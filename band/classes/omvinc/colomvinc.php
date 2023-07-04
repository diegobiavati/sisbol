<?php
  class ColOMVinc implements IColOMVinc  
  { private $db;
    public function ColOMVinc($db)
    { $this->db = $db;
    }
    public function incluirRegistro($OMVinc)
    { $q = "insert into om_vinc (codom,nome,gu, sigla)
			values ('" . $OMVinc->getCodOM() ."','". $OMVinc->getNome() ."','". $OMVinc->getGu() . "','".
			$OMVinc->getSigla() ."')";
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
          // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Incluído")
                                    </script>');
          //throw new Exception('Registro não Incluido');
          /* { throw new Exception('COLOMVinc->Registro não Incluido'); PARREIRA 05-06-2013 modificado msg */
	  }
    }
    public function alterarRegistro($OMVinc)
    { $q = "update om_vinc set ";
      $q = $q . "codom = '".$OMVinc->getCodOM() ."',";
      $q = $q . "nome = '".$OMVinc->getNome() ."',";
	  $q = $q . "gu = '".$OMVinc->getGu() ."',";
	  $q = $q . "sigla = '".$OMVinc->getSigla() ."',";
	  $q = $q . "data_atualiz = now()";
	  $q = $q . " where  codom = '" . $OMVinc->getCodOM() . "'";
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
          // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Alterado")
                                    </script>');
          //throw new Exception('Registro não alterado');
      /* { throw new Exception('COLOMVinc->Registro não alterado'); PARREIRA 05-06-2013 modificado msg */
	  }
    }
    public function excluirRegistro($OMVinc)
    { $q = "delete from om_vinc ";
	  $q = $q . " where  codom = '" . $OMVinc->getCodOM() . "'";
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
          // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Excluído")
                                    </script>');
          //throw new Exception('Registro não excluído');
      /* { throw new Exception('COLOMVinc->Registro não excluído'); PARREIRA 05-06-2013 modificado msg */
	  }
    }
    public function lerRegistro($codOM)
    { $q = "select codom,nome,gu, sigla, data_atualiz from om_vinc";
      $q = $q . " where codom = '" . $codOM . "'";
      $result = mysqli_query($this->db, $q);
	  if (mysqli_num_rows($result) <= 0)
	  { return null;
	  }
	  else
	  { $OMVinc = new OMVinc(null);
        $row = mysqli_fetch_array($result);
        $OMVinc->setCodOM($row['codom']);
		$OMVinc->setNome($row['nome']);
		$OMVinc->setGu($row['gu']);
		$OMVinc->setSigla($row['sigla']);
        return $OMVinc;
	  
	  }
    }
    public function lerColecao($ordem)
    { $q = "select codom,nome,gu, sigla from om_vinc";
	  $q = $q . "  order by  " . $ordem;
	  $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_num_rows($result);
      $colOMVinc2 = new ColOMVinc2();
      for ($i = 0 ; $i < $num_rows; $i++)
      { $row = mysqli_fetch_array($result);
        $OMVinc = new OMVinc(null);
        $OMVinc->setCodOM($row['codom']);
		$OMVinc->setNome($row['nome']);
		$OMVinc->setGu($row['gu']);
		$OMVinc->setSigla($row['sigla']);
        $colOMVinc2->incluirRegistro($OMVinc);
      }
      return $colOMVinc2;
    }
  }
?>
