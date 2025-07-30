<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{

     /**
     * Verifica se l'utente autenticato è un admin.
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        // Accesso negato: reindirizza o mostra errore
        abort(403, 'Accesso negato - Solo gli amministratori possono accedere.');
    }
    
}