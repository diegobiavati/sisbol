<? 	session_start();
	require_once('filelist_geral.php');
	require_once('filelist_militar.php');
	require_once('filelist_pgrad.php');
	require_once('filelist_qm.php');
	require_once('filelist_funcao.php');
	require_once('filelist_om.php');
	require_once('filelist_temposerper.php');
	$fachadaSist2 = new FachadaSist2();
    $funcoesPermitidas = $fachadaSist2->lerColecaoAutorizada($_SESSION['NOMEUSUARIO'], 'X');
	$apresentacao = new Apresentacao($funcoesPermitidas);
	// Mostrar via ajax os tempo de serviço computado para o período
	if ($_GET["opcao"] == "ajaxTempoServico")
	{	$idMilitarAlt = $_GET["idMilitarAlt"];
		$idComport = $_GET["comportamento"];
		$dataInicial = $_GET["dtInicial"];
		$dataFinal = $_GET["dtFinal"];
		$Militar = $fachadaSist2->lerMilitar($idMilitarAlt);
		$pGrad = $fachadaSist2->lerPGrad($Militar->getPGrad()->getCodigo());

		$filtro = "id_militar_alt='".$idMilitarAlt."' and
							data_in >= '".$dataInicial."' and
							data_fim <= '".$dataFinal."' ";
		$colTempoSerPer2 = $fachadaSist2->lerColecaoTempoSerPer($filtro,null);
  		$TempoSerPer = $colTempoSerPer2->iniciaBusca1();
		$Comportamento = $fachadaSist2->lerComportamento($idComport);
		?>
		<TABLE width="550" bgcolor="#0000FF" CELLPADDING="0" border="1"><TR><TD>
		<TABLE width="100%" border="0" BORDERCOLOR="#C0C0C0" BORDERCOLORLIGHT="#C0C0C0" CELLSPACING="0" CELLPADDING="0" name="tabela">
		<TR CLASS="cabec"><TD colspan="7">
		<font size="2"><?echo $pGrad->getDescricao().' - '
			.$Militar->getNome().' ('.$Militar->getNomeGuerra();?>)</font></TD></TR>

		<?
		//print_r($colTempoSerPer2);
		if($TempoSerPer == null){
			echo '<TR><TD  BGCOLOR="#C0C0C0" align="center">
				<br>N&atilde;o h&aacute; tempos registrados no per&iacute;odo...<br>&nbsp;</TD></TR>';
			echo '</table></TD></TR></TABLE>';
			die();
		}
		?>
		<TR><TD BGCOLOR="#C0C0C0" align="center">&nbsp;&nbsp;&nbsp;</td>
                    <TD BGCOLOR="#C0C0C0" align="center">&nbsp;&nbsp;&nbsp;</td>
                    <TD BGCOLOR="#C0C0C0" colspan="2">
		D. Inicial: <input name="dataInicial" type="text" size="15" maxlength="10" value="<?=$TempoSerPer->getdataIn()->GetcDataDDBMMBYYYY()?>">&nbsp;
		D. T&eacute;rmino: <input name="dataTermino" type="text" size="15" maxlength="10" value="<?=$TempoSerPer->getdataFim()->GetcDataDDBMMBYYYY()?>"></TD>
		<TD BGCOLOR="#C0C0C0" colspan="3">Aprovada?<br><?=$apresentacao->retornaCheck($TempoSerPer->getAssinado())?>&nbsp;
		</TD></TR>

		<TR><TD  BGCOLOR="#C0C0C0" colspan="7" align="center">&nbsp;</TD></TR>

		<TR><TD  BGCOLOR="#C0C0C0" colspan="4" align="center">
		<font size="2">LAN&Ccedil;AMENTO DE  TEMPOS</font></TD>
		<TD  BGCOLOR="#C0C0C0" align="center">Anos</TD>
		<TD  BGCOLOR="#C0C0C0" align="center">Meses</TD>
		<TD  BGCOLOR="#C0C0C0" align="center">Dias</TD></TR>

                <TR><TD BGCOLOR="#C0C0C0" colspan="4">
		1. TEMPO COMPUTADO DE EFETIVO SERVI&Ccedil;O (TC):</TD>
		<TD BGCOLOR="#C0C0C0" align="center"><input name="ano_TC" type="text" size="2" maxlength="2" value="<?=$TempoSerPer->getTemComEfeSer()->getAno()?>"></TD>
		<TD BGCOLOR="#C0C0C0" align="center"><input name="mes_TC" type="text" size="2" maxlength="2" value="<?=$TempoSerPer->getTemComEfeSer()->getMes()?>"></TD>
		<TD BGCOLOR="#C0C0C0" align="center"><input name="dia_TC" type="text" size="2" maxlength="2" value="<?=$TempoSerPer->getTemComEfeSer()->getDia()?>"></TD></TR>

                <TR><TD BGCOLOR="#C0C0C0" align="center">&nbsp;&nbsp;&nbsp;</td>
		<TD BGCOLOR="#C0C0C0" colspan="3">a. Arregimentado:</TD>
		<TD BGCOLOR="#C0C0C0" align="center"><input name="ano_ARR" type="text" size="2" maxlength="2" value="<?=$TempoSerPer->getArr()->getAno()?>"></TD>
		<TD BGCOLOR="#C0C0C0" align="center"><input name="mes_ARR" type="text" size="2" maxlength="2" value="<?=$TempoSerPer->getArr()->getMes()?>"></TD>
		<TD BGCOLOR="#C0C0C0" align="center"><input name="dia_ARR" type="text" size="2" maxlength="2" value="<?=$TempoSerPer->getArr()->getDia()?>"></TD></TR>

		<TR><TD BGCOLOR="#C0C0C0" align="center">&nbsp;&nbsp;&nbsp;</td>
                    <TD BGCOLOR="#C0C0C0" align="center">&nbsp;&nbsp;&nbsp;</td>
		<TD BGCOLOR="#C0C0C0" colspan="2"><?echo utf8_encode($TempoSerPer->getArr()->getTexto())?></TD>
		<TD BGCOLOR="#C0C0C0" align="center"></TD>
		<TD BGCOLOR="#C0C0C0" align="center"></TD>
		<TD BGCOLOR="#C0C0C0" align="center"></TD></TR>

                <?if ($TempoSerPer->getArr()->getTexto() != ''){
                   echo '<TR><TD BGCOLOR="#C0C0C0" align="center" colspan="7">&nbsp;</td></tr>';
                }?>

                <TR><TD BGCOLOR="#C0C0C0" align="center">&nbsp;&nbsp;&nbsp;</td>
		<TD BGCOLOR="#C0C0C0" colspan="3">b. N&atilde;o Arregimentado:</TD>
		<TD BGCOLOR="#C0C0C0" align="center"><input name="ano_NARR" type="text" size="2" maxlength="2" value="<?=$TempoSerPer->getNArr()->getAno()?>"></TD>
		<TD BGCOLOR="#C0C0C0" align="center"><input name="mes_NARR" type="text" size="2" maxlength="2" value="<?=$TempoSerPer->getNArr()->getMes()?>"></TD>
		<TD BGCOLOR="#C0C0C0" align="center"><input name="dia_NARR" type="text" size="2" maxlength="2" value="<?=$TempoSerPer->getNArr()->getDia()?>"></TD></TR>

		<TR><TD BGCOLOR="#C0C0C0" align="center">&nbsp;&nbsp;&nbsp;</td>
                    <TD BGCOLOR="#C0C0C0" align="center">&nbsp;&nbsp;&nbsp;</td>
		<TD BGCOLOR="#C0C0C0" colspan="2"><?echo utf8_encode($TempoSerPer->getNArr()->getTexto())?></TD>
		<TD BGCOLOR="#C0C0C0" align="center"></TD>
		<TD BGCOLOR="#C0C0C0" align="center"></TD>
		<TD BGCOLOR="#C0C0C0" align="center"></TD></TR>

                <?if ($TempoSerPer->getNArr()->getTexto() != ''){
                   echo '<TR><TD BGCOLOR="#C0C0C0" align="center" colspan="7">&nbsp;</td></tr>';
                }?>

                <TR><TD BGCOLOR="#C0C0C0" colspan="4">
		2. TEMPO N&Atilde;O COMPUTADO (TNC):</TD>
		<TD BGCOLOR="#C0C0C0" align="center"><input name="ano_TNC" type="text" size="2" maxlength="2" value="<?=$TempoSerPer->getTemNCom()->getAno()?>"></TD>
		<TD BGCOLOR="#C0C0C0" align="center"><input name="mes_TNC" type="text" size="2" maxlength="2" value="<?=$TempoSerPer->getTemNCom()->getMes()?>"></TD>
		<TD BGCOLOR="#C0C0C0" align="center"><input name="dia_TNC" type="text" size="2" maxlength="2" value="<?=$TempoSerPer->getTemNCom()->getDia()?>"></TD></TR>

                <TR><TD BGCOLOR="#C0C0C0" align="center">&nbsp;&nbsp;&nbsp;</td>
		<TD BGCOLOR="#C0C0C0" colspan="3"><?echo utf8_encode($TempoSerPer->getTemNCom()->getTexto())?></TD>
		<TD BGCOLOR="#C0C0C0" align="center"></TD>
		<TD BGCOLOR="#C0C0C0" align="center"></TD>
		<TD BGCOLOR="#C0C0C0" align="center"></TD></TR>

                <?if ($TempoSerPer->getTemNCom()->getTexto() != ''){
                   echo '<TR><TD BGCOLOR="#C0C0C0" align="center" colspan="7">&nbsp;</td></tr>';
                }?>

                <TR><TD BGCOLOR="#C0C0C0" colspan="4">
		3. TEMPO DE SERVI&Ccedil;O COMPUT&Aacute;VEL PARA MEDALHA MILITAR (TSCMM):</TD>
		<TD BGCOLOR="#C0C0C0" align="center"><input name="ano_TSCMM" type="text" size="2" maxlength="2" value="<?=$TempoSerPer->getTemMedMil()->getAno()?>"></TD>
		<TD BGCOLOR="#C0C0C0" align="center"><input name="mes_TSCMM" type="text" size="2" maxlength="2" value="<?=$TempoSerPer->getTemMedMil()->getMes()?>"></TD>
		<TD BGCOLOR="#C0C0C0" align="center"><input name="dia_TSCMM" type="text" size="2" maxlength="2" value="<?=$TempoSerPer->getTemMedMil()->getDia()?>"></TD></TR>

                <TR><TD BGCOLOR="#C0C0C0" align="center">&nbsp;&nbsp;&nbsp;</td>
		<TD BGCOLOR="#C0C0C0" colspan="3"><?echo utf8_encode($TempoSerPer->getTemMedMil()->getTexto())?></TD>
		<TD BGCOLOR="#C0C0C0" align="center"></TD>
		<TD BGCOLOR="#C0C0C0" align="center"></TD>
		<TD BGCOLOR="#C0C0C0" align="center"></TD></TR>

                <?if ($TempoSerPer->getTemMedMil()->getTexto() != ''){
                   echo '<TR><TD BGCOLOR="#C0C0C0" align="center" colspan="7">&nbsp;</td></tr>';
                }?>

                <TR><TD BGCOLOR="#C0C0C0" colspan="4">
		4. TEMPO DE SERVI&Ccedil;O NACIONAL RELEVANTE (TSNR):</TD>
		<TD BGCOLOR="#C0C0C0" align="center"><input name="ano_TSNR" type="text" size="2" maxlength="2" value="<?=$TempoSerPer->getSerRel()->getAno()?>"></TD>
		<TD BGCOLOR="#C0C0C0" align="center"><input name="mes_TSNR" type="text" size="2" maxlength="2" value="<?=$TempoSerPer->getSerRel()->getMes()?>"></TD>
		<TD BGCOLOR="#C0C0C0" align="center"><input name="dia_TSNR" type="text" size="2" maxlength="2" value="<?=$TempoSerPer->getSerRel()->getDia()?>"></TD></TR>

                <TR><TD BGCOLOR="#C0C0C0" align="center">&nbsp;&nbsp;&nbsp;</td>
		<TD BGCOLOR="#C0C0C0" colspan="3"><?echo utf8_encode($TempoSerPer->getSerRel()->getTexto())?></TD>
		<TD BGCOLOR="#C0C0C0" align="center"></TD>
		<TD BGCOLOR="#C0C0C0" align="center"></TD>
		<TD BGCOLOR="#C0C0C0" align="center"></TD></TR>

                <?if ($TempoSerPer->getSerRel()->getTexto() != ''){
                   echo '<TR><TD BGCOLOR="#C0C0C0" align="center" colspan="7">&nbsp;</td></tr>';
                }?>

                <TR><TD BGCOLOR="#C0C0C0" colspan="4">
		5. TEMPO TOTAL DE EFETIVO SERVI&Ccedil;O (TTES):</TD>
		<TD BGCOLOR="#C0C0C0" align="center"><input name="ano_TTES" type="text" size="2" maxlength="2" value="<?=$TempoSerPer->getTotEfeSer()->getAno()?>"></TD>
		<TD BGCOLOR="#C0C0C0" align="center"><input name="mes_TTES" type="text" size="2" maxlength="2" value="<?=$TempoSerPer->getTotEfeSer()->getMes()?>"></TD>
		<TD BGCOLOR="#C0C0C0" align="center"><input name="dia_TTES" type="text" size="2" maxlength="2" value="<?=$TempoSerPer->getTotEfeSer()->getDia()?>"></TD></TR>
		<TR><TD BGCOLOR="#C0C0C0" colspan="7">&nbsp;</TD></TR>
                <TR><TD BGCOLOR="#C0C0C0" colspan="7">
                COMPORTAMENTO:&nbsp;&nbsp;
		<input name="seleComportamento" type="text" size="20" maxlength="20" value="<?=$Comportamento;?>">
        </TD></TR>
                <TR><TD BGCOLOR="#C0C0C0" align="center">&nbsp;&nbsp;&nbsp;</td>
		<TD BGCOLOR="#C0C0C0" colspan="3"><?echo utf8_encode($TempoSerPer->getTotEfeSer()->getTexto())?></TD>
		<TD BGCOLOR="#C0C0C0" align="center"></TD>
		<TD BGCOLOR="#C0C0C0" align="center"></TD>
		<TD BGCOLOR="#C0C0C0" align="center"></TD></TR>

                <?if ($TempoSerPer->getTotEfeSer()->getTexto() != ''){
                   echo '<TR><TD BGCOLOR="#C0C0C0" align="center" colspan="7">&nbsp;</td></tr>';
                }?>

                <TR><TD  BGCOLOR="#C0C0C0" colspan="7"></TD></TR>
		<TR><TD BGCOLOR="#C0C0C0" colspan="7" align="right">
	</table>
	</TD></TR></TABLE>
	<?

	}//FIM DO if ($_GET["opcao"] == "cadTempoServico")

	if ($_GET["opcao"] == "cadTempoServico")
	{	$idMilitarAlt = $_GET["idMilitarAlt"];
		$formulario = $_GET["formulario"];
		$dataInicial = $_GET["dtInicial"];
		$dataFinal = $_GET["dtFinal"];
		//if ($formulario === "textoForm")
		//{ echo '<h3>Tempos registrados em '.$anoAtual.'.</h3>';
		//}
		$Militar = $fachadaSist2->lerMilitar($idMilitarAlt);
		$pGrad = $fachadaSist2->lerPGrad($Militar->getPGrad()->getCodigo());
		$filtro = "id_militar_alt='".$idMilitarAlt."' and
							data_in >= '".$dataInicial."' and
							data_fim <= '".$dataFinal."' ";
		$colTempoSerPer2 = $fachadaSist2->lerColecaoTempoSerPer($filtro,null);
  		$TempoSerPer = $colTempoSerPer2->iniciaBusca1();
		$ord = 1;

  		echo '<br><table width="400" border="0" cellspacing="0" cellppading="0"><tr><td>';
		echo $pGrad->getDescricao().' - '
			.utf8_encode($apresentacao->setaNomeGuerra($Militar->getNome(),$Militar->getNomeGuerra()));
		echo '</td></tr></table>';
		//echo '<form name="cadTemposv" method="post">';
		echo '<table width="400" border="0" cellspacing="0" cellppading="0" class="lista"><tr><td>
				<table width="100%" border="0" cellspacing="1" cellpadding="0">
				<tr class="cabec">
				<td width="5%" align="center"><b><font size="2">Ord</font></b></td>
				<td width="15%" align="center"><b><font size="2">D. Inicial</font></b></td>
				<td width="15%"%" align="center"><b><font size="2">D. T&eacute;rmino</font></b></td>
				<td width="10%" align="center"><b><font size="2">Assinada</font></b></td>';
		if ($formulario === "listaPeriodos")
		{ echo '<td width="10%" align="center"><b><font size="2">A&ccedil;&atilde;o</font></b></td>';
		}
		echo '</tr>';

  		while ($TempoSerPer != null)
		{	echo '<tr bgcolor="#F5F5F5"><td align="center">'.$ord.'</td>';
			$ord++;
			echo '<td align="center">'.$TempoSerPer->getdataIn()->GetcDataDDBMMBYYYY().'</td>';
			echo '<td align="center">'.$TempoSerPer->getdataFim()->GetcDataDDBMMBYYYY().'</td>';
			echo '<td align="center">'.$TempoSerPer->getAssinado().'</td>';
			//print_r($TempoSerPer);
			if ($formulario === "listaPeriodos")
			{	$param = "'".$idMilitarAlt."','"
							.$TempoSerPer->getmilitarAss()->getIdMilitar()."','"
							.$TempoSerPer->getdataIn()->GetcDataDDBMMBYYYY()."','"
							.$TempoSerPer->getdataFim()->GetcDataDDBMMBYYYY()."',"

							.$TempoSerPer->getTemComEfeSer()->getAno().","
							.$TempoSerPer->getTemComEfeSer()->getMes().","
							.$TempoSerPer->getTemComEfeSer()->getDia().","

							.$TempoSerPer->getArr()->getAno().","
							.$TempoSerPer->getArr()->getMes().","
							.$TempoSerPer->getArr()->getDia().","

							.$TempoSerPer->getNArr()->getAno().","
							.$TempoSerPer->getNArr()->getMes().","
							.$TempoSerPer->getNArr()->getDia().","

							.$TempoSerPer->getTemNCom()->getAno().","
							.$TempoSerPer->getTemNCom()->getMes().","
							.$TempoSerPer->getTemNCom()->getDia().","

							.$TempoSerPer->getTemMedMil()->getAno().","
							.$TempoSerPer->getTemMedMil()->getMes().","
							.$TempoSerPer->getTemMedMil()->getDia().","

							.$TempoSerPer->getSerRel()->getAno().","
							.$TempoSerPer->getSerRel()->getMes().","
							.$TempoSerPer->getSerRel()->getDia().","

							.$TempoSerPer->getTotEfeSer()->getAno().","
							.$TempoSerPer->getTotEfeSer()->getMes().","
							.$TempoSerPer->getTotEfeSer()->getDia().",'"

							.$TempoSerPer->getAssinado()."',";
				//marco
				echo '<td align="center"><a href="javascript:carregaedit('.$param.'\'Alterar\')">';
                if ($_SESSION['NOMEUSUARIO'] != 'supervisor')
                { $mAlterar = $funcoesPermitidas->lerRegistro(1122);
                }
                if (($mAlterar != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor'))
				{ echo '<img src="./imagens/alterar.gif"  border=0 title="Alterar">';
				}
				echo '<FONT COLOR="#000000"></FONT></a>&nbsp;|&nbsp';
				echo '<a href="javascript:carregaedit('.$param.'\'Excluir\')">';
                if ($_SESSION['NOMEUSUARIO'] != 'supervisor')
                { $mExcluir = $funcoesPermitidas->lerRegistro(1123);
                }
                if (($mExcluir != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor'))
				{ echo '<img src="./imagens/excluir.gif" border=0 title="Excluir">';
				}
				echo '<FONT COLOR="#000000"></FONT></a>';
			}//FIM DO if ($formulario === "listaPeriodos")
			echo '</tr>';
			$TempoSerPer = $colTempoSerPer2->getProximo1();
		}//fim do while ($TempoSerPer != null)
		echo '</table></td></tr></table>';

        //verifica permissao para incluir tempos
        if ($_SESSION['NOMEUSUARIO'] != 'supervisor')
        { $mIncluir = $funcoesPermitidas->lerRegistro(1121);
        }
        if (($formulario === "listaPeriodos") and (($mIncluir != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor')))
		{ //verifica permissao
          if ($_SESSION['NOMEUSUARIO'] != 'supervisor')
          { $mIncluir = $funcoesPermitidas->lerRegistro(1121);
          }
          if (($mIncluir != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor'))
          { echo '<table width="400" border="0" ><TR><TD><a href="javascript:novo(\''.$idMilitarAlt.'\')" id="novo">';
		    echo '<img src="./imagens/seta_dir.gif" border=0>';
		    echo '<FONT COLOR="#0080C0">Adicionar</FONT></a></TD></TR></TABLE>';
		  }
		}
		//echo '</form>';
	}//FIM DO if ($_GET["opcao"] == "cadTempoServico")

	//marco
	if ($_GET["opcao"] == "alteraTempoSv")
	{ 	$acao = $_GET["acao"];
		$dataIn = trim($_GET['dataIn']);
		$dataIn = explode("/",$dataIn);
		$dataIn = $dataIn[2]."-".$dataIn[1]."-".$dataIn[0];
		$dataIn = new MinhaData($dataIn);

		$dataFim = trim($_GET['dataTerm']);
		$dataFim = explode("/",$dataFim);
		$dataFim = $dataFim[2]."-".$dataFim[1].'-'.$dataFim[0];
		$dataFim = new MinhaData($dataFim);

		$idComport = $_GET['idComport'];
		$militarAlt = new Militar(null, null, null, null, null);
        $militarAss = new Militar(null, null, null, null, null);

        $temComEfeSer = new Tempos();
        $temComEfeSer->setAno($_GET['TC_Ano']);
        $temComEfeSer->setMes($_GET['TC_Mes']);
        $temComEfeSer->setDia($_GET['TC_Dia']);

	    $temNCom = new Tempos();
	    $temNCom->setAno($_GET['TNC_Ano']);
	    $temNCom->setMes($_GET['TNC_Mes']);
	    $temNCom->setDia($_GET['TNC_Dia']);
	    $temNCom->setTexto($_GET['TNC_Texto']);

	    $temMedMil = new Tempos();
	    $temMedMil->setAno($_GET['TSCMM_Ano']);
	    $temMedMil->setMes($_GET['TSCMM_Mes']);
	    $temMedMil->setDia($_GET['TSCMM_Dia']);
	    $temMedMil->setTexto($_GET['TSCMM_Texto']);

	    $temSerRel = new Tempos();
	    $temSerRel->setAno($_GET['TSNR_Ano']);
	    $temSerRel->setMes($_GET['TSNR_Mes']);
	    $temSerRel->setDia($_GET['TSNR_Dia']);
	    $temSerRel->setTexto($_GET['TSNR_Texto']);

	    $temTotEfeSer = new Tempos();
	    $temTotEfeSer->setAno($_GET['TTES_Ano']);
	    $temTotEfeSer->setMes($_GET['TTES_Mes']);
	    $temTotEfeSer->setDia($_GET['TTES_Dia']);
	    $temTotEfeSer->setTexto($_GET['TTES_Texto']);

	    $temArr = new Tempos();
	    $temArr->setAno($_GET['Arr_Ano']);
	    $temArr->setMes($_GET['Arr_Mes']);
	    $temArr->setDia($_GET['Arr_Dia']);
	    $temArr->setTexto($_GET['Arr_Texto']);

	    $temNArr = new Tempos();
	    $temNArr->setAno($_GET['nArr_Ano']);
	    $temNArr->setMes($_GET['nArr_Mes']);
	    $temNArr->setDia($_GET['nArr_Dia']);
	    $temNArr->setTexto($_GET['nArr_Texto']);

		$TempoSerPer = new TempoSerPer($idComport, $dataIn, $dataFim, $militarAlt, $militarAss, $temComEfeSer, $temNCom, $temMedMil, $temSerRel, $temTotEfeSer, $temArr, $temNArr);

	    $TempoSerPer->getmilitarAlt()->setIdMilitar($_GET['idMilitarAlt']);
		$TempoSerPer->getmilitarAss()->setIdMilitar($_GET['idMilitarAss']);

		//echo $acao;
		//print_r($TempoSerPer);
		//print_r($TempoSerPer).'<br><br><br>';
		//echo '<script>window.alert("Módulo")</script>';
		//die($acao);
		if ($acao == 'Incluir'){
			$fachadaSist2->incluirTempoSv($TempoSerPer);
		}
		if ($acao == 'Alterar'){
			$fachadaSist2->alterarTempoSv($TempoSerPer,true);
		}
		if ($acao == 'Excluir'){
			$fachadaSist2->excluirTempoSv($TempoSerPer);
		}
	}//FIM DO if ($_GET["opcao"] == "alteraTempoSv")

	if ($_GET["opcao"] == "excluiTempoSv")
	{ 	echo 'teste';
		$acao = $_GET["acao"];
		$dataIn = trim($_GET['dataIn']);
		$dataIn = explode("/",$dataIn);
		$dataIn = $dataIn[2]."-".$dataIn[1]."-".$dataIn[0];
		$dataIn = new MinhaData($dataIn);

		$militarAlt = new Militar(null, null, null, null, null);
        $militarAss = new Militar(null, null, null, null, null);

		$TempoSerPer = new TempoSerPer($idComport, $dataIn, null, $militarAlt, $militarAss, null, null, null,null, null, null, null);
	    $TempoSerPer->getmilitarAlt()->setIdMilitar($_GET['idt']);
		$fachadaSist2->excluirTempoSv($TempoSerPer);
	}

	//marco
	if ($_GET["opcao"] == "montaComboAssina")
	{	$acao = $_GET["acao"];
		if (isset($_GET["idMilitarAss"])){
			$idMilitarAss = $_GET["idMilitarAss"];
			$Assina = true;
		}
		//echo 'getMilitarAssina'.$idMilitarAss;
		$colMilitar2 = $fachadaSist2->lerColMilAssAlteracoes(null);
		$Militar = $colMilitar2->iniciaBusca1();
		//die($idMilitarAss);
		$texto = 'Militar Assina: <select name="seleMilitarAssina">';
		$foraFunc = true;
		while ($Militar != null){
			if ($Militar->getIdMilitar() === $idMilitarAss){
				$selecionado = 'SELECTED';
			  	$foraFunc = false;
			}
			$pGrad = $fachadaSist2->lerPGrad($Militar->getPGrad()->getCodigo());
			$texto .= '<option value="'.$Militar->getIdMilitar().'" '.$selecionado.'>'
						.$pGrad->getDescricao().'-'.$Militar->getNome().'</option>';
			$selecionado = '';
			$Militar = $colMilitar2->getProximo1();
		}
		if (($foraFunc)&&($acao !== "Incluir")){
			//echo 'teste: '.$acao;
			$militarAss = $fachadaSist2->lerMilitar($idMilitarAss);
			$pGrad = $fachadaSist2->lerPGrad($militarAss->getPGrad()->getCodigo());
  			$texto .= '<option value="'.$idMilitarAss.'" SELECTED>'
					.$pGrad->getDescricao().'-'
					.$militarAss->getNome()
					.'-(Fora de Função)'.'</option>';
  		}
		$texto .= '</select><br><br>';
		echo $texto;
	} 

	if ($_GET["opcao"] == "assinaAltr")
	{	$idMilitarAlt = $_GET["idMilitarAlt"];
		$formulario = $_GET["formulario"];
		$anoAtual = $_GET["ano"];
		$acao = $_GET["acao"];
		//echo $acao;
		if ($acao == "assinar")
		{	$opcao = "Assinar";
			$situacao = 'N';
		} else {
			$opcao = "Cancelar Assinatura";
			$situacao = 'S';
		}
		if ($formulario === "textoForm")
		{  echo '<h3>Tempos registrados em '.$anoAtual.'.</h3>';
		}
		$Militar = $fachadaSist2->lerMilitar($idMilitarAlt);
		$pGrad = $fachadaSist2->lerPGrad($Militar->getPGrad()->getCodigo());
		$colTempoSerPer2 = $fachadaSist2->lerColecaoTempoSerPer("id_militar_alt='".$idMilitarAlt."' and EXTRACT(YEAR FROM data_in)=".$anoAtual." and assinado = '".$situacao."'",null);
  		$TempoSerPer = $colTempoSerPer2->iniciaBusca1();
		$ord = 1;

  		echo '<br><table width="400" border="0" cellspacing="0" cellppading="0"><tr><td>';
		echo $pGrad->getDescricao().' - '
			.$apresentacao->setaNomeGuerra($Militar->getNome(),$Militar->getNomeGuerra());
		echo '</td></tr></table>';
		//echo '<form name="cadTemposv" method="post">';
		echo '<table width="400" border="0" cellspacing="0" cellppading="0" class="lista"><tr><td>
				<table width="100%" border="0" cellspacing="1" cellpadding="0">
				<tr class="cabec">
				<td width="5%" align="center"><b><font size="2">Ord</font></b></td>
				<td width="15%" align="center"><b><font size="2">D. Inicial</font></b></td>
				<td width="15%"%" align="center"><b><font size="2">D. T&eacute;rmino</font></b></td>
				<td width="15%" align="center"><b><font size="2">Assinada</font></b></td>';
		if ($formulario === "listaPeriodos")
		{ echo '<td width="10%" align="center"><b><font size="2">A&ccedil;&atilde;o</font></b></td>';
		}
		echo '</tr>';

  		while ($TempoSerPer != null)
		{   echo '<tr bgcolor="#F5F5F5"><td align="center">'.$ord.'</td>';
			$ord++;
			echo '<td align="center">'.$TempoSerPer->getdataIn()->GetcDataDDBMMBYYYY().'</td>';
			echo '<td align="center">'.$TempoSerPer->getdataFim()->GetcDataDDBMMBYYYY().'</td>';
			echo '<td align="center">'.$TempoSerPer->getAssinado().'</td>';
			//print_r($TempoSerPer);
			if ($formulario === "listaPeriodos")
			{  $param = "'".$idMilitarAlt."','"
							.$TempoSerPer->getmilitarAss()->getIdMilitar()."','"
							.$TempoSerPer->getdataIn()->GetcDataDDBMMBYYYY()."','"
							.$TempoSerPer->getdataFim()->GetcDataDDBMMBYYYY()."','"
							.$TempoSerPer->getAssinado()."',";

				echo '<td align="center"><a href="javascript:carregaedit('.$param.'\''.$opcao.'\')">
		  			  <img src="./imagens/alterar.gif"  border=0 title="Assinar"><FONT COLOR="#000000"></FONT></a>';
			}
			echo '</tr>';
			$TempoSerPer = $colTempoSerPer2->getProximo1();
		}
		echo '</table></td></tr></table><br>';
	}//FIM DO if ($_GET["opcao"] == "assinaAltr")

	if ($_GET["opcao"] == "assinaAlteracao")
	{ 	$acao = $_GET["acao"];
		$idMilitarAss = $_GET['idMilitarAss'];
		$idMilitarAlt = $_GET['idMilitarAlt'];

		$dataIn = trim($_GET['dataIn']);
		$dataIn = explode("/",$dataIn);
		$dataIn = $dataIn[2]."-".$dataIn[1].'-'.$dataIn[0];
		$dataIn = new MinhaData($dataIn);

		$dataFim = trim($_GET['dataTerm']);
		$dataFim = explode("/",$dataFim);
		$dataFim = $dataFim[2]."-".$dataFim[1].'-'.$dataFim[0];
		$dataFim = new MinhaData($dataFim);

		$TempoSerPer = $fachadaSist2->lerTempoSv($dataIn, $dataFim, $idMilitarAlt);
		//print_r($TempoSerPer);
		if ($acao == 'assinar')
		{	$TempoSerPer->setAssinado('S');
			$TempoSerPer->getmilitarAss()->setIdMilitar($idMilitarAss);
			$fachadaSist2->alterarTempoSv($TempoSerPer);
		}
		if ($acao == 'cancelar')
		{	$TempoSerPer->setAssinado('N');
			$fachadaSist2->alterarTempoSv($TempoSerPer);
		}
	}

	// Cadastro de funcoes - Lista os militares que estiverem em determinada função
	if($opcao == "listamilitarfuncao")
	{ $codFuncao = $_GET["codfuncao"];
	  echo  '<h3><FONT COLOR="#0000FF">'.'Militares na Função'.'</FONT></h3>';
	  $colMilitar2 = $fachadaSist2->lerColecaoMilitar("m.pgrad_cod","and p.funcao_cod = ".$codFuncao);
  	  $Militar = $colMilitar2->iniciaBusca1();
  	  echo '<br><table width="90%" border="1" cellspacing="0" cellppading="0" class="lista"><tr class="cabec">';
  	  echo '<td colspan="4" align="left">'.'Militar(es)'.'</td></tr>';
  	  $ord = 0;
	  while ($Militar != null)
	  { /* Capturando a descrição da QM*/
		$ord++;
		$pQM = $fachadaSist2->lerQM($Militar->getQM()->getCod());
		$pGrad = $fachadaSist2->lerPGrad($Militar->getPGrad()->getCodigo());
		echo '<tr id='.($ord + 2000).' onMouseOut="outLinha('.($ord + 2000).')"
						onMouseOver="overLinha('.($ord + 2000).')" bgcolor="#F5F5F5">
						<td align="center">'.$ord.'</TD>';
		echo '<TD>'.$pGrad->getDescricao().'</TD>';
		echo '<TD>'.$apresentacao->setaNomeGuerra($Militar->getNome(),$Militar->getNomeGuerra()).'</TD>';
		echo '</TR>';
		$Militar = $colMilitar2->getProximo1();
		if ($ord >= 15)
		{   echo '<TR><TD align="right" colspan="4" bgcolor="white"><FONT COLOR="#FF0000">De um total de: '.$colMilitar2->getQTD().' militares.</FONT></TD></TR>';
			BREAK;
		}
  	  }
  	  echo '</table>';
	}//fim do if($opcao == "listamilitarfuncao")

	/*
	[opcao] =&gt; buscaTempoSv
    [idMilitarAlt] =&gt; 0307095646
    [dataIni] =&gt; 01/01/2008
    [dataFim] =&gt; 30/06/2008
    [dataIniSemAnt] =&gt; 2007/07/01
    [dataFimSemAnt] =&gt; 2007/12/31
	*/

	if ($_GET["opcao"] == "buscaTempoSv"){
		$idMilitarAlt 	= $_GET["idMilitarAlt"];
		$dataIni 		= $_GET["dataIni"];
		$dataFim 		= $_GET["dataFim"];
		$dataIniSemAnt	= $_GET["dataIniSemAnt"];
		$dataFimSemAnt	= $_GET["dataFimSemAnt"];


		$filtro = "id_militar_alt='".$idMilitarAlt."' and
							data_in >= '".$dataIniSemAnt."' and
							data_fim <= '".$dataFimSemAnt."' ";
		$colTempoSerPer2 = $fachadaSist2->lerColecaoTempoSerPer($filtro,null);
  		$TempoSerPer = $colTempoSerPer2->iniciaBusca1();

		list($ano,$mes,$dia) = explode("|",$apresentacao->dif_datas($dataIni, $dataFim));
		$msg = '';

		$medAno = '0';
		$medMes = '0';
		$medDia = '0';

		$relAno = '0';
		$relMes = '0';
		$relDia = '0';

		$totAno = '0';
		$totMes = '0';
		$totDia = '0';



		if(!$TempoSerPer){
			$msg = 'erro1';
		} else {

			if($TempoSerPer->getAssinado() !== 'S'){
				$msg = 'erro2';
			}


			$Medalha = $apresentacao->SomarTempoSv($TempoSerPer->getTemMedMil()->GetDia()."/".
																$TempoSerPer->getTemMedMil()->GetMes()."/".
																$TempoSerPer->getTemMedMil()->GetAno(),
																(int) $dia,(int) $mes);

			$TotEfeSer = $apresentacao->SomarTempoSv($TempoSerPer->getTotEfeSer()->GetDia()."/".
																	$TempoSerPer->getTotEfeSer()->GetMes()."/".
																$TempoSerPer->getTotEfeSer()->GetAno(),
																	(int) $dia,(int) $mes);

			$medAno = $Medalha[2];
			$medMes = $Medalha[1];
			$medDia = $Medalha[0];

			$relAno = $TempoSerPer->getSerRel()->GetAno();
			$relMes = $TempoSerPer->getSerRel()->GetMes();
			$relDia = $TempoSerPer->getSerRel()->GetDia();

			$totAno = $TotEfeSer[2];
			$totMes = $TotEfeSer[1];
			$totDia = $TotEfeSer[0];

		}
		$array = array ('ano'=>$ano,'mes' =>$mes, 'dia' =>$dia,
				'medAno'=>$medAno,'medMes'=>$medMes,'medDia'=>$medDia,
				'relAno'=>$relAno,'relMes'=>$relMes, 'relDia'=>$relDia,
				'totAno'=>$totAno,'totMes'=>$totMes,'totDia'=>$totDia,'msg'=>$msg);

		echo json_encode($array);
	}
?>
