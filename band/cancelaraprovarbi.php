<? 	session_start(); 
	require_once('./filelist_geral.php');
	require_once('./filelist_boletim.php');
	require_once('./filelist_usuariofuncaotipobol.php');
	$fachadaSist2 = new FachadaSist2();
    $funcoesPermitidas = $fachadaSist2->lerColecaoAutorizada($_SESSION['NOMEUSUARIO'], 'X');	
	$apresentacao = new Apresentacao($funcoesPermitidas);
?>
<html>
<head>
	<? $apresentacao->chamaEstilo(); ?>
	<script src="scripts/band.js"></script>
	
	<script>
	function desaprovaBoletim(codbol){
		if (!window.confirm("Deseja realmente cancelar a aprovação do Boletim selecionado?")){
			return ;
		}
		document.desaprovarbi.cod.value = codbol;
		document.desaprovarbi.executar.value = "cancela";
		document.desaprovarbi.action = "cancelaraprovarbi.php?codTipoBol="+document.desaprovarbi.seleTipoBol.value;
		document.desaprovarbi.submit();	
	}
		
	function tipoBol(){
		window.location.href = "cancelaraprovarbi.php?codTipoBol="+document.desaprovarbi.seleTipoBol.value;
	}
	</script>
</head>
<body><center>
	<? 	$apresentacao->chamaCabec();
		$apresentacao->montaMenu();
	?>
	<? 	if ($_SESSION['NOMEUSUARIO'] == 'supervisor')
	 	{ $colTipoBol = $fachadaSist2->lerColecaoTipoBol('descricao');
		}
		else
	    { $colTipoBol = $fachadaSist2->lerColecaoAutorizadaTipoBol($_SESSION['NOMEUSUARIO'], 3012);
	    }
		if (isset($_GET['codTipoBol'])){
			$codTipoBolAtual = $_GET['codTipoBol'];
		}else {
			$obj = $colTipoBol->iniciaBusca1();
			
			if (!is_null($obj)){
				$codTipoBolAtual = $obj->getCodigo();
			} else {
				$codTipoBolAtual = 0;
			}
		}
	?>
	
	
	<h3 class="titulo">&nbsp;&nbsp;<img src="./imagens/item_dir.gif">&nbsp;Cancelar Aprovação de Boletim</h3>
	<form  method="post" name="desaprovarbi">
	<p>Tipo de Boletim:&nbsp;

	<? 	$apresentacao->montaCombo('seleTipoBol',$colTipoBol,'getCodigo','getDescricao',$codTipoBolAtual,'tipoBol()');	
	?>
	<br><br>
	<table width="500"'" border="0" cellspacing="0" cellppading="0" class="lista"><tr><td>
	<table width="100%" border="0" cellspacing="1" cellpadding="0">
	<tr class="cabec">
		<td width="10%" ><div align="center"><strong><font size="2">Nr BI</font></strong></div></td>
		<td width="10%" align="center"><strong><font size="2">Data BI</font></strong></td>
		<td width="10%" align="center"><strong><font size="2">P. Inicial</font></strong></td>
		<td width="10%" align="center"><strong><font size="2">P. Final</font></strong></td>
		<td width="7%" align="center"><strong><font size="2">T. Pág</font></strong></td>
		<td width="7%" align="center"2"><strong><font size="2">Ação</font></strong></td>
	</tr>
	<?php
		if (isset($_POST['executar'])){
			$boletim = $fachadaSist2->lerBoletimPorCodigo($_POST['cod']);
			$fachadaSist2->cancelarAprovarBoletim($boletim);
  		}
  		$colBoletim2 = $fachadaSist2->lerColecaoBi('S','N',$codTipoBolAtual);
  		$boletim = $colBoletim2->iniciaBusca1();
		$ord = 0;
  		while ($boletim != null){
			$ord++;
			echo '<tr id='.$ord.' onMouseOut="outLinha('.$ord.')" onMouseOver="overLinha('.$ord.')" bgcolor="#F5F5F5">
				<td align="center">'.$boletim->getNumeroBi().'</td>
				<td align="center">'.$boletim->getDataPub()->GetcDataDDBMMBYYYY().'</td>
				<td align="center">'.$boletim->getPagInicial().'</td>
				<td align="center">'.$boletim->getPagFinal().'</td>
				<td align="center">'.($boletim->getPagFinal() - $boletim->getPagInicial()).'</td>
				<td align="center">
				<a href="javascript:desaprovaBoletim('.$boletim->getCodigo().')">
				<img src="./imagens/desative.gif"  border=0 title="Cancelar Aprovação"><FONT COLOR="#000000"></FONT></a></td>';
    		$boletim = $colBoletim2->getProximo1();
  		}
		?>
  		</tr></table></td></tr>
	</table>

	<script>javascript:tot_linhas(<?=$ord?>)</script>

		<input name="executar" type="hidden" value="">
		<input name="cod" type="hidden" value="">
		<div id="formulario" STYLE="VISIBILITY:hidden">
		<TABLE bgcolor="#0000FF" CELLPADDING="1" ><TR><TD>
			<TABLE border=0 BORDERCOLOR="#C0C0C0" BORDERCOLORLIGHT="#C0C0C0" CELLSPACING="0" CELLPADDING="0" name="tabela">
			<TR CLASS="cabec"><TD><font size="2"><div id="tituloForm"></div></font></TD></TR>
			
		<TR>
			<TD BGCOLOR="#C0C0C0" align="right">
		</TR></table>
		</TD></TR></TABLE>
		</div>
	</form>
</center>
</body>
</html>
