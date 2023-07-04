<? 	session_start();
	require_once('./filelist_geral.php');
	require_once('./filelist_pgrad.php');
	require_once('./filelist_militar.php');
	require_once('./filelist_boletim.php');
	require_once('./filelist_om.php');
	require_once('./filelist_controladoras.php');
	require_once('./filelist_indice.php');
	require_once('./filelist_usuariofuncaotipobol.php');
	require_once('./classes/fpdf/fpdf.php');
	require_once('./classes/meupdfind/meupdfind.php');
	$fachadaSist2 = new FachadaSist2();
    $funcoesPermitidas = $fachadaSist2->lerColecaoAutorizada($_SESSION['NOMEUSUARIO'], 'X');
	$apresentacao = new Apresentacao($funcoesPermitidas);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Gerar Índice</title>
<?
	$apresentacao->chamaEstilo();
	?>
<script type="text/javascript" src="scripts/band.js"></script>
<script type="text/javascript">
	var janelaPDF;
	function gerarIndice(acao){
		if (!window.confirm("Deseja realmente gerar o Índice para o Tipo de Boletim selecionado?")){
			return ;
		}
		document.geraindice.executar.value = acao;
		document.geraindice.action = "gerarindice.php?codTipoBol="+document.geraindice.seleTipoBol.value;
		document.geraindice.submit();
	}
	function tipoBol(){
		window.location.href = "gerarindice.php?codTipoBol="+document.geraindice.seleTipoBol.value;
		document.geraindice.seleTipoBol.focus;
	}
	</script>
</head>
<body>
<center>
  <?
	$apresentacao->chamaCabec();
	$apresentacao->montaMenu();
    if ($_SESSION['NOMEUSUARIO'] == 'supervisor') {
		$colTipoBol = $fachadaSist2->lerColecaoTipoBol('descricao');
	}
	else {
		$colTipoBol = $fachadaSist2->lerColecaoAutorizadaTipoBol($_SESSION['NOMEUSUARIO'], 3032);
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
  <h3 class="titulo">&nbsp;&nbsp;<img src="./imagens/item_dir.gif" alt="">&nbsp;Gerar Índice</h3>
  <form  method="post" name="geraindice" action="indice.php">
    <br>
    <br>
    <table width="350" border="0" cellspacing="0" class="lista">
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr class="cabec">
              <td colspan="4"><font size="2" >Informe os Parâmetros</font></td>
            </tr>
            <tr  bgcolor="#F5F5F5">
              <td><br>
                &nbsp;&nbsp;Tipo de Boletim:&nbsp;
                <?
		$apresentacao->montaCombo('seleTipoBol',$colTipoBol,'getCodigo','getDescricao',$codTipoBolAtual,'tipoBol()');
		?>
                <br>
                <br>
                <input name="executar" type="hidden" value="">
                &nbsp;&nbsp;Data Inicial:&nbsp;
                <input type="text" name="dt_inicial" size="12" maxlength="10" value="01/01/<?=date("Y"); ?>" onBlur="validaData(this)">
                &nbsp;&nbsp;&nbsp;Data Final:&nbsp;
                <input type="text" name="dt_final" size="12" maxlength="10" value="<?=date("d/m/Y"); ?>" onBlur="validaData(this)">
                <br>
                <br>
                <div align="center">
                  <input type="button" name="assunto" value="Gerar Índice por Assunto" onClick="gerarIndice('assunto')">
                  &nbsp;&nbsp;&nbsp;&nbsp;
                  <input type="button" name="pessoa" value="Gerar Índice por Pessoa" onClick="gerarIndice('pessoa')">
                </div>
                <br></td>
            </tr>
          </table></td>
      </tr>
    </table>
  </form>
  <?
	if (isset($_POST['executar'])){
		/* Configura $dataInicial como um objeto do tipo MinhaData */
		$dataInicial = trim($_POST['dt_inicial']);
		$dataInicial = explode("/",$dataInicial);
		$dataInicial = $dataInicial[2]."-".$dataInicial[1].'-'.$dataInicial[0];
		$dataInicial = new MinhaData($dataInicial);
		/* Configura $dataFinal como um objeto do tipo MinhaData */
		$dataFinal = trim($_POST['dt_final']);
		$dataFinal = explode("/",$dataFinal);
		$dataFinal = $dataFinal[2]."-".$dataFinal[1].'-'.$dataFinal[0];
		$dataFinal = new MinhaData($dataFinal);
		$codTipoBol = $_GET['codTipoBol'];
		/* Chama o método da fachada que gera o índice */
		if ($_POST['executar'] == 'assunto') {
			$arq = $fachadaSist2->gerarIndice($codTipoBol,$dataInicial,$dataFinal);
		} else {
			$arq = $fachadaSist2->gerarIndicePessoa($codTipoBol,$dataInicial,$dataFinal);
		}
		echo '<script type="text/javascript">';
		echo ($arq == 'error')?'javascript:alert("Não há publicações para o índice no período considerado.")':'javascript:viewPDF2("'.$arq.'")';
		echo '</script>';
	}
?>
</center>
</body>
</html>
