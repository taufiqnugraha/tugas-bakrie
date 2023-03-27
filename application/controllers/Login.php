<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_login', 'm_login');
    }

    public function index()
    {
        if (isset($_SESSION['id_login'])) {
            redirect('dashboard');
        }
        $this->load->view('login');
    }

    public function submit()
    {
        $username = $this->security->xss_clean($this->input->post('username'));
        $password =  $this->security->xss_clean($this->input->post('password'));

        $status = $this->m_login->user($username, $password);
        if ($status == false) {
            $result = array('status'  => 'error', 'reason' => false);
        } elseif ($status == 'blocked') {
            $result = array('status'  => 'error', 'reason' => 'blocked');
        } else {
            $result = array('status'  => 'success', 'reason' => true);
        }
        echo json_encode($result);
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }
}
