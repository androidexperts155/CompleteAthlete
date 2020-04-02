<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $table = 'workout_chat';
	protected $appends = ['time_info'];
	
	public function getTimeInfoAttribute()
    {
    	return $this->updated_at->diffForHumans();
    }    

    public function getsenderuser()
   {
    return $this->hasOne('App\User', 'id', 'sender_id');
   }
   public function getreceiveruser()
   {
    return $this->hasOne('App\User', 'id', 'receiver_id');
   }

}
