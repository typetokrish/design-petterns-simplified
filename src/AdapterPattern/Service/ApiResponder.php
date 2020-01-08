<?php

namespace App\AdapterPattern\Service;

/**
 * Example business logic
 * This is a client code that sends HTTP Response 
 * to the api caller using some third party library
 */
class ApiResponder
{
    private $response;

    /**
     * Constructor arg : the third party library
     */
    public function __construct($responseHanlder) 
    {
        $this->response = $responseHanlder;
    }

    /**
     * The sendResponse expect the library to have 3 methods attached
     */
    public function sendResponse($data, $code) 
    {
        $this->response->setCode($code);
        $this->response->setData($data);
        $this->response->respond();
    }
}