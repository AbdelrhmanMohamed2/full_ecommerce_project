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
// check name exists for edit
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
// create new product 
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
// insert imgs of a product
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
// get all products 
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
// get all product info 
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
// get all product img 
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
//  delete All Imgs of a product
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
// delete Product 
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
// Update Product 
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


//#################################################################################
// Update Product 
function categoryProducts($category_id)
{

    $conn = getConnection();

    $sql = "SELECT
    p.id AS product_id, p.name AS product_name, p.description AS product_description, p.price AS product_price, PI.img_path AS product_image
    FROM `products` AS p
    INNER JOIN `categories` AS c
    ON p.category_id = c.id

    INNER JOIN(
        SELECT product_id, MIN(id) AS min_id
        FROM `product_imgs`
        GROUP BY product_id
    ) AS pi_min
    ON p.id = pi_min.product_id

    INNER JOIN `product_imgs` AS PI
    ON
    pi_min.min_id = PI.id

    WHERE c.id = ?";
    $data = [];
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $category_id);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_bind_result($stmt, $id, $name, $desc, $price, $product_image);
    while (mysqli_stmt_fetch($stmt)) {
        $data[$id]['product_id'] = $id;
        $data[$id]['product_name'] = $name;
        $data[$id]['product_description'] = $desc;
        $data[$id]['product_price'] = $price;
        $data[$id]['product_image'] = $product_image;
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);


    return ($data);
}
//#################################################################################

// //#################################################################################
// // check name exists for edit
// function checkQty($qty, $id)
// {
//     $conn = getConnection();
//     $sql = "SELECT `stock` FROM `products` WHERE  `id` = ?";

//     $stmt = mysqli_prepare($conn, $sql);
//     mysqli_stmt_bind_param($stmt, "i", $id);
//     mysqli_stmt_execute($stmt);

//     mysqli_stmt_bind_result($stmt, $stock);
//     mysqli_stmt_fetch($stmt);

//     mysqli_stmt_close($stmt);
//     mysqli_close($conn);

//     return $stock < $qty;
// }
// //#################################################################################