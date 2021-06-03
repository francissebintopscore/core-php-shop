<?php
require_once dirname(__FILE__).'/../config.php';
defined('BASE_URL') or exit('No direct script access allowed');

use Includes\Db\Cart;
use Includes\Db\Order;
use Includes\Db\Item;
use Includes\Helpers\OrderItem;

$namespace = 'Includes\Payments\\';

$paymentMethod = 'Stripe';
$paymentMethod = 'CashOnDelivery';
$paymentMethod = $namespace . $paymentMethod ;

try {
    $paymentMethod  = new $paymentMethod();
    $orderDetails   = $paymentMethod->getOrderDetails();
    $order          = new Order();
    $orderId        = $order->create($orderDetails);

    if ($orderId) {
        $cart = new Cart();
        $cartItem = new Item();
        $items = $cart->getItems();
        $items = $cartItem->mergeItemWithProducts($items);
        $orderItems = new OrderItem();
        $orderItems->createOrderItems($orderId, $items);
        $cart->clearitems();
    }

    $transactionID  = $paymentMethod->transactionID;
    $paidAmount     = $paymentMethod->paidAmount;
    $paidCurrency   = $paymentMethod->paidCurrency;
    $paymentStatus  = $paymentMethod->paymentStatus;
    $statusMessage  = $paymentMethod->getStatusMessage();

    // print_r($paymentMethod);
} catch (\Throwable $th) {
    //throw $th;
}
require_once dirname(__FILE__).'/../thankyou.php';
require_once dirname(__FILE__).'/../templates/footer.php';
