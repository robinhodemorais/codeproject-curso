<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectMembersRepository;
use CodeProject\Repositories\ProjectNoteRepository;
use CodeProject\Services\ProjectMembersService;
use CodeProject\Services\ProjectNoteService;
use Illuminate\Http\Request;

class ProjectMembersController extends Controller
{

    /**
     * @var ProjectNoteRepository
     */
    private $repository;
    /**
     * @var ProjectNoteService
     */
    private $service;

    /**
     * @param ProjectMembersRepository $repository
     * @param ProjectMembersService $service
     */
    public function __construct(ProjectMembersRepository $repository, ProjectMembersService $service){
        $this->repository = $repository;
        $this->service = $service;
        $this->middleware('check.project.owner', ['except' => ['index', 'show' ]]);
        $this->middleware('check.project.permission', ['except' => ['store', 'destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param ProjectMembersRepository $repository
     * @return Response
     */


    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */

    public function index($id){
        return $this->repository->findWhere(['project_id' => $id]);
    }


    public function store(Request $request, $id){
        $data = $request->all();
        $data['project_id'] = $id;


        return $this->service->create($data);
    }

    public function show($id, $idProjectMember){
        return $this->repository->find($idProjectMember);
    }

    public function destroy($id, $idProjectMember){
        $this->service->delete($idProjectMember);
    }

}
