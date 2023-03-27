<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('tanggal_indo')) {
    function tanggal_indo($date, $format)
    {
        $jam = substr($date, 11, 5);

        $date = date('Y-m-d', strtotime($date));
        if ($date == '0000-00-00')
            return 'Tanggal Kosong';

        $tgl = substr($date, 8, 2);
        $bln = substr($date, 5, 2);
        $thn = substr($date, 0, 4);

        switch ($bln) {
            case 1: {
                    $bln = '01';
                }
                break;

            case 2: {
                    $bln = '02';
                }
                break;

            case 3: {
                    $bln = '03';
                }
                break;

            case 4: {
                    $bln = '04';
                }
                break;

            case 5: {
                    $bln = '05';
                }
                break;

            case 6: {
                    $bln = "06";
                }
                break;

            case 7: {
                    $bln = '07';
                }
                break;

            case 8: {
                    $bln = '08';
                }
                break;

            case 9: {
                    $bln = '09';
                }
                break;

            case 10: {
                    $bln = '10';
                }
                break;

            case 11: {
                    $bln = '11';
                }
                break;

            case 12: {
                    $bln = '12';
                }
                break;

            default: {
                    $bln = 'UnKnown';
                }
                break;
        }

        $hari = date('N', strtotime($date));
        switch ($hari) {
            case 7: {
                    $hari = 'Minggu';
                }
                break;

            case 1: {
                    $hari = 'Senin';
                }
                break;

            case 2: {
                    $hari = 'Selasa';
                }
                break;

            case 3: {
                    $hari = 'Rabu';
                }
                break;

            case 4: {
                    $hari = 'Kamis';
                }
                break;

            case 5: {
                    $hari = "Jum'at";
                }
                break;

            case 6: {
                    $hari = 'Sabtu';
                }
                break;

            default: {
                    $hari = 'UnKnown';
                }
                break;
        }

        if ($format == 'date') {
            $tanggalIndonesia = $tgl . " " . bulan_indo($bln) . " " . $thn;
        } elseif ($format == 'month') {
            $tanggalIndonesia = bulan_indo($bln) . " " . $thn;
        } elseif ($format == 'datetime') {
            $tanggalIndonesia = $tgl . " " . bulan_indo($bln) . " " . $thn . ", " . $jam;
        } elseif ($format == 'time') {
            $tanggalIndonesia = $jam;
        } elseif ($format == 'fulldate') {
            $tanggalIndonesia = $hari . ", " . $tgl . " " . bulan_indo($bln) . " " . $thn;
        } else {
            $tanggalIndonesia = $hari . ", " . $tgl . " " . bulan_indo($bln) . " " . $thn . ", " . $jam;
        }

        return $tanggalIndonesia;
    }
}

if (!function_exists('bulan_indo')) {
    function bulan_indo($bulan)
    {
        switch ($bulan) {
            case 1: {
                    $bulan = 'Januari';
                }
                break;
            case 2: {
                    $bulan = 'Februari';
                }
                break;
            case 3: {
                    $bulan = 'Maret';
                }
                break;
            case 4: {
                    $bulan = 'April';
                }
                break;
            case 5: {
                    $bulan = 'Mei';
                }
                break;
            case 6: {
                    $bulan = "Juni";
                }
                break;
            case 7: {
                    $bulan = 'Juli';
                }
                break;
            case 8: {
                    $bulan = 'Agustus';
                }
                break;
            case 9: {
                    $bulan = 'September';
                }
                break;
            case 10: {
                    $bulan = 'Oktober';
                }
                break;
            case 11: {
                    $bulan = 'November';
                }
                break;
            case 12: {
                    $bulan = 'Desember';
                }
                break;
            default: {
                    $bulan = 'UnKnown';
                }
                break;
        }
        return $bulan;
    }
}

if (!function_exists('triwulan')) {
    function triwulan($bulan)
    {
        if ($bulan < 4) {
            return 1;
        } else if ($bulan < 7) {
            return 2;
        } else if ($bulan < 10) {
            return 3;
        } else {
            return 4;
        }
    }
}

if (!function_exists('format_rupiah')) {
    function format_rupiah($money)
    {
        return 'Rp. ' . number_format($money, 0, ",", ".");
    }
}

function bulanromawi($bulanangka) {
    switch ($bulanangka) {
        case '01':
            return 'I';
            break;
        case '02':
            return 'II';
            break;
        case '03':
            return 'III';
            break;
        case '04':
            return 'IV';
            break;
        case '05':
            return 'V';
            break;
        case '06':
            return 'VI';
            break;
        case '07':
            return 'VII';
            break;
        case '08':
            return 'VIII';
            break;
        case '09':
            return 'IX';
            break;
        case '10':
            return 'X';
            break;
        case '11':
            return 'XI';
            break;
        case '12':
            return 'XII';
            break;
    }
}

if (!function_exists('format_rupiah')) {
    function format_rupiah($money)
    {
        return 'Rp. ' . number_format($money, 0, ",", ".");
    }
}

if (!function_exists('get_accessmenu')) {
    function get_accessmenu()
    {
      $CI = &get_instance();
      $user_id = $CI->session->userdata('id_login');
      $CI->db->group_by('tbl_access.menu_id,orderkey,menu_name,orderkey,icon,nav_id,span_key,link');
      $CI->db->select('tbl_access.menu_id,menu_name,orderkey,icon,nav_id,span_key,link');
      $CI->db->order_by('orderkey,tbl_access.menu_id,menu_name,orderkey,icon,nav_id,span_key,link','asc');
      $CI->db->join('tbl_menu','tbl_menu.menu_id = tbl_access.menu_id','left');
      $CI->db->where('tbl_menu.flag',1);
      $data = $CI->db->get_where('tbl_access',array('id_login'=>$user_id));
      return $data->result_array();
    }
}

if (!function_exists('get_submenu')) {
    function get_submenu($id)
    {
      $CI = &get_instance();
      $user_id = $CI->session->userdata('id_login');

      $CI->db->order_by('orderkey,tbl_access.submenu_id,submenu_name,link','asc');
      $CI->db->select('tbl_access.submenu_id,submenu_name,link,orderkey');
      $CI->db->join('tbl_submenu','tbl_submenu.submenu_id = tbl_access.submenu_id','left');
      $CI->db->where('tbl_submenu.flag',1);
      $data = $CI->db->get_where('tbl_access',array('id_login'=>$user_id,'tbl_access.menu_id'=>$id));
      return $data->result_array();
    }
}
