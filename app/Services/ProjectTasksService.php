<?php
/**
 * Created by PhpStorm.
 * User: Robinho de Morais
 * Date: 01/09/2015
 * Time: 21:11
 */

namespace CodeProject\Services;


use CodeProject\Repositories\ProjectTasksRepository;
use CodeProject\Validators\ProjectTasksValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Prettus\Validator\Exceptions\ValidatorException;


class ProjectTasksService {
    protected $repository;
    /**
     * @var
     */
    private $validator;

    public function __construct(ProjectTasksRepository $repository, ProjectTasksValidator $validator){
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function all($id){
        return response()->json($this->repository->findWhere(['project_id' => $id]));
    }


    public function read($id,$taskid) {
        try {
            return response()->json($this->repository->findWhere(['project_id'=>$id, 'id'=>$taskid]));
        } catch(ModelNotFoundException $ex) {
            return response()->json([
                'error' => true,
                'message' => "ProjectTasks id {$id} not found"
            ]);
        }
    }


    public function create(array $data){

        try{
            $this->validator->with($data)->passesOrFail();
            return $this->repository->create($data);
        } catch (ValidatorException $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessageBag()
            ]);
        }


    }



    public function update(array $data, $id){

        try{
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
                'message' => "ProjectTasks id {$id} not found"
            ]);
        }



    }



    public function delete($id){

        try {
            $this->repository->delete($id);
            return response()->json(['error' => false,'message' => "ProjectTasks {$id} deleted"]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => false,
                'message' => "ProjectTasks id {$id} not found"
            ]);
        }

    }


}