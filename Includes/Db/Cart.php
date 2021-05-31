<?php
namespace Includes\Db;


class Cart extends Query{


    protected $userId;
    protected $cartItems =array();

    public function __construct()
    {
        parent::__construct();
        $this->userId = isset( $_SESSION['user_data']['id'] ) ? $_SESSION['user_data']['id'] : 0 ;
        $this->setCartItems();
        $this->mergeItemWithProducts();
        $this->setCartCookie();
    }
    
    public function getCartItems(){
        // print_r($this->cartItems);
        return $this->cartItems;
    }

    public function setCartItems(){
        
        if( isset( $_COOKIE['cart_items'] ) && !empty( $_COOKIE['cart_items'] ) ){
            $this->cartItems = unserialize( $_COOKIE['cart_items'] );
        }
        else
        {
            $this->cartItems = $this->getUserCartItems();
        }
    }

    protected function getUserCartItems(){
        
        $items = $_SESSION['user_data']['cart_items'];
        if( !empty( $items ) ){
            // return unserialize( User::getUserCartItems( $this->userId) );
            return unserialize( $items );
        }
        return array();
    }
    public function addCartItems( $item ){

        
    }
    public static function removeCartItem( $productId ){
        $cart = new Cart();
        $items = $cart->getCartItems();
        $items = array_filter( $items, function($value) use ($productId){
            return $value['product_id'] != $productId;
        }
        );
        $cart->cartItems = $items;
        $cart->setCartCookie();
        
    }

    public static function saveCartItems(){

    }

    protected function setCartCookie(){
        $value = serialize( $this->cartItems );
        setcookie( 'cart_items', $value , time() + (86400 * 30), "/");
    }

    protected function mergeItemWithProducts(){

        $items = $this->cartItems;
        $productIds =array();

        foreach( $items as $item){
            $productIds = [...$productIds, $item['product_id']];
        }
        $productIds = implode( ',',$productIds );
        $sql = "SELECT `id`,`name`,`image`,`amount` FROM `products` WHERE `id` IN($productIds)";
        $result = $this->rawQuery($sql);

        $i = 0;
        while($row = $result->fetch_assoc()) {
            
            $productId = ( isset( $items[$i]['product_id'] ) ) ? $items[$i]['product_id'] : 0;
            if( $row['id'] == $productId )
            {
                $items[$i]['product_data'] = $row; 
            }
            
            $i++;
        }
        $this->cartItems = $items;
    }
}