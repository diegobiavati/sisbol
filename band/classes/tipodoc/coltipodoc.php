<?php
  class ColTipoDoc implements IColTipoDoc 
  { private $db;
  	private function mensagem($mensagem){
  		echo '<script>window.alert("'.$mensagem.'")</script>';
  	}
    public function ColTipoDoc($db)
    { $this->db = $db;
    }
    public function incluirRegistro($tipoDoc)
    { $q = "insert into tipo_doc (descricao, data_atualiz) values ('". $tipoDoc->getDescricao() . "', now())";
      //echo $q;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
	  // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Incluído")
                                    </script>');
          //throw new Exception('COLTIPODOC->Registro não Incluido');
	  } 
    }
    public function alterarRegistro($tipoDoc)
    { $q = "update tipo_doc set ";
      $q = $q . "descricao = '" . $tipoDoc->getDescricao() . "',";
      $q = $q . " data_atualiz = now() ";
	  $q = $q . " where  codigo_tipo = " . $tipoDoc->getCodigo();
      //echo $q;
	  $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
	  // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Alterado")
                                    </script>');
          //throw new Exception('COLTIPODOC->Registro não alterado');
	  } 
    }
    
    public function excluirRegistro($tipoDoc)
    { $q = "delete from tipo_doc ";
	  $q = $q . " where  codigo_tipo = " . $tipoDoc->getCodigo();
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
	  // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Excluído")
                                    </script>');
          //throw new Exception('COLTIPODOC->Registro não excluído');
	  }
    }
    
    public function lerRegistro($codDoc)
    { 
//	  echo $codDoc;
	  $q = "select codigo_tipo, descricao from tipo_doc";
	  $q = $q . " where codigo_tipo = " . $codDoc;
	  
      $result = mysqli_query($this->db, $q);
	  if (mysqli_num_rows($result) <= 0)
	  { return null;
	  }
	  else
	  { $tipoDoc = new TipoDoc();
      
        $row = mysqli_fetch_array($result);
        $tipoDoc->setCodigo($row['codigo_tipo']);
        $tipoDoc->setDescricao($row['descricao']);
        return $tipoDoc;
	  
	  }
    }
    
    public function lerColecao($ordem)
    { $q = "select codigo_tipo, descricao from tipo_doc ";
	  $q = $q . "  order by  " . $ordem;
      //echo $q;
	  $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_num_rows($result);
      $colTipoDoc2 = new ColTipoDoc2();
      for ($i = 0 ; $i < $num_rows; $i++)
      { $row = mysqli_fetch_array($result);
        $TipoDoc = new TipoDoc();
        $TipoDoc->setCodigo($row['codigo_tipo']);
        $TipoDoc->setDescricao($row['descricao']);
        $colTipoDoc2->incluirRegistro($TipoDoc);
      }
      return $colTipoDoc2;
    }
    
  }
?>
