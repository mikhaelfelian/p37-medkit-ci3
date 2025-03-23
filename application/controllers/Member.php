<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php



/**

 * Description of produk

 *

 * @author mike

 */



class member extends CI_Controller {

    //put your code here

    function __construct() {

        parent::__construct();

    }

    

    public function member_list() {

        if (akses::aksesLogin() == TRUE) {

            $query   = $this->input->get('q');

            $hal     = $this->input->get('halaman');

            $jml     = $this->input->get('jml');

            $jml_hal = (!empty($jml) ? $jml  : $this->db->count_all('tbl_m_pelanggan'));

            

            $data['hasError'] = $this->session->flashdata('form_error');

                        

            $config['base_url']               = base_url('member.php?'.(isset($_GET['q']) ? '&q='.$_GET['q'].'&jml='.$_GET['jml'] : ''));

            $config['total_rows']             = $jml_hal;

            

            $config['query_string_segment']  = 'halaman';

            $config['page_query_string']     = TRUE;

            $config['per_page']              = 10;

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

                    $data['pelanggan'] = $this->db->limit($config['per_page'],$hal)->like('nama', $query)->get('tbl_m_pelanggan')->result();

                } else {

                    $data['pelanggan'] = $this->db->limit($config['per_page'],$hal)->order_by('id','asc')->get('tbl_m_pelanggan')->result();

                }

            }else{

                if (!empty($query)) {

                    $data['pelanggan'] = $this->db->limit($config['per_page'],$hal)->like('nama', $query)->get('tbl_m_pelanggan')->result();

                } else {

                    $data['pelanggan'] = $this->db->limit($config['per_page'])->order_by('id','asc')->get('tbl_m_pelanggan')->result();

                }

            }

            

            $this->pagination->initialize($config);

            

            $data['total_rows'] = $config['total_rows'];

            $data['PerPage']    = $config['per_page'];

            $data['pagination'] = $this->pagination->create_links();



            $this->load->view('admin-lte-2/1_atas', $data);

            $this->load->view('admin-lte-2/2_header', $data);

//            $this->load->view('admin-lte-2/3_navbar', $data);

            $this->load->view('admin-lte-2/includes/member/member_list', $data);

            $this->load->view('admin-lte-2/5_footer', $data);

            $this->load->view('admin-lte-2/6_bawah', $data);

        } else {

            $errors = $this->ion_auth->messages();

            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');

            redirect();

        }

    }



    public function member_ubah() {

        if (akses::aksesLogin() == TRUE) {

            $id = $this->input->get('id');

            $data['member']       = $this->db->where('id', general::dekrip($id))->get('tbl_m_pelanggan')->row();

            $data['member_saldo'] = $this->db->where('id_pelanggan', general::dekrip($id))->get('tbl_m_pelanggan_deposit')->row();

            $data['member_hist']  = $this->db->select('id_pelanggan, DATE(tgl_simpan) as tgl_simpan, jml_deposit, keterangan')->where('id_pelanggan', general::dekrip($id))->get('tbl_m_pelanggan_deposit_hist')->result();

            $data['member_tipe']  = $this->db->get('tbl_m_pelanggan_grup');

            

            $this->load->view('admin-lte-2/1_atas', $data);

            $this->load->view('admin-lte-2/2_header', $data);

            $this->load->view('admin-lte-2/includes/member/member_ubah', $data);

            $this->load->view('admin-lte-2/5_footer', $data);

            $this->load->view('admin-lte-2/6_bawah', $data);

        } else {

            $errors = $this->ion_auth->messages();

            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');

            redirect();

        }

    }



    public function member_deposit() {

        if (akses::aksesLogin() == TRUE) {

            $id = $this->input->get('id');

            $data['member']       = $this->db->join('tbl_m_pelanggan_grup','tbl_m_pelanggan_grup.id=tbl_m_pelanggan.id_grup')->where('tbl_m_pelanggan.id', general::dekrip($id))->get('tbl_m_pelanggan')->row();

            $data['member_saldo'] = $this->db->where('id_pelanggan', general::dekrip($id))->get('tbl_m_pelanggan_deposit')->row();

            $data['member_hist']  = $this->db->select('id_pelanggan, DATE(tgl_simpan) as tgl_simpan, jml_deposit, debet, kredit, keterangan')->where('id_pelanggan', general::dekrip($id))->get('tbl_m_pelanggan_deposit_hist')->result();

            

            $this->load->view('admin-lte-2/1_atas', $data);

            $this->load->view('admin-lte-2/2_header', $data);

            $this->load->view('admin-lte-2/includes/member/member_deposit', $data);

            $this->load->view('admin-lte-2/5_footer', $data);

            $this->load->view('admin-lte-2/6_bawah', $data);

        } else {

            $errors = $this->ion_auth->messages();

            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');

            redirect();

        }

    }

    

    public function member_simpan() {

        if (akses::aksesLogin() == TRUE) {

            $id           = $this->input->post('id');

            $nik          = $this->input->post('nik');

            $nama         = $this->input->post('nama');

            $no_hp        = $this->input->post('no_hp');

            $alamat       = $this->input->post('alamat');

            $tipe_member  = $this->input->post('tipe_member');

            

            $pengaturan = $this->db->get('tbl_pengaturan')->row();



            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');



            $this->form_validation->set_rules('nik', 'NIK', 'required');



            if ($this->form_validation->run() == FALSE) {

                $msg_error = array(

                    'nik'     => form_error('nik'),

                );



                $this->session->set_flashdata('form_error', $msg_error);

                redirect(base_url('member/member_ubah.php?id='.$id));

            } else {

                $sql_num = $this->db->get('tbl_m_pelanggan')->num_rows() + 1;

                $kode    = sprintf('%05d', $sql_num);

                

                $data_penj = array(

                    'id_app'      => $pengaturan->id_app,

                    'id_grup'     => $tipe_member,

                    'nik'         => $nik,

                    'nama'        => $nama,

                    'no_hp'       => $no_hp,

                    'alamat'      => $alamat

                );

                

                $this->session->set_flashdata('member', '<div class="alert alert-success">Data member berhasil diubah</div>');

                crud::update('tbl_m_pelanggan','id', general::dekrip($id),$data_penj);

                redirect(base_url('member/member_ubah.php?id='.$id));

            }

        } else {

            $errors = $this->ion_auth->messages();

            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');

            redirect();

        }

    }



    public function member_hps() {

        if (akses::aksesLogin() == TRUE) {

            $id = $this->input->get('id');

            

            if(!empty($id)){

                crud::delete('tbl_m_pelanggan','id',general::dekrip($id));

            }

            

            redirect('page=produk&act=prod_pelanggan_list');

        } else {

            $errors = $this->ion_auth->messages();

            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');

            redirect();

        }

    }

    

    public function member_simpan2() {

        if (akses::aksesLogin() == TRUE) {

            $nik     = $this->input->post('nik');

            $nama    = $this->input->post('nama');

            $no_hp   = $this->input->post('no_hp');

            $alamat  = $this->input->post('alamat');

            $tipe_member  = $this->input->post('tipe_member');            

            $pengaturan = $this->db->get('tbl_pengaturan')->row();

//

//            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

//

//            $this->form_validation->set_rules('nama', 'Nama Pelanggan', 'required');

//

//            if ($this->form_validation->run() == FALSE) {

//                $msg_error = array(

//                    'nama'     => form_error('nama'),

//                );

//

//                $this->session->set_flashdata('form_error', $msg_error);

//                redirect('page=produk&act=prod_plgn_list');

//            } else {

                $sql_num = $this->db->select('MAX(kode) as kode')->get('tbl_m_pelanggan')->row();

                $num     = (int)$sql_num->kode + 1;

                $kode    = sprintf('%05d', $num);

                                

                $data_penj = array(

                    'id_app'      => $pengaturan->id_app,

                    'id_grup'     => $tipe_member,

                    'tgl_simpan'  => date('Y-m-d H:i:s'),

                    'kode'        => $kode,

                    'nik'         => $nik,

                    'nama'        => $nama,

                    'no_hp'       => $no_hp,

                    'alamat'      => $alamat

                );

                

                crud::simpan('tbl_m_pelanggan',$data_penj);

                echo 'done!!';

//                redirect('page=produk&act=prod_plgn_list');

//            }

        } else {

            $errors = $this->ion_auth->messages();

            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');

            redirect();

        }

    }

    

    public function member_deposit_simpan() {

        if (akses::aksesLogin() == TRUE) {

            $id   = $this->input->post('id');

            $dep  = str_replace('.', '', $this->input->post('jml_deposit'));

            $pengaturan  = $this->db->get('tbl_pengaturan')->row();



            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');



            $this->form_validation->set_rules('id', 'Nama Pelanggan', 'required');



            if ($this->form_validation->run() == FALSE) {

                $msg_error = array(

                    'id'     => form_error('id'),

                );



                $this->session->set_flashdata('form_error', $msg_error);

                redirect('page=produk&act=prod_pelanggan_list');

            } else {

                $sql_dep = $this->db->where('id_pelanggan', general::dekrip($id))->get('tbl_m_pelanggan_deposit');

                $jml_dep = $sql_dep->row()->jml_deposit + $dep;

                

                if($sql_dep->num_rows() > 0){

                    $data_penj = array(

                        'tgl_modif'     => date('Y-m-d H:i:s'),

                        'jml_deposit'   => $jml_dep

                    );

                    

                    $data_log = array(

                        'tgl_simpan'    => date('Y-m-d H:i:s'),

                        'id_app'        => $pengaturan->id_app,

                        'id_pelanggan'  => general::dekrip($id),

                        'id_user'       => $this->ion_auth->user()->row()->id,

                        'jml_deposit'   => $jml_dep,

                        'kredit'        => $dep,

                        'keterangan'    => 'Deposit sebesar '.general::format_angka($dep),

                    );

                    

                    crud::update('tbl_m_pelanggan_deposit','id',$sql_dep->row()->id,$data_penj);

                    crud::simpan('tbl_m_pelanggan_deposit_hist',$data_log);

                }else{

                    $data_penj = array(

                        'tgl_simpan'    => date('Y-m-d H:i:s'),

                        'id_app'        => $pengaturan->id_app,

                        'id_pelanggan'  => general::dekrip($id),

                        'jml_deposit'   => $jml_dep,

                    );

                    

                    $data_log = array(

                        'tgl_simpan'    => date('Y-m-d H:i:s'),

                        'id_app'        => $pengaturan->id_app,

                        'id_pelanggan'  => general::dekrip($id),

                        'id_user'       => $this->ion_auth->user()->row()->id,

                        'jml_deposit'   => $jml_dep,

                        'kredit'        => $jml_dep,

                        'keterangan'    => 'Deposit pertama sebesar '.general::format_angka($jml_dep),

                    );

                    

                    crud::simpan('tbl_m_pelanggan_deposit',$data_penj);

                    crud::simpan('tbl_m_pelanggan_deposit_hist',$data_log);

                }                

                

                redirect(base_url('member/member_deposit.php?id='.$id));

            }

        } else {

            $errors = $this->ion_auth->messages();

            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');

            redirect();

        }

    }

}





//

//  

//    public function prod_plgngrp_list() {

//        if (akses::aksesLogin() == TRUE) {

//            $query   = $this->input->get('q');

//            $hal     = $this->input->get('halaman');

//            $jml     = $this->input->get('jml');

//            $jml_hal = (!empty($jml) ? $jml  : $this->db->count_all('tbl_m_pelanggan_grup'));

//            

//            $data['hasError'] = $this->session->flashdata('form_error');

//                        

//            $config['base_url']               = site_url('page=produk&act=prod_plgngrp_list'.(isset($_GET['q']) ? '&q='.$_GET['q'].'&jml='.$_GET['jml'] : ''));

//            $config['total_rows']             = $jml_hal;

//            

//            $config['query_string_segment']  = 'halaman';

//            $config['page_query_string']     = TRUE;

//            $config['per_page']              = 10;

//            $config['num_links']             = 2;

//            

//            $config['first_tag_open']        = '<li>';

//            $config['first_tag_close']       = '</li>';

//            

//            $config['prev_tag_open']         = '<li>';

//            $config['prev_tag_close']        = '</li>';

//            

//            $config['num_tag_open']          = '<li>';

//            $config['num_tag_close']         = '</li>';

//            

//            $config['next_tag_open']         = '<li>';

//            $config['next_tag_close']        = '</li>';

//            

//            $config['last_tag_open']         = '<li>';

//            $config['last_tag_close']        = '</li>';

//            

//            $config['cur_tag_open']          = '<li><a href="#"><b>';

//            $config['cur_tag_close']         = '</b></a></li>';

//            

//            $config['first_link']            = '&laquo;';

//            $config['prev_link']             = '&lsaquo;';

//            $config['next_link']             = '&rsaquo;';

//            $config['last_link']             = '&raquo;';

//            

//            

//            if(!empty($hal)){

//                if (!empty($query)) {

//                    $data['pelanggan'] = $this->db->limit($config['per_page'],$hal)->like('nama', $query)->get('tbl_m_pelanggan_grup')->result();

//                } else {

//                    $data['pelanggan'] = $this->db->limit($config['per_page'],$hal)->order_by('id','asc')->get('tbl_m_pelanggan_grup')->result();

//                }

//            }else{

//                if (!empty($query)) {

//                    $data['pelanggan'] = $this->db->limit($config['per_page'],$hal)->like('nama', $query)->get('tbl_m_pelanggan_grup')->result();

//                } else {

//                    $data['pelanggan'] = $this->db->limit($config['per_page'])->order_by('id','asc')->get('tbl_m_pelanggan_grup')->result();

//                }

//            }

//            

//            $this->pagination->initialize($config);

//            

//            $data['total_rows'] = $config['total_rows'];

//            $data['PerPage']    = $config['per_page'];

//            $data['pagination'] = $this->pagination->create_links();

//            

//            if(isset($_GET['id'])){

//                $data['pelanggan_agt'] = $this->db->select('tbl_m_pelanggan.id, tbl_m_pelanggan.nama, tbl_m_pelanggan.lokasi')->where('tbl_m_pelanggan.id_grup', '0')->where('tbl_m_pelanggan.id !=', '1')->order_by('tbl_m_pelanggan.kode','asc')->get('tbl_m_pelanggan')->result();

//            }

//

//            $this->load->view('admin-lte-2/1_atas', $data);

//            $this->load->view('admin-lte-2/2_header', $data);

//            $this->load->view('admin-lte-2/3_navbar', $data);

//            $this->load->view('admin-lte-2/includes/produk/prod_plgngrp_list', $data);

//            $this->load->view('admin-lte-2/5_footer', $data);

//            $this->load->view('admin-lte-2/6_bawah', $data);

//        } else {

//            $errors = $this->ion_auth->messages();

//            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');

//            redirect();

//        }

//    }

//

//    public function prod_plgngrp_simpan() {

//        if (akses::aksesLogin() == TRUE) {

//            $grup    = $this->input->post('grup');

//            $diskon  = str_replace(array('.'), '', $this->input->post('diskon'));

//            $ket     = $this->input->post('keterangan');

//

//            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

//

//            $this->form_validation->set_rules('grup', 'Grup Pelanggan', 'required');

//

//            if ($this->form_validation->run() == FALSE) {

//                $msg_error = array(

//                    'grup'     => form_error('grup'),

//                );

//

//                $this->session->set_flashdata('form_error', $msg_error);

//                redirect('page=produk&act=prod_plgngrp_list');

//            } else {                

//                $data_penj = array(

//                    'tgl_simpan'  => date('Y-m-d H:i'),

//                    'grup'        => $grup,

//                    'potongan'    => $diskon,

//                    'keterangan'  => $ket

//                );

//                

//                crud::simpan('tbl_m_pelanggan_grup',$data_penj);

//                redirect('page=produk&act=prod_plgngrp_list');

//            }

//        } else {

//            $errors = $this->ion_auth->messages();

//            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');

//            redirect();

//        }

//    }

//

//    public function prod_plgngrp_simpan_agt() {

//        if (akses::aksesLogin() == TRUE) {

//            $id    = $this->input->post('id');

//

//            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

//

//            $this->form_validation->set_rules('id', 'ID Pelanggan', 'required');

//

//            if ($this->form_validation->run() == FALSE) {

//                $msg_error = array(

//                    'id'     => form_error('id'),

//                );

//

//                $this->session->set_flashdata('form_error', $msg_error);

//                redirect('page=produk&act=prod_plgngrp_list');

//            } else {   

////                if(isset($_POST['ck'])){

//                    /* Mengurai array cekbox */

//                    foreach ($_POST['ck'] as $key => $ck){

//                        $sql = $this->db->where('id',general::dekrip($ck))->get('tbl_m_pelanggan_grup')->row();

//                        

//                        crud::update('tbl_m_pelanggan','id',$key,array('id_grup'=>general::dekrip($ck)));

//                        crud::simpan('tbl_m_pelanggan_agt',array('id_pelanggan_grup'=>general::dekrip($ck), 'id_pelanggan'=>$key, 'potongan'=>$sql->potongan));

//                    }

//                    

//                    redirect('page=produk&act=prod_plgngrp_list');

////                }

//            }

//        } else {

//            $errors = $this->ion_auth->messages();

//            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');

//            redirect();

//        }

//    }

//

//    public function prod_plgngrp_hapus() {

//        if (akses::aksesLogin() == TRUE) {

//            $id = $this->input->get('id');

//            

//            if(!empty($id)){

//                crud::delete('tbl_m_pelanggan_grup','id',general::dekrip($id));

//            }

//            

//            redirect('page=produk&act=prod_plgngrp_list');

//        } else {

//            $errors = $this->ion_auth->messages();

//            $this->session->set_flashdata('login_toast', 'toastr.error("Authentifikasi gagal, silahkan login ulang!!");');

//            redirect();

//        }

//    }