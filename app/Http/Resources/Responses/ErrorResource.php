<?php

namespace App\Http\Resources\Responses;

use App\Http\Resources\Responses\Traits\ResponseManager;
use Illuminate\Http\Resources\Json\JsonResource;

class ErrorResource extends JsonResource
{
    use ResponseManager;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $errors = $this->resource->getErrors();

        if (isset($errors['debug_message'])) {
            $this->debug_message = $errors['debug_message'];

            $this->parseOracleMessage($this->debug_message);
        }

        $data = $this->resource->getData();

        return [
            'error' => true,
            'errors' => $this->getErrors(),
            'data' => $data,
            'httpCode' => $this->getCode(),
            'message' => $this->resource->getMessage(),
        ];
    }

    protected function getErrors()
    {
        $errors = [];

        $errors['message'] = $this->getMessage();

        if (config('app.debug')) {
            $errors['debug_message'] = $this->debug_message;
        }


        return $errors;
    }
}
