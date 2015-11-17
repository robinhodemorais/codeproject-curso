<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Services\ProjectService;
use CodeProject\Validators\ProjectFileValidator;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Prettus\Validator\Exceptions\ValidatorException;

class ProjectFileController extends Controller
{

    /**
     * @var ProjectRepository
     */
    private $repository;
    /**
     * @var ProjectService
     */
    private $service;
    /**
     * @var ProjectFileValidator
     */
    private $validator;

    /**
     * @param ProjectRepository $repository
     * @param ProjectService $service
     */
    public function __construct(ProjectRepository $repository, ProjectService $service, ProjectFileValidator $validator, Filesystem $filesystem, Storage $storage){
        $this->repository = $repository;
        $this->service = $service;
        $this->validator = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @param ProjectRepository $repository
     * @return Response
     */
    public function index()
    {
        return $this->service->all();
       // return $this->repository->skipPresenter()->all();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */

    /*
     * Vai armazer o arquivo no banco de dados e fazer o upload
     *
     */
    public function store(Request $request) {

            $rules = array('file' => 'required');

            $file = $request->file('file');

            $validator = Validator::make( array('file'=> $file) , $rules);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => "Arquivo não selecionado"
            ]);
        } elseif($validator->passes()) {


            $extension = $file->getClientOriginalExtension();

            $data['file'] = $file;
            $data['extension'] = $extension;
            $data['name'] = $request->name;
            $data['project_id'] = $request->project_id;
            $data['description'] = $request->description;


            try {
                $this->validator->with($data)->passesOrFail();

                $this->service->createFile($data);

            }  catch (ValidatorException $e) {

            return response()->json([
                'error' => true,
                'message' => $e->getMessageBag()
            ]);
        }

        }


    }


    public function destroy($idProject,$idFile)  {

        return $this->service->deleteFile($idProject,$idFile);

    }



}
