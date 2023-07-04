<?php
  class ColIndice implements ICOLIndice
  { private $db;
    public function ColIndice($db)
    { $this->db = $db;
    }
    public function lerColecao($codTipoBol, $dtInicio, $dtTermino)
    {
//      $q =  "select materia_bi.descr_ass_ger,";
      $q =  "select ";
      $q = $q . "assunto_geral.descricao descr_ass_ger,";
//      $q = $q . "materia_bi.descr_ass_esp,";
      $q = $q . "assunto_espec.descricao descr_ass_esp,";
      $q = $q . " materia_bi.cod_materia_bi,";
      $q = $q . " materia_bi.pagina,";
      $q = $q . " materia_bi.usuario,";
      $q = $q . " boletim.numero_bi,";
      $q = $q . " boletim.data_pub,";
      $q = $q . " tipo_bol.descricao,";
      $q = $q . " tipo_bol.abreviatura";
      $q = $q . " from   materia_bi, ";
      $q = $q . " assunto_geral,";
      $q = $q . " assunto_espec,";
      $q = $q . " boletim,";
      $q = $q . " tipo_bol";
      $q = $q . " where  materia_bi.cod_assunto_ger = assunto_espec.cod_assunto_ger";
      $q = $q . " and    materia_bi.cod_assunto_ger = assunto_geral.cod_assunto";
      $q = $q . " and    materia_bi.cod_assunto_esp = assunto_espec.cod";
      $q = $q . " and    materia_bi.cod_boletim = boletim.cod";
      $q = $q . " and    assunto_espec.vai_indice = 'S'";
      $q = $q . " and    boletim.assinado = 'S'";
      $q = $q . " and    boletim.data_pub >= '" . $dtInicio->GetcDataYYYYHMMHDD() . "'";
      $q = $q . " and    boletim.data_pub <= '" . $dtTermino->GetcDataYYYYHMMHDD() . "'";
      $q = $q . " and    boletim.tipo_bol_cod = " . $codTipoBol;
      $q = $q . " and    boletim.tipo_bol_cod = tipo_bol.cod";
      $q = $q . " order  by materia_bi.descr_ass_ger,";
      $q = $q . "    materia_bi.descr_ass_esp,";
      $q = $q . "    boletim.numero_bi, ";
      $q = $q . "    materia_bi.pagina";
      //echo $q;

      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_num_rows($result);
      $colIndice2 = new ColIndice2();
      for ($i = 0 ; $i < $num_rows; $i++)
      { $row = mysqli_fetch_array($result);

        $tipoBol = new TipoBol();
        $tipoBol->setDescricao($row['descricao']);
        $tipoBol->setAbreviatura($row['abreviatura']);

        $assuntoGeral = new AssuntoGeral(null, null, $tipoBol, null);
        $assuntoGeral->setDescricao($row['descr_ass_ger']);

        $assuntoEspec = new AssuntoEspec();
        $assuntoEspec->setDescricao($row['descr_ass_esp']);

        $dataPub = new MinhaData($row['data_pub']);
        $tipoBol = new TipoBol();
        $tipoBol->setDescricao($row['descricao']);
        $tipoBol->setAbreviatura($row['abreviatura']);

        $boletim = new boletim($dataPub, $tipoBol, null, null);
        $boletim->setNumeroBi($row['numero_bi']);
        $materiaBi = new MateriaBi($dataPub, $assuntoEspec, $assuntoGeral, null, null,null, $tipoBol,null);
        $materiaBi->setPagina($row['pagina']);
        $materiaBi->setUsuario($row['usuario']);
        $materiaBi->setCodigo($row['cod_materia_bi']);
        $indice = new Indice($boletim, $materiaBi);
        $indice->setCodigo($i+1);
        $colIndice2->incluirRegistro($indice);
      }
      //print_r($colIndice2);
      return $colIndice2;
    }

  }
?>
