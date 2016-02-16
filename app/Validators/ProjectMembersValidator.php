<?php
/**
 * Created by PhpStorm.
 * User: Robinho de Morais
 * Date: 01/09/2015
 * Time: 21:26
 */

namespace CodeProject\Validators;


use Prettus\Validator\LaravelValidator;

class ProjectMembersValidator  extends LaravelValidator {
    protected $rules = [
        'project_id' => 'required',
        'member_id' => 'required',
    ];
}