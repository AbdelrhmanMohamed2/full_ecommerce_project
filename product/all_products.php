<?php require_once '../inc/header.php'; ?>
<?php require_once '../inc/nav.php';
require_once '../functions/functions.php';
require_once 'functions/db_functions.php';

if (!isset($_SESSION['data'])) {
    redirect('user/login.php');
} elseif ($_SESSION['data']['roll'] > 2) {
    redirect('../user/profile.php');
}


$result = getAllProducts();

?>

<div class="container">
    <div class="row">
        <div class="col-12 my-5">
            <h1>All Products : SELECT Category </h1>
            <hr>
            <?php require_once '../inc/show_mass.php'; ?>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#product id</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Product Description</th>
                        <th scope="col">category name</th>
                        <th scope="col">category logo</th>
                        <th scope="col">Show</th>
                        <?php if ($_SESSION['data']['roll'] === 1) : ?>

                            <th scope="col">Edit</th>
                            <th scope="col">delete</th>
                        <?php endif ?>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($product = mysqli_fetch_assoc($result)) :     ?>

                        <tr>
                            <th scope="row"><?= $product['product_id'] ?></th>
                            <td><?= $product['product_name'] ?></td>
                            <td><?= $product['product_description'] ?></td>
                            <td><?= $product['category_name'] ?></td>
                            <td><img width="150" src="../manager/cat_logos/<?= $product['category_logo'] ?>" alt=""></td>
                            <td><a href="show_product.php?id=<?= $product['product_id'] ?>" class="btn btn-success">Show</a></td>
                            <?php if ($_SESSION['data']['roll'] === 1) : ?>
                                <td><a href="edit_product.php?id=<?= $product['product_id'] ?>" class="btn btn-info">Edit</a></td>
                                <td><a href="handlers/delete_product.php?id=<?= $product['product_id'] ?>" class="btn btn-danger">Delete</a></td>
                            <?php endif ?>
                        </tr>
                    <?php endwhile ?>

                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require_once '../inc/footer.php'; ?>