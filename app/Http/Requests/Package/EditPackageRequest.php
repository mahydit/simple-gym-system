<?php

namespace App\Http\Requests\Package;

use Illuminate\Foundation\Http\FormRequest;

class EditPackageRequest extends FormRequest
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
            'name'=> 'min:3|required|unique:packages,name,'. $this->package['id'],
            'price'=>'required',
            'no_sessions'=>'required',
        ];
    }
}
