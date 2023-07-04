<?
session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SisBol</title>
<script type="text/javascript" src="scripts/jcap.js" charset="UTF-8"></script>
        <script type="text/javascript" src="scripts/md5.js" charset="UTF-8"></script>
<!-- Login ver 2.5 - PARREIRA -->
<style type="text/css">
<!--

body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
        background-image: url(./imagens/login_new_bg.png);
	background-repeat:no-repeat;
}
#tabela {
	position:absolute;
	left: 50%;
	top:50%;
	margin-left: -389px;
	margin-top: -280px;
	border: 1px solid #000;
	width: 777px;
	height: 559px;
	text-align:center;
	border: 0;
        display: inline;
	float:left;
}
#linha1 {
	width: 100%;
	height: 150px;
	margin-top: 80px;
        display: inline;
	float:left;
}
#col1linha1 {
	width: 580px;
	height: 150px;

        display: inline;
	float:left;
}
#col2linha1 {
	width: 150px;
	height: 150px;
        display: inline;
	float:left;
}
#linha2 {
        margin-left: 90px;
        margin-top: 5px;
	width: 100%;
	height: 350px;
        display: inline;
	float:left;
}
#col1linha2 {
	width: 380px;
	height: 350px;
        display: inline;
	float:left;
}
.tit_corpo_input{
    margin-left: 5px;
    width: 375px;
    display: inline;
    float:left;
    text-align: left;
    font-family: "trebuchet ms", Helvetica;
    font-size: 10pt;
    color: #fff;
    font-weight: bold;
}

.tit_input{
    width: 90px;
    height: 28px;
    display: inline;
    float:left;
}
.corpo_input{
    width: 285px;
    height: 28px;
    display: inline;
    float:left;
}
.corpo_input2{
    width: 285px;
    display: inline;
    float:left;
}
.campos_input {

  background-color: #FAFFF4;
  border:1px #888888 solid;
  font-size: 12px;
  color: #000000;
  margin-bottom:1px;
  font-family: arial,sans-serif;
  text-align:left;
  height: 18px;

  }
  .campos_input2 {

  background-color: #FAFFF4;
  border:1px #888888 solid;
  font-size: 12px;
  color: #000000;
  margin-bottom:1px;
  margin-top: 6px;
  font-family: arial,sans-serif;
  text-align:left;
  height: 18px;

  }
.botao_entrar {
    margin-top: 17px;
    margin-left: 5px;
    background-image: url(./imagens/login_new_entrar.png);
    width: 97px;
    height: 64px;    
       }
.botao_limpar {
    margin-top: 17px;
    margin-left: 10px;
    background-image: url(./imagens/login_new_limpar.png);
    width: 97px;
    height: 64px;    
       }
.botao_cadastrar {
    margin-top: 17px;
    margin-left: 10px;
    background-image: url(./imagens/login_new_cadastrar.png);
    width: 126px;
    height: 64px;    
       }
.img_input{
    margin-top: 16px;
    margin-left: 3px;
}
#col2linha2 {
	width: 260px;
	height: 350px;

        display: inline;
	float:left;
}
.alignlogo {
    margin-top: 10px;

}
.txtversao {
    text-align: right;
    margin-top: 20px;
    font-family: "trebuchet ms", Helvetica;
    font-size: 10pt;
    color: #fff;
    font-weight: bold;
}
#cxinput {
    background-image: url(./imagens/login_new2.png);
    background-repeat: repeat-x;
    height: 228px;
}
.txttit {
    padding-top: 5px;
    padding-bottom: 5px;
    font-family: "trebuchet ms", Helvetica;
    font-size: 12pt;
    color: #fff;
    font-weight: bold;
}


.style1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 18px;
	color: #fff;
}

/*.login {
    background-image: url("./imagens/entrada_sisbol.png");
    height: 477px;
}*/
.login {
    background-image: url("./imagens/login_new1.png");
    background-repeat: no-repeat;
    
}

.style3 {font-family: Verdana, Arial, Helvetica, sans-serif; font-weight: bold; font-size: 16px; color: #663300; }
-->
</style>
<?

require ('filelist_geral.php');
require_once('./filelist_om.php');
$local_user 	= 'supervisor';
$fachadaSist2 	= new FachadaSist2();

if (isset ($_GET['login'])) { //Se foi requerido login
		// Testando o captcha
		if($_POST['cod1'] != md5($_POST['validador'])){
			echo '<script>window.alert("Acesso negado - Dados inválidos")</script>';		
			echo '<script>window.location.href="sisbol.php";</script>';
		}
}

// Gerar a senha do supervisor
if (isset ($_GET['supervisor'])) {
	$local_senha = encriptaSenha($_POST['senha']);
	$texto = 'supersenha=' . $local_senha;
	// Alterado pelo Ten S.Lopes 17/04/2012 - ('../supervisor.ini')caminho errado. para-->
	$size = file_put_contents('../../supervisor.ini', $texto);
	if ($size > 5) {
		echo '<script>window.alert("Senha do supervisor gravada com sucesso.");</script>';
	}
}
// Busca o arquivo ini do supervisor
// Alterado pelo Ten S.Lopes 17/04/2012 - ('../supervisor.ini')caminho errado. para-->
$iniFile = new IniFile('../../supervisor.ini');
$supIniFile = new SupIniFile($iniFile);
$local_senha = $supIniFile->getPassword();
if ($local_senha == null) {
	echo '<script>window.alert("Usuário supervisor não cadastrado.\n\n Cadastre o usuário supervisor");';
	echo 'function administrador(){';
	echo '	if(document.formLogin.senha.value !== document.formLogin.senha1.value){';
	echo '		window.alert("As senhas informadas não são iguais.");';
	echo '		return;';
	echo '	}';

	echo '	if((document.formLogin.nomeUsuario.value == "")||(document.formLogin.senha.value == "")){';
	echo '		window.alert("Informe seu nome de usuário e a senha do Administrador.");';
	echo '		return;';
	echo '	}';
	echo '  document.formLogin.action = "sisbol.php?supervisor=true";';
	echo '	document.formLogin.submit();';
	echo '}</script>';
} else {
	if (isset ($_GET['login'])) { //Se foi requerido login
		//echo 'foi requerido login';
		$usuario = new Usuario(null);
		$usuario->setLogin($_POST['nomeUsuario']);
		$usuario->setSenha($_POST['senha']);
		
		//registra os parametros de configuracao
		$configuracoes = $fachadaSist2->lerConfiguracoes();
		$_SESSION['APROVNOTA1'] = $configuracoes->getAprovNota1();		
		$_SESSION['APROVNOTA2'] = $configuracoes->getAprovNota2();		
		$_SESSION['APROVBOLETIM'] = $configuracoes->getAprovBoletim();		
		$_SESSION['IMPRIMENOMESLINHA'] = $configuracoes->getImprimeNomesLinha();		
		$_SESSION['IMPRIMEASSINATURA'] = $configuracoes->getImprimeAssinatura();
		$_SESSION['IMPRIMEQMS'] = $configuracoes->getImprimeQMS();		
		
		//O primeiro if é para o usuário administrador
		if (($local_user == $usuario->getLogin()) and (comparaSenha($local_senha, $usuario->getSenha()))) {
			// registra as variaveis de sessao
			$_SESSION['TIPOUSER'] = 1;
			$_SESSION['NOMEUSUARIO'] = $usuario->getLogin();

			$_SESSION['ORGANIZACAO'] = (is_object($fachadaSist2->lerOM()))?$fachadaSist2->lerOM()->getNome():'OM não cadastrada';
	 		//$_SESSION['OM_VINC'] = '999999';
	 		//$_SESSION['SUBUN'] = 99;
         		$_SESSION['TODAS_OMVINC'] = 'X';
			$_SESSION['TODAS_SUBUN'] = 'X';
         		$_SESSION['TODAS_OMVINC2'] = 'X';
	 		$_SESSION['TODAS_SUBUN2'] = 'X';
	 		$_SESSION['MODIFICA_MODELO'] = 'X';
			echo '<script>location.href="menuboletim.php"</script>';
		} else { // se nao e o supervisor, ler o usuario
			$lUsuario = $fachadaSist2->lerUsuario($usuario->getLogin());
			//se o usuario nao existe
			if ($lUsuario == null) {
				echo '<script>window.alert("Acesso negado - Dados inválidos")</script>';
			} else { //se existe, verifica a senha
        		$omVinc = $fachadaSist2->lerOMVinc($lUsuario->getCodom());
                $siglaOmVinv = $omVinc->getSigla();
                $subun = $fachadaSist2->lerSubun($lUsuario->getCodom(), $lUsuario->getCodSubun());
                $siglaSubun = $subun->getSigla();
                                if ($usuario->getSenha() != $lUsuario->getSenha()) {
					//echo 'senha infor='.$usuario->getSenha(). 'senha lida='. $lUsuario->getSenha();
					echo '<script>window.alert("Acesso negado - Dados inválidos")</script>';
				} else { //usuario e senha corretos, registra as variaveis de sessao
					$_SESSION['TIPOUSER'] = 1;
			 		$_SESSION['NOMEUSUARIO'] = $usuario->getLogin();
			 		$_SESSION['ORGANIZACAO'] = (is_object($fachadaSist2->lerOM()))?$fachadaSist2->lerOM()->getNome():'OM não cadastrada';
			 		$_SESSION['OM_VINC'] = $lUsuario->getCodom();
			 		$_SESSION['SIGLA_OM_VINC'] = $siglaOmVinv;
			 		$_SESSION['SUBUN'] = $lUsuario->getCodSubun();
			 		$_SESSION['SIGLA_SUBUN'] = $siglaSubun;
			 		$_SESSION['TODAS_OMVINC'] = $lUsuario->getTodasOmVinc();
			 		$_SESSION['TODAS_SUBUN'] = $lUsuario->getTodasSubun();
			 		$_SESSION['TODAS_OMVINC2'] = $lUsuario->getTodasOmVinc2();
			 		$_SESSION['TODAS_SUBUN2'] = $lUsuario->getTodasSubun2();
			 		$_SESSION['MODIFICA_MODELO'] = $lUsuario->getModificaModelo();
					echo '<script>location.href="menuboletim.php"</script>';
				} //fim do else
			} //fim do else
		}
	}
}
?>
<script type="text/javascript" language="javascript">
	function login(){
		if((document.formLogin.nomeUsuario.value == '')||(document.formLogin.senha.value == '')){
			window.alert("Informe seu nome de usuário e a senha.");
			return;
		}
			document.formLogin.action = "sisbol.php?login=true";
			document.formLogin.submit();
	}

	function capturaTecla(e){
		if(document.all){
			tecla=event.keyCode;
		}
		else
		{
		tecla=e.which;
		}
		if(tecla==13){
			//window.alert("acessei");
			login();
		}
	}

	document.onkeydown = capturaTecla;
</script>
</head>
<body>
<form id="form1" name="formLogin" method="post" action="#" >
  <!--inicio tabela-->
  <div id="tabela" border="0" class="login">
      <div id="linha1">
          <div id="col1linha1">
          <p class="txtversao">Versão 2.5 - jun 2013</p>
          </div>
          <div id="col2linha1">
          <img class="alignlogo" src="./imagens/login_new_3cta.png">
          </div>
      </div>
      <div id="linha2">
          <div id="col1linha2">
              <div id="cxinput">
              <p class="txttit" align="center" id="titulo">Seja Bem-vindo</p>  
                <div class="tit_corpo_input">
                    <div class="tit_input">Login:</div><div class="corpo_input"><input class="campos_input" type="text" name="nomeUsuario" size="26"/></div>
                    <div class="tit_input">Senha:</div><div class="corpo_input"><input class="campos_input" type="password" name="senha" maxlength="16" size="16"/></div>
                    
                    <div id="confSenha" style="visibility:hidden"><div class="tit_input">Confirme:</div><div class="corpo_input"><input class="campos_input" type="password" name="senha1" maxlength="16" size="16"/></div></div>
                <div class="tit_input">Caracteres:</div><div class="corpo_input2"><script type="text/javascript">sjcap();</script></div>
                </div>
              
              </div>
          </div>
          <div id="col2linha2">
          <label>
                <?
			if ($local_senha == null) {
                                echo '<input type="button" class="botao_cadastrar" name="Submit" value="" onclick="administrador()"/>';
				echo '<script>	document.formLogin.nomeUsuario.value="supervisor";';
				echo '			document.formLogin.nomeUsuario.readOnly = true;';
				echo '			document.formLogin.senha.value="";';
				echo '			document.getElementById("titulo").innerHTML = "Cadastro da senha do supervisor";';
				echo '			document.getElementById("confSenha").style.visibility = "visible";</script>';
			} else {
				echo '<input type="button" class="botao_entrar" name="Submit" value="" onclick="login()"/>';
				echo '<input type="reset" class="botao_limpar" name="Submit2" value="" />';
			}
			?>
                </label>
          </div>
      </div>
      
      
    
  <!--fim tabela-->
  <!--table id="tabela" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td valign="top" ><div class="login">
          
            
            <table border="0">
            <tr>
              <td width="600px" height="180">&nbsp;</td>
              <td width="100px"><img src="./imagens/login_new_3cta.png"></td>              
            </tr>  
            </div>
            
              
            <tr>
              <td width="32%" height="135">&nbsp;</td>
              <td width="11%">&nbsp;</td>
              <td width="3%">&nbsp;</td>
              <td width="24%">&nbsp;</td>
              <td height ="30" align="right"><font size="2" color="#FFFFFF"><b>Versão 2.5 - ago 2013</b></font><br>
              </td>
              <td width="4%">&nbsp;</td>
            </tr>
            <tr>
              <td height="38">&nbsp;</td>
              <td height="38" colspan="4"><div align="center" class="style1" id="titulo">Seja Bem-vindo</div></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td height="38">&nbsp;</td>
              <td height="38" class="style3" align="left"><font color="#000000" size="2">Login:</font></td>
              <td height="38" colspan="2"  align="left"><input type="text" name="nomeUsuario"/></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td height="38">&nbsp;</td>
              <td height="38" class="style3" align="left"><font color="#000000" size="2">Senha:</font></td>
              <td height="38" colspan="2"  align="left"><input type="password" name="senha" maxlength="16"  size="14"/></td>
              <td align="left" class="style3"><div id="confSenha" style="visibility:hidden">
              <font color="#000000" size="2">Confirme:</font>
              <input type="password" name="senha1" maxlength="16" size="14"/>
              </div>
              </td>
              <td>&nbsp;</td>
            </tr>
            
            <tr>
              <td height="38">&nbsp;</td>
              <td height="38" class="style3" valign="top" align="right"></td>
              <td height="38" colspan="2">
                <script type="text/javascript">sjcap();</script></td>
              <td></td>
              <td>&nbsp;</td>
            </tr>
            
            <tr>
              <td height="33">&nbsp;</td>
              <td height="33"><div align="center">
                  <label></label>
                </div></td>
              <td height="33">&nbsp;</td>
              <td><label>
                <//?
			if ($local_senha == null) {
				echo '<input type="button" name="Submit" value="Cadastrar" onclick="administrador()"/>';
				echo '<script>	document.formLogin.nomeUsuario.value="supervisor";';
				echo '			document.formLogin.nomeUsuario.readOnly = true;';
				echo '			document.formLogin.senha.value="";';
				echo '			document.getElementById("titulo").innerHTML = "Cadastro da senha do supervisor";';
				echo '			document.getElementById("confSenha").style.visibility = "visible";</script>';
			} else {
				echo '<input type="button" name="Submit" value="Entrar" onclick="login()"/>';
				echo '<input type="reset" name="Submit2" value="Limpar" />';
			}
			?//>
                </label></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
          </table>
        </div></td>
    </tr>
  </table-->
  
</form>
<script type="text/javascript" language="javascript">document.formLogin.nomeUsuario.focus();</script>
<!-- Sisbol 2.5 -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-42446963-1', 'sistemasisbol.com');
  ga('send', 'pageview');

</script>
</body>
</html>
