<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('index');
});

Route::get('edit', function() {
	return view('edit');
});

Route::group(['prefix' => 'api'], function() {
	Route::group(['prefix' => 'events'], function() {
	
		Route::get('all', 'EventsController@getEvents');
		Route::get('get', 'EventsController@getEvent');
		Route::post('set', 'EventsController@setEvent');
		Route::post('delete', 'EventsController@deleteEvent');

		Route::get('echo', function() {
			return json_encode(['ping' => true]);
		});

		Route::post('echo', function() {
			$input = Input::all();
			$input['id'] = 1375;
			return json_encode($input);
		});
	});
});