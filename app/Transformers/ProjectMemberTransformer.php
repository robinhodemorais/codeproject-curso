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

class ProjectMemberTransformer extends TransformerAbstract
{

    /*
     * Transformer, transforma as informações da maneira que vc queira apresentar
     *
     */

    public function transform(User $member){
        return [
            'member_id' => $member->id,
            'name' => $member->name
        ];
    }



}