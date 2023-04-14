<?php require_once '../inc/header.php'; ?>
<?php require_once '../inc/nav.php';

require_once '../functions/functions.php';
if (!isset($_SESSION['data'])) {
    redirect('login.php');
}
$user = $_SESSION['data'];

?>

<div class="container">

    <!-- check for errors -->
    <?php if (isset($_SESSION['errors'])) :
        foreach ($_SESSION['errors'] as $error) :
    ?>
            <div class="alert alert-danger"><?= $error ?></div>

    <?php
        endforeach;
        unset($_SESSION['errors']);

    endif ?>

    <!-- check for success massages -->
    <?php if (isset($_SESSION['success'])) :

    ?>
        <div class="alert alert-success"><?= $_SESSION['success'] ?></div>

    <?php

        unset($_SESSION['success']);
    endif ?>

    <div class="row my-5">
        <h1>Profile Page</h1>
        <hr>

        <!-- img -->
        <div class="col-6 my-5 ">
            <img width="400" src="imgs/<?= $user['img'] ?? "https://placehold.co/400x400" ?>" class="rounded  " alt="profile picture">

            <hr>
            <div class="card-body">
                <h5 class="card-title">Change Img:</h5>
                <form method="POST" action="handlers/change_img.php" enctype="multipart/form-data">
                    <!-- user img input -->
                    <div class="mb-3">
                        <label for="profile_img" class="form-label">New Img</label>
                        <input name="profile_img" class="form-control" type="file" id="profile_img">
                    </div>

                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>
            </div>


        </div>


        <!-- info -->
        <div class="col-6 ">
            <div class="card">
                <div class="card-header">
                    Profile Info :
                </div>
                <div class="card-body">
                    <h5 class="card-title">FullName:</h5>
                    <p class="card-text"><?= $user['first_name'] . " " . $user['last_name'] ?></p>
                </div>
                <hr>

                <div class="card-body">
                    <h5 class="card-title">Email:</h5>
                    <p class="card-text"><?= $user['email']  ?></p>
                </div>

                <hr>

                <div class="card-body">
                    <h5 class="card-title">Change Password:</h5>
                    <form action="handlers/change_pass.php" method="POST">

                        <!-- old password input -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Old Password</label>
                            <input name="old_password" type="password" class="form-control" id="password">
                        </div>

                        <!-- new password input -->
                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input name="password" type="password" class="form-control" id="password">
                        </div>


                        <!-- confirm password input -->
                        <div class="mb-3">
                            <label for="con_password" class="form-label">Confirm New Password</label>
                            <input name="con_password" type="password" class="form-control" id="con_password">
                        </div>

                        <button type="submit" class="btn btn-primary">Change Password</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <hr>
        <div class="col-6">

            <form action="handlers/delete_acc.php" method="POST">



                <!-- password input -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input name="password" type="password" class="form-control" id="password">
                </div>


                <!-- confirm password input -->
                <div class="mb-3">
                    <label for="con_password" class="form-label">Confirm Password</label>
                    <input name="con_password" type="password" class="form-control" id="con_password">
                </div>



                <button type="submit" class="btn btn-danger mb-5">Delete Your Account</button>
            </form>
        </div>
    </div>
</div>
<?php require_once '../inc/footer.php'; ?>