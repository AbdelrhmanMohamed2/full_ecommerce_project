<?php
session_start();
require_once '../../functions/functions.php';
require_once '../../functions/validations.php';
require_once '../functions/db_functions.php';

$errors = [];
$success_massage = 'product created successfully';
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
    $product_imgs = $_FILES['product_imgs'];


    // validations 
    // product name
    $product_name_validation = validateProductName($product_name);
    if (!empty($product_name_validation['error'])) {
        $errors[] = $product_name_validation['error'];
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
        $product_data['category'] =  $product_category_validation['value'];
    }


    // product imgs
    $product_imgs_validation = validateProductImgs($product_imgs);
    if (!empty($product_imgs_validation['error'])) {
        $errors[] = $product_imgs_validation['error'];
    } else {
        $product_data['imgs'] =  $product_imgs_validation['value'];
    }



    // check for errors
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        if (isset($product_data['imgs'])) {
            deleteImgsOnError($product_data['imgs']);
        }
    } else {
        createProduct($product_data);
        $_SESSION['success'] = $success_massage;
    }

    redirect('../../manager/panel.php');

    // wrong method
} else {
    $errors['method_error'] = 'wrong method';
    $_SESSION['errors'] = $errors;
    redirect('../../manager/panel.php');
}
