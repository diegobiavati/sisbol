<? 	session_start();
	require_once('./filelist_geral.php');
	require_once('./filelist_militar.php');
	require_once('./filelist_boletim.php');
	require_once('./filelist_tipodoc.php');
	require_once('./filelist_usuariofuncaotipobol.php');
	require_once ('./filelist_om.php');
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
    <script type="text/javascript" src="scripts/notaBoletim.js"></script>
	<script type="text/javascript" src="scripts/flyform.js"></script>
	<script type="text/javascript">
	function tipoBol(codBol){
		window.location.href = "publiquesematbi.php?codTipoBol="+document.publicaMatBi.seleTipoBol.value;
	}
	function aprova(cod_materia, acao){
		document.publicaMatBi.codMateria.value = cod_materia;
		document.publicaMatBi.executar.value = acao;
		document.publicaMatBi.action = "publiquesematbi.php?codTipoBol="+document.publicaMatBi.seleTipoBol.value;
		document.publicaMatBi.submit();
		// Alterado por Ten S.Lopes -- 06/03/2012 -- código anterior = "ordena("cod_materia_bi DESC");" não funciona nas versões do Firefox acima da 3.6
		document.ordena("cod_materia_bi DESC"); 

	}
	function visualizar(codMateriaBI,linha){
		document.getElementById("subscrForm").style.left = 50 + "px";
		document.getElementById("flyframe").style.visibility = "visible";
		document.getElementById('subscrForm').style.visibility = 'visible';
		document.getElementById('buscador').innerHTML =
  		'<table width="95%" border="0"><tr><td><b><FONT FACE="Arial" COLOR="#0000FF">Nota nº: '
		  +codMateriaBI+'<\/FONT><\/b><\/td><td align="right"><input type="button" value="Fechar" onclick="javascript:escondeFly()"><\/td><\/tr><\/table>';
  		//'<b>Nota nº: '+codMateriaBI+'<\/b>';
  		isrc="ajax_aprovamatbi.php?opcao=aprovaMateriaBI&codMateriaBI="+codMateriaBI;
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
	// Função para inserir comentário nas NBI - Sgt Bedin
	function visualizar3(codMateriaBI,linha,alturaForm){
		document.getElementById("subscrForm").style.left = 50 + "px";
		document.getElementById("flyframe").style.visibility = "visible";
		document.getElementById('subscrForm').style.visibility = 'visible';
		document.getElementById('buscador').innerHTML =
  		'<table width="95%" border="0"><tr><td><b><FONT FACE="Arial" COLOR="#0000FF">Nota nº: '
		  +codMateriaBI+'<\/FONT><\/b><\/td><td align="right"><input type="button" value="Fechar" onclick="javascript:escondeFly()"><\/td><tr><td>Digite seu comentário: <\/FONT><\/b><input type="text" size="90" maxlength="150" id="textoComentario"><\/td><td align="right"><input type="button" name="Enviar" id="Enviar" value="Enviar" onclick="javascript:enviaComentario('+codMateriaBI+')"><\/td><\/tr><\/table>';
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
	function escondeFly(){
		document.getElementById("flyframe").style.visibility = "hidden";
		document.getElementById('subscrForm').style.visibility = 'hidden';
	}
	// Função para inserir comentário nas NBI - Sgt Bedin
	function enviaComentario(codMateriaBI) {
	var priletra = document.getElementById("textoComentario").value;
	var letrasvalidas = priletra.search("[^a-z' '0-9A-ZãÃáÁàÀêÊéÉèÈíÍìÌôÔõÕóÓòÒúÚùÙûÛçÇ.;:,@-_ºª]+$"); 
	if (priletra == "") {
	alert('Digite uma mensagem!');
	   
		return false; 
		}
	if(priletra.length > 0 &&  letrasvalidas >= 0) 
	{ 
	    alert('Há caracteres inválidos na mensagem!');
	   
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
  		'<table width="95%" border="0"><tr><td><b><FONT FACE="Arial" COLOR="#0000FF">Nota nº: '
		  +codMateriaBI+'<\/FONT><\/b><\/td><td align="right"><input type="button" value="Fechar" onclick="javascript:escondeFly()"><\/td><tr><td>Digite seu comentário: <\/FONT><\/b><input type="text" size="90" maxlength="150" id="textoComentario"><\/td><td align="right"><input type="button" name="Enviar" id="Enviar" value="Enviar" onclick="javascript:enviaComentario('+codMateriaBI+')"><\/td><\/tr><\/table>';
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
	// Função para inserir comentário nas NBI - Sgt Bedin
    function ordena(ordem){
		window.location.href="publiquesematbi.php?codTipoBol="+document.publicaMatBi.seleTipoBol.value+"&ordem="+ordem;
        }
	function atualizaTela(resposta){
		document.getElementById('mensagem').style.visibility = "hidden";
		document.getElementById('divMatBi').innerHTML = "";
		viewPDF2(resposta);;
	}
	</script>
<style type="text/css">
.negr {
	font-weight: bold;
}
.negrito {	font-weight: bold;
}
</style>
</head>
<body><center>
	<? 	$apresentacao->chamaCabec();
		$apresentacao->montaMenu();
		$apresentacao->montaFlyForm(700,350,'#DDEDFF');
		if (isset($_POST['executar'])){
			//echo ($_POST['executar']);
                        $materia = $fachadaSist2->lerRegistroMateriaBI($_POST['codMateria']);
			if ($_POST['executar'] == "Aprovar"){
				$fachadaSist2->publicarMateriaBi($materia);
			}
			if (($_POST['executar'] == "Cancelar") || ($_POST['executar'] == "Correcao")){
//				$materia->setAprovada('K');
				$fachadaSist2->cancelarPublicarMateriaBi($materia);
			}
			
			
  		}
	?>

	<h3 class="titulo">&nbsp;&nbsp;<img src="./imagens/item_dir.gif" alt="">&nbsp;Aprovação de Nota para Boletim (Cmt/Ch/Dir)</h3>
	<form name="publicaMatBi" action="publicaMatBi.php" method="post">
	<input type="hidden" name="codMateria" value="">
	<input type="hidden" name="executar" value="">
	<?
	echo 'Tipo de Boletim:&nbsp;';
	if ($_SESSION['NOMEUSUARIO'] == 'supervisor') {
		$colTipoBol = $fachadaSist2->lerColecaoTipoBol('descricao');
	} else {
		$colTipoBol = $fachadaSist2->lerColecaoAutorizadaTipoBol($_SESSION['NOMEUSUARIO'],2013);
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
	<br><br>
	<table width="60%" border="0" ><tr>
	<td valign="bottom" width="3%"><div id="mensagem" class="processa" style="visibility:hidden"><img src="imagens/ajax-loader.gif" alt=""></div></td>
	<td><div id="divMatBi">&nbsp;</div></td></tr></table>
	<table width="900px" border="0" cellspacing="0" class="lista">
	  <tr><td>
	<table width="100%" border="0" cellspacing="1" cellpadding="0">
	<tr class="cabec">
		<td width="5%"><div align="center"><strong><font size="2">Ord</font></strong></div></td>
		<td width="5%" align="center"><strong><font size="2">Status</font></strong></td>
		<td width="10%"><div align="center"><strong><font size="2">Nr Nota<a href="javascript:ordena('cod_materia_bi DESC')"><img src="./imagens/seta_down2.gif" title="Ordenar" border=0></a></font></strong></div></td>
		<td width="20%" align="center"><strong><font size="2">Assunto Específico<a href="javascript:ordena('descr_ass_esp, codom, cod_subun, data_materia_bi DESC')"><img src="./imagens/seta_down2.gif" title="Ordenar" border=0></a></font></strong></td>
		<td width="8%" align="center"><strong><font size="2">Data<a href="javascript:ordena('data_materia_bi DESC, codom, cod_subun')"><img src="./imagens/seta_down2.gif" title="Ordenar" border=0></a></font></strong></td>
		<td width="10%" align="center"><strong><font size="2">OM Vinc<a href="javascript:ordena('codom, cod_subun, data_materia_bi DESC')"><img src="./imagens/seta_down2.gif" title="Ordenar" border=0></a></font></strong></td>
		<td width="12%" align="center"><strong><font size="2">SU/Div/Sec<a href="javascript:ordena('cod_subun, codom, data_materia_bi DESC')"><img src="./imagens/seta_down2.gif" title="Ordenar" border=0></a></font></strong></td>
		<td width="10%" align="center"><strong><font size="2">Usuário<a href="javascript:ordena('usuario, codom, cod_subun, data_materia_bi DESC')"><img src="./imagens/seta_down2.gif" title="Ordenar" border=0></a></font></strong></td>
		<td width="20%" align="center"><strong><font size="2">Ação</font></strong></td>
	</tr>
	<?php
	  if(isset($_POST['vetor'])){
		foreach($_POST['vetor'] as $codMatBi){
		  $materiaBi = $fachadaSist2->lerRegistroMateriaBI($codMatBi);
		  $fachadaSist2->aprovarMateriaBi($materiaBi);
	  	}
	  }

										 //lerColMateriaBITipoBolAprov($codTipoBol, $aprovada, $order)
		//$colMatBITipoBolAprov = $fachadaSist2->lerColMateriaBITipoBolAprov($codTipoBolAtual,'','descr_ass_esp', 'N');
		//vs 2.2
		if (($_SESSION['APROVNOTA1']=='S')&&($_SESSION['APROVNOTA2']=='S')){
			$filtraNota = 'A,X,S,E,K';									
		}
		if (($_SESSION['APROVNOTA1']=='N')&&($_SESSION['APROVNOTA2']=='S')){
			$filtraNota = 'A,C,X,S,E,K';									
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
				<td align="center">'.$Materia_BI->getDataDoc()->GetcDataDDBMMBYYYY().'</td>
				<td align="center">'.$siglaOmVinv.'</td>
				<td align="center">'.$siglaSubun.'</td>
				<td align="center">'.$Materia_BI->getUsuario().'</td>
				<td align="center">';

				//alterado sgt vincenzo
				//dia 26/06/2012
                //vs 2.2
				//com 2 niveis de aprovacao
				//permissao para aprovar o documento - publique-se
//				echo "NOTA1".$_SESSION['APROVNOTA1'];
//				echo "NOTA2".$_SESSION['APROVNOTA2']."</br>";

				if (($_SESSION['APROVNOTA1']=='S')&&($_SESSION['APROVNOTA2']=='S')){
				  if (($Materia_BI->getAprovada() == 'A')||($Materia_BI->getAprovada() == 'S')){
					if ($Materia_BI->getAprovada() == 'A')
					{
									 
									 echo '<a href="javascript:aprova('.$Materia_BI->getCodigo().',\'Aprovar\')"><img src="./imagens/ok.png"  border=0 title="Publique-se" alt=""><FONT COLOR="#000000"></FONT></a>'; 
									   echo '&nbsp;|&nbsp;'; 
//									   echo '<a href="javascript:aprova('.$Materia_BI->getCodigo().',\'Cancelar\')"><img src="./imagens/voltarcorrecao.png"  border=0 title="Voltar para correção" alt=""><FONT COLOR="#000000"></FONT></a>';
//                    }
					//verifica permissao para alterar o documento
					if ($_SESSION['NOMEUSUARIO'] != 'supervisor')
					{ //$mAlterar = $funcoesPermitidas->lerRegistro(2002);
					  $mAlterar = $fachadaSist2->lerUsuarioFuncaoCodTipoBol($_SESSION['NOMEUSUARIO'],2002,$codTipoBolAtual);
					}
					if (($mAlterar != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor'))
					{
						//inserido em 22/06 - retirar o icone de editar quando nao aprovada ou corrigida
//						if (($Materia_BI->getAprovada() == 'A'))
//						{
						 echo '<a href="javascript:carregaedit('.$Materia_BI->getCodigo().',\''.$Materia_BI->getMilitarAss()->getIdMilitar().'\',\'Alterar\',\''.$Materia_BI->getAprovada().'\' ,document.publicaMatBi.seleTipoBol.value)"><img src="./imagens/alterar.png"  border=0 title="Alterar" alt=""></a>&nbsp;|&nbsp';
//						} else
//						{
//						echo '&nbsp;-&nbsp;&nbsp;|&nbsp';
//						}
					}	
//					if ($Materia_BI->getAprovada() == 'A'){
									 
//									 echo '<a href="javascript:aprova('.$Materia_BI->getCodigo().',\'Aprovar\')"><img src="./imagens/ok.png"  border=0 title="Publique-se" alt=""><FONT COLOR="#000000"></FONT></a>'; 
//									   echo '&nbsp;|&nbsp;'; 
									   echo '<a href="javascript:aprova('.$Materia_BI->getCodigo().',\'Cancelar\')"><img src="./imagens/voltarcorrecao.png"  border=0 title="Voltar para correção" alt=""><FONT COLOR="#000000"></FONT></a>&nbsp;|&nbsp';
                    }
					if ($Materia_BI->getAprovada() == 'S'){
                                    echo '&nbsp;-&nbsp;';
                                    echo '&nbsp;|&nbsp;';
                                    echo '&nbsp;-&nbsp;';
                                    echo '&nbsp;|&nbsp;';
                                    echo '<a href="javascript:aprova('.$Materia_BI->getCodigo().',\'Cancelar\')"><img src="./imagens/voltarcorrecao.png"  border=0 title="Voltar para correção" alt=""><FONT COLOR="#000000"></FONT></a>&nbsp;|&nbsp';
					}                                    
				  } else {
                                    echo '&nbsp;-&nbsp;';
                                    echo '&nbsp;|&nbsp;';
                                    echo '&nbsp;-&nbsp;';
                                    echo '&nbsp;|&nbsp;';
                                    echo '&nbsp;-&nbsp;';
                                    echo '&nbsp;|&nbsp;';
                  }
				}


				//alterado sgt vincenzo
				//dia 26/06/2012
                //vs 2.2
				//com 1 nivel de aprovacao
				//permissao para aprovar o documento - publique-se
				if (($_SESSION['APROVNOTA1']=='N')&&($_SESSION['APROVNOTA2']=='S')){
//				  if (($Materia_BI->getAprovada() == 'C')||($Materia_BI->getAprovada() == 'K')||($Materia_BI->getAprovada() == 'S')){
				// alterado sgt vincenzo
				// dia 28/06/2012
				  if (($Materia_BI->getAprovada() == 'A')||($Materia_BI->getAprovada() == 'C')||($Materia_BI->getAprovada() == 'K')||($Materia_BI->getAprovada() == 'S')){

					if (($Materia_BI->getAprovada() == 'A')||($Materia_BI->getAprovada() == 'C')||($Materia_BI->getAprovada() == 'K'))
					{
                                    echo '<a href="javascript:aprova('.$Materia_BI->getCodigo().',\'Aprovar\')"><img src="./imagens/ok.png"  border=0 title="Publique-se" alt=""><FONT COLOR="#000000"></FONT></a>|&nbsp';
									//verifica permissao para alterar o documento
									// inserido sgt vincenzo 28/06/2012
									if ($_SESSION['NOMEUSUARIO'] != 'supervisor')
									{
									  $mAlterar = $fachadaSist2->lerUsuarioFuncaoCodTipoBol($_SESSION['NOMEUSUARIO'],2002,$codTipoBolAtual);
									}
									if (($mAlterar != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor'))
									{
										 echo '<a href="javascript:carregaedit('.$Materia_BI->getCodigo().',\''.$Materia_BI->getMilitarAss()->getIdMilitar().'\',\'Alterar\',\''.$Materia_BI->getAprovada().'\' ,document.publicaMatBi.seleTipoBol.value)"><img src="./imagens/alterar.png"  border=0 title="Alterar" alt=""></a>&nbsp;|&nbsp';
									} else
									{	
										echo '&nbsp;-&nbsp;';
										echo '&nbsp;|&nbsp;';
									}
                                    echo '<a href="javascript:aprova('.$Materia_BI->getCodigo().',\'Cancelar\')"><img src="./imagens/voltarcorrecao.png"  border=0 title="Voltar para correção" alt=""><FONT COLOR="#000000"></FONT></a>&nbsp;|&nbsp';
                    }
					if ($Materia_BI->getAprovada() == 'S'){
                                    echo '&nbsp;-&nbsp;';
                                    echo '&nbsp;|&nbsp;';
                                    echo '&nbsp;-&nbsp;';
                                    echo '&nbsp;|&nbsp;';
                                    echo '<a href="javascript:aprova('.$Materia_BI->getCodigo().',\'Correcao\')"><img src="./imagens/voltarcorrecao.png"  border=0 title="Voltar para correção" alt=""><FONT COLOR="#000000"></FONT></a>&nbsp;|&nbsp';
					}                                    
				  } else {
                                    echo '&nbsp;-&nbsp;';
                                    echo '&nbsp;|&nbsp;';
                                    echo '&nbsp;-&nbsp;';
                                    echo '&nbsp;|&nbsp;';
                                    echo '&nbsp;-&nbsp;';
                                    echo '&nbsp;|&nbsp;';
                  }
				}
		                
			// icone de visualizar o documento
			
				echo '<a href="javascript:carregaedit('.$Materia_BI->getCodigo().',\'Visualizar\')" onclick="visualizar('.$Materia_BI->getCodigo().','.$ord.')"><img src="./imagens/buscar.gif"  border=0 title="Visualizar" alt=""></a>';
				echo '&nbsp;|&nbsp;';
				// Função para inserir comentário nas NBI - Sgt Bedin
				echo '<a href="javascript:carregaedit('.$Materia_BI->getCodigo().',\'Comentário\')"
				 onclick="visualizar3('.$Materia_BI->getCodigo().','.$ord.')"><img src="./imagens/chat.jpg"  border=0 title="Comentário" alt=""></a>';

		echo '&nbsp;|&nbsp;';
            			echo '<a href="javascript:visualizar2('.$Materia_BI->getCodigo().')"><img src="./imagens/b_print.png"  border=0 title="Gerar PDF" alt=""></a></td></tr>';
    		$Materia_BI = $colMatBITipoBolAprov->getProximo1();
  		}
		?>
	  </table></td></tr>
    </table>
	  <table width="75%" border="0" cellspacing="0" >
		<tr>
		  <td>
			<font>
			<!--
			<td width="78%" align="right"><a href="javascript:marcaTudo(document.publicaMatBi,true)">Marcar tudo</a>&nbsp;/&nbsp;
			<a href="javascript:marcaTudo(document.publicaMatBi,false)">Desmarcar tudo</a></font></td>
			<td width="12%" align="center"><img src="./imagens/seta.png" border=0></td>
			<td width="10%" align="right"><input name="aprovar" type="button" value="Aprovar" onclick="aprova()"></td>-->
		</font>
			<TABLE width="100%" border="0">
			  <TR>
			    <TD align="left" valign="middle"><?
//retirado pelo sgt vincenzo
// dia 26/06/2012
/*        		  if (($_SESSION['APROVNOTA1']=='S')&&($_SESSION['APROVNOTA2']=='S')){
                               
		          }
        		  if (($_SESSION['APROVNOTA1']=='N')&&($_SESSION['APROVNOTA2']=='S')){
				echo '<img src="./imagens/concluida.png" title="Conclu&iacute;da" border=0 alt="">Conclu&iacute;da&nbsp;&nbsp;
        		        <img src="./imagens/correcao.png" title="Em corre&ccedil;&atilde;o" border=0 alt="">Em corre&ccedil;&atilde;o&nbsp;&nbsp;<br>
                		<img src="./imagens/corrigida.png" title="Corrigida" border=0 alt="">Corrigida&nbsp;&nbsp;
		                <img src="./imagens/concluir.png" title="Para publica&ccedil;&atilde;o" border=0 alt="">Para publica&ccedil;&atilde;o&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</TD>';
		          } */
				?>
	          </TR>
      </TABLE></td></tr></table>
	</form>
  <p><span class="negrito"><u>Status</u>: </span> <img src="./imagens/notanova.png" title="Nova" border=0 alt="">Nova  <img src="./imagens/corrigida.png" title="Corrigida" border=0 alt="">Corrigida&nbsp;&nbsp; <img src="./imagens/correcao.png" title="Correcao" border=0 alt="">Em corre&ccedil;&atilde;o&nbsp;&nbsp;<img src="imagens/concluir.png" width="16" height="16">Para publica&ccedil;&atilde;o|&nbsp;<u><strong>Ação</strong></u>:<img src="./imagens/ok.png" title="Aprovar" border=0 alt="">Publicar <img src="./imagens/alterar.png" title="Alterar" border=0 alt="">Alterar&nbsp;&nbsp; <img src="./imagens/voltarcorrecao.png" title="Voltar para corre&ccedil;&atilde;o" border=0 alt="">Voltar p/ corre&ccedil;&atilde;o&nbsp;&nbsp; <img src="imagens/chat.jpg" width="16" height="16"> Observação <img src="./imagens/buscar.gif" title="Visualizar Mat&eacute;ria" border=0 alt="">Visualizar Nota&nbsp;&nbsp;&nbsp;</p>
  </p>
  </center>

</body>
</html>
