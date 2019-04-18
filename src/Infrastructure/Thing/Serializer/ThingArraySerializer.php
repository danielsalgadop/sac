<?php

namespace App\Infrastructure\Thing\Serializer;

use App\Domain\Entity\Thing;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Yaml\Yaml;

class ThingArraySerializer
{
    public static function serialize(Thing $thing): array
    {
        // DUDA Victor, manera de obterner la ruta
        $apiRouteYaml = Yaml::parseFile('../src/Infrastructure/Resources/config/routes/api.yaml');

        $routes = new RouteCollection();

        $routes->add('api_thing', new Route($apiRouteYaml['api_thing']['path']));
        $context = new RequestContext();

        $urlGenerator = new UrlGenerator($routes, $context);
        $urlForThingConnected = $urlGenerator->generate('api_thing', ['thingId' => $thing->getId()]);


//        $urlForThingConnected = "api/thing/1";
//        $urlForThingConnected = self::getUrlForThingConnected($thing->getId());
        return [
            'id' => $thing->getId(),
            'root' => $thing->getRoot(),
            'urlForThingConnected' => $urlForThingConnected,
//            'urlForThingConnected' => "api/thing/1",
//            'urlForThingConnected' => $this->container->get('router')->generate('api_thing', ['thingId' => $thing->getId()]),
//            'urlForThingConnected' => OwnerApiController::getUrlForThingconnected($thing->getId()),
        ];
    }

    /*
     * DUDA VICTOR, he probado muchas cosas, pero no consigo usar el Router aqui:
     *  - Usar servicio con -"@route" como argumento
     *  - Usar ThingArraySerializer2, que no es STATIC
     * */
    public static function getUrlForThingConnected($thingId)
    {
        // estoy intentando no hardcodear este prefio "api/thing"
        return "api/thing/" . $thingId;
//        return $this->container->get('router')->generate('api_thing', ['thingId' => $thingId]);
        return "api/thing/3";
        //        De momento ponlo en el serializador. En el controller NO, que vas a tener que repetir código en caso de que necesites esa funcionalidad en ltro lado
    }
}