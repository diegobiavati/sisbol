<?php
  class ColFuncaoDoSistema implements ICOLFuncaoDoSistema
  { private $db;
    public function ColFuncaoDoSistema($db)
    { $this->db = $db;
    }
    public function incluirRegistro($funcaoDoSistema)//alterado
    { $q = "insert into funcoesdosistema (codigofuncao, descricao, assoc_tipobol) values (" . 
	    $funcaoDoSistema->getCodigo() . ",'" . $funcaoDoSistema->getDescricao() . "','" .  
		$funcaoDoSistema->getAssocTipoBol() . "')";
//	  echo $q;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
	  // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Incluído")
                                    </script>');
          //throw new Exception('COLFUNCAODOSISTEMA->Registro não Incluido');
	  }
    }
    public function alterarRegistro($funcaoDoSistema)//alterado
    { $q = "update funcoesdosistema set descricao = '" . $funcaoDoSistema->getDescricao() . "', assoc_tipobol = '";
      $q = $q . $funcaoDoSistema->getAssocTipoBol() . "',";
	  $q = $q . "data_atualiz = now()" ;
	  $q = $q . " where codigofuncao = " . $funcaoDoSistema->getCodigo();
//      echo $q;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
	  // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Alterado")
                                    </script>');
          //throw new Exception('COLFUNCAODOSISTEMA->Registro não alterado');
	  }
    }
    public function excluirRegistro($funcaoDoSistema)
    { $q = "delete from funcoesdosistema ";
	  $q = $q . " where  codigofuncao = " .$funcaoDoSistema->getCodigo() ;
//	  echo $q;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
	  // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Excluído")
                                    </script>');
          //throw new Exception('COLFUNCAODOSISTEMA->Registro não excluído');
	  }
    }
    
    public function lerRegistro($codigo)//alterado
    { $q = "select codigofuncao, descricao, assoc_tipobol from funcoesdosistema ";
	  $q = $q . " where codigofuncao = " . $codigo ;
//	  $q = $q . " and ativado = 'S'" ;
//	  echo $q;
      $result = mysqli_query($this->db, $q);
	  if (mysqli_num_rows($result) <= 0)
	  { return null;
	  }
	  else
	  { $row = mysqli_fetch_array($result);
	    $funcaoDoSistema = new FuncaoDoSistema();        
        $funcaoDoSistema->setCodigo($row['codigofuncao']);
        $funcaoDoSistema->setDescricao($row['descricao']);
        $funcaoDoSistema->setAssocTipoBol($row['assoc_tipobol']);
        return $funcaoDoSistema;
	  }
    }
    public function lerColecao()//alterado
    { $q = "select codigofuncao, descricao, assoc_tipobol from funcoesdosistema "; 
	  $q = $q . " where ativado = 'S'" ;
	 // echo $q;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_num_rows($result);
      $colFuncaoDoSistema2 = new ColFuncaoDoSistema2();
      for ($i = 0 ; $i < $num_rows; $i++)
      { $row = mysqli_fetch_array($result);
	    $funcaoDoSistema = new FuncaoDoSistema();        
        $funcaoDoSistema->setCodigo($row['codigofuncao']);
        $funcaoDoSistema->setDescricao($row['descricao']);
        $funcaoDoSistema->setAssocTipoBol($row['assoc_tipobol']);
        $colFuncaoDoSistema2->incluirRegistro($funcaoDoSistema);
      }
      return $colFuncaoDoSistema2;
    }
    
  }
?>
