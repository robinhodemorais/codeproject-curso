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
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

class UserRepositoryEloquent extends BaseRepository implements UserRepository {

    //para realizar um auto complete
    //assim o campo name estara aberto para busca
    protected $fieldSearchable = [
        'name'
    ];

    public function model(){
        return User::class;
    }

    public function boot()
    {
       $this->pushCriteria(app(RequestCriteria::class));
    }


}