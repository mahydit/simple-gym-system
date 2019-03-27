<?php

namespace App\Http\Requests\Session;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\User;

class AttendSessionRequest extends FormRequest
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
            "session_date"  => "date_format:Y-m-d|date_equals:today",
            "remain_sessions" => "gt:0",
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'session_date' => $this->route('session')->session_date,
            'remain_sessions' => Auth::user()->role->remain_sessions,
        ]);
    }

    public function messages(){

        return [

            'remain_sessions.gt' => "You Have No Remaining Sessions Left Please Buy A Session in Order To Attend",
        ];
    }
}
