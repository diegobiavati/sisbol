<? 	session_start();
	require_once('./filelist_geral.php');
	require_once('./filelist_assunto.php');
	$fachadaSist2 = new FachadaSist2();
    $funcoesPermitidas = $fachadaSist2->lerColecaoAutorizada($_SESSION['NOMEUSUARIO'], 'X');
	$apresentacao = new Apresentacao($funcoesPermitidas);


	//marco
	if ($_GET["opcao"] == "cadAssuntoEspecifico"){
		$codAssuntoGeral = $_GET["codGeral"];
		$codAssuntoEspecifico = $_GET["codEspecifico"];
		$assuntoEspecifico = $fachadaSist2->lerAssuntoEspec($codAssuntoGeral,$codAssuntoEspecifico);
		if (isset($_GET["flyframe"])){
			echo '<h4>'.$assuntoEspecifico->getDescricao()."</h4>";
			echo $assuntoEspecifico->getTextoPadAbert().'<br>';
			echo $assuntoEspecifico->getTextoPadFech();
		} else {
			$texto = utf8_encode($assuntoEspecifico->getVaiAlteracao());
			$texto .= utf8_encode($assuntoEspecifico->getVaiIndice());
			$texto .= utf8_encode($assuntoEspecifico->getTextoPadAbert()).'$wxxw$';
			$texto .= utf8_encode($assuntoEspecifico->getTextoPadFech());
			//die($texto);
			echo trim($texto);
		}
	}
?>
