<?  session_start();
	require_once('filelist_geral.php');
	$fachadaSist2 = new FachadaSist2();
    $funcoesPermitidas = $fachadaSist2->lerColecaoAutorizada($_SESSION['NOMEUSUARIO'], 'X');
	$apresentacao = new Apresentacao($funcoesPermitidas);

	$acao = $_GET['acao'];
	$file = trim($_GET['nome']);
	//echo $acao.'  '.$file;
	if (isset($acao)) {
		$file = $fachadaSist2->getBackupDir().$file;
		//echo $acao . '  '.$file;
		if (trim($acao) == 'Recuperar') {
			$comando = $fachadaSist2->getRestoreCommand().' < '.$file;
			echo "<font color='blue'>&nbsp;&nbsp;Espere, executando o restore...</font>";
			//echo $_GET['acao'];
			try {
				system($comando,$status);
			} catch (exception $e) {
				$e->getMessage();
			}
			if ($status == 0) {
				//echo '<script> window.alert("Recuperação executada com êxito!"); </script>';
				echo 'Arquivo: '.trim($_GET['nome']).' recuperado com Sucesso.';
			} else {
				echo 'Falhou na recuperação do arquivo: '.trim($_GET['nome']).' .';
			}
		}
		if (trim($acao) == 'Excluir') {
			system($fachadaSist2->getDeleteCommand().' '.$file,$status);
			if ($status == 0) {
				echo '<script> window.alert("Arquivo apagado com sucesso!"); </script>';
			} else {
				echo ('<script> window.alert("A tentativa de excluir o arquivo falhou.\nContate o administrador do sistema!"); </script>');
			}
		}
			//echo ('<script> window.location.href="tablerecovery.php"; </script>');
	}
?>
