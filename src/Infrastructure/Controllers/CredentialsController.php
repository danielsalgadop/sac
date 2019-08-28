<?php

namespace App\Infrastructure\Controllers;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CredentialsController extends AbstractController
{
/*    private $searchOwnerByFbDelegatedHandler;
    private $createOwnerHandler;

    public function __construct(SearchOwnerByFbDelegatedHandler $searchOwnerByFbDelegatedHandler, CreateOwnerHandler $createOwnerHandler)
    {
        $this->searchOwnerByFbDelegatedHandler = $searchOwnerByFbDelegatedHandler;
        $this->createOwnerHandler = $createOwnerHandler;
    }*/

    public function test()
    {
        return $this->render('test.html.twig');
    }

    public function handlebars()
    {
        return $this->render('test/handlebars.html.twig');
    }
    //appId      : '361174884467644',
    //version    : 'v3.2'

    public function login()
    {
        // return new Response($cookie);
        // $request->headers->setCookie(new Cookie('Peter', 'Griffin', time() + 3600));

        // correct FbLogin will redirect to owner_index
        return $this->render('login.html.twig', ['login_ok_url' => $this->generateUrl('owner_index'), 'login_ko_url' => $this->generateUrl('login')]);

    }

    // DEPRECATED
    // public function loginOk(Request $request)
    //{

        // Victor
        // $ownerInfoUrl = urlGenerator

//        return $this->redirect('owner_info', 301);
      //  return $this->forward('App\Infrastructure\Controllers\OwnerController::index', ['ownerFbDelegated' => $ownerFbDelegated]);
    //}


    public function loginStatus()
    {
        return $this->render('loginStatus.html.twig');
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


