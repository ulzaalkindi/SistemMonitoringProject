<?php
if ($this->session->userdata('role') == 1) {
    require_once('template/header.php');
    require_once('template/navbar.php');
    require_once('template/sidebar_a.php');
    require_once('template/main.php');
    require_once('template/footer.php');
} else if ($this->session->userdata('role') == 2) {
    require_once('template/header.php');
    require_once('template/navbar.php');
    require_once('template/sidebar_b.php');
    require_once('template/main.php');
    require_once('template/footer.php');
} else if ($this->session->userdata('role') == 3) {
    require_once('template/header.php');
    require_once('template/navbar.php');
    require_once('template/sidebar_c.php');
    require_once('template/main.php');
    require_once('template/footer.php');
} else {
    $this->session->set_flashdata('gagal', '<center>Anda harus login terlebih dahulu!</center>');
    redirect(site_url('auth'), 'refresh');
}
