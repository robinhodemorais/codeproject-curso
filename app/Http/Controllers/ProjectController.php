<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Services\ProjectService;
use Illuminate\Http\Request;

class ProjectController extends Controller
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
     * @param ProjectRepository $repository
     * @param ProjectService $service
     */
    public function __construct(ProjectRepository $repository, ProjectService $service){
        $this->repository = $repository;
        $this->service = $service;
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
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request) {
        return $this->service->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
         return $this->service->read($id);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id){
            return $this->service->update($request->all(),$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)  {

        return $this->service->delete($id);

    }


    /**
     * @param $id
     * @param $memberId
     * @return Response
     */
    public function addMember($id, $memberId)
    {
        return $this->service->addMember($id, $memberId);
    }
    /**
     * @param $id
     * @param $memberId
     * @return Response
     */
    public function removeMember($id, $memberId)
    {
        return $this->service->removeMember($id, $memberId);
    }
    /**
     * @param $id
     * @param $memberId
     * @return Response
     */
    public function isMember($id, $memberId)
    {
        return $this->service->isMember($id, $memberId);
    }
}
