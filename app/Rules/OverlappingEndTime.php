<?php

namespace App\Rules;

use App\Session;
use Illuminate\Contracts\Validation\Rule;

class OverlappingEndTime implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($date)
    {
        $this->date=$date;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $value = date("H:i:s", strtotime($value));
        $sessions = Session::all()->where('session_date','=',$this->date);
        
        if($sessions)
        {
            foreach ($sessions as $session) {
               
                if(($value == $session->ends_at))
                {
                    return false;
                }
                
                if($value > $session->starts_at && $value <$session->ends_at )
                {
                    return false;
                }
                
            }
            return true;
        }
        else
        {
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Session end time overlaps another session.';
    }
}
