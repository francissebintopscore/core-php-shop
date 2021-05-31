<?php
require_once dirname(__FILE__).'/../config.php';

use Includes\Db\Cart;
use Includes\Helpers\User;

if( !User::userLoggedIn() ){
    die('Un authorize');
}

if ( $_SERVER['REQUEST_METHOD'] == 'GET' ){


    $action =  ( isset( $_GET['action'] ) ) ? $_GET['action'] : '';

    switch( $action ){
        case 'removeCartItem' :
                            $productId = ( isset( $_GET['productId'] ) ) ? $_GET['productId'] : 0;
                            if( $productId )
                            {
                                Cart::removeCartItem( $productId );
                                exit('success');
                            }
                            break;

        default :
                echo "Thulasi";
                break;
    }


}