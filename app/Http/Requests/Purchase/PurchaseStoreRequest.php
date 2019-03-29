<?php

namespace App\Http\Requests\Purchase;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseStoreRequest extends FormRequest
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
            'gym_id' =>'required|exists:gyms,id',
            'user_id' => 'required|exists:users,id',
            'package_id' => 'required|exists:packages,id',
            'card_no' => 'required|digits_between:14,16',
            'expiry_month' => 'required|digits:2',
            'expiry_year' => 'required|digits:4',
            'cvv' =>'required|digits:3',
        ];
    }
}
