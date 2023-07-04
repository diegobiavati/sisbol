<?php
  class ColAssuntogeral implements ICOLAssuntoGeral
  { private $db;
    public function ColAssuntoGeral($db)
    { $this->db = $db;
    }
    public function incluirRegistro($assuntoGeral)
    { $q = "insert into assunto_geral (numero_parte, numero_secao, descricao,ord_assunto_geral,cod_tipo_bol) values (";

	  $q = $q . $assuntoGeral->getParteBoletim()->getNumeroParte() . ",'" . $assuntoGeral->getSecaoParteBi()->getNumeroSecao()
	    . "','"  . $assuntoGeral->getDescricao() . "',". $assuntoGeral->getOrdAssuntoGeral() . "," . $assuntoGeral->getTipoBol()->getCodigo() . ")";
      //echo $q;
      /*$result = mysql_query($q,$this->db);
      $num_rows = mysql_affected_rows();*/
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
	  // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Incluído")
                                    </script>');
          //throw new Exception('COLASSUNTOGERAL->Registro não Incluido');
	  }
    }
    public function alterarRegistro($assuntoGeral)
    { $q = "update assunto_geral set ";
      $q = $q . "numero_parte = ".$assuntoGeral->getParteBoletim()->getNumeroParte().",";
      $q = $q . "numero_secao = '".$assuntoGeral->getSecaoParteBi()->getNumeroSecao()."',";
      $q = $q . "descricao = '" . $assuntoGeral->getDescricao() . "',";
      $q = $q . "cod_tipo_bol = ".$assuntoGeral->getTipoBol()->getCodigo().",";
	  $q = $q . "data_atualiz = now()" ;
	  $q = $q . " where cod_assunto = " . $assuntoGeral->getCodigo();
      //echo $q;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
	  // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Alterado")
                                    </script>');
          //throw new Exception('COLASSUNTOGERAL->Registro não alterado');
	  }
    }
    public function excluirRegistro($assuntoGeral)
    { $q = "delete from assunto_geral";
	  $q = $q . " where cod_assunto = " . $assuntoGeral->getCodigo();
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
	  // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Excluído")
                                    </script>');
          //throw new Exception('COLASSUNTOGERAL->Registro não excluído');
	  }
    }
    public function lerRegistro($codigo)
    { $q = "select cod_assunto, numero_parte, numero_secao, descricao, cod_tipo_bol, data_atualiz from assunto_geral ";
	  $q = $q . " where cod_assunto = " . $codigo;
      //echo $q;
      $result = mysqli_query($this->db, $q);
	  if (mysqli_num_rows($result) <= 0)
	  { return null;
	  }
	  else
	  { $parteBoletim = new ParteBoletim(null);
		$secaoParteBi = new SecaoParteBi();
		$tipoBol = new TipoBol();
		$assuntoGeral = new AssuntoGeral($parteBoletim, $secaoParteBi, $tipoBol, new ColAssuntoEspec2());

        $row = mysqli_fetch_array($result);
        $assuntoGeral->setCodigo($row['cod_assunto']);
        $assuntoGeral->setDescricao($row['descricao']);
        $assuntoGeral->getParteBoletim()->setNumeroParte($row['numero_parte']);
        $assuntoGeral->getSecaoParteBi()->setNumeroSecao($row['numero_secao']);
        $assuntoGeral->getTipoBol()->setCodigo($row['cod_tipo_bol']);

	    return $assuntoGeral;
	  }
    }
    public function lerUltimoRegistro()
    { $q = "select max(cod_assunto) as ultimo from assunto_geral ";
//    echo $q;
      $result = mysqli_query($this->db, $q);
	  if (mysqli_num_rows($result) <= 0)
	  { return null;
	  }
	  else
	  { $row = mysqli_fetch_array($result);
        return $this->lerRegistro($row['ultimo']);
	  }
    }
    public function lerColecao($numeroParte,$numeroSecao,$codTipoBol)
    { $q = "select cod_assunto, numero_parte, numero_secao, descricao, ord_assunto_geral, cod_tipo_bol from assunto_geral ";
	  $q = $q . " where numero_parte = " . $numeroParte . " and numero_secao = " . $numeroSecao . " and cod_tipo_bol = " . $codTipoBol;
	  $q = $q . " order by ord_assunto_geral, descricao";
	  //echo $q;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_num_rows($result);
      $colAssuntoGeral2 = new ColAssuntoGeral2();
      $SecaoParteBi = new SecaoParteBi();
      $ParteBi = new ParteBoletim($SecaoParteBi);
      $tipoBol = new TipoBol();
      for ($i = 0 ; $i < $num_rows; $i++)
      { $row = mysqli_fetch_array($result);
        $assuntoGeral = new AssuntoGeral($ParteBi,$SecaoParteBi,$tipoBol,null);
        $assuntoGeral->setCodigo($row['cod_assunto']);
        $assuntoGeral->setParteBoletim($row['numero_parte']);
        $assuntoGeral->setSecaoParteBi($row['numero_secao']);
        $assuntoGeral->SetDescricao($row['descricao']);
        $assuntoGeral->setOrdAssuntoGeral($row['ord_assunto_geral']);
        $assuntoGeral->setTipoBol($row['cod_tipo_bol']);
        $colAssuntoGeral2->incluirRegistro($assuntoGeral);
      }
      return $colAssuntoGeral2;
    }
    public function lerColecaoLike($numeroParte,$numeroSecao,$codTipoBol,$like)
    { $q = "select cod_assunto, numero_parte, numero_secao, descricao from assunto_geral ";
	  $q = $q . " where numero_parte = " . $numeroParte . " and numero_secao = " . $numeroSecao . " and cod_tipo_bol = " . $codTipoBol;
	  if ($like != ''){
	  	$q = $q ." and descricao like '%".$like."%'";
	  }
	  $q = $q . " order by descricao";
	  //echo $q;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_num_rows($result);
      $colAssuntoGeral2 = new ColAssuntoGeral2();
      $SecaoParteBi = new SecaoParteBi();
      $ParteBi = new ParteBoletim($SecaoParteBi);
      $tipoBol = new TipoBol();
      for ($i = 0 ; $i < $num_rows; $i++)
      { $row = mysqli_fetch_array($result);
        $assuntoGeral = new AssuntoGeral($ParteBi,$SecaoParteBi,$tipoBol,null);
        $assuntoGeral->setCodigo($row['cod_assunto']);
        $assuntoGeral->setParteBoletim($row['numero_parte']);
        $assuntoGeral->setSecaoParteBi($row['numero_secao']);
        $assuntoGeral->SetDescricao($row['descricao']);
        $assuntoGeral->setTipoBol($row['cod_tipo_bol']);
        $colAssuntoGeral2->incluirRegistro($assuntoGeral);
      }
      return $colAssuntoGeral2;
    }

    public function setaOrdem($codAssuntoGer, $ordemAssuntoGer)
    {
      $q = "update assunto_geral set	ord_assunto_geral = " . $ordemAssuntoGer . "
    			where  cod_assunto = " . $codAssuntoGer;
      //echo $q;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
	  // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Alterado")
                                    </script>');
          //throw new Exception('COLASSUNTOGERAL->Registro não alterado');
	  }
    }

    public function setaOrdemGeral($codAssuntoGeral, $ordemAssuntoGeral)
    {
      $q = "update assuntogeral set	ord_assunto_geral = " . $ordemAssuntoGeral . "
    			where  cod_assunto = " . $codAssuntoGeral;
      //echo $q;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
          // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Alterado")
                                    </script>');
          //throw new Exception('COLMASSUNTOGERAL->Registro não alterado');
	  }
    }
  }
?>
