<? 	session_start(); 
	require_once('./filelist_geral.php');
	require_once('./filelist_om.php');
	$fachadaSist2 = new FachadaSist2();
    $funcoesPermitidas = $fachadaSist2->lerColecaoAutorizada($_SESSION['NOMEUSUARIO'], 'X');	
	$apresentacao = new Apresentacao($funcoesPermitidas);
        $ordem = (isset($_GET['ordem']))?($_GET['ordem']):"nome";
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
		document.cadOmVinc.codom.focus();
	}
	function cancelar(){
   		document.cadOmVinc.codom.value  = "";
		document.cadOmVinc.gu.value  = "";
		document.cadOmVinc.sigla.value  = "";
		document.cadOmVinc.nome.value = "";
   		document.cadOmVinc.acao.value = "Incluir";
   		document.getElementById("formulario").style.visibility = "hidden";
   		document.getElementById("novo").style.visibility = "visible";
	}
	function executa(acao){
		document.cadOmVinc.executar.value = acao;
		if (document.cadOmVinc.codom.value == ""){
			window.alert("Informe o CODOM da OM!");
			return;
		}    
		if (document.cadOmVinc.gu.value == "") {
			window.alert("Informe a Guarnição da OM!");
			return;
		}
		if (document.cadOmVinc.sigla.value == "") {
			window.alert("Informe a Sigla da OM!");
			return;
		}
		if (document.cadOmVinc.nome.value == "") {
			window.alert("Informe o nome da OM!");
			return;
		}
		if (acao == "Excluir")  {
			if (!window.confirm("Deseja realmente excluir a OM selecionada?")){
				return ;
			}
		} 
		document.cadOmVinc.action = "cad_om_vinc.php";
		document.cadOmVinc.submit();
	}
	function carregaedit(codom,gu,sigla,nome,acao,IDT) {
		document.cadOmVinc.codom.value  = codom;
		document.cadOmVinc.codom.readOnly  = true;
		document.cadOmVinc.gu.value  = gu;
		document.cadOmVinc.sigla.value  = sigla;
		document.cadOmVinc.nome.value = nome;
		document.cadOmVinc.acao.value = acao;
   		document.getElementById("formulario").style.visibility = "visible";
   		document.getElementById("novo").style.visibility = "hidden";
   		document.getElementById("tituloForm").innerHTML = acao;
	}
        function ordena(ordem){
		window.location.href="cad_om_vinc.php?ordem="+ordem;
        }
	</script>
</head>
<body><center>
	<? 	$apresentacao->chamaCabec();
		$apresentacao->montaMenu();
	?>
	
	<h3 class="titulo">&nbsp;&nbsp;<img src="./imagens/item_dir.gif" alt="">&nbsp;Cadastro de OM para Vinculação <img src="imagens/ajuda.png" width="14" height="14" alt="Help" onClick="ajuda('cadOmVinc')" onMouseOver="this.style.cursor='help';" onMouseOut="this.style.cursor='default';"></h3>
	
	<?php
      //verifica permissao para incluir
      if ($_SESSION['NOMEUSUARIO'] != 'supervisor')
      { $mIncluir = $funcoesPermitidas->lerRegistro(1041);
      }
      if (($mIncluir != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor'))
      { echo '<table width="70%" border="0" >';
        echo '<TR>';
	    echo '<TD><a href="javascript:novo()" id="novo">';
	    echo '<img src="./imagens/add.png" border=0 alt="">&nbsp;<FONT COLOR="#0080C0">Adicionar</FONT></a>';
	    echo '</TD>';
	    echo '</TR>';
	    echo '</TABLE>';
		echo '<p>';
	  }
	?>
	<table width="70%" border="0" cellspacing="0"  class="lista"><tr><td>
	<table width="100%" border="0" cellspacing="1" cellpadding="0">
	<tr class="cabec">
		<td width="4%"><div align="center"><strong><font size="2">Ord</font></strong></div></td>
		<td width="10%" align="center"><strong><font size="2">CODOM<br><a href="javascript:ordena('codom')"></a></font></strong></td>
		<td width="23%" align="center"><strong><font size="2">Guarnição</font></strong></td>
		<td width="15%" align="center"><strong><font size="2">Sigla</font></strong></td>
		<td width="38%" align="center"><strong><font size="2">Nome<br><a href="javascript:ordena('nome')"></a></font></strong></td>
		<td width="10%" align="center"><strong><font size="2">Ação</font></strong></td>
	</tr>
	<?php
		if (isset($_POST['executar'])){
  			$omVinc = new OmVinc(null);
  			$omVinc->setCodom($_POST['codom']);
  			$omVinc->setGu($_POST['gu']);
  			$omVinc->setSigla($_POST['sigla']);
  			$omVinc->setNome($_POST['nome']);
		
  			if ($_POST['executar'] == 'Incluir'){
				$fachadaSist2->incluirOmVinc($omVinc);	
			}	
			if ($_POST['executar'] == 'Excluir'){
				$fachadaSist2->excluirOmVinc($omVinc);
			}
			if ($_POST['executar'] == 'Alterar'){
				$fachadaSist2->alterarOmVinc($omVinc);
			}
  		}
  		$colOmVinc2 = $fachadaSist2->lerColecaoOmVinc($ordem);
  		$omVinc = $colOmVinc2->iniciaBusca1();
					
  		while ($omVinc != null){
			$ord++;
			//Alterado para não aparecer os cadasdros 99--> Ten S.Lopes - 23/04/2012
			if($omVinc->getCodom()==999999){
				$omVinc = $colOmVinc2->getProximo1();
				continue;
			}
			
			echo '<tr id='.$ord.' onMouseOut="outLinha('.$ord.')" onMouseOver="overLinha('.$ord.')" bgcolor="#F5F5F5">
				<td align="center">'.$ord.'</td>
				<td align="center">'.$omVinc->getCodOM().'</td>
				<td align="center">'.$omVinc->getGu().'</td>
				<td align="left">'.$omVinc->getSigla().'</td>
				<td align="left">'.$omVinc->getNome().'</td>
				<td align="center">';

            //verifica permissao para alterar
            if ($_SESSION['NOMEUSUARIO'] != 'supervisor')
            { $mAlterar = $funcoesPermitidas->lerRegistro(1042);
            }
            if (($mAlterar != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor'))
		    { echo '<a href="javascript:carregaedit(\''.$omVinc->getCodOM().'\',\''
					.$omVinc->getGu().'\',\''.$omVinc->getSigla().'\',\''
					.$omVinc->getNome().'\',\'Alterar\','.$ord.')">
					<img src="./imagens/alterar.png" title="Alterar" border=0 alt=""></a>'; 
		    }
            //verifica permissao para excluir
            if ($_SESSION['NOMEUSUARIO'] != 'supervisor')
            { $mExcluir = $funcoesPermitidas->lerRegistro(1043);
            }
            if (($mExcluir != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor'))
            { if (($mAlterar != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor'))
			  { echo '&nbsp;|&nbsp';}
			  echo '<a href="javascript:carregaedit(\''.$omVinc->getCodOM().'\',\''
					.$omVinc->getGu().'\',\''.$omVinc->getSigla().'\',\''
					.$omVinc->getNome().'\',\'Excluir\','.$ord.')"><img src="./imagens/excluir.png" title="Excluir" border=0 alt=""></a>';
            }
			echo '</td></tr>';
    		$omVinc = $colOmVinc2->getProximo1();
  		}
		?>
  		</table></td></tr>
	</table>
	<b>Legenda:</b> <img src="imagens/alterar.png" width="16" height="16" alt="Alterar"> Alterar &nbsp;&nbsp;<img src="imagens/excluir.png" width="16" height="16" alt="Excluir"> Excluir <br>
	<!-- Formulário parainserçao/alteração de dados Inicialmente escondido-->	
  <form  method="post" name="cadOmVinc" action="">
		<input name="executar" type="hidden" value="">
		<div id="formulario" STYLE="VISIBILITY:hidden">
                        <br>
			<TABLE width="40%" class="formulario" CELLPADDING="1" ><TR><TD>
			<TABLE width="100%" border=0 CELLSPACING="0" CELLPADDING="0" style="name:tabela;">
			<TR CLASS="cabec"><TD colspan="2"><div id="tituloForm"><font size="2"></font></div></TD></TR>
			<tr>
			<TD BGCOLOR="#C0C0C0">&nbsp;</td>
			<TD BGCOLOR="#C0C0C0">
			CODOM:<br>
			<input name="codom" type="text" size="10" maxlength="10"><br>
			Guarnição:<br>
			<input name="gu" type="text" size="40" maxlength="40"><br>
			Sigla:<br>
			<input name="sigla" type="text" size="30" maxlength="30"><br>
			Nome:<br>
			<input name="nome" type="text" size="80" maxlength="80"><br>
			</TD>
			</TR><TR>
			<TD BGCOLOR="#C0C0C0" align="right" colspan="2">
			<input name="acao" type="button" value="Incluir" onClick="executa(this.value)">
			<input name="cancela" type="button" value="Cancelar" onClick="cancelar()"><TD>
			</TR></table>
			</TD></TR></TABLE>
		</div>
	</form>
</center>
</body>
</html>
