<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
/**
 * Description of laporan
 *
 * @author Mikhael Felian Waskito
 * @date 2025-04-13
 */
class laporan extends CI_Controller {
    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->library('Excel'); 
    }
    
    public function index() {
        if (akses::aksesLogin() == TRUE) {
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/laporan/sidebar_lap';
            /* --- Sidebar Menu --- */
            
            /* Load view tampilan */
            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/laporan/index', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_cuti(){
        if (akses::aksesLogin() == TRUE) {
            $karyawan   = $this->input->get('id_kary');
            $jml        = $this->input->get('jml');
            $tgl        = $this->input->get('tgl');
            $tgl_awal   = $this->input->get('tgl_awal');
            $tgl_akhir  = $this->input->get('tgl_akhir');
            $status     = $this->input->get('status');
            $case       = $this->input->get('case');
            
            $data['sql_kat_cuti']   = $this->db->get('tbl_m_kategori_cuti')->result();
            $data['sql_kry']        = $this->db->where('status_aps', '0')->get('tbl_m_karyawan')->result();
            
            if($jml > 0){
                $sql_kary = $this->db->where('id_user', general::dekrip($karyawan))->get('tbl_m_karyawan')->row();
                
                switch ($case){
                    case 'per_bulan':
                        $data['sql_cuti']     = $this->db
                                                      ->select('tbl_sdm_cuti.id, tbl_sdm_cuti.id_user, tbl_sdm_cuti.tgl_simpan, tbl_sdm_cuti.tgl_masuk, tbl_sdm_cuti.tgl_keluar, tbl_sdm_cuti.no_surat, tbl_sdm_cuti.keterangan, tbl_sdm_cuti.catatan, tbl_sdm_cuti.file_name, tbl_sdm_cuti.file_type, tbl_sdm_cuti.status, tbl_m_karyawan.nama_dpn, tbl_m_karyawan.nama, tbl_m_karyawan.nama_blk, tbl_m_karyawan.tgl_lahir, tbl_m_karyawan.alamat, tbl_m_karyawan.jns_klm, tbl_m_kategori_cuti.tipe')
                                                      ->join('tbl_m_karyawan', 'tbl_m_karyawan.id=tbl_sdm_cuti.id_karyawan')
                                                      ->join('tbl_m_kategori_cuti', 'tbl_m_kategori_cuti.id=tbl_sdm_cuti.id_kategori', 'left')
                                                      ->where('tbl_sdm_cuti.id_kategori', $this->input->get('tipe'))
                                                      ->where('MONTH(tbl_sdm_cuti.tgl_simpan)', $this->input->get('bln'))
                                                      ->like('tbl_sdm_cuti.status', $status, (!empty($status) ? 'none' : ''))
//                                                      ->like('tbl_m_karyawan.id', $sql_kary->id, (!empty($sql_kary->id) ? 'none' : ''))
                                                      ->get('tbl_sdm_cuti')->result();  
//                        $data['sql_cuti']      = $this->db->query("SELECT 
//	tbl_sdm_cuti.id, tbl_sdm_cuti.id_user, tbl_sdm_cuti.tgl_simpan, tbl_sdm_cuti.tgl_masuk, tbl_sdm_cuti.tgl_keluar, tbl_sdm_cuti.no_surat, tbl_sdm_cuti.keterangan, tbl_sdm_cuti.catatan, tbl_sdm_cuti.file_name, tbl_sdm_cuti.file_type, tbl_sdm_cuti.status, tbl_m_karyawan.nama_dpn, tbl_m_karyawan.nama, tbl_m_karyawan.nama_blk, tbl_m_karyawan.tgl_lahir, tbl_m_karyawan.alamat, tbl_m_karyawan.jns_klm, tbl_m_kategori_cuti.tipe
//FROM tbl_sdm_cuti 
//JOIN tbl_m_karyawan ON tbl_sdm_cuti.id_karyawan=tbl_m_karyawan.id
//LEFT JOIN tbl_m_kategori_cuti ON tbl_sdm_cuti.id_kategori=tbl_m_kategori_cuti.tipe
//WHERE MONTH(tbl_sdm_cuti.tgl_simpan)='".$this->input->get('bln')."'")->result();
                        break;
                    
                    case 'per_tanggal':
                        $data['sql_cuti']     = $this->db
                                                      ->select('tbl_sdm_cuti.id, tbl_sdm_cuti.id_user, tbl_sdm_cuti.tgl_simpan, tbl_sdm_cuti.tgl_masuk, tbl_sdm_cuti.tgl_keluar, tbl_sdm_cuti.no_surat, tbl_sdm_cuti.keterangan, tbl_sdm_cuti.catatan, tbl_sdm_cuti.file_name, tbl_sdm_cuti.file_type, tbl_sdm_cuti.status, tbl_m_karyawan.nama_dpn, tbl_m_karyawan.nama, tbl_m_karyawan.nama_blk, tbl_m_karyawan.tgl_lahir, tbl_m_karyawan.alamat, tbl_m_karyawan.jns_klm, tbl_m_kategori_cuti.tipe')
                                                      ->join('tbl_m_karyawan', 'tbl_m_karyawan.id=tbl_sdm_cuti.id_karyawan')
                                                      ->join('tbl_m_kategori_cuti', 'tbl_m_kategori_cuti.id=tbl_sdm_cuti.id_kategori')
                                                      ->where('tbl_sdm_cuti.id_kategori', $this->input->get('tipe'))
                                                      ->where('DATE(tbl_sdm_cuti.tgl_simpan)', $this->input->get('tgl'))
                                                      ->like('tbl_sdm_cuti.status', $status, (!empty($status) ? 'none' : ''))
//                                                      ->like('tbl_m_karyawan.id', $sql_kary->id, (!empty($sql_kary->id) ? 'none' : ''))
                                                      ->get('tbl_sdm_cuti')->result();  
                        break;
                    
                    case 'per_rentang':
                        $data['sql_cuti']     = $this->db
                                                      ->select('tbl_sdm_cuti.id, tbl_sdm_cuti.id_user, tbl_sdm_cuti.tgl_simpan, tbl_sdm_cuti.tgl_masuk, tbl_sdm_cuti.tgl_keluar, tbl_sdm_cuti.no_surat, tbl_sdm_cuti.keterangan, tbl_sdm_cuti.catatan, tbl_sdm_cuti.file_name, tbl_sdm_cuti.file_type, tbl_sdm_cuti.status, tbl_m_karyawan.nama_dpn, tbl_m_karyawan.nama, tbl_m_karyawan.nama_blk, tbl_m_karyawan.tgl_lahir, tbl_m_karyawan.alamat, tbl_m_karyawan.jns_klm, tbl_m_kategori_cuti.tipe')
                                                      ->join('tbl_m_karyawan', 'tbl_m_karyawan.id=tbl_sdm_cuti.id_karyawan')
                                                      ->join('tbl_m_kategori_cuti', 'tbl_m_kategori_cuti.id=tbl_sdm_cuti.id_kategori')
                                                      ->where('tbl_sdm_cuti.id_kategori', $this->input->get('tipe'))
                                                      ->where('DATE(tbl_sdm_cuti.tgl_simpan) >=', $this->input->get('tgl_awal'))
                                                      ->where('DATE(tbl_sdm_cuti.tgl_simpan) <=', $this->input->get('tgl_akhir'))
                                                      ->like('tbl_m_karyawan.id', $sql_kary->id, (!empty($sql_kary->id) ? 'none' : ''))
                                                      ->get('tbl_sdm_cuti')->result();     
                        break;
                }
            }
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/laporan/sidebar_lap';
            /* --- Sidebar Menu --- */
            
            /* Load view tampilan */
            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/laporan/data_cuti', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_periksa(){
        if (akses::aksesLogin() == TRUE) {
            $dokter     = $this->input->get('id_dokter');
            $jml        = $this->input->get('jml');
            $tgl        = $this->input->get('tgl');
            $tgl_awal   = $this->input->get('tgl_awal');
            $tgl_akhir  = $this->input->get('tgl_akhir');
            $case       = $this->input->get('case');
            $setting    = $this->db->get('tbl_pengaturan')->row();
            
            $data['sql_doc']    = $this->db->where('id_user_group', '10')->get('tbl_m_karyawan')->result();
            $data['pengaturan'] = $setting;
            
            if($jml > 0){
                $sql_doc = $this->db->where('id_user', general::dekrip($dokter))->get('tbl_m_karyawan')->row();
                
                switch ($case){
                    case 'per_tanggal':
                        $data['sql_periksa']     = $this->db->select('tbl_trans_medcheck.id, tbl_trans_medcheck.id_dokter, tbl_trans_medcheck.tgl_simpan, tbl_trans_medcheck.tgl_masuk, tbl_trans_medcheck.no_rm, tbl_trans_medcheck.anamnesa, tbl_trans_medcheck.diagnosa, tbl_trans_medcheck.pemeriksaan, tbl_trans_medcheck.program, tbl_m_pasien.nama_pgl, tbl_m_pasien.no_hp, tbl_m_poli.lokasi, tbl_m_karyawan.nama_dpn, tbl_m_karyawan.nama, tbl_m_karyawan.nama_blk')
                                                          ->join('tbl_m_karyawan', 'tbl_m_karyawan.id_user=tbl_trans_medcheck.id_dokter')
                                                          ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
                                                          ->join('tbl_m_poli', 'tbl_m_poli.id=tbl_trans_medcheck.id_poli')
                                                          ->where('DATE(tbl_trans_medcheck.tgl_simpan)', $tgl)
                                                      ->get('tbl_trans_medcheck')->result();
                        break;
                    
                    case 'per_rentang':
                        $data['sql_periksa']     = $this->db->select('tbl_trans_medcheck.id, tbl_trans_medcheck.id_dokter, tbl_trans_medcheck.tgl_simpan, tbl_trans_medcheck.tgl_masuk, tbl_trans_medcheck.no_rm, tbl_trans_medcheck.anamnesa, tbl_trans_medcheck.diagnosa, tbl_trans_medcheck.pemeriksaan, tbl_trans_medcheck.program, tbl_m_pasien.nama_pgl, tbl_m_pasien.no_hp, tbl_m_poli.lokasi, tbl_m_karyawan.nama_dpn, tbl_m_karyawan.nama, tbl_m_karyawan.nama_blk')
                                                          ->join('tbl_m_karyawan', 'tbl_m_karyawan.id_user=tbl_trans_medcheck.id_dokter')
                                                          ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
                                                          ->join('tbl_m_poli', 'tbl_m_poli.id=tbl_trans_medcheck.id_poli')
                                                          ->like('tbl_trans_medcheck.id_dokter', (!empty($sql_doc->id_user) ? $sql_doc->id_user : ''))
                                                          ->where('DATE(tbl_trans_medcheck.tgl_simpan) >=', $tgl_awal)
                                                          ->where('DATE(tbl_trans_medcheck.tgl_simpan) <=', $tgl_akhir)
                                                      ->get('tbl_trans_medcheck')->result();
                        break;
                }
            }
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/laporan/sidebar_lap';
            /* --- Sidebar Menu --- */
            
            /* Load view tampilan */
            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/laporan/data_periksa', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_remunerasi(){
        if (akses::aksesLogin() == TRUE) {
            $dokter     = $this->input->get('id_dokter');
            $tgl        = $this->input->get('tgl');
            $tgl_awal   = $this->input->get('tgl_awal');
            $tgl_akhir  = $this->input->get('tgl_akhir');
            $tipe       = $this->input->get('tipe');
            $case       = $this->input->get('case');
            $setting    = $this->db->get('tbl_pengaturan')->row();
            $hal        = $this->input->get('halaman');
            
            $data['sql_doc']    = $this->db->where('id_user_group', '10')->get('tbl_m_karyawan')->result();
            $data['pengaturan'] = $setting;
            
            $sql_doc = $this->db->where('id_user', general::dekrip($dokter))->get('tbl_m_karyawan')->row();
            
            // Count total records for pagination
            $jml_hal = 0;
            
            switch ($case){
                case 'per_tanggal':
                    $query = $this->db
                        ->select('COUNT(*) as total')
                        ->from('tbl_trans_medcheck_remun')
                        ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id = tbl_trans_medcheck_remun.id_medcheck', 'left')
                        ->join('tbl_m_produk', 'tbl_m_produk.id = tbl_trans_medcheck_remun.id_item', 'left')
                        ->where('DATE(tbl_trans_medcheck_remun.tgl_simpan)', $tgl)
                        ->like('tbl_m_produk.status', (!empty($tipe) ? $tipe : ''), 'both')
                        ->like('tbl_trans_medcheck_remun.id_dokter', (!empty($sql_doc->id_user) ? $sql_doc->id_user : ''), 'both');
                    
                    $jml_hal = $query->get()->row()->total;
                    
                    $data['sql_remun'] = $this->db
                        ->select('
                            tbl_trans_medcheck_remun.id AS id,
                            tbl_trans_medcheck_remun.id_dokter AS id_dokter,
                            tbl_trans_medcheck_remun.tgl_simpan AS tgl_simpan,
                            CONCAT(tbl_m_karyawan.nama_dpn, " ", tbl_m_karyawan.nama) AS dokter,
                            tbl_m_karyawan.nama_blk AS dokter_blk,
                            tbl_m_poli.lokasi AS poli,
                            tbl_trans_medcheck.no_rm AS no_rm,
                            tbl_m_pasien.nama_pgl AS nama_pgl,
                            tbl_trans_medcheck_det.item AS item,
                            tbl_trans_medcheck_det.jml AS jml,
                            tbl_trans_medcheck_remun.harga AS harga,
                            tbl_trans_medcheck_remun.remun_nom AS remun_nom,
                            tbl_trans_medcheck_remun.remun_subtotal AS remun_subtotal,
                            tbl_trans_medcheck_remun.remun_perc AS remun_perc,
                            tbl_trans_medcheck.tipe AS tipe,
                            tbl_m_produk.status AS status_produk
                        ')
                        ->from('tbl_trans_medcheck_remun')
                        ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id = tbl_trans_medcheck_remun.id_medcheck', 'left')
                        ->join('tbl_trans_medcheck_det', 'tbl_trans_medcheck_det.id = tbl_trans_medcheck_remun.id_medcheck_det', 'left')
                        ->join('tbl_m_pasien', 'tbl_m_pasien.id = tbl_trans_medcheck.id_pasien', 'left')
                        ->join('tbl_m_poli', 'tbl_m_poli.id = tbl_trans_medcheck.id_poli', 'left')
                        ->join('tbl_m_produk', 'tbl_m_produk.id = tbl_trans_medcheck_remun.id_item', 'left')
                        ->join('tbl_m_karyawan', 'tbl_m_karyawan.id_user = tbl_trans_medcheck_remun.id_dokter', 'left')
                        ->where('DATE(tbl_trans_medcheck_remun.tgl_simpan)', $tgl)
                        ->like('tbl_m_produk.status', (!empty($tipe) ? $tipe : ''), 'both')
                        ->like('tbl_trans_medcheck_remun.id_dokter', (!empty($sql_doc->id_user) ? $sql_doc->id_user : ''), 'both')
                        ->order_by('tbl_trans_medcheck_remun.id', 'DESC')
                        ->limit($setting->jml_item, $hal ?? 0)
                        ->get()->result();
                    
                    if (empty($data['sql_remun'])) {
                        $data['sql_remun'] = array();
                    }
                    $data['jml'] = $jml_hal;
                    break;
                
                case 'per_rentang':
                    $query = $this->db
                        ->select('COUNT(*) as total')
                        ->from('tbl_trans_medcheck_remun')
                        ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id = tbl_trans_medcheck_remun.id_medcheck', 'left')
                        ->join('tbl_m_produk', 'tbl_m_produk.id = tbl_trans_medcheck_remun.id_item', 'left')
                        ->where('DATE(tbl_trans_medcheck_remun.tgl_simpan) >=', $tgl_awal)
                        ->where('DATE(tbl_trans_medcheck_remun.tgl_simpan) <=', $tgl_akhir)
                        ->like('tbl_m_produk.status', (!empty($tipe) ? $tipe : ''), 'both')
                        ->like('tbl_trans_medcheck_remun.id_dokter', (!empty($sql_doc->id_user) ? $sql_doc->id_user : ''), 'both');
                    
                    $jml_hal = $query->get()->row()->total;
                    
                    $data['sql_remun'] = $this->db
                        ->select('
                            tbl_trans_medcheck_remun.id AS id,
                            tbl_trans_medcheck_remun.id_dokter AS id_dokter,
                            tbl_trans_medcheck_remun.tgl_simpan AS tgl_simpan,
                            CONCAT(tbl_m_karyawan.nama_dpn, " ", tbl_m_karyawan.nama) AS dokter,
                            tbl_m_karyawan.nama_blk AS dokter_blk,
                            tbl_m_poli.lokasi AS poli,
                            tbl_trans_medcheck.no_rm AS no_rm,
                            tbl_m_pasien.nama_pgl AS nama_pgl,
                            tbl_trans_medcheck_det.item AS item,
                            tbl_trans_medcheck_det.jml AS jml,
                            tbl_trans_medcheck_remun.harga AS harga,
                            tbl_trans_medcheck_remun.remun_nom AS remun_nom,
                            tbl_trans_medcheck_remun.remun_subtotal AS remun_subtotal,
                            tbl_trans_medcheck_remun.remun_perc AS remun_perc,
                            tbl_trans_medcheck.tipe AS tipe,
                            tbl_m_produk.status AS status_produk
                        ')
                        ->from('tbl_trans_medcheck_remun')
                        ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id = tbl_trans_medcheck_remun.id_medcheck', 'left')
                        ->join('tbl_trans_medcheck_det', 'tbl_trans_medcheck_det.id = tbl_trans_medcheck_remun.id_medcheck_det', 'left')
                        ->join('tbl_m_pasien', 'tbl_m_pasien.id = tbl_trans_medcheck.id_pasien', 'left')
                        ->join('tbl_m_poli', 'tbl_m_poli.id = tbl_trans_medcheck.id_poli', 'left')
                        ->join('tbl_m_produk', 'tbl_m_produk.id = tbl_trans_medcheck_remun.id_item', 'left')
                        ->join('tbl_m_karyawan', 'tbl_m_karyawan.id_user = tbl_trans_medcheck_remun.id_dokter', 'left')
                        ->where('DATE(tbl_trans_medcheck_remun.tgl_simpan) >=', $tgl_awal)
                        ->where('DATE(tbl_trans_medcheck_remun.tgl_simpan) <=', $tgl_akhir)
                        ->like('tbl_m_produk.status', (!empty($tipe) ? $tipe : ''), 'both')
                        ->like('tbl_trans_medcheck_remun.id_dokter', (!empty($sql_doc->id_user) ? $sql_doc->id_user : ''), 'both')
                        ->order_by('tbl_trans_medcheck_remun.id', 'DESC')
                        ->limit($setting->jml_item, $hal ?? 0)
                        ->get()->result();
                    
                    if (empty($data['sql_remun'])) {
                        $data['sql_remun'] = array();
                    }
                    $data['jml'] = $jml_hal;
                    break;
                
                default:
                    $data['sql_remun'] = array();
                    $data['jml'] = 0;
                    break;
            }
            
            // Config Pagination
            $config['base_url']              = base_url('laporan/data_remunerasi.php?case='.$case.(!empty($dokter) ? '&id_dokter='.$dokter : '').(!empty($tgl) ? '&tgl='.$tgl : '').(!empty($tgl_awal) ? '&tgl_awal='.$tgl_awal : '').(!empty($tgl_akhir) ? '&tgl_akhir='.$tgl_akhir : '').(!empty($tipe) ? '&tipe='.$tipe : ''));
            $config['total_rows']            = $jml_hal;
            
            $config['query_string_segment']  = 'halaman';
            $config['page_query_string']     = TRUE;
            $config['per_page']              = $setting->jml_item;
            $config['num_links']             = 3;
            
            // AdminLTE 3 pagination styling
            $config['full_tag_open']         = '<ul class="pagination pagination-sm">';
            $config['full_tag_close']        = '</ul>';
            
            $config['first_tag_open']        = '<li class="page-item">';
            $config['first_tag_close']       = '</li>';
            
            $config['prev_tag_open']         = '<li class="page-item">';
            $config['prev_tag_close']        = '</li>';
            
            $config['num_tag_open']          = '<li class="page-item">';
            $config['num_tag_close']         = '</li>';
            
            $config['next_tag_open']         = '<li class="page-item">';
            $config['next_tag_close']        = '</li>';
            
            $config['last_tag_open']         = '<li class="page-item">';
            $config['last_tag_close']        = '</li>';
            
            $config['cur_tag_open']          = '<li class="page-item active"><a href="#" class="page-link">';
            $config['cur_tag_close']         = '</a></li>';
            
            $config['first_link']            = '&laquo;';
            $config['prev_link']             = '&lsaquo;';
            $config['next_link']             = '&rsaquo;';
            $config['last_link']             = '&raquo;';
            $config['attributes']            = ['class' => 'page-link'];
            
            // Initialize pagination
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            
            /* Sidebar Menu */
            $data['sidebar'] = 'admin-lte-3/includes/laporan/sidebar_lap';
            /* --- Sidebar Menu --- */
            
            /* Load view tampilan */
            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/laporan/data_remunerasi', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_periksa_wa(){
        if (akses::aksesLogin() == TRUE) {
            $dokter     = $this->input->get('id_dokter');
            $jml        = $this->input->get('jml');
            $tgl        = $this->input->get('tgl');
            $tgl_awal   = $this->input->get('tgl_awal');
            $tgl_akhir  = $this->input->get('tgl_akhir');
            $case       = $this->input->get('case');
            $setting    = $this->db->get('tbl_pengaturan')->row();
            
            
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_apresiasi(){
        if (akses::aksesLogin() == TRUE) {
            $dokter     = $this->input->get('id_dokter');
            $jml        = $this->input->get('jml');
            $tgl        = $this->input->get('tgl');
            $tgl_awal   = $this->input->get('tgl_awal');
            $tgl_akhir  = $this->input->get('tgl_akhir');
            $tipe       = $this->input->get('tipe');
            $case       = $this->input->get('case');
            $hal        = $this->input->get('halaman');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();
            
            $data['sql_doc'] = $this->db->where('id_user_group', '10')->get('tbl_m_karyawan')->result();
            
            if(!empty($dokter)) {
                $sql_doc = $this->db->where('id_user', general::dekrip($dokter))->get('tbl_m_karyawan')->row();
                
                // Base query for both cases
                $this->db->select('tbl_trans_medcheck_apres.id AS id, 
                                  tbl_trans_medcheck_apres.id_dokter AS id_dokter, 
                                  tbl_trans_medcheck_apres.tgl_simpan AS tgl_simpan, 
                                  CONCAT(tbl_m_karyawan.nama_dpn, " ", tbl_m_karyawan.nama) AS dokter, 
                                  tbl_m_karyawan.nama_blk AS dokter_blk, 
                                  tbl_m_poli.lokasi AS poli, 
                                  tbl_trans_medcheck.no_rm AS no_rm, 
                                  tbl_m_pasien.nama_pgl AS nama_pgl, 
                                  tbl_trans_medcheck_det.item AS item, 
                                  tbl_trans_medcheck_det.jml AS jml, 
                                  tbl_trans_medcheck_apres.harga AS harga, 
                                  tbl_trans_medcheck_apres.apres_nom AS apres_nom, 
                                  tbl_trans_medcheck_apres.apres_subtotal AS apres_subtotal, 
                                  tbl_trans_medcheck_apres.apres_perc AS apres_perc, 
                                  tbl_trans_medcheck.tipe AS tipe, 
                                  tbl_m_produk.status AS status_produk')
                    ->from('tbl_trans_medcheck_apres')
                    ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id = tbl_trans_medcheck_apres.id_medcheck')
                    ->join('tbl_trans_medcheck_det', 'tbl_trans_medcheck_det.id = tbl_trans_medcheck_apres.id_medcheck_det')
                    ->join('tbl_m_pasien', 'tbl_m_pasien.id = tbl_trans_medcheck.id_pasien')
                    ->join('tbl_m_poli', 'tbl_m_poli.id = tbl_trans_medcheck.id_poli')
                    ->join('tbl_m_produk', 'tbl_m_produk.id = tbl_trans_medcheck_apres.id_item')
                    ->join('tbl_m_karyawan', 'tbl_m_karyawan.id_user = tbl_trans_medcheck_apres.id_dokter');
                
                if(!empty($tipe)) {
                    $this->db->like('tbl_m_produk.status', $tipe);
                }
                
                if(!empty($sql_doc->id_user)) {
                    $this->db->where('tbl_trans_medcheck_apres.id_dokter', $sql_doc->id_user);
                }
                
                switch ($case){
                    case 'per_tanggal':
                        $this->db->where('DATE(tbl_trans_medcheck_apres.tgl_simpan)', $tgl);
                        break;
                    
                    case 'per_rentang':
                        $this->db->where('DATE(tbl_trans_medcheck_apres.tgl_simpan) >=', $tgl_awal);
                        $this->db->where('DATE(tbl_trans_medcheck_apres.tgl_simpan) <=', $tgl_akhir);
                        break;
                }
                
                // Count total rows for pagination
                $total_rows = $this->db->get()->num_rows();
                
                // Rerun the query with pagination limits
                $this->db->select('tbl_trans_medcheck_apres.id AS id, 
                                  tbl_trans_medcheck_apres.id_dokter AS id_dokter, 
                                  tbl_trans_medcheck_apres.tgl_simpan AS tgl_simpan, 
                                  CONCAT(tbl_m_karyawan.nama_dpn, " ", tbl_m_karyawan.nama) AS dokter, 
                                  tbl_m_karyawan.nama_blk AS dokter_blk, 
                                  tbl_m_poli.lokasi AS poli, 
                                  tbl_trans_medcheck.no_rm AS no_rm, 
                                  tbl_m_pasien.nama_pgl AS nama_pgl, 
                                  tbl_trans_medcheck_det.item AS item, 
                                  tbl_trans_medcheck_det.jml AS jml, 
                                  tbl_trans_medcheck_apres.harga AS harga, 
                                  tbl_trans_medcheck_apres.apres_nom AS apres_nom, 
                                  tbl_trans_medcheck_apres.apres_subtotal AS apres_subtotal, 
                                  tbl_trans_medcheck_apres.apres_perc AS apres_perc, 
                                  tbl_trans_medcheck.tipe AS tipe, 
                                  tbl_m_produk.status AS status_produk')
                    ->from('tbl_trans_medcheck_apres')
                    ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id = tbl_trans_medcheck_apres.id_medcheck')
                    ->join('tbl_trans_medcheck_det', 'tbl_trans_medcheck_det.id = tbl_trans_medcheck_apres.id_medcheck_det')
                    ->join('tbl_m_pasien', 'tbl_m_pasien.id = tbl_trans_medcheck.id_pasien')
                    ->join('tbl_m_poli', 'tbl_m_poli.id = tbl_trans_medcheck.id_poli')
                    ->join('tbl_m_produk', 'tbl_m_produk.id = tbl_trans_medcheck_apres.id_item')
                    ->join('tbl_m_karyawan', 'tbl_m_karyawan.id_user = tbl_trans_medcheck_apres.id_dokter');
                
                if(!empty($tipe)) {
                    $this->db->like('tbl_m_produk.status', $tipe);
                }
                
                if(!empty($sql_doc->id_user)) {
                    $this->db->where('tbl_trans_medcheck_apres.id_dokter', $sql_doc->id_user);
                }
                
                switch ($case){
                    case 'per_tanggal':
                        $this->db->where('DATE(tbl_trans_medcheck_apres.tgl_simpan)', $tgl);
                        break;
                    
                    case 'per_rentang':
                        $this->db->where('DATE(tbl_trans_medcheck_apres.tgl_simpan) >=', $tgl_awal);
                        $this->db->where('DATE(tbl_trans_medcheck_apres.tgl_simpan) <=', $tgl_akhir);
                        break;
                }
                
                $this->db->order_by('tbl_trans_medcheck_apres.id', 'DESC');
                
                if(!empty($hal)) {
                    $this->db->limit($pengaturan->jml_item, $hal);
                } else {
                    $this->db->limit($pengaturan->jml_item, 0);
                }
                
                $data['sql_apres'] = $this->db->get()->result();
                
                // Config Pagination
                $config['base_url'] = base_url('laporan/data_apresiasi.php?case='.$case.(!empty($tipe) ? '&tipe='.$tipe : '').(!empty($dokter) ? '&id_dokter='.$dokter : '').(!empty($tgl) ? '&tgl='.$tgl : '').(!empty($tgl_awal) ? '&tgl_awal='.$tgl_awal : '').(!empty($tgl_akhir) ? '&tgl_akhir='.$tgl_akhir : ''));
                $config['total_rows'] = $total_rows;
                
                $config['query_string_segment'] = 'halaman';
                $config['page_query_string'] = TRUE;
                $config['per_page'] = $pengaturan->jml_item;
                $config['num_links'] = 3;
                
                $config['first_tag_open'] = '<li class="page-item">';
                $config['first_tag_close'] = '</li>';
                
                $config['prev_tag_open'] = '<li class="page-item">';
                $config['prev_tag_close'] = '</li>';
                
                $config['num_tag_open'] = '<li class="page-item">';
                $config['num_tag_close'] = '</li>';
                
                $config['next_tag_open'] = '<li class="page-item">';
                $config['next_tag_close'] = '</li>';
                
                $config['last_tag_open'] = '<li class="page-item">';
                $config['last_tag_close'] = '</li>';
                
                $config['cur_tag_open'] = '<li class="page-item active"><a href="#" class="page-link">';
                $config['cur_tag_close'] = '</a></li>';
                
                $config['first_link'] = '&laquo;';
                $config['prev_link'] = '&lsaquo;';
                $config['next_link'] = '&rsaquo;';
                $config['last_link'] = '&raquo;';
                $config['attributes'] = ['class' => 'page-link'];
                
                // Initialize pagination
                $this->pagination->initialize($config);
                $data['pagination'] = $this->pagination->create_links();
            }
            
            /* Sidebar Menu */
            $data['sidebar'] = 'admin-lte-3/includes/laporan/sidebar_lap';
            /* --- Sidebar Menu --- */
            
            /* Load view tampilan */
            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/laporan/data_apresiasi', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_icd(){
        if (akses::aksesLogin() == TRUE) {
            $dokter             = $this->input->get('id_dokter');
            $poli               = $this->input->get('poli');
            $tipe               = $this->input->get('tipe');
            $plat               = $this->input->get('plat');
            $jml                = $this->input->get('jml');
            $tgl                = $this->input->get('tgl');
            $tgl_awal           = $this->input->get('tgl_awal');
            $tgl_akhir          = $this->input->get('tgl_akhir');
            $case               = $this->input->get('case');
            $hal                = $this->input->get('halaman');
            $pasien_id          = $this->input->get('id_pasien');
            $pasien             = $this->input->get('pasien');
            $pengaturan         = $this->db->get('tbl_pengaturan')->row();
            
            $data['sql_doc']    = $this->db->where('id_user_group', '10')->get('tbl_m_karyawan')->result();
            $data['sql_poli']   = $this->db->get('tbl_m_poli')->result();
            $data['sql_plat']   = $this->db->get('tbl_m_platform')->result();
            
            if($jml > 0){
                $data['hasError'] = $this->session->flashdata('form_error');
                
                // Config Pagination
                $config['base_url']              = base_url('laporan/data_icd.php?case='.$case.(!empty($plat) ? '&plat='.$plat : '').(!empty($poli) ? '&poli='.$poli : '').(!empty($tgl) ? '&tgl='.$tgl : '').(!empty($tgl_awal) ? '&tgl_awal='.$tgl_awal : '').(!empty($tgl_akhir) ? '&tgl_akhir='.$tgl_akhir : '').(!empty($jml) ? '&jml='.$jml : ''));
                $config['total_rows']            = $jml;
                
                $config['query_string_segment']  = 'halaman';
                $config['page_query_string']     = TRUE;
                $config['per_page']              = $pengaturan->jml_item;
                $config['num_links']             = 3;
                
                $config['first_tag_open']        = '<li class="page-item">';
                $config['first_tag_close']       = '</li>';
                
                $config['prev_tag_open']         = '<li class="page-item">';
                $config['prev_tag_close']        = '</li>';
                
                $config['num_tag_open']          = '<li class="page-item">';
                $config['num_tag_close']         = '</li>';
                
                $config['next_tag_open']         = '<li class="page-item">';
                $config['next_tag_close']        = '</li>';
                
                $config['last_tag_open']         = '<li class="page-item">';
                $config['last_tag_close']        = '</li>';
                
                $config['cur_tag_open']          = '<li class="page-item"><a href="#" class="page-link text-dark"><b>';
                $config['cur_tag_close']         = '</b></a></li>';
                
                $config['first_link']            = '&laquo;';
                $config['prev_link']             = '&lsaquo;';
                $config['next_link']             = '&rsaquo;';
                $config['last_link']             = '&raquo;';
                $config['anchor_class']          = 'class="page-link"';
            
                $sql_doc = $this->db->where('id', general::dekrip($dokter))->get('tbl_m_karyawan')->row();
                
                switch ($case){
                    case 'per_tanggal':
                        $data['sql_icd'] = $this->db->query(""
                                . "SELECT "
                                . "id, kode, icd, diagnosa_en, COUNT(icd) AS jml "
                                . "FROM tbl_trans_medcheck_icd "
                                . "WHERE DATE(tbl_trans_medcheck_icd.tgl_simpan) = '".$this->tanggalan->tgl_indo_sys($tgl)."' "
                                . "GROUP BY tbl_trans_medcheck_icd.id_icd HAVING  COUNT(id_icd) > 1 "
                                . "ORDER BY COUNT(tbl_trans_medcheck_icd.icd) DESC;"
                                . "")->result();
                        break;
                    
                    case 'per_rentang':
                        $data['sql_icd'] = $this->db->query(""
                                . "SELECT "
                                . "id, kode, icd, diagnosa_en, COUNT(icd) AS jml "
                                . "FROM tbl_trans_medcheck_icd "
                                . "WHERE DATE(tbl_trans_medcheck_icd.tgl_simpan) >= '".$this->tanggalan->tgl_indo_sys($tgl_awal)."' AND DATE(tbl_trans_medcheck_icd.tgl_simpan) <= '".$this->tanggalan->tgl_indo_sys($tgl_akhir)."' "
                                . "GROUP BY tbl_trans_medcheck_icd.id_icd HAVING  COUNT(id_icd) > 1 "
                                . "ORDER BY COUNT(tbl_trans_medcheck_icd.icd) DESC;"
                                . "")->result();
                        break; 
                }
                
                // Initializing Config Pagination
                $this->pagination->initialize($config);
                
                // Pagination Data
                $data['total_rows'] = $config['total_rows'];
                $data['PerPage']    = $config['per_page'];
                $data['pagination'] = $this->pagination->create_links();
            }
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/laporan/sidebar_lap';
            /* --- Sidebar Menu --- */
            
            /* Load view tampilan */
            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/laporan/data_icd', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_icd_pasien(){
        if (akses::aksesLogin() == TRUE) {
            $dokter             = $this->input->get('id_dokter');
            $poli               = $this->input->get('poli');
            $tipe               = $this->input->get('tipe');
            $plat               = $this->input->get('plat');
            $jml                = $this->input->get('jml');
            $tgl                = $this->input->get('tgl');
            $tgl_awal           = $this->input->get('tgl_awal');
            $tgl_akhir          = $this->input->get('tgl_akhir');
            $case               = $this->input->get('case');
            $hal                = $this->input->get('halaman');
            $pasien_id          = $this->input->get('id_pasien');
            $pasien             = $this->input->get('pasien');
            $pengaturan         = $this->db->get('tbl_pengaturan')->row();
            
            $data['sql_doc']    = $this->db->where('id_user_group', '10')->get('tbl_m_karyawan')->result();
            $data['sql_poli']   = $this->db->get('tbl_m_poli')->result();
            $data['sql_plat']   = $this->db->get('tbl_m_platform')->result();
            
            if($jml > 0){
                $data['hasError'] = $this->session->flashdata('form_error');
                
                // Config Pagination
                $config['base_url']              = base_url('laporan/data_icd.php?case='.$case.(!empty($plat) ? '&plat='.$plat : '').(!empty($poli) ? '&poli='.$poli : '').(!empty($tgl) ? '&tgl='.$tgl : '').(!empty($tgl_awal) ? '&tgl_awal='.$tgl_awal : '').(!empty($tgl_akhir) ? '&tgl_akhir='.$tgl_akhir : '').(!empty($jml) ? '&jml='.$jml : ''));
                $config['total_rows']            = $jml;
                
                $config['query_string_segment']  = 'halaman';
                $config['page_query_string']     = TRUE;
                $config['per_page']              = $pengaturan->jml_item;
                $config['num_links']             = 3;
                
                $config['first_tag_open']        = '<li class="page-item">';
                $config['first_tag_close']       = '</li>';
                
                $config['prev_tag_open']         = '<li class="page-item">';
                $config['prev_tag_close']        = '</li>';
                
                $config['num_tag_open']          = '<li class="page-item">';
                $config['num_tag_close']         = '</li>';
                
                $config['next_tag_open']         = '<li class="page-item">';
                $config['next_tag_close']        = '</li>';
                
                $config['last_tag_open']         = '<li class="page-item">';
                $config['last_tag_close']        = '</li>';
                
                $config['cur_tag_open']          = '<li class="page-item"><a href="#" class="page-link text-dark"><b>';
                $config['cur_tag_close']         = '</b></a></li>';
                
                $config['first_link']            = '&laquo;';
                $config['prev_link']             = '&lsaquo;';
                $config['next_link']             = '&rsaquo;';
                $config['last_link']             = '&raquo;';
                $config['anchor_class']          = 'class="page-link"';
            
                $sql_doc = $this->db->where('id', general::dekrip($dokter))->get('tbl_m_karyawan')->row();
                
                switch ($case){
                    case 'per_tanggal':
                        $data['sql_icd'] = $this->db->query(""
                                . "SELECT "
                                . "id, id_medcheck, id_icd, kode, icd, diagnosa_en, COUNT(icd) AS jml "
                                . "FROM tbl_trans_medcheck_icd "
                                . "WHERE DATE(tbl_trans_medcheck_icd.tgl_simpan) = '".$this->tanggalan->tgl_indo_sys($tgl)."' "
                                . "GROUP BY tbl_trans_medcheck_icd.id_icd HAVING  COUNT(id_icd) > 1 "
                                . "ORDER BY COUNT(tbl_trans_medcheck_icd.icd) DESC;"
                                . "")->result();
                        break;
                    
                    case 'per_rentang':
                        $data['sql_icd'] = $this->db->query(""
                                . "SELECT "
                                . "id, id_medcheck, id_icd, kode, icd, diagnosa_en, COUNT(icd) AS jml "
                                . "FROM tbl_trans_medcheck_icd "
                                . "WHERE DATE(tbl_trans_medcheck_icd.tgl_simpan) >= '".$this->tanggalan->tgl_indo_sys($tgl_awal)."' AND DATE(tbl_trans_medcheck_icd.tgl_simpan) <= '".$this->tanggalan->tgl_indo_sys($tgl_akhir)."' "
                                . "GROUP BY tbl_trans_medcheck_icd.id_icd HAVING  COUNT(id_icd) > 1 "
                                . "ORDER BY COUNT(tbl_trans_medcheck_icd.icd) DESC;"
                                . "")->result();
                        break; 
                }
                
                // Initializing Config Pagination
                $this->pagination->initialize($config);
                
                // Pagination Data
                $data['total_rows'] = $config['total_rows'];
                $data['PerPage']    = $config['per_page'];
                $data['pagination'] = ''; // $this->pagination->create_links();
            }
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/laporan/sidebar_lap';
            /* --- Sidebar Menu --- */
            
            /* Load view tampilan */
            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/laporan/data_icd_diagnosa', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_mcu(){
        if (akses::aksesLogin() == TRUE) {
            $dokter             = $this->input->get('id_dokter');
            $poli               = $this->input->get('poli');
            $tipe               = $this->input->get('tipe');
            $plat               = $this->input->get('plat');
            $jml                = $this->input->get('jml');
            $tgl                = $this->input->get('tgl');
            $tgl_awal           = $this->input->get('tgl_awal');
            $tgl_akhir          = $this->input->get('tgl_akhir');
            $inst               = $this->input->get('id_instansi');
            $case               = $this->input->get('case');
            $hal                = $this->input->get('halaman');
            $pasien_id          = $this->input->get('id_pasien');
            $pasien             = $this->input->get('pasien');
            $pengaturan         = $this->db->get('tbl_pengaturan')->row();
            
            $data['sql_doc']    = $this->db->where('id_user_group', '10')->get('tbl_m_karyawan')->result();
            $data['sql_poli']   = $this->db->get('tbl_m_poli')->result();
            $data['sql_plat']   = $this->db->get('tbl_m_platform')->result();
            
            if($jml > 0){
                $data['hasError'] = $this->session->flashdata('form_error');
                
                // Config Pagination
                $config['base_url']              = base_url('laporan/data_mcu.php?case='.$case.(!empty($tgl) ? '&tgl='.$tgl : '').(!empty($tgl_awal) ? '&tgl_awal='.$tgl_awal : '').(!empty($tgl_akhir) ? '&tgl_akhir='.$tgl_akhir : '').(!empty($jml) ? '&jml='.$jml : ''));
                $config['total_rows']            = $jml;
                
                $config['query_string_segment']  = 'halaman';
                $config['page_query_string']     = TRUE;
                $config['per_page']              = $pengaturan->jml_item;
                $config['num_links']             = 3;
                
                $config['first_tag_open']        = '<li class="page-item">';
                $config['first_tag_close']       = '</li>';
                
                $config['prev_tag_open']         = '<li class="page-item">';
                $config['prev_tag_close']        = '</li>';
                
                $config['num_tag_open']          = '<li class="page-item">';
                $config['num_tag_close']         = '</li>';
                
                $config['next_tag_open']         = '<li class="page-item">';
                $config['next_tag_close']        = '</li>';
                
                $config['last_tag_open']         = '<li class="page-item">';
                $config['last_tag_close']        = '</li>';
                
                $config['cur_tag_open']          = '<li class="page-item"><a href="#" class="page-link text-dark"><b>';
                $config['cur_tag_close']         = '</b></a></li>';
                
                $config['first_link']            = '&laquo;';
                $config['prev_link']             = '&lsaquo;';
                $config['next_link']             = '&rsaquo;';
                $config['last_link']             = '&raquo;';
                $config['anchor_class']          = 'class="page-link"';
            
                $sql_doc = $this->db->where('id', general::dekrip($dokter))->get('tbl_m_karyawan')->row();
                
                switch ($case){
                    case 'per_tanggal':
                            $data['sql_mcu'] =  $this->db->select('tbl_m_pasien.id AS id_pasien, tbl_m_pasien.nama_pgl, tbl_trans_medcheck_resume.id, tbl_trans_medcheck_resume.id_medcheck, tbl_trans_medcheck_resume.id_user, tbl_trans_medcheck_resume.no_surat, tbl_trans_medcheck_resume.saran, tbl_trans_medcheck_resume.kesimpulan')
                                                         ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_resume.id_medcheck')
                                                         ->join('tbl_pendaftaran', 'tbl_pendaftaran.id=tbl_trans_medcheck.id_dft')
                                                         ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
                                                         ->where('tbl_trans_medcheck.tipe', '5')
                                                         ->where('DATE(tbl_trans_medcheck_resume.tgl_simpan)', $this->tanggalan->tgl_indo_sys($tgl))
                                                         ->like('tbl_pendaftaran.id_instansi', $inst, (!empty($inst) ? 'none' : ''))
//                                                         ->limit($config['per_page'])                          
                                                         ->get('tbl_trans_medcheck_resume')->result();
                            
                            $data['sql_mcu_cek_hdr'] =  $this->db->select('tbl_trans_medcheck_resume_det.id_resume, tbl_trans_medcheck_resume_det.param, COUNT(tbl_trans_medcheck_resume_det.id_resume)')
                                                                ->join('tbl_trans_medcheck_resume', 'tbl_trans_medcheck_resume.id=tbl_trans_medcheck_resume_det.id_resume')
                                                                ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_resume_det.id_medcheck')
                                                                ->join('tbl_pendaftaran', 'tbl_pendaftaran.id=tbl_trans_medcheck.id_dft')
                                                                ->where('tbl_trans_medcheck.tipe', '5')
                                                                ->where('DATE(tbl_trans_medcheck_resume.tgl_simpan)', $this->tanggalan->tgl_indo_sys($tgl))
                                                                ->like('tbl_pendaftaran.id_instansi', $inst, (!empty($inst) ? 'none' : ''))
                                                                ->order_by('tbl_trans_medcheck_resume_det.id', 'DESC')
//                                                         ->where('id_resume', '1482')
                                                         ->get('tbl_trans_medcheck_resume_det')->row();
                            
                            $data['sql_mcu_hdr'] =  $this->db->select('tbl_trans_medcheck_resume_det.id, tbl_trans_medcheck_resume_det.id_resume, tbl_trans_medcheck_resume_det.id_medcheck, tbl_trans_medcheck_resume_det.param')
                                                         ->where('id_resume',  $data['sql_mcu_cek_hdr']->id_resume)
                                                         ->get('tbl_trans_medcheck_resume_det');
                        break;
                    
                    case 'per_rentang':
//                        if(!empty($hal)){
//                            $data['sql_mcu'] =  $this->db->select('tbl_m_pasien.id AS id_pasien, tbl_m_pasien.nama_pgl, tbl_trans_medcheck_resume.id, tbl_trans_medcheck_resume.id_medcheck, tbl_trans_medcheck_resume.id_user, tbl_trans_medcheck_resume.no_surat')
//                                                         ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_resume.id_medcheck')
//                                                         ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
//                                                         ->where('tbl_trans_medcheck.tipe', '5')
//                                                         ->where('DATE(tbl_trans_medcheck_resume.tgl_simpan) >=', $this->tanggalan->tgl_indo_sys($tgl_awal))
//                                                         ->where('DATE(tbl_trans_medcheck_resume.tgl_simpan) <=', $this->tanggalan->tgl_indo_sys($tgl_akhir))
//                                                         ->limit($config['per_page'], $hal)                          
//                                                         ->get('tbl_trans_medcheck_resume')->result(); 
//                        }else{
//                            $data['sql_mcu'] =  $this->db->select('tbl_m_pasien.id AS id_pasien, tbl_m_pasien.nama_pgl, tbl_trans_medcheck_resume.id, tbl_trans_medcheck_resume.id_medcheck, tbl_trans_medcheck_resume.id_user, tbl_trans_medcheck_resume.no_surat, tbl_trans_medcheck_resume.saran, tbl_trans_medcheck_resume.kesimpulan')
//                                                         ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_resume.id_medcheck')
//                                                         ->join('tbl_pendaftaran', 'tbl_pendaftaran.id=tbl_trans_medcheck.id_dft')
//                                                         ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
//                                                         ->where('tbl_trans_medcheck.tipe', '5')
//                                                         ->where('DATE(tbl_trans_medcheck_resume.tgl_simpan) >=', $this->tanggalan->tgl_indo_sys($tgl_awal))
//                                                         ->where('DATE(tbl_trans_medcheck_resume.tgl_simpan) <=', $this->tanggalan->tgl_indo_sys($tgl_akhir))
//                                                         ->like('tbl_pendaftaran.id_instansi', $inst, (!empty($inst) ? 'none' : ''))
////                                                         ->limit($config['per_page'])                          
//                                                         ->get('tbl_trans_medcheck_resume')->result();
                            
                            $data['sql_mcu']    = $this->db
                                                           ->where('DATE(tgl_simpan) >=', $this->tanggalan->tgl_indo_sys($tgl_awal))
                                                           ->where('DATE(tgl_simpan) <=', $this->tanggalan->tgl_indo_sys($tgl_akhir))
                                                           ->like('id_instansi', $inst, (!empty($inst) ? 'none' : ''))
                                                           ->get('v_medcheck_mcu')->result();
                        
                            $data['sql_mcu_cek_hdr'] =  $this->db->select('tbl_trans_medcheck_resume_det.id_resume, tbl_trans_medcheck_resume_det.param, COUNT(tbl_trans_medcheck_resume_det.id_resume)')
                                                                ->join('tbl_trans_medcheck_resume', 'tbl_trans_medcheck_resume.id=tbl_trans_medcheck_resume_det.id_resume')
                                                                ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_resume_det.id_medcheck')
                                                                ->join('tbl_pendaftaran', 'tbl_pendaftaran.id=tbl_trans_medcheck.id_dft')
                                                                ->where('tbl_trans_medcheck.tipe', '5')
                                                                ->where('DATE(tbl_trans_medcheck_resume.tgl_simpan) >=', $this->tanggalan->tgl_indo_sys($tgl_awal))
                                                                ->where('DATE(tbl_trans_medcheck_resume.tgl_simpan) <=', $this->tanggalan->tgl_indo_sys($tgl_akhir))
                                                                ->like('tbl_pendaftaran.id_instansi', $inst, (!empty($inst) ? 'none' : ''))
                                                                ->order_by('tbl_trans_medcheck_resume_det.id', 'DESC')
//                                                         ->where('id_resume', '1482')
                                                         ->get('tbl_trans_medcheck_resume_det')->row();
                            
                            $data['sql_mcu_hdr'] =  $this->db->select('tbl_trans_medcheck_resume_det.id, tbl_trans_medcheck_resume_det.id_resume, tbl_trans_medcheck_resume_det.id_medcheck, tbl_trans_medcheck_resume_det.param')
                                                         ->where('id_resume',  $data['sql_mcu_cek_hdr']->id_resume)
                                                         ->get('tbl_trans_medcheck_resume_det');
                            
//                            echo '<pre>';
//                            print_r( $data['sql_mcu_cek_hdr']->result());
//                            echo '</pre>';
                            
//                            $data['sql_mcu'] =  $this->db->select('tbl_m_pasien.id, tbl_m_pasien.nama_pgl, tbl_trans_medcheck_resume_det.id, tbl_trans_medcheck_resume_det.param, tbl_trans_medcheck_resume_det.param_nilai')
//                                                         ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_resume_det.id_medcheck')
//                                                         ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
//                                                         ->where('tbl_trans_medcheck.tipe', '5')
//                                                         ->where('DATE(tbl_trans_medcheck_resume_det.tgl_simpan) >=', $this->tanggalan->tgl_indo_sys($tgl_awal))
//                                                         ->where('DATE(tbl_trans_medcheck_resume_det.tgl_simpan) <=', $this->tanggalan->tgl_indo_sys($tgl_akhir))
//                                                         ->limit($config['per_page'])                          
//                                                         ->get('tbl_trans_medcheck_resume_det')->result();                            
//                        }
                        break; 
                }
                
                // Initializing Config Pagination
                $this->pagination->initialize($config);
                
                // Pagination Data
                $data['total_rows'] = $config['total_rows'];
                $data['PerPage']    = $config['per_page'];
                $data['pagination'] = $this->pagination->create_links();
            }
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/laporan/sidebar_lap';
            /* --- Sidebar Menu --- */
            
            
            /* Load view tampilan */
            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/laporan/data_mcu', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    public function data_omset(){
        if (akses::aksesLogin() == TRUE) {
            $dokter                 = $this->input->get('id_dokter');
            $poli                   = $this->input->get('poli');
            $tipe                   = $this->input->get('tipe');
            $tipe_byr               = $this->input->get('tipe_bayar');
            $plat                   = $this->input->get('plat');
            $jml                    = 0; // Initialize jml to 0
            $tgl                    = $this->input->get('tgl');
            $tgl_awal               = $this->input->get('tgl_awal');
            $tgl_akhir              = $this->input->get('tgl_akhir');
            $case                   = $this->input->get('case');
            $hal                    = $this->input->get('halaman');
            $pasien_id              = $this->input->get('id_pasien');
            $pasien                 = $this->input->get('pasien');
            $pengaturan             = $this->db->get('tbl_pengaturan')->row();
            
            // Load necessary data only when needed
            $data['sql_doc']        = $this->db->where('id_user_group', '10')->get('tbl_m_karyawan')->result();
            $data['sql_poli']       = $this->db->get('tbl_m_poli')->result();
            $data['sql_plat']       = $this->db->get('tbl_m_platform')->result();
            $data['sql_penjamin']   = $this->db->where('status', '1')->get('tbl_m_penjamin')->result();

            $data['hasError'] = $this->session->flashdata('form_error');
            
            // Count total records based on case
            if(!empty($case)) {
                // Base query builder for counting records
                $this->db->select('COUNT(DISTINCT tm.id_pasien) as total')
                        ->from('tbl_trans_medcheck_det tmd')
                        ->join('tbl_trans_medcheck tm', 'tmd.id_medcheck = tm.id')
                        ->join('tbl_m_pasien mp', 'tm.id_pasien = mp.id')
                        ->where('tm.status_hps', '0')
                        ->where('tm.status_bayar', '1')
                        ->where('tmd.status_pkt', '0');
                
                if($case == 'per_tanggal') {
                    $this->db->where('DATE(tm.tgl_bayar)', $tgl);
                } else if($case == 'per_rentang') {
                    $this->db->where('DATE(tm.tgl_bayar) >=', $tgl_awal);
                    $this->db->where('DATE(tm.tgl_bayar) <=', $tgl_akhir);
                }
                
                if(!empty($tipe)) $this->db->where('tm.tipe', $tipe);
                if(!empty($tipe_byr)) $this->db->where('tm.tipe_bayar', $tipe_byr);
                if(!empty($poli)) $this->db->where('tm.id_poli', $poli);
                if(!empty($plat)) $this->db->where('tm.metode', $plat);
                if(!empty($pasien)) $this->db->like('mp.nama_pgl', $pasien);
                
                $count_result = $this->db->get()->row();
                $jml = $count_result->total;
            }
            
            if($jml > 0) {
                // Config Pagination
                $config['base_url']              = base_url('laporan/data_omset.php?case='.$case.(!empty($plat) ? '&plat='.$plat : '').(!empty($poli) ? '&poli='.$poli : '').(!empty($tipe) ? '&tipe='.$tipe : '').(!empty($tgl) ? '&tgl='.$tgl : '').(!empty($tgl_awal) ? '&tgl_awal='.$tgl_awal : '').(!empty($tgl_akhir) ? '&tgl_akhir='.$tgl_akhir : '').(!empty($jml) ? '&jml='.$jml : ''));
                $config['total_rows']            = $jml;
                
                $config['query_string_segment']  = 'halaman';
                $config['page_query_string']     = TRUE;
                $config['per_page']              = $pengaturan->jml_item;
                $config['num_links']             = 3;
                
                $config['first_tag_open']        = '<li class="page-item">';
                $config['first_tag_close']       = '</li>';
                
                $config['prev_tag_open']         = '<li class="page-item">';
                $config['prev_tag_close']        = '</li>';
                
                $config['num_tag_open']          = '<li class="page-item">';
                $config['num_tag_close']         = '</li>';
                
                $config['next_tag_open']         = '<li class="page-item">';
                $config['next_tag_close']        = '</li>';
                
                $config['last_tag_open']         = '<li class="page-item">';
                $config['last_tag_close']        = '</li>';
                
                $config['cur_tag_open']          = '<li class="page-item"><a href="#" class="page-link text-dark"><b>';
                $config['cur_tag_close']         = '</b></a></li>';
                
                $config['first_link']            = '&laquo;';
                $config['prev_link']             = '&lsaquo;';
                $config['next_link']             = '&rsaquo;';
                $config['last_link']             = '&raquo;';
                $config['anchor_class']          = 'class="page-link"';
                
                // Initializing Config Pagination
                $this->pagination->initialize($config);
                
                // Pagination Data
                $data['total_rows'] = $config['total_rows'];
                $data['PerPage']    = $config['per_page'];
                $data['pagination'] = $this->pagination->create_links();
                
                // Apply filters based on case
                switch ($case) {
                    case 'per_tanggal':
                        // Prepare base query for summary data
                        $this->db->select('SUM(tmd.harga) AS jml_harga, SUM(tmd.jml) AS jml_qty, 
                            SUM(tmd.diskon) AS jml_diskon, SUM(tmd.potongan) AS jml_potongan, 
                            SUM(tmd.potongan_poin) AS jml_potongan_poin, SUM(tmd.subtotal) AS jml_gtotal, 
                            SUM(tmd.harga * tmd.jml) AS jml_subtotal')
                            ->from('tbl_trans_medcheck_det tmd')
                            ->join('tbl_trans_medcheck tm', 'tmd.id_medcheck = tm.id')
                            ->join('tbl_m_pasien mp', 'tm.id_pasien = mp.id')
                            ->where('tm.status_hps', '0')
                            ->where('tm.status_bayar', '1')
                            ->where('tmd.status_pkt', '0')
                            ->where('DATE(tm.tgl_bayar)', $tgl);
                        
                        if(!empty($tipe)) $this->db->where('tm.tipe', $tipe);
                        if(!empty($tipe_byr)) $this->db->where('tm.tipe_bayar', $tipe_byr);
                        if(!empty($poli)) $this->db->where('tm.id_poli', $poli);
                        if(!empty($plat)) $this->db->where('tm.metode', $plat);
                        if(!empty($pasien)) $this->db->like('mp.nama_pgl', $pasien);
                        
                        $data['sql_omset_row'] = $this->db->get()->row();
                        
                        // Prepare query for paginated data
                        $this->db->select('tmd.id AS id, tm.id AS id_medcheck, tm.id_pasien AS id_pasien, tm.id_poli AS id_poli, 
                            tm.id_dokter AS id_dokter, tmd.id_item AS id_item, tmd.id_item_kat AS id_item_kat, 
                            tmd.tgl_simpan AS tgl_simpan, tm.tgl_masuk AS tgl_masuk, tm.tgl_bayar AS tgl_bayar, 
                            tm.no_akun AS no_akun, tm.no_rm AS no_rm, mp.nama_pgl AS nama_pgl, mp.nama_pgl AS pasien, 
                            mp.tgl_lahir AS tgl_lahir, tmd.kode AS kode, tmd.item AS item, tmd.jml AS jml, 
                            tmd.harga AS harga, tmd.diskon AS diskon, tmd.potongan AS potongan, tmd.potongan_poin AS potongan_poin, 
                            tmd.subtotal AS subtotal, tm.jml_gtotal AS jml_gtotal, tmd.status_pkt AS status_pkt, 
                            tmd.status AS status, tm.tipe AS tipe, tm.tipe_bayar AS tipe_bayar, tm.metode AS metode,
                            SUM(tmd.diskon) AS jml_diskon, SUM(tmd.potongan) AS jml_potongan, SUM(tmd.potongan_poin) AS potongan_poin, 
                            SUM(tmd.subtotal) AS jml_gtotal')
                            ->from('tbl_trans_medcheck_det tmd')
                            ->join('tbl_trans_medcheck tm', 'tmd.id_medcheck = tm.id')
                            ->join('tbl_m_pasien mp', 'tm.id_pasien = mp.id')
                            ->where('tm.status_hps', '0')
                            ->where('tm.status_bayar', '1')
                            ->where('tmd.status_pkt', '0')
                            ->where('DATE(tm.tgl_bayar)', $tgl);
                        
                        if(!empty($tipe)) $this->db->where('tm.tipe', $tipe);
                        if(!empty($tipe_byr)) $this->db->where('tm.tipe_bayar', $tipe_byr);
                        if(!empty($poli)) $this->db->where('tm.id_poli', $poli);
                        if(!empty($plat)) $this->db->where('tm.metode', $plat);
                        if(!empty($pasien)) $this->db->like('mp.nama_pgl', $pasien);
                        
                        $this->db->group_by('tm.id_pasien');
                        $this->db->order_by('tm.id', 'DESC');
                        $this->db->limit($config['per_page'], $hal);
                        
                        $data['sql_omset'] = $this->db->get()->result();
                        break;
                    
                    case 'per_rentang':
                        // Prepare base query for summary data
                        $this->db->select('SUM(tmd.harga) AS jml_harga, SUM(tmd.jml) AS jml_qty, 
                        SUM(tmd.diskon) AS jml_diskon, SUM(tmd.potongan) AS jml_potongan, 
                        SUM(tmd.potongan_poin) AS jml_potongan_poin, SUM(tmd.subtotal) AS jml_gtotal, 
                        SUM(tmd.harga * tmd.jml) AS jml_subtotal')
                            ->from('tbl_trans_medcheck_det tmd')
                            ->join('tbl_trans_medcheck tm', 'tmd.id_medcheck = tm.id')
                            ->join('tbl_m_pasien mp', 'tm.id_pasien = mp.id')
                            ->where('tm.status_hps', '0')
                            ->where('tm.status_bayar', '1')
                            ->where('tmd.status_pkt', '0')
                            ->where('DATE(tm.tgl_bayar) >=', $tgl_awal)
                            ->where('DATE(tm.tgl_bayar) <=', $tgl_akhir);
                        
                        if(!empty($tipe)) $this->db->where('tm.tipe', $tipe);
                        if(!empty($tipe_byr)) $this->db->where('tm.tipe_bayar', $tipe_byr);
                        if(!empty($poli)) $this->db->where('tm.id_poli', $poli);
                        if(!empty($plat)) $this->db->where('tm.metode', $plat);
                        if(!empty($pasien)) $this->db->like('mp.nama_pgl', $pasien);
                        
                        $data['sql_omset_row'] = $this->db->get()->row();
                        
                        // Prepare query for paginated data
                        $this->db->select('tmd.id AS id, tm.id AS id_medcheck, tm.id_pasien AS id_pasien, tm.id_poli AS id_poli, 
                            tm.id_dokter AS id_dokter, tmd.id_item AS id_item, tmd.id_item_kat AS id_item_kat, 
                            tmd.tgl_simpan AS tgl_simpan, tm.tgl_masuk AS tgl_masuk, tm.tgl_bayar AS tgl_bayar, 
                            tm.no_akun AS no_akun, tm.no_rm AS no_rm, mp.nama_pgl AS nama_pgl, mp.nama_pgl AS pasien, 
                            mp.tgl_lahir AS tgl_lahir, tmd.kode AS kode, tmd.item AS item, tmd.jml AS jml, 
                            tmd.harga AS harga, tmd.diskon AS diskon, tmd.potongan AS potongan, tmd.potongan_poin AS potongan_poin, 
                            tmd.subtotal AS subtotal, tm.jml_gtotal AS jml_gtotal, tmd.status_pkt AS status_pkt, 
                            tmd.status AS status, tm.tipe AS tipe, tm.tipe_bayar AS tipe_bayar, tm.metode AS metode,
                            SUM(tmd.diskon) AS jml_diskon, SUM(tmd.potongan) AS jml_potongan, SUM(tmd.potongan_poin) AS potongan_poin, 
                            SUM(tmd.subtotal) AS jml_gtotal')
                            ->from('tbl_trans_medcheck_det tmd')
                            ->join('tbl_trans_medcheck tm', 'tmd.id_medcheck = tm.id')
                            ->join('tbl_m_pasien mp', 'tm.id_pasien = mp.id')
                            ->where('tm.status_hps', '0')
                            ->where('tm.status_bayar', '1')
                            ->where('tmd.status_pkt', '0')
                            ->where('DATE(tm.tgl_bayar) >=', $tgl_awal)
                            ->where('DATE(tm.tgl_bayar) <=', $tgl_akhir);
                        
                        if(!empty($tipe)) $this->db->where('tm.tipe', $tipe);
                        if(!empty($tipe_byr)) $this->db->where('tm.tipe_bayar', $tipe_byr);
                        if(!empty($poli)) $this->db->where('tm.id_poli', $poli);
                        if(!empty($plat)) $this->db->where('tm.metode', $plat);
                        if(!empty($pasien)) $this->db->like('mp.nama_pgl', $pasien);
                        
                        $this->db->group_by('tm.id_pasien, tm.tgl_masuk');
                        $this->db->order_by('tm.id', 'DESC');
                        $this->db->limit($config['per_page'], $hal);
                        
                        $data['sql_omset'] = $this->db->get()->result();
                        break;
                }
            } else {
                // Initialize empty data when no results
                $data['sql_omset'] = array();
                $data['sql_omset_row'] = null;
                $data['total_rows'] = 0;
                $data['PerPage'] = $pengaturan->jml_item;
                $data['pagination'] = '';
            }
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/laporan/sidebar_lap';
            /* --- Sidebar Menu --- */
            
            /* Load view tampilan */
            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/laporan/data_omset', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    public function data_omset_poli(){
        if (akses::aksesLogin() == TRUE) {
            $case                   = $this->input->get('case');
            $hal                    = $this->input->get('halaman');
            $jml                    = $this->input->get('jml');
            $tgl                    = $this->input->get('tgl');
            $tgl_awal               = $this->input->get('tgl_awal');
            $tgl_akhir              = $this->input->get('tgl_akhir');
            $poli                   = $this->input->get('poli');
            $tipe                   = $this->input->get('tipe');
            $status                 = $this->input->get('status');
            $pengaturan             = $this->db->get('tbl_pengaturan')->row();
            $st                     = json_decode(general::dekrip($status));
            
            $data['sql_doc']        = $this->db->where('id_user_group', '10')->get('tbl_m_karyawan')->result();
            $data['sql_poli']       = $this->db->get('tbl_m_poli')->result();
            $data['sql_plat']       = $this->db->get('tbl_m_platform')->result();
            $data['sql_penjamin']   = $this->db->where('status', '1')->get('tbl_m_penjamin')->result();
            
            $data['hasError'] = $this->session->flashdata('form_error');
            
            // Config Pagination
            $config['base_url']              = base_url('laporan/data_omset_poli.php?case='.$case.(!empty($tipe) ? '&tipe='.$tipe : '').(!empty($poli) ? '&poli='.$poli : '').(!empty($status) ? '&status='.$status : '').(!empty($tgl) ? '&tgl='.$tgl : '').(!empty($tgl_awal) ? '&tgl_awal='.$tgl_awal : '').(!empty($tgl_akhir) ? '&tgl_akhir='.$tgl_akhir : '').(!empty($jml) ? '&jml='.$jml : ''));
            $config['total_rows']            = $jml;
            
            $config['query_string_segment']  = 'halaman';
            $config['page_query_string']     = TRUE;
            $config['per_page']              = $pengaturan->jml_item;
            $config['num_links']             = 3;
            
            $config['first_tag_open']        = '<li class="page-item">';
            $config['first_tag_close']       = '</li>';
            
            $config['prev_tag_open']         = '<li class="page-item">';
            $config['prev_tag_close']        = '</li>';
            
            $config['num_tag_open']          = '<li class="page-item">';
            $config['num_tag_close']         = '</li>';
            
            $config['next_tag_open']         = '<li class="page-item">';
            $config['next_tag_close']        = '</li>';
            
            $config['last_tag_open']         = '<li class="page-item">';
            $config['last_tag_close']        = '</li>';
            
            $config['cur_tag_open']          = '<li class="page-item"><a href="#" class="page-link text-dark"><b>';
            $config['cur_tag_close']         = '</b></a></li>';
            
            $config['first_link']            = '&laquo;';
            $config['prev_link']             = '&lsaquo;';
            $config['next_link']             = '&rsaquo;';
            $config['last_link']             = '&raquo;';
            $config['anchor_class']          = 'class="page-link"';
                        
            switch ($case){
                case 'per_tanggal':
                    if(!empty($hal)){
                        $data['sql_omset'] = $this->db->select('tmd.id AS id, tm.id AS id_medcheck, tm.id_pasien AS id_pasien, 
                                        tm.id_poli AS id_poli, tm.id_dokter AS id_dokter, tmd.id_item AS id_item, 
                                        tmd.id_item_kat AS id_item_kat, tmd.tgl_simpan AS tgl_simpan, 
                                        tm.tgl_masuk AS tgl_masuk, tm.tgl_bayar AS tgl_bayar, tm.no_akun AS no_akun, 
                                        tm.no_rm AS no_rm, mp.nama_pgl AS nama_pgl, mp.nama_pgl AS pasien, 
                                        mp.tgl_lahir AS tgl_lahir, tmd.kode AS kode, tmd.item AS item, 
                                        tmd.jml AS jml, tmd.harga AS harga, tmd.diskon AS diskon, 
                                        tmd.potongan AS potongan, tmd.potongan_poin AS potongan_poin, 
                                        tmd.subtotal AS subtotal, tm.jml_gtotal AS jml_gtotal, 
                                        tmd.status_pkt AS status_pkt, tmd.status AS status, 
                                        tm.tipe AS tipe, tm.tipe_bayar AS tipe_bayar, tm.metode AS metode')
                            ->from('tbl_trans_medcheck_det tmd')
                            ->join('tbl_trans_medcheck tm', 'tmd.id_medcheck = tm.id')
                            ->join('tbl_m_pasien mp', 'tm.id_pasien = mp.id')
                            ->where('tm.status_hps', '0')
                            ->where('tm.status_bayar', '1')
                            ->where('DATE(tm.tgl_bayar)', $tgl)
                            ->where_in('tmd.id_item_kat', $st)
                            ->like('tm.id_poli', $poli, (!empty($poli) ? 'none' : ''))
                            ->like('tm.tipe', $tipe, (!empty($tipe) ? 'none' : ''))
                            ->group_by('tm.id_pasien', 'tm.tipe')
                            ->limit($config['per_page'], $hal)
                            ->order_by('tmd.id', 'desc')
                            ->get()->result();
                    }else{
                        $data['sql_omset'] = $this->db->select('tmd.id AS id, tm.id AS id_medcheck, tm.id_pasien AS id_pasien, 
                                        tm.id_poli AS id_poli, tm.id_dokter AS id_dokter, tmd.id_item AS id_item, 
                                        tmd.id_item_kat AS id_item_kat, tmd.tgl_simpan AS tgl_simpan, 
                                        tm.tgl_masuk AS tgl_masuk, tm.tgl_bayar AS tgl_bayar, tm.no_akun AS no_akun, 
                                        tm.no_rm AS no_rm, mp.nama_pgl AS nama_pgl, mp.nama_pgl AS pasien, 
                                        mp.tgl_lahir AS tgl_lahir, tmd.kode AS kode, tmd.item AS item, 
                                        tmd.jml AS jml, tmd.harga AS harga, tmd.diskon AS diskon, 
                                        tmd.potongan AS potongan, tmd.potongan_poin AS potongan_poin, 
                                        tmd.subtotal AS subtotal, tm.jml_gtotal AS jml_gtotal, 
                                        tmd.status_pkt AS status_pkt, tmd.status AS status, 
                                        tm.tipe AS tipe, tm.tipe_bayar AS tipe_bayar, tm.metode AS metode')
                            ->from('tbl_trans_medcheck_det tmd')
                            ->join('tbl_trans_medcheck tm', 'tmd.id_medcheck = tm.id')
                            ->join('tbl_m_pasien mp', 'tm.id_pasien = mp.id')
                            ->where('tm.status_hps', '0')
                            ->where('tm.status_bayar', '1')
                            ->where('DATE(tm.tgl_bayar)', $tgl)
                            ->where_in('tmd.id_item_kat', $st)
                            ->like('tm.id_poli', $poli, (!empty($poli) ? 'none' : ''))
                            ->like('tm.tipe', $tipe, (!empty($tipe) ? 'none' : ''))
                            ->group_by('tm.id_pasien', 'tm.tipe')
                            ->limit($config['per_page'])
                            ->order_by('tmd.id', 'desc')
                            ->get()->result();                        
                    }
                    
                    $data['sql_oms_tot'] = $this->db->select('SUM(tmd.subtotal) AS jml_gtotal')
                            ->from('tbl_trans_medcheck_det tmd')
                            ->join('tbl_trans_medcheck tm', 'tmd.id_medcheck = tm.id')
                            ->join('tbl_m_pasien mp', 'tm.id_pasien = mp.id')
                            ->where('tm.status_hps', '0')
                            ->where('tm.status_bayar', '1')
                            ->where('DATE(tm.tgl_simpan)', $tgl)
                            ->where_in('tmd.id_item_kat', $st)
                            ->like('tm.id_poli', $poli, (!empty($poli) ? 'none' : ''))
                            ->like('tm.tipe', $tipe, (!empty($tipe) ? 'none' : ''))
                            ->group_by('tm.id_pasien')
                            ->order_by('tmd.id', 'desc')
                            ->get()->row();
                    break;
                
                case 'per_rentang':
                    if(!empty($jml)){
                        $data['sql_omset'] = $this->db->select('tmd.id AS id, tm.id AS id_medcheck, tm.id_pasien AS id_pasien, 
                                        tm.id_poli AS id_poli, tm.id_dokter AS id_dokter, tmd.id_item AS id_item, 
                                        tmd.id_item_kat AS id_item_kat, tmd.tgl_simpan AS tgl_simpan, 
                                        tm.tgl_masuk AS tgl_masuk, tm.tgl_bayar AS tgl_bayar, tm.no_akun AS no_akun, 
                                        tm.no_rm AS no_rm, mp.nama_pgl AS nama_pgl, mp.nama_pgl AS pasien, 
                                        mp.tgl_lahir AS tgl_lahir, tmd.kode AS kode, tmd.item AS item, 
                                        tmd.jml AS jml, tmd.harga AS harga, tmd.diskon AS diskon, 
                                        tmd.potongan AS potongan, tmd.potongan_poin AS potongan_poin, 
                                        tmd.subtotal AS subtotal, tm.jml_gtotal AS jml_gtotal, 
                                        tmd.status_pkt AS status_pkt, tmd.status AS status, 
                                        tm.tipe AS tipe, tm.tipe_bayar AS tipe_bayar, tm.metode AS metode')
                            ->from('tbl_trans_medcheck_det tmd')
                            ->join('tbl_trans_medcheck tm', 'tmd.id_medcheck = tm.id')
                            ->join('tbl_m_pasien mp', 'tm.id_pasien = mp.id')
                            ->where('tm.status_hps', '0')
                            ->where('tm.status_bayar', '1')
                            ->where('DATE(tm.tgl_simpan) >=', $tgl_awal)
                            ->where('DATE(tm.tgl_simpan) <=', $tgl_akhir)
                            ->where_in('tmd.id_item_kat', $st)
                            ->like('tm.id_poli', $poli, (!empty($poli) ? 'none' : ''))
                            ->like('tm.tipe', $tipe, (!empty($tipe) ? 'none' : ''))
                            ->group_by('tm.id_pasien', 'tm.tipe')
                            ->order_by('tmd.id', 'desc')
                            ->get()->result();
                    }else{
                        $data['sql_omset'] = $this->db->select('tmd.id AS id, tm.id AS id_medcheck, tm.id_pasien AS id_pasien, 
                                        tm.id_poli AS id_poli, tm.id_dokter AS id_dokter, tmd.id_item AS id_item, 
                                        tmd.id_item_kat AS id_item_kat, tmd.tgl_simpan AS tgl_simpan, 
                                        tm.tgl_masuk AS tgl_masuk, tm.tgl_bayar AS tgl_bayar, tm.no_akun AS no_akun, 
                                        tm.no_rm AS no_rm, mp.nama_pgl AS nama_pgl, mp.nama_pgl AS pasien, 
                                        mp.tgl_lahir AS tgl_lahir, tmd.kode AS kode, tmd.item AS item, 
                                        tmd.jml AS jml, tmd.harga AS harga, tmd.diskon AS diskon, 
                                        tmd.potongan AS potongan, tmd.potongan_poin AS potongan_poin, 
                                        tmd.subtotal AS subtotal, tm.jml_gtotal AS jml_gtotal, 
                                        tmd.status_pkt AS status_pkt, tmd.status AS status, 
                                        tm.tipe AS tipe, tm.tipe_bayar AS tipe_bayar, tm.metode AS metode')
                            ->from('tbl_trans_medcheck_det tmd')
                            ->join('tbl_trans_medcheck tm', 'tmd.id_medcheck = tm.id')
                            ->join('tbl_m_pasien mp', 'tm.id_pasien = mp.id')
                            ->where('tm.status_hps', '0')
                            ->where('tm.status_bayar', '1')
                            ->where('DATE(tm.tgl_simpan) >=', $tgl_awal)
                            ->where('DATE(tm.tgl_simpan) <=', $tgl_akhir)
                            ->where_in('tmd.id_item_kat', $st)
                            ->like('tm.id_poli', $poli, (!empty($poli) ? 'none' : ''))
                            ->like('tm.tipe', $tipe, (!empty($tipe) ? 'none' : ''))
                            ->group_by('tm.id_pasien', 'tm.tipe')
                            ->order_by('tmd.id', 'desc')
                            ->get()->result();
                    }
                    
                    $data['sql_oms_tot'] = $this->db->select('SUM(tmd.subtotal) AS jml_gtotal')
                            ->from('tbl_trans_medcheck_det tmd')
                            ->join('tbl_trans_medcheck tm', 'tmd.id_medcheck = tm.id')
                            ->join('tbl_m_pasien mp', 'tm.id_pasien = mp.id')
                            ->where('tm.status_hps', '0')
                            ->where('tm.status_bayar', '1')
                            ->where('DATE(tm.tgl_simpan) >=', $tgl_awal)
                            ->where('DATE(tm.tgl_simpan) <=', $tgl_akhir)
                            ->where_in('tmd.id_item_kat', $st)
                            ->like('tm.id_poli', $poli, (!empty($poli) ? 'none' : ''))
                            ->like('tm.tipe', $tipe, (!empty($tipe) ? 'none' : ''))
                            ->group_by('tm.id_pasien', 'tm.tipe')
                            ->order_by('tmd.id', 'desc')
                            ->get()->row();
                    break;
            }
            
            // Initializing Config Pagination
            $this->pagination->initialize($config);

            // Pagination Data
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();
        
            $data['sql_kat']        = $this->db->where('status', '1')->where('status_lab', '0')->get('tbl_m_kategori')->result();
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/laporan/sidebar_lap';
            /* --- Sidebar Menu --- */
            
            /* Load view tampilan */
            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/laporan/data_omset_poli', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
            
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_omset_detail(){
        if (akses::aksesLogin() == TRUE) {
            $dokter             = $this->input->get('id_dokter');
            $poli               = $this->input->get('poli');
            $tipe               = $this->input->get('tipe');
            $status             = $this->input->get('status');
            $jml                = $this->input->get('jml');
            $tgl                = $this->input->get('tgl');
            $tgl_awal           = $this->input->get('tgl_awal');
            $tgl_akhir          = $this->input->get('tgl_akhir');
            $case               = $this->input->get('case');
            $hal                = $this->input->get('halaman');
            
            $pengaturan         = $this->db->get('tbl_pengaturan')->row();
            
            $data['sql_doc']    = $this->db->where('id_user_group', '10')->get('tbl_m_karyawan')->result();
            $data['sql_poli']   = $this->db->get('tbl_m_poli')->result();
            $data['sql_plat']   = $this->db->get('tbl_m_platform')->result();
            
            $data['hasError'] = $this->session->flashdata('form_error');
            
            // Base query for all cases
            $base_query = $this->db->select('tmd.id AS id, tm.id AS id_medcheck, tm.id_pasien AS id_pasien, 
                                            tm.id_poli AS id_poli, tm.id_dokter AS id_dokter, tmd.id_item AS id_item, 
                                            tmd.id_item_kat AS id_item_kat, tmd.tgl_simpan AS tgl_simpan, 
                                            tm.tgl_masuk AS tgl_masuk, tm.tgl_bayar AS tgl_bayar, tm.no_akun AS no_akun, 
                                            tm.no_rm AS no_rm, mp.nama_pgl AS nama_pgl, mp.nama_pgl AS pasien, 
                                            mp.tgl_lahir AS tgl_lahir, tmd.kode AS kode, tmd.item AS item, 
                                            tmd.jml AS jml, tmd.harga AS harga, tmd.diskon AS diskon, 
                                            tmd.potongan AS potongan, tmd.potongan_poin AS potongan_poin, 
                                            tmd.subtotal AS subtotal, tm.jml_gtotal AS jml_gtotal, 
                                            tmd.status_pkt AS status_pkt, tmd.status AS status, 
                                            tm.tipe AS tipe, tm.tipe_bayar AS tipe_bayar, tm.metode AS metode')
                                ->from('tbl_trans_medcheck_det tmd')
                                ->join('tbl_trans_medcheck tm', 'tmd.id_medcheck = tm.id')
                                ->join('tbl_m_pasien mp', 'tm.id_pasien = mp.id')
                                ->where('tm.status_hps', '0')
                                ->where('tm.status_bayar', '1');
            
            if (!empty($poli)) {
                $base_query->like('tm.id_poli', $poli);
            }
            
            if (!empty($tipe)) {
                $base_query->like('tm.tipe', $tipe);
            }
            
            if (!empty($status)) {
                $base_query->like('tmd.status', $status);
            }
            
            if (!empty($dokter)) {
                $base_query->where('tm.id_dokter', general::dekrip($dokter));
            }
            
            // Config Pagination
            $config['base_url']              = base_url('laporan/data_omset_detail.php?case='.$case.(!empty($tipe) ? '&tipe='.$tipe : '').(!empty($poli) ? '&poli='.$poli : '').(!empty($status) ? '&status='.$status : '').(!empty($tgl) ? '&tgl='.$tgl : '').(!empty($tgl_awal) ? '&tgl_awal='.$tgl_awal : '').(!empty($tgl_akhir) ? '&tgl_akhir='.$tgl_akhir : '').(!empty($jml) ? '&jml='.$jml : ''));
            $config['query_string_segment']  = 'halaman';
            $config['page_query_string']     = TRUE;
            $config['per_page']              = $pengaturan->jml_item;
            $config['num_links']             = 3;
            
            $config['first_tag_open']        = '<li class="page-item">';
            $config['first_tag_close']       = '</li>';
            
            $config['prev_tag_open']         = '<li class="page-item">';
            $config['prev_tag_close']        = '</li>';
            
            $config['num_tag_open']          = '<li class="page-item">';
            $config['num_tag_close']         = '</li>';
            
            $config['next_tag_open']         = '<li class="page-item">';
            $config['next_tag_close']        = '</li>';
            
            $config['last_tag_open']         = '<li class="page-item">';
            $config['last_tag_close']        = '</li>';
            
            $config['cur_tag_open']          = '<li class="page-item"><a href="#" class="page-link text-dark"><b>';
            $config['cur_tag_close']         = '</b></a></li>';
            
            $config['first_link']            = '&laquo;';
            $config['prev_link']             = '&lsaquo;';
            $config['next_link']             = '&rsaquo;';
            $config['last_link']             = '&raquo;';
            $config['anchor_class']          = 'class="page-link"';
            
            switch ($case){
                case 'per_tanggal':
                    $base_query->where('DATE(tmd.tgl_simpan)', $tgl);
                    
                    // Get total count for pagination
                    $count_query = clone $base_query;
                    $jml = $count_query->count_all_results();
                    $config['total_rows'] = $jml;
                    
                    // Get data with pagination
                    if(!empty($hal)){
                        $data['sql_penj'] = $base_query->order_by('tmd.id', 'DESC')
                                                      ->limit($config['per_page'], $hal)
                                                      ->get()->result();
                    } else {
                        $data['sql_penj'] = $base_query->order_by('tmd.id', 'DESC')
                                                      ->limit($config['per_page'])
                                                      ->get()->result();
                    }
                    
                    // Get summary data
                    $data['sql_omset_pas'] = $this->db->select('mp.nama_pgl, SUM(tmd.subtotal) as subtotal')
                                                     ->from('tbl_trans_medcheck_det tmd')
                                                     ->join('tbl_trans_medcheck tm', 'tmd.id_medcheck = tm.id')
                                                     ->join('tbl_m_pasien mp', 'tm.id_pasien = mp.id')
                                                     ->where('tm.status_hps', '0')
                                                     ->where('tm.status_bayar', '1')
                                                     ->where('DATE(tmd.tgl_simpan)', $tgl)
                                                     ->group_by('mp.nama_pgl')
                                                     ->get();
                    break;
                
                case 'per_rentang':
                    $base_query->where('DATE(tmd.tgl_simpan) >=', $tgl_awal)
                              ->where('DATE(tmd.tgl_simpan) <=', $tgl_akhir);
                    
                    // Get total count for pagination
                    $count_query = clone $base_query;
                    $jml = $count_query->count_all_results();
                    $config['total_rows'] = $jml;
                    
                    // Get data with pagination
                    if(!empty($hal)){
                        $data['sql_penj'] = $base_query->order_by('tmd.id', 'DESC')
                                                      ->limit($config['per_page'], $hal)
                                                      ->get()->result();
                    } else {
                        $data['sql_penj'] = $base_query->order_by('tmd.id', 'DESC')
                                                      ->limit($config['per_page'])
                                                      ->get()->result();
                    }
                    
                    // Get summary data
                    $data['sql_omset_pas'] = $this->db->select('mp.nama_pgl, SUM(tmd.subtotal) as subtotal')
                                                     ->from('tbl_trans_medcheck_det tmd')
                                                     ->join('tbl_trans_medcheck tm', 'tmd.id_medcheck = tm.id')
                                                     ->join('tbl_m_pasien mp', 'tm.id_pasien = mp.id')
                                                     ->where('tm.status_hps', '0')
                                                     ->where('tm.status_bayar', '1')
                                                     ->where('DATE(tmd.tgl_simpan) >=', $tgl_awal)
                                                     ->where('DATE(tmd.tgl_simpan) <=', $tgl_akhir)
                                                     ->group_by('mp.nama_pgl')
                                                     ->get();
                    break;
            }
            
            // Initializing Config Pagination
            $this->pagination->initialize($config);

            // Pagination Data
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/laporan/sidebar_lap';
            /* --- Sidebar Menu --- */
            
            /* Load view tampilan */
            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/laporan/data_omset_detail', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_omset_jasa(){
        if (akses::aksesLogin() == TRUE) {
            $dokter             = $this->input->get('id_dokter');
            $poli               = $this->input->get('poli');
            $plat               = $this->input->get('plat');
            $jml                = $this->input->get('jml');
            $tgl                = $this->input->get('tgl');
            $tgl_awal           = $this->input->get('tgl_awal');
            $tgl_akhir          = $this->input->get('tgl_akhir');
            $case               = $this->input->get('case');
            $hal                = $this->input->get('halaman');
            $pasien_id          = $this->input->get('id_pasien');
            $pasien             = $this->input->get('pasien');
            $pengaturan         = $this->db->get('tbl_pengaturan')->row();
            
            $data['sql_doc']    = $this->db->where('id_user_group', '10')->get('tbl_m_karyawan')->result();
            $data['sql_poli']   = $this->db->get('tbl_m_poli')->result();
            $data['sql_plat']   = $this->db->get('tbl_m_platform')->result();
            
            if($jml > 0){
                $data['hasError'] = $this->session->flashdata('form_error');
                
                // Config Pagination
                $config['base_url']              = base_url('laporan/data_stok_keluar.php?case='.$case.(!empty($tgl) ? '&tgl='.$tgl : '').(!empty($poli) ? '&poli='.$poli : '').(!empty($tgl_awal) ? '&tgl_awal='.$tgl_awal : '').(!empty($tgl_akhir) ? '&tgl_akhir='.$tgl_akhir : '').(!empty($jml) ? '&jml='.$jml : ''));
                $config['total_rows']            = $jml;
                
                $config['query_string_segment']  = 'halaman';
                $config['page_query_string']     = TRUE;
                $config['per_page']              = $pengaturan->jml_item;
                $config['num_links']             = 3;
                
                $config['first_tag_open']        = '<li class="page-item">';
                $config['first_tag_close']       = '</li>';
                
                $config['prev_tag_open']         = '<li class="page-item">';
                $config['prev_tag_close']        = '</li>';
                
                $config['num_tag_open']          = '<li class="page-item">';
                $config['num_tag_close']         = '</li>';
                
                $config['next_tag_open']         = '<li class="page-item">';
                $config['next_tag_close']        = '</li>';
                
                $config['last_tag_open']         = '<li class="page-item">';
                $config['last_tag_close']        = '</li>';
                
                $config['cur_tag_open']          = '<li class="page-item"><a href="#" class="page-link text-dark"><b>';
                $config['cur_tag_close']         = '</b></a></li>';
                
                $config['first_link']            = '&laquo;';
                $config['prev_link']             = '&lsaquo;';
                $config['next_link']             = '&rsaquo;';
                $config['last_link']             = '&raquo;';
                $config['anchor_class']          = 'class="page-link"';
            
                $sql_doc = $this->db->where('id', general::dekrip($dokter))->get('tbl_m_karyawan')->row();
                
                switch ($case){
                    case 'per_tanggal':
                        if(!empty($jml)){
                            $data['sql_penj']     = $this->db->select('tbl_trans_medcheck.id, tbl_trans_medcheck.tipe_bayar, tbl_trans_medcheck.tgl_simpan, tbl_trans_medcheck.no_rm, tbl_trans_medcheck.no_nota, tbl_trans_medcheck.tipe, tbl_m_pasien.nama_pgl, tbl_m_pasien.tgl_lahir, tbl_m_pasien.alamat, tbl_m_pasien.alamat_dom, tbl_m_pasien.instansi, tbl_m_pasien.instansi_alamat, tbl_trans_medcheck_det.id AS id_medcheck_det, tbl_trans_medcheck_det.kode, tbl_trans_medcheck_det.item, tbl_trans_medcheck_det.harga, tbl_trans_medcheck_det.jml, tbl_trans_medcheck_det.subtotal')
                                                              ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_det.id_medcheck')
                                                              ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
                                                              ->where('tbl_trans_medcheck.status_bayar', '1')
                                                              ->where('DATE(tbl_trans_medcheck.tgl_bayar)', $tgl)
                                                              ->where('tbl_trans_medcheck_det.status', '2')
                                                              ->like('tbl_trans_medcheck.pasien', $pasien)
                                                              ->like('tbl_trans_medcheck.tipe', $poli, (!empty($poli) ? 'none' : '')) 
                                                              ->limit($config['per_page'], $hal)
                                                          ->get('tbl_trans_medcheck_det')->result(); 
                        }else{
                            $data['sql_penj']     = $this->db->select('tbl_trans_medcheck.id, tbl_trans_medcheck.tipe_bayar, tbl_trans_medcheck.tgl_simpan, tbl_trans_medcheck.no_rm, tbl_trans_medcheck.no_nota, tbl_trans_medcheck.tipe, tbl_m_pasien.nama_pgl, tbl_m_pasien.tgl_lahir, tbl_m_pasien.alamat, tbl_m_pasien.alamat_dom, tbl_m_pasien.instansi, tbl_m_pasien.instansi_alamat, tbl_trans_medcheck_det.id AS id_medcheck_det, tbl_trans_medcheck_det.kode, tbl_trans_medcheck_det.item, tbl_trans_medcheck_det.harga, tbl_trans_medcheck_det.jml, tbl_trans_medcheck_det.subtotal')
                                                              ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_det.id_medcheck')
                                                              ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
                                                              ->where('tbl_trans_medcheck.status_bayar', '1')
                                                              ->where('DATE(tbl_trans_medcheck.tgl_bayar)', $tgl)
                                                              ->where('tbl_trans_medcheck_det.status', '2')
                                                              ->like('tbl_trans_medcheck.pasien', $pasien)
                                                              ->like('tbl_trans_medcheck.tipe', $poli, (!empty($poli) ? 'none' : '')) 
                                                              ->limit($config['per_page'])
                                                          ->get('tbl_trans_medcheck_det')->result();                            
                        }
                        break;
                    
                    case 'per_rentang':
                        if(!empty($hal)){
                            $data['sql_penj']     = $this->db->select('tbl_trans_medcheck.id, tbl_trans_medcheck.tipe_bayar, tbl_trans_medcheck.tgl_simpan, tbl_trans_medcheck.no_rm, tbl_trans_medcheck.no_nota, tbl_trans_medcheck.tipe, tbl_m_pasien.nama_pgl, tbl_m_pasien.tgl_lahir, tbl_m_pasien.alamat, tbl_m_pasien.alamat_dom, tbl_m_pasien.instansi, tbl_m_pasien.instansi_alamat, tbl_trans_medcheck_det.id AS id_medcheck_det, tbl_trans_medcheck_det.kode, tbl_trans_medcheck_det.item, tbl_trans_medcheck_det.harga, tbl_trans_medcheck_det.jml, tbl_trans_medcheck_det.subtotal')
                                                              ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_det.id_medcheck')
                                                              ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
                                                              ->where('tbl_trans_medcheck.status_bayar', '1')
                                                              ->where('DATE(tbl_trans_medcheck.tgl_bayar) >=', $tgl_awal)
                                                              ->where('DATE(tbl_trans_medcheck.tgl_bayar) <=', $tgl_akhir)
                                                              ->where('tbl_trans_medcheck_det.status', '2')
                                                              ->like('tbl_trans_medcheck.pasien', $pasien)
                                                              ->like('tbl_trans_medcheck.tipe', $poli, (!empty($poli) ? 'none' : '')) 
                                                              ->order_by('tbl_trans_medcheck_det.tgl_simpan', 'ASC')
                                                              ->limit($config['per_page'], $hal)
                                                          ->get('tbl_trans_medcheck_det')->result(); 
                        }else{
                            $data['sql_penj']     = $this->db->select('tbl_trans_medcheck.id, tbl_trans_medcheck.tipe_bayar, tbl_trans_medcheck.tgl_simpan, tbl_trans_medcheck.no_rm, tbl_trans_medcheck.no_nota, tbl_trans_medcheck.tipe, tbl_m_pasien.nama_pgl, tbl_m_pasien.tgl_lahir, tbl_m_pasien.alamat, tbl_m_pasien.alamat_dom, tbl_m_pasien.instansi, tbl_m_pasien.instansi_alamat, tbl_trans_medcheck_det.id AS id_medcheck_det, tbl_trans_medcheck_det.kode, tbl_trans_medcheck_det.item, tbl_trans_medcheck_det.harga, tbl_trans_medcheck_det.jml, tbl_trans_medcheck_det.subtotal')
                                                              ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_det.id_medcheck')
                                                              ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
                                                              ->join('tbl_m_kategori', 'tbl_m_kategori.id=tbl_trans_medcheck_det.id_item_kat')
                                                              ->where('tbl_trans_medcheck.status_bayar', '1')
                                                              ->where('DATE(tbl_trans_medcheck.tgl_bayar) >=', $tgl_awal)
                                                              ->where('DATE(tbl_trans_medcheck.tgl_bayar) <=', $tgl_akhir)
                                                              ->where('tbl_trans_medcheck_det.status', '2')
                                                              ->like('tbl_trans_medcheck.pasien', $pasien)
                                                              ->like('tbl_trans_medcheck.tipe', $poli, (!empty($poli) ? 'none' : '')) 
                                                              ->order_by('tbl_trans_medcheck_det.tgl_simpan', 'ASC')
                                                              ->limit($config['per_page'])
                                                          ->get('tbl_trans_medcheck_det')->result();
                        }
                        break;
                }
                
                // Initializing Config Pagination
                $this->pagination->initialize($config);

                // Pagination Data
                $data['total_rows'] = $config['total_rows'];
                $data['PerPage']    = $config['per_page'];
                $data['pagination'] = $this->pagination->create_links();
            }
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/laporan/sidebar_lap';
            /* --- Sidebar Menu --- */
            
            /* Load view tampilan */
            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/laporan/data_omset_jasa', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_omset_dokter(){
        if (akses::aksesLogin() == TRUE) {
            $dokter             = $this->input->get('id_dokter');
            $poli               = $this->input->get('poli');
            $plat               = $this->input->get('plat');
            $jml                = $this->input->get('jml');
            $tgl                = $this->input->get('tgl');
            $tgl_awal           = $this->input->get('tgl_awal');
            $tgl_akhir          = $this->input->get('tgl_akhir');
            $case               = $this->input->get('case');
            $hal                = $this->input->get('halaman');
            $pengaturan         = $this->db->get('tbl_pengaturan')->row();
            
            if(!empty($jml)){
                $jml_hal = $jml;
            }else{
                $query = $this->db->select('tbl_trans_medcheck.id, tbl_trans_medcheck.tipe_bayar, tbl_trans_medcheck.tgl_simpan, tbl_trans_medcheck.no_rm, tbl_trans_medcheck.no_nota, tbl_trans_medcheck.tipe, tbl_m_pasien.nama_pgl, tbl_m_pasien.tgl_lahir, tbl_m_pasien.alamat, tbl_m_pasien.alamat_dom, tbl_m_pasien.instansi, tbl_m_pasien.instansi_alamat, tbl_trans_medcheck_det.id AS id_medcheck_det, tbl_trans_medcheck_det.kode, tbl_trans_medcheck_det.item, tbl_trans_medcheck_det.harga, tbl_trans_medcheck_det.jml, tbl_trans_medcheck_det.subtotal')
                        ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_det.id_medcheck')
                        ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
                        ->join('tbl_m_kategori', 'tbl_m_kategori.id=tbl_trans_medcheck_det.id_item_kat')
                        ->where('tbl_trans_medcheck.status_bayar', '1')
                        ->where('tbl_trans_medcheck_det.status !=', '4');
                
                // Add dokter filter if provided
                if(!empty($dokter)) {
                    $query->where('tbl_trans_medcheck_det.id_dokter', general::dekrip($dokter));
                }
                
                // Add date filters if provided
                if(!empty($tgl_awal) && !empty($tgl_akhir)) {
                    $query->where('DATE(tbl_trans_medcheck_det.tgl_masuk) >=', $tgl_awal);
                    $query->where('DATE(tbl_trans_medcheck_det.tgl_masuk) <=', $tgl_akhir);
                } else if(!empty($tgl)) {
                    $query->where('DATE(tbl_trans_medcheck_det.tgl_masuk)', $tgl);
                }
                
                $query->order_by('tbl_trans_medcheck_det.tgl_simpan', 'ASC');
                $jml_hal = $query->get('tbl_trans_medcheck_det')->num_rows();
            }
            
            $data['sql_doc']    = $this->db->where('id_user_group', '10')->get('tbl_m_karyawan')->result();
            $data['sql_poli']   = $this->db->get('tbl_m_poli')->result();
            $data['sql_plat']   = $this->db->get('tbl_m_platform')->result();
            
            $data['hasError'] = $this->session->flashdata('form_error');
            
            // Config Pagination
            $config['base_url']              = base_url('laporan/data_omset_dokter.php?case='.$case.(!empty($dokter) ? '&id_dokter='.$dokter : '').(!empty($tgl) ? '&tgl='.$tgl : '').(!empty($tgl_awal) ? '&tgl_awal='.$tgl_awal : '').(!empty($tgl_akhir) ? '&tgl_akhir='.$tgl_akhir : '').(!empty($jml_hal) ? '&jml='.$jml_hal : ''));
            $config['total_rows']            = $jml_hal;
            
            $config['query_string_segment']  = 'halaman';
            $config['page_query_string']     = TRUE;
            $config['per_page']              = $pengaturan->jml_item;
            $config['num_links']             = 3;
            
            // AdminLTE 3 pagination styling
            $config['full_tag_open']         = '<ul class="pagination pagination-sm">';
            $config['full_tag_close']        = '</ul>';
            
            $config['first_tag_open']        = '<li class="page-item">';
            $config['first_tag_close']       = '</li>';
            
            $config['prev_tag_open']         = '<li class="page-item">';
            $config['prev_tag_close']        = '</li>';
            
            $config['num_tag_open']          = '<li class="page-item">';
            $config['num_tag_close']         = '</li>';
            
            $config['next_tag_open']         = '<li class="page-item">';
            $config['next_tag_close']        = '</li>';
            
            $config['last_tag_open']         = '<li class="page-item">';
            $config['last_tag_close']        = '</li>';
            
            $config['cur_tag_open']          = '<li class="page-item active"><a href="#" class="page-link">';
            $config['cur_tag_close']         = '</a></li>';
            
            $config['first_link']            = '&laquo;';
            $config['prev_link']             = '&lsaquo;';
            $config['next_link']             = '&rsaquo;';
            $config['last_link']             = '&raquo;';
            $config['attributes']            = ['class' => 'page-link'];
        
            $data['sql_penj'] = [];
            
            switch ($case){
                case 'per_tanggal':
                    if(!empty($tgl)) {
                        $query = $this->db->select('tbl_trans_medcheck.id, tbl_trans_medcheck.tipe_bayar, tbl_trans_medcheck.tgl_simpan, tbl_trans_medcheck.no_rm, tbl_trans_medcheck.no_nota, tbl_trans_medcheck.tipe, tbl_m_pasien.nama_pgl, tbl_m_pasien.tgl_lahir, tbl_m_pasien.alamat, tbl_m_pasien.alamat_dom, tbl_m_pasien.instansi, tbl_m_pasien.instansi_alamat, tbl_trans_medcheck_det.id AS id_medcheck_det, tbl_trans_medcheck_det.kode, tbl_trans_medcheck_det.item, tbl_trans_medcheck_det.harga, tbl_trans_medcheck_det.jml, tbl_trans_medcheck_det.subtotal')
                            ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_det.id_medcheck')
                            ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
                            ->join('tbl_m_kategori', 'tbl_m_kategori.id=tbl_trans_medcheck_det.id_item_kat')
                            ->where('tbl_trans_medcheck.status_bayar', '1')
                            ->where('DATE(tbl_trans_medcheck_det.tgl_masuk)', $tgl)
                            ->where('tbl_trans_medcheck_det.status !=', '4');
                        
                        if(!empty($dokter)) {
                            $query->where('tbl_trans_medcheck_det.id_dokter', general::dekrip($dokter));
                        }
                        
                        $data['sql_penj'] = $query->order_by('tbl_trans_medcheck_det.tgl_simpan', 'ASC')
                            ->limit($config['per_page'], $hal ?? 0)
                            ->get('tbl_trans_medcheck_det')->result();
                    }
                    break;
                
                case 'per_rentang':
                    if(!empty($tgl_awal) && !empty($tgl_akhir)) {
                        $query = $this->db->select('tbl_trans_medcheck.id, tbl_trans_medcheck.tipe_bayar, tbl_trans_medcheck.tgl_simpan, tbl_trans_medcheck.no_rm, tbl_trans_medcheck.no_nota, tbl_trans_medcheck.tipe, tbl_m_pasien.nama_pgl, tbl_m_pasien.tgl_lahir, tbl_m_pasien.alamat, tbl_m_pasien.alamat_dom, tbl_m_pasien.instansi, tbl_m_pasien.instansi_alamat, tbl_trans_medcheck_det.id AS id_medcheck_det, tbl_trans_medcheck_det.kode, tbl_trans_medcheck_det.item, tbl_trans_medcheck_det.harga, tbl_trans_medcheck_det.jml, tbl_trans_medcheck_det.subtotal')
                            ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_det.id_medcheck')
                            ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
                            ->join('tbl_m_kategori', 'tbl_m_kategori.id=tbl_trans_medcheck_det.id_item_kat')
                            ->where('tbl_trans_medcheck.status_bayar', '1')
                            ->where('DATE(tbl_trans_medcheck_det.tgl_masuk) >=', $tgl_awal)
                            ->where('DATE(tbl_trans_medcheck_det.tgl_masuk) <=', $tgl_akhir)
                            ->where('tbl_trans_medcheck_det.status !=', '4');
                        
                        if(!empty($dokter)) {
                            $query->where('tbl_trans_medcheck_det.id_dokter', general::dekrip($dokter));
                        }
                        
                        $data['sql_penj'] = $query->order_by('tbl_trans_medcheck_det.tgl_simpan', 'ASC')
                            ->limit($config['per_page'], $hal ?? 0)
                            ->get('tbl_trans_medcheck_det')->result();
                    }
                    break;
            }

            // Initializing Config Pagination
            $this->pagination->initialize($config);

            // Pagination Data
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/laporan/sidebar_lap';
            /* --- Sidebar Menu --- */
            
            /* Load view tampilan */
            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/laporan/data_omset_dokter', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_omset_bukti(){
        if (akses::aksesLogin() == TRUE) {
            $tgl_awal           = $this->input->get('tgl_awal');
            $tgl_akhir          = $this->input->get('tgl_akhir');
            $tgl_masuk          = $this->input->get('tgl');
            $case               = $this->input->get('case');
            $hal                = $this->input->get('halaman');
            $pengaturan         = $this->db->get('tbl_pengaturan')->row();
            
            // Base query for counting total records
            $base_query = $this->db->select('
                    tbl_trans_medcheck.id AS id,
                    tbl_trans_medcheck.id_pasien AS id_pasien,
                    tbl_trans_medcheck_file.id_user AS id_user,
                    tbl_trans_medcheck_file.tgl_simpan AS tgl_simpan,
                    tbl_ion_users.first_name AS username,
                    tbl_trans_medcheck.no_rm AS no_rm,
                    tbl_trans_medcheck.pasien AS pasien,
                    tbl_trans_medcheck_file.judul AS judul,
                    tbl_trans_medcheck_file.file_name AS file_name,
                    tbl_trans_medcheck_file.status AS status
                ')
                ->from('tbl_trans_medcheck_file')
                ->join('tbl_trans_medcheck', 'tbl_trans_medcheck_file.id_medcheck = tbl_trans_medcheck.id')
                ->join('tbl_ion_users', 'tbl_trans_medcheck_file.id_user = tbl_ion_users.id')
                ->where('tbl_trans_medcheck.status_hps', '0')
                ->where('tbl_trans_medcheck_file.status', '3');
                
            // Apply date filters based on case
            if ($case == 'per_tanggal' && !empty($tgl_masuk)) {
                $base_query->where('DATE(tbl_trans_medcheck_file.tgl_simpan)', $tgl_masuk);
            } else if ($case == 'per_rentang' && !empty($tgl_awal) && !empty($tgl_akhir)) {
                $base_query->where('DATE(tbl_trans_medcheck_file.tgl_simpan) >=', $tgl_awal)
                          ->where('DATE(tbl_trans_medcheck_file.tgl_simpan) <=', $tgl_akhir);
            }
            
            // Get total count for pagination
            $jml_hal = $base_query->count_all_results('', false);
            
            // Order by most recent first
            $base_query->order_by('tbl_trans_medcheck_file.tgl_simpan', 'DESC');
            
            $data['hasError'] = $this->session->flashdata('form_error');
            
            // Config Pagination
            $config['base_url']              = base_url('laporan/data_omset_bukti.php?case='.$case.(!empty($tgl_masuk) ? '&tgl='.$tgl_masuk : '').(!empty($tgl_awal) ? '&tgl_awal='.$tgl_awal : '').(!empty($tgl_akhir) ? '&tgl_akhir='.$tgl_akhir : ''));
            $config['total_rows']            = $jml_hal;
            
            $config['query_string_segment']  = 'halaman';
            $config['page_query_string']     = TRUE;
            $config['per_page']              = $pengaturan->jml_item;
            $config['num_links']             = 3;
            
            $config['first_tag_open']        = '<li class="page-item">';
            $config['first_tag_close']       = '</li>';
            
            $config['prev_tag_open']         = '<li class="page-item">';
            $config['prev_tag_close']        = '</li>';
            
            $config['num_tag_open']          = '<li class="page-item">';
            $config['num_tag_close']         = '</li>';
            
            $config['next_tag_open']         = '<li class="page-item">';
            $config['next_tag_close']        = '</li>';
            
            $config['last_tag_open']         = '<li class="page-item">';
            $config['last_tag_close']        = '</li>';
            
            $config['cur_tag_open']          = '<li class="page-item"><a href="#" class="page-link text-dark"><b>';
            $config['cur_tag_close']         = '</b></a></li>';
            
            $config['first_link']            = '&laquo;';
            $config['prev_link']             = '&lsaquo;';
            $config['next_link']             = '&rsaquo;';
            $config['last_link']             = '&raquo;';
            $config['anchor_class']          = 'class="page-link"';
            
            // Apply pagination limit
            $base_query->limit($config['per_page'], $hal);
            
            // Execute query and get results
            $data['sql_penj'] = $base_query->get()->result();
            
            // Initializing Config Pagination
            $this->pagination->initialize($config);
            
            // Pagination Data
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/laporan/sidebar_lap';
            /* --- Sidebar Menu --- */
            
            /* Load view tampilan */
            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/laporan/data_omset_bukti', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_pembelian(){
        if (akses::aksesLogin() == TRUE) {
            $supplier   = $this->input->get('id_supplier');
            $jml        = $this->input->get('jml');
            $tgl        = $this->input->get('tgl');
            $tgl_awal   = $this->input->get('tgl_awal');
            $tgl_akhir  = $this->input->get('tgl_akhir');
            $case       = $this->input->get('case');
            $hal        = $this->input->get('halaman');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();
            
            $data['sql_supp']      = $this->db->get('tbl_m_supplier')->result();
//            $data['sql_supp_rw']   = $this->db->where('id', general::dekrip($supplier))->get('tbl_m_supplier')->row();
            
            if($jml > 0){
                $data['hasError'] = $this->session->flashdata('form_error');
                
                // Config Pagination
                $config['base_url']              = base_url('laporan/data_pembelian.php?case='.$case.(!empty($tgl) ? '&tgl='.$tgl : '').(!empty($tgl_awal) ? '&tgl_awal='.$tgl_awal : '').(!empty($tgl_akhir) ? '&tgl_akhir='.$tgl_akhir : '').(!empty($jml) ? '&jml='.$jml : ''));
                $config['total_rows']            = $jml;
                
                $config['query_string_segment']  = 'halaman';
                $config['page_query_string']     = TRUE;
                $config['per_page']              = $pengaturan->jml_item;
                $config['num_links']             = 3;
                
                $config['first_tag_open']        = '<li class="page-item">';
                $config['first_tag_close']       = '</li>';
                
                $config['prev_tag_open']         = '<li class="page-item">';
                $config['prev_tag_close']        = '</li>';
                
                $config['num_tag_open']          = '<li class="page-item">';
                $config['num_tag_close']         = '</li>';
                
                $config['next_tag_open']         = '<li class="page-item">';
                $config['next_tag_close']        = '</li>';
                
                $config['last_tag_open']         = '<li class="page-item">';
                $config['last_tag_close']        = '</li>';
                
                $config['cur_tag_open']          = '<li class="page-item"><a href="#" class="page-link text-dark"><b>';
                $config['cur_tag_close']         = '</b></a></li>';
                
                $config['first_link']            = '&laquo;';
                $config['prev_link']             = '&lsaquo;';
                $config['next_link']             = '&rsaquo;';
                $config['last_link']             = '&raquo;';
                $config['anchor_class']          = 'class="page-link"';
            
                $sql_supp = $this->db->where('id', general::dekrip($supplier))->get('tbl_m_supplier')->row();
                                
                switch ($case){
                    case 'per_tanggal':
                        if(!empty($hal)){
                            $data['sql_pembelian']     = $this->db->select('tbl_trans_beli.id, tbl_trans_beli.tgl_masuk, tbl_trans_beli.no_nota, tbl_trans_beli.jml_dpp, tbl_trans_beli.ppn, tbl_trans_beli.jml_ppn, tbl_trans_beli.jml_diskon, tbl_trans_beli.jml_gtotal, tbl_m_supplier.nama')
                                                              ->join('tbl_m_supplier', 'tbl_m_supplier.id=tbl_trans_beli.id_supplier')
                                                              ->where('DATE(tbl_trans_beli.tgl_masuk)', $tgl)
                                                              ->like('tbl_m_supplier.nama', $sql_supp->nama)
                                                              ->limit($config['per_page'], $hal)
                                                              ->get('tbl_trans_beli')->result();                           
                        }else{
                            $data['sql_pembelian']     = $this->db->select('tbl_trans_beli.id, tbl_trans_beli.tgl_masuk, tbl_trans_beli.no_nota, tbl_trans_beli.jml_dpp, tbl_trans_beli.ppn, tbl_trans_beli.jml_ppn, tbl_trans_beli.jml_diskon, tbl_trans_beli.jml_gtotal, tbl_m_supplier.nama')
                                                              ->join('tbl_m_supplier', 'tbl_m_supplier.id=tbl_trans_beli.id_supplier')
                                                              ->where('DATE(tbl_trans_beli.tgl_masuk)', $tgl)
                                                              ->like('tbl_m_supplier.nama', $sql_supp->nama)
                                                              ->limit($config['per_page'])
                                                              ->get('tbl_trans_beli')->result();
                        }
                        break;
                    
                    case 'per_rentang':
                        if(!empty($hal)){
                            $data['sql_pembelian']     = $this->db->select('tbl_trans_beli.id, tbl_trans_beli.tgl_masuk, tbl_trans_beli.no_nota, tbl_trans_beli.jml_dpp, tbl_trans_beli.ppn, tbl_trans_beli.jml_ppn, tbl_trans_beli.jml_diskon, tbl_trans_beli.jml_gtotal, tbl_m_supplier.nama')
                                                              ->join('tbl_m_supplier', 'tbl_m_supplier.id=tbl_trans_beli.id_supplier')
                                                              ->where('DATE(tbl_trans_beli.tgl_masuk) >=', $tgl_awal)
                                                              ->where('DATE(tbl_trans_beli.tgl_masuk) <=', $tgl_akhir)
                                                              ->like('tbl_m_supplier.nama', $sql_supp->nama)
                                                              ->limit($config['per_page'], $hal)
                                                              ->get('tbl_trans_beli')->result();                             
                        }else{
                            $data['sql_pembelian']     = $this->db->select('tbl_trans_beli.id, tbl_trans_beli.tgl_masuk, tbl_trans_beli.no_nota, tbl_trans_beli.jml_dpp, tbl_trans_beli.ppn, tbl_trans_beli.jml_ppn, tbl_trans_beli.jml_diskon, tbl_trans_beli.jml_gtotal, tbl_m_supplier.nama')
                                                              ->join('tbl_m_supplier', 'tbl_m_supplier.id=tbl_trans_beli.id_supplier')
                                                              ->where('DATE(tbl_trans_beli.tgl_masuk) >=', $tgl_awal)
                                                              ->where('DATE(tbl_trans_beli.tgl_masuk) <=', $tgl_akhir)
                                                              ->like('tbl_m_supplier.nama', $sql_supp->nama)
                                                              ->limit($config['per_page'])
                                                              ->get('tbl_trans_beli')->result();  
                        }
                        break;
                }
                
                # Initializing Config Pagination
                $this->pagination->initialize($config);
                
                # Pagination Data
                $data['total_rows'] = $config['total_rows'];
                $data['PerPage']    = $config['per_page'];
                $data['pagination'] = $this->pagination->create_links();
            }
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/laporan/sidebar_lap';
            /* --- Sidebar Menu --- */
            
            /* Load view tampilan */
            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/laporan/data_pembelian', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_stok(){
        if (akses::aksesLogin() == TRUE) {
            $dokter     = $this->input->get('id_dokter');
            $jml        = $this->input->get('jml');
            $hal        = $this->input->get('halaman');
            $case       = $this->input->get('case');
            $stok       = $this->input->get('stok');
            $tipe       = $this->input->get('tipe');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();
            
            if($jml > 0){
                $data['hasError'] = $this->session->flashdata('form_error');
                
                # Config Pagination
                $config['base_url']              = base_url('laporan/data_stok.php?tipe='.$tipe.(!empty($stok) ? '&stok='.$stok : '').(!empty($jml) ? '&jml='.$jml : ''));
                $config['total_rows']            = $jml;
                
                $config['query_string_segment']  = 'halaman';
                $config['page_query_string']     = TRUE;
                $config['per_page']              = $pengaturan->jml_item;
                $config['num_links']             = 3;
                
                $config['first_tag_open']        = '<li class="page-item">';
                $config['first_tag_close']       = '</li>';
                
                $config['prev_tag_open']         = '<li class="page-item">';
                $config['prev_tag_close']        = '</li>';
                
                $config['num_tag_open']          = '<li class="page-item">';
                $config['num_tag_close']         = '</li>';
                
                $config['next_tag_open']         = '<li class="page-item">';
                $config['next_tag_close']        = '</li>';
                
                $config['last_tag_open']         = '<li class="page-item">';
                $config['last_tag_close']        = '</li>';
                
                $config['cur_tag_open']          = '<li class="page-item"><a href="#" class="page-link text-dark"><b>';
                $config['cur_tag_close']         = '</b></a></li>';
                
                $config['first_link']            = '&laquo;';
                $config['prev_link']             = '&lsaquo;';
                $config['next_link']             = '&rsaquo;';
                $config['last_link']             = '&raquo;';
                $config['anchor_class']          = 'class="page-link"';
                       

                switch ($tipe) {
                    case '0' :
                        $st = '<';
                
                        if (isset($jml)) {
                            $data['sql_stok'] = $this->db->select('*')
                                            ->where('status_subt', '0')
                                            ->where('status_hps', '0')
                                            ->limit($config['per_page'], $hal)
                                            ->get('tbl_m_produk')->result();
                        } else {
                            $data['sql_stok'] = $this->db->select('*')
                                            ->where('status_subt', '0')
                                            ->where('status_hps', '0')
                                            ->limit($config['per_page'])
                                            ->get('tbl_m_produk')->result();
                        }
                        break;
                        
                    case '1' :
                        $st = '<';
                
                        if (isset($jml)) {
                            $data['sql_stok'] = $this->db->select('*')
                                            ->where('status_subt', '1')
                                            ->where('status_hps', '0')
                                            ->limit($config['per_page'], $hal)
                                            ->get('tbl_m_produk')->result();
                        } else {
                            $data['sql_stok'] = $this->db->select('*')
                                            ->where('status_subt', '1')
                                            ->where('status_hps', '0')
                                            ->limit($config['per_page'])
                                            ->get('tbl_m_produk')->result();
                        }
                        break;

                    case '2' :
                        $st = '';
                
                        if (isset($jml)) {
                            $data['sql_stok'] = $this->db->select('*')
                            ->where('status_hps', '0')
                                            ->limit($config['per_page'], $hal)
                                            ->get('tbl_m_produk')->result();
                        } else {
                            $data['sql_stok'] = $this->db->select('*')
                            ->where('status_hps', '0')
                                            ->limit($config['per_page'])
                                            ->get('tbl_m_produk')->result();
                        }
                        break;
                }

                // Initializing Config Pagination
                $this->pagination->initialize($config);
                
                // Pagination Data
                $data['total_rows'] = $config['total_rows'];
                $data['PerPage']    = $config['per_page'];
                $data['pagination'] = $this->pagination->create_links();
            }
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/laporan/sidebar_lap';
            /* --- Sidebar Menu --- */
            
            /* Load view tampilan */
            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/laporan/data_stok', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_stok_masuk(){
        if (akses::aksesLogin() == TRUE) {
            $dokter     = $this->input->get('id_dokter');
            $jml        = $this->input->get('jml');
            $tgl        = $this->input->get('tgl');
            $tgl_awal   = $this->input->get('tgl_awal');
            $tgl_akhir  = $this->input->get('tgl_akhir');
            $case       = $this->input->get('case');
            $hal        = $this->input->get('halaman');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();
            
            $data['sql_doc'] = $this->db->where('id_user_group', '10')->get('tbl_m_karyawan')->result();
            
            if($jml > 0){
                $data['hasError'] = $this->session->flashdata('form_error');
                
                // Config Pagination
                $config['base_url']              = base_url('laporan/data_stok_masuk.php?case='.$case.(!empty($tgl) ? '&tgl='.$tgl : '').(!empty($tgl_awal) ? '&tgl_awal='.$tgl_awal : '').(!empty($tgl_akhir) ? '&tgl_akhir='.$tgl_akhir : '').(!empty($jml) ? '&jml='.$jml : ''));
                $config['total_rows']            = $jml;
                
                $config['query_string_segment']  = 'halaman';
                $config['page_query_string']     = TRUE;
                $config['per_page']              = $pengaturan->jml_item;
                $config['num_links']             = 3;
                
                $config['first_tag_open']        = '<li class="page-item">';
                $config['first_tag_close']       = '</li>';
                
                $config['prev_tag_open']         = '<li class="page-item">';
                $config['prev_tag_close']        = '</li>';
                
                $config['num_tag_open']          = '<li class="page-item">';
                $config['num_tag_close']         = '</li>';
                
                $config['next_tag_open']         = '<li class="page-item">';
                $config['next_tag_close']        = '</li>';
                
                $config['last_tag_open']         = '<li class="page-item">';
                $config['last_tag_close']        = '</li>';
                
                $config['cur_tag_open']          = '<li class="page-item"><a href="#" class="page-link text-dark"><b>';
                $config['cur_tag_close']         = '</b></a></li>';
                
                $config['first_link']            = '&laquo;';
                $config['prev_link']             = '&lsaquo;';
                $config['next_link']             = '&rsaquo;';
                $config['last_link']             = '&raquo;';
                $config['anchor_class']          = 'class="page-link"';
            
                $sql_doc = $this->db->where('id', general::dekrip($dokter))->get('tbl_m_karyawan')->row();
                
                switch ($case){
                    case 'per_tanggal':
                        if(!empty($jml)){
                            $data['sql_penj']     = $this->db->select('tbl_trans_beli.id, tbl_trans_beli.tgl_simpan, tbl_trans_beli.no_rm, tbl_trans_beli.no_nota, tbl_m_pasien.nama_pgl, tbl_m_pasien.tgl_lahir, tbl_trans_beli_det.id AS id_beli_det, tbl_trans_beli_det.kode, tbl_trans_beli_det.item, tbl_trans_beli_det.harga, tbl_trans_beli_det.jml, tbl_trans_beli_det.subtotal')
                                                              ->join('tbl_trans_beli', 'tbl_trans_beli.id=tbl_trans_beli_det.id_beli')
                                                              ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_beli.id_pasien')
                                                              ->where('tbl_trans_beli.status_bayar', '1')
                                                              ->where('DATE(tbl_trans_beli.tgl_masuk)', $tgl)
                                                              ->where('tbl_trans_beli_det.status', '4')
                                                              ->limit($config['per_page'], $hal)
                                                          ->get('tbl_trans_beli_det')->result(); 
                        }else{
                            $data['sql_penj']     = $this->db->select('tbl_trans_beli.id, tbl_trans_beli.tgl_simpan, tbl_trans_beli.no_rm, tbl_trans_beli.no_nota, tbl_m_pasien.nama_pgl, tbl_m_pasien.tgl_lahir, tbl_trans_beli_det.id AS id_beli_det, tbl_trans_beli_det.kode, tbl_trans_beli_det.item, tbl_trans_beli_det.harga, tbl_trans_beli_det.jml, tbl_trans_beli_det.subtotal')
                                                              ->join('tbl_trans_beli', 'tbl_trans_beli.id=tbl_trans_beli_det.id_beli')
                                                              ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_beli.id_pasien')
                                                              ->where('tbl_trans_beli.status_bayar', '1')
                                                              ->where('DATE(tbl_trans_beli.tgl_masuk)', $tgl)
                                                              ->where('tbl_trans_beli_det.status', '4')
                                                              ->limit($config['per_page'])
                                                          ->get('tbl_trans_beli_det')->result();                            
                        }
                        break;
                    
                    case 'per_rentang':
                        if(!empty($jml)){
                            $data['sql_penj']     = $this->db->select('tbl_trans_beli.id, tbl_trans_beli.tgl_simpan, tbl_trans_beli.no_nota, tbl_trans_beli.supplier, tbl_trans_beli_det.id AS id_beli_det, tbl_trans_beli_det.kode, tbl_trans_beli_det.produk AS item, tbl_trans_beli_det.harga, tbl_trans_beli_det.jml, tbl_trans_beli_det.satuan, tbl_trans_beli_det.subtotal')
                                                              ->join('tbl_trans_beli', 'tbl_trans_beli.id=tbl_trans_beli_det.id_pembelian')
                                                              ->where('DATE(tbl_trans_beli.tgl_masuk) >=', $tgl_awal)
                                                              ->where('DATE(tbl_trans_beli.tgl_masuk) <=', $tgl_akhir)
                                                              ->limit($config['per_page'], $hal)
                                                          ->get('tbl_trans_beli_det')->result(); 
                        }else{
                            $data['sql_penj']     = $this->db->select('tbl_trans_beli.id, tbl_trans_beli.tgl_simpan, tbl_trans_beli.no_nota, tbl_trans_beli.supplier, tbl_trans_beli_det.id AS id_beli_det, tbl_trans_beli_det.kode, tbl_trans_beli_det.produk AS item, tbl_trans_beli_det.harga, tbl_trans_beli_det.jml, tbl_trans_beli_det.satuan, tbl_trans_beli_det.subtotal')
                                                              ->join('tbl_trans_beli', 'tbl_trans_beli.id=tbl_trans_beli_det.id_pembelian')
                                                              ->where('DATE(tbl_trans_beli.tgl_masuk) >=', $tgl_awal)
                                                              ->where('DATE(tbl_trans_beli.tgl_masuk) <=', $tgl_akhir)
                                                              ->limit($config['per_page'])
                                                          ->get('tbl_trans_beli_det')->result();
                        }
                        break;
                }
                
                // Initializing Config Pagination
                $this->pagination->initialize($config);
                
                // Pagination Data
                $data['total_rows'] = $config['total_rows'];
                $data['PerPage']    = $config['per_page'];
                $data['pagination'] = $this->pagination->create_links();
            }
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/laporan/sidebar_lap';
            /* --- Sidebar Menu --- */
            
            /* Load view tampilan */
            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/laporan/data_stok_masuk', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_stok_telusur(){
        if (akses::aksesLogin() == TRUE) {
            $dokter     = $this->input->get('id_dokter');
            $id         = $this->input->get('id');
            $id_gdg     = $this->input->get('id_gudang');
            $jml        = $this->input->get('jml');
            $tgl        = $this->input->get('tgl');
            $tgl_awal   = $this->input->get('tgl_awal');
            $tgl_akhir  = $this->input->get('tgl_akhir');
            $case       = $this->input->get('act');
            $hal        = $this->input->get('halaman');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();
            
            $data['sql_item']       = $this->db->where('status_subt', '1')->get('tbl_m_produk')->result();
            $data['sql_gudang']     = $this->db->get('tbl_m_gudang')->result();
            
            if(!empty($id)){
                $data['sql_gudang_rw']  = $this->db->where('id', $id_gdg)->get('tbl_m_gudang')->row();
                $data['sql_stok']       = $this->db->where('id', general::dekrip($id))->get('tbl_m_produk')->row();

                switch ($case){
                    case 'per_tanggal':
                        $data['gd_aktif']   = $this->db->where('id', $id_gdg)->get('tbl_m_gudang')->row();
                        $data['stok_so']    = $this->db->where('id_produk', $data['sql_stok']->id)->where('status', '6')->where('id_gudang', $id_gdg)->where('DATE(tgl_simpan) <=', $tgl)->order_by('id', 'DESC')->get('tbl_m_produk_hist')->row();
                        $data['stok_mts']   = $this->db->where('id_produk', $data['sql_stok']->id)->where('status', '8')->where('DATE(tgl_simpan) <=', $tgl)->limit(1)->order_by('id', 'DESC')->get('tbl_m_produk_hist')->row();
                        $data['stok_msk']   = $this->db->select_sum('jml')->where('id_produk', $data['sql_stok']->id)->where('status', '1')->where('DATE(tgl_simpan)', $tgl)->get('tbl_m_produk_hist')->row()->jml;
                        $data['stok_klr']   = $this->db->select_sum('jml')->where('id_produk', $data['sql_stok']->id)->where('status', '4')->where('DATE(tgl_simpan)', $tgl)->get('tbl_m_produk_hist')->row()->jml;

                        $data['tot_msk']    = ($data['gd_aktif']->status == '1' ? $data['stok_so']->jml + $data['stok_msk'] + $data['stok_mts']->jml : $data['stok_so']->jml + $data['stok_msk']);
                        $data['tot_klr']    = ($data['gd_aktif']->status == '1' ? $data['stok_klr'] : $data['stok_mts']->jml);

                        $data['sql_stok_hist'] = $this->db
                                                      ->where('id_produk', $data['sql_stok']->id)
                                                      ->where('DATE(tgl_simpan)', $tgl)
                                                      ->like('id_gudang', $id_gdg)
                                                      ->order_by('tgl_simpan', 'desc')
                                                      ->get('tbl_m_produk_hist')->result();
                        
                        $data['sql_stok_msk'] = $this->db
                                                       ->where('status', '1')
                                                       ->where('id_produk', $data['sql_stok']->id)
                                                       ->where('DATE(tgl_simpan)', $tgl)
                                                       ->like('id_gudang', $id_gdg)
                                                       ->order_by('tgl_simpan', 'desc')
                                                     ->get('tbl_m_produk_hist')->result();
                    break;
                
                    case 'per_rentang':
                        $data['gd_aktif']   = $this->db->where('id', $id_gdg)->get('tbl_m_gudang')->row();
                        $data['stok_mts']   = $this->db->where('id_produk', $data['sql_stok']->id)->where('status', '8')->where('DATE(tgl_simpan) <=', $tgl_akhir)->limit(1)->order_by('id', 'DESC')->get('tbl_m_produk_hist')->row();
                        $data['stok_so']    = $this->db->where('id_produk', $data['sql_stok']->id)->where('id_gudang', $id_gdg)->where('status', '6')->where('DATE(tgl_simpan) <=', $tgl_akhir)->limit(1)->order_by('id', 'DESC')->get('tbl_m_produk_hist')->row();
                        
                        $data['tot_msk']    = ($data['gd_aktif']->status == '1' ? $data['stok_so']->jml + $data['stok_msk'] + $data['stok_mts']->jml : $data['stok_so']->jml + $data['stok_msk']);
                            $data['tot_klr']    = ($data['gd_aktif']->status == '1' ? $data['stok_klr'] : $data['stok_mts']->jml);
                            
                        $data['sql_stok_hist'] = $this->db
                                                           ->where('id_produk', $data['sql_stok']->id)
                                                      ->where('DATE(tgl_simpan) >=', $tgl_awal)
                                                      ->where('DATE(tgl_simpan) <=', $tgl_akhir)
                                                           ->like('id_gudang', $id_gdg)
                                                           ->order_by('tgl_simpan', 'desc')
                                                      ->get('tbl_m_produk_hist')->result();

                        $data['sql_stok_msk'] = $this->db
                                                           ->where('status', '1')
                                                           ->where('id_produk', $data['sql_stok']->id)
                                                           ->where('DATE(tgl_simpan) >=', $tgl_awal)
                                                           ->where('DATE(tgl_simpan) <=', $tgl_akhir)
                                                           ->like('id_gudang', $id_gdg)
                                                     ->order_by('tgl_simpan', 'desc')
                                                     ->get('tbl_m_produk_hist')->result();
                    break;
                }
            }
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/laporan/sidebar_lap';
            /* --- Sidebar Menu --- */

            /* Load view tampilan */
            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/laporan/data_stok_telusur', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_stok_pers(){
        if (akses::aksesLogin() == TRUE) {
            $dokter     = $this->input->get('id_dokter');
            $id         = $this->input->get('id');
            $id_gdg     = $this->input->get('id_gudang');
            $jml        = $this->input->get('jml');
            $tgl        = $this->input->get('tgl');
            $tgl_awal   = $this->input->get('tgl_awal');
            $tgl_akhir  = $this->input->get('tgl_akhir');
            $case       = $this->input->get('act');
            $hal        = $this->input->get('halaman');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();
            
            $data['sql_item']       = $this->db->where('status_subt', '1')->get('tbl_m_produk')->result();
            $data['sql_gudang']     = $this->db->get('tbl_m_gudang')->result();
            
            if(!empty($id)){
                $data['sql_gudang_rw']  = $this->db->where('id', $id_gdg)->get('tbl_m_gudang')->row();
                $data['sql_stok']       = $this->db->where('id', general::dekrip($id))->get('tbl_m_produk')->row();

                switch ($case){
                    case 'per_tanggal':
                        $data['gd_aktif']   = $this->db->where('id', $id_gdg)->get('tbl_m_gudang')->row();
                        $data['stok_so']    = $this->db->where('id_produk', $data['sql_stok']->id)->where('status', '6')->where('DATE(tgl_simpan) <=', $tgl)->order_by('id', 'DESC')->get('v_produk_hist')->row();
                        $data['stok_bl']    = $this->db->where('id_produk', $data['sql_stok']->id)->where('status', '1')->where('DATE(tgl_simpan) <=', $tgl)->limit(1)->order_by('id', 'DESC')->get('v_produk_hist')->row();
                        $data['stok_mts']   = $this->db->where('id_produk', $data['sql_stok']->id)->where('status', '8')->where('DATE(tgl_simpan) <=', $tgl)->limit(1)->order_by('id', 'DESC')->get('v_produk_hist')->row();
                        $data['stok_msk']   = $this->db->select_sum('jml')->where('id_produk', $data['sql_stok']->id)->where('status', '1')->where('DATE(tgl_simpan)', $tgl)->get('v_produk_hist')->row()->jml;
                        $data['stok_klr']   = $this->db->select_sum('jml')->where('id_produk', $data['sql_stok']->id)->where('status', '4')->where('DATE(tgl_simpan)', $tgl)->get('v_produk_hist')->row()->jml;

                        $data['tot_msk']    = ($data['gd_aktif']->status == '1' ? $data['stok_so']->jml + $data['stok_msk'] + $data['stok_mts']->jml : $data['stok_so']->jml + $data['stok_msk']);
                        $data['tot_klr']    = ($data['gd_aktif']->status == '1' ? $data['stok_klr'] : $data['stok_mts']->jml);

                        $data['sql_stok_hist'] = $this->db
                                                        ->where('id_produk', $data['sql_stok']->id)
                                                        ->where('DATE(tgl_simpan)', $tgl)
                                                        ->like('id_gudang', $id_gdg)
                                                        ->group_by('tgl_simpan, id_penjualan, id_pembelian, id_pembelian_det, keterangan')
                                                        ->order_by('tgl_simpan', 'desc')
                                                      ->get('tbl_m_produk_hist')->result();
                        
                        $data['sql_stok_msk'] = $this->db
                                                       ->where('status', '1')
                                                       ->where('id_produk', $data['sql_stok']->id)
                                                       ->where('DATE(tgl_simpan)', $tgl)
                                                       ->like('id_gudang', $id_gdg)
                                                       ->group_by('tgl_simpan, id_penjualan, id_pembelian, id_pembelian_det, keterangan')
                                                       ->order_by('tgl_simpan', 'desc')
                                                     ->get('tbl_m_produk_hist')->result();
                    break;
                
                    case 'per_rentang':
                        $data['gd_aktif']   = $this->db->where('id', $id_gdg)->get('tbl_m_gudang')->row();
                        $data['stok_mts']   = $this->db->where('id_produk', $data['sql_stok']->id)->where('status', '8')->where('DATE(tgl_simpan) <=', $tgl_akhir)->limit(1)->order_by('id', 'DESC')->get('v_produk_hist')->row();
                        $data['stok_so']    = $this->db->where('id_produk', $data['sql_stok']->id)->where('status', '6')->where('DATE(tgl_simpan) <=', $tgl_awal)->limit(1)->order_by('id', 'DESC')->get('v_produk_hist')->row();
                        $data['stok_bl']    = $this->db->where('id_produk', $data['sql_stok']->id)->where('status', '1')->where('DATE(tgl_simpan) <=', $tgl_awal)->limit(1)->order_by('id', 'DESC')->get('v_produk_hist')->row();
                        
                            $data['tot_msk']    = ($data['gd_aktif']->status == '1' ? $data['stok_so']->jml + $data['stok_msk']->jml + $data['stok_mts']->jml : $data['stok_so']->jml + $data['stok_msk']->jml);
                            $data['tot_klr']    = ($data['gd_aktif']->status == '1' ? $data['stok_klr'] : $data['stok_mts']->jml);
                            
                        $data['sql_stok_hist'] = $this->db
                                                           ->where('id_produk', $data['sql_stok']->id)
                                                           ->where('DATE(tgl_masuk) >=', $tgl_awal)
                                                           ->where('DATE(tgl_masuk) <=', $tgl_akhir)
                                                           ->where('status !=', '2')
                                                           ->where('status !=', '8')
                                                           ->group_by('tgl_simpan, id_penjualan, id_pembelian, id_pembelian_det, keterangan')
                                                           ->order_by('tgl_simpan', 'asc')
                                                      ->get('tbl_m_produk_hist')->result();

                        $data['sql_stok_msk'] = $this->db
                                                           ->where('status', '1')
                                                           ->where('id_produk', $data['sql_stok']->id)
                                                           ->where('DATE(tgl_simpan) >=', $tgl_awal)
                                                           ->where('DATE(tgl_simpan) <=', $tgl_akhir)
                                                           ->like('id_gudang', $id_gdg)
                                                           ->group_by('tgl_simpan, id_penjualan, id_pembelian, id_pembelian_det, keterangan')
                                                     ->get('tbl_m_produk_hist')->result();
                    break;
                }
            }
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/laporan/sidebar_lap';
            /* --- Sidebar Menu --- */

            /* Load view tampilan */
            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/laporan/data_stok_pers', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function data_stok_keluar(){
        if (akses::aksesLogin() == TRUE) {
            $dokter     = $this->input->get('id_dokter');
            $jml        = $this->input->get('jml');
            $tgl        = $this->input->get('tgl');
            $tgl_awal   = $this->input->get('tgl_awal');
            $tgl_akhir  = $this->input->get('tgl_akhir');
            $case       = $this->input->get('case');
            $hal        = $this->input->get('halaman');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();
            
            $data['sql_doc'] = $this->db->where('id_user_group', '10')->get('tbl_m_karyawan')->result();
            
            if($jml > 0){
                $data['hasError'] = $this->session->flashdata('form_error');
                
                // Config Pagination
                $config['base_url']              = base_url('laporan/data_stok_keluar.php?case='.$case.(!empty($tgl) ? '&tgl='.$tgl : '').(!empty($tgl_awal) ? '&tgl_awal='.$tgl_awal : '').(!empty($tgl_akhir) ? '&tgl_akhir='.$tgl_akhir : '').(!empty($jml) ? '&jml='.$jml : ''));
                $config['total_rows']            = $jml;
                
                $config['query_string_segment']  = 'halaman';
                $config['page_query_string']     = TRUE;
                $config['per_page']              = $pengaturan->jml_item;
                $config['num_links']             = 3;
                
                $config['first_tag_open']        = '<li class="page-item">';
                $config['first_tag_close']       = '</li>';
                
                $config['prev_tag_open']         = '<li class="page-item">';
                $config['prev_tag_close']        = '</li>';
                
                $config['num_tag_open']          = '<li class="page-item">';
                $config['num_tag_close']         = '</li>';
                
                $config['next_tag_open']         = '<li class="page-item">';
                $config['next_tag_close']        = '</li>';
                
                $config['last_tag_open']         = '<li class="page-item">';
                $config['last_tag_close']        = '</li>';
                
                $config['cur_tag_open']          = '<li class="page-item"><a href="#" class="page-link text-dark"><b>';
                $config['cur_tag_close']         = '</b></a></li>';
                
                $config['first_link']            = '&laquo;';
                $config['prev_link']             = '&lsaquo;';
                $config['next_link']             = '&rsaquo;';
                $config['last_link']             = '&raquo;';
                $config['anchor_class']          = 'class="page-link"';
            
                $sql_doc = $this->db->where('id', general::dekrip($dokter))->get('tbl_m_karyawan')->row();
                
                switch ($case){
                    case 'per_tanggal':
                        if(!empty($jml)){
                            $data['sql_penj']     = $this->db->select('tbl_trans_medcheck.id, tbl_trans_medcheck.tgl_simpan, tbl_trans_medcheck.no_rm, tbl_trans_medcheck.no_nota, tbl_m_pasien.nama_pgl, tbl_m_pasien.tgl_lahir, tbl_trans_medcheck_det.id AS id_medcheck_det, tbl_trans_medcheck_det.kode, tbl_trans_medcheck_det.item, tbl_trans_medcheck_det.harga, tbl_trans_medcheck_det.jml, tbl_trans_medcheck_det.subtotal')
                                                              ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_det.id_medcheck')
                                                              ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
                                                              ->where('tbl_trans_medcheck.status_bayar', '1')
                                                              ->where('DATE(tbl_trans_medcheck.tgl_masuk)', $tgl)
                                                              ->where('tbl_trans_medcheck_det.status', '4')
                                                              ->limit($config['per_page'], $hal)
                                                          ->get('tbl_trans_medcheck_det')->result(); 
                        }else{
                            $data['sql_penj']     = $this->db->select('tbl_trans_medcheck.id, tbl_trans_medcheck.tgl_simpan, tbl_trans_medcheck.no_rm, tbl_trans_medcheck.no_nota, tbl_m_pasien.nama_pgl, tbl_m_pasien.tgl_lahir, tbl_trans_medcheck_det.id AS id_medcheck_det, tbl_trans_medcheck_det.kode, tbl_trans_medcheck_det.item, tbl_trans_medcheck_det.harga, tbl_trans_medcheck_det.jml, tbl_trans_medcheck_det.subtotal')
                                                              ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_det.id_medcheck')
                                                              ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
                                                              ->where('tbl_trans_medcheck.status_bayar', '1')
                                                              ->where('DATE(tbl_trans_medcheck.tgl_masuk)', $tgl)
                                                              ->where('tbl_trans_medcheck_det.status', '4')
                                                              ->limit($config['per_page'])
                                                          ->get('tbl_trans_medcheck_det')->result();                            
                        }
                        break;
                    
                    case 'per_rentang':
                        if(!empty($hal)){
                            $data['sql_penj']     = $this->db->select('tbl_trans_medcheck.id, tbl_trans_medcheck.tgl_simpan, tbl_trans_medcheck.no_rm, tbl_trans_medcheck.no_nota, tbl_m_pasien.nama_pgl, tbl_m_pasien.tgl_lahir, tbl_trans_medcheck_det.id AS id_medcheck_det, tbl_trans_medcheck_det.kode, tbl_trans_medcheck_det.item, tbl_trans_medcheck_det.harga, tbl_trans_medcheck_det.jml, tbl_trans_medcheck_det.subtotal')
                                                              ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_det.id_medcheck')
                                                              ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
                                                              ->where('tbl_trans_medcheck.status_bayar', '1')
                                                              ->where('DATE(tbl_trans_medcheck.tgl_masuk) >=', $tgl_awal)
                                                              ->where('DATE(tbl_trans_medcheck.tgl_masuk) <=', $tgl_akhir)
                                                              ->where('tbl_trans_medcheck_det.status', '4')
                                                              ->order_by('tbl_trans_medcheck_det.tgl_simpan', 'ASC')
                                                              ->limit($config['per_page'], $hal)
                                                          ->get('tbl_trans_medcheck_det')->result(); 
                        }else{
                            $data['sql_penj']     = $this->db->select('tbl_trans_medcheck.id, tbl_trans_medcheck.metode, tbl_trans_medcheck.no_rm, tbl_trans_medcheck.no_nota, tbl_trans_medcheck.tipe, tbl_m_pasien.nama_pgl, tbl_m_pasien.tgl_lahir, tbl_trans_medcheck_det.id AS id_medcheck_det, tbl_trans_medcheck_det.tgl_simpan, tbl_trans_medcheck_det.id_dokter, tbl_trans_medcheck_det.kode, tbl_trans_medcheck_det.item, tbl_trans_medcheck_det.harga, tbl_trans_medcheck_det.jml, tbl_trans_medcheck_det.subtotal, tbl_m_kategori.keterangan AS kategori')
                                                              ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_det.id_medcheck')
                                                              ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
                                                              ->join('tbl_m_kategori', 'tbl_m_kategori.id=tbl_trans_medcheck_det.id_item_kat')
                                                              ->where('tbl_trans_medcheck.status_bayar', '1')
                                                              ->where('DATE(tbl_trans_medcheck_det.tgl_simpan) >=', $tgl_awal)
                                                              ->where('DATE(tbl_trans_medcheck_det.tgl_simpan) <=', $tgl_akhir)
                                                              ->where('tbl_trans_medcheck_det.status', '4')
                                                              ->order_by('tbl_trans_medcheck_det.tgl_simpan', 'ASC')
                                                              ->limit($config['per_page'])
                                                          ->get('tbl_trans_medcheck_det')->result();
                        }
                        break;
                }
                
                // Initializing Config Pagination
                $this->pagination->initialize($config);
                
                // Pagination Data
                $data['total_rows'] = $config['total_rows'];
                $data['PerPage']    = $config['per_page'];
                $data['pagination'] = $this->pagination->create_links();
            }
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/laporan/sidebar_lap';
            /* --- Sidebar Menu --- */
            
            /* Load view tampilan */
            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/laporan/data_stok_keluar', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function data_stok_keluar_laku() {
        if (akses::aksesLogin() == TRUE) {
            $hal        = $this->input->get('halaman');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();
            
            /* -- Blok Filter -- */
            $dokter     = $this->input->get('id_dokter');
            $tgl        = $this->input->get('tgl');
            $tgl_awal   = $this->input->get('tgl_awal');
            $tgl_akhir  = $this->input->get('tgl_akhir');
            $case       = $this->input->get('case');
            
            $data['sql_doc'] = $this->db->where('id_user_group', '10')->get('tbl_m_karyawan')->result();
            
            // Count total records based on case
            if ($case == 'per_tanggal') {
                $jml = $this->db->select('COUNT(*) as count')
                               ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_det.id_medcheck')
                               ->where('tbl_trans_medcheck.status_bayar', '1')
                               ->where('DATE(tbl_trans_medcheck.tgl_masuk)', $tgl)
                               ->where('tbl_trans_medcheck_det.status', '4')
                               ->group_by('tbl_trans_medcheck_det.id_item')
                               ->get('tbl_trans_medcheck_det')
                               ->num_rows();
            } else if ($case == 'per_rentang') {
                $jml = $this->db->select('COUNT(*) as count')
                               ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_det.id_medcheck')
                               ->where('tbl_trans_medcheck.status_bayar', '1')
                               ->where('DATE(tbl_trans_medcheck.tgl_masuk) >=', $tgl_awal)
                               ->where('DATE(tbl_trans_medcheck.tgl_masuk) <=', $tgl_akhir)
                               ->where('tbl_trans_medcheck_det.status', '4')
                               ->group_by('tbl_trans_medcheck_det.id_item')
                               ->get('tbl_trans_medcheck_det')
                               ->num_rows();
            }

            $data['hasError'] = $this->session->flashdata('form_error');
            
            $config['base_url']             = base_url('laporan/data_stok_keluar_laku.php?case='.$case.(!empty($tgl) ? '&tgl='.$tgl : '').(!empty($tgl_awal) ? '&tgl_awal='.$tgl_awal : '').(!empty($tgl_akhir) ? '&tgl_akhir='.$tgl_akhir : ''));
            $config['total_rows']           = $jml;
            $config['query_string_segment'] = 'halaman';
            $config['page_query_string']    = TRUE;
            $config['per_page']             = $pengaturan->jml_item;
            $config['num_links']            = 3;
            
            // AdminLTE 3 pagination styling
            $config['full_tag_open']        = '<ul class="pagination pagination-sm m-0 float-right">';
            $config['full_tag_close']       = '</ul>';
            $config['first_tag_open']       = '<li class="page-item">';
            $config['first_tag_close']      = '</li>';
            $config['prev_tag_open']        = '<li class="page-item">';
            $config['prev_tag_close']       = '</li>';
            $config['num_tag_open']         = '<li class="page-item">';
            $config['num_tag_close']        = '</li>';
            $config['next_tag_open']        = '<li class="page-item">';
            $config['next_tag_close']       = '</li>';
            $config['last_tag_open']        = '<li class="page-item">';
            $config['last_tag_close']       = '</li>';
            $config['cur_tag_open']         = '<li class="page-item active"><a href="#" class="page-link">';
            $config['cur_tag_close']        = '</a></li>';
            $config['first_link']           = '<i class="fas fa-angle-double-left"></i>';
            $config['prev_link']            = '<i class="fas fa-angle-left"></i>';
            $config['next_link']            = '<i class="fas fa-angle-right"></i>';
            $config['last_link']            = '<i class="fas fa-angle-double-right"></i>';
            $config['attributes']           = array('class' => 'page-link');
        
            $sql_doc = $this->db->where('id', $this->general->dekrip($dokter))->get('tbl_m_karyawan')->row();
            
            switch ($case) {
                case 'per_tanggal':
                    if(!empty($hal)) {
                        $data['sql_penj'] = $this->db->select('tbl_trans_medcheck.id, tbl_trans_medcheck.tgl_simpan, tbl_trans_medcheck.no_rm, tbl_trans_medcheck.no_nota, tbl_m_pasien.nama_pgl, tbl_m_pasien.tgl_lahir, tbl_trans_medcheck_det.id AS id_medcheck_det, tbl_trans_medcheck_det.id_item, tbl_trans_medcheck_det.kode, tbl_trans_medcheck_det.item, tbl_trans_medcheck_det.harga, SUM(tbl_trans_medcheck_det.jml) as jml, tbl_trans_medcheck_det.subtotal')
                                                    ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_det.id_medcheck')
                                                    ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
                                                    ->where('tbl_trans_medcheck.status_bayar', '1')
                                                    ->where('DATE(tbl_trans_medcheck.tgl_masuk)', $tgl)
                                                    ->where('tbl_trans_medcheck_det.status', '4')
                                                    ->group_by('tbl_trans_medcheck_det.id_item')
                                                    ->limit($config['per_page'], $hal)
                                                    ->get('tbl_trans_medcheck_det')->result(); 
                    } else {
                        $data['sql_penj'] = $this->db->select('tbl_trans_medcheck.id, tbl_trans_medcheck.tgl_simpan, tbl_trans_medcheck.no_rm, tbl_trans_medcheck.no_nota, tbl_m_pasien.nama_pgl, tbl_m_pasien.tgl_lahir, tbl_trans_medcheck_det.id AS id_medcheck_det, tbl_trans_medcheck_det.id_item, tbl_trans_medcheck_det.kode, tbl_trans_medcheck_det.item, tbl_trans_medcheck_det.harga, SUM(tbl_trans_medcheck_det.jml) as jml, tbl_trans_medcheck_det.subtotal')
                                                    ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_det.id_medcheck')
                                                    ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
                                                    ->where('tbl_trans_medcheck.status_bayar', '1')
                                                    ->where('DATE(tbl_trans_medcheck.tgl_masuk)', $tgl)
                                                    ->where('tbl_trans_medcheck_det.status', '4')
                                                    ->group_by('tbl_trans_medcheck_det.id_item')
                                                    ->limit($config['per_page'])
                                                    ->get('tbl_trans_medcheck_det')->result();                            
                    }
                    break;
                
                case 'per_rentang':
                    if(!empty($hal)) {
                        $data['sql_penj'] = $this->db->select('tbl_trans_medcheck.id, tbl_trans_medcheck.tgl_simpan, tbl_trans_medcheck.no_rm, tbl_trans_medcheck.no_nota, tbl_m_pasien.nama_pgl, tbl_m_pasien.tgl_lahir, tbl_trans_medcheck_det.id AS id_medcheck_det, tbl_trans_medcheck_det.id_item, tbl_trans_medcheck_det.kode, tbl_trans_medcheck_det.item, tbl_trans_medcheck_det.harga, SUM(tbl_trans_medcheck_det.jml) as jml, tbl_trans_medcheck_det.subtotal')
                                                    ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_det.id_medcheck')
                                                    ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
                                                    ->where('tbl_trans_medcheck.status_bayar', '1')
                                                    ->where('DATE(tbl_trans_medcheck.tgl_masuk) >=', $tgl_awal)
                                                    ->where('DATE(tbl_trans_medcheck.tgl_masuk) <=', $tgl_akhir)
                                                    ->where('tbl_trans_medcheck_det.status', '4')
                                                    ->group_by('tbl_trans_medcheck_det.id_item')
                                                    ->order_by('tbl_trans_medcheck_det.tgl_simpan', 'ASC')
                                                    ->limit($config['per_page'], $hal)
                                                    ->get('tbl_trans_medcheck_det')->result(); 
                    } else {
                        $data['sql_penj'] = $this->db->select('tbl_trans_medcheck.id, tbl_trans_medcheck.metode, tbl_trans_medcheck.no_rm, tbl_trans_medcheck.no_nota, tbl_trans_medcheck.tipe, tbl_m_pasien.nama_pgl, tbl_m_pasien.tgl_lahir, tbl_trans_medcheck_det.id AS id_medcheck_det, tbl_trans_medcheck_det.tgl_simpan, tbl_trans_medcheck_det.id_dokter, tbl_trans_medcheck_det.id_item, tbl_trans_medcheck_det.kode, tbl_trans_medcheck_det.item, tbl_trans_medcheck_det.harga, SUM(tbl_trans_medcheck_det.jml) as jml, tbl_trans_medcheck_det.subtotal, tbl_m_kategori.keterangan AS kategori')
                                                    ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_det.id_medcheck')
                                                    ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
                                                    ->join('tbl_m_kategori', 'tbl_m_kategori.id=tbl_trans_medcheck_det.id_item_kat')
                                                    ->where('tbl_trans_medcheck.status_bayar', '1')
                                                    ->where('DATE(tbl_trans_medcheck_det.tgl_simpan) >=', $tgl_awal)
                                                    ->where('DATE(tbl_trans_medcheck_det.tgl_simpan) <=', $tgl_akhir)
                                                    ->where('tbl_trans_medcheck_det.status', '4')
                                                    ->group_by('tbl_trans_medcheck_det.id_item')
                                                    ->order_by('tbl_trans_medcheck_det.tgl_simpan', 'ASC')
                                                    ->limit($config['per_page'])
                                                    ->get('tbl_trans_medcheck_det')->result();
                    }
                    break;
        }
            
        // Initializing Config Pagination
        $this->pagination->initialize($config);
        
        // Pagination Data
        $data['total_rows'] = $config['total_rows'];
        $data['PerPage']    = $config['per_page'];
        $data['pagination'] = $this->pagination->create_links();
        
        /* Sidebar Menu */
        $data['sidebar']    = 'admin-lte-3/includes/laporan/sidebar_lap';
        /* --- Sidebar Menu --- */
        
        /* Load view tampilan */
        $this->load->view('admin-lte-3/1_atas', $data);
        $this->load->view('admin-lte-3/2_header', $data);
        $this->load->view('admin-lte-3/3_navbar', $data);
        $this->load->view('admin-lte-3/includes/laporan/data_stok_keluar_laku', $data);
        $this->load->view('admin-lte-3/5_footer', $data);
        $this->load->view('admin-lte-3/6_bawah', $data);
    } else {
        $errors = $this->ion_auth->messages();
        $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
        redirect();
    }
}
        
    public function data_stok_mutasi(){
        if (akses::aksesLogin() == TRUE) {
            $dokter     = $this->input->get('id_dokter');
            $jml        = $this->input->get('jml');
            $tgl        = $this->input->get('tgl');
            $tgl_awal   = $this->input->get('tgl_awal');
            $tgl_akhir  = $this->input->get('tgl_akhir');
            $case       = $this->input->get('case');
            $hal        = $this->input->get('halaman');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();
            
            $data['sql_doc'] = $this->db->where('id_user_group', '10')->get('tbl_m_karyawan')->result();
            
            if($jml > 0){
                $data['hasError'] = $this->session->flashdata('form_error');
                
                // Config Pagination
                $config['base_url']              = base_url('laporan/data_stok_mutasi.php?case='.$case.(!empty($tgl) ? '&tgl='.$tgl : '').(!empty($tgl_awal) ? '&tgl_awal='.$tgl_awal : '').(!empty($tgl_akhir) ? '&tgl_akhir='.$tgl_akhir : '').(!empty($jml) ? '&jml='.$jml : ''));
                $config['total_rows']            = $jml;
                
                $config['query_string_segment']  = 'halaman';
                $config['page_query_string']     = TRUE;
                $config['per_page']              = $pengaturan->jml_item;
                $config['num_links']             = 3;
                
                $config['first_tag_open']        = '<li class="page-item">';
                $config['first_tag_close']       = '</li>';
                
                $config['prev_tag_open']         = '<li class="page-item">';
                $config['prev_tag_close']        = '</li>';
                
                $config['num_tag_open']          = '<li class="page-item">';
                $config['num_tag_close']         = '</li>';
                
                $config['next_tag_open']         = '<li class="page-item">';
                $config['next_tag_close']        = '</li>';
                
                $config['last_tag_open']         = '<li class="page-item">';
                $config['last_tag_close']        = '</li>';
                
                $config['cur_tag_open']          = '<li class="page-item"><a href="#" class="page-link text-dark"><b>';
                $config['cur_tag_close']         = '</b></a></li>';
                
                $config['first_link']            = '&laquo;';
                $config['prev_link']             = '&lsaquo;';
                $config['next_link']             = '&rsaquo;';
                $config['last_link']             = '&raquo;';
                $config['anchor_class']          = 'class="page-link"';
            
                $sql_doc = $this->db->where('id', general::dekrip($dokter))->get('tbl_m_karyawan')->row();
                
                switch ($case){
                    case 'per_tanggal':
                        if(!empty($jml)){
                            $data['sql_penj']     = $this->db->where('DATE(tgl_simpan)', $tgl)
                                                             ->limit($config['per_page'], $hal)
                                                             ->get('v_laporan_stok')->result(); 
                        }else{
                            $data['sql_penj']     = $this->db->where('DATE(tgl_simpan)', $tgl)
                                                             ->limit($config['per_page'])
                                                             ->get('v_laporan_stok')->result();                          
                        }
                        break;
                    
                    case 'per_rentang':
                        if(!empty($hal)){
                            $data['sql_penj']     = $this->db
//                                                             ->where('DATE(tgl_simpan) >=', $tgl_awal)
//                                                             ->where('DATE(tgl_simpan) <=', $tgl_akhir)
                                                             ->limit($config['per_page'], $hal)
                                                             ->get('v_produk_stok')->result(); 
                        }else{
                            $data['sql_penj']     = $this->db
//                                                             ->where('DATE(tgl_simpan) >=', $tgl_awal)
//                                                             ->where('DATE(tgl_simpan) <=', $tgl_akhir)
                                                             ->limit($config['per_page'])
                                                             ->get('v_produk_stok')->result(); 
                        }
                        break;
                }
                
                // Initializing Config Pagination
                $this->pagination->initialize($config);
                
                // Pagination Data
                $data['total_rows'] = $config['total_rows'];
                $data['PerPage']    = $config['per_page'];
                $data['pagination'] = $this->pagination->create_links();
            }
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/laporan/sidebar_lap';
            /* --- Sidebar Menu --- */
            
            /* Load view tampilan */
            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/laporan/data_stok_mutasi', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function data_stok_opname(){
        if (akses::aksesLogin() == TRUE) {
            $jml        = $this->input->get('jml');
            $tgl        = $this->input->get('tgl');
            $tgl_awal   = $this->input->get('tgl_awal');
            $tgl_akhir  = $this->input->get('tgl_akhir');
            $case       = $this->input->get('case');
            $hal        = $this->input->get('halaman');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();
            
            if($jml > 0){
                $data['hasError'] = $this->session->flashdata('form_error');
                
                // Config Pagination
                $config['base_url']              = base_url('laporan/data_stok_opname.php?case='.$case.(!empty($tgl) ? '&tgl='.$tgl : '').(!empty($tgl_awal) ? '&tgl_awal='.$tgl_awal : '').(!empty($tgl_akhir) ? '&tgl_akhir='.$tgl_akhir : '').(!empty($jml) ? '&jml='.$jml : ''));
                $config['total_rows']            = $jml;
                
                $config['query_string_segment']  = 'halaman';
                $config['page_query_string']     = TRUE;
                $config['per_page']              = $pengaturan->jml_item;
                $config['num_links']             = 3;
                
                $config['first_tag_open']        = '<li class="page-item">';
                $config['first_tag_close']       = '</li>';
                
                $config['prev_tag_open']         = '<li class="page-item">';
                $config['prev_tag_close']        = '</li>';
                
                $config['num_tag_open']          = '<li class="page-item">';
                $config['num_tag_close']         = '</li>';
                
                $config['next_tag_open']         = '<li class="page-item">';
                $config['next_tag_close']        = '</li>';
                
                $config['last_tag_open']         = '<li class="page-item">';
                $config['last_tag_close']        = '</li>';
                
                $config['cur_tag_open']          = '<li class="page-item"><a href="#" class="page-link text-dark"><b>';
                $config['cur_tag_close']         = '</b></a></li>';
                
                $config['first_link']            = '&laquo;';
                $config['prev_link']             = '&lsaquo;';
                $config['next_link']             = '&rsaquo;';
                $config['last_link']             = '&raquo;';
                $config['anchor_class']          = 'class="page-link"';
                
                $this->db->select('tbl_util_so.id, tbl_util_so.tgl_simpan, tbl_util_so.id_user, tbl_util_so.uuid, tbl_util_so.keterangan, tbl_util_so_det.id_produk, tbl_util_so_det.kode, tbl_util_so_det.produk, tbl_util_so_det.jml, tbl_util_so_det.jml_sys, tbl_util_so_det.jml_satuan, tbl_util_so_det.keterangan as keterangan_so, tbl_m_gudang.gudang');
                $this->db->from('tbl_util_so');
                $this->db->join('tbl_util_so_det', 'tbl_util_so_det.id_so = tbl_util_so.id');
                $this->db->join('tbl_m_gudang', 'tbl_m_gudang.id = tbl_util_so.id_gudang');
                
                switch ($case){
                    case 'per_tanggal':
                        if(!empty($hal)){
                            $this->db->where('DATE(tbl_util_so.tgl_simpan)', $tgl);
                            $this->db->limit($config['per_page'], $hal);
                            $data['sql_so'] = $this->db->get()->result();
                        }else{
                            $this->db->where('DATE(tbl_util_so.tgl_simpan)', $tgl);
                            $this->db->limit($config['per_page']);
                            $data['sql_so'] = $this->db->get()->result();                          
                        }
                        break;
                    
                    case 'per_rentang':
                        if(!empty($hal)){
                            $this->db->where('DATE(tbl_util_so.tgl_simpan) >=', $tgl_awal);
                            $this->db->where('DATE(tbl_util_so.tgl_simpan) <=', $tgl_akhir);
                            $this->db->limit($config['per_page'], $hal);
                            $data['sql_so'] = $this->db->get()->result();
                        }else{
                            $this->db->where('DATE(tbl_util_so.tgl_simpan) >=', $tgl_awal);
                            $this->db->where('DATE(tbl_util_so.tgl_simpan) <=', $tgl_akhir);
                            $this->db->limit($config['per_page']);
                            $data['sql_so'] = $this->db->get()->result();
                        }
                        break;
                }
                
                // Initializing Config Pagination
                $this->pagination->initialize($config);
                
                // Pagination Data
                $data['total_rows'] = $config['total_rows'];
                $data['PerPage']    = $config['per_page'];
                $data['pagination'] = $this->pagination->create_links();
            }
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/laporan/sidebar_lap';
            /* --- Sidebar Menu --- */
            
            /* Load view tampilan */
            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/laporan/data_stok_opname', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_data_stok_opname(){
        if (akses::aksesLogin() == TRUE) {
            $tgl        = $this->input->post('tgl');
            $tgl_rtg    = $this->input->post('tgl_rentang');
            $case       = $this->input->post('case');

            // Determine case based on input
            if (!empty($tgl)) {
                $case = 'per_tanggal';
                $tgl = $this->tanggalan->tgl_indo_sys($tgl);
            } else {
                $case = 'per_rentang';
                // Parse date range
                $tg = explode(' - ', $tgl_rtg);
                $tgl_awal = $this->tanggalan->tgl_indo_sys($tg[0]);
                $tgl_akhir = $this->tanggalan->tgl_indo_sys($tg[1]);
            }
            
            switch ($case){
                case 'per_tanggal':
                    $jml = $this->db->where('DATE(tgl_simpan)', $tgl)->get('tbl_util_so')->num_rows();
                    redirect('laporan/data_stok_opname.php?case='.$case.'&tgl='.$tgl.'&jml='.$jml);
                    break;
                
                case 'per_rentang':
                    $jml = $this->db->where('DATE(tgl_simpan) >=', $tgl_awal)
                                    ->where('DATE(tgl_simpan) <=', $tgl_akhir)
                                    ->get('tbl_util_so')->num_rows();
                    redirect('laporan/data_stok_opname.php?case='.$case.'&tgl_awal='.$tgl_awal.'&tgl_akhir='.$tgl_akhir.'&jml='.$jml);
                    break;
            }
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_stok_keluar_resep(){
        if (akses::aksesLogin() == TRUE) {
            $poli               = $this->input->get('poli');
            $plat               = $this->input->get('plat');
            $jml                = $this->input->get('jml');
            $tgl                = $this->input->get('tgl');
            $tgl_awal           = $this->input->get('tgl_awal');
            $tgl_akhir          = $this->input->get('tgl_akhir');
            $case               = $this->input->get('case');
            $hal                = $this->input->get('halaman');
            $dokter             = $this->input->get('dokter');
            $pengaturan         = $this->db->get('tbl_pengaturan')->row();
            
            if(!empty($jml)){
                $jml_hal = $jml;
            }else{
//                $jml_hal = $this->db->select('tbl_trans_medcheck.id, tbl_trans_medcheck.tipe_bayar, tbl_trans_medcheck.tgl_simpan, tbl_trans_medcheck.no_rm, tbl_trans_medcheck.no_nota, tbl_trans_medcheck.tipe, tbl_m_pasien.nama_pgl, tbl_m_pasien.tgl_lahir, tbl_m_pasien.alamat, tbl_m_pasien.alamat_dom, tbl_m_pasien.instansi, tbl_m_pasien.instansi_alamat, tbl_trans_medcheck_resep_det.kode, tbl_trans_medcheck_resep_det.item, tbl_trans_medcheck_resep_det.dosis, tbl_trans_medcheck_resep_det.dosis_ket, tbl_trans_medcheck_resep_det.keterangan, tbl_trans_medcheck_resep_det.harga, tbl_trans_medcheck_resep_det.jml')
//                                ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_resep_det.id_medcheck')
//                                ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
//                                ->join('tbl_m_kategori', 'tbl_m_kategori.id=tbl_trans_medcheck_resep_det.id_item_kat')
//                                ->where('tbl_trans_medcheck.status_bayar', '1')
//                                ->where('tbl_trans_medcheck_resep_det.id_user', $dokter)
//                                ->where('DATE(tbl_trans_medcheck_resep_det.tgl_simpan) >=', $tgl_awal)
//                                ->where('DATE(tbl_trans_medcheck_resep_det.tgl_simpan) <=', $tgl_akhir)
//                                ->order_by('tbl_trans_medcheck_resep_det.tgl_simpan', 'ASC')
//                                ->get('tbl_trans_medcheck_resep_det')->num_rows();
            }
            
            $data['sql_doc']    = $this->db->where('id_user_group', '10')->get('tbl_m_karyawan')->result();
            $data['sql_poli']   = $this->db->get('tbl_m_poli')->result();
            $data['sql_plat']   = $this->db->get('tbl_m_platform')->result();
            
            $data['hasError'] = $this->session->flashdata('form_error');
            
            // Config Pagination
            $config['base_url']              = base_url('laporan/data_stok_keluar_resep.php?case='.$case.(!empty($dokter) ? '&dokter='.$dokter : '').(!empty($tgl) ? '&tgl='.$tgl : '').(!empty($tgl_awal) ? '&tgl_awal='.$tgl_awal : '').(!empty($tgl_akhir) ? '&tgl_akhir='.$tgl_akhir : '').(!empty($jml_hal) ? '&jml='.$jml_hal : ''));
            $config['total_rows']            = $jml_hal;
            
            $config['query_string_segment']  = 'halaman';
            $config['page_query_string']     = TRUE;
            $config['per_page']              = $pengaturan->jml_item;
            $config['num_links']             = 3;
            
            $config['first_tag_open']        = '<li class="page-item">';
            $config['first_tag_close']       = '</li>';
            
            $config['prev_tag_open']         = '<li class="page-item">';
            $config['prev_tag_close']        = '</li>';
            
            $config['num_tag_open']          = '<li class="page-item">';
            $config['num_tag_close']         = '</li>';
            
            $config['next_tag_open']         = '<li class="page-item">';
            $config['next_tag_close']        = '</li>';
            
            $config['last_tag_open']         = '<li class="page-item">';
            $config['last_tag_close']        = '</li>';
            
            $config['cur_tag_open']          = '<li class="page-item"><a href="#" class="page-link text-dark"><b>';
            $config['cur_tag_close']         = '</b></a></li>';
            
            $config['first_link']            = '&laquo;';
            $config['prev_link']             = '&lsaquo;';
            $config['next_link']             = '&rsaquo;';
            $config['last_link']             = '&raquo;';
            $config['anchor_class']          = 'class="page-link"';
        
            $sql_doc = $this->db->where('id', general::dekrip($dokter))->get('tbl_m_karyawan')->row();
            
            switch ($case){
                case 'per_tanggal':
                    if(!empty($hal)){
                        $data['sql_penj']     = $this->db->select('tbl_trans_medcheck.id, tbl_trans_medcheck.tipe_bayar, tbl_trans_medcheck.tgl_simpan, tbl_trans_medcheck.no_rm, tbl_trans_medcheck.no_nota, tbl_trans_medcheck.tipe, tbl_m_pasien.nama_pgl, tbl_m_pasien.tgl_lahir, tbl_m_pasien.alamat, tbl_m_pasien.alamat_dom, tbl_m_pasien.instansi, tbl_m_pasien.instansi_alamat, tbl_trans_medcheck_resep_det.kode, tbl_trans_medcheck_resep_det.item, tbl_trans_medcheck_resep_det.dosis, tbl_trans_medcheck_resep_det.dosis_ket, tbl_trans_medcheck_resep_det.keterangan, tbl_trans_medcheck_resep_det.harga, tbl_trans_medcheck_resep_det.jml, tbl_trans_medcheck_resep_det.satuan')
                                                        ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_resep_det.id_medcheck')
                                                        ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
                                                        ->join('tbl_m_kategori', 'tbl_m_kategori.id=tbl_trans_medcheck_resep_det.id_item_kat')
                                                        ->where('tbl_trans_medcheck.status_bayar', '1')
                                                        ->where('tbl_trans_medcheck_resep_det.id_user', general::dekrip($dokter))
                                                        ->where('DATE(tbl_trans_medcheck_resep_det.tgl_simpan)', $tgl)
                                                        ->order_by('tbl_trans_medcheck_resep_det.tgl_simpan', 'ASC')
                                                        ->limit($config['per_page'], $hal)
                                                        ->get('tbl_trans_medcheck_resep_det')->result(); 
                    }else{
                        $data['sql_penj']     = $this->db->select('tbl_trans_medcheck.id, tbl_trans_medcheck.tipe_bayar, tbl_trans_medcheck.tgl_simpan, tbl_trans_medcheck.no_rm, tbl_trans_medcheck.no_nota, tbl_trans_medcheck.tipe, tbl_m_pasien.nama_pgl, tbl_m_pasien.tgl_lahir, tbl_m_pasien.alamat, tbl_m_pasien.alamat_dom, tbl_m_pasien.instansi, tbl_m_pasien.instansi_alamat, tbl_trans_medcheck_resep_det.kode, tbl_trans_medcheck_resep_det.item, tbl_trans_medcheck_resep_det.dosis, tbl_trans_medcheck_resep_det.dosis_ket, tbl_trans_medcheck_resep_det.keterangan, tbl_trans_medcheck_resep_det.harga, tbl_trans_medcheck_resep_det.jml, tbl_trans_medcheck_resep_det.satuan')
                                                        ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_resep_det.id_medcheck')
                                                        ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
                                                        ->join('tbl_m_kategori', 'tbl_m_kategori.id=tbl_trans_medcheck_resep_det.id_item_kat')
                                                        ->where('tbl_trans_medcheck.status_bayar', '1')
                                                        ->where('tbl_trans_medcheck_resep_det.id_user', general::dekrip($dokter))
                                                        ->where('DATE(tbl_trans_medcheck_resep_det.tgl_simpan)', $tgl)
                                                        ->order_by('tbl_trans_medcheck_resep_det.tgl_simpan', 'ASC')
                                                        ->limit($config['per_page'])
                                                        ->get('tbl_trans_medcheck_resep_det')->result();                          
                    }
                    break;
                
                case 'per_rentang':
                    if(!empty($hal)){
                        $data['sql_penj']     = $this->db->select('tbl_trans_medcheck.id, tbl_trans_medcheck.tipe_bayar, tbl_trans_medcheck.tgl_simpan, tbl_trans_medcheck.no_rm, tbl_trans_medcheck.no_nota, tbl_trans_medcheck.tipe, tbl_m_pasien.nama_pgl, tbl_m_pasien.tgl_lahir, tbl_m_pasien.alamat, tbl_m_pasien.alamat_dom, tbl_m_pasien.instansi, tbl_m_pasien.instansi_alamat, tbl_trans_medcheck_resep_det.kode, tbl_trans_medcheck_resep_det.item, tbl_trans_medcheck_resep_det.dosis, tbl_trans_medcheck_resep_det.dosis_ket, tbl_trans_medcheck_resep_det.keterangan, tbl_trans_medcheck_resep_det.harga, tbl_trans_medcheck_resep_det.jml')
                                                        ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_resep_det.id_medcheck')
                                                        ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
                                                        ->join('tbl_m_kategori', 'tbl_m_kategori.id=tbl_trans_medcheck_resep_det.id_item_kat')
                                                        ->where('tbl_trans_medcheck.status_bayar', '1')
                                                        ->where('tbl_trans_medcheck_resep_det.id_user', general::dekrip($dokter))
                                                        ->where('DATE(tbl_trans_medcheck_resep_det.tgl_simpan) >=', $tgl_awal)
                                                        ->where('DATE(tbl_trans_medcheck_resep_det.tgl_simpan) <=', $tgl_akhir)
                                                        ->order_by('tbl_trans_medcheck_resep_det.tgl_simpan', 'ASC')
                                                        ->limit($config['per_page'], $hal)
                                                        ->get('tbl_trans_medcheck_resep_det')->result();
                    }else{
                        $data['sql_penj']     = $this->db->select('tbl_trans_medcheck.id, tbl_trans_medcheck.tipe_bayar, tbl_trans_medcheck.tgl_simpan, tbl_trans_medcheck.no_rm, tbl_trans_medcheck.no_nota, tbl_trans_medcheck.tipe, tbl_m_pasien.nama_pgl, tbl_m_pasien.tgl_lahir, tbl_m_pasien.alamat, tbl_m_pasien.alamat_dom, tbl_m_pasien.instansi, tbl_m_pasien.instansi_alamat, tbl_trans_medcheck_resep_det.kode, tbl_trans_medcheck_resep_det.item, tbl_trans_medcheck_resep_det.dosis, tbl_trans_medcheck_resep_det.dosis_ket, tbl_trans_medcheck_resep_det.keterangan, tbl_trans_medcheck_resep_det.harga, tbl_trans_medcheck_resep_det.jml')
                                                        ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_resep_det.id_medcheck')
                                                        ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
                                                        ->join('tbl_m_kategori', 'tbl_m_kategori.id=tbl_trans_medcheck_resep_det.id_item_kat')
                                                        ->where('tbl_trans_medcheck.status_bayar', '1')
                                                        ->where('tbl_trans_medcheck_resep_det.id_user', general::dekrip($dokter))
                                                        ->where('DATE(tbl_trans_medcheck_resep_det.tgl_simpan) >=', $tgl_awal)
                                                        ->where('DATE(tbl_trans_medcheck_resep_det.tgl_simpan) <=', $tgl_akhir)
                                                        ->order_by('tbl_trans_medcheck_resep_det.tgl_simpan', 'ASC')
                                                        ->limit($config['per_page'])
                                                        ->get('tbl_trans_medcheck_resep_det')->result();
                    }
                    break;
            }
            
            
            // Initializing Config Pagination
            $this->pagination->initialize($config);
//
            // Pagination Data
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/laporan/sidebar_lap';
            /* --- Sidebar Menu --- */
            
            /* Load view tampilan */
            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/laporan/data_stok_keluar_resep', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function data_referensi(){
        if (akses::aksesLogin() == TRUE) {
            $pengaturan = $this->db->get('tbl_pengaturan')->row();
            $data['pengaturan'] = $pengaturan;
            
            $data['hasError'] = $this->session->flashdata('form_error');
            
            $tipe = $this->input->get('tipe');
            
            switch ($tipe) {
                case '0':
                    $data['sql_referensi'] = $this->db
                                            ->select('tbl_m_produk.id, tbl_m_produk.kode, tbl_m_produk.produk as nama_produk, tbl_m_produk.harga_beli, tbl_m_produk.harga_jual, tbl_m_produk.id_kategori, tbl_m_produk.id_satuan, 
                                            (SELECT COUNT(id) FROM tbl_m_produk_ref WHERE tbl_m_produk_ref.id_produk = tbl_m_produk.id AND tbl_m_produk_ref.id_produk > 0) as stok')
                                            ->where('tbl_m_produk.status_subt', '0')
                                            ->where('tbl_m_produk.status_hps', '0')
                                            ->where('(SELECT COUNT(id) FROM tbl_m_produk_ref WHERE tbl_m_produk_ref.id_produk = tbl_m_produk.id AND tbl_m_produk_ref.id_produk > 0) >', 0)
                                            ->group_by('tbl_m_produk.id')
                                            ->order_by('tbl_m_produk.produk', 'ASC')
                                            ->get('tbl_m_produk')->result();
                    break;
                
                case '1':
                    $data['sql_referensi'] = $this->db
                                                    ->select('tbl_m_produk.id, tbl_m_produk.kode, tbl_m_produk.produk as nama_produk, tbl_m_produk.harga_beli, tbl_m_produk.harga_jual, tbl_m_produk.id_kategori, tbl_m_produk.id_satuan, 
                                                    (SELECT COUNT(id) FROM tbl_m_produk_ref WHERE tbl_m_produk_ref.id_produk = tbl_m_produk.id AND tbl_m_produk_ref.id_produk > 0) as stok')
                                                    ->where('tbl_m_produk.status_subt', '1')
                                                    ->where('tbl_m_produk.status_hps', '0')
                                                    ->where('(SELECT COUNT(id) FROM tbl_m_produk_ref WHERE tbl_m_produk_ref.id_produk = tbl_m_produk.id AND tbl_m_produk_ref.id_produk > 0) >', 0)
                                                    ->group_by('tbl_m_produk.id')
                                                    ->order_by('tbl_m_produk.produk', 'ASC')
                                                    ->get('tbl_m_produk')->result();
                    break;
                
                case '2':
                    $data['sql_referensi'] = $this->db
                                                  ->select('tbl_m_produk.id, tbl_m_produk.kode, tbl_m_produk.produk as nama_produk, tbl_m_produk.harga_beli, tbl_m_produk.harga_jual, tbl_m_produk.id_kategori, tbl_m_produk.id_satuan, 
                                                        (SELECT COUNT(id) FROM tbl_m_produk_ref WHERE tbl_m_produk_ref.id_produk = tbl_m_produk.id AND tbl_m_produk_ref.id_produk > 0) as stok')
                                                  ->where('tbl_m_produk.status_hps', '0')
                                                  ->where('(SELECT COUNT(id) FROM tbl_m_produk_ref WHERE tbl_m_produk_ref.id_produk = tbl_m_produk.id AND tbl_m_produk_ref.id_produk > 0) >', 0)
                                                  ->group_by('tbl_m_produk.id')
                                                  ->order_by('tbl_m_produk.produk', 'ASC')
                                                  ->get('tbl_m_produk')->result();
                    break;
            }
            
            /* Sidebar Menu */
            $data['sidebar'] = 'admin-lte-3/includes/laporan/sidebar_lap';
            /* --- Sidebar Menu --- */
            
            /* Load view tampilan */
            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/laporan/data_referensi', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_pasien(){
        if (akses::aksesLogin() == TRUE) {
            $tgl                = explode('-', $this->input->get('tgl'));
            $tgl                = $tgl[0];
            $bln                = $tgl[1];
            $bulan              = $this->input->get('bulan');
            $hal                = $this->input->get('halaman');
            $case               = $this->input->get('case');
            $pengaturan         = $this->db->get('tbl_pengaturan')->row();

            // Count based on case
            switch ($case) {
                case 'per_bulan':
                    $jml = $this->db->select("tbl_m_pasien.id")
                                    ->where('tbl_m_pasien.no_hp !=', '')
                                    ->where("MONTH(tbl_m_pasien.tgl_lahir)", $bulan)
                                    ->from("tbl_m_pasien")
                                    ->count_all_results();
                    break;

                    case 'per_tanggal':
                        // Format day and month with leading zeros if needed
                        $tgl = sprintf('%02d', $tgl);
                        $bln = sprintf('%02d', $bln);
                        
                        // Get the search date from the input (format: DD-MM)
                        $search_date = $this->input->get('tgl');
                        if (!empty($search_date) && strpos($search_date, '-') !== false) {
                            $date_parts = explode('-', $search_date);
                            if (count($date_parts) >= 2) {
                                $tgl = sprintf('%02d', $date_parts[0]);
                                $bln = sprintf('%02d', $date_parts[1]);
                            }
                        }
                        
                        $jml = $this->db->select("tbl_m_pasien.id")
                                        ->where('tbl_m_pasien.no_hp !=', '')
                                        ->where('DAY(tbl_m_pasien.tgl_lahir)', $tgl)
                                        ->where('MONTH(tbl_m_pasien.tgl_lahir)', $bln)
                                        ->from("tbl_m_pasien")
                                        ->count_all_results();
                        break;

                default:
                    $jml = 0;
                    break;
            }

            if (!empty($jml)) {
                $data['hasError'] = $this->session->flashdata('form_error');
                
                // Config Pagination
                $config['base_url']              = base_url('laporan/data_pasien.php?case='.$case.(!empty($tgl) ? '&tgl='.$this->input->get('tgl') : '').(!empty($bulan) ? '&bulan='.$bulan : ''));
                $config['total_rows']            = $jml;
                
                $config['query_string_segment']  = 'halaman';
                $config['page_query_string']     = TRUE;
                $config['per_page']              = $pengaturan->jml_item;
                $config['num_links']             = 3;
                
                $config['first_tag_open']        = '<li class="page-item">';
                $config['first_tag_close']       = '</li>';
                
                $config['prev_tag_open']         = '<li class="page-item">';
                $config['prev_tag_close']        = '</li>';
                
                $config['num_tag_open']          = '<li class="page-item">';
                $config['num_tag_close']         = '</li>';
                
                $config['next_tag_open']         = '<li class="page-item">';
                $config['next_tag_close']        = '</li>';
                
                $config['last_tag_open']         = '<li class="page-item">';
                $config['last_tag_close']        = '</li>';
                
                $config['cur_tag_open']          = '<li class="page-item"><a href="#" class="page-link text-dark"><b>';
                $config['cur_tag_close']         = '</b></a></li>';
                
                $config['first_link']            = '&laquo;';
                $config['prev_link']             = '&lsaquo;';
                $config['next_link']             = '&rsaquo;';
                $config['last_link']             = '&raquo;';
                $config['anchor_class']          = 'class="page-link"';
            
                // Initialize dokter variable to avoid undefined variable error
                $dokter = $this->input->get('dokter') ?? null;
                $sql_doc = $dokter ? $this->db->where('id', general::dekrip($dokter))->get('tbl_m_karyawan')->row() : null;
                
                switch ($case){
                    default:
                        if (!empty($hal)) {
                            $data['sql_pasien']     = $this->db->select('tbl_m_pasien.id, tbl_m_pasien.kode_dpn, tbl_m_pasien.kode, tbl_m_pasien.nama, tbl_m_pasien.no_hp, tbl_m_pasien.tgl_lahir, DAY(tbl_m_pasien.tgl_lahir) AS hari, MONTH(tbl_m_pasien.tgl_lahir) AS bulan')
                                                                ->limit($config['per_page'], $hal)
                                                                ->order_by('tbl_m_pasien.nama', 'ASC') 
                                                                ->get('tbl_m_pasien')->result();                            
                        }else{
                            $data['sql_pasien']     = $this->db->select('tbl_m_pasien.id, tbl_m_pasien.kode_dpn, tbl_m_pasien.kode, tbl_m_pasien.nama, tbl_m_pasien.no_hp, tbl_m_pasien.tgl_lahir, DAY(tbl_m_pasien.tgl_lahir) AS hari, MONTH(tbl_m_pasien.tgl_lahir) AS bulan')
                                                                ->limit($config['per_page'])
                                                                ->order_by('tbl_m_pasien.nama', 'ASC') 
                                                                ->get('tbl_m_pasien')->result();                            
                        }
                        break;
                    
                    case 'per_tanggal':
                        // Format day and month with leading zeros if needed
                        $tgl = sprintf('%02d', $tgl);
                        $bln = sprintf('%02d', $bln);
                        
                        // Get the search date from the input (format: DD-MM)
                        $search_date = $this->input->get('tgl');
                        if (!empty($search_date) && strpos($search_date, '-') !== false) {
                            $date_parts = explode('-', $search_date);
                            if (count($date_parts) >= 2) {
                                $tgl = sprintf('%02d', $date_parts[0]);
                                $bln = sprintf('%02d', $date_parts[1]);
                            }
                        }
                        
                        $data['sql_pasien'] = $this->db->select('tbl_m_pasien.id, tbl_m_pasien.kode_dpn, tbl_m_pasien.kode, tbl_m_pasien.nama, tbl_m_pasien.no_hp, tbl_m_pasien.tgl_lahir, DAY(tbl_m_pasien.tgl_lahir) AS hari, MONTH(tbl_m_pasien.tgl_lahir) AS bulan')
                                                        ->where('tbl_m_pasien.no_hp !=', '')
                                                        ->where('DAY(tbl_m_pasien.tgl_lahir)', $tgl)
                                                        ->where('MONTH(tbl_m_pasien.tgl_lahir)', $bln)
                                                        ->limit($config['per_page'], $hal)
                                                        ->order_by('tbl_m_pasien.nama', 'ASC') 
                                                        ->get('tbl_m_pasien')->result();
                        break;

                    case 'per_bulan':
                        $data['sql_pasien']     = $this->db->select('tbl_m_pasien.id, tbl_m_pasien.kode_dpn, tbl_m_pasien.kode, tbl_m_pasien.nama, tbl_m_pasien.no_hp, tbl_m_pasien.tgl_lahir, DAY(tbl_m_pasien.tgl_lahir) AS hari, MONTH(tbl_m_pasien.tgl_lahir) AS bulan')
                                                            ->where('tbl_m_pasien.no_hp !=', '')
                                                            ->where('MONTH(tbl_m_pasien.tgl_lahir)', $bulan)
                                                            ->limit($config['per_page'], $hal)
                                                            ->order_by('tbl_m_pasien.nama', 'ASC') 
                                                            ->get('tbl_m_pasien')->result();
                        break;
                }
                
                // Initializing Config Pagination
                $this->pagination->initialize($config);
                
                // Pagination Data
                $data['total_rows'] = $config['total_rows'];
                $data['PerPage']    = $config['per_page'];
                $data['pagination'] = $this->pagination->create_links();
            }
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/laporan/sidebar_lap';
            /* --- Sidebar Menu --- */
            
            /* Load view tampilan */
            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/laporan/data_pasien', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_pasien_st(){
        if (akses::aksesLogin() == TRUE) {
            $tgl        = $this->input->get('tgl');
            $tgl_awal   = $this->input->get('tgl_awal');
            $tgl_akhir  = $this->input->get('tgl_akhir');
            $case       = $this->input->get('case');
            $hal        = $this->input->get('halaman'); // Halaman yang sedang dibuka
            $statusPas  = $this->input->get('status_pas');
            $jml        = $this->input->get('jml'); // Jumlah total pasien

            $pengaturan = $this->db->get('tbl_pengaturan')->row();
            $data['sql_poli'] = $this->db->get('tbl_m_poli')->result();

            if ($jml > 0) {
                $data['hasError'] = $this->session->flashdata('form_error');

                // **Konfigurasi Pagination**
                $config['base_url']  = base_url('laporan/data_pasien_st.php?case=' . $case
                    . (!empty($tgl) ? '&tgl=' . $tgl : '')
                    . (!empty($tgl_awal) ? '&tgl_awal=' . $tgl_awal : '')
                    . (!empty($tgl_akhir) ? '&tgl_akhir=' . $tgl_akhir : '')
                    . (!empty($jml) ? '&jml=' . $jml : '')
                    . (!empty($statusPas) ? '&status_pas=' . $statusPas : '')
                );

                $config['total_rows']            = $jml; // Total data yang diambil
                $config['per_page']              = $pengaturan->jml_item; // Jumlah data per halaman
                $config['uri_segment']           = 3;
                $config['page_query_string']     = TRUE;
                $config['query_string_segment']  = 'halaman';

                // **Tampilan Pagination**
                $config['first_tag_open']        = '<li class="page-item">';
                $config['first_tag_close']       = '</li>';
                
                $config['prev_tag_open']         = '<li class="page-item">';
                $config['prev_tag_close']        = '</li>';
                
                $config['num_tag_open']          = '<li class="page-item">';
                $config['num_tag_close']         = '</li>';
                
                $config['next_tag_open']         = '<li class="page-item">';
                $config['next_tag_close']        = '</li>';
                
                $config['last_tag_open']         = '<li class="page-item">';
                $config['last_tag_close']        = '</li>';
                
                $config['cur_tag_open']          = '<li class="page-item"><a href="#" class="page-link text-dark"><b>';
                $config['cur_tag_close']         = '</b></a></li>';
                
                $config['first_link']            = '&laquo;';
                $config['prev_link']             = '&lsaquo;';
                $config['next_link']             = '&rsaquo;';
                $config['last_link']             = '&raquo;';
                $config['anchor_class']          = 'class="page-link"';

                // **Inisialisasi Pagination**
                $this->pagination->initialize($config);

                // **Query untuk mendapatkan data pasien sesuai case yang dipilih**
                switch ($case) {
                    case 'per_rentang':
                        $this->db->from("v_pasien");
                        $this->db->where("DATE(tgl_simpan) >=", $tgl_awal);
                        $this->db->where("DATE(tgl_simpan) <=", $tgl_akhir);

                        if ($statusPas == "1") {
                            $this->db->where("jumlah", '1'); // Pasien baru (jumlah = 1)
                        } elseif ($statusPas == "2") {
                            $this->db->where("jumlah >", '1'); // Pasien lama (jumlah > 1)
                        }

                        // Pagination: Ambil data sesuai halaman
                        if (!empty($hal)) {
                            $this->db->limit($config['per_page'], $hal);
                        } else {
                            $this->db->limit($config['per_page']);
                        }

                        $query = $this->db->get();
                        $data['sql_pasien'] = $query->result();
                        break;
                }

                // **Simpan data pagination**
                $data['total_rows'] = $config['total_rows'];
                $data['PerPage']    = $config['per_page'];
                $data['pagination'] = $this->pagination->create_links();
            }

            // **Sidebar Menu**
            $data['sidebar'] = 'admin-lte-3/includes/laporan/sidebar_lap';

            // **Load View**
            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/laporan/data_pasien_st', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function data_pasien_kunj(){
        if (akses::aksesLogin() == TRUE) {
            $jml                = $this->input->get('jml');
            $tgl                = $this->input->get('tgl');
            $tgl_awal           = $this->input->get('tgl_awal');
            $tgl_akhir          = $this->input->get('tgl_akhir');
            $poli               = $this->input->get('poli');
            $tipe               = $this->input->get('tipe');
            $hal                = $this->input->get('halaman');
            $case               = $this->input->get('case');
            $pengaturan         = $this->db->get('tbl_pengaturan')->row();
            
            $data['sql_poli']   = $this->db->get('tbl_m_poli')->result();
            $data['sql_plat']   = $this->db->get('tbl_m_platform')->result();
            
            switch ($case){                
                case 'per_tanggal':
                    $data['sql_pasien'] = $this->db->select('tm.id, tm.id AS id_medcheck, tm.id_pasien, tm.id_poli, tm.tgl_bayar AS tgl_simpan, mp.lokasi AS poli, tm.no_rm, tm.uuid AS kode, tm.pasien AS nama, mpas.tgl_lahir, COUNT(tm.id_pasien) AS jml_kunjungan, SUM(tm.jml_gtotal) AS jml_gtotal')
                                                   ->from('tbl_trans_medcheck tm')
                                                   ->join('tbl_m_poli mp', 'tm.id_poli = mp.id', 'left')
                                                   ->join('tbl_m_pasien mpas', 'tm.id_pasien = mpas.id', 'left')
                                                   ->where('DATE(tm.tgl_bayar)', $tgl)
                                                   ->like('tm.id_poli', $poli)
                                                   ->like('tm.tipe', $tipe)
                                                   ->group_by('tm.tipe, tm.id_pasien')
                                                   ->order_by('COUNT(tm.id_pasien)', 'desc')
                                                   ->get()->result();
                    break;

                case 'per_rentang':
                    $data['sql_pasien'] = $this->db->select('tm.id, tm.id AS id_medcheck, tm.id_pasien, tm.id_poli, tm.tgl_bayar AS tgl_simpan, mp.lokasi AS poli, tm.no_rm, tm.uuid AS kode, tm.pasien AS nama, mpas.tgl_lahir, COUNT(tm.id_pasien) AS jml_kunjungan, SUM(tm.jml_gtotal) AS jml_gtotal')
                                                   ->from('tbl_trans_medcheck tm')
                                                   ->join('tbl_m_poli mp', 'tm.id_poli = mp.id', 'left')
                                                   ->join('tbl_m_pasien mpas', 'tm.id_pasien = mpas.id', 'left')
                                                   ->where('DATE(tm.tgl_bayar) >=', $tgl_awal)
                                                   ->where('DATE(tm.tgl_bayar) <=', $tgl_akhir)
                                                   ->like('tm.id_poli', $poli, (!empty($poli) ? 'none' : ''))
                                                   ->like('tm.tipe', $tipe, (!empty($tipe) ? 'none' : ''))
                                                   ->group_by('tm.tipe, tm.id_pasien')
                                                   ->order_by('COUNT(tm.id_pasien)', 'desc')
                                                   ->get()->result();
                    break;
            }
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/laporan/sidebar_lap';
            /* --- Sidebar Menu --- */
            
            /* Load view tampilan */
            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/laporan/data_pasien_kunj', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_pasien_periksa(){
        if (akses::aksesLogin() == TRUE) {
            $jml                = $this->input->get('jml');
            $tgl                = $this->input->get('tgl');
            $tgl_awal           = $this->input->get('tgl_awal');
            $tgl_akhir          = $this->input->get('tgl_akhir');
            $poli               = $this->input->get('poli');
            $pasien             = $this->input->get('id_pasien');
            $hal                = $this->input->get('halaman');
            $case               = $this->input->get('case');
            $pengaturan         = $this->db->get('tbl_pengaturan')->row();
            
            $data['sql_poli']   = $this->db->get('tbl_m_poli')->result();
            $data['sql_plat']   = $this->db->get('tbl_m_platform')->result();
            
            switch ($case){                
                case 'per_tanggal':
                    $data['sql_pasien'] = $this->db->select('
                            trm.id AS id,
                            trm.id_medcheck,
                            trm.id_user,
                            trm.id_dokter,
                            trm.id_pasien,
                            trm.id_icd10,
                            trm.tgl_simpan,
                            tm.tgl_masuk,
                            tm.no_rm AS kode,
                            mp.nama_pgl AS nama,
                            mp.tgl_lahir,
                            trm.anamnesa,
                            trm.pemeriksaan,
                            tm.diagnosa,
                            trm.terapi,
                            trm.program,
                            trm.ttv_skala,
                            trm.ttv_saturasi,
                            trm.ttv_laju,
                            trm.ttv_nadi,
                            trm.ttv_diastole,
                            trm.ttv_sistole,
                            trm.ttv_tb,
                            trm.ttv_bb,
                            trm.ttv_st,
                            trm.tipe,
                            trm.status,
                            tm.status_bayar
                        ')
                        ->from('tbl_trans_medcheck_rm trm')
                        ->join('tbl_trans_medcheck tm', 'trm.id_medcheck = tm.id', 'join')
                        ->join('tbl_m_pasien mp', 'trm.id_pasien = mp.id', 'join')
                        ->where('tm.status_hps', '0')
                        ->where('DATE(trm.tgl_simpan)', $tgl)
                        ->like('trm.id_pasien', general::dekrip($pasien), (!empty($pasien) ? 'none' : ''))
                        ->group_by('trm.id_medcheck')
                        ->order_by('trm.id', 'DESC')
                        ->get()->result();
                    break;

                case 'per_rentang':
                    $data['sql_pasien'] = $this->db->select('
                            trm.id AS id,
                            trm.id_medcheck,
                            trm.id_user,
                            trm.id_dokter,
                            trm.id_pasien,
                            trm.id_icd10,
                            trm.tgl_simpan,
                            tm.tgl_masuk,
                            tm.no_rm AS kode,
                            mp.nama_pgl AS nama,
                            mp.tgl_lahir,
                            trm.anamnesa,
                            trm.pemeriksaan,
                            tm.diagnosa,
                            trm.terapi,
                            trm.program,
                            trm.ttv_skala,
                            trm.ttv_saturasi,
                            trm.ttv_laju,
                            trm.ttv_nadi,
                            trm.ttv_diastole,
                            trm.ttv_sistole,
                            trm.ttv_tb,
                            trm.ttv_bb,
                            trm.ttv_st,
                            trm.tipe,
                            trm.status,
                            tm.status_bayar
                        ')
                        ->from('tbl_trans_medcheck_rm trm')
                        ->join('tbl_trans_medcheck tm', 'trm.id_medcheck = tm.id', 'join')
                        ->join('tbl_m_pasien mp', 'trm.id_pasien = mp.id', 'join')
                        ->where('tm.status_hps', '0')
                        ->where('DATE(trm.tgl_simpan) >=', $tgl_awal)
                        ->where('DATE(trm.tgl_simpan) <=', $tgl_akhir)
                        ->like('trm.id_pasien', general::dekrip($pasien), (!empty($pasien) ? 'none' : ''))
                        ->group_by('trm.id_medcheck')
                        ->order_by('trm.id', 'DESC')
                        ->get()->result();
                    break;
            }
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/laporan/sidebar_lap';
            /* --- Sidebar Menu --- */
            
            /* Load view tampilan */
            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/laporan/data_pasien_periksa', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_pasien_periksa_det(){
        if (akses::aksesLogin() == TRUE) {
            $id                 = $this->input->get('id');
            $jml                = $this->input->get('jml');
            $tgl                = $this->input->get('tgl');
            $tgl_awal           = $this->input->get('tgl_awal');
            $tgl_akhir          = $this->input->get('tgl_akhir');
            $poli               = $this->input->get('poli');
            $tipe               = $this->input->get('tipe');
            $hal                = $this->input->get('halaman');
            $case               = $this->input->get('case');
            $pengaturan         = $this->db->get('tbl_pengaturan')->row();
                        
            switch ($case){                
                case 'per_tanggal':
                    $data['sql_pasien'] = $this->db
                        ->select('
                            tbl_trans_medcheck_rm.id AS id,
                            tbl_trans_medcheck_rm.id_medcheck,
                            tbl_trans_medcheck_rm.id_user,
                            tbl_trans_medcheck_rm.id_dokter,
                            tbl_trans_medcheck_rm.id_pasien,
                            tbl_trans_medcheck_rm.id_icd10,
                            tbl_trans_medcheck_rm.tgl_simpan,
                            tbl_trans_medcheck.tgl_masuk,
                            tbl_trans_medcheck.no_rm AS kode,
                            tbl_m_pasien.nama_pgl AS nama,
                            tbl_m_pasien.tgl_lahir,
                            tbl_trans_medcheck_rm.anamnesa,
                            tbl_trans_medcheck_rm.pemeriksaan,
                            tbl_trans_medcheck.diagnosa,
                            tbl_trans_medcheck_rm.terapi,
                            tbl_trans_medcheck_rm.program,
                            tbl_trans_medcheck_rm.ttv_skala,
                            tbl_trans_medcheck_rm.ttv_saturasi,
                            tbl_trans_medcheck_rm.ttv_laju,
                            tbl_trans_medcheck_rm.ttv_nadi,
                            tbl_trans_medcheck_rm.ttv_diastole,
                            tbl_trans_medcheck_rm.ttv_sistole,
                            tbl_trans_medcheck_rm.ttv_tb,
                            tbl_trans_medcheck_rm.ttv_bb,
                            tbl_trans_medcheck_rm.ttv_st,
                            tbl_trans_medcheck_rm.tipe,
                            tbl_trans_medcheck_rm.status,
                            tbl_trans_medcheck.status_bayar
                        ')
                        ->from('tbl_trans_medcheck_rm')
                        ->join('tbl_trans_medcheck', 'tbl_trans_medcheck_rm.id_medcheck = tbl_trans_medcheck.id', 'join')
                        ->join('tbl_m_pasien', 'tbl_trans_medcheck_rm.id_pasien = tbl_m_pasien.id', 'join')
                        ->where('tbl_trans_medcheck.status_hps', '0')
                        ->where('tbl_trans_medcheck_rm.id_medcheck', general::dekrip($id))
                        ->order_by('tbl_trans_medcheck_rm.id', 'DESC')
                        ->get()->result();
                    break;

                case 'per_rentang':
                    $data['sql_pasien'] = $this->db
                        ->select('
                            tbl_trans_medcheck_rm.id AS id,
                            tbl_trans_medcheck_rm.id_medcheck,
                            tbl_trans_medcheck_rm.id_user,
                            tbl_trans_medcheck_rm.id_dokter,
                            tbl_trans_medcheck_rm.id_pasien,
                            tbl_trans_medcheck_rm.id_icd10,
                            tbl_trans_medcheck_rm.tgl_simpan,
                            tbl_trans_medcheck.tgl_masuk,
                            tbl_trans_medcheck.no_rm AS kode,
                            tbl_m_pasien.nama_pgl AS nama,
                            tbl_m_pasien.tgl_lahir,
                            tbl_trans_medcheck_rm.anamnesa,
                            tbl_trans_medcheck_rm.pemeriksaan,
                            tbl_trans_medcheck.diagnosa,
                            tbl_trans_medcheck_rm.terapi,
                            tbl_trans_medcheck_rm.program,
                            tbl_trans_medcheck_rm.ttv_skala,
                            tbl_trans_medcheck_rm.ttv_saturasi,
                            tbl_trans_medcheck_rm.ttv_laju,
                            tbl_trans_medcheck_rm.ttv_nadi,
                            tbl_trans_medcheck_rm.ttv_diastole,
                            tbl_trans_medcheck_rm.ttv_sistole,
                            tbl_trans_medcheck_rm.ttv_tb,
                            tbl_trans_medcheck_rm.ttv_bb,
                            tbl_trans_medcheck_rm.ttv_st,
                            tbl_trans_medcheck_rm.tipe,
                            tbl_trans_medcheck_rm.status,
                            tbl_trans_medcheck.status_bayar
                        ')
                        ->from('tbl_trans_medcheck_rm')
                        ->join('tbl_trans_medcheck', 'tbl_trans_medcheck_rm.id_medcheck = tbl_trans_medcheck.id', 'join')
                        ->join('tbl_m_pasien', 'tbl_trans_medcheck_rm.id_pasien = tbl_m_pasien.id', 'join')
                        ->where('tbl_trans_medcheck.status_hps', '0')
                        ->where('tbl_trans_medcheck_rm.id_medcheck', general::dekrip($id))
                        ->order_by('tbl_trans_medcheck_rm.id', 'DESC')
                        ->get()->result();
                    break;
            }
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/laporan/sidebar_lap';
            /* --- Sidebar Menu --- */
            
            /* Load view tampilan */
            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/laporan/data_pasien_periksa_det', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_pasien_periksa_rj(){
        if (akses::aksesLogin() == TRUE) {
            $jml                = $this->input->get('jml');
            $tgl                = $this->input->get('tgl');
            $tgl_awal           = $this->input->get('tgl_awal');
            $tgl_akhir          = $this->input->get('tgl_akhir');
            $poli               = $this->input->get('poli');
            $pasien             = $this->input->get('id_pasien');
            $hal                = $this->input->get('halaman');
            $case               = $this->input->get('case');
            $pengaturan         = $this->db->get('tbl_pengaturan')->row();
            
            $data['sql_poli']   = $this->db->get('tbl_m_poli')->result();
            $data['sql_plat']   = $this->db->get('tbl_m_platform')->result();
            
            switch ($case){                
                case 'per_tanggal':
                    $data['sql_pasien'] = $this->db->select('tbl_trans_medcheck.id AS id, tbl_trans_medcheck.id_pasien AS id_pasien, tbl_trans_medcheck.tgl_simpan AS tgl_simpan, tbl_trans_medcheck.tgl_masuk AS tgl_masuk, concat(tbl_m_pasien.kode_dpn, "", tbl_m_pasien.kode) AS kode, tbl_trans_medcheck.pasien AS pasien, tbl_m_pasien.tgl_lahir AS tgl_lahir, tbl_m_poli.lokasi AS poli, tbl_trans_medcheck.diagnosa AS diagnosa, tbl_trans_medcheck_icd.kode AS kode_icd, tbl_trans_medcheck_icd.icd AS icd, tbl_trans_medcheck_icd.diagnosa_en AS diagnosa_en')
                                        ->from('tbl_trans_medcheck')
                                        ->join('tbl_trans_medcheck_icd', 'tbl_trans_medcheck.id = tbl_trans_medcheck_icd.id_medcheck')
                                        ->join('tbl_m_pasien', 'tbl_trans_medcheck.id_pasien = tbl_m_pasien.id')
                                        ->join('tbl_m_poli', 'tbl_trans_medcheck.id_poli = tbl_m_poli.id')
                                        ->where('tbl_trans_medcheck.tipe', '2')
                                        ->where('DATE(tbl_trans_medcheck.tgl_simpan)', $tgl)
                                        ->order_by('tbl_trans_medcheck.id', 'desc')
                                        ->get()->result();
                    break;

                case 'per_rentang':
                    $data['sql_pasien'] = $this->db->select('tbl_trans_medcheck.id AS id, tbl_trans_medcheck.id_pasien AS id_pasien, tbl_trans_medcheck.tgl_simpan AS tgl_simpan, tbl_trans_medcheck.tgl_masuk AS tgl_masuk, concat(tbl_m_pasien.kode_dpn, "", tbl_m_pasien.kode) AS kode, tbl_trans_medcheck.pasien AS pasien, tbl_m_pasien.tgl_lahir AS tgl_lahir, tbl_m_poli.lokasi AS poli, tbl_trans_medcheck.diagnosa AS diagnosa, tbl_trans_medcheck_icd.kode AS kode_icd, tbl_trans_medcheck_icd.icd AS icd, tbl_trans_medcheck_icd.diagnosa_en AS diagnosa_en')
                                        ->from('tbl_trans_medcheck')
                                        ->join('tbl_trans_medcheck_icd', 'tbl_trans_medcheck.id = tbl_trans_medcheck_icd.id_medcheck')
                                        ->join('tbl_m_pasien', 'tbl_trans_medcheck.id_pasien = tbl_m_pasien.id')
                                        ->join('tbl_m_poli', 'tbl_trans_medcheck.id_poli = tbl_m_poli.id')
                                        ->where('tbl_trans_medcheck.tipe', '2')
                                        ->where('DATE(tbl_trans_medcheck.tgl_simpan) >=', $tgl_awal)
                                        ->where('DATE(tbl_trans_medcheck.tgl_simpan) <=', $tgl_akhir)
                                        ->order_by('tbl_trans_medcheck.id', 'desc')
                                        ->get()->result();
                    break;
            }
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/laporan/sidebar_lap';
            /* --- Sidebar Menu --- */
            
            /* Load view tampilan */
            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/laporan/data_pasien_periksa_rj', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_karyawan_ultah(){
        if (akses::aksesLogin() == TRUE) {
            $jml                = $this->input->get('jml');
            $tgl                = $this->input->get('tgl');
            $bln                = $this->input->get('bln');
            $hr_awal            = $this->input->get('hr_awal');
            $bln_awal           = $this->input->get('bln_awal');
            $hr_akhir           = $this->input->get('hr_akhir');
            $bln_akhir          = $this->input->get('bln_akhir');
            $hal                = $this->input->get('halaman');
            $case               = $this->input->get('case');
            $pengaturan         = $this->db->get('tbl_pengaturan')->row();
            
            if($jml > 0){
                $data['hasError'] = $this->session->flashdata('form_error');
                
                switch ($case){                    
                    case 'per_tanggal':
                        $data['sql_karyawan']     = $this->db->select('tbl_m_karyawan.id, tbl_m_karyawan.nik, tbl_m_karyawan.kode, tbl_m_karyawan.nama, tbl_m_karyawan.no_hp, tbl_m_karyawan.tgl_lahir, DAY(tbl_m_karyawan.tgl_lahir) AS hari, MONTH(tbl_m_karyawan.tgl_lahir) AS bulan')
                                                            ->where('tbl_m_karyawan.no_hp !=', '')
                                                            ->where('DAY(tbl_m_karyawan.tgl_lahir)', $tgl)
                                                            ->where('MONTH(tbl_m_karyawan.tgl_lahir)', $bln)
                                                            ->order_by('tbl_m_karyawan.nama', 'ASC') 
                                                            ->get('tbl_m_karyawan')->result();
                        break;
                    
                    case 'per_rentang':
                        $data['sql_karyawan']     = $this->db->select('tbl_m_karyawan.id, tbl_m_karyawan.nik, tbl_m_karyawan.kode, tbl_m_karyawan.nama, tbl_m_karyawan.no_hp, tbl_m_karyawan.tgl_lahir, DAY(tbl_m_karyawan.tgl_lahir) AS hari, MONTH(tbl_m_karyawan.tgl_lahir) AS bulan')
                                                            ->where('tbl_m_karyawan.no_hp !=', '')
                                                            ->where('DAY(tbl_m_karyawan.tgl_lahir) >=', $hr_awal)
                                                            ->where('MONTH(tbl_m_karyawan.tgl_lahir) >=', $bln_awal)
                                                            ->where('DAY(tbl_m_karyawan.tgl_lahir) <=', $hr_akhir)
                                                            ->where('MONTH(tbl_m_karyawan.tgl_lahir) <=', $bln_akhir)
                                                            ->order_by('tbl_m_karyawan.nama', 'ASC') 
                                                            ->get('tbl_m_karyawan')->result();
                        break;
                }
            }
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/laporan/sidebar_lap';
            /* --- Sidebar Menu --- */
            
            /* Load view tampilan */
            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/laporan/data_karyawan_ultah', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_tracer(){
        if (akses::aksesLogin() == TRUE) {
            $dokter     = $this->input->get('id_dokter');
            $jml        = $this->input->get('jml');
            $tgl        = $this->input->get('tgl');
            $tgl_awal   = $this->input->get('tgl_awal');
            $tgl_akhir  = $this->input->get('tgl_akhir');
            $poli       = $this->input->get('poli');
            $tipe       = $this->input->get('tipe');
            $case       = $this->input->get('case');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();
            
            $data['hasError']   = $this->session->flashdata('form_error');
        
            $data['sql_poli']   = $this->db->get('tbl_m_poli')->result();
            $sql_doc            = $this->db->where('id', general::dekrip($dokter))->get('tbl_m_karyawan')->row();
            
            switch ($case) {
                case 'per_tanggal':
                    $data['sql_tracer'] = $this->db
                                               ->select('
                                                   tm.id AS id,
                                                   tm.id_poli AS id_poli,
                                                   tm.no_rm AS no_rm,
                                                   tm.pasien AS nama_pgl,
                                                   tm.tgl_simpan AS tgl_simpan,
                                                   CAST(tm.tgl_simpan AS DATE) AS tanggal,
                                                   p.tgl_simpan AS wkt_daftar,
                                                   tm.tgl_periksa AS wkt_periksa,
                                                   tml.tgl_simpan AS wkt_sampling_msk,
                                                   tml.tgl_keluar AS wkt_sampling_klr,
                                                   tmr.tgl_simpan AS wkt_rad_msk,
                                                   tm.tgl_periksa_rad_keluar AS wkt_rad_klr,
                                                   tm.tgl_periksa_rad_kirim AS wkt_rad_krm,
                                                   tm.tgl_periksa_rad_baca AS wkt_rad_baca,
                                                   tmrp.tgl_simpan AS wkt_resep_msk,
                                                   tmrp.tgl_keluar AS wkt_resep_klr,
                                                   tm.tgl_bayar AS wkt_resep_byr,
                                                   tm.tgl_ttd AS wkt_resep_trm,
                                                   tmrp.tgl_simpan AS wkt_farmasi_msk,
                                                   tmrp.tgl_keluar AS wkt_farmasi_klr,
                                                   tm.tgl_ranap AS wkt_ranap,
                                                   tm.tgl_ranap_keluar AS wkt_ranap_keluar,
                                                   tm.tgl_bayar AS wkt_selesai,
                                                   tm.tipe AS tipe,
                                                   tm.status AS status
                                               ')
                                               ->from('tbl_trans_medcheck tm')
                                               ->join('tbl_pendaftaran p', 'p.id = tm.id_dft', 'join')
                                               ->join('tbl_trans_medcheck_lab tml', 'tml.id_medcheck = tm.id', 'left')
                                               ->join('tbl_trans_medcheck_rad tmr', 'tmr.id_medcheck = tm.id', 'left')
                                               ->join('tbl_trans_medcheck_resep tmrp', 'tmrp.id_medcheck = tm.id', 'left')
                                               ->where('tm.status_hps', '0')
                                               ->where('DATE(tm.tgl_simpan)', $tgl)
                                               ->like('tm.id_poli', $poli, (!empty($poli) ? 'none' : ''))
                                               ->like('tm.tipe', $tipe, (!empty($tipe) ? 'none' : ''))
                                               ->order_by('tm.id', 'DESC')
                                               ->get()->result();
                    break;

                case 'per_rentang':
                    $data['sql_tracer'] = $this->db
                                               ->select('
                                                   tm.id AS id,
                                                   tm.id_poli AS id_poli,
                                                   tm.no_rm AS no_rm,
                                                   tm.pasien AS nama_pgl,
                                                   tm.tgl_simpan AS tgl_simpan,
                                                   CAST(tm.tgl_simpan AS DATE) AS tanggal,
                                                   p.tgl_simpan AS wkt_daftar,
                                                   tm.tgl_periksa AS wkt_periksa,
                                                   tml.tgl_simpan AS wkt_sampling_msk,
                                                   tml.tgl_keluar AS wkt_sampling_klr,
                                                   tmr.tgl_simpan AS wkt_rad_msk,
                                                   tm.tgl_periksa_rad_keluar AS wkt_rad_klr,
                                                   tm.tgl_periksa_rad_kirim AS wkt_rad_krm,
                                                   tm.tgl_periksa_rad_baca AS wkt_rad_baca,
                                                   tmrp.tgl_simpan AS wkt_resep_msk,
                                                   tmrp.tgl_keluar AS wkt_resep_klr,
                                                   tm.tgl_bayar AS wkt_resep_byr,
                                                   tm.tgl_ttd AS wkt_resep_trm,
                                                   tmrp.tgl_simpan AS wkt_farmasi_msk,
                                                   tmrp.tgl_keluar AS wkt_farmasi_klr,
                                                   tm.tgl_ranap AS wkt_ranap,
                                                   tm.tgl_ranap_keluar AS wkt_ranap_keluar,
                                                   tm.tgl_bayar AS wkt_selesai,
                                                   tm.tipe AS tipe,
                                                   tm.status AS status
                                               ')
                                               ->from('tbl_trans_medcheck tm')
                                               ->join('tbl_pendaftaran p', 'p.id = tm.id_dft', 'join')
                                               ->join('tbl_trans_medcheck_lab tml', 'tml.id_medcheck = tm.id', 'left')
                                               ->join('tbl_trans_medcheck_rad tmr', 'tmr.id_medcheck = tm.id', 'left')
                                               ->join('tbl_trans_medcheck_resep tmrp', 'tmrp.id_medcheck = tm.id', 'left')
                                               ->where('tm.status_hps', '0')
                                               ->where('DATE(tm.tgl_simpan) >=', $tgl_awal)
                                               ->where('DATE(tm.tgl_simpan) <=', $tgl_akhir)
                                               ->like('tm.id_poli', $poli, (!empty($poli) ? 'none' : ''))
                                               ->like('tm.tipe', $tipe, (!empty($tipe) ? 'none' : ''))
                                               ->order_by('tm.id', 'DESC')
                                               ->get()->result();
                    break;
            }
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/laporan/sidebar_lap';
            /* --- Sidebar Menu --- */
            
            /* Load view tampilan */
            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/laporan/data_tracer', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_tracer_div(){
        if (akses::aksesLogin() == TRUE) {
            $dokter     = $this->input->get('id_dokter');
            $jml        = $this->input->get('jml');
            $tgl        = $this->input->get('tgl');
            $tgl_awal   = $this->input->get('tgl_awal');
            $tgl_akhir  = $this->input->get('tgl_akhir');
            $tipe       = $this->input->get('tipe');
            $case       = $this->input->get('case');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();
            
            $data['hasError'] = $this->session->flashdata('form_error');
        
            $sql_doc = $this->db->where('id', general::dekrip($dokter))->get('tbl_m_karyawan')->row();
            
            switch ($case) {
                case 'per_tanggal':
                    $data['sql_tracer'] = $this->db->select('
                                               tm.id AS id,
                                               tm.id_poli AS id_poli,
                                               tm.no_rm AS no_rm,
                                               tm.pasien AS nama_pgl,
                                               tm.tgl_simpan AS tgl_simpan,
                                               CAST(tm.tgl_simpan AS DATE) AS tanggal,
                                               p.tgl_simpan AS wkt_daftar,
                                               tm.tgl_periksa AS wkt_periksa,
                                               tml.tgl_simpan AS wkt_sampling_msk,
                                               tml.tgl_keluar AS wkt_sampling_klr,
                                               tmr.tgl_simpan AS wkt_rad_msk,
                                               tm.tgl_periksa_rad_keluar AS wkt_rad_klr,
                                               tm.tgl_periksa_rad_kirim AS wkt_rad_krm,
                                               tm.tgl_periksa_rad_baca AS wkt_rad_baca,
                                               tmrp.tgl_simpan AS wkt_resep_msk,
                                               tmrp.tgl_keluar AS wkt_resep_klr,
                                               tm.tgl_bayar AS wkt_resep_byr,
                                               tm.tgl_ttd AS wkt_resep_trm,
                                               tmrp.tgl_simpan AS wkt_farmasi_msk,
                                               tmrp.tgl_keluar AS wkt_farmasi_klr,
                                               tm.tgl_ranap AS wkt_ranap,
                                               tm.tgl_ranap_keluar AS wkt_ranap_keluar,
                                               tm.tgl_bayar AS wkt_selesai,
                                               tm.tipe AS tipe,
                                               tm.status AS status
                                           ')
                                           ->from('tbl_trans_medcheck tm')
                                           ->join('tbl_pendaftaran p', 'p.id = tm.id_dft', 'join')
                                           ->join('tbl_trans_medcheck_lab tml', 'tml.id_medcheck = tm.id', 'left')
                                           ->join('tbl_trans_medcheck_rad tmr', 'tmr.id_medcheck = tm.id', 'left')
                                           ->join('tbl_trans_medcheck_resep tmrp', 'tmrp.id_medcheck = tm.id', 'left')
                                           ->where('tm.status_hps', '0')
                                           ->where('DATE(tm.tgl_simpan)', $tgl)
                                           ->like('tm.tipe', $tipe, (!empty($tipe) ? 'none' : ''))
                                           ->order_by('tm.id', 'DESC')
                                           ->get()->result();
                    break;

                case 'per_rentang':
                    $data['sql_tracer'] = $this->db->select('
                                               tm.id AS id,
                                               tm.id_poli AS id_poli,
                                               tm.no_rm AS no_rm,
                                               tm.pasien AS nama_pgl,
                                               tm.tgl_simpan AS tgl_simpan,
                                               CAST(tm.tgl_simpan AS DATE) AS tanggal,
                                               p.tgl_simpan AS wkt_daftar,
                                               tm.tgl_periksa AS wkt_periksa,
                                               tml.tgl_simpan AS wkt_sampling_msk,
                                               tml.tgl_keluar AS wkt_sampling_klr,
                                               tmr.tgl_simpan AS wkt_rad_msk,
                                               tm.tgl_periksa_rad_keluar AS wkt_rad_klr,
                                               tm.tgl_periksa_rad_kirim AS wkt_rad_krm,
                                               tm.tgl_periksa_rad_baca AS wkt_rad_baca,
                                               tmrp.tgl_simpan AS wkt_resep_msk,
                                               tmrp.tgl_keluar AS wkt_resep_klr,
                                               tm.tgl_bayar AS wkt_resep_byr,
                                               tm.tgl_ttd AS wkt_resep_trm,
                                               tmrp.tgl_simpan AS wkt_farmasi_msk,
                                               tmrp.tgl_keluar AS wkt_farmasi_klr,
                                               tm.tgl_ranap AS wkt_ranap,
                                               tm.tgl_ranap_keluar AS wkt_ranap_keluar,
                                               tm.tgl_bayar AS wkt_selesai,
                                               tm.tipe AS tipe,
                                               tm.status AS status
                                           ')
                                           ->from('tbl_trans_medcheck tm')
                                           ->join('tbl_pendaftaran p', 'p.id = tm.id_dft', 'join')
                                           ->join('tbl_trans_medcheck_lab tml', 'tml.id_medcheck = tm.id', 'left')
                                           ->join('tbl_trans_medcheck_rad tmr', 'tmr.id_medcheck = tm.id', 'left')
                                           ->join('tbl_trans_medcheck_resep tmrp', 'tmrp.id_medcheck = tm.id', 'left')
                                           ->where('tm.status_hps', '0')
                                           ->where('DATE(tm.tgl_simpan) >=', $tgl_awal)
                                           ->where('DATE(tm.tgl_simpan) <=', $tgl_akhir)
                                           ->like('tm.tipe', $tipe, (!empty($tipe) ? 'none' : ''))
                                           ->order_by('tm.id', 'DESC')
                                           ->get()->result();
                    break;
            }
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/laporan/sidebar_lap';
            /* --- Sidebar Menu --- */
            
            /* Load view tampilan */
            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/laporan/data_tracer_div', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function data_referall(){
        if (akses::aksesLogin() == TRUE) {
            $dokter     = $this->input->get('id_dokter');
            $hal        = $this->input->get('halaman');
            $tgl        = $this->input->get('tgl');
            $tgl_awal   = $this->input->get('tgl_awal');
            $tgl_akhir  = $this->input->get('tgl_akhir');
            $case       = $this->input->get('case');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();
            
            $sql_doc = $this->db->where('id', general::dekrip($dokter))->get('tbl_m_karyawan')->row();
            
            // Get total count based on case
            $jml = 0;
            if ($case == 'per_tanggal') {
                $jml = $this->db->from('tbl_trans_medcheck tm')
                            ->join('tbl_m_karyawan k', 'tm.id_referall = k.id_user', 'left')
                            ->where('tm.id_referall IS NOT NULL')
                            ->where('tm.id_referall <>', '')
                            ->where('tm.id_referall <>', '0')
                            ->where('DATE(tm.tgl_simpan)', $tgl)
                            ->like('tm.id_referall', (!empty($sql_doc->id_user) ? $sql_doc->id_user : ''))
                            ->count_all_results();
            } else if ($case == 'per_rentang') {
                $jml = $this->db->from('tbl_trans_medcheck tm')
                            ->join('tbl_m_karyawan k', 'tm.id_referall = k.id_user', 'left')
                            ->where('tm.id_referall IS NOT NULL')
                            ->where('tm.id_referall <>', '')
                            ->where('tm.id_referall <>', '0')
                            ->where('DATE(tm.tgl_simpan) >=', $tgl_awal)
                            ->where('DATE(tm.tgl_simpan) <=', $tgl_akhir)
                            ->like('tm.id_referall', (!empty($sql_doc->id_user) ? $sql_doc->id_user : ''))
                            ->count_all_results();
            }
            
            if($jml > 0){
                $data['hasError'] = $this->session->flashdata('form_error');
                
                # Config Pagination
                $config['base_url']              = base_url('laporan/data_referall.php?case='.$case.(!empty($tgl) ? '&tgl='.$tgl : '').(!empty($tgl_awal) ? '&tgl_awal='.$tgl_awal : '').(!empty($tgl_akhir) ? '&tgl_akhir='.$tgl_akhir : ''));
                $config['total_rows']            = $jml;
                
                $config['query_string_segment']  = 'halaman';
                $config['page_query_string']     = TRUE;
                $config['per_page']              = $pengaturan->jml_item;
                $config['num_links']             = 3;
                
                $config['first_tag_open']        = '<li class="page-item">';
                $config['first_tag_close']       = '</li>';
                
                $config['prev_tag_open']         = '<li class="page-item">';
                $config['prev_tag_close']        = '</li>';
                
                $config['num_tag_open']          = '<li class="page-item">';
                $config['num_tag_close']         = '</li>';
                
                $config['next_tag_open']         = '<li class="page-item">';
                $config['next_tag_close']        = '</li>';
                
                $config['last_tag_open']         = '<li class="page-item">';
                $config['last_tag_close']        = '</li>';
                
                $config['cur_tag_open']          = '<li class="page-item"><a href="#" class="page-link text-dark"><b>';
                $config['cur_tag_close']         = '</b></a></li>';
                
                $config['first_link']            = '&laquo;';
                $config['prev_link']             = '&lsaquo;';
                $config['next_link']             = '&rsaquo;';
                $config['last_link']             = '&raquo;';
                $config['anchor_class']          = 'class="page-link"';
                
                switch ($case) {
                    case 'per_tanggal':
                        if (isset($hal)) {
                            $data['sql_referall'] = $this->db
                                                ->select('
                                                    tm.id AS id,
                                                    k.id_user AS id_user,
                                                    tm.tgl_simpan AS tgl_simpan,
                                                    tm.tgl_masuk AS tgl_masuk,
                                                    CONCAT(p.kode_dpn, "", p.kode) AS no_rm,
                                                    p.nama_pgl AS nama_pasien,
                                                    k.nama AS nama_karyawan
                                                ')
                                                ->from('tbl_trans_medcheck tm')
                                                ->join('tbl_m_pasien p', 'tm.id_pasien = p.id', 'left')
                                                ->join('tbl_m_karyawan k', 'tm.id_referall = k.id_user', 'left')
                                                ->where('tm.id_referall IS NOT NULL')
                                                ->where('tm.id_referall <>', '')
                                                ->where('tm.id_referall <>', '0')
                                                ->where('DATE(tm.tgl_simpan)', $tgl)
                                                ->like('tm.id_referall', (!empty($sql_doc->id_user) ? $sql_doc->id_user : ''))
                                                ->limit($config['per_page'], $hal)
                                                ->get()->result();
                        } else {
                            $data['sql_referall'] = $this->db
                                                ->select('
                                                    tm.id AS id,
                                                    k.id_user AS id_user,
                                                    tm.tgl_simpan AS tgl_simpan,
                                                    tm.tgl_masuk AS tgl_masuk,
                                                    CONCAT(p.kode_dpn, "", p.kode) AS no_rm,
                                                    p.nama_pgl AS nama_pasien,
                                                    k.nama AS nama_karyawan
                                                ')
                                                ->from('tbl_trans_medcheck tm')
                                                ->join('tbl_m_pasien p', 'tm.id_pasien = p.id', 'left')
                                                ->join('tbl_m_karyawan k', 'tm.id_referall = k.id_user', 'left')
                                                ->where('tm.id_referall IS NOT NULL')
                                                ->where('tm.id_referall <>', '')
                                                ->where('tm.id_referall <>', '0')
                                                ->where('DATE(tm.tgl_simpan)', $tgl)
                                                ->like('tm.id_referall', (!empty($sql_doc->id_user) ? $sql_doc->id_user : ''))
                                                ->limit($config['per_page'])
                                                ->get()->result();
                        }
                        break;

                    case 'per_rentang':
                        if (isset($hal)) {
                            $data['sql_referall'] = $this->db
                                                ->select('
                                                    tm.id AS id,
                                                    k.id_user AS id_user,
                                                    tm.tgl_simpan AS tgl_simpan,
                                                    tm.tgl_masuk AS tgl_masuk,
                                                    CONCAT(p.kode_dpn, "", p.kode) AS no_rm,
                                                    p.nama_pgl AS nama_pasien,
                                                    k.nama AS nama_karyawan
                                                ')
                                                ->from('tbl_trans_medcheck tm')
                                                ->join('tbl_m_pasien p', 'tm.id_pasien = p.id', 'left')
                                                ->join('tbl_m_karyawan k', 'tm.id_referall = k.id_user', 'left')
                                                ->where('tm.id_referall IS NOT NULL')
                                                ->where('tm.id_referall <>', '')
                                                ->where('tm.id_referall <>', '0')
                                                ->where('DATE(tm.tgl_simpan) >=', $tgl_awal)
                                                ->where('DATE(tm.tgl_simpan) <=', $tgl_akhir)
                                                ->like('tm.id_referall', (!empty($sql_doc->id_user) ? $sql_doc->id_user : ''))
                                                ->limit($config['per_page'], $hal)
                                                ->get()->result();
                        } else {
                            $data['sql_referall'] = $this->db
                                                ->select('
                                                    tm.id AS id,
                                                    k.id_user AS id_user,
                                                    tm.tgl_simpan AS tgl_simpan,
                                                    tm.tgl_masuk AS tgl_masuk,
                                                    CONCAT(p.kode_dpn, "", p.kode) AS no_rm,
                                                    p.nama_pgl AS nama_pasien,
                                                    k.nama AS nama_karyawan
                                                ')
                                                ->from('tbl_trans_medcheck tm')
                                                ->join('tbl_m_pasien p', 'tm.id_pasien = p.id', 'left')
                                                ->join('tbl_m_karyawan k', 'tm.id_referall = k.id_user', 'left')
                                                ->where('tm.id_referall IS NOT NULL')
                                                ->where('tm.id_referall <>', '')
                                                ->where('tm.id_referall <>', '0')
                                                ->where('DATE(tm.tgl_simpan) >=', $tgl_awal)
                                                ->where('DATE(tm.tgl_simpan) <=', $tgl_akhir)
                                                ->like('tm.id_referall', (!empty($sql_doc->id_user) ? $sql_doc->id_user : ''))
                                                ->limit($config['per_page'])
                                                ->get()->result();
                        }
                        break;
                }

                // Initializing Config Pagination
                $this->pagination->initialize($config);
                
                // Pagination Data
                $data['total_rows'] = $config['total_rows'];
                $data['PerPage']    = $config['per_page'];
                $data['pagination'] = $this->pagination->create_links();
            }
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/laporan/sidebar_lap';
            /* --- Sidebar Menu --- */
            
            /* Load view tampilan */
            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/laporan/data_referall', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function set_data_referall(){
        if (akses::aksesLogin() == TRUE) {
            $tanggal = $this->input->post('tanggal');
            $case = $this->input->get('case');
            
            $pengaturan = $this->db->get('tbl_pengaturan')->row();
            
            if(!empty($tanggal)){
                $tgl_rentang = explode(' - ', $tanggal);
                $tgl_awal = $this->tanggalan->tgl_indo_sys(trim($tgl_rentang[0]));
                $tgl_akhir = $this->tanggalan->tgl_indo_sys(trim($tgl_rentang[1]));
                
                redirect(base_url('laporan/data_referall.php?case=per_rentang&tgl_awal='.$tgl_awal.'&tgl_akhir='.$tgl_akhir));
            }
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function xls_data_referall(){
        if (akses::aksesLogin() == TRUE) {
            $tgl_awal  = $this->input->get('tgl_awal');
            $tgl_akhir = $this->input->get('tgl_akhir');
            
            if(!empty($tgl_awal) && !empty($tgl_akhir)){
                $jml        = $this->input->get('jml');
                $pengaturan = $this->db->get('tbl_pengaturan')->row();
                
                $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                
                // Header Tabel
                $sheet->getStyle('A1:E1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A1:E1')->getFont()->setBold(TRUE);
                
                $sheet->setCellValue('A1', 'NO')
                        ->setCellValue('B1', 'TANGGAL')
                        ->setCellValue('C1', 'NO RM')
                        ->setCellValue('D1', 'PASIEN')
                        ->setCellValue('E1', 'KARYAWAN');
                
                $sheet->getColumnDimension('A')->setWidth(7);
                $sheet->getColumnDimension('B')->setWidth(18);
                $sheet->getColumnDimension('C')->setWidth(35);
                $sheet->getColumnDimension('D')->setWidth(35);
                $sheet->getColumnDimension('E')->setWidth(35);
                
                $sql_referall = $this->db
                                ->select('
                                    tm.id AS id,
                                    k.id_user AS id_user,
                                    tm.tgl_simpan AS tgl_simpan,
                                    tm.tgl_masuk AS tgl_masuk,
                                    CONCAT(p.kode_dpn, "", p.kode) AS no_rm,
                                    p.nama_pgl AS nama_pasien,
                                    k.nama AS nama_karyawan
                                ')
                                ->from('tbl_trans_medcheck tm')
                                ->join('tbl_m_pasien p', 'tm.id_pasien = p.id', 'left')
                                ->join('tbl_m_karyawan k', 'tm.id_referall = k.id_user', 'left')
                                ->where('tm.id_referall IS NOT NULL')
                                ->where('tm.id_referall <>', '')
                                ->where('tm.id_referall <>', '0')
                                ->where('DATE(tm.tgl_simpan) >=', $tgl_awal)
                                ->where('DATE(tm.tgl_simpan) <=', $tgl_akhir)
                                ->get()->result();
                
                if(!empty($sql_referall)){
                    $no    = 1;
                    $cell  = 2;
                    foreach ($sql_referall as $ref){
                        $sheet->getStyle('A'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                        $sheet->getStyle('B'.$cell.':E'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                        
                        $sheet->setCellValue('A'.$cell, $no)
                                ->setCellValue('B'.$cell, $this->tanggalan->tgl_indo($ref->tgl_simpan))
                                ->setCellValue('C'.$cell, $ref->no_rm)
                                ->setCellValue('D'.$cell, $ref->nama_pasien)
                                ->setCellValue('E'.$cell, $ref->nama_karyawan);
                        
                        $no++;
                        $cell++;
                    }
                }
                
                // Rename worksheet
                $sheet->setTitle('Lap Referall');
                
                /** Page Setup * */
                $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);
                $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
                
                /* -- Margin -- */
                $sheet->getPageMargins()->setTop(0.25);
                $sheet->getPageMargins()->setRight(0);
                $sheet->getPageMargins()->setLeft(0);
                $sheet->getPageMargins()->setFooter(0);
                
                
                /** Page Setup * */
                // Set document properties
                $spreadsheet->getProperties()->setCreator("Referall Report")
                        ->setLastModifiedBy($this->ion_auth->user()->row()->username)
                        ->setTitle("Referall")
                        ->setSubject("Referall Report")
                        ->setDescription("Kunjungi http://tigerasoft.co.id")
                        ->setKeywords("Referall Report")
                        ->setCategory("Referall Report");
                
                
                
                ob_end_clean();
                // Redirect output to a client's web browser (Excel)
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="data_referall_'.$tgl_awal.'_'.$tgl_akhir.'.xlsx"');
                
                // If you're serving to IE over SSL, then the following may be needed
                header('Expires: Mon, 15 Feb 1992 05:00:00 GMT'); // Date in the past
                header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
                header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
                header('Pragma: public'); // HTTP/1.0
                
                $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
                $writer->save('php://output');
                exit;
            }
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function xls_data_referensi() {
        if (akses::aksesLogin() == TRUE) {
            $tipe = $this->input->get('tipe');
            
            // Create new Spreadsheet object
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            
            // Set column width
            $sheet->getColumnDimension('A')->setWidth(5);
            $sheet->getColumnDimension('B')->setWidth(15);
            $sheet->getColumnDimension('C')->setWidth(70);
            $sheet->getColumnDimension('D')->setWidth(20);
            $sheet->getColumnDimension('E')->setWidth(10);
            $sheet->getColumnDimension('F')->setWidth(15);
            $sheet->getColumnDimension('G')->setWidth(20);
            
            // Set header style
            $styleArray = [
                'font' => [
                    'bold' => true,
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => [
                        'argb' => 'FFCCCCCC',
                    ],
                ],
            ];
            
            // Set header
            $sheet->setCellValue('A1', 'No.');
            $sheet->setCellValue('B1', 'Kode');
            $sheet->setCellValue('C1', 'Nama Item');
            $sheet->setCellValue('D1', 'Kategori');
            $sheet->setCellValue('E1', 'Stok');
            $sheet->setCellValue('F1', 'Satuan');
            $sheet->setCellValue('G1', 'Harga Jual');
            
            $sheet->getStyle('A1:G1')->applyFromArray($styleArray);
            
            // Get data based on tipe
            switch ($tipe) {
                case '0':
                    $sql_referensi = $this->db
                                    ->select('tbl_m_produk.id, tbl_m_produk.kode, tbl_m_produk.produk as nama_produk, tbl_m_produk.harga_beli, tbl_m_produk.harga_jual, tbl_m_produk.id_satuan, tbl_m_produk.id_kategori,
                                    (SELECT COUNT(id) FROM tbl_m_produk_ref WHERE tbl_m_produk_ref.id_produk = tbl_m_produk.id AND tbl_m_produk_ref.id_produk > 0) as stok')
                                    ->where('tbl_m_produk.status_subt', '0')
                                    ->where('tbl_m_produk.status_hps', '0')
                                    ->where('(SELECT COUNT(id) FROM tbl_m_produk_ref WHERE tbl_m_produk_ref.id_produk = tbl_m_produk.id AND tbl_m_produk_ref.id_produk > 0) >', 0)
                                    ->group_by('tbl_m_produk.id')
                                    ->order_by('tbl_m_produk.produk', 'ASC')
                                    ->get('tbl_m_produk')->result();
                    break;
                
                case '1':
                    $sql_referensi = $this->db
                                    ->select('tbl_m_produk.id, tbl_m_produk.kode, tbl_m_produk.produk as nama_produk, tbl_m_produk.harga_beli, tbl_m_produk.harga_jual, tbl_m_produk.id_satuan, tbl_m_produk.id_kategori,
                                    (SELECT COUNT(id) FROM tbl_m_produk_ref WHERE tbl_m_produk_ref.id_produk = tbl_m_produk.id AND tbl_m_produk_ref.id_produk > 0) as stok')
                                    ->where('tbl_m_produk.status_subt', '1')
                                    ->where('tbl_m_produk.status_hps', '0')
                                    ->where('(SELECT COUNT(id) FROM tbl_m_produk_ref WHERE tbl_m_produk_ref.id_produk = tbl_m_produk.id AND tbl_m_produk_ref.id_produk > 0) >', 0)
                                    ->group_by('tbl_m_produk.id')
                                    ->order_by('tbl_m_produk.produk', 'ASC')
                                    ->get('tbl_m_produk')->result();
                    break;
                
                case '2':
                    $sql_referensi = $this->db
                                    ->select('tbl_m_produk.id, tbl_m_produk.kode, tbl_m_produk.produk as nama_produk, tbl_m_produk.harga_beli, tbl_m_produk.harga_jual, tbl_m_produk.id_satuan, tbl_m_produk.id_kategori,
                                    (SELECT COUNT(id) FROM tbl_m_produk_ref WHERE tbl_m_produk_ref.id_produk = tbl_m_produk.id AND tbl_m_produk_ref.id_produk > 0) as stok')
                                    ->where('tbl_m_produk.status_hps', '0')
                                    ->where('(SELECT COUNT(id) FROM tbl_m_produk_ref WHERE tbl_m_produk_ref.id_produk = tbl_m_produk.id AND tbl_m_produk_ref.id_produk > 0) >', 0)
                                    ->group_by('tbl_m_produk.id')
                                    ->order_by('tbl_m_produk.produk', 'ASC')
                                    ->get('tbl_m_produk')->result();
                    break;
            }
            
            // Fill data
            $row = 2;
            $no = 1;
            
            foreach ($sql_referensi as $data) {                
                // Get item references
                $item_refs      = $this->db->where('id_produk', $data->id)->get('tbl_m_produk_ref')->result();
                // Get satuan for the product
                $item_satuan    = $this->db->where('id', $data->id_satuan)->get('tbl_m_satuan')->row();
                // Get product data first to get the id_kategori
                $item_kat       = $this->db->where('id', $data->id_kategori)->get('tbl_m_kategori')->row();
                // Get stok all gudang
                $stok           = $this->db->where('id_produk', $data->id)->get('tbl_m_produk_ref')->row();

                $sheet->getStyle('A'.$row.':B'.$row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->getStyle('C'.$row.':D'.$row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('E'.$row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('F'.$row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->getStyle('G'.$row)->getNumberFormat()->setFormatCode("_(\"\"* #,##0_);_(\"\"* \(#,##0\);_(\"\"* \"-\"??_);_(@_)");
                
                // Add main item
                $sheet->setCellValue('A' . $row, $no++);
                $sheet->setCellValue('B' . $row, $data->kode);
                $sheet->setCellValue('C' . $row, $data->nama_produk);
                $sheet->setCellValue('D' . $row, $item_kat->keterangan);
                $sheet->setCellValue('E' . $row, '');
                $sheet->setCellValue('F' . $row, '');
                $sheet->setCellValue('G' . $row, $data->harga_jual);
                
                // Set alignment for numeric columns
                $sheet->getStyle('F' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                
                $row++;
                
                // Add item references indented below the main item
                foreach ($item_refs as $item_ref) {
                    $item_refd          = $this->db->where('id', $item_ref->id_produk_item)->get('tbl_m_produk')->row();
                    // Get satuan for the product
                    $item_satuan_ref    = $this->db->where('id', $item_refd->id_satuan)->get('tbl_m_satuan')->row();
                    // Get product data first to get the id_kategori
                    $item_kat_ref       = $this->db->where('id', $item_refd->id_kategori)->get('tbl_m_kategori')->row();
                    // Get stok all gudang
                    $stok_ref           = $this->db->where('id', $item_refd->id)->get('tbl_m_produk_ref')->row();

                    $sheet->getStyle('E'.$row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('F'.$row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    
                    $sheet->setCellValue('A' . $row, '');
                    $sheet->setCellValue('B' . $row, $item_ref->kode);
                    $sheet->setCellValue('C' . $row, '- ' . $item_ref->item);
                    $sheet->setCellValue('D' . $row, $item_kat_ref->keterangan);
                    $sheet->setCellValue('E' . $row, $item_ref->jml);
                    $sheet->setCellValue('F' . $row, $item_satuan_ref->satuanBesar);
                    $sheet->setCellValue('G' . $row, '');
                    
                    $row++;
                }
            }
            
            // Set border for all data
            $styleArray = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ];
            
            $sheet->getStyle('A1:F' . ($row - 1))->applyFromArray($styleArray);
            
            // Rename worksheet
            $sheet->setTitle('Data Item Referensi');
            
            // Page Setup
            $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
            $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
            
            // Margin
            $sheet->getPageMargins()->setTop(0.25);
            $sheet->getPageMargins()->setRight(0.25);
            $sheet->getPageMargins()->setLeft(0.25);
            $sheet->getPageMargins()->setBottom(0.25);
            
            // Set document properties
            $spreadsheet->getProperties()->setCreator("Data Item Referensi Report")
                    ->setLastModifiedBy($this->ion_auth->user()->row()->username)
                    ->setTitle("Data Item Referensi")
                    ->setSubject("Data Item Referensi Report")
                    ->setDescription("Kunjungi http://tigerasoft.com")
                    ->setKeywords("Data Item Referensi Report")
                    ->setCategory("Data Item Referensi Report");
            
            ob_end_clean();
            // Redirect output to a client's web browser (Excel)
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="data_item_referensi.xlsx"');
            
            // If you're serving to IE over SSL, then the following may be needed
            header('Expires: Mon, 15 Feb 1992 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0
            
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
            exit;
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_data_cuti(){
        if (akses::aksesLogin() == TRUE) {
            $kry     = $this->input->post('karyawan');
            $tgl     = $this->input->post('tgl');
            $tgl_rtg = $this->input->post('tgl_rentang');
            $bln     = $this->input->post('bulan');
            $tipe    = $this->input->post('tipe');
            $status  = $this->input->post('status');
            
            $pengaturan = $this->db->get('tbl_pengaturan')->row();
            
//            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
//            $this->form_validation->set_rules('dokter', 'Dokter', 'required');
//            
//            if ($this->form_validation->run() == FALSE) {
//                $msg_error = array(
//                    'dokter'   => form_error('dokter'),
//                );
//                
//                redirect(base_url('laporan/data_remunerasi.php'));
//            } else {
                $sql_kry = $this->db->where('id_user', $kry)->get('tbl_m_karyawan')->row();
                
                $tgl_rentang    = explode('-', $tgl_rtg);
                $tgl_awal       = $this->tanggalan->tgl_indo_sys($tgl_rentang[0]);
                $tgl_akhir      = $this->tanggalan->tgl_indo_sys($tgl_rentang[1]);
                $tgl_masuk      = $this->tanggalan->tgl_indo_sys($tgl);

                if(!empty($tgl)){
                    $sql = $this->db
                                ->where('id_kategori', $tipe)
                                ->where('DATE(tgl_simpan)', $tgl_masuk)
                                ->where('status', $status)
                                ->where('status', $status)
                                ->like('id_karyawan', $sql_kry->id, (!empty($sql_kry->id) ? 'none' : ''))
                                ->get('tbl_sdm_cuti');
                    
//                    redirect(base_url('laporan/data_cuti.php?case=per_tanggal&id_kary='.general::enkrip($sql_kry->id_user).'&tgl='.$tgl_masuk.'&tipe='.$tipe.'&jml='.$sql->num_rows()));
//                }elseif(!empty($tgl_rtg)){
//                    $sql = $this->db
//                                ->like('id_karyawan', (!empty($sql_kry->id) ? $sql_kry->id : ''))
//                                ->where('DATE(tgl_masuk) >=', $tgl_awal)->where('DATE(tgl_simpan) <=', $tgl_akhir)->get('tbl_sdm_cuti');
//                    
                    redirect(base_url('laporan/data_cuti.php?case=per_rentang&id_kary='.general::enkrip($sql_kry->id_user).'&tgl='.$tgl_masuk.'&tipe='.$tipe.'&status='.$status.'&jml='.$sql->num_rows()));
                }elseif(!empty($bln)){
                    $sql = $this->db
                                ->where('id_kategori', $tipe)
                                ->where('MONTH(tgl_simpan)', $bln)
                                ->like('status', $status, (!empty($status) ? 'none' : ''))
//                                ->like('id_karyawan', $sql_kry->id, (!empty($sql_kry->id) ? 'none' : ''))
                                ->get('tbl_sdm_cuti');
                                        
                    redirect(base_url('laporan/data_cuti.php?case=per_bulan&id_kary='.general::enkrip($sql_kry->id_user).'&bln='.$bln.'&tipe='.$tipe.'&status='.$status.'&jml='.$sql->num_rows()));
                }else{
                    redirect(base_url('laporan/data_cuti.php'));
                }
                    
                echo '<pre>';
                print_r($sql->row());
                echo '</pre>';
//                echo '<pre>';
//                print_r($sql_kry);
//                echo '</pre>';
//            }
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_data_periksa(){
        if (akses::aksesLogin() == TRUE) {
            $dokter  = $this->input->post('dokter');
            $tgl     = $this->input->post('tgl');
            $tgl_rtg = $this->input->post('tgl_rentang');
            
            $pengaturan = $this->db->get('tbl_pengaturan')->row();
            
//            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
//            $this->form_validation->set_rules('dokter', 'Dokter', 'required');
//            
//            if ($this->form_validation->run() == FALSE) {
//                $msg_error = array(
//                    'dokter'   => form_error('dokter'),
//                );
//                
//                redirect(base_url('laporan/data_remunerasi.php'));
//            } else {
                $sql_doc = $this->db->where('id_user', $dokter)->get('tbl_m_karyawan')->row();
                
                $tgl_rentang    = explode('-', $tgl_rtg);
                $tgl_awal       = $this->tanggalan->tgl_indo_sys($tgl_rentang[0]);
                $tgl_akhir      = $this->tanggalan->tgl_indo_sys($tgl_rentang[1]);
                $tgl_masuk      = $this->tanggalan->tgl_indo_sys($tgl);

                if(!empty($tgl)){
                    $sql = $this->db->like('id_dokter', (!empty($sql_doc->id_user) ? $sql_doc->id_user : ''))->where('DATE(tgl_simpan)', $tgl_masuk)->get('tbl_trans_medcheck');
//                
                    redirect(base_url('laporan/data_periksa.php?case=per_tanggal&id_dokter='.general::enkrip($sql_doc->id_user).'&tgl='.$tgl_masuk.'&jml='.$sql->num_rows()));
                }elseif($tgl_rtg){
                    $sql = $this->db
                                ->like('id_dokter', (!empty($sql_doc->id_user) ? $sql_doc->id_user : ''))
                                ->where('DATE(tgl_simpan) >=', $tgl_awal)->where('DATE(tgl_simpan) <=', $tgl_akhir)->order_by('id', 'DESC')->get('tbl_trans_medcheck');
                    
                    redirect(base_url('laporan/data_periksa.php?case=per_rentang&id_dokter='.general::enkrip($sql_doc->id_user).'&tgl_awal='.$tgl_awal.'&tgl_akhir='.$tgl_akhir.'&jml='.$sql->num_rows()));
                }
                    
//                echo '<pre>';
//                print_r($sql->result());
//                echo '</pre>';
//            }
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_data_remunerasi(){
        if (akses::aksesLogin() == TRUE) {
            $tipe    = $this->input->post('tipe');
            $dokter  = $this->input->post('dokter');
            $tgl     = $this->input->post('tgl');
            $tgl_rtg = $this->input->post('tgl_rentang');
            
            $pengaturan = $this->db->get('tbl_pengaturan')->row();
            
            $dokter_param = '';
            if (!empty($dokter)) {
                $sql_doc = $this->db->where('id_user', $dokter)->get('tbl_m_karyawan')->row();
                $dokter_param = '&id_dokter='.general::enkrip($sql_doc->id_user);
            }
            
            $tgl_rentang    = explode('-', $tgl_rtg);
            $tgl_awal       = $this->tanggalan->tgl_indo_sys($tgl_rentang[0]);
            $tgl_akhir      = $this->tanggalan->tgl_indo_sys($tgl_rentang[1]);
            $tgl_masuk      = $this->tanggalan->tgl_indo_sys($tgl);

            if(!empty($tgl)){
                redirect(base_url('laporan/data_remunerasi.php?case=per_tanggal&tipe='.$tipe.$dokter_param.'&tgl='.$tgl_masuk));
            }elseif($tgl_rtg){
                redirect(base_url('laporan/data_remunerasi.php?case=per_rentang&tipe='.$tipe.$dokter_param.'&tgl_awal='.$tgl_awal.'&tgl_akhir='.$tgl_akhir));
            }
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_data_apresiasi(){
        if (akses::aksesLogin() == TRUE) {
            $dokter     = $this->input->post('dokter');
            $tgl        = $this->input->post('tgl');
            $tipe       = $this->input->post('tipe');
            $tgl_rtg    = $this->input->post('tgl_rentang');
            
            $pengaturan = $this->db->get('tbl_pengaturan')->row();
            
            $sql_doc = $this->db->where('id_user', $dokter)->get('tbl_m_karyawan')->row();
            
            $tgl_rentang    = explode('-', $tgl_rtg);
            $tgl_awal       = $this->tanggalan->tgl_indo_sys($tgl_rentang[0]);
            $tgl_akhir      = $this->tanggalan->tgl_indo_sys($tgl_rentang[1]);
            $tgl_masuk      = $this->tanggalan->tgl_indo_sys($tgl);

            if(!empty($tgl)){
                redirect(base_url('laporan/data_apresiasi.php?case=per_tanggal&tipe='.$tipe.'&id_dokter='.general::enkrip($sql_doc->id_user).'&tgl='.$tgl_masuk));
            }elseif($tgl_rtg){
                redirect(base_url('laporan/data_apresiasi.php?case=per_rentang&tipe='.$tipe.'&id_dokter='.general::enkrip($sql_doc->id_user).'&tgl_awal='.$tgl_awal.'&tgl_akhir='.$tgl_akhir));
            }
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_data_icd(){
        if (akses::aksesLogin() == TRUE) {
            $tgl     = $this->input->post('tgl');
            $tgl_rtg = $this->input->post('tgl_rentang');
            $poli    = $this->input->post('poli');
            $plat    = $this->input->post('platform');
            $idp     = $this->input->post('id_pasien');
            $pasien  = $this->input->post('pasien');
            $tipe    = $this->input->post('tipe');
            $dokter  = $this->input->post('dokter');
            
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $tgl_masuk = !empty($tgl) ? $this->tanggalan->tgl_indo_sys($tgl) : null;
            $tgl_awal = null;
            $tgl_akhir = null;

            if (!empty($tgl_rtg)) {
            $tgl_rentang = explode('-', $tgl_rtg);
                if (count($tgl_rentang) == 2) {
            $tgl_awal = $this->tanggalan->tgl_indo_sys($tgl_rentang[0]);
            $tgl_akhir = $this->tanggalan->tgl_indo_sys($tgl_rentang[1]);
                }
            }

            if (!empty($tgl)) {
                $sql = $this->db->select('tbl_m_pasien.nama_pgl')
                                ->join('tbl_m_icd', 'tbl_m_icd.id=tbl_trans_medcheck_icd.id_icd')
                                ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_icd.id_medcheck')
                                ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
                                ->where('tbl_trans_medcheck.status_hps', '0')
                                ->where('tbl_trans_medcheck.status_bayar', '1')
                                ->where('DATE(tbl_trans_medcheck_icd.tgl_simpan)', $tgl_masuk)
                                ->like('tbl_trans_medcheck.tipe', $tipe, (!empty($tipe) ? 'none' : ''))
                                ->like('tbl_trans_medcheck.id_poli', $poli, (!empty($poli) ? 'none' : ''))
//                                ->like('tbl_trans_medcheck.pasien', $pasien)
                                ->get('tbl_trans_medcheck_icd');
                
                # Lempar ke halaman laporan
                redirect(base_url('laporan/data_icd.php?case=per_tanggal&poli='.$poli.(!empty($pasien) ? '&id_pasien='.$idp.'&pasien='.$pasien : '').(!empty($plat) ? '&plat='.$plat : '').(!empty($tipe) ? '&tipe='.$tipe : '').'&tgl='.$tgl_masuk.'&jml=' . $sql->num_rows()));
            } elseif (!empty($tgl_awal) && !empty($tgl_akhir)) {
                $sql = $this->db->select('tbl_m_pasien.nama_pgl')
                                ->join('tbl_m_icd', 'tbl_m_icd.id=tbl_trans_medcheck_icd.id_icd')
                                ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_icd.id_medcheck')
                                ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
                                ->where('tbl_trans_medcheck.status_hps', '0')
                                ->where('tbl_trans_medcheck.status_bayar', '1')
                                ->where('DATE(tbl_trans_medcheck_icd.tgl_simpan) >=', $tgl_awal)
                                ->where('DATE(tbl_trans_medcheck_icd.tgl_simpan) <=', $tgl_akhir)
                                ->like('tbl_trans_medcheck.tipe', $tipe, (!empty($tipe) ? 'none' : ''))
                                ->like('tbl_trans_medcheck.id_poli', $poli, (!empty($poli) ? 'none' : ''))
//                                ->like('tbl_trans_medcheck.pasien', $pasien)
                                ->get('tbl_trans_medcheck_icd');
                
                # Lempar ke halaman laporan
                redirect(base_url('laporan/data_icd.php?case=per_rentang&poli='.$poli.(!empty($pasien) ? '&id_pasien='.$idp.'&pasien='.$pasien : '').(!empty($plat) ? '&plat='.$plat : '').(!empty($tipe) ? '&tipe='.$tipe : '').'&tgl_awal=' . $tgl_awal . '&tgl_akhir=' . $tgl_akhir . '&jml=' . $sql->num_rows()));
            }
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_data_icd_pasien(){
        if (akses::aksesLogin() == TRUE) {
            $tgl     = $this->input->post('tgl');
            $tgl_rtg = $this->input->post('tgl_rentang');
            $poli    = $this->input->post('poli');
            $plat    = $this->input->post('platform');
            $idp     = $this->input->post('id_pasien');
            $pasien  = $this->input->post('pasien');
            $tipe    = $this->input->post('tipe');
            
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            // Konversi format tanggal
            $tgl_masuk = !empty($tgl) ? $this->tanggalan->tgl_indo_sys($tgl) : null;
            $tgl_awal = null;
            $tgl_akhir = null;

            if (!empty($tgl_rtg)) {
            $tgl_rentang = explode('-', $tgl_rtg);
                if (count($tgl_rentang) == 2) {
            $tgl_awal = $this->tanggalan->tgl_indo_sys($tgl_rentang[0]);
            $tgl_akhir = $this->tanggalan->tgl_indo_sys($tgl_rentang[1]);
                }
            }

            if (!empty($tgl)) {
                $sql = $this->db->select('tbl_m_pasien.nama_pgl')
                                ->join('tbl_m_icd', 'tbl_m_icd.id=tbl_trans_medcheck_icd.id_icd')
                                ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_icd.id_medcheck')
                                ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
                                ->where('tbl_trans_medcheck.status_hps', '0')
                                ->where('tbl_trans_medcheck.status_bayar', '1')
                                ->where('DATE(tbl_trans_medcheck_icd.tgl_simpan)', $tgl_masuk)
                                ->like('tbl_trans_medcheck.tipe', $tipe, (!empty($tipe) ? 'none' : ''))
                                ->like('tbl_trans_medcheck.id_poli', $poli, (!empty($poli) ? 'none' : ''))
//                                ->like('tbl_trans_medcheck.pasien', $pasien)
                                ->get('tbl_trans_medcheck_icd');
                
                # Lempar ke halaman laporan
                redirect(base_url('laporan/data_icd.php?case=per_tanggal&poli='.$poli.(!empty($pasien) ? '&id_pasien='.$idp.'&pasien='.$pasien : '').(!empty($plat) ? '&plat='.$plat : '').(!empty($tipe) ? '&tipe='.$tipe : '').'&tgl='.$tgl_masuk.'&jml=' . $sql->num_rows()));
            } elseif (!empty($tgl_rtg)) {
                $sql = $this->db->select('tbl_m_pasien.nama_pgl')
                                ->join('tbl_m_icd', 'tbl_m_icd.id=tbl_trans_medcheck_icd.id_icd')
                                ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_icd.id_medcheck')
                                ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
                                ->where('tbl_trans_medcheck.status_hps', '0')
                                ->where('tbl_trans_medcheck.status_bayar', '1')
                                ->where('DATE(tbl_trans_medcheck_icd.tgl_simpan) >=', $tgl_awal)
                                ->where('DATE(tbl_trans_medcheck_icd.tgl_simpan) <=', $tgl_akhir)
                                ->like('tbl_trans_medcheck.tipe', $tipe, (!empty($tipe) ? 'none' : ''))
                                ->like('tbl_trans_medcheck.id_poli', $poli, (!empty($poli) ? 'none' : ''))
//                                ->like('tbl_trans_medcheck.pasien', $pasien)
                                ->get('tbl_trans_medcheck_icd');
                
                # Lempar ke halaman laporan
                redirect(base_url('laporan/data_icd.php?case=per_rentang&poli='.$poli.(!empty($pasien) ? '&id_pasien='.$idp.'&pasien='.$pasien : '').(!empty($plat) ? '&plat='.$plat : '').(!empty($tipe) ? '&tipe='.$tipe : '').'&tgl_awal=' . $tgl_awal . '&tgl_akhir=' . $tgl_akhir . '&jml=' . $sql->num_rows()));
            }
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_data_mcu(){
        if (akses::aksesLogin() == TRUE) {
            $tgl            = $this->input->post('tgl');
            $tgl_rtg        = $this->input->post('tgl_rentang');
            $poli           = $this->input->post('poli');
            $plat           = $this->input->post('platform');
            $idp            = $this->input->post('id_pasien');
            $pasien         = $this->input->post('pasien');
            $tipe           = $this->input->post('tipe');
            $inst           = $this->input->post('instansi');
            $dokter         = $this->input->post('dokter');
            
            $pengaturan     = $this->db->get('tbl_pengaturan')->row();
            
            if (!empty($dokter)) {
                $sql_doc    = $this->db->where('id', $dokter)->get('tbl_m_karyawan')->row();
            }

            $tgl_rentang    = explode('-', $tgl_rtg);
            $tgl_awal       = !empty($tgl_rtg) ? $this->tanggalan->tgl_indo_sys($tgl_rentang[0]) : null;
            $tgl_akhir      = !empty($tgl_rtg) ? $this->tanggalan->tgl_indo_sys($tgl_rentang[1]) : null;
            $tgl_masuk      = !empty($tgl) ? $this->tanggalan->tgl_indo_sys($tgl) : null;

            if (!empty($tgl)) {
                $sql = $this->db->select('tbl_m_pasien.id, tbl_m_pasien.nama, tbl_trans_medcheck_resume_det.id, tbl_trans_medcheck_resume_det.param, tbl_trans_medcheck_resume_det.param_nilai')
                                ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_resume_det.id_medcheck')
                                ->join('tbl_pendaftaran', 'tbl_pendaftaran.id=tbl_trans_medcheck.id_dft')
                                ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
                                ->where('tbl_trans_medcheck.tipe', '5')
                                ->where('DATE(tbl_trans_medcheck_resume_det.tgl_simpan)', $tgl_masuk)
                                ->like('tbl_pendaftaran.id_instansi', $inst, (!empty($inst) ? 'none' : ''))
                                ->get('tbl_trans_medcheck_resume_det');
                
                # Lempar ke halaman laporan
                redirect(base_url('laporan/data_mcu.php?case=per_tanggal&tgl=' . $tgl_masuk.'&id_instansi='.$inst . '&jml=' . $sql->num_rows()));
            } elseif (!empty($tgl_rtg)) {
                $sql = $this->db->select('tbl_m_pasien.id AS id_pasien, tbl_m_pasien.nama_pgl, tbl_trans_medcheck_resume.id, tbl_trans_medcheck_resume.id_medcheck, tbl_trans_medcheck_resume.id_user, tbl_trans_medcheck_resume.no_surat')
                                                         ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_resume.id_medcheck')
                                                         ->join('tbl_pendaftaran', 'tbl_pendaftaran.id=tbl_trans_medcheck.id_dft')
                                                         ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
                                                         ->where('tbl_trans_medcheck.tipe', '5')
                                ->where('DATE(tbl_trans_medcheck_resume.tgl_simpan) >=', $tgl_awal)
                                ->where('DATE(tbl_trans_medcheck_resume.tgl_simpan) <=', $tgl_akhir)
                                                         ->like('tbl_pendaftaran.id_instansi', $inst, (!empty($inst) ? 'none' : ''))
                                                         ->get('tbl_trans_medcheck_resume');
                
                # Lempar ke halaman laporan
                redirect(base_url('laporan/data_mcu.php?case=per_rentang&tgl_awal=' . $tgl_awal . '&tgl_akhir=' . $tgl_akhir .'&id_instansi='.$inst . '&jml=' . $sql->num_rows()));
            }
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_data_pembelian(){
        if (akses::aksesLogin() == TRUE) {
            $tgl     = $this->input->post('tgl');
            $tgl_rtg = $this->input->post('tgl_rentang');
            $idp     = $this->input->post('id_supplier');
            $supplier= $this->input->post('supplier');
            
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $sql_supp = $this->db->where('id', $supplier)->get('tbl_m_supplier')->row();

            $tgl_rentang = explode('-', $tgl_rtg);
            $tgl_awal = $this->tanggalan->tgl_indo_sys($tgl_rentang[0]);
            $tgl_akhir = $this->tanggalan->tgl_indo_sys($tgl_rentang[1]);
            $tgl_masuk = $this->tanggalan->tgl_indo_sys($tgl);

            if (!empty($tgl)) {
                $sql = $this->db->select('tbl_trans_beli.id')
                                ->join('tbl_m_supplier', 'tbl_m_supplier.id=tbl_trans_beli.id_supplier')
                                ->where('DATE(tbl_trans_beli.tgl_masuk)', $this->tanggalan->tgl_indo_sys($tgl))
                                ->like('tbl_m_supplier.nama', $sql_supp->nama)
                                ->get('tbl_trans_beli');
                
                # Lempar ke halaman laporan
                redirect(base_url('laporan/data_pembelian.php?case=per_tanggal&'.(!empty($supplier) ? 'id_supplier='.general::enkrip($sql_supp->id).'&supplier='.$sql_supp->nama.'&' : '').'tgl='.$tgl_masuk.'&jml=' . $sql->num_rows()));
            } elseif ($tgl_rtg) {
                $sql = $this->db->select('tbl_trans_beli.id')
                                ->join('tbl_m_supplier', 'tbl_m_supplier.id=tbl_trans_beli.id_supplier')
                                ->where('DATE(tbl_trans_beli.tgl_masuk) >=', $this->tanggalan->tgl_indo_sys($tgl_awal))
                                ->where('DATE(tbl_trans_beli.tgl_masuk) <=', $this->tanggalan->tgl_indo_sys($tgl_akhir))
                                ->like('tbl_m_supplier.nama', $sql_supp->nama)
                                ->get('tbl_trans_beli');
                
                # Lempar ke halaman laporan
                redirect(base_url('laporan/data_pembelian.php?case=per_rentang&'.(!empty($supplier) ? 'id_supplier='.general::enkrip($sql_supp->id).'&supplier='.$sql_supp->nama.'&' : '').'tgl_awal='.$tgl_awal.'&tgl_akhir='.$tgl_akhir.'&jml=' . $sql->num_rows()));
            }
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_data_omset(){
        if (akses::aksesLogin() == TRUE) {
            $tgl     = $this->input->post('tgl');
            $tgl_rtg = $this->input->post('tgl_rentang');
            $poli    = $this->input->post('poli');
            $plat    = $this->input->post('platform');
            $pjm     = $this->input->post('penjamin');
            $idp     = $this->input->post('id_pasien');
            $pasien  = $this->input->post('pasien');
            $tipe    = $this->input->post('tipe');
            
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $tgl_rentang = explode('-', $tgl_rtg);
            $tgl_awal = !empty($tgl_rtg) ? $this->tanggalan->tgl_indo_sys($tgl_rentang[0]) : null;
            $tgl_akhir = !empty($tgl_rtg) ? $this->tanggalan->tgl_indo_sys($tgl_rentang[1]) : null;
            $tgl_masuk = !empty($tgl) ? $this->tanggalan->tgl_indo_sys($tgl) : null;

            if (!empty($tgl)) {
                # Lempar ke halaman laporan
                redirect(base_url('laporan/data_omset.php?case=per_tanggal&poli='.$poli.(!empty($pasien) ? '&id_pasien='.$idp.'&pasien='.$pasien : '').(!empty($plat) ? '&plat='.$plat : '').(!empty($tipe) ? '&tipe='.$tipe : '').'&tgl='.$tgl_masuk));
            } elseif ($tgl_rtg) {
                # Lempar ke halaman laporan
                redirect(base_url('laporan/data_omset.php?case=per_rentang&poli='.$poli.(!empty($pasien) ? '&id_pasien='.$idp.'&pasien='.$pasien : '').(!empty($plat) ? '&plat='.$plat : '').(!empty($tipe) ? '&tipe='.$tipe : '').(!empty($pjm) ? '&tipe_bayar='.$pjm : '').'&tgl_awal=' . $tgl_awal . '&tgl_akhir=' . $tgl_akhir));
            }
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_data_omset_poli(){
        if (akses::aksesLogin() == TRUE) {
            $tgl            = $this->input->post('tgl');
            $tgl_rtg        = $this->input->post('tgl_rentang');
            $poli           = $this->input->post('poli');
            $tipe           = $this->input->post('tipe');
            $status         = $this->input->post('status');            
            $pengaturan     = $this->db->get('tbl_pengaturan')->row();

            $tgl_rentang    = explode('-', $tgl_rtg);
            $tgl_awal       = $this->tanggalan->tgl_indo_sys($tgl_rentang[0]);
            $tgl_akhir      = $this->tanggalan->tgl_indo_sys($tgl_rentang[1]);
            $tgl_masuk      = $this->tanggalan->tgl_indo_sys($tgl);

            $p              = json_encode($_POST['status']);
            $st             = json_decode($p);

            if (!empty($tgl)){
                redirect(base_url('laporan/data_omset_poli.php?case=per_tanggal'.(!empty($tipe) ? '&tipe='.$tipe : '').(!empty($poli) ? '&poli='.$poli : '').(!empty($status) ? '&status='.general::enkrip($p) : '').'&tgl=' . $tgl_masuk));
            } elseif ($tgl_rtg) {
                redirect(base_url('laporan/data_omset_poli.php?case=per_rentang'.(!empty($tipe) ? '&tipe='.$tipe : '').(!empty($poli) ? '&poli='.$poli : '').(!empty($status) ? '&status='.general::enkrip($p) : '').'&tgl_awal=' . $tgl_awal . '&tgl_akhir=' . $tgl_akhir));
            }
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_data_omset_detail(){
        if (akses::aksesLogin() == TRUE) {
            $tgl     = $this->input->post('tgl');
            $tgl_rtg = $this->input->post('tgl_rentang');
            $poli    = $this->input->post('poli');
            $tipe    = $this->input->post('tipe');
            $status  = $this->input->post('status');
            
            $pengaturan     = $this->db->get('tbl_pengaturan')->row();

            $tgl_rentang    = explode('-', $tgl_rtg);
            $tgl_awal       = $this->tanggalan->tgl_indo_sys($tgl_rentang[0]);
            $tgl_akhir      = $this->tanggalan->tgl_indo_sys($tgl_rentang[1]);
            $tgl_masuk      = $this->tanggalan->tgl_indo_sys($tgl);

            if (!empty($tgl)) {
                redirect(base_url('laporan/data_omset_detail.php?case=per_tanggal'.(!empty($tipe) ? '&tipe='.$tipe : '').(!empty($poli) ? '&poli='.$poli : '').(!empty($status) ? '&status='.$status : '').'&tgl=' . $tgl_masuk));
            } elseif ($tgl_rtg) {
                redirect(base_url('laporan/data_omset_detail.php?case=per_rentang'.(!empty($tipe) ? '&tipe='.$tipe : '').(!empty($poli) ? '&poli='.$poli : '').(!empty($status) ? '&status='.$status : '').'&tgl_awal=' . $tgl_awal . '&tgl_akhir=' . $tgl_akhir));
            }
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_data_omset_jasa(){
        if (akses::aksesLogin() == TRUE) {
            $tgl     = $this->input->post('tgl');
            $tgl_rtg = $this->input->post('tgl_rentang');
            $poli    = $this->input->post('poli');
            $plat    = $this->input->post('platform');
            $idp     = $this->input->post('id_pasien');
            $pasien  = $this->input->post('pasien');
            
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            // Convert date formats
            $tgl_masuk = !empty($tgl) ? $this->tanggalan->tgl_indo_sys($tgl) : null;
            $tgl_awal = null;
            $tgl_akhir = null;

            if (!empty($tgl_rtg)) {
            $tgl_rentang = explode('-', $tgl_rtg);
                if (count($tgl_rentang) == 2) {
            $tgl_awal = $this->tanggalan->tgl_indo_sys($tgl_rentang[0]);
            $tgl_akhir = $this->tanggalan->tgl_indo_sys($tgl_rentang[1]);
                }
            }

            if (!empty($tgl)) {
                $sql = $this->db->where('DATE(tgl_bayar)', $tgl_masuk)
                                ->where('status_hps', '0')
                                ->where('status_bayar', '1')
                                ->like('metode', $plat, (!empty($plat) ? 'none' : ''))
                                ->like('pasien', $pasien, (!empty($pasien) ? 'none' : ''))
                                ->like('tipe', $poli, (!empty($poli) ? 'none' : ''))
                                ->get('tbl_trans_medcheck');
                
                redirect(base_url('laporan/data_omset_jasa.php?case=per_tanggal&poli='.$poli.(!empty($pasien) ? '&id_pasien='.$idp.'&pasien='.$pasien : '').(!empty($plat) ? '&plat='.$plat : '').'&tgl=' . $tgl_masuk . '&jml=' . $sql->num_rows()));
            } elseif (!empty($tgl_awal) && !empty($tgl_akhir)) {
                $sql = $this->db
                        ->like('pasien', $pasien, (!empty($pasien) ? 'none' : ''))
                        ->like('tipe', $poli, (!empty($poli) ? 'none' : ''))
                        ->like('metode', $plat, (!empty($plat) ? 'none' : ''))
                        ->where('status_hps', '0')
                        ->where('status_bayar', '1')
                        ->where('DATE(tgl_bayar) >=', $tgl_awal)
                        ->where('DATE(tgl_bayar) <=', $tgl_akhir)
                        ->get('tbl_trans_medcheck');
                
                redirect(base_url('laporan/data_omset_jasa.php?case=per_rentang&poli='.$poli.(!empty($pasien) ? '&id_pasien='.$idp.'&pasien='.$pasien : '').(!empty($plat) ? '&plat='.$plat : '').'&tgl_awal=' . $tgl_awal . '&tgl_akhir=' . $tgl_akhir . '&jml=' . $sql->num_rows()));
            }
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_data_omset_dokter(){
        if (akses::aksesLogin() == TRUE) {
            $tgl     = $this->input->post('tgl');
            $tgl_rtg = $this->input->post('tgl_rentang');
            $poli    = $this->input->post('poli');
            $plat    = $this->input->post('platform');
            $dokter  = $this->input->post('dokter');
            
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            // Convert date formats
            $tgl_masuk = !empty($tgl) ? $this->tanggalan->tgl_indo_sys($tgl) : null;
            $tgl_awal = null;
            $tgl_akhir = null;

            if (!empty($tgl_rtg)) {
                $tgl_rentang = explode('-', $tgl_rtg);
                if (count($tgl_rentang) == 2) {
                    $tgl_awal = $this->tanggalan->tgl_indo_sys($tgl_rentang[0]);
                    $tgl_akhir = $this->tanggalan->tgl_indo_sys($tgl_rentang[1]);
                }
            }

            if (!empty($tgl)) {
                redirect(base_url('laporan/data_omset_dokter.php?case=per_tanggal&dokter='.general::enkrip($dokter).'&tgl=' . $tgl_masuk));
            } elseif (!empty($tgl_awal) && !empty($tgl_akhir)) {
                redirect(base_url('laporan/data_omset_dokter.php?case=per_rentang&dokter='.general::enkrip($dokter).'&tgl_awal=' . $tgl_awal . '&tgl_akhir=' . $tgl_akhir));
            }
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_data_omset_bukti(){
        if (akses::aksesLogin() == TRUE) {
            $tgl     = $this->input->post('tgl');
            $tgl_rtg = $this->input->post('tgl_rentang');
            
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $tgl_masuk = !empty($tgl) ? $this->tanggalan->tgl_indo_sys($tgl) : null;
            $tgl_awal = null;
            $tgl_akhir = null;
            
            if (!empty($tgl_rtg)) {
                $tgl_rentang = explode('-', $tgl_rtg);
                if (count($tgl_rentang) == 2) {
                    $tgl_awal = $this->tanggalan->tgl_indo_sys($tgl_rentang[0]);
                    $tgl_akhir = $this->tanggalan->tgl_indo_sys($tgl_rentang[1]);
                }
            }

            if (!empty($tgl)) {
                redirect(base_url('laporan/data_omset_bukti.php?case=per_tanggal&tgl=' . $tgl_masuk));
            } elseif (!empty($tgl_rtg) && !empty($tgl_awal) && !empty($tgl_akhir)) {
                redirect(base_url('laporan/data_omset_bukti.php?case=per_rentang&tgl_awal=' . $tgl_awal . '&tgl_akhir=' . $tgl_akhir));
            }
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_data_stok(){
        if (akses::aksesLogin() == TRUE) {
            $st     = $this->input->post('st');
            $stok   = $this->input->post('stok');
            
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('st', 'ST', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'st'            => form_error('st'),
                );

                $this->session->set_flashdata('form_error', $msg_error);

                redirect(base_url('laporan/data_stok.php'));
            } else {
                switch ($st) {
                    case '0' :
                        $stp = '';
                        $sql_stok = $this->db
                                 ->where('status_subt', '0')
                                 ->get('tbl_m_produk');
                        break;
                    
                    case '1' :
                        $stp = '<';
                        $sql_stok = $this->db
                                 ->where('status_subt', '1')
//                                 ->where('jml'.(isset($stp) ? ' '.$stp : ''), $stok)
                                 ->get('tbl_m_produk');
                        break;

                    case '2' :
                        $stp = '';
                        $sql_stok = $this->db
//                                 ->where('status_subt', '1')
//                                 ->where('jml'.(isset($stp) ? ' '.$stp : ''), $stok)
                                 ->get('tbl_m_produk');
                        break;

                    case '3' :
                        $stp = '>';
                        $sql_stok = $this->db
                                 ->where('status', '4')
                                 ->where('jml'.(isset($stp) ? ' '.$stp : ''), $stok)
                                 ->get('tbl_m_produk');
                        break;
                }
                
                
                redirect(base_url('laporan/data_stok.php?tipe='.$st.'&stok='.$stok.'&jml='.$sql_stok->num_rows()));
            }
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_data_stok_masuk() {
        if (akses::aksesLogin() == TRUE) {
            $tgl        = $this->input->post('tgl');
            $tgl_rtg    = $this->input->post('tgl_rentang');
            
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $tgl_rentang = explode('-', $tgl_rtg);
            $tgl_awal    = !empty($tgl_rtg) ? $this->tanggalan->tgl_indo_sys($tgl_rentang[0]) : '';
            $tgl_akhir   = !empty($tgl_rtg) ? $this->tanggalan->tgl_indo_sys($tgl_rentang[1]) : '';
            $tgl_masuk   = !empty($tgl) ? $this->tanggalan->tgl_indo_sys($tgl) : '';

            if (!empty($tgl)) {
                $sql = $this->db->select('tbl_trans_beli_det.kode')
                        ->join('tbl_trans_beli', 'tbl_trans_beli.id=tbl_trans_beli_det.id_pembelian')
                        ->where('DATE(tbl_trans_beli.tgl_masuk)', $tgl_masuk)
                        ->get('tbl_trans_beli_det');
                
                redirect(base_url('laporan/data_stok_masuk.php?case=per_tanggal&tgl=' . $tgl_masuk . '&jml=' . $sql->num_rows()));
            } elseif ($tgl_rtg) {
                $sql = $this->db->select('tbl_trans_beli_det.kode')
                        ->join('tbl_trans_beli', 'tbl_trans_beli.id=tbl_trans_beli_det.id_pembelian')
                        ->where('DATE(tbl_trans_beli.tgl_masuk) >=', $tgl_awal)
                        ->where('DATE(tbl_trans_beli.tgl_masuk) <=', $tgl_akhir)
                        ->get('tbl_trans_beli_det');
                redirect(base_url('laporan/data_stok_masuk.php?case=per_rentang&tgl_awal=' . $tgl_awal . '&tgl_akhir=' . $tgl_akhir . '&jml=' . $sql->num_rows()));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    public function set_data_stok_telusur(){
        if (akses::aksesLogin() == TRUE) {
            $item           = $this->input->post('item');
            $tgl            = $this->input->post('tgl');
            $tgl_rtg        = $this->input->post('tgl_rentang');            
            $gdg            = $this->input->post('gudang');            
            $pengaturan     = $this->db->get('tbl_pengaturan')->row();

            $tgl_rentang    = explode('-', $tgl_rtg);
            $tgl_awal       = $this->tanggalan->tgl_indo_sys($tgl_rentang[0]);
            $tgl_akhir      = $this->tanggalan->tgl_indo_sys($tgl_rentang[1]);
            $tgl_masuk      = $this->tanggalan->tgl_indo_sys($tgl);
            
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('item', 'Item', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'item' => form_error('item'),
                );

                $this->session->set_flashdata('form_error', $msg_error);

                redirect(base_url('laporan/data_stok_telusur.php'));
            } else {
                
                if(!empty($tgl)){
                    
                    redirect(base_url('laporan/data_stok_telusur.php?act=per_tanggal&id='.general::enkrip($item).'&tgl='.$tgl_masuk.'&id_gudang='.$gdg));
                }elseif($tgl_rtg){
                    
                    redirect(base_url('laporan/data_stok_telusur.php?act=per_rentang&id='.general::enkrip($item).'&tgl_awal='.$tgl_awal.'&tgl_akhir='.$tgl_akhir.'&id_gudang='.$gdg));
                }else{
                    redirect(base_url('laporan/data_stok_telusur.php'));
                }
            }
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_data_stok_pers(){
        if (akses::aksesLogin() == TRUE) {
            $item           = $this->input->post('item');
            $tgl            = $this->input->post('tgl');
            $tgl_rtg        = $this->input->post('tgl_rentang');            
            $gdg            = $this->input->post('gudang');            
            $bln            = $this->input->post('bulan');            
            $thn            = $this->input->post('tahun');            
            $pengaturan     = $this->db->get('tbl_pengaturan')->row();

            $tgl_rentang    = explode('-', $tgl_rtg);
            $tgl_awal       = $this->tanggalan->tgl_indo_sys($tgl_rentang[0]);
            $tgl_akhir      = $this->tanggalan->tgl_indo_sys($tgl_rentang[1]);
            $tgl_masuk      = $this->tanggalan->tgl_indo_sys($tgl);
            
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('item', 'Item', 'required');
//            $this->form_validation->set_rules('gudang', 'gudang', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'item'      => form_error('item'),
//                    'gudang'    => form_error('gudang'),
                );

                $this->session->set_flashdata('form_error', $msg_error);

                redirect(base_url('laporan/data_stok_pers.php'));
            } else {
                
                if(!empty($tgl)){
                    $this->db->query("TRUNCATE tbl_trans_stok_tmp");
                    $this->db->query("TRUNCATE tbl_trans_stok_tmp_glob");
                    
                    $stok_so    = $this->db->where('id_produk', $item)->where('status', '6')->where('DATE(tgl_simpan) <=', $tgl_masuk)->limit(1)->order_by('id', 'DESC')->get('v_produk_hist')->row();
                    $stok_bl    = $this->db->where('id_produk', $item)->where('status', '1')->where('DATE(tgl_simpan) <=', $tgl_masuk)->limit(1)->order_by('id', 'DESC')->get('v_produk_hist')->row();
                    $sql_hist   = $this->db
                                        ->where('id_produk', $item)
                                        ->where('DATE(tgl_masuk)', $tgl_masuk)
                                        ->where('status !=', '2')
//                                        ->where('status !=', '6')
                                        ->where('status !=', '8')
                                        ->group_by('tgl_simpan, id_penjualan, id_pembelian, id_pembelian_det, keterangan')
                                        ->order_by('tgl_simpan', 'asc')
                                        ->get('v_produk_hist')->result();
                    
                    crud::simpan('tbl_trans_stok_tmp_glob', array('id_item'=>$item,'jml'=>$stok_so->jml + $stok_bl->jml));
                    
                    foreach ($sql_hist as $hst){
                        $sa = $this->db->where('id_item', $item)->get('tbl_trans_stok_tmp_glob')->row();
                        
                        if($hst->status == '1'){
                            $sisa = $sa->jml + $hst->jml;
                            
                            crud::update('tbl_trans_stok_tmp_glob', 'id_item', $item, array('jml'=>$sisa));
                        }elseif($hst->status == '4'){
                            $sisa = $sa->jml - $hst->jml;
                            crud::update('tbl_trans_stok_tmp_glob', 'id_item', $item, array('jml'=>$sisa));
                        }elseif($hst->status == '6'){
                            $sisa = $sisa + $hst->jml;
                            crud::update('tbl_trans_stok_tmp_glob', 'id_item', $item, array('jml'=>$sisa));
                        }
                        
                        $data = array(
                            'id_item'       => $hst->id_produk,
                            'id_item_det'   => $hst->id,
                            'item'          => $hst->produk,
                            'keterangan'    => $hst->keterangan,
                            'stok_awal'     => $sa->jml,
                            'jml'           => $hst->jml,
                            'stok_akhir'    => $sisa,
                            'status'        => $hst->status,
                        );

                        crud::simpan('tbl_trans_stok_tmp', $data);
                    }
                    
                    redirect(base_url('laporan/data_stok_pers.php?act=per_tanggal&id='.general::enkrip($item).'&tgl='.$tgl_masuk.'&id_gudang='.$gdg));
                }elseif($tgl_rtg){
                    $this->db->query("TRUNCATE tbl_trans_stok_tmp");
                    $this->db->query("TRUNCATE tbl_trans_stok_tmp_glob");
                    
                    $stok_so    = $this->db->where('id_produk', $item)->where('status', '6')->where('DATE(tgl_simpan) <=', $tgl_awal)->limit(1)->order_by('id', 'DESC')->get('v_produk_hist')->row();
                    $stok_bl    = $this->db->where('id_produk', $item)->where('status', '1')->where('DATE(tgl_simpan) <=', $tgl_awal)->limit(1)->order_by('id', 'DESC')->get('v_produk_hist')->row();
                    $sql_hist   = $this->db
                                        ->where('id_produk', $item)
                                        ->where('DATE(tgl_masuk) >=', $tgl_awal)
                                        ->where('DATE(tgl_masuk) <=', $tgl_akhir)
                                        ->where('status !=', '2')
//                                        ->where('status !=', '6')
                                        ->where('status !=', '8')
                                        ->group_by('tgl_simpan, id_penjualan, id_pembelian, id_pembelian_det, keterangan')
                                        ->order_by('tgl_simpan', 'asc')
                                        ->get('v_produk_hist')->result();
                    
                    crud::simpan('tbl_trans_stok_tmp_glob', array('id_item'=>$item,'jml'=>$stok_so->jml + $stok_bl->jml));
                    
                    foreach ($sql_hist as $hst){
                        $sa = $this->db->where('id_item', $item)->get('tbl_trans_stok_tmp_glob')->row();
                        
                        if($hst->status == '1'){
                            $sisa = $sa->jml + $hst->jml;
                            
                            crud::update('tbl_trans_stok_tmp_glob', 'id_item', $item, array('jml'=>$sisa));
                        }elseif($hst->status == '4'){
                            $sisa = $sa->jml - $hst->jml;
                            crud::update('tbl_trans_stok_tmp_glob', 'id_item', $item, array('jml'=>$sisa));
                        }elseif($hst->status == '6'){
                            $sisa = $sisa + $hst->jml;
                            crud::update('tbl_trans_stok_tmp_glob', 'id_item', $item, array('jml'=>$sisa));
                        }
                        
                        $data = array(
                            'id_item'       => $hst->id_produk,
                            'id_item_det'   => $hst->id,
                            'item'          => $hst->produk,
                            'keterangan'    => $hst->keterangan,
                            'stok_awal'     => $sa->jml,
                            'jml'           => $hst->jml,
                            'stok_akhir'    => $sisa,
                            'status'        => $hst->status,
                        );

                        crud::simpan('tbl_trans_stok_tmp', $data);
                    }                   
                    
                    redirect(base_url('laporan/data_stok_pers.php?act=per_rentang&id='.general::enkrip($item).'&tgl_awal='.$tgl_awal.'&tgl_akhir='.$tgl_akhir.'&id_gudang='.$gdg));
                }else{
                    redirect(base_url('laporan/data_stok_pers.php'));
                }
            }
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_data_stok_keluar(){
        if (akses::aksesLogin() == TRUE) {
            $tgl     = $this->input->post('tgl');
            $tgl_rtg = $this->input->post('tgl_rentang');
            $dokter  = $this->input->post('id_dokter'); // Added missing variable
            
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            // Only query if dokter is provided
            $sql_doc = null;
            if (!empty($dokter)) {
            $sql_doc = $this->db->where('id', $dokter)->get('tbl_m_karyawan')->row();
            }

            // Handle date processing safely
            $tgl_awal = null;
            $tgl_akhir = null;
            $tgl_masuk = null;
            
            if (!empty($tgl)) {
            $tgl_masuk = $this->tanggalan->tgl_indo_sys($tgl);
            }
            
            if (!empty($tgl_rtg)) {
                $tgl_rentang = explode('-', $tgl_rtg);
                if (count($tgl_rentang) == 2) {
                    $tgl_awal = $this->tanggalan->tgl_indo_sys(trim($tgl_rentang[0]));
                    $tgl_akhir = $this->tanggalan->tgl_indo_sys(trim($tgl_rentang[1]));
                }
            }

            if (!empty($tgl)) {
                $sql = $this->db->select('tbl_trans_medcheck.tgl_masuk, tbl_trans_medcheck_det.kode, tbl_trans_medcheck_det.item')
                        ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_det.id_medcheck')
                        ->where('tbl_trans_medcheck.status_hps', '0')
                        ->where('tbl_trans_medcheck.status_bayar', '1')
                        ->where('DATE(tbl_trans_medcheck_det.tgl_simpan)', $tgl_masuk)
                        ->where('tbl_trans_medcheck_det.status', '4')
                        ->get('tbl_trans_medcheck_det');
                
                redirect(base_url('laporan/data_stok_keluar.php?case=per_tanggal&tgl=' . $tgl_masuk . '&jml=' . $sql->num_rows()));
            } elseif (!empty($tgl_awal) && !empty($tgl_akhir)) {
                $sql = $this->db->select('tbl_trans_medcheck.tgl_masuk, tbl_trans_medcheck_det.kode, tbl_trans_medcheck_det.item')
                        ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_det.id_medcheck')
                        ->where('tbl_trans_medcheck.status_hps', '0')
                        ->where('tbl_trans_medcheck.status_bayar', '1')
                        ->where('DATE(tbl_trans_medcheck_det.tgl_simpan) >=', $tgl_awal)
                        ->where('DATE(tbl_trans_medcheck_det.tgl_simpan) <=', $tgl_akhir)
                        ->where('tbl_trans_medcheck_det.status', '4')
                        ->get('tbl_trans_medcheck_det');
                redirect(base_url('laporan/data_stok_keluar.php?case=per_rentang&tgl_awal=' . $tgl_awal . '&tgl_akhir=' . $tgl_akhir . '&jml=' . $sql->num_rows()));
            }

//                echo '<pre>';
//                print_r($sql);
//                echo '</pre>';
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_data_stok_keluar_laku(){
        if (akses::aksesLogin() == TRUE) {
            $tgl     = $this->input->post('tgl');
            $tgl_rtg = $this->input->post('tgl_rentang');
            
            $tgl_rentang = explode('-', $tgl_rtg);
            $tgl_awal = $this->tanggalan->tgl_indo_sys($tgl_rentang[0]);
            $tgl_akhir = $this->tanggalan->tgl_indo_sys($tgl_rentang[1]);
            $tgl_masuk = $this->tanggalan->tgl_indo_sys($tgl);

            if (!empty($tgl)) {
                redirect(base_url('laporan/data_stok_keluar_laku.php?case=per_tanggal&tgl=' . $tgl_masuk));
            } elseif ($tgl_rtg) {
                redirect(base_url('laporan/data_stok_keluar_laku.php?case=per_rentang&tgl_awal=' . $tgl_awal . '&tgl_akhir=' . $tgl_akhir));
            }
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_data_stok_mutasi(){
        if (akses::aksesLogin() == TRUE) {
            $tgl            = $this->input->post('tgl');
            $tgl_rtg        = $this->input->post('tgl_rentang');
            $dokter         = $this->input->post('dokter');
            
            $pengaturan     = $this->db->get('tbl_pengaturan')->row();

            if (!empty($dokter)) {
                $sql_doc    = $this->db->where('id', $dokter)->get('tbl_m_karyawan')->row();
            }

            $tgl_masuk      = !empty($tgl) ? $this->tanggalan->tgl_indo_sys($tgl) : null;
            $tgl_awal       = null;
            $tgl_akhir      = null;
            
            if (!empty($tgl_rtg)) {
                $tgl_rentang = explode('-', $tgl_rtg);
                if (count($tgl_rentang) == 2) {
                    $tgl_awal = $this->tanggalan->tgl_indo_sys($tgl_rentang[0]);
                    $tgl_akhir = $this->tanggalan->tgl_indo_sys($tgl_rentang[1]);
                }
            }

            if (!empty($tgl)) {
                $sql = $this->db->where('DATE(tgl_simpan)', $tgl_masuk)
                                ->get('v_laporan_stok');
                
                redirect(base_url('laporan/data_stok_mutasi.php?case=per_tanggal&tgl=' . $tgl_masuk . '&jml=' . $sql->num_rows()));
            } elseif (!empty($tgl_awal) && !empty($tgl_akhir)) {
                $sql = $this->db
//                                ->where('DATE(tgl_simpan) >=', $tgl_awal)
//                                ->where('DATE(tgl_simpan) <=', $tgl_akhir)
                                ->get('v_produk_stok');
                redirect(base_url('laporan/data_stok_mutasi.php?case=per_rentang&tgl_awal=' . $tgl_awal . '&tgl_akhir=' . $tgl_akhir . '&jml=' . $sql->num_rows()));
            }

//                echo '<pre>';
//                print_r($sql);
//                echo '</pre>';
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_data_stok_keluar_resep(){
        if (akses::aksesLogin() == TRUE) {
            $tgl     = $this->input->post('tgl');
            $tgl_rtg = $this->input->post('tgl_rentang');
            $dokter  = $this->input->post('dokter');
            
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $sql_doc = $this->db->where('id_user', $dokter)->get('tbl_m_karyawan')->row();

            $tgl_rentang = explode('-', $tgl_rtg);
            $tgl_awal = $this->tanggalan->tgl_indo_sys($tgl_rentang[0]);
            $tgl_akhir = $this->tanggalan->tgl_indo_sys($tgl_rentang[1]);
            $tgl_masuk = $this->tanggalan->tgl_indo_sys($tgl);

            if (!empty($tgl)) {
                $sql = $this->db->select('tbl_trans_medcheck.id, tbl_trans_medcheck.tipe_bayar, tbl_trans_medcheck.tgl_simpan, tbl_trans_medcheck.no_rm, tbl_trans_medcheck.no_nota, tbl_trans_medcheck.tipe, tbl_m_pasien.nama_pgl, tbl_m_pasien.tgl_lahir, tbl_m_pasien.alamat, tbl_m_pasien.alamat_dom, tbl_m_pasien.instansi, tbl_m_pasien.instansi_alamat, tbl_trans_medcheck_resep_det.kode, tbl_trans_medcheck_resep_det.item, tbl_trans_medcheck_resep_det.dosis, tbl_trans_medcheck_resep_det.dosis_ket, tbl_trans_medcheck_resep_det.keterangan, tbl_trans_medcheck_resep_det.harga, tbl_trans_medcheck_resep_det.jml')
                                ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_resep_det.id_medcheck')
                                ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
                                ->join('tbl_m_kategori', 'tbl_m_kategori.id=tbl_trans_medcheck_resep_det.id_item_kat')
                                ->where('tbl_trans_medcheck.status_bayar', '1')
                                ->where('tbl_trans_medcheck_resep_det.id_user', $dokter)
                                ->where('DATE(tbl_trans_medcheck_resep_det.tgl_simpan)', $tgl_masuk)
                                ->order_by('tbl_trans_medcheck_resep_det.tgl_simpan', 'ASC')
                                ->get('tbl_trans_medcheck_resep_det');
                redirect(base_url('laporan/data_stok_keluar_resep.php?case=per_tanggal&dokter='.general::enkrip($dokter).'&tgl=' . $tgl_masuk . '&jml=' . $sql->num_rows()));
            } elseif ($tgl_rtg) {
                $sql = $this->db->select('tbl_trans_medcheck.id, tbl_trans_medcheck.tipe_bayar, tbl_trans_medcheck.tgl_simpan, tbl_trans_medcheck.no_rm, tbl_trans_medcheck.no_nota, tbl_trans_medcheck.tipe, tbl_m_pasien.nama_pgl, tbl_m_pasien.tgl_lahir, tbl_m_pasien.alamat, tbl_m_pasien.alamat_dom, tbl_m_pasien.instansi, tbl_m_pasien.instansi_alamat, tbl_trans_medcheck_resep_det.kode, tbl_trans_medcheck_resep_det.item, tbl_trans_medcheck_resep_det.dosis, tbl_trans_medcheck_resep_det.dosis_ket, tbl_trans_medcheck_resep_det.keterangan, tbl_trans_medcheck_resep_det.harga, tbl_trans_medcheck_resep_det.jml')
                                ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_resep_det.id_medcheck')
                                ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
                                ->join('tbl_m_kategori', 'tbl_m_kategori.id=tbl_trans_medcheck_resep_det.id_item_kat')
                                ->where('tbl_trans_medcheck.status_bayar', '1')
                                ->where('tbl_trans_medcheck_resep_det.id_user', $dokter)
                                ->where('DATE(tbl_trans_medcheck_resep_det.tgl_simpan) >=', $tgl_awal)
                                ->where('DATE(tbl_trans_medcheck_resep_det.tgl_simpan) <=', $tgl_akhir)
                                ->order_by('tbl_trans_medcheck_resep_det.tgl_simpan', 'ASC')
                                ->get('tbl_trans_medcheck_resep_det');
                
                redirect(base_url('laporan/data_stok_keluar_resep.php?case=per_rentang&dokter='.general::enkrip($dokter).'&tgl_awal=' . $tgl_awal . '&tgl_akhir=' . $tgl_akhir . '&jml=' . $sql->num_rows()));
            }

//            echo $dokter;
//                echo '<pre>';
//                print_r($sql->result());
//                echo '</pre>';
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    

    public function set_data_pasien(){
        if (akses::aksesLogin() == TRUE) {
            // Ambil parameter dari input
            $tgl        = $this->input->post('tgl');
            $tgl_rtg    = $this->input->post('tgl_rentang');
            $statusPas  = $this->input->post('statusPasien');
            $bulan      = $this->input->post('bulan');
            
            // Konversi format tanggal
            $tgl_masuk  = !empty($tgl) ? trim($this->tanggalan->tgl_indo_sys($tgl)) : null;
            $tgl_awal   = null;
            $tgl_akhir  = null;
            
            if (!empty($tgl_rtg)) {
                $tgl_rentang = explode('-', $tgl_rtg);
                if (count($tgl_rentang) == 2) {
                    $tgl_awal   = trim($this->tanggalan->tgl_indo_sys($tgl_rentang[0]));
                    $tgl_akhir  = trim($this->tanggalan->tgl_indo_sys($tgl_rentang[1]));
                }
            }
            
            // Menentukan URL dasar
            $redirect_url = 'laporan/data_pasien.php';

            // Menyimpan parameter dalam array
            $params = [];

            // Menentukan case dan parameter berdasarkan input tanggal
            if (!empty($tgl)) {
                // Jika tanggal tunggal diisi (format MM-DD)
                $params['case']         = 'per_tanggal';
                $params['tgl']          = $tgl;
            } elseif (!empty($tgl_awal) && !empty($tgl_akhir)) {
                // Jika rentang tanggal diisi
                $params['case']         = 'per_rentang';
                $params['tgl_awal']     = $tgl_awal;
                $params['tgl_akhir']    = $tgl_akhir;
            } elseif (!empty($bulan)) {
                $params['case']         = 'per_bulan';
                $params['bulan']        = $bulan;
            } else {    
                // Jika tidak ada filter tanggal, redirect ke halaman utama
                redirect(base_url('laporan/data_pasien.php'));
                return;
            }

            // Tambahkan parameter status pasien
            $params['status_pas']       = $statusPas;
            
            // Gabungkan semua parameter ke dalam URL
            $redirect_url .= '?' . http_build_query($params);

            // Redirect ke halaman laporan dengan parameter yang benar
            redirect(base_url($redirect_url));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function set_data_pasien_st(){
        if (akses::aksesLogin() == TRUE) {
            $tgl            = $this->input->post('tgl');
            $tgl_rtg        = $this->input->post('tgl_rentang');
            $statusPas      = $this->input->post('statusPasien');
            
            $pengaturan     = $this->db->get('tbl_pengaturan')->row();
            $tgl_rentang    = explode('-', $tgl_rtg);

            $pengaturan     = $this->db->get('tbl_pengaturan')->row();

            // **Mengonversi tanggal rentang jika ada**
            $tgl_awal   = null;
            $tgl_akhir  = null;

            if (!empty($tgl_rtg)) {
                $tgl_rentang = explode('-', $tgl_rtg);

                if (count($tgl_rentang) == 2) { // Pastikan ada dua tanggal yang valid
                    $tgl_awal  = trim($this->tanggalan->tgl_indo_sys($tgl_rentang[0]));
                    $tgl_akhir = trim($this->tanggalan->tgl_indo_sys($tgl_rentang[1]));
                }
            }

            // **Mengonversi tanggal masuk jika ada**
            $tgl_masuk = !empty($tgl) ? trim($this->tanggalan->tgl_indo_sys($tgl)) : null;

            // **Redirect sesuai dengan kondisi yang terpenuhi**
            if (!empty($tgl_rtg)) {
                // Jika hanya tanggal rentang yang terisi               
                // **Menentukan kueri berdasarkan status pasien**
                $this->db->select("id_pasien, tgl_simpan, kode_pasien, pasien, jumlah");
                $this->db->from("v_pasien");
                $this->db->where("DATE(tgl_simpan) >=", $tgl_awal);
                $this->db->where("DATE(tgl_simpan) <=", $tgl_akhir);

                if ($statusPas == "1") {
                    // Jika statusPas = 1 (Pasien Baru), cari yang jumlahnya = 1
                    $this->db->where("jumlah", '1');
                } elseif ($statusPas == "2") {
                    // Jika statusPas = 2 (Pasien Lama), cari yang jumlahnya > 1
                    $this->db->where("jumlah >", '1');
                }

                $query = $this->db->get();
                $jml = $query->num_rows(); // Hitung jumlah hasil kueri

                // Redirect ke halaman laporan dengan parameter pencarian
                redirect(base_url('laporan/data_pasien_st.php?case=per_rentang&tgl_awal=' . $tgl_awal . '&tgl_akhir=' . $tgl_akhir . '&status_pas=' . $statusPas . '&jml=' . $jml));
            } elseif (!empty($tgl)) {
                // Jika hanya tanggal spesifik yang terisi             
                // **Menentukan kueri berdasarkan status pasien**
                $this->db->select("id_pasien, tgl_simpan, kode_pasien, pasien, jumlah");
                $this->db->from("v_pasien");
                $this->db->where("DATE(tgl_simpan)", $tgl_masuk);

                if ($statusPas == "1") {
                    // Jika statusPas = 1 (Pasien Baru), cari yang jumlahnya = 1
                    $this->db->where("jumlah", '1');
                } elseif ($statusPas == "2") {
                    // Jika statusPas = 2 (Pasien Lama), cari yang jumlahnya > 1
                    $this->db->where("jumlah >", '1');
                }

                $query = $this->db->get();
                $jml = $query->num_rows(); // Hitung jumlah hasil kueri
                
                redirect(base_url('laporan/data_pasien_st.php?case=per_tanggal&tgl=' . $tgl_masuk . '&status_pas=' . $statusPas));
            } else {
                // Jika tidak ada filter yang terisi, redirect ke halaman utama
                redirect(base_url('laporan/data_pasien_st.php'));
            }
            exit; // Pastikan script berhenti setelah redirect
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    public function set_data_pasien_kunj(){
        if (akses::aksesLogin() == TRUE) {
            $tgl        = $this->input->post('tgl');
            $tgl_rtg    = $this->input->post('tgl_rentang');
            $poli       = $this->input->post('poli');
            $tipe       = $this->input->post('tipe');
            
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $tgl_rentang    = explode('-', $tgl_rtg);
            $tgl_awal       = $this->tanggalan->tgl_indo_sys($tgl_rentang[0]);
            $tgl_akhir      = $this->tanggalan->tgl_indo_sys($tgl_rentang[1]);
            $tgl_masuk      = $this->tanggalan->tgl_indo_sys($tgl);

            if (!empty($tgl)) {
                redirect(base_url('laporan/data_visit_pasien.php?case=per_tanggal&tgl=' . $tgl_masuk.(!empty($poli) ? '&poli='.$poli : '').(!empty($tipe) ? '&tipe='.$tipe : '')));
            } elseif ($tgl_rtg) {
                redirect(base_url('laporan/data_visit_pasien.php?case=per_rentang&tgl_awal=' . $tgl_awal . '&tgl_akhir=' . $tgl_akhir.(!empty($poli) ? '&poli='.$poli : '').(!empty($tipe) ? '&tipe='.$tipe : '')));
            }
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function set_data_pasien_periksa(){
        if (akses::aksesLogin() == TRUE) {
            $tgl        = $this->input->post('tgl');
            $tgl_rtg    = $this->input->post('tgl_rentang');
            $poli       = $this->input->post('poli');
            $tipe       = $this->input->post('tipe');
            $pasien     = $this->input->post('id_pasien');
            
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $tgl_rentang    = explode('-', $tgl_rtg);
            $tgl_awal       = $this->tanggalan->tgl_indo_sys($tgl_rentang[0]);
            $tgl_akhir      = $this->tanggalan->tgl_indo_sys($tgl_rentang[1]);
            $tgl_masuk      = $this->tanggalan->tgl_indo_sys($tgl);

            if (!empty($tgl)) {
                redirect(base_url('laporan/data_pemeriksaan.php?case=per_tanggal&tgl=' . $tgl_masuk.(!empty($pasien) ? '&id_pasien='.$pasien : '')));
            } elseif ($tgl_rtg) {
                redirect(base_url('laporan/data_pemeriksaan.php?case=per_rentang&tgl_awal=' . $tgl_awal . '&tgl_akhir=' . $tgl_akhir.(!empty($pasien) ? '&id_pasien='.$pasien : '')));
            }
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function set_data_pasien_periksa_rj(){
        if (akses::aksesLogin() == TRUE) {
            $tgl        = $this->input->post('tgl');
            $tgl_rtg    = $this->input->post('tgl_rentang');
            $poli       = $this->input->post('poli');
            $tipe       = $this->input->post('tipe');
            $pasien     = $this->input->post('id_pasien');
            
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $tgl_rentang    = explode('-', $tgl_rtg);
            $tgl_awal       = $this->tanggalan->tgl_indo_sys($tgl_rentang[0]);
            $tgl_akhir      = $this->tanggalan->tgl_indo_sys($tgl_rentang[1]);
            $tgl_masuk      = $this->tanggalan->tgl_indo_sys($tgl);

            if (!empty($tgl)) {
                redirect(base_url('laporan/data_pemeriksaan_rj.php?case=per_tanggal&tgl=' . $tgl_masuk.(!empty($pasien) ? '&id_pasien='.$pasien : '')));
            } elseif ($tgl_rtg) {
                redirect(base_url('laporan/data_pemeriksaan_rj.php?case=per_rentang&tgl_awal=' . $tgl_awal . '&tgl_akhir=' . $tgl_akhir.(!empty($pasien) ? '&id_pasien='.$pasien : '')));
            }
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_data_karyawan_ultah(){
        if (akses::aksesLogin() == TRUE) {
            $tgl        = $this->input->post('tgl');
            $tgl_rtg    = $this->input->post('tgl_rentang');
            $tipe       = $this->input->post('tipe');
            
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $tgln       = explode('-', $tgl);
            $tgl_rentang= explode('-', $tgl_rtg);
            $tgl_awal   = $this->tanggalan->tgl_indo_sys($tgl_rentang[0]);
            $tgl_akhir  = $this->tanggalan->tgl_indo_sys($tgl_rentang[1]);
            $day1       = explode('-', $tgl_awal);
            $day2       = explode('-', $tgl_akhir);
            

            if (!empty($tgl)) {
                $sql = $this->db->where('tbl_m_karyawan.no_hp !=', '')
                                ->where('DAY(tbl_m_karyawan.tgl_lahir)', $tgln[0])
                                ->where('MONTH(tbl_m_karyawan.tgl_lahir)', $tgln[1])
                                ->get('tbl_m_karyawan');
                
                # Lempar ke halaman laporan
                redirect(base_url('laporan/data_karyawan_ultah.php?case=per_tanggal'.'&tgl='.$tgln[0].'&bln='.$tgln[1].'&jml=' . $sql->num_rows()));
            }else{
                $sql = $this->db->where('tbl_m_karyawan.no_hp !=', '')
                                ->where('DAY(tbl_m_karyawan.tgl_lahir) >=', $day1[2])
                                ->where('MONTH(tbl_m_karyawan.tgl_lahir) >=', $day1[1])
                                ->where('DAY(tbl_m_karyawan.tgl_lahir) <=', $day2[2])
                                ->where('MONTH(tbl_m_karyawan.tgl_lahir) <=', $day2[1])
                                ->get('tbl_m_karyawan');
                
                # Lempar ke halaman laporan
                redirect(base_url('laporan/data_karyawan_ultah.php?case=per_rentang&hr_awal='.$day1[2].'&hr_akhir='.$day2[2].'&bln_awal='.$day1[1].'&bln_akhir='.$day2[1].'&jml=' . $sql->num_rows()));
            }
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function set_data_tracer(){
        if (akses::aksesLogin() == TRUE) {
            $tipe           = $this->input->post('tipe');
            $tgl            = $this->input->post('tgl');
            $tgl_rtg        = $this->input->post('tgl_rentang');
            $poli           = $this->input->post('poli');
            $tipe           = $this->input->post('tipe');
            
            $pengaturan     = $this->db->get('tbl_pengaturan')->row();

            $tgln           = explode('-', $tgl);
            $tgl_rentang    = explode('-', $tgl_rtg);
            $tgl_awal       = $this->tanggalan->tgl_indo_sys($tgl_rentang[0]);
            $tgl_akhir      = $this->tanggalan->tgl_indo_sys($tgl_rentang[1]);
            $tgl_masuk      = $this->tanggalan->tgl_indo_sys($tgl);
            

            if(!empty($tgl)) {
                redirect(base_url('laporan/data_tracer.php?case=per_tanggal&tgl=' . $tgl_masuk.(!empty($tipe) ? '&tipe='.$tipe : '').(!empty($poli) ? '&poli='.$poli : '')));
            } elseif ($tgl_rtg) {
                redirect(base_url('laporan/data_tracer.php?case=per_rentang&tgl_awal=' . $tgl_awal . '&tgl_akhir=' . $tgl_akhir.(!empty($tipe) ? '&tipe='.$tipe : '').(!empty($poli) ? '&poli='.$poli : '')));
            }
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function set_data_tracer_div(){
        if (akses::aksesLogin() == TRUE) {
            $tipe           = $this->input->post('tipe');
            $tgl            = $this->input->post('tgl');
            $tgl_rtg        = $this->input->post('tgl_rentang');
            
            $pengaturan     = $this->db->get('tbl_pengaturan')->row();

            $tgln           = explode('-', $tgl);
            $tgl_rentang    = explode('-', $tgl_rtg);
            $tgl_awal       = $this->tanggalan->tgl_indo_sys($tgl_rentang[0]);
            $tgl_akhir      = $this->tanggalan->tgl_indo_sys($tgl_rentang[1]);
            $tgl_masuk      = $this->tanggalan->tgl_indo_sys($tgl);
            

            if(!empty($tgl)) {
                redirect(base_url('laporan/data_tracer_div.php?case=per_tanggal&tgl=' . $tgl_masuk.'&tipe='.$tipe));
            } elseif ($tgl_rtg) {
                redirect(base_url('laporan/data_tracer_div.php?case=per_rentang&tgl_awal=' . $tgl_awal . '&tgl_akhir=' . $tgl_akhir.'&tipe='.$tipe));
            }
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function xls_data_remunerasi(){
        if (akses::aksesLogin() == TRUE) {
            $dokter     = $this->input->get('id_dokter');
            $jml        = $this->input->get('jml');
            $tgl        = $this->input->get('tgl');
            $tgl_awal   = $this->input->get('tgl_awal');
            $tgl_akhir  = $this->input->get('tgl_akhir');
            $case       = $this->input->get('case');
            $tipe       = $this->input->get('tipe');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $grup       = $this->ion_auth->get_users_groups()->row();
            $id_user    = $this->ion_auth->user()->row()->id;
            $id_grup    = $this->ion_auth->get_users_groups()->row();

            if($jml > 0){
                $sql_doc = $this->db->where('id_user', general::dekrip($dokter))->get('tbl_m_karyawan')->row();
                
                $this->db->select('tbl_trans_medcheck_remun.id AS id, 
                                  tbl_trans_medcheck_remun.id_dokter AS id_dokter, 
                                  tbl_trans_medcheck_remun.tgl_simpan AS tgl_simpan, 
                                  CONCAT(tbl_m_karyawan.nama_dpn, " ", tbl_m_karyawan.nama) AS dokter, 
                                  tbl_m_karyawan.nama_blk AS dokter_blk, 
                                  tbl_m_poli.lokasi AS poli, 
                                  tbl_trans_medcheck.no_rm AS no_rm, 
                                  tbl_m_pasien.nama_pgl AS nama_pgl, 
                                  tbl_trans_medcheck_det.item AS item, 
                                  tbl_trans_medcheck_det.jml AS jml, 
                                  tbl_trans_medcheck_remun.harga AS harga, 
                                  tbl_trans_medcheck_remun.remun_nom AS remun_nom, 
                                  tbl_trans_medcheck_remun.remun_subtotal AS remun_subtotal, 
                                  tbl_trans_medcheck_remun.remun_perc AS remun_perc, 
                                  tbl_trans_medcheck.tipe AS tipe, 
                                  tbl_m_produk.status AS status_produk')
                    ->from('tbl_trans_medcheck_remun')
                    ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id = tbl_trans_medcheck_remun.id_medcheck')
                    ->join('tbl_trans_medcheck_det', 'tbl_trans_medcheck_det.id = tbl_trans_medcheck_remun.id_medcheck_det')
                    ->join('tbl_m_pasien', 'tbl_m_pasien.id = tbl_trans_medcheck.id_pasien')
                    ->join('tbl_m_poli', 'tbl_m_poli.id = tbl_trans_medcheck.id_poli')
                    ->join('tbl_m_produk', 'tbl_m_produk.id = tbl_trans_medcheck_remun.id_item')
                    ->join('tbl_m_karyawan', 'tbl_m_karyawan.id_user = tbl_trans_medcheck_remun.id_dokter');
                
                switch ($case){
                    case 'per_tanggal':
                        $this->db->where('DATE(tbl_trans_medcheck_remun.tgl_simpan)', $tgl);
                        break;
                    
                    case 'per_rentang':
                        $this->db->where('DATE(tbl_trans_medcheck_remun.tgl_simpan) >=', $tgl_awal);
                        $this->db->where('DATE(tbl_trans_medcheck_remun.tgl_simpan) <=', $tgl_akhir);
                        break;
                }
                
                if(!empty($tipe)) {
                    $this->db->like('tbl_m_produk.status', $tipe);
                }
                
                if(!empty($sql_doc->id_user)) {
                    $this->db->where('tbl_trans_medcheck_remun.id_dokter', $sql_doc->id_user);
                }
                
                $this->db->order_by('tbl_trans_medcheck_remun.id', 'asc');
                $sql_remun = $this->db->get()->result();
            }

            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Header Tabel Nota
            $sheet->getStyle('A4:J4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A4:J4')->getFont()->setBold(TRUE);

            $sheet->setCellValue('A4', 'No.')
                    ->setCellValue('B4', 'Tgl')
                    ->setCellValue('C4', 'No. Faktur')
                    ->setCellValue('D4', 'Dokter')
                    ->setCellValue('E4', 'Tindakan')
                    ->setCellValue('F4', 'Pasien')
                    ->setCellValue('G4', 'Jml')
                    ->setCellValue('H4', 'Harga')
                    ->setCellValue('I4', 'Remunerasi')
                    ->setCellValue('J4', 'Subtotal');

            $sheet->getColumnDimension('A')->setWidth(6);
            $sheet->getColumnDimension('B')->setWidth(20);
            $sheet->getColumnDimension('C')->setWidth(20);
            $sheet->getColumnDimension('D')->setWidth(30);
            $sheet->getColumnDimension('E')->setWidth(50);
            $sheet->getColumnDimension('F')->setWidth(40);
            $sheet->getColumnDimension('G')->setWidth(6);
            $sheet->getColumnDimension('H')->setWidth(14);
            $sheet->getColumnDimension('I')->setWidth(14);
            $sheet->getColumnDimension('J')->setWidth(14);

            if(!empty($sql_remun)){
                $no    = 1;
                $cell  = 5;
                $total = 0;
                foreach ($sql_remun as $penjualan){
                    $dokter   = $this->db->where('id_user', $penjualan->id_dokter)->get('tbl_m_karyawan')->row();
                    $remun    = ($penjualan->remun_nom > 0 ? $penjualan->remun_nom : (($penjualan->remun_perc / 100) * $penjualan->harga));
                    $total    = $total + $penjualan->remun_subtotal;

                    $sheet->getStyle('A'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('G'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('B'.$cell.':F'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                    $sheet->getStyle('H'.$cell.':J'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    $sheet->getStyle('H'.$cell.':J'.$cell)->getNumberFormat()->setFormatCode("_(\"\"* #,##0_);_(\"\"* \(#,##0\);_(\"\"* \"-\"??_);_(@_)");
               
                    $sheet->setCellValue('A'.$cell, $no)
                            ->setCellValue('B'.$cell, $this->tanggalan->tgl_indo5($penjualan->tgl_simpan))
                            ->setCellValue('C'.$cell, '#'.$penjualan->no_rm)
                            ->setCellValue('D'.$cell, (!empty($dokter->nama_dpn) ? $dokter->nama_dpn.' ' : '').$dokter->nama.(!empty($dokter->nama_blk) ? ', '.$dokter->nama_blk : ''))
                            ->setCellValue('E'.$cell, $penjualan->item)
                            ->setCellValue('F'.$cell, $penjualan->nama_pgl)
                            ->setCellValue('G'.$cell, $penjualan->jml)
                            ->setCellValue('H'.$cell, $penjualan->harga)
                            ->setCellValue('I'.$cell, $remun)
                            ->setCellValue('J'.$cell, $penjualan->remun_subtotal);
                    
                    $no++;
                    $cell++;
                }

                $sell1 = $cell;
                
                $sheet->getStyle('J'.$cell)->getNumberFormat()->setFormatCode("_(\"\"* #,##0_);_(\"\"* \(#,##0\);_(\"\"* \"-\"??_);_(@_)");
                $sheet->getStyle('A'.$sell1.':J'.$sell1)->getFont()->setBold(TRUE);
                $sheet->getStyle('A'.$sell1.':J'.$sell1)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->setCellValue('A' . $sell1, 'TOTAL REMUNERASI');
                $sheet->mergeCells('A'.$sell1.':I'.$sell1);
                $sheet->setCellValue('J' . $sell1, $total);
            }

            // Rename worksheet
            $sheet->setTitle('LAP REMUNERASI');

            /** Page Setup * */
            $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);
            $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);

            /* -- Margin -- */
            $sheet->getPageMargins()->setTop(0.25);
            $sheet->getPageMargins()->setRight(0);
            $sheet->getPageMargins()->setLeft(0);
            $sheet->getPageMargins()->setFooter(0);

            /** Page Setup * */
            // Set document properties
            $spreadsheet->getProperties()->setCreator("Mikhael Felian Waskito")
                    ->setLastModifiedBy($this->ion_auth->user()->row()->username)
                    ->setTitle("Stok")
                    ->setSubject("Aplikasi Bengkel POS")
                    ->setDescription("Kunjungi http://tigerasoft.co.id")
                    ->setKeywords("Pasifik POS")
                    ->setCategory("Untuk mencetak nota dot matrix");

            ob_end_clean();
            // Redirect output to a client's web browser
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="data_remunerasi_'.(isset($_GET['filename']) ? $_GET['filename'] : 'lap').'.xls"');
            header('Cache-Control: max-age=0');

            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
            $writer->save('php://output');
            exit;
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function xls_data_apresiasi(){
        if (akses::aksesLogin() == TRUE) {
            $dokter     = $this->input->get('id_dokter');
            $jml        = $this->input->get('jml');
            $tgl        = $this->input->get('tgl');
            $tgl_awal   = $this->input->get('tgl_awal');
            $tgl_akhir  = $this->input->get('tgl_akhir');
            $case       = $this->input->get('case');
            $tipe       = $this->input->get('tipe');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $grup       = $this->ion_auth->get_users_groups()->row();
            $id_user    = $this->ion_auth->user()->row()->id;
            $id_grup    = $this->ion_auth->get_users_groups()->row();

            
                $sql_doc = $this->db->where('id_user', general::dekrip($dokter))->get('tbl_m_karyawan')->row();
                
                // Use the provided SQL query structure
                $this->db->select('tbl_trans_medcheck_apres.id AS id, 
                                  tbl_trans_medcheck_apres.id_dokter AS id_dokter, 
                                  tbl_trans_medcheck_apres.tgl_simpan AS tgl_simpan, 
                                  CONCAT(tbl_m_karyawan.nama_dpn, " ", tbl_m_karyawan.nama) AS dokter, 
                                  tbl_m_karyawan.nama_blk AS dokter_blk, 
                                  tbl_m_poli.lokasi AS poli, 
                                  tbl_trans_medcheck.no_rm AS no_rm, 
                                  tbl_m_pasien.nama_pgl AS nama_pgl, 
                                  tbl_trans_medcheck_det.item AS item, 
                                  tbl_trans_medcheck_det.jml AS jml, 
                                  tbl_trans_medcheck_apres.harga AS harga, 
                                  tbl_trans_medcheck_apres.apres_nom AS apres_nom, 
                                  tbl_trans_medcheck_apres.apres_subtotal AS apres_subtotal, 
                                  tbl_trans_medcheck_apres.apres_perc AS apres_perc, 
                                  tbl_trans_medcheck.tipe AS tipe, 
                                  tbl_m_produk.status AS status_produk')
                    ->from('tbl_trans_medcheck_apres')
                    ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id = tbl_trans_medcheck_apres.id_medcheck')
                    ->join('tbl_trans_medcheck_det', 'tbl_trans_medcheck_det.id = tbl_trans_medcheck_apres.id_medcheck_det')
                    ->join('tbl_m_pasien', 'tbl_m_pasien.id = tbl_trans_medcheck.id_pasien')
                    ->join('tbl_m_poli', 'tbl_m_poli.id = tbl_trans_medcheck.id_poli')
                    ->join('tbl_m_produk', 'tbl_m_produk.id = tbl_trans_medcheck_apres.id_item')
                    ->join('tbl_m_karyawan', 'tbl_m_karyawan.id_user = tbl_trans_medcheck_apres.id_dokter')
                    ->order_by('tbl_trans_medcheck_apres.id', 'desc');
                
                switch ($case){
                    case 'per_tanggal':
                        $this->db->where('DATE(tbl_trans_medcheck_apres.tgl_simpan)', $tgl);
                        if(!empty($tipe)) {
                            $this->db->like('tbl_m_produk.status', $tipe);
                        }
                        if(!empty($sql_doc->id_user)) {
                            $this->db->where('tbl_trans_medcheck_apres.id_dokter', $sql_doc->id_user);
                        }
                        $sql_apres = $this->db->get()->result();
                        break;
                    
                    case 'per_rentang':
                        $this->db->where('DATE(tbl_trans_medcheck_apres.tgl_simpan) >=', $tgl_awal)
                                 ->where('DATE(tbl_trans_medcheck_apres.tgl_simpan) <=', $tgl_akhir);
                        if(!empty($tipe)) {
                            $this->db->like('tbl_m_produk.status', $tipe);
                        }
                        if(!empty($sql_doc->id_user)) {
                            $this->db->where('tbl_trans_medcheck_apres.id_dokter', $sql_doc->id_user);
                        }
                        $sql_apres = $this->db->get()->result();
                        break;
                }

            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Header Tabel Nota
            $sheet->getStyle('A4:J4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A4:J4')->getFont()->setBold(TRUE);

            $sheet->setCellValue('A4', 'No.')
                    ->setCellValue('B4', 'Tgl')
                    ->setCellValue('C4', 'No. Faktur')
                    ->setCellValue('D4', 'Dokter')
                    ->setCellValue('E4', 'Tindakan')
                    ->setCellValue('F4', 'Pasien')
                    ->setCellValue('G4', 'Jml')
                    ->setCellValue('H4', 'Harga')
                    ->setCellValue('I4', 'Apresiasi')
                    ->setCellValue('J4', 'Subtotal');

            $sheet->getColumnDimension('A')->setWidth(6);
            $sheet->getColumnDimension('B')->setWidth(20);
            $sheet->getColumnDimension('C')->setWidth(20);
            $sheet->getColumnDimension('D')->setWidth(30);
            $sheet->getColumnDimension('E')->setWidth(50);
            $sheet->getColumnDimension('F')->setWidth(40);
            $sheet->getColumnDimension('G')->setWidth(6);
            $sheet->getColumnDimension('H')->setWidth(14);
            $sheet->getColumnDimension('I')->setWidth(14);
            $sheet->getColumnDimension('J')->setWidth(14);

            if(!empty($sql_apres)){
                $no    = 1;
                $cell  = 5;
                $total = 0;
                foreach ($sql_apres as $penjualan){
                    $dokter   = $this->db->where('id_user', $penjualan->id_dokter)->get('tbl_m_karyawan')->row();
                    $apres    = ($penjualan->apres_tipe == '2' ? $penjualan->apres_nom : (($penjualan->apres_perc / 100) * $penjualan->harga));
                    $total    = $total + $penjualan->apres_subtotal;

                    $sheet->getStyle('A'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('G'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('B'.$cell.':F'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                    $sheet->getStyle('H'.$cell.':J'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    $sheet->getStyle('H'.$cell.':J'.$cell)->getNumberFormat()->setFormatCode("_(\"\"* #,##0_);_(\"\"* \(#,##0\);_(\"\"* \"-\"??_);_(@_)");
               
                    $sheet->setCellValue('A'.$cell, $no)
                            ->setCellValue('B'.$cell, $this->tanggalan->tgl_indo5($penjualan->tgl_simpan))
                            ->setCellValue('C'.$cell, '#'.$penjualan->no_rm)
                            ->setCellValue('D'.$cell, (!empty($dokter->nama_dpn) ? $dokter->nama_dpn.' ' : '').$dokter->nama.(!empty($dokter->nama_blk) ? ', '.$dokter->nama_blk : ''))
                            ->setCellValue('E'.$cell, $penjualan->item)
                            ->setCellValue('F'.$cell, $penjualan->nama_pgl)
                            ->setCellValue('G'.$cell, $penjualan->jml)
                            ->setCellValue('H'.$cell, $penjualan->harga)
                            ->setCellValue('I'.$cell, $apres)
                            ->setCellValue('J'.$cell, $penjualan->apres_subtotal);
                    
                    $no++;
                    $cell++;
                }

                $sell1 = $cell;
                
                $sheet->getStyle('J'.$cell)->getNumberFormat()->setFormatCode("_(\"\"* #,##0_);_(\"\"* \(#,##0\);_(\"\"* \"-\"??_);_(@_)");
                $sheet->getStyle('A'.$sell1.':J'.$sell1)->getFont()->setBold(TRUE);
                $sheet->getStyle('A'.$sell1.':J'.$sell1)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->setCellValue('A' . $sell1, 'TOTAL APRESIASI');
                $sheet->mergeCells('A'.$sell1.':I'.$sell1);
                $sheet->setCellValue('J' . $sell1, $total);
            }

            // Rename worksheet
            $sheet->setTitle('LAP APRESIASI');

            /** Page Setup * */
            $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);
            $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);

            /* -- Margin -- */
            $sheet->getPageMargins()->setTop(0.25);
            $sheet->getPageMargins()->setRight(0);
            $sheet->getPageMargins()->setLeft(0);
            $sheet->getPageMargins()->setFooter(0);

            /** Page Setup * */
            // Set document properties
            $spreadsheet->getProperties()->setCreator("Mikhael Felian Waskito")
                    ->setLastModifiedBy($this->ion_auth->user()->row()->username)
                    ->setTitle("Stok")
                    ->setSubject("Aplikasi Bengkel POS")
                    ->setDescription("Kunjungi http://tigerasoft.co.id")
                    ->setKeywords("Pasifik POS")
                    ->setCategory("Untuk mencetak nota dot matrix");

            ob_end_clean();
            // Redirect output to a client's web browser
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="data_apresiasi_'.(isset($_GET['filename']) ? $_GET['filename'] : 'lap').'.xls"');
            header('Cache-Control: max-age=0');

            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
            $writer->save('php://output');
            exit;
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    

    public function xls_data_cuti(){
        if (akses::aksesLogin() == TRUE) {
            $jml        = $this->input->get('jml');
            $tgl        = $this->input->get('tgl');
            $tgl_awal   = $this->input->get('tgl_awal');
            $tgl_akhir  = $this->input->get('tgl_akhir');
            $kary       = $this->input->get('id_kary');
            $tipe       = $this->input->get('tipe');
            $status     = $this->input->get('status');
            $case       = $this->input->get('case');
            $hal        = $this->input->get('halaman');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $grup       = $this->ion_auth->get_users_groups()->row();
            $id_user    = $this->ion_auth->user()->row()->id;
            $id_grup    = $this->ion_auth->get_users_groups()->row();
            $sql_kary   = $this->db->where('id_user', general::dekrip($kary))->get('tbl_m_karyawan')->row();

            
            switch ($_GET['case']){
                case 'per_tanggal':
                    $sql = $this->db
                                    ->select('tbl_sdm_cuti.id, tbl_sdm_cuti.id_user, tbl_sdm_cuti.tgl_simpan, tbl_sdm_cuti.tgl_masuk, tbl_sdm_cuti.tgl_keluar, tbl_sdm_cuti.no_surat, tbl_sdm_cuti.keterangan, tbl_sdm_cuti.catatan, tbl_sdm_cuti.file_name, tbl_sdm_cuti.file_type, tbl_sdm_cuti.status, tbl_m_karyawan.nama_dpn, tbl_m_karyawan.nama, tbl_m_karyawan.nama_blk, tbl_m_karyawan.tgl_lahir, tbl_m_karyawan.alamat, tbl_m_karyawan.jns_klm, tbl_m_kategori_cuti.tipe')
                                    ->join('tbl_m_karyawan', 'tbl_m_karyawan.id=tbl_sdm_cuti.id_karyawan')
                                    ->join('tbl_m_kategori_cuti', 'tbl_m_kategori_cuti.id=tbl_sdm_cuti.id_kategori')
                                    ->where('tbl_sdm_cuti.id_kategori', $tipe)
                                    ->where('DATE(tbl_sdm_cuti.tgl_simpan)', $this->input->get('tgl'))
                                    ->like('tbl_sdm_cuti.status', $status, (!empty($status) ? 'none' : ''))
                                    ->like('tbl_m_karyawan.id', $sql_kary->id, (!empty($sql_kary->id) ? 'none' : ''))
                                    ->get('tbl_sdm_cuti')->result();
                    break;

                case 'per_rentang':
                    $sql = $this->db
                                    ->select('tbl_sdm_cuti.id, tbl_sdm_cuti.id_user, tbl_sdm_cuti.tgl_simpan, tbl_sdm_cuti.tgl_masuk, tbl_sdm_cuti.tgl_keluar, tbl_sdm_cuti.no_surat, tbl_sdm_cuti.keterangan, tbl_sdm_cuti.catatan, tbl_sdm_cuti.file_name, tbl_sdm_cuti.file_type, tbl_sdm_cuti.status, tbl_m_karyawan.nama_dpn, tbl_m_karyawan.nama, tbl_m_karyawan.nama_blk, tbl_m_karyawan.tgl_lahir, tbl_m_karyawan.alamat, tbl_m_karyawan.jns_klm, tbl_m_kategori_cuti.tipe')
                                    ->join('tbl_m_karyawan', 'tbl_m_karyawan.id=tbl_sdm_cuti.id_karyawan')
                                    ->join('tbl_m_kategori_cuti', 'tbl_m_kategori_cuti.id=tbl_sdm_cuti.id_kategori')
                                    ->where('tbl_sdm_cuti.id_kategori', $tipe)
                                    ->where('DATE(tbl_sdm_cuti.tgl_simpan) >=', $this->input->get('tgl_awal'))
                                    ->where('DATE(tbl_sdm_cuti.tgl_simpan) <=', $this->input->get('tgl_akhir'))
                                    ->like('tbl_sdm_cuti.status', $status, (!empty($status) ? 'none' : ''))
                                    ->like('tbl_m_karyawan.id', $sql_kary->id, (!empty($sql_kary->id) ? 'none' : ''))
                                    ->get('tbl_sdm_cuti')->result();
                    break;

                case 'per_bulan':
//                    $sql = $this->db->query("SELECT 
//	tbl_sdm_cuti.id, tbl_sdm_cuti.id_user, tbl_sdm_cuti.tgl_simpan, tbl_sdm_cuti.tgl_masuk, tbl_sdm_cuti.tgl_keluar, tbl_sdm_cuti.no_surat, tbl_sdm_cuti.keterangan, tbl_sdm_cuti.catatan, tbl_sdm_cuti.file_name, tbl_sdm_cuti.file_type, tbl_sdm_cuti.status, tbl_m_karyawan.nama_dpn, tbl_m_karyawan.nama, tbl_m_karyawan.nama_blk, tbl_m_karyawan.tgl_lahir, tbl_m_karyawan.alamat, tbl_m_karyawan.jns_klm, tbl_m_kategori_cuti.tipe
//FROM tbl_sdm_cuti 
//JOIN tbl_m_karyawan ON tbl_sdm_cuti.id_karyawan=tbl_m_karyawan.id
//LEFT JOIN tbl_m_kategori_cuti ON tbl_sdm_cuti.id_kategori=tbl_m_kategori_cuti.tipe
//WHERE MONTH(tbl_sdm_cuti.tgl_simpan)='".$this->input->get('bln')."';")->result();
                    
                    $sql = $this->db
                                    ->select('tbl_sdm_cuti.id, tbl_sdm_cuti.id_user, tbl_sdm_cuti.tgl_simpan, tbl_sdm_cuti.tgl_masuk, tbl_sdm_cuti.tgl_keluar, tbl_sdm_cuti.no_surat, tbl_sdm_cuti.keterangan, tbl_sdm_cuti.catatan, tbl_sdm_cuti.file_name, tbl_sdm_cuti.file_type, tbl_sdm_cuti.status, tbl_m_karyawan.nama_dpn, tbl_m_karyawan.nama, tbl_m_karyawan.nama_blk, tbl_m_karyawan.tgl_lahir, tbl_m_karyawan.alamat, tbl_m_karyawan.jns_klm, tbl_m_kategori_cuti.tipe')
                                    ->join('tbl_m_karyawan', 'tbl_m_karyawan.id=tbl_sdm_cuti.id_karyawan')
                                    ->join('tbl_m_kategori_cuti', 'tbl_m_kategori_cuti.id=tbl_sdm_cuti.id_kategori')
                                    ->where('tbl_sdm_cuti.id_kategori', $tipe)
                                    ->where('MONTH(tbl_sdm_cuti.tgl_simpan)', $this->input->get('bln'))
                                    ->like('tbl_sdm_cuti.status', $status, (!empty($status) ? 'none' : ''))
//                                    ->like('tbl_sdm_cuti.id_karyawan', $sql_kary->id, (!empty($kary) ? 'none' : ''))
                                    ->get('tbl_sdm_cuti')->result();
                    break;
            }

            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Header Tabel Nota
            $sheet->getStyle('A1:G1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A1:G1')->getFont()->setBold(TRUE);

            $sheet->setCellValue('A1', 'NO')
                    ->setCellValue('B1', 'NO SURAT')
                    ->setCellValue('C1', 'NAMA')
                    ->setCellValue('D1', 'ALASAN')
                    ->setCellValue('E1', 'WAKTU');

            $sheet->getColumnDimension('A')->setWidth(7);
            $sheet->getColumnDimension('B')->setWidth(18);
            $sheet->getColumnDimension('C')->setWidth(35);
            $sheet->getColumnDimension('D')->setWidth(80);
            $sheet->getColumnDimension('E')->setWidth(10);
            $sheet->getColumnDimension('F')->setWidth(80);
            $sheet->getColumnDimension('G')->setWidth(80);

            if(!empty($sql)){
                $no    = 1;
                $cell  = 2;
                $total = 0;
                foreach ($sql as $cuti){
                    $sheet->getStyle('A'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('B'.$cell.':D'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                    
                    $sheet->setCellValue('A'.$cell, $no)
                            ->setCellValue('B'.$cell, (!empty($cuti->no_surat) ? $cuti->no_surat : ''))
                            ->setCellValue('C'.$cell, (!empty($cuti->nama_dpn) ? $cuti->nama_dpn.' ' : '').$cuti->nama.(!empty($cuti->nama_blk) ? ', '.$cuti->nama_blk : ''))
                            ->setCellValue('D'.$cell, $cuti->keterangan)
                            ->setCellValue('E'.$cell, $this->tanggalan->jml_hari($cuti->tgl_masuk, $cuti->tgl_keluar).' Hari');

                    $no++;
                    $cell++;
                }

                $sell1 = $cell;
            }

            // Rename worksheet
            $sheet->setTitle('Lap Cuti');

            /** Page Setup * */
            $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);
            $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);

            /* -- Margin -- */
            $sheet->getPageMargins()->setTop(0.25);
            $sheet->getPageMargins()->setRight(0);
            $sheet->getPageMargins()->setLeft(0);
            $sheet->getPageMargins()->setFooter(0);

            /** Page Setup * */
            // Set document properties
            $spreadsheet->getProperties()->setCreator("Mikhael Felian Waskito")
                    ->setLastModifiedBy($this->ion_auth->user()->row()->username)
                    ->setTitle("Stok")
                    ->setSubject("Aplikasi Bengkel POS")
                    ->setDescription("Kunjungi http://tigerasoft.co.id")
                    ->setKeywords("Pasifik POS")
                    ->setCategory("Untuk mencetak nota dot matrix");

            ob_end_clean();
            // Redirect output to a client's web browser
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="data_rekap_cuti_'.(isset($_GET['filename']) ? $_GET['filename'] : 'lap').'.xls"');
            header('Cache-Control: max-age=0');

            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
            $writer->save('php://output');
            exit;
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function htm_data_omset(){
        if (akses::aksesLogin() == TRUE) {
            $jml        = $this->input->get('jml');
            $tgl        = $this->input->get('tgl');
            $tgl_awal   = $this->input->get('tgl_awal');
            $tgl_akhir  = $this->input->get('tgl_akhir');
            $case       = $this->input->get('case');
            $hal        = $this->input->get('halaman');
            $poli       = $this->input->get('poli');
            $tipe       = $this->input->get('tipe');
            $plat       = $this->input->get('plat');
            $pasien_id  = $this->input->get('id_pasien');
            $pasien     = $this->input->get('pasien');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $grup       = $this->ion_auth->get_users_groups()->row();
            $id_user    = $this->ion_auth->user()->row()->id;
            $id_grup    = $this->ion_auth->get_users_groups()->row();

            
            switch ($case) { 
                case 'per_tanggal':
                    $data['sql_omset'] = $this->db->select('tbl_trans_medcheck.id, tbl_trans_medcheck.tgl_simpan, tbl_trans_medcheck.tgl_masuk, tbl_trans_medcheck.no_akun, tbl_trans_medcheck.no_rm, tbl_trans_medcheck.pasien, tbl_trans_medcheck.no_nota, tbl_trans_medcheck.tipe, tbl_trans_medcheck.jml_gtotal, tbl_trans_medcheck.jml_bayar, tbl_trans_medcheck.jml_kembali, tbl_trans_medcheck.metode, tbl_trans_medcheck.status_bayar, tbl_trans_medcheck.tipe, tbl_m_pasien.nama_pgl, tbl_m_pasien.tgl_lahir, tbl_m_poli.lokasi, tbl_m_kategori.keterangan AS kategori, tbl_trans_medcheck_det.id AS id_medcheck_det, tbl_trans_medcheck_det.id_item, tbl_trans_medcheck_det.id_dokter, tbl_trans_medcheck_det.kode AS kode_item, tbl_trans_medcheck_det.item, tbl_trans_medcheck_det.resep, tbl_trans_medcheck_det.harga, tbl_trans_medcheck_det.jml, tbl_trans_medcheck_det.disk1, tbl_trans_medcheck_det.disk2, tbl_trans_medcheck_det.disk3, tbl_trans_medcheck_det.diskon, tbl_trans_medcheck_det.potongan, tbl_trans_medcheck_det.subtotal, tbl_trans_medcheck_det.resep, CONCAT(tbl_m_pasien.kode_dpn,\'\',tbl_m_pasien.kode) AS "kode_pasien"', false)
                                                              ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_det.id_medcheck')
                                                              ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
                                                              ->join('tbl_m_poli', 'tbl_m_poli.id=tbl_trans_medcheck.id_poli')
                                                              ->join('tbl_m_kategori', 'tbl_m_kategori.id=tbl_trans_medcheck_det.id_item_kat')
                                                              ->where('tbl_trans_medcheck.status_hps', '0')
                                                              ->where('tbl_trans_medcheck.status_bayar', '1')
                                                              ->where('DATE(tbl_trans_medcheck.tgl_bayar)', $tgl)
                                                              ->like('tbl_trans_medcheck.tipe', $tipe, (!empty($tipe) ? 'none' : ''))
                                                              ->like('tbl_trans_medcheck.metode', $plat, (!empty($plat) ? 'none' : ''))
                                                              ->like('tbl_trans_medcheck.id_poli', $poli, (!empty($poli) ? 'none' : ''))                                                              
                                                              ->like('tbl_trans_medcheck.pasien', $pasien)                                                              
                                                ->order_by('tbl_trans_medcheck.id', 'DESC')
                                                ->get('tbl_trans_medcheck_det')->result();
                        
                        $data['sql_omset_row'] = $this->db->select('SUM(tbl_trans_medcheck_det.jml * tbl_trans_medcheck_det.harga) AS jml_total, SUM(tbl_trans_medcheck_det.diskon) AS diskon, SUM(tbl_trans_medcheck_det.potongan) AS potongan, SUM(tbl_trans_medcheck_det.subtotal) AS jml_gtotal')
                                                              ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_det.id_medcheck')
                                                              ->where('tbl_trans_medcheck.status_hps', '0')
                                                              ->where('tbl_trans_medcheck.status_bayar', '1')
                                                              ->where('DATE(tbl_trans_medcheck.tgl_bayar)', $tgl)
                                                              ->like('tbl_trans_medcheck.tipe', $tipe, (!empty($tipe) ? 'none' : ''))
                                                              ->like('tbl_trans_medcheck.id_poli', $poli, (!empty($poli) ? 'none' : ''))
                                                              ->like('tbl_trans_medcheck.metode', $plat, (!empty($plat) ? 'none' : ''))
                                                              ->like('tbl_trans_medcheck.pasien', $pasien)
                                                        ->get('tbl_trans_medcheck_det')->row();
                    break;

                case 'per_rentang':
                        $data['sql_omset']    = $this->db->select('tbl_trans_medcheck.id, tbl_trans_medcheck.tgl_simpan, tbl_trans_medcheck.tgl_masuk, tbl_trans_medcheck.no_akun, tbl_trans_medcheck.no_rm, tbl_trans_medcheck.pasien, tbl_trans_medcheck.no_nota, tbl_trans_medcheck.tipe, tbl_trans_medcheck.jml_gtotal, tbl_trans_medcheck.jml_bayar, tbl_trans_medcheck.jml_kembali, tbl_trans_medcheck.metode, tbl_trans_medcheck.status_bayar, tbl_trans_medcheck.tipe, tbl_m_pasien.nama_pgl, tbl_m_pasien.tgl_lahir, tbl_m_poli.lokasi, tbl_m_kategori.keterangan AS kategori, tbl_trans_medcheck_det.id AS id_medcheck_det, tbl_trans_medcheck_det.id_item, tbl_trans_medcheck_det.id_dokter, tbl_trans_medcheck_det.kode AS kode_item, tbl_trans_medcheck_det.item, tbl_trans_medcheck_det.resep, tbl_trans_medcheck_det.harga, tbl_trans_medcheck_det.jml, tbl_trans_medcheck_det.disk1, tbl_trans_medcheck_det.disk2, tbl_trans_medcheck_det.disk3, tbl_trans_medcheck_det.diskon, tbl_trans_medcheck_det.potongan, tbl_trans_medcheck_det.subtotal, tbl_trans_medcheck_det.resep, CONCAT(tbl_m_pasien.kode_dpn,\'\',tbl_m_pasien.kode) AS "kode_pasien"', false)
                                                              ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_det.id_medcheck')
                                                              ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
                                                              ->join('tbl_m_poli', 'tbl_m_poli.id=tbl_trans_medcheck.id_poli')
                                                              ->join('tbl_m_kategori', 'tbl_m_kategori.id=tbl_trans_medcheck_det.id_item_kat')
                                                              ->where('tbl_trans_medcheck.status_hps', '0')
                                                              ->where('tbl_trans_medcheck.status_bayar', '1')
                                                              ->where('DATE(tbl_trans_medcheck.tgl_bayar) >=', $tgl_awal)
                                                              ->where('DATE(tbl_trans_medcheck.tgl_bayar) <=', $tgl_akhir)
                                                              ->like('tbl_trans_medcheck.tipe', $tipe, (!empty($tipe) ? 'none' : ''))
                                                              ->like('tbl_trans_medcheck.metode', $plat, (!empty($plat) ? 'none' : ''))
                                                              ->like('tbl_trans_medcheck.id_poli', $poli, (!empty($poli) ? 'none' : ''))
                                                              ->like('tbl_trans_medcheck.pasien', $pasien) 
                                                ->order_by('tbl_trans_medcheck.id', 'DESC')
                                                ->get('tbl_trans_medcheck_det')->result();
                        
                        $data['sql_omset_row'] = $this->db->select('SUM(tbl_trans_medcheck_det.jml * tbl_trans_medcheck_det.harga) AS jml_total, SUM(tbl_trans_medcheck_det.diskon) AS diskon, SUM(tbl_trans_medcheck_det.potongan) AS potongan, SUM(tbl_trans_medcheck_det.subtotal) AS jml_gtotal')
                                                              ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_det.id_medcheck')
                                                              ->where('tbl_trans_medcheck.status_hps', '0')
                                                              ->where('tbl_trans_medcheck.status_bayar', '1')
                                                              ->where('DATE(tbl_trans_medcheck.tgl_bayar) >=', $tgl_awal)
                                                              ->where('DATE(tbl_trans_medcheck.tgl_bayar) <=', $tgl_akhir)
                                                              ->like('tbl_trans_medcheck.tipe', $tipe, (!empty($tipe) ? 'none' : ''))
                                                              ->like('tbl_trans_medcheck.id_poli', $poli, (!empty($poli) ? 'none' : ''))
                                                              ->like('tbl_trans_medcheck.metode', $plat, (!empty($plat) ? 'none' : ''))
                                                              ->like('tbl_trans_medcheck.pasien', $pasien)
                                                        ->get('tbl_trans_medcheck_det')->row();
                    break;
            }
            
            /* Load view tampilan */
//            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/includes/laporan/data_omset_htm_zahir', $data);
//            $this->load->view('admin-lte-3/6_bawah', $data);

//            $objPHPExcel = new PHPExcel();
//
//            // Header Tabel Nota
//            $objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//            $objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(TRUE);
//
//            $objPHPExcel->setActiveSheetIndex(0)
//                    ->setCellValue('A4', 'No.')
//                    ->setCellValue('B4', 'Tgl')
//                    ->setCellValue('C4', 'Pasien')
//                    ->setCellValue('D4', 'Tipe')
//                    ->setCellValue('E4', 'Dokter')
//                    ->setCellValue('F4', 'No. Faktur')
//                    ->setCellValue('G4', 'Qty')
//                    ->setCellValue('H4', 'Kode')
//                    ->setCellValue('I4', 'Item')
//                    ->setCellValue('J4', 'Group')
//                    ->setCellValue('K4', 'Harga')
//                    ->setCellValue('L4', 'Subtotal')
//                    ->setCellValue('M4', 'Jasa Dokter')
//                    ->setCellValue('N4', 'Total Jasa');
//
//            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(6);
//            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
//            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(65);
//            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(14);
//            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(50);
//            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
//            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
//            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(14);
//            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(45);
//            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(35);
//            $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(14);
//            $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(14);
//            $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(14);
//            $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(14);
//
//            if(!empty($sql_omset)){
//                $no    = 1;
//                $cell  = 5;
//                $total = 0;
//                foreach ($sql_omset as $penjualan){
//                    $remun   = $this->db->where('id_medcheck_det', $penjualan->id_medcheck_det)->get('tbl_trans_medcheck_remun')->row();
//                    $dokter  = $this->db->where('id_user', $penjualan->id_dokter)->get('tbl_m_karyawan')->row();
//                    $item    = $this->db->where('id', $penjualan->id_item)->get('tbl_m_produk')->row();
//                    $remun_nom   = ($remun->remun_tipe == '2' ? $remun->remun_nom : (($remun->remun_perc / 100) * $penjualan->harga));
//                    $total   = $total + $penjualan->subtotal;
//                    $subtot  = $penjualan->harga * $penjualan->jml;
//
//                    $objPHPExcel->getActiveSheet()->getStyle('A'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//                    $objPHPExcel->getActiveSheet()->getStyle('B'.$cell.':J'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
//                    $objPHPExcel->getActiveSheet()->getStyle('K'.$cell.':N'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//                    $objPHPExcel->getActiveSheet()->getStyle('K'.$cell.':N'.$cell)->getNumberFormat()->setFormatCode("_(\"\"* #,##0_);_(\"\"* \(#,##0\);_(\"\"* \"-\"??_);_(@_)");
//                    $objPHPExcel->getActiveSheet()->getStyle('I'.$cell)->getAlignment()->setWrapText(true);
//
//                    $rsp = "\n";
//                    foreach (json_decode($penjualan->resep) as $resep){
//                        $rsp .= ' - '.$resep->item.' ['.$resep->jml.' '.$resep->satuan.']'."\n"; 
//                    }
//                    
//                    $objPHPExcel->setActiveSheetIndex(0)
//                            ->setCellValue('A'.$cell, $no)
//                            ->setCellValue('B'.$cell, $this->tanggalan->tgl_indo5($penjualan->tgl_simpan))
//                            ->setCellValue('C'.$cell, $penjualan->nama_pgl)
//                            ->setCellValue('D'.$cell, general::status_rawat2($penjualan->tipe))
//                            ->setCellValue('E'.$cell, $dokter->nama)
//                            ->setCellValue('F'.$cell, $penjualan->no_rm)
//                            ->setCellValue('G'.$cell, (float)$penjualan->jml)
//                            ->setCellValue('H'.$cell, $item->kode)
//                            ->setCellValue('I'.$cell, $penjualan->item.(!empty($penjualan->resep) ? $rsp : ''))
//                            ->setCellValue('J'.$cell, $penjualan->kategori)
//                            ->setCellValue('K'.$cell, $penjualan->harga)
//                            ->setCellValue('L'.$cell, $subtot)
//                            ->setCellValue('M'.$cell, $remun_nom)
//                            ->setCellValue('N'.$cell, $remun->remun_subtotal);
//
//                    $no++;
//                    $cell++;
//                }
//
//                $sell1     = $cell;
//                
//                $objPHPExcel->getActiveSheet()->getStyle('L'.$cell)->getNumberFormat()->setFormatCode("_(\"\"* #,##0_);_(\"\"* \(#,##0\);_(\"\"* \"-\"??_);_(@_)");
//                $objPHPExcel->getActiveSheet()->getStyle('A'.$sell1.':F'.$sell1.'')->getFont()->setBold(TRUE);
//                $objPHPExcel->getActiveSheet()->getStyle('A'.$sell1.':F'.$sell1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//                $objPHPExcel->setActiveSheetIndex(0)
//                        ->setCellValue('A' . $sell1, '')->mergeCells('A'.$sell1.':K'.$sell1.'')
//                        ->setCellValue('L' . $sell1, $sql_omset_row->jml_gtotal);
//            }
//
//            // Rename worksheet
//            $objPHPExcel->getActiveSheet()->setTitle('Lap Omset');
//
//            /** Page Setup * */
//            $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
//            $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
//
//            /* -- Margin -- */
//            $objPHPExcel->getActiveSheet()
//                    ->getPageMargins()->setTop(0.25);
//            $objPHPExcel->getActiveSheet()
//                    ->getPageMargins()->setRight(0);
//            $objPHPExcel->getActiveSheet()
//                    ->getPageMargins()->setLeft(0);
//            $objPHPExcel->getActiveSheet()
//                    ->getPageMargins()->setFooter(0);
//

//            /** Page Setup * */
//            // Set document properties
//            $objPHPExcel->getProperties()->setCreator("Mikhael Felian Waskito")
//                    ->setLastModifiedBy($this->ion_auth->user()->row()->username)
//                    ->setTitle("Stok")
//                    ->setSubject("Aplikasi Bengkel POS")
//                    ->setDescription("Kunjungi http://tigerasoft.co.id")
//                    ->setKeywords("Pasifik POS")
//                    ->setCategory("Untuk mencetak nota dot matrix");
//
//
//
//            // Redirect output to a client’s web browser (Excel5)
//            header('Content-Type: application/vnd.ms-excel');
//            // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//            header('Content-Disposition: attachment;filename="data_omset_'.(isset($_GET['filename']) ? $_GET['filename'] : 'lap').'.xls"');
//
//            // If you're serving to IE over SSL, then the following may be needed
//            header('Expires: Mon, 15 Feb 1992 05:00:00 GMT'); // Date in the past
//            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
//            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
//            header('Pragma: public'); // HTTP/1.0
//
//            ob_clean();
//            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
//            $objWriter->save('php://output');
//            exit;
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function htm_data_omset_jasa(){
        if (akses::aksesLogin() == TRUE) {
            $jml        = $this->input->get('jml');
            $tgl        = $this->input->get('tgl');
            $tgl_awal   = $this->input->get('tgl_awal');
            $tgl_akhir  = $this->input->get('tgl_akhir');
            $case       = $this->input->get('case');
            $hal        = $this->input->get('halaman');
            $poli       = $this->input->get('poli');
            $tipe       = $this->input->get('tipe');
            $plat       = $this->input->get('plat');
            $pasien_id  = $this->input->get('id_pasien');
            $pasien     = $this->input->get('pasien');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $grup       = $this->ion_auth->get_users_groups()->row();
            $id_user    = $this->ion_auth->user()->row()->id;
            $id_grup    = $this->ion_auth->get_users_groups()->row();

            
            switch ($case) {
                case 'per_tanggal':
                    $data['sql_omset'] = $this->db->select('tbl_trans_medcheck.id, tbl_trans_medcheck.tgl_simpan, tbl_trans_medcheck.tgl_masuk, tbl_trans_medcheck.no_akun, tbl_trans_medcheck.no_rm, tbl_trans_medcheck.pasien, tbl_trans_medcheck.no_nota, tbl_trans_medcheck.tipe, tbl_trans_medcheck.jml_gtotal, tbl_trans_medcheck.jml_bayar, tbl_trans_medcheck.jml_kembali, tbl_trans_medcheck.metode, tbl_trans_medcheck.status_bayar, tbl_trans_medcheck.tipe, tbl_m_pasien.nama_pgl, tbl_m_pasien.tgl_lahir, tbl_m_poli.lokasi, tbl_m_kategori.keterangan AS kategori, tbl_trans_medcheck_det.id AS id_medcheck_det, tbl_trans_medcheck_det.id_item, tbl_trans_medcheck_det.id_dokter, tbl_trans_medcheck_det.kode AS kode_item, tbl_trans_medcheck_det.item, tbl_trans_medcheck_det.resep, tbl_trans_medcheck_det.harga, tbl_trans_medcheck_det.jml, tbl_trans_medcheck_det.disk1, tbl_trans_medcheck_det.disk2, tbl_trans_medcheck_det.disk3, tbl_trans_medcheck_det.potongan, tbl_trans_medcheck_det.subtotal, tbl_trans_medcheck_det.resep, CONCAT(tbl_m_pasien.kode_dpn,\'\',tbl_m_pasien.kode) AS "kode_pasien"', false)
                                                              ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_det.id_medcheck')
                                                              ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
                                                              ->join('tbl_m_poli', 'tbl_m_poli.id=tbl_trans_medcheck.id_poli')
                                                              ->join('tbl_m_kategori', 'tbl_m_kategori.id=tbl_trans_medcheck_det.id_item_kat')
                                                              ->where('tbl_trans_medcheck.status_hps', '0')
                                                              ->where('tbl_trans_medcheck.status_bayar', '1')
                                                              ->where('tbl_trans_medcheck_det.status', '2')
                                                              ->where('DATE(tbl_trans_medcheck.tgl_bayar)', $tgl)
                                                              ->like('tbl_trans_medcheck.tipe', $tipe, (!empty($tipe) ? 'none' : ''))
                                                              ->like('tbl_trans_medcheck.metode', $plat, (!empty($plat) ? 'none' : ''))
                                                              ->like('tbl_trans_medcheck.tipe', $poli, (!empty($poli) ? 'none' : ''))                                                              
                                                              ->like('tbl_trans_medcheck.pasien', $pasien, (!empty($pasien) ? 'none' : ''))                                                              
                                                ->order_by('tbl_trans_medcheck.id', 'DESC')
                                                ->get('tbl_trans_medcheck_det')->result();
                    break;

                case 'per_rentang':
                        $data['sql_omset']    = $this->db->select('tbl_trans_medcheck.id, tbl_trans_medcheck.tgl_simpan, tbl_trans_medcheck.tgl_masuk, tbl_trans_medcheck.no_akun, tbl_trans_medcheck.no_rm, tbl_trans_medcheck.pasien, tbl_trans_medcheck.no_nota, tbl_trans_medcheck.tipe, tbl_trans_medcheck.jml_gtotal, tbl_trans_medcheck.jml_bayar, tbl_trans_medcheck.jml_kembali, tbl_trans_medcheck.metode, tbl_trans_medcheck.status_bayar, tbl_trans_medcheck.tipe, tbl_m_pasien.nama_pgl, tbl_m_pasien.tgl_lahir, tbl_m_poli.lokasi, tbl_m_kategori.keterangan AS kategori, tbl_trans_medcheck_det.id AS id_medcheck_det, tbl_trans_medcheck_det.id_item, tbl_trans_medcheck_det.id_dokter, tbl_trans_medcheck_det.kode AS kode_item, tbl_trans_medcheck_det.item, tbl_trans_medcheck_det.resep, tbl_trans_medcheck_det.harga, tbl_trans_medcheck_det.jml, tbl_trans_medcheck_det.disk1, tbl_trans_medcheck_det.disk2, tbl_trans_medcheck_det.disk3, tbl_trans_medcheck_det.potongan, tbl_trans_medcheck_det.subtotal, tbl_trans_medcheck_det.resep, CONCAT(tbl_m_pasien.kode_dpn,\'\',tbl_m_pasien.kode) AS "kode_pasien"', false)
                                                              ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_det.id_medcheck')
                                                              ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
                                                              ->join('tbl_m_poli', 'tbl_m_poli.id=tbl_trans_medcheck.id_poli')
                                                              ->join('tbl_m_kategori', 'tbl_m_kategori.id=tbl_trans_medcheck_det.id_item_kat')
                                                              ->where('tbl_trans_medcheck.status_hps', '0')
                                                              ->where('tbl_trans_medcheck.status_bayar', '1')
                                                              ->where('tbl_trans_medcheck_det.status', '2')
                                                              ->where('DATE(tbl_trans_medcheck.tgl_bayar) >=', $tgl_awal)
                                                              ->where('DATE(tbl_trans_medcheck.tgl_bayar) <=', $tgl_akhir)
                                                              ->like('tbl_trans_medcheck.tipe', $tipe, (!empty($tipe) ? 'none' : ''))
                                                              ->like('tbl_trans_medcheck.metode', $plat, (!empty($plat) ? 'none' : ''))
                                                              ->like('tbl_trans_medcheck.tipe', $poli, (!empty($poli) ? 'none' : ''))
                                                              ->like('tbl_trans_medcheck.pasien', $pasien, (!empty($pasien) ? 'none' : '')) 
                                                ->order_by('tbl_trans_medcheck.id', 'DESC')
                                                ->get('tbl_trans_medcheck_det')->result();
                    break;
            }
            
            /* Load view tampilan */
//            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/includes/laporan/data_omset_htm_jasa', $data);
//            $this->load->view('admin-lte-3/6_bawah', $data);

//            $objPHPExcel = new PHPExcel();
//
//            // Header Tabel Nota
//            $objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//            $objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(TRUE);
//
//            $objPHPExcel->setActiveSheetIndex(0)
//                    ->setCellValue('A4', 'No.')
//                    ->setCellValue('B4', 'Tgl')
//                    ->setCellValue('C4', 'Pasien')
//                    ->setCellValue('D4', 'Tipe')
//                    ->setCellValue('E4', 'Dokter')
//                    ->setCellValue('F4', 'No. Faktur')
//                    ->setCellValue('G4', 'Qty')
//                    ->setCellValue('H4', 'Kode')
//                    ->setCellValue('I4', 'Item')
//                    ->setCellValue('J4', 'Group')
//                    ->setCellValue('K4', 'Harga')
//                    ->setCellValue('L4', 'Subtotal')
//                    ->setCellValue('M4', 'Jasa Dokter')
//                    ->setCellValue('N4', 'Total Jasa');
//
//            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(6);
//            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
//            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(65);
//            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(14);
//            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(50);
//            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
//            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
//            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(14);
//            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(45);
//            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(35);
//            $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(14);
//            $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(14);
//            $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(14);
//            $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(14);
//
//            if(!empty($sql_omset)){
//                $no    = 1;
//                $cell  = 5;
//                $total = 0;
//                foreach ($sql_omset as $penjualan){
//                    $remun   = $this->db->where('id_medcheck_det', $penjualan->id_medcheck_det)->get('tbl_trans_medcheck_remun')->row();
//                    $dokter  = $this->db->where('id_user', $penjualan->id_dokter)->get('tbl_m_karyawan')->row();
//                    $item    = $this->db->where('id', $penjualan->id_item)->get('tbl_m_produk')->row();
//                    $remun_nom   = ($remun->remun_tipe == '2' ? $remun->remun_nom : (($remun->remun_perc / 100) * $penjualan->harga));
//                    $total   = $total + $penjualan->subtotal;
//                    $subtot  = $penjualan->harga * $penjualan->jml;
//
//                    $objPHPExcel->getActiveSheet()->getStyle('A'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//                    $objPHPExcel->getActiveSheet()->getStyle('B'.$cell.':J'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
//                    $objPHPExcel->getActiveSheet()->getStyle('K'.$cell.':N'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//                    $objPHPExcel->getActiveSheet()->getStyle('K'.$cell.':N'.$cell)->getNumberFormat()->setFormatCode("_(\"\"* #,##0_);_(\"\"* \(#,##0\);_(\"\"* \"-\"??_);_(@_)");
//                    $objPHPExcel->getActiveSheet()->getStyle('I'.$cell)->getAlignment()->setWrapText(true);
//
//                    $rsp = "\n";
//                    foreach (json_decode($penjualan->resep) as $resep){
//                        $rsp .= ' - '.$resep->item.' ['.$resep->jml.' '.$resep->satuan.']'."\n"; 
//                    }
//                    
//                    $objPHPExcel->setActiveSheetIndex(0)
//                            ->setCellValue('A'.$cell, $no)
//                            ->setCellValue('B'.$cell, $this->tanggalan->tgl_indo5($penjualan->tgl_simpan))
//                            ->setCellValue('C'.$cell, $penjualan->nama_pgl)
//                            ->setCellValue('D'.$cell, general::status_rawat2($penjualan->tipe))
//                            ->setCellValue('E'.$cell, $dokter->nama)
//                            ->setCellValue('F'.$cell, $penjualan->no_rm)
//                            ->setCellValue('G'.$cell, (float)$penjualan->jml)
//                            ->setCellValue('H'.$cell, $item->kode)
//                            ->setCellValue('I'.$cell, $penjualan->item.(!empty($penjualan->resep) ? $rsp : ''))
//                            ->setCellValue('J'.$cell, $penjualan->kategori)
//                            ->setCellValue('K'.$cell, $penjualan->harga)
//                            ->setCellValue('L'.$cell, $subtot)
//                            ->setCellValue('M'.$cell, $remun_nom)
//                            ->setCellValue('N'.$cell, $remun->remun_subtotal);
//
//                    $no++;
//                    $cell++;
//                }
//
//                $sell1     = $cell;
//                
//                $objPHPExcel->getActiveSheet()->getStyle('L'.$cell)->getNumberFormat()->setFormatCode("_(\"\"* #,##0_);_(\"\"* \(#,##0\);_(\"\"* \"-\"??_);_(@_)");
//                $objPHPExcel->getActiveSheet()->getStyle('A'.$sell1.':F'.$sell1.'')->getFont()->setBold(TRUE);
//                $objPHPExcel->getActiveSheet()->getStyle('A'.$sell1.':F'.$sell1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//                $objPHPExcel->setActiveSheetIndex(0)
//                        ->setCellValue('A' . $sell1, '')->mergeCells('A'.$sell1.':K'.$sell1.'')
//                        ->setCellValue('L' . $sell1, $sql_omset_row->jml_gtotal);
//            }
//
//            // Rename worksheet
//            $objPHPExcel->getActiveSheet()->setTitle('Lap Omset');
//
//            /** Page Setup * */
//            $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
//            $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
//
//            /* -- Margin -- */
//            $objPHPExcel->getActiveSheet()
//                    ->getPageMargins()->setTop(0.25);
//            $objPHPExcel->getActiveSheet()
//                    ->getPageMargins()->setRight(0);
//            $objPHPExcel->getActiveSheet()
//                    ->getPageMargins()->setLeft(0);
//            $objPHPExcel->getActiveSheet()
//                    ->getPageMargins()->setFooter(0);
//

//            /** Page Setup * */
//            // Set document properties
//            $objPHPExcel->getProperties()->setCreator("Mikhael Felian Waskito")
//                    ->setLastModifiedBy($this->ion_auth->user()->row()->username)
//                    ->setTitle("Stok")
//                    ->setSubject("Aplikasi Bengkel POS")
//                    ->setDescription("Kunjungi http://tigerasoft.co.id")
//                    ->setKeywords("Pasifik POS")
//                    ->setCategory("Untuk mencetak nota dot matrix");
//
//
//
//            // Redirect output to a client’s web browser (Excel5)
//            header('Content-Type: application/vnd.ms-excel');
//            // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//            header('Content-Disposition: attachment;filename="data_omset_'.(isset($_GET['filename']) ? $_GET['filename'] : 'lap').'.xls"');
//
//            // If you're serving to IE over SSL, then the following may be needed
//            header('Expires: Mon, 15 Feb 1992 05:00:00 GMT'); // Date in the past
//            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
//            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
//            header('Pragma: public'); // HTTP/1.0
//
//            ob_clean();
//            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
//            $objWriter->save('php://output');
//            exit;
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function htm_data_omset_dokter(){
        if (akses::aksesLogin() == TRUE) {
            $jml        = $this->input->get('jml');
            $tgl        = $this->input->get('tgl');
            $tgl_awal   = $this->input->get('tgl_awal');
            $tgl_akhir  = $this->input->get('tgl_akhir');
            $case       = $this->input->get('case');
            $hal        = $this->input->get('halaman');
            $poli       = $this->input->get('poli');
            $tipe       = $this->input->get('tipe');
            $plat       = $this->input->get('plat');
            $dokter     = $this->input->get('dokter');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $grup       = $this->ion_auth->get_users_groups()->row();
            $id_user    = $this->ion_auth->user()->row()->id;
            $id_grup    = $this->ion_auth->get_users_groups()->row();

            
            switch ($case) {
                case 'per_tanggal':
                    $data['sql_omset'] = $this->db->select('tbl_trans_medcheck.id, tbl_trans_medcheck.tgl_simpan, tbl_trans_medcheck.tgl_masuk, tbl_trans_medcheck.no_akun, tbl_trans_medcheck.no_rm, tbl_trans_medcheck.pasien, tbl_trans_medcheck.no_nota, tbl_trans_medcheck.tipe, tbl_trans_medcheck.jml_gtotal, tbl_trans_medcheck.jml_bayar, tbl_trans_medcheck.jml_kembali, tbl_trans_medcheck.metode, tbl_trans_medcheck.status_bayar, tbl_trans_medcheck.tipe, tbl_m_pasien.nama_pgl, tbl_m_pasien.tgl_lahir, tbl_m_poli.lokasi, tbl_m_kategori.keterangan AS kategori, tbl_trans_medcheck_det.id AS id_medcheck_det, tbl_trans_medcheck_det.id_item, tbl_trans_medcheck_det.id_dokter, tbl_trans_medcheck_det.kode AS kode_item, tbl_trans_medcheck_det.item, tbl_trans_medcheck_det.resep, tbl_trans_medcheck_det.harga, tbl_trans_medcheck_det.jml, tbl_trans_medcheck_det.disk1, tbl_trans_medcheck_det.disk2, tbl_trans_medcheck_det.disk3, tbl_trans_medcheck_det.potongan, tbl_trans_medcheck_det.subtotal, tbl_trans_medcheck_det.resep, CONCAT(tbl_m_pasien.kode_dpn,\'\',tbl_m_pasien.kode) AS "kode_pasien"', false)
                                                              ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_det.id_medcheck')
                                                              ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
                                                              ->join('tbl_m_poli', 'tbl_m_poli.id=tbl_trans_medcheck.id_poli')
                                                              ->join('tbl_m_kategori', 'tbl_m_kategori.id=tbl_trans_medcheck_det.id_item_kat')
                                                              ->where('tbl_trans_medcheck.status_hps', '0')
                                                              ->where('tbl_trans_medcheck.status_bayar', '1')
                                                              ->where('tbl_trans_medcheck_det.status', '2')
                                                              ->where('DATE(tbl_trans_medcheck.tgl_bayar)', $tgl)
                                                              ->where('tbl_trans_medcheck_det.id_dokter', general::dekrip($dokter))                                                              
                                                ->order_by('tbl_trans_medcheck.id', 'DESC')
                                                ->get('tbl_trans_medcheck_det')->result();
                    break;

                case 'per_rentang':
                        $data['sql_omset'] = $this->db->select('tbl_trans_medcheck.id, tbl_trans_medcheck.tgl_simpan, tbl_trans_medcheck.tgl_masuk, tbl_trans_medcheck.no_akun, tbl_trans_medcheck.no_rm, tbl_trans_medcheck.pasien, tbl_trans_medcheck.no_nota, tbl_trans_medcheck.tipe, tbl_trans_medcheck.jml_gtotal, tbl_trans_medcheck.jml_bayar, tbl_trans_medcheck.jml_kembali, tbl_trans_medcheck.metode, tbl_trans_medcheck.status_bayar, tbl_trans_medcheck.tipe, tbl_m_pasien.nama_pgl, tbl_m_pasien.tgl_lahir, tbl_m_poli.lokasi, tbl_m_kategori.keterangan AS kategori, tbl_trans_medcheck_det.id AS id_medcheck_det, tbl_trans_medcheck_det.id_item, tbl_trans_medcheck_det.id_dokter, tbl_trans_medcheck_det.kode AS kode_item, tbl_trans_medcheck_det.item, tbl_trans_medcheck_det.resep, tbl_trans_medcheck_det.harga, tbl_trans_medcheck_det.jml, tbl_trans_medcheck_det.disk1, tbl_trans_medcheck_det.disk2, tbl_trans_medcheck_det.disk3, tbl_trans_medcheck_det.potongan, tbl_trans_medcheck_det.subtotal, tbl_trans_medcheck_det.resep, CONCAT(tbl_m_pasien.kode_dpn,\'\',tbl_m_pasien.kode) AS "kode_pasien"', false)
                                                              ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_det.id_medcheck')
                                                              ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
                                                              ->join('tbl_m_poli', 'tbl_m_poli.id=tbl_trans_medcheck.id_poli')
                                                              ->join('tbl_m_kategori', 'tbl_m_kategori.id=tbl_trans_medcheck_det.id_item_kat')
                                                              ->where('tbl_trans_medcheck.status_hps', '0')
                                                              ->where('tbl_trans_medcheck.status_bayar', '1')
                                                              ->where('tbl_trans_medcheck_det.status', '2')
                                                              ->where('DATE(tbl_trans_medcheck.tgl_bayar) >=', $tgl_awal)
                                                              ->where('DATE(tbl_trans_medcheck.tgl_bayar) <=', $tgl_akhir)
                                                              ->like('tbl_trans_medcheck.tipe', $tipe, (!empty($tipe) ? 'none' : ''))
                                                              ->like('tbl_trans_medcheck.metode', $plat, (!empty($plat) ? 'none' : ''))
                                                              ->like('tbl_trans_medcheck.tipe', $poli, (!empty($poli) ? 'none' : ''))
                                                              ->where('tbl_trans_medcheck_det.id_dokter', general::dekrip($dokter))
                                                ->order_by('tbl_trans_medcheck.id', 'DESC')
                                                ->get('tbl_trans_medcheck_det')->result();
                    break;
            }
            
            $this->load->view('admin-lte-3/includes/laporan/data_omset_htm_dokter', $data);
        } else {
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
               
    public function htm_data_omset_global(){
        if (akses::aksesLogin() == TRUE) {
            $jml        = $this->input->get('jml');
            $tgl        = $this->input->get('tgl');
            $tgl_awal   = $this->input->get('tgl_awal');
            $tgl_akhir  = $this->input->get('tgl_akhir');
            $poli       = $this->input->get('poli');
            $tipe       = $this->input->get('tipe');
            $plat       = $this->input->get('plat');
            $case       = $this->input->get('case');
            $hal        = $this->input->get('halaman');
            $pasien     = $this->input->get('pasien'); // Added missing variable
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $grup       = $this->ion_auth->get_users_groups()->row();
            $id_user    = $this->ion_auth->user()->row()->id;
            $id_grup    = $this->ion_auth->get_users_groups()->row();

            
            switch ($case) {
                case 'per_tanggal':
                    $data['sql_omset'] = $this->db->select('tbl_trans_medcheck.id, tbl_trans_medcheck.tgl_simpan, tbl_trans_medcheck.no_rm, tbl_trans_medcheck.no_nota, tbl_trans_medcheck.tipe, tbl_trans_medcheck.jml_gtotal, tbl_trans_medcheck.jml_bayar, tbl_trans_medcheck.jml_kembali, tbl_trans_medcheck.status_bayar, tbl_trans_medcheck.tipe, tbl_m_pasien.nama_pgl, tbl_m_pasien.tgl_lahir, tbl_m_poli.lokasi, tbl_m_kategori.keterangan AS kategori, tbl_trans_medcheck_det.id AS id_medcheck_det, tbl_trans_medcheck_det.id_item, tbl_trans_medcheck_det.id_dokter, tbl_trans_medcheck_det.harga, tbl_trans_medcheck_det.jml, tbl_trans_medcheck_det.disk1, tbl_trans_medcheck_det.disk2, tbl_trans_medcheck_det.disk3, tbl_trans_medcheck_det.potongan, tbl_trans_medcheck_det.kode, tbl_trans_medcheck_det.item, tbl_trans_medcheck_det.subtotal, tbl_trans_medcheck_det.resep')
                                                              ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_det.id_medcheck')
                                                              ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
                                                              ->join('tbl_m_poli', 'tbl_m_poli.id=tbl_trans_medcheck.id_poli')
                                                              ->join('tbl_m_kategori', 'tbl_m_kategori.id=tbl_trans_medcheck_det.id_item_kat')
                                                              ->where('tbl_trans_medcheck.status_hps', '0')
                                                              ->where('tbl_trans_medcheck.status_bayar', '1')
                                                              ->where('DATE(tbl_trans_medcheck.tgl_bayar)', $tgl)
                                                              ->like('tbl_trans_medcheck.tipe', $tipe, (!empty($tipe) ? 'none' : ''))
                                                              ->like('tbl_trans_medcheck.metode', $plat, (!empty($plat) ? 'none' : ''))
                                                              ->like('tbl_trans_medcheck.id_poli', $poli, (!empty($poli) ? 'none' : ''))
                                                ->order_by('tbl_trans_medcheck.id', 'DESC')
                                                ->get('tbl_trans_medcheck_det')->result();
                        
                        $data['sql_omset_row'] = $this->db->select('SUM(tbl_trans_medcheck_det.jml * tbl_trans_medcheck_det.harga) AS jml_total, SUM(tbl_trans_medcheck_det.diskon) AS diskon, SUM(tbl_trans_medcheck_det.potongan) AS potongan, SUM(tbl_trans_medcheck_det.subtotal) AS jml_gtotal')
                                                              ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_det.id_medcheck')
                                                              ->where('tbl_trans_medcheck.status_hps', '0')
                                                              ->where('tbl_trans_medcheck.status_bayar', '1')
                                                              ->where('DATE(tbl_trans_medcheck.tgl_bayar)', $tgl)
                                                              ->like('tbl_trans_medcheck.tipe', $tipe, (!empty($tipe) ? 'none' : ''))
                                                              ->like('tbl_trans_medcheck.id_poli', $poli, (!empty($poli) ? 'none' : ''))
                                                              ->like('tbl_trans_medcheck.metode', $plat, (!empty($plat) ? 'none' : ''))
                                                              ->like('tbl_trans_medcheck.pasien', $pasien, (!empty($pasien) ? 'none' : ''))
                                                        ->get('tbl_trans_medcheck_det')->row();
                    break;

                case 'per_rentang':
                        $data['sql_omset']     = $this->db->select('tbl_trans_medcheck.id, tbl_trans_medcheck.tgl_simpan, tbl_trans_medcheck.no_rm, tbl_trans_medcheck.no_nota, tbl_trans_medcheck.tipe, tbl_trans_medcheck.jml_gtotal, tbl_trans_medcheck.jml_bayar, tbl_trans_medcheck.jml_kembali, tbl_trans_medcheck.status_bayar, tbl_trans_medcheck.tipe, tbl_m_pasien.nama_pgl, tbl_m_pasien.tgl_lahir, tbl_m_poli.lokasi, tbl_m_kategori.keterangan AS kategori, tbl_trans_medcheck_det.id AS id_medcheck_det, tbl_trans_medcheck_det.id_item, tbl_trans_medcheck_det.id_dokter, tbl_trans_medcheck_det.harga, tbl_trans_medcheck_det.jml, tbl_trans_medcheck_det.disk1, tbl_trans_medcheck_det.disk2, tbl_trans_medcheck_det.disk3, tbl_trans_medcheck_det.potongan, tbl_trans_medcheck_det.kode, tbl_trans_medcheck_det.item, tbl_trans_medcheck_det.subtotal, tbl_trans_medcheck_det.resep')
                                                              ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_det.id_medcheck')
                                                              ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
                                                              ->join('tbl_m_poli', 'tbl_m_poli.id=tbl_trans_medcheck.id_poli')
                                                              ->join('tbl_m_kategori', 'tbl_m_kategori.id=tbl_trans_medcheck_det.id_item_kat')
                                                              ->where('tbl_trans_medcheck.status_hps', '0')
                                                              ->where('tbl_trans_medcheck.status_bayar', '1')
                                                              ->where('DATE(tbl_trans_medcheck.tgl_bayar) >=', $tgl_awal)
                                                              ->where('DATE(tbl_trans_medcheck.tgl_bayar) <=', $tgl_akhir) // Fixed: changed tgl_masuk to tgl_bayar
                                                              ->like('tbl_trans_medcheck.tipe', $tipe, (!empty($tipe) ? 'none' : ''))
                                                              ->like('tbl_trans_medcheck.metode', $plat, (!empty($plat) ? 'none' : ''))
                                                              ->like('tbl_trans_medcheck.id_poli', $poli, (!empty($poli) ? 'none' : ''))
                                                ->order_by('tbl_trans_medcheck.id', 'DESC')
                                                ->get('tbl_trans_medcheck_det')->result();
                    
                        
                        $data['sql_omset_row'] = $this->db->select('SUM(tbl_trans_medcheck_det.jml * tbl_trans_medcheck_det.harga) AS jml_total, SUM(tbl_trans_medcheck_det.diskon) AS diskon, SUM(tbl_trans_medcheck_det.potongan) AS potongan, SUM(tbl_trans_medcheck_det.subtotal) AS jml_gtotal')
                                                              ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_det.id_medcheck')
                                                              ->where('tbl_trans_medcheck.status_hps', '0')
                                                              ->where('tbl_trans_medcheck.status_bayar', '1')
                                                              ->where('DATE(tbl_trans_medcheck.tgl_bayar) >=', $tgl_awal)
                                                              ->where('DATE(tbl_trans_medcheck.tgl_bayar) <=', $tgl_akhir)
                                                              ->like('tbl_trans_medcheck.tipe', $tipe, (!empty($tipe) ? 'none' : ''))
                                                              ->like('tbl_trans_medcheck.id_poli', $poli, (!empty($poli) ? 'none' : ''))
                                                              ->like('tbl_trans_medcheck.metode', $plat, (!empty($plat) ? 'none' : ''))
                                                              ->like('tbl_trans_medcheck.pasien', $pasien, (!empty($pasien) ? 'none' : ''))
                                                        ->get('tbl_trans_medcheck_det')->row();
                    break;
            }
            
            /* Load view tampilan */
            $this->load->view('admin-lte-3/includes/laporan/data_omset_htm', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
               
    public function htm_data_pembelian() {
        if (akses::aksesLogin() == TRUE) {
            $jml        = $this->input->get('jml');
            $tgl        = $this->input->get('tgl');
            $tgl_awal   = $this->input->get('tgl_awal');
            $tgl_akhir  = $this->input->get('tgl_akhir');
            $plat       = $this->input->get('plat');
            $case       = $this->input->get('case');
            $hal        = $this->input->get('halaman');
            $supplier   = $this->input->get('supplier');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $grup       = $this->ion_auth->get_users_groups()->row();
            $id_user    = $this->ion_auth->user()->row()->id;
            $id_grup    = $this->ion_auth->get_users_groups()->row();
            
            $sql_supp = !empty($supplier) ? $this->db->where('id', general::dekrip($supplier))->get('tbl_m_supplier')->row() : null;
            $supplier_name = !empty($sql_supp) ? $sql_supp->nama : '';

            switch ($case) {
                case 'per_tanggal':
                        $data['sql_pembelian'] = $this->db->select('tbl_trans_beli.id, tbl_trans_beli.tgl_masuk, tbl_trans_beli.no_nota, tbl_trans_beli.jml_dpp, tbl_trans_beli.ppn, tbl_trans_beli.jml_ppn, tbl_trans_beli.jml_diskon, tbl_trans_beli.jml_gtotal, tbl_m_supplier.nama')
                                        ->join('tbl_m_supplier', 'tbl_m_supplier.id=tbl_trans_beli.id_supplier')
                                        ->where('DATE(tbl_trans_beli.tgl_masuk)', $this->tanggalan->tgl_indo_sys($tgl))
                                        ->like('tbl_m_supplier.nama', $supplier_name)
                                        ->get('tbl_trans_beli')->result();
                    break;

                case 'per_rentang':
                        $data['sql_pembelian'] = $this->db->select('tbl_trans_beli.id, tbl_trans_beli.tgl_masuk, tbl_trans_beli.no_nota, tbl_trans_beli.jml_dpp, tbl_trans_beli.ppn, tbl_trans_beli.jml_ppn, tbl_trans_beli.jml_diskon, tbl_trans_beli.jml_gtotal, tbl_m_supplier.nama')
                                        ->join('tbl_m_supplier', 'tbl_m_supplier.id=tbl_trans_beli.id_supplier')
                                        ->where('DATE(tbl_trans_beli.tgl_masuk) >=', $this->tanggalan->tgl_indo_sys($tgl_awal))
                                        ->where('DATE(tbl_trans_beli.tgl_masuk) <=', $this->tanggalan->tgl_indo_sys($tgl_akhir))
                                        ->like('tbl_m_supplier.nama', $supplier_name)
                                        ->get('tbl_trans_beli')->result();
                    break;
            }

            /* Load view tampilan */
            $this->load->view('admin-lte-3/includes/laporan/data_pembelian_htm', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    

    
    public function htm_data_mcu(){
        if (akses::aksesLogin() == TRUE) {
            $dokter             = $this->input->get('id_dokter');
            $inst               = $this->input->get('id_instansi');
            $jml                = $this->input->get('jml');
            $tgl                = $this->input->get('tgl');
            $tgl_awal           = $this->input->get('tgl_awal');
            $tgl_akhir          = $this->input->get('tgl_akhir');
            $case               = $this->input->get('case');
            $hal                = $this->input->get('halaman');
            $pengaturan         = $this->db->get('tbl_pengaturan')->row();
            
            switch ($case) {
                case 'per_tanggal':
                            $data['sql_mcu'] = $this->db->select('tbl_m_pasien.id AS id_pasien, tbl_m_pasien.nama_pgl, tbl_trans_medcheck_resume.id, tbl_trans_medcheck_resume.id_medcheck, tbl_trans_medcheck_resume.id_user, tbl_trans_medcheck_resume.no_surat, tbl_trans_medcheck_resume.saran, tbl_trans_medcheck_resume.kesimpulan')
                                                        ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_resume.id_medcheck')
                                                        ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
                                                        ->where('tbl_trans_medcheck.tipe', '5')
                                                        ->where('DATE(tbl_trans_medcheck_resume.tgl_simpan)', $this->tanggalan->tgl_indo_sys($tgl))
//                                                         ->limit($config['per_page'])                          
                                                        ->get('tbl_trans_medcheck_resume')->result();

                    $data['sql_mcu_cek_hdr']    = $this->db->select('tbl_trans_medcheck_resume_det.id_resume, tbl_trans_medcheck_resume_det.param, COUNT(tbl_trans_medcheck_resume_det.id_resume)')
                                                        ->join('tbl_trans_medcheck_resume', 'tbl_trans_medcheck_resume.id=tbl_trans_medcheck_resume_det.id_resume')
                                                        ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_resume_det.id_medcheck')
                                                        ->where('tbl_trans_medcheck.tipe', '5')
                                                        ->where('DATE(tbl_trans_medcheck_resume.tgl_simpan)', $this->tanggalan->tgl_indo_sys($tgl))
                                                        ->order_by('tbl_trans_medcheck_resume_det.id', 'DESC')
                                                        ->get('tbl_trans_medcheck_resume_det')->row();

                    $data['sql_mcu_hdr']        = $this->db->select('tbl_trans_medcheck_resume_det.id, tbl_trans_medcheck_resume_det.id_resume, tbl_trans_medcheck_resume_det.id_medcheck, tbl_trans_medcheck_resume_det.param')
                                                    ->where('id_resume', $data['sql_mcu_cek_hdr']->id_resume)
                                                    ->get('tbl_trans_medcheck_resume_det');
                    break;

                case 'per_rentang':
//                            $data['sql_mcu'] =  $this->db->select('tbl_m_pasien.id AS id_pasien, tbl_m_pasien.nama_pgl, tbl_trans_medcheck_resume.id, tbl_trans_medcheck_resume.id_medcheck, tbl_trans_medcheck_resume.id_user, tbl_trans_medcheck_resume.no_surat, tbl_trans_medcheck_resume.saran, tbl_trans_medcheck_resume.kesimpulan')
//                                                         ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_resume.id_medcheck')
//                                                         ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
//                                                         ->where('tbl_trans_medcheck.tipe', '5')
//                                                         ->where('DATE(tbl_trans_medcheck_resume.tgl_simpan) >=', $this->tanggalan->tgl_indo_sys($tgl_awal))
//                                                         ->where('DATE(tbl_trans_medcheck_resume.tgl_simpan) <=', $this->tanggalan->tgl_indo_sys($tgl_akhir))
////                                                         ->limit($config['per_page'])                          
//                                                         ->get('tbl_trans_medcheck_resume')->result();
                    $data['sql_mcu']    = $this->db
                                               ->where('DATE(tgl_simpan) >=', $this->tanggalan->tgl_indo_sys($tgl_awal))
                                               ->where('DATE(tgl_simpan) <=', $this->tanggalan->tgl_indo_sys($tgl_akhir))
                                               ->like('id_instansi', $inst, (!empty($inst) ? 'none' : ''))
                                               ->get('v_medcheck_mcu')->result();
                            
                            $data['sql_mcu_cek_hdr'] =  $this->db->select('tbl_trans_medcheck_resume_det.id_resume, tbl_trans_medcheck_resume_det.param, COUNT(tbl_trans_medcheck_resume_det.id_resume)')
                                                                ->join('tbl_trans_medcheck_resume', 'tbl_trans_medcheck_resume.id=tbl_trans_medcheck_resume_det.id_resume')
                                                                ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_resume_det.id_medcheck')
                                                                ->where('tbl_trans_medcheck.tipe', '5')
                                                                ->where('DATE(tbl_trans_medcheck_resume.tgl_simpan) >=', $this->tanggalan->tgl_indo_sys($tgl_awal))
                                                                ->where('DATE(tbl_trans_medcheck_resume.tgl_simpan) <=', $this->tanggalan->tgl_indo_sys($tgl_akhir))
                                                                ->order_by('tbl_trans_medcheck_resume_det.id', 'DESC')
//                                                         ->where('id_resume', '1482')
                                                         ->get('tbl_trans_medcheck_resume_det')->row();
                            
                            $data['sql_mcu_hdr'] =  $this->db->select('tbl_trans_medcheck_resume_det.id, tbl_trans_medcheck_resume_det.id_resume, tbl_trans_medcheck_resume_det.id_medcheck, tbl_trans_medcheck_resume_det.param')
                                                         ->where('id_resume',  $data['sql_mcu_cek_hdr']->id_resume)
                                                         ->get('tbl_trans_medcheck_resume_det');
                    break;
            }


            /* Load view tampilan */
            /* Load view tampilan */
            $this->load->view('admin-lte-3/includes/laporan/data_mcu_htm', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function xls_data_icd(){
        if (akses::aksesLogin() == TRUE) {
            $jml        = $this->input->get('jml');
            $tgl        = $this->input->get('tgl');
            $tgl_awal   = $this->input->get('tgl_awal');
            $tgl_akhir  = $this->input->get('tgl_akhir');
            $case       = $this->input->get('case');
            $hal        = $this->input->get('halaman');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $grup       = $this->ion_auth->get_users_groups()->row();
            $id_user    = $this->ion_auth->user()->row()->id;
            $id_grup    = $this->ion_auth->get_users_groups()->row();

            
            switch ($case) {
                case 'per_tanggal':
                    $sql_omset = $this->db->query(""
                                . "SELECT "
                                . "id, kode, icd, diagnosa_en, COUNT(icd) AS jml "
                                . "FROM tbl_trans_medcheck_icd "
                                . "WHERE DATE(tbl_trans_medcheck_icd.tgl_simpan) = '".$this->tanggalan->tgl_indo_sys($tgl)."' "
                                . "GROUP BY tbl_trans_medcheck_icd.id_icd HAVING  COUNT(id_icd) > 1 "
                                . "ORDER BY COUNT(tbl_trans_medcheck_icd.icd) DESC;"
                                . "")->result();
                    break;

                case 'per_rentang':
                        $sql_omset     = $this->db->query(""
                                . "SELECT "
                                . "id, kode, icd, diagnosa_en, COUNT(icd) AS jml "
                                . "FROM tbl_trans_medcheck_icd "
                                . "WHERE DATE(tbl_trans_medcheck_icd.tgl_simpan) >= '".$this->tanggalan->tgl_indo_sys($tgl_awal)."' AND DATE(tbl_trans_medcheck_icd.tgl_simpan) <= '".$this->tanggalan->tgl_indo_sys($tgl_akhir)."' "
                                . "GROUP BY tbl_trans_medcheck_icd.id_icd HAVING  COUNT(id_icd) > 1 "
                                . "ORDER BY COUNT(tbl_trans_medcheck_icd.icd) DESC;"
                                . "")->result();
                    break;
            }

            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Header Tabel Nota
            $sheet->getStyle('A1:G1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A1:G1')->getFont()->setBold(TRUE);

            $sheet->setCellValue('A1', 'NO')
                  ->setCellValue('B1', 'ICD')
                  ->setCellValue('C1', '')
                  ->setCellValue('D1', 'JML DIAGNOSA');

            $sheet->getColumnDimension('A')->setWidth(2);
            $sheet->getColumnDimension('B')->setWidth(80);
            $sheet->getColumnDimension('C')->setWidth(80);
            $sheet->getColumnDimension('D')->setWidth(16);
            $sheet->getColumnDimension('E')->setWidth(16);
            $sheet->getColumnDimension('F')->setWidth(80);
            $sheet->getColumnDimension('G')->setWidth(80);

            if(!empty($sql_omset)){
                $no    = 1;
                $cell  = 2;
                $total = 0;
                foreach ($sql_omset as $omset){
                    $sheet->getStyle('A'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('B'.$cell.':D'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                    
                    $sheet->setCellValue('A'.$cell, $no)
                          ->setCellValue('B'.$cell, $omset->icd.(!empty($omset->diagnosa_en) ? ' >>' : ''))
                          ->setCellValue('C'.$cell, $omset->diagnosa_en)
                          ->setCellValue('D'.$cell, $omset->jml.' Diagnosa');

                    $no++;
                    $cell++;
                }

                $sell1 = $cell;
            }

            // Rename worksheet
            $sheet->setTitle('Lap ICD');

            /** Page Setup * */
            $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);
            $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);

            /* -- Margin -- */
            $sheet->getPageMargins()->setTop(0.25);
            $sheet->getPageMargins()->setRight(0);
            $sheet->getPageMargins()->setLeft(0);
            $sheet->getPageMargins()->setBottom(0);

            /** Page Setup * */
            // Set document properties
            $spreadsheet->getProperties()->setCreator("Mikhael Felian Waskito")
                    ->setLastModifiedBy($this->ion_auth->user()->row()->username)
                    ->setTitle("Stok")
                    ->setSubject("Aplikasi Bengkel POS")
                    ->setDescription("Kunjungi http://tigerasoft.co.id")
                    ->setKeywords("Pasifik POS")
                    ->setCategory("Untuk mencetak nota dot matrix");

            ob_end_clean();
            // Redirect output to a client's web browser (Excel5)
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="data_icd_'.(isset($_GET['filename']) ? $_GET['filename'] : 'lap').'.xls"');

            // If you're serving to IE over SSL, then the following may be needed
            header('Expires: Mon, 15 Feb 1992 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0

            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
            $writer->save('php://output');
            exit;
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function xls_data_pembelian(){
        if (akses::aksesLogin() == TRUE) {
            $supplier   = $this->input->get('id_supplier');
            $jml        = $this->input->get('jml');
            $tgl        = $this->input->get('tgl');
            $tgl_awal   = $this->input->get('tgl_awal');
            $tgl_akhir  = $this->input->get('tgl_akhir');
            $case       = $this->input->get('case');
            $hal        = $this->input->get('halaman');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $grup       = $this->ion_auth->get_users_groups()->row();
            $id_user    = $this->ion_auth->user()->row()->id;
            $id_grup    = $this->ion_auth->get_users_groups()->row();

            $sql_supp = $this->db->where('id', general::dekrip($supplier))->get('tbl_m_supplier')->row();
            
            switch ($case) {
                    case 'per_tanggal':
                        $sql_pembelian     = $this->db->select('tbl_trans_beli.id, tbl_trans_beli.tgl_masuk, tbl_trans_beli.no_nota, tbl_trans_beli_det.kode, tbl_trans_beli_det.produk, tbl_trans_beli_det.harga, tbl_trans_beli_det.harga, tbl_trans_beli_det.jml, tbl_trans_beli_det.diskon, tbl_trans_beli_det.subtotal, tbl_m_supplier.nama')
                                                          ->join('tbl_trans_beli', 'tbl_trans_beli.id=tbl_trans_beli_det.id_pembelian')
                                                          ->join('tbl_m_supplier', 'tbl_m_supplier.id=tbl_trans_beli.id_supplier')
                                                          ->where('DATE(tbl_trans_beli.tgl_masuk)', $this->tanggalan->tgl_indo_sys($tgl))
                                                          ->like('tbl_m_supplier.nama', $sql_supp->nama)
                                                          ->get('tbl_trans_beli_det')->result();
                        break;
                    
                    case 'per_rentang':
                        $sql_pembelian     = $this->db->select('tbl_trans_beli.id, tbl_trans_beli.tgl_masuk, tbl_trans_beli.no_nota, tbl_trans_beli_det.kode, tbl_trans_beli_det.produk, tbl_trans_beli_det.harga, tbl_trans_beli_det.harga_het, tbl_trans_beli_det.jml, tbl_trans_beli_det.diskon, tbl_trans_beli_det.subtotal, tbl_m_supplier.nama')
                                                          ->join('tbl_trans_beli', 'tbl_trans_beli.id=tbl_trans_beli_det.id_pembelian')
                                                          ->join('tbl_m_supplier', 'tbl_m_supplier.id=tbl_trans_beli.id_supplier')
                                                          ->where('DATE(tbl_trans_beli.tgl_masuk) >=', $this->tanggalan->tgl_indo_sys($tgl_awal))
                                                          ->where('DATE(tbl_trans_beli.tgl_masuk) <=', $this->tanggalan->tgl_indo_sys($tgl_akhir))
                                                          ->like('tbl_m_supplier.nama', $sql_supp->nama)
                                                          ->get('tbl_trans_beli')->result();
                        
                        break;
            }

            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Header Tabel Nota
            $sheet->getStyle('A4:I4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A4:I4')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A4:I4')->getFont()->setBold(TRUE);

            $sheet->setCellValue('A4', 'No.')
                  ->setCellValue('B4', 'Tgl')
                  ->setCellValue('C4', 'No. Faktur')
                  ->setCellValue('D4', 'Supplier')
                  ->setCellValue('E4', 'Item')
                  ->setCellValue('F4', 'Harga')
                  ->setCellValue('G4', 'Jml')
                  ->setCellValue('H4', 'Subtotal')
                  ->setCellValue('I4', 'HET');

            $sheet->getColumnDimension('A')->setWidth(6);
            $sheet->getColumnDimension('B')->setWidth(10);
            $sheet->getColumnDimension('C')->setWidth(25);
            $sheet->getColumnDimension('D')->setWidth(40);
            $sheet->getColumnDimension('E')->setWidth(35);
            $sheet->getColumnDimension('F')->setWidth(25);
            $sheet->getColumnDimension('G')->setWidth(7);
            $sheet->getColumnDimension('H')->setWidth(25);

            if(!empty($sql_pembelian)){
                $no    = 1;
                $cell  = 5;
                $total = 0;
                foreach ($sql_pembelian as $item){
                    $total = $total + $item->subtotal;

                    $sheet->getStyle('A'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('B'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('C'.$cell.':E'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                    $sheet->getStyle('F'.$cell.':I'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    $sheet->getStyle('F'.$cell.':I'.$cell)->getNumberFormat()->setFormatCode("_(\"\"* #,##0_);_(\"\"* \(#,##0\);_(\"\"* \"-\"??_);_(@_)");
               
                    $sheet->setCellValue('A'.$cell, $no)
                          ->setCellValue('B'.$cell, $this->tanggalan->tgl_indo($item->tgl_masuk))
                          ->setCellValue('C'.$cell, $item->no_nota)
                          ->setCellValue('D'.$cell, $item->nama)
                          ->setCellValue('E'.$cell, $item->produk)
                          ->setCellValue('F'.$cell, $item->harga)
                          ->setCellValue('G'.$cell, (float)$item->jml)
                          ->setCellValue('H'.$cell, $item->subtotal)
                          ->setCellValue('I'.$cell, $item->harga_het);

                    $no++;
                    $cell++;
                }

                $sell1 = $cell;
            }

            // Rename worksheet
            $sheet->setTitle('Lap Pembelian');

            /** Page Setup * */
            $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);
            $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);

            /* -- Margin -- */
            $sheet->getPageMargins()->setTop(0.25);
            $sheet->getPageMargins()->setRight(0);
            $sheet->getPageMargins()->setLeft(0);
            $sheet->getPageMargins()->setBottom(0);

            /** Page Setup * */
            // Set document properties
            $spreadsheet->getProperties()->setCreator("Mikhael Felian Waskito")
                    ->setLastModifiedBy($this->ion_auth->user()->row()->username)
                    ->setTitle("Stok")
                    ->setSubject("Aplikasi Bengkel POS")
                    ->setDescription("Kunjungi http://tigerasoft.co.id")
                    ->setKeywords("Pasifik POS")
                    ->setCategory("Untuk mencetak nota dot matrix");

            ob_end_clean();
            // Redirect output to a client's web browser (Excel5)
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="data_pembelian_'.(isset($_GET['filename']) ? $_GET['filename'] : 'lap').'.xls"');

            // If you're serving to IE over SSL, then the following may be needed
            header('Expires: Mon, 15 Feb 1992 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0

            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
            $writer->save('php://output');
            exit;
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function xls_data_omset(){
        if (akses::aksesLogin() == TRUE) {
            $jml        = $this->input->get('jml');
            $tgl        = $this->input->get('tgl');
            $tgl_awal   = $this->input->get('tgl_awal');
            $tgl_akhir  = $this->input->get('tgl_akhir');
            $case       = $this->input->get('case');
            $hal        = $this->input->get('halaman');
            $poli       = $this->input->get('poli');
            $tipe       = $this->input->get('tipe');
            $tipe_byr   = $this->input->get('tipe_byr'); // Added missing variable
            $plat       = $this->input->get('plat');
            $pasien_id  = $this->input->get('id_pasien');
            $pasien     = $this->input->get('pasien');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $grup       = $this->ion_auth->get_users_groups()->row();
            $id_user    = $this->ion_auth->user()->row()->id;
            $id_grup    = $this->ion_auth->get_users_groups()->row();
            
            $query = "select `tmd`.`id` AS `id`,`tm`.`id` AS `id_medcheck`,`tm`.`id_pasien` AS `id_pasien`,`tm`.`id_poli` AS `id_poli`,`tm`.`id_dokter` AS `id_dokter`,`tmd`.`id_item` AS `id_item`,`tmd`.`id_item_kat` AS `id_item_kat`,`tmd`.`tgl_simpan` AS `tgl_simpan`,`tm`.`tgl_masuk` AS `tgl_masuk`,`tm`.`tgl_bayar` AS `tgl_bayar`,`tm`.`no_akun` AS `no_akun`,`tm`.`no_rm` AS `no_rm`,`mp`.`nama_pgl` AS `nama_pgl`,`mp`.`nama_pgl` AS `pasien`,`mp`.`tgl_lahir` AS `tgl_lahir`,`tmd`.`kode` AS `kode`,`tmd`.`item` AS `item`,`tmd`.`jml` AS `jml`,`tmd`.`harga` AS `harga`,`tmd`.`diskon` AS `diskon`,`tmd`.`potongan` AS `potongan`,`tmd`.`potongan_poin` AS `potongan_poin`,`tmd`.`subtotal` AS `subtotal`,`tm`.`jml_gtotal` AS `jml_gtotal`,`tmd`.`status_pkt` AS `status_pkt`,`tmd`.`status` AS `status`,`tm`.`tipe` AS `tipe`,`tm`.`tipe_bayar` AS `tipe_bayar`,`tm`.`metode` AS `metode` from ((`tbl_trans_medcheck_det` `tmd` join `tbl_trans_medcheck` `tm` on(`tmd`.`id_medcheck` = `tm`.`id`)) join `tbl_m_pasien` `mp` on(`tm`.`id_pasien` = `mp`.`id`)) where `tm`.`status_hps` = '0' and `tm`.`status_bayar` = '1'";
            
            switch ($case) {
                case 'per_tanggal':
                    $query .= " AND DATE(tm.tgl_bayar) = '$tgl'";
                    if (!empty($tipe)) $query .= " AND tm.tipe LIKE '%$tipe%'";
                    if (!empty($tipe_byr)) $query .= " AND tm.tipe_bayar LIKE '%$tipe_byr%'";
                    if (!empty($poli)) $query .= " AND tm.id_poli LIKE '%$poli%'";
                    if (!empty($plat)) $query .= " AND tm.metode LIKE '%$plat%'";
                    if (!empty($pasien)) $query .= " AND mp.nama_pgl LIKE '%$pasien%'";
                    $query .= " ORDER BY tm.id DESC";
                    $sql_omset = $this->db->query($query)->result();
                    break;

                case 'per_rentang':
                    $query .= " AND DATE(tm.tgl_bayar) >= '$tgl_awal' AND DATE(tm.tgl_bayar) <= '$tgl_akhir'";
                    if (!empty($tipe)) $query .= " AND tm.tipe LIKE '%$tipe%'";
                    if (!empty($tipe_byr)) $query .= " AND tm.tipe_bayar LIKE '%$tipe_byr%'";
                    if (!empty($poli)) $query .= " AND tm.id_poli LIKE '%$poli%'";
                    if (!empty($plat)) $query .= " AND tm.metode LIKE '%$plat%'";
                    if (!empty($pasien)) $query .= " AND mp.nama_pgl LIKE '%$pasien%'";
                    $query .= " ORDER BY tm.id DESC";
                    $sql_omset = $this->db->query($query)->result();
                    break;
            }

            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->getStyle('A1:Q4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A1:Q4')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A1:Q4')->getFont()->setBold(TRUE);
            
            $sheet->setCellValue('A1', 'LAPORAN OMSET');
            $sheet->mergeCells('A1:J1');
            $sheet->setCellValue('A2', $pengaturan->judul);
            $sheet->mergeCells('A2:J2');
            
            $sheet->setCellValue('A4', 'No.')
                  ->setCellValue('B4', 'Tgl')
                  ->setCellValue('C4', 'Pasien')
                  ->setCellValue('D4', 'Tipe')
                  ->setCellValue('E4', 'Dokter')
                  ->setCellValue('F4', 'No. Faktur')
                  ->setCellValue('G4', 'Group')
                  ->setCellValue('H4', 'Kode')
                  ->setCellValue('I4', 'Item')
                  ->setCellValue('J4', 'Jml')
                  ->setCellValue('K4', 'Harga')
                  ->setCellValue('L4', 'Subtotal')
                  ->setCellValue('M4', 'Diskon')
                  ->setCellValue('N4', 'Potongan')
                  ->setCellValue('O4', 'Grand Total')
                  ->setCellValue('P4', 'Jasa Dokter')
                  ->setCellValue('Q4', 'Total Jasa');
            
            $sheet->freezePane("A5");
            $sheet->setAutoFilter('A4:Q4');

            $sheet->getColumnDimension('A')->setWidth(5);
            $sheet->getColumnDimension('B')->setWidth(15);
            $sheet->getColumnDimension('C')->setWidth(50);
            $sheet->getColumnDimension('D')->setWidth(10);
            $sheet->getColumnDimension('E')->setWidth(40);
            $sheet->getColumnDimension('F')->setWidth(14);
            $sheet->getColumnDimension('G')->setWidth(15);
            $sheet->getColumnDimension('H')->setWidth(14);
            $sheet->getColumnDimension('I')->setWidth(45);
            $sheet->getColumnDimension('J')->setWidth(10);
            $sheet->getColumnDimension('K')->setWidth(14);
            $sheet->getColumnDimension('L')->setWidth(16);
            $sheet->getColumnDimension('M')->setWidth(14);
            $sheet->getColumnDimension('N')->setWidth(14);
            $sheet->getColumnDimension('O')->setWidth(16);
            $sheet->getColumnDimension('P')->setWidth(16);
            $sheet->getColumnDimension('Q')->setWidth(16);

            if(!empty($sql_omset)){
                $no    = 1;
                $cell  = 5;
                $total = 0;
                foreach ($sql_omset as $omset){
                    $sql_poli   = $this->db->where('id', $omset->id_poli)->get('tbl_m_poli')->row();
                    $sql_kary   = $this->db->where('id_user', $omset->id_dokter)->get('tbl_m_karyawan')->row();
                    $sql_remun  = $this->db->where('id_medcheck_det', $omset->id_medcheck_det)->get('tbl_trans_medcheck_remun')->row();
                    $subtotal   = $omset->harga * $omset->jml;
                    $remun_nom  = 0;
                    $remun_tot  = 0;
                    
                    if(isset($sql_remun) && !empty($sql_remun)) {
                        $remun_nom = ($sql_remun->remun_tipe == '2' ? $sql_remun->remun_nom : (($sql_remun->remun_perc / 100) * $omset->harga));
                        $remun_tot = isset($sql_remun->remun_subtotal) ? $sql_remun->remun_subtotal * $omset->jml : 0;
                    }
                    
                    $potongan   = $omset->potongan + $omset->potongan_poin;
                    
                    $sheet->getStyle('A'.$cell.':B'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('C'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                    $sheet->getStyle('D'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('E'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                    $sheet->getStyle('F'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('G'.$cell.':I'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                    $sheet->getStyle('J'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('K'.$cell.':Q'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    $sheet->getStyle('K'.$cell.':Q'.$cell)->getNumberFormat()->setFormatCode("_(\"\"* #,##0_);_(\"\"* \(#,##0\);_(\"\"* \"-\"??_);_(@_)");
                    
                    $sheet->setCellValue('A'.$cell, $no)
                          ->setCellValue('B'.$cell, $this->tanggalan->tgl_indo5($omset->tgl_simpan))
                          ->setCellValue('C'.$cell, $omset->pasien)
                          ->setCellValue('D'.$cell, general::status_rawat2($omset->tipe))
                          ->setCellValue('E'.$cell, $sql_kary->nama)
                          ->setCellValue('F'.$cell, $omset->no_rm)
                          ->setCellValue('G'.$cell, general::tipe_item($omset->status))
                          ->setCellValue('H'.$cell, $omset->kode)
                          ->setCellValue('I'.$cell, $omset->item)
                          ->setCellValue('J'.$cell, (float)$omset->jml)
                          ->setCellValue('K'.$cell, $omset->harga)
                          ->setCellValue('L'.$cell, $subtotal)
                          ->setCellValue('M'.$cell, $omset->diskon)
                          ->setCellValue('N'.$cell, $potongan)
                          ->setCellValue('O'.$cell, $omset->subtotal)
                          ->setCellValue('P'.$cell, $remun_nom)
                          ->setCellValue('Q'.$cell, $remun_tot);

                    $no++;
                    $cell++;
                }

                $sell1 = $cell;
            }

            // Rename worksheet
            $sheet->setTitle('Lap Omset');

            /** Page Setup * */
            $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);
            $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);

            /* -- Margin -- */
            $sheet->getPageMargins()->setTop(0.25);
            $sheet->getPageMargins()->setRight(0);
            $sheet->getPageMargins()->setLeft(0);
            $sheet->getPageMargins()->setBottom(0);

            /** Page Setup * */
            // Set document properties
            $spreadsheet->getProperties()->setCreator("Mikhael Felian Waskito")
                    ->setLastModifiedBy($this->ion_auth->user()->row()->username)
                    ->setTitle("Stok")
                    ->setSubject("Aplikasi Bengkel POS")
                    ->setDescription("Kunjungi http://tigerasoft.co.id")
                    ->setKeywords("Pasifik POS")
                    ->setCategory("Untuk mencetak nota dot matrix");

            ob_end_clean();
            // Redirect output to a client's web browser (Excel5)
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="data_omset_'.(isset($_GET['filename']) ? $_GET['filename'] : 'lap').'.xls"');

            // If you're serving to IE over SSL, then the following may be needed
            header('Expires: Mon, 15 Feb 1992 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0

            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
            $writer->save('php://output');
            exit;
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function xls_data_omset_zahir(){
        if (akses::aksesLogin() == TRUE) {
            $jml        = $this->input->get('jml');
            $tgl        = $this->input->get('tgl');
            $tgl_awal   = $this->input->get('tgl_awal');
            $tgl_akhir  = $this->input->get('tgl_akhir');
            $case       = $this->input->get('case');
            $hal        = $this->input->get('halaman');
            $poli       = $this->input->get('poli');
            $tipe       = $this->input->get('tipe');
            $tipe_byr   = $this->input->get('tipe_byr');
            $plat       = $this->input->get('plat');
            $pasien_id  = $this->input->get('id_pasien');
            $pasien     = $this->input->get('pasien');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $grup       = $this->ion_auth->get_users_groups()->row();
            $id_user    = $this->ion_auth->user()->row()->id;
            $id_grup    = $this->ion_auth->get_users_groups()->row();
            
            switch ($case) {
                case 'per_tanggal':
                        $sql_omset     = $this->db
                                              ->select('`tmd`.`id` AS `id`,`tm`.`id` AS `id_medcheck`,`tm`.`id_pasien` AS `id_pasien`,`tm`.`id_poli` AS `id_poli`,`tm`.`id_dokter` AS `id_dokter`,`tmd`.`id_item` AS `id_item`,`tmd`.`id_item_kat` AS `id_item_kat`,`tmd`.`tgl_simpan` AS `tgl_simpan`,`tm`.`tgl_masuk` AS `tgl_masuk`,`tm`.`tgl_bayar` AS `tgl_bayar`,`tm`.`no_akun` AS `no_akun`,`tm`.`no_rm` AS `no_rm`,`mp`.`nama_pgl` AS `nama_pgl`,`mp`.`nama_pgl` AS `pasien`,`mp`.`tgl_lahir` AS `tgl_lahir`,`tmd`.`kode` AS `kode`,`tmd`.`item` AS `item`,`tmd`.`jml` AS `jml`,`tmd`.`harga` AS `harga`,`tmd`.`diskon` AS `diskon`,`tmd`.`potongan` AS `potongan`,`tmd`.`potongan_poin` AS `potongan_poin`,`tmd`.`subtotal` AS `subtotal`,`tm`.`jml_gtotal` AS `jml_gtotal`,`tmd`.`status_pkt` AS `status_pkt`,`tmd`.`status` AS `status`,`tm`.`tipe` AS `tipe`,`tm`.`tipe_bayar` AS `tipe_bayar`,`tm`.`metode` AS `metode`')
                                              ->from('`tbl_trans_medcheck_det` `tmd`')
                                              ->join('`tbl_trans_medcheck` `tm`', '`tmd`.`id_medcheck` = `tm`.`id`')
                                              ->join('`tbl_m_pasien` `mp`', '`tm`.`id_pasien` = `mp`.`id`')
                                              ->where('`tm`.`status_hps`', '0')
                                              ->where('`tm`.`status_bayar`', '1')
                                              ->where('DATE(tgl_bayar)', $tgl)
                                              ->like('tipe', $tipe, (!empty($tipe) ? 'none' : ''))
                                              ->like('tipe_bayar', $tipe_byr, (!empty($tipe_byr) ? 'none' : ''))
                                              ->like('id_poli', $poli, (!empty($poli) ? 'none' : ''))
                                              ->like('metode', $plat, (!empty($plat) ? 'none' : ''))
                                              ->like('pasien', $pasien, (!empty($pasien) ? 'none' : ''))
                                              ->order_by('id_medcheck', 'DESC')
                                              ->get()->result();
                    break;

                case 'per_rentang':
                        $sql_omset     = $this->db
                                              ->select('`tmd`.`id` AS `id`,`tm`.`id` AS `id_medcheck`,`tm`.`id_pasien` AS `id_pasien`,`tm`.`id_poli` AS `id_poli`,`tm`.`id_dokter` AS `id_dokter`,`tmd`.`id_item` AS `id_item`,`tmd`.`id_item_kat` AS `id_item_kat`,`tmd`.`tgl_simpan` AS `tgl_simpan`,`tm`.`tgl_masuk` AS `tgl_masuk`,`tm`.`tgl_bayar` AS `tgl_bayar`,`tm`.`no_akun` AS `no_akun`,`tm`.`no_rm` AS `no_rm`,`mp`.`nama_pgl` AS `nama_pgl`,`mp`.`nama_pgl` AS `pasien`,`mp`.`tgl_lahir` AS `tgl_lahir`,`tmd`.`kode` AS `kode`,`tmd`.`item` AS `item`,`tmd`.`jml` AS `jml`,`tmd`.`harga` AS `harga`,`tmd`.`diskon` AS `diskon`,`tmd`.`potongan` AS `potongan`,`tmd`.`potongan_poin` AS `potongan_poin`,`tmd`.`subtotal` AS `subtotal`,`tm`.`jml_gtotal` AS `jml_gtotal`,`tmd`.`status_pkt` AS `status_pkt`,`tmd`.`status` AS `status`,`tm`.`tipe` AS `tipe`,`tm`.`tipe_bayar` AS `tipe_bayar`,`tm`.`metode` AS `metode`')
                                              ->from('`tbl_trans_medcheck_det` `tmd`')
                                              ->join('`tbl_trans_medcheck` `tm`', '`tmd`.`id_medcheck` = `tm`.`id`')
                                              ->join('`tbl_m_pasien` `mp`', '`tm`.`id_pasien` = `mp`.`id`')
                                              ->where('`tm`.`status_hps`', '0')
                                              ->where('`tm`.`status_bayar`', '1')
                                              ->where('DATE(tgl_bayar) >=', $tgl_awal)
                                              ->where('DATE(tgl_bayar) <=', $tgl_akhir)
                                              ->like('tipe', $tipe, (!empty($tipe) ? 'none' : ''))
                                              ->like('tipe_bayar', $tipe_byr, (!empty($tipe_byr) ? 'none' : ''))
                                              ->like('id_poli', $poli, (!empty($poli) ? 'none' : ''))
                                              ->like('metode', $plat, (!empty($plat) ? 'none' : ''))
                                              ->like('pasien', $pasien, (!empty($pasien) ? 'none' : ''))
                                              ->order_by('id_medcheck', 'DESC')
                                              ->get()->result();
                    break;
            }
            
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            
            // Header Tabel Nota
            $sheet->getStyle('A1:AL1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A1:AL1')->getFont()->setBold(true);

            $sheet->setCellValue('A1', 'date')
                  ->setCellValue('B1', 'number')
                  ->setCellValue('C1', 'patient')
                  ->setCellValue('D1', 'description')
                  ->setCellValue('E1', 'customer.code')
                  ->setCellValue('F1', 'orders[0].number')
                  ->setCellValue('G1', 'currency.code')
                  ->setCellValue('H1', 'exchange_rate')
                  ->setCellValue('I1', 'department.code')
                  ->setCellValue('J1', 'project.code')
                  ->setCellValue('K1', 'warehouse.code')
                  ->setCellValue('L1', 'line_items.product.code')
                  ->setCellValue('M1', 'line_items.account.code')
                  ->setCellValue('N1', 'line_items.unit.code')
                  ->setCellValue('O1', 'line_items.quantity')
                  ->setCellValue('P1', 'line_items.unit_price')
                  ->setCellValue('Q1', 'line_items.discount.rate')
                  ->setCellValue('R1', 'line_items.discount.amount')
                  ->setCellValue('S1', 'line_items.description')
                  ->setCellValue('T1', 'line_items.taxes[0].code')
                  ->setCellValue('U1', 'line_items.department.code')
                  ->setCellValue('V1', 'line_items.project.code')
                  ->setCellValue('W1', 'line_items.warehouse.code')
                  ->setCellValue('X1', 'line_items.note')
                  ->setCellValue('Y1', 'payments[0].is_cash')
                  ->setCellValue('Z1', 'payments[0].account.code')
                  ->setCellValue('AA1', 'status')
                  ->setCellValue('AB1', 'term_of_payments[0].discount_days')
                  ->setCellValue('AC1', 'term_of_payments[0].due_date')
                  ->setCellValue('AD1', 'term_of_payments[0].due_days')
                  ->setCellValue('AE1', 'term_of_payments[0].early_discount_rate')
                  ->setCellValue('AF1', 'term_of_payments[0].late_charge_rate')
                  ->setCellValue('AG1', 'document.number')
                  ->setCellValue('AH1', 'document.date')
                  ->setCellValue('AI1', 'parent_memo.number')
                  ->setCellValue('AJ1', 'employees[0].contact.code')
                  ->setCellValue('AK1', 'delivery_dates')
                  ->setCellValue('AL1', 'others[0].amount_origin');
            
            $sheet->freezePane("A2");
            $sheet->setAutoFilter('A1:AL1');

            $sheet->getColumnDimension('A')->setWidth(15);
            $sheet->getColumnDimension('B')->setWidth(15);
            $sheet->getColumnDimension('C')->setWidth(50);
            $sheet->getColumnDimension('D')->setWidth(15);
            $sheet->getColumnDimension('E')->setWidth(14);
            $sheet->getColumnDimension('F')->setWidth(16);
            $sheet->getColumnDimension('G')->setWidth(12);
            $sheet->getColumnDimension('H')->setWidth(10);
            $sheet->getColumnDimension('I')->setWidth(16);
            $sheet->getColumnDimension('J')->setWidth(11);
            $sheet->getColumnDimension('K')->setWidth(15);
            $sheet->getColumnDimension('L')->setWidth(22);
            $sheet->getColumnDimension('M')->setWidth(20);
            $sheet->getColumnDimension('N')->setWidth(20);
            $sheet->getColumnDimension('O')->setWidth(18);
            $sheet->getColumnDimension('P')->setWidth(20);
            $sheet->getColumnDimension('Q')->setWidth(20);
            $sheet->getColumnDimension('R')->setWidth(20);
            $sheet->getColumnDimension('S')->setWidth(40);
            $sheet->getColumnDimension('T')->setWidth(20);
            $sheet->getColumnDimension('U')->setWidth(20);
            $sheet->getColumnDimension('V')->setWidth(20);
            $sheet->getColumnDimension('W')->setWidth(20);
            $sheet->getColumnDimension('X')->setWidth(15);
            $sheet->getColumnDimension('Y')->setWidth(18);
            $sheet->getColumnDimension('Z')->setWidth(20);
            $sheet->getColumnDimension('AA')->setWidth(6);
            $sheet->getColumnDimension('AB')->setWidth(40);
            $sheet->getColumnDimension('AC')->setWidth(40);
            $sheet->getColumnDimension('AD')->setWidth(40);
            $sheet->getColumnDimension('AE')->setWidth(40);
            $sheet->getColumnDimension('AF')->setWidth(40);
            $sheet->getColumnDimension('AG')->setWidth(40);
            $sheet->getColumnDimension('AH')->setWidth(14);
            $sheet->getColumnDimension('AI')->setWidth(25);
            $sheet->getColumnDimension('AJ')->setWidth(25);
            $sheet->getColumnDimension('AK')->setWidth(16);
            $sheet->getColumnDimension('AL')->setWidth(25);

            if(!empty($sql_omset)){
                $no    = 1;
                $cell  = 2;
                $total = 0;
                foreach ($sql_omset as $omset){
                    $sql_poli   = $this->db->where('id', $omset->id_poli)->get('tbl_m_poli')->row();
                    $sql_kary   = $this->db->where('id_user', $omset->id_dokter)->get('tbl_m_karyawan')->row();
                    $sql_remun  = $this->db->where('id_medcheck_det', $omset->id_medcheck_det)->get('tbl_trans_medcheck_remun')->row();
                    
                    // Get platform data
                    $sql_plat   = $this->db->select('tbl_trans_medcheck_plat.id, tbl_trans_medcheck_plat.id_platform, tbl_m_platform.platform AS metode, tbl_trans_medcheck_plat.platform, tbl_trans_medcheck_plat.keterangan, tbl_trans_medcheck_plat.nominal, tbl_m_platform.status_akt, tbl_m_platform.kode, tbl_m_platform.akun')
                                           ->where('tbl_trans_medcheck_plat.id_medcheck', $omset->id_medcheck)
                                           ->join('tbl_m_platform', 'tbl_m_platform.id=tbl_trans_medcheck_plat.id_platform', 'left')
                                           ->get('tbl_trans_medcheck_plat');
                    
                    // Get platform details
                    $sql_plat2  = $this->db->where('id', $omset->metode)->get('tbl_m_platform')->row();
                    
                    // Calculate values
                    $subtotal   = $omset->harga * $omset->jml;
                    $diskon     = isset($omset->diskon) ? $omset->diskon : 0;
                    $diskon    += isset($omset->potongan) ? $omset->potongan : 0;
                    $diskon    += isset($omset->potongan_poin) ? $omset->potongan_poin : 0;
                    
                    // Calculate remuneration if exists
                    $remun_nom  = 0;
                    $remun_tot  = 0;
                    if(isset($sql_remun) && !empty($sql_remun)) {
                        $remun_nom = ($sql_remun->remun_tipe == '2' ? $sql_remun->remun_nom : (($sql_remun->remun_perc / 100) * $omset->harga));
                        $remun_tot = isset($sql_remun->remun_subtotal) ? $sql_remun->remun_subtotal * $omset->jml : 0;
                    }
                    
                    // Determine payment type - Group asuransi as PIUTANG
                    $is_split = 'PIUTANG';
                    if ($sql_plat->num_rows() <= 1) {
                        if (isset($sql_plat2) && $sql_plat2->status_akt == '1') {
                            // Check if it's asuransi type
                            if (strtolower($sql_plat2->platform) == 'asuransi') {
                                $is_split = 'PIUTANG';
                            } else {
                                $is_split = strtoupper($sql_plat2->platform);
                            }
                        }
                    }
                    
                    // Set cell styles
                    $sheet->getStyle('A'.$cell.':B'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('C'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                    $sheet->getStyle('D'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('E'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                    $sheet->getStyle('F'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('G'.$cell.':I'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                    $sheet->getStyle('J'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('K'.$cell.':Q'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    $sheet->getStyle('P'.$cell)->getNumberFormat()->setFormatCode("_(\"\"* #,##0_);_(\"\"* \(#,##0\);_(\"\"* \"-\"??_);_(@_)");
                    $sheet->getStyle('R'.$cell)->getNumberFormat()->setFormatCode("_(\"\"* #,##0_);_(\"\"* \(#,##0\);_(\"\"* \"-\"??_);_(@_)");
                    
                    // Customer code handling
                    $customer_code = 'UMUM';
                    if(isset($sql_plat2) && $sql_plat2->status_akt != '1' && !empty($sql_plat2->kode)) {
                        $customer_code = $sql_plat2->kode;
                    }
                    
                    // Account code handling
                    $account_code = '';
                    if(isset($sql_plat2) && !empty($sql_plat2->akun)) {
                        $account_code = $sql_plat2->akun;
                    }
                    
                    // Set cell values
                    $sheet->setCellValue('A'.$cell, isset($omset->tgl_simpan) ? $this->tanggalan->tgl_indo5($omset->tgl_simpan) : '')
                          ->setCellValue('B'.$cell, isset($omset->no_akun) ? $omset->no_akun : '')
                          ->setCellValue('C'.$cell, isset($omset->pasien) ? $omset->pasien : '')
                          ->setCellValue('D'.$cell, $is_split)
                          ->setCellValue('E'.$cell, $customer_code)
                          ->setCellValue('F'.$cell, '')
                          ->setCellValue('G'.$cell, 'IDR')
                          ->setCellValue('H'.$cell, '1')
                          ->setCellValue('I'.$cell, '99')
                          ->setCellValue('J'.$cell, 'N/A')
                          ->setCellValue('K'.$cell, '99')
                          ->setCellValue('L'.$cell, isset($omset->kode) ? $omset->kode : '')
                          ->setCellValue('M'.$cell, '')
                          ->setCellValue('N'.$cell, (!empty($omset->satuan) ? strtolower(ucfirst($omset->satuan)) : 'Pcs'))
                          ->setCellValue('O'.$cell, (float) (isset($omset->jml) && $omset->jml > 0 ? $omset->jml : ''))
                          ->setCellValue('P'.$cell, isset($omset->harga) ? $omset->harga : 0)
                          ->setCellValue('Q'.$cell, '')
                          ->setCellValue('R'.$cell, round($diskon, 2))
                          ->setCellValue('S'.$cell, isset($omset->item) ? $omset->item : '')
                          ->setCellValue('T'.$cell, '')
                          ->setCellValue('U'.$cell, '99')
                          ->setCellValue('V'.$cell, 'N/A')
                          ->setCellValue('W'.$cell, '99')
                          ->setCellValue('X'.$cell, '')
                          ->setCellValue('Y'.$cell, (isset($omset->metode) && $omset->metode == '1' ? 'TRUE' : 'FALSE'))
                          ->setCellValue('Z'.$cell, $account_code)
                          ->setCellValue('AA'.$cell, 'draft')
                          ->setCellValue('AB'.$cell, '')
                          ->setCellValue('AC'.$cell, '')
                          ->setCellValue('AD'.$cell, '')
                          ->setCellValue('AE'.$cell, '')
                          ->setCellValue('AF'.$cell, '')
                          ->setCellValue('AG'.$cell, '')
                          ->setCellValue('AH'.$cell, isset($omset->tgl_masuk) ? $this->tanggalan->tgl_indo7($omset->tgl_masuk) : '')
                          ->setCellValue('AI'.$cell, '')
                          ->setCellValue('AJ'.$cell, '')
                          ->setCellValue('AK'.$cell, isset($omset->tgl_bayar) ? $this->tanggalan->tgl_indo7($omset->tgl_bayar) : '')
                          ->setCellValue('AL'.$cell, '');

                    $no++;
                    $cell++;
                }
            }

            // Rename worksheet
            $sheet->setTitle('Lap Omset Zahir');

            // Page Setup
            $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);
            $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);

            // Margins
            $sheet->getPageMargins()->setTop(0.25);
            $sheet->getPageMargins()->setRight(0);
            $sheet->getPageMargins()->setLeft(0);
            $sheet->getPageMargins()->setBottom(0);

            // Document properties
            $spreadsheet->getProperties()->setCreator("Mikhael Felian Waskito")
                        ->setLastModifiedBy($this->ion_auth->user()->row()->username)
                        ->setTitle("Stok")
                        ->setSubject("Aplikasi Bengkel POS")
                        ->setDescription("Kunjungi http://tigerasoft.co.id")
                        ->setKeywords("Pasifik POS")
                        ->setCategory("Untuk mencetak nota dot matrix");

            ob_end_clean();
            
            // Headers
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="data_omset_lap_zahir.xls"');
            header('Expires: Mon, 15 Feb 1992 05:00:00 GMT');
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
            header('Cache-Control: cache, must-revalidate');
            header('Pragma: public');

            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
            $writer->save('php://output');
            exit;
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function xls_data_omset_poli(){
        if (akses::aksesLogin() == TRUE) {
            $tgl        = $this->input->get('tgl');
            $tgl_awal   = $this->input->get('tgl_awal');
            $tgl_akhir  = $this->input->get('tgl_akhir');
            $tipe       = $this->input->get('tipe');
            $poli       = $this->input->get('poli');
            $status     = $this->input->get('status');
            $case       = $this->input->get('case');
            $hal        = $this->input->get('halaman');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();
            $st         = json_decode(general::dekrip($status));

            $grup       = $this->ion_auth->get_users_groups()->row();
            $id_user    = $this->ion_auth->user()->row()->id;
            $id_grup    = $this->ion_auth->get_users_groups()->row();

            
            switch ($case) {
                case 'per_tanggal':
                    $sql_omset      = $this->db->select('tmd.id AS id, tm.id AS id_medcheck, tm.id_pasien AS id_pasien, tm.id_poli AS id_poli, tm.id_dokter AS id_dokter, tmd.id_item AS id_item, tmd.id_item_kat AS id_item_kat, tmd.tgl_simpan AS tgl_simpan, tm.tgl_masuk AS tgl_masuk, tm.tgl_bayar AS tgl_bayar, tm.no_akun AS no_akun, tm.no_rm AS no_rm, mp.nama_pgl AS nama_pgl, mp.nama_pgl AS pasien, mp.tgl_lahir AS tgl_lahir, tmd.kode AS kode, tmd.item AS item, tmd.jml AS jml, tmd.harga AS harga, tmd.diskon AS diskon, tmd.potongan AS potongan, tmd.potongan_poin AS potongan_poin, tmd.subtotal AS subtotal, tm.jml_gtotal AS jml_gtotal, tmd.status_pkt AS status_pkt, tmd.status AS status, tm.tipe AS tipe, tm.tipe_bayar AS tipe_bayar, tm.metode AS metode')
                                               ->from('tbl_trans_medcheck_det tmd')
                                               ->join('tbl_trans_medcheck tm', 'tmd.id_medcheck = tm.id')
                                               ->join('tbl_m_pasien mp', 'tm.id_pasien = mp.id')
                                               ->where('tm.status_hps', '0')
                                               ->where('tm.status_bayar', '1')
                                               ->where('DATE(tm.tgl_bayar)', $tgl)
                                               ->where_in('tmd.id_item_kat', $st)
                                               ->like('tm.id_poli', $poli, (!empty($poli) ? 'none' : ''))
                                               ->like('tm.tipe', $tipe, (!empty($tipe) ? 'none' : ''))
                                               ->order_by('tmd.id', 'DESC')
                                               ->get()->result();
                    
                    $sql_omset_pas  = $this->db->select('SUM(tmd.subtotal) AS jml_gtotal')
                                               ->from('tbl_trans_medcheck_det tmd')
                                               ->join('tbl_trans_medcheck tm', 'tmd.id_medcheck = tm.id')
                                               ->join('tbl_m_pasien mp', 'tm.id_pasien = mp.id')
                                               ->where('tm.status_hps', '0')
                                               ->where('tm.status_bayar', '1')
                                               ->where('DATE(tm.tgl_bayar)', $tgl)
                                               ->where_in('tmd.status', $st)
                                               ->like('tm.id_poli', $poli, (!empty($poli) ? 'none' : ''))
                                               ->like('tm.tipe', $tipe, (!empty($tipe) ? 'none' : ''))
                                               ->get()->row();
                    break;

                case 'per_rentang':
                    $sql_omset      = $this->db->select('tmd.id AS id, tm.id AS id_medcheck, tm.id_pasien AS id_pasien, tm.id_poli AS id_poli, tm.id_dokter AS id_dokter, tmd.id_item AS id_item, tmd.id_item_kat AS id_item_kat, tmd.tgl_simpan AS tgl_simpan, tm.tgl_masuk AS tgl_masuk, tm.tgl_bayar AS tgl_bayar, tm.no_akun AS no_akun, tm.no_rm AS no_rm, mp.nama_pgl AS nama_pgl, mp.nama_pgl AS pasien, mp.tgl_lahir AS tgl_lahir, tmd.kode AS kode, tmd.item AS item, tmd.jml AS jml, tmd.harga AS harga, tmd.diskon AS diskon, tmd.potongan AS potongan, tmd.potongan_poin AS potongan_poin, tmd.subtotal AS subtotal, tm.jml_gtotal AS jml_gtotal, tmd.status_pkt AS status_pkt, tmd.status AS status, tm.tipe AS tipe, tm.tipe_bayar AS tipe_bayar, tm.metode AS metode')
                                               ->from('tbl_trans_medcheck_det tmd')
                                               ->join('tbl_trans_medcheck tm', 'tmd.id_medcheck = tm.id')
                                               ->join('tbl_m_pasien mp', 'tm.id_pasien = mp.id')
                                               ->where('tm.status_hps', '0')
                                               ->where('tm.status_bayar', '1')
                                               ->where('DATE(tm.tgl_bayar) >=', $tgl_awal)
                                               ->where('DATE(tm.tgl_bayar) <=', $tgl_akhir)
                                               ->where_in('tmd.id_item_kat', $st)
                                               ->like('tm.id_poli', $poli, (!empty($poli) ? 'none' : ''))
                                               ->like('tm.tipe', $tipe, (!empty($tipe) ? 'none' : ''))
                                               ->order_by('tmd.id', 'DESC')
                                               ->get()->result();
                    
                    $sql_omset_pas  = $this->db->select('SUM(tmd.subtotal) AS jml_gtotal')
                                               ->from('tbl_trans_medcheck_det tmd')
                                               ->join('tbl_trans_medcheck tm', 'tmd.id_medcheck = tm.id')
                                               ->join('tbl_m_pasien mp', 'tm.id_pasien = mp.id')
                                               ->where('tm.status_hps', '0')
                                               ->where('tm.status_bayar', '1')
                                               ->where('DATE(tm.tgl_bayar) >=', $tgl_awal)
                                               ->where('DATE(tm.tgl_bayar) <=', $tgl_akhir)
                                               ->where_in('tmd.status', $st)
                                               ->like('tm.id_poli', $poli, (!empty($poli) ? 'none' : ''))
                                               ->like('tm.tipe', $tipe, (!empty($tipe) ? 'none' : ''))
                                               ->get()->row();
                    break;
            }
            
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            
            // Header styling
            $sheet->getStyle('A1:S4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A1:S4')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A1:S4')->getFont()->setBold(true);

            $sheet->setCellValue('A1', 'LAPORAN OMSET PER POLI')
                  ->mergeCells('A1:M1');
            $sheet->setCellValue('A2', $pengaturan->judul)
                  ->mergeCells('A2:M2');

            $sheet->setCellValue('A4', 'No.')
                  ->setCellValue('B4', 'Tanggal')
                  ->setCellValue('C4', 'Pasien')
                  ->setCellValue('D4', 'Tipe')
                  ->setCellValue('E4', 'Poli')
                  ->setCellValue('F4', 'Dokter')
                  ->setCellValue('G4', 'No. Faktur')
                  ->setCellValue('H4', 'Kategori')
                  ->setCellValue('I4', 'Kode')
                  ->setCellValue('J4', 'Item')
                  ->setCellValue('K4', 'Jml')
                  ->setCellValue('L4', 'Harga')
                  ->setCellValue('M4', 'Grand Total');
            
            $sheet->freezePane("A5");
            $sheet->setAutoFilter('A4:M4');

            // Column widths
            $sheet->getColumnDimension('A')->setWidth(6);
            $sheet->getColumnDimension('B')->setWidth(16);
            $sheet->getColumnDimension('C')->setWidth(50);
            $sheet->getColumnDimension('D')->setWidth(16);
            $sheet->getColumnDimension('E')->setWidth(20);
            $sheet->getColumnDimension('F')->setWidth(50);
            $sheet->getColumnDimension('G')->setWidth(14);
            $sheet->getColumnDimension('H')->setWidth(15);
            $sheet->getColumnDimension('I')->setWidth(10);
            $sheet->getColumnDimension('J')->setWidth(40);
            $sheet->getColumnDimension('K')->setWidth(8);
            $sheet->getColumnDimension('L')->setWidth(10);
            $sheet->getColumnDimension('M')->setWidth(15);

            if(!empty($sql_omset)){
                $no         = 1;
                $cell       = 5;
                $total      = 0;
                $total_itm  = 0;
                foreach ($sql_omset as $omset){
                    $sql_kat    = $this->db->where('id', $omset->id_item_kat)->get('tbl_m_kategori')->row();
                    $sql_poli   = $this->db->where('id', $omset->id_poli)->get('tbl_m_poli')->row();
                    $sql_kary   = $this->db->where('id_user', $omset->id_dokter)->get('tbl_m_karyawan')->row();
                    
                    $total      = $total + $omset->subtotal;
                    $total_itm  = $total_itm + $omset->jml;
                    
                    $sheet->getStyle('A'.$cell.':B'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('C'.$cell.':F'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                    $sheet->getStyle('G'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('H'.$cell.':I'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                    $sheet->getStyle('J'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('K'.$cell.':M'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    $sheet->getStyle('K'.$cell.':M'.$cell)->getNumberFormat()->setFormatCode("_(\"\"* #,##0_);_(\"\"* \(#,##0\);_(\"\"* \"-\"??_);_(@_)");

                    $subtotal = $omset->harga * $omset->jml;
                    
                    $sheet->setCellValue('A'.$cell, $no)
                          ->setCellValue('B'.$cell, $this->tanggalan->tgl_indo($omset->tgl_simpan))
                          ->setCellValue('C'.$cell, $omset->pasien)
                          ->setCellValue('D'.$cell, general::status_rawat2($omset->tipe))
                          ->setCellValue('E'.$cell, $sql_poli->lokasi)
                          ->setCellValue('F'.$cell, (!empty($sql_kary->nama_dpn) ? $sql_kary->nama_dpn.' ' : '').(!empty($sql_kary->nama) ? $sql_kary->nama : '').(!empty($sql_kary->nama_blk) ? ', '.$sql_kary->nama_blk : ''))
                          ->setCellValue('G'.$cell, $omset->no_rm)
                          ->setCellValue('H'.$cell, general::tipe_item($omset->status))
                          ->setCellValue('I'.$cell, $omset->kode)
                          ->setCellValue('J'.$cell, $omset->item)
                          ->setCellValue('K'.$cell, $omset->jml)
                          ->setCellValue('L'.$cell, $omset->harga)
                          ->setCellValue('M'.$cell, $omset->subtotal);

                    $no++;
                    $cell++;
                }

                $sell1 = $cell + 1;
                $sell2 = $sell1 + 1;
                $sell3 = $sell2 + 1;
                
                $sheet->getStyle('A'.$sell1.':B'.$sell1)->getFont()->setBold(true);
                $sheet->getStyle('A'.$sell1)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('M'.$sell1)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->getStyle('M'.$sell1)->getNumberFormat()->setFormatCode("_(\"\"* #,##0_);_(\"\"* \(#,##0\);_(\"\"* \"-\"??_);_(@_)");
                $sheet->setCellValue('A'.$sell1, 'TOTAL OMSET')
                      ->mergeCells('A'.$sell1.':L'.$sell1)
                      ->setCellValue('M'.$sell1, $total);
                
                $sheet->getStyle('A'.$sell2.':B'.$sell2)->getFont()->setBold(true);
                $sheet->getStyle('A'.$sell2)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('C'.$sell2)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->getStyle('C'.$sell2)->getNumberFormat()->setFormatCode("_(\"\"* #,##0_);_(\"\"* \(#,##0\);_(\"\"* \"-\"??_);_(@_)");
                $sheet->setCellValue('A'.$sell2, 'TOTAL KUNJ PASIEN')
                      ->mergeCells('A'.$sell2.':B'.$sell2)
                      ->setCellValue('C'.$sell2, count($sql_omset))
                      ->mergeCells('C'.$sell2.':D'.$sell2);
                
                $sheet->getStyle('A'.$sell3.':B'.$sell3)->getFont()->setBold(true);
                $sheet->getStyle('A'.$sell3)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('C'.$sell3)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->getStyle('C'.$sell3)->getNumberFormat()->setFormatCode("_(\"\"* #,##0_);_(\"\"* \(#,##0\);_(\"\"* \"-\"??_);_(@_)");
                $sheet->setCellValue('A'.$sell3, 'TOTAL ITEM')
                      ->mergeCells('A'.$sell3.':B'.$sell3)
                      ->setCellValue('C'.$sell3, $total_itm)
                      ->mergeCells('C'.$sell3.':D'.$sell3);
            }

            // Rename worksheet
            $sheet->setTitle('Lap Omset');

            // Page Setup
            $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);
            $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);

            // Margins
            $sheet->getPageMargins()->setTop(0.25);
            $sheet->getPageMargins()->setRight(0);
            $sheet->getPageMargins()->setLeft(0);
            $sheet->getPageMargins()->setBottom(0);

            // Document properties
            $spreadsheet->getProperties()->setCreator("Mikhael Felian Waskito")
                        ->setLastModifiedBy($this->ion_auth->user()->row()->username)
                        ->setTitle("Stok")
                        ->setSubject("Aplikasi Bengkel POS")
                        ->setDescription("Kunjungi http://tigerasoft.co.id")
                        ->setKeywords("Pasifik POS")
                        ->setCategory("Untuk mencetak nota dot matrix");

            ob_end_clean();
            
            // Headers
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="data_omset_poli_'.(isset($_GET['filename']) ? $_GET['filename'] : 'lap').'.xls"');
            header('Expires: Mon, 15 Feb 1992 05:00:00 GMT');
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
            header('Cache-Control: cache, must-revalidate');
            header('Pragma: public');

            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
            $writer->save('php://output');
            exit;
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function xls_data_omset_detail(){
        if (akses::aksesLogin() == TRUE) {
            $jml        = $this->input->get('jml');
            $tgl        = $this->input->get('tgl');
            $tgl_awal   = $this->input->get('tgl_awal');
            $tgl_akhir  = $this->input->get('tgl_akhir');
            $tipe       = $this->input->get('tipe');
            $poli       = $this->input->get('poli');
            $status     = $this->input->get('status');
            $case       = $this->input->get('case');
            $hal        = $this->input->get('halaman');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $grup       = $this->ion_auth->get_users_groups()->row();
            $id_user    = $this->ion_auth->user()->row()->id;
            $id_grup    = $this->ion_auth->get_users_groups()->row();

            
            switch ($case) {
                case 'per_tanggal':
                    $sql_omset = $this->db->select('tmd.id AS id, tm.id AS id_medcheck, tm.id_pasien AS id_pasien, tm.id_poli AS id_poli, tm.id_dokter AS id_dokter, tmd.id_item AS id_item, tmd.id_item_kat AS id_item_kat, tmd.tgl_simpan AS tgl_simpan, tm.tgl_masuk AS tgl_masuk, tm.tgl_bayar AS tgl_bayar, tm.no_akun AS no_akun, tm.no_rm AS no_rm, mp.nama_pgl AS nama_pgl, mp.nama_pgl AS pasien, mp.tgl_lahir AS tgl_lahir, tmd.kode AS kode, tmd.item AS item, tmd.jml AS jml, tmd.harga AS harga, tmd.diskon AS diskon, tmd.potongan AS potongan, tmd.potongan_poin AS potongan_poin, tmd.subtotal AS subtotal, tm.jml_gtotal AS jml_gtotal, tmd.status_pkt AS status_pkt, tmd.status AS status, tm.tipe AS tipe, tm.tipe_bayar AS tipe_bayar, tm.metode AS metode')
                                      ->from('tbl_trans_medcheck_det tmd')
                                      ->join('tbl_trans_medcheck tm', 'tmd.id_medcheck = tm.id')
                                      ->join('tbl_m_pasien mp', 'tm.id_pasien = mp.id')
                                      ->where('tm.status_hps', '0')
                                      ->where('tm.status_bayar', '1')
                                      ->where('DATE(tmd.tgl_simpan)', $tgl)
                                      ->like('tm.id_poli', $poli, (!empty($poli) ? 'none' : ''))
                                      ->like('tm.tipe', $tipe, (!empty($tipe) ? 'none' : ''))
                                      ->like('tmd.status', $status, (!empty($status) ? 'none' : ''))
                                      ->order_by('tmd.id', 'DESC')
                                      ->get();
                    
                    $sql_omset_pas = $this->db->select('tmd.id AS id, tm.id AS id_medcheck, tm.id_pasien AS id_pasien, tm.id_poli AS id_poli, tm.id_dokter AS id_dokter, tmd.id_item AS id_item, tmd.id_item_kat AS id_item_kat, tmd.tgl_simpan AS tgl_simpan, tm.tgl_masuk AS tgl_masuk, tm.tgl_bayar AS tgl_bayar, tm.no_akun AS no_akun, tm.no_rm AS no_rm, mp.nama_pgl AS nama_pgl, mp.nama_pgl AS pasien, mp.tgl_lahir AS tgl_lahir, tmd.kode AS kode, tmd.item AS item, tmd.jml AS jml, tmd.harga AS harga, tmd.diskon AS diskon, tmd.potongan AS potongan, tmd.potongan_poin AS potongan_poin, tmd.subtotal AS subtotal, tm.jml_gtotal AS jml_gtotal, tmd.status_pkt AS status_pkt, tmd.status AS status, tm.tipe AS tipe, tm.tipe_bayar AS tipe_bayar, tm.metode AS metode')
                                          ->from('tbl_trans_medcheck_det tmd')
                                          ->join('tbl_trans_medcheck tm', 'tmd.id_medcheck = tm.id')
                                          ->join('tbl_m_pasien mp', 'tm.id_pasien = mp.id')
                                          ->where('tm.status_hps', '0')
                                          ->where('tm.status_bayar', '1')
                                          ->where('DATE(tmd.tgl_simpan)', $tgl)
                                          ->like('tm.id_poli', $poli, (!empty($poli) ? 'none' : ''))
                                          ->like('tm.tipe', $tipe, (!empty($tipe) ? 'none' : ''))
                                          ->like('tmd.status', $status, (!empty($status) ? 'none' : ''))
                                          ->group_by('mp.nama_pgl')
                                          ->order_by('tmd.id', 'DESC')
                                          ->get();
                    break;

                case 'per_rentang':
                    $sql_omset = $this->db->select('tmd.id AS id, tm.id AS id_medcheck, tm.id_pasien AS id_pasien, tm.id_poli AS id_poli, tm.id_dokter AS id_dokter, tmd.id_item AS id_item, tmd.id_item_kat AS id_item_kat, tmd.tgl_simpan AS tgl_simpan, tm.tgl_masuk AS tgl_masuk, tm.tgl_bayar AS tgl_bayar, tm.no_akun AS no_akun, tm.no_rm AS no_rm, mp.nama_pgl AS nama_pgl, mp.nama_pgl AS pasien, mp.tgl_lahir AS tgl_lahir, tmd.kode AS kode, tmd.item AS item, tmd.jml AS jml, tmd.harga AS harga, tmd.diskon AS diskon, tmd.potongan AS potongan, tmd.potongan_poin AS potongan_poin, tmd.subtotal AS subtotal, tm.jml_gtotal AS jml_gtotal, tmd.status_pkt AS status_pkt, tmd.status AS status, tm.tipe AS tipe, tm.tipe_bayar AS tipe_bayar, tm.metode AS metode')
                                      ->from('tbl_trans_medcheck_det tmd')
                                      ->join('tbl_trans_medcheck tm', 'tmd.id_medcheck = tm.id')
                                      ->join('tbl_m_pasien mp', 'tm.id_pasien = mp.id')
                                      ->where('tm.status_hps', '0')
                                      ->where('tm.status_bayar', '1')
                                      ->where('DATE(tmd.tgl_simpan) >=', $tgl_awal)
                                      ->where('DATE(tmd.tgl_simpan) <=', $tgl_akhir)
                                      ->like('tm.id_poli', $poli, (!empty($poli) ? 'none' : ''))
                                      ->like('tm.tipe', $tipe, (!empty($tipe) ? 'none' : ''))
                                      ->like('tmd.status', $status, (!empty($status) ? 'none' : ''))
                                      ->order_by('tmd.id', 'DESC')
                                      ->get();
                    
                    $sql_omset_pas = $this->db->select('tmd.id AS id, tm.id AS id_medcheck, tm.id_pasien AS id_pasien, tm.id_poli AS id_poli, tm.id_dokter AS id_dokter, tmd.id_item AS id_item, tmd.id_item_kat AS id_item_kat, tmd.tgl_simpan AS tgl_simpan, tm.tgl_masuk AS tgl_masuk, tm.tgl_bayar AS tgl_bayar, tm.no_akun AS no_akun, tm.no_rm AS no_rm, mp.nama_pgl AS nama_pgl, mp.nama_pgl AS pasien, mp.tgl_lahir AS tgl_lahir, tmd.kode AS kode, tmd.item AS item, tmd.jml AS jml, tmd.harga AS harga, tmd.diskon AS diskon, tmd.potongan AS potongan, tmd.potongan_poin AS potongan_poin, tmd.subtotal AS subtotal, tm.jml_gtotal AS jml_gtotal, tmd.status_pkt AS status_pkt, tmd.status AS status, tm.tipe AS tipe, tm.tipe_bayar AS tipe_bayar, tm.metode AS metode')
                                          ->from('tbl_trans_medcheck_det tmd')
                                          ->join('tbl_trans_medcheck tm', 'tmd.id_medcheck = tm.id')
                                          ->join('tbl_m_pasien mp', 'tm.id_pasien = mp.id')
                                          ->where('tm.status_hps', '0')
                                          ->where('tm.status_bayar', '1')
                                          ->where('DATE(tmd.tgl_simpan) >=', $tgl_awal)
                                          ->where('DATE(tmd.tgl_simpan) <=', $tgl_akhir)
                                          ->like('tm.id_poli', $poli, (!empty($poli) ? 'none' : ''))
                                          ->like('tm.tipe', $tipe, (!empty($tipe) ? 'none' : ''))
                                          ->like('tmd.status', $status, (!empty($status) ? 'none' : ''))
                                          ->group_by('mp.nama_pgl')
                                          ->order_by('tmd.id', 'DESC')
                                          ->get();
                    break;
            }

            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            
            // Header Tabel Nota
            $sheet->getStyle('A1:S4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A1:S4')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A1:S4')->getFont()->setBold(TRUE);

            $sheet->setCellValue('A1', 'LAPORAN OMSET DETAIL')
                  ->mergeCells('A1:J1');
            $sheet->setCellValue('A2', $pengaturan->judul)
                  ->mergeCells('A2:J2');

            $sheet->setCellValue('A4', 'No.')
                  ->setCellValue('B4', 'Tanggal')
                  ->setCellValue('C4', 'Tipe')
                  ->setCellValue('D4', 'Poli')
                  ->setCellValue('E4', 'Pasien')
                  ->setCellValue('F4', 'Item')
                  ->setCellValue('G4', 'Jumlah')
                  ->setCellValue('H4', 'Harga')
                  ->setCellValue('I4', 'Subtotal')
                  ->setCellValue('J4', 'Jenis');

            $sheet->getColumnDimension('A')->setWidth(6);
            $sheet->getColumnDimension('B')->setWidth(11);
            $sheet->getColumnDimension('C')->setWidth(11);
            $sheet->getColumnDimension('D')->setWidth(16);
            $sheet->getColumnDimension('E')->setWidth(40);
            $sheet->getColumnDimension('F')->setWidth(40);
            $sheet->getColumnDimension('G')->setWidth(8);
            $sheet->getColumnDimension('H')->setWidth(12);
            $sheet->getColumnDimension('I')->setWidth(15);
            $sheet->getColumnDimension('J')->setWidth(20);

            if(!empty($sql_omset)){
                $no         = 1;
                $cell       = 5;
                $total      = 0;
                $total_itm  = 0;
                foreach ($sql_omset->result() as $omset){
                    $total      = $total + $omset->subtotal;
                    $total_itm  = $total_itm + $omset->jml;
                    
                    $sheet->getStyle('A'.$cell.':B'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('C'.$cell.':F'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                    $sheet->getStyle('G'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('J'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                    $sheet->getStyle('H'.$cell.':I'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    $sheet->getStyle('H'.$cell.':I'.$cell)->getNumberFormat()->setFormatCode("_(\"\"* #,##0_);_(\"\"* \(#,##0\);_(\"\"* \"-\"??_);_(@_)");

                    $sheet->setCellValue('A'.$cell, $no)
                          ->setCellValue('B'.$cell, $this->tanggalan->tgl_indo($omset->tgl_simpan))
                          ->setCellValue('C'.$cell, general::status_rawat2($omset->tipe))
                          ->setCellValue('D'.$cell, $omset->poli)
                          ->setCellValue('E'.$cell, $omset->nama_pgl)
                          ->setCellValue('F'.$cell, $omset->item)
                          ->setCellValue('G'.$cell, $omset->jml)
                          ->setCellValue('H'.$cell, $omset->harga)
                          ->setCellValue('I'.$cell, $omset->subtotal)
                          ->setCellValue('J'.$cell, general::tipe_item($omset->status));

                    $no++;
                    $cell++;
                }

                $sell1     = $cell + 1;
                $sell2     = $sell1 + 1;
                $sell3     = $sell2 + 1;
                
                $sheet->getStyle('A'.$sell1.':B'.$sell1)->getFont()->setBold(TRUE);
                $sheet->getStyle('A'.$sell1)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('C'.$sell1)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->getStyle('C'.$sell1)->getNumberFormat()->setFormatCode("_(\"\"* #,##0_);_(\"\"* \(#,##0\);_(\"\"* \"-\"??_);_(@_)");
                $sheet->setCellValue('A'.$sell1, 'TOTAL OMSET')
                      ->mergeCells('A'.$sell1.':B'.$sell1)
                      ->setCellValue('C'.$sell1, $total)
                      ->mergeCells('C'.$sell1.':D'.$sell1);
                
                $sheet->getStyle('A'.$sell2.':B'.$sell2)->getFont()->setBold(TRUE);
                $sheet->getStyle('A'.$sell2)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('C'.$sell2)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->getStyle('C'.$sell2)->getNumberFormat()->setFormatCode("_(\"\"* #,##0_);_(\"\"* \(#,##0\);_(\"\"* \"-\"??_);_(@_)");
                $sheet->setCellValue('A'.$sell2, 'TOTAL KUNJ PASIEN')
                      ->mergeCells('A'.$sell2.':B'.$sell2)
                      ->setCellValue('C'.$sell2, $sql_omset_pas->num_rows())
                      ->mergeCells('C'.$sell2.':D'.$sell2);
            }

            // Rename worksheet
            $sheet->setTitle('Lap Omset');

            // Page Setup
            $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);
            $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);

            // Margins
            $sheet->getPageMargins()->setTop(0.25);
            $sheet->getPageMargins()->setRight(0);
            $sheet->getPageMargins()->setLeft(0);
            $sheet->getPageMargins()->setBottom(0);

            // Document properties
            $spreadsheet->getProperties()->setCreator("Mikhael Felian Waskito")
                        ->setLastModifiedBy($this->ion_auth->user()->row()->username)
                        ->setTitle("Stok")
                        ->setSubject("Aplikasi Bengkel POS")
                        ->setDescription("Kunjungi http://tigerasoft.co.id")
                        ->setKeywords("Pasifik POS")
                        ->setCategory("Untuk mencetak nota dot matrix");

            ob_end_clean();
            
            // Headers
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="data_omset_'.(isset($_GET['filename']) ? $_GET['filename'] : 'lap').'.xls"');
            header('Expires: Mon, 15 Feb 1992 05:00:00 GMT');
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
            header('Cache-Control: cache, must-revalidate');
            header('Pragma: public');

            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
            $writer->save('php://output');
            exit;
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function xls_data_omset_jasa(){
        if (akses::aksesLogin() == TRUE) {
            $jml        = $this->input->get('jml');
            $tgl        = $this->input->get('tgl');
            $tgl_awal   = $this->input->get('tgl_awal');
            $tgl_akhir  = $this->input->get('tgl_akhir');
            $case       = $this->input->get('case');
            $hal        = $this->input->get('halaman');
            $pasien_id  = $this->input->get('id_pasien');
            $pasien     = $this->input->get('pasien');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $grup       = $this->ion_auth->get_users_groups()->row();
            $id_user    = $this->ion_auth->user()->row()->id;
            $id_grup    = $this->ion_auth->get_users_groups()->row();

            
            switch ($case) {
                case 'per_tanggal':
                    $sql_omset = $this->db->select('tbl_trans_medcheck.id, tbl_trans_medcheck.tgl_simpan, tbl_trans_medcheck.tgl_masuk, tbl_trans_medcheck.no_akun, tbl_trans_medcheck.no_rm, tbl_trans_medcheck.no_nota, tbl_trans_medcheck.tipe, tbl_trans_medcheck.jml_gtotal, tbl_trans_medcheck.jml_bayar, tbl_trans_medcheck.jml_kembali, tbl_trans_medcheck.metode, tbl_trans_medcheck.status_bayar, tbl_trans_medcheck.tipe, tbl_m_pasien.nama_pgl, tbl_m_pasien.tgl_lahir, tbl_m_poli.lokasi, tbl_m_kategori.keterangan AS kategori, tbl_trans_medcheck_det.id AS id_medcheck_det, tbl_trans_medcheck_det.id_item, tbl_trans_medcheck_det.id_dokter, tbl_trans_medcheck_det.kode AS kode_item, tbl_trans_medcheck_det.item, tbl_trans_medcheck_det.resep, tbl_trans_medcheck_det.harga, tbl_trans_medcheck_det.jml, tbl_trans_medcheck_det.subtotal, tbl_trans_medcheck_det.resep, CONCAT(tbl_m_pasien.kode_dpn,\'\',tbl_m_pasien.kode) AS "kode_pasien"', false)
                                                              ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_det.id_medcheck')
                                                              ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
                                                              ->join('tbl_m_poli', 'tbl_m_poli.id=tbl_trans_medcheck.id_poli')
                                                              ->join('tbl_m_kategori', 'tbl_m_kategori.id=tbl_trans_medcheck_det.id_item_kat')
                                                              ->where('tbl_trans_medcheck.status_hps', '0')
                                                              ->where('tbl_trans_medcheck.status_bayar', '1')
                                                              ->where('DATE(tbl_trans_medcheck.tgl_bayar)', $tgl)
                                                              ->where('tbl_trans_medcheck_det.status', '2')
                                                              ->like('tbl_trans_medcheck.pasien', $pasien)
                                                ->get('tbl_trans_medcheck_det')->result();
                    break;

                case 'per_rentang':
                        $sql_omset     = $this->db->select('tbl_trans_medcheck.id, tbl_trans_medcheck.tgl_simpan, tbl_trans_medcheck.tgl_masuk, tbl_trans_medcheck.no_akun, tbl_trans_medcheck.no_rm, tbl_trans_medcheck.no_nota, tbl_trans_medcheck.tipe, tbl_trans_medcheck.jml_gtotal, tbl_trans_medcheck.jml_bayar, tbl_trans_medcheck.jml_kembali, tbl_trans_medcheck.metode, tbl_trans_medcheck.status_bayar, tbl_trans_medcheck.tipe, tbl_m_pasien.nama_pgl, tbl_m_pasien.tgl_lahir, tbl_m_poli.lokasi, tbl_m_kategori.keterangan AS kategori, tbl_trans_medcheck_det.id AS id_medcheck_det, tbl_trans_medcheck_det.id_item, tbl_trans_medcheck_det.id_dokter, tbl_trans_medcheck_det.kode AS kode_item, tbl_trans_medcheck_det.item, tbl_trans_medcheck_det.resep, tbl_trans_medcheck_det.harga, tbl_trans_medcheck_det.jml, tbl_trans_medcheck_det.subtotal, tbl_trans_medcheck_det.resep, CONCAT(tbl_m_pasien.kode_dpn,\'\',tbl_m_pasien.kode) AS "kode_pasien"', false)
                                                              ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_det.id_medcheck')
                                                              ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
                                                              ->join('tbl_m_poli', 'tbl_m_poli.id=tbl_trans_medcheck.id_poli')
                                                              ->join('tbl_m_kategori', 'tbl_m_kategori.id=tbl_trans_medcheck_det.id_item_kat')
                                                              ->where('tbl_trans_medcheck.status_hps', '0')
                                                              ->where('tbl_trans_medcheck.status_bayar', '1')
                                                              ->where('DATE(tbl_trans_medcheck.tgl_bayar) >=', $tgl_awal)
                                                              ->where('DATE(tbl_trans_medcheck.tgl_bayar) <=', $tgl_akhir)
                                                              ->where('tbl_trans_medcheck_det.status', '2')
                                                              ->like('tbl_trans_medcheck.pasien', $pasien)
                                                ->get('tbl_trans_medcheck_det')->result();
                    break;
            }

            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->setCellValue('A1', 'date')
                  ->setCellValue('B1', 'number')
                  ->setCellValue('C1', 'description')
                  ->setCellValue('D1', 'customer.code')
                  ->setCellValue('E1', 'orders[0].number')
                  ->setCellValue('F1', 'currency.code')
                  ->setCellValue('G1', 'exchange_rate')
                  ->setCellValue('H1', 'department.code')
                  ->setCellValue('I1', 'project.code')
                  ->setCellValue('J1', 'warehouse.code')
                  ->setCellValue('K1', 'line_items.product.code')
                  ->setCellValue('L1', 'line_items.account.code')
                  ->setCellValue('M1', 'line_items.unit.code')
                  ->setCellValue('N1', 'line_items.quantity')
                  ->setCellValue('O1', 'line_items.unit_price')
                  ->setCellValue('P1', 'line_items.discount.rate')
                  ->setCellValue('Q1', 'line_items.discount.amount')
                  ->setCellValue('R1', 'line_items.description')
                  ->setCellValue('S1', 'line_items.taxes[0].code')
                  ->setCellValue('T1', 'line_items.department.code')
                  ->setCellValue('U1', 'line_items.project.code')
                  ->setCellValue('V1', 'line_items.warehouse.code')
                  ->setCellValue('W1', 'line_items.note')
                  ->setCellValue('X1', 'payments[0].is_cash')
                  ->setCellValue('Y1', 'payments[0].account.code')
                  ->setCellValue('Z1', 'status')
                  ->setCellValue('AA1', 'term_of_payments[0].discount_days')
                  ->setCellValue('AB1', 'term_of_payments[0].due_date')
                  ->setCellValue('AC1', 'term_of_payments[0].due_days')
                  ->setCellValue('AD1', 'term_of_payments[0].early_discount_rate')
                  ->setCellValue('AE1', 'term_of_payments[0].late_charge_rate')
                  ->setCellValue('AF1', 'document.number')
                  ->setCellValue('AG1', 'document.date')
                  ->setCellValue('AH1', 'parent_memo.number')
                  ->setCellValue('AI1', 'employees[0].contact.code')
                  ->setCellValue('AJ1', 'delivery_dates')
                  ->setCellValue('AK1', 'others[0].amount_origin');
            
            $sheet->getColumnDimension('A')->setWidth(80);
            $sheet->getColumnDimension('B')->setWidth(100);
            $sheet->getColumnDimension('C')->setWidth(150);
            $sheet->getColumnDimension('D')->setWidth(120);
            $sheet->getColumnDimension('E')->setWidth(120);
            $sheet->getColumnDimension('F')->setWidth(120);
            $sheet->getColumnDimension('G')->setWidth(120);
            $sheet->getColumnDimension('H')->setWidth(120);
            $sheet->getColumnDimension('I')->setWidth(120);
            $sheet->getColumnDimension('J')->setWidth(120);
            $sheet->getColumnDimension('K')->setWidth(120);
            $sheet->getColumnDimension('L')->setWidth(120);
            $sheet->getColumnDimension('M')->setWidth(120);
            $sheet->getColumnDimension('N')->setWidth(120);
            $sheet->getColumnDimension('O')->setWidth(120);
            $sheet->getColumnDimension('P')->setWidth(120);
            $sheet->getColumnDimension('Q')->setWidth(120);
            $sheet->getColumnDimension('R')->setWidth(120);
            $sheet->getColumnDimension('S')->setWidth(120);
            $sheet->getColumnDimension('T')->setWidth(120);
            $sheet->getColumnDimension('U')->setWidth(120);
            $sheet->getColumnDimension('V')->setWidth(120);
            $sheet->getColumnDimension('W')->setWidth(120);
            $sheet->getColumnDimension('X')->setWidth(120);
            $sheet->getColumnDimension('Y')->setWidth(120);
            $sheet->getColumnDimension('Z')->setWidth(120);
            $sheet->getColumnDimension('AA')->setWidth(120);
            $sheet->getColumnDimension('AB')->setWidth(120);
            $sheet->getColumnDimension('AC')->setWidth(120);
            $sheet->getColumnDimension('AD')->setWidth(120);
            $sheet->getColumnDimension('AE')->setWidth(120);
            $sheet->getColumnDimension('AF')->setWidth(120);
            $sheet->getColumnDimension('AG')->setWidth(120);
            $sheet->getColumnDimension('AH')->setWidth(120);
            $sheet->getColumnDimension('AI')->setWidth(120);
            $sheet->getColumnDimension('AJ')->setWidth(120);
            $sheet->getColumnDimension('AK')->setWidth(120);

            if(!empty($sql_omset)){
                $no    = 1;
                $cell  = 5;
                $total = 0;
                foreach ($sql_omset as $omset){
                    $sql_plat = $this->db->select('tbl_trans_medcheck_plat.id, tbl_m_platform.platform AS metode, tbl_trans_medcheck_plat.platform, tbl_trans_medcheck_plat.keterangan, tbl_trans_medcheck_plat.nominal')
                                         ->where('tbl_trans_medcheck_plat.id_medcheck', $omset->id)
                                         ->join('tbl_m_platform', 'tbl_m_platform.id=tbl_trans_medcheck_plat.id_platform')
                                         ->get('tbl_trans_medcheck_plat');
                    
                    $plat_text = '';
                    foreach($sql_plat->result() as $plat){
                        $plat_text .= ($plat->id_platform == '1' ? 'CASH' : '').' ';
                    }

                    // Get doctor information
                    $dokter = $this->db->where('id_user', $omset->id_dokter)->get('tbl_m_karyawan')->row();
                    
                    // Get item information
                    $item = $this->db->where('id', $omset->id_item)->get('tbl_m_produk')->row();
                }
            }

            // Rename worksheet
            $sheet->setTitle('Lap Omset');

            // Page Setup
            $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);
            $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);

            // Margins
            $sheet->getPageMargins()->setTop(0.25);
            $sheet->getPageMargins()->setRight(0);
            $sheet->getPageMargins()->setLeft(0);
            $sheet->getPageMargins()->setBottom(0);

            // Document properties
            $spreadsheet->getProperties()->setCreator("Mikhael Felian Waskito")
                        ->setLastModifiedBy($this->ion_auth->user()->row()->username)
                        ->setTitle("Stok")
                        ->setSubject("Aplikasi Bengkel POS")
                        ->setDescription("Kunjungi http://tigerasoft.co.id")
                        ->setKeywords("Pasifik POS")
                        ->setCategory("Untuk mencetak nota dot matrix");

            ob_end_clean();
            
            // Headers
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="data_omset_'.(isset($_GET['filename']) ? $_GET['filename'] : 'lap').'.xls"');
            header('Expires: Mon, 15 Feb 1992 05:00:00 GMT');
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
            header('Cache-Control: cache, must-revalidate');
            header('Pragma: public');

            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
            $writer->save('php://output');
            exit;
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function xls_data_omset_backup(){
        if (akses::aksesLogin() == TRUE) {
            $jml        = $this->input->get('jml');
            $tgl        = $this->input->get('tgl');
            $tgl_awal   = $this->input->get('tgl_awal');
            $tgl_akhir  = $this->input->get('tgl_akhir');
            $case       = $this->input->get('case');
            $hal        = $this->input->get('halaman');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $grup       = $this->ion_auth->get_users_groups()->row();
            $id_user    = $this->ion_auth->user()->row()->id;
            $id_grup    = $this->ion_auth->get_users_groups()->row();

            
            switch ($case) {
                case 'per_tanggal':
                    $sql_omset = $this->db->select('tbl_trans_medcheck.id, tbl_trans_medcheck.tgl_simpan, tbl_trans_medcheck.no_rm, tbl_trans_medcheck.no_nota, tbl_trans_medcheck.tipe, tbl_trans_medcheck.jml_gtotal, tbl_trans_medcheck.jml_bayar, tbl_trans_medcheck.jml_kembali, tbl_trans_medcheck.status_bayar, tbl_trans_medcheck.tipe, tbl_m_pasien.nama_pgl, tbl_m_pasien.tgl_lahir, tbl_m_poli.lokasi, tbl_m_kategori.keterangan AS kategori, tbl_trans_medcheck_det.id AS id_medcheck_det, tbl_trans_medcheck_det.id_item, tbl_trans_medcheck_det.id_dokter, tbl_trans_medcheck_det.harga, tbl_trans_medcheck_det.jml, tbl_trans_medcheck_det.kode, tbl_trans_medcheck_det.item, tbl_trans_medcheck_det.subtotal, tbl_trans_medcheck_det.resep')
                                                              ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_det.id_medcheck')
                                                              ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
                                                              ->join('tbl_m_poli', 'tbl_m_poli.id=tbl_trans_medcheck.id_poli')
                                                              ->join('tbl_m_kategori', 'tbl_m_kategori.id=tbl_trans_medcheck_det.id_item_kat')
                                                              ->where('tbl_trans_medcheck.status_hps', '0')
                                                              ->where('tbl_trans_medcheck.status_bayar', '1')
                                                              ->where('DATE(tbl_trans_medcheck.tgl_bayar)', $tgl)
                                                ->get('tbl_trans_medcheck_det')->result();
                    break;

                case 'per_rentang':
                        $sql_omset     = $this->db->select('tbl_trans_medcheck.id, tbl_trans_medcheck.tgl_simpan, tbl_trans_medcheck.no_rm, tbl_trans_medcheck.no_nota, tbl_trans_medcheck.tipe, tbl_trans_medcheck.jml_gtotal, tbl_trans_medcheck.jml_bayar, tbl_trans_medcheck.jml_kembali, tbl_trans_medcheck.status_bayar, tbl_trans_medcheck.tipe, tbl_m_pasien.nama_pgl, tbl_m_pasien.tgl_lahir, tbl_m_poli.lokasi, tbl_m_kategori.keterangan AS kategori, tbl_trans_medcheck_det.id AS id_medcheck_det, tbl_trans_medcheck_det.id_item, tbl_trans_medcheck_det.id_dokter, tbl_trans_medcheck_det.harga, tbl_trans_medcheck_det.jml, tbl_trans_medcheck_det.kode, tbl_trans_medcheck_det.item, tbl_trans_medcheck_det.subtotal, tbl_trans_medcheck_det.resep')
                                                              ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_det.id_medcheck')
                                                              ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
                                                              ->join('tbl_m_poli', 'tbl_m_poli.id=tbl_trans_medcheck.id_poli')
                                                              ->join('tbl_m_kategori', 'tbl_m_kategori.id=tbl_trans_medcheck_det.id_item_kat')
                                                              ->where('tbl_trans_medcheck.status_hps', '0')
                                                              ->where('tbl_trans_medcheck.status_bayar', '1')
                                                              ->where('DATE(tbl_trans_medcheck.tgl_bayar) >=', $tgl_awal)
                                                              ->where('DATE(tbl_trans_medcheck.tgl_bayar) <=', $tgl_akhir)
                                                ->get('tbl_trans_medcheck_det')->result();
//
                        $sql_omset_row = $this->db->select('SUM(tbl_trans_medcheck_det.jml * tbl_trans_medcheck_det.harga) AS jml_gtotal')
                                                              ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_det.id_medcheck')
                                                              ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
                                                              ->join('tbl_m_poli', 'tbl_m_poli.id=tbl_trans_medcheck.id_poli')
                                                              ->join('tbl_m_kategori', 'tbl_m_kategori.id=tbl_trans_medcheck_det.id_item_kat')
                                                              ->where('tbl_trans_medcheck.status_hps', '0')
                                                              ->where('tbl_trans_medcheck.status_bayar', '1')
                                                              ->where('DATE(tbl_trans_medcheck.tgl_bayar) >=', $tgl_awal)
                                                              ->where('DATE(tbl_trans_medcheck.tgl_bayar) <=', $tgl_akhir)
                                                ->get('tbl_trans_medcheck_det')->row();
                    break;
            }

            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Header Tabel Nota
            $sheet->getStyle('A1:I1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A1:I1')->getFont()->setBold(TRUE);

            $sheet->setCellValue('A4', 'No.')
                    ->setCellValue('B4', 'Tgl')
                    ->setCellValue('C4', 'Pasien')
                    ->setCellValue('D4', 'Tipe')
                    ->setCellValue('E4', 'Dokter')
                    ->setCellValue('F4', 'No. Faktur')
                    ->setCellValue('G4', 'Qty')
                    ->setCellValue('H4', 'Kode')
                    ->setCellValue('I4', 'Item')
                    ->setCellValue('J4', 'Group')
                    ->setCellValue('K4', 'Harga')
                    ->setCellValue('L4', 'Subtotal')
                    ->setCellValue('M4', 'Jasa Dokter')
                    ->setCellValue('N4', 'Total Jasa');

            $sheet->getColumnDimension('A')->setWidth(6);
            $sheet->getColumnDimension('B')->setWidth(20);
            $sheet->getColumnDimension('C')->setWidth(65);
            $sheet->getColumnDimension('D')->setWidth(14);
            $sheet->getColumnDimension('E')->setWidth(50);
            $sheet->getColumnDimension('F')->setWidth(15);
            $sheet->getColumnDimension('G')->setWidth(10);
            $sheet->getColumnDimension('H')->setWidth(14);
            $sheet->getColumnDimension('I')->setWidth(45);
            $sheet->getColumnDimension('J')->setWidth(35);
            $sheet->getColumnDimension('K')->setWidth(14);
            $sheet->getColumnDimension('L')->setWidth(14);
            $sheet->getColumnDimension('M')->setWidth(14);
            $sheet->getColumnDimension('N')->setWidth(14);

            if(!empty($sql_omset)){
                $no    = 1;
                $cell  = 5;
                $total = 0;
                foreach ($sql_omset as $penjualan){
                    $remun   = $this->db->where('id_medcheck_det', $penjualan->id_medcheck_det)->get('tbl_trans_medcheck_remun')->row();
                    $dokter  = $this->db->where('id_user', $penjualan->id_dokter)->get('tbl_m_karyawan')->row();
                    $item    = $this->db->where('id', $penjualan->id_item)->get('tbl_m_produk')->row();
                    $remun_nom   = ($remun->remun_tipe == '2' ? $remun->remun_nom : (($remun->remun_perc / 100) * $penjualan->harga));
                    $total   = $total + $penjualan->subtotal;
                    $subtot  = $penjualan->harga * $penjualan->jml;

                    $sheet->getStyle('A'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('B'.$cell.':J'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                    $sheet->getStyle('K'.$cell.':N'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    $sheet->getStyle('K'.$cell.':N'.$cell)->getNumberFormat()->setFormatCode("_(\"\"* #,##0_);_(\"\"* \(#,##0\);_(\"\"* \"-\"??_);_(@_)");
                    $sheet->getStyle('I'.$cell)->getAlignment()->setWrapText(true);

                    $rsp = "\n";
                    foreach (json_decode($penjualan->resep) as $resep){
                        $rsp .= ' - '.$resep->item.' ['.$resep->jml.' '.$resep->satuan.']'."\n"; 
                    }
                    
                    $sheet->setCellValue('A'.$cell, $no)
                            ->setCellValue('B'.$cell, $this->tanggalan->tgl_indo5($penjualan->tgl_simpan))
                            ->setCellValue('C'.$cell, $penjualan->nama_pgl)
                            ->setCellValue('D'.$cell, general::status_rawat2($penjualan->tipe))
                            ->setCellValue('E'.$cell, $dokter->nama)
                            ->setCellValue('F'.$cell, $penjualan->no_rm)
                            ->setCellValue('G'.$cell, (float)$penjualan->jml)
                            ->setCellValue('H'.$cell, $item->kode)
                            ->setCellValue('I'.$cell, $penjualan->item.(!empty($penjualan->resep) ? $rsp : ''))
                            ->setCellValue('J'.$cell, $penjualan->kategori)
                            ->setCellValue('K'.$cell, $penjualan->harga)
                            ->setCellValue('L'.$cell, $subtot)
                            ->setCellValue('M'.$cell, $remun_nom)
                            ->setCellValue('N'.$cell, $remun->remun_subtotal);

                    $no++;
                    $cell++;
                }

                $sell1 = $cell;
                
                $sheet->getStyle('L'.$cell)->getNumberFormat()->setFormatCode("_(\"\"* #,##0_);_(\"\"* \(#,##0\);_(\"\"* \"-\"??_);_(@_)");
                $sheet->getStyle('A'.$sell1.':F'.$sell1)->getFont()->setBold(TRUE);
                $sheet->getStyle('A'.$sell1.':F'.$sell1)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->setCellValue('A' . $sell1, '')
                      ->mergeCells('A'.$sell1.':K'.$sell1)
                        ->setCellValue('L' . $sell1, $sql_omset_row->jml_gtotal);
            }

            // Rename worksheet
            $sheet->setTitle('Lap Omset');

            /** Page Setup * */
            $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);
            $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);

            /* -- Margin -- */
            $sheet->getPageMargins()->setTop(0.25);
            $sheet->getPageMargins()->setRight(0);
            $sheet->getPageMargins()->setLeft(0);
            $sheet->getPageMargins()->setBottom(0);

            /** Page Setup * */
            // Set document properties
            $spreadsheet->getProperties()->setCreator("Mikhael Felian Waskito")
                    ->setLastModifiedBy($this->ion_auth->user()->row()->username)
                    ->setTitle("Stok")
                    ->setSubject("Aplikasi Bengkel POS")
                    ->setDescription("Kunjungi http://tigerasoft.co.id")
                    ->setKeywords("Pasifik POS")
                    ->setCategory("Untuk mencetak nota dot matrix");

            ob_end_clean();
            // Redirect output to a client's web browser (Excel5)
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="data_omset_'.(isset($_GET['filename']) ? $_GET['filename'] : 'lap').'.xls"');

            // If you're serving to IE over SSL, then the following may be needed
            header('Expires: Mon, 15 Feb 1992 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0

            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
            $writer->save('php://output');
            exit;
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function csv_data_omset(){
        if (akses::aksesLogin() == TRUE) {
            $jml        = $this->input->get('jml');
            $tgl        = $this->input->get('tgl');
            $tgl_awal   = $this->input->get('tgl_awal');
            $tgl_akhir  = $this->input->get('tgl_akhir');
            $case       = $this->input->get('case');
            $hal        = $this->input->get('halaman');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $grup       = $this->ion_auth->get_users_groups()->row();
            $id_user    = $this->ion_auth->user()->row()->id;
            $id_grup    = $this->ion_auth->get_users_groups()->row();
            
            switch ($case) {
                case 'per_tanggal':
                    $sql_omset = $this->db->select('tbl_trans_medcheck.id, tbl_trans_medcheck.tgl_simpan, tbl_trans_medcheck.tgl_masuk, tbl_trans_medcheck.no_akun, tbl_trans_medcheck.no_rm, tbl_trans_medcheck.no_nota, tbl_trans_medcheck.tipe, tbl_trans_medcheck.jml_gtotal, tbl_trans_medcheck.jml_bayar, tbl_trans_medcheck.jml_kembali, tbl_trans_medcheck.metode, tbl_trans_medcheck.status_bayar, tbl_trans_medcheck.tipe, tbl_m_pasien.nama_pgl, tbl_m_pasien.tgl_lahir, tbl_m_poli.lokasi, tbl_m_kategori.keterangan AS kategori, tbl_trans_medcheck_det.id AS id_medcheck_det, tbl_trans_medcheck_det.id_item, tbl_trans_medcheck_det.id_dokter, tbl_trans_medcheck_det.kode AS kode_item, tbl_trans_medcheck_det.item, tbl_trans_medcheck_det.resep, tbl_trans_medcheck_det.harga, tbl_trans_medcheck_det.jml, tbl_trans_medcheck_det.subtotal, tbl_trans_medcheck_det.resep, CONCAT(tbl_m_pasien.kode_dpn,\'\',tbl_m_pasien.kode) AS "kode_pasien"', false)
                                                              ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_det.id_medcheck')
                                                              ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
                                                              ->join('tbl_m_poli', 'tbl_m_poli.id=tbl_trans_medcheck.id_poli')
                                                              ->join('tbl_m_kategori', 'tbl_m_kategori.id=tbl_trans_medcheck_det.id_item_kat')
                                                              ->where('tbl_trans_medcheck.status_hps', '0')
                                                              ->where('tbl_trans_medcheck.status_bayar', '1')
                                                              ->where('DATE(tbl_trans_medcheck.tgl_bayar)', $tgl)
                                                ->get('tbl_trans_medcheck_det')->result();
                    break;

                case 'per_rentang':
                        $sql_omset     = $this->db->select('tbl_trans_medcheck.id, tbl_trans_medcheck.tgl_simpan, tbl_trans_medcheck.tgl_masuk, tbl_trans_medcheck.no_akun, tbl_trans_medcheck.no_rm, tbl_trans_medcheck.no_nota, tbl_trans_medcheck.tipe, tbl_trans_medcheck.jml_gtotal, tbl_trans_medcheck.jml_bayar, tbl_trans_medcheck.jml_kembali, tbl_trans_medcheck.metode, tbl_trans_medcheck.status_bayar, tbl_trans_medcheck.tipe, tbl_m_pasien.nama_pgl, tbl_m_pasien.tgl_lahir, tbl_m_poli.lokasi, tbl_m_kategori.keterangan AS kategori, tbl_trans_medcheck_det.id AS id_medcheck_det, tbl_trans_medcheck_det.id_item, tbl_trans_medcheck_det.id_dokter, tbl_trans_medcheck_det.kode AS kode_item, tbl_trans_medcheck_det.item, tbl_trans_medcheck_det.resep, tbl_trans_medcheck_det.harga, tbl_trans_medcheck_det.jml, tbl_trans_medcheck_det.subtotal, tbl_trans_medcheck_det.resep, CONCAT(tbl_m_pasien.kode_dpn,\'\',tbl_m_pasien.kode) AS "kode_pasien"', false)
                                                              ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_det.id_medcheck')
                                                              ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
                                                              ->join('tbl_m_poli', 'tbl_m_poli.id=tbl_trans_medcheck.id_poli')
                                                              ->join('tbl_m_kategori', 'tbl_m_kategori.id=tbl_trans_medcheck_det.id_item_kat')
                                                              ->where('tbl_trans_medcheck.status_hps', '0')
                                                              ->where('tbl_trans_medcheck.status_bayar', '1')
                                                              ->where('DATE(tbl_trans_medcheck.tgl_bayar) >=', $tgl_awal)
                                                              ->where('DATE(tbl_trans_medcheck.tgl_bayar) <=', $tgl_akhir)
                                                ->get('tbl_trans_medcheck_det')->result();
                    break;
            }            
            
            $header1 = [
                'date',
                'number',
                'description',
                'customer.code',
                'orders[0].number',
                'currency.code',
                'exchange_rate',
                'department.code',
                'project.code',
                'warehouse.code',
                'line_items.product.code',
                'line_items.account.code',
                'line_items.unit.code',
                'line_items.quantity',
                'line_items.unit_price',
                'line_items.discount.rate',
                'line_items.discount.amount',
                'line_items.description',
                'line_items.taxes[0].code',
                'line_items.department.code',
                'line_items.project.code',
                'line_items.warehouse.code',
                'line_items.note',
                'payments[0].is_cash',
                'payments[0].account.code',
                'status',
                'term_of_payments[0].discount_days',
                'term_of_payments[0].due_date',
                'term_of_payments[0].due_days',
                'term_of_payments[0].early_discount_rate',
                'term_of_payments[0].late_charge_rate',
                'document.number',
                'document.date',
                'parent_memo.number',
                'employees[0].contact.code',
                'delivery_dates',
                'others[0].amount_origin'
            ];            
            $header2 = [
                'Transaction Date (Format: yyyy-mm-dd, Ex: 2020-01-30)',
                'Reference No.',
                'Description',	
                'Customer Code',
                'Order No',
                'Currency Code',
                'Exchange Rate', 
                'Department Code',
                'Project Code',	
                'Warhouse Code',
                'Item Product Code',
                'Item service (Account Code)',	
                'Item Unit Code',
                'Item Quantity','Item Price',
                'Item Discount',	
                'Item Discount Amount',	
                'Item Description',	
                'Item Tax Code',	
                'Item Department Code',	
                'Item Project Code','Item Warhouse Code',
                'Item Note',
                'Cash',	
                'Payment Account Cash',	
                'Status','Discount Days',
                'Due Date',	
                'Due Days',	
                'Early Discount Rate',	
                'Late Charge Rate',	
                'Document Number',	
                'Document Date',	
                'Salesman',	
                'Memo Of Credit / Debit',	
                'Delivery Date',	
                'Biaya Lain'
            ];
            
            # Set headers to force file download
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="sales-invoice-'.date('dmYH').'.csv"');
            
            # Open a new output stream for writing the CSV data
            $output = fopen('php://output', 'w');
            
            # Write CSV header row
            fputcsv($output, $header1);
            
            # Write CSV header row
            fputcsv($output, $header2);
            
            # Get Result From database
            if(!empty($sql_omset)){
                foreach ($sql_omset as $omset){
                    $sql_plat = $this->db->select('tbl_trans_medcheck_plat.id, tbl_m_platform.platform AS metode, tbl_trans_medcheck_plat.platform, tbl_trans_medcheck_plat.keterangan, tbl_trans_medcheck_plat.nominal')
                                        ->where('tbl_trans_medcheck_plat.id_medcheck', $omset->id)
                                        ->join('tbl_m_platform', 'tbl_m_platform.id=tbl_trans_medcheck_plat.id_platform')
                                        ->get('tbl_trans_medcheck_plat');
                    
                    $no_nota = strtoupper(date('M').date('d').date('y').'001');
                    
                    foreach($sql_plat->result() as $plat){
                        $plat = ($plat->id_platform == '1' ? 'CASH' : '').' ';
                        //$plat->metode
                    }
                    
                    $data = [
                        $this->tanggalan->tgl_indo7($omset->tgl_simpan),
                        $omset->no_akun,
                        $plat,
                        ($omset->metode == '1' ? 'UMUM' : ''),
                        '',
                        'IDR',
                        '1',
                        '99',
                        'N/A',
                        '99',
                        $omset->kode_item,
                        '',
                        (!empty($omset->satuan) ? strtolower(ucfirst($omset->satuan)) : 'Pcs'),
                        (float)$omset->jml,
                        (float)$omset->harga,
                        '',
                        '',
                        $omset->item,
                        '',
                        '99',
                        'N/A',
                        '99',
                        '',
                        ($omset->metode == '1' ? 'TRUE' : 'FALSE'),
                        '110099020',
                        'draft',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        $this->tanggalan->tgl_indo7($omset->tgl_masuk),
                        '',
                        '',
                        $this->tanggalan->tgl_indo7($omset->tgl_masuk)
                    ];
                    
                    # Tulis di file CSV-nya
                    fputcsv($output, $data);
                    
                    if(!empty($omset->resep)){
                        foreach (json_decode($omset->resep) as $resep){
                            $data_resep = [
                                $this->tanggalan->tgl_indo7($omset->tgl_simpan),
                                $no_nota,
                                $plat,
                                $omset->kode_pasien,
                                '',
                                'IDR',
                                '1',
                                '99',
                                'N/A',
                                '99',
                                $resep->kode,
                                '',
                                (!empty($resep->satuan) ? strtolower(ucfirst($resep->satuan)) : 'Pcs'),
                                (float) $resep->jml,
                                (float) $resep->harga,
                                '',
                                '',
                                $resep->item,
                                '',
                                '99',
                                'N/A',
                                '99',
                                '',
                                ($omset->metode == '1' ? 'TRUE' : 'FALSE'),
                                '110099020',
                                'draft',
                                '',
                                '',
                                '',
                                '',
                                '',
                                '',
                                $this->tanggalan->tgl_indo7($omset->tgl_masuk),
                                '',
                                '',
                                $this->tanggalan->tgl_indo7($omset->tgl_masuk)
                            ];
                            
                            # Tulis resep
                            fputcsv($output, $data_resep);
                        }
                    }
                }
            }
            
            # Close the output stream
            fclose($output);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function xls_data_stok(){
        if (akses::aksesLogin() == TRUE) {
            $jml        = $this->input->get('jml');
            $tipe       = $this->input->get('tipe');
            $stok       = $this->input->get('stok');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $grup       = $this->ion_auth->get_users_groups()->row();
            $id_user    = $this->ion_auth->user()->row()->id;
            $id_grup    = $this->ion_auth->get_users_groups()->row();

            
            switch ($tipe) {
                case '0' :
                    $sql_stok = $this->db
                                     ->where('status_subt', '0')
                                     ->where('status_hps', '0')
                                     ->get('tbl_m_produk')->result();
                    break;
                
                case '1' :
                    $sql_stok = $this->db
                                     ->where('status_subt', '1')
                                     ->where('status_hps', '0')
                                     ->get('tbl_m_produk')->result();
                    break;

                case '2' :
                    $sql_stok = $this->db
                                     ->where('status_hps', '0')
                                     ->get('tbl_m_produk')->result();
                    break;
            }
                            
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Header Tabel Nota
            $sheet->getStyle('A1:L1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A1:L1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A1:L1')->getFont()->setBold(TRUE);

            $sheet->setCellValue('A1', 'No.')
                  ->setCellValue('B1', 'Tgl')
                  ->setCellValue('C1', 'Kategori')
                  ->setCellValue('D1', 'Kode')
                  ->setCellValue('E1', 'Item')
                  ->setCellValue('F1', 'Jml')
                  ->setCellValue('G1', 'Harga')
                  ->setCellValue('H1', 'Nilai Stok')
                  ->setCellValue('I1', 'Remun Perc')
                  ->setCellValue('J1', 'Remun Nom')
                  ->setCellValue('K1', 'Apres Perc')
                  ->setCellValue('L1', 'Apres Nom');

            $sheet->getColumnDimension('A')->setWidth(6);
            $sheet->getColumnDimension('B')->setWidth(19);
            $sheet->getColumnDimension('C')->setWidth(20);
            $sheet->getColumnDimension('D')->setWidth(12);
            $sheet->getColumnDimension('E')->setWidth(50);
            $sheet->getColumnDimension('F')->setWidth(10);
            $sheet->getColumnDimension('G')->setWidth(20);
            $sheet->getColumnDimension('H')->setWidth(20);
            $sheet->getColumnDimension('I')->setWidth(20);
            $sheet->getColumnDimension('J')->setWidth(20);
            $sheet->getColumnDimension('K')->setWidth(20);
            $sheet->getColumnDimension('L')->setWidth(20);

            if(!empty($sql_stok)){
                $no    = 1;
                $cell  = 2;
                $total = 0;
                foreach ($sql_stok as $item){
                    $sql_kat    = $this->db->where('id', $item->id_kategori)->get('tbl_m_kategori')->row();
                    $subtot     = $item->harga_jual * $item->jml;
                    $total      = $total + $subtot;

                    $sheet->getStyle('A'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('B'.$cell.':E'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                    $sheet->getStyle('F'.$cell.':L'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    $sheet->getStyle('F'.$cell.':L'.$cell)->getNumberFormat()->setFormatCode("_(\"\"* #,##0_);_(\"\"* \(#,##0\);_(\"\"* \"-\"??_);_(@_)");
               
                    $sheet->setCellValue('A'.$cell, $no)
                          ->setCellValue('B'.$cell, $this->tanggalan->tgl_indo5($item->tgl_modif))
                          ->setCellValue('C'.$cell, $sql_kat->keterangan)
                          ->setCellValue('D'.$cell, $item->kode)
                          ->setCellValue('E'.$cell, $item->produk)
                          ->setCellValue('F'.$cell, (float)$item->jml)
                          ->setCellValue('G'.$cell, $item->harga_jual)
                          ->setCellValue('H'.$cell, $subtot)
                          ->setCellValue('I'.$cell, $item->remun_perc)
                          ->setCellValue('J'.$cell, $item->remun_nom)
                          ->setCellValue('K'.$cell, $item->apres_perc)
                          ->setCellValue('L'.$cell, $item->apres_nom);

                    $no++;
                    $cell++;
                }
            }

            // Rename worksheet
            $sheet->setTitle('Lap Stok');

            // Page Setup
            $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);
            $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);

            // Margins
            $sheet->getPageMargins()->setTop(0.25);
            $sheet->getPageMargins()->setRight(0);
            $sheet->getPageMargins()->setLeft(0);
            $sheet->getPageMargins()->setBottom(0);

            // Document properties
            $spreadsheet->getProperties()->setCreator("Mikhael Felian Waskito")
                        ->setLastModifiedBy($this->ion_auth->user()->row()->username)
                        ->setTitle("Stok")
                        ->setSubject("Aplikasi Bengkel POS")
                        ->setDescription("Kunjungi http://tigerasoft.co.id")
                        ->setKeywords("Pasifik POS")
                        ->setCategory("Untuk mencetak nota dot matrix");

            ob_end_clean();
            // Redirect output to a client's web browser
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="data_stok_'.(isset($_GET['filename']) ? $_GET['filename'] : 'lap').'.xlsx"');
            header('Cache-Control: max-age=0');

            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
            exit;
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function xls_data_stok2(){
        if (akses::aksesLogin() == TRUE) {
            $jml        = $this->input->get('jml');
            $tipe       = $this->input->get('tipe');
            $stok       = $this->input->get('stok');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $grup       = $this->ion_auth->get_users_groups()->row();
            $id_user    = $this->ion_auth->user()->row()->id;
            $id_grup    = $this->ion_auth->get_users_groups()->row();

            
            switch ($tipe) {
                case '0' :
                    $sql_stok = $this->db
                             ->where('status_subt', '1')
                             ->get('tbl_m_produk')->result();
                    break;
                
                case '1' :
                    $stp = '<';
                    $sql_stok = $this->db
                             ->where('status_subt', '1')
                             ->where('jml'.(isset($stp) ? ' '.$stp : ''), $stok)
                             ->get('tbl_m_produk')->result();
                    break;

                case '2' :
                    $sql_stok = $this->db
                             ->where('status_subt', '1')
                             ->where('jml'.(isset($stp) ? ' '.$stp : ''), $stok)
                             ->get('tbl_m_produk')->result();
                    break;

                case '3' :
                    $stp = '>=';
                    $sql_stok = $this->db
                             ->where('status_subt', '1')
                             ->where('jml'.(isset($stp) ? ' '.$stp : ''), $stok)
                             ->get('tbl_m_produk')->result();
                    break;
            }
                            
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Header Tabel Nota
            $sheet->getStyle('A4:G4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A4:G4')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A4:G4')->getFont()->setBold(TRUE);

            $sheet->setCellValue('A4', 'No.')
                  ->setCellValue('B4', 'Tgl')
                  ->setCellValue('C4', 'Kode')
                  ->setCellValue('D4', 'Item')
                  ->setCellValue('E4', 'Jml')
                  ->setCellValue('F4', 'Harga')
                  ->setCellValue('G4', 'Nilai Stok');

            $sheet->getColumnDimension('A')->setWidth(6);
            $sheet->getColumnDimension('B')->setWidth(19);
            $sheet->getColumnDimension('C')->setWidth(12);
            $sheet->getColumnDimension('D')->setWidth(50);
            $sheet->getColumnDimension('E')->setWidth(10);
            $sheet->getColumnDimension('F')->setWidth(20);
            $sheet->getColumnDimension('G')->setWidth(20);

            if(!empty($sql_stok)){
                $no    = 1;
                $cell  = 5;
                $total = 0;
                foreach ($sql_stok as $item){
                    $subtot     = $item->harga_jual * $item->jml;
                    $total      = $total + $subtot;

                    $sheet->getStyle('A'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('E'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('B'.$cell.':D'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                    $sheet->getStyle('F'.$cell.':G'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    $sheet->getStyle('F'.$cell.':G'.$cell)->getNumberFormat()->setFormatCode("_(\"\"* #,##0_);_(\"\"* \(#,##0\);_(\"\"* \"-\"??_);_(@_)");
               
                    $sheet->setCellValue('A'.$cell, $no)
                          ->setCellValue('B'.$cell, $this->tanggalan->tgl_indo5($item->tgl_modif))
                          ->setCellValue('C'.$cell, $item->kode)
                          ->setCellValue('D'.$cell, $item->produk)
                          ->setCellValue('E'.$cell, (float)$item->jml)
                          ->setCellValue('F'.$cell, $item->harga_jual)
                          ->setCellValue('G'.$cell, $subtot);

                    $no++;
                    $cell++;
                }
            }

            // Rename worksheet
            $sheet->setTitle('Lap Stok');

            // Page Setup
            $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);
            $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);

            // Margins
            $sheet->getPageMargins()->setTop(0.25);
            $sheet->getPageMargins()->setRight(0);
            $sheet->getPageMargins()->setLeft(0);
            $sheet->getPageMargins()->setBottom(0);

            // Document properties
            $spreadsheet->getProperties()->setCreator("Mikhael Felian Waskito")
                        ->setLastModifiedBy($this->ion_auth->user()->row()->username)
                        ->setTitle("Stok")
                        ->setSubject("Aplikasi Bengkel POS")
                        ->setDescription("Kunjungi http://tigerasoft.co.id")
                        ->setKeywords("Pasifik POS")
                        ->setCategory("Untuk mencetak nota dot matrix");

            ob_end_clean();
            // Redirect output to a client's web browser
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="data_stok_'.(isset($_GET['filename']) ? $_GET['filename'] : 'lap').'.xlsx"');
            header('Cache-Control: max-age=0');

            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
            exit;
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function csv_data_stok_gomed(){
        if (akses::aksesLogin() == TRUE) {
            $jml        = $this->input->get('jml');
            $tipe       = $this->input->get('tipe');
            $stok       = $this->input->get('stok');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $grup       = $this->ion_auth->get_users_groups()->row();
            $id_user    = $this->ion_auth->user()->row()->id;
            $id_grup    = $this->ion_auth->get_users_groups()->row();

            switch ($tipe) {
                case '1' :
                    $stp = '<';
                    break;

                case '2' :
                    $stp = '';
                    break;

                case '3' :
                    $stp = '>=';
                    break;
            }

            $sql_stok = $this->db
                            ->where('status', '4')
                            ->where('status_subt', '1')
                            ->where('jml' . (isset($stp) ? ' ' . $stp : ''), $stok)
                            ->where('harga_jual >', '0')
                            ->order_by('id', 'ASC')
                            ->get('tbl_m_produk')->result();

            // Set headers to force file download
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="combined_esensia_'.date('dmYH').'.csv"');

            # Open a new output stream for writing the CSV data
            $output = fopen('php://output', 'w');

            # Write CSV header row
            fputcsv($output, array('NO', 'TGL', 'KODE', 'ITEM', 'JML', 'HARGA', 'NILAI STOK'));

            # Ambil dari db
            $no    = 1;
            $cell  = 5;
            $total = 0;
            foreach ($sql_stok as $item){
                $subtot     = $item->harga_jual * $item->jml;
                $total      = $total + $subtot;   
                
                $data = array(
                    $no,
                    date('Y-m-d H:i'),
                    $item->kode,
                    $item->produk,
                    (float)$item->jml,
                    $item->harga_jual,
                    $subtot
                );
                
                fputcsv($output, $data);
                
                $no++;
            }
            
            # Close the output stream
            fclose($output);
            
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function xls_data_stok_gomed(){
        if (akses::aksesLogin() == TRUE) {
            $jml        = $this->input->get('jml');
            $tipe       = $this->input->get('tipe');
            $stok       = $this->input->get('stok');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $grup       = $this->ion_auth->get_users_groups()->row();
            $id_user    = $this->ion_auth->user()->row()->id;
            $id_grup    = $this->ion_auth->get_users_groups()->row();

            
                switch ($tipe) {
                    case '0' :
                        $sql_stok = $this->db
                                    ->where('status_subt', '1')
                                    ->order_by('id', 'ASC')
                                    ->get('tbl_m_produk')->result();
                        break;
                    
                    case '1' :
                        $stp = '<';
                        $sql_stok = $this->db
                                    ->where('status_subt', '1')
                                    ->where('jml' . (isset($stp) ? ' ' . $stp : ''), $stok)
                                    ->order_by('id', 'ASC')
                                    ->get('tbl_m_produk')->result();
                        break;

                    case '2' :
                        $stp = '';
                        $sql_stok = $this->db
                                    ->where('status_subt', '1')
                                    ->where('jml' . (isset($stp) ? ' ' . $stp : ''), $stok)
                                    ->order_by('id', 'ASC')
                                    ->get('tbl_m_produk')->result();
                        break;

                    case '3' :
                        $stp = '>=';
                        $sql_stok = $this->db
                                    ->where('status_subt', '1')
                                    ->where('jml' . (isset($stp) ? ' ' . $stp : ''), $stok)
                                    ->order_by('id', 'ASC')
                                    ->get('tbl_m_produk')->result();
                    break;
                }
            

            $objPHPExcel = new PHPExcel();

            // Header Tabel Nota
            $objPHPExcel->getActiveSheet()->getStyle('A4:G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A4:G4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A4:G4')->getFont()->setBold(TRUE);
//            $objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(40);

            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A4', 'Tgl')
                    ->setCellValue('B4', 'Kode')
                    ->setCellValue('C4', 'Item')
                    ->setCellValue('D4', 'Stok')
                    ->setCellValue('E4', 'Satuan Jual')
                    ->setCellValue('F4', 'Harga Jual')
                    ->setCellValue('G4', 'Nilai Stok');

            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);

            if(!empty($sql_stok)){
                $no    = 1;
                $cell  = 5;
                $total = 0;
                foreach ($sql_stok as $item){
                    $subtot     = $item->harga_jual * $item->jml;
                    $total      = $total + $subtot;

                    $objPHPExcel->getActiveSheet()->getStyle('A'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    $objPHPExcel->getActiveSheet()->getStyle('D'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('B'.$cell.':C'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    $objPHPExcel->getActiveSheet()->getStyle('E'.$cell.':G'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $objPHPExcel->getActiveSheet()->getStyle('E'.$cell.':G'.$cell)->getNumberFormat()->setFormatCode("_(\"\"* #,##0_);_(\"\"* \(#,##0\);_(\"\"* \"-\"??_);_(@_)");
               
                    $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A'.$cell, date('Y-m-d H:i'))
                            ->setCellValue('B'.$cell, $item->kode)
                            ->setCellValue('C'.$cell, $item->produk)
                            ->setCellValue('D'.$cell, (float)$item->jml)
                            ->setCellValue('E'.$cell, 'UNIT')
                            ->setCellValue('F'.$cell, $item->harga_jual)
                            ->setCellValue('G'.$cell, $subtot);

                    $no++;
                    $cell++;
                }

                $sell1     = $cell;
            }

            // Rename worksheet
            $objPHPExcel->getActiveSheet()->setTitle('Export GoMed');

            /** Page Setup * */
            $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
            $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

            /* -- Margin -- */
            $objPHPExcel->getActiveSheet()
                    ->getPageMargins()->setTop(0.25);
            $objPHPExcel->getActiveSheet()
                    ->getPageMargins()->setRight(0);
            $objPHPExcel->getActiveSheet()
                    ->getPageMargins()->setLeft(0);
            $objPHPExcel->getActiveSheet()
                    ->getPageMargins()->setFooter(0);


            /** Page Setup * */
            // Set document properties
            $objPHPExcel->getProperties()->setCreator("Mikhael Felian Waskito")
                    ->setLastModifiedBy($this->ion_auth->user()->row()->username)
                    ->setTitle("Stok")
                    ->setSubject("Aplikasi Bengkel POS")
                    ->setDescription("Kunjungi http://tigerasoft.co.id")
                    ->setKeywords("Pasifik POS")
                    ->setCategory("Untuk mencetak nota dot matrix");



            ob_end_clean();
            // Redirect output to a client’s web browser (Excel5)
            header('Content-Type: application/vnd.ms-excel');
            // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="combined_esensia_'.date('dmYH').'.xls"');

            // If you're serving to IE over SSL, then the following may be needed
            header('Expires: Mon, 15 Feb 1992 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0

            ob_clean();
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            exit;
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function xls_data_stok_keluar(){
        if (akses::aksesLogin() == TRUE) {
            $jml        = $this->input->get('jml');
            $tgl        = $this->input->get('tgl');
            $tgl_awal   = $this->input->get('tgl_awal');
            $tgl_akhir  = $this->input->get('tgl_akhir');
            $case       = $this->input->get('case');
            $hal        = $this->input->get('halaman');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $grup       = $this->ion_auth->get_users_groups()->row();
            $id_user    = $this->ion_auth->user()->row()->id;
            $id_grup    = $this->ion_auth->get_users_groups()->row();

            
            switch ($case) {
                case 'per_tanggal':
                    $sql_omset = $this->db->select('tbl_trans_medcheck.id, tbl_trans_medcheck.tgl_simpan, tbl_trans_medcheck.no_rm, tbl_trans_medcheck.no_nota, tbl_m_pasien.nama_pgl, tbl_m_pasien.tgl_lahir, tbl_trans_medcheck_det.id AS id_medcheck_det, tbl_trans_medcheck_det.kode, tbl_trans_medcheck_det.item, tbl_trans_medcheck_det.harga, tbl_trans_medcheck_det.jml, tbl_trans_medcheck_det.subtotal')
                                                              ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_det.id_medcheck')
                                                              ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
                                                              ->where('tbl_trans_medcheck.status_bayar', '1')
                                                              ->where('DATE(tbl_trans_medcheck_det.tgl_simpan)', $tgl)
                                                              ->where('tbl_trans_medcheck_det.status', '4')
                                                              ->order_by('DATE(tbl_trans_medcheck_det.tgl_simpan)', 'ASC')
                                                          ->get('tbl_trans_medcheck_det')->result(); 
                    break;

                case 'per_rentang':
                        $sql_omset     = $this->db->select('tbl_trans_medcheck.id, tbl_trans_medcheck.metode, tbl_trans_medcheck.no_rm, tbl_trans_medcheck.no_nota, tbl_trans_medcheck.tipe, tbl_m_pasien.nama_pgl, tbl_m_pasien.tgl_lahir, tbl_trans_medcheck_det.id AS id_medcheck_det, tbl_trans_medcheck_det.tgl_simpan, tbl_trans_medcheck_det.id_dokter, tbl_trans_medcheck_det.kode, tbl_trans_medcheck_det.item, tbl_trans_medcheck_det.harga, tbl_trans_medcheck_det.jml, tbl_trans_medcheck_det.satuan, tbl_trans_medcheck_det.subtotal, tbl_m_kategori.keterangan AS kategori')
                                                              ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_det.id_medcheck')
                                                              ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
                                                              ->join('tbl_m_kategori', 'tbl_m_kategori.id=tbl_trans_medcheck_det.id_item_kat')
                                                              ->where('tbl_trans_medcheck.status_hps', '0')
                                                              ->where('tbl_trans_medcheck.status_bayar', '1')
                                                              ->where('DATE(tbl_trans_medcheck_det.tgl_simpan) >=', $tgl_awal)
                                                              ->where('DATE(tbl_trans_medcheck_det.tgl_simpan) <=', $tgl_akhir)
                                                              ->where('tbl_trans_medcheck_det.status', '4')
                                                              ->order_by('tbl_trans_medcheck_det.tgl_simpan', 'ASC')
                                                          ->get('tbl_trans_medcheck_det')->result();
                    break;
            }

            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Header Tabel Nota
            $sheet->getStyle('A4:N4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A4:N4')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A4:N4')->getFont()->setBold(TRUE);
            $sheet->getRowDimension('4')->setRowHeight(40);

            $sheet->setCellValue('A4', 'No.')
                    ->setCellValue('B4', 'TGL')
                    ->setCellValue('C4', 'TIPE')
                    ->setCellValue('D4', 'ITEM')
                    ->setCellValue('E4', 'PASIEN')
                    ->setCellValue('F4', 'QTY')
                    ->setCellValue('G4', 'SATUAN')
                    ->setCellValue('H4', 'HARGA')
                    ->setCellValue('I4', 'SUBTOTAL');

            $sheet->getColumnDimension('A')->setWidth(6);
            $sheet->getColumnDimension('B')->setWidth(18);
            $sheet->getColumnDimension('C')->setWidth(14);
            $sheet->getColumnDimension('D')->setWidth(35);
            $sheet->getColumnDimension('E')->setWidth(50);
            $sheet->getColumnDimension('F')->setWidth(8);
            $sheet->getColumnDimension('G')->setWidth(10);
            $sheet->getColumnDimension('H')->setWidth(10);
            $sheet->getColumnDimension('I')->setWidth(10);
            $sheet->getColumnDimension('J')->setWidth(14);
            $sheet->getColumnDimension('K')->setWidth(14);
            $sheet->getColumnDimension('L')->setWidth(30);
            $sheet->getColumnDimension('M')->setWidth(14);
            $sheet->getColumnDimension('N')->setWidth(14);

            if(!empty($sql_omset)){
                $no    = 1;
                $cell  = 5;
                $total = 0;
                foreach ($sql_omset as $penjualan){
                    $sql_so     = $this->db->where('id_user', $penjualan->id_dokter)->get('tbl_m_karyawan')->row();
                    $dokter     = $this->db->where('id_user', $penjualan->id_dokter)->get('tbl_m_karyawan')->row();
                    $platform   = $this->db->where('id', $penjualan->metode)->get('tbl_m_platform')->row();
                    // Get remuneration data if needed
                    $remun      = $this->db->where('id_item', $penjualan->id_item)->get('tbl_m_remun')->row();
                    $sub_js     = isset($remun) ? $remun->remun_nom * $penjualan->jml : 0;
                    $total      = $total + $penjualan->subtotal;
                    $subtot     = $penjualan->harga * $penjualan->jml;

                    $sheet->getStyle('A'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('F'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('B'.$cell.':E'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                    $sheet->getStyle('H'.$cell.':I'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    $sheet->getStyle('L'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    $sheet->getStyle('H'.$cell.':I'.$cell)->getNumberFormat()->setFormatCode("_(\"\"* #,##0_);_(\"\"* \(#,##0\);_(\"\"* \"-\"??_);_(@_)");
               
                    $sheet->setCellValue('A'.$cell, $no)
                            ->setCellValue('B'.$cell, $this->tanggalan->tgl_indo5($penjualan->tgl_simpan))
                            ->setCellValue('C'.$cell, 'Stok Keluar')
                            ->setCellValue('D'.$cell, $penjualan->item)
                            ->setCellValue('E'.$cell, $penjualan->nama_pgl)
                            ->setCellValue('F'.$cell, (float)$penjualan->jml)
                            ->setCellValue('G'.$cell, $penjualan->satuan)
                            ->setCellValue('H'.$cell, $penjualan->harga)
                            ->setCellValue('I'.$cell, $penjualan->subtotal);

                    $no++;
                    $cell++;
                }

                $sell1 = $cell;
                
                $sheet->getStyle('I'.$sell1)->getNumberFormat()->setFormatCode("_(\"\"* #,##0_);_(\"\"* \(#,##0\);_(\"\"* \"-\"??_);_(@_)");
                $sheet->getStyle('A'.$sell1.':H'.$sell1.'')->getFont()->setBold(TRUE);
                $sheet->getStyle('A'.$sell1.':H'.$sell1)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->setCellValue('A'.$sell1, 'TOTAL');
                $sheet->mergeCells('A'.$sell1.':H'.$sell1.'');
                $sheet->setCellValue('I'.$sell1, $total);
            }

            // Rename worksheet
            $sheet->setTitle('Lap Omset');

            /** Page Setup * */
            $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);
            $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);

            /* -- Margin -- */
            $sheet->getPageMargins()->setTop(0.25);
            $sheet->getPageMargins()->setRight(0);
            $sheet->getPageMargins()->setLeft(0);
            $sheet->getPageMargins()->setBottom(0);

            /** Page Setup * */
            // Set document properties
            $spreadsheet->getProperties()->setCreator("Mikhael Felian Waskito")
                    ->setLastModifiedBy($this->ion_auth->user()->row()->username)
                    ->setTitle("Stok")
                    ->setSubject("Aplikasi Bengkel POS")
                    ->setDescription("Kunjungi http://tigerasoft.co.id")
                    ->setKeywords("Pasifik POS")
                    ->setCategory("Untuk mencetak nota dot matrix");

            ob_end_clean();
            // Redirect output to a client's web browser
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="data_stok_keluar_'.(isset($_GET['filename']) ? $_GET['filename'] : 'lap').'.xlsx"');
            header('Cache-Control: max-age=0');

            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
            exit;
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }



    public function xls_data_stok_keluar_laku(){
        if (akses::aksesLogin() == TRUE) {
            $jml        = $this->input->get('jml');
            $tgl        = $this->input->get('tgl');
            $tgl_awal   = $this->input->get('tgl_awal');
            $tgl_akhir  = $this->input->get('tgl_akhir');
            $case       = $this->input->get('case');
            $hal        = $this->input->get('halaman');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $grup       = $this->ion_auth->get_users_groups()->row();
            $id_user    = $this->ion_auth->user()->row()->id;
            $id_grup    = $this->ion_auth->get_users_groups()->row();

            
            switch ($case) {
                case 'per_tanggal':
                    $sql_omset = $this->db->select('tbl_trans_medcheck.id, tbl_trans_medcheck.tgl_simpan, tbl_trans_medcheck.no_rm, tbl_trans_medcheck.no_nota, tbl_trans_medcheck_det.id AS id_medcheck_det, tbl_trans_medcheck_det.kode, tbl_trans_medcheck_det.id_item, tbl_trans_medcheck_det.item, tbl_trans_medcheck_det.harga, SUM(tbl_trans_medcheck_det.jml) AS jml, tbl_trans_medcheck_det.subtotal')
                                                              ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_det.id_medcheck')
                                                              ->where('tbl_trans_medcheck.status_bayar', '1')
                                                              ->where('DATE(tbl_trans_medcheck_det.tgl_simpan)', $tgl)
                                                              ->where('tbl_trans_medcheck_det.status', '4')
                                                              ->group_by('tbl_trans_medcheck_det.id_item')
                                                              ->order_by('DATE(tbl_trans_medcheck_det.tgl_simpan)', 'ASC')
                                                          ->get('tbl_trans_medcheck_det')->result();
                    break;

                case 'per_rentang':
                        $sql_omset     = $this->db->select('tbl_trans_medcheck.id, tbl_trans_medcheck.metode, tbl_trans_medcheck.no_rm, tbl_trans_medcheck.no_nota, tbl_trans_medcheck.tipe, tbl_trans_medcheck_det.id AS id_medcheck_det, tbl_trans_medcheck_det.tgl_simpan, tbl_trans_medcheck_det.id_dokter, tbl_trans_medcheck_det.kode, tbl_trans_medcheck_det.id_item, tbl_trans_medcheck_det.item, tbl_trans_medcheck_det.harga, SUM(tbl_trans_medcheck_det.jml) AS jml, tbl_trans_medcheck_det.satuan, tbl_trans_medcheck_det.subtotal, tbl_m_kategori.keterangan AS kategori')
                                                  ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_det.id_medcheck')
                                                              ->join('tbl_m_kategori', 'tbl_m_kategori.id=tbl_trans_medcheck_det.id_item_kat')
                                                              ->where('tbl_trans_medcheck.status_hps', '0')
                                                              ->where('tbl_trans_medcheck.status_bayar', '1')
                                                              ->where('DATE(tbl_trans_medcheck_det.tgl_simpan) >=', $tgl_awal)
                                                              ->where('DATE(tbl_trans_medcheck_det.tgl_simpan) <=', $tgl_akhir)
                                                              ->where('tbl_trans_medcheck_det.status', '4')
                                                              ->group_by('tbl_trans_medcheck_det.id_item')
                                                              ->order_by('tbl_trans_medcheck_det.tgl_simpan', 'ASC')
                                                          ->get('tbl_trans_medcheck_det')->result();
                    break;
            }

            $objPHPExcel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $objPHPExcel->getActiveSheet();

            // Header Tabel Nota
            $sheet->getStyle('A1:H1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A1:H1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A1:H1')->getFont()->setBold(TRUE);
            $sheet->getRowDimension('1')->setRowHeight(40);

            $sheet->setCellValue('A1', 'No.')
                  ->setCellValue('B1', 'TGL')
                  ->setCellValue('C1', 'ITEM')
                  ->setCellValue('D1', 'QTY')
                  ->setCellValue('E1', 'SATUAN')
                  ->setCellValue('F1', 'HARGA BELI')
                  ->setCellValue('G1', 'HARGA JUAL')
                  ->setCellValue('H1', 'SUBTOTAL');

            $sheet->getColumnDimension('A')->setWidth(6);
            $sheet->getColumnDimension('B')->setWidth(18);
            $sheet->getColumnDimension('C')->setWidth(35);
            $sheet->getColumnDimension('D')->setWidth(8);
            $sheet->getColumnDimension('E')->setWidth(12);
            $sheet->getColumnDimension('F')->setWidth(15);
            $sheet->getColumnDimension('G')->setWidth(15);
            $sheet->getColumnDimension('H')->setWidth(16);

            // Enable auto filter
            $sheet->setAutoFilter('A1:H1');

            if(!empty($sql_omset)){
                $no    = 1;
                $cell  = 2;
                $total = 0;
                foreach ($sql_omset as $penjualan){
                    $sql_item   = $this->db->where('id', $penjualan->id_item)->get('tbl_m_produk')->row();
                    $sql_so     = $this->db->where('id_user', $penjualan->id_dokter)->get('tbl_m_karyawan')->row();
                    $dokter     = $this->db->where('id_user', $penjualan->id_dokter)->get('tbl_m_karyawan')->row();
                    $platform   = $this->db->where('id', $penjualan->metode)->get('tbl_m_platform')->row();
                    $total      = $total + $penjualan->subtotal;
                    $subtot     = $penjualan->harga * $penjualan->jml;

                    $sheet->getStyle('A'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('E'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('B'.$cell.':D'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                    $sheet->getStyle('G'.$cell.':H'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    $sheet->getStyle('G'.$cell.':H'.$cell)->getNumberFormat()->setFormatCode("_(\"\"* #,##0_);_(\"\"* \(#,##0\);_(\"\"* \"-\"??_);_(@_)");
               
                    $sheet->setCellValue('A'.$cell, $no)
                          ->setCellValue('B'.$cell, $this->tanggalan->tgl_indo5($penjualan->tgl_simpan))
                          ->setCellValue('C'.$cell, $penjualan->item)
                          ->setCellValue('D'.$cell, (float)$penjualan->jml)
                          ->setCellValue('E'.$cell, $penjualan->satuan)
                          ->setCellValue('F'.$cell, isset($sql_item->harga_beli) ? $sql_item->harga_beli : 0)
                          ->setCellValue('G'.$cell, $penjualan->harga)
                          ->setCellValue('H'.$cell, $subtot);

                    $no++;
                    $cell++;
                }

                $sell1 = $cell;
                
                // Add sort functionality
                $sheet->setAutoFilter($sheet->calculateWorksheetDimension());
                
                $sheet->getStyle('H'.$cell)->getNumberFormat()->setFormatCode("_(\"\"* #,##0_);_(\"\"* \(#,##0\);_(\"\"* \"-\"??_);_(@_)");
                $sheet->getStyle('A'.$sell1.':H'.$sell1.'')->getFont()->setBold(TRUE);
                $sheet->getStyle('A'.$sell1.':H'.$sell1)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->setCellValue('A' . $sell1, 'TOTAL')
                      ->mergeCells('A'.$sell1.':G'.$sell1.'')
                      ->setCellValue('H' . $sell1, $total);
            }

            // Rename worksheet
            $sheet->setTitle('Lap Obat Laku');

            /** Page Setup * */
            $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);
            $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);

            /* -- Margin -- */
            $sheet->getPageMargins()->setTop(0.25);
            $sheet->getPageMargins()->setRight(0);
            $sheet->getPageMargins()->setLeft(0);
            $sheet->getPageMargins()->setFooter(0);


            /** Page Setup * */
            // Set document properties
            $objPHPExcel->getProperties()->setCreator("Mikhael Felian Waskito")
                    ->setLastModifiedBy($this->ion_auth->user()->row()->username)
                    ->setTitle("Stok")
                    ->setSubject("Aplikasi Bengkel POS")
                    ->setDescription("Kunjungi http://tigerasoft.co.id")
                    ->setKeywords("Pasifik POS")
                    ->setCategory("Untuk mencetak nota dot matrix");


            // Redirect output to a client's web browser (Excel5)
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="data_stok_laku_'.(isset($_GET['filename']) ? $_GET['filename'] : 'lap').'.xls"');

            // If you're serving to IE over SSL, then the following may be needed
            header('Expires: Mon, 15 Feb 1992 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0
            
            ob_clean();
            $objWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($objPHPExcel, 'Xls');
            $objWriter->save('php://output');            
            exit;
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function xls_data_stok_mutasi(){
        if (akses::aksesLogin() == TRUE) {
            $jml        = $this->input->get('jml');
            $tgl        = $this->input->get('tgl');
            $tgl_awal   = $this->input->get('tgl_awal');
            $tgl_akhir  = $this->input->get('tgl_akhir');
            $case       = $this->input->get('case');
            $hal        = $this->input->get('halaman');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $grup       = $this->ion_auth->get_users_groups()->row();
            $id_user    = $this->ion_auth->user()->row()->id;
            $id_grup    = $this->ion_auth->get_users_groups()->row();

            
            switch ($case) {
                case 'per_tanggal':
                    $sql_stok  = $this->db->where('DATE(tgl_simpan)', $tgl)
                                          ->get('v_laporan_stok')->result(); 
                    break;

                case 'per_rentang':
                    $sql_stok  = $this->db->where('DATE(tgl_simpan) >=', $tgl_awal)
                                          ->where('DATE(tgl_simpan) <=', $tgl_akhir)
                                          ->get('v_laporan_stok')->result(); 
                    break;
            }

            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Header Tabel Nota
            $sheet->getStyle('A4:N4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A4:N4')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A4:N4')->getFont()->setBold(TRUE);
            $sheet->getRowDimension('4')->setRowHeight(40);

            $sheet->setCellValue('A4', 'No.')
                    ->setCellValue('B4', 'ITEM')
                    ->setCellValue('C4', 'STOK MASUK')
                    ->setCellValue('D4', 'STOK KELUAR')
                    ->setCellValue('E4', 'STOK SISA');

            $sheet->getColumnDimension('A')->setWidth(6);
            $sheet->getColumnDimension('B')->setWidth(35);
            $sheet->getColumnDimension('C')->setWidth(13);
            $sheet->getColumnDimension('D')->setWidth(13);
            $sheet->getColumnDimension('E')->setWidth(13);

            if(!empty($sql_stok)){
                $no    = 1;
                $cell  = 5;
                $total = 0;
                foreach ($sql_stok as $stok){
                    $sheet->getStyle('A'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('B'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                    $sheet->getStyle('C'.$cell.':E'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
//                    $sheet->getStyle('C'.$cell.':E'.$cell)->getNumberFormat()->setFormatCode("_(\"\"* #,##0_);_(\"\"* \(#,##0\);_(\"\"* \"-\"??_);_(@_)");

                    $sheet->setCellValue('A'.$cell, $no)
                            ->setCellValue('B'.$cell, $stok->item)
                            ->setCellValue('C'.$cell, $stok->stok)
                            ->setCellValue('D'.$cell, $stok->laku)
                            ->setCellValue('E'.$cell, $stok->sisa_stok);

                    $no++;
                    $cell++;
                }
            }

            // Rename worksheet
            $sheet->setTitle('Lap Stok Mutasi');

            /** Page Setup * */
            $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);
            $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);

            /* -- Margin -- */
            $sheet->getPageMargins()->setTop(0.25);
            $sheet->getPageMargins()->setRight(0);
            $sheet->getPageMargins()->setLeft(0);
            $sheet->getPageMargins()->setFooter(0);


            /** Page Setup * */
            // Set document properties
            $spreadsheet->getProperties()->setCreator("Mikhael Felian Waskito")
                    ->setLastModifiedBy($this->ion_auth->user()->row()->username)
                    ->setTitle("Stok")
                    ->setSubject("Aplikasi Bengkel POS")
                    ->setDescription("Kunjungi http://tigerasoft.co.id")
                    ->setKeywords("Pasifik POS")
                    ->setCategory("Untuk mencetak nota dot matrix");


            ob_end_clean();
            // Redirect output to a client's web browser (Excel5)
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="data_stok_mutasi_'.(isset($_GET['filename']) ? $_GET['filename'] : 'lap').'.xls"');

            // If you're serving to IE over SSL, then the following may be needed
            header('Expires: Mon, 15 Feb 1992 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0

            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
            $writer->save('php://output');
            exit;
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function xls_data_stok_keluar_resep(){
        if (akses::aksesLogin() == TRUE) {
            $jml        = $this->input->get('jml');
            $tgl        = $this->input->get('tgl');
            $tgl_awal   = $this->input->get('tgl_awal');
            $tgl_akhir  = $this->input->get('tgl_akhir');
            $dokter     = $this->input->get('dokter');
            $case       = $this->input->get('case');
            $hal        = $this->input->get('halaman');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $grup       = $this->ion_auth->get_users_groups()->row();
            $id_user    = $this->ion_auth->user()->row()->id;
            $id_grup    = $this->ion_auth->get_users_groups()->row();

            
            switch ($case) {
                case 'per_tanggal':
                    $sql_omset = $this->db->select('tbl_trans_medcheck.id, tbl_trans_medcheck.tipe_bayar, tbl_trans_medcheck.tgl_simpan, tbl_trans_medcheck.no_rm, tbl_trans_medcheck.no_nota, tbl_trans_medcheck.tipe, tbl_m_pasien.nama_pgl, tbl_m_pasien.tgl_lahir, tbl_m_pasien.alamat, tbl_m_pasien.alamat_dom, tbl_m_pasien.instansi, tbl_m_pasien.instansi_alamat, tbl_trans_medcheck_resep_det.kode, tbl_trans_medcheck_resep_det.item, tbl_trans_medcheck_resep_det.dosis, tbl_trans_medcheck_resep_det.dosis_ket, tbl_trans_medcheck_resep_det.keterangan, tbl_trans_medcheck_resep_det.harga, tbl_trans_medcheck_resep_det.jml, tbl_trans_medcheck_resep_det.satuan')
                                                        ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_resep_det.id_medcheck')
                                                        ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
                                                        ->join('tbl_m_kategori', 'tbl_m_kategori.id=tbl_trans_medcheck_resep_det.id_item_kat')
                                                        ->where('tbl_trans_medcheck.status_bayar', '1')
                                                        ->where('tbl_trans_medcheck_resep_det.id_user', general::dekrip($dokter))
                                                        ->where('DATE(tbl_trans_medcheck_resep_det.tgl_simpan)', $tgl)
                                                        ->order_by('tbl_trans_medcheck_resep_det.tgl_simpan', 'ASC')
                                                        ->get('tbl_trans_medcheck_resep_det')->result();
                    break;

                case 'per_rentang':
                        $sql_omset     = $this->db->select('tbl_trans_medcheck.id, tbl_trans_medcheck.tipe_bayar, tbl_trans_medcheck.tgl_simpan, tbl_trans_medcheck.no_rm, tbl_trans_medcheck.no_nota, tbl_trans_medcheck.tipe, tbl_m_pasien.nama_pgl, tbl_m_pasien.tgl_lahir, tbl_m_pasien.alamat, tbl_m_pasien.alamat_dom, tbl_m_pasien.instansi, tbl_m_pasien.instansi_alamat, tbl_trans_medcheck_resep_det.kode, tbl_trans_medcheck_resep_det.item, tbl_trans_medcheck_resep_det.dosis, tbl_trans_medcheck_resep_det.dosis_ket, tbl_trans_medcheck_resep_det.keterangan, tbl_trans_medcheck_resep_det.harga, tbl_trans_medcheck_resep_det.jml, tbl_trans_medcheck_resep_det.satuan')
                                                        ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_resep_det.id_medcheck')
                                                        ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
                                                        ->join('tbl_m_kategori', 'tbl_m_kategori.id=tbl_trans_medcheck_resep_det.id_item_kat')
                                                        ->where('tbl_trans_medcheck.status_bayar', '1')
                                                        ->where('tbl_trans_medcheck_resep_det.id_user', general::dekrip($dokter))
                                                        ->where('DATE(tbl_trans_medcheck_resep_det.tgl_simpan) >=', $tgl_awal)
                                                        ->where('DATE(tbl_trans_medcheck_resep_det.tgl_simpan) <=', $tgl_akhir)
                                                        ->order_by('tbl_trans_medcheck_resep_det.tgl_simpan', 'ASC')
                                                        ->get('tbl_trans_medcheck_resep_det')->result();
                    break;
            }
            
            $sql_dokter = $this->db->where('id_user', general::dekrip($dokter))->get('tbl_m_karyawan')->row();
            
            $judul = "LAPORAN PENGGUNAAN RESEP PER DOKTER";
            $ket = "";
            
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            
            // Header Laporan
            $sheet->getStyle("A1:I1")->getFont()->setSize(16);
            $sheet->getStyle('A1:I1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A1:I1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A1:I1')->getFont()->setBold(TRUE);
            
            $sheet->setCellValue('A1', $pengaturan->judul);
            $sheet->mergeCells('A1:I1');
            
            $sheet->getStyle("A2:I2")->getFont()->setSize(13);
            $sheet->getStyle('A2:I2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A2:I2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A2:I2')->getFont()->setBold(TRUE);
            $sheet->setCellValue('A2', $pengaturan->alamat);
            $sheet->mergeCells('A2:I2');
            
            $sheet->getStyle("A3:I3")->getFont()->setSize(13);
            $sheet->getStyle('A3:I3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A3:I3')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A3:I3')->getFont()->setBold(TRUE);
            $sheet->setCellValue('A3', $judul.' '.$ket);
            $sheet->mergeCells('A3:I3');
            
            $sheet->getStyle("A4:I4")->getFont()->setSize(14);
            $sheet->getStyle('A4:I4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A4:I4')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A4:I4')->getFont()->setBold(TRUE);
            $sheet->setCellValue('A4', (!empty($sql_dokter->nama_dpn) ? $sql_dokter->nama_dpn.' ' : '').strtoupper($sql_dokter->nama).(!empty($sql_dokter->nama_blk) ? ', '.$sql_dokter->nama_blk : ''));
            $sheet->mergeCells('A4:I4');

            // Header Tabel Nota
            $sheet->getStyle('A6:N6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A6:N6')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A6:N6')->getFont()->setBold(TRUE);
            $sheet->getRowDimension('6')->setRowHeight(36);

            $sheet->setCellValue('A6', 'No.')
                    ->setCellValue('B6', 'TGL')
                    ->setCellValue('C6', 'ID')
                    ->setCellValue('D6', 'PASIEN')
                    ->setCellValue('E6', 'ITEM')
                    ->setCellValue('F6', 'QTY')
                    ->setCellValue('G6', 'SATUAN')
                    ->setCellValue('H6', 'HARGA')
                    ->setCellValue('I6', 'SUBTOTAL');

            $sheet->getColumnDimension('A')->setWidth(6);
            $sheet->getColumnDimension('B')->setWidth(16);
            $sheet->getColumnDimension('C')->setWidth(15);
            $sheet->getColumnDimension('D')->setWidth(55);
            $sheet->getColumnDimension('E')->setWidth(45);
            $sheet->getColumnDimension('F')->setWidth(12);
            $sheet->getColumnDimension('G')->setWidth(14);
            $sheet->getColumnDimension('H')->setWidth(18);
            $sheet->getColumnDimension('I')->setWidth(18);

            if(!empty($sql_omset)){
                $no    = 1;
                $cell  = 7;
                $total = 0;
                foreach ($sql_omset as $penjualan){
                    $subtot = $penjualan->harga * $penjualan->jml;

                    $sheet->getStyle('A'.$cell.':C'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('D'.$cell.':G'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                    $sheet->getStyle('F'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('H'.$cell.':I'.$cell)->getNumberFormat()->setFormatCode("_(\"\"* #,##0_);_(\"\"* \(#,##0\);_(\"\"* \"-\"??_);_(@_)");
               
                    $sheet->setCellValue('A'.$cell, $no)
                            ->setCellValue('B'.$cell, $this->tanggalan->tgl_indo5($penjualan->tgl_simpan))
                            ->setCellValue('C'.$cell, $penjualan->no_rm)
                            ->setCellValue('D'.$cell, $penjualan->nama_pgl)
                            ->setCellValue('E'.$cell, $penjualan->item)
                            ->setCellValue('F'.$cell, (float)$penjualan->jml)
                            ->setCellValue('G'.$cell, $penjualan->satuan)
                            ->setCellValue('H'.$cell, $penjualan->harga)
                            ->setCellValue('I'.$cell, $subtot);

                    $no++;
                    $cell++;
                }

//                $sell1     = $cell;
//                
//                $sheet->getStyle('L'.$cell)->getNumberFormat()->setFormatCode("_(\"\"* #,##0_);_(\"\"* \(#,##0\);_(\"\"* \"-\"??_);_(@_)");
//                $sheet->getStyle('A'.$sell1.':F'.$sell1.'')->getFont()->setBold(TRUE);
//                $sheet->getStyle('A'.$sell1.':F'.$sell1)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
//                $sheet->setCellValue('A' . $sell1, '');
//                $sheet->mergeCells('A'.$sell1.':K'.$sell1.'');
//                $sheet->setCellValue('L' . $sell1, $sql_omset_row->jml_gtotal);
            }

            // Rename worksheet
            $sheet->setTitle('Lap Penggunaan Resep');

            /** Page Setup * */
            $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);
            $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);

            /* -- Margin -- */
            $sheet->getPageMargins()->setTop(0.25);
            $sheet->getPageMargins()->setRight(0);
            $sheet->getPageMargins()->setLeft(0);
            $sheet->getPageMargins()->setFooter(0);


            /** Page Setup * */
            // Set document properties
            $spreadsheet->getProperties()->setCreator("Mikhael Felian Waskito")
                    ->setLastModifiedBy($this->ion_auth->user()->row()->username)
                    ->setTitle("Stok")
                    ->setSubject("Aplikasi Bengkel POS")
                    ->setDescription("Kunjungi http://tigerasoft.co.id")
                    ->setKeywords("Pasifik POS")
                    ->setCategory("Untuk mencetak nota dot matrix");


            ob_end_clean();
            // Redirect output to a client's web browser (Excel5)
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="data_stok_keluar_resep_'.str_replace(' ', '', (!empty($sql_dokter->nama_dpn) ? $sql_dokter->nama_dpn.' ' : '').strtoupper($sql_dokter->nama).(!empty($sql_dokter->nama_blk) ? ', '.$sql_dokter->nama_blk : '')).'.xls"');

            // If you're serving to IE over SSL, then the following may be needed
            header('Expires: Mon, 15 Feb 1992 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0

            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
            $writer->save('php://output');
            exit;
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    public function xls_data_stok_telusur(){
        if (akses::aksesLogin() == TRUE) {
            $id         = $this->input->get('id');
            $jml        = $this->input->get('jml');
            $tgl        = $this->input->get('tgl');
            $tgl_awal   = $this->input->get('tgl_awal');
            $tgl_akhir  = $this->input->get('tgl_akhir');
            $case       = $this->input->get('act');
            $hal        = $this->input->get('halaman');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $grup       = $this->ion_auth->get_users_groups()->row();
            $id_user    = $this->ion_auth->user()->row()->id;
            $id_grup    = $this->ion_auth->get_users_groups()->row();

            
            switch ($case) {
                case 'per_tanggal':
                    $sql_stok     = $this->db
                                         ->where('id_produk', general::dekrip($id))
                                         ->where('DATE(tgl_masuk)', $tgl)
                                         ->group_by('tgl_simpan, id_penjualan, id_pembelian, id_pembelian_det, keterangan')
                                         ->order_by('tgl_simpan', 'desc')
                                         ->get('v_produk_hist')->result();
                    break;

                case 'per_rentang':
                    $sql_stok     = $this->db
                                         ->where('id_produk', general::dekrip($id))
                                         ->where('DATE(tgl_masuk) >=', $tgl_awal)
                                         ->where('DATE(tgl_masuk) <=', $tgl_akhir)
                                         ->group_by('tgl_simpan, id_penjualan, id_pembelian, id_pembelian_det, keterangan')
                                         ->order_by('tgl_simpan', 'desc')
                                         ->get('v_produk_hist')->result();
                    break;
            }

            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Header Tabel Nota
            $sheet->getStyle('A4:F4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A4:F4')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A4:F4')->getFont()->setBold(TRUE);
            $sheet->getRowDimension('4')->setRowHeight(40);

            $sheet->setCellValue('A4', 'No.')
                    ->setCellValue('B4', 'TGL')
                    ->setCellValue('C4', 'ITEM')
                    ->setCellValue('D4', 'KETERANGAN')
                    ->setCellValue('E4', 'STOK MASUK')
                    ->setCellValue('F4', 'STOK KELUAR');

            $sheet->getColumnDimension('A')->setWidth(6);
            $sheet->getColumnDimension('B')->setWidth(18);
            $sheet->getColumnDimension('C')->setWidth(50);
            $sheet->getColumnDimension('D')->setWidth(65);
            $sheet->getColumnDimension('E')->setWidth(15);
            $sheet->getColumnDimension('F')->setWidth(15);

            if(!empty($sql_stok)){
                $no    = 1;
                $cell  = 5;
                $total = 0;
                foreach ($sql_stok as $hist){
                    $sql_nota_dt = $this->db->where('id', $hist->id_pembelian_det)->get('tbl_trans_beli_det')->row();
                    
                    $sheet->setCellValue('A'.$cell, $no)
                            ->setCellValue('B'.$cell, $this->tanggalan->tgl_indo5($hist->tgl_masuk))
                            ->setCellValue('C'.$cell, $hist->produk)
                            ->setCellValue('D'.$cell, $hist->keterangan.(!empty($sql_nota_dt->kode_batch) ? ' / ['.$sql_nota_dt->kode_batch.']' : ''))
                            ->setCellValue('E'.$cell, ($hist->status == '1' || $hist->status == '2' || $hist->status == '6' ? (float)$hist->jml : '0'))
                            ->setCellValue('F'.$cell, ($hist->status == '4' ? (float)$hist->jml : '0'));

                    $no++;
                    $cell++;
                }
            }

            // Rename worksheet
            $sheet->setTitle('Lap Stok Telusur');

            /** Page Setup * */
            $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);
            $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);

            /* -- Margin -- */
            $sheet->getPageMargins()->setTop(0.25);
            $sheet->getPageMargins()->setRight(0);
            $sheet->getPageMargins()->setLeft(0);
            $sheet->getPageMargins()->setFooter(0);


            /** Page Setup * */
            // Set document properties
            $spreadsheet->getProperties()->setCreator("Mikhael Felian Waskito")
                    ->setLastModifiedBy($this->ion_auth->user()->row()->username)
                    ->setTitle("Stok")
                    ->setSubject("Aplikasi Bengkel POS")
                    ->setDescription("Kunjungi http://tigerasoft.co.id")
                    ->setKeywords("Pasifik POS")
                    ->setCategory("Untuk mencetak nota dot matrix");


            ob_end_clean();
            // Redirect output to a client's web browser (Excel5)
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="data_stok_riwayat_'.(isset($_GET['filename']) ? $_GET['filename'] : 'lap').'.xls"');

            // If you're serving to IE over SSL, then the following may be needed
            header('Expires: Mon, 15 Feb 1992 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0

            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
            $writer->save('php://output');
            exit;
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function xls_data_stok_pers(){
        if (akses::aksesLogin() == TRUE) {
            $id        = $this->input->get('id');
            $jml        = $this->input->get('jml');
            $tgl        = $this->input->get('tgl');
            $tgl_awal   = $this->input->get('tgl_awal');
            $tgl_akhir  = $this->input->get('tgl_akhir');
            $case       = $this->input->get('act');
            $hal        = $this->input->get('halaman');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $grup       = $this->ion_auth->get_users_groups()->row();
            $id_user    = $this->ion_auth->user()->row()->id;
            $id_grup    = $this->ion_auth->get_users_groups()->row();

            
            switch ($case) {
                case 'per_tanggal':
                    $sql_stok     = $this->db
                                         ->where('id_produk', general::dekrip($id))
                                         ->where('DATE(tgl_masuk)', $tgl)
                                         ->group_by('tgl_simpan, id_penjualan, id_pembelian, id_pembelian_det, keterangan')
                                         ->order_by('tgl_simpan', 'desc')
                                         ->get('v_produk_hist')->result();
                    break;

                case 'per_rentang':
                    $sql_stok     = $this->db
                                         ->where('id_produk', general::dekrip($id))
                                         ->where('DATE(tgl_masuk) >=', $tgl_awal)
                                         ->where('DATE(tgl_masuk) <=', $tgl_akhir)
                                         ->group_by('tgl_simpan, id_penjualan, id_pembelian, id_pembelian_det, keterangan')
                                         ->order_by('tgl_simpan', 'desc')
                                         ->get('v_produk_hist')->result();
                    break;
            }

            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Header Tabel Nota
            $sheet->getStyle('A4:N4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A4:N4')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A4:N4')->getFont()->setBold(TRUE);
            $sheet->getRowDimension('4')->setRowHeight(40);

            $sheet->setCellValue('A4', 'No.')
                    ->setCellValue('B4', 'TGL')
                    ->setCellValue('C4', 'ITEM')
                    ->setCellValue('D4', 'KETERANGAN')
                    ->setCellValue('E4', 'STOK MASUK')
                    ->setCellValue('F4', 'STOK KELUAR');

            $sheet->getColumnDimension('A')->setWidth(6);
            $sheet->getColumnDimension('B')->setWidth(18);
            $sheet->getColumnDimension('C')->setWidth(50);
            $sheet->getColumnDimension('D')->setWidth(65);
            $sheet->getColumnDimension('E')->setWidth(15);
            $sheet->getColumnDimension('F')->setWidth(15);

            if(!empty($sql_stok)){
                $no    = 1;
                $cell  = 5;
                $total = 0;
                foreach ($sql_stok as $hist){
                    $sql_nota_dt = $this->db->where('id', $hist->id_pembelian_det)->get('tbl_trans_beli_det')->row();
                    
                    $sheet->setCellValue('A'.$cell, $no)
                            ->setCellValue('B'.$cell, $this->tanggalan->tgl_indo5($hist->tgl_masuk))
                            ->setCellValue('C'.$cell, $hist->produk)
                            ->setCellValue('D'.$cell, $hist->keterangan.(!empty($sql_nota_dt->kode_batch) ? ' / ['.$sql_nota_dt->kode_batch.']' : ''))
                            ->setCellValue('E'.$cell, ($hist->status == '1' || $hist->status == '2' || $hist->status == '6' ? (float)$hist->jml : '0'))
                            ->setCellValue('F'.$cell, ($hist->status == '4' ? (float)$hist->jml : '0'));

                    $no++;
                    $cell++;
                }
            }

            // Rename worksheet
            $sheet->setTitle('Lap Omset');

            /** Page Setup * */
            $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);
            $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);

            /* -- Margin -- */
            $sheet->getPageMargins()->setTop(0.25);
            $sheet->getPageMargins()->setRight(0);
            $sheet->getPageMargins()->setLeft(0);
            $sheet->getPageMargins()->setFooter(0);


            /** Page Setup * */
            // Set document properties
            $spreadsheet->getProperties()->setCreator("Mikhael Felian Waskito")
                    ->setLastModifiedBy($this->ion_auth->user()->row()->username)
                    ->setTitle("Stok")
                    ->setSubject("Aplikasi Bengkel POS")
                    ->setDescription("Kunjungi http://tigerasoft.co.id")
                    ->setKeywords("Pasifik POS")
                    ->setCategory("Untuk mencetak nota dot matrix");


            ob_end_clean();
            // Redirect output to a client's web browser (Excel5)
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="data_stok_riwayat_'.(isset($_GET['filename']) ? $_GET['filename'] : 'lap').'.xls"');

            // If you're serving to IE over SSL, then the following may be needed
            header('Expires: Mon, 15 Feb 1992 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0

            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
            $writer->save('php://output');
            exit;
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function xls_data_pasien(){
        if (akses::aksesLogin() == TRUE) {
            $jml        = $this->input->get('jml');
            $tgl        = $this->input->get('tgl');
            $bln        = $this->input->get('bln');
            $bulan      = $this->input->get('bulan');
            $case       = $this->input->get('case');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();
            
            switch ($case) {
                case 'per_tanggal':
                    // Format day and month with leading zeros if needed
                    $tgl = sprintf('%02d', $tgl);
                    $bln = sprintf('%02d', $bln);
                    
                    // Get the search date from the input (format: DD-MM)
                    $search_date = $this->input->get('tgl');
                    if (!empty($search_date) && strpos($search_date, '-') !== false) {
                        $date_parts = explode('-', $search_date);
                        if (count($date_parts) >= 2) {
                            $tgl = sprintf('%02d', $date_parts[0]);
                            $bln = sprintf('%02d', $date_parts[1]);
                        }
                    }
                    
                    $sql_pasien = $this->db->select('tbl_m_pasien.id, tbl_m_pasien.kode_dpn, tbl_m_pasien.kode, tbl_m_pasien.nama, tbl_m_pasien.no_hp, tbl_m_pasien.tgl_lahir, DAY(tbl_m_pasien.tgl_lahir) AS hari, MONTH(tbl_m_pasien.tgl_lahir) AS bulan')
                                          ->where('tbl_m_pasien.no_hp !=', '')
                                          ->where('DAY(tbl_m_pasien.tgl_lahir)', $tgl)
                                          ->where('MONTH(tbl_m_pasien.tgl_lahir)', $bln)
                                          ->order_by('tbl_m_pasien.nama', 'ASC') 
                                          ->get('tbl_m_pasien')->result();
                    break;
                    
                case 'per_bulan':
                    $sql_pasien = $this->db->select('tbl_m_pasien.id, tbl_m_pasien.kode_dpn, tbl_m_pasien.kode, tbl_m_pasien.nama, tbl_m_pasien.no_hp, tbl_m_pasien.tgl_lahir, DAY(tbl_m_pasien.tgl_lahir) AS hari, MONTH(tbl_m_pasien.tgl_lahir) AS bulan')
                                          ->where('tbl_m_pasien.no_hp !=', '')
                                          ->where('MONTH(tbl_m_pasien.tgl_lahir)', $bulan)
                                          ->order_by('tbl_m_pasien.nama', 'ASC') 
                                          ->get('tbl_m_pasien')->result();
                    break;
            }

            // Create new Spreadsheet object
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Set header styles
            $sheet->getStyle('A1:N1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A1:N1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A1:N1')->getFont()->setBold(true);

            // Set headers
            $sheet->setCellValue('A1', 'Whatsapp Number')
                  ->setCellValue('B1', 'Name')
                  ->setCellValue('C1', 'Col1')
                  ->setCellValue('D1', 'Tgl Lahir')
                  ->setCellValue('E1', 'Col3');

            // Set column widths
            $sheet->getColumnDimension('A')->setWidth(18);
            $sheet->getColumnDimension('B')->setWidth(55);
            $sheet->getColumnDimension('C')->setWidth(14);
            $sheet->getColumnDimension('D')->setWidth(12);
            $sheet->getColumnDimension('E')->setWidth(10);

            // Fill data
            if(!empty($sql_pasien)){
                $no    = 1;
                $cell  = 2;
                foreach ($sql_pasien as $pasien){
                    $sheet->getStyle('A'.$cell)->getNumberFormat()->setFormatCode('#');
                    $sheet->getStyle('A'.$cell.':C'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                    $sheet->getStyle('D'.$cell.':E'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                    $sheet->setCellValue('A'.$cell, (!empty($pasien->no_hp) ? "62".substr($pasien->no_hp, 1) : ''))
                          ->setCellValue('B'.$cell, $pasien->nama)
                          ->setCellValue('C'.$cell, $this->tanggalan->bulan_ke($pasien->bulan))
                          ->setCellValue('D'.$cell, $this->tanggalan->tgl_indo8($pasien->tgl_lahir))
                          ->setCellValue('E'.$cell, $pasien->bulan);

                    $no++;
                    $cell++;
                }
            }

            // Rename worksheet
            $sheet->setTitle('Data Pasien');

            // Page setup
            $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);
            $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);

            // Margins
            $sheet->getPageMargins()->setTop(0.25);
            $sheet->getPageMargins()->setRight(0);
            $sheet->getPageMargins()->setLeft(0);
            $sheet->getPageMargins()->setBottom(0);

            // Document properties
            $spreadsheet->getProperties()->setCreator("Mikhael Felian Waskito")
                        ->setLastModifiedBy($this->ion_auth->user()->row()->username)
                        ->setTitle("Data Pasien")
                        ->setSubject("Data Pasien WA")
                        ->setDescription("Kunjungi http://tigerasoft.co.id");

            // Clean output buffer
            ob_end_clean();

            // Set headers for download
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="data_pasien_wa_lap.xlsx"');
            header('Cache-Control: max-age=0');

            // Create Excel writer and output file
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
            exit;
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function xls_data_pasien_st() {
        if (akses::aksesLogin() == TRUE) {
            // Ambil parameter dari URL
            $jml        = $this->input->get('jml');
            $tgl        = $this->input->get('tgl');
            $tgl_awal   = $this->input->get('tgl_awal');
            $tgl_akhir  = $this->input->get('tgl_akhir');
            $statusPas  = $this->input->get('status_pas');
            $case       = $this->input->get('case');

            // Pilih data berdasarkan filter
            switch ($case) {
                case 'per_tanggal':
                    $this->db->from("v_pasien");
                    $this->db->where("DATE(tgl_simpan)", $tgl);
                    if ($statusPas == "1") {
                        $this->db->where("jumlah", '1'); // Pasien Baru
                    } elseif ($statusPas == "2") {
                        $this->db->where("jumlah >", '1'); // Pasien Lama
                    }
                    break;

                case 'per_rentang':
                    $this->db->from("v_pasien");
                    $this->db->where("DATE(tgl_simpan) >=", $tgl_awal);
                    $this->db->where("DATE(tgl_simpan) <=", $tgl_akhir);
                    if ($statusPas == "1") {
                        $this->db->where("jumlah", '1'); // Pasien Baru
                    } elseif ($statusPas == "2") {
                        $this->db->where("jumlah >", '1'); // Pasien Lama
                    }
                    break;
                    
                default:
                    $this->db->from("v_pasien");
                    break;
            }

            $query = $this->db->get();
            $sql_pasien = $query->result();

            // Load PhpSpreadsheet
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Header Tabel
            $sheet->setCellValue('A1', 'No')
                  ->setCellValue('B1', 'No. RM')
                  ->setCellValue('C1', 'Pasien')
                  ->setCellValue('D1', 'Alamat')
                  ->setCellValue('E1', 'Tgl Lahir')
                  ->setCellValue('F1', 'No. HP');

            // Set Lebar Kolom
            $sheet->getColumnDimension('A')->setWidth(5);
            $sheet->getColumnDimension('B')->setWidth(15);
            $sheet->getColumnDimension('C')->setWidth(35);
            $sheet->getColumnDimension('D')->setWidth(55);
            $sheet->getColumnDimension('E')->setWidth(15);
            $sheet->getColumnDimension('F')->setWidth(15);

            // Set Style Header
            $sheet->getStyle("A1:F1")->getFont()->setBold(true);
            $sheet->getStyle("A1:F1")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            // Isi Data Pasien
            $cell = 2;
            $no = 1;

            foreach ($sql_pasien as $pasien) {
                $sheet->setCellValue('A' . $cell, $no++)
                      ->setCellValue('B' . $cell, $pasien->kode_pasien)
                      ->setCellValue('C' . $cell, $pasien->pasien)
                      ->setCellValue('D' . $cell, $pasien->alamat)
                      ->setCellValue('E' . $cell, $this->tanggalan->tgl_indo2($pasien->tgl_lahir))
                      ->setCellValue('F' . $cell, (!empty($pasien->no_hp) ? "62" . substr($pasien->no_hp, 1) : ''));
                $cell++;
            }

            // Set Nama Sheet
            $sheet->setTitle('Data Pasien');

            // Tentukan nama file berdasarkan status pasien
            $filename = "data_pasien";
            if ($statusPas == "1") {
                $filename .= "_baru.xlsx"; // Jika pasien baru
            } elseif ($statusPas == "2") {
                $filename .= "_lama.xlsx"; // Jika pasien lama
            } else {
                $filename .= ".xlsx"; // Default tanpa status
            }

            // Set Format Header
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');

            // Simpan ke output
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            ob_end_clean(); // Menghindari error karena output buffering
            $writer->save('php://output');
            exit;
        } else {
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function xls_data_pasien_kunj(){
        if (akses::aksesLogin() == TRUE) {
            $jml        = $this->input->get('jml');
            $tgl        = $this->input->get('tgl');
            $tgl_awal   = $this->input->get('tgl_awal');
            $tgl_akhir  = $this->input->get('tgl_akhir');
            $tipe       = $this->input->get('tipe');
            $poli       = $this->input->get('poli');
            $case       = $this->input->get('case');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();
            
            switch ($case){                
                case 'per_tanggal':
                    $sql_pasien = $this->db->select('tm.id, tm.id AS id_medcheck, tm.id_pasien, tm.id_poli, tm.tgl_bayar AS tgl_simpan, tm.tgl_masuk, mp.lokasi AS poli, tm.no_rm, tm.uuid AS kode, tm.pasien AS nama, mpas.tgl_lahir, tm.jml_gtotal, tm.tipe, tm.status_bayar, COUNT(tm.id_pasien) AS jml_kunjungan, SUM(tm.jml_gtotal) AS jml_gtotal')
                                           ->from('tbl_trans_medcheck tm')
                                           ->join('tbl_m_poli mp', 'tm.id_poli = mp.id', 'left')
                                           ->join('tbl_m_pasien mpas', 'tm.id_pasien = mpas.id', 'left')
                                           ->where('DATE(tm.tgl_bayar)', $tgl)
                                           ->like('tm.id_poli', $poli, (!empty($poli) ? 'none' : ''))
                                           ->like('tm.tipe', $tipe, (!empty($tipe) ? 'none' : ''))
                                           ->group_by('tm.tipe, tm.id_pasien')
                                           ->order_by('COUNT(tm.id_pasien)', 'desc')
                                           ->get()->result();
                    break;

                case 'per_rentang':
                    $sql_pasien = $this->db->select('tm.id, tm.id AS id_medcheck, tm.id_pasien, tm.id_poli, tm.tgl_bayar AS tgl_simpan, tm.tgl_masuk, mp.lokasi AS poli, tm.no_rm, tm.uuid AS kode, tm.pasien AS nama, mpas.tgl_lahir, tm.jml_gtotal, tm.tipe, tm.status_bayar, COUNT(tm.id_pasien) AS jml_kunjungan, SUM(tm.jml_gtotal) AS jml_gtotal')
                                           ->from('tbl_trans_medcheck tm')
                                           ->join('tbl_m_poli mp', 'tm.id_poli = mp.id', 'left')
                                           ->join('tbl_m_pasien mpas', 'tm.id_pasien = mpas.id', 'left')
                                           ->where('DATE(tm.tgl_bayar) >=', $tgl_awal)
                                           ->where('DATE(tm.tgl_bayar) <=', $tgl_akhir)
                                           ->like('tm.id_poli', $poli, (!empty($poli) ? 'none' : ''))
                                           ->like('tm.tipe', $tipe, (!empty($tipe) ? 'none' : ''))
                                           ->group_by('tm.tipe, tm.id_pasien')
                                           ->order_by('COUNT(tm.id_pasien)', 'desc')
                                           ->get()->result();
                    break;
            }

            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Header Tabel
            $sheet->getStyle('A1:E1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A1:E1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A1:E1')->getFont()->setBold(true);

            $sheet->setCellValue('A1', 'No.')
                  ->setCellValue('B1', 'RM')
                  ->setCellValue('C1', 'Pasien')
                  ->setCellValue('D1', 'Kunjungan')
                  ->setCellValue('E1', 'Omset');

            $sheet->getColumnDimension('A')->setWidth(5);
            $sheet->getColumnDimension('B')->setWidth(10);
            $sheet->getColumnDimension('C')->setWidth(55);
            $sheet->getColumnDimension('D')->setWidth(11);
            $sheet->getColumnDimension('E')->setWidth(20);

            if(!empty($sql_pasien)){
                $no = 1;
                $cell = 2;
                $total_kunj = 0;
                $total_oms = 0;
                
                foreach ($sql_pasien as $pasien){
                    $total_kunj += $pasien->jml_kunjungan;
                    $total_oms += $pasien->jml_gtotal;
                    
                    $sheet->getStyle('E'.$cell)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
                    $sheet->getStyle('A'.$cell.':B'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('C'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                    $sheet->getStyle('D'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('E'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                    $sheet->setCellValue('A'.$cell, $no)
                          ->setCellValue('B'.$cell, $pasien->kode)
                          ->setCellValue('C'.$cell, $pasien->nama)
                          ->setCellValue('D'.$cell, $pasien->jml_kunjungan)
                          ->setCellValue('E'.$cell, $pasien->jml_gtotal);

                    $no++;
                    $cell++;
                }
                
                $sell = $cell;
                
                $sheet->getStyle('E'.$sell)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_ACCOUNTING_IDR);
                $sheet->getStyle('A'.$sell.':B'.$sell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('C'.$sell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->getStyle('D'.$sell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('E'.$sell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    
                $sheet->setCellValue('A'.$sell, '')
                      ->setCellValue('B'.$sell, '')
                      ->setCellValue('C'.$sell, 'TOTAL')
                      ->setCellValue('D'.$sell, $total_kunj)
                      ->setCellValue('E'.$sell, $total_oms);
            }

            // Rename worksheet
            $sheet->setTitle('Data Kunjungan Pasien');

            // Page setup
            $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);
            $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
            
            // Margins
            $sheet->getPageMargins()->setTop(0.25);
            $sheet->getPageMargins()->setRight(0);
            $sheet->getPageMargins()->setLeft(0);
            $sheet->getPageMargins()->setBottom(0);

            // Document properties
            $spreadsheet->getProperties()
                ->setCreator("Mikhael Felian Waskito")
                ->setLastModifiedBy($this->ion_auth->user()->row()->username)
                ->setTitle("Data Kunjungan Pasien")
                ->setSubject("Laporan Kunjungan")
                ->setDescription("Kunjungi http://tigerasoft.co.id")
                ->setKeywords("Pasien Kunjungan")
                ->setCategory("Laporan");

            ob_end_clean();
            
            // Redirect output to client's browser
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="data_pasien_kunj_lap.xlsx"');
            header('Cache-Control: max-age=0');
            
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $writer->save('php://output');
            exit;
        } else {
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function xls_data_pasien2(){
        if (akses::aksesLogin() == TRUE) {
            $jml        = $this->input->get('jml');
            $tgl        = $this->input->get('tgl');
            $bln        = $this->input->get('bln');
            $case       = $this->input->get('case');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();
            
            switch ($case) {
                case 'per_tanggal':
                    $sql_pasien = $this->db->select('tbl_m_pasien.id, tbl_m_pasien.kode_dpn, tbl_m_pasien.kode, tbl_m_pasien.nama, tbl_m_pasien.no_hp, tbl_m_pasien.tgl_lahir, DAY(tbl_m_pasien.tgl_lahir) AS hari, MONTH(tbl_m_pasien.tgl_lahir) AS bulan')
                                          ->where('tbl_m_pasien.no_hp !=', '')
                                          ->where('DAY(tbl_m_pasien.tgl_lahir)', $tgl)
                                          ->where('MONTH(tbl_m_pasien.tgl_lahir)', $bln)
                                          ->order_by('tbl_m_pasien.nama', 'ASC') 
                                          ->get('tbl_m_pasien')->result();
                    break;
                    
                default:
                    $sql_pasien = $this->db->select('tbl_m_pasien.id, tbl_m_pasien.kode_dpn, tbl_m_pasien.kode, tbl_m_pasien.nama, tbl_m_pasien.no_hp, tbl_m_pasien.tgl_lahir, DAY(tbl_m_pasien.tgl_lahir) AS hari, MONTH(tbl_m_pasien.tgl_lahir) AS bulan')
                                          ->order_by('tbl_m_pasien.nama', 'ASC') 
                                          ->get('tbl_m_pasien')->result();
                    break;
            }

            // Create new Spreadsheet object
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Set header styles
            $sheet->getStyle('A1:F1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A1:F1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A1:F1')->getFont()->setBold(true);

            // Set headers
            $sheet->setCellValue('A1', 'No')
                  ->setCellValue('B1', 'No. RM')
                  ->setCellValue('C1', 'Pasien')
                  ->setCellValue('D1', 'Alamat')
                  ->setCellValue('E1', 'Tgl Lahir')
                  ->setCellValue('F1', 'No. HP');

            // Set column widths
            $sheet->getColumnDimension('A')->setWidth(5);
            $sheet->getColumnDimension('B')->setWidth(10);
            $sheet->getColumnDimension('C')->setWidth(35);
            $sheet->getColumnDimension('D')->setWidth(55);
            $sheet->getColumnDimension('E')->setWidth(10);
            $sheet->getColumnDimension('F')->setWidth(10);

            // Fill data
            if(!empty($sql_pasien)){
                $no = 1;
                $cell = 2;
                foreach ($sql_pasien as $pasien){
                    $sheet->getStyle('A'.$cell)->getNumberFormat()->setFormatCode('#');
                    $sheet->getStyle('A'.$cell.':C'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                    $sheet->getStyle('D'.$cell.':E'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                    $sheet->setCellValue('A'.$cell, '')
                          ->setCellValue('B'.$cell, $pasien->kode_dpn.$pasien->kode)
                          ->setCellValue('C'.$cell, $pasien->nama)
                          ->setCellValue('D'.$cell, $pasien->alamat ?? '')
                          ->setCellValue('E'.$cell, $this->tanggalan->tgl_indo8($pasien->tgl_lahir))
                          ->setCellValue('F'.$cell, (!empty($pasien->no_hp) ? "62".substr($pasien->no_hp, 1) : ''));

                    $no++;
                    $cell++;
                }
            }

            // Rename worksheet
            $sheet->setTitle('Data Pasien');

            // Page setup
            $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);
            $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);

            // Margins
            $sheet->getPageMargins()->setTop(0.25);
            $sheet->getPageMargins()->setRight(0);
            $sheet->getPageMargins()->setLeft(0);
            $sheet->getPageMargins()->setBottom(0);

            // Document properties
            $spreadsheet->getProperties()->setCreator("Mikhael Felian Waskito")
                        ->setLastModifiedBy($this->ion_auth->user()->row()->username)
                        ->setTitle("Data Pasien")
                        ->setSubject("Data Pasien")
                        ->setDescription("Kunjungi http://tigerasoft.co.id")
                        ->setKeywords("Data Pasien")
                        ->setCategory("Laporan");

            // Clean output buffer
            ob_end_clean();

            // Set headers for download
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="data_pasien.xlsx"');
            header('Cache-Control: max-age=0');

            // Create Excel writer and output file
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
            exit;
        } else {
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function xls_data_pasien_periksa_rj(){
        if (akses::aksesLogin() == TRUE) {
            $jml        = $this->input->get('jml');
            $tgl        = $this->input->get('tgl');
            $tgl_awal   = $this->input->get('tgl_awal');
            $tgl_akhir  = $this->input->get('tgl_akhir');
            $tipe       = $this->input->get('tipe');
            $case       = $this->input->get('case');
            $hal        = $this->input->get('halaman');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();
            
            switch ($case){                
                case 'per_tanggal':
                    $sql_pasien = $this->db
                                       ->select('tbl_trans_medcheck.id AS id, tbl_trans_medcheck.id_pasien AS id_pasien, tbl_trans_medcheck.tgl_simpan AS tgl_simpan, tbl_trans_medcheck.tgl_masuk AS tgl_masuk, CONCAT(tbl_m_pasien.kode_dpn, "", tbl_m_pasien.kode) AS kode, tbl_trans_medcheck.pasien AS pasien, tbl_m_pasien.tgl_lahir AS tgl_lahir, tbl_m_poli.lokasi AS poli, tbl_trans_medcheck.diagnosa AS diagnosa, tbl_trans_medcheck_icd.kode AS kode_icd, tbl_trans_medcheck_icd.icd AS icd, tbl_trans_medcheck_icd.diagnosa_en AS diagnosa_en')
                                       ->from('tbl_trans_medcheck')
                                       ->join('tbl_trans_medcheck_icd', 'tbl_trans_medcheck.id = tbl_trans_medcheck_icd.id_medcheck')
                                       ->join('tbl_m_pasien', 'tbl_trans_medcheck.id_pasien = tbl_m_pasien.id')
                                       ->join('tbl_m_poli', 'tbl_trans_medcheck.id_poli = tbl_m_poli.id')
                                       ->where('tbl_trans_medcheck.tipe', '2')
                                       ->where('DATE(tbl_trans_medcheck.tgl_simpan)', $tgl)
                                       ->order_by('tbl_trans_medcheck.id', 'DESC')
                                       ->get()->result();
                    break;

                case 'per_rentang':
                    $sql_pasien = $this->db
                                       ->select('tbl_trans_medcheck.id AS id, tbl_trans_medcheck.id_pasien AS id_pasien, tbl_trans_medcheck.tgl_simpan AS tgl_simpan, tbl_trans_medcheck.tgl_masuk AS tgl_masuk, CONCAT(tbl_m_pasien.kode_dpn, "", tbl_m_pasien.kode) AS kode, tbl_trans_medcheck.pasien AS pasien, tbl_m_pasien.tgl_lahir AS tgl_lahir, tbl_m_poli.lokasi AS poli, tbl_trans_medcheck.diagnosa AS diagnosa, tbl_trans_medcheck_icd.kode AS kode_icd, tbl_trans_medcheck_icd.icd AS icd, tbl_trans_medcheck_icd.diagnosa_en AS diagnosa_en')
                                       ->from('tbl_trans_medcheck')
                                       ->join('tbl_trans_medcheck_icd', 'tbl_trans_medcheck.id = tbl_trans_medcheck_icd.id_medcheck')
                                       ->join('tbl_m_pasien', 'tbl_trans_medcheck.id_pasien = tbl_m_pasien.id')
                                       ->join('tbl_m_poli', 'tbl_trans_medcheck.id_poli = tbl_m_poli.id')
                                       ->where('tbl_trans_medcheck.tipe', '2')
                                       ->where('DATE(tbl_trans_medcheck.tgl_simpan) >=', $tgl_awal)
                                       ->where('DATE(tbl_trans_medcheck.tgl_simpan) <=', $tgl_akhir)
                                       ->order_by('tbl_trans_medcheck.id', 'DESC')
                                       ->get()->result();
                    break;
            }

            // Create new Spreadsheet object
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Header Tabel
            $sheet->getStyle('A1:G1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A1:G1')->getFont()->setBold(true);

            $sheet->setCellValue('A1', 'NO')
                  ->setCellValue('B1', 'TGL')
                  ->setCellValue('C1', 'POLI')
                  ->setCellValue('D1', 'PASIEN')
                  ->setCellValue('E1', 'DIAGNOSA')
                  ->setCellValue('F1', 'KODE ICD')
                  ->setCellValue('G1', 'ICD');

            $sheet->freezePane("A2");
            $sheet->setAutoFilter('A1:G1');

            $sheet->getColumnDimension('A')->setWidth(7);
            $sheet->getColumnDimension('B')->setWidth(15);
            $sheet->getColumnDimension('C')->setWidth(20);
            $sheet->getColumnDimension('D')->setWidth(40);
            $sheet->getColumnDimension('E')->setWidth(25);
            $sheet->getColumnDimension('F')->setWidth(15);
            $sheet->getColumnDimension('G')->setWidth(35);

            if(!empty($sql_pasien)){
                $no    = 1;
                $cell  = 2;
                foreach ($sql_pasien as $det){
                    $sheet->getStyle('A'.$cell.':G'.$cell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                    $sheet->getStyle('A'.$cell.':B'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('C'.$cell.':E'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                    $sheet->getStyle('F'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('G'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                    $sheet->getStyle('E'.$cell)->getAlignment()->setWrapText(true);
                    $sheet->getStyle('G'.$cell)->getAlignment()->setWrapText(true);
                    
                    $sheet->setCellValue('A'.$cell, $no)
                          ->setCellValue('B'.$cell, $this->tanggalan->tgl_indo5($det->tgl_masuk))
                          ->setCellValue('C'.$cell, $det->poli)
                          ->setCellValue('D'.$cell, $det->pasien)
                          ->setCellValue('E'.$cell, $det->diagnosa)
                          ->setCellValue('F'.$cell, $det->kode_icd)
                          ->setCellValue('G'.$cell, $det->diagnosa_en);

                    $no++;
                    $cell++;
                }
            }

            // Rename worksheet
            $sheet->setTitle('Lap Diagnosa');

            // Page setup
            $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);
            $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);

            // Margins
            $sheet->getPageMargins()->setTop(0.25);
            $sheet->getPageMargins()->setRight(0);
            $sheet->getPageMargins()->setLeft(0);
            $sheet->getPageMargins()->setBottom(0);

            // Document properties
            $spreadsheet->getProperties()->setCreator("Mikhael Felian Waskito")
                        ->setLastModifiedBy($this->ion_auth->user()->row()->username)
                        ->setTitle("Data Diagnosa")
                        ->setSubject("Rekap Diagnosa")
                        ->setDescription("Kunjungi http://tigerasoft.co.id");

            // Clean output buffer
            ob_end_clean();

            // Set headers for download
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="data_rekap_diagnosa_'.(isset($_GET['filename']) ? $_GET['filename'] : 'lap').'.xlsx"');
            header('Cache-Control: max-age=0');

            // Create Excel writer and output file
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
            exit;
        } else {
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function xls_data_karyawan_ultah(){
        if (akses::aksesLogin() == TRUE) {
            $jml        = $this->input->get('jml');
            $tgl        = $this->input->get('tgl');
            $bln        = $this->input->get('bln');
            $hr_awal    = $this->input->get('hr_awal');
            $bln_awal   = $this->input->get('bln_awal');
            $hr_akhir   = $this->input->get('hr_akhir');
            $bln_akhir  = $this->input->get('bln_akhir');
            $case       = $this->input->get('case');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();
            
            switch ($case) {
                case 'per_tanggal':
                    $sql_karyawan = $this->db->select('tbl_m_karyawan.id, tbl_m_karyawan.nik, tbl_m_karyawan.kode, tbl_m_karyawan.nama, tbl_m_karyawan.no_hp, tbl_m_karyawan.tgl_lahir, DAY(tbl_m_karyawan.tgl_lahir) AS hari, MONTH(tbl_m_karyawan.tgl_lahir) AS bulan')
                                          ->where('tbl_m_karyawan.no_hp !=', '')
                                          ->where('DAY(tbl_m_karyawan.tgl_lahir)', $tgl)
                                          ->where('MONTH(tbl_m_karyawan.tgl_lahir)', $bln)
                                          ->order_by('tbl_m_karyawan.nama', 'ASC') 
                                          ->get('tbl_m_karyawan')->result();
                    break;
                
                case 'per_rentang':
                    $sql_karyawan = $this->db->select('tbl_m_karyawan.id, tbl_m_karyawan.nik, tbl_m_karyawan.kode, tbl_m_karyawan.nama, tbl_m_karyawan.no_hp, tbl_m_karyawan.tgl_lahir, DAY(tbl_m_karyawan.tgl_lahir) AS hari, MONTH(tbl_m_karyawan.tgl_lahir) AS bulan')
                                          ->where('tbl_m_karyawan.no_hp !=', '')
                                          ->where('DAY(tbl_m_karyawan.tgl_lahir) >=', $hr_awal)
                                          ->where('MONTH(tbl_m_karyawan.tgl_lahir) >=', $bln_awal)
                                          ->where('DAY(tbl_m_karyawan.tgl_lahir) <=', $hr_akhir)
                                          ->where('MONTH(tbl_m_karyawan.tgl_lahir) <=', $bln_akhir)
                                          ->order_by('tbl_m_karyawan.nama', 'ASC') 
                                          ->get('tbl_m_karyawan')->result();
                    break;
            }

            // Create new Spreadsheet object
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Set header styles
            $sheet->getStyle('A1:E1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A1:E1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A1:E1')->getFont()->setBold(true);

            // Set headers
            $sheet->setCellValue('A1', 'Whatsapp Number')
                  ->setCellValue('B1', 'Name')
                  ->setCellValue('C1', 'Col1')
                  ->setCellValue('D1', 'Tgl Lahir')
                  ->setCellValue('E1', 'Col3');

            // Set column widths
            $sheet->getColumnDimension('A')->setWidth(18);
            $sheet->getColumnDimension('B')->setWidth(55);
            $sheet->getColumnDimension('C')->setWidth(14);
            $sheet->getColumnDimension('D')->setWidth(12);
            $sheet->getColumnDimension('E')->setWidth(10);

            // Fill data
            if(!empty($sql_karyawan)){
                $no    = 1;
                $cell  = 2;
                foreach ($sql_karyawan as $karyawan){
                    $sheet->getStyle('A'.$cell)->getNumberFormat()->setFormatCode('#');
                    $sheet->getStyle('A'.$cell.':C'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                    $sheet->getStyle('D'.$cell.':E'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                    $sheet->setCellValue('A'.$cell, (!empty($karyawan->no_hp) ? "62".substr($karyawan->no_hp, 1) : ''))
                          ->setCellValue('B'.$cell, $karyawan->nama)
                          ->setCellValue('C'.$cell, $this->tanggalan->bulan_ke($karyawan->bulan))
                          ->setCellValue('D'.$cell, $this->tanggalan->tgl_indo8($karyawan->tgl_lahir))
                          ->setCellValue('E'.$cell, $karyawan->bulan);

                    $no++;
                    $cell++;
                }
            }

            // Rename worksheet
            $sheet->setTitle('Data Karyawan');

            // Page setup
            $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);
            $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);

            // Margins
            $sheet->getPageMargins()->setTop(0.25);
            $sheet->getPageMargins()->setRight(0);
            $sheet->getPageMargins()->setLeft(0);
            $sheet->getPageMargins()->setBottom(0);

            // Document properties
            $spreadsheet->getProperties()->setCreator("Mikhael Felian Waskito")
                        ->setLastModifiedBy($this->ion_auth->user()->row()->username)
                        ->setTitle("Data Karyawan")
                        ->setSubject("Data Karyawan Ulang Tahun")
                        ->setDescription("Kunjungi http://tigerasoft.co.id");

            // Clean output buffer
            ob_end_clean();

            // Set headers for download
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="data_karyawan_wa_lap.xlsx"');
            header('Cache-Control: max-age=0');

            // Create Excel writer and output file
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
            exit;
        } else {
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function xls_data_tracer(){
        if (akses::aksesLogin() == TRUE) {
            $dokter     = $this->input->get('id_dokter');
            $jml        = $this->input->get('jml');
            $tgl        = $this->input->get('tgl');
            $tgl_awal   = $this->input->get('tgl_awal');
            $tgl_akhir  = $this->input->get('tgl_akhir');
            $case       = $this->input->get('case');
            $tipe       = $this->input->get('tipe');
            $poli       = $this->input->get('poli');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $grup       = $this->ion_auth->get_users_groups()->row();
            $id_user    = $this->ion_auth->user()->row()->id;
            $id_grup    = $this->ion_auth->get_users_groups()->row();

            
            switch ($case) {
                case 'per_tanggal':
                    $sql_tracer = $this->db
                                    ->select('
                                        tm.id AS id,
                                        tm.id_poli AS id_poli,
                                        tm.no_rm AS no_rm,
                                        tm.pasien AS nama_pgl,
                                        tm.tgl_simpan AS tgl_simpan,
                                        CAST(tm.tgl_simpan AS DATE) AS tanggal,
                                        p.tgl_simpan AS wkt_daftar,
                                        tm.tgl_periksa AS wkt_periksa,
                                        tml.tgl_simpan AS wkt_sampling_msk,
                                        tml.tgl_keluar AS wkt_sampling_klr,
                                        tmr.tgl_simpan AS wkt_rad_msk,
                                        tm.tgl_periksa_rad_keluar AS wkt_rad_klr,
                                        tm.tgl_periksa_rad_kirim AS wkt_rad_krm,
                                        tm.tgl_periksa_rad_baca AS wkt_rad_baca,
                                        tmrp.tgl_simpan AS wkt_resep_msk,
                                        tmrp.tgl_keluar AS wkt_resep_klr,
                                        tm.tgl_bayar AS wkt_resep_byr,
                                        tm.tgl_ttd AS wkt_resep_trm,
                                        tmrp.tgl_simpan AS wkt_farmasi_msk,
                                        tmrp.tgl_keluar AS wkt_farmasi_klr,
                                        tm.tgl_ranap AS wkt_ranap,
                                        tm.tgl_ranap_keluar AS wkt_ranap_keluar,
                                        tm.tgl_bayar AS wkt_selesai,
                                        tm.tipe AS tipe,
                                        tm.status AS status
                                    ')
                                    ->from('tbl_trans_medcheck tm')
                                    ->join('tbl_pendaftaran p', 'p.id = tm.id_dft')
                                    ->join('tbl_trans_medcheck_lab tml', 'tml.id_medcheck = tm.id', 'left')
                                    ->join('tbl_trans_medcheck_rad tmr', 'tmr.id_medcheck = tm.id', 'left')
                                    ->join('tbl_trans_medcheck_resep tmrp', 'tmrp.id_medcheck = tm.id', 'left')
                                    ->where('tm.status_hps', '0')
                                    ->where('DATE(tm.tgl_simpan)', $tgl)
                                    ->like('tm.id_poli', $poli, (!empty($poli) ? 'none' : ''))
                                    ->like('tm.tipe', $tipe, (!empty($tipe) ? 'none' : ''))
                                    ->order_by('tm.id', 'DESC')
                                    ->get()->result();
                    break;

                case 'per_rentang':
                    $sql_tracer = $this->db
                                    ->select('
                                        tm.id AS id,
                                        tm.id_poli AS id_poli,
                                        tm.no_rm AS no_rm,
                                        tm.pasien AS nama_pgl,
                                        tm.tgl_simpan AS tgl_simpan,
                                        CAST(tm.tgl_simpan AS DATE) AS tanggal,
                                        p.tgl_simpan AS wkt_daftar,
                                        tm.tgl_periksa AS wkt_periksa,
                                        tml.tgl_simpan AS wkt_sampling_msk,
                                        tml.tgl_keluar AS wkt_sampling_klr,
                                        tmr.tgl_simpan AS wkt_rad_msk,
                                        tm.tgl_periksa_rad_keluar AS wkt_rad_klr,
                                        tm.tgl_periksa_rad_kirim AS wkt_rad_krm,
                                        tm.tgl_periksa_rad_baca AS wkt_rad_baca,
                                        tmrp.tgl_simpan AS wkt_resep_msk,
                                        tmrp.tgl_keluar AS wkt_resep_klr,
                                        tm.tgl_bayar AS wkt_resep_byr,
                                        tm.tgl_ttd AS wkt_resep_trm,
                                        tmrp.tgl_simpan AS wkt_farmasi_msk,
                                        tmrp.tgl_keluar AS wkt_farmasi_klr,
                                        tm.tgl_ranap AS wkt_ranap,
                                        tm.tgl_ranap_keluar AS wkt_ranap_keluar,
                                        tm.tgl_bayar AS wkt_selesai,
                                        tm.tipe AS tipe,
                                        tm.status AS status
                                    ')
                                    ->from('tbl_trans_medcheck tm')
                                    ->join('tbl_pendaftaran p', 'p.id = tm.id_dft')
                                    ->join('tbl_trans_medcheck_lab tml', 'tml.id_medcheck = tm.id', 'left')
                                    ->join('tbl_trans_medcheck_rad tmr', 'tmr.id_medcheck = tm.id', 'left')
                                    ->join('tbl_trans_medcheck_resep tmrp', 'tmrp.id_medcheck = tm.id', 'left')
                                    ->where('tm.status_hps', '0')
                                    ->where('DATE(tm.tgl_simpan) >=', $tgl_awal)
                                    ->where('DATE(tm.tgl_simpan) <=', $tgl_akhir)
                                    ->like('tm.id_poli', $poli, (!empty($poli) ? 'none' : ''))
                                    ->like('tm.tipe', $tipe, (!empty($tipe) ? 'none' : ''))
                                    ->order_by('tm.id', 'DESC')
                                    ->get()->result();
                    break;
            }

            // Create new Spreadsheet object
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Header Tabel Nota
            $sheet->getStyle('A1:Z5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A1:Z5')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A1:Z5')->getFont()->setBold(true);

            $sheet->setCellValue('A1', 'LAPORAN TRACER PENGUNJUNG')
                  ->mergeCells('A1:S1');
            $sheet->setCellValue('A2', $pengaturan->judul)
                  ->mergeCells('A2:S2');
            
            $sheet->setCellValue('A4', 'No.')
                  ->mergeCells('A4:A5');
            $sheet->setCellValue('B4', 'Pasien')
                  ->mergeCells('B4:B5');
            $sheet->setCellValue('C4', 'Tanggal')
                  ->mergeCells('C4:C5');
            $sheet->setCellValue('D4', 'Pendaftaran')
                  ->mergeCells('D4:D5');
            $sheet->setCellValue('E4', 'PX Dokter')
                  ->mergeCells('E4:E5');
            $sheet->setCellValue('F4', 'Laborat')
                  ->mergeCells('F4:H4');
            $sheet->setCellValue('I4', 'Radiologi')
                  ->mergeCells('I4:M4');
            $sheet->setCellValue('N4', 'Farmasi')
                  ->mergeCells('N4:Q4');
            $sheet->setCellValue('R4', 'Rawat Inap')
                  ->mergeCells('R4:T4');
            $sheet->setCellValue('U4', 'Selesai')
                  ->mergeCells('U4:U5');
            $sheet->setCellValue('V4', 'Total')
                  ->mergeCells('V4:V5');
            
            $sheet->setCellValue('F5', 'Masuk');
            $sheet->setCellValue('G5', 'Keluar');
            $sheet->setCellValue('H5', 'Total');
            $sheet->setCellValue('I5', 'Masuk');
            $sheet->setCellValue('J5', 'Kirim');
            $sheet->setCellValue('K5', 'Baca');
            $sheet->setCellValue('L5', 'Selesai');
            $sheet->setCellValue('M5', 'Total');
            $sheet->setCellValue('N5', 'Masuk');
            $sheet->setCellValue('O5', 'Bayar');
            $sheet->setCellValue('P5', 'Diterima');
            $sheet->setCellValue('Q5', 'Total');
            $sheet->setCellValue('R5', 'Masuk');
            $sheet->setCellValue('S5', 'Keluar');
            $sheet->setCellValue('T5', 'Total');
            
            $sheet->freezePane("A6");

            $sheet->getColumnDimension('A')->setWidth(6);
            $sheet->getColumnDimension('B')->setWidth(40);
            $sheet->getColumnDimension('C')->setWidth(11);
            $sheet->getColumnDimension('D')->setWidth(12);
            $sheet->getColumnDimension('E')->setWidth(12);
            $sheet->getColumnDimension('F')->setWidth(8);
            $sheet->getColumnDimension('G')->setWidth(8);
            $sheet->getColumnDimension('H')->setWidth(16);
            $sheet->getColumnDimension('I')->setWidth(8);
            $sheet->getColumnDimension('J')->setWidth(8);
            $sheet->getColumnDimension('K')->setWidth(8);
            $sheet->getColumnDimension('L')->setWidth(8);
            $sheet->getColumnDimension('M')->setWidth(16);
            $sheet->getColumnDimension('N')->setWidth(8);
            $sheet->getColumnDimension('O')->setWidth(8);
            $sheet->getColumnDimension('P')->setWidth(8);
            $sheet->getColumnDimension('Q')->setWidth(16);
            $sheet->getColumnDimension('R')->setWidth(16);
            $sheet->getColumnDimension('S')->setWidth(20);
            $sheet->getColumnDimension('T')->setWidth(16);
            $sheet->getColumnDimension('U')->setWidth(20);
            $sheet->getColumnDimension('V')->setWidth(20);

            if(!empty($sql_tracer)){
                $no    = 1;
                $cell  = 6;
                foreach ($sql_tracer as $trace){
                    $sheet->getStyle('A'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('C'.$cell.':P'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('Q'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    $sheet->getStyle('R'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('S'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                    $sheet->setCellValue('A'.$cell, $no)
                          ->setCellValue('B'.$cell, $trace->nama_pgl)
                          ->setCellValue('C'.$cell, $this->tanggalan->tgl_indo($trace->tanggal))
                          ->setCellValue('D'.$cell, $this->tanggalan->wkt_indo($trace->wkt_daftar))
                          ->setCellValue('E'.$cell, $this->tanggalan->wkt_indo($trace->wkt_periksa))
                          ->setCellValue('F'.$cell, $this->tanggalan->wkt_indo($trace->wkt_sampling_msk))
                          ->setCellValue('G'.$cell, $this->tanggalan->wkt_indo($trace->wkt_sampling_klr))
                          ->setCellValue('H'.$cell, $this->tanggalan->usia_wkt($trace->wkt_sampling_msk, $trace->wkt_sampling_klr))
                          ->setCellValue('I'.$cell, $this->tanggalan->wkt_indo($trace->wkt_rad_msk))
                          ->setCellValue('J'.$cell, $this->tanggalan->wkt_indo($trace->wkt_rad_krm))
                          ->setCellValue('K'.$cell, $this->tanggalan->wkt_indo($trace->wkt_rad_baca))
                          ->setCellValue('L'.$cell, $this->tanggalan->wkt_indo($trace->wkt_rad_klr))
                          ->setCellValue('M'.$cell, $this->tanggalan->usia_wkt($trace->wkt_rad_msk, $trace->wkt_rad_klr))
                          ->setCellValue('N'.$cell, $this->tanggalan->wkt_indo($trace->wkt_resep_msk))
                          ->setCellValue('O'.$cell, $this->tanggalan->wkt_indo($trace->wkt_resep_klr))
                          ->setCellValue('P'.$cell, $this->tanggalan->wkt_indo($trace->wkt_resep_trm))
                          ->setCellValue('Q'.$cell, $this->tanggalan->usia_wkt($trace->wkt_resep_msk, $trace->wkt_resep_trm))
                          ->setCellValue('R'.$cell, $this->tanggalan->tgl_indo5($trace->wkt_ranap))
                          ->setCellValue('S'.$cell, $this->tanggalan->tgl_indo5($trace->wkt_ranap_keluar))
                          ->setCellValue('T'.$cell, $this->tanggalan->usia_wkt($trace->wkt_ranap, $trace->wkt_ranap_keluar))
                          ->setCellValue('U'.$cell, $this->tanggalan->tgl_indo5($trace->wkt_selesai))
                          ->setCellValue('V'.$cell, $this->tanggalan->usia_wkt($trace->wkt_daftar, $trace->wkt_selesai));

                    $no++;
                    $cell++;
                }
            }

            // Rename worksheet
            $sheet->setTitle('LAP TRACER');

            // Page setup
            $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);
            $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);

            // Margins
            $sheet->getPageMargins()->setTop(0.25);
            $sheet->getPageMargins()->setRight(0);
            $sheet->getPageMargins()->setLeft(0);
            $sheet->getPageMargins()->setBottom(0);

            // Document properties
            $spreadsheet->getProperties()->setCreator("Mikhael Felian Waskito")
                        ->setLastModifiedBy($this->ion_auth->user()->row()->username)
                        ->setTitle("Laporan Tracer")
                        ->setSubject("Laporan Tracer")
                        ->setDescription("Kunjungi http://tigerasoft.co.id")
                        ->setKeywords("Tracer")
                        ->setCategory("Laporan");

            // Clean output buffer
            ob_end_clean();

            // Set headers for download
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="data_tracer_'.(isset($_GET['filename']) ? $_GET['filename'] : 'lap').'.xlsx"');
            header('Cache-Control: max-age=0');

            // Create Excel writer and output file
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
            exit;
        } else {
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function xls_data_tracer_div(){
        if (akses::aksesLogin() == TRUE) {
            $dokter     = $this->input->get('id_dokter');
            $jml        = $this->input->get('jml');
            $tgl        = $this->input->get('tgl');
            $tgl_awal   = $this->input->get('tgl_awal');
            $tgl_akhir  = $this->input->get('tgl_akhir');
            $case       = $this->input->get('case');
            $tipe       = $this->input->get('tipe');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $grup       = $this->ion_auth->get_users_groups()->row();
            $id_user    = $this->ion_auth->user()->row()->id;
            $id_grup    = $this->ion_auth->get_users_groups()->row();

            
            switch ($case) {
                case 'per_tanggal':
                    $sql_tracer = $this->db->select('
                                               tm.id AS id,
                                               tm.id_poli AS id_poli,
                                               tm.no_rm AS no_rm,
                                               tm.pasien AS nama_pgl,
                                               tm.tgl_simpan AS tgl_simpan,
                                               CAST(tm.tgl_simpan AS DATE) AS tanggal,
                                               p.tgl_simpan AS wkt_daftar,
                                               tm.tgl_periksa AS wkt_periksa,
                                               tml.tgl_simpan AS wkt_sampling_msk,
                                               tml.tgl_keluar AS wkt_sampling_klr,
                                               tmr.tgl_simpan AS wkt_rad_msk,
                                               tm.tgl_periksa_rad_keluar AS wkt_rad_klr,
                                               tm.tgl_periksa_rad_kirim AS wkt_rad_krm,
                                               tm.tgl_periksa_rad_baca AS wkt_rad_baca,
                                               tmrp.tgl_simpan AS wkt_resep_msk,
                                               tmrp.tgl_keluar AS wkt_resep_klr,
                                               tm.tgl_bayar AS wkt_resep_byr,
                                               tm.tgl_ttd AS wkt_resep_trm,
                                               tmrp.tgl_simpan AS wkt_farmasi_msk,
                                               tmrp.tgl_keluar AS wkt_farmasi_klr,
                                               tm.tgl_ranap AS wkt_ranap,
                                               tm.tgl_ranap_keluar AS wkt_ranap_keluar,
                                               tm.tgl_bayar AS wkt_selesai,
                                               tm.tipe AS tipe,
                                               tm.status AS status
                                           ')
                                           ->from('tbl_trans_medcheck tm')
                                           ->join('tbl_pendaftaran p', 'p.id = tm.id_dft', 'join')
                                           ->join('tbl_trans_medcheck_lab tml', 'tml.id_medcheck = tm.id', 'left')
                                           ->join('tbl_trans_medcheck_rad tmr', 'tmr.id_medcheck = tm.id', 'left')
                                           ->join('tbl_trans_medcheck_resep tmrp', 'tmrp.id_medcheck = tm.id', 'left')
                                           ->where('tm.status_hps', '0')
                                           ->where('DATE(tm.tgl_simpan)', $tgl)
                                           ->like('tm.tipe', $tipe, (!empty($tipe) ? 'none' : ''))
                                           ->order_by('tm.id', 'DESC')
                                           ->get()->result();
                    break;

                case 'per_rentang':
                    $sql_tracer = $this->db->select('
                                               tm.id AS id,
                                               tm.id_poli AS id_poli,
                                               tm.no_rm AS no_rm,
                                               tm.pasien AS nama_pgl,
                                               tm.tgl_simpan AS tgl_simpan,
                                               CAST(tm.tgl_simpan AS DATE) AS tanggal,
                                               p.tgl_simpan AS wkt_daftar,
                                               tm.tgl_periksa AS wkt_periksa,
                                               tml.tgl_simpan AS wkt_sampling_msk,
                                               tml.tgl_keluar AS wkt_sampling_klr,
                                               tmr.tgl_simpan AS wkt_rad_msk,
                                               tm.tgl_periksa_rad_keluar AS wkt_rad_klr,
                                               tm.tgl_periksa_rad_kirim AS wkt_rad_krm,
                                               tm.tgl_periksa_rad_baca AS wkt_rad_baca,
                                               tmrp.tgl_simpan AS wkt_resep_msk,
                                               tmrp.tgl_keluar AS wkt_resep_klr,
                                               tm.tgl_bayar AS wkt_resep_byr,
                                               tm.tgl_ttd AS wkt_resep_trm,
                                               tmrp.tgl_simpan AS wkt_farmasi_msk,
                                               tmrp.tgl_keluar AS wkt_farmasi_klr,
                                               tm.tgl_ranap AS wkt_ranap,
                                               tm.tgl_ranap_keluar AS wkt_ranap_keluar,
                                               tm.tgl_bayar AS wkt_selesai,
                                               tm.tipe AS tipe,
                                               tm.status AS status
                                           ')
                                           ->from('tbl_trans_medcheck tm')
                                           ->join('tbl_pendaftaran p', 'p.id = tm.id_dft', 'join')
                                           ->join('tbl_trans_medcheck_lab tml', 'tml.id_medcheck = tm.id', 'left')
                                           ->join('tbl_trans_medcheck_rad tmr', 'tmr.id_medcheck = tm.id', 'left')
                                           ->join('tbl_trans_medcheck_resep tmrp', 'tmrp.id_medcheck = tm.id', 'left')
                                           ->where('tm.status_hps', '0')
                                           ->where('DATE(tm.tgl_simpan) >=', $tgl_awal)
                                           ->where('DATE(tm.tgl_simpan) <=', $tgl_akhir)
                                           ->like('tm.tipe', $tipe, (!empty($tipe) ? 'none' : ''))
                                           ->order_by('tm.id', 'DESC')
                                           ->get()->result();
                    break;
            }

            // Create new Spreadsheet object
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Header Tabel Nota
            $sheet->getStyle('A1:Z5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A1:Z5')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A1:Z5')->getFont()->setBold(true);
            
            switch ($tipe){
                default:
                    $sheet->setCellValue('A4', 'No.')
                          ->mergeCells('A4:A5');
                    $sheet->setCellValue('B4', 'Pasien')
                          ->mergeCells('B4:B5');
                    $sheet->setCellValue('C4', 'Tanggal')
                          ->mergeCells('C4:C5');
                    $sheet->setCellValue('D4', 'Pendaftaran')
                          ->mergeCells('D4:D5');
                    $sheet->setCellValue('E4', 'PX Dokter')
                          ->mergeCells('E4:E5');
                    $sheet->setCellValue('F4', 'Selesai')
                          ->mergeCells('F4:F5');
                    $sheet->setCellValue('G4', 'Total')
                          ->mergeCells('G4:G5');

                    $sheet->freezePane("A6");

                    $sheet->getColumnDimension('A')->setWidth(6);
                    $sheet->getColumnDimension('B')->setWidth(40);
                    $sheet->getColumnDimension('C')->setWidth(11);
                    $sheet->getColumnDimension('D')->setWidth(12);
                    $sheet->getColumnDimension('E')->setWidth(12);
                    $sheet->getColumnDimension('F')->setWidth(12);
                    $sheet->getColumnDimension('G')->setWidth(12);

                    if(!empty($sql_tracer)){
                        $no    = 1;
                        $cell  = 6;
                        foreach ($sql_tracer as $trace){
                            $sheet->getStyle('A'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                            $sheet->getStyle('C'.$cell.':G'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                            
                            $sheet->setCellValue('A'.$cell, $no)
                                  ->setCellValue('B'.$cell, $trace->nama_pgl)
                                  ->setCellValue('C'.$cell, $this->tanggalan->tgl_indo($trace->tanggal))
                                  ->setCellValue('D'.$cell, $this->tanggalan->wkt_indo($trace->wkt_daftar))
                                  ->setCellValue('E'.$cell, $this->tanggalan->wkt_indo($trace->wkt_periksa))
                                  ->setCellValue('F'.$cell, $this->tanggalan->tgl_indo5($trace->wkt_selesai))
                                  ->setCellValue('G'.$cell, $this->tanggalan->usia_wkt($trace->wkt_daftar, $trace->wkt_selesai));

                            $no++;
                            $cell++;
                        }
                    }
                    break;
                
                case '1':
                    $sheet->setCellValue('A1', 'LAPORAN TRACER PENGUNJUNG')
                          ->mergeCells('A1:G1');
                    $sheet->setCellValue('A2', $pengaturan->judul)
                          ->mergeCells('A2:G2');
            
                    $sheet->setCellValue('A4', 'No.')
                          ->mergeCells('A4:A5');
                    $sheet->setCellValue('B4', 'Pasien')
                          ->mergeCells('B4:B5');
                    $sheet->setCellValue('C4', 'Tanggal')
                          ->mergeCells('C4:C5');
                    $sheet->setCellValue('D4', 'Pendaftaran')
                          ->mergeCells('D4:D5');
                    $sheet->setCellValue('E4', 'PX Dokter')
                          ->mergeCells('E4:E5');
                    $sheet->setCellValue('F4', 'Selesai')
                          ->mergeCells('F4:F5');
                    $sheet->setCellValue('G4', 'Total')
                          ->mergeCells('G4:G5');

                    $sheet->freezePane("A6");

                    $sheet->getColumnDimension('A')->setWidth(6);
                    $sheet->getColumnDimension('B')->setWidth(40);
                    $sheet->getColumnDimension('C')->setWidth(11);
                    $sheet->getColumnDimension('D')->setWidth(12);
                    $sheet->getColumnDimension('E')->setWidth(12);
                    $sheet->getColumnDimension('F')->setWidth(12);
                    $sheet->getColumnDimension('G')->setWidth(12);

                    if(!empty($sql_tracer)){
                        $no    = 1;
                        $cell  = 6;
                        foreach ($sql_tracer as $trace){
                            $sheet->getStyle('A'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                            $sheet->getStyle('C'.$cell.':G'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                            
                            $sheet->setCellValue('A'.$cell, $no)
                                  ->setCellValue('B'.$cell, $trace->nama_pgl)
                                  ->setCellValue('C'.$cell, $this->tanggalan->tgl_indo($trace->tanggal))
                                  ->setCellValue('D'.$cell, $this->tanggalan->wkt_indo($trace->wkt_daftar))
                                  ->setCellValue('E'.$cell, $this->tanggalan->wkt_indo($trace->wkt_periksa))
                                  ->setCellValue('F'.$cell, $this->tanggalan->tgl_indo5($trace->wkt_selesai))
                                  ->setCellValue('G'.$cell, $this->tanggalan->usia_wkt($trace->wkt_daftar, $trace->wkt_selesai));

                            $no++;
                            $cell++;
                        }
                    }
                    break;
                
                case '2':
                case '3':
                case '4':
                    $sheet->setCellValue('A4', 'No.')
                          ->mergeCells('A4:A5');
                    $sheet->setCellValue('B4', 'Pasien')
                          ->mergeCells('B4:B5');
                    $sheet->setCellValue('C4', 'Tanggal')
                          ->mergeCells('C4:C5');
                    $sheet->setCellValue('D4', 'Pendaftaran')
                          ->mergeCells('D4:D5');
                    $sheet->setCellValue('E4', 'PX Dokter')
                          ->mergeCells('E4:E5');
                    $sheet->setCellValue('F4', 'Laborat')
                          ->mergeCells('F4:H4');
                    $sheet->setCellValue('I4', 'Radiologi')
                          ->mergeCells('I4:M4');
                    $sheet->setCellValue('N4', 'Farmasi')
                          ->mergeCells('N4:Q4');
                    $sheet->setCellValue('R4', 'Rawat Inap')
                          ->mergeCells('R4:T4');
                    $sheet->setCellValue('U4', 'Selesai')
                          ->mergeCells('U4:U5');
                    $sheet->setCellValue('V4', 'Total')
                          ->mergeCells('V4:V5');

                    $sheet->setCellValue('F5', 'Masuk');
                    $sheet->setCellValue('G5', 'Keluar');
                    $sheet->setCellValue('H5', 'Total');
                    $sheet->setCellValue('I5', 'Masuk');
                    $sheet->setCellValue('J5', 'Kirim');
                    $sheet->setCellValue('K5', 'Baca');
                    $sheet->setCellValue('L5', 'Selesai');
                    $sheet->setCellValue('M5', 'Total');
                    $sheet->setCellValue('N5', 'Masuk');
                    $sheet->setCellValue('O5', 'Bayar');
                    $sheet->setCellValue('P5', 'Diterima');
                    $sheet->setCellValue('Q5', 'Total');
                    $sheet->setCellValue('R5', 'Masuk');
                    $sheet->setCellValue('S5', 'Keluar');
                    $sheet->setCellValue('T5', 'Total');

                    $sheet->freezePane("A6");

                    $sheet->getColumnDimension('A')->setWidth(6);
                    $sheet->getColumnDimension('B')->setWidth(40);
                    $sheet->getColumnDimension('C')->setWidth(11);
                    $sheet->getColumnDimension('D')->setWidth(12);
                    $sheet->getColumnDimension('E')->setWidth(12);
                    $sheet->getColumnDimension('F')->setWidth(8);
                    $sheet->getColumnDimension('G')->setWidth(8);
                    $sheet->getColumnDimension('H')->setWidth(16);
                    $sheet->getColumnDimension('I')->setWidth(8);
                    $sheet->getColumnDimension('J')->setWidth(8);
                    $sheet->getColumnDimension('K')->setWidth(8);
                    $sheet->getColumnDimension('L')->setWidth(8);
                    $sheet->getColumnDimension('M')->setWidth(16);
                    $sheet->getColumnDimension('N')->setWidth(8);
                    $sheet->getColumnDimension('O')->setWidth(8);
                    $sheet->getColumnDimension('P')->setWidth(8);
                    $sheet->getColumnDimension('Q')->setWidth(16);
                    $sheet->getColumnDimension('R')->setWidth(16);
                    $sheet->getColumnDimension('S')->setWidth(20);
                    $sheet->getColumnDimension('T')->setWidth(16);
                    $sheet->getColumnDimension('U')->setWidth(20);
                    $sheet->getColumnDimension('V')->setWidth(20);

                    if(!empty($sql_tracer)){
                        $no    = 1;
                        $cell  = 6;
                        foreach ($sql_tracer as $trace){
                            $sheet->getStyle('A'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                            $sheet->getStyle('C'.$cell.':V'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                            
                            $sheet->setCellValue('A'.$cell, $no)
                                  ->setCellValue('B'.$cell, $trace->nama_pgl)
                                  ->setCellValue('C'.$cell, $this->tanggalan->tgl_indo($trace->tanggal))
                                  ->setCellValue('D'.$cell, $this->tanggalan->wkt_indo($trace->wkt_daftar))
                                  ->setCellValue('E'.$cell, $this->tanggalan->wkt_indo($trace->wkt_periksa))
                                  ->setCellValue('F'.$cell, $this->tanggalan->wkt_indo($trace->wkt_sampling_msk))
                                  ->setCellValue('G'.$cell, $this->tanggalan->wkt_indo($trace->wkt_sampling_klr))
                                  ->setCellValue('H'.$cell, $this->tanggalan->usia_wkt($trace->wkt_sampling_msk, $trace->wkt_sampling_klr))
                                  ->setCellValue('I'.$cell, $this->tanggalan->wkt_indo($trace->wkt_rad_msk))
                                  ->setCellValue('J'.$cell, $this->tanggalan->wkt_indo($trace->wkt_rad_krm))
                                  ->setCellValue('K'.$cell, $this->tanggalan->wkt_indo($trace->wkt_rad_baca))
                                  ->setCellValue('L'.$cell, $this->tanggalan->wkt_indo($trace->wkt_rad_klr))
                                  ->setCellValue('M'.$cell, $this->tanggalan->usia_wkt($trace->wkt_rad_msk, $trace->wkt_rad_klr))
                                  ->setCellValue('N'.$cell, $this->tanggalan->wkt_indo($trace->wkt_resep_msk))
                                  ->setCellValue('O'.$cell, $this->tanggalan->wkt_indo($trace->wkt_resep_klr))
                                  ->setCellValue('P'.$cell, $this->tanggalan->wkt_indo($trace->wkt_resep_trm))
                                  ->setCellValue('Q'.$cell, $this->tanggalan->usia_wkt($trace->wkt_resep_msk, $trace->wkt_resep_klr))
                                  ->setCellValue('R'.$cell, $this->tanggalan->tgl_indo5($trace->wkt_ranap))
                                  ->setCellValue('S'.$cell, $this->tanggalan->tgl_indo5($trace->wkt_ranap_keluar))
                                  ->setCellValue('T'.$cell, $this->tanggalan->usia_wkt($trace->wkt_ranap, $trace->wkt_ranap_keluar))
                                  ->setCellValue('U'.$cell, $this->tanggalan->tgl_indo5($trace->wkt_selesai))
                                  ->setCellValue('V'.$cell, $this->tanggalan->usia_wkt($trace->wkt_daftar, $trace->wkt_selesai));

                            $no++;
                            $cell++;
                        }
                    }
                    break;
            }

            // Rename worksheet
            $sheet->setTitle('LAP TRACER');

            // Page setup
            $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);
            $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);

            // Margins
            $sheet->getPageMargins()->setTop(0.25);
            $sheet->getPageMargins()->setRight(0);
            $sheet->getPageMargins()->setLeft(0);
            $sheet->getPageMargins()->setBottom(0);

            // Document properties
            $spreadsheet->getProperties()->setCreator("Mikhael Felian Waskito")
                        ->setLastModifiedBy($this->ion_auth->user()->row()->username)
                        ->setTitle("Laporan Tracer")
                        ->setSubject("Laporan Tracer")
                        ->setDescription("Kunjungi http://tigerasoft.co.id")
                        ->setKeywords("Tracer")
                        ->setCategory("Laporan");

            // Clean output buffer
            ob_end_clean();

            // Set headers for download
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="data_tracer_'.(isset($_GET['filename']) ? $_GET['filename'] : 'lap').'.xlsx"');
            header('Cache-Control: max-age=0');

            // Create Excel writer and output file
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
            exit;
        } else {
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function xls_data_stok_opname() {
        if (akses::aksesLogin() == TRUE) {
            // Get parameters
            $tgl = $this->input->get('tgl');
            $tgl_awal = $this->input->get('tgl_awal');
            $tgl_akhir = $this->input->get('tgl_akhir');
            $case = $this->input->get('case');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();
            
            // Create new Spreadsheet object
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            
            // Set header styles
            $sheet->getStyle('A1:J1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A1:J1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A1:J1')->getFont()->setBold(true);
            
            // Set headers
            $sheet->setCellValue('A1', 'NO')
                  ->setCellValue('B1', 'TANGGAL')
                  ->setCellValue('C1', 'GUDANG')
                  ->setCellValue('D1', 'KODE')
                  ->setCellValue('E1', 'PRODUK')
                  ->setCellValue('F1', 'JUMLAH FISIK')
                  ->setCellValue('G1', 'JUMLAH SISTEM')
                  ->setCellValue('H1', 'SELISIH')
                  ->setCellValue('I1', 'KETERANGAN')
                  ->setCellValue('J1', 'PETUGAS');
            
            // Set column widths
            $sheet->getColumnDimension('A')->setWidth(5);
            $sheet->getColumnDimension('B')->setWidth(15);
            $sheet->getColumnDimension('C')->setWidth(20);
            $sheet->getColumnDimension('D')->setWidth(15);
            $sheet->getColumnDimension('E')->setWidth(40);
            $sheet->getColumnDimension('F')->setWidth(15);
            $sheet->getColumnDimension('G')->setWidth(15);
            $sheet->getColumnDimension('H')->setWidth(10);
            $sheet->getColumnDimension('I')->setWidth(25);
            $sheet->getColumnDimension('J')->setWidth(15);
            
            // Query data
            $this->db->select('tbl_util_so.id, tbl_util_so.tgl_simpan, tbl_util_so.id_user, tbl_util_so.uuid, tbl_util_so.keterangan, tbl_util_so_det.id_produk, tbl_util_so_det.kode, tbl_util_so_det.produk, tbl_util_so_det.jml, tbl_util_so_det.jml_sys, tbl_util_so_det.jml_satuan, tbl_util_so_det.keterangan as keterangan_so, tbl_m_gudang.gudang');
            $this->db->from('tbl_util_so');
            $this->db->join('tbl_util_so_det', 'tbl_util_so_det.id_so = tbl_util_so.id');
            $this->db->join('tbl_m_gudang', 'tbl_m_gudang.id = tbl_util_so.id_gudang');
            
            switch ($case) {
                case 'per_tanggal':
                    $this->db->where('DATE(tbl_util_so.tgl_simpan)', $tgl);
                    break;
                
                case 'per_rentang':
                    $this->db->where('DATE(tbl_util_so.tgl_simpan) >=', $tgl_awal);
                    $this->db->where('DATE(tbl_util_so.tgl_simpan) <=', $tgl_akhir);
                    break;
            }
            
            $data_so = $this->db->get()->result();
            
            // Fill data rows
            $no = 1;
            $cell = 2;
            
            foreach ($data_so as $so) {
                $sheet->getStyle('A'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('B'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('F'.$cell.':H'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('J'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                
                // Get user name
                $user = $this->db->where('id', $so->id_user)->get('tbl_ion_users')->row();
                $petugas = isset($user->first_name) ? $user->first_name : '';
                
                $sheet->setCellValue('A'.$cell, $no)
                      ->setCellValue('B'.$cell, $this->tanggalan->tgl_indo($so->tgl_simpan))
                      ->setCellValue('C'.$cell, $so->gudang)
                      ->setCellValue('D'.$cell, $so->kode)
                      ->setCellValue('E'.$cell, $so->produk)
                      ->setCellValue('F'.$cell, $so->jml)
                      ->setCellValue('G'.$cell, $so->jml_sys)
                      ->setCellValue('H'.$cell, ($so->jml - $so->jml_sys))
                      ->setCellValue('I'.$cell, $so->keterangan)
                      ->setCellValue('J'.$cell, $petugas);
                
                $no++;
                $cell++;
            }
            
            // Rename worksheet
            $sheet->setTitle('STOK OPNAME');
            
            // Page setup
            $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
            $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
            
            // Margins
            $sheet->getPageMargins()->setTop(0.25);
            $sheet->getPageMargins()->setRight(0);
            $sheet->getPageMargins()->setLeft(0);
            $sheet->getPageMargins()->setBottom(0);
            
            // Document properties
            $spreadsheet->getProperties()->setCreator("Mikhael Felian Waskito")
                        ->setLastModifiedBy($this->ion_auth->user()->row()->username)
                        ->setTitle("Laporan Stok Opname")
                        ->setSubject("Laporan Stok Opname")
                        ->setDescription("Kunjungi http://tigerasoft.co.id");
            
            // Clean output buffer
            ob_end_clean();
            
            // Set headers for download
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="data_stok_opname_'.(isset($_GET['filename']) ? $_GET['filename'] : 'lap').'.xlsx"');
            header('Cache-Control: max-age=0');
            
            // Create Excel writer and output file
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
            exit;
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    public function laporan_referal() {
        if (akses::aksesLogin() == TRUE) {
            try {
                $pengaturan = $this->db->get('tbl_pengaturan')->row();

                // Get filters
                $tgl = $this->input->get('filter_tgl');
                $dokter = $this->input->get('filter_dokter');
                $status = $this->input->get('filter_status');
                $hal = $this->input->get('halaman');

                // Get doctors for filter dropdown
                $data['sql_doc'] = $this->db->where('id_user_group', '10')
                        ->get('tbl_m_karyawan')
                        ->result();
                
                // Count total rows first
                $query = $this->db->select('COUNT(*) as total')
                        ->from('tbl_trans_medcheck')
                        ->join('tbl_m_karyawan', 'tbl_m_karyawan.id_user = tbl_trans_medcheck.id_dokter', 'left')
                        ->where('tbl_trans_medcheck.status_hps', '0')
                        ->where('tbl_trans_medcheck.jml_fee >', 0);

                // Apply filters to count query
                if (!empty($tgl)) {
                    $query->where('DATE(tbl_trans_medcheck.tgl_masuk)', $this->tanggalan->tgl_indo_sys($tgl));
                }
                if (!empty($dokter)) {
                    $query->where('tbl_trans_medcheck.id_dokter', $dokter);
                }
                
                if ($status !== '') {
                    $query->where('tbl_trans_medcheck.status_fee', $status);
                }

                $count_result = $query->get();

                if ($count_result === FALSE) {
                    throw new Exception('Error executing count query: ' . $this->db->error()['message']);
                }

                $jml_sql = $count_result->row()->total;

                // Configure pagination
                $config['base_url'] = base_url('laporan/laporan_referal.php');
                $config['total_rows'] = $jml_sql;
                $config['per_page'] = $pengaturan->jml_item;
                $config['page_query_string'] = TRUE;
                $config['query_string_segment'] = 'halaman';
                $config['num_links'] = 2;
                $config['use_page_numbers'] = TRUE;
                $config['reuse_query_string'] = TRUE;

                $this->pagination->initialize($config);

                // Get paginated data
                $offset = ($hal) ? ($hal - 1) * $config['per_page'] : 0;

                // Main data query
                $data_query = $this->db->select('
               tbl_trans_medcheck.id,
               tbl_trans_medcheck.tgl_masuk,
               tbl_trans_medcheck.tgl_bayar_fee,
               tbl_trans_medcheck.status_fee,
               tbl_trans_medcheck.ket_fee,
               tbl_trans_medcheck.jml_fee,
               tbl_trans_medcheck.pasien,
               tbl_m_karyawan.nama_dpn,
               tbl_m_karyawan.nama,
               tbl_m_karyawan.nama_blk
           ')
                        ->from('tbl_trans_medcheck')
                        ->join('tbl_m_karyawan', 'tbl_m_karyawan.id_user = tbl_trans_medcheck.id_dokter', 'left')
                        ->where('tbl_trans_medcheck.status_hps', '0')
                        ->where('tbl_trans_medcheck.jml_fee >', 0);

                // Apply filters to data query
                if (!empty($tgl)) {
                    $data_query->where('DATE(tbl_trans_medcheck.tgl_masuk)', $this->tanggalan->tgl_indo_sys($tgl));
                }
                if (!empty($dokter)) {
                    $data_query->where('tbl_trans_medcheck.id_dokter', $dokter);
                }
                if ($status !== '') {
                    $data_query->where('tbl_trans_medcheck.status_fee', $status);
                }

                $data_query->limit($config['per_page'], $offset)
                        ->order_by('tbl_trans_medcheck.tgl_masuk', 'DESC');

                $result = $data_query->get();

                if ($result === FALSE) {
                    throw new Exception('Error executing data query: ' . $this->db->error()['message']);
                }

                $data['referal'] = $result->result();

                // Calculate total fee
                $data['total_all_fee'] = 0;
                foreach ($data['referal'] as $row) {
                    $data['total_all_fee'] += $row->jml_fee;
                }

                // Pagination data
                $data['total_rows'] = $jml_sql;
                $data['pagination'] = $this->pagination->create_links();

                /* Sidebar Menu */
                $data['sidebar'] = 'admin-lte-3/includes/laporan/sidebar_lap';

                /* Load views */
                $this->load->view('admin-lte-3/1_atas', $data);
                $this->load->view('admin-lte-3/2_header', $data);
                $this->load->view('admin-lte-3/3_navbar', $data);
                $this->load->view('admin-lte-3/includes/medcheck/laporan_referal', $data);
                $this->load->view('admin-lte-3/5_footer', $data);
                $this->load->view('admin-lte-3/6_bawah', $data);
            } catch (Exception $e) {
                log_message('error', $e->getMessage());
                $this->session->set_flashdata('error', 'Terjadi kesalahan saat memuat data: ' . $e->getMessage());
                redirect('laporan');
            }
        } else {
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function set_cari_referal() {
       if (akses::aksesLogin() == TRUE) {
           $tgl = $this->input->post('tgl');
           $dokter = $this->input->post('dokter');
           $status = $this->input->post('status');
           
           redirect(base_url('laporan/laporan_referal.php?'.
               (!empty($tgl) ? 'filter_tgl='.$tgl : '').
               (!empty($dokter) ? '&filter_dokter='.$dokter : '').
               (isset($status) ? '&filter_status='.$status : '')));
               
       } else {
           $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
           redirect();
       }
   }
   
   public function set_bayar_referal() {
       if (akses::aksesLogin() == TRUE) {
           try {
               $this->db->trans_begin();
               
               $id_medcheck = general::dekrip($this->input->post('id_medcheck'));
               $tgl_bayar = $this->tanggalan->tgl_indo_sys($this->input->post('tgl_bayar'));
               $keterangan = $this->input->post('keterangan');
               
               $data = array(
                   'tgl_bayar_fee' => $tgl_bayar,
                   'status_fee' => '1',
                   'ket_fee' => $keterangan
               );
               
               $this->db->where('id', $id_medcheck)->update('tbl_trans_medcheck', $data);
               
               if ($this->db->trans_status() === FALSE) {
                   throw new Exception('Gagal menyimpan pembayaran');
               }
               
               $this->db->trans_commit();
               $this->session->set_flashdata('form_error', '<div class="alert alert-success">Pembayaran berhasil disimpan</div>');
               
           } catch (Exception $e) {
               $this->db->trans_rollback();
               $this->session->set_flashdata('form_error', '<div class="alert alert-danger">'.$e->getMessage().'</div>');
           }
           
           redirect($_SERVER['HTTP_REFERER']);
           
       } else {
           $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
           redirect();
       }
   }
    
    
    

    
    public function json_pasien() {
        if (akses::aksesLogin() == TRUE) {
            $term  = $this->input->get('term');
            $sql   = $this->db->select('id, kode, kode_dpn, nik, nama_pgl, alamat, jns_klm, tgl_lahir')
                              ->like('nama',$term)
                              ->or_like('nik',$term)
                              ->or_like('alamat',$term)
                              ->limit(10)->get('tbl_m_pasien')->result();
            
            if(!empty($sql)){
                foreach ($sql as $sql){
                    $produk[] = array(
                        'id'         => $sql->id,
                        'id_pas'     => general::enkrip($sql->id),
                        'kode'       => $sql->kode_dpn.$sql->kode,
                        'nik'        => $sql->nik,
                        'nama'       => $sql->nama_pgl,
                        'nama2'      => $sql->nama,
                        'tgl_lahir'  => $sql->tgl_lahir,
                        'jns_klm'    => $sql->jns_klm,
                        'alamat'     => $sql->alamat,
                    );
                }
                
                if(!empty($term)){
                    echo json_encode($produk);
                }
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    
    
    
//    public function xls_data_stok_keluar(){
//        if (akses::aksesLogin() == TRUE) {
//            $jml        = $this->input->get('jml');
//            $tgl        = $this->input->get('tgl');
//            $tgl_awal   = $this->input->get('tgl_awal');
//            $tgl_akhir  = $this->input->get('tgl_akhir');
//            $case       = $this->input->get('case');
//            $hal        = $this->input->get('halaman');
//            $pengaturan = $this->db->get('tbl_pengaturan')->row();
//
//            $grup       = $this->ion_auth->get_users_groups()->row();
//            $id_user    = $this->ion_auth->user()->row()->id;
//            $id_grup    = $this->ion_auth->get_users_groups()->row();
//
//            
//            switch ($case) {
//                case 'per_tanggal':
//                    $sql_omset = $this->db->select('tbl_trans_medcheck.id, tbl_trans_medcheck.tgl_simpan, tbl_trans_medcheck.no_rm, tbl_trans_medcheck.no_nota, tbl_m_pasien.nama_pgl, tbl_m_pasien.tgl_lahir, tbl_trans_medcheck_det.id AS id_medcheck_det, tbl_trans_medcheck_det.kode, tbl_trans_medcheck_det.item, tbl_trans_medcheck_det.harga, tbl_trans_medcheck_det.jml, tbl_trans_medcheck_det.subtotal')
//                                                              ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_det.id_medcheck')
//                                                              ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
//                                                              ->where('tbl_trans_medcheck.status_bayar', '1')
//                                                              ->where('DATE(tbl_trans_medcheck_det.tgl_simpan)', $tgl)
//                                                              ->where('tbl_trans_medcheck_det.status', '4')
//                                                              ->order_by('DATE(tbl_trans_medcheck_det.tgl_simpan)', 'ASC')
//                                                          ->get('tbl_trans_medcheck_det')->result(); 
//                    break;
//
//                case 'per_rentang':
//                        $sql_omset     = $this->db->select('tbl_trans_medcheck.id, tbl_trans_medcheck.metode, tbl_trans_medcheck.no_rm, tbl_trans_medcheck.no_nota, tbl_trans_medcheck.tipe, tbl_m_pasien.nama_pgl, tbl_m_pasien.tgl_lahir, tbl_trans_medcheck_det.id AS id_medcheck_det, tbl_trans_medcheck_det.tgl_simpan, tbl_trans_medcheck_det.id_dokter, tbl_trans_medcheck_det.kode, tbl_trans_medcheck_det.item, tbl_trans_medcheck_det.harga, tbl_trans_medcheck_det.jml, tbl_trans_medcheck_det.subtotal, tbl_m_kategori.keterangan AS kategori')
//                                                              ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_det.id_medcheck')
//                                                              ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
//                                                              ->join('tbl_m_kategori', 'tbl_m_kategori.id=tbl_trans_medcheck_det.id_item_kat')
//                                                              ->where('tbl_trans_medcheck.status_hps', '0')
//                                                              ->where('tbl_trans_medcheck.status_bayar', '1')
//                                                              ->where('DATE(tbl_trans_medcheck_det.tgl_simpan) >=', $tgl_awal)
//                                                              ->where('DATE(tbl_trans_medcheck_det.tgl_simpan) <=', $tgl_akhir)
//                                                              ->where('tbl_trans_medcheck_det.status', '4')
//                                                              ->order_by('tbl_trans_medcheck_det.tgl_simpan', 'ASC')
//                                                          ->get('tbl_trans_medcheck_det')->result();
//                    break;
//            }
//
//            $objPHPExcel = new PHPExcel();
//
//            // Header Tabel Nota
//            $objPHPExcel->getActiveSheet()->getStyle('A4:N4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//            $objPHPExcel->getActiveSheet()->getStyle('A4:N4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
//            $objPHPExcel->getActiveSheet()->getStyle('A4:N4')->getFont()->setBold(TRUE);
//            $objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(40);
//
//            $objPHPExcel->setActiveSheetIndex(0)
//                    ->setCellValue('A4', 'No.')
//                    ->setCellValue('B4', 'Tgl')
//                    ->setCellValue('C4', 'Tipe')
//                    ->setCellValue('D4', 'Pasien')
//                    ->setCellValue('E4', 'No. Faktur')
//                    ->setCellValue('F4', 'Qty')
//                    ->setCellValue('G4', 'Kode')
//                    ->setCellValue('H4', 'Item')
//                    ->setCellValue('I4', 'Group')
//                    ->setCellValue('J4', 'Harga')
//                    ->setCellValue('K4', 'Subtotal')
//                    ->setCellValue('L4', 'Jenis')
//                    ->setCellValue('M4', 'Kode Jenis');
//
//            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(6);
//            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(18);
//            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(14);
//            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(50);
//            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
//            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(5);
//            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
//            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(40);
//            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(18);
//            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(14);
//            $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(14);
//            $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(30);
//            $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(14);
//            $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(14);
//
//            if(!empty($sql_omset)){
//                $no    = 1;
//                $cell  = 5;
//                $total = 0;
//                foreach ($sql_omset as $penjualan){
//                    $dokter     = $this->db->where('id_user', $penjualan->id_dokter)->get('tbl_m_karyawan')->row();
//                    $platform   = $this->db->where('id', $penjualan->metode)->get('tbl_m_platform')->row();
//                    $sub_js     = $remun->remun_nom * $penjualan->jml;
//                    $total      = $total + $penjualan->subtotal;
//                    $subtot     = $penjualan->harga * $penjualan->jml;
//
//                    $objPHPExcel->getActiveSheet()->getStyle('A'.$cell.':C'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//                    $objPHPExcel->getActiveSheet()->getStyle('E'.$cell.':G'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//                    $objPHPExcel->getActiveSheet()->getStyle('J'.$cell.':K'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//                    $objPHPExcel->getActiveSheet()->getStyle('L'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
////                    $objPHPExcel->getActiveSheet()->getStyle('B'.$cell.':J'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
////                    $objPHPExcel->getActiveSheet()->getStyle('K'.$cell.':N'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
////                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$cell, $val,PHPExcel_Cell_DataType::TYPE_STRING);
//                    $objPHPExcel->getActiveSheet()->getStyle('J'.$cell.':K'.$cell)->getNumberFormat()->setFormatCode("_(\"\"* #,##0_);_(\"\"* \(#,##0\);_(\"\"* \"-\"??_);_(@_)");
//               
//                    $objPHPExcel->setActiveSheetIndex(0)
//                            ->setCellValue('A'.$cell, $no)
//                            ->setCellValue('B'.$cell, $this->tanggalan->tgl_indo5($penjualan->tgl_simpan))
//                            ->setCellValue('C'.$cell, general::status_rawat2($penjualan->tipe))
//                            ->setCellValue('D'.$cell, $penjualan->nama_pgl)
//                            ->setCellValue('E'.$cell, $penjualan->no_rm)
//                            ->setCellValue('F'.$cell, (float)$penjualan->jml)
//                            ->setCellValue('G'.$cell, $penjualan->kode)
//                            ->setCellValue('H'.$cell, $penjualan->item)
//                            ->setCellValue('I'.$cell, $penjualan->kategori)
//                            ->setCellValue('J'.$cell, $penjualan->harga)
//                            ->setCellValue('K'.$cell, $subtot)
//                            ->setCellValue('L'.$cell, $platform->platform)
//                            ->setCellValue('M'.$cell, '');
//
//                    $no++;
//                    $cell++;
//                }
//
//                $sell1     = $cell;
//                
//                $objPHPExcel->getActiveSheet()->getStyle('L'.$cell)->getNumberFormat()->setFormatCode("_(\"\"* #,##0_);_(\"\"* \(#,##0\);_(\"\"* \"-\"??_);_(@_)");
//                $objPHPExcel->getActiveSheet()->getStyle('A'.$sell1.':F'.$sell1.'')->getFont()->setBold(TRUE);
//                $objPHPExcel->getActiveSheet()->getStyle('A'.$sell1.':F'.$sell1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//                $objPHPExcel->setActiveSheetIndex(0)
//                        ->setCellValue('A' . $sell1, '')->mergeCells('A'.$sell1.':K'.$sell1.'')
//                        ->setCellValue('L' . $sell1, $sql_omset_row->jml_gtotal);
//            }
//
//            // Rename worksheet
//            $objPHPExcel->getActiveSheet()->setTitle('Lap Omset');
//
//            /** Page Setup * */
//            $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
//            $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
//
//            /* -- Margin -- */
//            $objPHPExcel->getActiveSheet()
//                    ->getPageMargins()->setTop(0.25);
//            $objPHPExcel->getActiveSheet()
//                    ->getPageMargins()->setRight(0);
//            $objPHPExcel->getActiveSheet()
//                    ->getPageMargins()->setLeft(0);
//            $objPHPExcel->getActiveSheet()
//                    ->getPageMargins()->setFooter(0);
//
//
//            /** Page Setup * */
//            // Set document properties
//            $objPHPExcel->getProperties()->setCreator("Mikhael Felian Waskito")
//                    ->setLastModifiedBy($this->ion_auth->user()->row()->username)
//                    ->setTitle("Stok")
//                    ->setSubject("Aplikasi Bengkel POS")
//                    ->setDescription("Kunjungi http://tigerasoft.co.id")
//                    ->setKeywords("Pasifik POS")
//                    ->setCategory("Untuk mencetak nota dot matrix");
//
//
//
//            // Redirect output to a client’s web browser (Excel5)
//            header('Content-Type: application/vnd.ms-excel');
//            // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//            header('Content-Disposition: attachment;filename="data_stok_keluar_'.(isset($_GET['filename']) ? $_GET['filename'] : 'lap').'.xls"');
//
//            // If you're serving to IE over SSL, then the following may be needed
//            header('Expires: Mon, 15 Feb 1992 05:00:00 GMT'); // Date in the past
//            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
//            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
//            header('Pragma: public'); // HTTP/1.0
//
//            ob_clean();
//            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
//            $objWriter->save('php://output');
//            exit;
//        }else{
//            $errors = $this->ion_auth->messages();
//            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
//            redirect();
//        }
//    }
}
