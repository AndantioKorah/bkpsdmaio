<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// panggil autoload dompdf nya
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;
class Pdfgenerator extends Dompdf {

    public function __construct()
    {
        parent::__construct();
    }

    public function generate($html, $filename='', $paper = '', $orientation = '', $stream=TRUE)
    {   
        $options = new Options();
        $options->set('isRemoteEnabled', TRUE);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper($paper, $orientation);
        $dompdf->render();
        if ($stream) {
            // $dompdf->stream($filename.".pdf", array("Attachment" => false));
            $dompdf->stream($filename.".pdf");
        } else {
            return $dompdf->output();
           
        }
    }
}