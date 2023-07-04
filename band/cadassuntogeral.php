<? 	session_start();
	require_once('./filelist_geral.php');
	require_once('./filelist_boletim.php');
	require_once('./filelist_assunto.php');
	require_once('./filelist_usuariofuncaotipobol.php');
	$fachadaSist2 = new FachadaSist2();
    $funcoesPermitidas = $fachadaSist2->lerColecaoAutorizada($_SESSION['NOMEUSUARIO'], 'X');
	$apresentacao = new Apresentacao($funcoesPermitidas);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
    "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SisBol</title>
	<? $apresentacao->chamaEstilo(); ?>
	<script type="text/javascript" src="scripts/band.js"></script>
	<script type="text/javascript">
	var div_atual = "";
	function novo(){

		document.getElementById("formulario").style.visibility = "visible";
		document.getElementById("novo").style.visibility = "hidden";
		document.getElementById("tituloForm").innerHTML = "Incluir";
		document.cadAssuntoGeral.descricao.focus();
	}
	function cancelar(divObj){
   		/*
   		document.cadAssuntoGeral.cod.value  = "";
		document.cadAssuntoGeral.descricao.value = "";
   		document.cadAssuntoGeral.acao.value = "Incluir";
   		document.getElementById("formulario").style.visibility = "hidden";
   		document.getElementById("novo").style.visibility = "visible";
   		cinza();
   		*/
   		//lerAssuntoGeral();
   		document.getElementById(divObj).innerHTML = '';
	}
	function excluir(cod){
		if (!window.confirm("Deseja realmente excluir o Assunto selecionado?")){
				return ;
		}
		dados = 'executar=Excluir&codAssuntoGeral='+cod+'&numeroParteAtual='+
				document.cadAssuntoGeral.seleParteBi.value+'&numeroSecaoParteBiAtual='+
				document.cadAssuntoGeral.seleSecaoParteBi.value+'&codTipoBolAtual='+
				document.cadAssuntoGeral.seleTipoBol.value;
		var html = $.ajax({
							type: "POST",
							url: "ajax_assunto_geral.php",
							data: dados,
							async: false
							}).responseText;
		document.getElementById("divGeral").innerHTML  = html;
	}
	function executa(acao,item){
		//alert(acao);
		document.formAltera.executar.value = acao;
		if (document.formAltera.descricao.value == ""){
			window.alert("Informe o Assunto Geral!");
			return;
		}
		dados = 'executar='+acao+'&numeroParteAtual='+
			document.cadAssuntoGeral.seleParteBi.value+
			'&numeroSecaoParteBiAtual='+document.cadAssuntoGeral.seleSecaoParteBi.value+
			'&codTipoBolAtual='+document.cadAssuntoGeral.seleTipoBol.value+
			'&descricao='+document.formAltera.descricao.value+
			'&ordAssuntoGeral='+item+
			'&codAssuntoGeral='+document.formAltera.cod.value;
		var html = $.ajax({
						contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
						type: "POST",
						url: "ajax_assunto_geral.php",
						data: dados,
						async: false
						}).responseText;

		document.getElementById("divGeral").innerHTML  = html;
	}

	function alterar(cod,descricao,acao,IDT,divObj) {
		if(div_atual !== ""){
			document.getElementById(div_atual).innerHTML = "";
		}
		div_atual = divObj;
		item = (divObj.split('_'))[1];
		document.getElementById(div_atual).innerHTML = chamaForm(cod,acao,descricao,item,div_atual);
	}
	function adicionar(divObj){
		if(div_atual !== ""){
			document.getElementById(div_atual).innerHTML = "";
			document.getElementById(div_atual).focus();
		}
		div_atual = divObj;
		item = (divObj.split('_'))[1];
		document.getElementById(div_atual).innerHTML = chamaForm("","Incluir","",item,div_atual);
	}
	
	// PARREIRA - 13-06-2013 - modificado aparencia do form alterar
	function chamaForm(cod,acao,descricao,item, divObj ){
		return '<br><input name="executar" type="hidden" value="">'+
		'<input name="cod" type="hidden" value="'+cod+'">'+
		'<TABLE class="formulario" width="500" bgcolor="#0000FF"><TR><TD>'+
		'<TABLE  width="100%" border=0 CELLSPACING="0">'+
		'<TR CLASS="cabec"><TD>'+
		'<div id="tituloForm"><font size="2">'+acao+'<\/font><\/div><\/TD><\/TR>'+
		'<TD BGCOLOR="#C0C0C0"><br>Descri&ccedil;&atilde;o: '+
		'<input name="descricao" value="'+descricao+'" type="text" size="80" maxlength="100" '+
		'onenter="executa(\"'+acao+'\",'+item+')">&nbsp;&nbsp;<br><br><\/TD><\/TR>'+
		'<TR><TD BGCOLOR="#C0C0C0" align="right">'+
		'<input name="acao" type="button" value="'+acao+'" onclick="executa(this.value,'+item+')">'+
		'<input name="cancela" type="button" value="Cancelar" onclick="cancelar(\''+divObj+'\')"><\/TD><\/TR><\/table>'+
		'<\/TD><\/TR><\/TABLE>';
	}
	/*function chamaForm(cod,acao,descricao,item, divObj ){
		return '<br><input name="executar" type="hidden" value="">'+
		'<input name="cod" type="hidden" value="'+cod+'">'+
		'<TABLE class="formulario" width="600" bgcolor="#0000FF"><TR><TD>'+
		'<TABLE  width="100%" border=0 CELLSPACING="0">'+
		'<TR CLASS="cabec"><TD>'+
		'<div id="tituloForm"><font size="2">'+acao+'<\/font><\/div><\/TD><\/TR>'+
		'<TD BGCOLOR="#C0C0C0"><br>Descri&ccedil;&atilde;o: '+
		'<input name="descricao" value="'+descricao+'" type="text" size="100" maxlength="100" '+
		'onenter="executa(\"'+acao+'\",'+item+')">&nbsp;&nbsp;<br><br><\/TD><\/TR>'+
		'<TR><TD BGCOLOR="#C0C0C0" align="right">'+
		'<input name="acao" type="button" value="'+acao+'" onclick="executa(this.value,'+item+')">'+
		'<input name="cancela" type="button" value="Cancelar" onclick="cancelar(\''+divObj+'\')"><\/TD><\/TR><\/table>'+
		'<\/TD><\/TR><\/TABLE>';
	}*/
	function secaoParteBi(){
		window.location.href = "cadassuntogeral.php?codTipoBol="+document.cadAssuntoGeral.seleTipoBol.value+"&numeroParte="+document.cadAssuntoGeral.seleParteBi.value;
	}
	function assuntoGeral(){
		window.location.href = "cadassuntogeral.php?codTipoBol="+document.cadAssuntoGeral.seleTipoBol.value+"&numeroParte="+document.cadAssuntoGeral.seleParteBi.value+"&numeroSecao="+document.cadAssuntoGeral.seleSecaoParteBi.value;
	}
	function move(codAss1,ord1,codAss2,ord2){
		dados = 'numeroParteAtual='+document.cadAssuntoGeral.seleParteBi.value+
				'&numeroSecaoParteBiAtual='+document.cadAssuntoGeral.seleSecaoParteBi.value+
				'&codTipoBolAtual='+document.cadAssuntoGeral.seleTipoBol.value+
				'&acao='+codAss1+','+ord1+','+codAss2+','+ord2;

		var html = $.ajax({
							type: "POST",
							url: "ajax_assunto_geral.php",
							data: dados,
							async: false
							}).responseText;
		document.getElementById("divGeral").innerHTML  = html;
	}
	function lerAssuntoGeral(){
		dados = 'numeroParteAtual='+document.cadAssuntoGeral.seleParteBi.value+
				'&numeroSecaoParteBiAtual='+document.cadAssuntoGeral.seleSecaoParteBi.value+
				'&codTipoBolAtual='+document.cadAssuntoGeral.seleTipoBol.value;

		var html = $.ajax({
							type: "POST",
							url: "ajax_assunto_geral.php",
							data: dados,
							async: false
							}).responseText;
		document.getElementById("divGeral").innerHTML  = html;
	}

	function html_entity_decode(str) {
  		var tarea=content.document.createElement('textarea'); // the "content" part is needed in buttons
  		tarea.innerHTML = str; return tarea.value;
  		tarea.parentNode.removeChild(tarea);
	}
	function tipoBol(codBol){
		window.location.href = "cadassuntogeral.php?codTipoBol="+document.cadAssuntoGeral.seleTipoBol.value;
	}
	</script>
</head>
<body><center>
	<? 	$apresentacao->chamaCabec();
		$apresentacao->montaMenu();
	?>
	<? 	$colParteBi = $fachadaSist2->lerColecaoParteBoletim('numero_parte');
		if (isset($_GET['numeroParte'])){
			$numeroParteAtual = $_GET['numeroParte'];
		}else {
			$obj = $colParteBi->iniciaBusca1();

			if (!is_null($obj)){
				$numeroParteAtual = $obj->getNumeroParte();
			} else {
				$numeroParteAtual = 0;
			}
		}
		$colSecaoParteBi = $fachadaSist2->lerColecaoSecaoParteBi($numeroParteAtual);
		if (isset($_GET['numeroSecao'])){
			$numeroSecaoParteBiAtual = $_GET['numeroSecao'];
		}else {
			$obj = $colSecaoParteBi->iniciaBusca1();

			if (!is_null($obj)){
				$numeroSecaoParteBiAtual = $obj->getNumeroSecao();
			} else {
				$numeroSecaoParteBiAtual = 0;
			}
		}
	?>


	<h3 class="titulo">&nbsp;&nbsp;<img src="./imagens/item_dir.gif" alt="">&nbsp;Cadastro de Assunto Geral </h3>
	<form  method="post" name="cadAssuntoGeral" action="">
	<table width="65%" border="0" cellspacing="4" bgcolor="#F5F5F5" style="border-top:1pt solid #006633;border-bottom:1pt solid #006633;border-left:1pt solid #006633;border-right:1pt solid #006633;">
	<tr>
	 <td>Tipo de Boletim:&nbsp;
		<? 	//$apresentacao->montaCombo('seleSecaoParteBi',$colSecaoParteBi,'getNumeroSecao','getDescricao',$numeroSecaoParteBiAtual,'assuntoGeral()');
		if ($_SESSION['NOMEUSUARIO'] == 'supervisor'){
			$colTipoBol = $fachadaSist2->lerColecaoTipoBol('descricao');
		}else{
			$colTipoBol = $fachadaSist2->lerColecaoAutorizadaTipoBol($_SESSION['NOMEUSUARIO'], 1104);
		}
		if (isset($_GET['codTipoBol'])){
			$codTipoBolAtual = $_GET['codTipoBol'];
		}else {
			$obj = $colTipoBol->iniciaBusca1();

			if (!is_null($obj)){
				$codTipoBolAtual = $obj->getCodigo();
			} else {
				$codTipoBolAtual = 0;
			}
		}
	 	$apresentacao->montaCombo('seleTipoBol',$colTipoBol,'getCodigo','getDescricao',$codTipoBolAtual,'tipoBol()');
		?>
	 </td>
	 <td>Parte BI:&nbsp;
		<? 	$apresentacao->montaCombo('seleParteBi',$colParteBi,'getNumeroParte','getDescrReduz',$numeroParteAtual,'secaoParteBi()');?>
	 </td>
	 <td>Seção da Parte do BI:&nbsp;
		<? 	$apresentacao->montaCombo('seleSecaoParteBi',$colSecaoParteBi,'getNumeroSecao','getDescricao',$numeroSecaoParteBiAtual,'assuntoGeral()');?>
	 </td>
	</tr>
	</table>
	</form>
	<br>
		<form name="formAltera" action="">

		<div id="divGeral"></div>
		<div id="divAdicionar_0"></div>
		</form>
    <b>Legenda:</b> <img src="imagens/alterar.png" width="16" height="16"> Alterar &nbsp;&nbsp;<img src="imagens/excluir.png" width="16" height="16"> Excluir  &nbsp;&nbsp;<img src="imagens/add.png" width="16" height="16">Adicionar
<?php
    //verifica permissao/*
    /*
    if ($_SESSION['NOMEUSUARIO'] != 'supervisor')
    { $mIncluir = $funcoesPermitidas->lerRegistro(1101);
    }
    if (($mIncluir != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor'))
    { echo '<table width="800" border="0" >';
	  echo '<TR><TD><a href="javascript:adicionar(\'divAdicionar_0\')" id="novo">';
	  echo '<img src="./imagens/seta_dir.gif" border=0>&nbsp;<FONT COLOR="#0080C0">Adicionar</FONT></a></TD>';
	  echo '</TR></TABLE>';
	}*/
	?>
	<script type="text/javascript">javascript:tot_linhas(<?=$ord?>)</script>

</center>
<A NAME="fim_pagina"></A>
<script type="text/javascript">lerAssuntoGeral()</script>
</body>
</html>
