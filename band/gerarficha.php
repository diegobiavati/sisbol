<? 	session_start(); 
	require_once('filelist_geral.php');
	require_once('filelist_pgrad.php');
	require_once('filelist_militar.php');
	require_once('filelist_qm.php');
	require_once('filelist_funcao.php');
	require_once('filelist_om.php');
	require_once('filelist_controladoras.php');
	require_once('filelist_temposerper.php');
	require_once('./classes/fpdf/fpdf.php');
	require_once('./classes/meupdffic/meupdffic.php');
	$fachadaSist2 = new FachadaSist2();
    $funcoesPermitidas = $fachadaSist2->lerColecaoAutorizada($_SESSION['NOMEUSUARIO'],'X');	
	$apresentacao = new Apresentacao($funcoesPermitidas);
	
	if (isset($_POST['executar'])){
		if (isset($_POST['vetor'])) {
			$colMilitar2 = new ColMilitar2();
			/* Laço que cria a coleção de militares que terão suas alterações geradas */
			foreach ($_POST['vetor'] as $IdMilitar) {
				$militar = $fachadaSist2->lerMilitar($IdMilitar);
				$colMilitar2->incluirRegistro($militar);
			}
			/* Gera as alterações passando a coleção de militares, data inicial e data final */
			$arq = $fachadaSist2->gerarFicha($colMilitar2);
		} else {
			/* Exibe uma msg de alerta caso o usário mande gerar alterações sem selecionar um militar */
			echo ('<script> window.alert(\'Selecione pelo menos 1 militar!!!\')</script>');
		}
	}
	
	$item = 0;
	$intervalo = 0;
	if(isset($_GET['item'])){
		$item = $_GET['item'];
	}
	$intervalo = $item + 20; 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SisBol</title>
<? $apresentacao->chamaEstilo(); ?>
<script type="text/javascript" src="scripts/band.js"></script>
<script type="text/javascript">
	var janelaPDF;
	function gerarFic(){
		document.geraFic.executar.value = "acao";
		document.geraFic.action = "gerarficha.php?codpgrad="+document.geraFic.selePGrad.value+
									"&item=<?=$item?>";
		document.geraFic.submit();
	}
	
	function seleMilPGrad(){
		window.location.href="gerarficha.php?codpgrad="+document.geraFic.selePGrad.value;
	}
	</script>
</head>
<body>
<a name="topo"></a>
<center>
  <? 	$apresentacao->chamaCabec();
		$apresentacao->montaMenu();
	?>
  <h3 class="titulo">&nbsp;&nbsp;<img src="./imagens/item_dir.gif" alt="">&nbsp;Gerar Ficha de Identificação</h3>
  <form  method="post" name="geraFic" action="">
    <table width="70%" border="0" cellspacing="0" cellppading="0">
      <tr>
        <td align="right"><?php
  		/*Listar os Postos e Graduações*/
  		$colPGrad2 = $fachadaSist2->lerColecaoPGrad('cod');
  		$pGrad = $colPGrad2->iniciaBusca1();
  		
  		/* Se estiver setado um posto/graduação*/
  		if(isset($_GET['codpgrad'])){
			$codpgrad = $_GET['codpgrad'];
		} else {
			$codpgrad = $pGrad->getCodigo();	
		}
		$location = "gerarficha.php?codpgrad=".$codpgrad;
  		echo 'Listar por: ';
  		$apresentacao->montaCombo('selePGrad',$colPGrad2,'getCodigo','getDescricao',
  									$codpgrad,'seleMilPGrad()');  	
  		$colMilitar2 = $fachadaSist2->lerColecaoMilitar("m.antiguidade, p.nome",
  			"and p.perm_pub_bi = 'S' and m.pgrad_cod = '".$codpgrad."'");
  		$Militar = $colMilitar2->iniciaBusca1();
		
  		$total = $colMilitar2->getQTD();
		
		echo '<br><br>';
		// Implementa a paginação caso a listagem tenha mais que 50 ítens
		if ($total > 20){
			echo "&nbsp;&nbsp;&nbsp;";
			$apresentacao->montaComboPag($total,$item,$selected,$location);
		}							
	?>
        </TD>
      </TR>
    </table>
    <table width="850px" border="0" cellspacing="0" cellppading="0" class="lista">
      <tr>
        <td><table width="100%" border="0" cellspacing="1" cellpadding="0">
            <tr class="cabec">
              <td width="5%"><div align="center"><strong><font size="2">Ord</font></strong></div></td>
              <td width="10%" align="center"><strong><font size="2">P/Grad</font></strong></td>
              <td width="65%" align="center"><strong><font size="2">Nome</font></strong></td>
              <td width="10%"><div align="center"><strong><font size="2">Gerar</font></strong></div></td>
            </tr>
            <?
  		$ord = 0;
		$items_lidos = 0;
		
  		while ($Militar != null){
  			if($codpgrad === $Militar->getPGrad()->getCodigo()){
				$ord++;
				if ($ord > $item){
					$pGrad = $fachadaSist2->lerPGrad($Militar->getPGrad()->getCodigo());
					echo '<tr id='.$ord.' onMouseOut="outLinha('.$ord.')" 
							onMouseOver="overLinha('.$ord.')" bgcolor="#F5F5F5">
							<td align="center">'.$ord.'</TD>';
					echo '<TD align=center>'.$pGrad->getDescricao().'</TD>';
					echo '<TD>'
					  .$apresentacao->setaNomeGuerra($Militar->getNome(),$Militar->getNomeGuerra()).'</TD>';
					echo '<td align="center"><input type="checkbox" name="vetor[]" 
					      value="'.$Militar->getIdMilitar().'"></td>';
						echo '</TR>';
				}
  			}			
	   		$Militar = $colMilitar2->getProximo1();
    		$items_lidos++;
    		if($items_lidos >= $intervalo){
    			break;
    		}
  		}
		?>
          </table></td>
      </tr>
    </table>
    <table width="850px" border="0" >
      <TR>
        <td width="50%" align="right">&nbsp;&nbsp; </td>
        <td width="35%" align="right"><a href="javascript:marcaTudo(document.geraFic,true)">Marca Tudo</a>&nbsp;/&nbsp; <a href="javascript:marcaTudo(document.geraFic,false)">Desmarca Tudo</a> </td>
        <td width="2%" align="left"><img src="./imagens/seta.png" border="0" alt=""> </td>
        <td width="10%" align="right"><input name="desaprovar" type="button" value="Gerar" onClick="javascript:gerarFic('true')">
        </td>
      </TR>
    </TABLE>
    <input name="executar" type="hidden" value="">
  </form>
  <?
	if (isset($_POST['executar'])){
		/*echo '<script>window.alert("Boletim gerado com sucesso!");</script>';*/
		if($arq !== 'error') echo '<script type="text/javascript">javascript:viewPDF2("'.$arq.'");</script>';
		
	}
	?>
</center>
</body>
</html>
