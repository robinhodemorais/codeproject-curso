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
    public function store(Request $request)
    {

        return $this->service->create($request->all());
    }


}
