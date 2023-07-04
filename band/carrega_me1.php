<?
session_start();
require_once ('./filelist_geral.php');
require_once ('./filelist_boletim.php');
require_once ('./filelist_assunto.php');
require_once ('./filelist_militar.php');
require_once ('./filelist_pgrad.php');
require_once ('./filelist_qm.php');
require_once ('./filelist_funcao.php');
require_once ('./filelist_om.php');
require_once ('./filelist_tipodoc.php');
$fachadaSist2 		= new FachadaSist2();
$funcoesPermitidas 	= $fachadaSist2->lerColecaoAutorizada($_SESSION['NOMEUSUARIO'], 'X');
$apresentacao 		= new Apresentacao($funcoesPermitidas);
$funcao_cod 		= $_POST['funcao_cod'];
$om_vinc 			= $_POST['om_vinc'];
$codSubun 			= $_POST['sele_subun'];

?>

<html>
<head>
	<? $apresentacao->chamaEstilo(); ?>
	<script src="scripts/band.js"></script>
</head>

<body><center>
<?
$apresentacao->chamaCabec();
$apresentacao->montaMenu();
?>
<h3 class="titulo">&nbsp;&nbsp;<img src="./imagens/item_dir.gif">&nbsp;Carregando Dados do Módulo E1</h3>

<?
$iniFile = new IniFile('sisbol.ini');
$bandIniFile = new BandIniFile($iniFile);
$uploaddir = $bandIniFile->getImportDir();
$namefile = $_FILES['userfile']['name'];
$uploadfile = $uploaddir . $namefile;

//PARREIRA 28-05-2013 - valida campos necessários para importação E1
if (($om_vinc === "999999") or ($codSubun === "99") or ($codSubun === "")) {
	echo "<script>
            
				window.alert('Cadastre uma OM de Vinculação.')
				window.location.href='importme1.php';
              </script>";
}
print "</pre>";
if (($codSubun === "99") or ($codSubun === "")) {
	echo "<script>
            
				window.alert('Cadastre uma Subunidade/Divisão/Seção.')
				window.location.href='importme1.php';
              </script>";
}
print "</pre>";
//FIM PARREIRA
if (($namefile !== "e1_sisbol.txt") and (substr($namefile, 0, 2) !== "SB")) {
	echo "<script>
				window.alert('O arquivo não tem o nome esperado. Consulte o Manual.')
				window.location.href='importme1.php';
			 </script>";
}
print "<pre>";
if (!move_uploaded_file($_FILES['userfile']['tmp_name'], $uploaddir . $_FILES['userfile']['name'])) {
	echo "<script>
				window.alert('Ocorreu um erro inesperado com a carga do arquivo.\n Verifique se o arquivo é válido e tente outra vez .')
				window.location.href='importme1.php';
			 </script>";
}
print "</pre>";

?>
<B>Legenda:</B>&nbsp;<img src='./imagens/check.gif'>Carregado com Sucesso&nbsp;&nbsp;<img src='./imagens/excluir.gif'>Não Carregou
<table width="750" border="0" cellspacing="0" cellppading="0" class="lista"><tr><td>
	<table width="100%" border="0" cellspacing="1" cellpadding="0">
	<tr class="cabec">
	<td><font size="2">Ord</font></td>
	<td><font size="2">IDT/RA</font></td>
	<td><font size="2">Nome</font></td>
	<td><font size="2">N. Guerra</font></td>
	<td><font size="2">OK ?</font></td>
	<td><font size="2">Motivo</font></td>
	</td></tr>
<?
if (file_exists($uploadfile)) {
	$vetor = file($uploadfile);
	$numerolinhas = count($vetor);
	for ($i = 0; $i < $numerolinhas; $i++) {
		echo '<tr bgcolor="#F5F5F5">';
		$line = explode(';', $vetor[$i]);
		echo '<td width="5">' . ($i +1) . '</td>';
		echo '<td>' . $line[0] . '</td>';
		echo '<td>' . $line[1] . '</td>';
		echo '<td>' . $line[2] . '</td>';
		echo '<td align="center">' .
//							IDT(*)		 NOME(*)		GUERRA(*)		PGRAD(*)		   QM(*)		CPF													
		incluiMilitar(trim($line[0]), trim($line[1]), trim($line[2]), trim($line[3]), trim($line[6]), trim($line[16]), 
//						PISPASEP		PREC-CP			  CP				DT-NASC(*)			PAI				MAE				 		
					  trim($line[17]), trim($line[23]), trim($line[24]), trim($line[31]), trim($line[32]), trim($line[33]),
//						SEXO	    	TIPO-SANG			FATOR-RH		COMPORT(*)		ESTADO-CIVIL	
					  trim($line[38]), trim($line[39]), trim($line[40]), trim($line[42]), trim($line[43]), 0, $funcao_cod, 
					  $om_vinc,$codSubun) .
		'</td>';
		//die(print_r($line));
		echo '</tr>';
	}
	echo "<script>window.alert('Importação concluída! Verifique se todos os registros foram importados com sucesso.');</script>";
}
// tentar incluir os dados da pessoa
function incluiMilitar($id_militar, $nome, $nome_guerra, $pgrad, $qm, $cpf, $pispasep, $preccp, $cp, $dtnascimento, $pai, $mae, $sexo, $sangue, $rh, $comportamento, $estadocivil, $antiguidade, $funcao_cod, $om_vinc,$codSubun) {
	global $fachadaSist2;
	// Verificar se o militar já não está cadastrado
	$Militar = $fachadaSist2->lerMilitar($id_militar);
	//return 'pgrad '.$pgrad;
	if (isset ($Militar)) {
		return "<img src='./imagens/excluir.gif'></td><td>Já cadastrado.";
	}
	// Tratar os campos que podem ser null no ME1
	$comportamento = ($comportamento == '') ? 0 : $comportamento;
	$pgrad = ($pgrad == '') ? '99' : $pgrad;
	$qm = ($qm == '') ? '0000' : $qm;
	$antiguidade = ($antiguidade == '') ? 0 : $antiguidade;

	// Tratar domínios
	switch ($sangue) {
		case 1 :
			$sangue = 'A';
			break;
		case 2 :
			$sangue = 'B';
			break;
		case 3 :
			$sangue = 'AB';
			break;
		case 4 :
			$sangue = 'O';
			break;
		default :
			$sangue = 'NN';
	}

	//	return $comportamento.$pgrad;
	//Buscando a data de nascimento;
	$estado_civil = "";
	$dataNasc = trim($dtnascimento);
	$dataNasc = explode("/", $dataNasc);
	$ano = explode(" ", $dataNasc[2]);
	$ano = $ano[0];
	$dataNasc = $ano . "-" . $dataNasc[1] . '-' . $dataNasc[0];

	$dataIdt = null;

	$PGrad = $fachadaSist2->lerPGrad($pgrad);
	$QM = $fachadaSist2->lerQM($qm);

	$Funcao = $fachadaSist2->lerFuncao($funcao_cod);
	$OmVinc = $fachadaSist2->lerOMVinc($om_vinc);
        $subun = $fachadaSist2->lerSubun($om_vinc, $codSubun);

	$Militar = new Militar($PGrad, $QM, $Funcao, new MinhaData($dataNasc), $OmVinc, $subun);
	$Militar->setIdMilitar($id_militar);
	$Militar->setIdtMilitar($id_militar); // Rv 05
	$Militar->setNome(str_replace("'", " ", $nome));
	$Militar->setDataNasc($dataNasc);
	$Militar->setNomePai(str_replace("'", " ", $pai));
	$Militar->setNomeMae(str_replace("'", " ", $mae));
	$Militar->setCPF($cpf);
	$Militar->setPisPasep($pispasep);
	$Militar->setSexo($sexo);
	$Militar->setCP($cp);
	$Militar->setPrecCP($preccp);
	$Militar->setNomeGuerra(str_replace("'", " ", $nome_guerra));
	$Militar->setPermPubBI('S');
	$Militar->setCutis(null);
	$Militar->setOlhos(null);
	$Militar->setCabelos(null);
	$Militar->setBarba(null);
	$Militar->setAltura(null);
	$Militar->setSinaisParticulares('NT');
	$Militar->setTipoSang($sangue);
	$Militar->setFatorRH($rh);
	$Militar->setComportamento($comportamento);
	$Militar->setAntiguidade($antiguidade);
	$Militar->setNaturalidade(null);
	$Militar->setEstadoCivil($estado_civil);
	$Militar->setDataIdt($dataIdt);
	$Militar->setBigode(null);
	$Militar->setOutros(null);
	if ($fachadaSist2->incluirMilitarME1($Militar)) {
		return "<img src='./imagens/check.gif'></td><td>Sucesso</td>";
	} else {
		return "<img src='./imagens/excluir.gif'></td><td>Falhou.</td>";
	}
}
?>
	</table></table>

</body>
</html>
