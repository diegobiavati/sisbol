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
		document.cadParteBoletim.cod.focus();
	}
	function cancelar(){
   		document.cadParteBoletim.cod.value  = "";
		document.cadParteBoletim.descricao.value = "";
		document.cadParteBoletim.descr_reduz.value = "";
   		document.cadParteBoletim.acao.value = "Incluir";
   		document.getElementById("formulario").style.visibility = "hidden";
   		document.getElementById("novo").style.visibility = "visible";
   		cinza();
	}
	function executa(acao){
		document.cadParteBoletim.executar.value = acao;
		if (document.cadParteBoletim.descricao.value == ""){
			window.alert("Informe o descrição da Parte do Boletim!");
			return;
		}    
		if (document.cadParteBoletim.descr_reduz.value == ""){
			window.alert("Informe o descrição reduzida da Parte do Boletim!");
			return;
		}    
		if (acao == "Excluir")  {
			if (!window.confirm("Deseja realmente excluir a Parte do Boletim selecionada ?")){
				return ;
			}
		} 
		document.cadParteBoletim.action = "cadparteboletim.php";
		document.cadParteBoletim.submit();
	}
	function carregaedit(cod,descricao,descr_reduz,acao,IDT) {
		cinza();
		document.cadParteBoletim.cod.readOnly = true;
		document.getElementById(IDT).style.background = "#DDEDFF";
		document.cadParteBoletim.cod.value  = cod;
		document.cadParteBoletim.descricao.value = descricao;
		document.cadParteBoletim.descr_reduz.value = descr_reduz;
   		document.cadParteBoletim.acao.value = acao;
   		document.getElementById("formulario").style.visibility = "visible";
   		document.getElementById("novo").style.visibility = "hidden";
   		document.getElementById("tituloForm").innerHTML = acao;
	}  
	</script>
</head>
<body><center>
	<? 	$apresentacao->chamaCabec();
		$apresentacao->montaMenu();
	?>
	
	<h3 class="titulo">&nbsp;&nbsp;<img src="./imagens/item_dir.gif" alt="">&nbsp;Cadastro das Partes do Boletim </h3>
	<?php
        //verifica permissao
        if ($_SESSION['NOMEUSUARIO'] != 'supervisor') {
            $mIncluir = $funcoesPermitidas->lerRegistro(1081);
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
		<td width="14%"><div align="center"><strong><font size="2">Nr Parte</font></strong></div></td>
		<td width="21%" align="center"><strong><font size="2">Descrição reduzida</font></strong></td>
		<td width="50%" align="center"><strong><font size="2">Descrição da Parte do Boletim</font></strong></td>
		<td width="10%" align="center"><strong><font size="2">Ação</font></strong></td>
	</tr>
	<?php
		if (isset($_POST['executar'])){
			$colSecaoParteBi2 = new ColSecaoParteBi2();
  			$parteBoletim = new ParteBoletim($colSecaoParteBi2);
  			$parteBoletim->setNumeroParte($_POST['cod']);
  			$parteBoletim->setDescricao($_POST['descricao']);
  			$parteBoletim->setDescrReduz($_POST['descr_reduz']);
  			if ($_POST['executar'] == 'Incluir'){
				$fachadaSist2->incluirParteBoletim($parteBoletim);	
			}	
			if ($_POST['executar'] == 'Excluir'){
				$fachadaSist2->excluirParteBoletim($parteBoletim);
			}
			if ($_POST['executar'] == 'Alterar'){
				$fachadaSist2->alterarParteBoletim($parteBoletim);
			}
  		}
  		$colParteBoletim2 = $fachadaSist2->lerColecaoParteBoletim('numero_parte');
  		$parteBoletim = $colParteBoletim2->iniciaBusca1();
		$ord = 0;
  		while ($parteBoletim != null){
			$ord++;
			echo '<tr id='.$ord.' onMouseOut="outLinha('.$ord.')" onMouseOver="overLinha('.$ord.')" bgcolor="#F5F5F5">
					<td align="center">'.$parteBoletim->getNumeroParte().'</td>
					<td align="center">'.$parteBoletim->getDescrReduz().'</td>
					<td align="left">'.$parteBoletim->getDescricao().'</td>
				<td align="center">
				<a href="javascript:carregaedit('.$parteBoletim->getNumeroParte().',\''.$parteBoletim->getDescricao().'\',\''.$parteBoletim->getDescrReduz().'\',\'Alterar\','.$ord.')">';
                //verifica permissao
                if ($_SESSION['NOMEUSUARIO'] != 'supervisor')
                { $mAlterar = $funcoesPermitidas->lerRegistro(1082);
                }
                if (($mAlterar != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor'))
			    { echo '<img src="./imagens/alterar.png"  border=0 title="Alterar" alt="">';
				  echo '<FONT COLOR="#000000"></FONT></a>&nbsp;|&nbsp'; 
				}
			echo '<a href="javascript:carregaedit('.$parteBoletim->getNumeroParte().',\''.$parteBoletim->getDescricao().'\',\''.$parteBoletim->getDescrReduz().'\'
				,\'Excluir\','.$ord.')">';

            //verifica permissao
            if ($_SESSION['NOMEUSUARIO'] != 'supervisor')
            { $mExcluir = $funcoesPermitidas->lerRegistro(1083);
            }
            if (($mExcluir != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor'))
			{ echo '<img src="./imagens/excluir.png" border=0 title="Excluir" alt="">';
			}
			echo '<FONT COLOR="#000000"></FONT></a></td></tr>';
    		$parteBoletim = $colParteBoletim2->getProximo1();
  		}
		?>
  		</table></td></tr>
	</table>

	<script type="text/javascript">javascript:tot_linhas(<?=$ord?>)</script>

	<form  method="post" name="cadParteBoletim" action="">
	  <b>Legenda:</b> <img src="imagens/alterar.png" width="16" height="16"> Alterar &nbsp;&nbsp;<img src="imagens/excluir.png" width="16" height="16"> Excluir
<input name="executar" type="hidden" value="">
	<br>
		<div id="formulario" STYLE="VISIBILITY:hidden">
		<TABLE class="formulario" bgcolor="#0000FF" CELLPADDING="1" ><TR><TD>
			<TABLE border="0"  CELLSPACING="0" CELLPADDING="0" style="name:tabela;">
			<TR CLASS="cabec"><TD><div id="tituloForm"><font size="2"></font></div></TD></TR>
			<tr>
		<TD BGCOLOR="#C0C0C0">
		<br>Número da Parte do BI: 	<input name="cod" type="text" size="2" maxlength="2">&nbsp;&nbsp;<br>
		<br>Descrição: <input name="descricao" type="text" size="50" maxlength="50">&nbsp;&nbsp;<br><br>
		Descrição reduzida: <input name="descr_reduz" type="text" size="10" maxlength="10">&nbsp;&nbsp;<br>
		</TD></TR>
		<TR>
			<TD BGCOLOR="#C0C0C0" align="right">
			<input name="acao" type="button" value="Incluir" onClick="executa(this.value)">
			<input name="cancela" type="button" value="Cancelar" onClick="cancelar()"></TD>
		</TR></table>
		</TD></TR></TABLE>
		</div>
	</form>
</center>
</body>
</html>
