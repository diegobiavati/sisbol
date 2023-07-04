<? 	session_start();
	require_once('./filelist_geral.php');
	require_once('./filelist_boletim.php');
	require_once('./filelist_tipodoc.php');
	require_once('./filelist_funcao.php');
	require_once('./filelist_militar.php');
	require_once('./filelist_pgrad.php');
	require_once('./filelist_usuariofuncaotipobol.php');
	$fachadaSist2 = new FachadaSist2();
    $funcoesPermitidas = $fachadaSist2->lerColecaoAutorizada($_SESSION['NOMEUSUARIO'], 'X');
	$apresentacao = new Apresentacao($funcoesPermitidas);
?>
<html>
<head>
	<?  $apresentacao->chamaEstilo();

	?>
	<link href="common_codethat.css" rel="stylesheet" type="text/css">
	<script src="scripts/band.js"></script>
	<script type="text/javascript" src="scripts/Bs_Tree.class.js"></script>
	<script type="text/javascript" src="scripts/Bs_TreeElement.class.js"></script>
	<script type="text/javascript" src="scripts/Bs_Array.class.js"></script>
	<script type="text/javascript">
	var a = new Array;
	var vicodBol;
	var vparteBoletim;
	var vsecaoParteBi;
	var boletim = '';
	function Boletim(){
		var tipoBol = document.buscaBoletim.seleTipoBol.value;
		window.location.href= "mapa_assuntos.php?tipoBol="+tipoBol;
	}
	function tipoBol(){
		window.location.href = "mapa_assuntos.php?tipoBol="+document.buscaBoletim.seleTipoBol.value;
	}
	function init() {
		//alert(a[2]['children'][0]['caption']);
  		t = new Bs_Tree();
  		t.imageDir = 'imagens/';
  		t.initByArray(a);
  		t.drawInto('treeDiv1');
  		//var path = new Array('yahoo');
  		//var tNode = t.getElementByCaptionPath(path);
		//tNode.expandAll();
	}
	
	<?
	if(isset($_GET['tipoBol'])){
		$icodBol =  $_GET['codBol'];
		echo 'passou!';
		//$boletim = $fachadaSist2->lerBoletimPorCodigo($icodBol);
		//$Bol = "'<img src=\'./imagens/boletim.gif\'>".$boletim->getNumeroBi().", de ".$boletim->getDataPub()->GetcDataDDBMMBYYYY()."';";
		//echo "boletim = ".$Bol;

		$colParteBoletim2 = $fachadaSist2->lerColecaoParteBoletim('numero_parte');
		$parteBoletim = $colParteBoletim2->iniciaBusca1();
		$i = 0;
		while ($parteBoletim != null){
			//$i = $parteBoletim->getNumeroParte();
		    echo "a[".$i."] = new Array;\n";
			echo "a[".$i."]['caption'] = '<b>".$parteBoletim->getNumeroParte()."-".$parteBoletim->getDescricao()."</b>';\n";
			echo "a[".$i."]['icon']    = \"parte.gif\";\n";
	    	echo "a[".$i."]['isOpen']  = true;\n";


	    	$colSecaoParteBi2 = $fachadaSist2->lerColecaoSecaoParteBi($parteBoletim->getNumeroParte());
	  		$secaoParteBi = $colSecaoParteBi2->iniciaBusca1();
			echo "a[".$i."]['children'] = new Array;\n";
			$ordSecao = 0;
			$b[$i] = 0;
	  		while ($secaoParteBi != null){
			  	echo "a[".$i."]['children'][".$ordSecao."] = new Array;\n";
			  	echo "a[".$i."]['children'][".$ordSecao."]['caption'] = '<font size=\'1\'>".$secaoParteBi->getDescricao()."</font>';\n";
	      		echo "a[".$i."]['children'][".$ordSecao."]['icon'] = \"topic.gif\";\n";
	      		//echo "a[".$i."]['children'][".$ordSecao."]['url'] = 'conAuditoria.php?cod_usuario=&descitem=';\n";
	      		echo "a[".$i."]['children'][".$ordSecao."]['target']  = \"right\";\n";
	      		echo "a[".$i."]['children'][".$ordSecao."]['isOpen']  = true;\n";

	      		$colAssGer =  $fachadaSist2->lerColecaoAssuntoGeral($parteBoletim->getNumeroParte(), $secaoParteBi->getNumeroSecao(), $icodBol);
	      		//$colAssGer =  $fachadaSist2->lerColMateriaParteSecao($icodBol, $parteBoletim->getNumeroParte(), $secaoParteBi->getNumeroSecao());
				$assGer = $colMateria->iniciaBusca1();
				echo "a[".$i."]['children'][".$ordSecao."]['children'] = new Array;\n";
				$ordAssGer = 0;
				$codAssuntGeral = null;
				$ordEspecifico = 0;
				$Loop = 0;
				while ($assGer != null){
					//if($codAssuntGeral != $materia->getAssuntoGeral()->getCodigo()){
					//	if ($Loop != 0){
					//		$ordMateria++;
					//	} else {
					//		$Loop = 1;
					//	}
						echo "a[".$i."]['children'][".$ordSecao."]['children'][".$ordAssGer."] = new Array;\n";
						echo "a[".$i."]['children'][".$ordSecao."]['children'][".$ordAssGer."]['caption'] = '<font size=\'1\'>".$assGer->getDescricao()."</font>';\n";
						echo "a[".$i."]['children'][".$ordSecao."]['children'][".$ordAssGer."]['icon'] = \"marcador.gif\";\n";
	    		  		echo "a[".$i."]['children'][".$ordSecao."]['children'][".$ordAssGer."]['target']  = \"right\";\n";
			      		echo "a[".$i."]['children'][".$ordSecao."]['children'][".$ordAssGer."]['isOpen']  = true;\n";
//						echo "a[".$i."]['children'][".$ordSecao."]['children'][".$ordAssGer."]['url'] = \"javascript:listaMaterias(".$icodBol.",".$parteBoletim->getNumeroParte().",".$secaoParteBi->getNumeroSecao().",".$materia->getAssuntoGeral()->getCodigo().")\";\n";
						//echo "a[".$i."]['children'][".$ordSecao."]['children'][".$ordMateria."]['url'] = \"javascript:listaMaterias(".$materia->.",".$parteBoletim->getNumeroParte().",".$secaoParteBi->getNumeroSecao().")\";\n";
//						echo "a[".$i."]['children'][".$ordSecao."]['children'][".$ordMateria."]['children'] = new Array;\n";
			      		$colAssEsp =  $fachadaSist2->lerColecaoAssuntoEspec($assGer->getCodigo());
						$assEsp = $colAssEsp->iniciaBusca1();
//						$codAssuntGeral = $materia->getAssuntoGeral()->getCodigo();
						$ordEspecifico = 0;
						$Loop = 0;
						while ($assEsp != null){
							echo "a[".$i."]['children'][".$ordSecao."]['children'][".$ordAssGer."]['children'][".$ordAssEsp."] = new Array;\n";
							echo "a[".$i."]['children'][".$ordSecao."]['children'][".$ordAssGer."]['children'][".$ordAssEsp."]['caption'] = '<font size=\'1\'>".$assEsp->getDescricao()."</font>';\n";
							echo "a[".$i."]['children'][".$ordSecao."]['children'][".$ordAssGer."]['children'][".$ordAssEsp."]['icon'] = \"marcador.gif\";\n";
	    			  		echo "a[".$i."]['children'][".$ordSecao."]['children'][".$ordAssGer."]['children'][".$ordAssEsp."]['target']  = \"right\";\n";
			    	  		echo "a[".$i."]['children'][".$ordSecao."]['children'][".$ordAssGer."]['children'][".$ordAssEsp."]['isOpen']  = true;\n";
							$assEsp = $colAssEsp->getProximo1();
						}
//					}

//					echo "a[".$i."]['children'][".$ordSecao."]['children'][".($ordMateria)."]['children'][".$ordEspecifico."] = new Array;\n";
//					echo "a[".$i."]['children'][".$ordSecao."]['children'][".($ordMateria)."]['children'][".$ordEspecifico."]['caption'] = '".$materia->getDescrAssEsp()."';\n";

					//echo "a[".$i."]['children'][".$ordSecao."]['children'][".($ordMateria)."]['children'][".$ordEspecifico."]['url'] = \"javascript:visualizar(".$materia->getCodigo().",".$ord.")\"";


//					echo "a[".$i."]['children'][".$ordSecao."]['children'][".($ordMateria)."]['children'][".$ordEspecifico."]['icon'] = \"item_dir.gif\";\n";
//					echo "a[".$i."]['children'][".$ordSecao."]['children'][".($ordMateria)."]['children'][".$ordEspecifico."]['isOpen']  = true;\n";
//					$ordEspecifico++;
					$assGer = $colAssGer->getProximo1();
				}

			  	$ordSecao++;
			  	$b[$i]++;
			  	$secaoParteBi = $colSecaoParteBi2->getProximo1();
	    	}
	    	$i++;
	    	$parteBoletim = $colParteBoletim2->getProximo1();
		}
	}
	?>
</script>
</head>
<body onLoad="init();"><center>
	<? 	$apresentacao->chamaCabec();
		$apresentacao->montaMenu();
		//$apresentacao->montaFlyForm(550,350,'#EFEFEF',"2");
	?>

	<h3 class="titulo">&nbsp;&nbsp;<img src="./imagens/item_dir.gif">&nbsp;Mapa de Assuntos</h3>
	<form name="buscaBoletim" action="ord_mat_bol.php" method="post">
	<table width="830" border="0" cellspacing="2" cellppading="4"  bgcolor="#F5F5F5"
		style="border-top:1pt solid #006633;border-bottom:1pt solid #006633;border-left:1pt solid #006633;border-right:1pt solid #006633;">
	<tr><td>
<!--	Ano:-->
	<?
	//$colBIAno = $fachadaSist2->getAnosBI();
	//$apresentacao->montaComboAnoBI('seleAno',$colBIAno,$ianoAtual,'listaBoletim()');
	//echo '</td><td>';
	echo 'Tipo de Boletim:&nbsp;';

	if ($_SESSION['NOMEUSUARIO'] == 'supervisor') {
		$colTipoBol = $fachadaSist2->lerColecaoTipoBol('descricao');
	} else {
		$colTipoBol = $fachadaSist2->lerColecaoAutorizadaTipoBol($_SESSION['NOMEUSUARIO'],3023);
	}

	if (isset($_GET['tipoBol'])){
		$codTipoBolAtual = $_GET['tipoBol'];
	}else {
		$obj = $colTipoBol->iniciaBusca1();
		if (!is_null($obj)){
			$codTipoBolAtual = $obj->getCodigo();
		} else {
			$codTipoBolAtual = 0;
		}
	}
 	$apresentacao->montaCombo('seleTipoBol',$colTipoBol,'getCodigo','getDescricao',$codTipoBolAtual,'tipoBol()');
//	echo '</td>';
/*	$colBoletim2 = $fachadaSist2->lerColecaoBi(null,null,$codTipoBolAtual,'desc',$ianoAtual);
		if (isset($_GET['codBoletim'])) {
			$codBolAtual = $_GET['codBoletim'];
		} else {
			$obj = $colBoletim2->iniciaBusca1();
			if (!is_null($obj)) {
				$codBolAtual = $obj->getCodigo();
			} else {
				$codBolAtual = 0;
			}
		}
	echo '</td><td><div id="divNrBoletim"></div>';*/
	?>
	</td><td>
	<input type="button" value="Atualizar" onclick="Boletim()">
	</td></tr>
	</table>

	<div id="meuHint"></div>
	</form>
	<table width="830" border="0"><tr><td align="left" valign="top" width="300">
	<div id="treeDiv1"></div>
	</td>
	<td align="left" width="530" valign="top">&nbsp;
	<div id="divMateria"></div>
	<div id="divMsg"></div>
	</td>
	</tr></table>
</center>
</body>
</html>
