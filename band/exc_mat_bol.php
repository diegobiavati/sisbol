<? 	session_start();
	require_once('./filelist_geral.php');
	require_once('./filelist_militar.php');
        require_once('./filelist_boletim.php');
	require_once('./filelist_tipodoc.php');
	require_once('./filelist_usuariofuncaotipobol.php');
        require_once ('./filelist_om.php');
	$fachadaSist2 = new FachadaSist2();
    $funcoesPermitidas = $fachadaSist2->lerColecaoAutorizada($_SESSION['NOMEUSUARIO'], 'X');
	$apresentacao = new Apresentacao($funcoesPermitidas);
        $ordem = (isset($_GET['ordem']))?($_GET['ordem']):"data_materia_bi DESC";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SisBol</title>
	<? $apresentacao->chamaEstilo(); ?>
	<script type="text/javascript" src="scripts/band.js"></script>
	<script type="text/javascript" src="scripts/flyform.js"></script>
	<script type="text/javascript">
	function tipoBol(codBol){
		window.location.href = "exc_mat_bol.php?codTipoBol="+document.excluirMateria.seleTipoBol.value;
	}

	function boletim() {
		window.location.href = "exc_mat_bol.php?codTipoBol="+document.excluirMateria.seleTipoBol.value+
		                       "&codBoletim="+document.excluirMateria.seleBoletim.value;
	}

	function visualizar(codMateriaBI){
		document.getElementById("subscrForm").style.left = 50 + "px";
		document.getElementById("flyframe").style.visibility = "visible";
		document.getElementById('subscrForm').style.visibility = 'visible';
		document.getElementById('buscador').innerHTML =
  		'<table width="95%" border="0"><tr><td><b><FONT FACE="Arial" COLOR="#0000FF">Nota nº: '
		  +codMateriaBI+'<\/FONT><\/b><\/td><td align="right"><input type="button" value="Fechar" onclick="javascript:escondeFly()"><\/td><\/tr><\/table>';
  		//'<b>Nota nº: '+codMateriaBI+'<\/b>';
  		isrc="ajax_exc_mat_bol.php?opcao=exc_mat_bol&codMateriaBI="+codMateriaBI;
  		url = '<iframe WIDTH="680" HEIGHT="300" src="'+isrc+'"><\/iframe>';
		document.getElementById('textoForm').innerHTML = url;
	}
	function visualizar2(codMatBi){
		document.getElementById('mensagem').style.visibility = "visible";
		document.getElementById('divMatBi').innerHTML = "<font color='blue'>&nbsp;&nbsp;Espere, gerando a Nota para Boletim...</font>";
		//alterado para gerar o original - rv06
//		url = 'ajax_boletim.php?codBol='+codBol+'&original=N';
		url = 'ajax_elabomatbi2.php?codMatBi='+codMatBi;
		ajaxCadMilitar(url,"divMatBi");
	}
	function escondeFly(){
		document.getElementById("flyframe").style.visibility = "hidden";
		document.getElementById('subscrForm').style.visibility = 'hidden';
	}

	function excMateriaSelecionada(){
		if (!window.confirm("Deseja realmente retirar a(s) notas(s) selecionada(s) do BI selecionado ?")){
				return ;
		}
		document.excluirMateria.executar.value = "Retirar";
		document.excluirMateria.action = "exc_mat_bol.php?codTipoBol="+document.excluirMateria.seleTipoBol.value+
				"&codBoletim="+document.excluirMateria.seleBoletim.value;
		document.excluirMateria.submit();
	}
        function ordena(ordem){
		window.location.href="exc_mat_bol.php?codTipoBol="+document.excluirMateria.seleTipoBol.value+"&ordem="+ordem;
        }
	function atualizaTela(resposta){
		document.getElementById('mensagem').style.visibility = "hidden";
		document.getElementById('divMatBi').innerHTML = "";
		viewPDF2(resposta);;
	}
	</script>
</head>
<body><center>
	<? 	$apresentacao->chamaCabec();
		$apresentacao->montaMenu();
		$apresentacao->montaFlyForm(700,350,'#DDEDFF');
	?>

	<h3 class="titulo">&nbsp;&nbsp;<img src="./imagens/item_dir.gif" alt="">&nbsp;Retirar Nota de Boletim</h3>
	<form name="excluirMateria" action="excluirMateria.php" method="post">
	<?
	echo 'Tipo de Boletim:&nbsp;';
//	$colTipoBol = $fachadaSist2->lerColecaoTipoBol('descricao');
	if ($_SESSION['NOMEUSUARIO'] == 'supervisor') {
		$colTipoBol = $fachadaSist2->lerColecaoTipoBol('descricao');
	} else {
		$colTipoBol = $fachadaSist2->lerColecaoAutorizadaTipoBol($_SESSION['NOMEUSUARIO'],2022);
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
	echo '&nbsp;&nbsp;Boletim:&nbsp;';
	$colBoletim2 = $fachadaSist2->lerColecaoBi('N','N',$codTipoBolAtual,'desc');
		if (isset($_GET['codBoletim'])) {
			$codBolAtual = $_GET['codBoletim'];
		} else {
			$obj = $colBoletim2->iniciaBusca1();
			if (!is_null($obj)) {
				$codBolAtual = $obj->getCodigo();
			} else {
				$codBolAtual = 0;
			}
		}
	$apresentacao->montaCombo('seleBoletim',$colBoletim2,'getCodigo','getNumeroBi',$codBolAtual,'boletim()');
	?>
	<br><br>
	<div id="meuHint"></div>
	<table width="60%" border="0" ><tr>
	<td valign="bottom" width="3%"><div id="mensagem" class="processa" style="visibility:hidden"><img src="imagens/ajax-loader.gif" alt=""></div></td>
	<td><div id="divMatBi">&nbsp;</div></td></tr></table>
	<TABLE width="60%" border="0">
            <TR><TD align="left" valign="middle"><B>Ações possíveis:</B></TD>
                <TD align="left" valign="middle"><img src="./imagens/check_incluir.png" title="Retirar matéria do BI selecionado" border=0 alt="">Retirar Nota do BI selecionado&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp;
        <img src="./imagens/buscar.gif" title="Visualizar Nota" border=0 alt="">Visualizar Nota	    </TD></TR>
	</TABLE>
	<table width="850px" border="0" cellspacing="0" class="lista"><tr><td>
	<table width="100%" border="0" cellspacing="1" cellpadding="0">
	<tr class="cabec">
		<td width="5%"><div align="center"><strong><font size="2">Ord</font></strong></div></td>
		<td width="7%"><div align="center"><strong><font size="2">Nr Nota<a href="javascript:ordena('cod_materia_bi DESC')"></a></font></strong></div></td>
		<td width="32%" align="center"><strong><font size="2">Assunto Específico<br><a href="javascript:ordena('descr_ass_esp, codom, cod_subun, data_materia_bi DESC')"></a></font></strong></td>
		<td width="9%" align="center"><strong><font size="2">Data<br><a href="javascript:ordena('data_materia_bi DESC, codom, cod_subun')"></a></font></strong></td>
		<td width="10%" align="center"><strong><font size="2">OM Vinc<br><a href="javascript:ordena('codom, cod_subun, data_materia_bi DESC')"></a></font></strong></td>
		<td width="10%" align="center"><strong><font size="2">SU/Div/Sec<br><a href="javascript:ordena('cod_subun, codom, data_materia_bi DESC')"></a></font></strong></td>
		<td width="10%" align="center"><strong><font size="2">Usuário<br><a href="javascript:ordena('usuario, codom, cod_subun, data_materia_bi DESC')"></a></font></strong></td>
		<td width="8%" align="center"><strong><font size="2">Ações</font></strong></td>
	</tr>
	<?php
		if ($_POST['executar'] == 'Retirar'){
			 if(isset($_POST['CheckCodigoMateria'])){
    			foreach($_POST['CheckCodigoMateria'] as $codMateriaBI){
    				// Buscar a Matéria
    				$materiaBi = $fachadaSist2->lerRegistroMateriaBI($codMateriaBI);
					$boletim = $fachadaSist2->lerBoletimQuePublicou($materiaBi->getCodigo());
					$fachadaSist2->excluirMateriaDoBi($materiaBi, $boletim);
				};
  			  }
		}
		$colMatBI = $fachadaSist2->lerColMateriaDoBi($codBolAtual, $ordem);
  		$Materia_BI = $colMatBI->iniciaBusca1();
		$ord = 0;
  		while ($Materia_BI != null){
                    if ($Materia_BI->getCodom() != null){
                        $omVinc = $fachadaSist2->lerOMVinc($Materia_BI->getCodom());
                        $siglaOmVinv = $omVinc->getSigla();
                    }else{
                        $siglaOmVinv = 'Indef';
                    }
                    if (($Materia_BI->getCodom() != null)&&($Materia_BI->getCodSubun() != null)){
                        $subun = $fachadaSist2->lerSubun($Materia_BI->getCodom(), $Materia_BI->getCodSubun());
                        $siglaSubun = $subun->getSigla();
                    }else{
                        $siglaSubun = 'Indef    ';
                    }
                    $ord++;
                    echo '<tr id='.$ord.' onMouseOut="outLinha('.$ord.')" onMouseOver="overLinha('.$ord.')" bgcolor="#F5F5F5">
				<td align="center">'.$ord.'</td>
				<td align="center">'.$Materia_BI->getCodigo().'</td>
				<td align="left">'.$Materia_BI->getDescrAssEsp().'</td>
				<td align="center">'.$Materia_BI->getDataDoc()->GetcDataDDBMMBYYYY().'</td>
        			<td align="center">'.$siglaOmVinv.'</td>
                		<td align="center">'.$siglaSubun.'</td>
        			<td align="center">'.$Materia_BI->getUsuario().'</td>
        			<td align="center">
                		<input type="checkbox" name="CheckCodigoMateria[]" value="'.$Materia_BI->getCodigo().'">
                                &nbsp;|&nbsp;
        			<a href="javascript:carregaedit('.$Materia_BI->getCodigo().',\'Visualizar\')"
				onclick="visualizar('.$Materia_BI->getCodigo().')">
                		<img src="./imagens/buscar.gif"  border=0 title="Visualizar" alt=""></a>';
                    $Materia_BI = $colMatBI->getProximo1();
  		}
		?>
  		</table></td></tr>
		</table>
		<table width="70%" border="0" >
		<TR>
    	<td width="86%" align="right">
	 		<a href="javascript:marcaTudo(document.excluirMateria,true)">Marca Tudo</a>&nbsp;/&nbsp;
			<a href="javascript:marcaTudo(document.excluirMateria,false)">Desmarca Tudo</a>		</td>
		<td width="4%" align="center">
			<img src="./imagens/seta.png" border="0" alt="">
		</td>
		<TD width="8%" align="right">
			<INPUT TYPE="button" NAME="Executar" VALUE="Retirar" onClick="excMateriaSelecionada()">		</TD>
		</TR></TABLE>
		<input name="executar" type="hidden" value="">
	</form>
</center>
</body>
</html>
