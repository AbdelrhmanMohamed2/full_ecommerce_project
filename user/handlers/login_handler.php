<?php
session_start();
require_once '../../functions/functions.php';
require_once '../../functions/validations.php';
require_once '../db_functions/users_functions.php';

$errors = [];
$success_massage = 'Welcome !';


if (checkMethod('POST')) {



    // DATA
    // data sanitize
    $email = sanitize($_POST['email']);
    $password = sanitize($_POST['password']);


    // data validations 
    // email validate
    if (empty($email)) {
        $errors['email_error'] = 'email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email_error'] = 'email not valid';
    }
    // password validate
    elseif (empty($password)) {
        $errors['password_error'] = 'password is required';
    }




    // check for errors
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
    } else {

        $user = login($email, $password);

        if ($user !== false) {
            $_SESSION['data'] = $user;
            $_SESSION['success'] = $success_massage;
            redirect("../profile.php");
        }

        $errors['email_error'] = 'invalid user email or password';
        $_SESSION['errors'] = $errors;
    }
    redirect('../login.php');

    // wrong method
} else {
    $errors['method_error'] = 'wrong method';
    $_SESSION['errors'] = $errors;
    redirect('../register.php');
}
