<?php require_once '../inc/header.php'; ?>
<?php require_once  ROOT . 'inc/nav.php';
require_once  ROOT . 'functions/functions.php';


if (!isset($_SESSION['data'])) {
    redirect('user/login.php');
}
require_once 'cart_functions/cart_functions.php';
$cart_info = getCartInfo($_SESSION['data']['id']);
$total = 0;




?>

<div class="container">
    <div class="row">
        <div class="col-12 my-5">
            <h1>Cart : </h1>
            <hr>
            <?php require_once '../inc/show_mass.php'; ?>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#cart item id</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Product price</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">total Price</th>
                        <th scope="col">Remove</th>

                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart_info as $cart_item) : ?>
                        <tr>
                            <th scope="row"><?= $cart_item['item_id'] ?></th>
                            <td><a href="<?= URL ?>product/show_product.php?id=<?= $cart_item['product_id'] ?>"><?= $cart_item['product_name'] ?></a></td>
                            <td><?= $cart_item['product_price'] ?></td>
                            <td>
                                <form action="handlers/update_item_qty.php" method="POST">
                                    <div class="mb-3">
                                        <input type="number" value="<?= $cart_item['quantity'] ?>" name="product_quantity" class="form-control" id="product_quantity">
                                        <input type="number" value="<?= $cart_item['item_id'] ?>" name="item_id" hidden>
                                    </div>
                                    <button type="submit" class="btn btn-success">Update</button>

                                </form>

                            </td>
                            <td><?= $cart_item['total_price'] ?></td>
                            <td><a href="<?= URL ?>cart/handlers/remove_item.php?id=<?= $cart_item['item_id'] ?>" class="btn btn-danger">Remove</a></td>
                        </tr>
                    <?php
                        $total += $cart_item['total_price'];

                    endforeach;

                    $tax = $total * .1;
                    $delivery = $tax > 0 ? 50 : 0;
                    $total_amount = $total + $delivery + $tax;



                    ?>


                </tbody>
            </table>
            <h4>Total Price : <?= $total ?> EGP</h4>
            <hr>
            <h4>Taxes (10%) : <?= $tax ?> EGP</h4>
            <hr>
            <h4>Delivery : <?= $delivery ?> EGP</h4>
            <hr>
            <h4>Total : <?= $total_amount ?> EGP</h4>
            <a href="<?= URL ?>order/handlers/create_order.php" class="btn btn-info">Order Now!</a>
        </div>
    </div>
</div>
<?php $total = 0;
require_once  ROOT . 'inc/footer.php'; ?>