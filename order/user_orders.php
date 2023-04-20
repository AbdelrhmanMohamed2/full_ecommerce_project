<?php require_once '../inc/header.php'; ?>
<?php
require_once  ROOT . 'functions/functions.php';
if (!isset($_SESSION['data'])) {
    redirect('user/login.php');
}
require_once  ROOT . 'inc/nav.php';
require_once   'functions/db_functions.php';

$result = getUserOrders($_SESSION['data']['id']);
$status_result = getAllStatus();

?>

<div class="container">
    <div class="row">
        <div class="col-12 my-5">
            <h1>All Users Orders : </h1>
            <hr>
            <?php require_once '../inc/show_mass.php'; ?>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#order id</th>
                        <th scope="col">total amount</th>
                        <th scope="col">time ordered</th>
                        <th scope="col">status</th>
                        <td>show details</td>

                    </tr>
                </thead>
                <tbody>
                    <?php while ($order = mysqli_fetch_assoc($result)) :  ?>
                        <tr>
                            <td><?= $order['order_id'] ?></td>
                            <td><?= $order['total_amount'] ?></td>
                            <td><?= $order['time_ordered'] ?></td>
                            <td><?= $order['status'] ?></td>
                            <td><a href="order_details.php?id=<?= $order['order_id'] ?>" class="btn btn-info">show</a> </td>
                        </tr>
                    <?php endwhile ?>

                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require_once  ROOT . 'inc/footer.php'; ?>