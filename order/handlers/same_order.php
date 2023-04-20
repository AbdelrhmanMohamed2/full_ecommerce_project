<?php
session_start();
require_once '../../inc/header.php';
require_once '../../functions/functions.php';
require_once '../../functions/validations.php';
require_once '../functions/db_functions.php';
require_once '../../cart/cart_functions/cart_functions.php';
require_once '../../product/functions/db_functions.php';

$errors = [];
$success_massage = 'Order created successfully';


if (checkMethod('GET')) {

    $order_id = sanitize($_GET['id']);
    //  validations
    if (empty($order_id)) {
        $errors[] = 'order id is missing';
    } elseif (!is_numeric($order_id)) {
        $errors[] = 'order id must be number';
    } elseif ($order_id < 0) {
        $errors[] = 'order id must be positive number';
    } else {

        $number_of_product = 0;
        $order_details = getOrderInfo($_GET['id'], $_SESSION['data']['id']);

        if (mysqli_num_rows($order_details['result']) == 0) {
            $errors[] = "order not exists";
        }
        while ($order_product = mysqli_fetch_assoc($order_details['result'])) {
            $product_details = getProductInfo($order_product['product_id']);


            if (!$product_details) {
                $errors[] = "product not exists anymore";
            } elseif ($product_details['product_stock'] < $order_product['quantity']) {
                $errors[] = "product " . $product_details['product_name'] . " has not enough stock";
            } else {
                $cart_data = [
                    'user_id' => $_SESSION['data']['id'],
                    'product_id' => $product_details['product_id'],
                    'product_name' => $product_details['product_name'],
                    'quantity' => $order_product['quantity'],
                    'total_price' => ($product_details['product_price'] * $order_product['quantity'])
                ];
                addToCart($cart_data);
                $number_of_product += 1;
            }
        }
    }




    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
    }

    if (!isset($_SESSION['cart_counter'])) {
        $_SESSION['cart_counter'] =  1;
    }
    $_SESSION['cart_counter'] = $_SESSION['cart_counter'] + $number_of_product;



    redirect(URL . 'cart/show_cart.php');
    // wrong method
} else {
    $errors['method_error'] = 'wrong method';
    $_SESSION['errors'] = $errors;
    redirect('../../index.php');
}
