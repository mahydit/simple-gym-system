<?php

namespace App\Http\Requests\Session;

use Illuminate\Foundation\Http\FormRequest;

class StoreSessionRequest extends FormRequest
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
            'name' => 'required|min:3',
            'starts_at' => 'required|', //TODO: validate time format
            'ends_at' => 'required|different:starts_at',
            'gym_id' => 'required|exists:gyms,id',
            'session_date' => 'required|date_format:Y-m-d',
            'coach_id'=>'required|exists:coaches,id',
        ];
    }

    // TODO: add customizer error msgs
}
