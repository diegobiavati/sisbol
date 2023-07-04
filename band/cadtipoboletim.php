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
		//document.cadTipoBoletim.nr_ult_bi.readOnly  = false;
		//document.cadTipoBoletim.nr_ult_pag.readOnly  = false;
		document.cadTipoBoletim.nr_ult_bi.value  = 0;
   		document.cadTipoBoletim.nr_ult_pag.value  = 0;
   		document.cadTipoBoletim.ini_num_paginas.checked=false;
   		document.cadTipoBoletim.e_aditamento.checked=false;
   		document.cadTipoBoletim.imp_bordas.checked=false;
   		document.cadTipoBoletim.titulo2.value="Para conhecimento deste aquartelamento e devida execução, publico o seguinte:";
		document.cadTipoBoletim.descricao.focus();
	}
	function cancelar(){
   		document.cadTipoBoletim.cod.value  = 0;
		document.cadTipoBoletim.descricao.value  = "";
		document.cadTipoBoletim.abreviatura.value = "";
   		document.cadTipoBoletim.nr_ult_bi.value  = "";
   		document.cadTipoBoletim.nr_ult_pag.value  = "";
   		document.cadTipoBoletim.acao.value = "Incluir";
   		document.cadTipoBoletim.titulo2.value = "";
   		document.getElementById("formulario").style.visibility = "hidden";
   		document.getElementById("novo").style.visibility = "visible";
	}
	function executa(acao){
		document.cadTipoBoletim.executar.value = acao;
		if (document.cadTipoBoletim.descricao.value == ""){
			window.alert("Informe o Tipo de Boletim!");
			return;
		}
		if (document.cadTipoBoletim.abreviatura.value == "") {
			window.alert("Informe a abreviatura do Tipo de Boletim!");
			return;
		}
		if (acao == "Excluir")  {
			if (!window.confirm("Deseja realmente excluir o tipo de boletim selecionado ?")){
				return ;
			}
		}

		document.cadTipoBoletim.action = "cadtipoboletim.php";
		document.cadTipoBoletim.submit();
	}
	function carregaedit(cod,descricao,abreviatura,ult_bi,ult_pag,qtdBI,ini_num_paginas,e_aditamento,imp_bordas,titulo,acao,IDT) {
		document.cadTipoBoletim.cod.value  = cod;
		document.cadTipoBoletim.descricao.value  = descricao;
		document.cadTipoBoletim.abreviatura.value = abreviatura;
   		/*
   		if (qtdBI > 0 ) {
		   document.cadTipoBoletim.nr_ult_bi.readOnly  = true;
		   document.cadTipoBoletim.nr_ult_pag.readOnly  = true;
		} else {
			document.cadTipoBoletim.nr_ult_bi.readOnly  = false;
			document.cadTipoBoletim.nr_ult_pag.readOnly  = false;
		}*/
		document.cadTipoBoletim.nr_ult_bi.value  = ult_bi;
   		document.cadTipoBoletim.nr_ult_pag.value  = ult_pag;

		document.cadTipoBoletim.ini_num_paginas.checked = ini_num_paginas == "S"?true:false;

		document.cadTipoBoletim.e_aditamento.checked = e_aditamento == "S"?true:false;

		document.cadTipoBoletim.imp_bordas.checked = imp_bordas=='S'?true:false;
		document.cadTipoBoletim.titulo2.value = titulo;
		document.cadTipoBoletim.acao.value = acao;

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

	<h3 class="titulo">&nbsp;&nbsp;<img src="./imagens/item_dir.gif" alt="">&nbsp;Cadastro de Tipo de Boletim <img src="imagens/ajuda.png" width="14" height="14" onClick="ajuda('cadTipoBoletim')"onMouseOver="this.style.cursor='help';" onMouseOut="this.style.cursor='default';"></h3>
      
        <?
        //verifica permissao para incluir
        if ($_SESSION['NOMEUSUARIO'] != 'supervisor')
        { $mIncluir = $funcoesPermitidas->lerRegistro(1051);
        }
        if (($mIncluir != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor'))
          	  { 
                    echo '<table width="750px" border="0" ><TR>';
        	    echo '<TD><a href="javascript:novo()" id="novo">';
                    echo '<img src="./imagens/add.png" border=0 alt="">&nbsp;<FONT COLOR="#0080C0">Adicionar</FONT></a>';
        	    echo '</TD></TR></TABLE>';
				echo '<p>';
				
	  }
	?>
            
	<table width="750px" border="0" cellspacing="0" class="lista"><tr><td>
	<table width="100%" border="0" cellspacing="1" cellpadding="0">
	<tr class="cabec">
		<td width="4%"><div align="center"><strong><font size="2">Ord</font></strong></div></td>
		<td width="26%" align="center"><strong><font size="2">Descri&ccedil;&atilde;o</font></strong></td>
		<td width="15%" align="center"><strong><font size="2">Abreviatura</font></strong></td>
		<td width="10%" align="center"><strong><font size="2">&Uacute;timo BI</font></strong></td>
		<td width="10%" align="center"><strong><font size="2">&Uacute;tima P&aacute;g.</font></strong></td>
		<td width="10%" align="center"><strong><font size="2">QTD BI</font></strong></td>
		<td width="10%" align="center"><strong><font size="2">Ação</font></strong></td>
	</tr>
      
	<?php
		if (isset($_POST['executar'])){
  			$tipoBol = new TipoBol();
  			$tipoBol->setCodigo($_POST['cod']);
  			$tipoBol->setDescricao($_POST['descricao']);
  			$tipoBol->setAbreviatura($_POST['abreviatura']);
  			$tipoBol->setNrUltBi($_POST['nr_ult_bi']);
  			$tipoBol->setNrUltPag($_POST['nr_ult_pag']);
  			$tipoBol->setTitulo2($_POST['titulo2']);

			if (isset($_POST['ini_num_paginas'])){
	  			$tipoBol->setIni_num_pag("S");
  			}else{
	  			$tipoBol->setIni_num_pag("N");
			}
			if (isset($_POST['e_aditamento'])){
	  			$tipoBol->setE_Aditamento("S");
  			}else{
	  			$tipoBol->setE_Aditamento("N");
			}
			$tipoBol->setImp_bordas(isset($_POST['imp_bordas'])?'S':'N');

  			if ($_POST['executar'] == 'Incluir'){
				$fachadaSist2->incluirTipoBol($tipoBol);
			}
			if ($_POST['executar'] == 'Excluir'){
				$fachadaSist2->excluirTipoBol($tipoBol);
			}
			if ($_POST['executar'] == 'Alterar'){
				$fachadaSist2->alterarTipoBol($tipoBol);
			}
  		}
  		$colTipoBol2 = $fachadaSist2->lerColecaoTipoBol('descricao');
  		$tipoBol = $colTipoBol2->iniciaBusca1();
  		while ($tipoBol != null)
		{   $qtdBol = $fachadaSist2->getQTDBoletim($tipoBol->getCodigo());
			$ord++;
			echo '<tr id='.$ord.' onMouseOut="outLinha('.$ord.')" onMouseOver="overLinha('.$ord.')" bgcolor="#F5F5F5">
				<td align="center">'.$ord.'</td>
				<td>'. $tipoBol->getDescricao().'</td><td align="center">'.$tipoBol->getAbreviatura().'</td>
				<td align="center">'. $tipoBol->getNrUltBi().'</td>
				<td align="center">'. $tipoBol->getNrUltPag().'</td>
				<td align="center">'. $qtdBol . '</td>
				<td align="center">';

            //verifica permissao para alterar
            if ($_SESSION['NOMEUSUARIO'] != 'supervisor')
            { $mAlterar = $funcoesPermitidas->lerRegistro(1052);
            }
            $carrega = $tipoBol->getCodigo().',\''
					.$tipoBol->getDescricao().'\',\''
					.$tipoBol->getAbreviatura().'\','
					.$tipoBol->getNrUltBi().','
					.$tipoBol->getNrUltPag().','
					.$qtdBol.',\''
					.$tipoBol->getIni_num_pag().'\',\''
					.$tipoBol->getE_Aditamento().'\',\''
					.$tipoBol->getImp_bordas().'\',\''
					.$tipoBol->getTitulo2();

            if (($mAlterar != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor'))
		    { echo '<a href="javascript:carregaedit('.$carrega.'\',\'Alterar\','.$ord.')">
					<img src="./imagens/alterar.png" title="Alterar" border=0 alt=""></a>';
		    }
            //verifica permissao para excluir
            if ($_SESSION['NOMEUSUARIO'] != 'supervisor')
            { $mExcluir = $funcoesPermitidas->lerRegistro(1053);
            }
            if (($mExcluir != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor'))
            { if (($mAlterar != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor'))
			  { echo '&nbsp;|&nbsp';}
			  echo '<a href="javascript:carregaedit('.$carrega.'\',\'Excluir\','.$ord.')"><img src="./imagens/excluir.png" border=0 title="Excluir" alt=""></a>';
            }
			echo '</td></tr>';
    		$tipoBol = $colTipoBol2->getProximo1();
  		}
		?>
  		</table></td></tr>
	</table>
	<!-- Formulário parainserçao/alteração de dados Inicialmente escondido-->
	<form  method="post" name="cadTipoBoletim" action="">
		<input name="executar" type="hidden" value="">
		<b>Legenda:</b> <img src="imagens/alterar.png" width="16" height="16"> Alterar &nbsp;&nbsp;<img src="imagens/excluir.png" width="16" height="16"> Excluir
		<div id="formulario" STYLE="VISIBILITY:hidden">
		  <input name="cod" size="2" maxlength="2" type="hidden" value="0">
			<TABLE width="700"  class="formulario" bgcolor="#0000FF" CELLPADDING="1" cellspacing="0">
			<TR><TD  align="right">
				<TABLE width="100%" border="0" CELLSPACING="0" CELLPADDING="0" style="name:tabela;">
				<TR CLASS="cabec">
					<TD colspan="3"><div id="tituloForm"><font size="2"></font></div></TD>
				</TR><TR VALIGN="BOTTOM">
					<TD BGCOLOR="#C0C0C0"><br>Descriçao:</TD>
					<TD BGCOLOR="#C0C0C0"><input name="descricao" type="text" size="50" maxlength="40"></TD>
					<TD BGCOLOR="#C0C0C0">Abrev: <input name="abreviatura" type="text" size="20" maxlength="20"></TD>
				</TR><TR  valign="bottom">
					<TD BGCOLOR="#C0C0C0"><br>Último BI: </TD>
					<TD BGCOLOR="#C0C0C0" COLSPAN="2"><input name="nr_ult_bi" type="text" size="10" maxlength="6" onKeyPress="return so_numeros(event)">
					Última Pág: <input name="nr_ult_pag" type="text" size="10" maxlength="6" onKeyPress="return so_numeros(event)"></TD>
				</TR><TR valign="bottom">
					<TD BGCOLOR="#C0C0C0" valign="top" colspan="3">&nbsp;</TD>
				</TR><TR  valign="top">
					<TD BGCOLOR="#C0C0C0">Outros:</TD>
					<TD BGCOLOR="#C0C0C0" colspan="2">
					<input type="checkbox" name="ini_num_paginas" value="N"> Reiniciar numeração de páginas a cada boletim.<br>
					<input type="checkbox" name="e_aditamento" value="N"> É aditamento ao boletim.<br>
					<input type="checkbox" name="imp_bordas" value="S"> Imprimir bordas ?</TD>
				</TR><TR>
					<TD BGCOLOR="#C0C0C0" align="left" colspan="3"><br>Texto de abertura do Boletim:</td>
				</TR><TR>
					<TD BGCOLOR="#C0C0C0" align="center" colspan="3">
						<textarea name="titulo2" cols="80" rows="1"></textarea><TD>
				</TR><TR>
					<TD BGCOLOR="#C0C0C0" align="right" colspan="3"><br>
						<input name="acao" type="button" value="Incluir" onClick="executa(this.value)">
						<input name="cancela" type="button" value="Cancelar" onClick="cancelar()"><TD>
				</TR></table>
			</TD></TR></TABLE>
		</div>
	</form>
</center>
</body>
</html>
