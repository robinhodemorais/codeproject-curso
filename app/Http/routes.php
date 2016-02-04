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
    return view('app');
});

Route::post('oauth/access_token', function(){
    return Response::json(Authorizer::issueAccessToken());
});


Route::group(['middleware'=>'oauth'], function () {

    Route::resource('client','ClientController', ['except' => ['create','edit']]);
    Route::resource('projects','ProjectController', ['except' => ['create','edit']]);

    Route::group(['middleware' => 'check.project.permission','prefix'=>'project'], function() {


        Route::get('/{id}/notes', 'ProjectNoteController@index');
        Route::post('/{id}/notes', 'ProjectNoteController@store');
        Route::put('/{id}/notes/{noteId}', 'ProjectNoteController@update');
        Route::get('/{id}/notes/{noteId}', 'ProjectNoteController@show');
        Route::delete('/{id}/notes/{noteId}', 'ProjectNoteController@destroy');


        Route::get('/{id}/task', 'ProjectTasksController@index');
        Route::post('/{id}/task', 'ProjectTasksController@store');
        Route::get('/{id}/task/{tasksId}', 'ProjectTasksController@show');
        Route::put('/{id}/task/{tasksId}', 'ProjectTasksController@update');
        Route::delete('/{id}/task/{tasksId}', 'ProjectTasksController@destroy');


        Route::get('{id}/file','ProjectFileController@index');
        Route::get('{id}/file/{fileId}','ProjectFileController@show');
        Route::get('{id}/file/{fileId}/download','ProjectFileController@showFile');
        Route::post('{id}/file','ProjectFileController@store');
        Route::put('{id}/file/{fileId}','ProjectFileController@update');
        Route::delete('{id}/file/{fileId}','ProjectFileController@destroy');


    });

    Route::get('/{id}/members', 'ProjectController@showMembers');
    Route::get('/member/add/{memberId}', ['as' => 'project.member.add', 'uses' => 'ProjectController@addMember']);
    Route::get('/member/remove/{memberId}',['as' => 'project.member.remove','uses' => 'ProjectController@removeMember']);
    Route::get('/tasks/{id}', ['as' => 'project.tasks.show', 'uses' => 'ProjectController@showTasks']);


    Route::get('/user/authenticated', 'UserController@authenticated');


});






