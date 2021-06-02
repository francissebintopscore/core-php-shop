<?php
require_once 'templates/header.php';

use Includes\Db\Cart;
use Includes\Db\User;
use Includes\Db\Item;
use Includes\Helpers\User as HelpersUser;

if (!HelpersUser::userLoggedIn()) {
    header('Location: '. BASE_URL);
    die();
}

$userDetails = User::fetchDetailsBeforeCheckout();

foreach ($userDetails as $key => $value) {
    $email = $value['email'];
    $firstName = $value['first_name'];
    $lastName = $value['last_name'];
    $contactNumber = $value['contact_number'];
    $address = $value['address'];
    $postalCode = $value['postal_code'];
    $city = $value['city'];
    $state = $value['state'];
    $country = $value['country'];
    $landmark = $value['landmark'];
    break;
}
$cart = new Cart();
$cartItem = new Item();
$items = $cart->getItems();
$items = $cartItem->mergeItemWithProducts($items);
?>
<div class="container mg-top-30">
    <div class="row">
        <div class="col-sm-12">
            <div class="au-heading">
                <h2>Checkout</h2>
            </div>
        </div>
    </div>
    <div class="row mg-top-30 mg-bot-30">
        <div class="col-sm-12">
            <h5>Billing Details</h5>
            <form action="actions/payments.php" method="POST" id="paymentFrm">

                <div class="form-group">
                    <label for="first_name">First name:</label>
                    <input type="text" class="form-control" id="first_name" placeholder="Enter first name"
                        name="first_name" value="<?php echo $firstName;?>">
                </div>

                <div class="form-group">
                    <label for="last_name">Last name:</label>
                    <input type="text" class="form-control" id="last_name" placeholder="Enter password" name="last_name"
                        value="<?php echo $lastName;?>">
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" placeholder="Email" name="email"
                        value="<?php echo $email;?>">
                </div>

                <div class="form-group">
                    <label for="contact_number">Contact number:</label>
                    <input type="text" class="form-control" id="contact_number" placeholder="Contact number"
                        name="contact_number" value="<?php echo $contactNumber;?>">
                </div>

                <div class="form-group">
                    <label for="address">Address:</label>
                    <textarea class="form-control" rows="5" id="address" name="address"
                        placeholder="Address"><?php echo $address;?></textarea>
                </div>

                <div class="form-group">
                    <label for="pincode">Pincode:</label>
                    <input type="text" class="form-control" id="pincode" placeholder="Pincode" name="pincode"
                        value="<?php echo $postalCode;?>">
                </div>
                <div class="form-group">
                    <label for="city">City:</label>
                    <input type="text" class="form-control" id="city" placeholder="City" name="city"
                        value="<?php echo $city;?>">
                </div>
                <div class="form-group">
                    <label for="State">State:</label>
                    <input type="text" class="form-control" id="State" placeholder="State" name="State"
                        value="<?php echo $state;?>">
                </div>
                <div class="form-group">
                    <label for="country">Country:</label>
                    <input type="text" class="form-control" id="country" placeholder="Country" name="country"
                        value="<?php echo $country;?>">
                </div>
                <div class="form-group">
                    <label for="landmark">Landmark:</label>
                    <input type="text" class="form-control" id="landmark" placeholder="Landmark" name="landmark"
                        value="<?php echo $landmark;?>">
                </div>
                <div class="form-group">
                    <label for="order_note">Order note:</label>
                    <textarea class="form-control" rows="5" id="order_note" name="order_note"
                        placeholder="Orders notes if any"></textarea>
                </div>

                <div class="panel-heading">

                    <!-- Product Info -->
                    <?php
                    $subTotal = 50;
                    foreach ($items as $item) {
                        $product = $item['product_data']['name'];
                        $amount = $item['product_data']['amount'];
                        $qty = $item['qty'];
                        $total = floatval($amount) * $qty;
                        $subTotal += $total; ?>
                        <p
                            ><b>Item :</b> 
                            <?php echo $product; ?>
                            x <?php echo $qty; ?>
                            <span style="padding-left: 50px;"><?php echo $total; ?> &#8377;</span>
                        </p>
                        <?php
                    }
                    ?>
                    <p><b>Shipping</b> : 50 &#8377; </p>
                    <h3 class="panel-title">Charge <?php echo $subTotal;?> &#8377; with Stripe</h3>
                    <input type="text" name="sub_total" value="<?php echo $subTotal;?>">
                </div>
                <div class="form-group">
                    <label>CARD NUMBER</label>
                    <div id="card_number" class="field"></div>
                </div>
                <div class="row">
                    <div class="left">
                        <div class="form-group">
                            <label>EXPIRY DATE</label>
                            <div id="card_expiry" class="field"></div>
                        </div>
                    </div>
                    <div class="right">
                        <div class="form-group">
                            <label>CVC CODE</label>
                            <div id="card_cvc" class="field"></div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
<script src="https://js.stripe.com/v3/"></script>
<script src="<?php echo JS_URL;?>stripe-customization.js"></script>
<script>
// Create an instance of the Stripe object
// Set your publishable API key
var stripe = Stripe('<?php echo STRIPE_PUBLISHABLE_KEY; ?>');

// Create an instance of elements
var elements = stripe.elements();

var style = {
    base: {
        fontWeight: 400,
        fontFamily: 'Roboto, Open Sans, Segoe UI, sans-serif',
        fontSize: '16px',
        lineHeight: '1.4',
        color: '#555',
        backgroundColor: '#fff',
        '::placeholder': {
            color: '#888',
        },
    },
    invalid: {
        color: '#eb1c26',
    }
};

var cardElement = elements.create('cardNumber', {
    style: style
});
cardElement.mount('#card_number');

var exp = elements.create('cardExpiry', {
    'style': style
});
exp.mount('#card_expiry');

var cvc = elements.create('cardCvc', {
    'style': style
});
cvc.mount('#card_cvc');

// Validate input of the card elements
var resultContainer = document.getElementById('paymentResponse');
cardElement.addEventListener('change', function(event) {
    if (event.error) {
        resultContainer.innerHTML = '<p>' + event.error.message + '</p>';
    } else {
        resultContainer.innerHTML = '';
    }
});

// Get payment form element
var form = document.getElementById('paymentFrm');

// Create a token when the form is submitted.
form.addEventListener('submit', function(e) {
    e.preventDefault();
    createToken();
});

// Create single-use token to charge the user
function createToken() {
    stripe.createToken(cardElement).then(function(result) {
        if (result.error) {
            // Inform the user if there was an error
            resultContainer.innerHTML = '<p>' + result.error.message + '</p>';
        } else {
            // Send the token to your server
            stripeTokenHandler(result.token);
        }
    });
}

// Callback to handle the response from stripe
function stripeTokenHandler(token) {
    // Insert the token ID into the form so it gets submitted to the server
    var hiddenInput = document.createElement('input');
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('name', 'stripeToken');
    hiddenInput.setAttribute('value', token.id);
    form.appendChild(hiddenInput);

    // Submit the form
    form.submit();
}
</script>
<?php
require_once 'templates/footer.php';
?>