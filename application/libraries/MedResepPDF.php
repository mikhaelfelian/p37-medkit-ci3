<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
require_once APPPATH.'third_party/Fpdf/fpdf.php';

/**
 * Description of Pdf
 *
 * @author Mikhael Felian Waskito - mikhaelfelian@gmail.com
 * @modified by Mikhael Felian Waskito - mikhaelfelian@gmail.com
 * @date 2025-03-24
 */
class MedResepPDF extends FPDF {

    private $nm_dokter;
    private $no_sip;

    // Store doctor info as class properties
    public function setDoctorInfo($dokter, $no_sip) {
        $this->nm_dokter = $dokter;
        $this->no_sip = $no_sip;
    }

    public function Header() {
        $CI = & get_instance();
        $CI->load->database();

        $setting = $CI->db->get('tbl_pengaturan')->row();
        $gambar1 = FCPATH.'/assets/theme/admin-lte-3/dist/img/logo-header-es.png';

        $this->Ln(0.25);
        $this->SetFont('Arial', 'B', '7');
        $this->SetTextColor(0,146,63,255);
        $this->Cell(5, .5, '', '', 0, 'L', FALSE);
        $this->MultiCell(4.5, .5, $setting->judul, '0', 'L');
        $this->Ln(0.5);

        // Gambar Logo Atas 1
        if(file_exists($gambar1)) {
            $this->Image($gambar1, 1, 0.25, 5, 1.3);
        }
    }
}
