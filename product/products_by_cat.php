<?php require_once '../inc/header.php'; ?>
<?php require_once  ROOT . 'inc/nav.php';
require_once  ROOT . 'functions/functions.php';
require_once  ROOT . 'manager/cat_db_functions/cat_functions.php';
require_once 'functions/db_functions.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    redirect('../index.php');
}
$cat_name = getOnaCat($_GET['id']);
if (!$cat_name) {
    redirect('../index.php');
}
$result = categoryProducts($_GET['id']);


?>

<div class="container">
    <div class="row">
        <div class="col-12 my-5">
            <h1>All Products For : <?= $cat_name['name'] ?> </h1>
            <hr>
            <?php require_once '../inc/show_mass.php'; ?>

            <div class="col-12 d-flex flex-wrap gap-5 my-5">
                <?php foreach ($result as $product) :

                ?>


                    <div class="card" style="width: 18rem;">
                        <img width="200" height="250" src="imgs/<?= $product['product_image'] ?>" class="d-block w-100" alt="...">

                        <div class="card-body">
                            <h5 class="card-title"><?= $product['product_name'] ?></h5>
                            <p class="card-text"><?= $product['product_description'] ?></p>
                            <p class="card-text">Price : <?= $product['product_price'] ?> EGP</p>
                            <a href="show_product.php?id=<?= $product['product_id'] ?>" class="btn btn-success">More Details</a>
                            <a href="../cart/handlers/add_to_cart.php?id=<?= $product['product_id'] ?>&qty=1" class="btn btn-primary">Add To Cart</a>
                        </div>
                    </div>
                <?php endforeach  ?>

            </div>

        </div>
    </div>
</div>
<?php require_once '../inc/footer.php'; ?>