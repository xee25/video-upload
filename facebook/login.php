<?php
require_once '../vendor/autoload.php';
$fb = new Facebook\Facebook([
    'app_id' => '',
    'app_secret' => '',
    'default_graph_version' => 'v2.2',
    'default_access_token' => '',
//    'default_access_token' => 'EAALB40bGzRQBAJV5kZBgibR1ZCKMXi9yxtIqHVuZAW8154MHnebZCmA7p0heVohgDZCrPidI66bKfiEYVwqhwl65NzZAn6yUGxbbqCiZAkdU3TM3dcXgkZBJ0tqnD7Iia46Fe2zAVtD3XsLoZA4YePBc4JZBdVPGKLjDoR8XgY40DXAgD480L2BPLZAuzqW0MTHJFqS8TqwI6cCBuWxsAlP3ZCHUDD5n7mdseawLzhc2QFstlQZDZD',
]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl('http://localhost/video-upload/facebook/fb-callback.php', $permissions);

echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';
?>