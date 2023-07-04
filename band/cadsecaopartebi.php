<? 	session_start(); 
	require_once('./filelist_geral.php');
	require_once('./filelist_boletim.php');
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
	function novo(){
		document.getElementById("formulario").style.visibility = "visible";
		document.getElementById("novo").style.visibility = "hidden";
		document.getElementById("tituloForm").innerHTML = "Incluir";
		document.cadSecaoParteBi.numero_secao.focus();
	}
	function cancelar(){
   		document.cadSecaoParteBi.numero_secao.value  = "";
		document.cadSecaoParteBi.descricao.value = "";
   		document.cadSecaoParteBi.acao.value = "Incluir";
   		document.getElementById("formulario").style.visibility = "hidden";
   		document.getElementById("novo").style.visibility = "visible";
		document.cadSecaoParteBi.numero_secao.readOnly = false;			
   		cinza();
	}
	function executa(acao){
		document.cadSecaoParteBi.executar.value = acao;
		if (document.cadSecaoParteBi.descricao.value == ""){
			window.alert("Informe a descrição da Seção de Parte do Boletim!");
			return;
		}    
		if (acao == "Excluir")  {
			if (!window.confirm("Deseja realmente excluir a Seção de Parte do Boletim selecionada ?")){
				return ;
			}
		} 
		document.cadSecaoParteBi.action = "cadsecaopartebi.php?numeroParte="+document.cadSecaoParteBi.seleParteBi.value;
		document.cadSecaoParteBi.submit();
	}
	function carregaedit(numero_secao,descricao,acao,IDT) {
		cinza();
		if (acao == 'Incluir'){
			document.cadSecaoParteBi.numero_secao.readOnly = false;			
		}else {
			document.cadSecaoParteBi.numero_secao.readOnly = true;		
		}
		document.getElementById(IDT).style.background = "#DDEDFF";
		document.cadSecaoParteBi.numero_secao.value  = numero_secao;
		document.cadSecaoParteBi.descricao.value = descricao;
   		document.cadSecaoParteBi.acao.value = acao;
   		document.getElementById("formulario").style.visibility = "visible";
   		document.getElementById("novo").style.visibility = "hidden";
   		document.getElementById("tituloForm").innerHTML = acao;
	}  
	function secaoParteBi(){
		window.location.href = "cadsecaopartebi.php?numeroParte="+document.cadSecaoParteBi.seleParteBi.value;

//		window.alert('passou!!!');
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
//	 	$apresentacao->montaCombo('seleParteBi',$colParteBi,'getNumeroParte','getDescricao',8);	
	?>
	
	
	<h3 class="titulo">&nbsp;&nbsp;<img src="./imagens/item_dir.gif" alt="">&nbsp;Cadastro das Seções de Partes do Boletim </h3>
	<form  method="post" name="cadSecaoParteBi" action="">
	<p>Parte BI:&nbsp;

            
	<? 	$apresentacao->montaCombo('seleParteBi',$colParteBi,'getNumeroParte','getDescrReduz',$numeroParteAtual,'secaoParteBi()');
		$parteBi = $fachadaSist2->lerParteBoletim($numeroParteAtual);
		echo '<br><br><b><font size="2">'.$parteBi->getDescricao().'</font></b>';	
	?>
            
               
             <?php
            //verifica permissao
            if ($_SESSION['NOMEUSUARIO'] != 'supervisor') {
                $mIncluir = $funcoesPermitidas->lerRegistro(1091);
            }
            if (($mIncluir != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor')) {
                echo '<table width="60%" border="0" >';
                echo '<TR><TD><a href="javascript:novo()" id="novo">';
                echo '<img src="./imagens/add.png" border=0 alt="">&nbsp;<FONT COLOR="#0080C0">Adicionar</FONT></a></TD>';
                echo '</TR></TABLE>';
				echo '<p>';
            }
            ?>

	<table width="60%" border="0" cellspacing="0" class="lista"><tr><td>
	<table width="100%" border="0" cellspacing="1" cellpadding="0">
	<tr class="cabec">
		<td width="4%"><div align="center"><strong><font size="2">Ord</font></strong></div></td>
		<td width="76%" align="center"><strong><font size="2">Descrição da Seção de Parte do Boletim</font></strong></td>
		<td width="20%" align="center"><strong><font size="2">Ação</font></strong></td>
	</tr>
	<?php
		if (isset($_POST['executar'])){
  			$secaoParteBi = new SecaoParteBi();
  			$secaoParteBi->setNumeroSecao($_POST['numero_secao']);
  			$secaoParteBi->setDescricao($_POST['descricao']);
  			$parteBi = $colParteBi->lerRegistro($_POST['seleParteBi']);

  			if ($_POST['executar'] == 'Incluir'){
				$fachadaSist2->incluirSecaoParteBi($parteBi,$secaoParteBi);	
			}	
			if ($_POST['executar'] == 'Excluir'){
				$fachadaSist2->excluirSecaoParteBi($parteBi,$secaoParteBi);
			}
			if ($_POST['executar'] == 'Alterar'){
				$fachadaSist2->alterarSecaoParteBi($parteBi,$secaoParteBi);
			}
  		}
  		$colSecaoParteBi2 = $fachadaSist2->lerColecaoSecaoParteBi($numeroParteAtual);
  		$secaoParteBi = $colSecaoParteBi2->iniciaBusca1();
		$ord = 0;
  		while ($secaoParteBi != null){
			$ord++;
			echo '<tr id='.$ord.' onMouseOut="outLinha('.$ord.')" onMouseOver="overLinha('.$ord.')" bgcolor="#F5F5F5">
				<td align="center">'.$secaoParteBi->getNumeroSecao().'</td><td>'. $secaoParteBi->getDescricao().'</td>
				<td align="center">
				<a href="javascript:carregaedit('.$secaoParteBi->getNumeroSecao().',\''.$secaoParteBi->getDescricao().'\',\'Alterar\','.$ord.')">';
                //verifica permissao
                if ($_SESSION['NOMEUSUARIO'] != 'supervisor')
                { $mAlterar = $funcoesPermitidas->lerRegistro(1092);
                }
                if (($mAlterar != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor'))
			    { echo '<img src="./imagens/alterar.png"  border=0 title="Alterar" alt="">';
			      echo '<FONT COLOR="#000000"></FONT></a>&nbsp;|&nbsp'; 
			    }
			echo '<a href="javascript:carregaedit('.$secaoParteBi->getNumeroSecao().',\''.$secaoParteBi->getDescricao().'\',\'Excluir\','.$ord.')">';
            //verifica permissao
            if ($_SESSION['NOMEUSUARIO'] != 'supervisor')
            { $mExcluir = $funcoesPermitidas->lerRegistro(1093);
            }
            if (($mExcluir != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor'))
            { echo '<img src="./imagens/excluir.png" border=0 title="Excluir" alt=""><FONT COLOR="#000000"></FONT>';
            }
			echo '</a></td></tr>';
    		$secaoParteBi = $colSecaoParteBi2->getProximo1();
  		}
		?>
  		</table></td></tr>
	</table>
   
	<script type="text/javascript">javascript:tot_linhas(<?=$ord?>)</script>

		<b>Legenda:</b> <img src="imagens/alterar.png" width="16" height="16"> Alterar &nbsp;&nbsp;<img src="imagens/excluir.png" width="16" height="16"> Excluir
<input name="executar" type="hidden" value="">
		<div id="formulario" STYLE="VISIBILITY:hidden">
		<TABLE class="formulario" bgcolor="#0000FF" CELLPADDING="1" ><TR><TD>
			<TABLE border="0"  CELLSPACING="0" CELLPADDING="0" style="name:tabela;">
			<TR CLASS="cabec"><TD><div id="tituloForm"><font size="2"></font></div></TD></TR>
		<TR>
			<TD BGCOLOR="#C0C0C0">
			<br>Número: <input name="numero_secao" type="text" size="3" maxlength="3" onKeyPress="return so_numeros(event)">&nbsp;&nbsp;<br>
			</TD>
		</TR>
		<TR>
			<TD BGCOLOR="#C0C0C0">
			<br>Descrição: <input name="descricao" type="text" size="50" maxlength="50">&nbsp;&nbsp;<br><br>
			</TD>
		</TR>
		<TR>
			<TD BGCOLOR="#C0C0C0" align="right">
			<input name="acao" type="button" value="Incluir" onClick="executa(this.value)">
			<input name="cancela" type="button" value="Cancelar" onClick="cancelar()"><TD>
		</TR></table>
		</TD></TR></TABLE>
		</div>
	</form>
</center>
</body>
</html>
