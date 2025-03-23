<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Encrypt Compatibility Class
 *
 * This is a compatibility layer for applications upgrading from the old Encrypt
 * library to the new Encryption library in PHP 8.2+
 */
class CI_Encrypt {

    /**
     * Reference to the CI singleton
     *
     * @var object
     */
    protected $CI;

    /**
     * Encryption key
     *
     * @var string
     */
    public $encryption_key = '';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->CI =& get_instance();
        
        // Load the new encryption library
        $this->CI->load->library('encryption');
        
        // Get encryption key from config
        $this->encryption_key = config_item('encryption_key');
    }

    /**
     * Encode URL-safe string
     *
     * @param string $string Input string
     * @return string
     */
    public function encode_url($string)
    {
        $encrypted = $this->CI->encryption->encrypt($string);
        return strtr(base64_encode($encrypted), array('+' => '.', '=' => '-', '/' => '~'));
    }

    /**
     * Decode URL-safe string
     *
     * @param string $string Encoded string
     * @return string
     */
    public function decode_url($string)
    {
        $string = base64_decode(strtr($string, array('.' => '+', '-' => '=', '~' => '/')));
        return $this->CI->encryption->decrypt($string);
    }

    /**
     * Encode
     *
     * @param string $string Input string
     * @return string
     */
    public function encode($string)
    {
        return $this->CI->encryption->encrypt($string);
    }

    /**
     * Decode
     *
     * @param string $string Encoded string
     * @return string
     */
    public function decode($string)
    {
        return $this->CI->encryption->decrypt($string);
    }

    /**
     * Set the encryption key
     *
     * @param string $key Encryption key
     * @return void
     */
    public function set_key($key = '')
    {
        $this->encryption_key = $key;
        $this->CI->encryption->initialize(array('key' => $key));
    }

    /**
     * Get the encryption key
     *
     * @return string
     */
    public function get_key()
    {
        return $this->encryption_key;
    }
} 