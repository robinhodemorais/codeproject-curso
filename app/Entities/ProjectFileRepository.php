<?php

namespace CodeProject\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class ProjectFileRepository extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [];

}
