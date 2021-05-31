<?php
require_once 'templates/header.php';
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
                        <tr>
                            <td>
                                <img src="http://localhost/sebin/php/custom/study/shop/assets/uploads/products/cooker.jpg"
                                    width="145" alt="product-img">
                            </td>
                            <td>
                                <span>Pressure Cooker</span>
                            </td>
                            <td>
                                <span class="price">145</span> &#8377;
                            </td>
                            <td>
                                <input type="number" class="product-qty" min="0" value="1">
                            </td>
                            <td>
                                <span class="total">145</span> &#8377;
                            </td>
                            <td>
                                <span>&#9940;</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <img src="http://localhost/sebin/php/custom/study/shop/assets/uploads/products/shirt.jpg"
                                    width="145" alt="product-img">
                            </td>
                            <td>
                                <span>Shirt</span>
                            </td>
                            <td>
                                <span class="price">1000</span> &#8377;
                            </td>
                            <td>
                                <input type="number" class="product-qty" min="0" value="1">
                            </td>
                            <td>
                                <span class="total">1000</span> &#8377;
                            </td>
                            <td>
                                <span>&#9940;</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="cart-update-container mg-top-30">
                <button class="btn btn-success disabled" id="cart-update-btn">Update</button>
            </div>
        </div>
    </div>

    <div class="row">
    <div class="col-sm-6"></div>
        <div class="col-sm-6 mg-top-30">
            <h3>CART TOTALS</h3>
            
            <table class="table" id="cart-total-table">
                <tbody>
                    <tr>
                        <td>SUBTOTAL</td>
                        <td>
                            <span class="sub-total">1000</span> &#8377;
                        </td>
                    </tr>
                    <tr>
                        <td>SHIPPING</td>
                        <td>0 &#8377;</td>
                    </tr>
                    <tr>
                        <td>TOTAL</td>
                        <td>
                        <span class="sub-total">1000</span> &#8377;
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="proceed-checkout-container mg-bot-30">
                <a href="#" class="btn btn-success">Proceed to checkout</a>
            </div>
        </div>
    </div>
</div>


<?php
require_once 'templates/footer.php';
?>