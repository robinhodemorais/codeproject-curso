<?php

namespace CodeProject\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class ProjectTasks extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'name',
        'start_date',
        'due_date',
        'status',
        'project_id'
    ];

    public function project(){
        //return $this->belongsTo('project');
        return $this->belongsTo(Project::class);
    }

}
