<?php
session_start();
require_once '../../functions/functions.php';
require_once '../../functions/validations.php';
require_once '../../product/functions/db_functions.php';
require_once '../list_functions/list_db_functions.php';


$errors = [];


if (checkMethod('GET') && isset($_SESSION['data'])) {


    // data 
    $wishList_item = $_GET['id'];

    // id sanitize and validate
    $wishList_item_validation = validateProductNumbers($wishList_item, 'id');
    if (!empty($wishList_item_validation['error'])) {
        $errors[] = $wishList_item_validation['error'];
    } elseif (deleteWishListItem($wishList_item_validation['value'], $_SESSION['data']['id']) != 1) {
        $errors[] = 'invalid item id';
    }




    // check for errors
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
    }
    redirect($_SERVER['HTTP_REFERER']);

    // wrong method
} else {
    $errors['method_error'] = 'wrong method';
    $_SESSION['errors'] = $errors;
    redirect('../panel.php');
}
