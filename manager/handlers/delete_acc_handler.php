<?php
session_start();
require_once '../../functions/functions.php';
require_once '../../functions/validations.php';
require_once '../../user/db_functions/users_functions.php';


$errors = [];
$success_massage = 'account Deleted successfully!';


if (checkMethod('GET') && $_SESSION['data']['roll'] == 1) {
    // img upload path
    define('UPLOAD_IMG_PATH', "../../user/imgs/");
    if (!is_dir(UPLOAD_IMG_PATH)) {
        mkdir(UPLOAD_IMG_PATH, "0777");
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
        $old_img = deleteAccount("admin", $id, $_SESSION['data']['roll']);
        if ($old_img) {
            $_SESSION['success'] = $success_massage;
            unlink(UPLOAD_IMG_PATH . $old_img);
        } else {
            $errors[] = 'Cant delete the account';
            $_SESSION['errors'] = $errors;
        }
    }
    if ($id == $_SESSION['data']['id']) {

        redirect('../../user/logout.php');
    }
    redirect('../all_users.php');

    // wrong method
} else {
    $errors['method_error'] = 'wrong method';
    $_SESSION['errors'] = $errors;
    redirect('../panel.php');
}
