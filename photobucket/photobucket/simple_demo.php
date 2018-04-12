<?php
/**
 * basic API demo class
 * 
 * @author jhart
 * 
 * @copyright Copyright (c) 2008, Photobucket, Inc.
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 */

//load PBAPI
require_once 'PBAPI.php';

//run Demo class
$x = new Demo($route);
echo call_user_func($route);

//done
exit;

/**
 * Demo class 
 * 
 */
class Demo {

    /**
     * Consumer Key (aka scid or developer key)
     * Fill in with your own
     */
    private static $consumer_key = 000000000;
    /**
     * Consumer Secret (aka private key)
     * Fill in with your own
     */
    private static $consumer_secret = '00000000000000000000000000000000';

    /**
     * API object
     */
    private $api;

    /**
     * params from URI
     * 
     * @var array
     */
    private $uri_params;

    /**
     * run the page 
     * 
     * @param array $route route callback to make everything public actions
     */
    public function __construct(&$route) {
        $this->api = new PBAPI(self::$consumer_key, self::$consumer_secret);
        $this->api->setResponseParser('phpserialize');

        session_start();

        $route = $this->getRoute();
    }

    /**
     * route the request to the appropriate method
     * 
     * @param string $path path_info - first part is action, everything after are params
     * @return callback
     */
    private function getRoute() {
        $path = $_SERVER['PATH_INFO'];

        $parts = explode('/', trim($path, '/'));
        $action = array_shift($parts);
        $this->uri_params = $parts;

        if (!$action) $action = 'index';
        $action .= 'Action';
        return array($this, $action);
    }

    /**
     * reset session (log out) action
     * 
     * @return string redirect body
     */
    public function resetAction() {
        $_SESSION = array();
        session_destroy();
        return self::redirect('index');
    }

    /**
     * index action
     * 
     * @return string output 
     */
    public function indexAction() {
        if (!$_SESSION['access_token']) {
            return self::redirect('request');
        }

        $tok = $_SESSION['access_token'];
        $username = $_SESSION['username'];
        $subdomain = $_SESSION['subdomain'];

        $this->api->setOAuthToken($tok->getKey(), $tok->getSecret(), $username);
        $this->api->setSubdomain($subdomain);
        $resp = $this->api->album($username, array('media' => 'images'))->get()->getParsedResponse(true);

        return self::render_index($resp['album']);
    }

    /**
     * render index html
     * 
     * @param array $album_array album array
     * @return string html output
     */
    private static function render_index($album_array) {
        $str = '';
        foreach ($album_array['album'] as $album) {
            $str .= '<h2>'.$album['_attribs']['name'].' ('.($album['_attribs']['photo_count'] + $album['_attribs']['video_count']).')</h2>';
        }
        $str .= "<hr>";
        foreach ($album_array['media'] as $media) {
            $src = $media['url'];
            $link = $media['browseurl'];
            $str .= "<a href='$link'><img src='$src'></a>";
        }

        return $str;
    }

    /**
     * api login request Action 
     * 
     * @return string redirect body
     */
    public function requestAction() {
        $this->api->login('request')->post()->loadTokenFromResponse();
        $_SESSION['request_token'] = $this->api->getOAuthToken();
        return $this->api->goRedirect('login');
    }

    /**
     * api login access Action 
     * 
     * @return string redirect body
     */
    public function accessAction() {
        if (!$_SESSION['request_token']) {
            return self::redirect('request');
        }

        $tok = $_SESSION['request_token'];
        $this->api->setOAuthToken($tok->getKey(), $tok->getSecret());
        $this->api->login('access')->post()->loadTokenFromResponse();
        $_SESSION['access_token'] = $this->api->getOAuthToken();
        $_SESSION['username'] = $this->api->getUsername();
        $_SESSION['subdomain'] = $this->api->getSubdomain();

        return self::redirect('index');
    }

    /**
     * do a redirect 
     * 
     * @param string $loc action to redirect to
     * @return string redirect body
     */
    private static function redirect($loc) {
        $url = "http://{$_SERVER['SERVER_NAME']}{$_SERVER['SCRIPT_NAME']}/$loc";
        header('Location: '.$url);
        return '<html><head><meta http-equiv="refresh" content="0;url='.$url.'"/></head>
            <body><a href="'.$url.'">Redirect</a></body></html>';
    }

}
