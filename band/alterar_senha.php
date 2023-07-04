<? 	session_start(); 
	require_once('./filelist_geral.php');
	$fachadaSist2 = new FachadaSist2();
    $funcoesPermitidas = $fachadaSist2->lerColecaoAutorizada($_SESSION['NOMEUSUARIO'], 'X');	
	$apresentacao = new Apresentacao($funcoesPermitidas);
?>
<html>
<head>
	<? $apresentacao->chamaEstilo(); ?>
	<script src="scripts/band.js"></script>
	<script>
	
	function executa(acao){
		document.usuario.executar.value = acao;   
		if (document.usuario.senha.value == "") {
			window.alert("Informe a nova senha!");
			document.usuario.senha.focus();
			return;
		}
		if (document.usuario.confsenha.value == "") {
			window.alert("Informe a confirmação da senha!");
			document.usuario.confsenha.focus();
			return;
		}
		if (document.usuario.senha.value != document.usuario.confsenha.value) {
			window.alert("A confirmação da senha não confere! Digite novamente.");
			document.usuario.confsenha.focus();
			return;
		}	
		document.usuario.action = "alterar_senha.php";
		document.usuario.submit();
	}
	function cancelar() {
		document.usuario.senha.value  = "";
		document.usuario.confsenha.value = "";
		location.href="menuboletim.php";
	}  
 
	</script>
</head>
<body><center>
	<? 	$apresentacao->chamaCabec();
		$apresentacao->montaMenu();
	?>
	
	<h3 class="titulo">&nbsp;&nbsp;<img src="./imagens/item_dir.gif">&nbsp;Alteração de Senha</h3>
	
	<?php
		if (isset($_POST['executar'])) {   
  			$usuario = $fachadaSist2->lerUsuario($_SESSION['NOMEUSUARIO']);
  			$usuario->setSenha($_POST['senha']);
  			$fachadaSist2->alterarUsuario($usuario);
  			echo '<script> window.alert("Senha alterada com sucesso!!!");
  				           location.href="menuboletim.php";
  				  </script>';
  		}
  		
	?>
		
	<!-- Formulário para alteração de senha -->
	<form  method="post" name="usuario">
		<input name="executar" type="hidden" value="">
			<TABLE width="40%"bgcolor="#0000FF" CELLPADDING="1" ><TR><TD>
			<TABLE width="100%" border=0 BORDERCOLOR="#C0C0C0" BORDERCOLORLIGHT="#C0C0C0" CELLSPACING="0" CELLPADDING="0" name="tabela">
			<TR CLASS="cabec"><TD colspan="2"><font size="2"><div id="tituloForm"></div></font></TD></TR>
			<TD BGCOLOR="#C0C0C0">&nbsp;</td>
			<TD BGCOLOR="#C0C0C0"><br>
			Login:
			<input name="login" type="text" size="10" maxlength="10" value="<?= $_SESSION['NOMEUSUARIO'] ?>" readOnly=true><br><br>
			Digite a nova senha:
			<input name="senha" type="password" size="20" maxlength="20"><br><br>
			Confirme a nova senha:
			<input name="confsenha" type="password" size="20" maxlength="20"><br><br>
			</TD>
			</TR><TR>
			<TD BGCOLOR="#C0C0C0" align="right" colspan="2">
			<input name="acao" type="button" value="Alterar" onclick="executa(this.value)">
			<input name="cancela" type="button" value="Cancelar" onclick="cancelar()"><TD>
			</TR></table>
			</TD></TR></TABLE>
	</form>
</center>
</body>
</html>
