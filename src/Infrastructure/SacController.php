<?php

namespace App\Infrastructure;

use App\Application\Command\Thing\CreateThingCommand;
use App\Application\CommandHandler\Owner\CreateOwnerHandler;
use App\Domain\Entity\Owner;
use App\Infrastructure\Owner\MySQLOwnerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Application\Command\Owner\CreateOwnerCommand;
use Doctrine\ORM\EntityManager;
use Symfony\Contracts\Service;


class SacController extends Controller
{

    /**
     * @Route("/test", name="test", methods={"GET"})
     */
    public function test()
    {
        return $this->render('test.html.twig');
    }

    // TODO: cambiar nombre de este controlador, algo estilo CredentialsController
//appId      : '361174884467644',

//version    : 'v3.2'

    /**
     * @Route("/", name="login", methods={"GET"})
     */
    public function login()
    {
        // return new Response($cookie);
        // $request->headers->setCookie(new Cookie('Peter', 'Griffin', time() + 3600));
        return $this->render('login.html.twig', ['login_ok_url' => $this->generateUrl('loginOk'), 'login_ko_url' => $this->generateUrl('login')]);
    }

    /**
     * @Route("/loginOk", name="loginOk", methods={"GET"})
     */
    public function loginOk(Request $request)
    {


        // meter en bbdd ID

        // $request->headers;
        // $ei = $request;
        // return new Response(var_dump($request->headers));
        return $this->render('loginOk.html.twig', ['login_ok_url' => $this->generateUrl('loginOk'), 'login_ko_url' => $this->generateUrl('login')]);
    }


    /**
     * @Route("/loginStatus", name="loginStatus", methods={"GET"})
     */
    public function loginStatus()
    {
        return $this->render('loginStatus.html.twig');
    }


    /**
     * @Route("/privacy", name="privacy", methods={"GET"})
     */
    public function privacy()
    {
        return new Response("FB privacy");

    }

    /**
     * @Route("/conditions", name="conditions", methods={"GET"})
     */
    public function conditions()
    {
        return new Response("FB conditions");
    }


}


