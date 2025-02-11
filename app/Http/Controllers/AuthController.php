<?php
namespace App\Http\Controllers;

use App\Models\Employe;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Vérifier si l'utilisateur est un ADMIN (User)
        if ($user = User::where('email', $request->email)->first()) {
            if (Hash::check($request->password, $user->password)) {
                Auth::guard('web')->login($user);
                session()->put('role', 'admin');
                return redirect()->route('dashboard'); // Redirige vers le dashboard Admin
            }
        }

        // Vérifier si l'utilisateur est un EMPLOYÉ (Employe)
        if ($employe = Employe::where('email', $request->email)->first()) {
            if (Hash::check($request->password, $employe->password)) {
                Auth::guard('employe')->login($employe); // Utiliser le guard 'employe'
                session()->put('employe', $employe);
                return redirect()->route('dashboard'); // Redirige vers le dashboard Employé
            }
        }

        throw ValidationException::withMessages([
            'email' => ['Les identifiants sont incorrects.'],
        ]);
    }

    public function logout(Request $request)
    {
        // Détermine quel guard est actuellement utilisé
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
            session()->forget('role');
        }

        if (Auth::guard('employe')->check()) {
            Auth::guard('employe')->logout();
            session()->forget('employe');
        }

        // Invalide la session
        $request->session()->invalidate();

        // Régénère le token CSRF
        $request->session()->regenerateToken();

        // Redirige vers la page de login
        return redirect()->route('login');
    }
}
