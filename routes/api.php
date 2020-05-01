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
//teams by slug
Route::get('teams/slug/{slug}', 'Teams\TeamsController@findBySlug')->name('teams.slug');
Route::get('teams/{id}/designs', 'Designs\DesignsController@getForTeam')->name('teams.getForTeam');

Route::group(['middleware'=>['auth:api']],function(){
   Route::post('logout', 'Auth\LoginController@logout'); 
   Route::put('settings/profile', 'User\SettingsController@updateProfile')->name('profile.update');
   Route::put('settings/password', 'User\SettingsController@updatePassword')->name('password.update');
   
   Route::post('designs', 'Designs\UploadController@upload')->name('designs.upload');
   Route::post('designs/{id}', 'Designs\DesignsController@update')->name('designs.update');
   Route::delete('designs/{id}/delete', 'Designs\DesignsController@destroy')->name('designs.destroy');
   Route::get('designs/{id}/liked', 'Designs\DesignsController@checkIfUserHasLiked')->name('designs.liked');
   Route::post('designs/{id}/like', 'Designs\DesignsController@like')->name('designs.like');
   Route::post('designs/{id}/comments', 'Designs\CommentController@store')->name('designs.comment.create');
   Route::post('comments/{id}/update', 'Designs\CommentController@update')->name('designs.comment.update');
   Route::delete('comments/{id}/delete', 'Designs\CommentController@destroy')->name('designs.comment.delete');
   //teams
   Route::post('teams', 'Teams\TeamsController@store')->name('teams.store');
   Route::get('teams', 'Teams\TeamsController@index')->name('teams.all');
   Route::get('users/teams', 'Teams\TeamsController@fetchUsersTeams')->name('teams.fetchUsersTeams');
   Route::get('teams/{id}', 'Teams\TeamsController@show')->name('teams.show');
   Route::post('teams/{id}', 'Teams\TeamsController@update')->name('teams.update');
   Route::delete('teams/{id}', 'Teams\TeamsController@destroy')->name('teams.destroy');
   Route::delete('teams/{team_id}/user/{user_id}', 'Teams\TeamsController@removeFromTeam')->name('teams.removeFromTeam');

   //invitations
   Route::post('invitations/{teamId}', 'Teams\InvitationsController@invite')->name('invitations.invite');
   Route::post('invitations/{id}/resend', 'Teams\InvitationsController@resend')->name('invitations.resend');
   Route::post('invitations/{id}/respond', 'Teams\InvitationsController@respond')->name('invitations.response');
   Route::delete('invitations/{id}', 'Teams\InvitationsController@destroy')->name('invitations.destroy');

   // Chats
   Route::post('chats', 'Chats\ChatController@sendMessage');
   Route::get('chats', 'Chats\ChatController@getUserChats');
   Route::get('chats/{id}/messages', 'Chats\ChatController@getChatMessages');
   Route::post('chats/{id}/markAsRead', 'Chats\ChatController@markAsRead');
   Route::delete('messages/{id}', 'Chats\ChatController@destroyMessage');

   // search designs
   Route::get('search/designs', 'Designs\DesignsController@search');
   Route::get('search/designers', 'User\UserController@search');
   
});

Route::group(['middleware'=>['guest:api']],function(){
   Route::post('register', 'Auth\RegisterController@register'); 
   Route::post('verification/verify/{user}', 'Auth\VerificationController@verify')->name('verification.verify'); 
   Route::post('verification/resend', 'Auth\VerificationController@resend'); 
   Route::post('login', 'Auth\LoginController@login'); 
   Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
   Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.reset');

   

});