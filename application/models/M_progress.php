<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_progress extends CI_Model
{
    public function get_progress()
    {
        $project = $this->db->get('project')->result_array();
        $data = [];
        $i = 0;
        $j = 0;
        foreach ($project as $pj) {
            $id = $pj['id'];
            // $id = 2;
            $data[$i]['idp'] = $pj['id'];
            $data[$i]['namap'] = $pj['nama'];
            $task = $this->db->query("SELECT COUNT(prjid) as total From task where prjid='$id'")->result_array();
            foreach ($task as $t) {
                $data[$i]['total'] = $t['total'];
            }
            $pgs = $this->db->query("SELECT COUNT(prj) as do FROM progress where prj='$id'")->result_array();
            foreach ($pgs as $p) {
                $data[$i]['do'] = $p['do'];
            }
            $i++;
        }
        return $data;
    }

    // Developer
    public function get_progressbydev($id)
    {
        $project = $this->db->query("SELECT * FROM project WHERE dsg='$id' OR fe='$id' OR be='$id'")->result_array();
        $dev = $this->session->userdata('id');
        $data = [];
        $i = 0;
        $j = 0;
        foreach ($project as $pj) {
            $id = $pj['id'];
            // $id = 2;
            $data[$i]['idp'] = $pj['id'];
            $data[$i]['namap'] = $pj['nama'];
            $task = $this->db->query("SELECT COUNT(prjid) as total From task where prjid='$id'")->result_array();
            foreach ($task as $t) {
                $data[$i]['total'] = $t['total'];
            }
            $pgs = $this->db->query("SELECT COUNT(prj) as do FROM progress where prj='$id' AND dev='$dev'")->result_array();
            foreach ($pgs as $p) {
                $data[$i]['do'] = $p['do'];
            }
            $i++;
        }
        return $data;
    }

    // update progress
    public function update_pgs($pgs)
    {
        $this->db->insert('progress', $pgs);
    }

    // Progress Client
    public function get_progressbycli($id)
    {
        $project = $this->db->query("SELECT * FROM project WHERE client='$id' ")->result_array();
        $data = [];
        $i = 0;
        $j = 0;
        foreach ($project as $pj) {
            $id = $pj['id'];
            // $id = 2;
            $data[$i]['idp'] = $pj['id'];
            $data[$i]['namap'] = $pj['nama'];
            $task = $this->db->query("SELECT COUNT(prjid) as total From task where prjid='$id'")->result_array();
            foreach ($task as $t) {
                $data[$i]['total'] = $t['total'];
            }
            $pgs = $this->db->query("SELECT COUNT(prj) as do FROM progress where prj='$id'")->result_array();
            foreach ($pgs as $p) {
                $data[$i]['do'] = $p['do'];
            }
            $i++;
        }
        return $data;
    }
}
