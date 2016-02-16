<?php
/**
 * Created by PhpStorm.
 * User: Robinho
 * Date: 11/10/2015
 * Time: 21:19
 */

namespace CodeProject\Presenters;

use CodeProject\Transformers\UserTransformer;
Use Prettus\Repository\Presenter\FractalPresenter;


class UserPresenter extends FractalPresenter
{

    /*
     * o Presenters recebe o transformer para apresentar
     *
     */

    public function getTransformer(){
        return new UserTransformer();
    }

}