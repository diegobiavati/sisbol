<?php
	require_once('./apresentacao.php');
	require_once('./classes/inifile/inifile.php');
	require_once('./classes/band/bandinifile.php');
	require_once('./classes/band/supinifile.php');
	require_once('./classes/band/configuracao.php');  
	require_once('./classes/band/fachadasist2.php');
	require_once('./classes/meulinkdb/meulinkdb.php');

	require_once('./classes/funcaodosistema/funcaodosistema.php');
	require_once('./classes/funcaodosistema/icolfuncaodosistema.php');
	require_once('./classes/funcaodosistema/colfuncaodosistema.php');
	require_once('./classes/funcaodosistema/icolfuncaodosistema2.php');
	require_once('./classes/funcaodosistema/colfuncaodosistema2.php');
	require_once('./classes/funcaodosistema/rgrfuncaodosistema.php');

    require_once('./classes/usuario/usuario.php');
    require_once('./classes/usuario/icolusuario.php');
    require_once('./classes/usuario/colusuario.php');
    require_once('./classes/usuario/icolusuario2.php');
    require_once('./classes/usuario/colusuario2.php');
    require_once('./classes/usuario/rgrusuario.php');
	
	require_once('./classes/usuariofuncao/icolusuariofuncao.php');
	require_once('./classes/usuariofuncao/colusuariofuncao.php');
	require_once('./classes/usuariofuncao/rgrusuariofuncao.php');
	require_once('./classes/minhadata/minhadata.php');
	require_once('./classes/tempos/tempos.php');

	require_once('./classes/configuracoes/icolconfiguracoes.php');
	require_once('./classes/configuracoes/colconfiguracoes.php');
	require_once('./classes/configuracoes/rgrconfiguracoes.php');
	require_once('./classes/configuracoes/configuracoes.php');

/*	$fachadaSist2 		= new FachadaSist2();
    $funcoesPermitidas 	= $fachadaSist2->lerColecaoAutorizada($_SESSION['NOMEUSUARIO'], 'X');	
	$apresentacao 		= new Apresentacao($funcoesPermitidas);*/

	function encriptaSenha($senha){
		return strrev( md5( strrev( md5( $senha ) ) ) );
	}

	function comparaSenha($senha, $var){
		if($senha === strrev(md5(strrev(md5($var))))){
			return true;
		} else {
			return false;
		}
	}
?>
