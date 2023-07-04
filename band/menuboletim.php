<? 	session_start(); 
	require('filelist_geral.php');
	//$configuracao = new Configuracao();
	//$configuracao->verificaConexao();
	$fachadaSist2 = new FachadaSist2();
    $funcoesPermitidas = $fachadaSist2->lerColecaoAutorizada($_SESSION['NOMEUSUARIO'], 'X');	
	$apresentacao = new Apresentacao($funcoesPermitidas);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> <title> Sisbol </title>
	<? $apresentacao->chamaEstilo(); ?>
	<script type="text/javascript" src="scripts/band.js"></script>
</head>
	<body><center>
	<? 	$apresentacao->chamaCabec();
		$apresentacao->montaMenu();
		


	?>
	</center>
</body>
</html>
