<?php
  class ConGerarFicha
  { private $rgrOM;
    private $rgrMilitar;
    private $rgrFuncao;
    private $rgrPGrad;
    private $rgrTempoSerPer;
    private $om;
    private $militar;
    private $nomeFonte;
    private $tamFonte;
    public function ConGerarFicha($rgrOM, $rgrMilitar, $rgrFuncao, $rgrPGrad, $rgrTempoSerPer, $bandIniFile)
    {  $this->rgrOM = $rgrOM;
       $this->rgrMilitar = $rgrMilitar;
       $this->rgrFuncao = $rgrFuncao;
       $this->rgrPGrad = $rgrPGrad;
       $this->rgrTempoSerPer = $rgrTempoSerPer;
       $this->bandIniFile = $bandIniFile;
       $this->tamFonte = 12;
	   $this->nomeFonte = 'Times';    
    }
    /**
    * Esta funcao prepara para a geracao das ficha de identificação de um conjunto de militares
    * Nao retorna nada, mas gera um arquivo PDF contendo as fichas dos militares solicitados
    *
    * @param $colMilitar2, colecao de militares
    */
    public function GerarFicha($colMilitar2)
    {
      /**
	  * captura as informações da OM
      */
      $this->om = $this->rgrOM->lerRegistro();
      
	  /**
	  * PREPARA PARA GERAR O PDF
	  */
	  $fpdfFontDir = $this->bandIniFile->getFPDFFontDir();
	  $outPutFicDir = $this->bandIniFile->getOutPutFicDir();
      define("FPDF_FONTPATH",$fpdfFontDir);
      $this->pdf = new MeuPDFFic('P','mm','A4'); 
      $this->pdf->setOM($this->om);
      //gerar para um subconjunto de militares
      if ($colMilitar2 != null)
      { $contMil = $colMilitar2->getQTD();
	  	$militar = $colMilitar2->iniciaBusca1();
	    $pGrad = $this->rgrPGrad->lerRegistro($militar->getPGrad()->getCodigo());
        if ($pGrad == null)
        { throw new Exception('Posto/Graduação do(a) ' . $pGrad->getDescricao() . ' ' . $militar->getNomeGuerra() . 
			'  não está cadastrado!');
		  return;
        }
        while ($militar != null)
   	    { 
   	    	$filtro = "id_militar_alt = '" . $militar->getIdMilitar() . "' and 
			   			data_in in (select max(data_in) from tp_sv_per where id_militar_alt = '" . 
						   	$militar->getIdMilitar()."')";
	        $colTempoSerPer2 = null;
			$colTempoSerPer2 = $this->rgrTempoSerPer->lerColecao($filtro,null);
			$tempoSerPer = $colTempoSerPer2->iniciaBusca1();
			if ($tempoSerPer!=null)
	      	{ $militarAss = $this->rgrMilitar->lerRegistro($tempoSerPer->getmilitarAss()->getIdMilitar());
			} else {
			  $militarAss = null;
			}
		    if ($militarAss == null)
		    { throw new Exception('Militar que assina a Ficha do(a) ' . $pGrad->getDescricao() . ' ' . 
									$militar->getNomeGuerra() . ' não está cadastrado!\nCadastre-o a partir do lançamento de tempo de serviço');
		      return;
		    }
    	    $funcaoAss = $this->rgrFuncao->lerRegistro($militarAss->getFuncao()->getCod());
	        if ($funcaoAss == null)
        	{ throw new Exception('Função do Militar que assina a Ficha do(a) ' . $pGrad->getDescricao() . ' ' . 
									$militar->getNomeGuerra() . ' não está cadastrada!');
		      return;
	        }
    	    $pGradAss = $this->rgrPGrad->lerRegistro($militarAss->getPGrad()->getCodigo());
        	if ($pGradAss == null)
		    { throw new Exception('Posto/Graduação do Militar que assina a Ficha do(a) ' . $pGrad->getDescricao() . ' ' . 
									$militar->getNomeGuerra() . ' não está cadastrado!');
		      return;
    	    }
		    $this->gerarFichaIndiv($militar,$militarAss,$funcaoAss,$pGradAss);
       	    $militar = $colMilitar2->getProximo1();
        }
		if ($contMil == 1){
	   	    $militar = $colMilitar2->iniciaBusca1();
                    /* PARREIRA - 23-05-2013 - Acrescentado letras maiúsculas no strtolower */
		    $nomeGuerra = strtr(strtolower($militar->getNomeGuerra()),'áéíóúãõâêôçäëïöüÁÉÍÓÚÃÕÂÊÔÇÄËÏÖÜ','aeiouaoaeocaeiouaeiouaoaeocaeiou');
                    
		} 
                
				$nomeArq = $contMil==1?
		/* Alterado por Ten S.Lopes -- 19/03/2012 -- código anterior:
								$nomeArq = $contMil==1?
							    ereg_replace('º','',
 							   	   ereg_replace(' ','',strtolower($pGrad->getDescricao()))) . '_' 
						        . ereg_replace(' ','_',$nomeGuerra) . '.pdf'
							  :
							    ereg_replace('º','',
								  ereg_replace(' ','',strtolower($pGrad->getDescricao()))) . '.pdf';

							"ereg_replace" depreciado na Versão do PHP 5.3

								  */
								  
                                       
                                        
							    str_replace('º','',
 							   	   str_replace(' ','',strtolower($pGrad->getDescricao()))) . '_' 
						        . str_replace(' ','_',$nomeGuerra) . '.pdf'
							  :
							    str_replace('º','',
								  str_replace(' ','',strtolower($pGrad->getDescricao()))) . '.pdf';
								  
								  
        //die($outPutFicDir.$nomeArq);
		
		$this->pdf->Output($outPutFicDir.$nomeArq,"F");
		return($outPutFicDir.$nomeArq);
      }
    }
    /**
    * Esta funcao gera as fichas de identificação de um conjunto de militares
    * escreve num arquivo PDF contendo as fichas dos militares solicitados
    *
    * @param $militar, militar que tera a ficha gerada, se nulo gera para todos
    */
    public function gerarFichaIndiv($militar,$militarAss,$funcaoAss,$pGradAss)
    { $aMesAbrev = array(1 => 'Jan', 'Fev', 'Mar', 'Abr', 'Maio', 'Jun', 'Jul', 'Ago', 'Set', 
	    'Out', 'Nov', 'Dez');
      $aMeses = array(1 => 'janeiro', 'fevereiro', 'março', 'abril', 'maio', 'junho', 'julho', 'agosto', 'setembro', 
	    'outubro', 'novembro', 'dezembro');
		
		$this->pdf->setPessoa($militar);
        $this->pdf->setPagina(0);
				
		$this->pdf->SetMargins(20,20,20);
	  	$this->pdf->SetFont('Times','',12);
		$this->pdf->AddPage();
//	    $this->pdf->ln();	
	    //print_r($militar);
	    $this->pdf->SetLeftMargin(22);
//        $this->pdf->Cell(177,5,'NOME: '.$this->imprimeNome($militar->getNome(),$militar->getNomeGuerra()),0,1,'L');
        $this->pdf->Cell(16,5,'NOME: ',0,0,'L');
        $this->pdf->Cell(177,5,$this->imprimeNome($militar->getNome(),$militar->getNomeGuerra()),0,1,'L');
        $this->pdf->ln(3);
		$cp = substr_replace($militar->getCp(), '-', strlen($militar->getCp()) - 1, 0); 
        $this->pdf->Cell(177,5,'CÓDIGO PESSOAL(CP): '.$cp,0,1,'L');
/*        if ($militar->getNomePai() <> ''){
	        $filiacao = $militar->getNomePai();
	        if ($militar->getNomeMae() <> ''){
		        $filiacao= $filiacao.' e '.$militar->getNomeMae();
	    	}
	    }else{
	        if ($militar->getNomeMae() <> ''){
		        $filiacao = $militar->getNomeMae();
	    	}
	    }*/
        $this->pdf->ln(3);
//        $this->pdf->Cell(177,5,'FILIAÇÃO: '.$filiacao,0,1,'L');
        $this->pdf->Cell(22,5,'FILIAÇÃO: ',0,0,'L');
		$largPai = round($this->pdf->GetStringWidth($militar->getNomePai()));
		$largMae = round($this->pdf->GetStringWidth($militar->getNomeMae()));
        if (($militar->getNomePai() <> '') and ($militar->getNomeMae() <> '')){
	        $this->pdf->Cell($largPai,5,trim($militar->getNomePai()) . ' e ',0,1,'L');
			$this->pdf->SetX(44);
	        $this->pdf->Cell($largMae,5,trim($militar->getNomeMae()),0,1,'L');
	    }else{
	        if ($militar->getNomePai() <> ''){
		        $this->pdf->Cell($largPai,5,trim($militar->getNomePai()),0,1,'L');
	    	}else{
	        	if ($militar->getNomeMae() <> ''){
		        	$this->pdf->Cell($largMae,5,trim($militar->getNomeMae()),0,1,'L');
		    	}else{
	    		    $this->pdf->ln(5);
		    	}
		    }
	    }
        $this->pdf->ln(3);
        $sexo = strtoupper($militar->getSexo())=='M'?'Masculino':'Feminino';
        $this->pdf->Cell(177,5,'SEXO: '.$sexo,0,1,'L');
        $this->pdf->ln(3);
		$cpf = substr_replace($militar->getCPF(), '-', strlen($militar->getCPF()) - 2, 0); 
        $this->pdf->Cell(177,5,'CPF: '.$cpf,0,1,'L');
        $this->pdf->ln(3);
        $dtNasc = explode("-",$militar->getDataNasc());
		$mesAbrev = $aMesAbrev[intval($dtNasc[1])];
        $this->pdf->Cell(177,5,'DATA DE NASCIMENTO: '. $dtNasc[2] . ' ' . $mesAbrev . ' ' . $dtNasc[0],0,1,'L');
        $this->pdf->ln(3);
        $this->pdf->Cell(177,5,'NATURAL DE: ' . $militar->getNaturalidade(),0,1,'L');
        $this->pdf->ln(3);
        $this->pdf->Cell(177,5,'ESTADO CIVIL: ' . $militar->getEstadoCivil(),0,1,'L');
        $this->pdf->ln(3);
		$idt = strlen($militar->getIdtMilitar())==10?substr_replace($militar->getIdtMilitar(), '-', strlen($militar->getIdtMilitar()) - 1, 0)
													:$militar->getIdtMilitar(); 
        $this->pdf->Cell(177,5,'NR DE REGISTRO DE IDENTIDADE: '.$idt,0,1,'L');
        $this->pdf->ln(3);
        $dtIdt = explode("/",$militar->getDataIdt());
		$mesAbrev = $aMesAbrev[intval($dtIdt[1])];
        $this->pdf->Cell(177,5,'DATA DA IDENTIFICAÇÃO: ' . $dtIdt[0] . ' ' . $mesAbrev . ' ' . $dtIdt[2],0,1,'L');
        $this->pdf->ln(3);
        $this->pdf->Cell(177,5,'CÚTIS: '.$militar->getCutis(),0,1,'L');
        $this->pdf->ln(3);
        $this->pdf->Cell(177,5,'CABELOS: '.$militar->getCabelos(),0,1,'L');
        $this->pdf->ln(3);
        $this->pdf->Cell(177,5,'BARBA: '.$militar->getBarba(),0,1,'L');
        $this->pdf->ln(3);
        $this->pdf->Cell(177,5,'BIGODE: ' . $militar->getBigode(),0,1,'L');
        $this->pdf->ln(3);
        $this->pdf->Cell(177,5,'ALTURA: '.$militar->getAltura().'m',0,1,'L');
        $this->pdf->ln(3);
        $this->pdf->Cell(177,5,'OLHOS: '.$militar->getOlhos(),0,1,'L');
        $this->pdf->ln(3);
        $this->pdf->Cell(177,5,'TIPO SANGÜÍNEO: "'.$militar->getTipoSang().'"',0,1,'L');
        $this->pdf->ln(3);
		$fatorRH = strtoupper($militar->getFatorRH())=='P'?'Positivo':'Negativo';
        $this->pdf->Cell(177,5,'FATOR RH: '.$fatorRH,0,1,'L');
        $this->pdf->ln(3);
        $this->pdf->MultiCell(177,5,'SINAIS PARTICULARES: '.$militar->getSinaisParticulares(),0,'J');
        $this->pdf->ln(3);
        $this->pdf->MultiCell(177,5,'OUTRAS NOTAS: ' . $militar->getOutros(),0,'J');
        $this->pdf->ln(10);
        
		$this->pdf->SetLeftMargin(20);
	    if (date('d') == '01')
		{ $dia = date('j') . 'º';
		} else{
		  $dia = date('d');
		}
		$mesAtual = $aMeses[date('n')];
        $this->pdf->Cell(177,5,'Quartel em ' . $this->om->getLoc() . ', ' . $dia . ' de ' .
								 $mesAtual . ' de ' . date('Y'),0,1,'C');
	    $this->pdf->ln(6);	
        $this->imprimirCampoAssinatura($pGradAss, $militarAss, $funcaoAss);
//	  }//fim do loop completo
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
      if (($pGradAssina->getCodigo() == 2) or ($pGradAssina->getCodigo() == 3) or ($pGradAssina->getCodigo() == 4) or ($pGradAssina->getCodigo() == 18))
      { $texto = $pGradAssina->getDescricao() . ' ' . $nome;
      }
      else
      { $texto = $nome . ' - ' . $pGradAssina->getDescricao();
      }
	  while (round($this->pdf->GetStringWidth($linha)) < round($this->pdf->GetStringWidth($texto))+4)
	  { $linha = $linha.'_';
	  }
	  $this->pdf->ln(6);	
      //1-imprimir linha centralizada para assinatura 
	  $this->pdf->Cell(180,4,$linha,0,1,'C');

      //2-imprimir posto/nome da autoridade que assina
      $this->pdf->SetFont('Times','B',12);
	  $this->pdf->Cell(180,5,$texto,0,1,'C');
      
      //3-imprimir funcao da autoridade que assina
      $this->pdf->SetFont('Times','',12);
	  $this->pdf->Cell(180,5,$funcaoAssina->getDescricao(),0,1,'C');
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
	
	//recebe o nome completo e o nome de guerra e imprime o nome completo cm o nome de guerra destacado (em negrito)
	private function imprimeNome($nome,$nomeGuerra){
		$nome=strtoupper($nome);
	  	$nome = strtr($nome,'áéíóúãõâêôçäëïöü','ÁÉÍÓÚÃÕÂÊÔÇÄËÏÖÜ');
		$nomeGuerra=strtoupper($nomeGuerra);
	  	$nomeGuerra = strtr($nomeGuerra,'áéíóúãõâêôçäëïöü','ÁÉÍÓÚÃÕÂÊÔÇÄËÏÖÜ');
		$c1 = explode(" ",$nome);
		$c2 = explode(" ",$nomeguerra);
		$pri = 0;

	    if ($c2 != 0)
	    {
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
				        $this->pdf->SetFont($this->nomeFonte,'',$this->tamFonte);
//						$this->pdf->Cell((round($this->pdf->GetStringWidth($c1[$i]))-
//										  round($this->pdf->GetStringWidth(substr($c1[$i],0,1))))+1,5,
//										  substr($c1[$i],1,round($this->pdf->GetStringWidth($c1[$i]))),0,0,'L');
						$this->pdf->Write(5,substr($c1[$i],1,round($this->pdf->GetStringWidth($c1[$i]))).' ');
						$pri=1;
						break;//sai do for (palavras do nome de guerra)
					}else {
						//coloca a palavra em negrito
				        $this->pdf->SetFont($this->nomeFonte,'B',$this->tamFonte);
//				        $this->pdf->Cell(round($this->pdf->GetStringWidth($c1[$i])),5,$c1[$i],0,0,'L');
				        $this->pdf->Write(5,$c1[$i].' ');
						break;//sai do for (palavras do nome de guerra)
					}
				} else {
					//verifica se é a última palavra do for (palavras do nome de guerra)
					if ($c2[$j+1]==''){
				        $this->pdf->SetFont($this->nomeFonte,'',$this->tamFonte);
//				        $this->pdf->Cell(round($this->pdf->GetStringWidth($c1[$i])),5,$c1[$i],0,0,'L');
				        $this->pdf->Write(5,$c1[$i].' ');
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
	
  }//fim da classe
?>
