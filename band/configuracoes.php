<? 	session_start();
	require_once('./filelist_geral.php');
//	require_once('./filelist_om.php');
	$fachadaSist2 = new FachadaSist2();
    $funcoesPermitidas = $fachadaSist2->lerColecaoAutorizada($_SESSION['NOMEUSUARIO'], 'X');
	$apresentacao = new Apresentacao($funcoesPermitidas);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SisBol</title>
	<? $apresentacao->chamaEstilo(); ?>
	<script type="text/javascript" src="scripts/band.js"></script>
	<script type="text/javascript">
	function executa(acao){
		document.cadOM.executar.value = acao;
		document.cadOM.action = "configuracoes.php";
		document.cadOM.submit();
	}
	function sair(){
		document.cadOM.action = "menuboletim.php";
		document.cadOM.submit();
	}
	</script>
</head>
<body><center>
	<? 	$apresentacao->chamaCabec();
		$apresentacao->montaMenu();

		if (isset($_POST['executar'])){
  			$configuracoes = new Configuracoes();
			if (isset($_POST['aprov_nota_1'])){
	  			$configuracoes->setAprovNota1("S");
  			}else{
	  			$configuracoes->setAprovNota1("N");
			}
			if (isset($_POST['aprov_nota_2'])){
	  			$configuracoes->setAprovNota2("S");
  			}else{
	  			$configuracoes->setAprovNota2("N");
			}
			if (isset($_POST['aprov_boletim'])){
	  			$configuracoes->setAprovBoletim("S");
  			}else{
	  			$configuracoes->setAprovBoletim("N");
			}
			if (isset($_POST['imprime_nomes_linha'])){
	  			$configuracoes->setImprimeNomesLinha("S");
  			}else{
	  			$configuracoes->setImprimeNomesLinha("N");
			}
			if (isset($_POST['imprime_assinatura'])){
	  			$configuracoes->setImprimeAssinatura("S");
  			}else{
	  			$configuracoes->setImprimeAssinatura("N");
			}
			//Bedin
			if (isset($_POST['imprime_qms'])){
	  			$configuracoes->setImprimeQMS("S");
  			}else{
	  			$configuracoes->setImprimeQMS("N");
			}

//			if ($_POST['executar'] == 'Incluir'){
//				$fachadaSist2->incluirOM($OM);
//			}
//			if ($_POST['executar'] == 'Excluir'){
//				$fachadaSist2->excluirOM($OM);
//			}
			if ($_POST['executar'] == 'Alterar'){
				$fachadaSist2->alterarConfiguracoes($configuracoes);
			}
//			$_SESSION['ORGANIZACAO'] = $OM->getNome();
			echo "<script type='text/javascript'>window.alert('Operação realizada com sucesso!');</script>";
			echo ('<script type="text/javascript"> window.location.href="sisbol.php"; </script>');			
		}

		/*Verificar se existe uma OM cadastrada. O sistema permite apenas o cadastramento
		  de uma OM. Pode futuramente permitir a inclusão de outras via novas implementações*/
		$configuracoes = $fachadaSist2->lerConfiguracoes();
//  		$OM = $colOM2->iniciaBusca1();
  		echo '<script type="text/javascript">function carregaForm(){';
//  		if ($OM != null){
//		document.cadTipoBoletim.ini_num_paginas.checked = ini_num_paginas == "S"?true:false;
  			echo '
  			document.cadOM.aprov_nota_1.checked 	= '.($configuracoes->getAprovNota1() == "S"?1:0).';
  			document.cadOM.aprov_nota_2.checked 	= '.($configuracoes->getAprovNota2() == "S"?1:0).';
  			document.cadOM.aprov_boletim.checked 	= '.($configuracoes->getAprovBoletim() == "S"?1:0).';
			document.cadOM.imprime_nomes_linha.checked 	= '.($configuracoes->getImprimeNomesLinha() == "S"?1:0).';
			document.cadOM.imprime_assinatura.checked 	= '.($configuracoes->getImprimeAssinatura() == "S"?1:0).';
			document.cadOM.imprime_qms.checked 	= '.($configuracoes->getImprimeQMS() == "S"?1:0).';
  			document.cadOM.acao.value = "Alterar";';
//  		} else {
//  			echo '
//  			document.cadOM.cod.value 	= "1";
//  			document.cadOM.acao.value = "Incluir";';
//  		}
  		echo '}</script>';
	?>

	<h3 class="titulo">&nbsp;&nbsp;<img src="./imagens/item_dir.gif" alt="">&nbsp;Configurações</h3>

	<form  method="post" name="cadOM" action="">
		<input name="cod" type="hidden" value="1">
		<input name="executar" type="hidden" value="">
		<table width="460"  border="0" cellspacing="0" class="lista"><tr><td>
		<table width="100%" border="0" cellspacing="0" class="lista">
		<TR CLASS="cabec">
			<TD colspan="4"><div><font size="2"><b>Configurações do SisBol</b></font></div></TD>
		</TR>
		<TR>
			<TD BGCOLOR="#EAEAEA">
					<input type="checkbox" name="aprov_nota_1" value="S"> Ativar o 1º Nível de Aprovação de Nota para Boletim (SU/Div/Sec).<br>
					<input type="checkbox" name="aprov_nota_2" value="S"> Ativar o 2º Nível de Aprovação de Nota para Boletim (Cmt/Ch/Dir).<br>
					<input type="checkbox" name="aprov_boletim" value="S"> Ativar a opção de Aprovação do Boletim.<br>
					<input type="checkbox" name="imprime_nomes_linha" value="S"> Imprimir os nomes dos militares um em cada linha.<br>
					<input type="checkbox" name="imprime_assinatura" value="S"> Imprimir as imagens das assinaturas dos respectivos militares.<br>
					<input type="checkbox" name="imprime_qms" value="S"> Imprimir QMS dos militares.
					</TD>
		</TR>
		<TR>
			<TD BGCOLOR="#EFEBEF" align="left">
				<input name="acao" type="button" value="Alterar" onClick="executa(this.value)">
				<input name="acao" type="button" value="Cancelar" onClick="sair()">
			</TD>
		</TR></table>
		</TD></TR></TABLE>
	</form>
	<script type="text/javascript">javascript:carregaForm();</script>
</center>
</body>
</html>
