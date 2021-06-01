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
        // $this->mergeItemWithProducts();
        $this->setCartCookie();
    }
    
    public function getCartItems()
    {
        // print_r($this->cartItems);
        return $this->cartItems;
    }

    public function setCartItems()
    {
        
        if( isset( $_COOKIE['cart_items'] ) && !empty( $_COOKIE['cart_items'] ) ){
            $this->cartItems = unserialize( $_COOKIE['cart_items'] );
        }
        else
        {
            $this->cartItems = $this->getUserCartItems();
        }
    }

    protected function getUserCartItems()
    {
        
        $items = $_SESSION['user_data']['cart_items'];
        if( !empty( $items ) ){
            // return unserialize( User::getUserCartItems( $this->userId) );
            return unserialize( $items );
        }
        return array();
    }
    public static function addCartItem( $newItem )
    {

        $cart = new Cart();
        $items = $cart->getCartItems();

        $flag = true;
        
        foreach($items as $key => $item)
        {
            if( $item['product_id'] === $newItem['product_id'] ){
                
                $items[$key]['qty'] = $item['qty'] + intval($newItem['qty']);
                // print_r($items[$key]['qty']);
                $flag = false;
                break;
            }
            

        }
        if( $flag )
        {
            array_push($items, $newItem);
        }
        // print_r($items);
        $cart->cartItems = $items;
        $cart->setCartCookie();
        
    }
    public static function removeCartItem( $productId )
    {
        $cart = new Cart();
        $items = $cart->getCartItems();
        $items = array_filter( $items, function($value) use ($productId){
            return $value['product_id'] != $productId;
        }
        );
        $cart->cartItems = $items;
        $cart->setCartCookie();
        
    }

    public static function saveCartItems()
    {

    }

    protected function setCartCookie()
    {
        $value = serialize( $this->cartItems );
        setcookie( 'cart_items', $value , time() + (86400 * 30), "/");
    }

    public function mergeItemWithProducts()
    {

        $items = $this->cartItems;
        if( empty( $items ) )
        {
            return array();
        }
        $productIds =array();

        foreach( $items as $item)
        {
            $productIds = [...$productIds, $item['product_id']];
        }
        sort($productIds);
        $productIds = implode( ',',$productIds );
        $sql = "SELECT `id`,`name`,`image`,`amount`, `stock` FROM `products` WHERE `id` IN($productIds)";
        $productIds = explode( ',',$productIds );
        $result = $this->rawQuery($sql);

        $i = 0;
        while($row = $result->fetch_assoc()) 
        {
            
        //    print_r($row);
        //    echo "<br>";
            $productId = ( isset( $productIds[$i] ) ) ? $productIds[$i] : 0;

            // if( $row['id'] == $productId )
            // {
            //     $items[$i]['product_data'] = $row; 
            // }
            foreach( $items as $key => $value )
            {
                if( $row['id'] == $value['product_id'] )
                {
                    $items[$key]['product_data'] = $row; 
                    break;
                }
            }
            
            $i++;
        }
        
        return $items;
    }
}