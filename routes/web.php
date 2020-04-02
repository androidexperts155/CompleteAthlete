<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});
Auth::routes();

Route::post('/login', 'Auth\LoginController@login')->name('login');

Route::group(['middleware'=>['auth']], function(){
Route::get('/home', 'Backend\AdminController@index')->name('home');
Route::match(['get', 'post'], '/admin_profile', 'Backend\AdminController@admin_profile')->name('admin_profile');
Route::match(['get', 'post'], '/ath_list', 'Backend\UserController@ath_list')->name('ath_list');
Route::match(['get', 'post'], '/coach_list', 'Backend\UserController@coach_list')->name('coach_list');
Route::match(['get', 'post'], '/savemessage', 'Backend\UserController@savemessage')->name('savemessage');
Route::match(['get', 'post'], '/viewathletes/{id}', 'Backend\UserController@viewathletes')->name('viewathletes');
Route::match(['get', 'post'], '/chatathlete/{coachid?}/{athleteid?}', 'Backend\UserController@chatathlete')->name('chatathlete');
Route::match(['get','post'],'/user-data','Backend\UserController@user_data')->name('user-data');
Route::match(['get','post'],'/save-user-data','Backend\UserController@save_user_data')->name('save-user-data');
Route::match(['get', 'post'],'delete/athlete/','Backend\UserController@delete_athlete');
Route::match(['get', 'post'],'delete/coach/','Backend\UserController@delete_coach');
Route::match(['get', 'post'],'delete/workout/','Backend\UserController@delete_workout');
Route::match(['get', 'post'],'/delete/video','Backend\UserController@delete_video');
Route::match(['get', 'post'],'/delete/place','Backend\UserController@delete_place');
Route::match(['get', 'post'],'checkemail','Backend\UserController@checkemail');
Route::match(['get', 'post'],'workout_add/{athid?}/{type?}','Backend\UserController@workout_add')->name('workout_add');
Route::match(['get', 'post'],'workoutplace_add','Backend\UserController@workoutplace_add')->name('workoutplace_add');

Route::match(['get', 'post'],'save-workout','Backend\UserController@save_workout')->name('save-workout');
Route::match(['get', 'post'],'workout_listing','Backend\UserController@workout_listing')->name('workout_listing');
Route::post('/find-workout','Backend\UserController@findworkout')->name('find-workout');
Route::post('/edit-workout
','Backend\UserController@editworkout')->name('edit-workout');
Route::match(['get', 'post'],'/changepassword/{id}
','Backend\UserController@changepassword')->name('changepassword');
Route::match(['get', 'post'],'/viewuserinfo/{id}/{type?}
','Backend\UserController@viewuserinfo')->name('viewuserinfo');
Route::match(['get', 'post'],'/viewuserimages/{id}
','Backend\UserController@viewuserimages')->name('viewuserimages');
Route::match(['get', 'post'],'/viewusersworkout/{id}
','Backend\UserController@viewusersworkout')->name('viewusersworkout');
Route::match(['get', 'post'],'/viewuserscomments/{userid}/{workoutid}
','Backend\UserController@viewuserscomments')->name('viewuserscomments');
Route::match(['get', 'post'],'/viewusershifives/{userid}/{workoutid}
','Backend\UserController@viewusershifives')->name('viewusershifives');
Route::match(['get', 'post'],'/viewnutritiondetails
','Backend\UserController@viewnutritiondetails')->name('viewnutritiondetails');
Route::match(['get', 'post'],'/viewnutritioncalender
','Backend\UserController@viewnutritioncalender')->name('viewnutritioncalender');
Route::match(['get', 'post'],'/checkdatevalue
','Backend\UserController@checkdatevalue')->name('checkdatevalue');
Route::match(['get', 'post'],'/video_upload','Backend\UserController@video_upload')->name('video_upload');
Route::match(['get', 'post'],'/video_datecheck','Backend\UserController@video_datecheck')->name('video_datecheck');

});


/*Route::match(['get', 'post'],'/changepassword1
','Backend\UserController@changepassword1')->name('changepassword1');*/




