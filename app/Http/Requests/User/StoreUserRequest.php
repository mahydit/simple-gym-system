<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            "name" => "required|string|max:255",
            "email" => "required|string|email|max:255|unique:users,email",
            // "gender" => "required",
            "password" => "required|string|min:8|max:255",
            "password_confirmation" => "required|string|min:8|max:255",
            // "date_of_birth" => "required",
            "profile_img" => "required|string",
        ];
    }
}
