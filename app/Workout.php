<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class workout extends Model
{
   protected $table = 'workout'; 
    public function mylogresults(){
    	return $this->hasOne('App\Userworkout', 'workoutid', 'id');
	}
  public function getuser()
   {
    return $this->hasMany('App\Userworkout', 'workoutid', 'id');
   }
  
   public function comments()
   {
    return $this->hasMany('App\Workoutcomment', 'workoutid', 'id');
   }

}
