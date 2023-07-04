<?php
  class ColPessoaMateriaBi implements ICOLPessoaMateriaBi
  { private $db;
    public function ColPessoaMateriaBi($db)
    { $this->db = $db;
    }
    public function incluirRegistro($materiaBi, $pessoaMateriaBi)
    { $q = "insert into pessoa_materia_bi (cod_materia_bi, id_militar, texto_indiv) values (" .
	    $materiaBi->getCodigo() . ",'" . $pessoaMateriaBi->getpessoa()->getIdMilitar() . "','" . addslashes($pessoaMateriaBi->getTextoIndiv()) . "')";
      //echo $q;
	  $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
	  // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Incluído")
                                    </script>');
          //throw new Exception('COLPESSOAMATERIABI->Registro não Incluido');
	  }
    }
    public function alterarRegistro($materiaBi, $pessoaMateriaBi)
    { //print_r($pessoaMateriaBi);
      $q = "update pessoa_materia_bi set ";
	  $q = $q .	" texto_indiv = '" . addslashes($pessoaMateriaBi->getTextoIndiv()) . "',";
	  $q = $q . "data_atualiz = now()" ;
	  $q = $q . " where  cod_materia_bi = " . $materiaBi->getCodigo() . " and id_militar = ";
	  $q = $q . "'".$pessoaMateriaBi->getPessoa()->getIdMilitar()."'";
      //echo $q;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
	  // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Alterado")
                                    </script>');
          //throw new Exception('COLPESSOAMATERIABI->Registro não alterado');
	  }
    }
    public function excluirRegistro($materiaBi, $pessoaMateriaBi)
    { $q = "delete from pessoa_materia_bi ";
	  $q = $q . " where  cod_materia_bi = " . $materiaBi->getCodigo() . " and id_militar = '";
	  $q = $q . $pessoaMateriaBi->getPessoa()->getIdMilitar()."'";
      //echo $q;
      //die($q);
	  $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
	  // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Excluído")
                                    </script>');
          //throw new Exception('COLPESSOAMATERIABI->Registro não excluído');
	  }
    }
    public function lerRegistro($codMateriaBi, $idtMilitar)
    { $q = "select cod_materia_bi, id_militar, texto_indiv from pessoa_materia_bi ";
	  $q = $q . " where  cod_materia_bi = " . $codMateriaBi . " and id_militar = ";
	  $q = $q ."'".$idtMilitar."'";
	  //echo $q;
      $result = mysqli_query($this->db, $q);
	  if (mysqli_num_rows($result) <= 0)
	  { return null;
	  }
	  else
	  { $pessoa = new Pessoa(null, null, null,null);
	    $pessoaMateriaBi = new pessoaMateriaBi($pessoa);

        $row = mysqli_fetch_array($result);
        $pessoaMateriaBi->getPessoa()->setIdMilitar($row['id_militar']);
        $pessoaMateriaBi->setTextoIndiv(stripslashes($row['texto_indiv']));
        return $pessoaMateriaBi;
	  }
    }
    public function lerColecao($codMateriaBi)
    { $q = "select pm.cod_materia_bi, pm.id_militar, pm.texto_indiv from pessoa_materia_bi pm, pessoa p, militar m";
	  $q = $q . " where  cod_materia_bi = " . $codMateriaBi;
	  $q = $q . " and pm.id_militar = p.id_militar ";
	  $q = $q . " and pm.id_militar = m.id_militar ";
	  $q = $q . " order by m.pgrad_cod, m.antiguidade ";

	  //echo $q;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_num_rows($result);
      $colPessoaMateriaBi2 = new ColPessoaMateriaBi2();
      for ($i = 0 ; $i < $num_rows; $i++)
      { $row = mysqli_fetch_array($result);
        $pessoa = new Pessoa(null, null, null,null);
        $pessoaMateriaBi = new PessoaMateriaBi($pessoa);
        $pessoaMateriaBi->getPessoa()->setIdMilitar($row['id_militar']);
        $pessoaMateriaBi->SetTextoIndiv(stripslashes($row['texto_indiv']));
        $colPessoaMateriaBi2->incluirRegistro($pessoaMateriaBi);
      }
      return $colPessoaMateriaBi2;
    }
    public function lerAlteracoes($idMilitar, $dtInicio, $dtTermino)
    { $q = "select pessoa_materia_bi.cod_materia_bi,";
      $q = $q . " pessoa_materia_bi.id_militar,";
      $q = $q . " pessoa_materia_bi.texto_indiv,";
      $q = $q . " materia_bi.texto_abert,";
      $q = $q . " materia_bi.texto_fech,";
      $q = $q . " materia_bi.texto_fech_vai_altr,";
      $q = $q . " materia_bi.descr_ass_ger,";
//      $q = $q . " assunto_geral.descricao descr_ass_ger,"; //rv06 - Renato
      $q = $q . " materia_bi.descr_ass_esp,";
//      $q = $q . " assunto_espec.descricao descr_ass_esp,";	//rv06 - Renato
      $q = $q . " boletim.data_pub,";
      $q = $q . " boletim.numero_bi,";
      $q = $q . " boletim.bi_ref,";
      $q = $q . " tipo_bol.abreviatura,";
      $q = $q . " pessoa.nome,";
      $q = $q . " pessoa.nome_guerra,"; //linha adicionada dia 22/05/2007 as 16h 20m
      $q = $q . " pessoa.data_nasc,";
      $q = $q . " pessoa.codom,";
      $q = $q . " militar.idt_militar,";	//rv 05
      $q = $q . " militar.cp,";
      $q = $q . " militar.prec_cp,";
      $q = $q . " militar.comportamento,";
      $q = $q . " pgrad.descricao descricao_pgrad,";
      $q = $q . " pgrad.cod codigopgrad,";
      $q = $q . " qm.descricao descricao_qm";
      $q = $q . " from pessoa_materia_bi,";
      $q = $q . " materia_bi,";
      $q = $q . " assunto_geral,"; //rv06 - Renato
      $q = $q . " assunto_espec,"; //rv06 - Renato
      $q = $q . " boletim,";
      $q = $q . " tipo_bol,";
      $q = $q . " pessoa,";
      $q = $q . " militar,";
      $q = $q . " pgrad,";
      $q = $q . " qm";
	  $q = $q . " where materia_bi.vai_altr = 'S'";
	  $q = $q . " and pessoa_materia_bi.cod_materia_bi = materia_bi.cod_materia_bi";
      $q = $q . " and materia_bi.cod_assunto_ger = assunto_geral.cod_assunto";
      $q = $q . " and materia_bi.cod_assunto_esp = assunto_espec.cod";
	  $q = $q . " and materia_bi.cod_boletim = boletim.cod";
	  $q = $q . " and boletim.tipo_bol_cod = tipo_bol.cod";
	  $q = $q . " and boletim.assinado = 'S'";
	  $q = $q . " and pessoa.id_militar = pessoa_materia_bi.id_militar";
	  $q = $q . " and pessoa.id_militar = militar.id_militar";
	  $q = $q . " and pgrad.cod = militar.pgrad_cod";
	  $q = $q . " and militar.qm_cod = qm.cod";
	  if ($idMilitar != 'TODOS')
	  { $q = $q . " and militar.id_militar = '" . $idMilitar . "'";
	  }
	  $q = $q . " and data_pub >= '" . $dtInicio->GetcDataYYYYHMMHDD() . "' and data_pub <= '";
	  $q = $q . $dtTermino->GetcDataYYYYHMMHDD() . "'";
	  $q = $q . " order by pessoa_materia_bi.id_militar, boletim.data_pub";
//	  echo $q;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_num_rows($result);
//	  echo 'linhas ' . $num_rows;

//      $colBoletim2 = new ColBoletim2();
      $arrayBoletim = array();
      for ($i = 0 ; $i < $num_rows; $i++)
      { $row = mysqli_fetch_array($result);

        $dtNasc = new MinhaData($row['data_nasc']);
		$pGrad = new PGrad();
		$pGrad->setCodigo($row['codigopgrad']);
		$pGrad->setDescricao($row['descricao_pgrad']);
		$qm = new QM();
		$qm->setDescricao($row['descricao_qm']);
		$omVinc = new OmVinc(null);
		$omVinc->setCodom($row['codom']);
        $militar = new Militar($pGrad, $qm, null, $dtNasc, $omVinc, null);
        $militar->setIdMilitar($row['id_militar']);
        $militar->setIdtMilitar($row['idt_militar']);	//rv 05
        $militar->setNome($row['nome']);
        $militar->setNomeGuerra($row['nome_guerra']); //linha adicionada dia 22/05/2007 as 16h 20m
        $militar->setCP($row['cp']);
        $militar->setPrecCP($row['prec_cp']);
        $militar->setComportamento($row['comportamento']);

        $pessoaMateriaBi = new PessoaMateriaBi($militar);
        $pessoaMateriaBi->getPessoa()->setIdMilitar($row['id_militar']);
        $pessoaMateriaBi->SetTextoIndiv(stripslashes($row['texto_indiv']));

        $colPessoaMateriaBi2 = new ColPessoaMateriaBi2();
        $colPessoaMateriaBi2->incluirRegistro($pessoaMateriaBi);

        $tipoBol = new tipoBol();
        $tipoBol->setAbreviatura($row['abreviatura']);

        $materiaBi = new MateriaBi(null, null, null, null, null, $colPessoaMateriaBi2, $tipoBol,null);
        $materiaBi->setDescrAssEsp($row['descr_ass_esp']);
        $materiaBi->setDescrAssGer($row['descr_ass_ger']);
        $materiaBi->setTextoAbert(stripslashes($row['texto_abert']));
        $materiaBi->setTextoFech(stripslashes($row['texto_fech']));
        $materiaBi->setTextoFechVaiAltr($row['texto_fech_vai_altr']);

        $colMateriaBi2 = new ColMateriaBi2();
        $colMateriaBi2->IncluirRegistro($materiaBi);
        $dataPub = new MinhaData($row['data_pub']);
        $boletim = new Boletim($dataPub, $tipoBol, null, $colMateriaBi2);
        $boletim->setNumeroBi($row['numero_bi']);
        $boletim->setBiRef($row['bi_ref']);

        $arrayBoletim[$i] = $boletim;
      }
      return $arrayBoletim;
    }
  }
?>
