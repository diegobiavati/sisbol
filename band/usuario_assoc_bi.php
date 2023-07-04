<? 	session_start();
	require_once('filelist_geral.php');
	require_once('filelist_boletim.php');
	require_once('filelist_usuariofuncaotipobol.php');
	$fachadaSist2 = new FachadaSist2();
    $funcoesPermitidas = $fachadaSist2->lerColecaoAutorizada($_SESSION['NOMEUSUARIO'],'X');
	$apresentacao = new Apresentacao($funcoesPermitidas);
?>
<html>
<head>
	<? $apresentacao->chamaEstilo(); ?>
	<script src="scripts/band.js"></script>
	<script type="text/javascript" src="scripts/tabber.js"></script>
	<script>

	function carregaedit(acao) {
		document.ufstb.acao.value  = acao;
		document.ufstb.executar.value  = "true";
   		document.ufstb.submit();
	}
	function perfil(){
		window.location.href = "usuario_assoc_bi.php?login="+document.ufstb.seleUsuario.value;
	}
	function funcsis(){
		window.location.href = "usuario_assoc_bi.php?login="+document.ufstb.seleUsuario.value+
		"&funcao="+document.ufstb.seleFuncao.value;
	}
	</script>
	<style type="text/css">
	.tabberlive .tabbertab {
 		padding:5px;
 		border:2px solid #aaa;
 		border-top:0;
 		background-color: #fff;
	}
	</style>
</head>
<body><center>
	<? 	$apresentacao->chamaCabec();
		$apresentacao->montaMenu();
	?>

	<h3 class="titulo">&nbsp;&nbsp;<img src="./imagens/item_dir.gif">&nbsp;Perfil por Tipo de Boletim</h3>
	<form  method="post" name="ufstb">
	<input name="executar" type="hidden" value="">
	<input name="codigo" type="hidden" value="">
	<input name="acao" type="hidden" value="">
	<p>Usuário:&nbsp;

	<?
		$colUsuario = $fachadaSist2->lerColecaoUsuario();
		if (isset($_GET['login'])){
			$login = $_GET['login'];
		}else {
			$obj = $colUsuario->iniciaBusca1();
			if (!is_null($obj)){
				$login = $obj->getLogin();
			} else {
				$login = '';
			}
		}
		$apresentacao->montaCombo('seleUsuario',$colUsuario,'getLogin','getLogin',$login,'perfil()');
		echo '<br><br><p>Função do Sistema:&nbsp;';


		$colFuncao = $fachadaSist2->lerColecaoAutorizada($login,'S');
		if (isset($_GET['funcao'])){
			$funcao = $_GET['funcao'];
		}else {
			$obj = $colFuncao->iniciaBusca1();
			if (!is_null($obj)){
				$funcao = $obj->getCodigo();
			} else {
				$funcao = '';
			}
		}
		$apresentacao->montaCombo('seleFuncao',$colFuncao,'getCodigo','getDescricao',$funcao,'funcsis()');


		if (isset($_POST['executar'])) {
			$objUsuario = $fachadaSist2->lerUsuario($login);
			$objFuncao = $fachadaSist2->lerFuncaoDoSistema($funcao);
			if ($_POST['acao'] == 'Incluir') {
				if (isset($_POST['vetor'])) {
					foreach($_POST['vetor'] as $codigo) {
						$objTipoBol = $fachadaSist2->lerTipoBol($codigo);
						$fachadaSist2->incluirUsuarioFuncaoTipoBol($objUsuario,$objFuncao,$objTipoBol);
					}
				}
			}
			if ($_POST['acao'] == 'Excluir') {
				if (isset($_POST['vetor'])) {
					foreach($_POST['vetor'] as $codigo) {
						$objTipoBol = $fachadaSist2->lerTipoBol($codigo);
						$fachadaSist2->excluirUsuarioFuncaoTipoBol($objUsuario,$objFuncao,$objTipoBol);
					}
				}
			}
		}
	?>
	<br><br><br>
	<table border="0" width="830"><tr><td>
	<div class="tabber" id="mytab1" align="left">
	<div class="tabbertab tabberdefault" title="Tipos de Boletins Autorizados">
	<table width="830"'" border="0" cellspacing="0" cellppading="0" class="lista"><tr><td>
	<table width="100%" border="0" cellspacing="1" cellpadding="0">
	<tr class="cabec">
		<td width="4%"><div align="center"><strong><font size="2">Ord</font></strong></div></td>
		<td width="16%" align="center"><strong><font size="2">Código</font></strong></td>
		<td width="60%" align="center"><strong><font size="2">Descrição</font></strong></td>
		<td width="20%" align="center"><strong><font size="2">Excluir</font></strong></td>
	</tr>
	<?php
		if (($login != null) && ($funcao != null)) {
			$colAutorizada = $fachadaSist2->lerColecaoAutorizadaTipoBol($login, $funcao);
			$autorizada = $colAutorizada->iniciaBusca1();
		} else {
			$colAutorizada = null;
			$autorizada = null;
		}
		$ord = 0;
  		while ($autorizada != null){
			$ord++;
			echo '<tr id='.$ord.' onMouseOut="outLinha('.$ord.')" onMouseOver="overLinha('.$ord.')" bgcolor="#F5F5F5">
				<td align="center">'.$ord.'</td>
				<td align="center">'.$autorizada->getCodigo().'</td>
				<td align="center">'.$autorizada->getDescricao().'</td>
				<td align="center">';

            //verifica permissao
            if ($_SESSION['NOMEUSUARIO'] != 'supervisor')
            { $mExcluir = $funcoesPermitidas->lerRegistro(1183);
            }
            if (($mExcluir != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor'))
            { echo '<input type="checkbox" name="vetor[]" value="'.$autorizada->getCodigo().'">';
            }
			echo '</a></td></tr>';
    		$autorizada = $colAutorizada->getProximo1();
    	}
		?>
  		</tr></table></td></tr>
	</table>
	<table width="830"'" border="0">
	<tr><td width="80%"></td><td align="center" width="20%">
		<input name="excluidas" type="button" value="Excluir" onclick="javascript:carregaedit('Excluir')">
	</td></tr>
	</table>
	</div><!--fechamento do primeiro div tabbertab -->

	<div class="tabbertab" title="Tipos de Boletins Não Autorizados">
	<table width="830"'" border="0" cellspacing="0" cellppading="0" class="lista"><tr><td>
	<table width="100%" border="0" cellspacing="1" cellpadding="0">
	<tr class="cabec">
		<td width="4%"><div align="center"><strong><font size="2">Ord</font></strong></div></td>
		<td width="16%" align="center"><strong><font size="2">Código</font></strong></td>
		<td width="60%" align="center"><strong><font size="2">Descrição</font></strong></td>
		<td width="20%" align="center"><strong><font size="2">Incluir</font></strong></td>
	</tr>
	<?php
		if (($login != null) && ($funcao != null)) {
			$colNaoAutorizada = $fachadaSist2->lerColecaoNaoAutorizadaTipoBol($login, $funcao);
			$naoAutorizada = $colNaoAutorizada->iniciaBusca1();
		} else {
			$colNaoAutorizada = null;
			$naoAutorizada = null;
		}
		$ord = 0;
  		while ($naoAutorizada != null){
			$ord++;
			echo '<tr id='.$ord.' onMouseOut="outLinha('.$ord.')" onMouseOver="overLinha('.$ord.')" bgcolor="#F5F5F5">
				<td align="center">'.$ord.'</td>
				<td align="center">'.$naoAutorizada->getCodigo().'</td>
				<td align="center">'.$naoAutorizada->getDescricao().'</td>
				<td align="center">';

            //verifica permissao
            if ($_SESSION['NOMEUSUARIO'] != 'supervisor')
            { $mIncluir = $funcoesPermitidas->lerRegistro(1181);
            }
            if (($mIncluir != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor'))
            { echo '<input type="checkbox" name="vetor[]" value="'.$naoAutorizada->getCodigo().'">';
            }
			echo '</a></td></tr>';
    		$naoAutorizada = $colNaoAutorizada->getProximo1();
    	}
		?>
  		</tr></table></td></tr>
	</table>
	<table width="830"'" border="0">
	<tr><td width="80%"></td><td align="center" width="20%">
		<input name="incluidas" type="button" value="Incluir" onclick="javascript:carregaedit('Incluir')">
	</td></tr>
	</table>
	</div><!--fechamento do segundo div tabbertab -->

	</div><!--fechamento do div tabber -->
	</td></tr></table>
	</form>
	</center>
</body>
</html>
