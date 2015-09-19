<?php
/**
 * Created by PhpStorm.
 * User: Robinho de Morais
 * Date: 01/09/2015
 * Time: 21:11
 */

namespace CodeProject\Services;


use CodeProject\Repositories\ProjectNoteRepository;
use CodeProject\Validators\ProjectNoteValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Prettus\Validator\Exceptions\ValidatorException;


class ProjectNoteService {
    protected $repository;
    /**
     * @var
     */
    private $validator;

    public function __construct(ProjectNoteRepository $repository, ProjectNoteValidator $validator){
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function all($id){
        return response()->json($this->repository->findWhere(['project_id' => $id]));
        //return $this->repository->findWhere(['project_id' => $id]);
    }


    public function read($id,$noteid) {
        try {
            return response()->json($this->repository->findWhere(['project_id'=>$id, 'id'=>$noteid]));
        } catch(ModelNotFoundException $ex) {
            return response()->json([
                'error' => true,
                'message' => "ProjectNote id {$id} not found"
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
                'message' => "ProjectNote id {$id} not found"
            ]);
        }



    }



    public function delete($id){

        try {
            $this->repository->delete($id);
            return response()->json(['error' => false,'message' => "ProjectNote {$id} deleted"]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => false,
                'message' => "ProjectNote id {$id} not found"
            ]);
        }

    }


}