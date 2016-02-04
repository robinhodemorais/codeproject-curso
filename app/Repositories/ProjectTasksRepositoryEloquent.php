<?php

namespace CodeProject\Repositories;

use CodeProject\Presenters\ProjectTasksPresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use CodeProject\Entities\ProjectTasks;


/**
 * Class ProjectTaskRepositoryEloquent
 * @package namespace CodeProject\Repositories;
 */
class ProjectTasksRepositoryEloquent extends BaseRepository implements ProjectTasksRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ProjectTasks::class;
    }


    public function presenter(){
        return ProjectTasksPresenter::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        //$this->pushCriteria(app(RequestCriteria::class));
        $this->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
    }
}
