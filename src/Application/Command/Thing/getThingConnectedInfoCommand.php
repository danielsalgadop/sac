<?php

namespace App\Application\Command\Thing;

class getThingConnectedInfoCommand
{
    private $id;
    private $thing_username;
    private $thing_password;

    // TODO: PSR
    public function __construct(int $id, string $thing_username, string $thing_password)
    {
        $this->id = $id;
        $this->thing_username = $thing_username;
        $this->thing_password = $thing_password;
    }

    public function getThingUsername()
    {
        return $this->thing_username;
    }

    public function getThingPassword()
    {
        return $this->thing_password;
    }

    public function getId()
    {
        return $this->id;
    }
}