<?php

namespace CodeProject\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use CodeProject\Entities\Project;
use CodeProject\Presenters\ProjectPresenter;

/**
 * Class ProjectRepositoryEloquent
 * @package namespace CodeProject\Repositories;
 */
class ProjectRepositoryEloquent extends BaseRepository implements ProjectRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */

   // protected $skipCriteria = true;

    public function model()
    {
        return Project::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria( app(RequestCriteria::class) );
    }

    /*
     * Metodo para verificar se o usu�rio � dono do projeto, se ele pode alterar
     */
    public function isOwner($projectId, $userId){

/*
        if(count($this->skipPresenter()->findWhere(['id' => $projectId, 'owner_id' => $userId]))) {
            return true;
        }

        return false;*/

        $result = $this->skipPresenter()->findWhere(['id' => $projectId, 'owner_id' => $userId]);
        if (count($result)) {
            return true;
        }
        return false;
    }

    //verifica se o membro � do projeto
    public function hasMember($projectId, $memberId){
        $project = $this->skipPresenter()->find($projectId);

        foreach($project->members as $member){
            if($member->id == $memberId) {
                return true;
            }
        }

        return false;
    }

/*Utilizando essa função para trazer os projetos e os membros proprietarios, quando utiliza o paginate
  função do prettus, ocorre um erro de Cardinality violation: 1222 The used SELECT
  esse erro ocorre por causa do laravel, onde com a union ele gera o sql do project_members realizando um count
  para paginar, porém no projets ele gera um select sem realizar o count, sendo assim sera utilizado outra maneira
  para listar.

  Erro completo :

SQLSTATE[21000]: Cardinality violation: 1222 The used SELECT statements have a different number of columns (SQL: (select count(*) as aggregate
 from `projects` left join `project_members` on `project_members`.`project_id` = `projects`.`id` where `project_members`.`user_id` = 1)
union (select * from `projects` where `owner_id` = 1))
    public function findWithOwnerAndMember($userId){
        return $this->scopeQuery(function($query) use ($userId) {
            return $query->select('projects.*')
                ->leftJoin('project_members','project_members.project_id','=','projects.id')
                ->where('project_members.user_id','=',$userId)
                ->union($this->model->query()->getQuery()->where('owner_id', '=', $userId));
        })->paginate();
    }
*/

    public function findOwner($userId, $limit = null, $columns = array()){
        return $this->scopeQuery(function ($query) use ($userId) {
            return $query->select('projects.*')-> where('owner_id','=',$userId);
        })->paginate($limit,$columns);
    }
    /*
     * Metodo para informar qual o presenter que vamos usar
     */

    public function presenter(){
        return ProjectPresenter::class;
    }
}