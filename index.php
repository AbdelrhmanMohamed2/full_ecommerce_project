<?php require_once 'inc/header.php'; ?>
<?php require_once 'inc/nav.php';
require_once 'functions/functions.php';
if (!isset($_SESSION['data'])) {
    redirect('user/login.php');
}
?>

<div class="container">
    <?php require_once 'inc/show_mass.php'; ?>
    <div class="row my-5">
        <div class="col-5">
            <ul class="list-group">
                <h4>All Categories: </h4>
                <li class="list-group-item">An item</li>
                <li class="list-group-item">A second item</li>
                <li class="list-group-item">A third item</li>
                <li class="list-group-item">A fourth item</li>
                <li class="list-group-item">And a fifth one</li>
            </ul>
        </div>
        <div class="col-5">
            <ul class="list-group">
                <h4>wish list: </h4>
                <li class="list-group-item">An item</li>
                <li class="list-group-item">A second item</li>
                <li class="list-group-item">A third item</li>
                <li class="list-group-item">A fourth item</li>
                <li class="list-group-item">And a fifth one</li>
            </ul>
        </div>
    </div>
    <div class="row  my-5">
        <div class="col-12">


            <hr>
            <h4>Top Products For Category 1 : </h4>
            <hr>
            <?php require 'product/top_product_for_cat.php' ?>

        </div>
        <hr>
    </div>

    <div class="row  my-5">
        <div class="col-12">


            <hr>
            <h4>Top Products For Category 2 : </h4>
            <hr>
            <?php require 'product/top_product_for_cat.php' ?>

        </div>
        <hr>
    </div>
</div>
<?php require_once 'inc/footer.php'; ?>