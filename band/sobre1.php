<?
	session_start();
	require_once('filelist_geral.php');
	$fachadaSist2 = new FachadaSist2();
    $funcoesPermitidas = $fachadaSist2->lerColecaoAutorizada($_SESSION['NOMEUSUARIO'],'X');
	$apresentacao = new Apresentacao($funcoesPermitidas);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<? $apresentacao->chamaEstilo(); ?>
<script type="text/javascript" src="scripts/band.js"></script>
<script type="text/javascript" src="scripts/tabber.js"></script>
<style type="text/css">
	.tabberlive .tabbertab {
 		padding:5px;
 		border:1px solid #006633;
 		border-top:0;
 		background-color: #fff;
	}
	</style>
<title>Cr�ditos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<center>
  <? 	$apresentacao->chamaCabec();
		$apresentacao->montaMenu();
		function sistema($data,$php_versao,$mysql_versao,$so){
			global $apresentacao;
			echo '<B><font face="Candara" size="5">&nbsp;Sistema</font></B>
				<ul><li><B>Sistema:&nbsp;</B><I>Sistema de Boletins e Altera��es</I></li>
				<li><B>Nome do Sistema:&nbsp;</B> <I>SisBol</I></li>
				<li><B>Servidor de P�ginas:&nbsp;</B> <I>Apache</I></li>
				<li><B>PHP vers�o:&nbsp;</B><I>PHP&nbsp;'.$php_versao.'</I></li>
				<li><B>Data:&nbsp;</b><I>'.$data.'</I>
				<li><B>Banco:&nbsp;</B><I>MySQL&nbsp;'.$mysql_versao.'</I> <BR>
				<li><B>Sistema Operacional:&nbsp;</B> <I>'.$so.'</I></li>
				</ul>
				<p align="center"><img src="./imagens/hc_help.png" alt=""></p>';
		}
	?>
  <br>
  <table width="600" border="0">
    <tr>
      <td>&nbsp; <img src="imagens/cta.gif" width="73" height="93" alt=""></td>
      <td align="right" valign="top"><FONT FACE="Cambria" SIZE="4" COLOR="black"><B> 3� Centro de Telem�tica de �rea</B></FONT> <BR>
        <FONT FACE="Calibri" SIZE="3" COLOR="black">Rua da Independ�ncia, 632 - Cambuci</FONT> <BR>
        <FONT FACE="Calibri" SIZE="3" COLOR="black">S�o Paulo (SP)</FONT> <BR>
        <FONT FACE="Calibri" SIZE="3" COLOR="black">Fone (11) 2915-1476 &nbsp&nbsp RITEx 826-1476</FONT> </td>
    </tr>
  </table>
  <table width="700">
    <tr>
      <td><div class="tabber" id="mytab1">
	   <div class="tabbertab" id="Vers�o 2.4">
            <h2>Vers�o 2.4</h2>
            <table width="600" border="0" cellspacing="2" cellpadding="0">
              <tr>
                <td valign="TOP" width="50%"><font size="2">
                  <?=sistema('dezembro de 2012','5.3.x','5.1.x','Windows Xp / Debian 6');?>
                  </font></td>
                <td width="50%" valign="TOP"><B><font face="Candara" size="5">&nbsp;Chefia</font></B>
                  <ul>
                    <li><B>Ch do 3� CTA:&nbsp;</B>Ten Cel Ades </li>
                    <li><B>Ch da Div Tec:&nbsp;</B>1� Ten Dias</li>
                  </ul>
                  <B><font face="Candara" size="5">&nbsp;Equipe</font></B>
                  <ul>
                    <li><B>Programa��o</B>
                    <blockquote>
                      <p>1� Ten Watanabe<br>
                        1&ordm; Ten Raquel<br>
                        1&ordm; Ten Ana Paula<br>
                        2&ordm; Ten S Lopes<br>
                        2&ordm; Sgt Vincenzo<br>
						3&ordm; Sgt Bedin
                        <br>
                      </p>
</blockquote>
                    </li>
                    <li><B>Documenta��o/Help</B>
                    <blockquote>1� Ten Raquel<br>
                    </blockquote></li>
                    <li><B>Design</B>
                    <blockquote>
                      <p>1� Ten Ana Paula<br>
                       </p>
                    </blockquote>
                    </li>
                    <li><B>Testes</B>
                    <blockquote> 
                      <p>1� Ten Ana Paula<br>
                        2� Ten S Lopes <br>
                        2� Sgt Vincenzo <br>
                      Cb Galindo</p>
                      </blockquote>
                    </li>
                  </ul></td>
              </tr>
            </table>
          </div>
          <div class="tabbertab" id="Vers�o 2.3">
            <h2>Vers�o 2.3</h2>
            <table width="600" border="0" cellspacing="2" cellpadding="0">
              <tr>
                <td valign="TOP" width="50%"><font size="2">
                  <?=sistema('julho de 2012','5.3.x','5.1.x','Windows Xp / Debian 6');?>
                  </font></td>
                <td width="50%" valign="TOP"><B><font face="Candara" size="5">&nbsp;Chefia</font></B>
                  <ul>
                    <li><B>Ch do 3� CTA:&nbsp;</B>Ten Cel Ades </li>
                    <li><B>Ch da Div Tec:&nbsp;</B>1� Ten Dias</li>
                  </ul>
                  <B><font face="Candara" size="5">&nbsp;Equipe</font></B>
                  <ul>
                    <li><B>Programa��o</B>
                    <blockquote>
                      <p>1� Ten Watanabe<br>
                        1&ordm; Ten Raquel<br>
                        1&ordm; Ten Ana Paula<br>
                        2&ordm; Ten S Lopes<br>
                        2&ordm; Sgt Vincenzo
                        <br>
                      </p>
</blockquote>
                    </li>
                    <li><B>Documenta��o/Help</B>
                    <blockquote>1� Ten Raquel<br>
                    </blockquote></li>
                    <li><B>Design</B>
                    <blockquote>
                      <p>1� Ten Ana Paula<br>
                        1&ordm; Ten Ruiz
                      </p>
                    </blockquote>
                    </li>
                    <li><B>Testes</B>
                    <blockquote> 
                      <p>1� Ten Ana Paula<br>
                        2� Ten S Lopes <br>
                        2� Sgt Vincenzo <br>
                      Cb Galindo</p>
                      </blockquote>
                    </li>
                  </ul></td>
              </tr>
            </table>
          </div>
          <div class="tabbertab" id="Vers�o 2.2">
            <h2>Vers�o 2.2</h2>
            <table width="600" border="0" cellspacing="2" >
              <tr>
                <td valign="TOP" width="50%"><font size="2">
                  <?=sistema('janeiro de 2011','5.2.x','5.0.x','Windows XP / Debian 5');?>
                  </font></td>
                <td width="50%" valign="TOP"><B><font face="Candara" size="5">&nbsp;Chefia</font></B>
                  <ul>
                    <li><B>Ch do 3� CTA:&nbsp;</B>Ten Cel Freire</li>
                    <li><B>Ch da Div Tec:&nbsp;</B>Maj Mello</li>
                    <li><B>Ch da Sec Sis:&nbsp;</B>1� Ten Dias</li>
                  </ul>
                  <B><font face="Candara" size="5">&nbsp;Equipe</font></B>
                  <ul>
                    <li><B>Programa��o</B>
                    <blockquote>2� Ten Watanabe<br>
                      2� Sgt Renato<br>
                      3� Sgt Vincenzo</blockquote></li>
                    <li><B>Documenta��o/Help</B>
                    <blockquote>1� Ten Alfredo<br>
                      1� Ten Raquel<br>
                      3� Sgt Hermes</blockquote></li
                    ><li><B>Design</B>
                    <blockquote>3� Sgt Sidinei</blockquote></li>
                    <li><B>Testes</B>
                    <blockquote>1� Ten Raquel<br>
                      2� Sgt Renato<br>
                      3� Sgt Vincenzo<br>
                      Sd Miguel</blockquote></li>
                  </ul></td>
              </tr>
            </table>
          </div>
          <div class="tabbertab" id="Vers�o 2.1">
            <h2>Vers�o 2.0/2.1</h2>
            <!--Vers�o 2.0-->
            <table width="600" border="0" cellspacing="2">
              <tr>
                <td valign="TOP" width="50%"><font size="2">
                  <?=sistema('junho de 2010','5.2.x','5.0.x','Windows XP / Debian 5');?>
                  </font></td>
                <td width="50%" valign="TOP"><B><font face="Candara" size="5">&nbsp;Chefia</font></B>
                  <ul>
                    <li><B>Ch do 3� CTA:&nbsp;</B>Ten Cel Freire</li>
                    <li><B>Ch da Div Tec:&nbsp;</B>Maj Mello</li>
                    <li><B>Ch da Sec Sis:&nbsp;</B>1� Ten Dias</li>
                  </ul>
                  <B><font face="Candara" size="5">&nbsp;Equipe</font></B>
                  <ul>
                    <li><B>Programa��o</B>
                    <blockquote>2� Ten Watanabe<br>
                      2� Sgt Renato<br>
                      3� Sgt Vincenzo</blockquote></li>
                    <li><B>Documenta��o/Help</B>
                    <blockquote>1� Ten Alfredo<br>
                      1� Ten Raquel<br>
                      3� Sgt Hermes</blockquote></li>
                    <li><B>Design</B>
                    <blockquote>3� Sgt Sidinei</blockquote></li>
                    <li><B>Testes</B>
                    <blockquote>1� Ten Raquel<br>
                      2� Sgt Renato<br>
                      3� Sgt Vincenzo<br>
                      Sd Miguel</blockquote></li>
                  </ul></td>
              </tr>
            </table>
          </div>
          <div class="tabbertab" id="rev06">
            <h2>Rev 06</h2>
            <!--Revis�o n 06-->
            <table width="600" border="0" cellspacing="2" >
              <tr>
                <td valign="TOP" width="50%"><font size="2">
                  <?=sistema('janeiro de 2009','5.2.x','5.0.x','Windows XP / Debian 5');?>
                  </font></td>
                <td width="50%" valign="TOP"><B><font face="Candara" size="5">&nbsp;Chefia</font></B>
                  <ul>
                    <li><B>Ch do 3� CTA:&nbsp;</B>Ten Cel Betat</li>
                    <li><B>Ch da Div Tec/Sistemas:&nbsp;</B>Maj Roberto</li>
                  </ul>
                  <B><font face="Candara" size="5">&nbsp;Equipe</font></B>
                  <ul>
                    <li><B>Programa��o</B>
                    <blockquote>ST Watanabe<br>
                      2� Sgt Renato</blockquote></li>
                    <li><B>Documenta��o</B>
                    <blockquote>2� Ten Alfredo<br>
                      Sgt Louren�o</blockquote></li>
                    <li><B>Design</B>
                    <blockquote>3� Sgt Sidinei<br>
                      Cb Hermes</blockquote></li>
                    <li><B>Testes</B>
                    <blockquote>3� Sgt S. Lopes<br>
                      Sd Miguel</blockquote></li>
                  </ul></td>
              </tr>
            </table>
          </div>
          <div class="tabbertab" id="rev05">
            <h2>Rev 05</h2>
            <!--Revis�o n 05-->
            <table width="600" border="0" cellspacing="2" >
              <tr>
                <td valign="TOP" width="50%"><font size="2">
                  <?=sistema('junho de 2008','5.2.x','5.0.x','Windows XP / Debian 5');?>
                  </font></td>
                <td width="50%" valign="TOP"><B><font face="Candara" size="5">&nbsp;Chefia</font></B>
                  <ul>
                    <li><B>Ch do 3� CTA:&nbsp;</B>Ten Cel Betat</li>
                    <li><B>Ch da Div Tec/Sistemas:&nbsp;</B>Maj Roberto</li>
                  </ul>
                  <B><font face="Candara" size="5">&nbsp;Equipe</font></B>
                  <ul>
                    <li><B>Programa��o</B>
                    <blockquote>ST Watanabe<br>
                      2� Sgt Renato</blockquote></li>
                    <li><B>Documenta��o</B>
                    <blockquote>2� Ten Alfredo<br>
                      Sgt Louren�o</blockquote></li>
                    <li><B>Design</B>
                    <blockquote>3� Sgt Sidinei<br>
                      Cb Hermes</blockquote></li>
                    <li><B>Testes</B>
                    <blockquote>Sd Miguel</blockquote></li>
                  </ul></td>
              </tr>
            </table>
          </div>
          <div class="tabbertab" id="rev04">
            <h2>Rev 04</h2>
            <!--Revis�o n 04-->
            <table width="600" border="0" cellspacing="2">
              <tr>
                <td valign="TOP" width="50%"><font size="2">
                  <?=sistema('dezembro de 2007','5.2.x','5.0.x','Windows XP / Debian 5');?>
                  </font></td>
                <td width="50%" valign="TOP"><B><font face="Candara" size="5">&nbsp;Chefia</font></B>
                  <ul>
                    <li><B>Ch do 3� CTA:&nbsp;</B>Ten Cel Betat</li>
                    <li><B>Ch da Div Tec/Sistemas:&nbsp;</B>Maj Roberto</li>
                  </ul>
                  <B><font face="Candara" size="5">&nbsp;Equipe</font></B>
                  <ul>
                    <li><B>Programa��o</B>
                    <blockquote>ST Watanabe<br>
                      2� Sgt Renato</blockquote></li>
                    <li><B>Documenta��o</B>
                    <blockquote>2� Ten Alfredo<br>
                      Sgt Louren�o</blockquote></li>
                    <li><B>Design</B>
                    <blockquote>3� Sgt Sidinei<br>
                      Cb Hermes</blockquote></li>
                    <li><B>Testes</B>
                    <blockquote>Sd Miguel</blockquote></li>
                  </ul></td>
              </tr>
            </table>
          </div>
          <div class="tabbertab" id="rev03">
            <h2>Rev 03, 02 e 01</h2>
            <!--Revis�o n 03,2,1-->
            <table width="600" border="0" cellspacing="2" >
              <tr>
                <td valign="TOP" width="50%"><font size="2">
                  <?=sistema('junho de 2007','5.2.x','5.0.x','Windows XP / Debian 5');?>
                  </font></td>
                <td width="50%" valign="TOP"><B><font face="Candara" size="5">&nbsp;Chefia</font></B>
                  <ul>
                    <li><B>Ch do 3� CTA:&nbsp;</B>Ten Cel Rufino</li>
                    <li><B>Ch da Div Tec:&nbsp;</B>Ten Cel Mignac</li>
                    <li><B>Ch Sec Sis:&nbsp;</B>Maj Roberto</li>
                  </ul>
                  <B><font face="Candara" size="5">&nbsp;Equipe</font></B>
                  <ul>
                    <li><B>Programa��o</B>
                    <blockquote>Cap Marco<br>
                      ST Watanabe<br>
                      1� Sgt Nataniel<br>
                      2� Sgt Renato</blockquote></li>
                    <li><B>Documenta��o</B>
                    <blockquote>1� Ten Glaucemara<br>
                      2� Ten Alfredo</blockquote></li>
                    <li><B>Design</B>
                    <blockquote>3� Sgt Sidinei<br>
                      Cb Hermes</blockquote></li>
                    <li><B>Testes</B>
                    <blockquote>1� Sgt De Paula</blockquote></li>
                  </ul></td>
              </tr>
            </table>
          </div>
        </div></td>
    </tr>
  </table>
</center>
</body>
</html>
