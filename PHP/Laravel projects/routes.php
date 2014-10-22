<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('icons', function(){
	return View::make('icons');
});
Route::controller('social', 'SocialController');
Route::get('job/details', 'HomeController@getDetails');
Route::controller('user', 'LoginController');

Route::post('application', 'ApplicationController@postSubmit');

Route::get('application/{appId}', array(
	'before' => 'authorize', 
	'uses' => 'ApplicationController@getSingle'
));

Route::get('applications', array(
	'before' => 'authorize', 
	'uses' => 'ApplicationController@getAll'
));

Route::post('application/trash/{appId}', array(
	'before' => 'authorize',
	'uses' => 'ApplicationController@postTrash'
));

Route::controller('/', 'HomeController'); 	

Route::filter('authorize', function(){
	if(Auth::guest())
	{
		return Redirect::guest('/user/login');
	}
});