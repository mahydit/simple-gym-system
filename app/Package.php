<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Package extends Model
{
    use HasRoles;

    protected $fillable = [
        'name',
        'price',
        'no_sessions'
    ];
    protected $table = 'packages';

    public function getPriceAttribute($value)
    {
        return ($value/100);
    }


    public function setPriceAttribute($value)
    {
        $this->attributes['price']= ($value*100);
    }
}
