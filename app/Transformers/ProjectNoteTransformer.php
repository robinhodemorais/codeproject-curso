<?php
/**
 * Created by PhpStorm.
 * User: Robinho
 * Date: 11/10/2015
 * Time: 21:12
 */

namespace CodeProject\Transformers;

use CodeProject\Entities\ProjectNote;
use League\Fractal\TransformerAbstract;

class ProjectNoteTransformer extends TransformerAbstract
{

    /*
     * Transformer, transforma as informações da maneira que vc queira apresentar
     *
     */

    public function transform(ProjectNote $projectNote){
        return [
            'note_id' => $projectNote->id,
            'project_id' => $projectNote->project_id,
            'title' => $projectNote->title,
            'note' => $projectNote->note,
        ];
    }



}