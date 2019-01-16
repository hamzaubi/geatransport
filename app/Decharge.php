<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Decharge extends Model
{
    public function user(){

    	return $this->belongsTo(User::class, 'user_id');
    }

       public function vehicule(){

    	return $this->belongsTo(Vehicule::class, 'v_id');
    }
    public function scopeOut($query){

    	return $query->where('is_ristutue', '0')->orderBy('created_at','desc')->get();
    }
}
