<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PasswordResetService;
use Illuminate\Support\Facades\Validator;

class PasswordResetController extends Controller
{
    protected $passwordResetService;

    public function __construct(PasswordResetService $passwordResetService)
    {
        $this->passwordResetService = $passwordResetService;
    }

    /**
     * Afficher le formulaire de demande de réinitialisation
     */
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Envoyer le lien de réinitialisation
     */
    public function sendResetLinkEmail(Request $request)
    {
        // dd('controller');
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:employes,email',
        ], [
            'email.required' => 'L\'adresse e-mail est requise.',
            'email.email' => 'L\'adresse e-mail doit être valide.',
            'email.exists' => 'Aucun compte n\'est associé à cette adresse e-mail.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $result = $this->passwordResetService->sendResetLink($request->email);
        // dd($result['status']);
        if ($result['status'] === 'success') {
            return back()->with('toast_success', $result['message']);
        }

        return back()->with('toast_error', $result['message'])->withInput();
    }

    /**
     * Afficher le formulaire de réinitialisation
     */
    public function showResetForm(Request $request, string $token)
    {
        $email = $request->query('email');

        if (!$email) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Lien de réinitialisation invalide.']);
        }

        // Vérifier si le token est valide
        if (!$this->passwordResetService->isTokenValid($email, $token)) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Le lien de réinitialisation est invalide ou a expiré.']);
        }

        return view('auth.reset-password', compact('token', 'email'));
    }

    /**
     * Réinitialiser le mot de passe
     */
    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email|exists:employes,email',
            'password' => 'required|min:8|confirmed',
        ], [
            'token.required' => 'Token de réinitialisation requis.',
            'email.required' => 'L\'adresse e-mail est requise.',
            'email.email' => 'L\'adresse e-mail doit être valide.',
            'email.exists' => 'Aucun compte n\'est associé à cette adresse e-mail.',
            'password.required' => 'Le mot de passe est requis.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $result = $this->passwordResetService->resetPassword(
            $request->email,
            $request->token,
            $request->password
        );

        if ($result['status'] === 'success') {
            return redirect()->route('login')->with('status', $result['message']);
        }

        return back()->withErrors(['email' => $result['message']])->withInput();
    }
}
