<?php

require_once  __DIR__ . '/../../migrations/conn.php';


//#################################################################################
// create new product 
function createOrder($new_order)
{
    $conn = getConnection();
    $sql = "INSERT INTO `orders`(`user_id`, `taxes`, `total_amount`, `delivery`) VALUES (?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iiii", $new_order['user_id'], $new_order['taxes'], $new_order['total_amount'], $new_order['delivery']);
    $result = mysqli_stmt_execute($stmt);

    $product_id = mysqli_insert_id($conn);

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return $product_id;
}
//#################################################################################


//#################################################################################
// create new product 
function moveCartToOrder($cart_item)
{
    $conn = getConnection();
    $sql = "INSERT INTO `cart_order`(`order_id`, `product_id`, `quantity`, `total_price`) VALUES (?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iiii", $cart_item['order_id'], $cart_item['product_id'], $cart_item['quantity'], $cart_item['total_price']);
    mysqli_stmt_execute($stmt);


    $sql = "DELETE FROM `carts` WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $cart_item['item_id']);
    mysqli_stmt_execute($stmt);


    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
//#################################################################################


//#################################################################################
// create new product 
function getAllUsersOrders()
{
    $conn = getConnection();
    $sql = "SELECT o.id AS order_id, o.status AS status_id, o.taxes, o.delivery, o.total_amount, o.user_id, o.time_ordered, u.first_name
    FROM `orders` AS o
    INNER JOIN `users` AS u
    ON u.id = o.user_id
    INNER JOIN `orders_status` AS s
    ON o.status = s.id
    ";
    $result = mysqli_query($conn, $sql);

    mysqli_close($conn);
    return $result;
}
//#################################################################################

//#################################################################################
// create new product 
function getAllStatus()
{
    $conn = getConnection();
    $sql = "SELECT * FROM `orders_status`";
    $result = mysqli_query($conn, $sql);

    mysqli_close($conn);
    $data = [];
    while ($status = mysqli_fetch_assoc($result)) {
        $data[$status['id']] = $status['status'];
    }

    return $data;
}
//#################################################################################


//#################################################################################
// create new product 
function updateOrderStatus($order_id, $status_id)
{
    $conn = getConnection();
    $sql = "UPDATE `orders` SET `status` = ? WHERE `id` = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $status_id, $order_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_affected_rows($stmt);

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    return $result;
}
//#################################################################################


//#################################################################################
// create new product 
function getOrderInfo($order_id, $user_id)
{
    $conn = getConnection();
    $sql = "SELECT 
    o.id, o.taxes, o.total_amount, o.delivery,o.time_ordered, p.name, co.quantity, co.total_price , os.status,o.user_id
    FROM orders AS o
    INNER JOIN 
    cart_order AS co
    ON o.id = co.order_id
    INNER JOIN 
    products AS p
    ON p.id = co.product_id
    INNER JOIN 
    orders_status AS os
    ON o.status = os.id
    WHERE o.id = ? AND o.user_id = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $order_id, $user_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt) ?? false;


    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return ['result' => $result, 'user_id' => $user_id];
}
//#################################################################################


//#################################################################################
// create new product 
function getUserOrders($user_id)
{
    $conn = getConnection();
    $sql = "SELECT o.id AS order_id, o.status AS status_id, o.taxes, o.delivery, o.total_amount, o.time_ordered, s.status
    FROM `orders` AS o
    INNER JOIN `orders_status` AS s
    ON o.status = s.id
    WHERE o.user_id = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);


    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return $result;
}
//#################################################################################
