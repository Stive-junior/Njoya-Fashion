<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Exception;
use Illuminate\Support\Facades\Log;

/**
 * Contrôleur de base pour les fonctionnalités communes.
 *
 * Fournit une méthode de gestion des erreurs utilisée par les contrôleurs dérivés.
 *
 * @package App\Http\Controllers
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Gère les erreurs et retourne une réponse JSON ou une redirection.
     *
     * @param Request $request Requête HTTP
     * @param Exception $exception Exception capturée
     * @param string|array $message Message d'erreur ou erreurs de validation
     * @param int $status Code HTTP
     * @return JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function handleError(Request $request, Exception $exception, $defaultMessage, int $statusCode = 500, ?array $errors = null): JsonResponse|\Illuminate\Http\RedirectResponse
    {
        Log::error($defaultMessage . ': ' . $exception->getMessage());
        return $request->expectsJson()
            ? response()->json([
                'success' => false,
                'message' => $defaultMessage,
                'errors' => $errors ?? [$exception->getMessage()]
            ], $statusCode)
            : redirect()->back()->with('error', $defaultMessage);
    }
}
