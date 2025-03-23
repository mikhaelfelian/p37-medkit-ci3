<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once FCPATH . 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class Excel {
    protected $spreadsheet;
    protected $alignment;
    protected $pageSetup;

    public function __construct() {
        $this->spreadsheet = new Spreadsheet();
        $this->alignment = new Alignment();
        $this->pageSetup = new PageSetup();
    }

    public function createSpreadsheet() {
        return new Spreadsheet();
    }

    public function getActiveSheet() {
        return $this->spreadsheet->getActiveSheet();
    }

    public function createWriter($spreadsheet = null) {
        $spreadsheet = $spreadsheet ?? $this->spreadsheet;
        return new Xlsx($spreadsheet);
    }

    public function getAlignment() {
        return $this->alignment;
    }

    public function getPageSetup() {
        return $this->pageSetup;
    }
}
?>
