<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectFileRepository;
use CodeProject\Services\ProjectFileService;
use CodeProject\Services\ProjectService;
use Illuminate\Http\Request;

class ProjectFileController extends Controller
{

    /**
     * @var ProjectFileRepository
     */
    private $repository;
    /**
     * @var ProjectFileService
     */
    private $service;

    /**
     * @param ProjectFileRepository $repository
     * @param ProjectFileService $service
     */
    public function __construct(ProjectFileRepository $repository, ProjectFileService $service){
        $this->repository = $repository;
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @param ProjectFileRepository $repository
     * @return Response
     */
    public function index()
    {
        return $this->service->all();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */

    /*
     * Vai armazer o arquivo no banco de dados e o upload
     *
     */
    public function store(Request $request) {

/*
            $rules = array(
                'name' => 'required',
                'file' => 'required',
                'description' => 'required',
                'extension' => 'required',
                'project_id' => 'project_id'
              );

            $file = $request->file('file');

            $validator = Validator::make( array('file'=> $file,
                                                'name' =>$request->name,
                                                'description'=> $request->description) , $rules);

        // $this->validator->with($data)->passesOrFail();

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => "Erro ao enviar arquivo"
            ]);
        } elseif($validator->passes())
            {
*/
                $file = $request->file('file');

                $extension = $file->getClientOriginalExtension();

                $data['file'] = $file;
                $data['extension'] = $extension;
                $data['name'] = $request->name;
                $data['project_id'] = $request->project_id;
                $data['description'] = $request->description;





                return $this->service->createFile($data);


           // }


    }


    public function destroy($file)  {

        return $this->service->deleteFile($file);

    }



}
