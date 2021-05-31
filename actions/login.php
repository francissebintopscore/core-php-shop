<?php
require_once dirname(__FILE__).'/../config.php';

use Includes\Helpers\Security;
use Includes\Db\User;

if( isset( $_POST['submit'] ) ){

    $token = isset(  $_POST['csrf'] ) ?  $_POST['csrf'] : '';
    if( Security::validateCSRF( $token, 'csrf' ) )
    {
        $user = new User();
        $user->select('*');
        $user->where('username', '=', 'sebin');
        $user->whereOr('email', '=', 'francissebinfernandez@gmail.com');
        $user->where('password', '=', 'b9f5b8bd9b146c2995129e0b2329c99c');
        $user->where('status', '=', 'active');
        $result = $user->get();
        
        $_SESSION['user_data'] = ( isset( $result[0] ) ) ? $result[0] : '';

        print_r($_SESSION);
        print_r($result[0]);
    }
    else{
        echo "problem";
    }

}