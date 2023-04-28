<nav class="navbar navbar-expand-lg " style="background-color: #e3f2fd;">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#categories_bar" aria-controls="categories_bar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="categories_bar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php
                require_once ROOT . 'manager/cat_db_functions/cat_functions.php';
                $result = getAllCat();

                ?>

                <?php while ($cat = mysqli_fetch_assoc($result)) :     ?>

                    <li class="nav-item">
                        <a class="nav-link text-dark" aria-current="page" href="<?= URL ?>product/products_by_cat.php?id=<?= $cat['id'] ?>"><?= $cat['name'] ?></a>
                    </li>

                <?php endwhile ?>

            </ul>

        </div>
    </div>
</nav>