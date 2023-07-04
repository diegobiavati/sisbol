<?php
  class ColUsuario implements ICOLUsuario
  { private $db;
    public function ColUsuario($db)
    { $this->db = $db;
    }
    public function incluirRegistro($usuario)//alterado
    { $q = "insert into usuarios (login, senha, codom, cod_subun, todas_omvinc, todas_subun, todas_omvinc2, todas_subun2, modifica_modelo) values ('" .
	    $usuario->getLogin() . "','" . $usuario->getSenha() . "','" . $usuario->getCodom() . "'," . 
            $usuario->getCodSubun() . ",'" . $usuario->getTodasOmVinc() . "','" . $usuario->getTodasSubun() . "','" .
            $usuario->getTodasOmVinc2() . "','" . $usuario->getTodasSubun2() . "','" .
            $usuario->getModificaModelo() . "')";
	  //echo $q;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
	  // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Incluído")
                                    </script>');
          //throw new Exception('COLUSUARIO->Registro não Incluido');
	  }
    }
    public function alterarRegistro($usuario)//alterado
    { $q = "update usuarios set senha = '" . $usuario->getSenha() . "'," .
			  	" codom = '" . $usuario->getCodom() . "'," .
			  	" cod_subun = " . $usuario->getCodSubun() . "," .
			  	" todas_omvinc = '" . $usuario->getTodasOmVinc() . "'," .
			  	" todas_subun = '" . $usuario->getTodasSubun() . "'," .
			  	" todas_omvinc2 = '" . $usuario->getTodasOmVinc2() . "'," .
			  	" todas_subun2 = '" . $usuario->getTodasSubun2() . "'," .
			  	" modifica_modelo = '" . $usuario->getModificaModelo() . "'," .
	  $q = $q . "data_atualiz = now()" ;
	  $q = $q . " where login = '" . $usuario->getLogin() . "'";
      //echo $q;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
	  // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Alterado")
                                    </script>');
          //throw new Exception('COLUSUARIO->Registro não alterado');
	  }
    }
    public function excluirRegistro($usuario)
    { 
	//Inserido para remover funções do usuário antes de remover o usuário - Sgt Bedin 13/05/2013
	  $q = "delete from usuariofuncao ";
	  $q = $q . " where  login = '" .$usuario->getLogin() . "'";
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
	  // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Funções não Excluídas")
                                    </script>');
          //throw new Exception('COLUSUARIO->Funções não excluídas');
	  }
	  $q = "delete from usuarios ";
	  $q = $q . " where  login = '" .$usuario->getLogin() . "'";
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
	  // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Excluído")
                                    </script>');
          //throw new Exception('COLUSUARIO->Registro não excluído');
	  }
    }
    public function lerRegistro($login)//alterado
    { $q = "select login, senha, codom, cod_subun, todas_omvinc, todas_subun, todas_omvinc2, todas_subun2, modifica_modelo from usuarios ";
	  $q = $q . " where  login = '" . $login . "'";
	  //echo $q;
      $result = mysqli_query($this->db, $q);
	  if (mysqli_num_rows($result) <= 0)
	  { return null;
	  }
	  else
	  { $row = mysqli_fetch_array($result);
        //$dtExpira = new MinhaData($row['dt_expira']);
	    $usuario = new Usuario(null);
        $usuario->setLogin($row['login']);
        $usuario->setSenha($row['senha']);
        $usuario->setCodom($row['codom']);
        $usuario->setCodSubun($row['cod_subun']);
        $usuario->setTodasOmVinc($row['todas_omvinc']);
        $usuario->setTodasSubun($row['todas_subun']);
        $usuario->setTodasOmVinc2($row['todas_omvinc2']);
        $usuario->setTodasSubun2($row['todas_subun2']);
        $usuario->setModificaModelo($row['modifica_modelo']);
        return $usuario;
	  }
    }
    public function lerColecao()//alterado
    { $q = "select  login, senha, codom, cod_subun, todas_omvinc, todas_subun, todas_omvinc2, todas_subun2, modifica_modelo from usuarios ";
	  $q = $q . " order by login";
//	  echo $q;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_num_rows($result);
      $colUsuario2 = new ColUsuario2();
      for ($i = 0 ; $i < $num_rows; $i++)
      { $row = mysqli_fetch_array($result);
        //$dtExpira = new MinhaData($row['dt_expira']);
	    $usuario = new Usuario(null);
        $usuario->setLogin($row['login']);
        $usuario->setSenha($row['senha']);
        $usuario->setCodom($row['codom']);
        $usuario->setCodSubun($row['cod_subun']);
        $usuario->setTodasOmVinc($row['todas_omvinc']);
        $usuario->setTodasSubun($row['todas_subun']);
        $usuario->setTodasOmVinc2($row['todas_omvinc2']);
        $usuario->setTodasSubun2($row['todas_subun2']);
        $usuario->setModificaModelo($row['modifica_modelo']);
        $colUsuario2->incluirRegistro($usuario);
      }
      return $colUsuario2;
    }
    
  }
?>
