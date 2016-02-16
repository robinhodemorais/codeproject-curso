<?php
/**
 * Created by PhpStorm.
 * User: Robinho
 * Date: 11/10/2015
 * Time: 21:12
 */

namespace CodeProject\Transformers;

use CodeProject\Entities\User;
use League\Fractal\TransformerAbstract;


class UserTransformer extends TransformerAbstract
{

    /*
     * Transformer, transforma as informa��es da maneira que vc queira apresentar
     *
     */

    public function transform(User $user){
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            //'password' => $data->password,
            'remember_token' => $user->remember_token,
        ];
    }



}