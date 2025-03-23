<?php
/**
 * Description of transaksi
 *
 * @author USER
 */
class transaksi extends CI_Controller {
    // put your code here
    function __construct() {
        parent::__construct();
        $this->load->library('cart');
        $this->load->library('excel/PHPExcel');
        $this->load->library('fpdf');
    }    

    public function trans_jual() {
        if (akses::aksesLogin() == TRUE) {
            $setting              = $this->db->get('tbl_pengaturan')->row();
            $id                   = $this->input->get('id');
            $id_produk            = $this->input->get('id_produk');
            $userid               = $this->ion_auth->user()->row()->id;

            $data['no_nota']      = general::no_nota('', 'tbl_trans_jual', 'no_nota');
            $data['kasir']        = (akses::hakKasir() == TRUE ? $this->db->where('id_user', $userid)->get('tbl_m_sales')->row()->nama : '');
            $data['kasir_id']     = (akses::hakKasir() == TRUE ? $this->db->where('id_user', $userid)->get('tbl_m_sales')->row()->id : '');
            $data['sess_jual']    = $this->session->userdata('trans_jual');
            $data['kategori']     = $this->db->get('tbl_m_kategori')->result();
            
            if(!empty($data['sess_jual'])){
                $data['sql_kategori']   = $this->db->where('id_pelanggan', $data['sess_jual']['id_pelanggan'])->where('id_kategori', $data['sess_jual']['id_kategori'])->get('tbl_m_pelanggan_diskon')->row();
                $data['sql_produk']     = $this->db->where('id', general::dekrip($id_produk))->get('tbl_m_produk')->row();
                $data['sql_penj']       = $this->db->where('id', general::dekrip($id))->get('tbl_trans_jual')->row();
                $data['sql_penj_det']   = $this->cart->contents();
                $data['sql_penj_disk']  = $this->db->where('id_pelanggan', $data['sess_jual']['id_pelanggan'])->where('kode', $data['sql_produk']->kode)->get('tbl_trans_jual_diskon')->row();
                $data['sql_sales']      = $this->db->where('id', $data['sess_jual']['id_sales'])->get('tbl_m_sales')->row();
                $data['sql_customer']   = $this->db->where('id', $data['sess_jual']['id_pelanggan'])->get('tbl_m_pelanggan')->row();
                $data['sql_satuan']     = $this->db->where('id', $data['sql_produk']->id_satuan)->get('tbl_m_satuan')->row();
                $data['sql_produk']  	= $this->db->where('id', general::dekrip($id_produk))->get('tbl_m_produk')->row();
                $data['sql_produk_nom']	= $this->db->where('id_produk', general::dekrip($id_produk))->get('tbl_m_produk_nominal')->result();
                $data['sql_produk_sat']	= $this->db->where('id_produk', general::dekrip($id_produk))->where('jml !=', '0')->order_by('jml', 'desc')->get('tbl_m_produk_satuan')->result();
            }
            
            $this->load->view('admin-lte-2/1_atas',$data);
            $this->load->view('admin-lte-2/2_header',$data);
            $this->load->view('admin-lte-2/includes/trans/trans_jual',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
            
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    } 

    public function trans_jual_umum() {
        if (akses::aksesLogin() == TRUE) {
            $setting              = $this->db->get('tbl_pengaturan')->row();
            $id                   = $this->input->get('id');
            $id_produk            = $this->input->get('id_produk');
            $retur                = $this->input->get('retur');
            $no_retur             = $this->input->get('no_retur');
            $token                = $this->input->get('token');
            $id_kasir             = $this->ion_auth->user()->row()->id;
            
            $data['draft']        = $this->db->where('status_nota', '4')->where('id_user', $id_kasir)->where('tgl_masuk', date('Y-m-d'))->get('tbl_trans_jual')->result();
            $data['no_nota']      = general::no_nota('', 'tbl_trans_jual', 'no_nota');
            $data['sess_jual']    = $this->session->userdata('trans_jual_umum');
            $data['sess_pot']     = $this->session->userdata('sess_retur_pot'); 
            $data['kategori']     = $this->db->get('tbl_m_kategori')->result();
            
            if($token == '1'){
                $sess_ret = array(
                    'id_retur'  => $no_retur,
                    'jml_retur' => $retur,
                );
                
                $this->session->set_userdata('sess_retur_pot', $sess_ret);
                
                redirect(base_url('transaksi/trans_jual_umum.php?id='.$id.'&retur='.$retur.'&no_retur='.$no_retur));
            }
            
            if(!empty($data['sess_jual'])){
                $data['sql_kategori']   = $this->db->where('id_pelanggan', $data['sess_jual']['id_pelanggan'])->where('id_kategori', $data['sess_jual']['id_kategori'])->get('tbl_m_pelanggan_diskon')->row();
                $data['sql_produk']     = $this->db->where('id', general::dekrip($id_produk))->get('tbl_m_produk')->row();
                $data['sql_penj']       = $this->db->where('id', general::dekrip($id))->get('tbl_trans_jual')->row();
                $data['sql_penj_det']   = $this->cart->contents();
                $data['sql_penj_disk']  = $this->db->where('id_pelanggan', $data['sess_jual']['id_pelanggan'])->where('kode', $data['sql_produk']->kode)->get('tbl_trans_jual_diskon')->row();
                $data['sql_sales']      = $this->db->where('id', $data['sess_jual']['id_sales'])->get('tbl_m_sales')->row();
                $data['sql_customer']   = $this->db->where('id', $data['sess_jual']['id_pelanggan'])->get('tbl_m_pelanggan')->row();
                $data['sql_satuan']     = $this->db->where('id', $data['sql_produk']->id_satuan)->get('tbl_m_satuan')->row();
                $data['sql_produk']  	= $this->db->where('id', general::dekrip($id_produk))->get('tbl_m_produk')->row();
                $data['sql_produk_nom']	= $this->db->where('id_produk', general::dekrip($id_produk))->get('tbl_m_produk_nominal')->result();
                $data['sql_produk_sat']	= $this->db->where('id_produk', general::dekrip($id_produk))->where('jml !=', '0')->where('harga !=', '0')->order_by('jml','asc')->get('tbl_m_produk_satuan')->result();
                $data['sql_platform']   = $this->db->get('tbl_m_platform')->result();
                
                $data['ppn']          = ($data['sess_jual']['status_ppn'] == 1 ? $setting->jml_ppn : 0);
//                $data['jml_ppn']      = ($data['sess_jual']['status_ppn'] == 1 ? ($setting->jml_ppn / 100) * $this->cart->total() : 0);
//                $data['jml_subtotal'] = $this->cart->total();
//                $data['jml_gtotal']   = $this->cart->total() + (($setting->jml_ppn / 100) * $this->cart->total());
            }
            
            $this->load->view('admin-lte-2/1_atas',$data);
            $this->load->view('admin-lte-2/2_header',$data);
            $this->load->view('admin-lte-2/includes/trans/trans_jual_umum',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
            
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    } 

    public function trans_jual_umum_draft() {
        if (akses::aksesLogin() == TRUE) {
            $setting              = $this->db->get('tbl_pengaturan')->row();
            $id                   = $this->input->get('id');
            $id_produk            = $this->input->get('id_produk');
            $id_kasir             = $this->ion_auth->user()->row()->id;
            $retur                = $this->input->get('retur');
            $no_retur             = $this->input->get('no_retur');
            $token                = $this->input->get('token');
            
            if($token == '1'){
                $sess_ret = array(
                    'id_retur'  => $no_retur,
                    'jml_retur' => $retur,
                );
                
                $this->session->set_userdata('sess_retur_pot', $sess_ret);
                
                redirect(base_url('transaksi/trans_jual_umum_draft.php?id='.$id.'&retur='.$retur.'&no_retur='.$no_retur));
            }
            
            $data['draft']        = $this->db->where('status_nota', '4')->where('id_user', $id_kasir)->where('tgl_masuk', date('Y-m-d'))->get('tbl_trans_jual')->result();            
            $data['no_nota']      = $id;
            $data['kategori']     = $this->db->get('tbl_m_kategori')->result();
            $data['sess_pot']     = $this->session->userdata('sess_retur_pot'); 
                                    
            if(!empty($id)){
                $data['sql_kategori']   = $this->db->where('id_pelanggan', $data['sql_penj']->id_pelanggan)->where('id_kategori', $data['sess_jual']['id_kategori'])->get('tbl_m_pelanggan_diskon')->row();
                $data['sql_produk']     = $this->db->where('id', general::dekrip($id_produk))->get('tbl_m_produk')->row();
                $data['sql_penj']       = $this->db->where('id', general::dekrip($id))->get('tbl_trans_jual')->row();
                $data['sql_penj_det']   = $this->db->where('id_penjualan', general::dekrip($id))->get('tbl_trans_jual_det')->result();;
                $data['sql_penj_disk']  = $this->db->where('id_pelanggan', $data['sess_jual']['id_pelanggan'])->where('kode', $data['sql_produk']->kode)->get('tbl_trans_jual_diskon')->row();
                $data['sql_sales']      = $this->db->where('id', $data['sql_penj']->id_sales)->get('tbl_m_sales')->row();
                $data['sql_customer']   = $this->db->where('id', $data['sql_penj']->id_pelanggan)->get('tbl_m_pelanggan')->row();
                $data['sql_satuan']     = $this->db->where('id', $data['sql_produk']->id_satuan)->get('tbl_m_satuan')->row();
                $data['sql_produk']  	= $this->db->where('id', general::dekrip($id_produk))->get('tbl_m_produk')->row();
                $data['sql_produk_nom']	= $this->db->where('id_produk', general::dekrip($id_produk))->get('tbl_m_produk_nominal')->result();
                $data['sql_produk_sat']	= $this->db->where('id_produk', general::dekrip($id_produk))->where('jml !=', '0')->where('harga !=', '0')->order_by('jml','asc')->get('tbl_m_produk_satuan')->result();
                $data['sql_platform']   = $this->db->get('tbl_m_platform')->result();
                
                $data['ppn']          = ($data['sess_jual']['status_ppn'] == 1 ? $setting->jml_ppn : 0);
            }
            
            $this->load->view('admin-lte-2/1_atas',$data);
            $this->load->view('admin-lte-2/2_header',$data);
            $this->load->view('admin-lte-2/includes/trans/trans_jual_umum_draft',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
            
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    } 

    public function trans_jual_pen() {
        if (akses::aksesLogin() == TRUE) {
            $setting              = $this->db->get('tbl_pengaturan')->row();
            $id                   = $this->input->get('id');
            $id_produk            = $this->input->get('id_produk');
            
            $data['no_nota']      = general::no_nota('', 'tbl_trans_jual_pen', 'no_nota');
            $data['sess_jual']    = $this->session->userdata('trans_jual_pen');
            $data['kategori']     = $this->db->get('tbl_m_kategori')->result();
            
            if(!empty($data['sess_jual'])){
                $data['sql_produk']     = $this->db->where('id', general::dekrip($id_produk))->get('tbl_m_produk')->row();
                $data['sql_produk_sat'] = $this->db->where('id_produk', general::dekrip($id_produk))->get('tbl_m_produk_satuan')->result();
                $data['sql_penj']       = $this->db->select()->where('no_nota', general::dekrip($id))->get('tbl_trans_jual_pen')->row();
                $data['sql_penj_det']   = $this->db->select()->where('no_nota', general::dekrip($id))->get('tbl_trans_jual_pen_det')->result();
                $data['sql_penj_disk']  = $this->db->where('id_pelanggan', $data['sess_jual']['id_pelanggan'])->where('kode', $data['sql_produk']->kode)->get('tbl_trans_jual_diskon')->row();
                $data['sql_sales']      = $this->db->where('id', $data['sess_jual']['id_sales'])->get('tbl_m_sales')->row();
                $data['sql_customer']   = $this->db->where('id', $data['sess_jual']['id_pelanggan'])->get('tbl_m_pelanggan')->row();
                $data['sql_satuan']     = $this->db->where('id', $data['sql_produk']->id_satuan)->get('tbl_m_satuan')->row();
                $data['sql_platform']   = $this->db->get('tbl_m_platform')->result();
                
                $data['ppn']          = ($data['sess_jual']['status_ppn'] == 1 ? $setting->jml_ppn : 0);
                $data['jml_ppn']      = ($data['sess_jual']['status_ppn'] == 1 ? ($setting->jml_ppn / 100) * $this->cart->total() : 0);
                $data['jml_subtotal'] = $this->cart->total();
                $data['jml_gtotal']   = $this->cart->total() + (($setting->jml_ppn / 100) * $this->cart->total());
            }
            
            $this->load->view('admin-lte-2/1_atas',$data);
            $this->load->view('admin-lte-2/2_header',$data);
            $this->load->view('admin-lte-2/includes/trans/trans_jual_pen',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
            
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    } 

    public function trans_jual_edit() {
        if (akses::aksesLogin() == TRUE) {
            $setting              = $this->db->get('tbl_pengaturan')->row();
            $id                   = $this->input->get('id');
            $id_produk            = $this->input->get('id_produk');
            $kd_produk            = $this->input->get('kd_produk');
            
            $data['no_nota']      = general::no_nota('', 'tbl_trans_jual', 'no_nota');
            $data['sess_jual']    = $this->session->userdata('trans_jual_upd');
            $data['kategori']     = $this->db->get('tbl_m_kategori')->result();
            
            if(isset($_GET['id'])){
                $data['sql_kategori']   = $this->db->where('id_pelanggan', $data['sess_jual']['id_pelanggan'])->where('id_kategori', $data['sess_jual']['id_kategori'])->get('tbl_m_pelanggan_diskon')->row();
                $data['sql_produk']     = $this->db->where('id', general::dekrip($id_produk))->get('tbl_m_produk')->row();
                $data['sql_penj']       = $this->db->where('id', general::dekrip($id))->get('tbl_trans_jual')->row();
                $data['sql_penj_det']   = $this->db->where('id_penjualan', general::dekrip($id))->get('tbl_trans_jual_det')->result();
                $data['sql_penj_disk']  = $this->db->where('id_pelanggan', $data['sess_jual']['id_pelanggan'])->where('kode', $data['sql_produk']->kode)->get('tbl_trans_jual_diskon')->row();
                $data['sql_sales']      = $this->db->where('id', $data['sql_penj']->id_sales)->get('tbl_m_sales')->row();
                $data['sql_customer']   = $this->db->where('id', $data['sql_penj']->id_pelanggan)->get('tbl_m_pelanggan')->row();
                $data['sql_satuan']     = $this->db->where('id', $data['sql_produk']->id_satuan)->get('tbl_m_satuan')->row();
                $data['sql_produk']  	= $this->db->where('id', general::dekrip($id_produk))->get('tbl_m_produk')->row();
                $data['sql_produk2']	= $this->db->where('kode', general::dekrip($kd_produk))->get('tbl_m_produk')->row();
                $data['sql_produk_nom']	= $this->db->where('id_produk', general::dekrip($id_produk))->get('tbl_m_produk_nominal')->result();
                $data['sql_produk_sat']	= $this->db->where('id_produk', general::dekrip($id_produk))->where('jml !=', '0')->order_by('jml', 'desc')->get('tbl_m_produk_satuan')->result();
                $data['sql_produk_sat2']= $this->db->where('id_produk', $data['sql_produk2']->id)->where('jml !=', '0')->order_by('jml', 'desc')->get('tbl_m_produk_satuan')->result();
            }
            
            $this->load->view('admin-lte-2/1_atas',$data);
            $this->load->view('admin-lte-2/2_header',$data);
            $this->load->view('admin-lte-2/includes/trans/trans_jual_edit',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
            
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    } 

    public function trans_jual_det() {
        if (akses::aksesLogin() == TRUE) {
            $setting               = $this->db->get('tbl_pengaturan')->row();
            $id                    = $this->input->get('id');
            
            $data['sql_penj']      = $this->db->where('id', general::dekrip($id))->get('tbl_trans_jual')->row();
            $data['sql_penj_det']  = $this->db->where('id_penjualan', $data['sql_penj']->id)->get('tbl_trans_jual_det')->result();
            $data['sql_penj_plat'] = $this->db->select('DATE(tgl_simpan) as tgl_simpan, HOUR(tgl_simpan) as jam, MINUTE(tgl_simpan) as menit, id, id_platform, platform, keterangan, nominal')->where('id_penjualan', $data['sql_penj']->id)->get('tbl_trans_jual_plat')->result();
            $data['sql_sales']     = $this->db->where('id', $data['sql_penj']->id_sales)->get('tbl_m_sales')->row();

            $this->load->view('admin-lte-2/1_atas',$data);
            $this->load->view('admin-lte-2/2_header',$data);
            $this->load->view('admin-lte-2/includes/trans/trans_jual_det',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function trans_jual_pen_det() {
        if (akses::aksesLogin() == TRUE) {
            $setting               = $this->db->get('tbl_pengaturan')->row();
            $id                    = $this->input->get('id');
            
            $data['sql_penj']      = $this->db->where('no_nota', general::dekrip($id))->get('tbl_trans_jual_pen')->row();
            $data['sql_penj_det']  = $this->db->where('no_nota', $data['sql_penj']->no_nota)->get('tbl_trans_jual_pen_det')->result();
            $data['sql_sales']     = $this->db->where('id', $data['sql_penj']->id_sales)->get('tbl_m_sales')->row();

            $this->load->view('admin-lte-2/1_atas',$data);
            $this->load->view('admin-lte-2/2_header',$data);
            $this->load->view('admin-lte-2/includes/trans/trans_jual_pen_det',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function trans_jual_hapus() {
        if (akses::aksesLogin() == TRUE) {
            $id    = $this->input->get('id');
            $rute  = $this->input->get('route');
            
            if(!empty($id)){
                $sql_nota = $this->db->where('id', general::dekrip($id))->get('tbl_trans_jual')->row();
                $nota     = $sql_nota->no_nota.'/'.$sql_nota->kode_nota_blk;
                $sql_mut  = $this->db->where('no_nota', $sql_nota->no_nota)->get('tbl_m_produk_hist')->result();
                $sql_kas  = $this->db->where('keterangan', 'Penjualan '.$nota)->get('tbl_akt_kas')->row();
                
                foreach ($sql_mut as $mutasi){
                    $sql_prod = $this->db->where('id', $mutasi->id_produk)->get('tbl_m_produk')->row();
                    $sql_stok = $this->db->where('id_produk', $mutasi->id_produk)->where('id_gudang', $mutasi->id_gudang)->get('tbl_m_produk_stok')->row();
                    $stok     = $sql_stok->jml + ($mutasi->jml * $mutasi->jml_satuan);

                    crud::update('tbl_m_produk_stok', 'id', $sql_stok->id, array('tgl_modif'=>date('Y-m-d H:i:s'), 'jml'=>$stok));
                    crud::delete('tbl_m_produk_hist','id', $mutasi->id);
                }
                
                $tot_stok = $this->db->select_sum('jml')->where('id_produk', $mutasi->id_produk)->get('tbl_m_produk_stok')->row()->jml;
                crud::update('tbl_m_produk', 'id', $mutasi->id_produk, array('tgl_modif'=>date('Y-m-d H:i:s'), 'jml'=>$tot_stok));
                crud::delete('tbl_akt_kas','id',$sql_kas->id);
                crud::delete('tbl_trans_jual','id',general::dekrip($id));
            }
            
            redirect(base_url('transaksi/'.(!empty($rute) ? $rute : 'data_penj_list.php')));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function trans_retur_jual() {
        if (akses::aksesLogin() == TRUE) {
            $setting                    = $this->db->get('tbl_pengaturan')->row();
            $id                         = $this->input->get('id');
            $id_produk                  = $this->input->get('id_produk');
            $no_nota                    = $this->input->get('no_nota');
            
            $data['no_nota']            = general::no_nota('', 'tbl_trans_jual', 'no_nota');
            $data['sess_ret_jual']      = $this->session->userdata('trans_retur_jual');
            
            $data['sql_produk']         = $this->db->where('id', general::dekrip($id_produk))->get('tbl_m_produk')->row();
            $data['sql_penj']           = $this->db->where('id', general::dekrip($no_nota))->get('tbl_trans_jual')->row();
            $data['sql_penj_det']       = $this->db->where('id_penjualan', general::dekrip($no_nota))->get('tbl_trans_jual_det')->result();
            $data['sql_penj_det_row']   = $this->db->where('id_penjualan', general::dekrip($no_nota))->where('kode', $data['sql_produk']->kode)->get('tbl_trans_jual_det')->row();
            $data['sql_sales']          = $this->db->where('id', $data['sql_penj']->id_sales)->get('tbl_m_sales')->row();
            $data['sql_pelanggan']      = $this->db->where('id', $data['sql_penj']->id_pelanggan)->get('tbl_m_pelanggan')->row();
            $data['sql_pelanggan_disk'] = $this->db->where('id_pelanggan', $data['sql_pelanggan']->id)->where('id_kategori', $data['sql_pelanggan']->id_kategori)->get('tbl_m_pelanggan_diskon')->row();
            $data['sql_satuan']         = $this->db->where('id', $data['sql_produk']->id_satuan)->get('tbl_m_satuan')->row();
            $data['sql_produk_sat']	= $this->db->where('id_produk', general::dekrip($id_produk))->where('jml !=', 0)->order_by('jml', 'asc')->get('tbl_m_produk_satuan')->result();

            $data['harga_bl_sat']       = $data['sql_penj_det_row']->harga; //$data['sql_penj_det_row']->subtotal / ($data['sql_penj_det_row']->jml * $data['sql_penj_det_row']->jml_satuan);
            
            $data['sql_ret ']           = $this->db->where('id', general::dekrip($id))->get('tbl_trans_retur_jual')->row();
            $data['sql_ret_det']        = $this->db->where('id_retur_jual', general::dekrip($id))->get('tbl_trans_retur_jual_det')->result();
            
            $this->load->view('admin-lte-2/1_atas',$data);
            $this->load->view('admin-lte-2/2_header',$data);
            $this->load->view('admin-lte-2/includes/trans/trans_retur_jual',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function trans_retur_jual_det() {
        if (akses::aksesLogin() == TRUE) {
            $setting               = $this->db->get('tbl_pengaturan')->row();
            $id                    = $this->input->get('id');
            
            $data['sql_ret']      = $this->db->select('DATE(tgl_simpan) as tgl_simpan, id, no_retur, no_nota, id_pelanggan, jml_retur')->where('id', general::dekrip($id))->get('tbl_trans_retur_jual')->row();
            $data['sql_ret_det']  = $this->db->where('id_retur_jual', $data['sql_ret']->id)->get('tbl_trans_retur_jual_det')->result();
            $data['sql_sales']     = $this->db->where('id', $data['sql_penj']->id_sales)->get('tbl_m_sales')->row();

            $this->load->view('admin-lte-2/1_atas',$data);
            $this->load->view('admin-lte-2/2_header',$data);
            $this->load->view('admin-lte-2/includes/trans/trans_retur_jual_det',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }    
    
    public function trans_retur_beli() {
        if (akses::aksesLogin() == TRUE) {
            $setting                    = $this->db->get('tbl_pengaturan')->row();
            $id                         = $this->input->get('id');
            $no_nota                    = $this->input->get('no_nota');
            $id_produk                  = $this->input->get('id_produk');
            
            $data['no_nota']            = general::no_nota('', 'tbl_trans_jual', 'no_nota');
            $data['sess_ret_beli']      = $this->session->userdata('trans_retur_beli');
            
            $data['sql_produk']         = $this->db->where('id', general::dekrip($id_produk))->get('tbl_m_produk')->row();
            $data['sql_satuan']         = $this->db->where('id', $data['sql_produk']->id_satuan)->get('tbl_m_satuan')->row();
            $data['sql_pemb']           = $this->db->where('id', general::dekrip($no_nota))->get('tbl_trans_beli')->row();
            $data['sql_pemb_det']       = $this->db->where('id_pembelian', general::dekrip($no_nota))->get('tbl_trans_beli_det')->result();
            $data['sql_pemb_det_row']   = $this->db->where('id_pembelian', general::dekrip($no_nota))->where('kode', $data['sql_produk']->kode)->get('tbl_trans_beli_det')->row();
            $data['sql_supplier']       = $this->db->where('id', $data['sql_pemb']->id_supplier)->get('tbl_m_supplier')->row();
            $data['sql_pelanggan_disk'] = $this->db->where('id_pelanggan', $data['sql_pelanggan']->id)->where('id_kategori', $data['sql_pelanggan']->id_kategori)->get('tbl_m_pelanggan_diskon')->row();
            $data['sql_produk_sat']	= $this->db->where('id_produk', general::dekrip($id_produk))->where('jml !=', '0')->order_by('jml', 'asc')->get('tbl_m_produk_satuan')->result();
            $data['hrg_satuan']         = $data['sql_pemb_det_row']->harga / $data['sql_pemb_det_row']->jml_satuan;
            
            $data['sql_ret']            = $this->db->where('id', general::dekrip($id))->get('tbl_trans_retur_beli')->row();
            $data['sql_ret_det']        = $this->db->where('id_retur_beli', general::dekrip($id))->get('tbl_trans_retur_beli_det')->result();
            
            $this->load->view('admin-lte-2/1_atas',$data);
            $this->load->view('admin-lte-2/2_header',$data);
            $this->load->view('admin-lte-2/includes/trans/trans_retur_beli',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function trans_retur_beli_det() {
        if (akses::aksesLogin() == TRUE) {
            $setting               = $this->db->get('tbl_pengaturan')->row();
            $id                    = $this->input->get('id');
            
            $data['sql_ret']       = $this->db->select('DATE(tgl_simpan) as tgl_simpan, id, no_retur, no_nota, id_pelanggan, jml_retur')->where('id', general::dekrip($id))->get('tbl_trans_retur_beli')->row();
            $data['sql_ret_det']   = $this->db->where('id_retur_beli', $data['sql_ret']->id)->get('tbl_trans_retur_beli_det')->result();
            $data['sql_sales']     = $this->db->where('id', $data['sql_penj']->id_sales)->get('tbl_m_sales')->row();

            $this->load->view('admin-lte-2/1_atas',$data);
            $this->load->view('admin-lte-2/2_header',$data);
            $this->load->view('admin-lte-2/includes/trans/trans_retur_beli_det',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function trans_beli() {
        if (akses::aksesLogin() == TRUE) {
            $setting              = $this->db->get('tbl_pengaturan')->row();
            $id                   = $this->input->get('id');
            $id_produk            = $this->input->get('id_produk');
            
            $data['sess_beli']    = $this->session->userdata('trans_beli');
            
            
            if(!empty($data['sess_beli'])){
                $data['sql_penj']       = $this->db->where('no_nota', general::dekrip($id))->get('tbl_trans_jual')->row();
                $data['sql_pemb_det']   = $this->cart->contents();
                $data['sql_supplier']   = $this->db->where('id', $data['sess_beli']['id_supplier'])->get('tbl_m_supplier')->row();
                $data['sql_produk']     = $this->db->where('id', general::dekrip($id_produk))->get('tbl_m_produk')->row();
                $data['sql_produk_sat'] = $this->db->where('id_produk', general::dekrip($id_produk))->get('tbl_m_produk_satuan')->result();
                $data['sql_satuan']     = $this->db->where('id', $data['sql_produk']->id_satuan)->get('tbl_m_satuan')->row();
                $data['sql_produk_sat']	= $this->db->where('id_produk', general::dekrip($id_produk))->get('tbl_m_produk_satuan')->result();
            }

            $this->load->view('admin-lte-2/1_atas',$data);
            $this->load->view('admin-lte-2/2_header',$data);
            $this->load->view('admin-lte-2/includes/trans/trans_beli',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function trans_beli_po() {
        if (akses::aksesLogin() == TRUE) {
            $setting              = $this->db->get('tbl_pengaturan')->row();
            $id                   = $this->input->get('id');
            $id_produk            = $this->input->get('id_produk');
            
            $data['sess_beli']    = $this->session->userdata('trans_beli_po');
            
            
            if(!empty($data['sess_beli'])){
//                $data['sql_penj']     = $this->db->where('no_nota', general::dekrip($id))->get('tbl_trans_jual')->row();
                $data['sql_pemb_det'] = $this->db->where('id_pembelian', general::dekrip($id))->get('tbl_trans_beli_po_det')->result();
                $data['sql_supplier'] = $this->db->where('id', $data['sess_beli']['id_supplier'])->get('tbl_m_supplier')->row();
                $data['sql_produk']     = $this->db->where('id', general::dekrip($id_produk))->get('tbl_m_produk')->row();
                $data['sql_produk_sat'] = $this->db->where('id_produk', general::dekrip($id_produk))->get('tbl_m_produk_satuan')->result();
                $data['sql_satuan']     = $this->db->where('id', $data['sql_produk']->id_satuan)->get('tbl_m_satuan')->row();
                $data['sql_produk_sat']	= $this->db->where('id_produk', general::dekrip($id_produk))->get('tbl_m_produk_satuan')->result();
            }

            $this->load->view('admin-lte-2/1_atas',$data);
            $this->load->view('admin-lte-2/2_header',$data);
            $this->load->view('admin-lte-2/includes/trans/trans_beli_po',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function trans_beli_edit() {
        if (akses::aksesLogin() == TRUE) {
            $setting              = $this->db->get('tbl_pengaturan')->row();
            $id                   = $this->input->get('id');
            $id_produk            = $this->input->get('id_produk');
            $kd_produk            = $this->input->get('kd_produk');
            
//            $data['no_nota']      = general::no_nota('', 'tbl_trans_beli', 'no_nota');
            $data['sess_beli']    = $this->session->userdata('trans_beli_upd');
//            $data['kategori']     = $this->db->get('tbl_m_kategori')->result();
            
            if(isset($_GET['id'])){
                $data['sql_produk']      = $this->db->where('id', general::dekrip($id_produk))->get('tbl_m_produk')->row();
                $data['sql_beli']        = $this->db->where('id', general::dekrip($id))->get('tbl_trans_beli')->row();
                $data['sql_beli_det']    = $this->db->where('id_pembelian', $data['sql_beli']->id)->get('tbl_trans_beli_det')->result();
                $data['sql_beli_plat']   = $this->db->select('id, DATE(tgl_simpan) as tgl_simpan, HOUR(tgl_simpan) as jam, MINUTE(tgl_simpan) as menit, id_platform, platform, nominal, keterangan')->where('tbl_trans_beli_plat.id_pembelian', $data['sql_beli']->id)->get('tbl_trans_beli_plat')->result();
                $data['sql_supplier']    = $this->db->where('id', $data['sql_beli']->id_supplier)->get('tbl_m_supplier')->row();
                $data['sql_satuan']      = $this->db->where('id', $data['sql_produk']->id_satuan)->get('tbl_m_satuan')->row();
                $data['sql_produk_sat']  = $this->db->where('id_produk', general::dekrip($id_produk))->get('tbl_m_produk_satuan')->result();
                $data['sql_produk_sat2'] = $this->db->where('id_produk', general::dekrip($kd_produk))->get('tbl_m_produk_satuan')->result();
            }
//            echo '<pre>';
//            print_r($data['sql_produk']);
//            echo '</pre>';
            
            $this->load->view('admin-lte-2/1_atas',$data);
            $this->load->view('admin-lte-2/2_header',$data);
            $this->load->view('admin-lte-2/includes/trans/trans_beli_edit',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
            
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    } 
    
    public function trans_beli_edit_po() {
        if (akses::aksesLogin() == TRUE) {
            $setting              = $this->db->get('tbl_pengaturan')->row();
            $id                   = $this->input->get('id');
            $id_produk            = $this->input->get('id_produk');
            $kd_produk            = $this->input->get('kd_produk');
            
//            $data['no_nota']      = general::no_nota('', 'tbl_trans_beli', 'no_nota');
            $data['sess_beli']    = $this->session->userdata('trans_beli_po_upd');
//            $data['kategori']     = $this->db->get('tbl_m_kategori')->result();
            
            if(isset($_GET['id'])){
                $data['sql_produk']      = $this->db->where('id', general::dekrip($id_produk))->get('tbl_m_produk')->row();
                $data['sql_beli']        = $this->db->where('id', general::dekrip($id))->get('tbl_trans_beli_po')->row();
                $data['sql_beli_det']    = $this->db->where('id_pembelian', $data['sql_beli']->id)->get('tbl_trans_beli_po_det')->result();
                $data['sql_beli_plat']   = $this->db->select('id, DATE(tgl_simpan) as tgl_simpan, HOUR(tgl_simpan) as jam, MINUTE(tgl_simpan) as menit, id_platform, platform, nominal, keterangan')->where('tbl_trans_beli_plat.id_pembelian', $data['sql_beli']->id)->get('tbl_trans_beli_plat')->result();
                $data['sql_supplier']    = $this->db->where('id', $data['sql_beli']->id_supplier)->get('tbl_m_supplier')->row();
                $data['sql_satuan']      = $this->db->where('id', $data['sql_produk']->id_satuan)->get('tbl_m_satuan')->row();
                $data['sql_produk_sat']  = $this->db->where('id_produk', general::dekrip($id_produk))->get('tbl_m_produk_satuan')->result();
                $data['sql_produk_sat2'] = $this->db->where('id_produk', general::dekrip($kd_produk))->get('tbl_m_produk_satuan')->result();
            }
//            echo '<pre>';
//            print_r($data['sql_produk']);
//            echo '</pre>';
            
            $this->load->view('admin-lte-2/1_atas',$data);
            $this->load->view('admin-lte-2/2_header',$data);
            $this->load->view('admin-lte-2/includes/trans/trans_beli_edit_po',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
            
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    } 
    
    public function trans_beli_edit_ppn() {
        if (akses::aksesLogin() == TRUE) {
            $setting              = $this->db->get('tbl_pengaturan')->row();
            $id                   = $this->input->get('id');
            $id_produk            = $this->input->get('id_produk');
            $kd_produk            = $this->input->get('kd_produk');
            
//            $data['no_nota']      = general::no_nota('', 'tbl_trans_beli', 'no_nota');
            $data['sess_beli']    = $this->session->userdata('trans_beli_upd');
//            $data['kategori']     = $this->db->get('tbl_m_kategori')->result();
            
            if(isset($_GET['id'])){
                $data['sql_produk']      = $this->db->where('id', general::dekrip($id_produk))->get('tbl_m_produk')->row();
                $data['sql_beli']        = $this->db->where('id', general::dekrip($id))->get('tbl_trans_beli')->row();
                $data['sql_beli_det']    = $this->db->where('id_pembelian', $data['sql_beli']->id)->get('tbl_trans_beli_det')->result();
                $data['sql_beli_plat']   = $this->db->select('id, DATE(tgl_simpan) as tgl_simpan, HOUR(tgl_simpan) as jam, MINUTE(tgl_simpan) as menit, id_platform, platform, nominal, keterangan')->where('tbl_trans_beli_plat.id_pembelian', $data['sql_beli']->id)->get('tbl_trans_beli_plat')->result();
                $data['sql_supplier']    = $this->db->where('id', $data['sql_beli']->id_supplier)->get('tbl_m_supplier')->row();
                $data['sql_satuan']      = $this->db->where('id', $data['sql_produk']->id_satuan)->get('tbl_m_satuan')->row();
                $data['sql_produk_sat']  = $this->db->where('id_produk', general::dekrip($id_produk))->get('tbl_m_produk_satuan')->result();
                $data['sql_produk_sat2'] = $this->db->where('id_produk', general::dekrip($kd_produk))->get('tbl_m_produk_satuan')->result();
            }
//            echo '<pre>';
//            print_r($this->session->all_userdata());
//            echo '</pre>';
            
            $this->load->view('admin-lte-2/1_atas',$data);
            $this->load->view('admin-lte-2/2_header',$data);
            $this->load->view('admin-lte-2/includes/trans/trans_beli_edit',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
            
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    } 
    
    public function trans_beli_det() {
        if (akses::aksesLogin() == TRUE) {
            $setting               = $this->db->get('tbl_pengaturan')->row();
            $id                    = $this->input->get('id');
            
            $data['sql_beli']      = $this->db->where('id', general::dekrip($id))->get('tbl_trans_beli')->row();
            $data['sql_beli_det']  = $this->db->where('id_pembelian', $data['sql_beli']->id)->get('tbl_trans_beli_det')->result();
            $data['sql_retur']     = $this->db->where('id_pembelian', $data['sql_beli']->id)->get('tbl_trans_retur_beli')->row();
            $data['sql_beli_plat'] = $this->db->select('id, DATE(tgl_simpan) as tgl_simpan, HOUR(tgl_simpan) as jam, MINUTE(tgl_simpan) as menit, id_platform, platform, nominal, keterangan')->where('tbl_trans_beli_plat.id_pembelian', $data['sql_beli']->id)->get('tbl_trans_beli_plat')->result();
            $data['sql_supplier']  = $this->db->where('id', $data['sql_beli']->id_supplier)->get('tbl_m_supplier')->row();

            $this->load->view('admin-lte-2/1_atas',$data);
            $this->load->view('admin-lte-2/2_header',$data);
            $this->load->view('admin-lte-2/includes/trans/trans_beli_det',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function trans_beli_det_po() {
        if (akses::aksesLogin() == TRUE) {
            $setting               = $this->db->get('tbl_pengaturan')->row();
            $id                    = $this->input->get('id');
            
            $data['sql_beli']      = $this->db->where('id', general::dekrip($id))->get('tbl_trans_beli_po')->row();
            $data['sql_beli_det']  = $this->db->where('id_pembelian', $data['sql_beli']->id)->get('tbl_trans_beli_po_det')->result();
            $data['sql_supplier']  = $this->db->where('id', $data['sql_beli']->id_supplier)->get('tbl_m_supplier')->row();

            $this->load->view('admin-lte-2/1_atas',$data);
            $this->load->view('admin-lte-2/2_header',$data);
            $this->load->view('admin-lte-2/includes/trans/trans_beli_det_po',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function trans_beli_hapus() {
        if (akses::aksesLogin() == TRUE) {
            $id    = $this->input->get('id');

            if(!empty($id)){
                $sql_nota     = $this->db->where('id', general::dekrip($id))->get('tbl_trans_beli')->row();
                $sql_nota_det = $this->db->where('id_pembelian', general::dekrip($id))->get('tbl_trans_beli_det')->result();
                $nota         = $sql_nota->no_nota.'/'.$sql_nota->kode_nota_blk;
                $sql_kas      = $this->db->where('keterangan', 'Pembelian '.$nota)->get('tbl_akt_kas')->row();
                
                foreach ($sql_nota_det as $pemb){
                    $sql_prod = $this->db->where('id', $pemb->id_produk)->get('tbl_m_produk')->row();
                    $sql_mut  = $this->db->where('status', '1')->where('id_produk', $pemb->id_produk)->where('id_pembelian', $pemb->id_pembelian)->get('tbl_m_produk_hist')->result();
                    $stok     = $sql_prod->jml - ($pemb->jml * $pemb->jml_satuan);
                    
                    foreach ($sql_mut as $mut){
                        $sql_stok = $this->db->where('id_produk', $mut->id_produk)->where('id_gudang', $mut->id_gudang)->get('tbl_m_produk_stok')->row();
                        $stok     = $sql_stok->jml - ($mut->jml * $mut->jml_satuan);
                        
                        crud::update('tbl_m_produk_stok', 'id', $sql_stok->id, array('jml'=>$stok));
                        crud::delete('tbl_m_produk_hist','id', $mut->id);
                    }
                    
//                    echo '<pre>';
//                    print_r($pemb->kode);
//                    echo '</pre>';
//                    echo '<pre>';
//                    print_r($sql_mut);
//                    echo '</pre>';
                    
                    $sum_stok = $this->db->select_sum('jml')->where('id_produk', $pemb->id_produk)->get('tbl_m_produk_stok')->row();
                    
                    crud::update('tbl_m_produk', 'id', $pemb->id_produk, array('tgl_modif'=>date('Y-m-d H:i:s'), 'jml'=>$sum_stok));                    
                }
                
                crud::delete('tbl_akt_kas','id',$sql_kas->id);
                crud::delete('tbl_trans_beli','id',general::dekrip($id));
//                
//                foreach ($sql_mut as $mutasi){
//                    $sql_prod = $this->db->where('id', $mutasi->id_produk)->get('tbl_m_produk')->row();
//                    $stok     = $sql_prod->jml - ($mutasi->jml * $mutasi->jml_satuan);
//                    
////                    echo '<pre>';
////                    print_r($sql_mut);
////                    echo '</pre>';
//                    
//                    crud::update('tbl_m_produk', 'id', $mutasi->id_produk, array('tgl_modif'=>date('Y-m-d H:i:s'), 'jml'=>$stok));
//                    crud::delete('tbl_m_produk_hist','id', $mutasi->id);
//                }
//                    echo '<pre>';
//                    print_r($sql_kas);
//                    echo '</pre>';
//                crud::delete('tbl_akt_kas','id',$sql_kas->id);
//                crud::delete('tbl_trans_beli','id',general::dekrip($id));
            }
            
            redirect(base_url('transaksi/data_pembelian_list.php'));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function cart_jual_simpan() {
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
                $msg_error = array(
                    'kode' => form_error('kode'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url('transaksi/trans_jual.php?id='.general::enkrip($no_nota)));
            } else {
                $sql_brg     = $this->db->where('id', general::dekrip($id_brg))
                                        ->get('tbl_m_produk')->row();
                $sql_brg_nom = $this->db->where('id_produk', $sql_brg->id)
                                        ->where('harga', $harga)
                                        ->get('tbl_m_produk_nominal')->row();
                $sql_gudang  = $this->db->where('status', $status_gd)->get('tbl_m_gudang')->row(); // cek gudang aktif
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
                        
                $disk1       = $harga_jual - (($diskon1 / 100) * $harga_jual);
                $disk2       = $disk1 - (($diskon2 / 100) * $disk1);
                $disk3       = $disk2 - (($diskon3 / 100) * $disk2);
                
                $harga_j     = (!empty($hrg_ds) ? $disk3 / $qty : $disk3);
                $jml         = $qty;
                $subtotal    = $harga_j * $jml;
                
                
                // Cek di keranjang
                foreach ($this->cart->contents() as $cart){                    
                    // Cek ada datanya kagak?
                    if($sql_brg->kode == $cart['options']['kode'] AND $cart['options']['satuan'] == $satuan){
                        $jml_subtotal      = ($cart['qty'] + $qty);                        
                        $jml_qty           = ($cart['qty'] + $qty);                        
                        
                        if($sql_stok->jml < $jml_subtotal){
                            $this->session->set_flashdata('transaksi', '<div class="alert alert-danger">Jumlah barang kurang dari <b>'.$jml.' '.$sat_brg.'</b>. Stok <b>['.$sql_gudang->gudang.']</b> tersedia <b>'.$sql_stok->jml.' '.$sql_satuan3->satuanTerkecil.'</b></div>');
                            redirect(base_url('transaksi/trans_jual.php?id='.$no_nota));
                        }else{
                            $this->cart->update(array('rowid'=>$cart['rowid'], 'qty'=>0));
                        }
                    }
                }
                
                // Cek jml unit dlm satuan terkecil
                $jml_unit = ((isset($jml_qty) ? (int)$jml_qty : $qty) * $sat_jual);
                
                if($sql_stok->jml < $jml_unit){
                    $this->session->set_flashdata('transaksi', '<div class="alert alert-danger">Jumlah barang kurang dari <b>'.$jml.' '.$sat_brg.'</b>. Stok <b>['.$sql_gudang->gudang.']</b> tersedia <b>'.$sql_stok->jml.' '.$sql_satuan3->satuanTerkecil.'</b></div>');
                }else{
                    $keranjang = array(
                        'id'      => rand(1,1024).$sql_brg->id,
                        'qty'     => (!empty($jml_qty) ? $jml_qty : $qty),
                        'price'   => $harga_j, // $disk3 => Ambil dari variable harga
                        'name'    => ($sql_brg->status_brg_dep == 1 ? str_replace(array('\'','\\','/'), ' ', $sql_brg->produk.'-['.$nomor.']') : str_replace(array('\'','\\','/'), ' ', $sql_brg->produk)),
                        'options' => array(
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
                        )
                    );
                    
                    $this->cart->insert($keranjang);
                }
                
                redirect(base_url('transaksi/trans_jual.php?id='.$no_nota));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function cart_jual_simpan_pen() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota  = $this->input->post('no_nota');
            $id_brg   = $this->input->post('id_barang');
            $kode     = $this->input->post('kode');
            $satuan   = $this->input->post('satuan');
            $qty      = $this->input->post('jml');
            $diskon1  = $this->input->post('disk1');
            $diskon2  = $this->input->post('disk2');
            $diskon3  = $this->input->post('disk3');
            $harga    = str_replace('.', '', $this->input->post('harga'));
            $potongan = str_replace('.', '', $this->input->post('potongan'));

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('kode', 'Kode', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'kode' => form_error('kode'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url('transaksi/trans_jual.php?id='.general::enkrip($no_nota)));
            } else {
                $sql_brg     = $this->db->where('id', general::dekrip($id_brg))->get('tbl_m_produk')->row();
                $sql_det     = $this->db->where('no_nota', general::dekrip($no_nota))->where('kode', $sql_brg->kode)->where('satuan', $satuan)->get('tbl_trans_jual_det');
                $sql_satuan  = $this->db->where('id_produk', $sql_brg->id)->where('satuan', $satuan)->get('tbl_m_produk_satuan')->row();
                $sql_satuan2 = $this->db->where('id', $sql_brg->id_satuan)->get('tbl_m_satuan')->row();

                $disk1       = $harga - (($diskon1 / 100) * $harga);
                $disk2       = $disk1 - (($diskon2 / 100) * $disk1);
                $disk3       = $disk2 - (($diskon3 / 100) * $disk2);

                $harga_j     = $disk3 * $sql_satuan->jml;
                $jml         = $qty;
                $subtotal    = $harga_j * $qty;
                $diskon      = ($harga * $sql_satuan->jml * $qty) - $subtotal;
                $jml_akhir   = $sql_brg->jml - ($sql_satuan->jml * $qty);
                
                if($sql_brg->jml < $jml){
                    $this->session->set_flashdata('transaksi', '<div class="alert alert-danger">Jumlah barang, tidak tersedia</div>');
                }else{
                    if($sql_det->num_rows() > 0){
                        $jml_qty = $qty + $sql_det->row()->jml;
                    }else{
                        $jml_qty = $qty;                        
                    }
                    
                    $data_penj_det = array(
                        'no_nota'   => general::dekrip($no_nota),
                        'tgl_simpan'=> date('Y-m-d H:i:s'),
                        'id_satuan' => $sql_brg->id_satuan,
                        'kode'      => $sql_brg->kode,
                        'produk'    => $sql_brg->produk,
                        'satuan'    => $satuan,
                        'keterangan'=> ($satuan == $sql_satuan->satuan ? ($sql_satuan->jml == $qty ? '' : ' ('.($jml_qty * $sql_satuan->jml).' '.$sql_satuan2->satuanTerkecil.')') : ''),
                        'harga'     => (float)$harga,
                        'disk1'     => (float)$diskon1,
                        'disk2'     => (float)$diskon2,
                        'disk3'     => (float)$diskon3,
                        'jml'       => (int)$jml_qty,
                        'jml_satuan'=> (int)$sql_satuan->jml,
                        'diskon'    => (float)$diskon,
                        'potongan'  => 0,
                        'subtotal'  => (float)$subtotal,
                    );                                      
                    
                    crud::simpan('tbl_trans_jual_pen_det', $data_penj_det);
                }
                
                redirect(base_url('transaksi/trans_jual_pen.php?id='.$no_nota));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function cart_jual_simpan_umum() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota  = $this->input->post('no_nota');
            $id_brg   = $this->input->post('id_barang');
            $kode     = $this->input->post('kode');
            $satuan   = $this->input->post('satuan');
            $qty      = $this->input->post('jml');
            $diskon1  = $this->input->post('disk1');
            $diskon2  = $this->input->post('disk2');
            $diskon3  = $this->input->post('disk3');
            $hrg_ds   = $this->input->post('harga_ds');
            $hrg      = str_replace('.', '', $this->input->post('harga'));
            $potongan = str_replace('.', '', $this->input->post('potongan'));
            $status_gd= $this->ion_auth->user()->row()->status_gudang;

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('kode', 'Kode', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'kode' => form_error('kode'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url('transaksi/trans_jual.php?id='.general::enkrip($no_nota)));
            } else {
                $where      = "(tbl_m_produk.kode LIKE '".$kode."' OR tbl_m_produk.barcode LIKE '".$kode."')";
                $sql_brg    = $this->db->where($where)->get('tbl_m_produk')->row();
                $sql_promo  = $this->db->where('id_produk', $sql_brg->id)->get('tbl_m_produk_promo')->row();
                $sql_satuan = $this->db->where('id_produk', $sql_brg->id)->where('satuan', $satuan)->get('tbl_m_produk_satuan')->row();
                
                $sql_gudang  = $this->db->where('status', $status_gd)->get('tbl_m_gudang')->row(); // cek gudang aktif
                $sql_stok    = $this->db->where('id_produk', $sql_brg->id)->where('id_gudang', $sql_gudang->id)->get('tbl_m_produk_stok')->row(); // cek posisi stok
                
//                $sql_satuan2= $this->db->where('id', $sql_brg->id_satuan)->get('tbl_m_satuan')->row();
                $sql_satuan3= $this->db->where('id', $sql_brg->id_satuan)->get('tbl_m_satuan')->row();
                $harga      = (!empty($hrg) ? $hrg : $sql_brg->harga_jual); //(!empty($sql_satuan->harga) ? $sql_satuan->harga : $sql_brg->harga_jual)); //$sql_satuan->harga
                
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
                
                $disc1      = (!empty($diskon1) ? $diskon1 : $sql_promo->disk1);
                $disc2      = (!empty($diskon2) ? $diskon2 : $sql_promo->disk2);
                $disc3      = (!empty($diskon3) ? $diskon3 : $sql_promo->disk3);
                   
                $disk1      = $harga - (($disc1 / 100) * $harga);
                $disk2      = $disk1 - (($disc2 / 100) * $disk1);
                $disk3      = $disk2 - (($disc3 / 100) * $disk2);
                
                $harga_j    = (!empty($hrg_ds) ? $disk3 / $qty : $disk3);
                $jml        = (!empty($satuan) ? $qty : 1);
                $diskon     = (!empty($hrg_ds) ? 0 : ($harga * $jml) - (($harga_j * $qty)));
                $subtotal   = (!empty($hrg_ds) ? ($harga_j * $jml): ($harga * $jml) - $diskon);

                // Cek di keranjang
                foreach ($this->cart->contents() as $cart){
                    
                    // Cek ada datanya kagak?
                    if($sql_brg->kode == $cart['options']['kode'] AND $cart['options']['satuan'] == $satuan){
                        $jml_subtotal = ($cart['qty'] + $qty) * $sql_satuan->jml;
                        $jml_qty      = $cart['qty'] + $qty;
                        
                        if($sql_stok->jml < $jml_subtotal){
                            $this->session->set_flashdata('transaksi', '<div class="alert alert-danger">Jumlah barang kurang dari <b>'.$jml.' '.$sat_brg.'</b>. Stok <b>['.$sql_gudang->gudang.']</b> tersedia <b>'.$sql_stok->jml.' '.$sql_satuan3->satuanTerkecil.'</b></div>');
                            redirect(base_url('transaksi/trans_jual.php?id='.$no_nota));
                        }else{
                            $this->cart->update(array('rowid'=>$cart['rowid'], 'qty'=>0));
                        }
                    }
                }
                
                // Cek jml unit dlm satuan terkecil
                $jml_unit = ((isset($jml_qty) ? (int)$jml_qty : $qty) * $sat_jual);
                
                if($sql_stok->jml < $jml_unit){
                    $this->session->set_flashdata('transaksi', '<div class="alert alert-danger">Jumlah barang kurang dari <b>'.$jml.' '.$sat_brg.'</b>. Stok <b>['.$sql_gudang->gudang.']</b> tersedia <b>'.$sql_stok->jml.' '.$sql_satuan3->satuanTerkecil.'</b></div>');
                }else{
                    $prod_name = preg_replace("/[^a-zA-Z0-9\s]/", "", $sql_brg->produk);
                    
                    $keranjang = array(
                        'id'      => rand(1,1024).$sql_brg->id,
                        'qty'     => (isset($jml_qty) ? (int)$jml_qty : $qty),
                        'price'   => $harga_j, // $disk3 => Ambil dari variable harga
                        'name'    => str_replace(array('&','=','\'','"'), ' ', $sql_brg->produk),
                        'options' => array(
                            'no_nota'   => general::dekrip($no_nota),
                            'id_barang' => $sql_brg->id,
                            'id_satuan' => $sql_brg->id_satuan,
                            'id_nominal'=> $sql_brg_nom->id,
                            'satuan'    => $sat_brg,
                            'satuan_ket'=> ($sat_jual != 1 ? '('.(!empty($jml_subtotal) ? $jml_qty : $qty) * $sat_jual.' '.$sql_satuan3->satuanTerkecil.')' : ''),
                            'jml'       => $qty,
                            'jml_satuan'=> ($sat_jual == '0' ? '1' : $sat_jual),
                            'kode'      => $sql_brg->kode,
                            'harga'     => $harga_j, //ceil($harga), //($satuan == $sql_satuan->satuanBesar ? $harga_j : $harga_j * $sql_satuan->jml),
                            'disk1'     => (float)$diskon1,
                            'disk2'     => (float)$diskon2,
                            'disk3'     => (float)$diskon3,
                            'potongan'  => (float)$potongan,
                            'diskon'    => (float)($diskon < 0 ? 0 : $diskon),
                            'subtotal'  => (float)$subtotal,
                        )
                    );

                    $this->cart->insert($keranjang);
//                    
//                    echo '<pre>';
//                    print_r($keranjang);
//                    echo '</pre>';
//                    echo '<pre>';
//                    print_r($sat3);
//                    echo '</pre>';
////                    echo $sat_jual;
//                    echo $sql_stok->jml;
                }
                redirect(base_url('transaksi/trans_jual_umum.php?id='.$no_nota));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function cart_jual_simpan_umum_draft() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota  = $this->input->post('no_nota');
            $id_brg   = $this->input->post('id_barang');
            $kode     = $this->input->post('kode');
            $satuan   = $this->input->post('satuan');
            $qty      = $this->input->post('jml');
            $diskon1  = $this->input->post('disk1');
            $diskon2  = $this->input->post('disk2');
            $diskon3  = $this->input->post('disk3');
            $hrg_ds   = $this->input->post('harga_ds');
            $hrg      = str_replace('.', '', $this->input->post('harga'));
            $potongan = str_replace('.', '', $this->input->post('potongan'));
            $status_gd= $this->ion_auth->user()->row()->status_gudang;

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('kode', 'Kode', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'kode' => form_error('kode'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url('transaksi/trans_jual.php?id='.general::enkrip($no_nota)));
            } else {
                $where      = "(tbl_m_produk.kode LIKE '".$kode."' OR tbl_m_produk.barcode LIKE '".$kode."')";
                $sql_brg    = $this->db->where($where)->get('tbl_m_produk')->row();
                $sql_promo  = $this->db->where('id_produk', $sql_brg->id)->get('tbl_m_produk_promo')->row();
                $sql_satuan = $this->db->where('id_produk', $sql_brg->id)->where('satuan', $satuan)->get('tbl_m_produk_satuan')->row();
                $sql_satuan2= $this->db->where('id', $sql_brg->id_satuan)->get('tbl_m_satuan')->row();
                $sql_trx    = $this->db->where('id', general::dekrip($no_nota))->get('tbl_trans_jual')->row();
                $sql_trx_det= $this->db->where('id_penjualan', general::dekrip($no_nota))->where('kode', $sql_brg->kode)->get('tbl_trans_jual_det');
                $sql_trx_row= $sql_trx_det->row();
                $sql_trx_rws= $sql_trx_det->num_rows();
                
                $sql_gudang  = $this->db->where('status', $status_gd)->get('tbl_m_gudang')->row(); // cek gudang aktif
                $sql_stok    = $this->db->where('id_gudang', $sql_gudang->id)->where('id_produk', $sql_brg->id)->get('tbl_m_produk_stok')->row(); // cek posisi stok

                $disk1     = $hrg - (($diskon1 / 100) * $hrg);
                $disk2     = $disk1 - (($diskon2 / 100) * $disk1);
                $disk3     = $disk2 - (($diskon3 / 100) * $disk2);

                $jml       = $qty;
                $jml_real  = (!empty($hrg_ds) ? $jml : $sql_satuan->jml * $jml);
                $subtotal  = (!empty($hrg_ds) ? $hrg : $disk3 * $jml);
                $harga_pcs = (!empty($hrg_ds) ? $subtotal / $jml : $hrg);
                $diskon    = $hrg - $disk3;
                $jml_akhir = $sql_brg->jml - $jml_real;
                                
                if($sql_stok->jml < $jml_real){
                    $this->session->set_flashdata('transaksi', '<div class="alert alert-danger">Jumlah barang, tidak tersedia</div>');
                    redirect(base_url('transaksi/trans_jual_umum_draft.php?id='.$no_nota));
                }else{
                    $data_brg = array(
                        'tgl_modif' => date('Y-m-d H:i:s'),
                        'jml'       => $jml_akhir
                    );
                    
                    if($sql_trx_rws == 1){
                        $jml_subtot_itm = $jml + $sql_trx_row->jml;
                        $jml_subtot_sat = $sql_satuan->jml;
                        $ket_upd        = ($sql_satuan->jml > 1 ? ' ('.($sql_satuan->jml * $jml).' '.$sql_satuan2->satuanTerkecil.')' : '');
                        
                        $data_penj_det = array(
                            'tgl_simpan'=> date('Y-m-d H:i:s'),
                            'keterangan'    => ($sql_satuan->jml > 1 ? ' ('.($sql_satuan->jml * $jml).' '.$sql_satuan2->satuanTerkecil.')' : ''),
                            'jml'           => (int)$jml_subtot_itm,
                            'jml_satuan'    => (int)$sql_satuan->jml,
                            'harga'         => (float)$hrg,
                            'disk1'         => (float)$diskon1,
                            'disk2'         => (float)$diskon2,
                            'disk3'         => (float)$diskon3,
                            'diskon'        => (float)$diskon,
                            'subtotal'      => (float)$subtotal,
                        );
                        
                        crud::update('tbl_m_produk', 'id', $sql_brg->id, $data_brg);
                        crud::update('tbl_trans_jual_det', 'id', $sql_trx_row->id, $data_brg_upd);
                        
                        /* Catat log barang keluar ke tabel */
                        $hist_nota      = $this->db->where('id_produk', $sql_brg->id)->where('id_penjualan', $sql_trx->id)->get('tbl_m_produk_hist');
                        $hist_nota_row  = $hist_nota->row();
                        $hist_nota_rws  = $hist_nota->num_rows();
                        
                        $data_penj_hist = array(
                            'tgl_simpan'    => date('Y-m-d H:i:s'),
                            'tgl_masuk'     => date('Y-m-d'),
                            'id_gudang'     => $sql_gudang->id,
                            'id_pelanggan'  => $sql_trx->id_pelanggan,
                            'id_produk'     => $sql_brg->id,
                            'id_user'       => $this->ion_auth->user()->row()->id,
                            'id_penjualan'  => $sql_trx->id,
                            'no_nota'       => $sql_trx->no_nota,
                            'kode'          => $sql_brg->kode,
                            'keterangan'    => 'Penjualan',
                            'jml'           => (int)$jml_subtot_itm,
                            'jml_satuan'    => (int)$sql_satuan->jml,
                            'satuan'        => $satuan,
                            'nominal'       => (float)$subtotal,
                            'status'        => '4'
                        );
                        
                        if($hist_nota_rws > 0){
                            crud::update('tbl_m_produk_hist', 'id', $hist_nota_row->id,$data_penj_hist);
                        }else{
                            crud::simpan('tbl_m_produk_hist', $data_penj_hist);
                        }
                        /* -- END -- */
                    }else{
                        $data_penj_det = array(
                            'id_penjualan'  => $sql_trx->id,
                            'id_satuan'     => $sql_brg->id_satuan,
                            'no_nota'       => $sql_trx->no_nota,
                            'tgl_simpan'    => date('Y-m-d H:i:s'),
                            'satuan'        => (!empty($hrg_ds) ? $sql_satuan2->satuanTerkecil : $satuan),
                            'keterangan'    => (!empty($hrg_ds) ? '' : ($sql_satuan->jml > 1 ? ' ('.($sql_satuan->jml * $jml).' '.$sql_satuan2->satuanTerkecil.')' : '')),
                            'kode'          => $sql_brg->kode,
                            'produk'        => $sql_brg->produk,
                            'jml'           => (int)$jml,
                            'jml_satuan'    => (int)(!empty($hrg_ds) ? $sql_satuan2->jml : $sql_satuan->jml),
                            'harga'         => (float)$harga_pcs,
                            'disk1'         => (float)$diskon1,
                            'disk2'         => (float)$diskon2,
                            'disk3'         => (float)$diskon3,
                            'diskon'        => (float)$diskon,
                            'subtotal'      => (float)$subtotal,
                        );
                        
                        crud::update('tbl_m_produk', 'id', $sql_brg->id, $data_brg);
                        crud::simpan('tbl_trans_jual_det', $data_penj_det);
                        
                        /* Catat log barang keluar ke tabel */
                        $hist_nota      = $this->db->where('id_produk', $sql_brg->id)->where('id_penjualan', $sql_trx->id)->get('tbl_m_produk_hist');
                        $hist_nota_row  = $hist_nota->row();
                        $hist_nota_rws  = $hist_nota->num_rows();
                        
                        $data_penj_hist = array(
                            'tgl_simpan'    => date('Y-m-d H:i:s'),
                            'tgl_masuk'     => $sql_trx->tgl_masuk,
                            'id_pelanggan'  => $sql_trx->id_pelanggan,
                            'id_produk'     => $sql_brg->id,
                            'id_user'       => $this->ion_auth->user()->row()->id,
                            'id_penjualan'  => $sql_trx->id,
                            'no_nota'       => $sql_trx->no_nota,
                            'kode'          => $sql_brg->kode,
                            'keterangan'    => 'Penjualan',
                            'jml'           => (int)$jml,
                            'jml_satuan'    => (int)(!empty($hrg_ds) ? $sql_satuan2->jml : $sql_satuan->jml),
                            'satuan'        => (!empty($hrg_ds) ? $sql_satuan2->satuanTerkecil : $satuan),
                            'nominal'       => (float)$subtotal,
                            'status'        => '4'
                        );
                        
                        if($hist_nota_rws > 0){
                            crud::update('tbl_m_produk_hist', 'id', $hist_nota_row->id,$data_penj_hist);
                        }else{
                            crud::simpan('tbl_m_produk_hist', $data_penj_hist);
                        }
                        /* -- END -- */
                    }
                }
                
                redirect(base_url('transaksi/trans_jual_umum_draft.php?id='.$no_nota));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function cart_jual_update() {
        if (akses::aksesLogin() == TRUE) {
            $id       = $this->input->post('id');
            $no_nota  = $this->input->post('no_nota');
            $id_brg   = $this->input->post('id_barang');
            $kode     = $this->input->post('kode');
            $satuan   = $this->input->post('satuan');
            $qty      = $this->input->post('jml');
            $diskon1  = $this->input->post('disk1');
            $diskon2  = $this->input->post('disk2');
            $diskon3  = $this->input->post('disk3');
            $harga    = str_replace(',', '.', str_replace('.', '', $this->input->post('harga')));

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('kode', 'Kode', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'kode' => form_error('kode'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url('transaksi/trans_jual_edit.php?id='.$id));
            } else {
                $sql_brg      = $this->db->where('id', general::dekrip($id_brg))
                                        ->get('tbl_m_produk')->row();
                $sql_brg_sat  = $this->db->where('id_produk', $sql_brg->id)->where('satuan', $satuan)
                                        ->get('tbl_m_produk_satuan')->row();
                $sql_satuan   = $this->db->where('id', $sql_brg->id_satuan)->get('tbl_m_satuan')->row();
                $sql_penj     = $this->db->where('id', general::dekrip($no_nota))->get('tbl_trans_jual')->row();
                $sql_penj_det = $this->db->where('id_penjualan', general::dekrip($no_nota))->where('kode', $sql_brg->kode)->where('satuan', $satuan)->get('tbl_trans_jual_det');
                
                $disk1        = $harga - (($diskon1 / 100) * $harga);
                $disk2        = $disk1 - (($diskon2 / 100) * $disk1);
                $disk3        = $disk2 - (($diskon3 / 100) * $disk2);
                
                $harga_j      = $disk3;
                $jml          = $qty; //($satuan == $sql_satuan->satuanBesar ? $sql_satuan->jml * $qty : $qty);
                $jml_real     = ($satuan == $sql_brg_sat->satuan ? $sql_brg_sat->jml * $qty : $qty);
                $subtotal     = $harga_j * $jml;
                $diskon       = ($harga * $jml) - $subtotal;
                $jml_akhir    = $sql_brg->jml - $jml_real;
                
//                if($sql_brg->jml < $jml){
//                    $this->session->set_flashdata('transaksi', '<div class="alert alert-danger">Jumlah barang, tidak tersedia</div>');
//                }else{                    
                    $data_penj_det = array(
                        'id_penjualan'  => general::dekrip($no_nota),
                        'no_nota'       => $sql_penj->no_nota,
                        'tgl_simpan'    => date('Y-m-d H:i:s'),
                        'id_satuan'     => $sql_brg->id_satuan,
                        'satuan'        => $satuan,
                        'keterangan'    => ($satuan != $sql_satuan->satuanTerkecil ? ' ('.($sql_brg_sat->jml * $jml).' '.$sql_satuan->satuanTerkecil.')' : ''),
                        'kode'          => $sql_brg->kode,
                        'produk'        => $sql_brg->produk,
                        'jml'           => (int)$jml,
                        'jml_satuan'    => (int)($satuan != $sql_satuan->satuanTerkecil ? $sql_brg_sat->jml : 1),
                        'harga'         => (float)$harga_j,
                        'disk1'         => (float)$diskon1,
                        'disk2'         => (float)$diskon2,
                        'disk3'         => (float)$diskon3,
                        'diskon'        => (float)$diskon,
                        'subtotal'      => (float)$subtotal,
                    );
                    
                    $data_brg = array(
                        'tgl_modif' => date('Y-m-d H:i:s'),
                        'jml'       => $jml_akhir
                    );
                    
                    $data_brg_hist = array(
                        'tgl_simpan'    => date('Y-m-d H:i:s'),
                        'id_produk'     => $sql_brg->id,
                        'id_user'       => $this->ion_auth->user()->row()->id,
                        'id_penjualan'  => $sql_penj->id,
                        'id_pelanggan'  => $sql_penj->id_pelanggan,
                        'no_nota'       => $sql_penj->no_nota,
                        'kode'          => $sql_brg->kode,
                        'keterangan'    => 'Penjualan '.$sql_penj->no_nota.(!empty($sql_penj->kode_nota_blk) ? '/'.$sql_penj->kode_nota_blk : ''),
                        'nominal'       => ceil((float)$disk3),
                        'jml'           => ceil((float)$jml),
                        'jml_satuan'    => (int)($satuan != $sql_satuan->satuanTerkecil ? $sql_brg_sat->jml : 1),
                        'satuan'        => $satuan,
                        'status'        => '4',
                    );

//                    if($sql_penj_det->num_rows() == 1){
//                        $jml_subtot_itm = $jml + $sql_penj_det->row()->jml;
//                        $jml_subtot_sat = ($satuan == $sql_satuan->satuanBesar ? $sql_satuan->jml : 0) + $sql_penj_det->row()->jml_satuan;
//                        $ket_upd        = ($satuan == $sql_satuan->satuanBesar ? ' ('.$jml_subtot_sat.' '.$sql_satuan->satuanTerkecil.')' : '');
//                        
//                        $data_brg_upd = array('keterangan'=> $ket_upd, 'jml'=> (int)$jml_subtot_itm, 'jml_satuan'=> (int)$jml_subtot_sat);
//                        crud::update('tbl_m_produk', 'id', $sql_brg->id, $data_brg);
//                        crud::update('tbl_trans_jual_det', 'id', $sql_det->row()->id, $data_brg_upd);
//                    }else{
                        crud::update('tbl_m_produk', 'id', $sql_brg->id, $data_brg);
                        crud::simpan('tbl_trans_jual_det', $data_penj_det);
                        crud::simpan('tbl_m_produk_hist', $data_brg_hist);
//                    }
//                }
                
                redirect(base_url('transaksi/trans_jual_edit.php?id='.$no_nota));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function cart_jual_update_umum() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota  = $this->input->post('no_nota');
            $id_brg   = $this->input->post('id_barang');
            $kode     = $this->input->post('kode');
            $satuan   = $this->input->post('satuan');
            $qty      = $this->input->post('jml');
            $diskon1  = $this->input->post('disk1');
            $diskon2  = $this->input->post('disk2');
            $diskon3  = $this->input->post('disk3');
            $harga    = str_replace('.', '', $this->input->post('harga'));

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('kode', 'Kode', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'kode' => form_error('kode'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url('transaksi/trans_jual_edit.php?id='.$no_nota));
            } else {
                $sql_brg    = $this->db->where('id', general::dekrip($id_brg))
                                       ->get('tbl_m_produk')->row();
                $sql_satuan = $this->db->where('id', $sql_brg->id_satuan)->get('tbl_m_satuan')->row();
                $sql_det    = $this->db->where('no_nota', general::dekrip($no_nota))->where('kode', $sql_brg->kode)->where('satuan', $satuan)->get('tbl_trans_jual_det');
                
                $disk1     = $harga - (($diskon1 / 100) * $harga);
                $disk2     = $disk1 - (($diskon2 / 100) * $disk1);
                $disk3     = $disk2 - (($diskon3 / 100) * $disk2);
                $harga_j   = ($satuan == $sql_satuan->satuanBesar ? $disk3 * $sql_satuan->jml : $disk3);
                $jml       = $qty; //($satuan == $sql_satuan->satuanBesar ? $sql_satuan->jml * $qty : $qty);
                $jml_real  = ($satuan == $sql_satuan->satuanBesar ? $sql_satuan->jml * $qty : $qty);
                $subtotal  = $harga_j * $jml;
                $diskon    = (($jml * $sql_satuan->jml) * $sql_brg->harga_jual) - $subtotal;
                $jml_akhir = $sql_brg->jml - $jml_real;
                
                if($sql_brg->jml < $jml){
                    $this->session->set_flashdata('transaksi', '<div class="alert alert-danger">Jumlah barang, tidak tersedia</div>');
                }else{                    
                    $data_penj_det = array(
                        'no_nota'   => general::dekrip($no_nota),
                        'tgl_simpan'=> date('Y-m-d H:i:s'),
                        'id_satuan' => $sql_brg->id_satuan,
                        'satuan'    => $satuan,
                        'keterangan'=> ($satuan == $sql_satuan->satuanBesar ? ' ('.($sql_satuan->jml * $jml).' '.$sql_satuan->satuanTerkecil.')' : ''),
                        'kode'      => $sql_brg->kode,
                        'produk'    => $sql_brg->produk,
                        'jml'       => (int)$jml,
                        'jml_satuan'=> (int)($satuan == $sql_satuan->satuanBesar ? $sql_satuan->jml : 1),
                        'harga'     => (float)$sql_brg->harga_jual,
                        'disk1'     => (float)$diskon1,
                        'disk2'     => (float)$diskon2,
                        'disk3'     => (float)$diskon3,
                        'diskon'    => (float)$diskon,
                        'subtotal'  => (float)$subtotal,
                    );
                    
                    $data_brg = array(
                        'tgl_modif' => date('Y-m-d H:i:s'),
                        'jml'       => $jml_akhir
                    );                                        
                    
                    if($sql_det->num_rows() == 1){
                        $jml_subtot_itm = $jml + $sql_det->row()->jml;
                        $jml_subtot_sat = ($satuan == $sql_satuan->satuanBesar ? $sql_satuan->jml : 0) + $sql_det->row()->jml_satuan;
                        $ket_upd        = ($satuan == $sql_satuan->satuanBesar ? ' ('.$jml_subtot_sat.' '.$sql_satuan->satuanTerkecil.')' : '');
                        
                        $data_brg_upd = array('keterangan'=> $ket_upd, 'jml'=> (int)$jml_subtot_itm, 'jml_satuan'=> (int)$jml_subtot_sat);
                        crud::update('tbl_m_produk', 'id', $sql_brg->id, $data_brg);
                        crud::update('tbl_trans_jual_det', 'id', $sql_det->row()->id, $data_brg_upd);
                    }else{
                        crud::update('tbl_m_produk', 'id', $sql_brg->id, $data_brg);
                        crud::simpan('tbl_trans_jual_det', $data_penj_det);
                    }
                }
                
                redirect(base_url('transaksi/trans_jual_edit.php?id='.$no_nota));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function cart_jual_update_qty() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota  = $this->input->post('no_nota');
            $id       = $this->input->post('id_cart');
            $qty      = $this->input->post('qty2');
            $potongan = str_replace('.','',$this->input->post('potongan2'));
            $status_gd= $this->ion_auth->user()->row()->status_gudang;

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id_cart', 'Kode', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'id_cart' => form_error('id_cart'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url('transaksi/trans_jual_umum.php?id='.$no_nota));
            } else {
                $cart = $this->cart->contents();
                
                foreach ($cart as $cart){
                    if($id == $cart['rowid']){
                        $sql_gudang = $this->db->where('id', $status_gd)->get('tbl_m_gudang')->row();
                        $sql_barang = $this->db->where('id', $cart['options']['id_barang'])->get('tbl_m_produk')->row();
                        $sql_stok   = $this->db->select('(jml * jml_satuan) AS jml')->where('id_produk', $cart['options']['id_barang'])->where('id_gudang', $sql_gudang->id)->get('tbl_m_produk_stok')->row();
                        $sql_satuan = $this->db->where('id', $sql_barang->id_satuan)->get('tbl_m_satuan')->row();
                        
                        if($sql_stok->jml < $qty ){
                            $this->session->set_flashdata('transaksi', '<div class="alert alert-danger">Jumlah barang kurang dari <b>'.$qty.' '.$cart['options']['satuan'].'</b>. Stok <b>['.$sql_gudang->gudang.']</b> tersedia <b>'.$sql_stok->jml.' '.$sql_satuan->satuanTerkecil.'</b></div>');
                        }else{
                            $harga    = $cart['price'];
                            $subtotal = ($harga * $qty) - $potongan;
                            
                            $keranjang = array(
                                'rowid' => $id,
                                'qty'   => $qty,
                                'options' => array(
                                    'no_nota'   => general::dekrip($no_nota),
                                    'id_barang' => $cart['options']['id_barang'],
                                    'id_satuan' => $cart['options']['id_satuan'],
                                    'id_nominal'=> $cart['options']['id_nominal'],
                                    'satuan'    => $cart['options']['satuan'],
                                    'satuan_ket'=> $cart['options']['satuan_ket'],
                                    'jml'       => $qty,
                                    'jml_satuan'=> $cart['options']['jml_satuan'],
                                    'kode'      => $cart['options']['kode'],
                                    'harga'     => $cart['options']['harga'],
                                    'disk1'     => (float)$cart['options']['disk1'],
                                    'disk2'     => (float)$cart['options']['disk2'],
                                    'disk3'     => (float)$cart['options']['disk3'],
                                    'potongan'  => (float)$potongan,
                                    'diskon'    => (float)$cart['options']['diskon'],
                                    'subtotal'  => (float)$subtotal,
                                )
                            );
                            
//                            echo '<pre>';
//                            print_r($keranjang);
//                            echo '</pre>';
                            $this->cart->update_all($keranjang);
                        }                        
                    }
                    
                }

                redirect(base_url('transaksi/trans_jual_umum.php?id='.$no_nota));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function cart_jual_update_draft() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota  = $this->input->post('no_nota');
            $id_cart  = $this->input->post('id_cart');
            $id_brg   = $this->input->post('id_barang');
            $kode     = $this->input->post('kode');
            $satuan   = $this->input->post('satuan');
            $qty      = $this->input->post('qty2');
            $diskon1  = $this->input->post('disk1');
            $diskon2  = $this->input->post('disk2');
            $diskon3  = $this->input->post('disk3');
            $hrg_ds   = $this->input->post('harga_ds');
            $hrg      = str_replace('.', '', $this->input->post('harga'));
            $potongan = str_replace('.', '', $this->input->post('potongan2'));

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id_cart', 'item_cart', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'id_cart' => form_error('id_cart'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url('transaksi/trans_jual_umum_draft.php?id='.$no_nota));
            } else {
                $sql_trx    = $this->db->where('id', general::dekrip($no_nota))->get('tbl_trans_jual')->row();
                $sql_trx_det= $this->db->where('id', general::dekrip($id_cart))->get('tbl_trans_jual_det');
                $sql_trx_row= $sql_trx_det->row();
                $sql_trx_rws= $sql_trx_det->num_rows();
                $sql_brg    = $this->db->where('kode', $sql_trx_row->kode)->get('tbl_m_produk')->row();
                $sql_promo  = $this->db->where('id_produk', $sql_brg->id)->get('tbl_m_produk_promo')->row();
                $sql_satuan2= $this->db->where('id', $sql_brg->id_satuan)->get('tbl_m_satuan')->row();

                $disk1     = $hrg - (($diskon1 / 100) * $hrg);
                $disk2     = $disk1 - (($diskon2 / 100) * $disk1);
                $disk3     = $disk2 - (($diskon3 / 100) * $disk2);

                $jml       = $qty;
                $jml_real  = $sql_trx_row->jml_satuan * $jml;
                $subtotal  = ($sql_trx_row->harga * $jml) - $potongan;
                $jml_akhir = ($sql_brg->jml + $sql_trx_row->jml) - $jml_real;
                $jml_stok  = ($sql_brg->jml + $sql_trx_row->jml);

                if($jml_stok < $jml_real){
                    $this->session->set_flashdata('transaksi', '<div class="alert alert-danger">Jumlah barang, tidak tersedia</div>');
                    redirect(base_url('transaksi/trans_jual_umum_draft.php?id='.$no_nota));
                }else{
                    $data_brg = array(
                        'tgl_modif' => date('Y-m-d H:i:s'),
                        'jml'       => $jml_akhir
                    );
                    
                    if($sql_trx_rws == 1){
                        $jml_subtot_itm = $jml;
                        $jml_subtot_sat = $sql_satuan->jml;
                        $ket_upd        = ($sql_satuan->jml > 1 ? ' ('.($sql_satuan->jml * $jml).' '.$sql_satuan2->satuanTerkecil.')' : '');
                        
                        $data_penj_det = array(
                            'tgl_simpan'=> date('Y-m-d H:i:s'),
                            'jml'           => (int)$jml,
                            'potongan'      => (float)$potongan,
                            'subtotal'      => (float)$subtotal,
                        );
                        
                        crud::update('tbl_m_produk', 'id', $sql_brg->id, $data_brg);
                        crud::update('tbl_trans_jual_det', 'id', $sql_trx_row->id, $data_penj_det);
                        
                        /* Catat log barang keluar ke tabel */
                        $hist_nota      = $this->db->where('id_produk', $sql_brg->id)->where('id_penjualan', $sql_trx->id)->get('tbl_m_produk_hist');
                        $hist_nota_row  = $hist_nota->row();
                        $hist_nota_rws  = $hist_nota->num_rows();
                        
                        $data_penj_hist = array(
                            'tgl_modif'  => date('Y-m-d H:i:s'),
                            'jml'        => (int)$jml,
                            'nominal'    => (float)$subtotal,
                        );
                        
                        if($hist_nota_rws > 0){
                            crud::update('tbl_m_produk_hist', 'id', $hist_nota_row->id, $data_penj_hist);
                        }else{
                            crud::simpan('tbl_m_produk_hist', $data_penj_hist);
                        }
                        /* -- END -- */
                    }
                }
                
//                echo $sql_trx_row->jml;      
//                echo '<pre>';
//                print_r($data_penj_det);
//                echo '</pre>';
//                echo '<pre>';
//                print_r($data_brg);
//                echo '</pre>';
//                echo '<pre>';
//                print_r($data_penj_hist);
//                echo '</pre>';
                
                redirect(base_url('transaksi/trans_jual_umum_draft.php?id='.$no_nota));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    

    public function cart_beli_simpan() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota  = $this->input->post('no_nota');
            $id_brg   = $this->input->post('id_barang');
            $satuan   = $this->input->post('satuan');
            $kode     = $this->input->post('kode');
            $qty      = $this->input->post('jml');
            $diskon1  = str_replace(',', '.', $this->input->post('disk1'));
            $diskon2  = str_replace(',', '.', $this->input->post('disk2'));
            $diskon3  = str_replace(',', '.', $this->input->post('disk3'));
            $harga    = str_replace('.', '', $this->input->post('harga'));
            $potongan = str_replace('.', '', $this->input->post('potongan'));
            $qtydep   = str_replace('.', '', $this->input->post('jml_deposit'));

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('kode', 'Kode', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'kode' => form_error('kode'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url('transaksi/trans_beli.php?id='.$no_nota));
            } else {
                $sql_brg     = $this->db->where('id', general::dekrip($id_brg))
                                    ->get('tbl_m_produk')->row();
                $sql_satuan  = $this->db->where('id_produk', $sql_brg->id)->where('satuan', $satuan)->get('tbl_m_produk_satuan')->row();
                $sql_satuan2 = $this->db->where('id', $sql_brg->id_satuan)->get('tbl_m_satuan')->row();
                $trans_beli  = $this->session->userdata('trans_beli');
                $pengaturan  = $this->db->get('tbl_pengaturan')->row();
                
                $jml_pcs     = $sql_satuan->jml * $qty;
                $harga_pcs   = ($harga * $qty) / $jml_pcs;
                $harga_sat   = $harga_pcs * $sql_satuan->jml;
                
                $disk1       = $harga_pcs - (($diskon1 / 100) * $harga_pcs);
                $disk2       = $disk1 - (($diskon2 / 100) * $disk1);
                $disk3       = $disk2 - (($diskon3 / 100) * $disk2);
                
                $harga_ppn   = ($trans_beli['status_ppn'] == '1' ? ($pengaturan->jml_ppn / 100) * $disk3 : 0);
                $harga_tot   = $disk3 + $harga_ppn;
                $subtotal    = ($disk3 * $jml_pcs) - $potongan;
                
                $jml_satuan  = $sql_satuan2->jml * $qty;
                
//                // Cek di keranjang
//                foreach ($this->cart->contents() as $cart){                    
//                    // Cek ada datanya kagak?
//                    if($sql_brg->kode == $cart['options']['kode'] AND $cart['options']['satuan'] == $satuan){
//                        $jml_subtotal      = ($cart['qty'] + $qty) * $sql_satuan->jml;                        
//                        $jml_qty           = ($cart['qty'] + $qty);                        
//                        
////                        $this->cart->update(array('rowid'=>$cart['rowid'], 'qty'=>0));
//                    }
//                }
//                
                $cart = array(
                    'id'      => rand(1,1024).$sql_brg->id,
                    'qty'     => $qty,
                    'price'   => $harga_sat, // number_format($harga, 2, '.',','),
                    'name'    => $sql_brg->produk,
                    'options' => array(
                            'no_nota'       => general::dekrip($no_nota),
                            'id_barang'     => $sql_brg->id,
                            'id_satuan'     => $sql_brg->id_satuan,
                            'satuan'        => $satuan,
                            'satuan_ket'    => ($sql_satuan->jml != 1 ? ' ('.(!empty($jml_subtotal) ? $jml_qty : $qty) * $sql_satuan->jml.' '.$sql_satuan2->satuanTerkecil.')' : ''),
                            'jml'           => $qty,
                            'jml_satuan'    => $sql_satuan->jml,
                            'jml_deposit'   => (!empty($qtydep) ? $qtydep : '0'),
                            'kode'          => $sql_brg->kode,
                            'harga'         => $harga_tot,
                            'ppn'           => $harga_ppn,
                            'potongan'      => $potongan,
                            'disk1'         => (float)$diskon1,
                            'disk2'         => (float)$diskon2,
                            'disk3'         => (float)$diskon3,
                            'subtotal'      => (float)$subtotal,
                    )
                );
//                echo $sql_satuan->jml;
//                echo '<pre>';
//                print_r($cart);
//                echo '<pre>';

                $this->cart->insert($cart);                
                redirect(base_url('transaksi/trans_beli.php?id='.$no_nota));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function cart_beli_simpan2() {
        if (akses::aksesLogin() == TRUE) {
            $id       = $this->input->post('id');
            $no_nota  = $this->input->post('no_nota');
            $kode     = $this->input->post('kode');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('kode', 'Kode', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'kode' => form_error('kode'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url('transaksi/trans_beli.php?id='.$no_nota));
            } else {
                $no = 1;
                foreach ($_POST['id'] as $pos){
                    $id       = $_POST['id'][$no];
                    $id_brg   = $_POST['id_barang'][$no];
                    $satuan   = $_POST['satuan'][$no];
                    $qty      = $_POST['jml'][$no];
                    $diskon1  = str_replace(',', '.', $_POST['disk1'][$no]);
                    $diskon2  = str_replace(',', '.', $_POST['disk2'][$no]);
                    $diskon3  = str_replace(',', '.', $_POST['disk3'][$no]);
                    $harga    = str_replace('.', '', $_POST['harga'][$no]);
                    $potongan = str_replace('.', '', $_POST['potongan'][$no]);
                    $qtydep   = str_replace('.', '', $_POST['jml_deposit'][$no]);
                    
                    $sql_brg     = $this->db->where('id', general::dekrip($id_brg))
                                        ->get('tbl_m_produk')->row();                
                    $sql_satuan  = $this->db->where('id_produk', $sql_brg->id)->where('satuan', $satuan)->get('tbl_m_produk_satuan')->row();
                    $sql_satuan2 = $this->db->where('id', $sql_brg->id_satuan)->get('tbl_m_satuan')->row();
                    $trans_beli  = $this->session->userdata('trans_beli');
                    $pengaturan  = $this->db->get('tbl_pengaturan')->row();
                    
                    $jml_pcs     = $sql_satuan->jml * $qty;
                    $harga_pcs   = ($harga * $qty) / $jml_pcs;
                    $harga_sat   = $harga_pcs * $sql_satuan->jml;
                    
                    $disk1       = $harga_pcs - (($diskon1 / 100) * $harga_pcs);
                    $disk2       = $disk1 - (($diskon2 / 100) * $disk1);
                    $disk3       = $disk2 - (($diskon3 / 100) * $disk2);
                    
                    $harga_ppn   = ($trans_beli['status_ppn'] == '1' ? ($pengaturan->jml_ppn / 100) * $disk3 : 0);
                    $harga_tot   = $disk3 + $harga_ppn;
                    $subtotal    = ($disk3 * $jml_pcs) - $potongan;
                    
                    $jml_satuan  = $sql_satuan2->jml * $qty;
    
                    $cart = array(
                        'rowid'   => $id,
                        'qty'     => $qty,
                        'price'   => $harga_sat,
                        'options' => array(
                                'no_nota'       => general::dekrip($no_nota),
                                'id_barang'     => $sql_brg->id,
                                'id_satuan'     => $sql_brg->id_satuan,
                                'satuan'        => $satuan,
                                'satuan_ket'    => ($sql_satuan->jml != 1 ? ' ('.(!empty($jml_subtotal) ? $jml_qty : $qty) * $sql_satuan->jml.' '.$sql_satuan2->satuanTerkecil.')' : ''),
                                'jml'           => $qty,
                                'jml_satuan'    => $sql_satuan->jml,
                                'jml_deposit'   => (!empty($qtydep) ? $qtydep : '0'),
                                'kode'          => $sql_brg->kode,
                                'harga'         => $harga_tot,
                                'ppn'           => $harga_ppn,
                                'potongan'      => $potongan,
                                'disk1'         => (float)$diskon1,
                                'disk2'         => (float)$diskon2,
                                'disk3'         => (float)$diskon3,
                                'subtotal'      => (float)$subtotal,
                        )
                    );
                    
                    $this->cart->update_all($cart);
                    
                    $no++;
                }

                
//                echo '<pre>';
//                print_r($_POST);

//                $this->cart->update_all($cart);                
                redirect(base_url('transaksi/trans_beli.php?id='.$no_nota));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function cart_beli_simpan_po() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota  = $this->input->post('no_nota');
            $id_brg   = $this->input->post('id_barang');
            $satuan   = $this->input->post('satuan');
            $kode     = $this->input->post('kode');
            $qty      = $this->input->post('jml');
            $ket      = $this->input->post('keterangan');
            $rute     = $this->input->post('rute');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('kode', 'Kode', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'kode' => form_error('kode'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url('transaksi/trans_beli_po.php?id='.$no_nota));
            } else {
                $sql_brg    = $this->db->where('id', general::dekrip($id_brg))
                                        ->get('tbl_m_produk')->row();
                $sql_satuan  = $this->db->where('id_produk', $sql_brg->id)->where('satuan', $satuan)->get('tbl_m_produk_satuan')->row();
                $sql_satuan2 = $this->db->where('id', $sql_brg->id_satuan)->get('tbl_m_satuan')->row();
                $trans_beli  = $this->session->userdata('trans_beli');
                $pengaturan  = $this->db->get('tbl_pengaturan')->row();
                
                $harga_tot= ($satuan == $sql_satuan->satuanBesar ? $harga * $sql_satuan->jml : $harga);
                $harga_sub= $harga_tot * $qty;
                $disk1    = $harga_sub - (($diskon1 / 100) * $harga_sub);
                $disk2    = $disk1 - (($diskon2 / 100) * $disk1);
                $disk3    = $disk2 - (($diskon3 / 100) * $disk2);
                
                $jml      = $qty;
                $jml_real = ($satuan == $sql_satuan->satuanBesar ? $sql_satuan->jml * $qty : $qty);
                $subtotal = $disk3 - $potongan;
                
                $cart = array(
                    'id_pembelian'   => general::dekrip($no_nota),
                    'id_user'        => $this->ion_auth->user()->row()->id,
                    'id_produk'      => $sql_brg->id,
                    'id_satuan'      => $sql_satuan->id_satuan,
                    'tgl_simpan'     => date('Y-m-d H:i:s'),
                    'kode'           => $kode,
                    'produk'         => $sql_brg->produk,
                    'jml'            => (int)$qty,
                    'jml_satuan'     => (int)$sql_satuan->jml,
                    'satuan'         => $satuan,
                    'keterangan'     => ($sql_satuan->jml != 1 ? ' ('.(!empty($jml_subtotal) ? $jml_qty : $qty) * $sql_satuan->jml.' '.$sql_satuan2->satuanTerkecil.')' : ''),
                    'keterangan_itm' => $ket,
                );

                crud::simpan('tbl_trans_beli_po_det', $cart);                
                redirect(base_url(!empty($rute) ? $rute.'?id='.$no_nota : 'transaksi/trans_beli_po.php?id='.$no_nota));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function cart_beli_update_po() {
        if (akses::aksesLogin() == TRUE) {
            $id       = $this->input->post('id');
            $no_nota  = $this->input->post('no_nota');
            $id_brg   = $this->input->post('id_barang');
            $satuan   = $this->input->post('satuan');
            $kode     = $this->input->post('kode');
            $qty      = $this->input->post('jml');
            $ket      = $this->input->post('keterangan');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id', 'Kode', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'id' => form_error('id'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url('transaksi/trans_beli_po.php?id='.$no_nota));
            } else {
                $sql_brg    = $this->db->where('id', general::dekrip($id_brg))
                                        ->get('tbl_m_produk')->row();
                $sql_satuan  = $this->db->where('id_produk', $sql_brg->id)->where('satuan', $satuan)->get('tbl_m_produk_satuan')->row();
                $sql_satuan2 = $this->db->where('id', $sql_brg->id_satuan)->get('tbl_m_satuan')->row();
                $trans_beli  = $this->session->userdata('trans_beli');
                $pengaturan  = $this->db->get('tbl_pengaturan')->row();
                
                $harga_tot= ($satuan == $sql_satuan->satuanBesar ? $harga * $sql_satuan->jml : $harga);
                $harga_sub= $harga_tot * $qty;
                $disk1    = $harga_sub - (($diskon1 / 100) * $harga_sub);
                $disk2    = $disk1 - (($diskon2 / 100) * $disk1);
                $disk3    = $disk2 - (($diskon3 / 100) * $disk2);
                
                $jml      = $qty;
                $jml_real = ($satuan == $sql_satuan->satuanBesar ? $sql_satuan->jml * $qty : $qty);
                $subtotal = $disk3 - $potongan;
                
                echo $id_brg;
                
                $cart = array(
                    'id_pembelian'   => general::dekrip($no_nota),
                    'id_user'        => $this->ion_auth->user()->row()->id,
                    'id_produk'      => $sql_brg->id,
                    'id_satuan'      => $sql_satuan->id_satuan,
                    'tgl_simpan'     => date('Y-m-d H:i:s'),
                    'kode'           => $sql_brg->kode,
                    'produk'         => $sql_brg->produk,
                    'jml'            => (int)$qty,
                    'jml_satuan'     => (int)$sql_satuan->jml,
                    'satuan'         => $satuan,
                    'keterangan'     => ($sql_satuan->jml != 1 ? ' ('.(!empty($jml_subtotal) ? $jml_qty : $qty) * $sql_satuan->jml.' '.$sql_satuan2->satuanTerkecil.')' : ''),
                );

                crud::update('tbl_trans_beli_po_det', 'id', general::dekrip($id), $cart);                
                redirect(base_url('transaksi/trans_beli_po.php?id='.$no_nota));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function   cart_beli_update() {
        if (akses::aksesLogin() == TRUE) {
            $id_pemb  = $this->input->post('id_pembelian');
            $no_nota  = $this->input->post('no_nota');
            $id_brg   = $this->input->post('id_barang');
            $satuan   = $this->input->post('satuan');
            $kode     = $this->input->post('kode');
            $qty      = $this->input->post('jml');
            $diskon1  = str_replace(',', '.', $this->input->post('disk1'));
            $diskon2  = str_replace(',', '.', $this->input->post('disk2'));
            $diskon3  = str_replace(',', '.', $this->input->post('disk3'));
            $harga    = str_replace('.', '', $this->input->post('harga'));
            $potongan = str_replace('.', '', $this->input->post('potongan'));

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('kode', 'Kode', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'kode' => form_error('kode'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url('transaksi/trans_beli.php?id='.$no_nota));
            } else {
                $sql_brg     = $this->db->where('id', general::dekrip($id_brg))
                                        ->get('tbl_m_produk')->row();
                $sql_det     = $this->db->where('id_pembelian', general::dekrip($id_pemb))->where('id_produk', $sql_brg->id)->get('tbl_trans_beli_det');
                $sql_satuan  = $this->db->where('id_produk', $sql_brg->id)->where('satuan', $satuan)->get('tbl_m_produk_satuan')->row();
                $sql_satuan2 = $this->db->where('id', $sql_brg->id_satuan)->get('tbl_m_satuan')->row();
                
                $jml_pcs     = $sql_satuan->jml * $qty;
                $harga_pcs   = ($harga * $qty) / $jml_pcs;
                $harga_sat   = $harga_pcs * $sql_satuan->jml;
                
                $disk1       = $harga_pcs - (($diskon1 / 100) * $harga_pcs);
                $disk2       = $disk1 - (($diskon2 / 100) * $disk1);
                $disk3       = $disk2 - (($diskon3 / 100) * $disk2);
                
                $harga_tot   = $disk3;
                $subtotal    = ($disk3 * $jml_pcs) - $potongan;
                               
                $data_penj_det = array(
                    'id_pembelian'  => general::dekrip($id_pemb),
                    'no_nota'       => $no_nota,
                    'tgl_simpan'    => date('Y-m-d H:i:s'),
                    'id_satuan'     => $sql_brg->id_satuan,
                    'id_produk'     => $sql_brg->id,
                    'satuan'        => $satuan,
                    'keterangan'    => ($sql_satuan->jml != '1' ? ' ('.(!empty($jml_subtotal) ? $jml_qty : $qty) * $sql_satuan->jml.' '.$sql_satuan2->satuanTerkecil.')' : ''),
                    'kode'          => $sql_brg->kode,
                    'produk'        => $sql_brg->produk,
                    'jml'           => $qty,
                    'jml_satuan'    => $sql_satuan->jml,
                    'harga'         => (float)$harga,
                    'disk1'         => (float)$diskon1,
                    'disk2'         => (float)$diskon2,
                    'disk3'         => (float)$diskon3,
//                    'diskon'        => '',
                    'potongan'      => (float)$potongan,
                    'subtotal'      => (float)$subtotal,
                );                                      
                
//                if($sql_det->num_rows() == 1){
//                    $jml_subtot_itm = $qty + $sql_det->row()->jml;
//                    $jml_subtot     = $jml_subtot_itm * $sql_det->row()->harga;
//                    $jml_subtot_sat = ($sql_satuan->jml != $qty ? $sql_satuan->jml : 1);
//                    $ket_upd        = ($sql_satuan->jml != $qty ? ' ('.$jml_subtot_itm * $sql_satuan->jml.' '.$sql_satuan2->satuanTerkecil.')' : '');
//                    
//                    $data_brg_upd = array('keterangan'=> $ket_upd, 'jml'=> $jml_subtot_itm, 'jml_satuan'=> $jml_subtot_sat, 'subtotal'=> $jml_subtot);
//                    crud::update('tbl_trans_beli_det', 'id', $sql_det->row()->id, $data_brg_upd);
//                }else{
                    crud::simpan('tbl_trans_beli_det', $data_penj_det);
//                }
//                
//                echo '<pre>';
//                print_r($data_penj_det);
//                echo '</pre>';
//                
//                echo '<pre>';
//                print_r($sql_det->row());
//                echo '</pre>';
//                
//                echo '<pre>';
//                print_r($data_brg);
//                echo '</pre>';
                
                redirect(base_url('transaksi/trans_beli_edit.php?id='.$id_pemb));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function cart_retur_jual_simpan() {
        if (akses::aksesLogin() == TRUE) {
            $id       = $this->input->post('id');
            $no_nota  = $this->input->post('no_nota');
            $id_brg   = $this->input->post('id_barang');
            $kode     = $this->input->post('kode');
            $qty      = $this->input->post('jml');
            $satuan   = $this->input->post('satuan');
            $diskon1  = $this->input->post('disk1');
            $diskon2  = $this->input->post('disk2');
            $diskon3  = $this->input->post('disk3');
            $tipe     = $this->input->post('tipe');
            $rute     = $this->input->post('route');
            $harga    = str_replace(',', '.', str_replace('.', '', $this->input->post('harga')));

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('kode', 'Kode', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'kode' => form_error('kode'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url('transaksi/trans_jual.php?id='.general::enkrip($no_nota)));
            } else {
                $sql_brg     = $this->db->where('id', general::dekrip($id_brg))
                                    ->get('tbl_m_produk')->row();
                $sql_satuan  = $this->db->where('id', $sql_brg->id_satuan)->get('tbl_m_satuan')->row();
                $sql_satuan2 = $this->db->where('id_produk', $sql_brg->id)->where('satuan', $satuan)->get('tbl_m_produk_satuan')->row();
                
                $disk1    = $harga - (($diskon1 / 100) * $harga);
                $disk2    = $disk1 - (($diskon2 / 100) * $disk1);
                $disk3    = $disk2 - (($diskon3 / 100) * $disk2);
                
                $harga_j  = ($satuan == $sql_satuan->satuanBesar ? $disk3 * $sql_satuan->jml : $disk3);
                $jml      = $qty; //($satuan == $sql_satuan->satuanBesar ? $sql_satuan->jml * $qty : $qty);
                $subtotal = $harga_j * $jml;
                
                $data_penj_det = array(
                    'id_retur_jual' => general::dekrip($id),
                    'tgl_simpan'    => date('Y-m-d H:i:s'),
                    'id_satuan'     => $sql_brg->id_satuan,
                    'kode'          => $sql_brg->kode,
                    'produk'        => $sql_brg->produk,
                    'satuan'        => $satuan,
                    'keterangan'    => ($satuan == $sql_satuan->satuanBesar ? ' ('.$jml * $sql_satuan->jml.' '.$sql_satuan->satuanTerkecil.')' : ''),
                    'jml'           => $jml,
                    'jml_satuan'    => $sql_satuan2->jml,
                    'harga'         => $harga,
                    'disk1'         => (!empty($diskon1) ? $diskon1 : '0'),
                    'disk2'         => (!empty($diskon2) ? $diskon2 : '0'),
                    'disk3'         => (!empty($diskon3) ? $diskon3 : '0'),
                    'subtotal'      => $subtotal,
                    'status_retur'  => $tipe,
                );
                
//                echo '<pre>';
//                print_r($data_penj_det);
//                echo '</pre>'; 
//                echo '<pre>';
//                print_r($sql_satuan2);
//                echo '</pre>'; 
                
                crud::simpan('tbl_trans_retur_jual_det', $data_penj_det);
                
                $sql_ret = $this->db->select_sum('subtotal')->where('id', general::dekrip($id))->get('tbl_trans_retur_jual_det')->row();

                if(!empty($sql_ret->subtotal)){
                    crud::update('tbl_trans_jual','id',general::dekrip($no_nota),array('jml_retur'=>$sql_ret->subtotal));
                }
                redirect(base_url('transaksi/trans_retur_jual.php?id='.$id.'&no_nota='.$no_nota.'&route='.$rute));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function cart_retur_beli_simpan() {
        if (akses::aksesLogin() == TRUE) {
            $id       = $this->input->post('id');
            $no_nota  = $this->input->post('no_nota');
            $id_brg   = $this->input->post('id_barang');
            $kode     = $this->input->post('kode');
            $qty      = $this->input->post('jml');
            $satuan   = $this->input->post('satuan');
            $diskon1  = $this->input->post('disk1');
            $diskon2  = $this->input->post('disk2');
            $diskon3  = $this->input->post('disk3');
            $tipe     = $this->input->post('tipe');
            $rute     = $this->input->post('route');
            $harga    = general::format_angka_db($this->input->post('harga'));

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('kode', 'Kode', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'kode' => form_error('kode'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url('transaksi/trans_retur_beli.php?id='.$id.'&no_nota='.$no_nota));
            } else {
                $sql_brg = $this->db->where('id', general::dekrip($id_brg))
                                    ->get('tbl_m_produk')->row();
                $sql_satuan = $this->db->where('id', $sql_brg->id_satuan)->get('tbl_m_satuan')->row();
                $sql_satuan2= $this->db->where('id_produk', $sql_brg->id)->where('satuan', $satuan)->get('tbl_m_produk_satuan')->row();
                
                $disk1    = $harga - (($diskon1 / 100) * $harga);
                $disk2    = $disk1 - (($diskon2 / 100) * $disk1);
                $disk3    = $disk2 - (($diskon3 / 100) * $disk2);
                $harga_j  = $disk3 * $sql_satuan2->jml;
                $jml      = $qty; //($satuan == $sql_satuan->satuanBesar ? $sql_satuan->jml * $qty : $qty);
                $subtotal = $harga_j * $jml;
                
                $data_penj_det = array(
                    'id_retur_beli' => general::dekrip($id),
                    'tgl_simpan'    => date('Y-m-d H:i:s'),
                    'id_satuan'     => $sql_brg->id_satuan,
                    'kode'          => $sql_brg->kode,
                    'produk'        => $sql_brg->produk,
                    'satuan'        => $satuan,
                    'keterangan'    => ($sql_satuan2->jml != '1' ? ' ('.$sql_satuan2->jml * $jml.' '.$sql_satuan->satuanTerkecil.')' : ''),
                    'jml'           => $jml,
                    'jml_satuan'    => $sql_satuan2->jml,
                    'harga'         => $harga,
                    'disk1'         => $diskon1,
                    'disk2'         => $diskon2,
                    'disk3'         => $diskon3,
                    'subtotal'      => $subtotal,
//                    'status_retur'  => $tipe,
                );                
                
                crud::simpan('tbl_trans_retur_beli_det', $data_penj_det);
                
//                echo '<pre>';
//                print_r($data_penj_det);
                
                $sql_ret = $this->db->select_sum('subtotal')->where('id', general::dekrip($id))->get('tbl_trans_retur_beli_det')->row();

                if(!empty($sql_ret->subtotal)){
                    crud::update('tbl_trans_beli','id',general::dekrip($no_nota),array('jml_retur'=>$sql_ret->subtotal));
                }
                redirect(base_url('transaksi/trans_retur_beli.php?id='.$id.'&no_nota='.$no_nota.'&route='.$rute));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function cart_retur_beli_hapus() {
        if (akses::aksesLogin() == TRUE) {
            $id    = $this->input->get('id');
            $nota  = $this->input->get('no_nota');
            $idp   = $this->input->get('id_barang');
            
            if(!empty($idp)){
                $sql_ret = $this->db->select_sum('subtotal')->where('id', general::dekrip($id))->get('tbl_trans_retur_beli_det')->row();
                
                crud::update('tbl_trans_beli','id',general::dekrip($nota),array('jml_retur'=>$sql_ret->subtotal));
                crud::delete('tbl_trans_retur_beli_det', 'id', general::dekrip($idp));
            }
            
            redirect(base_url('transaksi/trans_retur_beli.php?id='.$id.'&no_nota='.$nota));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }    
    
    public function cart_jual_hapus() {
        if (akses::aksesLogin() == TRUE) {
            $id    = $this->input->get('id');
            $nota  = $this->input->get('no_nota');
            $rute  = $this->input->get('route');
            
            if(!empty($id)){
                $cart = array(
                    'rowid' => general::dekrip($id),
                    'qty'   => 0
                );
                $this->cart->update($cart);
            }
            
            redirect(base_url('transaksi/'.(!empty($rute) ? $rute : 'trans_jual.php').'?id='.$nota));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function cart_jual_hapus_upd() {
        if (akses::aksesLogin() == TRUE) {
            $id    = $this->input->get('id');
            $nota  = $this->input->get('no_nota');
            
            if(!empty($id)){
                $sql_det     = $this->db->where('id', general::dekrip($id))->get('tbl_trans_jual_det')->row();
                $sql_brg     = $this->db->where('kode', $sql_det->kode)->get('tbl_m_produk')->row();
                $sql_brg_sat = $this->db->where('id_produk', $sql_brg->id)->where('id_penjualan', $sql_det->id_penjualan)->get('tbl_m_produk_hist')->row();
                $sql_sat     = $this->db->where('id', $sql_det->id_satuan)->get('tbl_m_satuan')->row();
                $jml_akh     = ($sql_det->jml * $sql_det->jml_satuan) + $sql_brg->jml;
                
                crud::update('tbl_m_produk', 'id', $sql_brg->id, array('jml'=>$jml_akh));
                crud::delete('tbl_trans_jual_det', 'id', general::dekrip($id));
                crud::delete('tbl_m_produk_hist', 'id', $sql_brg_sat->id);
            }
            
            redirect(base_url('transaksi/trans_jual_edit.php?id='.$nota));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function cart_jual_hapus_draft() {
        if (akses::aksesLogin() == TRUE) {
            $id    = $this->input->get('id');
            $nota  = $this->input->get('no_nota');
            
            if(!empty($id)){
                $sql_det     = $this->db->where('id', general::dekrip($id))->get('tbl_trans_jual_det')->row();
                $sql_brg     = $this->db->where('kode', $sql_det->kode)->get('tbl_m_produk')->row();
                $sql_brg_sat = $this->db->where('id_produk', $sql_brg->id)->where('id_penjualan', $sql_det->id_penjualan)->get('tbl_m_produk_hist')->row();
                $sql_sat     = $this->db->where('id', $sql_det->id_satuan)->get('tbl_m_satuan')->row();
                $jml_akh     = ($sql_det->jml * $sql_det->jml_satuan) + $sql_brg->jml;
                
                crud::update('tbl_m_produk', 'id', $sql_brg->id, array('jml'=>$jml_akh));
                crud::delete('tbl_trans_jual_det', 'id', general::dekrip($id));
                crud::delete('tbl_m_produk_hist', 'id', $sql_brg_sat->id);
            }
            
            redirect(base_url('transaksi/trans_jual_umum_draft.php?id='.$nota));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function cart_retur_jual_hapus() {
        if (akses::aksesLogin() == TRUE) {
            $id    = $this->input->get('id');
            $nota  = $this->input->get('no_nota');
            $idr   = $this->input->get('id_retur_det');
            
            if(!empty($idr)){
                crud::delete('tbl_trans_retur_jual_det', 'id', general::dekrip($idr));
            }

            redirect(base_url('transaksi/trans_retur_jual.php?id='.$id.'&no_nota='.$nota));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function cart_beli_hapus() {
        if (akses::aksesLogin() == TRUE) {
            $id    = $this->input->get('id');
            $nota  = $this->input->get('no_nota');
            
            if(!empty($id)){
                $cart = array(
                    'rowid' => general::dekrip($id),
                    'qty'   => 0
                );
                $this->cart->update($cart);
            }
            
            redirect(base_url('transaksi/trans_beli.php?id='.$nota));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function cart_beli_hapus_upd() {
        if (akses::aksesLogin() == TRUE) {
            $id    = $this->input->get('id');
            $nota  = $this->input->get('no_nota');
            
            if(!empty($id)){
                $sql_det = $this->db->where('id', general::dekrip($id))->get('tbl_trans_beli_det')->row();
                $sql_brg = $this->db->where('id', $sql_det->id_produk)->get('tbl_m_produk')->row();
                $sql_hst = $this->db->where('id_produk', $sql_det->id_produk)->where('id_pembelian', $sql_det->id_pembelian)->get('tbl_m_produk_hist')->result();
                $sql_sat = $this->db->where('id', $sql_det->id_satuan)->get('tbl_m_satuan')->row();
                
                foreach ($sql_hst as $hist){
                    $sql_stok   = $this->db->where('id_produk', $sql_det->id_produk)->where('id_gudang', $hist->id_gudang)->get('tbl_m_produk_stok')->row();
                    $stok_akhir = $sql_stok->jml - $hist->jml;
//                    $jml_akh = $sql_brg->jml - ($sql_det->jml * $sql_det->jml_satuan);
                    
                    $this->db->where('id_produk', $sql_det->id_produk)->where('id_gudang', $hist->id_gudang)->update('tbl_m_produk_stok', array('jml'=>$stok_akhir));
                    crud::delete('tbl_m_produk_hist', 'id', $hist->id);
                }
                
                $sql_stok_sum = $this->db->select_sum('jml')->where('id_produk', $sql_det->id_produk)->get('tbl_m_produk_stok')->row();
                               
                
                crud::update('tbl_m_produk', 'id', $sql_brg->id, array('jml' => ($sql_stok_sum->jml < '0' ? 0 : $sql_stok_sum->jml)));
                crud::delete('tbl_trans_beli_det', 'id',general::dekrip($id));
            }
            
            redirect(base_url('transaksi/trans_beli_edit.php?id='.$nota));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function cart_beli_hapus_po() {
        if (akses::aksesLogin() == TRUE) {
            $id    = $this->input->get('id');
            $nota  = $this->input->get('no_nota');
            
            if(!empty($id)){
                crud::delete('tbl_trans_beli_po_det', 'id', general::dekrip($id));
            }
            
            redirect(base_url('transaksi/trans_beli_po.php?id='.$nota));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function trans_jual_print_ex() {
        if (akses::aksesLogin() == TRUE) {
            $id         = $this->input->get('id');
            $aid        = general::dekrip($id);
            $sql        = $this->db->select('DATE(tgl_masuk) as tgl_simpan, tgl_keluar, id, no_nota, kode_nota_dpn, kode_nota_blk, id_pelanggan, id_sales, jml_total, jml_diskon, jml_biaya, jml_retur, jml_subtotal, ppn, jml_ppn, jml_gtotal, jml_bayar, jml_kembali, jml_kurang, status_ppn, metode_bayar')->where('tbl_trans_jual.id', $aid)->get('tbl_trans_jual')->row();
            $sql_det    = $this->db->select('tbl_trans_jual_det.id, tbl_trans_jual_det.kode, tbl_trans_jual_det.produk, tbl_trans_jual_det.jml, tbl_trans_jual_det.jml_satuan, tbl_trans_jual_det.satuan, tbl_trans_jual_det.keterangan, tbl_m_satuan.satuanTerkecil as sk, tbl_m_satuan.satuanBesar as sb, tbl_trans_jual_det.harga, tbl_trans_jual_det.subtotal')->join('tbl_m_satuan', 'tbl_m_satuan.id=tbl_trans_jual_det.id_satuan', 'left')->where('tbl_trans_jual_det.id_penjualan', $aid)->get('tbl_trans_jual_det');
            $sql_plat   = $this->db->select('tbl_m_platform.id, tbl_m_platform.platform, tbl_m_platform.persen, tbl_trans_jual_plat.no_nota, tbl_trans_jual_plat.platform as metode, tbl_trans_jual_plat.keterangan')->join('tbl_m_platform', 'tbl_m_platform.id=tbl_trans_jual_plat.id_platform')->where('tbl_trans_jual_plat.id_penjualan', $sql->id)->where('tbl_trans_jual_plat.id_platform', $sql->metode_bayar)->get('tbl_trans_jual_plat')->row();
            $member     = $this->db->where('id', $sql->id_pelanggan)->get('tbl_m_pelanggan')->row();
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
            $objPHPExcel->getActiveSheet()->getStyle('F4')->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('F4', strtoupper($member->alamat))->mergeCells('F4:H6');
            $objPHPExcel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A5', strtoupper($member->nama_toko.(!empty($member->lokasi) ? ' - '.$member->lokasi : '')))->mergeCells('A5:E5')
                    ->setCellValue('F5', '');
            
            $objPHPExcel->getActiveSheet()->getStyle('A6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A6', 'NOTA : '.$sql->kode_nota_dpn.$sql->no_nota.'/'.$sql->kode_nota_blk)->mergeCells('A6:C6');
            
            $objPHPExcel->getActiveSheet()->getStyle('D6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('D6', 'Jth Tempo : '.$this->tanggalan->tgl_indo($sql->tgl_keluar))->mergeCells('D6:E6');

            // Header Tabel Nota
            $objPHPExcel->getActiveSheet()->getRowDimension('7')->setRowHeight(18.75);
            $objPHPExcel->getActiveSheet()->getStyle('A7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('B7:C7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('D7:E7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle('F7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle('G7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getStyle('H7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A7', 'No.')
                    ->setCellValue('B7', 'Banyaknya')->mergeCells('B7:C7')
                    ->setCellValue('D7', 'Nama Barang')->mergeCells('D7:E7')
                    ->setCellValue('F7', 'Kode')
                    ->setCellValue('G7', 'Harga')
                    ->setCellValue('H7', 'Subtotal');
            
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(6);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(6);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(14);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12);   
            
            // Detail barang
            $no    = 1;
            $cell  = 8;
            $cel   = 8;
            foreach ($sql_det->result() as $items){
                $produk  = $this->db->where('kode', $items->kode)->get('tbl_m_produk')->row();
                
                // Format Angka
//                $objPHPExcel->getActiveSheet()->getStyle('G' . $cell.':H'.$cell)->getNumberFormat()->setFormatCode("#.##0");
//                $objPHPExcel->getActiveSheet()->getStyle('G' . $cell.':H'.$cell)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
                $objPHPExcel->getActiveSheet()->getRowDimension($cell)->setRowHeight(18.75);
                $objPHPExcel->getActiveSheet()->getStyle('G'.$cell.':H'.$cell)->getNumberFormat()->setFormatCode("_(\"\"* #,##0_);_(\"\"* \(#,##0\);_(\"\"* \"-\"??_);_(@_)");
                $objPHPExcel->getActiveSheet()->getStyle('F'.$cell)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
                
                // Format Alignment
                $objPHPExcel->getActiveSheet()->getStyle('A'.$cell.':H'.$cell)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                
                $objPHPExcel->getActiveSheet()->getStyle('A'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('B'.$cell.':C'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objPHPExcel->getActiveSheet()->getStyle('D'.$cell.':E'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objPHPExcel->getActiveSheet()->getStyle('F'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objPHPExcel->getActiveSheet()->getStyle('G'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $objPHPExcel->getActiveSheet()->getStyle('H'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                
                $kiri = substr($items->kode, 0, 1);
                
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A'.$cell, $no)
                            ->setCellValue('B'.$cell, (!empty($items->keterangan) ? $items->jml : $items->jml))
                            ->setCellValue('C'.$cell, $items->satuan)
                            ->setCellValue('D'.$cell, $items->produk)->mergeCells('D'.$cell.':E'.$cell)
                            ->setCellValue('F'.$cell, ' '.$items->kode)
                            ->setCellValue('G'.$cell, ($items->harga != 0 ? $items->harga : '')) //number_format($items->harga,'0','.',',')
                            ->setCellValue('H'.$cell, ($items->subtotal != 0 ? $items->subtotal : '')); //number_format($items->subtotal,'0','.',',')
                
                $no++;
                $cell++;
            }
            
            // Maximal baris
            if($sql_det->num_rows() >= 40){
//                $jmlbaris = 8;
                $sell = $cell;
            }else{
                $jmlbaris = 33 - (int) $cell;
                
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
                        
//          Font Nota Detail            
            $objPHPExcel->getActiveSheet()->getStyle('A8:H'.$cell)->getFont()->setSize('12')->setName('Times New Roman');
                      
            
            
            // Hitung sell bawah
            $sell2     = $sell + 1;
            $sellbwh1  = $sell2 + 1;
            $sellbwh2  = $sellbwh1 + 1;
            $sellbwh3  = $sellbwh2 + 1;
            $sellbwh4  = $sellbwh3 + 1;
            $sellbwh5  = $sellbwh4 + 1;
            $sellbwh6  = $sellbwh5 + 1;
            $sellbwh7  = $sellbwh6 + 1;
            $sellbwh8  = $sellbwh7 + 1;
            $sellbwh9  = $sellbwh8 + 1;
            $sellbwh10 = $sellbwh9 + 1;
            
            // border bawah
            $objPHPExcel->getActiveSheet()->getStyle('A'.$sell2.':H'.$sell2)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$sell2.':H'.$sellbwh10)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            
            // Subtotal, ppn, grand total
            $objPHPExcel->getActiveSheet()->getStyle('A'.$sell2.':F'.$sell2)->getFont()->setSize('12')->setName('Times New Roman');
            $objPHPExcel->getActiveSheet()->getStyle('G'.$sell2.':H'.$sell2)->getFont()->setSize('12')->setName('Times New Roman')->setBold(TRUE);
            
            $objPHPExcel->getActiveSheet()->getStyle('A'.$sell2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('D'.$sell2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('G'.$sell2.':H'.$sell2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getStyle('H' . $sell2)->getNumberFormat()->setFormatCode("_(\"\"* #,##0_);_(\"\"* \(#,##0\);_(\"\"* \"-\"??_);_(@_)");
            $objPHPExcel->getActiveSheet()->getRowDimension($sell2)->setRowHeight(18.75);
//            $objPHPExcel->getActiveSheet()->getStyle('H' . $sell2)->getNumberFormat()->setFormatCode("_(\"Rp\"* #,##0_);_(\"Rp\"* \(#,##0\);_(\"Rp\"* \"-\"??_);_(@_)");
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $sell2, 'Tanda Terima')->mergeCells('A' . $sell2.':C' . $sell2)
                    ->setCellValue('D' . $sell2, 'Perhatian : Barang2 yang sudah dibeli')->mergeCells('D' . $sell2.':F' . $sell2)
                    ->setCellValue('G' . $sell2, 'Total')
                    ->setCellValue('H' . $sell2, ceil($sql->jml_total));
            
            $objPHPExcel->getActiveSheet()->getStyle('A'.$sellbwh1.':F'.$sellbwh1)->getFont()->setSize('12')->setName('Times New Roman');
            $objPHPExcel->getActiveSheet()->getStyle('G'.$sellbwh1.':H'.$sellbwh1)->getFont()->setSize('12')->setName('Times New Roman')->setBold(TRUE);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$sellbwh1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('D'.$sellbwh1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('G'.$sellbwh1.':H'.$sellbwh1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getStyle('H' . $sellbwh1)->getNumberFormat()->setFormatCode("_(\"\"* #,##0_);_(\"\"* \(#,##0\);_(\"\"* \"-\"??_);_(@_)");
            $objPHPExcel->getActiveSheet()->getRowDimension($sellbwh1)->setRowHeight(18.75);
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $sellbwh1, '')->mergeCells('A' . $sellbwh1.':C' . $sellbwh1)
                    ->setCellValue('D' . $sellbwh1, 'tidak dapat di kembalikan / ditukar')->mergeCells('D' . $sellbwh1.':F' . $sellbwh1)
                    ->setCellValue('G' . $sellbwh1, 'Diskon')
                    ->setCellValue('H' . $sellbwh1, ($sql->jml_diskon != 0 ? ceil($sql->jml_diskon) : 0));
            
            $objPHPExcel->getActiveSheet()->getStyle('G'.$sellbwh2.':H'.$sellbwh2)->getFont()->setSize('12')->setName('Times New Roman')->setBold(TRUE);
            $objPHPExcel->getActiveSheet()->getStyle('G'.$sellbwh2.':H'.$sellbwh2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getStyle('H' . $sellbwh2)->getNumberFormat()->setFormatCode("_(\"\"* #,##0_);_(\"\"* \(#,##0\);_(\"\"* \"-\"??_);_(@_)");
            $objPHPExcel->getActiveSheet()->getRowDimension($sellbwh2)->setRowHeight(18.75);
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $sellbwh2, '')->mergeCells('A' . $sellbwh2.':C' . $sellbwh2)
                    ->setCellValue('G' . $sellbwh2, 'Retur')
                    ->setCellValue('H' . $sellbwh2, ($sql->jml_retur != 0 ? ceil($sql->jml_retur) : 0));
            
            if($sql->status_ppn == 1){
                $objPHPExcel->getActiveSheet()->getStyle('G'.$sellbwh3.':H'.$sellbwh3)->getFont()->setSize('12')->setName('Times New Roman')->setBold(TRUE);
                $objPHPExcel->getActiveSheet()->getStyle('G'.$sellbwh3.':H'.$sellbwh3)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $objPHPExcel->getActiveSheet()->getStyle('H' . $sellbwh3)->getNumberFormat()->setFormatCode("_(\"\"* #,##0_);_(\"\"* \(#,##0\);_(\"\"* \"-\"??_);_(@_)");
                $objPHPExcel->getActiveSheet()->getRowDimension($sellbwh3)->setRowHeight(18.75);
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $sellbwh3, '')->mergeCells('A' . $sellbwh3.':C' . $sellbwh3)
                        ->setCellValue('G' . $sellbwh3, ($sql->status_ppn == 1) ? 'DPP' : 'Subtotal')
                        ->setCellValue('H' . $sellbwh3, ($sql->jml_subtotal != 0 ? ceil($sql->jml_subtotal) : 0));
            
                $objPHPExcel->getActiveSheet()->getStyle('G'.$sellbwh4.':H'.$sellbwh4)->getFont()->setSize('12')->setName('Times New Roman')->setBold(TRUE);
                $objPHPExcel->getActiveSheet()->getStyle('G'.$sellbwh4.':H'.$sellbwh4)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $objPHPExcel->getActiveSheet()->getStyle('H' . $sellbwh4)->getNumberFormat()->setFormatCode("_(\"\"* #,##0_);_(\"\"* \(#,##0\);_(\"\"* \"-\"??_);_(@_)");
                $objPHPExcel->getActiveSheet()->getRowDimension($sellbwh4)->setRowHeight(18.75);
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $sellbwh4, '')->mergeCells('A' . $sellbwh4.':C' . $sellbwh4)
                        ->setCellValue('G' . $sellbwh4, 'PPN '.($sql->ppn != 0 ? round($sql->ppn).'%' : ''))
                        ->setCellValue('H' . $sellbwh4, ($sql->jml_ppn != 0 ? ceil($sql->jml_ppn) : 0));
            
                $objPHPExcel->getActiveSheet()->getStyle('G'.$sellbwh5.':H'.$sellbwh5)->getFont()->setSize('12')->setName('Times New Roman')->setBold(TRUE);
                $objPHPExcel->getActiveSheet()->getStyle('G'.$sellbwh5.':H'.$sellbwh5)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $objPHPExcel->getActiveSheet()->getStyle('H' . $sellbwh5)->getNumberFormat()->setFormatCode("_(\"\"* #,##0_);_(\"\"* \(#,##0\);_(\"\"* \"-\"??_);_(@_)");
                $objPHPExcel->getActiveSheet()->getRowDimension($sellbwh5)->setRowHeight(18.75);
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $sellbwh5, '')->mergeCells('A' . $sellbwh5.':C' . $sellbwh5)
                        ->setCellValue('G' . $sellbwh5, 'Grand Total')
                        ->setCellValue('H' . $sellbwh5, ($sql->jml_gtotal != 0 ? ceil($sql->jml_gtotal) : 0));
    
                $objPHPExcel->getActiveSheet()->getStyle('G'.$sellbwh6.':H'.$sellbwh6)->getFont()->setSize('12')->setName('Times New Roman')->setBold(TRUE);
                $objPHPExcel->getActiveSheet()->getStyle('G'.$sellbwh6.':H'.$sellbwh6)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $objPHPExcel->getActiveSheet()->getStyle('H' . $sellbwh6)->getNumberFormat()->setFormatCode("_(\"\"* #,##0_);_(\"\"* \(#,##0\);_(\"\"* \"-\"??_);_(@_)");
                $objPHPExcel->getActiveSheet()->getRowDimension($sellbwh6)->setRowHeight(18.75);
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $sellbwh6, '')->mergeCells('A' . $sellbwh6.':C' . $sellbwh6)
                        ->setCellValue('G' . $sellbwh6, 'Jml Bayar')
                        ->setCellValue('H' . $sellbwh6, ($sql->jml_bayar != 0 ? ceil($sql->jml_bayar) : 0));
                
                $objPHPExcel->getActiveSheet()->getStyle('G'.$sellbwh7.':H'.$sellbwh7)->getFont()->setSize('12')->setName('Times New Roman')->setBold(TRUE);
                $objPHPExcel->getActiveSheet()->getStyle('G'.$sellbwh7.':H'.$sellbwh7)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $objPHPExcel->getActiveSheet()->getStyle('H' . $sellbwh7)->getNumberFormat()->setFormatCode("_(\"\"* #,##0_);_(\"\"* \(#,##0\);_(\"\"* \"-\"??_);_(@_)");
                $objPHPExcel->getActiveSheet()->getRowDimension($sellbwh7)->setRowHeight(18.75);
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $sellbwh7, '')->mergeCells('A' . $sellbwh7.':C' . $sellbwh7)
                        ->setCellValue('G' . $sellbwh7, 'Jml Kembali')
                        ->setCellValue('H' . $sellbwh7, ($sql->jml_kembali != 0 ? ceil($sql->jml_kembali) : 0));
            }else{
                
                $objPHPExcel->getActiveSheet()->getStyle('G'.$sellbwh3.':H'.$sellbwh3)->getFont()->setSize('12')->setName('Times New Roman')->setBold(TRUE);
                $objPHPExcel->getActiveSheet()->getStyle('G'.$sellbwh3.':H'.$sellbwh3)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $objPHPExcel->getActiveSheet()->getStyle('H' . $sellbwh3)->getNumberFormat()->setFormatCode("_(\"\"* #,##0_);_(\"\"* \(#,##0\);_(\"\"* \"-\"??_);_(@_)");
                $objPHPExcel->getActiveSheet()->getRowDimension($sellbwh3)->setRowHeight(18.75);
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $sellbwh3, '')->mergeCells('A' . $sellbwh3.':C' . $sellbwh3)
                        ->setCellValue('G' . $sellbwh3, 'Biaya / Charge')
                        ->setCellValue('H' . $sellbwh3, ($sql->jml_biaya != 0 ? ceil($sql->jml_biaya) : 0));
                
                $objPHPExcel->getActiveSheet()->getStyle('G'.$sellbwh4.':H'.$sellbwh4)->getFont()->setSize('12')->setName('Times New Roman')->setBold(TRUE);
                $objPHPExcel->getActiveSheet()->getStyle('G'.$sellbwh4.':H'.$sellbwh4)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $objPHPExcel->getActiveSheet()->getStyle('H' . $sellbwh4)->getNumberFormat()->setFormatCode("_(\"\"* #,##0_);_(\"\"* \(#,##0\);_(\"\"* \"-\"??_);_(@_)");
                $objPHPExcel->getActiveSheet()->getRowDimension($sellbwh4)->setRowHeight(18.75);
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $sellbwh4, '')->mergeCells('A' . $sellbwh4.':C' . $sellbwh4)
                        ->setCellValue('G' . $sellbwh4, 'Grand Total')
                        ->setCellValue('H' . $sellbwh4, ($sql->jml_gtotal != 0 ? ceil($sql->jml_gtotal) : 0));
    
                $objPHPExcel->getActiveSheet()->getStyle('G'.$sellbwh5.':H'.$sellbwh5)->getFont()->setSize('12')->setName('Times New Roman')->setBold(TRUE);
                $objPHPExcel->getActiveSheet()->getStyle('G'.$sellbwh5.':H'.$sellbwh5)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $objPHPExcel->getActiveSheet()->getStyle('H' . $sellbwh5)->getNumberFormat()->setFormatCode("_(\"\"* #,##0_);_(\"\"* \(#,##0\);_(\"\"* \"-\"??_);_(@_)");
                $objPHPExcel->getActiveSheet()->getRowDimension($sellbwh5)->setRowHeight(18.75);
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $sellbwh5, '')->mergeCells('A' . $sellbwh5.':C' . $sellbwh5)
                        ->setCellValue('G' . $sellbwh5, 'Jml Bayar')
                        ->setCellValue('H' . $sellbwh5, ($sql->jml_bayar != 0 ? ceil($sql->jml_bayar) : 0));
                
                $objPHPExcel->getActiveSheet()->getStyle('G'.$sellbwh6.':H'.$sellbwh6)->getFont()->setSize('12')->setName('Times New Roman')->setBold(TRUE);
                $objPHPExcel->getActiveSheet()->getStyle('G'.$sellbwh6.':H'.$sellbwh6)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $objPHPExcel->getActiveSheet()->getStyle('H' . $sellbwh6)->getNumberFormat()->setFormatCode("_(\"\"* #,##0_);_(\"\"* \(#,##0\);_(\"\"* \"-\"??_);_(@_)");
                $objPHPExcel->getActiveSheet()->getRowDimension($sellbwh6)->setRowHeight(18.75);
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $sellbwh6, '')->mergeCells('A' . $sellbwh6.':C' . $sellbwh6)
                        ->setCellValue('G' . $sellbwh6, 'Jml Kembali')
                        ->setCellValue('H' . $sellbwh6, ($sql->jml_kembali != 0 ? ceil($sql->jml_kembali) : 0));                
                
                $objPHPExcel->getActiveSheet()->getStyle('A'.$sellbwh7.':H'.$sellbwh7)->getFont()->setSize('12')->setName('Times New Roman')->setItalic(TRUE);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$sellbwh7.':H'.$sellbwh7)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                
                $objPHPExcel->getActiveSheet()->getRowDimension($sellbwh7)->setRowHeight(18.75);
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $sellbwh7, ' * '.$sql_plat->platform.' - '.$sql_plat->metode.(!empty($sql_plat->keterangan) ? ' '.$sql_plat->keterangan : ''))->mergeCells('A' . $sellbwh7.':F' . $sellbwh7)
                        ->setCellValue('G' . $sellbwh7, '')
                        ->setCellValue('H' . $sellbwh7, '');                
            }
            
            // border penutup
            $objPHPExcel->getActiveSheet()->getStyle('A'.$sellbwh10)->getFont()->setSize('10')->setName('Times New Roman');
            $objPHPExcel->getActiveSheet()->getStyle('A'.$sellbwh10.':H'.$sellbwh10)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUMDASHED);
            /* END CONTENT EXCEL -- */
            
            // Rename worksheet
            $objPHPExcel->getActiveSheet()->setTitle('Nota '.$sql->kode_nota_dpn.$sql->no_nota.'-'.$sql->kode_nota_blk);

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
            header('Content-Disposition: attachment;filename="nota-'.strtolower($sql->kode_nota_dpn.$sql->no_nota.'-'.$sql->kode_nota_blk).'.xls"');

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
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function trans_jual_print_ex_pen() {
        if (akses::aksesLogin() == TRUE) {
            $setting    = $this->db->get('tbl_pengaturan')->row();
            $id         = $this->input->get('id');
            $aid        = general::dekrip($id);
            $sql        = $this->db->select('DATE(tgl_simpan) as tgl_simpan, tgl_masuk, tgl_keluar, no_nota, kode_nota_dpn, kode_nota_blk, id_pelanggan, id_sales, jml_total, jml_diskon, jml_retur, jml_subtotal, ppn, jml_ppn, jml_gtotal, jml_bayar, jml_kembali, jml_kurang, status_ppn')->where('tbl_trans_jual_pen.no_nota', $aid)->get('tbl_trans_jual_pen')->row();
            $sql_det    = $this->db->select('tbl_trans_jual_pen_det.id, tbl_trans_jual_pen_det.kode, tbl_trans_jual_pen_det.produk, tbl_trans_jual_pen_det.jml, tbl_trans_jual_pen_det.jml_satuan, tbl_trans_jual_pen_det.satuan, tbl_trans_jual_pen_det.keterangan, tbl_m_satuan.satuanTerkecil as sk, tbl_m_satuan.satuanBesar as sb, tbl_trans_jual_pen_det.harga, tbl_trans_jual_pen_det.subtotal')->join('tbl_m_satuan', 'tbl_m_satuan.id=tbl_trans_jual_pen_det.id_satuan')->where('tbl_trans_jual_pen_det.no_nota', $aid)->get('tbl_trans_jual_pen_det');
            $member     = $this->db->where('id', $sql->id_pelanggan)->get('tbl_m_pelanggan')->row();
            $sales      = $this->db->where('id', $sql->id_sales)->get('tbl_m_sales')->row();
            $pengaturan = $this->db->get('tbl_pengaturan')->row();
                                    
            $objPHPExcel = new PHPExcel();            

            // Font size nota
            $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getFont()->setSize('13')->setName('Times New Roman');
            $objPHPExcel->getActiveSheet()->getStyle('F1:H1')->getFont()->setSize('11')->setName('Times New Roman');
            $objPHPExcel->getActiveSheet()->getStyle('A2:H2')->getFont()->setSize('11')->setName('Times New Roman');
            $objPHPExcel->getActiveSheet()->getStyle('A3:H3')->getFont()->setSize('11')->setName('Times New Roman');
            $objPHPExcel->getActiveSheet()->getStyle('A4:H4')->getFont()->setSize('11')->setName('Times New Roman');
            $objPHPExcel->getActiveSheet()->getStyle('A5:H5')->getFont()->setSize('11')->setName('Times New Roman')->setBold(TRUE);
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
            $objPHPExcel->getActiveSheet()->getStyle('F4')->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('F4', strtoupper($member->alamat))->mergeCells('F4:H6');
            $objPHPExcel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A5', 'SURAT PENAWARAN HARGA')->mergeCells('A5:E5')
                    ->setCellValue('F5', '');
            
            $objPHPExcel->getActiveSheet()->getStyle('A6:E6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A6', 'No. Penawaran : '.$sql->kode_nota_dpn.$sql->no_nota.'/'.$sql->kode_nota_blk)->mergeCells('A6:E6');

            // Header Tabel Nota
            $objPHPExcel->getActiveSheet()->getRowDimension('7')->setRowHeight(18.75);
            $objPHPExcel->getActiveSheet()->getStyle('A7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('B7:C7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('D7:E7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle('F7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle('G7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getStyle('H7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A7', 'No.')
                    ->setCellValue('B7', 'Banyaknya')->mergeCells('B7:C7')
                    ->setCellValue('D7', 'Nama Barang')->mergeCells('D7:E7')
                    ->setCellValue('F7', 'Kode')
                    ->setCellValue('G7', 'Harga')
                    ->setCellValue('H7', 'Subtotal');
            
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(6);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(6);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(24);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(14);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(11);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12);   
            
            // Detail barang
            $no    = 1;
            $cell  = 8;
            $cel   = 8;
            foreach ($sql_det->result() as $items){
                $produk  = $this->db->where('kode', $items->kode)->get('tbl_m_produk')->row();
                
                // Format Angka
//                $objPHPExcel->getActiveSheet()->getStyle('G' . $cell.':H'.$cell)->getNumberFormat()->setFormatCode("#.##0");
//                $objPHPExcel->getActiveSheet()->getStyle('G' . $cell.':H'.$cell)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
                $objPHPExcel->getActiveSheet()->getRowDimension($cell)->setRowHeight(18.75);
                $objPHPExcel->getActiveSheet()->getStyle('G'.$cell.':H'.$cell)->getNumberFormat()->setFormatCode("_(\"\"* #,##0_);_(\"\"* \(#,##0\);_(\"\"* \"-\"??_);_(@_)");
                $objPHPExcel->getActiveSheet()->getStyle('F'.$cell)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
                
                // Format Alignment
                $objPHPExcel->getActiveSheet()->getStyle('A'.$cell.':H'.$cell)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                
                $objPHPExcel->getActiveSheet()->getStyle('A'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('B'.$cell.':C'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objPHPExcel->getActiveSheet()->getStyle('D'.$cell.':E'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objPHPExcel->getActiveSheet()->getStyle('F'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objPHPExcel->getActiveSheet()->getStyle('G'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $objPHPExcel->getActiveSheet()->getStyle('H'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                
                $kiri = substr($items->kode, 0, 1);
                
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A'.$cell, $no)
                            ->setCellValue('B'.$cell, (!empty($items->keterangan) ? $items->jml : $items->jml))
                            ->setCellValue('C'.$cell, $items->satuan)
                            ->setCellValue('D'.$cell, $items->produk)->mergeCells('D'.$cell.':E'.$cell)
                            ->setCellValue('F'.$cell, ' '.$items->kode)
                            ->setCellValue('G'.$cell, ($items->harga != 0 ? $items->harga : '')) //number_format($items->harga,'0','.',',')
                            ->setCellValue('H'.$cell, ($items->subtotal != 0 ? ($items->jml * $items->jml_satuan) * $items->harga : '')); //number_format($items->subtotal,'0','.',',')
                
                $no++;
                $cell++;
            }
            
            // Maximal baris
            if($sql_det->num_rows() >= 40){
//                $jmlbaris = 8;
                $sell = $cell;
            }else{
                $jmlbaris = 33 - (int) $cell;
                
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
                        
//          Font Nota Detail            
            $objPHPExcel->getActiveSheet()->getStyle('A8:H'.$cell)->getFont()->setSize('12')->setName('Times New Roman');
                      
            
            
            // Hitung sell bawah
            $sell2     = $sell + 1;
            $sellbwh1  = $sell2 + 1;
            $sellbwh2  = $sellbwh1 + 1;
            $sellbwh3  = $sellbwh2 + 1;
            $sellbwh4  = $sellbwh3 + 1;
            $sellbwh5  = $sellbwh4 + 1;
            $sellbwh6  = $sellbwh5 + 1;
            $sellbwh7  = $sellbwh6 + 1;
            $sellbwh8  = $sellbwh7 + 1;
            $sellbwh9  = $sellbwh8 + 1;
            $sellbwh10 = $sellbwh9 + 1;
            
            // border bawah
            $objPHPExcel->getActiveSheet()->getStyle('A'.$sell2.':H'.$sell2)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$sell2.':H'.$sellbwh10)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            
            // Subtotal, ppn, grand total
            $objPHPExcel->getActiveSheet()->getStyle('A'.$sell2.':F'.$sell2)->getFont()->setSize('12')->setName('Times New Roman');
            $objPHPExcel->getActiveSheet()->getStyle('G'.$sell2.':H'.$sell2)->getFont()->setSize('12')->setName('Times New Roman')->setBold(TRUE);
            
            $objPHPExcel->getActiveSheet()->getStyle('A'.$sell2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('D'.$sell2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('G'.$sell2.':H'.$sell2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getStyle('H' . $sell2)->getNumberFormat()->setFormatCode("_(\"\"* #,##0_);_(\"\"* \(#,##0\);_(\"\"* \"-\"??_);_(@_)");
            $objPHPExcel->getActiveSheet()->getRowDimension($sell2)->setRowHeight(18.75);
            
            $objPHPExcel->getActiveSheet()->getStyle('A'.$sell2.':F'.$sell2)->getFont()->setSize('11')->setName('Times New Roman');
            $objPHPExcel->getActiveSheet()->getStyle('A'.$sell2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $sell2, '* Penawaran berlaku hingga : '.$this->tanggalan->tgl_indo($sql->tgl_keluar))->mergeCells('A' . $sell2.':F' . $sell2)
                    ->setCellValue('G' . $sell2, 'Total')
                    ->setCellValue('H' . $sell2, ceil($sql->jml_total));
            
            $objPHPExcel->getActiveSheet()->getStyle('A'.$sellbwh1.':F'.$sellbwh1)->getFont()->setSize('12')->setName('Times New Roman');
            $objPHPExcel->getActiveSheet()->getStyle('G'.$sellbwh1.':H'.$sellbwh1)->getFont()->setSize('12')->setName('Times New Roman')->setBold(TRUE);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$sellbwh1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('D'.$sellbwh1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('G'.$sellbwh1.':H'.$sellbwh1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getStyle('H' . $sellbwh1)->getNumberFormat()->setFormatCode("_(\"\"* #,##0_);_(\"\"* \(#,##0\);_(\"\"* \"-\"??_);_(@_)");
            $objPHPExcel->getActiveSheet()->getRowDimension($sellbwh1)->setRowHeight(18.75);
            
            $objPHPExcel->getActiveSheet()->getStyle('A'.$sellbwh1.':F'.$sellbwh1)->getFont()->setSize('11')->setName('Times New Roman');
            $objPHPExcel->getActiveSheet()->getStyle('A'.$sellbwh1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $sellbwh1, '* Harga tidak mengikat, sewaktu-waktu dapat berubah')->mergeCells('A' . $sellbwh1.':F' . $sellbwh1)
                    ->setCellValue('G' . $sellbwh1, 'Diskon')
                    ->setCellValue('H' . $sellbwh1, ($sql->jml_diskon != 0 ? ceil($sql->jml_diskon) : 0));
            
            if($sql->status_ppn == 1){
                $objPHPExcel->getActiveSheet()->getStyle('G'.$sellbwh2.':H'.$sellbwh2)->getFont()->setSize('12')->setName('Times New Roman')->setBold(TRUE);
                $objPHPExcel->getActiveSheet()->getStyle('G'.$sellbwh2.':H'.$sellbwh2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $objPHPExcel->getActiveSheet()->getStyle('H' . $sellbwh2)->getNumberFormat()->setFormatCode("_(\"\"* #,##0_);_(\"\"* \(#,##0\);_(\"\"* \"-\"??_);_(@_)");
                $objPHPExcel->getActiveSheet()->getRowDimension($sellbwh2)->setRowHeight(18.75);
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $sellbwh2, '')->mergeCells('A' . $sellbwh2.':C' . $sellbwh2)
                        ->setCellValue('G' . $sellbwh2, 'Subtotal')
                        ->setCellValue('H' . $sellbwh2, ($sql->jml_subtotal != 0 ? ceil($sql->jml_subtotal) : 0));
            
                $objPHPExcel->getActiveSheet()->getStyle('G'.$sellbwh3.':H'.$sellbwh3)->getFont()->setSize('12')->setName('Times New Roman')->setBold(TRUE);
                $objPHPExcel->getActiveSheet()->getStyle('G'.$sellbwh3.':H'.$sellbwh3)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $objPHPExcel->getActiveSheet()->getStyle('H' . $sellbwh3)->getNumberFormat()->setFormatCode("_(\"\"* #,##0_);_(\"\"* \(#,##0\);_(\"\"* \"-\"??_);_(@_)");
                $objPHPExcel->getActiveSheet()->getRowDimension($sellbwh3)->setRowHeight(18.75);
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $sellbwh3, '')->mergeCells('A' . $sellbwh3.':C' . $sellbwh3)
                        ->setCellValue('G' . $sellbwh3, 'PPN '.($sql->ppn != 0 ? round($sql->ppn).'%' : ''))
                        ->setCellValue('H' . $sellbwh3, ($sql->jml_ppn != 0 ? ceil($sql->jml_ppn) : 0));
            }
            
            $objPHPExcel->getActiveSheet()->getStyle('G'.$sellbwh4.':H'.$sellbwh4)->getFont()->setSize('12')->setName('Times New Roman')->setBold(TRUE);
            $objPHPExcel->getActiveSheet()->getStyle('G'.$sellbwh4.':H'.$sellbwh4)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getStyle('H' . $sellbwh4)->getNumberFormat()->setFormatCode("_(\"\"* #,##0_);_(\"\"* \(#,##0\);_(\"\"* \"-\"??_);_(@_)");
            $objPHPExcel->getActiveSheet()->getRowDimension($sellbwh4)->setRowHeight(18.75);
            
            $objPHPExcel->getActiveSheet()->getStyle('A'.$sellbwh4.':F'.$sellbwh4)->getFont()->setSize('11')->setName('Times New Roman')->setItalic(TRUE);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$sellbwh4)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $sellbwh4, 'CP : '.ucwords(strtolower($sales->nama)).(!empty($sales->no_hp) ? '/'.$sales->no_hp : ''))->mergeCells('A' . $sellbwh4.':F' . $sellbwh4)
                    ->setCellValue('G' . $sellbwh4, 'Grand Total')
                    ->setCellValue('H' . $sellbwh4, ($sql->jml_gtotal != 0 ? ceil($sql->jml_gtotal) : 0));
            
            // border penutup
            $objPHPExcel->getActiveSheet()->getStyle('A'.$sellbwh5)->getFont()->setSize('10')->setName('Times New Roman');
            $objPHPExcel->getActiveSheet()->getStyle('A'.$sellbwh5.':H'.$sellbwh6)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUMDASHED);
            /* END CONTENT EXCEL -- */
            
            // Rename worksheet
            $objPHPExcel->getActiveSheet()->setTitle('S.P '.$sql->kode_nota_dpn.$sql->no_nota.'-'.$sql->kode_nota_blk);

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
            header('Content-Disposition: attachment;filename="nota-'.strtolower($sql->kode_nota_dpn.$sql->no_nota.'-'.$sql->kode_nota_blk).'.xls"');

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
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function trans_jual_print_ex_do() {
        if (akses::aksesLogin() == TRUE) {
            $id         = $this->input->get('id');
            $aid        = general::dekrip($id);
            $sql        = $this->db->select('DATE(tgl_masuk) as tgl_simpan, tgl_keluar, no_nota, kode_nota_dpn, kode_nota_blk, id_pelanggan, id_sales, jml_total, jml_diskon, jml_retur, jml_subtotal, ppn, jml_ppn, jml_gtotal, jml_bayar, jml_kembali, jml_kurang, status_ppn')->where('tbl_trans_jual.id', $aid)->get('tbl_trans_jual')->row();
            $sql_det    = $this->db->select('tbl_trans_jual_det.id, tbl_trans_jual_det.kode, tbl_trans_jual_det.produk, tbl_trans_jual_det.jml, tbl_trans_jual_det.jml_satuan, tbl_trans_jual_det.satuan, tbl_trans_jual_det.keterangan, tbl_m_satuan.satuanTerkecil as sk, tbl_m_satuan.satuanBesar as sb, tbl_trans_jual_det.harga, tbl_trans_jual_det.subtotal')->join('tbl_m_satuan', 'tbl_m_satuan.id=tbl_trans_jual_det.id_satuan')->where('tbl_trans_jual_det.id_penjualan', $aid)->get('tbl_trans_jual_det');
            $member     = $this->db->where('id', $sql->id_pelanggan)->get('tbl_m_pelanggan')->row();
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
            $objPHPExcel->getActiveSheet()->getStyle('F4')->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('F4', strtoupper($member->alamat))->mergeCells('F4:H6');
            $objPHPExcel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A5', strtoupper($member->nama_toko.(!empty($member->lokasi) ? ' - '.$member->lokasi : '')))->mergeCells('A5:E5')
                    ->setCellValue('F5', '');
            
            $objPHPExcel->getActiveSheet()->getStyle('D6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A6', 'SURAT JALAN : SJ-'.$sql->no_nota.'')->mergeCells('A6:E6');

            // Header Tabel Nota
            $objPHPExcel->getActiveSheet()->getRowDimension('7')->setRowHeight(18.75);
            $objPHPExcel->getActiveSheet()->getStyle('A7:H7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('B7:C7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('D7:E7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle('F7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle('G7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getStyle('H7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A7', 'No.')
                    ->setCellValue('B7', 'Banyaknya')->mergeCells('B7:C7')
                    ->setCellValue('D7', 'Nama Barang')->mergeCells('D7:G7')
                    ->setCellValue('H7', 'Kode');
            
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(6);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(14);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12);   
            
            // Detail barang
            $no    = 1;
            $cell  = 8;
            $cel   = 8;
            foreach ($sql_det->result() as $items){
                $produk  = $this->db->where('kode', $items->kode)->get('tbl_m_produk')->row();
                
                // Format Angka
//                $objPHPExcel->getActiveSheet()->getStyle('G' . $cell.':H'.$cell)->getNumberFormat()->setFormatCode("#.##0");
//                $objPHPExcel->getActiveSheet()->getStyle('G' . $cell.':H'.$cell)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
                $objPHPExcel->getActiveSheet()->getRowDimension($cell)->setRowHeight(18.75);
                $objPHPExcel->getActiveSheet()->getStyle('G'.$cell.':H'.$cell)->getNumberFormat()->setFormatCode("_(\"\"* #,##0_);_(\"\"* \(#,##0\);_(\"\"* \"-\"??_);_(@_)");
                $objPHPExcel->getActiveSheet()->getStyle('F'.$cell)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
                
                // Format Alignment
                $objPHPExcel->getActiveSheet()->getStyle('A'.$cell.':H'.$cell)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                
                $objPHPExcel->getActiveSheet()->getStyle('A'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('B'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $objPHPExcel->getActiveSheet()->getStyle('C'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objPHPExcel->getActiveSheet()->getStyle('D'.$cell.':E'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objPHPExcel->getActiveSheet()->getStyle('F'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objPHPExcel->getActiveSheet()->getStyle('G'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $objPHPExcel->getActiveSheet()->getStyle('H'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                
                $kiri = substr($items->kode, 0, 1);
                
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A'.$cell, $no)
                            ->setCellValue('B'.$cell, (!empty($items->keterangan) ? $items->jml : $items->jml))
                            ->setCellValue('C'.$cell, $items->satuan)
                            ->setCellValue('D'.$cell, $items->produk)->mergeCells('D'.$cell.':G'.$cell)
                            ->setCellValue('H'.$cell, ' '.$items->kode); //number_format($items->subtotal,'0','.',',')
                
                $no++;
                $cell++;
            }
            
            // Maximal baris
            if($sql_det->num_rows() >= 40){
//                $jmlbaris = 8;
                $sell = $cell;
            }else{
                $jmlbaris = 33 - (int) $cell;
                
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
                        
//          Font Nota Detail            
            $objPHPExcel->getActiveSheet()->getStyle('A8:H'.$cell)->getFont()->setSize('12')->setName('Times New Roman');
                      
            
            
            // Hitung sell bawah
            $sell2     = $sell + 1;
            $sellbwh1  = $sell2 + 1;
            $sellbwh2  = $sellbwh1 + 1;
            $sellbwh3  = $sellbwh2 + 1;
            $sellbwh4  = $sellbwh3 + 1;
            $sellbwh5  = $sellbwh4 + 1;
            $sellbwh6  = $sellbwh5 + 1;
            $sellbwh7  = $sellbwh6 + 1;
            $sellbwh8  = $sellbwh7 + 1;
            $sellbwh9  = $sellbwh8 + 1;
            $sellbwh10 = $sellbwh9 + 1;
            
            // border bawah
            $objPHPExcel->getActiveSheet()->getStyle('A'.$sell2.':H'.$sell2)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$sell2.':H'.$sellbwh10)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            
            // Subtotal, ppn, grand total
            $objPHPExcel->getActiveSheet()->getStyle('A'.$sell2.':F'.$sell2)->getFont()->setSize('12')->setName('Times New Roman');
            $objPHPExcel->getActiveSheet()->getStyle('G'.$sell2.':H'.$sell2)->getFont()->setSize('12')->setName('Times New Roman');
            
            $objPHPExcel->getActiveSheet()->getStyle('A'.$sell2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('D'.$sell2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('G'.$sell2.':H'.$sell2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('H' . $sell2)->getNumberFormat()->setFormatCode("_(\"\"* #,##0_);_(\"\"* \(#,##0\);_(\"\"* \"-\"??_);_(@_)");
            $objPHPExcel->getActiveSheet()->getRowDimension($sell2)->setRowHeight(18.75);
//            $objPHPExcel->getActiveSheet()->getStyle('H' . $sell2)->getNumberFormat()->setFormatCode("_(\"Rp\"* #,##0_);_(\"Rp\"* \(#,##0\);_(\"Rp\"* \"-\"??_);_(@_)");
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $sell2, 'Tanda Terima')->mergeCells('A' . $sell2.':C' . $sell2)
                    ->setCellValue('D' . $sell2, '')->mergeCells('D' . $sell2.':F' . $sell2)
                    ->setCellValue('G' . $sell2, 'Pengirim')->mergeCells('G' . $sell2.':H' . $sell2);

            $objPHPExcel->getActiveSheet()->getStyle('G'.$sellbwh7.':H'.$sellbwh7)->getFont()->setSize('12')->setName('Times New Roman');
            $objPHPExcel->getActiveSheet()->getStyle('G'.$sellbwh7.':H'.$sellbwh7)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getStyle('H' . $sellbwh7)->getNumberFormat()->setFormatCode("_(\"\"* #,##0_);_(\"\"* \(#,##0\);_(\"\"* \"-\"??_);_(@_)");
            $objPHPExcel->getActiveSheet()->getRowDimension($sellbwh7)->setRowHeight(18.75);
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $sellbwh7, '( ............................. )')->mergeCells('A' . $sellbwh7.':C' . $sellbwh7)
                    ->setCellValue('G' . $sellbwh7, '( ...................................... )')->mergeCells('G' . $sellbwh7.':H' . $sellbwh7);
            
            // border penutup
            $objPHPExcel->getActiveSheet()->getStyle('A'.$sellbwh10)->getFont()->setSize('10')->setName('Times New Roman');
            $objPHPExcel->getActiveSheet()->getStyle('A'.$sellbwh10.':H'.$sellbwh10)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUMDASHED);
            /* END CONTENT EXCEL -- */
            
            // Rename worksheet
            $objPHPExcel->getActiveSheet()->setTitle('SJ-'.$sql->no_nota);

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
            header('Content-Disposition: attachment;filename="sj-'.strtolower($sql->no_nota).'.xls"');

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
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function trans_jual_print_tr() {
        if (akses::aksesLogin() == TRUE) {
            $id         = $this->input->get('id');
            $aid        = general::dekrip($id);
            $sql        = $this->db->select('DATE(tgl_simpan) as tgl_simpan, no_nota, kode_nota_dpn, kode_nota_blk, id_pelanggan, id_sales, jml_total, jml_diskon, jml_retur, jml_subtotal, ppn, jml_ppn, jml_gtotal, jml_bayar, jml_kembali, jml_kurang, status_ppn')->where('tbl_trans_jual.id', $aid)->get('tbl_trans_jual')->row();
            $sql_det    = $this->db->select('tbl_trans_jual_det.id, tbl_trans_jual_det.kode, tbl_trans_jual_det.produk, tbl_trans_jual_det.jml, tbl_trans_jual_det.jml_satuan, tbl_trans_jual_det.satuan, tbl_trans_jual_det.keterangan, tbl_m_satuan.satuanTerkecil as sk, tbl_m_satuan.satuanBesar as sb, tbl_trans_jual_det.harga, tbl_trans_jual_det.subtotal')->join('tbl_m_satuan', 'tbl_m_satuan.id=tbl_trans_jual_det.id_satuan')->where('tbl_trans_jual_det.id_penjualan', $aid)->get('tbl_trans_jual_det');
            $member     = $this->db->where('id', $sql->id_pelanggan)->get('tbl_m_pelanggan')->row();
            $sales      = $this->db->where('id', $sql->id_sales)->get('tbl_m_sales')->row();
            $pengaturan = $this->db->get('tbl_pengaturan')->row();
                                    
            $this->load->view('print');
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function trans_beli_print_ex() {
        if (akses::aksesLogin() == TRUE) {
            $setting    = $this->db->get('tbl_pengaturan')->row();
            $id         = $this->input->get('id');
            $aid        = general::dekrip($id);
            $sql        = $this->db->select('DATE(tgl_simpan) as tgl_simpan, no_nota, id_supplier, id_user, jml_total, ppn, jml_ppn, jml_retur, jml_gtotal, jml_bayar, jml_kembali, jml_kurang, status_ppn')->where('tbl_trans_beli.id', $aid)->get('tbl_trans_beli')->row();
            $sql_det    = $this->db->select('tbl_trans_beli_det.id, tbl_trans_beli_det.kode, tbl_trans_beli_det.produk, tbl_trans_beli_det.jml, tbl_trans_beli_det.satuan, tbl_m_satuan.satuanTerkecil as sk, tbl_m_satuan.satuanBesar as sb, tbl_trans_beli_det.harga, tbl_trans_beli_det.subtotal')->join('tbl_m_satuan', 'tbl_m_satuan.id=tbl_trans_beli_det.id_satuan')->where('tbl_trans_beli_det.id_pembelian', $aid)->get('tbl_trans_beli_det');
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
            $objPHPExcel->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('D5', strtoupper($sales->kode))->mergeCells('D5:E5')
                    ->setCellValue('F5', strtoupper($member->lokasi));
            
            $objPHPExcel->getActiveSheet()->getStyle('D6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A6', 'Nota Pembelian '.$sql->no_nota)
                    ->setCellValue('D6', strtoupper($sales->kota))->mergeCells('D6:E6');

            // Header Tabel Nota
            $objPHPExcel->getActiveSheet()->getStyle('A7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('B7:C7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('D7:E7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle('F7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle('G7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getStyle('H7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A7', 'No.')
                    ->setCellValue('B7', 'Banyaknya')->mergeCells('B7:C7')
                    ->setCellValue('D7', 'Nama Barang')->mergeCells('D7:E7')
                    ->setCellValue('F7', 'Kode')
                    ->setCellValue('G7', 'Harga')
                    ->setCellValue('H7', 'Subtotal');
            
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
                $objPHPExcel->getActiveSheet()->getStyle('H'.$cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A'.$cell, $no)
                            ->setCellValue('B'.$cell, $items->jml)
                            ->setCellValue('C'.$cell, $items->satuan)
                            ->setCellValue('D'.$cell, $items->produk)->mergeCells('D'.$cel.':E'.$cel)
                            ->setCellValue('F'.$cell, $items->kode)
                            ->setCellValue('G'.$cell, ($items->harga != 0 ? number_format($items->harga,'0','.',',') : ''))
                            ->setCellValue('H'.$cell, ($items->subtotal != 0 ? number_format($items->subtotal,'0','.',',') : ''));
                   
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
            $objPHPExcel->getActiveSheet()->getStyle('D'.$sell2.':H'.$sell2)->getFont()->setSize('11')->setName('Times New Roman')->setBold(TRUE);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$sell2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//            $objPHPExcel->getActiveSheet()->getStyle('D'.$sell2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('D'.$sell2.':H'.$sell2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getStyle('H' . $sell2)->getNumberFormat()->setFormatCode("#.##0");
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $sell2, '')->mergeCells('A' . $sell2.':C' . $sell2)
                    ->setCellValue('D' . $sell2, 'Total')->mergeCells('D' . $sell2.':G' . $sell2)
                    ->setCellValue('H' . $sell2, number_format($sql->jml_total,'0','.',','));
            
            $objPHPExcel->getActiveSheet()->getStyle('A'.$sellbwh1.':F'.$sellbwh1)->getFont()->setSize('11')->setName('Times New Roman');
            $objPHPExcel->getActiveSheet()->getStyle('D'.$sellbwh1.':H'.$sellbwh1)->getFont()->setSize('11')->setName('Times New Roman')->setBold(TRUE);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$sellbwh1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('D'.$sellbwh1.':H'.$sellbwh1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getStyle('H' . $sellbwh1)->getNumberFormat()->setFormatCode("#.##0");
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $sellbwh1, '')->mergeCells('A' . $sellbwh1.':C' . $sellbwh1)
                    ->setCellValue('D' . $sellbwh1, 'PPn '.(!empty($sql->ppn) ? $sql->ppn.' %' : ''))->mergeCells('D' . $sellbwh1.':G' . $sellbwh1)
                    ->setCellValue('H' . $sellbwh1, (!empty($sql->jml_ppn) ? number_format($sql->jml_ppn,'0','.',',') : ''));
            
            $objPHPExcel->getActiveSheet()->getStyle('D'.$sellbwh2.':H'.$sellbwh2)->getFont()->setSize('11')->setName('Times New Roman')->setBold(TRUE);
            $objPHPExcel->getActiveSheet()->getStyle('D'.$sellbwh2.':H'.$sellbwh2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getStyle('H' . $sellbwh2)->getNumberFormat()->setFormatCode("#.##0");
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $sellbwh2, '')->mergeCells('A' . $sellbwh2.':C' . $sellbwh2)
                    ->setCellValue('D' . $sellbwh2, 'Grand Total')->mergeCells('D' . $sellbwh2.':G' . $sellbwh2)
                    ->setCellValue('H' . $sellbwh2, number_format($sql->jml_gtotal,'0','.',','));
            
            // border penutup
            $objPHPExcel->getActiveSheet()->getStyle('A'.$sellbwh4)->getFont()->setSize('10')->setName('Times New Roman');
            $objPHPExcel->getActiveSheet()->getStyle('A'.$sellbwh4.':H'.$sellbwh4)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUMDASHED);
            /* END CONTENT EXCEL -- */
            
            // Rename worksheet
            $objPHPExcel->getActiveSheet()->setTitle('Nota '.$sql->kode_nota_dpn.$sql->no_nota.'-'.$sql->kode_nota_blk);

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
            header('Content-Disposition: attachment;filename="nota-'.strtolower($sql->kode_nota_dpn.$sql->no_nota).'.xls"');

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
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
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
            $objPHPExcel->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('D5', strtoupper($sales->kode))->mergeCells('D5:E5')
                    ->setCellValue('F5', strtoupper($member->lokasi));
            
            $objPHPExcel->getActiveSheet()->getStyle('A5:D5')->getFont()->setBold(TRUE);
            $objPHPExcel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A5', 'PURCHASE ORDER')->mergeCells('A5:E5');
            
            $objPHPExcel->getActiveSheet()->getStyle('A6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
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
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
	
    public function data_penj_list() {
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
                $jml_hal = $this->db->select('id, id_app, no_nota, kode_nota_dpn, kode_nota_blk, kode_nota_dpn, kode_nota_blk, DATE(tgl_masuk) as tgl_masuk, DATE(tgl_bayar) as tgl_bayar, DATE(tgl_keluar) as tgl_keluar, jml_total, jml_gtotal, ppn, jml_ppn, id_user, id_sales, id_pelanggan, status_nota, status_bayar, status_grosir')
                                ->where('status_nota !=', '4')
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
                           ->where('status_nota !=', '4')
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
                           ->where('status_nota !=', '4')
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

            /* Load view tampilan */
            $this->load->view('admin-lte-2/1_atas',$data);
            $this->load->view('admin-lte-2/2_header',$data);
            $this->load->view('admin-lte-2/includes/trans/data_penjualan_list',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
	
    public function data_penj_list_draft() {
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
                $jml_hal = $this->db->select('id, id_app, no_nota, kode_nota_dpn, kode_nota_blk, kode_nota_dpn, kode_nota_blk, DATE(tgl_masuk) as tgl_masuk, DATE(tgl_bayar) as tgl_bayar, DATE(tgl_keluar) as tgl_keluar, jml_total, jml_gtotal, ppn, jml_ppn, id_user, id_sales, id_pelanggan, status_nota, status_bayar, status_grosir')
                                ->where('status_nota', '4')
                                ->like('no_nota', $fn[0])
                                ->like('DATE(tgl_bayar)', $tb)
                                ->like('DATE(tgl_keluar)', $tp)
                                ->like('id_pelanggan', $cs)
                                ->like('id_sales', $sl)
                                ->like('id_user', ($id_grup->name == 'superadmin' || $id_grup->name == 'owner' || $id_grup->name == 'admin' ? '' : $id_user), ($id_grup->name == 'superadmin' || $id_grup->name == 'owner' || $id_grup->name == 'admin' ? '' : 'none'))
                                ->like('tgl_masuk', ($id_grup->name == 'superadmin' || $id_grup->name == 'owner' || $id_grup->name == 'admin' ? '' : date('Y-m-d')))
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
                           ->where('status_nota', '4')
                           ->limit($config['per_page'],$hal)
                           ->like('no_nota', $fn[0])
                           ->like('DATE(tgl_bayar)', $tb)
                           ->like('DATE(tgl_keluar)', $tp)
                           ->like('id_pelanggan', $cs)
                           ->like('id_sales', $sl)
                           ->like('id_user', ($id_grup->name == 'superadmin' || $id_grup->name == 'owner' || $id_grup->name == 'admin' ? '' : $id_user))
                           ->like('tgl_masuk', ($id_grup->name == 'superadmin' || $id_grup->name == 'owner' || $id_grup->name == 'admin' ? '' : date('Y-m-d')))
                           ->order_by('tgl_simpan','desc')
                           ->get('tbl_trans_jual')->result();
            }else{
                   $data['penj'] = $this->db->select('id, id_app, no_nota, kode_nota_dpn, kode_nota_blk, kode_nota_dpn, kode_nota_blk, DATE(tgl_masuk) as tgl_masuk, DATE(tgl_bayar) as tgl_bayar, DATE(tgl_keluar) as tgl_keluar, jml_total, jml_gtotal, ppn, jml_ppn, id_user, id_sales, id_pelanggan, status_nota, status_bayar, status_grosir')
                           ->where('status_nota', '4')
                           ->limit($config['per_page'])
                           ->like('no_nota', $fn[0])
                           ->like('DATE(tgl_bayar)', $tb)
                           ->like('DATE(tgl_keluar)', $tp)
                           ->like('id_pelanggan', $cs)
                           ->like('id_sales', $sl)
                           ->like('id_user', ($id_grup->name == 'superadmin' || $id_grup->name == 'owner' || $id_grup->name == 'admin' ? '' : $id_user))
                           ->like('tgl_masuk', ($id_grup->name == 'superadmin' || $id_grup->name == 'owner' || $id_grup->name == 'admin' ? '' : date('Y-m-d')))
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

            /* Load view tampilan */
            $this->load->view('admin-lte-2/1_atas',$data);
            $this->load->view('admin-lte-2/2_header',$data);
            $this->load->view('admin-lte-2/includes/trans/data_penjualan_list_draft',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
	
    public function data_penj_list_tempo() {
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
            $jml_sql = ($id_grup->name == 'superadmin' || $id_grup->name == 'owner' ? $this->db->query("SELECT id, no_nota, tgl_keluar, DATEDIFF(tgl_keluar, CURDATE()) AS selisih FROM tbl_trans_jual WHERE DATEDIFF(tgl_keluar, CURDATE()) >= 0 AND DATEDIFF(tgl_keluar, CURDATE()) <= '10' AND `tgl_masuk` != `tgl_keluar`")->num_rows() : $this->db->query("SELECT id, no_nota, tgl_keluar, DATEDIFF(tgl_keluar, CURDATE()) AS selisih FROM tbl_trans_jual WHERE DATEDIFF(tgl_keluar, CURDATE()) >= 0 AND DATEDIFF(tgl_keluar, CURDATE()) <= '10' AND `tgl_masuk` != `tgl_keluar` AND id_user='".$id_user."'")->num_rows());
            $jml_hal = (!empty($jml) ? $jml : $jml_sql); // (!empty($jml) ? $jml  : ($id_grup->name == 'superadmin' OR $id_grup->name == 'owner' ? $jml_kueri : $this->db->where('id_user', $id_user)->get('tbl_trans_jual')->num_rows()));
 
            $nt = $this->input->get('filter_nota');
            $fn = explode('/', $nt);
            $tg = $this->input->get('filter_tgl');
            $tp = $this->input->get('filter_tgl_tempo');
            $lk = $this->input->get('filter_lokasi');
            $cs = $this->input->get('filter_cust');
            $sn = $this->input->get('filter_status');
            $sl = $this->input->get('filter_sales');
            /* -- End Blok Filter -- */

            /* -- Form Error -- */
            $data['hasError']                = $this->session->flashdata('form_error');

            /* -- Blok Pagination -- */
            $config['base_url']              = base_url('transaksi/data_penj_list.php?jml='.$jml);
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
                           ->limit($config['per_page'],$hal)
                           ->where('DATEDIFF(tgl_keluar, CURDATE()) >=', '0')
                           ->where('DATEDIFF(tgl_keluar, CURDATE()) <=', $pengaturan->jml_limit_tempo)
                           ->order_by('tgl_masuk','desc')
                           ->get('tbl_trans_jual')->result();
            }else{
                   $data['penj'] = $this->db->select('id, id_app, no_nota, kode_nota_dpn, kode_nota_blk, kode_nota_dpn, kode_nota_blk, DATE(tgl_masuk) as tgl_masuk, DATE(tgl_bayar) as tgl_bayar, DATE(tgl_keluar) as tgl_keluar, jml_total, jml_gtotal, ppn, jml_ppn, id_user, id_sales, id_pelanggan, status_nota, status_bayar, status_grosir')
                           ->limit($config['per_page'])
                           ->where('DATEDIFF(tgl_keluar, CURDATE()) >=', '0')
                           ->where('DATEDIFF(tgl_keluar, CURDATE()) <=', $pengaturan->jml_limit_tempo)
                           ->order_by('tgl_simpan','desc')
                           ->get('tbl_trans_jual')->result();
            }
            
            $this->pagination->initialize($config);
            
            /* Blok pagination */
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();
            $data['cetak']      = ''; // '<button type="button" onclick="window.location.href = \''.base_url('transaksi/cetak_data_penj.php?'.(!empty($nt) ? 'filter_nota='.$nt : '').(!empty($tg) ? '&filter_tgl='.$tg : '').(!empty($tp) ? '&filter_tgl_tempo='.$tp : '').(!empty($cs) ? '&filter_cust='.$cs : '').(!empty($sl) ? '&filter_sales='.$sl : '').(!empty($jml) ? '&jml='.$jml : '')).'\'" class="btn btn-warning"><i class="fa fa-print"></i> Cetak</button>';
            /* --End Blok pagination-- */
//echo '<pre>';
//print_r($data['penj']);
            /* Load view tampilan */
            $this->load->view('admin-lte-2/1_atas',$data);
            $this->load->view('admin-lte-2/2_header',$data);
            $this->load->view('admin-lte-2/includes/trans/data_penjualan_list_tempo',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
	
    public function data_pen_list() {
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
            $jml_hal = (!empty($jml) ? $jml  : $this->db->count_all('tbl_trans_jual_pen'));
 
            $nt = $this->input->get('filter_nota');
            $fn = explode('/', $nt);
            $tg = $this->input->get('filter_tgl');
            $tp = $this->input->get('filter_tgl_tempo');
            $lk = $this->input->get('filter_lokasi');
            $cs = $this->input->get('filter_cust');
            $sn = $this->input->get('filter_status');
            $sl = $this->input->get('filter_sales');
            /* -- End Blok Filter -- */

            /* -- Form Error -- */
            $data['hasError']                = $this->session->flashdata('form_error');

            /* -- Blok Pagination -- */
            $config['base_url']              = base_url('transaksi/data_pen_list.php?filter_nota='.$tg.'&filter_tgl='.$tg.'&filter_sales='.$sl.'&filter_status='.$sn.'&jml='.$jml);
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
                   $data['penj'] = $this->db->select('no_nota, kode_nota_dpn, kode_nota_blk, kode_nota_dpn, kode_nota_blk, DATE(tgl_masuk) as tgl_masuk, DATE(tgl_bayar) as tgl_bayar, DATE(tgl_keluar) as tgl_keluar, jml_total, jml_gtotal, ppn, jml_ppn, id_user, id_sales, id_pelanggan, status_nota, status_bayar')
                           ->limit($config['per_page'],$hal)
                           ->like('no_nota', $fn[0])
//                           ->or_like('kode_nota_dpn', $nt, 'before')
//                           ->or_like('kode_nota_blk', $nt, 'after')
                           ->like('DATE(tgl_masuk)', $tg)
                           ->like('DATE(tgl_keluar)', $tp)
                           ->like('id_pelanggan', $cs)
                           ->like('id_sales', $sl)
                           ->like('id_user', ($id_grup->name == 'superadmin' || $id_grup->name == 'owner' ? '' : $id_user))
                           ->order_by('no_nota','desc')
                           ->get('tbl_trans_jual_pen')->result();
            }else{
                   $data['penj'] = $this->db->select('no_nota, kode_nota_dpn, kode_nota_blk, kode_nota_dpn, kode_nota_blk, DATE(tgl_masuk) as tgl_masuk, DATE(tgl_bayar) as tgl_bayar, DATE(tgl_keluar) as tgl_keluar, jml_total, jml_gtotal, ppn, jml_ppn, id_user, id_sales, id_pelanggan, status_nota, status_bayar')
                           ->limit($config['per_page'],$hal)
                           ->like('no_nota', $fn[0])
//                           ->or_like('kode_nota_dpn', $nt, 'before')
//                           ->or_like('kode_nota_blk', $nt, 'after')
                           ->like('DATE(tgl_masuk)', $tg)
                           ->like('DATE(tgl_keluar)', $tp)
                           ->like('id_pelanggan', $cs)
                           ->like('id_sales', $sl, 'match')
                           ->like('id_user', ($id_grup->name == 'superadmin' || $id_grup->name == 'owner' ? '' : $id_user))
                           ->order_by('no_nota','desc')
                           ->get('tbl_trans_jual_pen')->result();
            }
            
            $this->pagination->initialize($config);
            
            /* Blok pagination */
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();
            $data['cetak']      = '<button type="button" onclick="window.location.href = \''.base_url('transaksi/cetak_data_penj.php?'.(!empty($nt) ? 'filter_nota='.$nt : '').(!empty($tg) ? '&filter_tgl='.$tg : '').(!empty($tp) ? '&filter_tgl_tempo='.$tp : '').(!empty($cs) ? '&filter_cust='.$cs : '').(!empty($sl) ? '&filter_sales='.$sl : '').(!empty($jml) ? '&jml='.$jml : '')).'\'" class="btn btn-warning"><i class="fa fa-print"></i> Cetak</button>';
            /* --End Blok pagination-- */

            /* Load view tampilan */
            $this->load->view('admin-lte-2/1_atas',$data);
            $this->load->view('admin-lte-2/2_header',$data);
            $this->load->view('admin-lte-2/includes/trans/data_penawaran_list',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function data_pembelian_list() {
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
                $jml_hal = $this->db->select('tbl_trans_beli.id, tbl_trans_beli.no_nota, DATE(tbl_trans_beli.tgl_masuk) as tgl_masuk, DATE(tbl_trans_beli.tgl_bayar) as tgl_bayar, DATE(tbl_trans_beli.tgl_keluar) as tgl_keluar, tbl_trans_beli.jml_total, tbl_trans_beli.jml_retur, tbl_trans_beli.jml_gtotal, tbl_trans_beli.id_user, tbl_trans_beli.id_supplier, tbl_trans_beli.status_nota, tbl_trans_beli.status_bayar')
                                ->join('tbl_m_supplier', 'tbl_m_supplier.id=tbl_trans_beli.id_supplier')
                                ->like('tbl_trans_beli.id_user', ($id_grup->name == 'superadmin' || $id_grup->name == 'owner' ? '' : $id_user))
                                ->like('tbl_m_supplier.nama', $sl)
                                ->like('tbl_trans_beli.no_nota', $nt)
                                ->like('DATE(tbl_trans_beli.tgl_masuk)', $tg)
                                ->like('DATE(tbl_trans_beli.tgl_keluar)', $tp)
                                ->like('DATE(tbl_trans_beli.tgl_bayar)', $tb)
                                ->like('tbl_trans_beli.status_bayar', $sb)
                                ->order_by('tbl_trans_beli.id','desc')
                                ->get('tbl_trans_beli')->num_rows();                
            }

            /* -- Form Error -- */
            $data['hasError']                = $this->session->flashdata('form_error');

            /* -- Blok Pagination -- */
            $config['base_url']              = base_url('transaksi/data_pembelian_list.php?filter_nota='.$tg.'&filter_tgl='.$tg.'&filter_sales='.$sl.'&filter_status='.$sn.'&jml='.$jml);
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
                   $data['penj'] = $this->db->select('tbl_trans_beli.id, tbl_trans_beli.no_nota, DATE(tbl_trans_beli.tgl_masuk) as tgl_masuk, DATE(tbl_trans_beli.tgl_bayar) as tgl_bayar, DATE(tbl_trans_beli.tgl_keluar) as tgl_keluar, tbl_trans_beli.jml_total, tbl_trans_beli.jml_retur, tbl_trans_beli.jml_gtotal, tbl_trans_beli.id_user, tbl_trans_beli.id_supplier, tbl_trans_beli.status_nota, tbl_trans_beli.status_bayar')
                           ->join('tbl_m_supplier', 'tbl_m_supplier.id=tbl_trans_beli.id_supplier')
                           ->limit($config['per_page'],$hal)
                           ->like('tbl_trans_beli.id_user', ($id_grup->name == 'superadmin' || $id_grup->name == 'owner' ? '' : $id_user))
                           ->like('tbl_m_supplier.nama', $sl)
                           ->like('tbl_trans_beli.no_nota', $nt)
                           ->like('DATE(tbl_trans_beli.tgl_masuk)', $tg)
                           ->like('DATE(tbl_trans_beli.tgl_keluar)', $tp)
                           ->like('DATE(tbl_trans_beli.tgl_bayar)', $tb)
                           ->like('tbl_trans_beli.status_bayar', $sb)
                           ->order_by('tbl_trans_beli.id','desc')
                           ->get('tbl_trans_beli')->result();
            }else{
                   $data['penj'] = $this->db->select('tbl_trans_beli.id, tbl_trans_beli.no_nota, DATE(tbl_trans_beli.tgl_masuk) as tgl_masuk, DATE(tbl_trans_beli.tgl_bayar) as tgl_bayar, DATE(tbl_trans_beli.tgl_keluar) as tgl_keluar, tbl_trans_beli.jml_total, tbl_trans_beli.jml_retur, tbl_trans_beli.jml_gtotal, tbl_trans_beli.id_user, tbl_trans_beli.id_supplier, tbl_trans_beli.status_nota, tbl_trans_beli.status_bayar')
                           ->join('tbl_m_supplier', 'tbl_m_supplier.id=tbl_trans_beli.id_supplier')
                           ->limit($config['per_page'],$hal)
                           ->like('tbl_trans_beli.id_user', ($id_grup->name == 'superadmin' || $id_grup->name == 'owner' ? '' : $id_user))
                           ->like('tbl_m_supplier.nama', $sl)
                           ->like('tbl_trans_beli.no_nota', $nt)
                           ->like('DATE(tbl_trans_beli.tgl_masuk)', $tg)
                           ->like('DATE(tbl_trans_beli.tgl_keluar)', $tp)
                           ->like('DATE(tbl_trans_beli.tgl_bayar)', $tb)
                           ->like('tbl_trans_beli.status_bayar', $sb)
                           ->order_by('tbl_trans_beli.id','desc')
                           ->get('tbl_trans_beli')->result();
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
            $this->load->view('admin-lte-2/includes/trans/data_pembelian_list',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function data_pembelian_list_tempo() {
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
            $lk = $this->input->get('filter_lokasi');
            $sl = $this->input->get('filter_supplier');
            $sn = $this->input->get('filter_status');
            $sb = $this->input->get('filter_bayar');
            /* -- End Blok Filter -- */

            /* -- jml halaman pada list -- */
            if(akses::hakSA() == TRUE OR akses::hakAdmin() == TRUE){
                $jml_hal = (!empty($jml) ? $jml  : $this->db->query("SELECT id, no_nota, tgl_keluar, DATEDIFF(tgl_keluar, CURDATE()) AS selisih FROM tbl_trans_beli WHERE DATEDIFF(tgl_keluar, CURDATE()) >= 0 AND DATEDIFF(tgl_keluar, CURDATE()) <= '10' AND `tgl_masuk` != `tgl_keluar`")->num_rows());
            }else{
                /* -- Hitung jumlah halaman -- */
                $jml_hal = (!empty($jml) ? $jml  : $this->db->query("SELECT id, no_nota, tgl_keluar, DATEDIFF(tgl_keluar, CURDATE()) AS selisih FROM tbl_trans_beli WHERE DATEDIFF(tgl_keluar, CURDATE()) >= 0 AND DATEDIFF(tgl_keluar, CURDATE()) <= '10' AND `tgl_masuk` != `tgl_keluar` AND id_user='".$id_user."'")->num_rows());
            }

            /* -- Form Error -- */
            $data['hasError']                = $this->session->flashdata('form_error');

            /* -- Blok Pagination -- */
            $config['base_url']              = base_url('transaksi/data_pembelian_list_tempo.php?route=tempo'.'&jml='.$jml);
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
                   $data['penj'] = $this->db->select('tbl_trans_beli.id, tbl_trans_beli.no_nota, DATE(tbl_trans_beli.tgl_masuk) as tgl_masuk, DATE(tbl_trans_beli.tgl_bayar) as tgl_bayar, DATE(tbl_trans_beli.tgl_keluar) as tgl_keluar, tbl_trans_beli.jml_total, tbl_trans_beli.jml_retur, tbl_trans_beli.jml_gtotal, tbl_trans_beli.id_user, tbl_trans_beli.id_supplier, tbl_trans_beli.status_nota, tbl_trans_beli.status_bayar')
                           ->join('tbl_m_supplier', 'tbl_m_supplier.id=tbl_trans_beli.id_supplier')
                           ->limit($config['per_page'],$hal)
                           ->like('tbl_trans_beli.id_user', ($id_grup->name == 'superadmin' || $id_grup->name == 'owner' ? '' : $id_user))
                           ->like('tbl_m_supplier.nama', $sl)
                           ->like('tbl_trans_beli.no_nota', $nt)
                           ->like('DATE(tbl_trans_beli.tgl_masuk)', $tg)
                           ->like('DATE(tbl_trans_beli.tgl_keluar)', $tp)
                           ->where('status_bayar !=', '1')
                           ->where('DATEDIFF(tgl_keluar, CURDATE()) >=', '0')
                           ->where('DATEDIFF(tgl_keluar, CURDATE()) <=', $pengaturan->jml_limit_tempo)
                           ->order_by('tbl_trans_beli.tgl_masuk','desc')
                           ->get('tbl_trans_beli')->result();
            }else{
                   $data['penj'] = $this->db->select('tbl_trans_beli.id, tbl_trans_beli.no_nota, DATE(tbl_trans_beli.tgl_masuk) as tgl_masuk, DATE(tbl_trans_beli.tgl_bayar) as tgl_bayar, DATE(tbl_trans_beli.tgl_keluar) as tgl_keluar, tbl_trans_beli.jml_total, tbl_trans_beli.jml_retur, tbl_trans_beli.jml_gtotal, tbl_trans_beli.id_user, tbl_trans_beli.id_supplier, tbl_trans_beli.status_nota, tbl_trans_beli.status_bayar')
                           ->join('tbl_m_supplier', 'tbl_m_supplier.id=tbl_trans_beli.id_supplier')
                           ->limit($config['per_page'],$hal)
                           ->like('tbl_trans_beli.id_user', ($id_grup->name == 'superadmin' || $id_grup->name == 'owner' ? '' : $id_user))
                           ->like('tbl_m_supplier.nama', $sl)
                           ->like('tbl_trans_beli.no_nota', $nt)
                           ->like('DATE(tbl_trans_beli.tgl_masuk)', $tg)
                           ->like('DATE(tbl_trans_beli.tgl_keluar)', $tp)
                           ->where('status_bayar !=', '1')
                           ->where('DATEDIFF(tgl_keluar, CURDATE()) >=', '0')
                           ->where('DATEDIFF(tgl_keluar, CURDATE()) <=', $pengaturan->jml_limit_tempo)
                           ->order_by('tbl_trans_beli.tgl_masuk','desc')
                           ->get('tbl_trans_beli')->result();
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
            $this->load->view('admin-lte-2/includes/trans/data_pembelian_list_tempo',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function data_po_list() {
        if (akses::aksesLogin() == TRUE) {
            /* -- Grup hak akses -- */
            $grup       = $this->ion_auth->get_users_groups()->row();
            $id_user    = $this->ion_auth->user()->row()->id;
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            /* -- Blok Filter -- */
            $query   = $this->input->get('q');
            $hal     = $this->input->get('halaman');
            $jml     = $this->input->get('jml');

            $nt = $this->input->get('filter_nota');
            $tg = $this->input->get('filter_tgl');
            $lk = $this->input->get('filter_lokasi');
            $sl = $this->input->get('filter_supplier');
            $sn = $this->input->get('filter_status');
            $sb = $this->input->get('filter_bayar');
            /* -- End Blok Filter -- */

            /* -- jml halaman pada list -- */
            if(akses::hakSA() == TRUE OR akses::hakAdmin() == TRUE){
                $jml_hal = (!empty($jml) ? $jml  : $this->db->like('no_nota', $nt)->like('DATE(tgl_masuk)', $tg)->like('id_user', $sl)->like('status_nota', $sn)->get('tbl_trans_beli_po')->num_rows());
            }else{
                /* -- Hitung jumlah halaman -- */
                $jml_hal = (!empty($jml) ? $jml  : $this->db->where('id_user', $id_user)->like('no_nota', $nt)->like('DATE(tgl_masuk)', $tg)->like('status_nota', $sn)->get('tbl_trans_beli_po')->num_rows());
            }

            /* -- Form Error -- */
            $data['hasError']                = $this->session->flashdata('form_error');

            /* -- Blok Pagination -- */
            $config['base_url']              = base_url('transaksi/data_po_list.php?filter_nota='.$tg.'&filter_tgl='.$tg.'&filter_sales='.$sl.'&filter_status='.$sn.'&jml='.$jml);
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
                   $data['penj'] = $this->db->select('tbl_trans_beli_po.id, tbl_trans_beli_po.no_nota, DATE(tbl_trans_beli_po.tgl_masuk) as tgl_masuk, DATE(tbl_trans_beli_po.tgl_keluar) as tgl_keluar, tbl_trans_beli_po.id_user, tbl_trans_beli_po.id_supplier, tbl_trans_beli_po.status_nota')
                           ->join('tbl_m_supplier', 'tbl_m_supplier.id=tbl_trans_beli_po.id_supplier')
                           ->limit($config['per_page'],$hal)
                           ->like('tbl_m_supplier.nama', $sl)
                           ->like('tbl_trans_beli_po.no_nota', $nt)
                           ->like('DATE(tbl_trans_beli_po.tgl_masuk)', $tg)
                           ->limit($config['per_page'],$hal)
                           ->order_by('tbl_trans_beli_po.id','desc')
                           ->get('tbl_trans_beli_po')->result();
            }else{
                   $data['penj'] = $this->db->select('tbl_trans_beli_po.id, tbl_trans_beli_po.no_nota, DATE(tbl_trans_beli_po.tgl_masuk) as tgl_masuk, DATE(tbl_trans_beli_po.tgl_keluar) as tgl_keluar, tbl_trans_beli_po.id_user, tbl_trans_beli_po.id_supplier, tbl_trans_beli_po.status_nota')
                           ->join('tbl_m_supplier', 'tbl_m_supplier.id=tbl_trans_beli_po.id_supplier')
                           ->limit($config['per_page'],$hal)
                           ->like('tbl_m_supplier.nama', $sl)
                           ->like('tbl_trans_beli_po.no_nota', $nt)
                           ->like('DATE(tbl_trans_beli_po.tgl_masuk)', $tg)
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

            /* Load view tampilan */
            $this->load->view('admin-lte-2/1_atas',$data);
            $this->load->view('admin-lte-2/2_header',$data);
            $this->load->view('admin-lte-2/includes/trans/data_po_list',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function data_pemb_jual_list() {
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
            $lk = $this->input->get('filter_lokasi');
            $sl = $this->input->get('filter_sales');
            $sn = $this->input->get('filter_status');
            $sb = $this->input->get('filter_bayar');
            /* -- End Blok Filter -- */

            /* -- jml halaman pada list -- */
            if(akses::hakSA() == TRUE OR akses::hakAdmin() == TRUE){
                $jml_hal = (!empty($jml) ? $jml  : $this->db->where('status_bayar !=', '1')->where('id_user', $id_user)->get('tbl_trans_jual')->num_rows());
            }else{
                /* -- Hitung jumlah halaman -- */
                $jml_hal = (!empty($jml) ? $jml  : $this->db->where('status_bayar !=', '1')->where('id_user', $id_user)->get('tbl_trans_jual')->num_rows());
            }

            /* -- Form Error -- */
            $data['hasError']                = $this->session->flashdata('form_error');

            /* -- Blok Pagination -- */
            $config['base_url']              = base_url('transaksi/data_pemb_jual_list.php?filter_nota='.$tg.'&filter_tgl='.$tg.'&filter_sales='.$sl.'&filter_status='.$sn.'&jml='.$jml);
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
                   $data['penj'] = $this->db->select('id, id_app, no_nota, kode_nota_dpn, kode_nota_blk, DATE(tgl_masuk) as tgl_masuk, DATE(tgl_bayar) as tgl_bayar, DATE(tgl_keluar) as tgl_keluar, jml_total, jml_diskon, jml_subtotal, ppn, jml_ppn, jml_gtotal, jml_bayar, jml_kurang, id_user, id_pelanggan, status_nota, status_bayar')
                           ->where('status_bayar !=', '1')
                           ->limit($config['per_page'],$hal)
                           ->like('no_nota', $nt)
                           ->like('DATE(tgl_masuk)', $tg)
                           ->like('DATE(tgl_keluar)', $tp)
                           ->like('id_user', $sl)
                           ->like('status_bayar', $sb)
                           ->like('id_user', ($id_grup->name == 'superadmin' || $id_grup->name == 'owner' ? '' : $id_user))
                           ->order_by('id','desc')
                           ->get('tbl_trans_jual')->result();
            }else{
                   $data['penj'] = $this->db->select('id, id_app, no_nota, kode_nota_dpn, kode_nota_blk, DATE(tgl_masuk) as tgl_masuk, DATE(tgl_bayar) as tgl_bayar, DATE(tgl_keluar) as tgl_keluar, jml_total, jml_diskon, jml_subtotal, ppn, jml_ppn, jml_gtotal, jml_bayar, jml_kurang, id_user, id_pelanggan, status_nota, status_bayar')
                           ->where('status_bayar !=', '1')
                           ->limit($config['per_page'],$hal)
                           ->like('no_nota', $nt)
                           ->like('DATE(tgl_masuk)', $tg)
                           ->like('DATE(tgl_keluar)', $tp)
                           ->like('id_user', $sl)
                           ->like('status_bayar', $sb)
                           ->like('id_user', ($id_grup->name == 'superadmin' || $id_grup->name == 'owner' ? '' : $id_user))
                           ->order_by('id','desc')
                           ->get('tbl_trans_jual')->result();
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
            $this->load->view('admin-lte-2/includes/trans/data_pembayaran_list',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function data_pemb_beli_list() {
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
            if(akses::hakSA() == TRUE OR akses::hakAdmin() == TRUE){
                $jml_hal = (!empty($jml) ? $jml  : $this->db->where('status_bayar !=', '1')->like('no_nota', $nt)->like('DATE(tgl_masuk)', $tg)->like('id_user', $sl)->like('status_nota', $sn)->get('tbl_trans_beli')->num_rows());
            }else{
                /* -- Hitung jumlah halaman -- */
                $jml_hal = (!empty($jml) ? $jml  : $this->db->where('status_bayar !=', '1')->where('id_user', $id_user)->like('no_nota', $nt)->like('DATE(tgl_masuk)', $tg)->like('DATE(tgl_keluar)', $tp)->like('status_nota', $sn)->get('tbl_trans_beli')->num_rows());
            }

            /* -- Form Error -- */
            $data['hasError']                = $this->session->flashdata('form_error');

            /* -- Blok Pagination -- */
            $config['base_url']              = base_url('transaksi/data_pemb_beli_list.php?filter_nota='.$tg.'&filter_tgl='.$tg.'&filter_sales='.$sl.'&filter_status='.$sn.'&jml='.$jml);
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
                   $data['penj'] = $this->db->select('tbl_trans_beli.id, tbl_trans_beli.no_nota, DATE(tbl_trans_beli.tgl_masuk) as tgl_masuk, DATE(tbl_trans_beli.tgl_bayar) as tgl_bayar, DATE(tbl_trans_beli.tgl_keluar) as tgl_keluar, tbl_trans_beli.jml_total, tbl_trans_beli.jml_retur, tbl_trans_beli.jml_gtotal, tbl_trans_beli.id_user, tbl_trans_beli.id_supplier, tbl_trans_beli.status_nota, tbl_trans_beli.status_bayar')
                           ->join('tbl_m_supplier', 'tbl_m_supplier.id=tbl_trans_beli.id_supplier')
                           ->where('status_bayar !=', '1')
                           ->limit($config['per_page'],$hal)
                           ->like('tbl_trans_beli.id_user', ($id_grup->name == 'superadmin' || $id_grup->name == 'owner' ? '' : $id_user))
                           ->like('tbl_m_supplier.nama', $sl)
                           ->like('tbl_trans_beli.no_nota', $nt)
                           ->like('DATE(tbl_trans_beli.tgl_masuk)', $tg)
                           ->like('DATE(tbl_trans_beli.tgl_keluar)', $tp)
                           ->like('DATE(tbl_trans_beli.tgl_bayar)', $tb)
                           ->like('tbl_trans_beli.status_bayar', $sb)
                           ->order_by('tbl_trans_beli.id','desc')
                           ->get('tbl_trans_beli')->result();
            }else{
                   $data['penj'] = $this->db->select('tbl_trans_beli.id, tbl_trans_beli.no_nota, DATE(tbl_trans_beli.tgl_masuk) as tgl_masuk, DATE(tbl_trans_beli.tgl_bayar) as tgl_bayar, DATE(tbl_trans_beli.tgl_keluar) as tgl_keluar, tbl_trans_beli.jml_total, tbl_trans_beli.jml_retur, tbl_trans_beli.jml_gtotal, tbl_trans_beli.id_user, tbl_trans_beli.id_supplier, tbl_trans_beli.status_nota, tbl_trans_beli.status_bayar')
                           ->join('tbl_m_supplier', 'tbl_m_supplier.id=tbl_trans_beli.id_supplier')
                           ->where('status_bayar !=', '1')
                           ->limit($config['per_page'],$hal)
                           ->like('tbl_trans_beli.id_user', ($id_grup->name == 'superadmin' || $id_grup->name == 'owner' ? '' : $id_user))
                           ->like('tbl_m_supplier.nama', $sl)
                           ->like('tbl_trans_beli.no_nota', $nt)
                           ->like('DATE(tbl_trans_beli.tgl_masuk)', $tg)
                           ->like('DATE(tbl_trans_beli.tgl_keluar)', $tp)
                           ->like('DATE(tbl_trans_beli.tgl_bayar)', $tb)
                           ->like('tbl_trans_beli.status_bayar', $sb)
                           ->order_by('tbl_trans_beli.id','desc')
                           ->get('tbl_trans_beli')->result();
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
            $this->load->view('admin-lte-2/includes/trans/data_pembayaran_beli_list',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function data_retur_jual_list() {
        if (akses::aksesLogin() == TRUE) {
            /* -- Grup hak akses -- */
            $grup        = $this->ion_auth->get_users_groups()->row();
            $id_user     = $this->ion_auth->user()->row()->id;
            $id_grup     = $this->ion_auth->get_users_groups()->row();
            $pengaturan  = $this->db->get('tbl_pengaturan')->row();
            
            $nota        = $this->input->get('id');
            $route       = $this->input->get('route');
            $data['sess_ret'] = $this->session->userdata('sess_cari_ret');
            
            if(empty($data['sess_ret']) && isset($_GET['id']) && isset($_GET['route'])){
                $sess_ret = array(
                    'id'    => $nota,
                    'route' => $route,
                );
                
                $this->session->set_userdata('sess_cari_ret', $sess_ret);
                
                redirect(base_url('transaksi/data_retur_jual_list.php?id='.$id.'&route='.$route));
            }

            /* -- Blok Filter -- */
            $query   = $this->input->get('q');
            $hal     = $this->input->get('halaman');
            $jml     = $this->input->get('jml');

            $nt = $this->input->get('filter_nota');
            $tg = $this->input->get('filter_tgl');
            $lk = $this->input->get('filter_lokasi');
            $sl = $this->input->get('filter_sales');
            $sn = $this->input->get('filter_status');
            $sb = $this->input->get('filter_bayar');
            /* -- End Blok Filter -- */

            /* -- jml halaman pada list -- */
//            $jml_hal = (!empty($jml) ? $jml  : $this->db->like('no_nota', $nt)->like('DATE(tgl_simpan)', $tg)->like('status_retur', $sn)->get('tbl_trans_retur_jual')->num_rows());
            if(!empty($jml)){
                
            }else{
                $jml_hal = $this->db->select('DATE(tbl_trans_retur_jual.tgl_simpan) as tgl_simpan, tbl_trans_retur_jual.id, tbl_trans_retur_jual.no_retur, tbl_trans_retur_jual.no_nota, tbl_trans_retur_jual.status_retur, tbl_trans_retur_jual.jml_retur, tbl_m_pelanggan.nama')
                                         ->join('tbl_trans_jual', 'tbl_trans_jual.id=tbl_trans_retur_jual.id_penjualan')
                                         ->join('tbl_m_pelanggan', 'tbl_m_pelanggan.id=tbl_trans_retur_jual.id_pelanggan')
//                                         ->like('tbl_trans_jual.id_user', ($id_grup->name == 'superadmin' || $id_grup->name == 'owner' || $id_grup->name == 'admin' ? '' : $id_user))
                                         ->like('tbl_trans_retur_jual.id', (float)$nt)
                                         ->like('DATE(tbl_trans_retur_jual.tgl_simpan)', $tg)
                                         ->order_by('tbl_trans_retur_jual.id','desc')
                                         ->get('tbl_trans_retur_jual')->num_rows();
            }
            
            /* -- Form Error -- */
            $data['hasError']                = $this->session->flashdata('form_error');

            /* -- Blok Pagination -- */
            $config['base_url']              = base_url('transaksi/data_retur_jual_list.php?filter_nota='.$tg.'&filter_tgl='.$tg.'&filter_sales='.$sl.'&filter_status='.$sn.'&jml='.$jml);
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
                   $data['retur'] = $this->db->select('DATE(tbl_trans_retur_jual.tgl_simpan) as tgl_simpan, tbl_trans_retur_jual.id, tbl_trans_retur_jual.no_retur, tbl_trans_retur_jual.no_nota, tbl_trans_retur_jual.status_retur, tbl_trans_retur_jual.jml_retur, tbl_m_pelanggan.nama')
                                         ->join('tbl_trans_jual', 'tbl_trans_jual.id=tbl_trans_retur_jual.id_penjualan')
                                         ->join('tbl_m_pelanggan', 'tbl_m_pelanggan.id=tbl_trans_retur_jual.id_pelanggan')
                                         ->limit($config['per_page'],$hal)
//                                         ->like('tbl_trans_jual.id_user', ($id_grup->name == 'superadmin' || $id_grup->name == 'owner' || $id_grup->name == 'admin' ? '' : $id_user))
                                         ->like('tbl_trans_retur_jual.no_retur', (float)$nt)
                                         ->like('DATE(tbl_trans_retur_jual.tgl_simpan)', $tg)
                                         ->order_by('tbl_trans_retur_jual.id','desc')
                                         ->get('tbl_trans_retur_jual')->result();
            }else{
                   $data['retur'] = $this->db->select('DATE(tbl_trans_retur_jual.tgl_simpan) as tgl_simpan, tbl_trans_retur_jual.id, tbl_trans_retur_jual.no_retur, tbl_trans_retur_jual.no_nota, tbl_trans_retur_jual.status_retur, tbl_trans_retur_jual.jml_retur, tbl_m_pelanggan.nama')
                                         ->join('tbl_trans_jual', 'tbl_trans_jual.id=tbl_trans_retur_jual.id_penjualan')
                                         ->join('tbl_m_pelanggan', 'tbl_m_pelanggan.id=tbl_trans_retur_jual.id_pelanggan')
                                         ->limit($config['per_page'])
//                                         ->like('tbl_trans_jual.id_user', ($id_grup->name == 'superadmin' || $id_grup->name == 'owner' || $id_grup->name == 'admin' ? '' : $id_user))
                                         ->like('tbl_trans_retur_jual.no_retur', (float)$nt)
                                         ->like('DATE(tbl_trans_retur_jual.tgl_simpan)', $tg)
                                         ->order_by('tbl_trans_retur_jual.id','desc')
                                         ->get('tbl_trans_retur_jual')->result();
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
            $this->load->view('admin-lte-2/includes/trans/data_retur_jual_list',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function data_retur_beli_list() {
        if (akses::aksesLogin() == TRUE) {
            /* -- Grup hak akses -- */
            $grup    = $this->ion_auth->get_users_groups()->row();
            $id_user = $this->ion_auth->user()->row()->id;

            /* -- Blok Filter -- */
            $query   = $this->input->get('q');
            $hal     = $this->input->get('halaman');
            $jml     = $this->input->get('jml');

            $nt = $this->input->get('filter_nota');
            $tg = $this->input->get('filter_tgl');
            $lk = $this->input->get('filter_lokasi');
            $sl = $this->input->get('filter_sales');
            $sn = $this->input->get('filter_status');
            $sb = $this->input->get('filter_bayar');
            /* -- End Blok Filter -- */

            /* -- jml halaman pada list -- */
            $jml_hal = (!empty($jml) ? $jml  : $this->db->like('no_nota', $nt)->like('DATE(tgl_simpan)', $tg)->like('status_retur', $sn)->get('tbl_trans_retur_beli')->num_rows());

            /* -- Form Error -- */
            $data['hasError']                = $this->session->flashdata('form_error');

            /* -- Blok Pagination -- */
            $config['base_url']              = site_url('page=transaksi&act=trans_beli_list&filter_nota='.$tg.'&filter_tgl='.$tg.'&filter_sales='.$sl.'&filter_status='.$sn.'&jml='.$jml);
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
                   $data['retur'] = $this->db->select('DATE(tbl_trans_retur_beli.tgl_simpan) as tgl_simpan, tbl_trans_retur_beli.id, tbl_trans_retur_beli.no_nota, tbl_trans_retur_beli.id_pembelian, tbl_trans_retur_beli.status_retur, tbl_trans_retur_beli.jml_retur, tbl_m_supplier.nama')
                             ->join('tbl_trans_beli', 'tbl_trans_beli.id=tbl_trans_retur_beli.id_pembelian')
                             ->join('tbl_m_supplier', 'tbl_m_supplier.id=tbl_trans_beli.id_supplier')
//                           ->limit($config['per_page'],$hal)
//                           ->like('no_nota', $nt)
//                           ->like('DATE(tgl_masuk)', $tg)
//                           ->like('id_user', $sl)
//                           ->like('status_bayar', $sb)
                           ->limit($config['per_page'],$hal)
                           ->order_by('id','desc')
                           ->get('tbl_trans_retur_beli')->result();
            }else{
                   $data['retur'] = $this->db->select('DATE(tbl_trans_retur_beli.tgl_simpan) as tgl_simpan, tbl_trans_retur_beli.id, tbl_trans_retur_beli.no_nota, tbl_trans_retur_beli.id_pembelian, tbl_trans_retur_beli.status_retur, tbl_trans_retur_beli.jml_retur, tbl_m_supplier.nama')
                             ->join('tbl_trans_beli', 'tbl_trans_beli.id=tbl_trans_retur_beli.id_pembelian')
                             ->join('tbl_m_supplier', 'tbl_m_supplier.id=tbl_trans_beli.id_supplier')
//                           ->like('no_nota', $nt)
//                           ->like('DATE(tgl_masuk)', $tg)
//                           ->like('id_user', $sl)
//                           ->like('status_bayar', $sb)
//                           ->limit($config['per_page'])
                           ->order_by('id','desc')
                           ->get('tbl_trans_retur_beli')->result();
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
            $this->load->view('admin-lte-2/includes/trans/data_retur_beli_list',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function trans_bayar_jual() {
        if (akses::aksesLogin() == TRUE) {
            $setting            = $this->db->get('tbl_pengaturan')->row();
            $id                 = $this->input->get('id');

            $data['platform']   = $this->db->get('tbl_m_platform')->result();
            $data['sql_penj']   = $this->db->where('id', general::dekrip($id))->get('tbl_trans_jual')->row();
            $data['penj_det']   = $this->db->where('id_penjualan', general::dekrip($id))->get('tbl_trans_jual_det')->result();
            
            $this->load->view('admin-lte-2/1_atas',$data);
            $this->load->view('admin-lte-2/2_header',$data);
            $this->load->view('admin-lte-2/includes/trans/trans_bayar',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function trans_bayar_beli() {
        if (akses::aksesLogin() == TRUE) {
            $setting            = $this->db->get('tbl_pengaturan')->row();
            $id                 = $this->input->get('id');

            $data['platform']   = $this->db->get('tbl_m_platform')->result();
            $data['pemb']       = $this->db->where('id', general::dekrip($id))->get('tbl_trans_beli')->row();
            $data['pemb_det']   = $this->db->where('id_pembelian', general::dekrip($id))->get('tbl_trans_beli_det')->result();
            $data['pemb_retur'] = $this->db->where('id_pembelian', general::dekrip($id))->get('tbl_trans_retur_beli')->row();
            $data['supplier']   = $this->db->where('id', $data['pemb']->id_supplier)->get('tbl_m_supplier')->row();
            
            $this->load->view('admin-lte-2/1_atas',$data);
            $this->load->view('admin-lte-2/2_header',$data);
            $this->load->view('admin-lte-2/includes/trans/trans_bayar_beli',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function input_retur_jual() {
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
            $lk = $this->input->get('filter_lokasi');
            $sl = $this->input->get('filter_sales');
            $sn = $this->input->get('filter_status');
            $sb = $this->input->get('filter_bayar');
            /* -- End Blok Filter -- */

            /* -- jml halaman pada list -- */
            $jml_sql = ($id_grup->name == 'superadmin' || $id_grup->name == 'owner' ? $this->db->get('tbl_trans_jual')->num_rows() : $this->db->where('id_user', $id_user)->get('tbl_trans_jual')->num_rows());
            
            if(!empty($jml)){
                   $jml_hal = $jml;                
            }else{
                   $jml_hal = $this->db->select('id, id_app, no_nota, kode_nota_dpn, kode_nota_blk, kode_nota_dpn, kode_nota_blk, DATE(tgl_masuk) as tgl_masuk, DATE(tgl_bayar) as tgl_bayar, DATE(tgl_keluar) as tgl_keluar, jml_total, jml_gtotal, ppn, jml_ppn, id_user, id_sales, id_pelanggan, status_nota, status_bayar, status_retur')
                           ->like('id_user', ($id_grup->name == 'superadmin' || $id_grup->name == 'owner' ? '' : $id_user))
                           ->like('no_nota', $nt)
                           ->like('DATE(tgl_masuk)', $tg)
                           ->like('id_user', $sl)
                           ->like('status_bayar', $sb)
                           ->order_by('id','desc')
                           ->get('tbl_trans_jual')->num_rows();                
            }
//            $jml_hal = (!empty($jml) ? $jml : $jml_sql); // (!empty($jml) ? $jml  : ($id_grup->name == 'superadmin' OR $id_grup->name == 'owner' ? $jml_kueri : $this->db->where('id_user', $id_user)->get('tbl_trans_jual')->num_rows()));

            /* -- Form Error -- */
            $data['hasError']                = $this->session->flashdata('form_error');

            /* -- Blok Pagination -- */
            $config['base_url']              = base_url('transaksi/input_retur_jual.php?filter_nota='.$nt.'&filter_tgl='.$tg.'&filter_sales='.$sl.'&filter_status='.$sn.'&jml='.$jml);
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
                   $data['penj'] = $this->db->select('id, id_app, no_nota, kode_nota_dpn, kode_nota_blk, kode_nota_dpn, kode_nota_blk, DATE(tgl_masuk) as tgl_masuk, DATE(tgl_bayar) as tgl_bayar, DATE(tgl_keluar) as tgl_keluar, jml_total, jml_gtotal, ppn, jml_ppn, id_user, id_sales, id_pelanggan, status_nota, status_bayar, status_retur')
                           ->limit($config['per_page'],$hal)
                           ->like('id_user', ($id_grup->name == 'superadmin' || $id_grup->name == 'owner' ? '' : $id_user))
                           ->like('no_nota', $nt)
                           ->like('DATE(tgl_masuk)', $tg)
                           ->like('id_user', $sl)
                           ->like('status_bayar', $sb)
                           ->order_by('id','desc')
                           ->get('tbl_trans_jual')->result();
            }else{
                   $data['penj'] = $this->db->select('id, id_app, no_nota, kode_nota_dpn, kode_nota_blk, kode_nota_dpn, kode_nota_blk, DATE(tgl_masuk) as tgl_masuk, DATE(tgl_bayar) as tgl_bayar, DATE(tgl_keluar) as tgl_keluar, jml_total, jml_gtotal, ppn, jml_ppn, id_user, id_sales, id_pelanggan, status_nota, status_bayar, status_retur')
                           ->limit($config['per_page'],$hal)
                           ->like('id_user', ($id_grup->name == 'superadmin' || $id_grup->name == 'owner' ? '' : $id_user))
                           ->like('no_nota', $nt)
                           ->like('DATE(tgl_masuk)', $tg)
                           ->like('id_user', $sl)
                           ->like('status_bayar', $sb)
                           ->order_by('id','desc')
                           ->get('tbl_trans_jual')->result();
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
            $this->load->view('admin-lte-2/includes/trans/input_retur_jual',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function input_retur_beli() {
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
                $jml_hal = $this->db->select('tbl_trans_beli.id, tbl_trans_beli.no_nota, DATE(tbl_trans_beli.tgl_masuk) as tgl_masuk, DATE(tbl_trans_beli.tgl_bayar) as tgl_bayar, DATE(tbl_trans_beli.tgl_keluar) as tgl_keluar, tbl_trans_beli.jml_total, tbl_trans_beli.jml_retur, tbl_trans_beli.jml_gtotal, tbl_trans_beli.id_user, tbl_trans_beli.id_supplier, tbl_trans_beli.status_nota, tbl_trans_beli.status_bayar')
                                ->join('tbl_m_supplier', 'tbl_m_supplier.id=tbl_trans_beli.id_supplier')
//                                ->like('tbl_trans_beli.id_user', ($id_grup->name == 'superadmin' || $id_grup->name == 'owner' ? '' : $id_user))
                                ->like('tbl_m_supplier.nama', $sl)
                                ->like('tbl_trans_beli.no_nota', $nt)
                                ->like('DATE(tbl_trans_beli.tgl_masuk)', $tg)
                                ->like('DATE(tbl_trans_beli.tgl_keluar)', $tp)
                                ->like('DATE(tbl_trans_beli.tgl_bayar)', $tb)
                                ->like('tbl_trans_beli.status_bayar', $sb)
                                ->order_by('tbl_trans_beli.tgl_masuk','desc')
                                ->get('tbl_trans_beli')->num_rows();                
            }

            /* -- Form Error -- */
            $data['hasError']                = $this->session->flashdata('form_error');

            /* -- Blok Pagination -- */
            $config['base_url']              = base_url('transaksi/input_retur_beli.php'.(!empty($nt) ? '?filter_nota='.$nt.'&' : '?').(!empty($tg) ? 'filter_tgl='.$tg.'&' : '').(!empty($sl) ? 'filter_supplier='.$sl.'&' : '').(!empty($tb) ? 'filter_tgl_bayar='.$tb.'&' : ''));
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
                   $data['penj'] = $this->db->select('tbl_trans_beli.id, tbl_trans_beli.no_nota, DATE(tbl_trans_beli.tgl_masuk) as tgl_masuk, DATE(tbl_trans_beli.tgl_bayar) as tgl_bayar, DATE(tbl_trans_beli.tgl_keluar) as tgl_keluar, tbl_trans_beli.jml_total, tbl_trans_beli.jml_retur, tbl_trans_beli.jml_gtotal, tbl_trans_beli.id_user, tbl_trans_beli.id_supplier, tbl_trans_beli.status_nota, tbl_trans_beli.status_bayar')
                           ->join('tbl_m_supplier', 'tbl_m_supplier.id=tbl_trans_beli.id_supplier')
                           ->limit($config['per_page'],$hal)
//                           ->like('tbl_trans_beli.id_user', ($id_grup->name == 'superadmin' || $id_grup->name == 'owner' ? '' : $id_user))
                           ->like('tbl_m_supplier.nama', $sl)
                           ->like('tbl_trans_beli.no_nota', $nt)
                           ->like('DATE(tbl_trans_beli.tgl_masuk)', $tg)
                           ->like('DATE(tbl_trans_beli.tgl_keluar)', $tp)
                           ->like('DATE(tbl_trans_beli.tgl_bayar)', $tb)
                           ->like('tbl_trans_beli.status_bayar', $sb)
                           ->order_by('tbl_trans_beli.tgl_masuk','desc')
                           ->get('tbl_trans_beli')->result();
            }else{
                   $data['penj'] = $this->db->select('tbl_trans_beli.id, tbl_trans_beli.no_nota, DATE(tbl_trans_beli.tgl_masuk) as tgl_masuk, DATE(tbl_trans_beli.tgl_bayar) as tgl_bayar, DATE(tbl_trans_beli.tgl_keluar) as tgl_keluar, tbl_trans_beli.jml_total, tbl_trans_beli.jml_retur, tbl_trans_beli.jml_gtotal, tbl_trans_beli.id_user, tbl_trans_beli.id_supplier, tbl_trans_beli.status_nota, tbl_trans_beli.status_bayar')
                           ->join('tbl_m_supplier', 'tbl_m_supplier.id=tbl_trans_beli.id_supplier')
                           ->limit($config['per_page'],$hal)
//                           ->like('tbl_trans_beli.id_user', ($id_grup->name == 'superadmin' || $id_grup->name == 'owner' ? '' : $id_user))
                           ->like('tbl_m_supplier.nama', $sl)
                           ->like('tbl_trans_beli.no_nota', $nt)
                           ->like('DATE(tbl_trans_beli.tgl_masuk)', $tg)
                           ->like('DATE(tbl_trans_beli.tgl_keluar)', $tp)
                           ->like('DATE(tbl_trans_beli.tgl_bayar)', $tb)
                           ->like('tbl_trans_beli.status_bayar', $sb)
                           ->order_by('tbl_trans_beli.tgl_masuk','desc')
                           ->get('tbl_trans_beli')->result();
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
            $this->load->view('admin-lte-2/includes/trans/input_retur_beli',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }

    public function input_retur_beli_m() {
        if (akses::aksesLogin() == TRUE) {
            /* -- Grup hak akses -- */
            $grup        = $this->ion_auth->get_users_groups()->row();
            $id_user     = $this->ion_auth->user()->row()->id;
            $id_grup     = $this->ion_auth->get_users_groups()->row();
            $pengaturan  = $this->db->get('tbl_pengaturan')->row();
            
            $data['sess_beli']  = $this->session->userdata('trans_retur_beli_m');
//            $data['sess_jual']  = $this->session->userdata('trans_retur_beli_m_rute');

            /* Load view tampilan */
            $this->load->view('admin-lte-2/1_atas',$data);
            $this->load->view('admin-lte-2/2_header',$data);
            $this->load->view('admin-lte-2/includes/trans/input_retur_beli_m',$data);
            $this->load->view('admin-lte-2/5_footer',$data);
            $this->load->view('admin-lte-2/6_bawah',$data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    
    public function cetak_data_penjualan(){
        if (akses::aksesLogin() == TRUE) {
            $case = $this->input->get('case');
            
            $data['produk'] = '';

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/includes/trans/cetak_data_penjualan', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    

    public function pdf_data_penjualan(){
        if (akses::aksesLogin() == TRUE) {
            $nt = $this->input->get('filter_nota');
            $fn = explode('/', $nt);
            $tg = $this->input->get('filter_tgl');
            $tp = $this->input->get('filter_tgl_tempo');
            $lk = $this->input->get('filter_lokasi');
            $cs = $this->input->get('filter_cust');
            $sn = $this->input->get('filter_status');
            $sl = $this->input->get('filter_sales');
            
            $sql = $this->db->select('no_nota, kode_nota_dpn, kode_nota_blk, kode_nota_dpn, kode_nota_blk, DATE(tgl_masuk) as tgl_masuk, DATE(tgl_bayar) as tgl_bayar, DATE(tgl_keluar) as tgl_keluar, jml_total, jml_gtotal, ppn, jml_ppn, id_user, id_sales, id_pelanggan, status_nota, status_bayar')
                           ->like('no_nota', substr($fn[0], 1))
//                           ->or_like('kode_nota_dpn', $nt, 'before')
//                           ->or_like('kode_nota_blk', $nt, 'after')
                           ->like('DATE(tgl_masuk)', $tg)
                           ->like('DATE(tgl_keluar)', $tp)
                           ->like('id_pelanggan', $cs)
                           ->like('id_sales', $sl)
                           ->order_by('no_nota','desc')
                           ->get('tbl_trans_jual')->result();

            $setting = $this->db->query("SELECT * FROM tbl_pengaturan")->row();
            $judul = "LAPORAN DATA PENJUALAN";

            $this->fpdf->FPDF('P', 'cm', 'a4');
            $this->fpdf->SetAutoPageBreak('auto');
            $this->fpdf->SetMargins(1, 1, 1);
            $this->fpdf->AliasNbPages();
            $this->fpdf->AddPage();

            $this->fpdf->SetFont('Arial', 'B', '14');
            $this->fpdf->Cell(19, .75, $setting->judul, '0', 1, 'C');
            $this->fpdf->Ln(0);
            $this->fpdf->SetFont('Arial', 'B', '11');
            $this->fpdf->Cell(19, .5, $setting->alamat, 'B', 1, 'C');
            $this->fpdf->Ln(0);
            $this->fpdf->SetFont('Arial', 'B', '14');
            $this->fpdf->Cell(19, .75, $judul, 0, 1, 'C');
            $this->fpdf->Ln();


            // Fill Colornya
            $this->fpdf->SetFillColor(211, 223, 227);
            $this->fpdf->SetTextColor(0);
            $this->fpdf->SetFont('Arial', 'B', '10');


//        // Header tabel
            $this->fpdf->Cell(1, .5, 'No', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(2.5, .5, 'Tgl', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(2.5, .5, 'Tempo', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(3, .5, 'No. Invoice', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(6, .5, 'Customer', 1, 0, 'C', TRUE);
//            $this->fpdf->Cell(3, .5, 'Sales', 1, 0, 'C', TRUE);
            $this->fpdf->Cell(4, .5, 'Nominal', 1, 0, 'C', TRUE);
            $this->fpdf->Ln();


            $this->fpdf->SetFillColor(235, 232, 228);
            $this->fpdf->SetTextColor(0);
            $this->fpdf->SetFont('Arial', '', '10');

            if (!empty($sql)) {
                $fill = FALSE;
                $no = 1;
                $tot = 0;
                foreach ($sql as $items) {
                    $tot    = $tot + $items->jml_gtotal;
                    $tgl_m    = explode('-', $items->tgl_masuk);
                    $tgl_t  = explode('-', $items->tgl_keluar);
                    $plgn   = $this->db->where('id', $items->id_pelanggan)->get('tbl_m_pelanggan')->row();
                    $sales  = $this->db->where('id', $items->id_sales)->get('tbl_m_sales')->row();
                    
                    $this->fpdf->Cell(1, .5, $no . '.', 1, 0, 'C', $fill);
                    $this->fpdf->Cell(2.5, .5,$tgl_m[1] . '/' . $tgl_m[2] . '/' . $tgl_m[0], 1, 0, 'C', $fill);
                    $this->fpdf->Cell(2.5, .5,$tgl_t[1] . '/' . $tgl_t[2] . '/' . $tgl_t[0], 1, 0, 'C', $fill);
                    $this->fpdf->Cell(3, .5,$items->kode_nota_dpn.$items->no_nota.'/'.$items->kode_nota_blk, 1, 0, 'L', $fill);
                    $this->fpdf->Cell(6, .5, ucwords($plgn->nama), 1, 0, 'L', $fill);
//                    $this->fpdf->Cell(3, .5, ucwords($sales->nama), 1, 0, 'L', $fill);
                    $this->fpdf->Cell(4, .5, general::format_angka($items->jml_gtotal), 1, 0, 'R', $fill);
                    $this->fpdf->Ln();

                    $fill = !$fill;
                    $no++;
                }
                $this->fpdf->SetFont('Arial', 'B', '11');
                $this->fpdf->Cell(15, .5, 'Total', 1, 0, 'R');
                $this->fpdf->Cell(4, .5, general::format_angka($tot), 1, 0, 'R');
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

            $this->fpdf->Output('lap_data_pengeluaran_' . date('YmdHm') . '.pdf', $type);
        }else{
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();            
        }
    }
    
    
    public function set_nota_jual() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota    = $this->input->post('no_nota');
            $kode_fp    = $this->input->post('kode_fp');
            $tgl_masuk  = $this->input->post('tgl_masuk');
            $tgl_tempo  = $this->input->post('tgl_tempo');
            $plgn       = $this->input->post('id_customer');
            $sales      = $this->input->post('id_sales');
            $kategori   = $this->input->post('kategori');
            $status_ppn = $this->input->post('status_ppn');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();
            $pengaturan2= $this->db->where('id', $this->ion_auth->user()->row()->id_app)->get('tbl_pengaturan_cabang')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('no_nota', 'no_nota', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'no_nota' => form_error('no_nota'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url('transaksi/trans_jual.php'));
            } else {
                $tgl_msk    = explode('/', $tgl_masuk);
                $tgl_klr    = explode('/', $tgl_tempo);
                $sql_diskon = $this->db->where('id_pelanggan', $plgn)->where('id_kategori', $kategori)->get('tbl_m_pelanggan_diskon')->row();
                
                $sql_nota   = $this->db->get('tbl_trans_jual');
                $noUrut     = $sql_nota->num_rows() + 1;
            
                $data = array(
                    'id_app'       => strtoupper($pengaturan2->keterangan),
                    'kode_fp'      => $kode_fp,
                    'tgl_simpan'   => date('Y-m-d H:i:s'),
                    'tgl_masuk'    => $tgl_msk[2].'-'.$tgl_msk[0].'-'.$tgl_msk[1],
                    'tgl_keluar'   => $tgl_klr[2].'-'.$tgl_klr[0].'-'.$tgl_klr[1],
                    'id_pelanggan' => $plgn,
                    'id_kategori'  => $kategori,
                    'id_sales'     => $sales,
                    'id_user'      => $this->ion_auth->user()->row()->id,
                    'disk1'        => $sql_diskon->disk1,
                    'disk2'        => $sql_diskon->disk2,
                    'disk3'        => $sql_diskon->disk3,
                    'status_ppn'   => (!empty($status_ppn) ? $status_ppn : '0'),
                );
                
                $this->session->set_userdata('trans_jual', $data);
                redirect(base_url('transaksi/trans_jual.php?id='.general::enkrip($noUrut)));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_nota_jual_pen() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota    = $this->input->post('no_nota');
            $kode_fp    = $this->input->post('kode_fp');
            $tgl_masuk  = $this->input->post('tgl_masuk');
            $tgl_tempo  = $this->input->post('tgl_tempo');
            $plgn       = $this->input->post('id_customer');
            $sales      = $this->input->post('id_sales');
            $kategori   = $this->input->post('kategori');
            $status_ppn = $this->input->post('status_ppn');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('no_nota', 'no_nota', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'no_nota' => form_error('no_nota'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url('transaksi/trans_jual.php'));
            } else {
                $tgl_msk    = explode('/', $tgl_masuk);
                $tgl_klr    = explode('/', $tgl_tempo);
                $sql_diskon = $this->db->where('id_pelanggan', $plgn)->where('id_kategori', $kategori)->get('tbl_m_pelanggan_diskon')->row();
                
                // Kode Nomor Nota
                $sql_sales = $this->db->where('id', $sales)->get('tbl_m_sales')->row();
                $nota      = general::no_nota('','tbl_trans_jual_pen','no_nota');
                
                $data = array(
                    'no_nota'       => $nota,
                    'kode_nota_dpn' => 'SP.',
                    'kode_nota_blk' => $sql_sales->kode,
                    'tgl_simpan'    => date('Y-m-d H:i:s'),
                    'tgl_masuk'     => $this->tanggalan->tgl_indo_sys($tgl_masuk),
                    'tgl_keluar'    => $this->tanggalan->tgl_indo_sys($tgl_tempo),
                    'id_pelanggan'  => $plgn,
                    'id_sales'      => $sales,
                    'id_user'       => $this->ion_auth->user()->row()->id,
                    'status_nota'   => '1',
                    'status_ppn'    => $status_ppn
                );
                
                $this->session->set_userdata('trans_jual_pen', $data);
                crud::simpan('tbl_trans_jual_pen', $data);
                redirect(base_url('transaksi/trans_jual_pen.php?id='.general::enkrip($no_nota)));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_nota_jual_umum() {
        if (akses::aksesLogin() == TRUE) {
            $kode_fp    = $this->input->post('kode_fp');
            $tgl_masuk  = $this->input->post('tgl_masuk');
            $tgl_tempo  = $this->input->post('tgl_tempo');
            $plgn       = $this->input->post('id_customer');
            $sales      = $this->input->post('id_sales');
            $kategori   = $this->input->post('kategori');
            $status_ppn = $this->input->post('status_ppn');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();
            $pengaturan2= $this->db->where('id', $this->ion_auth->user()->row()->id_app)->get('tbl_pengaturan_cabang')->row();
            $id_user    = $this->ion_auth->user()->row()->id;

            $tgl_msk    = explode('/', $tgl_masuk);
            $tgl_klr    = explode('/', $tgl_tempo);
            $sql_diskon = $this->db->where('id_pelanggan', $plgn)->where('id_kategori', $kategori)->get('tbl_m_pelanggan_diskon')->row();
            $sql_sales  = $this->db->where('id_user', $id_user)->get('tbl_m_sales')->row();
            
            $sql_nota   = $this->db->get('tbl_trans_jual');
            $noUrut     = $sql_nota->num_rows() + 1;
            
            $data = array(
                'id_app'       => strtoupper($pengaturan2->keterangan),
                'kode_fp'      => $kode_fp,
                'tgl_simpan'   => date('Y-m-d H:i:s'),
                'tgl_masuk'    => date('Y-m-d'),
                'tgl_keluar'   => date('Y-m-d'),
                'id_pelanggan' => (!empty($plgn) ? $plgn : 1),
                'id_kategori'  => 0,
                'id_sales'     => (!empty($sql_sales->id) ? $sql_sales->id : 1),
                'id_user'      => $this->ion_auth->user()->row()->id,
                'disk1'        => $sql_diskon->disk1,
                'disk2'        => $sql_diskon->disk2,
                'disk3'        => $sql_diskon->disk3,
                'status_ppn'   => 0,
            );
            
            $this->session->set_userdata('trans_jual_umum', $data);
            redirect(base_url('transaksi/trans_jual_umum.php?id='.general::enkrip($noUrut)));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_nota_jual_upd() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota    = $this->input->post('no_nota');
            $kode_fp    = $this->input->post('kode_fp');
            $tgl_masuk  = $this->input->post('tgl_masuk');
            $tgl_tempo  = $this->input->post('tgl_tempo');
            $plgn       = $this->input->post('id_customer');
            $sales      = $this->input->post('id_sales');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('no_nota', 'no_nota', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'no_nota' => form_error('no_nota'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url('transaksi/data_penj_list.php'));
            } else {
                $tgl_msk    = explode('/', $tgl_masuk);
                $tgl_klr    = explode('/', $tgl_tempo);
                $sql_diskon = $this->db->where('id_pelanggan', $plgn)->where('id_kategori', $kategori)->get('tbl_m_pelanggan_diskon')->row();
                
                $data = array(
                    'tgl_simpan'   => date('Y-m-d H:i:s'),
                    'tgl_masuk'    => $tgl_msk[2].'-'.$tgl_msk[0].'-'.$tgl_msk[1],
                    'tgl_keluar'   => $tgl_klr[2].'-'.$tgl_klr[0].'-'.$tgl_klr[1],
                    'id_pelanggan' => $plgn,
                    'id_sales'     => $sales,
                    'id_user'      => $this->ion_auth->user()->row()->id,
                    'disk1'        => $sql_diskon->disk1,
                    'disk2'        => $sql_diskon->disk2,
                    'disk3'        => $sql_diskon->disk3,
                );

                $this->session->set_userdata('trans_jual_upd', $data);
                crud::update('tbl_trans_jual', 'no_nota', general::dekrip($no_nota), $data);
                redirect(base_url('transaksi/trans_jual_edit.php?id='.$no_nota));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_nota_jual_upd_item() {
        if (akses::aksesLogin() == TRUE) {
            $id         = $this->input->post('id');
            $id_prod    = $this->input->post('id_produk');
            $id_satuan  = $this->input->post('id_satuan');
            $id_penj_det= $this->input->post('aid');
            $edit_jml   = $this->input->post('edit_jml');
            $edit_sat   = $this->input->post('edit_satuan');
            $edit_hrg   = str_replace('.', '', $this->input->post('edit_harga'));
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id', 'no _nota', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'no_nota' => form_error('no_nota'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url('transaksi/trans_jual_edit.php?id='.$id));
            } else {
                $sql_satuan   = $this->db->where('id_produk', general::dekrip($id_prod))->where('satuan', $edit_sat)->get('tbl_m_produk_satuan')->row();
                $sql_penj_det = $this->db->where('id', general::dekrip($id_penj_det))->get('tbl_trans_jual_det')->row();
                $sql_penj     = $this->db->where('id', $sql_penj_det->id_penjualan)->get('tbl_trans_jual')->row();
                $sql_brg      = $this->db->where('id', general::dekrip($id_prod))->get('tbl_m_produk')->row();
                $sql_brg_sat  = $this->db->where('id', $sql_brg->id_satuan)->get('tbl_m_satuan')->row();
                $harga_j      = $edit_hrg;
                $subtotal     = $harga_j * $edit_jml;
                $jml_satuan   = (!empty($sql_satuan->jml) ? $sql_satuan->jml : 1);
                $jml_real     = (!empty($sql_satuan->jml) ? $edit_jml * $sql_satuan->jml : $edit_jml);
                $jml_sblmnx   = ($sql_penj_det->jml * $sql_penj_det->jml_satuan);
                $jml_akhir    = ($sql_brg->jml + $jml_sblmnx) - $jml_real;

                if($jml_akhir < 0){
                    $this->session->set_flashdata('transaksi', '<div class="alert alert-danger">Item "<b>'.$sql_brg->produk.'</b>", Jumlah tidak mencukupi !!</div>');
                    redirect(base_url('transaksi/trans_jual_edit.php?id='.$id));
                }else{
                    // Simpan penjualan ke tabel
                    $data_penj = array(
                        'satuan'        => $edit_sat,
                        'keterangan'    => ($edit_sat != $sql_brg_sat->satuanTerkecil ? ' ('.$edit_jml * $jml_satuan.' '.$sql_brg_sat->satuanTerkecil.')' : ''),
                        'harga'         => ceil((float)$edit_hrg),
                        'jml'           => ceil((float)$edit_jml),
                        'jml_satuan'    => $jml_satuan,
                        'subtotal'      => ceil((float)$subtotal),
                    );
                    
                    // Kembalikan dulu stok sebelumnya berdasarkan transaksi sebelumnya
                    $this->db->where('id_produk', $sql_brg->id)->where('id_penjualan', $sql_penj_det->id_penjualan)->delete('tbl_m_produk_hist');
                    $data_brg = array(
                        'tgl_modif' => date('Y-m-d H:i:s'),
                        'jml'       => $jml_akhir
                    );
                    
                    $data_brg_hist = array(
                        'tgl_simpan'    => date('Y-m-d H:i:s'),
                        'id_produk'     => $sql_brg->id,
                        'id_user'       => $this->ion_auth->user()->row()->id,
                        'id_penjualan'  => $sql_penj->id,
                        'id_pelanggan'  => $sql_penj->id_pelanggan,
                        'no_nota'       => $sql_penj->no_nota,
                        'kode'          => $sql_penj_det->kode,
                        'keterangan'    => 'Penjualan '.$sql_penj->no_nota.(!empty($sql_penj->kode_nota_blk) ? '/'.$sql_penj->kode_nota_blk : ''),
                        'nominal'       => ceil((float)$edit_hrg),
                        'jml'           => ceil((float)$edit_jml),
                        'jml_satuan'    => $jml_satuan,
                        'satuan'        => $edit_sat,
                        'status'        => '4',
                    );
                    
                    crud::update('tbl_m_produk', 'id', $sql_brg->id, $data_brg);
                    crud::update('tbl_trans_jual_det', 'id', general::dekrip($id_penj_det), $data_penj);
                    crud::simpan('tbl_m_produk_hist', $data_brg_hist);
                    /* --- */
                }
                
                $this->session->set_flashdata('transaksi', '<div class="alert alert-success">Data berhasil di ubah !!!</div>');
                redirect(base_url('transaksi/trans_jual_edit.php?id='.$id));
                
                echo '<pre>';
                print_r($data_penj);
                echo '</pre>';
                echo '<pre>';
                print_r($data_brg_hist);
                echo '</pre>';
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_nota_beli() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota    = $this->input->post('no_nota');
            $tgl_masuk  = $this->input->post('tgl_masuk');
            $tgl_tempo  = $this->input->post('tgl_tempo');
            $plgn       = $this->input->post('id_supplier');
//            $sales      = $this->input->post('id_sales');
            $status_ppn = $this->input->post('status_ppn');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('no_nota', 'no_nota', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'no_nota' => form_error('no_nota'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url('transaksi/trans_beli.php'));
            } else {
                $tgl_msk = explode('/', $tgl_masuk);
                $tgl_klr = explode('/', $tgl_tempo);
                
                $data = array(
                    'no_nota'      => $no_nota,
                    'tgl_simpan'   => date('Y-m-d H:i:s'),
                    'tgl_masuk'    => $tgl_msk[2].'-'.$tgl_msk[0].'-'.$tgl_msk[1],
                    'tgl_keluar'   => $tgl_klr[2].'-'.$tgl_klr[0].'-'.$tgl_klr[1],
                    'id_supplier'  => $plgn,
                    'id_user'      => $this->ion_auth->user()->row()->id,
                    'status_ppn'   => (!empty($status_ppn) ? $status_ppn : '0'),
                );
                
                $this->session->set_userdata('trans_beli', $data);
                redirect(base_url('transaksi/trans_beli.php?id='.general::enkrip($no_nota)));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_nota_beli_po() {
        if (akses::aksesLogin() == TRUE) {
            $tgl_masuk  = $this->input->post('tgl_masuk');
            $tgl_tempo  = $this->input->post('tgl_tempo');
            $plgn       = $this->input->post('id_supplier');
            $ket        = $this->input->post('keterangan');
            $pengiriman = $this->input->post('pengiriman');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id_supplier', 'id_supplier', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'id_supplier' => form_error('id_supplier'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url('transaksi/trans_beli_po.php'));
            } else {
                $tgl_msk = $this->tanggalan->tgl_indo_sys($tgl_masuk);
                $tgl_klr = $this->tanggalan->tgl_indo_sys($tgl_tempo);
                $sql_num = $this->db->get('tbl_trans_beli_po')->num_rows();
                $no_nota = 'PO.'.sprintf("%05s", $sql_num + 1).'/'.$this->tanggalan->getBulan(date('m')).'/'.date('Y');
                
                $data = array(
                    'no_nota'      => $no_nota,
                    'tgl_simpan'   => date('Y-m-d H:i:s'),
                    'tgl_masuk'    => $tgl_msk,
                    'tgl_keluar'   => $tgl_klr,
                    'id_supplier'  => $plgn,
                    'id_user'      => $this->ion_auth->user()->row()->id,
                    'keterangan'   => $ket,
                    'pengiriman'   => $pengiriman,
                    'status_nota'  => '0'
                );
                crud::simpan('tbl_trans_beli_po', $data);
                $sql_max = $this->db->select_max('id')->get('tbl_trans_beli_po')->row();
                
//                echo '<pre>';
//                print_r($sql_num);
//                echo '</pre>';
//                
//                echo '<pre>';
//                print_r($data);
//                echo '</pre>';
//                echo '<pre>';
//                print_r($sql_max);
                
                $this->session->set_userdata('trans_beli_po', $data);                
                redirect(base_url('transaksi/trans_beli_po.php?id='.general::enkrip($sql_max->id)));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_nota_beli_upd() {
        if (akses::aksesLogin() == TRUE) {
            $id         = $this->input->post('id');
            $no_nota    = $this->input->post('no_nota');
            $tgl_masuk  = $this->input->post('tgl_masuk');
            $tgl_tempo  = $this->input->post('tgl_tempo');
            $plgn       = $this->input->post('id_supplier');
//            $sales      = $this->input->post('id_sales');
            $status_ppn = $this->input->post('status_ppn');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('no_nota', 'no_nota', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'no_nota' => form_error('no_nota'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url('transaksi/trans_beli_edit.php?id='.$id));
            } else {
                $tgl_msk = explode('/', $tgl_masuk);
                $tgl_klr = explode('/', $tgl_tempo);
                
                $data = array(
                    'no_nota'      => $no_nota,
                    'tgl_modif'    => date('Y-m-d H:i:s'),
                    'tgl_masuk'    => $tgl_msk[2].'-'.$tgl_msk[0].'-'.$tgl_msk[1],
                    'tgl_keluar'   => $tgl_klr[2].'-'.$tgl_klr[0].'-'.$tgl_klr[1],
                    'id_supplier'  => $plgn,
                    'id_user'      => $this->ion_auth->user()->row()->id,
                    'status_ppn'   => (!empty($status_ppn) ? $status_ppn : '0'),
                );
                
                $this->session->set_userdata('trans_beli_upd', $data);
                crud::update('tbl_trans_beli', 'id', general::dekrip($id), $data);
                redirect(base_url('transaksi/trans_beli_edit.php?id='.$id));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_nota_beli_upd_po() {
        if (akses::aksesLogin() == TRUE) {
            $id         = $this->input->post('id');
            $tgl_masuk  = $this->input->post('tgl_masuk');
            $tgl_tempo  = $this->input->post('tgl_tempo');
            $plgn       = $this->input->post('id_supplier');
            $ket        = $this->input->post('keterangan');
            $pengiriman = $this->input->post('pengiriman');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id_supplier', 'id_supplier', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'id_supplier' => form_error('id_supplier'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url('transaksi/trans_beli_po.php'));
            } else {
                $tgl_msk = $this->tanggalan->tgl_indo_sys($tgl_masuk);
                $tgl_klr = $this->tanggalan->tgl_indo_sys($tgl_tempo);
                $sql_num = $this->db->get('tbl_trans_beli_po')->num_rows();
                $no_nota = 'PO.'.sprintf("%05s", $sql_num + 1).'/'.$this->tanggalan->getBulan(date('m')).'/'.date('Y');
                
                $data = array(
                    'no_nota'      => $no_nota,
                    'tgl_simpan'   => date('Y-m-d H:i:s'),
                    'tgl_masuk'    => $tgl_msk,
                    'tgl_keluar'   => $tgl_klr,
                    'id_supplier'  => $plgn,
                    'id_user'      => $this->ion_auth->user()->row()->id,
                    'keterangan'   => $ket,
                    'pengiriman'   => $pengiriman,
                    'status_nota'  => '1'
                );
                crud::update('tbl_trans_beli_po', 'id', general::dekrip($id), $data);
                $sql_max = $this->db->select_max('id')->get('tbl_trans_beli_po')->row();
                
//                echo '<pre>';
//                print_r($sql_num);
//                echo '</pre>';
//                
//                echo '<pre>';
//                print_r($data);
//                echo '</pre>';
//                echo '<pre>';
//                print_r($sql_max);
                
                $this->session->set_userdata('trans_beli_po_upd', $data);                
                redirect(base_url('transaksi/trans_beli_edit_po.php?id='.general::enkrip($sql_max->id)));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_retur_jual() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota    = $this->input->post('no_nota');
            $rute       = $this->input->post('route');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('no_nota', 'no_nota', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'no_nota' => form_error('no_nota'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url('transaksi/trans_retur_jual.php?no_nota='.$no_nota));
            } else {
                $penj     = $this->db->where('id', general::dekrip($no_nota))->get('tbl_trans_jual')->row();
                $no_retur = general::no_nota('','tbl_trans_retur_jual', 'no_retur');
                
                $data = array(
                    'id_penjualan' => $penj->id,
                    'no_retur'     => $no_retur,
                    'no_nota'      => $penj->no_nota,
                    'id_pelanggan' => $penj->id_pelanggan,
                    'id_user'      => $this->ion_auth->user()->row()->id,
                    'tgl_simpan'   => date('Y-m-d'),
                    'status_retur' => '0',
                );
                
//                echo '<pre>';;
//                print_r($data);
                $this->session->set_userdata('trans_retur_jual', $data);
                crud::simpan('tbl_trans_retur_jual', $data);
                $retur = $this->db->select_max('id')->get('tbl_trans_retur_jual')->row();
                redirect(base_url('transaksi/trans_retur_jual.php?id='.general::enkrip($retur->id).'&no_nota='.general::enkrip($penj->id).'&route='.$rute));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_retur_jual_update() {
        if (akses::aksesLogin() == TRUE) {
            $id         = $this->input->post('id');
            $no_nota    = $this->input->post('no_nota');
            $rute       = $this->input->post('route');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('no_nota', 'no_nota', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'no_nota' => form_error('no_nota'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url('transaksi/trans_retur_jual.php?no_nota='.$no_nota));
            } else {
                $penj     = $this->db->where('id', general::dekrip($no_nota))->get('tbl_trans_jual')->row();
                $no_retur = general::no_nota('','tbl_trans_retur_jual', 'no_retur');
                
                $data = array(
                    'id_penjualan' => $penj->id,
                    'no_retur'     => $no_retur,
                    'no_nota'      => $penj->no_nota,
                    'id_pelanggan' => $penj->id_pelanggan,
                    'id_user'      => $this->ion_auth->user()->row()->id,
                    'tgl_simpan'   => date('Y-m-d'),
                    'status_retur' => '0',
                );
                
                $this->session->set_userdata('trans_retur_jual', $data);
                crud::update('tbl_trans_retur_jual', 'id', '', $data);
                redirect(base_url('transaksi/trans_retur_jual.php?id='.$id.'&no_nota='.general::enkrip($penj->id).'&route='.$rute));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_retur_beli() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota    = $this->input->post('no_nota');
            $rute       = $this->input->post('route');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('no_nota', 'no_nota', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'no_nota' => form_error('no_nota'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url('transaksi/trans_retur_beli.php?no_nota='.$no_nota));
            } else {
                $penj       = $this->db->where('id', general::dekrip($no_nota))->get('tbl_trans_beli')->row();
                $no_retur   = general::no_nota('','tbl_trans_retur_beli', 'no_retur');
                
                $data = array(
                    'id_user'      => $this->ion_auth->user()->row()->id,
                    'id_pelanggan' => $penj->id_supplier,
                    'id_pembelian' => $penj->id,
                    'tgl_simpan'   => date('Y-m-d H:i:s'),
                    'no_retur'     => $no_retur,
                    'no_nota'      => $penj->no_nota,
                    'status_retur' => '0',
                );
                
                $this->session->set_userdata('trans_retur_beli', $data);
                crud::simpan('tbl_trans_retur_beli', $data);
                $retur = $this->db->select_max('id')->get('tbl_trans_retur_beli')->row();
                redirect(base_url('transaksi/trans_retur_beli.php?id='.general::enkrip($retur->id).'&no_nota='.general::enkrip($penj->id).'&route='.$rute));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_retur_beli_m() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota    = $this->input->post('no_nota');
            $rute       = $this->input->post('route');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id_supplier', 'Data Supplier', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'id_supplier' => form_error('id_supplier'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url('transaksi/input_retur_beli_m.php?err_msg='.$msg_error['id_supplier']));
            } else {
                $penj       = $this->db->where('id', general::dekrip($no_nota))->get('tbl_trans_beli')->row();
                $no_retur   = general::no_nota('','tbl_trans_retur_beli', 'no_retur');
                
                $data = array(
                    'id_user'      => $this->ion_auth->user()->row()->id,
                    'id_supplier'  => $penj->id_supplier,
                    'tgl_simpan'   => date('Y-m-d H:i:s'),
                    'no_retur'     => $no_retur,
                    'sess_id'      => general::enkrip($no_retur),
                    'status_retur' => '0',
                );
                
                $this->session->set_userdata('trans_retur_beli_m', $data);
//                crud::simpan('tbl_trans_retur_beli', $data);
//                $retur = $this->db->select_max('id')->get('tbl_trans_retur_beli')->row();
                redirect(base_url('transaksi/input_retur_beli_m.php?id='.general::enkrip($no_retur).'&route='.$rute));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_nota_ppn() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota    = $this->input->post('no_nota');
            $ppn        = $this->input->post('ppn');
            $jml_total  = $this->input->post('jml_total');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('no_nota', 'no_nota', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'no_nota' => form_error('no_nota'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url('transaksi/trans_jual.php'));
            } else {
                $jml_ppn = ($ppn / 100) * $jml_total;
                $data = array(
                    'tgl_modif' => date('Y-m-d H:i:s'),
                    'ppn'       => $ppn,
                    'jml_ppn'   => $jml_ppn,
                );
                echo '<pre>';
                print_r($data);
                echo '</pre>';
                
                crud::update('tbl_trans_jual', 'no_nota', general::dekrip($no_nota), $data);
                redirect(base_url('transaksi/trans_jual.php?id='.$no_nota));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_nota_jual_proses() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota    = $this->input->post('no_nota');
            $jml_total  = $this->input->post('jml_total');
            $jml_ppn    = $this->input->post('jml_ppn');
            $act        = $this->input->post('act');
            $rute       = $this->input->post('route');
            $cetak      = $this->input->post('cetak');
            $status_gd  = $this->ion_auth->user()->row()->status_gudang;
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

//            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
//
//            $this->form_validation->set_rules('no_nota', 'no_nota', 'required');
//
//            if ($this->form_validation->run() == FALSE) {
//                $msg_error = array(
//                    'no_nota' => form_error('no_nota'),
//                );
//
//                $this->session->set_flashdata('form_error', $msg_error);
//                
//                redirect(base_url('transaksi/trans_jual.php'));
//            } else {
                $trans_jual     = $this->session->userdata((!empty($act) ? $act : 'trans_jual'));
                $trans_jual_det = $this->cart->contents();
                $sales          = $this->db->where('id', $trans_jual['id_sales'])->get('tbl_m_sales')->row();
                                                
                // Kode Nomor Nota
                $sql_sales      = $this->db->where('id', $trans_jual['id_sales'])->get('tbl_m_sales')->row();
                $sql_kat        = $this->db->where('id', $trans_jual['id_kategori'])->get('tbl_m_kategori')->row();
                $sql_nota       = $this->db->get('tbl_trans_jual');
                $noUrut         = $sql_nota->num_rows() + 1;
                $nomer_nota     = $sql_nota->num_rows() + 1;
//                $nota           = sprintf("%05s", $noUrut).sprintf("%02s", rand(1,64));
                
                // Simpan penjualan ke tabel
                $data_penj = array(
                    'id_app'        => $this->ion_auth->user()->row()->id_app,
                    'no_nota'       => $nomer_nota,
                    'kode_nota_dpn' => $sql_kat->kategori,
                    'kode_nota_blk' => 'G',
                    'kode_fp'       => $trans_jual['kode_fp'],
                    'tgl_simpan'    => $trans_jual['tgl_simpan'],
                    'tgl_modif'     => '0000-00-00',
                    'tgl_masuk'     => $trans_jual['tgl_masuk'],
                    'tgl_keluar'    => $trans_jual['tgl_keluar'],
                    'id_kategori'   => $trans_jual['id_kategori'],
                    'id_pelanggan'  => $trans_jual['id_pelanggan'],
                    'id_sales'      => $trans_jual['id_sales'],
                    'id_user'       => $trans_jual['id_user'],
                    'status_nota'   => '1',
                    'status_ppn'    => $trans_jual['status_ppn'],
                    'status_grosir' => '1',
                );
                                
                crud::simpan('tbl_trans_jual', $data_penj);
                $last_id = crud::last_id();
                $nota    = sprintf("%05s", $last_id).date('dm');
                
                $tot_gtotal_real = 0;
                $tot_diskon_real = 0;
                foreach ($trans_jual_det as $cart){
                     $sql_brg         = $this->db->where('kode', $cart['options']['kode'])->get('tbl_m_produk')->row();
                     $sql_brg_sat     = $this->db->where('id', $sql_brg->id_satuan)->get('tbl_m_satuan')->row();
                     $sql_brg_dep     = $this->db->where('id_produk', $sql_brg->id)->get('tbl_m_produk_deposit')->row();
                     $sql_brg_nom     = $this->db->where('id', $cart['options']['id_nominal'])->order_by('id', 'DESC')->get('tbl_m_produk_nominal')->row();
                     $sql_disk        = $this->db->where('id_pelanggan', $trans_jual['id_pelanggan'])->where('kode', $cart['options']['kode'])->get('tbl_trans_jual_diskon');
                     
                     $sql_gudang      = $this->db->where('status', $status_gd)->get('tbl_m_gudang')->row(); // Cek gudang aktif dari gudang utama
                     $sql_gudang_stok = $this->db->where('id_gudang', $sql_gudang->id)->where('id_produk', $sql_brg->id)->get('tbl_m_produk_stok')->row(); // ambil data dari stok tsb
                             
                     $jml_akhir       = $sql_brg->jml - ($cart['options']['jml_satuan'] * $cart['options']['jml']);
                     $jml_akhir_stk   = $sql_gudang_stok->jml - ($cart['options']['jml_satuan'] * $cart['options']['jml']);
                     $jml_diskon      = ($cart['qty'] * $cart['options']['harga']) - $cart['subtotal'];
                     $jml_gtotal_real = ($cart['qty'] * $cart['options']['harga']);
                     $tot_gtotal_real = $tot_gtotal_real + $jml_gtotal_real;
                     $tot_diskon_real = $tot_diskon_real + $jml_diskon + $cart['options']['potongan'];
                     
                     /* Cek lagi, sisa stok dari db */
                     if($jml_akhir_stk < 0){
                        /* Hapus dulu dari database */
                        crud::delete('tbl_trans_jual', 'id', $last_id);
                        
                        $this->session->set_flashdata('transaksi', '<div class="alert alert-danger">Stok <b>'.$sql_brg->produk.'</b> dari gudang '.$sql_gudang->gudang.' tidak mencukupi !. Stok tersedia di sistem <b>'.$sql_gudang_stok->jml.' '.$sql_brg_sat->satuanTerkecil.'</b></div>');
                        redirect(base_url('transaksi/'.(!empty($rute) ? $rute : 'trans_jual').'.php?id='.general::enkrip($last_id)));
                     }else{
                        $data_penj_det = array(
                            'id_penjualan' => $last_id,
                            'no_nota'      => $nota,
                            'tgl_simpan'   => $trans_jual['tgl_simpan'],
                            'id_satuan'    => $cart['options']['id_satuan'],
                            'satuan'       => $cart['options']['satuan'],
                            'keterangan'   => $cart['options']['satuan_ket'],
                            'kode'         => $cart['options']['kode'],
                            'produk'       => $cart['name'],
                            'jml'          => (int)$cart['qty'],
                            'jml_satuan'   => (int)$cart['options']['jml_satuan'],
                            'harga'        => (float)$cart['options']['harga'],
                            'disk1'        => (float)$cart['options']['disk1'],
                            'disk2'        => (float)$cart['options']['disk2'],
                            'disk3'        => (float)$cart['options']['disk3'],
                            'diskon'       => (float)$jml_diskon,
                            'potongan'     => (float)$cart['options']['potongan'],
                            'subtotal'     => (float)$cart['subtotal'],
                        );
                        
                        // Simpan sisa barang setelah di kurangi
                        $data_brg = array(
                            'tgl_modif' => date('Y-m-d H:i'),
                            'jml'       => (int)$jml_akhir
                        );
                        
                        // Simpan sisa stok dari gudang terkait setelah di kurangi
                        $data_stk = array(
                            'tgl_modif' => date('Y-m-d H:i'),
                            'jml'       => (int)$jml_akhir_stk
                        );
   
                        // Simpan diskon untuk penjualan ini
                        $data_diskon = array(
                            'tgl_simpan'   => date('Y-m-d H:i'),
                            'id_penjualan' => $last_id,
                            'no_nota'      => $nota,
                            'kode'         => $cart['options']['kode'],
                            'id_pelanggan' => $trans_jual['id_pelanggan'],
                            'disk1'        => $cart['options']['disk1'],
                            'disk2'        => $cart['options']['disk1'],
                            'disk3'        => $cart['options']['disk1'],
                        );
   		                     
                        crud::simpan('tbl_trans_jual_det', $data_penj_det);
   
                        // Jika barang berupa voucher elektrik
                        if($sql_brg->status_brg_dep == '1'){
                            $saldo_awal = $sql_brg_dep->harga;
                            $saldo_akhr = ($sql_brg_dep->kredit - $sql_brg_nom->nominal);
                            
                            $data_dep = array(
                                'tgl_simpan' => date('Y-m-d H:i'),
                                'id_produk'  => $sql_brg_nom->id_produk,
                                'no_nota'    => $nota,
                                'keterangan' => 'Penjualan '.$cart['name'],
                                'harga'      => $sql_brg_nom->harga,
                                'debet'      => $sql_brg_nom->nominal,
                                'kredit'     => $saldo_akhr,
                                'saldo'      => $saldo_akhr,
                            );
                            
                            crud::simpan('tbl_m_produk_deposit', $data_dep);
                        }else{
                            crud::update('tbl_m_produk','id', $sql_brg->id, $data_brg);
                            crud::update('tbl_m_produk_stok','id', $sql_gudang_stok->id, $data_stk);
                        }
                        
                        
                        /* Cek Diskon */
                        if($sql_disk->num_rows() > 0){
                            crud::update('tbl_trans_jual_diskon','id',$sql_disk->id, $data_diskon);
                        }else{
                            crud::simpan('tbl_trans_jual_diskon', $data_diskon);
                        }
                        
                        /* Catat log barang keluar ke tabel */
                        $data_penj_hist = array(
                            'tgl_simpan'   => $trans_jual['tgl_masuk'].' '.date('H:i'),
                            'tgl_masuk'    => $trans_jual['tgl_masuk'],
                            'id_pelanggan' => $trans_jual['id_pelanggan'],
                            'id_gudang'    => $sql_gudang->id,
                            'id_produk'    => $sql_brg->id,
                            'id_user'      => $this->ion_auth->user()->row()->id,
                            'id_penjualan' => $last_id,
                            'no_nota'      => $nota,
                            'kode'         => $cart['options']['kode'],
                            'keterangan'   => 'Penjualan '.$sql_kat->kategori.$nota.(!empty($sql_sales->kode) ? '/'.$sql_sales->kode : '').ucwords($sql_cust->nama).(!empty($sql_cust->nama_toko) ? ' - '.'['.$sql_cust->nama_toko.']' : ''),
                            'jml'          => (int)$cart['qty'],
                            'jml_satuan'   => (int)$cart['options']['jml_satuan'],
                            'satuan'       => $cart['options']['satuan'],
                            'nominal'      => (float)$cart['subtotal'],
                            'status'       => '4'
                        );
   
                        crud::simpan('tbl_m_produk_hist', $data_penj_hist);
                        /* -- END -- */
                     }
                     /* -- END -- */
                }

                $sql_penj_total = $this->db->where('id', $last_id)->get('tbl_trans_jual')->row();

                $jml_tot_nota   = $tot_gtotal_real;
                $jml_tot_diskon = $tot_diskon_real;
                $jml_tot_subtot = $this->cart->total();
                $jml_tot_dpp    = ($trans_jual['status_ppn'] == 1 ? ($this->cart->total() / 1.1) : $jml_tot_subtot);
                $jml_tot_ppn    = ($trans_jual['status_ppn'] == 1 ? $this->cart->total() - ($this->cart->total() / 1.1) : 0);
//                $jml_tot_ppn    = ($trans_jual['status_ppn'] == 1 ? ($pengaturan->jml_ppn / 100) * $this->cart->total() : 0);
                $jml_tot_gtotal = $this->cart->total();

                // Simpan perhitungan nota ke tabel penjualan
                $data_penj_total = array(
                    'no_nota'       => $nota,
                    'jml_total'     => floor((float)$jml_tot_nota),
                    'jml_diskon'    => floor((float)$jml_tot_diskon),
                    'jml_subtotal'  => floor((float)$jml_tot_dpp),
                    'ppn'           => ($trans_jual['status_ppn'] == 1 ? $pengaturan->jml_ppn : 0),
                    'jml_ppn'       => floor((float)$jml_tot_ppn),
                    'jml_gtotal'    => floor((float)$jml_tot_gtotal),
                );
                
                crud::update('tbl_trans_jual', 'id', $last_id, $data_penj_total);

                /* -- Hapus semua session -- */
                $this->session->unset_userdata('trans_jual');
                $this->cart->destroy();
                /* -- Hapus semua session -- */

                $this->session->set_flashdata('transaksi', '<div class="alert alert-success">Transaksi berhasil disimpan</div>');
                redirect(base_url('transaksi/'.(!empty($rute) ? $rute : 'trans_bayar_jual').'.php?id='.general::enkrip($last_id)));
//            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_nota_jual_proses_pen() {
        if (akses::aksesLogin() == TRUE) {
            $nota       = $this->input->post('no_nota');
            $jml_total  = $this->input->post('jml_total');
            $jml_ppn    = $this->input->post('jml_ppn');
            $act        = $this->input->post('act');
            $rute       = $this->input->post('route');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('no_nota', 'no_nota', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'no_nota' => form_error('no_nota'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url('transaksi/trans_jual.php'));
            } else {
                $no_nota        = general::dekrip($nota);
                $sql_penj       = $this->db->select('no_nota, status_ppn')->where('no_nota', $no_nota)->get('tbl_trans_jual_pen')->row();
                $sql_penj_total = $this->db->select('SUM(diskon) as jml_diskon, SUM(potongan) as jml_potongan, SUM(subtotal) as subtotal')->where('no_nota', $no_nota)->get('tbl_trans_jual_pen_det')->row();
                
                $jml_tot_nota   = $sql_penj_total->subtotal + $sql_penj_total->jml_diskon + $sql_penj_total->jml_potongan;
                $jml_tot_diskon = $sql_penj_total->jml_diskon;
                $jml_tot_subtot = $sql_penj_total->subtotal;
                $jml_tot_ppn    = ($sql_penj->status_ppn == 1 ? ($pengaturan->jml_ppn / 100) * $jml_tot_subtot : 0);
                $jml_tot_gtotal = $jml_tot_subtot + $jml_tot_ppn;
                
                // Simpan perhitungan nota ke tabel penjualan
                $data_penj_total = array(
                    'jml_total'     => ceil((float)$jml_tot_nota),
                    'jml_diskon'    => ceil((float)$jml_tot_diskon),
                    'jml_subtotal'  => ceil((float)$jml_tot_subtot),
                    'ppn'           => ($sql_penj->status_ppn == 1 ? $pengaturan->jml_ppn : 0),
                    'jml_ppn'       => ceil((float)$jml_tot_ppn),
                    'jml_gtotal'    => ceil((float)$jml_tot_gtotal),
                    'status_nota'   => '3',
                );                
                
                crud::update('tbl_trans_jual_pen', 'no_nota', $no_nota, $data_penj_total);
//                
//                /* -- Hapus semua session -- */
                $this->session->unset_userdata('trans_jual_pen');
//                /* -- Hapus semua session -- */
//                
                $this->session->set_flashdata('transaksi', '<div class="alert alert-success">Transaksi berhasil disimpan</div>');
                redirect(base_url('transaksi/'.(!empty($rute) ? $rute : 'trans_jual_pen_det').'.php?id='.$nota));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_nota_jual_proses_umum() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota      = $this->input->post('no_nota');
            $jml_total    = str_replace('.', '', $this->input->post('jml_total'));
            $jml_diskon   = str_replace('.', '', $this->input->post('jml_diskon'));
            $jml_diskon1  = str_replace('.', '', $this->input->post('jml_diskon1'));
            $jml_biaya    = str_replace('.', '', $this->input->post('jml_biaya'));
            $jml_ongkir   = str_replace('.', '', $this->input->post('jml_ongkir'));
            $jml_retur    = str_replace('.', '', $this->input->post('jml_retur'));
            $jml_subtotal = str_replace('.', '', $this->input->post('jml_subtotal'));
            $jml_ppn      = str_replace('.', '', $this->input->post('jml_ppn'));
            $jml_gtotal   = str_replace('.', '', $this->input->post('jml_gtotal'));
            $jml_bayar    = str_replace('.', '', $this->input->post('jml_bayar'));
            $jml_kembali  = str_replace('.', '', $this->input->post('jml_kembali'));
            $metode_byr   = $this->input->post('metode_bayar');
            $bank         = $this->input->post('bank');
            $no_kartu     = $this->input->post('no_kartu');
            $act          = $this->input->post('act');
            $rute         = $this->input->post('route');
            $cetak        = $this->input->post('cetak');
            $pengaturan   = $this->db->get('tbl_pengaturan')->row();
            $status_gd    = $this->ion_auth->user()->row()->status_gudang;

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('no_nota', 'no_nota', 'required');
            $this->form_validation->set_rules('jml_bayar', 'Jumlah Bayar', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'no_nota'   => form_error('no_nota'),
                    'jml_bayar' => form_error('jml_bayar'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url('transaksi/trans_jual_umum.php?id='.$no_nota.'#pembayaran'));
            } else {
                $trans_jual     = $this->session->userdata('trans_jual_umum');
                $trans_jual_det = $this->cart->contents();
                $sales          = $this->db->where('id', $trans_jual['id_sales'])->get('tbl_m_sales')->row();
                                
                // Kode Nomor Nota
                $sql_sales      = $this->db->where('id', $trans_jual['id_sales'])->get('tbl_m_sales')->row();
                $sql_kat        = $this->db->where('id', $trans_jual['id_kategori'])->get('tbl_m_kategori')->row();
                $sql_nota       = $this->db->select('COUNT(*) as jml_nota')->get('tbl_trans_jual')->row();
                $nomer_nota     = $sql_nota->jml_nota + 1;
//                $nota           = sprintf("%05s", $nomer_nota).sprintf("%02s", rand(1,64));
                
                $jml_tot        = $jml_total + $jml_diskon1;
                $jml_diskonnya  = $jml_diskon1 + $jml_diskon;
                $gtotal         = ($trans_jual['status_ppn'] == 1 ? $jml_gtotal : $jml_subtotal);
                $kembali        = $jml_bayar - $gtotal;
//                $jml_kembli     = $jml_bayar - $jml_gtotal;
//                $jml_kembali    = $jml_kembli; 
                
                // Cek jika jumlah bayar kurang dari jml_gtotal
                if($jml_bayar < $jml_gtotal){
                   $this->session->set_flashdata('transaksi', '<div class="alert alert-danger">Nominal pembayaran kurang dari tagihan</div>');
                   redirect(base_url('transaksi/'.(!empty($rute) ? $rute : 'trans_jual_umum').'.php?id='.general::enkrip($nota)));
                }else{
                   // Simpan penjualan ke tabel
                   $data_penj = array(
                       'id_app'        => $this->ion_auth->user()->row()->id_app,
                       'no_nota'       => $nomer_nota,
                       'kode_nota_dpn' => $sql_kat->kategori,
                       'kode_nota_blk' => $sql_sales->kode,
                       'tgl_simpan'    => $trans_jual['tgl_simpan'],
                       'tgl_masuk'     => $trans_jual['tgl_masuk'],
                       'tgl_keluar'    => $trans_jual['tgl_keluar'],
                       'tgl_bayar'     => $trans_jual['tgl_masuk'],
                       'id_pelanggan'  => $trans_jual['id_pelanggan'],
                       'id_sales'      => $trans_jual['id_sales'],
                       'id_user'       => $trans_jual['id_user'],
                       'ppn'           => ($trans_jual['status_ppn'] == 1 ? $pengaturan->jml_ppn : 0),
                       'jml_total'     => ceil((float)$jml_tot),
                       'jml_diskon'    => ceil((float)$jml_diskonnya),
                       'jml_biaya'     => ceil((float)$jml_biaya),
                       'jml_ongkir'    => ceil((float)$jml_ongkir),
                       'jml_retur'     => ceil((float)$jml_retur),
                       'jml_subtotal'  => ceil((float)$jml_subtotal),
                       'jml_ppn'       => ($trans_jual['status_ppn'] == 1 ? ceil((float)$jml_ppn) : 0),
                       'jml_gtotal'    => ($trans_jual['status_ppn'] == 1 ? ceil((float)$jml_gtotal) : ceil((float)$jml_subtotal)),
                       'jml_bayar'     => ceil((float)$jml_bayar),
                       'jml_kembali'   => ceil((float)$kembali),
                       'metode_bayar'  => $metode_byr,
                       'status_nota'   => '3',
                       'status_bayar'  => '1',
                       'status_ppn'    => (!empty($trans_jual['status_ppn']) ? $trans_jual['status_ppn'] : '0'),
                       'status_jurnal' => '0',
                       'status_grosir' => '0'
                   );
                                   
                   crud::simpan('tbl_trans_jual', $data_penj);
                   $last_id = crud::last_id();
                   $nota    = sprintf("%05s", $last_id).date('dm');
                   
                   $tot_gtotal_real = 0;
                   $tot_diskon_real = 0;
                   foreach ($trans_jual_det as $cart){
                        $sql_brg         = $this->db->where('kode', $cart['options']['kode'])->get('tbl_m_produk')->row();
                        $sql_brg_sat     = $this->db->where('id', $sql_brg->id_satuan)->get('tbl_m_satuan')->row();
                        $sql_sat         = $this->db->where('id', $cart['options']['id_satuan'])->get('tbl_m_satuan')->row();
                        $sql_disk        = $this->db->where('id_pelanggan', $trans_jual['id_pelanggan'])->where('kode', $cart['options']['kode'])->get('tbl_trans_jual_diskon');
                        
                        $sql_gudang      = $this->db->where('status', $status_gd)->get('tbl_m_gudang')->row(); // Cek gudang aktif dari gudang utama
                        $sql_gudang_stok = $this->db->where('id_gudang', $sql_gudang->id)->where('id_produk', $sql_brg->id)->get('tbl_m_produk_stok')->row(); // ambil data dari stok tsb
                        
                        $jml_akhir       = $sql_brg->jml - ($cart['options']['jml_satuan'] * $cart['options']['jml']);
                        $jml_akhir_stk   = $sql_gudang_stok->jml - ($cart['options']['jml_satuan'] * $cart['options']['jml']);
                        $jml_stok_klr    = 0 - ($cart['qty'] * $cart['options']['jml_satuan']);
                        
                        if($jml_akhir_stk < 0){
                            /* Hapus dulu dari database */
                            crud::delete('tbl_trans_jual', 'id', $last_id);
                        
                            $this->session->set_flashdata('transaksi', '<div class="alert alert-danger">Stok <b>'.$sql_brg->produk.'</b> tidak mencukupi !. Stok tersedia di sistem <b>'.$sql_brg->jml.' '.$sql_brg_sat->satuanTerkecil.'</b></div>');
                            redirect(base_url('transaksi/'.(!empty($rute) ? $rute : 'trans_jual_umum').'.php?id='.general::enkrip($last_id)));
                        }else{
                            $data_penj_det = array(
                                'id_penjualan'  => $last_id,
                                'no_nota'       => $nota,
                                'tgl_simpan'    => $trans_jual['tgl_simpan'],
                                'id_satuan'     => $cart['options']['id_satuan'],
                                'satuan'        => $cart['options']['satuan'],
                                'keterangan'    => $cart['options']['satuan_ket'],
                                'kode'          => $cart['options']['kode'],
                                'produk'        => $cart['name'],
                                'jml'           => (int)$cart['qty'],
                                'jml_satuan'    => (int)$cart['options']['jml_satuan'],
                                'harga'         => (float)$cart['options']['harga'],
                                'disk1'         => (float)$cart['options']['disk1'],
                                'disk2'         => (float)$cart['options']['disk2'],
                                'disk3'         => (float)$cart['options']['disk3'],
                                'diskon'        => (float)$cart['options']['diskon'],
                                'potongan'      => (float)$cart['options']['potongan'],
                                'subtotal'      => (float)$cart['options']['subtotal'],
                            );
                            
                            // Simpan sisa barang setelah di kurangi
                            $data_brg = array(
                                'tgl_modif' => date('Y-m-d H:i'),
                                'jml'       => (int)$jml_akhir
                            );
                            
                            // Simpan sisa stok dari gudang terkait setelah di kurangi
                            $data_stk = array(
                                'tgl_modif' => date('Y-m-d H:i'),
                                'jml'       => (int)$jml_akhir_stk
                            );
       
                            // Simpan diskon untuk penjualan ini
                            $data_diskon = array(
                                'tgl_simpan'  => date('Y-m-d H:i'),
                                'id_penjualan'=> $last_id,
                                'no_nota'     => $nota,
                                'kode'        => $cart['options']['kode'],
                                'id_pelanggan'=> $trans_jual['id_pelanggan'],
                                'disk1'       => $cart['options']['disk1'],
                                'disk2'       => $cart['options']['disk1'],
                                'disk3'       => $cart['options']['disk1'],
                            );
                            
                            // Simpan stok awal barang
                            $data_brg_log = array(
                                'tgl_simpan' => $trans_jual['tgl_masuk'].' '.date('H:i:s'),
                                'id_produk'  => $sql_brg->id,
                                'jml'        => $jml_stok_klr,
                                'jml_satuan' => $cart['options']['jml_satuan'],
                                'satuan'     => $sql_sat->satuanTerkecil,
                                'harga'      => $cart['options']['harga'],
                                'keterangan' => 'Penjualan '.$nota.'/'.$sql_sales->kode,
                            );
                            
                            crud::simpan('tbl_trans_jual_det', $data_penj_det);
                            crud::update('tbl_m_produk','id',$sql_brg->id,$data_brg);
                            crud::update('tbl_m_produk_stok','id', $sql_gudang_stok->id, $data_stk);
                            crud::simpan('tbl_m_produk_saldo', $data_brg_log);
                            
                            /* Cek Diskon */
                            if($sql_disk->num_rows() > 0){
                                crud::update('tbl_trans_jual_diskon','id',$sql_disk->id, $data_diskon);
                            }else{
                                crud::simpan('tbl_trans_jual_diskon', $data_diskon);
                            }
                            /* END Cek Diskon */
                            
                            /* Catat log barang keluar ke tabel */
                            $hist_nota = $nota.(!empty($sql_sales->kode) ? '/'.$sql_sales->kode : '').ucwords($sql_cust->nama).(!empty($sql_cust->nama_toko) ? ' - '.'['.$sql_cust->nama_toko.']' : '');
                            $data_penj_hist = array(
                                'tgl_simpan'   => $trans_jual['tgl_masuk'].' '.date('H:i:s'),
                                'tgl_masuk'    => $trans_jual['tgl_masuk'],
                                'id_pelanggan' => $trans_jual['id_pelanggan'],
                                'id_gudang'    => $sql_gudang->id,
                                'id_produk'    => $sql_brg->id,
                                'id_user'      => $this->ion_auth->user()->row()->id,
                                'id_penjualan' => $last_id,
                                'no_nota'      => $nota,
                                'kode'         => $cart['options']['kode'],
                                'keterangan'   => 'Penjualan '.$hist_nota,
                                'jml'          => (int)$cart['qty'],
                                'jml_satuan'   => (int)$cart['options']['jml_satuan'],
                                'satuan'       => $sql_sat->satuanTerkecil,
                                'nominal'      => (float)$cart['subtotal'],
                                'status'       => '4'
                            );
//
                            crud::simpan('tbl_m_produk_hist', $data_penj_hist);
                            /* -- END -- */
                        }
                   }
                        
                   // Simpan platform pembayaran
                   $jml_pembayaran = $jml_bayar - $jml_gtotal;
                   $data_platform = array(
                      'tgl_simpan'  => $trans_jual['tgl_masuk'].' '.date('H:i:s'),
                      'id_penjualan'=> $last_id,
                      'id_platform' => $metode_byr,
                      'no_nota'     => $nota,
                      'platform'    => (!empty($bank) ? $bank : '-'),
                      'keterangan'  => (!empty($no_kartu) ? $no_kartu : ''),
                      'nominal'     => (float)$jml_bayar,
                   );
                   
                   crud::simpan('tbl_trans_jual_plat',$data_platform);
                   /* --- END Simpan platform pembayaran -- */
                   
                  /* -- Simpan pemasukan ke tabel pemasukan -- */
                  $kode_pm   = general::no_nota('', 'tbl_akt_kas', 'kode', "WHERE tipe='masuk'");
                  $saldo_kas = $this->db->select('MAX(id) as id, MAX(saldo) as saldo')->get('tbl_akt_kas')->row();
                  $sql_trans = $this->db->select('kode_nota_dpn, no_nota, kode_nota_blk, jml_gtotal, jml_bayar, jml_kurang, jml_kembali')->where('id', $last_id)->get('tbl_trans_jual')->row();
                  $nominal   = $jml_bayar - $sql_trans->jml_kembali;
                  $tot_saldo = $saldo_kas->saldo + ($nominal);
          
                  $data_pemasukan = array(
                      'tgl_simpan' => $trans_jual['tgl_masuk'].' '.date('H:i:s'),
                      'id_user'    => $this->ion_auth->user()->row()->id,
                      'kode'       => $kode_pm,
                      'keterangan' => 'Penjualan '.$sql_trans->kode_nota_dpn.$sql_trans->no_nota.'/'.$sql_trans->kode_nota_blk,
                      'nominal'    => (float)$nominal,
                      'kredit'     => (float)$nominal,
                      'saldo'      => (float)$tot_saldo,
                      'status_kas' => ($metode_byr > 1 ? 'bank' : 'kas'),
                      'tipe'       => 'masuk',
                  );
  
                  crud::simpan('tbl_akt_kas', $data_pemasukan);
                  /* -- Simpan pemasukan ke tabel pemasukan -- */
                  
                  crud::update('tbl_trans_jual', 'id', $last_id, array('no_nota'=>$nota));
                  
                   /* -- Hapus semua session -- */
                   $this->session->unset_userdata('sess_cari_ret');
                   $this->session->unset_userdata('sess_retur_pot');
                   $this->session->unset_userdata('trans_jual_umum');
                   $this->cart->destroy();
                   /* -- Hapus semua session -- */
                   
                   $this->session->set_flashdata('transaksi', '<div class="alert alert-success">Transaksi berhasil disimpan</div>');
                   
                   if(!empty($cetak)){
                       redirect(base_url('transaksi/cetak_nota_termal.php?id='.general::enkrip($last_id).''));
                   }else{
                       redirect(base_url('transaksi/'.(!empty($rute) ? $rute : 'trans_jual_det').'.php?id='.general::enkrip($last_id).''));
                   }
                }
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_nota_jual_proses_umum_draft() {
        if (akses::aksesLogin() == TRUE) {
            $nota_id      = $this->input->get('id');
            $no_nota      = $this->input->post('no_nota');
            $jml_total    = str_replace('.', '', $this->input->get('jml_total'));
            $jml_retur    = str_replace('.', '', $this->input->post('jml_retur'));
            $jml_diskon   = str_replace('.', '', $this->input->post('jml_diskon'));
            $jml_diskon1  = str_replace('.', '', $this->input->post('jml_diskon1'));
            $jml_biaya    = str_replace('.', '', $this->input->post('jml_biaya'));
            $jml_ongkir   = str_replace('.', '', $this->input->post('jml_ongkir'));
            $jml_subtotal = str_replace('.', '', $this->input->get('jml_total'));
            $jml_ppn      = str_replace('.', '', $this->input->post('jml_ppn'));
            $jml_gtotal   = str_replace('.', '', $this->input->post('jml_gtotal'));
            $jml_bayar    = str_replace('.', '', $this->input->post('jml_bayar'));
            $jml_kembali  = str_replace('.', '', $this->input->post('jml_kembali'));
            $metode_byr   = $this->input->post('metode_bayar');
            $bank         = $this->input->post('bank');
            $no_kartu     = $this->input->post('no_kartu');
            $act          = $this->input->post('act');
            $rute         = $this->input->post('route');
            $cetak        = $this->input->post('cetak');
            $pengaturan   = $this->db->get('tbl_pengaturan')->row();
            $status_gd    = $this->ion_auth->user()->row()->status_gudang;

            if (empty($nota_id)) {
                // ID nota ga ada?, auto tendang sluur..
                redirect(base_url('transaksi/set_nota_batal.php?term=jual_umum&route=data_penj_list.php'));
            } else {
                $trans_jual     = $this->session->userdata('trans_jual_umum');
                $trans_jual_det = $this->cart->contents();
                $sales          = $this->db->where('id', $trans_jual['id_sales'])->get('tbl_m_sales')->row();
                                
                // Kode Nomor Nota
                $sql_sales      = $this->db->where('id', $trans_jual['id_sales'])->get('tbl_m_sales')->row();
                $sql_kat        = $this->db->where('id', $trans_jual['id_kategori'])->get('tbl_m_kategori')->row();
                $sql_nota       = $this->db->select('COUNT(*) as jml_nota')->get('tbl_trans_jual')->row();
                $nomer_nota     = $sql_nota->jml_nota + 1;
                
                $jml_tot        = $jml_total + $jml_diskon1;
                $jml_diskonnya  = $jml_diskon1 + $jml_diskon;
                $gtotal         = ($trans_jual['status_ppn'] == 1 ? $jml_gtotal : $jml_subtotal);
                $kembali        = $jml_bayar - $gtotal;
                
                // Cek jika jumlah bayar kurang dari jml_gtotal
                if($jml_bayar < $jml_gtotal){
                   $this->session->set_flashdata('transaksi', '<div class="alert alert-danger">Nominal pembayaran kurang dari tagihan</div>');
                   redirect(base_url('transaksi/'.(!empty($rute) ? $rute : 'trans_jual_umum').'.php?id='.general::enkrip($nota)));
                }else{
                   // Simpan penjualan ke tabel
                   $data_penj = array(
                       'id_app'        => $this->ion_auth->user()->row()->id_app,
                       'no_nota'       => $nomer_nota,
                       'kode_nota_dpn' => $sql_kat->kategori,
                       'kode_nota_blk' => $sql_sales->kode,
                       'tgl_simpan'    => $trans_jual['tgl_simpan'],
                       'tgl_masuk'     => $trans_jual['tgl_masuk'],
                       'tgl_keluar'    => $trans_jual['tgl_keluar'],
                       'tgl_bayar'     => $trans_jual['tgl_masuk'],
                       'id_pelanggan'  => $trans_jual['id_pelanggan'],
                       'id_sales'      => $trans_jual['id_sales'],
                       'id_user'       => $trans_jual['id_user'],
                       'ppn'           => ($trans_jual['status_ppn'] == 1 ? $pengaturan->jml_ppn : 0),
                       'jml_total'     => ceil((float)$jml_tot),
                       'jml_diskon'    => ceil((float)$jml_diskonnya),
                       'jml_biaya'     => ceil((float)$jml_biaya),
                       'jml_ongkir'    => ceil((float)$jml_ongkir),
                       'jml_retur'     => ceil((float)$jml_retur),
                       'jml_subtotal'  => ceil((float)$jml_subtotal),
                       'jml_ppn'       => ($trans_jual['status_ppn'] == 1 ? ceil((float)$jml_ppn) : 0),
                       'jml_gtotal'    => ($trans_jual['status_ppn'] == 1 ? ceil((float)$jml_gtotal) : ceil((float)$jml_subtotal)),
                       'jml_bayar'     => ceil((float)$jml_bayar),
                       'jml_kembali'   => ceil((float)$kembali),
                       'jml_retur'     => '0',
                       'metode_bayar'  => $metode_byr,
                       'status_nota'   => '4',
                       'status_bayar'  => '1',
                       'status_ppn'    => (!empty($trans_jual['status_ppn']) ? $trans_jual['status_ppn'] : '0'),
                       'status_jurnal' => '0',
                       'status_grosir' => '0',
                   );
                                   
                   crud::simpan('tbl_trans_jual', $data_penj);
                   $last_id = crud::last_id();
                   $nota    = sprintf("%05s", $last_id).date('dm');
                   
                   $tot_gtotal_real = 0;
                   $tot_diskon_real = 0;
                   foreach ($trans_jual_det as $cart){
                        $sql_brg         = $this->db->where('kode', $cart['options']['kode'])->get('tbl_m_produk')->row();
                        $sql_brg_sat     = $this->db->where('id', $sql_brg->id_satuan)->get('tbl_m_satuan')->row();
                        $sql_sat         = $this->db->where('id', $cart['options']['id_satuan'])->get('tbl_m_satuan')->row();
                        $sql_disk        = $this->db->where('id_pelanggan', $trans_jual['id_pelanggan'])->where('kode', $cart['options']['kode'])->get('tbl_trans_jual_diskon');
                        
                        $sql_gudang      = $this->db->where('status', $status_gd)->get('tbl_m_gudang')->row(); // Cek gudang aktif dari gudang utama
                        $sql_gudang_stok = $this->db->where('id_gudang', $sql_gudang->id)->where('id_produk', $sql_brg->id)->get('tbl_m_produk_stok')->row(); // ambil data dari stok tsb
                        
                        $jml_akhir       = $sql_brg->jml - ($cart['qty'] * $cart['options']['jml_satuan']);
                        $jml_akhir_stk   = $sql_gudang_stok->jml - ($cart['options']['jml_satuan'] * $cart['options']['jml']);
                        $jml_stok_klr    = 0 - ($cart['qty'] * $cart['options']['jml_satuan']);
                        
                        if($jml_akhir_s < 0){
                            /* Hapus dulu dari database */
                            crud::delete('tbl_trans_jual', 'id', $last_id);
                        
                            $this->session->set_flashdata('transaksi', '<div class="alert alert-danger">Stok <b>'.$sql_brg->produk.'</b> tidak mencukupi !. Stok tersedia di sistem <b>'.$sql_brg->jml.' '.$sql_brg_sat->satuanTerkecil.'</b></div>');
                            redirect(base_url('transaksi/'.(!empty($rute) ? $rute : 'trans_jual_umum').'.php?id='.general::enkrip($last_id)));
                        }else{
                            $data_penj_det = array(
                                'id_penjualan'  => $last_id,
                                'no_nota'       => $nota,
                                'tgl_simpan'    => $trans_jual['tgl_simpan'],
                                'id_satuan'     => $cart['options']['id_satuan'],
                                'satuan'        => $cart['options']['satuan'],
                                'keterangan'    => $cart['options']['satuan_ket'],
                                'kode'          => $cart['options']['kode'],
                                'produk'        => $cart['name'],
                                'jml'           => (int)$cart['qty'],
                                'jml_satuan'    => (int)$cart['options']['jml_satuan'],
                                'harga'         => (float)$cart['options']['harga'],
                                'disk1'         => (float)$cart['options']['disk1'],
                                'disk2'         => (float)$cart['options']['disk2'],
                                'disk3'         => (float)$cart['options']['disk3'],
                                'diskon'        => (float)$cart['options']['diskon'],
                                'potongan'      => (float)$cart['options']['potongan'],
                                'subtotal'      => (float)$cart['options']['subtotal'],
                            );
                            
                            // Simpan sisa barang setelah di kurangi
                            $data_brg = array(
                                'tgl_modif' => date('Y-m-d H:i'),
                                'jml'       => (int)$jml_akhir
                            );
                            
                            // Simpan sisa stok dari gudang terkait setelah di kurangi
                            $data_stk = array(
                                'tgl_modif' => date('Y-m-d H:i'),
                                'jml'       => (int)$jml_akhir_stk
                            );
       
                            // Simpan diskon untuk penjualan ini
                            $data_diskon = array(
                                'tgl_simpan'  => date('Y-m-d H:i'),
                                'id_penjualan'=> $last_id,
                                'no_nota'     => $nota,
                                'kode'        => $cart['options']['kode'],
                                'id_pelanggan'=> $trans_jual['id_pelanggan'],
                                'disk1'       => $cart['options']['disk1'],
                                'disk2'       => $cart['options']['disk1'],
                                'disk3'       => $cart['options']['disk1'],
                            );
                            
                            // Simpan stok awal barang
                            $data_brg_log = array(
                                'tgl_simpan' => $trans_jual['tgl_masuk'].' '.date('H:i:s'),
                                'id_produk'  => $sql_brg->id,
                                'jml'        => $jml_stok_klr,
                                'jml_satuan' => $cart['options']['jml_satuan'],
                                'satuan'     => $sql_sat->satuanTerkecil,
                                'harga'      => $cart['options']['harga'],
                                'keterangan' => 'Penjualan '.$nota.'/'.$sql_sales->kode,
                            );
                            
                            crud::simpan('tbl_trans_jual_det', $data_penj_det);
                            crud::update('tbl_m_produk','id',$sql_brg->id,$data_brg);
                            crud::update('tbl_m_produk_stok','id', $sql_gudang_stok->id, $data_stk);
                            crud::simpan('tbl_m_produk_saldo', $data_brg_log);
                            
                            /* Cek Diskon */
                            if($sql_disk->num_rows() > 0){
                                crud::update('tbl_trans_jual_diskon','id',$sql_disk->id, $data_diskon);
                            }else{
                                crud::simpan('tbl_trans_jual_diskon', $data_diskon);
                            }
                            /* END Cek Diskon */
                            
                            /* Catat log barang keluar ke tabel */
                            $hist_nota = $nota.(!empty($sql_sales->kode) ? '/'.$sql_sales->kode : '').ucwords($sql_cust->nama).(!empty($sql_cust->nama_toko) ? ' - '.'['.$sql_cust->nama_toko.']' : '');
                            $data_penj_hist = array(
                                'tgl_simpan'   => $trans_jual['tgl_masuk'].' '.date('H:i:s'),
                                'tgl_masuk'    => $trans_jual['tgl_masuk'],
                                'id_pelanggan' => $trans_jual['id_pelanggan'],
                                'id_gudang'    => $sql_gudang->id,
                                'id_produk'    => $sql_brg->id,
                                'id_user'      => $this->ion_auth->user()->row()->id,
                                'id_penjualan' => $last_id,
                                'no_nota'      => $nota,
                                'kode'         => $cart['options']['kode'],
                                'keterangan'   => 'Penjualan '.$hist_nota,
                                'jml'          => (int)$cart['qty'],
                                'jml_satuan'   => (int)$cart['options']['jml_satuan'],
                                'satuan'       => $sql_sat->satuanTerkecil,
                                'nominal'      => (float)$cart['subtotal'],
                                'status'       => '4'
                            );
//
                            crud::simpan('tbl_m_produk_hist', $data_penj_hist);
                            /* -- END -- */
                        }
                   }
                   
                  
                   crud::update('tbl_trans_jual', 'id', $last_id, array('no_nota'=>$nota));
                  
                   /* -- Hapus semua session -- */
                   $this->cart->destroy();
                   $this->session->unset_userdata('sess_cari_ret');
                   $this->session->unset_userdata('sess_retur_pot');
                   $this->session->unset_userdata('trans_jual_umum');
                   /* -- Hapus semua session -- */
                   
                   $this->session->set_flashdata('transaksi', '<div class="alert alert-success">Transaksi berhasil disimpan</div>');
                   redirect(base_url('transaksi/'.(!empty($rute) ? $rute : 'set_nota_jual_umum').'.php?id='.general::enkrip($last_id).''));
                }
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_nota_jual_proses_upd() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota    = $this->input->post('no_nota');
            $jml_ppn    = $this->input->post('jml_ppn');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('no_nota', 'no_nota', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'no_nota' => form_error('no_nota'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url('transaksi/trans_jual.php'));
            } else {
                $trans_jual     = $this->db->where('id', general::dekrip($no_nota))->get('tbl_trans_jual')->row();
                $trans_diskon   = $this->db->where('id_pelanggan', $trans_jual->id_pelanggan)->where('id_kategori', $trans_jual->id_kategori)->get('tbl_m_pelanggan_diskon')->row();
                $trans_jual_det = $this->db->select('SUM(diskon) as diskon, SUM(subtotal) as subtotal')->where('id_penjualan', general::dekrip($no_nota))->get('tbl_trans_jual_det')->row();
                $trans_jual_det2= $this->db->select('*')->where('id_penjualan', general::dekrip($no_nota))->get('tbl_trans_jual_det')->result();
                
                $jml_total      = $trans_jual_det->diskon + $trans_jual_det->subtotal;
                $jml_diskon     = $trans_jual_det->diskon;
                $jml_subtotal   = $jml_total - $jml_diskon;
                $jml_ppn        = ($trans_jual->status_ppn == 1 ? ($pengaturan->jml_ppn / 100) * $trans_jual_det->subtotal : 0);
                $jml_gtotal     = $trans_jual_det->subtotal + $jml_ppn;
                                                
                // Simpan penjualan ke tabel                
                if($trans_jual->jml_gtotal != $jml_gtotal){
                    $jml_kurang = $jml_gtotal - $trans_jual->jml_bayar;
                    
                    $data_penj = array(
                        'jml_total'    => ceil((float)$jml_total),
                        'jml_diskon'   => ceil((float)$jml_diskon),
                        'jml_subtotal' => ceil((float)$jml_subtotal),
                        'ppn'          => ($trans_jual->status_ppn == 1 ? $pengaturan->jml_ppn : 0),
                        'jml_ppn'      => ceil((float)$jml_ppn),
                        'jml_gtotal'   => ceil((float)$jml_gtotal),
                        'jml_kurang'   => ($trans_jual->jml_bayar == '0' ? '0' : $jml_kurang),
                        'status_bayar' => ($trans_jual->jml_bayar == 0 ? '0' : '2'),
                        'status_nota'  => (!empty($trans_jual->jml_bayar) ? '2' : '0'),
                    );
                }else{                    
                    $data_penj = array(
                        'jml_total'    => ceil((float)$jml_total),
                        'jml_diskon'   => ceil((float)$jml_diskon),
                        'jml_subtotal' => ceil((float)$jml_subtotal),
                        'ppn'          => ($trans_jual->status_ppn == 1 ? $pengaturan->jml_ppn : 0),
                        'jml_ppn'      => ceil((float)$jml_ppn),
                        'jml_gtotal'   => ceil((float)$jml_gtotal),
                    );                    
                }
                
                crud::update('tbl_trans_jual', 'id', general::dekrip($no_nota), $data_penj);
                
                /* -- Hapus semua session -- */
                $this->session->unset_userdata('trans_jual_upd');
                /* -- Hapus semua session -- */
                
                $this->session->set_flashdata('transaksi', '<div class="alert alert-success">Transaksi berhasil disimpan</div>');
                redirect(base_url('transaksi/trans_jual_det.php?id='.$no_nota));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_nota_jual_edit_item() {
        if (akses::aksesLogin() == TRUE) {
            $id         = $this->input->post('id');
            $id_prod    = $this->input->post('id_produk');
            $id_satuan  = $this->input->post('id_satuan');
            $id_penj_det= $this->input->post('aid');
            $edit_jml   = $this->input->post('edit_jml');
            $edit_sat   = $this->input->post('edit_satuan');
            $edit_hrg   = str_replace('.', '', $this->input->post('edit_harga'));
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id', 'no _nota', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'no_nota' => form_error('no_nota'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url('transaksi/trans_jual_edit.php?id='.$id));
            } else {
                $sql_satuan   = $this->db->where('id', general::dekrip($id_satuan))->get('tbl_m_satuan')->row();
                $sql_penj_det = $this->db->where('id', general::dekrip($id_penj_det))->get('tbl_trans_jual_det')->row();
                $sql_brg      = $this->db->where('id', general::dekrip($id_prod))->get('tbl_m_produk')->row();
                $harga_j      = ($edit_sat == $sql_satuan->satuanBesar ? $edit_hrg : $edit_hrg / $sql_satuan->jml);
                $subtotal     = $harga_j * $edit_jml;
                $jml_satuan   = ($edit_sat == $sql_satuan->satuanBesar ? $sql_satuan->jml : 1);
                $jml_real     = ($edit_sat == $sql_satuan->satuanBesar ? $sql_satuan->jml * $edit_jml : $edit_jml);
                $jml_sblmnx   = ($sql_penj_det->jml * $sql_penj_det->jml_satuan);
                $jml_akhir    = $sql_brg->jml + $jml_sblmnx;
               
                if($sql_brg->jml < $jml_real){
                    $this->session->set_flashdata('transaksi', '<div class="alert alert-danger">Item "<b>'.$sql_brg->produk.'</b>", Jumlah tidak mencukupi !!</div>');
                    redirect(base_url('transaksi/trans_jual_edit.php?id='.$id));
                }else{
                    // Simpan penjualan ke tabel
                    $data_penj = array(
                        'satuan'        => $edit_sat,
                        'keterangan'    => ($edit_sat == $sql_satuan->satuanBesar ? ' ('.$sql_satuan->jml.' '.$sql_satuan->satuanTerkecil.')' : ''),
                        'harga'         => ceil((float)$edit_hrg),
                        'jml'           => ceil((float)$edit_jml),
                        'jml_satuan'    => $jml_satuan,
                        'subtotal'      => ceil((float)$subtotal),
                    );
                    
                    // Kembalikan dulu stok sebelumnya aberdasarkan transaksi sebelumnya
                    $data_brg = array(
                        'tgl_modif' => date('Y-m-d H:i:s'),
                        'jml'       => $jml_akhir
                    );
                    
                    crud::update('tbl_m_produk', 'id', $sql_brg->id, $data_brg);
                    crud::update('tbl_trans_jual_det', 'id', general::dekrip($id_penj_det), $data_penj);
                    /* --- */
                
                    // Ambil data transaksi terbaru
                    $sql_brg2      = $this->db->where('id', general::dekrip($id_prod))->get('tbl_m_produk')->row();
                    $sql_penj_det2 = $this->db->where('id', general::dekrip($id_penj_det))->get('tbl_trans_jual_det')->row();
                    $jml_akhir2    = $sql_brg2->jml - ($sql_penj_det2->jml * $sql_penj_det2->jml_satuan);
                    
                    // Kurangkan data stok dengan data transaksi terbaru
                    $data_brg2 = array(
                        'tgl_modif' => date('Y-m-d H:i:s'),
                        'jml'       => $jml_akhir2
                    );
                    crud::update('tbl_m_produk', 'id', $sql_brg->id, $data_brg2);
                }
                
                $this->session->set_flashdata('transaksi', '<div class="alert alert-success">Data berhasil di ubah !!!</div>');
                redirect(base_url('transaksi/trans_jual_edit.php?id='.$id));
                
                echo '<pre>';
                print_r($data_penj);
                echo '</pre>';
                echo '<pre>';
                print_r($data_brg);
                echo '</pre>';
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_nota_beli_proses() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota    = $this->input->post('no_nota');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('no_nota', 'no_nota', 'required');

//            if ($this->form_validation->run() == FALSE) {
//                $msg_error = array(
//                    'no_nota' => form_error('no_nota'),
//                );
//
//                $this->session->set_flashdata('form_error', $msg_error);
//                
//                redirect(base_url('transaksi/trans_beli.php'));
//            } else {
                $trans_beli     = $this->session->userdata('trans_beli');
                $trans_beli_det = $this->cart->contents();
                $supplier       = $this->db->where('id', $trans_beli['id_supplier'])->get('tbl_m_supplier')->row();
                
                // Simpan pembelian ke tabel
                $data_pemb = array(
                    'no_nota'           => $trans_beli['no_nota'],
                    'tgl_simpan'        => $trans_beli['tgl_simpan'],
                    'tgl_masuk'         => $trans_beli['tgl_masuk'],
                    'tgl_keluar'        => $trans_beli['tgl_keluar'],
                    'id_supplier'       => $trans_beli['id_supplier'],
                    'id_user'           => $trans_beli['id_user'],
                    'status_nota'       => '1',
                    'status_bayar'      => '0',
                    'status_penerimaan' => '0',
                    'status_ppn'        => $trans_beli['status_ppn'],
                );

                crud::simpan('tbl_trans_beli', $data_pemb);
                $last_id  = crud::last_id();
                $sql_pemb = $this->db->select_max('id')->get('tbl_trans_beli')->row();
                
                $jml_total    = 0;
                $jml_diskon   = 0;
                $jml_potongan = 0;
                $jml_subtotal = 0;
                foreach ($trans_beli_det as $cart){
                     $sql_brg      = $this->db->where('kode', $cart['options']['kode'])->get('tbl_m_produk')->row();
                     $sql_brg_dep  = $this->db->where('id_produk', $sql_brg->id)->order_by('id', 'DESC')->get('tbl_m_produk_deposit')->row();
                     $total        = $cart['options']['harga'] * $cart['qty'] * $cart['options']['jml_satuan'];
//                     $diskon       = $total - ($cart['options']['potongan'] + $cart['options']['subtotal']);
                     $jml_akhir    = $sql_brg->jml + ($cart['qty'] * $cart['options']['jml_satuan']);
                     $jml_total    = $jml_total + $total;
                     $jml_potongan = $jml_potongan + $cart['options']['potongan'];
                     $jml_subtotal = $jml_subtotal + $cart['options']['subtotal'];
                     $jml_diskon   = $jml_diskon + $diskon;
                     $hrg_pcs      = $cart['options']['subtotal'] / ($cart['options']['jml'] * $cart['options']['jml_satuan']);
                     $hrg_ppn      = ($trans_beli['status_ppn'] == 1 ? ($pengaturan->jml_ppn / 100) * $hrg_pcs : 0);
                     $hrg_pcs_akhir= $hrg_pcs + $hrg_ppn;
                     $subtotal     = $hrg_pcs_akhir * $cart['options']['jml'];
                     
                     $data_pemb_det = array(
                         'id_pembelian' => $last_id,
                         'id_produk'    => $sql_brg->id,
                         'id_satuan'    => $sql_brg->id_satuan,
                         'no_nota'      => $trans_beli['no_nota'],
                         'tgl_simpan'   => $trans_beli['tgl_simpan'],
                         'kode'         => $cart['options']['kode'],
                         'produk'       => $cart['name'],
                         'jml'          => $cart['options']['jml'],
                         'jml_satuan'   => (int)$cart['options']['jml_satuan'],
                         'satuan'       => $cart['options']['satuan'],
                         'keterangan'   => $cart['options']['satuan_ket'],
                         'harga'        => $cart['price'],
                         'disk1'        => ($cart['options']['disk1']),
                         'disk2'        => ($cart['options']['disk2']),
                         'disk3'        => ($cart['options']['disk3']),
                         'diskon'       => ($diskon),
                         'potongan'     => ceil($cart['options']['potongan']),
                         'subtotal'     => $cart['options']['subtotal'],
                     );
                     
                     // Simpan stok barang
                     $data_brg = array(
                        'tgl_modif'         => date('Y-m-d H:i:s'),
                        'harga_beli'        => $hrg_pcs_akhir,
                        'harga_beli_ppn'    => $hrg_ppn,
                     );
                     
                     // Log History Harga
                     $data_brg_hist = array(
                        'tgl_simpan'         => date('Y-m-d H:i:s'),
                        'id_produk'          => $sql_brg->id,
                        'id_user'            => $trans_beli['id_user'],
                        'id_pembelian'       => $last_id,
                        'nom_awal'           => $sql_brg->harga_beli,
                        'nom_akhir'          => $hrg_pcs_akhir,
                        'keterangan'         => 'Pembelian '.$trans_beli['no_nota'],
                        'status'             => '1',
                     );
                                          
                     crud::simpan('tbl_trans_beli_det', $data_pemb_det);
//                     crud::simpan('tbl_m_produk_hist_harga', $data_brg_hist);
                     crud::update('tbl_m_produk', 'id', $cart['options']['id_barang'], $data_brg);
                     
                     // Simpan nominal deposit ke tabel
                     if($sql_brg->status_brg_dep == '1'){
                         $saldo_awal = $sql_brg_dep->harga;
                         $saldo_akhr = ($sql_brg_dep->kredit + $cart['options']['jml_deposit']);
                         
                         $data_dep = array(
                             'tgl_simpan' => date('Y-m-d H:i'),
                             'id_produk'  => $sql_brg->id,
                             'no_nota'    => $trans_beli['no_nota'],
                             'keterangan' => 'Penambahan Deposit '.$cart['name'],
                             'harga'      => $cart['price'],
                             'kredit'     => $saldo_akhr,
                             'saldo'      => $saldo_akhr,
                         );

                         crud::simpan('tbl_m_produk_deposit', $data_dep); 
                     }
                     
                     /* Catat log barang keluar ke tabel ini */
//                     $data_pemb_hist = array(
//                         'tgl_simpan'   => date('Y-m-d H:i'),
//                         'id_supplier'  => $trans_beli['id_supplier'],
//                         'id_produk'    => $sql_brg->id,
//                         'id_user'      => $this->ion_auth->user()->row()->id,
//                         'id_pembelian' => $sql_pemb->id,
//                         'no_nota'      => $trans_beli['no_nota'],
//                         'kode'         => $cart['options']['kode'],
//                         'keterangan'   => 'Pembelian '.$trans_beli['no_nota'],
//                         'jml'          => (int)$cart['qty'],
//                         'jml_satuan'   => (int)$cart['options']['jml_satuan'],
//                         'satuan'       => $cart['options']['satuan'],
//                         'nominal'      => (float)$cart['subtotal'],
//                         'status'       => '1'
//                     );
//                     crud::simpan('tbl_m_produk_hist', $data_pemb_hist);
                     /* -- END -- */
                }
                
                $ppn            = ($trans_beli['status_ppn'] == 1 ? $pengaturan->jml_ppn : 0);
                $jml_ppn        = ($trans_beli['status_ppn'] == 1 ? ($pengaturan->jml_ppn / 100) * $jml_subtotal : 0);
                $jml_gtotal     = $jml_subtotal + $jml_ppn;
                
                $data_pemb_update = array(
                    'jml_total'     => (float)$jml_total,
                    'jml_diskon'    => (float)$jml_diskon,
                    'jml_potongan'  => (float)$jml_potongan,
                    'jml_subtotal'  => (float)$jml_subtotal,
                    'ppn'           => (float)$ppn,
                    'jml_ppn'       => (float)$jml_ppn,
                    'jml_gtotal'    => (float)$jml_gtotal,
                    'status_retur'  => '0',
                );
                
                crud::update('tbl_trans_beli','id',$last_id, $data_pemb_update);
                
                /* -- Hapus semua session -- */
                $this->session->unset_userdata('trans_beli');
                $this->cart->destroy();
                /* -- Hapus semua session -- */
                
                $this->session->set_flashdata('transaksi', '<div class="alert alert-success">Transaksi berhasil disimpan</div>');
                redirect(base_url('transaksi/trans_bayar_beli.php?id='.general::enkrip($last_id)));
//            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_nota_beli_proses_po() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota    = $this->input->post('no_nota');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('no_nota', 'no_nota', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'no_nota' => form_error('no_nota'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url('transaksi/trans_beli_po.php?id='.$no_nota));
            } else {
                $data_pemb_update = array(
                    'status_nota'  => '3',
                );
                
                crud::update('tbl_trans_beli_po','id', general::dekrip($no_nota), $data_pemb_update);

                /* -- Hapus semua session -- */
                $this->session->unset_userdata('trans_beli_po');
                /* -- Hapus semua session -- */
                
                $this->session->set_flashdata('transaksi', '<div class="alert alert-success">Transaksi berhasil disimpan</div>');
                redirect(base_url('transaksi/trans_beli_po_det.php?id='.$no_nota));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_nota_beli_proses_po_upd() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota    = $this->input->post('no_nota');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('no_nota', 'no_nota', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'no_nota' => form_error('no_nota'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url('transaksi/trans_beli_po.php?id='.$no_nota));
            } else {
                $data_pemb_update = array(
                    'status_nota'  => '3',
                );
                
                crud::update('tbl_trans_beli_po','id', general::dekrip($no_nota), $data_pemb_update);

                /* -- Hapus semua session -- */
                $this->session->unset_userdata('trans_beli_po_upd');
                /* -- Hapus semua session -- */
                
                $this->session->set_flashdata('transaksi', '<div class="alert alert-success">Transaksi berhasil disimpan</div>');
                redirect(base_url('transaksi/trans_beli_po_det.php?id='.$no_nota));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_nota_beli_proses_po_st() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota    = $this->input->get('id');
            
            $sql_po     = $this->db->where('id', general::dekrip($no_nota))->get('tbl_trans_beli_po');
            $sql_po_det = $this->db->where('id_pembelian', general::dekrip($no_nota))->get('tbl_trans_beli_po_det')->result();

            if ($sql_po->num_rows() == 0) {                
                redirect(base_url('transaksi/data_po_list.php'));
            } else {
                $po = $sql_po->row();
                $data_pemb = array(
//                    'id_po'             => $po->id,
                    'no_nota'           => $po->no_nota,
                    'tgl_simpan'        => date('Y-m-d H:i:s'),
                    'tgl_modif'         => date('Y-m-d H:i:s'),
                    'tgl_masuk'         => $po->tgl_masuk,
                    'tgl_keluar'        => '0000-00-00',
                    'id_supplier'       => $po->id_supplier,
                    'id_user'           => $po->id_user,
                    'status_nota'       => '0',
                    'status_bayar'      => '0',
                    'status_penerimaan' => '0',
                    'status_ppn'        => '0',
                    'status_retur'      => '0',
                );
                
                crud::simpan('tbl_trans_beli', $data_pemb);
                $last_id  = crud::last_id();
                
                $jml_total    = 0;
                $jml_diskon   = 0;
                $jml_potongan = 0;
                $jml_subtotal = 0;
                foreach ($sql_po_det as $cart){                
                     $data_pemb_det = array(
                         'id_pembelian' => $last_id,
                         'id_produk'    => $cart->id_produk,
                         'id_satuan'    => $cart->id_satuan,
                         'no_nota'      => $po->no_nota,
                         'tgl_simpan'   => date('Y-m-d H:i:s'),
                         'kode'         => $cart->kode,
                         'produk'       => $cart->produk,
                         'jml'          => $cart->jml,
                         'jml_satuan'   => (int)$cart->jml_satuan,
                         'satuan'       => $cart->satuan,
                         'keterangan'   => $cart->keterangan,
                         'harga'        => '0',
                         'disk1'        => '0',
                         'disk2'        => '0',
                         'disk3'        => '0',
                         'diskon'       => '0',
                         'potongan'     => '0',
                         'subtotal'     => '0',
                     );
                     
                     /* Catat log barang keluar ke tabel ini */
                     $data_pemb_hist = array(
                         'tgl_simpan'   => date('Y-m-d H:i'),
                         'id_supplier'  => $po->id_supplier,
                         'id_produk'    => $cart->id_produk,
                         'id_user'      => $po->id_user,
                         'id_pembelian' => $last_id,
                         'no_nota'      => $po->no_nota,
                         'kode'         => $cart->kode,
                         'keterangan'   => 'Pembelian '.$po->no_nota.' dari <i>Purchase Order</i>',
                         'jml'          => (int)$cart->jml,
                         'jml_satuan'   => (int)$cart->jml_satuan,
                         'satuan'       => $cart->satuan,
                         'nominal'      => '0',
                         'status'       => '1'
                     );
                     
                     crud::simpan('tbl_m_produk_hist', $data_pemb_hist);                     
                     crud::simpan('tbl_trans_beli_det', $data_pemb_det);
                     /* -- END -- */
                }
                
                $this->session->set_flashdata('transaksi', '<div class="alert alert-success">Transaksi berhasil diproses ke pembelian</div>');
                redirect(base_url('transaksi/trans_beli_edit.php?id='.general::enkrip($last_id)));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_nota_beli_proses_upd() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota    = $this->input->post('no_nota');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('no_nota', 'no_nota', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'no_nota' => form_error('no_nota'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url('transaksi/trans_beli_edit.php'));
            } else {
                $sql_beli     = $this->db->where('id', general::dekrip($no_nota))->get('tbl_trans_beli')->row();
                $sql_beli_det = $this->db->where('id_pembelian', general::dekrip($no_nota))->get('tbl_trans_beli_det')->result();
                $sql_beli_sum = $this->db->select('SUM(diskon) as diskon, SUM(potongan) as potongan, SUM(subtotal) as subtotal')->where('id_pembelian', general::dekrip($no_nota))->get('tbl_trans_beli_det')->row();
                $jml_total    = $sql_beli_sum->subtotal + $sql_beli_sum->potongan + $sql_beli_sum->diskon;
                $jml_potongan = $sql_beli_sum->potongan;
                $jml_diskon   = $sql_beli_sum->diskon;
                $jml_ppn      = ($sql_beli->status_ppn == 1 ? ($jml_total - $jml_potongan - $jml_diskon) * ($pengaturan->jml_ppn / 100) : 0);
                $jml_gtotal   = $sql_beli_sum->subtotal + $jml_ppn;
                
                
                
                // Simpan penjualan ke tabel
                $data_penj = array(
                    'jml_total'    => ceil((float)$jml_total),
                    'jml_diskon'   => ceil((float)$jml_diskon),
                    'jml_potongan' => ceil((float)$jml_potongan),
                    'jml_subtotal' => ceil((float)$sql_beli_sum->subtotal),
                    'ppn'          => ($sql_beli->status_ppn == 1 ? $pengaturan->jml_ppn : 0),
                    'jml_ppn'      => ceil((float)$jml_ppn),
                    'jml_gtotal'   => ceil((float)$jml_gtotal),
                    'status_penerimaan' => ($sql_beli_sum->subtotal != $sql_beli->jml_subtotal ? '0' : $sql_beli->status_penerimaan)
                );
                                
                crud::update('tbl_trans_beli', 'id', general::dekrip($no_nota), $data_penj);
                
                foreach ($sql_beli_det as $sql_det){
                    $jml_pcs    = $sql_det->jml_satuan * $sql_det->jml;                   
                    $hrg_pcs    = $sql_det->subtotal / $jml_pcs;
                    $hrg_ppn    = ($sql_beli->status_ppn == 1 ? ($pengaturan->jml_ppn / 100) * $hrg_pcs : 0);
                    $harga_pcs  = $hrg_pcs + $hrg_ppn;
                    $subtotal   = $hrg_pcs + $hrg_ppn;
                    
                    $sql_brg      = $this->db->where('id', $sql_det->id_produk)->get('tbl_m_produk')->row();
                    $sql_cek_hist = $this->db->where('id_pembelian', $sql_det->id_pembelian)->where('id_produk', $sql_brg->id)->get('tbl_m_produk_hist_harga')->row();
                    
                    $data_produk = array(
                        'tgl_modif'         => date('Y-m-d H:i:s'),
                        'harga_beli'        => $harga_pcs,
                        'harga_beli_ppn'    => $hrg_ppn,
                    );
                    
                    $data_trans_beli_det = array(
                        'tgl_simpan' => date('Y-m-d H:i:s'),
                        'no_nota'    => $sql_beli->no_nota,
//                        'subtotal'   => 
                    );
                    
                    $data_hist = array(
                        'tgl_modif'  => date('Y-m-d H:i:s'),
                        'keterangan' => 'Pembelian '.$sql_beli->no_nota
                    );
                    
                    // Log History Harga
                    $data_brg_hist = array(
                       'tgl_simpan'         => date('Y-m-d H:i:s'),
                       'id_produk'          => $sql_brg->id,
                       'id_user'            => $sql_beli->id_user,
                       'id_pembelian'       => $sql_det->id_pembelian,
                       'nom_awal'           => $sql_brg->harga_beli,
                       'nom_akhir'          => $harga_pcs,
                       'keterangan'         => 'Pembelian '.$sql_beli->no_nota,
                       'status'             => '1',
                    );
                    
                    crud::update('tbl_trans_beli', 'id', $sql_beli->id, array('status_penerimaan'=>'0'));
                    crud::update('tbl_trans_beli_det', 'id_pembelian', $sql_beli->id, $data_trans_beli_det);
//                    crud::update('tbl_m_produk_hist_harga', 'id', $sql_cek_hist->id, $data_brg_hist);
                    crud::update('tbl_m_produk', 'id', $sql_det->id_produk, $data_produk);
                }
                
                /* -- Hapus semua session -- */
                $this->session->unset_userdata('trans_beli_upd');
                /* -- Hapus semua session -- */
                
//                $this->session->set_flashdata('transaksi', '<div class="alert alert-success">Transaksi berhasil disimpan</div>');
                redirect(base_url('transaksi/trans_bayar_beli.php?id='.$no_nota));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_nota_beli_proses_upd_item() {
        if (akses::aksesLogin() == TRUE) {
            $id         = $this->input->post('id');
            $id_prod    = $this->input->post('id_produk');
            $id_satuan  = $this->input->post('id_satuan');
            $id_penj_det= $this->input->post('aid');
            $edit_jml   = $this->input->post('edit_jml');
            $edit_disk1 = $this->input->post('edit_disk1');
            $edit_disk2 = $this->input->post('edit_disk2');
            $edit_disk3 = $this->input->post('edit_disk3');
            $edit_pot   = str_replace('.', '', $this->input->post('edit_pot'));
            $edit_sat   = $this->input->post('edit_satuan');
            $edit_hrg   = str_replace('.', '', $this->input->post('edit_harga'));
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id', 'no _nota', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'no_nota' => form_error('no_nota'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url('transaksi/trans_jual_edit.php?id='.$id));
            } else {
                $sql_beli_det = $this->db->where('id', general::dekrip($id_penj_det))->get('tbl_trans_beli_det')->row();
                $sql_satuan   = $this->db->where('id_produk', general::dekrip($id_prod))->where('satuan', $edit_sat)->get('tbl_m_produk_satuan')->row();
                $sql_satuan2  = $this->db->where('id', $sql_beli_det->id_satuan)->get('tbl_m_satuan')->row();
                $sql_brg      = $this->db->where('id', general::dekrip($id_prod))->get('tbl_m_produk')->row();
                
                $jml_pcs     = $sql_satuan->jml * $edit_jml;
                $harga_pcs   = ($edit_hrg * $edit_jml) / $jml_pcs;
                $harga_sat   = $harga_pcs * $sql_satuan->jml;
                
                $disk1       = $harga_pcs - (($edit_disk1 / 100) * $harga_pcs);
                $disk2       = $disk1 - (($edit_disk2 / 100) * $disk1);
                $disk3       = $disk2 - (($edit_disk3 / 100) * $disk2);
                
                $harga_tot   = $disk3;
                $subtotal    = ($disk3 * $jml_pcs) - $edit_pot;
                
                $jml_ditrm   = $sql_beli_det->jml_diterima;
                $jml_sisa    = $jml_pcs - $jml_ditrm;
               
                if($jml_sisa < 0){
                    $this->session->set_flashdata('transaksi', '<div class="alert alert-danger">Tidak bisa merubah item "<b>'.$sql_brg->produk.'</b>", '.$sql_beli_det.'</b> karena sudah dilakukan penerimaan !!. Jika tetap ingin merubah, silahkan '.anchor(base_url('gudang/trans_po_terima.php?id='.general::enkrip($sql_beli_det->id_pembelian)), '<b>Klik disini</b>', 'target="_blank"').' untuk reset penerimaan.</div>');
                    redirect(base_url('transaksi/trans_beli_edit.php?id='.$id));
                }else{
                    // Simpan pembelian ke tabel
                    $data_penj = array(
                        'satuan'        => $edit_sat,
                        'keterangan'    => ($sql_satuan->jml != '1' ? ' ('.$sql_satuan->jml * $edit_jml.' '.$sql_satuan2->satuanTerkecil.')' : ''),
                        'harga'         => ceil((float)$edit_hrg),
                        'jml'           => (float)$edit_jml,
                        'jml_satuan'    => $sql_satuan->jml,
                        'disk1'         => $edit_disk1,
                        'disk2'         => $edit_disk2,
                        'disk3'         => $edit_disk3,
                        'potongan'      => $edit_pot,
                        'subtotal'      => ceil((float)$subtotal),
                    );

//                    // Kembalikan dulu stok sebelumnya berdasarkan transaksi sebelumnya
//                    $data_brg = array(
//                        'tgl_modif' => date('Y-m-d H:i:s'),
//                        'jml'       => $jml_akhir
//                    );
//                    
//                    crud::update('tbl_m_produk', 'id', $sql_brg->id, $data_brg);
                    crud::update('tbl_trans_beli_det', 'id', general::dekrip($id_penj_det), $data_penj);
//                    /* --- */
//                
//                    // Ambil data transaksi terbaru
//                    $sql_brg2      = $this->db->where('id', general::dekrip($id_prod))->get('tbl_m_produk')->row();
//                    $sql_penj_det2 = $this->db->where('id', general::dekrip($id_penj_det))->get('tbl_trans_jual_det')->row();
//                    $jml_akhir2    = $sql_brg2->jml - ($sql_penj_det2->jml * $sql_penj_det2->jml_satuan);
//                    
//                    // Kurangkan data stok dengan data transaksi terbaru
//                    $data_brg2 = array(
//                        'tgl_modif' => date('Y-m-d H:i:s'),
//                        'jml'       => $jml_akhir2
//                    );
//                    crud::update('tbl_m_produk', 'id', $sql_brg->id, $data_brg2);
                }
                
//                $this->session->set_flashdata('transaksi', '<div class="alert alert-success">Data berhasil di ubah !!!</div>');
                redirect(base_url('transaksi/trans_beli_edit.php?id='.$id));
                
//                echo '<pre>';
//                print_r($data_penj);
//                echo '</pre>';
//                echo '<pre>';
//                print_r($data_brg);
//                echo '</pre>';
//                echo '<pre>';
//                print_r($sql_satuan);
//                echo '</pre>';
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_nota_beli_ppn_upd() {
        if (akses::aksesLogin() == TRUE) {
            $id         = $this->input->get('id');
            $ppn        = $this->input->get('ppn');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();

//            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
//
//            $this->form_validation->set_rules('id', 'no _nota', 'required');
//
//            if ($this->form_validation->run() == FALSE) {
//                $msg_error = array(
//                    'no_nota' => form_error('no_nota'),
//                );
//
//                $this->session->set_flashdata('form_error', $msg_error);
//                
//                redirect(base_url('transaksi/trans_jual_edit.php?id='.$id));
//            } else {
                $sql_penj       = $this->db->where('id', general::dekrip($id))->get('tbl_trans_beli')->row();
                $sql_penj_det   = $this->db->where('id_pembelian', general::dekrip($id))->get('tbl_trans_beli_det')->result();
                
                $jml_ppn    = ($ppn / 100) * $sql_penj->jml_subtotal;
                $jml_gtotal = $sql_penj->jml_subtotal + $jml_ppn;
                
                $penj = array(
                    'ppn'       => $ppn,
                    'jml_ppn'   => $jml_ppn,
                    'jml_gtotal'=> $jml_gtotal,
                    'status_ppn'=> ($ppn > 0 ? '1' : '0'),
                );
                
                crud::update('tbl_trans_beli', 'id', general::dekrip($id), $penj);
                
                foreach ($sql_penj_det as $beli){
                    $jml_pcs        = $beli->jml * $beli->jml_satuan;
                    $hrg_ppn_beli   = ($beli->subtotal / $beli->jml);
                    $hrg_ppn_tot    = ($ppn > 0 ? (($ppn / 100) * $hrg_ppn_beli) : 0);
                    $hrg_pcs        = ($hrg_ppn_beli + $hrg_ppn_tot) / $beli->jml_satuan;
                    $hrg_ppn        = $hrg_ppn_tot / $beli->jml_satuan;

                    crud::update('tbl_m_produk', 'id', $beli->id_produk, array('harga_beli' => $hrg_pcs, 'harga_beli_ppn' => $hrg_ppn));
                }
                
                redirect(base_url('transaksi/trans_bayar_beli.php?id='.$id.'#blok_ppn'));
//            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_nota_beli_bayar() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota        = general::dekrip($this->input->post('id'));
            $tgl_byr        = explode('/',$this->input->post('tgl_bayar'));
            $metode_byr     = $this->input->post('metode_bayar');
            $bank           = $this->input->post('bank');
            $no_kartu       = $this->input->post('no_kartu');
            $disk1          = str_replace(',', '.', $this->input->post('disk1'));
            $disk2          = str_replace(',', '.', $this->input->post('disk2'));
            $disk3          = str_replace(',', '.', $this->input->post('disk3'));
            $jml_total      = str_replace('.', '', $this->input->post('jml_total'));
//            $jml_subtotal   = str_replace('.', '', $this->input->post('jml_subtotal'));
            $jml_ppn        = str_replace('.', '', $this->input->post('jml_ppn'));
            $jml_gtotal     = str_replace('.', '', $this->input->post('jml_gtotal'));
            $jml_bayar      = str_replace('.', '', $this->input->post('jml_bayar'));
            $gt_diskon      = str_replace('.', '', $this->input->post('disk_nom'));
            $tp_diskon      = str_replace('.', '', $this->input->post('tipe_disk'));

            $pengaturan = $this->db->get('tbl_pengaturan')->row();
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('id', 'id', 'required');
            $this->form_validation->set_rules('jml_bayar', 'jml_bayar', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'id'        => form_error('id'),
                    'jml_bayar' => form_error('jml_bayar'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url('transaksi/trans_bayar_beli.php?id='.general::enkrip($no_nota).'#jml_bayar'));
            } else {
                $tgl_bayar    = $tgl_byr[2].'-'.$tgl_byr[0].'-'.$tgl_byr[1];
                $sql_cek      = $this->db->where('id', $no_nota)->get('tbl_trans_beli')->row();
                $sql_cek_plat = $this->db->where('id_pembelian', $no_nota)->get('tbl_trans_beli_plat')->num_rows();
                $sql_plat     = $this->db->where('id', $metode_byr)->get('tbl_m_platform')->row();
                
                $diskon1      = $jml_total - (($disk1 / 100) * $jml_total);
                $diskon2      = $diskon1 - (($disk2 / 100) * $diskon1);
                $diskon3      = $diskon2 - (($disk3 / 100) * $diskon2);
                $jml_diskon   = ($tp_diskon == 'nominal' ? $gt_diskon : ($jml_total - $diskon3) + $sql_cek->jml_diskon);
                
                $jml_subtotal = $jml_total - $jml_diskon - $sql_cek->jml_retur;
                $jml_ppn      = ($sql_cek->ppn / 100) * $jml_subtotal;
                $jml_gtotal   = $jml_subtotal + $jml_ppn;
                
                $jml_kurang   = $jml_gtotal - $jml_bayar;
                $jml_kembali  = $jml_bayar - $jml_gtotal;                
                
                /* Kalo pembayaran kurang */
                if($sql_cek->status_bayar > 1){
                    $jml_tot_bayar  = $sql_cek->jml_bayar + $jml_bayar;
                    $jml_sisa_bayar = $sql_cek->jml_kurang - $jml_bayar;
                    $jml_sisa_kmbli = $jml_sisa_bayar;
                    
                    if(floor($jml_sisa_bayar) <= 0){
                        $trans = array(
                            'tgl_bayar'    => $tgl_bayar,
                            'tgl_modif'    => date('Y-m-d H:i:s'),
                            'jml_bayar'    => $jml_tot_bayar,
                            'jml_kurang'   => (int)($jml_sisa_bayar < 0 ? 0 : $jml_sisa_bayar),
                            'jml_kembali'  => $jml_sisa_bayar,
                            'status_bayar' => '1',
                         );
                        
                         crud::update('tbl_trans_beli','id',$sql_cek->id,$trans);
                    }else{
                        $trans = array(
                            'tgl_bayar'    => $tgl_bayar,
                            'tgl_modif'    => date('Y-m-d H:i:s'),
                            'jml_bayar'    => $jml_tot_bayar,
                            'jml_kurang'   => (int)$jml_sisa_bayar,
                         );
                        
                        crud::update('tbl_trans_beli','id',$sql_cek->id,$trans);
                    }
                }else{
                    /* Cek Pembayaran jika kurang, otomatis menjadi DP */
                    if(floor($jml_bayar) < floor($jml_gtotal)){
                        $trans = array(
                            'tgl_bayar'    => $tgl_bayar,
                            'tgl_modif'    => date('Y-m-d H:i:s'),
                            'disk1'        => (float)$disk1,
                            'disk2'        => (float)$disk2,
                            'disk3'        => (float)$disk3,
                            'jml_subtotal' => (float)$jml_subtotal,
                            'jml_ppn'      => (float)$jml_ppn,
                            'jml_gtotal'   => (float)$jml_gtotal,
                            'jml_diskon'   => (float)$jml_diskon,
                            'jml_bayar'    => (float)$jml_bayar,
                            'jml_kurang'   => (int)$jml_kurang,
                            'status_bayar' => '2',
                            'metode_bayar' => $metode_byr,
                         );
                         
                        crud::update('tbl_trans_beli','id',$sql_cek->id,$trans);
                    }else{
                        /* Jika jumlah pembayaran lunas */
                        $trans = array(
                            'tgl_bayar'    => $tgl_bayar,
                            'tgl_modif'    => date('Y-m-d H:i:s'),
                            'disk1'        => (float)$disk1,
                            'disk2'        => (float)$disk2,
                            'disk3'        => (float)$disk3,
                            'jml_subtotal' => (float)$jml_subtotal,
                            'jml_ppn'      => (float)$jml_ppn,
                            'jml_gtotal'   => (float)$jml_gtotal,
                            'jml_diskon'   => (float)$jml_diskon,
                            'jml_bayar'    => (float)$jml_bayar,
                            'jml_kembali'  => (float)$jml_kembali,
                            'status_bayar' => '1',
                            'status_nota'  => '3',
                            'metode_bayar' => $metode_byr,
                         );
                        
                        crud::update('tbl_trans_beli', 'id', $sql_cek->id, $trans);
                    }
                }
                
                /* -- Simpan pengeluaran ke tabel pengeluaran -- */
                $kode_pm   = general::no_nota('', 'tbl_akt_kas', 'kode', "WHERE tipe='keluar'");
                $saldo_kas = $this->db->select('MAX(id) as id, MAX(saldo) as saldo')->get('tbl_akt_kas')->row();
                $tot_saldo = $saldo_kas->saldo - $jml_bayar;
                
                $data_pengeluaran = array(
                    'tgl_simpan' => date('Y-m-d H:i'),
                    'id_user'    => $this->ion_auth->user()->row()->id,
                    'kode'       => $kode_pm,
                    'keterangan' => 'Pembelian '.$sql_cek->no_nota,
                    'nominal'    => (float)$jml_bayar,
                    'kredit'     => (float)$sql_cek->jml_gtotal,
                    'saldo'      => (float)$tot_saldo,
                    'status_kas' => ($metode_byr > 1 ? 'bank' : 'kas'),
                    'tipe'       => 'keluar',
                );
                
                crud::simpan('tbl_akt_kas', $data_pengeluaran);
                /* -- Simpan pengeluaran ke tabel pengeluaran -- */
                
                // Simpan platform pembayaran
                $data_platform = array(
                    'tgl_simpan'  => $tgl_bayar.' '.date('H:i'),
                    'id_platform' => $metode_byr,
                    'id_pembelian'=> $no_nota,
                    'platform'    => (!empty($bank) ? $bank : '-'),
                    'keterangan'  => (!empty($no_kartu) ? $no_kartu : ''),
                    'nominal'     => (float)$jml_bayar,
                );

                // Cek di tabel platform supaya tidak dobel
                crud::simpan('tbl_trans_beli_plat',$data_platform);
                
                $this->session->set_flashdata('transaksi', '<div class="alert alert-success">Transaksi berhasil disimpan</div>');
                redirect(base_url('transaksi/trans_beli_det.php?id='.general::enkrip($no_nota)));
                
                if($sql_cek->status_bayar > 1){
                    if($jml_sisa_bayar <= 0){
                        redirect(base_url('transaksi/trans_beli_det.php?id='.general::enkrip($no_nota)));
                    }else{
                        redirect(base_url('transaksi/trans_bayar_beli.php?id='.general::enkrip($no_nota)));
                    }
                }else{
                    if($jml_bayar < $jml_gtotal){
                        redirect(base_url('transaksi/trans_bayar_beli.php?id='.general::enkrip($no_nota)));                        
                    }else{
                        redirect(base_url('transaksi/trans_beli_det.php?id='.general::enkrip($no_nota)));                        
                    }
                }   
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_nota_beli_status() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota        = general::dekrip($this->input->post('id'));
            $status         = $this->input->post('status');
                        
            if(!empty($_GET['status'])){
                crud::update('tbl_trans_beli_po', 'id', general::dekrip($_GET['id']), array('status_nota'=>$_GET['status']));
                redirect(base_url('transaksi/trans_beli_po_det.php?id='.$_GET['id']));
            }else{
                crud::update('tbl_trans_beli_po', 'id', $no_nota, array('status_nota'=>$status));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_retur_jual_proses() {
        if (akses::aksesLogin() == TRUE) {
            $id         = $this->input->post('id');
            $no_nota    = $this->input->post('no_nota');
            $jml_total  = $this->input->post('jml_total');
            $jml_ppn    = $this->input->post('jml_ppn');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();
            $status_gd  = $this->ion_auth->user()->row()->status_gudang;

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('no_nota', 'no_nota', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'no_nota' => form_error('no_nota'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url('transaksi/input_retur_jual.php'));
            } else {
                $trans_jual     = $this->db->where('id', general::dekrip($no_nota))->get('tbl_trans_jual')->row();
                $trans_ret      = $this->db->where('id', general::dekrip($id))->get('tbl_trans_retur_jual')->row();
                $trans_ret_det  = $this->db->where('id_retur_jual', general::dekrip($id))->get('tbl_trans_retur_jual_det')->result();
                $trans_ret_sum  = $this->db->select('SUM(subtotal) as subtotal')->where('id_retur_jual', $trans_ret->id)->where('status_retur !=', '3')->get('tbl_trans_retur_jual_det')->row();
                
                $trans_ret_sum1  = $this->db->select('SUM(subtotal) as subtotal')->where('id_retur_jual', general::dekrip($id))->where('status_retur !=', '3')->get('tbl_trans_retur_jual_det')->row();
                $trans_ret_sum2  = $this->db->select('SUM(subtotal) as subtotal')->where('id_retur_jual', general::dekrip($id))->where('status_retur', '3')->get('tbl_trans_retur_jual_det')->row();
                $jm_retur        = $trans_ret_sum1->subtotal - $trans_ret_sum2->subtotal;
                
//                $disk1          = $trans_ret_sum->subtotal - (($trans_jual->disk1 / 100) * $trans_ret_sum->subtotal);
//                $disk2          = $disk1 - (($trans_jual->disk2 / 100) * $disk1);
//                $disk3          = $disk2 - (($trans_jual->disk3 / 100) * $disk2);
//                $jml_diskon     = $trans_ret_sum->subtotal - $disk3;
//                
//                $jml_total      = ($trans_jual->jml_total - $trans_jual->jml_diskon) + $trans_jual->jml_biaya;
//                $jml_retur      = $jm_retur;
//                $jml_subtotal   = $jml_total - $jml_retur;
//                $jml_ppn        = ($trans_jual->ppn / 100) * $jml_subtotal;
//                $jml_ppn_retur  = ($trans_jual->ppn / 100) * $jml_retur;
//                $jml_gtotal     = ($jml_subtotal + $jml_ppn);
//                $jml_gtotal_ret = $disk3 + $jml_ppn_retur;
//                $jml_kembali    = $trans_jual->jml_bayar - $jml_gtotal;
                
                foreach ($trans_ret_det as $items){
                    $sql_nota_det  = $this->db->where('id_penjualan', general::dekrip($no_nota))->where('kode', $items->kode)->get('tbl_trans_jual_det')->row();
                    $sql_barang    = $this->db->where('kode', $items->kode)->get('tbl_m_produk')->row();
                    $qty           = (int)$sql_nota_det->jml - (int)$items->jml;
                    $jml_real      = $items->jml * $items->jml_satuan;
                    $jml_awal      = $sql_nota_det->jml;
                    $harga         = $sql_nota_det->harga;
                    
                    $sql_gudang      = $this->db->where('status', $status_gd)->get('tbl_m_gudang')->row(); // Cek gudang aktif dari gudang utama
                    $sql_gudang_stok = $this->db->where('id_gudang', $sql_gudang->id)->where('id_produk', $sql_barang->id)->get('tbl_m_produk_stok')->row(); // ambil data dari stok tsb
                    
                    $disk1         = $harga - (($sql_nota_det->disk1 / 100) * $harga);
                    $disk2         = $disk1 - (($sql_nota_det->disk2 / 100) * $disk1);
                    $disk3         = $disk2 - (($sql_nota_det->disk3 / 100) * $disk2);
                    $subtotal      = $disk3 * $qty;
                    
                    if($items->status_retur != '3'){
                        $jml_barang         = $sql_nota_det->jml - $items->jml;
                        $jml_subtotal_det   = $jml_barang * $items->harga;
                        
                        $data_retur_det = array(
                            'produk'     => $sql_nota_det->produk.' [RETUR]',
                            'jml'        => $jml_barang,
//                            'subtotal'   => $jml_subtotal_det,
                            'status_brg' => '1',
                        );
                    
                        /* Ubah status barang, ke retur */
                        crud::update('tbl_trans_jual_det', 'id', $sql_nota_det->id, $data_retur_det);
                    }
                    
                    /* Balikin stok barang, jika retur */
                    if($items->status_retur != '3'){
                         $sisa_barang      = $sql_barang->jml + $jml_real;
                         $sisa_barang_st   = $sql_gudang_stok->jml + $jml_real;
                    }else{
                         $data_penj_det = array(
                             'id_penjualan' => $trans_jual->id,
                             'no_nota'      => $trans_jual->no_nota,
                             'tgl_simpan'   => $trans_jual->tgl_simpan,
                             'id_satuan'    => $items->id_satuan,
                             'satuan'       => $items->satuan,
                             'keterangan'   => $items->satuan_ket,
                             'kode'         => $items->kode,
                             'produk'       => $items->produk,
                             'jml'          => (int)$items->jml,
                             'jml_satuan'   => (int)$items->jml_satuan,
                             'harga'        => (float)$items->harga,
                             'disk1'        => (float)$items->disk1,
                             'disk2'        => (float)$items->disk2,
                             'disk3'        => (float)$items->disk3,
                             'diskon'       => (float)$jml_diskon,
                             'potongan'     => (float)$items->potongan,
                             'subtotal'     => (float)$items->subtotal,
                         );
                         
                        $sisa_barang   = $sql_barang->jml - $jml_real;
                        $sisa_barang_st= $sql_gudang_stok->jml - $jml_real;
                        crud::simpan('tbl_trans_jual_det', $data_penj_det);
                    }
                    
                    /* Untuk menyimpan sisa barang dari semua gudang */
                    $data_retur_brg = array(
                        'jml'       => $sisa_barang,
                    );
                    
                    /* Untuk menyimpan sisa barang dari gudang aktif */
                    $data_retur_stk = array(
                        'tgl_modif' => date('Y-m-d H:i:s'),
                        'jml'       => $sisa_barang_st,
                    );
                    
                    crud::update('tbl_m_produk', 'id', $sql_barang->id, $data_retur_brg);
                    crud::update('tbl_m_produk_stok', 'id', $sql_gudang_stok->id, $data_retur_stk);
                    
                    /* Catat log barang keluar ke tabel */
                    $data_penj_hist = array(
                        'tgl_simpan'   => $trans_ret->tgl_simpan,
                        'id_pelanggan' => $trans_ret->id_pelanggan,
                        'id_gudang'    => $sql_gudang->id,
                        'id_produk'    => $sql_barang->id,
                        'id_user'      => $this->ion_auth->user()->row()->id,
                        'id_penjualan' => $trans_ret->id,
                        'no_nota'      => $trans_ret->no_retur,
                        'kode'         => $sql_barang->kode,
                        'keterangan'   => 'Retur Penjualan '.$trans_ret->no_retur,
                        'jml'          => (int)$items->jml,
                        'jml_satuan'   => (int)$items->jml_satuan,
                        'satuan'       => $sql_sat->satuanTerkecil,
                        'nominal'      => (float)$items->subtotal,
                        'status'       => '3'
                    );

                    crud::simpan('tbl_m_produk_hist', $data_penj_hist);
                    /* -- END -- */
                
//                    echo '<pre>';
//                    print_r($data_retur_brg);
//                    echo '</pre>';
//                
//                    echo '<pre>';
//                    print_r($data_penj_hist);
//                    echo '</pre>';
                }
                
                $trans_jual_det_sum = $this->db->select('SUM(subtotal) as jml_total')->where('id_penjualan', general::dekrip($no_nota))->get('tbl_trans_jual_det')->row();
                $jml_subtotal       = $trans_jual_det_sum->jml_total - $trans_jual->jml_diskon - $trans_jual->jml_biaya - $trans_ret_sum->subtotal;
                $jml_ppn            = ($trans_jual->status_ppn == '1' ? '' : '0');
                $jml_gtotal         = $jml_subtotal + $jml_ppn;
                $jml_kembali        = $trans_jual->jml_bayar - $jml_gtotal;
                
                $data_penjualan = array(
                    'jml_total'     => (float)$trans_jual_det_sum->jml_total,
                    'jml_diskon'    => (float)$trans_jual->jml_diskon,
                    'jml_biaya'     => (float)$trans_jual->jml_biaya,
                    'jml_retur'     => (float)$trans_ret_sum->subtotal,
                    'jml_subtotal'  => (float)$jml_subtotal,
                    'jml_ppn'       => (float)$jml_ppn,
                    'jml_gtotal'    => (float)$jml_gtotal,
                    'jml_kembali'   => (float)($jm_retur < 0 ? 0 : $jml_kembali),
                    'jml_kurang'    => (float)($jm_retur < 0 ? 0 - $jm_retur : '0'),
                    'status_retur'  => '1',
                    'status_bayar'  => ($jm_retur < 0 ? '2' : '1'),
                );
                
                $data_retur = array(
                    'jml_total'     => (float)$trans_ret_sum1->subtotal,
                    'jml_retur'     => (float)$jm_retur + $jml_diskon,
                    'status_retur'  =>  '3'
                );
                
//                echo '<pre>';
//                print_r($data_penjualan);
//                echo '</pre>';
//                echo $jm_retur;
//                echo '<pre>';
//                print_r($data_retur);
//                echo '</pre>';
                
                crud::update('tbl_trans_jual', 'id', $trans_jual->id, $data_penjualan);
                crud::update('tbl_trans_retur_jual', 'id', $trans_ret->id, $data_retur);
                                
                /* -- Hapus semua session -- */
                $this->session->unset_userdata('trans_retur_jual');
                /* -- Hapus semua session -- */
                //  data_retur_jual_list
                $this->session->set_flashdata('transaksi', '<div class="alert alert-success">Transaksi retur berhasil disimpan</div>');
                redirect(base_url('transaksi/'.($jm_retur < 0 ? 'trans_bayar_jual' : 'trans_retur_jual_det').'.php?id='.($jm_retur < 0 ? $no_nota : $id)));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_retur_beli_proses() {
        if (akses::aksesLogin() == TRUE) {
            $id         = $this->input->post('id');
            $no_nota    = $this->input->post('no_nota');
            $pengaturan = $this->db->get('tbl_pengaturan')->row();
            $status_gd  = $this->ion_auth->user()->row()->status_gudang;

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('no_nota', 'no_nota', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'no_nota' => form_error('no_nota'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url('transaksi/trans_retur_beli.php?id='.$id.'&no_nota='.$no_nota));
            } else {
                $trans_beli     = $this->db->where('id', general::dekrip($no_nota))->get('tbl_trans_beli')->row();
                $trans_ret      = $this->db->where('id', general::dekrip($id))->get('tbl_trans_retur_beli')->row();
                $trans_ret_det  = $this->db->where('id_retur_beli', general::dekrip($id))->get('tbl_trans_retur_beli_det')->result();
                $trans_ret_sum  = $this->db->select('SUM(subtotal) as subtotal')->where('id_retur_beli', general::dekrip($id))->get('tbl_trans_retur_beli_det')->row();
                $jml_total      = $trans_beli->jml_total - $trans_ret_sum->subtotal;
                $jml_gtotal     = $jml_total;
                
                foreach ($trans_ret_det as $items){
                    $sql_nota_det = $this->db->where('id_pembelian', general::dekrip($no_nota))->where('kode', $items->kode)->get('tbl_trans_beli_det')->row();
                    $sql_barang   = $this->db->where('kode', $items->kode)->get('tbl_m_produk')->row();
                    $sql_sat      = $this->db->where('id', $sql_barang->id_satuan)->get('tbl_m_satuan')->row();
                    
                    $sql_gudang      = $this->db->where('status', $status_gd)->get('tbl_m_gudang')->row(); // Cek gudang aktif dari gudang utama
                    $sql_gudang_stok = $this->db->where('id_gudang', $sql_gudang->id)->where('id_produk', $sql_barang->id)->get('tbl_m_produk_stok')->row(); // ambil data dari stok tsb
                    
                    $qty          = (int)$sql_nota_det->jml - (int)$items->jml;
                    $jml_real     = $items->jml_satuan * $items->jml;
                    $sisa_barang  = $sql_barang->jml - $jml_real;
                    $sisa_stok    = $sql_gudang_stok->jml - $jml_real;
                    $harga        = $sql_nota_det->harga_beli;
                    
                    $disk1    = $harga - (($sql_nota_det->disk1 / 100) * $harga);
                    $disk2    = $disk1 - (($sql_nota_det->disk2 / 100) * $disk1);
                    $disk3    = $disk2 - (($sql_nota_det->disk3 / 100) * $disk2);
                    $subtotal = $disk3 * $qty;
                    
                    $data_retur_det = array(
//                         'jml'       => $qty,
//                         'subtotal'  => $subtotal,
                         'status_brg'=> '1',
                    );
                    
                    $data_retur_brg = array(
                         'jml'       => $sisa_barang,
                         
                    );
                    
                    $data_retur_stok = array(
                         'tgl_modif' => date('Y-m-d H:i:s'),
                         'jml'       => $sisa_stok,
                         
                    );
                    
                    /* Catat log retur barang ke tabel */
                    $data_penj_hist = array(
                        'tgl_simpan'   => $trans_ret->tgl_simpan,
                        'id_gudang'    => $sql_gudang->id,
                        'id_produk'    => $sql_barang->id,
                        'id_supplier'  => $trans_beli->id_supplier,
                        'id_user'      => $this->ion_auth->user()->row()->id,
                        'id_pembelian' => $trans_ret->id,
                        'no_nota'      => $trans_ret->no_nota,
                        'kode'         => $sql_barang->kode,
                        'keterangan'   => 'Retur Pembelian '.$trans_ret->no_nota,
                        'jml'          => (int)$items->jml,
                        'jml_satuan'   => (int)$items->jml_satuan,
                        'satuan'       => $sql_sat->satuanTerkecil,
                        'nominal'      => (float)$items->subtotal,
                        'status'       => '5'
                    );
                    
//                    echo '<pre>';
//                    print_r($data_penj_hist);
//                    echo '</pre>';
//                    
//                    echo '<pre>';
//                    print_r($data_retur_brg);
//                    echo '</pre>';
//                    
//                    echo '<pre>';
//                    print_r($data_retur_det);
//                    echo '</pre>';

                    crud::simpan('tbl_m_produk_hist', $data_penj_hist);
                    /* -- END -- */
                    
                    /* Ubah status barang, ke retur */
                    crud::update('tbl_trans_beli_det', 'id', $sql_nota_det->id, $data_retur_det);
                    
                    /* Ubah status barang, ke retur */
                    crud::update('tbl_m_produk', 'id', $sql_barang->id, $data_retur_brg);
                    
                    /* Simpan sisa stok */
                    crud::update('tbl_m_produk_stok', 'id', $sql_gudang_stok->id, $data_retur_stok);
                }
                
                $jml_subtotal = $trans_beli->jml_total - $trans_beli->jml_potongan - $trans_beli->jml_diskon - $trans_ret_sum->subtotal + $trans_beli->jml_biaya;
                $jml_ppn      = ($trans_beli->ppn / 100) * $jml_subtotal;
                $jml_gtotal   = $jml_subtotal + $jml_ppn;
                $jml_bayar    = $trans_beli->jml_bayar;
                $jml_kembali  = $trans_beli->jml_bayar - $jml_gtotal;
                
                $data_pemb = array(
                    'jml_total'     => (float)$trans_beli->jml_total,
                    'jml_retur'     => (float)$trans_ret_sum->subtotal,
                    'jml_subtotal'  => (float)$jml_subtotal,
                    'jml_ppn'       => (float)$jml_ppn,
                    'jml_gtotal'    => (float)$jml_gtotal,
                    'jml_bayar'     => (float)$jml_bayar,
                    'jml_kembali'   => (float)$jml_kembali,
                    'status_retur'  => '1',
                );
                
                $data_retur = array(
                    'jml_retur'     => (float)$trans_ret_sum->subtotal,
                    'status_retur'  => '2'
                );
                    
//                echo '<pre>';
//                print_r($data_retur);
//                echo '</pre>';
//                    
//                echo '<pre>';
//                print_r($data_pemb);
//                echo '</pre>';
//                    
//                echo '<pre>';
//                print_r($trans_beli);
//                echo '</pre>';
                
                crud::update('tbl_trans_beli', 'id', $trans_beli->id, $data_pemb);
                crud::update('tbl_trans_retur_beli', 'id', general::dekrip($id), $data_retur);
                                
                /* -- Hapus semua session -- */
                $this->session->unset_userdata('trans_retur_beli');
                $this->cart->destroy();
                /* -- Hapus semua session -- */
                
                $this->session->set_flashdata('transaksi', '<div class="alert alert-success">Transaksi retur berhasil disimpan</div>');
                redirect(base_url('transaksi/data_retur_beli_list.php'));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_nota_jual_bayar() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota    = general::dekrip($this->input->post('no_nota'));
            $tgl_byr    = explode('/',$this->input->post('tgl_bayar'));
            $metode_byr = $this->input->post('metode_bayar');
            $bank       = $this->input->post('bank');
            $no_kartu   = $this->input->post('no_kartu');
            $jml_gtotal = str_replace('.', '', $this->input->post('jml_gtotal'));
            $diskon     = str_replace('.', '', $this->input->post('diskon'));
            $jml_diskon = str_replace('.', '', $this->input->post('jml_diskon'));
            $jml_bayar  = str_replace('.', '', $this->input->post('jml_bayar'));
            $jml_biaya  = str_replace('.', '', $this->input->post('jml_biaya'));

            $pengaturan = $this->db->get('tbl_pengaturan')->row();
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('no_nota', 'no_nota', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'no_nota' => form_error('no_nota'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url('transaksi/trans_bayar_jual.php?id='.$no_nota));
            } else {
                $tgl_bayar    = $tgl_byr[2].'-'.$tgl_byr[0].'-'.$tgl_byr[1];
                $sql_cek      = $this->db->where('id', $no_nota)->get('tbl_trans_jual')->row();
                $sql_cek_plat = $this->db->where('id_penjualan', $no_nota)->get('tbl_trans_jual_plat')->num_rows();
                $sql_plat     = $this->db->where('id', $metode_byr)->get('tbl_m_platform')->row();
                $jml_kurang   = $jml_gtotal - $jml_bayar;
                $jml_kembali  = $jml_bayar - $jml_gtotal;
                $jml_tot_disk = $sql_cek->jml_diskon + $jml_diskon;
                $ppn          = ($sql_cek->status_ppn == '1' ? $sql_cek->ppn : '0');
                $jml_ppn      = ($sql_cek->status_ppn == '1' ? ($sql_cek->ppn / 100) * $jml_gtotal : '0');
                $gtotal       = ($sql_cek->status_ppn == '1' ? $jml_gtotal + $jml_ppn : $jml_gtotal);
                
                /* Kalo pembayaran kurang */
                if($sql_cek->status_bayar > 1){
                    $jml_tot_bayar  = $sql_cek->jml_bayar + $jml_bayar;
                    $jml_tot_biaya  = $sql_cek->jml_biaya + $jml_biaya;
                    $jml_tot_gtot   = $sql_cek->jml_gtotal + $jml_biaya;
                    $jml_sisa_bayar = $sql_cek->jml_kurang - $jml_bayar;
                    $jml_sisa_kmbli = $jml_tot_bayar - $sql_cek->jml_gtotal;
                    
                    if($jml_sisa_bayar <= 0){
                        $trans = array(
                            'tgl_bayar'    => $tgl_bayar,
                            'tgl_modif'    => date('Y-m-d H:i:s'),
                            'jml_biaya'    => (float)$jml_tot_biaya,
                            'jml_gtotal'   => (float)$jml_tot_gtot,
                            'jml_bayar'    => $jml_tot_bayar,
                            'jml_kurang'   => (int)($jml_sisa_bayar < 0 ? 0 : $jml_sisa_bayar),
                            'jml_kembali'  => (int)($jml_sisa_kmbli < 0 ? 0 : $jml_sisa_kmbli),
                            'status_bayar' => '1',
                            'status_nota'  => '3',
                            'metode_bayar' => $metode_byr,
                         );
                        
                         crud::update('tbl_trans_jual','id',$no_nota,$trans);
                    }else{
                        $trans = array(
                            'tgl_bayar'    => $tgl_bayar,
                            'tgl_modif'    => date('Y-m-d H:i:s'),
                            'jml_biaya'    => (float)$jml_tot_biaya,
                            'jml_gtotal'   => (float)$jml_tot_gtot,
                            'jml_bayar'    => $jml_tot_bayar,
                            'jml_kurang'   => (int)$jml_sisa_bayar,
                            'metode_bayar' => $metode_byr,
                         );
                        
                        crud::update('tbl_trans_jual','id',$no_nota,$trans);
                    }
                }else{
                    /* Cek Pembayaran jika kurang, otomatis menjadi DP */
                    if($jml_bayar < $jml_gtotal){
                        $trans = array(
                            'tgl_bayar'    => $tgl_bayar,
                            'tgl_modif'    => date('Y-m-d H:i:s'),
                            'jml_subtotal' => (float)$jml_gtotal,
                            'diskon'       => (float)$diskon,
                            'jml_diskon'   => (float)$jml_tot_disk,
                            'jml_biaya'    => (float)$jml_biaya,
                            'jml_gtotal'   => (float)$gtotal,
                            'jml_bayar'    => (float)$jml_bayar,
                            'jml_kurang'   => (int)$jml_kurang,
                            'status_bayar' => '2',
                            'metode_bayar' => $metode_byr,
                         );
                         
                        crud::update('tbl_trans_jual','id',$no_nota,$trans);
                    }else{
                        /* Jika jumlah pembayaran lunas */
                        $trans = array(
                            'tgl_bayar'    => $tgl_bayar,
                            'tgl_modif'    => date('Y-m-d H:i:s'),
                            'jml_subtotal' => (float)$jml_gtotal,
                            'diskon'       => (float)$diskon,
                            'jml_diskon'   => (float)$jml_tot_disk,
                            'jml_biaya'    => (float)$jml_biaya,
                            'jml_gtotal'   => (float)$gtotal,
                            'jml_bayar'    => (float)$jml_bayar,
                            'jml_kembali'  => (float)$jml_kembali,
                            'status_bayar' => '1',
                            'status_nota'  => '3',
                            'metode_bayar' => $metode_byr,
                         );
                        
                        crud::update('tbl_trans_jual','id',$no_nota,$trans);
                    }
                }
                
//                echo '<pre>';
//                print_r($trans);
//                echo '</pre>';

                /* -- Simpan pemasukan ke tabel pemasukan -- */
                $kode_pm   = general::no_nota('', 'tbl_akt_kas', 'kode', "WHERE tipe='masuk'");
                $saldo_kas = $this->db->select('MAX(id) as id, MAX(saldo) as saldo')->get('tbl_akt_kas')->row();
                $sql_trans = $this->db->select('jml_gtotal, jml_bayar, jml_kurang, jml_kembali')->where('id', $sql_cek->id)->get('tbl_trans_jual')->row();
                $nominal   = $jml_bayar - $sql_trans->jml_kembali;
                $tot_saldo = $saldo_kas->saldo + ($nominal);
        
                $data_pemasukan = array(
                    'tgl_simpan' => $tgl_bayar,
                    'id_user'    => $this->ion_auth->user()->row()->id,
                    'kode'       => $kode_pm,
                    'keterangan' => 'Penjualan '.$sql_cek->kode_nota_dpn.$sql_cek->no_nota.'/'.$sql_cek->kode_nota_blk,
                    'nominal'    => (float)$nominal,
                    'kredit'     => (float)$nominal,
                    'saldo'      => (float)$tot_saldo,
                    'status_kas' => ($metode_byr > 1 ? 'bank' : 'kas'),
                    'tipe'       => 'masuk',
                );

                crud::simpan('tbl_akt_kas', $data_pemasukan);
                /* -- Simpan pemasukan ke tabel pemasukan -- */
                
                // Simpan platform pembayaran
                $data_platform = array(
                    'tgl_simpan'  => $tgl_bayar.' '.date('H:i'),
                    'id_platform' => $metode_byr,
                    'id_penjualan'=> $no_nota,
                    'no_nota'     => $sql_cek->no_nota,
                    'platform'    => (!empty($bank) ? $bank : '-'),
                    'keterangan'  => (!empty($no_kartu) ? $no_kartu : ''),
                    'nominal'     => (float)$jml_bayar,
                );

                // Cek di tabel platform supaya tidak dobel
                crud::simpan('tbl_trans_jual_plat',$data_platform);
                
                /* Cek Akhir Nota Jual */
                $sql_nota = $this->db->select('status_nota, status_bayar')->where('id', $sql_cek->id)->get('tbl_trans_jual')->row();
                /* -- Cek Akhir Nota Jual -- */
                $this->session->set_flashdata('transaksi', '<div class="alert alert-success">Transaksi berhasil disimpan</div>');
//                redirect(base_url('transaksi/'.($jml_kurang > 0 ? 'trans_bayar_jual' : ($jml_sisa_bayar <= 0 ? 'trans_jual_det' : 'trans_bayar_jual')).'.php?id='.general::enkrip($no_nota).''));
                redirect(base_url('transaksi/'.($sql_nota->status_bayar > 1 ? 'trans_bayar_jual' : 'trans_jual_det').'.php?id='.general::enkrip($no_nota).''));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_nota_jual_bayar_draft() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota      = $this->input->post('no_nota');
            $jml_total    = str_replace('.', '', $this->input->post('jml_total'));
            $jml_diskon   = str_replace('.', '', $this->input->post('jml_diskon'));
            $jml_diskon1  = str_replace('.', '', $this->input->post('jml_diskon1'));
            $jml_biaya    = str_replace('.', '', $this->input->post('jml_biaya'));
            $jml_ongkir   = str_replace('.', '', $this->input->post('jml_ongkir'));
            $jml_retur    = str_replace('.', '', $this->input->post('jml_retur'));
            $jml_subtotal = str_replace('.', '', $this->input->post('jml_subtotal'));
            $jml_ppn      = str_replace('.', '', $this->input->post('jml_ppn'));
            $jml_gtotal   = str_replace('.', '', $this->input->post('jml_gtotal'));
            $jml_bayar    = str_replace('.', '', $this->input->post('jml_bayar'));
            $jml_kembali  = str_replace('.', '', $this->input->post('jml_kembali'));
            $metode_byr   = $this->input->post('metode_bayar');
            $bank         = $this->input->post('bank');
            $no_kartu     = $this->input->post('no_kartu');
            $act          = $this->input->post('act');
            $rute         = $this->input->post('route');
            $cetak        = $this->input->post('cetak');
            $pengaturan   = $this->db->get('tbl_pengaturan')->row();

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('no_nota', 'no_nota', 'required');
            $this->form_validation->set_rules('jml_bayar', 'Jumlah Bayar', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg_error = array(
                    'no_nota'   => form_error('no_nota'),
                    'jml_bayar' => form_error('jml_bayar'),
                );

                $this->session->set_flashdata('form_error', $msg_error);
                
                redirect(base_url('transaksi/trans_jual_umum_draft.php?id='.$no_nota.'#pembayaran'));
            } else {
                $trans_jual     = $this->db->where('id', general::dekrip($no_nota))->get('tbl_trans_jual')->row();
                $trans_jual_det = $this->db->select('SUM(subtotal) AS total')->where('id_penjualan', $trans_jual->id)->get('tbl_trans_jual_det')->row();
                
                $jml_tot        = $trans_jual_det->total + $jml_diskon1;
                $jml_diskonnya  = $jml_diskon1 + $jml_diskon;
                $gtotal         = ($trans_jual->status_ppn == 1 ? $jml_gtotal : $jml_subtotal);
                $kembali        = $jml_bayar - $gtotal;
                
                // Cek jika jumlah bayar kurang dari jml_gtotal
                if($jml_bayar < $jml_gtotal){
                   $this->session->set_flashdata('transaksi', '<div class="alert alert-danger">Nominal pembayaran kurang dari tagihan</div>');
                   redirect(base_url('transaksi/'.(!empty($rute) ? $rute : 'trans_jual_umum').'.php?id='.general::enkrip($nota)));
                }else{
                   // Simpan penjualan ke tabel
                   $data_penj = array(
                       'jml_total'     => ceil((float)$jml_tot),
                       'jml_diskon'    => ceil((float)$jml_diskonnya),
                       'jml_biaya'     => ceil((float)$jml_biaya),
                       'jml_ongkir'    => ceil((float)$jml_ongkir),
                       'jml_subtotal'  => ceil((float)$jml_subtotal),
                       'jml_ppn'       => ($trans_jual->status_ppn == 1 ? ceil((float)$jml_ppn) : 0),
                       'jml_gtotal'    => ($trans_jual->status_ppn == 1 ? ceil((float)$jml_gtotal) : ceil((float)$jml_subtotal)),
                       'jml_bayar'     => ceil((float)$jml_bayar),
                       'jml_kembali'   => ceil((float)$kembali),
                       'jml_retur'     => ceil((float)$jml_retur),
                       'metode_bayar'  => $metode_byr,
                       'status_nota'   => '3',
                       'status_bayar'  => '1',
                       'status_ppn'    => (!empty($trans_jual->status_ppn) ? $trans_jual->status_ppn : '0'),
                       'status_jurnal' => '0',
                       'status_grosir' => '0'
                   );
                                   
                   crud::update('tbl_trans_jual', 'id', $trans_jual->id, $data_penj);
                        
                   // Simpan platform pembayaran
                   $jml_pembayaran = $jml_bayar - $jml_gtotal;
                   $data_platform = array(
                      'tgl_simpan'  => date('Y-m-d H:i:s'),
                      'id_penjualan'=> $trans_jual->id,
                      'id_platform' => $metode_byr,
                      'no_nota'     => $trans_jual->no_nota,
                      'platform'    => (!empty($bank) ? $bank : '-'),
                      'keterangan'  => (!empty($no_kartu) ? $no_kartu : ''),
                      'nominal'     => (float)$jml_bayar,
                   );
                   
                   crud::simpan('tbl_trans_jual_plat',$data_platform);
                  /* --- END Simpan platform pembayaran -- */
                   
                  /* -- Simpan pemasukan ke tabel pemasukan -- */
                  $kode_pm   = general::no_nota('', 'tbl_akt_kas', 'kode', "WHERE tipe='masuk'");
                  $saldo_kas = $this->db->select('MAX(id) as id, MAX(saldo) as saldo')->get('tbl_akt_kas')->row();
                  $sql_trans = $this->db->select('kode_nota_dpn, no_nota, kode_nota_blk, jml_gtotal, jml_bayar, jml_kurang, jml_kembali')->where('id', $last_id)->get('tbl_trans_jual')->row();
                  $nominal   = $jml_bayar - $sql_trans->jml_kembali;
                  $tot_saldo = $saldo_kas->saldo + ($nominal);
          
                  $data_pemasukan = array(
                      'tgl_simpan' => date('Y-m-d H:i:s'),
                      'id_user'    => $this->ion_auth->user()->row()->id,
                      'kode'       => $kode_pm,
                      'keterangan' => 'Penjualan '.$trans_jual->kode_nota_dpn.$trans_jual->no_nota.'/'.$trans_jual->kode_nota_blk,
                      'nominal'    => (float)$nominal,
                      'kredit'     => (float)$nominal,
                      'saldo'      => (float)$tot_saldo,
                      'status_kas' => ($metode_byr > 1 ? 'bank' : 'kas'),
                      'tipe'       => 'masuk',
                  );

                  crud::simpan('tbl_akt_kas', $data_pemasukan);
                  /* -- Simpan pemasukan ke tabel pemasukan -- */
                   
                   $this->session->set_flashdata('transaksi', '<div class="alert alert-success">Transaksi berhasil disimpan</div>');
                   if(!empty($cetak)){
                       redirect(base_url('transaksi/cetak_nota_termal.php?id='.$no_nota.''));
                   }else{
                       redirect(base_url('transaksi/'.(!empty($rute) ? $rute : 'trans_jual_det').'.php?id='.$no_nota.''));
                   }

//                   echo '<pre>';
//                   print_r($data_penj);
//                   echo '</pre>';
//                   echo '<pre>';
//                   print_r($data_platform);
//                   echo '</pre>';
//                   echo '<pre>';
//                   print_r($data_pemasukan);
//                   echo '</pre>';
                }
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_nota_batal() {
        if (akses::aksesLogin() == TRUE) {
            $id   = $this->input->get('id');
            $term = $this->input->get('term');
                        
            $this->session->unset_userdata('trans_'.$term);
            $this->session->unset_userdata('trans_'.$term.'_upd');
            if($term == 'jual_pen' OR $term == 'jual_po'){
                crud::delete('tbl_trans_'.$term, 'no_nota', general::dekrip($id));
            }
            $this->cart->destroy();
            redirect(base_url('transaksi/'.$this->input->get('route')));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_nota_batal_draft() {
        if (akses::aksesLogin() == TRUE) {
            $id   = $this->input->get('id');                        

            redirect(base_url('transaksi/trans_jual_hapus.php?id='.$id.'&route=set_nota_jual_umum.php'));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_retur_jual_batal() {
        if (akses::aksesLogin() == TRUE) {
            $id   = $this->input->get('id');
            $nota = $this->input->get('no_nota');
            
            $this->session->unset_userdata('trans_retur_jual');
            crud::delete('tbl_trans_retur_jual', 'id', general::dekrip($id));
            $this->cart->destroy();
            
            redirect(base_url('transaksi/trans_retur_jual.php?no_nota='.$nota));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_retur_beli_batal() {
        if (akses::aksesLogin() == TRUE) {
            $id     = $this->input->get('id');
            $nota   = $this->input->get('no_nota');
                       
            $this->session->unset_userdata('trans_retur_beli');
            crud::delete('tbl_trans_retur_beli', 'id', general::dekrip($id));
            $this->cart->destroy();

            redirect(base_url('transaksi/trans_retur_beli.php?no_nota='.$nota));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_cari_penj() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota   = $this->input->post('no_nota');
            $lokasi    = $this->input->post('cabang');
            $t_nota    = $this->input->post('tgl');
            $t_bayar   = $this->tanggalan->tgl_indo_sys($this->input->post('tgl_bayar'));
            $t_tempo   = $this->input->post('tgl_tempo');
            $customer  = $this->input->post('customer');
            $sales     = $this->input->post('sales');
            $id_user   = $this->ion_auth->user()->row()->id;
            $id_grup   = $this->ion_auth->get_users_groups()->row();
            
            
            $tg_nota  = explode('/', $t_nota);
            $tgl_nota = $tg_nota[2].'-'.$tg_nota[0].'-'.$tg_nota[1];
            $tg_tempo = explode('/', $t_tempo);
            $tgl_tempo= $tg_tempo[2].'-'.$tg_tempo[0].'-'.$tg_tempo[1];
            $nota      = explode('/', $no_nota);
            
//            $sql = $this->db->select('no_nota, kode_nota_dpn, kode_nota_blk, kode_nota_dpn, kode_nota_blk, DATE(tgl_masuk) as tgl_masuk, DATE(tgl_bayar) as tgl_bayar, DATE(tgl_keluar) as tgl_keluar, jml_total, jml_gtotal, ppn, jml_ppn, id_user, id_sales, id_pelanggan, status_nota, status_bayar')
//                           ->like('no_nota', substr($nota[0], 1))
////                           ->or_like('kode_nota_dpn', $nt, 'before')
////                           ->or_like('kode_nota_blk', $nt, 'after')
//                           ->like('DATE(tgl_masuk)', ($tgl_nota != '--' ? $tgl_nota : ''))
//                           ->like('DATE(tgl_keluar)', ($tgl_tempo != '--' ? $tgl_tempo : ''))
//                           ->like('id_pelanggan', $customer)
//                           ->like('id_sales', $sales)
//                           ->like('id_user', ($id_grup->name == 'superadmin' || $id_grup->name == 'owner' || $id_grup->name == 'owner' ? '' : $id_user))
//                           ->order_by('no_nota','desc')
//                           ->get('tbl_trans_jual')->num_rows();

            redirect(base_url('transaksi/data_penj_list.php?'.(!empty($no_nota) ? 'filter_nota='. substr($no_nota, 1) : '').(!empty($t_nota) ? '&filter_tgl='.$tgl_nota : '').(!empty($t_tempo) ? '&filter_tgl_tempo='.$tgl_tempo : '').(!empty($customer) ? '&filter_cust='.$customer : '').(!empty($sales) ? '&filter_sales='.$sales : '').(!empty($t_bayar) ? '&filter_tgl_bayar='.$t_bayar : '')));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_cari_penj_retur() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota   = $this->input->post('no_nota');
            $lokasi    = $this->input->post('cabang');
            $t_nota    = $this->input->post('tgl');
            $t_tempo   = $this->input->post('tgl_tempo');
            $customer  = $this->input->post('customer');
            $sales     = $this->input->post('sales');
            $id_user   = $this->ion_auth->user()->row()->id;
            $id_grup   = $this->ion_auth->get_users_groups()->row();
            
            
            $tg_nota  = explode('/', $t_nota);
            $tgl_nota = $tg_nota[2].'-'.$tg_nota[0].'-'.$tg_nota[1];
            $tg_tempo = explode('/', $t_tempo);
            $tgl_tempo= $tg_tempo[2].'-'.$tg_tempo[0].'-'.$tg_tempo[1];
            $nota      = explode('/', $no_nota);

            redirect(base_url('transaksi/data_retur_jual_list.php?'.(!empty($no_nota) ? 'filter_nota='. $no_nota : '').(!empty($t_nota) ? '&filter_tgl='.$tgl_nota : '').(!empty($t_tempo) ? '&filter_tgl_tempo='.$tgl_tempo : '').(!empty($customer) ? '&filter_cust='.$customer : '').(!empty($sales) ? '&filter_sales='.$sales : '')));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_cari_penj_retur_input() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota   = $this->input->post('no_nota');
            $lokasi    = $this->input->post('cabang');
            $t_nota    = $this->input->post('tgl');
            $t_tempo   = $this->input->post('tgl_tempo');
            $customer  = $this->input->post('customer');
            $sales     = $this->input->post('sales');
            $id_user   = $this->ion_auth->user()->row()->id;
            $id_grup   = $this->ion_auth->get_users_groups()->row();
            
            
            $tg_nota  = explode('/', $t_nota);
            $tgl_nota = $tg_nota[2].'-'.$tg_nota[0].'-'.$tg_nota[1];
            $tg_tempo = explode('/', $t_tempo);
            $tgl_tempo= $tg_tempo[2].'-'.$tg_tempo[0].'-'.$tg_tempo[1];
            $nota      = explode('/', $no_nota);

            redirect(base_url('transaksi/input_retur_jual.php?'.(!empty($no_nota) ? 'filter_nota='. substr($no_nota, 1) : '').(!empty($t_nota) ? '&filter_tgl='.$tgl_nota : '').(!empty($t_tempo) ? '&filter_tgl_tempo='.$tgl_tempo : '').(!empty($customer) ? '&filter_cust='.$customer : '').(!empty($sales) ? '&filter_sales='.$sales : '')));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_cari_penj_bayar() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota   = $this->input->post('no_nota');
            $lokasi    = $this->input->post('cabang');
            $t_nota    = $this->input->post('tgl');
            $t_tempo   = $this->input->post('tgl_tempo');
            $customer  = $this->input->post('customer');
            $sales     = $this->input->post('sales');
            
            /* -- Grup hak akses -- */
            $grup        = $this->ion_auth->get_users_groups()->row();
            $id_user     = $this->ion_auth->user()->row()->id;
            $id_grup     = $this->ion_auth->get_users_groups()->row();
            $pengaturan  = $this->db->get('tbl_pengaturan')->row();
            
            $tg_nota  = explode('/', $t_nota);
            $tgl_nota = $tg_nota[2].'-'.$tg_nota[0].'-'.$tg_nota[1];
            $tg_tempo = explode('/', $t_tempo);
            $tgl_tempo= $tg_tempo[2].'-'.$tg_tempo[0].'-'.$tg_tempo[1];
            $nota      = explode('/', $no_nota);
            
            $sql = $this->db->select('no_nota, kode_nota_dpn, kode_nota_blk, kode_nota_dpn, kode_nota_blk, DATE(tgl_masuk) as tgl_masuk, DATE(tgl_bayar) as tgl_bayar, DATE(tgl_keluar) as tgl_keluar, jml_total, jml_gtotal, ppn, jml_ppn, id_user, id_sales, id_pelanggan, status_nota, status_bayar')
                           ->where('status_bayar !=', '1')
                           ->like('no_nota', substr($nota[0], 1))
                           ->like('DATE(tgl_masuk)', ($tgl_nota != '--' ? $tgl_nota : ''))
                           ->like('DATE(tgl_keluar)', ($tgl_tempo != '--' ? $tgl_tempo : ''))
                           ->like('id_pelanggan', $customer)
                           ->like('id_sales', $sales)
                           ->like('id_user', ($id_grup->name == 'superadmin' || $id_grup->name == 'owner' ? '' : $id_user))
                           ->order_by('no_nota','desc')
                           ->get('tbl_trans_jual')->num_rows();

            redirect(base_url('transaksi/data_pemb_jual_list.php?'.(!empty($no_nota) ? 'filter_nota='. substr($no_nota, 1) : '').(!empty($t_nota) ? '&filter_tgl='.$tgl_nota : '').(!empty($t_tempo) ? '&filter_tgl_tempo='.$tgl_tempo : '').(!empty($customer) ? '&filter_cust='.$customer : '').(!empty($sales) ? '&filter_sales='.$sales : '').'&jml='.$sql));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_cari_penawaran() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota   = $this->input->post('no_nota');
            $lokasi    = $this->input->post('cabang');
            $t_nota    = $this->input->post('tgl');
            $t_tempo   = $this->input->post('tgl_tempo');
            $customer  = $this->input->post('customer');
            $sales     = $this->input->post('sales');
            
            $tg_nota  = explode('/', $t_nota);
            $tgl_nota = $tg_nota[2].'-'.$tg_nota[0].'-'.$tg_nota[1];
            $tg_tempo = explode('/', $t_tempo);
            $tgl_tempo= $tg_tempo[2].'-'.$tg_tempo[0].'-'.$tg_tempo[1];
            $nota      = explode('/', $no_nota);
            
            $sql = $this->db->select('no_nota, kode_nota_dpn, kode_nota_blk, kode_nota_dpn, kode_nota_blk, DATE(tgl_masuk) as tgl_masuk, DATE(tgl_bayar) as tgl_bayar, DATE(tgl_keluar) as tgl_keluar, jml_total, jml_gtotal, ppn, jml_ppn, id_user, id_sales, id_pelanggan, status_nota, status_bayar')
                           ->like('no_nota', substr($nota[0], 1))
//                           ->or_like('kode_nota_dpn', $nt, 'before')
//                           ->or_like('kode_nota_blk', $nt, 'after')
                           ->like('DATE(tgl_masuk)', ($tgl_nota != '--' ? $tgl_nota : ''))
                           ->like('DATE(tgl_keluar)', ($tgl_tempo != '--' ? $tgl_tempo : ''))
                           ->like('id_pelanggan', $customer)
                           ->like('id_sales', $sales)
                           ->order_by('no_nota','desc')
                           ->get('tbl_trans_jual_pen')->num_rows();

            redirect(base_url('transaksi/data_pen_list.php?'.(!empty($no_nota) ? 'filter_nota='. substr($no_nota, 1) : '').(!empty($t_nota) ? '&filter_tgl='.$tgl_nota : '').(!empty($t_tempo) ? '&filter_tgl_tempo='.$tgl_tempo : '').(!empty($customer) ? '&filter_cust='.$customer : '').(!empty($sales) ? '&filter_sales='.$sales : '').'&jml='.$sql));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
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
            $supplier  = $this->input->post('cari_supplier');
            $sb        = $this->input->post('filter_bayar');
            $rute      = $this->input->post('route');
            $tgl       = explode('/', $tgl_trans);
            
            redirect(base_url('transaksi/data_pembelian_list'.(!empty($rute) ? '_tempo' : '').'.php?'.(!empty($rute) ? 'route=tempo&' : '').(!empty($no_nota) ? 'filter_nota='.$no_nota : '').(!empty($lokasi) ? '&filter_lokasi='.$lokasi : '').(!empty($tgl_trans) ? '&filter_tgl='.$tgl[2] . '-' . $tgl[0] . '-' . $tgl[1] : '').(!empty($tgl_tempo) ? '&filter_tgl_tempo='.$this->tanggalan->tgl_indo_sys($tgl_tempo) : '').(!empty($supplier) ? '&filter_supplier='.$supplier : '').(!empty($tgl_bayar) ? '&filter_tgl_bayar='.$this->tanggalan->tgl_indo_sys($tgl_bayar) : '').(isset($sb) && !empty($sb) ? '&filter_bayar='.$sb : '')));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_cari_pemb_retur() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota   = $this->input->post('no_nota');
            $lokasi    = $this->input->post('cabang');
            $tgl_trans = $this->input->post('tgl');
            $tgl_tempo = $this->input->post('tgl_tempo');
            $tgl_bayar = $this->input->post('tgl_bayar');
            $supplier  = $this->input->post('cari_supplier');
            $sb        = $this->input->post('filter_bayar');
            $rute      = $this->input->post('route');
            $tgl       = explode('/', $tgl_trans);
            
            redirect(base_url('transaksi/input_retur_beli.php?'.(!empty($no_nota) ? 'filter_nota='.$no_nota : '?').(!empty($lokasi) ? 'filter_lokasi='.$lokasi.'&' : '').(!empty($tgl_trans) ? 'filter_tgl='.$tgl[2] . '-' . $tgl[0] . '-' . $tgl[1].'&' : '').(!empty($tgl_tempo) ? 'filter_tgl_tempo='.$this->tanggalan->tgl_indo_sys($tgl_tempo).'&' : '').(!empty($supplier) ? 'filter_supplier='.$supplier.'&' : '').(!empty($tgl_bayar) ? 'filter_tgl_bayar='.$this->tanggalan->tgl_indo_sys($tgl_bayar).'&' : '').(isset($sb) && !empty($sb) ? 'filter_bayar='.$sb.'&' : '')));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_cari_pemb_bayar() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota   = $this->input->post('no_nota');
            $lokasi    = $this->input->post('cabang');
            $tgl_trans = $this->input->post('tgl');
            $tgl_tempo = $this->input->post('tgl_tempo');
            $tgl_bayar = $this->input->post('tgl_bayar');
            $supplier  = $this->input->post('cari_supplier');
            $tgl       = explode('/', $tgl_trans);
            
            redirect(base_url('transaksi/data_pemb_beli_list.php?'.(!empty($no_nota) ? 'filter_nota='.$no_nota : '').(!empty($lokasi) ? '&filter_lokasi='.$lokasi : '').(!empty($tgl_trans) ? '&filter_tgl='.$tgl[2] . '-' . $tgl[0] . '-' . $tgl[1] : '').(!empty($tgl_tempo) ? '&filter_tgl_tempo='.$this->tanggalan->tgl_indo_sys($tgl_tempo) : '').(!empty($supplier) ? '&filter_supplier='.$supplier : '').(!empty($tgl_bayar) ? '&filter_tgl_bayar='.$this->tanggalan->tgl_indo_sys($tgl_bayar) : '')));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_cari_po() {
        if (akses::aksesLogin() == TRUE) {
            $no_nota  = $this->input->post('no_nota');
            $lokasi   = $this->input->post('cabang');
            $tanggal  = $this->input->post('tgl');
            $supplier = $this->input->post('cari_supplier');
            $tgl      = explode('/', $tanggal);
            
            redirect(base_url('gudang/data_po_list.php?'.(!empty($no_nota) ? 'filter_nota='.$no_nota : '').(!empty($lokasi) ? '&filter_lokasi='.$lokasi : '').(!empty($tanggal) ? '&filter_tgl='.$tgl[2] . '-' . $tgl[0] . '-' . $tgl[1] : '').(!empty($supplier) ? '&filter_supplier='.$supplier : '')));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function set_edit_ppn() {
        if (akses::aksesLogin() == TRUE) {
            $ppn = $this->input->post('ppn');
            echo json_encode(array('response' => $ppn));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function hapus_nota_jual() {
        if (akses::aksesLogin() == TRUE) {
            $id  = $this->input->get('id');

            if(!empty($id)){
                $sql_nota = $this->db->where('id', general::dekrip($id))->get('tbl_trans_jual')->row();
                $nota     = $sql_nota->no_nota.'/'.$sql_nota->kode_nota_blk;
                $sql_mut  = $this->db->where('keterangan', 'Penjualan '.$nota)->get('tbl_m_produk_hist')->row();

//                crud::delete('tbl_trans_jual','id',general::dekrip($id));
            }
            
            redirect(base_url('transaksi/data_penj_list.php'));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function hapus_nota_beli() {
        if (akses::aksesLogin() == TRUE) {
            $id  = $this->input->get('id');
            
            if(!empty($id)){
//                crud::delete('tbl_trans_beli','id',general::dekrip($id));
//                crud::delete('tbl_m_produk_hist','id_pembelian',general::dekrip($id));
            }
            redirect(base_url('transaksi/data_penj_list.php'));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function hapus_nota_retur_beli() {
        if (akses::aksesLogin() == TRUE) {
            $id  = $this->input->get('id');
            
            if(!empty($id)){
                $sql_ret  = $this->db->where('id', general::dekrip($id))->get('tbl_trans_retur_beli')->row();
                $sql_retd = $this->db->where('id_retur_beli', $sql_ret->id)->get('tbl_trans_retur_beli_det')->result();
                
                foreach($sql_retd as $retur){
                    $sql_hist = $this->db->where('kode', $retur->kode)->where('status', '5')->get('tbl_m_produk_hist')->row();
                    $sql_prd  = $this->db->where('kode', $retur->kode)->get('tbl_m_produk')->row();
                    $jml      = $sql_prd->jml + ($sql_hist->jml * $sql_hist->jml_satuan);
                    
                    crud::update('tbl_m_produk', 'id', $sql_prd->id, array('jml'=>$jml));
                    crud::delete('tbl_m_produk_hist', 'id', $sql_hist->id);
                    
                }
                crud::delete('tbl_trans_retur_beli','id', $sql_ret->id);
            }
            redirect(base_url('transaksi/data_retur_beli_list.php'));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    
    public function json_supplier() {
        if (akses::aksesLogin() == TRUE) {
            $term  = $this->input->get('term');
            $sql   = $this->db->select('id, kode, nama')->like('nama',$term)->or_like('kode',$term)->get('tbl_m_supplier')->result();
            
            if(!empty($sql)){
                foreach ($sql as $sql){
                    $produk[] = array(
                        'id'   => $sql->id,
                        'kode' => $sql->kode,
                        'nama' => $sql->nama,
                    );
                }
                echo json_encode($produk);
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function json_customer() {
        if (akses::aksesLogin() == TRUE) {
            $term  = $this->input->get('term');
            $sql   = $this->db->select('id, nik, nama, nama_toko')->like('nama',$term)->or_like('nama_toko',$term)->get('tbl_m_pelanggan')->result();
            if(!empty($sql)){
                foreach ($sql as $sql){
                    $produk[] = array(
                        'id'         => $sql->id,
                        'nik'        => $sql->nik,
                        'nama'       => $sql->nama,
                        'nama_toko'  => $sql->nama_toko,
                    );
                }
                echo json_encode($produk);
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function json_sales() {
        if (akses::aksesLogin() == TRUE) {
            $term  = $this->input->get('term');
            $sql   = $this->db->select('id, kode, nama')->like('nama',$term)->get('tbl_m_sales')->result();
            if(!empty($sql)){
                foreach ($sql as $sql){
                    $produk[] = array(
                        'id'   => $sql->id,
                        'kode' => $sql->kode,
                        'nama' => $sql->nama,
                    );
                }
                echo json_encode($produk);
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function json_barang() {
        if (akses::aksesLogin() == TRUE) {
            $term  = $this->input->get('term');
            $sql   = $this->db->select('tbl_m_produk.id, tbl_m_produk.id_satuan, tbl_m_produk.kode, tbl_m_produk.produk, tbl_m_produk.jml, tbl_m_produk.harga_jual, tbl_m_produk.harga_beli, tbl_m_produk.harga_beli')
//                              ->join('tbl_m_satuan','tbl_m_satuan.id=tbl_m_produk.id_satuan')
                              ->where("(tbl_m_produk.produk LIKE '%".$term."%' OR tbl_m_produk.kode LIKE '%".$term."' OR tbl_m_produk.barcode LIKE '".$term."')")
//                              ->like('tbl_m_produk.produk', $term,'')->or_like('tbl_m_produk.kode',$term, 'match')->or_like('tbl_m_produk.barcode',$term, 'match')
                              ->order_by('tbl_m_produk.jml', ($_GET['mod'] == 'beli' ? 'asc' : 'desc'))
                              ->get('tbl_m_produk')->result();
            $sg    = $this->ion_auth->user()->row()->status_gudang;
            
            if(!empty($sql)){
                foreach ($sql as $sql){
                    $sql_satuan = $this->db->select('*')->where('id', $sql->id_satuan)->get('tbl_m_satuan')->row();
                    $sql_stok   = $this->db->select('SUM(jml * jml_satuan) AS jml')->where('id_produk', $sql->id)->where('id_gudang', $sg)->get('tbl_m_produk_stok')->row();
                    
                    if($_GET['mod'] == 'beli'){
                        $produk[] = array(
                            'id'        	=> general::enkrip($sql->id),
                            'kode'      	=> $sql->kode,
                            'produk'    	=> $sql->produk,
                            'jml'       	=> $sql_stok->jml,
                            'satuan'    	=> $sql_satuan->satuan,
                            'harga'     	=> number_format($sql->harga_jual, 0, ',', '.'),
                            'harga_beli'	=> number_format($sql->harga_beli, 0, ',', '.'),
                            'harga_grosir'	=> number_format($sql->harga_grosir, 0, ',', '.'),
                        );
                    }else{
                        if($sql_stok->jml > 0){
                            $produk[] = array(
                                'id'            => general::enkrip($sql->id),
                                'kode'          => $sql->kode,
                                'produk'        => $sql->produk,
                                'jml'           => $sql_stok->jml.' '.$sql_satuan->satuanTerkecil,
                                'satuan'        => $sql_satuan->satuan,
                                'harga'         => number_format($sql->harga_jual, 0, ',', '.'),
                                'harga_beli'    => number_format($sql->harga_beli, 0, ',', '.'),
                                'harga_grosir'	=> number_format($sql->harga_grosir, 0, ',', '.'),
                            );                            
                        }
                    }
                }
                
                echo json_encode($produk);
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function json_barang_sat() {
        if (akses::aksesLogin() == TRUE) {
            $term  = $this->input->get('term');
            $sql   = $this->db->select('tbl_m_produk.id, tbl_m_produk_satuan.satuan, tbl_m_produk_satuan.jml, tbl_m_produk_satuan.harga')
                              ->join('tbl_m_produk', 'tbl_m_produk.id=tbl_m_produk_satuan.id_produk')
                              ->where('tbl_m_produk_satuan.id_produk', $this->input->get('id'))
                              ->where('tbl_m_produk_satuan.satuan', $this->input->get('satuan'))
                              ->get('tbl_m_produk_satuan')->result();
            if(!empty($sql)){
                foreach ($sql as $sql){
                    $produk = array(
                        'id'     => $sql->id,
                        'satuan' => $sql->satuan,
                        'jml'    => $sql->jml,
                        'harga'  => general::format_angka($sql->harga),
                    );
                }
                
                echo json_encode($produk);
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function json_platform() {
        if (akses::aksesLogin() == TRUE) {
            $term  = $this->input->get('term');
            $sql   = $this->db->select('*')
                              ->where('id', $this->input->get('id'))
                              ->get('tbl_m_platform')->result();
            if(!empty($sql)){
                foreach ($sql as $sql){
                    $produk = array(
                        'id'       => $sql->id,
                        'platform' => $sql->platform,
                        'persen'   => (int)$sql->persen,
                    );
                }
                
                echo json_encode($produk);
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
}