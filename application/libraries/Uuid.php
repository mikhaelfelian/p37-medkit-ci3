<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Ramsey\Uuid\Uuid as RamseyUuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class Uuid {
    
    protected $CI;
    
    public function __construct() {
        $this->CI =& get_instance();
        
        // Autoload Composer's autoloader
        require_once FCPATH . 'vendor/autoload.php';
    }
    
    /**
     * Generate UUID v4
     * @return string
     */
    public function v4() {
        try {
            $uuid4 = RamseyUuid::uuid4();
            return $uuid4->toString();
        } catch (UnsatisfiedDependencyException $e) {
            log_message('error', 'UUID Generation failed: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Generate UUID v1 (timestamp-based)
     * @return string
     */
    public function v1() {
        try {
            $uuid1 = RamseyUuid::uuid1();
            return $uuid1->toString();
        } catch (UnsatisfiedDependencyException $e) {
            log_message('error', 'UUID Generation failed: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Check if a string is a valid UUID
     * @param string $uuid
     * @return bool
     */
    public function isValid($uuid) {
        return RamseyUuid::isValid($uuid);
    }
    
    /**
     * Generate short UUID (13 characters)
     * @return string
     */
    public function short() {
        try {
            $uuid = RamseyUuid::uuid4();
            return substr(str_replace(['-', '/'], '', base64_encode($uuid->getBytes())), 0, 13);
        } catch (UnsatisfiedDependencyException $e) {
            log_message('error', 'Short UUID Generation failed: ' . $e->getMessage());
            return false;
        }
    }
} 