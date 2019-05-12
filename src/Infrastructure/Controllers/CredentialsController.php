<?php

namespace App\Infrastructure\Controllers;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Application\Command\Owner\SearchOwnerByFbDelegatedCommand;
use App\Application\CommandHandler\Owner\SearchOwnerByFbDelegatedHandler;
use App\Application\Command\Owner\CreateOwnerCommand;
use App\Application\CommandHandler\Owner\CreateOwnerHandler;

class CredentialsController extends Controller
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
        return new Response("FB privacy");

    }

    public function conditions()
    {
        return new Response("FB conditions");
    }


}


