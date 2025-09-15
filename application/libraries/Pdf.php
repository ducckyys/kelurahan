<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Sertakan autoloader DomPDF
require_once APPPATH . 'third_party/dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

class Pdf
{
    public function generate($html, $filename = 'document', $paper = 'A4', $orientation = 'portrait')
    {
        $options = new Options();
        // Mengaktifkan remote images sangat penting agar bisa memuat gambar dari base_url()
        $options->set('isRemoteEnabled', TRUE);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper($paper, $orientation);
        $dompdf->render();

        // Attachment => false akan menampilkan PDF di browser (preview)
        // Attachment => true akan langsung men-download file
        $dompdf->stream($filename . ".pdf", array("Attachment" => false));
    }
}
