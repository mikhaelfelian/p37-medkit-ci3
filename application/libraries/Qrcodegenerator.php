<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH.'third_party/phpqrcode/qrlib.php';

class Qrcodegenerator {
    public function generate($params) {
        if (!isset($params['savename'])) {
            return false;
        }

        // Create directory if it doesn't exist
        $dir = dirname($params['savename']);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        // Default parameters
        $level = isset($params['level']) ? $params['level'] : 'H';
        $size = isset($params['size']) ? $params['size'] : 2;
        $margin = isset($params['margin']) ? $params['margin'] : 2;
        $data = isset($params['data']) ? $params['data'] : 'QR Code';

        // Map error correction level
        $errorCorrectionLevel = 'QR_ECLEVEL_' . strtoupper($level);
        if (!defined($errorCorrectionLevel)) {
            $errorCorrectionLevel = QR_ECLEVEL_H;
        }

        // Generate QR Code
        QRcode::png($data, $params['savename'], constant($errorCorrectionLevel), $size, $margin);

        return file_exists($params['savename']);
    }
} 