<?php
namespace Includes\Db;

use Includes\Db\Query;

class OrderItem extends Query{

    protected $table = 'order_items';

    public static function create($datas){


        $orderItem = new OrderItem();
        $keys = array_keys($datas);
        $values = array_values($datas);
        $sql = "INSERT INTO `order_items`
        (`product_id`, `order_id`, `amount`, `quantity`) 
        VALUES (?,?,?,?)";

        $stmt = $orderItem->conn->prepare($sql);
        $stmt->bind_param(
            'iidi', 
            $datas['product_id'],
            $datas['order_id'],
            $datas['amount'],
            $datas['quantity']
        );

        $stmt->execute();
        
        if( $stmt->error )
        {
            return false;
        }
        return $stmt->insert_id;

    }
}