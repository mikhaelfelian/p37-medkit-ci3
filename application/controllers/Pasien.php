<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php

/**
 * Description of Pasien
 *
 * @author mike
 */

class Pasien extends CI_Controller {
    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->library('qrcode/ciqrcode');
    }
    
    public function index() {
//        if (akses::aksesLoginP() == TRUE) {
        $pengaturan = $this->db->get('tbl_pengaturan')->row();

        $data['pengaturan'] = $pengaturan;
        $data['recaptcha']  = $this->recaptcha->create_box();

        $this->load->view('admin-lte-2/1_atas', $data);
        $this->load->view('admin-lte-2/2_header', $data);
//        $this->load->view('admin-lte-2/3_navbar', $data);
        $this->load->view('admin-lte-2/content', $data);
        $this->load->view('admin-lte-2/5_footer', $data);
        $this->load->view('admin-lte-2/6_bawah', $data);
//        } else {
//            $errors = $this->ion_auth->messages();
//            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
//            redirect('pasien');
//        }
    }
    
    public function dashboard() {
        if (akses::aksesLoginP() == TRUE) {
            $data['sql_kary_jdwl']  = $this->db->select('tbl_m_karyawan.nama_dpn, tbl_m_karyawan.nama, tbl_m_karyawan.nama_blk, tbl_m_poli.lokasi, tbl_m_karyawan_jadwal.hari_1, tbl_m_karyawan_jadwal.hari_2, tbl_m_karyawan_jadwal.hari_3, tbl_m_karyawan_jadwal.hari_4, tbl_m_karyawan_jadwal.hari_5, tbl_m_karyawan_jadwal.hari_6, tbl_m_karyawan_jadwal.hari_7, tbl_m_karyawan_jadwal.waktu')
                                               ->join('tbl_m_karyawan', 'tbl_m_karyawan.id=tbl_m_karyawan_jadwal.id_karyawan')
                                               ->join('tbl_m_poli', 'tbl_m_poli.id=tbl_m_karyawan_jadwal.id_poli')
                                               ->get('tbl_m_karyawan_jadwal')->result();
            $data['pengaturan'] = $this->db->get('tbl_pengaturan')->row();

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/content', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
//            redirect('pasien');
            echo 'baaa';
        }
    }

    
    public function login() {
        $data['recaptcha'] = $this->recaptcha->create_box();
        
        if ($this->ion_auth->logged_in() == TRUE):
            redirect(base_url('dashboard2.php'));
        else:            
            $data['login'] = 'TRUE';

            $this->load->view('admin-lte-2/includes/user/login', $data);
        endif;
    }
    
    public function cek_login() {
        $user   = $this->input->post('user');
        $pass   = $this->input->post('pass');
        $inga   = $this->input->post('ingat');

//        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
        $this->form_validation->set_rules('user', 'Username', 'required');
        $this->form_validation->set_rules('pass', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $msg_error = array(
                'user' => form_error('user'),
                'pass' => form_error('pass')
            );

            $this->session->set_flashdata('form_error', $msg_error);
            redirect(base_url('pasien'));
        } else {            
            if($this->input->post('login') === 'login_aksi'){
                /*
                  Check if the reCAPTCHA was solved
                  You can pass arguments to the `is_valid` method,
                  but it should work fine without any.
                  Check the "Validating the reCAPTCHA" section for more details
                 */
                
                $is_valid = $this->recaptcha->is_valid();
                
                if($is_valid['success']){
                    $inget_ya = ($inga == 'ya' ? 'TRUE' : 'FALSE');
                    $login    = $this->ion_auth->login($user,$pass,$inget_ya);
                    $user     = $this->ion_auth->user()->row();
                    
                    # Cek passwot bener atau tidak
                    if($login == FALSE){
                        $this->session->set_flashdata('login', '<p class="login-box-msg text-bold text-danger">Username atau Kata sandi salah !!</p>');
                        redirect(base_url('pasien'));                        
                    }else{
                        # cek status user pasien atau manajemen
                        if($user->tipe == '2'){
                            redirect(base_url('pasien/dashboard.php'));
                        }else{
                            redirect(base_url('dashboard2.php'));
                        }
                    }
                }else{
                    $this->session->set_flashdata('login', '<p class="login-box-msg text-bold text-danger">Captcha tidak valid !!</p>');
                    redirect(base_url('pasien'));
                }
            }

//            if($login == FALSE){
//                $this->session->set_flashdata('login', '<p class="login-box-msg text-bold text-danger">Username atau Kata sandi salah !!</p>');
//                redirect('pasien');                
//            }else{
//                redirect(base_url('dashboard2.php'));
//            }
        }
    }
    
    public function cek_login2() {
        $user   = $this->input->post('user');
        $pass   = $this->input->post('pass');
        $inga   = $this->input->post('ingat');

//        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
        $this->form_validation->set_rules('user', 'Username', 'required');
        $this->form_validation->set_rules('pass', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $msg_error = array(
                'user' => form_error('user'),
                'pass' => form_error('pass')
            );

            $this->session->set_flashdata('form_error', $msg_error);
            redirect(base_url('pasien/login.php'));
        } else {            
            if($this->input->post('login') === 'login_aksi'){
                /*
                  Check if the reCAPTCHA was solved
                  You can pass arguments to the `is_valid` method,
                  but it should work fine without any.
                  Check the "Validating the reCAPTCHA" section for more details
                 */
                
                $is_valid = $this->recaptcha->is_valid();
                
                if($is_valid['success']){
                    $inget_ya = ($inga == 'ya' ? 'TRUE' : 'FALSE');
                    $login    = $this->ion_auth->login($user,$pass,$inget_ya);
                    $user     = $this->ion_auth->user()->row();
                    
                    # Cek passwot bener atau tidak
                    if($login == FALSE){
                        $this->session->set_flashdata('login', '<p class="login-box-msg text-bold text-danger">Username atau Kata sandi salah !!</p>');
                        redirect(base_url('pasien'));                        
                    }else{
                        # cek status user pasien atau manajemen
                        if($user->tipe == '2'){
                            redirect(base_url('pasien/dashboard.php'));
                        }else{
                            redirect(base_url('dashboard2.php'));
                        }
                    }
                }else{
                    $this->session->set_flashdata('login', '<p class="login-box-msg text-bold text-danger">Captcha tidak valid !!</p>');
                    redirect(base_url('pasien'));
                }
            }

//            if($login == FALSE){
//                $this->session->set_flashdata('login', '<p class="login-box-msg text-bold text-danger">Username atau Kata sandi salah !!</p>');
//                redirect('pasien');                
//            }else{
//                redirect(base_url('dashboard2.php'));
//            }
        }
    }
    
    public function pendaftaran() {
        if (akses::aksesLoginP() == TRUE) {
            $id_medc                = $this->input->get('id_medc');
            $id                     = $this->input->get('id');
            $id_resep               = $this->input->get('id_resep');
            $id_pasien              = $this->input->get('id_pasien');
            $id_item                = $this->input->get('id_item');
            $id_item_res            = $this->input->get('id_item_resep');
            $dft_id                 = $this->input->get('dft');
            $userid                 = $this->ion_auth->user()->row()->id;
        
            $data['pengaturan']     = $this->db->get('tbl_pengaturan')->row();
            $data['poli']           = $this->db->where('status_ant', '1')->get('tbl_m_poli')->result();
            $data['platform']       = $this->db->get('tbl_m_platform')->result();
            $data['gelar']          = $this->db->get('tbl_m_gelar')->result();
            $data['sql_doc']        = $this->db->where('id_user_group', '10')->get('tbl_m_karyawan')->result();
            $data['kerja']          = $this->db->get('tbl_m_jenis_kerja')->result();
            $data['sql_poli']       = $this->db->where('id', $data['sql_dft_id']->id_poli)->get('tbl_m_poli')->row();
            $data['sql_dft_id']     = $this->db->where('id', general::dekrip($dft_id))->get('tbl_pendaftaran')->row();            
            $data['sql_itm_pas']    = $this->db->select('id, nama, nama_pgl')->get('tbl_m_pasien')->result();
            $data['sql_pas']        = $this->db->where('id_user', $userid)->get('tbl_m_pasien')->row();
            $data['sql_penjamin']   = $this->db->where('status', '1')->get('tbl_m_penjamin')->result();
        
            if(!empty($userid)){
               $data['pasien']      = $this->db->where('id_user', $userid)->get('tbl_m_pasien')->row(); 
               $data['sql_dft']     = $this->db->where('status_akt <', '2')->where('id_pasien', $data['pasien']->id)->get('tbl_pendaftaran');
               $data['sql_poli2']   = $this->db->where('id', $data['sql_dft']->row()->id_poli)->get('tbl_m_poli')->row();
               $data['sql_dokter']  = $this->db->where('id_user', $data['sql_dft']->row()->id_dokter)->get('tbl_m_karyawan')->row();
            }
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/laporan/sidebar_lap';
            /* --- Sidebar Menu --- */
            
            /* Load view tampilan */
            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/pasien/daftar', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect('pasien');
        }
    }
    
    public function pendaftaran_baru() {
        $pengaturan = $this->db->get('tbl_pengaturan')->row();
        $userid     = $this->input->get('id');

        $data['pengaturan']     = $pengaturan;
        $data['recaptcha']      = $this->recaptcha->create_box();
        
        $data['poli']           = $this->db->where('status_ant', '1')->get('tbl_m_poli')->result();
        $data['platform']       = $this->db->get('tbl_m_platform')->result();
        $data['gelar']          = $this->db->get('tbl_m_gelar')->result();
        $data['sql_doc']        = $this->db->where('id_user_group', '10')->get('tbl_m_karyawan')->result();
        $data['kerja']          = $this->db->get('tbl_m_jenis_kerja')->result();
        $data['sql_poli']       = $this->db->where('id', $data['sql_dft_id']->id_poli)->get('tbl_m_poli')->row();
        $data['sql_dft_id']     = $this->db->where('id', general::dekrip($dft_id))->get('tbl_pendaftaran')->row();            
        $data['sql_itm_pas']    = $this->db->select('id, nama, nama_pgl')->get('tbl_m_pasien')->result();
        $data['sql_pas']        = $this->db->where('id_user', $userid)->get('tbl_m_pasien')->row();
        $data['sql_penjamin']   = $this->db->where('status', '1')->get('tbl_m_penjamin')->result();
        
        if(!empty($userid)) {
//            $data['pasien']     = $this->db->where('id_user', $userid)->get('tbl_m_pasien')->row();
            $data['sql_dft']    = $this->db->where('id', general::dekrip($userid))->get('tbl_pendaftaran');
            $data['sql_poli2']  = $this->db->where('id', $data['sql_dft']->row()->id_poli)->get('tbl_m_poli')->row();
            $data['sql_dokter'] = $this->db->where('id', $data['sql_dft']->row()->id_dokter)->get('tbl_m_karyawan')->row();
        }

        $this->load->view('admin-lte-2/1_atas', $data);
        $this->load->view('admin-lte-2/2_header', $data);
        $this->load->view('admin-lte-2/includes/pasien/daftar_baru', $data);
        $this->load->view('admin-lte-2/5_footer', $data);
        $this->load->view('admin-lte-2/6_bawah', $data);
    }
    
    
    
    
    public function profile() {
        if (akses::aksesLoginP() == TRUE) {
            $id               = $this->ion_auth->user()->row()->id;
            
            $data['gelar']    = $this->db->get('tbl_m_gelar')->result();
            $data['pasien']   = $this->db->where('id_user', $id)->get('tbl_m_pasien')->row();
//            $data['rm']       = $this->db->where('id_pasien', general::dekrip($id))->where('tipe !=', '3')->limit(10)->order_by('id', 'desc')->get('tbl_trans_medcheck')->result();
////            $data['rmi']      = $this->db->where('id_pasien', general::dekrip($id))->where('tipe', '3')->limit(10)->order_by('id', 'desc')->get('tbl_trans_medcheck')->result();
//            $data['rmi']      = $this->db->where('id_pasien', general::dekrip($id))->limit(10)->order_by('id', 'desc')->get('tbl_trans_medcheck_rm')->result();
//            $data['rmlab']    = $this->db->where('id_pasien', general::dekrip($id))->limit(10)->order_by('id', 'desc')->get('tbl_trans_medcheck_lab')->result();
//            $data['rmrad']    = $this->db->where('id_pasien', general::dekrip($id))->limit(10)->order_by('id', 'desc')->get('tbl_trans_medcheck_rad')->result();
//            $data['rmfile']   = $this->db->select('id,DATE(tgl_simpan) AS tgl_simpan')->where('id_pasien', general::dekrip($id))->limit(10)->group_by('DATE(tgl_simpan)')->order_by('id', 'desc')->get('tbl_trans_medcheck_file')->result();
//            $data['satuan']   = $this->db->get('tbl_m_satuan')->result();
//            $data['kategori'] = $this->db->get('tbl_m_kategori')->result();
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/master/sidebar_cust';
            /* --- Sidebar Menu --- */

            /* Load view tampilan */
            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/pasien/profile', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect('pasien');
        }
    }
    
    public function detail() {
        if (akses::aksesLoginP() == TRUE) {            
            $id_medc                = $this->input->get('id_medc');
            $id                     = $this->input->get('id');
            $id_resep               = $this->input->get('id_resep');
            $id_pasien              = $this->input->get('id_pasien');
            $id_item                = $this->input->get('id_item');
            $id_item_res            = $this->input->get('id_item_resep');
            $dft_id                 = $this->input->get('dft');
            $userid                 = $this->ion_auth->user()->row()->id;
            
            if(!empty($userid)){
               $data['pasien']      = $this->db->where('id_user', $userid)->get('tbl_m_pasien')->row(); 
            }
            
            /* Sidebar Menu */
            $data['sidebar']        = 'admin-lte-3/includes/laporan/sidebar_lap';
            /* --- Sidebar Menu --- */
            
            /* Load view tampilan */
            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/pasien/detail', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect(base_url('pasien/login'));
        }
    }
    
    public function riwayat_lab() {
        if (akses::aksesLoginP() == TRUE) {
            /* -- Grup hak akses -- */
            $grup        = $this->ion_auth->get_users_groups()->row();
            $id_user     = $this->ion_auth->user()->row()->id;
            $id_grup     = $this->ion_auth->get_users_groups()->row();            
            $pengaturan  = $this->db->get('tbl_pengaturan')->row();

            /* -- Blok Filter -- */
            $query   = $this->input->get('q');
            $hal     = $this->input->get('halaman');
            $nt      = $this->input->get('filter_nota');
            $fn      = explode('/', $nt);
            $tg      = $this->input->get('filter_tgl');
            $jml     = $this->input->get('jml');
            
            if(!empty($jml)){
                $jml_hal = $jml;
            }else{
                $jml_hal =  $this->db->select('*')
                                        ->where('id_pasien', $data['sql_pasien']->id)
//                                      ->like('tgl_simpan', (!empty($tg) ? $tg : ''))
                                        ->order_by('tgl_simpan','desc')
                                        ->get('tbl_trans_medcheck_lab')->num_rows();
            }
            /* -- End Blok Filter -- */

            /* -- Form Error -- */
            $data['hasError']                = $this->session->flashdata('form_error');

            /* -- Blok Pagination -- */
            $config['base_url']              = base_url('pasien/riwayat_lab.php?filter_tgl='.$tg.'&jml='.$jml);
            $config['total_rows']            = $jml_hal;

            $config['query_string_segment']  = 'halaman';
            $config['page_query_string']     = TRUE;
            $config['per_page']              = $pengaturan->jml_item;
            $config['num_links']             = 2;

            $config['first_tag_open']        = '<li>';
            $config['first_tag_close']       = '</li>';

            $config['prev_tag_open']         = '<li>';
            $config['prev_tag_close']        = '</li>';

            $config['num_tag_open']          = '<li>';
            $config['num_tag_close']         = '</li>';

            $config['next_tag_open']         = '<li>';
            $config['next_tag_close']        = '</li>';

            $config['last_tag_open']         = '<li>';
            $config['last_tag_close']        = '</li>';

            $config['cur_tag_open']          = '<li><a href="#"><b>';
            $config['cur_tag_close']         = '</b></a></li>';

            $config['first_link']            = '&laquo;';
            $config['prev_link']             = '&lsaquo;';
            $config['next_link']             = '&rsaquo;';
            $config['last_link']             = '&raquo;';
            /* -- End Blok Pagination -- */
            
            $data['sql_pasien']              = $this->db->where('id_user', $id_user)->get('tbl_m_pasien')->row();
            
            if(!empty($hal)){
                   $data['sql'] = $this->db->select('*')
                                        ->limit($config['per_page'], $hal)
                                        ->where('id_pasien', $data['sql_pasien']->id)
                                        ->like('tgl_masuk', (!empty($tg) ? $tg : ''))
                                        ->order_by('tgl_masuk','desc')
                                        ->get('tbl_trans_medcheck_lab')->result();
            }else{
                   $data['sql'] = $this->db->select('*')
                                        ->limit($config['per_page'])
                                        ->where('id_pasien', $data['sql_pasien']->id)
                                        ->like('tgl_masuk', (!empty($tg) ? $tg : ''))
                                        ->order_by('tgl_masuk','desc')
                                        ->get('tbl_trans_medcheck_lab')->result();
            }

            $this->pagination->initialize($config);

            /* Blok pagination */
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();
            /* --End Blok pagination-- */

            /* Load view tampilan */
            $this->load->view('admin-lte-2/1_atas',$data);
            $this->load->view('admin-lte-2/2_header',$data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/pasien/riwayat_lab',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect(base_url('pasien/login'));
        }
    }    
    
    public function riwayat_rad() {
        if (akses::aksesLoginP() == TRUE) {
            /* -- Grup hak akses -- */
            $grup        = $this->ion_auth->get_users_groups()->row();
            $id_user     = $this->ion_auth->user()->row()->id;
            $id_grup     = $this->ion_auth->get_users_groups()->row();            
            $pengaturan  = $this->db->get('tbl_pengaturan')->row();

            /* -- Blok Filter -- */
            $query   = $this->input->get('q');
            $hal     = $this->input->get('halaman');
            $nt      = $this->input->get('filter_nota');
            $fn      = explode('/', $nt);
            $tg      = $this->input->get('filter_tgl');
            $jml     = $this->input->get('jml');
            
            $data['sql_pasien'] = $this->db->where('id_user', $id_user)->get('tbl_m_pasien')->row();
            
            if(!empty($jml)){
                $jml_hal = $jml;
            }else{
                $jml_hal =  $this->db->select('*')
                                        ->where('id_pasien', $data['sql_pasien']->id)
//                                      ->like('tgl_simpan', (!empty($tg) ? $tg : ''))
                                        ->order_by('tgl_simpan','desc')
                                        ->get('tbl_trans_medcheck_rad')->num_rows();
            }
            /* -- End Blok Filter -- */

            /* -- Form Error -- */
            $data['hasError']                = $this->session->flashdata('form_error');

            /* -- Blok Pagination -- */
            $config['base_url']              = base_url('pasien/riwayat_rad.php?filter_tgl='.$tg.'&jml='.$jml);
            $config['total_rows']            = $jml_hal;

            $config['query_string_segment']  = 'halaman';
            $config['page_query_string']     = TRUE;
            $config['per_page']              = $pengaturan->jml_item;
            $config['num_links']             = 2;

            $config['first_tag_open']        = '<li>';
            $config['first_tag_close']       = '</li>';

            $config['prev_tag_open']         = '<li>';
            $config['prev_tag_close']        = '</li>';

            $config['num_tag_open']          = '<li>';
            $config['num_tag_close']         = '</li>';

            $config['next_tag_open']         = '<li>';
            $config['next_tag_close']        = '</li>';

            $config['last_tag_open']         = '<li>';
            $config['last_tag_close']        = '</li>';

            $config['cur_tag_open']          = '<li><a href="#"><b>';
            $config['cur_tag_close']         = '</b></a></li>';

            $config['first_link']            = '&laquo;';
            $config['prev_link']             = '&lsaquo;';
            $config['next_link']             = '&rsaquo;';
            $config['last_link']             = '&raquo;';
            /* -- End Blok Pagination -- */
            
            if(!empty($hal)){
                   $data['sql'] = $this->db->select('*')
                                        ->limit($config['per_page'], $hal)
                                        ->where('id_pasien', $data['sql_pasien']->id)
                                        ->like('tgl_masuk', (!empty($tg) ? $tg : ''))
                                        ->order_by('tgl_masuk','desc')
                                        ->get('tbl_trans_medcheck_rad')->result();
            }else{
                   $data['sql'] = $this->db->select('*')
                                        ->limit($config['per_page'])
                                        ->where('id_pasien', $data['sql_pasien']->id)
                                        ->like('tgl_masuk', (!empty($tg) ? $tg : ''))
                                        ->order_by('tgl_masuk','desc')
                                        ->get('tbl_trans_medcheck_rad')->result();
            }

            $this->pagination->initialize($config);

            /* Blok pagination */
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();
            /* --End Blok pagination-- */

            /* Load view tampilan */
            $this->load->view('admin-lte-2/1_atas',$data);
            $this->load->view('admin-lte-2/2_header',$data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/pasien/riwayat_rad',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect(base_url('pasien/login'));
        }
    }    
    
    public function riwayat_berkas() {
        if (akses::aksesLoginP() == TRUE) {
            /* -- Grup hak akses -- */
            $grup        = $this->ion_auth->get_users_groups()->row();
            $id_user     = $this->ion_auth->user()->row()->id;
            $id_grup     = $this->ion_auth->get_users_groups()->row();            
            $pengaturan  = $this->db->get('tbl_pengaturan')->row();

            /* -- Blok Filter -- */
            $query   = $this->input->get('q');
            $hal     = $this->input->get('halaman');
            $nt      = $this->input->get('filter_nota');
            $fn      = explode('/', $nt);
            $tg      = $this->input->get('filter_tgl');
            $jml     = $this->input->get('jml');
            
            $data['sql_pasien'] = $this->db->where('id_user', $id_user)->get('tbl_m_pasien')->row();
            
            if(!empty($jml)){
                $jml_hal = $jml;
            }else{
                $jml_hal =  $this->db->select('*')
                                        ->where('id_pasien', $data['sql_pasien']->id)
//                                      ->like('tgl_simpan', (!empty($tg) ? $tg : ''))
                                        ->order_by('tgl_simpan','desc')
                                        ->get('tbl_trans_medcheck_file')->num_rows();
            }
            /* -- End Blok Filter -- */

            /* -- Form Error -- */
            $data['hasError']                = $this->session->flashdata('form_error');

            /* -- Blok Pagination -- */
            $config['base_url']              = base_url('pasien/riwayat_berkas.php?filter_tgl='.$tg.'&jml='.$jml);
            $config['total_rows']            = $jml_hal;

            $config['query_string_segment']  = 'halaman';
            $config['page_query_string']     = TRUE;
            $config['per_page']              = $pengaturan->jml_item;
            $config['num_links']             = 2;

            $config['first_tag_open']        = '<li>';
            $config['first_tag_close']       = '</li>';

            $config['prev_tag_open']         = '<li>';
            $config['prev_tag_close']        = '</li>';

            $config['num_tag_open']          = '<li>';
            $config['num_tag_close']         = '</li>';

            $config['next_tag_open']         = '<li>';
            $config['next_tag_close']        = '</li>';

            $config['last_tag_open']         = '<li>';
            $config['last_tag_close']        = '</li>';

            $config['cur_tag_open']          = '<li><a href="#"><b>';
            $config['cur_tag_close']         = '</b></a></li>';

            $config['first_link']            = '&laquo;';
            $config['prev_link']             = '&lsaquo;';
            $config['next_link']             = '&rsaquo;';
            $config['last_link']             = '&raquo;';
            /* -- End Blok Pagination -- */
            
            if(!empty($hal)){
                   $data['sql'] = $this->db->select('*')
                                        ->limit($config['per_page'], $hal)
                                        ->where('id_pasien', $data['sql_pasien']->id)
                                        ->like('tgl_masuk', (!empty($tg) ? $tg : ''))
                                        ->order_by('tgl_masuk','desc')
                                        ->get('tbl_trans_medcheck_file')->result();
            }else{
                   $data['sql'] = $this->db->select('*')
                                        ->limit($config['per_page'])
                                        ->where('id_pasien', $data['sql_pasien']->id)
                                        ->like('tgl_masuk', (!empty($tg) ? $tg : ''))
                                        ->order_by('tgl_masuk','desc')
                                        ->get('tbl_trans_medcheck_file')->result();
            }

            $this->pagination->initialize($config);

            /* Blok pagination */
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();
            /* --End Blok pagination-- */

            /* Load view tampilan */
            $this->load->view('admin-lte-2/1_atas',$data);
            $this->load->view('admin-lte-2/2_header',$data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/pasien/riwayat_berkas',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect(base_url('pasien/login')); 
        }
    }


    public function pdf_riwayat_lab() {
        if (akses::aksesLoginP() == TRUE) {
            $setting            = $this->db->get('tbl_pengaturan')->row();
            $id_medcheck        = $this->input->get('id');
            $id_lab             = $this->input->get('id_lab');
            $status_ctk         = $this->input->get('status_ctk');
            $apppath            = realpath('../medkit/');
            
            $sql_medc           = $this->db->where('id', general::dekrip($id_medcheck))->get('tbl_trans_medcheck')->row();
            $sql_medc_srt       = $this->db->where('id', general::dekrip($id))->get('tbl_trans_medcheck_surat')->row(); 
            $sql_medc_lab       = $this->db->where('id', general::dekrip($id_lab))->get('tbl_trans_medcheck_lab')->row(); 
            $sql_medc_lab_det   = $this->db->where('id_medcheck', general::dekrip($id_medcheck))->where('id_lab', general::dekrip($id_lab))->where('status', '3')->where('status_hsl', '1')->group_by('id_lab_kat')->get('tbl_trans_medcheck_det')->result(); 
            $sql_poli           = $this->db->where('id', $sql_medc->id_poli)->get('tbl_m_poli')->row(); 
            $sql_pasien         = $this->db->where('id', $sql_medc->id_pasien)->get('tbl_m_pasien')->row(); 
            $sql_pekerjaan      = $this->db->where('id', $sql_pasien->id_pekerjaan)->get('tbl_m_jenis_kerja')->row();
            $sql_dokter         = $this->db->where('id_user', (!empty($sql_medc_lab->id_dokter) ? $sql_medc_lab->id_dokter : $sql_medc->id_dokter))->get('tbl_m_karyawan')->row();
            $sql_dokter2        = $this->db->where('id_user', '221')->get('tbl_m_karyawan')->row();
            $kode_pasien        = $sql_pasien->kode_dpn.$sql_pasien->kode;
            $gambar1            = $apppath.'/assets/theme/admin-lte-3/dist/img/logo-esensia-2.png'; // base_url('assets/theme/admin-lte-3/dist/img/logo-esensia-2.png');
            $gambar2            = $apppath.'/assets/theme/admin-lte-3/dist/img/logo-bw-bg2-1440px.png'; // base_url('assets/theme/admin-lte-3/dist/img/logo-bw-bg2-1440px.png');
            $gambar3            = $apppath.'/assets/theme/admin-lte-3/dist/img/logo-footer.png'; // base_url('assets/theme/admin-lte-3/dist/img/logo-footer.png');
            $sess_print         = $this->session->userdata('lab_print');
            
            $judul              = "HASIL PEMERIKSAAN LABORATORIUM";
            $judul2             = "Laboratory Result";

            $this->load->library('MedLabPDF');
            $pdf = new MedLabPDF('P', 'cm', array(21.5,33));
            $pdf->SetAutoPageBreak('auto', 7);
            $pdf->header = 0;
            $pdf->addPage('','',false);
            
            // Gambar Watermark Tengah
            $pdf->Image($gambar2,5,4,15,19);     
            
            # Blok Judul
            $pdf->SetFont('Arial', 'B', '13');
            $pdf->Cell(19, .5, $judul, 0, 1, 'C');
            $pdf->Ln(0);
            $pdf->SetFont('Arial', 'Bi', '13');
            $pdf->Cell(19, .5, $judul2, 'B', 1, 'C');
            $pdf->Ln(0);
            
            # Blok Dokter Penanggung Jawab
            $pdf->SetFont('Arial', 'B', '9');
            $pdf->Cell(9, .5, '', '0', 0, 'L', $fill);
            $pdf->Cell(4, .5, 'Dokter Penanggung Jawab', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->SetFont('Arial', 'B', '9');
            $pdf->Cell(5.5, .5, '1. dr. ANITA TRI HASTUTI, Sp.PK', '', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->Cell(9, .5, '', '0', 0, 'L', $fill);
            $pdf->Cell(4, .5, '', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, '', '0', 0, 'C', $fill);
            $pdf->Cell(5.5, .5, '2. dr. YENI JAMILAH, Sp.MK', '', 0, 'L', $fill);
            $pdf->Ln();
            
            # Blok ID PASIEN
            $pdf->SetFont('Arial', '', '9');
            $pdf->Cell(3, .5, 'No. Pemeriksaan', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->Cell(4.5, .5, $sql_medc_lab->no_lab, '0', 0, 'L', $fill);
            $pdf->Cell(2.5, .5, 'No. RM', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->Cell(8, .5, $sql_pasien->kode_dpn.$sql_pasien->kode, '0', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->Cell(3, .5, 'No. Sampel', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->Cell(4.5, .5, $sql_medc_lab->no_sample, '0', 0, 'L', $fill);
            $pdf->Cell(2.5, .5, 'Nama Name', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->Cell(8, .5, $sql_pasien->nama_pgl.' ('.$sql_pasien->jns_klm.')', '0', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->Cell(3, .5, 'Tgl Periksa', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->Cell(4.5, .5, $this->tanggalan->tgl_indo5($sql_medc_lab->tgl_masuk), '0', 0, 'L', $fill);
            $pdf->Cell(2.5, .5, 'NIK', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->Cell(8, .5, $sql_pasien->nik, '0', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->Cell(3, .5, 'Poli', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->Cell(4.5, .5, $sql_poli->lokasi, '0', 0, 'L', $fill);
            $pdf->Cell(2.5, .5, 'Tgl Lahir', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->Cell(8, .5, $this->tanggalan->tgl_indo2($sql_pasien->tgl_lahir).' / '.$this->tanggalan->usia_lkp($sql_pasien->tgl_lahir), '0', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->Cell(3, .5, 'Alamat', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->MultiCell(15.5, .5, (!empty($sql_pasien->alamat) ? $sql_pasien->alamat : (!empty($sql_pasien->alamat_dom) ? $sql_pasien->alamat_dom : '-')), '0', 'L');
            $pdf->Cell(3, .5, 'No. HP / Rmh', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->MultiCell(15.5, .5, $sql_pasien->no_hp.(!empty($penj->no_telp) ? ' / '.$penj->no_telp : ''), '0', 'L');
            $pdf->Cell(3, .5, 'Dokter Pengirim', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->MultiCell(15.5, .5, (!empty($sql_dokter->nama_dpn) ? $sql_dokter->nama_dpn.' ' : '').$sql_dokter->nama.(!empty($sql_dokter->nama_blk) ? ', '.$sql_dokter->nama_blk : ''), '0', 'L');
            $pdf->Ln();
            
            $fill = FALSE;
            $pdf->SetFont('Arial', 'B', '9');
            $pdf->Cell(7, .5, 'PEMERIKSAAN', 'T', 0, 'L', $fill);
            $pdf->Cell(4.5, .5, 'HASIL', 'T', 0, 'L', $fill);
            $pdf->Cell(5.5, .5, 'NILAI RUJUKAN', 'T', 0, 'L', $fill);
            $pdf->Cell(2, .5, 'SATUAN', 'T', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->SetFont('Arial', 'Bi', '9');
            $pdf->Cell(7, .5, 'EXAMINATION', 'B', 0, 'L', $fill);
            $pdf->Cell(4.5, .5, 'RESULT', 'B', 0, 'L', $fill);
            $pdf->Cell(5.5, .5, 'REFERENCE VALUE', 'B', 0, 'L', $fill);
            $pdf->Cell(2, .5, 'MEASURE', 'B', 0, 'L', $fill);
            $pdf->Ln();
            
            # Jika status cetak 1, maka akan di cetak semua
            # Pilihan ini untuk mengakomodir ePasien supaya bisa mencetak hasil
            # Jika status cetak tidak ada, maka untuk perawat bisa memilih item yg di cetak
            if ($status_ctk == '1') {
                foreach ($sql_medc_lab_det as $det) {
                    $sql_kat = $this->db->where('id', $det->id_lab_kat)->get('tbl_m_kategori')->row();
                    $sql_det = $this->db->where('status_hsl', '1')->where('id_medcheck', $det->id_medcheck)->where('id_lab', $det->id_lab)->where('id_lab_kat', $det->id_lab_kat)->get('tbl_trans_medcheck_det')->result();

                    if (!empty($det->id_lab_kat)) {
                        $pdf->SetFont('Arial', 'Bi', '9');
                        $pdf->Cell(19, .5, $sql_kat->keterangan, '', 0, 'L', $fill);
                        $pdf->Ln();
                    }

                    foreach ($sql_det as $medc) {
                        $sql_lab_rws = $this->db->where('id_medcheck', $medc->id_medcheck)->get('tbl_trans_medcheck_lab');
                        if ($sql_lab_rws->num_rows() > 1) {
                            $sql_lab = $this->db->where('id_medcheck', $medc->id_medcheck)->where('id_lab', general::dekrip($this->input->get('id_lab')))->where('id_item', $medc->id_item)->get('tbl_trans_medcheck_lab_hsl')->result();
                        } else {
                            $sql_lab = $this->db->where('id_medcheck', $medc->id_medcheck)->where('id_item', $medc->id_item)->get('tbl_trans_medcheck_lab_hsl')->result();
                        }

                        $pdf->SetFont('Arial', '', '8');

                        if (!empty($det->id_lab_kat)) {
                            $pdf->Cell(.25, .5, '', '', 0, 'L', $fill);
                        }

                        $pdf->Cell(18.5, .5, $medc->item . ($lab_det->status_hsl_lab == '1' ? '*' : ''), '', 0, 'L', $fill);
                        $pdf->Ln();

                        foreach ($sql_lab as $lab) {
                            $pdf->Cell(.25, .5, '', '', 0, 'L', $fill);
                            $pdf->Cell(7, .5, ' - ' . html_entity_decode($lab->item_name) . ($lab->status_hsl_lab == '1' ? '*' : ''), '', 0, 'L', $fill);
//                            $pdf->Cell(7, .5, '', 'B', 0, 'L', $fill);
                            $pdf->Cell(4.5, .5, html_entity_decode($lab->item_hasil, ENT_NOQUOTES, 'utf-8'), '', 0, 'L', $fill);
                            
                            $x = $pdf->GetX();
                            $y = $pdf->GetY();                           
                            $pdf->MultiCell(5.5, .5, html_entity_decode($lab->item_value, ENT_NOQUOTES, 'utf-8'), '', 'L');                            
                            $pdf->SetXY($x + 5.5, $y);                            
                            $pdf->Cell(2, .5, html_entity_decode($lab->item_satuan, ENT_NOQUOTES, 'utf-8'), '', 0, 'L', $fill);
//                            $pdf->Cell(5.5, .5, html_entity_decode($lab->item_value, ENT_NOQUOTES, 'utf-8'), '', 0, 'L', $fill);
//                            $pdf->Cell(2, .5, html_entity_decode($lab->item_satuan, ENT_NOQUOTES, 'utf-8'), '', 0, 'L', $fill);
                            $pdf->Ln();
                        }
                    }
                }
            } else {
                # Untuk Mencetak dengan pilihan
                
                $sql_medc_lab_det2   = $this->db->where('status', '3')->where('status_ctk', '1')->where('status_hsl', '1')->group_by('id_lab_kat')->where('id_medcheck', general::dekrip($id_medcheck))->where('id_lab', general::dekrip($id_lab))->get('tbl_trans_medcheck_det')->result();
                
                $i = 0;
                foreach ($sql_medc_lab_det2 as $det2) {
                    $sql_kat2 = $this->db->where('id', $det2->id_lab_kat)->get('tbl_m_kategori')->row();
                    $sql_det2 = $this->db->where('status_ctk', '1')->where('status_hsl', '1')->where('id_medcheck', $det2->id_medcheck)->where('id_lab', $det2->id_lab)->where('id_lab_kat', $det2->id_lab_kat)->get('tbl_trans_medcheck_det')->result();                        
                    
                    if (!empty($det2->id_lab_kat)) {
                        $pdf->SetFont('Arial', 'Bi', '9');
                        $pdf->Cell(19, .5, $sql_kat2->keterangan, '', 0, 'L', $fill);
                        $pdf->Ln();
                    }

                    foreach ($sql_det2 as $medc2) {
                        $sql_lab_rws2 = $this->db->where('id_medcheck', $medc2->id_medcheck)->get('tbl_trans_medcheck_lab');
                        if ($sql_lab_rws2->num_rows() > 1) {
                            $sql_lab2 = $this->db->where('id_medcheck', $medc2->id_medcheck)->where('id_lab', $medc2->id_lab)->where('id_item', $medc2->id_item)->get('tbl_trans_medcheck_lab_hsl')->result();
                        } else {
                            $sql_lab2 = $this->db->where('id_medcheck', $medc2->id_medcheck)->where('id_item', $medc2->id_item)->get('tbl_trans_medcheck_lab_hsl')->result();
                        }

                        $pdf->SetFont('Arial', '', '8');

                        if (!empty($det2->id_lab_kat)) {
//                            if ($sess_print[$i]['value'] == '1' AND $sess_print[$i]['id_kat'] == $det->id_lab_kat) {
                                $pdf->Cell(.25, .5, '', '', 0, 'L', $fill);
//                            }
                        }
                        
//                        if($sess_print[$i]['value'] == '1' AND $sess_print[$i]['id'] == $medc->id){
                            $pdf->Cell(18.5, .5, $medc2->item . ($lab_det2->status_hsl_lab == '1' ? '*' : ''), '', 0, 'L', $fill);
                            $pdf->Ln();
//                        }

                        foreach ($sql_lab2 as $lab2) {
//                            if ($sess_print[$i]['value'] == '1' AND $sess_print[$i]['id_lab_hsl'] == $lab->id) {
                                $pdf->Cell(.25, .5, '', '', 0, 'L', $fill);
                                $pdf->Cell(7, .5, ' - '.html_entity_decode($lab2->item_name) . ($lab2->status_hsl_lab == '1' ? '*' : ''), '', 0, 'L', $fill);
                                $pdf->Cell(4.5, .5, html_entity_decode($lab2->item_hasil, ENT_NOQUOTES, 'utf-8'), '', 0, 'L', $fill);
                                $pdf->Cell(5.5, .5, html_entity_decode($lab2->item_value, ENT_NOQUOTES, 'utf-8'), '', 0, 'L', $fill);
                                $pdf->Cell(2, .5, html_entity_decode($lab2->item_satuan, ENT_NOQUOTES, 'utf-8'), '', 0, 'L', $fill);
                                $pdf->Ln();
//                            }
                        }
                    }
                    
                    $i++;
                }                
            }

//            if($status_ctk == '1'){
//                $i = 0;
//                $fill = FALSE;
//                foreach ($sql_medc_lab_det as $key => $lab) {
//                        $sql_kat = $this->db->where('id', $lab->id_kat)->get('tbl_m_kategori');
//                        $sql_lab = $this->db->where('id', $lab->id)->where('status_hsl', '1')->get('tbl_trans_medcheck_det');
//                        $sql_lab_hsl = $this->db->where('id_medcheck', $sql_medc->id)->where('id_lab', general::dekrip($id_lab))->where('id_item', $sql_lab->row()->id_item)->get('tbl_trans_medcheck_lab_hsl')->result();
//
//                        $item = ($sql_kat->num_rows() == '0' ? $sql_lab->row()->item : $sql_kat->row()->keterangan);
//
//                        $pdf->Cell(18.5, .5, $sql_lab->row()->item . ($lab_det->status_hsl_lab == '1' ? '*' : ''), '', 0, 'L', $fill);
//                        $pdf->Ln();
//
//                        foreach ($sql_lab_hsl as $lab_item) {
//                            $sql_lab_nilai_rw = $this->db->where('id', $lab_item->id_item_ref_ip)->get('tbl_m_produk_ref_input')->row();
//
//                            // Detail Pemeriksaan dan hasilnya
//                            $pdf->SetFont('Arial', '', '8');
//                            $pdf->Cell(7, .5, ' - ' . html_entity_decode($lab_item->item_name) . ($lab_item->status_hsl_lab == '1' ? '*' : ''), '', 0, 'L', $fill);
//                            $pdf->Cell(4.5, .5, html_entity_decode($lab_item->item_hasil, ENT_NOQUOTES, 'utf-8'), '', 0, 'L', $fill);
////                            $pdf->Cell(5.5, .5, html_entity_decode($lab_item->item_value, ENT_NOQUOTES, 'utf-8'), '', 0, 'L', $fill);
////                            $pdf->MultiCell(5, .5, 'p'.$lab_item->item_value, '1', 'L');
////                            $pdf->Cell(2, .5, html_entity_decode($lab_item->item_satuan, ENT_NOQUOTES, 'utf-8'), '', 0, 'L', $fill);
//                            $pdf->Ln();
//                        }
//                    $i++;
//                }                
//            }else{
//                $i = 0;
//                $fill = FALSE;
//                foreach ($sql_medc_lab_det as $key => $lab) {
////                    if ($sess_print[$i]['value'] == '1') {
//                        $sql_kat        = $this->db->where('id', $sess_print[$i]['id_kat'])->get('tbl_m_kategori');
//                        $sql_lab        = $this->db->where('id', $sess_print[$i]['id'])->where('status_hsl', '1')->get('tbl_trans_medcheck_det');
//                        $sql_lab_hsl    = $this->db->where('id_medcheck', $sql_medc->id)->where('id_lab', general::dekrip($id_lab))->where('id_item', $sql_lab->row()->id_item)->get('tbl_trans_medcheck_lab_hsl')->result();
//
//                        $item = ($sql_kat->num_rows() == '0' ? $sql_lab->row()->item : $sql_kat->row()->keterangan);
//
//                        if(!empty($lab->id_lab_kat)){
//                            $pdf->SetFont('Arial', 'Bi', '10');
//                            $pdf->Cell(19, .5, $lab->id_lab_kat, '', 0, 'L', $fill);
//                            $pdf->Ln();
//                        }
////                        
////                        $pdf->SetFont('Arial', '', '8');
////                        $pdf->Cell(18.5, .5, $sql_lab->row()->item . ($lab_det->status_hsl_lab == '1' ? '*' : ''), '', 0, 'L', $fill);
////                        $pdf->Ln();
////
////                        foreach ($sql_lab_hsl as $lab_item) {
////                            $sql_lab_nilai_rw = $this->db->where('id', $lab_item->id_item_ref_ip)->get('tbl_m_produk_ref_input')->row();
////
////                            // Detail Pemeriksaan dan hasilnya
////                            $pdf->SetFont('Arial', '', '8');
////                            $pdf->Cell(7, .5, ' - ' . html_entity_decode($lab_item->item_name) . ($lab_item->status_hsl_lab == '1' ? '*' : ''), '', 0, 'L', $fill);
////                            $pdf->Cell(4.5, .5, html_entity_decode($lab_item->item_hasil, ENT_NOQUOTES, 'utf-8'), '', 0, 'L', $fill);
////                            $pdf->Cell(5.5, .5, html_entity_decode($lab_item->item_value, ENT_NOQUOTES, 'utf-8'), '1', 0, 'L', $fill);
//////                            $pdf->MultiCell(5.5, .5, $lab_item->item_value, '1', 'L');
////                            $pdf->Cell(2, .5, html_entity_decode($lab_item->item_satuan, ENT_NOQUOTES, 'utf-8'), '1', 0, 'L', $fill);
////                            $pdf->Ln();
////                        }
////                    }
//
//
//
//
//
//
////                echo '<pre>';
////                print_r($lab);
////                echo '</pre>';
////                
////                if($sess_print[$i]['value'] == 1){
////                    $sql_kat        = $this->db->where('id', $sess_print[$i]['id_kat'])->get('tbl_m_kategori');
////                    $sql_lab        = $this->db->where('id', $sess_print[$i]['id'])->where('status_hsl', '1')->get('tbl_trans_medcheck_det');
////                    
////                    if ($sql_kat->num_rows() > 0) {
////                        echo $sql_kat->row()->keterangan;
////                        echo br();
////                    }
////                }
////                if($sess_print[$i]['value'] == 1){
////                    $sql_kat        = $this->db->where('id', $sess_print[$i]['id_kat'])->get('tbl_m_kategori');
////                    $sql_lab        = $this->db->where('id', $sess_print[$i]['id'])->where('status_hsl', '1')->get('tbl_trans_medcheck_det');
////                    
////                    $item = ($sql_kat->num_rows() == '0' ? $sql_lab->row()->item : $sql_kat->row()->keterangan);
////                    
////                    $pdf->SetFont('Arial', '', '10');
////                    
//////                    if ($sql_kat->num_rows() > 0) {
//////                        // Kategori Bidang Muncul disini
//////                        $pdf->SetFont('Arial', 'Bi', '10');
//////                        $pdf->Cell(19, .5, $sql_kat->row()->keterangan, '', 0, 'L', $fill);
//////                        $pdf->Ln();
//////                    }else{
//////                        $sql_lab_hsl = $this->db->where('id_medcheck', $sql_medc->id)->where('id_lab', general::dekrip($id_lab))->where('id_item', $sql_lab->row()->id_item)->get('tbl_trans_medcheck_lab_hsl')->result();
//////                        
//////                        $pdf->Cell(18.5, .5, $item . ($lab_det->status_hsl_lab == '1' ? '*' : ''), '', 0, 'L', $fill);
//////                        $pdf->Ln();
//////                            
//////                        foreach ($sql_lab_hsl as $lab_item) {
//////                            $sql_lab_nilai_rw = $this->db->where('id', $lab_item->id_item_ref_ip)->get('tbl_m_produk_ref_input')->row();
//////
//////                            // Detail Pemeriksaan dan hasilnya
//////                            $pdf->SetFont('Arial', '', '8');
//////                            $pdf->Cell(7, .5, ' - ' . html_entity_decode($lab_item->item_name) . ($lab_item->status_hsl_lab == '1' ? '*' : ''), '', 0, 'L', $fill);
//////                            $pdf->Cell(4.5, .5, html_entity_decode($lab_item->item_hasil, ENT_NOQUOTES, 'utf-8'), '', 0, 'L', $fill);
//////                            $pdf->Cell(5.5, .5, html_entity_decode($lab_item->item_value, ENT_NOQUOTES, 'utf-8'), '', 0, 'L', $fill);
//////                            $pdf->Cell(2, .5, html_entity_decode($lab_item->item_satuan, ENT_NOQUOTES, 'utf-8'), '', 0, 'L', $fill);
//////                            $pdf->Ln();
//////                        }
//////                    }
////                    
////                    
////                    if($sql_kat->num_rows() > 0){
////                        $sql_lab_det     = $this->db->where('id_medcheck', $sql_medc->id)->where('id_lab', general::dekrip($id_lab))->where('id_lab_kat', $sess_print[$i]['id_kat'])->where('status_hsl', '1')->get('tbl_trans_medcheck_det');
////
////                        foreach ($sql_lab_det->result() as $lab_det) {
////                            $sql_lab_hsl = $this->db->where('id_medcheck', $sql_medc->id)->where('id_lab', general::dekrip($id_lab))->where('id_item', $lab_det->id_item)->get('tbl_trans_medcheck_lab_hsl')->result();
////                            
////                            $pdf->SetFont('Arial', '', '10');
////                            $pdf->Cell(0.5, .5, '', '', 0, 'L', $fill);
////                            $pdf->Cell(18.5, .5, $lab_det->item . ($lab_det->status_hsl_lab == '1' ? '*' : ''), '', 0, 'L', $fill);
////                            $pdf->Ln();
////                            
////                            foreach ($sql_lab_hsl as $lab_item){
////                                $sql_lab_nilai_rw = $this->db->where('id', $lab_item->id_item_ref_ip)->get('tbl_m_produk_ref_input')->row();
////
////                                // Detail Pemeriksaan dan hasilnya
////                                $pdf->SetFont('Arial', '', '8');
////                                $pdf->Cell(0.5, .5, '', '', 0, 'L', $fill);
////                                $pdf->Cell(6.5, .5, ' - ' . html_entity_decode($lab_item->item_name) . ($lab_item->status_hsl_lab == '1' ? '*' : ''), '', 0, 'L', $fill);
////                                $pdf->Cell(4.5, .5, html_entity_decode($lab_item->item_hasil, ENT_NOQUOTES, 'utf-8'), '', 0, 'L', $fill);
////                                $pdf->Cell(5.5, .5, html_entity_decode($lab_item->item_value, ENT_NOQUOTES, 'utf-8'), '', 0, 'L', $fill);
////                                $pdf->Cell(2, .5, html_entity_decode($lab_item->item_satuan, ENT_NOQUOTES, 'utf-8'), '', 0, 'L', $fill);
////                                $pdf->Ln();
////                            }
////                        }
////                    }
////                    
//////                    $ck = $i;
//////                    foreach ($sql_lab as $lab_det) {
//////                        echo nbs(5).'No : '.$sess_print[$i]['value'].br();
////////                        echo 'val : '.$sess_print[$ck]['value'].br();
////////                        echo 'Item : '.$lab_det->item.br();
////////                        
//////                        $ck++;
//////                    }
////                }
////                if ($sess_print[$i]['value'][$lab->id_lab_kat] == '1') {
////                    $sql_kat        = $this->db->where('id', $lab->id_lab_kat)->get('tbl_m_kategori')->row();
////                    $sql_lab        = $this->db->where('id_medcheck', $sql_medc->id)->where('id_lab', general::dekrip($id_lab))->where('id_lab_kat', $lab->id_lab_kat)->where('status_hsl', '1')->get('tbl_trans_medcheck_det')->result();
////                    
////                    if (!empty($lab->id_lab_kat)) {
////                        // Kategori Bidang Muncul disini
////                        $pdf->SetFont('Arial', 'Bi', '10');
////                        $pdf->Cell(19, .5, $sess_print[$i]['value'][$lab->id_lab_kat].$sql_kat->keterangan, '', 0, 'L', $fill);
////                        $pdf->Ln();
////                    }
////
////                    $ctk = 0;
////                    foreach ($sql_lab as $lab_det) {
//////                        if ($sess_print[$ctk]['id'] == $lab_det->id) {
////                            $sql_lab_det = $this->db->where('id_medcheck', $sql_medc->id)->where('id_lab', general::dekrip($id_lab))->where('id_item', $lab_det->id_item)->get('tbl_trans_medcheck_lab_hsl')->result();
////                            
////                            // Item pemeriksaan
////                            $pdf->SetFont('Arial', '', '10');
////                            if (!empty($lab->id_lab_kat)) {
////                                $pdf->Cell(0.5, .5, '', '', 0, 'L', $fill);
////                            }
////
////                            $pdf->Cell(18.5, .5, $sess_print[$ctk]['id'].$lab_det->item . ($lab_det->status_hsl_lab == '1' ? '*' : ''), '', 0, 'L', $fill);
////                            $pdf->Ln();
////
////                            foreach ($sql_lab_det as $lab_item) {
////                                $sql_lab_nilai_rw = $this->db->where('id', $lab_item->id_item_ref_ip)->get('tbl_m_produk_ref_input')->row();
////
////                                // Detail Pemeriksaan dan hasilnya
////                                $pdf->SetFont('Arial', '', '8');
////                                if (!empty($lab->id_lab_kat)) {
////                                    $pdf->Cell(0.5, .5, '', '', 0, 'L', $fill);
////                                }
////                                $pdf->Cell(6.5, .5, ' - ' . html_entity_decode($lab_item->item_name) . ($lab_item->status_hsl_lab == '1' ? '*' : ''), '', 0, 'L', $fill);
////                                $pdf->Cell(4.5, .5, html_entity_decode($lab_item->item_hasil, ENT_NOQUOTES, 'utf-8'), '', 0, 'L', $fill);
////                                $pdf->Cell(5.5, .5, html_entity_decode($lab_item->item_value, ENT_NOQUOTES, 'utf-8'), '', 0, 'L', $fill);
////                                $pdf->Cell(2, .5, html_entity_decode($lab_item->item_satuan, ENT_NOQUOTES, 'utf-8'), '', 0, 'L', $fill);
////                                $pdf->Ln();
////                            }
////                            $ctk++;
//////                        }
////                    }
////                    $i++;
////                }else{
////                    $sql_lab        = $this->db->where('id_medcheck', $sql_medc->id)->where('id_lab', general::dekrip($id_lab))->where('id_lab_kat', $lab->id_lab_kat)->where('status_hsl', '1')->get('tbl_trans_medcheck_det')->result();
////                    
////                    foreach ($sql_lab as $lab_det) {
////                            $pdf->Cell(18.5, .5, $sess_print[$ctk]['id'].$lab_det->item . ($lab_det->status_hsl_lab == '1' ? '*' : ''), '', 0, 'L', $fill);
////                            $pdf->Ln();
////                    }
////                }
//                    $i++;
//                }
//            }
            
            $pdf->SetFont('Arial', 'i', '8');
            $pdf->Ln();
            $pdf->Cell(19, .5, ($sql_medc_lab->status_duplo == '1' ? '* Sudah dilakukan duplo' : ''), 'T', 0, 'L', $fill);
            $pdf->Ln();
            
            // Keterangan Hasil Lab selain template covid
            if ($sql_medc_lab->status_cvd == '0' AND !empty($sql_medc_lab->ket)) {
                $pdf->SetFont('Arial', 'B', '10');
                $pdf->Cell(19, .5, 'Catatan / Note', '', 0, 'L', $fill);
                $pdf->Ln();
                $pdf->SetFont('Arial', '', '9');
                $pdf->MultiCell(6, .5, $sql_medc_lab->ket, '0', 'L');
            }elseif($sql_medc_lab->status_cvd != '0'){
                $pdf->SetFont('Arial', 'B', '10');
                $pdf->Cell(19, .5, 'Catatan / Note', '', 0, 'L', $fill);
                $pdf->Ln();
                $pdf->SetFont('Arial', '', '8');
                $pdf->Cell(.5, .5, '', '', 0, 'C', $fill);              
                $pdf->Cell(.5, .5, '1.', '', 0, 'C', $fill);             
                $pdf->Cell(18, .5, 'Hasil positiv berlaku untuk hasil PCR SARS CoV-2 atau Antigen dari Laboratorium Klinik Utama Rawat Inap', '', 0, 'L', $fill);
                $pdf->Ln();
                $pdf->Cell(.5, .5, '', '', 0, 'C', $fill);              
                $pdf->Cell(.5, .5, '', '', 0, 'C', $fill);             
                $pdf->Cell(18, .5, 'Esensia. Nilai tersebut tidak dapat dibandingkan dengan CT hasil PCR SARS CoV-2 atau Antigen dari', '', 0, 'L', $fill);
                $pdf->Ln();
                $pdf->Cell(.5, .5, '', '', 0, 'C', $fill);              
                $pdf->Cell(.5, .5, '', '', 0, 'C', $fill);             
                $pdf->Cell(18, .5, 'laboratorium lain.', '', 0, 'L', $fill);
                $pdf->Ln();
                $pdf->SetFont('Arial', 'i', '8');
                $pdf->Cell(.5, .5, '', '', 0, 'C', $fill);              
                $pdf->Cell(.5, .5, '', '', 0, 'C', $fill);             
                $pdf->Cell(18, .5, 'Positive results apply to PCR results for SARS CoV-2 or Antigens from the Esensia Inpatient Main', '', 0, 'L', $fill);
                $pdf->Ln();
                $pdf->Cell(.5, .5, '', '', 0, 'C', $fill);              
                $pdf->Cell(.5, .5, '', '', 0, 'C', $fill);             
                $pdf->Cell(18, .5, 'Clinical Laboratory. This value cannot be compared with CT PCR results from SARS CoV-2 or Antigens from', '', 0, 'L', $fill);
                $pdf->Ln();
                $pdf->Cell(.5, .5, '', '', 0, 'C', $fill);              
                $pdf->Cell(.5, .5, '', '', 0, 'C', $fill);             
                $pdf->Cell(18, .5, 'other laboratories.', '', 0, 'L', $fill);
                $pdf->Ln();
                $pdf->SetFont('Arial', '', '8');
                $pdf->Cell(.5, .5, '', '', 0, 'C', $fill);              
                $pdf->Cell(.5, .5, '2.', '', 0, 'C', $fill);             
                $pdf->Cell(18, .5, 'Kondisi tersebut hanya menggambarkan kondisi saat pengambilan sampel.', '', 0, 'L', $fill);
                $pdf->Ln();
                $pdf->SetFont('Arial', 'i', '8');
                $pdf->Cell(.5, .5, '', '', 0, 'C', $fill);              
                $pdf->Cell(.5, .5, '', '', 0, 'C', $fill);             
                $pdf->Cell(18, .5, 'These conditions only describe the conditions at the time of sampling.', '', 0, 'L', $fill);
                $pdf->Ln();
                $pdf->SetFont('Arial', '', '8');
                $pdf->Cell(.5, .5, '', '', 0, 'C', $fill);              
                $pdf->Cell(.5, .5, '3.', '', 0, 'C', $fill);             
                $pdf->Cell(18, .5, 'Bila hasil positif dan terdapat gejala klinis, segera konsultasikan ke faskes.', '', 0, 'L', $fill);
                $pdf->Ln();
                $pdf->SetFont('Arial', 'i', '8');
                $pdf->Cell(.5, .5, '', '', 0, 'C', $fill);              
                $pdf->Cell(.5, .5, '', '', 0, 'C', $fill);             
                $pdf->Cell(18, .5, 'These conditions only describe the conditions at the time of sampling.', '', 0, 'L', $fill);
                $pdf->Ln();
                $pdf->SetFont('Arial', '', '8');
                $pdf->Cell(.5, .5, '', '', 0, 'C', $fill);              
                $pdf->Cell(.5, .5, '4.', '', 0, 'C', $fill);             
                $pdf->Cell(18, .5, 'Bila hasil negatif tidak selalu berarti pasien tidak terinfeksi SARS CoV-2, dan perlu dilakukan', '', 0, 'L', $fill);
                $pdf->Ln();
                $pdf->Cell(.5, .5, '', '', 0, 'C', $fill);              
                $pdf->Cell(.5, .5, '', '', 0, 'C', $fill);             
                $pdf->Cell(18, .5, 'pemeriksaan secara berkala.', '', 0, 'L', $fill);
                $pdf->Ln();
                $pdf->SetFont('Arial', 'i', '8');
                $pdf->Cell(.5, .5, '', '', 0, 'C', $fill);              
                $pdf->Cell(.5, .5, '', '', 0, 'C', $fill);             
                $pdf->Cell(18, .5, 'A negative results  does not necessarily mean that the patient is not infected with SARS-CoV-2, and', '', 0, 'L', $fill);
                $pdf->Ln();
                $pdf->Cell(.5, .5, '', '', 0, 'C', $fill);
                $pdf->Cell(.5, .5, '', '', 0, 'C', $fill);
                $pdf->Cell(18, .5, 'periodic examinations need to be carried out.', '', 0, 'L', $fill);
                $pdf->Ln();
            }
           
            // QR GENERATOR VALIDASI
            $qr_validasi        = $apppath.'/file/pasien/'.strtolower($kode_pasien).'/qr-validasi-'.strtolower($kode_pasien).'.png';
            $params['data']     = 'Telah diverifikasi dan ditandatangani secara elektronik oleh manajemen klinik esensia. Pasien a/n. ';
            $params['data']    .= strtoupper($sql_pasien->nama_pgl).' ('.strtoupper($kode_pasien).')';
            $params['level']    = 'H';
            $params['size']     = 2;
            $params['savename'] = $qr_validasi;
            $this->ciqrcode->generate($params);
            
//            $gambar4            = base_url('file/qr/validasi-'.$sql_pasien->id.'.png');         
            $gambar4            = $qr_validasi;         
                        
            // QR GENERATOR DOKTER
            $qr_dokter          = $apppath.'/file/pasien/'.strtolower($kode_pasien).'/qr-dokter-'.strtolower($sql_dokter2->id).'.png';
            $params['data']     = 'Telah diverifikasi dan ditandatangani secara elektronik oleh dokter penanggung jawab ['.(!empty($sql_dokter2->nama_dpn) ? $sql_dokter2->nama_dpn.' ' : '').$sql_dokter2->nama.(!empty($sql_dokter2->nama_blk) ? ', '.$sql_dokter2->nama_blk : '').']';
            $params['level']    = 'H';
            $params['size']     = 2;
            $params['savename'] = $qr_dokter;
            $this->ciqrcode->generate($params);
            
            $gambar5            = $qr_dokter;
//            $gambar5            = base_url('file/qr/dokter-'.strtolower($sql_dokter2->id).'.png');
            
            // Gambar VALIDASI
            $getY = $pdf->GetY() + 1;
            $pdf->Image($gambar4,2,$getY,2,2);
            $pdf->Image($gambar5,12,$getY,2,2);
            
            
            $pdf->SetFont('Arial', '', '10');
            $pdf->Cell(10.5, .5, '', '', 0, 'L', $fill);
            $pdf->Cell(7.5, .5, 'Semarang, '.$this->tanggalan->tgl_indo3($sql_medc_lab->tgl_masuk), '', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->SetFont('Arial', 'B', '10');
            $pdf->Cell(4, .5, 'Validasi', '0', 0, 'C', $fill);
            $pdf->Cell(6.5, .5, '', '0', 0, 'C', $fill);
            $pdf->SetFont('Arial', '', '10');
            $pdf->Cell(7.5, .5, (!empty($ket) ? $ket : 'Dokter Pemeriksa'), '0', 0, 'L', $fill);
            $pdf->Ln(2.5);
            
            $pdf->SetFont('Arial', '', '10');
            $pdf->Cell(10.5, .5, '', '', 0, 'L', $fill);
            $pdf->Cell(7.5, .5, (!empty($sql_dokter2->nama_dpn) ? $sql_dokter2->nama_dpn.' ' : '').$sql_dokter2->nama.(!empty($sql_dokter2->nama_blk) ? ', '.$sql_dokter2->nama_blk : ''), '', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->Cell(10.5, .5, '', '', 0, 'L', $fill);
            $pdf->Cell(7.5, .5, $sql_dokter2->nik, '', 0, 'L', $fill);
            $pdf->Ln();
            
            $type = (isset($_GET['type']) ? $_GET['type'] : 'I');
            $pdf->Output($sql_pasien->nama_pgl. '.pdf', $type);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function pdf_riwayat_rad() {
        if (akses::aksesLoginP() == TRUE) {
            $setting            = $this->db->get('tbl_pengaturan')->row();
//            $id                 = $this->input->get('id');
            $id_medcheck        = $this->input->get('id');
            $id_rad             = $this->input->get('id_rad');
            $apppath            = realpath('../medkit/');
            
            $sql_medc           = $this->db->where('id', general::dekrip($id_medcheck))->get('tbl_trans_medcheck')->row();
            $sql_medc_item      = $this->db->where('id_medcheck', general::dekrip($id_medcheck))
                                           ->where('id_rad', general::dekrip($id_rad))
//                                           ->where('status', '5')
                                           ->where('status_hsl', '1')
                                           ->get('tbl_trans_medcheck_det')->result(); 
            $sql_medc_rad       = $this->db->where('id', general::dekrip($id_rad))->get('tbl_trans_medcheck_rad')->row(); 
            $sql_pasien         = $this->db->where('id', $sql_medc->id_pasien)->get('tbl_m_pasien')->row(); 
            $sql_pekerjaan      = $this->db->where('id', $sql_pasien->id_pekerjaan)->get('tbl_m_jenis_kerja')->row();
            $sql_dokter         = $this->db->where('id_user', $sql_medc->id_dokter)->get('tbl_m_karyawan')->row();
            $sql_dokter_rad     = $this->db->where('id_user', $sql_medc_rad->id_dokter)->get('tbl_m_karyawan')->row();
            $sql_dokter_krm     = $this->db->where('id_user', $sql_medc_rad->id_dokter_kirim)->get('tbl_m_karyawan')->row();
            $kode_pasien        = $sql_pasien->kode_dpn.$sql_pasien->kode;
            $gambar1            = $apppath.'/assets/theme/admin-lte-3/dist/img/logo-esensia-2.png';
            $gambar2            = $apppath.'/assets/theme/admin-lte-3/dist/img/logo-bw-bg2-1440px.png';
            $gambar3            = $apppath.'/assets/theme/admin-lte-3/dist/img/logo-footer.png';

            $judul  = "HASIL PEMERIKSAAN RADIOLOGI";
            $judul2 = "Radiology Result";
            
            $this->load->library('MedRadPDF');
            $pdf = new MedRadPDF('P', 'cm', array(21.5,33));
            $pdf->SetAutoPageBreak('auto', 6.5);
            $pdf->addPage();
            
            // Gambar Watermark Tengah
            $pdf->Image($gambar2,5,4,17,19);
            
            // Blok Judul
            $pdf->SetFont('Arial', 'B', '14');
            $pdf->Cell(19, .5, $judul, 0, 1, 'C');
            $pdf->Ln(0);
            $pdf->SetFont('Arial', 'Bi', '14');
            $pdf->Cell(19, .5, $judul2, 0, 1, 'C');
            $pdf->Ln();
            
            // Blok ID PASIEN
            $pdf->SetFont('Arial', '', '9');
            $pdf->Cell(5.5, .5, 'Nama / Name', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->Cell(8, .5, strtoupper($sql_pasien->nama_pgl).' ('.strtoupper($kode_pasien).')', '0', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->Cell(5.5, .5, 'Tgl Lahir / Date of Birth', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->Cell(8, .5, $this->tanggalan->tgl_indo($sql_pasien->tgl_lahir).' - '.$this->tanggalan->usia($sql_pasien->tgl_lahir).' ('.general::jns_klm($sql_pasien->jns_klm).')', '0', 0, 'L', $fill);
            $pdf->Ln();
//            $pdf->Cell(5.5, .5, 'Jenis Kelamin / Gender', '0', 0, 'L', $fill);
//            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
//            $pdf->Cell(8, .5, $this->tanggalan->usia($sql_pasien->tgl_lahir).' ('.general::jns_klm($sql_pasien->jns_klm).')', '0', 0, 'L', $fill);
//            $pdf->Ln();
            $pdf->Cell(5.5, .5, 'Alamat / Address', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->Cell(8, .5, (!empty($sql_pasien->alamat) ? $sql_pasien->alamat : (!empty($sql_pasien->alamat_dom) ? $sql_pasien->alamat_dom : '-')), '0', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->Cell(5.5, .5, 'Tgl Periksa / Check Date', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->Cell(8, .5, $this->tanggalan->tgl_indo5($sql_medc->tgl_masuk), '0', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->Cell(5.5, .5, 'Tgl Selesai / End Date', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->Cell(8, .5, $this->tanggalan->tgl_indo5(date('Y-m-d H:i')), '0', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->Cell(5.5, .5, 'Dokter Pengirim / Reffered', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->Cell(8, .5, (!empty($sql_dokter_krm->nama) ? (!empty($sql_dokter_krm->nama_dpn) ? $sql_dokter_krm->nama_dpn.' ' : '').$sql_dokter_krm->nama.(!empty($sql_dokter_krm->nama_blk) ? ', '.$sql_dokter_krm->nama_blk.' ' : '') : $sql_medc->nama), '0', 0, 'L', $fill);
            $pdf->Ln(1);
                        
            $fill = FALSE;
            foreach ($sql_medc_item as $rad){
                $sql_rad_det = $this->db->where('id_medcheck_det', $rad->id)->where('id_rad', $rad->id_rad)->get('tbl_trans_medcheck_rad_det')->result();
                
                $pdf->SetFont('Arial', 'B', '11');
                $pdf->Cell(19, .5, $rad->item, '', 0, 'L', $fill);
                $pdf->Ln();
                
                foreach ($sql_rad_det as $rad_hasil){
                    $pdf->SetFont('Arial', 'Bi', '7.5');
                    $pdf->Cell(5, .5, (!empty($rad_hasil->item_name) ? ' - ' : '').strtoupper($rad_hasil->item_name), '', 0, 'L', $fill);
                    $pdf->Cell(.5, .5, (!empty($rad_hasil->item_name) ? ':' : ''), '', 0, 'C', $fill);
                    $pdf->SetFont('Arial', '', '7.5');
//                    $pdf->Ln();
//                    $pdf->Cell(13.5, .5, ucfirst($rad_hasil->item_value), '', 0, 'L', $fill);
                    $pdf->MultiCell(13.5, .5, $rad_hasil->item_value, '', 'J', false);
//                    $pdf->Ln();
                }
                
                $pdf->Ln();
            }
            
            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Cell(19, .5, 'KESAN', '', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->SetFont('Arial', '', '9');
            $pdf->MultiCell(19, .5, $sql_medc_rad->ket, '', 'J', false);
            $pdf->Ln();

            // QR GENERATOR VALIDASI
            $qr_validasi        = $apppath.'/file/pasien/'.strtolower($kode_pasien).'/qr-validasi-'.strtolower($kode_pasien).'.png';
            $params['data']     = 'Telah diverifikasi dan ditandatangani secara elektronik oleh manajemen klinik esensia. Pasien a/n. ';
            $params['data']    .= strtoupper($sql_pasien->nama_pgl).' ('.strtoupper($kode_pasien).')';
            $params['level']    = 'H';
            $params['size']     = 2;
            $params['savename'] = $qr_validasi; 
            $this->ciqrcode->generate($params);
            
            $gambar4            = $qr_validasi; 
                        
            // QR GENERATOR DOKTER
            $qr_dokter          = $apppath.'/file/pasien/'.strtolower($kode_pasien).'/qr-dokter-'.strtolower($sql_dokter_rad->id).'.png';
            $params['data']     = 'Telah diverifikasi dan ditandatangani secara elektronik oleh dokter penanggung jawab ['.(!empty($sql_dokter_rad->nama_dpn) ? $sql_dokter_rad->nama_dpn.' ' : '').$sql_dokter_rad->nama.(!empty($sql_dokter_rad->nama_blk) ? ', '.$sql_dokter_rad->nama_blk : '').']';
            $params['level']    = 'H';
            $params['size']     = 2;
            $params['savename'] = $qr_dokter;
            $this->ciqrcode->generate($params);
            
            $gambar5            = $qr_dokter;  
            
            // Gambar VALIDASI
            $getY = $pdf->GetY() + 1;
            $pdf->Image($gambar4,2,$getY,2,2);
            $pdf->Image($gambar5,12.5,$getY,2,2);
            
            $pdf->SetFont('Arial', '', '10');
            $pdf->Cell(11.5, .5, '', '', 0, 'L', $fill);
            $pdf->Cell(7.5, .5, 'Semarang, '.$this->tanggalan->tgl_indo3($sql_medc_srt->tgl_simpan), '', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->SetFont('Arial', 'B', '10');
            $pdf->Cell(4, .5, 'Validasi', '0', 0, 'C', $fill);
            $pdf->Cell(7.5, .5, '', '0', 0, 'C', $fill);
            $pdf->SetFont('Arial', '', '10');
            $pdf->Cell(7.5, .5, (!empty($ket) ? $ket : 'Dokter Spesialis Radiologi'), '0', 0, 'L', $fill);
            $pdf->Ln(2.5);
            
            $pdf->SetFont('Arial', '', '10');
            $pdf->Cell(11, .5, '', '', 0, 'L', $fill);
            $pdf->Cell(8, .5, (!empty($sql_dokter_rad->nama_dpn) ? $sql_dokter_rad->nama_dpn.' ' : '').$sql_dokter_rad->nama.(!empty($sql_dokter_rad->nama_blk) ? ', '.$sql_dokter_rad->nama_blk.' ' : ''), '0', 0, 'L', $fill);
            $pdf->Ln();
                    
            $pdf->SetFillColor(235, 232, 228);
            $pdf->SetTextColor(0);
            $pdf->SetFont('Arial', '', '10');
            
            $type = (isset($_GET['type']) ? $_GET['type'] : 'I');
            
            ob_start();
            $pdf->Output($sql_pasien->nama_pgl. '.pdf', $type);
            ob_end_flush();
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }   
    
    public function set_daftar() {
        if (akses::aksesLoginP() == TRUE) {
            $id_pasien    = $this->input->post('id_pasien');
            $no_rm        = $this->input->post('no_rm');
            $nik_lama     = $this->input->post('nik');
            $nik_baru     = $this->input->post('nik_baru');
            $gelar        = $this->input->post('gelar');
            $nama         = $this->input->post('nama');
            $no_hp        = $this->input->post('no_hp');
            $no_rmh       = $this->input->post('no_rmh');
            $tmp_lahir    = $this->input->post('tmp_lahir');
            $tgl_lahir    = $this->input->post('tgl_lahir');
            $alamat       = $this->input->post('alamat');
            $alamat_dom   = $this->input->post('alamat_dom');
            $jns_klm      = $this->input->post('jns_klm');
            $pekerjaan    = $this->input->post('pekerjaan');
            $tipe_pas     = $this->input->post('tipe_pas');
            $file         = $this->input->post('file');
            $file_id      = $this->input->post('file_id');
            $alergi       = $this->input->post('alergi');
            $inst         = $this->input->post('instansi');
            $inst_alamat  = $this->input->post('instansi_almt');
            
            $tgl_masuk    = $this->input->post('tgl_masuk');
            $plat         = $this->input->post('platform');
            $poli         = $this->input->post('poli');
            $dokter       = $this->input->post('dokter');
            
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('gelar', 'Gelar', 'required');
            $this->form_validation->set_rules('nama', 'Nama Pasien', 'required');
            $this->form_validation->set_rules('jns_klm', 'Jenis Kelamin', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'gelar'   => form_error('gelar'),
                    'nama'    => form_error('nama'),
                    'jns_klm' => form_error('jns_klm'),
                );
//
                // value data pasien                        
                $this->session->set_flashdata('tipe_pas', $tipe_pas);
                $this->session->set_flashdata('nik_baru', $nik_baru);
                $this->session->set_flashdata('nama', $nama);
                $this->session->set_flashdata('tmp_lahir', $tmp_lahir);
                $this->session->set_flashdata('tgl_lahir', $tgl_lahir);
                $this->session->set_flashdata('jns_klm', $jns_klm);
                $this->session->set_flashdata('no_hp', $no_hp);
                $this->session->set_flashdata('no_rmh', $no_rmh);
                $this->session->set_flashdata('alamat', $alamat);
                $this->session->set_flashdata('alamat_dom', $alamat_dom);
                $this->session->set_flashdata('pekerjaan', $pekerjaan);
                $this->session->set_flashdata('poli', $poli);
                $this->session->set_flashdata('dokter', $dokter);
                $this->session->set_flashdata('alergi', $alergi);
                
                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url('pasien/pendaftaran.php'));
            } else {
                $tmsk    = $this->tanggalan->tgl_indo_sys($tgl_masuk);
                $sql_cek1= $this->db->where('id', general::dekrip($id_pasien))->get('tbl_m_pasien');
                $sql_cek2= $this->db->like('nik', $nik)->get('tbl_m_pasien');
                
                if($sql_cek1->num_rows() > 0){
                    $sql_num    = $this->db->where('DATE(tgl_masuk)', $tmsk)->where('id_poli', $poli)->get('tbl_pendaftaran');
                    $pasien     = $sql_cek1->row();
                    $sql_glr    = $this->db->where('id', $pasien->id_gelar)->get('tbl_m_gelar')->row();
                    $no_urut    = $sql_num->num_rows() + 1;
                    
                }elseif($sql_cek2->num_rows() > 0){
                    $sql_num    = $this->db->where('DATE(tgl_masuk)', $tmsk)->where('id_poli', $poli)->get('tbl_pendaftaran');
                    $pasien     = $sql_cek2->row();
                    $sql_glr    = $this->db->where('id', $pasien->id_gelar)->get('tbl_m_gelar')->row();
                    $no_urut    = $sql_num->num_rows() + 1;
                    
                }else{
                    $this->session->set_flashdata('master', '<div class="alert alert-danger">NIK atau No. RM Pasien tidak ditemukan di database !!</div>');
                }
                
                $data = array(
                    'tgl_simpan'        => date('Y-m-d H:i:s'),
                    'tgl_masuk'         => $tmsk.' '.date('H:i:s'),
                    'id_pasien'         => general::dekrip($id_pasien),
                    'id_gelar'          => (!empty($gelar) ? $gelar : '0'),
                    'id_poli'           => (!empty($poli) ? $poli : '0'),
                    'id_dokter'         => (!empty($dokter) ? $dokter : '0'),
                    'id_pekerjaan'      => (!empty($pekerjaan) ? $pekerjaan : '0'),
                    'no_urut'           => $no_urut,
                    'nik'               => $nik_lama,
                    'nama'              => $nama,
                    'nama_pgl'          => strtoupper($sql_glr->gelar.' '.$nama),
                    'tmp_lahir'         => $tmp_lahir,
                    'tgl_lahir'         => $this->tanggalan->tgl_indo_sys($tgl_lahir),
                    'jns_klm'           => (!empty($jns_klm) ? $jns_klm : 0),
                    'kontak'            => $no_hp,
                    'kontak_rmh'        => $no_rmh,
                    'alamat'            => $alamat,
                    'alamat_dom'        => $alamat_dom,
                    'instansi'          => $inst,
                    'instansi_alamat'   => $inst_alamat,
                    'file_base64'       => $file,
                    'file_base64_id'    => $file_id,
                    'alergi'            => $alergi,
                    'tipe_bayar'        => (!empty($plat) ? $plat : '0'),
                    'status'            => '1',
                    'status_akt'        => '0',
                    'status_hdr'        => '0',
                    'status_dft'        => '2',
                );
                
                /* Transaksi Database */
                $this->db->query('SET autocommit = 0;');
                $this->db->trans_start();
                
                # Masukkan ke tabel pendaftaran
                $this->db->insert('tbl_pendaftaran', $data);
                $last_id = crud::last_id();
                
                # Cek status transact MySQL
                if ($this->db->trans_status() === FALSE) {
                    # Rollback jika gagal
                    $this->db->trans_rollback();

                    # Tampilkan pesan error
                    $this->session->set_flashdata('pasien', '<div class="alert alert-danger">Pendaftaran pelayanan gagal</div>');
                } else {
                    $this->db->trans_complete();

                    # Tampilkan pesan sukses jika sudah berhasil commit
                    $this->session->set_flashdata('pasien', '<div class="alert alert-success">Pendaftaran pelayanan berhasil</div>');
                }
                
//                echo '<pre>';
//                print_r($data);
//
//                $this->session->set_flashdata('master', '<div class="alert alert-success">Data member berhasil diubah</div>');
//
//                crud::simpan('tbl_pendaftaran', $data_pas);
//                $last_id = crud::last_id();                
////
                redirect(base_url('pasien/pendaftaran.php?id='.general::enkrip($last_id)));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect('pasien');
        }
    }   
    
    public function set_daftar_baru() {
       $id_pasien    = $this->input->post('id_pasien');
       $no_rm        = $this->input->post('no_rm');
       $nik          = $this->input->post('nik');
       $gelar        = $this->input->post('gelar');
       $nama         = $this->input->post('nama');
       $no_hp        = $this->input->post('no_hp');
       $no_rmh       = $this->input->post('no_rmh');
       $tmp_lahir    = $this->input->post('tmp_lahir');
       $tgl_lahir    = $this->input->post('tgl_lahir');
       $alamat       = $this->input->post('alamat');
       $alamat_dom   = $this->input->post('alamat_dom');
       $jns_klm      = $this->input->post('jns_klm');
       $pekerjaan    = $this->input->post('pekerjaan');
       $tipe_pas     = $this->input->post('tipe_pas');
       $file         = $this->input->post('file');
       $file_id      = $this->input->post('file_id');
       $alergi       = $this->input->post('alergi');
       $inst         = $this->input->post('instansi');
       $inst_alamat  = $this->input->post('instansi_almt');
       
       $tgl_masuk    = $this->input->post('tgl_masuk');
       $plat         = $this->input->post('platform');
       $poli         = $this->input->post('poli');
       $dokter       = $this->input->post('dokter');
       
       $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
//
       $this->form_validation->set_rules('gelar', 'Gelar', 'required');
       $this->form_validation->set_rules('nama', 'Nama Pasien', 'required');
       $this->form_validation->set_rules('jns_klm', 'Jenis Kelamin', 'required');
       $this->form_validation->set_rules('tgl_lahir', 'Tanggal Lahir', 'required');
       $this->form_validation->set_rules('alamat', 'Alamat', 'required');
       $this->form_validation->set_rules('platform', 'Penjamin', 'required');
       $this->form_validation->set_rules('poli', 'Poli', 'required');
       $this->form_validation->set_rules('dokter', 'Dokter', 'required');
//       $this->form_validation->set_rules('tgl_periksa', 'Tgl Periksa', 'required');
//
       if ($this->form_validation->run() == FALSE) {
           $msg_error = array(
               'gelar'      => form_error('gelar'),
               'nama'       => form_error('nama'),
               'jns_klm'    => form_error('jns_klm'),
               'tgl_lahir'  => form_error('tgl_lahir'),
               'alamat'     => form_error('alamat'),
               'platform'   => form_error('platform'),
               'poli'       => form_error('poli'),
               'dokter'     => form_error('dokter'),
//               'tgl_periksa'=> form_error('tgl_periksa'),
           );
////
           // value data pasien                        
           $this->session->set_flashdata('tipe_pas', $tipe_pas);
           $this->session->set_flashdata('nik_baru', $nik_baru);
           $this->session->set_flashdata('nama', $nama);
           $this->session->set_flashdata('tmp_lahir', $tmp_lahir);
           $this->session->set_flashdata('tgl_lahir', $tgl_lahir);
           $this->session->set_flashdata('jns_klm', $jns_klm);
           $this->session->set_flashdata('no_hp', $no_hp);
           $this->session->set_flashdata('no_rmh', $no_rmh);
           $this->session->set_flashdata('alamat', $alamat);
           $this->session->set_flashdata('alamat_dom', $alamat_dom);
           $this->session->set_flashdata('pekerjaan', $pekerjaan);
           $this->session->set_flashdata('poli', $poli);
           $this->session->set_flashdata('dokter', $dokter);
           $this->session->set_flashdata('alergi', $alergi);
           
           $this->session->set_flashdata('form_error', $msg_error);
           redirect(base_url('pasien/pendaftaran_baru.php'));
       } else {
           $tmsk    = $this->tanggalan->tgl_indo_sys($tgl_masuk);
           $sql_cek1= $this->db->where('id', general::dekrip($id_pasien))->get('tbl_m_pasien');
           $sql_cek2= $this->db->like('nik', $nik)->get('tbl_m_pasien');
           
           if($sql_cek1->num_rows() > 0){
               $sql_num    = $this->db->where('DATE(tgl_masuk)', $tmsk)->where('id_poli', $poli)->get('tbl_pendaftaran');
               $pasien     = $sql_cek1->row();
               $sql_glr    = $this->db->where('id', $pasien->id_gelar)->get('tbl_m_gelar')->row();
               $no_urut    = $sql_num->num_rows() + 1;
               
           }elseif($sql_cek2->num_rows() > 0){
               $sql_num    = $this->db->where('DATE(tgl_masuk)', $tmsk)->where('id_poli', $poli)->get('tbl_pendaftaran');
               $pasien     = $sql_cek2->row();
               $sql_glr    = $this->db->where('id', $pasien->id_gelar)->get('tbl_m_gelar')->row();
               $no_urut    = $sql_num->num_rows() + 1;
               
           }else{
               $sql_num    = $this->db->where('DATE(tgl_masuk)', $tmsk)->where('id_poli', $poli)->get('tbl_pendaftaran');
               $sql_glr    = $this->db->where('id', $pasien->id_gelar)->get('tbl_m_gelar')->row();
               $no_urut    = $sql_num->num_rows() + 1;
//               $this->session->set_flashdata('master', '<div class="alert alert-danger">NIK atau No. RM Pasien tidak ditemukan di database !!</div>');
           }
           
           $data = array(
               'tgl_simpan'        => date('Y-m-d H:i:s'),
               'tgl_masuk'         => $tmsk.' '.date('H:i:s'),
               'id_pasien'         => general::dekrip($id_pasien),
               'id_gelar'          => (!empty($gelar) ? $gelar : '0'),
               'id_poli'           => (!empty($poli) ? $poli : '0'),
               'id_dokter'         => (!empty($dokter) ? $dokter : '0'),
               'id_pekerjaan'      => (!empty($pekerjaan) ? $pekerjaan : '0'),
               'no_urut'           => $no_urut,
               'nik'               => $nik,
               'nama'              => $nama,
               'nama_pgl'          => strtoupper($sql_glr->gelar.' '.$nama),
               'tmp_lahir'         => $tmp_lahir,
               'tgl_lahir'         => $this->tanggalan->tgl_indo_sys($tgl_lahir),
               'jns_klm'           => (!empty($jns_klm) ? $jns_klm : 0),
               'kontak'            => $no_hp,
               'kontak_rmh'        => $no_rmh,
               'alamat'            => $alamat,
               'alamat_dom'        => $alamat_dom,
               'instansi'          => $inst,
               'instansi_alamat'   => $inst_alamat,
               'file_base64'       => $file,
               'file_base64_id'    => $file_id,
               'alergi'            => $alergi,
               'tipe_bayar'        => (!empty($plat) ? $plat : '0'),
               'status'            => '2',
               'status_akt'        => '0',
               'status_hdr'        => '0',
               'status_dft'        => '2',
           );
           
           # Validasi captcha google
           if($this->input->post('daftar') === 'daftar_aksi'){
               
               $is_valid = $this->recaptcha->is_valid();
               
               # Cek captcha valid atau tidak
               if($is_valid['success']){
                   
                   /* Transaksi Database */
                   $this->db->query('SET autocommit = 0;');
                   $this->db->trans_start();
//
                   # Masukkan ke tabel pendaftaran
                   $this->db->insert('tbl_pendaftaran', $data);
                   $last_id = crud::last_id();
//
                   # Cek status transact MySQL
                   if ($this->db->trans_status() === FALSE) {
                       # Rollback jika gagal
                       $this->db->trans_rollback();
//
                       # Tampilkan pesan error
                       $this->session->set_flashdata('pasien', '<div class="alert alert-danger">Pendaftaran pelayanan gagal</div>');
                   } else {
                       $this->db->trans_complete();
//
                       # Tampilkan pesan sukses jika sudah berhasil commit
                       $this->session->set_flashdata('pasien', '<div class="alert alert-success">Pendaftaran pelayanan berhasil</div>');
                   }
                   redirect(base_url('pasien/pendaftaran_baru.php?id='.general::enkrip($last_id)));
               }else{
                   redirect(base_url('pasien/pendaftaran_baru.php'));
               }
           }else{
               redirect(base_url('pasien/pendaftaran_baru.php'));
           }
           
//           echo '<pre>';
//           print_r($data);
       }
    }   
    
    public function set_daftar_hapus() {
        if (akses::aksesLoginP() == TRUE) {
            $id         = $this->input->get('id');
            $rute       = $this->input->get('route');
            
            if(!empty($id)){
                $this->session->set_flashdata('medcheck', '<div class="alert alert-success">Item berhasil di hapus</div>');
                crud::delete('tbl_pendaftaran', 'id', general::dekrip($id));
            }
            
            redirect(base_url('pasien/pendaftaran.php'));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect('pasien');
        }
    }
    
    public function logout() {
        ob_start();
        $user  = $this->ion_auth->user()->row();
        $grup  = $this->ion_auth->get_users_groups($user->id)->row();
                
        $this->ion_auth->logout();
        $this->session->set_flashdata('login','<p class="login-box-msg text-success">Anda berhasil logout !!</p>');
        redirect(base_url(($user->tipe == '2' ? 'pasien' : '')));
        ob_end_flush();
    }
}
