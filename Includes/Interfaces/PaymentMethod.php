<?php
namespace Includes\Interfaces;

interface PaymentMethod
{
    public function __construct();
    public function setPaymentData();
    public function getOrderDetails();
    public function getStatusMessage();
}
