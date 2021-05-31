<?php
require_once 'config.php';
session_start();
$_SESSION['user_data'] = '';
header('Location: '. BASE_URL . 'login.php');