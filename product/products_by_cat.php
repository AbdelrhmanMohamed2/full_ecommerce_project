<?php require_once '../inc/header.php'; ?>
<?php require_once '../inc/nav.php';
require_once '../functions/functions.php';
require_once 'functions/db_functions.php';
require_once '../manager/cat_db_functions/cat_functions.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    redirect('../index.php');
} elseif (!checkExists($_GET['id'], 'id',  'categories')) {
    redirect('../index.php');
}
$cat_name = getOnaCat($_GET['id']);
$result = categoryProducts($_GET['id']);

?>

<div class="container">
    <div class="row">
        <div class="col-12 my-5">
            <h1>All Products For : <?= $cat_name['name'] ?> </h1>
            <hr>
            <?php require_once '../inc/show_mass.php'; ?>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#product id</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Product Description</th>
                        <th scope="col">Price</th>
                        <th scope="col">Available</th>
                        <th scope="col">Show</th>

                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($result as $product) :     ?>

                        <tr>
                            <th scope="row"><?= $product['product_id'] ?></th>
                            <td><?= $product['product_name'] ?></td>
                            <td><?= $product['product_description'] ?></td>
                            <td><?= $product['price'] ?></td>
                            <td><?= $product['stock'] > 5 ? "Available" : "last : " . $product['stock']  ?></td>
                            <td><a href="show_product.php?id=<?= $product['product_id'] ?>" class="btn btn-success">Show</a></td>

                        </tr>
                    <?php endforeach  ?>

                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require_once '../inc/footer.php'; ?>