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

Route::group(['middleware'=>['auth:api']],function(){
   Route::post('logout', 'Auth\LoginController@logout'); 
});

Route::group(['middleware'=>['guest:api']],function(){
   Route::post('register', 'Auth\RegisterController@register'); 
   Route::post('verification/verify/{user}', 'Auth\VerificationController@verify')->name('verification.verify'); 
   Route::post('verification/resend', 'Auth\VerificationController@resend'); 
   Route::post('login', 'Auth\LoginController@login'); 
});