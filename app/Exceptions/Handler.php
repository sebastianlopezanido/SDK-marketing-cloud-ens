<?php

namespace App\Exceptions;

use App\Core\Controller\Traits\CommonResponse;
use App\Core\Controller\Traits\Error;
use App\Core\Controller\Traits\LaravelResource;
use App\Core\Controller\Traits\LaravelResponse;
use App\Core\Controller\Traits\Meta;
use App\Core\Controller\Traits\Response;
use App\Http\Resources\Responses\ExceptionResource;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    use CommonResponse, Error, LaravelResource, LaravelResponse, Meta, Response;

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
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        if (property_exists($this, 'resource')) {
            $this->resource = ExceptionResource::class;
        }

        return $this->setErrors($e->validator->errors()->all())->setStatusCode($e->status)->respondWithItem($e);
    }

    protected function prepareJsonResponse($request, Throwable $e)
    {
        return $this
            ->setStatusCode(
                $this->isHttpException($e) ? $e->getStatusCode() : 500)
            ->setHeaders(
                $this->isHttpException($e) ? $e->getHeaders() : [])
            ->setErrors((array)$e->getMessage())
            ->respondWithItem($e, ExceptionResource::class);
    }
}
