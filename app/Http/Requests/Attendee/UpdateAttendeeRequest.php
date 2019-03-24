<?php

namespace App\Http\Requests\Attendee;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAttendeeRequest extends FormRequest
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
            'name' => 'string|max:255',
            'gender' => 'in:male,female',
            'birth_date' => 'date_format:Y-m-d|before:2018-01-1|string',
        ];
    }
}
