<?php
// consts
// name length
define('MAX_NAME_SIZE', 15);
define('MIN_NAME_SIZE', 2);

// password length
define('MAX_PASSWORD_SIZE', 20);
define('MIN_PASSWORD_SIZE', 6);

// img size
define('MAX_IMG_SIZE', 5000000);
define('MIN_IMG_SIZE', 1000);





// DATA
// data sanitize
$f_name = sanitize($_POST['f_name']);
$l_name = sanitize($_POST['l_name']);
$email = sanitize($_POST['email']);
$password = sanitize($_POST['password']);
$con_password = sanitize($_POST['con_password']);


// data validations
// first name validations
if (empty($f_name)) {
    $errors[] = 'first name is required';
} elseif (is_numeric($f_name)) {
    $errors[] = 'first name must be string';
} elseif (maxInputSize($f_name, MAX_NAME_SIZE)) {
    $errors[] = 'first name must is too larg, max = ' . MAX_NAME_SIZE;
} elseif (minInputSize($f_name, MIN_NAME_SIZE)) {
    $errors[] = 'first name must is too small, min = ' . MIN_NAME_SIZE;
} else {
    $users_data['f_name'] = $f_name;
}

// last name validations
if (empty($l_name)) {
    $errors[] = 'last name is required';
} elseif (is_numeric($l_name)) {
    $errors[] = 'last name must be string';
} elseif (maxInputSize($l_name, MAX_NAME_SIZE)) {
    $errors[] = 'last name must is too larg, max = ' . MAX_NAME_SIZE;
} elseif (minInputSize($l_name, MIN_NAME_SIZE)) {
    $errors[] = 'last name must is too small, min = ' . MIN_NAME_SIZE;
} else {
    $users_data['l_name'] = $l_name;
}

// email validations
if (empty($email)) {
    $errors[] = 'email is required';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'email not valid';
} else {
    $users_data['email'] = $email;
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
} else {
    $users_data['password'] = $password;
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
            $users_data['img'] = $new_img_name;
        }
    }
} else {
    $errors[] = 'img is required';
}
