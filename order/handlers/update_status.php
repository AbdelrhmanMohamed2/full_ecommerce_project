<?php
session_start();
require_once '../../functions/functions.php';
require_once '../../functions/validations.php';
require_once '../functions/db_functions.php';


$errors = [];
$success_massage = 'Order Status Updated successfully';


if (checkMethod('POST') && $_SESSION['data']['roll'] == 1) {

    // data 
    $order_id = sanitize($_POST['order_id']);
    $status_id = sanitize($_POST['status_id']);

    // validations
    // order id
    if (empty($order_id)) {
        $errors[] = 'order id is missing';
    } elseif (!is_numeric($order_id)) {
        $errors[]  = 'order id must be number';
    } elseif ($order_id < 0) {
        $errors[] = 'order id must be positive number';
    }


    // status id
    if (empty($status_id)) {
        $errors[] = 'status id is missing';
    } elseif (!is_numeric($status_id)) {
        $errors[]  = 'status id must be number';
    } elseif ($status_id < 0) {
        $errors[] = 'status id must be positive number';
    }

    // check for errors
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
    } else {
        $_SESSION['success'] = $success_massage;
        updateOrderStatus($order_id, $status_id);
    }

    redirect($_SERVER['HTTP_REFERER']);
    // wrong method
} else {
    $errors['method_error'] = 'wrong method';
    $_SESSION['errors'] = $errors;
    redirect('../../index.php');
}
