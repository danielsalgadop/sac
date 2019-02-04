<?php

namespace App\Infrastructure;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SacController extends AbstractController
{
    /**
     * @Route("/login", name="login", methods={"GET"})
     */
    public function login()
    {
        return new Response("login with facebook");
    }
}
