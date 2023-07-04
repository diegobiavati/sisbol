<?php
  class ConGerarAlteracoes
  { private $rgrOM;
    private $rgrPessoaMateriaBi;
    private $rgrTempoSerPer;
    private $rgrMilitar;
    private $rgrFuncao;
    private $rgrPGrad;
    private $rgrOmVinc;
    private $bandIniFile;
    
    private $om;
    private $militar;
    private $nomeFonte;
    private $tamFonte;
    public function ConGerarAlteracoes($rgrOM, $rgrPessoaMateriaBi, $rgrTempoSerPer, $rgrMilitar, $rgrFuncao, 
	  $rgrPGrad, $rgrOmVinc, $bandIniFile)
    {  $this->rgrOM = $rgrOM;
       $this->rgrPessoaMateriaBi = $rgrPessoaMateriaBi;
       $this->rgrTempoSerPer = $rgrTempoSerPer;
       $this->rgrMilitar = $rgrMilitar;
       $this->rgrFuncao = $rgrFuncao;
       $this->rgrPGrad = $rgrPGrad;
       $this->rgrOmVinc = $rgrOmVinc;
       $this->bandIniFile = $bandIniFile;
       $this->tamFonte = 12;
	   $this->nomeFonte = 'Times';    
    }
    /**
    * Esta funcao prepara para a geracao das alteracoes de um conjunto de militares, num periodo especificado
    * Nao retorna nada, mas gera um arquivo PDF contendo as alteracoes dos militares solicitados
    *
    * @param $colMilitar2, colecao de militares
    * @param $dtInicio, data de inicio do periodo
    * @param $dtTermino, data de termino do periodo
    */
    public function GerarAlteracoes($colMilitar2, $dtInicio, $dtTermino)
    {

//	  print_r($dtTermino);


      /**
	  * captura as informações da OM
      */
      $this->om = $this->rgrOM->lerRegistro();
	  	
	  /**
	  * PREPARA PARA GERAR O PDF
	  */								  
	  $fpdfFontDir = $this->bandIniFile->getFPDFFontDir();
	  $outPutAltDir = $this->bandIniFile->getOutPutAltDir();
      define("FPDF_FONTPATH",$fpdfFontDir);

  	  $this->pdf = new meuhtml2fpdfalt('P','mm','a4'); 		  							
		
      $this->pdf->setOM($this->om);
	  $arq = $outPutAltDir . $dtInicio->getcDataYYYYHMMHDD() . '_' 
		  								   . $dtTermino->getcDataYYYYHMMHDD() . '_';
// 		  die($arq);
      //gerar para um subconjunto de militares
      if ($colMilitar2 != null)
      { $contMil = $colMilitar2->getQTD();
	  	$militar = $colMilitar2->iniciaBusca1();
		$pGrad = $this->rgrPGrad->lerRegistro($militar->getPGrad()->getCodigo());

        if ($contMil == 1)
        { 
          //leitura do tempo de servico - alterado 06Mai08
          $tempoSerPer = null;
	      $tempoSerPer = $this->rgrTempoSerPer->lerRegistro($dtInicio, $dtTermino, $militar->getIdMilitar());
          $dtIni=$tempoSerPer->getdataIn()->GetcDataYYYYHMMHDD();
		  $dtIni = new MinhaData($dtIni);
          $dtTer=$tempoSerPer->getdataFim()->GetcDataYYYYHMMHDD();
		  $dtTer = new MinhaData($dtTer);
		  $this->pdf->setDtInicio($dtIni);
          $this->pdf->setDtTermino($dtTer);

		  if($this->gerarAlteracoesIndiv($militar, $dtIni, $dtTer, $tempoSerPer) === 0){
        	$arq = 0;
          }	else {
		  //$this->gerarAlteracoesIndiv($militar, $dtInicio, $dtTermino);
			// rev 06
		  	$nomeGuerra = strtr($militar->getNomeGuerra(),'áéíóúãõâêôçäëïöüñÁÉÍÓÚÃÕÂÊÔÇÄËÏÖÜÑ','aeiouaoaeocaeiounAEIOUAOAEOCAEIOUN');
		  	$nomeGuerra = strtolower($nomeGuerra);
//		  	$nomeGuerra = strtr(strtolower($militar->getNomeGuerra()),'áéíóúãõâêôçäëïöü','aeiouaoaeocaeiou');
		  	/*Alterado por Ten S.Lopes -- 19/03/2012 -- código anterior:
			$arq = $arq . ereg_replace('º','',ereg_replace(' ','',strtolower($pGrad->getDescricao()))) . '_' 
										   . ereg_replace(' ','_',$nomeGuerra) . '.pdf';
										   ereg_replace Depreciado na Versão do PHP 5.3*/
		
			$arq = $arq . str_replace('º','',str_replace(' ','',strtolower($pGrad->getDescricao()))) . '_' 
										   . str_replace(' ','_',$nomeGuerra) . '.pdf';
		  }							   
		}else{
			while ($militar != null)
    	    { 
			    //leitura do tempo de servico - alterado 06Mai08
        		$tempoSerPer = null;
			    $tempoSerPer = $this->rgrTempoSerPer->lerRegistro($dtInicio, $dtTermino, $militar->getIdMilitar());
        		$dtIni=$tempoSerPer->getdataIn()->GetcDataYYYYHMMHDD();
				$dtIni = new MinhaData($dtIni);
        		$dtTer=$tempoSerPer->getdataFim()->GetcDataYYYYHMMHDD();
				$dtTer = new MinhaData($dtTer);
				$this->pdf->setDtInicio($dtIni);
        		$this->pdf->setDtTermino($dtTer);
			    $this->gerarAlteracoesIndiv($militar, $dtIni, $dtTer, $tempoSerPer);
	            $militar = $colMilitar2->getProximo1();      
    	    }
			// Alterado por Ten S.Lopes -- 19/03/2012 -- código anterior = "$arq = $arq . ereg_replace('º','', ereg_replace(' ','',strtolower($pGrad->getDescricao()))).'.pdf';" ereg_replace Depreciado na Versão do PHP 5.3
			$arq = $arq . str_replace('º','', str_replace(' ','',strtolower($pGrad->getDescricao()))).'.pdf';

    	}
      }
	  /* retirado em 06Mai08
	  else //gerar para todos os militares
      { $this->gerarAlteracoesIndiv(null, $dtInicio, $dtTermino, $tempoSerPer);
		$arq = $arq . 'todos.pdf';
      }
      */
      if($arq !== 0){
	  	$this->pdf->Output($arq, "F");
	  }
	  return($arq);
    }
    /**
    * Esta funcao gera as alteracoes de um conjunto de militares, num periodo especificado
    * escreve num arquivo PDF contendo as alteracoes dos militares solicitados
    *
    * @param $militar, militar que tera alteracoes gerada, se nulo gera para todos
    * @param $dtInicio, data de inicio do periodo
    * @param $dtTermino, data de termino do periodo
    */
    public function gerarAlteracoesIndiv($militar, $dtInicio, $dtTermino, $tempoSerPer)
    { $aMes = array(1 => 'JANEIRO', 'FEVEREIRO', 'MARÇO', 'ABRIL', 'MAIO', 'JUNHO', 'JULHO', 'AGOSTO', 'SETEMBRO', 
	    'OUTUBRO', 'NOVEMBRO', 'DEZEMBRO');
      $aMeses = array(1 => 'janeiro', 'fevereiro', 'março', 'abril', 'maio', 'junho', 'julho', 'agosto', 'setembro', 
	    'outubro', 'novembro', 'dezembro');
//	  print_r($militar);
      if ($militar != null){ 
	  	$arrayBoletim = $this->rgrPessoaMateriaBi->lerAlteracoes($militar->getIdMilitar(), $dtInicio, $dtTermino);
      } else { 
	  	$arrayBoletim = $this->rgrPessoaMateriaBi->lerAlteracoes('TODOS', $dtInicio, $dtTermino);
      }
//	  print_r($arrayBoletim);
      
      $total = count($arrayBoletim);
      //die('cheguei '.print_r($militar->getOMVinc()->getCodOM()));
	  
	  if ($total == 0)
      { return $total;
      }
      
      $i = 0;


      while ($i < $total)
      { $boletim = $arrayBoletim[$i];
	    $materiaBi = $boletim->getColMateriaBi2()->iniciaBusca1();
        $pessoaMateriaBi = $materiaBi->getColPessoaMateriaBi2()->iniciaBusca1();
        $pessoa = $pessoaMateriaBi->getPessoa();
//		print_r($pessoa);
        $pessoaAnt = $pessoa;

    	//die('Esta é a pessoa '.$pessoa->getOMVinc()->getCodOM());//->getOmVinc()->getCodOM());
    	
    	//die($Pessoa->getOmVinc()->getCodOM());
        
		$pessoa->setOmVinc($this->rgrOmVinc->lerRegistro($pessoa->getOmVinc()->getCodOM()));
        $this->pdf->setOMVinc($pessoa->getOmVinc());	
	    
        $this->pdf->setPessoa($pessoa);
  
 		/*alteracao 06Mai08 - Erro na datas de inicio e término
        $dtInicio=$tempoSerPer->getdataIn()->GetcDataYYYYHMMHDD();
		$dtInicio = new MinhaData($dtInicio);
        $dtTermino=$tempoSerPer->getdataFim()->GetcDataYYYYHMMHDD();
		$dtTermino = new MinhaData($dtTermino);
//        print_r($dtInicio);
		$this->pdf->setDtInicio($dtInicio);
        $this->pdf->setDtTermino($dtTermino);
        */
        
        $this->pdf->setPagina(0);

		$this->pdf->SetMargins(20,20,15);
	  	$this->pdf->SetFont('Times','',12);
		$this->pdf->AddPage();
	    $this->pdf->ln();	
        $this->pdf->Cell(177,5,'1ª PARTE',0,1,'L');
		$this->pdf->Line($this->pdf->GetX()+1,$this->pdf->GetY(),40,$this->pdf->GetY());
        $mesI = $dtInicio->getIMes();
        $mesF = $dtTermino->getIMes();
        while (($i < $total) and ($pessoa->getIdMilitar() === $pessoaAnt->getIdMilitar()))
        { $mes = $boletim->getDataPub()->getImes(); 
          $mesAnt = $mes;
          /**
		  * imprime meses sem alteracao
          * nao imprime $mes porque tem alteracoes e sera impresso no loop
          */
          while ($mesI < $mes)
          { $this->pdf->ln();
		  	$this->pdf->SetFont('Times','',12);
		  	$this->pdf->Cell(round($this->pdf->GetStringWidth($aMes[$mesI]))+3,5,$aMes[$mesI].': ','B',0,'L');
		  	$this->pdf->SetFont('Times','',12);
    	    $this->pdf->Cell(80,5,'Sem Alteração',0,1,'L');
    	    $mesI = $mesI + 1;
          }
    	  $this->pdf->ln();
		  $this->pdf->SetFont('Times','',12);
		  $this->pdf->Cell(round($this->pdf->GetStringWidth($aMes[$mesI]))+3,5,$aMes[$mes].':','B',1,'L');
          //fim da rotina de impressao de meses sem alteraçao
          while (($i < $total) and ($pessoa->getIdMilitar() === $pessoaAnt->getIdMilitar()) and 
            ($mes == $mesAnt))
          { 
		  	$this->pdf->SetFont('Times','B',12);
    	    $this->pdf->ln();

			if (substr($materiaBi->getDescrAssEsp(),0,1) == "(")
				$assGerMaisAssEsp = '<div style="text-align: justify;">'.$materiaBi->getDescrAssGer().'</div>';
			else
				$assGerMaisAssEsp = '<div style="text-align: justify;">'.$materiaBi->getDescrAssGer() . ' - ' . $materiaBi->getDescrAssEsp().'</div>';


//    	    $this->pdf->MultiCell(177,5,$assGerMaisAssEsp,0,'J',0);
	        $this->pdf->WriteHTML($assGerMaisAssEsp);

		  	$this->pdf->SetFont($this->nomeFonte,'',$this->tamFonte);
    	    
			$textoCompleto = '- a ' . $boletim->getDataPub()->getIDia() . ', ' . trim($boletim->getTipoBol()->getAbreviatura()) . ' Nº ' . $boletim->getNumeroBi() . ' ' . $boletim->getBiRef() . ' :';
            //dados do boletim								
		        $this->pdf->ln();
                        $this->pdf->WriteHTML('<div style="text-align: justify;">'.$textoCompleto.'</div>');
	        //$this->pdf->MultiCell(177,5,$textoCompleto,0,'J',0);
//	        $this->pdf->ln();
	        //texto de abertura
			$textoAbert = rtrim($materiaBi->getTextoAbert());
			if ($textoAbert != null)
                            $this->pdf->WriteHTML('<div style="text-align: justify;">'.$textoAbert.'</div>');

	        //texto individual
		  	$this->pdf->SetFont('Times','',12);
			$textoIndiv = rtrim($pessoaMateriaBi->getTextoIndiv());
			if ($textoIndiv != ''){
		        //$this->pdf->ln();
		        $this->pdf->WriteHTML('<div style="text-align: justify;">'.$textoIndiv.'</div>');
//		        $this->pdf->MultiCell(177,5,$textoIndiv,0,'J',0);
//		        $this->pdf->ln();
		    }
	        //texto de fechamento
            $this->pdf->SetFont('Times','',12);
			if (rtrim($materiaBi->getTextoFechVaiAltr())=='S'){
            	$textoFech = rtrim($materiaBi->getTextoFech());
                if ($textoFech != null)
                	$this->pdf->WriteHTML('<div style="text-align: justify;">'.$textoFech.'</div>');
            }
		  	$this->pdf->SetFont('Times','',12);
	        
            $i = $i + 1;
            if ($i < $total)
            { $boletim = $arrayBoletim[$i];
	        }
            else
            { $boletim = null;
            }

            if ($boletim != null)
            { $materiaBi = $boletim->getColMateriaBi2()->iniciaBusca1();
              $pessoaMateriaBi = $materiaBi->getColPessoaMateriaBi2()->iniciaBusca1();
              $pessoa = $pessoaMateriaBi->getPessoa();
              $mes = $boletim->getDataPub()->getImes(); 
            }
          }//fim do loop do mes
          $mesI = $mesI + 1;
        
	    }//fim do loop do militar
        //imprime meses sem alteracao
        //adiciona um ao mes porque ja foi impresso
//        $mesI = $mesI + 1;//alterado por Renato, devido imprimir duplicado os meses que têm alteração
        //se terminou o militar imprime ate o fim, nao sera impresso em duplicata por causa da adicao ao mesi
        while ($mesI <= $mesF)
        { $this->pdf->ln();
  	      $this->pdf->SetFont('Times','',12);
          $this->pdf->Cell(round($this->pdf->GetStringWidth($aMes[$mesI])+3),5,$aMes[$mesI].': ','B',0,'L');
  	      $this->pdf->SetFont('Times','',12);
    	  $this->pdf->Cell(80,5,'Sem Alteração',0,1,'L');
          $mesI = $mesI + 1;
        }
        $this->pdf->ln();
		//Alterado ($pessoaAnt->getPGrad()->getCodigo() > 18) para consultar o valor do campo comportamento, para impressão do mesmo, 
		//Sgt Bedin 23/04/2013
        if ($pessoaAnt->getComportamento() != '0')
        {
   	      $this->pdf->Cell(round($this->pdf->GetStringWidth('Comportamento')+3),5,'Comportamento: ',0,0,'L');
          //echo 'Comportamento: ';
          //Domínio do Módulo E1 1-Excepcional;2-Ótimo;3-Bom;5-Insuficiente;6-Mau-->		
          if ($pessoaAnt->getComportamento() == '0')
          { $comportamento = 'INVÁLIDO';
          }
          if ($pessoaAnt->getComportamento() == '1')
          { $comportamento = 'EXCEPCIONAL';
          }
	      if ($pessoaAnt->getComportamento() == '2')
          { $comportamento = 'ÓTIMO';
          }
          if ($pessoaAnt->getComportamento() == '3')
	      { $comportamento = 'BOM';
          }
          if ($pessoaAnt->getComportamento() == '5')
          { $comportamento = 'INSUFICIENTE';
	      }
	      if ($pessoaAnt->getComportamento() == '6')
          { $comportamento = 'MAU';
          }
	      //echo $comportamento;
          $this->pdf->SetFont('Times','B',12);
          $this->pdf->Cell(round($this->pdf->GetStringWidth($comportamento)+3),5,$comportamento,0,1,'L');
	      $this->pdf->ln();
	    }
	    
        $this->pdf->SetFont('Times','',12);
        $this->pdf->Cell(177,5,'2ª PARTE',0,1,'L');
		$this->pdf->Line($this->pdf->GetX()+1,$this->pdf->GetY(),40,$this->pdf->GetY());
	    $this->pdf->ln();	
        //leitura do tempo de servico - alterado 06Mai08
        //$tempoSerPer = null;
		//$tempoSerPer = $this->rgrTempoSerPer->lerRegistro($dtInicio, $dtTermino, $pessoaAnt->getIdMilitar());
		if ($tempoSerPer != null)
        {   
			$this->pdf->SetLeftMargin(20.5);
			$this->pdf->Cell(140,5,$this->formataTexto('1. TEMPO COMPUTADO DE EFETIVO SERVIÇO (TC)',138),0,0,'L');
                        $this->pdf->Cell(27,5,$this->formataTempo($tempoSerPer->getTemComEfeSer()->getAno()) . ' a ' .
							$this->formataTempo($tempoSerPer->getTemComEfeSer()->getMes()) . ' m ' . 
							$this->formataTempo($tempoSerPer->getTemComEfeSer()->getDia()) . ' d ',0,1,'L');    
			$this->pdf->SetLeftMargin(20);
			$this->pdf->Cell(135,5,$this->formataTexto('a. Arregimentado',133),0,0,'L');
                        $this->pdf->Cell(27,5,$this->formataTempo($tempoSerPer->getArr()->getAno()) . ' a ' .
							$this->formataTempo($tempoSerPer->getArr()->getMes()) . ' m ' . 
							$this->formataTempo($tempoSerPer->getArr()->getDia()) . ' d ',0,1,'L');    
			//$this->pdf->SetLeftMargin(30);
			if ($tempoSerPer->getArr()->getTexto() != '')
				$this->pdf->SetLeftMargin(21.5);
				$this->pdf->WriteHTML($tempoSerPer->getArr()->getTexto());
				//$this->pdf->Cell(135,5,$tempoSerPer->getArr()->getTexto(),0,0,'L');
                        //if ($tempoSerPer->getArr()->getTexto() != '') $this->pdf->ln();

			//$this->pdf->SetLeftMargin(25);
                        $this->pdf->SetFont('Times','',12);
			$this->pdf->SetLeftMargin(20.5);
                        $this->pdf->ln();
			$this->pdf->Cell(135,5,$this->formataTexto('b. Não Arregimentado',133),0,0,'L');
                        $this->pdf->Cell(27,5,$this->formataTempo($tempoSerPer->getNArr()->getAno()) . ' a ' .
                                	$this->formataTempo($tempoSerPer->getNArr()->getMes()) . ' m ' .
                                        $this->formataTempo($tempoSerPer->getNArr()->getDia()) . ' d ',0,1,'L');
			//$this->pdf->SetLeftMargin(30);
			if ($tempoSerPer->getNArr()->getTexto() != ''){
				$this->pdf->SetLeftMargin(21.5);
				$this->pdf->WriteHTML($tempoSerPer->getNArr()->getTexto());
				$this->pdf->ln();
			}
			//$this->pdf->Cell(135,5,$tempoSerPer->getNArr()->getTexto(),0,0,'L');
                        //if ($tempoSerPer->getNArr()->getTexto() != '') $this->pdf->ln();

                        //$this->pdf->SetLeftMargin(20);
                        $this->pdf->SetFont('Times','',12);
			$this->pdf->SetLeftMargin(20.5);
			$this->pdf->ln();
			$this->pdf->Cell(140,5,$this->formataTexto('2. TEMPO NÃO COMPUTADO (TNC)',138),0,0,'L');
                        $this->pdf->Cell(27,5,$this->formataTempo($tempoSerPer->getTemNCom()->getAno()) . ' a ' .
							$this->formataTempo($tempoSerPer->getTemNCom()->getMes()) . ' m ' . 
							$this->formataTempo($tempoSerPer->getTemNCom()->getDia()) . ' d ',0,1,'L');    
			//$this->pdf->SetLeftMargin(25);
			if ($tempoSerPer->getTemNCom()->getTexto() != ''){
				$this->pdf->SetLeftMargin(21.5);
				$this->pdf->WriteHTML($tempoSerPer->getTemNCom()->getTexto());
				$this->pdf->ln();
			}
			//$this->pdf->Cell(135,5,$tempoSerPer->getTemNCom()->getTexto(),0,0,'L');
                        //if ($tempoSerPer->getTemNCom()->getTexto() != '') $this->pdf->ln();

                        //$this->pdf->SetLeftMargin(20);
                        $this->pdf->SetFont('Times','',12);
			$this->pdf->SetLeftMargin(20.5);
                        $this->pdf->ln();
                        $this->pdf->Cell(140,5,$this->formataTexto('3. TEMPO DE SERVIÇO COMPUTÁVEL PARA MEDALHA MILITAR',138),0,0,'L');
                	$this->pdf->Cell(27,5,$this->formataTempo($tempoSerPer->getTemMedMil()->getAno()) . ' a ' .
                            $this->formataTempo($tempoSerPer->getTemMedMil()->getMes()) . ' m ' .
                            $this->formataTempo($tempoSerPer->getTemMedMil()->getDia()) . ' d ',0,1,'L');
			//$this->pdf->SetLeftMargin(25);
//			$this->pdf->Cell(135,5,$this->formataTexto('até '.$dtTermino->GetcDataDDBMMBYYYY().' (TSCMM)',133),0,0,'L');
			if ($tempoSerPer->getTemMedMil()->getTexto() != ''){
				$this->pdf->SetLeftMargin(21.5);
				$this->pdf->WriteHTML($tempoSerPer->getTemMedMil()->getTexto());
				$this->pdf->ln();
			}
			//$this->pdf->Cell(135,5,$tempoSerPer->getTemMedMil()->getTexto(),0,0,'L');
                        //if ($tempoSerPer->getTemMedMil()->getTexto() != '') $this->pdf->ln();

                        //$this->pdf->SetLeftMargin(20);
                        $this->pdf->SetFont('Times','',12);
			$this->pdf->SetLeftMargin(20.5);
			$this->pdf->ln();
			$this->pdf->Cell(140,5,$this->formataTexto('4. TEMPO DE SERVIÇO NACIONAL RELEVANTE (TSNR)',138),0,0,'L');
                        $this->pdf->Cell(27,5,$this->formataTempo($tempoSerPer->getSerRel()->getAno()) . ' a ' .
							$this->formataTempo($tempoSerPer->getSerRel()->getMes()) . ' m ' . 
							$this->formataTempo($tempoSerPer->getSerRel()->getDia()) . ' d ',0,1,'L');    
			//$this->pdf->SetLeftMargin(25);
			if ($tempoSerPer->getSerRel()->getTexto() != ''){
				$this->pdf->SetLeftMargin(21.5);
				$this->pdf->WriteHTML($tempoSerPer->getSerRel()->getTexto());
				$this->pdf->ln();
			}
			//$this->pdf->Cell(135,5,$tempoSerPer->getSerRel()->getTexto(),0,0,'L');
                        //if ($tempoSerPer->getSerRel()->getTexto() != '') $this->pdf->ln();

                        //$this->pdf->SetLeftMargin(20);
                        $this->pdf->SetFont('Times','',12);
			$this->pdf->SetLeftMargin(20.5);
                        $this->pdf->ln();
			$this->pdf->Cell(140,5,$this->formataTexto('5. TEMPO TOTAL DE EFETIVO SERVIÇO (TTES)',138),0,0,'L');
                	$this->pdf->Cell(27,5,$this->formataTempo($tempoSerPer->getTotEfeSer()->getAno()) . ' a ' .
				$this->formataTempo($tempoSerPer->getTotEfeSer()->getMes()) . ' m ' .
				$this->formataTempo($tempoSerPer->getTotEfeSer()->getDia()) . ' d ',0,1,'L');
			//$this->pdf->SetLeftMargin(25);
			if ($tempoSerPer->getTotEfeSer()->getTexto() != ''){
				$this->pdf->SetLeftMargin(21.5);
				$this->pdf->WriteHTML($tempoSerPer->getTotEfeSer()->getTexto());
			}
			//$this->pdf->Cell(140,5,$tempoSerPer->getTotEfeSer()->getTexto(),0,0,'L');
			//$this->pdf->SetLeftMargin(20);
		    $this->pdf->ln(10);	
   			//$this->pdf->SetLeftMargin(20);
		    if (date('d') == '01')
			{ $dia = date('j') . 'º';
			} else{
			  $dia = date('d');
			}
			$mesAtual = $aMeses[date('n')];
                        $this->pdf->SetFont('Times','',12);
                    $this->pdf->Cell(177,5,'Quartel ' . $this->om->getLoc() . ', ' . $dia . ' de ' .
									 $mesAtual . ' de ' . date('Y'),0,1,'C');
	      
        	$militarAss = $this->rgrMilitar->lerRegistro($tempoSerPer->getmilitarAss()->getIdMilitar());
		    if ($militarAss == null)
		    { throw new Exception('Militar que assina não está cadastrado');
		    }
	        $funcaoAss = $this->rgrFuncao->lerRegistro($militarAss->getFuncao()->getCod());
	        if ($funcaoAss == null)
	        { throw new Exception('Função do Militar que assina não está cadastrada');
	        }
	        $pGradAss = $this->rgrPGrad->lerRegistro($militarAss->getPGrad()->getCodigo());
	        if ($pGradAss == null)
		    { throw new Exception('Posto/Graduação do Militar que assina não está cadastrado');
	        }
		    $this->pdf->ln(6);	
	        $this->imprimirCampoAssinatura($pGradAss, $militarAss, $funcaoAss);
          }
          else
          { $this->pdf->Cell(177,5,'Não há registro de tempo de serviço para este período',0,1,'L');
          }
	  }//fim do loop completo
	}//fim da funcao
    /**
    * Esta funcao imprime o campo com o nome de quem assinara as alteracoes do militar
    *
    * @param $pGradAssina, posto de quem assinara as alteracoes
    * @param $militarAssina, nome do militar que assinara as alteracoes
    * @param $funcaoAssina, funcao do militar que assinara as alteracoes
    */
    private function imprimirCampoAssinatura($pGradAssina, $militarAssina, $funcaoAssina)
    { $linha = '_';
	  $nome = strtoupper($militarAssina->getNome());
	  $nome = strtr($nome,'áéíóúãõâêôçäëïöü','ÁÉÍÓÚÃÕÂÊÔÇÄËÏÖÜ');
      if (($pGradAssina->getCodigo() == 2) or ($pGradAssina->getCodigo() == 3) 
	  			or ($pGradAssina->getCodigo() == 4) or ($pGradAssina->getCodigo() == 18))
      { $texto = $pGradAssina->getDescricao() . ' ' . $nome;
      }
      else
      { $texto = $nome . ' - ' . $pGradAssina->getDescricao();
      }

	  if ($_SESSION['IMPRIMEASSINATURA']=='S')
	  	  if ($militarAssina->getAssinatura()!=null){
	  	  	  $absissa = (210 - round($this->pdf->GetStringWidth($texto))+4)/2;
		      $this->pdf->Image($this->bandIniFile->getAssinaturaDir().$militarAssina->getAssinatura(),$absissa,$this->pdf->GetY(),round($this->pdf->GetStringWidth($texto))+4,17);
	  	  }else{
		      //1-imprimir linha centralizada para assinatura 
			  while (round($this->pdf->GetStringWidth($linha)) < round($this->pdf->GetStringWidth($texto))+4)
			  { $linha = $linha.'_';
	  		  }
			  $this->pdf->ln();	
			  $this->pdf->Cell(176,4,$linha,0,1,'C');
	      }
	  else{
	      //1-imprimir linha centralizada para assinatura 
		  while (round($this->pdf->GetStringWidth($linha)) < round($this->pdf->GetStringWidth($texto))+4)
		  { $linha = $linha.'_';
  		  }
		  $this->pdf->ln();	
		  $this->pdf->Cell(176,4,$linha,0,1,'C');
	  }

/*	  while (round($this->pdf->GetStringWidth($linha)) < round($this->pdf->GetStringWidth($texto))+16)
	  { $linha = $linha.'_';
	  }
	  $this->pdf->ln(6);	
      //1-imprimir linha centralizada para assinatura 
	  $this->pdf->Cell(180,4,$linha,0,1,'C');*/

      //2-imprimir posto/nome da autoridade que assina
      $this->pdf->SetFont('Times','B',12);
	  $this->pdf->Cell(176,4,$texto,0,1,'C');
      
      //3-imprimir funcao da autoridade que assina
      $this->pdf->SetFont('Times','',12);
	  $this->pdf->Cell(176,4,$funcaoAssina->getDescricao(),0,1,'C');
    }
    /**
    * Esta funcao formata o tempo de servico, ascrescentando 0 a esquerda, caso o tempo seja menor que 10
    *
    * @param entrada $tempo
    *
    * @return retorna o tempo formatado
	*/    
   	private function formataTempo($tempo)
	{ if ($tempo < 10)
	  { $tempo = '0'.$tempo;
	  }
	  return $tempo;
	}
    /**
    * Esta funcao formata o texto dos tempos de servico, ascrescentando o caracter "." até atingir a largura determinada
    *
    * @param entrada $texto, $largura
    *
    * @return retorna o texto formatado com o caracter "."
	*/    
   	private function formataTexto($texto,$largura){
	    while (round($this->pdf->GetStringWidth($texto)) < $largura)
        { $texto = $texto.'.';
        }
		return $texto;
	}
  }//fim da classe
?>
