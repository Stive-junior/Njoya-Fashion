<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
      
        if (!Auth::check()) {
            return $this->redirectTo($request);
        }

        return $next($request);
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectTo(Request $request)
    {
        if (!$request->expectsJson()) {
           
            return redirect()->route('home')->with('error', 'Authentification requise. Veuillez vous connecter.');
            
        }
        return null;
    }
}