<?php

namespace App\Http\Controllers\Backend;
use App\User;
use App\Workout;
use App\Progresspics;
use App\Userworkout;
use App\Workoutcomment;
use App\Workoutlike;
use App\Userdiet;
use App\Userdietweb;
use App\Workoutplace;
use VideoThumbnail;
use Redirect;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Hash;
use Auth;
use App\Chat;
use App\Video;
use DB;
use FFMpeg;
use URL;

class UserController extends Controller
{
  public function ath_list()
  {
    $user = Auth::user();
    $role = Auth::user()->role;
    $id = Auth::user()->id;
    $coachName = User::where('role',0)->pluck('name', 'id')->toArray();
    //return $coachName;
    if($role==2)
    $allathletes = User::where('role',1)->orderBy('id', 'DESC')->get();
    else
    $allathletes = User::where('role',1)->where('coach_id',$id)->orderBy('id', 'DESC')->get();


    $user = 'athlete';
    return view('backend.users.athlist')->with(compact('allathletes', 'coachName','user','role'));
  }
  public function coach_list()
  {
    $allcoach = User::where('role',0)->orderBy('id', 'DESC')->get();
    $user = 'coach';
    return view('backend.users.coachlist')->with(compact('allcoach','user'));
  }
   public function user_data(Request $request)
  { 
    $user = $request->user;  
    if($request->has('id') && $request->get('id')!=""){
      $id = $request->id;    
      $athdata = User::where('id',$request->id)->first();
      $type = 'edit';
    }     
     $coachName = User::where('role',0)->pluck('name', 'id')->toArray();
    return view('backend.forms.addedituser')->with(compact('coachName','athdata','type','user'))->render();
  }
  public function save_user_data(Request $request)
  {

   
    if($request->has('athedit') && $request->get('athedit')!="")
    {
      $user = User::find($request->athedit);
      if($user['role']==1)
        $message = "Athlete edited successfully";
     else if($user['role']==0)
      $message = "Coach edited successfully";

      $user->height = $request->height;
    }
    else{

      $user = new User();
      $user->password = bcrypt($request->password);

      if($request->height_ft!="")
        {
          
          $ft = $request->height_ft*12;         
        }
        else
        {
          $ft = 0;
        }
        if($request->height_in!="")
        {
          $in = $request->height_in;
        }
        else
        {
          $in = 0;
        }

        $user->height = $ft+$in;
       
       
        $message = "Athlete added successfully";

      } 
      if($request->has('usertype') && $request->get('usertype')=="athlete"){
        if($request->has('coachathleteid') && $request->get('coachathleteid')!="")
          $user->coach_id = $request->coachathleteid; 
        else
          $user->coach_id = $request->coach; 
        $user->role = 1;
        if($request->file('cover_image')!= "" || $request->has('cover_image')){
          $path =public_path('/images/');
          $image = $request->file('cover_image');
          $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
          $destinationPath = public_path('/images');
          $image->move($destinationPath, $input['imagename']);
          $user->cover_image =  $input['imagename'];
        } 
        $user->age = $request->age;
        $user->weight = $request->weight; 
      }
      if($request->has('usertype') && $request->get('usertype')=="coach"){
        $user->role = 0;
        $user->state = $request->state;
        $user->city = $request->city;
        $user->country = $request->country;
        $user->zipcode = $request->zipcode;
        $user->phone = $request->phone;
        $user->bio = $request->bio;
        
      if($request->has('athedit') && $request->get('athedit')!="")
      {

      $user = User::find($request->athedit);        
      $message = "Coach edited successfully";
      }
      else
        $message = "Coach added successfully";
      }
     
      $user->name = $request->name;
      $user->email = $request->email;
      $user->gender = $request->gender;
      $user->dob = $request->dob;

      if(($request->tracks)!="")
      $user->tracks =  "1,".implode(",",$request->tracks);
    else
      $user->tracks =  1;
    
    if($request->file('image')!= "" || $request->has('image')){
     if (!file_exists( public_path('/images'))) { 
        mkdir(public_path('/images'), 0777, true);
      }
      $path =public_path('/images/');
      $image = $request->file('image');
      $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
      $destinationPath = public_path('/images');
      $image->move($destinationPath, $input['imagename']);
      $user->image  =  $input['imagename'];
    } 
    $user->save();
    /*if($request->get('athedit')=="" && $user->role==1)
    {
      $chat = new Chat;
      $chat->sender_id = $user->id;
      $chat->receiver_id = $user->coach_id;
      $chat->type = 1;
      $chat->sender_receiverid = $user->id.'_'.$chat->receiver_id;
      $chat->readstatus = 1;
      $chat->messageread = 1;
      $chat->save();
    }*/
   
     if($request->get('athedit')!="" && $user->role==1)
    {

      $user = User::find($request->athedit);
      $userid = $user->id;
      $coachid = $request->coachathid;

      if($user['coach_id']!= $request->coachathid){

         $serverkey = 'AAAAwfR2gGQ:APA91bGztP8eKKQ5UoGgBLpqRH7rCPoeBSxLySnwbYJrLpobaUvLC7dMoe0vUYRiaAHI8M_wFWAYYE-f_XpsdmpfTbKXX5ycJqiiy9kS3i_58AEAzsRaYxm3sI-anPrWjpiA6R6lYY-p';
         $tokens = User::select('device_token')->where('id',$userid)->first();
        $device_type = User::select('device_type')->where('id',$userid)->first();

        if($tokens){  

        Chat::where(function ($query) use ($userid) {
         $query->where('sender_id','=',$userid)
          ->orWhere('receiver_id','=', $userid);
        })
        ->where(function ($query) use ($coachid) {
             $query->where('sender_id','=',$coachid )
                  ->orWhere('receiver_id','=', $coachid);
        })->update(['coacheditstatus'=>1]);

        $url = 'https://fcm.googleapis.com/fcm/send';
        if($device_type['device_type']==1)
        {
        
           $fields = array(
            'to' => $tokens['device_token'],
            'notification' => array('title' => 'dummy', 'body' =>  '' ,'sound'=>'Default','type'=>101)           
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
       
        $fields = array(
            'to' => $tokens['device_token'],
            'notification' => array('title' => 'dummy', 'body' =>  '' ,'sound'=>'Default','type'=>101)           
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
      

        
        /*$chat = new Chat;
        $chat->sender_id = $user->id;
        $chat->receiver_id = $user->coach_id;
        $chat->type = 1;
        $chat->readstatus = 1;
        $chat->messageread = 1;

        $chat->sender_receiverid = $user->id.'_'.$chat->receiver_id;
        $chat->save();*/
      }

    }
    return redirect::back()->with('success', $message);
  }
  public function delete_athlete(Request $request){
    $id = $request->id;
    $user = User::find($id);       
    $user->delete();
    if(($user->image && file_exists(public_path('images').'/'.$user->image)))
    {
      unlink(public_path('/images').'/'.$user->image);
    } 
    $user = User::find($id); 
    if($user){ return 0;}
    else return 1;
  }
  public function delete_coach(Request $request){
    $id = $request->id;
    $user = User::find($id);       
    $user->delete();
    if(($user->image && file_exists(public_path('images').'/'.$user->image)))
    {
      unlink(public_path('/images').'/'.$user->image);
    } 
    $user = User::find($id); 
    if($user){ return 0;}
    else return 1;
  }
  public function delete_workout(Request $request){
    $id = $request->id;
    $workout = Workout::find($id);       
    $workout->delete();    
    $user = Workout::find($id); 
    if($user){ return 0;}
    else return 1;
  }
   public function delete_video(Request $request){
    $id = $request->id;
    $workout = Video::find($id);       
    $workout->delete();    
    $user = Video::find($id); 
    if($user){ return 0;}
    else return 1;
  }
   public function delete_place(Request $request){
    $id = $request->id;
    $user = Workoutplace::find($id);       
    $user->delete();
    $user = Workoutplace::find($id); 
    if($user){ return 0;}
    else return 1;
  }

  public function checkemail(Request $request)
  {
    $email = $request->email;
    $emailvalue = User::where('email',$email)->first();
    if($emailvalue){  return 1; }
    else { return 0;}
  }

  public function workout_add(Request $request,$athid=null,$type=null)
  { 

    $id = Auth::user()->id;
    $role = Auth::user()->role;
    $type = $type;
    $athid = $athid;
    $allathletes = User::where('role',1)->where('coach_id',$id)->get();
    return view('backend.forms.addworkout')->with(compact('allcoach','user','allathletes','type','athid'));
  }
  public function workoutplace_add(Request $request)
  {
    $allplaces = Workoutplace::orderBy('title')->get();
    if($request->isMethod('post')){
      $place = new Workoutplace;
      $place->title = $request->placetitle;
      if($place->save())
      {
        $allplaces = Workoutplace::orderBy('title')->get();;
        $view = view('backend.users.saveworkoutplace',compact('allplaces'))->render();
    return response()->json(['html'=>$view]); 
      }
    }

       return view('backend.forms.addworkoutplace')->with(compact('allplaces'));
   
  }
  
  public function save_workout(Request $request)
  { 
    $userid = Auth::user()->id;
    $role = Auth::user()->role;
    if($request->has('editworkout')&& $request->get('editworkout')=='edit')
    {
      $id = $request->editworkoutid;
     
      $work = Workout::find($id);
        
    }
    else{
      $work = new Workout;
    }
    $work->title = $request->title;
    $work->description = $request->description;
    $work->prepare = $request->notes;
    $work->workout_date = $request->workoutdate;
    $work->category = $request->workoutcategory;
    $work->scoring_type = $request->workoutscore;
   
    $work->assigned_by = $userid;
    //$work->assigned_to = $request->athleteworkout;
    if($request->athid !="")
    $work->assigned_to = base64_decode($request->athid);
  else
  $work->assigned_to = $request->athleteworkout;
    
    if($request->workouttype ==1)
      $work->type = 'simple';
    else if($request->workouttype ==2)
      $work->type = 'Benchmark';
    else if($request->workouttype ==3)
      $work->type = 'Barbell PRs';   

    if($request->has('workoutsubtype') && $request->get('workoutsubtype')!="")
      $work->subtype = $request->workoutsubtype;

    /*if($request->file('videofile')!= "" || $request->has('videofile')){
     if (!file_exists( public_path('/workouts'))) { 
        mkdir(public_path('/workouts'), 0777, true);
      }
      $path =public_path('/workouts');
      $image = $request->file('videofile');
      $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
      $destinationPath = public_path('/workouts');
      $image->move($destinationPath, $input['imagename']);
      $work->videofile  =  $input['imagename'];
       if (!file_exists( public_path('/thumbnails'))) { 
        mkdir(public_path('/thumbnails'), 0777, true);
      }
       $upload_path = public_path('/thumbnails');
       $thumbnailName = time().'.jpg';
       VideoThumbnail::createThumbnail(public_path('workouts/'.$input['imagename']), public_path('/thumbnails'), $thumbnailName, 2, 192, 108);
      $work->videoimage = $thumbnailName;
    } */   
    if($work->save())
    {
      if($request->typeworkout=="personalworkout")
      {
       return 2;
      }
      return 1;
    }
    else
    {
      return 0;
    }   
  }

  public function workout_listing(Request $request)
  {
    $user = Auth::user();
    $role = Auth::user()->role;
    $id = Auth::user()->id;
    if($role==0)
    {
      $allworkouts = Workout::where('assigned_by',$id)->orderBy('id', 'DESC')->get();
    }
    else
    $allworkouts = Workout::orderBy('id', 'DESC')->get();

    return view('backend.users.workoutlist')->with(compact('allworkouts'));
  }
  public function findworkout(Request $request)
  {
    $workdate = $request->workdate;
   // $date = date('Y-m-d', strtotime($workdate));
    $workdateexists = Workout::where('workout_date',$workdate)->first();
    if($workdateexists)
      return 0;
    else
      return 1;
  }
  public function editworkout(Request $request)
  {
    $user = Auth::user();
    $role = Auth::user()->role;
    $id = Auth::user()->id;
    $workout = Workout::where('id',$request->workid)->first();
    $allathletes = User::where('role',1)->where('coach_id',$id)->get();

    $view = view('backend.users.editworkout',compact('workout','allathletes'))->render();
    return response()->json(['html'=>$view]);  
  }

  public function changepassword(Request $request,$id)
  {
    if($request->get('userid') && $request->get('userid')!="")
    {
      $rules = [ 
       'newpassword' =>'required',   
       'confirmpassword' => 'required|required_with:newpassword|same:newpassword'  
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
          $res = [                
            'error' => $validator->errors()->all(),
          ];
        return Redirect::back()->withErrors($res);
        }
        $userid = base64_decode($id);

        User::where('id',$userid)->update(['password'=>bcrypt($request->newpassword)]);
        $success = "Password changed successfully";
        return redirect()->back()->with('message', $success);
     }      
    return view('changepassword')->with(compact('id'));
  }
  public function viewuserinfo(Request $request,$id,$type = null)
  {
    $athid = base64_decode($id);
    $type = $request->type;
    $role  = User::where('id',$athid)->value('role');
    $coachid = User::where('id',$athid)->value('coach_id'); 
    $coachName = User::where('id',$coachid)->value('name');
    $athletedata = User::where('id',$athid)->get();
    $user = 'athlete';
    return view('backend.users.personalinfo')->with(compact('coachName','athletedata','role','type','coachid'));
  }

  public function viewuserimages(Request $request,$id)
  {
    $userid = base64_decode($id);
    $pics = Progresspics::select('image')->where('userid',$userid)->get();
    $firstpic = Progresspics::select('image')->where('userid',$userid)->first();
    return view('backend.users.userprogresspics')->with(compact('pics','firstpic'));
  }

  public function viewusersworkout(Request $request,$id)
  {   
    $wrkid = base64_decode($id);
    $userwrk = Userworkout::where('workoutid', $wrkid)->get();
    $workname = Workout::select('title','id')->where('id', $wrkid)->first();
    $usernames = User::pluck('name','id');

    foreach ($userwrk as $key => $value) {
      $value->comm = Workoutcomment::where('userid',$value['userid'])->where('workoutid',$value['workoutid'])->count();
      $value->fives = Workoutlike::where('userid',$value['userid'])->where('workoutid',$value['workoutid'])->count();
    }
    
    return view('backend.users.userworkouts')->with(compact('userwrk','usernames','workname'));
  }
  public function viewuserscomments(Request $request,$userid,$workoutid)
  {       
    $useridcode = base64_decode($userid);
    $workoutcode = base64_decode($workoutid);
    $workid = $workoutid;

    $allcomments = Workoutcomment::where('userid',$useridcode)->where('workoutid',$workoutcode)->orderby('created_at','desc')->get();
    
    
    $usernames = User::pluck('name','id');
   
    return view('backend.users.usercomments')->with(compact('allcomments','userid','usernames','workid'));
  }
  public function viewnutritiondetails(Request $request)
  {  
    $useridcode = $request->userid;
    $datevalue = $request->caldate;    
    $diet = Userdietweb::where('userid',$useridcode)->whereDate('created_at',$datevalue)->first(); 
    $type = 0;
    if($diet)
      return view('backend.users.nutritionaccuracy')->with(compact('diet'));
    else
      return view('backend.users.nutritionaccuracy')->with(compact('type'));
  }
  public function viewnutritioncalender(Request $request)
  {    
    return $request->id;    
  }
  public function checkdatevalue(Request $request)
  {    
    $dateval = $request->dateval;   
    $diet = Userdietweb::where('userid',$request->userid)->whereDate('created_at',$dateval)->first(); 
    if($diet) 
      return 0;
    else
      return 1;
  }
  public function viewathletes(Request $request,$id)
  {
    $coach_id = base64_decode($id);
    $coach = 'coach';
    $athletes = User::where('coach_id',$coach_id)->orderby('id','DESC')->get();
    return view('backend.users.coachathletelisting')->with(compact('athletes','coach','coach_id'));
  }
  public function chatathlete(Request $request,$athleteid=null,$coachid=null)
  {

    if($request->has('type1'))
    {
      
      $coach_id = $request->coachid;
      $athlete_id = $request->athid;
    }
    else{

      $coach_id = base64_decode($coachid);
      $athlete_id = base64_decode($athleteid);
    }
    $allmessages = Chat::whereRaw('(sender_id ="' . $coach_id . '" AND receiver_id ="' .$athlete_id . '") OR (sender_id ="'.$athlete_id.'" AND receiver_id ="'.$coach_id.'")')->orderby('id','DESC')->take(10)->get()->reverse();
   
    $allmessagesno = Chat::whereRaw('(sender_id ="' . $coach_id . '" AND receiver_id ="' .$athlete_id . '") OR (sender_id ="'.$athlete_id.'" AND receiver_id ="'.$coach_id.'")')->count();
    $athname = User::where('id',$athlete_id)->value('name');
    $athimg = User::where('id',$athlete_id)->value('image');
    $coachimg = User::where('id',$coach_id)->value('image');
 
    if($request->has('type1')){
      $view = view('backend.users.athletechat',compact('allmessages','coach_id','athlete_id','allmessagesno','athname','athimg','coachimg'))->render();
      return response()->json(['html'=>$view]);  
    }
    else
    {      
      return view('backend.users.chatathlete')->with(compact('allmessages','coach_id','athlete_id','allmessagesno','athname','athimg','coachimg'));
    } 
  }
  public function savemessage(Request $request)
  {
    $chat = new Chat;
    $chat->sender_id = $request->coachid;
    $chat->receiver_id = $request->athid;
    $chat->type = $request->typemsg;
    $token = Chat::select('sender_receiverid')
    ->whereRaw('(sender_id ="' . $request->coachid . '" AND receiver_id ="' .$request->athid . '") OR (sender_id ="'.$request->athid.'" AND receiver_id ="'.$request->coachid.'")')->first();
    if($token){
      $chat->sender_receiverid = $token['sender_receiverid'];
    }
    else{
      $chat->sender_receiverid =  $request->coachid.'_'.$request->athid;
    }
     if($request->filename!= ""){        
        if (!file_exists( public_path('/attachments'))) {
            mkdir(public_path('/attachments'), 0777, true);
        }
        $path =public_path('/attachments/');
        $image = $request->filename;
        $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path('/attachments');
        $image->move($destinationPath, $input['imagename']);
        $chat->media  =  $input['imagename'];
      } 
      else{
       $chat->media = $request->message;
      }    
    $senderdetails = User::where('id',$request->coachid)->first();
    $receiverdetails = User::where('id',$request->athid)->first();
    
   $user_id = $request->athid;
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
      $username = User::where('id',$request->coachid)->value('name');
      if($request->typemsg==1){
        $message = $request->media; 
      }
      if($request->typemsg==2){
        $message =$username." sent you an image";
      }
      if($request->typemsg==3){
        $message =$username." sent you a video";
      }
      if($request->typemsg==4){
        $message =$username." sent you a file";
      }    
     $tokens = User::select('device_token')->where('id',$request->athid)->first();
    $device_type = User::select('device_type')->where('id',$request->athid)->first();
   
      if($tokens){     
      $url = 'https://fcm.googleapis.com/fcm/send';
      if($device_type['device_type']==1)
      {
        $fields = array(
          'to' => $tokens['device_token'],
          'data' => 
          array('title' => 'New Message', 
            'body' =>  $message ,
            'sound'=>'Default',
            'data' => $ios,
            'type'=> $iostype)           
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
         $notification = [
          'title' => 'New Message',
          'sound' => 'Default',
          "type"=> $iostype,                     
          "body" => $message,
          "data"=>  $ios    
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
      return 1;
    }
    else
    {
     return 0;
    }
  }

 
  public function video_upload(Request $request)
  {
    if ($request->isMethod('post')) {
      $video = new Video;
      if($request->file('videofile')!= "" || $request->has('videofile')){
       if (!file_exists( public_path('/workouts'))) { 
          mkdir(public_path('/workouts'), 0777, true);
        }
        $path =public_path('/workouts');
        $image = $request->file('videofile');
        $imagetime = time();
        $image_ext = $image->getClientOriginalExtension();
        $input['imagename'] =  $imagetime.'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path('/workouts');
        $image->move($destinationPath, $input['imagename']);
        $video->video  =  $input['imagename'];
         if (!file_exists( public_path('/thumbnails'))) { 
          mkdir(public_path('/thumbnails'), 0777, true);
        }
        $url = URL::to('/').'/workouts/'.$input['imagename'];
        $new_img = explode(".",$input['imagename']);
        $new_img1 = $new_img[0];
        if($image_ext !="mp4"){

          $ffmpeg = FFMpeg\FFMpeg::create(array(
          'ffmpeg.binaries' => '/usr/bin/ffmpeg',   
          'ffprobe.binaries' => '/usr/bin/ffprobe',
          'timeout' => 0, // The timeout for the underlying process
          'ffmpeg.threads' => 22, // The number of threads that FFMpeg should use
          ), @$logger);

          $video1 = $ffmpeg->open($url);

          $video1->save(new FFMpeg\Format\Video\X264('libmp3lame', 'libx264'),"workouts/".$imagetime.".mp4");
        }
        $input['imagename'] = $imagetime.".mp4";

         $upload_path = public_path('/thumbnails');
         $thumbnailName = time().'.jpg';
         VideoThumbnail::createThumbnail(public_path('workouts/'.$input['imagename']), public_path('/thumbnails'), $thumbnailName, 2, 192, 108);
        $video->thumbnail = $thumbnailName;
        $video->created_at = $request->videodate1;
        $video->video = $input['imagename'];
      } 
      if($video->save())
      {
        if($request->ajax())
        return response()->json(['success'=>"uploaded successfully"]);         
        return redirect::back()->with('success', "Video upload successfully");
      }
    }
    $videodata = Video::orderby('created_at','desc')->get();
    return view('backend.users.video')->with(compact('videodata'));
  }

  public function video_datecheck(Request $request)
  {
    $datedata = Video::wheredate('created_at',$request->dateval)->first();
    if($datedata)
      return 1;
    else
      return 0;
  }

  
}
