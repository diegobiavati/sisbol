<?
  class ConGerarBoletimPDFHTML extends ConGerarBoletim
  { private $rgrOM;
    private $rgrOMVinc;
    private $rgrSubun;
    private $rgrParteBoletim;
    private $rgrSecaoParteBi;
    private $rgrAssuntoGeral;
    private $rgrAssuntoEspec;
    private $rgrBoletim;
    private $rgrAssinaConfereBi;
    private $rgrMilitar;
    private $rgrFuncao;
    private $rgrPGrad;
	//Bedin
	private $rgrQM;
	//
    private $rgrTipoBol;
    private $rgrMateriaBi;
    private $rgrPessoaMateriaBi;
    private $bandIniFile;
    private $aLetras;
    private $pdf;
    private $materiaBi;
    private $assuntoGeral;
    private $assuntoEspec;
    private $colMateriaBi2;
    private $rgrPessoa;
    private $ctAssuntogeral;
    private $ctAssuntoEspec;
    private $nomeFonte;
    private $tamFonte;
    private $margemEsqDoc;
    private $ultPag;
    private $boletim;


    public function ConGerarBoletimPDFHTML($rgrOM, $rgrOMVinc, $rgrSubun, $rgrParteBoletim, $rgrSecaoParteBi, $rgrAssuntoGeral, $rgrAssuntoEspec,
      //Bedin
	  $rgrBoletim, $rgrAssinaConfereBi, $rgrMilitar, $rgrFuncao, $rgrPGrad, $rgrQM, $rgrTipoBol, $rgrMateriaBi, 
	  //
	  $rgrPessoaMateriaBi, $rgrPessoa, $bandIniFile)
    { 
      ConGerarBoletim::ConGerarBoletim($rgrOM, $rgrOMVinc, $rgrSubun, $rgrParteBoletim, $rgrSecaoParteBi,
	    $rgrAssuntoGeral, 
//Bedin	   
	   $rgrAssuntoEspec, $rgrBoletim, $rgrAssinaConfereBi, $rgrMilitar, $rgrFuncao, $rgrPGrad, $rgrQM,
	   //
		$rgrTipoBol, $rgrMateriaBi, $rgrPessoaMateriaBi, $rgrPessoa, $bandIniFile);
      
	  $this->aLetras = array(1 => 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l' , 'm', 'n', 'o', 
              'p', 'q','r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'aa', 'ab', 'ac', 'ad', 'ae', 'af', 'ag', 'ah',
              'ai', 'aj', 'ak', 'al', 'am', 'an', 'ao', 'ap', 'aq', 'ar', 'as', 'at', 'au', 'av', 'aw', 'ax', 'ay',
              'az', 'ba', 'bb', 'bc', 'bd', 'be', 'bf', 'bg', 'bh', 'bi', 'bj', 'bk', 'bl', 'bm', 'bn', 'bo', 'bp',
              'bq', 'br', 'bs', 'bt', 'bu', 'bv', 'bw', 'bx', 'by', 'bz');
	  $this->tamFonte = 12;
	  $this->nomeFonte = 'Times';
	  $this->margemEsqDoc = 15;
      $this->bandIniFile = $bandIniFile;
	  

	}
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    // Objetivo: Obter o ultimo numero da pagina do ultimo boletim, para iniciar a contagem do novo boletim
    //
    // Parametros de Entrada:
	//
	// $boletim: boletim atual
	// $tipoBol: tipo do boletim
	//
	// retorna: o numero da ultima pagina
	//
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function formataNumBi($numBi){
		while (strlen($numBi) < 3){
			$numBi = 0 . $numBi;
		}    	
		return $numBi;
    }
//rev 06 - Renato
/*    private function obterUltPag($boletim, $tipoBol)
    { //obter o numero do bi anterior
      $numeroBiAnt = $boletim->getNumeroBi() - 1;
      //se nao e o primeiro bi do ano
      if ($numeroBiAnt != 0)
      { //le o bi anterior
	    $BoletimAnt = $this->rgrBoletim->lerPorNumeroBi($boletim->getTipoBol()->getCodigo(),$numeroBiAnt);
	    //se existe anterior
        if ($BoletimAnt != null)
        { $ultPag = $BoletimAnt->getPagFinal();
        }
        //nao existe boletim anterior
        else
        { $ultPag = $tipoBol->getNrUltPag();
        }
      }
      else
      { // se e o nro do bi ant = 0, o primeiro boletim
	    $ultPag = 0;
      }
      return $ultPag;
    }*/
    public function PDFImprimeNome($nome,$nomeGuerra)
    { 
		//rev 06
//		$nome=($nome);
		$this->pdf->SetLeftMargin(16.4);
		//$nome = strtoupper($nome);
	  	$nome = strtr($nome,'áéíóúãõâêôçäëïöü','ÁÉÍÓÚÃÕÂÊÔÇÄËÏÖÜ');
		$nomeGuerra= strtoupper($nomeGuerra);
	  	$nomeGuerra = strtr($nomeGuerra,'áéíóúãõâêôçäëïöü','ÁÉÍÓÚÃÕÂÊÔÇÄËÏÖÜ');
		$c1 = explode(" ",$nome);
		$c2 = explode(" ",$nomeGuerra);
		$pri = 0;

	    if ($c2 != 0){
		  for ($i = 0; $i < count($c1); $i++) {		//percorre todas as palavras do nome
			for ($j = 0; $j < count($c2); $j++){			//percorre todas as palavras do nome de guerra
				//verifica se a palavra do nome é igual a palavra do nome de guerra
				//ou se a letra inicial do nome é igual a palavra do nome de guerra
				if ( ($c1[$i] == $c2[$j]) or ( substr($c1[$i],0,1) == $c2[$j] and $pri==0) ) {
					if (strlen($c2[$j]) == 1){
						//coloca apenas a letra inicial da palavra em negrito
						$this->pdf->SetFont($this->nomeFonte,'B',$this->tamFonte);
//				        $this->pdf->Cell(round($this->pdf->GetStringWidth(substr($c1[$i],0,1))),5,substr($c1[$i],0,1),0,0,'L');
				        $this->pdf->Write(5,substr($c1[$i],0,1));
                                        //$this->pdf->WriteHTML(substr($c1[$i],0,1));
				        $this->pdf->SetFont($this->nomeFonte,'',$this->tamFonte);
//						$this->pdf->Cell((round($this->pdf->GetStringWidth($c1[$i]))-
//										  round($this->pdf->GetStringWidth(substr($c1[$i],0,1))))+1,5,
//										  substr($c1[$i],1,round($this->pdf->GetStringWidth($c1[$i]))),0,0,'L');
						$this->pdf->Write(5,substr($c1[$i],1,round($this->pdf->GetStringWidth($c1[$i]))).' ');
//                                                $this->pdf->WriteHTML(substr($c1[$i],1,round($this->pdf->GetStringWidth($c1[$i]))).' ');
						$pri=1;
						break;//sai do for (palavras do nome de guerra)
					}else {
						//coloca a palavra em negrito
				        $this->pdf->SetFont($this->nomeFonte,'B',$this->tamFonte);
//				        $this->pdf->Cell(round($this->pdf->GetStringWidth($c1[$i])),5,$c1[$i],0,0,'L');
				        $this->pdf->Write(5,$c1[$i].' ');
                                        //$this->pdf->WriteHTML($c1[$i].'x ');
						break;//sai do for (palavras do nome de guerra)
					}
				} else {
					//verifica se é a última palavra do for (palavras do nome de guerra)
					if ($c2[$j+1]==''){
				        $this->pdf->SetFont($this->nomeFonte,'',$this->tamFonte);
//				        $this->pdf->Cell(round($this->pdf->GetStringWidth($c1[$i])),5,$c1[$i],0,0,'L');
				        $this->pdf->Write(5,$c1[$i].' ');
//                                        $this->pdf->WriteHTML($c1[$i].' ');
					}
				}
		        $this->pdf->SetFont($this->nomeFonte,'',$this->tamFonte);
//		        $this->pdf->Cell(1,5,' ',0,0,'L');
//		        $this->pdf->Write(5,' ');
			}
		  }
		}else{
//		   $this->pdf->Cell(100,5,strtoupper($nome),0,0,'L');
		   $this->pdf->Cell(5,$nome);
	    }
        $this->pdf->SetFont($this->nomeFonte,'',$this->tamFonte);
    }		
    
    
    public function PDFPrepara($fpdfFontDir, $ultPag, $tipoBol, $boletim, $pGradAssina, $militarAssina, $funcaoAssina,
	  $outputBolDir, $OM)
    { 
      define("FPDF_FONTPATH", $fpdfFontDir);
//	  $this->pdf = new MeuPDF('P','mm','A4', $ultPag, $tipoBol, $boletim, $pGradAssina, $militarAssina, 
//	  							$funcaoAssina); 
  	  $this->pdf = new meuhtml2fpdf('P','mm','a4', $ultPag, $tipoBol, $boletim, $pGradAssina, $militarAssina, 
	  							$funcaoAssina, $OM); 		  							
	  $this->pdf->SetMargins($this->margemEsqDoc,20,15);
	  $this->pdf->SetAutoPageBreak(true,17);
	  $this->pdf->AddPage();
	}
	public function PDFImpTipoNumeroDescrBI($tipoBol, $boletim)
	{ $this->pdf->SetFont('Times','B',12);
	  if ($tipoBol->getImp_bordas() == 'S'){
	      $this->pdf->SetFillColor(180,180,180);
	      $this->pdf->Cell(181,6,$tipoBol->getDescricao().' Nº '.$boletim->getNumeroBi().'/' 
		  						 .$boletim->getDataPub()->getIAno().' '.$boletim->getBiRef(),1,1,'C',1);
	      $this->pdf->SetFillColor(255,255,255);
	  }else
      	$this->pdf->Cell(181,6,$tipoBol->getDescricao().' Nº '.$boletim->getNumeroBi().'/' 
	  						 .$boletim->getDataPub()->getIAno().' '.$boletim->getBiRef(),"TB",1,'C');
      $this->pdf->SetLineWidth(0.2);
	  $this->pdf->ln(4);
//      $this->pdf->Cell(180,4,'Para conhecimento deste aquartelamento e devida execução, publico o seguinte:',0,0,'C');
      $this->pdf->MultiCell(179,4,$tipoBol->getTitulo2(),0,'C',0);
//	  $this->pdf->MultiCell(178,4,rtrim($pessoaMateriaBi->getTextoIndiv()),0,'J',0);
	  $this->pdf->ln();
      $this->pdf->ln();
	}
    public function PDFImprimeDescricaoParte($parteBi)
    { 
//      $this->pdf->ln();
	  $this->pdf->SetFont('Times','B',12);
	  $this->pdf->Cell(180,4,$parteBi->getDescrReduz(),0,0,'C');
      $this->pdf->ln();
      $descrParte = strtoupper(strtr($parteBi->getDescricao(),'áéíóúãõâêôçäëïöü','ÁÉÍÓÚÃÕÂÊÔÇÄËÏÖÜ'));      
//	  $this->pdf->Cell(180,4,$parteBi->getDescricao(),1,0,'C');
	  $this->pdf->Cell(180,4,$descrParte,0,0,'C');
//      $this->pdf->ln();
	  $this->pdf->ln();
    }
//    public function PDFImprimeDescricaoSecao($secaoParteBi, $aLetras)
    public function PDFImprimeDescricaoSecao($secaoParteBi, $numSec)
    { $this->pdf->SetFont('Times','B',12);
//      $this->pdf->Cell(180,4,$aLetras[$numSec] . '. '.$secaoParteBi->getDescricao(),0,0,'C');
      $descrSec = strtoupper(strtr($secaoParteBi->getDescricao(),'áéíóúãõâêôçäëïöü','ÁÉÍÓÚÃÕÂÊÔÇÄËÏÖÜ'));      
//      $this->pdf->Cell(180,4,$numSec . '. '.$secaoParteBi->getDescricao(),0,0,'C');
	  //se houver mais de uma seção sempre sera com numero + o ponto, ex: 1.
	  //se for apenas uma seção ela será omitida
//      $this->pdf->Cell(180,4,$numSec . '. '.$descrSec,0,0,'L');
      $this->pdf->WriteHTML('<div style="text-align: justify;">'.$numSec . '. '.$descrSec.'</div>');
//      $this->pdf->ln();
    }
//    public function PDFImprimeAssuntoGeral($ctAssuntoGeral, $assuntoGeral2)
    public function PDFImprimeAssuntoGeral($caracterAssGer, $assuntoGeral2)
    { $this->pdf->SetFont('Times','',12);
//	  $this->pdf->MultiCell(180,4,$this->ctAssuntoGeral .'. '. $assuntoGeral2->getDescricao(),0,'J',0);
	  //se houver mais de uma ass ger sempre sera com letra/numero + o ponto, ex: 1. ou a.
	  //se for apenas um ass ger o caracter de identificação será omitido
	  if ($caracterAssGer!=' ')
//		  $this->pdf->MultiCell(180,4,$caracterAssGer . '. ' . $assuntoGeral2->getDescricao(),1,'J',0);
		  $this->pdf->WriteHTML('<div style="text-align: justify;">'.$caracterAssGer.'. '.$assuntoGeral2->getDescricao().'</div>');
	  else
//		  $this->pdf->MultiCell(180,4,$assuntoGeral2->getDescricao(),1,'J',0);
		  $this->pdf->WriteHTML('<div style="text-align: justify;">'.$assuntoGeral2->getDescricao().'</div>');
	  		
//      $this->pdf->ln();
    }
    public function PDFImprimeSemAlteracao($qteSec)
    {
      $this->pdf->ln();
        $this->pdf->SetFont('Times','',12);
        if ($qteSec==1)
            $this->pdf->Cell(180,4,'Sem Alteração',0,0,'C');
        else
            $this->pdf->Cell(180,4,'Sem Alteração',0,0,'L');
      $this->pdf->ln();
      //$this->pdf->ln();
    }
//    public function PDFImprimeAssuntoEspec($aLetras, $assuntoEspec2, $ctAssuntoEspec)
    public function PDFImprimeAssuntoEspec($assuntoEspec2, $caracterAssEsp)
    { 
	  $this->pdf->SetLeftMargin(15);
      $this->pdf->SetFont($this->nomeFonte,'',$this->tamFonte);
      $this->pdf->ln();
//	  if (is_int($caracterAssEsp))
//	  	$caracterAssEsp = $caracterAssEsp . ') ';
	  if ($caracterAssEsp!=' ')
//		  $this->pdf->MultiCell(180,4,$caracterAssEsp . $assuntoEspec2->getDescricao(),0,'L',0);
		  $this->pdf->WriteHTML('<div style="text-align: justify;">'.$caracterAssEsp.$assuntoEspec2->getDescricao().'</div>');
	  else
//		  $this->pdf->MultiCell(180,4,$caracterAssEsp . '   ' .$assuntoEspec2->getDescricao(),0,'L',0);
		  $this->pdf->WriteHTML('<div style="text-align: justify;">'.$assuntoEspec2->getDescricao().'</div>');
	  	
      //$this->pdf->ln();
    }
    public function PDFImprimeTextoAbertura($materiaBi, $ctMat)
    {
        $this->pdf->SetFont($this->nomeFonte,'',$this->tamFonte);
	if (trim($materiaBi->getTextoAbert()) <> '')
        { 	$this->pdf->SetLeftMargin(15);
        	$textoAbert = rtrim($materiaBi->getTextoAbert());
		$textoAbert = '<div style="text-align: justify;">'.$textoAbert.'</div>'; 
	        $this->pdf->ln();
                $this->pdf->WriteHTML($textoAbert);
		$this->pdf->SetLeftMargin(15);
	        //$this->pdf->ln();
        }
	//}else
	        //$this->pdf->ln();

    }
    public function PDFImprimeTextoFech($materiaBi)
    { $this->pdf->SetFont($this->nomeFonte,'',$this->tamFonte);
	  if ((trim($materiaBi->getTextoFech()) <> '')||(trim($materiaBi->getTextoFech()) <> '<br />'))
	  { 
		$textoFech = rtrim($materiaBi->getTextoFech()); 
		$textoFech = '<div style="text-align: justify;">'.$textoFech.'</div>'; 
		$this->pdf->SetLeftMargin(15);
//		$this->pdf->MultiCell(180,4,$textoFech,0,'J',0);
	    $this->pdf->WriteHTML($textoFech);

//        $this->pdf->ln();
	  }
	  $this->pdf->SetLeftMargin(15);
      $this->pdf->SetFont('Times','',12);
    }
    public function PDFImprimeRef($materiaBi,$siglaSubun)
    { $this->pdf->SetFont($this->nomeFonte,'',$this->tamFonte);

      if ($materiaBi->getData()->getIDia() == "1")
	$dia = "1º";
      else
  	$dia = $materiaBi->getData()->getIDia();
      
      $textoRef = '(Nota nº '.$materiaBi->getCodigo().', de '. $dia .  ' de ' .
			    $materiaBi->getData()->getNomeMes2() . ' de ' .
                            $materiaBi->getData()->getIAno() . ', da(o) ' . $siglaSubun . ')';
      
      $textoRef = '<div style="text-align: justify;">'.$textoRef.'</div>';
      $this->pdf->SetLeftMargin(15);
      $this->pdf->WriteHTML($textoRef);
      $this->pdf->SetLeftMargin(15);
      $this->pdf->SetFont('Times','',12);
    }

    public function PDFImprimeTextoIndiv($pessoaMateriaBi)
    {   $this->pdf->SetFont($this->nomeFonte,'',$this->tamFonte);
//	    $this->pdf->SetLeftMargin(1);
//		$this->pdf->MultiCell(178,4,rtrim($pessoaMateriaBi->getTextoIndiv()),1,'J',0);
		$textoIndiv = rtrim($pessoaMateriaBi->getTextoIndiv()); 
		$textoIndiv = '<div style="text-align: justify;">'.$textoIndiv.'</div>'; 
	    $this->pdf->WriteHTML($textoIndiv);
    }
    //retorna o numero da ultima pagina do bi atual, ou numero da pag corrente
    public function PDFGetUltPagBi($ultPag)
    { return $this->pdf->pageNo()+ $ultPag;
    }
    public function PDFAvancaLinha($n)
    { for ($i = 0 ; $i < $n; $i++)
      { $this->pdf->ln();
      }
    }
    public function PDFGravarOutput($outputBolDir, $boletim, $tipoBol, $original)
    { 	$original = $original=='S'?'O':'N';
//	  	$nomeGuerra = strtr($militar->getNomeGuerra(),'áéíóúãõâêôçäëïöüÁÉÍÓÚÃÕÂÊÔÄËÏÖÜ','aeiouaoaeocaeiouAEIOUAOAEOAEIOU');
    	$tipoBi = strtolower(strtr($tipoBol->getDescricao(),'áéíóúãõâêôçäëïöüÁÉÍÓÚÃÕÂÊÔÇÄËÏÖÜ','aeiouaoaeocaeiouAEIOUAOAEOCAEIOU'));
//		$tipoBi = ereg_replace('ª','',$tipoBi);
		$tipoBi = preg_replace('(ª)','',$tipoBi);
//		$tipoBi = ereg_replace('º','',$tipoBi);
		$tipoBi = preg_replace('(º)','',$tipoBi);
//		$arq = $outputBolDir. $boletim->getDataPub()->getcDataYYYYHMMHDD() . "_" . $original . "_" . 
//  	    	$this->formataNumBi($boletim->getNumeroBi()) . '_' . ereg_replace(' ','_',strtolower($tipoBol->getDescricao())) . ".pdf" ;
//  	    	$this->formataNumBi($boletim->getNumeroBi()) . '_' . ereg_replace(' ','_',$tipoBi) . ".pdf" ;
		$arq = $outputBolDir. $boletim->getDataPub()->getcDataYYYYHMMHDD() . "_" . $original . "_" . 
//  	    	$this->formataNumBi($boletim->getNumeroBi()) . '_' . ereg_replace(' ','_',strtolower($tipoBol->getDescricao())) . ".pdf" ;
  	    	$this->formataNumBi($boletim->getNumeroBi()) . '_' . preg_replace('( )','_',$tipoBi) . ".pdf" ;
		$this->pdf->Output($arq, "F");
  	    return $arq;
  	}
  	public function PDFImprimePGrad($pGrad)
  	{ 
	  $this->pdf->Cell(round($this->pdf->GetStringWidth($pGrad->getDescricao()))+3,4,' '.$pGrad->getDescricao(),0,0,'L');
//	  $this->pdf->WriteHTML('<div style="text-align: justify;">'.$pGrad->getDescricao().'</div>');
    }
    public function PDFImprimeNomeCivil($pessoa)
    { $this->pdf->Cell(176,4,$pessoa->getNome(),0,1,'L');
      $this->pdf->ln();
    }
    public function PDFAlteraMargemEsq($margemEsqDoc)
    { $this->pdf->SetLeftMargin($margemEsqDoc);
    }    
	//Incluído $boletim, para remover a imagem de assinatura caso não tenha sido assinado o BI - Sgt Bedin
    public function PDFImprimirCampoAssinatura($pGradAssina, $militarAssina, $funcaoAssina, $original, $boletim)
    { $linha = ' ';
      $nomeMilitar = strtoupper(strtr($militarAssina->getNome(),'áéíóúãõâêôçäëïöü','ÁÉÍÓÚÃÕÂÊÔÇÄËÏÖÜ'));      
      if (($pGradAssina->getCodigo() == 2) or ($pGradAssina->getCodigo() == 3) or ($pGradAssina->getCodigo() == 4)
	  			or ($pGradAssina->getCodigo() == 60))
      { $texto = $pGradAssina->getDescricao() . ' ' . $nomeMilitar;
      }
      else
      { $texto = $nomeMilitar . ' - ' . $pGradAssina->getDescricao();
      }
	  $this->pdf->ln();	
	  $this->pdf->ln();	

	  //se a posicao vertical esta proximo do final, imprime linhas em branco ate quebrar a pagina
	  while ($this->pdf->GetY() > 270){
		$this->pdf->Cell(180,4,'',0,1,'C');
	  }

      //1-imprimir linha centralizada para assinatura 
	//Váriavel com valor do campo assinado - Sgt Bedin  
	$assinado =  $boletim->getAssinado();
	
	  if ($original == 'S')
      {   

		  if ($_SESSION['IMPRIMEASSINATURA']=='S')
			//Condição para imprimir imagem caso esteja assinado o BI - Sgt Bedin
		  if ($assinado == 'S')
	  {
		  	  if ($militarAssina->getAssinatura()!=null){
	  		  	  $absissa = (204 - round($this->pdf->GetStringWidth($texto))+4)/2;
		    	  $this->pdf->Image($this->bandIniFile->getAssinaturaDir().$militarAssina->getAssinatura(),$absissa,$this->pdf->GetY(),round($this->pdf->GetStringWidth($texto))+4,17);
		  	  }
			  }
			  
		  
	    	  //1-imprimir linha centralizada para assinatura - Removido devido determinação da Legislação - Sgt Bedin 24/04/2013
			 /* while (round($this->pdf->GetStringWidth($linha)) < round($this->pdf->GetStringWidth($texto))+4)
			  { $linha = $linha.' ';
  			  }
			 // $this->pdf->ln();	
			  $this->pdf->Cell(180,4,$linha,0,1,'C');*/
		  

/*
		  while (round($this->pdf->GetStringWidth($linha)) < round($this->pdf->GetStringWidth($texto))+4)
		  { $linha = $linha.'_';
	  	  }
		  $this->pdf->ln();	
		  $this->pdf->Cell(180,4,$linha,0,1,'C');*/
	  }

      //2-imprimir posto/nome da autoridade que assina
      $this->pdf->SetFont('Times','B',12);
	  $this->pdf->Cell(180,5,$texto,0,1,'C');
      
      //3-imprimir funcao da autoridade que assina
      $this->pdf->SetFont('Times','',12);
	  $this->pdf->Cell(180,4,$funcaoAssina->getDescricao(),0,1,'C');
    
	}
    public function PDFImprimirCampoConfere($pGradConfere, $militarConfere, $funcaoConfere)
    { $linha = ' ';
	  $this->pdf->ln();
	  $this->pdf->ln();
	  //se a posicao vertical esta proximo do final, imprime linhas em branco ate quebrar a pagina
	  while ($this->pdf->GetY() > 250){
		$this->pdf->Cell(180,4,'',0,1,'C');
	  }
	  
      //confere com o original
	  $this->pdf->Cell(180,4,'CONFERE COM O ORIGINAL:',0,1,'L');
	  $this->pdf->ln();
	  $this->pdf->ln();
	  $this->pdf->ln();
	  

      $nomeMilitar = strtoupper(strtr($militarConfere->getNome(),'áéíóúãõâêôçäëïöü','ÁÉÍÓÚÃÕÂÊÔÇÄËÏÖÜ'));      
      if (($pGradConfere->getCodigo() == 2) or ($pGradConfere->getCodigo() == 3) or ($pGradConfere->getCodigo() == 4)
	  				or ($pGradConfere->getCodigo() == 60))
      { $texto = $pGradConfere->getDescricao() . ' ' . $nomeMilitar;
      }
      else
      { $texto = $nomeMilitar . ' - ' . $pGradConfere->getDescricao();
      }
      $texto2 = $funcaoConfere->getDescricao();
      if (round($this->pdf->GetStringWidth($texto)) > round($this->pdf->GetStringWidth($texto2)))
      	$textoMaior = $texto;
      else
      	$textoMaior = $texto2;
      
	  while (round($this->pdf->GetStringWidth($linha)) < round($this->pdf->GetStringWidth($textoMaior))+2)
	  //Alterado $linha.'_' para $linha.' '; devido alteração na legislação - Sgt Bedin 23/04/2013
	  { $linha = $linha.' ';
	  }

		  
		  	  if ($militarConfere->getAssinatura()!=null){
	  		  	  $absissa = (87 - round($this->pdf->GetStringWidth($texto))+4)/2;
		    	  $this->pdf->Image($this->bandIniFile->getAssinaturaDir().$militarConfere->getAssinatura(),$absissa,$this->pdf->GetY(),round($this->pdf->GetStringWidth($texto))+4,17);
		  	  }else{
			      //1-imprimir linha a esquerda para assinatura 
				  if (round($this->pdf->GetStringWidth($texto)) > round($this->pdf->GetStringWidth($texto2)))
				   //Alterado $linha.'_' para $linha.' '; devido alteração na legislação - Sgt Bedin 23/04/2013
				  { $linha = $linha.' ';
		  		  }
				  $this->pdf->Cell(180,4,$linha,0,1,'L');
		      }
			  
			
      //imprimir linha alinhada a esquerda para assinatura do confere - Removido devido determinação da Legislação - Sgt Bedin 24/04/2013
      /*
	  if (round($this->pdf->GetStringWidth($texto)) > round($this->pdf->GetStringWidth($texto2)))
		 //Alterado $linha.'_' para $linha.' '; devido alteração na legislação - Sgt Bedin 23/04/2013
		$linha = $linha.' ';
		      
	  $this->pdf->Cell(180,4,$linha,0,1,'L');
*/
      //imprimir posto/nome da autoridade que assina o confere
      $this->pdf->SetFont('Times','B',12);
      if (round($this->pdf->GetStringWidth($texto)) > round($this->pdf->GetStringWidth($texto2)))
		  $this->pdf->Cell(180,5,$texto,0,1,'L');
	  else
		  $this->pdf->Cell(round($this->pdf->GetStringWidth($textoMaior)),5,$texto,0,1,'C');

      //imprimir funcao da autoridade que assina o confere
	  $this->pdf->SetFont('Times','',12);
      if (round($this->pdf->GetStringWidth($texto)) > round($this->pdf->GetStringWidth($texto2)))
		  $this->pdf->Cell(round($this->pdf->GetStringWidth($texto))+5,4,$funcaoConfere->getDescricao(),0,1,'C');
	  else		  
		  $this->pdf->Cell(180,4,$funcaoConfere->getDescricao(),0,1,'L');
    }
    public function PDFImprimirCabecalho($OM, $boletim, $img, $brasaoDir)
    { $aDia = array('Sunday' => 'domingo','Monday' => 'segunda-feira', 'Tuesday' => 'terça-feira',
	  				 'Wednesday' => 'quarta-feira', 'Thursday' => 'quinta-feira', 'Friday' => 'sexta-feira',
	  				 'Saturday' => 'sábado');
	  $aDia = $aDia[date('l',strtotime($boletim->getDataPub()->GetcDataMMBDDBYYYY()))];	
	  $this->pdf->SetFont('Times','B',10);
	  //imprime a imagem do brasão das armas
	  if (file_exists($brasaoDir.'brasao.jpg')) {
	      $this->pdf->Image($brasaoDir.'brasao.jpg',93,15,23,25);
//	      $this->pdf->ln(24);
	      $this->pdf->ln(1);
	  }else{
	      $this->pdf->ln(4);
      }
	  $this->pdf->Cell(180,4,strtoupper($OM->getSubd1()),0,1,'C');
	  $this->pdf->Cell(180,4,strtoupper($OM->getSubd2()),0,1,'C');
	  if ($OM->getSubd3() <> '')
//		  $this->pdf->Cell(180,4,strtoupper($OM->getSubd3()),0,1,'C');
		  $this->pdf->Cell(180,4,$OM->getSubd3(),0,1,'C');
//	  $this->pdf->Cell(180,4,strtoupper($OM->getNome()),0,1,'C');
	 $this->pdf->Cell(180,4,$OM->getNome(),0,1,'C');
	  if ($OM->getDesigHist() <> '')
//		  $this->pdf->Cell(180,4,strtoupper($OM->getDesigHist()),0,1,'C');
		  $this->pdf->Cell(180,4,$OM->getDesigHist(),0,1,'C');
           if ($OM->getSubd4() <> '')
		  $this->pdf->Cell(180,4,$OM->getSubd4(),0,1,'C');
          $this->pdf->Cell(180,6,'',0,1,'C');
	  $this->pdf->SetFont('Times','',12);
	  $this->pdf->Cell(180,4,'Quartel '.$OM->getLoc().', '. $boletim->getDataPub()->getIDia() .  ' de ' . 
			    $boletim->getDataPub()->getNomeMes2() . ' de ' . $boletim->getDataPub()->getIAno(),0,1,'C'); 
	  $this->pdf->Cell(180,4,'('.$aDia.')',0,1,'C');
	  $this->pdf->Cell(180,4,'',0,1,'C');
	  $this->pdf->SetX(15);
    } 

    public function PDFImprimeMilitaresAgrupados($saida)
    { 
	    $this->pdf->WriteHTML('<div style="text-align: justify;">'.$saida.'</div>',$this->margemEsqDoc+0.5);
    }


  }
?>
