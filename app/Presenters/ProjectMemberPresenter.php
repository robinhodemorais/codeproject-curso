<?php
/**
 * Created by PhpStorm.
 * User: Robinho
 * Date: 11/10/2015
 * Time: 21:19
 */

namespace CodeProject\Presenters;

use CodeProject\Transformers\ProjectMemberTransformer;
Use Prettus\Repository\Presenter\FractalPresenter;


class ProjectMemberPresenter extends FractalPresenter
{

    /*
     * o Presenters recebe o transformer para apresentar
     *
     */

    public function getTransformer(){
        return new ProjectMemberTransformer();
    }

}