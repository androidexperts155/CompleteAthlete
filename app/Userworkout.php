<?php

namespace App;
use App\Category;

use Illuminate\Database\Eloquent\Model;

class Userworkout extends Model
{
    protected $table = 'user_workout';
    protected $appends = ['category_name'] ;

    public function getCategoryNameAttribute()
    {
    	$catname = Category::where('id',$this->categoryid)->value('name');
    	return $catname;
    } 
    
   
}
