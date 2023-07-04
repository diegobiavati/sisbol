<? 	
        session_start();
	require_once('./filelist_geral.php');
	require_once('./filelist_assunto.php');
	require_once('./filelist_boletim.php');
	require_once('./filelist_tipodoc.php');
	require_once('./filelist_pdf.php');
	require_once('./filelist_militar.php');
	require_once('./filelist_funcao.php');	
	require_once('./filelist_om.php');
	require_once('./filelist_pgrad.php');
	require_once('./filelist_qm.php');
	require_once('./filelist_usuariofuncaotipobol.php');
	$fachadaSist2 = new FachadaSist2();
        $funcoesPermitidas = $fachadaSist2->lerColecaoAutorizada($_SESSION['NOMEUSUARIO'], 'X');
	$apresentacao = new Apresentacao($funcoesPermitidas);
	
	$codMateria = $_GET['codMateria'];
	
	$materiaBi = $fachadaSist2->lerRegistroMateriaBI($codMateria);

	$texto = $materiaBi->getDescrAssGer().'<br>';
	$texto .= $materiaBi->getDescrAssEsp().'<br><br>';
	$texto .= $materiaBi->getTextoAbert();
		
	$colPessoaMateriaBi2 = $fachadaSist2->lerColecaoPessoaMateriaBI($codMateria);
	$PessoaMateriaBI = $colPessoaMateriaBi2->iniciaBusca1();
	while ($PessoaMateriaBI != null){
		$ord++;
		$idMilitar = $PessoaMateriaBI->getPessoa()->getIdMilitar();
		$Militar = $fachadaSist2->lerMilitar($idMilitar);
					
		$pQM = $fachadaSist2->lerQM($Militar->getQM()->getCod());
		$pGrad = $fachadaSist2->lerPGrad($Militar->getPGrad()->getCodigo());
		
		$texto .= '<br>'.$pGrad->getDescricao().' ';
		$texto .= $apresentacao->setaNomeGuerra($Militar->getNome(),$Militar->getNomeGuerra());
		if (trim($PessoaMateriaBI->getTextoIndiv()) !== ''){
			$texto .= '<br>'.$PessoaMateriaBI->getTextoIndiv().'<br>';
		}else{
			$texto .= '<br>';
		}
		$PessoaMateriaBI = $colPessoaMateriaBi2->getProximo1();
	}  
	$texto .= '<br>'.$materiaBi->getTextoFech();
	//echo $texto;
	$pdf = new html2fpdf('P','mm','A4');

        $pdf->SetMargins(15,20,15);
	$pdf->SetAutoPageBreak(true,17);
	$pdf->AddPage();
	$pdf->WriteHTML($texto);
	
	$pdf->Output("teste.pdf" , "I");
?>
