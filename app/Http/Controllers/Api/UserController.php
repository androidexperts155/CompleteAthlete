<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Auth;
use Log;
use DB;
use Pagination;
use App\User;
use App\Userworkout;
use App\Workout;
use App\Category;
use App\Workoutlike;
use App\Workoutcomment;
use App\Chat;
use App\Commentlike;
use Carbon\Carbon;
use App\Notification;
use App\Video;
use App\Usergoal;
use App\Userdiet;
use App\Userdietweb;
use App\Progresspics;
use URL;
use Mail;
use Hash;
use App\Mail\ResetPassword;
use App\Mail\ChangePassword;
use App\Mail\VerifyUser;
use App\Mail\HelpEmail;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;


class Usercontroller extends Controller
{

  /*public function test11(Request $request)
  {

  if (Hash::check('123456', '$2y$10$bN66ugLSB9I8Fycd5RyqAuHuAfzhy7xreECI7.p1rnilaRdP0VHmS')) {
    return 1;
    
  }
  else
  {
    return 2;
  }
  }*/
	public function login(Request $request)
 	{
    try {
      $rules = [    			    			
  			'email'=> 'required|email',    			
  			'password' => 'required'    			
  		];
      $validator = Validator::make($request->all(), $rules);

      if($validator->fails())
      {
        return response()->json([
         "message" => "Something went wrong!",
         "success"=>FALSE,
         'errors' => $validator->errors()
        ],422);
      }
      if(Auth::attempt(['email' => $request->get('email') , 'password' => $request->get('password')])){
        $user = Auth::user();
        $token = $user->createToken($user->id. ' token ')->accessToken;
        $coach_id = Auth::user()->coach_id;
        $userid = Auth::user()->id;
        
        $result['message'] = 'Login successful.';
        $result['access_token'] = $token;
        $result['user'] = $user;
        $user->coach_details = User::select('id','name','email','phone','role','created_at','updated_at','image','gender','state','city','country','zipcode','bio')->where('id',$coach_id)->first();
        $result['success'] = TRUE;
    	}
    	else{
        return response()->json([
        "message" => "Please enter correct email or password",
        "success"=>FALSE ]
        );                   
    	}
    } 
    catch (\Exception $e) {
      $result = [
        'message'=> $e->getMessage(). ' Line No '. $e->getLine() . ' In File'. $e->getFile()
      ];
      Log::error($e->getTraceAsString());
      $result['success'] = FALSE;
  	}       
    return $result;
 	}   

 	public function allworkouts(Request $request) 
 	{
    
 		$userid = Auth::id();
    
 		try{
			$rules = [
  		'date'=> 'required'    
  		];
      $validator = Validator::make($request->all(), $rules);

      if($validator->fails())
      {
        return response()->json([
         "message" => "Something went wrong!",
          "success"=>FALSE,
         'errors' => $validator->errors()->toArray(),
       ], 422);               
      }
      $arr = array();
	    $allworkouts = Workout::with(array("mylogresults" => 
        function($query) use ($userid){
        $query->select()->where('userid',$userid);
      }))
      ->whereDate('workout_date', '=', $request->date)->where('category',0)->get();

       $allpersonalworkouts = Workout::with(array("mylogresults" => 
        function($query) use ($userid){
        $query->select()->where('userid',$userid);
      }))
      ->whereDate('workout_date', '=', $request->date)->where('category',1)->where('assigned_to',$userid)->get();

      $Games_Prep = Workout::with(array("mylogresults" => 
        function($query) use ($userid){
        $query->select()->where('userid',$userid);
      }))
      ->whereDate('workout_date', '=', $request->date)->where('category',2)->where('assigned_to',$userid)->get();

      $Complete_60 = Workout::with(array("mylogresults" => 
        function($query) use ($userid){
        $query->select()->where('userid',$userid);
      }))
      ->whereDate('workout_date', '=', $request->date)->where('category',3)->where('assigned_to',$userid)->get();


      $Sweat_Session = Workout::with(array("mylogresults" => 
        function($query) use ($userid){
        $query->select()->where('userid',$userid);
      }))
      ->whereDate('workout_date', '=', $request->date)->where('category',4)->where('assigned_to',$userid)->get();

      $Weightlifting = Workout::with(array("mylogresults" => 
        function($query) use ($userid){
        $query->select()->where('userid',$userid);
      }))
      ->whereDate('workout_date', '=', $request->date)->where('category',5)->where('assigned_to',$userid)->get();



       $videoexists = Video::whereDate('created_at','=',$request->date)->first();

       if($videoexists)
       {
          //$path = public_path('/videos');
          $result['video'] = URL::to('/').'/workouts/'.$videoexists['video'];
          $result['thumbnail'] = URL::to('/').'/thumbnails/'.$videoexists['thumbnail'];
       }
       else
       {
          $result['video'] = "";
           $result['thumbnail'] = "";
       }
      foreach($allworkouts as $mylog){   
        if($mylog->mylogresults)
        {
          $mylog->has_logresults = TRUE;      
        }
       else
       {
         $mylog->has_logresults = FALSE;      
        }
      }

      foreach($allpersonalworkouts as $mylog){   
        if($mylog->mylogresults)
        {
          $mylog->has_logresults = TRUE;      
        }
       else
       {
         $mylog->has_logresults = FALSE;      
        }
      }
      foreach($Games_Prep as $mylog){   
        if($mylog->mylogresults)
        {
          $mylog->has_logresults = TRUE;      
        }
       else
       {
         $mylog->has_logresults = FALSE;      
        }
      }
      foreach($Complete_60 as $mylog){   
        if($mylog->mylogresults)
        {
          $mylog->has_logresults = TRUE;      
        }
       else
       {
         $mylog->has_logresults = FALSE;      
        }
      }
       foreach($Sweat_Session as $mylog){   
        if($mylog->mylogresults)
        {
          $mylog->has_logresults = TRUE;      
        }
       else
       {
         $mylog->has_logresults = FALSE;      
        }
      }
      foreach($Weightlifting as $mylog){   
        if($mylog->mylogresults)
        {
          $mylog->has_logresults = TRUE;      
        }
       else
       {
         $mylog->has_logresults = FALSE;      
        }
      }
   		if(count($allworkouts)>0 ||count($allpersonalworkouts)>0||count($Games_Prep)>0 ||count($Complete_60)>0||count($Sweat_Session)>0||count($Weightlifting)>0)
   		{
   			$result['allworkouts'] = $allworkouts;
        $result['allpersonalworkouts'] = $allpersonalworkouts;
        $result['Games_Prep'] = $Games_Prep;
        $result['Complete_60'] = $Complete_60;
        $result['Sweat_Session'] = $Sweat_Session;
        $result['Weightlifting'] = $Weightlifting;
   			$result['success'] = TRUE;
   			$result['message'] = "Successfully found";     
   		}
   		else
   		{
        $result['allworkouts'] = array();
        $result['allpersonalworkouts'] = array();
        $result['Games_Prep'] =  array();
        $result['Complete_60'] =  array();
        $result['Sweat_Session'] =  array();
        $result['Weightlifting'] =  array();
   			$result['success'] = TRUE;
   			$result['message'] = "No Workout found";
   		}
	  }
	 	catch (\Exception $e) {
      $result = [
        'message'=> $e->getMessage(). ' Line No '. $e->getLine() . ' In File'. $e->getFile()
      ];
      Log::error($e->getTraceAsString());
      $result['success'] = FALSE;
   	}    
   	return $result;	
 	}

 	public function mylog(Request $request) 
 	{
 		$userid = Auth::id();
 		try {
      $rules = [  
        'workoutid' => 'required',	         	
  			'categoryid' => 'required',       
        'date_created'=>'required',
        'notes' =>'required'
  		];
      $validator = Validator::make($request->all(), $rules);
      if($validator->fails())
      {
        return response()->json([
          "message" => "Something went wrong!",
          "success"=>FALSE,
          'errors' => $validator->errors()->toArray(),
       ], 422);               
      }
      $scoring_type = Workout::where('id',$request->workoutid)->value('scoring_type');
      if($scoring_type==1)
      {
          $rules = [  
          'minutes'=> 'required',
          'seconds'=> 'required'
        ];
      }
      else if($scoring_type==2)
      {
          $rules = [  
          'rounds'=> 'required',
          'reps'=> 'required'
        ];
      }
      else if($scoring_type==3)
      {
          $rules = [  
          'reps'=> 'required'
        ];        
      }
      else if($scoring_type==4)
      {
        $rules = [  
          'meters'=> 'required'
        ];
      }
      else if($scoring_type==5)
      {
          $rules = [  
          'lbs'=> 'required'
        ];         
      }
      else if($scoring_type==6)
      {
          $rules = [  
          'calories'=> 'required'
        ];         
      }
      $validator = Validator::make($request->all(), $rules);
      if($validator->fails())
      {
        return response()->json([
          "message" => "Something went wrong!",
          "success"=>FALSE,
          'errors' => $validator->errors()->toArray(),
       ], 422);               
      }

      $status = 0;
      $userdata = Userworkout::where('userid',$userid)->where('workoutid',$request->workoutid)->count();
       $image = User::where('id',$userid)->value('image');
       $name = User::where('id',$userid)->value('name');

      
      if($userdata >0)
      {
        if($scoring_type==1)
          {
            Userworkout::where('userid',$userid)->where('workoutid',$request->workoutid)->update(['userid'=>$userid,'categoryid'=>$request->categoryid,'workoutid'=>$request->workoutid,'minutes'=>$request->minutes,'seconds'=>$request->seconds,'date_created'=>$request->date_created,'notes'=> $request->notes,'scoring_type'=>$scoring_type]);
          }
        if($scoring_type==2)
        {
          Userworkout::where('userid',$userid)->where('workoutid',$request->workoutid)->update(['userid'=>$userid,'categoryid'=>$request->categoryid,'workoutid'=>$request->workoutid,'rounds'=>$request->rounds,'reps'=>$request->reps,'date_created'=>$request->date_created,'notes'=> $request->notes,'scoring_type'=>$scoring_type]);
        }
        if($scoring_type==3)
        {
          Userworkout::where('userid',$userid)->where('workoutid',$request->workoutid)->update(['userid'=>$userid,'categoryid'=>$request->categoryid,'workoutid'=>$request->workoutid,'reps'=>$request->reps,'date_created'=>$request->date_created,'notes'=> $request->notes,'scoring_type'=>$scoring_type]);
          }

        if($scoring_type==4)
        {
          Userworkout::where('userid',$userid)->where('workoutid',$request->workoutid)->update(['userid'=>$userid,'categoryid'=>$request->categoryid,'workoutid'=>$request->workoutid,'meters'=>$request->meters,'date_created'=>$request->date_created,'notes'=> $request->notes,'scoring_type'=>$scoring_type]);
        }
        if($scoring_type==5)
          {
            Userworkout::where('userid',$userid)->where('workoutid',$request->workoutid)->update(['userid'=>$userid,'categoryid'=>$request->categoryid,'workoutid'=>$request->workoutid,'lbs'=>$request->lbs,'date_created'=>$request->date_created,'notes'=> $request->notes,'scoring_type'=>$scoring_type]);
          }
        if($scoring_type==6)
        {
          Userworkout::where('userid',$userid)->where('workoutid',$request->workoutid)->update(['userid'=>$userid,'categoryid'=>$request->categoryid,'workoutid'=>$request->workoutid,'calories'=>$request->calories,'date_created'=>$request->date_created,'notes'=> $request->notes,'scoring_type'=>$scoring_type]);
        }
        $status = 1;
        $msg = "updated";
      }
      else{
       $wrkout =  new Userworkout;      
       $wrkout->userid = $userid;
       $wrkout->categoryid = $request->categoryid;
       $wrkout->workoutid = $request->workoutid;
        if($scoring_type==1)
        {
         $wrkout->minutes = $request->minutes;
         $wrkout->seconds = $request->seconds;
        }
        if($scoring_type==2)
        {
         $wrkout->rounds = $request->rounds;
         $wrkout->reps = $request->reps;
        }
        if($scoring_type==3)
        {
          $wrkout->reps = $request->reps;
        }
        if($scoring_type==4)
        {
         $wrkout->meters = $request->meters;
         
        }
        if($scoring_type==5)
        {
         $wrkout->lbs = $request->lbs;
        
        }
        if($scoring_type==6)
        {
         $wrkout->calories = $request->calories;
         
        }
       $wrkout->date_created = $request->date_created;
       $wrkout->notes = $request->notes;
       $wrkout->scoring_type = $scoring_type;
       $wrkout->image = $image;
       $wrkout->username = $name;
       $wrkout->save();
       $status = 2;
       $msg = "added";
     }
      if($status ==2){
        Workout::where('id',$request->workoutid)->increment('results');
        User::where('id',$userid)->increment('points');
      }
       if($status ==1 || $status ==2)
       {
       	$myworkout = Userworkout::where('workoutid',$request->workoutid)->where('userid',$userid)->first();
        $myworkout->points = User::where('id',$userid)->value('points');
       	
       	$result['myworkout'] = $myworkout;
       	$result['success'] = TRUE;
       	$result['message'] = "Workout Statistics ".$msg;
       }
       else
       {
       	$result['success'] = TRUE;
       	$result['message'] = "Workout Statistics not " .$msg;
       }
      return $result;
 		}
 		catch (\Exception $e) {
      $result = [
        'message'=> $e->getMessage(). ' Line No '. $e->getLine() . ' In File'. $e->getFile()
      ];
      Log::error($e->getTraceAsString());
      $result['success'] = FALSE;
   	} 
   	return $result;
 	}	 

  public function allcategories()
  {
    try{
      $allcat = Category::all();
      if(count($allcat)>0)
      {
        $result['allcategories'] = $allcat;
        $result['success'] = TRUE;
        $result['message'] = "Successfully found";
      }
      else
      {
        $result['allcategories'] = array();
        $result['success'] = TRUE;
        $result['message'] = "Not found";
      }
    }
    catch (\Exception $e) {
      $result = [
          'message'=> $e->getMessage(). ' Line No '. $e->getLine() . ' In File'. $e->getFile()
      ];
      Log::error($e->getTraceAsString());
      $result['success'] = FALSE;
      } 
    return $result;
  }

  public function allresultdata(Request $request) 
  {
    $userid = Auth::id();
    try{
     $rules = [
        'workoutid'=> 'required'    
      ];
      $validator = Validator::make($request->all(), $rules);

      if($validator->fails())
      {
        return response()->json([
         "message" => "Something went wrong!",
          "success"=>FALSE,
         'errors' => $validator->errors()->toArray(),
        ], 422);               
      }
     $scoring = Workout::where('id',$request->workoutid)->value('scoring_type');
     if($scoring==1){
      $field = 'minutes';
      $sort = 'asc';
     }
     if($scoring==2){
      $field = 'rounds';
      $sort = 'desc';
     }
     if($scoring==3){
      $field = 'reps';
      $sort = 'desc';
     }
     if($scoring==4){
      $field = 'meters';
      $sort = 'desc';
     }
     if($scoring==5){
      $field = 'lbs';
      $sort = 'desc';
     }
     if($scoring==6){
      $field = 'calories';
      $sort = 'desc';
     }

     $allworkouts = Workout::with(array("getuser" => 
        function($query) use ($field,$sort){
        $query->orderby($field,$sort);
      }))->where('id',$request->workoutid)->first();
    
     foreach($allworkouts['getuser'] as $data)
     {
      $worklike = Workoutlike::where('workoutid',$data->workoutid)->where('userid',$data->userid)->where('likebyuserid',$userid)->first();
      $gender = User::where('id',$data->userid)->value('gender');
      $likes = Workoutlike::where('workoutid',$request->workoutid)->where('userid',$data['userid'])->count();
      $comments = Workoutcomment::where('workoutid',$request->workoutid)->where('userid',$data['userid'])->count();
      if($worklike)
      {
        $data->is_myliked = TRUE;          
      }
      else
      {
        $data->is_myliked = FALSE;        
      }
      $data->gender =  $gender;
      $data->likes = $likes;
      $data->comments = $comments;
     }
   
      $allikes = Workoutlike::where('workoutid',$request->workoutid)->count();
      $allcomments = Workoutcomment::where('workoutid',$request->workoutid)->count();        
      $allworkouts->likes_count = $allikes;
      $allworkouts->comments_count = $allcomments;
          
      if($allworkouts)
      {
        $result['allworkouts'] = $allworkouts;
        $result['success'] = TRUE;
        $result['message'] = "Successfully found";       
      }
      else
      {
        $result['allworkouts'] = array();
        $result['success'] = TRUE;
        $result['message'] = "No Workout found";
      }
    }
    catch (\Exception $e) {
      $result = [
          'message'=> $e->getMessage(). ' Line No '. $e->getLine() . ' In File'. $e->getFile()
      ];
      Log::error($e->getTraceAsString());
      $result['success'] = FALSE;
      }    
    return $result; 
  }

  public function likeworkout(Request $request)
  {
    $userid = Auth::id();
    $username = User::where('id',$userid)->value('name');

    try{
     $rules = [
        'workoutid'=> 'required',
        'userlikeid'  =>'required' 
      ];
      $validator = Validator::make($request->all(), $rules);

      if($validator->fails())
      {
        return response()->json([
         "message" => "Something went wrong!",
          "success"=>FALSE,
         'errors' => $validator->errors()->toArray(),
        ], 422);               
      }
     
      $liked = Workoutlike::where('workoutid',$request->workoutid)->where('userid',$request->userlikeid)->where('likebyuserid',$userid)->first();

    
     
      if($liked)
      {
        $result['success'] = TRUE;       
        $result['message'] = "Already liked";
        $result['is_workout_liked'] = false; 
        Workoutlike::where('workoutid',$request->workoutid)->where('userid',$request->userlikeid)->where('likebyuserid',$userid)->delete();

        $allusers = Workoutlike::where('workoutid',$request->workoutid)->where('userid',$request->userlikeid)->get();  
      if(count($allusers)>0){
        foreach ($allusers as $likes)
        {
          $name = User::where('id',$likes['likebyuserid'])->value('name');
          $gender = User::where('id',$likes['likebyuserid'])->value('gender');
          $image = User::where('id',$likes['likebyuserid'])->value('image');        
          $likes->name = $name;
          $likes->gender = $gender;
          $likes->image = $image;
        }  
        $result['likes'] = $allusers;
      }
      else
      {
        $result['likes'] = array();
      }


      }
      else{
        $userlike = new Workoutlike;
        $userlike->workoutid = $request->workoutid;
        $userlike->userid = $request->userlikeid;
        $userlike->likebyuserid = $userid;
        $result['is_workout_liked'] = true; 
       

        if($userlike->save())
        {
           $allusers = Workoutlike::where('workoutid',$request->workoutid)->where('userid',$request->userlikeid)->get();  
        if(count($allusers)>0){
          foreach ($allusers as $likes)
          {
            $name = User::where('id',$likes['likebyuserid'])->value('name');
            $gender = User::where('id',$likes['likebyuserid'])->value('gender');
            $image = User::where('id',$likes['likebyuserid'])->value('image');        
            $likes->name = $name;
            $likes->gender = $gender;
            $likes->image = $image;
          }  
          $result['likes'] = $allusers;
        }
        else
        {
          $result['likes'] = array();
        }
          $userlike = Workoutlike::find($userlike->id);
          $result['likedata'] = $userlike;
          $result['success'] = TRUE;
          $result['message'] = "liked"; 

         $serverkey = 'AAAAwfR2gGQ:APA91bGztP8eKKQ5UoGgBLpqRH7rCPoeBSxLySnwbYJrLpobaUvLC7dMoe0vUYRiaAHI8M_wFWAYYE-f_XpsdmpfTbKXX5ycJqiiy9kS3i_58AEAzsRaYxm3sI-anPrWjpiA6R6lYY-p';

         $workoutname = Workout::where('id',$request->workoutid)->value('title');

         $userworkout  = Userworkout::where('userid',$request->userlikeid)->where('workoutid',$request->workoutid)->first();

        $worklike = Workoutlike::where('workoutid',$request->workoutid)->where('userid',$request->userlikeid)->where('likebyuserid',$userid)->first();

          $gender = User::where('id',$request->userlikeid)->value('gender');
          $likes = Workoutlike::where('workoutid',$request->workoutid)->where('userid',$request->userlikeid)->count();

          $comments = Workoutcomment::where('workoutid',$request->workoutid)->where('userid',$request->userlikeid)->count();

          if($worklike)
          {            
            $userworkout->is_myliked = TRUE;          
          }
          else
          {           
            $userworkout->is_myliked = FALSE;        
          }         
          $userworkout->gender =  $gender;         
          $userworkout->likes = $likes;          
          $userworkout->comments = $comments;
          $allikes = Workoutlike::where('workoutid',$request->workoutid)->count();
          $allcomments = Workoutcomment::where('workoutid',$request->workoutid)->count();   

          $userworkout->likes_count = $allikes;
          $userworkout->comments_count = $allcomments;
          $ios = $userworkout;
          $message1 =  "<b><font face=roboto size=4px>".$username ." </b>"." "."gave you a High-Five on your ".$workoutname." workout</font>";

         /*$counthighfive = Notification::where('workoutid',$request->workoutid)->where('otheruserid',$request->userlikeid)->where('type',3)->count();
         return $counthighfive;
         
         if($counthighfive >2)
         {
          $net =  $counthighfive - 2;
         }
         else{}*/
          $message =  $username ." gave you a High-Five on your ".$workoutname." workout";

          $tokens = User::select('device_token')->where('id',$request->userlikeid)->first();
          $device_type = User::select('device_type')->where('id',$request->userlikeid)->first();

          if($tokens){    
          $this->addnotifications($userid,$request->userlikeid,$request->workoutid,$message1,3);

        $notificationscount= Notification::where('otheruserid',$request->userlikeid)->where('readstatus',0)->count();
        $messagecount =  Chat::where('receiver_id',$request->userlikeid)->where('readstatus',0)->count();
        $allcount = $notificationscount+$messagecount;


            $url = 'https://fcm.googleapis.com/fcm/send';
            if($device_type['device_type']==1){
            $fields = array(
              'to' => $tokens['device_token'],
              'data' => array('title' => 'comment', 'body' =>  $message ,'sound'=>'Default','getuser'=>$ios,'type'=>3,'badge'=>$allcount)           
            );
          }
          else if($device_type['device_type']==2){
            $fields = array(
              'to' => $tokens['device_token'],
              'notification' => array('title' => 'comment', 'body' =>  $message ,'sound'=>'Default','getuser'=>$ios,'type'=>3,'badge'=>$allcount)           
            );
          }


            $headers = array(
              'Authorization: key=' . $serverkey,
              'Content-Type: application/json'
            );
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            curl_exec($ch);
            curl_close($ch);


          }       
        }
        else
        {
          $result['success'] = TRUE;
          $result['message'] = "Something went wrong";
        }
      } 
    }
    catch (\Exception $e) {
      $result = [
          'message'=> $e->getMessage(). ' Line No '. $e->getLine() . ' In File'. $e->getFile()
      ];
      Log::error($e->getTraceAsString());
      $result['success'] = FALSE;
    }    
    return $result; 
  }

  public function listcomments(Request $request)
  {
    $userid = Auth::id();
    try{
      $rules = [
        'workoutid'=> 'required',
        'userid'  =>'required' 
      ];
      $validator = Validator::make($request->all(), $rules);

      if($validator->fails())
      {
        return response()->json([
         "message" => "Something went wrong!",
          "success"=>FALSE,
         'errors' => $validator->errors()->toArray(),
        ], 422);               
      }
      $useridcomment = $request->userid;
      $allworkouts = Workout::with(array("comments" => 
        function($query) use ($useridcomment){
        $query->select()->where('userid',$useridcomment);
      }))->where('id',$request->workoutid)->first();  

      foreach ($allworkouts['comments'] as $comment)
      {
        $name = User::where('id',$comment['commentedby'])->value('name');
        $gender = User::where('id',$comment['commentedby'])->value('gender');
        $image = User::where('id',$comment['commentedby'])->value('image');
        $comment_likes = Workoutcomment::where('id',$comment['id'])->value('likes');
        $comment_byme = Commentlike::where('commentid',$comment['id'])->where('userid',$userid)->first();
        $comment->name = $name;
        $comment->gender = $gender;
        $comment->image = $image;
        $comment->comment_likes = $comment_likes;
        if($comment_byme)
        {
          $comment->comment_likebyme = true;
        }
        else
        {
         $comment->comment_likebyme = false; 
        }
      }
      foreach($allworkouts as $data)
      {
        $allusers = Workoutlike::where('workoutid',$request->workoutid)->where('userid',$request->userid)->get();      
      }
      $allworkouts->likes = $allusers;  
      foreach ($allworkouts['likes'] as $likes)
      {
        $name = User::where('id',$likes['likebyuserid'])->value('name');
        $gender = User::where('id',$likes['likebyuserid'])->value('gender');
        $image = User::where('id',$likes['likebyuserid'])->value('image');        
        $likes->name = $name;
        $likes->gender = $gender;
        $likes->image = $image;
      }  
      if($allworkouts)
      {
        $result['workouts'] =$allworkouts;
        $result['message']=  "successfully listed";
        $result['success'] = TRUE;
      }
      else
      {
        $result['message']=  "Something went wrong";
        $result['success'] = TRUE;
      }
    }
    catch (\Exception $e) {
      $result = [
            'message'=> $e->getMessage(). ' Line No '. $e->getLine() . ' In File'. $e->getFile()
        ];
      Log::error($e->getTraceAsString());
      $result['success'] = FALSE;
    }    
    return $result; 
  }


public function deletecomment(Request $request)
  {
    $userid = Auth::id();
    try{
     $rules = [
        'commentid' =>'required'
      ];
      $validator = Validator::make($request->all(), $rules);

      if($validator->fails())
      {
        return response()->json([
         "message" => "Something went wrong!",
          "success"=>FALSE,
         'errors' => $validator->errors()->toArray(),
        ], 422);               
      }
      Workoutcomment::where('id',$request->commentid)->delete();
      $comment = Workoutcomment::find($request->commentid);
      if($comment)
      {  
        $result['success'] = TRUE;
        $result['message'] = "Something went wrong";
      }
      else
      {
        $result['success'] = TRUE;
        $result['message'] = "comment deleted";
        
      }
    }
    catch (\Exception $e) {
      $result = [
            'message'=> $e->getMessage(). ' Line No '. $e->getLine() . ' In File'. $e->getFile()
        ];
      Log::error($e->getTraceAsString());
      $result['success'] = FALSE;
    }    
    return $result; 
  }


  public function addcomment(Request $request)
  {
    $userid = Auth::id();
    $username = User::where('id',$userid)->value('name');
    try{
     $rules = [
        'workoutid'=> 'required',
        'userid'  =>'required' ,
        'comments'=>'required'
      ];
      $validator = Validator::make($request->all(), $rules);

      if($validator->fails())
      {
        return response()->json([
         "message" => "Something went wrong!",
          "success"=>FALSE,
         'errors' => $validator->errors()->toArray(),
        ], 422);               
      }
     $comment = new Workoutcomment ;
     $comment->workoutid = $request->workoutid;
     $comment->userid = $request->userid;
     $comment->commentedby = $userid;
     $comment->comments = $request->comments;
     if($comment->save())
     {
   /*   $getuser = Userworkout::where('userid',$request->userid)->where('workoutid',$request->workoutid)->first();*/


        $result['comment'] = Workoutcomment::find($comment->id);
        $result['success'] = TRUE;
        $result['message'] = "comment Added";

        $workoutname = Workout::where('id',$request->workoutid)->value('title');

        $userworkout  = Userworkout::where('userid',$request->userid)->where('workoutid',$request->workoutid)->first();

        $worklike = Workoutlike::where('workoutid',$request->workoutid)->where('userid',$request->userid)->where('likebyuserid',$userid)->first();

          $gender = User::where('id',$request->userid)->value('gender');
          $likes = Workoutlike::where('workoutid',$request->workoutid)->where('userid',$request->userid)->count();

          $comments = Workoutcomment::where('workoutid',$request->workoutid)->where('userid',$request->userid)->count();

          if($worklike)
          {
            
             $userworkout->is_myliked = TRUE;          
          }
          else
          {
           
            $userworkout->is_myliked = FALSE;        
          }
         
            $userworkout->gender =  $gender;
         
           $userworkout->likes = $likes;
          
            $userworkout->comments = $comments;
          $allikes = Workoutlike::where('workoutid',$request->workoutid)->count();

          $allcomments = Workoutcomment::where('workoutid',$request->workoutid)->count();   

          $userworkout->likes_count = $allikes;
         $userworkout->comments_count = $allcomments;
         $ios = $userworkout;
         $message1 =  "<font face=roboto size=4px><b>".$username ."</b>"." "." made a comment on your " .$workoutname." workout</font>";
        /*$result['getuser'] = $getuser;*/       

      $serverkey = 'AAAAwfR2gGQ:APA91bGztP8eKKQ5UoGgBLpqRH7rCPoeBSxLySnwbYJrLpobaUvLC7dMoe0vUYRiaAHI8M_wFWAYYE-f_XpsdmpfTbKXX5ycJqiiy9kS3i_58AEAzsRaYxm3sI-anPrWjpiA6R6lYY-p';
       $message =  $username ." made a comment on your " .$workoutname." workout";
       $tokens = User::select('device_token')->where('id',$request->userid)->first();
       $device_type = User::select('device_type')->where('id',$request->userid)->first();
      if($tokens){   

         $this->addnotifications($userid,$request->userid,$request->workoutid,$message1,1);

        $notificationscount= Notification::where('otheruserid',$request->userid)->where('readstatus',0)->count();
        $messagecount =  Chat::where('receiver_id',$request->userid)->where('readstatus',0)->count();
        $allcount = $notificationscount+$messagecount; 

        $url = 'https://fcm.googleapis.com/fcm/send';
        if($device_type['device_type']==1)
        {
          $fields = array(
          'to' => $tokens['device_token'],
          'data' => array('title' => 'comment', 'body' =>  $message ,'sound'=>'Default','getuser'=>$ios,'type'=>2,'badge'=>$allcount)           
          );
        }
        else if($device_type['device_type']==2){
          $fields = array(
            'to' => $tokens['device_token'],
            'notification' => array('title' => 'comment', 'body' =>  $message ,'sound'=>'Default','getuser'=>$ios,'type'=>2,'badge'=>$allcount)           
          );
        }
        $headers = array(
          'Authorization: key=' . $serverkey,
          'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        curl_exec($ch);
        curl_close($ch);
      }      
    }
     else
     {
      $result['success'] = TRUE;
      $result['message'] = "Something went wrong"; 
     }
    }
    catch (\Exception $e) {
      $result = [
            'message'=> $e->getMessage(). ' Line No '. $e->getLine() . ' In File'. $e->getFile()
        ];
      Log::error($e->getTraceAsString());
      $result['success'] = FALSE;
    }    
    return $result; 
  }
  public function likecomment(Request $request)
  {
    $userid = Auth::id();
    $username = User::where('id',$userid)->value('name');
    try{
     $rules = [
        'commentid' =>'required'
      ];
      $validator = Validator::make($request->all(), $rules);

      if($validator->fails())
      {
        return response()->json([
         "message" => "Something went wrong!",
          "success"=>FALSE,
         'errors' => $validator->errors()->toArray(),
        ], 422);               
      }
    
      $commentworkoutid  = Workoutcomment::where('id',$request->commentid)->value('workoutid');   
      $workoutname = Workout::where('id',$commentworkoutid)->value('title');
      $commentalreadyliked = Commentlike::where('commentid',$request->commentid)->where('userid',$userid)->first();
      if($commentalreadyliked )
      {
        Commentlike::where('commentid',$request->commentid)->where('userid',$userid)->delete();
        Workoutcomment::where('id',$request->commentid)->decrement('likes');
        $result['is_comment_liked'] = False;
        $result['message'] = "comment unliked"; 
        $like=1;
      }
      else{     
        $commentlike = new Commentlike;
        $commentlike->commentid = $request->commentid;
        $commentlike->userid = $userid;
        $commentlike->save();
        $like = Workoutcomment::where('id',$request->commentid)->increment('likes'); 
        $like=1;
        $result['is_comment_liked'] = TRUE;
        $result['message'] = "comment liked"; 
      }
      $commentdata = Workoutcomment::where('id',$request->commentid)->first();
      $work_userid = Workoutcomment::where('id',$commentdata['id'])->value('userid');
      $workoutid = Workoutcomment::where('id',$commentdata['id'])->value('workoutid');

      $userworkout  = Userworkout::where('userid', $work_userid )->where('workoutid',$workoutid)->first();

      $worklike = Workoutlike::where('workoutid',$workoutid)->where('userid', $work_userid)->where('likebyuserid',$userid)->first();

          $gender = User::where('id',$work_userid)->value('gender');
          $likes = Workoutlike::where('workoutid',$workoutid)->where('userid',$work_userid )->count();

          $comments = Workoutcomment::where('workoutid',$workoutid)->where('userid',$work_userid )->count();

          if($worklike)
          {
            
             $userworkout->is_myliked = TRUE;          
          }
          else
          {
           
            $userworkout->is_myliked = FALSE;        
          }
         
            $userworkout->gender =  $gender;
         
           $userworkout->likes = $likes;
          
            $userworkout->comments = $comments;
          $allikes = Workoutlike::where('workoutid',$workoutid)->count();

          $allcomments = Workoutcomment::where('workoutid',$workoutid)->count();   

          $userworkout->likes_count = $allikes;
         $userworkout->comments_count = $allcomments;
         $ios = $userworkout;
         $message1 =  "<font face=roboto size=4px><b>".$username ."</b>"." "." liked comment on your ".$workoutname." workout</font>"; 

     /* $getuser = Userworkout::where('userid',$commentdata['userid'])->where('workoutid',$commentdata['workoutid'])->first();*/
      if($like>0){
        $result['success'] = TRUE;

                  

      $serverkey = 'AAAAwfR2gGQ:APA91bGztP8eKKQ5UoGgBLpqRH7rCPoeBSxLySnwbYJrLpobaUvLC7dMoe0vUYRiaAHI8M_wFWAYYE-f_XpsdmpfTbKXX5ycJqiiy9kS3i_58AEAzsRaYxm3sI-anPrWjpiA6R6lYY-p';

       $message =  $username ." liked comment on your ".$workoutname." workout";      
       $usertokenid = Workoutcomment::where('id',$request->commentid)->value('userid');
       $tokens = User::select('device_token')->where('id',$usertokenid)->first();
       $device_type = User::select('device_type')->where('id',$usertokenid)->first();
        if($tokens){     

          $this->addnotifications($userid,$commentdata['userid'],$commentdata['workoutid'],$message1,2);

        $notificationscount= Notification::where('otheruserid',$commentdata['userid'])->where('readstatus',0)->count();
        $messagecount =  Chat::where('receiver_id',$commentdata['userid'])->where('readstatus',0)->count();

        $allcount = $notificationscount+$messagecount;  
        $url = 'https://fcm.googleapis.com/fcm/send';
        if($device_type['device_type']==1)
        {
        $fields = array(
          'to' => $tokens['device_token'],
          'data' => array('title' => 'comment liked', 'body' =>  $message ,'sound'=>'Default','getuser'=>$ios,'type'=>4,'badge'=>$allcount)           
        );
      }
      else if($device_type['device_type']==2)
        {
          $fields = array(
          'to' => $tokens['device_token'],
          'notification' => array('title' => 'comment liked', 'body' =>  $message ,'sound'=>'Default','getuser'=>$ios,'type'=>4,'badge'=>$allcount)
        );
        }

        $headers = array(
          'Authorization: key=' . $serverkey,
          'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        curl_exec($ch);
        curl_close($ch);
        /*if($commentdata['userid'] == $userid){}
        else*/
      } 
      }
      else
      {
        $result['success'] = TRUE;
        $result['message'] = "Something went wrong"; 
      }
    }
    catch (\Exception $e) {
      $result = [
            'message'=> $e->getMessage(). ' Line No '. $e->getLine() . ' In File'. $e->getFile()
        ];
      Log::error($e->getTraceAsString());
      $result['success'] = FALSE;
    }    
    return $result; 
  }

 public function savemessage(Request $request)
  {
    try{
     $rules = [
        'senderid' =>'required',
        'receiverid' =>'required',
        'type' =>'required',
        'media'=>'required'
      ];
      $validator = Validator::make($request->all(), $rules);
      if($validator->fails())
      {
        return response()->json([
         "message" => "Something went wrong!",
         "success"=>FALSE,
         'errors' => $validator->errors()->toArray(),
        ], 422);               
      }
      $chat = new Chat;
      $chat->sender_id = $request->senderid;
      $chat->receiver_id = $request->receiverid;
      $chat->type = $request->type;
      $token = Chat::select('sender_receiverid')
      ->whereRaw('(sender_id ="' . $request->senderid . '" AND receiver_id ="' .$request->receiverid . '") OR (sender_id ="'.$request->receiverid.'" AND receiver_id ="'.$request->senderid.'")')->first();
    
      if($token){
        $chat->sender_receiverid = $token['sender_receiverid'];
      }
      else{
        $chat->sender_receiverid =  $request->senderid.'_'.$request->receiverid;
      }
      if($request->file('media')!= "" || $request->has('media')&& $request->type !=1 ){
        ;
          if (!file_exists( public_path('/attachments'))) {
              mkdir(public_path('/attachments'), 0777, true);
          }
          $path =public_path('/attachments/');
          $image = $request->file('media');
          $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
          $destinationPath = public_path('/attachments');
          $image->move($destinationPath, $input['imagename']);
          $chat->media  =  $input['imagename'];
      } 
      else{
        
       $chat->media = $request->media;
      }
      $senderdetails = User::where('id',$request->senderid)->first();
      $receiverdetails = User::where('id',$request->receiverid)->first();
      $user_id = $request->senderid;
     $role = User::where('id',$request->senderid)->value('role');
   
      if($role == 1)
      {  
        $coachid = User::where('id',$request->senderid)->value('coach_id');     
        $lastmsg = Chat::with(array("getsenderuser" => 
        function($query) use ($user_id){
        $query->select()->where('id','<>',$user_id);
        }))->with(array("getreceiveruser" => 
        function($query) use ($user_id){
        $query->select()->where('id','<>',$user_id);
        }))->whereIn('workout_chat.id',array( DB::raw('SELECT  MAX(id) FROM workout_chat WHERE (sender_id ='.$user_id.' And receiver_id ='.$coachid.')OR (receiver_id ='.$user_id.' And sender_id ='.$coachid.')')));
        $chatdata = $lastmsg->orderBy('workout_chat.id','desc')->get();


       
       foreach($chatdata as $key => $user)
       {
          if($user->getsenderuser != NULL)
          {
            $user->otheruserdetails = $user->getsenderuser;
            unset($user->getsenderuser);
          }   
          else
          {
            unset($user->getsenderuser);
          }
           if($user->getreceiveruser != NULL)
          
          {
            $user->otheruserdetails = $user->getreceiveruser;
            unset($user->getreceiveruser);
          }
          else{
             unset($user->getreceiveruser);
          }      
       }
      
        if(count($chatdata)>0)
          $ios['chatheads'] = $chatdata[0];     
        else
          $ios['chatheads'] = array(); 
          $result['chatheads'] = $chatdata;
      }
      
      else if($role == 0)
      { 
        $users = Chat::with(array("getsenderuser" => 
        function($query) use ($user_id){
        $query->select()->where('id','<>',$user_id);
        }))->with(array("getreceiveruser" => 
        function($query) use ($user_id){
        $query->select()->where('id','<>',$user_id);
        }))
        ->whereIn('workout_chat.id', array( DB::raw('SELECT  MAX(id) FROM workout_chat WHERE sender_id = '.$user_id.' OR receiver_id ='.$user_id.' GROUP BY sender_receiverid')));
        $users = $users->orderBy('workout_chat.id','desc')
       ->get();
       $arr = array();
       foreach($users as $key => $user)
       {
          if($user->getsenderuser != NULL)
          {
            $user->otheruserdetails = $user->getsenderuser;
            unset($user->getsenderuser);
          }   
          else
          {
            unset($user->getsenderuser);
          }
           if($user->getreceiveruser != NULL)
          
          {
            $user->otheruserdetails = $user->getreceiveruser;
            unset($user->getreceiveruser);
          }
          else{
             unset($user->getreceiveruser);
          }      
       }
      
       $result['chatheads'] = $users;
      }
     
     $user_id = $request->receiverid;
     $role = User::where('id',$user_id)->value('role');
   
      if($role == 1)
      {  
        $coachid = User::where('id',$user_id)->value('coach_id');     
        $lastmsg = Chat::with(array("getsenderuser" => 
        function($query) use ($user_id){
        $query->select()->where('id','<>',$user_id);
        }))->with(array("getreceiveruser" => 
        function($query) use ($user_id){
        $query->select()->where('id','<>',$user_id);
        }))->whereIn('workout_chat.id',array( DB::raw('SELECT  MAX(id) FROM workout_chat WHERE (sender_id ='.$user_id.' And receiver_id ='.$coachid.')OR (receiver_id ='.$user_id.' And sender_id ='.$coachid.')')));
        $chatdata = $lastmsg->orderBy('workout_chat.id','desc')->get();
       
       foreach($chatdata as $key => $user)
       {
          if($user->getsenderuser != NULL)
          {
            $user->otheruserdetails = $user->getsenderuser;
            unset($user->getsenderuser);
          }   
          else
          {
            unset($user->getsenderuser);
          }
           if($user->getreceiveruser != NULL)
          
          {
            $user->otheruserdetails = $user->getreceiveruser;
            unset($user->getreceiveruser);
          }
          else{
             unset($user->getreceiveruser);
          }      
       }
        //$ios['chatheads'] = $chatdata[0];
      }
      
      else if($role == 0)
      { 
        $users = Chat::with(array("getsenderuser" => 
        function($query) use ($user_id){
        $query->select()->where('id','<>',$user_id);
        }))->with(array("getreceiveruser" => 
        function($query) use ($user_id){
        $query->select()->where('id','<>',$user_id);
        }))
        ->whereIn('workout_chat.id', array( DB::raw('SELECT  MAX(id) FROM workout_chat WHERE sender_id = '.$user_id.' OR receiver_id ='.$user_id.' GROUP BY sender_receiverid')));
        $users = $users->orderBy('workout_chat.id','desc')
       ->get();
       $arr = array();
       foreach($users as $key => $user)
       {
          if($user->getsenderuser != NULL)
          {
            $user->otheruserdetails = $user->getsenderuser;
            unset($user->getsenderuser);
          }   
          else
          {
            unset($user->getsenderuser);
          }
           if($user->getreceiveruser != NULL)
          
          {
            $user->otheruserdetails = $user->getreceiveruser;
            unset($user->getreceiveruser);
          }
          else{
             unset($user->getreceiveruser);
          }      
       }
       if(count($users)>0)
       $ios['chatheads'] = $users[0];  
       else
        $ios['chatheads'] = array();

      }
    
      if($chat->save()){
        $result['chatdata'] = Chat::find($chat->id);
        $result['senderdetails'] = $senderdetails;
        $result['receiverdetails'] = $receiverdetails;
        $result['success'] = TRUE;
        $result['message'] = "Message saved";
        $ios['chatdata'] = Chat::find($chat->id);
        $ios['senderdetails'] = $senderdetails;
        $ios['receiverdetails'] = $receiverdetails;
        $iostype = 1;
        $serverkey = 'AAAAwfR2gGQ:APA91bGztP8eKKQ5UoGgBLpqRH7rCPoeBSxLySnwbYJrLpobaUvLC7dMoe0vUYRiaAHI8M_wFWAYYE-f_XpsdmpfTbKXX5ycJqiiy9kS3i_58AEAzsRaYxm3sI-anPrWjpiA6R6lYY-p';
        $username = User::where('id',$request->senderid)->value('name');
        if($request->type==1){
          $message = $request->media; 
        }
        if($request->type==2){
          $message =$username." sent you an image";
        }
        if($request->type==3){
          $message =$username." sent you a video";
        }
        if($request->type==4){
          $message =$username." sent you a file";
        }        
       
       $tokens = User::select('device_token')->where('id',$request->receiverid)->first();
       $device_type = User::select('device_type')->where('id',$request->receiverid)->first();
     
        if($tokens){     
        $url = 'https://fcm.googleapis.com/fcm/send';
        if($device_type['device_type']==1)
        {
        
        $notificationscount= Notification::where('otheruserid',$request->receiverid)->where('readstatus',0)->count();
        $messagecount =  Chat::where('receiver_id',$request->receiverid)->where('readstatus',0)->count();
        $allcount = $messagecount+$notificationscount; 

          $fields = array(
            'to' => $tokens['device_token'],
            'data' => 
            array('title' => 'New Message', 
              'body' =>  $message ,
              'sound'=>'Default',
              'data' => $ios,
              'type'=> $iostype,
              "badge"=>$allcount    
              )           
          );
          $headers = array(
              'Authorization: key=' . $serverkey,
              'Content-Type: application/json'
            );
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            curl_exec($ch);
            curl_close($ch);
      }
      else if($device_type['device_type']==2){
       /* $fields = array(
          'to' => $tokens['device_token'],
          'notification' => 
          array('title' => 'New Message', 
            'body' =>  $message ,
            'sound'=>'Default',
           //'data' => $ios,
            'type'=> $iostype) 

        );*/
        $notificationscount= Notification::where('otheruserid',$request->receiverid)->where('readstatus',0)->count();

        $messagecount =  Chat::where('receiver_id',$request->receiverid)->where('readstatus',0)->count();
        $allcount = $messagecount+$notificationscount; 
        
      
       $notification = [
            'title' => 'New Message',
            'sound' => 'Default',
            "type"=> $iostype,                     
            "body" => $message,
            "data"=>  $ios,
            "badge"=>$allcount    
            ];
            $fields = array(
              'to' => $tokens['device_token'],
              'notification' => $notification
            );
            
         
          $headers = array(
            'Authorization: key=' . $serverkey,
            'Content-Type: application/json'
          );
        $url = 'https://fcm.googleapis.com/fcm/send';
          $ch = curl_init();         
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_POST, true);
          curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
         $res =  curl_exec($ch);
         //echo "<pre>"; print_r($res); die;
          curl_close($ch);
          }
        }
      }
      else
      {
        $result['success'] = TRUE;
        $result['message'] = "Something went wrong"; 
      }
    }
      catch (\Exception $e) {
        $result = [
              'message'=> $e->getMessage(). ' Line No '. $e->getLine() . ' In File'. $e->getFile()
          ];
        Log::error($e->getTraceAsString());
        $result['success'] = FALSE;
      }    
      return $result; 
  }


public function getcoachdetails(Request $request)
{
    try{     
      $coach = User::where('role',0)->first();
      if($coach){
        $result['success'] = TRUE;
        $result['message'] = "success";  
        $result['coachdata'] = $coach;
      }
      else
      {
        $result['success'] = TRUE;
        $result['message'] = "Something went wrong"; 
      }
    }
    catch (\Exception $e) {
      $result = [
            'message'=> $e->getMessage(). ' Line No '. $e->getLine() . ' In File'. $e->getFile()
        ];
      Log::error($e->getTraceAsString());
      $result['success'] = FALSE;
    }    
    return $result; 
  }

  public function allchatdata(Request $request)
  {
    $userid = Auth::id();
    $coachid = User::where('role',0)->value('id');
    try{
      $rules = [
        'role' =>'required'
      ];
      $validator = Validator::make($request->all(), $rules);
      if($validator->fails())
      {
        return response()->json([
         "message" => "Something went wrong!",
         "success"=>FALSE,
         'errors' => $validator->errors()->toArray(),
        ], 422);               
      }
      if($request->role == 1)
      {        
         $mychat = Chat::where(function($q) use ($userid){
                  $q->orWhere("sender_id","=",$userid)
                  ->orWhere("receiver_id","=",$userid);
                  })->where('coacheditstatus',0)
                ->get();
        $result['otheruserdetails '] = User::where('role',0)->first();
        if($mychat){
          $result['success'] = TRUE;
          $result['message'] = "success";  
          $result['chatmessages'] = $mychat;
        }
        else
        {
          $result['success'] = TRUE;
          $result['message'] = "Something went wrong"; 
        }
      }
      else if($request->role == 0)
      {  
        $rules = [
          'userid'=>'required'
        ];
        $user_id = $request->userid;
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails())
        {
          return response()->json([
           "message" => "Something went wrong!",
           "success"=>FALSE,
           'errors' => $validator->errors()->toArray(),
          ], 422);               
        }    
        $mychat = Chat::where(function($q) use ($user_id){
          $q->orWhere("sender_id","=",$user_id)
          ->orWhere("receiver_id","=",$user_id);
          })->where('coacheditstatus',0)
        ->get();
        $result['otheruserdetails '] = User::where('role',1)->where('id',$user_id)->first();
        if($mychat){
          $result['success'] = TRUE;
          $result['message'] = "success";  
          $result['chatmessages'] = $mychat;
        }
        else
        {
          $result['success'] = TRUE;
          $result['message'] = "Something went wrong"; 
        }

      }
    }
    catch (\Exception $e) {
      $result = [
            'message'=> $e->getMessage(). ' Line No '. $e->getLine() . ' In File'. $e->getFile()
        ];
      Log::error($e->getTraceAsString());
      $result['success'] = FALSE;
    }    
    return $result; 
  }

  public function chatheads(Request $request)
  {
    $user_id = Auth::id();
    $role = User::where('id',$user_id)->value('role');
    try{
      if($role == 1)
      {  
        $coachid = User::where('id',$user_id)->value('coach_id');     
        $lastmsg = Chat::with(array("getsenderuser" => 
        function($query) use ($user_id){
        $query->select()->where('id','<>',$user_id);
        }))->with(array("getreceiveruser" => 
        function($query) use ($user_id){
        $query->select()->where('id','<>',$user_id);
        }))->whereIn('workout_chat.id',array( DB::raw('SELECT  MAX(id) FROM workout_chat WHERE (sender_id ='.$user_id.' And receiver_id ='.$coachid.')OR (receiver_id ='.$user_id.' And sender_id ='.$coachid.')')))->where('coacheditstatus',0);

        $chatdata = $lastmsg->orderBy('workout_chat.id','desc')->get();
       
       foreach($chatdata as $key => $user)
       {
          if($user->getsenderuser != NULL)
          {
            $user->otheruserdetails = $user->getsenderuser;
            unset($user->getsenderuser);
          }   
          else
          {
            unset($user->getsenderuser);
          }
           if($user->getreceiveruser != NULL)
          
          {
            $user->otheruserdetails = $user->getreceiveruser;
            unset($user->getreceiveruser);
          }
          else{
             unset($user->getreceiveruser);
          }      
       }
      
        if($chatdata){
          $result['success'] = TRUE;
          $result['chatheads '] = $chatdata;
        }
        else
        {
          $result['success'] = TRUE;
          $result['message'] = "Something went wrong"; 
        }
      }
      else if($role == 0)
      { 
        $users = Chat::with(array("getsenderuser" => 
        function($query) use ($user_id){
        $query->select()->where('id','<>',$user_id);
        }))->with(array("getreceiveruser" => 
        function($query) use ($user_id){
        $query->select()->where('id','<>',$user_id);
        }))
        ->whereIn('workout_chat.id', array( DB::raw('SELECT  MAX(id) FROM workout_chat WHERE sender_id = '.$user_id.' OR receiver_id ='.$user_id.' GROUP BY sender_receiverid')))->where('coacheditstatus',0);
        $users = $users->orderBy('workout_chat.id','desc')
       ->get();
       $arr = array();
       foreach($users as $key => $user)
       {
          if($user->getsenderuser != NULL)
          {
            $user->otheruserdetails = $user->getsenderuser;
            unset($user->getsenderuser);
          }   
          else
          {
            unset($user->getsenderuser);
          }
           if($user->getreceiveruser != NULL)
          
          {
            $user->otheruserdetails = $user->getreceiveruser;
            unset($user->getreceiveruser);
          }
          else{
             unset($user->getreceiveruser);
          }      
       }

        if($users){
          $result['success'] = TRUE;
          $result['message'] = "success";  
          $result['chatheads'] = $users;
        }
        else
        {
          $result['success'] = TRUE;
          $result['message'] = "Something went wrong"; 
        }
      }
    }
    catch (\Exception $e) {
      $result = [
            'message'=> $e->getMessage(). ' Line No '. $e->getLine() . ' In File'. $e->getFile()
        ];
      Log::error($e->getTraceAsString());
      $result['success'] = FALSE;
    }    
    return $result; 
  }
  public function registertoken(Request $request)
  {
    $userid = Auth::id();
    try{
      $rules = [
        'device_token' =>'required',
        'device_type' =>'required'
      ];
      $validator = Validator::make($request->all(), $rules);
      if($validator->fails())
      {
        return response()->json([
         "message" => "Something went wrong!",
         "success"=>FALSE,
         'errors' => $validator->errors()->toArray(),
        ], 422);               
      }
      User::where('id',$userid)->update(['device_token'=>$request->device_token,'device_type'=>$request->device_type]);
      $is_token =  User::where('id',$userid)->value('device_token');
      if($is_token !="")
      {
        $result['success'] = TRUE;
        $result['message'] = "Token Updated successfully";
      }
      else
      {
        $result['success'] = TRUE;
        $result['message'] = "Token Not Updated";
      }
    }
    catch (\Exception $e) {
      $result = [
            'message'=> $e->getMessage(). ' Line No '. $e->getLine() . ' In File'. $e->getFile()
        ];
      Log::error($e->getTraceAsString());
      $result['success'] = FALSE;
    }  
    return $result; 
  }

  public function editprofile(Request $request)
  {
    $userid = Auth::id();
    $user = Auth::user();
    $coach_id = $user->coach_id;
    try{
      $user = User::find($userid);
      if($request->has('name')&& $request->get('name')!=""){
        $user->name = $request->name;
      }
      if($request->has('dob')&& $request->get('dob')!=""){
        $user->dob = $request->dob;
      }
      if($request->has('age')&& $request->get('age')!=""){
        $user->age = $request->age;
      }
      if($request->has('weight')&& $request->get('weight')!=""){
        $user->weight = $request->weight;
      }
      if($request->has('height')&& $request->get('height')!=""){
        $user->height = $request->height;
      }
      if($request->has('profile')&& $request->file('profile')!=""){
        $rules = [
          'profile'=>'image|mimes:jpeg,png,jpg,gif,svg'
        ];
        $user_id = $request->userid;
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails())
        {
          return response()->json([
           "message" => "Something went wrong!",
           "success"=>FALSE,
           'errors' => $validator->errors()->toArray(),
          ], 422);               
        }   
        if (!file_exists( public_path('/images'))) {
          mkdir(public_path('/images'), 0777, true);
        }
        $path =public_path('/images/');
        $image = $request->file('profile');
        $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path('/images');
        $image->move($destinationPath, $input['imagename']);
        $user->image  =  $input['imagename'];        
      }
      if($request->has('coverimage') && $request->file('coverimage')!=""){
        $rules = [
          'coverimage'=>'image|mimes:jpeg,png,jpg,gif,svg'
        ];
        $user_id = $request->userid;
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails())
        {
          return response()->json([
           "message" => "Something went wrong!",
           "success"=>FALSE,
           'errors' => $validator->errors()->toArray(),
          ], 422);               
        }   
       if (!file_exists( public_path('/images'))) {
          mkdir(public_path('/images'), 0777, true);
        }
        $path =public_path('/images/');
        $image = $request->file('coverimage');
        $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path('/images');
        $image->move($destinationPath, $input['imagename']);
        $user->cover_image  =  $input['imagename'];
      }       
      $coatchDetails  = User::select('id','name','email','role','created_at','updated_at','image','gender')->where('id',$coach_id)->first();   
     
      if($user->save())
      {
        $user = User::where('id',$userid)->first();
        $result['success'] = TRUE;
        $result['user'] = $user;
        $result['user']['coach_details'] = $coatchDetails;
        $result['message'] = "profile Updated successfully";
      }
      else
      {
        $result['success'] = TRUE;
        $result['message'] = "Something went wrong";
      }
    }
    catch (\Exception $e) {
      $result = [
            'message'=> $e->getMessage(). ' Line No '. $e->getLine() . ' In File'. $e->getFile()
        ];
      Log::error($e->getTraceAsString());
      $result['success'] = FALSE;
    }  
    return $result; 
  }

  public function addnotifications($userid,$otheruserid,$workoutid,$message,$type)
  {

    $notify = new Notification;
    $notify->userid = $userid;
    $notify->otheruserid = $otheruserid;
    $notify->workoutid = $workoutid;
    $notify->message = $message;
    $notify->type = $type;
    $notify->message = $message;
    $notify->save();
    
  }
  public function allnotifications()
  {
    try{
      $userid = Auth::id();  

      $allnotifications = Notification::where('otheruserid',$userid)     
      ->orWhere(function ($query) use ($userid) {
      $query->where('otheruserid',$userid)
      ->where('userid',$userid);
    })->paginate(30);

      $iddata = array();
      foreach($allnotifications as $notify){

        $notify['getuser'] = Userworkout::where('userid',$notify['otheruserid'])->where('workoutid',$notify['workoutid'])->first();
      }
        foreach($allnotifications as $data)
       {   
          $typenotify = Notification::where('workoutid',$data['workoutid'])->value('type');          

           if($typenotify == 3){

            $messagecount = Notification::where('workoutid',$data['workoutid'])->where('type',3)->count();
          

            if($messagecount>3)
            {               
              $messageids = Notification::where('workoutid',$data['workoutid'])->where('type',3)->get();
             
              $workoutname = Workout::where('id',$data['workoutid'])->value('title');

              $names = array();
              foreach($messageids as $msg)
              {
                $names[] = User::where('id',$msg['userid'])->value('name');
              }
              if(count($names)>3)
              {
                $sliced_namearray = array_slice($names, 0, 3);  
                $names1 = implode(", ",$sliced_namearray);
                $netcount = count($names)- 3;             
                $message = "<font face=Roboto size=4px><b>".$names1." +".$netcount." others</b> gave a high five on your ".$workoutname. " workout</font>";              
              }
              else{
                $names1 = implode(",",$names);
                $message = "<font face=Roboto size=4px><b>".$names1."</b> gave a high five on your ".$workoutname. " workout</font>";
              }

              foreach( $messageids as $key=>$id)
              { 
                if($key==0)
                Notification::where('id',$id['id'])->update(['message'=>$message]);

                if($key!=0)
                Notification::where('id',$id['id'])->update(['status'=>1,'message'=>$names1." gave a high five on your workout"]);          
              }          
              //$data['message']= "all"; 
            }
          }

          $worklike = Workoutlike::where('workoutid',$data['workoutid'])->where('userid',$data['otheruserid'])->where('likebyuserid',$data['userid'])->first();

          $gender = User::where('id',$data['userid'])->value('gender');
          $likes = Workoutlike::where('workoutid',$data['workoutid'])->where('userid',$data['userid'])->count();

          $comments = Workoutcomment::where('workoutid',$data['workoutid'])->where('userid',$data['userid'])->count();

          if($worklike)
          {
            if($data['getuser']!=NULL)
            $data['getuser']->is_myliked = TRUE;          
          }
          else
          {
            if($data['getuser']!=NULL)
            $data['getuser']->is_myliked = FALSE;        
          }
          if($data['getuser']!=NULL)
          $data['getuser']->gender =  $gender;
          if($data['getuser']!=NULL)
          $data['getuser']->likes = $likes;
          if($data['getuser']!=NULL)
          $data['getuser']->comments = $comments;
          $allikes = Workoutlike::where('workoutid',$data['workoutid'])->count();

          $allcomments = Workoutcomment::where('workoutid',$data['workoutid'])->count();   

          $data->likes_count = $allikes;
          $data->comments_count = $allcomments;
       }  
       /*$all =  array();
       foreach($allnotifications as $key=>$n)
       {
        if(!in_array($n['id'],$iddata))
         $all[$key] = $n;
       }
       return $all;*/
        $allnotifications = Notification::where('otheruserid',$userid)->where('status',0)->paginate(30); 
   
      foreach($allnotifications as $notify){

        $notify['getuser'] = Userworkout::where('userid',$notify['otheruserid'])->where('workoutid',$notify['workoutid'])->first();
      }
        foreach($allnotifications as $data)
       {     
        
          /*$typenotify = Notification::where('workoutid',$data['workoutid'])->value('type');

           if($typenotify == 3){

            $messagecount = Notification::where('workoutid',$data['workoutid'])->where('type',3)->count();

            if($messagecount>1)
            { 
             $messageids = Notification::where('workoutid',$data['workoutid'])->where('type',3)->get();
              $names = array();

              foreach($messageids as $msg)
              {
                $names[] = User::where('id',$msg['userid'])->value('name');
              }
              $names1 = implode(",",$names);
              foreach( $messageids as $key=>$id)
              { 
                if($key!=0)
                Notification::where('id',$id['id'])->update(['status'=>1,'message'=>$names1." gave a high five on your workout"]);          
              }               
              
            }
          }*/
           
          $worklike = Workoutlike::where('workoutid',$data['workoutid'])->where('userid',$data['otheruserid'])->where('likebyuserid',$data['userid'])->first();

          $gender = User::where('id',$data['userid'])->value('gender');
          $likes = Workoutlike::where('workoutid',$data['workoutid'])->where('userid',$data['userid'])->count();

          $comments = Workoutcomment::where('workoutid',$data['workoutid'])->where('userid',$data['userid'])->count();

          if($worklike)
          {
            if($data['getuser']!=NULL)
            $data['getuser']->is_myliked = TRUE;          
          }
          else
          {
            if($data['getuser']!=NULL)
            $data['getuser']->is_myliked = FALSE;        
          }
          if($data['getuser']!=NULL)
          $data['getuser']->gender =  $gender;
          if($data['getuser']!=NULL)
          $data['getuser']->likes = $likes;
          if($data['getuser']!=NULL)
          $data['getuser']->comments = $comments;
          $allikes = Workoutlike::where('workoutid',$data['workoutid'])->count();

          $allcomments = Workoutcomment::where('workoutid',$data['workoutid'])->count();   

          $data->likes_count = $allikes;
          $data->comments_count = $allcomments;
       }  

        if(count( $allnotifications)>0)
        {
         $result['success'] = TRUE;
         $result['notifications'] = $allnotifications;
         $result['message'] = "Listed successfully";
        }
        else
        {
          $result['success'] = TRUE;
          $result['notifications'] = $allnotifications;
          $result['message'] = "No notifications available";
        }
    }
    catch (\Exception $e) {
      $result = [
            'message'=> $e->getMessage(). ' Line No '. $e->getLine() . ' In File'. $e->getFile()
        ];
      Log::error($e->getTraceAsString());
      $result['success'] = FALSE;
    }  
    return $result; 
  }

  public function userstats(Request $request)
  {
    try{
      $userid = Auth::id();


      $user = Auth::user();
      $coach_id = $user->coach_id;
      $currentMonth = date('m');
      $currentdate = date('Y-m-d');
      $lastthreemonthdate = Carbon::now()->addMonths(-3);
      
      $commentsthismonth = DB::table("workout_comments")
      ->where('commentedby',$userid)
      ->whereRaw('MONTH(created_at) = ?',[$currentMonth])
      ->count();      
      $commentslastthreemonth = DB::table("workout_comments")
      ->where('commentedby',$userid)
      ->whereDate('created_at','>=',$lastthreemonthdate)->whereDate('created_at','<=',$currentdate)
      ->count();
      $commentsalltime = DB::table("workout_comments")
      ->where('commentedby',$userid)      
      ->count();
      $hifivesthismonth = DB::table("workout_like")
      ->where('likebyuserid',$userid)
      ->whereRaw('MONTH(created_at) = ?',[$currentMonth])
      ->count();
      $hifivesthreemonth = DB::table("workout_like")
     ->where('likebyuserid',$userid)
      ->whereDate('created_at','>=',$lastthreemonthdate)->whereDate('created_at','<=',$currentdate)
      ->count();
       $hifivesalltime = DB::table("workout_like")
     ->where('likebyuserid',$userid)   
      ->count();
       $hifivesthismonth_me_got = DB::table("workout_like")
      ->where('userid',$userid)
      ->whereRaw('MONTH(created_at) = ?',[$currentMonth])
      ->count();
      $hifivesthreemonth_me_got = DB::table("workout_like")
     ->where('userid',$userid)
      ->whereDate('created_at','>=',$lastthreemonthdate)->whereDate('created_at','<=',$currentdate)
      ->count();
       $hifivesalltime_me_got = DB::table("workout_like")
     ->where('userid',$userid)   
      ->count();
      $workoutworkedtoday = Userworkout::where('userid',$userid)->whereDate('date_created',$currentdate)->get();
     
      foreach($workoutworkedtoday as $key=>$data){
        $workoutworkedtoday[$key]['admin_created_date'] = Workout::where('id',$data->workoutid)->value('workout_date');
         $workoutworkedtoday[$key]['workout_title'] = Workout::where('id',$data->workoutid)->value('title');
      }

     /* $workoutworkedtoday->adminworkout = Workout::where('id',$workoutworkedtoday['workout_date'])->first();*/
      $result = array();
      $all = array();
      $result['this_month']['thismonthcomments']  = $commentsthismonth;
      $result['this_month']['thismonthhifives']  = $hifivesthismonth;
      $result['this_month']['thismonthhifivesme']  = $hifivesthismonth_me_got;      
      
     $result['three_months']['threesmonthcomments']  = $commentslastthreemonth;
      $result['three_months']['threesmonthhifives']  = $hifivesthreemonth;
      $result['three_months']['threesmonthhifivesme']  = $hifivesthreemonth_me_got;

      $result['alltime']['alltimecomments']  = $commentsalltime;
      $result['alltime']['alltimehifives']  = $hifivesalltime;
      $result['alltime']['alltimefivesme']  = $hifivesalltime_me_got;
      $result['workoutworkedtoday'] = $workoutworkedtoday;  
      $userdetails = User::where('id',$userid)->first();
      $coachdetails = User::where('id',$coach_id)->first();
      $goal = Usergoal::where('userid',$userid)->first();
      $diet = Userdiet::where('userid',$userid)->first();
           
      if(count( $result)>0)
      {
       $result1['success'] = TRUE;
       $result1['result'] = $result;
      if($goal)
        $result1['result']['goaldetails'] = $goal;
      else        
        $result1['result']['goaldetails'] = null;
       if($diet)
        $result1['result']['dietdetails'] = $diet;
      else
         $result1['result']['dietdetails'] = null;
       $result1['result']['userdetails'] = $userdetails;
       $result1['result']['userdetails']['coach_details'] = $coachdetails;

       $result1['message'] = "Listed successfully";
      }
      else
      {
        $result1['success'] = TRUE;
        $result1['message'] = "Something went wrong";
      }
    }
    catch (\Exception $e) {
      $result = [
            'message'=> $e->getMessage(). ' Line No '. $e->getLine() . ' In File'. $e->getFile()
        ];
      Log::error($e->getTraceAsString());
      $result['success'] = FALSE;
    }  
    return $result1;
  }

  public function savegoal(Request $request)
  {
    try{
      $userid = Auth::id();
      $user = Auth::user();
      $coach_id = $user->coach_id;
       $rules = [
        'weightloss' =>'required',
        'weightgain' =>'required',
        'weightmaintain' =>'required',
        'proteins'=>'required',
        'carbs'=>'required',
        'fats'=>'required',
      ];
      $validator = Validator::make($request->all(), $rules);
      if($validator->fails())
      {
        return response()->json([
         "message" => "Something went wrong!",
         "success"=>FALSE,
         'errors' => $validator->errors()->toArray(),
        ], 422);               
      }
      $goalexists = Usergoal::where('userid',$userid)->first();
      if($goalexists)
      {
        Usergoal::where('userid',$userid)->update(['weightloss'=>$request->weightloss,'weightgain'=>$request->weightgain, 'weightmaintain'=>$request->weightmaintain,'proteins'=>$request->proteins,'carbs'=>$request->carbs,'fats'=>$request->fats]);
         $goaldata  =  Usergoal::where('userid',$userid)->first();

      }
      else{
        $goal = new Usergoal;
      
      $goal->userid = $userid;
      $goal->weightloss = $request->weightloss;
      $goal->weightgain = $request->weightgain;
      $goal->weightmaintain = $request->weightmaintain;
      $goal->proteins = $request->proteins;
      $goal->carbs = $request->carbs;
      $goal->fats = $request->fats;

      if($goal->save())
      {
       $goaldata  =  Usergoal::find($goal->id);
     }
   }
       if($goaldata['weightloss']== 1)
        { $goaldata['weightloss']=true ; } 
        else 
        { $goaldata['weightloss']= false ; }
       if($goaldata['weightgain']== 1)
        { $goaldata['weightgain']=true ; } 
        else 
        { $goaldata['weightgain']= false ; }
       if($goaldata['weightmaintain']== 1)
        { $goaldata['weightmaintain']=true ; }
        else 
        { $goaldata['weightmaintain']= false ; }
      if($goaldata){
      $userdetails = User::where('id',$userid)->first();
      $coachdetails = User::where('id',$coach_id)->first();
     
       $result['success'] = TRUE;
       $result['goal'] = $goaldata;
       $result['goal']['user'] =  $userdetails;
       $result['goal']['user']['coach'] =  $coachdetails;

       $result['message'] = "Goal saved successfully";
      }
      else
      {
        $result['success'] = TRUE;
        $result['message'] = "Something went wrong";
      }
    }
    catch (\Exception $e) {
      $result = [
            'message'=> $e->getMessage(). ' Line No '. $e->getLine() . ' In File'. $e->getFile()
        ];
      Log::error($e->getTraceAsString());
      $result['success'] = FALSE;
    }  
    return $result; 
  }

   public function savediet(Request $request)
  {
    try{
      $userid = Auth::id();
      $user = Auth::user();
      $coach_id = $user->coach_id;
       $rules = [       
        'proteins'=>'required',
        'carbs'=>'required',
        'fats'=>'required',
        'calories' =>'required',
        'totalproteins' =>'required',
        'totalcarbs' =>'required',
        'totalfats' =>'required',
        'percent' =>'required'        
      ];
      $validator = Validator::make($request->all(), $rules);
      if($validator->fails())
      {
        return response()->json([
         "message" => "Something went wrong!",
         "success"=>FALSE,
         'errors' => $validator->errors()->toArray(),
        ], 422);               
      }
      $userexists = Userdiet::where('userid',$userid)->first();

      if($userexists)
      {
        $date = date('Y-m-d');
        
        Userdiet::where('userid',$userid)->update(['calories'=>$request->calories,'percentage'=>$request->percent, 'proteins'=>$request->proteins,'carbs'=>$request->carbs,'fats'=>$request->fats,'total_proteins'=>$request->totalproteins,'total_carbs'=>$request->totalcarbs,'total_fats'=>$request->totalfats]);
         $dietdata  =  Userdiet::where('userid',$userid)->first(); 
         $dietdate = Userdietweb::where('userid',$userid)->whereDate('created_at',$date)->first();

         if($dietdate){

            Userdietweb::where('userid',$userid)->update(['calories'=>$request->calories,'percentage'=>$request->percent, 'proteins'=>$request->proteins,'carbs'=>$request->carbs,'fats'=>$request->fats,'total_proteins'=>$request->totalproteins,'total_carbs'=>$request->totalcarbs,'total_fats'=>$request->totalfats]);
          }
          else
          {
            $dietweb = new Userdietweb;     
            $dietweb->userid = $userid;      
            $dietweb->proteins = $request->proteins;
            $dietweb->carbs = $request->carbs;
            $dietweb->fats = $request->fats;
            $dietweb->calories = $request->calories;
            $dietweb->total_proteins = $request->totalproteins;
            $dietweb->total_carbs = $request->totalcarbs;
            $dietweb->total_fats = $request->totalfats;
            $dietweb->percentage = $request->percent;
             $dietweb->save();
          }
      }
      else{
        
        $diet = new Userdiet;
      
      $diet->userid = $userid;      
      $diet->proteins = $request->proteins;
      $diet->carbs = $request->carbs;
      $diet->fats = $request->fats;
      $diet->calories = $request->calories;
      $diet->total_proteins = $request->totalproteins;
      $diet->total_carbs = $request->totalcarbs;
      $diet->total_fats = $request->totalfats;
      $diet->percentage = $request->percent;
      if($diet->save())
      {

      $dietweb = new Userdietweb;

      $dietweb->userid = $userid;      
      $dietweb->proteins = $request->proteins;
      $dietweb->carbs = $request->carbs;
      $dietweb->fats = $request->fats;
      $dietweb->calories = $request->calories;
      $dietweb->total_proteins = $request->totalproteins;
      $dietweb->total_carbs = $request->totalcarbs;
      $dietweb->total_fats = $request->totalfats;
      $dietweb->percentage = $request->percent;
      $dietweb->save();
      $dietdata  =  Userdiet::find($diet->id);
      }
   }       
      if($dietdata){
        $userdetails = User::where('id',$userid)->first();
        $coachdetails = User::where('id',$coach_id)->first();
        $result['success'] = TRUE;
        $result['diet'] = $dietdata;
        $result['diet']['user'] =  $userdetails;
        $result['diet']['user']['coach'] =  $coachdetails;
        $result['message'] = "Diet saved successfully";
      }
      else
      {
        $result['success'] = TRUE;
        $result['message'] = "Something went wrong";
      }
    }
    catch (\Exception $e) {
      $result = [
            'message'=> $e->getMessage(). ' Line No '. $e->getLine() . ' In File'. $e->getFile()
        ];
      Log::error($e->getTraceAsString());
      $result['success'] = FALSE;
    }  
    return $result; 
  }

  public function getbenchmark()
  {
    $userid = Auth::id();

    $heros = Workout::where('type','Benchmark')->where('subtype','Heros')->paginate(10);   

    foreach ($heros as $key => $hero) {    
      $mylogresult = Userworkout::where('userid',$userid)->where('workoutid',$hero['id'])->first();      
      
      if($mylogresult)
      {
        $hero['has_logresults'] = true;
        $hero['mylogresults'] =  $mylogresult;
      }
      else
      {
        $hero['has_logresults'] = false;   
        $hero['mylogresults'] =  null;
      } 
     
      /*foreach ($hero->getuser as $key1 => $value1) {
        $gender = User::where('id',$value1->userid)->value('gender');
      $worklike = Workoutlike::where('workoutid',$hero->workoutid)->where('userid',$value1->userid)->where('likebyuserid',$userid)->first();
       if($worklike)
      {
        $heros[$key]->getuser[$key1]["is_mylike"] = TRUE;          
      }
      else
      {
        $heros[$key]->getuser[$key1]["is_mylike"] = FALSE;        
      }
      
      $likes = Workoutlike::where('workoutid',$hero->workoutid)->where('userid',$value1->userid)->count();

      $comments = Workoutcomment::where('workoutid',$hero->workoutid)->where('userid',$value1->userid)->count();

          $heros[$key]->getuser[$key1]["likes"] = $likes;
          $heros[$key]->getuser[$key1]["gender"] = $gender;
          $heros[$key]->getuser[$key1]["comments"] =  $comments;
        }*/
      } 

    $girls = Workout::where('type','Benchmark')->where('subtype','Girls')->paginate(10);

     foreach ($girls as $key => $girl) {    
      $mylogresult = Userworkout::where('userid',$userid)->where('workoutid',$girl['id'])->first();      
      
      if($mylogresult)
      {
        $girl['has_logresults'] = true;
        $girl['mylogresults'] =  $mylogresult;
      }
      else
      {
        $girl['has_logresults'] = false;   
        $girl['mylogresults'] =  null;
      } 
     /*
      foreach ($girl->getuser as $key1 => $value1) {
          $gender = User::where('id',$value1->userid)->value('gender');
      $worklike = Workoutlike::where('workoutid',$girl->workoutid)->where('userid',$value1->userid)->where('likebyuserid',$userid)->first();
       if($worklike)
      {
        $girls[$key]->getuser[$key1]["is_mylike"] = TRUE;          
      }
      else
      {
        $girls[$key]->getuser[$key1]["is_mylike"] = FALSE;        
      }
      
      $likes = Workoutlike::where('workoutid',$girl->workoutid)->where('userid',$value1->userid)->count();

      $comments = Workoutcomment::where('workoutid',$girl->workoutid)->where('userid',$value1->userid)->count();

          $girls[$key]->getuser[$key1]["likes"] = $likes;
          $girls[$key]->getuser[$key1]["gender"] = $gender;
          $girls[$key]->getuser[$key1]["comments"] =  $comments;
        }*/
      } 

    $complete = Workout::where('type','Benchmark')->where('subtype','Complete')->paginate(10); 

     foreach ($complete as $key => $comp) {    
      $mylogresult = Userworkout::where('userid',$userid)->where('workoutid',$comp['id'])->first();      
      
      if($mylogresult)
      {
        $comp['has_logresults'] = true;
        $comp['mylogresults'] =  $mylogresult;
      }
      else
      {
        $comp['has_logresults'] = false;   
        $comp['mylogresults'] =  null;
      } 
     
      /*foreach ($comp->getuser as $key1 => $value1) {
          $gender = User::where('id',$value1->userid)->value('gender');
      $worklike = Workoutlike::where('workoutid',$comp->workoutid)->where('userid',$value1->userid)->where('likebyuserid',$userid)->first();
       if($worklike)
      {
        $complete[$key]->getuser[$key1]["is_mylike"] = TRUE;          
      }
      else
      {
        $complete[$key]->getuser[$key1]["is_mylike"] = FALSE;        
      }
      
      $likes = Workoutlike::where('workoutid',$girl->workoutid)->where('userid',$value1->userid)->count();

      $comments = Workoutcomment::where('workoutid',$girl->workoutid)->where('userid',$value1->userid)->count();

          $girls[$key]->getuser[$key1]["likes"] = $likes;
          $girls[$key]->getuser[$key1]["gender"] = $gender;
          $girls[$key]->getuser[$key1]["coments"] =  $comments;
        }*/
      } 
    
    if(count($heros)>0 ||count($girls)>0 ||count($complete)>0)
    {
      $otherworkouts['Heros']['allworkouts'] = $heros;
      $otherworkouts['Girls']['allworkouts'] = $girls;
      $otherworkouts['Complete']['allworkouts'] = $complete;
      $otherworkouts['success'] = TRUE;
      $otherworkouts['message'] = "Benchmarks Listed successfully";
    }
    else
    {
      $otherworkouts['Heros']['allworkouts'] = array();
      $otherworkouts['Girls']['allworkouts'] = array();
      $otherworkouts['Complete']['allworkouts'] = array();
      $otherworkouts['success'] = TRUE;
      $otherworkouts['message'] = "No Benchmarks found";
    }  
    //return $this->paginate($otherworkouts);  
    return $otherworkouts;
  }
  public function getbarbell()
  {
    $userid = Auth::id();
    $barbells = Workout::where('type','Barbell PRs')->paginate(10);    

     
     foreach ($barbells as $key => $bell) { 
      $mylogresult = Userworkout::where('userid',$userid)->where('workoutid',$bell['id'])->first();      
      
      if($mylogresult)
      {
        $bell['has_logresults'] = true;
        $bell['mylogresults'] =  $mylogresult;
      }
      else
      {
        $bell['has_logresults'] = false;   
        $bell['mylogresults'] =  null;
      } 
     
     /* foreach ($bell->getuser as $key1 => $value1) {
        $gender = User::where('id',$value1->userid)->value('gender');
      $worklike = Workoutlike::where('workoutid',$bell->workoutid)->where('userid',$value1->userid)->where('likebyuserid',$userid)->first();

       if($worklike)
      {
        $barbells[$key]->getuser[$key1]["is_mylike"] = TRUE;          
      }
      else
      {
        $barbells[$key]->getuser[$key1]["is_mylike"] = FALSE;        
      }
      
      $likes = Workoutlike::where('workoutid',$bell->workoutid)->where('userid',$value1->userid)->count();

      $comments = Workoutcomment::where('workoutid',$bell->workoutid)->where('userid',$value1->userid)->count();

          $barbells[$key]->getuser[$key1]["likes"] = $likes;
          $barbells[$key]->getuser[$key1]["gender"] = $gender;
          $barbells[$key]->getuser[$key1]["coments"] =  $comments;
        }*/
      } 
   
    if(count($barbells)>0)
    {
      $otherworkouts['Barbell']['allworkouts'] = $barbells;
      $otherworkouts['success'] = TRUE;
      $otherworkouts['message'] = "Barbells Listed successfully";
    }
    else
    {
      $otherworkouts['Barbell']['allworkouts'] = (object)array();
      $otherworkouts['success'] = TRUE;
      $otherworkouts['message'] = "No Barbells found";
    }    
    return $otherworkouts;
  }

  public function addprogresspic(Request $request)
  {
    $userid = Auth::id();

    try{
       $rules = [ 
        'type' =>'required'        
      ];
      $validator = Validator::make($request->all(), $rules);
      if($validator->fails())
      {
        return response()->json([
         "message" => "Something went wrong!",
         "success"=>FALSE,
         'errors' => $validator->errors()->toArray(),
        ], 422);               
      } 
        $type = $request->type;
        $user_id = $userid;
        $picid = array();
      foreach( $request->images as $key=>$image ){
        $pics = new Progresspics;
        $pics->type = $type;
        $pics->userid = $user_id;
        if (!file_exists( public_path('/progresspics'))) {
            mkdir(public_path('/progresspics'), 0777, true);
          }
          $path =public_path('/progresspics/');
          $image1 = $image; 
          $input['imagename'] = time().rand(10,10000).$key.'.'.$image1->getClientOriginalExtension();
          $destinationPath = public_path('/progresspics');
          $image->move($destinationPath, $input['imagename']);
          $pics->image  =  $input['imagename'];
       
        $pics->save();
        array_push($picid,$pics->id);
      }
      
     // $userdetails = User::where('id',$userid)->first();
      if(count($picid)>0)
      {
        $userpicdata = Progresspics::whereIn('id',$picid)->get();        
        $result['userpicdata'] = $userpicdata;
        //$result['userdetails'] =  $userdetails;
        $result['success'] = TRUE;
        $result['message'] = "Image saved successfully"; 
      }
      else
      {        
        $result['userpicdata'] = array();
       // $result['userdetails'] =  $userdetails;
        $result['success'] = TRUE;
        $result['message'] = "Something went wrong"; 
      }   
    }
    catch (\Exception $e) {
      $result = [
        'message'=> $e->getMessage(). ' Line No '. $e->getLine() . ' In File'. $e->getFile()
        ];
      Log::error($e->getTraceAsString());
      $result['success'] = FALSE;
    } 
     return $result;
  } 

   public function deleteprogresspic(Request $request)
  {
    $userid = Auth::id();

    try{
       $rules = [ 
        'id' =>'required'        
      ];
      $validator = Validator::make($request->all(), $rules);
      if($validator->fails())
      {
        return response()->json([
         "message" => "Something went wrong!",
         "success"=>FALSE,
         'errors' => $validator->errors()->toArray(),
        ], 422);               
      }
      Progresspics::where('id',$request->id)->delete();
      $picexists = Progresspics::find($request->id);
      if($picexists) {

        $result['success'] = TRUE;
        $result['message'] = "Something went wrong!!";
      }      
      else
      { 
        $result['success'] = TRUE;
        $result['message'] = "Image deleted successfully";
      }   
    }
    catch (\Exception $e) {
      $result = [
        'message'=> $e->getMessage(). ' Line No '. $e->getLine() . ' In File'. $e->getFile()
        ];
      Log::error($e->getTraceAsString());
      $result['success'] = FALSE;
    } 
     return $result;
  } 
  public function getallprogresspic()
  {
   
    $userid = Auth::id();
    try{
      $frontpics = Progresspics::where('type',1)->where('userid',$userid)->get();
      $backpics = Progresspics::where('type',2)->where('userid',$userid)->get();
      $sidepics = Progresspics::where('type',3)->where('userid',$userid)->get();
      if(count($frontpics)>0 ||count($backpics)>0 ||count($sidepics)>0)
      {
        $result['front'] = $frontpics;
        $result['back'] = $backpics;
        $result['side'] = $sidepics;
        $result['success'] = TRUE;
        $result['message'] = "Images listed successfully";
      }
      else
      {
        $result['success'] = TRUE;
        $result['message'] = "No images found";
      }
    }
    catch (\Exception $e) {
      $result = [
        'message'=> $e->getMessage(). ' Line No '. $e->getLine() . ' In File'. $e->getFile()
        ];
      Log::error($e->getTraceAsString());
      $result['success'] = FALSE;
    } 
    return $result;
  }

  public function logout(Request $request)
  {
   try{
        $id = Auth::id();          
        $request->user()->token()->revoke();
        User::where('id',$id)->update(['device_token'=>'']);
        $result['success']=TRUE;  
        $result['message'] = "User logged out successfully";      
      }
      catch (\Exception $e) {
        $result = [
          'error' => $e->getMessage() . ' Line No ' . $e->getLine() . ' in File' . $e->getFile()
        ];
        $result['success'] = FALSE;
        Log::error($e->getTraceAsString());
      }
    return $result;
  }

  public function deleteaccount()
  {
    $id = Auth::id(); 
    try{   
      User::where('id',$id)->delete();
      $userid = User::where('id',$id)->first();
      if($userid){
        $result['success'] = false;
        $result['message'] =  "Account not deleted";
      }
      else{
        $result['success'] = True;
        $result['message'] =  "Account deleted successfully";
      }
    }
    catch (\Exception $e) {
        $result = [
          'error' => $e->getMessage() . ' Line No ' . $e->getLine() . ' in File' . $e->getFile()
        ];
        $result['success'] = FALSE;
        Log::error($e->getTraceAsString());
      }
    return $result;
  }

  public function getuserdetails()
  {
    try{
      $userid = Auth::id();
      $user = User::where('id',$userid)->first();
      $coach_id = User::where('id',$userid)->value('coach_id');
      $userid = Auth::user()->id;
      $user->coach_details = User::select('id','name','email','phone','role','created_at','updated_at','image','gender','state','city','country','zipcode','bio')->where('id',$coach_id)->first();
      $result['message'] = 'User Details listed successfully.';
      $result['user'] = $user;
      $result['success'] = true;
    }
    catch (\Exception $e) {
      $result = [
        'error' => $e->getMessage() . ' Line No ' . $e->getLine() . ' in File' . $e->getFile()
      ];
      $result['success'] = FALSE;
      Log::error($e->getTraceAsString());
    }
    return $result;
  }

  public function changepassword(Request $request)
  {
    $userid = Auth::id();
    try{
       $rules = [ 
        'email' =>'required'        
      ];
      $validator = Validator::make($request->all(), $rules);
      if($validator->fails())
      {
        return response()->json([
         "message" => "Something went wrong!",
         "success"=>FALSE,
         'errors' => $validator->errors()->toArray(),
        ], 422);  
      }
      $user = User::where('email', $request->get('email'))->first();

      if (!isset($user) || $validator->fails() || !$user->exists())
      {
        $result['message'] = 'Enter an valid email address';
        $result['success'] = False;
        return $result;
      }
         
      $encodeduserid = base64_encode($userid);
      $username = User::where('id',$userid)->value('name'); 
      $url = URL::to('/').'/changepassword'.'/'. $encodeduserid;
      Mail::to($user->email)->send(new ResetPassword($encodeduserid,$username,$url));
      if (Mail::failures()) {
        $result['message'] = 'Email not sent';
        $result['success'] = False;
        return $result;
      }
      else
      {
        $result['message'] = 'A Email Has Been Sent To The Email Provided. Please Check Your Email.';
        $result['success'] = True;
        return $result;
      }
    }
    catch (\Exception $e) {
      $result = [
        'error' => $e->getMessage() . ' Line No ' . $e->getLine() . ' in File' . $e->getFile()
      ];
      $result['success'] = FALSE;
      Log::error($e->getTraceAsString());
    }
  } 
  public function resetpassword(Request $request)
  {  
    try{
      $rules = [ 
        'email' =>'required'        
      ];
      $validator = Validator::make($request->all(), $rules);
      if($validator->fails())
      {
        return response()->json([
         "message" => "Something went wrong!",
         "success"=>FALSE,
         'errors' => $validator->errors()->toArray(),
        ], 422);  
      }
      $user = User::where('email', $request->get('email'))->first();
      if($user){
        $username = User::where('email',$request->get('email'))->value('name');
        $random_pass = $this->generaterandomstring();
        Mail::to($user['email'])->send(new ChangePassword($username,$random_pass));
        if (Mail::failures()) {
          $result['message'] = 'Email not sent';
          $result['success'] = False;
          return $result;
      }
      else
      {
        $result['message'] = 'Password reset link successfully sent on your email. Please check your email to change your password';
        $result['success'] = True;
        User::where('email',$request->get('email'))->update(['password'=>bcrypt($random_pass)]);
        return $result;
      }   
      }
      else
      {
        $result['message'] = 'user not found';
        $result['success'] = False;
      }       
    }
    catch(Exception $e)
    {
      $result = [
        'error'=> $e->getMessage(). ' Line No '. $e->getLine() . ' In File'. $e->getFile()
      ];
      Log::error($e->getTraceAsString());
      $result['success'] = FALSE;
    }
    return $result;
  }

  function generaterandomstring() {
    $length = 6;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
  }

  public function deleteuserworkout(Request $request)
  {
    try{
      $rules = [ 
        'id' =>'required'        
      ];
      $validator = Validator::make($request->all(), $rules);
      if($validator->fails())
      {
        return response()->json([
         "message" => "Something went wrong!",
         "success"=>FALSE,
         'errors' => $validator->errors()->toArray(),
        ], 422);  
      }
      $user = Userworkout::where('id', $request->get('id'))->first();
      $workoutid = Userworkout::where('id', $request->get('id'))->value('workoutid');
      Workout::where('id',$workoutid)->decrement('results');
      if($user){
        Userworkout::where('id', $request->get('id'))->delete();
        $workoutexists =  Userworkout::find($request->id);
       if($workoutexists)
       {
          $result['message'] = "User Workout not deleted";
          $result['success']= false;
        }
       else
       {
         $result['message'] = "User Workout deleted";
         $result['success']= true;
        }        
      }
      else
      {
        $result['message'] = "No user workout found";
        $result['success']= true;
      } 
    }
    catch(Exception $e)
    {
      $result = [
        'error'=> $e->getMessage(). ' Line No '. $e->getLine() . ' In File'. $e->getFile()
      ];
      Log::error($e->getTraceAsString());
      $result['success'] = False;
    }
    return $result;
  }


   public function editcoachprofile(Request $request)
  {
    $userid = Auth::id();
    $user = Auth::user();
    try{
      
      if($request->has('name')&& $request->get('name')!=""){
        $user->name = $request->name;
      }
      if($request->has('dob')&& $request->get('dob')!=""){
        $user->dob = $request->dob;
      }
      if($request->has('phone')&& $request->get('phone')!=""){
        $user->phone = $request->phone;
      }
      if($request->has('country')&& $request->get('country')!=""){
        $user->country = $request->country;
      }
      if($request->has('city')&& $request->get('city')!=""){
        $user->city = $request->city;
      }
      if($request->has('state')&& $request->get('state')!=""){
        $user->state = $request->state;
      }
       if($request->has('zipcode')&& $request->get('zipcode')!=""){
        $user->zipcode = $request->zipcode;
      }
      if($request->has('bio')&& $request->get('bio')!=""){
        $user->bio = $request->bio;
      }
       if($request->has('email')&& $request->get('email')!=""){
        $user->email = $request->email;
      }
       if($request->has('gender')&& $request->get('gender')!=""){
        $user->gender = $request->gender;
      }
      if($request->has('profile')&& $request->file('profile')!=""){
        $rules = [
          'profile'=>'image|mimes:jpeg,png,jpg,gif,svg'
        ];
        
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails())
        {
          return response()->json([
           "message" => "Something went wrong!",
           "success"=>FALSE,
           'errors' => $validator->errors()->toArray(),
          ], 422);               
        }   
        if (!file_exists( public_path('/images'))) {
          mkdir(public_path('/images'), 0777, true);
        }
        $path =public_path('/images/');
        $image = $request->file('profile');
        $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path('/images');
        $image->move($destinationPath, $input['imagename']);
        $user->image  =  $input['imagename'];        
      }
     
      if($user->save())
      {
        $user = User::where('id',$userid)->first();
        $result['success'] = TRUE;
        $result['user'] = $user;
        $result['message'] = "profile Updated successfully";
      }
      else
      {
        $result['success'] = TRUE;
        $result['message'] = "Something went wrong";
      }
    }
    catch (\Exception $e) {
      $result = [
            'message'=> $e->getMessage(). ' Line No '. $e->getLine() . ' In File'. $e->getFile()
        ];
      Log::error($e->getTraceAsString());
      $result['success'] = FALSE;
    }  
    return $result; 
  }

  public function notificationscount()
  {
    $userid = Auth::id();
    try{
      $notificationscount= Notification::where('otheruserid',$userid)->where('readstatus',0)->count();
      $messagecount =  Chat::where('receiver_id',$userid)->where('readstatus',0)->count();
        $result['success'] = TRUE;
        $result['messagecount'] = $messagecount;
        $result['notificationscount'] = $notificationscount;
        $result['message'] = "success";
     
    }
    catch (\Exception $e) {
      $result = [
            'message'=> $e->getMessage(). ' Line No '. $e->getLine() . ' In File'. $e->getFile()
        ];
      Log::error($e->getTraceAsString());
      $result['success'] = FALSE;
    }  
    return $result; 
  }

  public function readnotification(Request $request)
  {
    $userid = Auth::id();
    try{
      $rules = [ 
          'type' =>'required'        
      ];
      $validator = Validator::make($request->all(), $rules);
      if($validator->fails())
      {
        return response()->json([
         "message" => "Something went wrong!",
         "success"=>FALSE,
         'errors' => $validator->errors()->toArray(),
        ], 422);  
      }    
     
      if($request->type==1){
        $notificationscount= Notification::where('otheruserid',$userid)->where('readstatus',0)->update(['readstatus'=>1]);
      }
     else if($request->type==2){
        $messagecount =  Chat::where('receiver_id',$userid)->where('readstatus',0)->update(['readstatus'=>1]);
     }

      $notificationscount= Notification::where('otheruserid',$userid)->where('readstatus',0)->count();
      $messagecount =  Chat::where('receiver_id',$userid)->where('readstatus',0)->count();
    
      $result['success'] = TRUE;
      $result['messagecount'] = $messagecount;
      $result['notificationscount'] = $notificationscount;
      $result['message'] = "success";
    }
    catch (\Exception $e) {
      $result = [
            'message'=> $e->getMessage(). ' Line No '. $e->getLine() . ' In File'. $e->getFile()
        ];
      Log::error($e->getTraceAsString());
      $result['success'] = FALSE;
    }  
    return $result;
  }

public function test()
{
  $serverkey = 'AAAAwfR2gGQ:APA91bGztP8eKKQ5UoGgBLpqRH7rCPoeBSxLySnwbYJrLpobaUvLC7dMoe0vUYRiaAHI8M_wFWAYYE-f_XpsdmpfTbKXX5ycJqiiy9kS3i_58AEAzsRaYxm3sI-anPrWjpiA6R6lYY-p';
   $url = 'https://fcm.googleapis.com/fcm/send';
   $fields = array(
    'to' => 'fRy_-b17rI0:APA91bGo1Fwm-D7gxEfn9JwjAFHNan3UQJiVAWHsJa60--BCIwyc7UnLooeV5-aP7VRwE-BS8tPOBS88CWJW3SfUbVQMVX7UD7TzE3aLmK1bCwW8lpHtuVHE9mojPeW2ZRW0wsUz_BNs',
              'notification' => array('title' => 'comment', 'body' =>  "test" ,'sound'=>'Default')           
            );
          
  $headers = array(
    'Authorization: key=' . $serverkey,
    'Content-Type: application/json'
  );
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
  curl_exec($ch);
  curl_close($ch);            
}

  public function readchatmessage(Request $request)
  {
    $loginuserid = Auth::id();

    try{
          $rules = [ 
              'userid' =>'required'        
          ];
          $validator = Validator::make($request->all(), $rules);
          if($validator->fails())
          {
            return response()->json([
             "message" => "Something went wrong!",
             "success"=>FALSE,
             'errors' => $validator->errors()->toArray(),
            ], 422);  
          } 
         Chat::whereRaw('(sender_id ="' . $loginuserid . '" AND receiver_id ="' .
          $request->userid . '") OR (sender_id ="'.$request->userid.'" AND receiver_id ="'.$loginuserid.'")')->orderBy('id','desc')
        ->take(1)
        ->update(['messageread' => 1]);
        $result['success'] = TRUE;
        } 

        catch (\Exception $e) {
        $result = [
              'message'=> $e->getMessage(). ' Line No '. $e->getLine() . ' In File'. $e->getFile()
          ];
        Log::error($e->getTraceAsString());
        $result['success'] = FALSE;
      } 
      return $result;    
  }

} 
