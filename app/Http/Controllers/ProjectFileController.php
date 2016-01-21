<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectFileRepository;
use CodeProject\Services\ProjectFileService;

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
     *
     * @return Response
     */
    public function index($id)
    {
        return $this->repository->findWhere(['project_id' => $id]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */

    public function store(Request $request){
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();

        $data['file'] = $file;
        $data['extension'] = $extension;
        $data['name'] = $request->name;
        $data['project_id'] = $request->project_id;
        $data['description'] = $request->description;

        $this->service->create($data);
    }

    /*
    public function store(Request $request) {

            $rules = array('file' => 'required');

            $file = $request->file('file');

            $validator = Validator::make( array('file'=> $file) , $rules);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => "Arquivo n�o selecionado"
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
*/
    public function showFile($id){
        if ($this->service->checkProjectPermissions($id) == false) {
            return ['error' => 'Access Forbidden'];
        }

        //pega o caminho do arquivo
        $filePath = $this->service->getFilePath($id);
        //passa o caminho do arquivo para pegar os dados dele
        $fileContent = file_get_contents($filePath);
        //codifica o arquivo
        $file64 = base64_encode($fileContent);


        return [
            'file' => $file64,
            'size' => filesize($filePath),
            'name' => $this->service->getFileName($id)
        ]; //response()->download($this->service->getFilePath($id));
    }


    public function show($id){
        if ($this->service->checkProjectPermissions($id) == false) {
            return ['error' => 'Access Forbidden'];
        }

        return $this->repository->find($id);
    }


    public function update(Request $request, $id){
        if ($this->service->checkProjectOwner($id) == false) {
            return ['error' => 'Access Forbidden'];
        }

        return $this->service->update($request->all(), $id);
    }


    public function destroy($id)  {

        if ($this->service->checkProjectOwner($id) == false) {
            return ['error' => 'Access Forbidden'];
        }
        $this->repository->delete($id);

    }



}
