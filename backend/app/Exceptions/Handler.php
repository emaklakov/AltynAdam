<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Throwable;

class Handler extends ExceptionHandler
{
	/**
	 * A list of the exception types that are not reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		//
	];

	/**
	 * A list of the inputs that are never flashed for validation exceptions.
	 *
	 * @var array
	 */
	protected $dontFlash = [
		'password',
		'password_confirmation',
	];

	/**
	 * Report or log an exception.
	 *
	 * @param \Throwable $exception
	 *
	 * @return void
	 *
	 * @throws \Exception
	 */
	public function report(Throwable $exception)
	{
		parent::report($exception);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \Throwable               $exception
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 *
	 * @throws \Throwable
	 */
	public function render($request, Throwable $exception)
	{
		//dd($exception);

		if ($exception instanceof CustomException) {
			return $exception->render($request, $exception);
		}

		if ($exception instanceof AuthenticationException) {
			return response()->json([
										'message' => 'Requires authentication' // При пустом токине
									], 401);
		}

		if ($exception instanceof AccessDeniedHttpException) {
			return response()->json([
										'message' => $exception->getMessage(),
									], 401);
		}

		if ($exception instanceof \Illuminate\Auth\Access\AuthorizationException) {
			return response()->json([
										'message' => 'Bad credentials' // При неправильном токине
									], 401);
		}

		if ($exception instanceof MethodNotAllowedHttpException) {
			return response()->json([
										'message' => $exception->getMessage(),
									], 400);
		}

		if ($exception instanceof ModelNotFoundException) {
			return response()->json([
										'message' => 'Not Found',
									], 404);
		}

		if ($exception instanceof NotFoundHttpException) {
			return response()->json([
										'message' => 'Not Found',
									], 404);
		}

		if ($exception instanceof RouteNotFoundException) {
			return response()->json([
										'message' => $exception->getMessage(),
									], 404);
		}

		if ($exception instanceof ValidationException) {
			return response()->json([
										'message' => $exception->getMessage(),
										'errors' => $exception->errors(),
									], 400);
		}

		if ($exception instanceof QueryException) {
			return response()->json([
										'message' => $exception->getMessage(),
									], 500);
		}

		if ($exception instanceof Exception) {
			return response()->json([
										'message' => $exception->getMessage(),
									], 400);
		}

		return parent::render($request, $exception);
	}
}
