<?php require_once '../inc/header.php'; ?>
<?php

require_once  ROOT . 'functions/functions.php';
require_once  ROOT . 'functions/validations.php';
require_once  ROOT . 'product/functions/db_functions.php';



// const
// search input length
define('MAX_INPUT_SIZE', 15);
define('MIN_INPUT_SIZE', 2);
$errors = [];
// DATA
// data sanitize
if (!isset($_GET['search'])) {
    redirect(URL);
}
$search = sanitize($_GET['search']);

// data validations
// search validations
if (empty($search)) {
    $errors[] = 'search value is missing';
} elseif (is_numeric($search)) {
    $errors[] = 'search must be string';
} elseif (maxInputSize($search, MAX_INPUT_SIZE)) {
    $errors[] = 'search must is too large, max = ' . MAX_INPUT_SIZE;
} elseif (minInputSize($search, MIN_INPUT_SIZE)) {
    $errors[] = 'search must is too small, min = ' . MIN_INPUT_SIZE;
} else {
    $result = search($search);
    if (!$result) {
        $errors[] = 'no product has been found';
    } else {
        $product = getProductInfo($result);
        $product_imgs = getProductImgs($result);
    }
}

if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
}
require_once  ROOT . 'inc/nav.php';

?>

<div class="container">

    <?php require_once  ROOT . 'inc/show_mass.php'; ?>

    <div class="row">
        <div class="col-5 my-5">
            <h1>Search Result For : <?= $search ?> </h1>
            <hr>
            <?php if (isset($product)) : ?>
                <div class="card" style="width: 18rem;">
                    <img width="200" height="250" src="<?= URL ?>product/imgs/<?= $product_imgs[0] ?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><?= $product['product_name'] ?></h5>
                        <h6 class="card-text"><?= $product['category_name'] ?></h6>
                        <p class="card-text"><?= $product['product_description'] ?></p>
                        <a href="<?= URL ?>product/show_product.php?id=<?= $product['product_id'] ?>" class="btn btn-success">Details</a>

                        <a href="<?= URL ?>cart/handlers/add_to_cart.php?id=<?= $product['product_id'] ?>&qty=1" class="btn "><button type="button" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                                    <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"></path>
                                </svg>
                            </button>
                        </a>
                        <a href="<?= URL ?>wishList/handlers/add_to_wishList.php?id=<?= $product['product_id'] ?>" class="btn btn-secondary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                                <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"></path>
                            </svg>

                        </a>

                    </div>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>


</div>
<?php require_once  ROOT . 'inc/footer.php';
?>