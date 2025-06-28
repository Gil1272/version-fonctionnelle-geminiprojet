<?php
namespace App\Http\Controllers;

use App\Models\Employe;
use App\Models\Projet;
use App\Models\Tache; // N'oubliez pas d'importer le modèle Employe
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TacheController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('taches.index');
    }

    public function create()
    {
        $employes = Employe::all();                                   // Récupérer tous les employés
        $projets  = Projet::all();                                    // Récupérer tous les projets
        return view('taches.create', compact('employes', 'projets')); // Passer les employés et projets à la vue
    }

    public function store(Request $request)
{
    $projet = Projet::findOrFail($request->projet_id);

    $employe = Auth::guard('employe')->user();  // superviseur potentiel
    $admin = Auth::guard('web')->user();        // admin potentiel

    // Condition : soit admin connecté, soit employé superviseur du projet
    if (!$admin && (!$employe || $employe->id !== $projet->employe_id)) {
        abort(403, 'Vous n\'êtes pas autorisé à assigner une tâche sur ce projet.');
    }

    // Validation des données
    $request->validate([
        'title'       => 'required|string|max:255',
        'description' => 'required|string',
        'start_date'  => 'required|date',
        'end_date'    => 'required|date|after:start_date',
        'projet_id'   => 'required|exists:projets,id',
        'employe_id'  => 'required|exists:employes,id',
    ]);

    // Création de la tâche
    Tache::create([
        'title'       => $request->title,
        'description' => $request->description,
        'start_date'  => $request->start_date,
        'end_date'    => $request->end_date,
        'status'      => 'pending', // Statut par défaut
        'projet_id'   => $request->projet_id,
        'employe_id'  => $request->employe_id,
    ]);

    return redirect()->back()->with('success', 'Tâche créée avec succès !');
}
}
