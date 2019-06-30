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
        list($urlForThingConnected, $urlForThingInfo) = self::getUrlsForThing($thing->getId());

        return [
            'id' => $thing->getId(),
            'root' => $thing->getRoot(),
            'urlForThingConnected' => $urlForThingConnected,
            'urlForThingInfo' => $urlForThingInfo,
        ];
    }

    /*
     * DUDA VICTOR, he probado muchas cosas, pero no consigo usar el Router aqui:
     *  - Usar servicio con -"@route" como argumento
     *  - Usar ThingArraySerializer2, que no es STATIC
//            'urlForThingConnected' => $this->container->get('router')->generate('api_thing_info', ['thingId' => $thing->getId()]),
     * TODO (cuando este entregado el proyecto) 19 Abril:
     *     Hacer un singleton del serializador, que por constructor reciviese RouteCollection y en el método el contexto
     * */
    public static function getUrlsForThing($thingId)
    {
        //        De momento ponlo en el serializador. En el controller NO, que vas a tener que repetir código en caso de que necesites esa funcionalidad en ltro lado

        // DUDA Victor, manera de obterner la ruta
        $apiRouteYaml = Yaml::parseFile('../src/Infrastructure/Resources/config/routes/api.yaml');
        $thingRouteYaml = Yaml::parseFile('../src/Infrastructure/Resources/config/routes/thing.yaml');

        $routes = new RouteCollection();

        $routes->add('api_thing_info', new Route($apiRouteYaml['api_thing_info']['path']));
        $routes->add('thing_info', new Route($thingRouteYaml['thing_info']['path']));
        $context = new RequestContext();

        $urlGenerator = new UrlGenerator($routes, $context);
        $urlForThingConnected = $urlGenerator->generate('api_thing_info', ['thingId' => $thingId]);
        $urlForThingInfo = $urlGenerator->generate('thing_info', ['thingId' => $thingId]);

        return [
            $urlForThingConnected,
            $urlForThingInfo
        ];
    }
}