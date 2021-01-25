<div class="mt-4 container">
    <div class="row">
        <div class="col-md-4">
            <div class=" card card-info card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle" src="<?= base_url('assets/lte/'); ?>dist/img/user4-128x128.jpg" alt="User profile picture">
                    </div>

                    <h3 class="profile-username text-center"><?= $profile['nama']; ?></h3>
                    <?php if ($profile['job'] == 1) : ?>
                        <p class="text-muted text-center">Desainer</p>
                    <?php elseif ($profile['job'] == 2) : ?>
                        <p class="text-muted text-center">Front End</p>
                    <?php else : ?>
                        <p class="text-muted text-center">Back End</p>
                    <?php endif; ?>
                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Username</b> <a class="float-right"><?= $profile['username']; ?></a>
                        </li>
                        <li class="list-group-item">
                            <b>Email</b> <a class="float-right"><?= $profile['email']; ?></a>
                        </li>
                        <li class="list-group-item">
                            <b>Since</b> <a class="float-right"><?= date("d - m - Y", strtotime($profile['created']));  ?></a>
                        </li>
                    </ul>

                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <div class="col-md">

            <!-- About Me Box -->
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">About Me</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <strong><i class="fas fa-map-marker-alt mr-1"></i> Address</strong>

                    <p class="text-muted"><?= $profile['alamat']; ?></p>

                    <hr>

                    <strong><i class="far fa-file-alt mr-1"></i> Whatsapp</strong>

                    <p class="text-muted"><?= $profile['wa']; ?></p>
                </div>
                <!-- /.card-body -->

            </div>
            <div class="row">
                <div class="col-md-2">
                    <a href="<?= base_url('devel/edit_profile/' . $profile['id']); ?>" class="btn btn-secondary btn-block "><i class="fas fa-pencil-alt mr-1"></i> <b>Edit</b></a>
                </div>
            </div>

        </div>
    </div>
    <!-- /.card -->

    <!-- /.card -->
</div>
<!-- /.container -->