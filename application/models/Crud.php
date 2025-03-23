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
}
