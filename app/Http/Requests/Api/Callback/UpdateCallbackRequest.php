<?php

namespace App\Http\Requests\Api\Callback;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCallbackRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            '*.callbackId' => ['required', 'string'],
            '*.callbackName' => ['required', 'string'],
            '*.maxBatchSize' => ['nullable', 'numeric', 'min:100','max:1000']
        ];
    }
}
