<?php
namespace Includes\Helpers;

use Includes\Db\Product;
use Includes\Db\OrderItem as DbOrderItem;

class OrderItem
{
    public function createOrderItems($orderId, $items)
    {
        foreach ($items as $item) {
            $productId = $item['product_data']['id'];
            $amount = $item['product_data']['amount'];
            $qty = $item['qty'];
            $orderItems = new DbOrderItem();
            $orderItems->create([
                            'product_id'    => $productId,
                            'order_id'      => $orderId,
                            'amount'        => $amount,
                            'quantity'      => $qty,
            ]);
            $product = new Product();
            $product->updateStock($qty, $productId);
        }
    }
}
