<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
// use function auth;
// use function redirect;
// use function response;

class Authenticate {

    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null) {

        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return abort(403);
            } elseif (!$request->is("/")) {
                return redirect()->guest('login')->withErrors("Veuillez vous connecter pour accéder à cette partie du site.");
            }
        }
        return $next($request);

    }

}
