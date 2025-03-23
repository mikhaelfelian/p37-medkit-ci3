<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
/**
 * Description of master
 *
 * @author USER
 */

class master extends CI_Controller {
    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->library('Excel');
        $this->load->library('qrcode/ciqrcode');
    }
    
    public function index() {
        if (Akses::aksesLogin() == TRUE) {
            /* -- Grup hak akses -- */
            $role        = $this->input->get('role');
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
            $tb      = $this->input->get('filter_tgl_bayar');
            $tp      = $this->input->get('filter_tgl_tempo');
            $lk      = $this->input->get('filter_lokasi');
            $cs      = $this->input->get('filter_cust');
            $sn      = $this->input->get('filter_status');
            $sl      = $this->input->get('filter_sales');
            $stts    = $this->input->get('status');
            $jml     = $this->input->get('jml');
//            $jml_sql = ($id_grup->name == 'superadmin' || $id_grup->name == 'owner' || $id_grup->name == 'admin' ? $this->db->get('tbl_trans_jual')->num_rows() : $this->db->where('id_user', $id_user)->where('tgl_masuk', date('Y-m-d'))->get('tbl_trans_jual')->num_rows());

            if(!empty($jml)){
                $jml_hal = $jml;
            }else{
                $jml_hal = $this->db->select('id, id_app, no_nota, kode_nota_dpn, kode_nota_blk, kode_nota_dpn, kode_nota_blk, DATE(tgl_masuk) as tgl_masuk, DATE(tgl_bayar) as tgl_bayar, DATE(tgl_keluar) as tgl_keluar, jml_total, jml_gtotal, ppn, jml_ppn, id_user, id_sales, id_pelanggan, status_nota, status_bayar, status_grosir')
                                ->where('status_nota !=', '4')
                                ->where('status', $stts)
                                ->like('no_nota', $fn[0])
                                ->like('DATE(tgl_bayar)', $tb)
                                ->like('DATE(tgl_keluar)', $tp)
                                ->like('id_pelanggan', $cs)
                                ->like('id_sales', $sl)
                                ->like('id_user', ($id_grup->name == 'superadmin' || $id_grup->name == 'owner' || $id_grup->name == 'admin' ? '' : $id_user), ($id_grup->name == 'superadmin' || $id_grup->name == 'owner' || $id_grup->name == 'adminm' || $id_grup->name == 'admin' ? '' : 'none'))
                                ->like('tgl_masuk', ($id_grup->name == 'superadmin' || $id_grup->name == 'owner' || $id_grup->name == 'adminm' || $id_grup->name == 'admin' ? '' : date('Y-m-d')))
                                ->order_by('tgl_simpan','desc')
                                ->get('tbl_trans_jual')->num_rows();
            }
            /* -- End Blok Filter -- */

            /* -- Form Error -- */
            $data['hasError']                = $this->session->flashdata('form_error');

            /* -- Blok Pagination -- */
            $config['base_url']              = base_url('transaksi/data_penj_list.php?filter_nota='.$nt.'&filter_tgl='.$tg.'&filter_sales='.$sl.'&filter_status='.$sn.'&jml='.$jml);
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
                   $data['penj'] = $this->db->select('id, id_app, no_nota, kode_nota_dpn, kode_nota_blk, kode_nota_dpn, kode_nota_blk, DATE(tgl_masuk) as tgl_masuk, DATE(tgl_bayar) as tgl_bayar, DATE(tgl_keluar) as tgl_keluar, jml_total, jml_gtotal, ppn, jml_ppn, id_user, id_sales, id_pelanggan, status_nota, status_bayar, status_grosir')
//                           ->where('status_nota !=', '4')
//                           ->where('status', $stts)
                           ->limit($config['per_page'],$hal)
                           ->like('no_nota', $fn[0])
                           ->like('DATE(tgl_bayar)', $tb)
                           ->like('DATE(tgl_keluar)', $tp)
                           ->like('id_pelanggan', $cs)
                           ->like('id_sales', $sl)
                           ->like('id_user', ($id_grup->name == 'superadmin' || $id_grup->name == 'owner' || $id_grup->name == 'admin' ? '' : $id_user))
                           ->like('tgl_masuk', ($id_grup->name == 'superadmin' || $id_grup->name == 'owner' || $id_grup->name == 'adminm' || $id_grup->name == 'admin' ? $tg : date('Y-m-d')))
                           ->order_by('tgl_simpan','desc')
                           ->get('tbl_trans_jual')->result();
            }else{
                   $data['penj'] = $this->db->select('id, id_app, no_nota, kode_nota_dpn, kode_nota_blk, kode_nota_dpn, kode_nota_blk, DATE(tgl_masuk) as tgl_masuk, DATE(tgl_bayar) as tgl_bayar, DATE(tgl_keluar) as tgl_keluar, jml_total, jml_gtotal, ppn, jml_ppn, id_user, id_sales, id_pelanggan, status_nota, status_bayar, status_grosir')
//                           ->where('status_nota !=', '4')
//                           ->where('status', $stts)
                           ->limit($config['per_page'])
                           ->like('no_nota', $fn[0])
                           ->like('DATE(tgl_bayar)', $tb)
                           ->like('DATE(tgl_keluar)', $tp)
                           ->like('id_pelanggan', $cs)
                           ->like('id_sales', $sl)
                           ->like('id_user', ($id_grup->name == 'superadmin' || $id_grup->name == 'owner' || $id_grup->name == 'adminm' || $id_grup->name == 'admin' ? '' : $id_user))
                           ->like('tgl_masuk', ($id_grup->name == 'superadmin' || $id_grup->name == 'owner' || $id_grup->name == 'adminm' || $id_grup->name == 'admin' ? $tg : date('Y-m-d')))
                           ->order_by('tgl_simpan','desc')
                           ->get('tbl_trans_jual')->result();
            }

            $this->pagination->initialize($config);

            /* Blok pagination */
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();
            $data['cetak']      = '<button type="button" onclick="window.location.href = \''.base_url('transaksi/cetak_data_penj.php?'.(!empty($nt) ? 'filter_nota='.$nt : '').(!empty($tg) ? '&filter_tgl='.$tg : '').(!empty($tp) ? '&filter_tgl_tempo='.$tp : '').(!empty($cs) ? '&filter_cust='.$cs : '').(!empty($sl) ? '&filter_sales='.$sl : '').(!empty($jml) ? '&jml='.$jml : '')).'\'" class="btn btn-warning"><i class="fa fa-print"></i> Cetak</button>';
            /* --End Blok pagination-- */
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/menu/side_master';
            /* --- Sidebar Menu --- */
            
            /* Load view tampilan */
            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/master/index', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_kategori_list() {
        if (Akses::aksesLogin() == TRUE) {
            $query      = $this->input->get('q');
            $hal        = $this->input->get('halaman');
            $jml        = $this->input->get('jml');
            $kode       = $this->input->get('kode');
            $kategori   = $this->input->get('kategori');
            $jml_hal    = (!empty($jml) ? $jml  : $this->db->count_all('tbl_m_kategori'));
            $pengaturan = $this->db->get('tbl_pengaturan')->row();
            
            $data['hasError'] = $this->session->flashdata('form_error');
                        
            $config['base_url']               = base_url('master/data_kategori_list.php?'.(isset($_GET['q']) ? '&q='.$_GET['q'].'&jml='.$jml_hal : ''));
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
                if (!empty($query)) {
                    $data['kategori'] = $this->db->limit($config['per_page'],$hal)
                                               ->like('kategori', $query)
                                               ->or_like('keterangan', $query)
                                               ->order_by('kategori','asc')
                                               ->get('tbl_m_kategori')->result();
                } else if (!empty($kode)) {
                    $data['kategori'] = $this->db->limit($config['per_page'],$hal)
                                               ->like('kategori', $kode)
                                               ->order_by('kategori','asc')
                                               ->get('tbl_m_kategori')->result();
                } else if (!empty($kategori)) {
                    $data['kategori'] = $this->db->limit($config['per_page'],$hal)
                                               ->like('keterangan', $kategori)
                                               ->order_by('kategori','asc')
                                               ->get('tbl_m_kategori')->result();
                } else {
                    $data['kategori'] = $this->db->limit($config['per_page'],$hal)
                                               ->order_by('kategori','asc')
                                               ->get('tbl_m_kategori')->result();
                }
            }else{
                if (!empty($query)) {
                    $data['kategori'] = $this->db->limit($config['per_page'],$hal)
                                               ->like('kategori', $query)
                                               ->or_like('keterangan', $query)
                                               ->order_by('kategori','asc')
                                               ->get('tbl_m_kategori')->result();
                } else if (!empty($kode)) {
                    $data['kategori'] = $this->db->limit($config['per_page'],$hal)
                                               ->like('kategori', $kode)
                                               ->order_by('kategori','asc')
                                               ->get('tbl_m_kategori')->result();
                } else if (!empty($kategori)) {
                    $data['kategori'] = $this->db->limit($config['per_page'],$hal)
                                               ->like('keterangan', $kategori)
                                               ->order_by('kategori','asc')
                                               ->get('tbl_m_kategori')->result();
                } else {
                    $data['kategori'] = $this->db->limit($config['per_page'])->order_by('kategori','asc')->get('tbl_m_kategori')->result();
                }
            }
            
            $this->pagination->initialize($config);
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/master/sidebar_kategori';
            /* --- Sidebar Menu --- */
            
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();
            $data['cetak']      = '<button type="button" onclick="window.location.href = \''.base_url('master/cetak_data_kategori.php?'.(!empty($query) ? 'query='.$query : '').(!empty($jml) ? '&jml='.$jml : '')).'\'" class="btn btn-warning btn-flat"><i class="fa fa-print"></i> Cetak</button>';

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/master/data_kategori_list', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_kategori_tambah() {
        if (Akses::aksesLogin() == TRUE) {
            $id   = $this->input->get('id');
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/master/sidebar_kategori';
            /* --- Sidebar Menu --- */
            
            $data['kategori'] = $this->db->where('id', general::dekrip($id))->get('tbl_m_kategori')->row();

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/master/data_kategori_tambah', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_kategori_simpan() {
        if (Akses::aksesLogin() == TRUE) {
            $id       = $this->input->post('id');
            $kategori = $this->input->post('kategori');
            $ket      = $this->input->post('keterangan');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('kategori', 'Kategori', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'kategori'     => form_error('kategori'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                $this->session->set_flashdata('master_toast', 'toastr.error("Validasi form gagal, silahkan periksa kembali.");');
                redirect(base_url('master/data_kategori_tambah.php?id='.$id));
            } else {                
                $data_penj = array(
                    'tgl_simpan'    => date('Y-m-d H:i:s'),
                    'kategori'      => $kategori,
                    'keterangan'    => $ket
                );
                
                try {
                    if (check_form_submitted($this->input->post('form_id'))) {
                        $this->session->set_flashdata('master_toast', 'toastr.warning("Form sudah disubmit sebelumnya");');
                        redirect(base_url('master/data_kategori_list.php'));
                        return;
                    }
                    
                    if (!crud::simpan('tbl_m_kategori', $data_penj)) {
                        $this->session->set_flashdata('master_toast', 'toastr.error("Gagal menyimpan data kategori");');
                        throw new Exception("Gagal menyimpan data kategori");
                    }
                    
                    $this->session->set_flashdata('master_toast', 'toastr.success("Data kategori berhasil disimpan");');
                } catch (Exception $e) {
                    $this->session->set_flashdata('master_toast', 'toastr.error("' . $e->getMessage() . '");');
                    redirect(base_url('master/data_kategori_tambah.php?id='.$id));
                    return;
                }
                
                redirect(base_url('master/data_kategori_list.php'));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_kategori_update() {
        if (Akses::aksesLogin() == TRUE) {
            $id       = $this->input->post('id');
            $kategori = $this->input->post('kategori');
            $ket      = $this->input->post('keterangan');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('kategori', 'Kategori', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'kategori'     => form_error('kategori'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                $this->session->set_flashdata('master_toast', 'toastr.error("Validasi form gagal, silahkan periksa kembali.");');
                redirect(base_url('master/data_kategori_tambah.php?id='.$id));
            } else {                
                $data_penj = array(
                    'tgl_modif'     => date('Y-m-d H:i:s'),
                    'kategori'      => $kategori,
                    'keterangan'    => $ket
                );
                
                $this->session->set_flashdata('master_toast', 'toastr.success("Data kategori berhasil diubah");');
                crud::update('tbl_m_kategori','id', general::dekrip($id),$data_penj);
                redirect(base_url('master/data_kategori_tambah.php?id='.$id));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_kategori_hapus() {
        if (Akses::aksesLogin() == TRUE) {
            $id = $this->input->get('id');
            
            if(!empty($id)){
                crud::delete('tbl_m_kategori','id',general::dekrip($id));
                $this->session->set_flashdata('master_toast', 'toastr.success("Data kategori berhasil dihapus");');
            } else {
                $this->session->set_flashdata('master_toast', 'toastr.error("ID kategori tidak ditemukan");');
            }
            
            redirect(base_url('master/data_kategori_list.php'));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function set_kategori_cari() {
        if (Akses::aksesLogin() == TRUE) {
            redirect('master/data_kategori_list.php?' . http_build_query($_GET));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    
    public function data_mcu_list() {
        if (Akses::aksesLogin() == TRUE) {
            $query      = $this->input->get('q');
            $hal        = $this->input->get('halaman');
            $jml        = $this->input->get('jml');
            $jml_hal    = (!empty($jml) ? $jml  : $this->db->count_all('tbl_m_mcu'));
            $pengaturan = $this->db->get('tbl_pengaturan')->row();
            
            $data['hasError'] = $this->session->flashdata('form_error');
                        
            $config['base_url']               = base_url('master/data_mcu_list.php?'.(isset($_GET['q']) ? '&q='.$_GET['q'].'&jml='.$jml_hal : ''));
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
                if (!empty($query)) {
                    $data['sql_mcu'] = $this->db->limit($config['per_page'],$hal)
                                               ->like('pemeriksaan', $query)
//                                               ->or_like('keterangan', $query)
                                               ->order_by('pemeriksaan','asc')
                                               ->get('tbl_m_mcu')->result();
                } else {
                    $data['sql_mcu'] = $this->db->limit($config['per_page'],$hal)
                                               ->order_by('pemeriksaan','asc')
                                               ->get('tbl_m_mcu')->result();
                }
            }else{
                if (!empty($query)) {
                    $data['sql_mcu'] = $this->db->limit($config['per_page'])
                                               ->like('pemeriksaan', $query)
//                                               ->or_like('keterangan', $query)
                                               ->order_by('pemeriksaan','asc')
                                               ->get('tbl_m_mcu')->result();
                } else {
                    $data['sql_mcu'] = $this->db->limit($config['per_page'])->order_by('pemeriksaan','asc')->get('tbl_m_mcu')->result();
                }
            }
            
            $this->pagination->initialize($config);
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/master/sidebar_mcu';
            /* --- Sidebar Menu --- */
            
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();
            $data['cetak']      = '<button type="button" onclick="window.location.href = \''.base_url('master/cetak_data_mcu.php?'.(!empty($query) ? 'query='.$query : '').(!empty($jml) ? '&jml='.$jml : '')).'\'" class="btn btn-warning btn-flat"><i class="fa fa-print"></i> Cetak</button>';

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/master/data_mcu_list', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_mcu_tambah() {
        if (Akses::aksesLogin() == TRUE) {
            $id   = $this->input->get('id');
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/master/sidebar_mcu';
            /* --- Sidebar Menu --- */
            
            $data['sql_kat'] = $this->db->order_by('kategori', 'ASC')->get('tbl_m_mcu_kat')->result();
            $data['mcu']     = $this->db->where('id', general::dekrip($id))->get('tbl_m_mcu')->row();

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/master/data_mcu_tambah', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_mcu_simpan() {
        if (Akses::aksesLogin() == TRUE) {
            $id       = $this->input->post('id');
            $kategori = $this->input->post('kategori');
            $periksa  = $this->input->post('periksa');
            $ket      = $this->input->post('keterangan');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('kategori', 'Kategori', 'required');
            $this->form_validation->set_rules('periksa', 'Pemeriksaan', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'kategori'    => form_error('kategori'),
                    'periksa'     => form_error('periksa'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url('master/data_mcu_tambah.php?id='.$id));
            } else {                
                $data_penj = array(
                    'id_user'       => $this->ion_auth->user()->row()->id,
                    'id_kategori'   => $kategori,
                    'tgl_simpan'    => date('Y-m-d H:i:s'),
                    'pemeriksaan'   => $periksa,
                    'keterangan'    => $ket
                );
                
                $this->session->set_flashdata('master', '<div class="alert alert-success">Data MCU disimpan</div>');
                crud::simpan('tbl_m_mcu',$data_penj);
                redirect(base_url('master/data_mcu_list.php'));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_mcu_update() {
        if (Akses::aksesLogin() == TRUE) {
            $id       = $this->input->post('id');
            $kategori = $this->input->post('kategori');
            $ket      = $this->input->post('keterangan');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('kategori', 'Kategori', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'kategori'     => form_error('kategori'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url('master/data_mcu_tambah.php?id='.$id));
            } else {                
                $data_penj = array(
                    'tgl_simpan'    => date('Y-m-d H:i:s'),
                    'kategori'      => $kategori,
                    'keterangan'    => $ket
                );
                
                $this->session->set_flashdata('master', '<div class="alert alert-success">Data kategori diubah</div>');
                crud::update('tbl_m_kategori','id', general::dekrip($id),$data_penj);
                redirect(base_url('master/data_mcu_tambah.php?id='.$id));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_mcu_hapus() {
        if (Akses::aksesLogin() == TRUE) {
            $id = $this->input->get('id');
            
            if(!empty($id)){
                crud::delete('tbl_m_mcu','id',general::dekrip($id));
            }
            
            redirect(base_url('master/data_mcu_list.php'));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_mcu_kat_list() {
        if (Akses::aksesLogin() == TRUE) {
            $query      = $this->input->get('q');
            $hal        = $this->input->get('halaman');
            $jml        = $this->input->get('jml');
            $jml_hal    = (!empty($jml) ? $jml  : $this->db->count_all('tbl_m_mcu_kat'));
            $pengaturan = $this->db->get('tbl_pengaturan')->row();
            
            $data['hasError'] = $this->session->flashdata('form_error');
                        
            $config['base_url']               = base_url('master/data_mcu_kat_list.php?'.(isset($_GET['q']) ? '&q='.$_GET['q'].'&jml='.$jml_hal : ''));
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
                if (!empty($query)) {
                    $data['kategori'] = $this->db->limit($config['per_page'],$hal)
                                               ->like('kategori', $query)
                                               ->or_like('keterangan', $query)
                                               ->order_by('kategori','asc')
                                               ->get('tbl_m_mcu_kat')->result();
                } else {
                    $data['kategori'] = $this->db->limit($config['per_page'],$hal)
                                               ->order_by('kategori','asc')
                                               ->get('tbl_m_mcu_kat')->result();
                }
            }else{
                if (!empty($query)) {
                    $data['kategori'] = $this->db->limit($config['per_page'])
                                               ->like('kategori', $query)
                                               ->or_like('keterangan', $query)
                                               ->order_by('kategori','asc')
                                               ->get('tbl_m_mcu_kat')->result();
                } else {
                    $data['kategori'] = $this->db->limit($config['per_page'])->order_by('kategori','asc')->get('tbl_m_mcu_kat')->result();
                }
            }
            
            $this->pagination->initialize($config);
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/master/sidebar_mcu';
            /* --- Sidebar Menu --- */
            
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();
            $data['cetak']      = '<button type="button" onclick="window.location.href = \''.base_url('master/cetak_data_mcu_kat.php?'.(!empty($query) ? 'query='.$query : '').(!empty($jml) ? '&jml='.$jml : '')).'\'" class="btn btn-warning btn-flat"><i class="fa fa-print"></i> Cetak</button>';

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/master/data_mcu_kat_list', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_mcu_kat_tambah() {
        if (Akses::aksesLogin() == TRUE) {
            $id   = $this->input->get('id');
            
            $data['sql_kat'] = $this->db->where('status_utm', '1')->order_by('kategori', 'ASC')->get('tbl_m_mcu_kat')->result();
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/master/sidebar_mcu';
            /* --- Sidebar Menu --- */
            
            $data['kategori'] = $this->db->where('id', general::dekrip($id))->get('tbl_m_mcu_kat')->row();

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/master/data_mcu_kat_tambah', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_mcu_kat_simpan() {
        if (Akses::aksesLogin() == TRUE) {
            $id       = $this->input->post('id');
            $parent   = $this->input->post('parent');
            $kategori = $this->input->post('kategori');
            $ket      = $this->input->post('keterangan');
            $sp       = $this->input->post('sp');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('kategori', 'Kategori', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'kategori'     => form_error('kategori'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url('master/data_mcu_kat_tambah.php?id='.$id));
            } else {                
                $data_penj = array(
                    'tgl_simpan'    => date('Y-m-d H:i:s'),
                    'id_kat'        => $parent,
                    'kategori'      => $kategori,
                    'keterangan'    => $ket,
                    'status_utm'    => (!empty($sp) ? '1' : '0')
                );
                
                $this->session->set_flashdata('master', '<div class="alert alert-success">Data kategori disimpan</div>');
                crud::simpan('tbl_m_mcu_kat',$data_penj);
                redirect(base_url('master/data_mcu_kat_list.php'));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_mcu_kat_update() {
        if (Akses::aksesLogin() == TRUE) {
            $id       = $this->input->post('id');
            $parent   = $this->input->post('parent');
            $kategori = $this->input->post('kategori');
            $ket      = $this->input->post('keterangan');
            $sp       = $this->input->post('sp');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('kategori', 'Kategori', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'kategori'     => form_error('kategori'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url('master/data_mcu_kat_tambah.php?id='.$id));
            } else {                
                $data_penj = array(
                    'tgl_simpan'    => date('Y-m-d H:i:s'),
                    'id_kat'        => $parent,
                    'kategori'      => $kategori,
                    'keterangan'    => $ket,
                    'status_utm'    => (!empty($sp) ? '1' : '0')
                );
                
                $this->session->set_flashdata('master', '<div class="alert alert-success">Data kategori diubah</div>');
                crud::update('tbl_m_mcu_kat','id', general::dekrip($id),$data_penj);
                redirect(base_url('master/data_mcu_kat_tambah.php?id='.$id));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_mcu_kat_hapus() {
        if (Akses::aksesLogin() == TRUE) {
            $id = $this->input->get('id');
            
            if(!empty($id)){
                crud::delete('tbl_m_mcu_kat','id',general::dekrip($id));
            }
            
            redirect(base_url('master/data_mcu_kat_list.php'));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    /**
 * Function to display MCU Header data
 * 
 * Created by:
 * Mikhael Felian Waskito - mikhaelfelian@gmail.com
 * 2025-03-15
 * master controller
 */
    public function data_mcu_header() {
        if (Akses::aksesLogin() == TRUE) {
            $query      = $this->input->get('q');
            $hal        = $this->input->get('halaman');
            $jml        = $this->input->get('jml');
            $jml_hal    = (!empty($jml) ? $jml  : $this->db->count_all('tbl_m_mcu_header'));
            $pengaturan = $this->db->get('tbl_pengaturan')->row();
            
            $data['hasError'] = $this->session->flashdata('form_error');
                        
            $config['base_url']               = base_url('master/data_mcu_header_list.php?'.(isset($_GET['q']) ? '&q='.$_GET['q'].'&jml='.$jml_hal : ''));
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
                if (!empty($query)) {
                    $data['sql_mcu_header'] = $this->db->limit($config['per_page'],$hal)
                                            ->like('param', $query)
                                            ->order_by('id','asc')
                                            ->get('tbl_m_mcu_header')->result();
                } else {
                    $data['sql_mcu_header'] = $this->db->limit($config['per_page'],$hal)
                                            ->order_by('id','asc')
                                            ->get('tbl_m_mcu_header')->result();
                }
            }else{
                if (!empty($query)) {
                    $data['sql_mcu_header'] = $this->db->limit($config['per_page'])
                                            ->like('param', $query)
                                            ->order_by('id','asc')
                                            ->get('tbl_m_mcu_header')->result();
                } else {
                    $data['sql_mcu_header'] = $this->db->limit($config['per_page'])->order_by('id','asc')->get('tbl_m_mcu_header')->result();
                }
            }
            
            $this->pagination->initialize($config);
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/master/sidebar_mcu';
            /* --- Sidebar Menu --- */
            
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();
            $data['cetak']      = '<button type="button" onclick="window.location.href = \''.base_url('master/cetak_data_mcu_header.php?'.(!empty($query) ? 'query='.$query : '').(!empty($jml) ? '&jml='.$jml : '')).'\'" class="btn btn-warning btn-flat rounded-0"><i class="fa fa-print"></i> Cetak</button>';

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/master/data_mcu_header', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function data_mcu_header_hapus() {
        if (Akses::aksesLogin() == TRUE) {
            $id = $this->input->get('id');
            
            if (!empty($id)) {
                $this->db->where('id', general::dekrip($id));
                $this->db->delete('tbl_m_mcu_header');
                
                $this->session->set_flashdata('message', '<div class="alert alert-success">Data berhasil dihapus!</div>');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger">Data tidak ditemukan!</div>');
            }
            
            redirect(base_url('master/data_mcu_header_list.php'));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function data_icd_list() {
        if (Akses::aksesLogin() == TRUE) {
            $hal        = $this->input->get('halaman');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();
            
            /* -- Blok Filter -- */
            $hal     = $this->input->get('halaman');
            $kd      = $this->input->get('filter_kode');
            $dg      = $this->input->get('filter_diag');
            $kt      = $this->input->get('filter_ket');
            $jml     = $this->input->get('jml');
            $jml_hal = (!empty($jml) ? $jml  : $this->db->get('tbl_m_icd')->num_rows());
            
            $data['hasError']                   = $this->session->flashdata('form_error');
                        
            $config['base_url']                 = base_url('master/data_icd_list.php?'.(!empty($kd) ? 'filter_kode='.$kd.'&' : '').(!empty($dg) ? 'filter_diag='.$dg.'&' : '').'jml='.$jml_hal);
            $config['total_rows']               = $jml_hal;
            
            $config['query_string_segment']     = 'halaman';
            $config['page_query_string']        = TRUE;
            $config['per_page']                 = $pengaturan->jml_item;
            $config['num_links']                = 3;
            
            $config['first_tag_open']           = '<li class="page-item">';
            $config['first_tag_close']          = '</li>';
            
            $config['prev_tag_open']            = '<li class="page-item">';
            $config['prev_tag_close']           = '</li>';
            
            $config['num_tag_open']             = '<li class="page-item">';
            $config['num_tag_close']            = '</li>';
            
            $config['next_tag_open']            = '<li class="page-item">';
            $config['next_tag_close']           = '</li>';
            
            $config['last_tag_open']            = '<li class="page-item">';
            $config['last_tag_close']           = '</li>';
            
            $config['cur_tag_open']             = '<li class="page-item"><a href="#" class="page-link text-dark"><b>';
            $config['cur_tag_close']            = '</b></a></li>';
            
            $config['first_link']               = '&laquo;';
            $config['prev_link']                = '&lsaquo;';
            $config['next_link']                = '&rsaquo;';
            $config['last_link']                = '&raquo;';
            $config['anchor_class']             = 'class="page-link"';
            
            
            if(!empty($hal)){
                $data['sql_icd'] = $this->db->limit($config['per_page'], $hal)
                                            ->like('kode', $kd)
                                            ->like('icd', $dg)
                                            ->order_by('kode', 'asc')
                                            ->get('tbl_m_icd')->result();
            }else{
                $data['sql_icd'] = $this->db->limit($config['per_page'])
                                            ->like('kode', $kd)
                                            ->like('icd', $dg)
                                            ->order_by('kode', 'asc')
                                            ->get('tbl_m_icd')->result();
            }
            
            $this->pagination->initialize($config);
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/master/sidebar_icd';
            /* --- Sidebar Menu --- */
            
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();
            $data['cetak']      = '<button type="button" onclick="window.location.href = \''.base_url('master/cetak_data_icd.php?'.(!empty($query) ? 'query='.$query : '').(!empty($jml) ? '&jml='.$jml : '')).'\'" class="btn btn-warning btn-flat"><i class="fa fa-print"></i> Cetak</button>';

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/master/data_icd_list', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_icd_tambah() {
        if (Akses::aksesLogin() == TRUE) {
            $id   = $this->input->get('id');
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/master/sidebar_icd';
            /* --- Sidebar Menu --- */
            
            $data['icd']     = $this->db->where('id', general::dekrip($id))->get('tbl_m_icd')->row();

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/master/data_icd_tambah', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_icd_simpan() {
        if (Akses::aksesLogin() == TRUE) {
            $kode     = $this->input->post('kode');
            $diagnosa = $this->input->post('diagnosa');
            $ket      = $this->input->post('keterangan');
            $harga    = $this->input->post('harga');
            $harga1   = $this->input->post('harga1');
            $harga2   = $this->input->post('harga2');
            $harga3   = $this->input->post('harga3');
            $tipe     = $this->input->post('tipe');
            $tipe_icd = $this->input->post('tipe_icd');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('kode', 'Kode', 'required');
            $this->form_validation->set_rules('diagnosa', 'Diagnosa', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'kode'        => form_error('kode'),
                    'diagnosa'    => form_error('diagnosa'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url('master/data_icd_tambah.php?id='.$id));
            } else {                
                $data = array(
                    'id_user'       => $this->ion_auth->user()->row()->id,
                    'tgl_simpan'    => date('Y-m-d H:i:s'),
                    'kode'          => $kode,
                    'diagnosa'      => $diagnosa,
                    'keterangan'    => $ket,
                    'harga'         => (!empty($harga) ? general::format_angka_db($harga) : '0'),
                    'harga1'        => (!empty($harga1) ? general::format_angka_db($harga1) : '0'),
                    'harga2'        => (!empty($harga2) ? general::format_angka_db($harga2) : '0'),
                    'harga3'        => (!empty($harga3) ? general::format_angka_db($harga3) : '0'),
                    'status'        => (!empty($tipe) ? (int)$tipe : '0'),
                    'status_icd'    => (!empty($tipe_icd) ? (int)$tipe_icd : '0'),
                );
                
                $this->session->set_flashdata('master', '<div class="alert alert-success">Data ICD disimpan</div>');
                crud::simpan('tbl_m_icd', $data);
                redirect(base_url('master/data_icd_list.php'));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_icd_update() {
        if (Akses::aksesLogin() == TRUE) {
            $id       = $this->input->post('id');
            $kode     = $this->input->post('kode');
            $diagnosa = $this->input->post('diagnosa');
            $ket      = $this->input->post('keterangan');
            $harga    = $this->input->post('harga');
            $harga1   = $this->input->post('harga1');
            $harga2   = $this->input->post('harga2');
            $harga3   = $this->input->post('harga3');
            $tipe     = $this->input->post('tipe');
            $tipe_icd = $this->input->post('tipe_icd');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('kode', 'Kode', 'required');
            $this->form_validation->set_rules('diagnosa', 'Diagnosa', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'kode'        => form_error('kode'),
                    'diagnosa'    => form_error('diagnosa'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url('master/data_icd_tambah.php?id='.$id));
            } else {                
                $data = array(
                    'id_user'       => $this->ion_auth->user()->row()->id,
                    'tgl_simpan'    => date('Y-m-d H:i:s'),
                    'kode'          => $kode,
                    'diagnosa'      => $diagnosa,
                    'keterangan'    => $ket,
                    'harga'         => (!empty($harga) ? general::format_angka_db($harga) : '0'),
                    'harga1'        => (!empty($harga1) ? general::format_angka_db($harga1) : '0'),
                    'harga2'        => (!empty($harga2) ? general::format_angka_db($harga2) : '0'),
                    'harga3'        => (!empty($harga3) ? general::format_angka_db($harga3) : '0'),
                    'status'        => (!empty($tipe) ? (int)$tipe : '0'),
                    'status_icd'    => (!empty($tipe_icd) ? (int)$tipe_icd : '0'),
                );
                
                $this->session->set_flashdata('master', '<div class="alert alert-success">Data ICD disimpan</div>');
                crud::update('tbl_m_icd', 'id', general::dekrip($id), $data);
                redirect(base_url('master/data_icd_list.php'));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_icd_hapus() {
        if (Akses::aksesLogin() == TRUE) {
            $id = $this->input->get('id');
            
            if(!empty($id)){
                crud::delete('tbl_m_icd','id',general::dekrip($id));
            }
            
            redirect(base_url('master/data_icd_list.php'));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    
    public function data_merk_list() {
        if (Akses::aksesLogin() == TRUE) {
            $query      = $this->input->get('q');
            $hal        = $this->input->get('halaman');
            $jml        = $this->input->get('jml');
            $jml_hal    = (!empty($jml) ? $jml  : $this->db->count_all('tbl_m_merk'));
            $pengaturan = $this->db->get('tbl_pengaturan')->row();
            
            $data['hasError'] = $this->session->flashdata('form_error');
                        
            $config['base_url']               = base_url('master/data_merk_list.php?'.(isset($_GET['q']) ? '&q='.$_GET['q'].'&jml='.$jml_hal : ''));
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
                if (!empty($query)) {
                    $data['merk'] = $this->db->limit($config['per_page'],$hal)
                                               ->like('merk', $query)
                                               ->or_like('keterangan', $query)
                                               ->order_by('merk','asc')
                                               ->get('tbl_m_merk')->result();
                } else {
                    $data['merk'] = $this->db->limit($config['per_page'],$hal)
                                               ->order_by('merk','asc')
                                               ->get('tbl_m_merk')->result();
                }
            }else{
                if (!empty($query)) {
                    $data['merk'] = $this->db->limit($config['per_page'],$hal)
                                               ->like('merk', $query)
                                               ->or_like('keterangan', $query)
                                               ->order_by('merk','asc')
                                               ->get('tbl_m_merk')->result();
                } else {
                    $data['merk'] = $this->db->limit($config['per_page'])->order_by('merk','asc')->get('tbl_m_merk')->result();
                }
            }
            
            $this->pagination->initialize($config);
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/master/sidebar_merk';
            /* --- Sidebar Menu --- */
            
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();
            $data['cetak']      = '<button type="button" onclick="window.location.href = \''.base_url('master/cetak_data_merk.php?'.(!empty($query) ? 'query='.$query : '').(!empty($jml) ? '&jml='.$jml : '')).'\'" class="btn btn-warning btn-flat"><i class="fa fa-print"></i> Cetak</button>';

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/master/data_merk_list', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_merk_tambah() {
        if (Akses::aksesLogin() == TRUE) {
            $id   = $this->input->get('id');
            
            $data['merk'] = $this->db->where('id', general::dekrip($id))->get('tbl_m_merk')->row();
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/master/sidebar_merk';
            /* --- Sidebar Menu --- */

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/master/data_merk_tambah', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_merk_simpan() {
        if (Akses::aksesLogin() == TRUE) {
            $id       = $this->input->post('id');
            $merk     = $this->input->post('merk');
            $ket      = $this->input->post('keterangan');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('merk', 'Merk', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'merk'     => form_error('merk'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                $this->session->set_flashdata('master_toast', 'toastr.error("Validasi form gagal, silahkan periksa kembali.");');
                redirect(base_url('master/data_merk_tambah.php'));
            } else {                
                $data_penj = array(
                    'tgl_simpan' => date('Y-m-d H:i:s'),
                    'tgl_modif'  => date('Y-m-d H:i:s'),
                    'merk'       => $merk,
                    'keterangan' => $ket
                );
                
                try {
                    if (check_form_submitted($this->input->post('form_id'))) {
                        $this->session->set_flashdata('master_toast', 'toastr.warning("Form sudah disubmit sebelumnya");');
                        redirect(base_url('master/data_merk_list.php'));
                        return;
                    }
                    
                    if (!crud::simpan('tbl_m_merk', $data_penj)) {
                        $this->session->set_flashdata('master_toast', 'toastr.error("Gagal menyimpan data merk");');
                        throw new Exception("Gagal menyimpan data merk");
                    }
                    
                    $this->session->set_flashdata('master_toast', 'toastr.success("Data merk berhasil disimpan");');
                } catch (Exception $e) {
                    $this->session->set_flashdata('master_toast', 'toastr.error("' . $e->getMessage() . '");');
                    redirect(base_url('master/data_merk_tambah.php?id='.$id));
                    return;
                }
                redirect(base_url('master/data_merk_list.php'));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_merk_update() {
        if (Akses::aksesLogin() == TRUE) {
            $id       = $this->input->post('id');
            $merk     = $this->input->post('merk');
            $ket      = $this->input->post('keterangan');
            $diskon   = $this->input->post('diskon');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('merk', 'Kategori', 'required');
            $this->form_validation->set_rules('id', 'ID', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'id'       => form_error('id'),
                    'merk'     => form_error('merk'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                $this->session->set_flashdata('master_toast', 'toastr.error("Validasi form gagal, silahkan periksa kembali.");');
                redirect(base_url('master/data_merk_tambah.php?id='.$id));
            } else {
                try {
                    if (check_form_submitted($this->input->post('form_id'))) {
                        $this->session->set_flashdata('master_toast', 'toastr.warning("Form sudah disubmit sebelumnya");');
                        redirect(base_url('master/data_merk_list.php'));
                        return;
                    }
                    
                    $sql = $this->db->where('id_merk', general::dekrip($id))->get('tbl_m_produk')->result();
                    $count_updated = 0; // Initialize counter for updated products
                    
                    $data_penj = array(
                        'tgl_modif'  => date('Y-m-d H:i:s'),
                        'merk'       => $merk,
                        'keterangan' => $ket,
                        'diskon'     => (!empty($diskon) ? $diskon : '0'),
                    );
                    
                    if (!crud::update('tbl_m_merk', 'id', general::dekrip($id), $data_penj)) {
                        $this->session->set_flashdata('master_toast', 'toastr.error("Gagal mengubah data merk");');
                        throw new Exception("Gagal mengubah data merk");
                    }
                    
                    $this->session->set_flashdata('master_toast', 'toastr.success("Data merk berhasil diubah");');
                } catch (Exception $e) {
                    $this->session->set_flashdata('master_toast', 'toastr.error("' . $e->getMessage() . '");');
                    redirect(base_url('master/data_merk_tambah.php?id='.$id));
                    return;
                }
                
                redirect(base_url('master/data_merk_tambah.php?id='.$id));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_merk_hapus() {
        if (Akses::aksesLogin() == TRUE) {
            $id = $this->input->get('id');
            
            if(!empty($id)){
                crud::delete('tbl_m_merk','id',general::dekrip($id));
            }
            
            redirect(base_url('master/data_merk_list.php'));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_klinik_list() {
        if (Akses::aksesLogin() == TRUE) {
            $query      = $this->input->get('q');
            $hal        = $this->input->get('halaman');
            $jml        = $this->input->get('jml');
            $kode       = $this->input->get('kode');
            $klinik     = $this->input->get('klinik');
            $jml_hal    = (!empty($jml) ? $jml  : $this->db->count_all('tbl_m_poli'));
            $pengaturan = $this->db->get('tbl_pengaturan')->row();
            
            $data['hasError'] = $this->session->flashdata('form_error');
                        
            $config['base_url']               = base_url('master/data_klinik_list.php?'.(isset($_GET['q']) ? '&q='.$_GET['q'].'&jml='.$jml_hal : ''));
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
                if (!empty($query)) {
                    $data['lokasi'] = $this->db->limit($config['per_page'],$hal)
                                               ->like('lokasi', $query)
                                               ->order_by('lokasi','asc')
                                               ->get('tbl_m_poli')->result();
                } else if (!empty($kode)) {
                    $data['lokasi'] = $this->db->limit($config['per_page'],$hal)
                                               ->like('kode', $kode)
                                               ->order_by('lokasi','asc')
                                               ->get('tbl_m_poli')->result();
                } else if (!empty($klinik)) {
                    $data['lokasi'] = $this->db->limit($config['per_page'],$hal)
                                               ->like('lokasi', $klinik)
                                               ->order_by('lokasi','asc')
                                               ->get('tbl_m_poli')->result();
                } else {
                    $data['lokasi'] = $this->db->limit($config['per_page'],$hal)
                                               ->order_by('lokasi','asc')
                                               ->get('tbl_m_poli')->result();
                }
            }else{
                if (!empty($query)) {
                    $data['lokasi'] = $this->db->limit($config['per_page'],$hal)
                                               ->like('lokasi', $query)
                                               ->order_by('lokasi','asc')
                                               ->get('tbl_m_poli')->result();
                } else if (!empty($kode)) {
                    $data['lokasi'] = $this->db->limit($config['per_page'],$hal)
                                               ->like('kode', $kode)
                                               ->order_by('lokasi','asc')
                                               ->get('tbl_m_poli')->result();
                } else if (!empty($klinik)) {
                    $data['lokasi'] = $this->db->limit($config['per_page'],$hal)
                                               ->like('lokasi', $klinik)
                                               ->order_by('lokasi','asc')
                                               ->get('tbl_m_poli')->result();
                } else {
                    $data['lokasi'] = $this->db->limit($config['per_page'])->order_by('lokasi','asc')->get('tbl_m_poli')->result();
                }
            }
            
            $this->pagination->initialize($config);
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/master/sidebar_klinik';
            /* --- Sidebar Menu --- */
            
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();
            $data['cetak']      = '<button type="button" onclick="window.location.href = \''.base_url('master/cetak_data_lokasi.php?'.(!empty($query) ? 'query='.$query : '').(!empty($jml) ? '&jml='.$jml : '')).'\'" class="btn btn-warning btn-flat"><i class="fa fa-print"></i> Cetak</button>';

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/master/data_klinik_list', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_klinik_tambah() {
        if (Akses::aksesLogin() == TRUE) {
            $id   = $this->input->get('id');
            
            $data['lokasi'] = $this->db->where('id', general::dekrip($id))->get('tbl_m_poli')->row();
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/master/sidebar_klinik';
            /* --- Sidebar Menu --- */

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/master/data_klinik_tambah', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_klinik_simpan() {
        if (Akses::aksesLogin() == TRUE) {
            $kode          = $this->input->post('kode');
            $lokasi        = $this->input->post('lokasi');
            $ket           = $this->input->post('keterangan');
            $postlocation  = $this->input->post('postlocation');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('lokasi', 'Kategori', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'lokasi'     => form_error('lokasi'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url('master/data_klinik_tambah.php'));
            } else {
                try {
                    if (check_form_submitted($this->input->post('form_id'))) {
                        $this->session->set_flashdata('master_toast', 'toastr.warning("Form sudah disubmit sebelumnya");');
                        redirect(base_url('master/data_klinik_list.php'));
                        return;
                    }
                    
                    $data_penj = array(
                        'tgl_simpan' => date('Y-m-d H:i:s'),
                        'tgl_modif'  => date('Y-m-d H:i:s'),
                        'kode'       => $kode,
                        'lokasi'     => $lokasi,
                        'keterangan' => $ket,
                        'post_location' => $postlocation,
                    );
                    
                    if (!crud::simpan('tbl_m_poli', $data_penj)) {
                        $this->session->set_flashdata('master_toast', 'toastr.error("Gagal menyimpan data klinik");');
                        throw new Exception("Gagal menyimpan data klinik");
                    }
                    
                    $this->session->set_flashdata('master_toast', 'toastr.success("Data klinik berhasil disimpan");');
                    $this->session->set_flashdata('master', '<div class="alert alert-success">Data klinik disimpan</div>');
                } catch (Exception $e) {
                    $this->session->set_flashdata('master_toast', 'toastr.error("' . $e->getMessage() . '");');
                    redirect(base_url('master/data_klinik_tambah.php'));
                    return;
                }
                redirect(base_url('master/data_klinik_list.php'));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_klinik_update() {
        if (Akses::aksesLogin() == TRUE) {
            $id            = $this->input->post('id');
            $kode          = $this->input->post('kode');
            $lokasi        = $this->input->post('lokasi');
            $ket           = $this->input->post('keterangan');
            $postlocation  = $this->input->post('postlocation');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('lokasi', 'Kategori', 'required');
            $this->form_validation->set_rules('id', 'ID', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'lokasi'     => form_error('lokasi'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url('master/data_klinik_tambah.php?id='.$id));
            } else {
                try {
                    if (check_form_submitted($this->input->post('form_id'))) {
                        $this->session->set_flashdata('master_toast', 'toastr.warning("Form sudah disubmit sebelumnya");');
                        redirect(base_url('master/data_klinik_list.php'));
                        return;
                    }
                    
                    $data_penj = array(
                        'tgl_modif'  => date('Y-m-d H:i:s'),
                        'kode'       => $kode,
                        'lokasi'     => $lokasi,
                        'keterangan' => $ket,
                        'post_location' => $postlocation,
                    );
                    
                    if (!crud::update('tbl_m_poli', 'id', general::dekrip($id), $data_penj)) {
                        $this->session->set_flashdata('master_toast', 'toastr.error("Gagal mengubah data klinik");');
                        throw new Exception("Gagal mengubah data klinik");
                    }
                    
                    $this->session->set_flashdata('master_toast', 'toastr.success("Data klinik berhasil diubah");');
                    $this->session->set_flashdata('master', '<div class="alert alert-success">Data klinik diubah</div>');
                } catch (Exception $e) {
                    $this->session->set_flashdata('master_toast', 'toastr.error("' . $e->getMessage() . '");');
                    redirect(base_url('master/data_klinik_tambah.php?id='.$id));
                    return;
                }
                redirect(base_url('master/data_klinik_tambah.php?id='.$id));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_klinik_hapus() {
        if (Akses::aksesLogin() == TRUE) {
            $id = $this->input->get('id');
            
            if(!empty($id)){
                try {
                    if (!crud::delete('tbl_m_poli','id',general::dekrip($id))) {
                        $this->session->set_flashdata('master_toast', 'toastr.error("Gagal menghapus data klinik");');
                    } else {
                        $this->session->set_flashdata('master_toast', 'toastr.success("Data klinik berhasil dihapus");');
                    }
                } catch (Exception $e) {
                    $this->session->set_flashdata('master_toast', 'toastr.error("' . $e->getMessage() . '");');
                }
            }
            
            redirect(base_url('master/data_klinik_list.php'));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function set_klinik_cari() {
        if (Akses::aksesLogin() == TRUE) {
            redirect('master/data_klinik_list.php?' . http_build_query($_GET));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_gudang_list() {
        if (Akses::aksesLogin() == TRUE) {
            $query      = $this->input->get('q');
            $hal        = $this->input->get('halaman');
            $jml        = $this->input->get('jml');
            $jml_hal    = (!empty($jml) ? $jml  : $this->db->count_all('tbl_m_gudang'));
            $pengaturan = $this->db->get('tbl_pengaturan')->row();
            
            $data['hasError'] = $this->session->flashdata('form_error');
                        
            $config['base_url']               = base_url('master/data_gudang_list.php?'.(isset($_GET['q']) ? '&q='.$_GET['q'].'&jml='.$jml_hal : ''));
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
                if (!empty($query)) {
                    $data['gudang'] = $this->db->limit($config['per_page'],$hal)
                                               ->like('gudangTerkecil', $query)
                                               ->or_like('gudangBesar', $query)
                                               ->or_like('jml', $query)
                                               ->get('tbl_m_gudang')->result();
                } else {
                    $data['gudang'] = $this->db->limit($config['per_page'],$hal)
                                               ->order_by('id','asc')
                                               ->get('tbl_m_gudang')->result();
                }
            }else{
                if (!empty($query)) {
                    $data['gudang'] = $this->db->limit($config['per_page'],$hal)
                                               ->like('gudangTerkecil', $query)
                                               ->or_like('gudangBesar', $query)
                                               ->or_like('jml', $query)
                                               ->get('tbl_m_gudang')->result();
                } else {
                    $data['gudang'] = $this->db->limit($config['per_page'])->order_by('id','asc')->get('tbl_m_gudang')->result();
                }
            }
            
            $this->pagination->initialize($config);
            
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();
            $data['cetak']      = '<button type="button" onclick="window.location.href = \''.base_url('master/cetak_data_gudang.php?'.(!empty($query) ? 'query='.$query : '').(!empty($jml) ? '&jml='.$jml : '')).'\'" class="btn btn-warning btn-flat"><i class="fa fa-print"></i> Cetak</button>';
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/master/sidebar_gd';
            /* --- Sidebar Menu --- */
            
            /* Load view tampilan */
            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/master/data_gudang_list', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_gudang_tambah() {
        if (Akses::aksesLogin() == TRUE) {
            $id   = $this->input->get('id');
            
            $data['gudang'] = $this->db->where('id', general::dekrip($id))->get('tbl_m_gudang')->row();

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
//            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/master/data_gudang_tambah', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
	
    public function data_kamar_list() {
        if (Akses::aksesLogin() == TRUE) {
            $query      = $this->input->get('q');
            $hal        = $this->input->get('halaman');
            $jml        = $this->input->get('jml');
            $jml_hal    = (!empty($jml) ? $jml  : $this->db->count_all('tbl_m_poli'));
            $pengaturan = $this->db->get('tbl_pengaturan')->row();
            
            $data['hasError'] = $this->session->flashdata('form_error');
                        
            $config['base_url']               = base_url('master/data_kamar_list.php?'.(isset($_GET['q']) ? '&q='.$_GET['q'].'&jml='.$jml_hal : ''));
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
                if (!empty($query)) {
                    $data['sql_kamar'] = $this->db->limit($config['per_page'],$hal)
                                               ->like('kamar', $query)
                                               ->order_by('id','asc')
                                               ->get('tbl_m_kamar')->result();
                } else {
                    $data['sql_kamar'] = $this->db->limit($config['per_page'],$hal)
                                               ->order_by('id','asc')
                                               ->get('tbl_m_kamar')->result();
                }
            }else{
                if (!empty($query)) {
                    $data['sql_kamar'] = $this->db->limit($config['per_page'],$hal)
                                               ->like('kamar', $query)
                                               ->order_by('id','asc')
                                               ->get('tbl_m_kamar')->result();
                } else {
                    $data['sql_kamar'] = $this->db->limit($config['per_page'])->order_by('id','asc')->get('tbl_m_kamar')->result();
                }
            }
            
            $this->pagination->initialize($config);
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/master/sidebar_kamar';
            /* --- Sidebar Menu --- */
            
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();
            $data['cetak']      = '<button type="button" onclick="window.location.href = \''.base_url('master/cetak_data_lokasi.php?'.(!empty($query) ? 'query='.$query : '').(!empty($jml) ? '&jml='.$jml : '')).'\'" class="btn btn-warning btn-flat"><i class="fa fa-print"></i> Cetak</button>';

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/master/data_kamar_list', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_kamar_tambah() {
        if (Akses::aksesLogin() == TRUE) {
            $id   = $this->input->get('id');
            
            $data['sql_kamar'] = $this->db->where('id', general::dekrip($id))->get('tbl_m_kamar')->row();
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/master/sidebar_kamar';
            /* --- Sidebar Menu --- */

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/master/data_kamar_tambah', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_kamar_simpan() {
        if (Akses::aksesLogin() == TRUE) {
            $kode  = $this->input->post('kode');
            $kamar = $this->input->post('kamar');
            $max   = $this->input->post('jml_max');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('kode', 'Kode', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'kode' => form_error('kode'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url('master/data_kamar_tambah.php?id='.$id));
            } else {                
                $data = array(
                    'tgl_simpan' => date('Y-m-d H:i:s'),
                    'kode'       => $kode,
                    'kamar'      => $kamar,
                    'jml_max'    => $max,
                    'status'     => '1',
                );
                
                $this->db->insert('tbl_m_kamar',$data);
                
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('master_toast', 'toastr.success("Data kamar berhasil disimpan !");');
                }else{
                    $this->session->set_flashdata('master_toast', 'toastr.error("Data kamar gagal disimpan !");');
                }                
                
                redirect(base_url('master/data_kamar_list.php'));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_kamar_update() {
        if (Akses::aksesLogin() == TRUE) {
            $id    = $this->input->post('id');
            $kode  = $this->input->post('kode');
            $kamar = $this->input->post('kamar');
            $max   = $this->input->post('jml_max');
            $status= $this->input->post('status');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id', 'ID', 'required');
            $this->form_validation->set_rules('kode', 'kode', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'id'    => form_error('id'),
                    'kode'  => form_error('kode'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url('master/data_kamar_tambah.php?id='.$id));
            } else {                
                $data = array(
                    'tgl_simpan' => date('Y-m-d H:i:s'),
                    'kode'       => $kode,
                    'kamar'      => $kamar,
                    'jml_max'    => $max,
                    'status'     => $status,
                );
                
                $this->db->where('id', general::dekrip($id))->update('tbl_m_kamar', $data);
                
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('master_toast', 'toastr.success("Perubahan berhasil disimpan !");');
                }else{
                    $this->session->set_flashdata('master_toast', 'toastr.error("Perubahan gagal disimpan !");');
                }
                
                redirect(base_url('master/data_kamar_tambah.php?id='.$id));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_kamar_hapus() {
        if (Akses::aksesLogin() == TRUE) {
            $id = $this->input->get('id');
            
            if(!empty($id)){
                crud::delete('tbl_m_kamar','id',general::dekrip($id));
            }
            
            redirect(base_url('master/data_kamar_list.php'));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_satuan_list() {
        if (Akses::aksesLogin() == TRUE) {
            $query      = $this->input->get('q');
            $satuan     = $this->input->get('satuan');
            $hal        = $this->input->get('halaman');
            $jml        = $this->input->get('jml');
            $jml_hal    = (!empty($jml) ? $jml  : $this->db->count_all('tbl_m_satuan'));
            $pengaturan = $this->db->get('tbl_pengaturan')->row();
            
            $data['hasError'] = $this->session->flashdata('form_error');
                        
            $config['base_url']               = base_url('master/data_satuan_list.php?'.(isset($_GET['q']) ? '&q='.$_GET['q'].'&jml='.$jml_hal : ''));
            $config['total_rows']             = $jml_hal;
            
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
            
            $this->db->select('satuanBesar');
            
            if(!empty($satuan)) {
                $this->db->where('satuanBesar', $satuan);
            }
            
            if(!empty($hal)){
                if (!empty($query)) {
                    $data['satuan'] = $this->db->limit($config['per_page'],$hal)
                                               ->like('satuanBesar', $query)
                                               ->order_by('satuanBesar','asc')
                                               ->get('tbl_m_satuan')->result();
                } else {
                    $data['satuan'] = $this->db->limit($config['per_page'],$hal)
                                               ->order_by('satuanBesar','asc')
                                               ->get('tbl_m_satuan')->result();
                }
            }else{
                if (!empty($query)) {
                    $data['satuan'] = $this->db->limit($config['per_page'],$hal)
                                               ->like('satuanBesar', $query)
                                               ->order_by('satuanBesar','asc')
                                               ->get('tbl_m_satuan')->result();
                } else {
                    $data['satuan'] = $this->db->limit($config['per_page'])->order_by('satuanBesar','asc')->get('tbl_m_satuan')->result();
                }
            }
            
            $this->pagination->initialize($config);
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/master/sidebar_satuan';
            /* --- Sidebar Menu --- */
            
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();
            $data['cetak']      = '<button type="button" onclick="window.location.href = \''.base_url('master/cetak_data_satuan.php?'.(!empty($query) ? 'query='.$query : '').(!empty($jml) ? '&jml='.$jml : '')).'\'" class="btn btn-warning btn-flat"><i class="fa fa-print"></i> Cetak</button>';

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/master/data_satuan_list', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_satuan_tambah() {
        if (Akses::aksesLogin() == TRUE) {
            $id   = $this->input->get('id');
            
            $data['satuan']   = $this->db->where('id', general::dekrip($id))->get('tbl_m_satuan')->row();
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/master/sidebar_satuan';
            /* --- Sidebar Menu --- */

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/master/data_satuan_tambah', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_satuan_simpan() {
        if (Akses::aksesLogin() == TRUE) {
            $id      = $this->input->post('id');
            $satKcl  = $this->input->post('satKcl');
            $satBsr  = $this->input->post('satBsr');
            $jml     = $this->input->post('jml');
            $tipe    = $this->input->post('tipe');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('satKcl', 'Satuan Terkecil', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'satKcl'     => form_error('satKcl'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                $this->session->set_flashdata('master_toast', 'toastr.error("Validasi form gagal, silahkan periksa kembali.");');
                redirect(base_url('master/data_satuan_tambah.php'));
            } else {                
                $data_penj = array(
                    'tgl_simpan'     => date('Y-m-d H:i:s'),
                    'satuanTerkecil' => $satKcl,
                    'satuanBesar'    => $satBsr,
                    'jml'            => $jml,
                    'status'         => '1',
                );
                
                try {
                    if (check_form_submitted($this->input->post('form_id'))) {
                        $this->session->set_flashdata('master_toast', 'toastr.warning("Form sudah disubmit sebelumnya");');
                        redirect(base_url('master/data_satuan_list.php'));
                        return;
                    }
                    
                    if (!crud::simpan('tbl_m_satuan', $data_penj)) {
                        $this->session->set_flashdata('master_toast', 'toastr.error("Gagal menyimpan data satuan");');
                        throw new Exception("Gagal menyimpan data satuan");
                    }
                    
                    $this->session->set_flashdata('master_toast', 'toastr.success("Data satuan berhasil disimpan");');
                    
                    $aid = crud::last_id();
                    
                    if(!empty($tipe)){
                        crud::update('tbl_m_satuan','id',$aid,array('id_sub'=>$aid));
                        redirect(base_url('master/data_satuan_tambah.php?id='.general::enkrip($aid)));
                    }else{
                        redirect(base_url('master/data_satuan_list.php'));
                    }
                } catch (Exception $e) {
                    $this->session->set_flashdata('master_toast', 'toastr.error("' . $e->getMessage() . '");');
                    redirect(base_url('master/data_satuan_tambah.php?id='.$id));
                    return;
                }
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
       
    public function data_satuan_update() {
        if (Akses::aksesLogin() == TRUE) {
            $id      = $this->input->post('id');
            $satKcl  = $this->input->post('satKcl');
            $satBsr  = $this->input->post('satBsr');
            $jml     = $this->input->post('jml');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('satKcl', 'Satuan Terkecil', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'satKcl'     => form_error('satKcl'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                $this->session->set_flashdata('master_toast', 'toastr.error("Validasi form gagal, silahkan periksa kembali.");');
                redirect(base_url('master/data_satuan_tambah.php?id='.$id));
            } else {                
                $sql_num = $this->db->where('id', general::dekrip($id))->get('tbl_m_satuan')->row();
                
                $data_penj = array(
                    'tgl_modif'      => date('Y-m-d H:i:s'),
                    'satuanTerkecil' => $satKcl,
                    'satuanBesar'    => $satBsr,
                    'jml'            => $jml
                );
                
                try {
                    if (check_form_submitted($this->input->post('form_id'))) {
                        $this->session->set_flashdata('master_toast', 'toastr.warning("Form sudah disubmit sebelumnya");');
                        redirect(base_url('master/data_satuan_list.php'));
                        return;
                    }
                    
                    if (!crud::update('tbl_m_satuan', 'id', general::dekrip($id), $data_penj)) {
                        $this->session->set_flashdata('master_toast', 'toastr.error("Gagal mengubah data satuan");');
                        throw new Exception("Gagal mengubah data satuan");
                    }
                    
                    crud::update('tbl_m_produk_satuan','id_satuan', general::dekrip($id), array('satuan'=>$satKcl, 'jml'=>$sql_num->jml));
                    
                    $this->session->set_flashdata('master_toast', 'toastr.success("Data satuan berhasil diubah");');
                } catch (Exception $e) {
                    $this->session->set_flashdata('master_toast', 'toastr.error("' . $e->getMessage() . '");');
                    redirect(base_url('master/data_satuan_tambah.php?id='.$id));
                    return;
                }
                redirect(base_url('master/data_satuan_list.php'));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_satuan_hapus() {
        if (Akses::aksesLogin() == TRUE) {
            try {
                $id = $this->input->get('id');
                
                if(!empty($id)){
                    // Check if satuan is used in products
                    $satuan_id = general::dekrip($id);
                    $used_in_products = $this->db->where('id_satuan', $satuan_id)->get('tbl_m_produk')->num_rows();
                    
                    if($used_in_products > 0) {
                        $this->session->set_flashdata('master_toast', 'toastr.error("Satuan tidak dapat dihapus karena masih digunakan dalam data produk");');
                    } else {
                        crud::delete('tbl_m_satuan','id', $satuan_id);
                        $this->session->set_flashdata('master_toast', 'toastr.success("Data satuan berhasil dihapus");');
                    }
                }
                
                redirect(base_url('master/data_satuan_list.php'));
            } catch (Exception $e) {
                $this->session->set_flashdata('master_toast', 'toastr.error("Terjadi kesalahan: '.$e->getMessage().'");');
                redirect(base_url('master/data_satuan_list.php'));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
        
    public function data_barang_list() {
        if (Akses::aksesLogin() == TRUE) {
            $hal             = $this->input->get('halaman');
            $filter_kode     = $this->input->get('filter_kode');
            $filter_merk     = $this->input->get('filter_merk');
            $filter_lokasi   = $this->input->get('filter_lokasi');
            $filter_kat      = $this->input->get('filter_kategori');
            $filter_produk   = $this->input->get('filter_produk');
            $filter_hpp      = $this->input->get('filter_hpp');
            $filter_harga    = $this->input->get('filter_harga');
            $filter_stok     = $this->input->get('filter_stok');
            $filter_brcd     = $this->input->get('filter_barcode');
            $filter_status   = $this->input->get('filter_status');
            $sort_type       = $this->input->get('sort_type');
            $sort_order      = $this->input->get('sort_order');
            $jml             = $this->input->get('jml');
            $jml_hal         = (!empty($jml) ? $jml  : $this->db->count_all('tbl_m_produk'));
            $pengaturan      = $this->db->get('tbl_pengaturan')->row();
            
            $data['hasError'] = $this->session->flashdata('form_error');
                        
            $config['base_url']              = base_url('master/data_barang_list.php?'.(!empty($filter_kode) ? '&filter_kode='.$filter_kode : '').(!empty($filter_kat) ? '&filter_kategori='.$filter_kat : '').(!empty($filter_brcd) ? '&filter_barcode='.$filter_brcd : '').(!empty($filter_merk) ? '&filter_merk='.$filter_merk : '').(!empty($filter_lokasi) ? '&filter_lokasi='.$filter_lokasi : '').(!empty($filter_produk) ? '&filter_produk='.$filter_produk : '').(!empty($filter_hpp) ? '&filter_hpp='.$filter_hpp : '').(!empty($filter_harga) ? '&filter_harga='.$filter_harga : '').(!empty($sort_order) ? '&sort_order='.$sort_order : '').(!empty($jml) ? '&jml='.$jml : ''));
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
            
//            $where = "(tbl_m_produk.kode LIKE '%".$filter_kode."%' OR tbl_m_produk.barcode LIKE '%".$filter_kode."%')";
            $where = "MATCH(tbl_m_produk.produk) AGAINST('".$filter_produk."')";

            if(!empty($hal)){
                if (!empty($jml)) {
                    $data['barang'] = $this->db->limit($config['per_page'],$hal)
                                               ->where('status_hps', '0')
                                                   ->where("(tbl_m_produk.produk LIKE '%".$filter_produk."%' OR tbl_m_produk.produk_alias LIKE '%".$filter_produk."%' OR tbl_m_produk.produk_kand LIKE '%".$filter_produk."%' OR tbl_m_produk.kode LIKE '%".$filter_produk."%')")
//                                                   ->like('kode', $filter_kode)
//                                                   ->like('barcode', $filter_brcd, (!empty($filter_brcd) ? 'none' : ''))
//                                                   ->like('produk', $filter_produk)
                                                   ->like('harga_jual', $filter_harga, (!empty($filter_harga) ? 'after' : ''))
                                                   ->like('id_merk', $filter_merk, (!empty($filter_merk) ? 'none' : ''))
                                                   ->like('id_kategori', $filter_kat, (!empty($filter_kat) ? 'none' : ''))
                                                   ->like('status_subt', $filter_stok, ($filter_stok !='' ? 'none' : ''))
                                               ->order_by(!empty($sort_type) ? $sort_type : 'produk', (!empty($sort_order) ? $sort_order : 'asc'))
                                               ->get('tbl_m_produk')->result();
                } else {
                    $data['barang'] = $this->db->where('status_hps', '0')->limit($config['per_page'],$hal)->order_by('produk', (!empty($sort_order) ? $sort_order : 'asc'))->get('tbl_m_produk')->result();
                }
            }else{
                if (!empty($jml)) {
                    $data['barang'] = $this->db->limit($config['per_page'],$hal)
                                               ->where('status_hps', '0')
                                                   ->where("(tbl_m_produk.produk LIKE '%".$filter_produk."%' OR tbl_m_produk.produk_alias LIKE '%".$filter_produk."%' OR tbl_m_produk.produk_kand LIKE '%".$filter_produk."%' OR tbl_m_produk.kode LIKE '%".$filter_produk."%')")
//                                                   ->like('kode', $filter_kode)
//                                                   ->like('barcode', $filter_brcd, 'none')
//                                                   ->like('produk', $filter_produk)
                                                   ->like('harga_jual', $filter_harga, (!empty($filter_harga) ? 'after' : ''))
                                                   ->like('id_merk', $filter_merk, (!empty($filter_merk) ? 'none' : ''))
                                                   ->like('id_kategori', $filter_kat, (!empty($filter_kat) ? 'none' : ''))
                                                   ->like('status_subt', $filter_stok, ($filter_stok !='' ? 'none' : ''))
                                               ->order_by(!empty($sort_type) ? $sort_type : 'produk', (!empty($sort_order) ? $sort_order : 'asc'))
                                               ->get('tbl_m_produk')->result();
                } else {
                    $data['barang'] = $this->db->where('status_hps', '0')->limit($config['per_page'])
                                               ->order_by(!empty($sort_type) ? $sort_type : 'produk', (!empty($sort_order) ? $sort_order : 'asc'))
//                                               ->order_by(!empty($sort_type) ? $sort_type : 'id', (isset($sort_order) ? $sort_order : 'desc'))
                                               ->get('tbl_m_produk')->result();
                }
            }
            
            $this->pagination->initialize($config);
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/master/sidebar_item';
            /* --- Sidebar Menu --- */
            
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();
            $data['cetak']      = '<button type="button" onclick="window.location.href = \''.base_url('master/cetak_data_barang.php?'.(!empty($filter_kode) ? 'filter_kode='.$filter_kode : '').(!empty($filter_merk) ? '&filter_merk='.$filter_merk : '').(!empty($filter_lokasi) ? '&filter_lokasi='.$filter_lokasi : '').(!empty($filter_produk) ? '&filter_produk='.$filter_produk : '').(!empty($filter_hpp) ? '&filter_hpp='.$filter_hpp : '').(!empty($filter_harga) ? '&filter_harga='.$filter_harga : '').(!empty($jml) ? '&jml='.$jml : '')).'\'" class="btn btn-warning btn-flat"><i class="fa fa-print"></i> Cetak</button>';

            $data['sql_kats']   = $this->db->where('status', '1')->where('status_lab', '0')->get('tbl_m_kategori')->result();
            
            
            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/master/data_item_list', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
        
    public function data_barang_list_arsip() {
        if (Akses::aksesLogin() == TRUE) {
            $hal             = $this->input->get('halaman');
            $filter_kode     = $this->input->get('filter_kode');
            $filter_merk     = $this->input->get('filter_merk');
            $filter_lokasi   = $this->input->get('filter_lokasi');
            $filter_kat      = $this->input->get('filter_kategori');
            $filter_produk   = $this->input->get('filter_produk');
            $filter_hpp      = $this->input->get('filter_hpp');
            $filter_harga    = $this->input->get('filter_harga');
            $filter_stok     = $this->input->get('filter_stok');
            $filter_brcd     = $this->input->get('filter_barcode');
            $filter_status   = $this->input->get('filter_status');
            $sort_type       = $this->input->get('sort_type');
            $sort_order      = $this->input->get('sort_order');
            $jml             = $this->input->get('jml');
            $jml_hal         = (!empty($jml) ? $jml  : $this->db->count_all('tbl_m_produk'));
            $pengaturan      = $this->db->get('tbl_pengaturan')->row();
            
            $data['hasError'] = $this->session->flashdata('form_error');
                        
            $config['base_url']              = base_url('master/data_barang_list_arsip.php?'.(!empty($filter_kode) ? '&filter_kode='.$filter_kode : '').(!empty($filter_kat) ? '&filter_kategori='.$filter_kat : '').(!empty($filter_brcd) ? '&filter_barcode='.$filter_brcd : '').(!empty($filter_merk) ? '&filter_merk='.$filter_merk : '').(!empty($filter_lokasi) ? '&filter_lokasi='.$filter_lokasi : '').(!empty($filter_produk) ? '&filter_produk='.$filter_produk : '').(!empty($filter_hpp) ? '&filter_hpp='.$filter_hpp : '').(!empty($filter_harga) ? '&filter_harga='.$filter_harga : '').(!empty($sort_order) ? '&sort_order='.$sort_order : '').(!empty($jml) ? '&jml='.$jml : ''));
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
            
//            $where = "(tbl_m_produk.kode LIKE '%".$filter_kode."%' OR tbl_m_produk.barcode LIKE '%".$filter_kode."%')";
            $where = "MATCH(tbl_m_produk.produk) AGAINST('".$filter_produk."')";

            if(!empty($hal)){
                if (!empty($jml)) {
                    $data['barang'] = $this->db->limit($config['per_page'],$hal)
                                               ->where('status_hps', '1')
                                                   ->where("(tbl_m_produk.produk LIKE '%".$filter_produk."%' OR tbl_m_produk.produk_alias LIKE '%".$filter_produk."%' OR tbl_m_produk.produk_kand LIKE '%".$filter_produk."%' OR tbl_m_produk.kode LIKE '%".$filter_produk."%')")
//                                                   ->like('kode', $filter_kode)
//                                                   ->like('barcode', $filter_brcd, (!empty($filter_brcd) ? 'none' : ''))
//                                                   ->like('produk', $filter_produk)
                                                   ->like('harga_jual', $filter_harga, (!empty($filter_harga) ? 'after' : ''))
                                                   ->like('id_merk', $filter_merk, (!empty($filter_merk) ? 'none' : ''))
                                                   ->like('id_kategori', $filter_kat, (!empty($filter_kat) ? 'none' : ''))
                                                   ->like('status_subt', $filter_stok, ($filter_stok !='' ? 'none' : ''))
                                               ->order_by(!empty($sort_type) ? $sort_type : 'produk', (!empty($sort_order) ? $sort_order : 'asc'))
                                               ->get('tbl_m_produk')->result();
                } else {
                    $data['barang'] = $this->db->where('status_hps', '1')->limit($config['per_page'],$hal)->order_by('produk', (!empty($sort_order) ? $sort_order : 'asc'))->get('tbl_m_produk')->result();
                }
            }else{
                if (!empty($jml)) {
                    $data['barang'] = $this->db->limit($config['per_page'],$hal)
                                               ->where('status_hps', '1')
                                                   ->where("(tbl_m_produk.produk LIKE '%".$filter_produk."%' OR tbl_m_produk.produk_alias LIKE '%".$filter_produk."%' OR tbl_m_produk.produk_kand LIKE '%".$filter_produk."%' OR tbl_m_produk.kode LIKE '%".$filter_produk."%')")
//                                                   ->like('kode', $filter_kode)
//                                                   ->like('barcode', $filter_brcd, 'none')
//                                                   ->like('produk', $filter_produk)
                                                   ->like('harga_jual', $filter_harga, (!empty($filter_harga) ? 'after' : ''))
                                                   ->like('id_merk', $filter_merk, (!empty($filter_merk) ? 'none' : ''))
                                                   ->like('id_kategori', $filter_kat, (!empty($filter_kat) ? 'none' : ''))
                                                   ->like('status_subt', $filter_stok, ($filter_stok !='' ? 'none' : ''))
                                               ->order_by(!empty($sort_type) ? $sort_type : 'produk', (!empty($sort_order) ? $sort_order : 'asc'))
                                               ->get('tbl_m_produk')->result();
                } else {
                    $data['barang'] = $this->db->where('status_hps', '1')->limit($config['per_page'])
                                               ->order_by(!empty($sort_type) ? $sort_type : 'produk', (!empty($sort_order) ? $sort_order : 'asc'))
//                                               ->order_by(!empty($sort_type) ? $sort_type : 'id', (isset($sort_order) ? $sort_order : 'desc'))
                                               ->get('tbl_m_produk')->result();
                }
            }
            
//            $data['barang_jml'] = $this->db->where('status_hps', '1')->get('tbl_m_produk')->num_rows();
            
            $this->pagination->initialize($config);
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/master/sidebar_item';
            /* --- Sidebar Menu --- */
            
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();
            $data['cetak']      = '<button type="button" onclick="window.location.href = \''.base_url('master/cetak_data_barang.php?'.(!empty($filter_kode) ? 'filter_kode='.$filter_kode : '').(!empty($filter_merk) ? '&filter_merk='.$filter_merk : '').(!empty($filter_lokasi) ? '&filter_lokasi='.$filter_lokasi : '').(!empty($filter_produk) ? '&filter_produk='.$filter_produk : '').(!empty($filter_hpp) ? '&filter_hpp='.$filter_hpp : '').(!empty($filter_harga) ? '&filter_harga='.$filter_harga : '').(!empty($jml) ? '&jml='.$jml : '')).'\'" class="btn btn-warning btn-flat"><i class="fa fa-print"></i> Cetak</button>';

            $data['sql_kats']   = $this->db->where('status', '1')->where('status_lab', '0')->get('tbl_m_kategori')->result();
            
            
            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/master/data_item_list_arsip', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
        
    public function data_barang_list_retbeli() {
        if (Akses::aksesLogin() == TRUE) {
            $hal             = $this->input->get('halaman');
            $filter_nota     = $this->input->get('filter_nota');
            $filter_produk   = $this->input->get('filter_produk');
            $filter_tgl      = $this->input->get('filter_hpp');
            $jml                = $this->input->get('jml');
            
            
            /* Nota beli by suppllier */
            $data['sess_beli']  = $this->session->userdata('trans_retur_beli_m');
            $data['sess_rute']  = $this->session->userdata('trans_retur_beli_m_rute');
            $data['supplier']   = $this->db->where('id', $data['sess_beli']['id_supplier'])->get('tbl_m_supplier')->row();
            /* -- END -- */
            
            $jml_hal            = (!empty($jml) ? $jml  : $this->db->join('tbl_trans_beli', 'tbl_trans_beli.id=tbl_trans_beli_det.id_pembelian')->where('tbl_trans_beli.id_supplier', $data['sess_beli']['id_supplier'])->get('tbl_trans_beli_det')->num_rows());
            $pengaturan         = $this->db->get('tbl_pengaturan')->row();
            
            $data['hasError']   = $this->session->flashdata('form_error');
                        
            $config['base_url']               = base_url('master/data_barang_list_retur_beli.php?'.(!empty($data['sess_beli']['sess_id']) ? 'nota='.$data['sess_beli']['sess_id'] : '').(!empty($data['sess_beli']['id_supplier']) ? '&supp='.general::enkrip($data['sess_beli']['id_supplier']) : '').(!empty($jml) ? '&jml='.$jml : '').(!empty($data['sess_beli']['route']) ? '&route='.$data['sess_beli']['route'] : ''));
            $config['total_rows']             = $jml_hal;
            
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
            
//            $where = "(tbl_m_produk.kode LIKE '%".$filter_kode."%' OR tbl_m_produk.barcode LIKE '%".$filter_kode."%')";
            $where = "MATCH(tbl_m_produk.produk) AGAINST('".$filter_produk."')";

            if(!empty($hal)){
                if (!empty($jml)) {
                    $data['barang'] = $this->db->select('tbl_trans_beli.no_nota, tbl_trans_beli.tgl_masuk, tbl_trans_beli.status_bayar, tbl_trans_beli_det.id, tbl_trans_beli_det.id_produk, tbl_trans_beli_det.id_pembelian, tbl_trans_beli_det.produk, tbl_trans_beli_det.jml, tbl_trans_beli_det.jml_satuan, tbl_trans_beli_det.satuan, tbl_trans_beli_det.harga')
                                               ->limit($config['per_page'], $hal)
                                               ->join('tbl_trans_beli', 'tbl_trans_beli.id=tbl_trans_beli_det.id_pembelian')
                                               ->where('tbl_trans_beli.id_supplier', $data['sess_beli']['id_supplier'])
//                                               ->where('tbl_trans_beli.status_bayar', '0')
                                               ->like('tbl_trans_beli.no_nota', $filter_nota)
                                               ->like('DATE(tbl_trans_beli.tgl_masuk)', $this->tanggalan->tgl_indo_sys($filter_tgl))
                                               ->like('tbl_trans_beli_det.produk', $filter_produk)
                                               ->order_by(!empty($sort_type) ? $sort_type : 'tbl_trans_beli.id', (isset($sort_order) ? $sort_order : 'desc'))
                                               ->get('tbl_trans_beli_det')->result();
                } else {
                    $data['barang'] = $this->db->select('tbl_trans_beli.no_nota, tbl_trans_beli.tgl_masuk, tbl_trans_beli.status_bayar, tbl_trans_beli_det.id, tbl_trans_beli_det.id_produk, tbl_trans_beli_det.id_pembelian, tbl_trans_beli_det.produk, tbl_trans_beli_det.jml, tbl_trans_beli_det.jml_satuan, tbl_trans_beli_det.satuan, tbl_trans_beli_det.harga')
                                               ->limit($config['per_page'], $hal)
                                               ->join('tbl_trans_beli', 'tbl_trans_beli.id=tbl_trans_beli_det.id_pembelian')
                                               ->where('tbl_trans_beli.id_supplier', $data['sess_beli']['id_supplier'])
//                                               ->where('tbl_trans_beli.status_bayar', '0')
                                               ->like('tbl_trans_beli.no_nota', $filter_nota)
                                               ->like('DATE(tbl_trans_beli.tgl_masuk)', $this->tanggalan->tgl_indo_sys($filter_tgl))
                                               ->like('tbl_trans_beli_det.produk', $filter_produk)
                                               ->order_by(!empty($sort_type) ? $sort_type : 'tbl_trans_beli.id', (isset($sort_order) ? $sort_order : 'desc'))
                                               ->get('tbl_trans_beli_det')->result();
                }
            }else{
                if (!empty($jml)) {
                    $data['barang'] = $this->db->select('tbl_trans_beli.no_nota, tbl_trans_beli.tgl_masuk, tbl_trans_beli.status_bayar, tbl_trans_beli_det.id, tbl_trans_beli_det.id_produk, tbl_trans_beli_det.id_pembelian, tbl_trans_beli_det.produk, tbl_trans_beli_det.jml, tbl_trans_beli_det.jml_satuan, tbl_trans_beli_det.satuan, tbl_trans_beli_det.harga')
                                               ->limit($config['per_page'])
                                               ->join('tbl_trans_beli', 'tbl_trans_beli.id=tbl_trans_beli_det.id_pembelian')
                                               ->where('tbl_trans_beli.id_supplier', $data['sess_beli']['id_supplier'])
//                                               ->where('tbl_trans_beli.status_bayar', '0')
                                               ->like('tbl_trans_beli.no_nota', $filter_nota)
                                               ->like('DATE(tbl_trans_beli.tgl_masuk)', $this->tanggalan->tgl_indo_sys($filter_tgl))
                                               ->like('tbl_trans_beli_det.produk', $filter_produk)
                                               ->order_by(!empty($sort_type) ? $sort_type : 'tbl_trans_beli.id', (isset($sort_order) ? $sort_order : 'desc'))
                                               ->get('tbl_trans_beli_det')->result();
                } else {
                    $data['barang'] = $this->db->select('tbl_trans_beli.no_nota, tbl_trans_beli.tgl_masuk, tbl_trans_beli.status_bayar, tbl_trans_beli_det.id, tbl_trans_beli_det.produk, tbl_trans_beli_det.jml, tbl_trans_beli_det.jml_satuan, tbl_trans_beli_det.satuan, tbl_trans_beli_det.harga')
                                               ->limit($config['per_page'])
                                               ->join('tbl_trans_beli', 'tbl_trans_beli.id=tbl_trans_beli_det.id_pembelian')
                                               ->where('tbl_trans_beli.id_supplier', $data['sess_beli']['id_supplier'])
//                                               ->where('tbl_trans_beli.status_bayar', '0')
                                               ->like('tbl_trans_beli.no_nota', $filter_nota)
                                               ->like('tbl_trans_beli_det.produk', $filter_produk)
                                               ->like('tbl_trans_beli.tgl_masuk', $this->tanggalan->tgl_indo_sys($filter_tgl))
                                               ->order_by(!empty($sort_type) ? $sort_type : 'tbl_trans_beli.id', (isset($sort_order) ? $sort_order : 'desc'))
                                               ->get('tbl_trans_beli_det')->result();
                }
            }
            
            $this->pagination->initialize($config);
            
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();
            
//            $data['cetak']      = '<button type="button" onclick="window.location.href = \''.base_url('master/cetak_data_barang.php?'.(!empty($filter_kode) ? 'filter_kode='.$filter_kode : '').(!empty($filter_merk) ? '&filter_merk='.$filter_merk : '').(!empty($filter_lokasi) ? '&filter_lokasi='.$filter_lokasi : '').(!empty($filter_produk) ? '&filter_produk='.$filter_produk : '').(!empty($filter_hpp) ? '&filter_hpp='.$filter_hpp : '').(!empty($filter_harga) ? '&filter_harga='.$filter_harga : '').(!empty($jml) ? '&jml='.$jml : '')).'\'" class="btn btn-warning btn-flat"><i class="fa fa-print"></i> Cetak</button>';

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
//            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/master/data_barang_list_retbeli', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_barang_tambah() {
        if (Akses::aksesLogin() == TRUE) {
            $id                  = $this->input->get('id');
            $lab                 = $this->input->get('id_item_lab');
            $lab_ref             = $this->input->get('ref');

            $sql_brg             = $this->db->get('tbl_m_produk')->row();
            $sql_brg_kode        = $this->db->select_max('id')->get('tbl_m_produk')->row();
            $sql_brg_sat         = $this->db->where('id_produk', general::dekrip($id))->get('tbl_m_produk_satuan')->num_rows();
            $sql_brg_satm        = $this->db->get('tbl_m_satuan')->num_rows();
            $kodebar             = $sql_brg_kode->id + 1;
            
            $data['kode']        = (!empty($id) ? general::dekrip($id) : $kodebar);
            $data['barang']      = $this->db->where('id', general::dekrip($id))->get('tbl_m_produk')->row();
            $data['barang_nom']  = $this->db->where('id_produk', general::dekrip($id))->get('tbl_m_produk_nominal')->result();
            $data['barang_stk']  = $this->db->select('SUM(jml * jml_satuan) AS jml')->where('id_produk', $data['barang']->id)->get('tbl_m_produk_stok')->row();
            $data['barang_bom_rw'] = $this->db->where('id', general::dekrip($lab))->get('tbl_m_produk')->row();
            $data['barang_bom_rs'] = $this->db->where('id_produk', general::dekrip($id))->get('tbl_m_produk_ref')->result();
            $data['barang_bom_ip'] = $this->db->where('id_produk', general::dekrip($id))->get('tbl_m_produk_ref_input')->result();
            $data['barang_bom_ip2']= $this->db->where('id', general::dekrip($lab_ref))->get('tbl_m_produk_ref_input')->row();
            
            if($sql_brg_sat != $sql_brg_satm){
                $data['barang_sat']  = $this->db->select('id, satuanTerkecil as satuan, status')->get('tbl_m_satuan')->result();
            }else{
                $data['barang_sat']  = $this->db->where('id_produk', general::dekrip($id))->order_by('id_satuan', 'asc')->get('tbl_m_produk_satuan')->result();
            }
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/master/sidebar_item';
            /* --- Sidebar Menu --- */
            
            $data['barang_sat2'] = $this->db->where('id', $data['barang']->id_satuan)->get('tbl_m_satuan')->row();
            $data['barang_dep']  = $this->db->select('DATE(tgl_simpan) as tgl_simpan, id, id_produk, keterangan, harga, debet, kredit, saldo, status')->where('id_produk', general::dekrip($id))->get('tbl_m_produk_deposit')->result();
            $data['barang_log']  = $this->db->select('DATE(tgl_simpan) as tgl_simpan, jml, harga, satuan, keterangan')->where('id_produk', general::dekrip($id))->get('tbl_m_produk_saldo')->result();
            $data['sql_satuan']  = $this->db->order_by('satuanTerkecil', 'asc')->get('tbl_m_satuan')->result();
            $data['sql_merk']    = $this->db->order_by('merk', 'asc')->get('tbl_m_merk')->result();
            $data['sql_lokasi']  = $this->db->order_by('lokasi', 'asc')->get('tbl_m_poli')->result();
            $data['sql_kat']     = $this->db->where('status_lab', '0')->order_by('kategori', 'asc')->get('tbl_m_kategori')->result();
            $data['sql_kat_lab'] = $this->db->where('status_lab', '1')->order_by('kategori', 'asc')->get('tbl_m_kategori')->result();

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/master/data_item_tambah', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_barang_det() {
        if (Akses::aksesLogin() == TRUE) {
            $id   = $this->input->get('id');
            
            $data['barang']     = $this->db->where('id', general::dekrip($id))->get('tbl_m_produk')->row();
            $data['barang_stk'] = $this->db->select('SUM(jml * jml_satuan) AS jml')->where('id_produk', $data['barang']->id)->get('tbl_m_produk_stok')->row();
            $data['satuan']     = $this->db->get('tbl_m_satuan')->result();
            $data['kategori']   = $this->db->get('tbl_m_kategori')->result();
            $data['merk']       = $this->db->get('tbl_m_merk')->result();
            $data['lokasi']     = $this->db->get('tbl_m_poli')->result();

            $sql_brg_sat        = $this->db->where('id_produk', general::dekrip($id))->get('tbl_m_produk_satuan')->num_rows();
            $sql_brg_satm       = $this->db->get('tbl_m_satuan')->num_rows();
            
            if($sql_brg_sat != $sql_brg_satm){
                $data['barang_sat']  = $this->db->select('id, satuanTerkecil as satuan, status')->get('tbl_m_satuan')->result();
            }else{
                $data['barang_sat']  = $this->db->where('jml !=', '0')->where('id_produk', general::dekrip($id))->order_by('id_satuan', 'asc')->get('tbl_m_produk_satuan')->result();
            }

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
//            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/master/data_barang_detail', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_barang_import() {
        if (Akses::aksesLogin() == TRUE) {
            $id   = $this->input->get('id');
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/master/sidebar_item';
            /* --- Sidebar Menu --- */
            
            $data['barang_sat2'] = $this->db->where('id', $data['barang']->id_satuan)->get('tbl_m_satuan')->row();
            $data['barang_dep']  = $this->db->select('DATE(tgl_simpan) as tgl_simpan, id, id_produk, keterangan, harga, debet, kredit, saldo, status')->where('id_produk', general::dekrip($id))->get('tbl_m_produk_deposit')->result();
            $data['barang_log']  = $this->db->select('DATE(tgl_simpan) as tgl_simpan, jml, harga, satuan, keterangan')->where('id_produk', general::dekrip($id))->get('tbl_m_produk_saldo')->result();
            $data['sql_satuan']  = $this->db->order_by('satuanTerkecil', 'asc')->get('tbl_m_satuan')->result();
            $data['sql_merk']    = $this->db->order_by('merk', 'asc')->get('tbl_m_merk')->result();
            $data['sql_lokasi']  = $this->db->order_by('lokasi', 'asc')->get('tbl_m_poli')->result();
            $data['kategori']    = $this->db->order_by('kategori', 'asc')->get('tbl_m_kategori')->result();

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/master/data_item_import', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_barang_upload() {
        if (Akses::aksesLogin() == TRUE) {
            $this->load->helper('file');
            
            if (!empty($_FILES['fupload']['name'])) {
                $folder = realpath('file/import');
                $config['upload_path']      = './file/import';
                $config['allowed_types']    = 'xls|xlsx';
                $config['remove_spaces']    = TRUE;
                $config['overwrite']        = TRUE;
                $this->load->library('upload', $config);
                
                if (!$this->upload->do_upload('fupload')) {
                    $this->session->set_flashdata('pengaturan', 'Error : <b>' . $this->upload->display_errors() . '</b>.');
                    redirect(base_url('master/data_barang_import.php?err='.$this->upload->display_errors()));
                }else{
                    $f           = $this->upload->data();
                    $path        = realpath('./file/import') . '/';                    
                    $objPHPExcel = PHPExcel_IOFactory::load($path.$f['orig_name']);
                    $sql_satuan  = $this->db->get('tbl_m_satuan')->row();
                    
                    foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                        $worksheetTitle     = $worksheet->getTitle();
                        $highestRow         = $worksheet->getHighestRow();
                        $highestColumn      = $worksheet->getHighestColumn();
                        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
                        
                        for ($row = 2; $row <= $highestRow; ++ $row) {
                            $val=array();
                            
                            for ($col = 0; $col < $highestColumnIndex; ++$col) {
                                $cell = $worksheet->getCellByColumnAndRow($col, $row);
                                $val[] = $cell->getValue();
                            }
                            
                            $nomer = $row - 1;
                            
//                            if(!empty($val[1])){
                                $produk = array(
                                    'id_satuan'     => 7,
                                    'id_kategori'   => 4,
                                    'tgl_simpan'    => date('Y-m-d H:i:s'),
                                    'tgl_modif'     => date('Y-m-d H:i:s'),
                                    'kode'          => 'JS'.sprintf('%05d', $nomer),
                                    'barcode'       => $val[1],
                                    'produk'        => strtoupper($val[3]),
                                    'jml'           => ($val[4] < 0 ? 0 : $val[4]),
                                    'harga_beli'    => (!empty($val[5]) ? $val[5] : 0),
                                    'harga_jual'    => (!empty($val[6]) ? $val[6] : 0),
                                    'status'        => 2,
                                );
                                
                                crud::simpan('tbl_m_produk', $produk); 
//                                crud::update('tbl_m_produk','produk',$val[3], $produk);
//                                
//                                echo $row.br();
//                                echo '<pre>';
//                                print_r($produk);
//                                echo '</pre>';
//                                
//                                unset($produk);
//                            }                       
                        }
                    }
                    
                    unlink($path.$f['orig_name']);
                    redirect(base_url('master/data_barang_list.php'));
                }
            }  
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_barang_simpan() {
        if (Akses::aksesLogin() == TRUE) {
            $kategori = $this->input->post('kategori');
            $merk     = $this->input->post('merk');
            $lokasi   = $this->input->post('lokasi');
            $kode     = $this->input->post('kode');
            $kode_dpn = $this->input->post('kode_dpn');
            $kode_tgh = $this->input->post('kode_tgh');
            $kode_blk = $this->input->post('kode_blk');
            $barcode  = $this->input->post('barcode');
            $brg      = $this->input->post('barang');
            $brg_alias= $this->input->post('barang_alias');
            $brg_kand = $this->input->post('barang_kand');
            $jml      = $this->input->post('jml');
            $satuan   = $this->input->post('satuan');
            $stat_sub = $this->input->post('status_subt');
            $tipe     = $this->input->post('tipe');
            $tipe_rc  = $this->input->post('tipe_racikan');
            $harga_bl = $this->input->post('harga_beli');
            $harga_jl = $this->input->post('harga_jual');
            $harga_ht = $this->input->post('harga_jual_het');
            $harga_gr = $this->input->post('harga_grosir');
            $rem_tipe = $this->input->post('remun_tipe');
            $rem_perc = $this->input->post('remun_perc');
            $rem_nom  = $this->input->post('remun_nom');
            $aps_tipe = $this->input->post('apres_tipe');
            $aps_perc = $this->input->post('apres_perc');
            $aps_nom  = $this->input->post('apres_nom');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('kategori', 'Kategori', 'required');
            $this->form_validation->set_rules('kode', 'Kode', 'required');
            $this->form_validation->set_rules('barang', 'Item', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'kategori' => form_error('kategori'),
                    'kode'     => form_error('kode'),
                    'barang'   => form_error('barang'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url('master/data_barang_tambah.php'));
            } else {
                $kodebar = 'B' . sprintf("%010s", general::dekrip($id));
                $sql_sat = $this->db->where('id', $satuan)->get('tbl_m_satuan')->row();
                $sql_brg = $this->db->get('tbl_m_produk');
                $sql_kat = $this->db->where('id', $kategori)->get('tbl_m_kategori')->row();
                $sql_gdg = $this->db->get('tbl_m_gudang')->result();
                
                $kd_item = sprintf('%02d', $kategori).sprintf('%04d', $sql_brg->num_rows() + 1);

                $data = array(
                        'tgl_simpan'        => date('Y-m-d H:i:s'),
                        'id_kategori'       => (!empty($kategori) ? $kategori : 0),
                        'id_merk'           => (!empty($merk) ? $merk : 0),
                        'id_satuan'         => (!empty($satuan) ? $satuan : 0),
                        'id_user'           => $this->ion_auth->user()->row()->id,
                        'kode'              => $kd_item,
                        'barcode'           => (!empty($barcode) ? $barcode : '899'.sprintf("%07s",$kode_blk)),
                        'produk'            => trim($brg),                     
                        'produk_alias'      => trim($brg_alias),                    
                        'produk_kand'       => trim($brg_kand),                
                        'jml'               => 0,                
                        'harga_beli'        => (!empty($harga_bl) ? general::format_angka_db($harga_bl) : 0),
                        'harga_jual'        => (!empty($harga_jl) ? general::format_angka_db($harga_jl) : 0),
                        'harga_jual'        => (!empty($harga_ht) ? general::format_angka_db($harga_ht) : 0),
                        'harga_grosir'      => (!empty($harga_gr) ? general::format_angka_db($harga_gr) : 0),
                        'remun_tipe'        => (!empty($rem_tipe) ? $rem_tipe : '0'),
                        'remun_nom'         => (!empty($rem_nom) ? $rem_nom : '0'),
                        'remun_perc'        => (!empty($rem_perc) ? $rem_perc : '0'),
                        'apres_tipe'        => (!empty($aps_tipe) ? $aps_tipe : '0'),
                        'apres_nom'         => (!empty($aps_nom) ? $aps_nom : '0'),
                        'apres_perc'        => (!empty($aps_perc) ? $aps_perc : '0'),
                        'status_subt'       => (!empty($stat_sub) ? $stat_sub : '0'),
                        'status_racikan'    => (!empty($tipe_rc) ? $tipe_rc : '0'),
                        'status'            => (!empty($tipe) ? $tipe : '0')
                    );
                    
                    $this->db->insert('tbl_m_produk', $data);
                    $last_id = crud::last_id();

                    if($last_id > 0){
                        if($stat_sub == '1'){
                            foreach ($sql_gdg as $gudang) {
                                $data_stok = array(
                                    'id_produk'     => $last_id,
                                    'id_satuan'     => $sql_sat->id,
                                    'id_gudang'     => $gudang->id,
                                    'tgl_simpan'    => date('Y-m-d H:i:s'),
                                    'jml'           => 0,
                                    'jml_satuan'    => $sql_sat->jml,
                                    'satuan'        => $sql_sat->satuanTerkecil,
                                    'satuanKecil'   => $sql_sat->satuanTerkecil,
                                    'status'        => $gudang->status,
                                );
                                
                                $this->db->insert('tbl_m_produk_stok', $data_stok);
                            }                          
                        }
                        
                        $this->session->set_flashdata('master', '<div class="alert alert-success">Data barang disimpan</div>');
                        redirect(base_url('master/data_barang_tambah.php?id='.general::enkrip($last_id)));
                    }else{
                        $this->session->set_flashdata('master', '<div class="alert alert-danger">Data Item Gagal Disimpan !!</div>');
                        redirect(base_url('master/data_barang_tambah.php'));
                    }     
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_barang_simpan_bom() {
        if (Akses::aksesLogin() == TRUE) {
            $id      = $this->input->post('id');
            $idp     = $this->input->post('item_id');
            $kode    = $this->input->post('kode');
            $ket     = $this->input->post('barang');
            $jml     = $this->input->post('jml');
            $sat     = $this->input->post('satuan');
            $harga_jl= general::format_angka_db($this->input->post('harga'));
            
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('item_id', 'ID Barang', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'item_id'         => form_error('item_id'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url('master/data_barang_tambah.php?id='.$id));
            } else {
                $sql         = $this->db->where('kode', $kode)->get('tbl_m_produk')->row();
                $sql_satuan  = $this->db->where('id', (!empty($sat) ? $sat : $sql->id_satuan))->get('tbl_m_satuan')->row();
                
                $data_penj = array(
                    'id_produk'         => general::dekrip($id),
                    'id_produk_item'    => (int)$sql->id,
                    'id_satuan'         => (int)$sql_satuan->id,
                    'tgl_simpan'        => date('Y-m-d H:i:s'),
                    'kode'              => $sql->kode,
                    'item'              => $sql->produk,
                    'harga'             => (float)$sql->harga_jual,      
                    'jml'               => (int)$jml,
                    'jml_satuan'        => (int)$sql_satuan->jml,
                    'satuan'            => $sql_satuan->satuanTerkecil,
                );
                
                $this->session->set_flashdata('master', '<div class="alert alert-success">Item lab berhasil di tambahkan</div>');
                crud::simpan('tbl_m_produk_ref', $data_penj);
                redirect(base_url('master/data_barang_tambah.php?id='.$id));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_barang_simpan_bom_input() {
        if (Akses::aksesLogin() == TRUE) {
            $id      = $this->input->post('id');
            $itm_nm  = $this->input->post('item_periksa');
            $itm_val = $this->input->post('item_nilai');
            $itm_l1  = $this->input->post('item_value_11');
            $itm_l2  = $this->input->post('item_value_12');
            $itm_p1  = $this->input->post('item_value_p1');
            $itm_p2  = $this->input->post('item_value_p2');
            $itm_sat = $this->input->post('item_satuan');
            
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id', 'ID Barang', 'required');
//            $this->form_validation->set_rules('item_periksa', 'Pemeriksaan', 'required');
//            $this->form_validation->set_rules('item_nilai', 'Nilai', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'id'            => form_error('id'),
//                    'item_periksa'  => form_error('item_periksa'),
//                    'item_nilai'    => form_error('item_nilai'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url('master/data_barang_tambah.php?id='.$id.'#item-ref-input'));
            } else {
                $sql         = $this->db->where('id', general::dekrip($id))->get('tbl_m_produk')->row();
                
                $data_penj = array(
                    'id_produk'         => (int)$sql->id,
                    'id_user'           => $this->ion_auth->user()->row()->id,
                    'tgl_simpan'        => date('Y-m-d H:i:s'),
                    'item_name'         => $itm_nm,
                    'item_value'        => $itm_val,
                    'item_value_l1'     => $itm_l1,
                    'item_value_l2'     => $itm_l2,
                    'item_value_p1'     => $itm_p1,
                    'item_value_p2'     => $itm_p2,
                    'item_satuan'       => $itm_sat,
                    'status'            => (int)$sql->status,
                );
                
                $this->session->set_flashdata('master', '<div class="alert alert-success">Item lab berhasil di tambahkan</div>');
                crud::simpan('tbl_m_produk_ref_input', $data_penj);
                redirect(base_url('master/data_barang_tambah.php?id='.$id.'#item-ref-input'));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_barang_simpan_nom() {
        if (Akses::aksesLogin() == TRUE) {
            $id      = $this->input->post('id');
            $ket     = $this->input->post('keterangan');
            $harga_nm= str_replace('.','',$this->input->post('nominal'));
            $harga_jl= str_replace('.','',$this->input->post('harga_jual'));
            
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id', 'ID Barang', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'id'     => form_error('id'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url('master/data_barang_tambah.php?id='.$id));
            } else {
                $jml_ppn = ($pengaturan->jml_ppn / 100) * $harga_jl;
                $hrg_ppn = $harga_jl + $jml_ppn;
                $hrg_dpp = $harga_jl;
                
                $data_penj = array(
                    'tgl_simpan'  => date('Y-m-d H:i:s'),
                    'id_produk'   => general::dekrip($id),
                    'keterangan'  => $ket,
                    'nominal'     => $harga_nm,
                    'harga'       => $harga_jl,
                );
                
                $this->session->set_flashdata('master', '<div class="alert alert-success">Data barang disimpan</div>');
                crud::simpan('tbl_m_produk_nominal', $data_penj);
                redirect(base_url('master/data_barang_tambah.php?id='.$id));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_barang_simpan_sat() {
        if (Akses::aksesLogin() == TRUE) {
            $id      = $this->input->post('id');
            $id_sat  = $this->input->post('id_sat');
            $sat     = $this->input->post('satuan');
            $jml     = $this->input->post('jml_satuan');
            $hrg     = str_replace('.','',$this->input->post('hrg_satuan'));
            
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id', 'ID Barang', 'required');

//            if ($this->form_validation->run() == FALSE) {
//                $msg_error = array(
//                    'id'     => form_error('id'),
//                );
//
//                $this->session->set_flashdata('form_error', $msg_error);
//                redirect(base_url('master/data_barang_tambah.php?id='.$id));
//            } else {                
                $sql_cek_sat  = $this->db->where('id_produk', general::dekrip($id))->get('tbl_m_produk_satuan')->num_rows();
                $sql_cek_satm = $this->db->get('tbl_m_satuan')->num_rows();
                
                $i = 0;
                foreach ($_POST['jml_satuan'] as $pos){ 
                    if($sql_cek_sat > 0){
                        $sql_sat_prd = $this->db->where('id', $_POST['id_sat'][$i])->get('tbl_m_produk_satuan')->row();
                        $sql_sat     = $this->db->where('id', $_POST['id_sat'][$i])->get('tbl_m_satuan')->row();
                        
                        if($sql_cek_sat != $sql_cek_satm){
                            $sql_sat_prd2 = $this->db->where('id_produk', general::dekrip($id))->where('id_satuan', $_POST['id_sat'][$i])->get('tbl_m_produk_satuan')->row();                            
                            
                            $data_satuan = array(
                                'id_produk'  => general::dekrip($id),
                                'id_satuan'  => $_POST['id_sat'][$i],
                                'satuan'     => (!empty($sql_sat_prd2->satuan) ? $sql_sat_prd2->satuan : $sql_sat->satuanTerkecil),
                                'jml'        => (!empty($_POST['jml_satuan'][$i]) ? $_POST['jml_satuan'][$i] : $sql_sat->jml), //(!empty($sql_sat_prd2->jml) ? $sql_sat_prd2->jml : $_POST['jml_satuan'][$i]),
                                'status'     => $sql_sat->status,
                            );
                            
                            
                            if(!isset($sql_sat_prd2->id)){                                
                                crud::simpan('tbl_m_produk_satuan', $data_satuan);
                            }else{
                                crud::update('tbl_m_produk_satuan', 'id', $sql_sat_prd2->id, $data_satuan);
                            }
                            
                        }else{
                            $data_satuan = array(
                                'jml'        => $_POST['jml_satuan'][$i],
                            );
                            
                            crud::update('tbl_m_produk_satuan', 'id', $sql_sat_prd->id, $data_satuan);                            
                        }
                    }else{
                        $sql_sat     = $this->db->where('id', $_POST['id_sat'][$i])->get('tbl_m_satuan')->row();
                    
                        $data_satuan = array(
                            'id_produk'  => general::dekrip($id),
                            'id_satuan'  => $_POST['id_sat'][$i],
                            'satuan'     => $sql_sat->satuanTerkecil,
                            'jml'        => (!empty($_POST['jml_satuan'][$i]) ? $_POST['jml_satuan'][$i] : $sql_sat->jml),
                            'status'     => $sql_sat->status,
                        );
                        
			            crud::simpan('tbl_m_produk_satuan', $data_satuan);
                    }
                    
                    $i++;
                }
                
                $this->session->set_flashdata('master', '<div class="alert alert-success">Data informasi satuan disimpan</div>');
                redirect(base_url('master/data_barang_tambah.php?id='.$id));
//            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_barang_simpan_hrg() {
        if (Akses::aksesLogin() == TRUE) {
            $id      = $this->input->post('id');
            $id_sat  = $this->input->post('id_sat');
            $sat     = $this->input->post('satuan');
            $jml     = $this->input->post('jml_satuan');
            $hrg     = str_replace('.','',$this->input->post('hrg_satuan'));
            
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id', 'ID Barang', 'required');

//            if ($this->form_validation->run() == FALSE) {
//                $msg_error = array(
//                    'id'     => form_error('id'),
//                );
//
//                $this->session->set_flashdata('form_error', $msg_error);
//                redirect(base_url('master/data_barang_tambah.php?id='.$id));
//            } else {                
                $sql_cek_prd  = $this->db->where('id', general::dekrip($id))->get('tbl_m_produk')->row();
                $sql_cek_sat  = $this->db->where('id_produk', general::dekrip($id))->get('tbl_m_produk_satuan')->num_rows();
                $sql_cek_satm = $this->db->get('tbl_m_satuan')->num_rows();
                
                $i = 0;
                foreach ($_POST['hrg_satuan'] as $pos){  
                    if($sql_cek_sat > 0){
                        $sql_sat_prd = $this->db->where('id', $_POST['id_sat'][$i])->get('tbl_m_produk_satuan')->row();
                        $sql_sat     = $this->db->where('id', $_POST['id_sat'][$i])->get('tbl_m_satuan')->row();
                        

                        if($sql_cek_sat != $sql_cek_satm){
                            $sql_sat_prd2 = $this->db->where('id_produk', general::dekrip($id))->where('id_satuan', $_POST['id_sat'][$i])->get('tbl_m_produk_satuan')->row();                            
                            
                            $data_satuan = array(
                                'id_produk'  => general::dekrip($id),
                                'id_satuan'  => $_POST['id_sat'][$i],
                                'satuan'     => (!empty($sql_sat_prd2->satuan) ? $sql_sat_prd2->satuan : $sql_sat->satuanTerkecil),
                                'harga'      => (!empty($_POST['hrg_satuan'][$i]) ? str_replace('.','',$_POST['hrg_satuan'][$i]) : $sql_sat->harga), //(!empty($sql_sat_prd2->jml) ? $sql_sat_prd2->jml : $_POST['jml_satuan'][$i]),
                                'status'     => $sql_sat->status,
                            );
                            
                            
                            if(!isset($sql_sat_prd2->id)){                                
                                crud::simpan('tbl_m_produk_satuan', $data_satuan);
                            }else{
                                crud::update('tbl_m_produk_satuan', 'id', $sql_sat_prd2->id, $data_satuan);
                            }
                            
                            if($_POST['id_sat'][$i] == 6){
                                crud::update('tbl_m_produk', 'id', general::dekrip($id), array('harga_grosir'=>str_replace('.','',$_POST['hrg_satuan'][$i])));
                            }
                        }else{
                            $data_satuan = array(
                                'harga'        => str_replace('.','',$_POST['hrg_satuan'][$i]),
                            );
                            
                            crud::update('tbl_m_produk_satuan', 'id', $sql_sat_prd->id, $data_satuan);                            
                        }
                    }else{
                        $sql_sat     = $this->db->where('id', $_POST['id_satm'][$i])->get('tbl_m_satuan')->row();
                        echo $_POST['id_sat'][$i];
                        echo '<pre>';
                        print_r($sql_sat);
                    
                        $data_satuan = array(
                            'id_produk'  => general::dekrip($id),
                            'id_satuan'  => $_POST['id_sat'][$i],
                            'satuan'     => $sql_sat->satuanTerkecil,
                            'jml'        => $sql_sat->jml,
                            'harga'      => (!empty($_POST['hrg_satuan'][$i]) ? str_replace('.','',$_POST['hrg_satuan'][$i]) : $sql_sat->harga),
                            'status'     => $sql_sat->status,
                        );
                        
                          crud::simpan('tbl_m_produk_satuan', $data_satuan);
                    }
                    
                    if($sql_sat_prd->id_satuan == $sql_cek_prd->id_satuan){
                        $data_hrg = array(
                            'harga_jual'    => str_replace('.','',$_POST['hrg_satuan'][$i]),
                            'id'            => $_POST['id_prod'][$i],
                            'tgl_modif'     => date('Y-m-d H:i:s')
                        );
                    }
                    
                    $i++;
                }
                
                $satm = 0;
                foreach ($_POST['id_satm'] as $pos_atm){
                    $sql_cr_sat  = $this->db->where('id', $_POST['id_sat'][$satm])->where('satuan', 'LUSIN')->get('tbl_m_produk_satuan');
                    $sql_cr_sat2 = $this->db->where('id_produk', $_POST['id_prod'][$satm])->where('satuan', 'SET')->get('tbl_m_produk_satuan')->row();
                    $sql_cr_sat3 = $this->db->where('id_produk', $_POST['id_prod'][$satm])->where('satuan', 'LUSIN (SET)')->get('tbl_m_produk_satuan')->row();
                    
                    if($sql_cr_sat->num_rows() > 0){                        
                        $hrg_satuan = array(
                            'harga'      => (float)$sql_cr_sat->row()->harga,
                            'jml'        => 12,
                        );
                        
//                        crud::update('tbl_m_produk_satuan', 'id', $sql_cr_sat2->id, $hrg_satuan);
//                        crud::update('tbl_m_produk_satuan', 'id', $sql_cr_sat3->id, $hrg_satuan);
                        crud::update('tbl_m_produk', 'id', $_POST['id_prod'][$satm], array('harga_grosir'=>(float)$sql_cr_sat->row()->harga));
                    }                   
                    $satm++;
                }
                
                
                crud::update('tbl_m_produk', 'id', $data_hrg['id'], $data_hrg);                
                $this->session->set_flashdata('master', '<div class="alert alert-success">Data informasi harga jual disimpan</div>');
                redirect(base_url('master/data_barang_tambah.php?id='.$id));
//            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_barang_update_bom_input() {
        if (Akses::aksesLogin() == TRUE) {
            $id      = $this->input->post('id');
            $itm_id  = $this->input->post('item_id');
            $itm_nm  = $this->input->post('item_periksa');
            $itm_val = $this->input->post('item_nilai');
            $itm_l1  = $this->input->post('item_value_11');
            $itm_l2  = $this->input->post('item_value_12');
            $itm_p1  = $this->input->post('item_value_p1');
            $itm_p2  = $this->input->post('item_value_p2');
            $itm_sat = $this->input->post('item_satuan');
            
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id', 'ID Barang', 'required');
//            $this->form_validation->set_rules('item_periksa', 'Pemeriksaan', 'required');
//            $this->form_validation->set_rules('item_nilai', 'Nilai', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'id'            => form_error('id'),
//                    'item_periksa'  => form_error('item_periksa'),
//                    'item_nilai'    => form_error('item_nilai'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url('master/data_barang_tambah.php?id='.$id.'#item-ref-input'));
            } else {
                $sql         = $this->db->where('id', general::dekrip($id))->get('tbl_m_produk')->row();
                
                $data_penj = array(
                    'item_name'         => $itm_nm,
                    'item_value'        => $itm_val,
                    'item_value_l1'     => $itm_l1,
                    'item_value_l2'     => $itm_l2,
                    'item_value_p1'     => $itm_p1,
                    'item_value_p2'     => $itm_p2,
                    'item_satuan'       => $itm_sat,
                    'status'            => (int)$sql->status,
                );
                
                $this->session->set_flashdata('master', '<div class="alert alert-success">Item lab berhasil di tambahkan</div>');
                crud::update('tbl_m_produk_ref_input', 'id', general::dekrip($itm_id), $data_penj);
                redirect(base_url('master/data_barang_tambah.php?id='.$id.'#item-ref-input'));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
        
    public function data_barang_update() {
        if (Akses::aksesLogin() == TRUE) {
            $id         = $this->input->post('id');
            $kat        = $this->input->post('kategori');
            $kat_lab    = $this->input->post('kategori_lab');
            $merk       = $this->input->post('merk');
            $lokasi     = $this->input->post('lokasi');
            $kode       = $this->input->post('kode');
            $kode_dpn   = $this->input->post('kode_dpn');
            $kode_tgh   = $this->input->post('kode_tgh');
            $kode_blk   = $this->input->post('kode_blk');
            $barcode    = $this->input->post('barcode');
            $brg        = $this->input->post('barang');
            $brg_alias  = $this->input->post('barang_alias');
            $brg_kand   = $this->input->post('barang_kand');
            $jml        = $this->input->post('jml');
            $jml_lmt    = $this->input->post('jml_limit');
            $satuan     = $this->input->post('satuan');
            $stat_subt  = $this->input->post('status_subt');
            $tipe       = $this->input->post('tipe');
            $tipe_et    = $this->input->post('tipe_etiket');
            $tipe_rc    = $this->input->post('tipe_racikan');
            $harga_bl   = $this->input->post('harga_beli');
            $harga_jl   = $this->input->post('harga_jual');
            $harga_ht   = $this->input->post('harga_jual_het');
            $harga_gr   = $this->input->post('harga_grosir');
            $rem_tipe   = $this->input->post('remun_tipe');
            $rem_perc   = $this->input->post('remun_perc');
            $rem_nom    = $this->input->post('remun_nom');
            $aps_tipe   = $this->input->post('apres_tipe');
            $aps_perc   = $this->input->post('apres_perc');
            $aps_nom    = $this->input->post('apres_nom');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('kode', 'Kode Barang', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'kode'     => form_error('kode'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url('master/data_barang_tambah.php?id='.$id));
            } else {
                $kodebar     = 'B'.sprintf("%010s", general::dekrip($id));
                $sql_brg     = $this->db->where('id', general::dekrip($id))->get('tbl_m_produk')->row();
                $sql_brg_sat = $this->db->where('id_produk', general::dekrip($id))->where('id_satuan', $satuan)->get('tbl_m_produk_satuan')->row();
                $kodebar = 'B' . sprintf("%010s", general::dekrip($id));
                
                $sql_sat = $this->db->where('id', $satuan)->get('tbl_m_satuan')->row();
                $sql_brg2= $this->db->get('tbl_m_produk');
                $sql_kat = $this->db->where('id', $kategori)->get('tbl_m_kategori')->row();
                $sql_gdg = $this->db->get('tbl_m_gudang')->result();
                
                $kd_item = $sql_kat->kategori.($sql_brg2->num_rows() + 1);
                
                $data_prod = array(
                    'tgl_modif'         => date('Y-m-d H:i:s'),
                    'id_kategori'       => (!empty($kat) ? $kat : 0),
                    'id_kategori_lab'   => (!empty($kat_lab) ? $kat_lab : 0),
                    'id_merk'           => (!empty($merk) ? $merk : 0),
                    'id_satuan'         => (!empty($satuan) ? $satuan : 0),
                    'kode'              => $kode,
                    'barcode'           => (!empty($barcode) ? $barcode : '899'.sprintf("%07s",$kode_blk)),
                    'produk'            => trim($brg),                     
                    'produk_alias'      => trim($brg_alias),                   
                    'produk_kand'       => trim($brg_kand),
                    'remun_tipe'        => (!empty($rem_tipe) ? $rem_tipe : '0'),
                    'remun_nom'         => (!empty($rem_nom) ? general::format_angka_db($rem_nom) : 0),
                    'remun_perc'        => (!empty($rem_perc) ? ($rem_perc != 'Infinity' ? general::format_angka_db($rem_perc) : 0) : 0),
                    'apres_tipe'        => (!empty($aps_tipe) ? $aps_tipe : '0'),
                    'apres_nom'         => (!empty($aps_nom) ? $aps_nom : '0'),
                    'apres_perc'        => (!empty($aps_perc) ? $aps_perc : '0'),
                    'harga_beli'        => (!empty($harga_bl) ? general::format_angka_db($harga_bl) : 0),
                    'harga_jual'        => (!empty($harga_jl) ? general::format_angka_db($harga_jl) : 0),
                    'harga_jual_het'    => (!empty($harga_ht) ? general::format_angka_db($harga_ht) : 0),
                    'jml_limit'         => (!empty($jml_lmt) ? $jml_lmt : '0'),
                    'status_subt'       => (!empty($stat_subt) ? $stat_subt : '0'),
                    'status_racikan'    => (!empty($tipe_rc) ? $tipe_rc : '0'),
                    'status_etiket'     => (!empty($tipe_et) ? $tipe_et : '0'),
                    'status'            => (!empty($tipe) ? $tipe : '0'),
                );
                
                $data_prod_jl = array(
                    'kode'              => $kode,
                    'produk'            => trim($brg),
                );
                
                $data_prod_hs = array(
                    'kode'              => $kode,
                    'produk'            => trim($brg),
                );
                
                if($stat_subt == '1'){
                    foreach ($sql_gdg as $gudang) {
                        $sql_brg_st  = $this->db->where('id_produk', $sql_brg->id)->where('id_gudang', $gudang->id)->get('tbl_m_produk_stok');
                        
                        $data_stok = array(
                            'id_produk'     => $sql_brg->id,
                            'id_satuan'     => $sql_sat->id,
                            'id_gudang'     => $gudang->id,
                            'tgl_simpan'    => date('Y-m-d H:i:s'),
//                            'jml'           => '0',
                            'jml_satuan'    => $sql_sat->jml,
                            'satuan'        => $sql_sat->satuanTerkecil,
                            'satuanKecil'   => $sql_sat->satuanTerkecil,
                            'status'        => $gudang->status,
                        );
                        
                        if($sql_brg_st->num_rows() == 0){
                            $this->db->insert('tbl_m_produk_stok', $data_stok);
                        }
                    }                          
                }
                
                # Update data kode, detail penjualan, pembelian, history
                $this->db->where('id_item', $sql_brg->id)->update('tbl_trans_medcheck_det', $data_prod_jl);
                $this->db->where('id_item', $sql_brg->id)->update('tbl_trans_jual_det', $data_prod_jl);
                $this->db->where('id_produk', $sql_brg->id)->update('tbl_trans_beli_po_det', $data_prod_jl);
                $this->db->where('id_produk', $sql_brg->id)->update('tbl_trans_beli_det', $data_prod_jl);
                $this->db->where('id_produk', $sql_brg->id)->update('tbl_m_produk_hist', $data_prod_hs);
                
                # Update data Produk
                $this->db->where('id', $sql_brg->id)->update('tbl_m_produk', $data_prod);
                
                # Sinkronkan dengan stok global
                $stok_glob = $this->db->select_sum('jml')->where('id_produk', $sql_brg->id)->get('tbl_m_produk_stok')->row();
                $this->db->where('id', $sql_brg->id)->update('tbl_m_produk', array('jml' => $stok_glob));
                
//                echo '<pre>';
//                print_r($data_prod_jl);
//                echo '</pre>';
//                echo '<pre>';
//                print_r($sql_brg_sat);
//                echo '</pre>';
                
                $this->session->set_flashdata('master', '<div class="alert alert-success">Data barang disimpan</div>');
                redirect(base_url('master/data_barang_tambah.php?id='.$id));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
       
    public function data_barang_hapus() {
        if (Akses::aksesLogin() == TRUE) {
            $id = $this->input->get('id');
            $pg = $this->input->get('halaman');
            
            if(!empty($id)){
                crud::delete('tbl_m_produk','id',general::dekrip($id));
            }
            
            redirect(base_url('master/data_barang_list.php?'.(!empty($pg) ? '&halaman='.$pg : '')));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
       
    public function data_barang_hapus_arsip() {
        if (Akses::aksesLogin() == TRUE) {
            $id         = $this->input->get('id');
            $rs         = $this->input->get('restore');
            $id_user    = $this->ion_auth->user()->row()->id; 
            
            if(!empty($id)){
               if($rs == '1'){
                   $this->db->where('id', general::dekrip($id))->update('tbl_m_produk', array('tgl_simpan_arsip'=>'0000-00-00 00:00:00','id_user_arsip'=>0,'status_hps'=>'0'));
               }else{
                   $this->db->where('id', general::dekrip($id))->update('tbl_m_produk', array('tgl_simpan_arsip'=>date('Y-m-d H:i:s'),'id_user_arsip'=>$id_user,'status_hps'=>'1'));
               }
            }
            
            redirect(base_url('master/data_barang_list.php?'.(!empty($pg) ? '&halaman='.$pg : '')));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_barang_hapus_nom() {
        if (Akses::aksesLogin() == TRUE) {
            $id = $this->input->get('id');
            $rf = $this->input->get('ref');
            
            if(!empty($id)){
                crud::delete('tbl_m_produk_nominal','id',general::dekrip($id));
            }
            
            redirect(base_url('master/data_barang_tambah.php?id='.$rf));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_barang_hapus_sat() {
        if (Akses::aksesLogin() == TRUE) {
            $id = $this->input->get('id');
            $rf = $this->input->get('ref');
            
            if(!empty($id)){
                crud::delete('tbl_m_produk_satuan','id',general::dekrip($id));
            }
            
            redirect(base_url('master/data_barang_tambah.php?id='.$rf));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_barang_hapus_ref() {
        if (Akses::aksesLogin() == TRUE) {
            $id = $this->input->get('id');
            $rf = $this->input->get('ref');
            
            if(!empty($id)){
                crud::delete('tbl_m_produk_ref','id',general::dekrip($id));
            }
            
            redirect(base_url('master/data_barang_tambah.php?id='.$rf));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_barang_hapus_ref_input() {
        if (Akses::aksesLogin() == TRUE) {
            $id = $this->input->get('id');
            $rf = $this->input->get('ref');
            
            if(!empty($id)){
                crud::delete('tbl_m_produk_ref_input','id',general::dekrip($id));
            }
            
            redirect(base_url('master/data_barang_tambah.php?id='.$rf));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_stok_list() {
        if (Akses::aksesLogin() == TRUE) {
            $hal             = $this->input->get('halaman');
            $filter_kode     = $this->input->get('filter_kode');
            $filter_produk   = $this->input->get('filter_produk');
            $filter_hpp      = $this->input->get('filter_hpp');
            $filter_harga    = $this->input->get('filter_harga');
            $filter_stok     = $this->input->get('filter_stok');
            $sort_type       = $this->input->get('sort_type');
            $sort_order      = $this->input->get('sort_order');
            $jml             = $this->input->get('jml');
            $jml_hal         = (!empty($jml) ? $jml  : $this->db->count_all('tbl_m_produk'));
            $pengaturan      = $this->db->get('tbl_pengaturan')->row();
            
            $data['hasError'] = $this->session->flashdata('form_error');
                        
            $config['base_url']               = base_url('master/data_stok_list.php?'.(!empty($filter_kode) ? '&filter_kode='.$filter_kode : '').(!empty($filter_produk) ? '&filter_produk='.$filter_produk : '').(isset($filter_stok) ? '&filter_stok='.$filter_stok : '').(!empty($filter_hpp) ? '&filter_hpp='.$filter_hpp : '').(!empty($filter_harga) ? '&filter_harga='.$filter_harga : '').(!empty($sort_order) ? '&sort_order='.$sort_order : '').(!empty($jml) ? '&jml='.$jml : ''));
            $config['total_rows']             = $jml_hal;
            
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
            
            
            if(!empty($hal)){
                if (!empty($jml)) {
                    $data['barang'] = $this->db->limit($config['per_page'],$hal)
                                               ->like('kode', $filter_kode)
                                               ->like('produk', $filter_produk)
                                               ->like('jml', $filter_stok)
                                               ->order_by(!empty($sort_type) ? $sort_type : 'id', (isset($sort_order) ? $sort_order : 'desc'))
                                               ->get('tbl_m_produk')->result();
                } else {
                    $data['barang'] = $this->db->limit($config['per_page'],$hal)->order_by('id', (isset($sort_order) ? $sort_order : 'desc'))->get('tbl_m_produk')->result();
                }
            }else{
                if (!empty($jml)) {
                    $data['barang'] = $this->db->limit($config['per_page'],$hal)
                                               ->like('kode', $filter_kode)
                                               ->like('produk', $filter_produk)
                                               ->like('jml', $filter_stok)
                                               ->order_by(!empty($sort_type) ? $sort_type : 'id', (isset($sort_order) ? $sort_order : 'desc'))
                                               ->get('tbl_m_produk')->result();
                } else {
                    $data['barang'] = $this->db->limit($config['per_page'])
                                               ->order_by(!empty($sort_type) ? $sort_type : 'id', (isset($sort_order) ? $sort_order : 'desc'))
                                               ->get('tbl_m_produk')->result();
                }
            }
            
            $this->pagination->initialize($config);
            
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();
            $data['cetak']      = '<button type="button" onclick="window.location.href = \''.base_url('master/cetak_data_barang.php?'.(!empty($filter_kode) ? 'filter_kode='.$filter_kode : '').(!empty($filter_produk) ? '&filter_produk='.$filter_produk : '').(!empty($filter_hpp) ? '&filter_hpp='.$filter_hpp : '').(!empty($filter_harga) ? '&filter_harga='.$filter_harga : '').(!empty($jml) ? '&jml='.$jml : '')).'\'" class="btn btn-warning btn-flat"><i class="fa fa-print"></i> Cetak</button>';

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
//            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/master/data_stok_list', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_stok_tambah() {
        if (Akses::aksesLogin() == TRUE) {
            $id   = $this->input->get('id');
            
            $data['barang'] = $this->db->where('id', general::dekrip($id))->get('tbl_m_produk')->row();
            $data['satuan'] = $this->db->get('tbl_m_satuan')->result();

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
//            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/master/data_stok_tambah', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_stok_det() {
        if (Akses::aksesLogin() == TRUE) {
            $id   = $this->input->get('id');
            
            $data['barang'] = $this->db->where('id', general::dekrip($id))->get('tbl_m_produk')->row();
            $data['satuan'] = $this->db->get('tbl_m_satuan')->result();

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
//            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/master/data_stok_detail', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_stok_update() {
        if (Akses::aksesLogin() == TRUE) {
            $id      = $this->input->post('id');
            $kode    = $this->input->post('kode');
            $barang  = $this->input->post('barang');
            $jml     = $this->input->post('jml');
            $satuan  = $this->input->post('satuan');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('kode', 'Kode Barang', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'kode'     => form_error('kode'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url('master/data_barang_tambah.php?id='.$id));
            } else {                
                $data_penj = array(
                    'tgl_modif'   => date('Y-m-d H:i:s'),
                    'kode'        => $kode,
                    'produk'      => $barang,
                    'jml'         => $jml,
                    'id_satuan'   => $satuan,
                );
                
                $this->session->set_flashdata('master', '<div class="alert alert-success">Data stok disimpan</div>');
                crud::update('tbl_m_produk', 'id', general::dekrip($id),$data_penj);
                redirect(base_url('master/data_stok_tambah.php?id='.$id));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_stok_update_br() {
        if (Akses::aksesLogin() == TRUE) {
            $id      = $this->input->post('id');
            $kode    = $this->input->post('kode');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('kode', 'Kode Barang', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'kode'     => form_error('kode'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url('master/data_barang_tambah.php?id='.$id));
            } else {
                $sql_brg   = $this->db->where('kode', $kode)->get('tbl_m_produk')->row();
                $jml_akhir = $sql_brg->jml + 1;
                
                $data_penj = array(
                    'tgl_modif'   => date('Y-m-d H:i:s'),
                    'jml'         => $jml_akhir,
                );
                
//                $this->session->set_flashdata('master', '<div class="alert alert-success">Data stok disimpan</div>');
                crud::update('tbl_m_produk', 'id', general::dekrip($id),$data_penj);
                redirect(base_url('master/data_stok_tambah.php?id='.$id));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_stok_import() {
        if (Akses::aksesLogin() == TRUE) {
            $id   = $this->input->get('id');
            
            $data['stok'] = $this->db->where('id', general::dekrip($id))->get('tbl_m_produk')->row();
            $data['satuan'] = $this->db->get('tbl_m_satuan')->result();

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
//            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/master/data_stok_import', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_stok_upload() {
        if (Akses::aksesLogin() == TRUE) {
            $this->load->helper('file');
            
            if (!empty($_FILES['fupload']['name'])) {
                $folder = realpath('file/import');
                $config['upload_path']      = './file/import';
                $config['allowed_types']    = 'xls|xlsx';
                $config['remove_spaces']    = TRUE;
                $config['overwrite']        = TRUE;
                $this->load->library('upload', $config);
                
                if (!$this->upload->do_upload('fupload')) {
                    $this->session->set_flashdata('pengaturan', 'Error : <b>' . $this->upload->display_errors() . '</b>.');
                    redirect(base_url('master/data_stok_import.php?err='.$this->upload->display_errors()));
                }else{
                    $f           = $this->upload->data();
                    $path        = realpath('./file/import') . '/';                    
                    $objPHPExcel = PHPExcel_IOFactory::load($path.$f['orig_name']);
                    $sql_satuan  = $this->db->get('tbl_m_satuan')->row();
                    
                    foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                        $worksheetTitle     = $worksheet->getTitle();
                        $highestRow         = $worksheet->getHighestRow();
                        $highestColumn      = $worksheet->getHighestColumn();
                        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
                        
                        for ($row = 3; $row <= $highestRow; ++ $row) {
                            $val=array();
                            
                            for ($col = 0; $col < $highestColumnIndex; ++$col) {
                                $cell = $worksheet->getCellByColumnAndRow($col, $row);
                                $val[] = $cell->getValue();
                            }
                            
                            $produk = array(
                                'kode'          => $val[1],
                                'produk'        => $val[2],
                                'jml'           => $val[3],
                            );
                            
                            crud::simpan('tbl_m_produk', $produk);
                        }
                    }
                    
                    unlink($path.$f['orig_name']);
                    redirect(base_url('master/data_stok_list.php'));
                }
            }  
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    
    public function data_customer_list() {
        if (Akses::aksesLogin() == TRUE) {
            $query   = $this->input->get('q');
            $hal     = $this->input->get('halaman');
            $jml     = $this->input->get('jml');
            $sort_type       = $this->input->get('sort_type');
            $sort_order      = $this->input->get('sort_order');
            $jml_hal = (!empty($jml) ? $jml  : $this->db->count_all('tbl_m_pelanggan'));
            $pengaturan = $this->db->get('tbl_pengaturan')->row();
            
            $data['hasError'] = $this->session->flashdata('form_error');
                        
            $config['base_url']               = base_url('master/data_customer_list.php?'.(!empty($sort_order) ? '&sort_order='.$sort_order : '').(isset($_GET['q']) ? '&q='.$_GET['q'].'&jml='.$_GET['jml'] : ''));
            $config['total_rows']             = $jml_hal;
            
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
            
            
            if(!empty($hal)){
                if (!empty($query)) {
                    $data['pelanggan'] = $this->db->limit($config['per_page'],$hal)->like('nama', $query)->or_like('nik', $query)->or_like('nama_toko', $query)->order_by(!empty($sort_type) ? $sort_type : 'nama', (isset($sort_order) ? $sort_order : 'asc'))->get('tbl_m_pelanggan')->result();
                } else {
                    $data['pelanggan'] = $this->db->limit($config['per_page'],$hal)->order_by(!empty($sort_type) ? $sort_type : 'nama', (isset($sort_order) ? $sort_order : 'asc'))->get('tbl_m_pelanggan')->result();
                }
            }else{
                if (!empty($query)) {
                    $data['pelanggan'] = $this->db->limit($config['per_page'],$hal)->like('nama', $query)->or_like('nik', $query)->or_like('nama_toko', $query)->order_by(!empty($sort_type) ? $sort_type : 'nama', (isset($sort_order) ? $sort_order : 'asc'))->get('tbl_m_pelanggan')->result();
                } else {
                    $data['pelanggan'] = $this->db->limit($config['per_page'])->order_by(!empty($sort_type) ? $sort_type : 'nama', (isset($sort_order) ? $sort_order : 'asc'))->get('tbl_m_pelanggan')->result();
                }
            }
            
            $this->pagination->initialize($config);
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/master/sidebar_cust';
            /* --- Sidebar Menu --- */
            
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();
            $data['cetak']      = '<button type="button" onclick="window.location.href = \''.base_url('master/cetak_data_customer.php?'.(!empty($query) ? 'query='.$query : '').(!empty($filter_produk) ? '&filter_produk='.$filter_produk : '').(!empty($filter_hpp) ? '&filter_hpp='.$filter_hpp : '').(!empty($filter_harga) ? '&filter_harga='.$filter_harga : '').(!empty($jml) ? '&jml='.$jml : '')).'\'" class="btn btn-warning btn-flat"><i class="fa fa-print"></i> Cetak</button>';

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/master/data_customer_list', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_customer_tambah() {
        if (Akses::aksesLogin() == TRUE) {
            $id   = $this->input->get('id');
            
            $data['customer'] = $this->db->where('id', general::dekrip($id))->get('tbl_m_pelanggan')->row();
            $data['satuan']   = $this->db->get('tbl_m_satuan')->result();
            $data['kategori'] = $this->db->get('tbl_m_kategori')->result();
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/master/sidebar_cust';
            /* --- Sidebar Menu --- */

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/master/data_customer_tambah', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_customer_det() {
        if (Akses::aksesLogin() == TRUE) {
            $id   = $this->input->get('id');
            
            $data['customer'] = $this->db->where('id', general::dekrip($id))->get('tbl_m_pelanggan')->row();
            $data['satuan']   = $this->db->get('tbl_m_satuan')->result();
            $data['kategori'] = $this->db->get('tbl_m_kategori')->result();
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/master/sidebar_cust';
            /* --- Sidebar Menu --- */

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/master/data_customer_tambah', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_customer_simpan() {
        if (Akses::aksesLogin() == TRUE) {
            $nik          = $this->input->post('nik');
            $nama         = $this->input->post('nama');
            $nama_toko    = $this->input->post('nama_toko');
            $no_hp        = $this->input->post('no_hp');
            $alamat       = $this->input->post('alamat');
            $tipe_member  = $this->input->post('tipe_member');
            $disk1        = $this->input->post('disk1');
            $disk2        = $this->input->post('disk2');
            $disk3        = $this->input->post('disk3');
            
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('nik', 'NIK', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'nik'     => form_error('nik'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url('master/data_customer_tambah.php'));
            } else {
                $sql_num = $this->db->get('tbl_m_pelanggan')->num_rows() + 1;
                $kode    = sprintf('%05d', $sql_num);
                $sql_kat = $this->db->get('tbl_m_kategori');
                
                $data_penj = array(
                    'tgl_simpan'  => date('Y-m-d H:i:s'),
                    'kode'        => $kode,
                    'nik'         => $nik,
                    'nama'        => $nama,
                    'tgl_lahir'   => $tgl_lhr,
                    'jns_klm'     => $jns_klm,
                    'no_hp'       => $no_hp,
                    'lokasi'      => $lokasi,
                    'alamat'      => $alamat
                );
                
                $this->session->set_flashdata('member', '<div class="alert alert-success">Data member berhasil diubah</div>');
                crud::simpan('tbl_m_pelanggan', $data_penj);
                
                $sql_max = $this->db->select_max('id')->get('tbl_m_pelanggan')->row();
                $sql_ckk = $this->db->where('id_pelanggan', general::dekrip($id))->get('tbl_m_pelanggan_diskon');
                
                foreach ($sql_kat->result() as $kat){                    
                    $data_disk = array(
                        'tgl_simpan'   => date('Y-m-d H:i:s'),
                        'id_pelanggan' => $sql_max->id,
                        'id_kategori'  => $kat->id,
                        'disk1'        => str_replace(',','.', $_POST['disk1'][$kat->id]),
                        'disk2'        => str_replace(',','.', $_POST['disk2'][$kat->id]),
                        'disk3'        => str_replace(',','.', $_POST['disk3'][$kat->id]),
                    );
                    
                    echo '<pre>';
                    print_r($data_disk);
                    
//                    if($_POST['disk1'][$kat->id] != '0' AND $_POST['disk2'][$kat->id] != '0' AND $_POST['disk3'][$kat->id] != '0'){
                        crud::simpan('tbl_m_pelanggan_diskon',$data_disk);
                        crud::update('tbl_m_pelanggan','id', $sql_max->id, array('id_kategori' => $kat->id));
//                    }
                }
                
                
                
                redirect(base_url('master/data_customer_list.php'));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_customer_simpan2() {
        if (Akses::aksesLogin() == TRUE) {
            $nik          = $this->input->post('nik');
            $nama         = $this->input->post('nama');
            $nama_toko    = $this->input->post('nama_toko');
            $lokasi       = $this->input->post('lokasi');
            $no_hp        = $this->input->post('no_hp');
            $alamat       = $this->input->post('alamat');
            $tipe_member  = $this->input->post('tipe_member');
            $disk1        = $this->input->post('disk1');
            $disk2        = $this->input->post('disk2');
            $disk3        = $this->input->post('disk3');
            
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

//            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
//
//            $this->form_validation->set_rules('nik', 'NIK', 'required');
//
//            if ($this->form_validation->run() == FALSE) {
//                $msg_error = array(
//                    'nik'     => form_error('nik'),
//                );
//
//                $this->session->set_flashdata('form_error', $msg_error);
//                redirect(base_url('master/data_customer_tambah.php'));
//            } else {
                $sql_num = $this->db->get('tbl_m_pelanggan')->num_rows() + 1;
                $kode    = sprintf('%05d', $sql_num);
                
                $data_penj = array(
                    'tgl_modif'   => date('Y-m-d H:i:s'),
                    'kode'        => $kode,
                    'nik'         => $nik,
                    'nama'        => $nama,
                    'nama_toko'   => $nama_toko,
                    'no_hp'       => $no_hp,
                    'lokasi'      => $lokasi,
                    'alamat'      => $alamat
                );
                
                $this->session->set_flashdata('member', '<div class="alert alert-success">Data member berhasil diubah</div>');
                crud::simpan('tbl_m_pelanggan', $data_penj);

//            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_customer_update() {
        if (Akses::aksesLogin() == TRUE) {
            $id           = $this->input->post('id');
            $nik          = $this->input->post('nik');
            $nama         = $this->input->post('nama');
            $nama_toko    = $this->input->post('nama_toko');
            $lokasi       = $this->input->post('lokasi');
            $no_hp        = $this->input->post('no_hp');
            $alamat       = $this->input->post('alamat');
            $tgl_lhr      = $this->input->post('tgl_lahir');
            $jns_klm      = $this->input->post('jns_klm');
            $tipe_member  = $this->input->post('tipe_member');
            $disk1        = $this->input->post('disk1');
            $disk2        = $this->input->post('disk2');
            $disk3        = $this->input->post('disk3');
            
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('nik', 'NIK', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'nik'     => form_error('nik'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url('master/data_customer_tambah.php?id='.$id));
            } else {
                $sql_kat = $this->db->get('tbl_m_kategori');
                $sql_ckk = $this->db->where('id_pelanggan', general::dekrip($id))->get('tbl_m_pelanggan_diskon');
                $sql_num = $this->db->get('tbl_m_pelanggan')->num_rows() + 1;
                $kode    = sprintf('%05d', $sql_num);
                
                $data_penj = array(
                    'tgl_modif'   => date('Y-m-d H:i:s'),
                    'kode'        => $kode,
                    'nik'         => $nik,
                    'nama'        => $nama,
                    'tgl_lahir'   => $this->tanggalan->tgl_indo_sys($tgl_lhr),
                    'jns_klm'     => $jns_klm,
                    'no_hp'       => $no_hp,
                    'lokasi'      => $lokasi,
                    'alamat'      => $alamat
                );
                
//                if($sql_ckk->num_rows() > 0){
//                    crud::delete('tbl_m_pelanggan_diskon','id_pelanggan',general::dekrip($id));
//                }
//                
//                foreach ($sql_kat->result() as $kat){                    
//                    $data_disk = array(
//                        'tgl_simpan'   => date('Y-m-d H:i:s'),
//                        'id_pelanggan' => general::dekrip($id),
//                        'id_kategori'  => $kat->id,
//                        'disk1'        => str_replace(',','.', $_POST['disk1'][$kat->id]),
//                        'disk2'        => str_replace(',','.', $_POST['disk2'][$kat->id]),
//                        'disk3'        => str_replace(',','.', $_POST['disk3'][$kat->id]),
//                    );
//                    
//                    crud::simpan('tbl_m_pelanggan_diskon',$data_disk);
//                    crud::update('tbl_m_pelanggan','id', general::dekrip($id), array('id_kategori' => $kat->id));
//                }
                
                $this->session->set_flashdata('member', '<div class="alert alert-success">Data pelanggan berhasil diubah</div>');
                crud::update('tbl_m_pelanggan','id', general::dekrip($id),$data_penj);                
                redirect(base_url('master/data_customer_tambah.php?id='.$id));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_customer_hapus() {
        if (Akses::aksesLogin() == TRUE) {
            $id = $this->input->get('id');
            $hl = $this->input->get('halaman');
            
            if(!empty($id)){
                crud::delete('tbl_m_pelanggan','id',general::dekrip($id));
            }
            
            redirect(base_url('master/data_customer_list.php?'.(isset($_GET['q']) ? '&q='.$this->input->get('q') : '').(isset($_GET['jml']) ? '&jml='.$this->input->get('jml') : '').(isset($_GET['halaman']) ? '&halaman='.$this->input->get('halaman') : '')));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
        
    public function data_customer_import() {
        if (Akses::aksesLogin() == TRUE) {
            $id   = $this->input->get('id');
            
            $data['barang'] = $this->db->where('id', general::dekrip($id))->get('tbl_m_produk')->row();
            $data['satuan'] = $this->db->get('tbl_m_satuan')->result();

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
//            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/master/data_customer_import', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_customer_upload() {
        if (Akses::aksesLogin() == TRUE) {
            $this->load->helper('file');
            
            if (!empty($_FILES['fupload']['name'])) {
                $folder = realpath('file/import');
                $config['upload_path']      = './file/import';
                $config['allowed_types']    = 'xls|xlsx';
                $config['remove_spaces']    = TRUE;
                $config['overwrite']        = TRUE;
                $this->load->library('upload', $config);
                                
                if (!$this->upload->do_upload('fupload')) {
                    $this->session->set_flashdata('pengaturan', 'Error : <b>' . $this->upload->display_errors() . '</b>.');
                    redirect(base_url('master/data_customer_import.php?err='.$this->upload->display_errors()));
                }else{
                    $f           = $this->upload->data();
                    $path        = realpath('./file/import') . '/';                    
                    $objPHPExcel = PHPExcel_IOFactory::load($path.$f['orig_name']);
                    
                    foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                        $worksheetTitle     = $worksheet->getTitle();
                        $highestRow         = $worksheet->getHighestRow();
                        $highestColumn      = $worksheet->getHighestColumn();
                        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
                        
                        for ($row = 3; $row <= $highestRow; ++ $row) {
                            $val=array();
                            
                            for ($col = 0; $col < $highestColumnIndex; ++$col) {
                                $cell = $worksheet->getCellByColumnAndRow($col, $row);
                                $val[] = $cell->getValue();
                            }
							
                            if (!empty($val[1])) {
                                $produk = array(
                                    'tgl_simpan'    => date('Y-m-d H:i:s'),
                                    'kode'          => $val[1],
                                    'nik'           => $val[2],
                                    'nama'          => $val[3],
                                    'nama_toko'     => $val[4],
                                    'no_hp'         => $val[5],
                                    'lokasi'        => $val[6],
                                    'alamat'        => $val[7],
                                    'status_plgn'   => 1,
                                );

                                crud::simpan('tbl_m_pelanggan', $produk);
                            }
                        }
                    }
                    
                    unlink($path.$f['orig_name']);
                    redirect(base_url('master/data_customer_list.php'));
                }
            }  
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }    
    
    public function data_karyawan_list() {
        if (Akses::aksesLogin() == TRUE) {
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
            $kd      = $this->input->get('filter_nik');
            $gr      = $this->input->get('filter_grup');
            $jml     = $this->input->get('jml');
            
            $data['hasError'] = $this->session->flashdata('form_error');
            
            if(!empty($jml)){
                $jml_hal = $jml;
            }else{
                $jml_hal = $this->db->select('*')
                                ->where('status_aps', '0')
                                ->like('nik', $kd)
                                ->like('nama', $cs)
                                ->like('id_user_group', $gr)
                                ->order_by('id', 'desc')
                                ->get('tbl_m_karyawan')->num_rows();
            }
                        
            $config['base_url']              = base_url('master/data_karyawan_list.php?'.(!empty($gr) ? 'filter_grup='.$gr.'&' : '').(!empty($kd) ? 'filter_nik='.$kd.'&' : '').(!empty($cs) ? 'filter_nama='.$cs : '').(!empty($jml_hal) ? '&jml='.$jml_hal : ''));
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
            
            
            if (!empty($hal)) {
                $data['sales'] = $this->db->select('*')
                                ->where('status_aps', '0')
                                ->like('nik', $kd)
                                ->like('nama', $cs)
                                ->like('id_user_group', $gr)
                                ->limit($config['per_page'], $hal)
                                ->order_by('id', 'desc')
                                ->get('tbl_m_karyawan')->result();
            } else {
                $data['sales'] = $this->db->select('*')
                                ->where('status_aps', '0')
                                ->like('nik', $kd)
                                ->like('nama', $cs)
                                ->like('id_user_group', $gr)
                                ->limit($config['per_page'])
                                ->order_by('id', 'desc')
                                ->get('tbl_m_karyawan')->result();
            }

            $this->pagination->initialize($config);
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/master/sidebar_karyawan';
            /* --- Sidebar Menu --- */
            
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();
            $data['cetak']      = '<button type="button" onclick="window.location.href = \''.base_url('master/cetak_data_karyawan.php?'.(!empty($query) ? 'query='.$query : '').(!empty($jml) ? '&jml='.$jml : '')).'\'" class="btn btn-warning btn-flat"><i class="fa fa-print"></i> Cetak</button>';

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/master/data_karyawan_list', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
        
    public function data_karyawan_import() {
        if (Akses::aksesLogin() == TRUE) {
            $id   = $this->input->get('id');
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/master/sidebar_karyawan';
            /* --- Sidebar Menu --- */

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/master/data_karyawan_import', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_karyawan_tambah() {
        if (Akses::aksesLogin() == TRUE) {
            $id   = $this->input->get('id');
            
            if(!empty($id)){
                $data['sql_kary']      = $this->db->where('id', general::dekrip($id))->get('tbl_m_karyawan')->row();
            }
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/master/sidebar_karyawan';
            /* --- Sidebar Menu --- */

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/master/data_karyawan_tambah', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_karyawan_tambah_pend() {
        if (Akses::aksesLogin() == TRUE) {
            $id   = $this->input->get('id');
            
            if(!empty($id)){
                $data['sql_kary']      = $this->db->where('id', general::dekrip($id))->get('tbl_m_karyawan')->row();
                $data['sql_kary_pend'] = $this->db->where('id_karyawan', $data['sql_kary']->id)->get('tbl_m_karyawan_pend')->result();
            }
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/master/sidebar_karyawan';
            /* --- Sidebar Menu --- */

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/master/data_karyawan_tambah_pend', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_karyawan_tambah_sert() {
        if (Akses::aksesLogin() == TRUE) {
            $id   = $this->input->get('id');
            
            if(!empty($id)){
                $data['sql_kary']      = $this->db->where('id', general::dekrip($id))->get('tbl_m_karyawan')->row();
                $data['sql_kary_sert'] = $this->db->where('id_karyawan', $data['sql_kary']->id)->get('tbl_m_karyawan_sert')->result();
            }
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/master/sidebar_karyawan';
            /* --- Sidebar Menu --- */

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/master/data_karyawan_tambah_sert', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_karyawan_tambah_peg() {
        if (Akses::aksesLogin() == TRUE) {
            $id   = $this->input->get('id');
            
            if(!empty($id)){
                $data['sql_dep']       = $this->db->get('tbl_m_departemen')->result();
                $data['sql_jab']       = $this->db->get('tbl_m_jabatan')->result();
                $data['sql_kary']      = $this->db->where('id', general::dekrip($id))->get('tbl_m_karyawan')->row();
                $data['sql_kary_peg']  = $this->db->where('id_karyawan', $data['sql_kary']->id)->get('tbl_m_karyawan_peg')->result();
                $data['sql_kary_tipe'] = $this->db->where('status', '1')->get('tbl_m_karyawan_tipe')->result();
            }
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/master/sidebar_karyawan';
            /* --- Sidebar Menu --- */

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/master/data_karyawan_tambah_peg', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_karyawan_tambah_kel() {
        if (Akses::aksesLogin() == TRUE) {
            $id   = $this->input->get('id');
            
            if(!empty($id)){
                $data['sql_dep']       = $this->db->get('tbl_m_departemen')->result();
                $data['sql_jab']       = $this->db->get('tbl_m_jabatan')->result();
                $data['sql_kary']      = $this->db->where('id', general::dekrip($id))->get('tbl_m_karyawan')->row();
                $data['sql_kary_kel']  = $this->db->where('id_karyawan', $data['sql_kary']->id)->get('tbl_m_karyawan_kel')->result();
                $data['sql_kary_tipe'] = $this->db->where('status', '1')->get('tbl_m_karyawan_tipe')->result();
            }
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/master/sidebar_karyawan';
            /* --- Sidebar Menu --- */

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/master/data_karyawan_tambah_kel', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_karyawan_tambah_jdwl() {
        if (Akses::aksesLogin() == TRUE) {
            $id   = $this->input->get('id');
            
            if(!empty($id)){
                $data['sql_dep']       = $this->db->get('tbl_m_departemen')->result();
                $data['sql_jab']       = $this->db->get('tbl_m_jabatan')->result();
                $data['sql_kary']      = $this->db->where('id', general::dekrip($id))->get('tbl_m_karyawan')->row();
                $data['sql_kary_jdwl'] = $this->db->where('id_karyawan', $data['sql_kary']->id)->get('tbl_m_karyawan_jadwal')->result();
                $data['poli']          = $this->db->where('status','1')->get('tbl_m_poli')->result();
            }
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/master/sidebar_karyawan';
            /* --- Sidebar Menu --- */

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/master/data_karyawan_tambah_jdwl', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_karyawan_simpan() {
        if (Akses::aksesLogin() == TRUE) {
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
            
            $pengaturan   = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('nik', 'NIK', 'required');
            $this->form_validation->set_rules('nama', 'Nama', 'required');
            $this->form_validation->set_rules('jns_klm', 'Jenis Klm', 'required');
            $this->form_validation->set_rules('tmp_lahir', 'Tempat Lahir', 'required');
            $this->form_validation->set_rules('tgl_lahir', 'Tgl Lahir', 'required');
            $this->form_validation->set_rules('alamat', 'Alamat', 'required');
            $this->form_validation->set_rules('alamat_dom', 'Alamat Dom', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'nik'           => form_error('nik'),
                    'nama'          => form_error('nama'),
                    'jns_klm'       => form_error('jns_klm'),
                    'tmp_lahir'     => form_error('tmp_lahir'),
                    'tgl_lahir'     => form_error('tgl_lahir'),
                    'alamat'        => form_error('alamat'),
                    'alamat_dom'    => form_error('alamat_dom'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url('master/data_karyawan_tambah.php'));
            } else {
                $sql_num    = $this->db->get('tbl_m_karyawan')->num_rows() + 1;
                $kode_no    = sprintf('%05d', $sql_num);
                
                $get_grup   = $this->ion_auth->get_users_groups(general::dekrip($id_user))->row();
                $sql_grup   = $this->ion_auth->group($get_grup->id)->row();
                
                $cek        = $this->db->select('username')->where('username', $user)->get('tbl_ion_users')->num_rows();
                
                if($cek > 0){
                    $this->session->set_flashdata('member', '<div class="alert alert-danger">Username sudah ada</div>');
                    redirect(base_url('master/data_karyawan_tambah.php'));
                }else{               
                    if(!empty($user) AND !empty($pass1)) {
                        $data_user = array(
                            'id_app'        => $pengaturan->id_app,
                            'first_name'    => (!empty($nama_dpn) ? $nama_dpn.' ' : '').strtoupper($nama).(!empty($nama_blk) ? ', '.$nama_blk : ''),
                            'username'      => $user,
                            'password'      => $pass2,
                            'address'       => $alamat,
                            'birthdate'     => (!empty($tgl_lahir) ? $this->tanggalan->tgl_indo_sys($tgl_lahir) : '0000-00-00'),
                        );
                        
                        $this->ion_auth->register($user, $pass2, $email, $data_user, array($grup));
                        $sql_user  = $this->db->where('username', $user)->get('tbl_ion_users')->row();
                    }
                }
                    
                $data_kary = array(
                    'id_user'           => (!empty($sql_user->id) ? $sql_user->id : '0'),
                    'id_user_group'     => (!empty($grup) ? $grup : '0'),
                    'tgl_simpan'        => date('Y-m-d H:i:s'),
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
                    'tgl_lahir'         => $this->tanggalan->tgl_indo_sys($tgl_lahir),
                    'tmp_lahir'         => $tmp_lahir,
                );
                
                $this->db->insert('tbl_m_karyawan', $data_kary);
                $last_id = crud::last_id();
                
                $this->session->set_flashdata('master_toast', 'toastr.success("Data karyawan berhasil dibuat !");');
                redirect(base_url('master/data_karyawan_tambah.php?id='.general::enkrip($last_id)));
                                    
//                echo general::dekrip($id);
//                echo '<pre>';
//                print_r($data_kary);
//                echo '</pre>';
//                echo '<pre>';
//                print_r($data_user);
//                echo '</pre>';
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_karyawan_simpan_kel() {
        if (Akses::aksesLogin() == TRUE) {
            $id             = $this->input->post('id');
            $id_kel         = $this->input->post('id_kel');
            $nm_ayah        = $this->input->post('nm_ayah');
            $tgl_lhr_ayah   = $this->input->post('tgl_lhr_ayah');
            $status_kawin   = $this->input->post('status_kawin');
            $jns_pasangan   = $this->input->post('jns_pasangan');
            $nm_ibu         = $this->input->post('nm_ibu');
            $tgl_lhr_ibu    = $this->input->post('tgl_lhr_ibu');
            $nm_pasangan    = $this->input->post('nm_pasangan');
            $nm_anak        = $this->input->post('nm_anak');
            $tgl_lhr_psg    = $this->input->post('tgl_lhr_psg');
            $status_kawin   = $this->input->post('status_kawin');
            $rute           = $this->input->post('route');
            
            $pengaturan   = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id', 'NIK', 'required');
            $this->form_validation->set_rules('nm_ayah', 'Kode', 'required');
            $this->form_validation->set_rules('nm_ibu', 'Divisi', 'required');
            
            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'id'        => form_error('id'),
                    'nm_ayah'   => form_error('nm_ayah'),
                    'nm_ibu'    => form_error('nm_ibu'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url((!empty($rute) ? $rute.'&id='.$id : 'master/data_karyawan_kel.php?id='.$id)));
            } else {
               $sql_kary    = $this->db->where('id', general::dekrip($id))->get('tbl_m_karyawan')->row();
               $sql_kel     = $this->db->where('id', general::dekrip($id_kel))->get('tbl_m_karyawan_kel');
               $path        = 'file/karyawan/'.$sql_kary->id.'/';
               $tgl_awal    = $this->tanggalan->tgl_indo_sys($tgl_msk);
               $tgl_akhir   = $this->tanggalan->tgl_indo_sys($tgl_klr);
               
               if($sql_kel->num_rows() > 0){
                   $id_kel = $sql_kel->row()->id;
                   $this->db->where('id', $id_kel)->delete('tbl_m_karyawan_kel');
               }
               
               # Buat Folder Untuk File KK
               if (!empty($_FILES['fupload']['name'])) {              
                    # Buat Folder Untuk File Karyawan
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }
                    
                    $config['upload_path']      = realpath($path);
                    $config['allowed_types']    = 'jpg|png|pdf|jpeg';
                    $config['remove_spaces']    = TRUE;
                    $config['overwrite']        = TRUE;
                    $config['file_name']        = 'file_kk_'.$sql_kary->id.sprintf('%05d', rand(1,256));
                    $this->load->library('upload', $config);
                    
                    if (!$this->upload->do_upload('fupload')) {
                        $this->session->set_flashdata('master_toast', 'toastr.error("Error : <b>'.$this->upload->display_errors().'</b>");');
//                        redirect((!empty($rute) ? $rute.'&id='.general::enkrip($sql_kary->id) : 'master/data_karyawan_kel.php?id='.$id));
                    } else {
                        $f          = $this->upload->data();
                        $file_name  = $f['orig_name'];
                        $file_type  = $f['file_type'];
                        $file_ext   = $f['file_ext'];
                    }
                }
                
               $data = array(
                   'id_karyawan'    => $sql_kary->id,
                   'id_user'        => $this->ion_auth->user()->row()->id,
                   'tgl_simpan'     => date('Y-m-d H:i:s'),
                   'tgl_lhr_ayah'   => (!empty($tgl_lhr_ayah) ? $this->tanggalan->tgl_indo_sys($tgl_lhr_ayah) : '0000-00-00'),
                   'tgl_lhr_ibu'    => (!empty($tgl_lhr_ibu) ? $this->tanggalan->tgl_indo_sys($tgl_lhr_ibu) : '0000-00-00'),
                   'tgl_lhr_psg'    => (!empty($tgl_lhr_psg) ? $this->tanggalan->tgl_indo_sys($tgl_lhr_psg) : '0000-00-00'),
                   'nm_ayah'        => (!empty($nm_ayah) ? $nm_ayah : '-'),
                   'nm_ibu'         => (!empty($nm_ibu) ? $nm_ibu : '-'),
                   'nm_pasangan'    => (!empty($nm_pasangan) ? $nm_pasangan : '-'),
                   'nm_anak'        => (!empty($nm_anak) ? $nm_anak : '-'),
                   'status_kawin'   => (!empty($status_kawin) ? $status_kawin : '0'),
                   'jns_pasangan'   => (!empty($jns_pasangan) ? $jns_pasangan : '0'),
                   'file_name'      => (!empty($file_name) ? $file_name : ''),
                   'file_type'      => (!empty($file_type) ? $file_type : ''),
                   'file_ext'       => (!empty($file_ext) ? $file_ext : '')
               );
               
               $this->db->insert('tbl_m_karyawan_kel', $data);
               $last_id = crud::last_id();
               
               $this->session->set_flashdata('master_toast', 'toastr.success("Data Keluarga berhasil disimpan !");');
               redirect(base_url((!empty($rute) ? $rute.'&id='.general::enkrip($sql_kary->id) : 'master/data_karyawan_kel.php?id='.$id)));
              
//                echo '<pre>';
//                print_r($data);
//                echo '</pre>';
//                echo '<pre>';
//                print_r($f);
//                echo '</pre>';
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_karyawan_simpan_kel_ktp() {
        if (Akses::aksesLogin() == TRUE) {
            $id             = $this->input->post('id');
            $id_kel         = $this->input->post('id_kel');
            $nm_ayah        = $this->input->post('nm_ayah');
            $tgl_lhr_ayah   = $this->input->post('tgl_lhr_ayah');
            $status_kawin   = $this->input->post('status_kawin');
            $jns_pasangan   = $this->input->post('jns_pasangan');
            $nm_ibu         = $this->input->post('nm_ibu');
            $tgl_lhr_ibu    = $this->input->post('tgl_lhr_ibu');
            $nm_pasangan    = $this->input->post('nm_pasangan');
            $nm_anak        = $this->input->post('nm_anak');
            $tgl_lhr_psg    = $this->input->post('tgl_lhr_psg');
            $status_kawin   = $this->input->post('status_kawin');
            $rute           = $this->input->post('route');
            
            $pengaturan   = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id', 'NIK', 'required');
            
            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'id'        => form_error('id'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url((!empty($rute) ? $rute.'&id='.$id : 'master/data_karyawan_kel.php?id='.$id)));
            } else {
               $sql_kary    = $this->db->where('id', general::dekrip($id))->get('tbl_m_karyawan')->row();
               $sql_kel     = $this->db->where('id', general::dekrip($id_kel))->get('tbl_m_karyawan_kel');
               $path        = 'file/karyawan/'.$sql_kary->id.'/';
               $tgl_awal    = $this->tanggalan->tgl_indo_sys($tgl_msk);
               $tgl_akhir   = $this->tanggalan->tgl_indo_sys($tgl_klr);
                
               # Buat Folder Untuk File KTP
               if (!empty($_FILES['fupload']['name'])) {                   
                    # Buat Folder Untuk File Karyawan
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }
                    
                    $config_ktp['upload_path']      = realpath($path);
                    $config_ktp['allowed_types']    = 'jpg|png|pdf|jpeg';
                    $config_ktp['remove_spaces']    = TRUE;
                    $config_ktp['overwrite']        = TRUE;
                    $config_ktp['file_name']        = 'file_ktp_'.$sql_kary->id.sprintf('%05d', rand(1,256));
                    $this->load->library('upload', $config_ktp);
                    
                    if (!$this->upload->do_upload('fupload')) {
                        $this->session->set_flashdata('master_toast', 'toastr.error("Error : <b>'.$this->upload->display_errors().'</b>");');
//                        redirect((!empty($rute) ? $rute.'&id='.general::enkrip($sql_kary->id) : 'master/data_karyawan_kel.php?id='.$id));
                    } else {
                        $f_ktp          = $this->upload->data();
                        $file_name_ktp  = $f_ktp['orig_name'];
                        $file_type      = $f_ktp['file_type'];
                        $file_ext       = $f_ktp['file_ext'];
                    }
                }
                
               $data = array(
                   'file_name_ktp'  => $file_name_ktp,
                   'file_ext_ktp'   => $file_ext,
                   'file_type_ktp'  => $file_type,
               );
               
               $this->db->where('id', general::dekrip($id_kel))->update('tbl_m_karyawan_kel', $data);
               $last_id = crud::last_id();
               
               $this->session->set_flashdata('master_toast', 'toastr.success("Data Keluarga berhasil disimpan !");');
               redirect(base_url((!empty($rute) ? $rute.'&id='.general::enkrip($sql_kary->id) : 'master/data_karyawan_kel.php?id='.$id)));
              
//                echo '<pre>';
//                print_r($data);
//                echo '</pre>';
//                echo '<pre>';
//                print_r($f);
//                echo '</pre>';
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_karyawan_simpan_pend() {
        if (Akses::aksesLogin() == TRUE) {
            $id         = $this->input->post('id');
            $pendidikan = $this->input->post('pendidikan');
            $jurusan    = $this->input->post('jurusan');
            $instansi   = $this->input->post('instansi');
            $ket        = $this->input->post('keterangan');
            $no_dok     = $this->input->post('no_dok');
            $thn_masuk  = $this->input->post('thn_masuk');
            $thn_keluar = $this->input->post('thn_keluar');
            $status_lls = $this->input->post('status_lulus');
            $rute       = $this->input->post('route');
            
            $pengaturan   = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id', 'NIK', 'required');
            $this->form_validation->set_rules('pendidikan', 'Nama', 'required');
            $this->form_validation->set_rules('jurusan', 'Jenis Klm', 'required');
            $this->form_validation->set_rules('instansi', 'Tempat Lahir', 'required');
            $this->form_validation->set_rules('no_dok', 'Tgl Lahir', 'required');
            $this->form_validation->set_rules('thn_masuk', 'Alamat', 'trim|required|min_length[4]');
            
            # Jika tidak ada berkas, tampilkan error
            if (empty($_FILES['fupload']['name'])){    
                $this->form_validation->set_rules('fupload', 'File', 'required');
            }

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'id'           => form_error('id'),
                    'pendidikan'   => form_error('pendidikan'),
                    'jurusan'      => form_error('jurusan'),
                    'instansi'     => form_error('instansi'),
                    'no_dok'       => form_error('no_dok'),
                    'thn_masuk'    => form_error('thn_masuk'),
                    'fupload'      => form_error('fupload'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url((!empty($rute) ? $rute.'&id='.$id : 'master/data_karyawan_peg.php?id='.$id)));
            } else {
               $sql_kary    = $this->db->where('id', general::dekrip($id))->get('tbl_m_karyawan')->row();
               $path        = 'file/karyawan/'.$sql_kary->id.'/';
               
               if (!empty($_FILES['fupload']['name'])) {                   
                    # Buat Folder Untuk File Karyawan
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }
                    
                    $config['upload_path']      = realpath($path);
                    $config['allowed_types']    = 'jpg|png|pdf|jpeg';
                    $config['remove_spaces']    = TRUE;
                    $config['overwrite']        = TRUE;
                    $config['file_name']        = 'file_pend_'.$sql_kary->id.'_'.sprintf('%05d', rand(1,256));
                    $this->load->library('upload', $config);
                    
                    if (!$this->upload->do_upload('fupload')) {
                        $this->session->set_flashdata('master_toast', 'toastr.error("Error : <b>'.$this->upload->display_errors().'</b>");');
                        redirect(base_url('master/data_karyawan_pend.php?id='.$id));
                    } else {
                        $f          = $this->upload->data();
                        $file_name  = $f['orig_name'];
                        $file_type  = $f['file_type'];
                        $file_ext   = $f['file_ext'];
                    }
                }

                $data = array(
                   'id_karyawan'    => $sql_kary->id,
                   'id_user'        => $this->ion_auth->user()->row()->id,
                   'tgl_simpan'     => date('Y-m-d H:i:s'),
                   'no_dok'         => $no_dok,
                   'pendidikan'     => $pendidikan,
                   'jurusan'        => $jurusan,
                   'instansi'       => $instansi,
                   'thn_masuk'      => (!empty($thn_masuk) ? $thn_masuk : '0000'),
                   'thn_keluar'     => (!empty($thn_keluar) ? $thn_keluar : '0000'),
                   'keterangan'     => $ket,
                   'file_name'      => $file_name,
                   'file_ext'       => $file_ext,
                   'file_type'      => $file_type,
                   'status_lulus'   => $status_lls
               );
                
               $this->db->insert('tbl_m_karyawan_pend', $data);
               
               $this->session->set_flashdata('master_toast', 'toastr.success("Berkas berhasil disimpan !");');
               redirect(base_url((!empty($rute) ? $rute.'&id='.general::enkrip($sql_kary->id) : 'master/data_karyawan_pend.php?id='.$id)));
              
//                echo '<pre>';
//                print_r($data);
//                echo '</pre>';
//                echo '<pre>';
//                print_r($f);
//                echo '</pre>';
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_karyawan_simpan_sert() {
        if (Akses::aksesLogin() == TRUE) {
            $id         = $this->input->post('id');
            $pt         = $this->input->post('pt');
            $jurusan    = $this->input->post('jurusan');
            $instansi   = $this->input->post('instansi');
            $ket        = $this->input->post('ket');
            $no_dok     = $this->input->post('no_dok');
            $tgl_berlaku= $this->input->post('tgl_berlaku');
            $tipe       = $this->input->post('tipe');
            $rute       = $this->input->post('route');
            
            $pengaturan   = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id', 'NIK', 'required');
//            $this->form_validation->set_rules('pt', 'Perguruan Tinggi', 'required');
            $this->form_validation->set_rules('instansi', 'Instansi', 'required');
            $this->form_validation->set_rules('no_dok', 'No. Dokumen', 'required');
            $this->form_validation->set_rules('tgl_berlaku', 'Tgl Berlaku', 'required');
            $this->form_validation->set_rules('tipe', 'Tgl Berlaku', 'required');
            
            # Jika tidak ada berkas, tampilkan error
            if (empty($_FILES['fupload']['name'])){    
                $this->form_validation->set_rules('fupload', 'File', 'required');
            }

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'id'           => form_error('id'),
//                    'pt'           => form_error('pt'),
                    'instansi'     => form_error('instansi'),
                    'no_dok'       => form_error('no_dok'),
                    'thn_masuk'    => form_error('thn_masuk'),
                    'fupload'      => form_error('fupload'),
                    'tipe'         => form_error('tipe'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url((!empty($rute) ? $rute.'&id='.$id : 'master/data_karyawan_sert.php?id='.$id)));
            } else {
               $sql_kary    = $this->db->where('id', general::dekrip($id))->get('tbl_m_karyawan')->row();
               $path        = 'file/karyawan/'.$sql_kary->id.'/';
               $tgl         = explode('-', $tgl_berlaku);
               $tgl_awal    = $this->tanggalan->tgl_indo_sys($tgl[0]);
               $tgl_akhir   = $this->tanggalan->tgl_indo_sys($tgl[1]);
               
               if (!empty($_FILES['fupload']['name'])) {                   
                    # Buat Folder Untuk File Karyawan
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }
                    
                    $config['upload_path']      = realpath($path);
                    $config['allowed_types']    = 'jpg|png|pdf|jpeg';
                    $config['remove_spaces']    = TRUE;
                    $config['overwrite']        = TRUE;
                    $config['file_name']        = 'file_sert_'.$sql_kary->id.'_'.sprintf('%05d', rand(1,256));
                    $this->load->library('upload', $config);
                    
                    if (!$this->upload->do_upload('fupload')) {
                        $this->session->set_flashdata('master_toast', 'toastr.error("Error : <b>'.$this->upload->display_errors().'</b>");');
                        redirect(base_url('master/data_karyawan_sert.php?id='.$id));
                    } else {
                        $f          = $this->upload->data();
                        $file_name  = $f['orig_name'];
                        $file_type  = $f['file_type'];
                        $file_ext   = $f['file_ext'];
                    }
                }

                $data = array(
                   'id_karyawan'    => $sql_kary->id,
                   'id_user'        => $this->ion_auth->user()->row()->id,
                   'tgl_simpan'     => date('Y-m-d H:i:s'),
                   'no_dok'         => $no_dok,
                   'pt'             => $pt,
                   'instansi'       => $instansi,
                   'tgl_masuk'      => (!empty($tgl_awal) ? $tgl_awal : '0000-00-00'),
                   'tgl_keluar'     => (!empty($tgl_akhir) ? $tgl_akhir : '0000-00-00'),
                   'keterangan'     => $ket,
                   'tipe'           => $tipe,
                   'file_name'      => $file_name,
                   'file_ext'       => $file_ext,
                   'file_type'      => $file_type
               );
                
               $this->db->insert('tbl_m_karyawan_sert', $data);
               
               $this->session->set_flashdata('master_toast', 'toastr.success("Berkas berhasil disimpan !");');
               redirect(base_url((!empty($rute) ? $rute.'&id='.general::enkrip($sql_kary->id) : 'master/data_karyawan_sert.php?id='.$id)));
              
//                echo '<pre>';
//                print_r($data);
//                echo '</pre>';
//                echo '<pre>';
//                print_r($f);
//                echo '</pre>';
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_karyawan_simpan_peg() {
        if (Akses::aksesLogin() == TRUE) {
            $id         = $this->input->post('id');
            $kode       = $this->input->post('kode');
            $div        = $this->input->post('divisi');
            $jab        = $this->input->post('jabatan');
            $ket        = $this->input->post('ket');
            $tgl_msk    = $this->input->post('tgl_masuk');
            $tgl_klr    = $this->input->post('tgl_keluar');
            $no_ks      = $this->input->post('no_bpjs_ks');
            $no_tk      = $this->input->post('no_bpjs_tk');
            $no_ptkp    = $this->input->post('no_ptkp');
            $tipe       = $this->input->post('tipe');
            $rute       = $this->input->post('route');
            
            $pengaturan   = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id', 'NIK', 'required');
            $this->form_validation->set_rules('kode', 'Kode', 'required');
            $this->form_validation->set_rules('divisi', 'Divisi', 'required');
            $this->form_validation->set_rules('jabatan', 'Jabatan', 'required');
            $this->form_validation->set_rules('tipe', 'Tipe', 'required');
            $this->form_validation->set_rules('tgl_masuk', 'Tgl Join', 'required');
            
            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'id'        => form_error('id'),
                    'kode'      => form_error('kode'),
                    'divisi'    => form_error('divisi'),
                    'jabatan'   => form_error('jabatan'),
                    'tipe'      => form_error('tipe'),
                    'tgl_masuk' => form_error('tgl_masuk'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url((!empty($rute) ? $rute.'&id='.$id : 'master/data_karyawan_peg.php?id='.$id)));
            } else {
               $sql_kary    = $this->db->where('id', general::dekrip($id))->get('tbl_m_karyawan')->row();
               $tgl_awal    = $this->tanggalan->tgl_indo_sys($tgl_msk);
               $tgl_akhir   = $this->tanggalan->tgl_indo_sys($tgl_klr);
               
               $data = array(
                   'id_karyawan'    => $sql_kary->id,
                   'id_dept'        => $div,
                   'id_jabatan'     => $jab,
                   'id_user'        => $this->ion_auth->user()->row()->id,
                   'tgl_simpan'     => date('Y-m-d H:i:s'),
                   'tgl_masuk'      => (!empty($tgl_awal) ? $tgl_awal : '0000-00-00'),
                   'tgl_keluar'     => (!empty($tgl_akhir) ? $tgl_akhir : '0000-00-00'),
                   'kode'           => $kode,
                   'no_bpjs_ks'     => $no_ks,
                   'no_bpjs_tk'     => $no_tk,
                   'no_ptkp'        => $no_ptkp,
                   'tipe'           => $tipe,
               );
                
               $this->db->insert('tbl_m_karyawan_peg', $data);
               
               $this->session->set_flashdata('master_toast', 'toastr.success("Berkas berhasil disimpan !");');
               redirect(base_url((!empty($rute) ? $rute.'&id='.general::enkrip($sql_kary->id) : 'master/data_karyawan_peg.php?id='.$id)));
              
                echo '<pre>';
                print_r($data);
                echo '</pre>';
                echo '<pre>';
                print_r($f);
                echo '</pre>';
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_karyawan_simpan_cuti() {
        if (Akses::aksesLogin() == TRUE) {
            $id         = $this->input->post('id');
            $kode       = $this->input->post('kode');
            $div        = $this->input->post('divisi');
            $jab        = $this->input->post('jabatan');
            $ket        = $this->input->post('ket');
            $tgl_msk    = $this->input->post('tgl_masuk');
            $tgl_klr    = $this->input->post('tgl_keluar');
            $no_ks      = $this->input->post('no_bpjs_ks');
            $no_tk      = $this->input->post('no_bpjs_tk');
            $no_ptkp    = $this->input->post('no_ptkp');
            $tipe       = $this->input->post('tipe');
            $rute       = $this->input->post('route');
            
            $pengaturan   = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id', 'NIK', 'required');
            $this->form_validation->set_rules('ket', 'Kode', 'required');
            $this->form_validation->set_rules('tgl_masuk', 'Tgl Join', 'required');
            $this->form_validation->set_rules('tgl_keluar', 'Tgl Join', 'required');
            
            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'id'            => form_error('id'),
                    'ket'           => form_error('ket'),
                    'tgl_masuk'     => form_error('tgl_masuk'),
                    'tgl_keluar'    => form_error('tgl_keluar'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url((!empty($rute) ? $rute.'&id='.$id : 'master/data_karyawan_cuti.php?id='.$id)));
            } else {
               $sql_kary    = $this->db->where('id', general::dekrip($id))->get('tbl_m_karyawan')->row();
               $tgl_awal    = $this->tanggalan->tgl_indo_sys($tgl_msk);
               $tgl_akhir   = $this->tanggalan->tgl_indo_sys($tgl_klr);
               
               $data = array(
                   'id_karyawan'    => $sql_kary->id,
                   'id_user'        => $this->ion_auth->user()->row()->id,
                   'tgl_simpan'     => date('Y-m-d H:i:s'),
                   'tgl_masuk'      => (!empty($tgl_awal) ? $tgl_awal : '0000-00-00'),
                   'tgl_keluar'     => (!empty($tgl_akhir) ? $tgl_akhir : '0000-00-00'),
                   'keterangan'     => $ket,
                   'status'         => '0',
               );
                
               $this->db->insert('tbl_m_karyawan_cuti', $data);
               
               $this->session->set_flashdata('master_toast', 'toastr.success("Berkas berhasil disimpan !");');
               redirect(base_url((!empty($rute) ? $rute.'&id='.general::enkrip($sql_kary->id) : 'master/data_karyawan_peg.php?id='.$id)));
              
//                echo '<pre>';
//                print_r($data);
//                echo '</pre>';
//                echo '<pre>';
//                print_r($f);
//                echo '</pre>';
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_karyawan_simpan_jdwl() {
        if (Akses::aksesLogin() == TRUE) {
            $id         = $this->input->post('id');
            $poli       = $this->input->post('poli');
            $stat_prtk  = $this->input->post('status_prtk');
            $wkt_prtk   = $this->input->post('waktu_prtk');
            $rute       = $this->input->post('route');
            
            $pengaturan   = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id', 'NIK', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'id'           => form_error('id'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url((!empty($rute) ? $rute.'&id='.$id : 'master/data_karyawan_jdwl.php?id='.$id)));
            } else {
               $sql_kary    = $this->db->where('id', general::dekrip($id))->get('tbl_m_karyawan')->row();

                $data = array(
                   'id_karyawan'    => $sql_kary->id,
                   'id_user'        => $this->ion_auth->user()->row()->id,
                   'id_poli'        => $poli,
                   'tgl_simpan'     => date('Y-m-d H:i:s'),
                   'hari_1'         => (!empty($_POST['ck_hari'][1]) ? $_POST['ck_hari'][1] : ''),
                   'hari_2'         => (!empty($_POST['ck_hari'][2]) ? $_POST['ck_hari'][2] : ''),
                   'hari_3'         => (!empty($_POST['ck_hari'][3]) ? $_POST['ck_hari'][3] : ''),
                   'hari_4'         => (!empty($_POST['ck_hari'][4]) ? $_POST['ck_hari'][4] : ''),
                   'hari_5'         => (!empty($_POST['ck_hari'][5]) ? $_POST['ck_hari'][5] : ''),
                   'hari_6'         => (!empty($_POST['ck_hari'][6]) ? $_POST['ck_hari'][6] : ''),
                   'hari_7'         => (!empty($_POST['ck_hari'][7]) ? $_POST['ck_hari'][7] : ''),
                   'waktu'          => $wkt_prtk,
                   'status_prtk'    => $stat_prtk,
               );
                
               $this->db->insert('tbl_m_karyawan_jadwal', $data);
               
               $this->session->set_flashdata('master_toast', 'toastr.success("Jadwal dokter berhasil disimpan !");');
               redirect(base_url((!empty($rute) ? $rute.'&id='.general::enkrip($sql_kary->id) : 'master/data_karyawan_jadwal.php?id='.$id)));
              
//                echo '<pre>';
//                print_r($data);
//                echo '</pre>';
//                echo '<pre>';
//                print_r($_POST);
//                echo '</pre>';
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_karyawan_update() {
        if (Akses::aksesLogin() == TRUE) {
            $id           = $this->input->post('id');
            $id_user      = $this->input->post('id_user');
            $nik          = $this->input->post('nik');
            $sip          = $this->input->post('sip');
            $str          = $this->input->post('str');
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
            $this->form_validation->set_rules('nama', 'Nama', 'required');
            $this->form_validation->set_rules('jns_klm', 'Jenis Klm', 'required');
            $this->form_validation->set_rules('tmp_lahir', 'Tempat Lahir', 'required');
            $this->form_validation->set_rules('tgl_lahir', 'Tgl Lahir', 'required');
            $this->form_validation->set_rules('alamat', 'Alamat', 'required');
            $this->form_validation->set_rules('alamat_dom', 'Alamat Dom', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'nik'           => form_error('nik'),
                    'nama'          => form_error('nama'),
                    'jns_klm'       => form_error('jns_klm'),
                    'tmp_lahir'     => form_error('tmp_lahir'),
                    'tgl_lahir'     => form_error('tgl_lahir'),
                    'alamat'        => form_error('alamat'),
                    'alamat_dom'    => form_error('alamat_dom'),
                );
                
                $this->session->set_flashdata('form_error', $msg_error);
                redirect(!empty($rute) ? base_url($rute) : base_url('master/data_karyawan_tambah.php?id='.$id));
            } else {
                $get_grup    = $this->ion_auth->get_users_groups(general::dekrip($id_user))->row();
                $sql_grup    = $this->ion_auth->group($get_grup->id)->row();
                $sql_user_ck = $this->db->where('id', general::dekrip($id_user))->get('tbl_ion_users');
                                
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
                    'id_user'           => $userid,
                    'id_user_group'     => $grup,
                    'nik'               => $nik,
                    'sip'               => $sip,
                    'str'               => $str,
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
                
                $this->session->set_flashdata('master_toast', 'toastr.success("Perubahan berhasil disimpan !");');
                redirect((!empty($rute) ? base_url($rute) : base_url('master/data_karyawan_tambah.php?id='.$id)));

//                echo general::dekrip($id_user);
//                echo '<pre>';
//                print_r($data_penj);
//                echo '</pre>';
//                echo '<pre>';
//                print_r($data_user);
//                echo '</pre>';
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_karyawan_update_kel() {
        if (Akses::aksesLogin() == TRUE) {
            $id             = $this->input->post('id');
            $id_kel         = $this->input->post('id_kel');
            $nm_ayah        = $this->input->post('nm_ayah');
            $tgl_lhr_ayah   = $this->input->post('tgl_lhr_ayah');
            $status_kawin   = $this->input->post('status_kawin');
            $jns_pasangan   = $this->input->post('jns_pasangan');
            $nm_ibu         = $this->input->post('nm_ibu');
            $tgl_lhr_ibu    = $this->input->post('tgl_lhr_ibu');
            $nm_pasangan    = $this->input->post('nm_pasangan');
            $nm_anak        = $this->input->post('nm_anak');
            $tgl_lhr_psg    = $this->input->post('tgl_lhr_psg');
            $status_kawin   = $this->input->post('status_kawin');
            $rute           = $this->input->post('route');
            
            $pengaturan   = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id', 'NIK', 'required');
            $this->form_validation->set_rules('nm_ayah', 'Kode', 'required');
            $this->form_validation->set_rules('nm_ibu', 'Divisi', 'required');
            
            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'id'        => form_error('id'),
                    'nm_ayah'   => form_error('nm_ayah'),
                    'nm_ibu'    => form_error('nm_ibu'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url((!empty($rute) ? $rute.'&id='.$id : 'master/data_karyawan_kel.php?id='.$id)));
            } else {
               $sql_kary    = $this->db->where('id', general::dekrip($id))->get('tbl_m_karyawan')->row();
               $sql_kel     = $this->db->where('id', general::dekrip($id_kel))->get('tbl_m_karyawan_kel');
               $path        = 'file/karyawan/'.$sql_kary->id.'/';
               $tgl_awal    = $this->tanggalan->tgl_indo_sys($tgl_msk);
               $tgl_akhir   = $this->tanggalan->tgl_indo_sys($tgl_klr);
                              
               # Buat Folder Untuk File KK
               if (!empty($_FILES['fupload']['name'])) {              
                    # Buat Folder Untuk File Karyawan
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }
                    
                    $config['upload_path']      = realpath($path);
                    $config['allowed_types']    = 'jpg|png|pdf|jpeg';
                    $config['remove_spaces']    = TRUE;
                    $config['overwrite']        = TRUE;
                    $config['file_name']        = 'file_kk_'.$sql_kary->id.sprintf('%05d', rand(1,256));
                    $this->load->library('upload', $config);
                    
                    if (!$this->upload->do_upload('fupload')) {
                        $this->session->set_flashdata('master_toast', 'toastr.error("Error : <b>'.$this->upload->display_errors().'</b>");');
//                        redirect((!empty($rute) ? $rute.'&id='.general::enkrip($sql_kary->id) : 'master/data_karyawan_kel.php?id='.$id));
                    } else {
                        $f          = $this->upload->data();
                        $file_name  = $f['orig_name'];
                        $file_type  = $f['file_type'];
                        $file_ext   = $f['file_ext'];
                    }
                }
                
                $data = array(
                    'id_karyawan'   => $sql_kary->id,
                    'id_user'       => $this->ion_auth->user()->row()->id,
                    'tgl_simpan'    => date('Y-m-d H:i:s'),
                    'tgl_lhr_ayah'  => ($tgl_lhr_ayah != '0000-00-00' ? $this->tanggalan->tgl_indo_sys($tgl_lhr_ayah) : '0000-00-00'),
                    'tgl_lhr_ibu'   => ($tgl_lhr_ibu != '0000-00-00' ? $this->tanggalan->tgl_indo_sys($tgl_lhr_ibu) : '0000-00-00'),
                    'tgl_lhr_psg'   => ($tgl_lhr_psg != '0000-00-00' ? $this->tanggalan->tgl_indo_sys($tgl_lhr_psg) : '0000-00-00'),
                    'nm_ayah'       => (!empty($nm_ayah) ? $nm_ayah : ''),
                    'nm_ibu'        => (!empty($nm_ibu) ? $nm_ibu : ''),
                    'nm_pasangan'   => (!empty($nm_pasangan) ? $nm_pasangan : ''),
                    'nm_anak'       => (!empty($nm_anak) ? $nm_anak : ''),
                    'status_kawin'  => (!empty($status_kawin) ? $status_kawin : '0'),
                    'jns_pasangan'  => (!empty($jns_pasangan) ? $jns_pasangan : '0'),
                    'file_name'     => $file_name,
                    'file_type'     => $file_type,
                    'file_ext'      => $file_ext,
                );
               
               $this->db->insert('tbl_m_karyawan_kel', $data);
               $last_id = crud::last_id();
               
               $this->session->set_flashdata('master_toast', 'toastr.success("Data Keluarga berhasil disimpan !");');
               redirect(base_url((!empty($rute) ? $rute.'&id='.general::enkrip($sql_kary->id) : 'master/data_karyawan_kel.php?id='.$id)));
              
//                echo '<pre>';
//                print_r($data);
//                echo '</pre>';
//                echo '<pre>';
//                print_r($f);
//                echo '</pre>';
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_karyawan_hapus() {
        if (Akses::aksesLogin() == TRUE) {
            $id = $this->input->get('id');
            
            if(!empty($id)){
                $sql_user = $this->db->where('id', general::dekrip($id))->get('tbl_m_karyawan')->row();
                
                $this->ion_auth->delete_user($sql_user->id_user);
                crud::delete('tbl_m_karyawan','id',general::dekrip($id));
            }
            
            redirect(base_url('master/data_karyawan_list.php'));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_karyawan_hapus_pend() {
        if (Akses::aksesLogin() == TRUE) {
            $id  = $this->input->get('id');
            $fl  = $this->input->get('file_name');
            $idk = $this->input->get('id_karyawan');
            $rute= $this->input->get('route');
            
            if(!empty($id)){
                $sql_user   = $this->db->where('id', general::dekrip($idk))->get('tbl_m_karyawan')->row();
                $berkas     = realpath('./file/karyawan/'.$sql_user->id).'/'.$fl;
                
                if(file_exists($berkas)){
                    unlink($berkas);
                }
                
                $this->db->where('id', general::dekrip($id))->delete('tbl_m_karyawan_pend');
                $this->session->set_flashdata('master_toast', 'toastr.success("Berkas berhasil dihapus !");');
            }
            
            redirect(base_url((!empty($rute) ? $rute.'&id='.$idk : 'master/data_karyawan_pend.php?id='.$idk)));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_karyawan_hapus_sert() {
        if (Akses::aksesLogin() == TRUE) {
            $id  = $this->input->get('id');
            $fl  = $this->input->get('file_name');
            $idk = $this->input->get('id_karyawan');
            $rute = $this->input->get('route');
            
            if(!empty($id)){
                $sql_user   = $this->db->where('id', general::dekrip($idk))->get('tbl_m_karyawan')->row();
                $berkas     = realpath('./file/karyawan/'.$sql_user->id).'/'.$fl;
                
                if(file_exists($berkas)){
                    unlink($berkas);
                }
                
                $this->db->where('id', general::dekrip($id))->delete('tbl_m_karyawan_sert');
                $this->session->set_flashdata('master_toast', 'toastr.success("Berkas berhasil dihapus !");');
            }
            
            redirect(base_url((!empty($rute) ? $rute.'&id='.$idk : 'master/data_karyawan_sert.php?id='.$idk)));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_karyawan_hapus_peg() {
        if (Akses::aksesLogin() == TRUE) {
            $id  = $this->input->get('id');
            $fl  = $this->input->get('file_name');
            $idk = $this->input->get('id_karyawan');
            $rute = $this->input->get('route');
            
            if(!empty($id)){
                $sql_user   = $this->db->where('id', general::dekrip($idk))->get('tbl_m_karyawan')->row();
                
                $this->db->where('id', general::dekrip($id))->delete('tbl_m_karyawan_peg');
                $this->session->set_flashdata('master_toast', 'toastr.success("Berkas berhasil dihapus !");');
            }
            
            redirect(base_url((!empty($rute) ? $rute.'&id='.$idk : 'master/data_karyawan_peg.php?id='.$idk)));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_karyawan_hapus_jdwl() {
        if (Akses::aksesLogin() == TRUE) {
            $id  = $this->input->get('id');
            $idk = $this->input->get('id_karyawan');
            $rute = $this->input->get('route');
            
            if(!empty($id)){                
                $this->db->where('id', general::dekrip($id))->delete('tbl_m_karyawan_jadwal');
                $this->session->set_flashdata('master_toast', 'toastr.success("Jadwal dokter berhasil dihapus !");');
            }
            
            redirect(base_url((!empty($rute) ? $rute.'&id='.$idk : 'master/data_karyawan_jadwal.php?id='.$idk)));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
       
    public function data_karyawan_upload() {
        if (Akses::aksesLogin() == TRUE) {
            $this->load->helper('file');
            
            if (!empty($_FILES['fupload']['name'])) {
                $folder = realpath('file/import');
                $config['upload_path']      = './file/import';
                $config['allowed_types']    = 'xls|xlsx';
                $config['remove_spaces']    = TRUE;
                $config['overwrite']        = TRUE;
                $this->load->library('upload', $config);
                
                if (!$this->upload->do_upload('fupload')) {
                    $this->session->set_flashdata('pengaturan', 'Error : <b>' . $this->upload->display_errors() . '</b>.');
                    redirect(base_url('master/data_customer_import.php?err='.$this->upload->display_errors()));
                }else{
                    $f           = $this->upload->data();
                    $path        = realpath('./file/import') . '/';                    
                    $objPHPExcel = PHPExcel_IOFactory::load($path.$f['orig_name']);
                    
                    foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                        $worksheetTitle     = $worksheet->getTitle();
                        $highestRow         = $worksheet->getHighestRow();
                        $highestColumn      = $worksheet->getHighestColumn();
                        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
                        
                        for ($row = 3; $row <= $highestRow; ++ $row) {
                            $val=array();
                            
                            for ($col = 0; $col < $highestColumnIndex; ++$col) {
                                $cell = $worksheet->getCellByColumnAndRow($col, $row);
                                $val[] = $cell->getValue();
                            }
                            
                            $produk = array(
                                'tgl_simpan'  => date('Y-m-d H:i:s'),
                                'kode'        => $val[1],
                                'nik'         => $val[2],
                                'nama'        => $val[3],
                                'no_hp'       => $val[4],
                                'kota'        => $val[5],
                                'alamat'      => $val[6],
                            );
                            
                            crud::simpan('tbl_m_karyawan', $produk);
                        }
                    }
                    
                    unlink($path.$f['orig_name']);
                    redirect(base_url('master/data_karyawan_list.php'));
                }
            }  
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    
    public function data_aps_list() {
        if (Akses::aksesLogin() == TRUE) {
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
            $kd      = $this->input->get('filter_nik');
            $gr      = $this->input->get('filter_grup');
            $jml     = $this->input->get('jml');
            
            $data['hasError'] = $this->session->flashdata('form_error');
            
            if(!empty($jml)){
                $jml_hal = $jml;
            }else{
                $jml_hal = $this->db->select('*')
                                ->where('status_aps', '1')
                                ->like('nik', $kd)
                                ->like('nama', $cs)
                                ->like('id_user_group', $gr)
                                ->order_by('id', 'desc')
                                ->get('tbl_m_karyawan')->num_rows();
            }
                        
            $config['base_url']              = base_url('master/data_aps_list.php?'.(!empty($gr) ? 'filter_grup='.$gr.'&' : '').(!empty($kd) ? 'filter_nik='.$kd.'&' : '').(!empty($cs) ? 'filter_nama='.$cs : '').(!empty($jml_hal) ? '&jml='.$jml_hal : ''));
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
            
            
            if (!empty($hal)) {
                $data['sales'] = $this->db->select('*')
                                        ->where('status_aps', '1')
                                        ->like('nama', $cs)
                                        ->like('id_user_group', $gr)
                                        ->limit($config['per_page'], $hal)
                                        ->order_by('id', 'desc')
                                        ->get('tbl_m_karyawan')->result();
            } else {
                $data['sales'] = $this->db->select('*')
                                ->where('status_aps', '1')
                                ->like('nama', $cs)
                                ->like('id_user_group', $gr)
                                ->limit($config['per_page'])
                                ->order_by('id', 'desc')
                                ->get('tbl_m_karyawan')->result();
            }

            $this->pagination->initialize($config);
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/master/sidebar_aps';
            /* --- Sidebar Menu --- */
            
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();
            $data['cetak']      = '<button type="button" onclick="window.location.href = \''.base_url('master/cetak_data_karyawan.php?'.(!empty($query) ? 'query='.$query : '').(!empty($jml) ? '&jml='.$jml : '')).'\'" class="btn btn-warning btn-flat"><i class="fa fa-print"></i> Cetak</button>';

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/master/data_aps_list', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_aps_tambah() {
        if (Akses::aksesLogin() == TRUE) {
            $id   = $this->input->get('id');
            
            if(!empty($id)){
                $data['sql_kary']      = $this->db->where('id', general::dekrip($id))->get('tbl_m_karyawan')->row();
            }
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/master/sidebar_aps';
            /* --- Sidebar Menu --- */

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/master/data_aps_tambah', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_aps_simpan() {
        if (Akses::aksesLogin() == TRUE) {
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
            $act          = $this->input->post('act');
            $id_medc      = $this->input->post('id_medc');
            $id_lab       = $this->input->post('id_lab');
            $status       = $this->input->post('status');
            $rute         = $this->input->post('route');
            
            $pengaturan   = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('nama', 'Nama', 'required');
//            $this->form_validation->set_rules('jns_klm', 'Jenis Klm', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'nama'          => form_error('nama'),
//                    'jns_klm'       => form_error('jns_klm'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url('master/data_karyawan_tambah.php'));
            } else {
                $sql_num    = $this->db->select('COUNT(*) AS jml')->where('status_aps', '1')->get('tbl_m_karyawan')->row()->jml + 1;
                $kode_no    = sprintf('%05d', $sql_num);
                
                $user       = 'aps'.$kode_no;
                $email      = 'aps'.$kode_no.'@'.$pengaturan->website;
                $pass2      = 'admin1234';
                $grup       = '10';
                $cek        = $this->db->select('username')->where('username', $user)->get('tbl_ion_users')->num_rows();
                
//                if($cek > 0){
//                    $this->session->set_flashdata('member', '<div class="alert alert-danger">Username sudah ada</div>');
//                    redirect(base_url('master/data_karyawan_tambah.php'));
//                }else{               
//                    if(!empty($user) AND !empty($pass2)) {
                        $data_user = array(
                            'id_app'        => $pengaturan->id_app,
                            'first_name'    => $nama,
                            'nama_dpn'      => $nama_dpn,
                            'nama_blk'      => $nama_blk,
                            'username'      => $user,
                            'password'      => $pass2,
                            'tipe'          => '1',
                        );
                        
                        $this->ion_auth->register($user, $pass2, $email, $data_user, array($grup));
                        $last_id_user = $this->db->where('username', $user)->get('tbl_ion_users')->row()->id;
//                    }
//                }

                $data_kary = array(
                    'id_user'           => (!empty($last_id_user) ? $last_id_user : '0'),
                    'id_user_group'     => '10',
                    'tgl_simpan'        => date('Y-m-d H:i:s'),
                    'kode'              => $user,
                    'nama'              => $nama,
                    'nama_dpn'          => $nama_dpn,
                    'nama_blk'          => $nama_blk,
                    'alamat'            => $alamat,
                    'no_hp'             => $no_hp,
                    'jns_klm'           => $jns_klm,
                    'status_aps'        => '1'
                );

                $this->db->insert('tbl_m_karyawan', $data_kary);
                $last_id = crud::last_id();

                $this->session->set_flashdata('master_toast', 'toastr.success("Data dokter aps berhasil dibuat !");');
                redirect(base_url((!empty($rute) ? $rute.'?act='.$act.'&id='.$id_medc.'&id_lab='.$id_lab.'&status='.$status : 'master/data_aps_tambah.php?id='.general::enkrip($last_id))));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_aps_update() {
        if (Akses::aksesLogin() == TRUE) {
            $id           = $this->input->post('id');
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
            
            $pengaturan   = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

//            $this->form_validation->set_rules('id', 'Nama', 'required');
            $this->form_validation->set_rules('nama', 'Nama', 'required');
//            $this->form_validation->set_rules('jns_klm', 'Jenis Klm', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
//                    'id'            => form_error('id'),
                    'nama'          => form_error('nama'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url('master/data_karyawan_tambah.php'));
            } else {
                $sql_num    = $this->db->get('tbl_m_karyawan')->num_rows() + 1;
                $kode_no    = sprintf('%05d', $sql_num);

                $get_grup   = $this->ion_auth->get_users_groups(general::dekrip($id_user))->row();
                $sql_grup   = $this->ion_auth->group($get_grup->id)->row();

                $data_kary = array(
                    'tgl_modif'         => date('Y-m-d H:i:s'),
                    'nama'              => $nama,
                    'nama_dpn'          => $nama_dpn,
                    'nama_blk'          => $nama_blk,
                    'alamat'            => $alamat,
                    'no_hp'             => $no_hp,
                    'jns_klm'           => $jns_klm,
                    'status_aps'        => '1'
                );

                $this->db->where('id', general::dekrip($id))->update('tbl_m_karyawan', $data_kary);
                $last_id = general::dekrip($id);

                $this->session->set_flashdata('master_toast', 'toastr.success("Data dokter aps berhasil diubah !");');
                redirect(base_url('master/data_aps_tambah.php?id='.general::enkrip($last_id)));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_aps_hapus() {
        if (Akses::aksesLogin() == TRUE) {
            $id = $this->input->get('id');
            
            if(!empty($id)){
                $sql_user = $this->db->where('id', general::dekrip($id))->get('tbl_m_karyawan')->row();
                
                $this->ion_auth->delete_user($sql_user->id_user);
                crud::delete('tbl_m_karyawan','id',general::dekrip($id));
            }
            
            redirect(base_url('master/data_aps_list.php'));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    
    public function data_mcu_perusahaan_list() {
        if (Akses::aksesLogin() == TRUE) {
            $hal            = $this->input->get('halaman');
            $filter_kode    = $this->input->get('filter_kode');
            $filter_nama    = $this->input->get('filter_nama');
            $sort_type      = $this->input->get('sort_type');
            $sort_order     = $this->input->get('sort_order');
            $jml            = $this->input->get('jml');
            $jml_hal        = (!empty($jml) ? $jml  : $this->db->count_all('tbl_m_pelanggan'));
            $pengaturan     = $this->db->get('tbl_pengaturan')->row();
            
            $data['hasError'] = $this->session->flashdata('form_error');
                        
            $config['base_url']              = base_url('master/data_mcu_perusahaan_list.php?'.(!empty($filter_kode) ? 'filter_kode='.$filter_kode.'&' : '').(!empty($filter_nama) ? 'filter_nama='.$filter_nama.'&' : '').'jml='.$_GET['jml']);
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
                if (!empty($jml)) {
                    $data['supplier'] = $this->db
                                             ->like('nama', $filter_nama)
                                             ->like('kode', $filter_kode)
                                             ->limit($config['per_page'],$hal)
                                             ->order_by('kode', 'desc')
                                             ->get('tbl_m_pelanggan')->result();
                } else {
                    $data['supplier'] = $this->db
                                             ->limit($config['per_page'],$hal)
                                             ->order_by('kode', 'desc')
                                             ->get('tbl_m_pelanggan')->result();
                }
            }else{
                if (!empty($jml)) {
                    $data['supplier'] = $this->db
                                             ->like('nama', $filter_nama)
                                             ->like('kode', $filter_kode)
                                             ->limit($config['per_page'])
                                             ->order_by('kode', 'desc')
                                             ->get('tbl_m_pelanggan')->result();
                } else {
                    $data['supplier'] = $this->db
                                             ->limit($config['per_page'])
                                             ->order_by('kode', 'desc')
                                             ->get('tbl_m_pelanggan')->result();
                }
            }
            
            $this->pagination->initialize($config);
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/master/sidebar_mcu';
            /* --- Sidebar Menu --- */
            
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();
            $data['cetak']      = '<button type="button" onclick="window.location.href = \''.base_url('master/cetak_data_mcu_perusahaan.php?'.(!empty($query) ? 'query='.$query : '').(!empty($jml) ? '&jml='.$jml : '')).'\'" class="btn btn-warning btn-flat"><i class="fa fa-print"></i> Cetak</button>';

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/master/data_mcu_perusahaan_list', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_mcu_perusahaan_tambah() {
        if (Akses::aksesLogin() == TRUE) {
            $id   = $this->input->get('id');
            
            $data['supplier'] = $this->db->where('id', general::dekrip($id))->get('tbl_m_pelanggan')->row();
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/master/sidebar_mcu';
            /* --- Sidebar Menu --- */

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/master/data_mcu_perusahaan_tambah', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_mcu_perusahaan_simpan() {
        if (Akses::aksesLogin() == TRUE) {
            $nama       = $this->input->post('nama');
            $alamat     = $this->input->post('alamat');
            $no_hp      = $this->input->post('no_hp');
            $cp         = $this->input->post('cp');
            $tipe       = $this->input->post('tipe');
            $rute       = $this->input->post('route');
            $idp        = $this->input->post('id_pasien');
            
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('nama', 'Nama', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'nama'     => form_error('nama'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url('master/data_mcu_perusahaan_tambah.php'));
            } else {
                $sql_num = $this->db->get('tbl_m_pelanggan')->num_rows() + 1;
                $kode    = 'MCU-'.sprintf('%03d', $sql_num);
                
                $data_penj = array(
                    'tgl_simpan' => date('Y-m-d H:i:s'),
                    'kode'       => $kode,
                    'nama'       => $nama,
                    'alamat'     => $alamat,
                    'no_hp'      => $no_hp,
                    'cp'         => $cp,
                );
                
                $this->session->set_flashdata('member', '<div class="alert alert-success">Data rekanan berhasil disimpan</div>');
                crud::simpan('tbl_m_pelanggan', $data_penj);
                redirect(base_url(!empty($rute) ? $rute.'?tipe_pas='.$tipe.(!empty($idp) ? '&id_pasien='.$idp : '') : 'master/data_mcu_perusahaan_list.php'));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_mcu_perusahaan_update() {
        if (Akses::aksesLogin() == TRUE) {
            $id           = $this->input->post('id');
            $npwp         = $this->input->post('npwp');
            $kode         = $this->input->post('kode');
            $nama         = $this->input->post('nama');
            $alamat       = $this->input->post('alamat');
            $kota         = $this->input->post('kota');
            $no_hp        = $this->input->post('no_hp');
            $no_tlp       = $this->input->post('no_tlp');
            $tgl_lhr      = $this->input->post('tgl_lahir');
            $jns_klm      = $this->input->post('jns_klm');
            $cp           = $this->input->post('cp');
            
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('kode', 'Kode', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'kode'     => form_error('kode'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url('master/data_mcu_perusahaan_tambah.php?id='.$id));
            } else {                
                $data_penj = array(
                    'tgl_modif'   => date('Y-m-d H:i:s'),
                    'kode'        => $kode,
                    'nama'        => $nama,
                    'npwp'        => $npwp,
                    'alamat'      => $alamat,
                    'kota'        => $kota,
                    'no_hp'       => $no_hp,
                    'no_tlp'      => $no_tlp,
                    'cp'          => $cp,
                );
                
                $this->session->set_flashdata('member', '<div class="alert alert-success">Data supplier berhasil diubah</div>');
                crud::update('tbl_m_pelanggan','id', general::dekrip($id),$data_penj);
                redirect(base_url('master/data_mcu_perusahaan_tambah.php?id='.$id));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_mcu_perusahaan_hapus() {
        if (Akses::aksesLogin() == TRUE) {
            $id = $this->input->get('id');
            
            if(!empty($id)){                
                crud::delete('tbl_m_pelanggan','id',general::dekrip($id));
            }
            
            redirect(base_url('master/data_mcu_perusahaan_list.php'));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    
    public function data_supplier_list() {
        if (Akses::aksesLogin() == TRUE) {
            $hal            = $this->input->get('halaman');
            $filter_kode    = $this->input->get('filter_kode');
            $filter_nama    = $this->input->get('filter_nama');
            $sort_type      = $this->input->get('sort_type');
            $sort_order     = $this->input->get('sort_order');
            $jml            = $this->input->get('jml');
            $jml_hal        = (!empty($jml) ? $jml  : $this->db->count_all('tbl_m_supplier'));
            $pengaturan     = $this->db->get('tbl_pengaturan')->row();
            
            $data['hasError'] = $this->session->flashdata('form_error');
                        
            $config['base_url']              = base_url('master/data_supplier_list.php?'.(!empty($filter_kode) ? 'filter_kode='.$filter_kode.'&' : '').(!empty($filter_nama) ? 'filter_nama='.$filter_nama.'&' : '').'jml='.$_GET['jml']);
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
                if (!empty($jml)) {
                    $data['supplier'] = $this->db
                                             ->like('nama', $filter_nama)
                                             ->like('kode', $filter_kode)
                                             ->limit($config['per_page'],$hal)
                                             ->order_by('kode', 'desc')
                                             ->get('tbl_m_supplier')->result();
                } else {
                    $data['supplier'] = $this->db
                                             ->limit($config['per_page'],$hal)
                                             ->order_by('kode', 'desc')
                                             ->get('tbl_m_supplier')->result();
                }
            }else{
                if (!empty($jml)) {
                    $data['supplier'] = $this->db
                                             ->like('nama', $filter_nama)
                                             ->like('kode', $filter_kode)
                                             ->limit($config['per_page'])
                                             ->order_by('kode', 'desc')
                                             ->get('tbl_m_supplier')->result();
                } else {
                    $data['supplier'] = $this->db
                                             ->limit($config['per_page'])
                                             ->order_by('kode', 'desc')
                                             ->get('tbl_m_supplier')->result();
                }
            }
            
            $this->pagination->initialize($config);
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/master/sidebar_supplier';
            /* --- Sidebar Menu --- */
            
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();
            $data['cetak']      = '<button type="button" onclick="window.location.href = \''.base_url('master/cetak_data_supplier.php?'.(!empty($query) ? 'query='.$query : '').(!empty($jml) ? '&jml='.$jml : '')).'\'" class="btn btn-warning btn-flat"><i class="fa fa-print"></i> Cetak</button>';

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/master/data_supplier_list', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
        
    public function data_supplier_import() {
        if (Akses::aksesLogin() == TRUE) {
            $id   = $this->input->get('id');
            
            $data['barang'] = $this->db->where('id', general::dekrip($id))->get('tbl_m_produk')->row();
            $data['satuan'] = $this->db->get('tbl_m_satuan')->result();
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/master/sidebar_supplier';
            /* --- Sidebar Menu --- */

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/master/data_supplier_import', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_supplier_tambah() {
        if (Akses::aksesLogin() == TRUE) {
            $id   = $this->input->get('id');
            
            $data['supplier'] = $this->db->where('id', general::dekrip($id))->get('tbl_m_supplier')->row();
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/master/sidebar_supplier';
            /* --- Sidebar Menu --- */

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/master/data_supplier_tambah', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_supplier_simpan() {
        if (Akses::aksesLogin() == TRUE) {
            $npwp         = $this->input->post('npwp');
            $kode         = $this->input->post('kode');
            $nama         = $this->input->post('nama');
            $alamat       = $this->input->post('alamat');
            $kota         = $this->input->post('kota');
            $no_hp        = $this->input->post('no_hp');
            $no_tlp       = $this->input->post('no_tlp');
            $cp           = $this->input->post('cp');
            
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('nama', 'Nama', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'nama'     => form_error('nama'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url('master/data_supplier_tambah.php'));
            } else {
                $sql_num    = $this->db->order_by('kode', 'desc')->get('tbl_m_supplier');
                $kd         = explode('-', $sql_num->row()->kode);
                $num        = $kd[1] + 1;
                $kode       = 'P-'.sprintf('%03d', $num);
                
                $data = array(
                    'tgl_simpan'  => date('Y-m-d H:i:s'),
                    'kode'        => $kode,
                    'nama'        => $nama,
                    'npwp'        => $npwp,
                    'alamat'      => $alamat,
                    'kota'        => $kota,
                    'no_hp'       => $no_hp,
                    'no_tlp'      => $no_tlp,
                    'cp'          => $cp,
                );
                
                $this->db->insert('tbl_m_supplier', $data);
                
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('master_toast', 'toastr.success("Data supplier berhasil disimpan !");');
                }else{
                    $this->session->set_flashdata('master_toast', 'toastr.error("Data supplier gagal disimpan !");');
                }
                
                redirect(base_url('master/data_supplier_list.php'));
                
//                echo '<pre>';
//                print_r($data);
//                echo '</pre>';
//                echo '<pre>';
//                print_r($kd);
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_supplier_simpan2() {
        if (Akses::aksesLogin() == TRUE) {
            $npwp         = $this->input->post('npwp');
            $kode         = $this->input->post('kode');
            $nama         = $this->input->post('nama');
            $alamat       = $this->input->post('alamat');
            $kota         = $this->input->post('kota');
            $no_hp        = $this->input->post('no_hp');
            $no_tlp       = $this->input->post('no_tlp');
            $cp           = $this->input->post('cp');
            
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

//            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
//
//            $this->form_validation->set_rules('kode', 'kode', 'required');
//
//            if ($this->form_validation->run() == FALSE) {
//                $msg_error = array(
//                    'kode'     => form_error('kode'),
//                );
//
//                $this->session->set_flashdata('form_error', $msg_error);
//                redirect(base_url('master/data_supplier_tambah.php'));
//            } else {                
                $data_penj = array(
                    'tgl_simpan'  => date('Y-m-d H:i:s'),
                    'kode'        => $kode,
                    'nama'        => $nama,
                    'npwp'        => $npwp,
                    'alamat'      => $alamat,
                    'kota'        => $kota,
                    'no_hp'       => $no_hp,
                    'no_tlp'      => $no_tlp,
                    'cp'          => $cp,
                );
                
                $this->session->set_flashdata('member', '<div class="alert alert-success">Data member berhasil diubah</div>');
                crud::simpan('tbl_m_supplier', $data_penj);
//                redirect(base_url('master/data_supplier_list.php'));
//            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_supplier_update() {
        if (Akses::aksesLogin() == TRUE) {
            $id           = $this->input->post('id');
            $npwp         = $this->input->post('npwp');
            $kode         = $this->input->post('kode');
            $nama         = $this->input->post('nama');
            $alamat       = $this->input->post('alamat');
            $kota         = $this->input->post('kota');
            $no_hp        = $this->input->post('no_hp');
            $no_tlp       = $this->input->post('no_tlp');
            $tgl_lhr      = $this->input->post('tgl_lahir');
            $jns_klm      = $this->input->post('jns_klm');
            $cp           = $this->input->post('cp');
            
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('kode', 'Kode', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'kode'     => form_error('kode'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url('master/data_supplier_tambah.php?id='.$id));
            } else {                
//                $sql_num    = $this->db->order_by('kode', 'desc')->get('tbl_m_supplier');
//                $kd         = explode('-', $sql_num->row()->kode);
//                $num        = $kd[1] + 1;
//                $kode       = 'P-'.sprintf('%03d', $num);
                
                $data = array(
                    'tgl_simpan'  => date('Y-m-d H:i:s'),
                    'kode'        => $kode,
                    'nama'        => $nama,
                    'npwp'        => $npwp,
                    'alamat'      => $alamat,
                    'kota'        => $kota,
                    'no_hp'       => $no_hp,
                    'no_tlp'      => $no_tlp,
                    'cp'          => $cp,
                );
                
                $this->db->where('id', general::dekrip($id))->update('tbl_m_supplier', $data);
                
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('master_toast', 'toastr.success("Data supplier berhasil disimpan !");');
                }else{
                    $this->session->set_flashdata('master_toast', 'toastr.error("Data supplier gagal disimpan !");');
                }
                
                redirect(base_url('master/data_supplier_tambah.php?id='.$id));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_supplier_upload() {
        if (Akses::aksesLogin() == TRUE) {
            $this->load->helper('file');
            
            if (!empty($_FILES['fupload']['name'])) {
                $folder = realpath('file/import');
                $config['upload_path']      = './file/import';
                $config['allowed_types']    = 'xls|xlsx';
                $config['remove_spaces']    = TRUE;
                $config['overwrite']        = TRUE;
                $this->load->library('upload', $config);
                
                if (!$this->upload->do_upload('fupload')) {
                    $this->session->set_flashdata('pengaturan', 'Error : <b>' . $this->upload->display_errors() . '</b>.');
                    redirect(base_url('master/data_supplier_import.php?err='.$this->upload->display_errors()));
                }else{
                    $f           = $this->upload->data();
                    $path        = realpath('./file/import') . '/';                    
                    $objPHPExcel = PHPExcel_IOFactory::load($path.$f['orig_name']);
                    
                    foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                        $worksheetTitle     = $worksheet->getTitle();
                        $highestRow         = $worksheet->getHighestRow();
                        $highestColumn      = $worksheet->getHighestColumn();
                        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
                        
                        for ($row = 3; $row <= $highestRow; ++ $row) {
                            $val=array();
                            
                            for ($col = 0; $col < $highestColumnIndex; ++$col) {
                                $cell = $worksheet->getCellByColumnAndRow($col, $row);
                                $val[] = $cell->getValue();
                            }
                            
                            $produk = array(
                                'tgl_simpan'  => date('Y-m-d H:i:s'),
                                'kode'        => $val[1],
                                'npwp'        => $val[2],
                                'nama'        => $val[3],
                                'no_tlp'      => $val[4],
                                'no_hp'       => $val[5],
                                'cp'          => $val[6],
                                'alamat'      => $val[7],
                            );
                            
                            crud::simpan('tbl_m_supplier', $produk);
                        }
                    }
                    
                    unlink($path.$f['orig_name']);
                    redirect(base_url('master/data_supplier_list.php'));
                }
            }  
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }   
    
    public function data_supplier_hapus() {
        if (Akses::aksesLogin() == TRUE) {
            $id = $this->input->get('id');
            
            if(!empty($id)){
                crud::delete('tbl_m_supplier','id',general::dekrip($id));
                
                $this->session->set_flashdata('master_toast', 'toastr.success("Data supplier berhasil dihapus !");');
            }
            
            redirect(base_url('master/data_supplier_list.php'));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function data_supplier_xls(){
        if (Akses::aksesLogin() == TRUE) {
            $query      = $this->input->get('q');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();
            
            if (!empty($query)) {
                $sql = $this->db->like('nama', $query)->or_like('kode', $query)->or_like('npwp', $query)->or_like('no_hp', $query)->or_like('no_tlp', $query)->or_like('alamat', $query)->order_by(!empty($sort_type) ? $sort_type : 'nama', (isset($sort_order) ? $sort_order : 'asc'))->get('tbl_m_supplier')->result();
            } else {
                $sql = $this->db->order_by(!empty($sort_type) ? $sort_type : 'nama', (isset($sort_order) ? $sort_order : 'asc'))->get('tbl_m_supplier')->result();
            }

            $objPHPExcel = new PHPExcel();
            
            // Header Tabel Nota
//            $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(TRUE);
            
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'No.')
                    ->setCellValue('B1', 'Kode')
                    ->setCellValue('C1', 'NIK / NPWP')
                    ->setCellValue('D1', 'Nama')
                    ->setCellValue('E1', 'No. Telp')
                    ->setCellValue('F1', 'No. HP')
                    ->setCellValue('G1', 'CP')
                    ->setCellValue('H1', 'Alamat')
                    ->setCellValue('I1', 'Kota');
            
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(55);  
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);  
                        
            // Detail barang
            $no    = 1;
            $cell  = 2;
            $cel   = 8;
            foreach ($sql as $items){ 
                // Format Angka
//                $objPHPExcel->getActiveSheet()->getStyle('G' . $cell.':I'.$cell)->getNumberFormat()->setFormatCode("#.##0");
                
                // Format Alignment
                $objPHPExcel->getActiveSheet()->getStyle('A'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('B'.$cell.':I'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A'.$cell, $no)
                            ->setCellValue('B'.$cell, $items->kode)
                            ->setCellValue('C'.$cell, $items->npwp)
                            ->setCellValue('D'.$cell, $items->nama)
                            ->setCellValue('E'.$cell, $items->no_tlp)
                            ->setCellValue('F'.$cell, $items->no_hp)
                            ->setCellValue('G'.$cell, $items->cp)
                            ->setCellValue('H'.$cell, $items->alamat)
                            ->setCellValue('I'.$cell, $items->kota);

                $no++;
                $cell++;
            }
            
            // Rename worksheet
            $objPHPExcel->getActiveSheet()->setTitle('Supplier');

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
            $objPHPExcel->getProperties()->setCreator("MIKHAEL FELIAN <mikhaelfelian@gmail.com>;")
                    ->setLastModifiedBy(strtoupper($this->ion_auth->user()->row()->first_name))
                    ->setTitle("Data Supplier")
                    ->setSubject("Aplikasi Bengkel POS")
                    ->setDescription("Kunjungi http://tigerasoft.co.id atau hubungi 085741220427 untuk info lebih lanjut.")
                    ->setKeywords(strtoupper($pengaturan->judul))
                    ->setCategory("PHPExcel exported apps");


            // Redirect output to a client’s web browser spreadsheet format
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="data_supplier_'.date('ymd').'.xlsx"');

            // If you're serving to IE over SSL, then the following may be needed
            header('Expires: Mon, 15 Feb 1992 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0
            
            ob_clean();
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('php://output');            
            exit;
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();            
        }
    }
    
    
    public function data_platform_list() {
        if (Akses::aksesLogin() == TRUE) {
            $kode       = $this->input->get('filter_kode');
            $akun       = $this->input->get('filter_akun');
            $plat       = $this->input->get('filter_plat');
            $hal        = $this->input->get('halaman');
            $jml        = $this->input->get('jml');
            $jml_hal    = (!empty($jml) ? $jml  : $this->db->count_all('tbl_m_platform'));
            $pengaturan = $this->db->get('tbl_pengaturan')->row();
            
            $data['hasError'] = $this->session->flashdata('form_error');
                        
            $config['base_url']              = base_url('master/data_platform_list.php?'.(isset($_GET['q']) ? '&q='.$_GET['q'].'&jml='.$_GET['jml'] : ''));
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
            
            
            if(!empty($hal)){
                $data['platform'] = $this->db
                                             ->limit($config['per_page'], $hal)
                                             ->like('kode', $kode)
                                             ->like('akun', $akun)
                                             ->like('platform', $plat)
                                             ->order_by('platform', 'asc')->get('tbl_m_platform')->result();
            }else{
                $data['platform'] = $this->db
                                             ->limit($config['per_page'])
                                             ->like('kode', $kode)
                                             ->like('akun', $akun)
                                             ->like('platform', $plat)
                                             ->order_by('platform', 'asc')->get('tbl_m_platform')->result();
            }
            
            $this->pagination->initialize($config);
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/master/sidebar_platform';
            /* --- Sidebar Menu --- */
            
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();
            $data['cetak']      = '<button type="button" onclick="window.location.href = \''.base_url('master/cetak_data_platform.php?'.(!empty($query) ? 'query='.$query : '').(!empty($jml) ? '&jml='.$jml : '')).'\'" class="btn btn-warning btn-flat"><i class="fa fa-print"></i> Cetak</button>';

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/master/data_platform_list', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_platform_tambah() {
        if (Akses::aksesLogin() == TRUE) {
            $id   = $this->input->get('id');
            
            $data['platform'] = $this->db->where('id', general::dekrip($id))->get('tbl_m_platform')->row();
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/master/sidebar_platform';
            /* --- Sidebar Menu --- */

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/master/data_platform_tambah', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_platform_simpan() {
        if (Akses::aksesLogin() == TRUE) {
            $akun        = $this->input->post('akun');
            $kode        = $this->input->post('kode');
            $platform    = $this->input->post('platform');
            $persen      = $this->input->post('biaya');
            $keterangan  = $this->input->post('keterangan');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('platform', 'Platform', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'platform'     => form_error('platform'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url('master/data_platform_tambah.php?id='.$id));
            } else {                
                $data_penj = array(
                    'kode'       => $kode,
                    'akun'       => $akun,
                    'platform'   => $platform,
                    'persen'     => $persen,
                    'keterangan' => $keterangan
                );
                
                $this->session->set_flashdata('master', '<div class="alert alert-success">Data platform disimpan</div>');
                crud::simpan('tbl_m_platform',$data_penj);
                redirect(base_url('master/data_platform_list.php'));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_platform_update() {
        if (Akses::aksesLogin() == TRUE) {
            $id          = $this->input->post('id');
            $akun        = $this->input->post('akun');
            $kode        = $this->input->post('kode');
            $platform    = $this->input->post('platform');
            $persen      = $this->input->post('biaya');
            $keterangan  = $this->input->post('keterangan');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('platform', 'Platform', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'platform'     => form_error('platform'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url('master/data_platform_tambah.php?id='.$id));
            } else {                
                $data_penj = array(
                    'akun'       => $akun,
                    'kode'       => $kode,
                    'platform'   => $platform,
                    'persen'     => $persen,
                    'keterangan' => $keterangan
                );
                
                $this->session->set_flashdata('master', '<div class="alert alert-success">Data platform diubah</div>');
                crud::update('tbl_m_platform','id', general::dekrip($id),$data_penj);
                redirect(base_url('master/data_platform_tambah.php?id='.$id));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_platform_hapus() {
        if (Akses::aksesLogin() == TRUE) {
            $id = $this->input->get('id');
            
            if(!empty($id)){
                crud::delete('tbl_m_platform','id',general::dekrip($id));
            }
            
            redirect(base_url('master/data_platform_list.php'));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_platform_pjm_list() {
        if (Akses::aksesLogin() == TRUE) {
            $query       = $this->input->get('q');
            $hal         = $this->input->get('halaman');
            $jml         = $this->input->get('jml');
            $jml_hal     = (!empty($jml) ? $jml  : $this->db->count_all('tbl_m_penjamin'));
            $pengaturan  = $this->db->get('tbl_pengaturan')->row();
            
            $data['hasError'] = $this->session->flashdata('form_error');
                        
            $config['base_url']               = base_url('master/data_platform_pjm_list.php?'.(isset($_GET['q']) ? '&q='.$_GET['q'].'&jml='.$_GET['jml'] : ''));
            $config['total_rows']             = $jml_hal;
            
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
            
            
            if(!empty($hal)){
                if (!empty($query)) {
                    $data['platform'] = $this->db->limit($config['per_page'],$hal)->like('penjamin', $query)->order_by('penjamin','asc')->get('tbl_m_penjamin')->result();
                } else {
                    $data['platform'] = $this->db->limit($config['per_page'],$hal)->order_by('penjamin','asc')->get('tbl_m_penjamin')->result();
                }
            }else{
                if (!empty($query)) {
                    $data['platform'] = $this->db->limit($config['per_page'],$hal)->like('penjamin', $query)->order_by('penjamin','asc')->get('tbl_m_penjamin')->result();
                } else {
                    $data['platform'] = $this->db->limit($config['per_page'])->order_by('penjamin','asc')->get('tbl_m_penjamin')->result();
                }
            }
            
            $this->pagination->initialize($config);
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/master/sidebar_platform';
            /* --- Sidebar Menu --- */
            
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();
            $data['cetak']      = '<button type="button" onclick="window.location.href = \''.base_url('master/cetak_data_platform.php?'.(!empty($query) ? 'query='.$query : '').(!empty($jml) ? '&jml='.$jml : '')).'\'" class="btn btn-warning btn-flat"><i class="fa fa-print"></i> Cetak</button>';

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/master/data_penjamin_list', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_platform_pjm_tambah() {
        if (Akses::aksesLogin() == TRUE) {
            $id   = $this->input->get('id');
            
            $data['platform'] = $this->db->where('id', general::dekrip($id))->get('tbl_m_penjamin')->row();
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/master/sidebar_platform';
            /* --- Sidebar Menu --- */

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/master/data_penjamin_tambah', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_platform_pjm_simpan() {
        if (Akses::aksesLogin() == TRUE) {
            $kode        = $this->input->post('kode');
            $platform    = $this->input->post('penjamin');
            $persen      = $this->input->post('biaya');
            $status      = $this->input->post('status');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('platform', 'Platform', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'platform'     => form_error('platform'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url('master/data_platform_pjm_tambah.php?id='.$id));
            } else {                
                $data_penj = array(
                    'tgl_simpan' => date('Y-m-d H:i:s'),
                    'kode'       => $kode,
                    'penjamin'   => $platform,
                    'persen'     => $persen,
                    'status'     => $status,
                );
                
                $this->session->set_flashdata('master', '<div class="alert alert-success">Data platform disimpan</div>');
                crud::simpan('tbl_m_penjamin',$data_penj);
                redirect(base_url('master/data_platform_pjm_list.php'));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_platform_pjm_update() {
        if (Akses::aksesLogin() == TRUE) {
            $id          = $this->input->post('id');
            $kode        = $this->input->post('kode');
            $platform    = $this->input->post('penjamin');
            $persen      = $this->input->post('biaya');
            $status      = $this->input->post('status');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('platform', 'Platform', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'platform'     => form_error('platform'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url('master/data_platform_pjm_tambah.php?id='.$id));
            } else {                
                $data_penj = array(
                    'tgl_simpan' => date('Y-m-d H:i:s'),
                    'kode'       => $kode,
                    'penjamin'   => $platform,
                    'persen'     => $persen,
                    'status'     => $status,
                );
                
                $this->session->set_flashdata('master', '<div class="alert alert-success">Data platform diubah</div>');
                crud::update('tbl_m_penjamin','id', general::dekrip($id),$data_penj);
                redirect(base_url('master/data_platform_pjm_tambah.php?id='.$id));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_platform_pjm_hapus() {
        if (Akses::aksesLogin() == TRUE) {
            $id = $this->input->get('id');
            
            if(!empty($id)){
                crud::delete('tbl_m_penjamin','id',general::dekrip($id));
            }
            
            redirect(base_url('master/data_platform_pjm_list.php'));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    
    public function data_biaya_list() {
        if (Akses::aksesLogin() == TRUE) {
            $query      = $this->input->get('q');
            $hal        = $this->input->get('halaman');
            $jml        = $this->input->get('jml');
            $jml_hal    = (!empty($jml) ? $jml  : $this->db->where('tipe', 'keluar')->get('tbl_akt_kas')->num_rows());
            $pengaturan = $this->db->get('tbl_pengaturan')->row();
            
            $data['hasError'] = $this->session->flashdata('form_error');
                        
            $config['base_url']              = base_url('master/data_biaya_list.php?'.(isset($_GET['q']) ? '&q='.$_GET['q'].'&jml='.$_GET['jml'] : ''));
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
            
            
            if(!empty($hal)){
                if (!empty($query)) {
                    $data['biaya'] = $this->db->select('DATE(tgl_simpan) as tgl, id, id_jenis, kode, keterangan, nominal')->where('tipe', 'keluar')->limit($config['per_page'],$hal)->like('nama', $query)->get('tbl_akt_kas')->result();
                } else {
                    $data['biaya'] = $this->db->select('DATE(tgl_simpan) as tgl, id, id_jenis, kode, keterangan, nominal')->where('tipe', 'keluar')->limit($config['per_page'],$hal)->order_by('id','asc')->get('tbl_akt_kas')->result();
                }
            }else{
                if (!empty($query)) {
                    $data['biaya'] = $this->db->select('DATE(tgl_simpan) as tgl, id, id_jenis, kode, keterangan, nominal')->where('tipe', 'keluar')->limit($config['per_page'],$hal)->like('nama', $query)->get('tbl_akt_kas')->result();
                } else {
                    $data['biaya'] = $this->db->select('DATE(tgl_simpan) as tgl, id, id_jenis, kode, keterangan, nominal')->where('tipe', 'keluar')->limit($config['per_page'])->order_by('id','asc')->get('tbl_akt_kas')->result();
                }
            }
            
            $this->pagination->initialize($config);
            
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
//            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/master/data_biaya_list', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_biaya_tambah() {
        if (Akses::aksesLogin() == TRUE) {
            $id   = $this->input->get('id');
            
            $data['no_nota']    = general::no_nota('','tbl_akt_kas', 'kode', "WHERE tipe='keluar'"); //no_nota($string,$tabel_nama, $tabel_kolom, $where)
            $data['jenis']      = $this->db->get('tbl_akt_kas_jns')->result();
            $data['biaya']      = $this->db->select('DATE(tgl_simpan) as tgl, id, id_jenis, kode, keterangan, nominal')->where('id', general::dekrip($id))->get('tbl_akt_kas')->row();

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
//            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/master/data_biaya_tambah', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_biaya_jns_simpan() {
        if (Akses::aksesLogin() == TRUE) {
            $id           = $this->input->post('id');
            $jenis        = $this->input->post('jenis');
            $nominal      = str_replace('.','', $this->input->post('nominal'));
            
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('jenis', 'jenis', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'jenis'     => form_error('jenis'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url('master/data_biaya_tambah.php?case=jenis_biaya'.(!empty($id) ? '&id='.$id : '')));
            } else {                
                $data_penj = array(
                    'jenis'      => $jenis,
                    'keterangan' => '-',
                    'nominal'    => $nominal,
                );
                
                $this->session->set_flashdata('member', '<div class="alert alert-success">Data jenis biaya disimpan</div>');
                crud::simpan('tbl_akt_kas_jns', $data_penj);
                redirect(base_url('master/data_biaya_tambah.php?case=jenis_biaya'.(!empty($id) ? '&id='.$id : '')));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_biaya_simpan() {
        if (Akses::aksesLogin() == TRUE) {
            $tgl          = explode('/',$this->input->post('tgl'));
            $kode         = $this->input->post('kode');
            $jenis        = $this->input->post('jenis');
            $ket          = $this->input->post('keterangan');
            $nominal      = str_replace('.','', $this->input->post('nominal'));
            
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('kode', 'kode', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'kode'     => form_error('kode'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url('master/data_biaya_tambah.php'));
            } else {                
                $data_penj = array(
                    'tgl_simpan'  => $tgl[2].'-'.$tgl[0].'-'.$tgl[1].' '.date('H:i:s'),
                    'kode'        => $kode,
                    'id_user'     => $this->ion_auth->user()->row()->id,
                    'id_jenis'    => $jenis,
                    'keterangan'  => $ket,
                    'nominal'     => $nominal,
                    'debet'       => $nominal,
                    'tipe'        => 'keluar',
                    'status_kas'  => 'kas',
                );
                
                $this->session->set_flashdata('member', '<div class="alert alert-success">Data member berhasil diubah</div>');
                crud::simpan('tbl_akt_kas', $data_penj);
                redirect(base_url('master/data_biaya_list.php'));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_biaya_update() {
        if (Akses::aksesLogin() == TRUE) {
            $id           = $this->input->post('id');
            $tgl          = explode('/',$this->input->post('tgl'));
            $kode         = $this->input->post('kode');
            $jenis        = $this->input->post('jenis');
            $ket          = $this->input->post('keterangan');
            $nominal      = str_replace('.','', $this->input->post('nominal'));
            
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('kode', 'Kode', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'kode'     => form_error('kode'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url('master/data_biaya_tambah.php?id='.$id));
            } else {                
                $data_penj = array(
                    'tgl_simpan'  => $tgl[2].'-'.$tgl[0].'-'.$tgl[1].' '.date('H:i:s'),
                    'kode'        => $kode,
                    'id_user'     => $this->ion_auth->user()->row()->id,
                    'id_jenis'    => $jenis,
                    'keterangan'  => $ket,
                    'nominal'     => $nominal,
                    'debet'       => $nominal,
                    'tipe'        => 'keluar',
                    'status_kas'  => 'kas',
                );
                
                $this->session->set_flashdata('member', '<div class="alert alert-success">Data biaya berhasil diubah</div>');
                crud::update('tbl_akt_kas','id', general::dekrip($id),$data_penj);
                redirect(base_url('master/data_biaya_tambah.php?id='.$id));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_biaya_hapus() {
        if (Akses::aksesLogin() == TRUE) {
            $id = $this->input->get('id');
            
            if(!empty($id)){
                crud::delete('tbl_akt_kas','id',general::dekrip($id));
            }
            
            redirect(base_url('master/data_biaya_list.php'));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_biaya_jns_hapus() {
        if (Akses::aksesLogin() == TRUE) {
            $id  = $this->input->get('id');
            $aid = $this->input->get('aid');
            
            if(!empty($aid)){
                crud::delete('tbl_akt_kas_jns','id',general::dekrip($aid));
            }
            
            redirect(base_url('master/data_biaya_tambah.php?case=jenis_biaya&id='.$id));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }    

    public function data_pasien_list() {
        if (Akses::aksesLogin() == TRUE) {
            $hal             = $this->input->get('halaman');
            $filter_kode     = $this->input->get('filter_cm');
            $filter_nik      = $this->input->get('filter_nik');
            $filter_nama     = $this->input->get('filter_nama');
            $sort_type       = $this->input->get('sort_type');
            $sort_order      = $this->input->get('sort_order');
            $jml             = $this->input->get('jml');
            $jml_hal         = (!empty($jml) ? $jml  : $this->db->count_all('tbl_m_pasien'));
            $pengaturan      = $this->db->get('tbl_pengaturan')->row();
            
            $data['hasError'] = $this->session->flashdata('form_error');
                        
            $config['base_url']               = base_url('master/data_pasien_list.php?'.(!empty($sort_order) ? '&sort_order='.$sort_order : '').(isset($_GET['filter_cm']) ? '&filter_cm='.$this->input->get('filter_cm') : '').(isset($_GET['filter_nama']) ? '&filter_nama='.$this->input->get('filter_nama') : '').'&jml='.$_GET['jml']);
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
                if (!empty($jml)) {
                    $data['pasien'] = $this->db->limit($config['per_page'],$hal)
                                                 ->like('kode', $filter_kode)
                                                 ->like('nik', $filter_nik)
                                                 ->like('nama_pgl', $filter_nama)
                                               ->order_by(!empty($sort_type) ? $sort_type : 'nama', (!empty($sort_order) ? $sort_order : 'asc'))
                                               ->get('tbl_m_pasien')->result();
                } else {
                    $data['pasien'] = $this->db->limit($config['per_page'],$hal)->order_by(!empty($sort_type) ? $sort_type : 'nama', (isset($sort_order) ? $sort_order : 'asc'))->get('tbl_m_pasien')->result();
                }
            }else{
                if (!empty($jml)) {
                    $data['pasien'] = $this->db->limit($config['per_page'])
                                                 ->like('kode', $filter_kode)
                                                 ->like('nik', $filter_nik)
                                                 ->like('nama_pgl', $filter_nama)
                                               ->order_by(!empty($sort_type) ? $sort_type : 'nama', (!empty($sort_order) ? $sort_order : 'asc'))
                                               ->get('tbl_m_pasien')->result();
                } else {
                    $data['pasien'] = $this->db->limit($config['per_page'])->order_by(!empty($sort_type) ? $sort_type : 'nama', (isset($sort_order) ? $sort_order : 'asc'))->get('tbl_m_pasien')->result();
                }
            }
            
            $this->pagination->initialize($config);
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/master/sidebar_cust';
            /* --- Sidebar Menu --- */
            
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();
//            $data['cetak']      = '<button type="button" onclick="window.location.href = \''.base_url('master/cetak_data_customer.php?'.(!empty($query) ? 'query='.$query : '').(!empty($filter_produk) ? '&filter_produk='.$filter_produk : '').(!empty($filter_hpp) ? '&filter_hpp='.$filter_hpp : '').(!empty($filter_harga) ? '&filter_harga='.$filter_harga : '').(!empty($jml) ? '&jml='.$jml : '')).'\'" class="btn btn-warning btn-flat"><i class="fa fa-print"></i> Cetak</button>';

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/master/data_pasien_list', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_pasien_tambah() {
        if (Akses::aksesLogin() == TRUE) {
            $id   = $this->input->get('id');
            
            $data['pasien']  = $this->db->where('id', general::dekrip($id))->get('tbl_m_pasien')->row();
            $data['satuan']   = $this->db->get('tbl_m_satuan')->result();
            $data['gelar']    = $this->db->get('tbl_m_gelar')->result();
            $data['kerja']    = $this->db->get('tbl_m_jenis_kerja')->result();
            $data['kategori'] = $this->db->get('tbl_m_kategori')->result();
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/master/sidebar_cust';
            /* --- Sidebar Menu --- */

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/master/data_pasien_tambah', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_pasien_det() {
        if (Akses::aksesLogin() == TRUE) {
            $id         = $this->input->get('id');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();
            
            $data['pasien']     = $this->db->where('id', general::dekrip($id))->get('tbl_m_pasien')->row();
            $data['rm']         = $this->db->where('id_pasien', general::dekrip($id))->where('tipe !=', '3')->limit(10)->order_by('id', 'desc')->get('tbl_trans_medcheck')->result();
//            $data['rmi']      = $this->db->where('id_pasien', general::dekrip($id))->where('tipe', '3')->limit(10)->order_by('id', 'desc')->get('tbl_trans_medcheck')->result();
            $data['rmi']        = $this->db->where('id_pasien', general::dekrip($id))->limit(10)->order_by('id', 'desc')->get('tbl_trans_medcheck_rm')->result();
            $data['rmlab']      = $this->db->where('id_pasien', general::dekrip($id))->limit(10)->order_by('id', 'desc')->get('tbl_trans_medcheck_lab')->result();
            $data['rmrad']      = $this->db->where('id_pasien', general::dekrip($id))->limit(10)->order_by('id', 'desc')->get('tbl_trans_medcheck_rad')->result();
            $data['rmfile']     = $this->db->select('id,DATE(tgl_simpan) AS tgl_simpan')->where('id_pasien', general::dekrip($id))->limit(10)->group_by('DATE(tgl_simpan)')->order_by('id', 'desc')->get('tbl_trans_medcheck_file')->result();
            $data['rmobat']     = $this->db->where('id_pasien', general::dekrip($id))->group_by('DATE(tgl_simpan)')->limit(10)->get('v_medcheck_apotik')->result();
            $data['rmpoin']     = $this->db->where('id_pasien', general::dekrip($id))->where('YEAR(tgl_bayar)', $pengaturan->tahun_poin)->get('v_medcheck')->result();
            $data['rmpoinklr']  = $this->db->where('id_pasien', general::dekrip($id))->where('YEAR(tgl_bayar)', $pengaturan->tahun_poin)->where('jml_potongan_poin >', '0')->get('v_medcheck')->result();
            $data['satuan']     = $this->db->get('tbl_m_satuan')->result();
            $data['kategori']   = $this->db->get('tbl_m_kategori')->result();
            $data['sql_poin']   = $this->db->select('SUM(jml_poin) as jml_poin, SUM(jml_poin_nom) AS jml_poin_nom')->where('id_pasien', general::dekrip($id))->where('YEAR(tgl_simpan)', $pengaturan->tahun_poin)->get('tbl_m_pasien_poin')->row();
            $data['pengaturan'] = $pengaturan;
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/master/sidebar_cust';
            /* --- Sidebar Menu --- */

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/master/data_pasien_det', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_pasien_simpan() {
        if (Akses::aksesLogin() == TRUE) {
            $nik          = $this->input->post('nik');
            $gelar        = $this->input->post('gelar');
            $nama         = $this->input->post('nama');
            $no_hp        = $this->input->post('no_hp');
            $tmp_lahir    = $this->input->post('tmp_lahir');
            $tgl_lahir    = str_replace('/', '-', $this->input->post('tgl_lahir'));
            $alamat       = $this->input->post('alamat');
            $jns_klm      = $this->input->post('jns_klm');
            $pekerjaan    = $this->input->post('pekerjaan');
            $file         = $this->input->post('file');
            
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('nik', 'NIK', 'required');
            $this->form_validation->set_rules('gelar', 'Gelar', 'required');
            $this->form_validation->set_rules('nama', 'Nama Pasien', 'required');
            $this->form_validation->set_rules('jns_klm', 'Jenis Kelamin', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'nik'     => form_error('nik'),
                    'gelar'   => form_error('gelar'),
                    'nama'    => form_error('nama'),
                    'jns_klm' => form_error('jns_klm'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url('master/data_pasien_tambah.php'));
            } else {
                $sql_num = $this->db->get('tbl_m_pasien')->num_rows() + 1;
                $sql_glr = $this->db->where('id', $gelar)->get('tbl_m_gelar')->row();
                $kode    = sprintf('%05d', $sql_num);
                $sql_kat = $this->db->get('tbl_m_kategori');

                $data_pas = array(
                    'tgl_simpan'   => date('Y-m-d H:i:s'),
                    'id_gelar'     => $gelar,
                    'id_kategori'  => '1',
                    'id_pekerjaan' => $pekerjaan,
                    'kode'         => $kode,
                    'kode_dpn'     => 'PKE',
                    'nik'          => $nik,
                    'nama'         => $nama,
                    'nama_pgl'     => strtoupper($sql_glr->gelar.' '.$nama),
                    'tmp_lahir'    => $tmp_lahir,
                    'tgl_lahir'    => $this->tanggalan->tgl_indo_sys($tgl_lahir),
                    'jns_klm'      => $jns_klm,
                    'no_hp'        => $no_hp,
                    'alamat'       => $alamat,
                    'file_base64'  => $file,
                    'status'       => '1'
                );
                
                $this->session->set_flashdata('member', '<div class="alert alert-success">Data member berhasil diubah</div>');
                crud::simpan('tbl_m_pasien', $data_pas);
//                
//                $sql_max = $this->db->select_max('id')->get('tbl_m_pelanggan')->row();
//                $sql_ckk = $this->db->where('id_pelanggan', general::dekrip($id))->get('tbl_m_pelanggan_diskon');
//                
//                foreach ($sql_kat->result() as $kat){                    
//                    $data_disk = array(
//                        'tgl_simpan'   => date('Y-m-d H:i:s'),
//                        'id_pelanggan' => $sql_max->id,
//                        'id_kategori'  => $kat->id,
//                        'disk1'        => str_replace(',','.', $_POST['disk1'][$kat->id]),
//                        'disk2'        => str_replace(',','.', $_POST['disk2'][$kat->id]),
//                        'disk3'        => str_replace(',','.', $_POST['disk3'][$kat->id]),
//                    );
//                    
//                    echo '<pre>';
//                    print_r($data_disk);
//                    
//                    if($_POST['disk1'][$kat->id] != '0' AND $_POST['disk2'][$kat->id] != '0' AND $_POST['disk3'][$kat->id] != '0'){
//                        crud::simpan('tbl_m_pelanggan_diskon',$data_disk);
//                        crud::update('tbl_m_pelanggan','id', $sql_max->id, array('id_kategori' => $kat->id));
//                    }
//                }
                
                redirect(base_url('master/data_pasien_list.php'));
//                echo strtotime($tgl_lahir);
//                echo br();
//                echo date('Y-m-d', strtotime($tgl_lahir));
//                    echo '<pre>';
//                    print_r($data_pas);
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_pasien_update() {
        if (Akses::aksesLogin() == TRUE) {
            $id           = $this->input->post('id');
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
            $file         = $this->input->post('file');
            $file_id      = $this->input->post('file_id');
            $rute         = $this->input->post('route');
            
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id', 'ID', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'id'     => form_error('id'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url('master/data_customer_tambah.php'));
            } else {
                $sql        = $this->db->where('id', general::dekrip($id))->get('tbl_m_pasien');
                $sql_glr    = $this->db->where('id', $gelar)->get('tbl_m_gelar')->row();
                $pasien     = $sql->row();
                
                $path       = realpath('file/pasien').'/';
                $kode       = sprintf('%05d', $pasien->id);
            
                $no_rm      = 'pke' . $kode;
                $path_file  = 'file/pasien/' . $no_rm . '/';

                $filename   = $path . 'profile_' . $kode . '.png';
                $filename_id= $path . 'ID_' . $kode . '.png';
                
                if(!empty($file) OR !empty($file_id)){
                    general::base64_to_jpeg($file, $filename);
                    general::base64_to_jpeg($file_id, $filename_id);
                }
                
                if(!empty($file) OR !empty($file_id)){
                    $data_pas = array(
                        'tgl_modif'    => date('Y-m-d H:i:s'),
                        'id_gelar'     => $gelar,
                        'id_pekerjaan' => $pekerjaan,
                        'nik'          => $nik,
                        'nama'         => $nama,
                        'nama_pgl'     => strtoupper($sql_glr->gelar.' '.$nama),
                        'tmp_lahir'    => $tmp_lahir,
                        'tgl_lahir'    => $this->tanggalan->tgl_indo_sys($tgl_lahir),
                        'jns_klm'      => $jns_klm,
                        'no_hp'        => $no_hp,
                        'no_telp'      => $no_rmh,
                        'alamat'       => $alamat,
                        'alamat_dom'   => (!empty($alamat_dom) ? $alamat_dom : ''),
                        'file_name'    => (file_exists($filename) ? $filename : ''),
                        'file_name_id' => (file_exists($filename_id) ? $filename_id : ''),
                        'file_ext'     => (file_exists($filename) || file_exists($filename_id) ? '.png' : ''),
                        'file_type'    => (file_exists($filename) || file_exists($filename_id) ? 'image/png' : ''),
                        'status'       => '1'
                    );
                }else{
                    $data_pas = array(
                        'tgl_modif'    => date('Y-m-d H:i:s'),
                        'id_gelar'     => $gelar,
                        'id_pekerjaan' => $pekerjaan,
                        'nik'          => $nik,
                        'nama'         => $nama,
                        'nama_pgl'     => strtoupper($sql_glr->gelar.' '.$nama),
                        'tmp_lahir'    => $tmp_lahir,
                        'tgl_lahir'    => $this->tanggalan->tgl_indo_sys($tgl_lahir),
                        'jns_klm'      => $jns_klm,
                        'no_hp'        => $no_hp,
                        'no_telp'      => $no_rmh,
                        'alamat'       => $alamat,
                        'alamat_dom'   => (!empty($alamat_dom) ? $alamat_dom : ''),
                        'status'       => '1'
                    );
                }
                
                $this->db->where('id', $pasien->id)->update('tbl_m_pasien', $data_pas);
                
                # Update Data Username pasien
                $pass2          = $this->tanggalan->tgl_indo8($tgl_lahir); # Format kata sandi pasien menggunakan tanggal lahir dd-mm-yyyy jika tanggal lahir kosong maka passwordnya sama dengan username
                
                $data_user = array(
                    'first_name'    => $nama,
                    'nama'          => strtoupper($sql_glr->gelar.' '.$nama),
                    'address'       => $alamat,
                    'phone'         => $no_hp,
                    'birthdate'     => $this->tanggalan->tgl_indo_sys($tgl_lahir),
                    'file_name'     => (file_exists($filename) ? $filename : ''),
                    'username'      => $no_rm,
                    'password'      => $pass2,
                );
                
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('master_toast', 'toastr.success("Data pasien berhasil disimpan !");');
                }else{
                    $this->session->set_flashdata('master_toast', 'toastr.error("Data pasien gagal disimpan !");');
                } 
                    
                # Update foto pasien via file upload
                # Upload file foto
                $kode   = sprintf('%05d', $pasien->kode);
                $no_rm  = strtolower($pengaturan->kode_pasien).$kode;
                $path   = 'file/pasien/'.$no_rm.'/';
                $folder = realpath('./'.$path);

                if (!empty($_FILES['fupload']['name'])) {                    
                    # Buat Folder Untuk Foto Pasien
                    if(!file_exists($path)){
                        mkdir($path, 0777, true);
                    }
                    
                    $config['upload_path']      = $folder;
                    $config['allowed_types']    = 'jpg|png|pdf|jpeg|jfif';
                    $config['remove_spaces']    = TRUE;
                    $config['overwrite']        = TRUE;
                    $config['file_name']        = 'profile_'.$no_rm; // general::dekrip($id).sprintf('%05d', rand(1,256));
                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('fupload')) {
                        $this->session->set_flashdata('master_toast', 'toastr.error("Foto pasien gagal disimpan !");');
//                        redirect(base_url('medcheck/tambah.php'.(!empty($dft_id) ? '?dft_pas='.general::enkrip($pasien).'&dft_id='.general::enkrip($dft_id) : '').'&err='.$this->upload->display_errors()));
                    } else {
                        $f      = $this->upload->data();
                        
                        # Data File
                        $data_file = array(
                            'file_name'     => $path.$f['orig_name'],
                            'file_type'     => $f['file_type'],
                            'file_ext'      => $f['file_ext'],
                        );

                        # Simpan File Gambar ke tabel
                        $this->db->where('id', $pasien->id)->update('tbl_m_pasien', $data_file);
                    }
                }
                
                if(!empty($rute)){
                    redirect(base_url($rute));
                }else{
                    redirect(base_url('master/data_pasien_det.php?id='.$id));
                }                
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_pasien_hapus() {
        if (Akses::aksesLogin() == TRUE) {
            $id      = $this->input->get('id');
            $id_user = $this->input->get('id_user');
            $hl      = $this->input->get('halaman');
            
            if(!empty($id)){
                $this->ion_auth->delete_user(general::dekrip($id_user)); 
                crud::delete('tbl_m_pasien','id',general::dekrip($id));
            }
            
            redirect(base_url('master/data_pasien_list.php?'.(isset($_GET['q']) ? '&q='.$this->input->get('q') : '').(isset($_GET['jml']) ? '&jml='.$this->input->get('jml') : '').(isset($_GET['halaman']) ? '&halaman='.$this->input->get('halaman') : '')));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_pasien_user() {
        if (Akses::aksesLogin() == TRUE) {
            $id = $this->input->get('id');
            $kd = $this->input->get('kode');
            $hl = $this->input->get('halaman');
            
            if(!empty($id)){
                $pengaturan     = $this->db->get('tbl_pengaturan')->row();
                $sql_user       = $this->db->where('username', $kd)->get('tbl_ion_users');
                $sql_pasien     = $this->db->where('id', general::dekrip($id))->get('tbl_m_pasien')->row();
                $sql_user       = $this->db->select('username')->where('username', $no_rm)->get('tbl_ion_users');
                $sql_user_rw    = $sql_user->row();
                $no_rm          = strtolower($pengaturan->kode_pasien).$sql_pasien->kode;
                $email          = $no_rm.'@'.$pengaturan->website; # Format Email
                $user           = $no_rm; # Format username pasien menggunakan no rm
                $pass2          = ($sql_pasien->tgl_lahir == '0000-00-00' ? $user : $this->tanggalan->tgl_indo8($sql_pasien->tgl_lahir)); # Format kata sandi pasien menggunakan tanggal lahir dd-mm-yyyy jika tanggal lahir kosong maka passwordnya sama dengan username
                
                if($sql_user->num_rows() == 0){
                    $data_user = array(
                        'email'         => $email,
                        'first_name'    => $sql_pasien->nama,
                        'nama'          => $sql_pasien->nama_pgl,
                        'address'       => $sql_pasien->alamat,
                        'phone'         => $sql_pasien->kontak,
                        'birthdate'     => $sql_pasien->tgl_lahir,
                        'file_name'     => $sql_pasien->file_name,
                        'username'      => $no_rm,
                        'tipe'          => '2',
                    );
                    
                    # Simpan ke modul user
                    $this->ion_auth->register($user, $pass2, $email, $data_user, array('15'));
                    
                    $sql_user_ck = $this->db->select('id, username')->where('username', $no_rm)->get('tbl_ion_users')->row();
                    $id_user = $sql_user_ck->id;
                    
                    $this->db->where('id', $id_user)->update('tbl_m_pasien', array('id_user'=>$id_user));
                    
                    $this->session->set_flashdata('medcheck_toast', 'toastr.success("Pasien ini sudah bisa log in ke aplikasi");');
                }
            }
            
            redirect(base_url('master/data_pasien_det.php?id='.general::enkrip($sql_pasien->id)));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_pasien_user_reset() {
        if (Akses::aksesLogin() == TRUE) {
            $id = $this->input->get('id');
            $kd = $this->input->get('kode');
            $hl = $this->input->get('halaman');
            
            if(!empty($id)){
                $pengaturan     = $this->db->get('tbl_pengaturan')->row();
                $sql_user_ck    = $this->db->where('username', $kd)->get('tbl_ion_users');
                $sql_user_ck_rw = $sql_user_ck->row();
                $sql_pasien     = $this->db->where('id', general::dekrip($id))->get('tbl_m_pasien')->row();
                $no_rm          = strtolower($pengaturan->kode_pasien).$sql_pasien->kode;
                $sql_user       = $this->db->select('username')->where('username', $no_rm)->get('tbl_ion_users');
                $sql_user_rw    = $sql_user->row();
                $email          = $no_rm.'@'.$pengaturan->website; # Format Email
                $user           = $no_rm; # Format username pasien menggunakan no rm
                $pass2          = ($sql_pasien->tgl_lahir == '0000-00-00' ? $user : $this->tanggalan->tgl_indo8($sql_pasien->tgl_lahir)); # Format kata sandi pasien menggunakan tanggal lahir dd-mm-yyyy jika tanggal lahir kosong maka passwordnya sama dengan username
                                
                if($sql_user_ck->num_rows() > 0){                    
                    # Reset semua id user yang berkaitan
                    $this->db->where('id', $sql_user->id)->update('tbl_m_pasien', array('id_user' => '0'));
                    
                    # Hapus dulu usernya
                    $this->db->where('id', $sql_user_ck_rw->id)->delete('tbl_ion_users');
                
                    $data_user = array(
                        'email'         => $email,
                        'first_name'    => $sql_pasien->nama,
                        'nama'          => $sql_pasien->nama_pgl,
                        'address'       => $sql_pasien->alamat,
                        'phone'         => $sql_pasien->kontak,
                        'birthdate'     => $sql_pasien->tgl_lahir,
                        'file_name'     => $sql_pasien->file_name,
                        'username'      => $no_rm,
                        'tipe'          => '2',
                    );
                    
                    # Simpan ke modul user
                    $this->ion_auth->register($user, $pass2, $email, $data_user, array('15'));

                    $sql_user_ck    = $this->db->select('id, username')->where('username', $no_rm)->get('tbl_ion_users')->row();
                    $id_user        = $sql_user_ck->id;
                    
                    # Reset jika ada ID user kembar
                    $this->db->where('id_user', $id_user)->update('tbl_m_pasien', array('id_user' => '0'));
                    # Update id user pada tabel pasien
                    $this->db->where('id', $sql_pasien->id)->update('tbl_m_pasien', array('id_user'=>$id_user));

                    $this->session->set_flashdata('medcheck_toast', 'toastr.success("Akses Pasien ini sudah berhasil di reset !");');
                }else{                    
                    $data_user = array(
                        'email'         => $email,
                        'first_name'    => $sql_pasien->nama,
                        'nama'          => $sql_pasien->nama_pgl,
                        'address'       => $sql_pasien->alamat,
                        'phone'         => $sql_pasien->kontak,
                        'birthdate'     => $sql_pasien->tgl_lahir,
                        'file_name'     => $sql_pasien->file_name,
                        'username'      => $no_rm,
                        'tipe'          => '2',
                    );
                    
                    # Simpan ke modul user
                    $this->ion_auth->register($user, $pass2, $email, $data_user, array('15'));
                    
                    $sql_user_ck = $this->db->select('id, username')->where('username', $no_rm)->get('tbl_ion_users')->row();
                    $id_user = $sql_user_ck->id;
                    
                    # Reset jika ada ID user kembar
                    $this->db->where('id_user', $id_user)->update('tbl_m_pasien', array('id_user' => '0'));
                    # Update id user pada tabel pasien
                    $this->db->where('id', $id_user)->update('tbl_m_pasien', array('id_user'=>$id_user));
                    
                    $this->session->set_flashdata('medcheck_toast', 'toastr.success("Pasien ini sudah bisa log in ke aplikasi");');
                }
            }
            
            redirect(base_url('master/data_pasien_det.php?id='.$id));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_pasien_foto_reset() {
        if (Akses::aksesLogin() == TRUE) {
            $id = $this->input->get('id');
            $kd = $this->input->get('kode');
            $hl = $this->input->get('halaman');
            
            if(!empty($id)){
                $pengaturan     = $this->db->get('tbl_pengaturan')->row();
                $sql_user_ck    = $this->db->where('username', $kd)->get('tbl_ion_users');
                $sql_user_ck_rw = $sql_user_ck->row();
                $sql_pasien     = $this->db->where('id', general::dekrip($id))->get('tbl_m_pasien')->row();
                $no_rm          = strtolower($pengaturan->kode_pasien).$sql_pasien->kode;
                $sql_user       = $this->db->select('username')->where('username', $no_rm)->get('tbl_ion_users');
                $sql_user_rw    = $sql_user->row();
                $email          = $no_rm.'@'.$pengaturan->website; # Format Email
                $user           = $no_rm; # Format username pasien menggunakan no rm
                $pass2          = ($sql_pasien->tgl_lahir == '0000-00-00' ? $user : $this->tanggalan->tgl_indo8($sql_pasien->tgl_lahir)); # Format kata sandi pasien menggunakan tanggal lahir dd-mm-yyyy jika tanggal lahir kosong maka passwordnya sama dengan username
                                
                if($sql_user_ck->num_rows() > 0){                
                    $data_user = array(
                        'file_name'     => '',
                    );
                    
                    $id_user = $sql_user_ck_rw->id;
                    
                    # Reset jika ada ID user kembar
                    $this->db->where('id_user', $id_user)->update('tbl_m_pasien', $data_user);

                    $this->session->set_flashdata('medcheck_toast', 'toastr.success("Foto Pasien ini sudah berhasil di reset !");');
                }
            }
            
            redirect(base_url('master/data_pasien_det.php?id='.$id));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function pdf_pasien() {
        if (Akses::aksesLogin() == TRUE) {
            $this->load->helper("terbilang");
            $setting            = $this->db->get('tbl_pengaturan')->row();
            $id                 = $this->input->get('id');

            $sql_pasien         = $this->db->where('id', general::dekrip($id))->get('tbl_m_pasien')->row(); 
            $kode_pasien        = $sql_pasien->kode_dpn.$sql_pasien->kode;
            $gambar1            = FCPATH.'/assets/theme/admin-lte-3/dist/img/logo-header-es1.png';
            $gambar2            = FCPATH.'/assets/theme/admin-lte-3/dist/img/kartu_periksa.png';
            $gambar3            = !empty($sql_pasien->file_name) ? realpath($sql_pasien->file_name) : '';
            $kasir              = (!empty($sql_medc->id_kasir) ? $this->ion_auth->user($sql_medc->id_kasir)->row()->first_name : $this->ion_auth->user()->row()->first_name);
            
            $this->load->library('MedLblPDF');
            $pdf = new MedLblPDF('L', 'cm', array(7,12));
            $pdf->SetAutoPageBreak('auto', 0);
            $pdf->header = 0;
            $pdf->addPage('','',false);
                        
            # Gambar Design Kartu
            if(file_exists($gambar2)) {
                $pdf->Image($gambar2, 0, 0, 12, 7);
            }

            # Foto Pasien
            if(!empty($sql_pasien->file_name) && file_exists($gambar3)){
                $pdf->Image($gambar3, 5.79, 4.36, 2.10, 1.97);
            }

            # Data Pasien
            $pdf->SetTextColor(37, 122, 53); //257a35
            $pdf->SetFont('Arial', 'B', '10');
            $pdf->Ln(2.70);
            $pdf->Cell(5, .35, $sql_pasien->nama_pgl, '', 0, 'L', $fill);
            $pdf->Ln(1.05);
            $pdf->Cell(5, .35, $sql_pasien->kode_dpn.$sql_pasien->kode, '', 0, 'L', $fill);
            $pdf->Ln(1.05);
            $pdf->Cell(5, .35, $this->tanggalan->tgl_indo($sql_pasien->tgl_lahir), '', 0, 'L', $fill);
            $pdf->Ln();

            $type = (isset($_GET['type']) ? $_GET['type'] : 'I');

            ob_start();
            $pdf->Output($sql_pasien->nama_pgl.'_kartu'. '.pdf', $type);
            ob_end_flush();
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function cetak_data_satuan(){
        if (Akses::aksesLogin() == TRUE) {
            $case = $this->input->get('case');
            
            $data['produk'] = '';

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/includes/master/cetak_data_satuan', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();            
        }
    }
    
    public function cetak_data_barang(){
        if (Akses::aksesLogin() == TRUE) {
            $case = $this->input->get('case');
            
            $data['produk'] = '';

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/includes/master/cetak_data_barang', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();            
        }
    }
    
    public function cetak_data_customer(){
        if (Akses::aksesLogin() == TRUE) {
            $case = $this->input->get('case');
            
            $data['produk'] = '';

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/includes/master/cetak_data_customer', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();            
        }
    }
    
    public function cetak_data_sales(){
        if (Akses::aksesLogin() == TRUE) {
            $case = $this->input->get('case');
            
            $data['produk'] = '';

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/includes/master/cetak_data_customer', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();            
        }
    }
    
    public function cetak_data_supplier(){
        if (Akses::aksesLogin() == TRUE) {
            $case = $this->input->get('case');
            
            $data['produk'] = '';

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/includes/master/cetak_data_supplier', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();            
        }
    }
    

    public function pdf_data_satuan(){
        if (Akses::aksesLogin() == TRUE) {
            $query = $this->input->get('query');
            $jml   = $this->input->get('jml');
            
            
            $sql = $this->db->select('DATE(tgl_simpan) as tgl_simpan, satuanTerkecil, satuanBesar, jml')
                            ->like('satuanTerkecil', $query)
                            ->or_like('satuanBesar', $query)
                            ->or_like('jml', $query)
                            ->get('tbl_m_satuan')->result();
            
            $setting = $this->db->get('tbl_pengaturan')->row();

            $judul = "LAPORAN DATA SATUAN";

            $this->fpdf->FPDF('P', 'cm', 'a4');
            $this->fpdf->SetAutoPageBreak('auto');
            $this->fpdf->SetMargins(1, 1, 1);
            $this->fpdf->AliasNbPages();
            $this->fpdf->AddPage();

            $this->fpdf->SetFont('Arial', 'B', '14');
            $this->fpdf->Cell(19, .75, strtoupper($setting->judul), '0', 1, 'C');
            $this->fpdf->Ln(0);
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(19, .5, ucwords($setting->alamat), 'B', 1, 'C');
            $this->fpdf->Ln(0);
            $this->fpdf->SetFont('Arial', 'B', '14');
            $this->fpdf->Cell(19, .75, $judul, 0, 1, 'C');
            $this->fpdf->Ln();


            // Fill Colornya
            $this->fpdf->SetFillColor(211, 223, 227);
            $this->fpdf->SetTextColor(0);
//        $this->fpdf->SetDrawColor(128, 0, 0);
            $this->fpdf->SetFont('Arial', 'B', '10');


//        // Header tabel
            $this->fpdf->Cell(1, .5, 'No', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(2.5, .5, 'Tgl Simpan', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(3, .5, 'Satuan Kecil', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(3, .5, 'Satuan Besar', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(2, .5, 'Jml', 1, 0, 'C', TRUE);
            $this->fpdf->Ln();


            $this->fpdf->SetFillColor(235, 232, 228);
            $this->fpdf->SetTextColor(0);
            $this->fpdf->SetFont('Arial', '', '10');

            if (!empty($sql)) {
                $fill = FALSE;
                $no = 1;
                $tot = 0;
                $jml_brg = 0;
                foreach ($sql as $produk) {
                    $tot     = $tot + $produk->harga_jual;
                    $tgl     = explode('-', $produk->tgl_simpan);
                    $jml     = $this->db->select('SUM(stok) as jml')->where('id_produk', $produk->id)->get('tbl_m_produk_stok')->row();
                    $jml_brg = $jml_brg + (!empty($jml->jml) ? $jml->jml : $produk->jml);

                    $this->fpdf->Cell(1, .5, $no . '. ', 1, 0, 'C', $fill);
                    $this->fpdf->Cell(2.5, .5, $tgl[1] . '/' . $tgl[2] . '/' . $tgl[0], 1, 0, 'C', $fill);
                    $this->fpdf->Cell(3, .5, $produk->satuanTerkecil, 1, 0, 'L', $fill);
                    $this->fpdf->Cell(3, .5, $produk->satuanBesar, 1, 0, 'L', $fill);
                    $this->fpdf->Cell(2, .5, (!empty($jml->jml) ? $jml->jml : $produk->jml), 1, 0, 'C', $fill);
                    $this->fpdf->Ln();

                    $fill = !$fill;
                    $no++;
                }
//                $this->fpdf->Cell(15.5, .5, 'Grand Total', 1, 0, 'R', $fill);
//                $this->fpdf->Cell(3.5, .5, general::format_angka($jml_brg * $tot), 1, 0, 'C', $fill);
//                $this->fpdf->Ln();
            } else {

                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->SetFillColor(235, 232, 228);
                $this->fpdf->Cell(19, 1, 'Data Kosong', 1, 0, 'C', TRUE);
                $this->fpdf->Ln(10);
            }

            $this->fpdf->SetTextColor(0);
            $this->fpdf->SetY(-2);
            $this->fpdf->SetFont('Arial', 'i', '9');
            $this->fpdf->Cell(9, .75, 'Copyright (c) ' . date('Y') . ' - ' . $setting->judul, 'T', 0, 'L');
            $this->fpdf->Cell(1, .75, $this->fpdf->PageNo(), 'T', 0, 'L');
            $this->fpdf->Cell(9, .75, 'Dicetak pada : ' . $this->tanggalan->tgl_indo(date('Y-m-d')), 'T', 0, 'R');

            $type = (isset($_GET['type']) ? $_GET['type'] : 'I');

            $this->fpdf->Output('lap_data_barang_' . date('YmdHm') . '.pdf', $type);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();            
        }
    }

    public function pdf_data_barang(){
        if (Akses::aksesLogin() == TRUE) {
            $filter_kode     = $this->input->get('filter_kode');
            $filter_merk     = $this->input->get('filter_merk');
            $filter_lokasi   = $this->input->get('filter_lokasi');
            $filter_produk   = $this->input->get('filter_produk');
            $filter_brcd     = $this->input->get('filter_barcode');
            $filter_hpp      = $this->input->get('filter_hpp');
            $filter_harga    = $this->input->get('filter_harga');
            $jml             = $this->input->get('jml');
            
            $where = "MATCH(tbl_m_produk.produk) AGAINST('".$filter_produk."')";
            $sql    = $this->db->select('DATE(tgl_simpan) as tgl_simpan, id_merk, kode, barcode, produk, jml, harga_jual')
                               ->where($where)
                               ->like('kode', $filter_kode, 'both')
                               ->like('id_merk', $filter_merk, 'both')
                               ->like('id_lokasi', $filter_lokasi, 'both')
                               ->like('barcode', $filter_brcd, 'both')
//                               ->like('produk', $filter_produk, 'both')
                               ->like('harga_beli', $filter_hpp, 'both')
                               ->like('harga_jual', $filter_harga, 'both')
                               ->get('tbl_m_produk')->result();
            
            $setting = $this->db->get('tbl_pengaturan')->row();

            $judul = "LAPORAN DATA BARANG";

            $this->fpdf->FPDF('P', 'cm', 'a4');
            $this->fpdf->SetAutoPageBreak('auto');
            $this->fpdf->SetMargins(1, 1, 1);
            $this->fpdf->AliasNbPages();
            $this->fpdf->AddPage();

            $this->fpdf->SetFont('Arial', 'B', '14');
            $this->fpdf->Cell(19, .75, strtoupper($setting->judul), '0', 1, 'C');
            $this->fpdf->Ln(0);
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(19, .5, ucwords($setting->alamat), 'B', 1, 'C');
            $this->fpdf->Ln(0);
            $this->fpdf->SetFont('Arial', 'B', '14');
            $this->fpdf->Cell(19, .75, $judul, 0, 1, 'C');
            $this->fpdf->Ln();


            // Fill Colornya
            $this->fpdf->SetFillColor(211, 223, 227);
            $this->fpdf->SetTextColor(0);
//        $this->fpdf->SetDrawColor(128, 0, 0);
            $this->fpdf->SetFont('Arial', 'B', '10');


//        // Header tabel
            $this->fpdf->Cell(1, .5, 'No', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(2.5, .5, 'Tgl Masuk', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(3, .5, 'Barcode', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(11, .5, 'Produk', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(1.5, .5, 'Stok', 1, 0, 'C', TRUE);
            $this->fpdf->Ln();

            $this->fpdf->SetFillColor(235, 232, 228);
            $this->fpdf->SetTextColor(0);
            $this->fpdf->SetFont('Arial', '', '10');

            if (!empty($sql)) {
                $fill = FALSE;
                $no = 1;
                $tot = 0;
                $jml_brg = 0;
                foreach ($sql as $produk) {
                    $tot     = $tot + $produk->harga_jual;
                    $tgl     = explode('-', $produk->tgl_simpan);
                    $jml     = $this->db->select('SUM(stok) as jml')->where('id_produk', $produk->id)->get('tbl_m_produk_stok')->row();
                    $jml_brg = $jml_brg + (!empty($jml->jml) ? $jml->jml : $produk->jml);
                    $satuan  = $this->db->where('id', $produk->id_satuan)->get('tbl_m_satuan')->row();
                    $merk    = $this->db->where('id', $produk->id_merk)->get('tbl_m_merk')->row();

                    $this->fpdf->Cell(1, .5, $no . '. ', 1, 0, 'C', $fill);
                    $this->fpdf->Cell(2.5, .5, $tgl[1] . '/' . $tgl[2] . '/' . $tgl[0], 1, 0, 'C', $fill);
                    $this->fpdf->Cell(3, .5, $produk->barcode, 1, 0, 'L', $fill);
                    $this->fpdf->Cell(11, .5, strtoupper($merk->merk).' '.$produk->produk, 1, 0, 'L', $fill);
                    $this->fpdf->Cell(1.5, .5, (!empty($jml->jml) ? $jml->jml : $produk->jml), 1, 0, 'C', $fill);
//                    $this->fpdf->Cell(2.5, .5, '', 1, 0, 'R', $fill);
                    $this->fpdf->Ln();

                    $fill = !$fill;
                    $no++;
                }

                $this->fpdf->SetFont('Arial', 'B', '10');
                $this->fpdf->Cell(17.5, .5, 'Total', 1, 0, 'R', $fill);
//                $this->fpdf->Cell(1, .5, $jml_brg, 1, 0, 'C', $fill);
                $this->fpdf->Cell(1.5, .5, $jml_brg, 1, 0, 'R', $fill);
                $this->fpdf->Ln();
//                $this->fpdf->Cell(15.5, .5, 'Grand Total', 1, 0, 'R', $fill);
//                $this->fpdf->Cell(3.5, .5, general::format_angka($jml_brg * $tot), 1, 0, 'C', $fill);
//                $this->fpdf->Ln();
            } else {

                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->SetFillColor(235, 232, 228);
                $this->fpdf->Cell(19, 1, 'Data Kosong', 1, 0, 'C', TRUE);
                $this->fpdf->Ln(10);
            }

            $this->fpdf->SetTextColor(0);
            $this->fpdf->SetY(-2);
            $this->fpdf->SetFont('Arial', 'i', '9');
            $this->fpdf->Cell(9, .75, 'Copyright (c) ' . date('Y') . ' - ' . $setting->judul, 'T', 0, 'L');
            $this->fpdf->Cell(1, .75, $this->fpdf->PageNo(), 'T', 0, 'L');
            $this->fpdf->Cell(9, .75, 'Dicetak pada : ' . $this->tanggalan->tgl_indo(date('Y-m-d')), 'T', 0, 'R');

            $type = (isset($_GET['type']) ? $_GET['type'] : 'I');

            $this->fpdf->Output('lap_data_barang_' . date('YmdHm') . '.pdf', $type);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();            
        }
    }
    
    public function pdf_data_customer(){
        if (Akses::aksesLogin() == TRUE) {
            $query = $this->input->get('query');
            $jml   = $this->input->get('jml');
            
            
            $sql = $this->db->select('DATE(tgl_simpan) as tgl_simpan, nik, nama, lokasi')
                        ->like('nama', $query)
                        ->or_like('nik', $query)
                        ->get('tbl_m_pelanggan')->result();
            
            $setting = $this->db->get('tbl_pengaturan')->row();

            $judul = "LAPORAN DATA CUSTOMER";

            $this->fpdf->FPDF('P', 'cm', 'a4');
            $this->fpdf->SetAutoPageBreak('auto');
            $this->fpdf->SetMargins(1, 1, 1);
            $this->fpdf->AliasNbPages();
            $this->fpdf->AddPage();

            $this->fpdf->SetFont('Arial', 'B', '14');
            $this->fpdf->Cell(19, .75, strtoupper($setting->judul), '0', 1, 'C');
            $this->fpdf->Ln(0);
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(19, .5, ucwords($setting->alamat), 'B', 1, 'C');
            $this->fpdf->Ln(0);
            $this->fpdf->SetFont('Arial', 'B', '14');
            $this->fpdf->Cell(19, .75, $judul, 0, 1, 'C');
            $this->fpdf->Ln();


            // Fill Colornya
            $this->fpdf->SetFillColor(211, 223, 227);
            $this->fpdf->SetTextColor(0);
//        $this->fpdf->SetDrawColor(128, 0, 0);
            $this->fpdf->SetFont('Arial', 'B', '10');


//        // Header tabel
            $this->fpdf->Cell(1, .5, 'No', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(2.5, .5, 'Tgl Simpan', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(5, .5, 'NIK', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(7.5, .5, 'Pelanggan', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(3, .5, 'Kota', 1, 0, 'C', TRUE);
            $this->fpdf->Ln();


            $this->fpdf->SetFillColor(235, 232, 228);
            $this->fpdf->SetTextColor(0);
            $this->fpdf->SetFont('Arial', '', '10');

            if (!empty($sql)) {
                $fill = FALSE;
                $no = 1;
                $tot = 0;
                $jml_brg = 0;
                foreach ($sql as $produk) {
                    $tot     = $tot + $produk->harga_jual;
                    $tgl     = explode('-', $produk->tgl_simpan);
                    
                    $this->fpdf->Cell(1, .5, $no . '. ', 1, 0, 'C', $fill);
                    $this->fpdf->Cell(2.5, .5, $tgl[1] . '/' . $tgl[2] . '/' . $tgl[0], 1, 0, 'C', $fill);
                    $this->fpdf->Cell(5, .5, $produk->nik, 1, 0, 'L', $fill);
                    $this->fpdf->Cell(7.5, .5, $produk->nama, 1, 0, 'L', $fill);
                    $this->fpdf->Cell(3, .5, $produk->lokasi, 1, 0, 'C', $fill);
                    $this->fpdf->Ln();

                    $fill = !$fill;
                    $no++;
                }
                $this->fpdf->Ln();
//                $this->fpdf->Cell(15.5, .5, 'Grand Total', 1, 0, 'R', $fill);
//                $this->fpdf->Cell(3.5, .5, general::format_angka($jml_brg * $tot), 1, 0, 'C', $fill);
//                $this->fpdf->Ln();
            } else {

                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->SetFillColor(235, 232, 228);
                $this->fpdf->Cell(19, 1, 'Data Kosong', 1, 0, 'C', TRUE);
                $this->fpdf->Ln(10);
            }

            $this->fpdf->SetTextColor(0);
            $this->fpdf->SetY(-2);
            $this->fpdf->SetFont('Arial', 'i', '9');
            $this->fpdf->Cell(9, .75, 'Copyright (c) ' . date('Y') . ' - ' . $setting->judul, 'T', 0, 'L');
            $this->fpdf->Cell(1, .75, $this->fpdf->PageNo(), 'T', 0, 'L');
            $this->fpdf->Cell(9, .75, 'Dicetak pada : ' . $this->tanggalan->tgl_indo(date('Y-m-d')), 'T', 0, 'R');

            $type = (isset($_GET['type']) ? $_GET['type'] : 'I');

            $this->fpdf->Output('lap_data_barang_' . date('YmdHm') . '.pdf', $type);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();            
        }
    }
    
    public function pdf_data_sales(){
        if (Akses::aksesLogin() == TRUE) {
            $query = $this->input->get('query');
            $jml   = $this->input->get('jml');
            
            
            $sql = $this->db->select('DATE(tgl_simpan) as tgl_simpan, nik, nama')
                        ->like('nama', $query)
                        ->or_like('nik', $query)
                        ->get('tbl_m_karyawan')->result();
            
            $setting = $this->db->get('tbl_pengaturan')->row();

            $judul = "LAPORAN DATA SALES";

            $this->fpdf->FPDF('P', 'cm', 'a4');
            $this->fpdf->SetAutoPageBreak('auto');
            $this->fpdf->SetMargins(1, 1, 1);
            $this->fpdf->AliasNbPages();
            $this->fpdf->AddPage();

            $this->fpdf->SetFont('Arial', 'B', '14');
            $this->fpdf->Cell(19, .75, strtoupper($setting->judul), '0', 1, 'C');
            $this->fpdf->Ln(0);
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(19, .5, ucwords($setting->alamat), 'B', 1, 'C');
            $this->fpdf->Ln(0);
            $this->fpdf->SetFont('Arial', 'B', '14');
            $this->fpdf->Cell(19, .75, $judul, 0, 1, 'C');
            $this->fpdf->Ln();


            // Fill Colornya
            $this->fpdf->SetFillColor(211, 223, 227);
            $this->fpdf->SetTextColor(0);
//        $this->fpdf->SetDrawColor(128, 0, 0);
            $this->fpdf->SetFont('Arial', 'B', '10');


//        // Header tabel
            $this->fpdf->Cell(1, .5, 'No', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(2.5, .5, 'Tgl Simpan', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(5, .5, 'NIK', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(7.5, .5, 'Sales', 1, 0, 'C', TRUE);
//            $this->fpdf->Cell(3, .5, 'Kota', 1, 0, 'C', TRUE);
            $this->fpdf->Ln();


            $this->fpdf->SetFillColor(235, 232, 228);
            $this->fpdf->SetTextColor(0);
            $this->fpdf->SetFont('Arial', '', '10');

            if (!empty($sql)) {
                $fill = FALSE;
                $no = 1;
                $tot = 0;
                $jml_brg = 0;
                foreach ($sql as $produk) {
                    $tot     = $tot + $produk->harga_jual;
                    $tgl     = explode('-', $produk->tgl_simpan);
                    
                    $this->fpdf->Cell(1, .5, $no . '. ', 1, 0, 'C', $fill);
                    $this->fpdf->Cell(2.5, .5, $tgl[1] . '/' . $tgl[2] . '/' . $tgl[0], 1, 0, 'C', $fill);
                    $this->fpdf->Cell(5, .5, $produk->nik, 1, 0, 'L', $fill);
                    $this->fpdf->Cell(7.5, .5, $produk->nama, 1, 0, 'L', $fill);
//                    $this->fpdf->Cell(3, .5, $produk->lokasi, 1, 0, 'C', $fill);
                    $this->fpdf->Ln();

                    $fill = !$fill;
                    $no++;
                }
                $this->fpdf->Ln();
//                $this->fpdf->Cell(15.5, .5, 'Grand Total', 1, 0, 'R', $fill);
//                $this->fpdf->Cell(3.5, .5, general::format_angka($jml_brg * $tot), 1, 0, 'C', $fill);
//                $this->fpdf->Ln();
            } else {

                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->SetFillColor(235, 232, 228);
                $this->fpdf->Cell(19, 1, 'Data Kosong', 1, 0, 'C', TRUE);
                $this->fpdf->Ln(10);
            }

            $this->fpdf->SetTextColor(0);
            $this->fpdf->SetY(-2);
            $this->fpdf->SetFont('Arial', 'i', '9');
            $this->fpdf->Cell(9, .75, 'Copyright (c) ' . date('Y') . ' - ' . $setting->judul, 'T', 0, 'L');
            $this->fpdf->Cell(1, .75, $this->fpdf->PageNo(), 'T', 0, 'L');
            $this->fpdf->Cell(9, .75, 'Dicetak pada : ' . $this->tanggalan->tgl_indo(date('Y-m-d')), 'T', 0, 'R');

            $type = (isset($_GET['type']) ? $_GET['type'] : 'I');

            $this->fpdf->Output('lap_data_barang_' . date('YmdHm') . '.pdf', $type);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();            
        }
    }
    
    public function pdf_data_supplier(){
        if (Akses::aksesLogin() == TRUE) {
            $query = $this->input->get('query');
            $jml   = $this->input->get('jml');
            
            
            $sql = $this->db->select('DATE(tgl_simpan) as tgl_simpan, kode, nama, npwp, kota')
                        ->like('nama', $query)
                        ->or_like('kode', $query)
                        ->or_like('npwp', $query)
                        ->or_like('kota', $query)
                        ->get('tbl_m_supplier')->result();
            
            $setting = $this->db->get('tbl_pengaturan')->row();

            $judul = "LAPORAN DATA SUPPLIER";

            $this->fpdf->FPDF('P', 'cm', 'a4');
            $this->fpdf->SetAutoPageBreak('auto');
            $this->fpdf->SetMargins(1, 1, 1);
            $this->fpdf->AliasNbPages();
            $this->fpdf->AddPage();

            $this->fpdf->SetFont('Arial', 'B', '14');
            $this->fpdf->Cell(19, .75, strtoupper($setting->judul), '0', 1, 'C');
            $this->fpdf->Ln(0);
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(19, .5, ucwords($setting->alamat), 'B', 1, 'C');
            $this->fpdf->Ln(0);
            $this->fpdf->SetFont('Arial', 'B', '14');
            $this->fpdf->Cell(19, .75, $judul, 0, 1, 'C');
            $this->fpdf->Ln();


            // Fill Colornya
            $this->fpdf->SetFillColor(211, 223, 227);
            $this->fpdf->SetTextColor(0);
//        $this->fpdf->SetDrawColor(128, 0, 0);
            $this->fpdf->SetFont('Arial', 'B', '10');


//        // Header tabel
            $this->fpdf->Cell(1, .5, 'No', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(2.5, .5, 'Tgl Simpan', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(2, .5, 'Kode', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(7.25, .5, 'Supplier', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(3.75, .5, 'NPWP', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(2.5, .5, 'Kota', 1, 0, 'C', TRUE);
            $this->fpdf->Ln();


            $this->fpdf->SetFillColor(235, 232, 228);
            $this->fpdf->SetTextColor(0);
            $this->fpdf->SetFont('Arial', '', '10');

            if (!empty($sql)) {
                $fill = FALSE;
                $no = 1;
                $tot = 0;
                $jml_brg = 0;
                foreach ($sql as $produk) {
                    $tot     = $tot + $produk->harga_jual;
                    $tgl     = explode('-', $produk->tgl_simpan);
                    
                    $this->fpdf->Cell(1, .5, $no . '. ', 1, 0, 'C', $fill);
                    $this->fpdf->Cell(2.5, .5, $tgl[1] . '/' . $tgl[2] . '/' . $tgl[0], 1, 0, 'C', $fill);
                    $this->fpdf->Cell(2, .5, $produk->kode, 1, 0, 'L', $fill);
                    $this->fpdf->Cell(7.25, .5, $produk->nama, 1, 0, 'L', $fill);
                    $this->fpdf->Cell(3.75, .5, ($produk->npwp != 0 ? $produk->npwp : ''), 1, 0, 'L', $fill);
                    $this->fpdf->Cell(2.5, .5, $produk->kota, 1, 0, 'C', $fill);
                    $this->fpdf->Ln();

                    $fill = !$fill;
                    $no++;
                }
                $this->fpdf->Ln();
//                $this->fpdf->Cell(15.5, .5, 'Grand Total', 1, 0, 'R', $fill);
//                $this->fpdf->Cell(3.5, .5, general::format_angka($jml_brg * $tot), 1, 0, 'C', $fill);
//                $this->fpdf->Ln();
            } else {

                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->SetFillColor(235, 232, 228);
                $this->fpdf->Cell(19, 1, 'Data Kosong', 1, 0, 'C', TRUE);
                $this->fpdf->Ln(10);
            }

            $this->fpdf->SetTextColor(0);
            $this->fpdf->SetY(-2);
            $this->fpdf->SetFont('Arial', 'i', '9');
            $this->fpdf->Cell(9, .75, 'Copyright (c) ' . date('Y') . ' - ' . $setting->judul, 'T', 0, 'L');
            $this->fpdf->Cell(1, .75, $this->fpdf->PageNo(), 'T', 0, 'L');
            $this->fpdf->Cell(9, .75, 'Dicetak pada : ' . $this->tanggalan->tgl_indo(date('Y-m-d')), 'T', 0, 'R');

            $type = (isset($_GET['type']) ? $_GET['type'] : 'I');

            $this->fpdf->Output('lap_data_barang_' . date('YmdHm') . '.pdf', $type);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();            
        }
    }
    

    public function pdf_data_cuti() {
        if (Akses::aksesLogin() == TRUE) {
            $setting            = $this->db->get('tbl_pengaturan')->row();
            $id                 = $this->input->get('id');
            $id_medcheck        = $this->input->get('id');
            $id_rad             = $this->input->get('id_rad');
            $id_kary            = $this->input->get('id_karyawan');
            
            $sql_medc           = $this->db->where('id', general::dekrip($id_medcheck))->get('tbl_trans_medcheck')->row();
            $sql_medc_item      = $this->db->where('id_medcheck', general::dekrip($id_medcheck))
                                           ->where('id_rad', general::dekrip($id_rad))
//                                           ->where('status', '5')
                                           ->where('status_hsl', '1')
                                           ->get('tbl_trans_medcheck_det')->result(); 
            $sql_medc_rad       = $this->db->where('id', general::dekrip($id_rad))->get('tbl_trans_medcheck_rad')->row(); 
            $sql_kary           = $this->db->where('id', general::dekrip($id_kary))->get('tbl_m_karyawan')->row(); 
            $sql_kary_cuti      = $this->db->where('id', general::dekrip($id))->get('tbl_m_karyawan_cuti')->row(); 
            $sql_pekerjaan      = $this->db->where('id', $sql_pasien->id_pekerjaan)->get('tbl_m_jenis_kerja')->row();
            $sql_dokter         = $this->db->where('id_user', $sql_medc->id_dokter)->get('tbl_m_karyawan')->row();
            $sql_dokter_rad     = $this->db->where('id_user', $sql_medc_rad->id_dokter)->get('tbl_m_karyawan')->row();
            $sql_dokter_krm     = $this->db->where('id_user', $sql_medc_rad->id_dokter_kirim)->get('tbl_m_karyawan')->row();
            $kode_pasien        = $sql_pasien->kode_dpn.$sql_pasien->kode;
            $gambar1            = FCPATH.'/assets/theme/admin-lte-3/dist/img/logo-esensia-2.png';
            $gambar2            = FCPATH.'/assets/theme/admin-lte-3/dist/img/logo-bw-bg2-1440px.png';
            $gambar3            = FCPATH.'/assets/theme/admin-lte-3/dist/img/logo-footer.png';

            $judul  = "FORM PENGAJUAN CUTI KARYAWAN";
            
            $this->load->library('MedPDF');
            $pdf = new MedPDF('P', 'cm', array(21.5,33));
            $pdf->SetAutoPageBreak('auto', 6.5);
            $pdf->addPage();
            
            // Gambar Watermark Tengah
            if(file_exists($gambar2)) {
                $pdf->Image($gambar2,5,4,17,19);
            }
            
            // Blok Judul
            $pdf->SetFont('Arial', 'B', '14');
            $pdf->Cell(19, .5, $judul, 0, 1, 'C');
            $pdf->Ln();
            
            // Blok ID PASIEN
            $pdf->SetFont('Arial', '', '9');
            $pdf->Cell(5.5, .5, 'Nama', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->Cell(8, .5, (!empty($sql_kary->nama_dpn) ? $sql_kary->nama_dpn.' ' : '').$sql_kary->nama.(!empty($sql_kary->nama_blk) ? ', '.$sql_kary->nama_blk.' ' : ''), '0', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->Cell(5.5, .5, 'Tgl Lahir', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->Cell(8, .5, $this->tanggalan->tgl_indo($sql_kary->tgl_lahir).' - '.$this->tanggalan->usia($sql_kary->tgl_lahir).' ('.general::jns_klm($sql_kary->jns_klm).')', '0', 0, 'L', $fill);
            $pdf->Ln();
//            $pdf->Cell(5.5, .5, 'Jenis Kelamin / Gender', '0', 0, 'L', $fill);
//            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
//            $pdf->Cell(8, .5, $this->tanggalan->usia($sql_pasien->tgl_lahir).' ('.general::jns_klm($sql_pasien->jns_klm).')', '0', 0, 'L', $fill);
//            $pdf->Ln();
            $pdf->Cell(5.5, .5, 'Alamat', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->Cell(8, .5, (!empty($sql_kary->alamat) ? $sql_kary->alamat : (!empty($sql_kary->alamat_dom) ? $sql_kary->alamat_dom : '-')), '0', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->Cell(5.5, .5, 'Tgl Mulai Cuti', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->Cell(8, .5, $this->tanggalan->tgl_indo($sql_kary_cuti->tgl_masuk), '0', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->Cell(5.5, .5, 'Tgl Masuk Kerja', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->Cell(8, .5, $this->tanggalan->tgl_indo($sql_kary_cuti->tgl_keluar), '0', 0, 'L', $fill);
            $pdf->Ln(1);
                        

            // QR GENERATOR VALIDASI
            $qr_validasi        = FCPATH.'/file/karyawan/'.strtolower($kode_pasien).'/qr-validasi-'.strtolower($kode_pasien).'.png';
            $params['data']     = 'Saya yang bertandatangan dibawah ini:';
            $params['data']    .= strtoupper($sql_kary->nama);
            $params['level']    = 'H';
            $params['size']     = 2;
            $params['savename'] = $qr_validasi; 
            $this->ciqrcode->generate($params);
            
            $gambar5            = $qr_validasi; 
                        
//            // QR GENERATOR DOKTER
//            $qr_dokter          = FCPATH.'/file/pasien/'.strtolower($kode_pasien).'/qr-dokter-'.strtolower($sql_dokter_rad->id).'.png';
//            $params['data']     = 'Telah diverifikasi dan ditandatangani secara elektronik oleh dokter penanggung jawab ['.(!empty($sql_dokter_rad->nama_dpn) ? $sql_dokter_rad->nama_dpn.' ' : '').$sql_dokter_rad->nama.(!empty($sql_dokter_rad->nama_blk) ? ', '.$sql_dokter_rad->nama_blk : '').']';
//            $params['level']    = 'H';
//            $params['size']     = 2;
//            $params['savename'] = $qr_dokter;
//            $this->ciqrcode->generate($params);
//            
//            $gambar5            = $qr_dokter;  
            
            // Gambar VALIDASI
            $getY = $pdf->GetY() + 1;
//            $pdf->Image($gambar4,2,$getY,2,2);
            $pdf->Image($gambar5,12.5,$getY,2,2);
            
            $pdf->SetFont('Arial', '', '10');
            $pdf->Cell(11.5, .5, '', '', 0, 'L', $fill);
            $pdf->Cell(7.5, .5, 'Semarang, '.$this->tanggalan->tgl_indo3($sql_kary_cuti->tgl_simpan), '', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->SetFont('Arial', 'B', '10');
            $pdf->Cell(4, .5, 'Mengetahui', '0', 0, 'C', $fill);
            $pdf->Cell(7.5, .5, '', '0', 0, 'C', $fill);
            $pdf->SetFont('Arial', '', '10');
            $pdf->Cell(7.5, .5, (!empty($ket) ? $ket : 'Yang bertandatangan dibawah ini'), '0', 0, 'L', $fill);
            $pdf->Ln(2.5);
            
            $pdf->SetFont('Arial', '', '10');
            $pdf->Cell(11, .5, '', '', 0, 'L', $fill);
            $pdf->Cell(8, .5, (!empty($sql_kary->nama_dpn) ? $sql_kary->nama_dpn.' ' : '').$sql_kary->nama.(!empty($sql_kary->nama_blk) ? ', '.$sql_kary->nama_blk.' ' : ''), '0', 0, 'L', $fill);
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
    

    public function ex_data_barang(){
        if (Akses::aksesLogin() == TRUE) {
            $filter_kode     = $this->input->get('filter_kode');
            $filter_produk   = $this->input->get('filter_produk');
            $filter_hpp      = $this->input->get('filter_hpp');
            $filter_harga    = $this->input->get('filter_harga');
            $jml             = $this->input->get('jml');
            
            
            $sql    = $this->db->select('DATE(tgl_simpan) as tgl_simpan, kode, produk, jml, harga_jual')
                               ->like('kode', $filter_kode, 'both')
                               ->like('produk', $filter_produk, 'both')
                               ->like('harga_beli', $filter_hpp, 'both')
                               ->like('harga_jual', $filter_harga, 'both')
                               ->limit(1)
                               ->get('tbl_m_produk');
           

            $objPHPExcel = new PHPExcel();
            
            // Header Tabel Nota
//            $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('D2:F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(TRUE);
            
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'No.')
                    ->setCellValue('B1', 'Kode')
                    ->setCellValue('C1', 'Nama Barang')
                    ->setCellValue('D1', 'Jumlah')->mergeCells('D1:F1')
                    ->setCellValue('G1', 'Harga Beli')
                    ->setCellValue('H1', 'Harga Lusin')
                    ->setCellValue('I1', 'Harga Grosir');
            
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(45);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(14);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);  
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);  
            
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A2', '0')
                            ->setCellValue('B2', 'Kode Barang')
                            ->setCellValue('C2', 'Nama')
                            ->setCellValue('D2', '100')->mergeCells('D2:F2')
                            ->setCellValue('G2', number_format(125000,'0','.',','))
                            ->setCellValue('H2', number_format(250050,'0','.',','))
                            ->setCellValue('I2', number_format(150050,'0','.',','));
            
            // Detail barang
//            $no    = 1;
//            $cell  = 2;
//            $cel   = 8;
//            foreach ($sql->result() as $items){ 
//                // Format Angka
//                $objPHPExcel->getActiveSheet()->getStyle('G' . $cell.':H'.$cell)->getNumberFormat()->setFormatCode("#.##0");
//                
//                // Format Alignment
//                $objPHPExcel->getActiveSheet()->getStyle('A'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//                $objPHPExcel->getActiveSheet()->getStyle('B'.$cell.':C'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
//                $objPHPExcel->getActiveSheet()->getStyle('D'.$cell.':E'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//                $objPHPExcel->getActiveSheet()->getStyle('F'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
//                $objPHPExcel->getActiveSheet()->getStyle('G'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//                $objPHPExcel->getActiveSheet()->getStyle('H'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//                $objPHPExcel->getActiveSheet()->getStyle('G' . $cell.':H'.$cell)->getNumberFormat()->setFormatCode("#.##0");
//                
//                $objPHPExcel->setActiveSheetIndex(0)
//                            ->setCellValue('A'.$cell, $no)
//                            ->setCellValue('B'.$cell, $items->kode)
//                            ->setCellValue('C'.$cell, $items->produk)
//                            ->setCellValue('D'.$cell, $items->jml)
//                            ->setCellValue('E'.$cell, '')
//                            ->setCellValue('F'.$cell, '')
//                            ->setCellValue('G'.$cell, number_format($items->harga_beli,'0','.',','))
//                            ->setCellValue('H'.$cell, number_format($items->harga_jual,'0','.',','));
//
//                $no++;
//                $cell++;
//            }
            
            // Rename worksheet
            $objPHPExcel->getActiveSheet()->setTitle('Nota ');

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
//                    ->setLastModifiedBy("" . ucwords($createBy) . ' [' . strtoupper($namaPerusahaan) . ']')
//                    ->setTitle("Nota Penjualan " . $sql->row()->no_nota . ($sql->row()->cetak == '1' ? ' Copy Customer' : ''))
                    ->setSubject("Aplikasi Bengkel POS")
                    ->setDescription("Kunjungi http://mikhaelfelian.web.id")
                    ->setKeywords("POS")
                    ->setCategory("Untuk mencetak nota dot matrix");



            // Redirect output to a client’s web browser (Excel5)
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="data_persediaan.xls"');

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


    public function htm_data_pasien(){
        if (Akses::aksesLogin() == TRUE) {
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

            
            $data['sql_pasien']= $this->db->select('id, kode_dpn, kode, nama, tgl_lahir, MONTH(tgl_lahir) AS bulan')
                               ->where('tgl_lahir !=', '0000-00-00')
                               ->where('status_pas', '2')
                               ->group_by('MONTH(tgl_lahir)')
                               ->get('tbl_m_pasien')->result();
                    
            /* Load view tampilan */
            $this->load->view('admin-lte-3/includes/master/data_pasien_htm', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function ex_data_pasien(){
        if (Akses::aksesLogin() == TRUE) {
            $filter_kode     = $this->input->get('filter_cm');
            $filter_nama     = $this->input->get('filter_nama');
            $jml             = $this->input->get('jml');
            
            
            $sql    = $this->db->select('id, kode_dpn, kode, nama, tgl_lahir, no_hp, MONTH(tgl_lahir) AS bulan')
                               ->where('tgl_lahir !=', '0000-00-00')
                               ->where('status_pas', '2')
                               ->like('kode', $filter_kode)
                               ->like('nama', $filter_nama)
                               ->order_by('MONTH(tgl_lahir)', 'asc')
//                               ->group_by('MONTH(tgl_lahir)')
//                               ->limit(100)
                               ->get('tbl_m_pasien');
           

            $objPHPExcel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $objPHPExcel->getActiveSheet();
            
            // Header Tabel Nota
            $sheet->getStyle('A1:I1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('D2:F2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle('A1:I1')->getFont()->setBold(TRUE);
            
            $sheet->setCellValue('A1', 'No.')
                  ->setCellValue('B1', 'Kode')
                  ->setCellValue('C1', 'Pasien')
                  ->setCellValue('D1', 'Tgl Lahir')
                  ->setCellValue('E1', 'No. HP')
                  ->setCellValue('F1', 'Bulan');
            
            $sheet->getColumnDimension('A')->setWidth(7);
            $sheet->getColumnDimension('B')->setWidth(25);
            $sheet->getColumnDimension('C')->setWidth(65);
            $sheet->getColumnDimension('D')->setWidth(15);
            $sheet->getColumnDimension('E')->setWidth(20);
            $sheet->getColumnDimension('F')->setWidth(14);
            $sheet->getColumnDimension('G')->setWidth(25);
            $sheet->getColumnDimension('H')->setWidth(25);  
            $sheet->getColumnDimension('I')->setWidth(25);  
            
            // Detail barang
            $no    = 1;
            $cell  = 2;
            $cel   = 8;
            foreach ($sql->result() as $items){
//                $sql_pas = $this->db->
                
                // Format Alignment
                $sheet->getStyle('A'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('B'.$cell.':C'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('D'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('E'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('F'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('E'.$cell)->getNumberFormat()->setFormatCode('#');
                               
                $sheet->setCellValue('A'.$cell, $no)
                      ->setCellValue('B'.$cell, $items->kode_dpn.$items->kode)
                      ->setCellValue('C'.$cell, $items->nama)
                      ->setCellValue('D'.$cell, ($items->tgl_lahir != '0000-00-00' ? $items->tgl_lahir : ''))
                      ->setCellValue('E'.$cell, (!empty($items->no_hp) ? "62".substr($items->no_hp, 1) : ''))
                      ->setCellValue('F'.$cell, $this->tanggalan->bulan_ke($items->bulan));
                
                $this->db->where('id', $items->id)->update('tbl_m_pasien', array('status_pas'=>'0'));

                $no++;
                $cell++;
            }
            
            // Rename worksheet
            $sheet->setTitle('WA Birthday');

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
                    ->setSubject("Aplikasi Bengkel POS")
                    ->setDescription("Kunjungi http://mikhaelfelian.web.id")
                    ->setKeywords("POS")
                    ->setCategory("Untuk mencetak nota dot matrix");



            // Redirect output to a client's web browser (Excel5)
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="data_pasien.xls"');

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
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();            
        }
    }

    public function ex_data_stok(){
        if (Akses::aksesLogin() == TRUE) {
            $filter_kode     = $this->input->get('filter_kode');
            $filter_produk   = $this->input->get('filter_produk');
            $filter_hpp      = $this->input->get('filter_hpp');
            $filter_harga    = $this->input->get('filter_harga');
            $jml             = $this->input->get('jml');
            
            
            $sql    = $this->db->select('DATE(tgl_simpan) as tgl_simpan, kode, produk, jml, harga_jual')
                               ->like('kode', $filter_kode, 'both')
                               ->like('produk', $filter_produk, 'both')
                               ->limit(1)
                               ->get('tbl_m_produk');
           

            $objPHPExcel = new Excel();
            
            // Header Tabel Nota
//            $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('D2:F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(TRUE);
            
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'No.')
                    ->setCellValue('B1', 'Kode')
                    ->setCellValue('C1', 'Nama Barang')
                    ->setCellValue('D1', 'Jumlah');
            
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(45);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(14);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);  
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);  
            
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A2', '0')
                            ->setCellValue('B2', 'Kode Barang')
                            ->setCellValue('C2', 'Nama')
                            ->setCellValue('D2', '100');
            
            // Detail barang
//            $no    = 1;
//            $cell  = 2;
//            $cel   = 8;
//            foreach ($sql->result() as $items){ 
//                // Format Angka
//                $objPHPExcel->getActiveSheet()->getStyle('G' . $cell.':H'.$cell)->getNumberFormat()->setFormatCode("#.##0");
//                
//                // Format Alignment
//                $objPHPExcel->getActiveSheet()->getStyle('A'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//                $objPHPExcel->getActiveSheet()->getStyle('B'.$cell.':C'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
//                $objPHPExcel->getActiveSheet()->getStyle('D'.$cell.':E'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//                $objPHPExcel->getActiveSheet()->getStyle('F'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
//                $objPHPExcel->getActiveSheet()->getStyle('G'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//                $objPHPExcel->getActiveSheet()->getStyle('H'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//                $objPHPExcel->getActiveSheet()->getStyle('G' . $cell.':H'.$cell)->getNumberFormat()->setFormatCode("#.##0");
//                
//                $objPHPExcel->setActiveSheetIndex(0)
//                            ->setCellValue('A'.$cell, $no)
//                            ->setCellValue('B'.$cell, $items->kode)
//                            ->setCellValue('C'.$cell, $items->produk)
//                            ->setCellValue('D'.$cell, $items->jml)
//                            ->setCellValue('E'.$cell, '')
//                            ->setCellValue('F'.$cell, '')
//                            ->setCellValue('G'.$cell, number_format($items->harga_beli,'0','.',','))
//                            ->setCellValue('H'.$cell, number_format($items->harga_jual,'0','.',','));
//
//                $no++;
//                $cell++;
//            }
            
            // Rename worksheet
            $objPHPExcel->getActiveSheet()->setTitle('Nota ');

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
//                    ->setLastModifiedBy("" . ucwords($createBy) . ' [' . strtoupper($namaPerusahaan) . ']')
//                    ->setTitle("Nota Penjualan " . $sql->row()->no_nota . ($sql->row()->cetak == '1' ? ' Copy Customer' : ''))
                    ->setSubject("Aplikasi Bengkel POS")
                    ->setDescription("Kunjungi http://mikhaelfelian.web.id")
                    ->setKeywords("POS")
                    ->setCategory("Untuk mencetak nota dot matrix");



            // Redirect output to a client’s web browser (Excel5)
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="data_persediaan.xls"');

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

    public function ex_data_customer(){
        if (Akses::aksesLogin() == TRUE) {
            $filter_kode     = $this->input->get('filter_kode');
            $filter_produk   = $this->input->get('filter_produk');
            $filter_hpp      = $this->input->get('filter_hpp');
            $filter_harga    = $this->input->get('filter_harga');
            $jml             = $this->input->get('jml');

            $objPHPExcel = new PHPExcel();
            
            // Header Tabel Nota
//            $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A1:Q1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A1:Q1')->getFont()->setBold(TRUE);
            
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'No.')
                    ->setCellValue('B1', 'Kode')
                    ->setCellValue('C1', 'NIK / NPWP')
                    ->setCellValue('D1', 'Nama')
                    ->setCellValue('E1', 'Nama Toko')
                    ->setCellValue('F1', 'No. HP')
                    ->setCellValue('G1', 'Lokasi')
                    ->setCellValue('H1', 'Alamat');
            
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(45);  
            
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A2', 'x')
                            ->setCellValue('B2', '00x')
                            ->setCellValue('C2', '801519-501xxx')
                            ->setCellValue('D2', 'CV. MAJU TERUS')
                            ->setCellValue('E2', 'Toko Kita')
                            ->setCellValue('F2', '085471xxxx')
                            ->setCellValue('G2', 'SEMARANG')
                            ->setCellValue('H2', 'Jl. Majapahit Raya 2/1280');
            
            // Rename worksheet
            $objPHPExcel->getActiveSheet()->setTitle('Template Import Cust');

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
//                    ->setLastModifiedBy("" . ucwords($createBy) . ' [' . strtoupper($namaPerusahaan) . ']')
//                    ->setTitle("Nota Penjualan " . $sql->row()->no_nota . ($sql->row()->cetak == '1' ? ' Copy Customer' : ''))
                    ->setSubject("Aplikasi Bengkel POS")
                    ->setDescription("Kunjungi http://mikhaelfelian.web.id")
                    ->setKeywords("POS")
                    ->setCategory("Untuk mencetak nota dot matrix");



            // Redirect output to a client’s web browser (Excel5)
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="data_pelanggan.xls"');

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

    public function ex_data_sales(){
        if (Akses::aksesLogin() == TRUE) {
            $filter_kode     = $this->input->get('filter_kode');
            $filter_produk   = $this->input->get('filter_produk');
            $filter_hpp      = $this->input->get('filter_hpp');
            $filter_harga    = $this->input->get('filter_harga');
            $jml             = $this->input->get('jml');

            $objPHPExcel = new PHPExcel();
            
            // Header Tabel Nota
//            $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(TRUE);
            
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'No.')
                    ->setCellValue('B1', 'Kode')
                    ->setCellValue('C1', 'NIK')
                    ->setCellValue('D1', 'Nama')
                    ->setCellValue('E1', 'No. HP')
                    ->setCellValue('F1', 'Kota')
                    ->setCellValue('G1', 'Alamat');
            
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(45);  
            
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A2', 'x')
                            ->setCellValue('B2', '00x')
                            ->setCellValue('C2', '33.7407.501xxx')
                            ->setCellValue('D2', 'Ishak Daniel Hendrawan')
                            ->setCellValue('E2', '08574890xxx')
                            ->setCellValue('F2', 'SEMARANG')
                            ->setCellValue('G2', 'Jl. Majapahit Raya 2/1280');
            
            // Detail barang
//            $no    = 1;
//            $cell  = 2;
//            $cel   = 8;
//            foreach ($sql->result() as $items){ 
//                // Format Angka
//                $objPHPExcel->getActiveSheet()->getStyle('G' . $cell.':H'.$cell)->getNumberFormat()->setFormatCode("#.##0");
//                
//                // Format Alignment
//                $objPHPExcel->getActiveSheet()->getStyle('A'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//                $objPHPExcel->getActiveSheet()->getStyle('B'.$cell.':C'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
//                $objPHPExcel->getActiveSheet()->getStyle('D'.$cell.':E'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//                $objPHPExcel->getActiveSheet()->getStyle('F'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
//                $objPHPExcel->getActiveSheet()->getStyle('G'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//                $objPHPExcel->getActiveSheet()->getStyle('H'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//                $objPHPExcel->getActiveSheet()->getStyle('G' . $cell.':H'.$cell)->getNumberFormat()->setFormatCode("#.##0");
//                
//                $objPHPExcel->setActiveSheetIndex(0)
//                            ->setCellValue('A'.$cell, $no)
//                            ->setCellValue('B'.$cell, $items->kode)
//                            ->setCellValue('C'.$cell, $items->produk)
//                            ->setCellValue('D'.$cell, $items->jml)
//                            ->setCellValue('E'.$cell, '')
//                            ->setCellValue('F'.$cell, '')
//                            ->setCellValue('G'.$cell, number_format($items->harga_beli,'0','.',','))
//                            ->setCellValue('H'.$cell, number_format($items->harga_jual,'0','.',','));
//
//                $no++;
//                $cell++;
//            }
            
            // Rename worksheet
            $objPHPExcel->getActiveSheet()->setTitle('Nota ');

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
//                    ->setLastModifiedBy("" . ucwords($createBy) . ' [' . strtoupper($namaPerusahaan) . ']')
//                    ->setTitle("Nota Penjualan " . $sql->row()->no_nota . ($sql->row()->cetak == '1' ? ' Copy Customer' : ''))
                    ->setSubject("Aplikasi Bengkel POS")
                    ->setDescription("Kunjungi http://mikhaelfelian.web.id")
                    ->setKeywords("POS")
                    ->setCategory("Untuk mencetak nota dot matrix");



            // Redirect output to a client’s web browser (Excel5)
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="data_sales.xls"');

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

    public function ex_data_supplier(){
        if (Akses::aksesLogin() == TRUE) {
            $filter_kode     = $this->input->get('filter_kode');
            $filter_produk   = $this->input->get('filter_produk');
            $filter_hpp      = $this->input->get('filter_hpp');
            $filter_harga    = $this->input->get('filter_harga');
            $jml             = $this->input->get('jml');

            $objPHPExcel = new PHPExcel();
            
            // Header Tabel Nota
//            $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(TRUE);
            
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'No.')
                    ->setCellValue('B1', 'Kode')
                    ->setCellValue('C1', 'NIK / NPWP')
                    ->setCellValue('D1', 'Nama')
                    ->setCellValue('E1', 'No. Telp')
                    ->setCellValue('F1', 'No. HP')
                    ->setCellValue('G1', 'CP')
                    ->setCellValue('H1', 'Alamat');
            
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(45);  
            
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A2', 'x')
                            ->setCellValue('B2', '00x')
                            ->setCellValue('C2', '801519-501xxx')
                            ->setCellValue('D2', 'CV. MAJU TERUS')
                            ->setCellValue('E2', '0271-1500888')
                            ->setCellValue('F2', '085471xxxx')
                            ->setCellValue('G2', 'Doni Alamsyah')
                            ->setCellValue('H2', 'Jl. Majapahit Raya 2/1280');
            
            // Detail barang
//            $no    = 1;
//            $cell  = 2;
//            $cel   = 8;
//            foreach ($sql->result() as $items){ 
//                // Format Angka
//                $objPHPExcel->getActiveSheet()->getStyle('G' . $cell.':H'.$cell)->getNumberFormat()->setFormatCode("#.##0");
//                
//                // Format Alignment
//                $objPHPExcel->getActiveSheet()->getStyle('A'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//                $objPHPExcel->getActiveSheet()->getStyle('B'.$cell.':C'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
//                $objPHPExcel->getActiveSheet()->getStyle('D'.$cell.':E'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//                $objPHPExcel->getActiveSheet()->getStyle('F'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
//                $objPHPExcel->getActiveSheet()->getStyle('G'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//                $objPHPExcel->getActiveSheet()->getStyle('H'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//                $objPHPExcel->getActiveSheet()->getStyle('G' . $cell.':H'.$cell)->getNumberFormat()->setFormatCode("#.##0");
//                
//                $objPHPExcel->setActiveSheetIndex(0)
//                            ->setCellValue('A'.$cell, $no)
//                            ->setCellValue('B'.$cell, $items->kode)
//                            ->setCellValue('C'.$cell, $items->produk)
//                            ->setCellValue('D'.$cell, $items->jml)
//                            ->setCellValue('E'.$cell, '')
//                            ->setCellValue('F'.$cell, '')
//                            ->setCellValue('G'.$cell, number_format($items->harga_beli,'0','.',','))
//                            ->setCellValue('H'.$cell, number_format($items->harga_jual,'0','.',','));
//
//                $no++;
//                $cell++;
//            }
            
            // Rename worksheet
            $objPHPExcel->getActiveSheet()->setTitle('Nota ');

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
//                    ->setLastModifiedBy("" . ucwords($createBy) . ' [' . strtoupper($namaPerusahaan) . ']')
//                    ->setTitle("Nota Penjualan " . $sql->row()->no_nota . ($sql->row()->cetak == '1' ? ' Copy Customer' : ''))
                    ->setSubject("Aplikasi Bengkel POS")
                    ->setDescription("Kunjungi http://mikhaelfelian.web.id")
                    ->setKeywords("POS")
                    ->setCategory("Untuk mencetak nota dot matrix");



            // Redirect output to a client’s web browser (Excel5)
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="data_supplier.xls"');

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

    public function ex_data_barang_cth(){
        if (Akses::aksesLogin() == TRUE) {
            $filter_kode     = $this->input->get('filter_kode');
            $filter_produk   = $this->input->get('filter_produk');
            $filter_hpp      = $this->input->get('filter_hpp');
            $filter_harga    = $this->input->get('filter_harga');
            $jml             = $this->input->get('jml');
            
            
            $sql    = $this->db->select('DATE(tgl_simpan) as tgl_simpan, id, kode, produk, jml, harga_jual')
                               ->like('kode', $filter_kode, 'both')
                               ->like('produk', $filter_produk, 'both')
                               ->like('harga_beli', $filter_hpp, 'both')
                               ->like('harga_jual', $filter_harga, 'both')
//                               ->limit(1)
                               ->get('tbl_m_produk');
           

            $objPHPExcel = new PHPExcel();
            
            // Header Tabel Nota
//            $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//            $objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//            $objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(TRUE);
            
            $objPHPExcel->setActiveSheetIndex(0) //,"KODE_OBJEK","NAMA","HARGA_SATUAN
                    ->setCellValue('A1', 'OB')
                    ->setCellValue('B1', 'KODE_OBJEK')
                    ->setCellValue('C1', 'NAMA')
                    ->setCellValue('D1', 'HARGA_SATUAN');
            
//            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
//            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
//            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(45);
//            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(7);
//            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(7);
//            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(14);
//            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
//            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
            
            // Detail barang
            $no    = 1;
            $cell  = 2;
            $cel   = 8;
            foreach ($sql->result() as $items){ 
//                // Format Angka
//                $objPHPExcel->getActiveSheet()->getStyle('G' . $cell.':H'.$cell)->getNumberFormat()->setFormatCode("#.##0");
//                
//                // Format Alignment
//                $objPHPExcel->getActiveSheet()->getStyle('A'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//                $objPHPExcel->getActiveSheet()->getStyle('B'.$cell.':C'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
//                $objPHPExcel->getActiveSheet()->getStyle('D'.$cell.':E'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//                $objPHPExcel->getActiveSheet()->getStyle('F'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
//                $objPHPExcel->getActiveSheet()->getStyle('G'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//                $objPHPExcel->getActiveSheet()->getStyle('H'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//                $objPHPExcel->getActiveSheet()->getStyle('G' . $cell.':H'.$cell)->getNumberFormat()->setFormatCode("#.##0");
                
//                $objPHPExcel->setActiveSheetIndex(0)
//                            ->setCellValue('A'.$cell, $no)
//                            ->setCellValue('B'.$cell, $items->kode)
//                            ->setCellValue('C'.$cell, $items->produk)
//                            ->setCellValue('D'.$cell, $items->jml)
//                            ->setCellValue('E'.$cell, '')
//                            ->setCellValue('F'.$cell, '')
//                            ->setCellValue('G'.$cell, number_format($items->harga_beli,'0','.',','))
//                            ->setCellValue('H'.$cell, number_format($items->harga_jual,'0','.',','));
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A'.$cell, 'OB')
                            ->setCellValue('B'.$cell, $items->id)
                            ->setCellValue('C'.$cell, $items->produk)
                            ->setCellValue('D'.$cell, $items->harga_jual);

                $no++;
                $cell++;
            }
            
            // Rename worksheet
            $objPHPExcel->getActiveSheet()->setTitle('Nota ');

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
//            $objPHPExcel->getProperties()->setCreator("Mikhael Felian Waskito")
////                    ->setLastModifiedBy("" . ucwords($createBy) . ' [' . strtoupper($namaPerusahaan) . ']')
////                    ->setTitle("Nota Penjualan " . $sql->row()->no_nota . ($sql->row()->cetak == '1' ? ' Copy Customer' : ''))
//                    ->setSubject("Aplikasi Bengkel POS")
//                    ->setDescription("Kunjungi http://mikhaelfelian.web.id")
//                    ->setKeywords("POS")
//                    ->setCategory("Untuk mencetak nota dot matrix");



            // Redirect output to a client’s web browser (Excel5)
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment;filename="data_persediaan.csv"');

            // If you're serving to IE over SSL, then the following may be needed
            header('Expires: Mon, 15 Feb 1992 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0
            
            ob_clean();
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
            $objWriter->save('php://output');            
            exit;
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();            
        }
    }

    public function import_data_barang(){
        if (Akses::aksesLogin() == TRUE) {
            
            $setting     = $this->db->get('tbl_pengaturan')->row();
            $file        = realpath('file/import').'/data_persediaan.xls';
            $objPHPExcel = PHPExcel_IOFactory::load($file);
            $sql_satuan  = $this->db->get('tbl_m_satuan')->row();
            
            foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                $worksheetTitle     = $worksheet->getTitle();
                $highestRow         = $worksheet->getHighestRow(); // e.g. 10
                $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
                $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
                
                for ($row = 2; $row <= $highestRow; ++ $row) {
                    $val=array();
                    
                    for ($col = 0; $col < $highestColumnIndex; ++$col) {
                        $cell = $worksheet->getCellByColumnAndRow($col, $row);
                        $val[] = $cell->getValue();
                        //here's my prob..
                    }
                    
                    $produk = array(
                        'kode'      => $val[1],
                        'produk'    => $val[2],
                        'jml'       => $val[3],
                        'id_satuan' => $sql_satuan->id,
                        'harga_beli'=> $val[6],
                        'harga_jual'=> $val[7],
                    );
                    
                    echo '<pre>';
                    print_r($produk);
                }
            }
            
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();            
        }
    }
    

    public function set_cari_satuan() {
        if (Akses::aksesLogin() == TRUE) {
            redirect('master/data_satuan_list.php?' . http_build_query($_GET));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function set_cari_kategori() {
        if (Akses::aksesLogin() == TRUE) {
            $id = $this->input->post('pencarian');
            
            if(!empty($id)){
                $jml = $this->db->like('keterangan',$id)
                                ->like('kategori',$id)
                                ->get('tbl_m_kategori')->num_rows();
                redirect(base_url('master/data_kategori_list.php?q='.$id.'&jml='.$jml));
            }else{
                redirect(base_url('master/data_kategori_list.php'));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function set_cari_merk() {
        if (Akses::aksesLogin() == TRUE) {
            $id = $this->input->post('pencarian');
            
            if(!empty($id)){
                $jml = $this->db->like('keterangan',$id)
                                ->like('merk',$id)
                                ->get('tbl_m_merk')->num_rows();
                redirect(base_url('master/data_merk_list.php?q='.$id.'&jml='.$jml));
            }else{
                redirect(base_url('master/data_merk_list.php'));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function set_cari_lokasi() {
        if (Akses::aksesLogin() == TRUE) {
            $id = $this->input->post('pencarian');
            
            if(!empty($id)){
                $jml = $this->db->like('keterangan',$id)
                                ->like('lokasi',$id)
                                ->get('tbl_m_poli')->num_rows();
                redirect(base_url('master/data_lokasi_list.php?q='.$id.'&jml='.$jml));
            }else{
                redirect(base_url('master/data_lokasi_list.php'));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function set_cari_barang() {
        if (Akses::aksesLogin() == TRUE) {
            $kode = str_replace(' ', '', $this->input->post('kode'));
            $brcd = $this->input->post('barcode');
            $prod = $this->input->post('produk');
            $hpp  = $this->input->post('hpp');
            $hrga = str_replace('.','',$this->input->post('harga'));
            $sa   = $this->input->post('sa');
            $mrk  = $this->input->post('merk');
            $lok  = $this->input->post('kategori');
            $sa   = $this->input->post('status_subt');
            $rt   = $this->input->post('route');
            
//            $where = "(tbl_m_produk.kode LIKE '%".$kode."%' OR tbl_m_produk.barcode LIKE '%".$kode."%')";
            $where = "MATCH(tbl_m_produk.produk) AGAINST('".$prod."')";
            
            $jml = $this->db
//                            ->select("id, produk, MATCH(tbl_m_produk.produk) AGAINST('".$prod."')")
                            ->where("(tbl_m_produk.produk LIKE '%".$prod."%' OR tbl_m_produk.produk_alias LIKE '%".$prod."%' OR tbl_m_produk.produk_kand LIKE '%".$prod."%' OR tbl_m_produk.kode LIKE '%".$prod."%')")
//                            ->like('kode', $kode)
//                            ->like('barcode', $brcd, (!empty($brcd) ? 'none' : ''))
                            ->like('id_kategori', $lok, (!empty($lok) ? 'none' : ''))
                            ->like('id_merk', $mrk, (!empty($mrk) ? 'none' : ''))
//                            ->like('produk', $prod)
//                            ->like('harga_beli', $hpp)
//                            ->like('ROUND(harga_jual)', $hrga, (!empty($hrga) ? 'none' : ''))
                            ->like('status_subt', $sa, ($sa !='' ? 'none' : ''))
                            ->get('tbl_m_produk')->num_rows();

            if($jml > 0){
                redirect(base_url((!empty($rt) ? $rt : 'master/data_barang_list.php').'?'.(!empty($kode) ? 'filter_kode='.$kode : '').(!empty($mrk) ? 'filter_merk='.$mrk : '').(!empty($lok) ? 'filter_kategori='.$lok : '').(!empty($brcd) ? 'filter_barcode='.$brcd : '').(!empty($prod) ? '&filter_produk='.$prod : '').(!empty($sa) ? '&filter_stok='.$sa : '').(!empty($hpp) ? '&filter_hpp='.$hpp : '').(!empty($hrga) ? '&filter_harga='.$hrga : '').'&jml='.$jml));
            }else{
                redirect(base_url((!empty($rt) ? $rt : 'master/data_barang_list.php').'?msg=Pencarian tidak di temukan!!'));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function set_cari_barang_retbeli() {
        if (Akses::aksesLogin() == TRUE) {
            $nota = $this->input->post('nota');
            $prod = $this->input->post('produk');
            $tgl  = $this->input->post('tgl');
            $sess_beli = $this->session->userdata('trans_retur_beli_m');
            
//            $where = "(tbl_m_produk.kode LIKE '%".$kode."%' OR tbl_m_produk.barcode LIKE '%".$kode."%')";
            $where = "MATCH(tbl_m_produk.produk) AGAINST('".$prod."')";
            
            $jml = $this->db
                            ->join('tbl_trans_beli', 'tbl_trans_beli.id=tbl_trans_beli_det.id_pembelian')
                            ->where('tbl_trans_beli.id_supplier', $sess_beli['id_supplier'])
                            ->like('tbl_trans_beli.no_nota', $nota)
                            ->like('tbl_trans_beli_det.produk', $prod)
                            ->like('DATE(tbl_trans_beli.tgl_masuk)', $this->tanggalan->tgl_indo_sys($tgl))
                            ->get('tbl_trans_beli_det')->num_rows();


            if($jml > 0){
                redirect(base_url('master/data_barang_list_retur_beli.php?'.(!empty($sess_beli['sess_id']) ? 'nota='.$sess_beli['sess_id'] : '').(!empty($sess_beli['id_supplier']) ? '&supp='.general::enkrip($sess_beli['id_supplier']) : '').(!empty($nota) ? '&filter_nota='.$nota : '').(!empty($prod) ? '&filter_produk='.$prod : '').(!empty($tgl) ? '&filter_tgl='.$tgl : '').'&jml='.$jml.(!empty($sess_beli['route']) ? '&route='.$sess_beli['route'] : '')));
            }else{
                redirect(base_url('master/data_barang_list_retur_beli.php?msg=Pencarian tidak di temukan!!'));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function set_cari_stok() {
        if (Akses::aksesLogin() == TRUE) {
            $kode = $this->input->post('kode');
            $prod = $this->input->post('produk');
//            $sa   = $this->input->post('sa');
            $sa   = $this->input->post('status_subt');
            
            $jml = $this->db->like('kode', $kode)
                            ->like('produk', $prod)
                            ->like('status_subt', $sa, (isset($sa) ? 'none' : ''))
                            ->get('tbl_m_produk')->num_rows();
                       
            if($jml > 0){
                redirect(base_url('master/data_stok_list.php?'.(!empty($kode) ? 'filter_kode='.$kode : '').(!empty($prod) ? '&filter_produk='.$prod : '').(isset($sa) ? '&filter_stok='.$sa : '').(!empty($hpp) ? '&filter_hpp='.$hpp : '').(!empty($hrga) ? '&filter_harga='.$hrga : '').'&jml='.$jml));
            }else{
                redirect(base_url('master/data_stok_list.php'));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function set_cari_plgn() {
        if (Akses::aksesLogin() == TRUE) {
            $id = $this->input->post('pencarian');
            
            if(!empty($id)){
                $jml = $this->db->like('nama',$id)
                                ->or_like('nik',$id)
                                ->or_like('nama_toko',$id)
                            ->get('tbl_m_pelanggan')->num_rows();
                redirect(base_url('master/data_customer_list.php?q='.$id.'&jml='.$jml));
            }else{
                redirect(base_url('master/data_customer_list.php'));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function set_cari_karyawan() {
        if (Akses::aksesLogin() == TRUE) {
            $nik    = $this->input->post('nik');
            $nama   = $this->input->post('nama');
            $grup   = $this->input->post('grup');
            
            if(!empty($nik) OR !empty($nama) OR !empty($grup)){
                $jml = $this->db->where('status_aps', '0')->like('nama',$nama)
                                ->like('nik',$nik)
                                ->like('id_user_group',$grup)
                            ->get('tbl_m_karyawan')->num_rows();
                redirect(base_url('master/data_karyawan_list.php?'.(!empty($nik) ? 'filter_nik='.$nik.'&' : '').(!empty($nama) ? 'filter_nama='.$nama : '').(!empty($grup) ? 'filter_grup='.$grup : '').'&jml='.$jml));
            }else{
                redirect(base_url('master/data_karyawan_list.php'));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function set_cari_aps() {
        if (Akses::aksesLogin() == TRUE) {
            $nik    = $this->input->post('nik');
            $nama   = $this->input->post('nama');
            $grup   = $this->input->post('grup');
            
            if(!empty($nik) OR !empty($nama)){
                $jml = $this->db
                            ->where('status_aps','1')
                            ->like('nama',$nama)
                            ->get('tbl_m_karyawan')->num_rows();
                redirect(base_url('master/data_aps_list.php?'.(!empty($nama) ? 'filter_nama='.$nama : '').'&jml='.$jml));
            }else{
                redirect(base_url('master/data_karyawan_list.php'));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function set_cari_supplier() {
        if (Akses::aksesLogin() == TRUE) {
            $kode = $this->input->post('kode');
            $supp = $this->input->post('supplier');
            
            if(!empty($kode) OR !empty($supp)){
                $jml = $this->db->like('kode',$kode)
                                ->like('nama', $supp)
                            ->get('tbl_m_supplier')->num_rows();
                redirect(base_url('master/data_supplier_list.php?'.(!empty($kode) ? 'filter_kode='.$kode.'&' : '').(!empty($supp) ? 'filter_nama='.$supp.'&' : '').'jml='.$jml));
            }else{
                redirect(base_url('master/data_supplier_list.php'));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_cari_platform() {
        if (Akses::aksesLogin() == TRUE) {
            $kode   = $this->input->post('kode');
            $akun   = $this->input->post('akun');
            $plat   = $this->input->post('platform');
            
            $jml    = $this->db
                           ->like('kode', $kode)
                           ->like('akun', $akun)
                           ->like('platform', $plat)
                            ->get('tbl_m_platform')->num_rows();
            
//            echo $jml;

            if ($jml > 0) {
                redirect(base_url('master/data_platform_list.php?' . (!empty($kode) ? 'filter_kode='.$kode.'&' : '').(!empty($akun) ? 'filter_akun='.$akun.'&' : '').(!empty($plat) ? 'filter_plat='.$plat : '') . '&jml=' . $jml));
            } else {
                redirect(base_url('master/data_platform_list.php'));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function set_cari_pasien() {
        if (Akses::aksesLogin() == TRUE) {
            $kode    = $this->input->post('kode');
            $nik     = $this->input->post('nik');
            $pasien  = $this->input->post('pasien');
            
            $jml = $this->db->like('kode', $kode)
                            ->like('nik', $nik)
                            ->like('nama_pgl', $pasien)
                            ->get('tbl_m_pasien')->num_rows();

            if($jml > 0){
                redirect(base_url('master/data_pasien_list.php?'.(!empty($kode) ? 'filter_cm='.$kode.'&' : '').(!empty($nik) ? 'filter_nik='.$nik.'&' : '').(!empty($pasien) ? 'filter_nama='.$pasien.'&' : '').'jml='.$jml));
            }else{
                redirect(base_url('master/data_pasien_list.php'));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_cari_icd() {
        if (Akses::aksesLogin() == TRUE) {
            $kode = $this->input->post('kode');
            $diag = $this->input->post('diagnosa');
            
            if(!empty($kode) OR !empty($diag)){
                $jml = $this->db->like('icd',$diag)
                                ->like('kode',$kode)
                                ->get('tbl_m_icd')->num_rows();
                redirect(base_url('master/data_icd_list.php?'.(!empty($kode) ? 'filter_kode='.$kode.'&' : '').(!empty($diag) ? 'filter_diag='.$diag.'&' : '').'jml='.$jml));
            }else{
                redirect(base_url('master/data_icd_list.php'));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    
    public function json_biaya() {
        if (Akses::aksesLogin() == TRUE) {
            $term  = $this->input->get('term');
            $sql   = $this->db->select('')
                              ->like('tbl_m_produk.produk',$term)->or_like('tbl_m_produk.kode',$term)
                              ->get('tbl_m_produk')->result();
            if(!empty($sql)){
                foreach ($sql as $sql){
                    $produk[] = array(
                        'id'        => $sql->id,
                        'kode'      => $sql->kode,
                        'produk'    => $sql->produk,
                        'jml'       => $sql->jml,
                        'satuan'    => $sql->satuan,
                        'harga'     => number_format($sql->harga_jual, 0, ',', '.'),
                        'harga_beli'=> number_format($sql->harga_beli, 0, ',', '.'),
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
    
    public function json_item() {
        if (Akses::aksesLogin() == TRUE) {
            $term  = $this->input->get('term');
            $stat  = $this->input->get('status');
            $sql   = $this->db->select('tbl_m_produk.id, tbl_m_produk.id_satuan, tbl_m_produk.kode, tbl_m_produk.produk, tbl_m_produk.jml, tbl_m_produk.harga_jual, tbl_m_produk.harga_beli, tbl_m_produk.harga_beli, tbl_m_produk.status_brg_dep')
                              ->where("(tbl_m_produk.produk LIKE '%".$term."%' OR tbl_m_produk.produk_alias LIKE '%".$term."%' OR tbl_m_produk.produk_kand LIKE '%".$term."%' OR tbl_m_produk.kode LIKE '%".$term."%')")
//                              ->where('tbl_m_produk.status', $stat)
                              ->order_by('tbl_m_produk.jml', ($_GET['mod'] == 'beli' ? 'asc' : 'desc'))
                              ->get('tbl_m_produk')->result();
            $sg    = $this->ion_auth->user()->row()->status_gudang;

            if(!empty($sql)){
                foreach ($sql as $sql){
                    $sql_satuan = $this->db->where('id', $sql->id_satuan)->get('tbl_m_satuan')->row();
                    $sql_stok   = $this->db->select('SUM(jml * jml_satuan) AS jml')->where('id_produk', $sql->id)->where('id_gudang', $sg)->get('tbl_m_produk_stok')->row();
                        $produk[] = array(
                            'id'            => general::enkrip($sql->id),
                            'kode'          => $sql->kode,
                            'name'          => $sql->produk,
                            'alias'         => (!empty($sql->produk_alias) ? $sql->produk_kand : ''),
                            'kandungan'     => (!empty($sql->produk_kand) ? $sql->produk_kand : ''),
                            'jml'           => $sql_stok->jml.' '.$sql_satuan->satuanTerkecil,
                            'satuan'        => $sql_satuan->satuanTerkecil,
                            'harga'         => $sql->harga_jual,
                            'harga_beli'    => number_format($sql->harga_beli, 0, ',', '.'),
                            'harga_grosir'  => number_format($sql->harga_grosir, 0, ',', '.'),
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
    
    public function cek_satuan() {
        if (Akses::aksesLogin() == TRUE) {
            $id   = $this->input->get('id');
            $sql  = $this->db->where('id', general::dekrip($id))->get('tbl_m_produk')->row();
            $sqls = $this->db->get('tbl_m_satuan')->result();
            $sqlp = $this->db->where('id_produk', $sql->id)->get('tbl_m_produk_satuan');
            
            if($sqlp->num_rows() == 0){
                foreach ($sqls as $satuan){
                    $data = array(
                        'id_produk'     => general::dekrip($id),
                        'id_satuan'     => $satuan->id,
                        'satuan'        => $satuan->satuanTerkecil,
                        'jml'           => $satuan->jml,
                        'harga'         => ($satuan->id == $sql->id_satuan ? $sql->harga_jual : 0),
                        'status'        => (!empty($satuan->status) ? $satuan->status : '0'),
                    );
                    
                    crud::simpan('tbl_m_produk_satuan', $data);
                }
            }else{
                foreach ($sqls as $satuan){
                    $sqlst = $this->db->where('id_produk', $sql->id)->where('id_satuan', $satuan->id)->get('tbl_m_produk_satuan');
                    
                    $data = array(
                        'id_produk'     => general::dekrip($id),
                        'id_satuan'     => $satuan->id,
                        'satuan'        => $satuan->satuanTerkecil,
                        'jml'           => $satuan->jml,
                        'harga'         => ($satuan->id == $sql->id_satuan ? $sql->harga_jual : 0),
                        'status'        => (!empty($satuan->status) ? $satuan->status : '0'),
                    );
                    
                    if($sqlst->num_rows() == 0){
                        crud::simpan('tbl_m_produk_satuan', $data);
                    }
                }
            }
            
            redirect(base_url('master/data_barang_tambah.php?id='.$id));

        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
}
