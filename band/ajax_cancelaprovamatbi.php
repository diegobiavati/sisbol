<? 	session_start(); 
	require('filelist_geral.php');
	require_once('./filelist_boletim.php');
	require_once('./filelist_tipodoc.php');
	$fachadaSist2 = new FachadaSist2();
    $funcoesPermitidas = $fachadaSist2->lerColecaoAutorizada($_SESSION['NOMEUSUARIO'], 'X');	
	$apresentacao = new Apresentacao($funcoesPermitidas);
	if(!empty($_GET["opcao"])){ 
		if ($_GET["opcao"] == "cancelaAprova"){ 
			$codMateriaBI = $_GET['codMateriaBI'];
			$materiaBi = $fachadaSist2->lerRegistroMateriaBI($codMateriaBI);
			
			echo '<b>'.$materiaBi->getDescrAssGer().'</b><br>';
   			echo '&nbsp;&nbsp;-<b>'.$materiaBi->getDescrAssEsp().'</b><br><br>';
   			echo  $materiaBi->getTextoAbert().'<br><br>';
			echo $materiaBi->getTextoFech();	
		}
	}	
?>
