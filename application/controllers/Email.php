<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Email extends CI_Controller
{
    public function index()
    {
        echo date("s", time());
        echo '
        ';
        // echo time();
        // echo sizeof(check_notif());
        // var_dump(check_notif());
        // _sendEmail('Menjadi orang', 'brokerjays6@gmail.com', 'admin');
        // $oke = $this->db->query("SELECT * FROM tsk where t_id=1")->row_array();
        // $data = $this->db->query("SELECT (SUM(t_stat)/count(prj_id))*100 as pgs from tsk where prj_id=1")->row_array();
        // $pid = $oke['prj_id'];
        // $prj = $this->db->query("SELECT * from prj where prj_id='$pid'")->row_array();
        // $clid = $prj['cli_id'];
        // $client = $this->db->query("SELECT * FROM client where cl_id=$clid")->row_array();
        // echo '<br>';
        // var_dump($client);
        // echo '<br>';
        // echo $oke['prj_id'];
        // echo '<br>';
        // echo round($data['pgs']);

        // $query = "SELECT * FROM tsk t join prj p on t.prj_id=p.prj_id join client c on p.cli_id=c.cl_id where t.t_id=1";
        // $data = $this->db->query($query)->row_array();
        // echo json_encode($data);
        // $t_id = 1;
        // $query = "SELECT * FROM tsk t join prj p on t.prj_id=p.prj_id join client c on p.cli_id=c.cl_id where t.t_id='$t_id'";
        // $client = $this->db->query($query)->row_array();
        // $prj = $client['prj_name'];
        // $email = $client['cl_email'];
        // echo $prj;
        // echo '<br>';
        // echo $email;
        //     $config = [
        //         'protocol' => 'smtp',
        //         'smtp_host' => 'smtp.gmail.com',
        //         'smtp_user' => 'deriatmaja12@gmail.com',
        //         'smtp_pass' => 'DeriAtmaja@12',
        //         'smtp_crypto' => 'tls',
        //         'smtp_port' => '587',
        //         'mailtype' => 'html',
        //         'charset' => 'utf-8',
        //         'newline' => "\r\n"
        //     ];


        //     $this->load->library('email', $config);
        //     $this->email->initialize($config);
        //     $this->email->subject('Tugas Project');
        //     $this->email->message('test');
        //     $this->email->attach(base_url('assets/upload/default.jpg'));
        //     $this->email->from('deriatmaja12@gmail.com', 'SISTEM MONITORING MIB');
        //     $this->email->to('brokerjays6@gmail.com');
        //     $this->email->send();

        //     // if ($name == 'admin') {

        //     //     $this->email->subject('Tugas Project');
        //     //     $this->email->message('Anda mendapat tugas <h1>' . $judul . '</h1> Pada Project<b> ' . $prj . '<b> Selamat mengerjakan.');
        //     // } else if ($name == 'developer') {

        //     //     $this->email->subject($prj);
        //     //     $this->email->message($judul);
        //     // }

        //     // if ($this->email->send()) {
        //     //     echo 'message sent';
        //     // } else {
        //     //     echo $this->email->print_debugger();
        //     //     die;
        //     // }
        // }
        // public function email()
        // {
        //     $this->db->get_where('user', ['email' => 'ulzaalkindi@gmail.com'])->result();
    }
}
