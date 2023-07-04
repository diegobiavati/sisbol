<? 	session_start();
	require_once('filelist_geral.php');
	require_once('filelist_boletim.php');
	require_once('./filelist_usuariofuncaotipobol.php');
	$fachadaSist2 = new FachadaSist2();
    $funcoesPermitidas = $fachadaSist2->lerColecaoAutorizada($_SESSION['NOMEUSUARIO'], 'X');
	$apresentacao = new Apresentacao($funcoesPermitidas);
	if ($_SESSION['NOMEUSUARIO'] == 'supervisor'){
			//monta a coleção com todos os tipos de boletim cadastrados
			$colTipoBol = $fachadaSist2->lerColecaoTipoBol('descricao');
		}else{
			//monta a coleção dos tipos de boletim autorizados para o usuário logado e para a função de consultar bi
		    $colTipoBol = $fachadaSist2->lerColecaoAutorizadaTipoBol($_SESSION['NOMEUSUARIO'], 3004);
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
<HEAD><TITLE>Baixar de Boletim</TITLE>

	<script type="text/javascript" src="scripts/band.js"></script>
	<script type="text/javascript">
	var janelaPDF;
	function tipo(){
		window.location.href = "baixar_alteracao.php?ano=" + document.listaBi.anos.value+
								"&semestre=" + document.listaBi.seleSemestre.value;
	}
	</script>

</HEAD>
<BODY><center>
<?	$apresentacao->chamaEstilo();
	$apresentacao->chamaCabec();
	$apresentacao->montaMenu();
	echo '<h3 class="titulo">&nbsp;&nbsp;<img src="./imagens/item_dir.gif" alt="">&nbsp;Alterações dispon&iacute;veis para download</h3>';
	$tipoAtual = 'alteracao';
?>
<form method="post" name="listaBi" action="">
	<table border="0" width="750px"><tr><td align="right">
	Ano:
	<?
	$semestre 	= (isset($_GET['semestre']))?($_GET['semestre']):1;
	$anoAtual = isset($_GET['ano'])?$_GET['ano']:date('Y');

	$colBIAno = $fachadaSist2->getAnosBI();
	$apresentacao->montaComboAnoBI('anos',$colBIAno,$anoAtual,'tipo()');

	if($semestre ==1){
		$PeriodoIni = (int) ($anoAtual.'0101');
		$PeriodoFim = (int) ($anoAtual.'0631');
	} else {
		$PeriodoIni = (int) ($anoAtual.'0701');
		$PeriodoFim = (int) ($anoAtual.'1231');
	}
	

	
	?>

	Sem: <select name="seleSemestre" onChange="tipo()">
			<option value="1">1º</option>
			<option value="2">2º</option>
		</select>
        <br><br>
	</td></tr></table>
	<table width="850px" border="0" cellspacing="0" class="lista"><tr><td>
	<table width="100%" border="0" cellspacing="1">
	<tr class="cabec">
		<td width="12%"><div align="center"><strong><font size="2">Ordem</font></strong></div></td>
		<td width="50%" align="center"><strong><font size="2">Nome do Arquivo</font></strong></td>
		<td width="18%" align="center"><strong><font size="2">Tamanho</font></strong></td>
		<td width="10%" align="center"><strong><font size="2">A&ccedil;&atilde;o</font></strong></td>
	</tr>

	<?
		$arquivos = scandir($tipoAtual);
		$contador = 0;
		$ord = 0;
		$contador = count($arquivos);
		while ($contador >= 0) {
			$dataIni = (int) (retornaData(substr($arquivos[$contador],0,10)));
			if(($dataIni >= $PeriodoIni) and ($dataIni <= $PeriodoFim)){
					$ord++;
					$valor = $arquivos[$contador];
					$caminho = $tipoAtual.'/'.$valor;
					$tamanho = sprintf("%u", filesize($tipoAtual.'/'.$valor));
					$tamanho = round($tamanho/1024);
					echo '<tr id='.$ord.' onMouseOut="outLinha('.$ord.')" onMouseOver="overLinha('.$ord.')" bgcolor="#F5F5F5">
	    	 		      <td align="center">'.$ord.'</td>
		    			  <td align="left">'.$valor.'</td>
		    			  <td align="center">'.$tamanho.' Kb</td>
			    		  <td align="center"><a href="javascript:viewPDF2(\''.$caminho.'\')">
					    		<img src="./imagens/buscar.gif" alt="" border=0 title="Visualizar alteração"></a>&nbsp;|&nbsp;';
					echo '<a href="down.php?filename='.$caminho.'"><img src="./imagens/salvar.png" alt="" border=0 title="Realizar download"></a></td>';
				//}
			}//fim do if
			$contador--;
		}//fim do while

		function retornaData($string){
			$valor = $string;
			$valor = explode("-",$valor);
			return $valor[0].$valor[1].$valor[2];
		}
	?>
	</table></td></tr>
</table>
<script type="text/javascript">document.listaBi.seleSemestre.value = <?=$semestre?>;</script>
</form>
</center>
</BODY>
</HTML>
