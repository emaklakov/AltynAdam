<?php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
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
	public function handle($request, Closure $next, $role, $permission = null)
	{
		if(!auth()->user()->hasRole($role)) {
			return response()->json([
										'message' => 'Forbidden Error'
									], 403);
		}
		if($permission !== null && !auth()->user()->can($permission)) {
			return response()->json([
										'message' => 'Forbidden Error'
									], 403);
		}

		return $next($request);
	}
}
