<?php

namespace App\Entity;

use App\EntityListeners\UserEntityListener;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\EntityListeners;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\Security\Core\User\UserInterface;

#[Entity]
#[EntityListeners([UserEntityListener::class])]
class User implements \JsonSerializable
{
    #[Id]
    #[Column]
    #[GeneratedValue]
    private int $id;

    #[Column(type: 'string', length: 255, nullable: true)]
    private string $myName;

    #[Column(type: 'string', length: 255, unique: true)]
    private string $email;

    #[Column(type: 'string', length: 255)]
    private string $password;

    public function getId(): int
    {
        return $this->id;
    }

    public function getMyName(): string
    {
        return $this->myName;
    }

    public function setMyName(string $myName): User
    {
        $this->myName = $myName;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): User
    {
        $this->password = $password;
        return $this;
    }


    public function jsonSerialize(): array
    {
        return [
            'myName' => $this->myName,
            'email' => $this->email,
        ];
    }

}