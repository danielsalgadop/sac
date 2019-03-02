<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Thing;

class ThingConnectorRepository
{
    const ENDPOINT = 'localhost';
    const PORT = '8001';

    function sendCurl($id, $thing_user_name, $thing_password)
    {
        // Esto q es tan variable, definirlo conf/ en parámetros, o hacerlo en services
        $ch = curl_init(self::ENDPOINT . '/' . $id);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_PORT, 8001);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'user: ' . $thing_user_name,
                'password: ' . $thing_password
            )
        );


        $result = curl_exec($ch);
        // TODO: esto tiene sentido aqui?
//        if($result == null){
//            throw new \Exception("Connection Error");
//        }
//        if(isset($result->error)){
//            throw new \Exception($result->error);
//        }

//        var_dump($result);
        return $result;
    }

    public function GetThingByIdOrException(int $id, string $thing_user_name, string $thing_password)
    {
        return $this->sendCurl($id, $thing_user_name, $thing_password);
    }
}