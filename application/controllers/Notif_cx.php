<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notif_cx extends CI_Controller
{

    function pusher()
    {
        require  APPPATH . '/views/vendor/autoload.php';
        $options = array(
            'cluster' => 'ap1',
            'useTLS' => true
        );
        $pusher = new Pusher\Pusher(
            '69a99071d426944894ee',
            'ec3017f3d1a002be9a09',
            '971391',
            $options
        );

        $data['message'] = 'success';
        $pusher->trigger('my-channel', 'my-event', $data);
    }

    function check_notif() //fungsi untuk check notifikasi
    {

        $user = $this->session->userdata('id');
        return $this->db->select('n.*,u.nama')->from('notif n')
            ->join('user u', 'u.id = n.usr', 'left')
            ->where(['n.usr' => $user, 'baca' => 0])->get()->result_array();
    }

    function send_notif($usr, $pesan)
    {

        $in = [
            'pesan' => $pesan,
            'baca' => 0,
            'usr' => $usr
        ];
        $this->db->insert('notif', $in);
    }
    public function send_task_to_dev()
    {
        $id = $this->input->post('id');
        $project = $this->db->get_where('project', ['id' => $id])->row_array();
        $desainer = $this->db->get_where('user', ['id' => $project['dsg']])->row_array();
        $dsg_email = $desainer['email'];
        $frontend = $this->db->get_where('user', ['id' => $project['fe']])->row_array();
        $fe_email = $frontend['email'];
        $backend = $this->db->get_where('user', ['id' => $project['be']])->row_array();
        $be_email = $backend['email'];

        $namaProject = $project['nama'];
        $subject = "NEW PROJECT $namaProject";
        $pesan = "Project Baru untuk anda, mohon untuk dikerjakan, tertanda Admin MIB";

        $this->db->where('id', $id);
        $this->db->set('done', 1);
        $this->db->update('project');
        $notif = $subject;

        send_emailbro($subject, $pesan, $dsg_email); //kirim notifikasi email ke desainer
        send_emailbro($subject, $pesan, $fe_email); //kirim notifikasi email ke frontend
        send_emailbro($subject, $pesan, $be_email); //kirim notifikasi email ke backend


        $this->send_notif($project['dsg'], $notif); //kirim notifikasi ke desainer
        $this->send_notif($project['fe'], $notif); // kirim notifikasi ke frontend
        $this->send_notif($project['be'], $notif); // kirim notifikasi ke backend

        $this->pusher(); // kirim pusher websocket
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
        $client = $not['client'];
        $this->send_notif(1, $notif); //send notif ke project manager
        $this->send_notif($client, $notif); // send notif ke client
        $this->pusher();
    }

    public function add_evaluasi($id, $tsk)
    {
        $data = [
            'title' => 'Add Evaluasi',
            'content' => '/client/evaluasi-add',
            'id' => $id,
            'tsk' => $tsk
        ];

        $this->form_validation->set_rules('keterangan', 'Evaluasi', 'trim|required');

        if ($this->form_validation->run() == false) {
            $this->load->view('wrapper', $data);
        } else {

            $tskid = htmlspethisalchars($this->input->post('tsk', true));
            $keterangan = htmlspethisalchars($this->input->post('keterangan', true));
            $task = [
                // 'job' => $job,
                'tskid' => $tskid,
                'ket' => $keterangan
            ];
            $this->eva->add_evaluasi($task);

            $prj = $this->db->query("SELECT p.nama as prj_name,t.* FROM task t join project p on t.prjid=p.id")->row_array();
            $this->send_notif(1, "New Evaluasi " . $prj['prj_name']); //send notif ke admin

            $this->pusher(); // kirim pusher
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New Evaluasi Added!</div>');
            redirect('client/evaluasifunc/' . $id . '/' . $tsk);
        }
    }
}
