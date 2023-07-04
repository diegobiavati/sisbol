<?session_start();
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

$ianoAtual = (isset($_GET['ianoAtual'])) ? $_GET['ianoAtual'] : date('Y');
$codBol = ($_GET['codBol'] != null ? $_GET['codBol'] : 0);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title>SisBol</title>
        <? $apresentacao->chamaEstilo();
        ?>
        <link href="common_codethat.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="scripts/band.js"></script>
        <script type="text/javascript" src="scripts/flyform.js"></script>
        <script type="text/javascript" src="scripts/Bs_Tree.class.js"></script>
        <script type="text/javascript" src="scripts/Bs_TreeElement.class.js"></script>
        <script type="text/javascript" src="scripts/Bs_Array.class.js"></script>
        <script type="text/javascript">
	
            var a = new Array;
            var vicodBol;
            var vparteBoletim;
            var vsecaoParteBi;
            var boletim = '';
            function listaBoletim(){
                var ano 	= document.buscaBoletim.seleAno.value;
                var tipobol = document.buscaBoletim.seleTipoBol.value;

                url = 'ajax_ord_mat_bi.php?acao=listabi&ano='+ano+'&tipobol='+tipobol+'&codBolAtual=<?= $codBol ?>';
                //alert(url);
                ajax(url,"divNrBoletim");
            }
            function Boletim(){
                var ianoAtual 	= document.buscaBoletim.seleAno.value;
                var tipoBol = document.buscaBoletim.seleTipoBol.value;
                var codBol	= document.buscaBoletim.seleBoletim.value;
                if(codBol == ''){
                    alert('Não foi selecionado nenhum boletim.');
                    document.buscaBoletim.seleBoletim.focus();
                    return;
                }
                window.location.href= "ord_mat_bol.php?codBol="+codBol+"&ianoAtual="+ianoAtual+"&tipoBol="+tipoBol;
            }
            function listaMaterias(icodBol,parteBoletim,secaoParteBi,codAssuntoGeral){
                vicodBol = icodBol;
                vparteBoletim = parteBoletim;
                vsecaoParteBi = secaoParteBi;
                url = 'ajax_ord_mat_bi.php?acao=listaMateria&icodBol='+icodBol+'&parteBoletim='+parteBoletim+
                    '&secaoParteBi='+secaoParteBi+'&codAssuntoGeral='+codAssuntoGeral;
        
	        //código abaixo referente ao ajax do novo ordenaMateria - set/12 - Ten Watanabe e Ten S.Lopes
                $.ajax({
                    url: url,
                    beforeSend: function (){
                        $("#loader").show();  
                        
                    },
                    
                    success: function(data) {
                        $('#sortable').html(data);
                        $("#loader").hide();
                        $('#cabeOrderMat').show();
                        $('#rodapeOrderMat').show();
                    }
                });              
            }
            function atualizaTela(resp,tipo){
                document.getElementById("subscrForm").style.left = 390 + "px";
                document.getElementById("subscrForm").style.top = 5 + "px";
                document.getElementById("flyframe").style.visibility = "visible";
                document.getElementById('subscrForm').style.visibility = 'visible';
                document.getElementById('buscador').innerHTML = '<table width="100%" border="0" class="lista"><tr>'+
                    '<td align="left"><font size="3" color="yellow"><b>Ordenar Matéria<\/b><\/font><\/td>'+
                    '<td align="right"><input type="button" value="Fechar" onclick="escondeFly()"><\/td><\/tr><\/table><br>'+
                    resp;
            }



            function visualizar(codMateriaBI,linha,alturaForm){
                document.getElementById("subscrForm").style.left = 50 + "px";
                document.getElementById("flyframe").style.visibility = "visible";
                document.getElementById('subscrForm').style.visibility = 'visible';
                document.getElementById('buscador').innerHTML =
                    '<table width="95%" border="0"><tr><td><b><FONT FACE="Arial" COLOR="#0000FF">Nota nº: '
                    +codMateriaBI+'<\/FONT><\/b><\/td><td align="right"><\/td><\/tr><\/table>';
                isrc="ajax_elabomatbi.php?opcao=buscaMateriaBI_Elab&codMateriaBI="+codMateriaBI;
                url = '<iframe WIDTH="680" HEIGHT="300" src="'+isrc+'"><\/iframe>';
                document.getElementById('textoForm').innerHTML = url;
            }
            function escondeFly(){
                document.getElementById("flyframe").style.visibility = "hidden";
                document.getElementById('subscrForm').style.visibility = 'hidden';
            }
            //            function moveUp(codMatAtual, ordMatAtual, codMatAnt, ordMatAnt, codAssuntoGeral){
            //                //alert(codMatAtual);
            //                url = 'ajax_ord_mat_bi.php?acao=moveUp&codMatAtual='+codMatAtual+'&ordMatAtual='+ordMatAtual+
            //                    '&codMatAnt='+codMatAnt+'&ordMatAnt='+ordMatAnt+'&codAssuntoGeral='+codAssuntoGeral;
            //                //alert(url);
            //                ajax(url,"divMsg");
            //                listaMaterias(vicodBol,vparteBoletim,vsecaoParteBi, codAssuntoGeral);
            //            }
            //            function moveDown(codMatAtual, ordMatAtual, codMatProx, ordMatProx, codAssuntoGeral){
            //                //alert(codMatAtual);
            //                url = 'ajax_ord_mat_bi.php?acao=moveDown&codMatAtual='+codMatAtual+'&ordMatAtual='+ordMatAtual+
            //                    '&codMatProx='+codMatProx+'&ordMatProx='+ordMatProx+'&codAssuntoGeral='+codAssuntoGeral;
            //                //alert(url);
            //                ajax(url,"divMsg");
            //                listaMaterias(vicodBol,vparteBoletim,vsecaoParteBi, codAssuntoGeral);
            //            }
            
			//código abaixo referente ao ajax do novo ordenaMateria - set/12 - Ten Watanabe e Ten S.Lopes
			var sortInput = $('#sort_order');
            var submit = $('#autoSubmit');
            var list = $('#sortable');
		
            $(function() {
                $('#cabeOrderMat').hide();
                $('#rodapeOrderMat').hide();
                $('#sortable').mouseover(function() {
                    $('#sortable').css('cursor','pointer');
                });
                $('#sortable').mouseout(function() {
                    $('#sortable').css('cursor','default');
                });
                
                $("#loader").hide();
                $("#sortable").sortable({
                    update: function(event, ui) {
                         
                        $.ajax({
                            type: "POST",
                            url: "ajax_ord_mat_bi.php?acao=ordenaMateria",
                            data: { pages: $('#sortable').sortable('serialize') }
                        }).done(function( msg ) {
                            //alert( "Data Saved: " + msg );
                        });
                    }

                });
               
            });

<?
if (isset($_GET['codBol'])) {
    $icodBol = $_GET['codBol'];
    $boletim = $fachadaSist2->lerBoletimPorCodigo($icodBol);
    $Bol = "'<img src=\'./imagens/boletim.png\'>" . $boletim->getNumeroBi() . ", de " . $boletim->getDataPub()->GetcDataDDBMMBYYYY() . "';";
    echo "boletim = " . $Bol;

    $colParteBoletim2 = $fachadaSist2->lerColecaoParteBoletim('numero_parte');
    $parteBoletim = $colParteBoletim2->iniciaBusca1();
    $i = 0;
    while ($parteBoletim != null) {
        //$i = $parteBoletim->getNumeroParte();
        echo "a[" . $i . "] = new Array;\n";
        echo "a[" . $i . "]['caption'] = '<b>" . $parteBoletim->getNumeroParte() . "-" . $parteBoletim->getDescricao() . "</b>';\n";
        echo "a[" . $i . "]['icon']    = \"parte.png\";\n";
        echo "a[" . $i . "]['isOpen']  = true;\n";


        $colSecaoParteBi2 = $fachadaSist2->lerColecaoSecaoParteBi($parteBoletim->getNumeroParte());
        $secaoParteBi = $colSecaoParteBi2->iniciaBusca1();
        echo "a[" . $i . "]['children'] = new Array;\n";
        $ordSecao = 0;
        $b[$i] = 0;
        while ($secaoParteBi != null) {
            echo "a[" . $i . "]['children'][" . $ordSecao . "] = new Array;\n";
            echo "a[" . $i . "]['children'][" . $ordSecao . "]['caption'] = '<font size=\'1\'>" . $secaoParteBi->getDescricao() . "</font>';\n";
            echo "a[" . $i . "]['children'][" . $ordSecao . "]['icon'] = \"topic.gif\";\n";
            //echo "a[".$i."]['children'][".$ordSecao."]['url'] = 'conAuditoria.php?cod_usuario=&descitem=';\n";
            echo "a[" . $i . "]['children'][" . $ordSecao . "]['target']  = \"right\";\n";
            echo "a[" . $i . "]['children'][" . $ordSecao . "]['isOpen']  = true;\n";

            $colMateria = $fachadaSist2->lerColMateriaParteSecao($icodBol, $parteBoletim->getNumeroParte(), $secaoParteBi->getNumeroSecao());
            $materia = $colMateria->iniciaBusca1();
            echo "a[" . $i . "]['children'][" . $ordSecao . "]['children'] = new Array;\n";
            $ordMateria = 0;
            $codAssuntGeral = null;
            $ordEspecifico = 0;
            $Loop = 0;
            while ($materia != null) {
                if ($codAssuntGeral != $materia->getAssuntoGeral()->getCodigo()) {
                    if ($Loop != 0) {
                        $ordMateria++;
                    } else {
                        $Loop = 1;
                    }
                    echo "a[" . $i . "]['children'][" . $ordSecao . "]['children'][" . $ordMateria . "] = new Array;\n";
                    echo "a[" . $i . "]['children'][" . $ordSecao . "]['children'][" . $ordMateria . "]['caption'] = '<font size=\'1\'>" . $materia->getDescrAssGer() . "</font>';\n";
                    echo "a[" . $i . "]['children'][" . $ordSecao . "]['children'][" . $ordMateria . "]['icon'] = \"marcador.gif\";\n";
                    echo "a[" . $i . "]['children'][" . $ordSecao . "]['children'][" . $ordMateria . "]['url'] = \"javascript:listaMaterias(" . $icodBol . "," . $parteBoletim->getNumeroParte() . "," . $secaoParteBi->getNumeroSecao() . "," . $materia->getAssuntoGeral()->getCodigo() . ")\";\n";
                    //echo "a[".$i."]['children'][".$ordSecao."]['children'][".$ordMateria."]['url'] = \"javascript:listaMaterias(".$materia->.",".$parteBoletim->getNumeroParte().",".$secaoParteBi->getNumeroSecao().")\";\n";
                    echo "a[" . $i . "]['children'][" . $ordSecao . "]['children'][" . $ordMateria . "]['children'] = new Array;\n";
                    $codAssuntGeral = $materia->getAssuntoGeral()->getCodigo();
                    $ordEspecifico = 0;
                }

                echo "a[" . $i . "]['children'][" . $ordSecao . "]['children'][" . ($ordMateria) . "]['children'][" . $ordEspecifico . "] = new Array;\n";
                echo "a[" . $i . "]['children'][" . $ordSecao . "]['children'][" . ($ordMateria) . "]['children'][" . $ordEspecifico . "]['caption'] = '" . $materia->getDescrAssEsp() . "';\n";

                //echo "a[".$i."]['children'][".$ordSecao."]['children'][".($ordMateria)."]['children'][".$ordEspecifico."]['url'] = \"javascript:visualizar(".$materia->getCodigo().",".$ord.")\"";


                echo "a[" . $i . "]['children'][" . $ordSecao . "]['children'][" . ($ordMateria) . "]['children'][" . $ordEspecifico . "]['icon'] = \"item_dir.gif\";\n";
                echo "a[" . $i . "]['children'][" . $ordSecao . "]['children'][" . ($ordMateria) . "]['children'][" . $ordEspecifico . "]['isOpen']  = true;\n";
                $ordEspecifico++;
                $materia = $colMateria->getProximo1();
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

        </script>


    </head>
    <body onLoad="init();">

        <input type="hidden" name="sort_order" id="sort_order" value="" />
        <input type="hidden" value="1" name="autoSubmit" id="autoSubmit"  /> 

        <center>
            <?
            $apresentacao->chamaCabec();
            $apresentacao->montaMenu();
            $apresentacao->montaFlyForm(550, 600, '#EFEFEF', "2");
            ?>
            <h3 class="titulo">&nbsp;&nbsp;<img src="./imagens/item_dir.gif" alt="">&nbsp;Ordenar Matéria de Boletim</h3>
            <form name="buscaBoletim" action="ord_mat_bol.php" method="post">
                <table width="830" border="0" cellspacing="2" bgcolor="#F5F5F5" style="border-top:1pt solid #006633;border-bottom:1pt solid #006633;border-left:1pt solid #006633;border-right:1pt solid #006633;">
                    <tr>
                        <td> Ano:
                            <?
                            $colBIAno = $fachadaSist2->getAnosBI();
                            $apresentacao->montaComboAnoBI('seleAno', $colBIAno, $ianoAtual, 'listaBoletim()');
                            echo '</td><td>';
                            echo 'Tipo de Boletim:&nbsp;';

                            if ($_SESSION['NOMEUSUARIO'] == 'supervisor') {
                                $colTipoBol = $fachadaSist2->lerColecaoTipoBol('descricao');
                            } else {
                                $colTipoBol = $fachadaSist2->lerColecaoAutorizadaTipoBol($_SESSION['NOMEUSUARIO'], 3023);
                            }

                            if (isset($_GET['tipoBol'])) {
                                $codTipoBolAtual = $_GET['tipoBol'];
                            } else {
                                $obj = $colTipoBol->iniciaBusca1();
                                if (!is_null($obj)) {
                                    $codTipoBolAtual = $obj->getCodigo();
                                } else {
                                    $codTipoBolAtual = 0;
                                }
                            }
                            $apresentacao->montaCombo('seleTipoBol', $colTipoBol, 'getCodigo', 'getDescricao', $codTipoBolAtual, 'listaBoletim()');
                            echo '</td><td>';
                            $colBoletim2 = $fachadaSist2->lerColecaoBi(null, null, $codTipoBolAtual, 'desc', $ianoAtual);
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
                            echo '</td><td><div id="divNrBoletim"></div>';
                            ?>
                        </td>
                        <td><input type="button" value="Atualizar" onClick="Boletim()">
                        </td>
                    </tr>
                </table>
                <div id="meuHint"></div>
            </form>
            <script type="text/javascript">listaBoletim();</script>
            <table width="830" border="0">
                <tr>
                    <td align="left" valign="top" width="300"><script type="text/javascript">document.writeln("<font color='blue'>"+boletim+"<\/font>");</script>
                        <div id="treeDiv1"></div></td>
                    <td align="left" width="130" valign="top">&nbsp;
                        <table id="cabeOrderMat" width=450px border="0" cellspacing="1" cellpadding="0" class="lista"> 

                            <tr>     

                                <td align="center"><strong><font size="2" color="#FF0">Ordena Matéria</font></strong></td>                                

                            </tr>
                            <tr>
                                <td>
                                    <table width=450px border="0" cellspacing="1" cellpadding="0">     
                                        <tr>
                                            <td>
                                                <div id="divMateria" style="scrolling:yes; width:100%;height:auto">
                                                    <ol id="sortable"></ol>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>

                                </td>
                            </tr>
                            </table>
                        <table id="rodapeOrderMat" align="right">
                            <td>
                                <img src="imagens/ajax-loader.gif" id="loader"> <input type="button" value="Ok" onClick="Boletim()">
                            </td>
                        </table>
            </table>
        </center>
    </body>
</html>
