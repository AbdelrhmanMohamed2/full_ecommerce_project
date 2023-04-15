<?php
session_start();
require_once '../../functions/functions.php';
require_once '../../functions/validations.php';
require_once '../../user/db_functions/users_functions.php';

$allowed_img_types = ['image/png', 'image/jpeg'];
$errors = [];
$success_massage = 'account created successfully!';
$users_data = [];

if (checkMethod('POST') && $_SESSION['data']['roll'] == 1) {
    // img upload path
    define('UPLOAD_IMG_PATH', "../../user/imgs/");
    if (!is_dir(UPLOAD_IMG_PATH)) {
        mkdir(UPLOAD_IMG_PATH, "0777");
    }

    // register validations
    require_once '../../user/handlers/reg_val.php';


    // roll  
    // roll sanitize 
    $roll = sanitize($_POST['roll']);
    // first name validations
    if (empty($roll)) {
        $errors[] = 'roll is missing';
    } elseif (!is_numeric($roll)) {
        $errors[] = 'invalid roll value';
    } elseif (!checkRollExists($roll)) {
        $errors[] = 'roll dose not exists';
    } else {
        $users_data['roll'] = $roll;
    }



    // check for errors
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
    } else {

        if (register($users_data)) {
            $_SESSION['success'] = $success_massage;
        } else {
            $errors[] = 'user already used before';
            $_SESSION['errors'] = $errors;
        }
    }
    redirect('../panel.php');

    // wrong method
} else {
    $errors['method_error'] = 'wrong method';
    $_SESSION['errors'] = $errors;
    redirect('../panel.php');
}
