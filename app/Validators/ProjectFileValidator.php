<?php
/**
 * Created by PhpStorm.
 * User: Robinho de Morais
 * Date: 01/09/2015
 * Time: 21:26
 */

namespace CodeProject\Validators;


use Prettus\Validator\LaravelValidator;

class ProjectFileValidator  extends LaravelValidator {
    protected $rules = [
        'project_id' => 'required',
        'name' => 'required',
        'file' => 'required|mines:jpeg,jpg,png,gif,pdf,zip',
        'description' => 'required'
    ];
}