<?php
  class ColQM implements IColQM 
  { private $db;
    public function ColQM($db)
    { $this->db = $db;
    }
    public function incluirRegistro($pQM)
	//bedin
    { $q = "insert into qm (cod, descricao, abreviacao, data_atualiz) values ('". $pQM->getCod() ."', '". $pQM->getDescricao() ."', '". $pQM->getAbreviacao() .
	    "',";
	  $q = $q . "now())" ;     
      /*$result = mysql_query($q,$this->db);
      $num_rows = mysql_affected_rows();*/
      //echo "<br><b>".$q."</b><br>";
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
	  // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Incluído")
                                    </script>');
          //throw new Exception('COLQM->Registro não Incluido');
	  }
    }
    public function alterarRegistro($pQM)
    { $q = "update qm set ";
      $q = $q ."cod = '". $pQM->getCod() .  "',";
      $q = $q . "descricao = '" . $pQM->getDescricao() . "',";
	  //bedin
	  $q = $q . "abreviacao = '" . $pQM->getAbreviacao() . "',";
	  $q = $q . "data_atualiz = now()" ;
	  $q = $q . " where  cod = '" . $pQM->getCod()."'";
	  //echo "<br><b>".$q."</b><br>";
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
     // echo "Foi alterado .$num_rows. registros!";
      if ($num_rows <= 0)
      { 
	  // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Alterado")
                                    </script>');
          //throw new Exception('COLQM->Registro não alterado');
	  }
    }
    public function excluirRegistro($pQM)
    { $q = "delete from qm ";
	  $q = $q . " where  cod = '" . $pQM->getCod()."'";
	  //echo "<br><b>".$q."</b><br>";
      $result = mysqli_query($this->db, $q);
      
      $num_rows = mysqli_affected_rows($this->db);
      //echo $num_rows;
      if ($num_rows <= 0)
      { 
	  // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Excluído")
                                    </script>');
          //throw new Exception('COLQM->Registro não excluído');
	  }
    }
    public function lerRegistro($codQM)
	//bedin
    { $q = "select cod, descricao, data_atualiz, abreviacao from qm ";
	  $q = $q . "  where  cod = '" . $codQM . "'";
	 // echo "<br><b>".$q."</b><br>";
      $result = mysqli_query($this->db, $q);
	  if (mysqli_num_rows($result) <= 0)
	  { return null;
	  }
	  else
	  { $pQM = new QM();
      
        $row = mysqli_fetch_array($result);
        $pQM->setCod($row['cod']);
        $pQM->setDescricao($row['descricao']);
		//bedin
		$pQM->setAbreviacao($row['abreviacao']);
        return $pQM;
	  
	  }
    }
    public function lerColecao($ordem)
    { $q = "select cod, descricao, abreviacao from qm ";
	  $q = $q . "  order by  " . $ordem;
      $result = mysqli_query($this->db, $q);
	  $num_rows = mysqli_num_rows($result);
      $colQM2 = new ColQM2();
      for ($i = 0 ; $i < $num_rows; $i++)
      { $row = mysqli_fetch_array($result);
        $pQM = new QM();
        $pQM->setCod($row['cod']);
        $pQM->SetDescricao($row['descricao']);
		//bedin
		$pQM->setAbreviacao($row['abreviacao']);
        $colQM2->incluirRegistro($pQM);
      }
      return $colQM2;
    }
  }
?>
