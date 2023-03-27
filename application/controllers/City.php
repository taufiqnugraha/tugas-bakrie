<?php
defined('BASEPATH') or exit('No direct script access allowed');

class City extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    if (!isset($_SESSION['id_login'])) {
      redirect('login');
    }
    $this->load->model('Model_master', 'master');
  }

  public function get_city(){
    $search = $this->input->get('search') ? $this->input->get('search') : 'a' ;
    $cities = $this->master->get_city($search);

    // $option = '<option value="">Pilih Unit of Measurement</option>';
    // foreach($cities as $city){
    //   $option .= '<option value="'. $city->id  .'">'. $city->name .'</option>';
    // }

    // if(!empty($cities)){
    //   $result = array('status'  => true, 'message' => $option);
    // } else {
    //   $result = array('status'  => false, 'message' => $option);
    // }
    echo json_encode($cities);
  }


}
