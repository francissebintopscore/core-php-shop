<?php
// require_once dirname(__FILE__).'/../config.php';
require_once dirname(__FILE__).'/../templates/header.php';

use Includes\Db\Order;
use Includes\Db\OrderItem;
use Includes\Db\Cart;
use Includes\Db\Product;
use Includes\Helpers\User;

$payment_id = $statusMsg = ''; 
$ordStatus = 'error'; 

// Check whether stripe token is not empty 
if(!empty($_POST['stripeToken'])){ 
     
    // Retrieve stripe token, card and user info from the submitted form data 
    $token  = $_POST['stripeToken']; 
    $name = $_POST['first_name']; 
    $email = $_POST['email']; 
    $currency = 'INR'; 
    $amount = $_POST['sub_total'];
    $orderNote = $_POST['order_note']; 
     
    // Include Stripe PHP library 
     
    // Set API key 
    \Stripe\Stripe::setApiKey(STRIPE_API_KEY); 
     
    // Add customer to stripe 
    try {  
        $customer = \Stripe\Customer::create(array( 
            'email' => $email, 
            'source'  => $token ,
            'name' => 'Jenny Rosen',
  			'address' => [
				    'line1' => '510 Townsend St',
				    'postal_code' => '98140',
				    'city' => 'San Francisco',
				    'state' => 'CA',
				    'country' => 'US',
  			],
        )); 
        // print_r($customer);
    }catch(Exception $e) {  
        $api_error = $e->getMessage();  
    } 

     
    if(empty($api_error) && $customer){  
         
        // Convert price to cents 
        // $itemPriceCents = ($itemPrice*100); 
         
        // Charge a credit or a debit card 
        try {  
            $charge = \Stripe\Charge::create(array( 
                'customer' => $customer->id, 
                'amount'   => $amount, 
                'currency' => $currency, 
                'description' => $orderNote 
            )); 
        }catch(Exception $e) {  
            $api_error = $e->getMessage();  
        } 
         
        if(empty($api_error) && $charge){ 
         
            // Retrieve charge details 
            $chargeJson = $charge->jsonSerialize(); 
         
            // Check whether the charge is successful 
            if($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1){ 
                // Transaction details  
                $transactionID = $chargeJson['balance_transaction']; 
                $paidAmount = $chargeJson['amount']; 
                // $paidAmount = ($paidAmount/100); 
                $paidCurrency = $chargeJson['currency']; 
                $payment_status = $chargeJson['status']; 
                 

                 
                // Insert tansaction data into the database 
                // $sql = "INSERT INTO orders(name,email,item_name,item_number,item_price,item_price_currency,paid_amount,paid_amount_currency,txn_id,payment_status,created,modified) VALUES('".$name."','".$email."','".$itemName."','".$itemNumber."','".$itemPrice."','".$currency."','".$paidAmount."','".$paidCurrency."','".$transactionID."','".$payment_status."',NOW(),NOW())"; 
                // $insert = $db->query($sql); 
                // $payment_id = $db->insert_id; 
                
                $payment_id  = Order::create([
                                    'user_id'               => User::getCurrentUserId(),
                                    'payment_gateway_id'    => 1,
                                    'order_note'            => $orderNote,
                                    'total_amount'          => $amount,
                                    'txn_id'                => $transactionID,
                                    'payment_status'        => $payment_status,
                                    'order_created'         => date("Y-m-d h:i:s")
                                    // 'order_created'         => '2021-06-08 18:18:15'

                ]);

                if( $payment_id && $payment_status=='succeeded' )
                {
                    $cart = new Cart();
                    $items = $cart->getCartItems();
                    $items = $cart->mergeItemWithProducts($items);

                    $subTotal = 0;
                    foreach ($items as $item) {
                        $productId = $item['product_data']['id'];
                        $amount = $item['product_data']['amount'];
                        $qty = $item['qty'];
                        OrderItem::create([
                                'product_id'    => $productId,
                                'order_id'      => $payment_id,
                                'amount'        => $amount,
                                'quantity'      => $qty,
                        ]);

                        Product::updateStock($qty,$productId);
                    }
                    $cart->clearCartItems();
                }

                 
                // If the order is successful 
                if($payment_status == 'succeeded'){ 
                    $ordStatus = 'success'; 
                    $statusMsg = 'Your Payment has been Successful!'; 
                }else{ 
                    $statusMsg = "Your Payment has Failed!"; 
                } 
            }else{ 
                $statusMsg = "Transaction has been failed!"; 
            } 
        }else{ 
            $statusMsg = "Charge creation failed! $api_error";  
        } 
    }else{  
        $statusMsg = "Invalid card details! $api_error";  
    } 
}else{ 
    $statusMsg = "Error on form submission."; 
} 
?>

<div class="container mg-top-30 mg-bot-30">
    <div class="row">
        <div class="col-sm-12">
            <div class="status">
                <?php if(!empty($payment_id)){ ?>
                <!-- <h1 class="<?php echo $ordStatus; ?>"><?php echo $statusMsg; ?></h1> -->
                <div class="au-heading">
                    <h2><?php echo $statusMsg; ?></h2>
                </div>

                <h4>Payment Information</h4>
                <p><b>Reference Number:</b> <?php echo $payment_id; ?></p>
                <p><b>Transaction ID:</b> <?php echo $transactionID; ?></p>
                <p><b>Paid Amount:</b> <?php echo $paidAmount.' '.$paidCurrency; ?></p>
                <p><b>Payment Status:</b> <?php echo $payment_status; ?></p>

                <!-- <h4>Product Information</h4>
            <p><b>Name:</b> <?php echo $itemName; ?></p>
            <p><b>Price:</b> <?php echo $amount.' '.$currency; ?></p> -->
                <?php }else{ ?>
                <div class="au-heading">
                    <h2>Your Payment has Failed</h2>
                </div>
                <!-- <h1 class="error">Your Payment has Failed</h1> -->
                <?php } ?>
            </div>
            <a href="<?php echo BASE_URL;?>" class="btn-link">Back to Payment Page</a>
        </div>
    </div>
</div>
        <?php
require_once dirname(__FILE__).'/../templates/footer.php';