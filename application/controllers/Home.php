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
     * Get patient visits data for dashboard chart
     * 
     * Retrieves patient visit data from the database and formats it
     * for display in the dashboard chart
     * 
     * @return json JSON-encoded data for the chart
     */
    public function get_patient_visits() {
        header('Content-Type: application/json');
        try {
            // Get current year
            $current_year = date('Y');
            
            // Get monthly visit data for the current year
            $this->db->select('DATE_FORMAT(tgl_simpan, "%Y-%m") as month, COUNT(*) as visit_count');
            $this->db->from('tbl_trans_medcheck');
            $this->db->where('YEAR(tgl_simpan)', $current_year);
            $this->db->where('status_hps', '0');
            $this->db->group_by('DATE_FORMAT(tgl_simpan, "%Y-%m")');
            $this->db->order_by('month', 'ASC');
            $monthly_visits = $this->db->get()->result();
            
            // Get total visits for current year
            $this->db->select('COUNT(*) as total');
            $this->db->from('tbl_trans_medcheck');
            $this->db->where('YEAR(tgl_simpan)', $current_year);
            $this->db->where('status_hps', '0');
            $current_year_total = $this->db->get()->row()->total;
            
            // Get total visits for previous year
            $this->db->select('COUNT(*) as total');
            $this->db->from('tbl_trans_medcheck');
            $this->db->where('YEAR(tgl_simpan)', $current_year - 1);
            $this->db->where('status_hps', '0');
            $previous_year_total = $this->db->get()->row()->total;
            
            // Calculate percentage change
            $percentage_change = 0;
            if ($previous_year_total > 0) {
                $percentage_change = round((($current_year_total - $previous_year_total) / $previous_year_total) * 100, 2);
            }
            
            // Create month labels
            $labels = [
                'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
            ];
            
            // Initialize visit data array with zeros
            $visit_data = array_fill(0, 12, 0);
            
            // Fill in actual visit data
            foreach ($monthly_visits as $visit) {
                $month = (int)substr($visit->month, 5, 2) - 1; // Extract month part (MM) from YYYY-MM and convert to 0-based index
                $visit_data[$month] = (int)$visit->visit_count;
            }
            
            // Debug: Log the query and results
            $last_query = $this->db->last_query();
            log_message('debug', 'Patient visits query: ' . $last_query);
            log_message('debug', 'Monthly visits: ' . json_encode($monthly_visits));
            log_message('debug', 'Current year total: ' . $current_year_total);
            
            // Prepare response data
            $data = [
                'total_visits' => $current_year_total,
                'percentage_change' => $percentage_change,
                'labels' => $labels,
                'visit_data' => $visit_data
            ];
            echo json_encode($data);
        } catch (Exception $e) {
            log_message('error', 'Error in get_patient_visits: ' . $e->getMessage());
            echo json_encode([
                'error' => true,
                'message' => $e->getMessage()
            ]);
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
