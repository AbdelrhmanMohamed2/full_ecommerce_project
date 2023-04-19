<?php
session_start();
require_once '../../functions/functions.php';
require_once '../../functions/validations.php';
require_once '../functions/db_functions.php';


$errors = [];
$success_massage = 'Product Deleted successfully!';


if (checkMethod('GET') && $_SESSION['data']['roll'] == 1) {
    define('UPLOAD_IMG_PATH', "../imgs/");

    // data 
    $product_id = $_GET['id'];

    // id sanitize and validate
    $product_product_validation = validateProductNumbers($product_id, 'product');
    if (!empty($product_product_validation['error'])) {
        $errors[] = $product_product_validation['error'];
    } elseif (!checkExists($product_product_validation['value'], 'id',  'products')) {
        $errors[] = 'invalid product id';
    }




    // check for errors
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
    } else {
        deleteProduct($product_product_validation['value']);
        $_SESSION['success'] = $success_massage;
    }

    redirect('../all_products.php');

    // wrong method
} else {
    $errors['method_error'] = 'wrong method';
    $_SESSION['errors'] = $errors;
    redirect('../panel.php');
}
