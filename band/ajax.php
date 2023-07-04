<? 	session_start(); 
	require_once('filelist_geral.php');
	require_once('filelist_militar.php');
	require_once('filelist_pgrad.php');
	require_once('filelist_qm.php');
	require_once('filelist_funcao.php');
	require_once('filelist_om.php');
	require_once('filelist_temposerper.php');
	$fachadaSist2 = new FachadaSist2();
    $funcoesPermitidas = $fachadaSist2->lerColecaoAutorizada($_SESSION['NOMEUSUARIO'], 'X');	
	$apresentacao = new Apresentacao($funcoesPermitidas);
	
	
if ($_GET["opcao"] == "cadTempoServico"){
	$idMilitarAlt = $_GET["idMilitarAlt"];
	$formulario = $_GET["formulario"];
	$anoAtual = $_GET["ano"];
	if ($formulario === "textoForm"){
		echo '<h3>Tempos registrados em '.$anoAtual.'.</h3>';
	}
	$Militar = $fachadaSist2->lerMilitar($idMilitarAlt);
	$pGrad = $fachadaSist2->lerPGrad($Militar->getPGrad()->getCodigo());
	$colTempoSerPer2 = $fachadaSist2->lerColecaoTempoSerPer("id_militar_alt='".$idMilitarAlt."' and EXTRACT(YEAR FROM data_in)=".$anoAtual,null);
			$TempoSerPer = $colTempoSerPer2->iniciaBusca1();
	$ord = 1;
		
	echo '<br><table width="400" border="0" cellspacing="0" cellppading="0"><tr><td>';
	echo $pGrad->getDescricao().' - '
		.utf8_encode($apresentacao->setaNomeGuerra($Militar->getNome(),$Militar->getNomeGuerra()));
	echo '</td></tr></table>';	
	//echo '<form name="cadTemposv" method="post">';
	echo '<table width="500" border="0" cellspacing="0" cellppading="0" class="lista"><tr><td>
			<table width="100%" border="0" cellspacing="1" cellpadding="0">
			<tr class="cabec">
			<td width="5%" align="center"><b><font size="2">Ord</font></b></td>
			<td width="15%" align="center"><b><font size="2">Data Inicial</font></b></td>
			<td width="15%"%" align="center"><b><font size="2">Data T&eacute;rmino</font></b></td>
			<td width="10%" align="center"><b><font size="2">Assinada</font></b></td>';
	if ($formulario === "listaPeriodos"){
		echo '<td width="10%" align="center"><b><font size="2">A&ccedil;&atilde;o</font></b></td>';
	}
	echo '</tr>';
	while ($TempoSerPer != null){
		echo '<tr bgcolor="#F5F5F5"><td align="center">'.$ord.'</td>';
		$ord++;
		echo '<td align="center">'.$TempoSerPer->getdataIn()->GetcDataDDBMMBYYYY().'</td>';
		echo '<td align="center">'.$TempoSerPer->getdataFim()->GetcDataDDBMMBYYYY().'</td>';
		echo '<td align="center">'.$TempoSerPer->getAssinado().'</td>';
		//print_r($TempoSerPer);
		if ($formulario === "listaPeriodos"){	
			$param = "'".$idMilitarAlt."','"
			.$TempoSerPer->getmilitarAss()->getIdMilitar()."','"
			.$TempoSerPer->getdataIn()->GetcDataDDBMMBYYYY()."','"
			.$TempoSerPer->getdataFim()->GetcDataDDBMMBYYYY()."',"
			
			.$TempoSerPer->getTemComEfeSer()->getAno().","
			.$TempoSerPer->getTemComEfeSer()->getMes().","
			.$TempoSerPer->getTemComEfeSer()->getDia().","
					
			.$TempoSerPer->getArr()->getAno().","
			.$TempoSerPer->getArr()->getMes().","
			.$TempoSerPer->getArr()->getDia().","
					
			.$TempoSerPer->getNArr()->getAno().","
			.$TempoSerPer->getNArr()->getMes().","
			.$TempoSerPer->getNArr()->getDia().","
						
			.$TempoSerPer->getTemNCom()->getAno().","
			.$TempoSerPer->getTemNCom()->getMes().","
			.$TempoSerPer->getTemNCom()->getDia().","
			
			.$TempoSerPer->getTemMedMil()->getAno().","
			.$TempoSerPer->getTemMedMil()->getMes().","
			.$TempoSerPer->getTemMedMil()->getDia().","
			
			.$TempoSerPer->getSerRel()->getAno().","
			.$TempoSerPer->getSerRel()->getMes().","
			.$TempoSerPer->getSerRel()->getDia().","
					
			.$TempoSerPer->getTotEfeSer()->getAno().","
			.$TempoSerPer->getTotEfeSer()->getMes().","
			.$TempoSerPer->getTotEfeSer()->getDia().",'"
				
			.$TempoSerPer->getAssinado()."',";
			//marco			
			echo '<td align="center"><a href="javascript:carregaedit('.$param.'\'Alterar\')">';
  	        if ($_SESSION['NOMEUSUARIO'] != 'supervisor'){ 
				$mAlterar = $funcoesPermitidas->lerRegistro(1122);
  	        }
            if (($mAlterar != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor')){ 
				echo '<img src="./imagens/alterar.gif"  border=0 title="Alterar">';
			}
			echo '<FONT COLOR="#000000"></FONT></a>&nbsp;|&nbsp'; 
			echo '<a href="javascript:carregaedit('.$param.'\'Excluir\')">';
            if ($_SESSION['NOMEUSUARIO'] != 'supervisor'){ 
				$mExcluir = $funcoesPermitidas->lerRegistro(1123);
            }
   	        if (($mExcluir != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor')){ 
				echo '<img src="./imagens/excluir.gif" border=0 title="Excluir">';
			}
			echo '<FONT COLOR="#000000"></FONT></a>';
		}	
		echo '</tr>';
		$TempoSerPer = $colTempoSerPer2->getProximo1();
	}
	echo '</table></td></tr></table>';
	//verifica permissao para incluir tempos
   	if ($_SESSION['NOMEUSUARIO'] != 'supervisor'){ 
	   $mIncluir = $funcoesPermitidas->lerRegistro(1121);
	}
    if (($formulario === "listaPeriodos") and (($mIncluir != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor'))){ 
		//verifica permissao
       	if ($_SESSION['NOMEUSUARIO'] != 'supervisor'){ 
			$mIncluir = $funcoesPermitidas->lerRegistro(1121);
		}
        if (($mIncluir != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor')){ 
			echo '<table width="400" border="0" ><TR><TD><a href="javascript:novo(\''.$idMilitarAlt.'\')" id="novo">';
		    echo '<img src="./imagens/seta_dir.gif" border=0>';
		    echo '<FONT COLOR="#0080C0">Adicionar</FONT></a></TD></TR></TABLE>';
		}	 	
	}
		//echo '</form>';
}
	
if ($_GET["opcao"] == "alteraTempoSv"){ 
	$acao = $_GET["acao"];
		
	$dataIn = trim($_GET['dataIn']);
	$dataIn = explode("/",$dataIn);
	$dataIn = $dataIn[2]."-".$dataIn[1].'-'.$dataIn[0];
	$dataIn = new MinhaData($dataIn);
		
	$dataFim = trim($_GET['dataTerm']);
	$dataFim = explode("/",$dataFim);
	$dataFim = $dataFim[2]."-".$dataFim[1].'-'.$dataFim[0];
	$dataFim = new MinhaData($dataFim);
		
	$militarAlt = new Militar(null, null, null, null, null);
	$militarAss = new Militar(null, null, null, null, null);
        
    $temComEfeSer = new Tempos();
	$temComEfeSer->setAno($_GET['TC_Ano']);
    $temComEfeSer->setMes($_GET['TC_Mes']);
	$temComEfeSer->setDia($_GET['TC_Dia']);
	        
	$temNCom = new Tempos();
	$temNCom->setAno($_GET['TNC_Ano']);
	$temNCom->setMes($_GET['TNC_Mes']);
	$temNCom->setDia($_GET['TNC_Dia']);
	        
	$temMedMil = new Tempos();
	$temMedMil->setAno($_GET['TSCMM_Ano']);
	$temMedMil->setMes($_GET['TSCMM_Mes']);
	$temMedMil->setDia($_GET['TSCMM_Dia']);
	        
	$temSerRel = new Tempos();
	$temSerRel->setAno($_GET['TSNR_Ano']);
	$temSerRel->setMes($_GET['TSNR_Mes']);
	$temSerRel->setDia($_GET['TSNR_Dia']);
	        
	$temTotEfeSer = new Tempos();
	$temTotEfeSer->setAno($_GET['TTES_Ano']);
	$temTotEfeSer->setMes($_GET['TTES_Mes']);
	$temTotEfeSer->setDia($_GET['TTES_Dia']);
	        
	$temArr = new Tempos();
	$temArr->setAno($_GET['Arr_Ano']);
	$temArr->setMes($_GET['Arr_Mes']);
	$temArr->setDia($_GET['Arr_Dia']);
	        
	$temNArr = new Tempos();
	$temNArr->setAno($_GET['nArr_Ano']);
	$temNArr->setMes($_GET['nArr_Mes']);
	$temNArr->setDia($_GET['nArr_Dia']);
        
	$TempoSerPer = new TempoSerPer($idComport,$dataIn, $dataFim, $militarAlt, $militarAss, $temComEfeSer, $temNCom, $temMedMil, 
				$temSerRel, $temTotEfeSer, $temArr, $temNArr);
					
	$TempoSerPer->getmilitarAlt()->setIdMilitar($_GET['idMilitarAlt']);                   
	$TempoSerPer->getmilitarAss()->setIdMilitar($_GET['idMilitarAss']);
		
			//print_r($TempoSerPer).'<br><br><br>';
			//echo '<script>window.alert("Módulo")</script>';
	if ($acao == 'Incluir'){
		$fachadaSist2->incluirTempoSv($TempoSerPer);
	}
	if ($acao == 'Alterar'){
		$fachadaSist2->alterarTempoSv($TempoSerPer);		
	}
	if ($acao == 'Excluir'){
		$fachadaSist2->excluirTempoSv($TempoSerPer);		
	}
		
}	

if ($_GET["opcao"] == "montaComboAssina"){
	$idMilitarAss = $_GET["idMilitarAss"];
	$colMilitar2 = $fachadaSist2->lerColMilAssAlteracoes(null);
	$Militar = $colMilitar2->iniciaBusca1();
	echo 'Militar Assina: <select name="seleMilitarAssina">';
	while ($Militar != null){
		if ($Militar->getIdMilitar() === $idMilitarAss){
			$selecionado = 'SELECTED';
		}	
		$pGrad = $fachadaSist2->lerPGrad($Militar->getPGrad()->getCodigo());
		echo '<option value="'.$Militar->getIdMilitar().'"'.$selecionado.'>'
				.$pGrad->getDescricao().'-'.$Militar->getNome().'</option>';
		$Militar = $colMilitar2->getProximo1();
	}
	if (!isset($selecionado)){
		$militarAss = $fachadaSist2->lerMilitar($idMilitarAss);
		$pGrad = $fachadaSist2->lerPGrad($militarAss->getPGrad()->getCodigo());
		echo '<option value="'.$idMilitarAss.'" SELECTED>'
			.$pGrad->getDescricao().'-'
			.$militarAss->getNome()
			.'-(Fora de Função)'.'</option>';
	}
	echo '</select><br><br>';
}

if ($_GET["opcao"] == "assinaAltr"){
	$idMilitarAlt = $_GET["idMilitarAlt"];
	$formulario = $_GET["formulario"];
	$anoAtual = $_GET["ano"];
	$acao = $_GET["acao"];
	//echo $acao;
	if ($acao == "assinar"){
		$opcao = "Assinar";
		$situacao = 'N';
	} else {
		$opcao = "Cancelar Assinatura";
		$situacao = 'S';
	}	
	if ($formulario === "textoForm"){
		echo '<h3>Tempos registrados em '.$anoAtual.'.</h3>';
	}
	$Militar = $fachadaSist2->lerMilitar($idMilitarAlt);
	$pGrad = $fachadaSist2->lerPGrad($Militar->getPGrad()->getCodigo());
	$colTempoSerPer2 = $fachadaSist2->lerColecaoTempoSerPer("id_militar_alt='".$idMilitarAlt."' and EXTRACT(YEAR FROM data_in)=".$anoAtual." and assinado = '".$situacao."'",null);
	$TempoSerPer = $colTempoSerPer2->iniciaBusca1();
	$ord = 1;
		
	echo '<br><table width="400" border="0" cellspacing="0" cellppading="0"><tr><td>';
	echo $pGrad->getDescricao().' - '
		.utf8_encode($apresentacao->setaNomeGuerra($Militar->getNome(),$Militar->getNomeGuerra()));
	echo '</td></tr></table>';	
	//echo '<form name="cadTemposv" method="post">';
	echo '<table width="500" border="0" cellspacing="0" cellppading="0" class="lista"><tr><td>
			<table width="100%" border="0" cellspacing="1" cellpadding="0">
			<tr class="cabec">
			<td width="5%" align="center"><b><font size="2">Ord</font></b></td>
			<td width="15%" align="center"><b><font size="2">Data Inicial</font></b></td>
			<td width="15%"%" align="center"><b><font size="2">Data T&eacute;rmino</font></b></td>
			<td width="15%" align="center"><b><font size="2">Assinada</font></b></td>';
	if ($formulario === "listaPeriodos"){
		echo '<td width="10%" align="center"><b><font size="2">A&ccedil;&atilde;o</font></b></td>';
	}
	echo '</tr>';
	
	while ($TempoSerPer != null){
		echo '<tr bgcolor="#F5F5F5"><td align="center">'.$ord.'</td>';
		$ord++;
		echo '<td align="center">'.$TempoSerPer->getdataIn()->GetcDataDDBMMBYYYY().'</td>';
		echo '<td align="center">'.$TempoSerPer->getdataFim()->GetcDataDDBMMBYYYY().'</td>';
		echo '<td align="center">'.$apresentacao->retornaCheck($TempoSerPer->getAssinado()).'</td>';
		//print_r($TempoSerPer);
		if ($formulario === "listaPeriodos"){	
			$param = "'".$idMilitarAlt."','"
					.$TempoSerPer->getmilitarAss()->getIdMilitar()."','"
					.$TempoSerPer->getdataIn()->GetcDataDDBMMBYYYY()."','"
					.$TempoSerPer->getdataFim()->GetcDataDDBMMBYYYY()."','"
					.$TempoSerPer->getAssinado()."',";
					echo '<td align="center"><a href="javascript:carregaedit('.$param.'\''.$opcao.'\')">
			  			  <img src="./imagens/alterar.gif"  border=0 title="Assinar"><FONT COLOR="#000000"></FONT></a>';
		}	
		echo '</tr>';
		$TempoSerPer = $colTempoSerPer2->getProximo1();
	}
	echo '</table></td></tr></table><br>';
}

if ($_GET["opcao"] == "assinaAlteracao"){ 
	$acao = $_GET["acao"];
	$idMilitarAss = $_GET['idMilitarAss'];
	$idMilitarAlt = $_GET['idMilitarAlt'];
    $idComport = $_GET['idComport'];
	
	$dataIn = trim($_GET['dataIn']);
	$dataIn = explode("/",$dataIn);
	$dataIn = $dataIn[2]."-".$dataIn[1].'-'.$dataIn[0];
	$dataIn = new MinhaData($dataIn);
	
	$dataFim = trim($_GET['dataTerm']);
	$dataFim = explode("/",$dataFim);
	$dataFim = $dataFim[2]."-".$dataFim[1].'-'.$dataFim[0];
	$dataFim = new MinhaData($dataFim);

	$TempoSerPer = $fachadaSist2->lerTempoSv($dataIn, $dataFim, $idMilitarAlt);
	//print_r($TempoSerPer);
	if ($acao == 'assinar'){
		$TempoSerPer->setAssinado('S');
		$TempoSerPer->getmilitarAss()->setIdMilitar($idMilitarAss);
		$fachadaSist2->alterarTempoSv($TempoSerPer);		
	}
	if ($acao == 'cancelar'){
		$TempoSerPer->setAssinado('N');
		$fachadaSist2->alterarTempoSv($TempoSerPer);		
	}
}	
		// Cadastro de funcoes - Lista os militares que estiverem em determinada função
if($_GET["opcao"] == "listamilitarfuncao"){
	$codFuncao = $_GET["codfuncao"];
	
	echo  '<h3><FONT COLOR="#0000FF">'.'Militares na Função'.'</FONT></h3>';
	$colMilitar2 = $fachadaSist2->lerColecaoMilitar("m.pgrad_cod","and p.funcao_cod = ".$codFuncao);
	$Militar = $colMilitar2->iniciaBusca1();
	echo '<br><table width="90%" border="1" cellspacing="0" cellppading="0" class="lista"><tr class="cabec">';
	echo '<td colspan="4" align="left">'.'Militar(es)'.'</td></tr>';
	$ord = 0;
	while ($Militar != null){
		$ord++;
		$pQM = $fachadaSist2->lerQM($Militar->getQM()->getCod());
		$pGrad = $fachadaSist2->lerPGrad($Militar->getPGrad()->getCodigo());

		echo '<tr id='.($ord + 2000).' onMouseOut="outLinha('.($ord + 2000).')" 
						onMouseOver="overLinha('.($ord + 2000).')" bgcolor="#F5F5F5">
						<td align="center">'.$ord.'</TD>';
		echo '<TD>'.$pGrad->getDescricao().'</TD>';
		echo '<TD>'.utf8_encode($apresentacao->setaNomeGuerra($Militar->getNome(),$Militar->getNomeGuerra())).'</TD>';
		echo '</TR>';
		$Militar = $colMilitar2->getProximo1();
		if ($ord >= 15){
			echo '<TR><TD align="right" colspan="4" bgcolor="white"><FONT COLOR="#FF0000">De um total de: '.$colMilitar2->getQTD().' militares.</FONT></TD></TR>';
			BREAK;
		}
	}			
	echo '</table>';
}
	

?>
