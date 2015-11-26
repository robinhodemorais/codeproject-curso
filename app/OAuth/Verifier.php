<?php
/**
 * Created by PhpStorm.
 * User: Robinho de Morais
 * Date: 03/09/2015
 * Time: 22:12
 */

namespace CodeProject\OAuth;

Use Auth;

class Verifier
{
    public function verify($username, $password)
    {
        $credentials = [
            'email'    => $username,
            'password' => $password,
        ];

        if (Auth::once($credentials)) {
            return Auth::user()->id;
        }

        return false;
    }
}