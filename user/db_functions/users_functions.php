<?php

require_once  __DIR__ . '/../../migrations/conn.php';

//#################################################################################
// create new user 
function register($new_user)
{
    $conn = getConnection();
    $sql = "INSERT INTO `users` (`first_name`, `last_name`, `email`, `password`, `img`, `roll`) VALUES
    (?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);
    $roll = ($new_user['roll'] ?? 3);
    mysqli_stmt_bind_param($stmt, "sssssi", $new_user['f_name'], $new_user['l_name'], $new_user['email'], $new_user['password'], $new_user['img'], $roll);
    $result = mysqli_stmt_execute($stmt);


    mysqli_close($conn);
    return $result;
}
//#################################################################################


//#################################################################################
// get all rolls
function getAllRolls()
{

    $conn = getConnection();
    $sql = "SELECT * FROM `rolls`";
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
    return $result;
}
//#################################################################################

//#################################################################################
// get all rolls
function checkRollExists($id)
{

    $result = getAllRolls();
    while ($roll = mysqli_fetch_assoc($result)) {
        if ($roll['id'] == $id) {
            return true;
        }
    }
    return false;
}
//#################################################################################


//#################################################################################
// login
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
// update user password
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
// delete users account
function deleteAccount($password, $id, $roll)
{
    $conn = getConnection();
    $sql = "SELECT `password`, `img` FROM `users` WHERE `id` = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $id);

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result->num_rows == 0) {
        mysqli_close($conn);
        return false;
    }
    $old_data = mysqli_fetch_assoc($result);
    $old_img = $old_data['img'];
    $old_pass = $old_data['password'];

    if ($old_pass != $password && $roll == 3) {
        mysqli_close($conn);
        return false;
    }


    $sql = "DELETE FROM `users`  WHERE `id` = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $id);

    mysqli_stmt_execute($stmt);
    mysqli_close($conn);
    return $old_img;
}
//#################################################################################


//#################################################################################
// get all users
function getAllUsers()
{
    $conn = getConnection();
    $sql = "SELECT  u.id AS user_id, u.first_name, u.last_name, u.img, u.email, r.name AS roll_name
    FROM `users` AS u
    INNER JOIN `rolls` AS r 
    ON u.roll = r.id ";
    $result = mysqli_query($conn, $sql);

    mysqli_close($conn);
    return $result;
}
//#################################################################################


//#################################################################################
// get user info
function getUserInfo($id)
{
    $conn = getConnection();
    $sql = "SELECT  *
    FROM `users` AS u
    WHERE u.id = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result->num_rows == 0) {
        mysqli_close($conn);
        return false;
    }

    mysqli_close($conn);
    return mysqli_fetch_assoc($result);
}
//#################################################################################

//#################################################################################
// edit user by super admin
function editUser($all_data, $roll)
{
    $id = $all_data['id'];

    $conn = getConnection();
    $sql = "SELECT `img` FROM `users` WHERE `id` = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result->num_rows == 0 || $roll != 1) {
        mysqli_close($conn);
        return false;
    }
    unset($all_data['id']);
    $old_img = mysqli_fetch_assoc($result)['img'];

    foreach ($all_data as $key => $data) {

        $sql = "UPDATE `users` SET $key = ? WHERE `id` = $id";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $data);
        mysqli_stmt_execute($stmt);
    }


    mysqli_close($conn);
    return $old_img;
}
//#################################################################################