<? 	session_start();
	require_once('./filelist_geral.php');
	require_once('./filelist_boletim.php');
	require_once('./filelist_assunto.php');
	require_once('./filelist_tipodoc.php');
	require_once('./filelist_funcao.php');
	require_once('./filelist_militar.php');
	require_once('./filelist_pgrad.php');
	require_once('./filelist_qm.php');
	require_once('./filelist_om.php');
	require_once('./filelist_usuariofuncaotipobol.php');
	$fachadaSist2 = new FachadaSist2();

    $funcoesPermitidas = $fachadaSist2->lerColecaoAutorizada($_SESSION['NOMEUSUARIO'],'X');
    $bIncluiAssunto = 0; 			// Se 0 não permitir a criação de novo assunto geral ou especifico
	if ($_SESSION['NOMEUSUARIO'] == 'supervisor') {
		$bIncluiAssunto = 1;
	} elseif (($funcoesPermitidas->lerRegistro(1101) != null)&&(($funcoesPermitidas->lerRegistro(1101) != null))) {
		$bIncluiAssunto = 1;
	}

	//echo $bIncluiAssunto; //
	$apresentacao = new Apresentacao($funcoesPermitidas);
	// Qual tab dever ser mostrada
	$tab = isset($_GET['tab'])?$_GET['tab']:1;

	// Se for para carregar uma materia ja cadastrada
	if(isset($_GET['codMateriaBIAtual'])){
		$buscaMateria = true;
		$codMateriaBIAtual = $_GET['codMateriaBIAtual'];
		//echo 'Editando materia BI nr:'.$codMateriaBIAtual;
		$titulo = "Alterar Matéria para:";
	} else {
		$buscaMateria = false;
		$titulo = "Lançar Matéria para:";
	}

	if(isset($_GET['codTipoBol'])){
		$codTipoBol = $_GET['codTipoBol'];
		$TipoBoletim = $fachadaSist2->lerTipoBol($codTipoBol);
	}
	if(isset($_GET['idtMilAss'])){
		$idtMilAss = $_GET['idtMilAss'];
	}
?>

<html>
<head>
	<? $apresentacao->chamaEstilo(); ?>

	<script>
		var ol_vauto = 1;
		var idMilitarAss = null;
	</script>
	<script type="text/javascript" src="scripts/band.js"></script>
	<script type="text/javascript" src="scripts/tabber.js"></script>
	<script type="text/javascript" src="scripts/datetimepicker.js"></script>
	<script type="text/javascript" src="../fckeditor/fckeditor.js"></script>
	<script type="text/javascript" src="scripts/jquery.accordion.js"></script>
	<script src="scripts/overlib.js"></script>
	<script src="scripts/msg_hints.js"></script>
	<script>
	var oFCKAbert = new FCKeditor( 'texto_abert' ) ;
	var oFCKFech  = new FCKeditor( 'texto_fech' ) ;
	var oFCKIndiv  = new FCKeditor( 'texto_indiv' ) ;
	document.write('<style type="text/css">.tabber{display:none;}<\/style>');


	var tabberOptions = {
		'manualStartup':true,
	    'onLoad': function(argsObj) {
	    if (argsObj.tabber.id == 'tab2') {
    	  alert('Finished loading tab2!');
    }
  },

  'onClick': function(argsObj) {

    var t = argsObj.tabber; /* Tabber object */
    var id = t.id; /* ID of the main tabber DIV */
    var i = argsObj.index; /* Which tab was clicked (0 is the first tab) */
    var e = argsObj.event; /* Event object */

    if (id == 'tab2') {
      return confirm('Swtich to '+t.tabs[i].headingText+'?\nEvent type: '+e.type);
    }
  },
  'addLinkId': true

};
	// É chamado via ajax.js para preenchimento do editor FCKEditor
	function InsertHTML(conteudo){
		var oEditorAbert = FCKeditorAPI.GetInstance('texto_abert') ;
		var oEditorFech = FCKeditorAPI.GetInstance('texto_fech') ;
		var oEditorIndiv = FCKeditorAPI.GetInstance('texto_indiv') ;

		vaiAltr 	= conteudo.substring(0,1);
		abertura 	= conteudo.substring(1,conteudo.indexOf('$wxxw$'));
		fechamento 	= conteudo.substring(conteudo.indexOf('$wxxw$') + 6,conteudo.length);
		individual  = conteudo.substring(conteudo.indexOf('$wyyw$') + 6,conteudo.length);
		oEditorAbert.SetHTML(abertura);
		oEditorFech.SetHTML(fechamento);
		oEditorIndiv.SetHTML(individual);
		document.cadMateriaBI.vai_altr.checked = (vaiAltr == 'S'? true: false);
	}

	function onChangeParteBi(){
		url="ajax_materia_bi.php?opcao=secaoBI&numeroParteAtual="+document.cadMateriaBI.seleParteBi.value;
		//window.alert(url);
		document.cadMateriaBI.inputAssuntoGeral.value = "";
		document.getElementById("divAssuntoGeral").innerHTML = '';
		document.cadMateriaBI.inputAssuntoGeral.value = "";
		document.getElementById("divAssuntoGeral").innerHTML = '';
		document.getElementById("divAssuntoEspecifico").innerHTML = '';
		//document.getElementById("divTextoAbertura").innerHTML = '';
		document.cadMateriaBI.texto_abert.value =  '';
		document.cadMateriaBI.texto_fech.value =  '';
		document.cadMateriaBI.inputAssuntoEspecifico.value = '';
		ajax(url,"divSecaoParteBI");
	}

	function onchangeSecao(){
		document.cadMateriaBI.inputAssuntoGeral.value = "";
		document.getElementById("divAssuntoGeral").innerHTML = '';
		document.getElementById("divAssuntoEspecifico").innerHTML = '';
		//document.getElementById("divTextoAbertura").innerHTML = '';
		document.cadMateriaBI.texto_abert.value =  '';
		document.cadMateriaBI.texto_fech.value =  '';
		document.cadMateriaBI.inputAssuntoEspecifico.value = '';
	}

	function listaGeral(evento){
		if(isEnterKey(evento)){
			//alert(evento);
			listaAssuntoGeralLike(document.subscribe.textBusca.value);
			//return false;
		}
		if(isEscKey(evento)){
			escondeFly();
		}
	}
	function listaEspecifico(evento){
		if(isEnterKey(evento)){
			//alert(evento);
			listaAssuntoEspecificoLike(document.subscribe.textBusca.value);
			//return false;
		}
		if(isEscKey(evento)){
			escondeFly();
		}
	}
	function buscaAssuntoGeral(textoBuscado){
		document.cadMateriaBI.codTipoBol.value = <?=$codTipoBol?>;
		document.getElementById("subscrForm").style.left = 5 + "px";
		document.getElementById("flyframe").style.visibility = "visible";
		document.getElementById("subscrForm").style.visibility = 'visible';
		listaAssuntoGeralLike(textoBuscado);
		document.getElementById('buscador').innerHTML =
			'<table width="100%" border="0" class="lista"><tr><td><font size="3" color="yellow"><b>Busca Assunto Geral</b></font></td></tr></table>' +
			'<br>Buscar:<input type="text" id="busca" name="textBusca" size="60"  onKeyDown="listaGeral(event)">'+
			'<input type="complemento" id="teste" name="testebusca" size="0" maxlenght="0" style="width:0px;">'+
			'<input type="button" value="Buscar" onclick="listaAssuntoGeralLike(document.subscribe.textBusca.value)">'+
			'<input type="button" value="Novo Assunto Geral" onclick="novoAssuntoGeral(\'\')" <?=($bIncluiAssunto == 0?'DISABLED':'')?>>'+
			'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="Fechar" onclick="escondeFly()">';
		document.getElementById('busca').focus();
	}
	function novoAssuntoGeral(textoBuscado){
		url = '<iframe WIDTH="730" HEIGHT="300" src="ajax_materia_bi.php?opcao=novoAssuntoGeral&numeroParteAtual='+document.cadMateriaBI.seleParteBi.value+
			'&numeroSecaoAtual='+document.cadMateriaBI.seleSecaoParteBi.value+'&codTipoBol='+document.cadMateriaBI.codTipoBol.value+'">';
		document.getElementById('textoForm').innerHTML = url;
	}
	function novoAssuntoEspecifico(textoBuscado){
		url = '<iframe WIDTH="730" HEIGHT="300" src="ajax_materia_bi.php?opcao=novoAssuntoEspecifico&numeroParteAtual='+document.cadMateriaBI.seleParteBi.value+
				'&numeroAssuntoGeral=' + document.cadMateriaBI.inputCodAssGeral.value+
				'&numeroSecaoAtual=' + document.cadMateriaBI.seleSecaoParteBi.value+'">';
		//alert(url);
		document.getElementById('textoForm').innerHTML = url;

	}

	function listaAssuntoGeralLike(textoBuscado){
		url = '<iframe WIDTH="730" HEIGHT="300" src="ajax_materia_bi.php?opcao=assuntoGeral&numeroParteAtual='+document.cadMateriaBI.seleParteBi.value+
			'&numeroSecaoAtual='+document.cadMateriaBI.seleSecaoParteBi.value+'&codTipoBol='+document.cadMateriaBI.codTipoBol.value+
			'&like='+textoBuscado+'">';
		//alert(url);
		
		document.getElementById('textoForm').innerHTML = url;
	}
	function buscaAssuntoEspecifico(textoBuscado){
		if(document.cadMateriaBI.inputAssuntoGeral.value=="") {
			window.alert('Você precisa selecionar o Assunto Geral.\n O Sistema chamará a janela de seleção do Assunto Geral.');
			buscaAssuntoGeral('');
			return;
		}
		document.getElementById("subscrForm").style.left = 5 + "px";
		document.getElementById("flyframe").style.visibility = "visible";
		document.getElementById("subscrForm").style.visibility = 'visible';
		listaAssuntoEspecificoLike(textoBuscado);
		document.getElementById('buscador').innerHTML = '<table width="100%" border="0" class="lista"><tr><td><font size="3" color="yellow"><b>'+
			'Busca Assunto Específico</b></font></td></tr></table>' +
			'<br>Buscar: <input type="text" id="textBusca" name="textBusca" size="60"  onKeyDown="listaEspecifico(event)">'+
			'<input type="complemento" id="teste" name="testebusca" size="0" maxlenght="0" style="width:0px;">'+
			'<input type="button" value="Buscar" onclick="listaAssuntoEspecificoLike(document.subscribe.textBusca.value)">'+
			'<input type="button" value="Novo Assunto Específico" onclick="novoAssuntoEspecifico(\'\')" <?=($bIncluiAssunto == 0?'DISABLED':'')?>>'+
			'&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="Fechar" onclick="escondeFly()">';
		document.getElementById('textBusca').focus();
	}

	function listaAssuntoEspecificoLike(textoBuscado){
		url = '<iframe WIDTH="730" HEIGHT="300" src="ajax_materia_bi.php?opcao=assuntoEspecifico&acao=montaCombo&assuntoGeral='
				+document.cadMateriaBI.inputCodAssGeral.value+
				'&like='+textoBuscado+'">';
		document.getElementById('textoForm').innerHTML = url;
	}


	function setaAssuntoGeral(cod,descricao){
		document.cadMateriaBI.inputAssuntoGeral.value = html_entity_decode(descricao);
		document.cadMateriaBI.inputCodAssGeral.value = cod;
		document.getElementById("divAssuntoGeral").innerHTML = '';
		document.getElementById("divAssuntoEspecifico").innerHTML = '';
		//document.getElementById("divTextoAbertura").innerHTML = '';
		document.cadMateriaBI.texto_abert.value =  '';
		document.cadMateriaBI.texto_fech.value =  '';
		document.cadMateriaBI.inputAssuntoEspecifico.value = '';
	}

	function setaAssuntoEspecifico_anterior(cod,descricao){
		//window.alert(objeto);
		codAssuntoEspec = cod;
		document.cadMateriaBI.inputAssuntoEspecifico.value = descricao;
		document.cadMateriaBI.inputCodAssEspec.value = cod;
		document.getElementById("divAssuntoEspecifico").innerHTML = '';
		// Buscar o texto padrão de abertura, fechamento e se vai para as alterações
		url="ajax_materia_bi.php?opcao=assuntoEspecifico&acao=buscaTextoAbertura&codAssuntoEspec="+codAssuntoEspec+
			"&assuntoGeral="+document.cadMateriaBI.inputCodAssGeral.value;
		//window.alert(url);
		ajax(url,"divTextoAbertura");
	}

	function setaAssuntoEspecifico(cod,descricao){
		//window.alert(objeto);
		codAssuntoEspec = cod;
		document.cadMateriaBI.inputAssuntoEspecifico.value = html_entity_decode(descricao);
		document.cadMateriaBI.inputCodAssEspec.value = cod;
		document.getElementById("divAssuntoEspecifico").innerHTML = '';
		// Buscar o texto padrão de abertura, fechamento e se vai para as alterações
		url="ajax_materia_bi.php?opcao=assuntoEspecifico&acao=buscaTextoAbertura&codAssuntoEspec="+codAssuntoEspec+
			"&assuntoGeral="+document.cadMateriaBI.inputCodAssGeral.value;
		//window.alert(url);
		//ajax(url,"divTextoAbertura");
		ajax(url,null,"cad_materia_bi");
	}

	// Lista os militares conforme os filtros selecionados
	function listaMilitar(codMateria){
		url="ajax_materia_bi.php?opcao=assuntoEspecifico&acao=listaMilitar&pgrad="+document.cadMateriaBI.selePGrad.value+
			"&nome="+document.cadMateriaBI.inputNomeMilitar.value+"&codMateria="+codMateria;
		ajax(url,"divListaMilitar");
		window.location.href="#fim_pag";
	}

	//function adicionaPessoaMateria(codMateria,codPessoa){
	function adicionaPessoaMateria(codMateria){
		document.cadMateriaBI.action = "cadmateriabi.php?codMateriaBIAtual="+codMateria+"&codTipoBol=<?=$codTipoBol?>&tab=2";
		document.cadMateriaBI.executar.value = "adicionaMilitares";
		document.cadMateriaBI.submit();
	}

	function adicionaPessoaIndividual(codMateria,codPessoa){
		document.cadMateriaBI.action = "cadmateriabi.php?codMateriaBIAtual="+codMateria+"&codTipoBol=<?=$codTipoBol?>&tab=2";
		document.cadMateriaBI.executar.value = "adicionaMilitarIndividual";
		document.cadMateriaBI.codPessoaIndividual.value = codPessoa;
		document.cadMateriaBI.submit();
		/*
		document.getElementById('divPessoa').innerHTML = "<font color='blue'>&nbsp;&nbsp;Espere, processando...</font>";
		url="ajax_materia_bi.php?opcao=pessoaMateria&acao=adicionaPessoaMateria&codMateria="+codMateria+
				"&codPessoa="+codPessoa;
		ajaxCadMilitar(url,"divListaMilitar","");
		*/
	}
	function excluiPessoaMateria(codMateria,codPessoa){
		document.cadMateriaBI.action = "cadmateriabi.php?codMateriaBIAtual="+codMateria+
										"&codTipoBol=<?=$codTipoBol?>&tab=2";
		document.cadMateriaBI.executar.value = "excluiMilitarIndividual";
		document.cadMateriaBI.codPessoaIndividual.value = codPessoa;
		document.cadMateriaBI.submit();
	}
	function atualizaTela(resposta,tipoLocal){
		//alert(resposta);
		if(tipoLocal == 'listaPessoaMateria'){
			listaPessoaMateria(<?=$codMateriaBIAtual?>);
		}
		if(tipoLocal == 'listaMilitar'){
			listaPessoaMateria(<?=$codMateriaBIAtual?>);
			//listaMilitar(<?=$codMateriaBIAtual?>);
		}
	}
	function atualizaTela(resposta){
		if(resposta !== ''){
			alert('A tentativa de exclusão falhou. \nO Sistema não pode excluir pessoas com publicações ou '+
					'alterações cadastradas.\n\nMensagem de erro: '+resposta);
			divPessoa.innerHTML = "";
		} else {
			window.location.href="cadmilitar.php?codpgrad="+document.cadMilitar.selePGrad.value+
							"&ativos="+document.cadMilitar.seleAtivo.value+"&item=<?=$item?>"+
							"&omVinculacao="+document.cadMilitar.sele_om_vinc.value;
		}
	}

	function listaPessoaMateria(codMateria){
		url="ajax_materia_bi.php?opcao=assuntoEspecifico&acao=listaPessoaMateria&codMateria="+codMateria;
//		alert(url);
		ajax(url,"divPessoaMateria");
		//window.location.href="#fim_pag";
	}

	// Salva a matéria
	function salvaMateriaBI(acao,codMateria){
		//window.alert(acao);
		document.cadMateriaBI.executar.value = acao;
		nrDoc = document.cadMateriaBI.nr_documento.value;
		idtMilAss = document.cadMateriaBI.seleMilitarAssina.value;
//		if (nrDoc == ''){
//			window.alert('Informe o número Documento');
//			window.location.href="#topo";
//			document.cadMateriaBI.nr_documento.focus();
//
//			return;
//		}
		if (document.cadMateriaBI.inputAssuntoGeral.value == ''){
			window.alert('Informe o Assunto Geral.');
			window.location.href="#topo";
			buscaAssuntoGeral('');
			return;
		}
		if (document.cadMateriaBI.inputAssuntoEspecifico.value == ''){
			window.alert('Informe o Assunto Específico.');
			window.location.href="#topo";
			buscaAssuntoEspecifico('');
			return;
		}
		if (acao=="Incluir"){
			document.cadMateriaBI.action = "cadmateriabi.php?idtMilAss="+idtMilAss+"&codTipoBol=<?=$codTipoBol?>";
		}
		if (acao=="Alterar"){
			document.cadMateriaBI.action = "cadmateriabi.php?idtMilAss="+idtMilAss+"&codMateriaBIAtual="+codMateria+"&codTipoBol=<?=$codTipoBol?>";
		}
		if (acao=="Salvar"){
			document.cadMateriaBI.action = "cadmateriabi.php?codMateriaBIAtual="+codMateria+"&tab=2&codTipoBol=<?=$codTipoBol?>";
		}
		if (acao == "Excluir")  {
			if (!window.confirm("Deseja realmente esta matéria para boletim ?")){
				return ;
			}
			document.cadMateriaBI.action = "cadmateriabi.php?codMateriaBIAtual="+codMateria+"&codTipoBol=<?=$codTipoBol?>";
		}
		document.cadMateriaBI.submit();
	}

	function novo(){
		document.getElementById("divBuscador").style.visibility = "visible";
		document.getElementById("novo").style.visibility = "hidden";
	}
	function cancelar(){
		document.getElementById("divBuscador").style.visibility = "hidden";
		document.getElementById("novo").style.visibility = "visible";
//		document.getElementById("divListaMilitar").innerHTML = '';
//		document.getElementById("divTextoIndividual").innerHTML = '';
//		document.getElementById("novo").style.visibility = "visible";
	}
	function carregaTextoIndividual(codMateria,codPessoa){
		document.getElementById("novo").style.visibility = "hidden";
//		document.getElementById("divBuscador").style.visibility = "hidden";
		document.getElementById("divTextoIndividual").style.visibility = "visible";
		url="ajax_materia_bi.php?opcao=formAlteraTextoIndividual&codMateria="+codMateria+
				"&codPessoa="+codPessoa;
		ajaxTextoIndiv(url,"divTextoIndividual");
	}

	function salvarTextoIndividual(codMateria,codPessoa){
		//window.alert('Texto individual');
		document.cadMateriaBI.action = "cadmateriabi.php?codMateriaBIAtual="+codMateria+"&codPessoa="+codPessoa+"&codTipoBol=<?=$codTipoBol?>&tab=2";
		document.cadMateriaBI.executar.value = "salvaTextoIndividual";
		document.cadMateriaBI.submit();
	}

	function carregaFrame(doc,idFrame) {
		document.getElementById(idFrame).src = doc
	}
	function escondeFly(){
		document.getElementById("flyframe").style.visibility = "hidden";
		document.getElementById('subscrForm').style.visibility = 'hidden';
	}

	function novaMateria(tipoBol){
		if (window.confirm("A edição de uma nova matéria vai descartar todas as alterações não salvas.\nDeseja editar uma nova matéria ?")){
			window.location.href='cadmateriabi.php?codTipoBol='+tipoBol;
		}
	}

	</script>
	<style type="text/css">
	.tabberlive .tabbertab {
 		padding:5px;
 		border:2px solid #aaa;
 		border-top:0;
 		background-color: #fff;
	}
	</style>
</head>

<body>
<a name="#topo">
<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
<center>
	<?
  	if (isset($_POST['executar'])){
		// Buscando os objetos posts enviados e atribuindo aos objetos para incl, altr

		//REV 07
        $militarAss = new Militar(null, null, null, null, null);

		$TipoDoc = new TipoDoc();
  		$TipoDoc->setCodigo($_POST['seleTipoDoc']);

  		$data = trim($_POST['data']);
		$data = explode("/",$data);
		$data = $data[2]."-".$data[1].'-'.$data[0];

  		$dataDoc = trim($_POST['data_documento']);
		$dataDoc = explode("/",$dataDoc);
		$dataDoc = $dataDoc[2]."-".$dataDoc[1].'-'.$dataDoc[0];

  		$parteBoletim = new ParteBoletim(null);
		$parteBoletim->setNumeroParte($_POST['seleParteBi']);

		$secaoParteBi = new SecaoParteBi();
		$secaoParteBi->setNumeroSecao($_POST['seleSecaoParteBi']);
		
	    $tipoBol = new TipoBol();
	    $tipoBol->setCodigo($codTipoBol);

		$assuntoGeral = new AssuntoGeral($parteBoletim,$secaoParteBi,$codTipoBol,null);
  		$assuntoGeral->setCodigo($_POST['inputCodAssGeral']);
  		$assuntoEspec = new AssuntoEspec();
  		$assuntoEspec->setCodigo($_POST['inputCodAssEspec']);
		//print_r($TipoBoletim);
  		$materiaBi = new MateriaBi(new MinhaData($data), $assuntoEspec, $assuntoGeral,$TipoDoc, new MinhaData($dataDoc), $colPessoaMateriaBi2,$TipoBoletim,$militarAss);

		//REV 07
		//$materiaBi->setData($data);
		$materiaBi->getMilitarAss()->setIdMilitar($_POST['seleMilitarAssina']);
		//print_r($materiaBi);

        //echo $_POST['texto_abert'];
		$materiaBi->setTextoAbert(str_replace('<br type=\"_moz\" />','',$_POST['texto_abert']));
        $materiaBi->setTextoFech(str_replace('<br type=\"_moz\" />','',$_POST['texto_fech']));
        $materiaBi->setNrDocumento($_POST['nr_documento']);
        $materiaBi->setAprovada('N');
//		$materiaBi->setUsuario($apresentacao->getUser()); // Rev 05 - Mai2008
		$materiaBi->setUsuario($_POST['usuario']); // Rev 07 - Set2009
        if (isset($_POST['vai_altr'])){
	  		$materiaBi->setVaiAltr('S');
  		}else{
		   $materiaBi->setVaiAltr('N');
		}
        $materiaBi->setDescrAssEsp($_POST['inputAssuntoEspecifico']);
        $materiaBi->setDescrAssGer($_POST['inputAssuntoGeral']);

  		if ($_POST['executar'] == 'Incluir'){
			$codMateriaBIAtual = $fachadaSist2->getProximoCodigoMateriaBI();
  			$materiaBi->setCodigo($codMateriaBIAtual);
  			$fachadaSist2->incluirMateriaBi($materiaBi, null);
			$buscaMateria = true;
		}
		if ($_POST['executar'] == 'Excluir'){
			$materiaBi->setCodigo($codMateriaBIAtual);
			$fachadaSist2->excluirMateriaBi($materiaBi, null);
			//$buscaMateria = false;
			echo "<script> window.location.href= 'elabomatbi.php?codTipoBol=".$codTipoBol."';</script>";
		}
		if ($_POST['executar'] == 'Alterar'){
			$materiaBi->setCodigo($codMateriaBIAtual);
			$fachadaSist2->alterarMateriaBi($materiaBi, null);
			$buscaMateria = true;
		}
		// Vai alterar o texto individual da pessoa
		if ($_POST['executar'] == 'salvaTextoIndividual'){
			$materiaBi->setCodigo($codMateriaBIAtual);
			$codPessoa = $_GET['codPessoa'];
			$textoIndividual = $_POST['texto_individual'];
			$getCodMateria = $_GET['codMateriaBIAtual'];
			$PessoaMateriaBI = $fachadaSist2->lerPessoaMateriaBI($getCodMateria,$codPessoa);
			$setTextoIndiv = $PessoaMateriaBI->setTextoIndiv($textoIndividual);
			//print_r($PessoaMateriaBI);
			$buscaMateria = true;
			$fachadaSist2->alterarPessoaMateriaBI($materiaBi,$PessoaMateriaBI);
		}
		// Adiciona os militares que estão vinculados a materia
		if ($_POST['executar'] == 'adicionaMilitares'){
			$materiaBi->setCodigo($codMateriaBIAtual);
			if(isset($_POST['CheckIdMilitar'])){
    			foreach($_POST['CheckIdMilitar'] as $codPessoa){
    				// Buscar a Matéria
    				$pessoa 		 = new Pessoa(null, null,null);
        			$pessoaMateriaBi = new PessoaMateriaBi($pessoa);
					$pessoaMateriaBi->getPessoa()->setIdMilitar($codPessoa);
					$fachadaSist2->incluirPessoaMateriaBI($materiaBi, $pessoaMateriaBi);
				};
  			  }
			$buscaMateria = true;
		}
		// Adiciona somente um militar que vinculado
		if ($_POST['executar'] == 'adicionaMilitarIndividual'){
			$materiaBi->setCodigo($codMateriaBIAtual);
    		$codPessoa = $_POST['codPessoaIndividual'];
			$pessoa 		 = new Pessoa(null, null,null);
        	$pessoaMateriaBi = new PessoaMateriaBi($pessoa);
			$pessoaMateriaBi->getPessoa()->setIdMilitar($codPessoa);
			$fachadaSist2->incluirPessoaMateriaBI($materiaBi, $pessoaMateriaBi);
		}
		$buscaMateria = true;
		// Exclui somente um militar que vinculado
		if ($_POST['executar'] == 'excluiMilitarIndividual'){
			$materiaBi->setCodigo($codMateriaBIAtual);
    		$codPessoa = $_POST['codPessoaIndividual'];
			$pessoa 		 = new Pessoa(null, null,null);
        	$pessoaMateriaBi = new PessoaMateriaBi($pessoa);
			$pessoaMateriaBi->getPessoa()->setIdMilitar($codPessoa);
			$fachadaSist2->excluirPessoaMateriaBI($materiaBi, $pessoaMateriaBi);
		}
		$buscaMateria = true;
  	}
  	//Se for para carregar uma matéria existente no banco
	if ($buscaMateria){
		//echo 'Código materia Bi atual'.$codMateriaBIAtual;
		$materiaBi = $fachadaSist2->lerRegistroMateriaBI($codMateriaBIAtual);
		//print_r($materiaBi);
  		$parteBI   = $fachadaSist2->LerParteQuePertenceAssuntoEspec($materiaBi->getAssuntoGeral()->getCodigo(),$materiaBi->getAssuntoEspec()->getCodigo());

  		if ($materiaBi != null){
  			if ($materiaBi->getVaiAltr() == 'S'){
				$vai_altr = 'true';
			} else {
				$vai_altr = 'false';
			}
 			echo '<script>function carregaForm(){';
	  		echo '
			document.cadMateriaBI.data.value 	 		= "'.$materiaBi->getData()->GetcDataDDBMMBYYYY().'";
  			document.cadMateriaBI.seleParteBi.value 	 		= '.$parteBI->getNumeroParte().';
  			document.cadMateriaBI.seleTipoDoc.value 	 		= '.$materiaBi->getTipoDoc()->getCodigo().';
			document.cadMateriaBI.nr_documento.value 	 		= "'.$materiaBi->getNrDocumento().'";
			document.cadMateriaBI.data_documento.value 	 		= "'.$materiaBi->getDataDoc()->GetcDataDDBMMBYYYY().'";
	  		document.cadMateriaBI.inputCodAssEspec.value 		= '.$materiaBi->getAssuntoEspec()->getCodigo().';
			document.cadMateriaBI.inputCodAssGeral.value 		= '.$materiaBi->getAssuntoGeral()->getCodigo().';
			document.cadMateriaBI.inputAssuntoGeral.value 		= "'.$materiaBi->getDescrAssGer().'";
			document.cadMateriaBI.inputAssuntoEspecifico.value  = "'.$materiaBi->getDescrAssEsp().'";
			document.cadMateriaBI.vai_altr.checked  			= '.$vai_altr.';
			document.cadMateriaBI.btSalvar.value				= "Alterar";';
  			echo '}</script>';
		}
	}
  	// Aqui começa a página propriamente dita
  	$apresentacao->chamaCabec();
	$apresentacao->montaMenu();
	$apresentacao->montaFlyForm(740,400,'#EFEFEF',"2");

 	//Montagem das coleções para preenchimento dos combo-boxes
 	$colTipoDoc = $fachadaSist2->lerColecaoTipoDoc('descricao'); // Tipo de documento
	$colParteBi = $fachadaSist2->lerColecaoParteBoletim('descr_reduz'); // Parte do BI
	$colMilitar2 = $fachadaSist2->lerColMilAssNota("order by PGRAD_COD, ANTIGUIDADE");
	$colPgrad = $fachadaSist2->lerColecaoPGrad('cod');

	// Se for leitura de matéria já incluída, precisamos montar a coleção de Seção em cima da parte de boletim
	if (isset($parteBI)){
		$numeroParteAtual = $parteBI->getNumeroParte();
	} else {
		$obj = $colParteBi->iniciaBusca1();
		$numeroParteAtual = $obj->getNumeroParte();
	}

	$colSecaoParteBi = $fachadaSist2->lerColecaoSecaoParteBi($numeroParteAtual);

	if (isset($_GET['numeroSecao'])){
		$numeroSecaoParteBiAtual = $_GET['numeroSecao'];
	}else {
		$obj = $colSecaoParteBi->iniciaBusca1();

		if (!is_null($obj)){
			$numeroSecaoParteBiAtual = $obj->getNumeroSecao();
		} else {
			$numeroSecaoParteBiAtual = 0;
		}
	}



	?>
	<form  method="post" name="cadMateriaBI">
	<table width="890" border="0">
	<tr>
	<td align="center">
	<h3 class="titulo" valign="left">&nbsp;&nbsp;<img src="./imagens/item_dir.gif">&nbsp;<?=$titulo?>
		<font color="red"><?=$TipoBoletim->getDescricao();?></font>&nbsp;&nbsp;Nota nº:&nbsp;<font color="red"><?=$codMateriaBIAtual?></font>
		&nbsp;&nbsp;Data:&nbsp;<input type="text" maxlength="10" size="12" id="data" name="data" value="<?=date("d/m/Y")?>">
			<a href="javascript:NewCal('data','DDMMYYYY')"><img src="imagens/cal.gif" width="16" height="16" border="0" alt="Selecione a Data."></a>
	</h3>
	</td>
	<td align="right"><input type="button" onclick="novaMateria(<?=$codTipoBol?>)" value="Nova Matéria"></td>
	</tr>
	</table>
	<!-- Campos escondidos destinado a guardar os códigos -->
	<input name="executar" type="hidden" value="">
	<input name="codTipoBol" type="hidden" value="">
	<input name="codPessoaIndividual" type="hidden" value="">
	<input name="usuario" type="hidden" value="<?=$apresentacao->getUser()?>">
	<table width="890" border="0" cellspacing="2" cellppading="2" bgcolor="#F5F5F5"
		style="border-top:1pt solid blue;border-bottom:1pt solid blue;border-left:1pt solid blue;border-right:1pt solid blue;">
		<tr>
		<td colspan="4"><b>Dados de referência:&nbsp;</b></td>
		</tr>
		<tr>
		<td>Tipo de Doc:&nbsp;</td>
		<td><? 	$apresentacao->montaCombo('seleTipoDoc',$colTipoDoc,'getCodigo','getDescricao',null,'');?></td>
		<td>N&ordm; Doc:</td>
		<td><input type="text" maxlength="40" size="40" name="nr_documento" value="">
			Data: <input type="text" maxlength="10" size="12" id="data_documento" name="data_documento" value="<?=date("d/m/Y")?>">
			<a href="javascript:NewCal('data_documento','DDMMYYYY')"><img src="imagens/cal.gif" width="16" height="16" border="0" alt="Selecione a Data."></a>
		</td>
		</tr>
		<tr><td colspan="4"><b>Estrutura da matéria dentro do Boletim:&nbsp;</b></td></tr>
		<tr><td>Parte do BI:&nbsp;</td><td>
		<? $apresentacao->montaCombo('seleParteBi',$colParteBi,'getNumeroParte','getDescrReduz',$numeroParteAtual,'onChangeParteBi()');?>
	 	</td>
	 	<td>Seção:&nbsp;</td><td><div id="divSecaoParteBI">
		<? $apresentacao->montaCombo('seleSecaoParteBi',$colSecaoParteBi,'getNumeroSecao',
										'getDescricao',$numeroSecaoParteBiAtual,'onchangeSecao()');?>
	 	</div></td>
		</tr><tr>
		<td valign="top">Assunto Geral:&nbsp;</td><td colspan="3" valign="top">
			<input type="HIDDEN" name="inputCodAssGeral">
			<input type="text" name="inputAssuntoGeral" maxlength="100" size="130" onkeypress="return false;">
	 		<input type="button" onclick="buscaAssuntoGeral('')" value="Buscar">
			<div id="divAssuntoGeral"></div></td>
		</tr><tr>
		<td valign="top">Assunto Específ:&nbsp;</td><td colspan="3" valign="top">
	 		<input type="hidden" name="inputCodAssEspec">
	 	<input type="text" name="inputAssuntoEspecifico" maxlength="100" size="130"  onkeypress="return false;">
	 		<input type="button" onclick="buscaAssuntoEspecifico('')" value="Buscar">
		 <div id="divAssuntoEspecifico"></div></td>
		 </tr>

		 <tr><td colspan="4"><b>Militar que assina a matéria:</b> 
		<? $apresentacao->montaComboAssina($colMilitar2,$idtMilAss,$colPgrad);?>
	 	</td></tr>
		 		 
	</table>

	<table border="0" width="830" ><tr><td>

	<!-- Inicio das Tabs-->
	<div class="tabber" id="mytab1">

	 <div class="tabbertab" id="tabmateria">
	 <div id="acordeon1">
	  <h2>Matéria Bi</h2>
		<div id="divTextoAbertura" align="center">
		 <table border="0"  width="810" class="lista"><tr class="cabec"><td>Texto de Abertura:</td>
		 <td align="right" valign="top">
		 <?echo $buscaMateria?'<INPUT TYPE="button" NAME="Vizualizar" value="Visualizar PDF" onclick="montaPreview('.$codMateriaBIAtual.')">':'';?>
		 Vai para Altera&ccedil;&otilde;es ?
		 <input name="vai_altr" type="checkbox" checked></td></tr>
		<tr>
		<td colspan="2" align="center">
		</tr>
		<div id="xToolbar"></div>
		<tr>
		<td colspan="2" align="center">

		<script>
			oFCKAbert.ToolbarSet = "CadMatBI";
			oFCKAbert.Height = 300 ;
			oFCKAbert.Value = '<?if ($buscaMateria){echo ereg_replace(chr(13).chr(10),'',$materiaBi->getTextoAbert());}?>';
			oFCKAbert.Create() ;
		</script>

		</td></tr></table>
		</div>
		<div id="acordeon2">
		<table border="0"  width="810" class="lista">
		<tr class="cabec"><td colspan="2">Texto de Fechamento:</td></tr>
		<tr>
		<td colspan="2" align="center">
		<script>
    		oFCKFech.ToolbarSet = "CadMatBI" ;
    		oFCKFech.Height = 150 ;
    		oFCKFech.Value = '<?if ($buscaMateria){echo ereg_replace(chr(13).chr(10),'',$materiaBi->getTextoFech());}?>';
			oFCKFech.Create() ;
		</script>

		</td></tr></table>
		</div>
		</div>

		<br>
		<div align="right">
		<?
		if ($buscaMateria){
            //verifica permissao para excluir
   	        if ($_SESSION['NOMEUSUARIO'] != 'supervisor'){
       	      $mExcluir = $fachadaSist2->lerUsuarioFuncaoCodTipoBol($_SESSION['NOMEUSUARIO'],2003,$codTipoBol);
           	}
            if (($mExcluir != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor'))
		    { echo '<input type="button" name="btnExcluir" value="Excluir" onClick="salvaMateriaBI(this.value,'.$codMateriaBIAtual.')"> ';
		    }
		}
		?>
		<input type="button" name="btnSalvar" value="Incluir" onClick="salvaMateriaBI(this.value,'<?=$codMateriaBIAtual?>')"></div>
		<a name="fim_pag">
	 </div> <!-- Fechou o 1o tabber -->
	 <!-- Abre o 2o tabber -->
	 <? if ($buscaMateria){
	 		echo '<div class="tabbertab" align="center" id="tabpessoa"><h2>Militares</h2>';
	  		echo ' <div id="divPessoaMateria"></div>';
  			echo ' <script>listaPessoaMateria('.$codMateriaBIAtual.')</script>';
  			echo ' <table width="830" border="0" ><TR><TD><a href="javascript:novo()" id="novo">
					<img src="./imagens/seta_dir.gif" border=0><FONT COLOR="#0080C0">Adicionar
					</FONT></a></TD>
					</TR></TABLE>';
			echo ' <div id="divBuscador" STYLE="VISIBILITY:hidden">';
  			echo '<table width="85%" border="0" cellspacing="0" cellppading="0" class="lista"><class="cabec"><td>';
			echo '<table border="0" width="100%" cellspacing="0" cellppading="0">';
			echo '<tr class="cabec"><td> Busca Militar</td></tr><tr>';
			echo '<tr bgcolor="white"><td>Posto/Grad:</td><td>';
			$colPGrad2 = $fachadaSist2->lerColecaoPGrad('cod');
  			$pGrad = $colPGrad2->iniciaBusca1();
			$apresentacao->montaCombo('selePGrad',$colPGrad2,'getCodigo','getDescricao',$codpgrad,'null');
			echo '  </td><td>Nome: <input name="inputNomeMilitar" type="text" maxlenght="40" size="45"></td>';
			echo '  <td><input type="button" value="Buscar" onClick="listaMilitar('.$codMateriaBIAtual.')"><td>';
			echo '  <input type="button" value="Cancelar" onClick="cancelar()"></tr></table>';
			echo '	</tr></td></table>';
			echo ' </div>';
	  		echo ' <div id="divListaMilitar"></div>';
  			echo ' <div id="divTextoIndividual" STYLE="VISIBILITY:hidden">';
			echo '<table border="0"  width="810" class="lista">
					<tr class="cabec"><td colspan="2">Texto Individual:</td></tr>
					<tr>
						<td colspan="2" align="center">
						<script>
				    		oFCKIndiv.ToolbarSet = "CadMatBI" ;
				    		oFCKIndiv.Height = 150 ;
				    		oFCKIndiv.Value = "";
							oFCKIndiv.Create();
						</script>

					</td></tr></table>';
				echo '<div align="right">';
				echo '<input type="button" name="btnExcluir" value="Limpar" onClick="salvaMateriaBI(this.value,'.$codMateriaBIAtual.')">';
				echo '<input type="button" name="btnSalvar" value="Salvar" onClick="salvarTextoIndividual('.$codMateriaBIAtual.','.$codMateriaBIAtual.')"></div>';
				echo '<a name="fim_pag">';
			echo '</div>'; // Local para montar o form de inclusão alteração do text individual
	  		echo '</div>';
//			echo '<script>carregaMilAss(\''.$materiaBi->getMilitarAss()->getIdMilitar().'\',\'Alterar\')</script>';
		}
	 ?>
	</div><!-- Fechou o tabber mytab1 -->
	</td></tr></table>
		<? if ($buscaMateria){echo '<script>carregaForm();</script>';}?>
		<script>
		tabberAutomatic(tabberOptions);
		//document.getElementById('mytab1').tabber.tabShow(1);
		jQuery('#acordeon1').accordion();
		jQuery('#acordeon2').accordion({
    	autoheight: false
		});
		</script>
	<div id="divNenhum"></div>
	<a name="bottom">
	</form>
</center>
</body>
</html>

