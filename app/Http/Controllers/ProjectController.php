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
        $this->middleware('check.project.owner', ['except' => ['index', 'store', 'show' ]]);
        $this->middleware('check.project.permission', ['except' => ['index', 'store', 'update', 'destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param ProjectRepository $repository
     * @return Response
     */
    public function index()
    {
       // return $this->service->all();

        /*
         * PEGA O USER ID : \Authorizer::getResourceOwnerId()
         */

        return $this->repository->findOwner(\Authorizer::getResourceOwnerId());//findWithOwnerAndMember(\Authorizer::getResourceOwnerId());
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
        if ($this->checkProjectPermissions($id)==false){
            return ['error' => 'Access forbidden'];
        }
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

        if ($this->checkProjectOwner($id)==false){
            return ['error' => 'Access forbidden'];
        }

        return $this->service->update($request->all(),$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)  {

        if ($this->checkProjectOwner($id)==false){
            return ['error' => 'Access forbidden'];
        }

        return $this->service->delete($id);

    }


    /**
     * @param $id
     * @param $memberId
     * @return Response
     */
    public function addMember($id, $memberId)
    {
        if ($this->checkProjectPermissions($id)==false){
            return ['error' => 'Access forbidden'];
        }

        return $this->service->addMember($id, $memberId);
    }
    /**
     * @param $id
     * @param $memberId
     * @return Response
     */
    public function removeMember($id, $memberId)
    {
        if ($this->checkProjectPermissions($id)==false){
            return ['error' => 'Access forbidden'];
        }

        return $this->service->removeMember($id, $memberId);
    }
    /**
     * @param $id
     * @param $memberId
     * @return Response
     */
    public function isMember($id, $memberId)
    {
        if ($this->checkProjectPermissions($id)==false){
            return ['error' => 'Access forbidden'];
        }

        return $this->service->isMember($id, $memberId);
    }

    public function showMembers($id){

        if ($this->checkProjectPermissions($id)==false){
            return ['error' => 'Access forbidden'];
        }

        return $this->service->showMembers($id);
    }
/*
    public function showNotes($id){

        if ($this->checkProjectPermissions($id)==false){
            return ['error' => 'Access forbidden'];
        }

        return $this->service->showNotes($id);
    }
*/
    public function showTasks($id){

        if ($this->checkProjectPermissions($id)==false){
            return ['error' => 'Access forbidden'];
        }

        return $this->service->showTasks($id);
    }

    private function checkProjectOwner($projectId){

        $userId =  \Authorizer::getResourceOwnerId();

        return $this->repository->isOwner($projectId,$userId);

    }

    private function checkProjectMember($projectId){

        $userId =  \Authorizer::getResourceOwnerId();

        return $this->repository->hasMember($projectId,$userId);

    }

    //verifica se o usu�rio est� no projeto para poder visualizar ele
    private function checkProjectPermissions($projectId){
        if ($this->checkProjectOwner($projectId) or $this->checkProjectMember($projectId)){
            return true;
        }

        return false;
    }




}
