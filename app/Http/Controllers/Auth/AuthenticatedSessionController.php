<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Categories;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
         $categories = Categories::with(['children' => function($query) {
            $query->where('status', 1)->orderBy('order');
        }])
        ->whereNull('parent_id')
        ->where('status', 1)
        ->orderBy('order')
        ->get();

        return view('auth.login',compact('categories'));
    }

    /**
     * Handle an incoming authentication request.
     */
public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Redirection en fonction du rôle de l'utilisateur
        
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->hasRole('manager')) {
            return redirect()->route('manager.dashboard');
        } elseif ($user->hasRole('livreur')) {
            
            if (session('cart')) {
        return redirect()->route('checkout')
            ->with('info', 'Connecté avec succès! Veuillez vérifier votre panier.');
    }
            return redirect()->route('livreur.dashboard');
        } elseif ($user->hasRole('client')) {
            return redirect()->route('home');
        }

      
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

}
