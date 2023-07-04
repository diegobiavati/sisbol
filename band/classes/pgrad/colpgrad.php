<?php
  class ColPGrad implements IColPGrad  
  { private $db;
    public function ColPGrad($db)
    { $this->db = $db;
    }
    public function incluirRegistro($pGrad)
    { $q = "insert into pgrad (cod, descricao, data_atualiz) values (" . $pGrad->getCodigo() . ", '". $pGrad->getDescricao() .
	    "',";
      $q = $q . "now())" ;  
      /*$result = mysql_query($q,$this->db);
      $num_rows = mysql_affected_rows();*/
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
	  // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro n�o Inclu�do")
                                    </script>');
          //throw new Exception('COLPOSTOGRADUA��O->Registro n�o Incluido');
	  }
    }
    public function alterarRegistro($pGrad)
    { $q = "update pgrad set ";
      $q = $q . "descricao = '" . $pGrad->getDescricao() . "',";
	  $q = $q . "data_atualiz = now() " ;
	  $q = $q . " where  cod = " . $pGrad->getCodigo();
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
	  // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro n�o alterado")
                                    </script>');
          //throw new Exception('COLPOSTOGRADUA��O->Registro n�o alterado');
	  }
    }
    public function excluirRegistro($pGrad)
    { $q = "delete from pgrad ";
	  $q = $q . " where  cod = " . $pGrad->getCodigo();
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
	  // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro n�o Exclu�do")
                                    </script>');
          //throw new Exception('COLPOSTOGRADUA��O->Registro n�o exclu�do');
	  }
    }
    public function lerRegistro($codPGrad)
    { $q = "select cod, descricao from pgrad ";
	  $q = $q . "  where  cod = " . $codPGrad;
      $result = mysqli_query($this->db, $q);
	  if (mysqli_num_rows($result) <= 0)
	  { return null;
	  }
	  else
	  { $pGrad = new PGrad();
        $row = mysqli_fetch_array($result);
        $pGrad->setCodigo($row['cod']);
        $pGrad->setDescricao($row['descricao']);
        return $pGrad;
	  
	  }
    }
    public function lerColecao($ordem)
    { $q = "select cod, descricao from pgrad ";
	  $q = $q . "  order by  " . $ordem;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_num_rows($result);
      $colPGrad2 = new ColPGrad2();
      for ($i = 0 ; $i < $num_rows; $i++)
      { $row = mysqli_fetch_array($result);
        $pGrad = new PGrad();
        $pGrad->setCodigo($row['cod']);
        $pGrad->SetDescricao($row['descricao']);
        $colPGrad2->incluirRegistro($pGrad);
      }
      return $colPGrad2;
    }
  }
?>
