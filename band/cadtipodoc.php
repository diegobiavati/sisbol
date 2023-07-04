<? 	session_start(); 
	require('filelist_geral.php');
	require_once('./filelist_tipodoc.php');
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
		document.cadTipoDoc.descricao.focus();
	}
	function cancelar(){
   		document.cadTipoDoc.cod.value  = "";
		document.cadTipoDoc.descricao.value = "";
   		document.cadTipoDoc.acao.value = "Incluir";
   		document.getElementById("formulario").style.visibility = "hidden";
   		document.getElementById("novo").style.visibility = "visible";
   		cinza();
	}
	function executa(acao){
		document.cadTipoDoc.executar.value = acao;
		if (document.cadTipoDoc.descricao.value == ""){
			window.alert("Informe o tipo de documento!");
			return;
		}    
		if (acao == "Excluir")  {
			if (!window.confirm("Deseja realmente excluir o tipo de documento selecionado ?")){
				return ;
			}
		} 
		document.cadTipoDoc.action = "cadtipodoc.php";
		document.cadTipoDoc.submit();
	}
	function carregaedit(cod,descricao,acao,IDT) {
		cinza();
		document.cadTipoDoc.cod.readOnly = true;
		document.getElementById(IDT).style.background = "#DDEDFF";
		document.cadTipoDoc.cod.value  = cod;
		document.cadTipoDoc.descricao.value = descricao;
		document.cadTipoDoc.acao.value = acao;
   		document.getElementById("formulario").style.visibility = "visible";
   		document.getElementById("novo").style.visibility = "hidden";
   		document.getElementById("tituloForm").innerHTML = acao;
	}  
	</script>
</head>
<body>
<center>
  <? 	$apresentacao->chamaCabec();
		$apresentacao->montaMenu();
	?>
  <h3 class="titulo">&nbsp;&nbsp;<img src="./imagens/item_dir.gif" alt="">&nbsp;Cadastro de Tipos de Documentos <img src="imagens/ajuda.png" width="14" height="14" onClick="ajuda('cadTipoDoc')" onMouseOver="this.style.cursor='help';" onMouseOut="this.style.cursor='default';"></h3>
  <?php
      //verifica permissao
      if ($_SESSION['NOMEUSUARIO'] != 'supervisor')
      { $mIncluir = $funcoesPermitidas->lerRegistro(1071);
      }
      if (($mIncluir != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor'))
      { echo '<table width="40%" border="0" >';
	    echo '<TR><TD><a href="javascript:novo()" id="novo">';
        echo '<img src="./imagens/add.png" border=0 alt="">&nbsp;<FONT COLOR="#0080C0">Adicionar</FONT></a></TD>';
	    echo '</TR></TABLE>';
		echo '<p>';
	  }
        ?>
  <table width="40%" border="0" cellspacing="0"  class="lista">
    <tr>
      <td><table width="100%" border="0" cellspacing="1" cellpadding="0">
          <tr class="cabec">
            <td width="5%"><div align="center"><strong><font size="2">Ord</font></strong></div></td>
            <td width="60%" align="center"><strong><font size="2">Tipos de Documentos</font></strong></td>
            <td width="15%" align="center"><strong><font size="2">Ação</font></strong></td>
          </tr>
          <?php
		if (isset($_POST['executar'])){
  			$TipoDoc = new TipoDoc();
  			if (isset($_POST['cod'])){
  				$TipoDoc->setCodigo($_POST['cod']);
  			}
  			$TipoDoc->setDescricao($_POST['descricao']);
			if ($_POST['executar'] == 'Incluir'){
				$fachadaSist2->incluirTipoDoc($TipoDoc);	
			}	
			if ($_POST['executar'] == 'Excluir'){
				$fachadaSist2->excluirTipoDoc($TipoDoc);
			}
			if ($_POST['executar'] == 'Alterar'){
				$fachadaSist2->alterarTipoDoc($TipoDoc);
			}
  		}
  		$colTipoDoc2 = $fachadaSist2->lerColecaoTipoDoc('codigo_tipo');
  		$TipoDoc = $colTipoDoc2->iniciaBusca1();
		$ord = 0;
  		while ($TipoDoc != null){
			$ord++;
			echo '<tr id='.$ord.' onMouseOut="outLinha('.$ord.')" onMouseOver="overLinha('.$ord.')" bgcolor="#F5F5F5">
				<td align="center">'.$ord.'</td><td>'. $TipoDoc->getDescricao().'</td>
				<td align="center">
				<a href="javascript:carregaedit('.$TipoDoc->getCodigo().',\''.$TipoDoc->getDescricao().'\',\'Alterar\','.$ord.')">';
            //verifica permissao
            if ($_SESSION['NOMEUSUARIO'] != 'supervisor'){ 
				$mAlterar = $funcoesPermitidas->lerRegistro(1072);
            }
            if (($mAlterar != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor')){ 
				echo '<img src="./imagens/alterar.png"  border=0 TITLE="Alterar" alt="">';
              	echo '<FONT COLOR="#000000"></FONT></a>&nbsp;|&nbsp'; 
            }
			echo '<a href="javascript:carregaedit('.$TipoDoc->getCodigo().',\''.$TipoDoc->getDescricao().'\',\'Excluir\','.$ord.')">';
            //verifica permissao
            if ($_SESSION['NOMEUSUARIO'] != 'supervisor'){ 
				$mExcluir = $funcoesPermitidas->lerRegistro(1073);
            }
            if (($mExcluir != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor')){ 
				echo '<img src="./imagens/excluir.png" border=0 TITLE="Excluir" alt=""><FONT COLOR="#000000"></FONT>';
            }
			echo '</a></td></tr>';
    		$TipoDoc = $colTipoDoc2->getProximo1();
  		}
		?>
        </table></td>
    </tr>
  </table>
  <script type="text/javascript">javascript:tot_linhas(<?=$ord?>)</script>
  <form  method="post" name="cadTipoDoc" action="">
    <b>Legenda:</b> <img src="imagens/alterar.png" width="16" height="16"> Alterar &nbsp;&nbsp;<img src="imagens/excluir.png" width="16" height="16"> Excluir
<input name="executar" type="hidden" value="">
    <input name="cod" type="hidden" value="">
    <div id="formulario" STYLE="VISIBILITY:hidden">
      <TABLE class="formulario" bgcolor="#0000FF" CELLPADDING="1" >
        <TR>
          <TD>
		  	<TABLE border=0 CELLSPACING="0" CELLPADDING="0" style="name:tabela;">
              <TR CLASS="cabec">
                <TD><div id="tituloForm"><font size="2"></font></div></TD>
              </TR>
			  <tr>
              <TD BGCOLOR="#C0C0C0"> Descrição:
                  <input name="descricao" type="text" size="40" maxlength="40">
                  &nbsp;&nbsp; </TD>
              </TR><TR>
                <TD BGCOLOR="#C0C0C0" align="right"><input name="acao" type="button" value="Incluir" onClick="executa(this.value)">
                  <input name="cancela" type="button" value="Cancelar" onClick="cancelar()"></TD>
              </TR>
            </table>
		  </TD>
        </TR>
      </TABLE>
    </div>
  </form>
</center>
</body>
</html>
