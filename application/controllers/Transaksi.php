<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
/**
 * Description of transaksi
 *
 * @author Mikhael Felian Waskito
 * 
 * modified by :
 *     Mikhael Felian Waskito - mikhaelfelian@gmail.com
 *     2025-03-30
 *     Transaksi controller
 */
class transaksi extends CI_Controller {
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
            $data['sidebar']    = 'admin-lte-3/includes/trans/beli/sidebar_beli';
            /* --- Sidebar Menu --- */
            
            /* Load view tampilan */
            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/trans/index', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    


    public function trans_jual() {
        if (akses::aksesLogin() == TRUE) {
            $setting            = $this->db->get('tbl_pengaturan')->row();
            $id                 = $this->input->get('id');
            $id_produk          = $this->input->get('id_item');
            $id_item            = $this->input->get('id_item');
            $id_po              = $this->input->get('id_po');
            $id_supp            = $this->input->get('id_supplier');
            $status             = $this->input->get('status');
            $dft_pas            = $this->input->get('dft_pas');
            $dft_id             = $this->input->get('dft_id');
            $userid             = $this->ion_auth->user()->row()->id;

            $data['sess_beli']      = $this->session->userdata('trans_beli');
            $data['sql_po']         = $this->db->where('id', general::dekrip($id_po))->get('tbl_trans_beli_po')->row();
            $data['sql_supplier']   = $this->db->where('id', $data['sess_beli']['id_supplier'])->get('tbl_m_supplier')->row();
            
            if(!empty($data['sess_beli'])){                
                $data['sql_beli']       = $this->db->where('id', general::dekrip($id))->get('tbl_trans_beli')->row();
                $data['sql_beli_det']   = $this->db->where('id_pembelian', $data['sql_beli']->id)->get('tbl_trans_beli_det')->result();
                $data['sql_item']       = $this->db->where('id', general::dekrip($id_produk))->get('tbl_m_produk')->row();
                $data['sql_satuan']     = $this->db->get('tbl_m_satuan')->result();
            }
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/trans/jual/sidebar_jual';
            /* --- Sidebar Menu --- */

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/trans/jual/trans_beli', $data);
            $this->load->view('admin-lte-3/5_footer',$data);
            $this->load->view('admin-lte-3/6_bawah',$data);
        } else {
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
                $jml_hal = $this->db->select('tbl_trans_beli.id, tbl_trans_beli.no_nota, tbl_trans_beli.no_po, DATE(tbl_trans_beli.tgl_masuk) as tgl_masuk, DATE(tbl_trans_beli.tgl_bayar) as tgl_bayar, DATE(tbl_trans_beli.tgl_keluar) as tgl_keluar, tbl_trans_beli.jml_total, tbl_trans_beli.jml_retur, tbl_trans_beli.jml_subtotal, tbl_trans_beli.jml_gtotal, tbl_trans_beli.id_user, tbl_trans_beli.id_supplier, tbl_trans_beli.status_nota, tbl_trans_beli.status_bayar')
                                ->join('tbl_m_supplier', 'tbl_m_supplier.id=tbl_trans_beli.id_supplier')
                                ->where('tbl_trans_beli.status_hps', '0')
                                ->like('tbl_m_supplier.nama', $sl)
                                ->like('tbl_trans_beli.no_nota', $nt)
                                ->like('DATE(tbl_trans_beli.tgl_keluar)', $tp)
                                ->order_by('tbl_trans_beli.id','desc')
                                ->get('tbl_trans_beli')->num_rows();
            }            

            /* -- Form Error -- */
            $data['hasError']                = $this->session->flashdata('form_error');
            
            // Config Pagination
            $config['base_url']              = base_url('transaksi/beli/index.php?'.(!empty($sl) ? 'filter_supplier='.$sl.'&' : '').(!empty($tgl) ? '&tgl='.$tgl : '').(!empty($tgl_awal) ? '&tgl_awal='.$tgl_awal : '').(!empty($tgl_akhir) ? '&tgl_akhir='.$tgl_akhir : '').(!empty($jml) ? '&jml='.$jml : ''));
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
                   $data['sql_beli'] = $this->db->select('tbl_trans_beli.id, tbl_trans_beli.no_po, tbl_trans_beli.no_nota, DATE(tbl_trans_beli.tgl_masuk) as tgl_masuk, DATE(tbl_trans_beli.tgl_bayar) as tgl_bayar, DATE(tbl_trans_beli.tgl_keluar) as tgl_keluar, tbl_trans_beli.jml_total, tbl_trans_beli.jml_retur, tbl_trans_beli.jml_subtotal, tbl_trans_beli.jml_gtotal, tbl_trans_beli.id_user, tbl_trans_beli.id_supplier, tbl_trans_beli.status_nota, tbl_trans_beli.status_bayar, tbl_m_supplier.nama, tbl_m_supplier.npwp, tbl_m_supplier.alamat, tbl_m_supplier.no_tlp, tbl_m_supplier.cp')
                           ->join('tbl_m_supplier', 'tbl_m_supplier.id=tbl_trans_beli.id_supplier')
                           ->where('tbl_trans_beli.status_hps', '0')
                           ->like('tbl_m_supplier.nama', $sl)
                           ->like('tbl_trans_beli.no_nota', $nt)
                           ->limit($config['per_page'],$hal)
                           ->order_by('tbl_trans_beli.tgl_masuk','desc')
                           ->get('tbl_trans_beli')->result();
            }else{
                   $data['sql_beli'] = $this->db->select('tbl_trans_beli.id, tbl_trans_beli.no_po, tbl_trans_beli.no_nota, DATE(tbl_trans_beli.tgl_masuk) as tgl_masuk, DATE(tbl_trans_beli.tgl_bayar) as tgl_bayar, DATE(tbl_trans_beli.tgl_keluar) as tgl_keluar, tbl_trans_beli.jml_total, tbl_trans_beli.jml_retur, tbl_trans_beli.jml_subtotal, tbl_trans_beli.jml_gtotal, tbl_trans_beli.id_user, tbl_trans_beli.id_supplier, tbl_trans_beli.status_nota, tbl_trans_beli.status_bayar, tbl_m_supplier.nama, tbl_m_supplier.npwp, tbl_m_supplier.alamat, tbl_m_supplier.no_tlp, tbl_m_supplier.cp')
                           ->join('tbl_m_supplier', 'tbl_m_supplier.id=tbl_trans_beli.id_supplier')
                           ->where('tbl_trans_beli.status_hps', '0')
                           ->like('tbl_m_supplier.nama', $sl)
                           ->like('tbl_trans_beli.no_nota', $nt)
                           ->like('DATE(tbl_trans_beli.tgl_keluar)', $tp)
                           ->limit($config['per_page'])                           
                           ->order_by('tbl_trans_beli.tgl_masuk','desc')
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
            $data['sidebar']    = 'admin-lte-3/includes/trans/beli/sidebar_beli';
            /* --- Sidebar Menu --- */
            
            /* Load view tampilan */
            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/trans/beli/index', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        }else{
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function trans_beli_po_list() {
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
            $case    = $this->input->get('case') ?? '';

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
                $jml_hal = $this->db->select('tbl_trans_beli_po.id, tbl_trans_beli_po.id_supplier, tbl_trans_beli_po.no_nota, DATE(tbl_trans_beli_po.tgl_masuk) as tgl_masuk, DATE(tbl_trans_beli_po.tgl_bayar) as tgl_bayar, DATE(tbl_trans_beli_po.tgl_keluar) as tgl_keluar, tbl_trans_beli_po.keterangan, tbl_trans_beli_po.pengiriman, tbl_m_supplier.nama, tbl_m_supplier.npwp, tbl_m_supplier.alamat, tbl_m_supplier.no_tlp, tbl_m_supplier.cp')
                           ->join('tbl_m_supplier', 'tbl_m_supplier.id=tbl_trans_beli_po.id_supplier')
                           ->like('tbl_m_supplier.nama', $sl)
                           ->order_by('tbl_trans_beli_po.id','desc')
                           ->get('tbl_trans_beli_po')->num_rows();
            }            

            /* -- Form Error -- */
            $data['hasError'] = $this->session->flashdata('form_error');
            
            // Config Pagination for AdminLTE 3
            $config['base_url']              = base_url('transaksi/beli/trans_beli_po_list.php?case='.$case.(!empty($tgl) ? '&tgl='.$tgl : '').(!empty($tgl_awal) ? '&tgl_awal='.$tgl_awal : '').(!empty($tgl_akhir) ? '&tgl_akhir='.$tgl_akhir : '').(!empty($jml) ? '&jml='.$jml : ''));
            $config['total_rows']            = $jml_hal;
            $config['query_string_segment']  = 'halaman';
            $config['page_query_string']     = TRUE;
            $config['per_page']              = $pengaturan->jml_item;
            $config['num_links']             = 3;
            
            // AdminLTE 3 pagination styling
            $config['full_tag_open']         = '<ul class="pagination pagination-sm m-0 float-right">';
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
            $config['first_link']            = '<i class="fas fa-angle-double-left"></i>';
            $config['prev_link']             = '<i class="fas fa-angle-left"></i>';
            $config['next_link']             = '<i class="fas fa-angle-right"></i>';
            $config['last_link']             = '<i class="fas fa-angle-double-right"></i>';
            $config['attributes']            = array('class' => 'page-link');
            
            if(!empty($hal)){
                   $data['sql_beli'] = $this->db->select('tbl_trans_beli_po.id, tbl_trans_beli_po.id_supplier, tbl_trans_beli_po.no_nota, DATE(tbl_trans_beli_po.tgl_masuk) as tgl_masuk, DATE(tbl_trans_beli_po.tgl_bayar) as tgl_bayar, DATE(tbl_trans_beli_po.tgl_keluar) as tgl_keluar, tbl_trans_beli_po.keterangan, tbl_trans_beli_po.pengiriman, tbl_m_supplier.nama, tbl_m_supplier.npwp, tbl_m_supplier.alamat, tbl_m_supplier.no_tlp, tbl_m_supplier.cp')
                           ->join('tbl_m_supplier', 'tbl_m_supplier.id=tbl_trans_beli_po.id_supplier')
                           ->like('tbl_m_supplier.nama', $sl)  
                           ->limit($config['per_page'],$hal)
                           ->order_by('tbl_trans_beli_po.id','desc')
                           ->get('tbl_trans_beli_po')->result();
            }else{
                   $data['sql_beli'] = $this->db->select('tbl_trans_beli_po.id, tbl_trans_beli_po.id_supplier, tbl_trans_beli_po.no_nota, DATE(tbl_trans_beli_po.tgl_masuk) as tgl_masuk, DATE(tbl_trans_beli_po.tgl_bayar) as tgl_bayar, DATE(tbl_trans_beli_po.tgl_keluar) as tgl_keluar, tbl_trans_beli_po.keterangan, tbl_trans_beli_po.pengiriman, tbl_m_supplier.nama, tbl_m_supplier.npwp, tbl_m_supplier.alamat, tbl_m_supplier.no_tlp, tbl_m_supplier.cp')
                           ->join('tbl_m_supplier', 'tbl_m_supplier.id=tbl_trans_beli_po.id_supplier')
                           ->like('tbl_m_supplier.nama', $sl)
                           ->limit($config['per_page'])
                           ->order_by('tbl_trans_beli_po.id','desc')
                           ->get('tbl_trans_beli_po')->result();
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
            $data['sidebar']    = 'admin-lte-3/includes/trans/beli/sidebar_beli';
            /* --- Sidebar Menu --- */
            
            /* Load view tampilan */
            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/trans/beli/trans_beli_po_list', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        }else{
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function trans_beli() {
        if (akses::aksesLogin() == TRUE) {
            $setting            = $this->db->get('tbl_pengaturan')->row();
            $id                 = $this->input->get('id');
            $id_produk          = $this->input->get('id_item');
            $id_item            = $this->input->get('id_item');
            $id_po              = $this->input->get('id_po');
            $id_supp            = $this->input->get('id_supplier');
            $status             = $this->input->get('status');
            $dft_pas            = $this->input->get('dft_pas');
            $dft_id             = $this->input->get('dft_id');
            $rowid              = $this->input->get('rowid');
            $userid             = $this->ion_auth->user()->row()->id;

            $data['sess_beli']      = $this->session->userdata('trans_beli');
            $data['sql_po']         = $this->db->where('id', general::dekrip($id_po))->get('tbl_trans_beli_po')->row();
            $supp_id                = (!empty($data['sess_beli']['id_supplier']) ? $data['sess_beli']['id_supplier'] : $data['sql_po']->id_supplier);
            $data['sql_supplier']   = $this->db->where('id', $supp_id)->get('tbl_m_supplier')->row();
            
            if(!empty($data['sess_beli'])){                
                $data['sql_beli']       = $this->db->where('id', general::dekrip($id))->get('tbl_trans_beli')->row();
                $data['sql_beli_det']   = $this->db->where('id_pembelian', $data['sql_beli']->id)->get('tbl_trans_beli_det')->result();
                $data['sql_beli_det_rw']= $this->db->where('id', general::dekrip($rowid))->get('tbl_trans_beli_det')->row();
                $data['sql_item']       = $this->db->where('id', general::dekrip($id_produk))->get('tbl_m_produk')->row();
                $data['sql_satuan']     = $this->db->get('tbl_m_satuan')->result();
            }
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/trans/beli/sidebar_beli';
            /* --- Sidebar Menu --- */

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/trans/beli/trans_beli', $data);
            $this->load->view('admin-lte-3/5_footer',$data);
            $this->load->view('admin-lte-3/6_bawah',$data);
        } else {
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function trans_beli_edit() {
        if (akses::aksesLogin() == TRUE) {
            $setting  = $this->db->get('tbl_pengaturan')->row();
            $id       = $this->input->get('id');
            $id_item  = $this->input->get('id_item');
            $rowid    = $this->input->get('rowid');
            $userid   = $this->ion_auth->user()->row()->id;
            
            if(!empty($id)){
                $data['sess_beli']      = $this->session->userdata('trans_beli_edit');
                $data['sql_beli']       = $this->db->where('id', general::dekrip($id))->get('tbl_trans_beli')->row();
                $data['sql_beli_det']   = $this->db->where('id_pembelian', $data['sql_beli']->id)->get('tbl_trans_beli_det')->result();
                $data['sql_beli_det_rw']= $this->db->where('id', general::dekrip($rowid))->get('tbl_trans_beli_det')->row();
                $data['sql_supplier']   = $this->db->where('id', $data['sql_beli']->id_supplier)->get('tbl_m_supplier')->row();
                $data['sql_item']       = $this->db->where('id', general::dekrip($id_item))->get('tbl_m_produk')->row();
                $data['sql_satuan']     = $this->db->get('tbl_m_satuan')->result();
            }
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/trans/beli/sidebar_beli';
            /* --- Sidebar Menu --- */

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/trans/beli/trans_beli_edit', $data);
            $this->load->view('admin-lte-3/5_footer',$data);
            $this->load->view('admin-lte-3/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function trans_beli_det() {
        if (akses::aksesLogin() == TRUE) {
            $setting  = $this->db->get('tbl_pengaturan')->row();
            $id       = $this->input->get('id');
            $id_produk = $this->input->get('id_produk'); // Added missing variable
            $userid   = $this->ion_auth->user()->row()->id;
            
            $data = []; // Initialize data array
            
            if(!empty($id)){
                $data['sql_beli']       = $this->db->where('id', general::dekrip($id))->get('tbl_trans_beli')->row();
                $data['sql_beli_det']   = $this->db->where('id_pembelian', general::dekrip($id))->get('tbl_trans_beli_det')->result();
                $data['sql_supplier']   = $this->db->where('id', $data['sql_beli']->id_supplier)->get('tbl_m_supplier')->row();
                
                if(!empty($id_produk)) {
                    $data['sql_item'] = $this->db->where('id', general::dekrip($id_produk))->get('tbl_m_produk')->row();
                }
                
                $data['sql_satuan']     = $this->db->get('tbl_m_satuan')->result();
            }
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/trans/beli/sidebar_beli';
            /* --- Sidebar Menu --- */

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/trans/beli/trans_beli_det', $data);
            $this->load->view('admin-lte-3/5_footer', $data);
            $this->load->view('admin-lte-3/6_bawah', $data);
        } else {
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function trans_beli_po() {
        if (akses::aksesLogin() == TRUE) {
            $setting                = $this->db->get('tbl_pengaturan')->row();
            $id                     = $this->input->get('id');
            $id_produk              = $this->input->get('id_item');
            $id_item                = $this->input->get('id_item');
            $status                 = $this->input->get('status');
            $userid                 = $this->ion_auth->user()->row()->id;

            $data['sess_beli']   = $this->session->userdata('trans_beli_po');
            
            if(!empty($data['sess_beli'])){
                $data['sql_beli']       = $this->db->where('id', general::dekrip($id))->get('tbl_trans_beli_po')->row();
                $data['sql_beli_det']   = $this->db->where('id_pembelian', $data['sql_beli']->id)->get('tbl_trans_beli_po_det')->result();
                $data['sql_supplier']   = $this->db->where('id', $data['sess_beli']['id_supplier'])->get('tbl_m_supplier')->row();
                $data['sql_item']       = $this->db->where('id', general::dekrip($id_produk))->get('tbl_m_produk')->row();
                $data['sql_satuan']     = $this->db->get('tbl_m_satuan')->result();
            }
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/trans/beli/sidebar_beli';
            /* --- Sidebar Menu --- */

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/trans/beli/trans_beli_po', $data);
            $this->load->view('admin-lte-3/5_footer',$data);
            $this->load->view('admin-lte-3/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function trans_beli_po_edit() {
        if (akses::aksesLogin() == TRUE) {
            $setting                = $this->db->get('tbl_pengaturan')->row();
            $id                     = $this->input->get('id');
            $id_produk              = $this->input->get('id_item');
            $id_resep               = $this->input->get('id_resep');
            $id_lab                 = $this->input->get('id_lab');
            $id_item                = $this->input->get('id_item');
            $status                 = $this->input->get('status');
            $dft_pas                = $this->input->get('dft_pas');
            $dft_id                 = $this->input->get('dft_id');
            $userid                 = $this->ion_auth->user()->row()->id;
            
            if(!empty($id)){
                $data['sql']            = $this->db->where('id', general::dekrip($id))->get('tbl_trans_beli_po')->row();
                $data['sql_det']        = $this->db->where('id_pembelian', $data['sql']->id)->get('tbl_trans_beli_po_det')->result();
                $data['sql_supplier']   = $this->db->where('id', $data['sql']->id_supplier)->get('tbl_m_supplier')->row();
                $data['sql_item']       = $this->db->where('id', general::dekrip($id_produk))->get('tbl_m_produk')->row();
                $data['sql_satuan']     = $this->db->get('tbl_m_satuan')->result();
                
                $data['sess_beli']      = $this->session->userdata('trans_beli_po_edit');
            }
            
//            echo '<pre>';
//            print_r($data['sql']);
//            echo '<pre>';
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/trans/beli/sidebar_beli';
            /* --- Sidebar Menu --- */

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/trans/beli/trans_beli_po_edit', $data);
            $this->load->view('admin-lte-3/5_footer',$data);
            $this->load->view('admin-lte-3/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function trans_beli_po_hapus() {
        if (akses::aksesLogin() == TRUE) {
            $id                   = $this->input->get('id');
            $userid               = $this->ion_auth->user()->row()->id;
            
            $sql_medc = $this->db->where('id', general::dekrip($id))->get('tbl_trans_beli_po');
            
            if($sql_medc->num_rows() > 0){
                $this->session->set_flashdata('medcheck', '<div class="alert alert-success">Transaksi berhasil dihapus</div>');
                crud::delete('tbl_trans_beli_po', 'id', general::dekrip($id));
            }
            
            redirect(base_url('transaksi/beli/trans_beli_po_list.php'));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function trans_beli_po_det() {
        if (akses::aksesLogin() == TRUE) {
            $setting                = $this->db->get('tbl_pengaturan')->row();
            $id                     = $this->input->get('id');
            $id_produk              = $this->input->get('id_item');
            $id_resep               = $this->input->get('id_resep');
            $id_lab                 = $this->input->get('id_lab');
            $id_item                = $this->input->get('id_item');
            $status                 = $this->input->get('status');
            $dft_pas                = $this->input->get('dft_pas');
            $dft_id                 = $this->input->get('dft_id');
            $userid                 = $this->ion_auth->user()->row()->id;
            
            if(!empty($id)){
                $data['sql_beli']       = $this->db->where('id', general::dekrip($id))->get('tbl_trans_beli_po')->row();
                $data['sql_beli_det']   = $this->db->where('id_pembelian', $data['sql_beli']->id)->get('tbl_trans_beli_po_det')->result();
                $data['sql_supplier']   = $this->db->where('id', $data['sql_beli']->id_supplier)->get('tbl_m_supplier')->row();
                $data['sql_item']       = $this->db->where('id', general::dekrip($id_produk))->get('tbl_m_produk')->row();
                $data['sql_satuan']     = $this->db->get('tbl_m_satuan')->result();
                
                $data['sess_beli']      = $this->session->userdata('trans_beli_po_edit');
            }
            
//            echo '<pre>';
//            print_r($data['sql']);
//            echo '<pre>';
            
            /* Sidebar Menu */
            $data['sidebar']    = 'admin-lte-3/includes/trans/beli/sidebar_beli';
            /* --- Sidebar Menu --- */

            $this->load->view('admin-lte-3/1_atas', $data);
            $this->load->view('admin-lte-3/2_header', $data);
            $this->load->view('admin-lte-3/3_navbar', $data);
            $this->load->view('admin-lte-3/includes/trans/beli/trans_beli_po_det', $data);
            $this->load->view('admin-lte-3/5_footer',$data);
            $this->load->view('admin-lte-3/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function trans_beli_print_ex_po() {
        if (akses::aksesLogin() == TRUE) {
            $setting    = $this->db->get('tbl_pengaturan')->row();
            $id         = $this->input->get('id');
            $aid        = general::dekrip($id);
            $sql        = $this->db->select('DATE(tgl_simpan) as tgl_simpan, no_nota, id_supplier, id_user, keterangan, pengiriman')->where('tbl_trans_beli_po.id', $aid)->get('tbl_trans_beli_po')->row();
            $sql_det    = $this->db->select('tbl_trans_beli_po_det.id, tbl_trans_beli_po_det.kode, tbl_trans_beli_po_det.produk, tbl_trans_beli_po_det.jml, tbl_trans_beli_po_det.satuan, tbl_trans_beli_po_det.keterangan_itm, tbl_m_satuan.satuanTerkecil as sk, tbl_m_satuan.satuanBesar as sb')->join('tbl_m_satuan', 'tbl_m_satuan.id=tbl_trans_beli_po_det.id_satuan')->where('tbl_trans_beli_po_det.id_pembelian', $aid)->get('tbl_trans_beli_po_det');
            $member     = $this->db->where('id', $sql->id_supplier)->get('tbl_m_supplier')->row();
            $sales      = $this->db->where('id', $sql->id_sales)->get('tbl_m_sales')->row();
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $objPHPExcel = new PHPExcel();

            // Font size nota
            $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getFont()->setSize('13')->setName('Times New Roman');
            $objPHPExcel->getActiveSheet()->getStyle('F1:H1')->getFont()->setSize('11')->setName('Times New Roman');
            $objPHPExcel->getActiveSheet()->getStyle('A2:H2')->getFont()->setSize('11')->setName('Times New Roman');
            $objPHPExcel->getActiveSheet()->getStyle('A3:H3')->getFont()->setSize('11')->setName('Times New Roman');
            $objPHPExcel->getActiveSheet()->getStyle('A4:H4')->getFont()->setSize('11')->setName('Times New Roman');
            $objPHPExcel->getActiveSheet()->getStyle('A5:H5')->getFont()->setSize('11')->setName('Times New Roman');
            $objPHPExcel->getActiveSheet()->getStyle('A6:H6')->getFont()->setSize('11')->setName('Times New Roman');
            $objPHPExcel->getActiveSheet()->getStyle('A7:H7')->getFont()->setSize('11')->setName('Times New Roman')->setBold(TRUE);
           // border atas, nama kolom
            $objPHPExcel->getActiveSheet()->getStyle('A7:H7')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);

            /* CONTENT EXCEL */
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', strtoupper($pengaturan->judul))->mergeCells('A1:E1')
                    ->setCellValue('F1', ucwords(strtolower($pengaturan->kota)).', '.$this->tanggalan->tgl_indo($sql->tgl_simpan));
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A2', strtoupper($pengaturan->alamat))
                    ->setCellValue('F2', 'Kepada Yth : ');
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A3', strtoupper($pengaturan->kota))->mergeCells('A2:E2')
                    ->setCellValue('F3', strtoupper($member->nama));
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('F4', strtoupper($member->alamat));
//            $objPHPExcel->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//            $objPHPExcel->setActiveSheetIndex(0)
//                    ->setCellValue('D5', strtoupper($sales->kode))->mergeCells('D5:E5')
//                    ->setCellValue('F5', strtoupper($member->lokasi));

            $objPHPExcel->getActiveSheet()->getStyle('A5:D5')->getFont()->setBold(TRUE);
            $objPHPExcel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A5', 'PURCHASE ORDER')->mergeCells('A5:E5');

            $objPHPExcel->getActiveSheet()->getStyle('A6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A6', 'No. PO : '.$sql->no_nota)->mergeCells('A6:E6');

            // Header Tabel Nota
            $objPHPExcel->getActiveSheet()->getStyle('A7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('B7:C7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('D7:E7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle('F7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle('G7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A7', 'No.')
                    ->setCellValue('B7', 'Banyaknya')->mergeCells('B7:C7')
                    ->setCellValue('D7', 'Nama Barang')->mergeCells('D7:E7')
                    ->setCellValue('F7', 'Kode')
                    ->setCellValue('G7', 'Keterangan')->mergeCells('G7:H7');

            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(5);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(6);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(28);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(14);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(13);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(13);

            // Detail barang
            $no    = 1;
            $cell  = 8;
            $cel   = 8;
            foreach ($sql_det->result() as $items){
                // Format Angka
                $objPHPExcel->getActiveSheet()->getStyle('G' . $cell.':H'.$cell)->getNumberFormat()->setFormatCode("#.##0");

                // Format Alignment
                $objPHPExcel->getActiveSheet()->getStyle('A'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('B'.$cell.':C'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $objPHPExcel->getActiveSheet()->getStyle('D'.$cell.':E'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objPHPExcel->getActiveSheet()->getStyle('F'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objPHPExcel->getActiveSheet()->getStyle('G'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $objPHPExcel->getActiveSheet()->getStyle('G'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A'.$cell, $no)
                            ->setCellValue('B'.$cell, $items->jml)
                            ->setCellValue('C'.$cell, $items->satuan)
                            ->setCellValue('D'.$cell, $items->produk)->mergeCells('D'.$cell.':E'.$cell)
                            ->setCellValue('F'.$cell, $items->kode)
                            ->setCellValue('G'.$cell, $items->keterangan_itm)->mergeCells('G'.$cell.':H'.$cell);

                $no++;
                $cell++;
            }
//
            // Maximal baris
            if($sql_det->num_rows() > 46){
               $sell = $cell;
            }else{
                $jmlbaris = 39 - (int) $no;

                // Baris kosong space nota
                for ($i = 0; $i <= $jmlbaris; $i++) {
                $sell = $cell + $i;

                    $objPHPExcel->setActiveSheetIndex(0)
                           ->setCellValue('A' . $sell, '')
                           ->setCellValue('B' . $sell, '')
                           ->setCellValue('C' . $sell, '')
                           ->setCellValue('D' . $sell, '')
                          ->setCellValue('E' . $sell, '');
                }
            }
//            // Font Nota Detail
            $objPHPExcel->getActiveSheet()->getStyle('A8:H'.$cell)->getFont()->setSize('10')->setName('Times New Roman');



            // Hitung sell bawah
            $sell2    = $sell + 1;
            $sellbwh1 = $sell2 + 1;
            $sellbwh2 = $sellbwh1 + 1;
            $sellbwh3 = $sellbwh2 + 1;
            $sellbwh4 = $sellbwh3 + 1;

            // border bawah
            $objPHPExcel->getActiveSheet()->getStyle('A'.$sell2.':H'.$sell2)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);

            // Subtotal, ppn, grand total
            $objPHPExcel->getActiveSheet()->getStyle('A'.$sell2.':F'.$sell2)->getFont()->setSize('11')->setName('Times New Roman');
            $objPHPExcel->getActiveSheet()->getStyle('A'.$sell2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle('H' . $sell2)->getNumberFormat()->setFormatCode("#.##0");
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $sell2, $sql->keterangan)->mergeCells('A' . $sell2.':H' . $sell2);

            $objPHPExcel->getActiveSheet()->getStyle('A'.$sellbwh1.':F'.$sellbwh1)->getFont()->setSize('11')->setName('Times New Roman');
            $objPHPExcel->getActiveSheet()->getStyle('A'.$sellbwh1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle('H' . $sellbwh1)->getNumberFormat()->setFormatCode("#.##0");
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $sellbwh1, $sql->pengiriman)->mergeCells('A' . $sellbwh1.':H' . $sellbwh1);

            // border penutup
            $objPHPExcel->getActiveSheet()->getStyle('A'.$sellbwh3)->getFont()->setSize('10')->setName('Times New Roman');
            $objPHPExcel->getActiveSheet()->getStyle('A'.$sellbwh3.':H'.$sellbwh3)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUMDASHED);
            /* END CONTENT EXCEL -- */

            // Rename worksheet
            $objPHPExcel->getActiveSheet()->setTitle('Purchase Order');

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
//                    ->setTitle("Nota Penbelian " . $sql->row()->no_nota . ($sql->row()->cetak == '1' ? ' Copy Customer' : ''))
                    ->setSubject("Aplikasi Bengkel POS")
                    ->setDescription("Kunjungi http://mikhaelfelian.web.id")
                    ->setKeywords("POS")
                    ->setCategory("Untuk mencetak nota dot matrix");



            // Redirect output to a client’s web browser (Excel5)
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.strtolower($sql->no_nota).'.xls"');

            // If you're serving to IE over SSL, then the following may be needed
            header('Expires: Mon, 15 Feb 1992 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0

            ob_clean();
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            exit;
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function pdf_trans_beli() {
        if (akses::aksesLogin() == TRUE) {
            $setting            = $this->db->get('tbl_pengaturan')->row();
            $id                 = $this->input->get('id');
            
            $sql_beli           = $this->db->where('id', general::dekrip($id))->get('tbl_trans_beli')->row();
            $sql_beli_det       = $this->db->where('id_pembelian', general::dekrip($id))->get('tbl_trans_beli_det')->result();
            $sql_supplier       = $this->db->where('id', $sql_beli->id_supplier)->get('tbl_m_supplier')->row();
            $oleh               = $this->ion_auth->user($sql_beli->id_user)->row()->first_name;
            
            $gambar1            = base_url('assets/theme/admin-lte-3/dist/img/logo-esensia-2.png');
            $gambar2            = base_url('assets/theme/admin-lte-3/dist/img/logo-bw-bg2-1440px.png');
            $gambar3            = base_url('assets/theme/admin-lte-3/dist/img/logo-footer.png');

            $this->load->library('MedBeliPDF');
            $pdf = new MedBeliPDF('P', 'cm', [21.5, 33]);
            // Use public property or setter method instead of direct property access
            $pdf->setJudul('FAKTUR BELI');
            $pdf->SetAutoPageBreak(true, 8.5);            
            $pdf->addPage('', '', false);
            
            # Gambar Watermark Tengah
            if (file_exists(str_replace(base_url(), FCPATH, $gambar2))) {
                $pdf->Image($gambar2, 5, 4, 15, 19);
            }
            
            # Line Cell
            $fill = false;
            $pdf->Cell(19, 0.5, '', 'T', 0, 'L', $fill);
            $pdf->Ln();
            
            # Blok Judul
            $pdf->SetFont('Arial', 'B', '9');
            $pdf->Cell(1, 0.5, 'APA', '0', 0, 'L', $fill);
            $pdf->Cell(0.5, 0.5, ':', '0', 0, 'C', $fill);
            $pdf->SetFont('Arial', '', '9');
            $pdf->Cell(17.5, 0.5, $setting->apt_apa, 0, 1, 'L');
            $pdf->Ln(0);
            $pdf->SetFont('Arial', 'B', '9');
            $pdf->Cell(1, 0.5, 'SIPA', '', 0, 'L', $fill);
            $pdf->Cell(0.5, 0.5, ':', '', 0, 'C', $fill);
            $pdf->SetFont('Arial', '', '9');
            $pdf->Cell(17.5, 0.5, $setting->apt_sipa, '', 1, 'L', $fill);
            $pdf->Ln();
            
            # DATA PEMBELIAN
            $pdf->SetFont('Arial', '', '9');
            $pdf->Cell(2.5, 0.5, 'Supplier', '0', 0, 'L', $fill);
            $pdf->Cell(0.5, 0.5, ':', '0', 0, 'C', $fill);
            $pdf->Cell(8.5, 0.5, strtoupper($sql_supplier->nama), '0', 0, 'L', $fill);
            $pdf->Cell(1.5, 0.5, 'No. Faktur', '0', 0, 'L', $fill);
            $pdf->Cell(0.5, 0.5, ':', '0', 0, 'C', $fill);
            $pdf->Cell(5, 0.5, $sql_beli->no_nota, '0', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->Cell(2.5, 0.5, 'NPWP', '0', 0, 'L', $fill);
            $pdf->Cell(0.5, 0.5, ':', '0', 0, 'C', $fill);
            $pdf->Cell(8.5, 0.5, (!empty($sql_supplier->npwp) ? $sql_supplier->npwp : '-'), '0', 0, 'L', $fill);
            $pdf->Cell(1.5, 0.5, 'No. PO', '0', 0, 'L', $fill);
            $pdf->Cell(0.5, 0.5, ':', '0', 0, 'C', $fill);
            $pdf->Cell(5, 0.5, $sql_beli->no_po, '0', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->Cell(2.5, 0.5, 'Kode Supplier', '0', 0, 'L', $fill);
            $pdf->Cell(0.5, 0.5, ':', '0', 0, 'C', $fill);
            $pdf->Cell(8.5, 0.5, $sql_supplier->kode, '0', 0, 'L', $fill);
            $pdf->Cell(1.5, 0.5, 'Tgl', '0', 0, 'L', $fill);
            $pdf->Cell(0.5, 0.5, ':', '0', 0, 'C', $fill);
            $pdf->Cell(5, 0.5, $this->tanggalan->tgl_indo2($sql_beli->tgl_masuk).' / '.$this->tanggalan->tgl_indo2($sql_beli->tgl_keluar), '0', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->Cell(2.5, 0.5, 'Alamat', '0', 0, 'L', $fill);
            $pdf->Cell(0.5, 0.5, ':', '0', 0, 'C', $fill);
            $pdf->MultiCell(15.5, 0.5, $sql_supplier->alamat, '0', 'L');
            $pdf->Ln();            
            
                        
            $fill = false;
            $pdf->SetTextColor(5, 148, 19);
            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Cell(7, 1, 'DESKRIPSI', 'TB', 0, 'L', $fill);
            $pdf->Cell(1, 1, 'JML', 'TB', 0, 'C', $fill);
            $pdf->Cell(3, 1, 'HARGA', 'TB', 0, 'R', $fill);
            $pdf->Cell(2, 1, 'DISK (%)', 'TB', 0, 'R', $fill);
            $pdf->Cell(3, 1, 'POTONGAN', 'TB', 0, 'R', $fill);
            $pdf->Cell(3, 1, 'SUBTOTAL', 'TB', 0, 'R', $fill);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Ln();
            
            $fill = false;
            $no = 1; 
            $gtotal = 0;
            foreach ($sql_beli_det as $det) {
                
                $pdf->SetFont('Arial', '', '10');
                $pdf->Cell(7, 0.5, $det->produk, '', 0, '', $fill);
                $pdf->Cell(1, 0.5, (float) $det->jml, '', 0, 'C', $fill);
                $pdf->Cell(3, 0.5, general::format_angka($det->harga), '', 0, 'R', $fill);
                $pdf->Cell(2, 0.5, ($det->disk1 != 0 ? (float) $det->disk1 : '') . ($det->disk2 != 0 ? ' + ' . (float) $det->disk2 : '') . ($det->disk3 != 0 ? ' + ' . (float) $det->disk3 : ''), '', 0, 'C', $fill);
                $pdf->Cell(3, 0.5, general::format_angka($det->potongan), '', 0, 'R', $fill);
                $pdf->Cell(3, 0.5, general::format_angka($det->subtotal), '', 0, 'R', $fill);
                $pdf->Ln();
                
                $gtotal = $gtotal + $det->subtotal;
                $no++;
            }
            
            $jml_total      = $gtotal;
            $jml_diskon     = $jml_total - ($jml_total - $sql_beli->jml_diskon);
            $diskon         = ($jml_diskon / $jml_total) * 100; 
            
            // Kolom Total
            $pdf->SetTextColor(5, 148, 19);
            $pdf->SetFont('Arial', 'B', '10');
            $pdf->Cell(16, 0.5, 'TOTAL', 'T', 0, 'R', $fill);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(3, 0.5, general::format_angka($jml_total), 'T', 0, 'R', $fill);
            $pdf->Ln();
            $pdf->SetTextColor(5, 148, 19);
            $pdf->Cell(16, 0.5, 'DISKON '.(!empty($diskon) ? $diskon.'%' : ''), '', 0, 'R', $fill);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(3, 0.5, '('.general::format_angka($jml_diskon).')', '', 0, 'R', $fill);
            $pdf->Ln();
            $pdf->Cell(13, 0.5, '', '', 0, 'R', $fill);
            $pdf->SetTextColor(5, 148, 19);
            $pdf->Cell(3, 0.5, 'SUBTOTAL', 'T', 0, 'R', $fill);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(3, 0.5, general::format_angka($sql_beli->jml_subtotal), 'T', 0, 'R', $fill);
            $pdf->Ln();
            $pdf->Cell(13, 0.5, '', '', 0, 'R', $fill);
            $pdf->SetTextColor(5, 148, 19);
            $pdf->Cell(3, 0.5, 'DPP', '', 0, 'R', $fill);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(3, 0.5, general::format_angka($sql_beli->jml_dpp), '', 0, 'R', $fill);
            $pdf->Ln();
            $pdf->Cell(13, 0.5, '', '', 0, 'R', $fill);
            $pdf->SetTextColor(5, 148, 19);
            $pdf->Cell(3, 0.5, 'PPN ('.(float) $sql_beli->ppn.'%)', '', 0, 'R', $fill);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(3, 0.5, general::format_angka($sql_beli->jml_ppn), '', 0, 'R', $fill);
            $pdf->Ln();
            $pdf->Cell(13, 0.5, '', '', 0, 'R', $fill);
            $pdf->SetTextColor(5, 148, 19);
            $pdf->Cell(3, 0.5, 'ONGKIR', 'T', 0, 'R', $fill);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(3, 0.5, general::format_angka($sql_beli->jml_ongkir), 'T', 0, 'R', $fill);
            $pdf->Ln();
            $pdf->Cell(13, 0.5, '', '', 0, 'R', $fill);
            $pdf->SetTextColor(5, 148, 19);
            $pdf->Cell(3, 0.5, 'GRAND TOTAL', '', 0, 'R', $fill);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(3, 0.5, general::format_angka($sql_beli->jml_gtotal), '', 0, 'R', $fill);
            $pdf->Ln(1);

            // Gambar VALIDASI
            $getY = $pdf->GetY() + 1;
            $gambar4 = base_url('assets/theme/admin-lte-3/dist/img/es-stempel.png');
            $pdf->Image($gambar4, 1.25, $getY, 6, 3.5);
            
            $pdf->SetFont('Arial', '', '10');
            $pdf->Cell(10.5, 0.5, '', '', 0, 'L', $fill);
            $pdf->Cell(8.5, 0.5, '', '', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->SetFont('Arial', 'B', '10');
            $pdf->Cell(4, 0.5, 'Pemesan', '0', 0, 'C', $fill);
            $pdf->Cell(6.5, 0.5, '', '0', 0, 'C', $fill);
            $pdf->SetFont('Arial', '', '10');
            $pdf->Cell(8.5, 0.5, 'Semarang, '.$this->tanggalan->tgl_indo3($sql_beli->tgl_masuk), '0', 0, 'C', $fill);
            $pdf->Ln(4);
            
            $pdf->SetFont('Arial', '', '10');
            $pdf->Cell(10.5, 0.5, 'APT. UNGSARI RIZKI EKA PURWANTO, M.SC', '0', 0, 'L', $fill);
            $pdf->Cell(8.5, 0.5, $oleh, '0', 0, 'C', $fill);
            $pdf->Ln();
                    
            $pdf->SetFillColor(235, 232, 228);
            $pdf->SetTextColor(0);
            $pdf->SetFont('Arial', '', '10');
            
            $type = (isset($_GET['type']) ? $_GET['type'] : 'I');
            
            ob_start();
            $pdf->Output('FP'.date('YmdHi').'.pdf', $type);
            ob_end_flush();
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function pdf_trans_beli_po() {
        if (akses::aksesLogin() == TRUE) {
            $setting      = $this->db->get('tbl_pengaturan')->row();
            $id           = $this->input->get('id');
            
            $sql_beli     = $this->db->where('id', general::dekrip($id))->get('tbl_trans_beli_po')->row();
            $sql_beli_det = $this->db->where('id_pembelian', general::dekrip($id))->get('tbl_trans_beli_po_det')->result();
            $sql_supplier = $this->db->where('id', $sql_beli->id_supplier)->get('tbl_m_supplier')->row();
            $oleh         = $this->ion_auth->user($sql_beli->id_user)->row()->first_name;
            
            $gambar1      = base_url('assets/theme/admin-lte-3/dist/img/logo-esensia-2.png');
            $gambar2      = base_url('assets/theme/admin-lte-3/dist/img/logo-bw-bg2-1440px.png');
            $gambar3      = base_url('assets/theme/admin-lte-3/dist/img/logo-footer.png');

            $judul        = "PURCHASE ORDER";
            $fill         = FALSE;
            
            $this->load->library('MedBeliPDF');
            $pdf = new MedBeliPDF('P', 'cm', array(21.5,33));
            $pdf->SetAutoPageBreak('auto', 8.5);            
            $pdf->addPage('','',false);
            
            # Gambar Watermark Tengah
            if (isset($gambar2) && !empty($gambar2)) {
                $pdf->Image($gambar2,5,4,15,19);
            } 
            
            # Line Cell
            $pdf->Cell(19, .5, '', 'T', 0, 'L', $fill);
            $pdf->Ln();            

            
            # Blok Judul
            $pdf->SetFont('Arial', 'B', '9');
            $pdf->Cell(1, .5, 'APA', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->SetFont('Arial', '', '9');
            $pdf->Cell(17.5, .5, $setting->apt_apa, 0, 1, 'L');
            $pdf->Ln(0);
            $pdf->SetFont('Arial', 'B', '9');
            $pdf->Cell(1, .5, 'SIPA', '', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '', 0, 'C', $fill);
            $pdf->SetFont('Arial', '', '9');
            $pdf->Cell(17.5, .5, $setting->apt_sipa, '', 1, 'L', $fill);
            $pdf->Ln();
            
            // Blok ID PASIEN
            $pdf->SetFont('Arial', '', '9');
            $pdf->Cell(2.5, .5, 'Kepada Yth.', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, '', '0', 0, 'C', $fill);
            $pdf->Cell(8.5, .5,'', '0', 0, 'L', $fill);
            $pdf->Cell(1.5, .5, 'No. PO', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->Cell(5, .5, $sql_beli->no_nota, '0', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->Cell(11.5, .5, strtoupper($sql_supplier->nama).(!empty($sql_supplier->kode) ? ' ['.$sql_supplier->kode.']' : ''), '0', 0, 'L', $fill);
            $pdf->Cell(1.5, .5, 'Tanggal', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->Cell(5, .5, $this->tanggalan->tgl_indo3($sql_beli->tgl_masuk), '0', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->Cell(11.5, .5, (!empty($sql_supplier->npwp) ? $sql_supplier->npwp : '-'), '0', 0, 'L', $fill);
            $pdf->Cell(1.5, .5, 'Oleh', '0', 0, 'L', $fill);
            $pdf->Cell(.5, .5, ':', '0', 0, 'C', $fill);
            $pdf->Cell(5, .5, $oleh, '0', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->MultiCell(19, .5, $sql_supplier->alamat, '0', 'L');
            $pdf->Ln();  
            
                        
            $fill = FALSE;
            $pdf->SetTextColor(5,148,19);
            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Cell(3, 1, 'KODE', 'TB', 0, 'L', $fill);
            $pdf->Cell(8, 1, 'DESKRIPSI', 'TB', 0, 'L', $fill);
            $pdf->Cell(1.5, 1, 'JML', 'TB', 0, 'C', $fill);
            $pdf->Cell(6.5, 1, 'KETERANGAN', 'TB', 0, 'L', $fill);
            $pdf->SetTextColor(0,0,0);
            $pdf->Ln();
            
            $fill = FALSE;
            $no = 1;
            foreach ($sql_beli_det as $det){
                
                $pdf->SetFont('Arial', '', '10');
                $pdf->Cell(3, .5, $det->kode, '', 0, 'L', $fill);
                $pdf->Cell(8, .5, $det->produk, '', 0, 'L', $fill);
                $pdf->Cell(1.5, .5, (float) $det->jml, '', 0, 'C', $fill);
                $pdf->Cell(6.5, .5, $det->keterangan_itm, '', 0, 'L', $fill);
                $pdf->Ln();
                
                $no++;
            }
            $pdf->Ln(2);

            // Gambar VALIDASI
            $getY = $pdf->GetY() + 1;
            $gambar4 = base_url('assets/theme/admin-lte-3/dist/img/es-stempel.png');
            if (file_exists(FCPATH . 'assets/theme/admin-lte-3/dist/img/es-stempel.png')) {
                $pdf->Image($gambar4, 1.25, $getY, 6, 3.5);
            }
            
            $pdf->SetFont('Arial', '', '10');
            $pdf->Cell(10.5, .5, '', '', 0, 'L', $fill);
            $pdf->Cell(8.5, .5, '', '', 0, 'L', $fill);
            $pdf->Ln();
            $pdf->SetFont('Arial', 'B', '10');
            $pdf->Cell(4, .5, 'Pemesan', '0', 0, 'C', $fill);
            $pdf->Cell(6.5, .5, '', '0', 0, 'C', $fill);
            $pdf->SetFont('Arial', '', '10');
            $pdf->Cell(8.5, .5, 'Semarang, '.$this->tanggalan->tgl_indo3($sql_beli->tgl_masuk), '0', 0, 'C', $fill);
            $pdf->Ln(4);
            
            $pdf->SetFont('Arial', '', '10');
            $pdf->Cell(10.5, .5, 'APT. UNGSARI RIZKI EKA PURWANTO, M.SC', '0', 0, 'L', $fill);
            $pdf->Cell(8.5, .5, $oleh, '0', 0, 'C', $fill);
            $pdf->Ln();
                    
            $pdf->SetFillColor(235, 232, 228);
            $pdf->SetTextColor(0);
            $pdf->SetFont('Arial', '', '10');
            
            $type = (isset($_GET['type']) ? $_GET['type'] : 'I');
            
            ob_start();
            $pdf->Output('PO_'.date('YmdHi').'.pdf', $type);
            ob_end_flush();
        } else {
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    

    public function set_trans_beli() {
        if (akses::aksesLogin() == TRUE) {
            $tgl_masuk  = $this->input->post('tgl_masuk');
            $tgl_tempo  = $this->input->post('tgl_keluar');
            $plgn       = $this->input->post('id_supplier');
            $no_nota    = $this->input->post('no_nota');
            $no_po      = $this->input->post('kode_po');
            $id_po      = $this->input->post('id_po');
            $status_ppn = $this->input->post('status_ppn');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id_supplier', 'ID Supplier', 'required');
            $this->form_validation->set_rules('tgl_masuk', 'Tgl Faktur', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = [
                    'id_supplier'   => form_error('id_supplier'),
                    'tgl_masuk'     => form_error('tgl_masuk'),
                ];

                $this->session->set_flashdata('form_error', $msg_error);
                $this->session->set_flashdata('trans_toast', 'toastr.error("Validasi form gagal!");');
                redirect(base_url('transaksi/beli/trans_beli.php'));
            } else {

                $tgl_msk        = $this->tanggalan->tgl_indo_sys($tgl_masuk);
                $tgl_klr        = $this->tanggalan->tgl_indo_sys($tgl_tempo);
                $sql_supplier   = $this->db->where('id', $plgn)->get('tbl_m_supplier')->row();
                
                $sql_beli   = $this->db->where('YEAR(tgl_simpan)', date('Y'))->where('MONTH(tgl_simpan)', date('m'))->get('tbl_trans_beli');
                $sql_beli_ck= $this->db->where('no_nota', $no_nota)->get('tbl_trans_beli');
                $nota_str   = $sql_beli->num_rows() + 1;
                $nota       = (!empty($no_nota) ? $no_nota : 'FP'.date('m').date('y').sprintf('%03d', $nota_str));
                
                $sql_po_det = $this->db->where('id_pembelian', $id_po)->get('tbl_trans_beli_po_det')->result();

                $data = [
                    'no_nota'      => $nota,
                    'id_po'        => $id_po,
                    'no_po'        => $no_po,
                    'tgl_simpan'   => date('Y-m-d H:i:s'),
                    'tgl_masuk'    => (!empty($tgl_msk) ? $tgl_msk : '0000-00-00'),
                    'tgl_keluar'   => (!empty($tgl_klr) ? $tgl_klr : '0000-00-00'),
                    'id_supplier'  => $plgn,
                    'id_user'      => $this->ion_auth->user()->row()->id,
                    'supplier'     => $sql_supplier->nama,
                    'status_ppn'   => (!empty($status_ppn) ? $status_ppn : '0'),
                    'status_nota'  => '0',
                ];
                                
                if($sql_beli_ck->num_rows() == 0){
                    # Begin transaction
                    $this->db->trans_begin();

                    try {
                        // Get form ID and check for double submission
                        $form_id = $this->input->post('form_id');
                        if (check_form_submitted($form_id)) {
                            $this->session->set_flashdata('trans_toast', 'toastr.error("Form sudah disubmit sebelumnya!");');
                            redirect(base_url('transaksi/beli/trans_beli.php'));
                        }

                        # Insert into trans_beli table
                        $this->db->insert('tbl_trans_beli', $data);
                        $last_id = $this->db->insert_id();

                        if($last_id > 0){
                            foreach ($sql_po_det as $po_det){
                                $sql_brg     = $this->db->where('id', $po_det->id_produk)
                                                        ->get('tbl_m_produk')->row();
                                $sql_satuan  = $this->db->where('id', $po_det->id_satuan)->get('tbl_m_satuan')->row();
                                $pengaturan  = $this->db->get('tbl_pengaturan')->row();

                                $harga       = ($sql_brg->harga_beli > 0 ? $sql_brg->harga_beli : '1');
                                $jml_pcs     = $sql_satuan->jml * $po_det->jml;
                                $harga_pcs   = ($harga * $po_det->jml) / $jml_pcs;
                                $harga_sat   = $harga_pcs * $sql_satuan->jml;

                                $harga_ppn   = ($status_ppn == '1' ? ($pengaturan->jml_ppn / 100) * $harga : 0);
                                $harga_tot   = $harga + $harga_ppn;
                                $potongan    = 0; // Initialize potongan to avoid undefined variable
                                $subtotal    = ($harga * $jml_pcs) - $potongan;
                                $jml_qty     = $po_det->jml;

                                $data_pemb_det = [
                                    'id_pembelian' => $last_id,
                                    'id_produk'    => $sql_brg->id,
                                    'id_satuan'    => $sql_brg->id_satuan,
                                    'no_nota'      => $nota,
                                    'tgl_simpan'   => $tgl_msk.' '.date('H:i:s'),
                                    'kode'         => $sql_brg->kode,
                                    'produk'       => $sql_brg->produk,
                                    'jml'          => $jml_qty,
                                    'jml_satuan'   => (!empty($sql_satuan->jml) ? $sql_satuan->jml : '1'),
                                    'satuan'       => $po_det->satuan,
                                    'keterangan'   => '',
                                    'harga'        => (float)$harga,
                                    'disk1'        => 0,
                                    'disk2'        => 0,
                                    'disk3'        => 0,
                                    'diskon'       => 0,
                                    'potongan'     => 0,
                                    'subtotal'     => $subtotal,
                                ];

                                # Insert into trans_beli_det table
                                $this->db->insert('tbl_trans_beli_det', $data_pemb_det);
                            }
                        }

                        # Set session data
                        $this->session->set_userdata('trans_beli', $data);

                        # Check transaction status
                        if ($this->db->trans_status() === FALSE) {
                            throw new Exception('Database transaction failed');
                        }
                        
                        # Commit transaction
                        $this->db->trans_commit();
                        
                        $this->session->set_flashdata('trans_toast', 'toastr.success("Transaksi berhasil disimpan!");');
                        redirect(base_url('transaksi/beli/trans_beli.php?id='.general::enkrip($last_id)));
                        
                    } catch (Exception $e) {
                        # Rollback transaction on error
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('trans_toast', 'toastr.error("Transaksi gagal: ' . $e->getMessage() . '");');
                        redirect(base_url('transaksi/beli/trans_beli.php'));
                    }
                } else {
                    $this->session->set_flashdata('trans_toast', 'toastr.error("Nomor faktur sudah ada!");');
                    redirect(base_url('transaksi/beli/trans_beli.php?id_po='.general::enkrip($id_po).'&id_supplier='.general::enkrip($plgn)));
                }
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!");');
            redirect();
        }
    }

    public function set_trans_beli_upd() {
        if (akses::aksesLogin() == TRUE) {
            $id         = $this->input->post('id');
            $tgl_masuk  = $this->input->post('tgl_masuk');
            $tgl_tempo  = $this->input->post('tgl_keluar');
            $plgn       = $this->input->post('id_supplier');
            $no_nota    = $this->input->post('no_nota');
            $no_po      = $this->input->post('no_po');
            $id_po      = $this->input->post('id_po');
            $status_ppn = $this->input->post('status_ppn');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id_supplier', 'ID Supplier', 'required');
            $this->form_validation->set_rules('tgl_masuk', 'Tgl Faktur', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = [
                    'id_supplier'   => form_error('id_supplier'),
                    'tgl_masuk'     => form_error('tgl_masuk'),
                ];

                $this->session->set_flashdata('form_error', $msg_error);
                $this->session->set_flashdata('trans_toast', 'toastr.error("Validasi form gagal!");');
                redirect(base_url('transaksi/beli/trans_beli.php'));
            } else {
                try {
                    // Get form ID and check for double submission
                    $form_id = $this->input->post('form_id');
                    if (check_form_submitted($form_id)) {
                        throw new Exception('Form sudah disubmit sebelumnya!');
                    }
                    
                    $tgl_msk = $this->tanggalan->tgl_indo_sys($tgl_masuk);
                    $tgl_klr = $this->tanggalan->tgl_indo_sys($tgl_tempo);

                    $data = [
                        'no_nota'      => $no_nota,
                        'no_po'        => $no_po,
                        'tgl_simpan'   => date('Y-m-d H:i:s'),
                        'tgl_masuk'    => $tgl_msk,
                        'tgl_keluar'   => $tgl_klr,
                        'id_po'        => $id_po,
                        'id_supplier'  => $plgn,
                        'id_user'      => $this->ion_auth->user()->row()->id,
                        'status_ppn'   => (!empty($status_ppn) ? $status_ppn : '0'),
                    ];
                    
                    $this->db->where('id', general::dekrip($id))->update('tbl_trans_beli', $data);
                    $this->session->set_userdata('trans_beli_edit', $data);
                    $this->session->set_flashdata('trans_toast', 'toastr.success("Data transaksi berhasil diupdate!");');
                    redirect(base_url('transaksi/beli/trans_beli_edit.php?id='.$id));
                } catch (Exception $e) {
                    $this->session->set_flashdata('trans_toast', 'toastr.error("' . $e->getMessage() . '");');
                    redirect(base_url('transaksi/beli/trans_beli.php'));
                }
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!");');
            redirect();
        }
    }

    public function set_trans_beli_batal() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota  = $this->input->get('id');
            
            if(!empty($no_nota)){
                $this->session->unset_userdata('trans_beli');
                $this->cart->destroy();
            }
            
            redirect(base_url('transaksi/beli/trans_beli.php'));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function set_trans_beli_po() {
        if (akses::aksesLogin() == TRUE) {
            $tgl_masuk  = $this->input->post('tgl_masuk');
            $tgl_tempo  = $this->input->post('tgl_tempo');
            $plgn       = $this->input->post('id_supplier');
            $ket        = $this->input->post('keterangan');
            $alamat     = $this->input->post('pengiriman');
            $status_ppn = $this->input->post('status_ppn');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id_supplier', 'ID Supplier', 'required');
            $this->form_validation->set_rules('tgl_masuk', 'Tgl Faktur', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = [
                    'id_supplier' => form_error('id_supplier'),
                    'tgl_masuk'   => form_error('tgl_masuk'),
                ];

                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url('transaksi/beli/trans_beli.php'));
            } else {
                $tgl_msk = $this->tanggalan->tgl_indo_sys($tgl_masuk);
                $tgl_klr = $this->tanggalan->tgl_indo_sys($tgl_tempo);
                
                $sql_beli   = $this->db->where('YEAR(tgl_simpan)', date('Y'))->where('MONTH(tgl_simpan)', date('m'))->get('tbl_trans_beli_po');
                $nota_str   = $sql_beli->num_rows() + 1;
                $nota       = (!empty($no_nota) ? $no_nota : 'FP'.date('m').date('y').sprintf('%03d', $nota_str));
                $supplier   = $this->db->where('id', $plgn)->get('tbl_m_supplier')->row();
                
                $data = [
                    'no_nota'      => $nota,
                    'tgl_simpan'   => date('Y-m-d H:i:s'),
                    'tgl_masuk'    => $tgl_msk,
                    'id_supplier'  => $plgn,
                    'id_user'      => $this->ion_auth->user()->row()->id,
                    'supplier'     => strtoupper($supplier->nama),
                    'keterangan'   => $ket,
                    'pengiriman'   => $alamat,
                    'status_nota'  => '0'
                ];
                
                # Begin Transaction
                $this->db->trans_begin();
                
                try {
                    // Get form ID and check for double submission
                    $form_id = $this->input->post('form_id');
                    if (check_form_submitted($form_id)) {
                        throw new Exception('Form sudah disubmit sebelumnya!');
                    }

                    # Insert into purchase order table
                    $this->db->insert('tbl_trans_beli_po', $data);
                    $last_id = $this->db->insert_id();
                    
                    # If everything is successful, commit the transaction
                    if ($this->db->trans_status() === FALSE) {
                        throw new Exception('Database transaction failed');
                    }
                    
                    $this->db->trans_commit();
                    
                    # Set session data and flash message
                    $this->session->set_userdata('trans_beli_po', $data);
                    $this->session->set_flashdata('trans_toast', 'toastr.success("Purchase Order berhasil dibuat!");');
                    
                    redirect(base_url('transaksi/beli/trans_beli_po.php?id='.general::enkrip($last_id)));
                } catch (Exception $e) {
                    # If something went wrong, rollback the transaction
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('trans_toast', 'toastr.error("Gagal membuat Purchase Order: ' . $e->getMessage() . '");');
                    redirect(base_url('transaksi/beli/trans_beli.php'));
                }
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function set_trans_beli_po_upd() {
        if (akses::aksesLogin() == TRUE) {
            $id         = $this->input->post('id');
            $tgl_masuk  = $this->input->post('tgl_masuk');
            $tgl_tempo  = $this->input->post('tgl_tempo');
            $plgn       = $this->input->post('id_supplier');
            $supp       = $this->input->post('supplier');
            $ket        = $this->input->post('keterangan');
            $alamat     = $this->input->post('pengiriman');
            $status_ppn = $this->input->post('status_ppn');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id_supplier', 'ID Supplier', 'required');
            $this->form_validation->set_rules('tgl_masuk', 'Tgl Faktur', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = [
                    'id_supplier'   => form_error('id_supplier'),
                    'tgl_masuk'     => form_error('tgl_masuk'),
                ];

                $this->session->set_flashdata('form_error', $msg_error);

                redirect(base_url('transaksi/beli/trans_beli_po_edit.php?id='.$id));
            } else {                      
                $tgl_msk    = $this->tanggalan->tgl_indo_sys($tgl_masuk);
                $tgl_klr    = $this->tanggalan->tgl_indo_sys($tgl_tempo);
                
                $sql_beli   = $this->db->where('YEAR(tgl_simpan)', date('Y'))->where('MONTH(tgl_simpan)', date('m'))->get('tbl_trans_beli_po');
                $nota_str   = $sql_beli->num_rows() + 1;
                $nota       = (!empty($no_nota) ? $no_nota : 'FP'.date('m').date('y').sprintf('%03d', $nota_str));
              
                # Begin Transaction
                $this->db->trans_begin();

                try {
                    // Get form ID and check for double submission
                    $form_id = $this->input->post('form_id');
                    if (check_form_submitted($form_id)) {
                        throw new Exception('Form sudah disubmit sebelumnya!');
                    }

                    $data = [
                        'no_nota'      => $nota,
                        'tgl_simpan'   => date('Y-m-d H:i:s'),
                        'tgl_masuk'    => $tgl_msk,
                        'id_supplier'  => $plgn,
                        'id_user'      => $this->ion_auth->user()->row()->id,
                        'supplier'     => $supp,
                        'keterangan'   => $ket,
                        'pengiriman'   => $alamat
                    ];
                    
                    # Update purchase order
                    $this->db->where('id', general::dekrip($id))->update('tbl_trans_beli_po', $data);
                    
                    # If everything is successful, commit the transaction
                    if ($this->db->trans_status() === FALSE) {
                        throw new Exception('Database transaction failed');
                    }
                    
                    $this->db->trans_commit();
                    
                    $this->session->set_userdata('trans_beli_po_edit', $data);
                    $this->session->set_flashdata('trans_toast', 'toastr.success("Purchase Order berhasil diperbarui!");');
                    redirect(base_url('transaksi/beli/trans_beli_po_edit.php?id='.$id));
                    
                } catch (Exception $e) {
                    # If something went wrong, rollback the transaction
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('trans_toast', 'toastr.error("Gagal memperbarui Purchase Order: ' . $e->getMessage() . '");');
                    redirect(base_url('transaksi/beli/trans_beli_po_edit.php?id='.$id));
                }
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function set_trans_beli_proses() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota    = $this->input->post('no_nota');
            $ongkir     = $this->input->post('jml_ongkir');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
            $this->form_validation->set_rules('no_nota', 'ID', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = [
                    'no_nota' => form_error('no_nota'),
                ];

                $this->session->set_flashdata('form_error', $msg_error);
                $this->session->set_flashdata('trans_toast', 'toastr.error("Validasi form gagal!");');
                redirect(base_url('transaksi/beli/trans_beli.php'));
            } else {
                # Begin transaction
                $this->db->trans_begin();

                try {
                    // Get form ID and check for double submission
                    $form_id = $this->input->post('form_id');
                    if (check_form_submitted($form_id)) {
                        throw new Exception('Form sudah disubmit sebelumnya!');
                    }
                    
                    $trans_beli   = $this->session->userdata('trans_beli');
                    $sql_beli     = $this->db->where('id', general::dekrip($no_nota))->get('tbl_trans_beli')->row();
                    $sql_beli_det = $this->db->where('id_pembelian', $sql_beli->id)->get('tbl_trans_beli_det')->result();
                    $pengaturan   = $this->db->get('tbl_pengaturan')->row();
                    $sql_supp     = $this->db->where('id', $trans_beli['id_supplier'])->get('tbl_m_supplier')->row();
                    $jml_ongkir   = (float)general::format_angka_db($ongkir);
                    
                    $jml_total    = 0;
                    $jml_diskon   = 0;
                    $jml_potongan = 0;
                    $jml_subtotal = 0;
                    
                    foreach ($sql_beli_det as $cart) {
                        $sql_gudang     = $this->db->where('status', '2')->get('tbl_m_gudang')->row();
                        $sql_item       = $this->db->where('id', $cart->id_produk)->get('tbl_m_produk')->row();
                        $sql_item_stok  = $this->db->where('id_produk', $sql_item->id)->where('id_gudang', $sql_gudang->id)->get('tbl_m_produk_stok')->row();
                        $sql_satuan     = $this->db->where('id', $sql_item->id_satuan)->get('tbl_m_satuan')->row();
                        $stok_akhir     = $sql_item_stok->jml + ($cart->jml * $cart->jml_satuan);
                        
                        $hrg_pcs        = $cart->subtotal / ($cart->jml * $cart->jml_satuan);
                        $hrg_ppn        = ($trans_beli['status_ppn'] == 1 ? ($pengaturan->jml_ppn / 100) * $hrg_pcs : 0);
                        $hrg_pcs_akhir  = $hrg_pcs + $hrg_ppn;
                        $jml_total      = $jml_total + $cart->subtotal;
                        $jml_potongan   = $jml_potongan + $cart->potongan;
                        $jml_subtotal   = $jml_subtotal + $cart->subtotal;

                        # Update product stok
                        $data_stok = [
                            'tgl_modif'      => date('Y-m-d H:i:s'),
                            'jml'            => (float)$stok_akhir,
                        ];

                        # Update product table
                        $this->db->where('id', $sql_item_stok->id)->update('tbl_m_produk_stok', $data_stok);

                        # History Pembelian
                        $data_brg_hist = [
                            'tgl_simpan'        => (!empty($tgl_trm) ? $this->tanggalan->tgl_indo_sys($tgl_trm) : date('Y-m-d')).' '.date('H:i:s'),
                            'tgl_masuk'         => (!empty($tgl_trm) ? $this->tanggalan->tgl_indo_sys($tgl_trm) : date('Y-m-d')),
                            'tgl_ed'            => $sql_item->tgl_ed ?? null,
                            'id_produk'         => $sql_item->id,
                            'id_user'           => $this->ion_auth->user()->row()->id,
                            'id_gudang'         => $sql_gudang->id,
                            'id_pembelian'      => $sql_beli->id,
                            'id_pembelian_det'  => $cart->id,
                            'id_supplier'       => $sql_supp->id,
                            'kode'              => $sql_item->kode,
                            'kode_batch'        => $cart->kode_batch ?? null,
                            'produk'            => $sql_item->produk,
                            'no_nota'           => $sql_beli->no_nota,
                            'jml'               => $cart->jml * $cart->jml_satuan,
                            'jml_satuan'        => 1,
                            'satuan'            => (!empty($sql_satuan->satuanTerkecil) ? $sql_satuan->satuanTerkecil : 'PCS'),
                            'nominal'           => $hrg_pcs_akhir,
                            'keterangan'        => 'Pembelian '.$sql_beli->no_nota,
                            'status'            => '1',
                        ];

                        # Insert into product history table
                        $this->db->insert('tbl_m_produk_hist', $data_brg_hist);

                        # Count global stock
                        $sql_stok = $this->db->select_sum('jml')->where('id_produk', $sql_item->id)->get('tbl_m_produk_stok')->row();
                        
                        # Update product data
                        $data_brg = [
                            'tgl_modif'      => date('Y-m-d H:i:s'),
                            'harga_jual_het' => (float)$hrg_pcs_akhir,
                            'jml'            => (float)$sql_stok->jml,
                        ];

                        # Update product table
                        $this->db->where('id', $sql_item->id)->update('tbl_m_produk', $data_brg);
                    }
                    
                    // Calculate totals based on tax status
                    if ($trans_beli['status_ppn'] == '1') {
                        $jml_ppn        = ($pengaturan->jml_ppn / 100) * $jml_subtotal;
                        $jml_gtotal     = $jml_subtotal + $jml_ppn;
                        $jml_dpp        = $jml_subtotal - $jml_ppn;
                        $ppn            = $pengaturan->jml_ppn;
                    } elseif ($trans_beli['status_ppn'] == '2') {
                        $jml_ppn        = $jml_subtotal - ($jml_subtotal / $pengaturan->ppn);
                        $jml_gtotal     = $jml_subtotal;
                        $jml_dpp        = $jml_subtotal - $jml_ppn;
                        $ppn            = $pengaturan->jml_ppn;
                    } else {
                        $ppn            = 0;
                        $jml_ppn        = 0;
                        $jml_gtotal     = $jml_subtotal;
                        $jml_dpp        = $jml_subtotal;
                    }
                    
                    $jml_gtotal = (float)$jml_gtotal + (float)$jml_ongkir;
                    
                    $data_pemb_update = [
                        'jml_total'     => (float)$jml_total,
                        'jml_diskon'    => (float)$jml_diskon,
                        'jml_potongan'  => (float)$jml_potongan,
                        'jml_subtotal'  => (float)$jml_subtotal,
                        'jml_dpp'       => (float)$jml_dpp,
                        'ppn'           => (float)$ppn,
                        'jml_ppn'       => (float)$jml_ppn,
                        'jml_ongkir'    => (float)$jml_ongkir,
                        'jml_gtotal'    => (float)$jml_gtotal,
                        'status_retur'  => '0',
                    ];
                    
                    # Update purchase transaction table
                    $this->db->where('id', $sql_beli->id)->update('tbl_trans_beli', $data_pemb_update);
                    
                    # Update purchase order status
                    if (!empty($sql_beli->id_po)) {
                        $this->db->where('id', $sql_beli->id_po)->update('tbl_trans_beli_po', ['status_nota' => '1']);
                    }
                    
                    # If everything is successful, commit the transaction
                    if ($this->db->trans_status() === FALSE) {
                        throw new Exception('Database transaction failed');
                    }
                    
                    $this->db->trans_commit();
                    
                    /* -- Hapus semua session -- */
                    $this->session->unset_userdata('trans_beli');
                    $this->cart->destroy();
                    /* -- Hapus semua session -- */
                    
                    $this->session->set_flashdata('trans_toast', 'toastr.success("Transaksi berhasil disimpan");');
                    redirect(base_url('transaksi/trans_beli_det.php?id='.general::enkrip($sql_beli->id)));
                } catch (Exception $e) {
                    # If something went wrong, rollback the transaction
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('trans_toast', 'toastr.error("Transaksi gagal disimpan: ' . $e->getMessage() . '");');
                    redirect(base_url('transaksi/beli/trans_beli.php'));
                }
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function set_trans_beli_proses_upd() {
        if (akses::aksesLogin() == TRUE) {
            $id         = $this->input->post('id');
            $no_nota    = $this->input->post('no_nota');
            $ongkir     = $this->input->post('jml_ongkir');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id', 'ID', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = [
                    'id' => form_error('id'),
                ];

                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url('transaksi/beli/trans_beli_edit.php?id='.$id));
            } else {                    
                # Start Transaction
                $this->db->trans_begin();
                
                try {
                    // Get form ID and check for double submission
                    $form_id = $this->input->post('form_id');
                    if (check_form_submitted($form_id)) {
                        throw new Exception('Form sudah disubmit sebelumnya!');
                    }
                    
                    $trans_beli  = $this->session->userdata('trans_beli_edit');
                    $pengaturan  = $this->db->get('tbl_pengaturan')->row();
                    $sql_beli    = $this->db->where('id', general::dekrip($id))->get('tbl_trans_beli')->row();
                    $sql_beli_det= $this->db->select('SUM(diskon) AS diskon, SUM(potongan) AS potongan, SUM(subtotal) AS subtotal')
                                           ->where('id_pembelian', $sql_beli->id)
                                           ->get('tbl_trans_beli_det')
                                           ->row();
                    $sql_supp    = $this->db->where('id', $sql_beli->id_supplier)->get('tbl_m_supplier')->row();
                    
                    // Process any new products added during the update
                    $sql_beli_det_items = $this->db->where('id_pembelian', $sql_beli->id)->get('tbl_trans_beli_det')->result();
                    
                    // // Update stock for each product in the purchase
                    // foreach ($sql_beli_det_items as $item) {
                    //     $sql_gudang     = $this->db->where('status', '2')->get('tbl_m_gudang')->row();
                    //     $sql_item       = $this->db->where('id', $item->id_produk)->get('tbl_m_produk')->row();
                    //     $sql_item_stok  = $this->db->where('id_produk', $sql_item->id)
                    //                                ->where('id_gudang', $sql_gudang->id)
                    //                                ->get('tbl_m_produk_stok')->row();
                    //     $sql_satuan     = $this->db->where('id', $sql_item->id_satuan)->get('tbl_m_satuan')->row();
                        
                    //     // If product stock record doesn't exist, create it
                    //     if (empty($sql_item_stok)) {
                    //         $stok_akhir = $item->jml * $item->jml_satuan;
                    //         $data_stok = [
                    //             'id_produk'      => $sql_item->id,
                    //             'id_gudang'      => $sql_gudang->id,
                    //             'tgl_simpan'     => date('Y-m-d H:i:s'),
                    //             'tgl_modif'      => date('Y-m-d H:i:s'),
                    //             'jml'            => (float)$stok_akhir,
                    //         ];
                    //         $this->db->insert('tbl_m_produk_stok', $data_stok);
                    //     } else {
                    //         // Update existing stock
                    //         $stok_akhir = $sql_item_stok->jml + ($item->jml * $item->jml_satuan);
                    //         $data_stok = [
                    //             'tgl_modif'      => date('Y-m-d H:i:s'),
                    //             'jml'            => (float)$stok_akhir,
                    //         ];
                    //         $this->db->where('id', $sql_item_stok->id)->update('tbl_m_produk_stok', $data_stok);
                    //     }
                        
                    //     // Calculate pricing
                    //     $hrg_pcs        = $item->subtotal / ($item->jml * $item->jml_satuan);
                    //     $hrg_ppn        = ($trans_beli['status_ppn'] == 1 ? ($pengaturan->jml_ppn / 100) * $hrg_pcs : 0);
                    //     $hrg_pcs_akhir  = $hrg_pcs + $hrg_ppn;
                        
                    //     // Add to product history
                    //     $data_brg_hist = [
                    //         'tgl_simpan'        => date('Y-m-d H:i:s'),
                    //         'tgl_masuk'         => date('Y-m-d'),
                    //         'tgl_ed'            => $item->tgl_ed ?? null,
                    //         'id_produk'         => $sql_item->id,
                    //         'id_user'           => $this->ion_auth->user()->row()->id,
                    //         'id_gudang'         => $sql_gudang->id,
                    //         'id_pembelian'      => $sql_beli->id,
                    //         'id_pembelian_det'  => $item->id,
                    //         'id_supplier'       => $sql_supp->id,
                    //         'kode'              => $sql_item->kode,
                    //         'kode_batch'        => $item->kode_batch ?? null,
                    //         'produk'            => $sql_item->produk,
                    //         'no_nota'           => $sql_beli->no_nota,
                    //         'jml'               => $item->jml * $item->jml_satuan,
                    //         'jml_satuan'        => 1,
                    //         'satuan'            => (!empty($sql_satuan->satuanTerkecil) ? $sql_satuan->satuanTerkecil : 'PCS'),
                    //         'nominal'           => $hrg_pcs_akhir,
                    //         'keterangan'        => 'Update Pembelian '.$sql_beli->no_nota,
                    //         'status'            => '1',
                    //     ];
                        
                    //     // Check if history already exists
                    //     $existing_hist = $this->db->where('id_pembelian_det', $item->id)
                    //                              ->get('tbl_m_produk_hist')->row();
                    //     if (empty($existing_hist)) {
                    //         $this->db->insert('tbl_m_produk_hist', $data_brg_hist);
                    //     } else {
                    //         // Update existing history record
                    //         $this->db->where('id', $existing_hist->id)
                    //                  ->update('tbl_m_produk_hist', $data_brg_hist);
                    //     }
                        
                    //     // Update product pricing
                    //     $sql_stok = $this->db->select_sum('jml')->where('id_produk', $sql_item->id)->get('tbl_m_produk_stok')->row();
                    //     $data_brg = [
                    //         'tgl_modif'      => date('Y-m-d H:i:s'),
                    //         'harga_jual_het' => (float)$hrg_pcs_akhir,
                    //         'jml'            => (float)$sql_stok->jml,
                    //     ];
                    //     $this->db->where('id', $sql_item->id)->update('tbl_m_produk', $data_brg);
                    // }
                    
                    // Convert all values to float to prevent type errors
                    $jml_total      = (float)$sql_beli_det->diskon + (float)$sql_beli_det->potongan + (float)$sql_beli_det->subtotal;
                    $jml_diskon     = (float)$sql_beli_det->diskon;
                    $jml_potongan   = (float)$sql_beli_det->potongan;
                    $jml_subtotal   = (float)$sql_beli_det->subtotal;
                    $jml_ongkir     = (float)general::format_angka_db($ongkir);
                      
                    if($trans_beli['status_ppn'] == '1'){
                        $jml_ppn        = ($sql_beli->status_ppn == 1 ? ((float)$pengaturan->jml_ppn / 100) * (float)$sql_beli_det->subtotal : 0);
                        $jml_dpp        = (float)$sql_beli_det->subtotal - (float)$jml_ppn;
                        $jml_gtotal     = (float)$sql_beli_det->subtotal + (float)$jml_ppn;
                        $ppn            = (float)$pengaturan->jml_ppn;
                    } elseif($trans_beli['status_ppn'] == '2'){
                        $jml_ppn        = (float)$sql_beli_det->subtotal - ((float)$sql_beli_det->subtotal / (float)$pengaturan->ppn);
                        $jml_dpp        = (float)$sql_beli_det->subtotal - (float)$jml_ppn;
                        $jml_gtotal     = (float)$sql_beli_det->subtotal;
                        $ppn            = (float)$pengaturan->jml_ppn;
                    } else {
                        $ppn            = 0;
                        $jml_ppn        = 0;
                        $jml_dpp        = (float)$sql_beli_det->subtotal;
                        $jml_gtotal     = (float)$sql_beli_det->subtotal;
                    }
                    
                    $jml_gtotal = (float)$jml_gtotal + (float)$jml_ongkir;
                    
                    $data_pemb_update = [
                        'jml_total'     => (float)$jml_total,
                        'jml_diskon'    => (float)$jml_diskon,
                        'jml_potongan'  => (float)$jml_potongan,
                        'jml_subtotal'  => (float)$jml_subtotal,
                        'jml_dpp'       => (float)$jml_dpp,
                        'ppn'           => (float)$ppn,
                        'jml_ppn'       => (float)$jml_ppn,
                        'jml_ongkir'    => (float)$jml_ongkir,
                        'jml_gtotal'    => (float)$jml_gtotal,
                        'status_retur'  => '0',
                    ];
                    
                    # Update purchase transaction table
                    $this->db->where('id', $sql_beli->id)->update('tbl_trans_beli', $data_pemb_update);
                    
                    # Check transaction status
                    if ($this->db->trans_status() === FALSE) {
                        $this->db->trans_rollback();
                        throw new Exception("Gagal mengupdate data pembelian!");
                    }
                    
                    $this->db->trans_commit();
                    
                    /* -- Hapus semua session -- */
                    $this->session->unset_userdata('trans_beli_edit');
                    $this->cart->destroy();
                    /* -- Hapus semua session -- */
                    
                    $this->session->set_flashdata('trans_toast', 'toastr.success("Transaksi berhasil disimpan");');
                    redirect(base_url('transaksi/beli/trans_beli_edit.php?id='.general::enkrip($sql_beli->id)));
                } catch (Exception $e) {
                    # If something went wrong, rollback the transaction
                    if ($this->db->trans_status() === FALSE) {
                        $this->db->trans_rollback();
                    }
                    $this->session->set_flashdata('trans_toast', 'toastr.error("' . $e->getMessage() . '");');
                    redirect(base_url('transaksi/beli/trans_beli_edit.php?id='.$id));
                }
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!");');
            redirect();
        }
    }

    public function set_trans_beli_po_proses() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota = $this->input->post('no_nota');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
            $this->form_validation->set_rules('no_nota', 'ID', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = [
                    'no_nota' => form_error('no_nota'),
                ];

                $this->session->set_flashdata('form_error', $msg_error);
                redirect(base_url('transaksi/beli/trans_beli.php'));
            } else {                       
                // Generate new PO number
                $sql_beli = $this->db->where('YEAR(tgl_simpan)', date('Y'))
                                     ->where('MONTH(tgl_simpan)', date('m'))
                                     ->get('tbl_trans_beli_po');
                $nota_str = $sql_beli->num_rows() + 1;
                $nota     = 'PO'.date('m').date('y').sprintf('%03d', $nota_str);
          
                
                // Begin transaction
                $this->db->trans_begin();

                try {
                    // Get form ID and check for double submission
                    $form_id = $this->input->post('form_id');
                    if (check_form_submitted($form_id)) {
                        throw new Exception('Form sudah disubmit sebelumnya!');
                    }
                    
                    // Get transaction data from session
                    $trans_beli = $this->session->userdata('trans_beli_po');

                    $this->db->where('id', $trans_beli->id)->update('tbl_trans_beli_po', ['tgl_modif' => date('Y-m-d H:i:s')]);

                    // If everything is successful, commit the transaction
                    if ($this->db->trans_status() === FALSE) {
                        throw new Exception('Database transaction failed');
                    }
                    
                    $this->db->trans_commit();
                    
                    // Clean up session and cart
                    $this->cart->destroy();
                    $this->session->unset_userdata('trans_beli_po');
                    
                    $this->session->set_flashdata('trans_toast', 'toastr.success("Transaksi PO berhasil diproses!");');
                    redirect(base_url('transaksi/beli/trans_beli_po_det.php?id='.$no_nota));
                    
                } catch (Exception $e) {
                    // If something went wrong, rollback the transaction
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('trans_toast', 'toastr.error("Gagal memproses PO: ' . $e->getMessage() . '");');
                    redirect(base_url('transaksi/beli/trans_beli_po.php'));
                }
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }

    public function set_trans_beli_po_proses_upd() {
        if (akses::aksesLogin() == TRUE) {
            $id = $this->input->post('id');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id', 'ID', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = [
                    'id' => form_error('id'),
                ];

                $this->session->set_flashdata('form_error', $msg_error);

                redirect(base_url('transaksi/beli/trans_beli_po_list.php'));
            } else {
                $this->cart->destroy();
                $this->session->unset_userdata('trans_beli_po_edit');
                
                redirect(base_url('transaksi/beli/trans_beli_po_edit.php?id='.$id));
            }
        } else {
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_trans_beli_po_batal() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota  = $this->input->get('id');
            
            if(!empty($no_nota)){
                $this->session->unset_userdata('trans_beli_po');
            }
            
            redirect(base_url('transaksi/beli/trans_beli_po.php'));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
//    
//    public function cart_beli_simpan() {
//        if (akses::aksesLogin() == TRUE) {
//            $rowid    = $this->input->post('rowid');
//            $no_nota  = $this->input->post('no_nota');
//            $id_brg   = $this->input->post('id_item');
//            $satuan   = $this->input->post('satuan');
//            $kode     = $this->input->post('kode');
//            $qty      = general::format_angka_db($this->input->post('jml'));
//            $diskon1  = general::format_angka_db($this->input->post('disk1'));
//            $diskon2  = general::format_angka_db($this->input->post('disk2'));
//            $diskon3  = general::format_angka_db($this->input->post('disk3'));
//            $harga    = general::format_angka_db($this->input->post('harga'));
//            $potongan = general::format_angka_db($this->input->post('potongan'));
//
//            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
//
//            $this->form_validation->set_rules('kode', 'Kode', 'required');
//
//            if ($this->form_validation->run() == FALSE) {
//                $msg_error = array(
//                    'kode' => form_error('kode'),
//                );
//
//                $this->session->set_flashdata('form_error', $msg_error);
//
//                redirect(base_url('transaksi/trans_beli.php?id='.$no_nota));
//            } else {
//                if(!empty($rowid)){
//                    $cart = array(
//                        'rowid' => $rowid,
//                        'qty'   => 0
//                    );
//                    $this->cart->update($cart);
//                }
//                
//                $sql_brg     = $this->db->where('id', general::dekrip($id_brg))
//                                        ->get('tbl_m_produk')->row();
//                $sql_satuan  = $this->db->where('id', $sql_brg->id_satuan)->get('tbl_m_satuan')->row();
//                $trans_beli  = $this->session->userdata('trans_beli');
//                $pengaturan  = $this->db->get('tbl_pengaturan')->row();
//
//                $jml_pcs     = (!empty($sql_satuan->jml) ? $sql_satuan->jml : '1') * $qty;
//                $harga_pcs   = ($harga * $qty) / $jml_pcs;
//                $harga_sat   = $harga_pcs * $sql_satuan->jml;
//
//                $disk1       = $harga_pcs - (($diskon1 / 100) * $harga_pcs);
//                $disk2       = $disk1 - (($diskon2 / 100) * $disk1);
//                $disk3       = $disk2 - (($diskon3 / 100) * $disk2);
//
//                $harga_ppn   = ($trans_beli['status_ppn'] == '1' ? ($pengaturan->jml_ppn / 100) * $disk3 : 0);
//                $harga_tot   = $disk3 + $harga_ppn;
//                $subtotal    = ($disk3 * $jml_pcs) - $potongan;
//                $jml_qty     = general::format_angka_db($qty);
//
//                $jml_satuan  = $sql_satuan2->jml * $qty;
//
//                // Cek di keranjang
//                foreach ($this->cart->contents() as $cart){
//                    // Cek ada datanya kagak?
//                    if($sql_brg->kode == $cart['options']['kode']){
//                        $jml_subtotal      = ($cart['qty'] + $qty) * $sql_satuan->jml;
//                        $jml_qty           = ($cart['qty'] + $qty);
//
//                        $this->cart->update(array('rowid'=>$cart['rowid'], 'qty'=>0));
//                    }
//                }
//
//                $cart = array(
//                    'id'      => rand(1,1024).$sql_brg->id,
//                    'qty'     => $jml_qty,
//                    'price'   => $harga, // number_format($harga, 2, '.',','),
//                    'name'    => rtrim($sql_brg->produk),
//                    'options' => array(
//                            'no_nota'       => general::dekrip($no_nota),
//                            'id_barang'     => $sql_brg->id,
//                            'id_satuan'     => $sql_brg->id_satuan,
//                            'satuan'        => $sql_satuan->satuanTerkecil,
////                            'satuan_ket'    => ($sql_satuan->jml != 1 ? ' ('.(!empty($jml_subtotal) ? $jml_qty : $qty) * $sql_satuan->jml.' '.$sql_satuan2->satuanTerkecil.')' : ''),
//                            'jml'           => $qty,
//                            'jml_satuan'    => (!empty($sql_satuan->jml) ? $sql_satuan->jml : '1'),
//                            'kode'          => $sql_brg->kode,
//                            'harga'         => $harga_tot,
//                            'ppn'           => $harga_ppn,
//                            'potongan'      => $potongan,
//                            'disk1'         => (float)$diskon1,
//                            'disk2'         => (float)$diskon2,
//                            'disk3'         => (float)$diskon3,
//                            'subtotal'      => (float)$subtotal,
//                    )
//                );
//                
////                echo '<pre>';
////                print_r($cart);
////                echo '</pre>';
////                echo '<pre>';
////                print_r($this->cart->contents());
////                echo '</pre>';
//
//                $this->cart->insert($cart);
//                redirect(base_url('transaksi/beli/trans_beli.php?id='.$no_nota));
//            }
//        } else {
//            $errors = $this->ion_auth->messages();
//            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
//            redirect();
//        }
//    }
    
    public function cart_beli_simpan() {
        if (akses::aksesLogin() == TRUE) {
            $id       = $this->input->post('id');
            $id_det   = $this->input->post('rowid');
            $no_nota  = $this->input->post('no_nota');
            $id_brg   = $this->input->post('id_item');
            $satuan   = $this->input->post('satuan');
            $kode     = $this->input->post('kode');
            $kode2    = $this->input->post('kode_batch');
            $tgl_ed   = $this->input->post('tgl_ed');
            $qty      = general::format_angka_db($this->input->post('jml'));
            $diskon1  = general::format_angka_db($this->input->post('disk1'));
            $diskon2  = general::format_angka_db($this->input->post('disk2'));
            $diskon3  = general::format_angka_db($this->input->post('disk3'));
            $harga    = general::format_angka_db($this->input->post('harga'));
            $harga_het= general::format_angka_db($this->input->post('harga_het'));
            $potongan = general::format_angka_db($this->input->post('potongan'));

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
            $this->form_validation->set_rules('kode', 'Kode', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = [
                    'kode' => form_error('kode'),
                ];

                $this->session->set_flashdata('form_error', $msg_error);
                $this->session->set_flashdata('trans_toast', 'toastr.error("Validasi form gagal!");');
                redirect(base_url('transaksi/trans_beli.php?id='.$no_nota));
            } else {                
                try {
                    // Get form ID and check for double submission
                    $form_id = $this->input->post('form_id');
                    if (check_form_submitted($form_id)) {
                        throw new Exception('Form sudah disubmit sebelumnya!');
                    }

                    $sql_brg     = $this->db->where('id', general::dekrip($id_brg))->get('tbl_m_produk')->row();
                    $sql_satuan  = $this->db->where('id', (!empty($satuan) ? $satuan : $sql_brg->id_satuan))->get('tbl_m_satuan')->row();
                    $sql_beli    = $this->db->where('id', general::dekrip($id))->get('tbl_trans_beli')->row();
                    $trans_beli  = $this->session->userdata('trans_beli_edit');
                    $pengaturan  = $this->db->get('tbl_pengaturan')->row();

                    $jml_pcs     = (!empty($sql_satuan->jml) ? $sql_satuan->jml : '1') * $qty;
                    $harga_pcs   = ($harga * $qty) / $jml_pcs;
                    $harga_sat   = $harga_pcs * $sql_satuan->jml;

                    $disk1       = $harga_pcs - (($diskon1 / 100) * $harga_pcs);
                    $disk2       = $disk1 - (($diskon2 / 100) * $disk1);
                    $disk3       = $disk2 - (($diskon3 / 100) * $disk2);
                    $diskon      = $harga - $disk3;

                    $harga_ppn   = ($trans_beli['status_ppn'] == '1' ? ($pengaturan->jml_ppn / 100) * $disk3 : 0);
                    $harga_tot   = $disk3 + $harga_ppn;
                    $subtotal    = ($disk3 * $jml_pcs) - $potongan;
                    $jml_qty     = $qty;

                    $data_pemb_det = [
                        'id_pembelian' => (int)general::dekrip($id),
                        'id_produk'    => (int)$sql_brg->id,
                        'id_satuan'    => (int)$sql_satuan->id,
                        'no_nota'      => $sql_beli->no_nota,
                        'tgl_simpan'   => date('Y-m-d H:i:s'),
                        'tgl_ed'       => $this->tanggalan->tgl_indo_sys($tgl_ed),
                        'kode'         => $sql_brg->kode,
                        'kode_batch'   => $kode2,
                        'produk'       => $sql_brg->produk,
                        'jml'          => (float)$qty,
                        'jml_satuan'   => (int)$sql_satuan->jml,
                        'satuan'       => $sql_satuan->satuanTerkecil,
                        'keterangan'   => '',
                        'harga'        => (float)$harga,
                        'harga_het'    => (float)$harga_het,
                        'disk1'        => (float)$diskon1,
                        'disk2'        => (float)$diskon2,
                        'disk3'        => (float)$diskon3,
                        'diskon'       => (float)$diskon,
                        'potongan'     => (float)$potongan,
                        'subtotal'     => (float)$subtotal,
                    ];
                    
                    # Start Transaksi
                    $this->db->trans_start();
                    
                    # Insert into trans_beli_det table
                    $this->db->insert('tbl_trans_beli_det', $data_pemb_det);               
                    
                    # Complete Transaction
                    $this->db->trans_complete();
                    
                    if ($this->db->trans_status() === FALSE) {
                        throw new Exception("Gagal menyimpan data pembelian!");
                    }
                    
                    $this->session->set_flashdata('trans_toast', 'toastr.success("Data pembelian berhasil disimpan!");');
                    redirect(base_url('transaksi/beli/trans_beli.php?id='.$id));
                    
                } catch (Exception $e) {
                    $this->session->set_flashdata('trans_toast', 'toastr.error("' . $e->getMessage() . '");');
                    redirect(base_url('transaksi/beli/trans_beli.php?id='.$id));
                }
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!");');
            redirect();
        }
    }
    
    # Untuk menjalankan update harga untuk barang baru yang ditambahkan melalui PO
    public function cart_beli_upd() {
        if (akses::aksesLogin() == TRUE) {
            $id       = $this->input->post('id');
            $id_det   = $this->input->post('rowid');
            $no_nota  = $this->input->post('no_nota');
            $id_brg   = $this->input->post('id_item');
            $satuan   = $this->input->post('satuan');
            $kode     = $this->input->post('kode');
            $kode2    = $this->input->post('kode_batch');
            $tgl_ed   = $this->input->post('tgl_ed');
            $qty      = general::format_angka_db($this->input->post('jml'));
            $diskon1  = general::format_angka_db($this->input->post('disk1'));
            $diskon2  = general::format_angka_db($this->input->post('disk2'));
            $diskon3  = general::format_angka_db($this->input->post('disk3'));
            $harga    = general::format_angka_db($this->input->post('harga'));
            $harga_het= general::format_angka_db($this->input->post('harga_het'));
            $potongan = general::format_angka_db($this->input->post('potongan'));

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('kode', 'Kode', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = [
                    'kode' => form_error('kode'),
                ];

                $this->session->set_flashdata('form_error', $msg_error);

                redirect(base_url('transaksi/beli/trans_beli_edit.php?id='.$no_nota));
            } else {
                try {
                    // Get form ID and check for double submission
                    $form_id = $this->input->post('form_id');
                    if (check_form_submitted($form_id)) {
                        throw new Exception('Form sudah disubmit sebelumnya!');
                    }

                    $sql_brg     = $this->db->where('id', general::dekrip($id_brg))->get('tbl_m_produk')->row();
                    $sql_satuan  = $this->db->where('id', (!empty($satuan) ? $satuan : $sql_brg->id_satuan))->get('tbl_m_satuan')->row();
                    $sql_beli    = $this->db->where('id', general::dekrip($id))->get('tbl_trans_beli')->row();
                    $trans_beli  = $this->session->userdata('trans_beli_edit');
                    $pengaturan  = $this->db->get('tbl_pengaturan')->row();

                    $jml_pcs     = (!empty($sql_satuan->jml) ? $sql_satuan->jml : '1') * $qty;
                    $harga_pcs   = ($harga * $qty) / $jml_pcs;
                    $harga_sat   = $harga_pcs * $sql_satuan->jml;

                    $disk1       = $harga_pcs - (($diskon1 / 100) * $harga_pcs);
                    $disk2       = $disk1 - (($diskon2 / 100) * $disk1);
                    $disk3       = $disk2 - (($diskon3 / 100) * $disk2);
                    $diskon      = $harga - $disk3;

                    $harga_ppn   = ($trans_beli['status_ppn'] == '1' ? ($pengaturan->jml_ppn / 100) * $disk3 : 0);
                    $harga_tot   = $disk3 + $harga_ppn;
                    $subtotal    = ($disk3 * $jml_pcs) - $potongan;
                    $jml_qty     = $qty;
                    $jml_satuan  = $sql_satuan->jml * $qty;

                    $data_pemb_det = [
                        'id_pembelian' => (int)general::dekrip($id),
                        'id_produk'    => (int)$sql_brg->id,
                        'id_satuan'    => (int)$sql_satuan->id,
                        'no_nota'      => $sql_beli->no_nota,
                        'tgl_simpan'   => date('Y-m-d H:i:s'),
                        'tgl_ed'       => (!empty($tgl_ed) ? $this->tanggalan->tgl_indo_sys($tgl_ed) : '0000-00-00'),
                        'kode'         => $sql_brg->kode,
                        'kode_batch'   => $kode2,
                        'produk'       => $sql_brg->produk,
                        'jml'          => (float)$qty,
                        'jml_satuan'   => (int)$sql_satuan->jml,
                        'satuan'       => $sql_satuan->satuanTerkecil,
                        'keterangan'   => '',
                        'harga'        => (float)$harga,
                        'harga_het'    => (float)$harga_het,
                        'disk1'        => (float)$diskon1,
                        'disk2'        => (float)$diskon2,
                        'disk3'        => (float)$diskon3,
                        'diskon'       => (float)$diskon,
                        'potongan'     => (float)$potongan,
                        'subtotal'     => (float)$subtotal,
                    ];
                    
                    # Start Transaction
                    $this->db->trans_begin();
                    
                    # Update trans_beli_det table
                    $this->db->where('id', general::dekrip($id_det))->update('tbl_trans_beli_det', $data_pemb_det);             
                    
                    # Check transaction status
                    if ($this->db->trans_status() === FALSE) {
                        $this->db->trans_rollback();
                        throw new Exception("Gagal mengupdate data pembelian!");
                    }
                    
                    $this->db->trans_commit();
                    
                    $this->session->set_flashdata('trans_toast', 'toastr.success("Item : <b>'.$sql_brg->produk.'</b> berhasil diupdate!");');
                    redirect(base_url('transaksi/beli/trans_beli.php?id='.$id));
                } catch (Exception $e) {
                    $this->session->set_flashdata('trans_toast', 'toastr.error("' . $e->getMessage() . '");');
                    redirect(base_url('transaksi/beli/trans_beli.php?id='.$id));
                }
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!");');
            redirect();
        }
    }
    
    # Untuk menjalankan edit melalui trans beli edit
    public function cart_beli_upd2() {
        if (akses::aksesLogin() == TRUE) {
            $id       = $this->input->post('id');
            $id_det   = $this->input->post('rowid');
            $no_nota  = $this->input->post('no_nota');
            $id_brg   = $this->input->post('id_item');
            $satuan   = $this->input->post('satuan');
            $kode     = $this->input->post('kode');
            $kode2    = $this->input->post('kode_batch');
            $tgl_ed   = $this->input->post('tgl_ed');
            $tgl_trm  = $this->input->post('tgl_trm'); // Added missing variable
            $qty      = general::format_angka_db($this->input->post('jml'));
            $diskon1  = general::format_angka_db($this->input->post('disk1'));
            $diskon2  = general::format_angka_db($this->input->post('disk2'));
            $diskon3  = general::format_angka_db($this->input->post('disk3'));
            $harga    = general::format_angka_db($this->input->post('harga'));
            $harga_het= general::format_angka_db($this->input->post('harga_het'));
            $potongan = general::format_angka_db($this->input->post('potongan'));

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('kode', 'Kode', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = [
                    'kode' => form_error('kode'),
                ];

                $this->session->set_flashdata('form_error', $msg_error);

                redirect(base_url('transaksi/beli/trans_beli_edit.php?id='.$no_nota));
            } else {
                # Start Transaction
                $this->db->trans_begin();

                try {
                    $sql_gudang    = $this->db->where('status', '2')->get('tbl_m_gudang')->row();
                    $sql_item      = $this->db->where('id', general::dekrip($id_brg))->get('tbl_m_produk')->row();
                    $sql_item_stok = $this->db->where('id_produk', $sql_item->id)->where('id_gudang', $sql_gudang->id)->get('tbl_m_produk_stok')->row();
                    $sql_satuan    = $this->db->where('id', $sql_item->id_satuan)->get('tbl_m_satuan')->row();
                    $sql_beli      = $this->db->where('id', general::dekrip($id))->get('tbl_trans_beli')->row();
                    $sql_beli_det  = $this->db->where('id', general::dekrip($id_det))->get('tbl_trans_beli_det')->row();
                    $sql_supp      = $this->db->where('id', $sql_beli->id_supplier)->get('tbl_m_supplier')->row();
                    $trans_beli    = $this->session->userdata('trans_beli_edit');
                    $pengaturan    = $this->db->get('tbl_pengaturan')->row();

                    # Delete before update
                    if(!empty($sql_beli_det->id)){
                        $stok_awal          = $sql_item_stok->jml - $sql_beli_det->jml;
                        $stok_akhir_glob    = $this->db->select_sum('jml')->where('id_produk', $sql_item->id)->where('id_gudang', $sql_gudang->id)->get('tbl_m_produk_stok')->row()->jml - $sql_beli_det->jml;

                        $data_stok_awal = [
                            'tgl_modif'    => date('Y-m-d H:i:s'),
                            'jml'          => (float)$stok_awal,
                        ];

                        $this->db->where('id', $sql_item_stok->id)->update('tbl_m_produk_stok', $data_stok_awal);
                        $this->db->where('id', $sql_item->id)->update('tbl_m_produk', ['jml' => (float)$stok_akhir_glob]);
                        $this->db->where('id_pembelian_det', $sql_beli_det->id)->delete('tbl_m_produk_hist');
                        $this->db->where('id', $sql_beli_det->id)->delete('tbl_trans_beli_det');
                    }

                    $sql_item_stok = $this->db->where('id_produk', $sql_item->id)->where('id_gudang', $sql_gudang->id)->get('tbl_m_produk_stok')->row();
                    $stok_akhir    = $sql_item_stok->jml + ($qty * $sql_satuan->jml);

                    // Calculate quantities and prices
                    $jml_pcs       = (!empty($sql_satuan->jml) ? $sql_satuan->jml : '1') * $qty;
                    $harga_pcs     = ($harga * $qty) / $jml_pcs;
                    $harga_sat     = $harga_pcs * $sql_satuan->jml;

                    // Apply discounts
                    $disk1         = $harga_pcs - (($diskon1 / 100) * $harga_pcs);
                    $disk2         = $disk1 - (($diskon2 / 100) * $disk1);
                    $disk3         = $disk2 - (($diskon3 / 100) * $disk2);
                    $diskon        = $harga - $disk3;

                    // Calculate final prices
                    $harga_ppn     = ($trans_beli['status_ppn'] == '1' ? ($pengaturan->jml_ppn / 100) * $disk3 : 0);
                    $harga_tot     = $disk3 + $harga_ppn;
                    $subtotal      = ($disk3 * $jml_pcs) - $potongan;
                    $jml_qty       = $qty;
                    

                    $data_pemb_det = [
                        'id_pembelian' => (int)general::dekrip($id),
                        'id_produk'    => (int)$sql_item->id,
                        'id_satuan'    => (int)$sql_satuan->id,
                        'no_nota'      => $sql_beli->no_nota,
                        'tgl_simpan'   => date('Y-m-d H:i:s'),
                        'tgl_ed'       => (!empty($tgl_ed) ? $this->tanggalan->tgl_indo_sys($tgl_ed) : '0000-00-00'),
                        'kode'         => $sql_item->kode,
                        'kode_batch'   => $kode2,
                        'produk'       => $sql_item->produk,
                        'jml'          => (float)$qty,
                        'jml_satuan'   => (int)$sql_satuan->jml,
                        'satuan'       => $sql_satuan->satuanTerkecil,
                        'keterangan'   => '',
                        'harga'        => (float)$harga,
                        'harga_het'    => (float)$harga_het,
                        'disk1'        => (float)$diskon1,
                        'disk2'        => (float)$diskon2,
                        'disk3'        => (float)$diskon3,
                        'diskon'       => (float)$diskon,
                        'potongan'     => (float)$potongan,
                        'subtotal'     => (float)$subtotal,
                    ];

                    # Update product stok
                    $data_stok = [
                        'tgl_modif'    => date('Y-m-d H:i:s'),
                        'jml'          => (float)$stok_akhir,
                    ];

                    # Update product table
                    $this->db->where('id', $sql_item_stok->id)->update('tbl_m_produk_stok', $data_stok);
                                        
                    # Simpan ke tabel trans beli detail
                    $this->db->insert('tbl_trans_beli_det', $data_pemb_det);
                    $last_id = $this->db->insert_id();
                    
                    $data_brg_hist = [
                        'tgl_simpan'        => (!empty($tgl_trm) ? $this->tanggalan->tgl_indo_sys($tgl_trm) : date('Y-m-d')).' '.date('H:i:s'),
                        'tgl_masuk'         => (!empty($tgl_trm) ? $this->tanggalan->tgl_indo_sys($tgl_trm) : date('Y-m-d')),
                        'tgl_ed'            => $sql_item->tgl_ed ?? null,
                        'id_produk'         => $sql_item->id,
                        'id_user'           => $this->ion_auth->user()->row()->id,
                        'id_gudang'         => $sql_gudang->id,
                        'id_pembelian'      => $sql_beli->id,
                        'id_pembelian_det'  => $last_id,
                        'id_supplier'       => $sql_supp->id,
                        'kode'              => $sql_item->kode,
                        'kode_batch'        => $kode2,
                        'produk'            => $sql_item->produk,
                        'no_nota'           => $sql_beli->no_nota,
                        'jml'               => (float)$qty,
                        'jml_satuan'        => (int)$sql_satuan->jml,
                        'satuan'            => (!empty($sql_satuan->satuanTerkecil) ? $sql_satuan->satuanTerkecil : 'PCS'),
                        'nominal'           => $data_pemb_det['harga'],
                        'keterangan'        => 'Pembelian '.$sql_beli->no_nota,
                        'status'            => '1',
                    ];

                    # Insert into product history table
                    $this->db->insert('tbl_m_produk_hist', $data_brg_hist);

                    $stok_glob = $this->db->select_sum('jml')->where('id_produk', $sql_item->id)->where('id_gudang', $sql_gudang->id)->get('tbl_m_produk_stok')->row()->jml;
                    $this->db->where('id', $sql_item->id)->update('tbl_m_produk', ['jml' => (float)$stok_glob]);
                    
                    # Check transaction status
                    if ($this->db->trans_status() === FALSE) {
                        $this->db->trans_rollback();
                        throw new Exception("Gagal menyimpan data pembelian!");
                    }
                    
                    # Transaksi Selesai
                    $this->db->trans_commit();
                    
                    $this->session->set_flashdata('trans_toast', 'toastr.success("Item : <b>'.$sql_item->produk.'</b> berhasil disimpan!");');
                    redirect(base_url('transaksi/beli/trans_beli_edit.php?id='.$id));
                } catch (Exception $e) {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('trans_toast', 'toastr.error("' . $e->getMessage() . '");');
                    redirect(base_url('transaksi/beli/trans_beli_edit.php?id='.$id));
                }
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!");');
            redirect();
        }
    }
    
    public function cart_beli_po_simpan() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota  = $this->input->post('no_nota');
            $id_brg   = $this->input->post('id_item');
            $satuan   = $this->input->post('satuan');
            $kode     = $this->input->post('kode');
            $qty      = $this->input->post('jml');
            $ket      = $this->input->post('ket');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('kode', 'Kode', 'required');
            $this->form_validation->set_rules('id_item', 'Kode', 'required');
            $this->form_validation->set_rules('item', 'Item', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = [
                    'kode'      => form_error('kode'),
                    'id_item'   => form_error('id_item'),
                    'item'      => form_error('item'),
                ];

                $this->session->set_flashdata('form_error', $msg_error);

                redirect(base_url('transaksi/beli/trans_beli_po.php?id='.$no_nota));
            } else {                    
                $sql_barang  = $this->db->where('id', general::dekrip($id_brg))
                                        ->get('tbl_m_produk')->row();
                $sql_satuan  = $this->db->where('id', (!empty($satuan) ? $satuan : $sql_barang->id_satuan))->get('tbl_m_satuan')->row();
                $trans_beli  = $this->session->userdata('trans_beli_po');
                
                $jml_qty     = general::format_angka_db($qty);
                    
                # Begin transaction
                $this->db->trans_begin();

                try {
                    // Get form ID and check for double submission
                    $form_id = $this->input->post('form_id');
                    if (check_form_submitted($form_id)) {
                        throw new Exception('Form sudah disubmit sebelumnya!');
                    }
                    
                    $data = [
                        'id_pembelian'      => general::dekrip($no_nota),
                        'id_produk'         => $sql_barang->id,
                        'id_satuan'         => $sql_satuan->id,
                        'no_nota'           => $trans_beli['no_nota'],
                        'tgl_simpan'        => $trans_beli['tgl_simpan'],
                        'kode'              => $sql_barang->kode,
                        'produk'            => $sql_barang->produk,
                        'jml'               => (float)$jml_qty,
                        'jml_satuan'        => $sql_satuan->jml,
                        'satuan'            => $sql_satuan->satuanTerkecil,
                        'keterangan_itm'    => $ket
                    ];
                    
                    # Insert into PO detail table
                    $this->db->insert('tbl_trans_beli_po_det', $data);
                    
                    # If everything is successful, commit the transaction
                    if ($this->db->trans_status() === FALSE) {
                        throw new Exception('Database transaction failed');
                    }
                    
                    $this->db->trans_commit();
                    $this->session->set_flashdata('trans_toast', 'toastr.success("Item berhasil ditambahkan ke PO!");');
                    
                    redirect(base_url('transaksi/beli/trans_beli_po.php?id='.$no_nota));
                } catch (Exception $e) {
                    # If something went wrong, rollback the transaction
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('trans_toast', 'toastr.error("Gagal menambahkan item: ' . $e->getMessage() . '");');
                    redirect(base_url('transaksi/beli/trans_beli_po.php?id='.$no_nota));
                }
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function cart_beli_po_upd() {
        if (akses::aksesLogin() == TRUE) {
            $id       = $this->input->post('id');
            $no_nota  = $this->input->post('no_nota');
            $id_brg   = $this->input->post('id_item');
            $satuan   = $this->input->post('satuan');
            $kode     = $this->input->post('kode');
            $qty      = $this->input->post('jml');
            $ket      = $this->input->post('ket');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
            $this->form_validation->set_rules('kode', 'Kode', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = [
                    'kode' => form_error('kode'),
                ];

                $this->session->set_flashdata('form_error', $msg_error);
                $this->session->set_flashdata('trans_toast', 'toastr.error("Validasi form gagal!");');
                redirect(base_url('transaksi/trans_beli_po_edit.php?id='.$id));
            } else {
                # Begin transaction
                $this->db->trans_begin();
                
                try {
                    $sql_brg      = $this->db->where('id', general::dekrip($id_brg))->get('tbl_m_produk')->row();
                    $sql_satuan   = $this->db->where('id', $satuan)->get('tbl_m_satuan')->row();
                    $sql_po       = $this->db->where('id', general::dekrip($id))->get('tbl_trans_beli_po')->row();
                    
                    if (!$sql_brg || !$sql_satuan || !$sql_po) {
                        throw new Exception("Data tidak ditemukan!");
                    }
                    
                    $data_pemb_det = [
                        'id_pembelian' => general::dekrip($id),
                        'id_produk'    => $sql_brg->id,
                        'id_satuan'    => $sql_brg->id_satuan,
                        'no_nota'      => $sql_po->no_nota,
                        'tgl_simpan'   => date('Y-m-d H:i:s'),
                        'kode'         => $sql_brg->kode,
                        'produk'       => $sql_brg->produk,
                        'jml'          => general::format_angka_db($qty),
                        'jml_satuan'   => (int)$sql_satuan->jml,
                        'satuan'       => $sql_satuan->satuanTerkecil,
                        'keterangan'   => $ket
                    ];
                    
                    # Insert into PO detail table
                    $this->db->insert('tbl_trans_beli_po_det', $data_pemb_det);
                    
                    # If everything is successful, commit the transaction
                    if ($this->db->trans_status() === FALSE) {
                        throw new Exception('Database transaction failed');
                    }
                    
                    $this->db->trans_commit();
                    $this->session->set_flashdata('trans_toast', 'toastr.success("Item berhasil ditambahkan ke PO!");');
                    redirect(base_url('transaksi/beli/trans_beli_po_edit.php?id='.$id));
                } catch (Exception $e) {
                    # If something went wrong, rollback the transaction
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('trans_toast', 'toastr.error("Gagal menambahkan item: ' . $e->getMessage() . '");');
                    redirect(base_url('transaksi/beli/trans_beli_po_edit.php?id='.$id));
                }
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function cart_beli_hapus() {
        if (akses::aksesLogin() == TRUE) {
            $id         = $this->input->get('id');
            $id_item    = $this->input->get('item_id');
            $rute       = $this->input->get('route');

            if(!empty($id_item)){
                crud::delete('tbl_trans_beli_det', 'id', general::dekrip($id_item));
            }

            redirect(base_url((!empty($rute) ? $rute : 'transaksi/beli/trans_beli.php').'?id='.$id));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function cart_beli_upd_hapus() {
        if (akses::aksesLogin() == TRUE) {
            $id         = $this->input->get('id');
            $id_item    = $this->input->get('item_id');
            $rute       = $this->input->get('route');

            if(!empty($id_item)){
                try {
                    # Start transaction
                    $this->db->trans_begin();
                    
                    $sql_beli_det = $this->db->where('id', general::dekrip($id_item))->get('tbl_trans_beli_det')->row();
                    if (!$sql_beli_det) {
                        throw new Exception("Data item tidak ditemukan!");
                    }
                    
                    # Get product data
                    $sql_item = $this->db->where('id', $sql_beli_det->id_produk)->get('tbl_m_produk')->row();
                    if (!$sql_item) {
                        throw new Exception("Data produk tidak ditemukan!");
                    }
                    
                    # Get warehouse data
                    $sql_gudang = $this->db->where('status', '2')->get('tbl_m_gudang')->row();
                    if (!$sql_gudang) {
                        throw new Exception("Data gudang tidak ditemukan!");
                    }
                    
                    # Get product stock in warehouse
                    $sql_item_stok = $this->db->where('id_produk', $sql_item->id)
                                             ->where('id_gudang', $sql_gudang->id)
                                             ->get('tbl_m_produk_stok')
                                             ->row();
                    if (!$sql_item_stok) {
                        throw new Exception("Data stok produk tidak ditemukan!");
                    }
                    
                    # Calculate new stock after removing item
                    $stok_akhir = $sql_item_stok->jml - ($sql_beli_det->jml * $sql_beli_det->jml_satuan);
                    
                    # Update product stock in warehouse
                    $data_stok = [
                        'tgl_modif' => date('Y-m-d H:i:s'),
                        'jml'       => (float)$stok_akhir,
                    ];
                    $this->db->where('id', $sql_item_stok->id)->update('tbl_m_produk_stok', $data_stok);
                    
                    # Count global stock
                    $sql_stok = $this->db->select_sum('jml')
                                        ->where('id_produk', $sql_item->id)
                                        ->get('tbl_m_produk_stok')
                                        ->row();
                    
                    # Update product data
                    $data_brg = [
                        'tgl_modif' => date('Y-m-d H:i:s'),
                        'jml'       => (float)$sql_stok->jml,
                    ];
                    $this->db->where('id', $sql_item->id)->update('tbl_m_produk', $data_brg);
                    
                    # Delete product history record
                    $this->db->where('id_produk', $sql_item->id)
                             ->where('id_pembelian', $sql_beli_det->id_pembelian)
                             ->where('id_pembelian_det', $sql_beli_det->id)
                             ->delete('tbl_m_produk_hist');
                    
                    # Delete purchase detail record
                    $this->db->where('id', general::dekrip($id_item))->delete('tbl_trans_beli_det');
                    
                    # If everything is successful, commit the transaction
                    if ($this->db->trans_status() === FALSE) {
                        throw new Exception("Gagal menghapus item dari faktur!");
                    }
                    
                    $this->db->trans_commit();
                    
                    $this->session->set_flashdata('trans_toast', 'toastr.success("Item berhasil dihapus dari faktur!");');
                } catch (Exception $e) {
                    # If something went wrong, rollback the transaction
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('trans_toast', 'toastr.error("' . $e->getMessage() . '");');
                }
            } else {
                $this->session->set_flashdata('trans_toast', 'toastr.error("ID item tidak ditemukan!");');
            }

            redirect(base_url((!empty($rute) ? $rute : 'transaksi/beli/trans_beli_edit.php').'?id='.$id));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!");');
            redirect();
        }
    }
    
    public function cart_beli_po_hapus() {
        if (akses::aksesLogin() == TRUE) {
            $id         = $this->input->get('id');
            $id_item    = $this->input->get('item_id');
            $rute       = $this->input->get('route');

            if(!empty($id_item)){
                crud::delete('tbl_trans_beli_po_det', 'id', general::dekrip($id_item));
            }

            redirect(base_url((!empty($rute) ? $rute : 'transaksi/beli/trans_beli_po.php').'?id='.$id));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function cart_beli_po_upd_hapus() {
        if (akses::aksesLogin() == TRUE) {
            $id         = $this->input->get('id');
            $id_item    = $this->input->get('item_id');
            $rute       = $this->input->get('route');

            if(!empty($id_item)){
                crud::delete('tbl_trans_beli_po_det', 'id', general::dekrip($id_item));
            }

            redirect(base_url((!empty($rute) ? $rute : 'transaksi/beli/trans_beli_po_edit.php').'?id='.$id));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_cari_pemb() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota   = $this->input->post('no_nota');
            $lokasi    = $this->input->post('cabang');
            $tgl_trans = $this->input->post('tgl');
            $tgl_tempo = $this->input->post('tgl_tempo');
            $tgl_bayar = $this->input->post('tgl_bayar');
            $supplier  = $this->input->post('supplier');
            $sb        = $this->input->post('filter_bayar');
            $rute      = $this->input->post('route');

            redirect(base_url('transaksi/beli/index'.(!empty($rute) ? '_tempo' : '').'.php?'.(!empty($rute) ? 'route=tempo&' : '').(!empty($no_nota) ? 'filter_nota='.$no_nota : '').(!empty($lokasi) ? '&filter_lokasi='.$lokasi : '').(!empty($tgl_trans) ? '&filter_tgl='.$this->tanggalan->tgl_indo_sys($tgl_trans) : '').(!empty($tgl_tempo) ? '&filter_tgl_tempo='.$this->tanggalan->tgl_indo_sys($tgl_tempo) : '').(!empty($supplier) ? '&filter_supplier='.$supplier : '').(!empty($tgl_bayar) ? '&filter_tgl_bayar='.$this->tanggalan->tgl_indo_sys($tgl_bayar) : '').(isset($sb) && !empty($sb) ? '&filter_bayar='.$sb : '')));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function set_cari_pemb_po() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota   = $this->input->post('no_nota');
            $lokasi    = $this->input->post('cabang');
            $tgl_trans = $this->input->post('tgl');
            $tgl_tempo = $this->input->post('tgl_tempo');
            $tgl_bayar = $this->input->post('tgl_bayar');
            $supplier  = $this->input->post('supplier');
            $sb        = $this->input->post('filter_bayar');
            $rute      = $this->input->post('route');

            redirect(base_url('transaksi/beli/trans_beli_po_list'.(!empty($rute) ? '_tempo' : '').'.php?'.(!empty($rute) ? 'route=tempo&' : '').(!empty($no_nota) ? 'filter_nota='.$no_nota : '').(!empty($lokasi) ? '&filter_lokasi='.$lokasi : '').(!empty($tgl_trans) ? '&filter_tgl='.$this->tanggalan->tgl_indo_sys($tgl_trans) : '').(!empty($tgl_tempo) ? '&filter_tgl_tempo='.$this->tanggalan->tgl_indo_sys($tgl_tempo) : '').(!empty($supplier) ? '&filter_supplier='.$supplier : '').(!empty($tgl_bayar) ? '&filter_tgl_bayar='.$this->tanggalan->tgl_indo_sys($tgl_bayar) : '').(isset($sb) && !empty($sb) ? '&filter_bayar='.$sb : '')));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function json_po() {
        if (akses::aksesLogin() == TRUE) {
            $term  = $this->input->get('term');
            $sql   = $this->db->select('tbl_trans_beli_po.id, tbl_trans_beli_po.id_supplier, tbl_trans_beli_po.no_nota, tbl_m_supplier.nama AS supplier, tbl_trans_beli_po.pengiriman')
                              ->join('tbl_m_supplier','tbl_m_supplier.id=tbl_trans_beli_po.id_supplier')
                              ->like('tbl_m_supplier.nama',$term)
                              ->or_like('tbl_trans_beli_po.no_nota',$term)
                              ->limit(10)->get('tbl_trans_beli_po')->result();
            
            if(!empty($sql)){
                foreach ($sql as $sql){
                    $sql_supp = $this->db->where('id', $sql->id_supplier)->get('tbl_m_supplier')->row();
                            
                    $supp[] = array(
                        'id'            => general::enkrip($sql->id),
                        'id_supplier'   => general::enkrip($sql->id_supplier),
                        'no_nota'       => $sql->no_nota,
                        'supplier'      => $sql->supplier,
                        'alamat'        => $sql_supp->alamat,
                    );
                }
                
                if(!empty($term)){
                    echo json_encode($supp);
                }
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
            redirect();
        }
    }
    
    public function json_supplier() {
        if (akses::aksesLogin() == TRUE) {
            $term  = $this->input->get('term');
            $sql   = $this->db->select('id, kode, npwp, nama, alamat')
                              ->like('nama',$term)
                              ->or_like('kode',$term)
                              ->or_like('alamat',$term)
                              ->limit(10)->get('tbl_m_supplier')->result();
            
            if(!empty($sql)){
                foreach ($sql as $sql){
                    $produk[] = array(
                        'id'         => $sql->id,
                        'kode'       => $sql->kode,
                        'npwp'       => $sql->npwp,
                        'nama'       => $sql->nama,
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
            $sql   = $this->db->select('id, kode, produk, jml, harga_beli')
//                              ->like('kode',$term)
                              ->or_like('produk',$term)
                              ->where('status_hps','0')
                              ->limit(10)->get('tbl_m_produk')->result();
            
            if(!empty($sql)){
                foreach ($sql as $sql){
                    $produk[] = array(
                        'id'        => $sql->id,
                        'id_item'   => general::enkrip($sql->id),
                        'kode'      => $sql->kode,
                        'produk'    => $sql->produk,
                        'jml'       => (float)$sql->jml,
                        'harga_beli'=> (float)$sql->harga_beli,
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
}
