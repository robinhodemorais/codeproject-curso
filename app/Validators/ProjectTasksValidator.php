<?php
/**
 * Created by PhpStorm.
 * User: Robinho de Morais
 * Date: 01/09/2015
 * Time: 21:26
 */

namespace CodeProject\Validators;


use Prettus\Validator\LaravelValidator;

class ProjectTasksValidator  extends LaravelValidator {
    protected $rules = [
        'name' => 'required',
        'start_date' => 'required',
        'due_date' => 'required',
        'status' => 'required'
    ];
}