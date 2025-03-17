<?php

use Entity\User;
class UserAction
{
    public function __invoke($data) : User
    {
        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        return new User($data['id'], $data['name'], $data['email'], $password);
    }
}