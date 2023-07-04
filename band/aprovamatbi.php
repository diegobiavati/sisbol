<? 	session_start();
	require_once('./filelist_geral.php');
	require_once('./filelist_militar.php');
	require_once('./filelist_boletim.php');
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
<script type="text/javascript" src="scripts/notaBoletim.js"></script>
<script type="text/javascript" src="scripts/flyform.js"></script>
<script type="text/javascript">
	function tipoBol(codBol){
		window.location.href = "aprovamatbi.php?codTipoBol="+document.aprovaMatBi.seleTipoBol.value;
	}
	function aprova(cod_materia, acao){
		document.aprovaMatBi.codMateria.value = cod_materia;
		document.aprovaMatBi.executar.value = acao;
		document.aprovaMatBi.action = "aprovamatbi.php?codTipoBol="+document.aprovaMatBi.seleTipoBol.value;
		document.aprovaMatBi.submit();
		//Ten S.Lopes -- 06/03/2012 -- código anterior = "ordena("cod_materia_bi DESC");" não funcionava nas versões do Firefox acima da 3.6 -- Alterado para o atual.
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
	// 
        function ordena(ordem){
		window.location.href="aprovamatbi.php?codTipoBol="+document.aprovaMatBi.seleTipoBol.value+"&ordem="+ordem;
        }
	function atualizaTela(resposta){
		document.getElementById('mensagem').style.visibility = "hidden";
		document.getElementById('divMatBi').innerHTML = "";
		viewPDF2(resposta);;
	}
	</script>
<style type="text/css">
.negrito {
	font-weight: bold;
}
</style>
</head>
<body>
<center>
  <? 	$apresentacao->chamaCabec();
		$apresentacao->montaMenu();
		$apresentacao->montaFlyForm(700,350,'#DDEDFF');
		if (isset($_POST['executar'])){
			//echo ($_POST['executar']);
			
            $materia = $fachadaSist2->lerRegistroMateriaBI($_POST['codMateria']);
											
						
			if ($_POST['executar'] == "Aprovar"){
				$fachadaSist2->aprovarMateriaBi($materia);
			}
			if (($_POST['executar'] == "Cancelar") || ($_POST['executar'] == "Correcao")){
				$fachadaSist2->cancelarAprovarMateriaBi($materia);
			}
  		}
	?>
  <h3 class="titulo">&nbsp;&nbsp;<img src="./imagens/item_dir.gif" alt="">&nbsp;Aprovação de Nota para Boletim (SU/Div/Sec)</h3>
  <form name="aprovaMatBi" action="aprovamatbi.php" method="post">
    <input type="hidden" name="codMateria" value="">
    <input type="hidden" name="executar" value="">
    <?
	echo 'Tipo de Boletim:&nbsp;';
	if ($_SESSION['NOMEUSUARIO'] == 'supervisor') {
		$colTipoBol = $fachadaSist2->lerColecaoTipoBol('descricao');
	} else {
		$colTipoBol = $fachadaSist2->lerColecaoAutorizadaTipoBol($_SESSION['NOMEUSUARIO'],2011);
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
    <br>
    <br>
    <table width="60%" border="0" >
      <tr>
        <td valign="bottom" width="3%"><div id="mensagem" class="processa" style="visibility:hidden"><img src="imagens/ajax-loader.gif" alt=""></div></td>
        <td><div id="divMatBi">&nbsp;</div></td>
      </tr>
    </table>
    <table width="900px" border="0" cellspacing="0"  class="lista">
      <tr>
       <td><table width="100%" border="0" cellspacing="1" cellpadding="0">
            <tr class="cabec">
              <td width="5%"><div align="center"><strong><font size="2">Ord</font></strong></div></td>
              <td width="5%" align="center"><strong><font size="2">Status</font></strong></td>
              <td width="10%"><div align="center"><strong><font size="2">Nr Nota<a href="javascript:ordena('cod_materia_bi DESC')"><img src="./imagens/seta_down2.gif" title="Ordenar" border=0></a></font></strong></div></td>
              <td width="20%" align="center"><strong><font size="2">Assunto Específico
                <a href="javascript:ordena('descr_ass_esp, codom, cod_subun, data_materia_bi DESC')"><img src="./imagens/seta_down2.gif" title="Ordenar" border=0></a></font></strong></td>
              <td width="8%" align="center"><strong><font size="2">Data
                <a href="javascript:ordena('data_materia_bi DESC, codom, cod_subun')"><img src="./imagens/seta_down2.gif" title="Ordenar" border=0></a></font></strong></td>
              <td width="10%" align="center"><strong><font size="2">OM Vinc
                <a href="javascript:ordena('codom, cod_subun, data_materia_bi DESC')"><img src="./imagens/seta_down2.gif" title="Ordenar" border=0></a></font></strong></td>
              <td width="12%" align="center"><strong><font size="2">SU/Div/Sec
                <a href="javascript:ordena('cod_subun, codom, data_materia_bi DESC')"><img src="./imagens/seta_down2.gif" title="Ordenar" border=0></a></font></strong></td>
              <td width="10%" align="center"><strong><font size="2">Usuário
                <a href="javascript:ordena('usuario, codom, cod_subun, data_materia_bi DESC')"><img src="./imagens/seta_down2.gif" title="Ordenar" border=0></a></font></strong></td>
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

		if (($_SESSION['APROVNOTA1']=='S')&&($_SESSION['APROVNOTA2']=='S')){
			$filtraNota = "C,X,K,E";									
		}
		if (($_SESSION['APROVNOTA1']=='S')&&($_SESSION['APROVNOTA2']=='N')){
			$filtraNota = "C,X,K,E,A";									
		}
		if (($_SESSION['APROVNOTA1']=='N')&&($_SESSION['APROVNOTA2']=='S')){
			$filtraNota = "C,X,K,E,A";									
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
				
				// verifica permissao para aprovar a nota
				if (($Materia_BI->getAprovada() == 'C') || ($Materia_BI->getAprovada() == 'K') || ($Materia_BI->getAprovada() == 'X'))
				{
					echo '<a href="javascript:aprova('.$Materia_BI->getCodigo().',\'Aprovar\')"><img src="./imagens/nok.png"  border=0 title="Aprovar" alt=""><FONT COLOR="#000000"></FONT></a>&nbsp;|&nbsp;';
				} else {
					echo '&nbsp;-&nbsp;';
					echo '&nbsp;|&nbsp;';
				}
			
			//verifica permissao para alterar
   	        if ($_SESSION['NOMEUSUARIO'] != 'supervisor')
       	    { //$mAlterar = $funcoesPermitidas->lerRegistro(2002);
       	      $mAlterar = $fachadaSist2->lerUsuarioFuncaoCodTipoBol($_SESSION['NOMEUSUARIO'],2002,$codTipoBolAtual);
           	}
            if (($mAlterar != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor'))
		    {
				// versao 2.3 - vincenzo
				if (($_SESSION['APROVNOTA1']=='S')&&($_SESSION['APROVNOTA2']=='N'))
				{
					if (($Materia_BI->getAprovada() != 'E') && ($Materia_BI->getAprovada() != 'A'))
					{
						echo '<a href="javascript:carregaedit('.$Materia_BI->getCodigo().',\''.$Materia_BI->getMilitarAss()->getIdMilitar().'\',\'Alterar\',\''.$Materia_BI->getAprovada().'\' ,document.aprovaMatBi.seleTipoBol.value)"><img src="./imagens/alterar.png"  border=0 title="Alterar" alt=""></a>&nbsp;|&nbsp';
					} else
					{
						echo '&nbsp;-&nbsp';
						echo '&nbsp;|&nbsp';
					}
				} else
				{
					if (($Materia_BI->getAprovada() != 'E'))
					{
						echo '<a href="javascript:carregaedit('.$Materia_BI->getCodigo().',\''.$Materia_BI->getMilitarAss()->getIdMilitar().'\',\'Alterar\',\''.$Materia_BI->getAprovada().'\' ,document.aprovaMatBi.seleTipoBol.value)"><img src="./imagens/alterar.png"  border=0 title="Alterar" alt=""></a>&nbsp;|&nbsp';
					} else
					{
						echo '&nbsp;-&nbsp';
						echo '&nbsp;|&nbsp';
					}
				}
		    } else
			{
				echo '&nbsp;-&nbsp;';
			}					
										
				if ($Materia_BI->getAprovada() != 'E'){
                                    echo '<a href="javascript:aprova('.$Materia_BI->getCodigo().',\'Correcao\')"><img src="./imagens/voltarcorrecao.png"  border=0 title="Voltar para correção" alt=""><FONT COLOR="#000000"></FONT></a>';
                                } else {
					echo '&nbsp;-&nbsp;';
                                }
				echo '&nbsp;|&nbsp;';
				echo '<a href="javascript:carregaedit('.$Materia_BI->getCodigo().',\'Visualizar\')" onclick="visualizar('.$Materia_BI->getCodigo().','.$ord.')"><img src="./imagens/buscar.gif"  border=0 title="Visualizar" alt=""></a>';
				echo '&nbsp;|&nbsp;';
		// Função para inserir comentário nas NBI - Sgt Bedin
		echo '<a href="javascript:carregaedit('.$Materia_BI->getCodigo().',\'Comentário\')"
				 onclick="visualizar3('.$Materia_BI->getCodigo().','.$ord.')"><img src="./imagens/chat.jpg"  border=0 title="Comentário" alt=""></a>';

		echo '&nbsp;|&nbsp;';
            			echo '<a href="javascript:visualizar2('.$Materia_BI->getCodigo().')"><img src="./imagens/b_print.png"  border=0 title="Gerar PDF"></a></td></tr>';
    		$Materia_BI = $colMatBITipoBolAprov->getProximo1();
  		}
		
		
		?>
          </table></td>
      </tr>
    </table>
    <table width="80%" align="center" border="0" cellspacing="0">
      <tr>
        <td><TABLE width="88%" border="0" align="center">
          <TR>
            <TD align="left" valign="middle">&nbsp;
              <?
//					if (($_SESSION['APROVNOTA1']=='S')&&($_SESSION['APROVNOTA2']=='S')){
						
//					}
//					if (($_SESSION['APROVNOTA1']=='S')&&($_SESSION['APROVNOTA2']=='N')){
						
//					}	
				?>
            </TR>
        </TABLE></td>
      </tr>
    </table>
  </form>
   <span class="negrito"><u>Status</u>: </span>
   <img src="./imagens/notanova.png" title="Nova" border=0 alt="">Nova&nbsp;
   <img src="./imagens/corrigida.png" title="Corrigida" border=0 alt="">Corrigida&nbsp;&nbsp;
   <img src="./imagens/correcao.png" title="Correcao" border=0 alt="">Em corre&ccedil;&atilde;o&nbsp;
	<?
	//versao 2.3
	if (($_SESSION['APROVNOTA1']=='S')&&($_SESSION['APROVNOTA2']=='N')){
		echo '<img src="imagens/concluir.png" width="16" height="16">Para publica&ccedil;&atilde;o';		
	}
	?>
   |&nbsp;<u><strong>Ação</strong></u><strong>:</strong>
   <img src="./imagens/nok.png" title="Aprovar" border=0 alt="">Aprovar&nbsp;&nbsp;
   <img src="./imagens/alterar.png" title="Alterar" border=0 alt="">Alterar&nbsp;&nbsp;
   <img src="./imagens/voltarcorrecao.png" title="Voltar para corre&ccedil;&atilde;o" border=0 alt="">Voltar p/ corre&ccedil;&atilde;o&nbsp;&nbsp;
   <img src="imagens/chat.jpg" width="16" height="16"> Observação
   <img src="./imagens/buscar.gif" title="Visualizar Mat&eacute;ria" border=0 alt="">Visualizar Nota&nbsp;</p>
  <p>&nbsp;</p>
</center>
</body>
</html>
