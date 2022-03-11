<?php

namespace Sumra\SDK\Exceptions;

use Illuminate\Support\Arr;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Sumra\SDK\JsonApiResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

//use Illuminate\Auth\Access\AuthorizationException;
//use Illuminate\Database\Eloquent\ModelNotFoundException;
//use Illuminate\Validation\ValidationException;
//use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        // Comment it. We want to know about all errors
//        AuthorizationException::class,
//        HttpException::class,
//        ModelNotFoundException::class,
//        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
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

        $telegram = new Telegram($exception);
        $telegram->send();

        $mailer = new Mailer($exception);
        $mailer->send();
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable               $exception
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        return $this->prepareJsonResponse($request, $exception);
    }

    /**
     * @param            $request
     * @param \Throwable $e
     *
     * @return \Sumra\SDK\JsonApiResponse
     */
    protected function prepareJsonResponse($request, Throwable $e)
    {
        return new JsonApiResponse(
            $this->convertExceptionToArray($e),
            $this->isHttpException($e) ? $e->getStatusCode() : 500,
            $this->isHttpException($e) ? $e->getHeaders() : [],
            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
        );
    }

    /**
     * @param \Throwable $e
     *
     * @return \array[][]
     */
    protected function convertExceptionToArray(Throwable $e)
    {
        $statusCode = $this->isHttpException($e) ? $e->getStatusCode() : 500;
        $error = [
            'status' => $statusCode,
            'title' => isset(Response::$statusTexts[$statusCode]) ? Response::$statusTexts[$statusCode] : '',
            'message' => $this->getErrorMessage($e)
        ];

        if (env('APP_DEBUG', config('app.debug', false)) && false) {
            $error = array_merge($error, [
                'exception' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => collect($e->getTrace())->map(function ($trace) {
                    return Arr::except($trace, ['args']);
                })->all(),
            ]);
        }

        return [
            'errors' => [
                $error
            ]
        ];
    }

    /**
     * @param $exception
     *
     * @return string
     */
    private function getErrorMessage($exception)
    {
        return 'file ' . $exception->getFile() . ': ' . $exception->getMessage() . ' in line ' . $exception->getLine();
    }
}
