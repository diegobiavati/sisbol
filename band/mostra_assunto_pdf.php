<? 	session_start(); 
	require_once('./filelist_geral.php');
	require_once('./filelist_assunto.php');
	require_once('./filelist_boletim.php');
	require_once('./filelist_tipodoc.php');
	require_once('./filelist_pdf.php');
	//define("FPDF_FONTPATH", "C:/Arquivos de programas/VertrigoServ/www/band/classes/fpdf/font/");
	//$fpdfFontDir = $this->bandIniFile->getFPDFFontDir();
	//private $pdf;
	$fachadaSist2 = new FachadaSist2();
    $funcoesPermitidas = $fachadaSist2->lerColecaoAutorizada($_SESSION['NOMEUSUARIO'], 'X');	
	$apresentacao = new Apresentacao($funcoesPermitidas);
	
	$codAssGer = $_GET['codAssGer'];
	$codAssEsp = $_GET['CodAssEsp'];
	//echo $codAssGer.'<br>';
	//echo $codAssEsp;
	
	$assuntoEspecifico = $fachadaSist2->lerAssuntoEspec($codAssGer,$codAssEsp);
	
	$texto = $assuntoEspecifico->getTextoPadAbert();
	$texto .= $assuntoEspecifico->getTextoPadFech();
	
	//$texto = $codMateria;
	
	//$texto2 = $_GET['htmlPDF_textoAbert'];
	//echo '<script>alert("'.$texto2.'");</script>';
	//$texto = "teste";
	
	//die($texto);
	$pdf = new html2fpdf('P','mm','A4');

    $pdf->SetMargins(15,20,15);
	$pdf->SetAutoPageBreak(true,17);
	$pdf->AddPage();
	$pdf->WriteHTML(rtrim($texto));
	
	$pdf->Output("teste.pdf" , "I");
?>
