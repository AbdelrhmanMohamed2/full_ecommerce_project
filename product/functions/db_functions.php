<?php

require_once  __DIR__ . '/../../migrations/conn.php';

//#################################################################################
// check exists
function checkExists($value, $column,  $table)
{
    $conn = getConnection();
    $sql = "SELECT `id` FROM $table WHERE $column = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $value);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return $result;
}
//#################################################################################


//#################################################################################
// create new category 
function createProduct($new_product)
{
    $conn = getConnection();
    $sql = "INSERT INTO `products`( `name`, `description`, `category_id`, `price`, `stock`) VALUES (?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssiii", $new_product['name'], $new_product['description'], $new_product['category'], $new_product['price'], $new_product['stock']);
    $result = mysqli_stmt_execute($stmt);

    $product_id = mysqli_insert_id($conn);
    insertImgs($new_product['imgs'], $product_id);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return $result;
}
//#################################################################################


//#################################################################################
// create new category 
function insertImgs($imgs, $product_id)
{
    $conn = getConnection();
    $sql = "INSERT INTO `product_imgs`( `product_id`, `img_path`) VALUES (?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    foreach ($imgs as $img) {

        mysqli_stmt_bind_param($stmt, "is", $product_id,  $img);
        mysqli_stmt_execute($stmt);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
//#################################################################################
