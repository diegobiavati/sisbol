<?
session_start();
require_once ('./filelist_geral.php');
require_once ('./filelist_boletim.php');
require_once ('./filelist_assunto.php');
require_once('./filelist_usuariofuncaotipobol.php');
$fachadaSist2 = new FachadaSist2();
$funcoesPermitidas = $fachadaSist2->lerColecaoAutorizada($_SESSION['NOMEUSUARIO'], 'X');
$apresentacao = new Apresentacao($funcoesPermitidas);
if (isset($_GET['codTipoBol'])) {
    $codTipoBolAtual = $_GET['codTipoBol'];
} else {
//$codTipoBolAtual = 1;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title>SisBol</title>
        <? $apresentacao->chamaEstilo(); ?>
        <script type="text/javascript" src="scripts/band.js"></script>
        <script type="text/javascript" src="scripts/flyform.js"></script>
        <script type="text/javascript" src="../fckeditor/fckeditor.js"></script>
        <script type="text/javascript" src="scripts/overlib.js"></script>
        <script type="text/javascript" src="scripts/msg_hints.js"></script>
 
         <script type="text/javascript" src="scripts/cookie.js"></script>

        <script type="text/javascript">
            var oFCKAbert = new FCKeditor( 'texto_abert' ) ;
            var oFCKFech  = new FCKeditor( 'texto_fech' ) ;
            var codAssGer,CodAssEsp;

            // … chamado via ajax.js para preenchimento do editor FCKEditor
            function InsertHTML(conteudo){
                window.location.href = "#cadastro";
                document.getElementById("formulario").style.visibility = "visible";
                document.getElementById("novo").style.visibility = "hidden";
                // Apanha a instancia do editor para interagir.

                var oEditorAbert = FCKeditorAPI.GetInstance('texto_abert') ;
                var oEditorFech = FCKeditorAPI.GetInstance('texto_fech') ;

                vaiAltr 	= conteudo.slice(0,1);
                abertura 	= conteudo.substring(2,conteudo.indexOf('$wxxw$'));
                fechamento 	= conteudo.substring(conteudo.indexOf('$wxxw$') + 6,conteudo.length);
                oEditorAbert.SetHTML(abertura);
                oEditorFech.SetHTML(fechamento);
                document.cadAssuntoEspec.vai_altr.checked = (vaiAltr == 'S'? true: false);
            }

            function novo(){
                var oEditorAbert = FCKeditorAPI.GetInstance('texto_abert') ;
                var oEditorFech = FCKeditorAPI.GetInstance('texto_fech') ;
                oEditorAbert.SetHTML('');
                oEditorFech.SetHTML('');
                document.getElementById("formulario").style.visibility = "visible";
                //RV05
                document.cadAssuntoEspec.vai_indice.checked=true;
                document.cadAssuntoEspec.vai_altr.checked=true;
                document.getElementById("novo").style.visibility = "hidden";
                document.getElementById("tituloForm").innerHTML = "Incluir";
                document.getElementById("preview").style.visibility = "hidden";
                document.cadAssuntoEspec.descricao.focus();
                window.location.href = "#cadastro";
            }
            function cancelar(){
                document.cadAssuntoEspec.cod.value  = "";
                document.cadAssuntoEspec.descricao.value = "";
                //document.cadAssuntoEspec.texto_pad_abert.value = "";
                //document.cadAssuntoEspec.texto_pad_fech.value = "";
                document.cadAssuntoEspec.acao.value = "Incluir";
                document.getElementById("formulario").style.visibility = "hidden";
                document.getElementById("preview").style.visibility = "hidden";
                document.getElementById("novo").style.visibility = "visible";
                window.location.href = "#lista";
                cinza();
            }
            function executa(acao){
                
                
                document.cadAssuntoEspec.executar.value = acao;
                
                
                if (document.cadAssuntoEspec.descricao.value == ""){
                    window.alert("Informe o Assunto EspecÌfico!");
                    return;
                }
                
                //ALTERACAO ASP PARREIRA - Impede o uso dos caracteres abaixo como primeiro nos titulos
                else{                
                //var letrasvalidas = new String("-+=./\^~@!?#$%®&*}{[]™∫;:|,'`");
                var letrasvalidas = new String("ABC");
                var priletra = document.cadAssuntoEspec.descricao.value.charAt(0);
                for(i=0;i<=letrasvalidas.length;i++)
                    {
                        if(priletra == letrasvalidas[i])
                            {

                
                
                if (document.cadAssuntoEspec.vai_indice.checked==true){
                    document.cadAssuntoEspec.vai_indice.value="S";
                }else{
                    document.cadAssuntoEspec.vai_indice.value="N";
                }
                if (document.cadAssuntoEspec.vai_altr.checked==true){
                    document.cadAssuntoEspec.vai_altr.value="S";
                }else{
                    document.cadAssuntoEspec.vai_altr.value="N";
                }
                if (acao == "Excluir")  {
                    if (!window.confirm("Deseja realmente excluir o Assunto EspecÌfico selecionado?")){
                        return ;
                    }
                }
                document.cadAssuntoEspec.action = "cadassuntoespec.php?numeroParte="+document.cadAssuntoEspec.seleParteBi.value
                    +"&numeroSecao="+document.cadAssuntoEspec.seleSecaoParteBi.value
                    +"&codTipoBol="+document.cadAssuntoEspec.seleTipoBol.value
                    +"&codAssuntoGeral="+document.cadAssuntoEspec.seleAssuntoGeral.value;
                document.cadAssuntoEspec.submit();
            }else
			
			
                                window.alert("Primeiro caractere inv·lido!b"); 
                            return false;}}}
            function carregaTexto(codAssuntoEspecifico,codAssuntoGeral){
                url="ajax_cad_assunto_espec.php?opcao=cadAssuntoEspecifico&codEspecifico="+codAssuntoEspecifico
                    +"&codGeral="+codAssuntoGeral;
                //window.alert(url);
                ajax(url,null,"cad_materia_bi");


                //ajax(url,"idTexto");
            }

            function carregaedit(codAssuntoGeral,codAssuntoEspec,descricao,vaiIndice,vaiAlteracao,textoPadAbert,textoPadFech,acao,IDT) {
                codAssGer = codAssuntoGeral;
                CodAssEsp = codAssuntoEspec;
                cinza();
				//alert("texto");
                document.getElementById(IDT).style.background = "#D5EADC";
                document.cadAssuntoEspec.cod.value = codAssuntoEspec;
                document.cadAssuntoEspec.descricao.value = descricao;
                document.getElementById("preview").style.visibility = "visible";
                if (vaiIndice == "S"){
                    document.cadAssuntoEspec.vai_indice.checked=true;
                }else{
                    document.cadAssuntoEspec.vai_indice.checked=false;
                }
                if (vaiAlteracao == "S"){
                    document.cadAssuntoEspec.vai_altr.checked=true;
                }else{
                    document.cadAssuntoEspec.vai_altr.checked=false;
                }
                //document.cadAssuntoEspec.texto_pad_abert.value = textoPadAbert;
                //document.cadAssuntoEspec.texto_pad_fech.value = textoPadFech;
                document.cadAssuntoEspec.acao.value = acao;
                //window.location.href = "#cadastro";
                //document.getElementById("formulario").style.visibility = "visible";
                //document.getElementById("novo").style.visibility = "hidden";
                document.getElementById("tituloForm").innerHTML = acao;
                carregaTexto(codAssuntoEspec,codAssuntoGeral);
                if(acao=="Excluir"){
                    executa("Excluir");
                }
            }
            function parteBi(){
                window.location.href = "cadassuntoespec.php?codTipoBol="+document.cadAssuntoEspec.seleTipoBol.value+"&numeroParte="+document.cadAssuntoEspec.seleParteBi.value;
            }
            function secaoParteBi(){
                window.location.href = "cadassuntoespec.php?codTipoBol="+document.cadAssuntoEspec.seleTipoBol.value+"&numeroParte="+document.cadAssuntoEspec.seleParteBi.value+
                    "&numeroSecao="+document.cadAssuntoEspec.seleSecaoParteBi.value;
            }
            function assuntoGeral(){
                window.location.href = "cadassuntoespec.php?codTipoBol="+document.cadAssuntoEspec.seleTipoBol.value+"&numeroParte="+document.cadAssuntoEspec.seleParteBi.value+
                    "&numeroSecao="+document.cadAssuntoEspec.seleSecaoParteBi.value+
                    "&codAssuntoGeral="+document.cadAssuntoEspec.seleAssuntoGeral.value;
            }

            function visualizar(codAssuntoGeral,codAssuntoEspecifico){
                document.getElementById("subscrForm").style.left = 50 + "px";
                document.getElementById("flyframe").style.visibility = "visible";
                document.getElementById('subscrForm').style.visibility = 'visible';
                document.getElementById('buscador').innerHTML =	'<table width="95%" border="0"><tr><td align="right"><input type="button" value="Fechar" onclick="javascript:escondeFly()"><\/td><\/tr><\/table>';
                isrc="ajax_cad_assunto_espec.php?opcao=cadAssuntoEspecifico&codEspecifico="+codAssuntoEspecifico
                    +"&codGeral="+codAssuntoGeral+"&flyframe=true";
                url = '<iframe WIDTH="680" HEIGHT="300" src="'+isrc+'"><\/iframe>';
                document.getElementById('textoForm').innerHTML = url;

                //url="ajax_cad_assunto_espec.php?opcao=cadAssuntoEspecifico&codEspecifico="+codAssuntoEspecifico
                //	+"&codGeral="+codAssuntoGeral+"&flyframe=true";
                //ajax(url,"textoForm");
            }
            function escondeFly(){
                document.getElementById("flyframe").style.visibility = "hidden";
                document.getElementById('subscrForm').style.visibility = 'hidden';
            }

            function tipoBol(codBol){
                window.location.href = "cadassuntoespec.php?codTipoBol="+document.cadAssuntoEspec.seleTipoBol.value;
            }
            // Tabs
            $(function(){
				$('#conteudo').attr('style','weight:755px');
				$('#flyframe').attr('style','background-color:#D5EADC');
                $('#tabs').tabs({
					cookie: {
					// store cookie for a day, without, it would be a session cookie
					expires: 1
					}
				});
             });
        </script>
    </head>
    <body><center>
            <div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
            <a name="lista"></a>
            <?php
            $apresentacao->chamaCabec();
            $apresentacao->montaMenu();
            $apresentacao->montaFlyForm(700, 350, '#D5EADC');

            if ($_SESSION['NOMEUSUARIO'] == 'supervisor') {
                $colTipoBol = $fachadaSist2->lerColecaoTipoBol('descricao');
            } else {
                $colTipoBol = $fachadaSist2->lerColecaoAutorizadaTipoBol($_SESSION['NOMEUSUARIO'], 1114);
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


            $colParteBi = $fachadaSist2->lerColecaoParteBoletim('numero_parte');
            if (isset($_GET['numeroParte'])) {
                $numeroParteAtual = $_GET['numeroParte'];
            } else {
                $obj = $colParteBi->iniciaBusca1();

                if (!is_null($obj)) {
                    $numeroParteAtual = $obj->getNumeroParte();
                } else {
                    $numeroParteAtual = 0;
                }
            }
            $colSecaoParteBi = $fachadaSist2->lerColecaoSecaoParteBi($numeroParteAtual);
            if (isset($_GET['numeroSecao'])) {
                $numeroSecaoParteBiAtual = $_GET['numeroSecao'];
            } else {
                $obj = $colSecaoParteBi->iniciaBusca1();

                if (!is_null($obj)) {
                    $numeroSecaoParteBiAtual = $obj->getNumeroSecao();
                } else {
                    $numeroSecaoParteBiAtual = 0;
                }
            }
            $colAssuntoGeral = $fachadaSist2->lerColecaoAssuntoGeral($numeroParteAtual, $numeroSecaoParteBiAtual, $codTipoBolAtual);
            if (isset($_GET['codAssuntoGeral'])) {
                $codAssuntoGeralAtual = $_GET['codAssuntoGeral'];
            } else {
                $obj = $colAssuntoGeral->iniciaBusca1();

                if (!is_null($obj)) {
                    $codAssuntoGeralAtual = $obj->getCodigo();
                } else {
                    $codAssuntoGeralAtual = 0;
                }
            }
            ?>
            <h3 class="titulo">&nbsp;&nbsp;<img src="./imagens/item_dir.gif" alt="">&nbsp;Cadastro de Assunto EspecÌfico </h3>
            <form  method="post" name="cadAssuntoEspec" action="">
              <table width="750px" border="0" cellspacing="4" bgcolor="#F5F5F5" style="border-top:1pt solid green;border-bottom:1pt solid green;border-left:1pt solid green;border-right:1pt solid green;">
                    <tr>
                        <td>Tipo de Boletim:</td>
                        <td>Parte BI:</td>
                        <td>SeÁ„o do BI:</td>
                    </tr>
                    <tr>
                        <td>
                            <?
                            //$apresentacao->montaCombo('seleSecaoParteBi',$colSecaoParteBi,'getNumeroSecao','getDescricao',$numeroSecaoParteBiAtual,'assuntoGeral()');
                            $apresentacao->montaCombo('seleTipoBol', $colTipoBol, 'getCodigo', 'getDescricao', $codTipoBolAtual, 'tipoBol()');
                            ?>
                        </td>
                        <td>

                            <?
                            $apresentacao->montaCombo('seleParteBi', $colParteBi, 'getNumeroParte', 'getDescrReduz', $numeroParteAtual, 'parteBi()');
                            $parteBi = $fachadaSist2->lerParteBoletim($numeroParteAtual);
                            ?>
                        </td>
                        <td>
                            <? $apresentacao->montaCombo('seleSecaoParteBi', $colSecaoParteBi, 'getNumeroSecao', 'getDescricao', $numeroSecaoParteBiAtual, 'secaoParteBi()'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">Assunto Geral:&nbsp;
                            <? $apresentacao->montaCombo('seleAssuntoGeral', $colAssuntoGeral, 'getCodigo', 'getDescricao', $codAssuntoGeralAtual, 'assuntoGeral()'); ?>
                        </td>
                    </tr>
                </table></br>
                 <?
                 
				 echo '<table width="65%" border="0">';
                 echo '<TR><TD width="30%" align="left"><a href="javascript:novo()" id="novo">';
                 echo '<img src="./imagens/add.png" border=0 alt="">&nbsp;<FONT COLOR="#0080C0">Adicionar</FONT></a></TD>';
                 //echo '<TD width="70%" align="right"><a href="#lista">Voltar ao Topo</a></TD>';
                 echo '</TR>';
                 echo '</TABLE>';?><br> 
                                
                <?
                if (isset($_POST['executar'])) {
                    $assuntoGeral = $fachadaSist2->lerAssuntoGeralComp($codAssuntoGeralAtual);
                    $assuntoEspec = new AssuntoEspec();
                    $assuntoEspec->setCodigo($_POST['cod']);
                    $assuntoEspec->setDescricao($_POST['descricao']);
                    if (isset($_POST['vai_indice'])) {
                        $assuntoEspec->setVaiIndice($_POST['vai_indice']);
                    } else {
                        $assuntoEspec->setVaiIndice('N');
                    }
                    if (isset($_POST['vai_altr'])) {
                        $assuntoEspec->setVaiAlteracao($_POST['vai_altr']);
                    } else {
                        $assuntoEspec->setVaiAlteracao('N');
                    }

                    //echo $assuntoEspec->setTextoPadAbert($_POST['texto_abert']);
                    $assuntoEspec->setTextoPadAbert($_POST['texto_abert']);

                    $assuntoEspec->setTextoPadFech($_POST['texto_fech']);

                    if ($_POST['executar'] == 'Incluir') {
                        $fachadaSist2->incluirAssuntoEspec($assuntoGeral, $assuntoEspec);
                    }
                    if ($_POST['executar'] == 'Excluir') {
                        $fachadaSist2->excluirAssuntoEspec($assuntoGeral, $assuntoEspec);
                    }
                    if ($_POST['executar'] == 'Alterar') {
                        $fachadaSist2->alterarAssuntoEspec($assuntoGeral, $assuntoEspec);
                    }
                }
                ?>
                <table id="conteudo"><tr><td>
                <div id="tabs">                      
                  <ul>
                        <?
                        $colLetras = $fachadaSist2->buscaLetras($codAssuntoGeralAtual);
                        $letras = $colLetras->iniciaBusca1();
                        $busca_array = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "_");
                        $outros = "";
                        while ($letras != null) {
							$letra = preg_replace("[^a-zA-Z0-9(-)_]", "", strtr($letras->getDescricao(), "·‡„‚ÈÍÌÛÙı˙¸Á¡¿√¬… Õ”‘’⁄‹«( " , "AAAAEEIOOOUUCAAAAEEIOOOUUC__"));
                            if (!in_array(strtoupper($letra), $busca_array)) {
								 $letras = $colLetras->getProximo1();
								 continue;
                                if ($outros == "") {
                                    $outros = "outros";
                                    echo '<li><a href="#tabs-Outros">Outros</a></li>';
                                }
                            } else {
                                echo '<li><a href="#tabs-' . strtoupper($letra) . '">' . strtoupper($letra) . '</a></li>';
                            }
                            $letras = $colLetras->getProximo1();
                        }
                        ?>
                    </ul>

                    <table style="width:800px; border:0px; cellspacing:0px; cellppading:0;border-top:1pt solid blue;border-bottom:1pt solid blue;border-left:1pt solid blue;border-right:1pt solid blue;">
          <?
                        $colAssuntoEspec2 = $fachadaSist2->lerColecaoAssuntoEspec($codAssuntoGeralAtual);
                        $assuntoEspec = $colAssuntoEspec2->iniciaBusca1();
                        $ord = 0;
                        $letraCapital = "";
                        $outros = "";
                        while ($assuntoEspec != null) {
							$letra = substr(ltrim(strtoupper($assuntoEspec->getDescricao())), 0, 1);
							//echo 'letra'.$letra.'<br>';
							$letra = preg_replace("[^a-zA-Z0-9(-)_]", "", strtr($letra, "·‡„‚ÈÍÌÛÙı˙¸Á¡¿√¬… Õ”‘’⁄‹«( ", "AAAAEEIOOOUUCAAAAEEIOOOUUC__"));
							if (!in_array($letra, $busca_array)) {
									 $assuntoEspec = $colAssuntoEspec2->getProximo1();
									continue;
							}
                            $ord++;
							//echo 'letra'.strtoupper($assuntoEspec->getDescricao());
                            

                            //Alterado por Ten S.Lopes -- 06/03/2012 -- cÛdigo anterior($letra = ereg_replace("[^a-zA-Z0-9_]", "", strtr($letra, "·‡„‚ÈÍÌÛÙı˙¸Á¡¿√¬… Õ”‘’⁄‹« ", "aaaaeeiooouucAAAAEEIOOOUUC_")))
                            //$letra = preg_replace("[^a-zA-Z0-9_]", "", strtr($letra, "·‡„‚ÈÍÌÛÙı˙¸Á¡¿√¬… Õ”‘’⁄‹« ", "aaaaeeiooouucAAAAEEIOOOUUC_"));
							$letra = preg_replace("[^a-zA-Z0-9(-)_]", "", strtr($letra, "·‡„‚ÈÍÌÛÙı˙¸Á¡¿√¬… Õ”‘’⁄‹«( ", "AAAAEEIOOOUUCAAAAEEIOOOUUC__"));
							//echo 'letra'.$letra;


                            if (($letraCapital != $letra) and (in_array($letra, $busca_array))) {
                                //$ord = 1;
                                //echo ($letraCapital == "") ? '' : '</tr></table></div>';
                                //echo ($outros == "") ? '' : '</tr></table></div>';
                                echo ($ord == 1) ? "</tr></table>" : "</tr></table></div>";
                                //echo '</tr></table></div>';
                                $outros = "";
                                $letraCapital = $letra;
                                echo chr(13) . '<div id="tabs-' . strtoupper($letraCapital) . '">' . chr(13);
								$ord++;
                                ?>
                                <table width="750px" border="0" cellspacing="1">
                                    <tr class="tr_cabec2">
                                        <td width="5%" align="center"><strong><font size="2">Ord</font></strong></td>
                                        <td width="65%" align="center"><strong><font size="2">DescriÁ„o do Assunto EspecÌfico</font></strong></td>
                                        <td width="8%" align="center"><strong><font size="2">Õndice</font></strong></td>
                                        <td width="8%" align="center"><strong><font size="2">Alter</font></strong></td>
                                        <td width="20%" align="center"><strong><font size="2">AÁ„o</font></strong></td>
                  </tr>
                                    <?
                                }
                                if (!in_array($letra, $busca_array)) {
									 
                                    if ($outros == "") {
                                        $outros = "outros";
										
                                        echo chr(13) . '<div id="tabs-Outros">' . chr(13);
										
                                        ?>
                                        <table width="100%" border="0" cellspacing="1">
                                            <tr class="tr_cabec2">
                                                <td width="5%" align="center"><strong><font size="2">Ord</font></strong></td>
                                                <td width="65%" align="center"><strong><font size="2">DescriÁ„o do Assunto EspecÌfico</font></strong></td>
                                                <td width="8%" align="center"><strong><font size="2">Õndice</font></strong></td>
                                                <td width="8%" align="center"><strong><font size="2">Alter</font></strong></td>
                                                <td width="20%" align="center"><strong><font size="2">AÁ„o</font></strong></td>
                                            </tr>
                              <?
                                    }
                                    //echo "Esta È a letra: ".$letra;
                                }
                                echo '<tr id=' . $ord . ' onMouseOut="outLinha(' . $ord . ')" onMouseOver="overLinha(' . $ord . ')" bgcolor="#F5F5F5">
                                    <td align="center">' . $ord . '</td><td>' . $assuntoEspec->getDescricao() . '</td>
                                    <td align="center">' . $apresentacao->retornaCheck($assuntoEspec->getVaiIndice()) . '</td>
                                    <td align="center">' . $apresentacao->retornaCheck($assuntoEspec->getVaiAlteracao()) . '</td>
                                    <td align="center">
                                        <a href="#" onclick="carregaedit(' . $codAssuntoGeralAtual . ',' . $assuntoEspec->getCodigo() .
                                ',\'' . $assuntoEspec->getDescricao() .
                                '\',\'' . $assuntoEspec->getVaiIndice() .
                                '\',\'' . $assuntoEspec->getVaiAlteracao() .
                                '\',\'' . $ord .
                                '\',\'' . $ord .
                                '\',\'Alterar\',' . $ord . ')">';
                                //verifica permissao
                                if ($_SESSION['NOMEUSUARIO'] != 'supervisor') {
                                    //		$mAlterar = $funcoesPermitidas->lerRegistro(1112);
                                    $mAlterar = $fachadaSist2->lerUsuarioFuncaoCodTipoBol($_SESSION['NOMEUSUARIO'], 1112, $codTipoBolAtual);
                                }
                                if (($mAlterar != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor')) {
                                    echo '<img src="./imagens/alterar.gif"  border=0 title="Alterar" alt=""><FONT COLOR="#000000"></FONT>';
                                    echo '</a>&nbsp;|&nbsp';
                                }
                                echo '<a href="javascript:carregaedit(' . $codAssuntoGeralAtual . ',' . $assuntoEspec->getCodigo() .
                                ',\'' . $assuntoEspec->getDescricao() .
                                '\',\'' . $assuntoEspec->getVaiIndice() .
                                '\',\'' . $assuntoEspec->getVaiAlteracao() .
                                '\',\'' . $ord .
                                '\',\'' . $ord .
                                '\',\'Excluir\',' . $ord . ')">';
                                //verifica permissao
                                if ($_SESSION['NOMEUSUARIO'] != 'supervisor') {
                                    //		$mExcluir = $funcoesPermitidas->lerRegistro(1113);
                                    $mExcluir = $fachadaSist2->lerUsuarioFuncaoCodTipoBol($_SESSION['NOMEUSUARIO'], 1113, $codTipoBolAtual);
                                }
                                if (($mExcluir != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor')) {
                                    echo '<img src="./imagens/excluir.gif" border=0 title="Excluir" alt="">';
                                }
                                echo '<FONT COLOR="#000000"></FONT>';
                                echo '</a>&nbsp;|&nbsp<a href="#" onclick="visualizar(' . $codAssuntoGeralAtual . ',' . $assuntoEspec->getCodigo() . ')"><img src="./imagens/buscar.gif"  border=0 title="Visualizar" alt=""></a>
                                    </td></tr>';

                                $assuntoEspec = $colAssuntoEspec2->getProximo1();
                            }
                            echo '</tr></table></div></div></td></tr></table>';
                            ?>

                            <?php
                            //verifica permissao
                            if ($_SESSION['NOMEUSUARIO'] != 'supervisor') {
                                //	$mIncluir = $funcoesPermitidas->lerRegistro(1111);
                                $mIncluir = $fachadaSist2->lerUsuarioFuncaoCodTipoBol($_SESSION['NOMEUSUARIO'], 1111, $codTipoBolAtual);
                            }
                            if (($mIncluir != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor')) {
                                echo '<table width="810" border="0">';
                        		echo '<TR><TD width="30%" align="left"><a href="javascript:novo()" id="novo">';
                              	//echo '<img src="./imagens/add.png" border=0 alt="">&nbsp;<FONT COLOR="#0080C0">Adicionar</FONT></a></TD>';
                            	echo '<TD width="70%" align="right"><a href="#lista">Voltar ao Topo</a></TD>';
                            	echo '</TR>';
                        		echo '</TABLE>';
  
                            }
                            ?>
                            <script type="text/javascript">javascript:tot_linhas(<?= $ord ?>)</script>

                            <input name="executar" type="hidden" value="">
                            <input name="cod" type="hidden" value="">
                            <a name="cadastro"></a><b>Legenda:</b> <img src="imagens/alterar.png" width="16" height="16"> Alterar &nbsp;&nbsp;<img src="imagens/excluir.png" width="16" height="16"> Excluir  &nbsp;&nbsp;<img src="imagens/buscar.gif" width="16" height="16">Visualizar
                            <div id="formulario" STYLE="VISIBILITY:hidden">
                                <TABLE width="800" bgcolor="#006633" border="0" cellspacing="0">
                                    <TR><TD>
                                            <table border="0"  width="100%" class="lista">
                                                <TR CLASS="cabec"><TD><div id="tituloForm"><font size="2"></font></div></TD>
                                                    <TD align="right"><INPUT TYPE="button" NAME="Vizualizar" id="preview" value="Visualizar" onClick="montaPreview2(codAssGer,CodAssEsp)"></TD></TR>
                                                <TR><TD COLSPAN="2" BGCOLOR="#E5E5E5" align="center" valign="top">
                                                        &nbsp;Assunto: <input name="descricao" type="text" size="100" maxlength="100"  onmouseover="return overlib(getMsg(2), CAPTION,'Como omitir este tÌtulo no BI ?');" onMouseOut="return nd();"/>&nbsp;
                                                        Õndice?&nbsp;<input name="vai_indice" type="checkbox">&nbsp;&nbsp;
                                          AlteraÁıes?&nbsp;<input name="vai_altr" type="checkbox"></TD></TR>
                                                <TR  CLASS="cabec">
                                                    <TD colspan="2" align="left"><B>Texto de abertura:</B>
                                                        <div id="idTexto">
                                                            <script type="text/javascript">
                                                                oFCKAbert.ToolbarSet = "CadMatBI";
                                                                oFCKAbert.Height = 300 ;
                                                                //oFCKAbert.Value = ;
                                                                oFCKAbert.Create() ;
                                                            </script>

                                                            <B>Texto de fechamento:</B>
                                                            <script type="text/javascript">
                                                                oFCKFech.ToolbarSet = "CadMatBI" ;
                                                                oFCKFech.Height = 150 ;
                                                                //oFCKFech.Value =
                                                                oFCKFech.Create() ;
                                                            </script>
                                                        </div>				</TD></TR>
                                                <TR>
                                                    <TD colspan="2" align="right"  CLASS="cabec">
                                                        <input name="acao" type="button" value="Incluir" onClick="executa(this.value)">
                                                        <input name="cancela" type="button" value="Cancelar" onClick="cancelar()"></TD></TR>
                                            </table>
                                        </TD></TR>
                              </TABLE>
                  </div>
      </form>
                            </center>
                            </body>
                            </html>
