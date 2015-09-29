<?php

namespace CodeProject\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use CodeProject\Repositories\ProjectTasksRepository;
use CodeProject\Entities\ProjectTasks;

/**
 * Class ProjectTasksRepositoryEloquent
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

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
