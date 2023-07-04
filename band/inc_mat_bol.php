<?
session_start();
require_once('./filelist_geral.php');
require_once('./filelist_militar.php');
require_once('./filelist_boletim.php');
require_once('./filelist_tipodoc.php');
require_once('./filelist_usuariofuncaotipobol.php');
require_once ('./filelist_om.php');
$fachadaSist2 = new FachadaSist2();
$funcoesPermitidas = $fachadaSist2->lerColecaoAutorizada($_SESSION['NOMEUSUARIO'], 'X');
$apresentacao = new Apresentacao($funcoesPermitidas);
$ordem = (isset($_GET['ordem'])) ? ($_GET['ordem']) : "data_materia_bi DESC";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title>SisBol</title>
<? $apresentacao->chamaEstilo(); ?>
        <script type="text/javascript" src="scripts/band.js"></script>
        <script type="text/javascript" src="scripts/flyform.js"></script>
        <script type="text/javascript">
      
            function tipoBol(codBol){
                window.location.href = "inc_mat_bol.php?codTipoBol="+document.incluirMateria.seleTipoBol.value;
            }
            //Incluido 3ºSgt Bedin (27/08/12) -- Passa Código do Tipo do Boletim e Código do Boletim via URL para consultar data do Bi selecionado
            function Boletim(){
                window.location.href = "inc_mat_bol.php?codTipoBol="+document.incluirMateria.seleTipoBol.value+"&codBolAtual="+document.incluirMateria.seleBoletim.value;
            }
            // FIM
            function visualizar(codMateriaBI){
                document.getElementById("subscrForm").style.left = 50 + "px";
                document.getElementById("flyframe").style.visibility = "visible";
                document.getElementById('subscrForm').style.visibility = 'visible';
                document.getElementById('buscador').innerHTML =
                    '<table width="80%" border="0"><tr><td><b><FONT FACE="Arial" COLOR="#0000FF">Nota nº: '
                    +codMateriaBI+'<\/FONT><\/b><\/td><td align="right"><input type="button" value="Fechar" onclick="javascript:escondeFly()"><\/td><\/tr><\/table>';
                //'<b>Nota nº: '+codMateriaBI+'<\/b>';
                isrc="ajax_inc_mat_bol.php?opcao=inc_mat_bol&codMateriaBI="+codMateriaBI;
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
            function incMateriaSelecionada(){
	
		
                if (document.incluirMateria.seleBoletim.value == ''){
                    alert('Não foi selecionado nehum número de boletim.');
                    return false;	
                }
                if (!window.confirm("Deseja realmente adicionar a(s) notas(s) selecionada(s) ao BI selecionado ?")){
                    return ;
                }
                document.incluirMateria.executar.value = "Adicionar";
                document.incluirMateria.action = "inc_mat_bol.php?codTipoBol="+document.incluirMateria.seleTipoBol.value;
                document.incluirMateria.submit();
            }
            function escondeFly(){
                document.getElementById("flyframe").style.visibility = "hidden";
                document.getElementById('subscrForm').style.visibility = 'hidden';
            }
            function ordena(ordem){
                window.location.href="inc_mat_bol.php?codTipoBol="+document.incluirMateria.seleTipoBol.value+"&ordem="+ordem;
            }
            function atualizaTela(resposta){
                document.getElementById('mensagem').style.visibility = "hidden";
                document.getElementById('divMatBi').innerHTML = "";
                viewPDF2(resposta);;
            }
        </script>
    </head>
    <body><center>
            <?
            $apresentacao->chamaCabec();
            $apresentacao->montaMenu();
            $apresentacao->montaFlyForm(700, 350, '#DDEDFF');
            ?>
            <h3 class="titulo">&nbsp;&nbsp;<img src="./imagens/item_dir.gif" alt="">&nbsp;Adicionar Nota em Boletim</h3>


            <form name="incluirMateria" action="incluirMateria.php" method="post">
                <?
                echo 'Tipo de Boletim:&nbsp;';

                //$colTipoBol = $fachadaSist2->lerColecaoTipoBol('descricao');
                if ($_SESSION['NOMEUSUARIO'] == 'supervisor') {
                    $colTipoBol = $fachadaSist2->lerColecaoTipoBol('descricao');
                } else {
                    $colTipoBol = $fachadaSist2->lerColecaoAutorizadaTipoBol($_SESSION['NOMEUSUARIO'], 2021);
                }

                if (isset($_GET['codTipoBol'])) {
                    $codTipoBolAtual = $_GET['codTipoBol'];
                } else {
                    $obj = $colTipoBol->iniciaBusca1();

                    if (!is_null($obj)) {
                        $codTipoBolAtual = $obj->getCodigo();
                    } else {
                        $codTipoBolAtual = 0;
                    }
                }
                $apresentacao->montaCombo('seleTipoBol', $colTipoBol, 'getCodigo', 'getDescricao', $codTipoBolAtual, 'tipoBol()');
                echo '&nbsp;&nbsp;Boletim:&nbsp;';
                $colBoletim2 = $fachadaSist2->lerColecaoBi('N', 'N', $codTipoBolAtual, '');
                //Incluido 3ºSgt Bedin (27/08/12) -- Busca data do Boletim selecionado para comparar com data da Matéria.
                $codBiAtual = $_GET['codBolAtual']; //recebe variável da URL
                //echo $codBiAtual;
                $apresentacao->montaComboBi('seleBoletim', $colBoletim2, 'getCodigo', 'getNumeroBi', $codBiAtual, 'Boletim()'); //Monta combo para numerção de BI com um campo em branco
                echo '&nbsp;&nbsp;Data do Boletim:&nbsp;';
                //$codBiAtual = $_GET['codBolAtual']; //recebe variável da URL
                $dataPubl = $fachadaSist2->lerPorBiTipo($codTipoBolAtual, $codBiAtual); //Executa função para consultar Data do Boletim pelo Tipo e pelo Número do BI
                $databi = $_SESSION['databi']; //Recebe a data do Boletim
                if ($codBiAtual != "") {
                    $data_nova = implode(preg_match("~\/~", $databi) == 0 ? "/" : "-", array_reverse(explode(preg_match("~\/~", $databi) == 0 ? "-" : "/", $databi))); // Converte a data de YYYY/MM/DD para DD/MM/YYYY
                    echo $data_nova;
                }
                // FIM
                ?>	

                <br><br>
                <div id="meuHint"></div>
                <table width="65%" border="0" ><tr>
                        <td valign="bottom" width="3%"><div id="mensagem" class="processa" style="visibility:hidden"><img src="imagens/ajax-loader.gif" alt=""></div></td>
                        <td><div id="divMatBi">&nbsp;</div></td></tr></table>
                <TABLE width="60%" border="0">
                    <TR><TD align="left" valign="middle"><B>Ações possíveis:</B></TD>
                        <TD align="left" valign="middle"><img src="./imagens/check_incluir.png" title="Adicionar Nota no BI selecionado" border=0 alt="">Adicionar Nota no BI selecionado&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp;
                            <img src="./imagens/buscar.gif" title="Visualizar Nota" border=0 alt="">Visualizar Nota
                        </TD></TR>
                </TABLE>
                <table width="850px" border="0" cellspacing="0"  class="lista"><tr><td>
                            <table width="100%" border="0" cellspacing="1" cellpadding="0">
                                <tr class="cabec">
                                    <td width="5%"><div align="center"><strong><font size="2">Ord</font></strong></div></td>
                                    <td width="7%"><div align="center"><strong><font size="2">Nr Nota<a href="javascript:ordena('cod_materia_bi DESC')"></a></font></strong></div></td>
                                    <td width="32%" align="center"><strong><font size="2">Assunto Específico<br><a href="javascript:ordena('descr_ass_esp, codom, cod_subun, data_materia_bi DESC')"></a></font></strong></td>
                                    <td width="9%" align="center"><strong><font size="2">Data<br><a href="javascript:ordena('data_materia_bi DESC, codom, cod_subun')"></a></font></strong></td>
                                    <td width="10%" align="center"><strong><font size="2">OM Vinc<br><a href="javascript:ordena('codom, cod_subun, data_materia_bi DESC')"></a></font></strong></td>
                                    <td width="10%" align="center"><strong><font size="2">SU/Div/Sec<br><a href="javascript:ordena('cod_subun, codom, data_materia_bi DESC')"></a></font></strong></td>
                                    <td width="10%" align="center"><strong><font size="2">Usuário<br><a href="javascript:ordena('usuario, codom, cod_subun, data_materia_bi DESC')"></a></font></strong></td>
                                    <td width="8%" align="center"><strong><font size="2">Ações</font></strong></td>
                                </tr>

                                <?php
                                if ($_POST['executar'] == 'Adicionar') {
                                    if (isset($_POST['CheckCodigoMateria'])) {
                                        foreach ($_POST['CheckCodigoMateria'] as $codMateriaBI) {
                                            $codBoletim = $_POST['seleBoletim'];
                                            $materiaBi = $fachadaSist2->lerRegistroMateriaBI($codMateriaBI);
                                            $boletim = $fachadaSist2->lerBoletimPorCodigo($codBoletim);
                                            //echo 'Código do Boletim:'.$codBoletim;
                                            //echo 'Boletim atual:'.$codTipoBolAtual.'<br>'.print_r($boletim);
                                            $fachadaSist2->incluirMateriaEmBi($materiaBi, $boletim);
                                        };
                                    } else {
                                        echo "<script type='text/javascript'>window.alert('Não foi selecionado nenhuma matéria para a inclusão')</script>";
                                    }
                                }

                                //vs 2.2
                                if (($_SESSION['APROVNOTA1'] == 'S') && ($_SESSION['APROVNOTA2'] == 'S')) {
                                    $filtraNota = "S";
                                }
                                if (($_SESSION['APROVNOTA1'] == 'N') && ($_SESSION['APROVNOTA2'] == 'N')) {
                                    $filtraNota = "C,K";
                                }
                                if (($_SESSION['APROVNOTA1'] == 'S') && ($_SESSION['APROVNOTA2'] == 'N')) {
                                    $filtraNota = "A";
                                }
                                if (($_SESSION['APROVNOTA1'] == 'N') && ($_SESSION['APROVNOTA2'] == 'S')) {
                                    $filtraNota = "S";
                                }

                                $colMatBITipoBolAprov = $fachadaSist2->lerColMateriaBITipoBolAprov($codTipoBolAtual, $filtraNota, $ordem, 'N', $apresentacao->getCodom(), $apresentacao->getCodSubun(), $apresentacao->getTodasOmVinc(), $apresentacao->getTodasSubun());
                                $Materia_BI = $colMatBITipoBolAprov->iniciaBusca1();
                                $ord = 0;
                                //Incluido 3ºSgt Bedin (27/08/12) - Criado array para armazenar datas das Matérias para enviar a array JS
                                $datarray = array();
                                // FIM
                                while ($Materia_BI != null) {

                                    if ($Materia_BI->getCodom() != null) {
                                        $omVinc = $fachadaSist2->lerOMVinc($Materia_BI->getCodom());
                                        $siglaOmVinv = $omVinc->getSigla();
                                    } else {
                                        $siglaOmVinv = 'Indef';
                                    }
                                    if (($Materia_BI->getCodom() != null) && ($Materia_BI->getCodSubun() != null)) {
                                        $subun = $fachadaSist2->lerSubun($Materia_BI->getCodom(), $Materia_BI->getCodSubun());
                                        $siglaSubun = $subun->getSigla();
                                    } else {
                                        $siglaSubun = 'Indef';
                                    }
                                    //Incluido 3ºSgt Bedin (27/08/12) - Recebe as datas e armazena na array
                                    $datarray[] = $Materia_BI->getDataDoc()->GetcDataDDBMMBYYYY();
                                    //FIM
                                    $ord++;
                                    echo '<tr id=' . $ord . ' onMouseOut="outLinha(' . $ord . ')" onMouseOver="overLinha(' . $ord . ')" bgcolor="#F5F5F5">
			<td align="center">' . $ord . '</td>
			<td align="center">' . $Materia_BI->getCodigo() . '</td>
			<td align="left">' . $Materia_BI->getDescrAssEsp() . '</td>
			<td align="center">' . $Materia_BI->getDataDoc()->GetcDataDDBMMBYYYY() . '</td>
			<td align="center">' . $siglaOmVinv . '</td>
			<td align="center">' . $siglaSubun . '</td>
			<td align="center">' . $Materia_BI->getUsuario() . '</td>
			<td align="center">
                        <input type="checkbox" id="check" name="CheckCodigoMateria[]" value="' . $Materia_BI->getCodigo() . '" onclick="comparar(this.value,\'' . $Materia_BI->getDataDoc()->GetcDataDDBMMBYYYY() . '\')">
                        &nbsp;|&nbsp;
			<a href="javascript:carregaedit(' . $Materia_BI->getCodigo() . ',\'Visualizar\')"
				onclick="visualizar(' . $Materia_BI->getCodigo() . ')">
			<img src="./imagens/buscar.gif"  border=0 title="Visualizar"></a>';

                                    //alterado linha 183 ten anapaula: <td align="center">'.$Materia_BI->getDataDoc()->GetcDataDDBMMBYYYY().'</td>
                                    //alterado checkbox(Adicionado id e evento onclick) 3º Sgt Bedin: <input type="checkbox" id="check" name="CheckCodigoMateria[]" value="'.$Materia_BI->getCodigo().'" onclick="comparar(this.value,\''.$Materia_BI->getDataDoc()->GetcDataDDBMMBYYYY().'\')">


                                    $Materia_BI = $colMatBITipoBolAprov->getProximo1();
                                }
                                //Adicionado 3º Sgt Bedin -- Variavel para armazenar as datas separadas por |, para enviar para array JS        
                                $string_array = implode("|", $datarray);
                                //FIM
                                ?>

                                <!--Incluido 3ºSgt Bedin (27/08/12) - Compara datas -->
                                <script type="text/javascript">
                                    function comparar(valor,datamat){
                                        databi = <? echo "\"$data_nova\"" ?> //recebe data do boletim
                                        var listaMarcados = document.getElementsByTagName("INPUT");
                                        for (loop = 0; loop < listaMarcados.length; loop++) {
                                            var item = listaMarcados[loop];
                                            if (item.type == "checkbox" && item.checked && item.value == valor) {
                                                var compara = parseInt(databi.split("/")[2].toString() + databi.split("/")[1].toString() + databi.split("/")[0].toString());//converte a data em array para fazer a comparação
                                                var compara1 = parseInt(datamat.split("/")[2].toString() + datamat.split("/")[1].toString() + datamat.split("/")[0].toString());//converte a data em array para fazer a comparação
                                                if (compara < compara1){//função comparar
            
                                                    alert('Data da Nota superior a Data do Boletim!');
                                                }
                                            }
                                        }    
                                    }
        

        
       
                                     
                                </script>
                                <!--FIM -->
                            </table></td></tr>

                </table></td></tr>

                </table>

                <table width="60%" border="0" >
                    <TR>
                        <td width="87%" align="right">
                            <a href="javascript:marcaTudo(document.incluirMateria,true); comparartudo()">Marca Tudo</a>&nbsp;/&nbsp;
                            <a href="javascript:marcaTudo(document.incluirMateria,false)">Desmarca Tudo</a>
                            <!--Incluido 3ºSgt Bedin (27/08/12) - Compara datas, se todas matérias forem selecionados -->	
                            <script type="text/javascript">
                                function comparartudo(){
                                    databi = <? echo "\"$data_nova\"" ?>//recebe data do Boletim
        
                                    var i,arrayjs, string_array;//cria array para receber array do PHP
                                    string_array = "<?php echo $string_array; ?>";//recebe valores da array PHP
                                    arrayjs = string_array.split("|");//converte a variavel JS em array JS
        
                                    i=0;
                                    while (i<arrayjs.length){//while para verificar todos campos data
                                        var compara = parseInt(databi.split("/")[2].toString() + databi.split("/")[1].toString() + databi.split("/")[0].toString());//converte a data em array para fazer a comparação
                                        var compara1 = parseInt(arrayjs[i].split("/")[2].toString() + arrayjs[i].split("/")[1].toString() + arrayjs[i].split("/")[0].toString());//converte a data em array para fazer a comparação
                                        if (compara < compara1){//Função para comparar
                                            alert("Existem nota(s) com data(s) superior(es) ao Boletim!");
                                            return;	
                                        }
                                        i++;
                                    }
                                }

                            </script>
                            <!-- FIM -->
                        </td>
                        <td width="5%" align="center">
                            <img src="./imagens/seta.png" border="0" alt="">
                        </td>
                        <TD width="8%" align="right">
                            <INPUT TYPE="button" NAME="Executar" VALUE="Adicionar" onClick="incMateriaSelecionada()">
                        </TD>
                    </TR></TABLE>
                <input name="executar" type="hidden" value="">
            </form>

        </center>
    </body>
</html>
