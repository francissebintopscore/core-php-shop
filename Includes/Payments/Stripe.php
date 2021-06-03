<?php
namespace Includes\Payments;

use Includes\Interfaces\PaymentMethod;
use Includes\Helpers\User;

class Stripe implements PaymentMethod
{
    protected $token;
    public $paymentStatus = 'failed';
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
    
    public function __construct()
    {
        $this->setPaymentData();
    }

    public function setPaymentData(){
        $this->token        = 'stripeToken';
        $this->name         = 'first_name';
        $this->name         = $this->name . ' ' . 'last_name';
        $this->email        = 'email';
        $this->currency     = 'INR';
        $this->amount       = 0;
        $this->orderNote    = 'order_note';
        $this->address      = 'address';
        $this->pincode      = 'pincode';
        $this->city         = 'city';
        $this->State        = 'State';
        $this->country      = 'country';
    }

    public function getOrderDetails(){
        return ([
            'user_id'               => User::getCurrentUserId(),
            'payment_gateway_id'    => 1,
            'order_note'            => $this->orderNote,
            'total_amount'          => $this->amount,
            'txn_id'                => $this->transactionID,
            'payment_status'        => $this->paymentStatus,
            'order_created'         => date("Y-m-d h:i:s")

            ]);
    }

    public function getStatusMessage()
    {
        return $this->statusMessage;
    }
    
}
