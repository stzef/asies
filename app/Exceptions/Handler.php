<?php

namespace asies\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
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
        parent::report($e);
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

        //\Bican\Roles\Exceptions\RoleDeniedException
        //\Bican\Roles\Exceptions\PermissionDeniedException
        //\Bican\Roles\Exceptions\LevelDeniedException
        if (
            $e instanceof \Bican\Roles\Exceptions\RoleDeniedException ||
            $e instanceof \Bican\Roles\Exceptions\PermissionDeniedException ||
            $e instanceof \Bican\Roles\Exceptions\LevelDeniedException
        ) {
            $request->session()->flash('message', 'No tiene Persmisos para acceder a este lugar');
            return redirect()->back();
        }
        return parent::render($request, $e);
    }
}
