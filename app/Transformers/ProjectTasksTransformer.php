<?php
/**
 * Created by PhpStorm.
 * User: Robinho
 * Date: 11/10/2015
 * Time: 21:12
 */

namespace CodeProject\Transformers;

use CodeProject\Entities\ProjectNote;
use CodeProject\Entities\ProjectTasks;
use League\Fractal\TransformerAbstract;

class ProjectTasksTransformer extends TransformerAbstract
{

    /*
     * Transformer, transforma as informa��es da maneira que vc queira apresentar
     *
     */

    public function transform(ProjectTasks $projectTasks){
        return [
            'id' => $projectTasks->id,
            'name' => $projectTasks->name,
            'project_id' => $projectTasks->project_id,
            'start_date' => $projectTasks->start_date,
            'due_date' => $projectTasks->due_date,
            'status' => $projectTasks->status
        ];
    }



}