<? 	session_start(); 
	require_once('./filelist_geral.php');
	require_once('./filelist_qm.php');
	$fachadaSist2 = new FachadaSist2();
	$funcoesPermitidas = $fachadaSist2->lerColecaoAutorizada($_SESSION['NOMEUSUARIO'], 'X');	
	$apresentacao = new Apresentacao($funcoesPermitidas);	
        $ordem = (isset($_GET['ordem']))?($_GET['ordem']):"cod";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
    "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>SisBol</title>
	<? $apresentacao->chamaEstilo(); ?>
	<script type="text/javascript" src="scripts/band.js"></script>
	<script type="text/javascript">
	function novo(){
		document.getElementById("formulario").style.visibility = "visible";
		document.getElementById("novo").style.visibility = "hidden";
		document.getElementById("tituloForm").innerHTML = "Incluir";
		document.cadQM.cod.readOnly = false;
		document.cadQM.cod.focus();
	}
	function cancelar(){
   		document.cadQM.cod.value  = "";
		document.cadQM.nome.value = "";
		document.cadQM.abreviacao.value = "";
   		document.cadQM.acao.value = "Incluir";
   		document.getElementById("formulario").style.visibility = "hidden";
   		document.getElementById("novo").style.visibility = "visible";
   		cinza();
	}
	function executa(acao){
		document.cadQM.executar.value = acao;                
                // PARREIRA 21/05/2013 - Alterado para alertar falta de codigo
		if (document.cadQM.cod.value == ""){
			window.alert("Informe o c�digo da Qualifica��o Militar!");
			return;
		}
                // PARREIRA 21/05/2013 - Alterado permitir cadastro sem abreviacao
                if (document.cadQM.abreviacao.value == ""){
			document.cadQM.abreviacao.value = " ";
		}// FIM PARREIRA 21/05/2013                
                if (document.cadQM.nome.value == ""){
			window.alert("Informe o nome da Qualifica��o Militar!");
			return;
		}  
                
		if (acao == "Excluir")  {
			if (!window.confirm("Deseja realmente excluir a Qualifica��o Militar ?")){
				return ;
			}
		} 
		document.cadQM.action = "cadqm.php";
		document.cadQM.submit();
	}
	function carregaedit(cod,nome, abreviacao,acao,IDT) {
		document.cadQM.cod.readOnly = true;
		document.getElementById(IDT).style.background = "#DDEDFF";
		document.cadQM.nome.value = nome;
		document.cadQM.cod.value  = cod;
		document.cadQM.abreviacao.value  = abreviacao;
   		document.cadQM.acao.value = acao;
   		document.getElementById("formulario").style.visibility = "visible";
   		document.getElementById("novo").style.visibility = "hidden";
   		document.getElementById("tituloForm").innerHTML = acao;
   		window.location.href = "#form";
	}  
        function ordena(ordem){
		window.location.href="cadqm.php?ordem="+ordem;
        }
	</script>
</head>
<body><center>
	<? 	
	$item = 0;
	$intervalo = 0;
	if(isset($_GET['item'])){
		$item = $_GET['item'];
	}
	$intervalo = $item + 20; 

	$apresentacao->chamaCabec();
	$apresentacao->montaMenu();
	?>
	<h3 class="titulo">&nbsp;&nbsp;<img src="./imagens/item_dir.gif" alt="">&nbsp;
	Cadastro de Qualifica��o Militar <img src="imagens/ajuda.png" width="14" height="14" onClick="ajuda('cadQM')" onMouseOver="this.style.cursor='help';" onMouseOut="this.style.cursor='default';" ></h3>
	<?
	if (isset($_POST['executar'])){
  		$pQM = new QM();
  		$pQM->setCod($_POST['cod']);
  		$pQM->setDescricao($_POST['nome']);
		$pQM->setAbreviacao($_POST['abreviacao']);
            	
  		if ($_POST['executar'] == 'Incluir'){
			$fachadaSist2->incluirQM($pQM);	
		}	
		if ($_POST['executar'] == 'Excluir'){
			$fachadaSist2->excluirQM($pQM);
		}
		if ($_POST['executar'] == 'Alterar'){
			$fachadaSist2->alterarQM($pQM);
		}
  	}
  	$colQM2 = $fachadaSist2->lerColecaoQM($ordem);
  	$pQM = $colQM2->iniciaBusca1();
	$total = $colQM2->getQTD();
	// Implementa a pagina��o caso a listagem tenha mais que 50 �tens
	$location = "cadqm.php?none=1";
      //verifica permissao
    if ($_SESSION['NOMEUSUARIO'] != 'supervisor'){
		$mIncluir = $funcoesPermitidas->lerRegistro(1021);
	}
    if (($mIncluir != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor')){
		echo '<table width="55%" border="0" >';
        echo '<TR>';
	    echo '<TD><a href="javascript:novo()" id="novo">';
        echo '<img src="./imagens/add.png" border=0 alt="">&nbsp;<FONT COLOR="#0080C0">';
	    echo 'Adicionar</FONT></a>';
	    echo '</TD>';
		
//	    echo '</TR>';
//	    echo '</TABLE>';
	}
	if ($total > 50){
		echo '<td align="right">';
		$apresentacao->montaComboPag($total,$item,$selected,$location);
		echo '</td></tr></table><p>';
	}
	?>
	<table width="55%" border="0" cellspacing="0"  class="lista"><tr><td>
	<table width="100%" border="0" cellspacing="1" cellpadding="0">
	<tr class="cabec">
		<td width="3%"><div align="center"><strong><font size="2">Ord</font></strong></div></td>
		<td width="6%"><div align="center"><strong><font size="2">C�d</font></strong><a href="javascript:ordena('cod')"></a></div></td>
		<td width="47%" align="center"><strong><font size="2">Descri��o</font></strong><a href="javascript:ordena('descricao')"></a></td>
		<td width="7%" align="center"><strong><font size="2">Abrevia��o</font></strong><a href="javascript:ordena('abreviacao')"></a></td>
        <td width="5%" align="center"><strong><font size="2">A��o</font></strong></td>
		</tr>
	<?
	$items_lidos = 0;
	$ord = 0;
	while ($pQM != null){
		$ord++;
		if ($ord > $item){ 
			echo '<tr id='.$ord.' onMouseOut="outLinha('.$ord.')" 
					onMouseOver="overLinha('.$ord.')" bgcolor="#F5F5F5">
					<td align="center">'.$ord.'</td>
					<td align="center">'.$pQM->getCod().'</td><td>'. $pQM->getDescricao().'</td><td>'. $pQM->getAbreviacao().'</td>
					<td align="center">
					<a href="javascript:carregaedit(\''.$pQM->getCod().'\',
					\''.$pQM->getDescricao().'\',
					\''.$pQM->getAbreviacao().'\',\'Alterar\','.$ord.')">';
              //verifica permissao
            if ($_SESSION['NOMEUSUARIO'] != 'supervisor'){
				$mAlterar = $funcoesPermitidas->lerRegistro(1022);
            }
            if (($mAlterar != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor')){ 
				echo '<img src="./imagens/alterar.png" title="Alterar" border=0 alt=""></a>&nbsp;|&nbsp'; 
			}
	    	echo '<a href="javascript:carregaedit(\''.$pQM->getCod().'\',
	    			\''.$pQM->getDescricao().'\',
					\''.$pQM->getAbreviacao().'\',\'Excluir\','.$ord.')">';
            //verifica permissao
            if ($_SESSION['NOMEUSUARIO'] != 'supervisor'){ 
				$mExcluir = $funcoesPermitidas->lerRegistro(1023);
            }
            if (($mExcluir != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor')){ 
				echo '<img src="./imagens/excluir.png" border=0 title="Excluir" alt="">';
			}
			echo '</a></td></tr>';
		}	
    	$pQM = $colQM2->getProximo1();
    	$items_lidos++;
    	if($items_lidos >= $intervalo){
    		break;
    	}
  	}
	?>
  	</table></td></tr></table>
	<b>Legenda:</b> <img src="imagens/alterar.png" width="16" height="16"> Alterar &nbsp;&nbsp;<img src="imagens/excluir.png" width="16" height="16"> Excluir <br>
<script type="text/javascript">javascript:tot_linhas(<?=$ord?>)</script>
	<a name="form"></a>
	<form  method="post" name="cadQM" action="">
		<input name="executar" type="hidden" value="">
		<div id="formulario" STYLE="VISIBILITY:hidden">
                <br>
		<TABLE class="formulario" width="55%" CELLPADDING="0"><TR><TD>
		<TABLE width="100%" border="0" CELLSPACING="0" CELLPADDING="0" style="name:tabela;">
		<TR CLASS="cabec"><TD><div id="tituloForm"><font size="2"></font></div></TD></TR>
		<tr>
		<TD BGCOLOR="#C0C0C0">
		&nbsp;C�d:<br>
		&nbsp;<input name="cod" size="5" maxlength="4"><br>
		&nbsp;Descri�ao:<br>
		&nbsp;<input name="nome" type="text" size="110" maxlength="120"><br>&nbsp;<br>
		&nbsp;Abreviacao:<br>
                <!-- PARREIRA 21/05/2013 - inserido value com espaco no abreviacao -->
                &nbsp;<input name="abreviacao" type="text" size="110" maxlength="120" value="&nbsp;"><br>&nbsp;</TD>
		</TR><TR>
		<TD BGCOLOR="#C0C0C0" align="center">
			<input name="acao" type="button" value="Incluir" onClick="executa(this.value)">
			<input name="cancela" type="button" value="Cancelar" onClick="cancelar()"><TD>
		</TR></table>
		</TD></TR></TABLE>
		</div>
	</form>
</center>
</body>
</html>
