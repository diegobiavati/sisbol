<?php
  class ColOM implements IColOM
  { private $db;
    public function ColOM($db)
    { $this->db = $db;
    }
    public function incluirRegistro($OM)
    { $q = "insert into om (cod,codom,nome,sigla,desig_hist,loc,subd1,subd2,subd3,subd4,gu,
    			ano_corrente,data_atualiz)
			values (" .$OM->getCodigo() . ", '". $OM->getCodOM() ."',
			 	'". $OM->getNome() ."','". $OM->getSigla() ."',
			 	'".$OM->getDesigHist(). "','". $OM->getLoc() ."',
			 	'".$OM->getSubd1()."','". $OM->getSubd2() ."',
			 	'".$OM->getSubd3() . "', '". $OM->getSubd4() ."',
                                
			 	".$OM->getAnoCorrente().",";
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
          //throw new Exception('COLOM->Registro não Incluido');
	  }
    }
    public function alterarRegistro($OM)
    { $q = "update om set ";
      $q = $q . "codom = '".$OM->getCodOM() ."',";
      $q = $q . "nome = '".$OM->getNome() ."',";
	  $q = $q . "sigla = '". $OM->getSigla() ."',";
      $q = $q . "desig_hist = '".$OM->getDesigHist() . "',";
	  $q = $q . "loc = '".$OM->getLoc() ."',";
 	  $q = $q . "subd1 = '".$OM->getSubd1()."',";
	  $q = $q . "subd2 = '".$OM->getSubd2() ."',";
	  $q = $q . "subd3 = '".$OM->getSubd3() . "', ";
          $q = $q . "subd4 = '".$OM->getSubd4() . "', ";
          
	  $q = $q . "gu = '".$OM->getGu() ."',";
	  $q = $q . "data_atualiz = now(), ";
	  $q = $q . "ano_corrente = ".$OM->getAnoCorrente();
	  $q = $q . " where  cod = " . $OM->getCodigo();
	  //echo "<br><b>".$q."</b><br>";
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
          // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Alterado")
                                    </script>');
          //throw new Exception('COLOM->Registro não alterado');
	  }
    }
    public function excluirRegistro($OM)
    { $q = "delete from om ";
	  $q = $q . " where  cod = " . $OM->getCodigo();
	  //echo "<br><b>".$q."</b><br>";
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
          // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Excluído")
                                    </script>');
          //throw new Exception('COLOM->Registro não excluído');
	  }
    }
    public function lerRegistro()
    { $q = "select cod,codom,nome,sigla,desig_hist,loc,subd1,subd2,subd3,subd4,gu,
    			data_atualiz, ano_corrente from om";
	  //echo "<br><b>".$q."</b><br>";
      $result = mysqli_query($this->db, $q);
	  if (mysqli_num_rows($result) <= 0)
	  { return null;
	  }
	  else
	  { $OM = new OM();
        $row = mysqli_fetch_array($result);
        $OM->setCodigo($row['cod']);
        $OM->setCodOM($row['codom']);
		$OM->setNome($row['nome']);
		$OM->setSigla($row['sigla']);
		$OM->setDesigHist($row['desig_hist']);
		$OM->setLoc($row['loc']);
		$OM->setSubd1($row['subd1']);
		$OM->setSubd2($row['subd2']);
		$OM->setSubd3($row['subd3']);
                $OM->setSubd4($row['subd4']);
                
		$OM->setAnoCorrente($row['ano_corrente']);
		$OM->setGu($row['gu']);
        return $OM;

	  }
    }
    public function lerColecao($ordem)
    { $q = "select cod,codom,nome,sigla,desig_hist,loc,subd1,subd2,subd3,subd4,
    			gu,data_atualiz,ano_corrente from om";
	  $q = $q . "  order by  " . $ordem;
      //echo "<br><b>".$q."</b><br>";
	  $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_num_rows($result);
      $colOM2 = new ColOM2();
      for ($i = 0 ; $i < $num_rows; $i++)
      { $row = mysqli_fetch_array($result);
        $OM = new OM();
        $OM->setCodigo($row['cod']);
        $OM->setCodOM($row['codom']);
		$OM->setNome($row['nome']);
		$OM->setSigla($row['sigla']);
		$OM->setDesigHist($row['desig_hist']);
		$OM->setLoc($row['loc']);
		$OM->setSubd1($row['subd1']);
		$OM->setSubd2($row['subd2']);
		$OM->setSubd3($row['subd3']);
                $OM->setSubd4($row['subd4']);
		$OM->setAnoCorrente($row['ano_corrente']);
		$OM->setGu($row['gu']);
        $colOM2->incluirRegistro($OM);
      }
      return $colOM2;
    }
  }
?>
