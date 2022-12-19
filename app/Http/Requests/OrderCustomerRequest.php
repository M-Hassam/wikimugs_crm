<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderCustomerRequest extends FormRequest
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
            'domain_id'=>'required',
            'topic'=>'required',
            // 'lead_id'=>'required',
            // 'customer_id'=>'required',
            'price_plan_type_of_work_id'=>'required',
            'price_plan_level_id'=>'required',
            'price_plan_urgency_id'=>'required',
            'price_plan_no_of_page_id'=>'required',
            // 'price_plan_indentation_id'=>'required',
            'price_plan_subject_id'=>'required',
            'price_plan_style_id'=>'required',
            // 'price_plan_language_id'=>'required',
            'total_amount'=>'required',
            'grand_total_amount'=>'required',
            'name'=>'required',
            'phone'=>'required',
            'email'=>'required'
        ];
    }
}
