<?php
// session_start();
require_once '../../inc/url.php';
require_once '../../functions/functions.php';
require_once '../../functions/validations.php';

require_once '../functions/db_functions.php';
// require_once '../../cart/cart_functions/cart_functions.php';
require_once '../../product/functions/db_functions.php';

$errors = [];
$success_massage = 'Order Printed successfully';


if (checkMethod('GET') && isset($_GET['id'])) {

    // define('test_file', URL . 'order/handlers/file/');
    define('test_file', __DIR__ . '/file/');

    $order_id = sanitize($_GET['id']);
    //  validations
    if (empty($order_id)) {
        $errors[] = 'order id is missing';
    } elseif (!is_numeric($order_id)) {
        $errors[] = 'order id must be number';
    } elseif ($order_id < 0) {
        $errors[] = 'order id must be positive number';
    } else {


        $order_details = getOrderInfo($_GET['id'], $_SESSION['data']['id']);

        if (mysqli_num_rows($order_details['result']) == 0) {
            $errors[] = "order not exists";
        } else {

            $file_name =  uniqid('', true) . '.txt';
            $file = "../file/" . $file_name;
            $file_stream = fopen($file, 'w');
            $i = 0;
            $total_products_prices = 0;
            $data = [];

            fwrite($file_stream, "####################################################################\n################# Welcome to " . SITE_NAME . " #########################\n####################################################################\n###################### ORDER DETAILS ###############################\n####################################################################\n########## N ####### product_name # quantity # total amount ########\n####################################################################\n");

            while ($order_product = mysqli_fetch_assoc($order_details['result'])) {
                $product_details = getProductInfo($order_product['product_id']);
                if ($i == 0) {

                    $data['total_amount'] = $order_product['total_amount'];
                    $data['time_ordered'] = $order_product['time_ordered'];
                    $data['taxes'] = $order_product['taxes'];
                    $data['delivery'] = $order_product['delivery'];
                    $data['status'] = $order_product['status'];
                }
                $i += 1;
                $total_amount = ($product_details['product_price'] * $order_product['quantity']);
                $total_products_prices += $total_amount;

                if (!$product_details) {
                    $errors[] = "product not exists anymore";
                } else {
                    fwrite($file_stream, "** Product $i Details : {{$product_details['product_name']} , {$order_product['quantity']}, {$total_amount}}\n");
                }
            }

            $total_amount = $total_products_prices + $data['taxes'] + $data['delivery'];
            $t = time();
            date_default_timezone_set('Africa/Cairo');
            $now_date =  (date("Y-m-d H:i:s", $t));


            fwrite($file_stream, "####################################################################\n");
            fwrite($file_stream, "-- Total Products Prices : {$total_products_prices}\n");
            fwrite($file_stream, "-- Time Ordered : {$data['time_ordered']}\n");
            fwrite($file_stream, "-- Taxes : {$data['taxes']}\n");
            fwrite($file_stream, "-- Delivery : {$data['delivery']}\n");
            fwrite($file_stream, "-- Total Amount : {$total_amount}\n");
            fwrite($file_stream, "-- Order Status : {$data['status']}\n");
            fwrite($file_stream, "####################################################################\n");
            fwrite($file_stream, "** User Name :  {$_SESSION['data']['first_name']} {$_SESSION['data']['last_name']}\n");
            fwrite($file_stream, "** User Address :  {$_SESSION['data']['address']}\n");
            fwrite($file_stream, "** User Phone :  {$_SESSION['data']['phone_number']}\n");
            fwrite($file_stream, "####################################################################\n");
            fwrite($file_stream, "$$$$$$ Thank You for Using " . SITE_NAME . " : {$now_date} $$$$$\n");
            fwrite($file_stream, "####################################################################\n");
            fclose($file_stream);

            header('Content-Disposition: attachment; filename="' . basename($file) . '"');
            readfile($file);
            unlink($file);
            exit;

            echo '<script>window.location.href="' . $_SERVER['HTTP_REFERER'] . '";</script>';
            // echo '<script>window.location.href="' . URL . 'order/order_details.php?id=' . $order_id . '";</script>';
        }
    }




    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        // redirect(URL . 'order/order_details.php?id=' . $order_id);
    }

    // wrong method
} else {
    $errors['method_error'] = 'wrong method';
    $_SESSION['errors'] = $errors;
    redirect('../../index.php');
}
