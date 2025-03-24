<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Qrcode {
    public function __construct() {
        require_once APPPATH . 'third_party/phpqrcode/qrlib.php';
    }

    public function generate($params) {
        // Create directory if not exists
        $dir = dirname($params['savename']);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        // Set error correction level
        $errorCorrectionLevel = 'H';
        if (isset($params['level']) && in_array($params['level'], ['L','M','Q','H'])) {
            $errorCorrectionLevel = $params['level'];
        }

        // Set size
        $matrixPointSize = 2;
        if (isset($params['size'])) {
            $matrixPointSize = $params['size'];
        }

        // Generate QR Code
        return \QRcode::png(
            $params['data'],
            $params['savename'],
            constant('QR_ECLEVEL_' . $errorCorrectionLevel),
            $matrixPointSize,
            2  // Margin
        );
    }
} 