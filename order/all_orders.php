<?php require_once '../inc/header.php'; ?>
<?php
require_once  ROOT . 'functions/functions.php';
if (!isset($_SESSION['data'])) {
    redirect('user/login.php');
} elseif ($_SESSION['data']['roll'] != 1) {
    redirect('../user/profile.php');
}
require_once  ROOT . 'inc/nav.php';
require_once   'functions/db_functions.php';

$result = getAllUsersOrders();
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
                        <th scope="col">user name</th>
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
                            <td><a href="<?= URL ?>manager/update_acc.php?id=<?= $order['user_id'] ?>"><?= $order['first_name'] ?></a> </td>
                            <td><?= $order['total_amount'] ?></td>
                            <td><?= $order['time_ordered'] ?></td>
                            <td>
                                <form method="POST" action="handlers/update_status.php">
                                    <div class="mb-3">
                                        <select class="form-select" name="status_id" aria-label="Default select example">

                                            <?php foreach ($status_result as $key => $status) :  ?>
                                                <option value="<?= $key ?>" <?php if ($key == $order['status_id']) : ?> selected class="text-info" <?php endif ?>><?= $status ?> </option>
                                            <?php endforeach ?>

                                        </select>
                                    </div>
                                    <input type="number" hidden value="<?= $order['order_id'] ?>" name="order_id">

                                    <button type="submit" class="btn btn-success">Save</button>
                                </form>
                            </td>
                            <td><a href="order_details.php?id=<?= $order['order_id'] ?>&user_id=<?= $order['user_id'] ?>" class="btn btn-info">show</a> </td>
                        </tr>
                    <?php endwhile ?>

                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require_once  ROOT . 'inc/footer.php'; ?>