<?php
/**
 * Gudang Model
 * 
 * Model for handling warehouse operations and minimum stock monitoring
 * 
 * @author Mikhael Felian Waskito - mikhaelfelian@gmail.com
 * @date 2025-04-12
 */

class Gudang_model extends CI_Model {
    
    /**
     * Get minimum stock items
     * 
     * Retrieves products with low stock levels
     * 
     * @param int $limit Maximum number of records to return
     * @return array Array of products with low stock
     */
    public function get_minimum_stock($limit = 100) {
        // Only get from active warehouse
        $sg = $this->db->where('status', '1')->get('tbl_m_gudang')->row();

        $this->db->select('tbl_m_produk.id, tbl_m_produk.tgl_simpan, tbl_m_produk.kode, tbl_m_produk.produk, tbl_m_produk_stok.jml');
        $this->db->from('tbl_m_produk_stok');
        $this->db->join('tbl_m_produk', 'tbl_m_produk_stok.id_produk = tbl_m_produk.id');
        $this->db->where('tbl_m_produk_stok.id_gudang', $sg->id);
        $this->db->where('tbl_m_produk.status_subt', '1');
        $this->db->where('tbl_m_produk_stok.jml <=', 10); // Adjust threshold as needed
        $this->db->order_by('tbl_m_produk_stok.jml', 'ASC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }
} 