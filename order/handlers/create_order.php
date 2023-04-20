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


if (checkMethod('GET') && $_SESSION['cart_counter'] > 0) {

    // delivery fee
    $delivery = 50;



    $cart_info = getCartInfo($_SESSION['data']['id']);
    $total = 0;

    foreach ($cart_info as $item) {
        if (updateOnOrder($item['product_id'], $item['quantity']) != 1) {
            $_SESSION['errors'][] = 'out of stock';
            redirect($_SERVER['HTTP_REFERER']);
        }

        $total += ($item['total_price']);
    }
    $taxes = (.1 * $total);
    $total_amount = $total + $delivery + $taxes;

    $new_order = [
        'user_id' => $_SESSION['data']['id'],
        'delivery' => $delivery,
        'taxes' => $taxes,
        'total_amount' => $total_amount,
    ];

    $order_id = createOrder($new_order);

    foreach ($cart_info as $item) {
        $item['order_id'] = $order_id;
        moveCartToOrder($item);
    }

    $_SESSION['cart_counter'] = 0;
    redirect(URL . 'order/user_orders.php');

    // wrong method
} else {
    $errors['method_error'] = 'wrong method';
    $_SESSION['errors'] = $errors;
    redirect('../../index.php');
}
