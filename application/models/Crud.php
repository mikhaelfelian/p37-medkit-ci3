<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php

class crud extends CI_Model {

    private $table_name;

    public function __construct() {
        parent::__construct();
    }

    public static function simpan($tabel, $data) {
        $CI =& get_instance();
        $CI->db->insert($tabel, $data);
        
        if ($CI->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function update($tabel, $field, $kode, $p) {
        $CI =& get_instance();
        $CI->db->where($field, $kode);
        $CI->db->update($tabel, $p);
        
        if ($CI->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function delete($tabel, $field, $kode) {
        $CI =& get_instance();
        $CI->db->where($field, $kode);
        $CI->db->delete($tabel);

        if ($CI->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function last_id() {
        $CI =& get_instance();
        $id = $CI->db->insert_id();
        return $id;
    }

    
    
    public static function kmr_label() {
        $CI =& get_instance();
        $sql = $CI->db->select('kamar')->where('status', '1')->get('tbl_m_kamar')->result();
        
        foreach ($sql as $kmr) {
            $data[] = $kmr->kamar;
        }
        $label_kmr = json_encode($data);
        return $label_kmr;
    }
    
    public static function kmr_kapasitas() {
        $CI =& get_instance();
        $sql = $CI->db->select('jml_max')->where('status', '1')->get('tbl_m_kamar')->result();
        
        foreach ($sql as $kmr) {
            $data[] = $kmr->jml_max;
        }
        
        $label_kaps = json_encode($data);
        return $label_kaps;
    }

    /**
     * Generate a sequential invoice number based on year and month
     * 
     * @param string $prefix Prefix for the invoice number
     * @param string $table Table to check for existing invoice numbers
     * @param string $date_field Field containing the date to check
     * @param string $format Format for the invoice number (default: 'INV/Y/m/00000')
     * @return string Formatted invoice number
     */
    public static function no_nota($prefix = 'INV', $table = 'tbl_trans_medcheck', $date_field = 'tgl_simpan', $format = null) {
        $CI =& get_instance();
        
        // Get current month and year
        $month = date('m');
        $year = date('Y');
        
        // Count existing records for this month and year
        $number = $CI->db->where("MONTH($date_field)", $month)
                         ->where("YEAR($date_field)", $year)
                         ->get($table)
                         ->num_rows() + 1;
        
        // Format the invoice number
        if ($format === null) {
            $invoice_number = $prefix . '/' . $year . '/' . $month . '/' . sprintf('%05d', $number);
        } else {
            // Replace placeholders in custom format
            $invoice_number = str_replace(
                ['PREFIX', 'Y', 'm', 'NUMBER'],
                [$prefix, $year, $month, sprintf('%05d', $number)],
                $format
            );
        }
        
        return $invoice_number; 
    }
}
