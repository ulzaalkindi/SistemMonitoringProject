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
                            <h3 class="card-title">Add Project</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->

                        <div class="card-body">
                            <div class="form-group">
                                <label for="client">Client</label>
                                <input type="text" class="form-control" name="client" id="client" value="<?= $id; ?>" readonly>
                                <?= form_error('client', '<small class="text-danger">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <label for="nama">Nama Project</label>
                                <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Project">
                                <?= form_error('nama', '<small class="text-danger">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <label for="dsg">Desainer</label>
                                <select name="dsg" id="dsg" class="form-control">
                                    <option value="">-- Pilih --</option>
                                    <?php foreach ($dsg as $ds) : ?>
                                        <option value="<?= $ds['id']; ?>"><?= $ds['nama']; ?></option>
                                    <?php endforeach; ?>

                                </select>
                                <?= form_error('dsg', '<small class="text-danger">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <label for="fe">Front End</label>
                                <select name="fe" id="fe" class="form-control">
                                    <option value="">-- Pilih --</option>
                                    <?php foreach ($fe as $f) : ?>
                                        <option value="<?= $f['id']; ?>"><?= $f['nama']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <?= form_error('fe', '<small class="text-danger">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <label for="be">Back End</label>
                                <select name="be" id="be" class="form-control">
                                    <option value="">-- Pilih --</option>
                                    <?php foreach ($be as $b) : ?>
                                        <option value="<?= $b['id']; ?>"><?= $b['nama']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <?= form_error('be', '<small class="text-danger">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <label for="keterangan">Keterangan</label>
                                <textarea class="form-control" name="keterangan" id="keterangan" rows="3"></textarea>
                                <?= form_error('keterangan', '<small class="text-danger">', '</small>'); ?>

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
                    <a href="<?= base_url('admin/project/' . $id); ?>" class="btn btn-danger"> <i class="fa fa-redo"></i> Batal</a>
                </div>
            </div>
        </div>
    </form>
</section>