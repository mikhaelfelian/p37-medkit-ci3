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
class MedNotaPDF extends FPDF {
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
        $gambar1 = FCPATH.'/assets/theme/admin-lte-3/dist/img/logo-header-es1.png';

        $this->Ln(1);
        $this->SetFont('Courier', 'B', '14');
        $this->Cell(2.5, .5, '', '', 0, 'L', FALSE);
        $this->Cell(16.5, .5, $setting->judul, '', 0, 'C', FALSE);
        $this->Ln(0.5);
        $this->SetFont('Courier', 'B', '10');
        $this->Cell(2.5, .5, '', 'B', 0, 'L', FALSE);
        $this->Cell(16.5, .5, $setting->alamat, 'B', 0, 'C', FALSE);
        $this->Ln(1);

        // Gambar Logo Atas
        if(file_exists($gambar1)) {
            $this->Image($gambar1, 1, 0.85, 2.40, 2);
        }
    }

    public function Footer() {
        $gambar3 = FCPATH.'/assets/theme/admin-lte-3/dist/img/logo-footer.png';

        // Gambar Watermark Bawah
        if(file_exists($gambar3)) {
            $this->Image($gambar3, 0, 22.75, 21, 7, 'png');
        }
    }
}
