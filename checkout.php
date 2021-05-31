<?php

use Includes\Db\User;

require_once 'templates/header.php';

$userDetails = User::fetchUserDetailsBeforeCheckout();
// print_r($userDetails);

foreach( $userDetails as $key => $value){
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
            <form action="/action_page.php">

                <div class="form-group">
                    <label for="first_name">First name:</label>
                    <input type="text" class="form-control" id="first_name" placeholder="Enter first name"
                        name="first_name" value="<?php echo $firstName;?>">
                </div>

                <div class="form-group">
                    <label for="last_name">Last name:</label>
                    <input type="text" class="form-control" id="last_name" placeholder="Enter password"
                        name="last_name" value="<?php echo $lastName;?>">
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" placeholder="Email" name="email" value="<?php echo $firstName;?>">
                </div>

                <div class="form-group">
                    <label for="contact_number">Contact number:</label>
                    <input type="text" class="form-control" id="contact_number" placeholder="Contact number"
                        name="contact_number" value="<?php echo $contactNumber;?>">
                </div>
                
                <div class="form-group">
                    <label for="address">Address:</label>
                    <textarea 
                        class="form-control" 
                        rows="5" 
                        id="address" 
                        name="address" 
                        placeholder="Address"><?php echo $address;?></textarea>
                </div>

                <div class="form-group">
                    <label for="pincode">Pincode:</label>
                    <input type="text" class="form-control" id="pincode" placeholder="Pincode"
                        name="pincode" value="<?php echo $postalCode;?>">
                </div>
                <div class="form-group">
                    <label for="city">City:</label>
                    <input type="text" class="form-control" id="city" placeholder="City"
                        name="city" value="<?php echo $city;?>">
                </div>
                <div class="form-group">
                    <label for="State">State:</label>
                    <input type="text" class="form-control" id="State" placeholder="State"
                        name="State" value="<?php echo $state;?>">
                </div>
                <div class="form-group">
                    <label for="country">Country:</label>
                    <input type="text" class="form-control" id="country" placeholder="Country"
                        name="country" value="<?php echo $country;?>">
                </div>
                <div class="form-group">
                    <label for="landmark">Landmark:</label>
                    <input type="text" class="form-control" id="landmark" placeholder="Landmark"
                        name="landmark" value="<?php echo $landmark;?>">
                </div>
                <div class="form-group">
                    <label for="order_note">Order note:</label>
                    <textarea 
                        class="form-control" 
                        rows="5" 
                        id="order_note" 
                        name="order_note" 
                        placeholder="Orders notes if any"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
<?php
require_once 'templates/footer.php';
?>