<? 	session_start(); 
	require('filelist_geral.php');
	$fachadaSist2 = new FachadaSist2();
    $funcoesPermitidas = $fachadaSist2->lerColecaoAutorizada($_SESSION['NOMEUSUARIO'], 'X');	
	$apresentacao = new Apresentacao($funcoesPermitidas);
?>
<html>
<head>
	<? $apresentacao->chamaEstilo(); ?>
	<script src="scripts/band.js"></script>
</head>
<body>
<center>

<? 	
	$apresentacao->chamaCabec();
	$apresentacao->montaMenu();
	
	if (isset($_POST['sair'])) {
		unset($_SESSION['NOMEUSUARIO']);
		session_destroy();
		echo '<script> window.location.href="sisbol.php"; </script>';
	}
?>

<form  method="post" name="saida" action="logout.php">
		<input name="sair" type="hidden" value="">
</form>

<script>
 		var resposta = window.confirm("Deseja realmente sair do sistema?");
 		if (!resposta) {
 			//window.location.href="menuboletim.php";
 			history.back();
		} else {
			document.saida.sair.value = 'true';
			document.saida.submit();			
		}
</script>
			
</center>
</body>
</html>
