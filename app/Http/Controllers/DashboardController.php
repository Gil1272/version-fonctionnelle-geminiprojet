<?php
namespace App\Http\Controllers;

use App\Models\Projet;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $totalProjects     = Projet::count();
        $ongoingProjects   = Projet::where('statut', 'in_progress')->count();
        $completedProjects = Projet::where('statut', 'completed')->count();
        $openProjects      = Projet::where('statut', 'in_progress')->with('taches')->get(); //, 'issues'

        return view('dashboard', [
            'totalProjects'     => $totalProjects,
            'ongoingProjects'   => $ongoingProjects,
            'completedProjects' => $completedProjects,
            'openProjects'      => $openProjects,
        ]);
    }

}
