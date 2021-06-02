<?php
namespace Includes\Db;

use Includes\Db\Query;

class Order extends Query
{
    protected $table = 'orders';

    public function create($datas)
    {
        $sql = "INSERT INTO `orders`
        (`user_id`, `payment_gateway_id`, `order_note`, 
        `total_amount`, `txn_id`, `payment_status`, `order_created`) 
        VALUES (?,?,?,?,?,?,?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            'iisdsss',
            $datas['user_id'],
            $datas['payment_gateway_id'],
            $datas['order_note'],
            $datas['total_amount'],
            $datas['txn_id'],
            $datas['payment_status'],
            $datas['order_created']
        );

        $stmt->execute();
        
        if ($stmt->error) {
            return false;
        }
        return $stmt->insert_id;
    }
}
