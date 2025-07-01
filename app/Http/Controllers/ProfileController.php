<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Afficher le formulaire de modification du profil
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    // Mettre à jour les informations personnelles
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nom'    => 'required|string|max:255',
            'prenom'    => 'required|string|max:255',
            'email'   => 'required|email|unique:users,email,' . $user->id,
            'contact'   => 'nullable|string|max:20',
            'adresse' => 'nullable|string|max:255',
            'photo'  => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->nom    = $request->nom;
        $user->prenom    = $request->prenom;
        $user->email   = $request->email;
        $user->contact   = $request->contact;
        $user->adresse = $request->adresse;

        // Gestion de l'avatar
        if ($request->hasFile('avatar')) {
            // Supprimer l'ancienne photo si elle existe
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }
            // Enregistrer la nouvelle photo
            $user->avatar = $request->file('photo')->store('photo', 'public');
        }

        // Log::info('Mise à jour du profil :', [
        //     'user_id' => $user->id,
        //     'nom' => $request->nom,
        //     'email' => $request->email,
        //     'phone' => $request->phone,
        //     'adresse' => $request->adresse,
        // ]);


        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profil mis à jour avec succès.');
    }

    // Mettre à jour le mot de passe
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password'      => 'required',
            'password'              => 'required|string|min:8|confirmed',
        ]);

        // Vérifier l'ancien mot de passe
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Mot de passe mis à jour avec succès.');
    }
}
