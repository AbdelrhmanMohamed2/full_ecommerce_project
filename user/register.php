<?php require_once '../inc/header.php'; ?>
<?php require_once '../inc/nav.php';
require_once '../functions/functions.php';
if (isset($_SESSION['data'])) {
    redirect('profile.php');
}
?>

<div class="container">
    <div class="row">
        <div class="col-8 my-5">
            <h1>Register Page</h1>
            <hr>

            <?php require_once '../inc/show_mass.php'; ?>
            <form action="handlers/register_handler.php" method="POST" enctype="multipart/form-data">

                <?php require_once 'reg_form.php' ?>
                <button type="submit" class="btn btn-primary">Register NOW!</button>

            </form>

        </div>
    </div>
</div>
<?php require_once '../inc/footer.php'; ?>