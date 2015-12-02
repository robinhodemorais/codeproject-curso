<?php
/**
 * Created by PhpStorm.
 * User: Robinho de Morais
 * Date: 01/09/2015
 * Time: 21:11
 */

namespace CodeProject\Services;


use CodeProject\Repositories\ProjectFileRepository;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validators\ProjectFileValidator;
use CodeProject\Validators\ProjectValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Prettus\Validator\Exceptions\ValidatorException;

use \Illuminate\Filesystem\Filesystem;
use \Illuminate\Contracts\Filesystem\Factory as Storage;



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
     * @var Filesystem
     */
    private $filesystem;
    /**
     * @var Storage
     */
    private $storage;
    /**
     * @var ProjectFileValidator
     */
    private $fileValidator;

    /**
     * @param ProjectRepository $repository
     * @param ProjectValidator $validator
     */
    public function __construct(ProjectRepository $repository, ProjectValidator $validator,
                                ProjectFileValidator $fileValidator, Filesystem $filesystem,
                                Storage $storage)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->filesystem = $filesystem;
        $this->storage = $storage;
        $this->fileValidator = $fileValidator;
    }


    public function all()
    {
        //return response()->json($this->repository->with(['owner', 'client', 'notes', 'members', 'tasks'])->all());
        //passa o Authorizer para verificar se o usuário tem acesso a ver
        //return $this->repository->skipPresenter()->with(['owner', 'client', 'notes', 'members', 'tasks'])->findWhere(['owner_id' => \Authorizer::getResourceOwnerId()]);
        return $this->repository->with(['owner', 'client', 'notes', 'members', 'tasks'])->findWhere(['owner_id' => \Authorizer::getResourceOwnerId()]);
    }


    public function read($id) {
        try {
            return $this->repository->skipPresenter()->with(['owner', 'client', 'notes', 'members', 'tasks'])->find($id);
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

    /*
    public function showNotes($id)
    {
        try {
            // return response()->json($this->repository->find($id)->notes->all());
            return response()->json($this->repository->with(['notes'])->find($id));
        } catch(ModelNotFoundException $ex) {
            return $this->notFound($id);
        }
    }
    */

    public function showMembers($id)
    {
        try {
            return response()->json($this->repository->with(['members'])->find($id));
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

    /*
     * Cria o novo arquivo no sistema
     */
    public function createFile(array $data){

        try {

            //$this->fileValidator->with($data)->passesOrFail();

            //utilizando o mesmo repository do project
            //utilizando o skipPresenter ele retorna o array
            $project = $this->repository->skipPresenter()->find($data['project_id']);
            // dd($project);
            $projectFile = $project->files()->create($data);


            //Storeage facede que executa o metodo put, cria o arquivo com o nome e extensiion
            //File face que faz upload
            $this->storage->put($projectFile->id . "." . $data['extension'], $this->filesystem->get($data['file']));

            if ($this->storage->exists($projectFile->id . "." . $data['extension'])) {
                return response()->json($projectFile->name . " up success !!");
            }

        } catch (ValidatorException $e) {

            return response()->json([
                'error' => true,
                'message' => $e->getMessageBag()
            ]);
        }



    }

    public function deleteFile($idProject,$idFile)
    {
        try {


           // $projectFile = $this->repository->skipPresenter()->with(['files'])->find($idFile);

            /*
             * Busco o File do project e acesso o files que está relacionando no Project buscando o file
             */
            $projectFile = $this->repository->skipPresenter()->find($idProject)->files()->find($idFile);

            //pega no nome do arquivo e extensão para deletar da pasta
            $nomeFile = $idFile.".".$projectFile->extension;

            //deleta da pasta
            $this->filesystem->delete($nomeFile);

            //return response()->json(['error' => false,'message' => "ProjectFile {$idFile} deleted"]);

        } catch(ModelNotFoundException $ex) {
            return $this->notFound($idFile);
        }


        //deleta o file da tabela
        try {
            $this->repository->skipPresenter()->find($idProject)->files()->detach($idFile);
        } catch (ModelNotFoundException $e) {

            try {
                $this->repository->skipPresenter()->find($idProject)->files()->detach($idFile);
                return response()->json(['error' => false,'message' => "ProjectFile {$idFile} deleted"]);
            } catch (ModelNotFoundException $e) {
                return response()->json([
                    'error' => true,
                    'message' => "ProjectFile {$idFile} not found"
                ]);
            }

        }


    }

}
