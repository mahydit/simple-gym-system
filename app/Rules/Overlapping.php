<?php

namespace App\Rules;

use App\Session;
use Illuminate\Contracts\Validation\Rule;

class Overlapping implements Rule
{
    private $start_time;
    private $end_time;
    private $date;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($starts_at,$ends_at,$date)
    {
        $this->start_time = date("H:i:s", strtotime($starts_at));
        $this->end_time= date("H:i:s", strtotime($ends_at));
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
        $sessions = Session::all()->where('session_date','=',$this->date);
        
        if($sessions)
        {
            foreach ($sessions as $session) {
               
                if(($this->start_time == $session->starts_at))
                {
                    return false;
                }
                if ($this->end_time == $session->ends_at)
                {
                    return false;
                }
                if($this->start_time > $session->start_time && $this->start_time <$session->ends_at )
                {
                    return false;
                }
                if($this->end_time > $session->starts_at && $this->end_time <$session->ends_at)
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
        return 'Session overlap. Please change the time.';
    }
}
