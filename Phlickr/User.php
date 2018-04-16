<?php
/**
 * Example use of PBAPI (with oauth) installed
 *
 * usage: php pbapiexample.php [consumer_key] [consumer_secret] [search term]
 * example: php pbapiexample 00000000 abdf12340987cedb Photobucket
 * @author jhart
 */

echo '<pre>';
const FLICKR_API_KEY = '008371898c160e0af3b3e63baf3c79da';
const FLICKR_API_SECRET = '4dfc4b3620f1ea31';
const FLICKR_TOKEN = '';
$key = FLICKR_API_KEY;//$argv[1];
$sec = FLICKR_API_SECRET;//$argv[2];

$search = 'a';//$argv[3];

include_once 'Phlickr/Api.php';
include_once 'Phlickr/User.php';

$api = new Phlickr_Api(FLICKR_API_KEY, FLICKR_API_SECRET, FLICKR_TOKEN);
$user = Phlickr_User::findByUrl($api, 'http://flickr.com/people/drewish/');

// print out the user's name
print "User: {$user->getName()}\n";

// print out their groups
foreach ($user->getGroupList()->getGroups() as $group) {
    print "Group: {$group->getName()} ({$group->buildUrl()})\n";
}

// print out their photosets
foreach ($user->getPhotosetList()->getPhotosets() as $photoset) {
    print "Photoset: {$photoset->getTitle()} ({$photoset->buildUrl()})\n";
}

// print out their 10 latest, favorite photos
$photolist = $user->getFavoritePhotoList(10);
foreach ($photolist->getPhotos() as $photo) {
    print "Favorite: {$photo->getTitle()} ({$photo->buildImgUrl()})\n";
}


die;

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


