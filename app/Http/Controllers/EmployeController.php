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
use Illuminate\Support\Facades\Log;
class EmployeController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        \Log::info('Message flash :', session()->get('_flash')); // Contient les clés à flasher
        \Log::info('Success :', ['success' => session('success')]);
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
            $password                  = \Illuminate\Support\Str::random(8);
            $validatedData['password'] = \Illuminate\Support\Facades\Hash::make($password);

            $employee = Employe::create($validatedData);

            if (! $employee) {
                throw new \Exception('Échec de la création de l\'employé');
            }

            // Envoi du mail avec les identifiants
            \Illuminate\Support\Facades\Mail::to($employee->email)->send(new \App\Mail\NewEmployeeCredentials($employee, $password));

            DB::commit();

            // Retourner la vue avec le message de succès
            $employes = Employe::all();
            return view('employes.index', compact('employes'))->with('success', 'Employé créé avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();

            // Retourner la vue avec le message d'erreur
            $employes = Employe::all();
            return view('employes.index', compact('employes'))->with('error', 'Une erreur est survenue lors de la création: ' . $e->getMessage());
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

        if ($request->hasFile('photo')) {
            if ($employe->photo) {
                Storage::delete($employe->photo);
            }
            $employe->photo = $request->file('photo')->store('employes', 'public');
        }

        $employe->save();

        $employes = Employe::all();
        return view('employes.index', compact('employes'))->with('success', 'Employé mis à jour avec succès.');
    }

    public function destroy(Employe $employe)
    {
        if ($employe->photo && Storage::disk('public')->exists($employe->photo)) {
            Storage::disk('public')->delete($employe->photo);
        }

        $employe->delete();

        $employes = Employe::all();
        return view('employes.index', compact('employes'))->with('success', 'Employé supprimé avec succès');
    }
}
