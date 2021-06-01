<?php
namespace Includes\Db;

use Includes\Db\Query;

class User extends Query
{

    protected $table = 'users';
    protected $currentUserId;

    public static function getUserCartItems( $userId ){

        $user = new User();
        $user->select('cart_items');
        $user->where('id', '=', $userId );
        $result = $user->get();
        $cartItems = ( isset( $result[0]['cart_items'] ) ) ? $result[0]['cart_items'] : '';
        return  $cartItems;
    }
    public function getCurrentUserId(){
        $this->currentUserId = ( isset( $_SESSION['user_data']['id'] ) ) ? $_SESSION['user_data']['id'] : 0;

    }
    
}
