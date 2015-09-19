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
        return response()->json($this->repository->with(['owner', 'client'])->all());
    }

<<<<<<< HEAD
    public function read($id) {
        try {
            return response()->json($this->repository->with(['owner', 'client'])->find($id));
        } catch(ModelNotFoundException $ex) {
            return response()->json([
                'error' => true,
                'message' => "Project id {$id} not found"
            ]);
        }
    }


    public function create(array $data){
=======
    public function read($id)
    {
       try {
           return response()->json($this->repository->with(['owner', 'client'])->find($id));

       } catch(ModelNotFoundException $ex) {
           return response()->json([
               'error' => true,
               'message' => "Project id {$id} not found"
           ]);
       }
    }


    public function create(array $data)
    {

>>>>>>> 7b4eb4208f49e4ef0b6486379f71565f14e2f62a
        try {
            $this->validator->with($data)->passesOrFail();
            return $this->repository->create($data);
        } catch (ValidatorException $e) {
<<<<<<< HEAD
=======

>>>>>>> 7b4eb4208f49e4ef0b6486379f71565f14e2f62a
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
<<<<<<< HEAD
=======

>>>>>>> 7b4eb4208f49e4ef0b6486379f71565f14e2f62a
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

<<<<<<< HEAD
        try {
            $this->repository->delete($id);
            return response()->json(['error' => false,'message' => "Project {$id} deleted"]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => false,
=======
           return response()->json([
                'error' => true,
>>>>>>> 7b4eb4208f49e4ef0b6486379f71565f14e2f62a
                'message' => "Project id {$id} not found"
            ]);
        }

    }

}