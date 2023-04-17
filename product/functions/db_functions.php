<?php

require_once  __DIR__ . '/../../migrations/conn.php';
require_once 'product_validations.php';

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
// check exists
function checkName($name, $id)
{
    $conn = getConnection();
    $sql = "SELECT `id` FROM `products` WHERE `name` = ? AND `id` != ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "si", $name, $id);
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



//#################################################################################
// get all category 
function getAllProducts()
{
    $conn = getConnection();
    $sql = "SELECT p.id AS product_id, p.name AS product_name, p.description AS product_description, p.price AS product_price,
    p.stock AS product_stock, c.name AS category_name, c.logo AS category_logo
    FROM `products` AS p
    INNER JOIN `categories` AS c
    ON p.category_id = c.id
    ";

    $result = mysqli_query($conn, $sql);


    mysqli_close($conn);
    return ($result);
}
//#################################################################################


//#################################################################################
// get all category 
function getProductInfo($id)
{
    $conn = getConnection();
    $sql = "SELECT p.id AS product_id, p.name AS product_name, p.description AS product_description, p.price AS product_price,
    p.stock AS product_stock, c.name AS category_name
    FROM `products` AS p
    INNER JOIN `categories` AS c
    ON p.category_id = c.id
    WHERE p.id = ?
    ";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    mysqli_close($conn);
    return mysqli_fetch_assoc($result);
}
//#################################################################################

//#################################################################################
// get all category 
function getProductImgs($id)
{
    $data = [];
    $conn = getConnection();
    $sql = "SELECT `img_path` FROM `product_imgs` WHERE `product_id` = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_bind_result($stmt, $path);
    while (mysqli_stmt_fetch($stmt)) {
        $data[] = $path;
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    // die;
    return ($data);
}
//#################################################################################

//#################################################################################
// get all category 
function deleteAllImgs($id)
{
    $all_product_img = getProductImgs($id);
    deleteAllProductImgs($all_product_img);

    $conn = getConnection();

    $sql = "DELETE FROM `product_imgs` WHERE `product_id` = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
//#################################################################################

//#################################################################################
// get all category 
function deleteProduct($id)
{
    deleteAllImgs($id);

    $conn = getConnection();

    $sql = "DELETE FROM `products` WHERE `id` = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
//#################################################################################


//#################################################################################
// get all category 
function UpdateProduct($all_new_data)
{

    $conn = getConnection();
    $id = $all_new_data['id'];
    unset($all_new_data['id']);
    foreach ($all_new_data as $col => $value) {
        $sql = "UPDATE `products` SET `$col` = ? WHERE `id` = ? ";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "si", $value, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }


    mysqli_close($conn);
}
//#################################################################################
