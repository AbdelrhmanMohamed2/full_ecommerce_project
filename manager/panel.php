<?php require_once '../inc/header.php'; ?>
<?php
require_once  ROOT . 'functions/functions.php';

if (!isset($_SESSION['data'])) {
    redirect(URL . 'user/login.php');
} elseif ($_SESSION['data']['roll'] != 1) {
    redirect(URL . 'user/profile.php');
}
require_once  ROOT . 'inc/nav.php';
require_once  ROOT . 'user/db_functions/users_functions.php';
require_once 'cat_db_functions/cat_functions.php';

$result = getAllRolls();
$all_categories = getAllCat();
?>

<div class="container">
    <div class="row">
        <div class="col-8 my-5">
            <h1>Panel page</h1>
            <hr>
            <?php require_once ROOT . 'inc/show_mass.php'; ?>

            <!-- create users -->
            <div class="accordion accordion-flush" id="inside">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed " type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                            Create New User Account
                        </button>
                    </h2>


                    <div id="flush-collapseOne" class="accordion-collapse collapse " data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">

                            <form action="users_handlers/create_acc_handler.php" method="POST" enctype="multipart/form-data">
                                <?php require_once '../user/reg_form.php' ?>
                                <?php while ($roll =  mysqli_fetch_assoc($result)) : ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="roll" value="<?= $roll['id'] ?>" id="<?= $roll['id'] ?>">
                                        <label class="form-check-label" for="<?= $roll['id'] ?>">
                                            <?= $roll['name'] ?>
                                        </label>
                                    </div>
                                <?php endwhile ?>

                                <button type="submit" class="btn btn-primary">Create Account</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- create categories -->
            <div class="accordion accordion-flush" id="inside">

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                            Create New Category
                        </button>
                    </h2>
                    <div id="flush-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <form method="POST" action="cat_handlers/create_cat_handler.php" enctype="multipart/form-data">

                                <div class="mb-3">
                                    <label for="cat_name" class="form-label">Category Name</label>
                                    <input type="text" name="cat_name" class="form-control" id="cat_name">
                                </div>


                                <div class="mb-3">
                                    <label for="cat_desc" class="form-label">Category Description</label>
                                    <input type="text" name="cat_desc" class="form-control" id="cat_desc">
                                </div>


                                <div class="mb-3">
                                    <label for="logo" class="form-label">Category Logo</label>
                                    <input class="form-control" name="cat_logo" type="file" id="logo">
                                </div>


                                <button type="submit" class="btn btn-primary">Create</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <!-- create products -->
            <div class="accordion accordion-flush" id="inside">

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#products_area" aria-expanded="false" aria-controls="products_area">
                            Create New Product
                        </button>
                    </h2>
                    <div id="products_area" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">

                        <div class="accordion-body">
                            <form method="POST" action="../product/handlers/create_product_handler.php" enctype="multipart/form-data">

                                <div class="mb-3">
                                    <label for="product_name" class="form-label">Product Name</label>
                                    <input type="text" name="product_name" class="form-control" id="product_name">
                                </div>


                                <div class="mb-3">
                                    <label for="product_description" class="form-label">Product Description</label>
                                    <input type="text" name="product_description" class="form-control" id="product_description">
                                </div>


                                <div class="mb-3">
                                    <label for="product_price" class="form-label">Product Price</label>
                                    <input type="number" name="product_price" class="form-control" id="product_price">
                                </div>

                                <div class="mb-3">
                                    <label for="product_stock" class="form-label">Product Stock</label>
                                    <input type="number" name="product_stock" class="form-control" id="product_stock">
                                </div>



                                <div class="mb-3">
                                    <select class="form-select" name="category_id">
                                        <option selected>Open to select product category</option>
                                        <?php while ($category = mysqli_fetch_assoc($all_categories)) : ?>
                                            <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                                        <?php endwhile ?>

                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="product_imgs" class="form-label">Product Imgs</label>
                                    <input class="form-control" name="product_imgs[]" multiple type="file" id="product_imgs">
                                </div>


                                <button type="submit" class="btn btn-primary">Create</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once  ROOT . 'inc/footer.php'; ?>