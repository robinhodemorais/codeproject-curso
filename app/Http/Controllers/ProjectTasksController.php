<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectTasksRepository;
use CodeProject\Services\ProjectTasksService;
use Illuminate\Http\Request;

class ProjectTasksController extends Controller
{

    /**
     * @var ProjectTasksRepository

    private $repository;
    /**
     * @var ProjectTasksService
     */
    private $service;

    /***
     * @param ProjectTasksRepository $repository
     * @param ProjectTasksService $service
     */
    public function __construct(ProjectTasksRepository $repository, ProjectTasksService $service){
        $this->repository = $repository;
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @param ProjectTasksRepository $repository
     * @return Response
     */
    public function index($id)
    {

       // return $this->service->all($id);
        return $this->repository->findWhere(['project_id' => $id]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request, $id)
    {
        $data = $request->all();
        $data['project_id'] = $id;

        return $this->service->create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @param $tasksid
     * @return Response
     */
    public function show($id, $idTask)
    {
        return $this->repository->find($idTask);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id, $idTask)
    {

        $data = $request->all();
        $data['project'] = $id;

        return $this->service->update($data,$idTask);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id, $idTask)
    {

       $this->service->delete($idTask);
    }


}
