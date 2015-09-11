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
use Prettus\Validator\Exceptions\ValidatorException;


class ProjectService {
    protected $repository;
    /**
     * @var
     */
    private $validator;

    public function __construct(ProjectRepository $repository, ProjectValidator $validator){
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function create(array $data){

        try{
            $this->validator->with($data)->passesOrFail();
            return $this->repository->create($data);
        } catch (ValidatorException $e) {

            return [
                'error' => true,
                'message' => $e->getMessageBag()
            ];
        }

        //enviar email
        //dispara notificacao

    }

    public function update(array $data, $id){

        try{
            $this->validator->with($data)->passesOrFail();
            return $this->repository->update($data, $id);
        } catch (ValidatorException $e) {

            return [
                'error' => true,
                'message' => $e->getMessageBag()
            ];
        }


    }

   // public function show(){

        //return $this->repository->with(['owner_id', 'client'])->all();
      //  return $this->repository->with(['owner_id', 'client_id'])->all();



  //  }

    public function all()
    {
        return response()->json($this->repository->with(['owner_id', 'client_id'])->all());
    }

    public function read($id)
    {
        try {
            return response()->json($this->repository->with(['owner_id', 'client_id'])->find($id));
        } catch(ModelNotFoundException $ex) {
            return $this->notFound($id);
        }
    }
}