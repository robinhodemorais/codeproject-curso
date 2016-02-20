<?php
/**
 * Created by PhpStorm.
 * User: Robinho
 * Date: 11/10/2015
 * Time: 21:12
 */

namespace CodeProject\Transformers;

use CodeProject\Entities\Client;
use League\Fractal\TransformerAbstract;

class ClientTransformer extends TransformerAbstract
{

    /*
     * Transformer, transforma as informa��es da maneira que vc queira apresentar
     *
     */

    protected $defaultIncludes = ['projects'];


    public function transform(Client $client){
        return [
            'id' => (int)$client->id,
            'name' => $client->name,
            'responsible' => $client->responsible,
            'email' => $client->email,
            'phone' => $client->phone,
            'address' => $client->address,
            'obs' => $client->obs,
            'created_at' => date_format($client->created_at, "Y-m-d h:m:s"),
            'updated_at' => date_format($client->updated_at, "Y-m-d h:m:s"),
        ];
    }


    public function includeProjects(Client $client){
        //Setamos o default includes para vazio para não criar um loop
        //no transformer Project e Client
        $transformer = new ProjectTransformer();
        $transformer->setDefaultIncludes([]);

        return  $this->collection($client->projects, $transformer);
    }


}