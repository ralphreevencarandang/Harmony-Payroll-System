<?= $this->extend('base'); ?>
<?= $this->section('main_content'); ?>


<div class="container">
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('message')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('message'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="d-flex">
            <a href="/dashboard">Home </a>
            <p class="mx-2"> > </p>
            <p class="text-primary"> Account Settings</p>
        </div>
    </div>

    <div class="row gap-5">

        <div class="card col-lg">
            <div class="card-body">

                <div class="">
                    <h3 class=""><i class="fa-solid fa-camera"></i> EDIT MY PHOTO</h3>
                    <div class="border-bottom border-dark my-3"></div>
                </div>
                <div class="text-center">
                    <form action="updateProfile" method="post" enctype="multipart/form-data">
                        <img src="uploads/<?= $user['image'] ?>" alt="" width="300px" class="mb-3 rounded-circle">
                        <input type="file" class="form-control mb-3" name="profileImage">
                        <input type="submit" class="btn btn-primary" value="Change Photo">
                    </form>


                </div>

            </div>

        </div>
        <div class="card col-lg">
            <div class="card-body">
                <div>
                    <h3><i class="fa-regular fa-pen-to-square"></i> EDIT MY ACCOUNT</h3>
                    <div class="border-bottom border-dark my-3"></div>

                </div>

                <div>
                    <form action="/updateAccount" method="post">
                        <label class="form-label">Role</label>
                        <input type="text" class="form-control" value="<?= $user['type'] ?>" readonly>
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" value="<?= $user['username'] ?>">
                        <label class="form-label">Current Password</label>
                        <input type="text" name="current_password" class="form-control">
                        <label class="form-label">New Password</label>
                        <input type="text" name="new_password" class="form-control mb-2">
                        <label class="form-label">Confirm Password</label>
                        <input type="text" name="confirm_password" class="form-control mb-2">

                        <div class="d-grid gap-2">
                            <input type="submit" value="Save" class="btn btn-primary">

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

</div>


<?= $this->endSection(); ?>