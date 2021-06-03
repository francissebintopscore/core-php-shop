<?php
namespace Includes\Abstracts;

abstract class PaymentMethod
{
    public $paymentStatus = 'Failed';
    public $transactionID = '';
    public $paidCurrency = 'INR';
    public $statusMessage = 'Payment failed!';
    public $paidAmount = 0;

    public $name = '';
    public $email = '';
    public $currency = 'INR';
    public $amount = 0;
    public $orderNote = '';
    public $address = '';
    public $pincode = '';
    public $city = '';
    public $State = '';
    public $country = '';

    abstract public function __construct();
    abstract public function setPaymentData();
    abstract public function getOrderDetails();
    abstract public function getStatusMessage();
}
