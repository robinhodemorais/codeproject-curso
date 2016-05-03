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
        return $this->belongsToMany(User::class,'project_members','project_id', 'member_id');
    }

    public function files(){
        return $this->hasMany(ProjectFile::class);
    }

    public function calculatePercentageCompleted() {
        $count = 0;
        $countTotal = 0;
        foreach ($this->tasks as $task){
            //tarefas concluidas
            if ($task->status == 4){
                $count++;
            }

            //todas exceto canceladas
            if ($task->status != 3){
                $countTotal++;
            }

        }

        if ($countTotal == 0) {
            $calc = 0;
        } else {
            $calc = ($count / $countTotal) * 100;
        }
        //return $calc;

        return [ 'percentage' => $calc, 'countTasks' => $countTotal ];
    }


}
