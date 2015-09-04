<?php
/**
 * Created by PhpStorm.
 * User: Robinho de Morais
 * Date: 01/09/2015
 * Time: 21:26
 */

namespace CodeProject\Validators;


use Prettus\Validator\LaravelValidator;

class ProjectNoteValidator extends LaravelValidator {
    protected $rules = [
        'project_id' => 'required|integer',
        'title' => 'required',
        'note' => 'required'
    ];
}