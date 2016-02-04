<?php
/**
 * Created by PhpStorm.
 * User: Robinho
 * Date: 11/10/2015
 * Time: 21:12
 */

namespace CodeProject\Transformers;

use CodeProject\Entities\Project;
use League\Fractal\TransformerAbstract;

class ProjectTransformer extends TransformerAbstract
{

    /*
     * Transformer, transforma as informa��es da maneira que vc queira apresentar
     *
     */

    //atributo protegido que fala para apresentar os membros de acordo
    //com o includeMembers
    protected $defaultIncludes = ['members','client'];


    public function transform(Project $project){
        return [
            'id' => $project->id,
            'client_id' => $project->client_id,
            'owner_id' => $project->owner_id,
            //'members' => $project->members,
            'name' => $project->name,
            'description' => $project->description,
            'progress' => (int) $project->progress,
            'status' => $project->status,
            'due_date' => $project->due_date,
            'is_member' => $project->owner_id != \Authorizer::getResourceOwnerId()
        ];
    }

    public function includeMembers(Project $project){
        //na hora de exibir os membros, receber o transformer dos membros para apresentar,
        //por�m para mostrar tem que utilizar o atributo protegido $defaultIncludes para
        //poder mostrar
        //return  $this->collection($project->members, new ProjectMemberTransformer());
        return  $this->collection($project->members, new MemberTransformer());
    }

    public function includeClient(Project $project){
        return  $this->item($project->client, new ClientTransformer());
    }

}