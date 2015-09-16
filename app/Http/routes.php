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
    return view('welcome');
});

Route::post('oauth/access_token', function(){
   return Response::json(Authorizer::issueAccessToken());
});

//Route::group(['middleware'=>'oauth'], function(){

    Route::resource('client','ClientController', ['except' => ['create','edit']]);


    Route::get('client', ['middleware'=>'oauth','uses'=>'ClientController@index']);
    Route::post('client', 'ClientController@store');
    Route::get('client/{id}', 'ClientController@show');
    Route::delete('client/{id}', 'ClientController@destroy');
    Route::put('client/{id}', 'ClientController@update');

/*
    Route::group(['prefix','project'], function () {

        Route::resource('','ProjectController', ['except' => ['create','edit']]);

        Route::get('{id}/note', 'ProjectNoteController@index');
        Route::post('{id}/note', 'ProjectNoteController@store');
        Route::get('{id}/note/{noteId}', 'ProjectNoteController@show');
       // Route::put('{id}/note/{noteId}', 'ProjectNoteController@update');
        Route::delete('note/{id}', 'ProjectNoteController@destroy');
    });


*/

    Route::get('project', 'ProjectController@index');
    Route::post('project', 'ProjectController@store');
    Route::get('project/{id}', 'ProjectController@show');
    Route::delete('project/{id}', 'ProjectController@destroy');
    Route::put('project/{id}', 'ProjectController@update');





//});

