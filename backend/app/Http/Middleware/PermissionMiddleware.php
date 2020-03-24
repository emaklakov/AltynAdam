<?php

namespace App\Http\Middleware;

use Closure;

class PermissionMiddleware
{
	/**
	 * Handle an incoming request.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \Closure                 $next
	 * @param $role
	 * @param null $permission
	 *
	 * @return mixed
	 */
	public function handle($request, Closure $next, $permission)
	{
		if(!auth()->user()->can($permission)) {
			return response()->json([
										'message' => 'Forbidden Error'
									], 403);
		}

		return $next($request);
	}
}
