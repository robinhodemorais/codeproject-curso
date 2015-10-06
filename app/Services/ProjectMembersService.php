<?php
/**
 * Created by PhpStorm.
 * User: Robinho de Morais
 * Date: 01/09/2015
 * Time: 21:11
 */

namespace CodeProject\Services;


use CodeProject\Repositories\ProjectMembersRepository;
use CodeProject\Validators\ProjectMembersValidator;


class ProjectMembersService {
    protected $repository;
    /**
     * @var
     */
    private $validator;

    public function __construct(ProjectMembersRepository $repository, ProjectMembersValidator $validator){
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function all($id){
        return response()->json($this->repository->findWhere(['project_id' => $id]));
    }




}