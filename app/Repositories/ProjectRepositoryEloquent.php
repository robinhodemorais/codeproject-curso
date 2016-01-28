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
    public function isOwner($projectid, $userid){


        if(count($this->skipPresenter()->findWhere(['id' => $projectid, 'owner_id' => $userid]))) {
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


    public function findWithOwnerAndMember($userId){
        return $this->scopeQuery(function($query) use ($userId) {
            return $query->select('projects.*')
                ->leftJoin('project_members','project_members.project_id','=','projects.id')
                ->where('project_members.user_id','=',$userId)
                ->union($this->model->query()->getQuery()->where('owner_id', '=', $userId));
        })->all();
    }

    /*
     * Metodo para informar qual o presenter que vamos usar
     */

    public function presenter(){
        return ProjectPresenter::class;
    }
}