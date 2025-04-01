<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php

/**
 * Description of anggota
 *
 * @author mike
 */
class akuntability extends CI_Controller {
    //put your code here
    function __construct() {
        parent::__construct();
    }
    
    public function data_pems_list() {
        if (akses::aksesLogin() == TRUE) {
            $query   = $this->input->get('q');
            $hal     = $this->input->get('halaman');
            $jml     = $this->input->get('jml');
            $jml_hal = (isset($jml) ? $jml  : $this->db->where('tipe', 'masuk')->get('tbl_akt_kas')->num_rows());
            
            $data['hasError'] = $this->session->flashdata('form_error');
                        
            $config['base_url']               = base_url('akuntability/data_pems_list.php?'.(isset($_GET['q']) ? '&q='.$_GET['q'].'&jml='.$_GET['jml'] : ''));
            $config['total_rows']             = $jml_hal;
            
            $config['query_string_segment']  = 'halaman';
            $config['page_query_string']     = TRUE;
            $config['per_page']              = 20;
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
                    $data['biaya'] = $this->db->select('DATE(tgl_simpan) as tgl, id, id_jenis, jenis, kode, keterangan, nominal')->where('tipe', 'masuk')->limit($config['per_page'],$hal)->like('keterangan', $query)->order_by('tgl_simpan','desc')->get('tbl_akt_kas')->result();
                } else {
                    $data['biaya'] = $this->db->select('DATE(tgl_simpan) as tgl, id, id_jenis, jenis, kode, keterangan, nominal')->where('tipe', 'masuk')->limit($config['per_page'],$hal)->order_by('tgl_simpan','desc')->get('tbl_akt_kas')->result();
                }
            }else{
                if (!empty($query)) {
                    $data['biaya'] = $this->db->select('DATE(tgl_simpan) as tgl, id, id_jenis, jenis, kode, keterangan, nominal')->where('tipe', 'masuk')->limit($config['per_page'],$hal)->like('keterangan', $query)->order_by('tgl_simpan','desc')->get('tbl_akt_kas')->result();
                } else {
                    $data['biaya'] = $this->db->select('DATE(tgl_simpan) as tgl, id, id_jenis, jenis, kode, keterangan, nominal')->where('tipe', 'masuk')->limit($config['per_page'])->order_by('tgl_simpan','desc')->get('tbl_akt_kas')->result();
                }
            }
            
            $this->pagination->initialize($config);
            
            $data['total_rows'] = $config['total_rows'];
            $data['PerPage']    = $config['per_page'];
            $data['pagination'] = $this->pagination->create_links();

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
//            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/akuntability/data_pems_list', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function data_pems_tambah() {
        if (akses::aksesLogin() == TRUE) {
            $id   = $this->input->get('id');
            
            $data['no_nota']    = general::no_nota('','tbl_akt_kas', 'kode', "WHERE tipe='masuk'"); //no_nota($string,$tabel_nama, $tabel_kolom, $where)
            $data['jenis']      = $this->db->get('tbl_akt_kas_jns')->result();
            $data['biaya']      = $this->db->select('DATE(tgl_simpan) as tgl, id, id_jenis, kode, keterangan, nominal')->where('id', general::dekrip($id))->get('tbl_akt_kas')->row();

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
//            $this->load->view('admin-lte-2/3_navbar', $data);
            $this->load->view('admin-lte-2/includes/akuntability/data_pems_tambah', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function data_pems_simpan() {
        if (akses::aksesLogin() == TRUE) {
            $tgl          = explode('/',$this->input->post('tgl'));
            $kode         = $this->input->post('kode');
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
                redirect(base_url('akuntability/data_pems_tambah.php'));
            } else {
                $saldo_kas = $this->db->select('MAX(id) as id, MAX(saldo) as saldo')->get('tbl_akt_kas')->row();
                $tot_saldo = $saldo_kas->saldo + $nominal;
                
                $data_penj = array(
                    'tgl_simpan'  => $tgl[2].'-'.$tgl[0].'-'.$tgl[1].' '.date('H:i:s'),
                    'kode'        => $kode,
                    'id_user'     => $this->ion_auth->user()->row()->id,
                    'keterangan'  => $ket,
                    'nominal'     => $nominal,
                    'kredit'      => $nominal,
                    'saldo'       => $tot_saldo,
                    'tipe'        => 'masuk',
                    'jenis'       => '1',
                    'status_kas'  => 'kas',
                );
                
                $this->session->set_flashdata('member', '<div class="alert alert-success">Pemasukan berhasil disimpan</div>');
                crud::simpan('tbl_akt_kas', $data_penj);
                redirect(base_url('akuntability/data_pems_list.php'));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function data_pems_update() {
        if (akses::aksesLogin() == TRUE) {
            $tgl          = explode('/',$this->input->post('tgl'));
            $id           = $this->input->post('id');
            $kode         = $this->input->post('kode');
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
                redirect(base_url('akuntability/data_pems_tambah.php'));
            } else {
                $saldo_kas = $this->db->select('MAX(id) as id, MAX(saldo) as saldo')->get('tbl_akt_kas')->row();
                $tot_saldo = $saldo_kas->saldo + $nominal;
                
                $data_penj = array(
                    'tgl_simpan'  => $tgl[2].'-'.$tgl[0].'-'.$tgl[1].' '.date('H:i:s'),
                    'kode'        => $kode,
                    'id_user'     => $this->ion_auth->user()->row()->id,
                    'keterangan'  => $ket,
                    'nominal'     => $nominal,
                    'kredit'      => $nominal,
                    'saldo'       => $tot_saldo,
                    'tipe'        => 'masuk',
                    'status_kas'  => 'kas',
                );
                
                $this->session->set_flashdata('member', '<div class="alert alert-success">Pemasukan berhasil disimpan</div>');
                crud::update('tbl_akt_kas','id',general::dekrip($id), $data_penj);
                redirect(base_url('akuntability/data_pems_list.php'));
            }
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function data_pems_hapus() {
        if (akses::aksesLogin() == TRUE) {
            $id = $this->input->get('id');
            
            if(!empty($id)){
                crud::delete('tbl_akt_kas','id',general::dekrip($id));
            }
            
            redirect(base_url('akuntability/data_pems_list.php'));
        } else {
            $errors = $this->ion_auth->messages();
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');
            redirect();
        }
    }
    
    public function data_peng_list() {
        if (akses::aksesLogin() == TRUE) {
            $query   = $this->input->get('q');
            $hal     = $this->input->get('halaman');
            $jml     = $this->input->get('jml');
            if(akses::hakOwner2() == TRUE OR akses::hakAdmin() == TRUE){
                $jml_hal = (!empty($jml) ? $jml  : $this->db->where('tipe', 'keluar')->not_like('keterangan', 'Pembelian')->get('tbl_akt_kas')->num_rows());
            }else{
                $jml_hal = (!empty($jml) ? $jml  : $this->db->where('tipe', 'keluar')->get('tbl_akt_kas')->num_rows());
            }
            
            $data['hasError'] = $this->session->flashdata('form_error');
                        
            $config['base_url']               = base_url('akuntability/data_peng_list.php?'.(isset($_GET['q']) ? '&q='.$_GET['q'].'&jml='.$_GET['jml'] : ''));
            $config['total_rows']             = $jml_hal;
            
            $config['query_string_segment']  = 'halaman';
            $config['page_query_string']     = TRUE;
            $config['per_page']              = 20;
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
            
            if(akses::hakOwner2() == TRUE OR akses::hakAdmin() == TRUE){
                if(!empty($hal)){
                    if (!empty($query)) {
                        $data['biaya'] = $this->db->select('DATE(tgl_simpan) as tgl, id, id_jenis, kode, keterangan, nominal')->where('tipe', 'keluar')->not_like('keterangan', 'Pembelian')->limit($config['per_page'],$hal)->like('keterangan', $query)->order_by('tgl_simpan','desc')->get('tbl_akt_kas')->result();
                    } else {
                        $data['biaya'] = $this->db->select('DATE(tgl_simpan) as tgl, id, id_jenis, kode, keterangan, nominal')->where('tipe', 'keluar')->not_like('keterangan', 'Pembelian')->limit($config['per_page'],$hal)->order_by('tgl_simpan','desc')->get('tbl_akt_kas')->result();
                    }
                }else{
                    if (!empty($query)) {
                        $data['biaya'] = $this->db->select('DATE(tgl_simpan) as tgl, id, id_jenis, kode, keterangan, nominal')->where('tipe', 'keluar')->not_like('keterangan', 'Pembelian')->limit($config['per_page'],$hal)->like('keterangan', $query)->order_by('tgl_simpan','desc')->get('tbl_akt_kas')->result();
                    } else {
                        $data['biaya'] = $this->db->select('DATE(tgl_simpan) as tgl, id, id_jenis, kode, keterangan, nominal')->where('tipe', 'keluar')->not_like('keterangan', 'Pembelian')->limit($config['per_page'])->order_by('tgl_simpan','desc')->get('tbl_akt_kas')->result();
                    }
                }
            }else{
                if(!empty($hal)){
                    if (!empty($query)) {
                        $data['biaya'] = $this->db->select('DATE(tgl_simpan) as tgl, id, id_jenis, kode, keterangan, nominal')->where('tipe', 'keluar')->limit($config['per_page'],$hal)->like('keterangan', $query)->order_by('tgl_simpan','desc')->get('tbl_akt_kas')->result();
                    } else {
                        $data['biaya'] = $this->db->select('DATE(tgl_simpan) as tgl, id, id_jenis, kode, keterangan, nominal')->where('tipe', 'keluar')->limit($config['per_page'],$hal)->order_by('tgl_simpan','desc')->get('tbl_akt_kas')->result();
                    }
                }else{
                    if (!empty($query)) {
                        $data['biaya'] = $this->db->select('DATE(tgl_simpan) as tgl, id, id_jenis, kode, keterangan, nominal')->where('tipe', 'keluar')->limit($config['per_page'],$hal)->like('keterangan', $query)->order_by('tgl_simpan','desc')->get('tbl_akt_kas')->result();
                    } else {
                        $data['biaya'] = $this->db->select('DATE(tgl_simpan) as tgl, id, id_jenis, kode, keterangan, nominal')->where('tipe', 'keluar')->limit($config['per_page'])->order_by('tgl_simpan','desc')->get('tbl_akt_kas')->result();
                    }
                }                
            }
            

            $this->pagination->initialize($config);

            

            $data['total_rows'] = $config['total_rows'];

            $data['PerPage']    = $config['per_page'];

            $data['pagination'] = $this->pagination->create_links();

            $data['cetak']      = '<button type="button" onclick="window.location.href = \''.base_url('laporan/data_pengeluaran_pdf.php?'.(empty($_GET['case']) ? 'query='.$query : 'case='.$_GET['case']).'&route=akuntability/data_peng_list'.(!empty($jml) ? '&jml='.$jml : '')).'\'" class="btn btn-warning btn-flat"><i class="fa fa-print"></i> Cetak</button>';



            $this->load->view('admin-lte-2/1_atas', $data);

            $this->load->view('admin-lte-2/2_header', $data);

//            $this->load->view('admin-lte-2/3_navbar', $data);

            $this->load->view('admin-lte-2/includes/akuntability/data_peng_list', $data);

            $this->load->view('admin-lte-2/5_footer', $data);

            $this->load->view('admin-lte-2/6_bawah', $data);

        } else {

            $errors = $this->ion_auth->messages();

            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');

            redirect();

        }

    }

    

    public function data_peng_tambah() {

        if (akses::aksesLogin() == TRUE) {

            $id   = $this->input->get('id');

            

            $data['no_nota']    = general::no_nota('','tbl_akt_kas', 'kode', "WHERE tipe='keluar'"); //no_nota($string,$tabel_nama, $tabel_kolom, $where)

            $data['jenis']      = $this->db->get('tbl_akt_kas_jns')->result();

            $data['biaya']      = $this->db->select('DATE(tgl_simpan) as tgl, id, id_jenis, kode, keterangan, nominal')->where('id', general::dekrip($id))->get('tbl_akt_kas')->row();



            $this->load->view('admin-lte-2/1_atas', $data);

            $this->load->view('admin-lte-2/2_header', $data);

//            $this->load->view('admin-lte-2/3_navbar', $data);

            $this->load->view('admin-lte-2/includes/akuntability/data_peng_tambah', $data);

            $this->load->view('admin-lte-2/5_footer', $data);

            $this->load->view('admin-lte-2/6_bawah', $data);

        } else {

            $errors = $this->ion_auth->messages();

            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');

            redirect();

        }

    }

    

    public function data_peng_jns_simpan() {

        if (akses::aksesLogin() == TRUE) {

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

                redirect(base_url('akuntability/data_peng_tambah.php?case=jenis_biaya'.(!empty($id) ? '&id='.$id : '')));

            } else {                

                $data_penj = array(

                    'jenis'      => $jenis,

                    'keterangan' => '-'

                );

                

                $this->session->set_flashdata('member', '<div class="alert alert-success">Data jenis biaya disimpan</div>');

                crud::simpan('tbl_akt_kas_jns', $data_penj);

                redirect(base_url('akuntability/data_peng_tambah.php?case=jenis_biaya'.(!empty($id) ? '&id='.$id : '')));

            }

        } else {

            $errors = $this->ion_auth->messages();

            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');

            redirect();

        }

    }

    

    public function data_peng_simpan() {

        if (akses::aksesLogin() == TRUE) {

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

                redirect(base_url('akuntability/data_peng_tambah.php'));

            } else {

                $saldo_kas = $this->db->select('MAX(id) as id, MAX(saldo) as saldo')->get('tbl_akt_kas')->row();

                $tot_saldo = $saldo_kas->saldo - $nominal;

                

                $data_penj = array(

                    'tgl_simpan'  => $tgl[2].'-'.$tgl[0].'-'.$tgl[1].' '.date('H:i:s'),

                    'kode'        => $kode,

                    'id_user'     => $this->ion_auth->user()->row()->id,

                    'id_jenis'    => $jenis,

                    'keterangan'  => $ket,

                    'nominal'     => $nominal,

                    'debet'       => $nominal,

                    'saldo'       => $tot_saldo,

                    'tipe'        => 'keluar',

                    'status_kas'  => 'kas',

                );

                

                $this->session->set_flashdata('member', '<div class="alert alert-success">Data member berhasil diubah</div>');

                crud::simpan('tbl_akt_kas', $data_penj);

                redirect(base_url('akuntability/data_peng_list.php'));

            }

        } else {

            $errors = $this->ion_auth->messages();

            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');

            redirect();

        }

    }

    

    public function data_peng_update() {

        if (akses::aksesLogin() == TRUE) {

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

                redirect(base_url('akuntability/data_peng_tambah.php?id='.$id));

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

                redirect(base_url('akuntability/data_peng_tambah.php?id='.$id));

            }

        } else {

            $errors = $this->ion_auth->messages();

            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');

            redirect();

        }

    }

    

    public function data_peng_hapus() {

        if (akses::aksesLogin() == TRUE) {

            $id = $this->input->get('id');

            

            if(!empty($id)){

                crud::delete('tbl_akt_kas','id',general::dekrip($id));

            }

            

            redirect(base_url('akuntability/data_peng_list.php'));

        } else {

            $errors = $this->ion_auth->messages();

            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');

            redirect();

        }

    }

    

    public function data_peng_jns_hapus() {

        if (akses::aksesLogin() == TRUE) {

            $id  = $this->input->get('id');

            $aid = $this->input->get('aid');

            

            if(!empty($aid)){

                crud::delete('tbl_akt_kas_jns','id',general::dekrip($aid));

            }

            

            redirect(base_url('akuntability/data_peng_tambah.php?case=jenis_biaya'.(!empty($id) ? '&id='.$id : '')));

        } else {

            $errors = $this->ion_auth->messages();

            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');

            redirect();

        }

    }

    

    public function data_pers_list() {

        if (akses::aksesLogin() == TRUE) {

            $query      = $this->input->get('q');

            $hal        = $this->input->get('halaman');

            $jml        = $this->input->get('jml');

            $jml_hal    = (!empty($jml) ? $jml  : $this->db->count_all('tbl_akt_persediaan'));

            $pengaturan = $this->db->get('tbl_pengaturan')->row();

            

            $data['hasError'] = $this->session->flashdata('form_error');

                        

            $config['base_url']               = base_url('akuntability/data_pers_list.php?'.(isset($_GET['q']) ? '&q='.$_GET['q'].'&jml='.$jml_hal : ''));

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

                    $data['pers'] = $this->db->select('DATE(tgl_simpan) as tgl_simpan, id, keterangan, nominal')->limit($config['per_page'],$hal)

                                               ->like('keterangan', $query)

                                               ->or_like('nominal', $query)

                                               ->or_like('DATE(tgl_simpan)', $this->tanggalan->tgl_indo_sys($query))

                                               ->get('tbl_akt_persediaan')->result();

                } else {

                    $data['pers'] = $this->db->select('DATE(tgl_simpan) as tgl_simpan, id, keterangan, nominal')->limit($config['per_page'],$hal)

                                               ->order_by('id','asc')

                                               ->get('tbl_akt_persediaan')->result();

                }

            }else{

                if (!empty($query)) {

                    $data['pers'] = $this->db->select('DATE(tgl_simpan) as tgl_simpan, id, keterangan, nominal')->limit($config['per_page'],$hal)

                                               ->like('keterangan', $query)

                                               ->or_like('nominal', $query)

                                               ->or_like('DATE(tgl_simpan)', $this->tanggalan->tgl_indo_sys($query))

                                               ->get('tbl_akt_persediaan')->result();

                } else {

                    $data['pers'] = $this->db->select('DATE(tgl_simpan) as tgl_simpan, id, keterangan, nominal')->limit($config['per_page'])->order_by('id','asc')->get('tbl_akt_persediaan')->result();

                }

            }

            

            $this->pagination->initialize($config);

            

            $data['total_rows'] = $config['total_rows'];

            $data['PerPage']    = $config['per_page'];

            $data['pagination'] = $this->pagination->create_links();

            $data['cetak']      = '<button type="button" onclick="window.location.href = \''.base_url('master/cetak_data_pers.php?'.(!empty($query) ? 'query='.$query : '').(!empty($jml) ? '&jml='.$jml : '')).'\'" class="btn btn-warning btn-flat"><i class="fa fa-print"></i> Cetak</button>';



            $this->load->view('admin-lte-2/1_atas', $data);

            $this->load->view('admin-lte-2/2_header', $data);

//            $this->load->view('admin-lte-2/3_navbar', $data);

            $this->load->view('admin-lte-2/includes/akuntability/data_pers_list', $data);

            $this->load->view('admin-lte-2/5_footer', $data);

            $this->load->view('admin-lte-2/6_bawah', $data);

        } else {

            $errors = $this->ion_auth->messages();

            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');

            redirect();

        }

    }

    

    public function data_pers_tambah() {

        if (akses::aksesLogin() == TRUE) {

            $id   = $this->input->get('id');

            

            $data['pers'] = $this->db->select('DATE(tgl_simpan) as tgl_simpan, nominal, keterangan')->where('id', general::dekrip($id))->get('tbl_akt_persediaan')->row();



            $this->load->view('admin-lte-2/1_atas', $data);

            $this->load->view('admin-lte-2/2_header', $data);

//            $this->load->view('admin-lte-2/3_navbar', $data);

            $this->load->view('admin-lte-2/includes/akuntability/data_pers_tambah', $data);

            $this->load->view('admin-lte-2/5_footer', $data);

            $this->load->view('admin-lte-2/6_bawah', $data);

        } else {

            $errors = $this->ion_auth->messages();

            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');

            redirect();

        }

    }

    

    public function data_pers_simpan() {

        if (akses::aksesLogin() == TRUE) {

            $tgl_simpan  = $this->input->post('tgl_simpan');

            $nominal     = str_replace('.', '', $this->input->post('nominal'));

            $ket         = $this->input->post('keterangan');



            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');



            $this->form_validation->set_rules('nominal', 'Nominal', 'required');



            if ($this->form_validation->run() == FALSE) {

                $msg_error = array(

                    'nominal'     => form_error('nominal'),

                );



                $this->session->set_flashdata('form_error', $msg_error);

                redirect(base_url('akuntability/data_pers_tambah.php?id='.$id));

            } else {

                $sql_num = $this->db->get('tbl_akt_persediaan')->num_rows() + 1;

                $kode    = sprintf('%05d', $sql_num);

                

                $data_penj = array(

                    'tgl_simpan'   => $this->tanggalan->tgl_indo_sys($tgl_simpan).' '.date('H:i:s'),

                    'id_user'      => $this->ion_auth->user()->row()->id,

                    'kode'         => $kode,

                    'nominal'      => $nominal,

                    'keterangan'   => $ket

                );

                

                $this->session->set_flashdata('master', '<div class="alert alert-success">Data pers disimpan</div>');

                crud::simpan('tbl_akt_persediaan',$data_penj);

                redirect(base_url('akuntability/data_pers_list.php'));

            }

        } else {

            $errors = $this->ion_auth->messages();

            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');

            redirect();

        }

    }

    

    public function data_pers_update() {

        if (akses::aksesLogin() == TRUE) {

            $id      = $this->input->post('id');

            $tgl_simpan  = $this->input->post('tgl_simpan');

            $nominal     = str_replace('.', '', $this->input->post('nominal'));

            $ket         = $this->input->post('keterangan');



            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');



            $this->form_validation->set_rules('nominal', 'Nominal', 'required');



            if ($this->form_validation->run() == FALSE) {

                $msg_error = array(

                    'nominal'     => form_error('nominal'),

                );



                $this->session->set_flashdata('form_error', $msg_error);

                redirect(base_url('akuntability/data_pers_tambah.php?id='.$id));

            } else {

                $sql_num = $this->db->get('tbl_akt_persediaan')->num_rows() + 1;

                $kode    = sprintf('%05d', $sql_num);

                

                $data_penj = array(

                    'tgl_simpan'   => $this->tanggalan->tgl_indo_sys($tgl_simpan).' '.date('H:i:s'),

                    'id_user'      => $this->ion_auth->user()->row()->id,

                    'kode'         => $kode,

                    'nominal'      => $nominal,

                    'keterangan'   => $ket

                );

                

                $this->session->set_flashdata('master', '<div class="alert alert-success">Data pers disimpan</div>');

                crud::update('tbl_akt_persediaan','id', general::dekrip($id),$data_penj);

                redirect(base_url('akuntability/data_pers_tambah.php?id='.$id));

            }

        } else {

            $errors = $this->ion_auth->messages();

            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');

            redirect();

        }

    }

    

    public function data_pers_hapus() {

        if (akses::aksesLogin() == TRUE) {

            $id = $this->input->get('id');

            

            if(!empty($id)){

                crud::delete('tbl_akt_persediaan','id',general::dekrip($id));

            }

            

            redirect(base_url('akuntability/data_pers_list.php'));

        } else {

            $errors = $this->ion_auth->messages();

            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');

            redirect();

        }

    }

    

    public function data_modal_list() {

        if (akses::aksesLogin() == TRUE) {

            $query   = $this->input->get('q');

            $hal     = $this->input->get('halaman');

            $jml     = $this->input->get('jml');

            $jml_hal = (!empty($jml) ? $jml  : $this->db->where('tipe', 'masuk')->get('tbl_akt_kas')->num_rows());

            

            $data['hasError'] = $this->session->flashdata('form_error');

                        

            $config['base_url']               = base_url('akuntability/data_pems_list.php?'.(isset($_GET['q']) ? '&q='.$_GET['q'].'&jml='.$_GET['jml'] : ''));

            $config['total_rows']             = $jml_hal;

            

            $config['query_string_segment']  = 'halaman';

            $config['page_query_string']     = TRUE;

            $config['per_page']              = 20;

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

                    $data['biaya'] = $this->db->select('DATE(tgl_simpan) as tgl, id, id_jenis, kode, keterangan, nominal')->where('tipe', 'masuk')->limit($config['per_page'],$hal)->like('nama', $query)->get('tbl_akt_kas')->result();

                } else {

                    $data['biaya'] = $this->db->select('DATE(tgl_simpan) as tgl, id, id_jenis, kode, keterangan, nominal')->where('tipe', 'masuk')->limit($config['per_page'],$hal)->order_by('id','asc')->get('tbl_akt_kas')->result();

                }

            }else{

                if (!empty($query)) {

                    $data['biaya'] = $this->db->select('DATE(tgl_simpan) as tgl, id, id_jenis, kode, keterangan, nominal')->where('tipe', 'masuk')->limit($config['per_page'],$hal)->like('nama', $query)->get('tbl_akt_kas')->result();

                } else {

                    $data['biaya'] = $this->db->select('DATE(tgl_simpan) as tgl, id, id_jenis, kode, keterangan, nominal')->where('tipe', 'masuk')->limit($config['per_page'])->order_by('id','asc')->get('tbl_akt_kas')->result();

                }

            }

            

            $this->pagination->initialize($config);

            

            $data['total_rows'] = $config['total_rows'];

            $data['PerPage']    = $config['per_page'];

            $data['pagination'] = $this->pagination->create_links();



            $this->load->view('admin-lte-2/1_atas', $data);

            $this->load->view('admin-lte-2/2_header', $data);

//            $this->load->view('admin-lte-2/3_navbar', $data);

            $this->load->view('admin-lte-2/includes/akuntability/data_modal_list', $data);

            $this->load->view('admin-lte-2/5_footer', $data);

            $this->load->view('admin-lte-2/6_bawah', $data);

        } else {

            $errors = $this->ion_auth->messages();

            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');

            redirect();

        }

    }

    

    

    

    // -- AKUNTANSI -- //

    public function data_akun_list() {

        if (akses::aksesLogin() == TRUE) {

            $query   = $this->input->get('q');

            $hal     = $this->input->get('halaman');

            $jml     = $this->input->get('jml');

            $jml_hal = (!empty($jml) ? $jml  : $this->db->order_by('id_akun_grup', 'asc')->get('tbl_akt_akun')->num_rows());

            

            $data['hasError'] = $this->session->flashdata('form_error');

                        

            $config['base_url']               = base_url('akuntability/data_akun_list.php?'.(isset($_GET['q']) ? '&q='.$_GET['q'].'&jml='.$_GET['jml'] : ''));

            $config['total_rows']             = $jml_hal;

            

            $config['query_string_segment']  = 'halaman';

            $config['page_query_string']     = TRUE;

            $config['per_page']              = 20;

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

                    $data['biaya'] = $this->db->select('DATE(tbl_akt_akun.tgl_simpan) as tgl, tbl_akt_akun.kode, tbl_akt_akun.nama, tbl_akt_akun.keterangan, tbl_akt_akun_grup.nama as grup')

                                              ->join('tbl_akt_akun_grup', 'tbl_akt_akun_grup.id=tbl_akt_akun.id_akun_grup', 'INNER')

                                              ->like('tbl_akt_akun.nama', $query)

                                              ->limit($config['per_page'],$hal)

                                              ->order_by('tbl_akt_akun.id_akun_grup', 'asc')

                                              ->get('tbl_akt_akun')->result();

                } else {

                    $data['biaya'] = $this->db->select('DATE(tbl_akt_akun.tgl_simpan) as tgl, tbl_akt_akun.kode, tbl_akt_akun.nama, tbl_akt_akun.keterangan, tbl_akt_akun_grup.nama as grup')

                                              ->join('tbl_akt_akun_grup', 'tbl_akt_akun_grup.id=tbl_akt_akun.id_akun_grup', 'INNER')

                                              ->order_by('tbl_akt_akun.id_akun_grup', 'asc')

                                              ->get('tbl_akt_akun')->result();

                }

            }else{

                if (!empty($query)) {

                    $data['biaya'] = $this->db->select('DATE(tbl_akt_akun.tgl_simpan) as tgl, tbl_akt_akun.kode, tbl_akt_akun.nama, tbl_akt_akun.keterangan, tbl_akt_akun_grup.nama as grup')

                                              ->join('tbl_akt_akun_grup', 'tbl_akt_akun_grup.id=tbl_akt_akun.id_akun_grup', 'INNER')

                                              ->like('tbl_akt_akun.nama', $query)

                                              ->limit($config['per_page'],$hal)

                                              ->order_by('tbl_akt_akun.id_akun_grup', 'asc')

                                              ->get('tbl_akt_akun')->result();

                } else {

                    $data['biaya'] = $this->db->limit($config['per_page'])

                                              ->order_by('id', 'asc')

                                              ->get('tbl_akt_akun_grup')->result();

                }

            }

            

            $this->pagination->initialize($config);

            

            $data['total_rows'] = $config['total_rows'];

            $data['PerPage']    = $config['per_page'];

            $data['pagination'] = $this->pagination->create_links();



            $this->load->view('admin-lte-2/1_atas', $data);

            $this->load->view('admin-lte-2/2_header', $data);

//            $this->load->view('admin-lte-2/3_navbar', $data);

            $this->load->view('admin-lte-2/includes/akuntability/data_akun_list', $data);

            $this->load->view('admin-lte-2/5_footer', $data);

            $this->load->view('admin-lte-2/6_bawah', $data);

        } else {

            $errors = $this->ion_auth->messages();

            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');

            redirect();

        }

    }

    

    public function data_akun_tambah() {

        if (akses::aksesLogin() == TRUE) {

            $id   = $this->input->get('id');

            

            $data['jenis']      = $this->db->get('tbl_akt_kas_jns')->result();

            $data['biaya']      = $this->db->select('DATE(tgl_simpan) as tgl, id, id_akun_grup, kode, keterangan, nama')->where('id', general::dekrip($id))->get('tbl_akt_akun')->row();



            $this->load->view('admin-lte-2/1_atas', $data);

            $this->load->view('admin-lte-2/2_header', $data);

//            $this->load->view('admin-lte-2/3_navbar', $data);

            $this->load->view('admin-lte-2/includes/akuntability/data_akun_tambah', $data);

            $this->load->view('admin-lte-2/5_footer', $data);

            $this->load->view('admin-lte-2/6_bawah', $data);

        } else {

            $errors = $this->ion_auth->messages();

            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');

            redirect();

        }

    }

    

    public function data_akun_simpan() {

        if (akses::aksesLogin() == TRUE) {

            $tgl          = explode('/',$this->input->post('tgl'));

            $kode         = $this->input->post('kode');

            $akun         = $this->input->post('akun');

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

                redirect(base_url('akuntability/data_akun_tambah.php'));

            } else {                

                $data_penj = array(

                    'tgl_simpan'  => date('Y-m-d H:i:s'),

                    'kode'        => $kode,

                    'id_akun_grup'=> $jenis,

                    'nama'        => $akun,

                    'keterangan'  => $ket,

                );

                

                $this->session->set_flashdata('member', '<div class="alert alert-success">Data Akun berhasil disimpan</div>');

                crud::simpan('tbl_akt_akun', $data_penj);

                redirect(base_url('akuntability/data_akun_list.php'));

            }

        } else {

            $errors = $this->ion_auth->messages();

            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');

            redirect();

        }

    }

    

    public function data_akun_update() {

        if (akses::aksesLogin() == TRUE) {

            $id           = $this->input->post('id');

            $kode         = $this->input->post('kode');

            $akun         = $this->input->post('akun');

            $jenis        = $this->input->post('jenis');

            $ket          = $this->input->post('keterangan');

            

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');



            $this->form_validation->set_rules('kode', 'kode', 'required');



            if ($this->form_validation->run() == FALSE) {

                $msg_error = array(

                    'kode'     => form_error('kode'),

                );



                $this->session->set_flashdata('form_error', $msg_error);

                redirect(base_url('akuntability/data_akun_tambah.php'));

            } else {                

                $data_penj = array(

                    'tgl_simpan'  => date('Y-m-d H:i:s'),

                    'kode'        => $kode,

                    'id_akun_grup'=> $jenis,

                    'nama'        => $akun,

                    'keterangan'  => $ket,

                );

                

                $this->session->set_flashdata('member', '<div class="alert alert-success">Data Akun berhasil disimpan</div>');

                crud::update('tbl_akt_akun','id',general::dekrip($id), $data_penj);

                redirect(base_url('akuntability/data_akun_list.php'));

            }

        } else {

            $errors = $this->ion_auth->messages();

            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');

            redirect();

        }

    }

    

    

    public function data_akun_hapus() {

        if (akses::aksesLogin() == TRUE) {

            $id = $this->input->get('id');

            

            if(!empty($id)){

                crud::delete('tbl_akt_akun','id',general::dekrip($id));

            }

            

            redirect(base_url('akuntability/data_akun_list.php'));

        } else {

            $errors = $this->ion_auth->messages();

            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');

            redirect();

        }

    }

    

    public function data_sawal_list() {

        if (akses::aksesLogin() == TRUE) {

            $query   = $this->input->get('q');

            $hal     = $this->input->get('halaman');

            $jml     = $this->input->get('jml');

            $jml_hal = (!empty($jml) ? $jml  : $this->db->order_by('id_akun_grup', 'asc')->get('tbl_akt_akun')->num_rows());

            

            $data['hasError'] = $this->session->flashdata('form_error');

                        

            $data['biaya'] = $this->db->select('tbl_akt_akun_grup.id as id_akun_grup, tbl_akt_akun_grup.nama as grup, tbl_akt_akun.nama, tbl_akt_akun.saldo_awal, tbl_akt_akun.saldo')

                                      ->join('tbl_akt_akun_grup', 'tbl_akt_akun_grup.id=tbl_akt_akun.id_akun_grup')

                                      ->order_by('tbl_akt_akun.id', 'asc')

                                      ->get('tbl_akt_akun')->result();



            $this->load->view('admin-lte-2/1_atas', $data);

            $this->load->view('admin-lte-2/2_header', $data);

//            $this->load->view('admin-lte-2/3_navbar', $data);

            $this->load->view('admin-lte-2/includes/akuntability/data_sawal_list', $data);

            $this->load->view('admin-lte-2/5_footer', $data);

            $this->load->view('admin-lte-2/6_bawah', $data);

        } else {

            $errors = $this->ion_auth->messages();

            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');

            redirect();

        }

    }    

    

    public function data_jur_jual_list() {

        if (akses::aksesLogin() == TRUE) {

            /* -- Grup hak akses -- */

            $grup        = $this->ion_auth->get_users_groups()->row();

            $id_user     = $this->ion_auth->user()->row()->id;

            $pengaturan  = $this->db->get('tbl_pengaturan')->row();



            /* -- Blok Filter -- */

            $query   = $this->input->get('q');

            $hal     = $this->input->get('halaman');

            $jml     = $this->input->get('jml');

            $jml_hal = (!empty($jml) ? $jml  : $this->db->count_all('tbl_trans_jual'));



            $bl = $this->input->get('bulan');

            $th = $this->input->get('tahun');

            $ak = $this->input->get('akun');

            /* -- End Blok Filter -- */



            /* -- Form Error -- */

            $data['hasError']                = $this->session->flashdata('form_error');



            /* -- Blok Pagination -- */

            $config['base_url']              = base_url('akuntability/data_jur_jual_list.php?bulan='.$bl.'&tahun='.$th.'&akun='.$ak.'&jml='.$jml);

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

                           ->where('status_nota', '3')

                           ->where('status_jurnal', '0')

                           ->limit($config['per_page'],$hal)

                           ->order_by('no_nota','desc')

                           ->get('tbl_trans_jual')->result();

            }else{

                   $data['penj'] = $this->db->select('no_nota, kode_nota_dpn, kode_nota_blk, kode_nota_dpn, kode_nota_blk, DATE(tgl_masuk) as tgl_masuk, DATE(tgl_bayar) as tgl_bayar, DATE(tgl_keluar) as tgl_keluar, jml_total, jml_gtotal, ppn, jml_ppn, id_user, id_sales, id_pelanggan, status_nota, status_bayar')

                           ->where('status_nota', '3')

                           ->where('status_jurnal', '0')

                           ->limit($config['per_page'],$hal)

                           ->order_by('no_nota','desc')

                           ->get('tbl_trans_jual')->result();

            }

            

            $data['akun']  = $this->db->get('tbl_akt_akun')->result();

            $data['akun2'] = $this->db->get('tbl_akt_akun')->result();

            

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

            $this->load->view('admin-lte-2/includes/akuntability/data_jur_jual_list',$data);

            $this->load->view('admin-lte-2/5_footer',$data);

            $this->load->view('admin-lte-2/6_bawah',$data);

        } else {

            $errors = $this->ion_auth->messages();

            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');

            redirect();

        }

    }



    public function data_jur_beli_list() {

        if (akses::aksesLogin() == TRUE) {

            /* -- Grup hak akses -- */

            $grup        = $this->ion_auth->get_users_groups()->row();

            $id_user     = $this->ion_auth->user()->row()->id;

            $pengaturan  = $this->db->get('tbl_pengaturan')->row();



            /* -- Blok Filter -- */

            $query  	 = $this->input->get('q');

            $hal    	 = $this->input->get('halaman');

            $jml    	 = $this->input->get('jml');

            $jml_hal	 = (!empty($jml) ? $jml  : $this->db->count_all('tbl_trans_beli'));



            $bl 		 = $this->input->get('bulan');

            $th			 = $this->input->get('tahun');

            $ak			 = $this->input->get('akun');

            /* -- End Blok Filter -- */



            /* -- Form Error -- */

            $data['hasError']                = $this->session->flashdata('form_error');



            /* -- Blok Pagination -- */

            $config['base_url']              = base_url('akuntability/data_jur_jual_list.php?bulan='.$bl.'&tahun='.$th.'&akun='.$ak.'&jml='.$jml);

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

                   $data['penj'] = $this->db->select('id, no_nota, DATE(tgl_masuk) as tgl_masuk, DATE(tgl_bayar) as tgl_bayar, DATE(tgl_keluar) as tgl_keluar, jml_total, jml_gtotal, status_nota, status_bayar')

                           ->where('status_nota', '3')

                           ->where('status_jurnal', '0')

                           ->limit($config['per_page'],$hal)

                           ->order_by('no_nota','desc')

                           ->get('tbl_trans_beli')->result();

            }else{

                   $data['penj'] = $this->db->select('id, no_nota, DATE(tgl_masuk) as tgl_masuk, DATE(tgl_bayar) as tgl_bayar, DATE(tgl_keluar) as tgl_keluar, jml_total, jml_gtotal, status_nota, status_bayar')

                           ->where('status_nota', '3')

                           ->where('status_jurnal', '0')

                           ->limit($config['per_page'],$hal)

                           ->order_by('no_nota','desc')

                           ->get('tbl_trans_beli')->result();

            }

            

            $data['akun']  = $this->db->get('tbl_akt_akun')->result();

            $data['akun2'] = $this->db->get('tbl_akt_akun')->result();

            

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

            $this->load->view('admin-lte-2/includes/akuntability/data_jur_beli_list',$data);

            $this->load->view('admin-lte-2/5_footer',$data);

            $this->load->view('admin-lte-2/6_bawah',$data);

        } else {

            $errors = $this->ion_auth->messages();

            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');

            redirect();

        }

    }

    

    

    

    public function data_jurnal_list() {

        if (akses::aksesLogin() == TRUE) {

            $query   = $this->input->get('q');

            $hal     = $this->input->get('halaman');

            $jml     = $this->input->get('jml');

            $jml_hal = (!empty($jml) ? $jml  : $this->db->where('tipe', 'masuk')->get('tbl_akt_kas')->num_rows());

            

            $data['hasError'] = $this->session->flashdata('form_error');

                        

            $config['base_url']               = base_url('akuntability/data_jurnal_list.php?'.(isset($_GET['q']) ? '&q='.$_GET['q'].'&jml='.$_GET['jml'] : ''));

            $config['total_rows']             = $jml_hal;

            

            $config['query_string_segment']  = 'halaman';

            $config['page_query_string']     = TRUE;

            $config['per_page']              = 20;

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

                    $data['biaya'] = $this->db->select('DATE(tgl_simpan) as tgl, id, id_jenis, kode, keterangan, nominal')->where('tipe', 'masuk')->limit($config['per_page'],$hal)->like('nama', $query)->get('tbl_akt_kas')->result();

                } else {

                    $data['biaya'] = $this->db->select('DATE(tgl_simpan) as tgl, id, id_jenis, kode, keterangan, nominal')->where('tipe', 'masuk')->limit($config['per_page'],$hal)->order_by('id','asc')->get('tbl_akt_kas')->result();

                }

            }else{

                if (!empty($query)) {

                    $data['biaya'] = $this->db->select('DATE(tgl_simpan) as tgl, id, id_jenis, kode, keterangan, nominal')->where('tipe', 'masuk')->limit($config['per_page'],$hal)->like('nama', $query)->get('tbl_akt_kas')->result();

                } else {

                    $data['biaya'] = $this->db->select('tbl_akt_jurnal.tgl_masuk as tgl, tbl_akt_jurnal.no as kode, tbl_akt_jurnal.role, tbl_akt_akun.nama as akun, tbl_akt_jurnal_det.id_akun, tbl_akt_jurnal_det.debit_kredit, tbl_akt_jurnal_det.nilai')

                                              ->join('tbl_akt_jurnal', 'tbl_akt_jurnal.id=tbl_akt_jurnal_det.id_jurnal')

                                              ->join('tbl_akt_akun', 'tbl_akt_akun.id=tbl_akt_jurnal_det.id_akun')

                                              ->limit($config['per_page'])

                                              ->get('tbl_akt_jurnal_det')->result();

                }

            }

            

            $this->pagination->initialize($config);

            

            $data['total_rows'] = $config['total_rows'];

            $data['PerPage']    = $config['per_page'];

            $data['pagination'] = $this->pagination->create_links();



            $this->load->view('admin-lte-2/1_atas', $data);

            $this->load->view('admin-lte-2/2_header', $data);

//            $this->load->view('admin-lte-2/3_navbar', $data);

            $this->load->view('admin-lte-2/includes/akuntability/data_jurnal_list', $data);

            $this->load->view('admin-lte-2/5_footer', $data);

            $this->load->view('admin-lte-2/6_bawah', $data);

        } else {

            $errors = $this->ion_auth->messages();

            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');

            redirect();

        }

    }

    

    

    public function set_jur_jual_cari() {

        if (akses::aksesLogin() == TRUE) {

            $bulan   = $this->input->post('bulan');

            $tahun   = $this->input->post('tahun');

            $akun_deb= $this->input->post('akun_deb');

            $akun_krd= $this->input->post('akun_krd');

            

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('bulan', 'Bulan', 'required');

            $this->form_validation->set_rules('tahun', 'Taun', 'required');

            $this->form_validation->set_rules('akun_deb', 'Akun', 'required');

            $this->form_validation->set_rules('akun_krd', 'Akun', 'required');



            if ($this->form_validation->run() == FALSE) {

                $msg_error = array(

                    'bulan'  => form_error('bulan'),

                    'tahun'  => form_error('tahun'),

                    'akun_deb'   => form_error('akun_deb'),

                    'akun_krd'   => form_error('akun_krd'),

                );



                $this->session->set_flashdata('form_error', $msg_error);

                redirect(base_url('akuntability/data_jur_jual_list.php'));

            } else {                

                $sql = $this->db->where('status_nota', '3')->like('MONTH(tgl_simpan)', $bulan, 'match')->like('YEAR(tgl_simpan)', $tahun, 'match')->get('tbl_trans_jual');

                

                if($sql->num_rows() > 0){

                    redirect(base_url('akuntability/data_jur_jual_list.php?bulan='.$bulan.'&tahun='.$tahun.'&akun_deb='.$akun_deb.'&akun_krd='.$akun_krd.'&jml='.$sql->num_rows()));

                }else{

                    redirect(base_url('akuntability/data_jur_jual_list.php'));

                }

            }

        } else {

            $errors = $this->ion_auth->messages();

            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');

            redirect();

        }

    }

    

    public function set_jur_jual_simpan() {

        if (akses::aksesLogin() == TRUE) {

            $id      = $this->input->get('id');

            $bulan   = $this->input->get('bulan');

            $tahun   = $this->input->get('tahun');

            $akun_deb= $this->input->get('akun_deb');

            $akun_krd= $this->input->get('akun_krd');

            

            if(!empty($id)){

                $sql_num = $this->db->where('id_jurnal_tipe', '1')->where('role', 'jual')->get('tbl_akt_jurnal')->num_rows();

                $sql     = $this->db->where('no_nota', general::dekrip($id))->get('tbl_trans_jual')->row();

                $kode    = 'ju-'.sprintf("%05s", $sql_num + 1);

                

                $jurnal = array(

                    'tgl_simpan'        => date('Y-m-d H:i:s'),

                    'tgl_masuk'         => date('Y-m-d'),

                    'id_jurnal_tipe'    => '1',

                    'id_transaksi'      => general::dekrip($id),

                    'no'                => $kode,

                    'login_id'          => $this->ion_auth->user()->row()->id,

                    'role'              => 'jual',

                );

                

                crud::simpan('tbl_akt_jurnal', $jurnal);

                $sql_max = $this->db->select_max('id')->get('tbl_akt_jurnal')->row();

                

                $jurnal_det_deb = array(

                    'id_jurnal'    => $sql_max->id,

                    'id_akun'      => $akun_deb,

                    'item'         => '1',

                    'debit_kredit' => '1',

                    'nilai'        => $sql->jml_gtotal,

                );

                crud::simpan('tbl_akt_jurnal_det', $jurnal_det_deb);

                

                $jurnal_det_krd = array(

                    'id_jurnal'    => $sql_max->id,

                    'id_akun'      => $akun_krd,

                    'item'         => '2',

                    'debit_kredit' => '0',

                    'nilai'        => $sql->jml_gtotal,

                );

                crud::simpan('tbl_akt_jurnal_det', $jurnal_det_krd);

                

                crud::update('tbl_trans_jual', 'no_nota', $sql->no_nota, array('status_jurnal'=>'1'));

                

                $sql_cari = $this->db->where('status_nota', '3')->like('MONTH(tgl_simpan)', $bulan, 'match')->like('YEAR(tgl_simpan)', $tahun, 'match')->get('tbl_trans_jual');

                redirect(base_url('akuntability/data_jur_jual_list.php?bulan='.$bulan.'&tahun='.$tahun.'&akun_deb='.$akun_deb.'&akun_krd='.$akun_krd.'&jml='.$sql_cari->num_rows()));

            }else{

                redirect(base_url('akuntability/data_jur_jual_list.php'));

            }

        } else {

            $errors = $this->ion_auth->messages();

            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');

            redirect();

        }

    }

    

    public function set_jur_beli_cari() {

        if (akses::aksesLogin() == TRUE) {

            $bulan   = $this->input->post('bulan');

            $tahun   = $this->input->post('tahun');

            $akun_deb= $this->input->post('akun_deb');

            $akun_krd= $this->input->post('akun_krd');

            

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            $this->form_validation->set_rules('bulan', 'Bulan', 'required');

            $this->form_validation->set_rules('tahun', 'Taun', 'required');

            $this->form_validation->set_rules('akun_deb', 'Akun', 'required');

            $this->form_validation->set_rules('akun_krd', 'Akun', 'required');



            if ($this->form_validation->run() == FALSE) {

                $msg_error = array(

                    'bulan'  => form_error('bulan'),

                    'tahun'  => form_error('tahun'),

                    'akun_deb'   => form_error('akun_deb'),

                    'akun_krd'   => form_error('akun_krd'),

                );



                $this->session->set_flashdata('form_error', $msg_error);

                redirect(base_url('akuntability/data_jur_beli_list.php'));

            } else {                

                $sql = $this->db->where('status_nota', '3')->like('MONTH(tgl_simpan)', $bulan, 'match')->like('YEAR(tgl_simpan)', $tahun, 'match')->get('tbl_trans_beli');

                

                if($sql->num_rows() > 0){

                    redirect(base_url('akuntability/data_jur_beli_list.php?bulan='.$bulan.'&tahun='.$tahun.'&akun_deb='.$akun_deb.'&akun_krd='.$akun_krd.'&jml='.$sql->num_rows()));

                }else{

                    redirect(base_url('akuntability/data_jur_beli_list.php'));

                }

            }

        } else {

            $errors = $this->ion_auth->messages();

            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');

            redirect();

        }

    }

    

    public function set_jur_beli_simpan() {

        if (akses::aksesLogin() == TRUE) {

            $id      = $this->input->get('id');

            $bulan   = $this->input->get('bulan');

            $tahun   = $this->input->get('tahun');

            $akun_deb= $this->input->get('akun_deb');

            $akun_krd= $this->input->get('akun_krd');

            

            if(!empty($id)){

                $sql_num = $this->db->where('id_jurnal_tipe', '1')->where('role', 'beli')->get('tbl_akt_jurnal')->num_rows();

                $sql     = $this->db->where('id', general::dekrip($id))->get('tbl_trans_beli')->row();

                $kode    = 'ju-'.sprintf("%05s", $sql_num + 1);

                

                $jurnal = array(

                    'tgl_simpan'        => date('Y-m-d H:i:s'),

                    'tgl_masuk'         => date('Y-m-d'),

                    'id_jurnal_tipe'    => '1',

                    'id_transaksi'      => general::dekrip($id),

                    'no'                => $kode,

                    'login_id'          => $this->ion_auth->user()->row()->id,

                    'role'              => 'beli',

                );

                

                crud::simpan('tbl_akt_jurnal', $jurnal);

                $sql_max = $this->db->select_max('id')->get('tbl_akt_jurnal')->row();

                

                $jurnal_det_deb = array(

                    'id_jurnal'    => $sql_max->id,

                    'id_akun'      => $akun_deb,

                    'item'         => '1',

                    'debit_kredit' => '1',

                    'nilai'        => $sql->jml_gtotal,

                );

                crud::simpan('tbl_akt_jurnal_det', $jurnal_det_deb);

                

                $jurnal_det_krd = array(

                    'id_jurnal'    => $sql_max->id,

                    'id_akun'      => $akun_krd,

                    'item'         => '2',

                    'debit_kredit' => '0',

                    'nilai'        => $sql->jml_gtotal,

                );

                crud::simpan('tbl_akt_jurnal_det', $jurnal_det_krd);

                

                crud::update('tbl_trans_beli', 'id', $sql->id, array('status_jurnal'=>'1'));

                

                $sql_cari = $this->db->where('status_nota', '3')->like('MONTH(tgl_simpan)', $bulan, 'match')->like('YEAR(tgl_simpan)', $tahun, 'match')->get('tbl_trans_jual');

                redirect(base_url('akuntability/data_jur_beli_list.php?bulan='.$bulan.'&tahun='.$tahun.'&akun_deb='.$akun_deb.'&akun_krd='.$akun_krd.'&jml='.$sql_cari->num_rows()));

            }else{

                redirect(base_url('akuntability/data_jur_beli_list.php'));

            }

        } else {

            $errors = $this->ion_auth->messages();

            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');

            redirect();

        }

    }

    

    

    public function set_cari_pems() {

        if (akses::aksesLogin() == TRUE) {

            $id = $this->input->post('pencarian');

            

            if(!empty($id)){

                $jml = $this->db

                                ->where('tipe', 'masuk')

                                ->like('keterangan', $id)

                                ->get('tbl_akt_kas')->num_rows();

                redirect(base_url('akuntability/data_pems_list.php?q='.$id.'&jml='.$jml));

            }else{

                redirect(base_url('master/data_pems_list.php'));

            }

        } else {

            $errors = $this->ion_auth->messages();

            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');

            redirect();

        }

    }

    

    

    public function set_cari_biaya() {

        if (akses::aksesLogin() == TRUE) {

            $id = $this->input->post('pencarian');

            

            if(!empty($id)){

                $jml = $this->db

                                ->where('tipe', 'keluar')

                                ->like('keterangan', $id)

                                ->get('tbl_akt_kas')->num_rows();

                redirect(base_url('akuntability/data_peng_list.php?q='.$id.'&jml='.$jml));

            }else{

                redirect(base_url('master/data_peng_list.php'));

            }

        } else {

            $errors = $this->ion_auth->messages();

            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');

            redirect();

        }

    }

    

    public function set_cari_pers() {

        if (akses::aksesLogin() == TRUE) {

            $id = $this->input->post('pencarian');

            

            if(!empty($id)){

                $jml = $this->db->like('nominal',$id)

                                ->or_like('keterangan',$id)

                                ->or_like('DATE(tgl_simpan)', $this->tanggalan->tgl_indo_sys($id))

                            ->get('tbl_akt_persediaan')->num_rows();

                redirect(base_url('akuntability/data_pers_list.php?q='.$id.'&jml='.$jml));

            }else{

                redirect(base_url('akuntability/data_pers_list.php'));

            }

        } else {

            $errors = $this->ion_auth->messages();

            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');

            redirect();

        }

    }

    



    

    

//    

//    public function set_jur_jual_cari() {

//        if (akses::aksesLogin() == TRUE) {

//            $bulan   = $this->input->post('bulan');

//            $tahun   = $this->input->post('tahun');

//            $akun    = $this->input->post('akun');

//            

//            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

//            $this->form_validation->set_rules('bulan', 'Bulan', 'required');

//            $this->form_validation->set_rules('tahun', 'Taun', 'required');

//            $this->form_validation->set_rules('akun', 'Akun', 'required');

//

//            if ($this->form_validation->run() == FALSE) {

//                $msg_error = array(

//                    'bulan'  => form_error('bulan'),

//                    'tahun'  => form_error('tahun'),

//                    'akun'   => form_error('akun'),

//                );

//

//                $this->session->set_flashdata('form_error', $msg_error);

//                redirect(base_url('akuntability/data_jur_jual_list.php'));

//            } else {                

//                $sql = $this->db->where('status_nota', '3')->like('MONTH(tgl_simpan)', $bulan, 'match')->like('YEAR(tgl_simpan)', $tahun, 'match')->get('tbl_trans_jual');

//                

//                if($sql->num_rows() > 0){

//                    redirect(base_url('akuntability/data_jur_jual_list.php?bulan='.$bulan.'&tahun='.$tahun.'&akun='.$akun.'&jml='.$sql->num_rows()));

//                }else{

//                    redirect(base_url('akuntability/data_jur_jual_list.php'));

//                }

//            }

//        } else {

//            $errors = $this->ion_auth->messages();

//            $this->session->set_flashdata('login', '<div class="alert alert-danger">Authentifikasi gagal, silahkan login ulang!!</div>');

//            redirect();

//        }

//    }



}

