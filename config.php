<?php
require 'vendor/autoload.php';
session_start();

checkDirectAccess(); 


define( 'BASE_URL', 'http://localhost/sebin/php/custom/study/shop/' );
define( 'BASE_DIR', __DIR__ );
define( 'DB_HOST', 'localhost' );
define( 'DB_USER', 'root' );
define( 'DB_PSW', '' );
define( 'DB', 'code_shop' );

define( 'JS_URL', BASE_URL. 'assets/js/');
define( 'CSS_URL', BASE_URL. 'assets/css/');
define( 'UPLOADS_URL', BASE_URL. 'assets/uploads/');

function checkDirectAccess()
{
    if ( $_SERVER['REQUEST_METHOD']=='GET' 
        && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])
        ) 
    {
        header('HTTP/1.0 403 Forbidden', true, 403);
        die(header('location: error.php'));
    }
}