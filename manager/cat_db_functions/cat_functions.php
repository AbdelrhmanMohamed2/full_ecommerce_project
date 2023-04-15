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
