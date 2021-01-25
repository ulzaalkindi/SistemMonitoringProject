<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Devel extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_progress', 'pgs');
        $this->load->model('M_task', 'tsk');
        $this->load->model('M_user', 'usr');
    }
    public function index()
    {
        $dev = $this->session->userdata('id');
        $prj = $this->db->query("SELECT COUNT(*) as pr FROM project WHERE dsg='$dev' OR fe='$dev' OR be='$dev'")->row_array();
        $tsk = $this->db->query("SELECT COUNT(*) as tt FROM progress WHERE dev='$dev'")->row_array();
        $data = [
            'title' => 'Dashboard',
            'content' => '/devel/index',
            'prj' => $prj['pr'],
            'tsk' => $tsk['tt']
        ];
        $this->load->view('wrapper', $data);
    }
    public function dtprogress()
    {
        $id = $this->session->userdata('id');
        $data = $this->pgs->get_progressbydev($id);
        echo json_encode($data);
    }
    // Controller Project task
    public function project()
    {
        $data = [
            'title' => 'Project List',
            'content' => '/devel/project'
        ];
        $this->load->view('wrapper', $data);
    }
    public function dtproject()
    {
        $id = $this->session->userdata('id');
        $data = $this->db->query("SELECT * FROM project where dsg='$id' OR fe='$id' OR be='$id'")->result();
        echo json_encode($data);
    }
    // ============================//
    // controller Project task
    public function task($id)
    {

        $data = [
            'title' => 'Task List',
            'content' => '/devel/task',
            'id' => $id
        ];
        $this->load->view('wrapper', $data);
    }
    public function dttask()
    {
        $prj = $this->input->post('prj');
        $dev = $this->session->userdata('id');
        // $prj = 2;
        // $dev = 8;
        $data = $this->tsk->get_taskbyprj($prj, $dev);
        echo json_encode($data);
    }
    public function update_progress()
    {
        $tsk = $this->input->post('tsk');
        $prj = $this->input->post('prjid');
        $dev = $this->session->userdata('id');
        $pgs = [
            'tsk' => $tsk,
            'dev' => $dev,
            'prj' => $prj
        ];
        $this->pgs->update_pgs($pgs);
        $not = $this->db->get_where('project', ['id' => $prj])->row_array();
        $notif = $not['nama'] . " Progess Terupdate!";
        $in = [
            'pesan' => $notif,
            'baca' => 0,
            'usr' => 1
        ];
        $this->db->insert('notif', $in);
        $not = $this->db->get_where('project', ['id' => $prj])->row_array();
        $notif = $not['nama'] . " Progess Terupdate!";
        $client = $not['client'];
        $in = [
            'pesan' => $notif,
            'baca' => 0,
            'usr' => $client
        ];
        $this->db->insert('notif', $in);
        pusher();
    }
    // ===========================//

    // Controller Profile
    public function profile()
    {
        $id = $this->session->userdata('id');
        $profile = $this->usr->dev_profile($id);
        $data = [
            'title' => 'User Profile',
            'content' => '/devel/profile',
            'profile' => $profile
        ];
        $this->load->view('wrapper', $data);
    }

    public function edit_profile($id)
    {
        $profile = $this->usr->dev_profile($id);
        $data = [
            'title' => 'User Profile',
            'content' => '/devel/profile-edit',
            'devel' => $profile
        ];

        $this->form_validation->set_rules('nama', 'Full Name', 'trim|required');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|callback_username_check');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        // $this->form_validation->set_rules('job', 'Job', 'trim|required');
        $this->form_validation->set_rules('wa', 'Whatsapp', 'trim|required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
        if ($this->form_validation->run() == false) {
            $this->load->view('wrapper', $data);
        } else {
            $nama = htmlspecialchars($this->input->post('nama', true));
            $username = htmlspecialchars($this->input->post('username', true));
            // $password = htmlspecialchars($this->input->post('password', true));
            $email = htmlspecialchars($this->input->post('email', true));
            // $job = htmlspecialchars($this->input->post('job', true));
            $wa = htmlspecialchars($this->input->post('wa', true));
            $alamat = htmlspecialchars($this->input->post('alamat', true));
            $usr = [
                'nama' => $nama,
                'username' => $username,
                'email' => $email
            ];
            $this->usr->edit_user($id, $usr);
            $dev = [
                // 'job' => $job,
                'wa' => $wa,
                'alamat' => $alamat,
                'user_id' => $id
            ];
            $this->usr->edit_devel($id, $dev);
            pusher();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Developer Edited!</div>');
            redirect('devel/profile');
        }
    }
    public function username_check()
    {
        $post = $this->input->post(null, TRUE);
        $query = $this->db->query("SELECT * FROM `user` WHERE `username` ='$post[username]' AND `id` != '$post[id]'");
        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('username_check', '{field} ini sudah dipakai, silahkan ganti');
            return FALSE;
        } else {
            return TRUE;
        }
    }


    // ......................../
}
