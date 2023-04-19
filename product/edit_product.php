<?php require_once '../inc/header.php'; ?>
<?php require_once  ROOT . 'inc/nav.php';

require_once  ROOT . 'functions/functions.php';
require_once 'functions/db_functions.php';

if (!isset($_SESSION['data'])) {
    redirect('../user/login.php');
} elseif (!isset($_GET['id']) || !is_numeric($_GET['id'])  || $_SESSION['data']['roll'] != 1) {
    redirect('../index.php');
}

require_once '../manager/cat_db_functions/cat_functions.php';

$product = getProductInfo($_GET['id']);
if (!$product) {
    redirect('../index.php');
}
$product_imgs = getProductImgs($_GET['id']);
$all_categories = getAllCat();




?>

<div class="container">

    <?php require_once '../inc/show_mass.php'; ?>


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

            <!-- create products -->


            <form method="POST" action="handlers/update_product_handler.php">

                <div class="mb-3">
                    <label for="product_name" class="form-label">Product Name</label>
                    <input type="text" value="<?= $product['product_name'] ?>" name="product_name" class="form-control" id="product_name">
                </div>


                <div class="mb-3">
                    <label for="product_description" class="form-label">Product Description</label>
                    <input type="text" value="<?= $product['product_description'] ?>" name="product_description" class="form-control" id="product_description">
                </div>


                <div class="mb-3">
                    <label for="product_price" class="form-label">Product Price</label>
                    <input type="number" value="<?= $product['product_price'] ?>" name="product_price" class="form-control" id="product_price">
                    <input type="number" value="<?= $product['product_id'] ?>" name="product_id" hidden>
                </div>

                <div class="mb-3">
                    <label for="product_stock" class="form-label">Product Stock</label>
                    <input type="number" value="<?= $product['product_stock'] ?>" name="product_stock" class="form-control" id="product_stock">
                </div>



                <div class="mb-3">
                    <select class="form-select" name="category_id">
                        <?php while ($category = mysqli_fetch_assoc($all_categories)) : ?>
                            <option value="<?= $category['id'] ?>" <?php if ($category['name'] == $product['category_name']) : ?> selected <?php endif ?>><?= $category['name'] ?></option>
                        <?php endwhile ?>

                    </select>
                </div>



                <button type="submit" class="btn btn-success">Update</button>
            </form>

        </div>
    </div>

</div>
<?php require_once  ROOT . 'inc/footer.php'; ?>