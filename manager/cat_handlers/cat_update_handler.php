<?php
session_start();
require_once '../../functions/functions.php';
require_once '../../functions/validations.php';
require_once '../cat_db_functions/cat_functions.php';

$allowed_logo_types = ['image/png', 'image/jpeg'];
$errors = [];
$success_massage = 'category updated successfully!';
$cat_data = [];

if (checkMethod('POST') && $_SESSION['data']['roll'] == 1) {

    // consts
    // name length
    define('MAX_NAME_SIZE', 15);
    define('MIN_NAME_SIZE', 2);
    // description length
    define('MAX_DESC_SIZE', 30);
    define('MIN_DESC_SIZE', 5);
    // LOGO size
    define('MAX_LOGO_SIZE', 5000000);
    define('MIN_LOGO_SIZE', 1000);
    // logo upload path
    define('UPLOAD_LOGO_PATH', "../cat_logos/");
    if (!is_dir(UPLOAD_LOGO_PATH)) {
        mkdir(UPLOAD_LOGO_PATH, "0777");
    }


    // DATA
    // data sanitize
    $id = sanitize($_POST['id']);
    $cat_name = sanitize($_POST['cat_name']);
    $cat_desc = sanitize($_POST['cat_desc']);


    // data validations
    // id validations
    if (empty($id)) {
        $errors[] = 'id is missing';
    } elseif (!is_numeric($id)) {
        $errors[] = 'invalid id';
    } else {
        $cat_data['id'] = $id;
    }


    // category name validations
    if (empty($cat_name)) {
        $errors[] = 'category name is required';
    } elseif (is_numeric($cat_name)) {
        $errors[] = 'category name must be string';
    } elseif (maxInputSize($cat_name, MAX_NAME_SIZE)) {
        $errors[] = 'category name must is too larg, max = ' . MAX_NAME_SIZE;
    } elseif (minInputSize($cat_name, MIN_NAME_SIZE)) {
        $errors[] = 'category name must is too small, min = ' . MIN_NAME_SIZE;
    } else {
        $cat_data['name'] = $cat_name;
    }

    // category description validations
    if (empty($cat_desc)) {
        $errors[] = 'category description is required';
    } elseif (is_numeric($cat_desc)) {
        $errors[] = 'category description must be string';
    } elseif (maxInputSize($cat_desc, MAX_DESC_SIZE)) {
        $errors[] = 'category description  is too larg, max = ' . MAX_DESC_SIZE;
    } elseif (minInputSize($cat_desc, MIN_NAME_SIZE)) {
        $errors[] = 'category description  is too small, min = ' . MIN_DESC_SIZE;
    } else {
        $cat_data['description'] = $cat_desc;
    }



    // logo data
    $logo = $_FILES['cat_logo'];
    $logo_name = $logo['name'];
    if ($logo_name !== '') {

        $logo_tmp_name = $logo['tmp_name'];
        $logo_error = $logo['error'];

        $logo_size = filesize($logo_tmp_name);
        $logo_info = finfo_open(FILEINFO_MIME_TYPE);
        $logo_mime_type = finfo_file($logo_info, $logo_tmp_name);

        $logo_extension = pathinfo($logo_name, PATHINFO_EXTENSION);


        // validations
        if ($logo_size > MAX_LOGO_SIZE) {
            $errors[] = 'logo is too large';
        } else if ($logo_size < MIN_LOGO_SIZE) {
            $errors[] = 'logo is too small';
        } elseif ($logo_error !== 0) {
            $errors[] = 'there is an error uploading the logo';
        } elseif (!in_array($logo_mime_type, $allowed_logo_types)) {
            $errors[] = 'invalid logo type';
        } else {
            $new_logo_name = uniqid('', true) . "." . $logo_extension;
            $logo_new_path = UPLOAD_LOGO_PATH . $new_logo_name;
            if (!move_uploaded_file($logo_tmp_name, $logo_new_path)) {
                $errors[] = 'moving logo error';
            } else {
                $cat_data['logo'] = $new_logo_name;
            }
        }
    }


    // check for errors
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        if (isset($new_logo_name)) {
            unlink(UPLOAD_IMG_PATH . $new_logo_name);
        }
    } else {
        $old_img = editCat($cat_data);
        if ($old_img) {
            $_SESSION['success'] = $success_massage;
            if (isset($new_logo_name)) {
                unlink(UPLOAD_LOGO_PATH . $old_img);
            }
        } else {
            $errors[] = 'cant update this category';
            $_SESSION['errors'] = $errors;
        }
    }

    redirect('../update_cat.php?id=' . $id);



    // wrong method
} else {
    $errors['method_error'] = 'wrong method';
    $_SESSION['errors'] = $errors;
    redirect('../../user/profile.php');
}
