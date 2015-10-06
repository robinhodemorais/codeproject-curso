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

    Route::resource('client','ClientController', ['except' => ['create','edit']]);


    Route::get('client', 'ClientController@index');
    Route::post('client', 'ClientController@store');
    Route::get('client/{id}', 'ClientController@show');
    Route::delete('client/{id}', 'ClientController@destroy');
    Route::put('client/{id}', 'ClientController@update');

    Route::get('tasks/{id}', 'ProjectTasksController@index');
    Route::post('tasks/{id}', 'ProjectTasksController@store');
    Route::get('tasks/{id}', 'ProjectTasksController@show');
    Route::put('tasks/{id}', 'ProjectTasksController@update');
    Route::delete('tasks/{id}', 'ProjectTasksController@destroy');

    Route::get('project/{id}/note', 'ProjectNoteController@index');
    Route::post('project/{id}/note', 'ProjectNoteController@store');
    Route::get('project/{id}/note/{noteId}', 'ProjectNoteController@show');
    Route::put('project/{id}/note/{noteId}', 'ProjectNoteController@update');
    Route::delete('project/{id}/note/{noteId}', 'ProjectNoteController@destroy');

    Route::get('project/{id}/tasks', 'ProjectTasksController@index');
    Route::post('project/{id}/tasks', 'ProjectTasksController@store');
    Route::get('project/{id}/tasks/{tasksId}', 'ProjectTasksController@show');
    Route::put('project/{id}/tasks/{tasksId}', 'ProjectTasksController@update');
    Route::delete('project/{id}/tasks/{tasksId}', 'ProjectTasksController@destroy');

    Route::get('project', 'ProjectController@index');
    Route::post('project', 'ProjectController@store');
    Route::get('project/{id}', 'ProjectController@show');
    Route::delete('project/{id}', 'ProjectController@destroy');
    Route::put('project/{id}', 'ProjectController@update');

    Route::get('project/notes', ['as' => 'project.show.notes', 'uses' => 'ProjectController@showNotes']);
    Route::get('project/members', ['as' => 'project.show.members', 'uses' => 'ProjectController@showMembers']);
    Route::get('project/member/add/{memberId}', ['as' => 'project.member.add', 'uses' => 'ProjectController@addMember']);
    Route::get('project/member/remove/{memberId}',['as' => 'project.member.remove','uses' => 'ProjectController@removeMember']);
    Route::get('project/tasks', ['as' => 'project.tasks.show', 'uses' => 'ProjectController@showTasks']);




