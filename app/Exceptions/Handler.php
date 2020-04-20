<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
     * @param  \Throwable  $exception
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
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if($exception instanceof AuthorizationException)
        {
            if($request->expectsJson())
            {
                return response()->json(
                    [
                        "status" =>false,
                        "message" =>trans('messages.you_are_not_authorized_to_access_this_resource'),
                        "errors"=>[
                            "message" =>trans('messages.you_are_not_authorized_to_access_this_resource'),
                        ]
                    ]
                    ,403
                );
            }
        }

        if($exception instanceof ModelNotFoundException && $request->expectsJson())
        {
                return response()->json(
                    [
                        "status" =>false,
                        "message" =>trans('messages.the_resource_was_not_found_in_database'),
                        "errors"=>[
                            "message" =>trans('messages.the_resource_was_not_found_in_database'),
                        ]
                    ]
                    ,404
                );

                
        }
        if($exception instanceof ModelNotDefind && $request->expectsJson())
        {
                return response()->json(
                    [
                        "status" =>false,
                        "message" =>trans('messages.model_not_defind'),
                        "errors"=>[
                            "message" =>trans('messages.model_not_defind'),
                        ]
                    ]
                    ,404
                );

                
        }

        
        return parent::render($request, $exception);
    }
}
