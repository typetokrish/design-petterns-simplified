<?php

namespace App\AdapterPattern\ThirdParty;

/**
 * New library that sends JsonResponse
 */
class JsonResponse {

    public function response(array $data, string $statusCode) 
    {
        
        echo "You are seeing this data in JSON format with HTTP Status Code as $statusCode";
        print_r($data);
        die();
    }
}

