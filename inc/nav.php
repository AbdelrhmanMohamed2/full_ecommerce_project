<?php

define('URL', 'http://localhost/phpCourse/php_mysql_project/ecommerce/');

?>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= URL ?>">E-commerce</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php if (!isset($_SESSION['data'])) : ?>


                    <!-- Register -->
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?= URL ?>user/register.php">Register</a>
                    </li>


                    <!-- Login -->
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?= URL ?>user/login.php">Login</a>
                    </li>
                <?php else : ?>
                    <!-- HOME -->
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?= URL ?>">Home</a>
                    </li>



                    <!-- Profile -->
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?= URL ?>user/profile.php">Profile</a>
                    </li>
            </ul>

            <ul class="navbar-nav ">
                <li class="nav-item">
                    <a class="nav-link text-danger" aria-current="page" href="<?= URL ?>user/logout.php">Logout</a>
                </li>
            <?php endif ?>
            </ul>

        </div>
    </div>
</nav>