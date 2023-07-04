<?
session_start();
require_once ('./filelist_geral.php');
require_once ('./filelist_funcao.php');
require_once ('./filelist_militar.php');
require_once ('./filelist_pgrad.php');
require_once ('./filelist_qm.php');
require_once ('./filelist_om.php');
$fachadaSist2 = new FachadaSist2();
$funcoesPermitidas = $fachadaSist2->lerColecaoAutorizada($_SESSION['NOMEUSUARIO'], 'X');
$apresentacao = new Apresentacao($funcoesPermitidas);
// Alterado pelo Sgt Bedin 15/08/2012 - $iniFile = new IniFile('sisbol.ini'); caminho errado. para-->
$iniFile = new IniFile('../../sisbol.ini');
$bandIniFile = new BandIniFile($iniFile);


$intervalo = 0;
$item = (isset ($_GET['item']))?($_GET['item']):0;
$intervalo = $item +20;
// Verifica se a consulta busca militares ativos ou não
$ativos = (isset($_GET['ativos']))?($_GET['ativos']):'S';
$omVinculacao = (isset($_GET['omVinculacao']))?($_GET['omVinculacao']):"0";
$codSubun = (isset($_GET['codSubun']))?($_GET['codSubun']):"0";
$codpgrad = (isset($_GET['codpgrad']))?($_GET['codpgrad']):"0";
$nomeMilitar = (isset($_GET['nomeMil']))?($_GET['nomeMil']):"";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
    "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head><title>Militares</title>
	<? $apresentacao->chamaEstilo(); ?>
	<script type="text/javascript"  src="scripts/band.js"></script>
	<script type="text/javascript">
	function novo(){
		document.getElementById("formulario").style.visibility = "visible";
		document.getElementById("novo").style.visibility = "hidden";
		document.getElementById("tituloForm").innerHTML = "Incluir";
                // PARREIRA - 21/05/2013 - retirado data atual no campo nasc.
                document.cadMilitar.data_nasc.value = "";
		/*document.cadMilitar.data_nasc.value = "<!--?=date("d/m/Y")?-->";*/
		//document.cadMilitar.id_militar.readOnly = false; // rev 05
		document.cadMilitar.antiguidade.value= '0';
		window.location.href="#cadastro";
		document.cadMilitar.id_militar.focus();
	}
	function cancelar(){
   		limpaForm(document.cadMilitar);
		document.cadMilitar.cod.value  = "";
		//document.cadMilitar.descricao.value = "";
   		document.cadMilitar.acao.value = "Incluir";
   		document.getElementById("formulario").style.visibility = "hidden";
   		document.getElementById("novo").style.visibility = "visible";
   		cinza();
   		window.location.href="#topo";
	}
	function executa(acao){
                              
                // PARREIRA 21/05/2013 - Alterado para validar campos obrigatorios
		if (document.cadMilitar.idt_militar.value == ""){
			window.alert("Informe o Idt ou RA!");
			return;
                    }
                if (document.cadMilitar.nome.value == ""){
			window.alert("Informe o Nome completo");
			return;
                    }
                if (document.cadMilitar.nome_guerra.value == ""){
			window.alert("Informe o Nome de Guerra!");
			return;
                    }   
		
                // FIM PARREIRA 21/05/2013
            
		document.cadMilitar.executar.value = acao;
		if (acao == "Excluir")  {
			if (!window.confirm("Deseja realmente excluir militar selecionado ?")){
				return ;
			}
		}

		document.cadMilitar.action = "cadmilitar.php?codpgrad="+document.cadMilitar.selePGrad.value+
									"&item=<?=$item?>"+"&omVinculacao="+document.cadMilitar.sele_om_vinc.value;
		document.cadMilitar.submit();
	}
	function carregaedit(id_militar,idt_militar,funcao_cod,om_vinc,subun,nome,data_nasc,nome_pai,nome_mae,cpf,pis_pasep,
					sexo,qm_cod,pgrad_cod,cp,prec_cp,nome_guerra,perm_pub_bi,
					cutis,olhos,cabelos,barba,altura,sinais_part,tipo_sang,fator_rh,comportamento,
					antiguidade,naturalidade,estadocivil,dataidentific,bigode,outros,assinatura,acao,IDT) {
                window.location.href="#cadastro";
                carregaSubun(om_vinc,subun);
                //document.cadMilitar.id_militar.readOnly = true; // Rev 05
		document.cadMilitar.id_militar.value = id_militar;
		document.cadMilitar.idt_militar.value = idt_militar;
		document.cadMilitar.funcao_cod.value = funcao_cod;
		document.cadMilitar.om_vinc.value = om_vinc;
		//alert(subun);
                //document.cadMilitar.sele_cad_subun.value = subun;
		document.cadMilitar.nome.value = nome;
		document.cadMilitar.nome_guerra.value = nome_guerra;
		document.cadMilitar.data_nasc.value = data_nasc;
		document.cadMilitar.nome_pai.value = nome_pai;
		document.cadMilitar.nome_mae.value = nome_mae;
		document.cadMilitar.cpf.value = cpf;
		document.cadMilitar.pis_pasep.value = pis_pasep;
		document.cadMilitar.sexo.value = sexo;
		document.cadMilitar.qm_cod.value = qm_cod;
		document.cadMilitar.selePGradForm.value = pgrad_cod;
		document.cadMilitar.cp.value = cp;
		document.cadMilitar.prec_cp.value = prec_cp;
		document.cadMilitar.cutis.value = cutis;
		document.cadMilitar.olhos.value = olhos;
		document.cadMilitar.cabelos.value = cabelos;
		document.cadMilitar.barba.value = barba;
		document.cadMilitar.altura.value = altura;
		document.cadMilitar.sinais_part.value = sinais_part;
		document.cadMilitar.tipo_sang.value = tipo_sang;
		document.cadMilitar.fator_rh.value = fator_rh;
		document.cadMilitar.comportamento.value = comportamento;
		document.cadMilitar.antiguidade.value = antiguidade;
		document.cadMilitar.naturalidade.value = naturalidade;
		document.cadMilitar.estado_civil.value = estadocivil;
		document.cadMilitar.dt_identificacao.value = dataidentific;
		document.cadMilitar.bigode.value = bigode;
		document.cadMilitar.outros.value = outros;
		//alert(assinatura); 
		if (assinatura=='./'){
			document.getElementById('imgAssinatura').style.visibility = "hidden";
			document.cadMilitar.assinatura2.value = '';
		}else{
			document.getElementById('imgAssinatura').setAttribute('src', assinatura);
			document.cadMilitar.assinatura2.value = "Tem assinatura";
		}
				
		perm_pub_bi = perm_pub_bi == ''?'N':perm_pub_bi;
		document.cadMilitar.perm_pub_bi.value = perm_pub_bi;
		document.getElementById(IDT).style.background = "#DDEDFF";
		document.cadMilitar.acao.value = acao;
   		document.getElementById("formulario").style.visibility = "visible";
   		document.getElementById("novo").style.visibility = "hidden";
   		document.getElementById("tituloForm").innerHTML = acao;
	}
	function excluirMilitar(idt,nome,identidade){
		if(window.confirm('Deseja realmente excluir:\n\n'+nome+'\nIdt: '+identidade+' ?')){
			url="ajax_cadmilitar.php?opcao=excluiPessoa&idt="+idt;
			ajaxCadMilitar(url,"divPessoa");
		}

	}
	function seleMilPGrad(){
		window.location.href="cadmilitar.php?codpgrad="+document.cadMilitar.selePGrad.value+
							"&ativos="+document.cadMilitar.seleAtivo.value+"&omVinculacao="+
							document.cadMilitar.sele_om_vinc.value+"&codSubun="+
							document.cadMilitar.sele_subun.value;
	}
	function seleSubun(){
		window.location.href="cadmilitar.php?codpgrad="+document.cadMilitar.selePGrad.value+
							"&ativos="+document.cadMilitar.seleAtivo.value+"&omVinculacao="+
							document.cadMilitar.sele_om_vinc.value+"&codSubun="+
							document.cadMilitar.sele_subun.value;
	}
	function ativaPessoa(idt){
		url="ajax_cadmilitar.php?opcao=ativaPessoa&idt="+idt;
		ajaxCadMilitar(url,"divPessoa");
	}
	function desativaPessoa(idt){
		url="ajax_cadmilitar.php?opcao=desativaPessoa&idt="+idt;
		ajaxCadMilitar(url,"divPessoa");
	}
	function ativos(ativado){
		document.cadMilitar.seleAtivo.value = ativado;
	}
	function atualizaTela(resposta){
		if(resposta !== ''){
			alert('A tentativa de exclusão falhou. \nO Sistema não pode excluir pessoas com publicações ou '+
					'alterações cadastradas.\n\nMensagem de erro: '+resposta);
			divPessoa.innerHTML = "";
		} else {
			window.location.href="cadmilitar.php?codpgrad="+document.cadMilitar.selePGrad.value+
							"&ativos="+document.cadMilitar.seleAtivo.value+"&item=<?=$item?>"+
							"&omVinculacao="+document.cadMilitar.sele_om_vinc.value+"&codSubun="+
							document.cadMilitar.sele_subun.value;
		}
	}
	function adicionaOMVinc(opcao){
		var count = document.cadMilitar.sele_om_vinc.options.length;
		option = new Option("Todas",0)
		document.cadMilitar.sele_om_vinc.options[count] = option;
		document.cadMilitar.sele_om_vinc.value = opcao;
	}
	function adicionaSubun(opcao){
		var count = document.cadMilitar.sele_subun.options.length;
		option = new Option("Todas",0)
		document.cadMilitar.sele_subun.options[count] = option;
		document.cadMilitar.sele_subun.value = opcao;
	}
	function adicionaPGrad(opcao){
		var count = document.cadMilitar.selePGrad.options.length;
		option = new Option("Todos",0)
		document.cadMilitar.selePGrad.options[count] = option;
		document.cadMilitar.selePGrad.value = opcao;
	}
	function filtroMilitar(){
		window.location.href="cadmilitar.php?codpgrad="+document.cadMilitar.selePGrad.value+
							"&ativos="+document.cadMilitar.seleAtivo.value+"&omVinculacao="+
							document.cadMilitar.sele_om_vinc.value+"&codSubun="+
							document.cadMilitar.sele_subun.value+"&nomeMil="+
                                                        document.cadMilitar.inputNomeMilitar.value;
	}
	function onChangeOMVinv(){
		url="ajax_cadmilitar.php?opcao=atualizaCmboSubun&codom="+document.cadMilitar.om_vinc.value;
		//window.alert(url);
		ajax(url,"divSubun");
	}
	function carregaSubun(om_vinc,subun){
		url="ajax_cadmilitar.php?opcao=atualizaCmboSubun&codom="+om_vinc+"&codSubun="+subun;
		//window.alert(url);
		ajax(url,"divSubun");
	}
	function capturaTecla(e){
		if(document.all){
			tecla=event.keyCode;
		}
		else
		{
		tecla=e.which;
		}
		if(tecla==13){
			//window.alert("acessei");
			filtroMilitar();
		}
	}

	document.onkeydown = capturaTecla;
	</script>
</head>
<body><a name="topo"></a>
<center>
<?
$apresentacao->chamaCabec();
$apresentacao->montaMenu();
?>

	<h3 class="titulo">&nbsp;&nbsp;<img src="./imagens/item_dir.gif" alt="Cadastro de Militares">&nbsp;Cadastro de Militares <img src="imagens/ajuda.png" width="14" height="14" alt="Ajuda" onClick="ajuda('cadMilitar')" onMouseOver="this.style.cursor='help';" onMouseOut="this.style.cursor='default';"></h3>
  <p>&nbsp;</p>
    
	<form action="" method="post" name="cadMilitar" enctype="multipart/form-data">
	<table width="800" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="left"><div id="divPessoa"></div></td>
	<td align="left">
	<?php

if (isset ($_POST['executar'])) {
	$dataNasc = trim($_POST['data_nasc']);
	$dataNasc = explode("/", $dataNasc);
	$dataNasc = $dataNasc[2] . "-" . $dataNasc[1] . '-' . $dataNasc[0];

	if (isset ($_POST['dt_identificacao'])) {
		$dataIdt = trim($_POST['dt_identificacao']);
		$dataIdt = explode("/", $dataIdt);
		$dataIdt = $dataIdt[2] . "-" . $dataIdt[1] . "-" . $dataIdt[0];
	} else {
		$dataIdt = null;
	}

	$PGrad = $fachadaSist2->lerPGrad($_POST['selePGradForm']);
	$QM = $fachadaSist2->lerQM($_POST['qm_cod']);
	$Funcao = $fachadaSist2->lerFuncao($_POST['funcao_cod']);
	$OmVinc = $fachadaSist2->lerOMVinc($_POST['om_vinc']);
	$subun = $fachadaSist2->lerSubun($_POST['om_vinc'],$_POST['sele_cad_subun']);
	//print_r($subun);

	$Militar = new Militar($PGrad, $QM, $Funcao, new MinhaData($dataNasc), $OmVinc, $subun);
	$Militar->setIdMilitar($_POST['id_militar']);
	$Militar->setIdtMilitar($_POST['idt_militar']);

	$Militar->setNome($_POST['nome']);
	$Militar->setDataNasc($dataNasc);
	$Militar->setNomePai($_POST['nome_pai']);
	$Militar->setNomeMae($_POST['nome_mae']);
	$Militar->setCPF($_POST['cpf']);
	$Militar->setPisPasep($_POST['pis_pasep']);
	$Militar->setSexo($_POST['sexo']);
	$Militar->setCP($_POST['cp']);
	$Militar->setPrecCP($_POST['prec_cp']);
	$Militar->setNomeGuerra($_POST['nome_guerra']);
	$Militar->setPermPubBI($_POST['perm_pub_bi']);
	$Militar->setCutis($_POST['cutis']);
	$Militar->setOlhos($_POST['olhos']);
	$Militar->setCabelos($_POST['cabelos']);
	$Militar->setBarba($_POST['barba']);
	$Militar->setAltura($_POST['altura']);
	$Militar->setSinaisParticulares($_POST['sinais_part']);
	$Militar->setTipoSang($_POST['tipo_sang']);
	$Militar->setFatorRH($_POST['fator_rh']);
	$Militar->setComportamento($_POST['comportamento']);
	$Militar->setAntiguidade($_POST['antiguidade']);
	$Militar->setNaturalidade($_POST['naturalidade']);
	$Militar->setEstadoCivil($_POST['estado_civil']);

	$Militar->setDataIdt($dataIdt);

	$Militar->setBigode($_POST['bigode']);
	$Militar->setOutros($_POST['outros']);
	//print_r($_FILES);
	//echo "<br>".$bandIniFile->getAssinaturaDir();
	$Militar->setAssinatura($_FILES['assinatura']['name']);
	if (!move_uploaded_file($_FILES["assinatura"]["tmp_name"], $bandIniFile->getAssinaturaDir().$_FILES['assinatura']['name'])) 
		//echo "Arquivo não movido..."; - PARREIRA - Msg retirada
                echo "";
	//print_r($Militar);
	if ($_POST['executar'] == 'Incluir') {
		$Militar->setIdMilitar($_POST['idt_militar']); // rv 05
		$fachadaSist2->incluirMilitar($Militar);
	}
	if ($_POST['executar'] == 'Alterar') {
		$fachadaSist2->alterarMilitar($Militar);
	}
}
/*Listar os Postos e Graduações*/
$colPGrad2 = $fachadaSist2->lerColecaoPGrad('cod');
$pGrad = $colPGrad2->iniciaBusca1();

/*Listar as funções*/
$colFuncao2 = $fachadaSist2->lerColecaoFuncao('cod');
$Funcao = $colFuncao2->iniciaBusca1();

/*Listar OM vinculadas*/
$colOmVinc2 = $fachadaSist2->lerColecaoOmVinc('nome');
$OmVinc = $colOmVinc2->iniciaBusca1();
//if ($omVinculacao == "0") $omVinculacao = $OmVinc->getCodOM();

/*Listar Subunidades*/
$colSubun2 = $fachadaSist2->lerColecaoSubun($omVinculacao);
$subun = $colSubun2->iniciaBusca1();

/*Listar as QM*/
$colQM2 = $fachadaSist2->lerColecaoQM('cod');
$pQM = $colQM2->iniciaBusca1();

/* Se estiver setada um posto/graduação*/
//if (isset ($_GET['codpgrad'])) {
//	$codpgrad = $_GET['codpgrad'];
//} else {
	//$codpgrad = $pGrad->getCodigo();
//}



echo "</TD></TR></table>";
$location = "cadmilitar.php?codpgrad=" . $codpgrad . "&ativos=" . $ativos . "&item=" . $item . "&omVinculacao=".$omVinculacao;
echo '<B>LISTAR POR: </B>&nbsp;&nbsp;&nbsp;Om Vinculada: ';
$apresentacao->montaCombo('sele_om_vinc', $colOmVinc2, 'getCodOM', 'getSigla', $omVinculacao, 'seleMilPGrad()');
echo '<script type="text/javascript">adicionaOMVinc("'.$omVinculacao.'")</script>';
echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Subunidade/Divisão/Seção: ';
$apresentacao->montaCombo('sele_subun', $colSubun2, 'getCod', 'getSigla', $codSubun, 'seleSubun()');
echo '<script type="text/javascript">adicionaSubun("'.$codSubun.'")</script>';
echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ativado:&nbsp;<select name="seleAtivo" onchange="seleMilPGrad()">
					<option value="S">Sim</option>
					<option value="N">Não</option>
					<option value="T">Todos</option>
			  </select>&nbsp;&nbsp;<script type="javascript/text">ativos("' . $ativos . '")</script>';
echo '</td></tr><tr><td colspan="2" align="left">&nbsp;&nbsp;

<p>
         Posto/Grad: ';
$apresentacao->montaCombo('selePGrad', $colPGrad2, 'getCodigo', 'getDescricao', $codpgrad, 'seleMilPGrad()');
echo '<script>adicionaPGrad("'.$codpgrad.'")</script>';

// Buscar a lista de militares
$sqlAtivo = '';
if (($ativos == 'S') or ($ativos == 'N')) {
	$sqlAtivo = " and p.perm_pub_bi = '" . $ativos . "'";
}
$sqlOMVinc = ($omVinculacao != "0")?" and p.codom = '". $omVinculacao ."' ":"";
$sqlSubun = ($codSubun != 0)?" and p.cod_subun = ". $codSubun ." ":"";
$sqlPGrad = ($codpgrad != 0)?" and m.pgrad_cod = ". $codpgrad ." ":"";
$sqlNomeMilitar = ($nomeMilitar!="")?" and p.nome like '%". $nomeMilitar ."%' ":"";
//echo $sqlOMVinc;

//$colMilitar2 = $fachadaSist2->lerColecaoMilitar(" m.antiguidade, p.nome", "and m.pgrad_cod = '" .
//$codpgrad . "' " . $sqlAtivo . $sqlOMVinc);
$colMilitar2 = $fachadaSist2->lerColecaoMilitar(" m.antiguidade, p.nome", $sqlPGrad . $sqlAtivo . $sqlOMVinc . $sqlSubun  . $sqlNomeMilitar);
$Militar = $colMilitar2->iniciaBusca1();
//print_r($Militar);
$total = $colMilitar2->getQTD();
// Implementa a paginação caso a listagem tenha mais que 20 ítens
echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nome:
        &nbsp;<input name="inputNomeMilitar" type="text" maxlenght="40" size="45">
        &nbsp;&nbsp;<input type="button" value="Buscar" onClick="filtroMilitar()">';
echo '</td></tr><tr><td colspan="2" align="right">&nbsp;&nbsp;';
if ($total > 20) {
	echo "&nbsp;&nbsp;&nbsp;<br>";
	//echo $total;
	$apresentacao->montaComboPag($total, $item, $selected, $location);
}
?>
            
        <table width="75%" border="0" >
	<TR><TD align="left"><a href="javascript:novo()" id="novo">
	<img src="./imagens/add.png" border=0 alt="Adicionar">&nbsp;<FONT COLOR="#0080C0">Adicionar</FONT></a></TD></table><p>
            
	</TD></TR></table>
	<table width="75%" border="0" cellspacing="0" cellpadding="0" class="lista"><tr><td>
	<table width="100%" border="0" cellspacing="1" cellpadding="0">
	<tr class="cabec">
		<td width="5%"><div align="center"><strong><font size="2">Ord</font></strong></div></td>
		<td width="12%" align="center"><strong><font size="2">Idt/RA</font></strong></td>
		<td width="10%" align="center"><strong><font size="2">OM Vinc</font></strong></td>
		<td width="10%" align="center"><strong><font size="2">SU/Div</font></strong></td>
		<td width="8%" align="center"><strong><font size="2">P/Grad</font></strong></td>
		<td width="35%" align="center"><strong><font size="2">Nome</font></strong></td>
		<td width="5%"><div align="center"><strong><font size="2">Ant</font></strong></div></td>
		<td width="5%"><div align="center"><strong><font size="2">Sit</font></strong></div></td>
		<td width="8%" align="center"><strong><font size="2">Ação</font></strong></td>
	</tr>
	<?


$ord = 0;
/*Instanciar QM pois so tenho o código e preciso da descrição*/
//$pQM = new QM();
$items_lidos = 0;

while ($Militar != null) {
	//if ($codpgrad === $Militar->getPGrad()->getCodigo()) {
		/* Capturando a descrição da QM*/
		$ord++;
		if ($ord > $item) {
			$pQM = $fachadaSist2->lerQM($Militar->getQM()->getCod());
			$pGrad = $fachadaSist2->lerPGrad($Militar->getPGrad()->getCodigo());
//			$nomeGuerra = $Militar->getNomeGuerra();
			$nomeGuerra = strtoupper(strtr($Militar->getNomeGuerra(),'áéíóúãõâêôçäëïöü','ÁÉÍÓÚÃÕÂÊÔÇÄËÏÖÜ'));
//			$nomeMilitar = $Militar->getNome();
			$nomeMilitar = strtoupper(strtr($Militar->getNome(),'áéíóúãõâêôçäëïöü','ÁÉÍÓÚÃÕÂÊÔÇÄËÏÖÜ'));

                        echo '<tr id=' . $ord . ' onMouseOut="outLinha(' . $ord . ')" onMouseOver="overLinha(' . $ord . ')" bgcolor="#F5F5F5"> <td align="center">' . $ord . '</TD>';
			echo '<TD align="left">&nbsp;' . $Militar->getIdtMilitar() . '</TD>';
			echo '<TD align="center">' .$Militar->getOmVinc()->getSigla().'</TD>';
			echo '<TD align="center">' .$Militar->getSubun()->getSigla().'</TD>';
			echo '<TD align="center">' .$pGrad->getDescricao().'</TD>';
			//echo '<br>'.$Militar->exibeDados().'<br>';
			echo '<TD>' . $apresentacao->setaNomeGuerra($nomeMilitar, $nomeGuerra) . '</TD>';
			/*echo '<TD>'
			  .$Militar->getNome().'</TD>';*/
			echo '<TD align="right">' . $Militar->getAntiguidade() . '&nbsp;&nbsp;</TD>';
			echo '<TD align="center">' . ($Militar->getPermPubBI() == "S" ? "<a href='javascript:desativaPessoa(\"" . $Militar->getIdMilitar() . "\")'><img src='./imagens/check.gif' border='0' title='Clique para desativar'></a>" : "<a href='javascript:ativaPessoa(\"" . $Militar->getIdMilitar() . "\")'><img src='./imagens/naprovada.png'  border='0' title='Clique para ativar'></a>") . '</TD>';
			//echo '<TD align="center">'.($Militar->getPermPubBI()=="S"?"<a href='javascript:desativaPessoa(\"".$Militar->getIdMilitar()."\")'><img src='./imagens/check.gif' border='0'></a>":"<a href='javascript:ativaPessoa(\"".$Militar->getIdMilitar()."\")'><img src='./imagens/desative.gif'  border='0'></a>").'</TD>';
			echo '<td align="center">';

			//verifica permissao para alterar
			if ($_SESSION['NOMEUSUARIO'] != 'supervisor') {
				$mAlterar = $funcoesPermitidas->lerRegistro(1032);
			}
			if (($mAlterar != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor')) {
				echo '<a href="javascript:carregaedit(\'' . $Militar->getIdMilitar() . '\',\'' . $Militar->getIdtMilitar() . '\','.
				$Militar->getFuncao()->getCod() . ',\'' .
                                $Militar->getOmVinc()->getCodOM() . '\',' .
                                $Militar->getSubun()->getCod() . ',\'' .
				$Militar->getNome() . '\',\'' .
				$Militar->getDataNasc()->GetcDataDDBMMBYYYY() . '\',\'' . $Militar->getNomePai() . '\',\'' .
				$Militar->getNomeMae() . '\',\'' . $Militar->getCPF() . '\',\'' .
				$Militar->getPisPasep() . '\',\'' . $Militar->getSexo() . '\',\'' .
				$Militar->getQM()->getCod() . '\',' . $Militar->getPGrad()->getCodigo() . ',\'' .
				$Militar->getCP() . '\',\'' . $Militar->getPrecCP() . '\',\'' .
				$Militar->getNomeGuerra() . '\',\'' . $Militar->getPermPubBI() . '\',\'' .
				$Militar->getCutis() . '\',\'' .
				$Militar->getOlhos() . '\',\'' . $Militar->getCabelos() . '\',\'' .
				$Militar->getBarba() . '\',\'' . $Militar->getAltura() . '\',\'' .
				$Militar->getSinaisParticulares() . '\',\'' . $Militar->getTipoSang() . '\',\'' .
				$Militar->getFatorRH() . '\',\'' . $Militar->getComportamento() . '\',' .
				$Militar->getAntiguidade() . ',\'' . $Militar->getNaturalidade() . '\',\'' .
				$Militar->getEstadoCivil() . '\',\'' .
				$Militar->getDataIdt() . '\',\'' .
				$Militar->getBigode() . '\',\'' .
				$Militar->getOutros() . '\',\'' .
				"./".$Militar->getAssinatura() .
				'\',\'Alterar\',' . $ord . ')"><img src="./imagens/alterar.png" title="Alterar" border=0></a>';
			}
			//verifica permissao para excluir
			if ($_SESSION['NOMEUSUARIO'] != 'supervisor') {
				$mExcluir = $funcoesPermitidas->lerRegistro(1033);
			}
			if (($mExcluir != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor')) {
				if (($mAlterar != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor')) {
					echo '&nbsp;|&nbsp';
				}
				echo '<a href="javascript:excluirMilitar(\'' . $Militar->getIdMilitar() . '\',\'' .
				$Militar->getNome() . '\',\'' . $Militar->getIdtMilitar() . '\')"><img src="./imagens/excluir.png" border=0 title="Excluir"></a>';
			}
			//echo '&nbsp;|&nbsp';
			echo '</td></tr>';
		}
	//}
	$Militar = $colMilitar2->getProximo1();
	$items_lidos++;
	if ($items_lidos >= $intervalo) {
		break;
	}
}
?>
</tr></table></td></tr></table>

<?php


//verifica permissao para incluir
if ($_SESSION['NOMEUSUARIO'] != 'supervisor') {
	$mIncluir = $funcoesPermitidas->lerRegistro(1031);
}
if (($mIncluir != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor')) {
	echo '<table width="75%" border="0" >';
	echo '<TR>';
	/*echo '<TD align="left"><a href="javascript:novo()" id="novo">';
	echo '<img src="./imagens/seta_dir.gif" border=0>&nbsp;<FONT COLOR="#0080C0">';
	echo 'Adicionar</FONT></a>';*/
	//echo '</TD>';
	echo '<TD align="right" valign="center">Legenda:&nbsp;&nbsp;';
	echo '<img src="./imagens/alterar.png" title="Alterar" border=0>&nbsp;Alterar&nbsp;';
	echo '<img src="./imagens/excluir.png" title="Alterar" border=0>&nbsp;Excluir&nbsp;';
	echo '<img src="./imagens/check.gif" title="Alterar" border=0>&nbsp;Ativado&nbsp;';
	echo '<img src="./imagens/naprovada.png" title="Alterar" border=0>&nbsp;Desativado&nbsp;';
	echo '</TD>';
	echo '</TR>';
	echo '</TABLE>';
}
?>

	<input name="executar" type="hidden" value="">
	<input name="cod" type="hidden" value="">
	<div id="formulario" STYLE="VISIBILITY:hidden">
	<a name="cadastro"></a>
        <br>
	<TABLE width="850" border="0" class="formulario" CELLPADDING="1" CELLSPACING="0">
        <TR><TD align="center">
	<TABLE width="100%" border="0" BORDERCOLOR="#C0C0C0" BORDERCOLORLIGHT="#C0C0C0"
				CELLSPACING="0" CELLPADDING="1" name="tabela">
	<TR CLASS="cabec"><TD><font size="2"><div id="tituloForm"></div></font></TD></TR>
	<TD BGCOLOR="#C0C0C0" colspan="3">&nbsp;</TD>
	</TR>
        <TR><TD BGCOLOR="#C0C0C0" colspan="3">&nbsp;&nbsp;Idt/RA(*):
	<input name="id_militar" type="hidden" value="" maxlength="15" size="15">
	<input name="idt_militar" type="TEXT" value="" maxlength="15" size="15" >
	&nbsp;&nbsp;Nome completo(*): <input name="nome" type="TEXT" value="" maxlength="70" size="65" >
	&nbsp;&nbsp;Antiguidade(*): <input name="antiguidade" type="TEXT" maxlength="4" size="3">
        </TD></TR>
        <TR><TD BGCOLOR="#C0C0C0" colspan="3">&nbsp;</TD></TR>
        <TR><TD BGCOLOR="#C0C0C0" colspan="3">
        &nbsp;&nbsp;Posto/Grad:&nbsp;
	<?
            $pGrad = $colPGrad2->iniciaBusca1();
            $apresentacao->montaCombo('selePGradForm', $colPGrad2, 'getCodigo', 'getDescricao', $codpgrad, '');
        ?>
        &nbsp;&nbsp;Nome de Guerra (*): <input name="nome_guerra" type="TEXT" maxlength="30" size="35">
	&nbsp;&nbsp;OM Vinculação:&nbsp;
        <?
            $apresentacao->montaCombo('om_vinc', $colOmVinc2, 'getCodOM', 'getSigla', $omVinculacao, 'onChangeOMVinv()');
        ?>
        </TD></TR>
        <TR><TD BGCOLOR="#C0C0C0" colspan="3">&nbsp;</TD></TR>
        <TR><TD BGCOLOR="#C0C0C0" width="10%">
	&nbsp;&nbsp;SU/Divisão/Seção:&nbsp;<!-- PARREIRA 28-05-2013 /TD>
        <TD BGCOLOR="#C0C0C0" width="30%"--><div id="divSubun">
        <? 
            if ($omVinculacao == "0")
			{
                $omVinculacao = $OmVinc->getCodOM();
                $colSubun2 = $fachadaSist2->lerColecaoSubun($omVinculacao);
                $subun = $colSubun2->iniciaBusca1();
                $codSubun = $subun->getCod();
            } 
            $apresentacao->montaCombo('sele_cad_subun', $colSubun2, 'getCod', 'getSigla', $codSubun, '');
        ?>
        </div>
        </TD><TD BGCOLOR="#C0C0C0">
	&nbsp;&nbsp;Função:&nbsp;
	<?$apresentacao->montaCombo('funcao_cod', $colFuncao2, 'getCod', 'getDescricao', $codfuncao, '');
        ?>
	&nbsp;&nbsp;Comport.:&nbsp;
	<!-- Domínio do Módulo E1 1-Excepcional;2-Ótimo;3-Bom;5-Insuficiente;6-Mau-->
	<select name="comportamento">
		<option value="0">Inválido</option>
		<option value="1">Excepcional</option>
		<option value="2">Ótimo</option>
		<option value="3">Bom</option>
		<option value="5">Insuficiente</option>
		<option value="6">Mau</option>
	</select>
        </TD></TR>
        <TR><TD BGCOLOR="#C0C0C0" colspan="3">&nbsp;</TD></TR>
        <TR><TD BGCOLOR="#C0C0C0" colspan="3">
                &nbsp;&nbsp;QM:&nbsp;
        	<?
                    $apresentacao->montaCombo('qm_cod', $colQM2, 'getCod', 'getDescricao', $codqm, '');
                ?>
               	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ativado:
                    <select name="perm_pub_bi">
			<option value="S">Sim</option><option value="N">Não</option>
		  </select>
            </TD>
	</TR>
        <TR><TD BGCOLOR="#C0C0C0" colspan="3">&nbsp;</TD></TR>
        <TR><TD BGCOLOR="#C0C0C0" colspan="3">
	&nbsp;&nbsp;CP:&nbsp;<input name="cp" type="TEXT" value="" maxlength="7" size="7">
	&nbsp;&nbsp;Prec-CP:&nbsp;<input name="prec_cp" type="TEXT" value="" maxlength="12" size="12">
	&nbsp;&nbsp;CPF:&nbsp;<input name="cpf" type="TEXT" value="" maxlength="15" size="15">
	&nbsp;&nbsp;PIS/PASEP:&nbsp;<input name="pis_pasep" type="TEXT" value="" maxlength="15" size="20">
        &nbsp;&nbsp;Data de Identificação:&nbsp;<input name="dt_identificacao" type="TEXT" value="" maxlength="10" size="10" onBlur="validaData(this)"></TD>
        </TD></TR>
        <TR><TD BGCOLOR="#C0C0C0" colspan="3">&nbsp;</TD></TR>
        <TR><TD BGCOLOR="#C0C0C0" colspan="3">
	&nbsp;&nbsp;Data Nasc.(DD/MM/AAAA):&nbsp;<input name="data_nasc" type="TEXT" value="" maxlength="10" size="10" onBlur="validaData(this)">
	&nbsp;&nbsp;Sexo:&nbsp;<select name="sexo">
			<option value="M">Masc</option><option value="F">Fem</option>
              </select>
	&nbsp;&nbsp;Naturalidade:&nbsp;<input name="naturalidade" type="TEXT" value="" maxlength="35" size="30">
        &nbsp;&nbsp;Estado Civil:&nbsp;<input name="estado_civil" type="TEXT" value="" maxlength="25" size="15">
		</SELECT>
	</TD></TR>
        <TR><TD BGCOLOR="#C0C0C0" colspan="3">&nbsp;</TD></TR>
        <TR><TD BGCOLOR="#C0C0C0" colspan="3">
                &nbsp;&nbsp;Nome do Pai:&nbsp;<input name="nome_pai" type="TEXT" value="" maxlength="55" size="51">
                &nbsp;&nbsp;Nome da Mãe:&nbsp;<input name="nome_mae" type="TEXT" value="" maxlength="55" size="51"></TD>
	</TR>
        <TR><TD BGCOLOR="#C0C0C0" colspan="3">&nbsp;</TD></TR>
        <TR><TD BGCOLOR="#C0C0C0" colspan="3">
                &nbsp;&nbsp;Cútis:&nbsp;<input name="cutis" type="TEXT" value="" maxlength="10" size="10">
		&nbsp;&nbsp;Olhos:&nbsp;<input name="olhos" type="TEXT" value="" maxlength="20" size="20">
		&nbsp;&nbsp;Cabelos:&nbsp;<input name="cabelos" type="TEXT" value="" maxlength="20" size="20">
		&nbsp;&nbsp;Bigode:&nbsp;<input name="bigode" type="TEXT" value="" maxlength="30" size="23">
                &nbsp;&nbsp;Altura:&nbsp;<input name="altura" type="TEXT" maxlength="5" size="6">
		</TD></TR>
        <TR><TD BGCOLOR="#C0C0C0" colspan="3">&nbsp;</TD></TR>
        <TR><TD BGCOLOR="#C0C0C0" colspan="3">
                &nbsp;&nbsp;Barba:&nbsp;<input name="barba" type="TEXT" maxlength="20" size="20">
		&nbsp;&nbsp;Sinais Part.:&nbsp;<input name="sinais_part" type="TEXT" value="" maxlength="50" size="52">
		&nbsp;&nbsp;Tipo Sang:&nbsp;<select name="tipo_sang">
					<option value="O">O</option><option value="A">A</option>
					<option value="B">B</option><option value="AB">AB</option><option value="NN">NN</option>
				  </select>
		&nbsp;&nbsp;Fator RH:&nbsp;<select name="fator_rh">
					<option value="P">P</option><option value="N">N</option>
				  </select>
            </TD></TR>
        <TR><TD BGCOLOR="#C0C0C0" colspan="3">&nbsp;</TD></TR>
        <TR><TD BGCOLOR="#C0C0C0" width="10%" valign="top">
	&nbsp;&nbsp;Outros.....................:&nbsp;</TD>
        <TD BGCOLOR="#C0C0C0" colspan="2">
                <TEXTAREA name="outros" COLS="85"></TEXTAREA>
		</TD>
		</TR>
        <TR><TD BGCOLOR="#C0C0C0" colspan="3">&nbsp;</TD></TR>
        <TR><TD BGCOLOR="#C0C0C0" width="10%" valign="top">
	&nbsp;&nbsp;Assinatura.....................:&nbsp;<br />&nbsp;&nbsp;(* Imagem JPG ou PNG)</TD>
        <TD BGCOLOR="#C0C0C0" valign="top">
			<input name="assinatura" type="file">
			<input name="assinatura2" type="hidden" value="" size="50">
		</TD>
        <TD BGCOLOR="#C0C0C0" valign="top">
			<img id="imgAssinatura" src="">
		</TD>
		</TR>		
		
		<TR>
			<TD BGCOLOR="#C0C0C0" align="right" COLSPAN="3"><br>
			<input name="acao" type="button" value="Incluir" onClick="executa(this.value)">
			<input name="cancela" type="button" value="Cancelar" onClick="cancelar()"><TD>
		</TR></table>
		</TD></TR></TABLE>
		</div>
	</form>
<script>document.cadMilitar.inputNomeMilitar.focus();</script>
</center>
</body>
</html>
