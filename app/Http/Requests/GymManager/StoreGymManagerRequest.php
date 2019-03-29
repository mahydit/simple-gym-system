<?php

namespace App\Http\Requests\GymManager;

use Illuminate\Foundation\Http\FormRequest;

class StoreGymManagerRequest extends FormRequest
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
            'name' => 'required|string',
            'email' => 'required|unique:users,email|email',
            'password' => 'required|min:6|integer|confirmed',
            'password_confirmation' => 'required|min:6|integer',
            'profile_img' => 'image|mimes:jpg,jpeg',
            'SID' => 'required|unique:gym_managers,SID|integer',
            'gym_id' => "required|exists:gyms,id",
        ];
    }
}
