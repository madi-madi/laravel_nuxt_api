<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
// Route ::get('/',function(){
//     return response('Hello world', 200, ["headers"]);
// });
// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('me','User\MeController@getMe');
Route::get('designs/list', 'Designs\DesignsController@index')->name('designs.list');
Route::get('designs/{id}', 'Designs\DesignsController@findDesign')->name('designs.find');
Route::get('users/list', 'User\UserController@index')->name('users.list');

Route::group(['middleware'=>['auth:api']],function(){
   Route::post('logout', 'Auth\LoginController@logout'); 
   Route::put('settings/profile', 'User\SettingsController@updateProfile')->name('profile.update');
   Route::put('settings/password', 'User\SettingsController@updatePassword')->name('password.update');
   
   Route::post('designs', 'Designs\UploadController@upload')->name('designs.upload');
   Route::post('designs/{id}', 'Designs\DesignsController@update')->name('designs.update');
   Route::delete('designs/{id}', 'Designs\DesignsController@destroy')->name('designs.destroy');
   Route::post('designs/{id}/comments', 'Designs\CommentController@store')->name('designs.comment.create');
   Route::post('comments/{id}/update', 'Designs\CommentController@update')->name('designs.comment.update');
   Route::delete('comments/{id}/delete', 'Designs\CommentController@destroy')->name('designs.comment.delete');

});

Route::group(['middleware'=>['guest:api']],function(){
   Route::post('register', 'Auth\RegisterController@register'); 
   Route::post('verification/verify/{user}', 'Auth\VerificationController@verify')->name('verification.verify'); 
   Route::post('verification/resend', 'Auth\VerificationController@resend'); 
   Route::post('login', 'Auth\LoginController@login'); 
   Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
   Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.reset');

   

});