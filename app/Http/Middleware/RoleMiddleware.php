<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        $user = Auth::user();

        if (! $user) {
            return redirect('/login')->with('error', 'Vous devez être connecté.');
        }

        if ($role === 'admin' && ! $user instanceof \App\Models\User) {
            return redirect('/')->with('error', 'Accès réservé aux administrateurs.');
        }

        if ($role === 'employe' && ! $user instanceof \App\Models\Employe) {
            return redirect('/')->with('error', 'Accès réservé aux employés.');
        }

        return $next($request);
    }
}
