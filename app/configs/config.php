<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(dirname(__FILE__))));
define('APPROOT', dirname(dirname(__FILE__)));
define('PUBLICROOT', dirname(dirname(dirname(__FILE__))).DS.'public');
// site name
// define('SITENAME', 'oswc');
if (PHP_OS_FAMILY === 'Windows') {
    // for OSPanel on Windows
    define('SITENAME', 'tlfspr');
} elseif (PHP_OS_FAMILY === 'Linux') {
    // for XAMPP on Linux
    define('SITENAME', 'localhost/tlfspr');
}
// define('URLROOT', 'http'.((isset($_SERVER['HTTPS']) and $_SERVER['HTTPS']=='on') ? 's': '').'://'.SITENAME.'.net');
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';
define('URLROOT', $protocol.SITENAME);
define('CURRENT_PAGE_LOCATION', $protocol.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
/*
define('ADMLOGPAS', [   "admin" => ['login' => 'admin', 'password' => 'passw'],
                        "moderator" =>  ['login' => 'moder', 'password' => 'moder'],
                        "user" =>  ['login' => 'user', 'password' => 'user']
                    ] );
*/
define('TEMPLATEROOT', PUBLICROOT.DS.'templates');
define('IMGDIR', PUBLICROOT.DS.'imgs');
define('DICTIONARY', APPROOT.DS.'phone_dictionary'.DS.'dictionary.json');
