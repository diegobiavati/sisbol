<? 	session_start();
	require_once('./filelist_geral.php');
	require_once('./filelist_boletim.php');
	require_once('./filelist_funcao.php');
	require_once('./filelist_militar.php');
	require_once('./filelist_pgrad.php');
	require_once('./filelist_qm.php');
	require_once('./filelist_controladoras.php');
	require_once('./filelist_om.php');
	require_once('./filelist_usuariofuncaotipobol.php');
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
	var janelaPDF;
	function novo(e_adt){
		document.getElementById("formulario").style.visibility = "visible";
		document.getElementById("novo").style.visibility = "hidden";
		//document.getElementById("nrbi").style.visibility = "hidden";
		document.getElementById("captionBI").style.visibility = "hidden";
		if (e_adt != 'S') document.getElementById("captionRefBi").style.visibility = "hidden";
		document.getElementById("tituloForm").innerHTML = "Incluir";
		document.cadBoletim.data_normal.value ='<?=date("d/m/Y"); ?>';
		document.cadBoletim.data_normal.focus();
	}

function validarData(campo){
	var expReg = /^(([0-2]\d|[3][0-1])\/([0]\d|[1][0-2])\/[1-2][0-9]\d{2})$/;
	var msgErro = 'Formato de data inválido!';
	if ((campo.value.match(expReg)) && (campo.value!='')){
		var dia = campo.value.substring(0,2);
		var mes = campo.value.substring(3,5);
		var ano = campo.value.substring(6,10);

		if((mes==4 || mes==6 || mes==9 || mes==11) && (dia > 30)){
			window.alert("Dia incorreto!!! O mês especificado contém no máximo 30 dias.");
			campo.focus();
			return false;
		} else{
			if(ano%4!=0 && mes==2 && dia>28){
				window.alert("Dia incorreto!!!!!! O mês especificado contém no máximo 28 dias.");
				campo.focus();
				return false;
			} else{
				if(ano%4==0 && mes==2 && dia>29){
					window.alert("Dia incorreto!!!!!! O mês especificado contém no máximo 29 dias.");
					campo.focus();
					return false;
				} else{
					var data = ano + '-' + mes + '-' + dia;
					document.cadBoletim.data_pub.value = data;
					return true;
				}
			}
		}

	}else {
		window.alert(msgErro);
		campo.focus();
		return false;
	}
}

	function cancelar(){
   		document.cadBoletim.data_normal.value  = "";
   		document.cadBoletim.bi_ref.value  = "";
   		document.cadBoletim.acao.value = "Incluir";
   		document.getElementById("formulario").style.visibility = "hidden";
   		document.getElementById("captionBI").style.visibility = "hidden";
   		document.getElementById("novo").style.visibility = "visible";
   		cinza();
	}

	function executa(acao){
		document.cadBoletim.executar.value = acao;
		if (document.cadBoletim.data_normal.value == ""){
			window.alert("Informe a data de publicação do Boletim!");
			return;
		}
		if (acao == "Excluir")  {
			if (!window.confirm("Deseja realmente excluir o Boletim selecionado?")){
				return ;
			}
		}
		document.cadBoletim.action = "cadboletim.php?codTipoBol="+document.cadBoletim.seleTipoBol.value;
		document.cadBoletim.submit();
	}

	function carregaedit(cod_assinabi,cod,numero_bi,data_pub,bi_ref,e_adt,acao,IDT) {
		cinza();
		document.cadBoletim.numero_bi.readOnly = true;
		document.getElementById(IDT).style.background = "#DDEDFF";
		document.cadBoletim.numero_bi.value = numero_bi;
		document.cadBoletim.cod.value = cod;
		document.cadBoletim.data_normal.value = data_pub;
		var dia = data_pub.substring(0,2);
		var mes = data_pub.substring(3,5);
		var ano = data_pub.substring(6,10);
		document.cadBoletim.data_pub.value = ano + '-' + mes + '-' + dia;
   		document.cadBoletim.bi_ref.value  = bi_ref;
   		document.cadBoletim.acao.value = acao;
   		document.getElementById("formulario").style.visibility = "visible";
   		document.getElementById("captionBI").style.visibility = "visible";
		if (e_adt != 'S') document.getElementById("captionRefBi").style.visibility = "hidden";
   		document.getElementById("novo").style.visibility = "hidden";
   		document.getElementById("tituloForm").innerHTML = acao;
		url="ajax_assinabi.php?codassinabi="+cod_assinabi;
		// Talvez futuramente tenhamos que tratar a questão de mudar os militares que assinam e conferem o BI
		//ajax(url,"militarAssina");
	}

	function tipoBol(){
		window.location.href = "cadboletim.php?codTipoBol="+document.cadBoletim.seleTipoBol.value;
	}
	function visualizar(codBol){
		document.getElementById('mensagem').style.visibility = "visible";
		document.getElementById('divBoletim').innerHTML = "<font color='blue'>&nbsp;&nbsp;Espere, gerando Boletim...<\/font>";
		//alterado para gerar o original - rv06
//		url = 'ajax_boletim.php?codBol='+codBol+'&original=N';
		url = 'ajax_boletim.php?codBol='+codBol+'&original=S';
		ajaxCadMilitar(url,"divBoletim");
	}
	function atualizaTela(resposta){
		document.getElementById('mensagem').style.visibility = "hidden";
		document.getElementById('divBoletim').innerHTML = "";
		viewPDF2(resposta);;
	}
	</script>
</head>
<body><center>
	<? 	$apresentacao->chamaCabec();
		$apresentacao->montaMenu();
		if ($_SESSION['NOMEUSUARIO'] == 'supervisor'){
			//monta a coleção com todos os tipos de boletim cadastrados
			$colTipoBol = $fachadaSist2->lerColecaoTipoBol('descricao');
		}else{
			//monta a coleção dos tipos de boletim autorizados para o usuário logado e para a função de consultar bi
		    $colTipoBol = $fachadaSist2->lerColecaoAutorizadaTipoBol($_SESSION['NOMEUSUARIO'], 3004);
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
	?>


	<h3 class="titulo">&nbsp;&nbsp;<img src="./imagens/item_dir.gif" alt="">&nbsp;Cadastro de Boletim (Não Aprovados)</h3>
	<form  method="post" name="cadBoletim" action="">
	<p>Tipo de Boletim:&nbsp;

	<? 	$apresentacao->montaCombo('seleTipoBol',$colTipoBol,'getCodigo','getDescricao',$codTipoBolAtual,'tipoBol()');
	?>
	<table width="60%" border="0" ><tr>
	<td valign="bottom" width="3%"><div id="mensagem" class="processa" style="visibility:hidden"><img src="imagens/ajax-loader.gif" alt=""></div></td>
	<td><div id="divBoletim">&nbsp;</div></td></tr></table>
	<table width="750px" border="0" cellspacing="0"  class="lista"><tr><td>
	<table width="100%" border="0" cellspacing="1" cellpadding="0">
	<tr class="cabec">
		<td width="10%" ><div align="center"><strong><font size="2">Nr BI</font></strong></div></td>
		<td width="10%" align="center"><strong><font size="2">Data BI</font></strong></td>
		<td width="10%" align="center"><strong><font size="2">P. Inicial</font></strong></td>
		<td width="10%" align="center"><strong><font size="2">P. Final</font></strong></td>
		<td width="7%" align="center"><strong><font size="2">T. Pág</font></strong></td>
		<td width="7%" align="center"><strong><font size="2">Ação</font></strong></td>
	</tr>
	<?php
		$tipoBol = $fachadaSist2->lerTipoBol($codTipoBolAtual);
		if (isset($_POST['executar'])){
			$minhadata = new MinhaData($_POST['data_pub']);
			$tipobol = $fachadaSist2->lerTipoBol($_POST['seleTipoBol']);
			$boletim = new Boletim($minhadata,$tipobol, null, null);
			$boletim->setNumeroBi($_POST['numero_bi']);
			$boletim->setCodigo($_POST['cod']);
			$boletim->setBiRef($_POST['bi_ref']);
  			if ($_POST['executar'] == 'Incluir'){
				$fachadaSist2->incluirBoletim($boletim);
			}
			if ($_POST['executar'] == 'Excluir'){
				$fachadaSist2->excluirBoletim($boletim);
			}
			if ($_POST['executar'] == 'Alterar'){
				$boletim->setNumeroBi($_POST['numero_bi']);
				$boletim->setCodigo($_POST['cod']);
				$boletim->setBiRef($_POST['bi_ref']);
				$boletim2 = $fachadaSist2->lerBoletimPorCodigo($boletim->getCodigo());
				$boletim2->setDataPub($boletim->getDataPub());
				$boletim2->setBiRef($_POST['bi_ref']);
			/*	$boletim->setPagInicial($boletim2->getPagInicial);
				$boletim->setPagFinal($boletim2->getPagFinal);
				$boletim->setAssinado($boletim2->getAssinado);
				$boletim->setAprovado($boletim2->getAprovado);
				$boletim->setPessoaAssina($boletim2->getPessoaAssina);
				$boletim->setPessoaConfere($boletim2->getPessoaConfere);
				$boletim->setAprovado($boletim2->getAprovado);*/
				$fachadaSist2->alterarBoletim($boletim2);
			}
  		}
//  		echo $codTipoBolAtual;
  		$colBoletim2 = $fachadaSist2->lerColecaoBi('N','N',$codTipoBolAtual,'');
  		$boletim = $colBoletim2->iniciaBusca1();
		$ord = 0;
  		while ($boletim != null){
			$ord++;
			echo '<tr id='.$ord.' onMouseOut="outLinha('.$ord.')" onMouseOver="overLinha('.$ord.')" bgcolor="#F5F5F5">
				<td align="center">'.$boletim->getNumeroBi().'</td><td align="center">'.$boletim->getDataPub()->GetcDataDDBMMBYYYY().'</td>
				<td align="center">'.$boletim->getPagInicial().'</td><td align="center">'.$boletim->getPagFinal().'</td>
				<td align="center">'.($boletim->getPagFinal() - $boletim->getPagInicial() + 1).'</td>
				<td align="center">';
			//verifica permissao para alterar
   	        if ($_SESSION['NOMEUSUARIO'] != 'supervisor')
       	    { $mAlterar = $fachadaSist2->lerUsuarioFuncaoCodTipoBol($_SESSION['NOMEUSUARIO'],3002,$codTipoBolAtual);
           	}
           	//print_r($boletim->getAssinaConfereBi()->getCodigo());
            if (($mAlterar != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor'))
		    { echo '<a href="javascript:carregaedit('.$boletim->getAssinaConfereBi()->getCodigo().','
						.$boletim->getCodigo().','.$boletim->getNumeroBi().',\''
				        .$boletim->getDataPub()->GetcDataDDBMMBYYYY().'\',\''.$boletim->getBiRef().'\',\''
						.$tipoBol->getE_Aditamento().'\',\'Alterar\','.$ord
						.')"><img src="./imagens/alterar.png" alt=""  border=0 title="Alterar"><FONT COLOR="#000000"></FONT></a>';
		    }
            //verifica permissao para excluir
            if ($_SESSION['NOMEUSUARIO'] != 'supervisor')
            { $mExcluir = $fachadaSist2->lerUsuarioFuncaoCodTipoBol($_SESSION['NOMEUSUARIO'],3003,$codTipoBolAtual);
            }
            if (($mExcluir != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor'))
            { if (($mAlterar != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor'))
			  { echo '&nbsp;|&nbsp';}
			  echo '<a href="javascript:carregaedit('.$boletim->getAssinaConfereBi()->getCodigo().','
			  				 .$boletim->getCodigo().','.$boletim->getNumeroBi().',\''
				        .$boletim->getDataPub()->GetcDataDDBMMBYYYY().'\',\''.$boletim->getBiRef().'\',\''
						.$tipoBol->getE_Aditamento().'\',\'Excluir\','.$ord
						.')"><img src="./imagens/excluir.png" border=0 title="Excluir" alt=""><FONT COLOR="#000000"></FONT></a>';
            }
            echo '&nbsp;|&nbsp;';
			echo '<a href="javascript:visualizar('.$boletim->getCodigo().')"><img src="./imagens/buscar.gif" alt="" title="Visualizar Boletim" border=0></a>';
			echo '</td></tr>';
    		$boletim = $colBoletim2->getProximo1();
  		}
		?>
  		</table></td></tr>
	</table>
	<table width="60%" border="0" >
        <TR><TD align="right" valign="middle">Legenda:&nbsp;&nbsp;
        <img src="./imagens/alterar.png" title="Alterar" border=0 alt="">&nbsp;Alterar Data&nbsp;
        <img src="./imagens/excluir.png" title="Alterar" border=0 alt="">&nbsp;Excluir Boletim&nbsp;
        <img src="./imagens/buscar.gif" title="Visualizar Boletim" border=0 alt="">&nbsp;Visualizar Boletim
	    </TD></TR>
	</TABLE>
	
     <?
        //verifica permissao para inclusão
        if ($_SESSION['NOMEUSUARIO'] != 'supervisor') {
            $mIncluir = $fachadaSist2->lerUsuarioFuncaoCodTipoBol($_SESSION['NOMEUSUARIO'], 3001, $codTipoBolAtual);
        }
        if (($mIncluir != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor')) {
            echo '<table width="60%" border="0" >';
            echo '<TR><TD><a href="javascript:novo(\'' . $tipoBol->getE_Aditamento() . '\')" id="novo">';
            echo '<img src="./imagens/add.png" border=0 alt="">&nbsp;<FONT COLOR="#0080C0">Adicionar</FONT></a></TD>';
            echo '</TR></TABLE>';
        }
        ?>

	<script type="text/javascript">javascript:tot_linhas(<?=$ord?>)</script>

		<input name="executar" type="hidden" value="">
		<input name="cod" type="hidden" value="">
		<input name="data_pub" type="hidden" value="">
		<div id="formulario" STYLE="VISIBILITY:hidden">
		<TABLE class="formulario" bgcolor="#0000FF" CELLPADDING="1" ><TR><TD>
			<TABLE border="0" width="380" CELLSPACING="0" CELLPADDING="0" style="name:tabela;">
			<TR CLASS="cabec"><TD><div id="tituloForm"><font size="2"></font></div></TD></TR>

		<TR>
			<TD BGCOLOR="#C0C0C0" >
			<div id="captionBI">&nbsp;N&uacute;mero do Bol:&nbsp;<input name="numero_bi" type="text" size="3" maxlength="3" id="nrbi"></div>			</TD>
		</TR>

		<TR>
			<TD BGCOLOR="#C0C0C0" >
			<br>&nbsp;Data de Publicação(dd/mm/aaaa): <input name="data_normal" type="text" size="15" maxlength="10" onBlur="validarData(this)"><br><br>			</TD>
		</TR>
		<TR>
			<TD BGCOLOR="#C0C0C0" >
			<div id="captionRefBi">&nbsp;Boletim de Referência: <input name="bi_ref" type="text" size="40" maxlength="40"><br><br></div>			</TD>
		</TR>
		<?/*if ($tipoBol->getE_Aditamento() == 'S'){
			echo '<TR>';
			echo '<TD BGCOLOR="#C0C0C0" >';
			echo '&nbsp;Boletim de Referência: <input name="bi_ref" type="text" size="40" maxlength="40"><br><br>';
			echo '</TD>';
			echo '</TR>';
		  }*/
		?>
		<TR>
			<TD BGCOLOR="#C0C0C0" >
			<div id="militarAssina"></div>			</TD>
		</TR>
		<TR>
			<TD BGCOLOR="#C0C0C0" align="right">
			<input name="acao" type="button" value="Incluir" onClick="executa(this.value)">
			<input name="cancela" type="button" value="Cancelar" onClick="cancelar()"><TD>
		</TR></table>
		</TD></TR></TABLE>
		<TABLE><TR><TD>
		<BR><B>OBSERVAÇÕES:</B>
		<BR>(1) O nº do BI será o nº do BI Anterior cadastrado na tela de Tipo de Boletim acrescido de 1;
		<BR>(2) O nº da página do BI será:
		<BR>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(a) O nº da última página do BI anterior acrescido de 1 <B>(CASO TENHA O BI ANTERIOR)</B>;
		<BR>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(b) O nº da última página cadastrado na tela de Tipo de Boletim acrescido de 1 <B>(CASO NÃO TENHA O BI ANTERIOR OU SEJA O 1º BI)</B>;
		<BR>(3) O BI gerado por padrão é o Original. Caso seja necessário, pode-se gerar o BI com o Confere com o Original na tela Regerar Boletim;
		<BR>(4) Na tela de Cadastro do Tipo de Boletim é possível ativar a opção para gerar o BI com uma borda simples.
		</TD></TR></TABLE>
		</div>
	</form>
</center>
</body>
</html>
