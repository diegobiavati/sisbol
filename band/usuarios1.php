<?
    session_start();
    require_once('filelist_geral.php');
    require_once ('./filelist_om.php');
    $fachadaSist2 = new FachadaSist2();
    $funcoesPermitidas = $fachadaSist2->lerColecaoAutorizada($_SESSION['NOMEUSUARIO'], 'X');	
    $apresentacao = new Apresentacao($funcoesPermitidas);
    /*Listar OM vinculadas*/
    $colOmVinc2 = $fachadaSist2->lerColecaoOmVinc('nome');
    $OmVinc = $colOmVinc2->iniciaBusca1();
    $omVinculacao = $OmVinc->getCodOM();

    /*Listar Subunidades*/
    $colSubun2 = $fachadaSist2->lerColecaoSubun($omVinculacao);
    $subun = $colSubun2->iniciaBusca1();

    //$omVinculacao = (isset($_GET['omVinculacao']))?($_GET['omVinculacao']):"0";
    $codSubun = (isset($_GET['codSubun']))?($_GET['codSubun']):"0";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SisBol</title>
<? $apresentacao->chamaEstilo(); ?>
<script type="text/javascript" src="scripts/band.js"></script>
<script type="text/javascript">
	function novo(){
		document.getElementById("formulario").style.visibility = "visible";
		document.getElementById("novo").style.visibility = "hidden";
		document.getElementById("tituloForm").innerHTML = "Incluir";
		document.usuario.login.value  = '';
   		document.usuario.senha.value  = '';
//		document.usuario.dataexpir.value = '01/01/2008';
		document.usuario.login.focus();
	}
	function cancelar(){
		document.usuario.login.readOnly  = false;
		document.usuario.senha.readOnly  = false;
		document.usuario.confsenha.readOnly  = false;
//		document.usuario.dataexpir.readOnly  = false;
		document.usuario.login.value  = '';
   		document.usuario.senha.value  = '';
		document.usuario.confsenha.value = '';
//		document.usuario.dataexpir.value = '';
   		document.usuario.acao.value = "Incluir";
   		document.getElementById("formulario").style.visibility = "hidden";
   		document.getElementById("novo").style.visibility = "visible";
	}
	function executa(acao){
		document.usuario.executar.value = acao;

            if ((acao == "Incluir") || (acao == "Alterar")){
        	if (document.usuario.login.value == ""){
			window.alert("Informe o Login do Usuário!");
			document.usuario.login.focus();
			return;
		}    
		if (document.usuario.senha.value == "") {
			window.alert("Informe a senha do Usuário!");
			document.usuario.senha.focus();
			return;
		}
		if (document.usuario.confsenha.value == "") {
			window.alert("Informe a confirmação da senha!");
			document.usuario.confsenha.focus();
			return;
		}
//		if (document.usuario.dataexpir.value == "") {
//			window.alert("Informe a data de expiração da senha!");
//			document.usuario.dataexpir.focus();
//			return;
//		}
		if (document.usuario.senha.value != document.usuario.confsenha.value) {
			window.alert("A confirmação da senha não confere! Digite novamente.");
			document.usuario.confsenha.focus();
			return;
		}
            }
            if (acao == "Excluir")  {
			if (!window.confirm("Deseja realmente excluir o usuário selecionado ?")){
				return ;
			}
            }
		
		document.usuario.action = "usuarios.php";
		document.usuario.submit();
	}
	function carregaedit(login,senha,om_vinc,subun,todas_omvinc,todas_subun,todas_omvinc2,todas_subun2,modifica_modelo,acao,IDT) {
		//cinza();
                window.location.href="#cadastro";
                carregaSubun(om_vinc,subun);
		document.usuario.om_vinc.value  = om_vinc;
		document.usuario.login.value  = login;
		document.usuario.login.readOnly  = true;
		document.usuario.senha.value = senha;
		document.usuario.confsenha.value = senha;
		if (todas_omvinc == "S"){
			document.usuario.todas_omvinc.checked=true;
		}else{
			document.usuario.todas_omvinc.checked=false;
		}
		if (todas_subun == "S"){
			document.usuario.todas_subun.checked=true;
		}else{
			document.usuario.todas_subun.checked=false;
		}
		if (todas_omvinc2 == "S"){
			document.usuario.todas_omvinc2.checked=true;
		}else{
			document.usuario.todas_omvinc2.checked=false;
		}
		if (todas_subun2 == "S"){
			document.usuario.todas_subun2.checked=true;
		}else{
			document.usuario.todas_subun2.checked=false;
		}
		if (modifica_modelo == "S"){
			document.usuario.modifica_modelo.checked=true;
		}else{
			document.usuario.modifica_modelo.checked=false;
		}
//		document.usuario.dataexpir.value  = dataexpir;
//		var dia = dataexpir.substring(0,2);
//		var mes = dataexpir.substring(3,5);
//		var ano = dataexpir.substring(6,10);
//		document.usuario.dataexpir_mysql.value = ano + '-' + mes + '-' + dia;
		document.usuario.acao.value = acao;
		if (document.usuario.acao.value == 'Excluir'){
			document.usuario.senha.readOnly  = true;
			document.usuario.confsenha.readOnly  = true;
//			document.usuario.dataexpir.readOnly  = true;
			document.usuario.om_vinc.readOnly  = true;
			document.usuario.sele_cad_subun.readOnly  = true;
		}
		//document.getElementById(IDT).style.background = "#DDEDFF";
   		
   		document.getElementById("formulario").style.visibility = "visible";
   		document.getElementById("novo").style.visibility = "hidden";
   		document.getElementById("tituloForm").innerHTML = acao;
	}  
  function validarData(campo){
	var expReg = /^(([0-2]\d|[3][0-1])\/([0]\d|[1][0-2])\/[1-2][0-9]\d{2})$/;
	var msgErro = 'Formato de data inválido!';
	if ((campo.value.match(expReg)) && (campo.value!='')){
		var dia = campo.value.substring(0,2);
		var mes = campo.value.substring(3,5);
		var ano = campo.value.substring(6,10);

		if((mes==4 || mes==6 || mes==9 || mes==11) && (dia > 30)){
			window.alert("Dia incorreto!!! O mês especificado contém no máximo 30 dias.");
			campo.focus();
			return false;
		} else{
			if(ano%4!=0 && mes==2 && dia>28){
				window.alert("Dia incorreto!!!!!! O mês especificado contém no máximo 28 dias.");
				campo.focus();
				return false;
			} else{
				if(ano%4==0 && mes==2 && dia>29){
					window.alert("Dia incorreto!!!!!! O mês especificado contém no máximo 29 dias.");
					campo.focus();
					return false;
				} else{
					var data = ano + '-' + mes + '-' + dia;
					document.usuario.dataexpir_mysql.value = data;
					return true;
				}
			}
		}
		
	}else {
		window.alert(msgErro);
		campo.focus();
		return false;
	}
  }		
	function onChangeOMVinv(){
		url="ajax_cadmilitar.php?opcao=atualizaCmboSubun&codom="+document.usuario.om_vinc.value;
		//window.alert(url);
		ajax(url,"divSubun");
	}
	function carregaSubun(om_vinc,subun){
		url="ajax_cadmilitar.php?opcao=atualizaCmboSubun&codom="+om_vinc+"&codSubun="+subun;
		//window.alert(url);
		ajax(url,"divSubun");
	}
	</script>
</head>
<body>
<center>
  <? 	$apresentacao->chamaCabec();
		$apresentacao->montaMenu();
	?>
  <h3 class="titulo">&nbsp;&nbsp;<img src="./imagens/item_dir.gif" alt="">&nbsp;Cadastro de Usuários</h3>
  <?PHP
          echo '<table width="75%" border="0" >';
	  echo '<TR><TD><a href="javascript:novo()" id="novo">';
          //verifica permissao
          if ($_SESSION['NOMEUSUARIO'] != 'supervisor')
          { $mIncluir = $funcoesPermitidas->lerRegistro(1151);
          }
          if (($mIncluir != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor'))
          { echo '<img src="./imagens/add.png" border=0 alt="">&nbsp;<FONT COLOR="#0080C0">Adicionar</FONT></a></TD>';
          }
		  
	  echo '</TR></TABLE>';
	?>
    <br><br>
  <table width="850px" border="0" cellspacing="0" class="lista">
    <tr>
      <td><table width="100%" border="1" cellspacing="0" >
          <tr class="cabec">
            <td rowspan="3" width="5%"><div align="center"><strong><font size="2">Ord</font></strong></div></td>
            <td rowspan="3" width="15%" align="center"><strong><font size="2">Login</font></strong></td>
            <td rowspan="3" width="12%" align="center"><strong><font size="2">OM de Vinculação</font></strong></td>
            <td rowspan="3" width="12%" align="center"><strong><font size="2">Subunidade / Divisão</font></strong></td>
            <td colspan="5" align="center"><strong><font size="2">ACESSOS</font></strong></td>
            <td rowspan="3" width="10%" align="center"><strong><font size="2">Ação</font></strong></td>
          </tr>
          <tr class="cabec">
            <td colspan="2" align="center"><strong><font size="2">Notas p/ BI</font></strong></td>
            <td colspan="2" align="center"><strong><font size="2">Lista de Militares</font></strong></td>
            <td rowspan="2" align="center" width="10%">Modifica Modelo</td>
          </tr>
          <tr class="cabec">
            <td width="9%" align="center"><strong><font size="2">Todas OM Vinc</font></strong></td>
            <td width="9%" align="center"><strong><font size="2">Todas SU/Div</font></strong></td>
            <td width="9%" align="center"><strong><font size="2">Todas OM Vinc</font></strong></td>
            <td width="9%" align="center"><strong><font size="2">Todas SU/Div</font></strong></td>
          </tr>
          <?php
		if (isset($_POST['executar']))
		{   //$data = new MinhaData($_POST['dataexpir_mysql']);
  			$usuario = new Usuario(null);
  			$usuario->setLogin($_POST['login']);
  			$usuario->setSenha($_POST['senha']);
  			$usuario->setCodom($_POST['om_vinc']);
  			$usuario->setCodSubun($_POST['sele_cad_subun']);
			if (isset($_POST['todas_omvinc']))
                            $usuario->setTodasOmVinc($_POST['todas_omvinc']);
                        else
                            $usuario->setTodasOmVinc("N");
			if (isset($_POST['todas_subun']))
                            $usuario->setTodasSubun($_POST['todas_subun']);
                        else
                            $usuario->setTodasSubun("N");
			if (isset($_POST['todas_omvinc2']))
                            $usuario->setTodasOmVinc2($_POST['todas_omvinc2']);
                        else
                            $usuario->setTodasOmVinc2("N");
			if (isset($_POST['todas_subun2']))
                            $usuario->setTodasSubun2($_POST['todas_subun2']);
                        else
                            $usuario->setTodasSubun2("N");
			if (isset($_POST['modifica_modelo']))
                            $usuario->setModificaModelo($_POST['modifica_modelo']);
                        else
                            $usuario->setModificaModelo("N");
                        //print_r($usuario);
  			if ($_POST['executar'] == 'Incluir'){
				$fachadaSist2->incluirUsuario($usuario);	
			}	
			if ($_POST['executar'] == 'Excluir'){
				$fachadaSist2->excluirUsuario($usuario);
			}
			if ($_POST['executar'] == 'Alterar'){
				$fachadaSist2->alterarUsuario($usuario);
			}
  		}
  		$colUsuario2 = $fachadaSist2->lerColecaoUsuario();
  		$usuario = $colUsuario2->iniciaBusca1();
                //print_r($usuario);
  		while ($usuario != null){
//                    if ($usuario->getCodom()!=null){
                        $omVinc = $fachadaSist2->lerOMVinc($usuario->getCodom());
                        $siglaOmVinc = $omVinc->getSigla();
                        $codOmVinc = $usuario->getCodom();
//                    }else{
//                        $siglaOmVinc = 'Indefinida';
//                        $codOmVinc = '999999';
//                    }

//                    if (($usuario->getCodom()!=null) && ($usuario->getCodSubun()!=null)){
                        $subun = $fachadaSist2->lerSubun($usuario->getCodom(), $usuario->getCodSubun());
						//print_r($subun);
                        $siglaSubun = $subun->getSigla();
                        $codSubun = $subun->getCod();
//                    }else{
 //                       $siglaSubun = 'Indefinida';
 //                       $codSubun = 99;
 //                   }

			$ord++;
			echo '<tr id='.$ord.' onMouseOut="outLinha('.$ord.')" onMouseOver="overLinha('.$ord.')" bgcolor="#F5F5F5">
				<td align="center">'.$ord.'</td>
				<td>'. $usuario->getLogin().'</td>
				<td>'. $siglaOmVinc.'</td>
				<td>'. $siglaSubun.'</td>
				<td align="center">'. $apresentacao->retornaCheck($usuario->getTodasOmVinc()) .'</td>
				<td align="center">'. $apresentacao->retornaCheck($usuario->getTodasSubun()) .'</td>
				<td align="center">'. $apresentacao->retornaCheck($usuario->getTodasOmVinc2()) .'</td>
				<td align="center">'. $apresentacao->retornaCheck($usuario->getTodasSubun2()) .'</td>
				<td align="center">'. $apresentacao->retornaCheck($usuario->getModificaModelo()) .'</td>
				
				<td align="center">
				<a href="javascript:carregaedit(\''.$usuario->getLogin().'\',\''
					.$usuario->getSenha().'\',\''
					.$codOmVinc.'\','
					.$codSubun.',\''
					.$usuario->getTodasOmVinc().'\',\''
					.$usuario->getTodasSubun().'\',\''
					.$usuario->getTodasOmVinc2().'\',\''
					.$usuario->getTodasSubun2().'\',\''
					.$usuario->getModificaModelo().'\','
                                        .'\'Alterar\','.$ord.')">';
                //verifica permissao
                if ($_SESSION['NOMEUSUARIO'] != 'supervisor')
                { $mAlterar = $funcoesPermitidas->lerRegistro(1152);
                }
                if (($mAlterar != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor'))
			    { echo '<img src="./imagens/alterar.png"  border=0 alt=""><FONT COLOR="#000000"></FONT></a>&nbsp;|&nbsp'; 
			    }
			echo '<a href="javascript:carregaedit(\''.$usuario->getLogin().'\',\''
					.$usuario->getSenha().'\',\''
					.$codOmVinc.'\','
					.$codSubun.',\''
					.$usuario->getTodasOmVinc().'\',\''
					.$usuario->getTodasSubun().'\',\''
					.$usuario->getTodasOmVinc2().'\',\''
					.$usuario->getTodasSubun2().'\',\''
					.$usuario->getModificaModelo().'\','
                                        .'\'Excluir\','.$ord.')">';
            //verifica permissao
            if ($_SESSION['NOMEUSUARIO'] != 'supervisor')
            { $mExcluir = $funcoesPermitidas->lerRegistro(1153);
            }
            if (($mExcluir != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor'))
            { echo '<img src="./imagens/excluir.png" border=0 alt=""><FONT COLOR="#000000"></FONT>';
			}
			echo '</a></td></tr>';
    		$usuario = $colUsuario2->getProximo1();
  		}
		?>
        </table></td>
    </tr>
  </table>
  <!-- Formulário parainserçao/alteração de dados Inicialmente escondido-->
  <form method="post" name="usuario" action="">
    <input name="executar" type="hidden" value="">
    <div id="formulario" STYLE="VISIBILITY:hidden"> <a name="cadastro"></a><br>
      <TABLE class="formulario" width="850px"bgcolor="#0000FF" >
        <TR>
          <TD><TABLE width="100%" border="0" CELLSPACING="0" style=" name:tabela;">
              <TR CLASS="cabec">
                <TD colspan="4">
                  <div id="tituloForm"><font size="2"></font></div>
                </TD>
              </TR>
              <TR>
                <TD BGCOLOR="#E9E9E9" colspan="4">&nbsp;</TD>
              </TR>
              <TR>
                <TD BGCOLOR="#E9E9E9" colspan="4">&nbsp;&nbsp;&nbsp;Login:
                  <input name="login" type="text" size="20" maxlength="15">
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Senha:
                  <input name="senha" type="password" size="20" maxlength="20">
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Confirme a senha:
                  <input name="confsenha" type="password" size="20" maxlength="20"></TD>
              </TR>
              <TR>
                <TD BGCOLOR="#E9E9E9" colspan="4">&nbsp;</TD>
              </TR>
              <TR>
                <TD BGCOLOR="#E9E9E9" WIDTH="14%">&nbsp;&nbsp;&nbsp;OM de Vinculação:</TD>
                <TD BGCOLOR="#E9E9E9" WIDTH="26%"><?
                        $apresentacao->montaCombo('om_vinc', $colOmVinc2, 'getCodOM', 'getSigla', $omVinculacao, 'onChangeOMVinv()');
                    ?></TD>
                <TD BGCOLOR="#E9E9E9" WIDTH="15%">&nbsp;&nbsp;&nbsp;Subunidade/Divisão:</TD>
                <TD BGCOLOR="#E9E9E9" WIDTH="35%"><div id="divSubun">
                    <?
                        $apresentacao->montaCombo('sele_cad_subun', $colSubun2, 'getCod', 'getSigla', $codSubun, '');
                    ?>
                  </div></TD>
              </TR>
              <TR>
                <TD BGCOLOR="#E9E9E9" colspan="4">&nbsp;</TD>
              </TR>
              <TR>
                <TD BGCOLOR="#E9E9E9" colspan="2">&nbsp;&nbsp;&nbsp;
                  <input name="todas_omvinc" type="checkbox" value="S">
                  Acesso as Notas de todas as OM Vinculadas? </TD>
                <TD BGCOLOR="#E9E9E9" colspan="2">&nbsp;&nbsp;&nbsp;
                  <input name="todas_subun" type="checkbox" value="S">
                  Acesso as Notas de todas as SU/Div da OM Vinc selecionada? </TD>
              </TR>
              <TR>
                <TD BGCOLOR="#E9E9E9" colspan="4">&nbsp;</TD>
              </TR>
              <TR>
                <TD BGCOLOR="#E9E9E9" colspan="2">&nbsp;&nbsp;&nbsp;
                  <input name="todas_omvinc2" type="checkbox" value="S">
                  Acesso a lista de militares de todas as OM Vinculadas? </TD>
                <TD BGCOLOR="#E9E9E9" colspan="2">&nbsp;&nbsp;&nbsp;
                  <input name="todas_subun2" type="checkbox" value="S">
                Acesso a lista de militares de todas as SU/Div da OM Vinc selecionada? </TD>
              </TR>
              <TR>
                <TD BGCOLOR="#E9E9E9" colspan="4">&nbsp;</TD>
              </TR>
              <TR>
                <TD BGCOLOR="#E9E9E9" colspan="2">&nbsp;&nbsp;&nbsp;
                  <input name="modifica_modelo" type="checkbox" value="S">
                  Pode modificar modelo das Notas? </TD>
                <TD BGCOLOR="#E9E9E9" colspan="2">&nbsp;</TD>
              </TR>
              <TR>
                <TD BGCOLOR="#E9E9E9" colspan="4">&nbsp;</TD>
              </TR>
              <TR>
                <TD BGCOLOR="#E9E9E9" align="center" colspan="2"><a href="imprimeperfilusuario_porusuario.php"><FONT COLOR="#000000">Perfil por Usuário</FONT></a>&nbsp;&nbsp;&nbsp; <a href="imprimeperfilusuario_porfuncao.php"><FONT COLOR="#000000">Perfil por Função</FONT></a></td>
                <TD BGCOLOR="#E9E9E9" align="right" colspan="2"><input name="acao" type="button" value="Incluir" onClick="executa(this.value)">
                  <input name="cancela" type="button" value="Cancelar" onClick="cancelar()">
                  <br><br>
                  <input name="dataexpir" type="hidden" size="12" maxlength="12" onBlur="validarData(this)">
                <input name="dataexpir_mysql" type="hidden" value=""></TD>
              </TR>
          </table></TD>
        </TR>
      </TABLE>
    </div>
  </form>
</center>
</body>
</html>
