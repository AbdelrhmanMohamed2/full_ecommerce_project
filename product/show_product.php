<?php require_once '../inc/header.php'; ?>
<?php require_once  ROOT . 'inc/nav.php';

require_once  ROOT . 'functions/functions.php';
require_once 'functions/db_functions.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    redirect(URL);
}

$product = getProductInfo($_GET['id']);
if (!$product) {
    redirect(URL);
}
$product_imgs = getProductImgs($_GET['id']);



?>

<div class="container">

    <?php require_once  ROOT . 'inc/show_mass.php'; ?>


    <div class="row my-5">
        <h1>Product : <?= $product['category_name'] ?> : <?= $product['product_name'] ?></h1>
        <hr>

        <!-- img -->
        <div class="col-6 my-5 ">
            <div id="carouselExample" class="carousel slide">
                <div class="carousel-inner">
                    <?php foreach ($product_imgs as $key => $img) : ?>
                        <div class="carousel-item <?php if ($key == 0) : ?> active <?php endif ?>">
                            <img width="400" height="400" src="imgs/<?= $img ?>" class="d-block w-100" alt="...">
                        </div>
                    <?php endforeach ?>

                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>

        </div>


        <!-- info -->
        <div class="col-6 ">
            <div class="card">
                <div class="card-header">
                    Product Info :
                </div>
                <div class="card-body">
                    <h5 class="card-title">Product Name :</h5>
                    <p class="card-text"><?= $product['product_name'] ?></p>
                </div>
                <hr>

                <div class="card-body">
                    <h5 class="card-title">Product Description :</h5>
                    <p class="card-text"><?= $product['product_description'] ?></p>
                </div>
                <hr>

                <div class="card-body">
                    <h5 class="card-title">Product Price :</h5>
                    <p class="card-text"><?= $product['product_price'] ?> EGP</p>
                </div>
                <hr>

                <div class="card-body">
                    <h5 class="card-title">Product State :</h5>
                    <p class="card-text"><?= $product['product_stock'] > 5 ? 'available' : ($product['product_stock'] == 0  ?  "out off stock" :  'last : ' . $product['product_stock']) ?> </p>
                </div>
                <hr>

                <form class="p-4" method="GET" action="../cart/handlers/add_to_cart.php" enctype="multipart/form-data">
                    <!-- user img input -->
                    <div class="mb-3">
                        <label for="order" class="form-label">Order Now: </label>
                        <input name="qty" value="1" class="form-control" type="number" id="order">
                        <input name="id" value="<?= $_GET['id'] ?>" hidden>
                    </div>

                    <button type="submit" class="btn btn-primary">Add to Cart</button>
                </form>


            </div>
        </div>
    </div>
    <div class="row">
        <hr>
        <h1>other product from : <?= $product['category_name'] ?></h1>
        <hr>
        <?php require_once 'top_product_for_cat.php' ?>
    </div>
</div>
<?php require_once  ROOT . 'inc/footer.php'; ?>