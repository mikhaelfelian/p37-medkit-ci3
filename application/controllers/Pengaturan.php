<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
/**
 * Description of pengaturan
 *
 * @author miki
 * 
 */

class pengaturan extends CI_Controller {
    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $this->load->dbforge();
    }
    
    public function printer() {
        if (akses::aksesLogin() == TRUE) {
            $data['pengaturan']  = $this->db->query("SELECT * FROM tbl_pengaturan")->result();
            $data['printer']     = $this->db->query("SELECT * FROM tbl_printer")->result();

            $this->load->view('1_atas', $data);
            $this->load->view('2_navbar', $data);
            $this->load->view('includes/pengaturan/printer', $data); // Beranda
            $this->load->view('4_bawah', $data);
        } else {
             $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }
    
    public function printer_hapus() {
        if (akses::aksesLogin() == TRUE) {
            $id = $this->input->get('id');            
            if(isset($id)){
                crud::delete('tbl_printer','id',general::dekrip($id));
                $this->session->set_flashdata('pengaturan','<div class="alert alert-success">Data printer berhasil dihapus !!</div>');
                redirect('page=pengaturan&act=printer');
            }else{
                $this->session->set_flashdata('pengaturan','<div class="alert alert-danger">Proses gagal !!</div>');
                redirect('page=pengaturan&act=printer');
            }
        } else {
             $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }
    
    public function printer_simpan() {
        if (akses::aksesLogin() == TRUE) {
            
        } else {
             $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }
    
    
    public function index() {
        if (akses::aksesLogin() == TRUE) {
            $data['pengaturan']  = $this->db->get("tbl_pengaturan")->row();
            $data['hasError']  = $this->session->flashdata('form_error');
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/pengaturan/sidebar_pengaturan';
            /* --- Sidebar Menu --- */
            
            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/pengaturan/pengaturan', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
             $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }
    
    public function backup_db() {
        if (akses::aksesLogin() == TRUE) {            
            $cek_tabel = $this->db->table_exists('tbl_util_backup');
            if($cek_tabel == 1){                
                $prefs = array(
                    'tables'     => $tabel, // Array of tables to backup.
                    'ignore'     => array(), // List of tables to omit from the backup
                    'format'     => 'txt', // gzip, zip, txt
                    'add_drop'   => TRUE, // Whether to add DROP TABLE statements to backup file
                    'add_insert' => TRUE, // Whether to add INSERT data to backup file
                    'newline'    => "\r\n"  // Newline character used in backup file
                );
                $backup = & $this->dbutil->backup($prefs);
                $path = realpath('../database/backup');
                write_file($path . '/temp_backup.sql', $backup); 
            }else{
                $fields = array(
                    'id' => array(
                        'type'           => 'INT',
                        'constraint'     => 11,
                        'unsigned'       => TRUE,
                        'auto_increment' => TRUE
                    ),
                    
                    'tgl' => array(
                        'type'           => 'TIMESTAMP',
                        'null'           => TRUE,
                    ),
                    
                    'name' => array(
                        'type'       => 'VARCHAR',
                        'constraint' => 160
                    )
                );
                $this->dbforge->add_field($fields);
                $this->dbforge->add_key('id', TRUE);
                $this->dbforge->create_table('tbl_util_backup', TRUE);
            }

            $data['pengaturan']  = $this->db->query("SELECT * FROM tbl_pengaturan")->result();
            $data['backup_list'] = $this->db->query("SELECT DATE(tgl) as tgl, TIME(tgl) as jam, name FROM tbl_util_backup ORDER BY tgl DESC")->result();
            $data['user']        = $this->ion_auth->user()->row();
            $data['hasError']  = $this->session->flashdata('form_error');
            
            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/user/backup_db', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
             $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }
    
    public function backup_download() {
        if (akses::aksesLogin() == TRUE) {
            $dbs    = $this->dbutil->list_databases();
            $user   = $this->ion_auth->user()->row();
            $tabel  = $this->db->list_tables();
            
            $prefs = array(
                'tables'     => $tabel, // Array of tables to backup.
                'ignore'     => array(), // List of tables to omit from the backup
                'format'     => 'txt', // gzip, zip, txt
                'filename'   => 'backup_'.date('YmdHis').'.sql', // File name - NEEDED ONLY WITH ZIP FILES
                'add_drop'   => TRUE, // Whether to add DROP TABLE statements to backup file
                'add_insert' => TRUE, // Whether to add INSERT data to backup file
                'newline'    => "\n"               // Newline character used in backup file
            );
            $backup = & $this->dbutil->backup($prefs);
            $path   = realpath('./database/backup').'/';
            $file   = 'backup_'.date('YmdHis').'_'.$user->username.'.sql';
            
            if(isset($_GET['trigger'])){
                if($_GET['trigger'] == 'create'){
                    $data = array(
                        'tgl'  => date('Y-m-d H:i:s'),
                        'name' => $file
                    );
                    crud::simpan('tbl_util_backup',$data);
                    write_file($path.$file, $backup);
                    $this->session->set_flashdata('pengaturan', '<div class="alert alert-success">Backup data, berhasil dibuat !!</div>');
                    redirect('page=pengaturan&act=backup_db');
                }
            }else{                
                write_file($path, $backup); 
                force_download($file, $backup);
            }
        } else {
             $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }

    public function backup_file_download(){
        if (akses::aksesLogin() == TRUE) {
            $id   = $_GET['id'];
            $path = realpath('./database/backup').'/';
            $file = general::dekrip($id);
            force_download($file,  file_get_contents($path.$file));
        }else{
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }

    public function backup_file_hapus(){
        if (akses::aksesLogin() == TRUE) {
            $id   = $_GET['id'];
            $path = realpath('./database/backup').'/';
            $file = general::dekrip($id);
            unlink($path.$file);
            crud::delete('tbl_util_backup','name',$file);
            redirect('page=pengaturan&act=backup_db');
        }else{
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }

    public function restore_db(){
        if (akses::aksesLogin() == TRUE) {
            $lines = file($_FILES['frestore']['tmp_name']);
            
            foreach ($lines as $line){
                // Lompat jika berupa baris komentar
                if (substr($line, 0, 2) == '--' || $line == '')
                    continue;

                // Tambahkan baris berikut, pada segment ini
                $templine .= $line;
                // Titik komea menandakan akhir dari kueri
                if (substr(trim($line), -1, 1) == ';') {
                    // jika MySQL 5.1 maka cek foreign key-nya
                    $this->db->query("SET FOREIGN_KEY_CHECKS=0;");
                    // Kueri MySQL
                    $this->db->query($templine);
                    $templine = '';
                }
            }
            
            $this->session->set_flashdata('pengaturan', '<div class="alert alert-success">Database, berhasil dikembalikan !!</div>');
            redirect('page=pengaturan&act=backup_db');
        }else{
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }

    public function ganti_password()
    {
        if (akses::aksesLogin() == TRUE) {
        
            $data['pengaturan']  = $this->db->query("SELECT * FROM tbl_pengaturan")->result();
            $data['user']  = $this->db->query("SELECT DATE(last_login) as last_tgl, TIME(last_login) as last_waktu, nama, username, level, status FROM tbl_user WHERE level !='root'")->result();
           
            $this->load->view('1_atas', $data);
            $this->load->view('2_navbar', $data);
            $this->load->view('includes/pengaturan/ganti_password', $data); // Beranda
            $this->load->view('4_bawah', $data);
        }else{
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }    
    
    public function set_pengaturan() {
        if (akses::aksesLogin() == TRUE) {
            $judul  = $this->input->post('judul');
            $alamat = $this->input->post('alamat');
            $kota   = $this->input->post('kota');
            $ppn    = $this->input->post('jml_ppn');
            $poin   = $this->input->post('jml_poin');
            $itm    = $this->input->post('jml_item');
            $itm_lmt= $this->input->post('jml_item_limit');
            $tahun  = $this->input->post('tahun');
            $cabang = $this->input->post('cabang');
            $ss_org = $this->input->post('ss_org_id');
            $ss_id  = $this->input->post('ss_client_id');
            $ss_scr = $this->input->post('ss_client_secret');
            
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('judul', 'Email', '');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'judul'   => form_error('judul'),
                );
                
                $this->session->set_flashdata('form_error', $msg_error);
                $this->session->set_flashdata('has_error', $has_error);

                $this->session->set_flashdata('email', $user);
                redirect(base_url('pengaturan/index.php'));
            }else{
                $peng = array(
                    'judul'             => $judul,
                    'alamat'            => $alamat,
                    'kota'              => $kota,
                    'jml_ppn'           => $ppn,
                    'jml_item'          => $itm,
                    'jml_limit_stok'    => $itm_lmt,
                    'jml_poin'          => $poin,
                    'tahun_poin'        => $tahun,
                    'ss_org_id'         => $ss_org,
                    'ss_client_id'      => $ss_id,
                    'ss_client_secret'  => $ss_scr,
                );
                
                crud::update('tbl_pengaturan','id_pengaturan','1',$peng);
                
                $this->session->set_flashdata('pengaturan_toast', 'toastr.success("Pengaturan berhasil disimpan !");');
                redirect(base_url('pengaturan/index.php'));
            }
        } else {
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }
    
    public function profile() {
        if (akses::aksesLogin() == TRUE) {
            $ses                    = $this->session->userdata('login');
            $id                     = $this->input->get('id_kel');
            $data['user']           = $this->ion_auth->user()->row();
            
            $data['sql_kary']       = $this->db->where('id_user', $data['user']->id)->get('tbl_m_karyawan')->row();
            $data['sql_kary_kel']   = $this->db->where('id_karyawan', $data['sql_kary']->id)->get('tbl_m_karyawan_kel')->result();
            $data['sql_kary_kel_rw']= $this->db->where('id', general::dekrip($id))->get('tbl_m_karyawan_kel')->row();
            $data['sql_kary_pend']  = $this->db->where('id_karyawan', $data['sql_kary']->id)->get('tbl_m_karyawan_pend')->result();
            $data['sql_kary_sert']  = $this->db->where('id_karyawan', $data['sql_kary']->id)->get('tbl_m_karyawan_sert')->result();
            $data['sql_kary_peg']   = $this->db->where('id_karyawan', $data['sql_kary']->id)->get('tbl_m_karyawan_peg')->result();            
            $data['sql_kary_cuti']  = $this->db
                                           ->select('tbl_sdm_cuti.id, tbl_sdm_cuti.id_user, tbl_sdm_cuti.tgl_simpan, tbl_sdm_cuti.tgl_masuk, tbl_sdm_cuti.tgl_keluar, tbl_sdm_cuti.keterangan, tbl_sdm_cuti.catatan, tbl_sdm_cuti.file_name, tbl_sdm_cuti.file_type, tbl_sdm_cuti.status, tbl_m_karyawan.nama, tbl_m_karyawan.tgl_lahir, tbl_m_karyawan.alamat, tbl_m_karyawan.jns_klm, tbl_m_kategori_cuti.tipe')
                                           ->join('tbl_m_karyawan', 'tbl_m_karyawan.id=tbl_sdm_cuti.id_karyawan')
                                           ->join('tbl_m_kategori_cuti', 'tbl_m_kategori_cuti.id=tbl_sdm_cuti.id_kategori')
                                           ->where('tbl_sdm_cuti.id_karyawan', $data['sql_kary']->id)
                                           ->get('tbl_sdm_cuti')->result();         
            $data['sql_kary_srt']  = $this->db
                                           ->join('tbl_m_karyawan', 'tbl_m_karyawan.id=tbl_sdm_surat_krj.id_karyawan')
                                           ->where('tbl_sdm_surat_krj.id_karyawan', $data['sql_kary']->id)
                                           ->get('tbl_sdm_surat_krj')->result();         
            $data['sql_dep']        = $this->db->get('tbl_m_departemen')->result();
            $data['sql_jab']        = $this->db->get('tbl_m_jabatan')->result();
            $data['sql_kat_cuti']   = $this->db->get('tbl_m_kategori_cuti')->result();
            $data['sql_kary_tipe']  = $this->db->where('status', '1')->get('tbl_m_karyawan_tipe')->result();
            /* Sidebar Menu */
            $data['sidebar']        = 'admin-lte-3/includes/user/sidebar_sdm';
            /* --- Sidebar Menu --- */
            
            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/user/profile', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
             $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }
	
    public function set_profile_update(){
        if (akses::aksesLogin() == TRUE) {
            $id           = $this->input->post('id');
            $id_user      = $this->input->post('id_user');
            $nik          = $this->input->post('nik');
            $kode         = $this->input->post('kode');
            $nama_dpn     = $this->input->post('nama_dpn');
            $nama         = $this->input->post('nama');
            $nama_blk     = $this->input->post('nama_blk');
            $jns_klm      = $this->input->post('jns_klm');
            $no_hp        = $this->input->post('no_hp');
            $no_rmh       = $this->input->post('no_rmh');
            $alamat       = $this->input->post('alamat');
            $alamat_dom   = $this->input->post('alamat_dom');
            $tgl_lahir    = $this->input->post('tgl_lahir');
            $tmp_lahir    = $this->input->post('tmp_lahir');
            $kota         = $this->input->post('kota');
            $jabatan      = $this->input->post('jabatan');
            $user         = $this->input->post('user');
            $pass1        = $this->input->post('pass1');
            $pass2        = $this->input->post('pass2');
            $grup         = $this->input->post('grup');
            $rute         = $this->input->post('route');
            
            $pengaturan   = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('nik', 'NIK', 'required');
//            $this->form_validation->set_rules('nama', 'Nama', 'required');
//            $this->form_validation->set_rules('jns_klm', 'Jenis Klm', 'required');
//            $this->form_validation->set_rules('tmp_lahir', 'Tempat Lahir', 'required');
//            $this->form_validation->set_rules('tgl_lahir', 'Tgl Lahir', 'required');
//            $this->form_validation->set_rules('alamat', 'Alamat', 'required');
//            $this->form_validation->set_rules('alamat_dom', 'Alamat Dom', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'nik'           => form_error('nik'),
//                    'nama'          => form_error('nama'),
//                    'jns_klm'       => form_error('jns_klm'),
//                    'tmp_lahir'     => form_error('tmp_lahir'),
//                    'tgl_lahir'     => form_error('tgl_lahir'),
//                    'alamat'        => form_error('alamat'),
//                    'alamat_dom'    => form_error('alamat_dom'),
                );
                
                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url('profile.php'));
            } else {
               $sql_kary        = $this->db->where('id', general::dekrip($id))->get('tbl_m_karyawan')->row();
               $get_grup        = $this->ion_auth->get_users_groups(general::dekrip($id_user))->row();
               $sql_grup        = $this->ion_auth->group($get_grup->id)->row();
               $sql_user_ck     = $this->db->where('id', general::dekrip($id_user))->get('tbl_ion_users');
                
               $path            = 'file/user/userid_'.sprintf('%03d',$sql_user_ck->row()->id);
                              
               # File untuk data profile karyawan
               if (!empty($_FILES['fupload']['name'])) {              
                    # Buat Folder Untuk File Karyawan
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }
                    
                    $config['upload_path']      = realpath($path);
                    $config['allowed_types']    = 'jpg|png|pdf|jpeg';
                    $config['remove_spaces']    = TRUE;
                    $config['overwrite']        = TRUE;
                    $config['file_name']        = 'userid_'.sprintf('%03d',$sql_user_ck->row()->id);
                    $this->load->library('upload', $config);
                    
                    if (!$this->upload->do_upload('fupload')) {
                        $this->session->set_flashdata('pengaturan_toast', 'toastr.error("Gagal : <b>'.$this->upload->display_errors().'</b>");');
                        redirect(base_url('profile.php'));
                    } else {
                        $f          = $this->upload->data();
                        $file_name  = $f['orig_name'];
                        $file_type  = $f['file_type'];
                        $file_ext   = $f['file_ext'];
                        
                        $this->db->where('id', general::dekrip($id_user))->update('tbl_ion_users', array('file_name' => $file_name));
                    }
                }
                                
                if(!empty($pass1)) {
                    $data_user = array(
                        'id_app'        => $pengaturan->id_app,
                        'first_name'    => (!empty($nama_dpn) ? $nama_dpn.' ' : '').strtoupper($nama).(!empty($nama_blk) ? ', '.$nama_blk : ''),
                        'username'      => $user,
                        'password'      => $pass2,
                        'address'       => $alamat,
                        'birthdate'     => (!empty($tgl_lahir) ? $this->tanggalan->tgl_indo_sys($tgl_lahir) : '0000-00-00'),
                    );
                } else {
                    $data_user = array(
                        'id_app'        => $pengaturan->id_app,
                        'first_name'    => (!empty($nama_dpn) ? $nama_dpn.' ' : '').strtoupper($nama).(!empty($nama_blk) ? ', '.$nama_blk : ''),
                        'username'      => $user,
                        'address'       => $alamat,
                        'birthdate'     => (!empty($tgl_lahir) ? $this->tanggalan->tgl_indo_sys($tgl_lahir) : '0000-00-00'),
                    );
                }
                
                if($sql_user_ck->num_rows() > 0){                
                    $this->ion_auth->remove_from_group(array($sql_grup->id), general::dekrip($id_user));
                    $this->ion_auth->update(general::dekrip($id_user), $data_user);
                    $this->ion_auth->add_to_group($grup, general::dekrip($id_user));
                    $userid     = general::dekrip($id_user);
                }else{
                    $this->ion_auth->register($user, $pass2, $email, $data_user, array($grup));
                    $sql_user   = $this->db->where('username', $user)->get('tbl_ion_users')->row();
                    $userid     = $sql_user->id;
                }
                
                $data_penj = array(
                    'tgl_modif'         => date('Y-m-d H:i:s'),
                    'id_user'           => general::dekrip($id_user),
                    'id_user_group'     => $grup,
                    'nik'               => $nik,
                    'nama'              => strtoupper($nama),
                    'nama_dpn'          => $nama_dpn,
                    'nama_blk'          => $nama_blk,
                    'alamat'            => $alamat,
                    'alamat_dom'        => $alamat_dom,
                    'no_hp'             => $no_hp,
                    'no_rmh'            => $no_rmh,
                    'jabatan'           => $jabatan,
                    'jns_klm'           => $jns_klm,
                    'tgl_lahir'         => (!empty($tgl_lahir) ? $this->tanggalan->tgl_indo_sys($tgl_lahir) : '0000-00-00'),
                    'tmp_lahir'         => $tmp_lahir
                );
                
                $this->db->where('id', general::dekrip($id))->update('tbl_m_karyawan', $data_penj);
                
                if($this->db->affected_rows() > 0){
                    $this->session->set_flashdata('pengaturan_toast', 'toastr.success("Profile berhasil disimpan !");');
                }
                
                redirect(base_url('profile.php'));

//                echo general::dekrip($id);
//                echo '<pre>';
//                print_r($data_penj);
//                echo '</pre>';
//                echo '<pre>';
//                print_r($data_user);
//                echo '</pre>';
//                echo '<pre>';
//                print_r($sql_kary);
//                echo '</pre>';
//                echo '<pre>';
//                print_r($data_user);
//                echo '</pre>';
            }
        }else{
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }
    
    public function cabang_list() {
        if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE) {
            $id      = $this->input->get('id');
            $kueri   = $this->input->get('kueri');
            
            $data['cabang']    = $this->db->where('id', general::dekrip($id))->get('tbl_pengaturan_cabang')->row();
            $data['cabangs']   = $this->db->like('keterangan', $kueri)->get('tbl_pengaturan_cabang')->result();
            $data['hasError']  = $this->session->flashdata('form_error');
                        
            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/includes/pengaturan/cabang_list', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
             $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }
    
    public function cabang_simpan() {
        if (akses::aksesLogin() == TRUE) {
            $cabang  = $this->input->post('cabang');
            
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('cabang', 'cabang', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'cabang'   => form_error('cabang'),
                );
                
                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url('pengaturan/data_cabang_list.php'));
            }else{
                $data_cbg = array(
                    'tgl_simpan'    => date('Y-m-d H:i:s'),
                    'keterangan'    => $cabang,
                );
                
                crud::simpan('tbl_pengaturan_cabang', $data_cbg);
                
                $this->session->set_flashdata('pengaturan', '<div class="alert alert-success">Data berhasil disimpan</div>');
                redirect(base_url('pengaturan/data_cabang_list.php'));
            }
        } else {
             $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }
    
    public function cabang_update() {
        if (akses::aksesLogin() == TRUE) {
            $id      = $this->input->post('id');
            $cabang  = $this->input->post('cabang');
            
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('cabang', 'cabang', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'cabang'   => form_error('cabang'),
                );
                
                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url('pengaturan/data_cabang_list.php'));
            }else{
                $data_cbg = array(
                    'tgl_simpan'    => date('Y-m-d H:i:s'),
                    'keterangan'    => $cabang,
                );
                
                crud::update('tbl_pengaturan_cabang', 'id', general::dekrip($id), $data_cbg);
                
                $this->session->set_flashdata('pengaturan', '<div class="alert alert-success">Perubahan berhasil disimpan</div>');
                redirect(base_url('pengaturan/data_cabang_list.php'));
            }
        } else {
             $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }
    
    public function cabang_hapus() {
        if (akses::aksesLogin() == TRUE) {
            $id   = general::dekrip($this->input->get('id'));
            
            crud::delete('tbl_pengaturan_cabang','id', $id);
            $this->session->set_flashdata('pengaturan', '<div class="alert alert-success">Data berhasil dihapus !!</div>');          
            redirect(base_url('pengaturan/data_cabang_list.php'));
        } else {
             $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }
    
    public function user_list() {
        if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE) {
            $pengaturan = $this->db->get('tbl_pengaturan')->row();            
            $id         = $this->input->get('id');
            
            /* -- Blok Filter -- */
            $query      = $this->input->get('q');
            $hal        = $this->input->get('halaman');
            $jml        = $this->input->get('jml');
            /* -- End Blok Filter -- */
            
            /* -- jml halaman pada list -- */
            if(!empty($jml)){
                $jml_hal = $jml;
            }else{
                $jml_hal = $this->db->select('id')->where('tipe', '1')->get('tbl_ion_users')->num_rows();
            }            

            /* -- Form Error -- */
            $data['hasError']                = $this->session->flashdata('form_error');
            
            # Config Pagination
            $config['base_url']              = base_url('pengaturan/data_user_list.php?'.(!empty($jml_hal) ? 'jml='.$jml_hal : '').(!empty($query) ? 'query='.$query : ''));
            $config['total_rows']            = $jml_hal;

            $config['query_string_segment']  = 'halaman';
            $config['page_query_string']     = TRUE;
            $config['per_page']              = $pengaturan->jml_item;
            $config['num_links']             = 2;

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
            /* -- End Blok Pagination -- */
            
            if(!empty($hal)){
                $data['users']     = $this->db
                                              ->where('tipe', '1')
                                              ->limit($config['per_page'], $hal)
                                              ->order_by('id', 'desc')
                                              ->get('tbl_ion_users')->result();
            }else{
                $data['users']     = $this->db
                                              ->where('tipe', '1')
                                              ->limit($config['per_page'])
                                              ->order_by('id', 'desc')
                                              ->get('tbl_ion_users')->result();
            }

            $this->pagination->initialize($config);

            /* Blok pagination */
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();
            /* --End Blok pagination-- */
            
            $data['pengguna']  = $this->db->where('id', general::dekrip($id))->get('tbl_ion_users')->row();            
            $data['hasError']  = $this->session->flashdata('form_error');


            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/pengaturan/sidebar_pengaturan';
            /* --- Sidebar Menu --- */
            
            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/user/user_list', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
             $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }
    
    public function user_simpan() {
        if (akses::aksesLogin() == TRUE) {
            $nama  = strtoupper($this->input->post('nama'));
            $user  = $this->input->post('user');
            $pass1 = $this->input->post('pass1');
            $pass2 = $this->input->post('pass2');
            $group = $this->input->post('grup');
            $email = $this->input->post('email');
            $cbg   = $this->input->post('cabang');
            
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('nama', 'Nama', 'required');
            $this->form_validation->set_rules('user', 'Username', 'trim|required|min_length[4]');
            $this->form_validation->set_rules('pass1', 'Password', 'trim|required|min_length[5]|matches[pass2]');
            $this->form_validation->set_rules('pass2', 'Ulang Password', 'trim|required|min_length[5]');
            $this->form_validation->set_rules('grup', 'Grup Pengguna', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'nama'   => form_error('nama'),
                    'user'   => form_error('user'),
                    'pass1'  => form_error('pass1'),
                    'pass2'  => form_error('pass2'),
                    'grup'   => form_error('grup'),
                );
                
                $has_error = array(
                    'nama'   => 'has-error',
                    'user'   => 'has-error',
                    'pass1'  => 'has-error',
                    'pass2'  => 'has-error',
                );
                
                $this->session->set_flashdata('form_error', $msg_error);
                $this->session->set_flashdata('has_error', $has_error);

                $this->session->set_flashdata('nama', $nama);
                $this->session->set_flashdata('user', $user);
                redirect(base_url('pengaturan/data_user_list.php'));
            }else{
                $cek         = $this->db->select('username')
//                                        ->where('id_app', $cbg)
                                        ->where('username', $user)
                                        ->get('tbl_ion_users')->num_rows();
                
                if($cek > 0) {
                    $this->session->set_flashdata('pengaturan', '<div class="alert alert-danger">Username tidak bisa digunakan / sudah ada !!</div>');
                    redirect(base_url('pengaturan/data_user_list.php'));
                } else {
                    $grup = $this->ion_auth->group($group)->row()->name;
                    
                    // Simpan ke tabel user
                    $data_user = array(
                        'id_app'        => $cbg,
                        'first_name'    => $nama,
                        'status_gudang' => '1',
                    );
                    
                    $this->ion_auth->register($user, $pass2, $email, $data_user, array($group));
                    $sql_user = $this->db->where('username',$user)->get('tbl_ion_users')->row();
                    
                    /* Simpan ke tabel sales */
                    $sql_num = $this->db->get('tbl_m_karyawan')->num_rows() + 1;
                    $kode_no = sprintf('%05d', $sql_num);
                    
                    $data_sales = array(
                        'id_user'       => $sql_user->id,
                        'id_user_group' => $group,
                        'tgl_simpan'    => date('Y-m-d H:i:s'),
                        'tgl_modif'     => '0000-00-00 00:00:00',
                        'nik'           => '-',
                        'nama'          => $nama,
                        'kota'          => 'Semarang',
                        'alamat'        => '-',
                        'no_hp'         => '-',
                        'status'        => '0',
                    );
                    
                    crud::simpan('tbl_m_karyawan', $data_sales);
                    /* --Simpan ke tabel karyawan-- */                    
                    
                    $this->session->set_flashdata('pengaturan', '<div class="alert alert-success">Username berhasil disimpan !!</div>');
                    redirect(base_url('pengaturan/data_user_list.php'));
                }
            }
        } else {
             $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }
    
    public function user_update() {
        if (akses::aksesLogin() == TRUE) {
            $id    = $this->input->post('id');
            $email = $this->input->post('email');
            $nama  = $this->input->post('nama');
            $user  = $this->input->post('user');
            $pass1 = $this->input->post('pass1');
            $pass2 = $this->input->post('pass2');
            $group = $this->input->post('grup');
            
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('nama', 'Nama', 'required');
//            $this->form_validation->set_rules('user', 'Username', 'trim|required|min_length[4]');
//            $this->form_validation->set_rules('pass1', 'Password', 'trim|required|min_length[5]|matches[pass2]');
//            $this->form_validation->set_rules('pass2', 'Ulang Password', 'trim|required|min_length[5]');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'nama' => form_error('nama'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url('pengaturan/data_user_list.php?id='.$id));
            }else{
                $cbg         = $this->db->get('tbl_pengaturan')->row()->id_app;
                $get_grup    = $this->ion_auth->get_users_groups(general::dekrip($id))->row();
                $grup        = $this->ion_auth->group($get_grup->id)->row();
                
                if(!empty($pass1)) {
                    $data_user = array(
                        'id_app'        => $cbg,
                        'email'         => $email,
                        'first_name'    => $nama,
                        'username'      => $user,
                        'password'      => $pass2,
                    );
                } else {
                    $data_user = array(
                        'id_app'        => $cbg,
                        'email'         => $email,
                        'first_name'    => $nama,
                        'username'      => $user,
                    );
                }
                
                $this->ion_auth->remove_from_group(array($grup->id), general::dekrip($id));
                $this->ion_auth->update(general::dekrip($id), $data_user);
                $this->ion_auth->add_to_group($group, general::dekrip($id));
                
                $data_kary = array(
                    'id_user'       => general::dekrip($id),
                    'id_user_group' => $grup->id,
                    'tgl_modif'     => date('Y-m-d H:i:s'),
                    'nik'           => '-',
                    'nama'          => $nama,
                    'kota'          => 'Semarang',
                    'alamat'        => $grup->description,
                    'no_hp'         => '-',
                    'status'        => '0',
                );
                
                crud::update('tbl_m_karyawan', 'id_user', general::dekrip($id), $data_kary);
                
                $this->session->set_flashdata('pengaturan', '<div class="alert alert-success">Username berhasil disimpan !!</div>');
                redirect(base_url('pengaturan/data_user_list.php?id='.$id));
                
//                echo general::dekrip($id);
//                echo br();
//                echo $grup->id;
//                
//                $get_grup  = $this->ion_auth->get_users_groups(general::dekrip($id))->row();
//                $grup      = $this->ion_auth->group($get_grup->id)->row()->name;
//                $sql_grup  = $this->db->where('user_id', general::dekrip($id))->where('group_id', $get_grup->id)->get('tbl_ion_users_groups');
//                $sql_sales = $this->db->where('id_user', general::dekrip($id))->get('tbl_m_sales');
//                
//                if($sql_grup->num_rows() > 0){
//                    crud::update('tbl_ion_users_groups', 'id', $sql_grup->row()->id, array('group_id'=>$group));
//                }
//                
//
//                
//                if($sql_sales->num_rows() == 0){
//                    $data_sales = array(
//                        'id_app'      => $cbg,
//                        'id_user'     => general::dekrip($id),
//                        'tgl_simpan'  => date('Y-m-d H:i:s'),
//                        'nik'         => '00.000.000.0-000.000',
//                        'kode'        => substr($nama, 0, 2).$sql_num,
//                        'nama'        => $nama,
//                        'no_hp'       => '-',
//                        'alamat'      => '-',
//                        'kota'        => '-',
//                    );
//                    
//                    if($sql_grup->row() == 'kasir'){
//                        crud::simpan('tbl_m_sales', $data_sales);
//                    }
//                }else{
//                    $data_sales = array(
//                        'id_app'      => $cbg,
//                        'id_user'     => general::dekrip($id),
//                        'tgl_modif'  => date('Y-m-d H:i:s'),
//                        'kode'        => substr($nama, 0, 2).$sql_num,
//                        'nama'        => $nama,
//                    );
//                    crud::update('tbl_m_sales', 'id', $sql_sales->row()->id, $data_sales);
//                }
//                
            }
        } else {
             $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }
    
    public function user_hapus() {
        if (akses::aksesLogin() == TRUE) {
            $id   = general::dekrip($this->input->get('id'));
            $grup = $this->ion_auth->get_users_groups($id)->row()->name;
            
            crud::delete('tbl_m_karyawan','id_user', $id);
            
            $this->session->set_flashdata('pengaturan', '<div class="alert alert-success">Username : <b>' . $this->ion_auth->user($id)->row()->username. '</b>, berhasil dihapus !!</div>');
            $this->ion_auth->delete_user($id);            
            redirect(base_url('pengaturan/data_user_list.php'));
        } else {
             $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }
    
    public function mail_notif() {
        if (akses::aksesLogin() == TRUE) {
            $data['users']     = $this->db->get('tbl_pengaturan_notif')->result();
            $data['setting']   = $this->db->get('tbl_pengaturan')->row();
            $data['hasError']  = $this->session->flashdata('form_error');
            
            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/user/user_mail', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
             $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }
    
    public function mail_notif_simpan() {
        if (akses::aksesLogin() == TRUE) {
            $user  = $this->input->post('email');
            
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_message('valid_email', 'Format salah !!. Cth : user@namadomain.com');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'email_bcc'   => form_error('email'),
                );
                
                $this->session->set_flashdata('form_error', $msg_error);
                $this->session->set_flashdata('has_error', $has_error);

                $this->session->set_flashdata('email', $user);
                redirect('page=pengaturan&act=mail_notif');
            }else{
                crud::simpan('tbl_pengaturan_notif',array('email'=>$user));
                redirect('page=pengaturan&act=mail_notif');
            }
        } else {
             $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }
    
    public function mail_notif_hapus() {
        if (akses::aksesLogin() == TRUE) {
            $id = $this->encrypt->decode_url($_GET['id']);
            $this->session->set_flashdata('pengaturan', '<div class="alert alert-success"> Data berhasil dihapus !!</div>');
            crud::delete('tbl_pengaturan_notif','id',$id);
            redirect('page=pengaturan&act=mail_notif');
        } else {
             $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }
    
    public function mail_simpan() {
        if (akses::aksesLogin() == TRUE) {
            $nama  = $this->input->post('nama');
            $user  = $this->input->post('user');
            $pass1 = $this->input->post('pass1');
            $pass2 = $this->input->post('pass2');
            $group = $this->input->post('grup');
            
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('nama', 'Nama', 'required');
            $this->form_validation->set_rules('user', 'Username', 'trim|required|min_length[4]');
            $this->form_validation->set_rules('pass1', 'Password', 'trim|required|min_length[5]|matches[pass2]');
            $this->form_validation->set_rules('pass2', 'Ulang Password', 'trim|required|min_length[5]');
            $this->form_validation->set_rules('grup', 'Grup Pengguna', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'nama'   => form_error('nama'),
                    'user'   => form_error('user'),
                    'pass1'  => form_error('pass1'),
                    'pass2'  => form_error('pass2'),
                    'grup'   => form_error('grup'),
                );
                
                $has_error = array(
                    'nama'   => 'has-error',
                    'user'   => 'has-error',
                    'pass1'  => 'has-error',
                    'pass2'  => 'has-error',
                );
                
                $this->session->set_flashdata('form_error', $msg_error);
                $this->session->set_flashdata('has_error', $has_error);

                $this->session->set_flashdata('nama', $nama);
                $this->session->set_flashdata('user', $user);
                redirect('page=pengaturan&act=user_list');
            }else{
                $cek         = $this->ion_auth->username_check($user);
                
                if($cek == TRUE) {
                    $this->session->set_flashdata('pengaturan', '<div class="alert alert-danger">Username tidak bisa digunakan / sudah ada !!</div>');
                    redirect('page=pengaturan&act=user_list');
                } else {
                    $data_user = array(
                        'first_name' => $nama,
                    );
                    $this->ion_auth->register($user, $pass2, 'admin@admin.com', $data_user, array($group));
                    $this->session->set_flashdata('pengaturan', '<div class="alert alert-success">Username berhasil disimpan !!</div>');
                    redirect('page=pengaturan&act=user_list');
                }
            }
        } else {
             $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }   

    public function set_cari_user() {
        if (akses::aksesLogin() == TRUE) {
            $kueri   = $this->input->post('pencarian');
            
            $sql = $this->db->like('username', $kueri)
                            ->or_like('first_name', $kueri)
                            ->or_like('email', $kueri)
                            ->get('tbl_ion_users')->num_rows();

            redirect(base_url('pengaturan/data_user_list.php'.(!empty($kueri) ? '?kueri='.$kueri.'&jml='.$sql : '')));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function set_cari_cabang() {
        if (akses::aksesLogin() == TRUE) {
            $kueri   = $this->input->post('pencarian');
            
            $sql = $this->db->like('keterangan', $kueri)
                            ->get('tbl_pengaturan_cabang')->num_rows();

            redirect(base_url('pengaturan/data_cabang_list.php'.(!empty($kueri) ? '?kueri='.$kueri.'&jml='.$sql : '')));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
}
