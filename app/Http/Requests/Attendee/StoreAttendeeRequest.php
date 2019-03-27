<?php

namespace App\Http\Requests\Attendee;

use Illuminate\Foundation\Http\FormRequest;

class StoreAttendeeRequest extends FormRequest
{
    /**
     * Determine if the Attendee is authorized to make this request.
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
            "gender" => "required|in:male,female",
            "password" => "required|string|min:8|max:255|confirmed",
            "password_confirmation" => "required|string|min:8|max:255",
            "birth_date" => "required|date_format:Y-m-d|before:2018-01-1|string",
            "profile_img" => "required|image|mimes:jpg,jpeg",
        ];
    }
}
