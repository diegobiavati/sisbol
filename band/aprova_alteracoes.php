<? 	session_start();
	require_once('filelist_geral.php');
	require_once('filelist_pgrad.php');
	require_once('filelist_funcao.php');
	require_once('filelist_qm.php');
	require_once('filelist_militar.php');
	require_once('filelist_om.php');
	require_once('filelist_temposerper.php');
	require_once('filelist_boletim.php');
	$fachadaSist2 = new FachadaSist2();
    $funcoesPermitidas = $fachadaSist2->lerColecaoAutorizada($_SESSION['NOMEUSUARIO'], 'X');
	$apresentacao = new Apresentacao($funcoesPermitidas);

	// Setando as variáveis iniciais
	$intervalo 	= 0;
	//$opcao = $_GET['opcao'];
	$item 		= (isset($_GET['item']))?($_GET['item']):0;;
	$semestre 	= (isset($_GET['semestre']))?($_GET['semestre']):1;;
	$codpgrad 	= (isset($_GET['codpgrad']))?($_GET['codpgrad']):0;
	$ianoAtual 	= (isset($_GET['ianoAtual']))?$_GET['ianoAtual']:date('Y');
	$intervalo 	= $item + 20;

	$apresentacao->montaSemestre($ianoAtual,$semestre);
	$dataInicial = $semestre==1?$ianoAtual.'/01/01':$ianoAtual.'/07/01';
	$dataFinal = $semestre==1?$ianoAtual.'/06/30':$ianoAtual.'/12/31';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>SisBol</title>
	<? $apresentacao->chamaEstilo(); ?>
	<script type="text/javascript" src="scripts/band.js"></script>
	<script type="text/javascript" src="scripts/flyform.js"></script>
	<script type="text/javascript">
	function go(item){
		atualizarMilitares(false,item);
	}
	function atualizarMilitares(mudouPosto,item){
		if(mudouPosto){
			window.location.href="aprova_alteracoes.php?codpgrad="
			+document.cadTemposv.selePGrad.value+"&ianoAtual="+document.cadTemposv.ianoAtual.value+
			"&semestre="+document.cadTemposv.seleSemestre.value+"&item=0";
		} else {
			window.location.href="aprova_alteracoes.php?codpgrad="
			+document.cadTemposv.selePGrad.value+"&ianoAtual="+document.cadTemposv.ianoAtual.value+
			"&semestre="+document.cadTemposv.seleSemestre.value+"&item="+item;
		}
	}
	function ajaxTempoServico(idMilitarAlt,IdComport,divId,dtIni,dtFim){
		document.getElementById("subscrForm").style.left = 50 + "px";
		document.getElementById("flyframe").style.visibility = "visible";
		document.getElementById('subscrForm').style.visibility = 'visible';
		url="ajax_cadtemposv.php?opcao=ajaxTempoServico&idMilitarAlt="+idMilitarAlt+"&comportamento="+IdComport+"&formulario="+divId+"&dtInicial="+dtIni+"&dtFinal="+dtFim;
		ajax(url,divId);
	}
	function escondeFly(){
		document.getElementById("flyframe").style.visibility = "hidden";
		document.getElementById('subscrForm').style.visibility = 'hidden';
	}
	function atualizaTela(resposta){
		atualizarMilitares(false,<?=$item?>);
	}
	function Aprova(idMilitarAlt,idComport,dataIn,dataTerm,idMilitarAss,acao){
		url="ajax.php?opcao=assinaAlteracao&acao="+acao
			+"&idMilitarAlt="+idMilitarAlt
			+"&idComport="+idComport
			+"&dataIn="+dataIn
			+"&dataTerm="+dataTerm
			+"&idMilitarAss="+idMilitarAss;
		ajaxCadMilitar(url,'assinar');
	}
	</script>
</head>
<body><a name="topo"></a>
<center>
	<? 	$apresentacao->chamaCabec();
		$apresentacao->montaMenu();
		$apresentacao->montaFlyForm(530,200,'white',0);
	?>
	<h3 class="titulo">&nbsp;&nbsp;<img src="./imagens/item_dir.gif" alt="">&nbsp;Aprovar/Cancelar Altera&ccedil;&otilde;es</h3>
	<form  method="post" name="cadTemposv" action="">
	<input name="executar" type="hidden" value="">
	<input name="inputMilitar" type="hidden" value="">

	<table width="850px" border="0" cellspacing="0" ><tr><td align="right">
	<?
	$colBIAno = $fachadaSist2->getAnosBI();
	$apresentacao->montaComboAnoBI('ianoAtual',$colBIAno,$ianoAtual,'atualizarMilitares(false)');
	?>
	&nbsp;&nbsp;
	Sem: <select name="seleSemestre" onChange="atualizarMilitares(false)">
			<option value="1">1º</option>
			<option value="2">2º</option>
	</select>&nbsp;
	<?php
  	/*Listar os Postos e Graduações*/
  	$colPGrad2 = $fachadaSist2->lerColecaoPGrad('cod');
  	$pGrad = $colPGrad2->iniciaBusca1();

  	/*Listar as funções*/
  	$colFuncao2 = $fachadaSist2->lerColecaoFuncao('cod');
  	$Funcao = $colFuncao2->iniciaBusca1();

  	/*Listar as QM*/
  	$colQM2 = $fachadaSist2->lerColecaoQM('cod');
  	$pQM = $colQM2->iniciaBusca1();

  	/* Se estiver setada um posto/graduação*/
  	if(isset($_GET['codpgrad'])){
		$codpgrad = $_GET['codpgrad'];
	} else {
		$codpgrad = $pGrad->getCodigo();
	}
	//$location = "cadTemposv.php?codpgrad=".$codpgrad."&semestre=".$semestre."&ianoAtual=".$ianoAtual;
  	echo 'Listar por: ';
  	$apresentacao->montaCombo('selePGrad',$colPGrad2,'getCodigo','getDescricao',
  								$codpgrad,'atualizarMilitares(true)');
	echo '<p>'
	?>
	</TD></TR></table>
	<table width="850" border="0" cellspacing="0"  class="lista"><tr><td>
	<table width="100%" border="0" cellspacing="1" >
	<tr class="cabec">
		<td width="5%" align="center"><strong><font size="2">Ord</font></strong></td>
		<td width="7%" align="center"><strong><font size="2">P/Grad</font></strong></td>
		<td width="30%" align="center"><strong><font size="2">Nome</font></strong></td>
		<td width="7%" align="center"><strong><font size="2">D. Ini</font></strong></td>
		<td width="7%" align="center"><strong><font size="2">D. Fim</font></strong></td>
		<td width="15%" align="center"><strong><font size="2">Assina</font></strong></td>
		<td width="7%" align="center"><strong><font size="2">Aprovado</font></strong></td>
		<td width="7%" align="center"><strong><font size="2">A&ccedil;&atilde;o</font></strong></td>
	</tr>
	<?
	$colMilitar2 = $fachadaSist2->lerColecaoMilitar("m.antiguidade, p.nome",
			"and p.perm_pub_bi = 'S' and m.pgrad_cod = '".$codpgrad."'");
  		$Militar = $colMilitar2->iniciaBusca1();
  		$total = $colMilitar2->getQTD();
	$ord = 0;
	$items_lidos = 0;
  	while ($Militar != null){
  		if($codpgrad === $Militar->getPGrad()->getCodigo()){
			/* Capturando a descrição da QM*/
			$ord++;
			if ($ord > $item){
				$pQM = $fachadaSist2->lerQM($Militar->getQM()->getCod());
				$pGrad = $fachadaSist2->lerPGrad($Militar->getPGrad()->getCodigo());
				$pGradNome = $pGrad->getDescricao().' '.$Militar->getNomeGuerra();
				echo '<tr id='.$ord.' onMouseOut="outLinha('.$ord.')"
						onMouseOver="overLinha('.$ord.')" bgcolor="#F5F5F5">
						<td align="center">'.$ord.'</TD>';
				echo '<TD>'.$pGrad->getDescricao().'</TD>';
				//echo '<br>'.$Militar->exibeDados().'<br>';
				echo '<TD>'
				  .$apresentacao->setaNomeGuerra($Militar->getNome(),$Militar->getNomeGuerra()).'</TD>';
				/*Buscar os tempos de serviço registrados para o semestre*/
				$filtro = "id_militar_alt='".$Militar->getIdMilitar()."' and
							data_in >= '".$dataInicial."' and
							data_fim <= '".$dataFinal."' ";
				$colTempoSerPer2 = $fachadaSist2->lerColecaoTempoSerPer($filtro,null);
				$TempoSerPer = $colTempoSerPer2->iniciaBusca1();

				if ($TempoSerPer != null){
					$dataIni = $TempoSerPer->getdataIn()->GetcDataDDBMMBYYYY();
					$dataFim = $TempoSerPer->getdataFim()->GetcDataDDBMMBYYYY();
					echo '<TD align="center">'.$dataIni.'</TD>';
					echo '<TD align="center">'.$dataFim.'</TD>';
					echo '<TD align="left">';
					$idMilitarAss = $TempoSerPer->getmilitarAss()->getIdMilitar();
					if($idMilitarAss !== null){
						$milAssina = $fachadaSist2->lerMilitar($TempoSerPer->getmilitarAss()->getIdMilitar());
						$PGradMilAss = $fachadaSist2->lerPGrad($milAssina->getPGrad()->getCodigo());
						echo $PGradMilAss->getDescricao().' ';
						echo $milAssina->getNomeGuerra();
					} else {
						echo '-';
					}
					echo '</TD>';
					echo '<TD align="center">'.$apresentacao->retornaCheck($TempoSerPer->getAssinado()).'</TD>';
					if($TempoSerPer->getAssinado() == 'S'){
						echo '<td align="center"><a href="javascript:Aprova(\''.$Militar->getIdMilitar().'\',\''.$Militar->getComportamento().'\',\''.$dataIni.'\',\''.$dataFim.'\',\''.$idMilitarAss.'\',\'cancelar\')">
				 		  <img src="./imagens/excluir.png" title="Cancelar aprova&ccedil;&atilde;o" border=0 alt=""></a>';
					} else {
						echo '<td align="center"><a href="javascript:Aprova(\''.$Militar->getIdMilitar().'\',\''.$Militar->getComportamento().'\',\''.$dataIni.'\',\''.$dataFim.'\',\''.$idMilitarAss.'\',\'assinar\')">
				 		  <img src="./imagens/check.gif" title="Aprovar" border=0 alt=""></a>';
					}
					echo '&nbsp;|&nbsp;<a href=# onmouseover="ajaxTempoServico(\''.$Militar->getIdMilitar().'\',\''.$Militar->getComportamento().'\',\'textoForm\',\''.$dataInicial.'\',\''.$dataFinal.'\')"
					
						   onMouseOut="javascript:escondeFly();"><img src="./imagens/buscar.gif" title="Visualizar Tempo de Servi&ccedil;o cadastrado" border=0 alt=""></a>
						 </td></tr>
				 		</TR>';
				} else {
					echo '<TD align="center">&nbsp;</TD>';
					echo '<TD align="center">&nbsp;</TD>';
					echo '<TD align="center">&nbsp;</TD>';
					echo '<TD align="center">&nbsp;</TD>';
					echo '<td align="center" valign="middle">-</td>
				 		</TR>';
				}
			}
  		}
		$Militar = $colMilitar2->getProximo1();
    	$items_lidos++;
    	if($items_lidos >= $intervalo){
    		break;
    	}
  	}
	?>
  	</table></td></tr>
	</table>
	<table width="850" border="0" cellspacing="0" ><tr><td align="right">
	<?
	if ($total > 20){
		echo "&nbsp;&nbsp;&nbsp;";
		$apresentacao->montaComboPag($total,$item,$selected,null);
	}
	?>
	</td></tr></table>
	<div id="formulario" STYLE="VISIBILITY:hidden" align="center">
		<TABLE width="550" bgcolor="#0000FF"  ><TR><TD>
		<TABLE width="100%" border="0" CELLSPACING="0" style="name:tabela;">
		<TR CLASS="cabec"><TD colspan="5">
		<div id="tituloForm"><font size="2"></font></div></TD></TR>
		<TR><TD BGCOLOR="#C0C0C0" colspan="5">&nbsp;</TD></TR>
		<TR><TD BGCOLOR="#C0C0C0" colspan="2">
		D. Inicial: <input name="dataInicial" type="text" size="15" maxlength="10" onBlur="validaData(this)">&nbsp;
		D. T&eacute;rmino: <input name="dataTermino" type="text" size="15" maxlength="10" onBlur="validaData(this)"></TD>
		<TD BGCOLOR="#C0C0C0" colspan="3">Assinada?<br><div id="idAssinada"></div>&nbsp;
		</TD></TR>

		<TR><TD  BGCOLOR="#C0C0C0" colspan="5" align="center">&nbsp;</TD></TR>
		<TR><TD  BGCOLOR="#C0C0C0" colspan="2" align="center">
		<font size="2">LAN&Ccedil;AMENTO DE  TEMPOS</font></TD>
		<TD  BGCOLOR="#C0C0C0" align="center">Anos</TD>
		<TD  BGCOLOR="#C0C0C0" align="center">Meses</TD>
		<TD  BGCOLOR="#C0C0C0" align="center">Dias</TD></TR>
		<TR><TD BGCOLOR="#C0C0C0" colspan="2">
		1. TEMPO COMPUTADO DE EFETIVO SERVI&Ccedil;O (TC):</TD>
		<TD BGCOLOR="#C0C0C0" align="center"><input name="ano_TC" type="text" size="2" maxlength="2" onKeyPress="return so_numeros(event)"></TD>
		<TD BGCOLOR="#C0C0C0" align="center"><input name="mes_TC" type="text" size="2" maxlength="2" onKeyPress="return so_numeros(event)"></TD>
		<TD BGCOLOR="#C0C0C0" align="center"><input name="dia_TC" type="text" size="2" maxlength="2" onKeyPress="return so_numeros(event)"></TD></TR>
		<TR><TD BGCOLOR="#C0C0C0" align="center">&nbsp;</td>
		<TD BGCOLOR="#C0C0C0">a. Arregimentado:</TD>
		<TD BGCOLOR="#C0C0C0" align="center"><input name="ano_ARR" type="text" size="2" maxlength="2" onKeyPress="return so_numeros(event)"></TD>
		<TD BGCOLOR="#C0C0C0" align="center"><input name="mes_ARR" type="text" size="2" maxlength="2" onKeyPress="return so_numeros(event)"></TD>
		<TD BGCOLOR="#C0C0C0" align="center"><input name="dia_ARR" type="text" size="2" maxlength="2" onKeyPress="return so_numeros(event)"></TD></TR>
		<TR><TD BGCOLOR="#C0C0C0">&nbsp;</td>
		<TD BGCOLOR="#C0C0C0">b. N&atilde;o Arregimentado:</TD>
		<TD BGCOLOR="#C0C0C0" align="center"><input name="ano_NARR" type="text" size="2" maxlength="2" onKeyPress="return so_numeros(event)"></TD>
		<TD BGCOLOR="#C0C0C0" align="center"><input name="mes_NARR" type="text" size="2" maxlength="2" onKeyPress="return so_numeros(event)"></TD>
		<TD BGCOLOR="#C0C0C0" align="center"><input name="dia_NARR" type="text" size="2" maxlength="2" onKeyPress="return so_numeros(event)"></TD></TR>
		<TR><TD BGCOLOR="#C0C0C0" colspan="2">
		2. TEMPO N&Atilde;O COMPUTADO (TNC):</TD>
		<TD BGCOLOR="#C0C0C0" align="center"><input name="ano_TNC" type="text" size="2" maxlength="2" onKeyPress="return so_numeros(event)"></TD>
		<TD BGCOLOR="#C0C0C0" align="center"><input name="mes_TNC" type="text" size="2" maxlength="2" onKeyPress="return so_numeros(event)"></TD>
		<TD BGCOLOR="#C0C0C0" align="center"><input name="dia_TNC" type="text" size="2" maxlength="2" onKeyPress="return so_numeros(event)"></TD></TR>
		<TR><TD BGCOLOR="#C0C0C0" colspan="2">
		3. TEMPO DE SERVI&Ccedil;O COMPUT&Aacute;VEL PARA MEDALHA MILITAR (TSCMM):</TD>
		<TD BGCOLOR="#C0C0C0" align="center"><input name="ano_TSCMM" type="text" size="2" maxlength="2" onKeyPress="return so_numeros(event)"></TD>
		<TD BGCOLOR="#C0C0C0" align="center"><input name="mes_TSCMM" type="text" size="2" maxlength="2" onKeyPress="return so_numeros(event)"></TD>
		<TD BGCOLOR="#C0C0C0" align="center"><input name="dia_TSCMM" type="text" size="2" maxlength="2" onKeyPress="return so_numeros(event)"></TD></TR>
		<TR><TD BGCOLOR="#C0C0C0" colspan="2">
		4. TEMPO DE SERVI&Ccedil;O NACIONAL RELEVANTE (TSNR):</TD>
		<TD BGCOLOR="#C0C0C0" align="center"><input name="ano_TSNR" type="text" size="2" maxlength="2" onKeyPress="return so_numeros(event)"></TD>
		<TD BGCOLOR="#C0C0C0" align="center"><input name="mes_TSNR" type="text" size="2" maxlength="2" onKeyPress="return so_numeros(event)"></TD>
		<TD BGCOLOR="#C0C0C0" align="center"><input name="dia_TSNR" type="text" size="2" maxlength="2" onKeyPress="return so_numeros(event)"></TD></TR>
		<TR><TD BGCOLOR="#C0C0C0" colspan="2">
		5. TEMPO TOTAL DE EFETIVO SERVI&Ccedil;O (TTES):</TD>
		<TD BGCOLOR="#C0C0C0" align="center"><input name="ano_TTES" type="text" size="2" maxlength="2" onKeyPress="return so_numeros(event)"></TD>
		<TD BGCOLOR="#C0C0C0" align="center"><input name="mes_TTES" type="text" size="2" maxlength="2" onKeyPress="return so_numeros(event)"></TD>
		<TD BGCOLOR="#C0C0C0" align="center"><input name="dia_TTES" type="text" size="2" maxlength="2" onKeyPress="return so_numeros(event)"></TD></TR>
		<TR><TD  BGCOLOR="#C0C0C0" colspan="5"><div id="comboMilitarAssina"></div></TD></TR>
		<TR><TD BGCOLOR="#C0C0C0" colspan="5" align="right">
		<input name="acao" type="button" value="" onClick="executa(this.value)" id="idacao">
		<input name="cancela" type="button" value="Cancelar" onClick="cancelar()"></TD></TR>
	</table>
	</TD></TR></TABLE>
	</div>
	</form>
	<script type="text/javascript">document.cadTemposv.seleSemestre.value = <?=$semestre?>;</script>
	<a name="cadastro"></a>
	</center>
</body>
</html>

