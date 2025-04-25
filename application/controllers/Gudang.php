<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
/***
 * Description of Gudang controller
 *
 * @author Mikhael Felian Waskito - mikhaelfelian@gmail.com
 * @modified by Mikhael Felian Waskito - mikhaelfelian@gmail.com
 * @date 2025-03-24
 */

class Gudang extends CI_Controller {
    //put your code here    
    function __construct() {
        parent::__construct();
        $this->load->library('cart'); 
        $this->load->library('Excel');
        $this->load->model('Gudang_model');
    }
    
    public function index() {
        if (akses::aksesLogin() == TRUE) {
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/gudang/sidebar_gudang';
            /* --- Sidebar Menu --- */
            
            /* Get minimum stock data */
            $data['minimum_stock'] = $this->Gudang_model->get_minimum_stock();
            
            /* Load view tampilan */
            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/gudang/index', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_opname_list() {
        if (akses::aksesLogin() == TRUE) {
            $tg         = $this->input->get('filter_tgl');
            $kt         = $this->input->get('filter_ket');
            $hal        = $this->input->get('halaman');
            $jml        = $this->input->get('jml');
            $jml_hal    = (!empty($jml) ? $jml  : $this->db->count_all('tbl_util_so'));
            $pengaturan = $this->db->get('tbl_pengaturan')->row();
            
            $data['hasError'] = $this->session->flashdata('form_error');
                        
            $config['base_url']               = base_url('gudang/data_opname_list.php?'.(!empty($tg) ? '&filter_tgl='.$tg : '').(!empty($kt) ? '&filter_ket='.$kt : '').'&jml='.$jml_hal);
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
            /* -- End Blok Pagination -- */
            
            
            if(!empty($hal)){
                if (!empty($query)) {
                    $data['opname'] = $this->db->select('DATE(tgl_simpan) as tgl_simpan, id, id_user, keterangan, nm_file, dl_file, reset')->limit($config['per_page'],$hal)
                                               ->limit($config['per_page'],$hal)
                                               ->like('keterangan', $query)
                                               ->or_like('nm_file', $query)
                                               ->order_by('tgl_simpan','desc')
                                               ->get('tbl_util_so')->result();
                } else {
                    $data['opname'] = $this->db->select('DATE(tgl_simpan) as tgl_simpan, id, id_user, keterangan, nm_file, dl_file, reset')->limit($config['per_page'],$hal)
                                               ->limit($config['per_page'],$hal)
                                               ->order_by('id','desc')
                                               ->get('tbl_util_so')->result();
                }
            } else {
                $data['opname'] = $this->db->select('DATE(tgl_simpan) as tgl_simpan, id, id_user, keterangan, nm_file, dl_file, reset')->limit($config['per_page'], $hal)
                                           ->limit($config['per_page'])
                                           ->like('DATE(tgl_simpan)', $tg)
                                           ->like('keterangan', $kt)
                                           ->order_by('id', 'desc')
                                           ->get('tbl_util_so')->result();
            }

            $this->pagination->initialize($config);
            
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();
            
            /* Sidebar Menu */
            $data['sidebar_act']= 'active';
            $data['sidebar']    = 'admin-lte-3/includes/gudang/sidebar_gudang';
            /* --- Sidebar Menu --- */

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/gudang/gd_opn_list', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_opname_tambah() {
        if (akses::aksesLogin() == TRUE) {
            $id   = $this->input->get('id');
            $idp  = $this->input->get('id_produk');
            $nota = $this->input->get('nota');
            
            $data['sql_produk']     = $this->db->where('id', general::dekrip($idp))->get('tbl_m_produk')->row();
            $data['sql_produk_stok']= $this->db->where('id_produk', general::dekrip($idp))->get('tbl_m_produk_stok')->result();
            $data['sql_satuan']     = $this->db->get('tbl_m_satuan')->result();
            $data['gudang_ls']      = $this->db->get('tbl_m_gudang')->result();
            $data['sess_jual']      = $this->session->userdata('trans_opname');
            $data['sql_gudang']     = $this->db->where('status !=', '3')->get('tbl_m_gudang')->result();
            $data['sql_util_so']    = $this->db->where('id', general::dekrip($nota))->get('tbl_util_so')->row();

            if (!empty($nota)) {
                $data['sql_util_so_det'] = $this->db->where('id_so', $data['sql_util_so']->id)->get('tbl_util_so_det')->result();
            } else {
                $data['sql_util_so_det'] = null;
            }

            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/gudang/sidebar_gudang';
            /* --- Sidebar Menu --- */

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/gudang/gd_opn_tambah', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_opname_det() {
        if (akses::aksesLogin() == TRUE) {
            $id   = $this->input->get('id');
            
            $data['barang']      = $this->db->where('id', general::dekrip($id))->get('tbl_util_so')->row();
            $data['barang_log']  = $this->db->select('*')->where('id_so', general::dekrip($id))->get('tbl_util_so_det')->result();
            $data['sql_gudang']  = $this->db->where('status !=', '3')->get('tbl_m_gudang')->result();
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/gudang/sidebar_gudang';
            /* --- Sidebar Menu --- */

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/gudang/gd_opn_detail', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_opname_item_list() {
        if (akses::aksesLogin() == TRUE) {
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
            $sort_type       = $this->input->get('sort_type');
            $sort_order      = $this->input->get('sort_order');
            $nota            = $this->input->get('nota');
            $jml             = $this->input->get('jml');
            $jml_hal         = (!empty($jml) ? $jml  : $this->db->where('so', '0')->get('tbl_m_produk')->num_rows());
            $pengaturan      = $this->db->get('tbl_pengaturan')->row();
            
            $trans_opname                    = $this->session->userdata('trans_opname');
            $sql_so_det                      = $this->db->where('id_so', general::dekrip($nota))->get('tbl_util_so_det')->result();

            $data['hasError']                = $this->session->flashdata('form_error');
                        
            $config['base_url']              = base_url('gudang/data_opname_item_list.php?nota='.$this->input->get('nota').'&route='.$this->input->get('route').(!empty($filter_kode) ? '&filter_kode='.$filter_kode : '').(!empty($filter_brcd) ? '&filter_barcode='.$filter_brcd : '').(!empty($filter_merk) ? '&filter_merk='.$filter_merk : '').(!empty($filter_lokasi) ? '&filter_lokasi='.$filter_lokasi : '').(!empty($filter_produk) ? '&filter_produk='.$filter_produk : '').(!empty($filter_hpp) ? '&filter_hpp='.$filter_hpp : '').(!empty($filter_harga) ? '&filter_harga='.$filter_harga : '').(!empty($sort_order) ? '&sort_order='.$sort_order : '').(!empty($jml) ? '&jml='.$jml : ''));
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
            
            $where = "MATCH(tbl_m_produk.produk) AGAINST('".$filter_produk."')";

            if(!empty($hal)){
                if (!empty($jml)) {
                    $data['barang'] = $this->db->select('tbl_m_produk.*, tbl_m_produk_stok.jml as stok')
                                               ->from('tbl_m_produk')
                                               ->join('tbl_m_produk_stok', 'tbl_m_produk.id = tbl_m_produk_stok.id_produk')
                                               ->where('tbl_m_produk_stok.id_gudang', $trans_opname['id_gudang'])
                                               ->where("(tbl_m_produk.produk LIKE '%".$filter_produk."%' OR tbl_m_produk.produk_alias LIKE '%".$filter_produk."%' OR tbl_m_produk.produk_kand LIKE '%".$filter_produk."%')")
                                               ->like('kode', $filter_kode)
                                               ->like('harga_jual', $filter_harga, (!empty($filter_harga) ? 'after' : ''))
                                               ->like('id_merk', $filter_merk, (!empty($filter_merk) ? 'none' : ''))
                                               ->like('id_kategori', $filter_kat, (!empty($filter_kat) ? 'none' : ''))
                                               ->order_by(!empty($sort_type) ? $sort_type : 'produk', (!empty($sort_order) ? $sort_order : 'asc'))
                                               ->limit($config['per_page'], $hal)
                                               ->get()->result();
                } else {
                    $data['barang'] = $this->db->select('tbl_m_produk.*, tbl_m_produk_stok.jml as stok')
                                               ->from('tbl_m_produk')
                                               ->join('tbl_m_produk_stok', 'tbl_m_produk.id = tbl_m_produk_stok.id_produk')
                                               ->where('tbl_m_produk_stok.id_gudang', $trans_opname['id_gudang'])
                                               ->order_by('produk', (!empty($sort_order) ? $sort_order : 'asc'))
                                               ->limit($config['per_page'], $hal)
                                               ->get()->result();
                }
            } else {
                if (!empty($jml)) {
                    $data['barang'] = $this->db->select('tbl_m_produk.*, tbl_m_produk_stok.jml as stok')
                                               ->from('tbl_m_produk')
                                               ->join('tbl_m_produk_stok', 'tbl_m_produk.id = tbl_m_produk_stok.id_produk')
                                               ->where('tbl_m_produk_stok.id_gudang', $trans_opname['id_gudang'])
                                               ->where("(tbl_m_produk.produk LIKE '%".$filter_produk."%' OR tbl_m_produk.produk_alias LIKE '%".$filter_produk."%' OR tbl_m_produk.produk_kand LIKE '%".$filter_produk."%')")
                                               ->like('kode', $filter_kode)
                                               ->like('harga_jual', $filter_harga, (!empty($filter_harga) ? 'after' : ''))
                                               ->like('id_merk', $filter_merk, (!empty($filter_merk) ? 'none' : ''))
                                               ->like('id_kategori', $filter_kat, (!empty($filter_kat) ? 'none' : ''))
                                               ->order_by(!empty($sort_type) ? $sort_type : 'produk', (!empty($sort_order) ? $sort_order : 'asc'))
                                               ->limit($config['per_page'])
                                               ->get()->result();
                } else {
                    $data['barang'] = $this->db->select('tbl_m_produk.*, tbl_m_produk_stok.jml as stok')
                                               ->from('tbl_m_produk')
                                               ->join('tbl_m_produk_stok', 'tbl_m_produk.id = tbl_m_produk_stok.id_produk')
                                               ->where('tbl_m_produk_stok.id_gudang', $trans_opname['id_gudang'])
                                               ->order_by(!empty($sort_type) ? $sort_type : 'produk', (!empty($sort_order) ? $sort_order : 'asc'))
                                               ->limit($config['per_page'])
                                               ->get()->result();
                }
            }
            
            $this->pagination->initialize($config);
            
            /* Sidebar Menu */
            $data['sidebar']        = 'admin-lte-3/includes/gudang/sidebar_gudang';
            /* --- Sidebar Menu --- */
            
            $data['total_rows']     = $config['total_rows'];
            $data['PerPage']        = $config['per_page'];
            $data['pagination']     = $this->pagination->create_links();
            $data['cetak']          = '<button type="button" onclick="window.location.href = \''.base_url('master/cetak_data_barang.php?'.(!empty($filter_kode) ? 'filter_kode='.$filter_kode : '').(!empty($filter_merk) ? '&filter_merk='.$filter_merk : '').(!empty($filter_lokasi) ? '&filter_lokasi='.$filter_lokasi : '').(!empty($filter_produk) ? '&filter_produk='.$filter_produk : '').(!empty($filter_hpp) ? '&filter_hpp='.$filter_hpp : '').(!empty($filter_harga) ? '&filter_harga='.$filter_harga : '').(!empty($jml) ? '&jml='.$jml : '')).'\'" class="btn btn-warning btn-flat"><i class="fa fa-print"></i> Cetak</button>';
            
            $data['trans_opn']      = $this->session->userdata('trans_opname');
            $data['trans_opn_det']  = $sql_so_det;
            
            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/gudang/gd_opn_item_list', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }


    
    public function trans_beli_list() {
        if (akses::aksesLogin() == TRUE) {
            /* -- Grup hak akses -- */
            $grup        = $this->ion_auth->get_users_groups()->row();
            $id_user     = $this->ion_auth->user()->row()->id;
            $id_grup     = $this->ion_auth->get_users_groups()->row();
            $pengaturan  = $this->db->get('tbl_pengaturan')->row();

            /* -- Blok Filter -- */
            $query   = $this->input->get('q');
            $hal     = $this->input->get('halaman');
            $jml     = $this->input->get('jml');

            $nt = $this->input->get('filter_nota');
            $tg = $this->input->get('filter_tgl');
            $tp = $this->input->get('filter_tgl_tempo');
            $tb = $this->input->get('filter_tgl_bayar');
            $lk = $this->input->get('filter_lokasi');
            $sl = $this->input->get('filter_supplier');
            $sn = $this->input->get('filter_status');
            $sb = $this->input->get('filter_bayar');
            /* -- End Blok Filter -- */
            
            /* -- jml halaman pada list -- */
            if(!empty($jml)){
                $jml_hal = $jml;
            }else{
                $jml_hal = $this->db->select('tbl_trans_beli.id, tbl_trans_beli.no_nota, tbl_trans_beli.no_po, DATE(tbl_trans_beli.tgl_masuk) as tgl_masuk, DATE(tbl_trans_beli.tgl_bayar) as tgl_bayar, DATE(tbl_trans_beli.tgl_keluar) as tgl_keluar, tbl_trans_beli.jml_total, tbl_trans_beli.jml_retur, tbl_trans_beli.jml_subtotal, tbl_trans_beli.jml_gtotal, tbl_trans_beli.id_user, tbl_trans_beli.id_supplier, tbl_trans_beli.status_nota, tbl_trans_beli.status_bayar, tbl_trans_beli.status_penerimaan')
                                ->join('tbl_m_supplier', 'tbl_m_supplier.id=tbl_trans_beli.id_supplier')
//                                ->like('tbl_trans_beli.id_user', ($id_grup->name == 'superadmin' || $id_grup->name == 'owner' || $id_grup->name == 'adminm' || $id_grup->name == 'purchasing' ? '' : $id_user))
                                ->like('tbl_m_supplier.nama', $sl)
                                ->like('tbl_trans_beli.no_nota', $nt)
//                                ->like('DATE(tbl_trans_beli.tgl_masuk)', $tg)
//                                ->like('DATE(tbl_trans_beli.tgl_keluar)', $tp)
//                                ->like('DATE(tbl_trans_beli.tgl_bayar)', $tb)
//                                ->like('tbl_trans_beli.status_bayar', $sb)
                                ->order_by('tbl_trans_beli.id','desc')
                                ->get('tbl_trans_beli')->num_rows();
            }            

            /* -- Form Error -- */
            $data['hasError']                = $this->session->flashdata('form_error');
            
            # Config Pagination
            $config['base_url']              = base_url('gudang/trans_beli_list.php?'.(!empty($tgl) ? '&tgl='.$tgl : '').(!empty($tgl_awal) ? '&tgl_awal='.$tgl_awal : '').(!empty($tgl_akhir) ? '&tgl_akhir='.$tgl_akhir : '').(!empty($jml) ? '&jml='.$jml : ''));
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
                   $data['sql_beli'] = $this->db->select('tbl_trans_beli.id, tbl_trans_beli.no_po, tbl_trans_beli.no_nota, DATE(tbl_trans_beli.tgl_masuk) as tgl_masuk, DATE(tbl_trans_beli.tgl_bayar) as tgl_bayar, DATE(tbl_trans_beli.tgl_keluar) as tgl_keluar, tbl_trans_beli.jml_total, tbl_trans_beli.jml_retur, tbl_trans_beli.jml_subtotal, tbl_trans_beli.jml_gtotal, tbl_trans_beli.id_user, tbl_trans_beli.id_supplier, tbl_trans_beli.status_nota, tbl_trans_beli.status_bayar, tbl_trans_beli.status_penerimaan, tbl_m_supplier.nama, tbl_m_supplier.npwp, tbl_m_supplier.alamat, tbl_m_supplier.no_tlp, tbl_m_supplier.cp')
                           ->join('tbl_m_supplier', 'tbl_m_supplier.id=tbl_trans_beli.id_supplier')
//                           ->like('tbl_trans_beli.id_user', ($id_grup->name == 'superadmin' || $id_grup->name == 'owner' || $id_grup->name == 'adminm' || $id_grup->name == 'purchasing' ? '' : $id_user))
                           ->like('tbl_m_supplier.nama', $sl)
                           ->like('tbl_trans_beli.no_nota', $nt)
//                           ->like('DATE(tbl_trans_beli.tgl_masuk)', $tg)
//                           ->like('DATE(tbl_trans_beli.tgl_keluar)', $tp)
//                           ->like('DATE(tbl_trans_beli.tgl_bayar)', $tb)
//                           ->like('tbl_trans_beli.status_bayar', $sb)
                           ->limit($config['per_page'],$hal)
                           ->order_by('tbl_trans_beli.id','desc')
                           ->get('tbl_trans_beli')->result();
            }else{
                   $data['sql_beli'] = $this->db->select('tbl_trans_beli.id, tbl_trans_beli.no_po, tbl_trans_beli.no_nota, DATE(tbl_trans_beli.tgl_masuk) as tgl_masuk, DATE(tbl_trans_beli.tgl_bayar) as tgl_bayar, DATE(tbl_trans_beli.tgl_keluar) as tgl_keluar, tbl_trans_beli.jml_total, tbl_trans_beli.jml_retur, tbl_trans_beli.jml_subtotal, tbl_trans_beli.jml_gtotal, tbl_trans_beli.id_user, tbl_trans_beli.id_supplier, tbl_trans_beli.status_nota, tbl_trans_beli.status_bayar, tbl_trans_beli.status_penerimaan, tbl_m_supplier.nama, tbl_m_supplier.npwp, tbl_m_supplier.alamat, tbl_m_supplier.no_tlp, tbl_m_supplier.cp')
                           ->join('tbl_m_supplier', 'tbl_m_supplier.id=tbl_trans_beli.id_supplier')
//                           ->like('tbl_trans_beli.id_user', ($id_grup->name == 'superadmin' || $id_grup->name == 'owner' || $id_grup->name == 'adminm' || $id_grup->name == 'purchasing' ? '' : $id_user))
                           ->like('tbl_m_supplier.nama', $sl)
                           ->like('tbl_trans_beli.no_nota', $nt)
//                           ->like('DATE(tbl_trans_beli.tgl_masuk)', $tg)
//                           ->like('DATE(tbl_trans_beli.tgl_keluar)', $tp)
//                           ->like('DATE(tbl_trans_beli.tgl_bayar)', $tb)
//                           ->like('tbl_trans_beli.status_bayar', $sb)
                           ->limit($config['per_page'])                           
                           ->order_by('tbl_trans_beli.id','desc')
                           ->get('tbl_trans_beli')->result();
            }

            $this->pagination->initialize($config);

            /* Blok pagination */
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();
            /* --End Blok pagination-- */
                        
            /* Blok pagination */
            $data['cetak']      = '<button type="button" onclick="window.location.href = \''.base_url('transaksi/cetak_data_penj.php?'.(!empty($nt) ? 'filter_nota='.$nt : '').(!empty($tg) ? '&filter_tgl='.$tg : '').(!empty($tp) ? '&filter_tgl_tempo='.$tp : '').(!empty($cs) ? '&filter_cust='.$cs : '').(!empty($sl) ? '&filter_sales='.$sl : '').(!empty($jml) ? '&jml='.$jml : '')).'\'" class="btn btn-warning"><i class="fa fa-print"></i> Cetak</button>';
            /* --End Blok pagination-- */
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/gudang/sidebar_gudang';
            /* --- Sidebar Menu --- */
            
            /* Load view tampilan */
            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/gudang/trans_beli_list', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function trans_beli_terima() {
        if (akses::aksesLogin() == TRUE) {
            $setting  = $this->db->get('tbl_pengaturan')->row();
            $id       = $this->input->get('id');
            $userid   = $this->ion_auth->user()->row()->id;
            $id_produk = $this->input->get('id_produk'); // Added missing variable
            
            
            if(!empty($id)){
                $data['sql_beli']       = $this->db->where('id', general::dekrip($id))->get('tbl_trans_beli')->row();
                $data['sql_beli_det']   = $this->db->where('id_pembelian', general::dekrip($id))->get('tbl_trans_beli_det')->result();
                $data['sql_supplier']   = $this->db->where('id', $data['sql_beli']->id_supplier)->get('tbl_m_supplier')->row();
                
                // Only query product if id_produk is provided
                if(!empty($id_produk)) {
                    $data['sql_item'] = $this->db->where('id', general::dekrip($id_produk))->get('tbl_m_produk')->row();
                } else {
                    $data['sql_item'] = null;
                }
                
                $data['sql_satuan']     = $this->db->get('tbl_m_satuan')->result();
                $data['sql_gudang']     = $this->db->get('tbl_m_gudang')->result();
            }
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/gudang/sidebar_gudang';
            /* --- Sidebar Menu --- */

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/gudang/trans_beli_terima', $data);
            $this->load->view('admin-lte-3/5_footer',$data);
            $this->load->view('admin-lte-3/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function trans_beli_terima_simpan() {
        if (akses::aksesLogin() == TRUE) {
            $id      = $this->input->post('id');
            $nota    = $this->input->post('no_nota');
            $tgl_trm = $this->input->post('tgl_terima');
            $jml_trm = (float)$this->input->post('jml_terima');
            $gudang  = $this->input->post('gudang');
            $setting = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id', 'Kode Barang', 'required');
            $this->form_validation->set_rules('gudang', 'Gudang', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = [
                    'id'     => form_error('id'),
                    'gd'     => form_error('gudang'),
                ];

                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url('gudang/trans_po_terima.php?id='.$nota));
            } else {
                $sql_cek        = $this->db->where('id', general::dekrip($id))->get('tbl_trans_beli_det')->row();
                $sql_bli        = $this->db->where('id', $sql_cek->id_pembelian)->get('tbl_trans_beli')->row();
                $sql_gdg        = $this->db->where('id', $gudang)->get('tbl_m_gudang')->row();
                $sql_cek_brg    = $this->db->where('id', $sql_cek->id_produk)->get('tbl_m_produk')->row();
                $sql_cek_sat    = $this->db->where('id', $sql_cek->id_satuan)->get('tbl_m_satuan')->row();
                $jml_terima     = $sql_cek->jml_diterima + $jml_trm;
                $jml_stok       = ($sql_cek_brg->jml < 0 ? $jml_trm : $sql_cek_brg->jml + $jml_trm);
                $jml_kurang     = ($sql_cek->jml * $sql_cek->jml_satuan) - $jml_terima;
                $hrg_pcs        = $sql_cek->subtotal / ($sql_cek->jml * $sql_cek->jml_satuan);
                $hrg_ppn        = ($sql_bli->status_ppn == '1' ? ($setting->jml_ppn / 100) * $hrg_pcs : 0);
                $hrg_pcs_akhir  = $hrg_pcs + $hrg_ppn;
                      
                # Simpan stok barang
                $data_brg = [
                    'tgl_modif'      => date('Y-m-d H:i:s'),
                    'jml'            => $jml_stok,
                    'harga_beli'     => $hrg_pcs_akhir,
                    'harga_beli_ppn' => $hrg_ppn,
                ];
                
                # Pembelian
                $data_pemb = [
                    'tgl_terima'   => (!empty($tgl_trm) ? $this->tanggalan->tgl_indo_sys($tgl_trm).' '.date('H:i:s') : date('Y-m-d H:i:s')),
                    'jml_diterima' => ($jml_kurang < 0 ? 0 : (int)$jml_terima),
                ];
                
                # History Pembelian
                $data_brg_hist = [
                    'tgl_simpan'        => (!empty($tgl_trm) ? $this->tanggalan->tgl_indo_sys($tgl_trm) : date('Y-m-d')).' '.date('H:i:s'),
                    'tgl_masuk'         => (!empty($tgl_trm) ? $this->tanggalan->tgl_indo_sys($tgl_trm) : date('Y-m-d')),
                    'tgl_ed'            => $sql_cek->tgl_ed,
                    'id_produk'         => $sql_cek_brg->id,
                    'id_user'           => $this->ion_auth->user()->row()->id,
                    'id_gudang'         => $gudang,
                    'id_pembelian'      => $sql_cek->id_pembelian,
                    'id_pembelian_det'  => $sql_cek->id,
                    'id_supplier'       => $sql_bli->id_supplier,
                    'kode'              => $sql_cek_brg->kode,
                    'kode_batch'        => $sql_cek->kode_batch,
                    'produk'            => $sql_cek_brg->produk,
                    'no_nota'           => $sql_cek->no_nota,
                    'jml'               => $jml_trm,
                    'jml_satuan'        => 1,
                    'satuan'            => (!empty($sql_cek_sat->satuanTerkecil) ? $sql_cek_sat->satuanTerkecil : 'PCS'),
                    'nominal'           => $hrg_pcs_akhir,
                    'keterangan'        => 'Pembelian '.$sql_bli->no_nota,
                    'status'            => '1',
                ];
                
                # Jika jumlah kurang > 0, maka update
                if($jml_kurang >= 0){
                    $sql_cek_stok = $this->db->where('id_produk', $sql_cek_brg->id)->where('id_gudang', $gudang)->get('tbl_m_produk_stok');
                    
                    if($sql_cek_stok->num_rows() > 0){
                        $stoknya    = $sql_cek_brg->jml;
                        $stoknya2   = $sql_cek_stok->row();
                        $stok       = $jml_trm + $stoknya;
                        $stok2      = $jml_trm + $stoknya2->jml;
                        
                       # Simpan stok ke tabel stok
                       $data_gudang_stok = [
                           'tgl_modif' => date('Y-m-d H:i:s'),
                           'id_user'    => $this->ion_auth->user()->row()->id,
                           'id_gudang'  => $gudang,
                           'id_produk'  => $sql_cek_brg->id,
                           'jml'        => $stok2,
                           'jml_satuan' => 1,
                           'satuanKecil'=> (!empty($sql_cek_sat->satuanTerkecil) ? $sql_cek_sat->satuanTerkecil : 'PCS'),
                           'status'     => $sql_gdg->status
                       ];
                       
                       $this->db->where('id', $stoknya2->id)->update('tbl_m_produk_stok', $data_gudang_stok);
                    } else {
                        $stoknya    = $sql_cek_stok->row();
                        $stok       = $jml_trm;
                       
                       # Simpan stok gudang
                       $data_gudang_stok = [
                           'tgl_simpan' => date('Y-m-d H:i:s'),
                           'id_user'    => $this->ion_auth->user()->row()->id,
                           'id_gudang'  => $gudang,
                           'id_produk'  => $sql_cek_brg->id,
                           'jml'        => $stok,
                           'jml_satuan' => 1,
                           'satuanKecil'=> (!empty($sql_cek_sat->satuanTerkecil) ? $sql_cek_sat->satuanTerkecil : 'PCS'),
                           'status'     => $sql_gdg->status
                       ];
                       
                       $this->db->insert('tbl_m_produk_stok', $data_gudang_stok);                        
                    }
                    
                    # Simpan data history pembelian
                    $this->db->insert('tbl_m_produk_hist', $data_brg_hist);

                    # Update tabel master produk dengan jumlah akhir yang sudah ditambah
                    $this->db->where('id', $sql_cek_brg->id)->update('tbl_m_produk', $data_brg);

                    # Simpan pemberiatuan bahwa barang sudah diterima
                    $this->db->where('id', $sql_cek->id)->update('tbl_trans_beli_det', $data_pemb);
                    
                    $this->session->set_flashdata('gd_toast', 'toastr.success("Data stok disimpan !");');
                } else {
                    $this->session->set_flashdata('gd_toast', 'toastr.error("Data stok tidak sesuai !");');
                }
                
                redirect(base_url('gudang/trans_beli_terima.php?id='.$nota));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function trans_beli_terima_hapus_hist() {
        if (akses::aksesLogin() == TRUE) {
            $id  = $this->input->get('id');
            $uid = $this->input->get('uid');
            $rut = $this->input->get('route');
            
            if(!empty($id)){
                $sql_prod = $this->db->where('id', general::dekrip($uid))->get('tbl_m_produk')->row();
                $sql_hist = $this->db->where('id', general::dekrip($id))->get('tbl_m_produk_hist')->row();
                $sql_stok = $this->db->where('id_gudang', $sql_hist->id_gudang)->where('id_produk', $sql_hist->id_produk)->get('tbl_m_produk_stok')->row();
                $sql_det  = $this->db->where('id', $sql_hist->id_pembelian_det)->where('id_produk', $sql_hist->id_produk)->get('tbl_trans_beli_det')->row();
                $sql_mts  = $this->db->select('tbl_trans_mutasi.id, tbl_trans_mutasi.id_gd_asal, tbl_trans_mutasi.id_gd_tujuan')->join('tbl_trans_mutasi', 'tbl_trans_mutasi.id=tbl_trans_mutasi_det.id_mutasi')->where('tbl_trans_mutasi_det.kode', $sql_prod->kode)->get('tbl_trans_mutasi_det')->row();

                switch ($sql_hist->status){
                    case '1':
                        $stok = $sql_stok->jml - $sql_hist->jml;
                        break;
                    
                    case '2':
                        $stok = $sql_stok->jml - $sql_hist->jml;
                        break;
                    
                    case '3':
                        $stok = $sql_stok->jml - $sql_hist->jml;
                        break;
                    
                    case '4':
                        $stok = $sql_stok->jml + $sql_hist->jml;
                        break;
                    
                    case '5':
                        $stok = $sql_stok->jml + $sql_hist->jml;
                        break;
                    
                    case '6':
                        $stok = $sql_stok->jml + $sql_hist->jml;
                        break;
                    
                    case '7':
                        $stok = $sql_stok->jml + $sql_hist->jml;
                        break;
                    
                    case '8':
                        $stok_asal = $this->db->where('id_produk', $sql_hist->id_produk)->where('id_gudang', $sql_mts->id_gd_asal)->get('tbl_m_produk_stok')->row()->jml + $sql_hist->jml;
//                        $this->db->where('id_produk', $sql_hist->id_produk)->where('id_gudang', $sql_mts->id_gd_asal)->update('tbl_m_produk_stok', array('tgl_modif'=>date('Y-m-d H:i:s'),'jml'=>$stok_asal));
                        $stok = $sql_stok->jml - $sql_hist->jml;
                        break;
                }
                
                $jml_trm        = $sql_det->jml_diterima - ($sql_hist->jml * $sql_hist->jml_satuan);
                $jml_diterima   = ($jml_trm < 0 ? 0 : $jml_trm);
                
                # Start mysql transact
                $this->db->query("SET AUTOCOMMIT=0;");
                $this->db->query("START TRANSACTION;");

                # Ubah status penerimaan menjadi 0
                $this->db->where('id', $sql_hist->id_pembelian)->update('tbl_trans_beli', array('status_penerimaan'=>'0'));

                # Ubah jml diterima sesuai data semula
                $this->db->where('id', $sql_det->id)->update('tbl_trans_beli_det', array('jml_diterima' => 0)); 

                # Ubah jumlah stok nya yang sesuai penerimaan pada gudang
                $this->db->where('id_produk', $sql_hist->id_produk)->where('id_gudang', $sql_hist->id_gudang)->update('tbl_m_produk_stok', array('jml'=>$stok));

                # Hapus riwayat penerimaan barang
                $this->db->where('id', $sql_hist->id)->where('id_gudang', $sql_hist->id_gudang)->delete('tbl_m_produk_hist');

                # Hitung ulang total stok terkait kemudian update ke tabel utama
                $sql_sum = $this->db->select_sum('jml')->where('id_produk', $sql_hist->id_produk)->get('tbl_m_produk_stok')->row();
                $stk_sum = $sql_sum->jml;

                $this->db->where('id', $sql_hist->id_produk)->update('tbl_m_produk', array('tgl_modif'=>date('Y-m-d H:i:s'), 'jml'=>$stk_sum));

                # COMMIT
                $this->db->query("COMMIT;");
            }
            
            redirect(base_url((!empty($rut) ? $rut.'?id='.general::enkrip($sql_hist->id_pembelian) : 'gudang/trans_beli_terima.php?id='.$uid)));
            
//            echo '<pre>';
//            print_r($sql_det);
//            echo '</pre>';            
//            echo '<pre>';
//            print_r($sql_hist);
//            echo '</pre>';
            
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function trans_mutasi() {
        if (akses::aksesLogin() == TRUE) {
            $setting              = $this->db->get('tbl_pengaturan')->row();
            $id                   = $this->input->get('id');
            $id_produk            = $this->input->get('item_id');
            $userid               = $this->ion_auth->user()->row()->id;

            $data['sess_mut']     = $this->session->userdata('trans_mutasi');
            $data['sql_gudang']   = $this->db->where('status !=', '3')->get('tbl_m_gudang')->result();
            
            if(!empty($data['sess_mut'])){
                $data['sql_produk']         = $this->db->where('id', general::dekrip($id_produk))->get('tbl_m_produk')->row();
                $data['sql_produk_sn']      = $this->db->select('id, kode_batch, tgl_ed')->where('id_produk', $data['sql_produk']->id)->where('kode_batch !=', '')->group_by('kode_batch')->get('tbl_trans_beli_det')->result();
                $data['sql_produk_satuan']  = $this->db->get('tbl_m_satuan')->result();
                $data['sql_penj']           = $this->db->where('id', general::dekrip($id))->get('tbl_trans_mutasi')->row();
                $data['sql_penj_det']       = $this->db->where('id_mutasi', $data['sql_penj']->id)->get('tbl_trans_mutasi_det')->result();
                $data['sql_satuan']         = $this->db->where('id', $data['sql_produk']->id_satuan)->get('tbl_m_satuan')->row();
                $data['sql_produk_sat']     = $this->db->where('id_produk', $data['sql_produk']->id)->get('tbl_m_produk_satuan')->result();
                $data['sql_produk_stk']     = $this->db->select('tbl_m_produk_stok.id, tbl_m_produk_stok.jml, tbl_m_produk_stok.jml_satuan, tbl_m_produk_stok.satuan, tbl_m_gudang.gudang')->join('tbl_m_gudang', 'tbl_m_gudang.id=tbl_m_produk_stok.id_gudang')->where('id_produk', general::dekrip($id_produk))->get('tbl_m_produk_stok')->result();
            }
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/gudang/sidebar_gudang';
            /* --- Sidebar Menu --- */

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/gudang/trans_mutasi', $data);
            $this->load->view('admin-lte-3/5_footer',$data);
            $this->load->view('admin-lte-3/6_bawah',$data);
            
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }   
    
    public function trans_mutasi_edit() {
        if (akses::aksesLogin() == TRUE) {
            $setting              = $this->db->get('tbl_pengaturan')->row();
            $id                   = $this->input->get('id');
            $id_produk            = $this->input->get('item_id');
            $userid               = $this->ion_auth->user()->row()->id;

            $data['sql_gudang']   = $this->db->where('status !=', '3')->get('tbl_m_gudang')->result();
            
            if(!empty($id)){
                $data['sql_produk']         = $this->db->where('id', general::dekrip($id_produk))->get('tbl_m_produk')->row();
                $data['sql_produk_sn']      = $this->db->select('id, kode_batch, tgl_ed')
                                                        ->where('id_produk', $data['sql_produk']->id)
                                                        ->where('kode_batch !=', '')
                                                        ->group_by('kode_batch')
                                                        ->get('tbl_trans_beli_det')
                                                        ->result();
                $data['sql_produk_satuan']  = $this->db->get('tbl_m_satuan')->result();
                $data['sql_penj']           = $this->db->where('id', general::dekrip($id))->get('tbl_trans_mutasi')->row();
                $data['sql_penj_det']       = $this->db->where('id_mutasi', $data['sql_penj']->id)->get('tbl_trans_mutasi_det')->result();
                $data['sql_satuan']         = $this->db->where('id', $data['sql_produk']->id_satuan)->get('tbl_m_satuan')->row();
                $data['sql_produk_stk']     = $this->db->select('tbl_m_produk_stok.id, tbl_m_produk_stok.jml, tbl_m_produk_stok.jml_satuan, tbl_m_produk_stok.satuan, tbl_m_gudang.gudang')
                                                        ->join('tbl_m_gudang', 'tbl_m_gudang.id=tbl_m_produk_stok.id_gudang')
                                                        ->where('id_produk', general::dekrip($id_produk))
                                                        ->get('tbl_m_produk_stok')
                                                        ->result();
            }
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/gudang/sidebar_gudang';
            /* --- Sidebar Menu --- */

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/gudang/trans_mutasi_edit', $data);
            $this->load->view('admin-lte-3/5_footer',$data);
            $this->load->view('admin-lte-3/6_bawah',$data);
            
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }   

    public function trans_mutasi_det() {
        if (akses::aksesLogin() == TRUE) {
            $setting               = $this->db->get('tbl_pengaturan')->row();
            $id                    = $this->input->get('id');
            
            $data['sql_penj']      = $this->db->where('id', general::dekrip($id))->get('tbl_trans_mutasi')->row();
            $data['sql_penj_det']  = $this->db->where('id_mutasi', $data['sql_penj']->id)->get('tbl_trans_mutasi_det')->result();
            
            /* --End Blok pagination-- */
            $data['sidebar']    = 'admin-lte-3/includes/gudang/sidebar_gudang';
            /* --- Sidebar Menu --- */

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/gudang/trans_mutasi_det', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    } 

    public function trans_mutasi_list() {
        if (akses::aksesLogin() == TRUE) {
            /* -- Grup hak akses -- */
            $role        = $this->input->get('role');
            $grup        = $this->ion_auth->get_users_groups()->row();
            $id_user     = $this->ion_auth->user()->row()->id;
            $id_grup     = $this->ion_auth->get_users_groups()->row();
            $pengaturan  = $this->db->get('tbl_pengaturan')->row();

            /* -- Blok Filter -- */
            $hal     = $this->input->get('halaman'); 
            $tg      = $this->input->get('filter_tgl');
            $sn      = $this->input->get('filter_status');
            
            /* -- End Blok Filter -- */

            /* -- Form Error -- */
            $data['hasError'] = $this->session->flashdata('form_error');

            /* -- Blok Pagination -- */
            $jml_hal = $this->db->select('id, no_nota')
                            ->like('status_nota', $sn)
                            ->like('DATE(tgl_simpan)', $tg)
                            ->like('id_user', ($id_grup->name == 'farmasi' || $id_grup->name == 'perawat' ? $id_user : ''), ($id_grup->name == 'farmasi' || $id_grup->name == 'perawat' ? 'none' : ''))
                            ->get('tbl_trans_mutasi')->num_rows();
            
            $config['base_url']              = base_url('gudang/data_mutasi.php?filter_tgl='.$tg.'&filter_status='.$sn);
            $config['total_rows']            = $jml_hal;

            $config['query_string_segment']  = 'halaman';
            $config['page_query_string']     = TRUE;
            $config['per_page']              = $pengaturan->jml_item;
            $config['num_links']             = 2;

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
            $config['attributes']            = array('class' => 'page-link');
            /* -- End Blok Pagination -- */

            if(!empty($hal)){
                   $data['sql_mut'] = $this->db->select('id, no_nota, DATE(tgl_simpan) as tgl_simpan, DATE(tgl_keluar) as tgl_keluar, id_user, keterangan, id_gd_asal, id_gd_tujuan, tipe, status_nota, status_terima')
                           ->like('status_nota', $sn)
                           ->limit($config['per_page'],$hal)
                           ->like('id_user', ($id_grup->name == 'farmasi' || $id_grup->name == 'perawat' ? $id_user : ''), ($id_grup->name == 'farmasi' || $id_grup->name == 'perawat' ? 'none' : ''))
                           ->like('DATE(tgl_simpan)', $tg)
                           ->order_by('id','desc')
                           ->get('tbl_trans_mutasi')->result();
            }else{
                   $data['sql_mut'] = $this->db->select('id, no_nota, DATE(tgl_simpan) as tgl_simpan, DATE(tgl_keluar) as tgl_keluar, id_user, keterangan, id_gd_asal, id_gd_tujuan, tipe, status_nota, status_terima')
                           ->like('status_nota', $sn)
                           ->limit($config['per_page'])
                           ->like('id_user', ($id_grup->name == 'farmasi' || $id_grup->name == 'perawat' ? $id_user : ''), ($id_grup->name == 'farmasi' || $id_grup->name == 'perawat' ? 'none' : ''))
                           ->like('DATE(tgl_simpan)', $tg)
                           ->order_by('id','desc')
                           ->get('tbl_trans_mutasi')->result();
            }
            
            $this->pagination->initialize($config);
            
            /* Blok pagination */
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();
            
            /* --End Blok pagination-- */
            $data['sidebar']    = 'admin-lte-3/includes/gudang/sidebar_gudang';
            /* --- Sidebar Menu --- */

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/gudang/trans_mutasi_list', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function trans_mutasi_list_terima() {
        if (akses::aksesLogin() == TRUE) {
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
            $jml     = $this->input->get('jml');
//            $jml_sql = ($id_grup->name == 'superadmin' || $id_grup->name == 'owner' || $id_grup->name == 'admin' ? $this->db->get('tbl_trans_jual')->num_rows() : $this->db->where('id_user', $id_user)->where('tgl_masuk', date('Y-m-d'))->get('tbl_trans_jual')->num_rows());
            
            if(!empty($jml)){
                $jml_hal = $jml;
            }else{
                $jml_hal = $this->db->select('id, no_nota')
                                ->where('status_nota', '1')
                                ->where('status_terima', '0')
                                ->like('no_nota', $fn[0])
                                ->like('DATE(tgl_keluar)', $tp)
                                ->like('id_user', ($id_grup->name == 'superadmin' || $id_grup->name == 'owner' || $id_grup->name == 'admin' || $id_grup->name == 'farmasi' ? '' : $id_user), ($id_grup->name == 'superadmin' || $id_grup->name == 'owner' || $id_grup->name == 'admin' || $id_grup->name == 'farmasi' ? '' : 'none'))
                                ->like('tgl_masuk', ($id_grup->name == 'superadmin' || $id_grup->name == 'owner' || $id_grup->name == 'admin' ? '' : date('Y-m-d')))
                                ->order_by('id','desc')
                                ->get('tbl_trans_mutasi')->num_rows();
            }
            /* -- End Blok Filter -- */

            /* -- Form Error -- */
            $data['hasError']                = $this->session->flashdata('form_error');

            /* -- Blok Pagination -- */
            $config['base_url']              = base_url('gudang/data_mutasi.php?filter_nota='.$nt.'&filter_tgl='.$tg.'&jml='.$jml);
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
                   $data['sql_mut'] = $this->db->select('id, no_nota, DATE(tgl_simpan) as tgl_simpan, DATE(tgl_keluar) as tgl_keluar, id_user, keterangan, id_gd_asal, id_gd_tujuan, tipe, status_nota')
                           ->where('status_nota', '1')
                           ->where('status_terima', '0')
                           ->limit($config['per_page'],$hal)
                           ->like('no_nota', $fn[0])
                           ->like('DATE(tgl_simpan)', $tg)
                           ->like('id_user', ($id_grup->name == 'farmasi' ? $id_user : ''), ($id_grup->name == 'farmasi' ? 'none' : ''))
                           ->order_by('id','desc')
                           ->get('tbl_trans_mutasi')->result();
            }else{
                   $data['sql_mut'] = $this->db->select('id, no_nota, DATE(tgl_simpan) as tgl_simpan, DATE(tgl_keluar) as tgl_keluar, id_user, keterangan, id_gd_asal, id_gd_tujuan, tipe, status_nota')
                           ->where('status_nota', '1')
                           ->where('status_terima', '0')
                           ->limit($config['per_page'])
                           ->like('id_user', ($id_grup->name == 'farmasi' ? $id_user : ''), ($id_grup->name == 'farmasi' ? 'none' : ''))
                           ->like('DATE(tgl_simpan)', $tg)
                           ->order_by('id','desc')
                           ->get('tbl_trans_mutasi')->result();
            }
            
            $this->pagination->initialize($config);
            
            /* Blok pagination */
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();
            
            /* --End Blok pagination-- */
            $data['sidebar']    = 'admin-lte-3/includes/gudang/sidebar_gudang';
            /* --- Sidebar Menu --- */

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/gudang/trans_mutasi_list_terima', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function trans_mutasi_terima() {
        if (akses::aksesLogin() == TRUE) {
            $setting               = $this->db->get('tbl_pengaturan')->row();
            $id                    = $this->input->get('id');
            
            $data['sql_penj']      = $this->db->where('id', general::dekrip($id))->get('tbl_trans_mutasi')->row();
            $data['sql_penj_det']  = $this->db->where('id_mutasi', $data['sql_penj']->id)->get('tbl_trans_mutasi_det')->result();
            $data['jml_mutasi']    = $this->db->select_sum('jml')->where('id_mutasi', $data['sql_penj']->id)->get('tbl_trans_mutasi_det')->row();
            $data['jml_terima']    = $this->db->select_sum('jml_diterima')->where('id_mutasi', $data['sql_penj']->id)->get('tbl_trans_mutasi_det')->row();
            $data['jml_kurang']    = $data['jml_mutasi']->jml - $data['jml_terima']->jml_diterima;
                  
            /* --End Blok pagination-- */
            $data['sidebar']    = 'admin-lte-3/includes/gudang/sidebar_gudang';
            /* --- Sidebar Menu --- */

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/gudang/trans_mutasi_terima', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function trans_mutasi_terima_simpan() {
        // Set JSON header
        header('Content-Type: application/json');
        
        if (!$this->ion_auth->logged_in()) {
            echo json_encode([
                'success' => false,
                'message' => 'Sesi anda telah berakhir'
            ]);
            return;
        }

        try {
            // Validate form data
            $this->form_validation->set_rules('id[]', 'ID', 'required');
            $this->form_validation->set_rules('jml_terima[]', 'Jumlah Terima', 'required|numeric');

            if ($this->form_validation->run() == FALSE) {
                throw new Exception(validation_errors());
            }

            // Start transaction
            $this->db->trans_begin();

            $ids            = $this->input->post('id');
            $quantities     = $this->input->post('jml_terima');
            $current_stocks = $this->input->post('current_stock');

            foreach ($ids as $key => $id) {
                // Process each item
                $decoded_id     = general::dekrip($id);
                $qty            = $quantities[$key];
                $current_stock  = $current_stocks[$key];

                // Get mutation details
                $sql_mut_det    = $this->db->where('id', $decoded_id)->get('tbl_trans_mutasi_det')->row();
                $sql_mut        = $this->db->where('id', $sql_mut_det->id_mutasi)->get('tbl_trans_mutasi')->row();
                $sql_cek_brg    = $this->db->where('id', $sql_mut_det->id_item)->get('tbl_m_produk')->row();
                
                // Get warehouse information
                $sql_gudang = $this->db->where('id', $sql_mut_det->id_gd_asal)->get('tbl_m_gudang')->row();
                $sql_gudang_asl = $this->db->where('id_gudang', $sql_mut->id_gd_asal)
                                           ->where('id_produk', $sql_mut_det->id_item)
                                           ->get('tbl_m_produk_stok')
                                           ->row();
                $sql_gudang_7an = $this->db->where('id_gudang', $sql_mut->id_gd_tujuan)
                                           ->where('id_produk', $sql_mut_det->id_item)
                                           ->get('tbl_m_produk_stok')
                                           ->row();
                
                $jml_akhir_stk = $sql_gudang_asl->jml - $quantities[$key];
                $jml_akhir_7an = $sql_gudang_7an->jml + $quantities[$key];
                $sql_gudang_ck = $this->db->where('id_produk', $sql_mut_det->id_item)
                                          ->where('id_gudang', $sql_mut_det->id_gd_tujuan)
                                          ->get('tbl_m_produk_stok');
                if($jml_akhir_stk < 0){
                    throw new Exception("Stok tidak mencukupi, hanya tersedia ".$sql_gudang_asl->jml." ".$sql_mut_det->satuan);                    
                }

                # Kurangi stok daripada gudang asal
                $this->db->where('id', $sql_gudang_asl->id)
                         ->update('tbl_m_produk_stok', ['jml' => $jml_akhir_stk]);

                # Tambahkan stok daripada gudang tujuan
                $this->db->where('id', $sql_gudang_7an->id)
                         ->update('tbl_m_produk_stok', ['jml' => $jml_akhir_7an]);

                $this->db->where('id', $sql_mut_det->id)
                         ->update('tbl_trans_mutasi_det', ['tgl_terima' => date('Y-m-d H:i:s'),'jml_diterima' => $quantities[$key]]);

                # Sinkronkan stok terkait
                $jml_akhir_glob = $this->db->select_sum('jml')
                                           ->where('id_produk', $sql_mut_det->id_item)
                                           ->get('tbl_m_produk_stok')
                                           ->row()
                                           ->jml;
                
                $this->db->where('id', $sql_mut_det->id_item)
                         ->update('tbl_m_produk', [
                             'tgl_modif'    => date('Y-m-d H:i:s'), 
                             'jml'          => $jml_akhir_glob
                         ]);

                $status = '8';
                $ket    = 'Permintaan Stok Farmasi - '.$this->ion_auth->user($sql_mut_det->id_user)->row()->first_name;
                
                # Catat log barang keluar ke tabel
                $data_mut_hist = [
                    'uuid'          => $this->uuid->v4(),
                    'tgl_simpan'    => $sql_mut_det->tgl_simpan,
                    'tgl_masuk'     => $this->tanggalan->tgl_indo_sys($sql_mut_det->tgl_simpan),
                    'id_gudang'     => $sql_mut->id_gd_asal,
                    'id_produk'     => $sql_mut_det->id_item,
                    'id_user'       => $this->ion_auth->user()->row()->id,
                    'id_penjualan'  => $sql_mut->id,
                    'no_nota'       => $sql_mut->no_nota,
                    'kode'          => $sql_mut_det->kode,
                    'produk'        => $sql_cek_brg->produk,
                    'keterangan'    => $ket,
                    'jml'           => (int)$sql_mut_det->jml,
                    'jml_satuan'    => 1,
                    'satuan'        => $sql_mut_det->satuan,
                    'nominal'       => 0,
                    'status'        => $status
                ];
                
                # Simpan riwayat stok
                $this->db->insert('tbl_m_produk_hist', $data_mut_hist);
            }

            if ($this->db->trans_status() === FALSE) {
                throw new Exception('Terjadi kesalahan database');
            }

            // Commit transaction
            $this->db->trans_commit();

            echo json_encode([
                'success' => true,
                'message' => 'Transaksi berhasil diproses'
            ]);
        } catch (Exception $e) {
            // Rollback transaction
            $this->db->trans_rollback();

            echo json_encode([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
    
    public function trans_mutasi_terima_hapus_hist() {
        if (akses::aksesLogin() == TRUE) {
            $id  = $this->input->get('id');
            $uid = $this->input->get('uid');
            $rut = $this->input->get('route');
            
            try {
                if(!empty($id)){
                    $sql_prod = $this->db->where('id', general::dekrip($uid))->get('tbl_m_produk')->row();
                    $sql_hist = $this->db->where('id', general::dekrip($id))->get('tbl_m_produk_hist')->row();
                    $sql_stok = $this->db->where('id_gudang', $sql_hist->id_gudang)->where('id_produk', $sql_hist->id_produk)->get('tbl_m_produk_stok')->row();
                    $sql_det  = $this->db->where('id', $sql_hist->id_pembelian_det)->where('id_produk', $sql_hist->id_produk)->get('tbl_trans_beli_det')->row();
                    $sql_mts  = $this->db->select('tbl_trans_mutasi.id, tbl_trans_mutasi.id_gd_asal, tbl_trans_mutasi.id_gd_tujuan')->join('tbl_trans_mutasi', 'tbl_trans_mutasi.id=tbl_trans_mutasi_det.id_mutasi')->where('tbl_trans_mutasi_det.kode', $sql_prod->kode)->get('tbl_trans_mutasi_det')->row();

                    switch ($sql_hist->status){
                        case '1':
                            $stok = $sql_stok->jml - $sql_hist->jml;
                            break;
                        
                        case '2':
                            $stok = $sql_stok->jml - $sql_hist->jml;
                            break;
                        
                        case '3':
                            $stok = $sql_stok->jml - $sql_hist->jml;
                            break;
                        
                        case '4':
                            $stok = $sql_stok->jml + $sql_hist->jml;
                            break;
                        
                        case '5':
                            $stok = $sql_stok->jml + $sql_hist->jml;
                            break;
                        
                        case '6':
                            $stok = $sql_stok->jml + $sql_hist->jml;
                            break;
                        
                        case '7':
                            $stok = $sql_stok->jml + $sql_hist->jml;
                            break;
                        
                        case '8':
                            $stok_asal = $this->db->where('id_produk', $sql_hist->id_produk)->where('id_gudang', $sql_mts->id_gd_asal)->get('tbl_m_produk_stok')->row()->jml + $sql_hist->jml;
    //                        $this->db->where('id_produk', $sql_hist->id_produk)->where('id_gudang', $sql_mts->id_gd_asal)->update('tbl_m_produk_stok', array('tgl_modif'=>date('Y-m-d H:i:s'),'jml'=>$stok_asal));
                            $stok = $sql_stok->jml - $sql_hist->jml;
                            break;
                    }
                    
                    $jml_trm        = $sql_det->jml_diterima - ($sql_hist->jml * $sql_hist->jml_satuan);
                    $jml_diterima   = ($jml_trm < 0 ? 0 : $jml_trm);
                    
                    # Start transaction
                    $this->db->trans_begin();
                    
                    # Ubah status penerimaan menjadi 0
                    $this->db->where('id', $sql_hist->id_pembelian)->update('tbl_trans_beli', array('status_penerimaan'=>'0'));
                    
                    # Ubah jml diterima sesuai data semula
                    $this->db->where('id', $sql_det->id)->update('tbl_trans_beli_det', array('jml_diterima'=>$jml_diterima)); 
                    
                    # Ubah jumlah stok nya yang sesuai penerimaan pada gudang
                    $this->db->where('id_produk', $sql_hist->id_produk)->where('id_gudang', $sql_hist->id_gudang)->update('tbl_m_produk_stok', array('jml'=>$stok));
                    
                    # Hapus riwayat penerimaan barang
                    $this->db->where('id_produk', $sql_hist->id_produk)->where('id_gudang', $sql_hist->id_gudang)->delete('tbl_m_produk_hist');
                    
                    # Hitung ulang total stok terkait kemudian update ke tabel utama
                    $sql_sum = $this->db->select_sum('jml')->where('id_produk', $sql_hist->id_produk)->get('tbl_m_produk_stok')->row();
                    $stk_sum = $sql_sum->jml;
                    
                    $this->db->where('id', $sql_hist->id_produk)->update('tbl_m_produk', array('tgl_modif'=>date('Y-m-d H:i:s'), 'jml'=>$stk_sum));
                    
                    # Check if transaction successful
                    if ($this->db->trans_status() === FALSE) {
                        $this->db->trans_rollback();
                        throw new Exception("Terjadi kesalahan dalam transaksi database");
                    } else {
                        $this->db->trans_commit();
                        redirect(base_url((!empty($rut) ? $rut.'?id='.general::enkrip($sql_hist->id_pembelian) : 'gudang/trans_beli_terima.php?id='.$uid)));
                    }
                }
            } catch (Exception $e) {
                # Rollback if error
                $this->db->trans_rollback();
                
                $this->session->set_flashdata('gd_toast', 'toastr.error("Error: '.$e->getMessage().'");');
                redirect(base_url('gudang/trans_beli_terima.php'));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    

    
    public function cart_mutasi_simpan() {
        if (akses::aksesLogin() == TRUE) {
            $id         = $this->input->post('id');
            $id_item    = $this->input->post('id_item');
            $kodeb      = $this->input->post('kode_batch');
            $tgl_ed     = $this->input->post('tgl_ed');
            $jml        = $this->input->post('jml');
            $ket        = $this->input->post('ket');
            $satuan     = $this->input->post('satuan');
            $rute       = $this->input->post('route');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id_item', 'Item', 'required|trim');


            if ($this->form_validation->run() == FALSE) {
                $msg_error = [
                    'kode'   => form_error('id_item'),
                ];

                $this->session->set_flashdata('form_error', $msg_error);
                $this->session->set_flashdata('gd_toast', 'toastr.error("Form tidak valid, silahkan periksa kembali data yang diinput");');
                
                redirect(base_url((!empty($rute) ? $rute : 'gudang/trans_mutasi.php').'?id='.$id.'&item_id='.$id_item));
            } else {
                $this->db->trans_begin();

                try {
                    // Cek Form Submission - Fix TypeError by checking if function exists first
                    $form_id = $this->input->post('form_id');
                    if (function_exists('check_form_submitted') && $form_id) {
                        // Wrap in try-catch to prevent uncaught exceptions
                        try {
                            if (check_form_submitted($form_id)) {
                                throw new Exception("Form sudah disubmit sebelumnya");
                            }
                        } catch (Exception $formEx) {
                            // Log error but continue processing
                            log_message('error', 'Form protection error: ' . $formEx->getMessage());
                        }
                    }
                
                    // Ambil data dari sesi dan database
                    $sess_mut           = $this->session->userdata('trans_mutasi');
                    $sql_brg            = $this->db->where('id', general::dekrip($id_item))->get('tbl_m_produk')->row();
                    $sql_brg_stk_asl    = $this->db->where('id_produk', $sql_brg->id)
                                               ->where('id_gudang', $sess_mut['id_gd_asal'])
                                               ->get('tbl_m_produk_stok')->row();
                    $sql_brg_stk_7an    = $this->db->where('id_produk', $sql_brg->id)
                                               ->where('id_gudang', $sess_mut['id_gd_tujuan'])
                                               ->get('tbl_m_produk_stok')->row();
                    $sql_satuan         = $this->db->where('id', $satuan)->get('tbl_m_satuan')->row();

                    $stok_asal          = $sql_brg_stk_asl->jml - $jml;
                    $stok_tujuan        = $sql_brg_stk_7an->jml + $jml;

                    if ($stok_asal < 0) {
                        throw new Exception('Stok tidak cukup.<br/><b>Stok tersedia: </b>' . $sql_brg_stk_asl->jml . '<br/><b>Permintaan: </b>' . $jml);
                    }
                
                    // Data yang akan dimasukkan ke tabel mutasi detail
                    $data_mut_det = [
                        'id_mutasi'    => general::dekrip($id),
                        'id_item'      => $sql_brg->id,
                        'id_satuan'    => $sql_satuan->id,
                        'id_user'      => $this->ion_auth->user()->row()->id,
                        'no_nota'      => $sess_mut['no_nota'],
                        'tgl_simpan'   => $sess_mut['tgl_simpan'],
                        'tgl_terima'   => '0000-00-00 00:00:00',
                        'tgl_ed'       => (!empty($tgl_ed) ? $tgl_ed : '0000-00-00'),
                        'satuan'       => $sql_satuan->satuanBesar,
                        'keterangan'   => $ket,
                        'kode'         => $sql_brg->kode,
                        'kode_batch'   => $kodeb,
                        'produk'       => strtoupper($sql_brg->produk),
                        'jml'          => (int)$jml,
                        'jml_satuan'   => (!empty($sql_satuan->jml) ? $sql_satuan->jml : 1),
                        'status_terima'=> '0',
                    ];
                
                    // Cek stok sebelum eksekusi
                    if ($sql_brg_stk_asl->jml < $jml AND $sess_mut['tipe'] != '2') {
                        throw new Exception("Stok tidak tersedia !");
                    } else {
                        if (!$this->db->insert('tbl_trans_mutasi_det', $data_mut_det)) {
                            throw new Exception("Gagal menyimpan data mutasi");
                        }
                    }
                
                    // Commit transaksi jika tidak ada masalah
                    $this->db->trans_commit();

                    // Set success message
                    $this->session->set_flashdata('gd_toast', 'toastr.success("<b>'.$sql_brg->produk.'</b> berhasil ditambahkan");');
                    redirect(base_url((!empty($rute) ? $rute : 'gudang/trans_mutasi.php') . '?id=' . $id));
                } catch (Exception $e) {
                    $this->db->trans_rollback(); // Rollback jika terjadi kesalahan
                    $this->session->set_flashdata('gd_toast', 'toastr.error("' . $e->getMessage() . '");');
                    redirect(base_url('gudang/trans_mutasi.php?id=' . $id . '&item_id=' . $id_item));
                }
                
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function cart_mutasi_hapus() {
        if (akses::aksesLogin() == TRUE) {
            $id    = $this->input->get('id');
            $nota  = $this->input->get('no_nota');
            $rute  = $this->input->get('route');
            
            try {
                if(!empty($id)){
                    if(!$this->db->where('id', general::dekrip($id))->delete('tbl_trans_mutasi_det')) {
                        throw new Exception("Gagal menghapus item mutasi");
                    }
                    $this->session->set_flashdata('gd_toast', 'toastr.success("Item berhasil dihapus");');
                }
                
                redirect(base_url('gudang/'.(!empty($rute) ? $rute : 'trans_mutasi.php').'?id='.$nota));
            } catch (Exception $e) {
                $this->session->set_flashdata('gd_toast', 'toastr.error("' . $e->getMessage() . '");');
                redirect(base_url('gudang/'.(!empty($rute) ? $rute : 'trans_mutasi.php').'?id='.$nota));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_trans_mutasi() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota    = $this->input->post('no_nota');
            $kode_fp    = $this->input->post('kode_fp');
            $tgl_masuk  = $this->input->post('tgl_masuk');
            $tgl_tempo  = $this->input->post('tgl_tempo');
            $gd_asal    = $this->input->post('gd_asal');
            $gd_tujuan  = $this->input->post('gd_tujuan');
            $ket        = $this->input->post('ket');
            $tipe       = $this->input->post('tipe');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();
            $pengaturan2= $this->db->where('id', $this->ion_auth->user()->row()->id_app)->get('tbl_pengaturan_cabang')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('tgl_masuk', 'Tgl Masuk', 'required');
            $this->form_validation->set_rules('tipe', 'Tipe', 'required');
            $this->form_validation->set_rules('gd_asal', 'Gd. Asal', 'required');
            $this->form_validation->set_rules('gd_tujuan', 'Gd. Tujuan', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = [
                    'tgl_masuk'   => form_error('tgl_masuk'),
                    'tipe'        => form_error('gd_asal'),
                    'gd_asal'     => form_error('gd_asal'),
                    'gd_tujuan'   => form_error('gd_tujuan'),
                ];

                $this->session->set_flashdata('form_error', $msg_error);
                $this->session->set_flashdata('gd_toast', 'toastr.error("Validasi form gagal, silahkan periksa kembali.");');
                
                redirect(base_url('gudang/trans_mutasi.php'));
            } else {
                # Transaksi Start
                $this->db->trans_begin();

                try {
                    $sql_nota   = $this->db->get('tbl_trans_mutasi');
                    $noUrut     = $sql_nota->num_rows() + 1;
                    $nota       = sprintf("%05s", $noUrut);
                
                    $data = [
                        'tgl_simpan'    => date('Y-m-d H:i:s'),
                        'tgl_masuk'     => $this->tanggalan->tgl_indo_sys($tgl_masuk),
                        'id_user'       => $this->ion_auth->user()->row()->id,
                        'id_gd_asal'    => $gd_asal,
                        'id_gd_tujuan'  => $gd_tujuan,
                        'no_nota'       => $nota,
                        'keterangan'    => $ket,
                        'tipe'          => $tipe,
                        'status_nota'   => '0'
                    ];
				
                    if ($gd_asal == $gd_tujuan AND $tipe == '1') {
                        throw new Exception("Gudang Asal dan Tujuan tidak boleh sama !");
                    } else {
                        # Set transaksi mutasi di gudang
                        $this->db->insert('tbl_trans_mutasi', $data);
                        $last_id = crud::last_id();
                    
                        if ($this->db->trans_status() === FALSE) {
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('gd_toast', 'toastr.error("Gagal menyimpan data mutasi!");');
                            redirect(base_url('gudang/trans_mutasi.php'));
                        } else {
                            $this->db->trans_commit();
                            $this->session->set_userdata('trans_mutasi', $data);
                            $this->session->set_flashdata('gd_toast', 'toastr.success("Data mutasi berhasil disimpan");');
                            redirect(base_url('gudang/trans_mutasi.php?id=' . general::enkrip($last_id)));
                        }
                    }
                } catch (Exception $e) {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('gd_toast', 'toastr.error("' . $e->getMessage() . '");');
                    redirect(base_url('gudang/trans_mutasi.php'));
                }
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_trans_mutasi_update() {
        if (akses::aksesLogin() == TRUE) {
            $id         = $this->input->post('id');
            $no_nota    = $this->input->post('no_nota');
            $kode_fp    = $this->input->post('kode_fp');
            $tgl_masuk  = $this->input->post('tgl_masuk');
            $tgl_tempo  = $this->input->post('tgl_tempo');
            $gd_asal    = $this->input->post('gd_asal');
            $gd_tujuan  = $this->input->post('gd_tujuan');
            $ket        = $this->input->post('ket');
            $tipe       = $this->input->post('tipe');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();
            $pengaturan2= $this->db->where('id', $this->ion_auth->user()->row()->id_app)->get('tbl_pengaturan_cabang')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('tgl_masuk', 'Tgl Masuk', 'required');
            $this->form_validation->set_rules('tipe', 'Tipe', 'required');
            $this->form_validation->set_rules('gd_asal', 'Gd. Asal', 'required');
            $this->form_validation->set_rules('gd_tujuan', 'Gd. Tujuan', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = [
                    'tgl_masuk'   => form_error('tgl_masuk'),
                    'tipe'        => form_error('tipe'),
                    'gd_asal'     => form_error('gd_asal'),
                    'gd_tujuan'   => form_error('gd_tujuan'),
                ];

                $this->session->set_flashdata('form_error', $msg_error);
                $this->session->set_flashdata('medcheck_toast', 'toastr.error("Validasi form gagal, silahkan periksa kembali.");');
                redirect(base_url('gudang/trans_mutasi.php'));
            } else {
                try {
                    $data = [
                        'tgl_simpan'    => date('Y-m-d H:i:s'),
                        'tgl_masuk'     => $this->tanggalan->tgl_indo_sys($tgl_masuk),
                        'id_user'       => $this->ion_auth->user()->row()->id,
                        'id_gd_asal'    => $gd_asal,
                        'id_gd_tujuan'  => $gd_tujuan,
                        'no_nota'       => $no_nota,
                        'keterangan'    => $ket,
                        'tipe'          => $tipe,
                        'status_nota'   => '0'
                    ];
				
                    if ($gd_asal == $gd_tujuan && $tipe == '1') {
                        throw new Exception("Gudang Asal dan Tujuan tidak boleh sama!");
                    } else {
                        # Transaksi Start
                        $this->db->trans_begin();
                        
                        # Set transaksi mutasi di gudang
                        $this->db->where('id', general::dekrip($id))->update('tbl_trans_mutasi', $data);
                        
                        if ($this->db->trans_status() === FALSE) {
                            $this->db->trans_rollback();
                            throw new Exception("Gagal mengupdate data transaksi mutasi");
                        }
                        
                        $this->db->trans_commit();
                        $this->session->set_userdata('trans_mutasi', $data);
                        $this->session->set_flashdata('medcheck_toast', 'toastr.success("Data mutasi berhasil diupdate");');
                        redirect(base_url('gudang/trans_mutasi_edit.php?id=' . $id));
                    }
                } catch (Exception $e) {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('medcheck_toast', 'toastr.error("' . $e->getMessage() . '");');
                    redirect(base_url('gudang/trans_mutasi.php'));
                }
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_trans_mutasi_proses() {
        if (akses::aksesLogin() == TRUE) {
            $id         = $this->input->post('id');
            $status_gd  = $this->ion_auth->user()->row()->status_gudang;
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id', 'ID', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = [
                    'kode'   => form_error('kode'),
                ];

                $this->session->set_flashdata('form_error', $msg_error);
                $this->session->set_flashdata('gd_toast', 'toastr.error("Validasi form gagal, silahkan periksa kembali.");');
                redirect(base_url('gudang/trans_mutasi.php?id='.$id));
            } else {
            $trans_mut      = $this->db->where('id', general::dekrip($id))->get('tbl_trans_mutasi');
            $trans_mut_det  = $this->db->where('id_mutasi', $trans_mut->row()->id)->get('tbl_trans_mutasi_det')->result();
            
                $this->db->trans_begin();

                try {
                    // Cek Form Submission
                    $form_id = $this->input->post('form_id');
                    if (check_form_submitted($form_id)) {
                        throw new Exception("Form sudah disubmit sebelumnya");
                    }

                    
                    // Check if there are details in the transaction
                    if (empty($trans_mut_det)) {
                        throw new Exception("Tidak ada item yang akan dimutasi!");
                    }
                    
                    // Update status in the main transaction table
                    $data_mutasi = [
                        'status_nota'   => '1',
                        'tgl_keluar'    => date('Y-m-d H:i:s')
                    ];
                    
                    $this->db->where('id', $trans_mut->row()->id)->update('tbl_trans_mutasi', $data_mutasi);
                    
                    
                    if ($this->db->trans_status() === FALSE) {
                        throw new Exception("Gagal memproses transaksi mutasi");
                    }
                    
                    $this->db->trans_commit();

                    // Destroy all sessions related to this transaction
                    $this->session->unset_userdata('trans_mutasi');
                    $this->cart->destroy();
                
                    $this->session->set_flashdata('gd_toast', 'toastr.success("Transaksi mutasi berhasil diproses");');
                    redirect(base_url('gudang/trans_mutasi_det.php?id='.$id));                    
                } catch (Exception $e) {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('gd_toast', 'toastr.error("' . $e->getMessage() . '");');
                    redirect(base_url('gudang/trans_mutasi.php?id='.$id));
                }
            }               
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_trans_mutasi_batal() {
        if (akses::aksesLogin() == TRUE) {
            $id   = $this->input->get('id');
                        
            $this->session->unset_userdata('trans_mutasi');
            $this->cart->destroy();
            redirect(base_url('gudang/trans_mutasi.php'));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_trans_mutasi_finish() {
        if (akses::aksesLogin() == TRUE) {
            $id         = $this->input->get('id');
            $sql_cek    = $this->db->where('id', general::dekrip($id))->get('tbl_trans_mutasi');
            
            // Jika jumlah kurang lebih dari 0, update
            if($sql_cek->num_rows() > 0){
                $data = [
                    'tgl_keluar'        => date('Y-m-d'),
                    'id_user_terima'    => $this->ion_auth->users()->row()->id,
                    'status_nota'       => '2',
                    'status_terima'     => '1'
                ];
                
                # Set penerimaan pada tabel mutasi nota
                $this->db->where('id', $sql_cek->row()->id)->update('tbl_trans_mutasi', $data);
                
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('gd_toast', 'toastr.success("Mutasi sudah di selesaikan !");');
                }
            }
            
            redirect(base_url('gudang/trans_mutasi_det.php?id='.$id));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function set_trans_mutasi_tolak() {
        if (akses::aksesLogin() == TRUE) {
            $id         = $this->input->get('id');
            $sql_cek    = $this->db->where('id', general::dekrip($id))->get('tbl_trans_mutasi');
            
            // Jika data ditemukan, update status
            if($sql_cek->num_rows() > 0){
                $data = [
                    'tgl_keluar'        => date('Y-m-d'),
                    'tgl_modif'         => date('Y-m-d H:i:s'),
                    'id_user_terima'    => $this->ion_auth->users()->row()->id,
                    'status_nota'       => '2', // Status ditolak
                    'status_terima'     => '2'  // Status ditolak
                ];

                # Set penolakan pada tabel mutasi nota
                $this->db->where('id', $sql_cek->row()->id)->update('tbl_trans_mutasi', $data);
                
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('gd_toast', 'toastr.warning("Permintaan mutasi telah ditolak!");');
                }
            }
            
            redirect(base_url('gudang/trans_mutasi_terima.php?id='.$id));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
        
    public function set_beli_terima_finish() {
        if (akses::aksesLogin() == TRUE) {
            $id      = $this->input->get('id');            
            $sql_cek     = $this->db->where('id', general::dekrip($id))->get('tbl_trans_beli')->row();
            
            // Jika jumlah kurang lebih dari 0, update
            if(!empty($id)){
                crud::update('tbl_trans_beli', 'id', $sql_cek->id, array('id_penerima' => $this->ion_auth->users()->row()->id, 'status_penerimaan' => '3'));
            }
            
            $this->session->set_flashdata('gudang', '<div class="alert alert-success">Data Penerimaan Selesai</div>');                
            redirect(base_url('gudang/trans_beli_terima.php?id='.$id));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function cart_nota_mutasi_simpan() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota  = $this->input->post('no_nota');
            $id_brg   = $this->input->post('id_barang');
            $kode     = $this->input->post('kode');
            $satuan   = $this->input->post('satuan');
            $qty      = $this->input->post('jml');
            $diskon1  = $this->input->post('disk1');
            $diskon2  = $this->input->post('disk2');
            $diskon3  = $this->input->post('disk3');
            $nomor    = $this->input->post('nomor');
            $hrg_ds   = $this->input->post('harga_ds');
            $harga    = str_replace('.', '', $this->input->post('harga'));
            $potongan = str_replace('.', '', $this->input->post('potongan'));
            $status_gd= $this->ion_auth->user()->row()->status_gudang;

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('kode', 'Kode', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = [
                    'kode' => form_error('kode'),
                ];

                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url('transaksi/trans_jual.php?id='.general::enkrip($no_nota)));
            } else {
                $sess_jual   = $this->session->userdata('trans_mutasi');
                $sql_brg     = $this->db->where('id', general::dekrip($id_brg))
                                        ->get('tbl_m_produk')->row();
                $sql_brg_nom = $this->db->where('id_produk', $sql_brg->id)
                                        ->where('harga', $harga)
                                        ->get('tbl_m_produk_nominal')->row();
                $sql_gudang  = $this->db->where('id', $sess_jual['id_gd_asal'])->get('tbl_m_gudang')->row(); // cek gudang aktif
                $sql_stok    = $this->db->where('id_produk', $sql_brg->id)->where('id_gudang', $sql_gudang->id)->get('tbl_m_produk_stok')->row(); // cek posisi stok
                
                $sql_satuan  = $this->db->where('id_produk', $sql_brg->id)->where('satuan', $satuan)->get('tbl_m_produk_satuan')->row();
                $sql_satuan3 = $this->db->where('id', $sql_brg->id_satuan)->get('tbl_m_satuan')->row();
                $harga_jual  = (!empty($harga) ? $harga : $sql_satuan->harga); //(!empty($sql_satuan->harga) ? $sql_satuan->harga : $harga)
                
                if(!empty($hrg_ds)){
                    $sql_sat= $this->db->where('id_produk', $sql_brg->id)->where('jml !=', 0)->where('harga !=', 0)->order_by('jml', 'DESC')->get('tbl_m_produk_satuan');
                    
                    $n = 0;
                    foreach ($sql_sat->result() as $sat3){
                        if($sat3->satuan == $satuan){
                            $limit       = $n + 1;
                            $sql_satuan2 = $this->db->where('id_produk', $sql_brg->id)->where('jml !=', 0)->where('harga !=', 0)->order_by('jml', 'DESC')->limit(1,$limit)->get('tbl_m_produk_satuan')->row();
                            
                            $sat_brg    = (!empty($sql_satuan2->satuan) ? $sql_satuan2->satuan : $sql_satuan3->satuanTerkecil);
                            $sat_jual   = (!empty($sql_satuan2->jml) ? $sql_satuan2->jml : 1);
                        }
                        $n++;
                    }                    
                }else{
                    $sat_brg    = (!empty($satuan) ? $satuan : $sql_satuan3->satuanTerkecil); // (!empty($hrg_ds) ? $sql_satuan2->row()->satuan : );
                    $sat_jual   = (!empty($satuan) ? $sql_satuan->jml : 1); // (!empty($hrg_ds) ? $sql_satuan2->row()->jml : );
                }
                        
                $jml = $qty;
                // Initialize harga_jual to prevent undefined variable
                $harga_j = $harga_jual ?? 0;
                $subtotal = $harga_j * $jml;
                
                
                // Cek di keranjang
                foreach ($this->cart->contents() as $cart){                    
                    // Cek ada datanya kagak?
                    if($sql_brg->kode == $cart['options']['kode'] AND $cart['options']['satuan'] == $satuan){
                        $jml_subtotal    = ($cart['qty'] + $qty);                        
                        $jml_qty         = ($cart['qty'] + $qty);                        
                        
                        if($sql_stok->jml < $jml_subtotal){
                            $this->session->set_flashdata('transaksi', '<div class="alert alert-danger">Jumlah barang, tidak tersedia</div>');
                            redirect(base_url('transaksi/trans_jual.php?id='.$no_nota));
                        }else{
                            $this->cart->update(['rowid'=>$cart['rowid'], 'qty'=>0]);
                        }
                    }
                }
                
                // Cek jml unit dlm satuan terkecil
                $jml_unit = ((isset($jml_qty) ? (int)$jml_qty : $qty) * $sat_jual);
                
                if($sql_stok->jml < $jml_unit AND $sess_jual['tipe'] != '2'){
                    $this->session->set_flashdata('transaksi', '<div class="alert alert-danger">Jumlah barang, tidak tersedia</div>');
                }else{
                    $keranjang = [
                        'id'      => rand(1,1024).$sql_brg->id,
                        'qty'     => (!empty($jml_qty) ? $jml_qty : $qty),
                        'price'   => '1', // $disk3 => Ambil dari variable harga
                        'name'    => ($sql_brg->status_brg_dep == 1 ? str_replace(['\'','\\','/'], ' ', $sql_brg->produk.'-['.$nomor.']') : str_replace(['\'','\\','/'], ' ', $sql_brg->produk)),
                        'options' => [
                            'no_nota'   => general::dekrip($no_nota),
                            'id_barang' => $sql_brg->id,
                            'id_satuan' => $sql_brg->id_satuan,
                            'id_nominal'=> $sql_brg_nom->id,
                            'satuan'    => $sat_brg,
                            'satuan_ket'=> ($sat_jual != 1 ? ' ('.(!empty($jml_subtotal) ? $jml_qty : $qty) * $sql_satuan->jml.' '.$sql_satuan3->satuanTerkecil.')' : ''),
                            'jml'       => $qty,
                            'jml_satuan'=> ($sat_jual == '0' ? '1' : $sat_jual),
                            'kode'      => $sql_brg->kode,
                            'harga'     => $harga,
                            'disk1'     => (float)$diskon1,
                            'disk2'     => (float)$diskon2,
                            'disk3'     => (float)$diskon3,
                            'potongan'  => (float)$potongan,
                        ]
                    ];
                    
                    $this->cart->insert($keranjang);
                }
                
                redirect(base_url('gudang/trans_mutasi.php?id='.$no_nota));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function cart_nota_mutasi_hapus() {
        if (akses::aksesLogin() == TRUE) {
            $id    = $this->input->get('id');
            $nota  = $this->input->get('no_nota');
            $rute  = $this->input->get('route');
            
            if(!empty($id)){
                $cart = [
                    'rowid' => general::dekrip($id),
                    'qty'   => 0
                ];
                $this->cart->update($cart);
            }
            
            redirect(base_url('gudang/'.(!empty($rute) ? $rute : 'trans_mutasi.php').'?id='.$nota));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    
    
    public function cart_opn_simpan() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota  = $this->input->post('no_nota');
            $id_brg   = $this->input->post('id_barang');
            $kode     = $this->input->post('kode');
            $satuan   = $this->input->post('satuan');
            $qty      = $this->input->post('jml');
            $rute     = $this->input->post('rute');
            $f_produk = $this->input->post('filter_produk');
            $f_jml    = $this->input->post('filter_jml');
            $f_hal    = $this->input->post('filter_hal');
            $status_gd= $this->ion_auth->user()->row()->status_gudang;

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('kode', 'Kode', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = [
                    'kode' => form_error('kode'),
                ];

                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url('gudang/data_opname_tambah.php?id='.$no_nota));
            } else {
                $trans_opname = $this->session->userdata('trans_opname');
                $sql_brg      = $this->db->where('id', general::dekrip($id_brg))->get('tbl_m_produk')->row();
                $sql_brg_stok = $this->db->where('id_produk', general::dekrip($id_brg))->where('id_gudang', $trans_opname['id_gudang'])->get('tbl_m_produk_stok')->row();
                $sql_brg_sat  = $this->db->where('id', $sql_brg->id_satuan)->get('tbl_m_satuan')->row();
                $sql_merk     = $this->db->where('id', $sql_brg->id_merk)->get('tbl_m_merk')->row();
                $sql_so       = $this->db->where('id', general::dekrip($no_nota))->get('tbl_util_so')->row();
                
                // Save to tbl_util_so_det
                $data_so_det = [
                    'id_so'       => general::dekrip($no_nota),
                    'id_produk'   => $sql_brg->id,
                    'id_user'     => $this->ion_auth->user()->row()->id,
                    'tgl_simpan'  => date('Y-m-d H:i:s'),
                    'tgl_masuk'   => date('Y-m-d'),
                    'kode'        => $sql_brg->kode,
                    'barcode'     => $sql_brg->barcode,
                    'produk'      => $sql_brg->produk,
                    'satuan'      => $sql_brg_sat->satuanBesar,
                    'keterangan'  => '',
                    'jml'         => (float)$qty,
                    'jml_sys'     => $sql_brg_stok->jml,
                    'jml_so'      => (float)$qty,
                    'jml_sls'     => $sql_brg_stok->jml - (float)$qty,
                    'jml_satuan'  => 1,
                    'merk'        => (!empty($sql_merk) ? $sql_merk->merk : ''),
                    'sp'          => '0'
                ];
                
                try {                    
                    if (!$this->db->insert('tbl_util_so_det', $data_so_det)) {
                        throw new Exception("Gagal menyimpan data opname");
                    }
                    
                    $this->session->set_flashdata('gd_toast', 'toastr.success("Data opname '.$sql_brg->produk.' berhasil disimpan");');
                    redirect(base_url('gudang/data_opname_item_list.php?nota='.$no_nota.'&route='.$rute.(!empty($f_produk) ? '&filter_produk='.$f_produk : '').(!empty($f_jml) ? '&jml='.$f_jml : '').(!empty($f_hal) ? '&halaman='.$f_hal : '')));
                } catch (Exception $e) {
                    $this->session->set_flashdata('gd_toast', 'toastr.error("' . $e->getMessage() . '");');
                    redirect(base_url('gudang/data_opname_tambah.php?id='.$no_nota));
                }
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function cart_opn_hapus() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota  = $this->input->get('no_nota');
            $id_brg   = $this->input->get('id');
            $rute     = $this->input->get('route');

            if (empty($id_brg)) {
                $this->session->set_flashdata('gd_toast', 'toastr.error("Data barang tidak ditemukan")');
                redirect(base_url('gudang/data_opname_tambah.php?id='.$no_nota));
            } else {
                
                $this->session->set_flashdata('gd_toast', 'toastr.success("Data opname berhasil dihapus");');
                // Delete from database
                $this->db->where('id', general::dekrip($id_brg))->delete('tbl_util_so_det');
                redirect(base_url(!empty($rute) ? $rute.'&route=gudang/data_opname_tambah.php' : 'gudang/data_opname_tambah.php?id='.$no_nota));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_opname() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota    = $this->input->post('customer');
            $tgl_masuk  = $this->input->post('tgl_masuk');
            $ket        = $this->input->post('keterangan');
            $tipe       = $this->input->post('tipe');
            $gudang     = $this->input->post('gudang');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();
            $pengaturan2= $this->db->where('id', $this->ion_auth->user()->row()->id_app)->get('tbl_pengaturan_cabang')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('customer', 'customer', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = [
                    'customer' => form_error('customer'),
                ];

                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url('gudang/data_opname_tambah.php'));
            } else {
                $sql_gudang = $this->db->where('id', $gudang)->get('tbl_m_gudang')->row();
                $sess_opn   = $this->session->userdata('trans_opname');
                $uuid       = $this->uuid->v4();

                // Insert data into tbl_util_so table
                $this->db->trans_begin();
                
                try {
                    // Prepare data for insertion
                    $data_so = [
                        'uuid'         => $uuid,
                        'id_gudang'    => $sql_gudang->id,
                        'tgl_simpan'   => $this->tanggalan->tgl_indo_sys($tgl_masuk).' '.date('H:i:s'),
                        'id_user'      => $this->ion_auth->user()->row()->id,
                        'keterangan'   => $ket,
                        'status'       => '0',
                    ];
                    
                    // Insert data into tbl_util_so
                    $this->db->insert('tbl_util_so', $data_so);
                    $last_id = $this->db->insert_id();
                                    
                    $this->session->set_userdata('trans_opname', $data_so);
                    $this->db->trans_commit();

                    // Set success message
                    $this->session->set_flashdata('gd_toast', 'toastr.success("Data stok opname berhasil disimpan");');
                } catch (Exception $e) {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('gd_toast', 'toastr.error("' . $e->getMessage() . '");');
                    redirect(base_url('gudang/data_opname_tambah.php'));
                }
                
                redirect(base_url('gudang/data_opname_item_list.php?nota='.general::enkrip($last_id).'&route=gudang/data_opname_tambah.php'));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function set_opname_upd() {
        if (akses::aksesLogin() == TRUE) {
            $id         = $this->input->post('id');
            $gudang     = $this->input->post('gudang');
            $tgl_masuk  = $this->input->post('tgl_masuk');
            $ket        = $this->input->post('keterangan');
            
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
            
            $this->form_validation->set_rules('gudang', 'Gudang', 'required');
            $this->form_validation->set_rules('tgl_masuk', 'Tanggal', 'required');
            
            if ($this->form_validation->run() == FALSE) {
                $msg_error = [
                    'gudang' => form_error('gudang'),
                    'tgl_masuk' => form_error('tgl_masuk'),
                ];
                
                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url('gudang/data_opname_tambah.php?nota=' . general::enkrip($id)));
            } else {
                $sql_gudang = $this->db->where('id', $gudang)->get('tbl_m_gudang')->row();
                $sql_opname = $this->db->where('id', general::dekrip($id))->get('tbl_util_so')->row();
                
                // Update data in tbl_util_so table
                $this->db->trans_begin();
                
                try {
                    // Prepare data for insertion
                    $data_so = [
                        'uuid'         => $sql_opname->uuid,
                        'id_gudang'    => $sql_gudang->id,
                        'tgl_simpan'   => $this->tanggalan->tgl_indo_sys($tgl_masuk).' '.date('H:i:s'),
                        'id_user'      => $this->ion_auth->user()->row()->id,
                        'keterangan'   => $ket,
                        'status'       => '0',
                    ];
                    
                    // Update data in tbl_util_so
                    $this->db->where('id', $sql_opname->id);
                    $this->db->update('tbl_util_so', $data_so);
               
                    $this->db->trans_commit();

                    $this->session->set_userdata('trans_opname', $data_so);
                    
                    // Set success message
                    $this->session->set_flashdata('gd_toast', 'toastr.success("Data stok opname berhasil diperbarui.");');
                } catch (Exception $e) {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('gd_toast', 'toastr.error("' . $e->getMessage() . '");');
                    redirect(base_url('gudang/data_opname_tambah.php?nota=' . $id));
                }
                
                redirect(base_url('gudang/data_opname_item_list.php?nota=' . $id));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_opname_batal() {
        if (akses::aksesLogin() == TRUE) {
            $id     = $this->input->get('id');
            $route  = $this->input->get('route');
            
            // Delete the record if ID is provided
            if (!empty($id)) {
                $this->db->where('id', general::dekrip($id));
                $this->db->delete('tbl_util_so');
                
                $this->session->set_flashdata('gd_toast', 'toastr.success("Data stok opname berhasil dihapus.");');
            }
            
            $this->session->unset_userdata('trans_opname');
            $this->cart->destroy();
            
            if (!empty($route)) {
                redirect(base_url($route));
            } else {
                redirect(base_url('gudang/data_opname_tambah.php'));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_opname_proses() {
        if (akses::aksesLogin() == TRUE) {
            $id         = $this->input->post('id');
            $sess_id    = $this->input->post('sess_id');
            
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
            $this->form_validation->set_rules('id', 'ID', 'required');
            $this->form_validation->set_rules('sess_id', 'Session ID', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = [
                    'id'        => form_error('id'),
                    'sess_id'   => form_error('sess_id'),
                ];

                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url('gudang/data_opname_item_list.php?nota=' . $id));
            } else {
                $sess_opn   = $this->db->where('id', general::dekrip($id))->get('tbl_util_so')->row();
                $sess_det   = $this->db->where('id_so', general::dekrip($id))->get('tbl_util_so_det')->result();
                $sql_gudang = $this->db->where('id', $sess_opn->id_gudang)->get('tbl_m_gudang')->row();
                

                $data = [
                    'status'       => '1'
                ];
                
                # Transactional Database
                $this->db->trans_begin();
                $last_id = 0; // Initialize last_id to prevent undefined variable error
                
                try {
                    // Get form ID and check for double submission
                    $form_id = $this->input->post('form_id');
                    if (check_form_submitted($form_id)) {
                        throw new Exception("Form sudah disubmit sebelumnya!");
                    }

                    
                    # Simpan ke tabel SO
                    $this->db->where('id', general::dekrip($id))->update('tbl_util_so', $data);
                    $last_id = $sess_opn->id;
                    
                    foreach ($sess_det as $sess_det) {
                        $sql_brg        = $this->db->where('id', $sess_det->id_produk)->get('tbl_m_produk')->row();
                        $sql_brg_stok   = $this->db->where('id_produk', $sess_det->id_produk)->where('id_gudang', $sql_gudang->id)->get('tbl_m_produk_stok')->row();
                        $sql_merk       = $this->db->where('id', $sql_brg->id_merk)->get('tbl_m_merk')->row();
                        $jml_so         = $sess_det->jml;
                        
                        // Ensure jml and jml_sys are valid numbers to prevent division by zero
                        $jml        = !empty($sess_det->jml) && is_numeric($sess_det->jml) ? (float)$sess_det->jml : 0;
                        $jml_sys    = !empty($sess_det->jml_sys) && is_numeric($sess_det->jml_sys) ? (float)$sess_det->jml_sys : 0;
                        $jml_sls    = (float)$jml - (float)$jml_sys;
                        
                        $data_stok = [
                            'tgl_modif' => date('Y-m-d H:i:s'),
                            'jml'       => (float)$sess_det->jml,
                            'so'        => '0'
                        ];
                        
                        $data_hist = [
                            'uuid'        => $this->uuid->v4(),
                            'id_user'     => $sess_opn->id_user,
                            'id_produk'   => $sess_det->id_produk,
                            'id_gudang'   => $sql_gudang->id,
                            'id_so'       => $last_id,
                            'tgl_simpan'  => date('Y-m-d H:i:s'),
                            'tgl_masuk'   => date('Y-m-d H:i:s'),
                            'no_nota'     => sprintf("%05s", $last_id),
                            'kode'        => $sql_brg->kode,
                            'produk'      => $sql_brg->produk,
                            'satuan'      => $sess_det->satuan,
                            'jml'         => (!empty($sess_det->jml) ? $sess_det->jml : 0),
                            'jml_satuan'  => 1,
                            'keterangan'  => 'Stok Opname '.sprintf("%05s", $last_id),
                            'status'      => '6',
                        ];
                        
                        # Update stok nya di tabel produk
                        $this->db->where('id', $sql_brg_stok->id)->update('tbl_m_produk_stok', $data_stok);
                        
                        # Jumlahkan total atas dan bawah, sinkronkan dengan master item
                        $jml_akhir_glob = $this->db->select_sum('jml')->where('id_produk', $sess_det->id_produk)->get('tbl_m_produk_stok')->row()->jml;
                        $this->db->where('id', $sess_det->id_produk)->update('tbl_m_produk', ['jml' => $jml_akhir_glob]);
                        
                        # Simpan ke tabel riwayat
                        $this->db->insert('tbl_m_produk_hist', $data_hist);                    
                    }
                    
                    # Complete transaction
                    $this->db->trans_commit();
                    
                    # Hapus semua session
                    $this->session->unset_userdata('trans_opname');
                    $this->session->unset_userdata('trans_opname_rute');
                    $this->cart->destroy();
                     
                    $this->session->set_flashdata('gd_toast', 'toastr.success("Transaksi berhasil disimpan");');
                    redirect(base_url('gudang/data_opname_det.php?id='.general::enkrip($last_id).'&route=gudang/data_opname_tambah.php'));
                    
                } catch (Exception $e) {
                    # Rollback transaction
                    $this->db->trans_rollback();
                    
                    $this->session->set_flashdata('gd_toast', 'toastr.error("Transaksi gagal disimpan: '.$e->getMessage().'");');
                    redirect(base_url('gudang/data_opname_item_list.php?nota='.general::enkrip($sess_opn->uuid)));
                }
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function set_opname_cari_item() {
        if (akses::aksesLogin() == TRUE) {
            $kode = str_replace(' ', '', $this->input->post('kode'));
            $brcd = $this->input->post('barcode');
            $prod = $this->input->post('produk');
            $hpp  = $this->input->post('hpp');
            $hrga = str_replace('.','',$this->input->post('harga'));
            $sa   = $this->input->post('sa');
            $mrk  = $this->input->post('merk');
            $lok  = $this->input->post('kategori');
            $nota = $this->input->post('nota');
            $rute = $this->input->post('route');
            
            $where = "MATCH(tbl_m_produk.produk) AGAINST('".$prod."')";
            
            $jml = $this->db
//                            ->where('status_subt', '1')
                            ->where("(tbl_m_produk.produk LIKE '%".$prod."%' OR tbl_m_produk.produk_alias LIKE '%".$prod."%' OR tbl_m_produk.produk_kand LIKE '%".$prod."%' OR tbl_m_produk.kode LIKE '%".$prod."%')")
//                            ->like('id_kategori', $lok, (!empty($lok) ? 'none' : ''))
//                            ->like('id_merk', $mrk, (!empty($mrk) ? 'none' : ''))
//                            ->like('ROUND(harga_jual)', $hrga, (!empty($hrga) ? 'none' : ''))
                            ->get('tbl_m_produk')->num_rows();

            if($jml > 0){
                redirect(base_url('gudang/data_opname_item_list.php?nota='.$nota.'&route='.$rute.(!empty($kode) ? 'filter_kode='.$kode : '').(!empty($mrk) ? 'filter_merk='.$mrk : '').(!empty($lok) ? 'filter_kategori='.$lok : '').(!empty($brcd) ? 'filter_barcode='.$brcd : '').(!empty($prod) ? '&filter_produk='.$prod : '').(!empty($sa) ? '&filter_stok='.$sa : '').(!empty($hpp) ? '&filter_hpp='.$hpp : '').(!empty($hrga) ? '&filter_harga='.$hrga : '').'&jml='.$jml));
            }else{
                redirect(base_url('gudang/data_opname_item_list.php?nota='.$nota.'&route='.$rute.'&msg=Pencarian tidak di temukan!!'));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    
    public function data_stok_list() {
        if (akses::aksesLogin() == TRUE) {
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
            $sort_type       = $this->input->get('sort_type');
            $sort_order      = $this->input->get('sort_order');
            $jml             = $this->input->get('jml');
            $jml_hal         = (!empty($jml) ? $jml  : $this->db->where('status_subt', '1')->where('status_hps', '0')->get('tbl_m_produk')->num_rows());
            $pengaturan      = $this->db->get('tbl_pengaturan')->row();
            
            $data['hasError']                = $this->session->flashdata('form_error');
                        
            $config['base_url']              = base_url('gudang/data_stok_list.php?'.(!empty($filter_kode) ? '&filter_kode='.$filter_kode : '').(!empty($filter_kat) ? '&filter_kategori='.$filter_kat : '').(!empty($filter_brcd) ? '&filter_barcode='.$filter_brcd : '').(!empty($filter_merk) ? '&filter_merk='.$filter_merk : '').(!empty($filter_lokasi) ? '&filter_lokasi='.$filter_lokasi : '').(!empty($filter_produk) ? '&filter_produk='.$filter_produk : '').(!empty($filter_hpp) ? '&filter_hpp='.$filter_hpp : '').(!empty($filter_harga) ? '&filter_harga='.$filter_harga : '').(!empty($sort_order) ? '&sort_order='.$sort_order : '').(!empty($jml) ? '&jml='.$jml : ''));
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
            
            $where = "MATCH(tbl_m_produk.produk) AGAINST('".$filter_produk."')";

            if(!empty($hal)){
                if (!empty($jml)) {
                    $data['barang'] = $this->db->where('status_subt', '1')
                                               ->where('status_hps', '0')
                                               ->where("(tbl_m_produk.produk LIKE '%".$filter_produk."%' OR 
                                                       tbl_m_produk.produk_alias LIKE '%".$filter_produk."%' OR 
                                                       tbl_m_produk.produk_kand LIKE '%".$filter_produk."%' OR 
                                                       tbl_m_produk.kode LIKE '%".$filter_produk."%')")
                                               ->limit($config['per_page'], $hal)
                                               ->like('harga_jual', $filter_harga, (!empty($filter_harga) ? 'after' : ''))
                                               ->like('id_merk', $filter_merk, (!empty($filter_merk) ? 'none' : ''))
                                               ->like('id_kategori', $filter_kat, (!empty($filter_kat) ? 'none' : ''))
                                               ->like('status_subt', $filter_stok, ($filter_stok !='' ? 'none' : ''))
                                               ->order_by(!empty($sort_type) ? $sort_type : 'produk', (!empty($sort_order) ? $sort_order : 'asc'))
                                               ->get('tbl_m_produk')->result();
                } else {
                    $data['barang'] = $this->db->where('status_subt', '1')
                                               ->where('status_hps', '0')
                                               ->limit($config['per_page'], $hal)
                                               ->order_by('produk', (!empty($sort_order) ? $sort_order : 'asc'))
                                               ->get('tbl_m_produk')->result();
                }
            } else {
                if (!empty($jml)) {
                    $data['barang'] = $this->db->where('status_subt', '1')
                                               ->where('status_hps', '0')
                                               ->where("(tbl_m_produk.produk LIKE '%".$filter_produk."%' OR 
                                                       tbl_m_produk.produk_alias LIKE '%".$filter_produk."%' OR 
                                                       tbl_m_produk.produk_kand LIKE '%".$filter_produk."%' OR 
                                                       tbl_m_produk.kode LIKE '%".$filter_produk."%')")
                                               ->limit($config['per_page'], $hal)
                                               ->like('harga_jual', $filter_harga, (!empty($filter_harga) ? 'after' : ''))
                                               ->like('id_merk', $filter_merk, (!empty($filter_merk) ? 'none' : ''))
                                               ->like('id_kategori', $filter_kat, (!empty($filter_kat) ? 'none' : ''))
                                               ->like('status_subt', $filter_stok, ($filter_stok !='' ? 'none' : ''))
                                               ->order_by(!empty($sort_type) ? $sort_type : 'produk', (!empty($sort_order) ? $sort_order : 'asc'))
                                               ->get('tbl_m_produk')->result();
                } else {
                    $data['barang'] = $this->db->where('status_subt', '1')
                                               ->where('status_hps', '0')
                                               ->limit($config['per_page'])
                                               ->order_by(!empty($sort_type) ? $sort_type : 'produk', (!empty($sort_order) ? $sort_order : 'asc'))
                                               ->get('tbl_m_produk')->result();
                }
            }
            
            $this->pagination->initialize($config);
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/gudang/sidebar_gudang';
            /* --- Sidebar Menu --- */
            
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();
            $data['cetak']      = '<button type="button" onclick="window.location.href = \''.base_url('master/cetak_data_barang.php?'.(!empty($filter_kode) ? 'filter_kode='.$filter_kode : '').(!empty($filter_merk) ? '&filter_merk='.$filter_merk : '').(!empty($filter_lokasi) ? '&filter_lokasi='.$filter_lokasi : '').(!empty($filter_produk) ? '&filter_produk='.$filter_produk : '').(!empty($filter_hpp) ? '&filter_hpp='.$filter_hpp : '').(!empty($filter_harga) ? '&filter_harga='.$filter_harga : '').(!empty($jml) ? '&jml='.$jml : '')).'\'" class="btn btn-warning btn-flat"><i class="fa fa-print"></i> Cetak</button>';

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/gudang/data_stok_list', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function data_stok_tambah() {
        if (akses::aksesLogin() == TRUE) {
            $id         = $this->input->get('id');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();
            
            $data['barang']      = $this->db->where('id', general::dekrip($id))->get('tbl_m_produk')->row();           
            $data['barang_stok'] = $this->db->select('SUM(jml * jml_satuan) as jml')->where('id_produk', general::dekrip($id))->get('tbl_m_produk_stok')->row();           
            $data['sql_satuan']  = $this->db->get('tbl_m_satuan')->result();
            $data['gudang_ls']   = $this->db->get('tbl_m_gudang')->result();
            $data['gudang']      = $this->db->select('tbl_m_produk_stok.id, tbl_m_produk_stok.id_produk, tbl_m_produk_stok.jml, tbl_m_produk_stok.satuanKecil as satuan, tbl_m_gudang.gudang, tbl_m_gudang.status')->join('tbl_m_gudang', 'tbl_m_gudang.id=tbl_m_produk_stok.id_gudang')->where('tbl_m_produk_stok.id_produk', general::dekrip($id))->get('tbl_m_produk_stok')->result();
  
            # -- PAGINATION UNTUK HISTORY
            /* -- Blok Filter -- */
            $hal     = $this->input->get('halaman');
            $gd      = $this->input->get('filter_gd');
            $jml     = $this->input->get('filter_jml');
            $ket     = $this->input->get('filter_ket');
            $status  = $this->input->get('filter_status');

            $total_rows = $this->db
                               ->where('id_produk', $data['barang']->id)
                               ->like('id_gudang', $gd, (!empty($gd) ? 'none' : ''))
                               ->like('jml', $jml, (!empty($jml) ? 'none' : ''))
                               ->like('keterangan', $ket, (!empty($ket) ? 'none' : ''))
                               ->like('status', $status, (!empty($status) ? 'none' : ''))
                               ->get('tbl_m_produk_hist')->num_rows();
            /* -- End Blok Filter -- */
            /* -- Form Error -- */
            $data['hasError']                = $this->session->flashdata('form_error');

            /* -- Blok Pagination -- */
            $config['base_url']              = base_url('gudang/data_stok_tambah.php?id='.$id.
                                                (!empty($gd) ? '&filter_gd='.$gd : '').
                                                (!empty($jml) ? '&filter_jml='.$jml : '').
                                                (!empty($ket) ? '&filter_ket='.$ket : '').
                                                (!empty($status) ? '&filter_status='.$status : ''));
            $config['total_rows']            = $total_rows;
            
            $config['query_string_segment']  = 'halaman';
            $config['page_query_string']     = TRUE;
            $config['per_page']              = $pengaturan->jml_item;
            $config['num_links']             = 3;
            
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
            $config['attributes']            = array('class' => 'page-link');
            /* -- End Blok Pagination -- */
            
            $data['barang_hist'] = $this->db
                                        ->select('tgl_simpan, tgl_masuk, id, id_user, id_gudang, id_pembelian, id_pembelian_det, id_penjualan, id_produk, no_nota, kode, jml, jml_satuan, nominal, satuan, keterangan, status')
                                        ->where('id_produk', $data['barang']->id)
                                        ->like('id_gudang', $gd, (!empty($gd) ? 'none' : ''))
                                        ->like('jml', $jml, (!empty($jml) ? 'none' : ''))
                                        ->like('keterangan', $ket, (!empty($ket) ? 'none' : ''))
                                        ->like('status', $status, (!empty($status) ? 'none' : ''))
                                        ->limit($config['per_page'], $hal)
                                        ->order_by('tgl_simpan, status', 'asc')
                                        ->get('tbl_m_produk_hist')->result();
            $this->pagination->initialize($config);
            
            /* Blok pagination */
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();
            /* --End Blok pagination-- */

            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/gudang/sidebar_gudang';
            /* --- Sidebar Menu --- */

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/gudang/data_stok_tambah', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    

    
    public function set_stok_update_gd() {
        if (akses::aksesLogin() == TRUE) {
            $id      = $this->input->post('id');
            $jml     = $this->input->post('jml');
            $satuan  = $this->input->post('satuan');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id', 'Kode Barang', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = [
                    'id' => form_error('id'),
                ];

                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url('master/data_barang_tambah.php?id='.$id));
            } else {
                try {
                    foreach ($_POST['jml'] as $key => $pos) {                    
                        // Get current stock data
                        $stock_data = $this->db->where('id', $key)->get('tbl_m_produk_stok')->row();
                        if (!$stock_data) {
                            throw new Exception("Data stok tidak ditemukan");
                        }
                        
                        $product_data   = $this->db->where('id', $stock_data->id_produk)->get('tbl_m_produk')->row();
                        $gudang_data    = $this->db->where('id', $stock_data->id_gudang)->get('tbl_m_gudang')->row();
                        
                        // Calculate stock difference
                        $old_stock      = $stock_data->jml;
                        $new_stock      = (int)$_POST['jml'][$key];
                        $stock_diff     = $new_stock - $old_stock;
                        
                        // Update stock data
                        $data_stok_gd = [
                            'tgl_modif' => date('Y-m-d H:i:s'),
                            'jml'       => $new_stock, 
                        ];
                        
                        # Simpan stok per gudang
                        $this->db->where('id', $key)->update('tbl_m_produk_stok', $data_stok_gd);
    
                        # Catat log barang ke tabel history
                        $data_mut_hist = [
                            'uuid'          => $this->uuid->v4(),
                            'tgl_simpan'    => date('Y-m-d H:i:s'),
                            'tgl_masuk'     => $this->tanggalan->tgl_indo_sys(date('Y-m-d')),
                            'id_gudang'     => $stock_data->id_gudang,
                            'id_produk'     => $stock_data->id_produk,
                            'id_user'       => $this->ion_auth->user()->row()->id,
                            'no_nota'       => 'ADJUST-'.date('YmdHis'),
                            'kode'          => $product_data->kode,
                            'produk'        => $product_data->produk,
                            'keterangan'    => 'Penyesuaian stok manual',
                            'jml'           => ($stock_diff > 0 ? $stock_diff : $_POST['jml'][$key]),
                            'jml_satuan'    => 1,
                            'satuan'        => $product_data->satuan,
                            'nominal'       => 0,
                            'status'        => '9'
                        ];
                        
                        # Simpan riwayat stok
                        // $this->db->insert('tbl_m_produk_hist', $data_mut_hist);
                    }
                    
                    $sql_stk_gd = $this->db->select_sum('jml')->where('id_produk', general::dekrip($id))->get('tbl_m_produk_stok')->row();
                    $data_stok = [
                        'tgl_modif' => date('Y-m-d H:i:s'),
                        'jml'       => $sql_stk_gd->jml,
                    ];
                    
                    # Update stok global
                    $this->db->where('id', general::dekrip($id))->update('tbl_m_produk', $data_stok);
                    
                    $this->session->set_flashdata('gd_toast', 'toastr.success("Update stok berhasil disimpan !");');
                    
                    if(akses::hakSA() == TRUE OR akses::hakOwner() == TRUE){
                        redirect(base_url('gudang/data_stok_tambah.php?id='.$id));
                    }else{
                        redirect(base_url('master/data_barang_tambah.php?id='.$id.'&route=gudang/data_stok_list'));
                    }
                } catch (Exception $e) {
                    $this->session->set_flashdata('gd_toast', 'toastr.error("Update stok gagal: ' . $e->getMessage() . '");');
                    
                    if(akses::hakSA() == TRUE OR akses::hakOwner() == TRUE){
                        redirect(base_url('gudang/data_stok_tambah.php?id='.$id));
                    }else{
                        redirect(base_url('master/data_barang_tambah.php?id='.$id.'&route=gudang/data_stok_list'));
                    }
                }
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function set_cari_mutasi() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota   = $this->input->post('no_nota');
            $tgl_trans = $this->input->post('tgl');
            $supplier  = $this->input->post('supplier');
            $rute      = $this->input->post('route');
            
            $jml = $this->db
                        ->like('DATE(tgl_simpan)', $this->tanggalan->tgl_indo_sys($tgl_trans), (!empty($tgl_trans) ? 'none' : ''))
                        ->get('tbl_trans_mutasi')->num_rows();

            if($jml > 0){
                redirect(base_url('gudang/'.(!empty($rute) ? $rute : 'data_mutasi.php').'?'.(!empty($tgl_trans) ? 'filter_tgl='.$this->tanggalan->tgl_indo_sys($tgl_trans).'&' : '').'jml='.$jml));
            }else{
                redirect(base_url('gudang/'.(!empty($rute) ? $rute : 'data_mutasi.php').'?msg=Pencarian tidak di temukan!!'));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function set_cari_pemb() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota   = $this->input->post('no_nota');
            $tgl_trans = $this->input->post('tgl');
            $supplier  = $this->input->post('supplier');
            $rute      = $this->input->post('route');
            
            $jml = $this->db
                        ->like('no_nota', $no_nota)
                        ->like('supplier', $supplier)
                        ->get('tbl_trans_beli')->num_rows();

            if($jml > 0){
                redirect(base_url('gudang/trans_beli_list.php?'.(!empty($no_nota) ? 'filter_nota='.$no_nota.'&' : '').(!empty($supplier) ? 'filter_supplier='.$supplier.'&' : '').'jml='.$jml));
            }else{
                redirect(base_url('gudang/trans_beli_list.php?msg=Pencarian tidak di temukan!!'));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function set_cari_opn() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota = $this->input->post('no_nota');
            $tgl     = $this->input->post('tgl');
            $ket     = $this->input->post('ket');
            $rute    = $this->input->post('route');
            
            $jml = $this->db
                        ->like('DATE(tgl_simpan)', $this->tanggalan->tgl_indo_sys($tgl))
                        ->like('keterangan', $ket)
                        ->get('tbl_util_so')->num_rows();

            if($jml > 0){
                redirect(base_url('gudang/data_opname_list.php?'.(!empty($tgl) ? 'filter_tgl='.$this->tanggalan->tgl_indo_sys($tgl).'&' : '').(!empty($ket) ? 'filter_ket='.$ket.'&' : '').'jml='.$jml));
            }else{
                redirect(base_url('gudang/data_opname_list.php?msg=Pencarian tidak di temukan!!'));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function set_cari_stok() {
        if (akses::aksesLogin() == TRUE) {
            $kode = str_replace(' ', '', $this->input->post('kode'));
            $brcd = $this->input->post('barcode');
            $prod = $this->input->post('produk');
            $hpp  = $this->input->post('hpp');
            $hrga = str_replace('.','',$this->input->post('harga'));
            $sa   = $this->input->post('sa');
            $mrk  = $this->input->post('merk');
            $lok  = $this->input->post('kategori');
            $sa   = $this->input->post('status_subt');
            
//            $where = "(tbl_m_produk.kode LIKE '%".$kode."%' OR tbl_m_produk.barcode LIKE '%".$kode."%')";
            $where = "MATCH(tbl_m_produk.produk) AGAINST('".$prod."')";
            
            $jml = $this->db
//                            ->select("id, produk, MATCH(tbl_m_produk.produk) AGAINST('".$prod."')")
                            ->where('status_subt', '1')
                            ->where("(tbl_m_produk.produk LIKE '%".$prod."%' OR tbl_m_produk.produk_alias LIKE '%".$prod."%' OR tbl_m_produk.produk_kand LIKE '%".$prod."%' OR tbl_m_produk.kode LIKE '%".$prod."%')")
                            ->like('id_kategori', $lok, (!empty($lok) ? 'none' : ''))
                            ->like('id_merk', $mrk, (!empty($mrk) ? 'none' : ''))
                            ->like('status_subt', $sa, ($sa !='' ? 'none' : ''))
                            ->get('tbl_m_produk')->num_rows();

            if($jml > 0){
                redirect(base_url('gudang/data_stok_list.php?'.(!empty($kode) ? 'filter_kode='.$kode : '').(!empty($mrk) ? 'filter_merk='.$mrk : '').(!empty($lok) ? 'filter_kategori='.$lok : '').(!empty($brcd) ? 'filter_barcode='.$brcd : '').(!empty($prod) ? '&filter_produk='.$prod : '').(!empty($sa) ? '&filter_stok='.$sa : '').(!empty($hpp) ? '&filter_hpp='.$hpp : '').(!empty($hrga) ? '&filter_harga='.$hrga : '').'&jml='.$jml));
            }else{
                redirect(base_url('gudang/data_stok_list.php?msg=Pencarian tidak di temukan!!'));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function set_cari_stok_tambah() {
        if (akses::aksesLogin() == TRUE) {
            $id = $this->input->post('id_produk');
            $gd = $this->input->post('gudang');
            
            $jml = $this->db
                    ->where('id_produk', general::dekrip($id))
                    ->like('id_gudang', $gd, (!empty($gd) ? 'none' : ''))
                    ->get('tbl_m_produk_hist')->num_rows();

            if($jml > 0){
                redirect(base_url('gudang/data_stok_tambah.php?id='.$id.(!empty($gd) ? '&filter_gd='.$gd : '').'&jml='.$jml));
            }else{
                $this->session->set_flashdata('gd_toast', 'toastr.info("Tidak ada riwayat stok ditemukan")');
                redirect(base_url('gudang/data_stok_tambah.php?id='.$id));
            }
        } else {
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!")');
            redirect();
        }
    }

    public function pdf_mutasi() {
        if (akses::aksesLogin() == TRUE) {
            $id = $this->input->get('id');
            
            if (empty($id)) {
                $this->session->set_flashdata('gd_toast', 'toastr.error("ID mutasi tidak ditemukan");');
                redirect(base_url('gudang/data_mutasi.php'));
            }
            
            // Load data
            $data_mutasi     = $this->db->where('id', general::dekrip($id))->get('tbl_trans_mutasi')->row();
            $data_mutasi_det = $this->db->where('id_mutasi', $data_mutasi->id)->get('tbl_trans_mutasi_det')->result();
            $gudang_asal     = $this->db->where('id', $data_mutasi->id_gd_asal)->get('tbl_m_gudang')->row();
            $gudang_tujuan   = $this->db->where('id', $data_mutasi->id_gd_tujuan)->get('tbl_m_gudang')->row();
            $user            = $this->ion_auth->user($data_mutasi->id_user)->row();
            $setting         = $this->db->get('tbl_pengaturan')->row();
            
            $this->load->library('MedPDF');
            $pdf = new MedPDF('P', 'cm', 'A4');
            $pdf->SetAutoPageBreak('auto', 7);
            $pdf->SetMargins(1, 0.35, 1);
            $pdf->header = 0;
            $pdf->addPage('', '', false);
                        
            // Title
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(19, 1, 'FORM PERMINTAAN STOK', 0, 1, 'C');
            $pdf->Ln(0.5);
            
            // Mutasi Info
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(4, 0.6, 'No. Permintaan', 0, 0);
            $pdf->Cell(0.5, 0.6, ':', 0, 0);
            $pdf->Cell(14.5, 0.6, $data_mutasi->no_nota, 0, 1);
            
            $pdf->Cell(4, 0.6, 'Tanggal', 0, 0);
            $pdf->Cell(0.5, 0.6, ':', 0, 0);
            $pdf->Cell(14.5, 0.6, $this->tanggalan->tgl_indo5($data_mutasi->tgl_simpan), 0, 1);
            
            $pdf->Cell(4, 0.6, 'Keterangan', 0, 0);
            $pdf->Cell(0.5, 0.6, ':', 0, 0);
            $pdf->MultiCell(14.5, 0.6, $data_mutasi->keterangan, 0, 'L');
            
            // Table Header
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(1, 0.8, 'No', 1, 0, 'C');
            $pdf->Cell(3, 0.8, 'Kode', 1, 0, 'C');
            $pdf->Cell(8, 0.8, 'Nama Barang', 1, 0, 'C');
            $pdf->Cell(2, 0.8, 'Jumlah', 1, 0, 'C');
            $pdf->Cell(2, 0.8, 'Satuan', 1, 0, 'C');
            $pdf->Cell(3, 0.8, 'Keterangan', 1, 1, 'C');
            
            // Table Content
            $pdf->SetFont('Arial', '', 10);
            $no = 1;
            foreach ($data_mutasi_det as $item) {
                $produk = $this->db->where('kode', $item->kode)->get('tbl_m_produk')->row();
                $satuan = $this->db->where('id', $produk->id_satuan)->get('tbl_m_satuan')->row();
                
                $pdf->Cell(1, 0.7, $no++, 'LR', 0, 'C');
                $pdf->Cell(3, 0.7, $item->kode, 'LR', 0, 'L');
                $pdf->Cell(8, 0.7, $item->produk, 'LR', 0, 'L');
                $pdf->Cell(2, 0.7, $item->jml, 'LR', 0, 'C');
                $pdf->Cell(2, 0.7, $satuan->satuanBesar, 'LR', 0, 'C');
                $pdf->Cell(3, 0.7, $item->keterangan, 'LR', 1, 'L');
            }
            
            $pdf->Cell(19, 0.6, '', 'T', 0, 'C');
            // Signatures
            $pdf->Ln(1.5);
            $pdf->Cell(6.3, 0.6, 'Dibuat Oleh,', 0, 0, 'C');
            $pdf->Cell(6.3, 0.6, '', 0, 0, 'C');
            $pdf->Cell(6.3, 0.6, 'Diterima Oleh,', 0, 1, 'C');
            
            $pdf->Ln(2);
            
            $pdf->Cell(6.3, 0.6, '('.$this->ion_auth->user($data_mutasi->id_user)->row()->first_name.')', 0, 0, 'C');
            $pdf->Cell(6.3, 0.6, '', 0, 0, 'C');
            $pdf->Cell(6.3, 0.6, '('.$this->ion_auth->user($data_mutasi->id_user_terima)->row()->first_name.')', 0, 1, 'C');
            
            // Output PDF
            $pdf->Output('Mutasi_' . $data_mutasi->no_nota . '.pdf', 'I');
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function json_item() {
        if (akses::aksesLogin() == TRUE) {
            $term  = $this->input->get('term') ?? '';
            $stat  = $this->input->get('status');
            $page  = $this->input->get('page');
                        
            $sql = $this->db->select('tbl_m_produk.id, tbl_m_produk.id_satuan, tbl_m_produk.kode, tbl_m_produk.produk, tbl_m_produk.produk_alias, tbl_m_produk.produk_kand, tbl_m_produk.jml, tbl_m_produk.harga_jual, tbl_m_produk.harga_beli, tbl_m_produk.harga_beli, tbl_m_produk.status_brg_dep')
                            ->where("(tbl_m_produk.produk LIKE '%" . $term . "%' OR tbl_m_produk.produk_alias LIKE '%" . $term . "%' OR tbl_m_produk.produk_kand LIKE '%" . $term . "%' OR tbl_m_produk.kode LIKE '%" . $term . "%' OR tbl_m_produk.barcode LIKE '" . $term . "')")
                            ->where('tbl_m_produk.status_subt', '1')
                            ->where('tbl_m_produk.status_hps', '0')
                            ->order_by('tbl_m_produk.produk', 'asc')
                            ->get('tbl_m_produk')->result();

            $produk = [];
            if(!empty($sql)){
                foreach ($sql as $sql_item) {
                    $sql_satuan = $this->db->where('id', $sql_item->id_satuan)->get('tbl_m_satuan')->row();
                    
                    $produk[] = array(
                        'id'        => general::enkrip($sql_item->id),
                        'kode'      => $sql_item->kode,
                        'name'      => $sql_item->produk,
                        'alias'     => (!empty($sql_item->produk_alias) ? $sql_item->produk_alias : ''),
                        'kandungan' => (!empty($sql_item->produk_kand) ? '(' . strtolower($sql_item->produk_kand) . ')' : ''),
                        'satuan'    => $sql_satuan?->satuanTerkecil ?? '',
                    );
                }
            }
            
            echo json_encode($produk);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
}
