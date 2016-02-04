<?php

namespace CodeProject\Repositories;

use CodeProject\Transformers\ProjectMemberTransformer;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use CodeProject\Entities\ProjectMembers;

/**
 * Class ProjectMembersRepositoryEloquent
 * @package namespace CodeProject\Repositories;
 */
class ProjectMembersRepositoryEloquent extends BaseRepository implements ProjectMembersRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ProjectMembers::class;
    }

    public function presenter()
    {
        return ProjectMemberTransformer::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
