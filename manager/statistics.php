<?php require_once '../inc/header.php'; ?>
<?php
require_once  ROOT . 'functions/functions.php';

if (!isset($_SESSION['data'])) {
    redirect(URL . 'user/login.php');
} elseif ($_SESSION['data']['roll'] != 1) {
    redirect(URL . 'user/profile.php');
}
require_once  ROOT . 'inc/nav.php';

require_once  ROOT . 'manager/statistics/db_functions.php';


?>

<div class="container">
    <div class="row">
        <div class="col-12 my-5">
            <h1>WebSite Statistics</h1>
            <hr>

            <table class="table">
                <?php $users_data = getUsersCount()[0];
                ?>
                <h3>Users (<?= $users_data['all_users'] ?>)</h3>
                <hr>
                <thead>
                    <tr>

                        <th>#</th>
                        <th>Roll</th>
                        <th>count</th>

                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Super Admin</td>
                        <td><?= $users_data['super_admin_count'] ?></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Admin</td>
                        <td><?= $users_data['admin_count'] ?></td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Users</td>
                        <td><?= $users_data['user_count'] ?></td>
                    </tr>

                </tbody>
            </table>

            <hr>
            <table class="table">
                <?php $category_statistics = getCategoryStatistics();
                $i = 1 ?>
                <h3>Categories (<?= count($category_statistics) ?>) </h3>
                <hr>
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Category Name</th>
                        <th scope="col">Count</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($category_statistics as $category) :  ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= $category['category_name'] ?></td>
                            <td><?= $category['product_count'] ?></td>
                        </tr>
                    <?php endforeach ?>

                </tbody>
            </table>

            <hr>
            <table class="table">
                <?php $orders_products = ordersProductsStatistics()[0]; ?>
                <h3>Orders and Products : </h3>
                <hr>
                <thead>
                    <tr>
                        <th scope="col">Data Name</th>
                        <th scope="col">counter </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Total product in stock</td>
                        <td><?= $orders_products['products_in_stock'] ?></td>
                    </tr>
                    <tr>
                        <td>Total product out of stock</td>
                        <td><?= $orders_products['products_out_of_stock'] ?></td>
                    </tr>
                    <tr>
                        <td>Total product has been ordered</td>
                        <td><?= $orders_products['product_ordered'] ?></td>
                    </tr>

                    <tr>
                        <td>Total quantity ordered</td>
                        <td><?= $orders_products['count_quantity'] ?></td>
                    </tr>

                    <tr>
                        <td>Total product Revenue</td>
                        <td><?= $orders_products['total_price'] ?></td>
                    </tr>
                </tbody>
            </table>



        </div>
    </div>
</div>
<?php require_once  ROOT . 'inc/footer.php'; ?>