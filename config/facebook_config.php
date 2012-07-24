<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['uri_protocol']    = 'PATH_INFO';

$config['enable_query_strings'] = FALSE;

$config['appId'] = Settings::get('login_fb_appid');
$config['secret'] = Settings::get('login_fb_appsecret');
$config['scope'] = Settings::get('login_fb_scope');
$config['display'] = Settings::get('login_fb_display');
$config['redirect_uri'] = Settings::get('login_fb_redirecturl');