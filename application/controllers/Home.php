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
            $data['sql_kary_jdwl'] = $this->db->from('v_master_dokter')
                                    ->where('hari_1 !=', '')
                                    ->or_where('hari_2 !=', '')
                                    ->or_where('hari_3 !=', '')
                                    ->or_where('hari_4 !=', '')
                                    ->or_where('hari_5 !=', '')
                                    ->or_where('hari_6 !=', '')
                                    ->or_where('hari_7 !=', '')
                                    ->where('status_prtk', 1)
                                    ->where('status_aps', 0)
                                    ->order_by('id_poli', 'ASC')
                                    ->get()
                                    ->result();
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
            $this->db->select('DATE_FORMAT(tgl_bayar, "%Y-%m") as month, COUNT(DISTINCT uuid) as visit_count');
            $this->db->from('tbl_trans_medcheck');
            $this->db->where('YEAR(tgl_bayar)', $current_year);
            $this->db->where('status_bayar', '1');
            $this->db->where('status_hps', '0');
            $this->db->group_by('DATE_FORMAT(tgl_bayar, "%Y-%m")');
            $this->db->order_by('month', 'ASC');
            $monthly_visits = $this->db->get()->result();
            
            // Get total visits for current year
            $this->db->select('COUNT(DISTINCT uuid) as total');
            $this->db->from('tbl_trans_medcheck');
            $this->db->where('YEAR(tgl_bayar)', $current_year);
            $this->db->where('status_bayar', '1');
            $this->db->where('status_hps', '0');
            $current_year_total = $this->db->get()->row()->total;
            
            // Get total visits for previous year
            $this->db->select('COUNT(DISTINCT uuid) as total');
            $this->db->from('tbl_trans_medcheck');
            $this->db->where('YEAR(tgl_bayar)', $current_year - 1);
            $this->db->where('status_bayar', '1');
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
            
            // Get total omset for the current year
            $this->db->select_sum('jml_gtotal', 'total_omset');
            $this->db->from('tbl_trans_medcheck');
            $this->db->where('YEAR(tgl_bayar)', $current_year);
            $this->db->where('status_bayar', '1');
            $this->db->where('status_hps', '0');
            $total_omset = $this->db->get()->row()->total_omset;
            
            // Prepare response data
            $data = [
                'total_visits'       => $current_year_total,
                'percentage_change'  => $percentage_change,
                'labels'             => $labels,
                'visit_data'         => $visit_data,
                'total_omset'        => $total_omset
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

    public function tes2(){
        echo '<meta http-equiv="refresh" content="10">'; 
        
        $sql = $this->db
                    ->where('status', '2')
                    //->where('id_rad !=', '0')
                    // ->where('id_berkas !=', '0')
                    //->where('id_medcheck_rsm !=', '0')
                    //->where('id <', '27956')
                    ->where('DATE(tgl_simpan) <', '2025-04-01')
                    ->where('sp', '1')
                    ->order_by('id', 'asc')
                    ->get('tbl_trans_medcheck_file')->result();
        
        foreach ($sql as $item){
            $fl  = parse_url($item->file_name); // ambil bagian path dan query dari file_name
            
            // cek kalau ada query-nya
            if (!isset($fl['query'])) {
                continue; // skip kalau gak ada query
            }
    
            parse_str($fl['query'], $prm); // hasilkan array dari query string
    
            // array untuk menampung hasil dekripsi
            $decrypted = [];
    
            // loop seluruh parameter di query string dan dekrip isinya
            foreach ($prm as $key => $val) {
                if ($key === 'status') {
                    // jangan dekrip 'status'
                    $decrypted[$key] = $val;
                } else {
                    // dekrip parameter lain
                    $decrypted[$key] = general::enkrip($val);
                }
            }
    
            //echo '<pre>';
            //echo "Original URL: " . $item->file_name . "\n";
            //echo "Decrypted Params:\n";
            
            // Menyusun kembali URL setelah dekripsi
            $decrypted_url = $fl['path'] . '?' . http_build_query($decrypted);
    
            //echo "Reconstructed Decrypted URL: " . $decrypted_url . "\n";
            //echo '</pre>';	
    
            
            $data = array(
                // 'file_name'     => $fl['path'].'?id='.general::dekrip($id).'&id_resm='.general::dekrip($id_resm),
                'file_name'     => $decrypted_url,
                // 'file_name'     => $item->file_name,
                'sp'            => '0',
            );
            
            $this->db->where('id', $item->id)->update('tbl_trans_medcheck_file', $data);
            
            echo '<pre>';
            print_r($data);
            
        }
    }

    /**
     * for update date and time display
     * Function to update date and time display
     * 
     * This function is used to update the date and time display in the UI
     * It uses the Tanggalan library to format the current date and time
     * 
     * @return void
     */
    public function tanggal() {
        try {
            // Get current date and time
            $current_datetime = date('Y-m-d H:i:s');
            
            // Format using Tanggalan library
            $formatted_datetime = $this->tanggalan->tgl_indo9($current_datetime);
            
            // Return formatted date and time as JSON
            echo json_encode([
                'success' => true,
                'datetime' => $formatted_datetime
            ]);
        } catch (Exception $e) {
            log_message('error', 'Error in update_datetime: ' . $e->getMessage());
            echo json_encode([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }
    }
}
