<?php

namespace App\Http\Requests\Session;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\OverlappingStartTime;
use App\Rules\OverlappingEndTime;

class UpdateSessionRequest extends FormRequest
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
            'session_date' => 'required|date_format:Y-m-d',
            'starts_at' => ['required',new OverlappingStartTime($this->session_date)],//TODO: validate time format
            'ends_at' => ['required','different:starts_at','after:starts_at',new OverlappingEndTime($this->session_date)],
        ];
    }
    
    // TODO: add customizer error msgs

}
