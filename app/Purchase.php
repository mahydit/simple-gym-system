<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'client_id', 
        'gym_id', 
        'name', 
        'price',
        'purchase_date'
    ];
    
    protected $table = 'purchase_history';
    public $timestamps = false;

    public function gym(){

        return $this->belongsTo('App\Gym');

    }

   public function user(){

        return $this->belongsTo('App\User','client_id');

   }

}
