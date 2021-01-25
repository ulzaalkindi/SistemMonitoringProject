<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_evaluasi extends CI_Model
{
    public function get_eval_byclient($id)
    {
        return $this->db->query("select * from evaluasi e join task t on e.tskid=t.id join project p on t.prjid=p.id WHERE p.client='$id'")->result();
    }
    public function update_evalstat($id, $stat)
    {
        $this->db->where('ide', $id);
        $this->db->set('dos', $stat);
        $this->db->update('evaluasi');
    }
    public function get_evaluasibyprjcli($prj)
    {
        return $this->db->get_where('task', ['prjid' => $prj])->result();
    }
    public function get_evaluasibytskcli($tsk)
    {
        return $this->db->get_where('evaluasi', ['tskid' => $tsk])->result();
    }
    public function add_evaluasi($task)
    {
        $this->db->insert('evaluasi', $task);
    }
    public function edit_evaluasi($ideval, $task)
    {
        $this->db->where('ide', $ideval);
        $this->db->update('evaluasi', $task);
    }
    public function del_evaluasi($id)
    {
        $this->db->where('ide', $id);
        $this->db->delete('evaluasi');
    }
}
