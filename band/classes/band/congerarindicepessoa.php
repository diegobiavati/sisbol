<?php
  class ConGerarIndicePessoa
  { private $rgrIndicePessoa;
    private $rgrOM;
    private $pdf;
    private $bandIniFile;
    public function ConGerarIndicePessoa($rgrIndicePessoa,$rgrOM, $bandIniFile)
    { $this->rgrIndicePessoa = $rgrIndicePessoa;
      $this->rgrOM = $rgrOM;
      $this->bandIniFile = $bandIniFile;
    }
    public function formataNumBi($numBi){
		while (strlen($numBi) < 3){
			$numBi = 0 . $numBi;
		}    	
		return $numBi;
    }
    public function gerarIndicePessoa($codTipoBol, $dtInicio, $dtTermino)
    { $colIndicePessoa2 = $this->rgrIndicePessoa->lerColecao($codTipoBol, $dtInicio, $dtTermino);
      //ler o primeiro objeto
      $indicePessoa = $colIndicePessoa2->iniciaBusca1();
      if($indicePessoa == null) return 'error';	
      //captura as informações da OM
      $OM = $this->rgrOM->lerRegistro();

      //PREPARA PARA GERAR O PDF
	  $fpdfFontDir = $this->bandIniFile->getFPDFFontDir();

      define("FPDF_FONTPATH",$fpdfFontDir);
	  $this->pdf = new MeuPDFInd('P','mm','A4',$indicePessoa->getBoletim()->getTipoBol()->getAbreviatura(),$dtInicio,$dtTermino); 
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
	  $this->pdf->Cell(180,4,'ÍNDICE REMISSIVO DOS ' . $indicePessoa->getBoletim()->getTipoBol()->getAbreviatura() .  ' de ' . 
			    $dtInicio->GetcDataDDBMMBYYYY() . ' a ' . $dtTermino->GetcDataDDBMMBYYYY(),0,1,'C'); 
	  $this->pdf->ln();
	  $this->pdf->ln();
	
	  //percorre toda a colecao
	  while ($indicePessoa != null) 
	  { $pGrad = $indicePessoa->getPessoaMateriaBi()->getPessoa()->getPGrad();
	    $this->pdf->SetLeftMargin(15);
		$this->pdf->SetFont('Times','B',16);
		$this->pdf->Cell(180,4,$pGrad->getDescricao(),0,1,'L');
		$this->pdf->ln();
	    //percorre pela mesma letra
  	    while (($indicePessoa != null) 
        and ($pGrad->getCodigo() == $indicePessoa->getPessoaMateriaBi()->getPessoa()->getPGrad()->getCodigo()))
        {
          $militar = $indicePessoa->getPessoaMateriaBi()->getPessoa();
		  $this->pdf->SetLeftMargin(15);
		  $this->pdf->SetFont('Times','B',12);
          $this->pdf->ln();
          $this->pdf->Cell(round($this->pdf->GetStringWidth(chr(187).' ')+1),4,chr(187).' ',0,0,'L');
          $this->pdf->Cell(round($this->pdf->GetStringWidth($militar->getNome())+1),4,$militar->getNome(),0,1,'L');
          //percorre por militar
          while (($indicePessoa != null) 
          and ($pGrad->getCodigo() == $indicePessoa->getPessoaMateriaBi()->getPessoa()->getPGrad()->getCodigo())
		  and ($militar->getIdMilitar() == $indicePessoa->getPessoaMateriaBi()->getPessoa()->getIdMilitar()))
	      { $descrAssGer = $indicePessoa->getMateriaBi()->getAssuntoGeral()->getDescricao();
            $this->pdf->SetFont('Times','B',12);
            $this->pdf->ln();
            $this->pdf->MultiCell(180,4,'   - '.$descrAssGer,0,'L',0);
	        //percorre por assunto geral
            while (($indicePessoa != null) 
            and ($pGrad->getCodigo() == $indicePessoa->getPessoaMateriaBi()->getPessoa()->getPGrad()->getCodigo())
	        and ($militar->getIdMilitar() == $indicePessoa->getPessoaMateriaBi()->getPessoa()->getIdMilitar())
			and ($descrAssGer == $indicePessoa->getMateriaBi()->getAssuntoGeral()->getDescricao()))
	        { $descrAssEsp = $indicePessoa->getMateriaBi()->getAssuntoEspec()->getDescricao();
              $this->pdf->SetFont('Times','',12);
//              $this->pdf->MultiCell(180,4,'     - '.$descrAssEsp,0,'J',0);
	          $this->pdf->ln();
	          $this->pdf->Cell(round($this->pdf->GetStringWidth('     - ')+1),4,'     - ',0,0,'L');
//              $this->pdf->MultiCell(round($this->pdf->GetStringWidth($descrAssEsp)+1),4,round($this->pdf->GetStringWidth($descrAssEsp)+1).$descrAssEsp,'B','L',0);
			  if (round($this->pdf->GetStringWidth($descrAssEsp)+3)<175){
	              $this->pdf->MultiCell(round($this->pdf->GetStringWidth($descrAssEsp)+3),4,$descrAssEsp,'B','J',0);
	          }else{
	              $this->pdf->MultiCell(175,4,$descrAssEsp,'B','J',0);
	          }
	          //percorre por assunto especifico
              while (($indicePessoa != null) 
              and ($pGrad->getCodigo() == $indicePessoa->getPessoaMateriaBi()->getPessoa()->getPGrad()->getCodigo())
	          and ($militar->getIdMilitar() == $indicePessoa->getPessoaMateriaBi()->getPessoa()->getIdMilitar())
	          and ($descrAssGer == $indicePessoa->getMateriaBi()->getAssuntoGeral()->getDescricao())
			  and ($descrAssEsp == $indicePessoa->getMateriaBi()->getAssuntoEspec()->getDescricao()))
              { $this->pdf->SetFont('Times','',12);
    		    $this->pdf->Cell(180,4,'        '.$indicePessoa->getBoletim()->getTipoBol()->getAbreviatura() . ' Nº ' . 
			    $indicePessoa->getBoletim()->getNumeroBi() . ' de '. 
			    $indicePessoa->getBoletim()->getDataPub()->GetcDataDDBMMBYYYY() . ' pag. '. 
		  	    $indicePessoa->getMateriaBi()->getPagina() . " - Nota: " . $indicePessoa->getMateriaBi()->getCodigo() . " - Usuário: " . $indicePessoa->getMateriaBi()->getUsuario(),0,1,'L',0,

				$indicePessoa->getBoletim()->getDataPub()->getcDataYYYYHMMHDD() . '_O_' .
					$this->formataNumBi($indicePessoa->getBoletim()->getNumeroBi()). '_' . 
				str_replace(' ','_',strtolower($indicePessoa->getBoletim()->getTipoBol()->getDescricao())) . '.pdf');
                $indicePessoa = $colIndicePessoa2->getProximo1();
              }
            }
     	  }
		  $this->pdf->SetLeftMargin(15);
		  $this->pdf->ln();
	    }
	  }
      //SAIDA DO PDF
	  $outputBolDir = $this->bandIniFile->getOutPutBolDir();
      $arq = $outputBolDir . $dtInicio->GetcDataYYYYHMMHDD() . '_' . $dtTermino->GetcDataYYYYHMMHDD() . '_indice_por_pessoa.pdf' ;
	  $this->pdf->Output($arq, "F");
	  return ($arq);	
    }
//
  }
?>
