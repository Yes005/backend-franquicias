<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$permissions): Response
    {
        /** @var $user App/Models/User */
        $user = auth()->user();

        if (!$user)
            throw new AccessDeniedHttpException('Necesitas estar autenticado para validar tus permisos');

        if (!$user->activo) {
            Auth::logout();
            return response()->json(['message' => 'El usuario está inactivo.', 'url' => '/login'], 302);
        }

        if (!$user->hasPermissions($permissions))
            throw new UnauthorizedException('No tienes permisos para realizar esta acción.');
        
        return $next($request);
    }
}
