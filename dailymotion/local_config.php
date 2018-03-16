<?php
/**
 * Created by IntelliJ IDEA.
 * User: XEE
 * Date: 3/13/2018
 * Time: 3:44 PM
 */

require_once 'Dailymotion.php';

// Account settings
$apiKey        = 'yourApiKey';
$apiSecret     = 'yourApiSecret';
$testUser      = 'someUser';
$testPassword  = 'yourPassword';
$videoTestFile = '/path/to/video/test.mp4';

// Scopes you need to run your tests
$scopes = array(
    'userinfo',
    'feed',
    'manage_videos',
);
// Dailymotion object instanciation
$api = new Dailymotion();
$api->setGrantType(
    Dailymotion::GRANT_TYPE_PASSWORD,
    $apiKey,
    $apiSecret,
    $scopes,
    array(
        'username' => $testUser,
        'password' => $testPassword,
    )
);

/*require_once 'local_config.php';

$url = $api->uploadFile($videoTestFile);

$result = $api->post(
    '/videos',
    array(
        'url'       => $url,
        'title'     => 'Dailymotion PHP SDK upload test',
        'tags'      => 'dailymotion,api,sdk,test',
        'channel'   => 'videogames',
        'published' => true,
    )
);
var_dump($result);*/