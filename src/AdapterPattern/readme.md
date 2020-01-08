## Adapter - Structural Pattern

The design pattern helps to bridge between incompatible interfaces without modyfying the business logic or the client code.
Suppose your system uses a third party library and your business logic has an expected interface ie your code expects the
library to have set of methods and your application runs fine . Later on you want to replace the library with another one and the
interface for this library has different methods and signature. To accomodate this, you might need to change your business logic or the implementation. Here we use an adapter to wrap the new library still the adapter keeps the same interface that your app expects. The adapter converts the existing interface to to new interface that the new library expects without affecting your client code much .


## We have an example application

Assume we have an API that displays some data in the plain text format , but with an http status code. Our app has a class that renders this data in plain text format but using a third party library to render this response.
Our client class looks like this:

```
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
```

This class needs a object in its constructor, using its methods it generate the response.

Currently this class expets an object of PlainTextResponse to send plain text as reponse.
Lets see the code from the PlainTextResponse

```
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
```

This means the AppiResponder uses methods setCode, setData and render exposed from an Interface of PlainTextResponse.
Let us see how we use the ApiResponder to process data and send response.

```
<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\AdapterPattern\ThirdParty\PlainTextResponse;
use App\AdapterPattern\Service\ApiResponder;
use App\AdapterPattern\ThirdParty\JsonResponse;
use App\AdapterPattern\Adapter\JsonResponseAdapter;


/**
 * The data to be send as response from an API
 */
$data = [
    'name' => 'Some Name',
    'age' => 10
];

/**
 * The http status code to be used
 */
$code = 200;

/**
 * We define the current http response handler, ie Plain Text
 */
$responseType = new PlainTextResponse();
/**
 * the actual client code which respond with the PlainText Library
 */
$api = new ApiResponder($responseType);
$api->sendResponse($data, $code);

```

Now imagine you are at a situattion to send the api response as json than plain text and you have a library which has methods different than the PlainTextResponse. 
You are not going to modify the APiResponder class which is your business logic, but you need some way to pass the JsonResponse library to ApiResponder to get the response as Json. 
For this, you cannot pass JsonResponse directly since its interface differs from what being used by PlainTextResponse.

Here you create an adaptor which provides an interface similar to PlainTextResponse but uses JsonResponse library internally. And you dont need to alter your busines logic or client implementation.

The adaptor class look like this :

```
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
```

Same interface or requirements similar to PlainTextResponse which is being expected by ApiResponder.

Let us see how to use this adapter without changing business logic, ie your ApiResponder.

```
<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\AdapterPattern\ThirdParty\PlainTextResponse;
use App\AdapterPattern\Service\ApiResponder;
use App\AdapterPattern\ThirdParty\JsonResponse;
use App\AdapterPattern\Adapter\JsonResponseAdapter;


/**
 * The data to be send as response from an API
 */
$data = [
    'name' => 'Some Name',
    'age' => 10
];

/**
 * The http status code to be used
 */
$code = 200;


$jsonResponse = new JsonResponse();
$jsonResponseAdapter = new JsonResponseAdapter($jsonResponse);

/**
 * Now we use the same client code to return json response
 */

$api = new ApiResponder($jsonResponseAdapter);
$api->sendResponse($data, $code);

```

This is how we use adapter pattern to bridge between incompatible interfaces without changing them. 

