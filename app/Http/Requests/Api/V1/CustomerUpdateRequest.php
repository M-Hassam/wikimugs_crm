<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CustomerUpdateRequest extends FormRequest
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

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'customer_id' =>"required|exists:customers,id",
            // "domain_id" => "required",
            "first_name" => "required",
            // "last_name" => "required",
            "email" => "required|email",
            "phone" => "required",
            // "is_email_notification" => "required",
            // "is_feedback_notification" => "required",
            // "is_promotion" => "required",
            // "password" => "required",
        ];
    }
}
