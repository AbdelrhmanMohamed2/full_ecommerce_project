<?php require_once 'inc/header.php'; ?>
<?php require_once 'inc/nav.php';
require_once 'functions/functions.php';
if (!isset($_SESSION['data'])) {
    redirect('user/login.php');
}
?>

<div class="container">
    <div class="row">
        <div class="col-8 my-5">
            <h1>Home Page</h1>
            <hr>
            <?php require_once 'inc/show_mass.php'; ?>

        </div>
    </div>
</div>
<?php require_once 'inc/footer.php'; ?>