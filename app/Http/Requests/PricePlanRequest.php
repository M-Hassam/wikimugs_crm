<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PricePlanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'price' => 'required',
            'domain_id' => 'required',
            'price_plan_urgency_id' => 'required',
            'price_plan_level_id' => 'required',
            'price_plan_type_of_work_id' => 'required',
        ];
    }
}
