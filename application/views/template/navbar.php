 <!-- Navbar -->
 <nav class="main-header navbar navbar-expand navbar-info navbar-dark">
     <!-- Left navbar links -->
     <ul class="navbar-nav">
         <li class="nav-item">
             <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
         </li>
     </ul>

     <!-- Right navbar links -->
     <ul class="navbar-nav ml-auto">
         <!-- Messages Dropdown Menu -->
         <!-- Notifications Dropdown Menu -->

         <li class="nav-item dropdown list-notif" data="<?= time(); ?>">

         </li>
         <li class="nav-item dropdown">
             <a class="nav-link" data-toggle="dropdown" href="#">
                 <i class="far fa-user-circle"></i>
                 <span class="d-none d-md-inline ml-1"><?= $this->session->userdata('nama'); ?></span>
             </a>
             <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                 <a href="<?= base_url('auth/logout'); ?>" class="dropdown-item bg-info dropdown-header float-right"><i class="fas fa-sign-out-alt mr-1"></i>Sign Out</a>
                 <div class="dropdown-divider"></div>
             </div>
         </li>
     </ul>
 </nav>
 <!-- /.navbar -->
 <script>
     $(document).ready(function() {

         show_not();
         Pusher.logToConsole = true;

         var pusher = new Pusher('69a99071d426944894ee', {
             cluster: 'ap1',
             forceTLS: true
         });

         var channel = pusher.subscribe('my-channel');
         channel.bind('my-event', function(data) {
             if (data.message === 'success') {
                 show_not();
             }
         });
         $('.list-notif').on('click', '.notclick', function() {
             var baca = 1;
             $.ajax({
                 type: "post",
                 url: "<?= site_url('notifikasi/updatebaca') ?>",
                 dataType: "JSON",
                 data: {
                     baca: baca
                 },
                 success: function() {
                     show_not();
                 }
             })
         });
     });

     function show_not() {
         $.ajax({
             type: "ajax",
             url: "<?= site_url('notifikasi/show_notif'); ?>",
             success: function(data) {
                 $('.list-notif').html(data);
             }
         });

     }
     //  $(document).ready(function() {



     //      $('.oke').html('<p>Anda Salah Pikiran</p>');

     //  });
 </script>