<?php
session_start();
require_once '../../functions/functions.php';
require_once '../../functions/validations.php';
require_once '../functions/db_functions.php';

$errors = [];
$success_massage = 'review Updated successfully';
$review_data = [];

if (checkMethod('POST') && isset($_SESSION['data'])) {


    // name length
    define('MAX_REVIEW_SIZE', 45);
    define('MIN_REVIEW_SIZE', 2);

    // data 
    $review = sanitize($_POST['review']);
    $review_id = sanitize($_POST['review_id']);

    // review validations
    if (empty($review)) {
        $errors[] = 'review is required';
    } elseif (is_numeric($review)) {
        $errors[] = 'review must be string';
    } elseif (maxInputSize($review, MAX_REVIEW_SIZE)) {
        $errors[] = 'review is too large, max = ' . MAX_REVIEW_SIZE;
    } elseif (minInputSize($review, MIN_NAME_SIZE)) {
        $errors[] = 'review is too small, min = ' . MIN_REVIEW_SIZE;
    } else {
        $review_data['review_body'] = $review;
    }

    // review id validations
    if (empty($review_id)) {
        $errors[] = 'review id is missing';
    } elseif (!is_numeric($review_id)) {
        $errors[] = 'review id must be a number';
    } elseif (!checkExists($review_id, 'id',  'reviews')) {
        $errors[] = 'review not exists';
    } else {
        $review_data['review_id'] = $review_id;
    }





    // check for errors
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
    } else {
        $review_data['user_id'] = $_SESSION['data']['id'];
        if (updateReview($review_data)  == 1) {
            $_SESSION['success'] = $success_massage;
        } else {
            $errors[] = 'error updating review';
            $_SESSION['errors'] = $errors;
        }
    }
    redirect($_SERVER['HTTP_REFERER']);


    // wrong method
} else {
    $errors['method_error'] = 'wrong method';
    $_SESSION['errors'] = $errors;
    redirect('../../manager/panel.php');
}
