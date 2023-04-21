<?php require_once '../inc/header.php'; ?>
<?php
require_once  ROOT . 'functions/functions.php';
if (!isset($_SESSION['data'])) {
    redirect('user/login.php');
}
require_once  ROOT . 'inc/nav.php';
require_once   'list_functions/list_db_functions.php';

$result = getWishListInfo($_SESSION['data']['id']);


?>

<div class="container">
    <div class="row">
        <div class="col-12 my-5">
            <h1>All Your Orders : </h1>
            <hr>
            <?php require_once '../inc/show_mass.php'; ?>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#id</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Add to Cart</th>
                        <th scope="col">Remove</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($result as $item) : ?>
                        <tr>
                            <td><?= $item['wishlist_id'] ?></td>
                            <td><a href="<?= URL ?>product/show_product.php?id=<?= $item['product_id'] ?>"><?= $item['product_name'] ?></a></td>
                            <td><a class="btn btn-primary" href="<?= URL ?>cart/handlers/add_to_cart.php?id=<?= $item['product_id'] ?>&qty=1">to Cart</a></td>
                            <td><a href="handlers/delete_item.php?id=<?= $item['wishlist_id'] ?>" class="btn btn-danger">Remove</a></td>
                        </tr>
                    <?php endforeach ?>

                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require_once  ROOT . 'inc/footer.php'; ?>