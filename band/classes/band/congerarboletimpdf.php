<?
class ConGerarBoletimPDF extends ConGerarBoletim {
	private $rgrOM;
	private $rgrParteBoletim;
	private $rgrSecaoParteBi;
	private $rgrAssuntoGeral;
	private $rgrAssuntoEspec;
	private $rgrBoletim;
	private $rgrAssinaConfereBi;
	private $rgrMilitar;
	private $rgrFuncao;
	private $rgrPGrad;
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

	public function ConGerarBoletimPDF($rgrOM, $rgrOMVinc, $rgrSubun, $rgrParteBoletim, $rgrSecaoParteBi, $rgrAssuntoGeral, $rgrAssuntoEspec, $rgrBoletim, $rgrAssinaConfereBi, $rgrMilitar, $rgrFuncao, $rgrPGrad, $rgrTipoBol, $rgrMateriaBi, $rgrPessoaMateriaBi, $rgrPessoa, $bandIniFile) { /*$this->rgrOM = $rgrOM;
	     $this->rgrParteBoletim = $rgrParteBoletim;
	     $this->rgrSecaoParteBi = $rgrSecaoParteBi;
	     $this->rgrAssuntoGeral = $rgrAssuntoGeral;
	     $this->rgrAssuntoEspec = $rgrAssuntoEspec;
	     $this->rgrBoletim      = $rgrBoletim;
	     $this->rgrAssinaConfereBi = $rgrAssinaConfereBi;
	     $this->rgrMilitar = $rgrMilitar;
	     $this->rgrFuncao = $rgrFuncao;
	     $this->rgrPGrad = $rgrPGrad;
	     $this->rgrTipoBol = $rgrTipoBol;
	     $this->rgrMateriaBi = $rgrMateriaBi;
	     $this->rgrPessoaMateriaBi = $rgrPessoaMateriaBi;
	     $this->rgrPessoa = $rgrPessoa;
	     $this->bandIniFile = $bandIniFile;

		  $this->aLetras = array(1 => 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'l' , 'm', 'n', 'o', 'p', 'q',
		  								 'r', 's', 't', 'u', 'v', 'x', 'z');
		  $this->tamFonte = 9;
		  $this->nomeFonte = 'Courier';
		  $this->margemEsqDoc = 15;
		  */
		ConGerarBoletim :: ConGerarBoletim($rgrOM, $rgrOMVinc, $rgrSubun, $rgrParteBoletim, $rgrSecaoParteBi, $rgrAssuntoGeral, $rgrAssuntoEspec, $rgrBoletim, $rgrAssinaConfereBi, $rgrMilitar, $rgrFuncao, $rgrPGrad, $rgrTipoBol, $rgrMateriaBi, $rgrPessoaMateriaBi, $rgrPessoa, $bandIniFile);

		$this->aLetras = array (
			1 => 'a',
			'b',
			'c',
			'd',
			'e',
			'f',
			'g',
			'h',
			'i',
			'j',
			'l',
			'm',
			'n',
			'o',
			'p',
			'q',
			'r',
			's',
			't',
			'u',
			'v',
			'x',
			'z'
		);
		$this->tamFonte = 9;
		$this->nomeFonte = 'Courier';
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
	private function obterUltPag($boletim, $tipoBol) { //obter o numero do bi anterior
		$numeroBiAnt = $boletim->getNumeroBi() - 1;
		//se nao e o primeiro bi do ano
		if ($numeroBiAnt != 0) { //le o bi anterior
			$BoletimAnt = $this->rgrBoletim->lerPorNumeroBi($boletim->getTipoBol()->getCodigo(), $numeroBiAnt);
			//se existe anterior
			if ($BoletimAnt != null) {
				$ultPag = $BoletimAnt->getPagFinal();
			}
			//nao existe boletim anterior
			else {
				$ultPag = $tipoBol->getNrUltPag();
			}
		} else { // se e o nro do bi ant = 0, o primeiro boletim
			$ultPag = 0;
		}
		return $ultPag;
	}
	public function PDFImprimeNome($nome,$nomeGuerra) { //nome completo com as tags do nome de guerra
		$i = 0;
		$this->pdf->SetFont($this->nomeFonte, '', $this->tamFonte);
		$saida = '';
		while ($i <= strlen($nome)) { //se encontrar a tag a abertura
			if (substr($nome, $i, 3) == '<U>') { //se a saida nao for nula
				if ($saida != '') { //imprime a saida
					$this->pdf->Cell(round($this->pdf->GetStringWidth($saida)), 4, $saida, 0, 0, 'L');
				}
				//limpa a saida
				$saida = '';
				//pula os caracteres da tag de abertura
				$i = $i +3;
				//coloca em negrito
				$this->pdf->SetFont($this->nomeFonte, 'B', $this->tamFonte);
			}
			//se encontrar a tag de fechamento
			if (substr($nome, $i, 4) == '</U>') { //se a saida nao for nula
				if ($saida != '') { //imprime a saida
					$this->pdf->Cell(round($this->pdf->GetStringWidth($saida)), 4, $saida, 0, 0, 'L');
				}
				//limpa a saida
				$saida = '';
				//pula os caracteres da tag de fechamento
				$i = $i +4;
				//muda o fonte p normal
				$this->pdf->SetFont($this->nomeFonte, '', $this->tamFonte);
			}
			$saida = $saida . $nome[$i];
			$i = $i +1;
		}
		$this->pdf->Cell(round($this->pdf->GetStringWidth($saida)), 4, $saida, 0, 0, 'L');
		$this->pdf->ln();
	}
	public function PDFPrepara($fpdfFontDir, $ultPag, $tipoBol, $boletim, $pGradAssina, $militarAssina, $funcaoAssina, $outputBolDir, $OM) {
		define("FPDF_FONTPATH", $fpdfFontDir);
		$this->pdf = new MeuPDF('P', 'mm', 'A4', $ultPag, $tipoBol, $boletim, $pGradAssina, $militarAssina, $funcaoAssina);
		$this->pdf->SetMargins($this->margemEsqDoc, 20, 15);
		$this->pdf->SetAutoPageBreak(true, 17);
		$this->pdf->AddPage();
	}
	public function PDFImpTipoNumeroDescrBI($tipoBol, $boletim) {
		$this->pdf->SetFont('Times', 'B', 12);
		$this->pdf->Cell(180, 6, $tipoBol->getDescricao() . ' Nº ' . $boletim->getNumeroBi() . '/' . $boletim->getDataPub()->getIAno(), "TB", 1, 'C');
		$this->pdf->SetLineWidth(0.2);
		$this->pdf->ln(4);
		$this->pdf->Cell(180, 4, 'Para conhecimento deste aquartelamento e devida execução, publico o seguinte:', 0, 0, 'C');
		$this->pdf->ln();
		$this->pdf->ln();
	}
	public function PDFImprimeDescricaoParte($parteBi) {
		$this->pdf->SetFont('Times', 'B', 12);
		$this->pdf->Cell(180, 4, $parteBi->getDescrReduz(), 0, 0, 'C');
		$this->pdf->ln();
		$this->pdf->Cell(180, 4, $parteBi->getDescricao(), 0, 0, 'C');
		$this->pdf->ln();
		$this->pdf->ln();
	}
	//    public function PDFImprimeDescricaoSecao($secaoParteBi, $aLetras)
	public function PDFImprimeDescricaoSecao($secaoParteBi, $numSec) {
		$this->pdf->SetFont('Times', 'B', 12);
		//      $this->pdf->Cell(180,4,$aLetras[$numSec] . '. '.$secaoParteBi->getDescricao(),0,0,'C');
		$this->pdf->Cell(180, 4, $numSec . '. ' . $secaoParteBi->getDescricao(), 0, 0, 'C');
		$this->pdf->ln();
		$this->pdf->ln();
	}
	//    public function PDFImprimeAssuntoGeral($ctAssuntoGeral, $assuntoGeral2)
	public function PDFImprimeAssuntoGeral($letra, $assuntoGeral2) {
		$this->pdf->SetFont('Times', '', 12);
		//	  $this->pdf->MultiCell(180,4,$this->ctAssuntoGeral .'. '. $assuntoGeral2->getDescricao(),0,'J',0);
		$this->pdf->MultiCell(180, 4, $letra . '. ' . $assuntoGeral2->getDescricao(), 0, 'J', 0);
		$this->pdf->ln();
	}
	public function PDFImprimeSemAlteracao($qteSec) {
		$this->pdf->SetFont('Times', '', 12);
		$this->pdf->Cell(180, 4, 'Sem Alteração', 0, 0, 'C');
		$this->pdf->ln();
		$this->pdf->ln();
	}
	//    public function PDFImprimeAssuntoEspec($aLetras, $assuntoEspec2, $ctAssuntoEspec)
	public function PDFImprimeAssuntoEspec($assuntoEspec2, $ctAssuntoEspec) {
		$this->pdf->MultiCell(180, 4, $ctAssuntoEspec . ') ' . $assuntoEspec2->getDescricao(), 0, 'L', 0);
		$this->pdf->ln();
	}
	public function PDFImprimeTextoAbertura($materiaBi, $ctMat) {
		$this->pdf->SetFont($this->nomeFonte, '', $this->tamFonte);
		if (trim($materiaBi->getTextoAbert()) <> '') {
			$this->pdf->MultiCell(180, 4, rtrim($ctMat . ') ' . $materiaBi->getTextoAbert()), 0, 'J', 0);
			$this->pdf->ln();
		}
	}
	public function PDFImprimeTextoFech($materiaBi) {
		if (trim($materiaBi->getTextoFech()) <> '') {
			$this->pdf->MultiCell(180, 4, rtrim($materiaBi->getTextoFech()), 0, 'J', 0);
			$this->pdf->ln();
		}
		$this->pdf->SetFont('Times', '', 12);
	}
	public function PDFImprimeRef($materiaBi,$subun) {
		$this->pdf->SetFont('Times', '', 12);
	}
	public function PDFImprimeTextoIndiv($pessoaMateriaBi) {
		$this->pdf->MultiCell(176, 4, rtrim($pessoaMateriaBi->getTextoIndiv()), 0, 'J', 0);
	}
	//retorna o numero da ultima pagina do bi atual, ou numero da pag corrente
	public function PDFGetUltPagBi($ultPag) {
		return $this->pdf->pageNo() + $ultPag;
	}
	public function PDFAvancaLinha($n) {
		for ($i = 0; $i < $n; $i++) {
			$this->pdf->ln();
		}
	}
	public function PDFGravarOutput($outputBolDir, $boletim, $tipoBol, $original) {
		$this->pdf->Output($outputBolDir . $boletim->getDataPub()->getIAno() . "_" .
		$boletim->getNumeroBi() . '_' . ereg_replace(' ', '_', $tipoBol->getDescricao()) . ".pdf", "F");
	}
	public function PDFImprimePGrad($pGrad) {
		$this->pdf->Cell(round($this->pdf->GetStringWidth($pGrad->getDescricao())) + 2, 4, $pGrad->getDescricao(), 0, 0, 'L');
	}
	public function PDFImprimeNomeCivil($pessoa) {
		$this->pdf->Cell(176, 4, $pessoa->getNome(), 0, 1, 'L');
		$this->pdf->ln();
	}
	public function PDFAlteraMargemEsq($margemEsqDoc) {
		$this->pdf->SetLeftMargin($margemEsqDoc);
	}
	//Incluído $boletim, para remover a imagem de assinatura caso não tenha sido assinado o BI - Sgt Bedin
	public function PDFImprimirCampoAssinatura($pGradAssina, $militarAssina, $funcaoAssina, $original, $boletim) {
		//Alterado $linha='_' para $linha=' '; devido alteração na legislação - Sgt Bedin 23/04/2013
		$linha = ' ';
		if (($pGradAssina->getCodigo == 1) or ($pGradAssina->getCodigo == 2) or ($pGradAssina->getCodigo == 3)) {
			$texto = $pGradAssina->getDescricao() . ' ' . $militarAssina->getNome();
		} else {
			$texto = $militarAssina->getNome() . ' - ' . $pGradAssina->getDescricao();
		}
		while (round($this->pdf->GetStringWidth($linha)) < round($this->pdf->GetStringWidth($texto)) + 4) {
			//Alterado $linha='_' para $linha=' '; devido alteração na legislação - Sgt Bedin 23/04/2013
			$linha = $linha . ' ';
		}
		$this->pdf->ln();
		//se a posicao vertical esta proximo do final, imprime linhas em branco ate quebrar a pagina

		while ($this->pdf->GetY() > 270) {
			$this->pdf->Cell(180, 4, '', 0, 1, 'C');
		}

		//1-imprimir linha centralizada para assinatura - Removido devido determinação da Legislação - Sgt Bedin 24/04/2013
		//$this->pdf->Cell(180, 4, $linha, 0, 1, 'C');

		//2-imprimir posto/nome da autoridade que assina
		$this->pdf->SetFont('Times', 'B', 12);
		$this->pdf->Cell(180, 5, $texto, 0, 1, 'C');

		//3-imprimir funcao da autoridade que assina
		$this->pdf->SetFont('Times', '', 12);
		$this->pdf->Cell(180, 4, $funcaoAssina->getDescricao(), 0, 1, 'C');
	}
	public function PDFImprimirCampoConfere($pGradConfere, $militarConfere, $funcaoConfere) {
		 //Alterado $linha='_' para $linha=' '; devido alteração na legislação - Sgt Bedin 23/04/2013
		$linha = ' ';
		$this->pdf->ln();
		$this->pdf->ln();
		//se a posicao vertical esta proximo do final, imprime linhas em branco ate quebrar a pagina
		while ($this->pdf->GetY() > 250) {
			$this->pdf->Cell(180, 4, '', 0, 1, 'C');
		}

		//confere com o original
		$this->pdf->Cell(180, 4, 'CONFERE COM O ORIGINAL:', 0, 1, 'L');
		$this->pdf->ln();
		$this->pdf->ln();
		$this->pdf->ln();

		if (($pGradConfere->getCodigo == 1) or ($pGradConfere->getCodigo == 2) or ($pGradConfere->getCodigo == 3)) {
			$texto = $pGradConfere->getDescricao() . ' ' . $militarConfere->getNome();
		} else {
			$texto = $militarConfere->getNome() . ' - ' . $pGradConfere->getDescricao();
		}
		while (round($this->pdf->GetStringWidth($linha)) < round($this->pdf->GetStringWidth($texto)) + 4) {
			 //Alterado $linha.'_' para $linha.' '; devido alteração na legislação - Sgt Bedin 23/04/2013
			$linha = $linha . ' ';
		}

		//imprimir linha alinhada a esquerda para assinatura do confere - Removido devido determinação da Legislação - Sgt Bedin 24/04/2013
		/*$this->pdf->Cell(180, 4, $linha, 0, 1, 'L');*/

		//imprimir posto/nome da autoridade que assina o confere
		$this->pdf->SetFont('Times', 'B', 12);
		$this->pdf->Cell(180, 5, $texto, 0, 1, 'L');

		//imprimir funcao da autoridade que assina o confere
		$this->pdf->SetFont('Times', '', 12);
		$this->pdf->Cell(round($this->pdf->GetStringWidth($texto)), 4, $funcaoConfere->getDescricao(), 0, 1, 'C');
	}
	public function PDFImprimirCabecalho($OM, $boletim, $img, $brasaoDir) {
		$aDia = array (
			'Sunday' => 'Domingo',
			'Monday' => 'Segunda-feira',
			'Tuesday' => 'Terça-feira',
			'Wednesday' => 'Quarta-feira',
			'Thursday' => 'Quinta-feira',
			'Friday' => 'Sexta-feira',
			'Saturday' => 'Sábado'
		);
		$aDia = $aDia[date('l', strtotime($boletim->getDataPub()->GetcDataMMBDDBYYYY()))];
		$this->pdf->SetFont('Times', 'B', 10);
		//imprime a imagem do brasão das armas
		if (file_exists($brasaoDir . 'brasao.jpg')) {
			$this->pdf->Image($brasaoDir . 'brasao.jpg', 93, 15, 23, 25);
			$this->pdf->ln(24);
		} else {
			$this->pdf->ln(4);
		}
		$this->pdf->Cell(180, 4, strtoupper($OM->getSubd1()), 0, 1, 'C');
		$this->pdf->Cell(180, 4, strtoupper($OM->getSubd2()), 0, 1, 'C');
		if ($OM->getSubd3() <> '')
			$this->pdf->Cell(180, 4, strtoupper($OM->getSubd3()), 0, 1, 'C');
                $this->pdf->Cell(180, 4, strtoupper($OM->getNome()), 0, 1, 'C');
		if ($OM->getDesigHist() <> '')
			$this->pdf->Cell(180, 4, strtoupper($OM->getDesigHist()), 0, 1, 'C');
                if ($OM->getSubd4() <> '')
			$this->pdf->Cell(180, 4, strtoupper($OM->getSubd4()), 0, 1, 'C');
		$this->pdf->Cell(180, 6, '', 0, 1, 'C');
		$this->pdf->SetFont('Times', '', 12);
		$this->pdf->Cell(180, 4, 'Quartel em ' . $OM->getLoc() . ', ' . $boletim->getDataPub()->getIDia() . ' de ' .
		$boletim->getDataPub()->getNomeMes() . ' de ' . $boletim->getDataPub()->getIAno(), 0, 1, 'C');
		$this->pdf->Cell(180, 4, '(' . $aDia . ')', 0, 1, 'C');
		$this->pdf->Cell(180, 4, '', 0, 1, 'C');
		$this->pdf->SetX(15);
	}
	/* FUNÇÃO PAI EM .../band/classes/band/congerarboletim.php -> Strict Standards no PHP 5.4.4-14 - Ten Slopes / Bedin 04/07/13
		private function varreAssuntoGeral() {
		while (($this->materiaBi != null) and ($this->assuntoGeral->getCodigo() == $this->materiaBi->getAssuntoGeral()->getCodigo())) {
			$this->assuntoEspec = $this->materiaBi->getAssuntoEspec();
			$assuntoEspec2 = $this->rgrAssuntoEspec->lerRegistro($this->assuntoGeral->getCodigo(), $this->assuntoEspec->getCodigo());
			$this->ctAssuntoEspec = $this->ctAssuntoEspec + 1;
			$this->PDFImprimeAssuntoEspec($this->aLetras, $assuntoEspec2, $this->ctAssuntoEspec);
			$this->varreAssuntoEspec();
		} //fim do loop ass geral
	
	private function varreAssuntoEspec() {
		$ctMat = 0;
		while (($this->materiaBi != null) and ($this->assuntoGeral->getCodigo() == $this->materiaBi->getAssuntoGeral()->getCodigo()) and ($this->assuntoEspec->getCodigo() == $this->materiaBi->getAssuntoEspec()->getCodigo())) {
			$ctMat = $ctMat +1;
			//marco
			//gravar o numero da pagina na materia
			$this->materiaBi->setPagina($this->PDFGetUltPagBi($this->ultPag));
			$this->rgrMateriaBi->alterarRegistroSemRestricao($this->materiaBi, $this->boletim);
			$this->PDFImprimeTextoAbertura($this->materiaBi, $ctMat);

			$colPessoaMateriaBi = $this->rgrPessoaMateriaBi->lerColecao($this->materiaBi->getCodigo());

			$this->varrePessoas($colPessoaMateriaBi);
			$this->PDFImprimeTextoFech($this->materiaBi);
			$this->materiaBi = $this->colMateriaBi2->getProximo1();

		} // fim do loop ass espec
	}*/
	private function varrePessoas($colPessoaMateriaBi) {
		$pessoaMateriaBi = $colPessoaMateriaBi->iniciaBusca1();
		//varre todas as pessoa da materia
		$ctPessoas = 0;
		while ($pessoaMateriaBi != null) {
			$ctPessoas = $ctPessoas +1;
			$pessoa = $this->rgrMilitar->lerRegistro($pessoaMateriaBi->getPessoa()->getIdMIlitar());
			//militar
			if ($pessoa != null) {
				$pGrad = $this->rgrPGrad->lerRegistro($pessoa->getPGrad()->getCodigo());
				$this->PDFImprimePGrad($pGrad);

				$nomeCompleto = trim($pessoa->getNome()) . '(' . trim($pessoa->getNomeGuerra()) . ')';
				//imprimir regua
				$this->PDFImprimeNome($nomeCompleto);
			}
			//civil
			else {
				$pessoa = $this->rgrPessoa->lerRegistro($pessoaMateriaBi->getPessoa()->getIdMIlitar());
				$this->PDFImprimeNomeCivil($pessoa);
				//avanca a linha
			}
			if (trim($pessoaMateriaBi->getTextoIndiv()) <> '') {
				$this->PDFImprimeTextoIndiv($pessoaMateriaBi);
			}
			$this->PDFAlteraMargemEsq($this->margemEsqDoc);
			$pessoaMateriaBi = $colPessoaMateriaBi->getProximo1();
		} //fim do loop de pessoa
		if ($ctPessoas > 0) {
			$this->PDFAvancaLinha(1);
		}
	}
	//imprime o nome negritando o nome de guerra
	private function imprimeNome($nome, $nomeGuerra) {
		$c1 = str_word_count($nome);
		$c2 = str_word_count($nomeGuerra);
		$a1 = str_word_count($nome, 1);
		$a2 = str_word_count($nomeGuerra, 1);
		$pri = 0;
		if ($c2 != 0) {
			for ($i = 0; $i <= $c1; $i++) { //percorre todas as palavras do nome
				for ($j = 1; $j <= $c2; $j++) { //percorre todas as palavras do nome de guerra
					//verifica se a palavra do nome é igual a palavra do nome de guerra
					//ou se a letra inicial do nome é igual a palavra do nome de guerra
					//if (($a1[$i] == $a2[$j-1]) or ((substr($a1[$i],0,1) == $a2[$j-1]) and ($pri == 0))) {
					if (($a1[$i] == $a2[$j -1]) or ((substr($a1[$i], 0, 1) == $a2[$j -1]))) {
						if (strlen($a2[$j -1]) == 1) {
							//coloca apenas a letra inicial da palavra em negrito
							$this->pdf->SetFont($this->nomeFonte, 'B', $this->tamFonte);
							$this->pdf->Cell(round($this->pdf->GetStringWidth(substr($a1[$i], 0, 1))), 4, substr($a1[$i], 0, 1), 0, 0, 'L');
							$this->pdf->SetFont($this->nomeFonte, '', $this->tamFonte);
							$this->pdf->Cell((round($this->pdf->GetStringWidth($a1[$i])) - round($this->pdf->GetStringWidth(substr($a1[$i], 0, 1)))) + 1, 4, substr($a1[$i], 1, round($this->pdf->GetStringWidth($a1[$i]))), 0, 0, 'L');
							break; //sai do for (palavras do nome de guerra)
						} else {
							//coloca a palavra em negrito
							$this->pdf->SetFont($this->nomeFonte, 'B', $this->tamFonte);
							$this->pdf->Cell(round($this->pdf->GetStringWidth($a1[$i])) + 1, 4, $a1[$i], 0, 0, 'L');
							break; //sai do for (palavras do nome de guerra)
						}
					} else {
						//verifica se é a última palavra do for (palavras do nome de guerra)
						if ($c2 == $j) {
							$this->pdf->SetFont($this->nomeFonte, '', $this->tamFonte);
							$this->pdf->Cell(round($this->pdf->GetStringWidth($a1[$i])) + 1, 4, $a1[$i], 0, 0, 'L');
						}
					}
				} //fim segundo for
			} //fim primeiro for
		} else {
			$this->pdf->Cell(100, 4, strtoupper($nome), 0, 0, 'L');
		}
	}
	
    public function PDFImprimeMilitaresAgrupados($saida)
    { 
	    $this->pdf->WriteHTML('<div style="text-align: justify;">'.$saida.'</div>',$this->margemEsqDoc);
    }
	
}
?>
