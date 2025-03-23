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
        $this->load->library('qrcode/ciqrcode');
        $this->load->model('crud');
    }

    /**
     * Main dashboard view
     * 
     * Displays the main dashboard with various statistics and information
     * including sales, purchases, and product data
     */
    public function index() {
//        if (akses::aksesLogin() == TRUE) {
        $pengaturan = $this->db->get('tbl_pengaturan')->row();
        $userid = $this->ion_auth->user()->row()->id;
        $id_grup = $this->ion_auth->get_users_groups()->row();
        $id_user = ($id_grup->name == 'superadmin' || $id_grup->name == 'owner' ? '' : $userid);
        $sql_penj = $this->db->select('SUM(jml_gtotal) as nominal')->like('id_user', $id_user)->get('tbl_trans_jual')->row();
        $sql_pemb = $this->db->select('SUM(jml_gtotal) as nominal')->get('tbl_trans_beli')->row();

        $data['tgl_tempo'] = date('Y-m-d', mktime(0, 0, 0, date("n"), date("j") + 1, date("Y")));

        $data['prod_new'] = $this->db->select('id, id_satuan, kode, produk, SUM((jml * jml_satuan)) AS jml')->limit(5)->group_by('produk')->order_by('jml', 'desc')->get('tbl_trans_jual_det')->result();
        $data['trans_new'] = $this->db->select('DATE(tgl_simpan) as tgl_simpan, id, id_sales, id_pelanggan, kode_nota_dpn, no_nota, kode_nota_blk, jml_gtotal')->like('id_user', $id_user)->limit(10)->order_by('no_nota', 'desc')->get('tbl_trans_jual')->result();
        $data['trans_jml'] = $this->db->like('id_user', $id_user)->get('tbl_trans_jual')->num_rows();
        $data['trans_jual_tmp'] = $this->db->query("SELECT id, no_nota, tgl_keluar FROM tbl_trans_jual WHERE DATEDIFF(tgl_keluar, CURDATE()) >= 0 AND DATEDIFF(tgl_keluar, CURDATE()) <= '" . $pengaturan->jml_limit_tempo . "' AND `tgl_masuk` != `tgl_keluar`");
        $data['trans_beli_new'] = $this->db->select('DATE(tgl_simpan) as tgl_simpan, id, id_supplier, id_user, no_nota, jml_gtotal')->like('id_user', $id_user)->limit(10)->order_by('id', 'desc')->get('tbl_trans_beli')->result();
        $data['trans_beli_jml'] = $this->db->like('id_user', $id_user)->get('tbl_trans_beli')->num_rows();
        $data['trans_beli_tmp'] = $this->db->query("SELECT id, no_nota, tgl_keluar FROM tbl_trans_beli WHERE status_bayar != '1' AND DATEDIFF(tgl_keluar, CURDATE()) >= 0 AND DATEDIFF(tgl_keluar, CURDATE()) <= '" . $pengaturan->jml_limit_tempo . "' AND `tgl_masuk` != `tgl_keluar`");
        $data['prod_jml'] = $this->db->select('jml')->where('jml <', $pengaturan->jml_limit_stok)->get('tbl_m_produk')->num_rows();
        $data['pem_jml'] = $this->db->select('SUM(jml_gtotal) as nominal')->where('MONTH(tgl_masuk)', date('m'))->where('YEAR(tgl_masuk)', date('Y'))->like('id_user', $id_user)->get('tbl_trans_jual')->row();
        $data['pem_jml_thn'] = $this->db->select('SUM(jml_gtotal) as nominal')->where('YEAR(tgl_masuk)', date('Y'))->like('id_user', $id_user)->get('tbl_trans_jual')->row();
        $data['pemb_jml'] = $this->db->select('SUM(jml_gtotal) as nominal')->like('id_user', $id_user)->get('tbl_trans_beli')->row();
        $data['pemb_jml_thn'] = $this->db->select('SUM(jml_gtotal) as nominal')->where('YEAR(tgl_masuk)', date('Y'))->like('id_user', $id_user)->get('tbl_trans_beli')->row();
        $data['tot_laba'] = $sql_penj->nominal - $sql_pemb->nominal;
        $data['user_id'] = $id_user;
        $data['pengaturan'] = $this->db->get('tbl_pengaturan')->row();

        $this->load->view('admin-lte-2/1_atas', $data);
        $this->load->view('admin-lte-2/2_header', $data);
        $this->load->view('admin-lte-2/3_navbar', $data);
        $this->load->view('admin-lte-2/content', $data);
        $this->load->view('admin-lte-2/5_footer', $data);
        $this->load->view('admin-lte-2/6_bawah', $data);
//        } else {
//            $errors = $this->ion_auth->messages(); 
//            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
//            redirect();
//        }
    }

    /**
     * Secondary dashboard view
     * 
     * Displays an alternative dashboard view with room labels,
     * capacity information, and staff schedules
     */
    public function index2() {
        if (akses::aksesLogin() == TRUE) {
            $data['kmr_label']      = $this->crud->kmr_label();
            $data['kmr_kaps']       = $this->crud->kmr_kapasitas();
            $data['sql_kamar']      = $this->db->get('v_trans_kamar')->result();
            $data['sql_kary_jdwl']  = $this->db->select('tbl_m_karyawan.nama_dpn, tbl_m_karyawan.nama, tbl_m_karyawan.nama_blk, tbl_m_poli.lokasi, tbl_m_karyawan_jadwal.hari_1, tbl_m_karyawan_jadwal.hari_2, tbl_m_karyawan_jadwal.hari_3, tbl_m_karyawan_jadwal.hari_4, tbl_m_karyawan_jadwal.hari_5, tbl_m_karyawan_jadwal.hari_6, tbl_m_karyawan_jadwal.hari_7, tbl_m_karyawan_jadwal.waktu')
                                               ->join('tbl_m_karyawan', 'tbl_m_karyawan.id=tbl_m_karyawan_jadwal.id_karyawan')
                                               ->join('tbl_m_poli', 'tbl_m_poli.id=tbl_m_karyawan_jadwal.id_poli')
                                               ->get('tbl_m_karyawan_jadwal')->result();
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
     * Test function for queue system
     * 
     * Displays queue system base path and room information
     */
    public function tes() {
        echo BASE_ANTRIAN;
        echo br();
        echo realpath('../'.BASE_ANTRIAN.'/scale/audio');
        $sql = $this->db->select('id, kode, kamar, jml_max')->where('status', '1')->get('tbl_m_kamar')->result();
        
        $data = [];
        foreach ($sql as $kmr){
            $data[] = $kmr->kamar;
        }
        
        echo '<pre>';
        print_r($sql);
        echo '</pre>';
        echo '<pre>';
        print_r(json_encode($data));
        echo '</pre>';
    }
    
    /**
     * Test function for product reset
     * 
     * Checks and displays product validation information
     */
    public function tes1_resetprod() {
        $sql_prod = $this->db->get('tbl_trans_medcheck')->num_rows();
        $qr_validasi = FCPATH . 'qr_validasi/';
        
        echo $qr_validasi;
        
        if(file_exists($qr_validasi)){
            echo br();
            echo 'ada';
        }
    }

    /**
     * Test function for product count
     * 
     * Displays the total number of medical check transactions
     */
    public function tes2() {
        $sql_prod = $this->db->get('tbl_trans_medcheck')->num_rows();
        echo $sql_prod;
    }

    /**
     * Test function for module access
     * 
     * Displays current controller and method information
     */
    public function tes3() {
        $grup   = $this->ion_auth->get_users_groups()->row();
        $db     = $this->db->where('modules', 'transaksi')->order_by('sort', 'ASC')->get('tbl_ion_modules')->result();
        $class  = $this->router->fetch_class();
        $funct  = $this->router->fetch_method();

        echo '<pre>';
        echo json_encode($class, JSON_PRETTY_PRINT);
        echo '</pre>';
    }

    /**
     * Test function for product code update
     * 
     * Updates product codes based on category information
     */
    public function tes4() {
        $db = $this->db->where('kode', '--')->get('tbl_m_produk')->result();
        $data = [];

        foreach ($db as $akses) {
            $sql_kat = $this->db->where('id', $akses->id_kategori)->get('tbl_m_produk')->row();
            
            $kode = $sql_kat->kategori.$akses->id;
            $this->crud->update('tbl_m_produk', 'id', $akses, array('tgl_modif'=>date('Y-m-d H:i:s'),'kode'=>$kode));
        }

        echo json_encode($data, JSON_PRETTY_PRINT);
    }

    /**
     * Test function for group access
     * 
     * Displays group access information in JSON format
     */
    public function tes5() {
        $grup       = $this->ion_auth->get_users_groups()->row();
        $grup_jn    = $this->ion_auth->group($grup->id)->row();
        $akses      = json_decode($grup_jn->akses);

        echo $grup->id;
        echo '<pre>';
        print_r(json_decode($grup_jn, JSON_PRETTY_PRINT));
        echo '</pre>';
    }

    /**
     * Test function for QR code generation
     * 
     * Generates and displays a sample QR code
     */
    public function tes6() {
        $params['data'] = 'This is a text to encode become QR Code';
        $params['level'] = 'H';
        $params['size'] = 4;
        $params['savename'] = FCPATH . 'tes.png';
        $this->ciqrcode->generate($params);

        echo '<img src="'.base_url().'tes.png" />';
    }

    /**
     * Test function for remuneration calculation
     * 
     * Updates remuneration data for medical check transactions by calculating
     * remuneration amounts based on percentages and fixed values
     * 
     * @return void
     */
    public function tes7() {
        $sql = $this->db->where('remun_tipe', '1')->get('tbl_trans_medcheck_remun')->result();
        
        foreach ($sql as $lab) {
            $sql_itm = $this->db->where('id', $lab->id_item)->get('tbl_m_produk')->row();
            if (!$sql_itm) continue;
            
            $remun_nom = ($sql_itm->remun_perc / 100) * $lab->harga;
            
            $data = array(
                'tgl_simpan'        => $lab->tgl_simpan,
                'id_medcheck'       => $lab->id_medcheck,
                'id_medcheck_det'   => $lab->id,
                'id_item'           => $lab->id_item,
                'id_dokter'         => $lab->id_dokter,
                'harga'             => (float)$lab->harga,
                'jml'               => (float)$lab->jml,
                'remun_tipe'        => (float)$sql_itm->remun_tipe,
                'remun_perc'        => (float)$sql_itm->remun_perc,
                'remun_nom'         => (float)($sql_itm->remun_tipe == '1' ? $remun_nom : $sql_itm->remun_nom),
            );
            
            $this->crud->update('tbl_trans_medcheck_remun', 'id', $lab->id, $data);
        }
    }

    /**
     * Test function for medical check data
     * 
     * Updates medical check data with additional information including
     * patient and doctor details
     * 
     * @return void
     */
    public function tes8() {
        $sql = $this->db->order_by('id', 'ASC')->get('tbl_trans_medcheck')->result();
        
        foreach ($sql as $med) {
            if (!$med) continue;
            
            $sql_pasien = $this->db->where('id', $med->id_pasien)->get('tbl_m_pasien')->row();
            $sql_dokter = $this->db->where('id', $med->id_dokter)->get('tbl_m_karyawan')->row();
            
            if (!$sql_pasien || !$sql_dokter) continue;
            
            $data = array(
                'tgl_simpan'        => $med->tgl_simpan,
                'id_pasien'         => $med->id_pasien,
                'id_dokter'         => $med->id_dokter,
                'no_nota'           => $med->no_nota,
                'jml_gtotal'        => (float)$med->jml_gtotal,
                'pasien'            => $sql_pasien->nama_dpn.' '.$sql_pasien->nama.' '.$sql_pasien->nama_blk,
                'dokter'            => $sql_dokter->nama_dpn.' '.$sql_dokter->nama.' '.$sql_dokter->nama_blk,
            );
            
            $this->crud->update('tbl_trans_medcheck', 'id', $med->id, $data);
        }
    }

    /**
     * Test function for purchase data
     * 
     * Updates purchase data with additional information including
     * supplier and user details
     * 
     * @return void
     */
    public function tes9() {
        $sql = $this->db->order_by('id', 'ASC')->get('tbl_trans_beli')->result();
        
        foreach ($sql as $beli) {
            if (!$beli) continue;
            
            $sql_supplier = $this->db->where('id', $beli->id_supplier)->get('tbl_m_supplier')->row();
            $sql_user = $this->db->where('id', $beli->id_user)->get('tbl_m_karyawan')->row();
            
            if (!$sql_supplier || !$sql_user) continue;
            
            $data = array(
                'tgl_simpan'        => $beli->tgl_simpan,
                'id_supplier'       => $beli->id_supplier,
                'id_user'           => $beli->id_user,
                'no_nota'           => $beli->no_nota,
                'jml_gtotal'        => (float)$beli->jml_gtotal,
                'supplier'          => $sql_supplier->nama,
                'user'              => $sql_user->nama_dpn.' '.$sql_user->nama.' '.$sql_user->nama_blk,
            );
            
            $this->crud->update('tbl_trans_beli', 'id', $beli->id, $data);
        }
    }

    // Set Data Karyawan
    public function tes10() {
        $sql = $this->db->order_by('id', 'ASC')->get('tbl_trans_beli')->result();
        $data = [];
        
        foreach ($sql as $beli){
            $sql_supplier = $this->db->where('id', $beli->id_supplier)->get('tbl_m_supplier')->row();
            $sql_user = $this->db->where('id', $beli->id_user)->get('tbl_m_karyawan')->row();
            
            $data = array(
                'tgl_simpan'        => $beli->tgl_simpan,
                'id_supplier'       => $beli->id_supplier,
                'id_user'           => $beli->id_user,
                'no_nota'           => $beli->no_nota,
                'jml_gtotal'        => (float)$beli->jml_gtotal,
                'supplier'          => $sql_supplier->nama,
                'user'              => $sql_user->nama_dpn.' '.$sql_user->nama.' '.$sql_user->nama_blk,
            );
            
            $this->crud->update('tbl_trans_beli', 'id', $beli->id, $data);
            
            echo '<pre>';
            print_r($data);
            echo '</pre>';
        }
    }

    // Set Data Remun
    public function tes11() {
        $sql = $this->db->order_by('id', 'ASC')->get('tbl_trans_beli_po')->result();
        
        $no = 1000;
        foreach ($sql as $lab){ 
            $sql_supp = $this->db->where('id', $lab->id_supplier)->get('tbl_m_supplier')->row();
            
            echo $sql_supp->nama;
            echo br();
            
            crud::update('tbl_trans_beli_po', 'id', $lab->id, array('supplier'=>strtoupper($sql_supp->nama)));
            
            $no++;
        }
        
    }

    // Reset Akun
    public function tes12() {
        $sql = $this->db->where('sp', '0')->group_by('DATE(tgl_simpan)')->get('tbl_trans_medcheck')->result();
        
        $no = 1;
        foreach ($sql as $lab){ 
            $sql2 = $this->db->where('sp', '0')->group_by('DATE(tgl_simpan)')->get('tbl_trans_medcheck')->result();
            
            $no_akun    = strtoupper(date('Mdy').sprintf('%04d', $str_akun));
            
            echo $sql_pas->nama_pgl;
            echo br();
            
//            crud::update('tbl_m_produk', 'id', $lab->id, array('kode'=>$kode));
//            crud::update('tbl_trans_beli_po', 'id', $lab->id, array('supplier'=>strtoupper($sql_supp->nama)));
            
            $no++;
        }
    }

    // Set Data Remun Pasien di upload
    public function tes13() {
        $sql = $this->db->where('id_resep_det', '13113')->get('tbl_trans_medcheck_resep_det_rc')->result();
        
        echo '<pre>';
        print_r(json_encode($sql));
        echo '</pre>';
        
//        foreach ($sql as $det){
//            $sql_produk = $this->db->where('id', $lab->id_item)->get('tbl_m_produk')->row();
//            echo $sql_produk->produk;
//            echo br();
////            crud::update('tbl_trans_medcheck_remun', 'id', $det->id, array('produk'=>$sql_produk->produk));
//        }
        
        
//        $no = 1000;
//        foreach ($sql as $lab){ 
////            $sql_medc = $this->db->where('id', $lab->id_produk)->get('tbl_m_produk')->row();
//            
//            $data[] = array(
//                'id_medcheck'   => (int)$lab->id_medcheck,
//                'id_resep'      => (int)$lab->id_resep,
//                'id_item'       => (int)$lab->id_item,
//                'id_item_kat'   => (int)$lab->id_item_kat,
//                'id_item_sat'   => (int)$lab->id_item_sat,
//                'kode'          => $lab->kode,
//                'item'          => $lab->item,
//                'dosis'         => $cart['options']['dos_jml1'].' '.$cart['options']['dos_sat'].' Tiap '.$cart['options']['dos_jml2'].' '.$cart['options']['dos_wkt'],
//                'dosis_ket'     => $cart['options']['dos_ket'],
//                'harga'         => $cart['options']['harga'],
//                'jml'           => (int)$cart['qty'],
//                'jml_satuan'    => '1',
//                'satuan'        => $cart['options']['satuan'],
//                'status'        => (int)$status,
//            );
//            
////            crud::update('tbl_m_produk', 'id', $lab->id, array('kode'=>$kode));
//            
////            crud::update('tbl_trans_beli_po', 'id', $lab->id, array('supplier'=>strtoupper($sql_supp->nama)));
//            
//            $no++;
//        }
        
    }

    // Reset Remun
    public function tes14_reset() {
        $sql = $this->db->order_by('id', 'ASC')->get('tbl_m_pasien')->result();
        
        foreach ($sql as $pas) {
            if (!$pas) continue;
            
            $sql_akun = $this->db->where('id', $pas->id_akun)->get('tbl_m_akun')->row();
            if (!$sql_akun) continue;
            
            $str_akun = $sql_akun->nama ?? '';
            
            $data = array(
                'tgl_simpan'        => $pas->tgl_simpan,
                'id_akun'           => $pas->id_akun,
                'nama_dpn'          => $pas->nama_dpn ?? '',
                'nama'              => $pas->nama ?? '',
                'nama_blk'          => $pas->nama_blk ?? '',
                'alamat'            => $pas->alamat,
                'no_telp'           => $pas->no_telp,
                'no_hp'             => $pas->no_hp,
                'email'             => $pas->email,
                'tgl_lahir'         => $pas->tgl_lahir,
                'jenis_kelamin'     => $pas->jenis_kelamin,
                'status'            => $pas->status,
                'akun'              => $str_akun,
                'pasien'            => ($pas->nama_dpn ?? '').' '.($pas->nama ?? '').' '.($pas->nama_blk ?? ''),
            );
            
            $this->crud->update('tbl_m_pasien', 'id', $pas->id, $data);
        }
    }

    // Set Data Remun Pasien di upload
    public function tes15() {
        $this->load->library('cart');
        
        
        echo '<pre>';
        print_r($this->session->all_userdata());
        echo '</pre>';
        
        $sql = $this->db->where('status', '4')->limit(25)->get('tbl_m_produk')->result();
        $no = 1;
        foreach ($sql as $item){
                $cart = array(
                    'id'      => rand(1,1024).$item->id,
                    'qty'     => 1,
                    'price'   => $item->harga_jual, // number_format($harga, 2, '.',','),
                    'name'    => rtrim($item->produk),
                    'options' => array(
                            'no'            => $no++,
                            'id_barang'     => $item->id,
                            'id_satuan'     => $item->id_satuan,
                            'kode'          => $item->kode,
                    )
                );
                
//                $this->cart->insert($cart);
//            echo '<pre>';
//            print_r($cart);
//            echo '</pre>';
        }
        $this->cart->destroy();
        
    }

    // Reset Stok Keluar
    public function tes16_so() {
        
        $sql = $this->db->where('sp', '0')->order_by('id', 'ASC')->get('tbl_util_so_det')->result();
        $no = 1;
        foreach ($sql as $item){
            $sql_so        = $this->db->where('id', $item->id_so)->get('tbl_util_so')->row();
            $sql_item      = $this->db->where('id', $item->id_produk)->get('tbl_m_produk')->row();
            $sql_satuan    = $this->db->where('id', $sql_item->id_satuan)->get('tbl_m_satuan')->row();
            
            $data_penj_hist = array(
                'id'            => $no++,
                'tgl_simpan'    => $item->tgl_simpan,
                'tgl_masuk'     => $sql_so->tgl_simpan,
                'id_so'         => $item->id_so,
                'id_gudang'     => '1',
                'id_produk'     => $item->id_produk,
                'id_user'       => $sql_so->id_user,
                'no_nota'       => 'SO'.sprintf('%04d', $sql_so->id),
                'kode'          => $sql_item->kode,
                'produk'        => $sql_item->produk,
                'keterangan'    => $sql_so->keterangan,
                'jml'           => (int)$item->jml,
                'jml_satuan'    => (!empty($sql_satuan->jml) ? (int)$sql_satuan->jml : '1'),
                'satuan'        => $sql_satuan->satuanTerkecil,
                'nominal'       => (float)$item->harga,
                'status'        => '6'
            );
            
//            crud::simpan('tbl_m_produk_hist2', $data_penj_hist);
//            crud::update('tbl_util_so_det', 'id', $item->id, array('sp'=>'1'));

            echo '<pre>';
            print_r($data_penj_hist);
            echo '</pre>';
        }
        
    }

    // Reset Stok Beli
    public function tes17_beli() {
        
        $sql = $this->db->where('sp', '0')->order_by('id', 'ASC')->get('tbl_trans_beli_det')->result();
        $no = 1;
        foreach ($sql as $item){
            $sql_medc       = $this->db->where('id', $item->id_pembelian)->get('tbl_trans_beli')->row();
            $sql_item       = $this->db->where('id', $item->id_produk)->get('tbl_m_produk')->row();
            $sql_satuan     = $this->db->where('id', $sql_item->id_satuan)->get('tbl_m_satuan')->row();
            
            $data_penj_hist = array(
                'tgl_simpan'    => $item->tgl_simpan,
                'tgl_masuk'     => $sql_medc->tgl_masuk,
                'id_gudang'     => '1',
                'id_supplier'   => $sql_medc->id_supplier,
                'id_produk'     => $sql_item->id,
                'id_user'       => $sql_medc->id_user,
                'id_pembelian'  => $sql_medc->id,
                'no_nota'       => (!empty($sql_medc->no_nota) ? $sql_medc->no_nota : ''),
                'kode'          => $sql_item->kode,
                'produk'        => $sql_item->produk,
                'keterangan'    => (!empty($sql_medc->no_po) ? '['.$sql_medc->no_po.'] ' : '').$sql_medc->supplier,
                'jml'           => (int)$item->jml,
                'jml_satuan'    => (int)$sql_satuan->jml,
                'satuan'        => $sql_satuan->satuanTerkecil,
                'nominal'       => (float)$item->harga,
                'status'        => '1'
            );
            
//            crud::simpan('tbl_m_produk_hist2', $data_penj_hist);
//            crud::update('tbl_trans_beli_det', 'id', $item->id, array('sp'=>'1'));

            echo '<pre>';
            print_r($data_penj_hist);
            echo '</pre>';
        }
        
    }

    // Reset Stok Keluar
    public function tes18_jual() {
        
//        $sql = $this->db->where('status', '4')->where('resep IS NOT NULL', null, false)->where('sp', '0')->order_by('id', 'ASC')->get('tbl_trans_medcheck_det');
//        $sql = $this->db->where('sp', '0')->limit(1500)->order_by('id', 'DESC')->get('tbl_trans_medcheck_det');
        $sql = $this->db->where('sp', '0')->limit(5000)->order_by('id', 'ASC')->get('tbl_trans_medcheck_det');
        
        $starttime = microtime(true); // Top of page
        
        echo '<html>';
        echo '<head>';
        echo '<meta http-equiv="refresh" content="60">';
        echo '<title>KUNTUL</title>';
        echo '</head>';
        echo '<body>';
        
        echo $sql->num_rows();
        echo '<hr/>';
        
        $no = 1;
        foreach ($sql->result() as $medc_det){
            $sql_medc       = $this->db->where('id', $medc_det->id_medcheck)->get('tbl_trans_medcheck')->row();
            $sql_pasien     = $this->db->where('id', $sql_medc->id_pasien)->get('tbl_m_pasien')->row();
            $sql_item       = $this->db->where('id', $medc_det->id_item)->get('tbl_m_produk')->row();
            $sql_item_ref   = $this->db->where('id_produk', $sql_item->id)->get('tbl_m_produk_ref'); 
            $sql_satuan     = $this->db->where('id', $sql_item->id_satuan)->get('tbl_m_satuan')->row();
            $sql_gudang     = $this->db->where('status', '1')->get('tbl_m_gudang')->row();
            
            if($sql_item->status_subt == '1'){
                $sql_gudang_stok = $this->db->where('id_gudang', $sql_gudang->id)->where('id_produk', $sql_item->id)->get('tbl_m_produk_stok')->row();
                $jml_akhir       = $sql_item->jml - $medc_det->jml;
                $jml_akhir_stk   = $sql_gudang_stok->jml - $medc_det->jml;
                
                $data_penj_hist = array(
                    'tgl_simpan'    => $medc_det->tgl_simpan,
                    'tgl_masuk'     => $sql_medc->tgl_masuk,
                    'id_gudang'     => $sql_gudang->id,
                    'id_pelanggan'  => $sql_medc->id_pasien,
                    'id_produk'     => $sql_item->id,
                    'id_user'       => $medc_det->id_user,
                    'id_penjualan'  => $sql_medc->id,
                    'no_nota'       => (!empty($sql_medc->no_nota) ? $sql_medc->no_nota : $sql_medc->no_rm),
                    'kode'          => $sql_item->kode,
                    'produk'        => $sql_item->produk,
                    'keterangan'    => $sql_medc->pasien,
                    'jml'           => (int)$medc_det->jml,
                    'jml_satuan'    => (int)$sql_satuan->jml,
                    'satuan'        => $sql_satuan->satuanTerkecil,
                    'nominal'       => (float)$medc_det->harga,
                    'status'        => '4'
                );
                
                $this->db->insert('tbl_m_produk_hist', $data_penj_hist);
                
                echo '<pre>';
                print_r($data_penj_hist);
                echo '</pre>';
            }
            
            if(!empty($medc_det->resep)){
                foreach (json_decode($medc_det->resep) as $rc){
                    $sql_item_rc          = $this->db->where('id', $rc->id_item)->get('tbl_m_produk')->row();
                    $sql_gudang_stok_rc   = $this->db->where('id_gudang', $sql_gudang->id)->where('id_produk', $sql_item_rc->id)->get('tbl_m_produk_stok')->row();
                    
                    if($sql_item_rc->status_subt == '1'){                        
                        $data_penj_hist_rc = array(
                            'tgl_simpan'    => $rc->tgl_simpan,
                            'tgl_masuk'     => $sql_medc->tgl_masuk,
                            'id_gudang'     => $sql_gudang->id,
                            'id_pelanggan'  => $sql_medc->id_pasien,
                            'id_produk'     => $sql_item_rc->id,
                            'id_user'       => $medc_det->id_user,
                            'id_penjualan'  => $sql_medc->id,
                            'no_nota'       => (!empty($sql_medc->no_nota) ? $sql_medc->no_nota : $sql_medc->no_rm),
                            'kode'          => $sql_item_rc->kode,
                            'produk'        => $sql_item_rc->produk,
                            'keterangan'    => $sql_medc->pasien.' - '.$medc_det->item,
                            'jml'           => (int)$rc->jml,
                            'jml_satuan'    => (int)$sql_satuan->jml,
                            'satuan'        => $sql_satuan->satuanTerkecil,
                            'nominal'       => (float)$rc->harga,
                            'status'        => '4'
                        );
                        
                        $this->db->insert('tbl_m_produk_hist', $data_penj_hist_rc);
                        
                        echo '<pre>';
                        print_r($data_penj_hist_rc);
                        echo '</pre>';
                    }
                }
            }
            
            if($sql_item_ref->num_rows() > 0){
                foreach ($sql_item_ref->result() as $reff){
                    $sql_item_rf      = $this->db->where('id', $reff->id_produk_item)->get('tbl_m_produk')->row();
                  
                    # Cek apakah stockabel
                    if($sql_item_rf->status_subt == '1'){                      
                        $data_penj_hist_rf = array(
                            'tgl_simpan'    => $medc_det->tgl_simpan,
                            'tgl_masuk'     => $sql_medc->tgl_masuk,
                            'id_gudang'     => $sql_gudang->id,
                            'id_pelanggan'  => $sql_medc->id_pasien,
                            'id_produk'     => $sql_item_rf->id,
                            'id_user'       => $medc_det->id_user,
                            'id_penjualan'  => $sql_medc->id,
                            'no_nota'       => (!empty($sql_medc->no_nota) ? $sql_medc->no_nota : $sql_medc->no_rm),
                            'kode'          => $sql_item_rf->kode,
                            'produk'        => $sql_item_rf->produk,
                            'keterangan'    => $sql_medc->pasien.' - REFERENCE ITEM',
                            'jml'           => (int)$rc->jml,
                            'jml_satuan'    => (int)$sql_satuan->jml,
                            'satuan'        => $sql_satuan->satuanTerkecil,
                            'nominal'       => (float)$rc->harga,
                            'status'        => '4'
                        );
                        
                        $this->db->insert('tbl_m_produk_hist', $data_penj_hist_rf);
                        
                        echo '<pre>';
                        print_r($data_penj_hist_rf);
                        echo '</pre>';
                    }
                }
            }
            
            $this->db->where('id', $medc_det->id)->update('tbl_trans_medcheck_det', array('sp'=>'1'));
        }
        
        $endtime = microtime(true); // Bottom of page 
        
        echo '<hr/>';
        echo "Page loaded in %f seconds : ", general::format_angka($endtime - $starttime);
        echo '</body>'; 
        echo '</html>'; 
    }
    
    # BOT Harga Jual
    public function tes19() {
        $sql = $this->db->limit(5000)->order_by('id', 'DESC')->get('tbl_trans_medcheck_det');
        
        foreach ($sql->result() as $medc_det){
            $sql_item       = $this->db->where('id', $medc_det->id_item)->get('tbl_m_produk')->row(); 
            
            $this->db->where('id', $medc_det->id)->update('tbl_trans_medcheck_det', array('harga'=>$sql_item->harga_jual));
            
            echo $medc_det->item.br();
            echo (float)$sql_item->harga_jual.br();
            echo '<hr/>';
        }
    }
    
    # BOT Akun
    public function tes20() {
        $sql = $this->db->where('sp','0')->group_by('DATE(tgl_simpan)')->order_by('id', 'DESC')->get('tbl_trans_medcheck_det');
        
        echo '<html>';
        echo '<head>';
        echo '<meta http-equiv="refresh" content="30">';
        echo '<title>KUNTUL</title>';
        echo '</head>';
        echo '<body>';
        
        foreach ($sql->result() as $medc){
            $sql2 = $this->db->where('DATE(tgl_simpan)', date('Y-m-d', strtotime($medc->tgl_simpan)))->where('sp','0')->order_by('id', 'ASC')->get('tbl_trans_medcheck')->result();
            
            $no = 1;
            foreach ($sql2 as $medc2){
                $nomer = strtoupper(date('Mdy', strtotime($medc2->tgl_simpan))).sprintf('%04d',$no);
                echo '['.$nomer.'] '.$medc2->pasien.br();
                echo '<hr/>';
                
                crud::update('tbl_trans_medcheck', 'id', $medc2->id, array('no_akun'=>$nomer, 'sp'=>'1'));
                
                $no++;
            }
        }
        
        
        echo '</body>';
        echo '</html>';
    }
    
    # BOT Reset Pasien Login
    public function tes21_pasien_reset() {
        $pengaturan = $this->db->get('tbl_pengaturan')->row();
        $sql        = $this->db->where('sp', '0')->limit(2000)->order_by('id', 'ASC')->get('tbl_m_pasien');
        
        echo '<html>';
        echo '<head>';
        echo '<meta http-equiv="refresh" content="15">';
        echo '<title>KUNTUL PEKOK</title>';
        echo '</head>';
        echo '<body>';

        $no = 1;
        foreach ($sql->result() as $pasien){            
            $no_rm      = 'pke' . $pasien->kode;
            $email      = strtolower($no_rm.'@'.$pengaturan->website);
            $pass       = (!empty($pasien->tgl_lahir) ? $this->tanggalan->tgl_indo8($pasien->tgl_lahir) : '1970-01-01');

            $data_user = array(
                'email'         => $email,
                'first_name'    => $pasien->nama,
                'nama'          => $pasien->nama_pgl,
                'address'       => $pasien->alamat,
                'phone'         => $pasien->kontak,
                'birthdate'     => $pasien->tgl_lahir,
                'file_name'     => $pasien->file_name,
                'tipe'          => '2',
            );
            
            # Simpan ke modul user
            $this->ion_auth->register($no_rm, $pass, $email, $data_user, array('15'));
            $sql_user_ck  = $this->db->select('id, username')->where('username', $no_rm)->get('tbl_ion_users')->row();
            $last_id      = $sql_user_ck->id;
            
            $data_pasien = array(
                'id_user' => $last_id,
                'sp'      => '1'
            );
            
            $this->db->where('id', $pasien->id)->update('tbl_m_pasien', $data_pasien);
            
            echo '<pre>';
            print_r($data_user);
            echo '</pre>';
            echo '<pre>';
            print_r($data_pasien);
            echo '</pre>';
            
            $no++;
        }        
        
        echo '</body>';
        echo '</html>';
    }
    
    # BOT Reset RM
    public function tes22_resetrm() {
        $bulan  = $this->input->get('bulan');
        $tahun  = $this->input->get('tahun');
        $sql    = $this->db->where('MONTH(tgl_simpan)', $bulan)->where('YEAR(tgl_simpan)', $tahun)->order_by('id', 'ASC')->get('tbl_trans_medcheck');
        
//        echo '<html>';
//        echo '<head>';
//        echo '<meta http-equiv="refresh" content="60">';
//        echo '<title>KUNTUL</title>';
//        echo '</head>';
//        echo '<body>';
        
        $no_urut = 1;
        foreach ($sql->result() as $pasien){
            $sql_pasien = $this->db->where('id', $pasien->id_pasien)->get('tbl_m_pasien')->row();
            $str_nota   = $no_urut;
            $no_rm      = substr($pasien->no_rm, 0, 6).sprintf('%04d', $str_nota);
            $no_nota    = 'INV/'.date('Y', strtotime($pasien->tgl_simpan)).'/'.date('m', strtotime($pasien->tgl_simpan)).'/'.sprintf('%04d', $str_nota);
            
            echo '['.$no_rm.']/'.'['.($pasien->status_bayar == '1' ? $no_nota : 'INV/0000/00/0000').'] ';
            echo $sql_pasien->nama_pgl.br();
            
            $data = array(
                'no_rm'     => $no_rm,
                'no_nota'   => ($pasien->status_bayar == '1' ? $no_nota : ''),
                'pasien'    => $sql_pasien->nama_pgl,
            );
            
//            echo '<pre>';
//            print_r($data);
//            echo '</pre>';

            crud::update('tbl_trans_medcheck', 'id', $pasien->id, $data);

            $no_urut++;
        }        
        
//        echo '</body>';
//        echo '</html>';
    }
    
    # BOT Reset RM
    public function tes23_upl() {
        $bulan  = $this->input->get('bulan');
        $tahun  = $this->input->get('tahun');
        $sql    = $this->db->order_by('id', 'ASC')->get('tbl_trans_medcheck_file');
        
//        echo '<html>';
//        echo '<head>';
//        echo '<meta http-equiv="refresh" content="60">';
//        echo '<title>KUNTUL</title>';
//        echo '</head>';
//        echo '<body>';
        
        $no_urut = 1;
        foreach ($sql->result() as $pasien){
            $sql_medc       = $this->db->where('id', $pasien->id_medcheck)->get('tbl_trans_medcheck')->row();
            $sql_pasien     = $this->db->where('id', $pasien->id_pasien)->get('tbl_m_pasien')->row();
            $no_rm          = strtolower($sql_pasien->kode_dpn).$sql_pasien->kode;
            $folder         = realpath('./file/pasien/'.$no_rm);
            $filename       = 'medc_'.$sql_medc->no_rm.'_upl'.sprintf('%05d', rand(1,256)).'_'.strtolower(str_replace(' ', '_', $pasien->judul)).$pasien->file_ext;
            
            if(!empty($pasien->file_base64)){
                $path = $folder.'/'.$filename;
                general::base64_to_jpeg($pasien->file_base64, $path);
            }
            
            $data = array(
                'file_name'    => $filename,
                'file_base64'  => '',
            );
            
            crud::update('tbl_trans_medcheck_file', 'id', $pasien->id, $data);
            
            echo $folder.'/'.$filename.br();
            
//            echo '<pre>';
//            print_r($data);
//            echo '</pre>';

            $no_urut++;
        }        
        
//        echo '</body>';
//        echo '</html>';
    }
    
    # BOT Reset RAD
    public function tes24_rad() {
        $bulan  = $this->input->get('bulan');
        $tahun  = $this->input->get('tahun');
//        $sql    = $this->db->where('sp', '0')->order_by('id', 'ASC')->get('tbl_trans_medcheck_rad_file');
        $sql = $this->db->where('sp','0')->where('file_rad !=','')->order_by('id', 'ASC')->get('tbl_trans_medcheck_det');
        
//        echo '<html>';
//        echo '<head>';
//        echo '<meta http-equiv="refresh" content="60">';
//        echo '<title>KUNTUL</title>';
//        echo '</head>';
//        echo '<body>';
        
        $no_urut = 1;
        foreach ($sql->result() as $pasien){
            $sql_medc       = $this->db->where('id', $pasien->id_medcheck)->get('tbl_trans_medcheck')->row();
            $sql_pasien     = $this->db->where('id', $sql_medc->id_pasien)->get('tbl_m_pasien')->row();
            $no_rm          = strtolower($sql_pasien->kode_dpn).$sql_pasien->kode;
            $folder         = realpath('./file/pasien/'.$no_rm);
            $get_type       = explode(',',$pasien->file_rad);
            $file_type      = str_replace(array('data:', ';base64'), '', $get_type[0]);
            $file_ext       = '.'.substr($file_type, 6);
            $filename       = 'medc_'.$sql_medc->no_rm.'_rad'.sprintf('%05d', rand(1,256)).$file_ext;
            
            if(!empty($pasien->file_rad)){
                $path = $folder.'/'.$filename;
                
                if(!file_exists($folder)){
                    mkdir($folder, 0777, true);
                }
                
                if(!empty($get_type[1])){
                    general::base64_to_jpeg($pasien->file_rad, $path);
                }
            }
            
            $data = array(
                'file_rad'          => (!empty($get_type[1]) ? $filename : ''),
//                'file_name_orig'    => (!empty($get_type[1]) ? $pasien->file_name : ''),
//                'file_ext'          => (!empty($get_type[1]) ? $file_ext : ''),
//                'file_type'         => (!empty($get_type[1]) ? $file_type : ''),
//                'file_base64'       => '',
                'sp'                => '1',
            );
            
//            crud::update('tbl_trans_medcheck_det', 'id', $pasien->id, $data);
            echo $folder.'/'.$filename.br();
            
            echo '<pre>';
            print_r($data);
            echo '</pre>';

            $no_urut++;
        }        
        
//        echo '</body>';
//        echo '</html>';
    }
    
    # Reset Gelar
    public function tes25_resetglr() {
        $sql = $this->db->where('status', '0')->limit(100)->order_by('id', 'ASC')->get('tbl_m_karyawan');
        
//        echo '<html>';
//        echo '<head>';
//        echo '<meta http-equiv="refresh" content="15">';
//        echo '<title>KUNTUL</title>';
//        echo '</head>';
//        echo '<body>';
        
//        $sql_num = $this->db->get('tbl_m_pasien')->num_rows() + 1;
//        $kode = sprintf('%05d', $sql_num);

        $no = 1;
        foreach ($sql->result() as $kary){
            $nama       = explode(',', $kary->nama);
            $glr_dpn    = explode('.', $nama[0]);
            $str_dpn    = (count($glr_dpn) == 2 ? strlen(strtolower($glr_dpn[0]).'. ') : 0);

            echo $nama[0].br(); // (count($glr_dpn) < 5 ? $glr_dpn[0] : '').br();
            
            $data = array(
                'first_name'    => (!empty($kary->nama_dpn) ? $kary->nama_dpn.' ' : '').$kary->nama.(!empty($kary->nama_blk) ? ', '.$kary->nama_blk : ''),
//                'nama'          => (count($glr_dpn) == 2 ? str_replace('.', '', substr($nama[0], $str_dpn)) : $nama[0]),
//                'nama_blk'      => ucwords(strtolower($nama[1])),
//                'nama_dpn'      => (count($glr_dpn) == 2 ? strtolower($glr_dpn[0]).'. ' : '')
            );
            
//            crud::update('tbl_m_karyawan', 'id', $kary->id, $data);
//            crud::update('tbl_ion_users', 'id', $kary->id_user, $data);
            
            echo '<pre>';
            print_r($data);
            echo '</pre>';
            
            $no++;
        }        
        
        echo '</body>';
        echo '</html>';
    }
    

    # BOT Image User
    public function tes26_user() {
        $sql = $this->db->where('file_base64 !=', '')->order_by('id', 'ASC')->get('tbl_ion_users');
        

        $no = 1;
        foreach ($sql->result() as $pasien){
            $path       = realpath('file/user').'/';
            $kode       = sprintf('%03d', $pasien->id);
            
            $no_rm      = 'userid_' . $kode;
            $path       = 'file/user/'.$no_rm;
            $file       = 'userid_' . $kode . '.png';
            $filename   = $path.'/userid_' . $kode . '.png';

//            if (!file_exists($path)) {
//                mkdir($path, 0777, true);
//            }

            if(!empty($pasien->file_base64)){
                general::base64_to_jpeg($pasien->file_base64, $filename);
            }
            
            $data = array(
                'file_name'     => (file_exists($filename) ? $file : ''),
                'file_base64'   => (file_exists($filename) ? '' : $pasien->file_base64),
            );
            
//            echo '<pre>';
//            print_r($data);
//            echo '</pre>';
                        
            crud::update('tbl_ion_users', 'id', $pasien->id, $data);
            echo $pasien->first_name.(file_exists($filename) ? ' - '.base_url($filename) : '').br();
            
            $no++;
        }        
        
        echo '</body>';
        echo '</html>';
    }
    
    public function tes27_kary_reset() { 
        $sql = $this->db->order_by('id', 'ASC')->get('tbl_ion_users');
        
        foreach ($sql->result() as $user){
            $data_user = array(
                'password'  => ($user->tipe == '2' ? ($user->birthdate == '0000-00-00' ? $user->username : $this->tanggalan->tgl_indo8($user->birthdate)) : ($user->username == 'superadmin' ? 'peace333' : 'admin1234')),
            );

//            $this->ion_auth->update($user->id, $data_user);
            
            echo '<pre>';
            print_r($data_user);
        }
    }
    
    public function tes28_pass_reset() {
        $sql = $this->db->order_by('id', 'ASC')->get('tbl_ion_users');
        
        foreach ($sql->result() as $user){
            $data_user = array(
                'password'  => ($user->tipe == '2' ? ($user->birthdate == '0000-00-00' ? $user->username : $this->tanggalan->tgl_indo8($user->birthdate)) : ($user->username == 'superadmin' ? 'peace333' : 'admin1234')),
            );

//            $this->ion_auth->update($user->id, $data_user);
            
            echo '<pre>';
            print_r($data_user);
        }
    }
    
    public function tes29_kand() {
        $sql = $this->db->select('id, produk, produk_alias, produk_kand, produk_kand2')->where('produk_kand2 !=', '')->get('tbl_m_produk');
        
        foreach ($sql->result() as $user){            
            $data = array(
                'produk_alias'  => $user->produk_kand,
                'produk_kand'   => $user->produk_kand2,
            );
            
//            crud::update('tbl_m_produk', 'id', $user->id, $data);
            
            echo '<pre>';
            print_r($data);
            echo '</pre>';
        }
    }
    
    public function tes30_rstfile() {
        $sql = $this->db->select('id, id_pasien, tgl_masuk, judul, file_name')->where('sp', '0')->order_by('id', 'desc')->get('tbl_trans_medcheck_file');
        
        foreach ($sql->result() as $user){
            $sql_pasien  = $this->db->where('id', $user->id_pasien)->get('tbl_m_pasien')->row();
            $no_rm       = strtolower($sql_pasien->kode_dpn).$sql_pasien->kode;
            $file        = realpath('./file/pasien/'.$no_rm).'/'.$user->file_name;
            
            
            $data = array(
//                'file_name'    => $user->file_name,
                'file_name'   => (file_exists($file) ? '/file/pasien/pke'.$user->id_pasien.'/'.$user->file_name : $user->file_name),
                'file_base64'  => '',
                'sp'           => '1',
            );
            
//            crud::update('tbl_trans_medcheck_file', 'id', $user->id, $data);
            
            echo '<pre>';
            print_r($data);
            echo '</pre>';
            echo 'ok';
            echo br();
        }
    }
    
    public function tes31_icd() {
        $sql = $this->db->select('*')->where('status', '2')->order_by('id', 'desc')->get('tbl_m_icd');
        
        foreach ($sql->result() as $user){
            $data = array(
                'harga'    => $user->harga3,
                'harga1'   => '0',
                'harga2'   => '0',
                'harga3'   => '0',
            );
            
            crud::update('tbl_m_icd', 'id', $user->id, $data);
            
            echo '<pre>';
            print_r($data);
            echo '</pre>';
            echo 'ok';
            echo br();
        }
    }
    
    public function tes32_resep() {
        ini_set('memory_limit', '-1');
        $sql = $this->db->select('*')->order_by('id', 'asc')->get('tbl_trans_medcheck_resep');
        
        foreach ($sql->result() as $user){
            $sql_cek = $this->db->where('id', $user->id_medcheck)->limit(100)->get('tbl_trans_medcheck');
            $data = array(
                'harga'    => $user->harga3,
                'harga1'   => '0',
                'harga2'   => '0',
                'harga3'   => '0',
            );
            
//            crud::update('tbl_m_icd', 'id', $user->id, $data);
            if($sql_cek->num_rows() == 0){
//                crud::delete('tbl_trans_medcheck_resep_det_rc', 'id_resep', $user->id_resep);
//                crud::delete('tbl_trans_medcheck_resep_det', 'id_resep', $user->id_resep);
//                crud::delete('tbl_trans_medcheck_resep', 'id_medcheck', $user->id_medcheck);
//                crud::delete('tbl_trans_medcheck_remun', 'id_medcheck_det', $user->id_medcheck_det);
                
                echo '<pre>';
                print_r($user);
                echo '</pre>';
            }
            
//            echo 'ok';
//            echo br();
        }
    }
    
    public function tes33_gudang() {
        ini_set('memory_limit', '-1');
        $sql = $this->db->select('*')->where('status_subt', '1')->order_by('id', 'asc')->get('tbl_m_produk');
        
        foreach ($sql->result() as $item){
            $sql_satuan = $this->db->where('id', $item->id_satuan)->get('tbl_m_satuan')->row();
            $data = array(
                'id_produk'     => $item->id,
                'id_satuan'     => $item->id_satuan,
                'id_gudang'     => 1,
                'tgl_simpan'    => $item->tgl_simpan,
                'jml'           => $item->jml,
                'jml_satuan'    => $sql_satuan->jml,
                'satuan'        => $sql_satuan->satuanTerkecil,
                'satuanKecil'   => $sql_satuan->satuanTerkecil,
                'status'        => '1',
            );
            
            $this->db->insert('tbl_m_produk_stok', $data);

//            crud::update('tbl_m_icd', 'id', $user->id, $data);
//            if($sql_cek->num_rows() == 0){
//                crud::delete('tbl_trans_medcheck_resep_det_rc', 'id_resep', $user->id_resep);
//                crud::delete('tbl_trans_medcheck_resep_det', 'id_resep', $user->id_resep);
//                crud::delete('tbl_trans_medcheck_resep', 'id_medcheck', $user->id_medcheck);
//                crud::delete('tbl_trans_medcheck_remun', 'id_medcheck_det', $user->id_medcheck_det);
                
                echo '<pre>';
                print_r($data);
                echo '</pre>';
//            }
            
//            echo 'ok';
//            echo br();
        }
    }
    
    public function tes34_alergi() {
        ini_set('memory_limit', '-1');
        $sql = $this->db->select('*')->where('id_pasien !=', '')->order_by('id', 'desc')->get('tbl_pendaftaran');
        
        foreach ($sql->result() as $pasien){
            $data = array(
                'alergi'     => $pasien->alergi
            );
            
            $this->db->where('id', $pasien->id)->update('tbl_m_pasien', $data);

//            crud::update('tbl_m_icd', 'id', $user->id, $data);
//            if($sql_cek->num_rows() == 0){
//                crud::delete('tbl_trans_medcheck_resep_det_rc', 'id_resep', $user->id_resep);
//                crud::delete('tbl_trans_medcheck_resep_det', 'id_resep', $user->id_resep);
//                crud::delete('tbl_trans_medcheck_resep', 'id_medcheck', $user->id_medcheck);
//                crud::delete('tbl_trans_medcheck_remun', 'id_medcheck_det', $user->id_medcheck_det);
                
                echo '<pre>';
                print_r($data);
                echo '</pre>';
//            }
            
//            echo 'ok';
//            echo br();
        }
    }
    
    public function tes35_medc() {
        ini_set('memory_limit', '-1');
        $sql = $this->db->select('*')->where('sp', '1')->order_by('id', 'desc')->get('tbl_trans_medcheck');
  
        $idpasien   = 17705;
        $idmedc     = 28923;
        foreach ($sql->result() as $medc){
            echo 'ID Pasien : '.$idpasien;
            echo br();
            echo 'ID : '.$idmedc.' '.$medc->pasien;
            echo br();
            
            $data_medc = array('id_medcheck' => $idmedc);
            $this->db->where('id', $medc->id_pasien)->update('tbl_m_pasien', array('id' => $idpasien));
            $this->db->where('id_penjualan', $medc->id)->update('tbl_m_produk_hist', array('id_penjualan' => $idmedc));
            $this->db->where('id', $medc->id)->update('tbl_trans_medcheck', array('id' => $idmedc, 'id_pasien' => $idpasien));
            
//            $this->db->where('id_medcheck', $medc->id)->update('tbl_trans_medcheck_lab', $data_medc);
//            $this->db->where('id_medcheck', $medc->id)->update('tbl_trans_medcheck_lab_hsl', $data_medc);
//            $this->db->where('id_medcheck', $medc->id)->update('tbl_trans_medcheck_mcu', $data_medc);
//            $this->db->where('id_medcheck', $medc->id)->update('tbl_trans_medcheck_mcu_det', $data_medc);
//            $this->db->where('id_medcheck', $medc->id)->update('tbl_trans_medcheck_rad', $data_medc);
//            $this->db->where('id_medcheck', $medc->id)->update('tbl_trans_medcheck_rad_det', $data_medc);
//            $this->db->where('id_medcheck', $medc->id)->update('tbl_trans_medcheck_rad_file', $data_medc);
//            $this->db->where('id_medcheck', $medc->id)->update('tbl_trans_medcheck_remun', $data_medc);
//            $this->db->where('id_medcheck', $medc->id)->update('tbl_trans_medcheck_resep', $data_medc);
//            $this->db->where('id_medcheck', $medc->id)->update('tbl_trans_medcheck_resep_det', $data_medc);
//            $this->db->where('id_medcheck', $medc->id)->update('tbl_trans_medcheck_resep_det_rc', $data_medc);
//            $this->db->where('id_medcheck', $medc->id)->update('tbl_trans_medcheck_resume', $data_medc);
//            $this->db->where('id_medcheck', $medc->id)->update('tbl_trans_medcheck_resume_det', $data_medc);
            
            $this->db->where('id_medcheck !=', $medc->id)->delete('tbl_trans_medcheck_apres');
            $this->db->where('id_medcheck !=', $medc->id)->delete('tbl_trans_medcheck_det');
            $this->db->where('id_medcheck !=', $medc->id)->delete('tbl_trans_medcheck_lab');
            $this->db->where('id_medcheck !=', $medc->id)->delete('tbl_trans_medcheck_lab_hsl');
            $this->db->where('id_medcheck !=', $medc->id)->delete('tbl_trans_medcheck_mcu');
            $this->db->where('id_medcheck !=', $medc->id)->delete('tbl_trans_medcheck_mcu_det');
            $this->db->where('id_medcheck !=', $medc->id)->delete('tbl_trans_medcheck_rad');
            $this->db->where('id_medcheck !=', $medc->id)->delete('tbl_trans_medcheck_rad_det');
            $this->db->where('id_medcheck !=', $medc->id)->delete('tbl_trans_medcheck_rad_file');
            $this->db->where('id_medcheck !=', $medc->id)->delete('tbl_trans_medcheck_remun');
            $this->db->where('id_medcheck !=', $medc->id)->delete('tbl_trans_medcheck_resep');
            $this->db->where('id_medcheck !=', $medc->id)->delete('tbl_trans_medcheck_resep_det');
            $this->db->where('id_medcheck !=', $medc->id)->delete('tbl_trans_medcheck_resep_det_rc');
            $this->db->where('id_medcheck !=', $medc->id)->delete('tbl_trans_medcheck_resume');
            $this->db->where('id_medcheck !=', $medc->id)->delete('tbl_trans_medcheck_resume_det');

//            $sql_medc_lab           = $this->db->where('id_medcheck', $medc->id)->get('tbl_trans_medcheck_lab');
//            $sql_medc_lab_hsl       = $this->db->where('id_medcheck', $medc->id)->get('tbl_trans_medcheck_lab_hsl');
//            $sql_medc_mcu           = $this->db->where('id_medcheck', $medc->id)->get('tbl_trans_medcheck_mcu');
//            $sql_medc_mcu_det       = $this->db->where('id_medcheck', $medc->id)->get('tbl_trans_medcheck_mcu_det');
//            $sql_medc_rad           = $this->db->where('id_medcheck', $medc->id)->get('tbl_trans_medcheck_rad');
//            $sql_medc_rad_det       = $this->db->where('id_medcheck', $medc->id)->get('tbl_trans_medcheck_rad_det');
//            $sql_medc_rad_file      = $this->db->where('id_medcheck', $medc->id)->get('tbl_trans_medcheck_rad_file');
//            $sql_medc_remun         = $this->db->where('id_medcheck', $medc->id)->get('tbl_trans_medcheck_remun');
//            $sql_medc_apres         = $this->db->where('id_medcheck', $medc->id)->get('tbl_trans_medcheck_apres');
//            $sql_medc_resep         = $this->db->where('id_medcheck', $medc->id)->get('tbl_trans_medcheck_resep');
//            $sql_medc_resep_det     = $this->db->where('id_medcheck', $medc->id)->get('tbl_trans_medcheck_resep_det');
//            $sql_medc_resep_det_rc  = $this->db->where('id_medcheck', $medc->id)->get('tbl_trans_medcheck_resep_det_rc');
//            $sql_medc_resume        = $this->db->where('id_medcheck', $medc->id)->get('tbl_trans_medcheck_resume');
//            $sql_medc_resume_det    = $this->db->where('id_medcheck', $medc->id)->get('tbl_trans_medcheck_resume_det');
//            $sql_medc_mcu           = $this->db->where('id_medcheck', $medc->id)->get('tbl_trans_medcheck_mcu');
//            $sql_medc_mcu_det       = $this->db->where('id_medcheck', $medc->id)->get('tbl_trans_medcheck_mcu_det');
            
            $idpasien++;
            $idmedc++;
        }
    }
    
    public function tes36_lab_hsl() {
        ini_set('memory_limit', '-1');
        $sql = $this->db->where('status', '3')->order_by('id', 'desc')->get('tbl_trans_medcheck_det');
  
        $idpasien   = 17705;
        $idmedc     = 28923;
        foreach ($sql->result() as $medc){
            $sql_hsl = $this->db->where('sp', '0')->where('id_medcheck', $medc->id_medcheck)->where('id_item', $medc->id_item)->order_by('id', 'desc')->get('tbl_trans_medcheck_lab_hsl')->result();
            
            echo 'ID : '.$medc->id.' ';
            echo br();
            echo 'Item : '.$medc->item.' ';
            echo br();
            
            foreach ($sql_hsl as $hsl){
                $data_hsl = array(
                    'id_medcheck_det'   => $medc->id,
                    'sp'                => '1'
                );
                
                $this->db->where('id', $hsl->id)->update('tbl_trans_medcheck_lab_hsl', $data_hsl);
            }
            
            $this->db->where('id', $medc->id)->update('tbl_trans_medcheck_det', array('sp' => '1'));

            $idmedc++;
        }
    }
    
    public function tes37_makefont() {
        require('framework/libraries/makefont/makefont.php');
        
//        MakeFont('C:\\Windows\\Fonts\\comic.ttf','cp1252');
//        MakeFont('framework/libraries/font/cambria.ttf','cp1252');
        MakeFont('framework/libraries/font/Cambria.ttf','cp1252');
        MakeFont('C:\\Windows\\Fonts\\Cambriab.ttf','cp1252');
        MakeFont('C:\\Windows\\Fonts\\Cambriaz.ttf','cp1252');
        MakeFont('C:\\Windows\\Fonts\\Cambriai.ttf','cp1252');
        
//        echo realpath('C:\\Windows\\Fonts\\Cambria.ttc');
    }
    

    public function tes38_dokter() {
        $sql_medc = $this->db->where('sp', '0')->limit(10000)->order_by('id', 'ASC')->get('tbl_trans_medcheck');
                
        echo '<html>';
        echo '<head>';
        echo '<meta http-equiv="refresh" content="10">';
        echo '<title>KUNTUL</title>';
        echo '</head>';
        
        foreach ($sql_medc->result() as $medc){
            $sql_ck = $this->db->where('id_medcheck', $medc->id)->where('id_dokter', $medc->id_dokter)->get('tbl_trans_medcheck_dokter');
            
            # Masukkan data dokter
            $data_dokter = array(
                'id_medcheck'   => $medc->id,
                'id_user'       => $medc->id_user,
                'id_pasien'     => $medc->id_pasien,
                'id_dokter'     => $medc->id_dokter,
                'tgl_simpan'    => $medc->tgl_simpan,
                'keterangan'    => '',
                'status'        => '1'
            );
            
            if($sql_ck->num_rows() == 0){            
                $this->db->insert('tbl_trans_medcheck_dokter', $data_dokter);
                $this->db->where('id', $medc->id)->update('tbl_trans_medcheck', array('sp'=>'1'));
                
                echo '<pre>';
                print_r($data_dokter);
                echo '</pre>';                
            }
            
        }
        
        echo '<body>';
        echo '</body>';
        echo '</html>';
    }
    
    public function tes39_remun_rad() {
        $sql = $this->db->get('v_medcheck_remun_rad')->result();
        
        $i=1;
        foreach ($sql as $remun){
            $sql_rad = $this->db->where('id', $remun->id_rad)->get('tbl_trans_medcheck_rad')->row();
            
            $data = array(
                'id_dokter' => $sql_rad->id_dokter
            );
            
//            crud::update('tbl_trans_medcheck_remun', 'id', $remun->id, array('id_dokter' => $sql_rad->id_dokter));
            
            echo $this->ion_auth->user($sql_rad->id_dokter)->row()->first_name;
            echo '<pre>';
            print_r($remun);
            echo '</pre>';
        }
    }
    
    public function tes40_aps() {
        $pengaturan = $this->db->get('tbl_pengaturan')->row();
        $sql        = $this->db->where('status_aps', '1')->order_by('id', 'asc')->get('tbl_m_karyawan')->result();
        
        $i=1;
        foreach ($sql as $remun){
            $kode_no    = sprintf('%05d', $i);
            $user       = 'aps'.$kode_no;
            $email      = 'aps'.$kode_no.'@'.$pengaturan->website;
            $pass2      = 'admin1234';
            $grup       = '10';
            
            if (!empty($user) AND!empty($pass2)) {
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
            }
            
            $data_kary = array(
                'id_user'           => $last_id_user,
                'id_user_group'     => '10',
                'tgl_modif'         => date('Y-m-d H:i:s'),
                'kode'              => $user,
            );
            
            crud::update('tbl_m_karyawan', 'id', $remun->id, $data_kary);
            
            echo '<pre>';
            print_r($data_kary);
            echo '</pre>';
            
            $i++;
        }
    }
    
    public function tes41_kary_nama() {
        $pengaturan = $this->db->get('tbl_pengaturan')->row();
        $sql        = $this->db->where('status_aps', '0')->order_by('id', 'asc')->get('tbl_m_karyawan')->result();
        
        $i=1;
        foreach ($sql as $kary){
            
            $data_kary = array(
                'first_name'    => (!empty($kary->nama_dpn) ? $kary->nama_dpn.' ' : '').strtoupper($kary->nama).(!empty($kary->nama_blk) ? ', '.$kary->nama_blk : ''),
                'birthdate'     => $kary->tgl_lahir,
                'address'       => $kary->alamat,
                'nama'          => '',
            );
            
            crud::update('tbl_ion_users', 'id', $kary->id_user, $data_kary);
            crud::update('tbl_m_karyawan', 'id', $kary->id, array('nama'=>strtoupper($kary->nama)));
            
            echo '<pre>';
            print_r($data_kary);
            echo '</pre>';
            
            $i++;
        }
    }
    
    public function tes42() {
        $awal  = date_create('2024-04-29 20:48:00');
        $akhir = date_create('2024-04-29 23:59:00'); // waktu sekarang
        $diff  = date_diff( $awal, $akhir );

        echo 'Selisih waktu: ';
        echo $diff->y . ' tahun, ';
        echo $diff->m . ' bulan, ';
        echo $diff->d . ' hari, ';
        echo $diff->h . ' jam, ';
        echo $diff->i . ' menit, ';
        echo $diff->s . ' detik, ';
        // Output: Selisih waktu: 28 tahun, 5 bulan, 9 hari, 13 jam, 7 menit, 7 detik

        echo 'Total selisih hari : ' . $diff->days;
        echo br();
        $umur = ($diff->d > 0 ? $diff->d.' Hari ' : '').($diff->h > 0 ? $diff->h.' Jam ' : '').($diff->i > 0 ? $diff->i.' Menit' : '');
        
        echo $umur;
        // Output: Total selisih hari: 10398
    }
    
    public function tes43() {
        echo '<html>';
        echo '<head>';
        echo '<meta http-equiv="refresh" content="8">';
        echo '<title>KUNTUL RESEP DET</title>';
        echo '</head>';
        echo '<body>';
        
//        $sql  = $this->db->where('id <', '45806')->where('id_item', '2980')->where('sp', '0')->order_by('id', 'desc')->limit(500)->get('tbl_trans_medcheck_resep_det');
        $sql  = $this->db->query("SELECT * FROM tbl_trans_medcheck_resep_det WHERE id_item='2980' AND sp='0' AND id < '278299' ORDER BY id DESC LIMIT 500;");
        
        $i = 1;
        foreach ($sql->result() as $rs){
            $sql_item   = $this->db->where('id', $rs->id_item)->get('tbl_m_produk')->row();
//            $sql_rc     = $this->db->where('id_resep_det', $rs->id)->get('tbl_trans_medcheck_resep_det_rc');
            
            if(!empty($rs->resep)){            
                foreach (json_decode($rs->resep) as $rc){
                    $data_rc_det = array(
                        'id_medcheck'       => (int)$rc->id_medcheck,
                        'id_resep'          => (int)$rc->id_resep,
                        'id_resep_det'      => (int)$rs->id,
                        'id_resep_det_rc'   => (int)$rc->id,
                        'id_item'           => (int)$rc->id_item,
                        'id_item_kat'       => (int)$rc->id_item_kat,
                        'id_item_sat'       => (int)$rc->id_item_sat,
                        'id_user'           => (int)$rc->id_user,
                        'tgl_simpan'        => $rc->tgl_simpan,
                        'tgl_modif'         => date('Y-m-d H:i:s'),
                        'kode'              => $rc->kode,
                        'item'              => $rc->item,
                        'dosis'             => $rc->dosis,
                        'dosis_ket'         => $rc->dosis_ket,
                        'harga'             => (float)$rc->harga,
                        'jml'               => (float)$rc->jml,
                        'jml_satuan'        => (int)$rc->jml_satuan,
                        'subtotal'          => (float)$rc->subtotal,
                        'satuan'            => $rc->satuan,
                        'status_pj'         => $rc->status_pj,
                        'status'            => '4',
                        'status_rc'         => '1',
                    );
                    
                    $this->db->insert('tbl_trans_medcheck_det', $data_rc_det);

                    echo '<pre>';
                    print_r($data_rc_det);
                    echo '</pre>';
                }

                $this->db->where('id', $rs->id)->update('tbl_trans_medcheck_resep_det', array('sp'=>'1'));
            }
        }
        
        echo '</body>';
        echo '</html>';
    }
    
    public function tes44() {
        $sql  = $this->db->where('DATE(tgl_masuk)', '2024-05-17')->where('tipe', '5')->where('status_hps', '0')->get('tbl_trans_medcheck');
        
        foreach ($sql->result() as $medc){
            $sql_pas    = $this->db->where('id', $medc->id_pasien)->get('tbl_m_pasien')->row();
            $cleanStr   = preg_replace('/[^A-Za-z0-9 ]/', '+', $sql_pas->alamat);
            $nama       = str_replace('+', ' ', $cleanStr);

//            crud::update('tbl_m_pasien', 'id', $sql_pas->id, array('alamat'=>$nama));

            echo $cleanStr;
            echo br();
        }
    }
    
    # Tracing diskon dan potongan
    public function tes45() {
        echo '<html>';
        echo '<head>';
        echo '<meta http-equiv="refresh" content="12">';
        echo '<title>KUNTUL</title>';
        echo '</head>';
        echo '<body>';
        
        $sql  = $this->db->where('DATE(tgl_simpan)', '2024-05-18')->where('sp', '0')->limit(5000)->order_by('id', 'desc')->get('tbl_trans_medcheck_det');
        
        foreach ($sql->result() as $rs){
            $sql_item   = $this->db->where('id', $rs->id_item)->get('tbl_m_produk')->row();

            $harga      = ($sql_item->id == '2980' ? $sql_item->harga_jual : $rs->harga);
            $disk1      = $harga - (($rs->disk1 / 100) * $harga);
            $disk2      = $disk1 - (($rs->disk2 / 100) * $disk1);
            $disk3      = $disk2 - (($rs->disk3 / 100) * $disk2);
            $diskon     = ($harga - $disk3) * $rs->jml;
            $subtotal   = ($disk3 - $rs->potongan) * $rs->jml;
            
            $cart = array(
                'harga'     => (float)$harga,
                'diskon'    => (float)$diskon,
                'potongan'  => (float)$rs->potongan,
                'subtotal'  => (float)$subtotal,
                'sp'        => '1'
            );
            
//            $this->db->where('id', $rs->id)->update('tbl_trans_medcheck_det', $cart);
            
            // Update price di total penjualan
            $sql_medc_det_sum   = $this->db->select('SUM(diskon) AS diskon, SUM(potongan) AS potongan, SUM(subtotal) AS subtotal')->where('id_medcheck', $rs->id_medcheck)->get('tbl_trans_medcheck_det')->row();
            $jml_total          = $sql_medc_det_sum->subtotal + $sql_medc_det_sum->diskon + $sql_medc_det_sum->potongan;
            $jml_diskon         = $sql_medc_det_sum->diskon;
            $jml_potongan       = $sql_medc_det_sum->potongan;
            $diskon             = (($sql_medc->jml_total - $sql_medc_det_sum->subtotal) / $sql_medc->jml_total) * 100;
            $jml_gtotal         = $jml_total - $jml_diskon - $jml_potongan;
            
            $data_medc_tot = array(
                'jml_diskon'    => $jml_diskon,
                'jml_potongan'  => $jml_potongan,
                'jml_subtotal'  => (float) $jml_gtotal,
                'jml_gtotal'    => (float) $jml_gtotal,
            );
            
//            $this->db->where('id', $rs->id_medcheck)->update('tbl_trans_medcheck', $data_medc_tot);

            echo '<pre>';
            print_r($cart);
            echo '</pre>';
        }
        


        echo '</body>';
        echo '</html>';
    }
    
    # Tracing instansi
    public function tes46() {
        echo '<html>';
        echo '<head>';
        echo '<meta http-equiv="refresh" content="12">';
        echo '<title>KUNTUL</title>';
        echo '</head>';
        echo '<body>';
        
        $sql  = $this->db->query("SELECT * FROM tbl_pendaftaran WHERE YEAR(tgl_simpan)='2023' AND instansi !='' AND instansi !='-';");
        
        foreach ($sql->result() as $det){
            $sql_inst = $this->db->where('nama', $det->instansi)->get('tbl_m_pelanggan');
            
            $data = array(
                'id_instansi'   => $sql_inst->row()->id
            );
            
//            if($sql_inst->num_rows() > 0){
//                crud::update('tbl_pendaftaran', 'id', $det->id, $data);
//            }
            
            echo $det->nama.br();
            echo '<pre>';
            print_r($sql_inst->row());
            echo '</pre>';
        }


        echo '</body>';
        echo '</html>';
    }
    
    # Tracing Poin
    public function tes47() {
        echo '<html>';
        echo '<head>';
        echo '<meta http-equiv="refresh" content="12">';
        echo '<title>KUNTUL</title>';
        echo '</head>';
        echo '<body>';
        
        $pengaturan     = $this->db->get('tbl_pengaturan')->row();
        $sql            = $this->db->query("SELECT * FROM tbl_trans_medcheck WHERE DATE(tgl_bayar) >'2024-05-29' AND sp='0';");
        
        foreach ($sql->result() as $det){
            $jml_poin       = $det->jml_gtotal / $pengaturan->jml_poin_nom;
            $jml_poin_nom   = floor($jml_poin) * $pengaturan->jml_poin;
            
            $data = array(
                'tgl_modif'     => $det->tgl_bayar,
                'pasien'        => $det->pasien,
                'jml_poin'      => floor($jml_poin),
                'jml_poin_nom'  => $jml_poin_nom
            );
            
//            if($sql_inst->num_rows() > 0){
//                crud::update('tbl_trans_medcheck', 'id', $det->id, $data);
//            }
            
            echo '<pre>';
            print_r($data);
            echo '</pre>';
        }


        echo '</body>';
        echo '</html>';
    }
    
    # Tracing Poin Per Pasien
    public function tes48() {
        echo '<html>';
        echo '<head>';
//        echo '<meta http-equiv="refresh" content="12">';
        echo '<title>KUNTUL</title>';
        echo '</head>';
        echo '<body>';
        
        $pengaturan     = $this->db->get('tbl_pengaturan')->row();
        $sql            = $this->db->query("SELECT id, id_pasien, tgl_simpan, tgl_bayar, pasien, SUM(jml_gtotal) AS jml_gtotal, SUM(jml_poin) AS jml_poin, SUM(jml_poin_nom) AS jml_poin_nom FROM tbl_trans_medcheck WHERE DATE(tgl_bayar) >'2024-05-29' AND sp='0' AND status_bayar ='1' GROUP BY id_pasien ORDER BY SUM(jml_poin) DESC;");
        
        $no = 1;
        foreach ($sql->result() as $det){
            $jml_poin       = $det->jml_gtotal / $pengaturan->jml_poin_nom;
            $jml_poin_nom   = floor($jml_poin) * $pengaturan->jml_poin;
            
            $data = array(
                'id'            => $no,
                'id_pasien'     => $det->id_pasien,
                'tgl_simpan'    => date('Y-m-d H:i:s'),
                'jml_poin'      => floor($jml_poin),
                'jml_poin_nom'  => $jml_poin_nom,
                'status'        => '1',
            );
            
//            if($sql_inst->num_rows() > 0){
//                crud::simpan('tbl_m_pasien_poin', $data);
//            }
            
            echo $det->pasien.br();
            echo '<pre>';
            print_r($data);
            echo '</pre>';
            
            $no++;
        }


        echo '</body>';
        echo '</html>';
    }
    
    # Insert Poin Per Pasien lama
    public function tes49() {
        echo '<html>';
        echo '<head>';
        echo '<meta http-equiv="refresh" content="8">';
        echo '<title>KUNTUL</title>';
        echo '</head>';
        echo '<body>';
        
        $pengaturan     = $this->db->get('tbl_pengaturan')->row();
        $sql            = $this->db->query("SELECT id, tgl_simpan, nama_pgl, sp FROM tbl_m_pasien WHERE sp='0' ORDER BY id ASC LIMIT 1000;");

        $no = 1;
        foreach ($sql->result() as $det){
            $sql_cek = $this->db->where('id_pasien', $det->id)->get('tbl_m_pasien_poin');
            $sql_mdc = $this->db->select('SUM(jml_poin) as jml_poin, SUM(jml_poin_nom) AS jml_poin_nom')->where('id_pasien', $det->id)->where('status_bayar', '1')->where('status_hps', '0')->where('tipe_bayar', '1')->where('YEAR(tgl_bayar)', date('Y'))->get('tbl_trans_medcheck')->row();
            
            $data = array(
                'id_pasien'     => $det->id,
                'tgl_simpan'    => date('Y-m-d H:i:s'),
                'tgl_modif'     => date('Y-m-d H:i:s'),
                'jml_poin'      => (float)$sql_mdc->jml_poin,
                'jml_poin_nom'  => (float)$sql_mdc->jml_poin_nom,
                'status'        => '1',
            );
            
            if($sql_cek->num_rows() == 0){
                crud::simpan('tbl_m_pasien_poin', $data);
            }
            crud::update('tbl_m_pasien', 'id', $det->id, array('sp'=>'1'));
            
            
            echo $det->nama_pgl.br();
            echo '<pre>';
            print_r($data);
            echo '</pre>';
            
            $no++;
        }


        echo '</body>';
        echo '</html>';
    }
    
    # Insert Medcheck beberpa tambahan
    public function tes50() {
        echo '<html>';
        echo '<head>';
        echo '<meta http-equiv="refresh" content="8">';
        echo '<title>KUNTUL</title>';
        echo '</head>';
        echo '<body>';
        
        $pengaturan     = $this->db->get('tbl_pengaturan')->row();
        $sql            = $this->db->query("SELECT * FROM tbl_trans_medcheck WHERE sp='0' AND YEAR(tgl_simpan)='2024' ORDER BY id DESC LIMIT 2000;");

        $no = 1;
        foreach ($sql->result() as $det){
            $sql_dok    = $this->db->where('id_user', $det->id_dokter)->get('tbl_m_karyawan')->row();
            $sql_pas    = $this->db->where('id', $det->id_pasien)->get('tbl_m_pasien')->row();
            $sql_poli   = $this->db->where('id', $det->id_poli)->get('tbl_m_poli')->row();
            $sql_dft    = $this->db->where('id', $det->id_dft)->get('tbl_pendaftaran')->row();
            
            $data = array(
                'id_instansi'       => (!empty($sql_dft->id_instansi) ? $sql_dft->id_instansi : 0),
                'dokter_nik'        => $sql_dok->nik,
                'dokter'            => (!empty($sql_dok->nama_dpn) ? $sql_dok->nama_dpn.' ' : '').$sql_dok->nama.(!empty($sql_dok->nama_blk) ? ', '.$sql_dok->nama_blk.' ' : ''),
                'poli'              => $sql_poli->lokasi,
                'id_post_location'  => $sql_poli->post_location,
                'pasien'            => $sql_pas->nama_pgl,
                'pasien_nik'        => $sql_pas->nik,
                'pasien_alamat'     => $sql_pas->alamat,
                'tgl_lahir'         => $sql_pas->tgl_lahir,
                'sp'                => '1',
            );
            
//            if($sql_cek->num_rows() == 0){
//                crud::simpan('tbl_m_pasien_poin', $data);
//            }
            crud::update('tbl_trans_medcheck', 'id', $det->id, $data);
            
            
            echo $det->nama_pgl.br();
            echo '<pre>';
            print_r($data);
            echo '</pre>';
            
            $no++;
        }


        echo '</body>';
        echo '</html>';
    }
    
    # BOT ID item
    public function tes51() {
        echo '<html>';
        echo '<head>';
        echo '<meta http-equiv="refresh" content="8">';
        echo '<title>KUNTUL</title>';
        echo '</head>';
        echo '<body>';
        
        $pengaturan     = $this->db->get('tbl_pengaturan')->row();
        $sql            = $this->db->query("SELECT 
	id, id_medcheck, id_item, kode, item, harga, jml, jml_satuan, satuan, subtotal, status_pkt
FROM tbl_trans_medcheck_det WHERE item IS NULL ORDER BY id DESC;");

        $no = 1;
        foreach ($sql->result() as $det){
            $sql_item   = $this->db->where('id', $det->id_item)->get('tbl_m_produk')->row();
            $subtot     = $sql_item->harga_jual * $det->jml;
            
            $data = array(
                'item'      => $sql_item->produk,
                'harga'     => $sql_item->harga_jual,
                'satuan'    => 'PCS',
                'subtotal'  => $subtot,
            );
            
            crud::update('tbl_trans_medcheck_det', 'id', $det->id, $data);
            
            
            echo $det->produk.br();
            echo '<pre>';
            print_r($data);
            echo '</pre>';
            
            $no++;
        }


        echo '</body>';
        echo '</html>';
    }
    
    public function tes52(){
        $sql = $this->db
                    ->where('instansi', 'MCU PT. SAMWON')
                    ->where('file_ext', '.jpg')
                    ->where('file_name !=', '')
                    ->order_by('id', 'desc')
                    ->get('tbl_m_pasien')->result();
        
        foreach ($sql as $item){
            $file = 'file/pasien/pke'.$item->id.'/profile_'.$item->id.'.png';
//            crud::update('tbl_m_pasien', 'id', $item->id, array('tgl_modif'=>date('Y-m-d H:i:s'),'file_name'=>$file,'file_type'=>'image/png'));
            
            echo $item->file_name.' ==> '.$file;
            echo br();
        }
    }
    
    public function tes53(){
//        $sql = $this->db
//                    ->where('status', '1')
//                    ->where('produk', '')
//                    ->order_by('id', 'desc')
//                    ->get('tbl_m_produk_hist')->result();
        $sql = $this->db->query("SELECT * FROM tbl_m_produk_hist WHERE status='1' AND produk IS NULL ORDER BY id DESC;")->result();
        
        foreach ($sql as $item){
            $sql_det = $this->db
                    ->where('id', $item->id_pembelian_det)
                    ->get('tbl_trans_beli_det')->row();
            
            $data = array(
                'tgl_modif'     => date('Y-m-d H:i:s'),
                'tgl_ed'        => $sql_det->tgl_ed,
                'kode_batch'    => $sql_det->kode_batch,
                'produk'        => $sql_det->produk,
            );
            
//            crud::update('tbl_m_produk_hist', 'id', $item->id, $data);
            
            echo $item->id.' ==> '.$item->id_produk.' ==> '.$sql_det->produk;
            echo br();
            
            echo '<pre>';
            print_r($data);
        }
    }

    public function bot_stok_op() {
        $sql = $this->db
                        ->where('DATE(tgl_simpan) >=', '2023-02-09')
//                        ->where('DATE(tgl_simpan) <=', '2023-02-19')
                        ->group_by('produk')
                        ->order_by('id', 'desc')
                        ->get('tbl_util_so_det')->result();
        $fix = $this->input->get('status');
        
        $no = 1;
        foreach ($sql as $item){
            $sql_beli = $this->db
                            ->select('SUM(tbl_trans_beli_det.jml) AS jml')
                            ->join('tbl_trans_beli', 'tbl_trans_beli.id=tbl_trans_beli_det.id_pembelian')
                            ->where('tbl_trans_beli_det.id_produk', $item->id_produk)
                            ->group_by('tbl_trans_beli_det.produk')
                            ->get('tbl_trans_beli_det')->row();
            
            $sql_jual = $this->db
                            ->select('SUM(tbl_trans_medcheck_det.jml) AS jml')
                            ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_det.id_medcheck')
                            ->where('tbl_trans_medcheck_det.id_item', $item->id_produk)
                            ->where('tbl_trans_medcheck.status_hps', '0')
                            ->where('tbl_trans_medcheck_det.status', '4')
                            ->where('tbl_trans_medcheck.status_bayar', '1')
                            ->where('tbl_trans_medcheck.tgl_masuk >=', $item->tgl_simpan)
                            ->where('tbl_trans_medcheck.tgl_masuk <=', (isset($_GET['tgl']) ? $this->input->get('tgl').' '.$this->input->get('jam').':00' : date('Y-m-d H:i:s')))
                            ->group_by('tbl_trans_medcheck_det.item')
                            ->get('tbl_trans_medcheck_det')->row();
            
            $sisa = ($item->jml_so + $sql_beli->jml) - $sql_jual->jml;
            
            
            echo $item->id_produk;
            echo br();
            echo anchor(base_url('master/data_barang_tambah.php?id='.general::enkrip($item->id_produk)), $item->produk, 'target="_blank"');
            echo br();
            echo '-SO : '.(float)$item->jml_so.' | '.$item->tgl_simpan;
            echo br();
            echo '-Beli : '.(float)$sql_beli->jml;
            echo br();
            echo '-Terjual : '.(float)$sql_jual->jml;
            echo br();
            echo '-Sisa : '.(float)$sisa;
            echo br(2);
            
            if($fix == '1'){
                crud::update('tbl_m_produk', 'id', $item->id_produk, array('jml'=>(float)$sisa));
            }
            
//            echo '<pre>';
//            print_r($item);
//            echo '</pre>';
        }
        
    }

    public function register() {
//        if (akses::aksesLogin() == TRUE) {       
        $dft_id             = $this->input->get('id');
        
        $data['poli']     = $this->db->where('status_ant', '1')->get('tbl_m_poli')->result();
        $data['gelar']    = $this->db->get('tbl_m_gelar')->result();
        $data['sql_doc']  = $this->db->where('id_user_group', '10')->get('tbl_m_karyawan')->result();
        $data['kerja']    = $this->db->get('tbl_m_jenis_kerja')->result();
        $data['sql_dft_id'] = $this->db->where('id', general::dekrip($dft_id))->get('tbl_pendaftaran')->row();
        $data['sql_poli']   = $this->db->where('id', $data['sql_dft_id']->id_poli)->get('tbl_m_poli')->row();
        $data['layout']   = 'layout-top-nav';

        $this->load->view('admin-lte-3/1_atas', $data);
        $this->load->view('admin-lte-3/2_header', $data);
//        $this->load->view('admin-lte-3/3_navbar', $data);
        $this->load->view('admin-lte-3/front/register', $data);
        $this->load->view('admin-lte-3/5_footer', $data);
        $this->load->view('admin-lte-3/6_bawah', $data);

//        } else {
//            $errors = $this->ion_auth->messages();
//            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
//            redirect();
//        }
    }
    

    public function set_register() {
//        if (akses::aksesLogin() == TRUE) {
            $no_rm        = $this->input->post('no_rm');
            $nik          = $this->input->post('nik');
            $gelar        = $this->input->post('gelar');
            $nama         = $this->input->post('nama');
            $no_hp        = $this->input->post('no_hp');
            $tmp_lahir    = $this->input->post('tmp_lahir');
            $tgl_lahir    = $this->input->post('tgl_lahir');
            $alamat       = $this->input->post('alamat');
            $jns_klm      = $this->input->post('jns_klm');
            $pekerjaan    = $this->input->post('pekerjaan');
            $tipe_pas     = $this->input->post('tipe_pas');
            $file         = $this->input->post('file');
            
            $tgl_masuk    = $this->input->post('tgl_masuk');
            $poli         = $this->input->post('poli');
            $dokter       = $this->input->post('dokter');
            
            $pengaturan = $this->db->get('tbl_pengaturan')->row();
            
            // Pilih tipe pasien
            switch ($tipe_pas){
                
                // Pasien Lama
                case '1':
                    $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
        
                    $this->form_validation->set_rules('nik', 'NIK', 'required');
                    $this->form_validation->set_rules('no_rm', 'No RM', 'required');
        
                    if ($this->form_validation->run() == FALSE) {
                        $msg_error = array(
                            'nik'     => form_error('nik'),
                            'gelar'   => form_error('no_rm'),
                        );
        
                        $this->session->set_flashdata('form_error', $msg_error);
                        redirect(base_url('home/register.php'));
                    } else {
                        $tmsk    = $this->tanggalan->tgl_indo_sys($tgl_masuk);
                        $sql_cek1= $this->db->like('kode', $no_rm)->get('tbl_m_pasien');
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
                        
                        
                        $data_pas = array(
                            'tgl_simpan'   => date('Y-m-d H:i:s'),
                            'tgl_masuk'    => $tmsk,
                            'id_gelar'     => $pasien->id_gelar,
                            'id_poli'      => $poli,
                            'id_dokter'    => $dokter,
                            'id_pekerjaan' => $pasien->id_pekerjaan,
                            'no_urut'      => $no_urut,
                            'nik'          => $nik,
                            'nama'         => $pasien->nama,
                            'nama_pgl'     => strtoupper($sql_glr->gelar.' '.$pasien->nama),
                            'tmp_lahir'    => $pasien->tmp_lahir,
                            'tgl_lahir'    => $this->tanggalan->tgl_indo_sys($pasien->tgl_lahir),
                            'jns_klm'      => $pasien->jns_klm,
                            'kontak'       => $no_hp,
                            'alamat'       => $pasien->alamat,
                            'status'       => $tipe_pas,
                            'status_akt'   => '0'
                        );
                        
                        $this->session->set_flashdata('master', '<div class="alert alert-success">Data member berhasil diubah</div>');
                        crud::simpan('tbl_pendaftaran', $data_pas);
                        $last_id = crud::last_id();                
                        
                        redirect(base_url('medcheck/register.php?id='.general::enkrip($last_id)));
                    }
                    break;
                
                // Pasien Baru
                case '2':
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
                        redirect(base_url('home/register.php'));
                    } else {
                        $tmsk    = $this->tanggalan->tgl_indo_sys($tgl_masuk);
                        $sql_num = $this->db->where('DATE(tgl_masuk)', $tmsk)->where('id_poli', $poli)->get('tbl_pendaftaran');
                        $sql_glr = $this->db->where('id', $gelar)->get('tbl_m_gelar')->row();
                        $kode    = sprintf('%05d', $sql_num);
                        $sql_kat = $this->db->get('tbl_m_kategori');
                        
                        $sql_cek = $this->db->where('kode', $no_rm)->get('tbl_pendaftaran');
                        
                        $no_urut = $sql_num->num_rows() + 1;
                        
                        $data_pas = array(
                            'tgl_simpan'   => date('Y-m-d H:i:s'),
                            'tgl_masuk'    => $tmsk,
                            'id_gelar'     => $gelar,
                            'id_poli'      => $poli,
                            'id_dokter'    => $dokter,
                            'id_pekerjaan' => $pekerjaan,
                            'no_urut'      => $no_urut,
                            'nik'          => $nik,
                            'nama'         => $nama,
                            'nama_pgl'     => strtoupper($sql_glr->gelar.' '.$nama),
                            'tmp_lahir'    => $tmp_lahir,
                            'tgl_lahir'    => $this->tanggalan->tgl_indo_sys($tgl_lahir),
                            'jns_klm'      => $jns_klm,
                            'kontak'       => $no_hp,
                            'alamat'       => $alamat,
                            'status'       => $tipe_pas,
                            'status_akt'   => '0'
                        );
                        
                        $this->session->set_flashdata('master', '<div class="alert alert-success">Data member berhasil diubah</div>');
                        crud::simpan('tbl_pendaftaran', $data_pas);
                        $last_id = crud::last_id();                
                        
                        redirect(base_url('medcheck/register.php?id='.general::enkrip($last_id)));
                    }
                    break;
            }
//        } else {
//            $errors = $this->ion_auth->messages();
//            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');
//            redirect();
//        }
    }
    
    public function json_medcheck_label() {
        if (akses::aksesLogin() == TRUE) {
            $term  = $this->input->get('term');
            $stat  = $this->input->get('status');
            $sql   = $this->db->select("tbl_trans_medcheck.id, tbl_trans_medcheck.id_dokter, tbl_trans_medcheck_resep.tgl_simpan, tbl_m_pasien.kode_dpn, tbl_m_pasien.kode, tbl_m_pasien.nama, tbl_m_pasien.tgl_lahir, tbl_m_pasien.jns_klm,	tbl_trans_medcheck_resep_det.item, tbl_trans_medcheck_resep_det.jml, tbl_trans_medcheck_resep_det.satuan, tbl_trans_medcheck_resep_det.tgl_ed, tbl_trans_medcheck_resep_det.dosis, tbl_trans_medcheck_resep_det.dosis_ket")
                              ->where('tbl_trans_medcheck_resep_det.status_resep', '0')
                              ->join('tbl_trans_medcheck_resep', 'tbl_trans_medcheck_resep.id=tbl_trans_medcheck_resep_det.id_resep')
                              ->join('tbl_trans_medcheck', 'tbl_trans_medcheck.id=tbl_trans_medcheck_resep_det.id_medcheck')
                              ->join('tbl_m_pasien', 'tbl_m_pasien.id=tbl_trans_medcheck.id_pasien')
                              ->order_by('tbl_trans_medcheck_resep_det.id', 'ASC')
                              ->get('tbl_trans_medcheck_resep_det')->result();

            if(!empty($sql)){
                foreach ($sql as $resep){
                    $setting    = $this->db->get('tbl_pengaturan')->row();
                    $sql_doc    = $this->db->where('id_user', $resep->id_dokter)->get('tbl_m_karyawan')->row();
                    
                        $produk[] = array(
                            'tgl'           => $this->tanggalan->tgl_indo($resep->tgl_simpan),
                            'rm'            => $resep->kode_dpn.''.$resep->kode,
                            'nama'          => $resep->nama,
                            'tgl_lahir'     => $this->tanggalan->tgl_indo($resep->tgl_lahir).' ('.$this->tanggalan->usia_lkp($resep->tgl_lahir).')',
                            'jns_klm'       => general::jns_klm($resep->jns_klm),
                            'item'          => $resep->item,
                            'jml'           => (float)$resep->jml,
                            'satuan'        => $resep->satuan,
                            'tgl_ed'        => $this->tanggalan->tgl_indo($resep->tgl_ed),
                            'dosis'         => $resep->dosis,
                            'ket'           => $resep->dosis_ket,
                            'dokter'        => (!empty($sql_doc->nama_dpn) ? $sql_doc->nama_dpn.' ' : '').$sql_doc->nama.(!empty($sql_doc->nama_blk) ? ', '.$sql_doc->nama_blk : ''),
                            'judul'         => $setting->judul
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
