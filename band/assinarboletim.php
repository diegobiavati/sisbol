<? 	session_start();
	require_once('./filelist_geral.php');
	require_once('./filelist_boletim.php');
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
	function assinaboletim(codBol){
		if (!window.confirm("Deseja realmente assinar o Boletim selecionado?")){
			return ;
		}
		gerarBoletim(codBol);
		document.assinarbi.cod.value = codBol;
		document.assinarbi.executar.value = "vai";
		document.assinarbi.action = "assinarboletim.php?codTipoBol="+document.assinarbi.seleTipoBol.value;
		document.assinarbi.submit();
	}
	function gerarBoletim(codBol){
		document.getElementById('mensagem').style.visibility = "visible";
		document.getElementById('divBoletim').innerHTML = "<font color='blue'>&nbsp;&nbsp;Espere, gerando Boletim...<\/font>";
		//alterado para gerar o original - rv 06
//		url = 'ajax_boletim.php?codBol='+codBol+'&original=N';
		url = 'ajax_boletim.php?codBol='+codBol+'&original=S';
		ajaxCadMilitar(url,"divBoletim");
	}
	function tipoBol(){
		window.location.href = "assinarboletim.php?codTipoBol="+document.assinarbi.seleTipoBol.value;
	}
	function visualizar(codBol){
		document.getElementById('mensagem').style.visibility = "visible";
		document.getElementById('divBoletim').innerHTML = "<font color='blue'>&nbsp;&nbsp;Espere, gerando Boletim...<\/font>";
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
<body>
<center>
  <? 	$apresentacao->chamaCabec();
		$apresentacao->montaMenu();
	?>
  <? 	//$colTipoBol = $fachadaSist2->lerColecaoTipoBol('descricao');
	    if ($_SESSION['NOMEUSUARIO'] == 'supervisor')
	 	{ $colTipoBol = $fachadaSist2->lerColecaoTipoBol('descricao');
		}
		else
	    { $colTipoBol = $fachadaSist2->lerColecaoAutorizadaTipoBol($_SESSION['NOMEUSUARIO'], 3021);
	    }
		if (isset($_GET['codTipoBol'])){
			$codTipoBolAtual = $_GET['codTipoBol'];
		}else {
			$obj = $colTipoBol->iniciaBusca1();

			if (!is_null($obj)){
				$codTipoBolAtual = 'Todos';
				//$codTipoBolAtual = $obj->getCodigo();
			} else {
				$codTipoBolAtual = 0;
			}
		}
	?>
  <h3 class="titulo">&nbsp;&nbsp;<img src="./imagens/item_dir.gif" alt="">&nbsp;Assinar Boletim</h3>
  <form  method="post" name="assinarbi" action="">
    <p>Tipo de Boletim:&nbsp;
      <? 	$apresentacao->montaCombo('seleTipoBol',$colTipoBol,'getCodigo','getDescricao',$codTipoBolAtual,'tipoBol()','Todos');
	?>
    <table width="60%" border="0" >
      <tr>
        <td valign="bottom" width="3%"><div id="mensagem" class="processa" style="visibility:hidden"><img src="imagens/ajax-loader.gif" alt=""></div></td>
        <td><div id="divBoletim">&nbsp;</div></td>
      </tr>
    </table>
    <table width="750px" border="0" cellspacing="0"  class="lista">
      <tr>
        <td><table width="100%" border="0" cellspacing="1" cellpadding="0">
            <tr class="cabec">
              <td width="20%" ><div align="center"><strong><font size="2">Tipo</font></strong></div></td>
              <td width="10%" ><div align="center"><strong><font size="2">Nr BI</font></strong></div></td>
              <td width="10%" align="center"><strong><font size="2">Data BI</font></strong></td>
              <td width="10%" align="center"><strong><font size="2">P. Inicial</font></strong></td>
              <td width="10%" align="center"><strong><font size="2">P. Final</font></strong></td>
              <td width="7%" align="center"><strong><font size="2">T. Pág</font></strong></td>
              <td width="7%" align="center"><strong><font size="2">Ação</font></strong></td>
            </tr>
            <?php
		if (isset($_POST['executar'])){
			$boletim = $fachadaSist2->lerBoletimPorCodigo($_POST['cod']);
			$fachadaSist2->assinarBoletim($boletim);
  		}
		//verifica se o nivel de aprovacao para BI esta ou nao Ativado  		
  		if ($_SESSION['APROVBOLETIM']=='S')
  			$filtroBoletimAprovado = 'S';
  		else
  			$filtroBoletimAprovado = 'N';

  		$colBoletim2 = $fachadaSist2->lerColecaoBi($filtroBoletimAprovado,'N',$codTipoBolAtual,'');
  		$boletim = $colBoletim2->iniciaBusca1();
		$ord = 0;

		while ($boletim != null){
			$ord++;
			echo '<tr id='.$ord.' onMouseOut="outLinha('.$ord.')" onMouseOver="overLinha('.$ord.')" bgcolor="#F5F5F5">
				<td align="left">'.$boletim->getTipoBol()->getDescricao().'</td>
				<td align="center">'.$boletim->getNumeroBi().'</td>
				<td align="center">'.$boletim->getDataPub()->GetcDataDDBMMBYYYY().'</td>
				<td align="center">'.$boletim->getPagInicial().'</td>
				<td align="center">'.$boletim->getPagFinal().'</td>
				<td align="center">'.($boletim->getPagFinal() - $boletim->getPagInicial() + 1).'</td>
				<td align="center">
				<a href="javascript:assinaboletim('.$boletim->getCodigo().')">
				<img src="./imagens/assinatura.png"  border=0 title="Assinar" alt=""><FONT COLOR="#000000"></FONT></a>';
			echo '&nbsp;|&nbsp;';
			echo '<a href="javascript:visualizar('.$boletim->getCodigo().')"><img src="./imagens/buscar.gif" title="Visualizar Boletim Original" border=0 alt=""></a>';
    		$boletim = $colBoletim2->getProximo1();
  		}
		?>
          </table></td>
      </tr>
    </table>
    <table width="60%" border="0" >
      <TR>
        <TD align="right" valign="middle">Legenda:&nbsp;&nbsp; <img src="./imagens/assinatura.png" alt="" width="12" height="12" border=0 title="Alterar">&nbsp;Assinar&nbsp; <img src="./imagens/buscar.gif" title="Visualizar Boletim" border=0 alt="">&nbsp;Visualizar Boletim </TD>
      </TR>
    </TABLE>
    <table width="60%" border="0" cellspacing="0" cellppading="0">
      <tr>
        <td>
		</td>
      </tr>
      
    </table>
    <script type="text/javascript">javascript:tot_linhas(<?=$ord?>)</script>
    <input name="executar" type="hidden" value="">
    <input name="cod" type="hidden" value="">
    <div id="formulario" STYLE="VISIBILITY:hidden">
      <TABLE bgcolor="#0000FF" CELLPADDING="1" >
        <TR>
          <TD><TABLE border=0 CELLSPACING="0" CELLPADDING="0" style="name:tabela;">
              <TR CLASS="cabec">
                <TD>
                  <div id="tituloForm"><font size="2"></font></div>
                  </TD>
              </TR>
              <TR>
                <TD BGCOLOR="#C0C0C0" align="right">
              </TR>
            </table></TD>
        </TR>
      </TABLE>
    </div>
  </form>
</center>
</body>
</html>
