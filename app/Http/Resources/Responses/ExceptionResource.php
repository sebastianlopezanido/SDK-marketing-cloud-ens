<?php

namespace App\Http\Resources\Responses;

use App\Http\Resources\Responses\Traits\ResponseManager;
use Illuminate\Http\Resources\Json\JsonResource;

class ExceptionResource extends JsonResource
{
    use ResponseManager;

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $errors = [];

        if (property_exists($this->resource, 'validator')) {
            $errors = $this->resource->validator->errors()->toArray();
        }

        $class = explode("\\", get_class($this->resource));

        $this->parseMessage();

        return [
            'error' => true,
            'errors' => $errors,
            'errorType' => 'exception',
            'httpCode' => $this->getCode(),
            'message' => $this->getMessage(),
            'debug_message' => $this->when(config('app.debug'), $this->json_message),
            'exception' => array_pop($class),
            'file' => $this->when(config('app.debug'), $this->resource->getFile()),
            'line' => $this->when(config('app.debug'), $this->resource->getLine()),
            // 'trace' => $this->when(config('app.debug'), $this->resource->getTrace())
        ];
    }

}
