<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'created_at',
        'updated_at',
        'name',
        'price',
        'no_sessions'
    ];
    protected $table = 'packages';
    protected $dateFormat = 'U';
}
