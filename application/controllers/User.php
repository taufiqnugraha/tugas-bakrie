<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!isset($_SESSION['id_login'])) {
            redirect('login');
        }
        $this->load->model('Model_master', 'master');
    }

    public function index() 
    {
        $data['javascript'] = 'access.js';
        $data['user'] = $this->master->get_user();
        $data['menu'] = $this->master->get_menu();

        foreach ($data['menu'] as $key => $res) {
          $menu_id = $data['menu'][$key]['menu_id'];
          $submenu = $this->master->get_submenu($menu_id);
          $data['menu'][$key]['submenu'] = $submenu;
        }

        $this->template->load('template', 'master/access-user', $data);
    }

    public function detail($user_id)
    {
      $user_id = decrypt_url($user_id);

      $data['javascript'] = 'access.js';
      $data['user'] = $this->master->get_user();
      $data['menu'] = $this->master->get_menu();
      $data['useredit'] = $this->master->get_userid($user_id);
      $access = $this->master->get_access($user_id);
      $menu_access = $this->master->get_accessmenu($user_id);
      
      $row = array();
      $i=1;
      foreach($menu_access as $rs){
        $row[$i] = $rs['menu_id'];
        $i++;
      }
      $data['menu_access'] = $row;

      $row_access = array();
      $i=1;
      foreach($access as $rs){
        $row_access[$i] = $rs['submenu_id'];
        $i++;
      }
      $data['access'] = $row_access;

      foreach ($data['menu'] as $key => $res) {
        $menu_id = $data['menu'][$key]['menu_id'];
        $submenu = $this->master->get_submenu($menu_id);
        $data['menu'][$key]['submenu'] = $submenu;
      }

      $this->template->load('template', 'master/access-detail', $data);
    }

    public function add_access(){
      $data = $this->input->post();

      $timestamp = date("Y-m-d H:i:s");
      $this->db->set('username', $data['username']);
      $this->db->set('fullname', $data['fullname']);
      $this->db->set('password', sha1(md5($data['password'])));
      $this->db->set('email', $data['email']);
      $this->db->set('input_date', date('Y-m-d H:i:s'));
      $this->db->set('user_type', $data['role']);
      $this->db->insert('tbl_login');
      $userID = $this->db->insert_id();

      foreach ($data['submenu'] as $ls) {
        $menu_id = $this->master->get_menuid($ls);

        $this->db->set('id_login', $userID);
        $this->db->set('menu_id', $menu_id);
        $this->db->set('submenu_id', $ls);
        $this->db->set('input_date', date('Y-m-d H:i:s'));
        $this->db->insert('tbl_access');
      }
    }

    public function update_access()
    {
      $data = $this->input->post();

      $id_login = decrypt_url($data['id_login']);
      
      $this->db->set('username', $data['username']);
      $this->db->set('fullname', $data['fullname']);
      if($data['password'] != ''){
        $this->db->set('password', sha1(md5($data['password'])));
      }
      $this->db->set('email', $data['email']);
      $this->db->set('flag', $data['flag']);
      $this->db->set('update_date', date('Y-m-d h:i:s'));
      $this->db->set('user_type', $data['role']);
      $this->db->where('id_login',$id_login);
      $this->db->update('tbl_login');

      $this->db->delete('tbl_access',array('id_login' => $id_login));

      foreach ($data['submenu'] as $ls) {
        $menu_id = $this->master->get_menuid($ls);

        $this->db->set('id_login', $id_login);
        $this->db->set('menu_id', $menu_id);
        $this->db->set('submenu_id', $ls);
        $this->db->set('input_date', date('Y-m-d h:i:s'));
        $this->db->insert('tbl_access');
      }
    }

    public function check_account(){
      $username = $this->input->post('username');

      $check  = $this->db->query('select username from tbl_login where (username = "'. $username .'" OR email = "'. $username .'")')->num_rows();
      if($check > 0){
        $result = array('status'  => false, 'message' => 'user exist');
      } else {
        $result = array('status'  => true, 'message' => 'user not exist');
      }
      echo json_encode($result);
    }
}
