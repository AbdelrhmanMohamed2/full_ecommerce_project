<?php require_once '../inc/header.php'; ?>
<?php require_once '../inc/nav.php';
require_once '../functions/functions.php';
require_once '../user/db_functions/users_functions.php';

if (!isset($_SESSION['data'])) {
    redirect('../user/login.php');
} elseif ($_SESSION['data']['roll'] > 3) {
    redirect('../user/profile.php');
}
$result = getAllRolls();
?>

<div class="container">
    <div class="row">
        <div class="col-8 my-5">
            <h1>Panel page</h1>
            <hr>
            <?php require_once '../inc/show_mass.php'; ?>
            <div class="accordion accordion-flush" id="top">
                <!-- show data  -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#show_data" aria-expanded="false" aria-controls="flush-collapseOne">
                            Show Data
                        </button>
                    </h2>
                    <div id="show_data" class="accordion-collapse collapse" data-bs-parent="#top">
                        <div class="accordion-body">

                            <a href="all_users.php" class="btn btn-primary">All Users</a>
                            <a href="all_cat.php" class="btn btn-primary">All Categories</a>

                        </div>
                    </div>
                </div>
                <?php if ($_SESSION['data']['roll'] === 1) : ?>
                    <div class="accordion-item">
                        <!-- create data -->
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#create_data" aria-expanded="false" aria-controls="flush-collapseTwo">
                                Create Data
                            </button>
                        </h2>
                        <div id="create_data" class="accordion-collapse collapse" data-bs-parent="#inside">
                            <div class="accordion-body">
                                <!-- create users -->
                                <div class="accordion accordion-flush" id="inside">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed sho" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                                Create New User Account
                                            </button>
                                        </h2>


                                        <div id="flush-collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionFlushExample">
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

                            </div>
                        </div>


                    </div>
                <?php endif ?>
            </div>

        </div>
    </div>
</div>
<?php require_once '../inc/footer.php'; ?>