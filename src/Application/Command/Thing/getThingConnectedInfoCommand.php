<?php

namespace App\Application\Command\Thing;

class getThingConnectedInfoCommand
{
    private $id;
    private $thingUsername;
    private $thingPassword;

    public function __construct(int $id, string $thingUsername, string $thingPassword)
    {
        $this->id = $id;
        $this->thingUsername = $thingUsername;
        $this->thingPassword = $thingPassword;
    }

    public function getThingUsername()
    {
        return $this->thingUsername;
    }

    public function getThingPassword()
    {
        return $this->thingPassword;
    }

    public function getId()
    {
        return $this->id;
    }
}