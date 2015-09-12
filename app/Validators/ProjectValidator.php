<?php
/**
 * Created by PhpStorm.
 * User: Robinho de Morais
 * Date: 01/09/2015
 * Time: 21:26
 */

namespace CodeProject\Validators;


use Prettus\Validator\LaravelValidator;

class ProjectValidator  extends LaravelValidator {
    protected $rules = [
        'owner_id' => 'required',
        'client_id' => 'required',
        'name' => 'required',
        'progress' => 'required',
        'status' => 'required',
        'due_date' => 'required'
    ];
}