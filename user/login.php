<?php require_once '../inc/header.php'; ?>
<?php require_once '../inc/nav.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-8 my-5">
            <h1>Login Page</h1>
            <hr>

            <form>



                <!-- email input -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input name="email" type="email" class="form-control" id="email">
                </div>


                <!-- password input -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input name="password" type="password" class="form-control" id="password">
                </div>



                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
    </div>
</div>
<?php require_once '../inc/footer.php'; ?>