<?php require_once '../inc/header.php'; ?>
<?php require_once '../inc/nav.php';
require_once '../functions/functions.php';
require_once '../user/db_functions/users_functions.php';
if (!isset($_SESSION['data'])) {
    redirect('user/login.php');
} elseif ($_SESSION['data']['roll'] > 2) {
    redirect('../user/profile.php');
}

$result = getAllUsers();

?>

<div class="container">
    <div class="row">
        <div class="col-12 my-5">
            <h1>All Users : </h1>
            <hr>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#user id</th>
                        <th scope="col">Full Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Img</th>
                        <th scope="col">Roll</th>
                        <?php if ($_SESSION['data']['roll'] === 1) : ?>

                            <th scope="col">Edit</th>
                            <th scope="col">delete</th>
                        <?php endif ?>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = mysqli_fetch_assoc($result)) :     ?>

                        <tr>
                            <th scope="row"><?= $user['user_id'] ?></th>
                            <td><?= $user['first_name'] . " " . $user['first_name'] ?></td>
                            <td><?= $user['email'] ?></td>
                            <td><img width="150" src="../user/imgs/<?= $user['img'] ?>" alt=""></td>
                            <td><?= $user['roll_name'] ?></td>
                            <?php if ($_SESSION['data']['roll'] === 1) : ?>
                                <td><a href="update_acc.php?id=<?= $user['user_id'] ?>" class="btn btn-info">Edit</a></td>
                                <td><a href="handlers/delete_acc_handler.php?id=<?= $user['user_id'] ?>" class="btn btn-danger">Delete</a></td>
                            <?php endif ?>
                        </tr>
                    <?php endwhile ?>

                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require_once '../inc/footer.php'; ?>