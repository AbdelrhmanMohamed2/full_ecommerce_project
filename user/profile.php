<?php require_once '../inc/header.php'; ?>
<?php require_once '../inc/nav.php'; ?>

<div class="container">
    <div class="row my-5">
        <h1>Profile Page</h1>
        <hr>

        <!-- img -->
        <div class="col-6 my-5 ">
            <img src="https://placehold.co/400x400" class="rounded  " alt="...">

            <hr>
            <div class="card-body">
                <h5 class="card-title">Change Img:</h5>
                <form>
                    <!-- user img input -->
                    <div class="mb-3">
                        <label for="profile_img" class="form-label">New Img</label>
                        <input name="profile_img" class="form-control" type="file" id="profile_img">
                    </div>

                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>
            </div>


        </div>


        <!-- info -->
        <div class="col-6 ">
            <div class="card">
                <div class="card-header">
                    Profile Info :
                </div>
                <div class="card-body">
                    <h5 class="card-title">FullName:</h5>
                    <p class="card-text">Abdelrhman Mohamed</p>
                </div>
                <hr>

                <div class="card-body">
                    <h5 class="card-title">Email:</h5>
                    <p class="card-text">abdo@gmail.com</p>
                </div>

                <hr>

                <div class="card-body">
                    <h5 class="card-title">Change Password:</h5>
                    <form>

                        <!-- old password input -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Old Password</label>
                            <input name="password" type="password" class="form-control" id="password">
                        </div>

                        <!-- new password input -->
                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input name="password" type="password" class="form-control" id="password">
                        </div>


                        <!-- confirm password input -->
                        <div class="mb-3">
                            <label for="con_password" class="form-label">Confirm New Password</label>
                            <input name="con_password" type="password" class="form-control" id="con_password">
                        </div>

                        <button type="submit" class="btn btn-primary">Change Password</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <hr>
        <div class="col-6">

            <form>



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



                <button type="submit" class="btn btn-danger">Delete Your Account</button>
            </form>
        </div>
    </div>
</div>
<?php require_once '../inc/footer.php'; ?>