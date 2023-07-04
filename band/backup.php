<? 	session_start();
	require_once('filelist_geral.php');
	$fachadaSist2 = new FachadaSist2();
    $funcoesPermitidas = $fachadaSist2->lerColecaoAutorizada($_SESSION['NOMEUSUARIO'], 'X');
	$apresentacao = new Apresentacao($funcoesPermitidas);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
<HEAD><TITLE>Gera&ccedil;&atilde;o de Backup</TITLE>

	<script type="text/javascript" src="scripts/band.js"></script>

	<script type="text/javascript">

	function geraBackup() {
		var resposta = window.confirm("Deseja gerar um novo backup?");
		if (resposta) {
			window.location.href = "backup.php?gerar=true";
		}
		else {
			return;
		}
	}

	</script>
</HEAD>
<BODY><center>

<?
	$apresentacao->chamaEstilo();
	$apresentacao->chamaCabec();
	$apresentacao->montaMenu();

	if(!file_exists('backup')) {
		try {
			system('mkdir backup',$status);
		} catch (exception $e) {
			$e->getMessage();
		}
	}

	if (isset($_GET['gerar'])) {
		$data = date('Y-m-d-H-i');
		$arquivo = $fachadaSist2->getBackupFileName().$data.'.sql';
		$comando = $fachadaSist2->getBackupCommand().' > '.$arquivo;

		try {
			system($comando,$status);
		} catch (exception $e) {
			$e-> getMessage();
		}

		if ($status == 0) {
			echo '<script> window.alert("Backup gerado com sucesso!"); </script>';
		} else {
			echo ('<script> window.alert("Falha na geração do backup.\nContate o administrador do sistema!");
				   </script>');
		}
		echo ('<script> window.location.href="backup.php"; </script>');
	}
	?>
        <h3 class="titulo">&nbsp;&nbsp;<img src="./imagens/item_dir.gif" alt="">&nbsp;Backups j&aacute; gerados</h3>
	<table width="600" border="0" cellspacing="0" class="lista"><tr><td>
	<table width="100%" border="0" cellspacing="1" >
	<tr class="cabec">
		<td width="5%"><div align="center"><strong><font size="2">Ord</font></strong></div></td>
		<td width="50%" align="center"><strong><font size="2">Nome do Arquivo</font></strong></td>
		<td width="18%" align="center"><strong><font size="2">Tamanho</font></strong></td>
		<td width="10%" align="center"><strong><font size="2">Download</font></strong></td>
	</tr>
	<?
	$arquivos = scandir($fachadaSist2->getBackupDir(),1);
	$contador = 0;
	while ($arquivos[$contador] != null) {
		$ord++;
		$caminho = $fachadaSist2->getBackupDir().'/'.$arquivos[$contador];
		$tamanho = sprintf("%u", filesize($fachadaSist2->getBackupDir().'/'.$arquivos[$contador]));
		$tamanho = round($tamanho/1024);
		if (substr($arquivos[$contador],0,3) == 'bkp') {
			echo '<tr id='.$ord.' onMouseOut="outLinha('.$ord.')" onMouseOver="overLinha('.$ord.')" bgcolor="#F5F5F5">';
			echo '<td align="center">'.$ord.'</td>';
			echo '<td>'.$arquivos[$contador].'</td>';
			echo '<td align="center">'.$tamanho.' Kb</td>';
			echo '<td align="center"><a href="down.php?filename='.$caminho.'"><img src="./imagens/bt_ok.png" border=0 alt="" title="Realizar download"></a></td></tr>';
		}
		$contador += 1;
	}
?>
</table></td></tr>
</table>
<table width="600" border="0" cellspacing="0" ><tr><td align="right">
<form name="backup" method="post" action="backup.php">
	&nbsp;<br><input type="button" value="Gerar novo backup" OnClick="javascript:geraBackup()">
</form>
</td></tr></table>
</font>
</center>
</BODY>
</HTML>
