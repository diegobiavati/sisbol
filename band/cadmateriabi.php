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
    $bIncluiAssunto = 0; 			// Se 0 n�o permitir a cria��o de novo assunto geral ou especifico
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
		$titulo = "Alterar Nota para:";
	} else {
		$buscaMateria = false;
		$titulo = "Lan�ar Nota para:";
	}

        if(isset($_GET['codTipoBol'])){
		$codTipoBol = $_GET['codTipoBol'];
		$TipoBoletim = $fachadaSist2->lerTipoBol($codTipoBol);
	}
	if(isset($_GET['idtMilAss'])){
		$idtMilAss = $_GET['idtMilAss'];
	}
        if(isset($_GET['modelo'])){
		$modelo = $_GET['modelo'];
	}else{
            $modelo=0;
        }
        //verifica se o usu�rio logado pode modificar o modelo da nota
        //S - usu�rio tem permiss�o para modificar
        //X - supervisor logado - pode tudo
	if (($_SESSION['MODIFICA_MODELO'] == 'S')||($_SESSION['MODIFICA_MODELO'] == 'X')) {
            //echo "modifica";
            $modificaModelo=1;
        }else{
            //echo "n�o modifica";
            $modificaModelo=0;
        }
        $omVinculacao = $apresentacao->getCodom();
	if(isset($_GET['status'])){
		$status = $_GET['status'];
	}else{
		$status = 'E';
    }

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SisBol</title>
<? $apresentacao->chamaEstilo(); ?>
<script type="text/javascript">
		var ol_vauto = 1;
		var idMilitarAss = null;
	</script>
<script type="text/javascript" src="scripts/band.js"></script>
<script type="text/javascript" src="scripts/tabber.js"></script>
<script type="text/javascript" src="scripts/datetimepicker.js"></script>
<script type="text/javascript" src="../fckeditor/fckeditor.js"></script>
<script type="text/javascript" src="scripts/overlib.js"></script>
<script type="text/javascript" src="scripts/msg_hints.js"></script>
<script type="text/javascript">
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
	// � chamado via ajax.js para preenchimento do editor FCKEditor
	function InsertHTML(conteudo){
		var oEditorAbert = FCKeditorAPI.GetInstance('texto_abert') ;
		var oEditorFech = FCKeditorAPI.GetInstance('texto_fech') ;

		vaiAltr 	= conteudo.substring(0,1);
		textoFechVaiAltr = conteudo.substring(1,1);
		abertura 	= conteudo.substring(2,conteudo.indexOf('$wxxw$'));
		fechamento 	= conteudo.substring(conteudo.indexOf('$wxxw$') + 6,conteudo.length);
		oEditorAbert.SetHTML(abertura);
		oEditorFech.SetHTML(fechamento);
		document.cadMateriaBI.vai_altr.checked = (vaiAltr == 'S'? true: false);
		document.cadMateriaBI.texto_fech_vai_altr.checked = (textoFechVaiAltr == 'S'? true: false);
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
                        '<table width="100%" border="0" class="lista"><tr><td><font size="2" color="yellow"><b>Busca Assunto Geral<\/b><\/font><\/td><\/tr><\/table>' +
			'<br>Buscar:<input type="text" id="busca" name="textBusca" size="60"  onKeyDown="listaGeral(event)">'+
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
			window.alert('Voc� precisa selecionar o Assunto Geral.\n O Sistema chamar� a janela de sele��o do Assunto Geral.');
			buscaAssuntoGeral('');
			return;
		}
		document.getElementById("subscrForm").style.left = 5 + "px";
		document.getElementById("flyframe").style.visibility = "visible";
		document.getElementById("subscrForm").style.visibility = 'visible';
		listaAssuntoEspecificoLike(textoBuscado);
		document.getElementById('buscador').innerHTML = '<table width="100%" border="0" class="lista"><tr><td><font size="3" color="yellow"><b>'+
			'Busca Assunto Espec�fico<\/b><\/font><\/td><\/tr><\/table>' +
			'<br>Buscar: <input type="text" id="textBusca" name="textBusca" size="60"  onKeyDown="listaEspecifico(event)">'+
			'<input type="button" value="Buscar" onclick="listaAssuntoEspecificoLike(document.subscribe.textBusca.value)">'+
			'<input type="button" value="Novo Assunto Espec�fico" onclick="novoAssuntoEspecifico(\'\')" <?=($bIncluiAssunto == 0?'DISABLED':'')?>>'+
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
		// Buscar o texto padr�o de abertura, fechamento e se vai para as altera��es
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
		// Buscar o texto padr�o de abertura, fechamento e se vai para as altera��es
		url="ajax_materia_bi.php?opcao=assuntoEspecifico&acao=buscaTextoAbertura&codAssuntoEspec="+codAssuntoEspec+
			"&assuntoGeral="+document.cadMateriaBI.inputCodAssGeral.value;
		//window.alert(url);
		//ajax(url,"divTextoAbertura");
		ajax(url,null,"cad_materia_bi");
	}

	// Lista os militares conforme os filtros selecionados
	function listaMilitar(codMateria,codom,codSubun,todasOmVinc,todasSubun){
		url="ajax_materia_bi.php?opcao=assuntoEspecifico&acao=listaMilitar&pgrad="+document.cadMateriaBI.selePGrad.value+
			"&nome="+document.cadMateriaBI.inputNomeMilitar.value+"&codMateria="+codMateria+"&codom="+codom+"&codSubun="+codSubun+"&x="+todasOmVinc+"&y="+todasSubun;
		ajax(url,"divListaMilitar");
		window.location.href="#fim_pag";
	}

	//function adicionaPessoaMateria(codMateria,codPessoa){
	function adicionaPessoaMateria(codMateria){
		document.cadMateriaBI.action = "cadmateriabi.php?codMateriaBIAtual="+codMateria+"&idtMilAss="+document.cadMateriaBI.seleMilitarAssina.value+"&codTipoBol=<?=$codTipoBol?>&tab=2";
		document.cadMateriaBI.executar.value = "adicionaMilitares";
		document.cadMateriaBI.submit();
	}

	function adicionaPessoaIndividual(codMateria,codPessoa){
		document.cadMateriaBI.action = "cadmateriabi.php?codMateriaBIAtual="+codMateria+"&idtMilAss="+document.cadMateriaBI.seleMilitarAssina.value+"&codTipoBol=<?=$codTipoBol?>&tab=2";
		document.cadMateriaBI.executar.value = "adicionaMilitarIndividual";
		document.cadMateriaBI.codPessoaIndividual.value = codPessoa;
		document.cadMateriaBI.submit();
		/*
		document.getElementById('divPessoa').innerHTML = "<font color='blue'>&nbsp;&nbsp;Espere, processando...<\/font>";
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
	function atualizaTextoIndiv(resposta){
		var oEditorIndiv = FCKeditorAPI.GetInstance('texto_indiv') ;
		oEditorIndiv.SetHTML(resposta);
		//document.cadMateriaBI.texto_indiv.value=resposta;
		window.location.href="#fim_pag";
		//window.alert(resposta);
	}

	function listaPessoaMateria(codMateria){
		url="ajax_materia_bi.php?opcao=assuntoEspecifico&acao=listaPessoaMateria&codMateria="+codMateria;
//		alert(url);
		ajax(url,"divPessoaMateria");
		//window.location.href="#fim_pag";
	}

	// Salva a mat�ria
	function salvaMateriaBI(acao,codMateria,modModelo){
		//window.alert(modModelo);
		document.cadMateriaBI.executar.value = acao;
		nrDoc = document.cadMateriaBI.nr_documento.value;
		idtMilAss = document.cadMateriaBI.seleMilitarAssina.value;
//		if (nrDoc == ''){
//			window.alert('Informe o n�mero Documento');
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
			window.alert('Informe o Assunto Espec�fico.');
			window.location.href="#topo";
			buscaAssuntoEspecifico('');
			return;
		}
		if (acao=="Incluir"){
                    if (modModelo==1){
			if (!window.confirm("Nota salva com sucesso! Deseja salvar o texto dessa nota como modelo no reposit�rio de assuntos?")){
                            modelo=0;
			}else {
                            modelo=1;
                        }
                    }else{
                        modelo=0;
                    }
                    document.cadMateriaBI.action = "cadmateriabi.php?modelo="+modelo+"&idtMilAss="+idtMilAss+"&codTipoBol=<?=$codTipoBol?>";
		}
		if (acao=="Alterar"){
                    if (modModelo==1){
			if (!window.confirm("Nota salva com sucesso! Deseja salvar o texto dessa nota como modelo no reposit�rio de assuntos?")){
                            modelo=0;
			}else {
                            modelo=1;
                        }
                    }else{
                            modelo=0;
                    }
                    document.cadMateriaBI.action = "cadmateriabi.php?modelo="+modelo+"&idtMilAss="+idtMilAss+"&codMateriaBIAtual="+codMateria+"&codTipoBol=<?=$codTipoBol?>";

		}
		if (acao=="Salvar"){
			document.cadMateriaBI.action = "cadmateriabi.php?codMateriaBIAtual="+codMateria+"&tab=2&codTipoBol=<?=$codTipoBol?>";
		}
		if (acao == "Excluir")  {
			if (!window.confirm("Deseja realmente excluir esta nota para boletim ?")){
				return ;
			}
			document.cadMateriaBI.action = "cadmateriabi.php?codMateriaBIAtual="+codMateria+"&codTipoBol=<?=$codTipoBol?>";
		}
		document.cadMateriaBI.submit();
	}

	function novo(){
		document.getElementById("divBuscador").style.visibility = "visible";
		document.getElementById("novo").style.visibility = "hidden";
		document.cadMateriaBI.btnSalvar.value = "Incluir";
	}
	function cancelar(){
		document.getElementById("divBuscador").style.visibility = "hidden";
		document.getElementById("novo").style.visibility = "visible";
		document.getElementById("divTextoIndividual").style.visibility = "hidden";
		window.location.href="#topo";
//		document.getElementById("divListaMilitar").innerHTML = '';
//		document.getElementById("divTextoIndividual").innerHTML = '';
//		document.getElementById("novo").style.visibility = "visible";
	}
	function carregaTextoIndividual(codMateria,codPessoa){
		document.getElementById("novo").style.visibility = "hidden";
//		document.getElementById("divBuscador").style.visibility = "hidden";
		document.getElementById("divTextoIndividual").style.visibility = "visible";
		document.cadMateriaBI.codPessoaIndividual.value = codPessoa;
		url="ajax_materia_bi.php?opcao=formAlteraTextoIndividual&codMateria="+codMateria+
				"&codPessoa="+codPessoa;
		ajaxTextoIndividual(url,"divTextoIndividual");
	}

	function salvarTextoIndividual(codMateria,codPessoa){
		//window.alert('Texto individual');
		document.cadMateriaBI.action = "cadmateriabi.php?codMateriaBIAtual="+codMateria+"&idtMilAss="+document.cadMateriaBI.seleMilitarAssina.value+"&codPessoa="+codPessoa+"&codTipoBol=<?=$codTipoBol?>&tab=2";
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
		if (window.confirm("A edi��o de uma nova nota vai descartar todas as altera��es n�o salvas.\nDeseja editar uma nova mat�ria ?")){
			window.location.href='cadmateriabi.php?codTipoBol='+tipoBol;
		}
	}

	function visualizar2(codMatBi){
		document.getElementById('mensagem').style.visibility = "visible";
		document.getElementById('divMatBi').innerHTML = "<font color='blue'>&nbsp;&nbsp;Espere, gerando a Nota para Boletim...<\/font>";
                url = 'ajax_elabomatbi2.php?codMatBi='+codMatBi;
                //alert(url);
                ajaxCadMilitar(url,"divMatBi");
	}
	//slopes
	function atualizaTela(resposta){
		document.getElementById('mensagem').style.visibility = "hidden";
		document.getElementById('divMatBi').innerHTML = "";
		viewPDF2(resposta);;
	}
	function adicionaOMVinc(opcao){
                //alert("passou...");
		var count = document.sele_om_vinc.options.length;
		option = new Option("Todas",0)
		document.sele_om_vinc.options[count] = option;
		document.sele_om_vinc.value = opcao;
	}
	</script>
<style type="text/css">
	.tabberlive .tabbertab {
 		padding:5px;
 		border:1px solid #006633;
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
        $militarAss = new Militar(null, null, null, null, null,null);

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
//		$materiaBi->setUsuario($apresentacao->getUser()); // Rev 05 - Mai2008
		$materiaBi->setUsuario($_POST['usuario']); // Rev 07 - Set2009
		$materiaBi->setCodom($_POST['codom']); // Rev 07 - Set2009
		$materiaBi->setCodSubun($_POST['cod_subun']); // Rev 07 - Set2009
        if (isset($_POST['vai_altr'])){
	  		$materiaBi->setVaiAltr('S');
  		}else{
		   $materiaBi->setVaiAltr('N');
		}
        if (isset($_POST['texto_fech_vai_altr'])){
	  		$materiaBi->setTextoFechVaiAltr('S');
  		}else{
		   $materiaBi->setTextoFechVaiAltr('N');
		}
        if (isset($_POST['mostra_ref'])){
	  		$materiaBi->setMostraRef('S');
  		}else{
		   $materiaBi->setMostraRef('N');
		}
        $materiaBi->setDescrAssEsp($_POST['inputAssuntoEspecifico']);
        $materiaBi->setDescrAssGer($_POST['inputAssuntoGeral']);

  		if ($_POST['executar'] == 'Incluir'){
            $materiaBi->setAprovada('N');
			$codMateriaBIAtual = $fachadaSist2->getProximoCodigoMateriaBI();
  			$materiaBi->setCodigo($codMateriaBIAtual);
  			$fachadaSist2->incluirMateriaBi($materiaBi, null, $modelo);
			$buscaMateria = true;
		}
		if ($_POST['executar'] == 'Excluir'){
			$materiaBi->setCodigo($codMateriaBIAtual);
			$fachadaSist2->excluirMateriaBi($materiaBi, null);
			//$buscaMateria = false;
			echo "<script type='text/javascript'> window.location.href= 'elabomatbi.php?codTipoBol=".$codTipoBol."';</script>";
		}
		if ($_POST['executar'] == 'Alterar'){
           $status = $fachadaSist2->lerRegistroMateriaBI($codMateriaBIAtual)->getAprovada();
		   // if ($status=="N")
               $materiaBi->setAprovada($status);
            //if ($status=="E")
            //    $materiaBi->setAprovada('E');
			$materiaBi->setCodigo($codMateriaBIAtual);
			$fachadaSist2->alterarMateriaBi($materiaBi, null, $modelo);
			$buscaMateria = true;
		}
		// Vai alterar o texto individual da pessoa
		if ($_POST['executar'] == 'salvaTextoIndividual'){
			$materiaBi->setCodigo($codMateriaBIAtual);
			$codPessoa = $_GET['codPessoa'];
			$textoIndividual = $_POST['texto_indiv'];
                        //die("mat: ".$codMateriaBIAtual."pessoa: ".$codPessoa."texto:".$textoIndividual);
			$getCodMateria = $_GET['codMateriaBIAtual'];
			$PessoaMateriaBI = $fachadaSist2->lerPessoaMateriaBI($getCodMateria,$codPessoa);
			//print_r($PessoaMateriaBI);
			$PessoaMateriaBI->setTextoIndiv(str_replace('<br type=\"_moz\" />','',$textoIndividual));
			//print_r($PessoaMateriaBI);
			$buscaMateria = true;
			$fachadaSist2->alterarPessoaMateriaBI($materiaBi,$PessoaMateriaBI);
		}
		// Adiciona os militares que est�o vinculados a materia
		if ($_POST['executar'] == 'adicionaMilitares'){
			$materiaBi->setCodigo($codMateriaBIAtual);
			if(isset($_POST['CheckIdMilitar'])){
    			foreach($_POST['CheckIdMilitar'] as $codPessoa){
    				// Buscar a Mat�ria
    				$pessoa 		 = new Pessoa(null, null,null,null);
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
			$pessoa 		 = new Pessoa(null, null,null,null);
        	$pessoaMateriaBi = new PessoaMateriaBi($pessoa);
			$pessoaMateriaBi->getPessoa()->setIdMilitar($codPessoa);
			$fachadaSist2->incluirPessoaMateriaBI($materiaBi, $pessoaMateriaBi);
		}
		$buscaMateria = true;
		// Exclui somente um militar que vinculado
		if ($_POST['executar'] == 'excluiMilitarIndividual'){
			$materiaBi->setCodigo($codMateriaBIAtual);
    		$codPessoa = $_POST['codPessoaIndividual'];
			$pessoa 		 = new Pessoa(null, null,null,null);
        	$pessoaMateriaBi = new PessoaMateriaBi($pessoa);
			$pessoaMateriaBi->getPessoa()->setIdMilitar($codPessoa);
			$fachadaSist2->excluirPessoaMateriaBI($materiaBi, $pessoaMateriaBi);
		}
		$buscaMateria = true;
  	}
  	//Se for para carregar uma mat�ria existente no banco
	if ($buscaMateria){
		//echo 'C�digo materia Bi atual'.$codMateriaBIAtual;
		$materiaBi = $fachadaSist2->lerRegistroMateriaBI($codMateriaBIAtual);
		//print_r($materiaBi);
  		$parteBI   = $fachadaSist2->LerParteQuePertenceAssuntoEspec($materiaBi->getAssuntoGeral()->getCodigo(),$materiaBi->getAssuntoEspec()->getCodigo());

		$materiaBi->getTextoAbert();
  		if ($materiaBi != null){
  			if ($materiaBi->getVaiAltr() == 'S'){
				$vai_altr = 'true';
			} else {
				$vai_altr = 'false';
			}
  			if ($materiaBi->getTextoFechVaiAltr() == 'S'){
				$textoFechVaiAltr = 'true';
			} else {
				$textoFechVaiAltr = 'false';
			}
  			if ($materiaBi->getMostraRef() == 'S'){
				$mostraRef = 'true';
			} else {
				$mostraRef = 'false';
			}
 			echo '<script type="text/javascript">function carregaForm(){';
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
			document.cadMateriaBI.texto_fech_vai_altr.checked  			= '.$textoFechVaiAltr.';
			document.cadMateriaBI.mostra_ref.checked  			= '.$mostraRef.';
			document.cadMateriaBI.btnSalvar.value				= "Alterar";';
  			echo '}</script>';
		}
	}
  	// Aqui come�a a p�gina propriamente dita
  	$apresentacao->chamaCabec();
	$apresentacao->montaMenu();
	$apresentacao->montaFlyForm(740,400,'#EFEFEF',"2");

 	//Montagem das cole��es para preenchimento dos combo-boxes
 	$colTipoDoc = $fachadaSist2->lerColecaoTipoDoc('descricao'); // Tipo de documento
	$colParteBi = $fachadaSist2->lerColecaoParteBoletim('descr_reduz'); // Parte do BI
	$colMilitar2 = $fachadaSist2->lerColMilAssNota("order by PGRAD_COD, ANTIGUIDADE");
        //print_r($colMilitar2);
	$colPgrad = $fachadaSist2->lerColecaoPGrad('cod');

	// Se for leitura de mat�ria j� inclu�da, precisamos montar a cole��o de Se��o em cima da parte de boletim
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
  <table width="500" border="0" >
    <tr>
      <td valign="bottom" width="3%"><div id="mensagem" class="processa" style="visibility:hidden"><img src="imagens/ajax-loader.gif" alt=""></div></td>
      <td><div id="divMatBi">&nbsp;</div></td>
    </tr>
  </table>
  <form  method="post" name="cadMateriaBI" action="">
    <table width="890" border="0">
      <tr>
        <td align="center"><h3 class="titulo">&nbsp;&nbsp;<img src="./imagens/item_dir.gif" alt="">&nbsp;
            <?=$titulo?>
            <font color="red">
            <?=$TipoBoletim->getDescricao();?>
            </font>&nbsp;&nbsp;Nota n�:&nbsp;<font color="red">
            <?=$codMateriaBIAtual?>
            </font> &nbsp;&nbsp;Data:&nbsp;
            <input type="text" maxlength="10" size="12" id="data" name="data" value="<?=date("d/m/Y")?>">
            <a href="javascript:NewCal('data','DDMMYYYY')"><img src="imagens/cal.gif" width="16" height="16" border="0" alt="Selecione a Data." ></a> </h3></td>
        <td align="right"><input type="button" onClick="novaMateria(<?=$codTipoBol?>)" value="Nova Nota"></td>
      </tr>
    </table>
    <!-- Campos escondidos destinado a guardar os c�digos -->
    <input name="executar" type="hidden" value="">
    <input name="codTipoBol" type="hidden" value="">
    <input name="codPessoaIndividual" type="hidden" value="">
    <input name="usuario" type="hidden" value="<?=$apresentacao->getUser()?>">
    <input name="codom" type="hidden" value="<?=$apresentacao->getCodom()?>">
    <input name="cod_subun" type="hidden" value="<?=$apresentacao->getCodSubun()?>">
    <table width="890" border="0" cellspacing="2" bgcolor="#F5F5F5"	style="border-top:1pt solid #006633;border-bottom:1pt solid #006633;border-left:1pt solid #006633;border-right:1pt solid #006633;">
      <tr>
        <td colspan="3" align="left"><b>Dados de refer�ncia:</b></td>
        <td align="right"><b>Mostrar dados desta Nota como refer�ncia no boletim?</b>&nbsp;
          <input name="mostra_ref" type="checkbox"></td>
      </tr>
      <tr>
        <td>Tipo de Doc:&nbsp;</td>
        <td><? 	$apresentacao->montaCombo('seleTipoDoc',$colTipoDoc,'getCodigo','getDescricao',null,'');?></td>
        <td>N&ordm; Doc:</td>
        <td><input type="text" maxlength="40" size="40" name="nr_documento" value="">
          Data:
          <input type="text" maxlength="10" size="12" id="data_documento" name="data_documento" value="<?=date("d/m/Y")?>">
          <a href="javascript:NewCal('data_documento','DDMMYYYY')"><img src="imagens/cal.gif" width="16" height="16" border="0" alt="Selecione a Data." ></a> </td>
      </tr>
      <tr>
        <td colspan="4"><b>Estrutura da nota dentro do Boletim:&nbsp;</b></td>
      </tr>
      <tr>
        <td>Parte do BI:&nbsp;</td>
        <td><? $apresentacao->montaCombo('seleParteBi',$colParteBi,'getNumeroParte','getDescrReduz',$numeroParteAtual,'onChangeParteBi()');?>
        </td>
        <td>Se��o:&nbsp;</td>
        <td><div id="divSecaoParteBI">
            <? $apresentacao->montaCombo('seleSecaoParteBi',$colSecaoParteBi,'getNumeroSecao',
										'getDescricao',$numeroSecaoParteBiAtual,'onchangeSecao()');?>
          </div></td>
      </tr>
      <tr>
        <td valign="top">Assunto Geral:&nbsp;</td>
        <td colspan="3" valign="top"><input type="HIDDEN" name="inputCodAssGeral" >
		<!-- Adicionado READONLY no input, bloqueando a edi��o do campo pelo usu�rio - Sgt Bedin 24/04/2013-->
          <input type="text" name="inputAssuntoGeral" maxlength="100" size="130"  READONLY>
          <input type="button" onClick="buscaAssuntoGeral('')" value="Buscar">
          <div id="divAssuntoGeral"></div></td>
      </tr>
      <tr>
        <td valign="top">Assunto Espec�f:&nbsp;</td>
        <td colspan="3" valign="top"><input type="hidden" name="inputCodAssEspec">
		<!-- Adicionado READONLY no input, bloqueando a edi��o do campo pelo usu�rio - Sgt Bedin 24/04/2013-->
          <input type="text" name="inputAssuntoEspecifico" maxlength="100" size="130" READONLY>
          <input type="button" onClick="buscaAssuntoEspecifico('')" value="Buscar">
          <div id="divAssuntoEspecifico"></div></td>
      </tr>
      <tr>
        <td colspan="4"><b>Militar que assina a mat�ria:</b>
          <? $apresentacao->montaComboAssina($colMilitar2,$idtMilAss,$colPgrad);?>
        </td>
      </tr>
    </table>
    <table border="0" width="830" >
      <tr>
        <td><!-- Inicio das Tabs-->
         <div class="tabber" id="mytab1">
             <div class="tabbertab" id="tabmateria">
              <div id="acordeon1">
               <h2>Mat�ria Bi</h2>
        	<div id="divTextoAbertura" align="center">
		 <table border="0"  width="810" class="lista">
                  <tr class="cabec">
                    <td>Texto de Abertura:</td>
		    <!--* PARREIRA 07-05-13- Inserido obs. sobre uso do enter
                    <td>Texto de Abertura:<p class="p_obs1">* Utilize Shift+ENTER para quebra de linha - Utilize somente ENTER para par�grafo</p></td>-->
                    <td align="right" valign="top">
                        <?echo $buscaMateria?'<INPUT TYPE="button" NAME="Vizualizar" value="Visualizar PDF" onclick="visualizar2('.$codMateriaBIAtual.')">':'';?>
                        Vai para Altera&ccedil;&otilde;es ?
                        <input name="vai_altr" type="checkbox" checked>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2" align="center">
                  </tr>
                  <div id="xToolbar"></div>
                  <tr>
                    <td colspan="2" align="center">
                    <script>
			oFCKAbert.ToolbarSet = "CadMatBI";
			oFCKAbert.Height = 300 ;
			
			<?			
			if ($buscaMateria){
				$texto = str_replace(chr(13).chr(10),"",$materiaBi->getTextoAbert());
			};			
			?>
			
			//Alterado para-->
			oFCKAbert.Value = '<?=$texto;?>';
			oFCKAbert.Create() ;
</script>
                    </td>
                  </tr>
                 </table>
		</div>     <!--div textoabert-->

		<div id="acordeon2">
		<table border="0"  width="810" class="lista">
		 <tr class="cabec">
                  <td>Texto de Fechamento:</td>
                   
                    <!--* PARREIRA 07-05-13- Inserido obs. sobre uso do enter 
                    <td>Texto de Abertura:<p class="p_obs1">* Utilize Shift+ENTER para quebra de linha - Utilize somente ENTER para par�grafo</p></td>-->
                    <td align="right" valign="top">
                        Vai para Altera&ccedil;&otilde;es ?
                        <input name="texto_fech_vai_altr" type="checkbox">
                    </td>
                 </tr>
		 <tr>
		  <td colspan="2" align="center">
		  <script>
                    oFCKFech.ToolbarSet = "CadMatBI" ;
                    oFCKFech.Height = 150 ;
					oFCKFech.Value = '<?if ($buscaMateria){echo str_replace(chr(13).chr(10),'',$materiaBi->getTextoFech());}?>';
                    oFCKFech.Create() ;
                  </script>
                  </td>
                 </tr>
                </table>
		</div>  <!--div acordon2-->
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
		    { echo '<input type="button" name="btnExcluir" value="Excluir" onClick="salvaMateriaBI(this.value,'.$codMateriaBIAtual.','.$modificaModelo.')">';
		    }
		}
		?>
		<input type="button" name="btnSalvar" value="Alterar" onClick="salvaMateriaBI(this.value,'<?=$codMateriaBIAtual?>','<?=$modificaModelo?>')"></div>
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
			$apresentacao->montaCombo('selePGrad',$colPGrad2,'getCodigo','getDescricao','Todos','null','Todos');
			echo '  <td>Nome: <input name="inputNomeMilitar" type="text" maxlenght="40" size="45"></td>';
			echo '  <td><input type="button" value="Buscar" onClick="listaMilitar('.$codMateriaBIAtual.',\''.$apresentacao->getCodom().'\','.$apresentacao->getCodSubun().',\''.$apresentacao->getTodasOmVinc2().'\',\''.$apresentacao->getTodasSubun2().'\')"><td>';
			echo '  <input type="button" value="Cancelar" onClick="cancelar()"></tr></table>';
			echo '	</tr></td></table>';
			echo ' </div>';
	  		echo ' <div id="divListaMilitar"></div>';
  			echo ' <div id="divTextoIndividual" STYLE="VISIBILITY:hidden;height:100px">';
			echo '<table border="0"  width="810" class="lista">
					<tr class="cabec"><td colspan="2">Texto Individual:</td></tr>
					<tr>
						<td colspan="2" align="center" >
						<script>
				    		oFCKIndiv.ToolbarSet = "CadMatBI" ;
				    		oFCKIndiv.Height = 300 ;
                                                //oFCKIndiv.value = "";
							oFCKIndiv.Create();
						</script>

					</td></tr></table>';
				echo '<div align="right">';
				echo '<input type="button" name="btnExcluir" value="Cancelar" onClick="cancelar()">';
				echo '<input type="button" name="btnSalvar" value="Salvar" onClick="salvarTextoIndividual('.$codMateriaBIAtual.',document.cadMateriaBI.codPessoaIndividual.value)"></div>';
			echo '</div>'; // Local para montar o form de inclus�o altera��o do text individual
	  		echo '</div>';
//			echo '<script>carregaMilAss(\''.$materiaBi->getMilitarAss()->getIdMilitar().'\',\'Alterar\')</script>';
		}
	 ?>
	</div><!-- Fechou o tabber mytab1 -->
	</td></tr></table>
		<a name="fim_pag">
		<? if ($buscaMateria){echo '<script>carregaForm();</script>';}else{echo '<script>document.cadMateriaBI.btnSalvar.value = "Incluir";</script>';}?>
		<script>
		tabberAutomatic(tabberOptions);
		//document.getElementById('mytab1').tabber.tabShow(1);
		//jQuery('#acordeon1').accordion(); --> retirada a chamada do accordion, pois n�o est� sendo utilizado -- Ten Watanabe/Ten S.Lopes -- 16/08/12
		//jQuery('#acordeon2').accordion({ --> retirada a chamada do accordion, pois n�o est� sendo utilizado -- Ten Watanabe/Ten S. Lopes -- 16/08/12
    	autoheight: false
		});
		</script>
	<div id="divNenhum"></div>
	<a name="bottom">
	</form>
</center>
</body>
</html>


