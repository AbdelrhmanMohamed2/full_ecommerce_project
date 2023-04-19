<?php

require_once  __DIR__ . '/../../migrations/conn.php';
//#################################################################################
// create new cart
function addToCart($cart_data)
{
    $conn = getConnection();
    $sql = "INSERT INTO `carts` (`user_id`, `product_id`,`product_name`, `quantity`, `total_price`) VALUES (?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iisii", $cart_data['user_id'], $cart_data['product_id'], $cart_data['product_name'], $cart_data['quantity'], $cart_data['total_price']);
    $result = mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return $result;
}
//#################################################################################


//#################################################################################
// get all product for user cart
function getCartInfo($user_id)
{
    $conn = getConnection();
    $sql = "SELECT c.id, p.name, p.price, p.id AS product_id, c.quantity, c.total_price
    FROM `carts` AS c
    INNER JOIN `products` AS p
    ON c.product_id = p.id
    WHERE `user_id` = ?";

    $data = [];
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_bind_result($stmt, $id, $name, $price,  $product_id, $quantity, $total_price);
    while (mysqli_stmt_fetch($stmt)) {
        $data[$id]['item_id'] = $id;
        $data[$id]['product_name'] = $name;
        $data[$id]['product_id'] = $product_id;
        $data[$id]['product_price'] = $price;
        $data[$id]['quantity'] = $quantity;
        $data[$id]['total_price'] = $total_price;
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);


    return ($data);
}
//#################################################################################


//#################################################################################
// delete Product 
function deleteCartItem($id, $user_id)
{
    $conn = getConnection();

    $sql = "DELETE FROM `carts` WHERE `id` = ? AND `user_id` = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $id, $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_affected_rows($stmt);

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return ($result);
}
//#################################################################################

//#################################################################################
// delete Product 
function deleteCartItems($user_id)
{
    $conn = getConnection();

    $sql = "DELETE FROM `carts` WHERE  `user_id` = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    // $result = mysqli_stmt_affected_rows($stmt);

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    // return ($result);
}
//#################################################################################

//#################################################################################
// get all product for user cart
function getCartItem($item_id)
{
    $conn = getConnection();
    $sql = "SELECT  p.stock, p.price
    FROM `products` AS p
    INNER JOIN `carts` AS c
    ON c.product_id = p.id
    WHERE c.id = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $item_id);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_bind_result($stmt, $stock, $price);
    mysqli_stmt_fetch($stmt);

    mysqli_stmt_close($stmt);
    mysqli_close($conn);


    return ['stock' => $stock, 'price' => $price];
}
//#################################################################################


//#################################################################################
// get all product for user cart
function updateCartItemQty($item_id, $qty, $total_price)
{
    $conn = getConnection();
    $sql = "UPDATE `carts` SET `quantity` = ?, `total_price` = ? WHERE `id` = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iii", $qty, $total_price, $item_id);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
//#################################################################################
