<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NoCache
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {

    try {

 
        /** @var Response $response */
        $response = $next($request);

        $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate, max-age=0');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', 'Thu, 01 Jan 1970 00:00:00 GMT');
        $response->headers->set('Last-Modified', gmdate('D, d M Y H:i:s') . ' GMT');



        return $response;
    } catch (\Throwable $e) {
        
        report($e);

        return response()->json([
            'error' => 'Une erreur est survenue.',
            'message' => $e->getMessage(),
        ], 500);
    }

    }
}
