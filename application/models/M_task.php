<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_task extends CI_Model
{
    public function get_taskbyprj($prj, $dev)
    {

        // return $this->db->get_where('task', ['prjid' => $prj])->result();
        $task = $this->db->get_where('task', ['prjid' => $prj])->result_array();
        $data = [];
        $i = 0;
        $j = 0;
        foreach ($task as $t) {
            $id = $t['id'];
            // $id = 2;
            $data[$i]['idtsk'] = $t['id'];
            $data[$i]['nama_task'] = $t['nama'];
            $data[$i]['ket_task'] = $t['keterangan'];
            $pgs = $this->db->query("SELECT * FROM progress where tsk='$id' AND dev='$dev'");
            $data[$i]['done'] = $pgs->num_rows() > 0;
            $i++;
        }
        return $data;
    }
}
