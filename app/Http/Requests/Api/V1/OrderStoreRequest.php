<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class OrderStoreRequest extends FormRequest
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
            'domain_id' => 'required|exists:App\Models\Domain,id',
            // 'lead_id' => 'required|exists:App\Models\Lead,id',
            // 'instructions' => 'required',
            // 'topic' => 'required',
            'price_plan_type_of_work_id' => 'required|exists:App\Models\PricePlanTypeOfWork,id',
            'price_plan_level_id' => 'required|exists:App\Models\PricePlanLevel,id',
            'price_plan_urgency_id' => 'required|exists:App\Models\PricePlanUrgency,id',
            'price_plan_no_of_page_id' => 'required|exists:App\Models\PricePlanNoOfPage,id',
            // 'price_plan_indentation_id' => 'required|exists:App\Models\PricePlanIndentation',
            // 'price_plan_subject_id' => 'required|exists:App\Models\PricePlanSubject',
            // 'price_plan_style_id' => 'required|exists:App\Models\PricePlanStyle',
            // 'price_plan_language_id' => 'required|exists:App\Models\PricePlanLanguage',
            'total_amount' => 'required',
            // 'manual_discount_amount' => 'required',
            // 'discount_amount' => 'required',
            'grand_total_amount' => 'required',
        ];
    }
}
