<?php

namespace App\AdapterPattern\Adapter;

use App\AdapterPattern\ThirdParty\JsonResponse;

/**
 * JsonResponseAdapter , wraps the JsonReponse class inside and keeps the same 
 * interface requirement for the existing ApiResponder 
 */
class JsonResponseAdapter
{
    /**
     * Holds the reference to the third party library
     */
    private $adaptee;

    private $code;

    private $data;

    public function __construct(JsonResponse $adaptee) {
        $this->adaptee = $adaptee;
    }

    public function setCode(string $code) 
    {
        $this->code = $code;
    }

    public function setData(array $data)
    {
        $this->data = $data;
    }

    public function respond()
    {
        $this->adaptee->response($this->data, $this->code);
    }
}