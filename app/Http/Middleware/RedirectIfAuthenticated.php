<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                
                /** @var \App\Models\User $user */
                $user = Auth::user();
                if ($user->hasRole('manager')) {
                    return redirect()->route('manager.dashboard');
                } elseif ($user->hasRole('livreur')) {
                    return redirect()->route('livreur.dashboard');
                } elseif ($user->hasRole('client')) {
                    return redirect()->route('home');
                }
                
                return redirect()->route('home');
            }

            
        }

        return $next($request);
    }
}
