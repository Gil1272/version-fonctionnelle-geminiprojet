<?php

namespace App\Http\Controllers;
use App\Models\Projet;
use App\Models\Commentaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
class CommentaireController extends Controller
{
    public function store(Request $request, Projet $projet)
{
    $request->validate([
        'contenu' => 'required|string|max:1000',
    ]);

    $user = Auth::guard('web')->user();
    $employe = Auth::guard('employe')->user();

    $auteur = $user ?? $employe;

    if (!$auteur) {
        if ($request->ajax()) {
            return response()->json(['error' => 'Vous devez être connecté pour commenter.'], 401);
        }
        return back()->withErrors('Vous devez être connecté pour commenter.');
    }

    $projet->commentaires()->create([
        'contenu' => $request->contenu,
        'commentable_id' => $auteur->id,
        'commentable_type' => get_class($auteur),
    ]);

    if ($request->ajax()) {
        return response()->json(['success' => 'Commentaire ajouté.']);
    }

    return back()->with('success', 'Commentaire ajouté.');
}


}
