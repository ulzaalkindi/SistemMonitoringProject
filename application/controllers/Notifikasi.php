<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notifikasi extends CI_Controller
{
    public function show_notif()
    {
        $this->load->view('notif/notif');
    }
    public function updatebaca()
    {
        $baca = $this->input->post('baca');
        $this->db->set('baca', $baca);
        $this->db->update('notif');
        pusher();
    }
}
