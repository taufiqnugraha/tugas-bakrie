<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_employee extends CI_Model
{
    var $search_emp = array('emp_fullname', 'nik');
    var $order_emp = array('emp_fullname', 'nik');

    public function _get_data_emp(){
        $this->db->select('tbl_emp.*, m_city.name');
        $this->db->from('tbl_emp')
        ->join('m_city', 'm_city.id = tbl_emp.emp_bop');

        $i = 0;
        if (isset($_POST['search']) and !empty($_POST['search'])) {
            foreach ($this->search_emp as $item) {
                if (($_POST['search'])) {
                    if ($i === 0) {
                        $this->db->group_start();
                        $this->db->like($item, $this->security->xss_clean(strtolower($this->input->post('search'))));
                    } else {
                        $this->db->or_like($item, $this->security->xss_clean(strtolower($this->input->post('search'))));
                    }

                    if (count($this->search_emp) - 1 == $i)
                        $this->db->group_end();
                }
                $i++;
            }
        }
        if (isset($_POST['order'])) {
            $this->db->order_by($this->order_emp[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $order = array('nik' => 'desc');
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function get_data_emp(){
        $this->_get_data_emp();
        if ($_POST['length'] != -1) {
            $this->db->limit(10, $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function records_filter_emp(){
        $this->_get_data_emp();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function records_total_emp(){
        $this->db->select('*');
        $this->db->from('tbl_emp');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function detail_emp($nik){
        $data = $this->db
        ->select('tbl_emp.*, m_city.name')
        ->join('m_city', 'm_city.id = tbl_emp.emp_bop', 'left')
        ->where('nik', $nik)
        ->from('tbl_emp')
        ->get();
        return $data->row();
    }

    public function import($records) {
        $this->db->insert_batch('tbl_emp', $records);
        foreach($records as $r) {

            $this->db->set('username',  $r['nik']);
            $this->db->set('fullname', $r['emp_fullname']);
            $this->db->set('password', sha1(md5('P4ssw0rd')));
            $this->db->set('email', $r['nik'].'@gmail.com');
            $this->db->set('input_date', date('Y-m-d H:i:s'));
            $this->db->set('user_type', 2);
            $this->db->insert('tbl_login');
            $userID = $this->db->insert_id();

            $this->db->set('id_login', $userID);
            $this->db->set('menu_id', 1);
            $this->db->set('submenu_id', 8);
            $this->db->set('input_date', date('Y-m-d H:i:s'));
            $this->db->insert('tbl_access');
        }
        return true;
    }
}
