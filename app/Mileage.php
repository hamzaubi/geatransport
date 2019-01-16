<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Mileage extends Model
{
    //test
   public function vehicule(){
   	return $this->belongsTo(Vehicule::class , 'id');
   }
}
