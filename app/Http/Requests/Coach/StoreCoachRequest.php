<?php

namespace App\Http\Requests\Coach;

use Illuminate\Foundation\Http\FormRequest;

class StoreCoachRequest extends FormRequest
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
            'name'=> 'min:3|required',
            'at_gym_id'=> 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'the name is required, please fill it',
            'at_gym_id.required' => 'you should choose a gym',
        ];
    }
}
