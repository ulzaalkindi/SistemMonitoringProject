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
    <!-- Info boxes -->
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-suitcase"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Project</span>
                    <span class="info-box-number">
                        <?= $prj; ?>
                        <small></small>
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-user-secret"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Done Task</span>
                    <span class="info-box-number"><?= $tsk; ?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix hidden-md-up"></div>

        <!-- /.col -->
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Default box -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Title</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fas fa-times"></i></button>
            </div>
        </div>
        <div class="card-body">
            <table id="dData" class="table">
                <thead>
                    <tr>
                        <th style="width: 1%">
                            #
                        </th>
                        <th style="width: 94%">
                            Project
                        </th>
                        <th style="width: 5%">

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

<!-- Javascript AJAX -->
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

    function showData() {
        $.ajax({
            type: "ajax",
            url: "<?= site_url('devel/dtprogress') ?>",
            dataType: "JSON",
            success: function(data) {
                var html = '';
                var i;
                var no = 1;
                var x;
                var warna;
                var y = ['primary', 'danger', 'success', 'info', 'warning'];
                for (i = 0; i < data.length; i++) {
                    x = Math.round((data[i].do / data[i].total) * 100);
                    if (x <= 20) {
                        warna = 'danger';
                    } else if (x <= 50 && x > 20) {
                        warna = 'warning'
                    } else if (x <= 80 && x > 50) {
                        warna = 'success';
                    } else if (x <= 100 && x > 80) {
                        warna = 'info';
                    }
                    html += '<tr>' +
                        '<td>' + no + '</td>' +
                        '<td>' + '<div class="progress-group"><span class="progress-text">' + data[i].namap + '</span><span class="float-right"><b>' + data[i].do + '</b>/' + data[i].total + '</span><div class="progress progress-sm"><div class="progress-bar bg-' + y[Math.floor(Math.random() * y.length)] + '" style="width: ' + Math.round((data[i].do / data[i].total) * 100) + '%"></div></div><td><span class="badge bg-' + warna + '">' + Math.round((data[i].do / data[i].total) * 100) + '%</span></td></div>' + '<td>' +
                        '</tr>';
                    no++;
                }

                $('#sData').html(html);
            }
        });

    }
</script>