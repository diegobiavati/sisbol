<? 	session_start();
	require_once('./filelist_geral.php');
	require_once('./filelist_boletim.php');
	require_once('./filelist_usuariofuncaotipobol.php');


	$fachadaSist2 = new FachadaSist2();
    $funcoesPermitidas = $fachadaSist2->lerColecaoAutorizada($_SESSION['NOMEUSUARIO'], 'X');
	$apresentacao = new Apresentacao($funcoesPermitidas);

	$acao = $_GET['acao'];
	$login = $_GET['login'];
	$funcao = $_GET['funcao'];
	$tipoBol = $_GET['tipobol'];
	$divName = $_GET['divname'];

	$objUsuario = $fachadaSist2->lerUsuario($login);
	$objFuncao = $fachadaSist2->lerFuncaoDoSistema($funcao);
	$objTipoBol = $fachadaSist2->lerTipoBol($tipoBol);

	//$retorno =
	if($acao == 'autoriza'){
		$fachadaSist2->incluirUsuarioFuncaoTipoBol($objUsuario,$objFuncao,$objTipoBol);
		$retorno = "<a href='javascript:cancela_autoriza(\"".$login."\",".$funcao.",".$tipoBol.",\"".$divName."\")' title='".$objTipoBol->getDescricao()."'><img src='./imagens/check.gif' border='0'></a>";
	} else {
		$fachadaSist2->excluirUsuarioFuncaoTipoBol($objUsuario,$objFuncao,$objTipoBol);
		$retorno = "<a href='javascript:autoriza(\"".$login."\",".$funcao.",".$tipoBol.",\"".$divName."\")' title='".$objTipoBol->getDescricao()."'><img src='./imagens/naprovada.png' border='0'></a>";
	}
	//$original = $_GET['original'];
	//$boletim = $fachadaSist2->lerBoletimPorCodigo($_GET['codBol']);
	//$arq = $fachadaSist2->gerarBoletim($boletim,$original);
	echo $retorno;
?>

