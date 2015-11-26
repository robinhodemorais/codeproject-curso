<?php

namespace CodeProject\Http\Middleware;

use Closure;
use CodeProject\Repositories\ProjectRepository;

class CheckProjectOwner
{
    /**
     * @var ProjectRepository
     */
    private $repository;

    /**
     * @param ProjectRepository $repository
     */
    public function __construct(ProjectRepository $repository){

        $this->repository = $repository;
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

        //retorna o ID do usuário na tela para verificar se é o correto
        // return ['userId'=> \Authorizer::getResourceOwnerId()];


        //pega o usuário logado de acordo com o access token
        $userId =  \Authorizer::getResourceOwnerId();

        //rodando o php artisan route:list, podemos ver que o resource criou um parametro
        //no caso do project criou como {project}, conforme abaixo

        /*| Domain | Method   | URI                              | Name                  | Action                                                      | Middleware |
         *|        | GET|HEAD | project/{project}                | project.show          | CodeProject\Http\Controllers\ProjectController@show         | oauth      |
         */

        $projectId = $request->project;

        if ($this->repository->isOwner($projectId,$userId) == false) {
            return ['error' => 'Access forbidden'];
        }

        return $next($request);
    }
}
