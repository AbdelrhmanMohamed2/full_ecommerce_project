<?php
session_start();
require_once '../../functions/functions.php';
require_once '../../functions/validations.php';
require_once '../functions/db_functions.php';


$errors = [];
$success_massage = 'Review Deleted successfully!';


if (checkMethod('GET') && isset($_SESSION['data'])) {
    define('UPLOAD_IMG_PATH', "../imgs/");

    // data 
    $review_id = sanitize($_GET['review_id']);

    // id sanitize and validate
    if (empty($review_id)) {
        $errors[] = 'review id is missing';
    } elseif (!is_numeric($review_id)) {
        $errors[] = 'invalid review id';
    } else {
        if ($_SESSION['data']['roll'] == 1) {
            $result = deleteReview($review_id);
        } else {
            $result = deleteReview($review_id, $_SESSION['data']['id']);
        }

        if ($result != 1) {
            $errors[] = 'cant delete this review';
        }
    }




    // check for errors
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
    } else {
        $_SESSION['success'] = $success_massage;
    }

    redirect($_SERVER['HTTP_REFERER']);

    // wrong method
} else {
    $errors['method_error'] = 'wrong method';
    $_SESSION['errors'] = $errors;
    redirect('../panel.php');
}
