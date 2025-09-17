<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'third_party/dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

class Pdf
{
    public function generate($html, $filename = 'document', $paper = 'A4', $orientation = 'portrait')
    {
        $options = new Options();
        $options->set('isRemoteEnabled', TRUE);
        $dompdf = new Dompdf($options);

        $dompdf->loadHtml($html);

        // Logika baru untuk ukuran kertas F4
        if (strtolower($paper) == 'f4') {
            // Ukuran F4 dalam points (lebar x tinggi)
            $customPaper = array(0, 0, 609.45, 935.43); // 215mm x 330mm
            $dompdf->setPaper($customPaper, $orientation);
        } else {
            // Gunakan ukuran standar jika bukan F4
            $dompdf->setPaper($paper, $orientation);
        }

        $dompdf->render();
        $dompdf->stream($filename . ".pdf", array("Attachment" => false));
    }
}
