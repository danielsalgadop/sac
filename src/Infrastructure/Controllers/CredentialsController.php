<?php

namespace App\Infrastructure\Controllers;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\HttpFoundation\Response;

class CredentialsController extends AbstractController
{
    public function login()
    {
        // correct FbLogin will redirect to owner_index
        return $this->render('login.html.twig', ['login_ok_url' => $this->generateUrl('owner_index'), 'login_ko_url' => $this->generateUrl('login')]);
    }

    public function privacy()
    {
        return $this->render('Facebook/privacy.html.twig');
    }

    public function conditions()
    {
        return $this->render('Facebook/conditions.html.twig');
    }


}


