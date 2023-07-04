<? 	session_start(); 
	require_once('filelist_geral.php');
	$fachadaSist2 = new FachadaSist2();
    $funcoesPermitidas = $fachadaSist2->lerColecaoAutorizada($_SESSION['NOMEUSUARIO'], 'X');	
	$apresentacao = new Apresentacao($funcoesPermitidas);
	
	
	//marco
	if ($_GET["opcao"] == "buscaMateriaBI_Elab"){ 
			$codMateriaBI = $_GET['codMateriaBI'];
			$materiaBi = $fachadaSist2->lerRegistroMateriaBI($codMateriaBI);
			
			echo '<b>'.$materiaBi->getDescrAssGer().'</b><br>';	
			echo '&nbsp;&nbsp;-&nbsp;<b>'.$materiaBi->getDescrAssEsp().'<b><br><br>';	
			echo '<p align="left">Texto Abertura:</p>';
			echo '<textarea cols="93" rows="10" class="tipo1">';
			echo $materiaBi->getTextoAbert();	
			echo '</textarea>';		
			echo '<p align="left">Texto Fechamento:</p>';
			echo '<textarea cols="93" rows="2" class="tipo1">';
			echo $materiaBi->getTextoFech();
			echo '</textarea>';		
	}
?>
