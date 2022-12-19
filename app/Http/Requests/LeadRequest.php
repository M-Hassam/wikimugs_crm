<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeadRequest extends FormRequest
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
            'domain_id'=>'required',
            'lead_status_id'=>'required',
            'name'=>'required',
            'email'=>'required',
            'phone'=>'required',
            // 'amount'=>'required',
        ];
    }
}
