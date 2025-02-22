<?
  abstract class ConGerarBoletim
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
    private $colMateriaBiPorAssGer;
    private $rgrPessoa;
    private $ctAssuntogeral;
    private $ctAssuntoEspec;
    private $nomeFonte;
    private $tamFonte;
    private $margemEsqDoc;
    private $ultPag;
    private $boletim;
    private $bolAnt;
    private $qteSecao;
    private $qteAssGer;
    private $qteAssEsp;
    private $qteMat;
    private $caracterAnt;
    
    public function ConGerarBoletim($rgrOM, $rgrOMVinc, $rgrSubun, $rgrParteBoletim, $rgrSecaoParteBi, $rgrAssuntoGeral, $rgrAssuntoEspec,
//Bedin    
	$rgrBoletim, $rgrAssinaConfereBi, $rgrMilitar, $rgrFuncao, $rgrPGrad, $rgrQM, $rgrTipoBol, $rgrMateriaBi, 
	  //
	  $rgrPessoaMateriaBi, $rgrPessoa, $bandIniFile)
    { $this->rgrOM = $rgrOM;
      $this->rgrOMVinc = $rgrOMVinc;
      $this->rgrSubun = $rgrSubun;
      $this->rgrParteBoletim = $rgrParteBoletim;
      $this->rgrSecaoParteBi = $rgrSecaoParteBi;
      $this->rgrAssuntoGeral = $rgrAssuntoGeral;
      $this->rgrAssuntoEspec = $rgrAssuntoEspec;
      $this->rgrBoletim      = $rgrBoletim;
      $this->rgrAssinaConfereBi = $rgrAssinaConfereBi;
      $this->rgrMilitar = $rgrMilitar;
      $this->rgrFuncao = $rgrFuncao;
      $this->rgrPGrad = $rgrPGrad;
//Bedin	
	$this->rgrQM = $rgrQM;
      //
	  $this->rgrTipoBol = $rgrTipoBol;
      $this->rgrMateriaBi = $rgrMateriaBi;
      $this->rgrPessoaMateriaBi = $rgrPessoaMateriaBi;
      $this->rgrPessoa = $rgrPessoa;
      $this->bandIniFile = $bandIniFile;
      
	  $this->aLetras = array(1 => 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l' , 'm', 'n', 'o',
              'p', 'q','r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'aa', 'ab', 'ac', 'ad', 'ae', 'af', 'ag', 'ah',
              'ai', 'aj', 'ak', 'al', 'am', 'an', 'ao', 'ap', 'aq', 'ar', 'as', 'at', 'au', 'av', 'aw', 'ax', 'ay',
              'az', 'ba', 'bb', 'bc', 'bd', 'be', 'bf', 'bg', 'bh', 'bi', 'bj', 'bk', 'bl', 'bm', 'bn', 'bo', 'bp',
              'bq', 'br', 'bs', 'bt', 'bu', 'bv', 'bw', 'bx', 'by', 'bz');
            $this->tamFonte = 12;
	  $this->nomeFonte = 'Times';
	  $this->margemEsqDoc = 15;

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
    private function obterUltPag($boletim, $tipoBol)
    { //obter o numero do bi anterior
      $numeroBiAnt = $boletim->getNumeroBi() - 1;
//      echo $numeroBiAnt;
	  //se e para iniciar a numeracao de paginas a cada BI	
      if ($tipoBol->getIni_num_pag() == "S"){
	      $ultPag = 0;
	  } else {

	      //se nao e o primeiro bi do ano
    	  if ($numeroBiAnt != 0 or $tipoBol->getIni_num_pag() == "N")
	      { //le o bi anterior
//		    $BoletimAnt = $this->rgrBoletim->lerPorNumeroBi($boletim->getTipoBol()->getCodigo(),$numeroBiAnt);
		    $BoletimAnt = $this->rgrBoletim->lerPorNumeroBi($boletim->getTipoBol()->getCodigo(),$numeroBiAnt,$boletim->getDataPub()->getIAno());
	    	//se existe anterior
	        if ($BoletimAnt != null)
    	    { $ultPag = $BoletimAnt->getPagFinal();
        	  $this->bolAnt = 1;
	        }
    	    //nao existe boletim anterior
        	else
	        { $ultPag = $tipoBol->getNrUltPag();
    	    	$this->bolAnt = 0;
	//          $ultPag = $boletim->getPagInicial()-1;	//rv 05
    	    }
	      }
    	  else
	      { // se e o nro do bi ant = 0, o primeiro boletim
		    $ultPag = 0;
	      }
	  }
	  
      return $ultPag;
    }
//    abstract function PDFImprimeNome($nome);
	//rev 06
    abstract function PDFImprimeNome($nome,$nomeGuerra);
    abstract function PDFPrepara($fpdfFontDir, $ultPag, $tipoBol, $boletim, $pGradAssina, $militarAssina, 
	  $funcaoAssina, $outputBolDir, $OM);
	abstract function PDFImpTipoNumeroDescrBI($tipoBol, $boletim);
    abstract function PDFImprimeDescricaoParte($parteBi);
//    abstract function PDFImprimeDescricaoSecao($secaoParteBi, $aLetras);
    abstract function PDFImprimeDescricaoSecao($secaoParteBi, $letra);
    abstract function PDFImprimeAssuntoGeral($ctAssuntoGeral, $assuntoGeral2);
    abstract function PDFImprimeSemAlteracao($qteSec);
//    abstract function PDFImprimeAssuntoEspec($aLetras, $assuntoEspec2, $ctAssuntoEspec);
    abstract function PDFImprimeAssuntoEspec($assuntoEspec2, $ctAssuntoEspec);
    abstract function PDFImprimeTextoAbertura($materiaBi, $ctMat);
    abstract function PDFImprimeTextoFech($materiaBi);
    abstract function PDFImprimeRef($materiaBi,$siglaSubun);
    abstract function PDFImprimeTextoIndiv($pessoaMateriaBi);
    //retorna o numero da ultima pagina do bi atual, ou numero da pag corrente
    abstract function PDFGetUltPagBi($ultPag);
    abstract function PDFAvancaLinha($n);
    abstract function PDFGravarOutput($outputBolDir, $boletim, $tipoBol,$original);
  	abstract function PDFImprimePGrad($pGrad);
    abstract function PDFImprimeNomeCivil($pessoa);
    abstract function PDFAlteraMargemEsq($margemEsqDoc);
    abstract function PDFImprimirCampoAssinatura($pGradAssina, $militarAssina, $funcaoAssina, $original, $boletim);
    abstract function PDFImprimirCampoConfere($pGradConfere, $militarConfere, $funcaoConfere);
    abstract function PDFImprimirCabecalho($OM, $boletim, $img, $brasaoDir);
    abstract function PDFImprimeMilitaresAgrupados($saida);
    public function gerarBoletim($boletim, $original)
	{ $this->boletim = $this->rgrBoletim->lerPorCodigo($boletim->getCodigo());
      $tipoBol = $this->rgrTipoBol->lerRegistro($this->boletim->getTipoBol()->getCodigo());
      $this->ultPag = $this->obterUltPag($this->boletim, $tipoBol); 
      
      $assinaConfereBi = $this->rgrAssinaConfereBi->lerPorCodigo($this->boletim->getAssinaConfereBi()->getCodigo()); 
      $militarAssina = $this->rgrMilitar->lerRegistro($assinaConfereBi->getMilitarAssina()->getIdMilitar());
      if ($militarAssina == null)
      { throw new Exception('Militar que assina n�o est� cadastrado');
      }
	  $funcaoAssina = $this->rgrFuncao->lerRegistro($assinaConfereBi->getMilitarAssina()->getFuncao()->getCod());
      if ($funcaoAssina == null)
      { throw new Exception('Fun��o do Militar que assina n�o est� cadastrada');
      }
      $pGradAssina = $this->rgrPGrad->lerRegistro($assinaConfereBi->getMilitarAssina()->getPGrad()->getCodigo());
      if ($pGradAssina == null)
      { throw new Exception('Posto/Gradua��o do Militar que assina n�o est� cadastrado');
      }

      $militarConfere= $this->rgrMilitar->lerRegistro($assinaConfereBi->getMilitarConfere()->getIdMilitar());
      if ($militarConfere == null)
      { throw new Exception('Militar que confere n�o est� cadastrado');
      }
      $funcaoConfere= $this->rgrFuncao->lerRegistro($assinaConfereBi->getMilitarConfere()->getFuncao()->getCod());
      if ($funcaoConfere == null)
      { throw new Exception('Fun��o do Militar que confere n�o est� cadastrada');
      }
      $pGradConfere = $this->rgrPGrad->lerRegistro($assinaConfereBi->getMilitarConfere()->getPGrad()->getCodigo());
      if ($pGradConfere == null)
      { throw new Exception('Posto/Gradua��o do Militar que confere n�o est� cadastrado');
      }

      $tipoBol = $this->rgrTipoBol->lerRegistro($this->boletim->getTipoBol()->getCodigo());
      
      //LOGO QUE SER� COLOCADO NO RELAT�RIO 
//      $img = "C:/Arquivos de programas/VertrigoServ/www/band/imagens/brasao.jpg"; 
//      $img = $this->bandIniFile->getBrasaoDir() . "brasao.jpg"; 
      $img = "brasao.jpg"; 

      //captura as informa��es da OM
      $OM = $this->rgrOM->lerRegistro();

      //captura as informa��es das Partes/Se��es
      $colParteBi = $this->rgrParteBoletim->lerColecao('numero_parte');

      //PREPARA PARA GERAR O PDF
      $fpdfFontDir = $this->bandIniFile->getFPDFFontDir();
	  $outputBolDir = $this->bandIniFile->getOutPutBolDir();
	  $brasaoDir = $this->bandIniFile->getBrasaoDir();
	  //echo str_replace("\\","/",__FILE__);
	  //die($this->bandIniFile->getBrasaoDir());
      $this->PDFPrepara($fpdfFontDir, $this->ultPag, $tipoBol, $this->boletim, $pGradAssina, $militarAssina, 
	    $funcaoAssina,$outputBolDir,$OM);
      	  
      $this->PDFImprimirCabecalho($OM, $this->boletim, $img, $brasaoDir);
	  	  
      $parteBi = $colParteBi->iniciaBusca1();

	  //imprime o tipo e o n�mero do Boletim      
	  $this->PDFImpTipoNumeroDescrBI($tipoBol, $boletim);
      //
      //varre o boletim por partes
      //
      while ($parteBi != null)
	  {
            $this->PDFAvancaLinha(1);
            $this->PDFImprimeDescricaoParte($parteBi);
	    $colSecaoParteBi = $this->rgrSecaoParteBi->lerColecao($parteBi->getNumeroParte());
	    $secaoParteBi = $colSecaoParteBi->iniciaBusca1();
	    $this->qteSecao = $colSecaoParteBi->getQTD();
	    $numSec = 1;
	    //
	    //varre o boletim por secao
	    //
        while ($secaoParteBi != null) //por exemplo Assuntos gerais e administrativos
		{ //$this->PDFImprimeDescricaoSecao($secaoParteBi, $this->aLetras[$numSec]);
		  //
          if ($this->qteSecao > 1){
                  $this->PDFAvancaLinha(1);
        	  $this->PDFImprimeDescricaoSecao($secaoParteBi, $numSec);
          }else{
                //$this->PDFAvancaLinha(1);
          }
		  $numSec = $numSec + 1;
	      $this->colMateriaBi2 = $this->rgrMateriaBi->lerColecao($this->boletim->getCodigo(), $parteBi->getNumeroParte(), 
		    $secaoParteBi->getNumeroSecao());
          $this->materiaBi = $this->colMateriaBi2->iniciaBusca1();
          $entrou = 'N';
	      $this->ctAssuntoGeral = 0;
          while ($this->materiaBi != null)
		  { 
	        $entrou = 'S';
            $this->assuntoGeral = $this->materiaBi->getAssuntoGeral();

			//busca a qte de materias por assunto geral
//			$this->colMateriaBiPorAssGer = $this->rgrMateriaBi->lerColecaoPorAssGer($this->boletim->getCodigo(), 
//														$parteBi->getNumeroParte(), $secaoParteBi->getNumeroSecao(),
//														$this->assuntoGeral->getCodigo());
														
			//$this->colMateriaBiPorAssGer = $this->colMateriaBiPorAssGer->iniciaBusca1();
            //print_r($this->colMateriaBiPorAssGer);
            
//			$qteMatPorAssGer = $this->colMateriaBiPorAssGer->getQTD();
			$this->qteAssGer = $this->rgrMateriaBi->lerQteAssGerPorSec($this->boletim->getCodigo(), 
														$parteBi->getNumeroParte(), $secaoParteBi->getNumeroSecao());


			$this->qteAssEsp = $this->rgrMateriaBi->lerQteAssEspPorAssGer($this->boletim->getCodigo(), 
														$parteBi->getNumeroParte(), $secaoParteBi->getNumeroSecao(),
														$this->assuntoGeral->getCodigo());

            $assuntoGeral2 = $this->rgrAssuntoGeral->lerRegistro($this->assuntoGeral->getCodigo());
            $this->ctAssuntoGeral = $this->ctAssuntoGeral + 1;

			if ($this->qteAssGer > 1){			
	            if ($this->qteSecao > 1)
		            $caracterAssGer = $this->aLetras[$this->ctAssuntoGeral];
//		            $caracterAssGer = $this->aLetras[$this->ctAssuntoGeral]."Sec:".$this->qteSecao."AssGer:".$this->qteAssGer;
	    	    else
	        	    $caracterAssGer = $this->ctAssuntoGeral;
//	        	    $caracterAssGer = $this->ctAssuntoGeral."Sec:".$this->qteSecao."AssGer:".$this->qteAssGer;
	        }else {
        	    $caracterAssGer = ' ';
	        }
//            if ($this->qteSecao > 1)
//	            $this->caracterAnt = 'numero';
//	            $this->caracterAnt = 'letra';
 //   	    else
//	            $this->caracterAnt = 'letra';
//	            $this->caracterAnt = 'numero';
			
    	    $this->PDFAvancaLinha(1);

            $this->PDFImprimeAssuntoGeral($caracterAssGer, $assuntoGeral2);
            $this->ctAssuntoEspec = 0;
            //varre todos os assuntos da secao
			$this->varreAssuntoGeral($caracterAssGer);
          }
          if ($entrou  == 'N')
          { $this->PDFImprimeSemAlteracao($this->qteSecao);
          }
   		  $secaoParteBi = $colSecaoParteBi->getProximo1();
        }//fim do while secaoParteBi
	    $parteBi = $colParteBi->getProximo1();
      }//fim do while parteBi
      $this->PDFAvancaLinha(1);
	  //Inclu�do $boletim, para remover a imagem de assinatura caso n�o tenha sido assinado o BI - Sgt Bedin
      $this->PDFImprimirCampoAssinatura($pGradAssina, $militarAssina, $funcaoAssina, $original, $boletim);
      if ($original != 'S')
      { $this->PDFImprimirCampoConfere($pGradConfere, $militarConfere, $funcaoConfere);
      }
      //atualizar boletim
      $this->boletim->setPagInicial($this->ultPag+1);
      $this->boletim->setPagFinal($this->PDFGetUltPagBi($this->ultPag));
      $this->rgrBoletim->alterarRegistro($this->boletim);

      //atualiza tipobol, somente se houver um boletim anterior ($bolAnt = 1)
      if ($this->bolAnt != 0){
	      $tipoBol->setNrUltPag($this->boletim->getPagFinal());
    	  $this->rgrTipoBol->alterarRegistro($tipoBol);
      }  
	  
	  //SAIDA DO PDF
      $arq = $this->PDFGravarOutput($outputBolDir, $this->boletim, $tipoBol, $original);
      return $arq;
    }
    private function varreAssuntoGeral($caracterAssGer)
    { while (($this->materiaBi != null) and 
	   ($this->assuntoGeral->getCodigo() == $this->materiaBi->getAssuntoGeral()->getCodigo()))
	   
      { $this->assuntoEspec = $this->materiaBi->getAssuntoEspec();
	    $assuntoEspec2 = $this->rgrAssuntoEspec->lerRegistro($this->assuntoGeral->getCodigo(),
	    $this->assuntoEspec->getCodigo());

		$this->qteMat = $this->rgrMateriaBi->lerQteMatPorAssEsp($this->boletim->getCodigo(), 
													$this->assuntoGeral->getCodigo(),$this->assuntoEspec->getCodigo());

        $this->ctAssuntoEspec = $this->ctAssuntoEspec + 1;
//        $this->PDFImprimeAssuntoEspec($this->aLetras, $assuntoEspec2, $this->ctAssuntoEspec);

		if ($this->qteAssEsp > 1){
			//17jan
//	        if ((is_int($caracterAssGer)) || (($caracterAssGer == ' ') && ($this->caracterAnt == "numero")))
			//verifica se o identicador do ass esp ser� numero ou letra
	        if ((is_int($caracterAssGer)) || (($caracterAssGer == ' ') && ($this->qteSecao > 1)))
    	    	$caracterAssEsp1 = $this->aLetras[$this->ctAssuntoEspec];
        	else
        		$caracterAssEsp1 = $this->ctAssuntoEspec;

			//verifica se o identicador do ass esp ser� acompanhado de . ou )
            if ((($this->qteAssGer == 1) || ($this->qteSecao == 1)) || (($this->qteAssGer == 1) && ($this->qteSecao == 1)))
    	    	$caracterAssEsp2 =  $caracterAssEsp1 . '. ';
//    	    	$caracterAssEsp2 =  $caracterAssEsp1 . '. '.$this->qteSecao.$this->qteAssGer.$this->qteAssEsp;
			else
    	    	$caracterAssEsp2 =  $caracterAssEsp1 . ') ';	            	
//    	    	$caracterAssEsp2 =  $caracterAssEsp1 . ') '.$this->qteSecao.$this->qteAssGer.$this->qteAssEsp;	            	
		} else{
			$caracterAssEsp2 = ' ';
		}
        if ((($this->qteAssGer == 1) && ($this->qteSecao == 1)) ||
			(($this->qteAssGer > 1) && ($this->qteSecao > 1)))
//            $this->caracterAnt = 'numero';
			//16jan
            $this->caracterAnt = 'letra';
   	    else
//16jan
            $this->caracterAnt = 'numero';
//            $this->caracterAnt = 'letra';

		if (substr($assuntoEspec2->getDescricao(),0,1) != "(")
		    $this->PDFImprimeAssuntoEspec($assuntoEspec2, $caracterAssEsp2);
        $this->varreAssuntoEspec($caracterAssEsp1);
      } //fim do loop ass geral
    }
    private function varreAssuntoEspec($caracterAssEsp)
    { $ctMat = 0;
	  while (($this->materiaBi != null) and 
	   ($this->assuntoGeral->getCodigo() == $this->materiaBi->getAssuntoGeral()->getCodigo()) and 
	   ($this->assuntoEspec->getCodigo() == $this->materiaBi->getAssuntoEspec()->getCodigo()))
	  { 

	  	$ctMat = $ctMat + 1;
	    //marco
	    //gravar o numero da pagina na materia
	    $this->materiaBi->setPagina($this->PDFGetUltPagBi($this->ultPag));
	    $this->rgrMateriaBi->alterarRegistroSemRestricao($this->materiaBi, $this->boletim);
//	    $this->PDFImprimeTextoAbertura($this->materiaBi, $ctMat);

		if ($this->qteMat > 1){
	        //verifica se deve ser letra ou numero
//			if ((is_int($caracterAssEsp)) || (($caracterAssEsp == ' ') && ($this->caracterAnt == 'numero')))
			if ((is_int($caracterAssEsp)) || ($this->caracterAnt == 'numero'))
//			if ((is_int($caracterAssEsp)) || ($this->caracterAnt == 'numero'))
    	    	$caracterMat = $this->aLetras[$ctMat];
//    	    	$caracterMat = $this->aLetras[$ctMat]."Sec:".$this->qteSecao."AssGer:".$this->qteAssGer."AssEsp:".$this->qteAssEsp;
        	else
        		$caracterMat = $ctMat;
//        		$caracterMat = $ctMat."Sec:".$this->qteSecao."AssGer:".$this->qteAssGer."AssEsp:".$this->qteAssEsp;
            
			//verifica se deve ser "." ou ")"
			if ((($this->qteSecao==1)&&($this->qteAssGer==1)) || 
				(($this->qteSecao==1)&&($this->qteAssEsp==1)) ||
				(($this->qteAssGer==1)&&($this->qteAssEsp==1)) ||
//				(($this->qteSecao>1)&&($this->qteAssGer>1)&&($this->qteAssEsp>1)) )
				(($this->qteSecao==1)&&($this->qteAssGer==1)&&($this->qteAssEsp==1)) )
    	    	$caracterMat .= '. ';
			else
    	    	$caracterMat .= ') ';	            	
		} else
			$caracterMat = ' ';
		//teste
        //if ($ctMatPorAssEsp == 1) $caracterMat = "X";
	    $this->PDFImprimeTextoAbertura($this->materiaBi, $caracterMat);
	    
        $colPessoaMateriaBi = $this->rgrPessoaMateriaBi->lerColecao($this->materiaBi->getCodigo());
        
        $this->varrePessoas($colPessoaMateriaBi);
        if (trim($this->materiaBi->getTextoFech()) <> ''){
    	    $this->PDFAvancaLinha(1);
	    $this->PDFImprimeTextoFech($this->materiaBi);        
    	    //$this->PDFAvancaLinha(1);
    	}
        if (trim($this->materiaBi->getMostraRef()) == 'S'){
          //captura as informa��es da OM
          $om = $this->rgrOM->lerRegistro();
          $omVinc = $this->rgrOMVinc->lerRegistro($this->materiaBi->getCodom());
          $siglaOmVinc = $omVinc->getSigla();
          $subun = $this->rgrSubun->lerRegistro($this->materiaBi->getCodom(), $this->materiaBi->getCodSubun());
          $siglaSubun = $subun->getSigla();
    	  $this->PDFAvancaLinha(1);
          $this->PDFImprimeRef($this->materiaBi,$siglaSubun);
        }

        $this->materiaBi = $this->colMateriaBi2->getProximo1();

      } // fim do loop ass espec
    }
    private function varrePessoas($colPessoaMateriaBi)
    {
      $saida="";
      $pessoaMateriaBi = $colPessoaMateriaBi->iniciaBusca1();
      $qtePessoa = $colPessoaMateriaBi->getQTD();
      //varre todas as pessoa da materia
      $ctPessoas = 0;
      $milAntTemTextoIndiv=0;
      while ($pessoaMateriaBi != null)
      {
        if ($milAntTemTextoIndiv==0)
            $this->PDFAvancaLinha(1);

        $ctPessoas = $ctPessoas + 1;
        $pessoa = $this->rgrMilitar->lerRegistro($pessoaMateriaBi->getPessoa()->getIdMIlitar());
        //militar
        if ($pessoa != null)
        { $pGrad = $this->rgrPGrad->lerRegistro($pessoa->getPGrad()->getCodigo());
		//Bedin
		$qm = $this->rgrQM->lerRegistro($pessoa->getQM()->getCod());
		//
   		  if ($_SESSION['IMPRIMENOMESLINHA']=='S'){
			if ($_SESSION['IMPRIMEQMS']=='S'){
		  //Bedin
            $this->PDFImprimeNome($pGrad->getDescricao().' '.$qm->getAbreviacao().' '.strtoupper(trim($pessoa->getNome())),strtoupper(trim($pessoa->getNomeGuerra())));
	        //
			}else{
			$this->PDFImprimeNome($pGrad->getDescricao().' '.strtoupper(trim($pessoa->getNome())),strtoupper(trim($pessoa->getNomeGuerra())));}
			if ((trim($pessoaMateriaBi->getTextoIndiv()) <> '')||(trim($pessoaMateriaBi->getTextoIndiv()) <> '<br />')){
    	        $this->PDFImprimeTextoIndiv($pessoaMateriaBi);
        	    $milAntTemTextoIndiv = 1;
        	}else
            	$milAntTemTextoIndiv=0;
          }else{
       	    $milAntTemTextoIndiv = 1;
			//Bedin
			$saida .= $pGrad->getDescricao(). ' ' . $qm->getAbreviacao().' '. $this->setaNomeGuerra($pessoa->getNome(),$pessoa->getNomeGuerra());  
			//
			if (trim($pessoaMateriaBi->getTextoIndiv()) <> ''){
				$textoIndiv = preg_replace('<div style="text-align: justify;">',"",$pessoaMateriaBi->getTextoIndiv());
				$textoIndiv = preg_replace('</div>',"",$textoIndiv);
				$saida .= " (" . $textoIndiv . ")";
   			}
			if ($ctPessoas!=$qtePessoa)
				$saida .= ", ";
			else
				$saida .= ".";
          
          }
        }
        //civil
        else
        { $pessoa = $this->rgrPessoa->lerRegistro($pessoaMateriaBi->getPessoa()->getIdMIlitar());
          $this->PDFImprimeNomeCivil($pessoa);
          //avanca a linha
        }
		$this->PDFAlteraMargemEsq($this->margemEsqDoc);
        $pessoaMateriaBi = $colPessoaMateriaBi->getProximo1();
      } //fim do loop de pessoa
  	  if ($_SESSION['IMPRIMENOMESLINHA']!='S')
	    $this->PDFImprimeMilitaresAgrupados($saida);

//      }
    }    

	//retorna o nome completo com o nome de guerra setado
	function setaNomeGuerra($nome,$nomeguerra){
		$Retorno = '';
		$nome=strtoupper(trim($nome));
	  	$nome = strtr($nome,'����������������','����������������');
		$nomeguerra=strtoupper(trim($nomeguerra));
	  	$nomeGuerra = strtr($nomeGuerra,'����������������','����������������');
		$c1 = explode(" ",$nome);
		$c2 = explode(" ",$nomeguerra);
		$pri = 0;

		for ($i = 0; $i < count($c1); $i++) {		//percorre todas as palavras do nome
			for ($j = 0; $j < count($c2); $j++){			//percorre todas as palavras do nome de guerra
				//verifica se a palavra do nome � igual a palavra do nome de guerra
				//ou se a letra inicial do nome � igual a palavra do nome de guerra
				if ( ($c1[$i] == $c2[$j]) or ( substr($c1[$i],0,1) == $c2[$j] and $pri==0) ) {
					if (strlen($c2[$j]) == 1){
						//coloca apenas a letra inicial da palavra em negrito
						$Retorno = $Retorno.'<B>'.substr($c1[$i],0,1).'</B>'.substr($c1[$i],1,strlen($c1[$i]));
						$pri=1;
						break;//sai do for (palavras do nome de guerra)
					}else {
						//coloca a palavra em negrito
						$Retorno = $Retorno.'<B>'.$c1[$i].'</B>'.' ';
						break;//sai do for (palavras do nome de guerra)
					}
				} else {
					//verifica se � a �ltima palavra do for (palavras do nome de guerra)
					if ($c2[$j+1]==''){
						$Retorno = $Retorno.$c1[$i];//coloca a palavra com o padr�o normal
					}
				}
				$Retorno = $Retorno.' ';
			}
		}
		return $Retorno;
	}

    
  }
?>
