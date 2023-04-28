<?php require_once '../inc/header.php';
require_once ROOT . 'functions/functions.php';
if (!isset($_SESSION['data'])) {
    redirect(URL);
}
require_once  'functions/db_functions.php';
$total_product_price = 0;
$data = [];
$user_id = $_GET['user_id'] ?? $_SESSION['data']['id'];
$order_details = getOrderInfo($_GET['id'], $user_id);

if (mysqli_num_rows($order_details['result']) == 0) {
    redirect(URL);
} elseif (($order_details['user_id'] != $_SESSION['data']['id']) && ($_SESSION['data']['roll'] > 2)) {
    redirect(URL);
}
require_once ROOT . 'inc/nav.php';


?>

<div class="container">
    <?php require_once ROOT . 'inc/show_mass.php'; ?>
    <div class="row my-5">
        <div class="col-6">
            <h1>Order Details : </h1>


            <hr>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Product name</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($order_details['result'])) : ?>
                        <tr>
                            <td><?= $row['name'] ?></td>
                            <td><?= $row['quantity'] ?></td>
                            <td><?= $row['total_price'] ?></td>
                        </tr>
                        <?php if ($total_product_price == 0) {

                            $data['total_amount'] = $row['total_amount'];
                            $data['time_ordered'] = $row['time_ordered'];
                            $data['taxes'] = $row['taxes'];
                            $data['delivery'] = $row['delivery'];
                            $data['status'] = $row['status'];
                        }
                        $total_product_price += $row['total_price'];
                        ?>
                    <?php
                    endwhile ?>
                </tbody>
            </table>
            <hr>
            <ul class="list-group">
                <li class="list-group-item">Total Products Prices : <?= $total_product_price ?> </li>
                <li class="list-group-item">Time Ordered : <?= $data['time_ordered'] ?> </li>
                <li class="list-group-item">Taxes : <?= $data['taxes'] ?></li>
                <li class="list-group-item">Delivery : <?= $data['delivery'] ?></li>
                <li class="list-group-item text-primary">Total Amount : <?= $data['total_amount'] ?></li>
                <li class="list-group-item text-primary">Order Status : <?= $data['status'] ?> </li>
            </ul>
            <?php if (!isset($_GET['user_id'])) : ?>
                <a href="handlers/same_order.php?id=<?= $_GET['id'] ?>" class="btn btn-primary my-3">Order The Same Order Again?</a>
                <a href="handlers/print_order.php?id=<?= $_GET['id'] ?>" class="btn btn-success m-3">Print Order Details</a>
            <?php endif ?>
        </div>
    </div>
</div>
<?php require_once ROOT . 'inc/footer.php'; ?>