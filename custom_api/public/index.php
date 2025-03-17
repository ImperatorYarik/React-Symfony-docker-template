<?php

require '../Entity/User.php';
use Entity\User;

$user = new User();
$user->setId(1)
    ->setName('Andrew')
    ->setEmail('andrew@andrew.com')
    ->setPassword('secretPassword');

if(!($user instanceof JsonSerializable)){
    echo "It is not a valid user";
    return;
}

echo $user->jsonSerialize();
