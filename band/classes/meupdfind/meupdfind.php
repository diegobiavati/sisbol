<?php

class MeuPDFInd extends FPDF
{ private $tipoBolAbrev;
  private $dtInicio;
  private $dtTermino;
  public function MeuPDFInd($orientation='P',$unit='mm',$format='A4', $tipoBolAbrev, $dtInicio, $dtTermino)
  { FPDF::FPDF($orientation, $unit, $format);
    $this->tipoBolAbrev = $tipoBolAbrev;
    $this->dtInicio = $dtInicio->GetcDataDDBMMBYYYY();
    $this->dtTermino = $dtTermino->GetcDataDDBMMBYYYY();
  }
  function Footer()
  {
	//To be implemented in your own inherited class
    //Vai para 1.5 cm da borda inferior
	$this->SetLeftMargin(15);
    $this->SetY(-12);
    //imprime o status do boletim
    $this->SetFont('Times','',12);
	$this->Cell(180,4,'- Página ' . $this->PageNo() . ' -',0,0,'C');	  
    $this->SetFont('Times','',12);
    
  }
  function Header()
  {
	//To be implemented in your own inherited class
    $this->SetFont('Times','',12);
	if ($this->PageNo() <> 1)
	{
	    //Vai para 1.5 cm da borda superior
    	$this->SetY(6);
	    $this->Cell(150,5,'(Continuação do Índice Remissivo dos ' .  $this->tipoBolAbrev . ' de ' .
					 $this->dtInicio . ' a ' . $this->dtTermino . ')',0,0,'L');
    }
   	$this->SetY(15);
  }
}
?>
