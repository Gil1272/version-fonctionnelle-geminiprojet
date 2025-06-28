<?php
namespace App\Http\Controllers;

use App\Models\Employe;
use App\Models\Projet;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     * Récupérer tous les projets
     */
    public function index()
    {
        $projets = Projet::with(['taches.employee', 'superviseur', 'commentaires.commentable'])->get();


        // $projets = Projet::with(['superviseur', 'taches'])->get();
        return view('projets.index', compact('projets'));

    }

    /**
     * Display a form to create a new project.
     */

    public function create()
    {
        // Récupérer tous les employés
        $employes = Employe::all();
        return view('projets.create', compact('employes'));

    }

    /**
     * Store a newly created resource in storage.
     *  Méthode pour stocker un nouveau projet
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom'         => 'required|string|max:255',
            'description' => 'required|string',
            'date_debut'  => 'required|date',
            'date_fin'    => 'required|date|after_or_equal:date_debut',
            'statut'      => 'required|string',
            'type_projet' => 'required|string',
            'employe_id'  => 'required|exists:employes,id',
        ]);

        Projet::create($request->all());

        return redirect()->route('projets.index')->with('success', 'Projet créé avec succès.');
    }

    public function edit(Projet $projet)
{
    $employes = Employe::all();
    return view('projets.edit', compact('projet', 'employes'));
}


    /**
     * Display the specified resource.
     */
    public function show(Projet $projet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Projet $projet)
{
    $validated = $request->validate([
        'nom' => 'required|string|max:255',
        'description' => 'required|string',
        'date_debut' => 'required|date',
        'date_fin' => 'required|date|after_or_equal:date_debut',
        'type_projet' => 'required|string',
        'statut' => 'required|string',
        'employe_id' => 'required|exists:employes,id',
    ]);

    $projet->update($validated);

    return redirect()->route('projets.index')->with('success', 'Projet mis à jour avec succès.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Projet $projet)
    {
        //
    }
}
