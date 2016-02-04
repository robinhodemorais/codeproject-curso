<?php

namespace CodeProject\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class ProjectMembers extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'project_id',
        'user_id',
    ];

/*
    public function project(){
        return $this->belongsTo(Project::class);
    }
*/

    public function projects()
    {
        //return $this->belongsToMany(Project::class, 'project_members', 'member_id', 'project_id');
        return $this->belongsTo(Project::class);
    }

    public function member(){
        return $this->belongsTo(User::class);
    }


}
