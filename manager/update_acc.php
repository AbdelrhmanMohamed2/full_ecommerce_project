<?php require_once '../inc/header.php'; ?>
<?php require_once '../inc/nav.php';
require_once '../functions/functions.php';
require_once '../user/db_functions/users_functions.php';
if (!isset($_SESSION['data'])) {
    redirect('../user/login.php');
} elseif ($_SESSION['data']['roll'] != 1 || !isset($_GET['id'])) {
    redirect('../user/profile.php');
}
$user_info = getUserInfo($_GET['id']);
if (!isset($user_info['email'])) {

    redirect('all_users.php');
}
$rolls = getAllRolls();
?>

<div class="container">
    <div class="row">
        <div class="col-8 my-5">
            <h1>Update User :</h1>
            <a href="all_users.php" class="btn btn-success">Back to All Users</a>
            <hr>
            <?php require_once '../inc/show_mass.php'; ?>
            <form action="users_handlers/update_acc_handler.php" method="POST" enctype="multipart/form-data">

                <!-- First name input -->
                <div class="mb-3">
                    <label for="f_name" class="form-label">First Name</label>
                    <input value="<?= $user_info['first_name'] ?>" name="f_name" type="text" class="form-control" id="f_name">
                </div>

                <!-- Last name input -->
                <div class="mb-3">
                    <label for="l_name" class="form-label">Last Name</label>
                    <input value="<?= $user_info['last_name'] ?>" name="l_name" type="text" class="form-control" id="l_name">
                </div>

                <!-- email input -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input value="<?= $user_info['email'] ?>" name="email" type="email" class="form-control" id="email">
                </div>


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


                <!-- user img input -->
                <img width="200" src="../user/imgs/<?= $user_info['img'] ?>" alt="">
                <div class="mb-3">
                    <label for="profile_img" class="form-label">Profile Img</label>
                    <input name="profile_img" class="form-control" type="file" id="profile_img">
                    <input hidden name="id" value="<?= $_GET['id'] ?>">
                </div>

                <?php while ($roll =  mysqli_fetch_assoc($rolls)) : ?>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="roll" <?php if ($roll['id'] == $user_info['roll']) : ?> checked <?php endif ?> value="<?= $roll['id'] ?>" id="<?= $roll['id'] ?>">
                        <label class="form-check-label" for="<?= $roll['id'] ?>">
                            <?= $roll['name'] ?>
                        </label>
                    </div>
                <?php endwhile ?>
                <button type="submit" class="btn btn-primary">Update</button>

            </form>

        </div>
    </div>
</div>
<?php require_once '../inc/footer.php'; ?>