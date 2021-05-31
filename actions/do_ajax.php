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
elseif ( $_SERVER['REQUEST_METHOD'] == 'POST' ){

    $action =  ( isset( $_POST['action'] ) ) ? $_POST['action'] : '';

    switch( $action ){
        case 'addCartItem' :
                            $productId = ( isset( $_POST['productId'] ) ) ? intval( $_POST['productId'] ): 0;
                            $qty = ( isset( $_POST['qty'] ) ) ? $_POST['qty'] : 1;
                            if( $productId )
                            {
                                $newItem = array( 'product_id'=>$productId, 'qty' => $qty );
                                Cart::addCartItem( $newItem );
                                exit('success');
                            }
                            break;

         case 'updateCartItems' :
                            $productDatas = ( isset( $_POST['productDatas'] ) ) ? $_POST['productDatas'] : array();
                            Cart::updateCartItem( $productDatas );
                            // print_r($productDatas);
                            exit('success');
                            break;

        default :
                echo "Thulasi";
                break;
    }

}
