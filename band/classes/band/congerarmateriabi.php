<?php
  class ConGerarMateriaBi
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
	//bedin
	private $rgrQM;
    private $rgrTipoBol;
    private $rgrTipoDoc;
    private $rgrMateriaBi;
    private $rgrPessoaMateriaBi;
    private $bandIniFile;
    
    private $om;
    private $militar;
    private $nomeFonte;
    private $tamFonte;
    private $docRef;
    private $margemEsqdDoc;
	//bedin
    public function ConGerarMateriaBi($rgrOM, $rgrOMVinc, $rgrSubun, $rgrParteBoletim, $rgrSecaoParteBi, $rgrAssuntoGeral, $rgrAssuntoEspec,
      $rgrBoletim, $rgrAssinaConfereBi, $rgrMilitar, $rgrFuncao, $rgrPGrad, $rgrQM, $rgrTipoBol, $rgrTipoDoc, $rgrMateriaBi, 
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
	  //bedin
	  $this->rgrQM = $rgrQM;
      $this->rgrTipoBol = $rgrTipoBol;
      $this->rgrTipoDoc = $rgrTipoDoc;
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
    /**
    * Esta funcao prepara para a geracao das alteracoes de um conjunto de militares, num periodo especificado
    * Nao retorna nada, mas gera um arquivo PDF contendo as alteracoes dos militares solicitados
    *
    * @param $colMilitar2, colecao de militares
    * @param $dtInicio, data de inicio do periodo
    * @param $dtTermino, data de termino do periodo
    */
    public function gerarMateriaBi($materiaBi)
	{ 

	  //busca militar que assina a Matéria
	  $militarAssMat = $this->rgrMilitar->lerRegistro($materiaBi->getMilitarAss()->getIdMilitar());
	  $funcaoMilAssMat = $this->rgrFuncao->lerRegistro($militarAssMat->getFuncao()->getCod());
	  $pgradMilAssMat = $this->rgrPGrad->lerRegistro($militarAssMat->getPGrad()->getCodigo());

/*	  //busca militar que assina o Publique-se
	  $militarAssPub = $this->rgrMilitar->lerRegistro($materiaBi->getMilitarAssPub()->getIdMilitar());
	  $funcaoMilAssPub = $this->rgrFuncao->lerRegistro($militarAssPub->getFuncao()->getCod());
	  $pgradMilAssPub = $this->rgrPGrad->lerRegistro($militarAssPub->getPGrad()->getCodigo());
*/

      $tipoBol = $this->rgrTipoBol->lerRegistro($materiaBi->getTipoBol()->getCodigo());
	  $docRef = $this->rgrTipoDoc->lerRegistro($materiaBi->getTipoDoc()->getCodigo());
	  $ref = $docRef->getDescricao();
          if ($ref != 'Sem referencia'){
            if (($materiaBi->getNrDocumento() === 's/n')||($materiaBi->getNrDocumento() === 's/n')){
              $ref .= ' '.$materiaBi->getNrDocumento().' ';
            }elseif ($materiaBi->getNrDocumento() == null){
              $ref .= ' ';
            }else {
              $ref .= ' nº '.$materiaBi->getNrDocumento().' ';
            }
            $ref .= ' de '.$materiaBi->getDataDoc()->GetcDataDDBMMBYYYY();
	  }else{
              $ref='';
          }

	  $funcaoAssina = $this->rgrFuncao->lerFuncaoQueAssinaPubliquese();
      if ($funcaoAssina == null)
      { throw new Exception('Função que assina publique-se não está cadastrada');
      }

      $militarAssina = $this->rgrMilitar->lerMilitarQueExerceFuncao($funcaoAssina->getCod());
      if ($militarAssina == null)
      { throw new Exception('Militar que assina o publique-se da nota para boletim não está cadastrado');
      }

      $pGradAssina = $this->rgrPGrad->lerRegistro($militarAssina->getPGrad()->getCodigo());
      if ($pGradAssina == null)
      { throw new Exception('Posto/Graduação do Militar que assina o publique-se da nota para boletim não está cadastrado');
      }

      
      //LOGO QUE SERÁ COLOCADO NO RELATÓRIO 
//      $img = "C:/Arquivos de programas/VertrigoServ/www/band/imagens/brasao.jpg"; 
//      $img = $this->bandIniFile->getBrasaoDir() . "brasao.jpg"; 
      $img = "brasao.jpg"; 

      //captura as informações da OM
      $om = $this->rgrOM->lerRegistro();
      $omVinc = $this->rgrOMVinc->lerRegistro($materiaBi->getCodom());
      $siglaOmVinv = $omVinc->getSigla();
      $subun = $this->rgrSubun->lerRegistro($materiaBi->getCodom(), $materiaBi->getCodSubun());
      $siglaSubun = $subun->getSigla();

      //captura as informações das Partes/Seções
//      $colParteBi = $this->rgrParteBoletim->lerColecao('numero_parte');

      //PREPARA PARA GERAR O PDF
      $fpdfFontDir = $this->bandIniFile->getFPDFFontDir();
	  $outputNotaBiDir = $this->bandIniFile->getOutPutNotaBiDir();
	  $brasaoDir = $this->bandIniFile->getBrasaoDir();
	  //echo str_replace("\\","/",__FILE__);
	  //die($this->bandIniFile->getBrasaoDir());

	  //preparacao
      define("FPDF_FONTPATH", $fpdfFontDir);
//	  $this->pdf = new MeuPDF('P','mm','A4', $ultPag, $tipoBol, $boletim, $pGradAssina, $militarAssina, 
//	  							$funcaoAssina); 
  	  $this->pdf = new meuhtml2fpdf_materiabi('P','mm','a4', $materiaBi, $tipoBol, $pgradMilAssMat, $militarAssMat, 
	  							$funcaoMilAssMat, $OM, $this->margemEsqdDoc, $siglaSubun);
	  $this->pdf->SetMargins($this->margemEsqDoc,20,15);
	  $this->pdf->SetAutoPageBreak(true,18);
	  $this->pdf->SetFont('Times','',12);
	  $this->pdf->AddPage();
      	  
	  
	  //cabecalho
	  $aDia = array('Sunday' => 'Domingo','Monday' => 'Segunda-feira', 'Tuesday' => 'Terça-feira',
	  				 'Wednesday' => 'Quarta-feira', 'Thursday' => 'Quinta-feira', 'Friday' => 'Sexta-feira',
	  				 'Saturday' => 'Sábado');
	  $aDia = $aDia[date('l',strtotime($materiaBi->getData()->GetcDataMMBDDBYYYY()))];	
	  $this->pdf->SetFont('Times','B',10);
	  //imprime a imagem do brasão das armas
	  if (file_exists($brasaoDir.'brasao.jpg')) {
	      $this->pdf->Image($brasaoDir.'brasao.jpg',93,15,23,25);
//	      $this->pdf->ln(24);
//	      $this->pdf->ln(1);
	  }else{
//	      $this->pdf->ln(4);
      }
	  $this->pdf->Cell(180,4,strtoupper($om->getSubd1()),0,1,'C');
	  $this->pdf->Cell(180,4,strtoupper($om->getSubd2()),0,1,'C');
	  if ($om->getSubd3() <> '')
//		  $this->pdf->Cell(180,4,strtoupper($OM->getSubd3()),0,1,'C');
		  $this->pdf->Cell(180,4,$om->getSubd3(),0,1,'C');
          if ($om->getSubd4() <> '')
		  $this->pdf->Cell(180,4,$om->getSubd4(),0,1,'C');
//	  $this->pdf->Cell(180,4,strtoupper($OM->getNome()),0,1,'C');
	  $this->pdf->Cell(180,4,$om->getNome(),0,1,'C');
	  if ($om->getDesigHist() <> '')
//		  $this->pdf->Cell(180,4,strtoupper($OM->getDesigHist()),0,1,'C');
		  $this->pdf->Cell(180,4,$om->getDesigHist(),0,1,'C');
	  $this->pdf->Cell(180,6,'',0,1,'C');
	  $this->pdf->SetFont('Times','',12);
	  if ($materiaBi->getData()->getIDia() == "1")
	  	$dia = "1º";
	  else
	  	$dia = $materiaBi->getData()->getIDia();
	  $this->pdf->Cell(180,4,'Nota nº '.$materiaBi->getCodigo().', de '. $dia .  ' de ' .
			    $materiaBi->getData()->getNomeMes2() . ' de ' . $materiaBi->getData()->getIAno() . ', da(o) ' . $siglaSubun,0,1,'L');
	  $this->pdf->Cell(75,4,'Para o '.$tipoBol->getDescricao(),0,0,'L');
	  $this->pdf->Cell(105,4,'Publique-se',0,1,'C'); 
	  $this->pdf->Cell(75,4,'',0,0,'L');
	  $this->pdf->Cell(105,4,'Em ____/________/____',0,1,'C'); 
	  $this->pdf->Cell(180,4,'',0,1,'C');
	  $this->pdf->Cell(180,4,'',0,1,'C');
	  $this->pdf->Cell(180,4,'',0,1,'C');
	  $this->pdf->Cell(180,4,'',0,1,'C');

	  $linha = '_______';
   	  $this->pdf->SetFont('Times','B',9);
      $nomeMilitar = strtoupper(strtr($militarAssina->getNome(),'áéíóúãõâêôçäëïöü','ÁÉÍÓÚÃÕÂÊÔÇÄËÏÖÜ'));      
      if (($pGradAssina->getCodigo() == 2) or ($pGradAssina->getCodigo() == 3) or ($pGradAssina->getCodigo() == 4)
	  			or ($pGradAssina->getCodigo() == 60))
      { $texto = $pGradAssina->getDescricao() . ' ' . $nomeMilitar;
      }
      else
      { $texto = $nomeMilitar . ' - ' . $pGradAssina->getDescricao();
      }

	  if ($_SESSION['IMPRIMEASSINATURA']=='S')
	  	  if ($militarAssina->getAssinatura()!=null){
	  	  	  $absissa = 76 + (125 - round($this->pdf->GetStringWidth($texto))+4)/2;
		      $this->pdf->Image($this->bandIniFile->getAssinaturaDir().$militarAssina->getAssinatura(),$absissa,$this->pdf->GetY(),round($this->pdf->GetStringWidth($texto))+4,17);
	  	  }else{
		      //1-imprimir linha centralizada para assinatura 
			  while (round($this->pdf->GetStringWidth($linha)) < round($this->pdf->GetStringWidth($texto))+4)
			  { $linha = $linha.'_';
	  		  }
			  $this->pdf->ln();	
		      $this->pdf->Cell(75,4,'',0,0,'C');
			  $this->pdf->Cell(105,4,$linha,0,1,'C');
	      }
	  else{
	      //1-imprimir linha centralizada para assinatura 
		  while (round($this->pdf->GetStringWidth($linha)) < round($this->pdf->GetStringWidth($texto))+4)
		  { $linha = $linha.'_';
  		  }
		  $this->pdf->ln();	
	      $this->pdf->Cell(75,4,'',0,0,'C');
		  $this->pdf->Cell(105,4,$linha,0,1,'C');
	  }
      
      //2-imprimir posto/nome da autoridade que assina
      $this->pdf->Cell(75,4,'',0,0,'C');
      $this->pdf->Cell(105,4,$texto,0,1,'C');

      //3-imprimir funcao da autoridade que assina
      $this->pdf->SetFont('Times','',9);
      $this->pdf->Cell(75,4,'',0,0,'C');
      $this->pdf->Cell(105,4,$funcaoAssina->getDescricao(),0,1,'C');
      $this->pdf->SetFont('Times','',12);

	  $this->pdf->SetX(15);	  	  
	  $this->pdf->SetMargins($this->margemEsqDoc,20,15);
	  $this->pdf->ln();
	  $this->pdf->ln();
//      $this->pdf->Cell(180,4,$materiaBi->getDescrAssGer(),1,1,'L');
	  $this->pdf->WriteHTML('<div style="text-align: justify;">'.$materiaBi->getDescrAssGer().'</div>',$this->margemEsqDoc);
      $this->pdf->SetFont('Times','',12);
	  if (substr($materiaBi->getDescrAssEsp(),0,1) != "(")
//	      $this->pdf->Cell(180,4,$materiaBi->getDescrAssEsp(),1,1,'L');
//	      $this->pdf->WriteHTML($materiaBi->getDescrAssEsp());
		  $this->pdf->WriteHTML('<div style="text-align: justify;">'.$materiaBi->getDescrAssEsp().'</div>',$this->margemEsqDoc);
      $this->pdf->SetFont('Times','',12);
//      $this->pdf->WriteHTML($materiaBi->getTextoAbert());
      if ($materiaBi->getTextoAbert()!=null){
	  $this->pdf->ln();
           $this->pdf->WriteHTML('<div style="text-align: justify;">'.$materiaBi->getTextoAbert().'</div>',$this->margemEsqDoc);
      }
          //$this->pdf->ln();
	  $colPessoaMateriaBi = $this->rgrPessoaMateriaBi->lerColecao($materiaBi->getCodigo());
	  $this->varrePessoas($colPessoaMateriaBi,$fachadaSist2);
      $this->pdf->SetFont('Times','',12);
      $this->pdf->ln();
	  $this->pdf->WriteHTML('<div style="text-align: justify;">'.$materiaBi->getTextoFech().'</div>',$this->margemEsqDoc);

	  $this->imprimiCampoAssinatura($pgradMilAssMat, $militarAssMat, $funcaoMilAssMat);

      $this->pdf->SetFont('Times','',12);
      //$this->pdf->SetY(-43);
      $this->pdf->ln(5);
      $this->pdf->Cell(180,4,'-------------------------------------------------------------------------------------------------------------------------------',0,1,'L'); 
      $this->pdf->Cell(180,4,'Publicado no '.$tipoBol->getDescricao().' nº ______, de ____/_______/____, item _______',0,1,'L'); 
      $this->pdf->Cell(180,4,'-------------------------------------------------------------------------------------------------------------------------------',0,1,'L'); 

      $this->pdf->Cell(180,4,'Referência: '.$ref,0,1,'L'); 
      $this->pdf->Cell(180,4,'-------------------------------------------------------------------------------------------------------------------------------',0,1,'L');

	  //SAIDA DO PDF
   		$tipoBi = strtolower(strtr($tipoBol->getDescricao(),'áéíóúãõâêôçäëïöüÁÉÍÓÚÃÕÂÊÔÇÄËÏÖÜ','aeiouaoaeocaeiouAEIOUAOAEOCAEIOU'));
		// Alterado por Ten S.Lopes -- 14/03/2012 -- código anterior = "$tipoBi = ereg_replace('ª','',$tipoBi);" ereg_replace Depreciado na Versão do PHP 5.3
		$tipoBi = str_replace('ª','',$tipoBi);
		
		// Alterado por Ten S.Lopes -- 14/03/2012 -- código anterior = "$tipoBi = ereg_replace('º','',$tipoBi);" ereg_replace Depreciado na Versão do PHP 5.3
		$tipoBi = str_replace ('º','',$tipoBi);

		$arq = $outputNotaBiDir.$materiaBi->getDataDoc()->getcDataYYYYHMMHDD() . "_" . $materiaBi->getCodigo() . "_nota_" . $tipoBi . ".pdf";
//  	    	$this->formataNumBi($boletim->getNumeroBi()) . '_' . ereg_replace(' ','_',strtolower($tipoBol->getDescricao())) . ".pdf" ;
//  	    	$this->formataNumBi($materiaBi->getNumeroBi()) . '_' . ereg_replace(' ','_',$tipoBi) . ".pdf" ;
		$this->pdf->Output($arq, "F");

      return $arq;
    }
    
    public function imprimiCampoAssinatura($pGradAssina, $militarAssina, $funcaoAssina)
    { $linha = '_';
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
	  $this->pdf->ln();	

	  //se a posicao vertical esta proximo do final, imprime linhas em branco ate quebrar a pagina
	  while ($this->pdf->GetY() > 270){
		$this->pdf->Cell(180,4,'',0,1,'C');
	  }

	  //$this->pdf->Cell(180,4,$this->bandIniFile->getAssinaturaDir().$militarAssina->getAssinatura(),0,1,'C'); 
	
	  if ($_SESSION['IMPRIMEASSINATURA']=='S')
	  	  if ($militarAssina->getAssinatura()!=null){
	  	  	  $absissa = (200 - round($this->pdf->GetStringWidth($texto))+4)/2;
		      $this->pdf->Image($this->bandIniFile->getAssinaturaDir().$militarAssina->getAssinatura(),$absissa,$this->pdf->GetY(),round($this->pdf->GetStringWidth($texto))+4,17);
	  	  }else{
		      //1-imprimir linha centralizada para assinatura 
			  while (round($this->pdf->GetStringWidth($linha)) < round($this->pdf->GetStringWidth($texto))+4)
			  { $linha = $linha.'_';
	  		  }
			  $this->pdf->ln();	
	    	  $this->pdf->SetFont('Times','',12);
			  $this->pdf->Cell(180,4,$linha,0,1,'C');
	      }
	  else{
	      //1-imprimir linha centralizada para assinatura 
		  while (round($this->pdf->GetStringWidth($linha)) < round($this->pdf->GetStringWidth($texto))+4)
		  { $linha = $linha.'_';
  		  }
		  $this->pdf->ln();	
    	  $this->pdf->SetFont('Times','',12);
		  $this->pdf->Cell(180,4,$linha,0,1,'C');
	  }

      //2-imprimir posto/nome da autoridade que assina
      $this->pdf->SetFont('Times','B',12);
	  $this->pdf->Cell(180,5,$texto,0,1,'C');
      
      //3-imprimir funcao da autoridade que assina
      $this->pdf->SetFont('Times','',12);
	  $this->pdf->Cell(180,4,$funcaoAssina->getDescricao(),0,1,'C');
    }

	function varrePessoas($colPessoaMateriaBi,$fachadaSist2){
		$saida = "";
        $pessoaMateriaBi = $colPessoaMateriaBi->iniciaBusca1();
        $qtePessoa = $colPessoaMateriaBi->getQTD();
        $contaPessoa = 0;
		$pessoaAnteriorTemTextoIndiv=0;					    
        while ($pessoaMateriaBi != null){
        	if ($contaPessoa==0)
            	$this->pdf->ln();

            $contaPessoa+=1;
            $idMilitar = $pessoaMateriaBi->getPessoa()->getIdMilitar();
            $militar = $this->rgrMilitar->lerRegistro($idMilitar);
            if ($militar != null){
      			$pGrad = $this->rgrPGrad->lerRegistro($militar->getPGrad()->getCodigo());
					//bedin
				$qm = $this->rgrQM->lerRegistro($militar->getQM()->getCod());
				if ($_SESSION['IMPRIMENOMESLINHA']=='S'){
					$this->pdf->SetLeftMargin($this->margemEsqDoc+0.9);
			        $this->pdf->Write(5,$pGrad->getDescricao().' ');
						//bedin
					if ($_SESSION['IMPRIMEQMS']=='S'){
					$this->pdf->Write(5,$qm->getAbreviacao().' ');
					$this->imprimeNome(strtoupper(trim($militar->getNome())),trim($militar->getNomeGuerra()),$this->margemEsqDoc);
					}else{
					$this->imprimeNome(strtoupper(trim($militar->getNome())),trim($militar->getNomeGuerra()),$this->margemEsqDoc);}
					if (trim($pessoaMateriaBi->getTextoIndiv()) <> ''){
				    	$this->pdf->SetFont('Times','',12);
					    $this->pdf->WriteHTML('<div style="text-align: justify;">'.$pessoaMateriaBi->getTextoIndiv().'</div>',$this->margemEsqDoc);
            	        $milAntTemTextoIndiv==1;
					} else {
						if ($contaPessoa!=$qtePessoa)
		            		$this->pdf->ln();
    	            }
				}else{		
				//bedin
				if ($_SESSION['IMPRIMEQMS']=='S'){				
					$saida .= $pGrad->getDescricao(). ' ' . $qm->getAbreviacao(). ' ' .$this->setaNomeGuerra($militar->getNome(),$militar->getNomeGuerra());  
					}else{
					$saida .= $pGrad->getDescricao(). ' '.$this->setaNomeGuerra($militar->getNome(),$militar->getNomeGuerra());  }
				if (trim($pessoaMateriaBi->getTextoIndiv()) <> ''){
						$textoIndiv = preg_replace('<div style="text-align: justify;">',"",$pessoaMateriaBi->getTextoIndiv());
						$textoIndiv = preg_replace('</div>',"",$textoIndiv);
						$saida .= " (" . $textoIndiv . ")";
	       			}
					if ($contaPessoa!=$qtePessoa)
						$saida .= ", ";
					else
						$saida .= ".";
				}
            }
            $pessoaMateriaBi = $colPessoaMateriaBi->getProximo1();
        }
		if ($_SESSION['IMPRIMENOMESLINHA']!='S')
		    $this->pdf->WriteHTML('<div style="text-align: justify;">'.$saida.'</div>',$this->margemEsqDoc);
	}

	//retorna o nome completo com o nome de guerra setado
	function setaNomeGuerra($nome,$nomeguerra){
		$Retorno = '';
		$nome=strtoupper(trim($nome));
	  	$nome = strtr($nome,'áéíóúãõâêôçäëïöü','ÁÉÍÓÚÃÕÂÊÔÇÄËÏÖÜ');
		$nomeguerra=strtoupper(trim($nomeguerra));
	  	$nomeGuerra = strtr($nomeGuerra,'áéíóúãõâêôçäëïöü','ÁÉÍÓÚÃÕÂÊÔÇÄËÏÖÜ');
		$c1 = explode(" ",$nome);
		$c2 = explode(" ",$nomeguerra);
		$pri = 0;

		for ($i = 0; $i < count($c1); $i++) {		//percorre todas as palavras do nome
			for ($j = 0; $j < count($c2); $j++){			//percorre todas as palavras do nome de guerra
				//verifica se a palavra do nome é igual a palavra do nome de guerra
				//ou se a letra inicial do nome é igual a palavra do nome de guerra
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
					//verifica se é a última palavra do for (palavras do nome de guerra)
					if ($c2[$j+1]==''){
						$Retorno = $Retorno.$c1[$i];//coloca a palavra com o padrão normal
					}
				}
				$Retorno = $Retorno.' ';
			}
		}
		return $Retorno;
	}


    public function imprimeNome($nome,$nomeGuerra,$leftMargin)
    { 
		//rev 06
//		$nome=($nome);
		$this->pdf->SetLeftMargin($leftMargin+0.9);
		$nome = strtoupper($nome);
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
//                                        $this->pdf->WriteHTML(substr($c1[$i],0,1),$this->margemEsqDoc);
				        $this->pdf->SetFont($this->nomeFonte,'',$this->tamFonte);
//						$this->pdf->Cell((round($this->pdf->GetStringWidth($c1[$i]))-
//										  round($this->pdf->GetStringWidth(substr($c1[$i],0,1))))+1,5,
//										  substr($c1[$i],1,round($this->pdf->GetStringWidth($c1[$i]))),0,0,'L');
						$this->pdf->Write(5,substr($c1[$i],1,round($this->pdf->GetStringWidth($c1[$i]))).' ');
//                                                $this->pdf->WriteHTML(substr($c1[$i],1,round($this->pdf->GetStringWidth($c1[$i]))).' ',$this->margemEsqDoc);
						$pri=1;
						break;//sai do for (palavras do nome de guerra)
					}else {
						//coloca a palavra em negrito
				        $this->pdf->SetFont($this->nomeFonte,'B',$this->tamFonte);
//				        $this->pdf->Cell(round($this->pdf->GetStringWidth($c1[$i])),5,$c1[$i],0,0,'L');
				        $this->pdf->Write(5,$c1[$i].' ');
//                                        $this->pdf->WriteHTML($c1[$i].' ',$this->margemEsqDoc);
						break;//sai do for (palavras do nome de guerra)
					}
				} else {
					//verifica se é a última palavra do for (palavras do nome de guerra)
					if ($c2[$j+1]==''){
				        $this->pdf->SetFont($this->nomeFonte,'',$this->tamFonte);
//				        $this->pdf->Cell(round($this->pdf->GetStringWidth($c1[$i])),5,$c1[$i],0,0,'L');
				        $this->pdf->Write(5,$c1[$i].' ');
//                                        $this->pdf->WriteHTML($c1[$i].' ',$this->margemEsqDoc);
					}
				}
		        $this->pdf->SetFont($this->nomeFonte,'',$this->tamFonte);
//		        $this->pdf->Cell(1,5,' ',0,0,'L');
//		        $this->pdf->Write(5,' ');
			} // fim do 1º for
		  } //fim do 2º for
		}else{
//		   $this->pdf->Cell(100,5,strtoupper($nome),0,0,'L');
		   $this->pdf->Cell(5,$nome);
	    }
        $this->pdf->SetFont($this->nomeFonte,'',$this->tamFonte);
    }		
    
    
  }//fim da classe
?>
