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

       //CheckProjectOwner está registrado o middleware no kernel
        /*
         * Na aula de Autorização - Validando no controller o Wesley achou melhor tirar essa validação pelo Middlware
         * e deixou como exemplo o que foi criado, mas acha melhor controlar direto no controller.
         */
      // Route::group(['middleware'=>'CheckProjectOwner'], function(){
           Route::resource('project','ProjectController', ['except' => ['create','edit']]);
      //}) ;


       Route::group(['prefix'=>'project'], function() {

          /* Route::get('', 'ProjectController@index');
           Route::post('', 'ProjectController@store');
           Route::get('{id}', 'ProjectController@show');
           Route::delete('{id}', 'ProjectController@destroy');
           Route::put('{id}', 'ProjectController@update');*/

          Route::get('{id}/notes', 'ProjectNoteController@index');
          Route::post('{id}/note', 'ProjectNoteController@store');
          Route::get('{id}/note/{noteId}', 'ProjectNoteController@show');
          Route::put('{id}/note/{noteId}', 'ProjectNoteController@update');
          Route::delete('{id}/note/{noteId}', 'ProjectNoteController@destroy');

          Route::get('{id}/tasks', 'ProjectTasksController@index');
          Route::post('{id}/tasks', 'ProjectTasksController@store');
          Route::get('{id}/tasks/{tasksId}', 'ProjectTasksController@show');
          Route::put('{id}/tasks/{tasksId}', 'ProjectTasksController@update');
          Route::delete('{id}/tasks/{tasksId}', 'ProjectTasksController@destroy');

         // Route::get('{id}/notes', ['as' => 'project.show.notes', 'uses' => 'ProjectController@showNotes']);
          Route::get('{id}/members', 'ProjectController@showMembers');
          Route::get('member/add/{memberId}', ['as' => 'project.member.add', 'uses' => 'ProjectController@addMember']);
          Route::get('member/remove/{memberId}',['as' => 'project.member.remove','uses' => 'ProjectController@removeMember']);
          Route::get('tasks/{id}', ['as' => 'project.tasks.show', 'uses' => 'ProjectController@showTasks']);
/*
           Route::get('tasks/{id}', 'ProjectTasksController@index');
           Route::post('tasks/{id}', 'ProjectTasksController@store');
           Route::get('tasks/{id}', 'ProjectTasksController@show');
           Route::put('tasks/{id}', 'ProjectTasksController@update');
           Route::delete('tasks/{id}', 'ProjectTasksController@destroy');
*/
           Route::post('{id}/file','ProjectFileController@store');
           Route::post('{id}/file/{fileId}/remove','ProjectFileController@destroy');


       });


       /*
       Route::get('client', ['middleware'=>'oauth','uses'=>'ClientController@index']);
       Route::post('client', 'ClientController@store');
       Route::get('client/{id}', 'ClientController@show');
       Route::delete('client/{id}', 'ClientController@destroy');
       Route::put('client/{id}', 'ClientController@update');
      */

/*
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
       Route::get('project/members/{id}', 'ProjectController@showMembers');
       Route::get('project/member/add/{memberId}', ['as' => 'project.member.add', 'uses' => 'ProjectController@addMember']);
       Route::get('project/member/remove/{memberId}',['as' => 'project.member.remove','uses' => 'ProjectController@removeMember']);
       Route::get('project/tasks', ['as' => 'project.tasks.show', 'uses' => 'ProjectController@showTasks']);
*/
    });






