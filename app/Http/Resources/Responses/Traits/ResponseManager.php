<?php

namespace App\Http\Resources\Responses\Traits;

use App\Core\Controller\Traits\CommonResponse;
use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Trait ResponseManager
 * @property \Exception|mixed $resource
 * @package App\Http\Resources\Traits
 */
trait ResponseManager
{
    use CommonResponse;

    protected static $_ROUTE_NOT_EXIST = 'validation.route_not_found';

    /**
     * @var Collection|array
     */
    protected $json_message = [];

    protected function getMessage()
    {
        if (strpos($this->resource->getMessage(), 'ORA')) {
            return $this->getOracleMessage();
        }
        if (empty(trim($this->resource->getMessage()))) {
            if ($this->resource instanceof NotFoundHttpException &&
                strpos($this->resource->getFile(), 'RouteCollection')) {
                return trans(self::$_ROUTE_NOT_EXIST);
            }
        }
        return $this->resource->getMessage();
    }

    protected function getErrors()
    {
        if ($this->json_message instanceof Collection) {
            return $this->json_message->filter(function ($value, $key) {
                return $key == 'Error Message';
            })->flatten()->map(function ($item, $key) {
                return $item;
            });
        }
        return $this->json_message;
    }

    protected function parseMessage()
    {
        $message = $this->resource->getMessage();
        $this->debug_message = $message;

        $this->parseOracleMessage($message);
    }

    protected function parseOracleMessage($message)
    {
        if (strpos($message, 'ORA')) {
            $this->json_message = $this->getDebugMessageArray();
        }
    }

    protected function getCode()
    {
        return $this->resource->status ??
            (method_exists($this->resource, 'getStatusCode') ?
                $this->resource->getStatusCode() : 500);
    }

    protected function isHttpException(\Exception $e)
    {
        return $e instanceof HttpExceptionInterface;
    }
}
