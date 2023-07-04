<? 	session_start();
	require('filelist_geral.php');
	require_once('./filelist_militar.php');
	require_once('./filelist_boletim.php');
	require_once('./filelist_assunto.php');
	require_once('./filelist_tipodoc.php');
	require_once('./filelist_usuariofuncaotipobol.php');
	require_once('./filelist_om.php');
	$fachadaSist2 = new FachadaSist2();
    $funcoesPermitidas = $fachadaSist2->lerColecaoAutorizada($_SESSION['NOMEUSUARIO'], 'X');
	$apresentacao = new Apresentacao($funcoesPermitidas);
        $ordem = (isset($_GET['ordem']))?($_GET['ordem']):"data_materia_bi DESC";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>SisBol</title>
	<? $apresentacao->chamaEstilo(); ?>
	<script type="text/javascript" src="scripts/band.js"></script>
    <script type="text/javascript" src="scripts/notaBoletim.js"  charset="utf-8"></script>
	<script type="text/javascript" src="scripts/flyform.js"></script>
	<script type="text/javascript">
	function tipoBol(codBol){
		window.location.href = "elabomatbi.php?codTipoBol="+document.elaboMateria.seleTipoBol.value;
	}

	function novo(){
		// Passar o tipo de boletim
		var tipoBol = document.elaboMateria.seleTipoBol.value;
		window.location.href="cadmateriabi.php?codTipoBol="+tipoBol;
	}

	// versao 2.3 - vincenzo
	function aprova(cod_materia, acao){
		document.elaboMateria.codMateria.value = cod_materia;
		document.elaboMateria.executar.value = acao;
		document.elaboMateria.action = "elabomatbi.php?codTipoBol="+document.elaboMateria.seleTipoBol.value;
		document.elaboMateria.submit();
	}
	
	function visualizar(codMateriaBI,linha,alturaForm){
		document.getElementById("subscrForm").style.left = 50 + "px";
		document.getElementById("flyframe").style.visibility = "visible";
		document.getElementById('subscrForm').style.visibility = 'visible';
		document.getElementById('buscador').innerHTML =
  		'<table width="95%" border="0"><tr><td><b><FONT FACE="Arial" COLOR="#0000FF">Nota n�: '
		  +codMateriaBI+'<\/FONT><\/b><\/td><td align="right"><input type="button" value="Fechar" onclick="javascript:escondeFly()"><\/td><\/tr><\/table>';
  		isrc="ajax_elabomatbi.php?opcao=buscaMateriaBI_Elab&codMateriaBI="+codMateriaBI;
  		url = '<iframe WIDTH="680" HEIGHT="300" src="'+isrc+'"><\/iframe>';
		document.getElementById('textoForm').innerHTML = url;
	}
	function visualizar2(codMatBi){
		document.getElementById('mensagem').style.visibility = "visible";
		document.getElementById('divMatBi').innerHTML = "<font color='blue'>&nbsp;&nbsp;Espere, gerando a Nota para Boletim...<\/font>";
		//alterado para gerar o original - rv06
//		url = 'ajax_boletim.php?codBol='+codBol+'&original=N';
		url = 'ajax_elabomatbi2.php?codMatBi='+codMatBi;
		ajaxCadMilitar(url,"divMatBi");
	}
	// Fun��o para inserir coment�rio nas NBI - Sgt Bedin
	function visualizar3(codMateriaBI,linha,alturaForm){
		document.getElementById("subscrForm").style.left = 50 + "px";
		document.getElementById("flyframe").style.visibility = "visible";
		document.getElementById('subscrForm').style.visibility = 'visible';
		document.getElementById('buscador').innerHTML =
  		'<table width="95%" border="0"><tr><td><b><FONT FACE="Arial" COLOR="#0000FF">Nota n�: '
		  +codMateriaBI+'<\/FONT><\/b><\/td><td align="right"><input type="button" value="Fechar" onclick="javascript:escondeFly()"><\/td><tr><td>Digite seu coment�rio: <\/FONT><\/b><input type="text" size="90" maxlength="150" id="textoComentario"><\/td><td align="right"><input type="button" name="Enviar" id="Enviar" value="Enviar" onclick="javascript:enviaComentario('+codMateriaBI+')"><\/td><\/tr><\/table>';
  		isrc="ajax_comentmatbi.php?opcao=buscaTextoComentario&codMateriaBI="+codMateriaBI;
  		url = '<iframe WIDTH="680" HEIGHT="300" src="'+isrc+'"><\/iframe>';
		document.getElementById('textoForm').innerHTML = url;
		$(document).ready(function () {
		$('input').keypress(function (e) {
        var code = null;
        code = (e.keyCode ? e.keyCode : e.which);                
        return (code == 13) ? false : true;
   });
});
	}
	//
	function atualizaTela(resposta){
		document.getElementById('mensagem').style.visibility = "hidden";
		document.getElementById('divMatBi').innerHTML = "";
		viewPDF2(resposta);;
	}
	function escondeFly(){
		document.getElementById("flyframe").style.visibility = "hidden";
		document.getElementById('subscrForm').style.visibility = 'hidden';
	}
	// Fun��o para inserir coment�rio nas NBI - Sgt Bedin
	function enviaComentario(codMateriaBI) {
	var priletra = document.getElementById("textoComentario").value;
	
	var letrasvalidas = priletra.search("[^a-z' '0-9A-Z��������������������������������.;:,@-_��]+$"); 
	if (priletra == "") {
	alert('Digite uma mensagem!');
	   
		return false; 
		}
	if(priletra.length > 0 &&  letrasvalidas >= 0) 
	{ 
	    alert('H� caracteres inv�lidos na mensagem!');
	   
		return false; 
	}
		acao="enviaComentario";
		$.ajax({
	  type: "POST",
	  url: "ajax_comentmatbi.php",
	  data: { opcao: acao, textoComentario: $("#textoComentario").val(), codMateriaBI: codMateriaBI}
	}).done(function(  ) {
	  //alert( "Data Saved: " + msg );
	  document.getElementById("flyframe").style.visibility = "hidden";
		document.getElementById('subscrForm').style.visibility = 'hidden';
		document.getElementById("subscrForm").style.left = 50 + "px";
		document.getElementById("flyframe").style.visibility = "visible";
		document.getElementById('subscrForm').style.visibility = 'visible';
		document.getElementById('buscador').innerHTML =
  		'<table width="95%" border="0"><tr><td><b><FONT FACE="Arial" COLOR="#0000FF">Nota n�: '
		  +codMateriaBI+'<\/FONT><\/b><\/td><td align="right"><input type="button" value="Fechar" onclick="javascript:escondeFly()"><\/td><tr><td>Digite seu coment�rio: <\/FONT><\/b><input type="text" size="90" maxlength="150" id="textoComentario"><\/td><td align="right"><input type="button" name="Enviar" id="Enviar" value="Enviar" onclick="javascript:enviaComentario('+codMateriaBI+')"><\/td><\/tr><\/table>';
  		isrc="ajax_comentmatbi.php?opcao=buscaTextoComentario&codMateriaBI="+codMateriaBI;
  		url = '<iframe WIDTH="680" HEIGHT="300" src="'+isrc+'"><\/iframe>';
		document.getElementById('textoForm').innerHTML = url;
		$(document).ready(function () {
		$('input').keypress(function (e) {
        var code = null;
        code = (e.keyCode ? e.keyCode : e.which);                
        return (code == 13) ? false : true;
   });
});
	});
	}
	// Fun��o para inserir coment�rio nas NBI - Sgt Bedin
	function executa(acao){	

		document.elaboMateria.executar.value = acao;
	}
        function ordena(ordem){
		window.location.href="elabomatbi.php?codTipoBol="+document.elaboMateria.seleTipoBol.value+"&ordem="+ordem;
        }
	function conclui(cod_materia, acao){
                //alert(acao);
		document.elaboMateria.codMateria.value = cod_materia;
		document.elaboMateria.executar.value = acao;
		document.elaboMateria.action = "elabomatbi.php?codTipoBol="+document.elaboMateria.seleTipoBol.value;
		document.elaboMateria.submit();
	}
	
	</script>

</head>
<body>

<center>
	<? 	$apresentacao->chamaCabec();
		$apresentacao->montaMenu();
		$apresentacao->montaFlyForm(700,350,'#D5EADC');
		if (isset($_POST['executar'])){
			$materia = $fachadaSist2->lerRegistroMateriaBI($_POST['codMateria']);
//			if ($_POST['executar'] == "Concluir"){
				$fachadaSist2->concluirMateriaBi($materia);
//			}
			// v 2.3 - vincenzo
			if (($_POST['executar'] == "Correcao")){
				$fachadaSist2->cancelarAprovarMateriaBi($materia);
			}
  		}
	?>

	<h3 class="titulo">&nbsp;&nbsp;<img src="./imagens/item_dir.gif" alt="">&nbsp;Elabora��o de Nota para Boletim</h3>
	<form name="elaboMateria" action="elabomateria.php" method="post">
	<input type="hidden" name="codMateria" value="">
	<input type="hidden" name="executar" value="">
	<br>
	<?
		echo 'Tipo de Boletim:&nbsp;';
		if ($_SESSION['NOMEUSUARIO'] == 'supervisor'){
			$colTipoBol = $fachadaSist2->lerColecaoTipoBol('descricao');
		}else{
		    $colTipoBol = $fachadaSist2->lerColecaoAutorizadaTipoBol($_SESSION['NOMEUSUARIO'], 2004);
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
	 	$apresentacao->montaCombo('seleTipoBol',$colTipoBol,'getCodigo','getDescricao',$codTipoBolAtual,'tipoBol()');
	?>
	<table width="500" border="0" ><tr>
	<td valign="bottom" width="3%"><div id="mensagem" class="processa" style="visibility:hidden"><img src="imagens/ajax-loader.gif" alt=""></div></td>
	<td><div id="divMatBi">&nbsp;</div></td></tr></table>
	
    
    
    <?
        //verifica permissao para inclus�o
        if ($_SESSION['NOMEUSUARIO'] != 'supervisor')
        { $mIncluir = $fachadaSist2->lerUsuarioFuncaoCodTipoBol($_SESSION['NOMEUSUARIO'],2001,$codTipoBolAtual);
        }
        if (($mIncluir != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor'))
        { echo '<table width="890" border="0" >';
		  //vs 2.2
//		  if (($_SESSION['APROVNOTA1']=='S')&&($_SESSION['APROVNOTA2']=='S')){
//			echo '<TR><TD width="100%" align="left"></TD></TR>';
//		  }
//		  if (($_SESSION['APROVNOTA1']=='N')&&($_SESSION['APROVNOTA2']=='N')){
//		  }
//		  if (($_SESSION['APROVNOTA1']=='S')&&($_SESSION['APROVNOTA2']=='N')){
//		  }
//		  if (($_SESSION['APROVNOTA1']=='N')&&($_SESSION['APROVNOTA2']=='S')){
//		  }
          echo '<TD align="left">';
	      echo '&nbsp;&nbsp;&nbsp;<a href="javascript:novo()" id="novo">';
              echo '<img src="./imagens/add.png" border=0 alt=""><FONT COLOR="#0080C0"> Adicionar</FONT></a>';
	      echo '</TD></TR></TABLE>';
  	    }
	?>
    
    <br>
	<table width="900px" border="0" cellspacing="0"  class="lista"><tr><td>
	<table width="100%" border="0" cellspacing="1" cellpadding="0">
	<tr class="cabec">
		<td width="5%"><div align="center"><strong><font size="2">Ord</font></strong></div></td>
		<td width="5%" align="center"><strong><font size="2">Status</font></strong></td>
		<td width="10%"><div align="center"><strong><font size="2">Nr Nota<a href="javascript:ordena('cod_materia_bi DESC')"><img src="./imagens/seta_down2.gif" title="Ordenar" border=0></a></font></strong></div></td>
		<td width="20%" align="center"><strong><font size="2">Assunto Espec�fico<a href="javascript:ordena('descr_ass_esp, codom, cod_subun, data_materia_bi DESC')"><img src="./imagens/seta_down2.gif" title="Ordenar" border=0></a></font></strong></td>
		<td width="8%" align="center"><strong><font size="2">Data<a href="javascript:ordena('data_materia_bi DESC, codom, cod_subun')"><img src="./imagens/seta_down2.gif" title="Ordenar" border=0></a></font></strong></td>
		<td width="10%" align="center"><strong><font size="2">OM Vinc<a href="javascript:ordena('codom, cod_subun, data_materia_bi DESC')"><img src="./imagens/seta_down2.gif" title="Ordenar" border=0></a></font></strong></td>
		<td width="12%" align="center"><strong><font size="2">SU/Div/Sec<a href="javascript:ordena('cod_subun, codom, data_materia_bi DESC')"><img src="./imagens/seta_down2.gif" title="Ordenar" border=0></a></font></strong></td>
		<td width="10%" align="center"><strong><font size="2">Usu�rio<a href="javascript:ordena('usuario, codom, cod_subun, data_materia_bi DESC')"><img src="./imagens/seta_down2.gif" title="Ordenar" border=0></a></font></strong></td>
		<td width="20%" align="center"><strong><font size="2">A��o</font></strong></td>
	</tr>

	  <?php
		if (isset($_GET['acao'])){
			$codMateriaBIAtual = $_GET['codMateriaBIAtual'];
			$materiaBi = $fachadaSist2->lerRegistroMateriaBI($codMateriaBIAtual);
  			if ($_GET['acao'] == 'Incluir'){
				$fachadaSist2->incluirParteBoletim($parteBoletim);
			}
			if ($_GET['acao'] == 'Excluir'){
				$fachadaSist2->excluirMateriaBi($materiaBi);
			}
			if ($_GET['acao'] == 'Inserir'){
				//$fachadaSist2->alterarComentario($materiaBi);
			echo 'teta';
			}
  		}
		//lerColMateriaBITipoBolAprov($codTipoBol, $aprovada, $order)
		//vs 2.2
		if (($_SESSION['APROVNOTA1']=='S')&&($_SESSION['APROVNOTA2']=='S')){
			$filtraNota = "N,E";									
		}
		if (($_SESSION['APROVNOTA1']=='N')&&($_SESSION['APROVNOTA2']=='N')){
			$filtraNota = "C,N,E,K";									
		}
		if (($_SESSION['APROVNOTA1']=='S')&&($_SESSION['APROVNOTA2']=='N')){
			$filtraNota = "N,E,X";									
		}
		if (($_SESSION['APROVNOTA1']=='N')&&($_SESSION['APROVNOTA2']=='S')){
			$filtraNota = "N,E,X";
		}

		$colMatBITipoBolAprov = $fachadaSist2->lerColMateriaBITipoBolAprov($codTipoBolAtual,$filtraNota,$ordem,'N',$apresentacao->getCodom(),$apresentacao->getCodSubun(),$apresentacao->getTodasOmVinc(),$apresentacao->getTodasSubun());
  		$Materia_BI = $colMatBITipoBolAprov->iniciaBusca1();
                $ord = 0;
  		while ($Materia_BI != null){
        		if ($Materia_BI->getCodom() != null){
                            $omVinc = $fachadaSist2->lerOMVinc($Materia_BI->getCodom());
                            $siglaOmVinv = $omVinc->getSigla();
                        }else{
                            $siglaOmVinv = 'Indef';
                        }
                        if (($Materia_BI->getCodom() != null)&&($Materia_BI->getCodSubun() != null)){
                                $subun = $fachadaSist2->lerSubun($Materia_BI->getCodom(), $Materia_BI->getCodSubun());
                                $siglaSubun = $subun->getSigla();
                        }else{
                                $siglaSubun = 'Indef    ';
                        }
			$ord++;
			echo '<tr id='.$ord.' onMouseOut="outLinha('.$ord.')" onMouseOver="overLinha('.$ord.')" bgcolor="#F5F5F5">
				<td align="center">'.$ord.'</td>
				<td align="center">'.$apresentacao->retornaStatus($Materia_BI->getAprovada()).'</td>
				<td align="center">'.$Materia_BI->getCodigo().'</td>
				<td align="left">'.$Materia_BI->getDescrAssEsp().'</td>
				<td align="center">'.$Materia_BI->getData()->GetcDataDDBMMBYYYY().'</td>
				<td align="center">'.$siglaOmVinv.'</td>
				<td align="center">'.$siglaSubun.'</td>
				<td align="center">'.$Materia_BI->getUsuario().'</td>
				<td align="center">';

				// permissao para aprovar a nota
				// nivel de 2 aprovacoes
				// adicionado sgt vincenzo 28/06/2012
				// versao 2.3
				if (($_SESSION['APROVNOTA1']=='S')&&($_SESSION['APROVNOTA2']=='S'))
				{
					if (($Materia_BI->getAprovada() == 'N') || ($Materia_BI->getAprovada() == 'E')){
						echo '<a href="javascript:conclui('.$Materia_BI->getCodigo().',\'Concluir\')">
							<img src="./imagens/nok.png"  border=0 title="Enviar para aprova��o"><FONT COLOR="#000000"></FONT></a>';
					}else{
						echo '&nbsp;-&nbsp;';
					}
					echo '&nbsp;|&nbsp;';
				} else

				// permissao para aprovar a nota
				// nivel de 1 aprovacao
				// adicionado sgt vincenzo 28/06/2012
				// versao 2.3
//				if ((($_SESSION['APROVNOTA1']=='N')&&($_SESSION['APROVNOTA2']=='S'))||(($_SESSION['APROVNOTA1']=='S')&&($_SESSION['APROVNOTA2']=='N')) )
				{
					if (($Materia_BI->getAprovada() == 'N') || ($Materia_BI->getAprovada() == 'E') || ($Materia_BI->getAprovada() == 'X')){
						echo '<a href="javascript:conclui('.$Materia_BI->getCodigo().',\'Concluir\')">
							<img src="./imagens/nok.png"  border=0 title="Enviar para aprova��o"><FONT COLOR="#000000"></FONT></a>';
					}else{
						echo '&nbsp;-&nbsp;';
					}
					echo '&nbsp;|&nbsp;';
				}

            //marco
			//verifica permissao para alterar
   	        if ($_SESSION['NOMEUSUARIO'] != 'supervisor')
       	    { //$mAlterar = $funcoesPermitidas->lerRegistro(2002);
       	      $mAlterar = $fachadaSist2->lerUsuarioFuncaoCodTipoBol($_SESSION['NOMEUSUARIO'],2002,$codTipoBolAtual);
           	}
            if (($mAlterar != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor'))
		    {
				// versao 2.3 - vincenzo
				// sem niveis
				if (($_SESSION['APROVNOTA1']=='N')&&($_SESSION['APROVNOTA2']=='N'))
				{
					if (($Materia_BI->getAprovada() == 'N') || ($Materia_BI->getAprovada() == 'E'))
					{
						echo '<a href="javascript:carregaedit('.$Materia_BI->getCodigo().',\''.$Materia_BI->getMilitarAss()->getIdMilitar().'\',\'Alterar\',\''.$Materia_BI->getAprovada().'\',document.elaboMateria.seleTipoBol.value)"><img src="./imagens/alterar.png"  border=0 title="Alterar" alt=""></a>&nbsp;|&nbsp';
					} else
					{
						echo '&nbsp;-&nbsp';
						echo '&nbsp;|&nbsp';
					}
				} else
				// com niveis de aprovacao
				{
					echo '<a href="javascript:carregaedit('.$Materia_BI->getCodigo().',\''.$Materia_BI->getMilitarAss()->getIdMilitar().'\',\'Alterar\',\''.$Materia_BI->getAprovada().'\',document.elaboMateria.seleTipoBol.value)"><img src="./imagens/alterar.png"  border=0 title="Alterar" alt=""></a>&nbsp;|&nbsp';					
				}
		    }

            //verifica permissao para excluir
   	        if ($_SESSION['NOMEUSUARIO'] != 'supervisor')
       	    { //$mExcluir = $funcoesPermitidas->lerRegistro(2003);
       	      $mExcluir = $fachadaSist2->lerUsuarioFuncaoCodTipoBol($_SESSION['NOMEUSUARIO'],2003,$codTipoBolAtual);
           	}
            if (($mExcluir != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor'))
   	        {
				// versao 2.3 - vincenzo
				// sem niveis
				if (($_SESSION['APROVNOTA1']=='N')&&($_SESSION['APROVNOTA2']=='N'))
				{
					if (($Materia_BI->getAprovada() == 'N') || ($Materia_BI->getAprovada() == 'E'))
					{
						echo '<a href="javascript:carregaedit('.$Materia_BI->getCodigo().',\''.$Materia_BI->getMilitarAss()->getIdMilitar().'\',\'Excluir\')"><img src="./imagens/excluir.png" border=0 title="Excluir" alt=""></a>&nbsp;|&nbsp';
					} else
					// Retirar do boletim - como correcao
					// versao 2.3 - vincenzo
					{
						echo '<a href="javascript:aprova('.$Materia_BI->getCodigo().',\'Correcao\')"><img src="./imagens/voltarcorrecao.png"  border=0 title="Voltar para corre��o" alt=""><FONT COLOR="#000000"></FONT></a>&nbsp;|&nbsp';
					}
				} else
				// com niveis
				{
					echo '<a href="javascript:carregaedit('.$Materia_BI->getCodigo().',\''.$Materia_BI->getMilitarAss()->getIdMilitar().'\',\'Excluir\')"><img src="./imagens/excluir.png" border=0 title="Excluir" alt=""></a>&nbsp;|&nbsp';
				}
   	        }

			echo '<a href="javascript:carregaedit('.$Materia_BI->getCodigo().',\'Visualizar\')"
				 onclick="visualizar('.$Materia_BI->getCodigo().','.$ord.')"><img src="./imagens/buscar.gif"  border=0 title="Visualizar" alt=""></a>';

		echo '&nbsp;|&nbsp;';
		// Fun��o para inserir coment�rio nas NBI - Sgt Bedin
		echo '<a href="javascript:carregaedit('.$Materia_BI->getCodigo().',\'Coment�rio\')"
				 onclick="visualizar3('.$Materia_BI->getCodigo().','.$ord.')"><img src="./imagens/chat.jpg"  border=0 title="Coment�rio" alt=""></a>';

		echo '&nbsp;|&nbsp;';
                echo '<a href="javascript:visualizar2('.$Materia_BI->getCodigo().')"><img src="./imagens/b_print.png"  border=0 title="Gerar PDF"></a></td></tr>';

    		$Materia_BI = $colMatBITipoBolAprov->getProximo1();
  		}
  		echo '</table></td></tr></table>';
		?>
	</form>
	<br>
	<u><strong>Status</strong></u><strong>: </strong>
    <img src="imagens/notanova.png" width="16" height="16"> Nova 
    <img src="imagens/correcao.png" width="16" height="16"> Corre&ccedil;&atilde;o
	<?
	//versao 2.3
	if (($_SESSION['APROVNOTA1']=='N')&&($_SESSION['APROVNOTA2']=='N')){
		echo '<img src="imagens/concluir.png" width="16" height="16">Para publica&ccedil;&atilde;o';		
	}
	?>
    &nbsp;|&nbsp; <strong><u>A��o</u>:</strong>&nbsp;
	<?
	//versao 2.3
	if (($_SESSION['APROVNOTA1']=='N')&&($_SESSION['APROVNOTA2']=='N')){
		echo '<img src="imagens/nok.png" width="14" height="14"> Aprovar';		
	} else
	{
		echo '<img src="imagens/nok.png" width="14" height="14"> Enviar para Aprova��o';
	}
	?>
    <img src="imagens/alterar.png" width="16" height="16"> Alterar&nbsp;&nbsp;
    <img src="imagens/excluir.png" width="16" height="16"> Excluir &nbsp;
	<?
	//versao 2.3
	if (($_SESSION['APROVNOTA1']=='N')&&($_SESSION['APROVNOTA2']=='N')){
		echo '<img src="./imagens/voltarcorrecao.png" width="14" height="14">Voltar p/ corre&ccedil;&atilde;o';
	}
	?>
	<img src="imagens/chat.jpg" width="16" height="16"> Observa��o
    <img src="imagens/buscar.gif" width="16" height="16"> Visualizar Nota
</center>
</body>
</html>
