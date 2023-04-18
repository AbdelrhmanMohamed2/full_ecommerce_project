<?php
session_start();
require_once '../../functions/functions.php';
require_once '../db_functions/users_functions.php';

$allowed_img_types = ['image/png', 'image/jpeg'];
$errors = [];
$success_massage = 'IMG updated successfully!';


if (checkMethod('POST')) {
    // consts
    // img size
    define('MAX_IMG_SIZE', 5000000);
    define('MIN_IMG_SIZE', 1000);

    // img upload path
    define('UPLOAD_IMG_PATH', "../imgs/");
    if (!is_dir(UPLOAD_IMG_PATH)) {
        mkdir(UPLOAD_IMG_PATH, "0777");
    }




    // img data 
    $img = $_FILES['profile_img'];
    $img_name = $img['name'];
    if ($img_name !== '') {

        $img_tmp_name = $img['tmp_name'];
        $img_error = $img['error'];

        $img_size = filesize($img_tmp_name);
        $img_info = finfo_open(FILEINFO_MIME_TYPE);
        $img_mime_type = finfo_file($img_info, $img_tmp_name);

        $img_extension = pathinfo($img_name, PATHINFO_EXTENSION);


        // validations 
        if ($img_size > MAX_IMG_SIZE) {
            $errors[] = 'img is too large';
        } else if ($img_size < MIN_IMG_SIZE) {
            $errors[] = 'img is too small';
        } elseif ($img_error !== 0) {
            $errors[] = 'there is an error uploading the img';
        } elseif (!in_array($img_mime_type, $allowed_img_types)) {
            $errors[] = 'invalid img type';
        } else {
            $new_img_name = uniqid('', true) . "." . $img_extension;
            $img_new_path = UPLOAD_IMG_PATH . $new_img_name;
            if (!move_uploaded_file($img_tmp_name, $img_new_path)) {
                $errors[] = 'moving img error';
            } else {
                $result =  updateImg($new_img_name, $_SESSION['data']['email']);
                if ($result == false) {
                    $errors[] = 'email no match';
                    unlink(UPLOAD_IMG_PATH . $new_img_name);
                } else {
                    $_SESSION['data']['img'] = $new_img_name;
                    unlink(UPLOAD_IMG_PATH . $result);
                }
            }
        }
    } else {
        $errors[] = 'img is required';
    }




    // check for errors
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
    } else {
        $_SESSION['success'] = $success_massage;
    }
    redirect('../profile.php');

    // wrong method
} else {
    $errors['method_error'] = 'wrong method';
    $_SESSION['errors'] = $errors;
    redirect('../profile.php');
}
