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
    p.stock AS product_stock, c.name AS category_name, c.logo AS category_logo, c.id AS category_id
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
    p.stock AS product_stock, c.name AS category_name, c.id AS category_id
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
// get sql to filter all products in one category
function filterBy($choose = "def")
{
    $sql = match ($choose) {
        'popular' => "SELECT
                p.id AS product_id,
                p.name AS product_name,
                p.description AS product_description,
                p.price AS product_price,
                PI.img_path AS product_image,
                c.id AS cat_id,
                COUNT(co.id) AS order_count
                FROM `products` AS p

                INNER JOIN `categories` AS c
                ON p.category_id = c.id

                INNER JOIN(
                    SELECT product_id,  MIN(id) AS min_id
                    FROM `product_imgs`
                    GROUP BY  product_id
                ) AS pi_min
                ON p.id = pi_min.product_id
                INNER JOIN `product_imgs` AS PI
                ON pi_min.min_id = PI.id

                LEFT JOIN cart_order AS co
                ON p.id = co.product_id
                GROUP BY co.product_id
                HAVING  cat_id = ?
                ORDER BY order_count DESC",

        'most_ordered' => "SELECT
                p.id AS product_id,
                p.name AS product_name,
                p.description AS product_description,
                p.price AS product_price,
                PI.img_path AS product_image,
                c.id AS cat_id,
                SUM(co.quantity) AS order_count
                FROM `products` AS p

                INNER JOIN `categories` AS c
                ON p.category_id = c.id

                INNER JOIN(
                    SELECT product_id,  MIN(id) AS min_id
                    FROM `product_imgs`
                    GROUP BY  product_id
                ) AS pi_min
                ON p.id = pi_min.product_id
                INNER JOIN `product_imgs` AS PI
                ON pi_min.min_id = PI.id

                LEFT JOIN cart_order AS co
                ON p.id = co.product_id
                GROUP BY co.product_id
                HAVING  cat_id = ?
                ORDER BY order_count DESC",
        'max_min' => "SELECT
                p.id AS product_id,
                p.name AS product_name,
                p.description AS product_description,
                p.price AS product_price,
                PI.img_path AS product_image,
                c.id AS cat_id,
                1 AS order_count
                FROM `products` AS p

                INNER JOIN `categories` AS c
                ON p.category_id = c.id

                INNER JOIN(
                    SELECT product_id,  MIN(id) AS min_id
                    FROM `product_imgs`
                    GROUP BY  product_id
                ) AS pi_min
                ON p.id = pi_min.product_id
                INNER JOIN `product_imgs` AS PI
                ON pi_min.min_id = PI.id

                WHERE p.category_id = ?
                ORDER BY p.price DESC",
        'min_max' => "SELECT
                p.id AS product_id,
                p.name AS product_name,
                p.description AS product_description,
                p.price AS product_price,
                PI.img_path AS product_image,
                c.id AS cat_id,
                1 AS order_count
                FROM `products` AS p

                INNER JOIN `categories` AS c
                ON p.category_id = c.id

                INNER JOIN(
                    SELECT product_id,  MIN(id) AS min_id
                    FROM `product_imgs`
                    GROUP BY  product_id
                ) AS pi_min
                ON p.id = pi_min.product_id
                INNER JOIN `product_imgs` AS PI
                ON pi_min.min_id = PI.id

                WHERE p.category_id = ?
                ORDER BY p.price ASC",
        'recently_added' => "SELECT
                p.id AS product_id,
                p.name AS product_name,
                p.description AS product_description,
                p.price AS product_price,
                PI.img_path AS product_image,
                c.id AS cat_id,
                1 AS order_count
                FROM `products` AS p

                INNER JOIN `categories` AS c
                ON p.category_id = c.id

                INNER JOIN(
                    SELECT product_id,  MIN(id) AS min_id
                    FROM `product_imgs`
                    GROUP BY  product_id
                ) AS pi_min
                ON p.id = pi_min.product_id
                INNER JOIN `product_imgs` AS PI
                ON pi_min.min_id = PI.id

                WHERE p.category_id = ?
                ORDER BY p.id DESC",
        default => "SELECT
                p.id AS product_id,
                p.name AS product_name,
                p.description AS product_description,
                p.price AS product_price,
                PI.img_path AS product_image,
                c.id AS cat_id,
                1 AS order_count
                FROM `products` AS p

                INNER JOIN `categories` AS c
                ON p.category_id = c.id

                INNER JOIN(
                    SELECT product_id,  MIN(id) AS min_id
                    FROM `product_imgs`
                    GROUP BY  product_id
                ) AS pi_min
                ON p.id = pi_min.product_id
                INNER JOIN `product_imgs` AS PI
                ON pi_min.min_id = PI.id

                WHERE p.category_id = ?
                ORDER BY p.id DESC"
    };

    return $sql;
}
//#################################################################################


//#################################################################################
// get all products foreach category 
function categoryProducts($category_id, $filter)
{

    $conn = getConnection();

    // $sql = "SELECT
    // p.id AS product_id, p.name AS product_name, p.description AS product_description, p.price AS product_price, PI.img_path AS product_image,
    //     c.id AS cat_id
    // FROM `products` AS p
    // INNER JOIN `categories` AS c
    // ON p.category_id = c.id

    // INNER JOIN(
    //     SELECT product_id, MIN(id) AS min_id
    //     FROM `product_imgs`
    //     GROUP BY product_id
    // ) AS pi_min
    // ON p.id = pi_min.product_id

    // INNER JOIN `product_imgs` AS PI
    // ON
    // pi_min.min_id = PI.id

    // WHERE c.id = ?";
    $sql = filterBy($filter);

    $data = [];
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $category_id);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_bind_result($stmt, $id, $name, $desc, $price, $product_image, $cat_id, $order_count);
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

//#################################################################################
// update stock on order
function updateOnOrder($product_id, $quantity)
{
    $conn = getConnection();
    $sql = "UPDATE `products` SET `stock` = `stock` - ? WHERE `id` = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $quantity, $product_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_affected_rows($stmt);

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    return $result;
}
//#################################################################################



//#################################################################################
// top Products Foreach Cat
function topProductsForCat($cat_id)
{
    $conn = getConnection();
    $sql = "SELECT p.id AS product_id, p.name AS product_name, p.description AS product_description, p.price AS product_price, PI.img_path AS product_img
    FROM 
        cart_order AS co 
        INNER JOIN products AS p ON co.product_id = p.id
        INNER JOIN (
            SELECT product_id, MIN(id) AS min_id
            FROM `product_imgs`
            GROUP BY product_id
        ) AS pi_min ON p.id = pi_min.product_id
        INNER JOIN `product_imgs` AS PI ON pi_min.min_id = PI.id
    WHERE p.category_id = ?
    GROUP BY co.product_id 
    ORDER BY SUM(quantity) DESC 
    LIMIT 4;";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $cat_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return $result;
}
//#################################################################################


//#################################################################################
// most popular products 
function popularProducts()
{
    $conn = getConnection();
    $sql = "SELECT p.id AS product_id, p.name AS product_name, p.description AS product_description, p.price AS product_price, PI.img_path AS product_img, c.name AS category_name
    FROM 
        cart_order AS co 
        INNER JOIN products AS p ON co.product_id = p.id
        INNER JOIN (
            SELECT product_id, MIN(id) AS min_id
            FROM `product_imgs`
            GROUP BY product_id
        ) AS pi_min ON p.id = pi_min.product_id
        INNER JOIN `product_imgs` AS PI ON pi_min.min_id = PI.id
    INNER JOIN `categories` AS c
    ON p.category_id = c.id
    GROUP BY co.product_id 
    ORDER BY COUNT(*) DESC 
    LIMIT 4;";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return $result;
}
//#################################################################################



//#################################################################################
// searching
function search($value)
{
    $value = '%' . $value . '%';
    $conn = getConnection();
    $sql = "SELECT p.id 
    FROM products AS p
    WHERE p.name LIKE ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $value);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_bind_result($stmt, $id);
    mysqli_stmt_fetch($stmt);

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return $id;
}
//#################################################################################

//#################################################################################
// create review on a product
function review($review_data)
{
    $conn = getConnection();
    $sql = "INSERT INTO `reviews`(`user_id`, `product_id`, `body`) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iis", $review_data['user_id'], $review_data['product_id'], $review_data['review_body']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
//#################################################################################


//#################################################################################
// get product reviews
function getReviews($product_id)
{
    $conn = getConnection();
    $sql = "SELECT 
    r.id AS review_id, r.body AS review_body, r.time_posted AS review_time, u.first_name AS first_name, u.last_name AS last_name, u.id AS user_id
    FROM `reviews` AS r 
    INNER JOIN `users` AS u
    ON u.id = r.user_id
    WHERE `product_id` = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $product_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $reviews = mysqli_fetch_all($result, MYSQLI_ASSOC);


    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return $reviews;
}
//#################################################################################

//#################################################################################
// delete review
function deleteReview($review_id, $user_id = "def")
{
    $conn = getConnection();
    if ($user_id != 'def') {
        $sql = "DELETE FROM `reviews` WHERE `id` = ? AND `user_id` = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $review_id, $user_id);
    } else {
        $sql = "DELETE FROM `reviews` WHERE `id` = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $review_id);
    }

    mysqli_stmt_execute($stmt);

    $result = mysqli_affected_rows($conn);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return $result;
}
//#################################################################################


//#################################################################################
// update review
function updateReview($review_data)
{
    $conn = getConnection();
    $sql = "UPDATE `reviews` SET `body` = ? WHERE `id` = ? AND `user_id` = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sii", $review_data['review_body'], $review_data['review_id'], $review_data['user_id']);

    mysqli_stmt_execute($stmt);
    $result = mysqli_affected_rows($conn);

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return $result;
}
//#################################################################################