<?php
session_start();
require_once '../vendor/autoload.php';
$consumerKey = 'zyoGDd6n4e7cosvIwvXILlwCbVWbiiffuGPohookaJVdy57ZXl';
$consumerSecret = 'RRtkQRy7BiQxQQik8GcdzpiZJcX2oRXwY3GevRo2lvol9s1enO';
$tmpToken = isset($_SESSION['tmp_oauth_token'])? $_SESSION['tmp_oauth_token'] : null;
$tmpTokenSecret = isset($_SESSION['tmp_oauth_token_secret'])? $_SESSION['tmp_oauth_token_secret'] : null;
$client = new Tumblr\API\Client($consumerKey, $consumerSecret, $tmpToken, $tmpTokenSecret);
// Change the base url
$requestHandler = $client->getRequestHandler();
$requestHandler->setBaseUrl('https://www.tumblr.com/');
if (!empty($_GET['oauth_verifier'])) {
    // exchange the verifier for the keys
    $verifier = trim($_GET['oauth_verifier']);
    $resp = $requestHandler->request('POST', 'oauth/access_token', array('oauth_verifier' => $verifier));
    $out = (string) $resp->body;
    $data = array();
    parse_str($out, $data);
    unset($_SESSION['tmp_oauth_token']);
    unset($_SESSION['tmp_oauth_token_secret']);
    $_SESSION['Tumblr_oauth_token'] = $data['oauth_token'];
    $_SESSION['Tumblr_oauth_token_secret'] = $data['oauth_token_secret'];
}
if (empty($_SESSION['Tumblr_oauth_token']) || empty($_SESSION['Tumblr_oauth_token_secret'])) {
    // start the old gal up
    $callbackUrl = 'http://localhost/video-upload/tumblr/BlogTest.php';
    $resp = $requestHandler->request('POST', 'oauth/request_token', array(
        'oauth_callback' => $callbackUrl
    ));
    // Get the result
    $result = (string) $resp->body;
    parse_str($result, $keys);
    $_SESSION['tmp_oauth_token'] = $keys['oauth_token'];
    $_SESSION['tmp_oauth_token_secret'] = $keys['oauth_token_secret'];
    $url = 'https://www.tumblr.com/oauth/authorize?oauth_token=' . $keys['oauth_token'];
    echo '<a href="'.$url.'">Connect Tumblr</a>';
    exit;
}
$client = new Tumblr\API\Client(
    $consumerKey,
    $consumerSecret,
    $_SESSION['Tumblr_oauth_token'],
    $_SESSION['Tumblr_oauth_token_secret']
);
$clientInfo = $client->getUserInfo();
$blogs = !empty($clientInfo->user->blogs)? $clientInfo->user->blogs : null;
foreach ($blogs as $blog) {
    $client->createPost($blog->name, array(
        'type' => 'video',
//        'state' => 'published',
        'caption' => 'Test upload '.time(),
        'embed' => 'https://www.youtube.com/embed/aZK7zNddz_Y',
//        'data' => '../test.mp4',
//        'source' => file_get_contents('../test.mp4')
    ));
}
echo '<pre>';
print_r($blogs);
exit;