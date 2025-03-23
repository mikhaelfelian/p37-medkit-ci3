<?php

/**
 * Description of sinkronisasi
 *
 * @author TK006
 */
class sinkronisasi extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $this->load->dbforge();
    }
    
    public function trans_eksport() {
        if (akses::aksesLogin() == TRUE) {
            $data['pengaturan'] = $this->db->query("SELECT * FROM tbl_pengaturan")->result();
            $data['trans_exp']  = $this->db->select('id, DATE(tgl_simpan) as tgl, TIME(tgl_simpan) as jam, file')->get('tbl_util_eksport');
            $data['user']       = $this->ion_auth->user()->row();
            $data['raw_data']   = file_get_contents(realpath('./file/export').'/'.$_GET['file']);
            $data['hasError']   = $this->session->flashdata('form_error');

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/includes/pengaturan/trans_eksp', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }

    public function trans_import() {
        if (akses::aksesLogin() == TRUE) {
            $data['pengaturan'] = $this->db->query("SELECT * FROM tbl_pengaturan")->result();
            $data['trans_exp']  = $this->db->select('DATE(tgl_simpan) as tgl, TIME(tgl_simpan) as jam, file')->get('tbl_util_import');
            $data['user']       = $this->ion_auth->user()->row();
            $data['raw_data']   = file_get_contents(realpath('./file/export').'/'.$_GET['file']);
            $data['hasError']   = $this->session->flashdata('form_error');

            $this->load->view('admin-lte-2/1_atas', $data);
            $this->load->view('admin-lte-2/2_header', $data);
            $this->load->view('admin-lte-2/includes/pengaturan/trans_import', $data);
            $this->load->view('admin-lte-2/5_footer', $data);
            $this->load->view('admin-lte-2/6_bawah', $data);
        } else {
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }
    
    public function eksport_create() {
        if (akses::aksesLogin() == TRUE) {
            $dbs        = $this->dbutil->list_databases();
            $user       = $this->ion_auth->user()->row();
            $tabel      = $this->db->list_tables();
            $setting    = $this->db->get('tbl_pengaturan')->row();
            $app        = $this->db->where('id', $this->ion_auth->user()->row()->id_app)->get('tbl_pengaturan_cabang')->row();
            
            /* Table wants to export */
//          tbl_ion_users
            $sql_user = $this->db->get('tbl_ion_users');
            foreach ($sql_user->result() as $trans) {
                $tbl_ion_users[] = array(
                    'id'           => $trans->id,
                    'id_app'       => $trans->id_app,
                    'username'     => $trans->username,
                    'password'     => $trans->password,
                    'first_name'   => $trans->first_name,
                );
            }
            
//          tbl_ion_users_group
            $sql_user_grup = $this->db->get('tbl_ion_users_groups');
            foreach ($sql_user_grup->result() as $trans) {
                $tbl_ion_users_groups[] = array(
                    'id'           => $trans->id,
                    'user_id'      => $trans->user_id,
                    'group_id'     => $trans->group_id,
                );
            }
            
//          tbl_m_kategori
            if($app->id == '1'){
                $sql_kategori = $this->db->get('tbl_m_kategori');
                foreach ($sql_kategori->result() as $trans) {
                    $tbl_m_kategori[] = array(
                        'id'           => $trans->id,
                        'id_app'       => $trans->id_app,
                        'tgl_simpan'   => $trans->tgl_simpan,
                        'kategori'     => $trans->kategori,
                        'keterangan'   => $trans->keterangan,
                    );
                }
            }
            
            // tbl_m_produk
            // Jika pusat, maka ekspor jml stoknya
            if($app->id == '1'){
                $sql_produk = $this->db->get('tbl_m_produk');
                foreach ($sql_produk->result() as $trans) {
                    $tbl_m_produk[] = array(
                        'id'            => $trans->id,
                        'tgl_simpan'    => $trans->tgl_simpan,
                        'kode'          => $trans->kode,
                        'produk'        => $trans->produk,
                        'jml'           => $trans->jml,
                        'harga_beli'    => $trans->harga_beli,
                        'harga_jual'    => $trans->harga_jual,
                        'harga_grosir'  => $trans->harga_grosir,
                        'status_promo'  => $trans->status_promo,
                    );
                }
            }     
            
            // tbl_m_produk_promo
            if($app->id == '1'){
                $sql_produk_promo = $this->db->get('tbl_m_produk_promo');
                foreach ($sql_produk_promo->result() as $trans) {
                    $tbl_m_produk_promo[] = array(
                        'id_produk'   => $trans->id_produk,
                        'id_promo'    => $trans->id_promo,
                        'tgl_simpan'  => $trans->tgl_simpan,
                        'tgl_mulai'   => $trans->tgl_mulai,
                        'tgl_akhir'   => $trans->tgl_akhir,
                        'disk1'       => $trans->disk1,
                        'disk2'       => $trans->disk2,
                        'disk3'       => $trans->disk3,
                    );
                }
            }

            // tbl_m_pelanggan
            $sql_pelanggan = $this->db->get('tbl_m_pelanggan');
            foreach ($sql_pelanggan->result() as $trans) {
                $tbl_m_pelanggan[] = array(
                    'id'          => $trans->id,
                    'id_app'      => $trans->id_app,
                    'id_grup'     => $trans->id_grup,
                    'tgl_simpan'  => $trans->tgl_simpan,
                    'kode'        => $trans->kode,
                    'nik'         => $trans->nik,
                    'nama'        => $trans->nama,
                    'nama_toko'   => $trans->nama_toko,
                    'no_hp'       => $trans->no_hp,
                    'lokasi'      => $trans->lokasi,
                    'alamat'      => $trans->alamat,
                    'status_plgn' => $trans->status_plgn
                );
            }
			
            // tbl_m_promo
            if($app->id == '1'){
                $sql_promo = $this->db->get('tbl_m_promo');
                foreach ($sql_promo->result() as $trans) {
                    $tbl_m_promo[] = array(
                        'id'          => $trans->id,
                        'tgl_simpan'  => $trans->tgl_simpan,
                        'promo'       => $trans->promo,
                        'keterangan'  => $trans->keterangan,
                    );
                }
            }
			
            // tbl_trans_jual
            $sql_trans_jual = $this->db->where('id_app', $app->id)->get('tbl_trans_jual');
            foreach ($sql_trans_jual->result() as $trans) {
                $tbl_trans_jual[] = array(
                    'id_app'        => $trans->id_app,
                    'no_nota'       => $trans->no_nota,
                    'kode_nota_dpn' => $trans->kode_nota_dpn,
                    'kode_nota_blk' => $trans->kode_nota_blk,
                    'kode_fp'       => $trans->kode_fp,
                    'tgl_simpan'    => $trans->tgl_simpan,
                    'tgl_masuk'     => $trans->tgl_masuk,
                    'tgl_keluar'    => $trans->tgl_keluar,
                    'id_kategori'   => $trans->id_kategori,
                    'id_pelanggan'  => $trans->id_pelanggan,
                    'id_sales'      => $trans->id_sales,
                    'id_user'       => $trans->id_user,
                    'ppn'           => $trans->ppn,
                    'jml_total'     => $trans->jml_total,
                    'jml_diskon'    => $trans->jml_diskon,
                    'jml_subtotal'  => $trans->jml_subtotal,
                    'jml_ppn'       => $trans->jml_ppn,
                    'jml_gtotal'    => $trans->jml_gtotal,
                    'jml_bayar'     => $trans->jml_bayar,
                    'jml_kembali'   => $trans->jml_kembali,
                    'status_nota'   => $trans->status_nota,
                    'status_bayar'  => $trans->status_bayar,
                    'status_ppn'    => $trans->status_ppn,
                );
            }
			
            // tbl_trans_jual_det
            $sql_trans_jual_det = $this->db->select('tbl_trans_jual.no_nota, tbl_trans_jual_det.tgl_simpan, tbl_trans_jual_det.id_satuan, tbl_trans_jual_det.satuan, tbl_trans_jual_det.keterangan, tbl_trans_jual_det.kode, tbl_trans_jual_det.produk, tbl_trans_jual_det.jml, tbl_trans_jual_det.jml_satuan, tbl_trans_jual_det.harga, tbl_trans_jual_det.disk1, tbl_trans_jual_det.disk2, tbl_trans_jual_det.disk3, tbl_trans_jual_det.diskon, tbl_trans_jual_det.potongan, tbl_trans_jual_det.subtotal')->where('tbl_trans_jual.id_app', $app->id)->join('tbl_trans_jual', 'tbl_trans_jual.no_nota=tbl_trans_jual_det.no_nota')->get('tbl_trans_jual_det');
            foreach ($sql_trans_jual_det->result() as $trans) {
                $tbl_trans_jual_det[] = array(
                    'no_nota'   => $trans->no_nota,
                    'tgl_simpan'=> $trans->tgl_simpan,
                    'id_satuan' => $trans->id_satuan,
                    'satuan'    => $trans->satuan,
                    'keterangan'=> $trans->keterangan,
                    'kode'      => $trans->kode,
                    'produk'    => $trans->produk,
                    'jml'       => $trans->jml,
                    'jml_satuan'=> $trans->jml_satuan,
                    'harga'     => $trans->harga,
                    'disk1'     => $trans->disk1,
                    'disk2'     => $trans->disk2,
                    'disk3'     => $trans->disk3,
                    'diskon'    => $trans->diskon,
                    'potongan'  => $trans->potongan,
                    'subtotal'  => $trans->subtotal,
                );
            }
			
            // tbl_trans_jual_diskon
            $sql_trans_jual_diskon = $this->db->select('tbl_trans_jual.no_nota, tbl_trans_jual_diskon.id_pelanggan, tbl_trans_jual_diskon.tgl_simpan, tbl_trans_jual_diskon.kode, tbl_trans_jual_diskon.disk1, tbl_trans_jual_diskon.disk2, tbl_trans_jual_diskon.disk3')->where('tbl_trans_jual.id_app', $app->id)->join('tbl_trans_jual', 'tbl_trans_jual.no_nota=tbl_trans_jual_diskon.no_nota')->get('tbl_trans_jual_diskon');
            foreach ($sql_trans_jual_diskon->result() as $trans) {
                $tbl_trans_jual_diskon[] = array(
                    'id_pelanggan'  => $trans->id_pelanggan,
                    'tgl_simpan'    => $trans->tgl_simpan,
                    'no_nota'       => $trans->no_nota,
                    'kode'          => $trans->kode,
                    'disk1'         => $trans->disk1,
                    'disk2'         => $trans->disk2,
                    'disk3'         => $trans->disk3
                );
            }
			
            // tbl_trans_jual_plat
            $sql_trans_jual_plat = $this->db->select('tbl_trans_jual.no_nota, tbl_trans_jual_plat.tgl_simpan, tbl_trans_jual_plat.id_platform, tbl_trans_jual_plat.platform, tbl_trans_jual_plat.keterangan, tbl_trans_jual_plat.nominal')->where('tbl_trans_jual.id_app', $app->id)->join('tbl_trans_jual', 'tbl_trans_jual.id=tbl_trans_jual_plat.id_penjualan')->get('tbl_trans_jual_plat');
            foreach ($sql_trans_jual_plat->result() as $trans) {
                $tbl_trans_jual_plat[] = array(
                    'id_platform'   => $trans->id_platform,
                    'tgl_simpan'    => $trans->tgl_simpan,
                    'no_nota'       => $trans->no_nota,
                    'platform'      => $trans->platform,
                    'keterangan'    => $trans->keterangan,
                    'nominal'       => $trans->nominal
                );
            }
			
            // tbl_trans_jual_hist
            $sql_trans_jual_hist = $this->db->select('tbl_trans_jual.no_nota, tbl_trans_jual_hist.tgl_simpan, tbl_trans_jual_hist.no_nota, tbl_trans_jual_hist.stok')->where('tbl_trans_jual.id_app', $app->id)->join('tbl_trans_jual', 'tbl_trans_jual.no_nota=tbl_trans_jual_hist.no_nota')->get('tbl_trans_jual_hist');
            foreach ($sql_trans_jual_hist->result() as $trans) {
                $tbl_trans_jual_hist[] = array(
                    'id_produk'   => $trans->id_platform,
                    'tgl_simpan'  => $trans->tgl_simpan,
                    'no_nota'     => $trans->no_nota,
                    'stok'        => $trans->stok,
                );
            }
            
            // tbl_pengaturan_cabang
            $sql_pengaturan_cabang = $this->db->get('tbl_pengaturan_cabang');
            foreach ($sql_pengaturan_cabang->result() as $trans) {
                $tbl_pengaturan_cabang[] = array(
                    'id'            => $trans->id,
                    'tgl_simpan'    => $trans->tgl_simpan,
                    'keterangan'    => $trans->keterangan,
                );
            }
            
            // export to json
            $backup = array(
                            'tbl_ion_users'                 => $tbl_ion_users,
                            'tbl_ion_users_groups'          => $tbl_ion_users_groups,
                            'tbl_m_kategori'                => $tbl_m_kategori,
                            'tbl_m_produk'                  => $tbl_m_produk,
                            'tbl_m_produk_promo'            => $tbl_m_produk_promo,
                            'tbl_m_pelanggan'               => $tbl_m_pelanggan,
                            'tbl_m_promo'                   => $tbl_m_promo,
                            'tbl_trans_jual'                => $tbl_trans_jual,
                            'tbl_trans_jual_det'            => $tbl_trans_jual_det,
                            'tbl_trans_jual_diskon'         => $tbl_trans_jual_diskon,
                            'tbl_trans_jual_plat'           => $tbl_trans_jual_plat,
                            'tbl_trans_jual_hist'           => $tbl_trans_jual_hist,
                            'tbl_pengaturan_cabang'         => $tbl_pengaturan_cabang
                        );

            if (isset($_GET['file'])) {
                $path = realpath('./file/export') . '/';
                $file = $path . $this->input->get('file');
                force_download($_GET['file']);
            } else {
                $path       = realpath('./file/export') . '/';
                $file       = 'pos_' . date('YmdHi') . '_' . str_replace(array('-','.',' '), '_', $app->keterangan) . '.json';
                $output     = json_encode($backup);

                $data = array(
                    'tgl_simpan' => date('Y-m-d H:i:s'),
                    'file'       => $file
                );

                crud::simpan('tbl_util_eksport', $data);
                write_file($path . $file, $output);
                $this->session->set_flashdata('pengaturan', '<div class="alert alert-success">Eksport data, berhasil dibuat !!</div>');
                redirect(base_url('sinkronisasi/data_export_list.php'));
            }
        } else {
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }

    public function eksport_hapus() {
        if (akses::aksesLogin() == TRUE) {
            $file    = $this->input->get('file');
            $id      = $this->input->get('id');
            $folder  = realpath('file/export').'/';
            
            if(!empty($id)){
                unlink($folder.$file);
                crud::delete('tbl_util_eksport','id', general::dekrip($id));
            }
            
            redirect(base_url('sinkronisasi/data_export_list.php'));
        } else {
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }

    public function eksport_download() {
        if (akses::aksesLogin() == TRUE) {
            $dbs     = $this->dbutil->list_databases();
            $user    = $this->ion_auth->user()->row();
            $tabel   = $this->db->list_tables();
            $setting = $this->db->get('tbl_pengaturan')->row();
            $app     = $this->db->where('id', $setting->id_app)->get('tbl_pengaturan_cabang')->row();

            $path = realpath('./file/export').'/';
            $file = $path.$this->input->get('file');
            
            ob_clean();
            force_download($this->input->get('file'), file_get_contents($file));
            
        } else {
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }
    
    
    public function import_create() {
        if (akses::aksesLogin() == TRUE) {

            if (!empty($_FILES['frestore']['name'])) {
                $folder = realpath('file/import');
                $config['upload_path']      = './file/import';
                $config['allowed_types']    = 'json|txt|app';
                $config['remove_spaces']    = TRUE;
                $config['overwrite']        = TRUE;
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('frestore')) {
                    $this->session->set_flashdata('pengaturan', 'Error : <b>' . $this->upload->display_errors() . '</b>.');
                    redirect(base_url('sinkronisasi/data_import_list.php?err_msg=' . $this->upload->display_errors()));
                } else {
                    $f = $this->upload->data();

                    $path = realpath('./file/import') . '/';
                    $file = file_get_contents($path . $f['orig_name']);
                    $json = json_decode($file, TRUE);

                    if (!empty($json)) {
                        foreach ($json['tbl_m_kategori'] as $kat) {
                            $sql_cek = $this->db->where('id',$kat['id'])->get('tbl_m_kategori');

                            if($sql_cek->num_rows() == 0){
                                crud::simpan('tbl_m_kategori', $kat);
                            }
                        }
                        
                        foreach ($json['tbl_m_pelanggan'] as $kat) {
                            $sql_cek = $this->db->where('id', $kat['id'])->get('tbl_m_pelanggan');

                            if ($sql_cek->num_rows() == 0) {
                                crud::simpan('tbl_m_pelanggan', $kat);
                            } else {
                                crud::update('tbl_m_pelanggan', 'id', $kat['id'], $kat);
                            }
                        }
                        
                        $i = 0;
                        foreach ($json['tbl_trans_jual'] as $trans) {
                            $sql_cek = $this->db->where('no_nota', $trans['no_nota'])->where('id_app', $trans['id_app'])->get('tbl_trans_jual');
                            
                            $tbl_trans_jual = array(
                                'id_app'        => $trans['id_app'],
                                'no_nota'       => $trans['no_nota'],
                                'kode_nota_dpn' => $trans['kode_nota_dpn'],
                                'kode_nota_blk' => $trans['kode_nota_blk'],
                                'kode_fp'       => $trans['kode_fp'],
                                'tgl_simpan'    => $trans['tgl_simpan'],
                                'tgl_masuk'     => $trans['tgl_masuk'],
                                'tgl_keluar'    => $trans['tgl_keluar'],
                                'id_kategori'   => $trans['id_kategori'],
                                'id_pelanggan'  => $trans['id_pelanggan'],
                                'id_sales'      => $trans['id_sales'],
                                'id_user'       => $trans['id_user'],
                                'ppn'           => $trans['ppn'],
                                'jml_total'     => $trans['jml_total'],
                                'jml_diskon'    => $trans['jml_diskon'],
                                'jml_subtotal'  => $trans['jml_subtotal'],
                                'jml_ppn'       => $trans['jml_ppn'],
                                'jml_gtotal'    => $trans['jml_gtotal'],
                                'jml_bayar'     => $trans['jml_bayar'],
                                'jml_kembali'   => $trans['jml_kembali'],
                                'status_nota'   => $trans['status_nota'],
                                'status_bayar'  => $trans['status_bayar'],
                                'status_ppn'    => $trans['status_ppn'],
                            );
							
                            if($sql_cek->num_rows() == 0){
                                crud::simpan('tbl_trans_jual', $tbl_trans_jual);
                                $last_id = $this->db->insert_id();
                                
                                foreach ($json['tbl_trans_jual_det'] as $trans_det){
                                    $tbl_trans_jual_det[$i] = array(
                                        'id_penjualan'  => $last_id,
                                        'no_nota'       => $trans_det['no_nota'],
                                        'tgl_simpan'    => $trans_det['tgl_simpan'],
                                        'id_satuan'     => $trans_det['id_satuan'],
                                        'satuan'        => $trans_det['satuan'],
                                        'keterangan'    => $trans_det['keterangan'],
                                        'kode'          => $trans_det['kode'],
                                        'produk'        => $trans_det['produk'],
                                        'jml'           => $trans_det['jml'],
                                        'jml_satuan'    => $trans_det['jml_satuan'],
                                        'harga'         => $trans_det['harga'],
                                        'disk1'         => $trans_det['disk1'],
                                        'disk2'         => $trans_det['disk2'],
                                        'disk3'         => $trans_det['disk3'],
                                        'diskon'        => $trans_det['diskon'],
                                        'potongan'      => $trans_det['potongan'],
                                        'subtotal'      => $trans_det['subtotal'],
                                    );
                                    
                                    crud::simpan('tbl_trans_jual_det', $tbl_trans_jual_det[$i]);
                                }
                                    
								
                                foreach ($json['tbl_trans_jual_plat'] as $trans_plat){
                                    $tbl_trans_jual_plat[$i] = array(
                                        'id_penjualan'  => $last_id,
                                        'id_platform'   => $trans_plat['id_platform'],
                                        'tgl_simpan'    => $trans_plat['tgl_simpan'],
                                        'no_nota'       => $trans_plat['no_nota'],
                                        'platform'      => $trans_plat['platform'],
                                        'keterangan'    => $trans_plat['keterangan'],
                                        'nominal'       => $trans_plat['nominal'],
                                    );
                                    
                                    crud::simpan('tbl_trans_jual_plat', $tbl_trans_jual_plat[$i]);
                                }
                            }else{
                                $this->db
                                        ->where('no_nota', $trans['no_nota'])
                                        ->where('id_app', $trans['id_app'])
                                        ->update('tbl_trans_jual', $tbl_trans_jual);
                            }
                            
                            $i++;
                        }


                        $data = array(
                            'tgl_simpan' => date('Y-m-d H:i:s'),
                            'file'       => $f['orig_name']
                        );

                        crud::simpan('tbl_util_import', $data);
                        redirect(base_url('sinkronisasi/data_import_list.php?msg=sukses'));
                    } else {
                        redirect(base_url('sinkronisasi/data_import_list.php?msg=gagal'));
                    }
                }
            } else {
                
            }
        } else {
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }

    public function import_hapus() {
        if (akses::aksesLogin() == TRUE) {
            $file    = $this->input->get('file');
            $id      = $this->input->get('id');
            $folder  = realpath('file/import').'/';
            
            if(!empty($id)){
                unlink($folder.$file);
                crud::delete('tbl_util_import','id', general::dekrip($id));
            }
            
            redirect(base_url('pengaturan/eksport.php'));
        } else {
            $this->session->set_flashdata('login', '<div class="alert alert-danger">Maaf, anda session habis. Silahkan login ulang.</div>');
            redirect();
        }
    }
}
