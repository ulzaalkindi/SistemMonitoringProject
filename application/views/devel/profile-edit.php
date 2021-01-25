<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?= $title; ?></h1>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <form role="form" action="" method="post">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">User Data</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <div class="card-body">
                            <input type="hidden" name="id" value="<?= $devel['id']; ?>">
                            <div class="form-group">
                                <label for="nama">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Lengkap" value="<?= $devel['nama']; ?>">
                                <?= form_error('nama', '<small class="text-danger">', '</small>'); ?>

                            </div>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?= $devel['username']; ?>">
                                <?= form_error('username', '<small class="text-danger">', '</small>'); ?>

                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?= $devel['email']; ?>">
                                <?= form_error('email', '<small class="text-danger">', '</small>'); ?>

                            </div>
                            <!-- <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                               

                            </div> -->
                        </div>
                        <!-- /.card-body -->

                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">Detail Information</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->

                        <div class="card-body">
                            <div class="form-group">
                                <label for="job">Pekerjaan</label>
                                <select class="form-control" name="job" id="job" disabled>
                                    <option value="">-- Pilih --</option>
                                    <option value="1" <?= $devel['job'] == 1 ? 'selected' : null ?>>Desainer</option>
                                    <option value="2" <?= $devel['job'] == 2 ? 'selected' : null ?>>Front End</option>
                                    <option value="3" <?= $devel['job'] == 3 ? 'selected' : null ?>>Back End</option>
                                </select>
                                <?= form_error('job', '<small class="text-danger">', '</small>'); ?>

                            </div>
                            <div class="form-group">
                                <label for="wa">Whatsapp *</label>
                                <input type="number" class="form-control" id="wa" name="wa" placeholder="Nomor Whatsapp" value="<?= $devel['wa']; ?>">
                                <?= form_error('wa', '<small class="text-danger">', '</small>'); ?>

                            </div>
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea name="alamat" id="alamat" class="form-control" rows="1"><?= $devel['alamat']; ?></textarea>
                                <?= form_error('alamat', '<small class="text-danger">', '</small>'); ?>

                            </div>
                        </div>


                    </div>
                    <!-- /.card -->
                </div>

            </div>
            <div class="row mb-2">
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                    <a href="<?= base_url('devel/profile'); ?>" class="btn btn-danger"> <i class="fa fa-redo"></i> Batal</a>
                </div>
            </div>
        </div>
    </form>
</section>