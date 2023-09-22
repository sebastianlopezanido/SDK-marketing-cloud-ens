<?php

namespace App\Http\Resources\Responses;

use Illuminate\Http\Resources\Json\JsonResource;

class SuccessResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'error' => false,
            'data' => $this->resource->getData(),
            'httpCode' => $this->resource->getStatusCode(),
            'message' => $this->resource->getMessage()
        ];
    }
}
