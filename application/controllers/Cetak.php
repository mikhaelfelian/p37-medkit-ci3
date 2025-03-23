<?php
/**
 * Description of cetak
 *
 * @author tk006
 */
class cetak extends CI_Controller {
    private $nama_printer;
    
    public function __construct() {
        parent::__construct();
        $this->nama_printer = "psf-kasir2";
    }
     
    public function termal_ctk(){
            require_once(realpath("./framework/libraries/escpos/Escpos.php"));
            
            $id   = $this->input->get('id');
            $rute = $this->input->get('route');
            
            $connector  = new WindowsPrintConnector($this->nama_printer);
//            $connector  = new FilePrintConnector($this->nama_printer);
            $printer    = new Escpos($connector);
            
            $pengaturan    = $this->db->get('tbl_pengaturan')->row();
            $sql_penj      = $this->db->select('id, DAY(tgl_masuk) as d, MONTH(tgl_masuk) as m, tgl_masuk as tgl_simpan, TIME(tgl_simpan) as wkt_simpan, no_nota, kode_nota_dpn, kode_nota_blk, jml_total, jml_diskon, jml_biaya, jml_retur, jml_gtotal, jml_bayar, jml_kembali, jml_ongkir, id_user, id_sales, metode_bayar')->where('id', general::dekrip($id))->get('tbl_trans_jual')->row();
            $sql_penj_det  = $this->db->where('id_penjualan', $sql_penj->id)->get('tbl_trans_jual_det')->result();
            $sql_penj_sum  = $this->db->select("SUM(jml) as jml")->where('id_penjualan', $sql_penj->id)->get('tbl_trans_jual_det')->row();
            $sql_penj_plat = $this->db->select('DATE(tgl_simpan) as tgl_simpan, HOUR(tgl_simpan) as jam, MINUTE(tgl_simpan) as menit, id, id_platform, platform, keterangan, nominal')->where('id_penjualan', $sql_penj->id)->get('tbl_trans_jual_plat')->row();
            $sql_plat 	   = $this->db->where('id', $sql_penj_plat->id_platform)->get('tbl_m_platform')->row();
            $sql_sales     = $this->db->where('id', $sql_penj->id_sales)->get('tbl_m_sales')->row();
            $nama          = explode(' ', $this->ion_auth->user($sql_penj->id_user)->row()->first_name);

            $printer->pulse();
            $printer->setJustification(Escpos::JUSTIFY_CENTER);
            $printer->text(strtoupper($pengaturan->judul."\n"));
            $printer->text(strtoupper($pengaturan->kota)."\n");            
            $printer->setJustification(Escpos::JUSTIFY_LEFT);
            $printer->text($nama[0]." - ".$this->tanggalan->tgl_indo2($sql_penj->tgl_simpan)." ".$sql_penj->wkt_simpan." ".$sql_penj->no_nota."/".$sql_penj->kode_nota_blk."\n");
            $printer->text("========================================\n");
            $printer->text("\n");

            $jml_brg = 0;
            foreach ($sql_penj_det as $nota_det) {
                $str  = strlen($nota_det->produk);
                $str2 = ($str > 34 ? substr($nota_det->produk, 0, 34) : $nota_det->produk);

                $printer->setJustification(Escpos::JUSTIFY_LEFT);
                $printer->text(strtoupper($str2).($nota_det->status_brg == '1' ? ' [R]' : '')."\n");
                $printer->setJustification(Escpos::JUSTIFY_RIGHT);
                $printer->text(" " . $nota_det->jml. " (".ucwords($nota_det->satuan).")" . " x ".general::format_angka($nota_det->harga)." = ".general::format_angka($nota_det->subtotal). "\n");
                
                $jml_brg = $jml_brg + $nota_det->jml;
            }
            
            $printer->setJustification(Escpos::JUSTIFY_LEFT);
            $printer->text("----------------------------------------\n");
            $printer->text("JUMLAH BRG   : ".$jml_brg."\n");
            $printer->text("JUMLAH ITEM  : ".$sql_penj_sum->jml."\n");
            $printer->text("----------------------------------------\n");
            $printer->setJustification(Escpos::JUSTIFY_LEFT);
            $printer -> setTextSize(1, 1);
            $printer->text("TOTAL      : ".general::format_angka($sql_penj->jml_total)."\n");
            $printer->text("ONGKIR     : ".general::format_angka($sql_penj->jml_ongkir)."\n");
            $printer->text("DISKON     : ".general::format_angka($sql_penj->jml_diskon)."\n");
            if($sql_penj_plat->id_platform != '1'){
                $printer->text("CHARGE     : ".general::format_angka($sql_penj->jml_biaya)."\n");
            }
            
            if($sql_penj->jml_retur != '0'){
                $printer->text("RETUR      : ".general::format_angka($sql_penj->jml_retur)."\n");
            }
            
            //$printer->text("RETUR      : ".general::format_angka($sql_penj->jml_retur)."\n");
            $printer->text("GRANDTOTAL : ".general::format_angka($sql_penj->jml_gtotal)."\n");
            
            if($sql_penj_plat->id_platform == '1'){
                $printer->text("TUNAI      : ".general::format_angka($sql_penj->jml_bayar)."\n");
            }else{
                $printer->text("NON TUNAI  : ".general::format_angka($sql_penj->jml_bayar)."\n");
            }
            $printer->text("KEMBALI    : ".general::format_angka($sql_penj->jml_kembali)."\n");

            if($sql_penj_plat->id_platform == '1'){
                $printer->text("METODE BYR : TUNAI\n");
            }else{
                $printer->text("METODE BYR : ".$sql_plat->platform." ".(int)$sql_plat->persen."%\n");
                $printer->text($sql_penj_plat->platform." ".$sql_penj_plat->keterangan."\n");
            }
            
            $printer->text("----------------------------------------\n");
            $printer->setJustification(Escpos::JUSTIFY_CENTER);
            $printer->text("HARGA SUDAH TERMASUK PAJAK\n");
            $printer->text("BARANG YANG SUDAH DIBELI\n");
            $printer->text("TIDAK DAPAT DIKEMBALIKAN\n");
            $printer->text("TERIMAKASIH ATAS KUNJUNGAN ANDA\n");
            $printer->text("========================================\n");
            $printer->cut(Escpos::CUT_FULL, 15);
            $printer->close();
            
            redirect(base_url(!empty($rute) ? $rute.'.php?id='.$id : 'transaksi/set_nota_jual_umum.php'));
    }     
     
    public function termal_ctk_tmp(){
            require_once(realpath("./framework/libraries/escpos/Escpos.php"));
            
            $id   = $this->input->get('id');
            $rute = $this->input->get('route');
            
            $connector  = new WindowsPrintConnector($this->nama_printer);
//            $connector  = new FilePrintConnector($this->nama_printer);
            $printer    = new Escpos($connector);
            
            $pengaturan    = $this->db->get('tbl_pengaturan')->row();
            $sql_penj      = $this->db->select('id, DAY(tgl_masuk) as d, MONTH(tgl_masuk) as m, tgl_masuk as tgl_simpan, TIME(tgl_simpan) as wkt_simpan, no_nota, kode_nota_dpn, kode_nota_blk, jml_total, jml_diskon, jml_biaya, jml_retur, jml_gtotal, jml_bayar, jml_kembali, jml_ongkir, id_user, id_sales, metode_bayar')->where('id', general::dekrip($id))->get('tbl_trans_jual')->row();
            $sql_penj_det  = $this->cart->contents();
            $sql_penj_sum  = $this->db->select("SUM(jml) as jml")->where('id_penjualan', $sql_penj->id)->get('tbl_trans_jual_det')->row();
            $sql_penj_plat = $this->db->select('DATE(tgl_simpan) as tgl_simpan, HOUR(tgl_simpan) as jam, MINUTE(tgl_simpan) as menit, id, id_platform, platform, keterangan, nominal')->where('id_penjualan', $sql_penj->id)->get('tbl_trans_jual_plat')->row();
            $sql_plat 	   = $this->db->where('id', $sql_penj_plat->id_platform)->get('tbl_m_platform')->row();
            $sql_sales     = $this->db->where('id', $sql_penj->id_sales)->get('tbl_m_sales')->row();
            $nama          = explode(' ', $this->ion_auth->user($sql_penj->id_user)->row()->first_name);

//            $printer->pulse();
            $printer->setJustification(Escpos::JUSTIFY_CENTER);
            $printer->text(strtoupper($pengaturan->judul."\n"));
            $printer->text(strtoupper($pengaturan->kota)."\n");            
            $printer->setJustification(Escpos::JUSTIFY_LEFT);
            $printer->text($nama[0]." - ".$this->tanggalan->tgl_indo2($sql_penj->tgl_simpan)." ".$sql_penj->wkt_simpan." ".$sql_penj->no_nota."/".$sql_penj->kode_nota_blk."\n");
            $printer->text("========================================\n");
            $printer->text("\n");

            foreach ($sql_penj_det as $nota_det) {
                $str  = strlen($nota_det->produk);
                $str2 = ($str > 34 ? substr($nota_det->produk, 0, 34) : $nota_det->produk);

                $printer->setJustification(Escpos::JUSTIFY_LEFT);
                $printer->text(strtoupper($str2).($nota_det->status_brg == '1' ? ' [R]' : '')."\n");
                $printer->setJustification(Escpos::JUSTIFY_RIGHT);
                $printer->text(" " . $nota_det->jml. " (".ucwords($nota_det->satuan).")" . " x ".general::format_angka($nota_det->harga)." = ".general::format_angka($nota_det->subtotal). "\n");
            }
            
            $printer->setJustification(Escpos::JUSTIFY_LEFT);
            $printer->text("----------------------------------------\n");
            $printer->text("JUMLAH ITEM  : ".$sql_penj_sum->jml."\n");
            $printer->text("----------------------------------------\n");
            $printer->setJustification(Escpos::JUSTIFY_LEFT);
            $printer->text("TOTAL      : ".general::format_angka($sql_penj->jml_total)."\n");
            $printer->text("ONGKIR     : ".general::format_angka($sql_penj->jml_ongkir)."\n");
            $printer->text("DISKON     : ".general::format_angka($sql_penj->jml_diskon)."\n");
            if($sql_penj_plat->id_platform != '1'){
                $printer->text("CHARGE     : ".general::format_angka($sql_penj->jml_biaya)."\n");
            }
            
            if($sql_penj->jml_retur != '0'){
                $printer->text("RETUR      : ".general::format_angka($sql_penj->jml_retur)."\n");
            }
            
            //$printer->text("RETUR      : ".general::format_angka($sql_penj->jml_retur)."\n");
            $printer->text("GRANDTOTAL : ".general::format_angka($sql_penj->jml_gtotal)."\n");
            
            if($sql_penj_plat->id_platform == '1'){
                $printer->text("TUNAI      : ".general::format_angka($sql_penj->jml_bayar)."\n");
            }else{
                $printer->text("NON TUNAI  : ".general::format_angka($sql_penj->jml_bayar)."\n");
            }
            $printer->text("KEMBALI    : ".general::format_angka($sql_penj->jml_kembali)."\n");

            if($sql_penj_plat->id_platform == '1'){
                $printer->text("METODE BYR : TUNAI\n");
            }else{
                $printer->text("METODE BYR : ".$sql_plat->platform." ".(int)$sql_plat->persen."%\n");
                $printer->text($sql_penj_plat->platform." ".$sql_penj_plat->keterangan."\n");
            }
            
            $printer->text("----------------------------------------\n");
            $printer->setJustification(Escpos::JUSTIFY_CENTER);
            $printer->text("HARGA SUDAH TERMASUK PAJAK\n");
            $printer->text("BARANG YANG SUDAH DIBELI\n");
            $printer->text("TIDAK DAPAT DIKEMBALIKAN\n");
            $printer->text("TERIMAKASIH ATAS KUNJUNGAN ANDA\n");
            $printer->text("========================================\n");
            $printer->cut(Escpos::CUT_FULL, 15);
            $printer->close();
            
            redirect(base_url(!empty($rute) ? $rute.'.php?id='.$id : 'transaksi/set_nota_jual_umum.php'));
    }     
     
    public function termal_ctk_retjual(){
            require_once(realpath("./framework/libraries/escpos/Escpos.php"));
            
            $id   = $this->input->get('id');
            $rute = $this->input->get('route');
            
            $connector  = new WindowsPrintConnector($this->nama_printer);
            $printer    = new Escpos($connector);
            
            $pengaturan    = $this->db->get('tbl_pengaturan')->row();
            $sql_penj      = $this->db->select('id, DATE(tgl_simpan) as tgl_simpan, TIME(tgl_simpan) as wkt_simpan, no_retur, no_nota, jml_total, jml_retur, id_user, id_pelanggan, id_penjualan')->where('id', general::dekrip($id))->get('tbl_trans_retur_jual')->row();
            $sql_penj_det  = $this->db->where('id_retur_jual', $sql_penj->id)->order_by('status_retur', 'asc')->get('tbl_trans_retur_jual_det')->result();
            $sql_penj_sum  = $this->db->select("SUM(jml) as jml")->where('id_retur_jual', $sql_penj->id)->where('status_retur', '1')->get('tbl_trans_retur_jual_det')->row();
            $sql_penj_sum1 = $this->db->select("SUM(subtotal) as subtotal")->where('id_retur_jual', $sql_penj->id)->where('status_retur <', '3')->get('tbl_trans_retur_jual_det')->row();
            $sql_penj_sum2 = $this->db->select("SUM(subtotal) as subtotal")->where('id_retur_jual', $sql_penj->id)->where('status_retur', '3')->get('tbl_trans_retur_jual_det')->row();
            $sql_penj_plat = $this->db->select('DATE(tgl_simpan) as tgl_simpan, HOUR(tgl_simpan) as jam, MINUTE(tgl_simpan) as menit, id, id_platform, platform, keterangan, nominal')->where('id_penjualan', $sql_penj->id)->get('tbl_trans_jual_plat')->result();
            $sql_sales     = $this->db->where('id', $sql_penj->id_sales)->get('tbl_m_sales')->row();

            $printer->setJustification(Escpos::JUSTIFY_CENTER);
            $printer->text(strtoupper($pengaturan->judul."\n"));
            $printer->text(strtoupper($pengaturan->kota)."\n");
            $printer->text("NOTA RETUR\n");
            $printer->setJustification(Escpos::JUSTIFY_LEFT);
            $printer->text($this->ion_auth->user($sql_penj->id_user)->row()->first_name." - ".$this->tanggalan->tgl_indo2($sql_penj->tgl_simpan)." ".$sql_penj->no_retur."\n");
            $printer->text("========================================\n");
            $printer->text("\n");

            foreach ($sql_penj_det as $nota_det) {
                $str  = strlen($nota_det->produk);
                $str2 = ($str > 34 ? substr($nota_det->produk, 0, 34) : $nota_det->produk);

                if($nota_det->status_retur == '1'){
                    $printer->setJustification(Escpos::JUSTIFY_LEFT);
//                  $printer->text($str2.' ['.general::status_retur_cetak($nota_det->status_retur).']'."\n");
                    $printer->text($str2.' [R]'."\n");
                    $printer->setJustification(Escpos::JUSTIFY_RIGHT);
                    $printer->text(" " . $nota_det->jml. " (".ucwords($nota_det->satuan).")" . " x ".general::format_angka($nota_det->harga)." = ".general::format_angka($nota_det->subtotal). "\n");
                }
            }
            
            $selisih    = $sql_penj_sum1->subtotal - $sql_penj_sum2->subtotal;
            $jml_total  = str_replace('-', '', $selisih);

            $printer->setJustification(Escpos::JUSTIFY_LEFT);
            $printer->text("----------------------------------------\n");
            $printer->text("JUMLAH ITEM  : ".$sql_penj_sum->jml."\n");
            $printer->text("----------------------------------------\n");
            $printer->setJustification(Escpos::JUSTIFY_LEFT);
//            if($selisih < 0){
//                $printer->text("JML BAYAR    : ".($selisih < 0 ? '-' : '').general::format_angka($jml_total)."\n");
//            }else{
                $printer->text("JML RETUR  : ".general::format_angka($sql_penj->jml_total)."\n");    
//            }
//            $printer->text("----------------------------------------\n");
//            $printer->setJustification(Escpos::JUSTIFY_CENTER);
//            $printer->text("HARGA SUDAH TERMASUK PAJAK\n");
            $printer->text("========================================\n");
            $printer->cut(Escpos::CUT_FULL, 15);
            $printer->close();
            
            redirect(base_url(!empty($rute) ? $rute.'.php?id='.$id : 'transaksi/data_retur_jual_list.php'));
    }
     
    public function termal_ctk_rkp_ksr(){
            require_once(realpath("./framework/libraries/escpos/Escpos.php"));
            
            $id          = $this->ion_auth->user()->row()->id;
            $rute        = $this->input->get('route');
            $tgl_awal    = $this->input->get('tgl_awal');
            $tgl_akhr    = $this->input->get('tgl_akhir');
            $met_bayar   = $this->input->get('metode');

            $connector   = new WindowsPrintConnector($this->nama_printer);
            //$connector   = new FilePrintConnector("ebong_dungu.txt");
            $printer     = new Escpos($connector);

            $pengaturan  = $this->db->get('tbl_pengaturan')->row();
            $status_rkp  = $this->ion_auth->user()->row()->status_rkp;
            
            if(!empty($met_bayar)){
                $sql_penj    = $this->db->select('id, DAY(tgl_masuk) as d, MONTH(tgl_masuk) as m, tgl_masuk as tgl_simpan, TIME(tgl_simpan) as wkt_simpan, HOUR(tgl_simpan) as h, MINUTE(tgl_simpan) as i, no_nota, kode_nota_dpn, kode_nota_blk, jml_gtotal, jml_bayar, jml_kembali, id_user, id_sales, metode_bayar')->where('id_user', $id)->where('DATE(tgl_masuk) >=', $tgl_awal)->where('DATE(tgl_masuk) <=', $tgl_akhr)->like('metode_bayar', (!empty($met_bayar) ? $met_bayar : ''))->get('tbl_trans_jual')->result();
            }else{
                if($status_rkp == '1'){
                    $sql_penj    = $this->db->select('id, DAY(tgl_masuk) as d, MONTH(tgl_masuk) as m, tgl_masuk as tgl_simpan, TIME(tgl_simpan) as wkt_simpan, HOUR(tgl_simpan) as h, MINUTE(tgl_simpan) as i, no_nota, kode_nota_dpn, kode_nota_blk, jml_gtotal, jml_bayar, jml_kembali, id_user, id_sales, metode_bayar')->where('id_user', $id)->or_where('status_grosir', '1')->where('DATE(tgl_masuk) >=', $tgl_awal)->where('DATE(tgl_masuk) <=', $tgl_akhr)->get('tbl_trans_jual')->result();
                }else{
                    $sql_penj    = $this->db->select('id, DAY(tgl_masuk) as d, MONTH(tgl_masuk) as m, tgl_masuk as tgl_simpan, TIME(tgl_simpan) as wkt_simpan, HOUR(tgl_simpan) as h, MINUTE(tgl_simpan) as i, no_nota, kode_nota_dpn, kode_nota_blk, jml_gtotal, jml_bayar, jml_kembali, id_user, id_sales, metode_bayar')->where('id_user', $id)->where('DATE(tgl_masuk) >=', $tgl_awal)->where('DATE(tgl_masuk) <=', $tgl_akhr)->get('tbl_trans_jual')->result();
                }
            }

            $printer->setJustification(Escpos::JUSTIFY_CENTER);
            $printer->text(strtoupper($pengaturan->judul."\n"));
            $printer->text(strtoupper($pengaturan->kota)."\n");
            $printer->text("REKAP PENJUALAN\n");
            $printer->setJustification(Escpos::JUSTIFY_LEFT);
            $printer->text($this->ion_auth->user($id)->row()->first_name."\n");
            $printer->text($this->tanggalan->tgl_indo2(date('Y-m-d'))." ".date('H:i')."\n");
            $printer->text("========================================\n");
            $printer->text("\n");

            $jml_gtotal = 0;
            foreach ($sql_penj as $nota_det) {
                $platform   = $this->db->where('id', $nota_det->metode_bayar)->get('tbl_m_platform')->row();
                $d          = sprintf('%02s', $nota_det->d);
                $m          = sprintf('%02s', $nota_det->m);
                $h          = sprintf('%02s', $nota_det->h);
                $i          = sprintf('%02s', $nota_det->i);
                $str        = $nota_det->jml_gtotal;
                $str2       = $d."/".$m." ".$h.":".$i." ".$nota_det->no_nota.(!empty($nota_det->kode_nota_blk) ? '/'.$nota_det->kode_nota_blk : '').($nota_det->metode_bayar > 1 ? '/NT' : '/T ')." ".general::format_angka($nota_det->jml_gtotal);
                $jml_gtotal = $jml_gtotal + $nota_det->jml_gtotal;
                
                $printer->setJustification(Escpos::JUSTIFY_LEFT);
                $printer->text($str2."\n");
            }
            
            $printer->setJustification(Escpos::JUSTIFY_LEFT);
            $printer->text("\n*NT = Non Tunai, T = Tunai\n");
            $printer->text("----------------------------------------\n");
            $printer->setJustification(Escpos::JUSTIFY_LEFT);
            $printer->text("TOTAL    : ".general::format_angka($jml_gtotal)."\n");
            $printer->text("========================================\n");
            $printer->cut(Escpos::CUT_FULL, 15);
            $printer->close();
            
            redirect(base_url(!empty($rute) ? $rute.'.php?tgl_awal='.$tgl_awal.'&tgl_akhir='.$tgl_akhr : 'laporan/data_penjualan_kasir_pos.php'));
    }
}