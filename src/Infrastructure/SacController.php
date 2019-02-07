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
        return new Response("<html>
<head>    <script>
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
</head>
<body>

login with facebook         
<script>
FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
    console.log(response);
});

</script>
</body>
   </html>
    ");
    }
}


