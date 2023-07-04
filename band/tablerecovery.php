<?  session_start();
	require_once('filelist_geral.php');
	$fachadaSist2 = new FachadaSist2();
    $funcoesPermitidas = $fachadaSist2->lerColecaoAutorizada($_SESSION['NOMEUSUARIO'], 'X');
	$apresentacao = new Apresentacao($funcoesPermitidas);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
<HEAD><TITLE>Restaura&ccedil;&atilde;o de Backup</TITLE>

	<script type="text/javascript" src="scripts/band.js"></script>

	<script type="text/javascript">

	function recuperaExclui(nome,acao) {
		var data = nome.substring(18,20)+'/'+ nome.substring(15,17)+'/'+ nome.substring(10,14);
		var hora = nome.substring(21,23)+'h'+ nome.substring(24,26);
		var msg = "O backup que você deseja restaurar foi realizado em "+ data +" às "+ hora +". Após a recuperação, " +
					"todos os dados gravados após esta data e hora serão perdidos."+
					"\n\nTem certeza que deseja recuperar o backup selecionado?"
		if (acao == 'Recuperar') {
			var resposta = window.confirm(msg);
			if (!resposta) {
				return;
			}
		}
		if (acao == 'Excluir') {
			var resposta = window.confirm("Tem certeza que deseja apagar o arquivo de backup selecionado?");
			if (!resposta) {
				return;
			}
		}
		//document.getElementById(objLocal).innerHTML
		document.getElementById('mensagem').style.visibility = 'visible';
		document.recovery.executar.value = acao;
		document.recovery.arquivo.value = nome;
		document.recovery.submit();
	}

	function mostraForm(){
		document.getElementById('formUpload').style.visibility = "visible";
		document.getElementById('refimport').style.visibility = "hidden";
	}
	function cancelar(){
		document.getElementById('formUpload').style.visibility = "hidden";
		document.getElementById('refimport').style.visibility = "visible";
	}
	</script>

</HEAD>
<BODY><center>

<?
	$apresentacao->chamaEstilo();
	$apresentacao->chamaCabec();
	$apresentacao->montaMenu();
	if (isset($_POST['executar'])) {
		$file = trim($_POST['arquivo']);
		$file = $fachadaSist2->getBackupDir().$file;
		if (trim($_POST['executar']) == 'Recuperar') {
			$comando = $fachadaSist2->getRestoreCommand().' < '.$file;

			try {
				system($comando,$status);
			} catch (exception $e) {
				$e->getMessage();
			}

			if ($status == 0) {
				echo '<script> window.alert("Recuperação executada com êxito!"); </script>';
				echo ('<script> window.location.href="sisbol.php"; </script>');
			} else {
				echo ('<script> window.alert("Falha na recuperação.\nContate o administrador do sistema!"); </script>');
			}
		}
		if (trim($_POST['executar']) == 'Excluir') {
			system($fachadaSist2->getDeleteCommand().' '.$file,$status);
			if ($status == 0) {
				echo '<script> window.alert("Arquivo apagado com sucesso!"); </script>';

			} else {
				echo ('<script> window.alert("A tentativa de excluir o arquivo falhou.\nContate o administrador do sistema!"); </script>');
			}
		}
		echo ('<script> window.location.href="tablerecovery.php"; </script>');
	}
?>
<h3 class="titulo">&nbsp;&nbsp;<img src="./imagens/item_dir.gif" alt="">&nbsp;Backups dispon&iacute;veis para restaura&ccedil;&atilde;o</h3>
<br>

		<TABLE width="500px" bgcolor="yellow" CELLPADDING="0" border="1" cellpadding="0" cellspacing="0"><TR><TD>
		<TABLE width="100%" border="0" BORDERCOLOR="#C0C0C0" BORDERCOLORLIGHT="#C0C0C0" CELLSPACING="0" CELLPADDING="0" name="tabela">
		<TR>
		  <TD><font face="Arial" size="3"><B> &nbsp;<img src="imagens/atencao.png" width="16" height="16"> Aten&ccedil;&atilde;o</B></font></TD></TR>
		<TR><TD  BGCOLOR="#FFFFEA">
                <FONT face ="Constantia" SIZE="2">
		<ul>
                        <li> A restaura&ccedil;&atilde;o de um Backup sobrep&otilde;e os dados atuais;
			<li> Realize um backup antes de executar, caso ainda n&atilde;o tenha feito;
			<li> Caso tenha d&uacute;vidas consulte o manual antes de executar.

		</ul>

		</TD></TR>
		</TABLE></TD></TR>

<br>
<table width="700" border="0" cellspacing="0" cellppading="0" ><tr><td>
<div id="mensagem" class="processa" style="visibility:hidden"><img src="imagens/ajax-loader.gif" alt=""> Espere, realizando restore...</div>
</td></tr></table>
<table width="650" border="0" cellspacing="0" cellppading="0" class="lista"><tr><td>
	<table width="100%" border="0" cellspacing="1" cellpadding="0">
	<tr class="cabec">
		<td width="8%"><div align="center"><strong><font size="2">Ord</font></strong></div></td>
		<td width="40%" align="center"><strong><font size="2">Nome do Arquivo</font></strong></td>
		<td width="25%" align="right"><strong><font size="2">Tamanho</font></strong></td>
		<td width="30%" align="center"><strong><font size="2">Data/Hora</font></strong></td>
		<td width="15%" align="center"><strong><font size="2">Restaurar</font></strong></td>
		<td width="15%" align="center"><strong><font size="2">Excluir</font></strong></td>
	</tr>

	<?
		$dir = $fachadaSist2->getBackupDir();
		$arquivos = scandir($dir,1);
		$contador = 0;
		$ord = 0;
		while ($arquivos[$contador] != null) {
			if (substr($arquivos[$contador],0,3) == 'bkp') {
				$ord++;
				$valor = $arquivos[$contador];
				$adata = explode("-",$valor);
				$data = $adata[3] . '/' . $adata[2] . '/' . $adata[1] . '  ' . $adata[4] . ':' . substr($adata[5],0,2);

				$tamanho = sprintf("%u", filesize($dir.$valor));
				$tamanho = round($tamanho/1024);
				echo '<tr id='.$ord.' onMouseOut="outLinha('.$ord.')" onMouseOver="overLinha('.$ord.')" bgcolor="#F5F5F5">
	     		      <td align="center">'.$ord.'</td>
		    		  <td align="center">'.$valor.'</td>
		    		  <td align="center">'.$tamanho.' Kb</td>
		    		  <td align="center">'.$data.'</td>
			    	  <td align="center"><a href="javascript:recuperaExclui(\''.$valor.'\',\'Recuperar\')">
				    		<img src="./imagens/anexo.png" border=0 title="Restaurar backup" alt=""></a></td>
				      <td align="center"><a href="javascript:recuperaExclui(\''.$valor.'\',\'Excluir\')">
				  	    	<img src="./imagens/excluir.png" border=0 title="Excluir arquivo de backup" alt=""></a></td>';
			}//fim do if
			$contador++;
		}//fim do while
	?>
	</table></td></tr>
</table><br>
<table width="650" border="0" cellspacing="0" cellppading="0" id="refimport"><tr>
	<td valign="center"><img src="./imagens/upload.png" border=0 title="Importar arquivo de backup" alt="">
	<a href="javascript:mostraForm()">Importar Backup</a></td>
</table>
<form name="recovery" method="post" action="tablerecovery.php">
	<input name="executar" type="hidden" value="">
	<input name="arquivo" type="hidden" value="">
</form>

<div id="formUpload" STYLE="VISIBILITY:hidden">
<form enctype="multipart/form-data" action="carrega_backup.php" method="post">
	<table width="700" border="0" cellspacing="0" cellppading="0" class="lista"><tr><td>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr class="cabec"><td>Carrega Arquivo de Backup</td>
	<TR><TD  BGCOLOR="white" align="center"><br>
		<input type="hidden" name="MAX_FILE_SIZE" value="100000000" size="90"/>
		Arquivo:&nbsp;<input name="userfile" type="file" size="90" />&nbsp;</tr></td>
	<TR><TD  BGCOLOR="white" align="center"><br>
		<input type="submit" value="Carregar" />&nbsp;&nbsp;
		<input type="button" value="Cancelar" onClick="cancelar()"/><br>&nbsp;
	</td>
	</TR></table>
	</TD></TR></TABLE>
</form>
</div>
</center>
</BODY>
</HTML>
