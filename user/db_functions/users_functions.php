<?php

require_once  __DIR__ . '/../../migrations/conn.php';

//#################################################################################
// create new user 
function register($new_user)
{
    $conn = getConnection();
    $sql = "INSERT INTO `users` (`first_name`, `last_name`, `email`, `password`, `img`, `roll`) VALUES
    (?, ?, ?, ?, ?, 3)";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssss", $new_user['f_name'], $new_user['l_name'], $new_user['email'], $new_user['password'], $new_user['img']);
    $result = mysqli_stmt_execute($stmt);


    mysqli_close($conn);
    return $result;
}
//#################################################################################


//#################################################################################
// create new user 
function login($email, $pass)
{
    $conn = getConnection();
    $sql = "SELECT * FROM `users` WHERE `email` = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $data = mysqli_fetch_assoc($result);
    mysqli_close($conn);

    if ($data['password'] == $pass) {
        return  $data;
    }

    return false;
}
//#################################################################################


//#################################################################################
// update user img
function updateImg($new_img, $email)
{
    $conn = getConnection();
    $sql = "SELECT `img` FROM `users` WHERE `email` = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result->num_rows == 0) {
        mysqli_close($conn);
        return false;
    }
    $old_img_name = mysqli_fetch_assoc($result)['img'];

    $sql = "UPDATE `users` SET `img` = ? WHERE `email` = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $new_img, $email);

    mysqli_stmt_execute($stmt);
    mysqli_close($conn);

    return $old_img_name;
}
//#################################################################################



//#################################################################################
// update user img
function updatePassword($old_password, $password, $email)
{
    $conn = getConnection();
    $sql = "SELECT `password` FROM `users` WHERE `email` = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result->num_rows == 0) {
        mysqli_close($conn);
        return false;
    }
    $old_data_password = mysqli_fetch_assoc($result)['password'];
    if ($old_data_password != $old_password) {
        mysqli_close($conn);
        return false;
    }

    $sql = "UPDATE `users` SET `password` = ? WHERE `email` = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $password, $email);

    mysqli_stmt_execute($stmt);
    mysqli_close($conn);

    return true;
}
//#################################################################################


//#################################################################################
// update user img
function deleteAccount($password, $email)
{
    $conn = getConnection();
    $sql = "SELECT `password` FROM `users` WHERE `email` = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result->num_rows == 0) {
        mysqli_close($conn);
        return false;
    }
    $old_data_password = mysqli_fetch_assoc($result)['password'];
    if ($old_data_password != $password) {
        mysqli_close($conn);
        return false;
    }

    $sql = "DELETE FROM `users`  WHERE `email` = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);

    mysqli_stmt_execute($stmt);
    mysqli_close($conn);
    return true;
}
//#################################################################################
