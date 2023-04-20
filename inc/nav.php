<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= URL ?>">King BOB</a>
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

                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Controller
                            </button>

                            <ul class="dropdown-menu dropdown-menu-dark">
                                <li><a class="dropdown-item active" href="<?= URL ?>manager/all_users.php">Show All Users</a></li>
                                <li><a class="dropdown-item" href="<?= URL ?>manager/all_cat.php">Show All Categories</a></li>
                                <li><a class="dropdown-item" href="<?= URL ?>product/all_products.php">Show All Products</a></li>
                                <li><a class="dropdown-item" href="<?= URL ?>order/all_orders.php">Show All Orders</a></li>
                                <?php if ($_SESSION['data']['roll'] == 1) : ?>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="<?= URL ?>manager/panel.php">Create Data Panel</a></li>
                                <?php endif ?>
                            </ul>
                        </div>
                    <?php endif ?>



                    <!-- Profile -->
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?= URL ?>user/profile.php">Profile</a>
                    </li>
            </ul>

            <ul class="navbar-nav mx-2">
                <li class="nav-item mx-2">
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
                </li>

                <li class="nav-item mx-2">
                    <a href="#" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
                        </svg>
                        WishList
                    </a>
                </li>


                <li class="nav-item mx-2">
                    <a href="<?= URL ?>order/user_orders.php" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-card-list" viewBox="0 0 16 16">
                            <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"></path>
                            <path d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8zm0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-1-5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zM4 8a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zm0 2.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z"></path>
                        </svg>
                        Orders
                    </a>
                </li>


                <li class="nav-item mx-2">
                    <a class="nav-link text-danger" aria-current="page" href="<?= URL ?>user/logout.php">Logout</a>
                </li>


            <?php endif ?>
            </ul>

        </div>
    </div>
</nav>