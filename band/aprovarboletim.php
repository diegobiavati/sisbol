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
	function acao(codBol,acao){
		if (!window.confirm("Deseja realmente "+acao+" o Boletim selecionado?")){
			return ;
		}
		document.aprovarbi.cod.value = codBol;
		document.aprovarbi.executar.value = acao;
		if(acao == "Aprovar"){
			gerarBoletim(codBol);
		}
		document.aprovarbi.action = "aprovarboletim.php?codTipoBol="+document.aprovarbi.seleTipoBol.value;
		document.aprovarbi.submit();
	}
	function gerarBoletim(codBol){
		document.getElementById('mensagem').style.visibility = "visible";
		document.getElementById('divBoletim').innerHTML = "<font color='blue'>&nbsp;&nbsp;Espere, gerando e aprovando Boletim...<\/font>";
		//alterado para gerar o original - rv06
//		url = 'ajax_boletim.php?codBol='+codBol+'&original=N';
		url = 'ajax_boletim.php?codBol='+codBol+'&original=S';
		ajaxCadMilitar(url,"divBoletim");
	}

	function tipoBol(){
		window.location.href = "aprovarboletim.php?codTipoBol="+document.aprovarbi.seleTipoBol.value;
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
	    { $colTipoBol = $fachadaSist2->lerColecaoAutorizadaTipoBol($_SESSION['NOMEUSUARIO'], 3011);
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
  <h3 class="titulo">&nbsp;&nbsp;<img src="./imagens/item_dir.gif" alt="">&nbsp;Aprova&ccedil;&atilde;o de Boletim</h3>
  <form  method="post" name="aprovarbi" action="">
    <p>Tipo de Boletim:&nbsp;</p>
    <?
		$apresentacao->montaCombo('seleTipoBol',$colTipoBol,'getCodigo','getDescricao',$codTipoBolAtual,'tipoBol()','Todos');
	?>
    <br>
    <br>
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
              <td width="5%" ><div align="center"><strong><font size="2">Nr BI</font></strong></div></td>
              <td width="10%" align="center"><strong><font size="2">Data BI</font></strong></td>
              <td width="10%" align="center"><strong><font size="2">P. Inicial</font></strong></td>
              <td width="10%" align="center"><strong><font size="2">P. Final</font></strong></td>
              <td width="7%" align="center"><strong><font size="2">T. Pág</font></strong></td>
              <td width="7%" align="center"><strong><font size="2">Aprovado</font></strong></td>
              <td width="7%" align="center"><strong><font size="2">Ação</font></strong></td>
            </tr>
            <?php
		if (isset($_POST['executar'])){
			$boletim = $fachadaSist2->lerBoletimPorCodigo($_POST['cod']);
			if ($_POST['executar'] == "Aprovar"){
				$fachadaSist2->aprovarBoletim($boletim);
			}
			if ($_POST['executar'] == "Cancelar"){
				$fachadaSist2->cancelarAprovarBoletim($boletim);
			}
  		}
  		$colBoletim2 = $fachadaSist2->lerColecaoBi(null,'N',$codTipoBolAtual,'');
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
				<TD align="center">'.$apresentacao->retornaCheck($boletim->getAprovado()).'</TD>
				<td align="center">';
				if($boletim->getAprovado() == 'S'){
					echo '<a href="javascript:acao('.$boletim->getCodigo().',\'Cancelar\')">
						<img src="./imagens/naprovada.png"  border=0 title="Cancelar aprovação" alt=""><FONT COLOR="#000000"></FONT></a>';
				} else {
					echo '<a href="javascript:acao('.$boletim->getCodigo().',\'Aprovar\')">
						<img src="./imagens/check.gif"  border=0 title="Aprovar" alt=""><FONT COLOR="#000000"></FONT></a>';
				}
    			echo '&nbsp;|&nbsp;';
				echo '<a href="javascript:visualizar('.$boletim->getCodigo().')"><img src="./imagens/buscar.gif" title="Visualizar Boletim" border=0 alt=""></a>';
			$boletim = $colBoletim2->getProximo1();
  		}
		?>
          </table></td>
      </tr>
    </table>
    <table width="60%" border="0" >
      <TR>
        <TD align="right" valign="middle">Legenda:&nbsp;&nbsp; <img src="./imagens/check.gif" title="Alterar" border=0 alt="">&nbsp;Aprovado <img src="./imagens/naprovada.png" title="Alterar" border=0 alt="">&nbsp;Desaprovar&nbsp; <img src="./imagens/buscar.gif" title="Visualizar Boletim" border=0 alt="">&nbsp;Visualizar Boletim </TD>
      </TR>
    </TABLE>
    <table width="60%" border="0" cellspacing="0" >
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
          <TD><TABLE border=0  CELLSPACING="0" CELLPADDING="0" style="name:tabela;">
              <TR CLASS="cabec">
                <TD><div id="tituloForm"><font size="2"></font></div></TD>
              </TR>
              <TR>
                <TD BGCOLOR="#C0C0C0" align="right"></TD>
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
