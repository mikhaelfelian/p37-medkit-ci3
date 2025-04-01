<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Satusehat_model extends CI_Model{

    var $table          = 'v_satusehat';
    var $table_pendf    = 'tbl_trans_medcheck';
    var $table_log      = 'tbl_util_log_satusehat';
    var $id             = 'no_rm';

    function get_data()
    {   $this->db->limit(1);
        $this->db->where('id_encounter IS NULL');
        $this->db->where('id_condition IS NULL');

        return $this->db->get($this->table)->result();
    }

    function total_rows()
    {
        $this->db->where('id_encounter IS NULL');
        $this->db->where('id_condition IS NULL');
        return $this->db->get($this->table)->num_rows();
    }

    function update_id($id, $data)
    {
        $this->db->where($this->id, $id);

        $this->db->update($this->table_pendf, $data);    
    }

    function insert_log($data)
    {
        $this->db->insert($this->table_log, $data);  
    }

}
?>