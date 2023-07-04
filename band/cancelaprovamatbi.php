<? 	session_start(); 
	require_once('./filelist_geral.php');
	require_once('./filelist_boletim.php');
	require_once('./filelist_tipodoc.php');
	require_once('./filelist_usuariofuncaotipobol.php');
	$fachadaSist2 = new FachadaSist2();
    $funcoesPermitidas = $fachadaSist2->lerColecaoAutorizada($_SESSION['NOMEUSUARIO'], 'X');	
	$apresentacao = new Apresentacao($funcoesPermitidas);
?>
<html>
<head>
	<? $apresentacao->chamaEstilo(); ?>
	<script src="scripts/band.js"></script>
	<script src="scripts/flyform.js"></script>
	<script>
	function tipoBol(codBol){
		window.location.href = "cancelaprovamatbi.php?codTipoBol="+document.cancelaAprovaMatBi.seleTipoBol.value;
	}
	function desaprova(){
		document.cancelaAprovaMatBi.action = "cancelaprovamatbi.php?codTipoBol="+document.cancelaAprovaMatBi.seleTipoBol.value;
		document.cancelaAprovaMatBi.submit();
	}
	function visualizar(codMateriaBI){
		document.getElementById("subscrForm").style.left = 50 + "px";
		document.getElementById("flyframe").style.visibility = "visible";
		document.getElementById('subscrForm').style.visibility = 'visible';
		document.getElementById('buscador').innerHTML =
  		'<b>Nota nº: '+codMateriaBI+'</b>';
  		isrc="ajax_cancelaprovamatbi.php?opcao=cancelaAprova&codMateriaBI="+codMateriaBI;
  		url = '<iframe WIDTH="680" HEIGHT="300" src="'+isrc+'"></iframe>';
		document.getElementById('textoForm').innerHTML = url;
	}

	function escondeFly(){
		document.getElementById("flyframe").style.visibility = "hidden";
		document.getElementById('subscrForm').style.visibility = 'hidden';
	}
	</script>
</head>
<body><center>
	<? 	$apresentacao->chamaCabec();
		$apresentacao->montaMenu();
		$apresentacao->montaFlyForm(700,350,'#DDEDFF');
	?>
	
	<h3 class="titulo">&nbsp;&nbsp;<img src="./imagens/item_dir.gif">&nbsp;Cancela aprovação de Matéria para Boletim</h3>
	<form name="cancelaAprovaMatBi" action="cancelaprovamatbi.php" method="post">
	<?
	echo 'Tipo de Boletim:&nbsp;';
	//$colTipoBol = $fachadaSist2->lerColecaoTipoBol('descricao');
	if ($_SESSION['NOMEUSUARIO'] == 'supervisor') {
		$colTipoBol = $fachadaSist2->lerColecaoTipoBol('descricao');
	} else {
		$colTipoBol = $fachadaSist2->lerColecaoAutorizadaTipoBol($_SESSION['NOMEUSUARIO'],2012);
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
 	$apresentacao->montaCombo('seleTipoBol',$colTipoBol,'getCodigo','getDescricao',$codTipoBolAtual,'tipoBol()');			
	?>	
	<br><br>
	<div id="meuHint"></div>
	<table width="800" border="0" cellspacing="0" cellppading="0" class="lista"><tr><td>
	<table width="100%" border="0" cellspacing="1" cellpadding="0">
	<tr class="cabec">
		<td width="8%"><div align="center"><strong><font size="2">Ord</font></strong></div></td>
		<td width="12%"><div align="center"><strong><font size="2">Nr Nota</font></strong></div></td>
		<td width="50%" align="center"><strong><font size="2">Assunto Específico</font></strong></td>
		<td width="14%" align="center"><strong><font size="2">Data Doc</font></strong></td>
		<td width="11%" align="center"><strong><font size="2">Cancelar?</font></strong></td>
		<td width="14%" align="center"><strong><font size="2">Visualizar?</font></strong></td>
	</tr>
	<?php
	  if(isset($_POST['vetor'])){
		foreach($_POST['vetor'] as $codMatBi){
		  $materiaBi = $fachadaSist2->lerRegistroMateriaBI($codMatBi);
		  $fachadaSist2->cancelarAprovarMateriaBi($materiaBi);
	  	}
	  }

										 //lerColMateriaBITipoBolAprov($codTipoBol, $aprovada, $order)
		$colMatBITipoBolAprov = $fachadaSist2->lerColMateriaBITipoBolAprov($codTipoBolAtual,'S','descr_ass_esp', 'N');
  		$Materia_BI = $colMatBITipoBolAprov->iniciaBusca1();
		$ord = 0;
  		while ($Materia_BI != null){
			$ord++;
			echo '<tr id='.$ord.' onMouseOut="outLinha('.$ord.')" onMouseOver="overLinha('.$ord.')" bgcolor="#F5F5F5">
				<td align="center">'.$ord.'</td>
				<td align="center">'.$Materia_BI->getCodigo().'</td>
				<td align="left">'.$Materia_BI->getDescrAssEsp().'</td>
				<td align="center">'.$Materia_BI->getDataDoc()->GetcDataDDBMMBYYYY().'</td>
				<td align="center"><input type="checkbox" name="vetor[]" 
										  value="'.$Materia_BI->getCodigo().'"></td>
				<td align="center"><a href="javascript:carregaedit('.$Materia_BI->getCodigo().',\'Visualizar\')"
					onmouseover="visualizar('.$Materia_BI->getCodigo().')" onMouseOut="javascript:escondeFly();" >
				<img src="./imagens/buscar.gif"  border=0 title="Visualizar"></a></td>
				</tr>';
    		$Materia_BI = $colMatBITipoBolAprov->getProximo1();
  		}
		?>
  		</tr></table></td></tr>
		</table>
		<table width="800" border="0" cellspacing="0" cellppading="0">
		<tr>
    	<td width="81%" align="right">
	 		<a href="javascript:marcaTudo(document.cancelaAprovaMatBi,true)">Marca Tudo</a>&nbsp;/&nbsp;
			<a href="javascript:marcaTudo(document.cancelaAprovaMatBi,false)">Desmarca Tudo</a>
		</td>
		<td width="14%" align="center">
			<img src="./imagens/seta.png" border="0">
		</td>
		<td width="8%" align="right">
			<input name="desaprovar" type="button" value="Cancelar" onclick="desaprova()">
		</td>
		</tr>
		</table>
	</form>
</center>
</body>
</html>
