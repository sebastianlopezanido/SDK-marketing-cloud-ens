<?php

namespace App\Http\Requests\Api\Subscription;

use Illuminate\Foundation\Http\FormRequest;

class CreateSubscriptionRequest extends FormRequest
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
            '*.subscriptionName' => ['required', 'string'],
            '*.eventCategoryTypes' => ['required', 'array'],
            '*.eventCategoryTypes.*' => ['string'],
            '*.filters' => ['nullable', 'array'],
            '*.filters.*' => ['string']
        ];
    }
}
