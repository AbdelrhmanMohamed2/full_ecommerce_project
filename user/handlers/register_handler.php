<?php
session_start();
require_once '../../functions/functions.php';
require_once '../../functions/validations.php';
require_once '../db_functions/users_functions.php';
$allowed_img_types = ['image/png', 'image/jpeg'];
$errors = [];
$success_massage = 'account created successfully, you can login now!';
$users_data = [];

if (checkMethod('POST')) {

    // img upload path
    define('UPLOAD_IMG_PATH', "../imgs/");
    if (!is_dir(UPLOAD_IMG_PATH)) {
        mkdir(UPLOAD_IMG_PATH, "0777");
    }
    // register validations
    require_once 'reg_val.php';

    // check for errors
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
    } else {

        if (register($users_data)) {
            $_SESSION['success'] = $success_massage;
            redirect("../login.php");
        } else {
            $errors['email_error'] = 'user already used before';
            $_SESSION['errors'] = $errors;
        }
    }
    redirect('../register.php');

    // wrong method
} else {
    $errors['method_error'] = 'wrong method';
    $_SESSION['errors'] = $errors;
    redirect('../register.php');
}
