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
            <a class="btn btn-warning btn-xs" href="<?= base_url('admin/evaluasi/'); ?>"><i class="fas fa-redo"></i> Back</a>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fas fa-times"></i></button>
            </div>
        </div>
        <div class="card-body mt-2 p-1">
            <input type="hidden" name="client" id="client" data="<?= $id; ?>">
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
                alert('done');

            }
        });
    });

    $('#sData').on('change', '.go', function(event) {
        // event.preventDefault();
        var stat;
        var id = $(this).attr('data');
        if (event.target.checked) {
            stat = 1;

        } else {
            stat = 0;

        }

        $.ajax({
            type: "post",
            url: "<?= site_url('admin/checkeval'); ?>",
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

    function showData() {
        var client = $('#client').attr('data');
        $.ajax({
            type: "post",
            async: false,
            url: "<?= site_url('admin/dteval') ?>",
            dataType: "JSON",
            data: {
                client: client
            },
            success: function(data) {
                var html = '';
                var i;
                var no = 1;
                for (i = 0; i < data.length; i++) {
                    var check;
                    if (data[i].dos == 1) {
                        check = 'checked';
                        dis = 'disabled';
                    } else {
                        check = null;
                        dis = null;

                    }
                    html += '<tr>' +
                        '<td>' + no + '</td>' +
                        '<td>' + data[i].nama + '</td>' +
                        '<td>' + data[i].ket + '</td>' +
                        '<td>' +
                        '<input data="' + data[i].ide + '" type="checkbox" class="form-control go" ' + dis + ' name="go" value=' + data[i].done + ' id="go" ' + check + '>' + '<label class="form-label" for="go">Done</label>' +
                        '</td>' +

                        '</tr>';
                    no++;
                }

                $('#sData').html(html);
            }
        });

    }
</script>