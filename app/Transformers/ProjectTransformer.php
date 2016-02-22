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
    //não é aconselhado, pois pode pesar muito os dados
    protected $defaultIncludes = ['members','notes','tasks','files','client'];
    //Seria ideal utilizar o available, porque por demanda configuramos o front
    //com o include: 'members', 'tasks'....etc
    //protected $availableIncludes = ['members','notes','tasks','files','client'];


    public function transform(Project $project){
        return [
            'id' => $project->id,
            'client_id' => $project->client_id,
            'owner_id' => $project->owner_id,
            'name' => $project->name,
            'description' => $project->description,
            'progress' => (int) $project->progress,
            'status' => $project->status,
            'due_date' => $project->due_date,
            'is_member' => $project->owner_id != \Authorizer::getResourceOwnerId(),
            //conta a quantidade de tasks, para exebir no front
            'tasks_count' => $project->tasks->count(),
            //
            'tasks_opened' =>$this->countTasksOpened($project)
        ];
    }

    public function includeMembers(Project $project){
        //na hora de exibir os membros, receber o transformer dos membros para apresentar,
        //por�m para mostrar tem que utilizar o atributo protegido $defaultIncludes para
        //poder mostrar
        //return  $this->collection($project->members, new ProjectMemberTransformer());
        return  $this->collection($project->members, new MemberTransformer());
    }

    public function includeNotes(Project $project){
        //utilizando o collection vamos serializar as coleções "varios dados"
        //para coleção de objetos
        //se for 1 dado só, usa o item, como no client
        return $this->collection($project->notes, new ProjectNoteTransformer());
    }

    public function includeFiles(Project $project){
        return $this->collection($project->files, new ProjectFileTransformer());
    }

    public function includeTasks(Project $project){
        return $this->collection($project->tasks, new ProjectTasksTransformer());
    }

    public function includeClient(Project $project){
        return $this->item($project->client, new ClientTransformer());
    }

    public function countTasksOpened(Project $project){
        $count = 0;

        foreach($project->tasks as $o) {
            //verifica se o status é igual para contar
            if ($o->status == 1) {
                $count++;
            }
        }

        return $count;

    }

}