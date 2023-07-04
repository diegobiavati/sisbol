<? 	session_start();
	require_once('./filelist_geral.php');
	$fachadaSist2 = new FachadaSist2();
    $funcoesPermitidas = $fachadaSist2->lerColecaoAutorizada($_SESSION['NOMEUSUARIO'], 'X');
	$apresentacao = new Apresentacao($funcoesPermitidas);

	
	$iniFile = new IniFile('../../sisbol.ini');
    $bandIniFile = new BandIniFile($iniFile);
	$uploaddir 	= $bandIniFile->getImportBackupDir();
	$namefile 	= $_FILES['userfile']['name'];
	$uploadfile = $uploaddir . $namefile;

	//die(substr($namefile,0,9));
	if(substr($namefile,0,9) !== "bkpSisBol"){
		echo "<script>
				window.alert('O arquivo não tem o nome esperado. Consulte o Manual. arquivo:".$namefile."')
				window.location.href='tablerecovery.php';
			 </script>";

	}
	//echo $uploaddir . $_FILES['userfile']['tmp'];
	if (!move_uploaded_file($_FILES['userfile']['tmp_name'], $uploaddir . $_FILES['userfile']['name'])) {
	   	echo "<script>
				window.alert('Ocorreu um erro inesperado com a carga do arquivo. ".$_FILES['userfile']['error'].".')
				window.location.href='tablerecovery.php';
			 </script>";
	} else {
	   	echo "<script>
				window.alert('Arquivo carregado com sucesso.');
				window.location.href='tablerecovery.php';
			 </script>";
	}
?>

