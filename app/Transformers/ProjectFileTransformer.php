<?php
/**
 * Created by PhpStorm.
 * User: Robinho
 * Date: 11/10/2015
 * Time: 21:12
 */

namespace CodeProject\Transformers;

use CodeProject\Entities\Project;
use CodeProject\Entities\ProjectFile;
use League\Fractal\TransformerAbstract;

class ProjectFileTransformer extends TransformerAbstract
{

    public function transform(ProjectFile $o){
        return [
            'id' => $o->id,
            'name' => $o->name,
            'extension' => $o->extension,
            'description' => $o->description,
            'project_id' => $o->project_id
        ];

    }



}