<?php
/**
 * Example use of PBAPI (with oauth) installed
 *
 * usage: php pbapiexample.php [consumer_key] [consumer_secret] [search term]
 * example: php pbapiexample 00000000 abdf12340987cedb Photobucket 
 * @author jhart
 */


$key = '1020304';//$argv[1];
$sec = '9eb84090956c484e32cb6c08455a667b';//$argv[2];

$search = 'a';//$argv[3];

require_once('PBAPI.php');
try {
    $api = new PBAPI($key, $sec);
    $api->setResponseParser('simplexml');
    $response = $api->search($search)->get()->getParsedResponse(true);
    print_r($response);
} catch (PBAPI_Exception_Response $e) {
    echo "RESPONSE $e";
} catch (PBAPI_Exception $e) {
    echo "EX $e";
}
