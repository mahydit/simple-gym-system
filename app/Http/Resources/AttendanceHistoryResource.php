<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Session;

class AttendanceHistoryResource extends JsonResource
{


    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $session = Session::find($this->session_id); 
        return [
            "session_name" => $session->name,
            "gym_name" => $session->gym->name,
            "attendance_date" => $this->attendance_date,
            "attendance_time" => $this->attendance_time,
        ];
    }
}
