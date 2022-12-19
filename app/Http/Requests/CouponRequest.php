<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
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
            'coupon_type_id'=>'required',
            'status'=>'required',
            'discount'=>'required',
            'code'=>'required',
            'start_date'=>'required',
            'end_date'=>'required',
            'limit'=>'required',
            'per_user'=>'required',
        ];
    }
}
