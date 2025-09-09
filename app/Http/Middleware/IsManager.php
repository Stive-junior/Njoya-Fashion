<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsManager
{

    /** @var \App\Models\User $user */
    public $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }
    
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        
        if (Auth::check() && $this->user->hasRole('manager')) {
            return $next($request);
        }

        return redirect('login')->with('error', 'Accès réservé aux managers.');
    }
}
