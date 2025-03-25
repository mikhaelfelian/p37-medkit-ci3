<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('add_form_protection')) {
    function add_form_protection() {
        $CI =& get_instance();
        
        // Generate unique form ID
        $form_id = 'form_' . uniqid();
        
        // Add hidden field for form ID
        // CSRF is automatically added by form helper
        $output = form_hidden('form_id', $form_id);
        
        // Store form ID in session
        if (!$CI->session->userdata('submitted_forms')) {
            $CI->session->set_userdata('submitted_forms', array());
        }
        
        return $output;
    }
}

if (!function_exists('check_form_submitted')) {
    function check_form_submitted($form_id) {
        $CI =& get_instance();
        $submitted_forms = $CI->session->userdata('submitted_forms');
        
        if (empty($submitted_forms)) {
            $submitted_forms = array();
        }
        
        if (in_array($form_id, $submitted_forms)) {
            return true;
        }
        
        // Mark form as submitted
        mark_form_submitted($form_id);
        return false;
    }
}

if (!function_exists('mark_form_submitted')) {
    function mark_form_submitted($form_id) {
        $CI =& get_instance();
        $submitted_forms = $CI->session->userdata('submitted_forms');
        
        if (empty($submitted_forms)) {
            $submitted_forms = array();
        }
        
        // Add form ID to submitted forms
        $submitted_forms[] = $form_id;
        $CI->session->set_userdata('submitted_forms', $submitted_forms);
    }
}

if (!function_exists('add_double_submit_protection')) {
    function add_double_submit_protection($form_id = '') {
        return "
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            var form = document.getElementById('" . $form_id . "');
            if (form) {
                form.addEventListener('submit', function(e) {
                    var submitButton = form.querySelector('button[type=\"submit\"], input[type=\"submit\"]');
                    if (submitButton) {
                        if (submitButton.classList.contains('disabled')) {
                            e.preventDefault();
                            return false;
                        }
                        submitButton.classList.add('disabled');
                        submitButton.setAttribute('disabled', 'disabled');
                        
                        // Optional: Add loading text
                        if (submitButton.tagName === 'BUTTON') {
                            submitButton.dataset.originalText = submitButton.innerHTML;
                            submitButton.innerHTML = '<i class=\"fas fa-spinner fa-spin\"></i> Processing...';
                        }
                    }
                });
            }
        });
        </script>";
    }
} 