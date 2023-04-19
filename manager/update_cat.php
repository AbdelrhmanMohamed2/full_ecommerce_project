<?php
require_once '../inc/header.php';
require_once  ROOT . 'inc/nav.php';
require_once  ROOT . 'functions/functions.php';
require_once 'cat_db_functions/cat_functions.php';

if (!isset($_SESSION['data'])) {
    redirect('../user/login.php');
} elseif ($_SESSION['data']['roll'] != 1 || !isset($_GET['id'])) {
    redirect('../user/profile.php');
}

$cat_data = getOnaCat($_GET['id']);
if (!$cat_data) {

    redirect('all_cat.php');
}
?>

<div class="container">
    <div class="row">
        <div class="col-8 my-5">
            <h1>Update Category :</h1>
            <a href="all_cat.php" class="btn btn-success">Back to All Categories</a>
            <hr>
            <?php require_once '../inc/show_mass.php'; ?>

            <form method="POST" action="cat_handlers/cat_update_handler.php" enctype="multipart/form-data">

                <div class="mb-3">
                    <label for="cat_name" class="form-label">Category Name</label>
                    <input type="text" value="<?= $cat_data['name'] ?>" name="cat_name" class="form-control" id="cat_name">
                    <input type="text" value="<?= $_GET['id'] ?>" name="id" hidden>
                </div>


                <div class="mb-3">
                    <label for="cat_desc" class="form-label">Category Description</label>
                    <input type="text" value="<?= $cat_data['description'] ?>" name="cat_desc" class="form-control" id="cat_desc">
                </div>

                <img width="200" src="cat_logos/<?= $cat_data['logo'] ?>" alt="">
                <div class="mb-3">
                    <label for="logo" class="form-label">Category Logo</label>
                    <input class="form-control" name="cat_logo" type="file" id="logo">
                </div>


                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
<?php require_once  ROOT . 'inc/footer.php'; ?>