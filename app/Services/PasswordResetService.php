<?php

namespace App\Services;

use App\Models\Employe;
use App\Models\PasswordResetToken;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Log;

class PasswordResetService
{
    /**
     * Envoyer un lien de réinitialisation de mot de passe
     */
    public function sendResetLink(string $email): array
    {
        $user = Employe::where('email', $email)->first();
        // dd('test1');
        if (!$user) {
            return [
                'status' => 'error',
                'message' => 'Aucun utilisateur trouvé avec cette adresse e-mail.'
            ];
        }

        // Créer le token
        $token = PasswordResetToken::createToken($email);

        // Envoyer l'email
        Log::info('Tentative d\'envoi du mail de reset', ['email' => $email]);
        // dd('test');
        try {
            Mail::to($email)->send(new ResetPasswordMail($token, $email));
            Log::info('Mail de reset envoyé avec succès', ['email' => $email]);

            return [
                'status' => 'success',
                'message' => 'Un lien de réinitialisation a été envoyé à votre adresse e-mail.'
            ];
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'envoi du mail de reset', [
                'email' => $email,
                'error' => $e->getMessage()
            ]);
            return [
                'status' => 'error',
                'message' => 'Erreur lors de l\'envoi de l\'e-mail. Veuillez réessayer.'
            ];
        }
    }

    /**
     * Réinitialiser le mot de passe
     */
    public function resetPassword(string $email, string $token, string $password): array
    {
        // Vérifier si le token est valide
        if (!PasswordResetToken::isValidToken($email, $token)) {
            return [
                'status' => 'error',
                'message' => 'Le lien de réinitialisation est invalide ou a expiré.'
            ];
        }

        // Trouver l'utilisateur
        $user = Employe::where('email', $email)->first();

        if (!$user) {
            return [
                'status' => 'error',
                'message' => 'Utilisateur non trouvé.'
            ];
        }

        // Mettre à jour le mot de passe
        $user->password = Hash::make($password);
        $user->save();

        // Supprimer le token
        PasswordResetToken::deleteToken($email);

        return [
            'status' => 'success',
            'message' => 'Votre mot de passe a été réinitialisé avec succès.'
        ];
    }

    /**
     * Vérifier si un token est valide
     */
    public function isTokenValid(string $email, string $token): bool
    {
        return PasswordResetToken::isValidToken($email, $token);
    }
}
