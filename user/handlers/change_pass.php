<?php
session_start();
require_once '../../functions/functions.php';
require_once '../../functions/validations.php';
require_once '../db_functions/users_functions.php';

$errors = [];
$success_massage = 'password updated successfully!';


if (checkMethod('POST')) {


    // password length
    define('MAX_PASSWORD_SIZE', 20);
    define('MIN_PASSWORD_SIZE', 6);

    // data 
    // data sanitization
    $old_password = sanitize($_POST['old_password']);
    $password = sanitize($_POST['password']);
    $con_password = sanitize($_POST['con_password']);

    // data validations
    // password validations
    if (empty($old_password)) {
        $errors[] = 'password is required';
    }

    // password validations
    if (empty($password)) {
        $errors[] = 'password is required';
    } elseif (maxInputSize($password, MAX_PASSWORD_SIZE)) {
        $errors[] = 'password must is too larg, max = ' . MAX_PASSWORD_SIZE;
    } elseif (minInputSize($password, MIN_PASSWORD_SIZE)) {
        $errors[] = 'password must is too small, min = ' . MIN_PASSWORD_SIZE;
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
        if (updatePassword($old_password, $password, $_SESSION['data']['email'])) {
            $_SESSION['success'] = $success_massage;
        } else {
            $errors[] = 'Wrong password';
            $_SESSION['errors'] = $errors;
        }
    }
    redirect('../profile.php');

    // wrong method
} else {
    $errors['method_error'] = 'wrong method';
    $_SESSION['errors'] = $errors;
    redirect('../profile.php');
}
