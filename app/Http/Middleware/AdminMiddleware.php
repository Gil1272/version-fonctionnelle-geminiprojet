<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        Log::info('Accès refusé pour l’utilisateur : ' . Auth::user()->id);
        abort(403, 'Accès non autorisé');
        return redirect('/')->with('error', 'Accès réservé aux administrateurs.');
    }
}
