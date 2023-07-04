<?php
  class ColSecaoParteBi implements ICOLSecaoParteBi
  { private $db;
    public function ColSecaoParteBi($db)
    { $this->db = $db;
    }
    public function incluirRegistro($parteBoletim, $secaoParteBi)
    { $q = "insert into secao_parte_bi (numero_secao, numero_parte, descricao) values (" . $secaoParteBi->getNumeroSecao();
      $q = $q . ", ". $parteBoletim->getNumeroParte() . ",'" . $secaoParteBi->getDescricao() . "')";
//      echo $q;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
	  // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Incluído")
                                    </script>');
          //throw new Exception('COLSECAOPARTEBI->Registro não Incluido');
	  }
    }
    public function alterarRegistro($parteBoletim, $secaoParteBi)
    { $q = "update secao_parte_bi set ";
      $q = $q . "descricao = '" . $secaoParteBi->getDescricao() . "',";
	  $q = $q . "data_atualiz = now()" ;
	  $q = $q . " where  numero_parte = " . $parteBoletim->getNumeroParte() . " and numero_secao = " . 
	    $secaoParteBi->getNumeroSecao() ;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
	  // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Alterado")
                                    </script>');
          //throw new Exception('COLSECAOPARTEBI->Registro não alterado');
	  }
    }
    public function excluirRegistro($parteBoletim, $secaoParteBi)
    { $q = "delete from secao_parte_bi";
	  $q = $q . " where  numero_parte = " . $parteBoletim->getNumeroParte() . " and numero_secao = " . 
	    $secaoParteBi->getNumeroSecao();
//	  echo $q;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
	  // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Excluído")
                                    </script>');
          //throw new Exception('COLSECAOPARTEBI->Registro não excluído');
	  }
    }
    public function lerRegistro($numeroParte, $numeroSecao)
    { $q = "select numero_parte, numero_secao descricao from secao_parte_bi ";
	  $q = $q . " where  numero_parte = " . $numeroParte . " and numero_secao = " . $numeroSecao();
      $result = mysqli_query($this->db, $q);
	  if (mysqli_num_rows($result) <= 0)
	  { return null;
	  }
	  else
	  { $secaoParteBi = new SecaoParteBi();
      
        $row = mysqli_fetch_array($result);
        $secaoParteBi->setNumeroSecao($row['numero_secao']);
        $secaoParteBi->setDescricao($row['descricao']);
        return $secaoParteBi;
	  }
    }
    public function lerColecao($numeroParte)
    { $q = "select numero_parte, numero_secao, descricao from secao_parte_bi ";
	  $q = $q . " where  numero_parte = " . $numeroParte;
//	  echo $q;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_num_rows($result);
      $colSecaoParteBi2 = new ColSecaoParteBi2();
      for ($i = 0 ; $i < $num_rows; $i++)
      { $row = mysqli_fetch_array($result);
        $secaoParteBi = new SecaoParteBi();
        $secaoParteBi->setNumeroSecao($row['numero_secao']);
        $secaoParteBi->SetDescricao($row['descricao']);
        $colSecaoParteBi2->incluirRegistro($secaoParteBi);
      }
      return $colSecaoParteBi2;
    }
  }
?>
