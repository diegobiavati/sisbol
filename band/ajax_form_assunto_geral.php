<?
	$divObj = $_GET['divObj'];
	$acao 	= $_GET['acao'];
	$cod 	= $_GET['cod'];
	$descricao 	= $_GET['descricao'];
	$item = explode('_',$divObj);
	$item = $item[1];
	//echo $_GET['descricao'];
?>


		<br>
		<input name="executar" type="hidden" value="">
		<input name="cod" type="hidden" value="<?=$cod?>">
		<TABLE width="630" bgcolor="#006633" CELLPADDING="1" ><TR><TD>
			<TABLE width="100%" border=0 BORDERCOLOR="#C0C0C0" BORDERCOLORLIGHT="#C0C0C0" CELLSPACING="0" CELLPADDING="0" name="tabela">
			<TR CLASS="cabec"><TD><font size="2"><div id="tituloForm"><?=$acao;?></div></font></TD></TR>
		<TR>
			<TD BGCOLOR="#C0C0C0">
			<br>Descri&ccedil;&atilde;o: <input name="descricao" value="<?=$descricao;?>" type="text" size="100" maxlength="100" onenter="executa('<?=$acao;?>','<?=$item?>')">&nbsp;&nbsp;<br><br>
			</TD>
		</TR>
		<TR>
			<TD BGCOLOR="#C0C0C0" align="right">
			<input name="acao" type="button" value="<?=$acao;?>" onclick="executa(this.value,'<?=$item?>')">
			<input name="cancela" type="button" value="Cancelar" onclick="cancelar('<?=$divObj?>')"><TD>
		</TR></table>
		</TD></TR></TABLE>
<?
	//}

?>

