<? 	session_start();
	require_once('./filelist_geral.php');
	require_once('./filelist_boletim.php');
	require_once('./filelist_controladoras.php');
	require_once('./filelist_militar.php');
	require_once('./filelist_pgrad.php');
	require_once('./filelist_qm.php');
	require_once('./filelist_om.php');
	require_once('./filelist_funcao.php');
	require_once('./filelist_tipodoc.php');
	require_once('./filelist_pdf.php');
	require_once('./filelist_usuariofuncaotipobol.php');

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SisBol</title>
<script type="text/javascript" src="scripts/band.js"></script>
<?
	$fachadaSist2 = new FachadaSist2();
    $funcoesPermitidas = $fachadaSist2->lerColecaoAutorizada($_SESSION['NOMEUSUARIO'], 'X');
	$apresentacao = new Apresentacao($funcoesPermitidas);
	if (isset($_POST['executar'])){
		$boletim = $fachadaSist2->lerBoletimPorCodigo($_POST['cod']);
		//a chamada para o código que gera o PDF deve estar no início do código PHP
		//alterado na rev 06 - foi invertido para gerar por padrao o original
		if (isset($_POST['original'])) {
			$original = 'N';
		} else {
			$original = 'S';
		}
		$Tipo_Bol = $_GET['TipoBol'];
		$arq = $fachadaSist2->gerarBoletim($boletim,$original);
	}
	$apresentacao->chamaEstilo();

	if (isset($_GET['ano'])){
		$anoAtual = trim($_GET['ano']);
	} else {
		$anoAtual = date('Y');
	}
?>
<script type="text/javascript">
	var janelaPDF;
	function gerarboletim(codbol){
		if (!window.confirm("Deseja realmente gerar o Boletim selecionado?")){
			return ;
		}
		var item = document.gerarbi.seleTipoBol.value;
		var tipoBol = document.gerarbi.seleTipoBol.options[document.gerarbi.seleTipoBol.selectedIndex].text;
		document.gerarbi.cod.value = codbol;
		document.gerarbi.executar.value = "gera";
		document.gerarbi.action = "publiquese.php?codTipoBol="+item+'&TipoBol='+tipoBol;
		document.gerarbi.submit();
	}
	function tipoBol(){
		window.location.href = "publiquese.php?codTipoBol="+document.gerarbi.seleTipoBol.value;

	}
	function baixarboletim(codbol){
		if (!window.confirm("Deseja realmente baixar o Boletim selecionado?")){
			return ;
		}
		var item = document.gerarbi.seleTipoBol.value;
		var tipoBol = document.gerarbi.seleTipoBol.options[document.gerarbi.seleTipoBol.selectedIndex].text;
		document.gerarbi.cod.value = codbol;
		document.gerarbi.executar.value = "gera";
		document.gerarbi.action = "down.php?filename='.$arq.'";
		document.gerarbi.submit();
	}
</script>
</head>
<body>
<center>
  <? 	$apresentacao->chamaCabec();
		$apresentacao->montaMenu();
	    if ($_SESSION['NOMEUSUARIO'] == 'supervisor'){
			$colTipoBol = $fachadaSist2->lerColecaoTipoBol('descricao');
		} else {
			$colTipoBol = $fachadaSist2->lerColecaoAutorizadaTipoBol($_SESSION['NOMEUSUARIO'], 3033);
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
  <h3 class="titulo">&nbsp;&nbsp;<img src="./imagens/item_dir.gif" alt="">&nbsp;Publique-se</h3>
  <form  method="post" name="gerarbi" action="">
    <p>Tipo de Boletim:&nbsp;
      <? 	$apresentacao->montaCombo('seleTipoBol',$colTipoBol,'getCodigo','getDescricao',$codTipoBolAtual,'tipoBol()');
	?>
    </p>
    <br>
    <br>
    <table width="750px" border="0" cellspacing="0" cellppading="0" class="lista">
      <tr>
        <td><table width="100%" border="0" cellspacing="1" cellpadding="0">
            <tr class="cabec">
              <td width="10%"><div align="center"><strong><font size="2">Nr BI</font></strong></div></td>
              <td width="15%" align="center"><strong><font size="2">Data BI</font></strong></td>
              <td width="10%" align="center"><strong><font size="2">Aprovado?</font></strong></td>
              <td width="10%" align="center"><strong><font size="2">Assinado?</font></strong></td>
              <td width="25%" align="center"><strong><font size="2">Confere c/ Original?</font></strong></td>
              <td width="5%" align="center"><strong><font size="2">Gerar</font></strong></td>
			  
            </tr>
            <?php
		$filtroBoletimAprovado = 'SN';
		$filtroBoletimAssinado = 'SN';

  		$colBoletim2 = $fachadaSist2->lerColecaoBi('S','N',$codTipoBolAtual,' desc ');
  		//$colBoletim2 = $fachadaSist2->lerColecaoBiSemPrimeiro('S','S',$codTipoBolAtual,' desc ');
  		$boletim = $colBoletim2->iniciaBusca1();
		$ord = 0;
  		while ($boletim != null){
			$ord++;
			echo '<tr id='.$ord.' onMouseOut="outLinha('.$ord.')" onMouseOver="overLinha('.$ord.')" bgcolor="#F5F5F5">
				<td align="center">'.$boletim->getNumeroBi().'</td>
				<td align="center">'.$boletim->getDataPub()->GetcDataDDBMMBYYYY().'</td>
				<td align="center">'.$apresentacao->retornaCheck($boletim->getAprovado()).'</td>
				<td align="center">'.$apresentacao->retornaCheck($boletim->getAssinado()).'</td>
				<td align="center"><input type="checkbox" name="original" value="S"></td>
				<td align="center"><a href="javascript:gerarboletim('.$boletim->getCodigo().')">
				<img src="./imagens/engrenagem.gif"  border=0 title="Visualizar Boletim"><FONT COLOR="#000000"></FONT></a>&nbsp;|&nbsp;';
				echo '<a href="javascript:baixarboletim('.$boletim->getCodigo().')"><img src="./imagens/salvar.png"  border=0 title="Baixar Boletim"><FONT COLOR="#000000"></FONT></a></td>';
    		$boletim = $colBoletim2->getProximo1();
    		if($ord == 10) break;
  		}
		?>
          </table></td>
      </tr>
    </table>
    <table width="650" border="0" cellspacing="0" >
      <tr>
        <td><font color="blue">Obs: S&atilde;o listados somente os 10 &uacute;ltimos boletins aprovados.</font> </td>
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
                <TD BGCOLOR="#C0C0C0" align="right">
              </TR>
            </table></TD>
        </TR>
      </TABLE>
    </div>
  </form>
</center>
<?
	if (isset($_POST['executar'])){
		//echo '<script>window.alert("Boletim gerado com sucesso!");</script>';
		// Exibe o arquivo
	echo '<script type="text/javascript">javascript:viewPDF2("'.$arq.'");</script>';
		// Faz download do arquivo
	//echo ('<script> window.location.href="down.php?filename='.$arq.'"; </script>');
		

	}
	?>
	
</body>
</html>
