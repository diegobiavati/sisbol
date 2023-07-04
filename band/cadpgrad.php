<? 	session_start();
	require_once('./filelist_geral.php');
	require_once('./filelist_pgrad.php');
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
	
	function novo(){
		document.getElementById("formulario").style.visibility = "visible";
		document.getElementById("novo").style.visibility = "hidden";
		document.getElementById("tituloForm").innerHTML = "Incluir";
		document.cadPGrad.cod.readOnly = false;
		document.cadPGrad.cod.focus();
	}
	function cancelar(){
   		document.cadPGrad.cod.value  = "";
		document.cadPGrad.nome.value = "";
   		document.cadPGrad.acao.value = "Incluir";
   		document.getElementById("formulario").style.visibility = "hidden";
   		document.getElementById("novo").style.visibility = "visible";
   		cinza();
	}
	function executa(acao){
		document.cadPGrad.executar.value = acao;
		if (document.cadPGrad.nome.value == ""){
			window.alert("Informe o nome do Posto/Graduaçao!");
			return;
		}
		var codpgrad = document.cadPGrad.cod.value;
		if ((codpgrad  == 2) || (codpgrad == 3) || (codpgrad == 4) || (codpgrad == 60)){
		window.alert("Não é possível alterar este registro!");
		return false;
		}
		if (acao == "Excluir")  {
			if (!window.confirm("Deseja realmente excluir o Posto/Graduaçao selecionado ?")){
				return ;
			}
		
}
		document.cadPGrad.action = "cadpgrad.php";
		document.cadPGrad.submit();
	}
	function carregaedit(cod,nome,acao,IDT) {
		//cinza();
		
		document.cadPGrad.cod.readOnly = true;
		document.getElementById(IDT).style.background = "#E2F1E7";
		document.cadPGrad.nome.value = nome;
		document.cadPGrad.cod.value  = cod;
   		document.cadPGrad.acao.value = acao;
   		document.getElementById("formulario").style.visibility = "visible";
   		document.getElementById("novo").style.visibility = "hidden";
   		document.getElementById("tituloForm").innerHTML = acao;
		window.location.href = "#form";
		if(acao == "Alterar"){
			document.cadPGrad.nome.focus();
		}
	}
	</script>
</head>
<body><center>
	<? 	$apresentacao->chamaCabec();
		$apresentacao->montaMenu();
	?>

	<h3 class="titulo">&nbsp;&nbsp;<img src="./imagens/item_dir.gif" alt="">&nbsp;Cadastro de Posto e Graduações <img src="./imagens/ajuda.png" alt="" width="14" height="14" onClick="ajuda('cadPGrad')" onMouseOver="this.style.cursor='help';" onMouseOut="this.style.cursor='default';"></h3>

	<?php
      //verifica permissao
      if ($_SESSION['NOMEUSUARIO'] != 'supervisor')
      { $mIncluir = $funcoesPermitidas->lerRegistro(1001);
      }
      if (($mIncluir != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor'))
      { echo '<table width="400px" border="0" >';
        echo '<TR>';
	    echo '<TD><a href="javascript:novo()" id="novo">';
	    echo '<img src="./imagens/add.png" border=0 alt="">&nbsp;<FONT COLOR="#0080C0">Adicionar</FONT></a>';
	    echo '</TD>';
	    echo '</TR>';
	    echo '</TABLE>';
		
	  }
	?>
	<table width="400px" border="0" cellspacing="0" cellpadding="0" class="lista"><tr><td>
	<table width="100%" border="0" cellspacing="1" cellpadding="0">
	<tr class="cabec">
		<td width="4%"><div align="center"><strong><font size="2">Cód</font></strong></div></td>
		<td width="38%" align="center"><strong><font size="2">Posto/Graduação</font></strong></td>
		<td width="10%" align="center"><strong><font size="2">Ação</font></strong></td>
	</tr>
	<?php
		if (isset($_POST['executar'])){
  			$pGrad = new PGrad();
  			$pGrad->setCodigo($_POST['cod']);
  			$pGrad->setDescricao($_POST['nome']);
  			//echo $cod. ' nome'.$_POST['nome'];

  			if ($_POST['executar'] == 'Incluir'){
				$fachadaSist2->incluirPGrad($pGrad);
			}
			if ($_POST['executar'] == 'Excluir'){
				$fachadaSist2->excluirPGrad($pGrad);
			}
			if ($_POST['executar'] == 'Alterar'){
			
				$fachadaSist2->alterarPGrad($pGrad);
			}
  		}
  		$colPGrad2 = $fachadaSist2->lerColecaoPGrad('cod');
  		$pGrad = $colPGrad2->iniciaBusca1();

  		//$apresentacao->montaCombo('selePGrad',$colPGrad3,'getCodigo','getDescricao','11');


		  while ($pGrad != null){
			$ord++;	
			
			if($pGrad->getCodigo()==99){ 
				$pGrad = $colPGrad2->getProximo1();
				continue;
			}
			echo '<tr id= "linha_'.$ord.'" onMouseOut="outLinha(this)" onMouseOver="overLinha(this)" bgcolor="#F5F5F5">
				<td align="center">'.$pGrad->getCodigo().'</td><td>'. $pGrad->getDescricao().'</td>
				<td align="center">
				<a href="javascript:carregaedit('.$pGrad->getCodigo().',\''.$pGrad->getDescricao().'\',\'Alterar\',\'linha_'.$ord.'\')">';


            //verifica permissao
            if ($_SESSION['NOMEUSUARIO'] != 'supervisor')
            { $mAlterar = $funcoesPermitidas->lerRegistro(1002);
            }
            if (($mAlterar != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor'))
		    { echo '<img src="./imagens/alterar.png" title="Alterar" border=0 alt=""></a>&nbsp;|&nbsp';
		    }
    		echo '<a href="javascript:carregaedit('.$pGrad->getCodigo().',\''.$pGrad->getDescricao().'\',\'Excluir\',\'linha_'.$ord.'\')">';

            //verifica permissao
            if ($_SESSION['NOMEUSUARIO'] != 'supervisor')
            { $mExcluir = $funcoesPermitidas->lerRegistro(1003);
            }
            if (($mExcluir != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor'))
            { echo '<img src="./imagens/excluir.png" title="Excluir" border=0 alt="Excluir">';
            }
			echo '</a></td></tr>';

    		$pGrad = $colPGrad2->getProximo1();
			
  		}
		?>
  		</table></td></tr>
	</table>
	<script type="text/javascript">javascript:tot_linhas(<?=$ord?>)</script>
	
    <b>Legenda:</b>
	      <img src="imagens/alterar.png" width="16" height="16" alt="Alterar">
	Alterar &nbsp;&nbsp;<img src="imagens/excluir.png" width="16" height="16" alt="Excluir">
    Excluir <br>
	<form  method="post" name="cadPGrad" action="">
		<input name="executar" type="hidden" value="">
		<div id="formulario" STYLE="VISIBILITY:hidden">
                <br>
		<TABLE class="formulario" CELLPADDING="1" ><TR><TD>
			<TABLE border=0 CELLSPACING="0" CELLPADDING="0" style="name:tabela;">
			<TR CLASS="cabec"><TD><div id="tituloForm"><font size="2"></font></div></TD></TR>
			<tr>
		<TD BGCOLOR="#C0C0C0">
		Cód: <input name="cod" size="2" maxlength="2">&nbsp;&nbsp;
		Descriçao:&nbsp;
		<input name="nome" type="text" size="15" maxlength="15"></TD>
		</TR><TR>
			<TD BGCOLOR="#C0C0C0" align="right">
			<input name="acao" type="button" value="Incluir" onClick="executa(this.value)">
			<input name="cancela" type="button" value="Cancelar" onClick="cancelar()">
		</TR></table>
		</TR></TABLE>
		</div>
          
	</form>
  
  <p>&nbsp;</p> <p>&nbsp;</p>
  <a id="form"></a>

</center>
</body>
</html>
