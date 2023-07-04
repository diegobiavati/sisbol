<?php

class MeuPDFFic extends FPDF
{ private $om;
  private $pessoa;
  private $pagina;
  //private $nomeGuerra;
  
  public function getOM()
  { return $this->om;
  }
  public function setOM($valor)
  { $this->om = $valor;
  }
  public function getPessoa()
  { return $this->pessoa;
  }
  public function setPessoa($valor)
  { $this->pessoa = $valor;
  }
  public function getPagina()
  { return $this->pagina;
  }
  public function setPagina($valor)
  { $this->pagina = $valor;
  }
  public function MeuPDFFic($orientation='P',$unit='mm',$format='A4')
  { FPDF::FPDF($orientation, $unit, $format);
    //$this->nomeGuerra = new NomeGuerra();

  }
  function Header()
  {
	$this->SetLeftMargin(20);
	$sigla = strtoupper($this->om->getSigla());
	$codOM = $this->om->getCodOM();
	$siglaCodOM = $sigla . ' - ' . $codOM;
	if (round($this->GetStringWidth($this->om->getSubd1())) >= round($this->GetStringWidth($this->om->getSubd2())))
	{
		$largura = round($this->GetStringWidth($this->om->getSubd1()));
	}
	if ($largura <= round($this->GetStringWidth($this->om->getSubd2()))){
		$largura = round($this->GetStringWidth($this->om->getSubd2()));
	}
	if ($largura <= round($this->GetStringWidth($this->om->getSubd3()))){
		$largura = round($this->GetStringWidth($this->om->getSubd3()));
	}
/*        if ($largura <= round($this->GetStringWidth($this->om->getSubd4()))){
		$largura = round($this->GetStringWidth($this->om->getSubd4()));
	}
        if ($largura <= round($this->GetStringWidth($this->om->getSubd5()))){
		$largura = round($this->GetStringWidth($this->om->getSubd5()));
	}
 */
	if ($largura <= round($this->GetStringWidth($siglaCodOM))){
		$largura = round($this->GetStringWidth($siglaCodOM));
	}		
	$larSiglaCodOM = round($this->GetStringWidth($siglaCodOM));
	while ($larSiglaCodOM < $largura-2){
		$sigla = $sigla . ' ';
		$codOM = ' ' . $codOM;
		$siglaCodOM = $sigla . '-' . $codOM;
		$larSiglaCodOM = round($this->GetStringWidth($siglaCodOM));
	}
	   
    $this->pagina = $this->pagina + 1;
//    $auxmes = $this->dtInicio->getImes(); 
    $this->SetFont('Times','',12);

    //cabecalho        
    $this->Cell($largura,5,strtoupper($this->om->getSubd1()),0,0,'C');
    $this->setX(100);	
    $this->Cell(97,5,'FICHA DE IDENTIFICAÇÃO',0,1,'R');
    $this->Cell($largura,5,strtoupper($this->om->getSubd2()),0,1,'C');
    if ($this->om->getSubd3() <> '')
    { $this->Cell($largura,5,strtoupper($this->om->getSubd3()),0,1,'C');
/*      if ($this->om->getSubd4() <> '')
        $this->Cell($largura,5,strtoupper($this->om->getSubd4()),0,1,'C');
      if ($this->om->getSubd5() <> '')
        $this->Cell($largura,5,strtoupper($this->om->getSubd5()),0,1,'C');
 */
      $this->Cell($largura,5,$siglaCodOM,0,0,'C');
   	  $this->setX(100);	
      $this->Cell(97,5,'GUARNIÇÃO DE '.strtr(strtoupper($this->om->getGu()),'áéíóúãõâêôçäëïöü','ÁÉÍÓÚÃÕÂÊÔÇÄËÏÖÜ'),0,1,'R');
    }else{
	  $this->Cell($largura,5,$siglaCodOM,0,0,'C');
	  $this->setX(100);	
	  $this->Cell(97,5,'GUARNIÇÃO DE '.strtr(strtoupper($this->om->getGu()),'áéíóúãõâêôçäëïöü','ÁÉÍÓÚÃÕÂÊÔÇÄËÏÖÜ'),0,1,'R');
          $this->ln();
    }
	
 /*      if ($this->om->getSubd4() == ''){
            $this->ln();}
       if ($this->om->getSubd5() == ''){
            $this->ln();}
            
        $this->ln();
        $this->Rect(20,20,177,30);
  	$this->Rect(20,50,177,232);	
  */
        $this->ln();
        $this->Rect(20,20,177,21);
  	$this->Rect(20,41,177,232);
    
  }
  public function ImprimeNomePDF($nome)
	{//nome completo com as tags do nome de guerra
	  $i = 0;
      $this->SetFont('Times','',12);
	  while ($i <= strlen($nome))
	  { if (substr($nome, $i, 3) == '<U>')
	    { $i = $i + 3;
          $this->SetFont('Times','B',12);
        }
        if (substr($nome, $i, 4) == '</U>')
        { $i = $i + 4;
          $this->SetFont('Times','',12);
        }
        $this->Cell(round($this->GetStringWidth($nome[$i])),5,$nome[$i],0,0,'L');
        $i = $i + 1;     
	  }
	}		
  public function ImprimeNomePDF2($nome)
	{//nome completo com as tags do nome de guerra
	  $i = 0;
      $this->SetFont('Times','',12);
      $saida = '';
	  while ($i <= strlen($nome))
	  { if (substr($nome, $i, 3) == '<U>')	  
	    { if ($saida != '')
		  { $this->Cell(round($this->GetStringWidth($saida)),5,$saida,0,0,'L');}
	      $saida = '';
		  $i = $i + 3;
          $this->SetFont('Times','B',12);
        }
        if (substr($nome, $i, 4) == '</U>')
        { if ($saida != '')
		  { $this->Cell(round($this->GetStringWidth($saida)),5,$saida,0,0,'L');}
          $saida = '';
		  $i = $i + 4;
          $this->SetFont('Times','',12);
        }
        $saida = $saida . $nome[$i];
        $i = $i + 1;     
	  }
      $this->Cell(round($this->GetStringWidth($saida)),5,$saida,0,0,'L');
	  
	}		
}
?>
