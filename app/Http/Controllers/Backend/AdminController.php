<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use auth;

class AdminController extends Controller
{
    public function index()
   {
    $user = Auth::user();
    $role = Auth::user()->role;
    $id = Auth::user()->id;
    if($role==2)
   	$athletes = User::where('role',1)->count();
    else
    $athletes = User::where('role',1)->where('coach_id',$id)->count();
    $coach = User::where('role',0)->count();
   	return view('backend.index')->with(compact('athletes','coach'));
   }
     public function admin_profile(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $this->validate($request, [
                'name' => 'required',
                // 'email' => 'required|email|max:255',
                'email' => 'email|unique:users,email,' . Auth::id(),
                // 'phone_number' => 'required|numeric|digits_between:8,12',
                'new_image'=>'mimes:jpeg,png,jpg,gif,svg|max:10000',
            ]);
            
            $user = User::where('id', Auth::id())->first();
            $user->name = $request->name;
            $user->email = $request->email;
            // $user->phone_number = $request->phone_number;
            
            if(!empty($request->new_password))
            {
                $user->password = bcrypt($request->new_password);
            }

            if(!empty($request->new_image))
            {
                $image = $request->new_image;
                if(!empty(Auth::user()->image) && file_exists(public_path('/images').'/'.Auth::user()->photo))
                {
                    unlink(public_path('/images').'/'.Auth::user()->image);
                }

                $new_name = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/images');
                $image->move($destinationPath, $new_name);               
                $user->image = $new_name;
            }

            if($user->save())
            {
                return redirect()->back()->with('success', 'Profile edited successfully.');
            }
        }
        return view('backend.profile');
    }
     public function password_request(Request $request)
    {
        if($request->isMethod('post'))
        {
            $this->validate($request, [
            'email' => 'required|email|max:255',
            ]);
            $user = User::where('email', $request->get('email'))->where('role', '2')->first();

            // return $request->all();
            if (!isset($user)  || !$user->exists()) {

                return redirect()->back()->with('error', 'User not found.');
            }
            else
            {
                $encoded_key = base64_encode(base64_encode($user->id));
                // $encoded_key = sha1(rand().$user->id);
                $url = url('/reset/password').'/'.$encoded_key;
                User::where('id', $user->id)->update(['encoded_key'=>$encoded_key]);

                Mail::to($user->email)->send(new AdminForgotPassword($user->name, $url));

                return redirect()->back()->with('success', 'Please check your email.');
            }
        }
        return view('backend.forgot_email');
    }

    public function password_reset(Request $request, $key)
    {
        if($request->isMethod('post'))
        {
            $id = base64_decode(base64_decode($key));
            $this->validate($request, [
                    'password' => 'required|min:6|confirmed',
                    'password_confirmation' => 'required|min:6',
                      ]);

            $exist = User::where(['id'=>$id, 'encoded_key'=>$key])->first();

            if($exist)
            {
                $exist->update(['encoded_key'=>null, 'password'=>bcrypt($request->password)]);

                return redirect('login')->with('success', 'password change successfully.');
            }
            else
            {
                return redirect()->back()->with('error', 'User not found or link is expire.');
            }

        }
        return view('backend.reset', ['key'=>$key]);
    }
}

