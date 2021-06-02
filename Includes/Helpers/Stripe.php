<?php
namespace Includes\Helpers;

use Includes\Helpers\User;

class Stripe
{
    public $paymentStatus;
    protected $statusMessage;
    public $token;
    public $name;
    public $email;
    public $currency;
    public $paidCurrency;
    public $amount;
    public $paidAmount;
    public $orderNote;
    public $address;
    public $pincode;
    public $city;
    public $State;
    public $country;
    public $apiError;
    public $customer;
    public $charge;
    public $transactionID;

    public function __construct()
    {
        if (!$this->existsStripeToken()) {
            $this->statusMessage = "Error on form submission.";
            return;
        }
        

        $this->setPaymentData();
        $this->startPaymentTransaction();

        if (!$this->isSuccessfullTransaction()) {
            $this->statusMessage = "Invalid card details! $this->apiError";
            return;
        }
        $this->setPayment();
        
        if (! $this->isSucessfullChargeCreated()) {
            $this->statusMessage = "Charge creation failed! $this->apiError";
            return;
        }
    }

    protected function setPaymentData()
    {
        $this->token        = $this->extractPostData('stripeToken');
        $this->name         = $this->extractPostData('first_name');
        $this->name         = $this->name . ' ' . $this->extractPostData('last_name');
        $this->email        = $this->extractPostData('email');
        $this->currency     = 'INR';
        $this->amount       = $this->extractPostData('sub_total');
        $this->orderNote    = $this->extractPostData('order_note');
        $this->address      = $this->extractPostData('address');
        $this->pincode      = $this->extractPostData('pincode');
        $this->city         = $this->extractPostData('city');
        $this->State        = $this->extractPostData('State');
        $this->country      = $this->extractPostData('country');
    }

    protected function extractPostData($key)
    {
        return isset( $_POST[$key] ) ? $_POST[$key] : '';
    }

    protected function existsStripeToken()
    {
        if ($this->extractPostData('stripeToken')) {
            return true;
        }
        return false;
    }

    protected function startPaymentTransaction()
    {
        \Stripe\Stripe::setApiKey(STRIPE_API_KEY);
     
        // Add customer to stripe
        try {
            $this->customer = \Stripe\Customer::create(
                array(
                                                'email' => $this->email,
                                                'source'  => $this->token ,
                                                'name' => $this->name,
                                                'address' => [
                                                        'line1' => $this->address,
                                                        'postal_code' => $this->pincode,
                                                        'city' => $this->city,
                                                        'state' => $this->State,
                                                        'country' => $this->country,
                                                ],
                                            )
            );
        } catch (\Exception $e) {
            $this->apiError = $e->getMessage();
        }
    }
    protected function isSuccessfullTransaction()
    {
        if (empty($this->apiError) && $this->customer) {
            return true;
        }
        return false;
    }

    protected function setPayment()
    {
        // Convert price
        $actualAmount = ($this->amount*100);
         
        // Charge a credit or a debit card
        try {
            $this->charge = \Stripe\Charge::create(array(
                'customer' => $this->customer->id,
                'amount'   => $actualAmount,
                'currency' => $this->currency,
                'description' => $this->orderNote
            ));
        } catch (\Exception $e) {
            $this->apiError = $e->getMessage();
        }
    }

    protected function isSucessfullChargeCreated()
    {
        if (empty($this->apiError) && $this->charge) {
            return true;
        }
        return false;
    }
    public function getOrderDetails()
    {
        $chargeJson = $this->charge->jsonSerialize();

        if (!$this->isSucessfullCharge($chargeJson)) {
            $this->statusMessage = "Transaction has been failed!";
            return;
        }

        $this->transactionID = $chargeJson['balance_transaction'];
        $this->paidAmount = $chargeJson['amount'];
        $this->paidAmount = ($this->paidAmount/100);
        $this->paidCurrency = $chargeJson['currency'];
        $this->paymentStatus = $chargeJson['status'];

        $this->setStatusMessage();
        
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

    protected function isSucessfullCharge($chargeJson)
    {
        if (
            $chargeJson['amount_refunded'] == 0 &&
            empty($chargeJson['failure_code']) &&
            $chargeJson['paid'] == 1 &&
            $chargeJson['captured'] == 1
        ) {
            return true;
        }
        return false;
    }

    public function getStatusMessage()
    {
        return $this->statusMessage;
    }
    public function setStatusMessage()
    {
        if ($this->paymentStatus == 'succeeded') {
            $this->statusMessage = 'Your Payment has been Successful!';
        } else {
            $this->statusMessage = "Your Payment has Failed!";
        }
    }
}
