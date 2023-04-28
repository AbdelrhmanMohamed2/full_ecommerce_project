<?php require_once '../inc/header.php'; ?>
<?php require_once  ROOT . 'inc/nav.php';
require_once  ROOT . 'functions/functions.php';
require_once  ROOT . 'manager/cat_db_functions/cat_functions.php';
require_once 'functions/db_functions.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    redirect(URL . 'index.php');
}
$cat_name = getOnaCat($_GET['id']);
if (!$cat_name) {
    redirect(URL . 'index.php');
}
$result = categoryProducts($_GET['id'], ($_GET['filter'] ?? 'most_recent'));

?>

<div class="container">
    <div class="row">
        <div class="col-12 my-5">
            <h1>All Products For : <?= $cat_name['name'] ?> </h1>
            <hr>
            <form method="GET" action="<?= $_SERVER['PHP_SELF']  ?>">
                <div class="mb-3">

                    <select class="form-select" name="filter" aria-label="Default select example">
                        <option <?php if (isset($_GET['filter']) && $_GET['filter'] == 'recently_added') : ?> selected <?php endif ?> value="recently_added">Recently Added</option>
                        <option <?php if (isset($_GET['filter']) && $_GET['filter'] == 'popular') : ?> selected <?php endif ?> value="popular">Popular</option>
                        <option <?php if (isset($_GET['filter']) && $_GET['filter'] == 'most_ordered') : ?> selected <?php endif ?> value="most_ordered">Most Ordered</option>
                        <option <?php if (isset($_GET['filter']) && $_GET['filter'] == 'min_max') : ?> selected <?php endif ?> value="min_max">Price : from min to max</option>
                        <option <?php if (isset($_GET['filter']) && $_GET['filter'] == 'max_min') : ?> selected <?php endif ?> value="max_min">Price : from max to min</option>
                    </select>
                </div>
                <input type="text" name="id" value="<?= $_GET['id'] ?>" hidden>
                <button type="submit" class="btn btn-primary">Filter</button>
            </form>

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
                            <a href="show_product.php?id=<?= $product['product_id'] ?>" class="btn btn-success">Details</a>

                            <a href="../cart/handlers/add_to_cart.php?id=<?= $product['product_id'] ?>&qty=1" class="btn "><button type="button" class="btn btn-secondary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                                        <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"></path>
                                    </svg>
                                </button></a>
                            <a href="../cart/handlers/add_to_cart.php?id=<?= $product['product_id'] ?>&qty=1" class="btn btn-primary">Wish List</a>
                        </div>
                    </div>
                <?php endforeach  ?>

            </div>

        </div>
    </div>
</div>
<?php require_once '../inc/footer.php'; ?>