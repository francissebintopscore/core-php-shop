<?php
require_once dirname(__FILE__).'/../templates/header.php';

use Includes\Db\Cart;
use Includes\Db\Order;
use Includes\Db\Item;
use Includes\Helpers\OrderItem;
use Includes\Helpers\Stripe;

try {
    $stripe         = new Stripe();
    $orderDetails   = $stripe->getOrderDetails();
    $order          = new Order();
    $orderId        = $order->create($orderDetails);

    if ($orderId && $stripe->paymentStatus == 'succeeded') {
        $cart = new Cart();
        $cartItem = new Item();
        $items = $cart->getItems();
        $items = $cartItem->mergeItemWithProducts($items);
        $orderItems = new OrderItem();
        $orderItems->createOrderItems($orderId, $items);
        $cart->clearitems();
    }


    $transactionID  = $stripe->transactionID;
    $paidAmount     = $stripe->paidAmount;
    $paidCurrency   = $stripe->paidCurrency;
    $paymentStatus  = $stripe->paymentStatus;
    $statusMessage  = $stripe->getStatusMessage();
    
} catch (\Throwable $th) {
}

require_once dirname(__FILE__).'/../thankyou.php';
require_once dirname(__FILE__).'/../templates/footer.php';
