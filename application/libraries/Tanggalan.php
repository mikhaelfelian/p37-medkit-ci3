<?php

/**
 * Description of Tanggalan controller
 *
 * @author Mikhael Felian Waskito - mikhaelfelian@gmail.com
 * @created by Mikhael Felian Waskito - mikhaelfelian@gmail.com
 * @date 2025-03-14
 */

/**
 * Class for handling date formatting and calculations
 * Used for converting dates between formats, calculating ages and time differences
 */
class tanggalan {

    // Add CI instance
    protected $CI;

    public function __construct() {
        $this->CI =& get_instance();
    }

    /**
     * Format date to Indonesian format (dd-mm-yyyy)
     */
    public static function tgl_indo($tglan) {
        $str_tgl = $tglan;
        $dta_tgl = ($str_tgl != '0000-00-00' ? $str_tgl : '');
        $tgln = (!empty($dta_tgl) ? date('d-m-Y', strtotime($dta_tgl)) : '');
        $tgle = $tgln;
        return $tgle;
    }

    /**
     * Alternative format for Indonesian date (dd-mm-yyyy)
     */
    public static function tgl_indo2($tglan) {
        $str_tgl = $tglan;
        $dta_tgl = ($str_tgl != '0000-00-00' ? $str_tgl : '');
        $tgln = (!empty($dta_tgl) ? date('d-m-Y', strtotime($dta_tgl)) : '');
        $tgle = $tgln;
        return $tgle;
    }

    /**
     * Format date to Indonesian format with month name (dd Month yyyy)
     */
    public static function tgl_indo3($tgl) {
        $tanggal = substr($tgl, 8, 2);
        $bulan = self::getBulan(substr($tgl, 5, 2));
        $tahun = substr($tgl, 0, 4);
        return $tanggal . ' ' . $bulan . ' ' . $tahun;
    }

    /**
     * Format date to Indonesian format (dd/Month)
     */
    public static function tgl_indo4($tglan) {
        $str_tgl = $tglan;
        $dta_tgl = ($str_tgl != '0000-00-00' ? $str_tgl : '');
        $tgln = (!empty($dta_tgl) ? date('Y-m-d', strtotime($dta_tgl)) : '');

        $tgl = explode('-', $tgln);
        $tanggal = $tgl[2];
        $bulan = self::bulan_ke($tgl[1]);
        $tahun = $tgl[0];
        $tgle = (!empty($tglan) ? $tanggal . '/' . $bulan : '');
        return $tgle;
    }

    /**
     * Format date and time to Indonesian format (dd-mm-yyyy HH:ii)
     */
    public static function tgl_indo5($tglan) {
        $str_tgl = $tglan;
        $dta_tgl = ($str_tgl != '0000-00-00 00:00:00' ? $str_tgl : '');
        $tgln = (!empty($dta_tgl) ? date('d-m-Y', strtotime($dta_tgl)) : '');
        $wktu = (!empty($dta_tgl) ? date('H:i', strtotime($dta_tgl)) : '');
        $tgle = $tgln . ' ' . $wktu;
        return $tgle;
    }

    /**
     * Format date to Indonesian format with day name (Day, dd/mm/yyyy)
     */
    public static function tgl_indo6($tglan) {
        $str_tgl = $tglan;
        $dta_tgl = ($str_tgl != '0000-00-00' ? $str_tgl : '');
        $tgln = (!empty($dta_tgl) ? date('d/m/Y', strtotime($dta_tgl)) : '');
        $tgle = self::hari_ke($tglan) . ', ' . $tgln;
        return $tgle;
    }

    /**
     * Format date to mm/dd/yyyy
     */
    public static function tgl_indo7($tglan) {
        $str_tgl = $tglan;
        $dta_tgl = ($str_tgl != '0000-00-00' ? $str_tgl : '');
        $tgln = (!empty($dta_tgl) ? date('m/d/Y', strtotime($dta_tgl)) : '');
        $tgle = $tgln;
        return $tgle;
    }

    /**
     * Format date to dd-mm-yyyy
     */
    public static function tgl_indo8($tglan) {
        $str_tgl = $tglan;
        $dta_tgl = ($str_tgl != '0000-00-00' ? $str_tgl : '');
        $tgln = (!empty($dta_tgl) ? date('d-m-Y', strtotime($dta_tgl)) : '');
        $tgle = $tgln;
        return $tgle;
    }

    /**
     * Format date to Indonesian format with abbreviated month name (dd MMM yyyy HH:mm:ss)
     * Example: 10 Apr 2025 15:45:08
     */
    public static function tgl_indo9($tglan) {
        $str_tgl = $tglan;
        $dta_tgl = ($str_tgl != '0000-00-00 00:00:00' ? $str_tgl : '');
        
        if (empty($dta_tgl)) {
            return '';
        }
        
        $timestamp = strtotime($dta_tgl);
        $day = date('d', $timestamp);
        $month = date('M', $timestamp); // Abbreviated month name
        $year = date('Y', $timestamp);
        $time = date('H:i:s', $timestamp);
        
        // Get day name using hari_ke method
        $day_name = self::hari_ke($dta_tgl);
        
        // Format: Selasa, 09 Apr 2025 12:23:55
        return $day_name . ', ' . $day . ' ' . $month . ' ' . $year . ' ' . $time;
    }

    /**
     * Get month number (mm)
     */
    public static function bln_indo($tglan) {
        $str_tgl = $tglan;
        $dta_tgl = ($str_tgl != '0000-00-00' ? $str_tgl : '');
        $tgln = (!empty($dta_tgl) ? date('m', strtotime($dta_tgl)) : '');
        $tgle = $tgln;
        return $tgle;
    }

    /**
     * Format date to system format (yyyy-mm-dd)
     */
    public static function tgl_indo_sys($tglan) {
        $str_tgl    = $tglan;
        $dta_tgl    = ($str_tgl != '0000-00-00' ? strtotime($str_tgl) : '');
        $tgln       = (!empty($dta_tgl) ? date('Y-m-d', $dta_tgl) : '');
        $tgle       = $tgln;
        return $tgle;
    }

    /**
     * Convert dd/mm/yyyy to yyyy-mm-dd
     */
    public static function tgl_indo_sys2($tglan) {
        $tgl = explode('/', $tglan);
        $tanggal = $tgl[0];
        $bulan = $tgl[1];
        $tahun = $tgl[2];
        $tgle = (!empty($tglan) ? $tahun . '-' . $bulan . '-' . $tanggal : '');
        return $tgle;
    }

    /**
     * Get time in HH:ii format
     */
    public static function wkt_indo($tglan) {
        $str_tgl = $tglan;
        $dta_tgl = ($str_tgl != '0000-00-00 00:00:00' ? $str_tgl : '');
        $tgln = (!empty($dta_tgl) ? date('H:i', strtotime($dta_tgl)) : '');
        $tgle = $tgln;
        return $tgle;
    }

    /**
     * Get Indonesian month name
     */
    public static function getBulan($bln) {
        switch ($bln) {
            case 1:
                return "Januari";
            case 2:
                return "Februari";
            case 3:
                return "Maret";
            case 4:
                return "April";
            case 5:
                return "Mei";
            case 6:
                return "Juni";
            case 7:
                return "Juli";
            case 8:
                return "Agustus";
            case 9:
                return "September";
            case 10:
                return "Oktober";
            case 11:
                return "November";
            case 12:
                return "Desember";
        }
    }

    /**
     * Get current day name in Indonesian
     */
    public static function hari_ini() {
        $nm_hari = array(
            'Sun' => 'Minggu',
            'Mon' => 'Senin',
            'Tue' => 'Selasa',
            'Wed' => 'Rabu',
            'Thu' => 'Kamis',
            'Fri' => 'Jumat',
            'Sat' => 'Sabtu'
        );

        $hari = date("D");
        $hari_ini = $nm_hari[$hari];
        return $hari_ini;
    }

    /**
     * Get day name in Indonesian for a given date
     */
    public static function hari_ke($tanggal) {
        $nm_hari = array(
            'Sun' => 'Minggu',
            'Mon' => 'Senin',
            'Tue' => 'Selasa',
            'Wed' => 'Rabu',
            'Thu' => 'Kamis',
            'Fri' => 'Jumat',
            'Sat' => 'Sabtu'
        );

        $hari = date('D', strtotime($tanggal));
        $hari_ini = $nm_hari[$hari];
        return $hari_ini;
    }

    /**
     * Get Indonesian month name for a given month number
     */
    public static function bulan_ke($bln) {
        switch ($bln) {
            case 1:
                $bulan = "Januari";
                break;
            case 2:
                $bulan = "Februari";
                break;
            case 3:
                $bulan = "Maret";
                break;
            case 4:
                $bulan = "April";
                break;
            case 5:
                $bulan = "Mei";
                break;
            case 6:
                $bulan = "Juni";
                break;
            case 7:
                $bulan = "Juli";
                break;
            case 8:
                $bulan = "Agustus";
                break;
            case 9:
                $bulan = "September";
                break;
            case 10:
                $bulan = "Oktober";
                break;
            case 11:
                $bulan = "November";
                break;
            case 12:
                $bulan = "Desember";
                break;
        }
        
        return $bulan;
    }

    /**
     * Calculate age in years from birthdate
     */
    public static function usia($tglan) {
        $birthDate = new DateTime($tglan);
        $today = new DateTime("today");
        if ($birthDate > $today) {
            return "0 Tahun 0 Bulan 0 Hari";
        }
        $y = $today->diff($birthDate)->y;
        $m = $today->diff($birthDate)->m;
        $d = $today->diff($birthDate)->d;
        $umur = $y . " tahun";
        return ucwords($umur);
    }

    /**
     * Calculate age in years only from birthdate
     */
    public static function usia_angka($tglan) {
        $birthDate = new DateTime($tglan);
        $today = new DateTime("today");
        if ($birthDate > $today) {
            return "0 Tahun 0 Bulan 0 Hari";
        }
        $y = $today->diff($birthDate)->y;
        $m = $today->diff($birthDate)->m;
        $d = $today->diff($birthDate)->d;
        $umur = $y;
        return ucwords($umur);
    }

    /**
     * Calculate complete age (years, months, days) from birthdate
     */
    public static function usia_lkp($tglan) {
        $birthDate = new DateTime($tglan);
        $today = new DateTime("today");

        $str_tgl = $tglan;
        if ($str_tgl != '0000-00-00') {
            $y = $today->diff($birthDate)->y;
            $m = $today->diff($birthDate)->m;
            $d = $today->diff($birthDate)->d;
            $umur = $y . " tahun " . $m . " bulan " . $d . " hari";
        }
        return $umur;
    }

    /**
     * Calculate days and hours between two dates
     */
    public static function usia_hari($tgl_awal, $tgl_akhir) {
        $birthDate = new DateTime($tgl_awal);
        $today = new DateTime($tgl_akhir);
        if ($birthDate > $today) {
            return "0 Hari 0 Jam";
        }
        $h = $today->diff($birthDate)->d;
        $j = $today->diff($birthDate)->h;
        $m = $today->diff($birthDate)->i;
        $umur = $h . ' Hari ' . $j . ' Jam';

        return ucwords($umur);
    }

    /**
     * Calculate time difference between two dates
     */
    public static function usia_wkt($tgl_awal, $tgl_akhir) {
        $awal   = date_create($tgl_awal);
        $akhir  = date_create($tgl_akhir);
        $diff   = date_diff($awal, $akhir);
        $usia   = ($diff->d > 0 ? $diff->d.' Hari ' : '').($diff->h > 0 ? $diff->h.' Jam ' : '').($diff->i > 0 ? $diff->i.' Menit' : '');;
                
        if(empty($tgl_awal)){
            $umur = '';
        }elseif(empty($tgl_akhir)){
            $umur = '';
        }elseif($tgl_awal == '0000-00-00 00:00:00'){
            $umur = '';
        }elseif($tgl_akhir == '0000-00-00 00:00:00'){
            $umur = '';
        }else{
            $umur = $usia;
        }
        
        return ucwords($umur);
    }

    /**
     * Calculate time elapsed since a given date
     */
    public static function sejak($since) {
        $timeCalc = strtotime(date('Y-m-d H:i:s')) - strtotime($since);
        
        if ($timeCalc >= (60 * 60 * 24 * 30 * 12 * 2)) {
            $timeCalc = intval($timeCalc / 60 / 60 / 24 / 30 / 12) . " years ago";
        } else if ($timeCalc >= (60 * 60 * 24 * 30 * 12)) {
            $timeCalc = intval($timeCalc / 60 / 60 / 24 / 30 / 12) . " tahun";
        } else if ($timeCalc >= (60 * 60 * 24 * 30 * 2)) {
            $timeCalc = intval($timeCalc / 60 / 60 / 24 / 30) . " months ago";
        } else if ($timeCalc >= (60 * 60 * 24 * 30)) {
            $timeCalc = intval($timeCalc / 60 / 60 / 24 / 30) . " bulan";
        } else if ($timeCalc >= (60 * 60 * 24 * 2)) {
            $timeCalc = intval($timeCalc / 60 / 60 / 24) . " hari";
        } else if ($timeCalc >= (60 * 60 * 24)) {
            $timeCalc = " Kemarin";
        } else if ($timeCalc >= (60 * 60 * 2)) {
            $timeCalc = intval($timeCalc / 60 / 60) . " hours ago";
        } else if ($timeCalc >= (60 * 60)) {
            $timeCalc = intval($timeCalc / 60 / 60) . " jam";
        } else if ($timeCalc >= 60 * 2) {
            $timeCalc = intval($timeCalc / 60) . " menit";
        } else if ($timeCalc >= 60) {
            $timeCalc = intval($timeCalc / 60) . " menit";
        } else if ($timeCalc > 0) {
            $timeCalc .= " detik";
        }
        
        return $timeCalc;
    }
    
    /**
     * Calculate number of days between two dates
     */
    public static function jml_hari($tgl_awal, $tgl_akhir) {
        $tg_awal = date('Y-m-d', strtotime($tgl_awal));
        
        $tgl1 = new DateTime($tg_awal);
        $tgl2 = new DateTime($tgl_akhir);
        $jarak = $tgl2->diff($tgl1);

        return $jarak->d;
    }
    
    /**
     * Get time of day text (Pagi/Siang/Sore/Malam)
     */
    public static function wkt_teks($wkt) {
        $waktu = strtotime($wkt);
        
        $pagi1  = strtotime('05:00');
        $pagi2  = strtotime('11:01');
        $siang1 = strtotime('11:01');
        $siang2 = strtotime('15:01');
        $sore1  = strtotime('15:01');
        $sore2  = strtotime('18:01');
        $malam1 = strtotime('18:01');
        $malam2 = strtotime('00:01');
        
        if($waktu >= $pagi1 AND $waktu < $pagi2){
            $teks = 'Pagi';
        }elseif($waktu >= $siang1 AND $waktu < $siang2){
            $teks = 'Siang';
        }elseif($waktu >= $sore1 AND $waktu < $sore2){
            $teks = 'Sore';
        }elseif($waktu >= $malam1){
            $teks = 'Malam';
        }else{
            $teks = 'Uppsss !!';
        }

        return $teks;
    }

}
