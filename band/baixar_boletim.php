<? 	session_start();
	require_once('filelist_geral.php');
	require_once('filelist_boletim.php');
	require_once('./filelist_usuariofuncaotipobol.php');
	$fachadaSist2 = new FachadaSist2();
    $funcoesPermitidas = $fachadaSist2->lerColecaoAutorizada($_SESSION['NOMEUSUARIO'], 'X');
	$apresentacao = new Apresentacao($funcoesPermitidas);
/*	if ($_SESSION['NOMEUSUARIO'] == 'supervisor'){
		//monta a coleção com todos os tipos de boletim cadastrados
		$colTipoBol = $fachadaSist2->lerColecaoTipoBol('descricao');
	}else{
		//monta a coleção dos tipos de boletim autorizados para o usuário logado e para a função de consultar bi
	    $colTipoBol = $fachadaSist2->lerColecaoAutorizadaTipoBol($_SESSION['NOMEUSUARIO'], 3004);
	}*/
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
<HEAD>
<TITLE>Baixar de Boletim</TITLE>
<script type="text/javascript" src="scripts/band.js"></script>
<script type="text/javascript">
	var janelaPDF;
	function tipoBol(){
		window.location.href = "baixar_boletim.php?codTipoBol="+document.listaBi.seleTipoBol.value+
								"&ano=" + document.listaBi.anos.value + "&mes=" + document.listaBi.mes.value;;
	}

	</script>
</HEAD>
<BODY>
<center>
  <?
	$apresentacao->chamaEstilo();
	$apresentacao->chamaCabec();
	$apresentacao->montaMenu();
	$path = 'boletim';
	//rv 05 - mostra apenas os boletins do tipo de boletim selecionado
	if ($_SESSION['NOMEUSUARIO'] == 'supervisor'){
		//monta a coleção com todos os tipos de boletim cadastrados
		$colTipoBol = $fachadaSist2->lerColecaoTipoBol('descricao');
	}else{
		//monta a coleção dos tipos de boletim autorizados para o usuário logado e para a função de consultar bi
	    $colTipoBol = $fachadaSist2->lerColecaoAutorizadaTipoBol($_SESSION['NOMEUSUARIO'], 3030);
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
	$tipoBol = $fachadaSist2->lerTipoBol($codTipoBolAtual);

?>
  <h3 class="titulo">&nbsp;&nbsp;<img src="./imagens/item_dir.gif" alt="">&nbsp;Baixar Boletim Gerado</h3>
  <form method="post" name="listaBi" action="">
    <!-- rv 05 - mostra apenas os boletins do tipo de boletim selecionado-->
    Tipo de Boletim:&nbsp;
    <? 	$apresentacao->montaCombo('seleTipoBol',$colTipoBol,'getCodigo','getDescricao',$codTipoBolAtual,'tipoBol()');
?>
    <br>
    <br>
    Ano:&nbsp;
    <?	$anoAtual = isset($_GET['ano'])?$_GET['ano']:date('Y');
	$mesAtual = isset($_GET['mes'])?$_GET['mes']:date('m');

	$colBIAno = $fachadaSist2->getAnosBI();
	$apresentacao->montaComboAnoBI('anos',$colBIAno,$anoAtual,'tipoBol()');
	echo '&nbsp;&nbsp;&nbsp;Mês:&nbsp;';
	$apresentacao->montaComboMes('mes',$mesAtual,'tipoBol()');
?>
  </form>
  <br>
  <table width="750px" border="0" cellspacing="0" class="lista">
    <tr>
      <td><table width="100%" border="0" cellspacing="1" cellpadding="0">
          <tr class="cabec">
            <td width="12%"><div align="center"><strong><font size="2">Ordem</font></strong></div></td>
            <td width="50%" align="center"><strong><font size="2">Nome do Arquivo</font></strong></td>
            <td width="18%" align="center"><strong><font size="2">Tamanho</font></strong></td>
            <td width="10%" align="center"><strong><font size="2">A&ccedil;&atilde;o</font></strong></td>
          </tr>
          <?
	if ($codTipoBolAtual!=0){
		$arquivos = scandir($path);
//		print_r($arquivos);
		$contador = 0;
		$ord = 0;
		$contador = count($arquivos);
		while ($contador >= 0) {
			$tamTipoBol = count_chars($arquivos[$contador], 0);
			if (substr($arquivos[$contador],0,4) == $anoAtual) {
/*				if(!strripos($arquivos[$contador], ereg_replace(' ','_',strtolower($tipoBol->getDescricao())))){
					$contador--;
					continue;
				}*/
				//rv 05 - mostra apenas os boletins do tipo de boletim selecionado
				//rv 06
		    	$tipoBi = strtolower(strtr($tipoBol->getDescricao(),'áéíóúãõâêôçäëïöüÁÉÍÓÚÃÕÂÊÔÇÄËÏÖÜ','aeiouaoaeocaeiouAEIOUAOAEOCAEIOU'));
				
				/*
				Ten S.Lopes -- 26/03/2012 -- código anterior = 
				$tipoBi = ereg_replace('ª','',$tipoBi);
				$tipoBi = ereg_replace('º','',$tipoBi);
				$tipoBi = ereg_replace(' ','_',$tipoBi);
				Função ereg_replace Depreciada no PHP 5.3
				*/

				$tipoBi = str_replace('ª','',$tipoBi);
				$tipoBi = str_replace('º','',$tipoBi);
				$tipoBi = str_replace(' ','_',$tipoBi);
				
//				if (substr($arquivos[$contador],17) != ereg_replace(' ','_',strtolower($tipoBol->getDescricao())).'.pdf'){
				if (substr($arquivos[$contador],17) != $tipoBi.'.pdf'){
					$contador--;
					continue;
				}
				if (intval(substr($arquivos[$contador],5,2)) == $mesAtual) {
					$ord++;
					$valor = $arquivos[$contador];
					$caminho = $path.'/'.$valor;
					$tamanho = sprintf("%u", filesize($path.'/'.$valor));
					$tamanho = round($tamanho/1024);
					echo '<tr id='.$ord.' onMouseOut="outLinha('.$ord.')" onMouseOver="overLinha('.$ord.')" bgcolor="#F5F5F5">
	    	 		      <td align="center">'.$ord.'</td>
		    			  <td align="left">'.$valor.'</td>
		    			  <td align="center">'.$tamanho.' Kb</td>
			    		  <td align="center"><a href="javascript:viewPDF2(\''.$caminho.'\')">
					    		<img src="./imagens/buscar.gif" border=0 title="Visualizar boletim" alt=""></a>&nbsp;|&nbsp;';
					echo '<a href="down.php?filename='.$caminho.'"><img src="./imagens/salvar.png" border=0 title="Realizar download" alt=""></a></td>';
				}
			}//fim do if
			$contador--;
		}//fim do while
	}
	?>
        </table></td>
    </tr>
  </table>  
</center>
</BODY>
</HTML>
