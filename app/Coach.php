<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coach extends Model
{
    protected $fillable = [
        'name',
    ];

    public function session()
    {
        return $this->belongsToMany('App\Session');
    }
}
