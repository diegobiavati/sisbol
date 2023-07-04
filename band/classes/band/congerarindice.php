<?php
  class ConGerarIndice
  { private $rgrIndice;
    private $rgrOM;
    private $pdf;
    private $bandIniFile;
    public function ConGerarIndice($rgrIndice,$rgrOM, $bandIniFile)
    { $this->rgrIndice = $rgrIndice;
      $this->rgrOM = $rgrOM;
      $this->bandIniFile = $bandIniFile;
    }
    public function formataNumBi($numBi){
		while (strlen($numBi) < 3){
			$numBi = 0 . $numBi;
		}    	
		return $numBi;
    }
    public function gerarIndice($codTipoBol, $dtInicio, $dtTermino)
    { $colIndice2 = $this->rgrIndice->lerColecao($codTipoBol, $dtInicio, $dtTermino);
      $indice = $colIndice2->iniciaBusca1();
      //var_export($indice);
      if ($indice == null)
	  { 	echo '<script>window.alert("Não há matérias publicadas para o período selecionado!");</script>';
	        return "error";
	  }
    
      //captura as informações da OM
      $OM = $this->rgrOM->lerRegistro();

      //PREPARA PARA GERAR O PDF
	  $fpdfFontDir = $this->bandIniFile->getFPDFFontDir();
      define("FPDF_FONTPATH",$fpdfFontDir);
	  $this->pdf = new MeuPDFInd('P','mm','A4',$indice->getBoletim()->getTipoBol()->getAbreviatura(),$dtInicio,$dtTermino); 
	  $this->pdf->SetMargins(15,15,15);
	  $this->pdf->SetAutoPageBreak(true,17);
	  $this->pdf->AddPage();

	  //imprime o cabeçalho da OM
	  $this->pdf->SetFont('Times','B',10);
	  $this->pdf->Cell(180,4,strtoupper($OM->getSubd1()),0,1,'C');
	  $this->pdf->Cell(180,4,strtoupper($OM->getSubd2()),0,1,'C');
	  if ($OM->getSubd3() <> '')
		  $this->pdf->Cell(180,4,strtoupper($OM->getSubd3()),0,1,'C');
          $this->pdf->Cell(180,4,strtoupper($OM->getNome()),0,1,'C');
          if ($OM->getDesigHist() <> '')
		  $this->pdf->Cell(180,4,strtoupper($OM->getDesigHist()),0,1,'C');
          if ($OM->getSubd4() <> '')
		  $this->pdf->Cell(180,4,strtoupper($OM->getSubd4()),0,1,'C');
	  $this->pdf->Cell(180,6,'',0,1,'C');
	  $this->pdf->SetFont('Times','B',12);
	  $this->pdf->Cell(180,4,'ÍNDICE REMISSIVO DOS ' . $indice->getBoletim()->getTipoBol()->getAbreviatura() .  ' de ' . 
			    $dtInicio->GetcDataDDBMMBYYYY() . ' a ' . $dtTermino->GetcDataDDBMMBYYYY(),0,1,'C'); 
	  $this->pdf->ln();
	  $this->pdf->ln();
	
	  //percorre toda a colecao
	  while ($indice != null) 
	  { $letra = substr($indice->getMateriaBi()->getAssuntoGeral()->getDescricao(),0,1);
	    $letraAnt = $letra;
	    $this->pdf->SetLeftMargin(15);
		$this->pdf->SetFont('Times','B',16);
		$this->pdf->Cell(180,4,$letra,0,1,'L');
		$this->pdf->ln();
	    //percorre pela mesma letra
  	    while (($indice != null) and ($letra == $letraAnt))
	    { $descricaoAssuntoGeral = $indice->getMateriaBi()->getAssuntoGeral()->getDescricao();
		  $this->pdf->SetLeftMargin(15);
		  $this->pdf->SetFont('Times','B',12);
          $this->pdf->MultiCell(180,4,chr(187).' '.$descricaoAssuntoGeral,0,'J',0);
          //percorre pelo assunto geral
          while (($indice != null) and ($letra == $letraAnt) 
		  and ($descricaoAssuntoGeral == $indice->getMateriaBi()->getAssuntoGeral()->getDescricao()))
	      { $descricaoAssuntoEspec = $indice->getMateriaBi()->getAssuntoEspec()->getDescricao();
		    $this->pdf->SetLeftMargin(19);
		    $this->pdf->SetFont('Times','',12);
            $this->pdf->MultiCell(175,4,'- '.$descricaoAssuntoEspec,0,'J',0);
     	    //percorre pelo assunto especifico
            while (($indice != null) and ($letra == $letraAnt) 
            and ($descricaoAssuntoGeral == $indice->getMateriaBi()->getAssuntoGeral()->getDescricao())
			and ($descricaoAssuntoEspec == $indice->getMateriaBi()->getAssuntoEspec()->getDescricao()))
	        { 
	 	      $this->pdf->SetLeftMargin(19);
			  $this->pdf->SetFont('Times','',12);
			  $this->pdf->Cell(180,4,'     '.$indice->getBoletim()->getTipoBol()->getAbreviatura() . ' Nº ' . 
			    $indice->getBoletim()->getNumeroBi() . ' de '. 
				$indice->getBoletim()->getDataPub()->GetcDataDDBMMBYYYY() . ' pag. '. 
				$indice->getMateriaBi()->getPagina() . " - Nota: " . $indice->getMateriaBi()->getCodigo() . " - Usuário: " . $indice->getMateriaBi()->getUsuario() ,0,1,'L',0,
				$indice->getBoletim()->getDataPub()->getcDataYYYYHMMHDD() . '_O_' . 
				$this->formataNumBi($indice->getBoletim()->getNumeroBi()). '_' . 
//	Alterado Ten S.Lopes em (23/04/12)--> Função depreciada	ereg_replace(' ','_',strtolower($indice->getBoletim()->getTipoBol()->getDescricao())) . '.pdf'); 
				str_replace(' ','_',strtolower($indice->getBoletim()->getTipoBol()->getDescricao())) . '.pdf');
     		  $indice = $colIndice2->getProximo1();
     		  if ($indice != null)
     		  { $letra = substr($indice->getMateriaBi()->getAssuntoGeral()->getDescricao(),0,1);
     		  }
     		}
     	  }
		  $this->pdf->SetLeftMargin(15);
		  $this->pdf->SetLeftMargin(15);
		  $this->pdf->ln();
	    }
	  }
      //SAIDA DO PDF
	  $outputBolDir = $this->bandIniFile->getOutPutBolDir();
	  $arq = $outputBolDir . $dtInicio->GetcDataYYYYHMMHDD() . '_' . $dtTermino->GetcDataYYYYHMMHDD() . '_indice_por_assunto.pdf';
	  $this->pdf->Output($arq, "F");
      return ($arq);	
	}
//
  }
?>
