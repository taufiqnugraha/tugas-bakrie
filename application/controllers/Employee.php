<?php
defined('BASEPATH') or exit('No direct script access allowed');
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Employee extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    if (!isset($_SESSION['id_login'])) {
      redirect('login');
    }
    $this->load->model('Model_employee', 'emp');
  }

  public function index()
  {
    $data['javascript'] = 'master/employee.js';
    $this->template->load('template', 'master/employee', $data);
  }

  public function get_data_emp()
  {
    $list = $this->emp->get_data_emp();

    $data = array();
    $no = $_POST['start'];

    foreach ($list as $ls) {
      $no++;
      $row = array();
      $flag = '<button type="button" class="btn btn-success btn-rounded waves-effect waves-light">Active</button>';
      $btnFlag = '<i data-id="'. encrypt_url($ls['nik']) .'" data-flag="'. encrypt_url($ls['nik']) .'" title="Delete" class="mdi mdi-close cursor-pointer font-size-20 text-danger me-1 btn-inactive-emp"></i>';
      $row[] = $ls['nik'] == '' ? '-' : $ls['nik'];
      $row[] = $ls['emp_fullname'];
      $row[] = $ls['emp_sex'] == '1' ? 'Laki-laki' : 'Perempuan';
      $row[] = $ls['name'] . ','. $ls['emp_dob'] ;
      $row[] = '<i data-id="'. encrypt_url($ls['nik']) .'" title="Update Emp" class="mdi mdi-pencil cursor-pointer font-size-20 text-info me-1 btn-update-emp"></i>
        '. $btnFlag .'
        ';

      $data[] = $row;
    }

    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->emp->records_total_emp(),
      "recordsFiltered" => $this->emp->records_filter_emp(),
      "data" => $data,
    );
    echo json_encode($output);
  }

  public function add_emp()
  {
    $data = $this->input->post();
    $this->load->library('form_validation');
    $this->form_validation->set_rules('nik', 'Nik', 'required|trim|is_unique[tbl_emp.nik]|min_length[8]|max_length[15]');
    $this->form_validation->set_rules('full_name', 'Full Name', 'required');
    $this->form_validation->set_rules('city', 'Kota Kelahiran', 'required');
    if($this->form_validation->run() == FALSE)
    {
        $errors = validation_errors();
        $result = array('status'  => false, 'message' => $errors);
    } else {
        $emp = array(
        'nik' => $data['nik'],
        'emp_fullname' => $data['full_name'],
        'emp_called' => $data['called_name'],
        'emp_sex' => $data['jenis_kelamin'],
        'emp_bop' => $data['city'],
        'emp_dob' => $data['start_date'],
        'status' => 1
        );

        if($this->db->insert('tbl_emp', $emp)){
            $this->db->set('username',  $data['nik']);
            $this->db->set('fullname', $data['full_name']);
            $this->db->set('password', sha1(md5('P4ssw0rd')));
            $this->db->set('email', $data['nik'].'@gmail.com');
            $this->db->set('input_date', date('Y-m-d H:i:s'));
            $this->db->set('user_type', 2);
            $this->db->insert('tbl_login');
            $userID = $this->db->insert_id();

            $this->db->set('id_login', $userID);
            $this->db->set('menu_id', 1);
            $this->db->set('submenu_id', 8);
            $this->db->set('input_date', date('Y-m-d H:i:s'));
            $this->db->insert('tbl_access');
            $result = array('status'  => true, 'message' => 'success add employee dan user');
        } else {
            $result = array('status'  => false, 'message' => 'failed add employee dan user');
        }
    }

    echo json_encode($result);
  }

  public function get_detail_emp(){
    $data = $this->input->post();
    $uom = $this->emp->detail_emp(decrypt_url($data['id']));
    echo json_encode($uom);
  }

  public function update_emp(){

    $data = $this->input->post();
    $this->load->library('form_validation');
    $this->form_validation->set_rules('full_name', 'Full Name', 'required');
    if($this->form_validation->run() == FALSE)
    {
        $errors = validation_errors();
        $result = array('status'  => false, 'message' => $errors);
        echo json_encode($result);
        die;
    } else {
        $emp = array(
        'emp_fullname' => $data['full_name'],
        'emp_called' => $data['called_name'],
        'emp_sex' => $data['jenis_kelamin'],

        'emp_dob' => $data['start_date'],
        'status' => 1
        );
        if( isset($data['city'])) {
            $emp['data_bop'] = $data['city'];
        }
        $this->db->update('tbl_emp', $emp, array('nik' => $data['_id_nik']));
        $result = array('status'  => true, 'message' => 'success add emp');

    }
    $result = array('status'  => true, 'message' => 'success update emp');

    echo json_encode($result);
  }

  public function import_data() {
    $path 		= 'documents/users/';
    $json 		= [];
    $this->upload_config($path);
    if (!$this->upload->do_upload('file')) {
        $json = [
            'error_message' => showErrorMessage($this->upload->display_errors()),
        ];
    } else {
        $file_data 	= $this->upload->data();
        $file_name 	= $path.$file_data['file_name'];
        $arr_file 	= explode('.', $file_name);
        $extension 	= end($arr_file);
        if('csv' == $extension) {
            $reader 	= new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        } else {
            $reader 	= new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }
        $spreadsheet 	= $reader->load($file_name);
        $sheet_data 	= $spreadsheet->getActiveSheet()->toArray();
        $list 			= [];
        $user           = [];
        foreach($sheet_data as $key => $val) {
            if($key != 0) {
                $result 	= $this->emp->detail_emp($val[0]);
                if($result) {
                    $json = [
                        'status' => false,
                        'message' 	=> "Ada nik ganda ". $val[0] . " pada line ". ($key),
                    ];
                    echo json_encode($json);
                    die;
                } else {
                    $city = $this->db->where('name', $val[3])->from('m_city')->get()->row();
                    if($city) {
                        $list [] = [
                            'nik'					=> $val[0],
                            'emp_fullname'			=> $val[1],
                            'emp_called'		    => $val[2],
                            'emp_bop'				=> $city->id,
                            'emp_dob'				=> date('Y-m-d',strtotime($val[4])),
                            'emp_sex'			    => $val[5] == 'Perempuan'? 2 : 1,
                            'status'				=> "1",
                        ];

                    } else {
                        $json = [
                            'status' => false,
                            'message' 	=> "Ada kota kelahiran yang tidak ditemukan dengan value ". $val[3] . " pada line ". ($key),
                        ];
                        echo json_encode($json);
                        die;
                    }
                }
            }
        }
        if(file_exists($file_name))
            unlink($file_name);

        if(count($list) > 0) {
            $result 	= $this->emp->import($list);
            if($result) {
                $json = [
                    'status' => true,
                    'message' 	=> "Semua data berhasil di Import",
                ];
            } else {
                $json = [
                    'status' => false,
                    'message' 	=> "Oops Something wrong"
                ];
            }
        } else {
            $json = [
                'status' => false,
                'message' => "Tidak ada record yang ditambahkan!. Kemungkinan Duplikat data nik atau kota kelahiran tidak ditemukan",
            ];
        }
    }
    echo json_encode($json);
    }

    public function upload_config($path) {
        if (!is_dir($path))
            mkdir($path, 0777, TRUE);
        $config['upload_path'] 		= './'.$path;
        $config['allowed_types'] 	= 'csv|CSV|xlsx|XLSX|xls|XLS';
        $config['max_filename']	 	= '255';
        $config['encrypt_name'] 	= TRUE;
        $config['max_size'] 		= 4096;
        $this->load->library('upload', $config);
    }

    public function delete($nik)
    {
        $nik = decrypt_url($nik);
        $this->db->where('nik', $nik);
        if($this->db->delete('tbl_emp')) {
            $this->db->where('username', $nik);
            $user = $this->db->get('tbl_login')->row();
            if($user) {
                $user_id = $user->id_login;
                $this-> db->where('id_login', $user_id);
                 if($this->db->delete('tbl_login')) {
                    $this-> db->where('id_login', $user_id);
                    $this->db->delete('tbl_access');
                }
            }
        }

        $json = [
            'status' => true,
            'message' => "Data Berhasil di delete",
        ];

        echo json_encode($json);
    }
}
