<?php

namespace App\Application\Command\Thing;


class CreateThingCommand
{
    private $root;
    private $userName;
    private $password;

    public function __construct(string $root, string $userName, string $password)
    {

        $this->root = $root;
        $this->userName = $userName;
        $this->password = $password;
    }

    public function getRoot(): string
    {
        return $this->root;
    }

    public function getUserName(): string
    {
        return $this->userName;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}

