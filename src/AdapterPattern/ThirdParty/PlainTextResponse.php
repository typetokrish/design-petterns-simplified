<?php

namespace App\AdapterPattern\ThirdParty;

/**
 * Consider it as an older Thirdparty library
 * Class that send PlainText response to client
 */
class PlainTextResponse 
{
    private $httpStatusCode;

    private $data;

    /**
     * Set the http status code
     */
    public function setCode(string $code)
    {
        $this->httpStatusCode = $code;
    }

    /**
     * set the data to be displayed
     */
    public function setData(array $data) 
    {
        $this->data  = $data;
    }

    /**
     * Send the reponse 
     */
    public function respond()
    {
        echo "You are seeing the data in Plain Text format with Status code as ".$this->httpStatusCode;
        print_r($this->data);
    }
}