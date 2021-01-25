<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function index()
    {
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if ($this->form_validation->run() == false) {
            $this->load->view('auth/index');
        } else {
            $this->_login();
        }
    }
    private function _login()
    {
        $username = $this->input->post('username', true);
        $password = $this->input->post('password', true);
        $user = $this->db->get_where('user', ['username' => $username])->row_array();
        if ($user) {
            if ($user['active'] == 1) {
                if (password_verify($password, $user['password'])) {
                    $data =  [
                        'id' => $user['id'],
                        'username' => $user['username'],
                        'nama' => $user['nama'],
                        'role' => $user['role']
                    ];
                    $this->session->set_userdata($data);
                    if ($user['role'] == 1) {
                        redirect('admin');
                    } else if ($user['role'] == 2) {
                        redirect('devel');
                    } else if ($user['role'] == 3) {
                        redirect('client');
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Wrong password!</div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">User not activated!</div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Wrong username!</div>');
            redirect('auth');
        }
    }
    public function logout()
    {
        $this->session->unset_userdata('id');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('nama');
        $this->session->unset_userdata('role');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">You have been logged out!</div>');
        redirect('auth');
    }
}
