<?php

if(!defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';

class Pdf extends TCPDF {

	function __construct() {
		parent::__construct();

	}
	public function Footer() {
		// Position at 15 mm from bottom
		$this->setY(-15);
		// Set font
		
		// Page number
		$this->SetFont('times','I',8);
		$this->Cell(190,7,'E-Struk',0,1,'C');
	}
	
	
	
}

/* End of file Pdf.php */
/* Location: ./application/libraries/Pdf.php */