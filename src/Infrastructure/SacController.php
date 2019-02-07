<?php

namespace App\Infrastructure;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SacController extends AbstractController
{
//appId      : '361174884467644',

//version    : 'v3.2'

    /**
     * @Route("/login", name="login", methods={"GET"})
     */
    public function login()
    {
        return new Response("<html>
        <head></head><body>


<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '361174884467644',
      cookie     : true,
      xfbml      : true,
      version    : 'v3.2'
    });
      
    FB.AppEvents.logPageView();   
      
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = \"https://connect.facebook.net/en_US/sdk.js\";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>


        </body>
</html>
    ");
    }
    /**
     * @Route("/loginStatus", name="login", methods={"GET"})
     */
    public function loginStatus()
    {
        return new Response("<html>
        <head></head><body>
        <script>
        
FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
    console.log(\"dasf\");
});

</script>

        </body>
</html>
    ");
    }




    /**
     * @Route("/loginOk", name="loginOk", methods={"GET"})
     */
    public function loginOk(){
        return new Response("FB loginOk");
    }

    /**
     * @Route("/privacy", name="privacy", methods={"GET"})
     */
    public function privacy(){
        return new Response("FB privacy");
    }

    /**
     * @Route("/conditions", name="conditions", methods={"GET"})
     */
    public function conditions(){
        return new Response("FB conditions");
    }


}


