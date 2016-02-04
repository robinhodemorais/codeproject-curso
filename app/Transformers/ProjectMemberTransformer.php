<?php
/**
 * Created by PhpStorm.
 * User: Robinho
 * Date: 11/10/2015
 * Time: 21:12
 */

namespace CodeProject\Transformers;

use CodeProject\Entities\Project;
use CodeProject\Entities\ProjectMembers;

use League\Fractal\TransformerAbstract;

class ProjectMemberTransformer extends TransformerAbstract
{

    /*
     * Transformer, transforma as informa��es da maneira que vc queira apresentar
     *
     */

    protected $defaultIncludes = [
      'user'
    ];

    public function transform(ProjectMembers $member){
        return [
            'project_id' => $member->project_id
        ];
    }

    public function includeUser(Project $member){
        return $this->item($member,new MemberTransformer());
    }



}