<?php
require_once 'config.php';

use Includes\Db\User;

$cartItems  = isset($_COOKIE['cart_items']) ? $_COOKIE['cart_items'] : '';
$userId     = $_SESSION['user_data']['id'];
User::update(array('cart_items'=>$cartItems), $userId, 'users');
$_SESSION['user_data'] = '';
header('Location: '. BASE_URL . 'login.php');
