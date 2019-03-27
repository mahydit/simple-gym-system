<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{

    private $user;
    private $token;

    public function __construct($user , $token){
        $this->user = $user;
        $this->token = $token;
        
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
            "id" => $this->user[0]->id,
            "name" => $this->user[0]->name,
            "email" => $this->user[0]->email,
            "password" => $this->user[0]->password,
            "profile_img" => $this->user[0]->profile_img,
            "role_type" => $this->user[0]->role_type,
            "gender" => $this->user[0]->role->gender,
            "birth_date" => $this->user[0]->role->birth_date,
            "remain_sessions" => $this->user[0]->role->remain_sessions,
            "access_token" => $this->token,
        ];
    }
}
