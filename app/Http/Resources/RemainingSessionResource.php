<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RemainingSessionResource extends JsonResource
{
    private $user;
    private $total_sessions;
    public function __construct($user , $total_sessions)
    {
        $this->user = $user;
        $this->total_sessions = $total_sessions;
    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "total_sessions" => $this->total_sessions,
            "remaining_sessions" => $this->user->role->remain_sessions,

        ];
    }
}
