<? 	session_start();
	require_once('./filelist_geral.php');
	require_once('./filelist_om.php');
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
	<script type="text/javascript">
	function executa(acao){
		document.cadOM.executar.value = acao;
		document.cadOM.action = "cadom.php";
		document.cadOM.submit();
	}
	function mudaStatus(op){
		document.cadOM.cod.readOnly = op;
		document.cadOM.codom.readOnly = op;
  		document.cadOM.sigla.readOnly = op;
		document.cadOM.ano.readOnly = op;
  		document.cadOM.nome.readOnly = op;
		document.cadOM.desig.readOnly = op;
		document.cadOM.loc.readOnly = op;
		document.cadOM.subd1.readOnly = op;
		document.cadOM.subd2.readOnly = op;
		document.cadOM.subd3.readOnly = op;
                document.cadOM.subd4.readOnly = op;                
		document.cadOM.gu.readOnly = op;
	}
	</script>
</head>
<body><center>
	<? 	$apresentacao->chamaCabec();
		$apresentacao->montaMenu();

		if (isset($_POST['executar'])){
  			$OM = new OM();
        	$OM->setCodigo($_POST['cod']);
			$OM->setCodOM($_POST['codom']);
        	$OM->setNome($_POST['nome']);
			$OM->setSigla($_POST['sigla']);
			$OM->setDesigHist($_POST['desig']);
			$OM->setLoc($_POST['loc']);
			$OM->setSubd1($_POST['subd1']);
			$OM->setSubd2($_POST['subd2']);
			$OM->setSubd3($_POST['subd3']);
                        $OM->setSubd4($_POST['subd4']);
			$OM->setAnoCorrente($_POST['ano']);
			$OM->setGu($_POST['gu']);

			if ($_POST['executar'] == 'Incluir'){
				$fachadaSist2->incluirOM($OM);
			}
			if ($_POST['executar'] == 'Excluir'){
				$fachadaSist2->excluirOM($OM);
			}
			if ($_POST['executar'] == 'Alterar'){
				$fachadaSist2->alterarOM($OM);
			}
			$_SESSION['ORGANIZACAO'] = $OM->getNome();
			echo "<script>window.alert('Operação realizada com sucesso!');</script>";
			
		}

		/*Verificar se existe uma OM cadastrada. O sistema permite apenas o cadastramento
		  de uma OM. Pode futuramente permitir a inclusão de outras via novas implementações*/
		$colOM2 = $fachadaSist2->lerColecaoOM('sigla');
  		$OM = $colOM2->iniciaBusca1();
  		echo '<script type="text/javascript">function carregaForm(){';
  		if ($OM != null){
  			echo '
  			document.cadOM.cod.value 	= "'.$OM->getCodigo().'";
  			document.cadOM.codom.value 	= "'.$OM->getCodOM().'";
  			document.cadOM.sigla.value 	= "'.$OM->getSigla().'";
			document.cadOM.ano.value 	= "'.$OM->getAnoCorrente().'";
  			document.cadOM.nome.value 	= "'.$OM->getNome().'";
			document.cadOM.desig.value 	= "'.$OM->getDesigHist().'";
			document.cadOM.loc.value 	= "'.$OM->getLoc().'";
			document.cadOM.subd1.value 	= "'.$OM->getSubd1().'";
			document.cadOM.subd2.value 	= "'.$OM->getSubd2().'";
			document.cadOM.subd3.value 	= "'.$OM->getSubd3().'";
                        document.cadOM.subd4.value 	= "'.$OM->getSubd4().'";
                        document.cadOM.gu.value 	= "'.$OM->getGu().'";
  			document.cadOM.acao.value = "Alterar";';
  		} else {
  			echo '
  			document.cadOM.cod.value 	= "1";
  			document.cadOM.acao.value = "Incluir";';
  		}
  		echo '}</script>';
	?>

	<h3 class="titulo">&nbsp;&nbsp;<img src="./imagens/item_dir.gif" alt="">&nbsp;Cadastro de OM </h3>

	<form  method="post" name="cadOM" action="">
	  <input name="cod" type="hidden" value="1">
		<input name="executar" type="hidden" value="">
		<table width="460px"  border="0" cellspacing="0" class="lista"><tr><td>
		<table width="100%" border="0" cellspacing="0" cellpadding="3"  class="lista">
		<TR CLASS="cabec">
			<TD colspan="4"><div><font size="2"><b>Organização Militar - Cadastro</b></font></div></TD>

		</TR><TR>
			<TD BGCOLOR="#EAE4D5">&nbsp;&nbsp;</TD>
			<TD BGCOLOR="#EAE4D5">
				<label for="codom" title="Informe o código da OM">Codom:(*)</label><br/>
				<input name="codom" size="12" maxlength="10">
			</TD><TD BGCOLOR="#EAE4D5">
				<label for="sigla" title="Informe a sigla da OM">Sigla:(*)</label><br/>
				<input name="sigla" size="35" maxlength="30">
			</TD><TD BGCOLOR="#EAE4D5">
				<label for="ano" title="Informe a sigla da OM">Ano:(*)</label><br/>
				<input name="ano" size="5" maxlength="4">
			</TD></TR>
		<TR bgcolor="#EAE4D5">
			<TD>&nbsp;</TD>
			<TD COLSPAN = "3">
			Nome:(*)<br>
                        Ex.: Texto em caixa alta.<br>
			<input name="nome" size="80" maxlength="70"><br>
		</TR><TR bgcolor="#EAE4D5">
			<TD>&nbsp;</TD>
			<TD COLSPAN = "3">
			Localização:(*)<br>
			<input name="loc" size="80" maxlength="70"><br>
		</TR><TR bgcolor="#EAE4D5">
			<TD>&nbsp;</TD>
			<TD COLSPAN = "3">
			Subordinação 1:<br>
                        Ex.: Texto em caixa alta.<br>
			<input name="subd1" size="80" maxlength="70"><br>
		</TR><TR bgcolor="#EAE4D5">
			<TD>&nbsp;</TD>
			<TD COLSPAN = "3">
			Subordinação 2:<br>
                        Ex.: Texto em caixa alta.<br>
			<input name="subd2" size="80" maxlength="70"><br>
		</TR><TR bgcolor="#EAE4D5">
			<TD>&nbsp;</TD>
			<TD COLSPAN = "3">
			Subordinação 3:<br>
			<input name="subd3" size="80" maxlength="70"><br>
		</TR><TR bgcolor="#EAE4D5">
			<TD>&nbsp;</TD>
			<TD COLSPAN = "3">
			Numeração Histórica:<br>
                        Ex.: (5º Batalhão de Engenharia/1908)<br>
			<input name="desig" size="80" maxlength="70"><br>
</TR><TR bgcolor="#EAE4D5">
           	  <TD>&nbsp;</TD>
			<TD COLSPAN = "3">
			Denominação Histórica:<br>
                        Ex.: Texto em caixa alta.<br>
			<input name="subd4" size="80" maxlength="70"><br>
</TR><TR bgcolor="#EAE4D5">
              <TD>&nbsp;</TD>
			<TD COLSPAN = "3">
			Guarnição:(*)<br>
			<input name="gu" size="45" maxlength="40"><br>
			</TD>
		</TR><TR>
			<TD BGCOLOR="#EAE4D5" colspan="3" align="left">
			<font size="1">(*) Campos de preenchimento obrigatório&nbsp;</font></TD>
			<TD BGCOLOR="#EAE4D5">

            <?
			//verifica permissao para alterar
            if ($_SESSION['NOMEUSUARIO'] != 'supervisor')
            { $mAlterar = $funcoesPermitidas->lerRegistro(1062);
            }
            if (($mAlterar != null) or ($_SESSION['NOMEUSUARIO'] == 'supervisor'))
		    { echo '<input name="acao" type="button" value="Incluir" onclick="executa(this.value)">';
			}else{
				echo '<script>document.cadOM.cod.readOnly = true;
					 		  document.cadOM.codom.readOnly = true;
							  document.cadOM.sigla.readOnly = true;
							  document.cadOM.ano.readOnly = true;
							  document.cadOM.nome.readOnly = true;
							  document.cadOM.desig.readOnly = true;
							  document.cadOM.loc.readOnly = true;
							  document.cadOM.subd1.readOnly = true;
							  document.cadOM.subd2.readOnly = true;
							  document.cadOM.subd3.readOnly = true;
                                                          document.cadOM.subd4.readOnly = true;
                                                          document.cadOM.gu.readOnly = true;
							  document.cadOM.gu.readOnly = true;
		   			  </script>';
			}
			?>

			</TD>
			<!--<input name="cancela" type="button" value="Cancelar" ><TD>-->
		</TR></TABLE>
		</TD></TR></TABLE></TABLE>
	</form>
	<script type="text/javascript">javascript:carregaForm();</script>
</center>
</body>
</html>
