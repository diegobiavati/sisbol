<html>
<head>
<title>Gera��o de Banco</title>
<body>
 <?php
/*
 * Created on 08/02/2008
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
require_once('./filelist_geral.php');
$configuracao = new Configuracao();

function dropBanco($query){
	global $configuracao;
	$link = $configuracao->verificaConexao();
	$link->query($query);
	if($link){
		echo '<BR><font size="3"> Opera��o cancelada </font>';
		$msg = chr(13).'<script>window.alert("Ocorreu um erro na gera��o do Banco de Dados.\nA opera��o foi cancelada.")</script></body><html>';
	} else {
		echo '<br>- N�o foi cancelar a opera��o.';
		$msg = chr(13).'<script>window.alert("Ocorreu um erro na gera��o do Banco de Dados.\nN�o foi poss�vel cancelar a opera��o.")</script></body><html>';
	}
	echo chr(13).'<a name="fimPag"><script>window.location.href="#fimPag";</script></body></html>';
	die($msg);
}
function fimPag(){
	 //echo '<script>window.location.href="#fimPag";</script>';
	 echo chr(13).'<a name="fimPag"><script>window.location.href="#fimPag";' .
	 		'window.alert("Banco gerado com sucesso.");</script></body></html>';
}

if ($_GET["opcao"] == "gerarBanco"){
	$nomeBanco = $configuracao->getNomeBanco();
	echo '<table width="750"><tr><td width="10%"><img src="./imagens/hc_help.png" widht="90" height="180"></td>';
	echo '<td width="90%" align="left"><font size="4"><b>Relat&oacute;rio de Gera&ccedil;&atilde;o do Banco: '.$nomeBanco.'</b></font>';
	echo '<br><br><br><b><u>Legenda:</u></b><br>';
	echo '<img src="./imagens/check.gif" height="20" width="20"> - Executado';
	echo ' <img src="./imagens/naprovada.png" height="20" width="20"> - Falhou';
	echo '</td></tr></table>';

	echo chr(13).'<ol type="I">';
	/* Verificar se h� conex�o com o Banco MySQL*/
	echo chr(13).'<li>Verificar Conex�o com o MySql:&nbsp;';
	$banco = $configuracao->verificaConexao();
	if($banco){
		echo chr(13).'<img src="./imagens/check.gif" height="20" width="20">';
	} else {
		echo chr(13).'<img src="./imagens/naprovada.png" height="20" width="20">';
		echo chr(13).'<br><font color="red">- N�o foi poss�vel fazer a conex�o com o MySQL. Verifique se o MySql est&aacute; ' .
				'ativo e se as configura��es do sisbol.ini est�o corretas.</font>';
		die('</body><html>');
	}

	/* Busca o arquivo de configura��o, normalmente instalado dois diret�rios acima da aplica��o /band */
	echo chr(13).'<li>Buscar Arquivo de Configura��o:&nbsp;';
	$arquivo = '../../geradb.sql';
	if (file_exists($arquivo)){
		echo chr(13).'<img src="./imagens/check.gif" height="20" width="20">';
	} else {
		echo chr(13).'<img src="./imagens/naprovada.png" height="20" width="20">';
		echo '<br><font color="red">- Arquivo: <b>'.$arquivo.'</b> n�o encontrado no diret�rio padr�o da aplica��o.</font>';
		die('</body><html>');
	}

	/* Tenta criar o banco de dados da aplica��o especificado no item database do arquivo sisbol.ini*/
	echo chr(13).'<li>Cria��o do Banco:&nbsp;';
	$link = $configuracao->verificaConexao();
	$link->autocommit(FALSE);
	$criaBanco = "create database ".$nomeBanco." DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci";
	if ($link->query($criaBanco) === TRUE) {
   		echo chr(13).'<img src="./imagens/check.gif" height="20" width="20"></font>';
	} else {
		echo chr(13).'<img src="./imagens/naprovada.png" height="20" width="20">';
		echo chr(13).'<br><font color="red">- N�o foi poss�vel criar o banco <b>'.$nomeBanco."</b>.";
		echo ' &Eacute; poss&iacute;vel que este j&aacute; tenha sido criado.</font>';
		/* Rollback */
		$link->rollback();
		$link->close();
		die('</body><html>');
	}
	/* commit insert */
	$link->commit();
	$link->close();
	// 	Conectar-se ao Banco CTA
	$link = $configuracao->getConexaoCTA();

	echo chr(13).'<li>Gerar Objetos do Banco:';
	echo chr(13).'<ol>';
	$lines = file($arquivo,FILE_IGNORE_NEW_LINES);
	$j = 1;
	for ($i = 0; $i < count($lines); $i++){
       	$texto .= trim($lines[$i]);
       	if (strpos($lines[$i], ";")){
        	$query[$j] = trim(str_replace(";","",$texto));
   	    	echo chr(13).'<li>'.trim(str_replace(";","",$texto))."&nbsp;";
   	       	if ($link->query($query[$j]) === TRUE) {
   				echo chr(13).'<img src="./imagens/check.gif" height="20" width="20"><br><br>';
			} else {
				echo chr(13).'<img src="./imagens/naprovada.png" height="20" width="20">';
				echo chr(13).'<br><font color="red">- N�o foi poss�vel criar o o objeto acima.'.chr(13).'<br> -> Erro: '.$link->error.'</font>'.chr(13);
				dropBanco("drop database ".$configuracao->getNomeBanco());
			}
   	    	$texto = "";
       		$j++;
		}
	}
	echo '</ol></ol></font>';
}
fimPag();
?>
