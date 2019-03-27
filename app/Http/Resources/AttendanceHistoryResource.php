<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceHistoryResource extends JsonResource
{

    private $user_attendance;
    public function __construct($user_attendance){
        $this->user_attendance = $user_attendance;
    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        dd($this->user_attendance);
        return parent::toArray($request);
    }
}
