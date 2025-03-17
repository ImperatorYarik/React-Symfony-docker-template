<?php

require '../Entity/User.php';
require '../Action/UserAction.php';
use Entity\User;
use Entity\UserInterface;

//$user = new User();
//$user->setId(1)
//    ->setName('Ім\'я')
//    ->setEmail('andrew@andrew.com')
//    ->setPassword('secretPassword');

//if(!($user instanceof JsonSerializable) or !($user instanceof UserInterface)){
//    echo "It is not a valid user";
//    return;
//}

$pdo = new PDO('mysql:host=mysql;dbname=user_database;charset=utf8', 'root', 'root');
//$user = $pdo->query('SELECT * FROM user WHERE id = 2')->fetch();
//
//$newUser = new User(id: $user['id'], name: $user['name'], email: $user['email'], password: $user['password']);
//print_r(json_encode($newUser));
//echo json_encode($user, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

//$query = "INSERT INTO user (name, email, password) VALUES(:name, :email, :password)";
//$statement = $pdo->prepare($query);
//
//$statement->bindValue(':name', 'Tony');
//$statement->bindValue(':email', 'tony@example.com');
//$statement->bindValue(':password', password_hash(1234567890, PASSWORD_DEFAULT));
//
//if (!$statement->execute()) {
//    echo 'Error: ' . $statement->errorInfo()[2];
//}
//
//echo "New record created successfully";

$user = new UserAction;

$userEntity = $user(['id' => 1, 'name' => 'Tony', 'email' => 'tony@example.com', 'password' => 'password']);

print_r(json_encode($userEntity));







