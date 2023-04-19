<?php
// require_once '../../functions/validations.php';
// const
// img upload path


// name length
define('MAX_NAME_SIZE', 15);
define('MIN_NAME_SIZE', 2);

// description length
define('MAX_DESC_SIZE', 30);
define('MIN_DESC_SIZE', 5);

// LOGO size
define('MAX_IMG_SIZE', 5000000);
define('MIN_IMG_SIZE', 1000);

// ######################################################################
// product name validations 
function validateProductName($pro_name)
{
    // sanitize 
    $pro_name = sanitize($pro_name);
    $error = '';

    // product name validations
    if (empty($pro_name)) {
        $error = 'product name is required';
    } elseif (is_numeric($pro_name)) {
        $error = 'product name must be string';
    } elseif (maxInputSize($pro_name, MAX_NAME_SIZE)) {
        $error = 'product name is too larg, max = ' . MAX_NAME_SIZE;
    } elseif (minInputSize($pro_name, MIN_NAME_SIZE)) {
        $error = 'product name is too small, min = ' . MIN_NAME_SIZE;
    }
    return ['error' => $error, 'value' => $pro_name];
}
// ######################################################################


// ######################################################################
// product description validations
function validateProductDescription($pro_desc)
{
    // sanitize 
    $pro_desc = sanitize($pro_desc);
    $error = '';
    // category description validations
    if (empty($pro_desc)) {
        $error = 'product description is required';
    } elseif (is_numeric($pro_desc)) {
        $error = 'product description must be string';
    } elseif (maxInputSize($pro_desc, MAX_DESC_SIZE)) {
        $error = 'product description  is too larg, max = ' . MAX_DESC_SIZE;
    } elseif (minInputSize($pro_desc, MIN_NAME_SIZE)) {
        $error = 'product description  is too small, min = ' . MIN_DESC_SIZE;
    }

    return ['error' => $error, 'value' => $pro_desc];
}
// ######################################################################


// ######################################################################
// product price || stock numbers validations
function validateProductNumbers($pro_num, $num_name)
{
    // sanitize 
    $pro_num = sanitize($pro_num);
    $error = '';

    //  validations
    if (empty($pro_num)) {
        $error = 'product ' . $num_name . ' is required';
    } elseif (!is_numeric($pro_num)) {
        $error = 'product ' . $num_name . ' must be number';
    } elseif ($pro_num < 0) {
        $error = 'product ' . $num_name . ' must be positive number';
    }

    return ['error' => $error, 'value' => $pro_num];
}
// ######################################################################


// ######################################################################
// product description validations
function validateProductImgs($pro_imgs)
{
    $allowed_img_types = ['image/png', 'image/jpeg'];
    $imgs_new_path = [];
    $error = '';

    if ($pro_imgs['name'][0] == '') {
        $error = 'product img required';
    } else {

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        foreach ($pro_imgs['tmp_name'] as $key => $value) {
            $mime_type = finfo_file($finfo, $value);
            $img_size = filesize($value);

            if ($pro_imgs['error'][$key] > 0) {
                $error = 'error uploading imgs';
            } elseif ($img_size > MAX_IMG_SIZE) {
                $error = 'img is too big max size = ' . MAX_IMG_SIZE;
            } elseif ($img_size < MIN_IMG_SIZE) {
                $error = 'img is too small min size = ' . MIN_IMG_SIZE;
            } elseif (!in_array($mime_type, $allowed_img_types)) {
                $error = 'invalid img type';
            } else {
                $extension = pathinfo($pro_imgs['name'][$key], PATHINFO_EXTENSION);

                $img_new_name = uniqid('', true) . "." . $extension;
                $imgs_new_path[] = $img_new_name;

                $new_path = UPLOAD_IMG_PATH . $img_new_name;

                move_uploaded_file($value, $new_path);
            }
        }
        finfo_close($finfo);
    }
    if (!empty($error)) {
        deleteAllProductImgs($imgs_new_path);
    }
    return ['error' => $error, 'value' => $imgs_new_path];
}
// ######################################################################

// ######################################################################
// delete all imgs if any error 
function deleteAllProductImgs($imgs_path)
{
    foreach ($imgs_path as $img_path) {
        unlink(UPLOAD_IMG_PATH . $img_path);
    }
}
// ######################################################################
