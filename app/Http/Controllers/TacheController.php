<?php
namespace App\Http\Controllers;

use App\Models\Employe;
use App\Models\Projet;
use App\Models\Tache; // N'oubliez pas d'importer le modèle Employe
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TacheController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $employe = auth()->user();

    // Récupérer les tâches de l'employé, avec les projets associés et trier par date_fin
    $tasks = Tache::where('employe_id', $employe->id)
                 ->with('projet')
                 ->orderBy('end_date', 'asc')
                 ->get();

    // Grouper les tâches par projet
    $tasksGroupedByProjet = $tasks->groupBy(function ($task) {
        return $task->projet->id;
    });

    return view('taches.index', [
        'tasksGroupedByProjet' => $tasksGroupedByProjet,
    ]);
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

public function update(Request $request, Tache $task)
{
    Log::info('user_id de la tâche : ' . $task->employe_id);
    Log::info('ID de l\'utilisateur connecté : ' . auth()->id());

    if ($task->employe_id !== auth()->id()) {
        abort(403);
    }

    $task->update(['status' => 'completed']);

    return redirect()->route('taches.index')->with('success', 'Tâche marquée comme terminée.');
}

}
