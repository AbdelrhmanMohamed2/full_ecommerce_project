<?php
session_start();
require_once '../../functions/functions.php';
require_once '../../functions/validations.php';
require_once '../cat_db_functions/cat_functions.php';


$errors = [];
$success_massage = 'Category Deleted successfully!';


if (checkMethod('GET') && $_SESSION['data']['roll'] == 1) {
    // logo upload path
    define('UPLOAD_LOGO_PATH', "../cat_logos/");
    if (!is_dir(UPLOAD_LOGO_PATH)) {
        mkdir(UPLOAD_LOGO_PATH, "0777");
    }

    // id sanitize and validate
    $id = sanitize($_GET['id']);

    if (empty($id)) {
        $errors[] = "id is missing";
    } elseif (!is_numeric($id)) {
        $errors[] = "invalid id";
    }




    // check for errors
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
    } else {
        $old_logo = deleteCategory($id);
        if ($old_logo) {
            $_SESSION['success'] = $success_massage;
            unlink(UPLOAD_LOGO_PATH . $old_logo);
        } else {
            $errors[] = 'Cant delete this category';
            $_SESSION['errors'] = $errors;
        }
    }

    redirect('../all_cat.php');

    // wrong method
} else {
    $errors['method_error'] = 'wrong method';
    $_SESSION['errors'] = $errors;
    redirect('../panel.php');
}
