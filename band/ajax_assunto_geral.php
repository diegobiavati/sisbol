<? 	session_start();
	require_once('./filelist_geral.php');
	require_once('./filelist_boletim.php');
	require_once('./filelist_assunto.php');
	require_once('./filelist_usuariofuncaotipobol.php');

	$fachadaSist2 = new FachadaSist2();
    $funcoesPermitidas = $fachadaSist2->lerColecaoAutorizada($_SESSION['NOMEUSUARIO'], 'X');
	$apresentacao = new Apresentacao($funcoesPermitidas);

	if (isset($_POST['executar'])){
		$numeroParteAtual 		 = $_POST['numeroParteAtual'];
		$numeroSecaoParteBiAtual = $_POST['numeroSecaoParteBiAtual'];
		$codTipoBolAtual = $_POST['codTipoBolAtual'];
		$descricao 				 = utf8_decode($_POST['descricao']);
		//echo $descricao;
		$ordAssuntoGeral 		 = $_POST['ordAssuntoGeral'];
		$codAssuntoGeral 		 = $_POST['codAssuntoGeral'];


	    $parteBoletim = new ParteBoletim(null);
	    $parteBoletim->setNumeroParte($numeroParteAtual);
	    $secaoParteBi = new SecaoParteBi();
	    $secaoParteBi->setNumeroSecao($numeroSecaoParteBiAtual);
	    $tipoBol = new TipoBol();
	    $tipoBol->setCodigo($codTipoBolAtual);


		$assuntoGeral = new AssuntoGeral($parteBoletim,$secaoParteBi,$tipoBol,null);
		$assuntoGeral->setDescricao($descricao);
		$assuntoGeral->setOrdAssuntoGeral($ordAssuntoGeral);
		if ($_POST['executar'] == 'Incluir'){
			//echo 'Entrei em incluir';
			$fachadaSist2->incluirAssuntoGeral($assuntoGeral);
		}
		if ($_POST['executar'] == 'Excluir'){
			$assuntoGeral=$fachadaSist2->lerAssuntoGeralComp($codAssuntoGeral);
			$fachadaSist2->excluirAssuntoGeral($assuntoGeral);
		}
		if ($_POST['executar'] == 'Alterar'){
			$assuntoGeral=$fachadaSist2->lerAssuntoGeralComp($codAssuntoGeral);
			$assuntoGeral->setDescricao($descricao);
			$fachadaSist2->alterarAssuntoGeral($assuntoGeral);
		}
  	}

	$acao = $_POST['acao'];

	if(isset($acao)){
		$itens = explode(',',$acao);
		$fachadaSist2->setaOrdemAssuntoGeral($itens[0], $itens[1]);
		$fachadaSist2->setaOrdemAssuntoGeral($itens[2], $itens[3]);
	}

	$numeroParteAtual = $_POST['numeroParteAtual'];
	$numeroSecaoParteBiAtual = $_POST['numeroSecaoParteBiAtual'];
	$codTipoBolAtual = $_POST['codTipoBolAtual'];

	$colAssuntoGeral2 = $fachadaSist2->lerColecaoAssuntoGeral($numeroParteAtual,$numeroSecaoParteBiAtual,$codTipoBolAtual);

  		$assuntoGeral = $colAssuntoGeral2->iniciaBusca1();
		$total_itens =  $colAssuntoGeral2->getQTD();
		$ord = 0;
  		$cabec = '<table width="800" border="0" cellspacing="0" cellppading="0" class="lista"><tr><td>
				<table width="100%" border="0" cellspacing="1" cellpadding="0">
				<tr class="cabec">
				<td width="5%"><div align="center"><strong><font size="2">Ord</font></strong></div></td>
				<td width="60%" align="center"><strong><font size="2">Descri&ccedil;&atilde;o do Assunto Geral</font></strong></td>
				<td width="8%" align="center"><strong><font size="2">Ordenar</font></strong></td>
				<td width="8%" align="center"><strong><font size="2">A&ccedil;&atilde;o</font></strong></td>
			</tr>';
		$novo ="";
  		if($assuntoGeral == null){
			if ($_SESSION['NOMEUSUARIO'] != 'supervisor')
//    			{ $mIncluir = $funcoesPermitidas->lerRegistro(1101);	rev 07
		        { $mIncluir = $fachadaSist2->lerUsuarioFuncaoCodTipoBol($_SESSION['NOMEUSUARIO'],1101,$codTipoBolAtual);
    		}
    		if (($mIncluir != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor'))
    			{ 	$novo .= '<table width="800" border="0" >';
	  				$novo .='<TR><TD><a href="javascript:adicionar(\'divAdicionar_0\')" id="novo">';
	  				$novo .='<img src="./imagens/seta_dir.gif" border=0>&nbsp;<FONT COLOR="#0080C0">Adicionar</FONT></a></TD>';
	  				$novo .='</TR></TABLE>';
			}
  		}
  		while ($assuntoGeral != null){
			$ord++;
			$codAssuntoGeral = $assuntoGeral->getCodigo();

			if($assuntoGeral->getOrdAssuntoGeral() != $ord){
				$fachadaSist2->setaOrdemAssuntoGeral($assuntoGeral->getCodigo(), $ord);
			}

			$retorno .= '<tr id='.$ord.' valign="bottom" onMouseOut="outLinha('.$ord.')" onMouseOver="overLinha('.$ord.')" bgcolor="#F5F5F5">
				  	<td align="center">'.$ord.'</td><td><div id="divTr_'.$ord.'"></div>'. $assuntoGeral->getDescricao().'</td><td align="center">';

			if($ord != 1){ // Se não for o primeiro, pode mover para cima
				$retorno .= '<a href="javascript:move('.$codAssuntoGeral.','.$ordAnterior.','.$codAssuntoGeralAnterior.','.$ord.')">'.
							'<img src="./imagens/seta_up.gif"  border=0 title="Mover para cima"></a>';
			}

            //verifica permissao
            $acao = '';
            $acao .= '<td align="center">';
           	if ($_SESSION['NOMEUSUARIO'] != 'supervisor'){
           			//$mAlterar = $funcoesPermitidas->lerRegistro(1102);	rev 07
		   	        $mAlterar = $fachadaSist2->lerUsuarioFuncaoCodTipoBol($_SESSION['NOMEUSUARIO'],1102,$codTipoBolAtual);
           	}
           	if (($mAlterar != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor')){
           		$acao .= '<a href="javascript:alterar('.$assuntoGeral->getCodigo().',\''.$assuntoGeral->getDescricao().'\',\'Alterar\','.$ord.',\'divTr_'.$ord.'\')">';
           		$acao .= '<img src="./imagens/alterar.png"  border=0 title="Alterar"></a>&nbsp;|&nbsp';
           	}

           	//verifica permissao para excluir
           	if ($_SESSION['NOMEUSUARIO'] != 'supervisor'){
           			//$mExcluir = $funcoesPermitidas->lerRegistro(1103);	rev 07
		   	        $mExcluir = $fachadaSist2->lerUsuarioFuncaoCodTipoBol($_SESSION['NOMEUSUARIO'],1103,$codTipoBolAtual);
           	}
           	if (($mExcluir != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor')){
				$acao .= '<a href="javascript:excluir('.$assuntoGeral->getCodigo().')">';
           		$acao .= '<img src="./imagens/excluir.png" border=0 title="Excluir"></a>&nbsp;|&nbsp';
           	}

           	//verifica permissao incluir
           	if ($_SESSION['NOMEUSUARIO'] != 'supervisor'){
		        $mIncluir = $fachadaSist2->lerUsuarioFuncaoCodTipoBol($_SESSION['NOMEUSUARIO'],1101,$codTipoBolAtual);
           	}
           	if (($mIncluir != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor')){
	           	$acao .= '<a href="javascript:adicionar(\'divTr_'.$ord.'\')">';
    	    	$acao .= '<img src="./imagens/add.png" border=0 title="Adicionar"></a>';
           	}

			$acao .= '</td>';

    	   	$assuntoGeral = $colAssuntoGeral2->getProximo1(); //------------------------------ next

			if($assuntoGeral != null){
	    	   	$codAssuntoGeralAnterior = $codAssuntoGeral;
	    	   	$ordAnterior = $ord;
				$retorno .= '<a href="javascript:move('.$codAssuntoGeral.','.($ord + 1).','.$assuntoGeral->getCodigo().','.$ord.')">' .
							'<img src="./imagens/seta_down.gif" border=0 title="Mover para baixo"></a>';
			}
			$retorno .= '</td>'.$acao.'</tr>';

  		}
  		echo $novo.$cabec.$retorno;
		?>
  		</tr></table></td></tr>
	</table>
