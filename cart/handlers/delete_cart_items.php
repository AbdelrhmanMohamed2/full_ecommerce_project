<?php
session_start();
require_once '../../functions/functions.php';
require_once '../../functions/validations.php';
require_once '../../product/functions/db_functions.php';
require_once '../cart_functions/cart_functions.php';


$errors = [];


if (checkMethod('GET') && isset($_SESSION['data'])) {

    deleteCartItems($_SESSION['data']['id']);


    $_SESSION['cart_counter'] = 0;
    redirect($_SERVER['HTTP_REFERER']);

    // wrong method
} else {
    $errors['method_error'] = 'wrong method';
    $_SESSION['errors'] = $errors;
    redirect(URL . 'manager/panel.php');
}
