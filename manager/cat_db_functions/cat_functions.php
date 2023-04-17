<?php

require_once  __DIR__ . '/../../migrations/conn.php';

//#################################################################################
// create new category 
function createCategory($new_category)
{
    $conn = getConnection();
    $sql = "INSERT INTO `categories`( `name`, `description`, `logo`) VALUES (?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $new_category['cat_name'], $new_category['cat_desc'], $new_category['logo']);
    $result = mysqli_stmt_execute($stmt);


    mysqli_close($conn);
    return $result;
}
//#################################################################################


//#################################################################################
// get all category 
function getAllCat()
{
    $conn = getConnection();
    $sql = "SELECT * FROM `categories`";

    $result = mysqli_query($conn, $sql);


    mysqli_close($conn);
    return $result;
}
//#################################################################################


//#################################################################################
// delete category
function deleteCategory($id)
{
    $conn = getConnection();
    $sql = "SELECT  `logo` FROM `categories` WHERE `id` = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result->num_rows == 0) {
        mysqli_close($conn);
        return false;
    }
    $old_data = mysqli_fetch_assoc($result);
    $old_logo = $old_data['logo'];


    $sql = "DELETE FROM `categories`  WHERE `id` = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result->num_rows == 0) {
        mysqli_close($conn);
        return false;
    }
    mysqli_close($conn);
    return $old_logo;
}
//#################################################################################


//#################################################################################
// get all category 
function getOnaCat($id)
{
    $conn = getConnection();
    $sql = "SELECT  *
    FROM `categories`
    WHERE id = ?";

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
// edit category by super admin
function editCat($all_data)
{
    $id = $all_data['id'];

    $conn = getConnection();
    $sql = "SELECT `logo` FROM `categories` WHERE `id` = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result->num_rows == 0) {
        mysqli_close($conn);
        return false;
    }
    unset($all_data['id']);
    $old_logo = mysqli_fetch_assoc($result)['logo'];

    foreach ($all_data as $key => $data) {

        $sql = "UPDATE `categories` SET $key = ? WHERE `id` = $id";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $data);
        mysqli_stmt_execute($stmt);
    }


    mysqli_close($conn);
    return $old_logo;
}
//#################################################################################