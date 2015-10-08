<?php

namespace CodeProject\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use CodeProject\Entities\Project;

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
     * Metodo para verificar se o usuário é dono do projeto, se ele pode alterar
     */
    public function isOwner($projectid, $userid){


        if(count($this->findWhere(['id'=>$projectid, 'owner_id'=>$userid]))){
            return true;
        }

        return false;
    }

    //verifica se o membro é do projeto
    public function hasMember($projectId, $memberId){
        $project = $this->find($projectId);

        foreach($project->members as $member){
            if($member->id == $memberId){
                return true;
            }

        }

        return false;
    }
}