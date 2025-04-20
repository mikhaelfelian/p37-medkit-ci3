<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Dompdf\Dompdf;
use Dompdf\Options;

class MedLabDomPDF {
    protected $dompdf;
    public $judul;
    public $subjudul;
    
    public function __construct() {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('isPhpEnabled', true);
        
        $this->dompdf = new Dompdf($options);
        $this->dompdf->setPaper('A4', 'portrait');
    }
    
    public function loadHtml($html) {
        // Add header and footer to the HTML
        $headerHtml = $this->generateHeader();
        $footerHtml = $this->generateFooter();
        
        $completeHtml = <<<HTML
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <style>
                @page {
                    margin: 2cm 1cm;
                }
                body {
                    font-family: Helvetica, Arial, sans-serif;
                    font-size: 10pt;
                }
                .header {
                    position: fixed;
                    top: 0;
                    left: 0;
                    right: 0;
                    height: 3cm;
                }
                .footer {
                    position: fixed;
                    bottom: 0;
                    left: 0;
                    right: 0;
                    height: 2cm;
                }
                .content {
                    margin-top: 3.5cm;
                    margin-bottom: 2.5cm;
                }
                .watermark {
                    position: fixed;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    opacity: 0.1;
                    z-index: -1000;
                }
            </style>
        </head>
        <body>
            <div class="header">
                {$headerHtml}
            </div>
            
            <div class="watermark">
                <img src="assets/theme/admin-lte-3/dist/img/logo-bw-bg2-1440px.png" width="500px">
            </div>
            
            <div class="content">
                {$html}
            </div>
            
            <div class="footer">
                {$footerHtml}
            </div>
        </body>
        </html>
        HTML;
        
        $this->dompdf->loadHtml($completeHtml);
    }
    
    protected function generateHeader() {
        $CI = & get_instance();
        $CI->load->database();
        
        $setting = $CI->db->get('tbl_pengaturan')->row();
        $logoPath = base_url('assets/theme/admin-lte-3/dist/img/logo-header-es.png');
        
        $header = <<<HTML
        <table width="100%" style="border-collapse: collapse;">
            <tr>
                <td width="40%">
                    <img src="{$logoPath}" style="width: 200px;">
                </td>
                <td width="60%" style="text-align: right; color: #00923f; font-weight: bold; font-size: 14pt;">
                    INSTALASI LABORATORIUM
                </td>
            </tr>
        </table>
        
        <div style="text-align: center; margin-top: 10px; border-bottom: 1px solid #000; padding-bottom: 5px;">
            <div style="font-weight: bold; font-size: 12pt;">{$this->judul}</div>
            <div style="font-weight: bold; font-style: italic; font-size: 12pt;">{$this->subjudul}</div>
        </div>
        
        <div style="margin-top: 10px;">
            <table width="100%">
                <tr>
                    <td width="60%"></td>
                    <td width="40%">
                        <div><strong>Dokter Penanggung Jawab:</strong></div>
                        <div>1. dr. ANITA TRI HASTUTI, Sp.PK</div>
                        <div>2. dr. YENI JAMILAH, Sp.MK</div>
                    </td>
                </tr>
            </table>
        </div>
        HTML;
        
        return $header;
    }
    
    protected function generateFooter() {
        $logoPath = base_url('assets/theme/admin-lte-3/dist/img/logo-footer.png');
        
        $footer = <<<HTML
        <div style="width: 100%; text-align: center;">
            <img src="{$logoPath}" style="width: 100%;">
        </div>
        HTML;
        
        return $footer;
    }
    
    public function render() {
        $this->dompdf->render();
    }
    
    public function stream($filename = 'document.pdf', $options = []) {
        return $this->dompdf->stream($filename, $options);
    }
    
    public function output() {
        return $this->dompdf->output();
    }
}