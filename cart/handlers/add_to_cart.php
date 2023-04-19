<?php
session_start();
require_once '../../functions/functions.php';
require_once '../../functions/validations.php';
require_once '../../product/functions/db_functions.php';
require_once '../cart_functions/cart_functions.php';

$errors = [];

if (isset($_SESSION['data'])) {

    require_once '../../product/functions/product_validations.php';

    // data 
    $product_id = ($_GET['id']);
    $product_qty = ($_GET['qty']);


    // validations 
    // product id
    $product = [];
    $product_id_validation = validateProductNumbers($product_id, 'id');
    $product_qty_validation = validateProductNumbers($product_qty, 'quantity');
    if (!empty($product_id_validation['error'])) {
        $errors[] = $product_id_validation['error'];
    } elseif (!empty($product_qty_validation['error'])) {
        $errors[] = $product_qty_validation['error'];
    } else {
        $product = getProductInfo($product_id_validation['value']);
        if (!$product) {
            $errors['method_error'] = 'product not exists';
        } elseif ($product['product_stock'] < $product_qty_validation['value']) {
            $errors['method_error'] = 'your order exceed the stock';
        }
        // var_dump($product);
    }




    // check for errors
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
    } else {
        if (!isset($_SESSION['cart_counter'])) {
            $_SESSION['cart_counter'] =  1;
        }
        $_SESSION['cart_counter'] = $_SESSION['cart_counter'] + 1;
        $cart_data = [
            'user_id' => $_SESSION['data']['id'],
            'product_id' => $product['product_id'],
            'product_name' => $product['product_name'],
            'quantity' => $product_qty_validation['value'],
            'total_price' => ($product['product_price'] * $product_qty_validation['value'])
        ];
        (addToCart($cart_data));
    }


    redirect($_SERVER['HTTP_REFERER']);

    // wrong method
} else {
    $errors['method_error'] = 'wrong method';
    $_SESSION['errors'] = $errors;
    redirect('../../manager/panel.php');
}
