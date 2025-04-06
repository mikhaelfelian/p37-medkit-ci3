<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php

/**
 * Home Controller
 * 
 * @package     MedKit
 * @subpackage  Controllers
 * @category    Home
 * @author      Mikhael Felian Waskito
 * @link        https://github.com/mikhaelfelian
 * @modified    Mikhael Felian Waskito - mikhaelfelian@gmail.com
 * @date        2025-03-14
 * 
 * Modified for PHP 8.2 compatibility
 * 
 * This controller handles the main dashboard and various test functions
 * for the MedKit application.
 */
class home extends CI_Controller {

    // Declare properties to prevent dynamic property creation warnings
    public $benchmark;
    public $hooks;
    public $config;
    public $log;
    public $utf8;
    public $uri;
    public $router;
    public $output;
    public $security;
    public $input;
    public $lang;
    public $db;
    public $pagination;
    public $encryption;
    public $encrypt;
    public $session;
    public $form_validation;
    public $tanggalan;
    public $agent;
    public $email;
    public $bcrypt;
    public $ion_auth_model;
    public $ion_auth;
    public $recaptcha;
    public $crud;
    public $akses;
    public $general;
    public $ciqrcode;

    /**
     * Constructor
     * 
     * Loads required libraries and initializes the controller
     */
    public function __construct() {
        parent::__construct();
        $this->load->library('qrcode/ciqrcode');
        $this->load->model('crud');
    }

    /**
     * Secondary dashboard view
     * 
     * Displays an alternative dashboard view with room labels,
     * capacity information, and staff schedules
     */
    public function index() {
        if (akses::aksesLogin() == TRUE) {
            $data['kmr_label']      = $this->crud->kmr_label();
            $data['kmr_kaps']       = $this->crud->kmr_kapasitas();
            $data['sql_kamar']      = $this->db->get('v_trans_kamar')->result();
            $data['sql_kary_jdwl']  = $this->db->select('tbl_m_karyawan.nama_dpn, tbl_m_karyawan.nama, tbl_m_karyawan.nama_blk, tbl_m_poli.lokasi, tbl_m_karyawan_jadwal.hari_1, tbl_m_karyawan_jadwal.hari_2, tbl_m_karyawan_jadwal.hari_3, tbl_m_karyawan_jadwal.hari_4, tbl_m_karyawan_jadwal.hari_5, tbl_m_karyawan_jadwal.hari_6, tbl_m_karyawan_jadwal.hari_7, tbl_m_karyawan_jadwal.waktu')
                                               ->join('tbl_m_karyawan', 'tbl_m_karyawan.id=tbl_m_karyawan_jadwal.id_karyawan')
                                               ->join('tbl_m_poli', 'tbl_m_poli.id=tbl_m_karyawan_jadwal.id_poli')
                                               ->get('tbl_m_karyawan_jadwal')->result();
            $data['pengaturan']     = $this->db->get('tbl_pengaturan')->row();
            
            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/content', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect(base_url('logout.php'));
        }
    }

    /**
     * Test function to load data from tbl_util_so
     * 
     * Retrieves and returns data from the tbl_util_so table
     * 
     * @return array Data from tbl_util_so table
     */
    public function test() {
        $sql_so = $this->db->where('uuid', '')->get('tbl_util_so')->result();

        // Process each record from tbl_util_so
        foreach ($sql_so as $so) {
            $uuid = $this->uuid->v4();

            $data = [
                'uuid'      => $uuid,
                'tgl_modif' => date('Y-m-d H:i:s'),
            ];

            // Update the record with the new UUID
            $this->db->where('id', $so->id)->update('tbl_util_so', $data);

            pre($data);
        }
    }
}
