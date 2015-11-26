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
    Route::resource('project','ProjectController', ['except' => ['create','edit']]);

    Route::group(['prefix'=>'project'], function() {


        Route::get('/{id}/notes', 'ProjectNoteController@index');
        Route::post('/{id}/notes', 'ProjectNoteController@store');
        Route::get('/{id}/notes/{noteId}', 'ProjectNoteController@show');
        Route::put('/notes/{idNote}', 'ProjectNoteController@update');
        Route::delete('/notes/{id}', 'ProjectNoteController@destroy');


        Route::get('/{id}/tasks', 'ProjectTasksController@index');
        Route::post('/{id}/tasks', 'ProjectTasksController@store');
        Route::get('/{id}/tasks/{tasksId}', 'ProjectTasksController@show');
        Route::put('/{id}/tasks/{tasksId}', 'ProjectTasksController@update');
        Route::delete('/{id}/tasks/{tasksId}', 'ProjectTasksController@destroy');

        Route::get('/{id}/members', 'ProjectController@showMembers');
        Route::get('/member/add/{memberId}', ['as' => 'project.member.add', 'uses' => 'ProjectController@addMember']);
        Route::get('/member/remove/{memberId}',['as' => 'project.member.remove','uses' => 'ProjectController@removeMember']);
        Route::get('/tasks/{id}', ['as' => 'project.tasks.show', 'uses' => 'ProjectController@showTasks']);

        Route::post('/{id}/file','ProjectFileController@store');
        Route::post('/{id}/file/{fileId}/remove','ProjectFileController@destroy');


    });

    Route::get('/user/authenticated', 'UserController@authenticated');


});






