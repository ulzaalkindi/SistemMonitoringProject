<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_user', 'user');
        $this->load->model('M_prj', 'prj');
        $this->load->model('M_progress', 'pgs');
        $this->load->model('M_evaluasi', 'eva');
    }

    // Control Halaman Dashboard

    public function index()
    {
        $project = $this->db->query("SELECT COUNT(*) as tp FROM project")->row_array();
        $devel = $this->db->query("SELECT COUNT(*) as td FROM devel")->row_array();
        $client = $this->db->query("SELECT COUNT(*) as tc FROM client")->row_array();
        $data = [
            'title' => 'Dashboard',
            'content' => '/admin/index',
            'tp' => $project['tp'],
            'td' => $devel['td'],
            'tc' => $client['tc']
        ];
        $this->load->view('wrapper', $data);
    }
    public function dtprogress()
    {
        $data = $this->pgs->get_progress();
        echo json_encode($data);
    }

    // ====================================\\
    // Control Halaman Evaluasi
    public function evaluasi()
    {
        $data = [
            'title' => 'Client',
            'content' => '/admin/evaluasi'
        ];
        $this->load->view('wrapper', $data);
    }
    public function evaluasiclient($id)
    {
        $data = [
            'title' => 'Client',
            'content' => '/admin/evaluasi-client',
            'id' => $id
        ];
        $this->load->view('wrapper', $data);
    }
    public function dteval()
    {
        $id = $this->input->post('client');
        $data = $this->eva->get_eval_byclient($id);
        echo json_encode($data);
    }
    public function checkeval()
    {
        $id = $this->input->post('id');
        $stat = $this->input->post('stat');
        $this->eva->update_evalstat($id, $stat);
        $evaluasi = $this->db->query("select e.*,u.email,p.client,p.nama as prjc,u.nama as clientnya from evaluasi e join task t on e.tskid=t.id join project p on p.id=t.prjid join user u on u.id=p.client WHERE e.ide='$id'")->row_array();
        $subject = " EVALUASI PROJECT ANDA";
        $pesan = "Revisi Project yang anda request kepada kami sudah kami perbaiki, semoga anda senang dengan pekerjaan kami, terimakasih, tertanda Admin MIB";
        $email = $evaluasi['email'];
        send_emailbro($subject, $pesan, $email);
        $psn = "Evaluasi Project" . $evaluasi['prjc'] . " Sudah Direvisi";
        send_notif($evaluasi['client'], $psn);
        pusher();
        // $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Evaluasi Updated!</div>');
        // redirect('admin/project/' . $id);
    }
    // ======================================= //

    // Controller sendemail
    public function sendprj()
    {
        $id = $this->input->post('id');
        // $id = 2;
        $project = $this->db->get_where('project', ['id' => $id])->row_array();
        $namaProject = $project['nama'];
        $subject = "NEW PROJECT $namaProject";
        $pesan = "Project Baru untuk anda, mohon untuk dikerjakan, tertanda Admin MIB";
        $desainer = $this->db->get_where('user', ['id' => $project['dsg']])->row_array();
        $dsg = $desainer['email'];
        $frontend = $this->db->get_where('user', ['id' => $project['fe']])->row_array();
        $fe = $frontend['email'];
        $backend = $this->db->get_where('user', ['id' => $project['be']])->row_array();
        $be = $backend['email'];
        send_emailbro($subject, $pesan, $dsg);
        send_emailbro($subject, $pesan, $fe);
        send_emailbro($subject, $pesan, $be);
        $this->db->where('id', $id);
        $this->db->set('done', 1);
        $this->db->update('project');
        $notif = $subject;
        send_notif($project['dsg'], $notif);
        send_notif($project['fe'], $notif);
        send_notif($project['be'], $notif);

        pusher();
    }
    private function _sendnotif($id, $usr)
    {
        $not = $this->db->get_where('project', ['id' => $id])->row_array();
        $notif = "New Project For you! " . $not['nama'];
        $in = [
            'pesan' => $notif,
            'baca' => 0,
            'usr' => $usr
        ];
        $this->db->insert('notif', $in);
    }
    // COntroller Send Evaluasi

    // Control halaman Project


    public function projectclient()
    {
        $data = [
            'title' => 'List Client',
            'content' => '/admin/project-client'
        ];
        $this->load->view('wrapper', $data);
    }


    public function project($id)
    {
        $data = [
            'title' => 'Project',
            'content' => '/admin/project',
            'id' => $id
        ];
        $this->load->view('wrapper', $data);
    }
    public function dtproject()
    {
        $id = $this->input->post('client');
        $data = $this->prj->get_project_byclient($id);
        echo json_encode($data);
    }
    public function addproject($id)
    {
        $dsg = $this->user->get_devel_dsg();
        $fe = $this->user->get_devel_fe();
        $be = $this->user->get_devel_be();
        $data = [
            'title' => 'Project',
            'content' => '/admin/project-add',
            'id' => $id,
            'dsg' => $dsg,
            'fe' => $fe,
            'be' => $be,
        ];

        $this->form_validation->set_rules('client', 'Client', 'trim|required');
        $this->form_validation->set_rules('nama', 'Nama Project', 'trim|required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');
        $this->form_validation->set_rules('dsg', 'Desainer', 'trim|required');
        $this->form_validation->set_rules('fe', 'Front End', 'trim|required');
        $this->form_validation->set_rules('be', 'Back End', 'trim|required');
        if ($this->form_validation->run() == false) {
            $this->load->view('wrapper', $data);
        } else {
            $cli = htmlspecialchars($this->input->post('client', true));
            $nama = htmlspecialchars($this->input->post('nama', true));
            $keterangan = htmlspecialchars($this->input->post('keterangan', true));
            $desainer = htmlspecialchars($this->input->post('dsg', true));
            $frontend = htmlspecialchars($this->input->post('fe', true));
            $backend = htmlspecialchars($this->input->post('be', true));

            $prj = [
                'client' => $cli,
                'nama' => $nama,
                'keterangan' => $keterangan,
                'dsg' => $desainer,
                'fe' => $frontend,
                'be' => $backend
            ];
            $this->prj->add_project($prj);
            pusher();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New Project Added!</div>');
            redirect('admin/project/' . $id);
        }
    }
    public function editproject($id, $idprj)
    {
        $dsg = $this->user->get_devel_dsg();
        $fe = $this->user->get_devel_fe();
        $be = $this->user->get_devel_be();
        $project = $this->prj->get_prj_byid($idprj);
        $data = [
            'title' => 'Project',
            'content' => '/admin/project-edit',
            'id' => $id,
            'dsg' => $dsg,
            'fe' => $fe,
            'be' => $be,
            'project' => $project
        ];
        $this->form_validation->set_rules('idprj', 'Project ID', 'trim|required');
        $this->form_validation->set_rules('nama', 'Nama Project', 'trim|required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');
        $this->form_validation->set_rules('dsg', 'Desainer', 'trim|required');
        $this->form_validation->set_rules('fe', 'Front End', 'trim|required');
        $this->form_validation->set_rules('be', 'Back End', 'trim|required');
        if ($this->form_validation->run() == false) {
            $this->load->view('wrapper', $data);
        } else {
            $idproject = htmlspecialchars($this->input->post('idprj', true));
            $nama = htmlspecialchars($this->input->post('nama', true));
            $keterangan = htmlspecialchars($this->input->post('keterangan', true));
            $desainer = htmlspecialchars($this->input->post('dsg', true));
            $frontend = htmlspecialchars($this->input->post('fe', true));
            $backend = htmlspecialchars($this->input->post('be', true));
            $prj = [
                'nama' => $nama,
                'keterangan' => $keterangan,
                'dsg' => $desainer,
                'fe' => $frontend,
                'be' => $backend
            ];
            $this->prj->edit_project($idproject, $prj);
            pusher();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Project Edited!</div>');
            redirect('admin/project/' . $id);
        }
    }

    public function delproject($idc, $id)
    {
        $this->prj->del_project($id);
        pusher();
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Project Deleted!</div>');
        redirect('admin/project/' . $idc, 'refresh');
    }


    // ====================================\\

    //Page Of project
    public function page($id)
    {
        $prj = $this->db->get_where('project', ['id' => $id])->row_array();
        $data = [
            'title' => 'Page',
            'content' => '/admin/page',
            'id' => $id,
            'clid' => $prj['client']
        ];
        $this->load->view('wrapper', $data);
    }
    public function dtpage()
    {
        $id = $this->input->post('project');
        $data = $this->prj->get_page_byproject($id);
        echo json_encode($data);
    }

    public function addpage($id)
    {
        $data = [
            'title' => 'Add Page',
            'content' => '/admin/page-add',
            'id' => $id,
        ];

        $this->form_validation->set_rules('prj_id', 'prj_id', 'trim|required');
        $this->form_validation->set_rules('nama', 'Nama Project', 'trim|required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');
        if ($this->form_validation->run() == false) {
            $this->load->view('wrapper', $data);
        } else {
            $project = htmlspecialchars($this->input->post('prj_id', true));
            $nama = htmlspecialchars($this->input->post('nama', true));
            $keterangan = htmlspecialchars($this->input->post('keterangan', true));
            $pg = [
                'prj_id' => $project,
                'nama' => $nama,
                'keterangan' => $keterangan
            ];
            $this->prj->add_page($pg);
            pusher();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New Page Added!</div>');
            redirect('admin/page/' . $id);
        }
    }
    public function editpage($id, $idpg)
    {
        $page = $this->prj->get_page_byidpage($idpg);
        $data = [
            'title' => 'Edit Page',
            'content' => '/admin/page-edit',
            'id' => $idpg,
            'page' => $page,
            'idprj' => $id
        ];

        $this->form_validation->set_rules('page', 'page', 'trim|required');
        $this->form_validation->set_rules('nama', 'Nama Project', 'trim|required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');
        if ($this->form_validation->run() == false) {
            $this->load->view('wrapper', $data);
        } else {
            $idpage = htmlspecialchars($this->input->post('page', true));
            $nama = htmlspecialchars($this->input->post('nama', true));
            $keterangan = htmlspecialchars($this->input->post('keterangan', true));
            $pg = [
                'nama' => $nama,
                'keterangan' => $keterangan
            ];
            $this->prj->edit_page($idpage, $pg);
            pusher();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">PageEdited!</div>');
            redirect('admin/page/' . $id);
        }
    }

    public function delpage($id, $idpg)
    {
        $this->prj->del_page($idpg);
        pusher();
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Page Deleted!</div>');
        redirect('admin/page/' . $id, 'refresh');
    }

    public function task($id)
    {
        $idpg = $this->db->get_where('page', ['id' => $id])->row_array();
        $data = [
            'title' => 'Task',
            'content' => '/admin/task',
            'id' => $id,
            'idpg' => $idpg['prj_id']
        ];
        $this->load->view('wrapper', $data);
    }
    public function dttask()
    {
        $id = $this->input->post('page');
        $data = $this->prj->get_task_bypage($id);
        echo json_encode($data);
    }
    public function addtask($id)
    {
        $data = [
            'title' => 'Add Task',
            'content' => '/admin/task-add',
            'id' => $id,
        ];

        $this->form_validation->set_rules('pg_id', 'Page ID', 'trim|required');
        $this->form_validation->set_rules('nama', 'Nama Project', 'trim|required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');
        if ($this->form_validation->run() == false) {
            $this->load->view('wrapper', $data);
        } else {
            $pp = $this->db->get_where('page', ['id' => $id])->row_array();
            $prj_id = $pp['prj_id'];
            $pgg = htmlspecialchars($this->input->post('pg_id', true));
            $nama = htmlspecialchars($this->input->post('nama', true));
            $keterangan = htmlspecialchars($this->input->post('keterangan', true));
            $tsk = [
                'pg_id' => $pgg,
                'nama' => $nama,
                'keterangan' => $keterangan,
                'prjid' => $prj_id
            ];
            $this->prj->add_task($tsk);
            pusher();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New Task Added!</div>');
            redirect('admin/task/' . $id);
        }
    }

    public function edittask($id, $idt)
    {
        $task = $this->prj->get_task_byid($idt);
        $data = [
            'title' => 'Edit Task',
            'content' => '/admin/task-edit',
            'id' => $idt,
            'task' => $task,
            'idpg' => $id
        ];

        $this->form_validation->set_rules('t_id', 't_id', 'trim|required');
        $this->form_validation->set_rules('nama', 'Nama Fungsi', 'trim|required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');
        if ($this->form_validation->run() == false) {
            $this->load->view('wrapper', $data);
        } else {
            $idtask = htmlspecialchars($this->input->post('t_id', true));
            $nama = htmlspecialchars($this->input->post('nama', true));
            $keterangan = htmlspecialchars($this->input->post('keterangan', true));
            $tsk = [
                'nama' => $nama,
                'keterangan' => $keterangan
            ];
            $this->prj->edit_task($idtask, $tsk);
            pusher();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Task  Edited!</div>');
            redirect('admin/task/' . $id);
        }
    }
    public function deltask($id, $idtsk)
    {
        $this->prj->del_task($idtsk);
        pusher();
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Task Deleted!</div>');
        redirect('admin/task/' . $id, 'refresh');
    }

    // ======================================\\

    // Control halaman Developer

    public function devel()
    {
        $data = [
            'title' => 'Dashboard',
            'content' => '/admin/devel'
        ];
        $this->load->view('wrapper', $data);
    }
    public function dtdevel()
    {
        $data = $this->user->get_all_devel();
        echo json_encode($data);
    }
    public function adddevel()
    {
        $data = [
            'title' => 'Add Developer',
            'content' => '/admin/devel-add'
        ];

        $this->form_validation->set_rules('nama', 'Full Name', 'trim|required');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|is_unique[user.username]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('job', 'Job', 'trim|required');
        $this->form_validation->set_rules('wa', 'Whatsapp', 'trim|required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
        if ($this->form_validation->run() == false) {

            $this->load->view('wrapper', $data);
        } else {
            $nama = htmlspecialchars($this->input->post('nama', true));
            $username = htmlspecialchars($this->input->post('username', true));
            $password = htmlspecialchars($this->input->post('password', true));
            $email = htmlspecialchars($this->input->post('email', true));
            $job = htmlspecialchars($this->input->post('job', true));
            $wa = htmlspecialchars($this->input->post('wa', true));
            $alamat = htmlspecialchars($this->input->post('alamat', true));
            $usr = [
                'nama' => $nama,
                'username' => $username,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'active' => 1,
                'role' => 2
            ];
            $user = $this->user->add_user($usr);
            $id = $this->db->insert_id($user);
            $dev = [
                'job' => $job,
                'wa' => $wa,
                'alamat' => $alamat,
                'user_id' => $id
            ];
            $this->user->add_devel($dev);
            pusher();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New Developer Added!</div>');
            redirect('admin/devel');
        }
    }

    public function editdevel($id)
    {
        $devel = $this->user->get_devel_byid($id);
        $data = [
            'title' => 'Edit Developer',
            'content' => '/admin/devel-edit',
            'devel' => $devel
        ];

        $this->form_validation->set_rules('nama', 'Full Name', 'trim|required');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|callback_username_check');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('job', 'Job', 'trim|required');
        $this->form_validation->set_rules('wa', 'Whatsapp', 'trim|required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
        if ($this->form_validation->run() == false) {

            $this->load->view('wrapper', $data);
        } else {
            $nama = htmlspecialchars($this->input->post('nama', true));
            $username = htmlspecialchars($this->input->post('username', true));
            // $password = htmlspecialchars($this->input->post('password', true));
            $email = htmlspecialchars($this->input->post('email', true));
            $job = htmlspecialchars($this->input->post('job', true));
            $wa = htmlspecialchars($this->input->post('wa', true));
            $alamat = htmlspecialchars($this->input->post('alamat', true));
            $usr = [
                'nama' => $nama,
                'username' => $username,
                'email' => $email,
                'active' => 1,
                'role' => 2
            ];
            $this->user->edit_user($id, $usr);
            $dev = [
                'job' => $job,
                'wa' => $wa,
                'alamat' => $alamat,
                'user_id' => $id
            ];
            $this->user->edit_devel($id, $dev);
            pusher();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Developer Edited!</div>');
            redirect('admin/devel');
        }
    }
    public function deldevel($id)
    {
        $this->user->del_dev($id);
        pusher();
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Developer Deleted!</div>');
        redirect('admin/devel', 'refresh');
    }

    // ====================================\\

    // Control halaman Client
    public function client()
    {
        $data = [
            'title' => 'Data Client',
            'content' => '/admin/client'
        ];
        $this->load->view('wrapper', $data);
    }
    public function dtclient()
    {
        $data = $this->user->get_all_client();
        echo json_encode($data);
    }

    // add
    public function addclient()
    {
        $data = [
            'title' => 'Add Client',
            'content' => '/admin/client-add'
        ];
        $this->form_validation->set_rules('nama', 'Full Name', 'trim|required');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|is_unique[user.username]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('perusahaan', 'Perusahaan', 'trim|required');
        $this->form_validation->set_rules('wa', 'Whatsapp', 'trim|required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
        if ($this->form_validation->run() == false) {

            $this->load->view('wrapper', $data);
        } else {
            $nama = htmlspecialchars($this->input->post('nama', true));
            $username = htmlspecialchars($this->input->post('username', true));
            $password = htmlspecialchars($this->input->post('password', true));
            $email = htmlspecialchars($this->input->post('email', true));
            $perusahaan = htmlspecialchars($this->input->post('perusahaan', true));
            $wa = htmlspecialchars($this->input->post('wa', true));
            $alamat = htmlspecialchars($this->input->post('alamat', true));
            $usr = [
                'nama' => $nama,
                'username' => $username,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'active' => 1,
                'role' => 3
            ];
            $user = $this->user->add_user($usr);
            $id = $this->db->insert_id($user);
            $cli = [
                'perusahaan' => $perusahaan,
                'wa' => $wa,
                'alamat' => $alamat,
                'user_id' => $id
            ];
            $this->user->add_client($cli);
            pusher();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New Client Added!</div>');
            redirect('admin/client');
        }
    }

    public function editclient($id)
    {
        $client = $this->user->get_client_byid($id);
        $data = [
            'title' => 'Edit clientoper',
            'content' => '/admin/client-edit',
            'client' => $client
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
            $this->user->edit_user($id, $usr);
            $cli = [
                'perusahaan' => $perusahaan,
                'wa' => $wa,
                'alamat' => $alamat,
                'user_id' => $id
            ];
            $this->user->edit_client($id, $cli);
            pusher();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Client Edited!</div>');
            redirect('admin/client');
        }
    }
    public function cpass($id)
    {
        $data = [
            'title' => 'Change Password',
            'content' => '/admin/cpass'
        ];

        $this->form_validation->set_rules('password', 'New Password', 'required|trim|min_length[3]|matches[password1]');
        $this->form_validation->set_rules('password1', 'Confirm New Password', 'required|trim|min_length[3]|matches[password]');
        if ($this->form_validation->run() == false) {
            $this->load->view('wrapper', $data);
        } else {
            $userku = $this->user->get_user_byid($id);
            $password = password_hash(htmlspecialchars($this->input->post('password', true)), PASSWORD_DEFAULT);
            $this->user->cpass($id, $password);
            pusher();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Password Updated</div>');

            if ($userku['role'] == 2) {
                redirect('admin/devel');
            } else if ($userku['role'] == 3) {
                redirect('admin/client');
            }
        }
    }
    public function delclient($id)
    {
        $this->user->del_client($id);
        pusher();
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Client Deleted!</div>');
        redirect('admin/client');
    }

    // ====================================\\

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
}
