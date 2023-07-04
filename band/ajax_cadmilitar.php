<? 	session_start(); 
	require_once('./filelist_geral.php');
	require_once('./filelist_militar.php');
	require_once('./filelist_funcao.php');
	require_once('./filelist_pgrad.php');
	require_once('./filelist_qm.php');
	require_once('./filelist_om.php');
	$fachadaSist2 = new FachadaSist2();
    $funcoesPermitidas = $fachadaSist2->lerColecaoAutorizada($_SESSION['NOMEUSUARIO'], 'X');	
	$apresentacao = new Apresentacao($funcoesPermitidas);
	$idt=$_GET['idt'];
	
	if ($_GET["opcao"] == "ativaPessoa"){
		$fachadaSist2->ativaPessoa($idt);	
	}
	if ($_GET["opcao"] == "desativaPessoa"){
		$fachadaSist2->desativaPessoa($idt);
	}
	if ($_GET["opcao"] == "excluiPessoa"){
		$Militar = $fachadaSist2->lerMilitar($idt);
		echo utf8_encode($fachadaSist2->excluirMilitar($Militar));
	}	
	if ($_GET["opcao"] == "atualizaCmboSubun"){
 		$codom = $_GET["codom"];
                $colSubun2 = $fachadaSist2->lerColecaoSubun($codom);
		//$colSecaoParteBi = $fachadaSist2->lerColecaoSecaoParteBi($numeroParteAtual);
		if (isset($_GET['codSubun'])){
			$codSubunAtual = $_GET['codSubun'];
		}else {
			$obj = $colSubun2->iniciaBusca1();
			if (!is_null($obj)){
				$codSubunAtual = $obj->getCod();
			} else {
				$codSubunAtual = 0;
			}
		}
		//echo 'Se&ccedil;&atilde;o:&nbsp';
		$apresentacao->montaCombo('sele_cad_subun',$colSubun2,'getCod','getSigla',$codSubunAtual,'');
		//$Militar = $fachadaSist2->lerMilitar($idt);
		//echo utf8_encode($fachadaSist2->excluirMilitar($Militar));*/
	}
?>
