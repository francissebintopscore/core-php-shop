<?php
require_once dirname(__FILE__).'/../config.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootstrap 4 Website Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo CSS_URL;?>bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo CSS_URL;?>style.css">
    <script src="<?php echo JS_URL;?>jquery.min.js"></script>
    <script src="<?php echo JS_URL;?>popper.min.js"></script>
    <script src="<?php echo JS_URL;?>bootstrap.min.js"></script>
    <style>
    .fakeimg {
        height: 200px;
        background: #aaa;
    }
    </style>
</head>

<body>

    <div class="text-center" style="margin-bottom:0">
        <h1>My Shop</h1>
    </div>

    <nav class="navbar navbar-expand-sm bg-dark navbar-dark sticky-top">
        <a class="navbar-brand" href="index.php">Shop</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="shop.php">Shop</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cart.php">Cart</a>
                </li>
            </ul>
        </div>
    </nav>