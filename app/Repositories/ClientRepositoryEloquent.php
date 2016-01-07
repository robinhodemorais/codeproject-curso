<?php
/**
 * Created by PhpStorm.
 * User: Robinho de Morais
 * Date: 01/09/2015
 * Time: 20:22
 */

namespace CodeProject\Repositories;

use CodeProject\Entities\Client;
use CodeProject\Presenters\ClientPresenter;
use Prettus\Repository\Eloquent\BaseRepository;

class ClientRepositoryEloquent extends BaseRepository implements ClientRepository {

    protected $fieldSearchable = [
      'name'
    ];

    public function model(){
        return Client::class;
    }

    public function presenter(){
        return ClientPresenter::class;
    }

}