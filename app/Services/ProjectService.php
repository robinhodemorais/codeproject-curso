<?php
/**
 * Created by PhpStorm.
 * User: Robinho de Morais
 * Date: 01/09/2015
 * Time: 21:11
 */

namespace CodeProject\Services;


use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validators\ProjectValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Prettus\Validator\Exceptions\ValidatorException;


class ProjectService
{
    /**
     * @var ProjectRepository
     */
    protected $repository;
    /**
     * @var ProjectValidator
     */
    private $validator;

    /**
     * @param ProjectRepository $repository
     * @param ProjectValidator $validator
     */
    public function __construct(ProjectRepository $repository, ProjectValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }


    public function all()
    {
        return response()->json($this->repository->with(['owner', 'client', 'notes', 'members', 'tasks'])->all());
    }


    public function read($id) {
        try {
            return response()->json($this->repository->with(['owner', 'client', 'notes', 'members', 'tasks'])->find($id));
        } catch(ModelNotFoundException $ex) {
            return response()->json([
                'error' => true,
                'message' => "Project id {$id} not found"
            ]);
        }
    }


    public function create(array $data)
    {

        try {
            $this->validator->with($data)->passesOrFail();
            return $this->repository->create($data);
        } catch (ValidatorException $e) {

            return response()->json([
                'error' => true,
                'message' => $e->getMessageBag()
            ]);
        }

    }

    public function update(array $data, $id)
    {
        try {
            $this->validator->with($data)->passesOrFail();
            return $this->repository->update($data, $id);
        } catch (ValidatorException $e) {

            return response()->json([
                'error' => true,
                'message' => $e->getMessageBag()
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => true,
                'message' => "Project id {$id} not found"
            ]);
        }

    }


    public function delete($id)
    {
        try {
            $this->repository->delete($id);
        } catch (ModelNotFoundException $e) {

            try {
                $this->repository->delete($id);
                return response()->json(['error' => false,'message' => "Project {$id} deleted"]);
            } catch (ModelNotFoundException $e) {
               return response()->json([
                    'error' => true,
                    'message' => "Project id {$id} not found"
                ]);
            }

        }
    }

    public function showNotes($id)
    {
        try {
            return response()->json($this->repository->find($id)->notes->all());
        } catch(ModelNotFoundException $ex) {
            return $this->notFound($id);
        }
    }
    public function showMembers($id)
    {
        try {
            return response()->json($this->repository->find($id)->members->all());
        } catch(ModelNotFoundException $ex) {
            return $this->notFound($id);
        }
    }
    public function addMember($id, $memberId)
    {
        try {
            $this->repository->find($id)->members()->attach($memberId);
            return response()->json([
                'error' => false,
                'message' => [
                    'addMember' => "Member ID {$memberId} added"
                ]
            ]);
        } catch(ModelNotFoundException $ex) {
            return $this->notFound($id);
        }
    }
    public function removeMember($id, $memberId)
    {
        try {
            $this->repository->find($id)->members()->detach($memberId);
            return response()->json([
                'error' => false,
                'message' => [
                    'removeMember' => "Member ID {$memberId} removed"
                ]
            ]);
        } catch(ModelNotFoundException $ex) {
            return $this->notFound($id);
        }
    }
    public function isMember($id, $memberId)
    {
        try {
            $member = $this->repository->find($id)->members()->find($memberId);
            if(!$member) {
                return response()->json([
                    'error' => true,
                    'message' => [
                        'isMember' => "Member ID {$memberId} is not a member in this project"
                    ]
                ]);
            }
            return response()->json([
                'error' => false,
                'message' => [
                    'isMember' => "{$member->name} is a member in this project"
                ]
            ]);
        } catch(ModelNotFoundException $ex) {
            return $this->notFound($id);
        }
    }
    public function showTasks($id)
    {
        try {
            return response()->json($this->repository->find($id)->tasks->all());
        } catch(ModelNotFoundException $ex) {
            return $this->notFound($id);
        }
    }

}
