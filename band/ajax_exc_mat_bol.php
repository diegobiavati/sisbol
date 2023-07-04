<? 	session_start(); 
	require_once('./filelist_geral.php');
	require_once('./filelist_boletim.php');
	require_once('./filelist_assunto.php');
	require_once('./filelist_tipodoc.php');
	require_once('./filelist_militar.php');
	require_once('./filelist_pgrad.php');
	require_once('./filelist_qm.php');
	require_once('./filelist_funcao.php');
	require_once('./filelist_om.php');
	$fachadaSist2 = new FachadaSist2();
    $funcoesPermitidas = $fachadaSist2->lerColecaoAutorizada($_SESSION['NOMEUSUARIO'], 'X');	
	$apresentacao = new Apresentacao($funcoesPermitidas);
	if(!empty($_GET["opcao"])){ 
		if ($_GET["opcao"] == "exc_mat_bol"){ 
			$codMateriaBI = $_GET['codMateriaBI'];
			$materiaBi = $fachadaSist2->lerRegistroMateriaBI($codMateriaBI);
			echo '<b>'.$materiaBi->getDescrAssGer().'</b><br>';
        		if (substr($materiaBi->getDescrAssEsp(),0,1) != "(")
                            echo '<b>'.$materiaBi->getDescrAssEsp().'</b><br>';
                        if ($materiaBi->getTextoAbert()!=null)
                            echo '<br><div style="text-align: justify;">'.$materiaBi->getTextoAbert().'</div>';
                        //else
                           //echo '<br>';
			$colPessoaMateriaBi = $fachadaSist2->lerColecaoPessoaMateriaBI($codMateriaBI);
			varrePessoas($colPessoaMateriaBi,$fachadaSist2,$apresentacao);
			echo '<br><div style="text-align: justify;">'.$materiaBi->getTextoFech().'</div>';
		}
	}	
	function varrePessoas($colPessoaMateriaBi,$fachadaSist2,$apresentacao){
								$saida = "";
    		$pessoaMateriaBi = $colPessoaMateriaBi->iniciaBusca1();
                $qtePessoa = $colPessoaMateriaBi->getQTD();
                $contaPessoa = 0;

                while ($pessoaMateriaBi != null){
                  if ($contaPessoa==0)
                       echo '<br>';
          	        $contaPessoa+=1;
					$idMilitar = $pessoaMateriaBi->getPessoa()->getIdMilitar();
					$militar = $fachadaSist2->lerMilitar($idMilitar);
               		if ($militar != null){
                        $pGrad = $fachadaSist2->lerPGrad($militar->getPGrad()->getCodigo());
						if ($_SESSION['IMPRIMENOMESLINHA']=='S'){
                           echo $pGrad->getDescricao() . ' ';
                           //$nomeCompleto = trim($militar->getNome()) . ' (' . trim($militar->getNomeGuerra()) . ')';
                           echo $apresentacao->setaNomeGuerra($militar->getNome(),$militar->getNomeGuerra());
                           echo '<br>';
                           if ((trim($pessoaMateriaBi->getTextoIndiv()) <> '')||(trim($pessoaMateriaBi->getTextoIndiv()) <> '<br />')){
    	   						echo '<div style="text-align: justify;">'.$pessoaMateriaBi->getTextoIndiv().'</div>';
                           }
                        }else{
							$saida .= $pGrad->getDescricao(). ' ' . $apresentacao->setaNomeGuerra($militar->getNome(),$militar->getNomeGuerra());  
							if (trim($pessoaMateriaBi->getTextoIndiv()) <> ''){
								$textoIndiv = preg_replace('<div style="text-align: justify;">',' ',$pessoaMateriaBi->getTextoIndiv());
								$textoIndiv = preg_replace('</div>',' ',$textoIndiv);
								$saida .= " (" . $textoIndiv . ")";
	    		   			}
							if ($contaPessoa!=$qtePessoa)
								$saida .= ", ";
							else
								$saida .= ".";
                        }
                            //if (($contaPessoa == $qtePessoa)&&((trim($pessoaMateriaBi->getTextoIndiv()) == '')||(trim($pessoaMateriaBi->getTextoIndiv()) == '<br />')))
                                //echo '<br>';
                    }
                    $pessoaMateriaBi = $colPessoaMateriaBi->getProximo1();
        	   }
				if ($_SESSION['IMPRIMENOMESLINHA']!='S')
				    echo '<div style="text-align: justify;">'.$saida.'</div>';
        	   
	}
?>
