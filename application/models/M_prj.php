<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_prj extends CI_Model
{
    public function get_project_byclient($id)
    {
        return $this->db->get_where('project', ['client' => $id])->result();
    }
    public function get_page_byproject($id)
    {
        return $this->db->get_where('page', ['prj_id' => $id])->result();
    }
    public function add_project($prj)
    {
        $this->db->insert('project', $prj);
    }
    public function get_prj_byid($idprj)
    {
        return $this->db->get_where('project', ['id' => $idprj])->row_array();
    }
    public function edit_project($idproject, $prj)
    {
        $this->db->where('id', $idproject);
        $this->db->update('project', $prj);
    }
    public function del_project($id)
    {
        $idpage = $this->db->get_where('page', ['prj_id' => $id])->result_array();
        foreach ($idpage as $idp) {
            $this->db->where('pg_id', $idp['id']);
            $this->db->delete('task');
        }
        $this->db->where('prj_id', $id);
        $this->db->delete('page');
        $this->db->where('id', $id);
        $this->db->delete('project');
    }
    public function get_page_byidpage($idpg)
    {
        return $this->db->get_where('page', ['id' => $idpg])->row_array();
    }
    public function add_page($pg)
    {
        $this->db->insert('page', $pg);
    }
    public function edit_page($idpage, $pg)
    {
        $this->db->where('id', $idpage);
        $this->db->update('page', $pg);
    }
    public function del_page($idpg)
    {
        $this->db->where('pg_id', $idpg);
        $this->db->delete('task');

        $this->db->where('id', $idpg);
        $this->db->delete('page');
    }
    public function get_task_bypage($id)
    {
        return $this->db->get_where('task', ['pg_id' => $id])->result();
    }
    public function add_task($tsk)
    {
        $this->db->insert('task', $tsk);
    }
    public function get_task_byid($idt)
    {
        return $this->db->get_where('task', ['id' => $idt])->row_array();
    }
    public function edit_task($idtask, $tsk)
    {
        $this->db->where('id', $idtask);
        $this->db->update('task', $tsk);
    }
    public function del_task($idtsk)
    {
        $this->db->where('id', $idtsk);
        $this->db->delete('task');
    }
}
