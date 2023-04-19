<?php
session_start();
require_once '../../functions/functions.php';
require_once '../../functions/validations.php';
require_once '../../product/functions/db_functions.php';
require_once '../cart_functions/cart_functions.php';


$errors = [];


if (checkMethod('GET') && isset($_SESSION['data'])) {


    // data 
    $cart_item = $_GET['id'];

    // id sanitize and validate
    $cart_item_validation = validateProductNumbers($cart_item, 'product');
    if (!empty($cart_item_validation['error'])) {
        $errors[] = $cart_item_validation['error'];
    } elseif (deleteCartItem($cart_item_validation['value'], $_SESSION['data']['id']) != 1) {
        $errors[] = 'invalid item id';
    }




    // check for errors
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
    } else {
        $_SESSION['cart_counter'] -= 1;
    }

    redirect($_SERVER['HTTP_REFERER']);

    // wrong method
} else {
    $errors['method_error'] = 'wrong method';
    $_SESSION['errors'] = $errors;
    redirect('../panel.php');
}
