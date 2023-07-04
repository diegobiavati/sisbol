<? 	session_start(); 
	require_once('filelist_geral.php');
	require_once('filelist_pgrad.php');
	require_once('filelist_militar.php');
	require_once('filelist_qm.php');
	require_once('filelist_funcao.php');
	require_once('filelist_om.php');
	require_once('./filelist_tipodoc.php');
	require_once('filelist_temposerper.php');
	require_once('filelist_assunto.php');
	require_once('filelist_boletim.php');
	require_once('./filelist_pdf.php');
	require_once('filelist_controladoras.php');
	require_once('./classes/fpdf/meuhtml2fpdfalt.php');
	$fachadaSist2 = new FachadaSist2();
    $funcoesPermitidas = $fachadaSist2->lerColecaoAutorizada($_SESSION['NOMEUSUARIO'], 'X');	
	$apresentacao = new Apresentacao($funcoesPermitidas);
	
	// Setando as variáveis iniciais
	$intervalo 	= 0;
	//$opcao = $_GET['opcao'];
	$item 		= (isset($_GET['item']))?($_GET['item']):0;;
	$semestre 	= (isset($_GET['semestre']))?($_GET['semestre']):1;;
	$codpgrad 	= (isset($_GET['codpgrad']))?($_GET['codpgrad']):0;
	$ianoAtual 	= (isset($_GET['ianoAtual']))?$_GET['ianoAtual']:date('Y');
	$intervalo 	= $item + 20; 
	$apresentacao->montaSemestre($ianoAtual,$semestre);
	$dataInicial = $semestre==1?$ianoAtual.'-01-01':$ianoAtual.'-07-01';
	$dataFinal = $semestre==1?$ianoAtual.'-06-30':$ianoAtual.'-12-31';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SisBol</title>
<? $apresentacao->chamaEstilo(); ?>
<script type="text/javascript" src="scripts/band.js"></script>
<script type="text/javascript">
	var janelaPDF;
	function go(item){
		atualizarMilitares(false,item);
	}
	function atualizarMilitares(mudouPosto,pitem){
		var item = (mudouPosto==true)?0:pitem;
		window.location.href="geraralteracao.php?codpgrad="
			+document.geraAlt.selePGrad.value+"&ianoAtual="+document.geraAlt.ianoAtual.value+
			"&semestre="+document.geraAlt.seleSemestre.value+"&item="+item;
	}
	function atualizaTela(resposta){
		if(resposta !== ''){
			alert('A tentativa de exclusão falhou. \nO Sistema não pode excluir pessoas com publicações ou '+
					'alterações cadastradas.\n\nMensagem de erro: '+resposta);
			divPessoa.innerHTML = "";		
		} else {
			atualizarMilitares(false,<?=$item?>);	
		}					
	}
	function gerarAlt(teste){
		document.geraAlt.executar.value = "acao";
		document.geraAlt.executar2.value = teste;
		document.geraAlt.action = "geraralteracao.php?codpgrad="+document.geraAlt.selePGrad.value+
									"&ianoAtual="+document.geraAlt.ianoAtual.value+
									"&semestre="+document.geraAlt.seleSemestre.value+
									"&item=<?=$item?>";
		document.geraAlt.submit();
	}
	</script>
</head>
<body>
<a name="topo"></a>
<center>
  <? 	$apresentacao->chamaCabec();
		$apresentacao->montaMenu();
		//$apresentacao->montaFlyForm(530,200,'white',0);
	?>
  <h3 class="titulo">&nbsp;&nbsp;<img src="./imagens/item_dir.gif" alt="">&nbsp;Gerar Altera&ccedil;&otilde;es</h3>
  <form  method="post" name="geraAlt" action="">
    <input name="executar" type="hidden" value="">
    <input name="executar2" type="hidden" value="">
    <table width="850px" border="0" cellspacing="0">
      <tr>
        <td align="right"> Ano:
          <?
	$colBIAno = $fachadaSist2->getAnosBI();
	$apresentacao->montaComboAnoBI('ianoAtual',$colBIAno,$ianoAtual,'atualizarMilitares(false)');
	?>
          &nbsp;&nbsp;
          Sem:
          <select name="seleSemestre" onChange="atualizarMilitares(false)">
            <option value="1">1º</option>
            <option value="2">2º</option>
          </select>
          &nbsp;
          <?php
	  
	/*Listar os Postos e Graduações*/
  	$colPGrad2 	= $fachadaSist2->lerColecaoPGrad('cod');
  	$pGrad 		= $colPGrad2->iniciaBusca1();
  		
  	/*Listar as funções*/
  	$colFuncao2 = $fachadaSist2->lerColecaoFuncao('cod');
  	$Funcao 	= $colFuncao2->iniciaBusca1();
  		
  	/*Listar as QM*/
  	$colQM2 = $fachadaSist2->lerColecaoQM('cod');
  	$pQM 	= $colQM2->iniciaBusca1();
  		
  	echo 'Listar por: ';
  	$apresentacao->montaCombo('selePGrad',$colPGrad2,'getCodigo','getDescricao',
  								$codpgrad,'atualizarMilitares(true)');  
	echo '<p>';							
		
	?>
        </TD>
      </TR>
    </table>
    <table width="850" border="0" cellspacing="0" class="lista">
      <tr>
      <td><table width="100%" border="0" cellspacing="1" cellpadding="0">
          <tr class="cabec">
            <td width="5%" align="center"><strong><font size="2">Ord</font></strong></td>
            <td width="7%" align="center"><strong><font size="2">P/Grad</font></strong></td>
            <td width="30%" align="center"><strong><font size="2">Nome</font></strong></td>
            <td width="7%" align="center"><strong><font size="2">D. Ini</font></strong></td>
            <td width="7%" align="center"><strong><font size="2">D. Fim</font></strong></td>
            <td width="15%" align="center"><strong><font size="2">Assina</font></strong></td>
            <td width="7%" align="center"><strong><font size="2">Aprovado</font></strong></td>
            <td width="7%" align="center"><strong><font size="2">Gerar</font></strong></td>
          </tr>
          <?
	$colMilitar2 = $fachadaSist2->lerColecaoMilitar("m.antiguidade, p.nome",
			"and p.perm_pub_bi = 'S' and m.pgrad_cod = '".$codpgrad."'");
  		$Militar = $colMilitar2->iniciaBusca1();
  		$total = $colMilitar2->getQTD();	
	$ord = 0;
	$items_lidos = 0;
  	while ($Militar != null){
  		if($codpgrad === $Militar->getPGrad()->getCodigo()){
			/* Capturando a descrição da QM*/
			$ord++;
			if ($ord > $item){
				$pQM = $fachadaSist2->lerQM($Militar->getQM()->getCod());
				$pGrad = $fachadaSist2->lerPGrad($Militar->getPGrad()->getCodigo());
				$pGradNome = $pGrad->getDescricao().' '.$Militar->getNomeGuerra();
				echo '<tr id='.$ord.' onMouseOut="outLinha('.$ord.')" 
						onMouseOver="overLinha('.$ord.')" bgcolor="#F5F5F5">
						<td align="center">'.$ord.'</TD>';
				echo '<TD>'.$pGrad->getDescricao().'</TD>';
				//echo '<br>'.$Militar->exibeDados().'<br>';	
				echo '<TD>'
				  .$apresentacao->setaNomeGuerra($Militar->getNome(),$Militar->getNomeGuerra()).'</TD>';
				/*Buscar os tempos de serviço registrados para o semestre*/
				$filtro = "id_militar_alt='".$Militar->getIdMilitar()."' and 
							data_in >= '".$dataInicial."' and 
							data_fim <= '".$dataFinal."' ";
				$colTempoSerPer2 = $fachadaSist2->lerColecaoTempoSerPer($filtro,null);
				$TempoSerPer = $colTempoSerPer2->iniciaBusca1();
				if ($TempoSerPer != null){
					$dataIni = $TempoSerPer->getdataIn()->GetcDataDDBMMBYYYY();
					$dataFim = $TempoSerPer->getdataFim()->GetcDataDDBMMBYYYY();
					echo '<TD align="center">'.$dataIni.'</TD>';
					echo '<TD align="center">'.$dataFim.'</TD>';
					echo '<TD align="left">';
					$idMilitarAss = $TempoSerPer->getmilitarAss()->getIdMilitar();
					if($idMilitarAss !== null){
						$milAssina = $fachadaSist2->lerMilitar($TempoSerPer->getmilitarAss()->getIdMilitar());	
						$PGradMilAss = $fachadaSist2->lerPGrad($milAssina->getPGrad()->getCodigo());
						echo $PGradMilAss->getDescricao().' ';
						echo $milAssina->getNomeGuerra();
					} else {
						echo '-';
					}
					echo '</TD>';
					echo '<TD align="center">'.$apresentacao->retornaCheck($TempoSerPer->getAssinado()).'</TD>';
					echo '<td align="center"><input type="checkbox" name="vetor[]" 
					      value="'.$Militar->getIdMilitar().'">
						 </td></tr>';
				} else {
					echo '<TD align="center">&nbsp;</TD>';
					echo '<TD align="center">&nbsp;</TD>';
					echo '<TD align="center">&nbsp;</TD>';
					echo '<TD align="center">&nbsp;</TD>';
					echo '<TD align="center">&nbsp;</TD>';
				}
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
    <table width="850" border="0" >
      <TR>
        <!-- retirado em 06Mai08
		<td align="left" width="50%">
			<input type="button" name="todos" value="Gerar Para Todos" onclick="javascript:gerarAlt('false')">
		</td>
		-->
        <td></td>
        <td width="40%" align="right"><input name="selecionados" type="button" value="Gerar" onClick="javascript:gerarAlt('true')">
          &nbsp;&nbsp; <a href="javascript:marcaTudo(document.geraAlt,true)">Marca Tudo</a>&nbsp;/&nbsp; <a href="javascript:marcaTudo(document.geraAlt,false)">Desmarca Tudo</a> </td>
        <td width="7%" align="center"><img src="./imagens/seta.png" border="0" alt=""></td>
      </TR>
    </TABLE>
    <table width="850" border="0" cellspacing="0" >
      <tr>
        <td align="right"><?
	if ($total > 20){
		echo "&nbsp;&nbsp;&nbsp;";
		$apresentacao->montaComboPag($total,$item,$selected,null);
	}	
	?>
        </td>
      </tr>
    </table>
  </form>
  <?
	if (isset($_POST['executar'])){
//		$dataIni = str_replace("/","-",$dataIni);
//		$dataIni = substr($dataIni,6,4).'-'.substr($dataIni,3,2).'-'.substr($dataIni,0,2);
//		echo $dataFim;
//		$dataFim = str_replace("/","-",$dataFim);
//		$dataFim = substr($dataFim,6,4).'-'.substr($dataFim,3,2).'-'.substr($dataFim,0,2);
		$dataInicial = str_replace("/","-",$dataInicial);
		$dataFinal = str_replace("/","-",$dataFinal);
		$dataInicial = new MinhaData($dataInicial);
		$dataFinal = new MinhaData($dataFinal);
//		$dataInicial = new MinhaData($dataIni);
//		$dataFinal = new MinhaData($dataFim);
//		print_r($dataInicial);
//		print_r($dataFinal);
		
					
		if (isset($_POST['vetor'])) {
			$colMilitar2 = new ColMilitar2();
			/* Laço que cria a coleção de militares que terão suas alterações geradas */
			foreach ($_POST['vetor'] as $IdMilitar) {
				$militar = $fachadaSist2->lerMilitar($IdMilitar);
				$colMilitar2->incluirRegistro($militar);
			}
			/* Gera as alterações passando a coleção de militares, data inicial e data final */
			$arq = $fachadaSist2->gerarAlteracoes($colMilitar2,$dataInicial,$dataFinal);

			if ($arq === 0)
				echo '<script type=""text/javascript>window.alert("Não há conteúdo para as alterações");</script>';
			else
				echo '<script type=""text/javascript>javascript:viewPDF2("'.$arq.'");</script>';
		} else {
			if ($_POST['executar2'] == "false") {
				$arq = $fachadaSist2->gerarAlteracoes(null,$dataInicial,$dataFinal);
				if ($arq == null)
					echo '<script type=""text/javascript>window.alert("Erro ao gerar o arquivo!'.$arq.'");</script>';
				else
					echo '<script type=""text/javascript>javascript:viewPDF2("'.$arq.'");</script>';
			} else {
				/* Exibe uma msg de alerta caso o usário mande gerar alterações sem selecionar um militar */
				echo ('<script type=""text/javascript> window.alert(\'Selecione pelo menos 1 militar!!!\')</script>');
			}
		}
	}
	?>
  <script type=""text/javascript>
		document.geraAlt.seleSemestre.value = <?=$semestre?>;
		document.geraAlt.selePGrad.value = <?=$codpgrad?>;		
	</script>
  <a name="cadastro"></a>
</center>
</body>
</html>
