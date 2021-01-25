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
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Add Page</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->

                        <div class="card-body">
                            <div class="form-group">
                                <label for="prj_id">prj_id</label>
                                <input type="text" class="form-control" name="prj_id" id="prj_id" value="<?= $id; ?>" readonly>
                                <?= form_error('prj_id', '<small class="text-danger">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <label for="nama">Nama Halaman</label>
                                <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Halaman">
                                <?= form_error('nama', '<small class="text-danger">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <label for="Keterangan">Keterangan Halaman</label>
                                <textarea name="keterangan" class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
                                <?= form_error('Keterangan', '<small class="text-danger">', '</small>'); ?>
                            </div>
                        </div>
                        <!-- /.card-body -->

                    </div>
                    <!-- /.card -->
                </div>

            </div>
            <div class="row mb-2">
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                    <a href="<?= base_url('admin/page/' . $id); ?>" class="btn btn-danger"> <i class="fa fa-redo"></i> Batal</a>
                </div>
            </div>
        </div>
    </form>
</section>