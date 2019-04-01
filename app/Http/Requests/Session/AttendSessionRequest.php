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
        $today_time = Carbon::now()->toTimeString();
        return [
            "session_date"  => "date_format:Y-m-d|date_equals:today",
            "remain_sessions" => "gt:0",
            // "starts_at" => "date_format:H:i:s|before_or_equal:".$today_time,
            // "ends_at" => "date_format:H:i:s|after_or_equal:".$today_time,
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'session_date' => $this->route('session')->session_date,
            'remain_sessions' => Auth::user()->role->remain_sessions,
            // 'starts_at' => $this->route('session')->starts_at,
            // 'ends_at' => $this->route('session')->ends_at,
        ]);
    }

    public function messages(){

        return [

            'remain_sessions.gt' => "You Have No Remaining Sessions Left Please Buy A Session in Order To Attend",
            'session_date.date_equals' => 'The Session is not Today Please Pick the right session',
            'starts_at.before_or_equal' => "The Session Hasn't Started Yet",
            'ends_at.after_or_equal' => "The Session Has Ended",
        ];
    }
}
