<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php

/**
 * Description of menu
 *
 * @author mike
 */

class stok extends CI_Controller {
    //put your code here
    public function __construct() {
        parent::__construct();
    }
    
    public function cek_stok(){
        $sql_prod   = $this->db->limit('25')->order_by('id','desc')->get('tbl_m_produk')->result();
        
        foreach ($sql_prod as $produk){
            
        }
    }
}
