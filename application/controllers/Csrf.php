<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Csrf Controller
 * 
 * Handles CSRF token refresh functionality
 * 
 * @author    Mikhael Felian Waskito <mikhaelfelian@gmail.com>
 * @date      2025-03-28
 */
class Csrf extends CI_Controller {

    /**
     * Refresh CSRF token
     * Returns a new CSRF token for AJAX requests
     * 
     * @return void
     */
    public function refresh() {
        // Verify this is an AJAX request
        if (!$this->input->is_ajax_request()) {
            show_error('Direct access not allowed', 403);
            return;
        }

        // Send JSON response with new CSRF data
        $csrf = array(
            'name'  => $this->security->get_csrf_token_name(),
            'token' => $this->security->get_csrf_hash()
        );
        
        header('Content-Type: application/json');
        echo json_encode($csrf);
    }
} 