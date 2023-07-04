<?php
  class ColIndicePessoa implements ICOLIndicePessoa
  { private $db;
    public function ColIndicePessoa($db)
    { $this->db = $db;
    }
    public function lerColecao($codTipoBol, $dtInicio, $dtTermino)
    {
      $q = "select materia_bi.pagina,";
      $q = $q . " assunto_geral.cod_assunto,";
      $q = $q . " materia_bi.cod_assunto_ger,";
      $q = $q . " assunto_geral.descricao descr_ass_ger,";
//      $q = $q . " materia_bi.descr_ass_ger,";
      $q = $q . " assunto_espec.cod,";
      $q = $q . " materia_bi.cod_materia_bi,";
      $q = $q . " materia_bi.cod_assunto_esp,";
      $q = $q . " materia_bi.usuario,";
      $q = $q . " assunto_espec.descricao descr_ass_esp,";
//      $q = $q . " materia_bi.descr_ass_esp,";
      $q = $q . " boletim.numero_bi,";
      $q = $q . " boletim.data_pub,";
      $q = $q . " pgrad.cod,";
      $q = $q . " pgrad.descricao descricaopgrad,";
      $q = $q . " militar.antiguidade, ";
      $q = $q . " pessoa.nome, ";
      $q = $q . " pessoa.id_militar, ";
      $q = $q . " tipo_bol.descricao,";
      $q = $q . " tipo_bol.abreviatura";
      $q = $q . " from assunto_geral, assunto_espec, materia_bi, ";
      $q = $q . " boletim,";
      $q = $q . " tipo_bol,";
      $q = $q . " pessoa_materia_bi,";
      $q = $q . " pessoa,";
      $q = $q . " militar,";
      $q = $q . " pgrad";
      $q = $q . " where  materia_bi.cod_boletim = boletim.cod";
      $q = $q . " and    materia_bi.cod_materia_bi = pessoa_materia_bi.cod_materia_bi";
      $q = $q . " and    pessoa_materia_bi.id_militar = pessoa.id_militar";
      $q = $q . " and    pessoa.id_militar = militar.id_militar";
      $q = $q . " and    militar.pgrad_cod = pgrad.cod";
      $q = $q . " and    materia_bi.cod_assunto_ger = assunto_geral.cod_assunto";
      $q = $q . " and    materia_bi.cod_assunto_esp = assunto_espec.cod";
      $q = $q . " and    boletim.assinado = 'S'";
      $q = $q . " and    boletim.data_pub >= '" . $dtInicio->GetcDataYYYYHMMHDD() . "'";
      $q = $q . " and    boletim.data_pub <= '" . $dtTermino->GetcDataYYYYHMMHDD() . "'";
      $q = $q . " and    boletim.tipo_bol_cod = " . $codTipoBol;
      $q = $q . " and    boletim.tipo_bol_cod = tipo_bol.cod";
      $q = $q . " order by pgrad.cod, militar.antiguidade,";
      $q = $q . " pessoa.nome,";
      $q = $q . " materia_bi.descr_ass_ger,";
      $q = $q . " materia_bi.descr_ass_esp,";
      $q = $q . " boletim.numero_bi, ";
      $q = $q . " materia_bi.pagina ";
      //echo $q;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_num_rows($result);
      $colIndicePessoa2 = new ColIndicePessoa2();
      for ($i = 0 ; $i < $num_rows; $i++)
      { $row = mysqli_fetch_array($result);


        $tipoBol = new TipoBol();
        $tipoBol->setDescricao($row['descricao']);
        $tipoBol->setAbreviatura($row['abreviatura']);

        $dataPub = new MinhaData($row['data_pub']);
        $boletim = new boletim($dataPub, $tipoBol, null, null);
        $boletim->setNumeroBi($row['numero_bi']);

        $assuntoGeral = new AssuntoGeral(null, null, null, null);
        $assuntoGeral->setDescricao(trim($row['descr_ass_ger']));

        $assuntoEspec = new AssuntoEspec();
        $assuntoEspec->setDescricao(trim($row['descr_ass_esp']));


        $materiaBi = new MateriaBi($dataPub, $assuntoEspec, $assuntoGeral, null, null,null, $tipoBol, null);
        $materiaBi->setPagina($row['pagina']);
        $materiaBi->setCodigo($row['cod_materia_bi']);
        $materiaBi->setUsuario($row['usuario']);

        $pGrad = new PGrad();
        $pGrad->setCodigo($row['cod']);
        $pGrad->setDescricao($row['descricaopgrad']);
		$militar = new Militar($pGrad, null, null, null, null, null);
        $militar->setNome(trim($row['nome']));
//        $militar->setNome($row['NOME']);
        $militar->setIdMilitar($row['id_militar']);

        $pessoaMateriaBi = new PessoaMateriaBi($militar);
        $indicePessoa = new IndicePessoa($boletim, $materiaBi, $pessoaMateriaBi);
        $indicePessoa->setCodigo($i+1);
        $colIndicePessoa2->incluirRegistro($indicePessoa);
      }
      //die($colIndicePessoa2);
      return $colIndicePessoa2;

    }
  }
?>
