<? 	session_start(); 
	require_once('filelist_geral.php');
	require_once('filelist_boletim.php');
	$fachadaSist2 = new FachadaSist2();
	$apresentacao = new Apresentacao(null);
?>

<HTML>
<HEAD><TITLE>Download de Boletim</TITLE>

	<script src="scripts/band.js"></script>
	<script>
	var janelaPDF;
	function tipo(){
		window.location.href = "consultar_boletim.php?ano=" + document.listaBi.anos.value
														+ "&mes=" + document.listaBi.mes.value;
	}
	</script>

</HEAD>
<BODY><center>
<?
		$apresentacao->chamaEstilo();
		$apresentacao->chamaCabec();
		//$apresentacao->montaMenu();
		echo '<h3 class="titulo">&nbsp;&nbsp;<img src="./imagens/item_dir.gif">&nbsp;Boletins dispon&iacute;veis para download</h3>';
		if (isset($_GET['tipo'])){
			$tipoAtual = trim($_GET['tipo']);	
		} else {
			$tipoAtual = 'boletim';
		}
		echo '<form method="post" name="listaBi">';
		echo '<table border="0" width="600"><tr>';
		echo '<td>&nbsp;&nbsp;&nbsp;</td>';
		echo '<td>&nbsp;&nbsp;&nbsp;</td>';
		echo '<td>Ano:&nbsp;</td>';
		echo '<td><select name="anos" onchange="tipo()">';
		if (isset($_GET['ano'])){
			$anoAtual = trim($_GET['ano']);	
		} else {
			$anoAtual = getdate();
			$anoAtual = $anoAtual[year];
		}
		$colBoletim = $fachadaSist2->lerColecaoBi('X','X',null);
		$obj = $colBoletim->iniciaBusca1();
		$ano1 = 0;
		while ($obj != null) {
			if ($ano1 != $obj->getDataPub()->getIAno()) {
				if ($obj->getDataPub()->getIAno() == $anoAtual) {
					echo '<option value="'.$anoAtual.'" SELECTED>'.$anoAtual.'</option>';	
				} else {
					echo '<option value="'.$obj->getDataPub()->getIAno().'">'.$obj->getDataPub()->getIAno().'</option>';
				}
				$ano1 = $obj->getDataPub()->getIAno();
			}
			$obj = $colBoletim->getProximo1();
		}
		echo '</select></td>';

  		$aMes = array( 1=> 'Janeiro', 'Fevereiro','Março','Abril','Maio','Junho',
            	          'Julho','Agosto','Setembro','Outubro','Novembro','Dezembro');
		echo '<td>&nbsp;&nbsp;&nbsp;</td>';
		echo '<td>&nbsp;&nbsp;&nbsp;</td>';
		echo '<td>Mês:&nbsp;</td>';
		echo '<td><select name="mes" onchange="tipo()">';
		if (isset($_GET['mes'])){
			$mesAtual = trim($_GET['mes']);	
		} else {
			$mesAtual = date('n');
		}

		echo 'Mês:&nbsp;&nbsp;';
    	for($i = 1; $i<=12; $i++){
			if ($mesAtual == $i)
				echo '<option value="'.$i.'" SELECTED>'.$aMes[$i].'</option>';	
			else
				echo '<option value="'.$i.'">'.$aMes[$i].'</option>';	
    	}
		echo '</select></td>';
		echo '</tr></table></form>';
	
?>
<table width="600" border="0" cellspacing="0" cellppading="0" class="lista"><tr><td>
	<table width="100%" border="0" cellspacing="1" cellpadding="0">
	<tr class="cabec">
		<td width="12%"><div align="center"><strong><font size="2">Ordem</font></strong></div></td>
		<td width="50%" align="center"><strong><font size="2">Nome do Arquivo</font></strong></td>
		<td width="18%" align="center"><strong><font size="2">Tamanho</font></strong></td>
		<td width="15%" align="center"><strong><font size="2">Ação</font></strong></td>
	</tr>

	<?	$tipoAtual == 'boletim';
		$arquivos = scandir($tipoAtual);
		$contador = 0;
		$ord = 0;
		while ($arquivos[$contador] != null) {
			if(strripos($arquivos[$contador],'_O_')){
				$contador++;
				continue;
			}
			if(strripos($arquivos[$contador],'indice')){
				$contador++;
				continue;
			}	
			if (substr($arquivos[$contador],0,4) == $anoAtual) {
//				echo substr($arquivos[$contador],5,2);
				if (intval(substr($arquivos[$contador],5,2)) == $mesAtual) {
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
					    		<img src="./imagens/buscar.gif" border=0 title="Abrir boletim"></a>&nbsp;|&nbsp;';
					echo '<a href="down.php?filename='.$caminho.'"><img src="./imagens/bt_ok.png" border=0 title="Realizar download"></a></td>';    		
				}
			}//fim do if
			$contador++;
		}//fim do while
	?>
	</table></td></tr>
</table>	
</font>
</center>
</BODY>
</HTML>
