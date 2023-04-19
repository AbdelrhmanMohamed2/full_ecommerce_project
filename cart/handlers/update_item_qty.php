<?php
session_start();
require_once '../../functions/functions.php';
require_once '../../functions/validations.php';
require_once '../../product/functions/db_functions.php';
require_once '../cart_functions/cart_functions.php';

$errors = [];
$success_massage = 'product quantity updated successfully';

if (isset($_SESSION['data']) && checkMethod('POST')) {

    require_once '../../product/functions/product_validations.php';

    // data 
    $item_id = ($_POST['item_id']);
    $product_qty = ($_POST['product_quantity']);


    // validations 
    // product id
    $item_id_validation = validateProductNumbers($item_id, 'id');
    $product_qty_validation = validateProductNumbers($product_qty, 'quantity');
    if (!empty($item_id_validation['error'])) {
        $errors[] = $item_id_validation['error'];
    } elseif (!empty($product_qty_validation['error'])) {
        $errors[] = $product_qty_validation['error'];
    } else {
        $product = getCartItem($item_id_validation['value']);

        if (!$product) {
            $errors[] = 'product not exists';
        } elseif ($product['stock'] < $product_qty_validation['value']) {
            $errors[] = 'your order exceed the stock';
        }
    }




    // check for errors
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
    } else {
        $_SESSION['success'] = $success_massage;
        updateCartItemQty($item_id_validation['value'], $product_qty_validation['value'], ($product_qty_validation['value'] * $product['price']));
    }


    redirect($_SERVER['HTTP_REFERER']);

    // wrong method
} else {
    $errors['method_error'] = 'wrong method';
    $_SESSION['errors'] = $errors;
    redirect('../../manager/panel.php');
}
