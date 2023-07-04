<? 	session_start(); 
	require_once('./filelist_geral.php');
	require_once('./filelist_om.php');
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
		document.cadSubunidade.cod.focus();
	}
	function cancelar(){
   		document.cadSubunidade.cod.value  = "";
		document.cadSubunidade.descricao.value = "";
		document.cadSubunidade.sigla.value = "";
   		document.cadSubunidade.acao.value = "Incluir";
   		document.getElementById("formulario").style.visibility = "hidden";
   		document.getElementById("novo").style.visibility = "visible";
		document.cadSubunidade.cod.readOnly = false;
   		cinza();
	}
	function executa(acao){
		document.cadSubunidade.executar.value = acao;
		if (document.cadSubunidade.descricao.value == ""){
			window.alert("Informe a descrição da Subunidade / Divisão!");
			return;
		}    
		if (acao == "Excluir")  {
			if (!window.confirm("Deseja realmente excluir a Subunidade / Divisão selecionada ?")){
				return ;
			}
		} 
		document.cadSubunidade.action = "cad_subun.php?codom="+document.cadSubunidade.sele_om_vinc.value;
		document.cadSubunidade.submit();
	}
	function carregaedit(cod,descricao,sigla,acao,IDT) {
		cinza();
		if (acao == 'Incluir'){
			document.cadSubunidade.cod.readOnly = false;
		}else {
			document.cadSubunidade.cod.readOnly = true;
		}
		document.getElementById(IDT).style.background = "#DDEDFF";
		document.cadSubunidade.cod.value = cod;
		document.cadSubunidade.descricao.value = descricao;
		document.cadSubunidade.sigla.value = sigla;
   		document.cadSubunidade.acao.value = acao;
   		document.getElementById("formulario").style.visibility = "visible";
   		document.getElementById("novo").style.visibility = "hidden";
   		document.getElementById("tituloForm").innerHTML = acao;
	}  
	function subun(){
		window.location.href = "cad_subun.php?codom="+document.cadSubunidade.sele_om_vinc.value;
//		window.alert('passou!!!');
	}
	
		
	</script>
</head>
<body><center>
	<? 	$apresentacao->chamaCabec();
		$apresentacao->montaMenu();
	?>
	<? 	/*Listar OM vinculadas*/
		$colOmVinc2 = $fachadaSist2->lerColecaoOmVinc('nome');
		if (isset($_GET['codom'])){
			$codom = $_GET['codom'];
		}else {
			$obj = $colOmVinc2->iniciaBusca1();
			
			if (!is_null($obj)){
				$codom = $obj->getCodOM();
			} else {
				$codom = 0;
			}
		}
//	 	$apresentacao->montaCombo('seleParteBi',$colParteBi,'getNumeroParte','getDescricao',8);	
	?>
	
	
	<h3 class="titulo">&nbsp;&nbsp;<img src="./imagens/item_dir.gif" alt="">&nbsp;Cadastro de Subunidades / Divisões / Seções </h3>
	<form  method="post" name="cadSubunidade" action="">
	<p>OM Vinculada:&nbsp;

	<? 	//$apresentacao->montaCombo('seleParteBi',$colParteBi,'getNumeroParte','getDescrReduz',$numeroParteAtual,'secaoParteBi()');
		$apresentacao->montaCombo('sele_om_vinc', $colOmVinc2, 'getCodOM', 'getSigla', $codom, 'subun()');
//		$parteBi = $fachadaSist2->lerParteBoletim($numeroParteAtual);
//		echo '<br><br><b><font size="2">'.$parteBi->getDescricao().'</font></b>';	
	?>
	<br><br>
    <?php
    //verifica permissao
    if ($_SESSION['NOMEUSUARIO'] != 'supervisor')
    { $mIncluir = $funcoesPermitidas->lerRegistro(1046);
    }
    if (($mIncluir != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor'))
    { echo '<table width="65%" border="0" >';
	  echo '<TR><TD><a href="javascript:novo()" id="novo">';
	  echo '<img src="./imagens/add.png" border=0 alt="">&nbsp;<FONT COLOR="#0080C0">Adicionar</FONT></a></TD>';
	  echo '</TR></TABLE>';
	  echo '<p>';
	}
	?>
	<table width="65%" border="0" cellspacing="0"  class="lista"><tr><td>
	<table width="100%" border="0" cellspacing="1" cellpadding="0">
	<tr class="cabec">
		<td width="4%"><div align="center"><strong><font size="2">Ord</font></strong></div></td>
		<td width="56%" align="center"><strong><font size="2">Descrição</font></strong></td>
		<td width="20%" align="center"><strong><font size="2">Sigla</font></strong></td>
		<td width="20%" align="center"><strong><font size="2">Ação</font></strong></td>
	</tr>
	<?php
		if (isset($_POST['executar'])){
  			$subunidade = new Subunidade();
  			$subunidade->setCod($_POST['cod']);
  			$subunidade->setDescricao($_POST['descricao']);
  			$subunidade->setSigla($_POST['sigla']);
  			$omVinv = $colOmVinc2->lerRegistro($codom);

  			if ($_POST['executar'] == 'Incluir'){
				$fachadaSist2->incluirSubun($omVinv,$subunidade);
			}	
			if ($_POST['executar'] == 'Excluir'){
				$fachadaSist2->excluirSubun($omVinv,$subunidade);
			}
			if ($_POST['executar'] == 'Alterar'){
				$fachadaSist2->alterarSubun($omVinv,$subunidade);
			}
  		}

  		$colSubunidade2 = $fachadaSist2->lerColecaoSubun($codom);
                //print_r($colSubunidade2);
  		$subunidade = $colSubunidade2->iniciaBusca1();
		$ord = 0;
  		
		//Alterado para não aparecer os cadasdros 99--> Ten S.Lopes - 23/04/2012
		while ($subunidade != null){
			$ord++;
			if($subunidade->getCod()==99){
				$subunidade = $colSubunidade2->getProximo1();
				continue;
			}
			
			echo '<tr id='.$ord.' onMouseOut="outLinha('.$ord.')" onMouseOver="overLinha('.$ord.')" bgcolor="#F5F5F5">
				<td align="center">'.$subunidade->getCod().'</td><td>'.$subunidade->getDescricao().'</td>
				<td>'.$subunidade->getSigla().'</td><td align="center">
				<a href="javascript:carregaedit('.$subunidade->getCod().',\''.$subunidade->getDescricao().'\',\''.$subunidade->getSigla().'\',\'Alterar\','.$ord.')">';
                //verifica permissao
                if ($_SESSION['NOMEUSUARIO'] != 'supervisor')
                { $mAlterar = $funcoesPermitidas->lerRegistro(1047);
                }
                if (($mAlterar != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor'))
			    { echo '<img src="./imagens/alterar.png"  border=0 title="Alterar" alt="">';
			      echo '<FONT COLOR="#000000"></FONT></a>&nbsp;|&nbsp'; 
			    }
			echo '<a href="javascript:carregaedit('.$subunidade->getCod().',\''.$subunidade->getDescricao().'\',\''.$subunidade->getSigla().'\',\'Excluir\','.$ord.')">';
            //verifica permissao
            if ($_SESSION['NOMEUSUARIO'] != 'supervisor')
            { $mExcluir = $funcoesPermitidas->lerRegistro(1048);
            }
            if (($mExcluir != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor'))
            { echo '<img src="./imagens/excluir.png" border=0 title="Excluir" alt=""><FONT COLOR="#000000"></FONT>';
            }
			echo '</a></td></tr>';
    		$subunidade = $colSubunidade2->getProximo1();
  		}
		?>
  		</table></td></tr>
	</table>
	<b>Legenda:</b> <img src="imagens/alterar.png" width="16" height="16"> Alterar &nbsp;&nbsp;<img src="imagens/excluir.png" width="16" height="16"> Excluir <br>
<script type="text/javascript">javascript:tot_linhas(<?=$ord?>)</script>

		<input name="executar" type="hidden" value="">
		<div id="formulario" STYLE="VISIBILITY:hidden">
                <TABLE class="formulario" CELLPADDING="1" ><TR><TD>
			<TABLE border=0 CELLSPACING="0" CELLPADDING="0" style="name:tabela;">
			<TR CLASS="cabec"><TD><div id="tituloForm"><font size="2"></font></div></TD></TR>
		<TR>
			<TD BGCOLOR="#C0C0C0">
			<br>Código: <input name="cod" type="text" size="3" maxlength="3" onKeyPress="return so_numeros(event)">&nbsp;&nbsp;<br>
			</TD>
		</TR>
		<TR>
			<TD BGCOLOR="#C0C0C0">
			<br>Descrição: <input name="descricao" type="text" size="50" maxlength="50">&nbsp;&nbsp;<br>
			</TD>
		</TR>
		<TR>
			<TD BGCOLOR="#C0C0C0">
			<br>Sigla: <input name="sigla" type="text" size="20" maxlength="20">&nbsp;&nbsp;<br><br>
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
