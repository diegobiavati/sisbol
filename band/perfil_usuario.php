<? 	session_start();
	require_once('filelist_geral.php');
	require_once('./filelist_boletim.php');
	require_once('filelist_boletim.php');
	require_once('filelist_usuariofuncaotipobol.php');
	$fachadaSist2 = new FachadaSist2();
    $funcoesPermitidas = $fachadaSist2->lerColecaoAutorizada($_SESSION['NOMEUSUARIO'],'X');
	$apresentacao = new Apresentacao($funcoesPermitidas);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SisBol</title>
<? $apresentacao->chamaEstilo(); ?>
<script type="text/javascript" src="scripts/band.js"></script>
<script type="text/javascript" src="scripts/tabber.js"></script>
<script type="text/javascript">

	function carregaedit(acao) {
		document.perfilusuario.acao.value  = acao;
		document.perfilusuario.executar.value  = "true";
   		document.perfilusuario.submit();
	}
	function perfil(){
		window.location.href = "perfil_usuario.php?login="+document.perfilusuario.seleUsuario.value;
	}
	function autoriza(login, funcao,tipoBol, divName){
		url = 'ajax_autoriza_bi.php?acao=autoriza&login='+login+'&funcao='+funcao+'&tipobol='+tipoBol+'&divname='+divName;
		//alert(url);
		ajax(url,divName);
	}
	function cancela_autoriza(login, funcao,tipoBol, divName){
		url = 'ajax_autoriza_bi.php?acao=cancela&login='+login+'&funcao='+funcao+'&tipobol='+tipoBol+'&divname='+divName;
		//alert(url);
		ajax(url,divName);
	}
</script>
<style type="text/css">
	.tabberlive .tabbertab {
 		padding:5px;
 		border:1px solid #006633;
 		border-top:0;
 		background-color: #fff;
	}
	</style>
</head>
<body>
<center>
  <? 	$apresentacao->chamaCabec();
		$apresentacao->montaMenu();
	?>
  <h3 class="titulo">&nbsp;&nbsp;<img src="./imagens/item_dir.gif" alt="">&nbsp;Perfil do Usuário - Tipo Boletim</h3>
  <form  method="post" name="perfilusuario" action="">
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

		if (isset($_POST['executar'])) {
			$usuario = $fachadaSist2->lerUsuario($login);
			if ($_POST['acao'] == 'Incluir') {
				if (isset($_POST['vetor'])) {
					foreach ($_POST['vetor'] as $codigo) {
						$funcao = $fachadaSist2->lerFuncaoDoSistema($codigo);
						$fachadaSist2->incluirUsuarioFuncao($usuario,$funcao);
					}
				}
			}
			if ($_POST['acao'] == 'Excluir') {
				if (isset($_POST['vetor'])) {
					foreach ($_POST['vetor'] as $codigo) {
						$funcao = $fachadaSist2->lerFuncaoDoSistema($codigo);
						$fachadaSist2->excluirUsuarioFuncao($usuario,$funcao);
					}
				}

			}
		}
	?>
      <br>
    <table border="0" width="<?=$TableLargura?>" >
    <tr>
    <td><div class="tabber" id="mytab1" align="left">
      <div class="tabbertab tabberdefault" title="Funções Autorizadas" align="right">
        <?
		$TableLargura = 350;
		$colTipoBol2 = $fachadaSist2->lerColecaoTipoBol('cod');
  		$tipoBol = $colTipoBol2->iniciaBusca1();
  		echo "<font color='Red'><b><img src='./imagens/alterar.png' alt=''> Legenda: </b> </font>";
                while ($tipoBol != null){
			echo $tipoBol->getCodigo()."-".$tipoBol->getAbreviatura()." | ";
			$TableLargura += 50;
			$TableCabec .= '<td width="50" align="center"><strong><font size="2">'.$tipoBol->getCodigo().'</font></strong></td>';
			$tipoBol = $colTipoBol2->getProximo1();
  		}
  		function buscaFuncaoTipoBol($login,$funcao,$assocBol){
			global $colTipoBol2, $fachadaSist2;
			$tipoBol = $colTipoBol2->iniciaBusca1();

			while ($tipoBol != null){
				if($assocBol == 'S'){
					$usuarioTipoBol = $fachadaSist2->lerUsuarioFuncaoCodTipoBol($login, $funcao, $tipoBol->getCodigo());
					$retorno .= '<td width="50" align="center" bgcolor="#F5F5F5">';
					$divName = "div".$funcao."_".$tipoBol->getCodigo();
					if($usuarioTipoBol == null){
						$link = '<img src="./imagens/naprovada.png" border="0" alt="">';
						$funcaoJavascript = "javascript:autoriza('".$login."',".$funcao.",".$tipoBol->getCodigo().",'".$divName."')";
					} else {
						$link = '<img src="./imagens/check.gif" border="0" alt="">';
						$funcaoJavascript = "javascript:cancela_autoriza('".$login."',".$funcao.",".$tipoBol->getCodigo().",'".$divName."')";
					}
					$retorno .= '<div id="'.$divName.'"><a href="'.$funcaoJavascript.'" title="'.$tipoBol->getDescricao().'">'.$link.'</a></div></td>';
				} else {
					$retorno .= '<td width="50" align="center"><strong><font size="2">-</font></strong></td>';
				}
				$tipoBol = $colTipoBol2->getProximo1();
  			}
			return $retorno;
  		}
	?>
        <br>
        <br>
        <table width="<?=$TableLargura?>" border="0" cellspacing="0" class="lista">
          <tr>          
          <td>
		  <table width="<?=$TableLargura?>" border="0" cellspacing="1" >
              <tr class="cabec">
                <td width="50"><div align="center"><strong><font size="2">Ord</font></strong></div></td>
                <td width="50" align="center"><strong><font size="2">Código</font></strong></td>
                <td width="200%" align="center"><strong><font size="2">Função</font></strong></td>
                <td width="50" align="center"><strong><font size="2">Excluir</font></strong></td>
                <?=$TableCabec?>
              </tr>
              <?php
		$colAutorizada = $fachadaSist2->lerColecaoAutorizada($login, 'X');
		$autorizada = $colAutorizada->iniciaBusca1();
		$ord = 0;
  		while ($autorizada != null){
			$ord++;
			echo '<tr id='.$ord.' onMouseOut="outLinha('.$ord.')" onMouseOver="overLinha('.$ord.')" bgcolor="#F5F5F5">
				<td align="center">'.$ord.'</td>
				<td align="center">'.$autorizada->getCodigo().'</td>
				<td align="left">'.$autorizada->getDescricao().'</td>
				<td align="center">';

			echo '<input type="checkbox" name="vetor[]" value="'.$autorizada->getCodigo().'"></td>';
			echo buscaFuncaoTipoBol($login,$autorizada->getCodigo(),$autorizada->getAssocTipoBol());
			echo '</tr>';

    		$autorizada = $colAutorizada->getProximo1();
    	}
		?>
              
              
            </table>
			</td></tr>          
        </table>
        <table width="<?=$TableLargura?>" border="0">
          <tr>
            <td width="80%"><img src="./imagens/check.gif" title="Alterar" border=0 alt="">&nbsp;Autorizado.&nbsp; <img src="./imagens/naprovada.png" title="Alterar" border=0 alt="">&nbsp;Não autorizado.&nbsp; </td>
            <td align="right" width="20%"><input name="excluidas" type="button" value="Excluir" onClick="javascript:carregaedit('Excluir')">
            </td>
          </tr>
        </table>
      </div>
      <!--fechamento do primeiro div tabbertab -->
      <div class="tabbertab" title="Funções Não Autorizadas">
        <table width="<?=$TableLargura?>" border="0" cellspacing="0"  class="lista">
          <tr>
            <td><table width="<?=$TableLargura?>" border="0" cellspacing="1" >
                <tr class="cabec">
                  <td width="4%"><div align="center"><strong><font size="2">Ord</font></strong></div></td>
                  <td width="16%" align="center"><strong><font size="2">Código</font></strong></td>
                  <td width="60%" align="center"><strong><font size="2">Função</font></strong></td>
                  <td width="20%" align="center"><strong><font size="2">Incluir</font></strong></td>
                </tr>
                <?php
		$colNaoAutorizada = $fachadaSist2->lerColecaoNaoAutorizada($login, 'X');
		$naoAutorizada = $colNaoAutorizada->iniciaBusca1();
		$ord = 0;
  		while ($naoAutorizada != null){
			$ord++;
			echo '<tr id='.$ord.' onMouseOut="outLinha('.$ord.')" onMouseOver="overLinha('.$ord.')" bgcolor="#F5F5F5">
				<td align="center">'.$ord.'</td>
				<td align="center">'.$naoAutorizada->getCodigo().'</td>
				<td align="left">'.$naoAutorizada->getDescricao().'</td>
				<td align="center">';

            //verifica permissao
            if ($_SESSION['NOMEUSUARIO'] != 'supervisor')
            { $mIncluir = $funcoesPermitidas->lerRegistro(1164);
            }
            if (($mIncluir != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor'))
            { echo '<input type="checkbox" name="vetor[]" value="'.$naoAutorizada->getCodigo().'">';
            }

			echo '</td></tr>';
    		$naoAutorizada = $colNaoAutorizada->getProximo1();
    	}


		?>
              </table></td>
          </tr>
        </table>
        <table width="<?=$TableLargura?>" border="0">
          <tr>
            <td width="80%"></td>
            <td align="right" width="20%"><input name="incluidas" type="button" value="Incluir" onClick="javascript:carregaedit('Incluir')">
            </td>
          </tr>
        </table>
      </div>
      <!--fechamento do segundo div tabbertab -->
	 
	  </div>
	   </table>
  </form>
</center>
</body>
</html>
