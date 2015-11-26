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
        'name' => 'required',
        'file' => 'required',
        'description' => 'required',
        'extension' => 'required'
    ];
}