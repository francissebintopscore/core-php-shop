<?php
require_once 'templates/header.php';

use Includes\Helpers\User;
use Includes\Db\Cart;
use Includes\Db\Item;

if (!User::userLoggedIn()) {
    header('Location: '. BASE_URL);
    die();
}

$cart = new Cart();
$cartItem = new Item();
$items = $cart->getItems();
$items = $cartItem->mergeItemWithProducts($items);
$imgBase = UPLOADS_URL.'products/';
$subTotal = 0.00;
$shipping = 50.00;
?>


<div class="container" style="margin-top:30px">
    <div class="row">
        <div class="col-sm-12">
            <div class="au-heading">
                <h2>Shopping Cart</h2>
            </div>
            <div class="table-responsive mg-top-30">
                <table class="table table-striped table-bordered table-hover" id="cart-table">
                    <thead class="thead-dark">
                        <tr>
                            <th>Image</th>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($items as $key => $value) {
                            $id = $value['product_data']['id'];
                            $img = $imgBase . $value['product_data']['image'];
                            $name = $value['product_data']['name'];
                            $amount = $value['product_data']['amount'];
                            $maxStocks = $value['product_data']['stock'];
                            $qty = $value['qty'];
                            $totalAmount = intval($qty) * floatval($amount);
                            $subTotal += $totalAmount; ?>
                            <tr data-product-id="<?php echo $id; ?>">
                                <td>
                                    <img src="<?php echo $img; ?>"
                                        width="145" alt="product-img">
                                </td>
                                <td>
                                    <span><?php echo $name; ?></span>
                                </td>
                                <td>
                                    <span class="price"><?php echo $amount; ?></span> &#8377;
                                </td>
                                <td>
                                    <input type="number" class="product-qty" min="0" max="<?php echo $maxStocks; ?>" value="<?php echo $qty; ?>">
                                </td>
                                <td>
                                    <span class="total"><?php echo $totalAmount; ?></span> &#8377;
                                </td>
                                <td>
                                    <span class="cart-remove">&#9940;</span>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="cart-update-container mg-top-30 mg-bot-30">
                <button class="btn btn-success disabled" id="cart-update-btn">Update</button>
            </div>
        </div>
    </div>
    
    <?php
    if ($subTotal >0) {
        ?>
        <div class="row">
            <div class="col-sm-6"></div>
            <div class="col-sm-6 mg-top-30">
                <h3>CART TOTALS</h3>
                
                <table class="table" id="cart-total-table">
                    <tbody>
                        <tr>
                            <td>SUBTOTAL</td>
                            <td>
                                <span class="sub-total"><?php echo $subTotal; ?></span> &#8377;
                            </td>
                        </tr>
                        <tr>
                            <td>SHIPPING</td>
                            <td><?php echo $shipping; ?> &#8377;</td>
                        </tr>
                        <tr>
                            <td>TOTAL</td>
                            <td>
                                <?php
                                $subTotal += $shipping; ?>
                                <span class="sub-total"><?php echo $subTotal; ?></span> &#8377;
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="proceed-checkout-container mg-bot-30">
                    <a href="checkout.php" class="btn btn-success">Proceed to checkout</a>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
</div>


<?php
require_once 'templates/footer.php';
?>