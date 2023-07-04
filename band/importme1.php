<? 	session_start();
	require_once('./filelist_geral.php');
	require_once('./filelist_om.php');
	require_once('./filelist_funcao.php');
	$fachadaSist2 = new FachadaSist2();
    $funcoesPermitidas = $fachadaSist2->lerColecaoAutorizada($_SESSION['NOMEUSUARIO'], 'X');
	$apresentacao = new Apresentacao($funcoesPermitidas);
//        $omVinculacao = (isset($_GET['omVinculacao']))?($_GET['omVinculacao']):"0";
        $codSubun = (isset($_GET['codSubun']))?($_GET['codSubun']):"0";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SisBol</title>
<? $apresentacao->chamaEstilo(); ?>
<script type="text/javascript" src="scripts/band.js"></script>
<script type="text/javascript">
	function seleMilPGrad(){
		window.location.href="importme1.php?codom="+document.cadMilitar.om_vinc.value+"&codSubun="+
							document.cadMilitar.sele_subun.value;
	}
	function seleSubun(){
		window.location.href="importme1.php?omVinculacao="+document.cadMilitar.om_vinc.value+"&codSubun="+
							document.cadMilitar.sele_subun.value;
	}
        </script>
</head>
<body>
<center>
  <?  $apresentacao->chamaCabec();
	$apresentacao->montaMenu();
?>
  <h3 class="titulo">&nbsp;&nbsp;<img src="./imagens/item_dir.gif" alt="">&nbsp;Carrega Dados do Módulo E1</h3>
  <form enctype="multipart/form-data" action="carrega_me1.php" method="post" name="cadMilitar">
    <TABLE width="640" bgcolor="yellow" border="1" cellspacing="0">
      <TR>
        <TD><TABLE width="100%" border="0"  CELLSPACING="0" style="name:tabela;">
            <TR>
              <TD><font face="Arial" size="3"><B><img src="imagens/atencao.png" width="16" height="16"> Aten&ccedil;&atilde;o</B></font></TD>
            </TR>
            <TR>
              <TD  BGCOLOR="#FFFFEa"> <br>
                <b>&nbsp;&nbsp;Esta op&ccedil;&atilde;o destina-se à importação dos militares cadastrados no m&oacute;dulo
                E1.<br />&nbsp;&nbsp;Antes de executar, saiba que:</b>
                <ul>
                  <li> Você deve cadastrar a OM de vincula&ccedil;&atilde;o e SU/Div/Sec<strong> antes de carregar</strong>;</li>
                  <li> Caso necessário, cadastre uma função 'Comum', e selecione no formulário;</li>
                  <li> Pode ser que alguns militares não sejam carregados, nesse caso estes devem ser cadastrados manualmente
                    a partir do módulo de Cadastro de Militares;</li>
                  <li> Esta op&ccedil;&atilde;o pode ser repetida, pois os militares carregados não serão alterados.</li>
                  
                </ul>
                </TD>
            </TR>
          </TABLE></TD>
      </TR>
    </TABLE>
    <br>
    <br>
    <table width="650px" border="0" cellspacing="0"  class="lista">
    <tr>
      <td><table width="100%" border="0" cellspacing="0">
        <tr class="cabec">
          <td colspan="4"><font size="2" >Carregar arquivo</font></td>
        </tr>
        <tr bgcolor="#F5F5F5">
          <td align="left" colspan="4"><br><br><br></td>
        </tr>
        <tr bgcolor="#F5F5F5">
          <td align="left" width="15%">OM Vinculação:</td>
          <td><?
		  	/*Listar OM vinculadas*/
                		$colOmVinc2 = $fachadaSist2->lerColecaoOmVinc('nome');
                                if (isset($_GET['codom'])){
                			$codom = $_GET['codom'];
                                }else {
                                    $obj = $colOmVinc2->iniciaBusca1();

                                    if (!is_null($obj)){
                                        $codom = $obj->getCodOM();
                                    } else {
                                        $codom = 0;
                                    }
                                }
  				//$colOmVinc2 = $fachadaSist2->lerColecaoOmVinc('nome');
  				//$OmVinc = $colOmVinc2->iniciaBusca1();
				$apresentacao->montaCombo('om_vinc',$colOmVinc2,'getCodOM','getNome',$codom,'seleMilPGrad()');
			?>
			</td>
          <td> SU/Div/Sec:</td>
          <td><?	/*Listar Subunidades*/
                                $colSubun2 = $fachadaSist2->lerColecaoSubun($codom);
                                $subun = $colSubun2->iniciaBusca1();
                                $apresentacao->montaCombo('sele_subun', $colSubun2, 'getCod', 'getSigla', $codSubun, 'seleSubun()');
			?>
			</td>
        </tr>
        <tr bgcolor="#F5F5F5">
          <td align="left" colspan="4"><br></td>
        </tr>
        <tr bgcolor="#F5F5F5">
          <td> Função:</td>
          <td colspan="3"><?	/*Listar funções*/
  				$colFuncao2 = $fachadaSist2->lerColecaoFuncao('cod');
  				$Funcao = $colFuncao2->iniciaBusca1();
				$apresentacao->montaCombo('funcao_cod',$colFuncao2,'getCod','getDescricao',
  									$codfuncao,'');
			?></td>
        </tr>
        <tr bgcolor="#F5F5F5">
          <td align="left" colspan="4"><br></td>
        </tr>
        <tr bgcolor="#F5F5F5">
          <td align="left"><input type="hidden" name="MAX_FILE_SIZE" value="1000000" size="90"/>Arquivo:</td>
          <td align="left" colspan="3"><input name="userfile" type="file" size="50"/>&nbsp;&nbsp;<input type="submit" value="Carregar" /></td>
        </tr>
		
		</table>
		</table>
		</form>
 
  
</center>
</body>
</html>
