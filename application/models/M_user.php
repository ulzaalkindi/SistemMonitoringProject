<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_user extends CI_Model
{

    // Add Data User
    public function get_user_byid($id)
    {
        return $this->db->get_where('user', ['id' => $id])->row_array();
    }
    public function add_user($usr)
    {
        $this->db->insert('user', $usr);
    }
    public function edit_user($id, $usr)
    {
        $this->db->where('id', $id);
        $this->db->update('user', $usr);
    }
    public function cpass($id, $password)
    {
        $this->db->where('id', $id);
        $this->db->set('password', $password);
        $this->db->update('user');
    }


    // Data Devel
    public function get_all_devel()
    {
        return $this->db->join('devel', 'devel.user_id=user.id')->get_where('user', ['role' => 2])->result();
    }
    public function get_devel_dsg()
    {
        return $this->db->query('SELECT * FROM user u join devel d on u.id=d.user_id WHERE u.role=2 AND d.job=1')->result_array();
    }
    public function get_devel_fe()
    {
        return $this->db->query('SELECT * FROM user u join devel d on u.id=d.user_id WHERE u.role=2 AND d.job=2')->result_array();
    }
    public function get_devel_be()
    {
        return $this->db->query('SELECT * FROM user u join devel d on u.id=d.user_id WHERE u.role=2 AND d.job=3')->result_array();
    }
    public function add_devel($dev)
    {
        $this->db->insert('devel', $dev);
    }
    public function edit_devel($id, $dev)
    {
        $this->db->where('user_id', $id);
        $this->db->update('devel', $dev);
    }
    public function get_devel_byid($id)
    {
        return $this->db->join('devel', 'devel.user_id=user.id')->get_where('user', ['user.id' => $id])->row_array();
    }
    public function del_dev($id)
    {
        $this->db->where('user_id', $id);
        $this->db->delete('devel');
        $this->db->where('id', $id);
        $this->db->delete('user');
    }
    public function dev_profile($id)
    {
        return $this->db->join('devel', 'devel.user_id=user.id')->get_where('user', ['id' => $id])->row_array();
    }

    // Data Client

    public function get_all_client()
    {
        return $this->db->join('client', 'client.user_id=user.id')->get_where('user', ['role' => 3])->result();
    }
    public function get_client_byid($id)
    {
        return $this->db->join('client', 'client.user_id=user.id')->get_where('user', ['user.id' => $id])->row_array();
    }
    public function add_client($cli)
    {
        $this->db->insert('client', $cli);
    }
    public function edit_client($id, $cli)
    {
        $this->db->where('user_id', $id);
        $this->db->update('client', $cli);
    }
    public function del_client($id)
    {
        $this->db->where('user_id', $id);
        $this->db->delete('client');
        $this->db->where('id', $id);
        $this->db->delete('user');
    }

    public function cli_profile($id)
    {
        return $this->db->join('client', 'client.user_id=user.id')->get_where('user', ['id' => $id])->row_array();
    }

    // ======================\\
}
