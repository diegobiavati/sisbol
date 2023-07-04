<?session_start();
	require_once('./filelist_geral.php');
	require_once('./filelist_boletim.php');
	$fachadaSist2 = new FachadaSist2();
    $funcoesPermitidas = $fachadaSist2->lerColecaoAutorizada($_SESSION['NOMEUSUARIO'], 'X');
	$apresentacao = new Apresentacao($funcoesPermitidas);



	$colParteBoletim2 = $fachadaSist2->lerColecaoParteBoletim('numero_parte');
$parteBoletim = $colParteBoletim2->iniciaBusca1();
$ord = 0;
while ($parteBoletim != null){
	$ord++;
	echo $parteBoletim->getNumeroParte().''.$parteBoletim->getDescrReduz().''.$parteBoletim->getDescricao();
 }


?>
