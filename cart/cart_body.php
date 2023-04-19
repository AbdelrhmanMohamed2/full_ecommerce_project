<?php
require_once 'cart_functions/cart_functions.php';
$cart_info = getCartInfo($_SESSION['data']['id']);
$total = 0;
$i = 0;
?>
<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Cart</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Total Price</th>
                        <th scope="col">Remove</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart_info as $cart_item) : ?>
                        <tr>
                            <th scope="row"><?= $cart_item['item_id'] ?></th>
                            <td><?= $cart_item['product_name'] ?></td>
                            <td><?= $cart_item['quantity'] ?></td>
                            <td><?= $cart_item['total_price'] ?></td>
                            <td><a href="<?= URL ?>cart/handlers/remove_item.php?id=<?= $cart_item['item_id'] ?>" class="btn btn-danger">Remove</a></td>
                        </tr>
                    <?php

                        $total += $cart_item['total_price'];
                        $i += 1;
                    endforeach;
                    $_SESSION['cart_counter'] = $i;

                    ?>

                </tbody>
            </table>
            <h4>Total : <?= $total ?></h4>
            <a href="<?= URL ?>cart/show_cart.php" class="btn btn-info">See Details</a>
            <a href="<?= URL ?>cart/handlers/delete_cart_items.php" class="btn btn-danger">Remove All</a>
        </div>

    </div>
</div>