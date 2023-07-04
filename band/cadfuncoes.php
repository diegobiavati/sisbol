<?
session_start();
require_once('./filelist_geral.php');
require_once('./filelist_funcao.php');
$fachadaSist2 = new FachadaSist2();
$funcoesPermitidas = $fachadaSist2->lerColecaoAutorizada($_SESSION['NOMEUSUARIO'], 'X');
$apresentacao = new Apresentacao($funcoesPermitidas);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
    "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title>SisBol</title>
        <? $apresentacao->chamaEstilo(); ?>
        <script type="text/javascript" src="scripts/band.js"></script>
        <script type="text/javascript" src="scripts/flyform.js"></script>
        <script type="text/javascript" src="scripts/overlib.js"></script>
        <script type="text/javascript" src="scripts/msg_hints.js"></script>
        <script type="text/javascript">
            $(function() {
                $( "#dialogFuncoes" ).dialog({
                    autoOpen: false,
                    modal: true,
                    width: 500,
                    height: 300,
                    buttons: {
                        Ok: function() {
                            $( this ).dialog( "close" );
                        }
                    }
                });
            });
            
            function visualizar(codFuncao,divId){
                $( "#dialogFuncoes" ).dialog( "open" );
                url="ajax_funcoes.php?opcao=listamilitarfuncao&codfuncao="+codFuncao;
                $.ajax({
                    url: url,
                    success: function(data) {
                        $('#divFuncoes').html(data);
                        
                    }
                });
            }
            function novo(){
                document.getElementById("formulario").style.visibility = "visible";
                document.getElementById("novo").style.visibility = "hidden";
                document.getElementById("tituloForm").innerHTML = "Incluir";
                document.cadFuncao.descricao.focus();
            }
            function cancelar(){
                document.cadFuncao.cod.value  = "";
                document.cadFuncao.descricao.value = "";
                document.cadFuncao.acao.value = "Incluir";
                document.getElementById("formulario").style.visibility = "hidden";
                document.getElementById("novo").style.visibility = "visible";
                window.location.href="#topo";
                cinza();
            }
            function executa(acao){
                document.cadFuncao.executar.value = acao;
                if (document.cadFuncao.descricao.value == ""){
                    window.alert("Informe o nome da Função!");
                    return;
                }    
                if (acao == "Excluir")  {
                    if (!window.confirm("Deseja realmente excluir a Função selecionada ?")){
                        return ;
                    }
                } 
                document.cadFuncao.action = "cadfuncoes.php";
                document.cadFuncao.submit();
            }
            function carregaedit(cod,descricao,assina_bi,assina_confere,assina_alt,assina_nota,assina_publiquese,acao,IDT) {
                window.location.href="#cadastro";
                cinza();
                document.cadFuncao.cod.readOnly = true;
                document.getElementById(IDT).style.background = "#E2F1E7";
                document.cadFuncao.cod.value  = cod;
                document.cadFuncao.descricao.value = descricao;
                if (assina_bi == "S"){
                    document.cadFuncao.assina_bi.checked=true;
                }else{
                    document.cadFuncao.assina_bi.checked=false;
                }
                if (assina_confere == "S"){
                    document.cadFuncao.assina_confere.checked=true;
                }else{
                    document.cadFuncao.assina_confere.checked=false;
                }
                if (assina_alt == "S"){
                    document.cadFuncao.assina_alt.checked=true;
                }else{
                    document.cadFuncao.assina_alt.checked=false;
                }
                if (assina_nota == "S"){
                    document.cadFuncao.assina_nota.checked=true;
                }else{
                    document.cadFuncao.assina_nota.checked=false;
                }
                if (assina_publiquese == "S"){
                    document.cadFuncao.assina_publiquese.checked=true;
                }else{
                    document.cadFuncao.assina_publiquese.checked=false;
                }
                document.cadFuncao.acao.value = acao;
                document.getElementById("formulario").style.visibility = "visible";
                document.getElementById("novo").style.visibility = "hidden";
                document.getElementById("tituloForm").innerHTML = acao;
            } 
            function escondeFly(){
                document.getElementById("flyframe").style.visibility = "hidden";
                document.getElementById('subscrForm').style.visibility = 'hidden';
            }
        </script>
    </head>
    <body><center>
            <?
            $apresentacao->chamaCabec();
            $apresentacao->montaMenu();
            ?>
            <div id="meuHint"></div>
            <h3 class="titulo">&nbsp;&nbsp;<img src="./imagens/item_dir.gif" alt="">&nbsp;Cadastro de Fun&ccedil;&otilde;es <img src="imagens/ajuda.png" width="14" height="14"onClick="ajuda('cadFuncoes')" alt="Help" onMouseOver="this.style.cursor='help';" onMouseOut="this.style.cursor='default';" ></h3>


            <?php
            //verifica permissao
            if ($_SESSION['NOMEUSUARIO'] != 'supervisor') {
                $mIncluir = $funcoesPermitidas->lerRegistro(1011);
            }
            if (($mIncluir != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor')) {
                echo '<table width="78%" border="0" >';
                echo '<TR><TD><a href="javascript:novo()" id="novo">';
                echo '<img src="./imagens/add.png" border=0 alt="">&nbsp';
                echo '<FONT COLOR="#0080C0">Adicionar</FONT></a></TD>';
                echo '</TR>';
                echo '</TABLE>';
                echo '<p>';
            }
            ?>
            <a name="topo"></a>
            <table width="78%" border="0" cellspacing="0" style="cellppading:0;" class="lista"><tr><td>
                        <table width="100%" border="0" cellspacing="1" style="cellpadding:0;">
                            <tr class="cabec">
                                <td width="5%"><div align="center"><strong><font size="2">Ord</font></strong></div></td>
                                <td width="15%" align="center"><strong><font size="2">Fun&ccedil;&atilde;o</font></strong></td>
                                <td width="10%" align="center"><strong><font size="2">Assina <br>BI?</font></strong></td>
                                <td width="10%" align="center"><strong><font size="2">Confere <br>BI?</font></strong></td>
                                <td width="15%" align="center"><strong><font size="2">Assina <br>Alterações?</font></strong></td>
                                <td width="15%" align="center"><strong><font size="2">Assina <br>Nota p/ BI?</font></strong></td>
                                <td width="15%" align="center"><strong><font size="2">Assina <br>Publique-se?</font></strong></td>
                                <td width="10%" align="center"><strong><font size="2">Ação</font></strong></td>
                            </tr>
                            <?php
                            if (isset($_POST['executar'])) {
                                $Funcao = new Funcao();
                                $Funcao->setCod($_POST['cod']);
                                $Funcao->setDescricao($_POST['descricao']);
                                if (isset($_POST['assina_bi'])) {
                                    $Funcao->setAssinaBI($_POST['assina_bi']);
                                } else {
                                    $Funcao->setAssinaBI("N");
                                }
                                if (isset($_POST['assina_confere'])) {
                                    $Funcao->setAssinaConfere($_POST['assina_confere']);
                                } else {
                                    $Funcao->setAssinaConfere("N");
                                }
                                if (isset($_POST['assina_alt'])) {
                                    $Funcao->setAssinaAlt($_POST['assina_alt']);
                                } else {
                                    $Funcao->setAssinaAlt("N");
                                }
                                if (isset($_POST['assina_nota'])) {
                                    $Funcao->setAssinaNota($_POST['assina_nota']);
                                } else {
                                    $Funcao->setAssinaNota("N");
                                }
                                if (isset($_POST['assina_publiquese'])) {
                                    $Funcao->setAssinaPubliquese($_POST['assina_publiquese']);
                                } else {
                                    $Funcao->setAssinaPubliquese("N");
                                }
                                if ($_POST['executar'] == 'Incluir') {
                                    $fachadaSist2->incluirFuncao($Funcao);
                                }
                                if ($_POST['executar'] == 'Excluir') {
                                    $fachadaSist2->excluirFuncao($Funcao);
                                }
                                if ($_POST['executar'] == 'Alterar') {
                                    $fachadaSist2->alterarFuncao($Funcao);
                                }
                            }
                            $colFuncao2 = $fachadaSist2->lerColecaoFuncao('cod');
                            $Funcao = $colFuncao2->iniciaBusca1();
                            $ord = 0;
                            while ($Funcao != null) {
                                $ord++;
                                echo '<tr id= "linha_'.$ord.'" onMouseOut="outLinha(this)" onMouseOver="overLinha(this)" bgcolor="#F5F5F5">
				<td align="center">' . $ord . '</td>
				<td>' . $Funcao->getDescricao() . '</td>
				<td align="center">' . $apresentacao->retornaCheck($Funcao->getAssinaBI()) . '</td>
				<td align="center">' . $apresentacao->retornaCheck($Funcao->getAssinaConfere()) . '</td>
				<td align="center">' . $apresentacao->retornaCheck($Funcao->getAssinaAlt()) . '</td>
				<td align="center">' . $apresentacao->retornaCheck($Funcao->getAssinaNota()) . '</td>
				<td align="center">' . $apresentacao->retornaCheck($Funcao->getAssinaPubliquese()) . '</td>
				<td align="center">
				<a href="javascript:carregaedit(' . $Funcao->getCod() . ',\'' . $Funcao->getDescricao() . '\',\'' . $Funcao->getAssinaBI() .
                                '\',\'' . $Funcao->getAssinaConfere() . '\',\'' . $Funcao->getAssinaAlt() . '\',\'' . $Funcao->getAssinaNota() . '\',\'' . $Funcao->getAssinaPubliquese() . '\',\'Alterar\',\'linha_' . $ord . '\')">';

                                //verifica permissao
                                if ($_SESSION['NOMEUSUARIO'] != 'supervisor') {
                                    $mAlterar = $funcoesPermitidas->lerRegistro(1012);
                                }
                                if (($mAlterar != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor')) {
                                    echo '<img src="./imagens/alterar.png"  border=0 TITLE="Alterar" alt="Alterar">';
                                    echo '<FONT COLOR="#000000"></FONT></a>&nbsp;|&nbsp';
                                }
                                echo '<a href="javascript:carregaedit(' . $Funcao->getCod() . ',\'' . $Funcao->getDescricao() . '\',\'' . $Funcao->getAssinaBI() .
                                '\',\'' . $Funcao->getAssinaConfere() . '\',\'' . $Funcao->getAssinaAlt() . '\',\'' . $Funcao->getAssinaNota() . '\',\'' . $Funcao->getAssinaPubliquese() . '\',\'Excluir\',\'linha_' . $ord . '\')">';

                                //verifica permissao
                                if ($_SESSION['NOMEUSUARIO'] != 'supervisor') {
                                    $mExcluir = $funcoesPermitidas->lerRegistro(1013);
                                }
                                if (($mExcluir != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor')) {
                                    echo '<img src="./imagens/excluir.png" border=0 TITLE="Excluir" alt="">';
                                    echo '<FONT COLOR="#000000"></FONT></a>&nbsp;|&nbsp';
                                }
                                echo '<a href="#" onclick="visualizar(' . $Funcao->getCod() . ',\'textoForm\')" onMouseOut="javascript:escondeFly();"><img src="./imagens/buscar.gif" title="Militares nesta Função." border=0 alt=""></a>
				</td></tr>';
                                $Funcao = $colFuncao2->getProximo1();
                            }
                            ?>
                        </table></td></tr>
            </table>
            <b>Legenda:</b> <img src="imagens/alterar.png" width="16" height="16" alt="Alterar" > Alterar;<img src="imagens/excluir.png" width="16" height="16" alt="Excluir"> Excluir  &nbsp;<img src="imagens/buscar.gif" width="13" height="13" alt="Buscar"> Visualizar<br>
            <script type="text/javascript">javascript:tot_linhas(<?= $ord ?>)</script>
            <form  method="post" name="cadFuncao" action="">
                <input name="executar" type="hidden" value="">
                <input name="cod" type="hidden" value="">
                <div id="formulario" STYLE="VISIBILITY:hidden">
                    <a name="cadastro"></a>
                    <br>
                    <TABLE width="70%" border=0 class="formulario" style="cellppading:1;" ><TR><TD>
                                <TABLE width="100%" border=0 style="BORDERCOLOR:#C0C0C0; BORDERCOLORLIGHT:#C0C0C0; cellppading:0; name:tabela;" CELLSPACING="0">
                                    <TR CLASS="cabec"><TD><div id="tituloForm"><font size="2"></font></div></TR>
                                    <tr>
                                        <TD BGCOLOR="#C0C0C0">
                                            Descrição: <input name="descricao" type="text" size="100" maxlength="100">&nbsp;&nbsp;</td>
                                    <tr><TD BGCOLOR="#C0C0C0">
                                            <input name="assina_bi" type="checkbox" value="S">Assina BI?&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input name="assina_confere" type="checkbox" value="S">Confere BI?
                                            <input name="assina_alt" type="checkbox" value="S">Assina Alterações?
                                            <input name="assina_nota" type="checkbox" value="S">Assina Nota p/ BI?
                                            <input name="assina_publiquese" type="checkbox" value="S">Assina Publique-se?</TD>
                                    </TR>
                                    <TR>
                                        <TD BGCOLOR="#C0C0C0" align="right">
                                            <input name="acao" type="button" value="Incluir" onClick="executa(this.value)">
                                            <input name="cancela" type="button" value="Cancelar" onClick="cancelar()"></TD>
                                    </TR></table>
                            </TD></TR></TABLE>
                </div>
            </form>
        </center>

        <div id="dialogFuncoes" title="Militares na função">
            <div id="divFuncoes"></div>
        </div>

    </body>
</html>
