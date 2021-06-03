<?php
require_once 'templates/header.php';

// global $orderData;
// print_r($orderData); 
?>
<div class="container mg-top-30 mg-bot-30">
    <div class="row">
        <div class="col-sm-12">
            <div class="status">
                <?php
                if (!empty($orderId)) {
                    ?>
                    <div class="au-heading">
                        <h2><?php echo $statusMessage; ?></h2>
                    </div>

                    <h4>Payment Information</h4>
                    <p><b>Reference Number:</b> <?php echo $orderId; ?></p>
                    <p><b>Transaction ID:</b> <?php echo $transactionID; ?></p>
                    <p><b>Amount:</b> <?php echo $paidAmount.' '. strtoupper($paidCurrency); ?></p>
                    <p><b>Payment Status:</b> <?php echo $paymentStatus; ?></p>
                    <?php
                } else {
                    ?>
                    <div class="au-heading">
                        <h2>Your Payment has Failed</h2>
                    </div>
                    <?php
                }
                ?>
            </div>
            <a href="<?php echo BASE_URL;?>" class="btn-link">Back to Payment Page</a>
        </div>
    </div>
</div>
<?php
require_once 'templates/footer.php';
?>