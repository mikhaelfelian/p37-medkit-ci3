<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        // Load necessary models if needed
    }

    public function notif_gudang() {
        if (akses::aksesLogin() == TRUE) {
            // Get pending mutations (status_nota = 0)
            $query = $this->db->where('status_nota', '0')
                              ->get('tbl_trans_mutasi');
            
            $result = $query->result();

            foreach ($result as $row) {
                $data[] = [
                    'nomer'     => $row->no_nota,
                    'user'      => $this->ion_auth->user($row->id_user)->row()->first_name,
                    'message'   => 'Permintaan : ' . $row->keterangan
                ];

                $total++;
            }
            
            // Return JSON response
            $response = [
                'data'    => isset($data) ? $data : [],
                'status'  => true,
                'total'   => isset($total) ? $total : 0,
                'message' => 'Ada ' . (isset($total) ? $total : 0) . ' mutasi yang belum diproses'
            ];

            header('Content-Type: application/json');
            echo json_encode($response);
        } else {
            // Return error response if not logged in
            $response = [
                'status' => false,
                'total' => 0,
                'message' => 'Authentication failed'
            ];

            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }
}