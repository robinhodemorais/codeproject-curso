<?php
/**
 * Created by PhpStorm.
 * User: Robinho de Morais
 * Date: 01/09/2015
 * Time: 20:22
 */

namespace CodeProject\Repositories;

use CodeProject\Entities\Client;
use CodeProject\Entities\User;
use CodeProject\Presenters\ClientPresenter;
use Prettus\Repository\Eloquent\BaseRepository;

class UserRepositoryEloquent extends BaseRepository implements UserRepository {

    public function model(){
        return User::class;
    }

   



}