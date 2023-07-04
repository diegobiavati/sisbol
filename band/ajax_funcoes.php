<? 	session_start();
	//require('filelist.php');
	require_once('./filelist_geral.php');
	require_once('./filelist_funcao.php');
	require_once('./filelist_militar.php');
	require_once('./filelist_pgrad.php');
	require_once('./filelist_qm.php');
	require_once('./filelist_om.php');
	$fachadaSist2 = new FachadaSist2();
    $funcoesPermitidas = $fachadaSist2->lerColecaoAutorizada($_SESSION['NOMEUSUARIO'], 'X');
	$apresentacao = new Apresentacao($funcoesPermitidas);

	if($_GET["opcao"] == "listamilitarfuncao"){
		$codFuncao = $_GET["codfuncao"];
		echo  '<h3><FONT COLOR="#0000FF">'.'Militares na Função'.'</FONT></h3>';
		$colMilitar2 = $fachadaSist2->lerColecaoMilitar("m.pgrad_cod","and p.perm_pub_bi <> 'N' and p.funcao_cod = ".$codFuncao);
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
			echo '<TD>'.$Militar->getNome().' ('.$Militar->getNomeGuerra().')'.'</TD>';
			echo '</TR>';
			$Militar = $colMilitar2->getProximo1();
			if ($ord >= 15){
				echo '<TR><TD align="right" colspan="4" bgcolor="white"><FONT COLOR="#FF0000">De um total de: '
					.$colMilitar2->getQTD().' militares.</FONT></TD></TR>';
				break;
			}
		}
		echo '</table>';
	}
?>
