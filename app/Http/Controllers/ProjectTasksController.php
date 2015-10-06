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

        return $this->service->all($id);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {

        return $this->service->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @param $tasksid
     * @return Response
     */
    public function show($id, $tasksid)
    {
        return $this->service->read($id,$tasksid);

    }



    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id, $tasksid)
    {
        return $this->service->update($request->all(),$tasksid);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
       return $this->service->delete($id);
    }
}
