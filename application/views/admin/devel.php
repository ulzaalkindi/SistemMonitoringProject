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
    <?= $this->session->flashdata('message'); ?>

    <!-- Default box -->
    <div class="card">
        <div class="card-header p-2">
            <a class="btn btn-success btn-xs" href="<?= base_url('admin/adddevel'); ?>"><i class="fas fa-user-plus"></i> Add Developer</a>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fas fa-times"></i></button>
            </div>
        </div>
        <div class="card-body mt-2 p-1">
            <table id="dData" class="table  table-striped projects text-center">
                <thead>
                    <tr>
                        <th style="width: 1%">
                            #
                        </th>
                        <th style="width: 20%">
                            Nama Developer
                        </th>
                        <th style="width: 30%">
                            Pekerjaan
                        </th>
                        <th style="width: 20%">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody id="sData">
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            Footer
        </div>
        <!-- /.card-footer-->
    </div>
    <!-- /.card -->

</section>
<!-- /.content -->
<script>
    $(document).ready(function() {
        showData();
        $('#dData').DataTable();
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('69a99071d426944894ee', {
            cluster: 'ap1',
            forceTLS: true
        });

        var channel = pusher.subscribe('my-channel');
        channel.bind('my-event', function(data) {
            if (data.message === 'success') {
                showData();
            }
        });
    });

    function showData() {
        $.ajax({
            type: "ajax",
            async: false,
            url: "<?= site_url('admin/dtdevel') ?>",
            dataType: "JSON",
            success: function(data) {
                var html = '';
                var i;
                var pekerjaan;
                var no = 1;
                for (i = 0; i < data.length; i++) {
                    if (data[i].job == 1) {
                        pekerjaan = 'Desainer';
                    } else if (data[i].job == 2) {
                        pekerjaan = 'Front End';
                    } else if (data[i].job == 3) {
                        pekerjaan = 'Back End';
                    }
                    html += '<tr>' +
                        '<td>' + no + '</td>' +
                        '<td>' + data[i].nama + '</td>' +
                        '<td>' + pekerjaan + '</td>' +
                        '<td>' +
                        '<a class="badge badge-warning mr-1" href="<?= base_url('admin/editdevel/'); ?>' + data[i].id + '"><i class="fas fa-pencil-alt"></i> Edit</a>' +
                        '<a class="badge badge-danger mr-1" href="<?= base_url('admin/deldevel/'); ?>' + data[i].id + '"><i class="fas fa-trash"></i> Delete</a>' +
                        '<a class="badge badge-info" href="<?= base_url('admin/cpass/'); ?>' + data[i].id + '"><i class="fas fa-key"></i> Pass</a>' +
                        '</td>' +
                        '</tr>';
                    no++;
                }
                $('#sData').html(html);
            }
        });
    }
</script>