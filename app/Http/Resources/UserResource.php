<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "password" => $this->password,
            "profile_img" => $this->profile_img,
            "role_type" => $this->role_type,
            "gender" => $this->role->gender,
            "birth_date" => $this->role->birth_date,
            "remain_sessions" => $this->role->remain_sessions,
            "access_token" => $request->header('Authorization'),
        ];
    }
}
