<?php
require 'vendor/autoload.php';
session_start();

checkDirectAccess(); 
date_default_timezone_set("Asia/Kolkata");

define( 'BASE_URL', 'http://localhost/sebin/php/custom/study/shop/' );
define( 'BASE_DIR', __DIR__ );
define( 'DB_HOST', 'localhost' );
define( 'DB_USER', 'root' );
define( 'DB_PSW', '' );
define( 'DB', 'code_shop' );

define( 'JS_URL', BASE_URL. 'assets/js/');
define( 'CSS_URL', BASE_URL. 'assets/css/');
define( 'UPLOADS_URL', BASE_URL. 'assets/uploads/');

define('STRIPE_API_KEY', 'sk_test_51IxQybSFnPbX0XXPpU8exx0IlfNGzTU4sGihfZ62wBGHHzyMjXvyziroDdwnvTT9yBhxUoaOcs4QLjg27lTJRssE00qJvHk67y'); 
define('STRIPE_PUBLISHABLE_KEY', 'pk_test_51IxQybSFnPbX0XXPmAooOMiMT3jpMpmA4RTUNWfQyDPwWP5rA9FRGXsr9AteTZvp6v0eeUDsKbY0hBIcK9qWYfWG00m1ZxfuSI'); 

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