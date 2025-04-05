<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
/**
 * Description of hris
 *
 * @author mike
 */
class Sdm extends CI_Controller {
    /**
     * Properties to suppress dynamic property creation warnings in PHP 8.2+
     */
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
    public $ion_auth_model;
    public $ion_auth;
    public $recaptcha;
    public $crud;
    public $akses;
    public $general;
    public $ciqrcode;
    public $bcrypt;
    public function __construct() {
        parent::__construct();
        $this->load->library('qrcode/ciqrcode');
    }
    
    public function index() {
        if (akses::aksesLogin() == TRUE) {
            /* -- Grup hak akses -- */
            $role        = $this->input->get('role');
            $grup        = $this->ion_auth->get_users_groups()->row();
            $id_user     = $this->ion_auth->user()->row()->id;
            $id_grup     = $this->ion_auth->get_users_groups()->row();
            $pengaturan  = $this->db->get('tbl_pengaturan')->row();
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/sdm/sidebar_sdm';
            /* --- Sidebar Menu --- */
            
            /* Load view tampilan */
            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/sdm/index', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_cuti_list() {
        if (akses::aksesLogin() == TRUE) {
            $hal             = $this->input->get('halaman');
            $filter_nama     = $this->input->get('filter_nama');
            $filter_status   = $this->input->get('filter_status');
            $filter_tp       = $this->input->get('tipe');
            $sort_type       = $this->input->get('sort_type');
            $sort_order      = $this->input->get('sort_order');
            $jml             = $this->input->get('jml');
            $jml_hal         = (!empty($jml) ? $jml  : $this->db->count_all('tbl_m_pasien'));
            $pengaturan      = $this->db->get('tbl_pengaturan')->row();
            
            $data['hasError']                = $this->session->flashdata('form_error');
                        
            $config['base_url']              = base_url('sdm/data_cuti_list.php?tipe='.$filter_tp.(isset($_GET['filter_nama']) ? '&filter_nama='.$this->input->get('filter_nama') : '').'&jml='.$_GET['jml']);
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
            
            
            if(!empty($hal)){
                    $data['sql_cuti'] = $this->db
                                             ->select('tbl_sdm_cuti.id, tbl_sdm_cuti.id_user, tbl_sdm_cuti.id_karyawan, tbl_sdm_cuti.tgl_simpan, tbl_sdm_cuti.tgl_masuk, tbl_sdm_cuti.tgl_keluar, tbl_sdm_cuti.keterangan, tbl_sdm_cuti.catatan, tbl_sdm_cuti.status, tbl_m_karyawan.nama, tbl_m_karyawan.tgl_lahir, tbl_m_karyawan.alamat, tbl_m_kategori_cuti.tipe')
                                             ->join('tbl_m_karyawan', 'tbl_m_karyawan.id=tbl_sdm_cuti.id_karyawan')
                                             ->join('tbl_m_kategori_cuti', 'tbl_m_kategori_cuti.id=tbl_sdm_cuti.id_kategori')
                                             ->where('tbl_sdm_cuti.id_kategori', $filter_tp)
                                             ->like('tbl_m_karyawan.nama', $filter_nama)
                                             ->like('tbl_sdm_cuti.status', $filter_status)
                                             ->limit($config['per_page'], $hal)->order_by('tbl_sdm_cuti.id', 'desc')->get('tbl_sdm_cuti')->result();
            }else{
                    $data['sql_cuti'] = $this->db
                                             ->select('tbl_sdm_cuti.id, tbl_sdm_cuti.id_user, tbl_sdm_cuti.id_karyawan, tbl_sdm_cuti.tgl_simpan, tbl_sdm_cuti.tgl_masuk, tbl_sdm_cuti.tgl_keluar, tbl_sdm_cuti.keterangan, tbl_sdm_cuti.catatan, tbl_sdm_cuti.status, tbl_m_karyawan.nama, tbl_m_karyawan.tgl_lahir, tbl_m_karyawan.alamat, tbl_m_kategori_cuti.tipe')
                                             ->join('tbl_m_karyawan', 'tbl_m_karyawan.id=tbl_sdm_cuti.id_karyawan')
                                             ->join('tbl_m_kategori_cuti', 'tbl_m_kategori_cuti.id=tbl_sdm_cuti.id_kategori')
                                             ->where('tbl_sdm_cuti.id_kategori', $filter_tp)
                                             ->like('tbl_m_karyawan.nama', $filter_nama)
                                             ->like('tbl_sdm_cuti.status', $filter_status)
                                             ->limit($config['per_page'])->order_by('tbl_sdm_cuti.id', 'desc')->get('tbl_sdm_cuti')->result();
            }
            
            $data['sql_kat_cuti']   = $this->db->get('tbl_m_kategori_cuti')->result();
            
            $this->pagination->initialize($config);
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/sdm/sidebar_sdm';
            /* --- Sidebar Menu --- */
            
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();
//            $data['cetak']      = '<button type="button" onclick="window.location.href = \''.base_url('master/cetak_data_customer.php?'.(!empty($query) ? 'query='.$query : '').(!empty($filter_produk) ? '&filter_produk='.$filter_produk : '').(!empty($filter_hpp) ? '&filter_hpp='.$filter_hpp : '').(!empty($filter_harga) ? '&filter_harga='.$filter_harga : '').(!empty($jml) ? '&jml='.$jml : '')).'\'" class="btn btn-warning btn-flat"><i class="fa fa-print"></i> Cetak</button>';

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/sdm/data_cuti_list', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_cuti_det() {
        if (akses::aksesLogin() == TRUE) {
            $id   = $this->input->get('id');
            
            if(!empty($id)){
                $data['sql_cuti']      = $this->db
                                              ->select('tbl_sdm_cuti.id, tbl_sdm_cuti.id_user, tbl_sdm_cuti.id_karyawan, tbl_sdm_cuti.tgl_simpan, tbl_sdm_cuti.tgl_masuk, tbl_sdm_cuti.tgl_keluar, tbl_sdm_cuti.keterangan, tbl_sdm_cuti.catatan, tbl_sdm_cuti.status, tbl_sdm_cuti.ttd, tbl_sdm_cuti.file_name, tbl_sdm_cuti.file_type, tbl_m_karyawan.nama, tbl_m_karyawan.tgl_lahir, tbl_m_karyawan.alamat, tbl_m_kategori_cuti.tipe')
                                              ->join('tbl_m_karyawan', 'tbl_m_karyawan.id=tbl_sdm_cuti.id_karyawan')
                                              ->join('tbl_m_kategori_cuti', 'tbl_m_kategori_cuti.id=tbl_sdm_cuti.id_kategori')
                                              ->where('tbl_sdm_cuti.id', general::dekrip($id))
                                              ->get('tbl_sdm_cuti')->row();
                
                $data['sql_cuti_list'] = $this->db
                                              ->where('id_karyawan', $data['sql_cuti']->id_karyawan)
                                              ->order_by('tgl_masuk','desc')->limit(2)->get('tbl_sdm_cuti')->result();
            }
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/sdm/sidebar_sdm';
            /* --- Sidebar Menu --- */

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/sdm/data_cuti_det', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_surat_krj_list() {
        if (akses::aksesLogin() == TRUE) {
            $hal             = $this->input->get('halaman');
            $filter_nama     = $this->input->get('filter_nama');
            $filter_tp       = $this->input->get('tipe');
            $sort_type       = $this->input->get('sort_type');
            $sort_order      = $this->input->get('sort_order');
            $jml             = $this->input->get('jml');
            $jml_hal         = (!empty($jml) ? $jml  : $this->db->count_all('tbl_m_pasien'));
            $pengaturan      = $this->db->get('tbl_pengaturan')->row();
            
            $data['hasError'] = $this->session->flashdata('form_error');
                        
            $config['base_url']               = base_url('sdm/data_surat_krj_list.php?tipe='.$filter_tp.(isset($_GET['filter_nama']) ? '&filter_nama='.$this->input->get('filter_nama') : '').'&jml='.$_GET['jml']);
            $config['total_rows']             = $jml_hal;
            
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
            
            
            if(!empty($hal)){
                 $data['sql_surat_krj'] = $this->db
                                             ->select('tbl_sdm_surat_krj.id, tbl_sdm_surat_krj.id_user, tbl_sdm_surat_krj.id_karyawan, tbl_sdm_surat_krj.tgl_simpan, tbl_sdm_surat_krj.tgl_masuk, tbl_sdm_surat_krj.tgl_keluar, tbl_sdm_surat_krj.keterangan, tbl_sdm_surat_krj.catatan, tbl_sdm_surat_krj.status, tbl_m_karyawan.nama, tbl_m_karyawan.tgl_lahir, tbl_m_karyawan.alamat')
                                             ->join('tbl_m_karyawan', 'tbl_m_karyawan.id=tbl_sdm_surat_krj.id_karyawan')
                                             ->join('tbl_m_kategori_cuti', 'tbl_m_kategori_cuti.id=tbl_sdm_surat_krj.id_kategori')
                                             ->like('tbl_m_karyawan.nama', $filter_nama)
                                             ->limit($config['per_page'], $hal)->order_by('tbl_sdm_surat_krj.id', 'desc')->get('tbl_sdm_surat_krj')->result();
            }else{
                 $data['sql_surat_krj'] = $this->db
                                             ->select('tbl_sdm_surat_krj.id, tbl_sdm_surat_krj.id_user, tbl_sdm_surat_krj.id_karyawan, tbl_sdm_surat_krj.tgl_simpan, tbl_sdm_surat_krj.tgl_masuk, tbl_sdm_surat_krj.tgl_keluar, tbl_sdm_surat_krj.keterangan, tbl_sdm_surat_krj.catatan, tbl_sdm_surat_krj.status, tbl_m_karyawan.nama, tbl_m_karyawan.tgl_lahir, tbl_m_karyawan.alamat')
                                             ->join('tbl_m_karyawan', 'tbl_m_karyawan.id=tbl_sdm_surat_krj.id_karyawan')
                                             ->like('tbl_m_karyawan.nama', $filter_nama)
                                             ->limit($config['per_page'])->order_by('tbl_sdm_surat_krj.id', 'desc')
                                             ->get('tbl_sdm_surat_krj')->result();
            }
            
            $data['sql_kat_cuti']   = $this->db->get('tbl_m_kategori_cuti')->result();
            
            $this->pagination->initialize($config);
            
            /* Sidebar Menu */
            $data['sidebar']        = 'admin-lte-3/includes/sdm/sidebar_sdm';
            /* --- Sidebar Menu --- */
            
            $data['total_rows']     = $config['total_rows'];
            $data['PerPage']        = $config['per_page'];
            $data['pagination']     = $this->pagination->create_links();

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/sdm/data_surat_krj_list', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_surat_krj_tambah() {
        if (akses::aksesLogin() == TRUE) {
            $id                 = $this->input->get('id');
            $pengaturan         = $this->db->get('tbl_pengaturan')->row();
          
            $data['sql_kary']   = $this->db->where('id', general::dekrip($id))->get('tbl_m_karyawan')->row();

            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/sdm/sidebar_sdm';
            /* --- Sidebar Menu --- */

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/sdm/data_surat_krj_tambah', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_surat_krj_det() {
        if (akses::aksesLogin() == TRUE) {
            $id                 = $this->input->get('id');
            $pengaturan         = $this->db->get('tbl_pengaturan')->row();
          
            $data['sql_krj']    = $this->db->where('id', general::dekrip($id))->get('tbl_sdm_surat_krj')->row();
            $data['sql_kary']   = $this->db->where('id', $data['sql_krj']->id_karyawan)->get('tbl_m_karyawan')->row();

            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/sdm/sidebar_sdm';
            /* --- Sidebar Menu --- */

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/sdm/data_surat_krj_det', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    

    
    public function data_surat_tgs_list() {
        if (akses::aksesLogin() == TRUE) {
            $hal             = $this->input->get('halaman');
            $filter_nama     = $this->input->get('filter_nama');
            $filter_tp       = $this->input->get('tipe');
            $sort_type       = $this->input->get('sort_type');
            $sort_order      = $this->input->get('sort_order');
            $jml             = $this->input->get('jml');
            $jml_hal         = (!empty($jml) ? $jml  : $this->db->count_all('tbl_m_pasien'));
            $pengaturan      = $this->db->get('tbl_pengaturan')->row();
            
            $data['hasError'] = $this->session->flashdata('form_error');
                        
            $config['base_url']               = base_url('sdm/data_surat_krj_list.php?tipe='.$filter_tp.(isset($_GET['filter_nama']) ? '&filter_nama='.$this->input->get('filter_nama') : '').'&jml='.$_GET['jml']);
            $config['total_rows']             = $jml_hal;
            
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
            
            
            if(!empty($hal)){
                 $data['sql_surat_tgs'] = $this->db
                                             ->select('tbl_sdm_surat_tgs.id, tbl_sdm_surat_tgs.id_user, tbl_sdm_surat_tgs.id_karyawan, tbl_sdm_surat_tgs.tgl_simpan, tbl_sdm_surat_tgs.tgl_masuk, tbl_sdm_surat_tgs.tgl_keluar, tbl_sdm_surat_tgs.keterangan, tbl_sdm_surat_tgs.catatan, tbl_sdm_surat_tgs.status, tbl_m_karyawan.nama, tbl_m_karyawan.tgl_lahir, tbl_m_karyawan.alamat')
                                             ->join('tbl_m_karyawan', 'tbl_m_karyawan.id=tbl_sdm_surat_tgs.id_karyawan')
                                             ->join('tbl_m_kategori_cuti', 'tbl_m_kategori_cuti.id=tbl_sdm_surat_tgs.id_kategori')
                                             ->like('tbl_m_karyawan.nama', $filter_nama)
                                             ->limit($config['per_page'], $hal)->order_by('tbl_sdm_surat_tgs.id', 'desc')->get('tbl_sdm_surat_tgs')->result();
            }else{
                 $data['sql_surat_tgs'] = $this->db
                                             ->select('tbl_sdm_surat_tgs.id, tbl_sdm_surat_tgs.id_user, tbl_sdm_surat_tgs.id_karyawan, tbl_sdm_surat_tgs.tgl_simpan, tbl_sdm_surat_tgs.tgl_masuk, tbl_sdm_surat_tgs.tgl_keluar, tbl_sdm_surat_tgs.keterangan, tbl_sdm_surat_tgs.catatan, tbl_sdm_surat_tgs.status, tbl_m_karyawan.nama, tbl_m_karyawan.tgl_lahir, tbl_m_karyawan.alamat')
                                             ->join('tbl_m_karyawan', 'tbl_m_karyawan.id=tbl_sdm_surat_tgs.id_karyawan')
                                             ->like('tbl_m_karyawan.nama', $filter_nama)
                                             ->limit($config['per_page'])->order_by('tbl_sdm_surat_tgs.id', 'desc')
                                             ->get('tbl_sdm_surat_tgs')->result();
            }
                        
            $this->pagination->initialize($config);
            
            /* Sidebar Menu */
            $data['sidebar']        = 'admin-lte-3/includes/sdm/sidebar_sdm';
            /* --- Sidebar Menu --- */
            
            $data['total_rows']     = $config['total_rows'];
            $data['PerPage']        = $config['per_page'];
            $data['pagination']     = $this->pagination->create_links();

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/sdm/data_surat_tgs_list', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_surat_tgs_tambah() {
        if (akses::aksesLogin() == TRUE) {
            $id                 = $this->input->get('id');
            $pengaturan         = $this->db->get('tbl_pengaturan')->row();
          
            $data['sql_kary']   = $this->db->where('id', general::dekrip($id))->get('tbl_m_karyawan')->row();

            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/sdm/sidebar_sdm';
            /* --- Sidebar Menu --- */

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/sdm/data_surat_tgs_tambah', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_surat_tgs_det() {
        if (akses::aksesLogin() == TRUE) {
            $id                     = $this->input->get('id');
            $pengaturan             = $this->db->get('tbl_pengaturan')->row();
          
            $data['sql_tgs']        = $this->db->where('id', general::dekrip($id))->get('tbl_sdm_surat_tgs')->row();
            $data['sql_tgs_tmbh']   = $this->db->where('id_surat_tgs', $data['sql_tgs']->id)->get('tbl_sdm_surat_tgs_kary')->result();
            $data['sql_kary']       = $this->db->where('id', $data['sql_tgs']->id_karyawan)->get('tbl_m_karyawan')->row();

            /* Sidebar Menu */
            $data['sidebar']        = 'admin-lte-3/includes/sdm/sidebar_sdm';
            /* --- Sidebar Menu --- */

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/sdm/data_surat_tgs_det', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_gaji_list() {
        if (akses::aksesLogin() == TRUE) {
            $hal             = $this->input->get('halaman');
            $filter_nama     = $this->input->get('filter_nama');
            $filter_tp       = $this->input->get('tipe');
            $sort_type       = $this->input->get('sort_type');
            $sort_order      = $this->input->get('sort_order');
            $jml             = $this->input->get('jml');
            $jml_hal         = (!empty($jml) ? $jml  : $this->db->count_all('tbl_m_pasien'));
            $pengaturan      = $this->db->get('tbl_pengaturan')->row();
            
            $data['hasError'] = $this->session->flashdata('form_error');
                        
            $config['base_url']               = base_url('sdm/data_gaji.php?tipe='.$filter_tp.(isset($_GET['filter_nama']) ? '&filter_nama='.$this->input->get('filter_nama') : '').'&jml='.$_GET['jml']);
            $config['total_rows']             = $jml_hal;
            
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
            
            
            if(!empty($hal)){
                 $data['sql_gaji'] = $this->db
                                             ->select('tbl_sdm_gaji.id, tbl_sdm_gaji.id_user, tbl_sdm_gaji.id_karyawan, tbl_sdm_gaji.tgl_simpan, tbl_sdm_gaji.tgl_masuk, tbl_sdm_gaji.tgl_keluar, tbl_sdm_gaji.keterangan, tbl_sdm_gaji.file_name, tbl_sdm_gaji.file_type, tbl_sdm_gaji.file_ext, tbl_sdm_gaji.status, tbl_m_karyawan.nama, tbl_m_karyawan.tgl_lahir, tbl_m_karyawan.alamat')
                                             ->join('tbl_m_karyawan', 'tbl_m_karyawan.id=tbl_sdm_gaji.id_karyawan')
                                             ->join('tbl_m_kategori_cuti', 'tbl_m_kategori_cuti.id=tbl_sdm_gaji.id_kategori')
                                             ->like('tbl_m_karyawan.nama', $filter_nama)
                                             ->limit($config['per_page'], $hal)->order_by('tbl_sdm_gaji.id', 'desc')->get('tbl_sdm_gaji')->result();
            }else{
                 $data['sql_gaji'] = $this->db
                                             ->select('tbl_sdm_gaji.id, tbl_sdm_gaji.id_user, tbl_sdm_gaji.id_karyawan, tbl_sdm_gaji.tgl_simpan, tbl_sdm_gaji.tgl_masuk, tbl_sdm_gaji.tgl_keluar, tbl_sdm_gaji.keterangan, tbl_sdm_gaji.file_name, tbl_sdm_gaji.file_type, tbl_sdm_gaji.file_ext, tbl_sdm_gaji.status, tbl_m_karyawan.nama, tbl_m_karyawan.tgl_lahir, tbl_m_karyawan.alamat')
                                             ->join('tbl_m_karyawan', 'tbl_m_karyawan.id=tbl_sdm_gaji.id_karyawan')
                                             ->like('tbl_m_karyawan.nama', $filter_nama)
                                             ->limit($config['per_page'])->order_by('tbl_sdm_gaji.id', 'desc')
                                             ->get('tbl_sdm_gaji')->result();
            }
                        
            $this->pagination->initialize($config);
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/sdm/sidebar_sdm';
            /* --- Sidebar Menu --- */
            
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();
//            $data['cetak']      = '<button type="button" onclick="window.location.href = \''.base_url('master/cetak_data_customer.php?'.(!empty($query) ? 'query='.$query : '').(!empty($filter_produk) ? '&filter_produk='.$filter_produk : '').(!empty($filter_hpp) ? '&filter_hpp='.$filter_hpp : '').(!empty($filter_harga) ? '&filter_harga='.$filter_harga : '').(!empty($jml) ? '&jml='.$jml : '')).'\'" class="btn btn-warning btn-flat"><i class="fa fa-print"></i> Cetak</button>';

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/sdm/data_gaji_list', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_gaji_tambah() {
        if (akses::aksesLogin() == TRUE) {
            $id                 = $this->input->get('id');
            $pengaturan         = $this->db->get('tbl_pengaturan')->row();
          
            $data['sql_kary']   = $this->db->where('id', general::dekrip($id))->get('tbl_m_karyawan')->row();

            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/sdm/sidebar_sdm';
            /* --- Sidebar Menu --- */

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/sdm/data_gaji_tambah', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_gaji_det() {
        if (akses::aksesLogin() == TRUE) {
            $id                 = $this->input->get('id');
            $pengaturan         = $this->db->get('tbl_pengaturan')->row();
          
            $data['sql_gaji']   = $this->db->where('id', general::dekrip($id))->get('tbl_sdm_gaji')->row();
            $data['sql_kary']   = $this->db->where('id', $data['sql_gaji']->id_karyawan)->get('tbl_m_karyawan')->row();

            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/sdm/sidebar_sdm';
            /* --- Sidebar Menu --- */

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/sdm/data_gaji_det', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_absen_list() {
        if (akses::aksesLogin() == TRUE) {
            $hal             = $this->input->get('halaman');
            $filter_nama     = $this->input->get('filter_nama');
            $filter_tgl      = $this->input->get('filter_tgl');
            $filter_tp       = $this->input->get('tipe');
            $sort_type       = $this->input->get('sort_type');
            $sort_order      = $this->input->get('sort_order');
            $jml             = $this->input->get('jml');
            $jml_hal         = (!empty($jml) ? $jml  : $this->db->count_all('tbl_m_pasien'));
            $pengaturan      = $this->db->get('tbl_pengaturan')->row();
            
            $data['hasError'] = $this->session->flashdata('form_error');
                        
            $config['base_url']               = base_url('sdm/data_absen.php?tipe='.$filter_tp.(isset($_GET['filter_nama']) ? '&filter_nama='.$this->input->get('filter_nama') : '').(isset($_GET['filter_tgl']) ? '&filter_tgl='.$this->input->get('filter_tgl') : '').'&jml='.$_GET['jml']);
            $config['total_rows']             = $jml_hal;
            
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
            
            
            if(!empty($hal)){
                 $data['sql_absen'] = $this->db
                                             ->like('nama', $filter_nama)
                                             ->like('tgl_masuk', $filter_tgl)
                                             ->limit($config['per_page'])->order_by('id', 'asc')
                                             ->get('v_karyawan_absen')->result();
            }else{
                 $data['sql_absen'] = $this->db
                                             ->like('nama', $filter_nama)
                                             ->like('tgl_masuk', $filter_tgl)
                                             ->limit($config['per_page'])->order_by('id', 'asc')
                                             ->get('v_karyawan_absen')->result();
            }
                        
            $this->pagination->initialize($config);
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/sdm/sidebar_sdm';
            /* --- Sidebar Menu --- */
            
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();
//            $data['cetak']      = '<button type="button" onclick="window.location.href = \''.base_url('master/cetak_data_customer.php?'.(!empty($query) ? 'query='.$query : '').(!empty($filter_produk) ? '&filter_produk='.$filter_produk : '').(!empty($filter_hpp) ? '&filter_hpp='.$filter_hpp : '').(!empty($filter_harga) ? '&filter_harga='.$filter_harga : '').(!empty($jml) ? '&jml='.$jml : '')).'\'" class="btn btn-warning btn-flat"><i class="fa fa-print"></i> Cetak</button>';

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/sdm/data_absen_list', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_absen_tambah() {
        if (akses::aksesLogin() == TRUE) {
            $id                 = $this->input->get('id');
            $pengaturan         = $this->db->get('tbl_pengaturan')->row();
          
            $data['sql_kary']   = $this->db->where('id', general::dekrip($id))->get('tbl_m_karyawan')->row();

            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/sdm/sidebar_sdm';
            /* --- Sidebar Menu --- */

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/sdm/data_absen_tambah', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    
    public function set_cuti_simpan() {
        if (akses::aksesLogin() == TRUE) {
            $id         = $this->input->post('id');
            $ket        = $this->input->post('ket');
            $tgl_rtg    = $this->input->post('tgl_rentang');
//            $tgl_msk    = $this->input->post('tgl_masuk');
//            $tgl_klr    = $this->input->post('tgl_keluar');
            $tipe       = $this->input->post('tipe');
            $rute       = $this->input->post('route');
            
            $pengaturan   = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id', 'NIK', 'required');
            $this->form_validation->set_rules('ket', 'Kode', 'required');
            $this->form_validation->set_rules('tgl_rentang', 'Tgl Join', 'required');
            
            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'id'            => form_error('id'),
                    'ket'           => form_error('ket'),
                    'tgl_rentang'   => form_error('tgl_rentang'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url((!empty($rute) ? $rute.'&id='.$id : 'master/data_karyawan_cuti.php?id='.$id)));
            } else {
               $sql_kary    = $this->db->where('id', general::dekrip($id))->get('tbl_m_karyawan')->row();
               $tgl_rentang = explode('-', $tgl_rtg);
               $tgl_awal    = $this->tanggalan->tgl_indo_sys($tgl_rentang[0]);
               $tgl_akhir   = $this->tanggalan->tgl_indo_sys($tgl_rentang[1]); 
               $sql_cek     = $this->db->where('YEAR(tgl_simpan)', date('Y'))->where('MONTH(tgl_simpan)', date('m'))->get('tbl_sdm_cuti');
               $urut        = $sql_cek->num_rows() + 1;
               $nomor       = sprintf('%02d', $urut).'/'.$pengaturan->kode_surat_cuti.'/'.general::format_romawi(date('m')).'/'.date('Y'); 
               
               $path        = 'file/user/userid_'.sprintf('%03d',$this->ion_auth->user()->row()->id).'/sdm';
                              
               # File untuk unggah berkas keperluan cuti ijin
               if (!empty($_FILES['fupload']['name'])) {              
                    # Buat Folder Untuk File Karyawan
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }
                    
                    $config['upload_path']      = realpath($path);
                    $config['allowed_types']    = 'jpg|png|pdf|jpeg';
                    $config['remove_spaces']    = TRUE;
                    $config['overwrite']        = TRUE;
                    $config['file_name']        = 'ijin_'.$tipe.date('YmdHi');
                    $this->load->library('upload', $config);
                    
                    if (!$this->upload->do_upload('fupload')) {
                        $this->session->set_flashdata('pengaturan_toast', 'toastr.error("Gagal : <b>'.$this->upload->display_errors().'</b>");');
                        redirect(base_url('profile.php?page=profile_cuti&id='.$id));
                    } else {
                        $f          = $this->upload->data();
                        $file_name  = $f['orig_name'];
                        $file_type  = $f['file_type'];
                        $file_ext   = $f['file_ext'];
                        
                        $berkas = $path.'/'.$file_name;
                    }
                }
               
               $data = array(
                   'id_karyawan'    => $sql_kary->id,
                   'id_user'        => $this->ion_auth->user()->row()->id,
                   'id_kategori'    => $tipe,
                   'tgl_simpan'     => date('Y-m-d H:i:s'),
                   'tgl_masuk'      => (!empty($tgl_awal) ? $tgl_awal : '0000-00-00'),
                   'tgl_keluar'     => (!empty($tgl_akhir) ? $tgl_akhir : '0000-00-00'),
                   'no_surat'       => $nomor,
                   'keterangan'     => $ket,
                   'file_name'      => $berkas,
                   'file_type'      => $file_type,
                   'file_ext'       => $file_ext,
                   'status'         => '0',
               );
                
               $this->db->insert('tbl_sdm_cuti', $data);
               
               $this->session->set_flashdata('sdm_toast', 'toastr.success("Cuti berhasil diajukan !");');
               redirect(base_url((!empty($rute) ? $rute.'&id='.general::enkrip($sql_kary->id) : 'master/data_karyawan_peg.php?id='.$id)));
              
//                echo '<pre>';
//                print_r($tgl_rentang);
//                echo '</pre>';
//                echo '<pre>';
//                print_r($data);
//                echo '</pre>';
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_cuti_update() {
        if (akses::aksesLogin() == TRUE) {
            $id         = $this->input->post('id');
            $tgl_msk    = $this->input->post('tgl_masuk');
            $tgl_klr    = $this->input->post('tgl_keluar');
            $status     = $this->input->post('status');
            $catatan    = $this->input->post('catatan');
            $foto       = $this->input->post('ttd');
            $rute       = $this->input->post('route');
            
            $pengaturan   = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id', 'NIK', 'required');
//            $this->form_validation->set_rules('ket', 'Kode', 'required');
//            $this->form_validation->set_rules('tgl_masuk', 'Tgl Join', 'required');
//            $this->form_validation->set_rules('tgl_keluar', 'Tgl Join', 'required');
            
            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'id'            => form_error('id'),
//                    'ket'           => form_error('ket'),
//                    'tgl_masuk'     => form_error('tgl_masuk'),
//                    'tgl_keluar'    => form_error('tgl_keluar'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url((!empty($rute) ? $rute.'&id='.$id : 'sdm/data_cuti_det.php?id='.$id)));
            } else {
               $sql_cuti    = $this->db->where('id', general::dekrip($id))->get('tbl_sdm_cuti')->row();
               $sql_kary    = $this->db->where('id', $sql_cuti->id_karyawan)->get('tbl_m_karyawan')->row();
               $tgl_awal    = $this->tanggalan->tgl_indo_sys($tgl_msk);
               $tgl_akhir   = $this->tanggalan->tgl_indo_sys($tgl_klr);
               
                # Config File Foto Pasien
                $path               = 'file/karyawan/'.$sql_kary->id.'/';
                
                # Buat Folder Untuk Foto Pasien
                if(!file_exists($path)){
                    mkdir($path, 0777, true);
                }

                # Simpan foto dari kamera ke dalam format file *.png dari base64
                if (!empty($foto)) {
                    $filename           = $path.'ttd_cuti_'.date('Ymd').'.png';
                    general::base64_to_jpeg($foto, $filename);
                }
               
               $data = array(
                   'tgl_modif'      => date('Y-m-d H:i:s'),
                   'id_manajemen'   => $this->ion_auth->user()->row()->id,
                   'catatan'        => $catatan,
                   'status'         => $status,
                   'ttd'            => $filename,
               );
               
               $this->db->where('id', general::dekrip($id))->update('tbl_sdm_cuti', $data);
               
               $this->session->set_flashdata('sdm_toast', 'toastr.success("Pengajuan cuti berhasil disimpan !");');
//               redirect(base_url((!empty($rute) ? $rute.'&id='.general::enkrip($sql_kary->id) : 'sdm/data_cuti_det.php?id='.$id)));
              
//                echo general::dekrip($id);
//                echo '<pre>';
//                print_r($data);
//                echo '</pre>';
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_cuti_hapus() {
        if (akses::aksesLogin() == TRUE) {
            $id = $this->input->get('id');
            $fl = $this->input->get('file_name');
            
            if(!empty($id)){
               $file = realpath(general::dekrip($fl));
                
                # Cek filenya ada atau tidak
                if (file_exists($file)) {
                    unlink($file);
                }
                
                $this->db->where('id',general::dekrip($id))->delete('tbl_sdm_cuti');
                
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('sdm_toast', 'toastr.success("Pengajuan cuti berhasil dihapus !");');
                }
            }
            
            redirect(base_url('profile.php?page=profile_cuti&id='.$id));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_surat_krj_simpan() {
        if (akses::aksesLogin() == TRUE) {
            $id         = $this->input->post('id_karyawan');
            $tgl_msk    = $this->input->post('tgl_surat');
            $ket        = $this->input->post('ket');
            $rute       = $this->input->post('route');
            
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id_karyawan', 'NIK', 'required');
            $this->form_validation->set_rules('ket', 'Keterangan', 'required');
            
            if ($this->form_validation->run() == FALSE) {
                $msg_error = [
                    'id_karyawan'   => form_error('id_karyawan'),
                    'ket'           => form_error('ket'),
                ];

                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url((!empty($rute) ? $rute.'&id='.$id : 'sdm/data_karyawan_cuti.php?id='.$id)));
            } else {
               $pengaturan  = $this->db->get('tbl_pengaturan')->row();
               $sql_kary    = $this->db->where('id', general::dekrip($id))->get('tbl_m_karyawan')->row();
               $sql_cek     = $this->db->where('YEAR(tgl_simpan)', date('Y'))->where('MONTH(tgl_simpan)', date('m'))->get('tbl_sdm_surat_krj');
               $tgl_awal    = $this->tanggalan->tgl_indo_sys($tgl_msk);
               $urut        = $sql_cek->num_rows() + 1;
               $nomor       = sprintf('%02d', $urut).'/'.$pengaturan->kode_surat_krj.'/'.general::format_romawi(date('m')).'/'.date('Y');                
               
               $data = [
                   'id_karyawan'    => $sql_kary->id,
                   'id_user'        => $this->ion_auth->user()->row()->id,
                   'kode'           => $nomor,
                   'tgl_simpan'     => date('Y-m-d H:i:s'),
                   'tgl_masuk'      => (!empty($tgl_awal) ? $tgl_awal : '0000-00-00'),
                   'keterangan'     => $ket,
                   'status'         => '0',
               ];
                
               $this->db->insert('tbl_sdm_surat_krj', $data);
               
               $this->session->set_flashdata('sdm_toast', 'toastr.success("Surat keterangan berhasil dibuat !");');
               redirect(base_url((!empty($rute) ? $rute.'&id='.general::enkrip($sql_kary->id) : 'sdm/data_surat_krj_tambah.php')));
            }
        } else {
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_surat_tgs_simpan() {
        if (akses::aksesLogin() == TRUE) {
            $id         = $this->input->post('id_karyawan');
            $tgl_msk    = $this->input->post('tgl_masuk');
            $tgl_klr    = $this->input->post('tgl_keluar');
            $judul      = $this->input->post('judul');
            $ket        = $this->input->post('ket');
            $rute       = $this->input->post('route');
            
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id_karyawan', 'NIK', 'required');
            $this->form_validation->set_rules('ket', 'Keterangan', 'required');
            
            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'id_karyawan'   => form_error('id_karyawan'),
                    'ket'           => form_error('ket'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url((!empty($rute) ? $rute.'&id='.$id : 'sdm/data_karyawan_cuti.php?id='.$id)));
            } else {
               $pengaturan  = $this->db->get('tbl_pengaturan')->row();
               $sql_kary    = $this->db->where('id', general::dekrip($id))->get('tbl_m_karyawan')->row();
               $sql_cek     = $this->db->where('YEAR(tgl_simpan)', date('Y'))->where('MONTH(tgl_simpan)', date('m'))->get('tbl_sdm_surat_tgs');
               $tgl_awal    = $this->tanggalan->tgl_indo_sys($tgl_msk);
               $tgl_akhir   = $this->tanggalan->tgl_indo_sys($tgl_klr);
               $urut        = $sql_cek->num_rows() + 1;
               $nomor       = sprintf('%02d', $urut).'/'.$pengaturan->kode_surat_tgs.'/'.general::format_romawi(date('m')).'/'.date('Y');
               
               echo $nomor;
                
               
               $data = array(
                   'id_karyawan'    => $sql_kary->id,
                   'id_user'        => $this->ion_auth->user()->row()->id,
                   'kode'           => $nomor,
                   'tgl_simpan'     => date('Y-m-d H:i:s'),
                   'tgl_masuk'      => (!empty($tgl_awal) ? $tgl_awal : '0000-00-00'),
                   'tgl_keluar'     => (!empty($tgl_akhir) ? $tgl_akhir : '0000-00-00'),
                   'judul'          => $judul,
                   'keterangan'     => $ket,
                   'status'         => '0',
               );
                
               $this->db->insert('tbl_sdm_surat_tgs', $data);
               
               $this->session->set_flashdata('sdm_toast', 'toastr.success("Surat tugas berhasil dibuat !");');
               redirect(base_url((!empty($rute) ? $rute.'&id='.general::enkrip($sql_kary->id) : 'sdm/data_surat_tgs_tambah.php')));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_surat_tgs_simpan_kary() {
        if (akses::aksesLogin() == TRUE) {
            $id         = $this->input->post('id');
            $id_kry     = $this->input->post('id_karyawan');
            $rute       = $this->input->post('route');
            
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id_karyawan', 'NIK', 'required');
            $this->form_validation->set_rules('id', 'ID', 'required');
            
            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'id_karyawan'   => form_error('id_karyawan'),
                    'id'           => form_error('id'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url((!empty($rute) ? $rute.'&id='.$id : 'sdm/data_surat_tgs_det.php?id='.$id)));
            } else {
                $sql_kary       = $this->db->where('id', general::dekrip($id_kry))->get('tbl_m_karyawan')->row();
                $sql_kary_tmbh  = $this->db->where('id_surat_tgs', general::dekrip($id))->get('tbl_sdm_surat_tgs_kary');
                
                $data = array(
                   'id_surat_tgs' => general::dekrip($id),
                   'id_karyawan'  => $sql_kary->id,
                   'id_user'      => $this->ion_auth->user()->row()->id,
                   'nik'          => $sql_kary->nik,
                   'nama'         => (!empty($sql_kary->nama_dpn) ? $sql_kary->nama_dpn.' ' : '').$sql_kary->nama.(!empty($sql_kary->nama_blk) ? ', '.$sql_kary->nama_blk : ''),
                );
                
                if($sql_kary_tmbh->num_rows() == 2){
                    $this->session->set_flashdata('sdm_toast', 'toastr.error("Maksimal 2 nama yang ditambahkan !");');
                }else{
                    $this->db->insert('tbl_sdm_surat_tgs_kary', $data);
                    $this->session->set_flashdata('sdm_toast', 'toastr.success("Nama berhasil ditambahkan !");');
                }
                
                redirect(base_url((!empty($rute) ? $rute.'&id='.general::enkrip($sql_kary->id) : 'sdm/data_surat_tgs_det.php?id='.$id)));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_surat_tgs_hapus_kary() {
        if (akses::aksesLogin() == TRUE) {
            $id = $this->input->get('id');
            $sr = $this->input->get('id_surat');
            
            if(!empty($id)){                
                $this->db->where('id',general::dekrip($id))->delete('tbl_sdm_surat_tgs_kary');
                
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('sdm_toast', 'toastr.success("Karyawan berhasil dihapus !");');
                }
            }
            
            redirect(base_url('sdm/data_surat_tgs_det.php?id='.$sr));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_gaji_simpan() {
        if (akses::aksesLogin() == TRUE) {
            $id         = $this->input->post('id_karyawan');
            $tgl_msk    = $this->input->post('tgl_masuk');
            $judul      = $this->input->post('judul');
            $ket        = $this->input->post('ket');
            $rute       = $this->input->post('route');
            
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id_karyawan', 'NIK', 'required');
            $this->form_validation->set_rules('ket', 'Keterangan', 'required');
            
            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'id_karyawan'   => form_error('id_karyawan'),
                    'ket'           => form_error('ket'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url((!empty($rute) ? $rute.'&id='.$id : 'sdm/data_gaji_tambah.php?id='.$id)));
            } else {
               $pengaturan  = $this->db->get('tbl_pengaturan')->row();
               $sql_kary    = $this->db->where('id', general::dekrip($id))->get('tbl_m_karyawan')->row();
               $tgl_awal    = $this->tanggalan->tgl_indo_sys($tgl_msk);
               $path        = 'file/karyawan/'.$sql_kary->id.'/';
               
               # Buat Folder Untuk File Gaji
               if (!empty($_FILES['fupload']['name'])) {                   
                    # Buat Folder Untuk File Karyawan
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }
                    
                    $config_ktp['upload_path']      = realpath($path);
                    $config_ktp['allowed_types']    = 'jpg|pdf';
                    $config_ktp['remove_spaces']    = TRUE;
                    $config_ktp['overwrite']        = TRUE;
                    $config_ktp['file_name']        = 'file_gaji_'.$sql_kary->id.sprintf('%05d', rand(1,256));
                    $this->load->library('upload', $config_ktp);
                    
                    if (!$this->upload->do_upload('fupload')) {
                        $this->session->set_flashdata('master_toast', 'toastr.error("Error : <b>'.$this->upload->display_errors().'</b>");');
//                        redirect((!empty($rute) ? $rute.'&id='.general::enkrip($sql_kary->id) : 'master/data_karyawan_kel.php?id='.$id));
                    } else {
                        $f_ktp          = $this->upload->data();
                        $file_name_gji  = $f_ktp['orig_name'];
                        $file_type      = $f_ktp['file_type'];
                        $file_ext       = $f_ktp['file_ext'];
                    }
                }

               $data = array(
                   'id_karyawan'    => $sql_kary->id,
                   'id_user'        => $this->ion_auth->user()->row()->id,
                   'tgl_simpan'     => date('Y-m-d H:i:s'),
                   'tgl_masuk'      => (!empty($tgl_awal) ? $tgl_awal : '0000-00-00'),
                   'keterangan'     => $ket,
                   'file_name'      => $file_name_gji,
                   'file_type'      => $file_type,
                   'file_ext'       => $file_ext,
                   'status'         => '0',
               );
                
               $this->db->insert('tbl_sdm_gaji', $data);
               
               $this->session->set_flashdata('sdm_toast', 'toastr.success("Data gaji berhasil diunggah !");');
               redirect(base_url((!empty($rute) ? $rute.'&id='.general::enkrip($sql_kary->id) : 'sdm/data_gaji.php')));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_absen_simpan() {
        if (akses::aksesLogin() == TRUE) {
            $id         = $this->input->post('id_karyawan');
            $tgl_msk    = $this->input->post('tgl_masuk');
            $judul      = $this->input->post('judul');
            $ket        = $this->input->post('ket');
            $rute       = $this->input->post('route');
            
//            $this->session->set_flashdata('sdm_toast', 'toastr.error("Error : <b>Nama tidak sesuai</b>");');
//            redirect(base_url('sdm/data_absen.php'));
            
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

//            $this->form_validation->set_rules('id_karyawan', 'NIK', 'required');
            $this->form_validation->set_rules('ket', 'Keterangan', 'required');
            
            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
//                    'id_karyawan'   => form_error('id_karyawan'),
                    'ket'           => form_error('ket'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url((!empty($rute) ? $rute.'&id='.$id : 'sdm/data_absen_tambah.php?id='.$id)));
            } else {
               $pengaturan  = $this->db->get('tbl_pengaturan')->row();
               $sql_kary    = $this->db->where('id', general::dekrip($id))->get('tbl_m_karyawan')->row();
               $tgl_awal    = $this->tanggalan->tgl_indo_sys($tgl_msk);
               $path        = 'file/karyawan/'.$sql_kary->id.'/';
               
               # Buat Folder Untuk File Gaji
               if (!empty($_FILES['fupload']['name'])) {                   
//                    # Buat Folder Untuk File Karyawan
//                    if (!file_exists($path)) {
//                        mkdir($path, 0777, true);
//                    }
//                    
//                    $config_ktp['upload_path']      = realpath($path);
//                    $config_ktp['allowed_types']    = 'jpg|pdf';
//                    $config_ktp['remove_spaces']    = TRUE;
//                    $config_ktp['overwrite']        = TRUE;
//                    $config_ktp['file_name']        = 'file_gaji_'.$sql_kary->id.sprintf('%05d', rand(1,256));
//                    $this->load->library('upload', $config_ktp);
//                    
//                    if (!$this->upload->do_upload('fupload')) {
//                        $this->session->set_flashdata('sdm_toast', 'toastr.error("Error : <b>'.$this->upload->display_errors().'</b>");');                        
////                        redirect((!empty($rute) ? $rute.'&id='.general::enkrip($sql_kary->id) : 'master/data_karyawan_kel.php?id='.$id));
//                    } else {
//                        $f_ktp          = $this->upload->data();
//                        $file_name_gji  = $f_ktp['orig_name'];
//                        $file_type      = $f_ktp['file_type'];
//                        $file_ext       = $f_ktp['file_ext'];
//                    }
                }else{
                   $this->session->set_flashdata('sdm_toast', 'toastr.error("Error : <b>File tidak ada</b>");');
                   redirect(base_url((!empty($rute) ? $rute.'&id='.general::enkrip($sql_kary->id) : 'sdm/data_absen_tambah.php')));
                }

//               $data = array(
//                   'id_karyawan'    => $sql_kary->id,
//                   'id_user'        => $this->ion_auth->user()->row()->id,
//                   'tgl_simpan'     => date('Y-m-d H:i:s'),
//                   'tgl_masuk'      => (!empty($tgl_awal) ? $tgl_awal : '0000-00-00'),
//                   'keterangan'     => $ket,
//                   'file_name'      => $file_name_gji,
//                   'file_type'      => $file_type,
//                   'file_ext'       => $file_ext,
//                   'status'         => '0',
//               );
//                
//               $this->db->insert('tbl_sdm_gaji', $data);
               
               $this->session->set_flashdata('sdm_toast', 'toastr.error("Data nama tidak ditemukan pada data karyawan !");');
               redirect(base_url((!empty($rute) ? $rute.'&id='.general::enkrip($sql_kary->id) : 'sdm/data_absen_tambah.php')));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_cari_cuti() {
        if (akses::aksesLogin() == TRUE) {
            $kary   = $this->input->post('nama');
            $tipe   = $this->input->post('tipe');
            $rute   = $this->input->post('route');
            $status = $this->input->post('status');
            
            $jml =  $this->db
                         ->select('tbl_sdm_cuti.id')
                         ->join('tbl_m_karyawan', 'tbl_m_karyawan.id=tbl_sdm_cuti.id_karyawan')
                         ->like('tbl_m_karyawan.nama', $kary)
                         ->like('tbl_sdm_cuti.status', $status, (!empty($status) ? 'none' : ''))
                         ->get('tbl_sdm_cuti')->num_rows();
            
//            if($jml > 0){
                redirect(base_url('sdm/'.(!empty($rute) ? $rute : 'data_cuti_list.php?tipe='.$tipe).'&'.(!empty($kary) ? 'filter_nama='.$kary.'&' : '').(isset($status) ? 'filter_status='.$status.'&' : '').'jml='.$jml));
//            }else{
//                redirect(base_url('sdm/'.(!empty($rute) ? $rute : 'data_cuti_list.php?tipe='.$tipe).'&msg=Pencarian tidak di temukan!!'));
//            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_cari_krj() {
        if (akses::aksesLogin() == TRUE) {
            $kary   = $this->input->post('nama');
            $tipe   = $this->input->post('tipe');
            $rute   = $this->input->post('route');
            
            $jml =  $this->db
                         ->select('tbl_sdm_surat_krj.id')
                         ->join('tbl_m_karyawan', 'tbl_m_karyawan.id=tbl_sdm_surat_krj.id_karyawan')
                         ->like('tbl_m_karyawan.nama', $kary)
                         ->get('tbl_sdm_surat_krj')->num_rows();
            
            if($jml > 0){
                redirect(base_url('sdm/'.(!empty($rute) ? $rute : 'data_surat_krj_list.php?tipe='.$tipe).'&'.(!empty($kary) ? 'filter_nama='.$kary.'&' : '').'jml='.$jml));
            }else{
                redirect(base_url('sdm/'.(!empty($rute) ? $rute : 'data_surat_krj_list.php?tipe='.$tipe).'&msg=Pencarian tidak di temukan!!'));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_cari_tgs() {
        if (akses::aksesLogin() == TRUE) {
            $kary   = $this->input->post('nama');
            $tipe   = $this->input->post('tipe');
            $rute   = $this->input->post('route');
            
            $jml =  $this->db
                         ->select('tbl_sdm_surat_tgs.id')
                         ->join('tbl_m_karyawan', 'tbl_m_karyawan.id=tbl_sdm_surat_tgs.id_karyawan')
                         ->like('tbl_m_karyawan.nama', $kary)
                         ->get('tbl_sdm_surat_tgs')->num_rows();
            
            if($jml > 0){
                redirect(base_url('sdm/'.(!empty($rute) ? $rute : 'data_surat_tgs_list.php?tipe='.$tipe).'&'.(!empty($kary) ? 'filter_nama='.$kary.'&' : '').'jml='.$jml));
            }else{
                redirect(base_url('sdm/'.(!empty($rute) ? $rute : 'data_surat_tgs_list.php?tipe='.$tipe).'&msg=Pencarian tidak di temukan!!'));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_cari_gaji() {
        if (akses::aksesLogin() == TRUE) {
            $kary   = $this->input->post('nama');
            $tipe   = $this->input->post('tipe');
            $rute   = $this->input->post('route');
            
            $jml =  $this->db
                         ->select('tbl_sdm_gaji.id')
                         ->join('tbl_m_karyawan', 'tbl_m_karyawan.id=tbl_sdm_gaji.id_karyawan')
                         ->like('tbl_m_karyawan.nama', $kary)
                         ->get('tbl_sdm_gaji')->num_rows();
            
            if($jml > 0){
                redirect(base_url('sdm/'.(!empty($rute) ? $rute : 'data_gaji.php?tipe='.$tipe).'&'.(!empty($kary) ? 'filter_nama='.$kary.'&' : '').'jml='.$jml));
            }else{
                redirect(base_url('sdm/'.(!empty($rute) ? $rute : 'data_gaji.php?tipe='.$tipe).'&msg=Pencarian tidak di temukan!!'));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_cari_absen() {
        if (akses::aksesLogin() == TRUE) {
            $kary   = $this->input->post('nama');
            $tgl    = $this->input->post('tgl_masuk');
            $rute   = $this->input->post('route');
            
            $tg_masuk = $this->tanggalan->tgl_indo_sys($tgl);
            
            $jml =  $this->db
                         ->like('nama', $kary)
                         ->like('DATE(tgl_masuk)', $tg_masuk)
                         ->get('v_karyawan_absen')->num_rows();
            
            if($jml > 0){
                redirect(base_url('sdm/'.(!empty($rute) ? $rute : 'data_absen.php?').(!empty($tgl) ? 'filter_tgl='.$tg_masuk.'&' : '').(!empty($kary) ? 'filter_nama='.$kary.'&' : '').'jml='.$jml));
            }else{
                redirect(base_url('sdm/'.(!empty($rute) ? $rute : 'data_absen.php').'?msg=Pencarian tidak di temukan!!'));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    

    public function pdf_cuti() {
        if (akses::aksesLogin() == TRUE) {
            $setting = $this->db->get('tbl_pengaturan')->row();
            $id = $this->input->get('id');
            
            $sql_kary = $this->db
                ->select([
                    'tbl_sdm_cuti.id', 
                    'tbl_sdm_cuti.id_user', 
                    'tbl_sdm_cuti.id_manajemen', 
                    'tbl_sdm_cuti.tgl_simpan', 
                    'tbl_sdm_cuti.tgl_masuk', 
                    'tbl_sdm_cuti.tgl_keluar', 
                    'tbl_sdm_cuti.keterangan', 
                    'tbl_sdm_cuti.catatan', 
                    'tbl_sdm_cuti.status', 
                    'tbl_sdm_cuti.ttd', 
                    'tbl_m_karyawan.nama',
                    'tbl_m_karyawan.kode',
                    'tbl_m_karyawan.tgl_lahir', 
                    'tbl_m_karyawan.alamat', 
                    'tbl_m_karyawan.jns_klm', 
                    'tbl_m_kategori_cuti.tipe', 
                    'tbl_m_jabatan.jabatan', 
                    'tbl_m_departemen.dept as divisi'
                ])
                ->join('tbl_m_karyawan', 'tbl_m_karyawan.id=tbl_sdm_cuti.id_karyawan')
                ->join('tbl_m_karyawan_peg', 'tbl_m_karyawan_peg.id_karyawan=tbl_m_karyawan.id', 'left')
                ->join('tbl_m_jabatan', 'tbl_m_jabatan.id=tbl_m_karyawan_peg.id_jabatan', 'left')
                ->join('tbl_m_departemen', 'tbl_m_departemen.id=tbl_m_karyawan_peg.id_dept', 'left')
                ->join('tbl_m_kategori_cuti', 'tbl_m_kategori_cuti.id=tbl_sdm_cuti.id_kategori', 'left')
                ->where('tbl_sdm_cuti.id', general::dekrip($id))
                ->get('tbl_sdm_cuti')->row();

            if (!$sql_kary) {
                $this->session->set_flashdata('sdm_toast', 'toastr.error("Data cuti tidak ditemukan!");');
                redirect('sdm/data_cuti');
                return;
            }

            $gambar1 = FCPATH.'/assets/theme/admin-lte-3/dist/img/logo-esensia-2.png';
            $gambar2 = FCPATH.'/assets/theme/admin-lte-3/dist/img/logo-bw-bg2-1440px.png';
            $gambar3 = FCPATH.'/assets/theme/admin-lte-3/dist/img/logo-footer.png';
            $gambar4 = FCPATH.$sql_kary->ttd;

            $judul = "FORM PENGAJUAN ".strtoupper($sql_kary->tipe)." KARYAWAN";
            
            // Initialize fill variable
            $fill = false;
                        
            $this->load->library('MedPDF');
            $pdf = new MedPDF('P', 'cm', [21.5, 33]);
            $pdf->SetAutoPageBreak('auto', 6.5);
            $pdf->addPage();
            $pdf->AddFont('Cambria','','Cambria.php');
            $pdf->AddFont('Cambria','B','Cambriab.php');
            $pdf->AddFont('Cambria','Bi','Cambriab.php');
            $pdf->AddFont('Cambria','i','Cambriaz.php');
            
            // Gambar Watermark Tengah
            $pdf->Image($gambar2, 5, 4, 17, 19);

            $pdf->SetFont('Cambria', '', '12');
            $pdf->Cell(1.5, .5, 'Kepada Yth,', '0', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->SetFont('Cambria', 'B', '12');
            $pdf->Cell(1.5, .5, 'Pimpinan', '0', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->Cell(8, .5, $setting->judul, '0', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->SetFont('Cambria', '', '12');
            $pdf->Cell(1.5, .5, 'Di tempat', '0', 0, 'L', $fill);
            $pdf->Ln(1);
            
            # Perihal
            $pdf->SetFont('Cambria', '', '12');
            $pdf->Cell(1.5, .5, 'Perihal', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->SetFont('Cambria', 'B', '12');
            $pdf->Cell(8, .5, 'Permohonan '.$sql_kary->tipe, '0', 0, 'L', $fill);
            $pdf->Ln(1);
            
            # Isi Surat
            $pdf->SetFont('Cambria', '', '12');
            $pdf->Cell(1.5, .5, 'Dengan Hormat,', '0', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->Cell(19, .5, 'Saya yang bertanda tangan di bawah ini :', '0', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->Cell(1, .5, '', '0', 0, 'L', $fill);
            $pdf->Cell(4.5, .5, 'Nama', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->Cell(8, .5, $sql_kary->nama, '0', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->Cell(1, .5, '', '0', 0, 'L', $fill);
            $pdf->Cell(4.5, .5, 'Jabatan', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->Cell(8, .5, $sql_kary->jabatan, '0', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->Cell(1, .5, '', '0', 0, 'L', $fill);
            $pdf->Cell(4.5, .5, 'Divisi', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->Cell(8, .5, $sql_kary->divisi, '0', 0, 'L', $fill);
            $pdf->Ln(1);
            
            $pdf->Cell(19, .5, 'Dengan ini mengajukan permohonan '.$sql_kary->tipe.' sebagai berikut :', '0', 0, 'L', $fill);
            $pdf->Ln();
            
            $pdf->Cell(1, .5, '', '0', 0, 'L', $fill);
            $pdf->Cell(4.5, .5, 'Mulai Tanggal', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->Cell(8, .5, $this->tanggalan->tgl_indo($sql_kary->tgl_masuk), '0', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->Cell(1, .5, '', '0', 0, 'L', $fill);
            $pdf->Cell(4.5, .5, 'Sampai Dengan Tanggal', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->Cell(8, .5, $this->tanggalan->tgl_indo($sql_kary->tgl_keluar), '0', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->Cell(1, .5, '', '0', 0, 'L', $fill);
            $pdf->Cell(4.5, .5, 'Untuk Keperluan', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->Cell(8, .5, $sql_kary->keterangan, '0', 0, 'L', $fill);
            $pdf->Ln(1);
            
            $pdf->Cell(19, .5, 'Demikian permohonan '.$sql_kary->tipe.' kerja ini saya ajukan.', '0', 0, 'L', $fill);
            $pdf->Ln(2);                        
            
            if($sql_kary->status != 0){
                $pdf->SetFont('Cambria', 'B', '12');
                $pdf->Cell(2, .5, 'Status', '0', 0, 'L', $fill);
                $pdf->Cell(0.5, .5, ':', '0', 0, 'C', $fill);
                $pdf->SetFont('Cambria', '', '12');
                $pdf->Cell(15.5, .5, ($sql_kary->status == '1' ? 'Disetujui' : 'Ditolak'), '0', 0, 'L', $fill);
                $pdf->Ln();
                $pdf->SetFont('Cambria', 'B', '12');
                $pdf->Cell(2, .5, 'Catatan', '0', 0, 'L', $fill);
                $pdf->Cell(0.5, .5, ':', '0', 0, 'C', $fill);
                $pdf->SetFont('Cambria', '', '12');
                $pdf->Cell(15.5, .5, $sql_kary->catatan, '0', 0, 'L', $fill);
                $pdf->Ln(2);
            }

            // QR GENERATOR VALIDASI
            $kode_karyawan = strtolower($sql_kary->kode);
            $folder_path = FCPATH.'/file/karyawan/'.$kode_karyawan;
            
            // Check if directory exists, if not create it
            if (!file_exists($folder_path)) {
                mkdir($folder_path, 0777, true);
            }
            
            $qr_validasi = $folder_path.'/qr-validasi-'.$kode_karyawan.'.png';
            
            // Generate QR code using QRlib
            $qr_content = 'Saya yang bertandatangan dibawah ini:' . strtoupper($sql_kary->nama);
            QRcode::png($qr_content, $qr_validasi, 'H', 2, 2);
            
            $gambar5 = $qr_validasi; 
            
            // Gambar VALIDASI
            $getY = $pdf->GetY() + 1;
            
            if(!empty($sql_kary->ttd)){
                $pdf->Image($gambar4, 2, $getY, 2, 2);
            }
            
            if(file_exists($gambar5)) {
                $pdf->Image($gambar5, 12.5, $getY, 2, 2);
            }
            
            $pdf->SetFont('Cambria', '', '12');
            $pdf->Cell(11.5, .5, '', '', 0, 'L', $fill);
            $pdf->Cell(7.5, .5, 'Semarang, '.$this->tanggalan->tgl_indo3($sql_kary->tgl_simpan), '', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->SetFont('Cambria', 'B', '12');
            $pdf->Cell(4, .5, ($sql_kary->status != '0' ? ($sql_kary->status == '1' ? 'Menyetujui, ' : 'Menolak, ') : ''), '0', 0, 'C', $fill);
            $pdf->Cell(7.5, .5, '', '0', 0, 'C', $fill);
            $pdf->SetFont('Cambria', '', '12');
            $pdf->Cell(7.5, .5, 'Hormat Saya', '0', 0, 'L', $fill);
            $pdf->Ln(2.5);
            
            $pdf->SetFont('Cambria', '', '12');
            $pdf->Cell(4, .5, $this->ion_auth->user($sql_kary->id_manajemen)->row()->first_name, '', 0, 'C', $fill);
            $pdf->Cell(7.5, .5, '', '', 0, 'L', $fill);
            $pdf->Cell(8, .5, $sql_kary->nama, '0', 0, 'L', $fill);
            $pdf->Ln();
                    
            $pdf->SetFillColor(235, 232, 228);
            $pdf->SetTextColor(0);
            $pdf->SetFont('Cambria', '', '12');
            
            $type = (isset($_GET['type']) ? $_GET['type'] : 'I');
            
            ob_start();
            $pdf->Output($sql_kary->nama . '.pdf', $type);
            ob_end_flush();
        } else {
            $this->session->set_flashdata('sdm_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!");');
            redirect();
        }
    }
    

    public function pdf_cuti_bls() {
        if (akses::aksesLogin() == TRUE) {
            $setting = $this->db->get('tbl_pengaturan')->row();
            $id = $this->input->get('id');
            $id_kary = $this->input->get('id_karyawan');
            
            $sql_kary = $this->db
                ->select('tbl_sdm_cuti.id, tbl_sdm_cuti.id_user, tbl_sdm_cuti.tgl_simpan, tbl_sdm_cuti.tgl_masuk, tbl_sdm_cuti.tgl_keluar, tbl_sdm_cuti.no_surat, tbl_sdm_cuti.keterangan, tbl_sdm_cuti.catatan, tbl_sdm_cuti.status, tbl_m_karyawan.nama, tbl_m_karyawan.tgl_lahir, tbl_m_karyawan.alamat, tbl_m_karyawan.jns_klm, tbl_m_kategori_cuti.tipe, tbl_m_jabatan.jabatan, tbl_m_departemen.dept as divisi')
                ->join('tbl_m_karyawan', 'tbl_m_karyawan.id=tbl_sdm_cuti.id_karyawan')
                ->join('tbl_m_karyawan_peg', 'tbl_m_karyawan_peg.id_karyawan=tbl_m_karyawan.id', 'left')
                ->join('tbl_m_jabatan', 'tbl_m_jabatan.id=tbl_m_karyawan_peg.id_jabatan', 'left')
                ->join('tbl_m_departemen', 'tbl_m_departemen.id=tbl_m_karyawan_peg.id_dept', 'left')
                ->join('tbl_m_kategori_cuti', 'tbl_m_kategori_cuti.id=tbl_sdm_cuti.id_kategori', 'left')
                ->where('tbl_sdm_cuti.id', general::dekrip($id))
                ->get('tbl_sdm_cuti')->row();
            $sql_pimpinan = $this->db->where('id', '51')->get('tbl_m_karyawan')->row();

            $gambar1 = FCPATH.'/assets/theme/admin-lte-3/dist/img/logo-esensia-2.png';
            $gambar2 = FCPATH.'/assets/theme/admin-lte-3/dist/img/logo-bw-bg2-1440px.png';
            $gambar3 = FCPATH.'/assets/theme/admin-lte-3/dist/img/logo-footer.png';

            $judul = "FORM PENGAJUAN ".strtoupper($sql_kary->tipe)." KARYAWAN";
            
            // Initialize fill variable to fix undefined variable error
            $fill = false;
                        
            $this->load->library('MedPDF');
            $pdf = new MedPDF('P', 'cm', [21.5, 33]);
            $pdf->SetAutoPageBreak('auto', 6.5);
            $pdf->addPage();
            $pdf->AddFont('Cambria','','Cambria.php');
            $pdf->AddFont('Cambria','B','Cambriab.php');
            $pdf->AddFont('Cambria','Bi','Cambriab.php');
            $pdf->AddFont('Cambria','i','Cambriaz.php');
            
            // Gambar Watermark Tengah
            $pdf->Image($gambar2, 5, 4, 17, 19);
            
            # Perihal
            $pdf->SetFont('Cambria', '', '12');
            $pdf->Cell(1.5, .5, 'No', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->SetFont('Cambria', 'B', '12');
            $pdf->Cell(8, .5, $sql_kary->no_surat, '0', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->SetFont('Cambria', '', '12');
            $pdf->Cell(1.5, .5, 'Perihal', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->SetFont('Cambria', 'B', '12');
            $pdf->Cell(8, .5, 'Balasan surat permohonan '.$sql_kary->tipe.' tahunan', '0', 0, 'L', $fill);
            $pdf->Ln(1);
            
            # Isi Surat
            $pdf->SetFont('Cambria', '', '12');
            $pdf->Cell(1.5, .5, 'Dengan Hormat,', '0', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->MultiCell(19, .5, 'Saya yang bertanda tangan di bawah ini, pimpinan '.$setting->judul.' menerangkan bahwa :', '0', 'L');
            $pdf->Ln();
            $pdf->Cell(1, .5, '', '0', 0, 'L', $fill);
            $pdf->Cell(4.5, .5, 'Nama', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->Cell(8, .5, (!empty($sql_kary->nama_dpn) ? $sql_kary->nama_dpn.' ' : '').$sql_kary->nama.(!empty($sql_kary->nama_blk) ? ', '.$sql_kary->nama_blk.' ' : ''), '0', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->Cell(1, .5, '', '0', 0, 'L', $fill);
            $pdf->Cell(4.5, .5, 'Jabatan', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->Cell(8, .5, $sql_kary->jabatan, '0', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->Cell(1, .5, '', '0', 0, 'L', $fill);
            $pdf->Cell(4.5, .5, 'Divisi', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->Cell(8, .5, $sql_kary->divisi, '0', 0, 'L', $fill);
            $pdf->Ln(1);
            
            $pdf->Cell(19, .5, 'Sehubungan ini pengajuan surat permohonan '.$sql_kary->tipe.' sebagai berikut :', '0', 0, 'L', $fill);
            $pdf->Ln();
            
            $pdf->Cell(1, .5, '', '0', 0, 'L', $fill);
            $pdf->Cell(4.5, .5, 'Mulai Tanggal', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->Cell(8, .5, $this->tanggalan->tgl_indo($sql_kary->tgl_masuk), '0', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->Cell(1, .5, '', '0', 0, 'L', $fill);
            $pdf->Cell(4.5, .5, 'Sampai Dengan Tanggal', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->Cell(8, .5, $this->tanggalan->tgl_indo($sql_kary->tgl_keluar), '0', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->Cell(1, .5, '', '0', 0, 'L', $fill);
            $pdf->Cell(4.5, .5, 'Untuk Keperluan', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->Cell(8, .5, $sql_kary->keterangan, '0', 0, 'L', $fill);
            $pdf->Ln(1);
            
            $pdf->MultiCell(19, .5, 'Maka kami atas nama Pimpinan Klinik Esensia menyatakan '.($sql_kary->status == '1' ? '"MEMBERIKAN PERSETUJUAN"' : '"TIDAK MEMBERIKAN PERSETUJUAN"').', atas permohonan '.$sql_kary->tipe.' Tahunan.', '0', 'L');
            $pdf->Ln();                        
            $pdf->Cell(19, .5, 'Demikian untuk menjadi maklum dan guna seperlunya.', '0', 0, 'L', $fill);
            $pdf->Ln(2);                        

            // QR GENERATOR VALIDASI
            $folder_path = FCPATH.'/file/karyawan/'.strtolower($sql_kary->id);
            if (!file_exists($folder_path)) {
                mkdir($folder_path, 0777, true);
            }
            $qr_validasi = $folder_path.'/qr-validasi-'.strtolower($sql_kary->id).'.png';
            
            // Generate QR code using QRlib
            $qr_content = 'Saya yang bertandatangan dibawah ini:'.strtoupper($sql_kary->nama);
            QRcode::png($qr_content, $qr_validasi, 'H', 2, 2);
            
            $gambar5 = $qr_validasi; 
            
            // Gambar VALIDASI
            $getY = $pdf->GetY() + 1;
            $pdf->Image($gambar5, 12.5, $getY, 2, 2);
            
            $pdf->SetFont('Cambria', '', '12');
            $pdf->Cell(11.5, .5, '', '', 0, 'L', $fill);
            $pdf->Cell(7.5, .5, 'Semarang, '.$this->tanggalan->tgl_indo3($sql_kary->tgl_simpan), '', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->SetFont('Cambria', 'B', '12');
            $pdf->Cell(4, .5, '', '0', 0, 'C', $fill);
            $pdf->Cell(7.5, .5, '', '0', 0, 'C', $fill);
            $pdf->SetFont('Cambria', '', '12');
            $pdf->Cell(7.5, .5, 'Direktur Klinik Esensia', '0', 0, 'L', $fill);
            $pdf->Ln(2.5);
            
            $pdf->SetFont('Cambria', '', '12');
            $pdf->Cell(4, .5, '', '', 0, 'C', $fill);
            $pdf->Cell(7.5, .5, '', '', 0, 'L', $fill);
            $pdf->Cell(8, .5, (!empty($sql_pimpinan->nama_dpn) ? $sql_pimpinan->nama_dpn.' ' : '').$sql_pimpinan->nama.(!empty($sql_pimpinan->nama_blk) ? ', '.$sql_pimpinan->nama_blk.' ' : ''), '0', 0, 'L', $fill);
            $pdf->Ln();
                    
            $pdf->SetFillColor(235, 232, 228);
            $pdf->SetTextColor(0);
            $pdf->SetFont('Cambria', '', '12');
            
            $type = (isset($_GET['type']) ? $_GET['type'] : 'I');
            
            ob_start();
            $pdf->Output($sql_kary->nama.'.pdf', $type);
            ob_end_flush();
        } else {
            $this->session->set_flashdata('sdm_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!");');
            redirect();
        }
    }

    public function pdf_surat_krj() {
        if (akses::aksesLogin() == TRUE) {
            $setting = $this->db->get('tbl_pengaturan')->row();
            $id = $this->input->get('id');
            $id_kary = $this->input->get('id_karyawan');
                        
            $sql_kary = $this->db
                ->select('tbl_sdm_surat_krj.id, tbl_sdm_surat_krj.id_user, tbl_sdm_surat_krj.tgl_simpan, tbl_sdm_surat_krj.tgl_masuk, tbl_sdm_surat_krj.tgl_keluar, tbl_sdm_surat_krj.kode, tbl_sdm_surat_krj.keterangan, tbl_sdm_surat_krj.catatan, tbl_sdm_surat_krj.status, tbl_m_karyawan.nama, tbl_m_karyawan.tgl_lahir, tbl_m_karyawan.alamat, tbl_m_karyawan.jns_klm, tbl_m_jabatan.jabatan, tbl_m_departemen.dept as divisi')
                ->join('tbl_m_karyawan', 'tbl_m_karyawan.id=tbl_sdm_surat_krj.id_karyawan')
                ->join('tbl_m_karyawan_peg', 'tbl_m_karyawan_peg.id_karyawan=tbl_m_karyawan.id', 'left')
                ->join('tbl_m_jabatan', 'tbl_m_jabatan.id=tbl_m_karyawan_peg.id_jabatan', 'left')
                ->join('tbl_m_departemen', 'tbl_m_departemen.id=tbl_m_karyawan_peg.id_dept', 'left')
                ->where('tbl_sdm_surat_krj.id', general::dekrip($id))
                ->get('tbl_sdm_surat_krj')->row();
            $sql_pimpinan = $this->db->where('id', '51')->get('tbl_m_karyawan')->row();

            $gambar1 = FCPATH.'/assets/theme/admin-lte-3/dist/img/logo-esensia-2.png';
            $gambar2 = FCPATH.'/assets/theme/admin-lte-3/dist/img/logo-bw-bg2-1440px.png';
            $gambar3 = FCPATH.'/assets/theme/admin-lte-3/dist/img/logo-footer.png';

            $judul = "SURAT KETERANGAN KERJA".strtoupper($sql_kary->tipe)."";
                        
            $this->load->library('MedPDF');
            $pdf = new MedPDF('P', 'cm', [21.5, 33]);
            $pdf->SetAutoPageBreak('auto', 6.5);
            $pdf->addPage();
            $pdf->AddFont('Cambria','','Cambria.php');
            $pdf->AddFont('Cambria','B','Cambriab.php');
            $pdf->AddFont('Cambria','Bi','Cambriab.php');
            $pdf->AddFont('Cambria','i','Cambriaz.php');
            
            // Gambar Watermark Tengah
            $pdf->Image($gambar2, 5, 4, 17, 19);

            $pdf->SetFont('Cambria', 'B', '14');
            $pdf->Cell(19, .5, $judul, 0, 1, 'C');
            $pdf->Ln(0);
            $pdf->SetFont('Cambria', 'B', '10');
            $pdf->Cell(19, .5, 'Nomor : ' . $sql_kary->kode, 0, 1, 'C');
            $pdf->Ln();
            
            # Isi Surat
            $fill = false;
            $pdf->SetFont('Cambria', '', '12');
            $pdf->Cell(19, .5, 'Saya yang bertanda tangan di bawah ini :', '0', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->Cell(1, .5, '', '0', 0, 'L', $fill);
            $pdf->Cell(4.5, .5, 'Nama', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->Cell(8, .5, (!empty($sql_pimpinan->nama_dpn) ? $sql_pimpinan->nama_dpn.' ' : '').$sql_pimpinan->nama.(!empty($sql_pimpinan->nama_blk) ? ', '.$sql_pimpinan->nama_blk.' ' : ''), '0', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->Cell(1, .5, '', '0', 0, 'L', $fill);
            $pdf->Cell(4.5, .5, 'Alamat', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->Cell(8, .5, $setting->alamat, '0', 0, 'L', $fill);
            $pdf->Ln(1);
            $pdf->SetFont('Cambria', '', '12');
            $pdf->Cell(19, .5, 'Menerangkan bahwa :', '0', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->Cell(1, .5, '', '0', 0, 'L', $fill);
            $pdf->Cell(4.5, .5, 'Nama', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->Cell(8, .5, (!empty($sql_kary->nama_dpn) ? $sql_kary->nama_dpn.' ' : '').$sql_kary->nama.(!empty($sql_kary->nama_blk) ? ', '.$sql_kary->nama_blk.' ' : ''), '0', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->Cell(1, .5, '', '0', 0, 'L', $fill);
            $pdf->Cell(4.5, .5, 'Alamat', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->MultiCell(8, .5, $sql_kary->alamat, '0', 'L');
            $pdf->Ln();
            $pdf->Cell(1, .5, '', '0', 0, 'L', $fill);
            $pdf->Cell(4.5, .5, 'Jabatan', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->Cell(8, .5, $sql_kary->jabatan, '0', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->Cell(1, .5, '', '0', 0, 'L', $fill);
            $pdf->Cell(4.5, .5, 'Divisi', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->Cell(8, .5, $sql_kary->divisi, '0', 0, 'L', $fill);
            $pdf->Ln(1);
            
            $pdf->MultiCell(19, .5, 'Adalah benar merupakan karyawan '.$setting->judul.' mulai '.$this->tanggalan->tgl_indo3($sql_kary->tgl_masuk).' sampai dengan sekarang.', '0', 'L');
            $pdf->Ln();
            $pdf->MultiCell(19, .5, 'Demikian surat keterangan ini dibuat untuk '.$sql_kary->keterangan.'. Atas perhatiannya kami ucapkan terimakasih', '0', 'L');
            $pdf->Ln(2);                       

            // QR GENERATOR VALIDASI
            $folder_path = FCPATH.'/file/karyawan/'.strtolower($sql_kary->id);
            if (!file_exists($folder_path)) {
                mkdir($folder_path, 0777, true);
            }
            $qr_validasi = $folder_path.'/qr-validasi-'.strtolower($sql_kary->id).'.png';
            
            // Generate QR code using QRlib
            require_once APPPATH.'third_party/phpqrcode/qrlib.php';
            $qr_data = 'Saya yang bertandatangan dibawah ini:'.strtoupper($sql_kary->nama);
            QRcode::png($qr_data, $qr_validasi, QR_ECLEVEL_H, 2);
            
            $gambar5 = $qr_validasi; 
            
            // Gambar VALIDASI
            $getY = $pdf->GetY() + 1;
            $pdf->Image($gambar5, 12.5, $getY, 2, 2);
            
            $pdf->SetFont('Cambria', '', '12');
            $pdf->Cell(11.5, .5, '', '', 0, 'L', $fill);
            $pdf->Cell(7.5, .5, 'Semarang, '.$this->tanggalan->tgl_indo3($sql_kary->tgl_simpan), '', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->SetFont('Cambria', 'B', '12');
            $pdf->Cell(4, .5, '', '0', 0, 'C', $fill);
            $pdf->Cell(7.5, .5, '', '0', 0, 'C', $fill);
            $pdf->SetFont('Cambria', '', '12');
            $pdf->Cell(7.5, .5, 'Direktur Klinik Esensia', '0', 0, 'L', $fill);
            $pdf->Ln(2.5);
            
            $pdf->SetFont('Cambria', '', '12');
            $pdf->Cell(4, .5, '', '', 0, 'C', $fill);
            $pdf->Cell(7.5, .5, '', '', 0, 'L', $fill);
            $pdf->Cell(8, .5, (!empty($sql_pimpinan->nama_dpn) ? $sql_pimpinan->nama_dpn.' ' : '').$sql_pimpinan->nama.(!empty($sql_pimpinan->nama_blk) ? ', '.$sql_pimpinan->nama_blk.' ' : ''), '0', 0, 'L', $fill);
            $pdf->Ln();
                    
            $pdf->SetFillColor(235, 232, 228);
            $pdf->SetTextColor(0);
            $pdf->SetFont('Cambria', '', '12');
            
            $type = (isset($_GET['type']) ? $_GET['type'] : 'I');
            
            ob_start();
            $pdf->Output($sql_kary->nama.'.pdf', $type);
            ob_end_flush();
        } else {
            $this->session->set_flashdata('sdm_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!");');
            redirect();
        }
    }

    public function pdf_surat_tgs() {
        if (akses::aksesLogin() == TRUE) {
            $setting            = $this->db->get('tbl_pengaturan')->row();
            $id                 = $this->input->get('id');
            $id_kary            = $this->input->get('id_karyawan');
            $fill               = false; // Initialize $fill variable
                        
            $sql_kary           = $this->db
                                       ->select('tbl_sdm_surat_tgs.id, tbl_sdm_surat_tgs.id_user, tbl_sdm_surat_tgs.tgl_simpan, tbl_sdm_surat_tgs.tgl_masuk, tbl_sdm_surat_tgs.tgl_keluar, tbl_sdm_surat_tgs.kode, tbl_sdm_surat_tgs.judul, tbl_sdm_surat_tgs.keterangan, tbl_sdm_surat_tgs.catatan, tbl_sdm_surat_tgs.status, tbl_m_karyawan.nama_dpn, tbl_m_karyawan.nama, tbl_m_karyawan.nama_blk, tbl_m_karyawan.tgl_lahir, tbl_m_karyawan.alamat, tbl_m_karyawan.jns_klm, tbl_m_jabatan.jabatan, tbl_m_departemen.dept as divisi')
                                       ->join('tbl_m_karyawan', 'tbl_m_karyawan.id=tbl_sdm_surat_tgs.id_karyawan')
                                       ->join('tbl_m_karyawan_peg', 'tbl_m_karyawan_peg.id_karyawan=tbl_m_karyawan.id', 'left')
                                       ->join('tbl_m_jabatan', 'tbl_m_jabatan.id=tbl_m_karyawan_peg.id_jabatan', 'left')
                                       ->join('tbl_m_departemen', 'tbl_m_departemen.id=tbl_m_karyawan_peg.id_dept', 'left')
                                       ->where('tbl_sdm_surat_tgs.id', general::dekrip($id))
                                       ->get('tbl_sdm_surat_tgs')->row();
            $sql_kary_tmbh      = $this->db
                                       ->select('tbl_m_karyawan.nama_dpn, tbl_m_karyawan.nama, tbl_m_karyawan.nama_blk, tbl_m_karyawan.tgl_lahir, tbl_m_karyawan.alamat, tbl_m_karyawan.jns_klm, tbl_m_jabatan.jabatan, tbl_m_departemen.dept as divisi')
                                       ->join('tbl_m_karyawan', 'tbl_m_karyawan.id=tbl_sdm_surat_tgs_kary.id_karyawan')
                                       ->join('tbl_m_karyawan_peg', 'tbl_m_karyawan_peg.id_karyawan=tbl_m_karyawan.id', 'left')
                                       ->join('tbl_m_jabatan', 'tbl_m_jabatan.id=tbl_m_karyawan_peg.id_jabatan', 'left')
                                       ->join('tbl_m_departemen', 'tbl_m_departemen.id=tbl_m_karyawan_peg.id_dept', 'left')
                                       ->where('tbl_sdm_surat_tgs_kary.id_surat_tgs', $sql_kary->id)
                                       ->get('tbl_sdm_surat_tgs_kary')->result();
            $sql_pimpinan       = $this->db->where('id', '51')->get('tbl_m_karyawan')->row();
            
            $gambar1            = FCPATH.'/assets/theme/admin-lte-3/dist/img/logo-esensia-2.png';
            $gambar2            = FCPATH.'/assets/theme/admin-lte-3/dist/img/logo-bw-bg2-1440px.png';
            $gambar3            = FCPATH.'/assets/theme/admin-lte-3/dist/img/logo-footer.png';

            $judul  = "SURAT TUGAS".strtoupper($sql_kary->tipe)."";
                        
            $this->load->library('MedPDF');
            $pdf = new MedPDF('P', 'cm', array(21.5,33));
            $pdf->SetAutoPageBreak('auto', 6.5);
            $pdf->addPage();
            $pdf->AddFont('Cambria','','Cambria.php');
            $pdf->AddFont('Cambria','B','Cambriab.php');
            $pdf->AddFont('Cambria','Bi','Cambriab.php');
            $pdf->AddFont('Cambria','i','Cambriaz.php');
            
            // Gambar Watermark Tengah
            if (!empty($gambar2) && file_exists($gambar2)) {
                $pdf->Image($gambar2,5,4,17,19);
            }

            $pdf->SetFont('Cambria', 'B', '14');
            $pdf->Cell(19, .5, $judul, 0, 1, 'C');
            $pdf->Ln(0);
            $pdf->SetFont('Cambria', 'B', '10');
            $pdf->Cell(19, .5, 'Nomor : ' . $sql_kary->kode, 0, 1, 'C');
            $pdf->Ln();
            
            # Isi Surat
            $pdf->SetFont('Cambria', '', '12');
            $pdf->Cell(19, .5, 'Saya yang bertanda tangan di bawah ini :', '0', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->Cell(1, .5, '', '0', 0, 'L', $fill);
            $pdf->Cell(4.5, .5, 'Nama', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->Cell(8, .5, (!empty($sql_pimpinan->nama_dpn) ? $sql_pimpinan->nama_dpn.' ' : '').$sql_pimpinan->nama.(!empty($sql_pimpinan->nama_blk) ? ', '.$sql_pimpinan->nama_blk.' ' : ''), '0', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->Cell(1, .5, '', '0', 0, 'L', $fill);
            $pdf->Cell(4.5, .5, 'Alamat', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->Cell(8, .5, $setting->alamat, '0', 0, 'L', $fill);
            $pdf->Ln(1);
            $pdf->SetFont('Cambria', '', '12');
            $pdf->Cell(19, .5, 'Memberi tugas kepada :', '0', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->Cell(1, .5, '', '0', 0, 'L', $fill);
            $pdf->Cell(4.5, .5, 'Nama', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->Cell(8, .5, (!empty($sql_kary->nama_dpn) ? $sql_kary->nama_dpn.' ' : '').$sql_kary->nama.(!empty($sql_kary->nama_blk) ? ', '.$sql_kary->nama_blk.' ' : ''), '0', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->Cell(1, .5, '', '0', 0, 'L', $fill);
            $pdf->Cell(4.5, .5, 'Jabatan', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->Cell(8, .5, $sql_kary->jabatan, '0', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->Cell(1, .5, '', '0', 0, 'L', $fill);
            $pdf->Cell(4.5, .5, 'Divisi', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->Cell(8, .5, $sql_kary->divisi, '0', 0, 'L', $fill);
            $pdf->Ln(1);
            
            foreach ($sql_kary_tmbh as $kary){
                $pdf->Cell(1, .5, '', '0', 0, 'L', $fill);
                $pdf->Cell(4.5, .5, 'Nama', '0', 0, 'L', $fill);
                $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
                $pdf->Cell(8, .5, (!empty($kary->nama_dpn) ? $kary->nama_dpn.' ' : '').$kary->nama.(!empty($kary->nama_blk) ? ', '.$kary->nama_blk.' ' : ''), '0', 0, 'L', $fill);
                $pdf->Ln();
                $pdf->Cell(1, .5, '', '0', 0, 'L', $fill);
                $pdf->Cell(4.5, .5, 'Jabatan', '0', 0, 'L', $fill);
                $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
                $pdf->Cell(8, .5, $kary->jabatan, '0', 0, 'L', $fill);
                $pdf->Ln();
                $pdf->Cell(1, .5, '', '0', 0, 'L', $fill);
                $pdf->Cell(4.5, .5, 'Divisi', '0', 0, 'L', $fill);
                $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
                $pdf->Cell(8, .5, $kary->divisi, '0', 0, 'L', $fill);
                $pdf->Ln(1);
            }
            
            $pdf->Cell(6, .5, 'Untuk melaksanakan kegiatan', '0', 0, 'L', $fill);
            $pdf->SetFont('Cambria', 'B', '12');
            $pdf->Cell(13, .5, $sql_kary->judul, '0', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->SetFont('Cambria', '', '12');
            $pdf->MultiCell(19, .5, $sql_kary->keterangan, '0', 'L');
            $pdf->MultiCell(19, .5, 'Bahwa tugas tersebut dilaksanakan mulai tanggal '.$this->tanggalan->tgl_indo3($sql_kary->tgl_masuk).' sampai dengan '.$this->tanggalan->tgl_indo3($sql_kary->tgl_keluar).'.', '0', 'L');
            $pdf->MultiCell(19, .5, 'Demikian surat tugas ini dibuat. Atas perhatiannya kami ucapkan terimakasih', '0', 'L');
            $pdf->Ln(2);                       

            // QR GENERATOR VALIDASI
            $folder_path = FCPATH.'/file/karyawan/'.strtolower($sql_kary->kode);
            if (!file_exists($folder_path)) {
                mkdir($folder_path, 0777, true);
            }
            $qr_validasi = $folder_path.'/qr-validasi-'.strtolower($sql_kary->kode).'.png';
            
            // Generate QR code using QRlib
            require_once APPPATH.'third_party/phpqrcode/qrlib.php';
            $qr_data = 'Saya yang bertandatangan dibawah ini:'.strtoupper($sql_kary->nama);
            QRcode::png($qr_data, $qr_validasi, QR_ECLEVEL_H, 2);
            
            $gambar5 = $qr_validasi; 
            
            // Gambar VALIDASI
            $getY = $pdf->GetY() + 1;
            $pdf->Image($gambar5, 12.5, $getY, 2, 2);
            
            $pdf->SetFont('Cambria', '', '12');
            $pdf->Cell(10.5, .5, '', '', 0, 'L', $fill);
            $pdf->Cell(7.5, .5, 'Semarang, '.$this->tanggalan->tgl_indo3($sql_kary->tgl_simpan), '', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->SetFont('Cambria', 'B', '12');
            $pdf->Cell(4, .5, '', '0', 0, 'C', $fill);
            $pdf->Cell(6.5, .5, '', '0', 0, 'C', $fill);
            $pdf->SetFont('Cambria', '', '12');
            $pdf->Cell(6.5, .5, 'Direktur Klinik Esensia', '0', 0, 'L', $fill);
            $pdf->Ln(2.5);
            
            $pdf->SetFont('Cambria', '', '12');
            $pdf->Cell(4, .5, '', '', 0, 'C', $fill);
            $pdf->Cell(6.5, .5, '', '', 0, 'L', $fill);
            $pdf->Cell(8, .5, (!empty($sql_pimpinan->nama_dpn) ? $sql_pimpinan->nama_dpn.' ' : '').$sql_pimpinan->nama.(!empty($sql_pimpinan->nama_blk) ? ', '.$sql_pimpinan->nama_blk.' ' : ''), '0', 0, 'L', $fill);
            $pdf->Ln();
                    
            $pdf->SetFillColor(235, 232, 228);
            $pdf->SetTextColor(0);
            $pdf->SetFont('Cambria', '', '12');
            
            $type = (isset($_GET['type']) ? $_GET['type'] : 'I');
            
            ob_start();
            $pdf->Output('Surat_tugas_'.$sql_kary->nama.'.pdf', $type);
            ob_end_flush();
        } else {
            $this->session->set_flashdata('sdm_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!");');
            redirect();
        }
    }

    public function pdf_surat_pkl() {
        if (akses::aksesLogin() == TRUE) {
            $setting            = $this->db->get('tbl_pengaturan')->row();
            $id                 = $this->input->get('id');
            $id_kary            = $this->input->get('id_karyawan');
            $fill               = false; // Initialize $fill variable
                        
            $sql_kary           = $this->db
                                       ->select('tbl_m_karyawan_peg.id, tbl_m_karyawan_peg.id_user, tbl_m_karyawan_peg.tgl_simpan, tbl_m_karyawan_peg.tgl_masuk, tbl_m_karyawan_peg.tgl_keluar, tbl_m_karyawan_peg.kode, tbl_m_karyawan.nama, tbl_m_karyawan.tgl_lahir, tbl_m_karyawan.alamat, tbl_m_karyawan.jns_klm, tbl_m_jabatan.jabatan, tbl_m_departemen.dept as divisi')
                                       ->join('tbl_m_karyawan', 'tbl_m_karyawan.id=tbl_m_karyawan_peg.id_karyawan')
                                       ->join('tbl_m_jabatan', 'tbl_m_jabatan.id=tbl_m_karyawan_peg.id_jabatan', 'left')
                                       ->join('tbl_m_departemen', 'tbl_m_departemen.id=tbl_m_karyawan_peg.id_dept', 'left')
                                       ->where('tbl_m_karyawan_peg.id', general::dekrip($id))
                                       ->get('tbl_m_karyawan_peg')->row();
            $sql_pimpinan       = $this->db->where('id', '51')->get('tbl_m_karyawan')->row();

            $gambar1            = FCPATH.'/assets/theme/admin-lte-3/dist/img/logo-esensia-2.png';
            $gambar2            = FCPATH.'/assets/theme/admin-lte-3/dist/img/logo-bw-bg2-1440px.png';
            $gambar3            = FCPATH.'/assets/theme/admin-lte-3/dist/img/logo-footer.png';

            $judul  = "SURAT PENGALAMAN KERJA".strtoupper($sql_kary->tipe)."";
                        
            $this->load->library('MedPDF');
            $pdf = new MedPDF('P', 'cm', [21.5, 33]);
            $pdf->SetAutoPageBreak('auto', 6.5);
            $pdf->addPage();
            $pdf->AddFont('Cambria','','Cambria.php');
            $pdf->AddFont('Cambria','B','Cambriab.php');
            $pdf->AddFont('Cambria','Bi','Cambriab.php');
            $pdf->AddFont('Cambria','i','Cambriaz.php');
            
            // Gambar Watermark Tengah
            $pdf->Image($gambar2,5,4,17,19);

            $pdf->SetFont('Cambria', 'B', '14');
            $pdf->Cell(19, .5, $judul, 0, 1, 'C');
            $pdf->Ln(0);
            $pdf->SetFont('Cambria', 'B', '10');
            $pdf->Cell(19, .5, 'Nomor : ' . $sql_kary->kode, 0, 1, 'C');
            $pdf->Ln();
            
            # Isi Surat
            $pdf->SetFont('Cambria', '', '12');
            $pdf->Cell(19, .5, 'Saya yang bertanda tangan di bawah ini :', '0', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->Cell(1, .5, '', '0', 0, 'L', $fill);
            $pdf->Cell(4.5, .5, 'Nama', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->Cell(8, .5, (!empty($sql_pimpinan->nama_dpn) ? $sql_pimpinan->nama_dpn.' ' : '').$sql_pimpinan->nama.(!empty($sql_pimpinan->nama_blk) ? ', '.$sql_pimpinan->nama_blk.' ' : ''), '0', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->Cell(1, .5, '', '0', 0, 'L', $fill);
            $pdf->Cell(4.5, .5, 'Alamat', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->Cell(8, .5, $setting->alamat, '0', 0, 'L', $fill);
            $pdf->Ln(1);
            $pdf->SetFont('Cambria', '', '12');
            $pdf->Cell(19, .5, 'Menerangkan dengan sesungguhnya bahwa :', '0', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->Cell(1, .5, '', '0', 0, 'L', $fill);
            $pdf->Cell(4.5, .5, 'Nama', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->Cell(8, .5, (!empty($sql_kary->nama_dpn) ? $sql_kary->nama_dpn.' ' : '').$sql_kary->nama.(!empty($sql_kary->nama_blk) ? ', '.$sql_kary->nama_blk.' ' : ''), '0', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->Cell(1, .5, '', '0', 0, 'L', $fill);
            $pdf->Cell(4.5, .5, 'Alamat', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->MultiCell(8, .5, $sql_kary->alamat, '0', 'L');
            $pdf->Cell(1, .5, '', '0', 0, 'L', $fill);
            $pdf->Cell(4.5, .5, 'Jabatan', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->Cell(8, .5, $sql_kary->jabatan, '0', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->Cell(1, .5, '', '0', 0, 'L', $fill);
            $pdf->Cell(4.5, .5, 'Divisi', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->Cell(8, .5, $sql_kary->divisi, '0', 0, 'L', $fill);
            $pdf->Ln(1);
            
            $pdf->MultiCell(19, .5, 'Bahwa pegawai sebagaimana tersebut telah secara nyata bekerja pada '.$setting->judul.' mulai tanggal '.$this->tanggalan->tgl_indo3($sql_kary->tgl_masuk).' sampai dengan '.$this->tanggalan->tgl_indo3($sql_kary->tgl_keluar).'.', '0', 'L');
            $pdf->Ln();
            $pdf->MultiCell(19, .5, 'Demikian surat keterangan ini dibuat dengan sesungguhnya dan sebenar-benarnya untuk dapat digunakan sebagaimana mestinya', '0', 'L');
            $pdf->Ln(2);                       

            // QR GENERATOR VALIDASI
            $kode_karyawan = strtolower($sql_kary->kode);
            $folder_path = FCPATH.'/file/karyawan/'.$kode_karyawan;
            
            // Check if directory exists, if not create it
            if (!file_exists($folder_path)) {
                mkdir($folder_path, 0777, true);
            }
            
            $qr_validasi = $folder_path.'/qr-validasi-'.$kode_karyawan.'.png';
            
            // Generate QR code using QRlib
            require_once APPPATH.'third_party/phpqrcode/qrlib.php';
            
            // QR code content
            $qr_content = 'Saya yang bertandatangan dibawah ini:' . strtoupper($sql_kary->nama);
            
            // Generate QR code with QRlib
            QRcode::png($qr_content, $qr_validasi, 'H', 2, 2);
            
            $gambar5 = $qr_validasi; 
            
            // Gambar VALIDASI
            $getY = $pdf->GetY() + 1;
            $pdf->Image($gambar5,12.5,$getY,2,2);
            
            $pdf->SetFont('Cambria', '', '12');
            $pdf->Cell(11.5, .5, '', '', 0, 'L', $fill);
            $pdf->Cell(7.5, .5, 'Semarang, '.$this->tanggalan->tgl_indo3($sql_kary->tgl_simpan), '', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->SetFont('Cambria', 'B', '12');
            $pdf->Cell(4, .5, '', '0', 0, 'C', $fill);
            $pdf->Cell(7.5, .5, '', '0', 0, 'C', $fill);
            $pdf->SetFont('Cambria', '', '12');
            $pdf->Cell(7.5, .5, 'Direktur Klinik Esensia', '0', 0, 'L', $fill);
            $pdf->Ln(2.5);
            
            $pdf->SetFont('Cambria', '', '12');
            $pdf->Cell(4, .5, '', '', 0, 'C', $fill);
            $pdf->Cell(7.5, .5, '', '', 0, 'L', $fill);
            $pdf->Cell(8, .5, (!empty($sql_pimpinan->nama_dpn) ? $sql_pimpinan->nama_dpn.' ' : '').$sql_pimpinan->nama.(!empty($sql_pimpinan->nama_blk) ? ', '.$sql_pimpinan->nama_blk.' ' : ''), '0', 0, 'L', $fill);
            $pdf->Ln();
                    
            $pdf->SetFillColor(235, 232, 228);
            $pdf->SetTextColor(0);
            $pdf->SetFont('Cambria', '', '12');
            
            $type = (isset($_GET['type']) ? $_GET['type'] : 'I');
            
            ob_start();
            $pdf->Output('paklaring_'.strtolower($sql_kary->nama).'.pdf', $type);
            ob_end_flush();
        } else {
            $this->session->set_flashdata('sdm_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    

    public function json_karyawan() {
        if (akses::aksesLogin() == TRUE) {
            $term  = $this->input->get('term');
            $sql   = $this->db->select('id, id_user, kode, nik, nama, nama_dpn, nama_blk')->like('nama',$term)->get('tbl_m_karyawan')->result();
            
            if(!empty($sql)){
                foreach ($sql as $sql){
                    $produk[] = array(
                        'id'         => general::enkrip($sql->id),
                        'id_user'    => $sql->id_user,
                        'kode'       => $sql->kode,
                        'nama'       => (!empty($sql->nama_dpn) ? $sql->nama_dpn.' ' : '').$sql->nama.(!empty($sql->nama_blk) ? ', '.$sql->nama_blk : ''),
                    );
                }
                echo json_encode($produk);
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
}
