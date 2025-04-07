<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
/**
 * Description of transaksi
 * 
 * Modified by : 
 *      Mikhael Felian Waskito - mikhaelfelian@gmail.com
 *      2025-03-14
 * github mikhaelfelian
 */
class Pos extends CI_Controller {
    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->library('cart');
        $this->load->library('Excel');
        $this->load->library('qrcode/ciqrcode');
    }
    
    public function index() {
        if (akses::aksesLogin() == TRUE) {
            /* Blok pagination */
            $data['cetak']      = '<button type="button" onclick="window.location.href = \''.base_url('transaksi/cetak_data_penj.php?'.(!empty($nt) ? 'filter_nota='.$nt : '').(!empty($tg) ? '&filter_tgl='.$tg : '').(!empty($tp) ? '&filter_tgl_tempo='.$tp : '').(!empty($cs) ? '&filter_cust='.$cs : '').(!empty($sl) ? '&filter_sales='.$sl : '').(!empty($jml) ? '&jml='.$jml : '')).'\'" class="btn btn-warning"><i class="fa fa-print"></i> Cetak</button>';
            /* --End Blok pagination-- */
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/trans/jual/sidebar_jual';
            /* --- Sidebar Menu --- */
            
            /* Load view tampilan */
            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/trans/jual/index', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_pelanggan_tambah() {
        if (akses::aksesLogin() == TRUE) {                   
            $id         = $this->input->get('id');
            $id_produk  = $this->input->get('item_id');
            $status     = $this->input->get('status');
            $userid     = $this->ion_auth->user()->row()->id;
            
            $sess_jual  = $this->session->userdata('trans_jual_umum');
            
            $data['gelar']          = $this->db->get('tbl_m_gelar')->result();
            $data['kerja']          = $this->db->get('tbl_m_jenis_kerja')->result();

            if(!empty($sess_jual)){
                $data['setting']      = $this->db->get('tbl_pengaturan')->row();
                $data['sql_medc']     = $this->db->where('id', general::dekrip($id))->get('tbl_trans_medcheck')->row();
                $data['sql_medc_det'] = $this->db->select('tbl_trans_medcheck_det.id, tbl_trans_medcheck_det.id_medcheck, tbl_trans_medcheck_det.id_item_kat, tbl_m_kategori.keterangan, tbl_m_kategori.kategori')->join('tbl_m_kategori', 'tbl_m_kategori.id=tbl_trans_medcheck_det.id_item_kat')->where('tbl_trans_medcheck_det.id_medcheck', general::dekrip($id))->group_by('tbl_trans_medcheck_det.id_item_kat')->get('tbl_trans_medcheck_det')->result();             
                $data['sql_produk']   = $this->db->where('id', general::dekrip($id_produk))->get('tbl_m_produk')->row();
                $data['sql_satuan']   = $this->db->get('tbl_m_satuan')->result();
                $data['sql_pelanggan']= $this->db->where('id', $sess_jual['id_pelanggan'])->get('tbl_m_pasien')->row();               
                $data['sql_platform'] = $this->db->order_by('id', 'asc')->get('tbl_m_platform')->result();                
            }
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/trans/jual/sidebar_jual';
            /* --- Sidebar Menu --- */

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/trans/jual/data_pelanggan_tambah', $data);
            $this->load->view('admin-lte-3/5_footer',$data);
            $this->load->view('admin-lte-3/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function trans_jual() {
        if (akses::aksesLogin() == TRUE) {                   
            $id         = $this->input->get('id');
            $id_produk  = $this->input->get('item_id');
            $status     = $this->input->get('status');
            $userid     = $this->ion_auth->user()->row()->id;
            
            $sess_jual  = $this->session->userdata('trans_jual_umum');

            if(!empty($sess_jual)){
                $data['setting']      = $this->db->get('tbl_pengaturan')->row();
                $data['sql_medc']     = $this->db->where('id', general::dekrip($id))->get('tbl_trans_medcheck')->row();
                $data['sql_medc_det'] = $this->db->select('tbl_trans_medcheck_det.id, tbl_trans_medcheck_det.id_medcheck, tbl_trans_medcheck_det.id_item_kat, tbl_m_kategori.keterangan, tbl_m_kategori.kategori')->join('tbl_m_kategori', 'tbl_m_kategori.id=tbl_trans_medcheck_det.id_item_kat')->where('tbl_trans_medcheck_det.id_medcheck', general::dekrip($id))->group_by('tbl_trans_medcheck_det.id_item_kat')->get('tbl_trans_medcheck_det')->result();             
                $data['sql_produk']   = $this->db->where('id', general::dekrip($id_produk))->get('tbl_m_produk')->row();
                $data['sql_satuan']   = $this->db->get('tbl_m_satuan')->result();
                $data['sql_pelanggan']= $this->db->where('id', $sess_jual['id_pelanggan'])->get('tbl_m_pasien')->row();               
                $data['sql_platform'] = $this->db->order_by('id', 'asc')->get('tbl_m_platform')->result();                
            }
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/trans/jual/sidebar_jual';
            /* --- Sidebar Menu --- */

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/trans/jual/trans_jual', $data);
            $this->load->view('admin-lte-3/5_footer',$data);
            $this->load->view('admin-lte-3/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
        
    public function trans_jual_invoice() {
        if (akses::aksesLogin() == TRUE) {                   
            $id                   = $this->input->get('id');
            $id_produk            = $this->input->get('id_produk');
            $status               = $this->input->get('status');
            $userid               = $this->ion_auth->user()->row()->id;

            if(!empty($id)){
                $data['setting']        = $this->db->get('tbl_pengaturan')->row();
                $data['sql_produk']     = $this->db->where('id', general::dekrip($id_produk))->get('tbl_m_produk')->row();
                $data['sql_medc']       = $this->db->where('id', general::dekrip($id))->get('tbl_trans_medcheck')->row();
                $data['sql_medc_det']   = $this->db->where('id_medcheck', general::dekrip($id))->group_by('id_item_kat')->get('tbl_trans_medcheck_det')->result();            
                $data['sql_medc_sum']   = $this->db->select('SUM(diskon) AS diskon, SUM(potongan) AS potongan, SUM(subtotal) AS subtotal')->where('id_medcheck', $data['sql_medc']->id)->get('tbl_trans_medcheck_det')->row();            
                $data['sql_medc_plat']  = $this->db->where('id_medcheck', general::dekrip($id))->get('tbl_trans_medcheck_plat')->result();            
                $data['sql_pasien']     = $this->db->where('id', $data['sql_medc']->id_pasien)->get('tbl_m_pasien')->row();
                $data['sql_dokter']     = $this->db->where('id', $data['sql_medc']->id_dokter)->get('tbl_m_karyawan')->row();
                $data['sql_poli']       = $this->db->where('id', $data['sql_medc']->id_poli)->get('tbl_m_poli')->row();
                $data['sql_platform']   = $this->db->get('tbl_m_platform')->result();             
            }

            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/trans/jual/sidebar_jual';
            /* --- Sidebar Menu --- */

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/trans/jual/trans_jual_inv', $data);
            $this->load->view('admin-lte-3/5_footer',$data);
            $this->load->view('admin-lte-3/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function trans_jual_invoice_print_dm() {
        if (akses::aksesLogin() == TRUE) {                   
            $id                   = $this->input->get('id');
            $id_produk            = $this->input->get('id_produk');
            $status               = $this->input->get('status');
            $userid               = $this->ion_auth->user()->row()->id;

            if(!empty($id)){
                $data['setting']        = $this->db->get('tbl_pengaturan')->row();
                $data['sql_produk']     = $this->db->where('id', general::dekrip($id_produk))->get('tbl_m_produk')->row();
                $data['sql_medc']       = $this->db->where('id', general::dekrip($id))->get('tbl_trans_medcheck')->row();
                $data['sql_medc_sum']   = $this->db->select('SUM(diskon) AS diskon, SUM(potongan) AS potongan, SUM(potongan_poin) AS potongan_poin, SUM(subtotal) AS subtotal')->where('id_medcheck', $data['sql_medc']->id)->get('tbl_trans_medcheck_det')->row();            
                $data['sql_medc_det']   = $this->db->where('id_medcheck', general::dekrip($id))->group_by('id_item_kat')->get('tbl_trans_medcheck_det')->result();            
                $data['sql_medc_plat']  = $this->db->where('id_medcheck', general::dekrip($id))->get('tbl_trans_medcheck_plat')->result();
                $data['sql_pasien']     = $this->db->where('id', $data['sql_medc']->id_pasien)->get('tbl_m_pasien')->row();
                $data['sql_pasien_poin']= $this->db->where('id_pasien', $data['sql_medc']->id_pasien)->get('tbl_m_pasien_poin')->row();
                $data['sql_dokter']     = $this->db->where('id', $data['sql_medc']->id_dokter)->get('tbl_m_karyawan')->row();
                $data['sql_poli']       = $this->db->where('id', $data['sql_medc']->id_poli)->get('tbl_m_poli')->row();              
            }

            $this->load->view('admin-lte-3/includes/trans/jual/trans_jual_inv_print_dm', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
        
    public function trans_jual_list() {
        if (akses::aksesLogin() == TRUE) {
            /* -- Grup hak akses -- */
            $role        = $this->input->get('role');
            $tipe        = $this->input->get('tipe');
            $grup        = $this->ion_auth->get_users_groups()->row();
            $id_user     = $this->ion_auth->user()->row()->id;
            $id_grup     = $this->ion_auth->get_users_groups()->row();
            $id_dokter   = $this->ion_auth->get_users_groups()->row();
            $pengaturan  = $this->db->get('tbl_pengaturan')->row();

            /* -- Blok Filter -- */
            $hal     = $this->input->get('halaman');
            $id      = $this->input->get('id');
            $cs      = $this->input->get('filter_nama');
            $by      = $this->input->get('filter_bayar');
            $tp      = $this->input->get('filter_tipe');
            $tg      = $this->input->get('filter_tgl');
            $sp      = $this->input->get('filter_periksa');
            $jml     = $this->input->get('jml');
            
            # Jika User dokter, maka pilih rajal dan ranap
            $jml_sql = $this->db
                            ->where('status_pos', '1')
                            ->like('DATE(tgl_simpan)', $this->tanggalan->tgl_indo_sys($tg))
                            ->like('pasien', $cs)
                            ->like('status_bayar', $by)
                            ->order_by('id', 'desc')
                            ->get('tbl_trans_medcheck')->num_rows();

            if(!empty($jml)){
                $jml_hal = $jml;
            }else{
                $jml_hal = $jml_sql;
            }
            /* -- End Blok Filter -- */

            /* -- Form Error -- */
            $data['hasError']                = $this->session->flashdata('form_error');

            /* -- Blok Pagination -- */
            $config['base_url']              = base_url('pos/trans_jual_list.php?tipe=1'.(!empty($cs) ? '&filter_nama='.$cs : '').(!empty($tg) ? '&filter_tgl='.$tg : '').(!empty($tp) ? '&filter_tipe='.$tp : '').(!empty($sp) ? '&filter_periksa='.$sp : '').(isset($by) ? '&filter_bayar='.$by : '').(!empty($jml_hal) ? '&jml='.$jml_hal : ''));
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

            if (!empty($hal)) {
                $data['penj'] = $this->db
                                ->where('status_pos', '1')
                                ->like('DATE(tgl_simpan)', $this->tanggalan->tgl_indo_sys($tg))
                                ->like('pasien', $cs)
                                ->like('status_bayar', $by)
                                ->limit($config['per_page'], $hal)
                                ->order_by('id', 'desc')
                                ->get('tbl_trans_medcheck')->result();
            } else {
                $data['penj'] = $this->db
                                    ->where('status_pos', '1')
                                    ->like('DATE(tgl_simpan)', $this->tanggalan->tgl_indo_sys($tg))
                                    ->like('pasien', $cs)
                                    ->like('status_bayar', $by)
                                    ->limit($config['per_page'])
                                    ->order_by('id', 'desc')
                                    ->get('tbl_trans_medcheck')->result();
            }

            $this->pagination->initialize($config);

            /* Blok pagination */
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();
            /* --End Blok pagination-- */
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/trans/jual/sidebar_jual';
            /* --- Sidebar Menu --- */
            
            $data['pengaturan']     = $pengaturan;
               
            /* Load view tampilan */
            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/trans/jual/trans_jual_list', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();            
        }
    }
    
    public function set_pelanggan_simpan() {
        if (akses::aksesLogin() == TRUE) {
            $id_ant       = $this->input->post('id_ant');
            $id_pasien    = $this->input->post('id_pasien');
            $ant          = $this->input->post('antrian');
            $no_rm        = $this->input->post('no_rm');
            $nik_lama     = $this->input->post('nik_lama');
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
            
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('gelar', 'Gelar', 'required');
            $this->form_validation->set_rules('nama', 'Nama Pasien', 'required');
            $this->form_validation->set_rules('jns_klm', 'Jenis Kelamin', 'required');
            $this->form_validation->set_rules('alamat', 'Alamat', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = [
                    'gelar'     => form_error('gelar'),
                    'nama'      => form_error('nama'),
                    'jns_klm'   => form_error('jns_klm'),
                    'alamat'    => form_error('alamat'),
                ];

                // value data pasien
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

                $this->session->set_flashdata('form_error', $msg_error);
                $this->session->set_flashdata('apt_toast', 'toastr.error("Validasi form gagal, silahkan periksa kembali!");');
                redirect(base_url('pos/set_trans_jual.php'));
            } else {
                try {
                    $pengaturan = $this->db->get('tbl_pengaturan')->row();
                    $sql_cek    = $this->db->select_max('id')->get('tbl_m_pasien')->row();
                    $sql_glr    = $this->db->where('id', $gelar)->get('tbl_m_gelar')->row();
                    
                    $nomor      = $sql_cek->id + 1;
                    
                    # Config File Foto Pasien
                    $kode       = sprintf('%05d', $nomor);
                    $no_rm      = strtolower($pengaturan->kode_pasien).$kode;
                    $path       = 'file/pasien/'.$no_rm.'/';
                    
                    # Buat Folder Untuk Foto Pasien
                    if(!file_exists($path)){
                        mkdir($path, 0777, true);
                    }

                    $data_pas = [
                        'tgl_simpan'    => date('Y-m-d H:i:s'),
                        'tgl_modif'     => date('Y-m-d H:i:s'),
                        'id_gelar'      => (!empty($gelar) ? $gelar : 0),
                        'id_pekerjaan'  => (!empty($pekerjaan) ? $pekerjaan : 0),
                        'kode_dpn'      => $pengaturan->kode_pasien,
                        'kode'          => $kode,
                        'nik'           => $nik_baru,
                        'nama'          => $nama,
                        'nama_pgl'      => strtoupper($sql_glr->gelar . ' ' . $nama),
                        'tmp_lahir'     => $tmp_lahir,
                        'tgl_lahir'     => (!empty($tgl_lahir) ? $this->tanggalan->tgl_indo_sys($tgl_lahir) : '0000-00-00'),
                        'jns_klm'       => $jns_klm,
                        'no_hp'         => $no_hp,
                        'no_rmh'        => $no_rmh,
                        'alamat'        => (!empty($alamat) ? $alamat : ''),
                        'alamat_dom'    => (!empty($alamat_dom) ? $alamat_dom : ''),
                        'status'        => '1',
                        'status_pas'    => '2',
                        'sp'            => '0',
                    ];

                    # Transact SQL
                    $this->db->trans_begin();

                    # Simpan ke tabel pendaftaran
                    $this->db->insert('tbl_m_pasien', $data_pas);
                    $last_id = $this->db->insert_id();

                    # Transact SQL End
                    if ($this->db->trans_status() === FALSE) {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('apt_toast', 'toastr.error("Gagal menyimpan data pasien!");');
                    } else {
                        $this->db->trans_commit();
                        $this->session->set_flashdata('apt_toast', 'toastr.success("Data pasien berhasil disimpan!");');
                    }
                } catch (Exception $e) {
                    if ($this->db->trans_status() === TRUE) {
                        $this->db->trans_rollback();
                    }
                    $this->session->set_flashdata('apt_toast', 'toastr.error("Terjadi kesalahan: ' . $e->getMessage() . '");');
                }

                redirect(base_url('pos/set_trans_jual.php'));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('apt_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!");');
            redirect();
        }
    }
    
    public function set_trans_jual() {
        if (akses::aksesLogin() == TRUE) {
            $id_user    = $this->ion_auth->user()->row()->id;
            $sql_sales  = $this->db->where('id_user', $id_user)->get('tbl_m_karyawan')->row();

            $sql_rm     = $this->db->where('MONTH(tgl_simpan)', date('m'))
                                   ->where('YEAR(tgl_simpan)', date('Y'))
                                   ->get('tbl_trans_jual');
            $str_rm     = $sql_rm->num_rows() + 1;
            $no_rm      = 'P'.date('ymd').sprintf('%04d', $str_rm);

            $data = [
                'tgl_simpan'   => date('Y-m-d H:i:s'),
                'tgl_masuk'    => date('Y-m-d'),
                'tgl_keluar'   => date('Y-m-d'),
                'id_pelanggan' => $this->input->post('id_customer') ?: 21933,
                'id_sales'     => $sql_sales->id ?? 0,
                'id_user'      => $id_user,
                'status_ppn'   => 0,
            ];

            $this->session->set_userdata('trans_jual_umum', $data);
            redirect(base_url('pos/trans_jual.php?id='.general::enkrip($no_rm)));
        } else {
            $this->session->set_flashdata('apt_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!");');
            redirect();
        }
    }
    
    public function set_trans_jual_upd() {
        if (akses::aksesLogin() == TRUE) {
            $id         = $this->input->post('id');
            $tgl_masuk  = $this->input->post('tgl_masuk');
            $tgl_tempo  = $this->input->post('tgl_keluar');
            $plgn       = $this->input->post('id_pelanggan');
            $status_ppn = $this->input->post('status_ppn');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id_pelanggan', 'Pelanggan', 'required');
            $this->form_validation->set_rules('tgl_masuk', 'Tgl Faktur', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = [
                    'id_pelanggan'  => form_error('id_pelanggan'),
                    'tgl_masuk'     => form_error('tgl_masuk'),
                ];

                $this->session->set_flashdata('form_error', $msg_error);
                $this->session->set_flashdata('apt_toast', 'toastr.error("Validasi form gagal, silahkan periksa kembali!");');
                redirect(base_url('pos/trans_jual.php?id='.$id));
            } else {
                try {
                    // Get form ID and check for double submission
                    $form_id = $this->input->post('form_id');
                    if (check_form_submitted($form_id)) {
                        $this->session->set_flashdata('apt_toast', 'toastr.warning("Form sudah disubmit sebelumnya!");');
                        redirect(base_url('pos/trans_jual.php?id='.$id));
                        return;
                    }
                    
                    $tgl_msk = $this->tanggalan->tgl_indo_sys($tgl_masuk);
                    $tgl_klr = $this->tanggalan->tgl_indo_sys($tgl_tempo);
                    
                    // Get sales data for the current user
                    $sql_sales = $this->db->where('id_user', $this->ion_auth->user()->row()->id)->get('tbl_m_karyawan')->row();

                    $data = [
                        'tgl_simpan'   => date('Y-m-d H:i:s'),
                        'tgl_masuk'    => date('Y-m-d'),
                        'tgl_keluar'   => date('Y-m-d'),
                        'id_pelanggan' => (!empty($plgn) ? $plgn : 1),
                        'id_sales'     => (!empty($sql_sales->id) ? $sql_sales->id : 1),
                        'id_user'      => $this->ion_auth->user()->row()->id,
                        'status_ppn'   => 0,
                    ];
                    
                    $this->session->set_userdata('trans_jual_umum', $data);
                    $this->session->set_flashdata('apt_toast', 'toastr.success("Data pelanggan berhasil disimpan!");');
                    redirect(base_url('pos/trans_jual.php?id='.$id));
                } catch (Exception $e) {
                    $this->session->set_flashdata('apt_toast', 'toastr.error("Terjadi kesalahan: ' . $e->getMessage() . '");');
                    redirect(base_url('pos/trans_jual.php?id='.$id));
                }
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_trans_jual_batal() {
        if (akses::aksesLogin() == TRUE) {
            $id = $this->input->get('id');
            
            if(!empty($id)){
                $this->cart->destroy();
                $this->session->unset_userdata('trans_jual_umum');
            }
            
            $this->session->set_flashdata('apt_toast', 'toastr.success("Transaksi berhasil dibatalkan");');
            redirect(base_url('pos/index.php'));
        } else {
            $this->session->set_flashdata('apt_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_trans_jual_batal_posting(){
        if (akses::aksesLogin() == TRUE) {
            $id         = $this->input->post('id');
            $status     = $this->input->post('status');
            
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id', 'ID', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = [
                    'id' => form_error('id'),
                ];

                $this->session->set_flashdata('anamnesa', $msg_error);

                redirect(base_url('medcheck/tambah.php?id='.$id));
            } else {
                $sql_medc       = $this->db->where('id', general::dekrip($id))->get('tbl_trans_medcheck')->row();
                
                $sql_medc_det   = $this->db->select('SUM(potongan) AS potongan, SUM(diskon) AS diskon, SUM(subtotal) AS subtotal')->where('id_medcheck', $sql_medc->id)->get('tbl_trans_medcheck_det')->row();   
                $sql_medc_det2  = $this->db->where('id_medcheck', $sql_medc->id)->get('tbl_trans_medcheck_det')->result();
                
                // Check if sql_medc->id_pasien exists before querying
                $sql_poin = null;
                if (!empty($sql_medc->id_pasien)) {
                    $sql_poin = $this->db->where('id_pasien', $sql_medc->id_pasien)->get('tbl_m_pasien_poin')->row();
                }
                
                $pengaturan     = $this->db->get('tbl_pengaturan')->row();
                
                $jml_total      = $sql_medc_det->subtotal + $sql_medc_det->potongan + $sql_medc_det->diskon;
                
                try {
                    // Get form ID and check for double submission
                    $form_id = $this->input->post('form_id');
                    if (check_form_submitted($form_id)) {
                        throw new Exception('Detected double form submission. Please try again.');
                    }
                    
                    # Hitung ulang data poin
                    if ($sql_poin && $pengaturan && $pengaturan->jml_poin_nom > 0) {
                        $poin           = $jml_total / $pengaturan->jml_poin_nom;
                        $poin_sisa      = $sql_poin->jml_poin - floor($poin);
                        $poin_sisa_tot  = $poin_sisa * $pengaturan->jml_poin;

                        $data_poin = [
                            'tgl_modif'     => date('Y-m-d H:i:s'),
                            'jml_poin'      => floor($poin_sisa),
                            'jml_poin_nom'  => (float) $poin_sisa_tot,
                        ];
                    }

                    # Start transaction
                    $this->db->trans_begin();

                    if (isset($data_poin) && $sql_poin) {
                        $this->db->where('id', $sql_poin->id)->update('tbl_m_pasien_poin', $data_poin);
                    }

                    $data = [
                        'tgl_modif'         => date('Y-m-d H:i:s'),
                        'jml_total'         => $jml_total,
                        'jml_potongan'      => 0,
                        'jml_potongan_poin' => 0,
                        'jml_diskon'        => 0,
                        'diskon'            => 0,
                        'jml_subtotal'      => 0,
                        'jml_gtotal'        => 0,
                        'status'            => '2',
                    ];
                    
                    # Update data nota dll
                    $this->db->where('id', general::dekrip($id))->update('tbl_trans_medcheck', $data);           
                      
                    foreach ($sql_medc_det2 as $medc_det){
                          $sql_item = $this->db->where('id', $medc_det->id_item)->get('tbl_m_produk')->row();
                          if (!$sql_item) {
                              continue; // Skip if item not found
                          }
                          
                          $sql_item_ref = $this->db->where('id_produk', $sql_item->id)->get('tbl_m_produk_ref');   
                          $sql_satuan = null;
                          if (!empty($sql_item->id_satuan)) {
                              $sql_satuan = $this->db->where('id', $sql_item->id_satuan)->get('tbl_m_satuan')->row();
                          }
                          
                          $sql_gudang = $this->db->where('status', '1')->get('tbl_m_gudang')->row();    // Cek gudang aktif dari gudang utama
                          if (!$sql_gudang) {
                              throw new Exception("Gudang aktif tidak ditemukan");
                          }

                          # Item racikan kumpulkan dahulu disini
                          if(!empty($medc_det->resep)){                     
                              foreach (json_decode($medc_det->resep) as $rc){
                                  $sql_item_rc = $this->db->where('id', $rc->id_item)->get('tbl_m_produk')->row();
                                  if (!$sql_item_rc) {
                                      continue; // Skip if racikan item not found
                                  }
                                  
                                  $sql_gudang_stok_rc = $this->db->where('id_gudang', $sql_gudang->id)
                                                               ->where('id_produk', $sql_item_rc->id)
                                                               ->get('tbl_m_produk_stok')->row();
                                  
                                  if (!$sql_gudang_stok_rc) {
                                      continue; // Skip if stock not found
                                  }
                                  
                                  # Cek resep Item stockable atau tidak ? 
                                  if($sql_item_rc->status_subt == '1'){
                                      $jml_akhir_rc = $sql_item_rc->jml + $rc->jml;
                                      $jml_akhir_stk = $sql_gudang_stok_rc->jml + $rc->jml;
                                      
                                      $data_item_rc = [
                                          'tgl_modif'  => date('Y-m-d H:i:s'),
                                          'jml'        => ($jml_akhir_rc < 0 ? 0 : (int) $jml_akhir_rc)
                                      ];
                                      
                                      # Hapus ke tabel riwayat produk
                                      $this->db->where('id_penjualan', $sql_medc->id)
                                               ->where('id_produk', $sql_item_rc->id)
                                               ->delete('tbl_m_produk_hist');
                                  }
                              }
                          }                      
                          # -- END OF RACIKAN
                          
                          # Cek Item Produk non resep stockable
                          if($sql_item->status_subt == '1'){
                                $sql_gudang_stok = $this->db->where('id_gudang', $sql_gudang->id)
                                                          ->where('id_produk', $sql_item->id)
                                                          ->get('tbl_m_produk_stok')->row();
                                
                                if (!$sql_gudang_stok) {
                                    continue; // Skip if stock not found
                                }
                                
                                $jml_akhir = $sql_item->jml + $medc_det->jml;
                                $jml_akhir_stk = $sql_gudang_stok->jml + $medc_det->jml;
                                                    
                                $data_item = [
                                    'tgl_modif'  => date('Y-m-d H:i'),
                                    'jml'        => ($jml_akhir < 0 ? 0 : (int) $jml_akhir)
                                ];
                                                    
                                $data_item_stk = [
                                    'tgl_modif'  => date('Y-m-d H:i'),
                                    'jml'        => ($jml_akhir_stk < 0 ? 0 : (int) $jml_akhir_stk)
                                ];                            

                                # Hapus ke tabel riwayat produk
                                $this->db->where('id_penjualan', $sql_medc->id)
                                         ->where('id_produk', $sql_item->id)
                                         ->delete('tbl_m_produk_hist');
                          }                      
                          # -- END OF ITEM
                          
                          # Jika punya refrensi item, maka jabarkan dulu
                            if($sql_item_ref && $sql_item_ref->num_rows() > 0){
                                foreach ($sql_item_ref->result() as $reff){
                                    $sql_item_rf = $this->db->where('id', $reff->id_produk_item)->get('tbl_m_produk')->row();
                                    if (!$sql_item_rf) {
                                        continue; // Skip if reference item not found
                                    }
                                    
                                    $sql_gudang_stok = $this->db->where('id_gudang', $sql_gudang->id)
                                                              ->where('id_produk', $sql_item_rf->id)
                                                              ->get('tbl_m_produk_stok')->row();
                                  
                                    # Cek apakah stockable
                                    if($sql_item_rf->status_subt == '1'){
                                        $jml_akhir_reff = $sql_item_rf->jml + ($reff->jml * $medc_det->jml);
                                  
                                        $data_item_reff = [
                                            'tgl_modif'  => date('Y-m-d H:i:s'),
                                            'jml'        => $jml_akhir_reff
                                        ];
                                                                                                                
                                        # Balikin stok, untuk item referensinya jika statusnya stockable
                                        $this->db->where('id', $reff->id_produk_item)->update('tbl_m_produk', $data_item_reff);
                                        
                                        # Hapus te tabel riwayat produk
                                        $this->db->where('id_penjualan', $sql_medc->id)
                                                 ->where('id_produk', $sql_item_rf->id)
                                                 ->delete('tbl_m_produk_hist');
                                    }
                                }
                            }
                    }
                    
                    # Ambil data dari tabel trace
                    $sql_medc_stok = $this->db->where('id_medcheck', $sql_medc->id)->get('tbl_trans_medcheck_stok')->result();
                    
                    foreach ($sql_medc_stok as $stok){
                        $sql_gudang_stok = $this->db->where('id_gudang', $stok->id_gudang)
                                                  ->where('id_produk', $stok->id_item)
                                                  ->get('tbl_m_produk_stok')->row();
                        
                        if (!$sql_gudang_stok) {
                            continue; // Skip if stock not found
                        }
                        
                        $stok_akhir = $sql_gudang_stok->jml + $stok->jml;
                        
                        $data_stok = [
                            'tgl_modif' => date('Y-m-d H:i:s'),
                            'jml'       => $stok_akhir
                        ];
                        
                        # Simpan stok akhir ke tabel gudang
                        $this->db->where('id', $sql_gudang_stok->id)->update('tbl_m_produk_stok', $data_stok);
                        $stok_glob = $this->db->select_sum('jml')->where('id_produk', $stok->id_item)->get('tbl_m_produk_stok')->row();
                        
                        $data_stok_glob = [
                            'tgl_modif' => date('Y-m-d H:i:s'),
                            'jml'       => $stok_glob->jml
                        ];
                        
                        # Simpan stok akhir global ke tabel master item
                        $this->db->where('id', $stok->id_item)->update('tbl_m_produk', $data_stok_glob);
                    }
                    
                    # Hapus Platform Pembayaran
                    $this->db->where('id_medcheck', $sql_medc->id)->delete('tbl_trans_medcheck_plat');
                    
                    # Hapus catatan riwayat stok
                    $this->db->where('id_medcheck', $sql_medc->id)->delete('tbl_trans_medcheck_stok');
                    
                    # Hapus Nota penjualan
                    $this->db->where('id', $sql_medc->id)->delete('tbl_trans_medcheck');
                    
                    # Check transaction status
                    if ($this->db->trans_status() === FALSE) {
                        # Rollback transaction
                        $this->db->trans_rollback();
                        
                        $this->session->set_flashdata('apt_toast', 'toastr.error("Transaksi gagal di proses!!");');
                    } else {
                        # Commit transaction
                        $this->db->trans_commit();
                         
                        $this->session->set_flashdata('apt_toast', 'toastr.success("Transaksi berhasil di batalkan dan dihapus!!");');
                    }
                                        
                    redirect(base_url('pos/trans_jual_list.php'));                    
                } catch (Exception $e) {
                    // Rollback transaction if active
                    if ($this->db->trans_status() !== FALSE) {
                        $this->db->trans_rollback();
                    }
                    
                    $this->session->set_flashdata('apt_toast', 'toastr.error("Transaksi gagal: ' . $e->getMessage() . '");');
                    redirect(base_url('pos/trans_jual_list.php'));
                }
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_trans_jual_simpan_item() {
        if (akses::aksesLogin() == TRUE) {
            $id         = $this->input->post('id');
            $id_item    = $this->input->post('id_item');
            $hrg        = $this->input->post('harga');
            $jml        = $this->input->post('jml');
            $diskon1    = $this->input->post('disk1');
            $diskon2    = $this->input->post('disk2');
            $diskon3    = $this->input->post('disk3');
            $pot        = $this->input->post('potongan');
            $status     = $this->input->post('status');
            $act        = $this->input->post('act');
            
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id', 'ID', 'required');
            $this->form_validation->set_rules('id_item', 'Item', 'required');
            $this->form_validation->set_rules('harga', 'Harga', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = [
                    'id'        => form_error('id'),
                    'kode'      => form_error('id_item'),
                    'harga'     => form_error('harga')
                ];

                $this->session->set_flashdata('form_error', $msg_error);

                redirect(base_url('pos/trans_jual.php?id='.$id));
            } else {
                $sg             = $this->ion_auth->user()->row()->status_gudang;
                $sql_item       = $this->db->where('id', general::dekrip($id_item))->get('tbl_m_produk')->row();
                $sql_stok       = $this->db->where('id_produk', $sql_item->id)->where('id_gudang', $sg)->get('tbl_m_produk_stok')->row();
                $sql_sat        = $this->db->where('id', $sql_item->id_satuan)->get('tbl_m_satuan')->row();
                $harga          = general::format_angka_db($hrg);
                $potongan       = general::format_angka_db($pot);
                $jml            = general::format_angka_db($jml);
                $jml_pot        = $potongan * $jml;
                
                try {                    
                    // Get form ID and check for double submission
                    $form_id = $this->input->post('form_id');
                    if (check_form_submitted($form_id)) {
                        throw new Exception('Detected double form submission. Please try again.');
                    }

                    // Check if requested quantity is available in stock
                    if ($jml > $sql_stok->jml) {
                        throw new Exception('Stok tidak cukup. <b>Stok tersedia: </b>' . $sql_stok->jml . ', Permintaan: ' . $jml);
                    }

                    
                    $disk1          = $harga - (($diskon1 > 0 ? $diskon1 : 0) / 100) * $harga;
                    $disk2          = $disk1 - (($diskon2 > 0 ? $diskon2 : 0) / 100) * $disk1;
                    $disk3          = $disk2 - (($diskon3 > 0 ? $diskon3 : 0) / 100) * $disk2;
                    $diskon         = $harga - $disk3;
                    $tot_harga      = ($disk3 - $potongan);
                    $subtotal       = $harga * $jml;
                    
                    $keranjang = [
                        'id'      => $sql_item->id . random_int(8, 1024),
                        'qty'     => (int)$jml,
                        'price'   => general::format_angka_db($tot_harga),
                        'name'    => $sql_item->id,
                        'options' => [
                            'id_penjualan'  => general::dekrip($id),
                            'id_item'       => $sql_item->id,
                            'harga'         => (float)$harga,
                            'disk1'         => (float)$diskon1,
                            'disk2'         => (float)$diskon2,
                            'disk3'         => (float)$diskon3,
                            'diskon'        => (float)$diskon,
                            'potongan'      => (float)$potongan,
                            'subtotal'      => (float)$subtotal,
                        ]
                    ];
                    
                    $this->cart->insert($keranjang);
                    $this->session->set_flashdata('apt_toast', 'toastr.success("Item berhasil ditambahkan ke keranjang!");');
                    redirect(base_url('pos/trans_jual.php?id='.$id));
                } catch (Exception $e) {
                    $this->session->set_flashdata('apt_toast', 'toastr.error("Gagal menambahkan item: ' . $e->getMessage() . '");');
                    redirect(base_url('pos/trans_jual.php?id='.$id));
                }
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_trans_jual_hapus_item() {
        if (akses::aksesLogin() == TRUE) {
            $id         = $this->input->get('id');
            $id_item    = $this->input->get('item_id');
            $rute       = $this->input->get('route');

            if(!empty($id)){
                $cart = [
                    'rowid' => general::dekrip($id_item),
                    'qty'   => 0
                ];
                $this->cart->update($cart);
                $this->session->set_flashdata('apt_toast', 'toastr.success("Item berhasil dihapus dari keranjang!");');
            }

            redirect(base_url('pos/trans_jual.php?id='.$id));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('apt_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    

    
    public function set_trans_jual_proses() {
        if (akses::aksesLogin() == TRUE) {
            $id         = $this->input->post('id');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id', 'ID', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = [
                    'id'  => form_error('id'),
                ];

                $this->session->set_flashdata('form_error', $msg_error);
                $this->session->set_flashdata('apt_toast', 'toastr.error("Validasi form gagal, silahkan periksa kembali!");');

                redirect(base_url('pos/trans_jual.php?id='.$id));
            } else {
                $sess_medc      = $this->session->userdata('trans_jual_umum');
                $sess_medc_det  = $this->cart->contents();
                $sql_pas        = $this->db->where('id', $sess_medc['id_pelanggan'])->get('tbl_m_pasien')->row();
                
                # Generate RM number
                $sql_rm         = $this->db->where('MONTH(tgl_simpan)', date('m'))->where('YEAR(tgl_simpan)', date('Y'))->get('tbl_trans_medcheck');
                $str_rm         = $sql_rm->num_rows() + 1;
                $no_rm          = date('ymd').sprintf('%04d', $str_rm);
                
                # Generate account number - using MAX to avoid duplicates
                $sql_no         = $this->db->select_max('id')->get('tbl_trans_medcheck')->row();
                $nomor_id       = $sql_no->id + 1;
                $no_akun        = strtoupper(date('Mdy').sprintf('%04d', $nomor_id));
                
                # Generate invoice number - using MAX to avoid duplicates
                $sql_invoice    = $this->db->select_max('no_nota')->where('MONTH(tgl_simpan)', date('m'))->where('YEAR(tgl_simpan)', date('Y'))->get('tbl_trans_medcheck')->row();
                $no_nota        = (!empty($sql_invoice->no_nota) ? (int)$sql_invoice->no_nota + 1 : 1);
                $no_nota        = 'INV/'.date('Y').'/'.date('m').'/'.sprintf('%05d', $no_nota);
                
                // Check if form is submitted to prevent duplicate submissions
                if (check_form_submitted('trans_jual_proses_form')) {
                    $this->session->set_flashdata('apt_toast', 'toastr.warning("Form sudah disubmit sebelumnya!");');
                    redirect(base_url('pos/trans_jual.php?id='.$id));
                }
                
                // Set cache lock to prevent concurrent processing
                $lock_key = 'trans_jual_lock_' . $this->ion_auth->user()->row()->id;
                
                // Check if cache library is loaded
                if (!isset($this->cache)) {
                    $this->load->driver('cache', array('adapter' => 'file'));
                }
                
                if ($this->cache->get($lock_key)) {
                    $this->session->set_flashdata('apt_toast', 'toastr.error("Another transaction is being processed!");');
                    redirect(base_url('pos/trans_jual.php?id='.$id));
                }
                
                // Set lock for 30 seconds
                $this->cache->save($lock_key, true, 30);
                
                try {
                    $sess_medc      = $this->session->userdata('trans_jual_umum');
                    $sess_medc_det  = $this->cart->contents();
                    $sql_pas        = $this->db->where('id', $sess_medc['id_pelanggan'])->get('tbl_m_pasien')->row();
                    
                    $sql_rm         = $this->db->where('MONTH(tgl_simpan)', date('m'))->where('YEAR(tgl_simpan)', date('Y'))->get('tbl_trans_medcheck');
                    $str_rm         = $sql_rm->num_rows() + 1;
                    $no_rm          = date('ymd').sprintf('%04d', $str_rm);
                    
                    # No Akun
                    $sql_no         = $this->db->select_max('id')->get('tbl_trans_medcheck')->row();
                    $sql_akun       = $this->db->select('COUNT(id) AS jml')->where('DATE(tgl_simpan)', date('Y-m-d'))->get('tbl_trans_medcheck')->row();
                    $str_akun       = $sql_akun->jml + 1;
                    $no_akun        = strtoupper(date('Mdy').sprintf('%04d', $str_akun));
                    $nomor_id       = $sql_no->id + 1;
                    
                    # No Nota
                    $nomer          = $this->db->where('MONTH(tgl_simpan)', date('m'))->where('YEAR(tgl_simpan)', date('Y'))->get('tbl_trans_medcheck')->num_rows();
                    $no_nota        = (int)$nomer + 1;
                    $no_nota        = 'INV/'.date('Y').'/'.date('m').'/'.sprintf('%05d', $no_nota);
                    $uuid           = $this->uuid->v4();

                    $data = [
                        'uuid'         => $uuid,
                        'id_user'      => $this->ion_auth->user()->row()->id,
                        'id_pasien'    => (!empty($sess_medc['id_pelanggan']) ? $sess_medc['id_pelanggan'] : '0'),
                        'id_poli'      => '5',
                        'tgl_simpan'   => date('Y-m-d H:i:s'),
                        'tgl_masuk'    => date('Y-m-d H:i:s'),
                        'pasien'       => $sql_pas->nama_pgl,
                        'no_rm'        => $no_rm,
                        'no_akun'      => $no_akun,
                        'no_nota'      => $no_nota,
                        'tipe'          => '6',
                        'tipe_bayar'    => '1',
                        'status'        => '5',
                        'status_pos'    => '1',
                        'status_nota'   => '1',
                    ];
                    
                    /* Transaksi Database */
                    $this->db->query('SET autocommit = 0;');
                    $this->db->trans_start();
        
                    # Masukkan ke tabel medcheck
                    $this->db->insert('tbl_trans_medcheck', $data);
                    $last_id = crud::last_id();
                    
                    foreach ($sess_medc_det as $cart){
                        $sql_item        = $this->db->where('id', $cart['options']['id_item'])->get('tbl_m_produk')->row();
                        $sql_satuan      = $this->db->where('id', $sql_item->id_satuan)->get('tbl_m_satuan')->row();
                        $sql_gudang      = $this->db->where('status', '1')->get('tbl_m_gudang')->row(); 
                        $sql_gudang_stok = $this->db->where('id_gudang', $sql_gudang->id)->where('id_produk', $sql_item->id)->get('tbl_m_produk_stok')->row();
                        $jml_akhir       = $sql_item->jml - $cart['qty'];
                        $jml_akhir_stk   = $sql_gudang_stok->jml - $cart['qty'];
                        
                        // Check if stock is sufficient
                        if ($jml_akhir_stk < 0) {
                            $this->db->trans_rollback();
                            throw new Exception("Stok tidak mencukupi untuk item ".$sql_item->produk.". Stok tersedia: ".$sql_gudang_stok->jml);
                        }
                        
                        $data_cart = [
                            'id_medcheck'   => (int)$last_id,
                            'id_item'       => (int)$sql_item->id,
                            'id_item_kat'   => (int)$sql_item->id_kategori,
                            'id_item_sat'   => (int)$sql_item->id_satuan,
                            'id_user'       => $this->ion_auth->user()->row()->id,
                            'tgl_simpan'    => date('Y-m-d H:i:s'),
                            'tgl_modif'     => date('Y-m-d H:i:s'),
                            'kode'          => $sql_item->kode,
                            'item'          => $sql_item->produk,
                            'harga'         => $cart['options']['harga'],
                            'jml'           => (int)$cart['qty'],
                            'jml_satuan'    => '1',
                            'satuan'        => $sql_satuan->satuanTerkecil,
                            'disk1'         => $cart['options']['disk1'],
                            'disk2'         => $cart['options']['disk2'],
                            'disk3'         => $cart['options']['disk3'],
                            'diskon'        => $cart['options']['diskon'],
                            'potongan'      => $cart['options']['potongan'],
                            'subtotal'      => $cart['options']['subtotal'],
                            'status'        => (int)$sql_item->status
                        ];
                        
                        # Masukkan ke tabel medcheck det
                        $this->db->insert('tbl_trans_medcheck_det', $data_cart);
                        $last_id_det = crud::last_id();
                        
                        $data_stok_trace = [
                              'tgl_simpan'        => date('Y-m-d H:i:s'),
                              'tgl_masuk'         => date('Y-m-d H:i:s'),
                              'id_medcheck'       => $last_id,
                              'id_medcheck_det'   => $last_id_det, 
                              'id_gudang'         => $sql_gudang->id, 
                              'id_item'           => $sql_item->id, 
                              'item'              => $sql_item->produk, 
                              'stok_awal'         => $sql_gudang_stok->jml, 
                              'jml'               => (int)$cart['qty'], 
                              'stok_akhir'        => $jml_akhir_stk, 
                        ];
                        
                        # Masukkan ke tabel medcheck trace
                        $this->db->insert('tbl_trans_medcheck_stok', $data_stok_trace);
                        
                        $data_penj_hist = [
                            'tgl_simpan'    => date('Y-m-d H:i:s'),
                            'tgl_masuk'     => date('Y-m-d H:i:s'),
                            'id_gudang'     => $sql_gudang->id,
                            'id_pelanggan'  => $sess_medc['id_pelanggan'],
                            'id_produk'     => $sql_item->id,
                            'id_user'       => $this->ion_auth->user()->row()->id,
                            'id_penjualan'  => $last_id,
                            'no_nota'       => $no_nota,
                            'kode'          => $sql_item->kode,
                            'produk'        => $sql_item->produk,
                            'keterangan'    => $sql_pas->nama.' - Penjualan Apotik',
                            'jml'           => (int)$cart['qty'],
                            'jml_satuan'    => (int)$sql_satuan->jml,
                            'satuan'        => $sql_satuan->satuanTerkecil,
                            'nominal'       => (float)$cart['options']['harga'],
                            'status'        => '4'
                        ];
                        
                        # Masukkan ke tabel hist produk
                        $this->db->insert('tbl_m_produk_hist', $data_penj_hist);
                    }
                    
                    # Setelah semua proses tersimpan, saat nya mengurangi stok
                    # Ambil data dari tabel tracer stok sementara
                    $sql_medc_stok = $this->db->where('id_medcheck', $last_id)->get('tbl_trans_medcheck_stok')->result();
                    
                    foreach ($sql_medc_stok as $stok){
                        # Ambil data stok dari item dari gudang dan item terkait
                        $sql_gudang_stok    = $this->db->where('id_gudang', $stok->id_gudang)->where('id_produk', $stok->id_item)->get('tbl_m_produk_stok')->row();
                            
                        # Hitung ulang secara live, stok saat ini dikurangi stok yang keluar
                        $stok_akhir         = $sql_gudang_stok->jml - $stok->jml;
                        
                        # Kumpulkan informasi pengurangan stok disini
                        $data_stok = [
                            'tgl_modif' => date('Y-m-d H:i:s'),
                            'jml'       => $stok_akhir
                        ];
                        
                        # Simpan stok akhir ke tabel gudang,update stok nya
                        $this->db->where('id', $sql_gudang_stok->id)->update('tbl_m_produk_stok', $data_stok);
                        
                        # Kumpulkan informasi pengurangan stok pada tabel tracer stok disini
                        $data_stok_trace = [
                            'stok_awal'     => $sql_gudang_stok->jml,
                            'stok_akhir'    => $stok_akhir
                        ];
                        
                        # Update pada tabel tracer stok nya
                        $this->db->where('id', $stok->id)->update('tbl_trans_medcheck_stok', $data_stok_trace);
                        
                        # Sinkronkan stok atas dan bawah, kemudian jumlahkan dengan sum dan catat sementara
                        $stok_glob = $this->db->select_sum('jml')->where('id_produk', $stok->id_item)->get('tbl_m_produk_stok')->row();
                        
                        # Stok atas bawah yang sinkron, catat disini
                        $data_stok_glob = [
                            'tgl_modif' => date('Y-m-d H:i:s'),
                            'jml'       => $stok_glob->jml
                        ];
                        
                        # Simpan stok akhir global ke tabel master item utama
                        $this->db->where('id', $stok->id_item)->update('tbl_m_produk', $data_stok_glob);
                    }
                    
                    # Update jumlah total, dll
                    $sql_medc_det   = $this->db->select('SUM(potongan) AS potongan, SUM(diskon) AS diskon, SUM(subtotal) AS subtotal')->where('id_medcheck', $last_id)->get('tbl_trans_medcheck_det')->row();   
                    
                    $jml_total      = $sql_medc_det->subtotal + $sql_medc_det->potongan + $sql_medc_det->diskon;
                    $jml_pot        = $sql_medc_det->potongan;
                    $jml_diskon     = $sql_medc_det->diskon;
                    $diskon         = ($jml_diskon / $jml_total) * 100;
                    $jml_subtotal   = $sql_medc_det->subtotal;
                    $ppn            = $pengaturan->ppn;
                    $jml_ppn        = $pengaturan->ppn;
                    $jml_gtotal     = ceil($sql_medc_det->subtotal);
                    
                    $data_total = [
                        'tgl_modif'     => date('Y-m-d H:i:s'),
                        'jml_total'     => (float)$jml_total,
                        'jml_diskon'    => (float)$jml_diskon,
                        'diskon'        => ($diskon > 1 ? (float)round($diskon, 2) : '0'),
                        'jml_potongan'  => (float)$jml_pot,
                        'jml_subtotal'  => (float)$jml_subtotal,
                        'jml_gtotal'    => (float)$jml_subtotal,
                        'status'        => '5',
                    ];
                    
                    $this->db->where('id', $last_id)->update('tbl_trans_medcheck', $data_total);
    
                    # Complete transaction
                    $this->db->trans_complete();
                    
                    # Check transaction status
                    if ($this->db->trans_status() === FALSE) {
                        throw new Exception("Database transaction failed");
                    }
    
                    # Hapus session
                    $this->cart->destroy();
                    $this->session->unset_userdata('trans_jual_umum');
    
                    $this->session->set_flashdata('apt_toast', 'toastr.success("Transaksi sudah dikirim ke kasir!");');
                    
                    // Release lock
                    $this->cache->delete($lock_key);
                    
                    redirect(base_url('pos/trans_jual_list.php'));
                    
                } catch (Exception $e) {
                    // Rollback transaction
                    $this->db->trans_rollback();
                    
                    // Release lock
                    $this->cache->delete($lock_key);
                    // Show error message
                    $this->session->set_flashdata('apt_toast', 'toastr.error("Data Medical Checkup gagal disimpan: ' . $e->getMessage() . '");');
                    redirect(base_url('pos/trans_jual.php?id='.$id));
                }
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('apt_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!");');
            redirect();
        }
    }
    

    public function set_trans_jual_cari() {
        if (akses::aksesLogin() == TRUE) {
            $id         = $this->input->post('id_medcheck');
            $nama       = $this->input->post('pasien');
            $tipe       = $this->input->post('tipe');
            $tgl        = $this->input->post('tgl');
            $status_byr = $this->input->post('status_bayar');

            $sql        = $this->db
                               ->where('status_pos', '1')
                               ->like('DATE(tgl_masuk)', $this->tanggalan->tgl_indo_sys($tgl))
                               ->like('pasien', $nama)
                               ->like('status_bayar', $status_byr)
                               ->get('v_medcheck');
            
            $sql_row    = $sql->row();
            $sql_jml    = $sql->num_rows();
            
            redirect(base_url('pos/trans_jual_list.php?tipe=1'.(!empty($nama) ? '&filter_nama='.$nama : '').(!empty($id) ? '&id='.general::enkrip($id) : '').(!empty($tgl) ? '&filter_tgl='.$this->tanggalan->tgl_indo_sys($tgl) : '').(isset($status_byr) ? '&filter_bayar='.$status_byr : '')));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    
    public function json_customer() {
        if (akses::aksesLogin() == TRUE) {
            $term  = $this->input->get('term');
            $sql   = $this->db->select('id, kode, kode_dpn, nik, nama_pgl, nama, alamat, jns_klm, tgl_lahir')
                              ->like('nama',$term)
                              ->or_like('nik',$term)
                              ->or_like('alamat',$term)
                              ->limit(200)->get('tbl_m_pasien')->result();
            
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
    
    
    public function json_item() {
        if (akses::aksesLogin() == TRUE) {
            $term  = $this->input->get('term');
            $stat  = $this->input->get('status');
            $page  = $this->input->get('page');
            $sg    = $this->ion_auth->user()->row()->status_gudang;            

            $sql = $this->db->select('tbl_m_produk.id, tbl_m_produk.id_satuan, tbl_m_produk.kode, tbl_m_produk.produk, tbl_m_produk.produk_alias, tbl_m_produk.produk_kand, tbl_m_produk.jml, tbl_m_produk.harga_jual, tbl_m_produk.harga_beli, tbl_m_produk.harga_beli, tbl_m_produk.status_brg_dep')
                            ->where("(tbl_m_produk.produk LIKE '%" . $term . "%' OR tbl_m_produk.produk_alias LIKE '%" . $term . "%' OR tbl_m_produk.produk_kand LIKE '%" . $term . "%' OR tbl_m_produk.kode LIKE '%" . $term . "%' OR tbl_m_produk.barcode LIKE '" . $term . "')")
                            ->where('tbl_m_produk.status_subt', '1')
                            ->order_by('tbl_m_produk.jml', ($_GET['mod'] == 'beli' ? 'asc' : 'desc'))
                            ->get('tbl_m_produk')->result();

            if(!empty($sql)){
                $produk = [];
                foreach ($sql as $sql){
                    $sql_satuan = $this->db->where('id', $sql->id_satuan)->get('tbl_m_satuan')->row();
                    $sql_stok   = $this->db->select('SUM(jml * jml_satuan) AS jml')->where('id_produk', $sql->id)->where('id_gudang', $sg)->get('tbl_m_produk_stok')->row();
                    
                    // Only add products with stock greater than 0
                    if ($sql_stok->jml > 0) {
                        $produk[] = [
                            'id'            => general::enkrip($sql->id),
                            'kode'          => $sql->kode,
                            'name'          => $sql->produk,
                            'alias'         => (!empty($sql->produk_alias) ? $sql->produk_alias : ''),
                            'kandungan'     => (!empty($sql->produk_kand) ? '('.strtolower($sql->produk_kand).')' : ''),
                            'jml'           => $sql_stok->jml.' '.$sql_satuan->satuanTerkecil,
                            'satuan'        => $sql_satuan->satuanTerkecil,
                            'harga'         => (float)$sql->harga_jual,
                            'harga_beli'    => (float)$sql->harga_beli,
                            'harga_grosir'  => (float)$sql->harga_grosir,
                        ];
                    }
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
