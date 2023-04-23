<?php

require_once  __DIR__ . '/../../migrations/conn.php';

//#################################################################################
// statistics on users 
function getUsersCount()
{
    $conn = getConnection();
    $sql = "SELECT 
    (SELECT COUNT(*) FROM users ) AS all_users,
    (SELECT COUNT(*) FROM users WHERE roll = 1) AS super_admin_count,
    (SELECT COUNT(*) FROM users WHERE roll = 2) AS admin_count,
    (SELECT COUNT(*) FROM users WHERE roll = 3) AS user_count;";

    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
//#################################################################################


//#################################################################################
// statistics on users 
function getCategoryStatistics()
{
    $conn = getConnection();
    $sql = "SELECT 
    (SELECT COUNT(*) AS main_counter FROM categories) AS category_count,
    c.name AS category_name,
    COUNT(p.id) AS product_count
    FROM 
        categories c
        LEFT JOIN products p ON c.id = p.category_id
    GROUP BY 
        c.id;";

    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
//#################################################################################


//#################################################################################
// statistics on users 
function ordersProductsStatistics()
{
    $conn = getConnection();
    $sql = "SELECT 
    (SELECT COUNT(*) FROM products  WHERE products.stock > 0) AS products_in_stock,
    (SELECT COUNT(*) FROM products  WHERE products.stock = 0) AS products_out_of_stock,
    (SELECT COUNT(DISTINCT product_id) FROM cart_order) AS product_ordered,
    (SELECT SUM(total_price) FROM cart_order) AS total_price,
    (SELECT SUM(quantity) FROM cart_order) AS count_quantity;";

    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
//#################################################################################