<?php

class MeuPDFAlt extends FPDF
{ private $om;
  private $pessoa;
  private $dtInicio;
  private $dtTermino;
  private $pagina;
  private $omVinc;
  //private $nomeGuerra;
  
  public function getOM()
  { return $this->om;
  }
  public function getOMVinc()
  { return $this->omVinc;
  }
  public function setOM($valor)
  { $this->om = $valor;
  }
  public function setOMVinc($valor)
  { $this->omVinc = $valor;
  }
  public function getPessoa()
  { return $this->pessoa;
  }
  public function setPessoa($valor)
  { $this->pessoa = $valor;
  }
  public function getDtInicio()
  { return $this->dtInicio;
  }
  public function setDtInicio($valor)
  { $this->dtInicio = $valor;
  }
  public function getDtTermino()
  { return $this->dtTermino;
  }
  public function setDtTermino($valor)
  { $this->dtTermino = $valor;
  }
  public function getPagina()
  { return $this->pagina;
  }
  public function setPagina($valor)
  { $this->pagina = $valor;
  }
  public function MeuPDFAlt($orientation='P',$unit='mm',$format='A4')
  { FPDF::FPDF($orientation, $unit, $format);
    //$this->nomeGuerra = new NomeGuerra();

  }
  function Header()
  {
	$this->SetLeftMargin(20);
//	$sigla = strtoupper($this->om->getSigla());
	$sigla = strtoupper($this->omVinc->getSigla());
//	$codOM = $this->om->getCodOM();
	$codOM = $this->omVinc->getCodOM();
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
    $auxmes = $this->dtInicio->getImes(); 
    $this->SetFont('Times','',12);
	if ($this->pagina == 1)
	{
        //cabecalho        
       $this->Cell($largura,5,strtoupper($this->om->getSubd1()),0,0,'C');
	   $this->setX(120);	
       $this->Cell(77,5,'FOLHA DE ALTERAÇÕES',0,1,'L');
       $this->Cell($largura,5,strtoupper($this->om->getSubd2()),0,0,'C');
	   $this->setX(120);	
//       $this->Cell(77,5,'GUARNIÇÃO: '.$this->om->getGu(),0,1,'L');
       $this->Cell(77,5,'GUARNIÇÃO: '.$this->omVinc->getGu(),0,1,'L');
       if ($this->om->getSubd3() <> '')
       { $this->Cell($largura,5,strtoupper($this->om->getSubd3()),0,0,'C');
	     $this->setX(120);	
      	 $this->Cell(77,5,'FOLHA Nº '.$this->pagina,0,1,'L');
 /*       if ($this->om->getSubd4() <> ''){
            $this->Cell($largura,5,strtoupper($this->om->getSubd4()),0,0,'C');
            $this->ln();}
        if ($this->om->getSubd5() <> ''){
            $this->Cell($largura,5,strtoupper($this->om->getSubd5()),0,0,'C');
            $this->ln();} 
  */
       $this->Cell($largura,5,$siglaCodOM,0,0,'C');
       }else{   
	     $this->Cell($largura,5,$siglaCodOM,0,0,'C');
	     $this->setX(120);	
       	 $this->Cell($largura,5,'FOLHA Nº '.$this->pagina,0,1,'L');
       }
	   $this->ln(7);	
	   $this->Cell(15,5,'NOME: ',0,0,'L');
	   //marco
       /*$nomeCompleto = $this->nomeGuerra->setaNomeGuerra($this->pessoa->getNome(),$this->pessoa->getNomeGuerra(),'','');
       $this->imprimeNomePDF2($nomeCompleto);*/
//       $nomeCompleto = NomeGuerra::setaNomeGuerra($this->pessoa->getNome(),$this->pessoa->getNomeGuerra(),'','');
       $nomeCompleto = trim($this->pessoa->getNome()) . '(' . trim($this->pessoa->getNomeGuerra()) . ')';
       $this->imprimeNomePDF2($nomeCompleto);
	   $this->ln();	
	   $this->Cell(100,5,'POSTO/GRADUAÇÃO: '.strtoupper($this->pessoa->getPGrad()->getDescricao()),0,1,'L');
//       $this->Cell(177,5,'ARMA/SERVIÇO/QUALIFICAÇÃO: ',0,1,'L');
		// alterado por solicitacao do GSI
       $this->Cell(177,5,'QAS/QMS: ',0,1,'L');
       $this->Cell(177,5,strtoupper($this->pessoa->getQM()->getDescricao()),0,1,'L');
       $this->Cell(100,5,'IDENTIDADE: '.strtoupper($this->pessoa->getIdMilitar()),0,0,'L');
       if ($auxmes < 7)
       { $this->Cell(77,5,'1º Semestre de '. $this->dtInicio->GetIAno(),0,1,'L');
       }
       else
       { $this->Cell(77,5,'2º Semestre de '. $this->dtInicio->GetIAno(),0,1,'L');
       }
       $this->Cell(100,5,'CP: '.$this->pessoa->getCP(),0,0,'L');
       $this->Cell(77,5,'PERÍODO: ' . $this->dtInicio->GetcDataDDBMMBYYYY() . ' a ' . $this->dtTermino->GetcDataDDBMMBYYYY(),0,1,'L');
        //fim do cabecalho
	   $this->Rect(20,20,177,53);
  	   $this->Rect(20,73,177,209);	
    }else 
    { 
       $this->setX(20);	
//       $this->Cell(110,5,$this->om->getNome(),0,0,'L');
       $this->Cell(110,5,$this->omVinc->getNome(),0,0,'L');
       $this->Cell(67,5,'FOLHA Nº '.$this->pagina,0,1,'C');
       $this->Cell(177,5,'',0,1,'L');
       $this->Cell(177,5,'Continuação das Folhas de Alterações',0,1,'L');
       $this->Cell(round($this->GetStringWidth('do '.strtoupper($this->pessoa->getPGrad()->getDescricao())))+1,5,'do ' . 
	   				strtoupper($this->pessoa->getPGrad()->getDescricao()) . ' ',0,0,'L');
//       $nomeCompleto = NomeGuerra::setaNomeGuerra($this->pessoa->getNome(),$this->pessoa->getNomeGuerra(),'','');
       $nomeCompleto = trim($this->pessoa->getNome()) . '(' . trim($this->pessoa->getNomeGuerra()) . ')';
       $this->imprimeNomePDF2($nomeCompleto);
       $this->setX(130);	
       if ($auxmes < 7)
       { $this->Cell(67,5,'1º Semestre de '. $this->dtInicio->GetIAno(),0,1,'C');
       }
       else
       { $this->Cell(67,5,'2º Semestre de '. $this->dtInicio->GetIAno(),0,1,'C');
       }
       $this->Cell(110,5,'CP: '.$this->pessoa->getCP(),0,0,'L');
       $this->Cell(67,5,'PERÍODO: ' . $this->dtInicio->GetcDataDDBMMBYYYY() . ' a ' . $this->dtTermino->GetcDataDDBMMBYYYY(),0,1,'L');
       $this->ln(8);	
	   $this->Rect(20,20,177,26);
  	   $this->Rect(20,46,177,231);	
	}
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
