<?php

namespace App\Http\Requests\CityManager;

use Illuminate\Foundation\Http\FormRequest;

class StoreCityManagerRequest extends FormRequest
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
        // dd($this->file());
        return [
            'name' => 'required|string',
            'email' => 'required|unique:users,email|email',
            'password' => 'required|min:6|integer|confirmed',
            'password_confirmation' => 'required|min:6|integer',
            'profile_img' => 'image|mimes:jpg,jpeg',
            'national_id' => 'required|unique:city_managers,SID|integer',
        ];
    }
}
