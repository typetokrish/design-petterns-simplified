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

//After one year, we need to send JSON response using a library. But the library has different interface than used by current API responser//
//So we need an adapter to match the interface for PlainTextResponse to avoid changes in client code//

$jsonResponse = new JsonResponse();
$jsonResponseAdapter = new JsonResponseAdapter($jsonResponse);

/**
 * Now we use the same client code to return json response
 */

$api = new ApiResponder($jsonResponseAdapter);
$api->sendResponse($data, $code);




