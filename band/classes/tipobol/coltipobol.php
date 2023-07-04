<?php
  class ColTipoBol implements IColTipoBol
  { private $db;
    public function ColTipoBol($db)
    { $this->db = $db;
    }
    public function incluirRegistro($tipoBol)
    { $q = "insert into tipo_bol (descricao, abreviatura, nr_ult_pag, nr_ult_bi, ini_num_pag, e_aditamento,imp_bordas, titulo2, data_atualiz) ";
	  $q = $q . " values ('". $tipoBol->getDescricao() ."','". $tipoBol->getAbreviatura()."',";
	  $q = $q . $tipoBol->getNrUltPag() . ", ". $tipoBol->getNrUltBi() .",'";
	  $q = $q . $tipoBol->getIni_num_pag() . "','". $tipoBol->getE_Aditamento() ."','". $tipoBol->getImp_bordas() ."','". $tipoBol->getTitulo2() ."',";
      $q = $q . "now())" ;
//      echo $q;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
	  // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Incluído")
                                    </script>');
          //throw new Exception('COLTIPOBOL->Registro não Incluido');
	  }
    }
    public function alterarRegistro($tipoBol)
    {
      $ini_num_pag =
      $q = "update tipo_bol set ";
      $q = $q . "descricao = '" . $tipoBol->getDescricao() . "',";
      $q = $q . "abreviatura = '". $tipoBol->getAbreviatura() . "',";
	  $q = $q . "nr_ult_pag = " . $tipoBol->getNrUltPag() . ",";
      $q = $q . "nr_ult_bi = " . $tipoBol->getNrUltBi() . ",";
      $q = $q . "ini_num_pag = '" . $tipoBol->getIni_num_pag() ."',";
      $q = $q . "e_aditamento = '" . $tipoBol->getE_Aditamento() ."',";
      $q = $q . "imp_bordas = '" . $tipoBol->getImp_bordas() ."',";
      $q = $q . "titulo2 = '" . $tipoBol->getTitulo2() ."',";
      $q = $q . "data_atualiz = now() " ;
	  $q = $q . " where  cod = " . $tipoBol->getCodigo();
	  //echo "<br><b>".$q."</b><br>";
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
	  // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Alterado")
                                    </script>');
          //throw new Exception('COLTIPOBOL->Registro não alterado');
	  }
    }
    public function excluirRegistro($tipoBol)
    { $q = "delete from tipo_bol ";
	  $q = $q . " where  cod = " . $tipoBol->getCodigo();
//	  echo "<br><b>".$q."</b><br>";
      $result = mysqli_query($this->db, $q);
//      echo $result;
      $num_rows = mysqli_affected_rows($this->db);
//      echo $num_rows;
      if ($num_rows <= 0)
      { 
	  // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Excluído")
                                    </script>');
          //throw new Exception('COLTIPOBOL->Registro não excluído');
	  }
    }
    public function lerRegistro($codTipoBol)
    { $q = "select cod, descricao, abreviatura, nr_ult_pag, nr_ult_bi, ini_num_pag, e_aditamento, imp_bordas, titulo2 from tipo_bol ";
	  $q = $q . "  where  cod = " . $codTipoBol;
	  //echo "<br><b>".$q."</b><br>";
      $result = mysqli_query($this->db, $q);
	  if (mysqli_num_rows($result) <= 0)
	  { return null;
	  }
	  else
	  { $tipoBol = new TipoBol();
        $row = mysqli_fetch_array($result);
        $tipoBol->setCodigo($row['cod']);
        $tipoBol->setDescricao($row['descricao']);
        $tipoBol->setAbreviatura($row['abreviatura']);
        $tipoBol->setNrUltPag($row['nr_ult_pag']);
        $tipoBol->setNrUltBi($row['nr_ult_bi']);
        $tipoBol->setIni_num_pag($row['ini_num_pag']);
        $tipoBol->setE_Aditamento($row['e_aditamento']);
		$tipoBol->setImp_bordas($row['imp_bordas']);
		$tipoBol->setTitulo2($row['titulo2']);
        return $tipoBol;
	  }
    }
    public function lerColecao($ordem)
    { $q = "select cod, descricao, abreviatura, nr_ult_pag, nr_ult_bi, ini_num_pag, ";
      $q = $q . " e_aditamento, imp_bordas, titulo2  from tipo_bol ";
	  $q = $q . "  order by  " . $ordem;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_num_rows($result);

      $colTipoBol2 = new ColTipoBol2();
      for ($i = 0 ; $i < $num_rows; $i++)
      { $row = mysqli_fetch_array($result);
        $tipoBol = new TipoBol();
        $tipoBol->setCodigo($row['cod']);
        $tipoBol->setDescricao($row['descricao']);
        $tipoBol->setAbreviatura($row['abreviatura']);
        $tipoBol->setNrUltPag($row['nr_ult_pag']);
        $tipoBol->setNrUltBi($row['nr_ult_bi']);
        $tipoBol->setIni_num_pag($row['ini_num_pag']);
        $tipoBol->setE_Aditamento($row['e_aditamento']);
        $tipoBol->setImp_bordas($row['imp_bordas']);
		$tipoBol->setTitulo2($row['titulo2']);
        $colTipoBol2->incluirRegistro($tipoBol);
      }
      return $colTipoBol2;
    }
  }
?>
