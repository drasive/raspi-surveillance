<?php namespace RaspiSurveillance\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		// Disable CSRF check on the following routes
		$excludedRoutes = ['api/*'];
		
		foreach ($excludedRoutes as $excludedRoute) {
			if($request->is($excludedRoute)){
				return parent::addCookieToResponse($request, $next($request));
			}
		}
		
		// Check CSRF token
		return parent::handle($request, $next);
	}

}
