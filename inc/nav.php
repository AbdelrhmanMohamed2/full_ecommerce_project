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

                    <?php if ($_SESSION['data']['roll'] < 3) : ?>
                        <!-- Controller -->
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="<?= URL ?>manager/panel.php">Controller</a>
                        </li>
                    <?php endif ?>



                    <!-- Profile -->
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?= URL ?>user/profile.php">Profile</a>
                    </li>
            </ul>

            <ul class="navbar-nav ">

                <li class="nav-item mx-5">
                    <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bag" viewBox="0 0 16 16">
                            <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z"></path>
                        </svg>
                        Cart
                        <span class="badge text-bg-success">
                            <?php if (isset($_SESSION['cart_counter'])) : ?>
                                <?= $_SESSION['cart_counter'] ?>
                            <?php else : ?>
                                0
                            <?php endif ?>
                        </span>
                    </button>



                    </button>

                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" aria-current="page" href="<?= URL ?>user/logout.php">Logout</a>
                </li>


            <?php endif ?>
            </ul>

        </div>
    </div>
</nav>