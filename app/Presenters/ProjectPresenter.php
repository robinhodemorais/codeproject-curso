<?php
/**
 * Created by PhpStorm.
 * User: Robinho
 * Date: 11/10/2015
 * Time: 21:19
 */

namespace CodeProject\Presenters;

use CodeProject\Services\ProjectService;
use CodeProject\Transformers\ProjectTransformer;
Use Prettus\Repository\Presenter\FractalPresenter;


class ProjectPresenter extends FractalPresenter
{

    private $projectService;

    public function __construct(ProjectService $projectService){
        $this->projectService = $projectService;
    }

    /*
     * o Presenters recebe o transformer para apresentar
     *
     */

    public function getTransformer(){
        return new ProjectTransformer($this->projectService);
    }

}