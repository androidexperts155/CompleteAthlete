<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

    Route::group(['namespace'=>'Api'], function(){
    	Route::post('/test11','UserController@test11');
	Route::post('/login','UserController@login');
		Route::group(['middleware'=>['auth:api']], function(){

			Route::post('/allworkouts','UserController@allworkouts');
			Route::post('/mylog','UserController@mylog');
			Route::get('/allcategories','UserController@allcategories');
			Route::post('/resultdata','UserController@allresultdata');	
			Route::post('/likeworkout','UserController@likeworkout');
			Route::post('/listcomments','UserController@listcomments');	
			Route::post('/addcomment','UserController@addcomment');
			Route::post('/deletecomment','UserController@deletecomment');
			Route::post('/likecomment','UserController@likecomment');
			Route::post('/savemessage','UserController@savemessage');	
			Route::get('/getcoachdetails','UserController@getcoachdetails');	
			Route::post('/allchatdata','UserController@allchatdata');
			Route::get('/chatheads','UserController@chatheads');
			Route::post('/registertoken','UserController@registertoken');
			Route::post('/editprofile','UserController@editprofile');
			Route::get('/allnotifications','UserController@allnotifications');
			Route::get('/userstats','UserController@userstats');
			Route::post('/savegoal','UserController@savegoal');
			Route::post('/savediet','UserController@savediet');
			Route::get('/getbenchmark','UserController@getbenchmark');
			Route::get('/getbarbell','UserController@getbarbell');
			Route::post('/addprogresspic','UserController@addprogresspic');
			Route::post('/deleteprogresspic','UserController@deleteprogresspic');
			Route::get('/getallprogresspic','UserController@getallprogresspic');
			Route::get('/logout','UserController@logout');
			Route::get('/deleteaccount','UserController@deleteaccount');
			Route::get('/getuserdetails','UserController@getuserdetails');		
			Route::post('/changepassword','UserController@changepassword');
			Route::post('/deleteuserworkout','UserController@deleteuserworkout');
			Route::post('/editcoachprofile','UserController@editcoachprofile');
			Route::get('/notificationscount','UserController@notificationscount');
			Route::post('/readnotification','UserController@readnotification');
			Route::post('/readchatmessage','UserController@readchatmessage');
		});	
		Route::post('/resetpassword','UserController@resetpassword');
		Route::post('/test','UserController@test');
	});

