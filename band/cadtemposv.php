<? 	session_start();
	require_once('filelist_geral.php');
	require_once('filelist_pgrad.php');
	require_once('filelist_funcao.php');
	require_once('filelist_qm.php');
	require_once('filelist_militar.php');
	require_once('filelist_om.php');
	require_once('filelist_temposerper.php');
	require_once('filelist_boletim.php');
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
	$dataInicial = $semestre==1?$ianoAtual.'/01/01':$ianoAtual.'/07/01';
	$dataFinal = $semestre==1?$ianoAtual.'/06/30':$ianoAtual.'/12/31';

	if($semestre==1){
		$dataIniSemAnterior = ($ianoAtual - 1).'/07/01';
		$dataFimSemAnterior = ($ianoAtual - 1).'/12/31';
	} else {
		$dataIniSemAnterior = $ianoAtual .'/01/01';
		$dataFimSemAnterior = $ianoAtual.'/06/30';
	}
	//echo $dataIniSemAnterior.'<br>';
	//echo $dataFimSemAnterior;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SisBol</title>
<? $apresentacao->chamaEstilo(); ?>
<script type="text/javascript" src="scripts/band.js"></script>
<script type="text/javascript" src="scripts/flyform.js"></script>
<script type="text/javascript" src="scripts/overlib.js"></script>
<script type="text/javascript" src="scripts/msg_hints.js"></script>
<script type="text/javascript">

	function go(item){
		atualizarMilitares(false,item);
	}
	function atualizarMilitares(mudouPosto,item){
		if(mudouPosto){
			window.location.href="cadtemposv.php?codpgrad="
			+document.cadTemposv.selePGrad.value+"&ianoAtual="+document.cadTemposv.ianoAtual.value+
			"&semestre="+document.cadTemposv.seleSemestre.value+"&item=0";
		} else {
			window.location.href="cadtemposv.php?codpgrad="
			+document.cadTemposv.selePGrad.value+"&ianoAtual="+document.cadTemposv.ianoAtual.value+
			"&semestre="+document.cadTemposv.seleSemestre.value+"&item="+item;
		}
	}
	function ajaxTempoServico(idMilitarAlt,IdComport,divId,dtIni,dtFim){
		document.getElementById("subscrForm").style.left = 50 + "px";
		document.getElementById("flyframe").style.visibility = "visible";
		document.getElementById('subscrForm').style.visibility = 'visible';
		url="ajax_cadtemposv.php?opcao=ajaxTempoServico&idMilitarAlt="+idMilitarAlt+"&comportamento="+IdComport+"&formulario="+divId+"&dtInicial="+dtIni+"&dtFinal="+dtFim;
		ajax(url,divId);
	}
	function escondeFly(){
		document.getElementById("flyframe").style.visibility = "hidden";
		document.getElementById('subscrForm').style.visibility = 'hidden';
	}
	function carregaedit(Militar, idMilAlt, IdMilAss, IdComport, dataIn, dataTerm, TC_Ano, TC_Mes, TC_Dia, Arr_Ano, Arr_Mes, Arr_Dia, Arr_Texto,
						 nArr_Ano, nArr_Mes, nArr_Dia, nArr_Texto, TNC_Ano, TNC_Mes, TNC_Dia, TNC_Texto, TSCMM_Ano, TSCMM_Mes,TSCMM_Dia,TSCMM_Texto,
						 TSNR_Ano, TSNR_Mes, TSNR_Dia, TSNR_Texto, TTES_Ano, TTES_Mes, TTES_Dia, TTES_Texto, Assinado, acao) {
		buscarFormCadastro(acao,Militar);
		var sTexto = '';
		document.getElementById("idacao").style.visibility = (Assinado == "S")? "hidden":"visible";
		document.getElementById("btnCalcula").style.visibility = (Assinado == "S")? "hidden":"visible";
		document.getElementById("idAssinada").innerHTML = (Assinado == "S")?
			'<font size="2" color="green"><b>&nbsp;&nbsp;Sim<\/b><\/font>':
			'<b><font size="2" color="red"><b>&nbsp;&nbsp;Não<\/b><\/font>';

		document.cadTemposv.seleComportamento.value = IdComport;
		montaComboAssina(IdMilAss,"comboMilitarAssina",acao);

		//document.cadTemposv.seleMilitarAssina.value = IdMilAss;
		document.cadTemposv.inputMilitar.value = idMilAlt;
		document.cadTemposv.dataInicial.value = dataIn;
		document.cadTemposv.dataTermino.value = dataTerm;

		document.cadTemposv.ano_TC.value = TC_Ano;
		document.cadTemposv.mes_TC.value = TC_Mes;
		document.cadTemposv.dia_TC.value = TC_Dia;

		document.cadTemposv.ano_ARR.value = Arr_Ano;
		document.cadTemposv.mes_ARR.value = Arr_Mes;
		document.cadTemposv.dia_ARR.value = Arr_Dia;
		document.cadTemposv.texto_ARR.value = Arr_Texto;

		document.cadTemposv.ano_NARR.value = nArr_Ano;
		document.cadTemposv.mes_NARR.value = nArr_Mes;
		document.cadTemposv.dia_NARR.value = nArr_Dia;
		document.cadTemposv.texto_NARR.value = nArr_Texto;

		document.cadTemposv.ano_TNC.value = TNC_Ano;
		document.cadTemposv.mes_TNC.value = TNC_Mes;
		document.cadTemposv.dia_TNC.value = TNC_Dia;
		document.cadTemposv.texto_TNC.value = TNC_Texto;

		document.cadTemposv.ano_TSCMM.value = TSCMM_Ano;
		document.cadTemposv.mes_TSCMM.value = TSCMM_Mes;
		document.cadTemposv.dia_TSCMM.value = TSCMM_Dia;
		document.cadTemposv.texto_TSCMM.value = TSCMM_Texto;

		document.cadTemposv.ano_TSNR.value = TSNR_Ano;
		document.cadTemposv.mes_TSNR.value = TSNR_Mes;
		document.cadTemposv.dia_TSNR.value = TSNR_Dia;
		document.cadTemposv.texto_TSNR.value = TSNR_Texto;

		document.cadTemposv.ano_TTES.value = TTES_Ano;
		document.cadTemposv.mes_TTES.value = TTES_Mes;
		document.cadTemposv.dia_TTES.value = TTES_Dia;
		document.cadTemposv.texto_TTES.value = TTES_Texto;
	}
	function buscarFormCadastro(acao,nome){
		document.getElementById("formulario").style.visibility = "visible";
		montaComboAssina(null,"comboMilitarAssina",acao);
		document.getElementById("tituloForm").innerHTML = nome;
		document.cadTemposv.acao.value = acao;
		if(acao != "Incluir"){
			document.cadTemposv.dataInicial.readOnly = true;
		} else {
			document.cadTemposv.dataInicial.readOnly = false;
		}
		window.location.href="#cadastro";
	}
	function montaComboAssina(idMilitarAss,divId,acao){
		url="ajax_cadtemposv.php?opcao=montaComboAssina&idMilitarAss="+idMilitarAss+"&acao="+acao;
		ajax(url,divId);
	}
	function cancelar(){
   		document.getElementById("formulario").style.visibility = "hidden";
		document.getElementById("idacao").style.visibility = "hidden";
		document.getElementById("btnCalcula").style.visibility = "hidden";
   		window.location.href="#topo";
	}

	function executa(acao){
		if (!validaMesDia(document.cadTemposv)){
			document.cadTemposv.dataInicial.focus();
			return;
		}
		var data1 = document.getElementById("data1").value;
		var data2 = document.getElementById("data2").value;
		var dataIni = "<?=$apresentacao->dtIniSem; ?>";
		var dataFim = "<?=$apresentacao->dtFimSem; ?>";
		var teste3="teste3";


		var nova_data1 	= parseInt(data1.split("/")[2].toString() + data1.split("/")[1].toString() + data1.split("/")[0].toString());
		var nova_data2 	= parseInt(data2.split("/")[2].toString() + data2.split("/")[1].toString() + data2.split("/")[0].toString());
		var dataIni1	= parseInt(dataIni.split("/")[2].toString() + dataIni.split("/")[1].toString() + dataIni.split("/")[0].toString());
		var dataFim1	= parseInt(dataFim.split("/")[2].toString() + dataFim.split("/")[1].toString() + dataFim.split("/")[0].toString());

		if (nova_data1 > nova_data2){
			alert("A data Inicial não pode ser menor que a data Final.");
			document.cadTemposv.dataInicial.focus();
			return;
		}
		if (!dataInPeriodo(data1,dataIni,dataFim)){
			alert("As datas devem estar dentro do semestre.");
			document.cadTemposv.dataInicial.focus();
			return;
		}
		if (!dataInPeriodo(data2,dataIni,dataFim)){
			alert("As datas devem estar dentro do semestre.");
			document.cadTemposv.dataInicial.focus();
			return;
		}
		url="ajax_cadtemposv.php?opcao=alteraTempoSv&acao="+acao
			+"&idMilitarAlt="+document.cadTemposv.inputMilitar.value
			+"&idComport="+document.cadTemposv.seleComportamento.value
			+"&dataIn="+document.cadTemposv.dataInicial.value
			+"&dataTerm="+document.cadTemposv.dataTermino.value
			+"&idMilitarAss="+document.cadTemposv.seleMilitarAssina.value
			+"&TC_Ano="+document.cadTemposv.ano_TC.value
			+"&TC_Mes="+document.cadTemposv.mes_TC.value
			+"&TC_Dia="+document.cadTemposv.dia_TC.value
			+"&Arr_Ano="+document.cadTemposv.ano_ARR.value
			+"&Arr_Mes="+document.cadTemposv.mes_ARR.value
			+"&Arr_Dia="+document.cadTemposv.dia_ARR.value
			+"&Arr_Texto="+document.cadTemposv.texto_ARR.value
			+"&nArr_Ano="+document.cadTemposv.ano_NARR.value
			+"&nArr_Mes="+document.cadTemposv.mes_NARR.value
			+"&nArr_Dia="+document.cadTemposv.dia_NARR.value
			+"&nArr_Texto="+document.cadTemposv.texto_NARR.value
			+"&TNC_Ano="+document.cadTemposv.ano_TNC.value
			+"&TNC_Mes="+document.cadTemposv.mes_TNC.value
			+"&TNC_Dia="+document.cadTemposv.dia_TNC.value
			+"&TNC_Texto="+document.cadTemposv.texto_TNC.value
			+"&TSCMM_Ano="+document.cadTemposv.ano_TSCMM.value
			+"&TSCMM_Mes="+document.cadTemposv.mes_TSCMM.value
			+"&TSCMM_Dia="+document.cadTemposv.dia_TSCMM.value
			+"&TSCMM_Texto="+document.cadTemposv.texto_TSCMM.value
			+"&TSNR_Ano="+document.cadTemposv.ano_TSNR.value
			+"&TSNR_Mes="+document.cadTemposv.mes_TSNR.value
			+"&TSNR_Dia="+document.cadTemposv.dia_TSNR.value
			+"&TSNR_Texto="+document.cadTemposv.texto_TSNR.value
			+"&TTES_Ano="+document.cadTemposv.ano_TTES.value
			+"&TTES_Mes="+document.cadTemposv.mes_TTES.value
			+"&TTES_Dia="+document.cadTemposv.dia_TTES.value
			+"&TTES_Texto="+document.cadTemposv.texto_TTES.value;
		//ajax(url,'erros');
		ajaxCadMilitar(url,acao);
	}

	function buscaTempoSv(){
		var dataIniSemAnterior = "<?=$dataIniSemAnterior?>";
		var dataFimSemAnterior = "<?=$dataFimSemAnterior?>";
		var idMilitarAlt = document.cadTemposv.inputMilitar.value;
		url="ajax_cadtemposv.php?opcao=buscaTempoSv"
			+"&idMilitarAlt="+document.cadTemposv.inputMilitar.value
			+"&dataIni="+document.cadTemposv.dataInicial.value
			+"&dataFim="+document.cadTemposv.dataTermino.value
			+"&dataIniSemAnt="+dataIniSemAnterior
			+"&dataFimSemAnt="+dataFimSemAnterior;
		//alert(url);
		//ajaxCadMilitar(url,"erros",1);
		//ajax(url,'erros');
		ajaxTempoSvJS(url);
	}
	function carregaForm(resposta){
		eval("var arr = "+resposta);
		with (document.cadTemposv){
			ano_TC.value = arr.ano;
			mes_TC.value = arr.mes;
			dia_TC.value = arr.dia;

			ano_ARR.value = arr.ano;
			mes_ARR.value = arr.mes;
			dia_ARR.value = arr.dia;


			ano_TSCMM.value = arr.medAno;
			mes_TSCMM.value = arr.medMes;
			dia_TSCMM.value = arr.medDia;

			ano_TSNR.value = arr.relAno;
			mes_TSNR.value = arr.relMes;
			dia_TSNR.value = arr.relDia;


			ano_TTES.value = arr.totAno;
			mes_TTES.value = arr.totMes;
			dia_TTES.value = arr.totDia;
		}
		if(arr.msg == 'erro1'){
			alert("Não há lançamento de serviço cadastrado no semestre anterior\n para o militar selecionado.");
		}
		if(arr.msg == 'erro2'){
			msg="Atenção\n\n O cálculo foi feito a partir do lançamento de "+
				"tempo de serviço anterior, que ainda não foi aprovado."+
				"\n\nPara aprovar:\n\n"+
				"Acesse o menu Alterações->Aprovação, selecione o semestre anterior e aprove\n"+
				"as alterações do militar em questão.";
			alert(msg);
		}

	}
	function deletaItem(idt,dataIni,aprovado,militar){
		if(aprovado == 'S'){
			alert('É preciso desaprovar este lançamento de Tempo de Serviço para poder excluir.');
			return;
		}
		if (!window.confirm("Deseja realmente excluir o Tempo de Serviço cadastrado para o:\n\n  "+militar+" ?")){
				return ;
		}
		url="ajax_cadtemposv.php?opcao=excluiTempoSv&idt="+idt+"&dataIn="+dataIni;
		//alert(url);
		ajaxCadMilitar(url,'excluir');
	}
	function validaMesDia(which){
    	for (i=0;i<which.length;i++){
    		var tempobj=which.elements[i];
        	if (tempobj.type=="text" && tempobj.name.substring(0,3)=="dat" && tempobj.value == ""){
        			tempobj.focus();
        			window.alert('As datas são obrigatórias.');
        			return 	false;
        	}
    		if (tempobj.type=="text" && tempobj.name.substring(0,3)=="mes"){
        		if (tempobj.value < 0 || tempobj.value > 12 || tempobj.value == ""){
        			tempobj.focus();
        			window.alert('O número de meses deve estar entre 0 e 11.');
        			return 	false;
        		}
        	}
        	if (tempobj.type=="text" && tempobj.name.substring(0,3)=="dia"){
        		if (tempobj.value < 0 || tempobj.value > 31 || tempobj.value == ""){
        			tempobj.focus();
        			window.alert('O número de dias deve estar entre 0 e 29.');
        			return 	false;
        		}
        	}
		}
		return true;
	}
	function atualizaTela(resposta, tipo){
		atualizarMilitares(false,<?=$item?>);
	}
	function novo(idMilitar,nome,idComport){
		buscarFormCadastro("Incluir",nome+" - Lan&ccedil;ar");
		document.getElementById("idAssinada").innerHTML = '<b><font size="2" color="red"><b>&nbsp;&nbsp;Não<\/b><\/font>';
		//limpaForm(document.cadTemposv);
		for (i=0;i<document.cadTemposv.length;i++){
    		var tempobj=document.cadTemposv.elements[i];
    		if (tempobj.name.substring(0,3)=="mes" || tempobj.name.substring(0,3)=="dia" || tempobj.name.substring(0,3)=="ano"){
        			tempobj.value = "0";
        	}
        	if (tempobj.name.substring(0,3)=="dat"){
        			tempobj.value="";
        	}
		}
		document.cadTemposv.seleComportamento.value = idComport;
		document.cadTemposv.inputMilitar.value = idMilitar;
		document.getElementById("idacao").style.visibility = "visible";
		document.getElementById("btnCalcula").style.visibility = "visible";
		document.cadTemposv.dataInicial.value = "<?= $apresentacao->dtIniSem; ?>";
		document.cadTemposv.dataTermino.value = "<?= $apresentacao->dtFimSem; ?>";
		document.cadTemposv.texto_ARR.value = '';
		document.cadTemposv.texto_NARR.value = '';
		document.cadTemposv.texto_TNC.value = '';
		document.cadTemposv.texto_TSCMM.value = '';
		document.cadTemposv.texto_TSNR.value = '';
		document.cadTemposv.texto_TTES.value = '';
	}
	</script>
</head>
<body>
<a name="topo"></a>
<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
<center>
<? 	$apresentacao->chamaCabec();
		$apresentacao->montaMenu();
		$apresentacao->montaFlyForm(530,200,'white',0);
	?>
<h3 class="titulo">&nbsp;&nbsp;<img src="./imagens/item_dir.gif" alt="">&nbsp;Lançar Tempos de Serviço</h3>
<form  method="post" name="cadTemposv" action="">
  <input name="executar" type="hidden" value="">
  <input name="inputMilitar" type="hidden" value="">
  <table width="850" border="0" cellspacing="0">
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
  	$colPGrad2 = $fachadaSist2->lerColecaoPGrad('cod');
  	$pGrad = $colPGrad2->iniciaBusca1();

  	/*Listar as funções*/
  	$colFuncao2 = $fachadaSist2->lerColecaoFuncao('cod');
  	$Funcao = $colFuncao2->iniciaBusca1();

  	/*Listar as QM*/
  	$colQM2 = $fachadaSist2->lerColecaoQM('cod');
  	$pQM = $colQM2->iniciaBusca1();

  	/* Se estiver setada um posto/graduação*/
  	if(isset($_GET['codpgrad'])){
		$codpgrad = $_GET['codpgrad'];
	} else {
		$codpgrad = $pGrad->getCodigo();
	}
	//$location = "cadTemposv.php?codpgrad=".$codpgrad."&semestre=".$semestre."&ianoAtual=".$ianoAtual;
  	echo 'Listar por: ';
  	$apresentacao->montaCombo('selePGrad',$colPGrad2,'getCodigo','getDescricao',$codpgrad,'atualizarMilitares(true)');
	?>
      </TD>
    </TR>
  </table>
  <table width="850" border="0" cellspacing="0"  class="lista">
    <tr>
      <td>
	  <table width="100%" border="0" cellspacing="1" >
          <tr class="cabec">
            <td width="5%" align="center"><strong><font size="2">Ord</font></strong></td>
            <td width="7%" align="center"><strong><font size="2">P/Grad</font></strong></td>
            <td width="30%" align="center"><strong><font size="2">Nome</font></strong></td>
            <td width="7%" align="center"><strong><font size="2">D. Ini</font></strong></td>
            <td width="7%" align="center"><strong><font size="2">D. Fim</font></strong></td>
            <td width="15%" align="center"><strong><font size="2">Assina</font></strong></td>
            <td width="7%" align="center"><strong><font size="2">Aprovado</font></strong></td>
            <td width="12%" align="center"><strong><font size="2">A&ccedil;&atilde;o</font></strong></td>
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
					echo '<TD align="center">'.$TempoSerPer->getdataIn()->GetcDataDDBMMBYYYY().'</TD>';
					echo '<TD align="center">'.$TempoSerPer->getdataFim()->GetcDataDDBMMBYYYY().'</TD>';
					echo '<TD align="left">';
					$idMilitarAss = $TempoSerPer->getmilitarAss()->getIdMilitar();
					if($idMilitarAss !== null){
						$milAssina = $fachadaSist2->lerMilitar($TempoSerPer->getmilitarAss()->getIdMilitar());
						$PGradMilAss = $fachadaSist2->lerPGrad($milAssina->getPGrad()->getCodigo());
						echo $PGradMilAss->getDescricao().' ';
						echo $milAssina->getNomeGuerra();
						
						// Capturar parametros para o carregaedit
						$param = "'".$pGradNome."','".$Militar->getIdMilitar()."','"
							.$TempoSerPer->getmilitarAss()->getIdMilitar()."',"
							.$Militar->getComportamento().",'"
							.$TempoSerPer->getdataIn()->GetcDataDDBMMBYYYY()."','"
							.$TempoSerPer->getdataFim()->GetcDataDDBMMBYYYY()."',"

							.$TempoSerPer->getTemComEfeSer()->getAno().","
							.$TempoSerPer->getTemComEfeSer()->getMes().","
							.$TempoSerPer->getTemComEfeSer()->getDia().","

							.$TempoSerPer->getArr()->getAno().","
							.$TempoSerPer->getArr()->getMes().","
							.$TempoSerPer->getArr()->getDia().",'"
							.$TempoSerPer->getArr()->getTexto()."',"

							.$TempoSerPer->getNArr()->getAno().","
							.$TempoSerPer->getNArr()->getMes().","
							.$TempoSerPer->getNArr()->getDia().",'"
							.$TempoSerPer->getNArr()->getTexto()."',"

							.$TempoSerPer->getTemNCom()->getAno().","
							.$TempoSerPer->getTemNCom()->getMes().","
							.$TempoSerPer->getTemNCom()->getDia().",'"
							.$TempoSerPer->getTemNCom()->getTexto()."',"

							.$TempoSerPer->getTemMedMil()->getAno().","
							.$TempoSerPer->getTemMedMil()->getMes().","
							.$TempoSerPer->getTemMedMil()->getDia().",'"
							.$TempoSerPer->getTemMedMil()->getTexto()."',"

							.$TempoSerPer->getSerRel()->getAno().","
							.$TempoSerPer->getSerRel()->getMes().","
							.$TempoSerPer->getSerRel()->getDia().",'"
							.$TempoSerPer->getSerRel()->getTexto()."',"

							.$TempoSerPer->getTotEfeSer()->getAno().","
							.$TempoSerPer->getTotEfeSer()->getMes().","
							.$TempoSerPer->getTotEfeSer()->getDia().",'"
							.$TempoSerPer->getTotEfeSer()->getTexto()."','"

							.$TempoSerPer->getAssinado()."',";
					} else {
						echo '-';
					}
					echo '</TD>';
					echo '<TD align="center">'.$apresentacao->retornaCheck($TempoSerPer->getAssinado()).'</TD>';

					echo '<td align="center">
							<a href="javascript:carregaedit('.$param.'\'Alterar\')">
				 		  <img src="./imagens/calculator_edit.png" title="Alterar Tempo de Servi&ccedil;o" border=0></a>
						   &nbsp;|&nbsp;<a href="javascript:deletaItem(\''.$Militar->getIdMilitar().'\',\''.$TempoSerPer->getdataIn()->GetcDataDDBMMBYYYY().'\',\''.$TempoSerPer->getAssinado().'\',\''.$pGrad->getDescricao().'-'.$Militar->getNome().'\')"><img src="./imagens/excluir.png" title="Excluir" border=0 alt=""></a>&nbsp;|&nbsp;
						   <a href=# onmouseover="ajaxTempoServico(\''.$Militar->getIdMilitar().'\',\''.$Militar->getComportamento().'\',\'textoForm\',\''.$dataInicial.'\',\''.$dataFinal.'\')"
						   onMouseOut="javascript:escondeFly();"><img src="./imagens/buscar.gif" title="Visualizar Tempo de Servi&ccedil;o cadastrado" border=0 alt=""></a>
						 </td></tr>
				 		</TR>';
				 		$TempoSerPer = $colTempoSerPer2->getProximo1();
				} else {
					echo '<TD align="center">&nbsp;</TD>';
					echo '<TD align="center">&nbsp;</TD>';
					echo '<TD align="center">&nbsp;</TD>';
					echo '<TD align="center">&nbsp;</TD>';
					echo '<td align="center" valign="middle">

						<a href="javascript:novo(\''.$Militar->getIdMilitar().'\',\''.$pGradNome.'\',\''.$Militar->getComportamento().'\')">
						
				 		<img src="./imagens/calculator_add.png" title="Adicionar Tempo de Servi&ccedil;o" border=0 alt="">Lan&ccedil;ar</a></td>
				 		</TR>';
				}
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
  <br>
  <div id="formulario" STYLE="VISIBILITY:hidden;" align="center">
    <TABLE class="formulario" width="550" bgcolor="#0000FF" CELLPADDING="1" >
      <TR>
        <TD><TABLE width="100%" border="0" CELLSPACING="0" style="name:tabela; color: #000; font-size: 16px;">
            <TR CLASS="cabec">
              <TD colspan="5">
                <div id="tituloForm"><font size="2"> </font></div>               </TD>
            </TR>
            <TR>
              <TD BGCOLOR="#C0C0C0" colspan="5">&nbsp;</TD>
            </TR>
            <TR>
              <TD BGCOLOR="#C0C0C0" colspan="5"><strong>O SISBOL CALCULA UMA PR&Eacute;VIA DO TEMPO DE SERVI&Ccedil;O, SE DESEJAR FAZER O C&Aacute;LCULO EXATO:<a href="http://www.eggcf.eb.mil.br/sistemas/calculo_tp_sv/calculo.php" target="_blank"> Click aqui </a></strong></TD>
            </TR>
            <TR>
              <TD BGCOLOR="#C0C0C0" colspan="2">&nbsp;</TD>
              <TD BGCOLOR="#C0C0C0" colspan="3">&nbsp;</TD>
            </TR>
            <TR>
              <TD BGCOLOR="#C0C0C0" colspan="2"> D. Inicial:
                <input name="dataInicial" type="text" size="15" maxlength="10" onBlur="validaData(this)" id="data1">
                &nbsp;
                D. T&eacute;rmino:
                <input name="dataTermino" type="text" size="15" maxlength="10" onBlur="validaData(this)"  id="data2">
                <input type="button" name="btncalcula" value="Calcular" id="btnCalcula" onClick="buscaTempoSv()"
  			onmouseover="return overlib(getMsg(1), CAPTION,'Calcula o Tempo de Serviço');" onMouseOut="return nd();"/>              </TD>
              <TD BGCOLOR="#C0C0C0" colspan="3">Aprovada?<br>
                <div id="idAssinada"></div>                  </TD>
            </TR>
            <TR>
              <TD  BGCOLOR="#C0C0C0" colspan="5" align="center">&nbsp;</TD>
            </TR>
            <TR>
              <TD  BGCOLOR="#C0C0C0" colspan="2" align="center"><font size="2">LAN&Ccedil;AMENTO DE  TEMPOS</font></TD>
              <TD  BGCOLOR="#C0C0C0" align="center">Anos</TD>
              <TD  BGCOLOR="#C0C0C0" align="center">Meses</TD>
              <TD  BGCOLOR="#C0C0C0" align="center">Dias</TD>
            </TR>
            <TR>
              <TD BGCOLOR="#C0C0C0" colspan="2"> 1. TEMPO COMPUTADO DE EFETIVO SERVI&Ccedil;O (TC):</TD>
              <TD BGCOLOR="#C0C0C0" align="center"><input name="ano_TC" type="text" size="2" maxlength="2" onKeyPress="return so_numeros(event)"></TD>
              <TD BGCOLOR="#C0C0C0" align="center"><input name="mes_TC" type="text" size="2" maxlength="2" onKeyPress="return so_numeros(event)"></TD>
              <TD BGCOLOR="#C0C0C0" align="center"><input name="dia_TC" type="text" size="2" maxlength="2" onKeyPress="return so_numeros(event)"></TD>
            </TR>
            <TR>
              <TD BGCOLOR="#C0C0C0" align="center">&nbsp;</td>
              <TD BGCOLOR="#C0C0C0">a. Arregimentado:</TD>
              <TD BGCOLOR="#C0C0C0" align="center"><input name="ano_ARR" type="text" size="2" maxlength="2" onKeyPress="return so_numeros(event)"></TD>
              <TD BGCOLOR="#C0C0C0" align="center"><input name="mes_ARR" type="text" size="2" maxlength="2" onKeyPress="return so_numeros(event)"></TD>
              <TD BGCOLOR="#C0C0C0" align="center"><input name="dia_ARR" type="text" size="2" maxlength="2" onKeyPress="return so_numeros(event)"></TD>
            </TR>
            <TR>
              <TD BGCOLOR="#C0C0C0" align="center">&nbsp;</td>
              <TD BGCOLOR="#C0C0C0"><textarea name="texto_ARR" cols="50" rows="1"></textarea></TD>
              <TD BGCOLOR="#C0C0C0" align="center">&nbsp;</TD>
              <TD BGCOLOR="#C0C0C0" align="center">&nbsp;</TD>
              <TD BGCOLOR="#C0C0C0" align="center">&nbsp;</TD>
            </TR>
            <TR>
              <TD BGCOLOR="#C0C0C0">&nbsp;</td>
              <TD BGCOLOR="#C0C0C0">b. N&atilde;o Arregimentado:</TD>
              <TD BGCOLOR="#C0C0C0" align="center"><input name="ano_NARR" type="text" size="2" maxlength="2" onKeyPress="return so_numeros(event)"></TD>
              <TD BGCOLOR="#C0C0C0" align="center"><input name="mes_NARR" type="text" size="2" maxlength="2" onKeyPress="return so_numeros(event)"></TD>
              <TD BGCOLOR="#C0C0C0" align="center"><input name="dia_NARR" type="text" size="2" maxlength="2" onKeyPress="return so_numeros(event)"></TD>
            </TR>
            <TR>
              <TD BGCOLOR="#C0C0C0" align="center">&nbsp;</td>
              <TD BGCOLOR="#C0C0C0"><textarea name="texto_NARR" cols="50" rows="1"></textarea></TD>
              <TD BGCOLOR="#C0C0C0" align="center">&nbsp;</TD>
              <TD BGCOLOR="#C0C0C0" align="center">&nbsp;</TD>
              <TD BGCOLOR="#C0C0C0" align="center">&nbsp;</TD>
            </TR>
            <TR>
              <TD BGCOLOR="#C0C0C0" colspan="2"> 2. TEMPO N&Atilde;O COMPUTADO (TNC):</TD>
              <TD BGCOLOR="#C0C0C0" align="center"><input name="ano_TNC" type="text" size="2" maxlength="2" onKeyPress="return so_numeros(event)"></TD>
              <TD BGCOLOR="#C0C0C0" align="center"><input name="mes_TNC" type="text" size="2" maxlength="2" onKeyPress="return so_numeros(event)"></TD>
              <TD BGCOLOR="#C0C0C0" align="center"><input name="dia_TNC" type="text" size="2" maxlength="2" onKeyPress="return so_numeros(event)"></TD>
            </TR>
            <TR>
              <TD BGCOLOR="#C0C0C0" align="center">&nbsp;</td>
              <TD BGCOLOR="#C0C0C0"><textarea name="texto_TNC" cols="50" rows="1"></textarea></TD>
              <TD BGCOLOR="#C0C0C0" align="center">&nbsp;</TD>
              <TD BGCOLOR="#C0C0C0" align="center">&nbsp;</TD>
              <TD BGCOLOR="#C0C0C0" align="center">&nbsp;</TD>
            </TR>
            <TR>
              <TD BGCOLOR="#C0C0C0" colspan="2"> 3. TEMPO DE SERVI&Ccedil;O COMPUT&Aacute;VEL PARA MEDALHA MILITAR (TSCMM):</TD>
              <TD BGCOLOR="#C0C0C0" align="center"><input name="ano_TSCMM" type="text" size="2" maxlength="2" onKeyPress="return so_numeros(event)"></TD>
              <TD BGCOLOR="#C0C0C0" align="center"><input name="mes_TSCMM" type="text" size="2" maxlength="2" onKeyPress="return so_numeros(event)"></TD>
              <TD BGCOLOR="#C0C0C0" align="center"><input name="dia_TSCMM" type="text" size="2" maxlength="2" onKeyPress="return so_numeros(event)"></TD>
            </TR>
            <TR>
              <TD BGCOLOR="#C0C0C0" align="center">&nbsp;</td>
              <TD BGCOLOR="#C0C0C0"><textarea name="texto_TSCMM" cols="50" rows="1"></textarea></TD>
              <TD BGCOLOR="#C0C0C0" align="center">&nbsp;</TD>
              <TD BGCOLOR="#C0C0C0" align="center">&nbsp;</TD>
              <TD BGCOLOR="#C0C0C0" align="center">&nbsp;</TD>
            </TR>
            <TR>
              <TD BGCOLOR="#C0C0C0" colspan="2"> 4. TEMPO DE SERVI&Ccedil;O NACIONAL RELEVANTE (TSNR):</TD>
              <TD BGCOLOR="#C0C0C0" align="center"><input name="ano_TSNR" type="text" size="2" maxlength="2" onKeyPress="return so_numeros(event)"></TD>
              <TD BGCOLOR="#C0C0C0" align="center"><input name="mes_TSNR" type="text" size="2" maxlength="2" onKeyPress="return so_numeros(event)"></TD>
              <TD BGCOLOR="#C0C0C0" align="center"><input name="dia_TSNR" type="text" size="2" maxlength="2" onKeyPress="return so_numeros(event)"></TD>
            </TR>
            <TR>
              <TD BGCOLOR="#C0C0C0" align="center">&nbsp;</td>
              <TD BGCOLOR="#C0C0C0"><textarea name="texto_TSNR" cols="50" rows="1"></textarea></TD>
              <TD BGCOLOR="#C0C0C0" align="center">&nbsp;</TD>
              <TD BGCOLOR="#C0C0C0" align="center">&nbsp;</TD>
              <TD BGCOLOR="#C0C0C0" align="center">&nbsp;</TD>
            </TR>
            <TR>
              <TD BGCOLOR="#C0C0C0" colspan="2"> 5. TEMPO TOTAL DE EFETIVO SERVI&Ccedil;O (TTES):</TD>
              <TD BGCOLOR="#C0C0C0" align="center"><input name="ano_TTES" type="text" size="2" maxlength="2" onKeyPress="return so_numeros(event)"></TD>
              <TD BGCOLOR="#C0C0C0" align="center"><input name="mes_TTES" type="text" size="2" maxlength="2" onKeyPress="return so_numeros(event)"></TD>
              <TD BGCOLOR="#C0C0C0" align="center"><input name="dia_TTES" type="text" size="2" maxlength="2" onKeyPress="return so_numeros(event)"></TD>
            </TR>
            <TR>
              <TD BGCOLOR="#C0C0C0" align="center">&nbsp;</td>
              <TD BGCOLOR="#C0C0C0"><textarea name="texto_TTES" cols="50" rows="1"></textarea></TD>
              <TD BGCOLOR="#C0C0C0" align="center">&nbsp;</TD>
              <TD BGCOLOR="#C0C0C0" align="center">&nbsp;</TD>
              <TD BGCOLOR="#C0C0C0" align="center">&nbsp;</TD>
            </TR>
            <TR>
              <TD BGCOLOR="#C0C0C0" align="center" colspan="5">&nbsp;</td>
            </TR>
            <TR>
              <TD BGCOLOR="#C0C0C0" colspan="5">Comportamento:
                <select name="seleComportamento">
                  <option value="0">Inválido</option>
                  <option value="1">Excepcional</option>
                  <option value="2">Ótimo</option>
                  <option value="3">Bom</option>
                  <option value="5">Insuficiente</option>
                  <option value="6">Mau</option>
                </SELECT></TD>
            </TR>
            <TR>
              <TD BGCOLOR="#C0C0C0" align="center" colspan="5">&nbsp;</td>
            </TR>
            <TR>
              <TD  BGCOLOR="#C0C0C0" colspan="5"><div id="comboMilitarAssina"></div></TD>
            </TR>
            <TR>
              <TD BGCOLOR="#C0C0C0" colspan="5" align="right"><input name="acao" type="button" value="" onClick="executa(this.value)" id="idacao">
                <input name="cancela" type="button" value="Cancelar" onClick="cancelar()">
              <TD>
          </table></TD>
      </TR>
    </TABLE>
  </div>
</form>
<script type="text/javascript">document.cadTemposv.seleSemestre.value = <?=$semestre?>;</script>
<br>
<br>
<br>
<br>
<a name="cadastro"></a>
<div id="erros"></div>
</center>
</body>
</html>
