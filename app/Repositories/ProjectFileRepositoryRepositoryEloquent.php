<?php

namespace CodeProject\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use CodeProject\Repositories\ProjectFileRepositoryRepository;
use CodeProject\Entities\ProjectFileRepository;

/**
 * Class ProjectFileRepositoryRepositoryEloquent
 * @package namespace CodeProject\Repositories;
 */
class ProjectFileRepositoryRepositoryEloquent extends BaseRepository implements ProjectFileRepositoryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ProjectFileRepository::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
