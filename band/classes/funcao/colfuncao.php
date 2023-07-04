<?php
  class ColFuncao implements IColFuncao 
  { private $db;
    public function ColFuncao($db)
    { $this->db = $db;
    }
    public function incluirRegistro($Funcao)
    { $q = "insert into funcao (descricao,assina_bi, assina_confere,assina_alt,assina_nota,assina_publiquese) values ('". $Funcao->getDescricao();
	  $q = $q .  "','". $Funcao->getAssinaBI() . "','" . $Funcao->getAssinaConfere();
	  $q = $q . "','". $Funcao->getAssinaAlt();
	  $q = $q . "','". $Funcao->getAssinaNota();
	  $q = $q . "','". $Funcao->getAssinaPubliquese()."')";
//	  echo $q;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
	  // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Incluído")
                                    </script>');
          //throw new Exception('COLFUNCAO->Registro não Incluido');
	  }
    }
    public function alterarRegistro($Funcao)
    { $q = "update funcao set ";
      $q = $q . "descricao = '" . $Funcao->getDescricao() . "',";
      $q = $q . "assina_bi = '" . $Funcao->getAssinaBI() . "',";
      $q = $q . "assina_confere = '" . $Funcao->getAssinaConfere() . "',";
      $q = $q . "assina_alt = '" . $Funcao->getAssinaAlt() . "',";
      $q = $q . "assina_nota = '" . $Funcao->getAssinaNota() . "',";
      $q = $q . "assina_publiquese = '" . $Funcao->getAssinaPubliquese() . "',";
	  $q = $q . "data_atualiz = now()" ;
	  $q = $q . " where  cod = " . $Funcao->getCod();
//	  echo "<br><b>".$q."</b><br>";
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
	  // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Alterado")
                                    </script>');
          //throw new Exception('COLFUNCAO->Registro não alterado');
	  }
    }
    public function excluirRegistro($Funcao)
    { $q = "delete from funcao ";
	  $q = $q . " where cod = " . $Funcao->getCod();
//	  echo "<br><b>".$q."</b><br>";
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
	  // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Excluído")
                                    </script>');
          //throw new Exception('COLFUNCAO->Registro não excluído');
	  }
    }
    public function lerRegistro($codFuncao)
    { $q = "select cod, descricao, assina_bi, assina_confere, assina_alt, assina_nota, assina_publiquese, data_atualiz from funcao ";
	  $q = $q . "  where  cod = " . $codFuncao;
//  echo "<br><b>".$q."</b><br>";
      $result = mysqli_query($this->db, $q);
	  if (mysqli_num_rows($result) <= 0)
	  { return null;
	  }
	  else
	  { $Funcao = new Funcao();
	    $row = mysqli_fetch_array($result);
        $Funcao->setCod($row['cod']);
        $Funcao->setDescricao($row['descricao']);
        $Funcao->setAssinaBI($row['assina_bi']);
        $Funcao->setAssinaConfere($row['assina_confere']);
        $Funcao->setAssinaAlt($row['assina_alt']);
        $Funcao->setAssinaNota($row['assina_nota']);
        $Funcao->setAssinaPubliquese($row['assina_publiquese']);
        $Funcao->setDataAtualiz($row['data_atualiz']);
        return $Funcao;
	  }
    }
    public function lerFuncaoQueAssinaBi()
    { $q = "select cod, descricao, assina_bi, assina_confere, assina_alt, assina_nota, assina_publiquese, data_atualiz from funcao ";
	  $q = $q . "  where  assina_bi= 'S'";
      $result = mysqli_query($this->db, $q);
	  if (mysqli_num_rows($result) <= 0)
	  { return null;
	  }
	  else
	  { $Funcao = new Funcao();
	    $row = mysqli_fetch_array($result);
        $Funcao->setCod($row['cod']);
        $Funcao->setDescricao($row['descricao']);
        $Funcao->setAssinaBI($row['assina_bi']);
        $Funcao->setAssinaConfere($row['assina_confere']);
        $Funcao->setAssinaAlt($row['assina_alt']);
        $Funcao->setAssinaNota($row['assina_nota']);
        $Funcao->setAssinaPubliquese($row['assina_publiquese']);
        $Funcao->setDataAtualiz($row['data_atualiz']);
        return $Funcao;
	  }
    }
    public function lerFuncaoQueConfere()
    { $q = "select cod, descricao, assina_bi, assina_confere, assina_alt, assina_nota, assina_publiquese, data_atualiz from funcao ";
	  $q = $q . "  where  assina_confere = 'S'";
      $result = mysqli_query($this->db, $q);
	  if (mysqli_num_rows($result) <= 0)
	  { return null;
	  }
	  else
	  { $Funcao = new Funcao();
	    $row = mysqli_fetch_array($result);
        $Funcao->setCod($row['cod']);
        $Funcao->setDescricao($row['descricao']);
        $Funcao->setAssinaBI($row['assina_bi']);
        $Funcao->setAssinaConfere($row['assina_confere']);
        $Funcao->setAssinaAlt($row['assina_alt']);
        $Funcao->setAssinaNota($row['assina_nota']);
        $Funcao->setAssinaPubliquese($row['assina_publiquese']);
        $Funcao->setDataAtualiz($row['data_atualiz']);
        return $Funcao;
	  }
    }
    public function lerColecao($ordem)
    { $q = "select cod, descricao, assina_bi, assina_confere, assina_alt, assina_nota, assina_publiquese, data_atualiz from funcao ";
	  $q = $q . "  order by  " . $ordem;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_num_rows($result);
      $colFuncao2 = new ColFuncao2();
      for ($i = 0 ; $i < $num_rows; $i++)
      { $row = mysqli_fetch_array($result);
        $Funcao = new Funcao();
        $Funcao->setCod($row['cod']);
        $Funcao->setDescricao($row['descricao']);
        $Funcao->setAssinaBI($row['assina_bi']);
        $Funcao->setAssinaConfere($row['assina_confere']);
        $Funcao->setAssinaAlt($row['assina_alt']);
        $Funcao->setAssinaNota($row['assina_nota']);
        $Funcao->setAssinaPubliquese($row['assina_publiquese']);
        $Funcao->setDataAtualiz($row['data_atualiz']);
        $colFuncao2->incluirRegistro($Funcao);
      }
      return $colFuncao2;
    }

    public function lerFuncaoQueAssinaPubliquese()
    { $q = "select cod, descricao, assina_bi, assina_confere, assina_alt, assina_nota, assina_publiquese, data_atualiz from funcao ";
	  $q = $q . "  where  assina_publiquese = 'S'";
      $result = mysqli_query($this->db, $q);
	  if (mysqli_num_rows($result) <= 0)
	  { return null;
	  }
	  else
	  { $Funcao = new Funcao();
	    $row = mysqli_fetch_array($result);
        $Funcao->setCod($row['cod']);
        $Funcao->setDescricao($row['descricao']);
        $Funcao->setAssinaBI($row['assina_bi']);
        $Funcao->setAssinaConfere($row['assina_confere']);
        $Funcao->setAssinaAlt($row['assina_alt']);
        $Funcao->setAssinaNota($row['assina_nota']);
        $Funcao->setAssinaPubliquese($row['assina_publiquese']);
        $Funcao->setDataAtualiz($row['data_atualiz']);
        return $Funcao;
	  }
    }


  }
  
  
?>
