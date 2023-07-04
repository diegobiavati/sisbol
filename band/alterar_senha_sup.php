<? 	session_start(); 
	require_once('filelist_geral.php');
	$fachadaSist2 = new FachadaSist2();
    $funcoesPermitidas = $fachadaSist2->lerColecaoAutorizada($_SESSION['NOMEUSUARIO'], 'X');	
	$apresentacao = new Apresentacao($funcoesPermitidas);
	
	if (isset($_GET['reinicializar'])) {
		//Alterado por Ten S.Lopes -- 16/04/2012 -- código anterior "$iniFile = new IniFile('..\..\supervisor.ini');"
		$iniFile = new IniFile('..\..\supervisor.ini');
		$supIniFile  = new SupIniFile($iniFile);
		$supIniFile->apagarchave('zerar');
		echo '<script>window.alert("Senha do usuário \"supervisor\" zerada com sucesso!!!")
			  		  window.location.href="sisbol.php"
	       	  </script>';	
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SisBol</title>
<? $apresentacao->chamaEstilo(); ?>
<script type="text/javascript" src="scripts/band.js"></script>
<script type="text/javascript">
	
	function reinicializa() {
		var resposta = window.confirm("Deseja reinicializar a senha do usuário \"supervisor\"?");
		if (resposta) {
				window.location.href = "alterar_senha_sup.php?reinicializar=true";
		}
		if (!resposta) {
			cancelar();
		}
	}
	
	function cancelar() {
		window.alert('Operação cancelada.');
		window.location.href = "menuboletim.php";
	}
		
	</script>
</head>
<body>
<center>
<? 	$apresentacao->chamaCabec();
		$apresentacao->montaMenu();
	?>
<h3 class="titulo">&nbsp;&nbsp;<img src="./imagens/item_dir.gif" alt="">&nbsp;Reinicializar a Senha do Supervisor</h3>
<TABLE width="500px" bgcolor="yellow" border="1"  cellspacing="0">
  <TR>
    <TD><TABLE width="100%" border="0"CELLSPACING="0" style="name:tabela;">
        <TR>
          <TD><font face="Cambria" size="4"><B> &nbsp;<img src="imagens/atencao.png" width="16" height="16"> Aten&ccedil;&atilde;o</B></font></TD>
        </TR>
        <TR>
          <TD  BGCOLOR="#FFFFEA"><FONT face="Constantia" SIZE="2"> <br>
            <center>
              <b>&nbsp;&nbsp;Esta op&ccedil;&atilde;o vai excluir a senha atual do usu&aacute;rio:</b><br>
              <FONT SIZE="+2" COLOR="#006633">"supervisor"</FONT> <br>
              <br>
              <b> &nbsp;Antes de executar, saiba que:</b>
              <ul>
                <li> Esta op&ccedil;&atilde;o vai apagar a senha atual do usuário "supervisor";</li>
                <li> Ap&oacute;s confirmar, o sistema apresentar&aacute; a tela de login solicitando o cadastramento de uma 
                  nova senha para o usuário "supervisor";</li>
                <li> Caso tenha d&uacute;vidas consulte o manual antes de executar.</li>
              </ul>
            </center>
            </FONT></TD>
        </TR>
        <TR>
          <TD  align="center" BGCOLOR="#FFFFEA"><input type="button" value="  Cancelar  " onClick="cancelar()">
            <input type="button" value="Reinicializar" onClick="reinicializa()"></TD>
        </TR>
      </TABLE></TD>
  </TR>
</table>
</center>
</body>
</html>
