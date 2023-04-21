<?php
session_start();
require_once '../../functions/functions.php';
require_once '../../functions/validations.php';
require_once '../../product/functions/db_functions.php';
require_once '../list_functions/list_db_functions.php';

$errors = [];

if (isset($_SESSION['data'])) {

    require_once '../../product/functions/product_validations.php';

    // data 
    $product_id = ($_GET['id']);

    // validations 
    // product id
    $product = [];
    $product_id_validation = validateProductNumbers($product_id, 'id');
    if (!empty($product_id_validation['error'])) {
        $errors[] = $product_id_validation['error'];
    } else {
        $product = getProductInfo($product_id_validation['value']);
        if (!$product) {
            $errors[] = 'product not exists';
        }
    }




    // check for errors
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
    } else {
        $wishList_data = [
            'user_id' => $_SESSION['data']['id'],
            'product_id' => $product['product_id'],
            'product_name' => $product['product_name'],
        ];
        if (addToWishList($wishList_data) != 1) {

            $_SESSION['errors'][] = 'product already in your WishList';
        }
    }


    redirect($_SERVER['HTTP_REFERER']);

    // wrong method
} else {
    $errors['method_error'] = 'wrong method';
    $_SESSION['errors'] = $errors;
    redirect('../../manager/panel.php');
}
