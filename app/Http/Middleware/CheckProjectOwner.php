<?php

namespace CodeProject\Http\Middleware;

use Closure;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Services\ProjectService;

class CheckProjectOwner
{
    /**
     * @var ProjectService
     */
    private $service;

    /**
     * @param ProjectService $service
     */
    public function __construct(ProjectService $service){

        $this->service = $service;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        //retorna o ID do usu�rio na tela para verificar se � o correto
        // return ['userId'=> \Authorizer::getResourceOwnerId()];


        //pega o usu�rio logado de acordo com o access token
        //$userId =  \Authorizer::getResourceOwnerId();

        //rodando o php artisan route:list, podemos ver que o resource criou um parametro
        //no caso do project criou como {project}, conforme abaixo

        /*| Domain | Method   | URI                              | Name                  | Action                                                      | Middleware |
         *|        | GET|HEAD | project/{project}                | project.show          | CodeProject\Http\Controllers\ProjectController@show         | oauth      |
         */

       // $projectId = $request->project;

        $projectId = $request->route('id') ? $request->route('id') : $request->route('project');

        if ($this->service->checkProjectOwner($projectId) == false) {
            return ['error' => 'Access forbidden'];
        }

        return $next($request);
    }
}
