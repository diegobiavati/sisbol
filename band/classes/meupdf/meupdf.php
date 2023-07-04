<?php

class MeuPDF extends FPDF
{ private $pagInicial;
  private $tipoBol;
  private $nrBi;
  private $dataBi;
  private $pGradAssina;
  private $militarAssina;
  private $funcaoAssina;
  private $boletim;
  public function MeuPDF($orientation='P',$unit='mm',$format='A4', $pagInicial, $tipoBol, $boletim,
  							$pGradAssina, $militarAssina, $funcaoAssina)
  { FPDF::FPDF($orientation, $unit, $format);
    $this->pagInicial = $pagInicial;
    $this->tipoBol = $tipoBol->getDescricao();
    $this->res = stristr($this->tipoBol,'reservado');
    $this->tipoBolAbrev = $tipoBol->getAbreviatura();
    $this->nrBi = $boletim->getNumeroBi();
    $this->dataBi = $boletim->getDataPub()->GetcDataDDBMMBYYYY();
    //associar campos da assinatura
    $this->pGradAssina = $pGradAssina;
    $this->militarAssina = $militarAssina;
    $this->funcaoAssina = $funcaoAssina;
    $this->boletim = $boletim;
  }
  function Footer()
  {
	//To be implemented in your own inherited class
    //Vai para 1.5 cm da borda inferior
	$this->SetLeftMargin(15);
    $this->SetY(-20);
/*    //imprime o status do boletim
    $this->SetFont('Times','',8);
	if (($this->boletim->getAprovado() == "N") and ($this->boletim->getAssinado() == "N"))
	{ $this->Cell(90,5,'Boletim em elaboração! Gerado em ' . date('d/m/Y - H:i:s').'.',0,1,'L');
	}else{
	  if ($this->boletim->getAssinado() == "N")
	  { $this->Cell(90,5,'Boletim aprovado e ainda não assinado! Gerado em ' . date('d/m/Y - H:i:s').'.',0,1,'L');
	  }else
	  {	$this->Cell(90,5,'Gerado em '.date('d/m/Y - H:i:s').'.',0,1,'L');	  
	  }
    }*/
	if ($this->res){ 
	    $this->SetY(-10);
	    $this->SetFont('Times','B',12);
	    $this->SetTextColor(255,0,0);
	    $this->SetDrawColor(255,0,0);
	    $this->SetLineWidth(0.5);
		$this->Cell(70,7,'',0,0,'L');
		$this->Cell(40,7,'RESERVADO',1,0,'C');
		$this->Cell(70,7,'',0,0,'L');
	    $this->SetTextColor(0,0,0);
	    $this->SetDrawColor(0,0,0);
	    $this->SetLineWidth(0.2);
	}
    $this->SetFont('Times','',12);
  }
  function Header()
  {
	//To be implemented in your own inherited class
    $yPagDifPri = 6;
	if ($this->res){ 
	    $this->SetY($yPagDifPri-4);
	    $this->SetFont('Times','B',12);
	    $this->SetTextColor(255,0,0);
	    $this->SetDrawColor(255,0,0);
	    $this->SetLineWidth(0.5);
		$this->Cell(70,7,'',0,0,'L');
		$this->Cell(40,7,'RESERVADO',1,0,'C');
		$this->Cell(70,7,'',0,0,'L');
	    $this->SetTextColor(0,0,0);
	    $this->SetDrawColor(0,0,0);
	    $this->SetLineWidth(0.2);
	    $this->SetY(15);
	    $yPagDifPri = 14;
	}
    $this->SetFont('Times','',12);
	if ($this->PageNo() <> 1)
	{
	    //Vai para 1.5 cm da borda superior
    	$this->SetY($yPagDifPri);
	    $this->Cell(150,5,'(Continuação do ' .  $this->tipoBolAbrev . ' Nr ' . $this->nrBi . ', de ' . $this->dataBi . 
					')',0,0,'L');
	    $this->Cell(30,5,'Pag Nº ' . ($this->PageNo()+ $this->pagInicial),0,0,'R');
        $this->SetY($yPagDifPri+8);
    }else{
	    $this->SetY(15);
	    $this->Cell(180,5,'Pag Nº ' . ($this->PageNo()+ $this->pagInicial),0,0,'R');
    }
  }
  private function imprimirCampoAssinatura($pGradAssina, $militarAssina, $funcaoAssina)
  { 
    $linha = '_______';
    $this->SetFont('Times','B',8);
    if (($pGradAssina->getCodigo == 1) or ($pGradAssina->getCodigo == 2) or ($pGradAssina->getCodigo == 3))
    { $texto = $pGradAssina->getDescricao() . ' ' . $militarAssina->getNome();
    }
    else
    { 
      $texto = $militarAssina->getNome() . ' - ' . $pGradAssina->getDescricao();
    }
    while (round($this->GetStringWidth($linha)) < round($this->GetStringWidth($texto))+4)
    { $linha = $linha.'_';
    }
    //1-imprimir linha centralizada para assinatura 
    $this->Cell(60,3,$linha,0,1,'C');

    //2-imprimir posto/nome da autoridade que assina
    $this->Cell(120,3,'',0,0,'C');
    $this->Cell(60,3,$texto,0,1,'C');
      
    //3-imprimir funcao da autoridade que assina
    $this->SetFont('Times','',8);
    $this->Cell(120,3,'',0,0,'C');
    $this->Cell(60,3,$funcaoAssina->getDescricao(),0,1,'C');
    $this->SetFont('Times','',12);
  }
  
}
?>
