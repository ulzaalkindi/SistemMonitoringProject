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
            <a class="btn btn-success btn-xs" href="<?= base_url('admin/addtask/' . $id); ?>"><i class="fas fa-user-plus"></i> Add Task</a>
            <a class="btn btn-warning btn-xs" href="<?= base_url('admin/page/' . $idpg); ?>"><i class="fas fa-redo"></i> Back</a>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fas fa-times"></i></button>
            </div>
        </div>
        <div class="card-body mt-2 p-1">
            <input type="hidden" name="page" id="page" data="<?= $id; ?>">
            <table id="dData" class="table  table-striped table-bordered text-center">
                <thead>
                    <tr>
                        <th style="width: 1%">
                            #
                        </th>
                        <th style="width: 20%">
                            Nama Project
                        </th>
                        <th style="width: 30%">
                            Keterangan
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
        $('#dData').DataTable({
            'lengthChange': false,
            'searching': false,
            'info': false
        });
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
        $('#sData').on('click', '.del_prj', function() {
            return confirm('anda yakin ?');
        });
        $('#sData').on('change', '#go', function(event) {
            var stat;
            var id = $(this).attr('data');
            if (event.target.checked) {
                stat = 1;


            } else {
                stat = 0;

            }

            $.ajax({
                type: "post",
                url: "<?= site_url('admin/project/upprj'); ?>",
                dataType: "JSON",
                data: {
                    stat: stat,
                    id: id
                },
                success: function() {
                    alert('done');
                }
            });

        });
    });

    function showData() {
        var page = $('#page').attr('data');
        $.ajax({
            type: "post",
            async: false,
            url: "<?= site_url('admin/dttask') ?>",
            dataType: "JSON",
            data: {
                page: page
            },
            success: function(data) {
                var html = '';
                var i;
                var no = 1;
                for (i = 0; i < data.length; i++) {
                    var done = data[i].done;
                    var check;
                    if (done == 1) {
                        check = 'checked';
                    } else {
                        check = null;
                    }
                    html += '<tr>' +
                        '<td>' + no + '</td>' +
                        '<td>' + data[i].nama + '</td>' +
                        '<td>' + data[i].keterangan + '</td>' +
                        '<td>' +
                        '<a class="badge badge-warning mr-1" href="<?= base_url('admin/edittask/'); ?>' + data[i].pg_id + '/' + data[i].id + '"><i class="fas fa-pencil-alt"></i></a>' +
                        '<a class="badge badge-danger mr-1 del_prj" href="<?= base_url('admin/deltask/'); ?>' + data[i].pg_id + '/' + data[i].id + '"><i class="fas fa-trash"></i></a>' +
                        '</td>' +
                        '</tr>';
                    no++;
                }

                $('#sData').html(html);
            }
        });

    }
</script>