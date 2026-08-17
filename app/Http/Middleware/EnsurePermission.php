<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EnsurePermission
{
    /**
     * Handle an incoming request.
     * Usage: ->middleware(\App\Http\Middleware\EnsurePermission::class . ':permission.name')
     * Or register short name in Kernel and use 'permission:permission.name'
     */
    public function handle(Request $request, Closure $next, string $permission = null)
    {
        $user = $request->user();

        if (! $user) {
            return response()->json(['message' => 'Unauthenticated.'], Response::HTTP_UNAUTHORIZED);
        }

        if (! $permission) {
            return response()->json(['message' => 'Permission not specified.'], Response::HTTP_FORBIDDEN);
        }

        if (! $user->hasPermission($permission)) {
            return response()->json(['message' => 'Forbidden.'], Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
