<?php
namespace App\Http\Controllers;

use App\Mail\NewEmployeeCredentials;
use App\Models\Employe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EmployeController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employes = Employe::all(); // Récupère tous les employés
        return view('employes.index', compact('employes'));
    }

    /**
     * Display a form to create a new project.
     */

    public function create()
    {
        return view('employes.create');
    }

    public function store(Request $request)
    {
        // Validation des données
        $validatedData = $request->validate([
            'nom'     => 'required',
            'prenom'  => 'required',
            'email'   => 'required|email|unique:employes',
            'poste'   => 'required',
            'contact' => 'required',
            'genre'   => 'required',
            'adresse' => 'required',
            'photo'   => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        DB::beginTransaction();

        try {
            // Gestion de l'upload de la photo
            if ($request->hasFile('photo')) {
                $photoPath              = $request->file('photo')->store('employes', 'public');
                $validatedData['photo'] = $photoPath;
            }

            // Génération et hachage du mot de passe
            $password                  = Str::random(8);
            $validatedData['password'] = Hash::make($password);

            // Création de l'employé avec log
            \Log::info('Tentative de création d\'employé avec les données:', $validatedData);

            $employee = Employe::create($validatedData);

            if (! $employee) {
                throw new \Exception('Échec de la création de l\'employé');
            }

            // Envoi du mail avec les identifiants
            Mail::to($employee->email)->send(new NewEmployeeCredentials($employee, $password));

            DB::commit();

            \Log::info('Employé créé avec succès. ID: ' . $employee->id);

            return redirect()->route('employes.index')->with('success', 'Employé créé avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('Erreur lors de la création de l\'employé: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la création: ' . $e->getMessage());
        }
    }

    // Afficher le formulaire de modification
    public function edit($id)
    {
        $employe = Employe::findOrFail($id);
        return view('employes.edit', compact('employe'));
    }

    // Mettre à jour les informations de l'employé
    public function update(Request $request, $id)
    {
        $request->validate([
            'nom'     => 'required|string|max:255',
            'prenom'  => 'required|string|max:255',
            'email'   => 'required|email|unique:employes,email,' . $id,
            'contact' => 'required|string|max:15',
            'poste'   => 'required|string',
            'genre'   => 'required|string',
            'adresse' => 'required|string|max:255',
            'photo'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $employe          = Employe::findOrFail($id);
        $employe->nom     = $request->nom;
        $employe->prenom  = $request->prenom;
        $employe->email   = $request->email;
        $employe->contact = $request->contact;
        $employe->poste   = $request->poste;
        $employe->genre   = $request->genre;
        $employe->adresse = $request->adresse;

        // Vérifier si une nouvelle photo a été téléchargée
        if ($request->hasFile('photo')) {
            // Supprimer l'ancienne photo si elle existe
            if ($employe->photo) {
                Storage::delete($employe->photo);
            }
            // Enregistrer la nouvelle photo
            $employe->photo = $request->file('photo')->store('photos');
        }

        $employe->save();

        return redirect()->route('employes.index')->with('success', 'Employé mis à jour avec succès.');
    }

    public function destroy(Employe $employe)
    {
        // Supprimer la photo si elle existe
        if ($employe->photo && Storage::disk('public')->exists($employe->photo)) {
            Storage::disk('public')->delete($employe->photo);
        }

        $employe->delete();

        return redirect()->route('employes.index')
            ->with('success', 'Employé supprimé avec succès');
    }
}
