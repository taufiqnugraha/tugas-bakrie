<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_login extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function user($username, $password){
        $password = sha1(md5($password));
        $dateNow = date('Y-m-d H:i:s');

        $this->db->select('*');
        $this->db->from('tbl_login');
        $this->db->where("(username = '$username' AND password = '$password') OR (email = '$username' AND password = '$password')");
        $query = $this->db->get();
        $hasil= $query->row_array();

        if($query->num_rows() > 0) { //cek num_rows
            if($hasil['flag'] == 1){
                $session = array(
                    'id_login'      => $hasil['id_login'],
                    'username'      => $hasil['username'],
                    'email'         => $hasil['email'],
                    'fullname'      => $hasil['fullname'],
                    'user_type'     => $hasil['user_type'],
                );
                $this->session->set_userdata($session);
                return $session;
            } else {
                return 'blocked';
            }
        } else {
            return false;
        }
    }
}
