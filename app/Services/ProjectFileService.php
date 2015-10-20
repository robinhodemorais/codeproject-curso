<?php
/**
 * Created by PhpStorm.
 * User: Robinho de Morais
 * Date: 01/09/2015
 * Time: 21:11
 */

namespace CodeProject\Services;


use CodeProject\Repositories\ProjectFileRepository;
use CodeProject\Validators\ProjectFileValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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

    /**
     * @param ProjectFileRepository $repository
     * @param ProjectFileValidator $validator
     */
    public function __construct(ProjectFileRepository $repository, ProjectFileValidator $validator, Filesystem $filesystem, Storage $storage)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->filesystem = $filesystem;
        $this->storage = $storage;
    }



    /*
     * Cria o novo arquivo no sistema
     */
    public function createFile(array $data){
        try {

            $this->validator->with($data)->passesOrFail();

            //utilizando o skipPresenter ele retorna o array
            $project = $this->repository->skipPresenter()->find($data['project_id']);
            // dd($project);
            $projectFile = $project->files()->create($data);

            //Storeage facede que executa o metodo put, cria o arquivo com o nome e extensiion
            //File face que faz upload
            $this->storage->put($projectFile->id . "." . $data['extension'], $this->filesystem->get($data['file']));

        } catch (ValidatorException $e) {

            return response()->json([
                'error' => true,
                'message' => $e->getMessageBag()
            ]);
        }






    }

    public function deleteFile($file)
    {
        try {
            $this->filesystem->delete($file);

            dd($file);
        } catch (ModelNotFoundException $e) {

            try {
                $this->filesystem->delete($file);
                return response()->json(['error' => false,'message' => "Project {$file} deleted"]);
            } catch (ModelNotFoundException $e) {
                return response()->json([
                    'error' => true,
                    'message' => "Project id {$file} not found"
                ]);
            }

        }
    }

}
