<?php
/**
 * Created by IntelliJ IDEA.
 * User: XEE
 * Date: 3/27/2018
 * Time: 6:04 PM
 */
echo '<pre>';
$ch = curl_init();

$url = urlencode("https://blog.onlywire.com");
$title = urlencode("OnlyWire Blog");
$comments = urlencode("OnlyWire Integration Testing");
$tags = urlencode("onlywire,bookmarking,blogging,submission");
$servicelogins = urlencode("c29mdHdhcmUtZW5naW5lZXItc2U,cmF5bW9uZC1sLXJvYmVydHM");

$username= "xee-tds";
$password= "tds12345";

$params = "url={$url}&title={$title}&tags={$tags}&comments={$comments}&service_logins={$servicelogins}&schedule_date=2018-03-28 14:50:59";

$query = "https://www.onlywire.com/api/add?{$params}";

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_URL, $query);
curl_setopt($ch, CURLOPT_USERPWD, $username.":".$password);

$output = curl_exec($ch);
echo '<br>';
print_r( curl_getinfo($ch) );
curl_close ($ch);

echo $output;

?>