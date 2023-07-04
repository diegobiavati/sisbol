<?

session_start();
require_once('./filelist_geral.php');
require_once('./filelist_tipodoc.php');
require_once('./filelist_boletim.php');
require_once('./filelist_funcao.php');
require_once('./filelist_militar.php');
require_once('./filelist_pgrad.php');

$fachadaSist2 = new FachadaSist2();
$funcoesPermitidas = $fachadaSist2->lerColecaoAutorizada($_SESSION['NOMEUSUARIO'], 'X');
$apresentacao = new Apresentacao($funcoesPermitidas);

//acao=listabi&ano='+ano+'&tipobol='+tipobol;
//lerColecao($aprovado,$assinado,$codTipoBol,$ordem,$ano)

$acao = $_GET['acao'];
$codAssuntoGeral = $_GET['codAssuntoGeral'];
$ano = $_GET['ano'];
$tipoBol = $_GET['tipobol'];
$codBolAtual = $_GET['codBolAtual'];
if ($acao == 'listabi') {
    $colBoletim2 = $fachadaSist2->lerColecaoBi(null, null, $tipoBol, 'desc', $ano);
    echo $apresentacao->montaCombo('seleBoletim', $colBoletim2, 'getCodigo', 'getNumeroBi', $codBolAtual, '');
}

if ($acao == 'moveUp') {
    echo 'move up';
    $codMatAtual = $_GET['codMatAtual'];
    $ordMatAtual = $_GET['ordMatAtual'];

    $codMatAnt = $_GET['codMatAnt'];
    $ordMatAnt = $_GET['ordMatAnt'];

    $fachadaSist2->setaOrdemMateria($codMatAtual, $ordMatAnt);
    $fachadaSist2->setaOrdemMateria($codMatAnt, $ordMatAtual);
}
if ($acao == 'moveDown') {
    echo 'move up';
    $codMatAtual = $_GET['codMatAtual'];
    $ordMatAtual = $_GET['ordMatAtual'];

    $codMatProx = $_GET['codMatProx'];
    $ordMatProx = $_GET['ordMatProx'];

    $fachadaSist2->setaOrdemMateria($codMatAtual, $ordMatProx);
    $fachadaSist2->setaOrdemMateria($codMatProx, $ordMatAtual);
}
//código inserido para o novo ordenaMateria - set/12 - Ten Watanabe e Ten S.Lopes
if ($acao == 'ordenaMateria') {
    parse_str($_POST['pages'], $pageOrder);
    foreach ($pageOrder['page'] as $key => $value) {
        $fachadaSist2->setaOrdemMateria($value, $key);
    }
}

//código inserido para o novo listaMateria - set/12 - Ten Watanabe e Ten S.Lopes
if ($acao == 'listaMateria') {
    //$retorno .= '<form name="formMateria" scrolling="yes">';
    $icodBol = $_GET['icodBol'];
    $parteBoletim = $_GET['parteBoletim'];
    $secaoParteBi = $_GET['secaoParteBi'];
    $colMateria = $fachadaSist2->lerColMateriaParteSecaoGeral($icodBol, $parteBoletim, $secaoParteBi, $codAssuntoGeral);

    $colMateria = $fachadaSist2->lerColMateriaParteSecaoGeral($icodBol, $parteBoletim, $secaoParteBi, $codAssuntoGeral);
    $materia = $colMateria->iniciaBusca1();
    $ordemItem = 0;
    while ($materia != null) {
        $coMateria = $materia->getCodigo();
        $ord = $materia->getOrd_mat();        
        // código alterado para mostrar código de matéria específica - 08-05-13 - PARREIRA 
        $retorno2 .='<li class="orderMat" value="' . $materia->getOrd_mat() . ' "id="page_' . $materia->getCodigo() . '"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span> &nbsp;&nbsp;&nbsp;&nbsp;'. $materia->getAssuntoEspec()->getCodigo() .'&nbsp;&nbsp;-&nbsp;&nbsp;' . $materia->getDescrAssEsp() . '</li>';
        //$retorno2 .='<li class="orderMat" value="' . $materia->getOrd_mat() . ' "id="page_' . $materia->getCodigo() . '"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span> &nbsp;&nbsp;&nbsp;&nbsp;' . $materia->getDescrAssEsp() . '</li>';
        



        $materia = $colMateria->getProximo1();

        if ($materia != null) {
            $coMateriaAnterior = $coMateria;
            $ordAnterior = $ord;
        }
    }
    echo $retorno2;
}



//antigo lista matéria - set/12 - Ten Watanabe e Ten S.Lopes
//não está em uso
if ($acao == 'listaMateria_old') {
    $retorno .= '<form name="formMateria" scrolling="yes">';
    $icodBol = $_GET['icodBol'];
    $parteBoletim = $_GET['parteBoletim'];
    $secaoParteBi = $_GET['secaoParteBi'];
    $colMateria = $fachadaSist2->lerColMateriaParteSecaoGeral($icodBol, $parteBoletim, $secaoParteBi, $codAssuntoGeral);
    setaOrdem($colMateria, $fachadaSist2);
    $colMateria = $fachadaSist2->lerColMateriaParteSecaoGeral($icodBol, $parteBoletim, $secaoParteBi, $codAssuntoGeral);
    $materia = $colMateria->iniciaBusca1();
    $retorno = '<div align="left" scrolling="yes"><font color="black" size="2"><b>Assunto: </b>' . $materia->getDescrAssGer() . '</font></div><br>';
    $retorno .= '<div style="overflow:scroll; height:300px"><table width="500" border="0" cellspacing="0" cellppading="0" class="lista"><tr><td>
				<table width="100%" border="0" cellspacing="1" cellpadding="0" scrolling="yes">
				<tr class="cabec">
					<td width="5%"><div align="center"><strong><font size="2">Ord</font></strong></div></td>
					<td width="80%" align="center"><strong><font size="2">Assunto Espec&iacute;fico</font></strong></td>
					<td colspan="2" width="15%" align="center"><strong><font size="2">A&ccedil;&atilde;o</font></strong></td>
				</tr>';

    while ($materia != null) {
        $coMateria = $materia->getCodigo();
        $ord = $materia->getOrd_mat();

        $retorno .= '<tr id=' . $ord . ' onMouseOut="outLinha(' . $ord . ')" onMouseOver="overLinha(' . $ord . ')" bgcolor="#F5F5F5">' .
                '<td align="center">' . $ord . '</td><td align="left">' . $materia->getDescrAssEsp() . ' - Nota: ' . $materia->getCodigo() . '</td>' .
                '<td align="center">&nbsp;';

        if ($ord != 1) { // Se não for o primeiro, pode mover para cima
            $retorno .= '<a href="javascript:moveUp(' . $coMateria . ',' . $ord . ',' . $coMateriaAnterior . ',' . $ordAnterior . ',' . $materia->getAssuntoGeral()->getCodigo() . ')">' .
                    '<img src="./imagens/seta_up.gif"  border=0 title="Mover para cima"></a>&nbsp;|&nbsp;';
        }
        //$retorno .= '</td><td align="center">&nbsp;<a href="#" onmouseover="visualizar('.$coMateria.','.$ord.')" onMouseOut="javascript:escondeFly();"><img src="./imagens/buscar.gif"  border=0 title="Visualizar"></a>' .
        //			'&nbsp;</td></tr>';

        $materia = $colMateria->getProximo1();

        if ($materia != null) {
            $coMateriaAnterior = $coMateria;
            $ordAnterior = $ord;
            $retorno .= '<a href="javascript:moveDown(' . $coMateria . ',' . $ord . ',' . $materia->getCodigo() . ',' . $materia->getOrd_mat() . ',' . $materia->getAssuntoGeral()->getCodigo() . ')"><img src="./imagens/seta_down.gif" border=0 title="Mover para baixo"></a>';
        }
        $retorno .= '</tr></div>';
    }
    $retorno .= '</form>';
    echo $retorno;
}

function setaOrdem($colMateria, $fachada) {
    $materia = $colMateria->iniciaBusca1();
    $ord = 0;
    while ($materia != null) {
        $ord++;
        $fachada->setaOrdemMateria($materia->getCodigo(), $ord);
        $materia = $colMateria->getProximo1();
    }
}

?>
