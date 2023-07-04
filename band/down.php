<?php
 	session_start(); 
 	require_once('filelist_geral.php');
	$fachadaSist2 = new FachadaSist2();
    $funcoesPermitidas = $fachadaSist2->lerColecaoAutorizada($_SESSION['NOMEUSUARIO'], 'X');	
	$apresentacao = new Apresentacao(null);

$arquivo = $_GET['filename'];
//header("Content-type: application/save");
header('Content-Disposition: attachment; filename="' . basename($arquivo) . '"');
//header("Content-Length: ".filesize($arquivo));
header('Expires: 0');
header('Pragma: no-cache');
readfile("$arquivo");
?>

