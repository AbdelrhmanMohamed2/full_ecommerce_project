<?php require_once '../inc/header.php'; ?>
<?php require_once '../inc/nav.php';
require_once '../functions/functions.php';
require_once 'cat_db_functions/cat_functions.php';

if (!isset($_SESSION['data'])) {
    redirect('user/login.php');
} elseif ($_SESSION['data']['roll'] > 2) {
    redirect('../user/profile.php');
}


$result = getAllCat();

?>

<div class="container">
    <div class="row">
        <div class="col-12 my-5">
            <h1>All Categories : </h1>
            <hr>
            <?php require_once '../inc/show_mass.php'; ?>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#category id</th>
                        <th scope="col">Category Name</th>
                        <th scope="col">Category Description</th>
                        <th scope="col">logo</th>
                        <?php if ($_SESSION['data']['roll'] === 1) : ?>

                            <th scope="col">Edit</th>
                            <th scope="col">delete</th>
                        <?php endif ?>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($cat = mysqli_fetch_assoc($result)) :     ?>

                        <tr>
                            <th scope="row"><?= $cat['id'] ?></th>
                            <td><?= $cat['name'] ?></td>
                            <td><?= $cat['description'] ?></td>
                            <td><img width="150" src="cat_logos/<?= $cat['logo'] ?>" alt=""></td>
                            <?php if ($_SESSION['data']['roll'] === 1) : ?>
                                <td><a href="update_cat.php?id=<?= $cat['id'] ?>" class="btn btn-info">Edit</a></td>
                                <td><a href="cat_handlers/delete_cat.php?id=<?= $cat['id'] ?>" class="btn btn-danger">Delete</a></td>
                            <?php endif ?>
                        </tr>
                    <?php endwhile ?>

                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require_once '../inc/footer.php'; ?>