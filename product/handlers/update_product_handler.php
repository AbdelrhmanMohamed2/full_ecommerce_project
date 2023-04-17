<?php
session_start();
require_once '../../functions/functions.php';
require_once '../../functions/validations.php';
require_once '../functions/db_functions.php';

$errors = [];
$success_massage = 'product Updated successfully';
$product_data = [];

if (checkMethod('POST') && $_SESSION['data']['roll'] == 1) {

    // validation functions and logic
    require_once '../functions/product_validations.php';

    // data 
    $product_name = $_POST['product_name'];
    $product_description = $_POST['product_description'];
    $product_price = $_POST['product_price'];
    $product_stock = $_POST['product_stock'];
    $category_id = $_POST['category_id'];
    $product_id = $_POST['product_id'];


    // validations 

    // product id
    $product_id_validation = validateProductNumbers($product_id, 'id');
    if (!empty($product_id_validation['error'])) {
        $errors[] = $product_id_validation['error'];
    } elseif (!checkExists($product_id, 'id',  'products')) {
        $errors[] = 'invalid category';
    } else {
        $product_data['id'] =  $product_id_validation['value'];
    }

    // product name
    $product_name_validation = validateProductName($product_name);
    if (!empty($product_name_validation['error'])) {
        $errors[] = $product_name_validation['error'];
    } elseif (checkName($product_name_validation['value'], $product_id_validation['value'])) {
        $errors[] = 'name already used before';
    } else {
        $product_data['name'] =  $product_name_validation['value'];
    }


    // product description
    $product_description_validation = validateProductDescription($product_description);
    if (!empty($product_description_validation['error'])) {
        $errors[] = $product_description_validation['error'];
    } else {
        $product_data['description'] =  $product_description_validation['value'];
    }


    // product price
    $product_price_validation = validateProductNumbers($product_price, 'price');
    if (!empty($product_price_validation['error'])) {
        $errors[] = $product_price_validation['error'];
    } else {
        $product_data['price'] =  $product_price_validation['value'];
    }


    // product stock
    $product_stock_validation = validateProductNumbers($product_stock, 'stock');
    if (!empty($product_stock_validation['error'])) {
        $errors[] = $product_stock_validation['error'];
    } else {
        $product_data['stock'] =  $product_stock_validation['value'];
    }


    // product category
    $product_category_validation = validateProductNumbers($category_id, 'category');
    if (!empty($product_category_validation['error'])) {
        $errors[] = $product_category_validation['error'];
    } elseif (!checkExists($category_id, 'id',  'categories')) {
        $errors[] = 'invalid category';
    } else {
        $product_data['category_id'] =  $product_category_validation['value'];
    }








    // check for errors
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        // if (isset($product_data['imgs'])) {
        //     deleteAllProductImgs($product_data['imgs']);
        // }
    } else {
        // createProduct($product_data);
        UpdateProduct($product_data);
        $_SESSION['success'] = $success_massage;
    }

    redirect('../edit_product.php?id=' . $product_id_validation['value']);

    // wrong method
} else {
    $errors['method_error'] = 'wrong method';
    $_SESSION['errors'] = $errors;
    redirect('../../manager/panel.php');
}
