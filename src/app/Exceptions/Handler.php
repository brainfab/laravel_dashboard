<?php namespace SmallTeam\Dashboard\App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler {

	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		'Symfony\Component\HttpKernel\Exception\HttpException'
	];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception  $e
	 * @return void
	 */
	public function report(Exception $e)
	{
		return parent::report($e);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Exception  $e
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $e)
	{
		return parent::render($request, $e);
	}

	/**
	 * Render the given HttpException.
	 *
	 * @param  \Symfony\Component\HttpKernel\Exception\HttpException  $e
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	protected function renderHttpException(\Symfony\Component\HttpKernel\Exception\HttpException $e)
	{
		if (view()->exists('dashboard::errors.'.$e->getStatusCode()))
		{
			return response()->view('dashboard::errors.'.$e->getStatusCode(), [], $e->getStatusCode());
		}
		else
		{
			return (new SymfonyDisplayer(config('app.debug')))->createResponse($e);
		}
	}

}
