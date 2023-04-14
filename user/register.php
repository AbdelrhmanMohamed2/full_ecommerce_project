<?php require_once '../inc/header.php'; ?>
<?php require_once '../inc/nav.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-8 my-5">
            <h1>Register Page</h1>
            <hr>

            <form>

                <!-- First name input -->
                <div class="mb-3">
                    <label for="f_name" class="form-label">First Name</label>
                    <input name="f_name" type="text" class="form-control" id="f_name">
                </div>

                <!-- Last name input -->
                <div class="mb-3">
                    <label for="l_name" class="form-label">Last Name</label>
                    <input name="l_name" type="text" class="form-control" id="l_name">
                </div>

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


                <!-- confirm password input -->
                <div class="mb-3">
                    <label for="con_password" class="form-label">Confirm Password</label>
                    <input name="con_password" type="password" class="form-control" id="con_password">
                </div>


                <!-- user img input -->
                <div class="mb-3">
                    <label for="profile_img" class="form-label">Profile Img</label>
                    <input name="profile_img" class="form-control" type="file" id="profile_img">
                </div>

                <button type="submit" class="btn btn-primary">Register NOW!</button>
            </form>
        </div>
    </div>
</div>
<?php require_once '../inc/footer.php'; ?>