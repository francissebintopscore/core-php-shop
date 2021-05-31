<?php
require_once 'templates/header.php';

use Includes\Db\Product;

$products = new Product();
$imgBase = UPLOADS_URL.'products/';
// print_r( $products->findAll() );
?>
<div class="container au-sep">
    <div class="row">

    <?php
    foreach ( $products->findAll() as $key => $value ){

        $id = $value['id'];
        $img = $imgBase . $value['image'];
        $name = $value['name'];
        $amount = $value['amount'];
        ?>
        <div class="col">
            <div class="card" style="width:400px">
                <img class="card-img-top" src="<?php echo $img;?>" alt="Card image" style="width:100%">
                <div class="card-body">
                    <h4 class="card-title"><?php echo $name;?></h4>
                    <p class="card-text"><?php echo $amount;?> &#8377;</p>
                    <a href="#" class="btn btn-primary">View</a>
                    <a 
                        href="#" 
                        class="btn btn-primary ajax-addToCart" 
                        data-product-id="<?php echo $id;?>">
                    Add to cart</a>
                </div>
            </div>
        </div>
        <?php
    }
    ?>

    </div>
</div>
<?php
require_once 'templates/footer.php';
?>