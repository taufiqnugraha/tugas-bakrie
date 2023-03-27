<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_master extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_user(){
        $data = $this->db->get('tbl_login');
        return $data->result_array();
    }


    public function get_userid($id){
        $data = $this->db->get_where('tbl_login',array('id_login' => $id));
        return $data->row_array();
    }

    public function get_menu(){
        $this->db->order_by('orderkey','asc');
        $data = $this->db->get_where('tbl_menu', array('flag' => 1));
        return $data->result_array();
    }

    public function get_submenu($id){
        $this->db->order_by('orderkey','asc');
        $data = $this->db->get_where('tbl_submenu',array('flag' => 1, 'menu_id' => $id));
        return $data->result_array();
    }

    public function get_menuid($id){
        $this->db->select('menu_id');
        $data = $this->db->get_where('tbl_submenu',array('flag' => 1, 'submenu_id' => $id));
        $hasil = $data->row_array();
        return $hasil['menu_id'];
    }

    public function get_access($id){
        $data = $this->db->get_where('tbl_access',array('id_login' => $id));
        return $data->result_array();
    }

    public function get_accessmenu($id){
        $this->db->group_by('menu_id');
        $this->db->select('menu_id');
        $data = $this->db->get_where('tbl_access',array('id_login' => $id));
        return $data->result_array();
    }

    public function get_city($search)
    {
        $this->db->select('a.name, a.id');
        $this->db->from('m_city a');
        $this->db->like('a.name', $search);
        $query = $this->db->limit(10)->get();
        return $query->result();
    }
}
