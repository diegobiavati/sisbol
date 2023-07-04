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
	$tabela = array(array(1,'Funcões do Sistema',100),
					array(2,'Usuários autorizados',80),
					array(3,'Tipo de Boletim',80)
					);
    $pdf = new MeuPDFListas('L','mm','A4','Relatório das Permissões do Sistema (por Função)',$tabela); 
    $pdf->SetMargins(20,20,15);
    $pdf->AddPage();
    $pdf->SetFont('Times','B',12);

	//monta a coleção das funções do sistema cadastradas
	$colFuncao = $fachadaSist2->lerColecaoFuncaoDoSistema();
	$qteFuncoes = $colFuncao->getQTD();
	$funcao = $colFuncao->iniciaBusca1();
	$ord = 0;
	while ($funcao != null){
		$ord++;
		//monta uma coleção com os usuários autorizados pelo código da função atual
		$colAutorizadaPorFuncao = $fachadaSist2->lerColecaoAutorizadaPorFuncao($funcao->getCodigo(), 'X');
		$usuarioAutorizado = $colAutorizadaPorFuncao->iniciaBusca1();
		$qteUsuarios = $colAutorizadaPorFuncao->getQTD();
		$ord2 = 0;
		$pdf->SetFont('Times','',12);
    	if ($usuarioAutorizado != null)
			if ((($pdf->GetY() > 180) and ($pdf->GetY() <> 189)) or ($qteFuncoes == $ord) or ($qteUsuarios == $ord2))
				$pdf->Cell(100,5,$funcao->getCodigo().' - '.$funcao->getDescricao(),1,0,'L');
			else
				$pdf->Cell(100,5,$funcao->getCodigo().' - '.$funcao->getDescricao(),"LTR",0,'L');
    	else{
			if (($pdf->GetY() > 180) and ($pdf->GetY() <> 189)) 
				$pdf->Cell(100,5,$funcao->getCodigo().' - '.$funcao->getDescricao(),1,0,'L');
			else
				$pdf->Cell(100,5,$funcao->getCodigo().' - '.$funcao->getDescricao(),"LTR",0,'L');
	    	$pdf->Cell(80,5,' - ',1,0,'C');
	    	$pdf->Cell(80,5,' - ',1,1,'C');
	    }

  		while ($usuarioAutorizado != null){
			$ord2++;
			$colAutorizadaPorFuncaoTipoBol = $fachadaSist2->lerColecaoAutorizadaTipoBol($usuarioAutorizado->getLogin(), $funcao->getCodigo());
			$usuarioAutorizadoPorTipoBol = $colAutorizadaPorFuncaoTipoBol->iniciaBusca1();
			$qteUsuarioAutorizadoPorTipoBol = $colAutorizadaPorFuncaoTipoBol->getQTD();
			$pdf->SetFont('Times','',12);
			if ($ord2 == 1){
				if ($qteUsuarioAutorizadoPorTipoBol == 0){
					$pdf->Cell(80,5,$usuarioAutorizado->getLogin(),1,0,'L');
					$pdf->Cell(80,5,'-',1,1,'C');
				}else
					if ($qteUsuarioAutorizadoPorTipoBol >= 1)
//						if ($pdf->GetY() > 180){
						if ((($pdf->GetY() > 180) and ($pdf->GetY() <> 189)) or ($qteFuncoes == $ord))
							$pdf->Cell(80,5,$usuarioAutorizado->getLogin(),1,0,'L');
						else
							$pdf->Cell(80,5,$usuarioAutorizado->getLogin(),"LTR",0,'L');
					else
						$pdf->Cell(80,5,$usuarioAutorizado->getLogin(),1,0,'L');
		    }else{
				if ((($pdf->GetY() > 180) and ($pdf->GetY() <> 189)) or 
						(($qteUsuarios == $ord2) and ($qteFuncoes == $ord)))				
					$pdf->Cell(100,5,'','LRB',0,'L');
				else
					$pdf->Cell(100,5,'',"LR",0,'L');
				if ($qteUsuarioAutorizadoPorTipoBol >= 1)
					if (($pdf->GetY() > 180) and ($pdf->GetY() <> 189))
						$pdf->Cell(80,5,$usuarioAutorizado->getLogin(),1,0,'L');
					else
						$pdf->Cell(80,5,$usuarioAutorizado->getLogin(),"LTR",0,'L');
				else{
					$pdf->Cell(80,5,$usuarioAutorizado->getLogin(),1,0,'L');
					$pdf->Cell(80,5,'-',1,1,'C');
				}
		    }
			$ord3 = 0;
  			while ($usuarioAutorizadoPorTipoBol != null){
				$ord3++;
				if ($ord3 == 1)
		    	    $pdf->Cell(80,5,$usuarioAutorizadoPorTipoBol->getDescricao(),1,1,'L');
				else{
					if ((($pdf->GetY() > 180) and ($pdf->GetY() <> 189)) or ($qteFuncoes == $ord)){
					  $pdf->Cell(100,5,'',"LRB",0,'L');
					  $pdf->Cell(80,5,'',"LRB",0,'L');
					}else{
					  $pdf->Cell(100,5,'',"LR",0,'L');
					  $pdf->Cell(80,5,'',"LR",0,'L');
					}
		    	    $pdf->Cell(80,5,$usuarioAutorizadoPorTipoBol->getDescricao(),1,1,'L');
		    	}
	    		$usuarioAutorizadoPorTipoBol = $colAutorizadaPorFuncaoTipoBol->getProximo1();
  			}
    		$usuarioAutorizado = $colAutorizadaPorFuncao->getProximo1();
    	}
   		$funcao = $colFuncao->getProximo1();
    }
    //SAIDA DO PDF
    $pdf->Output("perfil_usuarios.pdf" , "D");
?>

