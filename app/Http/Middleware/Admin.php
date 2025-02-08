<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::guard('admin')->user();
    
        if ($user) {
            // Vérifier si l'utilisateur a un rôle limité
            if ($user->role === 'normal') {
                // Liste des routes interdites aux admins avec rôle limité
                $restrictedRoutes = [
                    'admin.dashboard', 
                    'admin.fournisseur',
                    'fonds.index',
                    'clients.index',
                    'produits.index'
                ];
    
                if (in_array($request->route()->getName(), $restrictedRoutes)) {
                    return redirect()->route('admin.connexion')->with('error', 'Vous n\'avez pas l\'autorisation d\'accéder à cette page.');
                }
            }
    
            return $next($request);
        }
    
        return redirect()->route('admin.connexion');
    }
    
}