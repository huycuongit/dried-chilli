<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (PostTooLargeException $exception, $request) {
            $message = 'The upload is too large for this server. Reduce the upload size and try again.';
            if ($request->expectsJson()) {
                return response()->json(['message' => $message], 413);
            }
            return response()->view('errors.upload-too-large', ['message' => $message], 413);
        });
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
