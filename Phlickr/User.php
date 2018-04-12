<?php
/**
 * Example use of PBAPI (with oauth) installed
 *
 * usage: php pbapiexample.php [consumer_key] [consumer_secret] [search term]
 * example: php pbapiexample 00000000 abdf12340987cedb Photobucket
 * @author jhart
 */

echo '<pre>';
$key = '008371898c160e0af3b3e63baf3c79da';//$argv[1];
$sec = '4dfc4b3620f1ea31';//$argv[2];

$search = 'a';//$argv[3];

require_once('Phlickr/Api.php');
require_once('Phlickr/Uploader.php');
try {

    $api1 = new Phlickr_Api($key, $sec);
    $api = new Phlickr_Uploader($api1);
    print_r($api->upload('clean1.png','Testing api','Teseting api desc'));
    print_r($api);
    die;
    $api->setResponseParser('simplexml');
    $response = $api->search($search)->get()->getParsedResponse(true);
    print_r($response);
} catch (PBAPI_Exception_Response $e) {
    echo "RESPONSE $e";
} catch (PBAPI_Exception $e) {
    echo "EX $e";
}


