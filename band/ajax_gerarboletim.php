<html>
<head>
<script>
//	var janelaPDF;
//	function viewPDF2(url){
//		if ((janelaPDF == undefined)){
//			janelaPDF = window.open(url,"","height=500,width=900");
//		}
//		if (janelaPDF.closed){
//			janelaPDF = window.open(url,"","height=500,width=900");
//		}
//		if (janelaPDF != null){
//			janelaPDF.focus();
//		}
//	}

</script>
</head>
<? 	session_start();
	require_once('./filelist_geral.php');
	$fachadaSist2 = new FachadaSist2();
    $funcoesPermitidas = $fachadaSist2->lerColecaoAutorizada($_SESSION['NOMEUSUARIO'], 'X');
	$apresentacao = new Apresentacao($funcoesPermitidas);
	$boletim = $fachadaSist2->lerBoletimPorCodigo($_POST['cod']);
		//a chamada para o código que gera o PDF deve estar no início do código PHP
	if (isset($_POST['original'])) {
		$original = 'S';
	} else {
		$original = 'N';
	}
	$Tipo_Bol = $_GET['TipoBol'];
	$fachadaSist2->gerarBoletim($boletim,$original);
	$arq = $fachadaSist2->getOutPutBolDir().$boletim->getDataPub()->getcDataYYYYHMMHDD() . "_" .
    $apresentacao->formataNumBi($boletim->getNumeroBi()) . '_'. ereg_replace(' ','_',$Tipo_Bol) . ".pdf";
	echo '<script>javascript:viewPDF2("'.$arq.'");</script>';
		//echo '<script>window.alert("Boletim gerado com sucesso!");</script>';

	?>
</html>
