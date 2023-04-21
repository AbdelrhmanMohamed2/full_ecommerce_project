<?php

require_once  __DIR__ . '/../../migrations/conn.php';
//#################################################################################
// create new wishlist item
function addToWishList($list_data)
{
    $conn = getConnection();
    $sql = "INSERT INTO `wishList` (`user_id`, `product_id`,`product_name`) VALUES (?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iis", $list_data['user_id'], $list_data['product_id'], $list_data['product_name']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_affected_rows($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return ($result);
}
//#################################################################################

//#################################################################################
// get all product for user wishlist
function getWishListInfo($user_id)
{
    $conn = getConnection();
    $sql = "SELECT wl.id AS item_id, p.name AS product_name, p.id AS product_id
    FROM `wishList` AS wl
    INNER JOIN `products` AS p
    ON wl.product_id = p.id
    WHERE `user_id` = ?";

    $data = [];
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_bind_result($stmt, $wishlist_id, $product_name, $product_id);
    while (mysqli_stmt_fetch($stmt)) {
        $data[$wishlist_id]['wishlist_id'] = $wishlist_id;
        $data[$wishlist_id]['product_name'] = $product_name;
        $data[$wishlist_id]['product_id'] = $product_id;
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);


    return ($data);
}
//#################################################################################

//#################################################################################
// delete one Product from wishlist
function deleteWishListItem($item_id, $user_id)
{
    $conn = getConnection();

    $sql = "DELETE FROM `wishList` WHERE `id` = ? AND `user_id` = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $item_id, $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_affected_rows($stmt);

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return ($result);
}
//#################################################################################

//#################################################################################
// delete all Product from wish list
function deleteWishList($user_id)
{
    $conn = getConnection();

    $sql = "DELETE FROM `wishList` WHERE  `user_id` = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    // $result = mysqli_stmt_affected_rows($stmt);

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    // return ($result);
}
//#################################################################################