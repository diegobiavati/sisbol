<? 	session_start(); 
	require_once('./filelist_geral.php');
	require_once('./filelist_boletim.php');
	require_once('./filelist_controladoras.php');
	require_once('./filelist_militar.php');
	require_once('./filelist_pgrad.php');
	require_once('./filelist_qm.php');
	require_once('./filelist_om.php');
	require_once('./filelist_funcao.php');
	require_once('./filelist_tipodoc.php');
	require_once('./filelist_pdf.php');
	require_once('./filelist_usuariofuncaotipobol.php');
	
	$fachadaSist2 = new FachadaSist2();
        $funcoesPermitidas = $fachadaSist2->lerColecaoAutorizada($_SESSION['NOMEUSUARIO'], 'X');
	$apresentacao = new Apresentacao($funcoesPermitidas);
	$materiaBi = $fachadaSist2->lerRegistroMateriaBI($_GET['codMatBi']);
	$arq = $fachadaSist2->gerarMateriaBi($materiaBi);
	echo $arq;
?>

