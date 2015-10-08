<?php

namespace CodeProject\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Project extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'owner_id',
        'client_id',
        'name',
        'description',
        'progress',
        'status',
        'due_date'
    ];

    public function owner()
    {
        return $this->belongsTo(User::class);
    }
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function notes(){
        return $this->hasMany(ProjectNote::class);
    }

    public function tasks(){
        return $this->hasMany(ProjectTasks::class);
    }

    public function members(){
        //belongsToMany pertence h� muitos, passa a tabelas que faz o relacionamento
        return $this->belongsToMany(User::class,'project_members');
    }
}
