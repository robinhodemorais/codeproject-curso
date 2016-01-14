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
use Prettus\Validator\Exceptions\ValidatorException;

use \Illuminate\Filesystem\Filesystem;
use \Illuminate\Contracts\Filesystem\Factory as Storage;



class ProjectFileService
{
    /**
     * @var ProjectFileRepository
     */
    protected $repository;

    /**
     * @var ProjectRepository
     */
    protected $projectRepository;

    /**
     * @var ProjectFileValidator
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

    public function __construct(ProjectFileRepository $repository,
                                ProjectRepository $projectRepository,
                                ProjectFileValidator $validator,
                                Filesystem $filesystem,
                                Storage $storage)
    {
        $this->repository = $repository;
        $this->projectRepository = $projectRepository;
        $this->validator = $validator;
        $this->filesystem = $filesystem;
        $this->storage = $storage;
    }


    /*
     * Cria o novo arquivo no sistema
     */
    public function create(array $data){

        try {

            $this->validator->with($data)->passesOrFail();

            //utilizando o mesmo repository do project
            //utilizando o skipPresenter ele retorna o array
            $project = $this->projectRepository->skipPresenter()->find($data['project_id']);
            // dd($project);
            $projectFile = $project->files()->create($data);


            //Storeage facede que executa o metodo put, cria o arquivo com o nome e extensiion
            //File face que faz upload
            $this->storage->put($projectFile->id . "." . $data['extension'], $this->filesystem->get($data['file']));

           /* if ($this->storage->exists($projectFile->id . "." . $data['extension'])) {
                return response()->json($projectFile->name . " up success !!");
            }
            */

            return $projectFile;

        } catch (ValidatorException $e) {

            return response()->json([
                'error' => true,
                'message' => $e->getMessageBag()
            ]);
        }

    }

    public function update(array $data, $id) {
        try {
            $this->validator->with($data)->passesOrFail();

            return $this->repository->update($data,$id);

        } catch (ValidatorException $e) {
            return [
              'error' => true,
               'message' => $e->getMessageBag()
            ];
        }

    }

    public function getFilePath($id){
        $projectFile = $this->repository->skipPresenter()->find($id);
        return $this->getBaseUrl($projectFile);
    }


    public function getBaseURL($projectFile){
        switch ($this->storage->getDefaultDriver()) {
            case 'local':
                return $this->storage->getDriver()->getAdapter()->getPathPrefix()
                    .'/'. $projectFile->id . '.' . $projectFile->extension;
        }
    }


    public function delete($id)
    {
       // try {


           // $projectFile = $this->repository->skipPresenter()->with(['files'])->find($idFile);

            /*
             * Busco o File do project e acesso o files que está relacionando no Project buscando o file
             */
            $projectFile = $this->repository->skipPresenter()->find($id);
            if($this->storage->exists($projectFile->id.'.'.$projectFile->extension)){
                $this->storage->delete($projectFile->id.'.'.$projectFile->extension);
                return $projectFile->delete();
            }


            /*
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

            */

    }

    public function checkProjectOwner($projectFileId){

        $userId =  \Authorizer::getResourceOwnerId();
        $projectId = $this->repository->skipPresenter()->find($projectFileId)->project_id;

        return $this->projectRepository->isOwner($projectId,$userId);

    }


    public function checkProjectMember($projectFileId){

        $userId =  \Authorizer::getResourceOwnerId();
        $projectId = $this->repository->skipPresenter()->find($projectFileId)->project_id;

        return $this->projectRepository->hasMember($projectId,$userId);

    }

    //verifica se o usuário está no projeto para poder visualizar ele
    public function checkProjectPermissions($projectFileId){
        if ($this->checkProjectOwner($projectFileId) or $this->checkProjectMember($projectFileId)){
            return true;
        }

        return false;
    }

}
