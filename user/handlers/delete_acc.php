<?php
session_start();
require_once '../../functions/functions.php';
require_once '../../functions/validations.php';
require_once '../db_functions/users_functions.php';

$errors = [];
$success_massage = 'account deleted successfully!';


if (checkMethod('POST')) {

    // img  path
    define('UPLOAD_IMG_PATH', "../imgs/");
    // password length
    define('MAX_PASSWORD_SIZE', 20);
    define('MIN_PASSWORD_SIZE', 6);

    // data 
    // data sanitization
    $password = sanitize($_POST['password']);
    $con_password = sanitize($_POST['con_password']);

    // data validations
    // password validations
    if (empty($password)) {
        $errors[] = 'password is required';
    }

    // confirm password validations
    if (empty($con_password)) {
        $errors[] = 'confirm password is required';
    } elseif ($con_password !== $password) {
        $errors[] = 'password and confirm password must be the same ';
    }




    // check for errors
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
    } else {
        $roll = $_SESSION['data']['roll'] ?? 3;
        if (deleteAccount($password, $_SESSION['data']['id'], $roll)) {
            $_SESSION['success'] = $success_massage;
            unlink(UPLOAD_IMG_PATH . $_SESSION['data']['img']);
            redirect('../logout.php');
        } else {
            $errors[] = 'Wrong password';
            $_SESSION['errors'] = $errors;
        }
    }
    if ($id == $_SESSION['data']['id']) {

        redirect('logout.php');
    }
    redirect('../profile.php');

    // wrong method
} else {
    $errors['method_error'] = 'wrong method';
    $_SESSION['errors'] = $errors;
    redirect('../profile.php');
}
