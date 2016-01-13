<?php
/**
 * Created by PhpStorm.
 * User: Robinho
 * Date: 11/10/2015
 * Time: 21:19
 */

namespace CodeProject\Presenters;

use CodeProject\Transformers\ProjectFileTransformer;
Use Prettus\Repository\Presenter\FractalPresenter;


class ProjectFilePresenter extends FractalPresenter
{

    public function getTransformer(){
        return new ProjectFileTransformer();
    }

}