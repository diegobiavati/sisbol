<? 	session_start();
	require_once('filelist_geral.php');
	require_once('filelist_usuariofuncaotipobol.php');
	$fachadaSist2 = new FachadaSist2();
    $funcoesPermitidas = $fachadaSist2->lerColecaoAutorizada($_SESSION['NOMEUSUARIO'], 'X');
	$apresentacao = new Apresentacao($funcoesPermitidas);

	if (isset($_GET['gerar'])) {
		$teste = $fachadaSist2->inicializarBaseFuncoes();
		echo ('<script>
					window.alert("Base de dados gerada com sucesso!!!");
					window.location.href="menuboletim.php";
		       </script>');
	}
?>
<html>
<head>

	<? $apresentacao->chamaEstilo(); ?>
	<script src="scripts/band.js"></script>

	<script>

	function gerar() {
		var resposta = window.confirm("Deseja gerar base de dados das funções?");
		if (resposta) {
			resposta = window.confirm("Já realizou o backup?");
			if (resposta) {
				window.location.href = "iniciabasefuncoes.php?gerar=true";
			}
		}
		if (!resposta) {
//			history.back();
			window.location.href = "menuboletim.php";
		}
	}
	function cancelar() {
		window.alert('Operação cancelada.');
		window.location.href = "menuboletim.php";
	}


	</script>

</head>
<body>
<center>
	<? 	$apresentacao->chamaCabec();
		$apresentacao->montaMenu();
	?>
	<h3 class="titulo">&nbsp;&nbsp;<img src="./imagens/item_dir.gif">&nbsp;Inicializar Fun&ccedil;&otilde;es</h3>
		<TABLE width="500" bgcolor="yellow" CELLPADDING="1" border="1" cellpadding="0" cellspacing="0"><TR><TD>
		<TABLE width="100%" border="0" BORDERCOLOR="#C0C0C0" BORDERCOLORLIGHT="#C0C0C0" CELLSPACING="0" CELLPADDING="0" name="tabela">
		<TR><TD><font size="3"><B>Aten&ccedil;&atilde;o</B></font></TD></TR>
		<TR><TD  BGCOLOR="white">
		<FONT SIZE="3">
		<br><b>&nbsp;&nbsp;Esta op&ccedil;&atilde;o deve ser utilizada ap&oacute;s a atualiza&ccedil;&atilde;o da
		vers&atilde;o do sistema. Antes de executar, saiba que:</b>
		<ul>
			<li> Esta op&ccedil;&atilde;o vai atualizar a lista de fun&ccedil;&otilde;es do sistema, utilizada na defini&ccedil;&atilde;o dos perfis dos usu&aacute;rios.
			<li> &Eacute; uma opera&ccedil;&atilde;o irrevers&iacute;vel;
			<li> Realize um backup antes de executar, caso ainda n&atilde;o tenha feito;
			<li> Caso tenha d&uacute;vidas consulte o manual antes de executar.

		</ul>
		</FONT>
		</TD></TR>
		<TR><TD  align="center" BGCOLOR="white">
		<input type="button" value="  Cancelar  " onclick="cancelar()">
		<input type="button" value="Inicializar Funções" onclick="gerar()"></TD></TR>
		</TABLE></TD></TR></TABLE>
</body>
</html>
