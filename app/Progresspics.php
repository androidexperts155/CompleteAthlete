<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Progresspics extends Model
{
    protected $table = 'user_progress_pics';

    public function getuser()
   {
    return $this->hasOne('App\User', 'id', 'userid');
   }
}
