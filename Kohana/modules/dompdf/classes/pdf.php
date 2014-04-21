<?php defined('SYSPATH') or die('No direct script access');

require Kohana::find_file('/', 'dompdf_usage');
require Kohana::find_file('/config/lang', "eng");


class MYPDF extends DOMPDF {

    function Header() {
        $image = Html::image('/images/icon-x.png');
        //$this->Image($image, '', '8', "180", '', 'PNG', '', '', false, 300, '', false, false, 0, 'C');
    }

    // Page footer
    function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(192, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
        $this->Cell(0, 20, 'Printed on: '.date('m-d-Y'), 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }
}


class Pdf
{

    protected $_pdf;

    /**
     * Set up default values
     */
    public function __construct($lang = NULL)
    {

        if ($lang === NULL)
        {
            $lang = 'eng';
        }



        // Create new PDF document - const. from tcpdf_config
        $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, TRUE, 'UTF-8', FALSE);

        //$image = Image::factory('images/print_header.png');


        // Set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('');
        $pdf->SetTitle('');
        $pdf->SetSubject('');
        $pdf->SetKeywords('');

        // Remove default header/footer
       // $pdf->setPrintHeader(TRUE);
       // $pdf->setPrintFooter(True);

        // Set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // Set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // Set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, 40, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // Set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);



        // Set font
        $pdf->SetFont('helvetica', '', 13);




        $pdf->AddPage();
        $this->_pdf = $pdf;

    }



    public function content($html)
    {
        $this->_pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
    }

    /**
     * Rendering PDF with given values
     * [1] Name
     * [2] D - Download, I - default action defined in client browser (main options)
     */
    public function save($name)
    {
        $this->_pdf->Output($name . '.pdf', 'I');
       // Request::current()->response()->headers('Content-Type', 'application/pdf');
    }

}

?>