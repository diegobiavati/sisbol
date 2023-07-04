<?
session_start();
require ('filelist_geral.php');
$apresentacao = new Apresentacao($funcoesPermitidas);

?>
<html>
<head>
<script src="scripts/band.js"></script>
<script>
		//var senha = window.prompt('Informe a senha do usuário supervisor.');
	var janelaPDF;
	function criaBanco() {
		//document.getElementById('divBanco').innerHTML = fazendo(1);
		viewConfig("ajax_config.php?opcao=gerarBanco");
	}
</script>
<?
	$apresentacao->chamaCabec();
	$apresentacao->chamaEstilo();
?>

</head>
<body><center>
		<br><br>
		<TABLE  bgcolor="yellow" CELLPADDING="1" border="0" cellpadding="0" cellspacing="0"><TR><TD>
		<TABLE width="100%" border="1" BORDERCOLOR="#C0C0C0" BORDERCOLORLIGHT="#C0C0C0" CELLSPACING="0" CELLPADDING="0" name="tabela">
		<TR>
			<TD  rowspan="3" BGCOLOR="white" width="20%"><img src="./imagens/hc_help.png"></td>
			<td BGCOLOR="white" align="center" valign="center"><font size="3"><B>Configura&ccedil;&atilde;o Inicial</B></font>
			<br><br><font size="3"><b>&nbsp;&nbsp;Esta op&ccedil;&atilde;o deve ser utilizada quando da 1ª Instala&ccedil;&atilde;o do SisBol.</b></font>
			<br><br><br><br><br><br>
			<input type="button" value="Gerar Banco" onclick="criaBanco()">
			</TD></TR>
		<TR>
			<TD  align="center" BGCOLOR="white">
		</TR></TABLE>
		</TD>
		</TR></TABLE>
</center></body>
</html>
