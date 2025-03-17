<?php

require '../Entity/User.php';
use Entity\User;
use Entity\UserInterface;

$user = new User();
$user->setId(1)
    ->setName('Ім\'я')
    ->setEmail('andrew@andrew.com')
    ->setPassword('secretPassword');

if(!($user instanceof JsonSerializable) or !($user instanceof UserInterface)){
    echo "It is not a valid user";
    return;
}

echo json_encode($user, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
