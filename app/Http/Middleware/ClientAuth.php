<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClientAuth {
    public function handle(Request $request, Closure $next): Response {
        if (!session('client_id')) {
            $slug = $request->route('slug');
            return redirect()->route('boutique.connexion', $slug);
        }
        return $next($request);
    }
}