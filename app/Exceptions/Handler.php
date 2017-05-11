<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Redirect;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        ModelNotFoundException::class,
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
        if ($e instanceof ModelNotFoundException) {
            $e = new NotFoundHttpException($e->getMessage(), $e);
        }

        if ($e instanceof TokenMismatchException){
            //redirect to form an example of how I handle mine
            return Redirect::back()->withErrors('Sorry, connection timeout. Please resubmit the form!')
                ->withInput();
        }

        //check the type of the exception you are interested at
        if ($e instanceof \Illuminate\Database\QueryException) {

            //do wathever you want, for example returining a specific view
            if ($e->getCode() == 23000) // Duplcate unique insert
            {
                return Redirect::back()->withErrors("Duplicate request!");
            }
        }

        if (!env('APP_DEBUG') && Auth::check()) {
            //return redirect()->route('errors.defaultError');
            return parent::render($request, $e);
        } else {
            return parent::render($request, $e);
        }
    }
}
