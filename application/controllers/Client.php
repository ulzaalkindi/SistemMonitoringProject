<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Client extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_progress', 'pgs');
        $this->load->model('M_evaluasi', 'eva');
        $this->load->model('M_user', 'usr');
    }
    public function index()
    {
        $id = $this->session->userdata('id');
        $prj = $this->db->query("SELECT count(*) as tp FROM project WHERE client='$id'")->row_array();
        $data = [
            'title' => 'Dashboard',
            'content' => '/client/index',
            'prj' => $prj['tp']
        ];
        $this->load->view('wrapper', $data);
    }
    public function dtprogress()
    {
        $id = $this->session->userdata('id');
        $data = $this->pgs->get_progressbycli($id);
        echo json_encode($data);
    }
    public function evaluasi()
    {
        $data = [
            'title' => 'Evaluasi',
            'content' => '/client/project'
        ];
        $this->load->view('wrapper', $data);
    }
    public function dtproject()
    {
        $id = $this->session->userdata('id');
        $data = $this->db->get_where('project', ['client' => $id])->result();
        echo json_encode($data);
    }
    public function evaluasitsk($id)
    {
        $data = [
            'title' => 'Fungsi',
            'content' => '/client/tsk',
            'id' => $id
        ];
        $this->load->view('wrapper', $data);
    }
    public function dtfungsi()
    {
        $prj = $this->input->post('prj');
        $data = $this->eva->get_evaluasibyprjcli($prj);
        echo json_encode($data);
    }
    public function evaluasifunc($id, $func)
    {
        $data = [
            'title' => 'Evaluasi',
            'content' => '/client/evaluasi',
            'id' => $id,
            'func' => $func
        ];
        $this->load->view('wrapper', $data);
    }
    public function dteval()
    {
        $tsk = $this->input->post('tsk');
        $data = $this->eva->get_evaluasibytskcli($tsk);
        echo json_encode($data);
    }
    public function addeval($id, $tsk)
    {
        $data = [
            'title' => 'Add Evaluasi',
            'content' => '/client/evaluasi-add',
            'id' => $id,
            'tsk' => $tsk
        ];

        $this->form_validation->set_rules('tsk', 'Task', 'trim|required');
        $this->form_validation->set_rules('keterangan', 'Evaluasi', 'trim|required', ['required' => "Kolom Keterangan tidak boleh kosong"]);
        if ($this->form_validation->run() == false) {
            $this->load->view('wrapper', $data);
        } else {
            $tskid = htmlspecialchars($this->input->post('tsk', true));
            $keterangan = htmlspecialchars($this->input->post('keterangan', true));
            $task = [
                // 'job' => $job,
                'tskid' => $tskid,
                'ket' => $keterangan
            ];
            $this->eva->add_evaluasi($task);
            $prj = $this->db->query("SELECT p.nama as prj_name,t.* FROM task t join project p on t.prjid=p.id")->row_array();
            $usr = 1;
            send_notif($usr, "New Evaluasi " . $prj['prj_name']);
            pusher();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New Evaluasi Added!</div>');
            redirect('client/evaluasifunc/' . $id . '/' . $tsk);
        }
    }
    public function editeval($id, $tsk, $prj)
    {
        $eval = $this->db->get_where('evaluasi', ['ide' => $id])->row_array();
        $data = [
            'title' => 'Evaluasi',
            'content' => '/client/evaluasi-edit',
            'id' => $id,
            'eval' => $eval,
            't' => $tsk,
            'p' => $prj

        ];

        $this->form_validation->set_rules('eval', 'Evaluasi ID', 'trim|required');
        $this->form_validation->set_rules('keterangan', 'Evaluasi', 'trim|required');
        if ($this->form_validation->run() == false) {
            $this->load->view('wrapper', $data);
        } else {
            $ideval = htmlspecialchars($this->input->post('eval', true));
            $keterangan = htmlspecialchars($this->input->post('keterangan', true));
            $task = [
                'ket' => $keterangan
            ];
            $this->eva->edit_evaluasi($ideval, $task);
            pusher();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Evaluasi Edited!</div>');
            redirect('client/evaluasifunc/' . $tsk . '/' . $prj);
        }
    }
    public function deleval($id, $tsk, $prj)
    {
        $this->eva->del_evaluasi($id);
        pusher();
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Evaluasi Deleted!</div>');
        redirect('client/evaluasifunc/' . $tsk . '/' . $prj);
    }

    // Controller Profile
    // Controller Profile
    public function profile()
    {
        $id = $this->session->userdata('id');
        $profile = $this->usr->cli_profile($id);
        $data = [
            'title' => 'User Profile',
            'content' => '/client/profile',
            'profile' => $profile
        ];
        $this->load->view('wrapper', $data);
    }

    public function edit_profile($id)
    {
        $profile = $this->usr->cli_profile($id);
        $data = [
            'title' => 'User Profile',
            'content' => '/client/profile-edit',
            'client' => $profile
        ];

        $this->form_validation->set_rules('nama', 'Full Name', 'trim|required');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|callback_username_check');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('perusahaan', 'perusahaan', 'trim|required');
        $this->form_validation->set_rules('wa', 'Whatsapp', 'trim|required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
        if ($this->form_validation->run() == false) {
            $this->load->view('wrapper', $data);
        } else {
            $nama = htmlspecialchars($this->input->post('nama', true));
            $username = htmlspecialchars($this->input->post('username', true));
            // $password = htmlspecialchars($this->input->post('password', true));
            $email = htmlspecialchars($this->input->post('email', true));
            $perusahaan = htmlspecialchars($this->input->post('perusahaan', true));
            $wa = htmlspecialchars($this->input->post('wa', true));
            $alamat = htmlspecialchars($this->input->post('alamat', true));
            $usr = [
                'nama' => $nama,
                'username' => $username,
                'email' => $email
            ];
            $this->usr->edit_user($id, $usr);
            $cli = [
                'perusahaan' => $perusahaan,
                'wa' => $wa,
                'alamat' => $alamat,
                'user_id' => $id
            ];
            $this->usr->edit_client($id, $cli);
            pusher();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Your Profile Edited!</div>');
            redirect('client/profile');
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


    // =========================//
}
