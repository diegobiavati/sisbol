<? 	session_start(); 
	require_once('filelist_geral.php');
	require_once('./filelist_om.php');
	require_once('./filelist_boletim.php');
	$fachadaSist2 = new FachadaSist2();
    $funcoesPermitidas = $fachadaSist2->lerColecaoAutorizada($_SESSION['NOMEUSUARIO'], 'X');	
	$apresentacao = new Apresentacao($funcoesPermitidas);
 
	if (isset($_GET['encerrar'])) {           
            
                        
                        
                // PARREIRA 10-06-2013 - Mensagem correta e validação agora no cololetim.php
		$fachadaSist2->encerrarAno();
		/*echo ('<script type="text/javascript"> 
					window.alert("Ano encerrado com sucesso!!!")
					window.location.href="menuboletim.php"
		       </script>');*/
                        }
	
        
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SisBol</title>
<? $apresentacao->chamaEstilo();                 
?>



<script type="text/javascript" src="scripts/band.js"></script>
<script type="text/javascript">
    
	
	function encerraAno() {                
		var resposta = window.confirm("Deseja encerrar o presente ano?");
		if (resposta) {
			resposta = window.confirm("Já realizou o backup?");
			if (resposta) {
				window.location.href = "encerrarano.php?encerrar=true";
			} 
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
<h3 class="titulo">&nbsp;&nbsp;<img src="./imagens/item_dir.gif" alt="">&nbsp;Encerra Ano</h3>
<TABLE width="500" bgcolor="yellow" border="1"  cellspacing="0">
  <TR>
    <TD><TABLE width="100%" border="0" CELLSPACING="0"  style="name:tabela;">
        <TR>
          <TD><font face="Cambria" size="4"><B><img src="imagens/atencao.png" width="16" height="16"> Aten&ccedil;&atilde;o</B></font></TD>
        </TR>
        <TR>
          <TD  BGCOLOR="white"><FONT face ="Constantia" SIZE="2"> <br>
            <b>&nbsp;&nbsp;Esta op&ccedil;&atilde;o deve ser utilizada quando do in&iacute;cio de um novo
            ano. Antes de executar, saiba que:</b>
            <ul>
              <li> Esta op&ccedil;&atilde;o vai zerar a numera&ccedil;&atilde;o de Boletins bem como
                os n&uacute;meros de p&aacute;ginas.</li>
              <li> &Eacute; uma opera&ccedil;&atilde;o irrevers&iacute;vel;</li>
              <li> Realize um backup antes de executar, caso ainda n&atilde;o tenha feito;</li>
              <li> Verifique se não há BI em aberto.</li>
              <li> Caso tenha d&uacute;vidas consulte o manual antes de executar.</li>
               
            </ul>
            </FONT> </TD>
        </TR>
        <TR>
          <TD  align="center" BGCOLOR="white"><input type="button" value="  Cancelar  " onClick="cancelar()">
            <input type="button" value="Encerrar ano" onClick="encerraAno()"></TD>
        </TR>
      </TABLE></TD>
  </TR>
</TABLE>




</center>
</body>
</html>
