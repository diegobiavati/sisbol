<? 	session_start(); 
	require_once('filelist_geral.php');
	require_once('filelist_boletim.php');
	require_once('filelist_usuariofuncaotipobol.php');
	require_once('./classes/fpdf/fpdf.php');
	require_once('./classes/meupdflistas/meupdflistas.php');
	$fachadaSist2 = new FachadaSist2();
    $funcoesPermitidas = $fachadaSist2->lerColecaoAutorizada($_SESSION['NOMEUSUARIO'],'X');	
	$apresentacao = new Apresentacao($funcoesPermitidas);

    //PREPARA PARA GERAR O PDF
   //define("FPDF_FONTPATH","C:/Arquivos de programas/VertrigoServ/www/band/classes/fpdf/font/");
    define("FPDF_FONTPATH",$fachadaSist2->getFPDFFontDir());
	$tabela = array(array(1,'Usuários do Sistema',80),
					array(2,'Funcões autorizadas',100),
					array(3,'Tipo de Boletim',80)
					);
    $pdf = new MeuPDFListas('L','mm','A4','Relatório das Permissões do Sistema (por Usuário)',$tabela); 
    $pdf->SetMargins(20,20,15);
    $pdf->AddPage();
    $pdf->SetFont('Times','B',12);

	//monta a coleção dos usuários do sistema cadastradas
	$colUsuario = $fachadaSist2->lerColecaoUsuario();
	$qteUsuarios = $colUsuario->getQTD();
	$usuario = $colUsuario->iniciaBusca1();

	$ord = 0;
	while ($usuario != null){
		$ord++;
		//monta uma coleção com as funções autorizadas para o usuário atual
		$colAutorizadaPorUsuario = $fachadaSist2->lerColecaoAutorizada($usuario->getLogin(), 'X');
		$funcaoAutorizada = $colAutorizadaPorUsuario->iniciaBusca1();
		$qteFuncoesAutorizadas = $colAutorizadaPorUsuario->getQTD();
		$ord2 = 0;
		$pdf->SetFont('Times','',12);
    	if ($funcaoAutorizada != null)
			if (($pdf->GetY() > 180) and ($pdf->GetY() <> 189))
				$pdf->Cell(80,5,$usuario->getLogin(),1,0,'L');
			else
				$pdf->Cell(80,5,$usuario->getLogin(),"LTR",0,'L');
    	else{
			if (($pdf->GetY() > 180) and ($pdf->GetY() <> 189))
				$pdf->Cell(80,5,$usuario->getLogin(),1,0,'L');
			else
				$pdf->Cell(80,5,$usuario->getLogin(),"LTR",0,'L');
	    	$pdf->Cell(100,5,' - ',1,0,'C');
	    	$pdf->Cell(80,5,' - ',1,1,'C');
	    }

  		while ($funcaoAutorizada != null){
			$ord2++;
		   //monta uma coleção com as funções autorizadas, por tipo de boletim, para o usuário atual
			$colAutorizadaPorUsuarioTipoBol = $fachadaSist2->lerColecaoAutorizadaTipoBol($usuario->getLogin(), $funcaoAutorizada->getCodigo());
			$usuarioAutorizadoPorTipoBol = $colAutorizadaPorUsuarioTipoBol->iniciaBusca1();
			$qteUsuarioAutorizadoPorTipoBol = $colAutorizadaPorUsuarioTipoBol->getQTD();
			$pdf->SetFont('Times','',12);
			if ($ord2 == 1)
				if ($qteUsuarioAutorizadoPorTipoBol == 0){
					$pdf->Cell(100,5,$funcaoAutorizada->getCodigo().' - '.$funcaoAutorizada->getDescricao(),1,0,'L');
					$pdf->Cell(80,5,'-',1,1,'C');
				}else
					if ($qteUsuarioAutorizadoPorTipoBol >= 1)
						if (($pdf->GetY() > 180) and ($pdf->GetY() <> 189))
							$pdf->Cell(100,5,$funcaoAutorizada->getCodigo().' - '.$funcaoAutorizada->getDescricao(),1,0,'L');
						else
							$pdf->Cell(100,5,$funcaoAutorizada->getCodigo().' - '.$funcaoAutorizada->getDescricao(),"LTR",0,'L');
					else
						$pdf->Cell(100,5,$funcaoAutorizada->getCodigo().' - '.$funcaoAutorizada->getDescricao(),1,0,'L');
		    else{
				if ((($pdf->GetY() > 180) and ($pdf->GetY() <> 189)) or 
						(($qteFuncoesAutorizadas == $ord2) and ($qteUsuarios == $ord)))
					$pdf->Cell(80,5,'','LRB',0,'L');
				else
					$pdf->Cell(80,5,'',"LR",0,'L');
				if ($qteUsuarioAutorizadoPorTipoBol >= 1)
					if (($pdf->GetY() > 180) and ($pdf->GetY() <> 189))
						$pdf->Cell(100,5,$funcaoAutorizada->getCodigo().' - '.$funcaoAutorizada->getDescricao(),1,0,'L');
					else
						$pdf->Cell(100,5,$funcaoAutorizada->getCodigo().' - '.$funcaoAutorizada->getDescricao(),"LTR",0,'L');
				else{
					$pdf->Cell(100,5,$funcaoAutorizada->getCodigo().' - '.$funcaoAutorizada->getDescricao(),1,0,'L');
					$pdf->Cell(80,5,'-',1,1,'C');
				}
		    }
			$ord3 = 0;
  			while ($usuarioAutorizadoPorTipoBol != null){
				$ord3++;
				if ($ord3 == 1)
		    	    $pdf->Cell(80,5,$usuarioAutorizadoPorTipoBol->getDescricao(),1,1,'L');
				else{
					if ((($pdf->GetY() > 180) and ($pdf->GetY() <> 189)) or ($qteUsuarios == $ord)){
					  $pdf->Cell(80,5,'',"LRB",0,'L');
					  $pdf->Cell(100,5,'',"LRB",0,'L');
					}else{
					  $pdf->Cell(80,5,'',"LR",0,'L');
					  $pdf->Cell(100,5,'',"LR",0,'L');
					}
		    	    $pdf->Cell(80,5,$usuarioAutorizadoPorTipoBol->getDescricao(),1,1,'L');
		    	}
	    		$usuarioAutorizadoPorTipoBol = $colAutorizadaPorUsuarioTipoBol->getProximo1();
  			}
    		$funcaoAutorizada = $colAutorizadaPorUsuario->getProximo1();
    	}
   		$usuario = $colUsuario->getProximo1();
    }
    //SAIDA DO PDF
    $pdf->Output("perfil_usuarios.pdf" , "D");
?>

