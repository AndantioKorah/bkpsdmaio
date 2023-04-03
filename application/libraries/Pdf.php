<?php 
error_reporting(1);
if (!defined('BASEPATH')) exit('No direct script access allowed');  
use Dompdf\Dompdf;
use Dompdf\Options;
require_once 'dompdf/autoload.inc.php';




class Pdf extends Dompdf
{
	public function __construct()
	{
		 parent::__construct();
	} 
}

?>