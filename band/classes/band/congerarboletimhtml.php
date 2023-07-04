<?
  class ConGerarBoletimHTML extends ConGerarBoletim
  { private $arquivoTexto;
    public function ConGerarBoletimHTML($rgrOM, $rgrOMVinc, $rgrSubun, $rgrParteBoletim, $rgrSecaoParteBi, $rgrAssuntoGeral, $rgrAssuntoEspec,
      $rgrBoletim, $rgrAssinaConfereBi, $rgrMilitar, $rgrFuncao, $rgrPGrad, $rgrTipoBol, $rgrMateriaBi, 
	  $rgrPessoaMateriaBi, $rgrPessoa, $bandIniFile)
    {
      ConGerarBoletim::ConGerarBoletim($rgrOM, $rgrOMVinc, $rgrSubun, $rgrParteBoletim, $rgrSecaoParteBi,
	    $rgrAssuntoGeral, 
	    $rgrAssuntoEspec, $rgrBoletim, $rgrAssinaConfereBi, $rgrMilitar, $rgrFuncao, $rgrPGrad, 
		$rgrTipoBol, $rgrMateriaBi, $rgrPessoaMateriaBi, $rgrPessoa, $bandIniFile);
	}
    public function PDFPrepara($fpdfFontDir, $ultPag, $tipoBol, $boletim, $pGradAssina, $militarAssina, $funcaoAssina,
	  $outputBolDir, $OM)
    { //cria o arquivo fisico
      $this->arquivoTexto = new ArquivoTexto($outputBolDir . $boletim->getDataPub()->getIAno() . "_" . 
				  	    $boletim->getNumeroBi() . '_' . ereg_replace(' ','_',$tipoBol->getDescricao()) . ".html");
	  $this->arquivoTexto->Open('w');
	}
	public function PDFImpTipoNumeroDescrBI($tipoBol, $boletim)
	{ 
	  $this->arquivoTexto->incluirTexto('<DIV ALIGN=CENTER>');
	  $this->arquivoTexto->incluirTexto('<HR ALIGN=CENTER SIZE=2 WIDTH=100%>');
	  $this->arquivoTexto->incluirTexto('<FONT FACE=TIMES SIZE=3><B>');
	  $this->arquivoTexto->incluirTexto($tipoBol->getDescricao() . ' Nº ' . $boletim->getNumeroBi() . '/' .
	  									 $boletim->getDataPub()->getIAno());
	  $this->arquivoTexto->incluirTexto('</B></FONT><BR>');
	  $this->arquivoTexto->incluirTexto('<HR ALIGN=CENTER SIZE=2 WIDTH=100%>');
	  $this->arquivoTexto->incluirTexto('<FONT FACE=TIMES SIZE=3><B>');
	  $this->arquivoTexto->incluirTexto('Para conhecimento deste aquartelamento e devida execução, publico o seguinte:');
	  $this->arquivoTexto->incluirTexto('</B></FONT><BR></DIV><BR>');
	}
    public function PDFImprimeDescricaoParte($parteBi)
    { 
	  $this->arquivoTexto->incluirTexto('<DIV ALIGN=CENTER>');
	  $this->arquivoTexto->incluirTexto('<FONT FACE=TIMES SIZE=3><B>');
	  $this->arquivoTexto->incluirTexto($parteBi->getDescrReduz());
	  $this->arquivoTexto->incluirTexto('</B></FONT><BR>');
	  $this->arquivoTexto->incluirTexto('<FONT FACE=TIMES SIZE=3><B>');
	  $this->arquivoTexto->incluirTexto($parteBi->getDescricao());
	  $this->arquivoTexto->incluirTexto('</B></FONT><BR></DIV><BR>');
    }
//    public function PDFImprimeDescricaoSecao($secaoParteBi, $aLetras)
    public function PDFImprimeDescricaoSecao($secaoParteBi, $numSec)
    { 
	  $this->arquivoTexto->incluirTexto('<DIV ALIGN=CENTER>');
	  $this->arquivoTexto->incluirTexto('<FONT FACE=TIMES SIZE=3><B>');
//	  $this->arquivoTexto->incluirTexto($aLetras[$numSec] . '. '.$secaoParteBi->getDescricao());
	  $this->arquivoTexto->incluirTexto($numSec . '. '.$secaoParteBi->getDescricao());
	  $this->arquivoTexto->incluirTexto('</B></FONT><BR></DIV><BR>');
    }
//    public function PDFImprimeAssuntoGeral($ctAssuntoGeral, $assuntoGeral2)
    public function PDFImprimeAssuntoGeral($letra, $assuntoGeral2)
    { 
	  $this->arquivoTexto->incluirTexto('<DIV ALIGN=LEFT>');
	  $this->arquivoTexto->incluirTexto('<FONT FACE=TIMES SIZE=3>');
//	  $this->arquivoTexto->incluirTexto($this->ctAssuntoGeral .'. '. $assuntoGeral2->getDescricao());
	  $this->arquivoTexto->incluirTexto($letra .'. '. $assuntoGeral2->getDescricao());
	  $this->arquivoTexto->incluirTexto('</FONT><BR></DIV><BR>');
    }
    public function PDFImprimeSemAlteracao($qteSec)
    { 
	  $this->arquivoTexto->incluirTexto('<DIV ALIGN=CENTER>');
	  $this->arquivoTexto->incluirTexto('<FONT FACE=TIMES SIZE=3>');
	  $this->arquivoTexto->incluirTexto('Sem Alteração');
	  $this->arquivoTexto->incluirTexto('</FONT></DIV><BR>');
    }
//    public function PDFImprimeAssuntoEspec($aLetras, $assuntoEspec2, $ctAssuntoEspec)
    public function PDFImprimeAssuntoEspec($assuntoEspec2, $ctAssuntoEspec)
    { 
	  $this->arquivoTexto->incluirTexto('<DIV ALIGN=LEFT>');
	  $this->arquivoTexto->incluirTexto('<FONT FACE=TIMES SIZE=3>');
//	  $this->arquivoTexto->incluirTexto($aLetras[$ctAssuntoEspec] .') '. $assuntoEspec2->getDescricao());
	  $this->arquivoTexto->incluirTexto($ctAssuntoEspec .') '. $assuntoEspec2->getDescricao());
	  $this->arquivoTexto->incluirTexto('</FONT></DIV><BR>');
    }
    public function PDFImprimeTextoAbertura($materiaBi, $ctMat)
    {
	  if (trim($materiaBi->getTextoAbert()) <> '')
      { 
	    $this->arquivoTexto->incluirTexto('<DIV WIDTH=100% ALIGN=JUSTIFY>');
	    $this->arquivoTexto->incluirTexto('<FONT FACE=TIMES SIZE=3>');
	    $this->arquivoTexto->incluirTexto('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $ctMat . ') '. 
											rtrim($materiaBi->getTextoAbert()));
	    $this->arquivoTexto->incluirTexto('</FONT></DIV><BR>');
	  }
	}
    public function PDFImprimeTextoFech($materiaBi)
    { 
	    $this->arquivoTexto->incluirTexto('<DIV WIDTH=100%>');
	    $this->arquivoTexto->incluirTexto('<FONT FACE=TIMES SIZE=3>');
    	if (trim($materiaBi->getTextoFech()) <> '')
	    { 
	    	$this->arquivoTexto->incluirTexto('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.rtrim($materiaBi->getTextoFech()));
	    }
	    $this->arquivoTexto->incluirTexto('</FONT></DIV><BR>');
    }
    public function PDFImprimeRef($materiaBi,$subun)
    {
    }
    public function PDFImprimeTextoIndiv($pessoaMateriaBi)
    { 
	    $this->arquivoTexto->incluirTexto('<DIV WIDTH=100% ALIGN=JUSTIFY>');
	    $this->arquivoTexto->incluirTexto('<FONT FACE=TIMES SIZE=3>');
	    $this->arquivoTexto->incluirTexto('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . 
											rtrim($pessoaMateriaBi->getTextoIndiv()));
	    $this->arquivoTexto->incluirTexto('</FONT></DIV><BR>');
    }
    public function PDFGetUltPagBi($ultPag)
    { //retorna o numero da ultima pagina
	  return 1;
    }
    public function PDFAvancaLinha($n)
    { for ($i = 0 ; $i < $n; $i++)
      { $this->arquivoTexto->incluirTexto('<BR>');
      }
    }
    public function PDFGravarOutput($outputBolDir, $boletim, $tipoBol, $original)
    { $this->arquivoTexto->Close();
	  //abre o arquivo no browser
      $this->arquivoTexto->lerArquivo();
  	}
  	public function PDFImprimePGrad($pGrad)
  	{ 
	    $this->arquivoTexto->incluirTexto('<FONT FACE=TIMES SIZE=3>');
	    $this->arquivoTexto->incluirTexto('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . 
											$pGrad->getDescricao() . '&nbsp;');
	    $this->arquivoTexto->incluirTexto('</FONT>');
    }
    public function PDFImprimeNomeCivil($pessoa)
    { 
	    $this->arquivoTexto->incluirTexto('<FONT FACE=TIMES SIZE=3>');
	    $this->arquivoTexto->incluirTexto($pessoa->getNome());
		$this->arquivoTexto->incluirTexto('</FONT><BR>');
    }
    public function PDFAlteraMargemEsq($margemEsqDoc)
    { 
    }    
	//Incluído $boletim, para remover a imagem de assinatura caso não tenha sido assinado o BI - Sgt Bedin
    public function PDFImprimirCampoAssinatura($pGradAssina, $militarAssina, $funcaoAssina, $original, $boletim)
    { 
	//Alterado $linha='_' para $linha=' '; devido alteração na legislação - Sgt Bedin 23/04/2013
	$linha = ' ';
      if (($pGradAssina->getCodigo == 1) or ($pGradAssina->getCodigo == 2) or ($pGradAssina->getCodigo == 3))
      { $texto = $pGradAssina->getDescricao() . ' ' . $militarAssina->getNome();
      }
      else
      { $texto = $militarAssina->getNome() . ' - ' . $pGradAssina->getDescricao();
      }
	  while (round(strlen($linha)) < round(strlen($texto))+4)
	  //Alterado $linha.'_' para $linha.' '; devido alteração na legislação - Sgt Bedin 23/04/2013
	  { $linha = $linha.' ';
	  }
	    $this->arquivoTexto->incluirTexto('<BR><BR><BR>');
        //1-imprimir linha centralizada para assinatura - Removido devido determinação da Legislação - Sgt Bedin 24/04/2013
	  /*  $this->arquivoTexto->incluirTexto('<DIV ALIGN=CENTER>');
	    $this->arquivoTexto->incluirTexto('<FONT FACE=TIMES SIZE=3><B>');
	    $this->arquivoTexto->incluirTexto($linha);
	    $this->arquivoTexto->incluirTexto('<BR>');*/

        //2-imprimir posto/nome da autoridade que assina
	    $this->arquivoTexto->incluirTexto($texto);
	    $this->arquivoTexto->incluirTexto('</B></FONT><BR>');
        //3-imprimir funcao da autoridade que assina
	    $this->arquivoTexto->incluirTexto('<FONT FACE=TIMES SIZE=3>');
	    $this->arquivoTexto->incluirTexto($funcaoAssina->getDescricao());
	    $this->arquivoTexto->incluirTexto('</FONT></DIV>');
    }
    public function PDFImprimirCampoConfere($pGradConfere, $militarConfere, $funcaoConfere)
    { 
	//Alterado $linha='_' para $linha=' '; devido alteração na legislação - Sgt Bedin 23/04/2013
	$linha = ' ';
/*	  $this->pdf->ln();
	  $this->pdf->ln();
	  //se a posicao vertical esta proximo do final, imprime linhas em branco ate quebrar a pagina
	  while ($this->pdf->GetY() > 250){
		$this->pdf->Cell(180,4,'',0,1,'C');
	  }*/
	  
	    $this->arquivoTexto->incluirTexto('<BR><BR>');
        //confere com o original
	    $this->arquivoTexto->incluirTexto('<DIV ALIGN=LEFT>');
	    $this->arquivoTexto->incluirTexto('<FONT FACE=TIMES SIZE=3>');
	    $this->arquivoTexto->incluirTexto('CONFERE COM O ORIGINAL:');
	    $this->arquivoTexto->incluirTexto('</B></FONT>');
	    $this->arquivoTexto->incluirTexto('<BR><BR><BR><BR>');

      if (($pGradConfere->getCodigo == 1) or ($pGradConfere->getCodigo == 2) or ($pGradConfere->getCodigo == 3))
      { $texto = $pGradConfere->getDescricao() . ' ' . $militarConfere->getNome();
      }
      else
      { $texto = $militarConfere->getNome() . ' - ' . $pGradConfere->getDescricao();
      }
	  while (round(strlen($linha)) < round(strlen($texto))+7)
	  { 
	  //Alterado $linha='_' para $linha=' '; devido alteração na legislação - Sgt Bedin 23/04/2013
	  $linha = $linha.' ';
	  }
	  $funcaoFormat = $funcaoConfere->getDescricao();
	  while (round(strlen($funcaoFormat)) < (round(strlen($texto)))+6)
	  { $funcaoFormat = chr(160).$funcaoFormat;
	  }

        //imprimir linha alinhada a esquerda para assinatura do confere - Removido devido determinação da Legislação - Sgt Bedin 24/04/2013
	   /* $this->arquivoTexto->incluirTexto('<FONT FACE=TIMES SIZE=3><B>');
	    $this->arquivoTexto->incluirTexto($linha);
	    $this->arquivoTexto->incluirTexto('<BR>');
*/
        //imprimir posto/nome da autoridade que assina o confere
	    $this->arquivoTexto->incluirTexto($texto);
	    $this->arquivoTexto->incluirTexto('</B></FONT><BR>');
        //imprimir funcao da autoridade que assina o confere
	    $this->arquivoTexto->incluirTexto('<FONT FACE=TIMES SIZE=3>');
	    $this->arquivoTexto->incluirTexto($funcaoFormat);
	    $this->arquivoTexto->incluirTexto('</FONT></DIV>');
    }
    public function PDFImprimirCabecalho($OM, $boletim, $img, $brasaoDir)
    { $aDia = array('Sunday' => 'Domingo','Monday' => 'Segunda-feira', 'Tuesday' => 'Terça-feira',
	  				 'Wednesday' => 'Quarta-feira', 'Thursday' => 'Quinta-feira', 'Friday' => 'Sexta-feira',
	  				 'Saturday' => 'Sábado');
	  $aDia = $aDia[date('l',strtotime($boletim->getDataPub()->GetcDataMMBDDBYYYY()))];	
	  //imprime a imagem do brasão das armas
//	  $this->arquivoTexto->incluirTexto($brasaoDir);
	  if (file_exists($brasaoDir.'brasao.jpg')) {
	    $this->arquivoTexto->incluirTexto('<TABLE WIDTH=100%><TR><TD ALIGN=CENTER><IMG ALIGN=MIDDLE SRC="' .
										 $img . '" WIDTH="85" HEIGHT="90"></TD></TR></TABLE>');
      }
	    $this->arquivoTexto->incluirTexto('<DIV ALIGN=CENTER>');
	    $this->arquivoTexto->incluirTexto('<FONT FACE=TIMES SIZE=2><B>');
	    $this->arquivoTexto->incluirTexto(strtoupper($OM->getSubd1()));
	    $this->arquivoTexto->incluirTexto('</B></FONT><BR>');
	    $this->arquivoTexto->incluirTexto('<FONT FACE=TIMES SIZE=2><B>');
	    $this->arquivoTexto->incluirTexto(strtoupper($OM->getSubd2()));
	    $this->arquivoTexto->incluirTexto('</B></FONT><BR>');
	    if ($OM->getSubd3() <> ''){
		    $this->arquivoTexto->incluirTexto('<FONT FACE=TIMES SIZE=2><B>');
	    	$this->arquivoTexto->incluirTexto(strtoupper($OM->getSubd3()));
		    $this->arquivoTexto->incluirTexto('</B></FONT><BR>');
	    }
            $this->arquivoTexto->incluirTexto('<FONT FACE=TIMES SIZE=2><B>');
	    $this->arquivoTexto->incluirTexto(strtoupper($OM->getNome()));
	    $this->arquivoTexto->incluirTexto('</B></FONT><BR>');
	    if ($OM->getDesigHist() <> ''){
	    $this->arquivoTexto->incluirTexto('<FONT FACE=TIMES SIZE=2><B>');
	    $this->arquivoTexto->incluirTexto(strtoupper($OM->getDesigHist()));
	    $this->arquivoTexto->incluirTexto('</B></FONT><BR>');
	    }
            if ($OM->getSubd4() <> ''){
		$this->arquivoTexto->incluirTexto('<FONT FACE=TIMES SIZE=2><B>');
                $this->arquivoTexto->incluirTexto(strtoupper($OM->getSubd4()));
                $this->arquivoTexto->incluirTexto('</B></FONT><BR>');
	    }
            $this->arquivoTexto->incluirTexto('<BR><FONT FACE=TIMES SIZE=3>');
	    $this->arquivoTexto->incluirTexto('Quartel em ' . $OM->getLoc() . ', ' . $boletim->getDataPub()->getIDia() .
										  ' de ' . $boletim->getDataPub()->getNomeMes() . ' de ' .
										  $boletim->getDataPub()->getIAno());
	    $this->arquivoTexto->incluirTexto('</FONT><BR>');
	    $this->arquivoTexto->incluirTexto('<FONT FACE=TIMES SIZE=3>');
	    $this->arquivoTexto->incluirTexto('('.$aDia.')');
	    $this->arquivoTexto->incluirTexto('</FONT><BR></DIV>');
    } 
  	public function PDFImprimeNome($nome,$nomeGuerra)
    { 
	    $this->arquivoTexto->incluirTexto('<FONT FACE=TIMES SIZE=3>');
	    $this->arquivoTexto->incluirTexto($nome);
	    $this->arquivoTexto->incluirTexto('</FONT><BR>');
    }
    public function PDFImprimeMilitaresAgrupados($saida)
    { 
	    $this->arquivoTexto->incluirTexto($saida);
    }
    
  }
?>
