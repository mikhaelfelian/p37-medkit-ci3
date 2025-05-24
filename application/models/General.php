<?php
/**
 * Description of jabatan
 *
 * @author Mike
 */
class general extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('encrypt');
    }

    public static function status_penerimaan($status)
    {
        switch ($status) {
            case '0':
                $status = '<label class="badge badge-warning">Menunggu</label>';
                break;

            case '1':
                $status = '<label class="badge badge-primary">Menunggu</label>';
                break;

            case '2':
                $status = '<label class="badge badge-warning">Proses</label>';
                break;

            case '3':
                $status = '<label class="badge badge-success">Selesai</label>';
                break;

            case '4':
                $status = '<label class="badge badge-info">Siap di ambil</label>';
                break;

            case '5':
                $status = '<label class="badge badge-default">Sudah diambil</label>';
                break;
        }
        return $status;
    }

    public static function status_nota($status)
    {
        switch ($status) {
            case '0':
                $status = '<label class="badge badge-warning">Menunggu</label>';
                break;

            case '1':
                $status = '<label class="badge badge-primary">Menunggu</label>';
                break;

            case '2':
                $status = '<label class="badge badge-warning">Proses</label>';
                break;

            case '3':
                $status = '<label class="badge badge-primary">Posted</label>';
                break;

            case '4':
                $status = '<label class="badge badge-success">Selesai</label>';
                break;

            case '5':
                $status = '<label class="badge badge-default">[DRAFT]</label>';
                break;
        }
        return $status;
    }

    public static function status_nota_brc($status)
    {
        switch ($status) {
            case '0':
                $status = '<label class="badge badge-warning">Menunggu</label>';
                break;

            case '1':
                $status = '<label class="badge badge-primary">Menunggu</label>';
                break;

            case '2':
                $status = '<label class="badge badge-warning">Proses</label>';
                break;

            case '3':
                $status = '<label class="badge badge-success">Selesai</label>';
                break;

            case '4':
                $status = '<label class="badge badge-info">[DRAFT]</label>';
                break;

            case '5':
                $status = '<label class="badge badge-default">Sudah diambil</label>';
                break;
        }
        return $status;
    }

    public static function status_nota_po($status)
    {
        switch ($status) {
            case '0':
                $status = '<label class="badge badge-warning">Menunggu</label>';
                break;

            case '1':
                $status = '<label class="badge badge-primary">Menunggu</label>';
                break;

            case '2':
                $status = '<label class="badge badge-warning">Proses</label>';
                break;

            case '3':
                $status = '<label class="badge badge-success">Selesai</label>';
                break;

            case '4':
                $status = '<label class="badge badge-info">Siap di ambil</label>';
                break;

            case '5':
                $status = '<label class="badge badge-default">Sudah diambil</label>';
                break;
        }
        return $status;
    }

    public static function status_nota2($status)
    {
        switch ($status) {
            case '0':
                $status = '1';
                break;

            case '1':
                $status = '2';
                break;

            case '2':
                $status = '3';
                break;

            case '3':
                $status = '4';
                break;

            case '4':
                $status = '5';
                break;
        }
        return $status;
    }

    public static function status_nota3($status)
    {
        switch ($status) {
            case '0':
                $status = '[Layout]';
                break;

            case '1':
                $status = '[Proses]';
                break;

            case '2':
                $status = '[Selesai]';
                break;

            case '3':
                $status = '[Siap Ambil]';
                break;

            case '4':
                $status = '[Sudah Ambil]';
                break;

            case '5':
                $status = '[Sudah Ambil]';
                break;
        }
        return $status;
    }

    public static function status_bayar($status)
    {
        switch ($status) {
            case '0':
                $status = '<label class="badge badge-warning">Belum Bayar</label>';
                break;

            case '1':
                $status = '<label class="badge badge-success">Lunas</label>';
                break;

            case '2':
                $status = '<label class="badge badge-info">Kurang</label>';
                break;
        }
        return $status;
    }

    public static function status_stok($status)
    {
        switch ($status) {
            case '1':
                $status = '<label class="badge badge-success">Stok Masuk</label>';
                break;

            case '2':
                $status = '<label class="badge badge-success">Stok Masuk</label>';
                break;

            case '3':
                $status = '<label class="badge badge-info">Retur Jual</label>';
                break;

            case '4':
                $status = '<label class="badge badge-info">Stok Keluar</label>';
                break;

            case '5':
                $status = '<label class="badge badge-info">Retur Beli</label>';
                break;

            case '6':
                $status = '<label class="badge badge-warning">Stok Opname</label>';
                break;

            case '7':
                $status = '<label class="badge badge-info">Stok Keluar</label>';
                break;

            case '8':
                $status = '<label class="badge badge-warning">Mutasi</label>';
                break;

            case '9':
                $status = '<label class="badge badge-info">Adjustment</label>';
                break;
        }
        return $status;
    } 

    public static function status_gd($status)
    {
        switch ($status) {
            case '0':
                $status = '';
                break;

            case '1':
                $status = '<label class="badge badge-success">Utama</label>';
                break;

            default:
                $status = '';
                break;
        }
        return $status;
    }

    public static function status_tp($status)
    {
        switch ($status) {
            case '1':
                $status = '<label class="badge badge-warning">POS</label>';
                break;

            case '2':
                $status = '<label class="badge badge-success">Rawat Jalan</label>';
                break;

            case '3':
                $status = '<label class="badge badge-danger">Rawat Inap</label>';
                break;

            default:
                $status = '';
                break;
        }
        return $status;
    }

    public static function status_nikah($status)
    {
        switch ($status) {
            case '1':
                $status = 'Belum';
                break;

            case '2':
                $status = 'Sudah';
                break;

            case '3':
                $status = 'Cerai';
                break;

            default:
                $status = '-';
                break;
        }
        return $status;
    }

    public static function status_rawat($status)
    {
        switch ($status) {
            case '2':
                $status = '<label class="badge badge-success">Rawat Jalan</label>';
                break;

            case '3':
                $status = '<label class="badge badge-danger">Rawat Inap</label>';
                break;

            default:
                $status = '';
                break;
        }
        return $status;
    }

    public static function status_rawat2($status)
    {
        switch ($status) {
            case '1':
                $status = 'Laborat';
                break;

            case '2':
                $status = 'Rawat Jalan';
                break;

            case '3':
                $status = 'Rawat Inap';
                break;

            case '4':
                $status = 'Radiologi';
                break;

            case '5':
                $status = 'MCU';
                break;

            case '6':
                $status = 'Farmasi';
                break;

            default:
                $status = '';
                break;
        }
        return $status;
    }


    public static function status_resep($status)
    {
        switch ($status) {
            case '0':
                $status = '<label class="badge badge-warning"><i class="far fa-solid fa-clock-rotate-left"></i> Pending</label>';
                break;

            case '1':
                $status = '<label class="badge badge-info"><i class="far fa-light fa-paper-plane"></i> Terkirim</label>';
                break;

            case '2':
                $status = '<label class="badge badge-primary"><i class="far fa-solid fa-clock-rotate-left"></i> Proses</label>';
                break;

            case '3':
                $status = '<label class="badge badge-danger">Tolak</label>';
                break;

            case '4':
                $status = '<label class="badge badge-success"><i class="far fa-check-circle"></i> Selesai</label>';
                break;

            default:
                $status = '';
                break;
        }
        return $status;
    }

    public static function status_periksa($status)
    {
        switch ($status) {
            case '0':
                $status = '<label class="badge badge-warning"><i class="far fa-solid fa-clock-rotate-left"></i> Belum Periksa</label>';
                break;

            case '1':
                $status = '<label class="badge badge-info"><i class="far fa-check-circle"></i> Sudah Periksa</label>';
                break;

            case '2':
                $status = '<label class="badge badge-primary"><i class="far fa-solid fa-clock-rotate-left"></i> Proses</label>';
                break;

            case '3':
                $status = '<label class="badge badge-danger">Tolak</label>';
                break;

            case '4':
                $status = '<label class="badge badge-success"><i class="far fa-check-circle"></i> Selesai</label>';
                break;

            default:
                $status = '';
                break;
        }
        return $status;
    }

    public static function status_rad($status)
    {
        switch ($status) {
            case '0':
                $status = '<label class="badge badge-warning"><i class="far fa-solid fa-clock-rotate-left"></i> Baru</label>';
                break;

            case '1':
                $status = '<label class="badge badge-info"><i class="far fa-check-circle"></i> Proses</label>';
                break;

            case '2':
                $status = '<label class="badge badge-primary"><i class="far fa-solid fa-clock-rotate-left"></i> Proses</label>';
                break;

            case '3':
                $status = '<label class="badge badge-danger">Tolak</label>';
                break;

            case '4':
                $status = '<label class="badge badge-success"><i class="far fa-check-circle"></i> Selesai</label>';
                break;

            default:
                $status = '';
                break;
        }
        return $status;
    }

    public static function status_farmasi($status)
    {
        switch ($status) {
            case '0':
                $status = '<label class="badge badge-warning">Pending</label>';
                break;

            case '1':
                $status = '<label class="badge badge-info">Diterima</label>';
                break;

            case '2':
                $status = '<label class="badge badge-primary">Diganti</label>';
                break;

            case '3':
                $status = '<label class="badge badge-success">Habis</label>';
                break;

            case '4':
                $status = '<label class="badge badge-danger">Tolak</label>';
                break;

            default:
                $status = '';
                break;
        }
        return $status;
    }

    public static function status_mutasi($status)
    {
        switch ($status) {
            case '0':
                $status = '<label class="badge badge-warning">Pending</label>';
                break;

            case '1':
                $status = '<label class="badge badge-info">Diterima</label>';
                break;

            case '2':
                $status = '<label class="badge badge-danger">Tolak</label>';
                break;

            default:
                $status = '';
                break;
        }
        return $status;
    }

    /**
     * Get stock status badge
     * 
     * Returns HTML badge for stock status based on quantity
     * 
     * @param int $quantity Current stock quantity
     * @return string HTML badge with appropriate color
     */
    public static function status_stok_badge($quantity)
    {
        if ($quantity <= 0) {
            return '<span class="badge badge-danger">Habis</span>';
        } else if ($quantity <= 5) {
            return '<span class="badge badge-danger">Kritis</span>';
        } else if ($quantity <= 10) {
            return '<span class="badge badge-warning">Rendah</span>';
        } else {
            return '<span class="badge badge-success">Normal</span>';
        }
    }

    public static function tipe_bayar($status)
    {
        switch ($status) {
            case '1':
                $status = 'UMUM';
                break;

            case '2':
                $status = 'ASURANSI';
                break;

            case '3':
                $status = 'BPJS';
                break;

            default:
                $status = 'Tidak Ada';
                break;
        }
        return $status;
    }

    public static function tipe_gd($status)
    {
        switch ($status) {
            case '1':
                $status = '<label class="badge badge-warning">Pindah</label>';
                break;

            case '2':
                $status = '<label class="badge badge-success">Stok Masuk</label>';
                break;

            case '3':
                $status = '<label class="badge badge-danger">Stok Keluar</label>';
                break;

            default:
                $status = '';
                break;
        }
        return $status;
    }

    public static function tipe_surat($status)
    {
        switch ($status) {
            default;
                $str_tipe = '';
                break;

            case '1';
                $str_tipe = 'Sehat';
                break;

            case '2';
                $str_tipe = 'Sakit';
                break;

            case '3';
                $str_tipe = 'Rawat Inap';
                break;

            case '4';
                $str_tipe = 'Kontrol';
                break;

            case '5';
                $str_tipe = 'Kelahiran';
                break;

            case '6';
                $str_tipe = 'Kematian';
                break;

            case '7';
                $str_tipe = 'Covid';
                break;

            case '8';
                $str_tipe = 'Rujukan';
                break;

            case '9';
                $str_tipe = 'Ket. Vaksin';
                break;

            case '10';
                $str_tipe = 'Ket. Kehamilan';
                break;

            case '13';
                $str_tipe = 'Keterangan Bebas Narkoba';
                break;

            case '14';
                $str_tipe = 'Layak Terbang';
                break;

            case '15';
                $str_tipe = 'Ket. THT';
                break;
        }
        return $str_tipe;
    }

    public static function tipe_surat_inf($status)
    {
        switch ($status) {
            case '1';
                $str_tipe = 'Pernyataan Rawat Inap';
                break;

            case '2';
                $str_tipe = 'Persetujuan Medis';
                break;
        }
        return $str_tipe;
    }

    public static function tipe_surat_inf_stj($status)
    {
        switch ($status) {
            case '1';
                $str_tipe = 'PERSETUJUAN';
                break;

            case '2';
                $str_tipe = 'PENOLAKAN';
                break;
        }
        return $str_tipe;
    }

    public static function tipe_hubungan($status)
    {
        switch ($status) {
            case '1';
                $str_tipe = 'Suami';
                break;

            case '2';
                $str_tipe = 'Istri';
                break;

            case '3';
                $str_tipe = 'Orangtua';
                break;

            case '4';
                $str_tipe = 'Anak';
                break;

            case '5';
                $str_tipe = 'Keluarga';
                break;

            case '6';
                $str_tipe = 'Kerabat';
                break;

            case '7';
                $str_tipe = 'Diri Sendiri';
                break;
        }
        return $str_tipe;
    }

    public static function tipe_sehat($status)
    {
        switch ($status) {
            case '1';
                $str_tipe = 'sehat';
                break;

            case '0';
                $str_tipe = 'tidak sehat';
                break;
        }
        return $str_tipe;
    }

    public static function tipe_obat_pakai($status)
    {
        switch ($status) {
            case '1';
                $str_tipe = 'Menit';
                break;

            case '2';
                $str_tipe = 'Jam';
                break;

            case '3';
                $str_tipe = 'Hari';
                break;

            case '4';
                $str_tipe = 'Minggu';
                break;

            case '5';
                $str_tipe = 'Bulan';
                break;
        }
        return $str_tipe;
    }

    public static function tipe_obat_makan($status)
    {
        switch ($status) {
            case '1';
                $str_tipe = 'Sebelum Makan';
                break;

            case '2';
                $str_tipe = 'Saat Makan';
                break;

            case '3';
                $str_tipe = 'Sesudah Makan';
                break;

            case '4';
                $str_tipe = 'Lain-lain';
                break;

            default;
                $str_tipe = '';
                break;
        }
        return $str_tipe;
    }

    public static function tipe_obat_etiket($status)
    {
        switch ($status) {
            case '1';
                $str_tipe = '';
                break;

            case '2';
                $str_tipe = 'Obat Luar';
                break;

            default;
                $str_tipe = '';
                break;
        }
        return $str_tipe;
    }

    public static function tipe_remun($status)
    {
        switch ($status) {
            case '1';
                $str_tipe = 'Persen';
                break;

            case '2';
                $str_tipe = 'Nominal';
                break;
        }
        return $str_tipe;
    }

    public static function tipe_mutasi($status)
    {
        switch ($status) {
            case '1':
                $status = '<label class="badge badge-success">Pindah</label>';
                break;

            case '2':
                $status = '<label class="badge badge-danger"></label>';
                break;
        }
        return $status;
    }

    public static function tipe_item($status)
    {
        switch ($status) {
            case '2':
                $status = 'Tindakan';
                break;
            case '3':
                $status = 'Laborat';
                break;
            case '4':
                $status = 'Obat';
                break;
            case '5':
                $status = 'Radiologi';
                break;
            case '6':
                $status = 'Bahan Habis Pakai';
                break;
        }
        return $status;
    }

    public static function status_retur($status)
    {
        switch ($status) {
            case '1':
                $status = '<label class="badge badge-success">Potong Nota</label>';
                break;

            case '2':
                $status = '<label class="badge badge-danger">Lama</label>';
                break;

            case '3':
                $status = '<label class="badge badge-info">Baru</label>';
                break;
        }
        return $status;
    }

    public static function status_retur_cetak($status)
    {
        switch ($status) {
            case '1':
                $status = 'Potong Nota';
                break;

            case '2':
                $status = 'Lama';
                break;

            case '3':
                $status = 'Baru';
                break;
        }
        return $status;
    }

    public static function status_promo($status)
    {
        switch ($status) {
            case '1':
                $status = '<label class="badge badge-success">Potong Nota</label>';
                break;

            case '2':
                $status = '<label class="badge badge-info">Ganti Barang</label>';
                break;
        }
        return $status;
    }

    public static function status_aktif($status)
    {
        switch ($status) {
            case '0':
                $status = '<label class="badge badge-warning">Non-Aktif</label>';
                break;

            case '1':
                $status = '<label class="badge badge-success">Aktif</label>';
                break;
        }
        return $status;
    }

    public static function status_grosir($status)
    {
        switch ($status) {
            case '0':
                $status = '<label class="badge badge-success">Umum</label>';
                break;

            case '1':
                $status = '<label class="badge badge-info">Grosir</label>';
                break;
        }
        return $status;
    }

    public static function status_ppn($status)
    {
        switch ($status) {
            case '0':
                $status = 'Non PPN';
                break;

            case '1':
                $status = 'Tambah PPN';
                break;

            case '2':
                $status = 'Include PPN';
                break;
        }
        return $status;
    }

    public static function status_dft($status)
    {
        switch ($status) {
            case '0':
                $status = 'None';
                break;

            case '1':
                $status = 'Offline';
                break;

            case '2':
                $status = 'Online';
                break;
        }
        return $status;
    }

    public static function status_rokok($status)
    {
        switch ($status) {
            case '0':
                $status = '';
                break;

            case '1':
                $status = 'Ya';
                break;

            case '2':
                $status = 'Tidak';
                break;
        }
        return $status;
    }

    public static function status_icd($status)
    {
        switch ($status) {
            case '1':
                $status = '<label class="badge badge-warning"><small>INA-CBG</small></label>';
                break;

            case '2':
                $status = '<label class="badge badge-success"><small>ICD 10</small></label>';
                break;

            default:
                $status = '';
                break;
        }
        return $status;
    }

    public static function status_cuti($status)
    {
        switch ($status) {
            case '0':
                $status = '<label class="badge badge-warning"><small>Menunggu</small></label>';
                break;

            case '1':
                $status = '<label class="badge badge-success"><small>Disetujui</small></label>';
                break;

            case '2':
                $status = '<label class="badge badge-danger"><small>Ditolak</small></label>';
                break;

            default:
                $status = '';
                break;
        }
        return $status;
    }


    public static function tipe_rak($status)
    {
        switch ($status) {
            case '1':
                $status = 'RAK';
                break;

            case '2':
                $status = 'GANTUNGAN';
                break;
        }
        return $status;
    }

    public static function metode_bayar($status)
    {
        switch ($status) {
            case '1':
                $status = 'Tunai';
                break;

            case '2':
                $status = 'Deposit';
                break;
        }
        return $status;
    }

    public static function tipe_pengeluaran($status)
    {
        switch ($status) {
            case '0':
                $status = 'Kas';
                break;

            case '1':
                $status = 'Kasbon';
                break;

            case '2':
                $status = 'Transfer';
                break;

            case '3':
                $status = 'Operasional';
                break;
        }
        return $status;
    }

    public static function status_byr_met($status)
    {
        switch ($status) {
            case 'cash':
                $status = 'Kas';
                break;

            case 'credit':
                $status = 'Kartu Kredit';
                break;

            case 'debet':
                $status = 'Kartu Debet';
                break;

            case 'lain':
                $status = 'Lainnya';
                break;
        }
        return $status;
    }

    public static function no_nota($string, $tabel_nama, $tabel_kolom, $where, $sep)
    {
        $CI =& get_instance();
        $pengaturan = $CI->db->query("SELECT * FROM tbl_pengaturan")->row();
        $kode = $CI->db->query("SELECT " . $tabel_kolom . " as no_nota FROM " . $tabel_nama . " " . (!empty($where) ? $where : ''))->num_rows();
        $char = $string; // Total String Nota
        $pjg_char = strlen($char); // Itung panjang Notanya
        $noUrut = $kode; // Incriment Numbering nota
        $noUrut++;

        $IDbaru = (!empty($string) ? $string : '') . (!empty($sep) ? $sep : '') . sprintf("%05s", $noUrut);
        return $IDbaru;
    }

    public static function kode_kas($string, $tabel_nama, $tabel_kolom, $where, $where2)
    {
        $CI =& get_instance();
        $pengaturan = $CI->db->query("SELECT * FROM tbl_pengaturan")->row();
        $kode = $CI->db->query("SELECT MAX(" . $tabel_kolom . ") as no_nota FROM " . $tabel_nama . (isset($where) ? " WHERE " . $where . "='" . $where2 . "'" : ''))->row();
        $char = $string; // Total String Nota
        $pjg_char = strlen($char); // Itung panjang Notanya
        $noUrut = (int) substr($kode->no_nota, $pjg_char, 5); // Incriment Numbering nota
        $noUrut++;

        $IDbaru = sprintf("%05s", $noUrut);
        return $IDbaru;
    }

    public static function random_kode($string, $tabel_nama, $tabel_kolom)
    {
        $CI =& get_instance();
        $kode = $CI->db->query("SELECT MAX(" . $tabel_kolom . ") as no_nota FROM " . $tabel_nama)->row();
        $char = $string . "."; // Total String Nota
        $pjg_char = strlen($char); // Itung panjang Notanya
        $noUrut = (int) substr($kode->no_nota, $pjg_char, 5); // Incriment Numbering nota
        $noUrut++;

        $IDbaru = $char . sprintf("%05s", $noUrut);
        return $IDbaru;
    }

    public static function jns_klm($jenis)
    {
        $CI =& get_instance();
        switch ($jenis) {
            case 'L':
                $jns_klm = 'Laki-laki';
                break;
            case 'P':
                $jns_klm = 'Perempuan';
                break;
            case 'O':
                $jns_klm = 'Lainnya';
                break;
        }
        return $jns_klm;
    }

    public static function enkrip($string)
    {
        $CI =& get_instance();
        $CI->load->library('encrypt');
        return $CI->encrypt->encode_url($string);
    }

    public static function dekrip($string)
    {
        $CI =& get_instance();
        $CI->load->library('encrypt');
        return $CI->encrypt->decode_url($string);
    }

    public static function waktu_post($data)
    {
        $CI =& get_instance();
        $CI->load->library('tanggalan');

        $original = strtotime($data);
        $chunks = array(
            array(60 * 60 * 24 * 365, 'tahun'),
            array(60 * 60 * 24 * 30, 'bulan'),
            array(60 * 60 * 24 * 7, 'minggu'),
            array(60 * 60 * 24, 'hari'),
            array(60 * 60, 'jam'),
            array(60, 'menit'),
        );

        $today = time();
        $since = $today - $original;

        if ($since > 604800) {
            $print = $CI->tanggalan->tgl_indo(date('Y-m-d', $original));

            if ($since > 31536000) {
                $print .= ", " . date("Y", $original);
            }
            return $print;
        }

        for ($i = 0, $j = count($chunks); $i < $j; $i++) {
            $seconds = $chunks[$i][0];
            $name = $chunks[$i][1];

            if (($count = floor($since / $seconds)) != 0)
                break;
        }

        $print = ($count == 1) ? '1 ' . $name : "$count {$name}";
        return $print . ' yang lalu';
    }

    public static function format_angka($str, $dec = null)
    {
        $string = number_format($str, $dec, ',', '.');
        return $string;
    }

    public static function format_angka2($str, $dec)
    {
        $string = number_format($str, $dec, '.', '');
        $var = explode('.', $string);
        $hasil = ($var[1] == '00' ? $var[0] : $string);
        return $hasil;
    }

    public static function format_angka_str($str)
    {
        $CI =& get_instance();
        $CI->load->model('general');

        $angka = abs($str);
        $terbilang = array(
            '',
            'satu',
            'dua',
            'tiga',
            'empat',
            'lima',
            'enam',
            'tujuh',
            'delapan',
            'sembilan',
            'sepuluh',
            'sebelas'
        );

        $hasil = '';

        if ($angka < 12) {
            $hasil = ' ' . $terbilang[$angka];
        } elseif ($angka < 20) {
            $hasil = $CI->general->format_angka_str($angka - 10) . ' belas';
        } elseif ($angka < 100) {
            $hasil = $CI->general->format_angka_str($angka / 10) . ' puluh' . $CI->general->format_angka_str($angka % 10);
        } elseif ($angka < 200) {
            $hasil = ' seratus' . $CI->general->format_angka_str($angka - 100);
        } elseif ($angka < 1000) {
            $hasil = $CI->general->format_angka_str($angka / 100) . ' ratus' . $CI->general->format_angka_str($angka % 100);
        } elseif ($angka < 2000) {
            $hasil = ' seribu' . $CI->general->format_angka_str($angka - 1000);
        } elseif ($angka < 1000000) {
            $hasil = $CI->general->format_angka_str($angka / 1000) . ' ribu' . $CI->general->format_angka_str($angka % 1000);
        } elseif ($angka < 1000000000) {
            $hasil = $CI->general->format_angka_str($angka / 1000000) . ' juta' . $CI->general->format_angka_str($angka % 1000000);
        } elseif ($angka < 1000000000000) {
            $hasil = $CI->general->format_angka_str($angka / 1000000000) . ' miliar' . $CI->general->format_angka_str(fmod($angka, 1000000000));
        } elseif ($angka < 1000000000000000) {
            $hasil = $CI->general->format_angka_str($angka / 1000000000000) . ' triliun' . $CI->general->format_angka_str(fmod($angka, 1000000000000));
        }

        return $hasil;
    }

    public static function format_angka_db($str)
    {
        $angka = (float) $str;
        $string = str_replace(',', '.', str_replace('.', '', $str));
        return $string;
    }

    public static function format_numerik($str, $des)
    {
        $string = number_format($str, 0, ',', '.');
        return $string;
    }

    public static function format_numerik2($str)
    {
        $string = str_replace(',', '.', str_replace('.', '', $str));
        return $string;
    }

    public static function format_romawi($integer)
    {
        // Convert the integer into an integer (just to make sure)
        $integer = intval($integer);
        $result = '';

        // Create a lookup array that contains all of the Roman numerals.
        $lookup = array(
            'M' => 1000,
            'CM' => 900,
            'D' => 500,
            'CD' => 400,
            'C' => 100,
            'XC' => 90,
            'L' => 50,
            'XL' => 40,
            'X' => 10,
            'IX' => 9,
            'V' => 5,
            'IV' => 4,
            'I' => 1
        );

        foreach ($lookup as $roman => $value) {
            // Determine the number of matches
            $matches = intval($integer / $value);

            // Add the same number of characters to the string
            $result .= str_repeat($roman, $matches);

            // Set the integer to be the remainder of the integer and the value
            $integer = $integer % $value;
        }

        // The Roman numeral should be built, return it
        return $result;
    }

    public static function generateEAN($number)
    {
        //        $code       = '899' . str_pad($number, 9, '0');
        $code = '899' . $number;
        $weightflag = true;
        $sum = 0;
        // Weight for a digit in the checksum is 3, 1, 3.. starting from the last digit.
        // loop backwards to make the loop length-agnostic. The same basic functionality
        // will work for codes of different lengths.
        for ($i = strlen($code) - 1; $i >= 0; $i--) {
            $sum += (int) $code[$i] * ($weightflag ? 3 : 1);
            $weightflag = !$weightflag;
        }
        $code .= (10 - ($sum % 10)) % 10;
        return $code;
    }

    public static function get_all_get()
    {
        $output = "?";
        $firstRun = true;

        foreach ($_GET as $key => $val) {
            if (!$firstRun) {
                $output .= "&";
            } else {
                $firstRun = false;
            }

            if ($key != 'halaman') {
                $output .= $key . "=" . $val;
            }
        }

        $str = substr($output, -1);
        return ($str == '&' ? substr($output, 0, -1) : $output);
    }

    public static function usia($tanggal_lahir)
    {
        $birthDate = new DateTime($tanggal_lahir);
        $today = new DateTime("today");
        if ($birthDate > $today) {
            exit("0 tahun 0 bulan 0 hari");
        }
        $y = $today->diff($birthDate)->y;
        $m = $today->diff($birthDate)->m;
        $d = $today->diff($birthDate)->d;
        return $y . " tahun " . $m . " bulan " . $d . " hari";
    }

    public static function regex_lab($des)
    {
        // Strip HTML Tags
        $clear = strip_tags($des);
        // Clean up things like &amp;
        $clear = html_entity_decode($clear);
        // Strip out any url-encoded stuff
        $clear = urldecode($clear);
        // Replace non-AlNum characters with space
        $clear = preg_replace('/[^A-Za-z0-9,-.]/', ' ', $clear);
        // Replace Multiple spaces with single space
        $clear = preg_replace('/ +/', ' ', $clear);
        // Trim the string of leading/trailing space
        $clear = trim($clear);

        return $clear;
    }

    public static function encode($str)
    {
        $str = mb_convert_encoding($str, 'UTF-32', 'UTF-8'); //big endian
        $split = str_split($str, 4);

        $res = "";
        foreach ($split as $c) {
            $cur = 0;
            for ($i = 0; $i < 4; $i++) {
                $cur |= ord($c[$i]) << (8 * (3 - $i));
            }
            $res .= "&#" . $cur . ";";
        }
        return $res;
    }

    public static function encode2($str)
    {
        $str = mb_convert_encoding($str, 'UTF-32', 'UTF-8');
        $t = unpack("N*", $str);
        $t = array_map(function ($n) {
            return "&#$n;";
        }, $t);
        return implode("", $t);
    }

    public static function base64_to_jpeg($base64_string, $output_file)
    {
        // open the output file for writing
        $ifp = fopen($output_file, 'wb');

        // split the string on commas
//         $data[ 0 ] == "data:image/png;base64";
        // $data[ 1 ] == <actual base64 string>
        $data = explode(',', $base64_string);

        // we could add validation here with ensuring count( $data ) > 1
        fwrite($ifp, base64_decode($data[1]));

        // clean up the file resource
        fclose($ifp);

        return $output_file;
    }

    public static function pre($str)
    {
        $print = print_r('<pre>');
        $print .= print_r($str);
        $print = print_r('</pre>');
        return $print;
    }

    public static function bersih($str)
    {
        $teks = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $str);
        return $teks;
    }


    public static function rotateImage($filePath)
    {

        // the file must exist
        if (!file_exists($filePath)) {
            die('image not found');
        }

        // if it was already processed return the already processed path
        if (file_exists($filePath)) {
            return $filePath;
        }

        // it must be a jpeg
        if (exif_imagetype($filePath) == IMAGETYPE_JPEG) {
            $exif = exif_read_data($filePath);
            $degrees = 0;
            if (isset($exif['Orientation'])) {
                switch ($exif['Orientation']) {
                    case 3: // Need to rotate 180 deg
                        $degrees = 180;
                        break;
                    case 6: // Need to rotate 90 deg clockwise
                        $degrees = 270;
                        break;
                    case 8: // Need to rotate 90 deg counter clockwise
                        $degrees = 90;
                        break;
                }
            }

            // rotate the image
            $image = imagecreatefromjpg($filePath);
            if ($degrees != 0) {
                $image = imagerotate($image, $degrees, 3);
            }

            // store the image
            imagejpeg($image, $filePath);
            imagedestroy($image);
            return $filePath;
        } else {

            // if it is not a jpeg just return the path
            return $filePath;
        }
    }

}