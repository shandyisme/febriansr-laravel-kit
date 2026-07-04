<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Restrict access to users that hold at least one of the given roles.
 *
 * Usage: ->middleware('role:admin,manajer')
 */
class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        abort_unless(
            auth()->check() && auth()->user()->hasRole($roles),
            403
        );

        return $next($request);
    }
}
