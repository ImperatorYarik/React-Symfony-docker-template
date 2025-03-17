<?php

namespace Entity;

interface UserInterface
{
    public function getId(): int;
    public function setId(int $id): UserInterface;
    public function getName(): string;
    public function setName(string $name): User;
    public function getEmail(): string;
    public function setEmail(string $email): User;
    public function getPassword(): string;
    public function setPassword(string $password): User;


}