<?php
/**
 * Created by PhpStorm.
 * User: Robinho de Morais
 * Date: 01/09/2015
 * Time: 21:11
 */

namespace CodeProject\Services;


use CodeProject\Repositories\ProjectRepository;
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
    /**
     * @var ProjectRepository
     */
    private $projectRepository;

    public function __construct(ProjectTasksRepository $repository,
                                ProjectRepository $projectRepository,
                                ProjectTasksValidator $validator){
        $this->repository = $repository;
        $this->validator = $validator;
        $this->projectRepository = $projectRepository;
    }

    /*
    public function all($id){
        return response()->json($this->repository->findWhere(['project_id' => $id]));
    }


    public function read($id,$taskid) {
        try {
            return response()->json($this->repository->findWhere(['project_id'=>$id, 'id'=>$taskid]));
        } catch(ModelNotFoundException $ex) {
            return response()->json([
                'error' => true,
                'message' => "ProjectTask id {$id} not found"
            ]);
        }
    }

*/
    public function create(array $data){

        try{
            $this->validator->with($data)->passesOrFail();

            $project = $this->projectRepository->skipPresenter()->find($data['project_id']);
            $projectTask = $project->tasks()->create($data);

            return $projectTask;

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
                'message' => "ProjectTask id {$id} not found"
            ]);
        }



    }



    public function delete($id){

        try {

            //$this->repository->delete($id);
            //return response()->json(['error' => false,'message' => "ProjectTask {$id} deleted"]);
            $projectTask = $this->repository->skipPresenter()->find($id);
            return $projectTask->delete();

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => false,
                'message' => "ProjectTask id {$id} not found"
            ]);
        }

    }


}