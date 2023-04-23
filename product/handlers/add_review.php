<?php
session_start();
require_once '../../functions/functions.php';
require_once '../../functions/validations.php';
require_once '../functions/db_functions.php';

$errors = [];
$success_massage = 'Review add successfully';
$review_data = [];

if (checkMethod('POST')) {


    // name length
    define('MAX_REVIEW_SIZE', 45);
    define('MIN_REVIEW_SIZE', 2);

    // data 
    $review = sanitize($_POST['review']);
    $product_id = sanitize($_POST['product_id']);

    // review validations
    if (empty($review)) {
        $errors[] = 'review is required';
    } elseif (is_numeric($review)) {
        $errors[] = 'review must be string';
    } elseif (maxInputSize($review, MAX_REVIEW_SIZE)) {
        $errors[] = 'review is too large, max = ' . MAX_REVIEW_SIZE;
    } elseif (minInputSize($review, MIN_NAME_SIZE)) {
        $errors[] = 'review is too small, min = ' . MIN_REVIEW_SIZE;
    } else {
        $review_data['review_body'] = $review;
    }

    // product id validations
    if (empty($product_id)) {
        $errors[] = 'product id is missing';
    } elseif (!is_numeric($product_id)) {
        $errors[] = 'product id must be a number';
    } elseif (checkExists($product_id, 'name',  'products')) {
        $errors[] = 'product not exists';
    } else {
        $review_data['product_id'] = $product_id;
    }





    // check for errors
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
    } else {
        $_SESSION['success'] = $success_massage;
        $review_data['user_id'] = $_SESSION['data']['id'];
        review($review_data);
    }
    redirect($_SERVER['HTTP_REFERER']);


    // wrong method
} else {
    $errors['method_error'] = 'wrong method';
    $_SESSION['errors'] = $errors;
    redirect('../../manager/panel.php');
}
