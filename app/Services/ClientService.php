<?php
/**
 * Created by PhpStorm.
 * User: Robinho de Morais
 * Date: 01/09/2015
 * Time: 21:11
 */

namespace CodeProject\Services;


use CodeProject\Repositories\ClientRepository;
use CodeProject\Validators\ClientValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Prettus\Validator\Exceptions\ValidatorException;


class ClientService {
    protected $repository;
    /**
     * @var
     */
    private $validator;

    public function __construct(ClientRepository $repository, ClientValidator $validator){
        $this->repository = $repository;
        $this->validator = $validator;
    }


    public function all(){
        return response()->json($this->repository->skipPresenter()->all());
    }

    public function read($id) {
        try {
            return response()->json($this->repository->find($id));
        } catch(ModelNotFoundException $ex) {
            return response()->json([
                'error' => true,
                'message' => "Client id {$id} not found"
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
        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'message' => "Client id {$id} not found"
            ]);
        }

    }



    public function delete($id){

        try {
            $this->repository->delete($id);
            return response()->json(['error' => false,'message' => "Client {$id} deleted"]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => true,
                'message' => "Client id {$id} not found"
            ]);
        }

    }


}