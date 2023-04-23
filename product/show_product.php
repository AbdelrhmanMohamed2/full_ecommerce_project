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
                    <a href="<?= URL ?>wishList/handlers/add_to_wishList.php?id=<?= $product['product_id'] ?>" class="btn btn-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                            <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"></path>
                        </svg>
                        WishList
                    </a>
                </form>

            </div>
        </div>
    </div>




    <div class="row my-3">
        <div class="col-12">
            <hr>
            <?php $reviews = getReviews($_GET['id']); ?>
            <h4>Reviews Section : <?= count($reviews) ?></h4>
            <?php foreach ($reviews as $review) : ?>
                <hr>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-primary"><?= $review['first_name'] ?> <?= $review['last_name'] ?></h5>
                        <p class="card-text"><?= $review['review_body'] ?></p>
                        <h6 class="card-subtitle mb-2 text-info">At : <?= $review['review_time'] ?></h6>

                        <?php if (isset($_SESSION['data']) && $review['user_id'] == $_SESSION['data']['id']) : ?>
                            <a class="btn btn-info" data-bs-toggle="collapse" href="#<?= $review['review_id'] ?>" role="button" aria-expanded="false" aria-controls="collapseExample">
                                Edit
                            </a>
                            <div class="collapse" id="<?= $review['review_id'] ?>">
                                <div class="card card-body">
                                    <form method="POST" action="handlers/update_review.php">
                                        <div class="mb-3">
                                            <div class="form-floating">
                                                <textarea class="form-control" name="review" id="floatingTextarea"><?= $review['review_body'] ?></textarea>
                                                <label for="floatingTextarea">Want to add your review ?</label>
                                                <input type="number" name="review_id" value="<?= $review['review_id'] ?>" hidden>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-warning">Edit</button>
                                    </form>
                                </div>
                            </div>

                        <?php endif ?>
                        <?php if (isset($_SESSION['data']) && ($review['user_id'] == $_SESSION['data']['id'] || $_SESSION['data']['roll'] == 1)) : ?>

                            <a href="handlers/delete_review.php?review_id=<?= $review['review_id'] ?>" class="card-link btn btn-danger">Delete</a>
                        <?php endif ?>
                    </div>
                </div>

            <?php endforeach ?>

            <?php if (isset($_SESSION['data'])) : ?>

                <hr>
                <form method="POST" action="handlers/add_review.php">
                    <div class="mb-3">
                        <div class="form-floating">
                            <textarea class="form-control" name="review" id="floatingTextarea"></textarea>
                            <label for="floatingTextarea">Want to add your review ?</label>
                        </div>
                    </div>
                    <input type="number" name="product_id" value="<?= $_GET['id'] ?>" hidden>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

            <?php endif ?>
        </div>
    </div>



    <div class="row">
        <hr>
        <h1>Top Product From : <?= $product['category_name'] ?></h1>
        <hr>
        <div class="col-12 d-flex my-4 gap-5">

            <?php
            $top_products_result = topProductsForCat($product['category_id']);
            while ($top_product = mysqli_fetch_assoc($top_products_result)) :
                if ($top_product['product_id'] == $product['product_id']) {
                    continue;
                }
            ?>
                <div class="card" style="width: 18rem;">
                    <img width="200" height="250" src="<?= URL ?>product/imgs/<?= $top_product['product_img'] ?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><?= $top_product['product_name'] ?></h5>
                        <p class="card-text"><?= $top_product['product_description'] ?></p>
                        <a href="<?= URL ?>product/show_product.php?id=<?= $top_product['product_id'] ?>" class="btn btn-success">Details</a>

                        <a href="<?= URL ?>cart/handlers/add_to_cart.php?id=<?= $top_product['product_id'] ?>&qty=1" class="btn "><button type="button" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                                    <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"></path>
                                </svg>
                            </button>
                        </a>
                        <a href="<?= URL ?>wishList/handlers/add_to_wishList.php?id=<?= $top_product['product_id'] ?>" class="btn btn-secondary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                                <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"></path>
                            </svg>
                        </a>

                    </div>
                </div>
            <?php endwhile ?>
        </div>
    </div>
</div>
<?php require_once  ROOT . 'inc/footer.php'; ?>