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
use Illuminate\Contracts\Validation\ValidationException;


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

    public function create(array $data){

        try {
            $this->validator->with($data)->passesOrFail();

            return $this->repository->create($data);
        } catch (ValidationException $e) {
            return [
                'error', true,
                'message' => $e->getMessageBag()
            ];
        }
    }

    public function delete($id){
        $projectMember = $this->repository->skipPresenter()->find($id);
        return $projectMember->delete();
    }



}