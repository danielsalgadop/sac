<?php

namespace App\Domain\Repository;


class ThingConnectorRepository
{
    const ENDPOINT = 'localhost';
    const PORT = '8001';

    // Mover a ConnectedThingRepository
    function sendCurl($id,$thing_user_name,$thing_password)
    {
        // Esto q es tan variable, definirlo conf/ en parámetros, o hacerlo en services
        $ch = curl_init(self::ENDPOINT . '/' . $id);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_PORT, 8001);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'user: '.$thing_user_name,
                'password: '.$thing_password
            )
        );


        $result = curl_exec($ch);
//        file_put_contents("/tmp/get_actions." . $time . ".html", __METHOD__ . ' ' . __LINE__ . PHP_EOL . var_export($result, true) . PHP_EOL, FILE_APPEND);
//        var_dump($result);
        return $result;
    }

}