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
     * Main dashboard view
     * 
     * Displays the main dashboard with various statistics and information
     * including sales, purchases, and product data
     */
    public function index() {
//        if (akses::aksesLogin() == TRUE) {
        $pengaturan = $this->db->get('tbl_pengaturan')->row();
        $userid = $this->ion_auth->user()->row()->id;
        $id_grup = $this->ion_auth->get_users_groups()->row();
        $id_user = ($id_grup->name == 'superadmin' || $id_grup->name == 'owner' ? '' : $userid);
        $sql_penj = $this->db->select('SUM(jml_gtotal) as nominal')->like('id_user', $id_user)->get('tbl_trans_jual')->row();
        $sql_pemb = $this->db->select('SUM(jml_gtotal) as nominal')->get('tbl_trans_beli')->row();

        $data['tgl_tempo'] = date('Y-m-d', mktime(0, 0, 0, date("n"), date("j") + 1, date("Y")));

        $data['prod_new'] = $this->db->select('id, id_satuan, kode, produk, SUM((jml * jml_satuan)) AS jml')->limit(5)->group_by('produk')->order_by('jml', 'desc')->get('tbl_trans_jual_det')->result();
        $data['trans_new'] = $this->db->select('DATE(tgl_simpan) as tgl_simpan, id, id_sales, id_pelanggan, kode_nota_dpn, no_nota, kode_nota_blk, jml_gtotal')->like('id_user', $id_user)->limit(10)->order_by('no_nota', 'desc')->get('tbl_trans_jual')->result();
        $data['trans_jml'] = $this->db->like('id_user', $id_user)->get('tbl_trans_jual')->num_rows();
        $data['trans_jual_tmp'] = $this->db->query("SELECT id, no_nota, tgl_keluar FROM tbl_trans_jual WHERE DATEDIFF(tgl_keluar, CURDATE()) >= 0 AND DATEDIFF(tgl_keluar, CURDATE()) <= '" . $pengaturan->jml_limit_tempo . "' AND `tgl_masuk` != `tgl_keluar`");
        $data['trans_beli_new'] = $this->db->select('DATE(tgl_simpan) as tgl_simpan, id, id_supplier, id_user, no_nota, jml_gtotal')->like('id_user', $id_user)->limit(10)->order_by('id', 'desc')->get('tbl_trans_beli')->result();
        $data['trans_beli_jml'] = $this->db->like('id_user', $id_user)->get('tbl_trans_beli')->num_rows();
        $data['trans_beli_tmp'] = $this->db->query("SELECT id, no_nota, tgl_keluar FROM tbl_trans_beli WHERE status_bayar != '1' AND DATEDIFF(tgl_keluar, CURDATE()) >= 0 AND DATEDIFF(tgl_keluar, CURDATE()) <= '" . $pengaturan->jml_limit_tempo . "' AND `tgl_masuk` != `tgl_keluar`");
        $data['prod_jml'] = $this->db->select('jml')->where('jml <', $pengaturan->jml_limit_stok)->get('tbl_m_produk')->num_rows();
        $data['pem_jml'] = $this->db->select('SUM(jml_gtotal) as nominal')->where('MONTH(tgl_masuk)', date('m'))->where('YEAR(tgl_masuk)', date('Y'))->like('id_user', $id_user)->get('tbl_trans_jual')->row();
        $data['pem_jml_thn'] = $this->db->select('SUM(jml_gtotal) as nominal')->where('YEAR(tgl_masuk)', date('Y'))->like('id_user', $id_user)->get('tbl_trans_jual')->row();
        $data['pemb_jml'] = $this->db->select('SUM(jml_gtotal) as nominal')->like('id_user', $id_user)->get('tbl_trans_beli')->row();
        $data['pemb_jml_thn'] = $this->db->select('SUM(jml_gtotal) as nominal')->where('YEAR(tgl_masuk)', date('Y'))->like('id_user', $id_user)->get('tbl_trans_beli')->row();
        $data['tot_laba'] = $sql_penj->nominal - $sql_pemb->nominal;
        $data['user_id'] = $id_user;
        $data['pengaturan'] = $this->db->get('tbl_pengaturan')->row();

        $this->load->view('admin-lte-2/1_atas', $data);
        $this->load->view('admin-lte-2/2_header', $data);
        $this->load->view('admin-lte-2/3_navbar', $data);
        $this->load->view('admin-lte-2/content', $data);
        $this->load->view('admin-lte-2/5_footer', $data);
        $this->load->view('admin-lte-2/6_bawah', $data);
//        } else {
//            $errors = $this->ion_auth->messages(); 
//            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
//            redirect();
//        }
    }

    /**
     * Secondary dashboard view
     * 
     * Displays an alternative dashboard view with room labels,
     * capacity information, and staff schedules
     */
    public function index2() {
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
