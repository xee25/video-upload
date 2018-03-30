<?php
//require_once '../vendor/dailymotion/sdk/Dailymotion.php';
require_once '../vendor/autoload.php';

echo '<pre>';
$fb = new Facebook\Facebook([
    'app_id' => '776131842592020',
    'app_secret' => '1d769c3f565eebc391c54ec56bc79247',
    'default_graph_version' => 'v2.2',
    'default_access_token' => '2705b39ea13ccd0acd88cb9bf88d6bef',
//    'default_access_token' => 'EAALB40bGzRQBAJV5kZBgibR1ZCKMXi9yxtIqHVuZAW8154MHnebZCmA7p0heVohgDZCrPidI66bKfiEYVwqhwl65NzZAn6yUGxbbqCiZAkdU3TM3dcXgkZBJ0tqnD7Iia46Fe2zAVtD3XsLoZA4YePBc4JZBdVPGKLjDoR8XgY40DXAgD480L2BPLZAuzqW0MTHJFqS8TqwI6cCBuWxsAlP3ZCHUDD5n7mdseawLzhc2QFstlQZDZD',
]);
/*$data = [
    'title' => 'My Foo Video',
    'description' => 'This video is full of foo and bar action.',
    'source' => $fb->videoToUpload('../test.mp4'),
];*/
$helper = $fb->getJavaScriptHelper();

try {
    $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}

if (! isset($accessToken)) {
    echo 'No cookie set or no OAuth data could be obtained from cookie.';
    exit;
}

// Logged in
echo '<h3>Access Token</h3>';
var_dump($accessToken->getValue());

$_SESSION['fb_access_token'] = (string) $accessToken;

// User is logged in!
// You can redirect them to a members-only page.
//header('Location: https://example.com/members.php');






die;
try {

//    $helper = $fb->getCanvasHelper();
//    $helper = $fb->getRedirectLoginHelper();
    $accessToken = $helper->getAccessToken();
    print_r($helper->getAccessToken());
    $client = $fb->getClient();
    print_r($client);
    $response = $client->uploadVideo('/me/videos', $data, '2705b39ea13ccd0acd88cb9bf88d6bef');
//    $response = $fb->post('/me/videos', $data, '2705b39ea13ccd0acd88cb9bf88d6bef');
} catch(Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}

$graphNode = $response->getGraphNode();
var_dump($graphNode);

echo 'Video ID: ' . $graphNode['id'];

?>


2705b39ea13ccd0acd88cb9bf88d6bef
<html>
<body>
  <div>
  <h1>Youtube Samples</h1>
<?php if (!file_exists(__DIR__ . '/../vendor/autoload.php')): ?>
  <h3>Library Requirements</h3>
  <ol>
    <li>1. Install composer (https://getcomposer.org)</li>
    <li>2. On the command line, change to this directory (api-samples/php)</li>
    <li>3. Require the google/apiclient library</li>
    $ composer require google/apiclient:~2.0
  </ol>
  <strong>please run <code>composer require google/apiclient:~2.0</code> in <code>"<?php echo __DIR__  ?>"</code></strong>
<?php endif ?>
  <ul>
      <li><a href="add_channel_section.php">Add Channel Section</a></li>
      <li><a href="add_subscription.php">Add Subscription</a></li>
      <li><a href="captions.php">Captions</a></li>
      <li><a href="comment_handling.php">Comment Handling</a></li>
      <li><a href="comment_threads.php">Comment Threads</a></li>
      <li><a href="create_broadcast.php">Create Broadcast</a></li>
      <li><a href="create_reporting_job.php">Create Reporting Job</a></li>
      <li><a href="geolocation_search.php">Geolocation Search</a></li>
      <li><a href="list_broadcasts.php">List Broadcasts</a></li>
      <li><a href="list_streams.php">List Streams</a></li>
      <li><a href="my_uploads.php">My Uploads</a></li>
      <li><a href="playlist_updates.php">Playlist Updates</a></li>
      <li><a href="resumable_upload.php">Resumable Upload</a></li>
      <li><a href="retrieve_reports.php">Retrieve Reports</a></li>
      <li><a href="search.php">Search</a></li>
      <li><a href="shuffle_channel_sections.php">Shuffle Channel Sections</a></li>
      <li><a href="update_video.php">Update Video</a></li>
      <li><a href="upload_banner.php">Upload Banner</a></li>
      <li><a href="upload_thumbnail.php">Upload Thumbnail</a></li>
  </ul>
</body>
</html>
