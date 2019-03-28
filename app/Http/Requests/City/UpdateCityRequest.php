<?php

namespace App\Http\Requests\City;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCityRequest extends FormRequest
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
            'name' => 'required|min:2'.$this->city->id,
            'city_manager_id' => 'required|min:3|exists:city_managers,id',
            'country_id' => 'required|exists:countries,id'
        ];
    }
}
