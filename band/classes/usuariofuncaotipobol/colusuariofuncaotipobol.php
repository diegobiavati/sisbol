<?php
  class ColUsuarioFuncaoTipoBol implements ICOLUsuarioFuncaoTipoBol
  { private $db;
    public function ColUsuarioFuncaoTipoBol($db)
    { $this->db = $db;
    }
    public function incluirRegistro($usuario, $funcaoDoSistema, $tipoBol)//alterado
    { $q = "insert into usuariofuncaotipobol(login, codigofuncao, cod_tipo_bol) values ('";
	  $q = $q . $usuario->getLogin() . "',";
	  $q = $q . $funcaoDoSistema->getCodigo()  . ",";
	  $q = $q . $tipoBol->getCodigo() . ")";
	  //echo $q;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { throw new Exception('COLFUNCAODOSISTEMA->Registro não Incluido');
	  }
    }
    public function excluirRegistro($usuario, $funcaoDoSistema, $tipoBol)
    { $q = "delete from usuariofuncaotipobol ";
	  $q = $q . " where  codigofuncao = " . $funcaoDoSistema->getCodigo() ;
	  $q = $q . " and    login = '" . $usuario->getLogin() . "'" ;
	  $q = $q . " and    cod_tipo_bol = " . $tipoBol->getCodigo();
//	  echo $q;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { throw new Exception('COLFUNCAODOSISTEMA->Registro não excluído');
	  }
    }
    public function lerRegistro($login, $codigoFuncao, $codTipoBol)//alterado
    { $q = "select codigofuncao, login, cod_tipo_bol from usuariofuncaotipobol ";
	  $q = $q . " where  codigofuncao = " . $codigoFuncao;
	  $q = $q . " and    login = '" . $login . "'";
	  $q = $q . " and    cod_tipo_bol = " . $codTipoBol;
//	  echo $q;
      $result = mysqli_query($this->db, $q);
	  if (mysqli_num_rows($result) <= 0)
	  { return null;
	  }
	  else
	  { $row = mysqli_fetch_array($result);
	    $usuario = new Usuario(null);
        $usuario->setLogin($row['login']);

	    $funcaoDoSistema = new FuncaoDoSistema();
        $funcaoDoSistema->setCodigo($row['codigofuncao']);
	    
	    $tipoBol = new TipoBol();
	    $tipoBol->setCodigo($row['cod_tipo_bol']);
	    
	    $usuarioFuncaoTipoBol = new UsuarioFuncaoTipoBol($usuario, $funcaoDoSistema, $tipoBol);
	    
        return $usuarioFuncaoTipoBol;
	  }
    }
    public function lerColecaoAutorizada($login, $codigoFuncao)//alterado
    { //retorna o conjunto de tipo de boletins em que o usuario pode realizar uma determinada operacao
	  $q =  "select cod_tipo_bol, descricao from usuariofuncaotipobol, tipo_bol ";
	  $q = $q . " where  codigofuncao = " . $codigoFuncao;
	  $q = $q . " and    login = '" . $login . "'" ;
	  $q = $q . " and usuariofuncaotipobol.cod_tipo_bol = tipo_bol.cod";
	  //echo $q;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_num_rows($result);
      $colTipoBol2 = new ColtipoBol2();
      for ($i = 0 ; $i < $num_rows; $i++)
      { $row = mysqli_fetch_array($result);
	    $tipoBol = new TipoBol();
	    $tipoBol->setCodigo($row['cod_tipo_bol']);
	    $tipoBol->setDescricao($row['descricao']);
	    
        $colTipoBol2->incluirRegistro($tipoBol);
      }
      return $colTipoBol2;
    }
    public function lerColecaoNaoAutorizada($login, $codigoFuncao)//alterado
    { //retorna o conjunto de tipo de boletins em que o usuario não pode realizar uma determinada operacao
	  $q =  "select cod, descricao from tipo_bol";
	  $q = $q . " where  cod not in (";
	  $q = $q . "select cod_tipo_bol from usuariofuncaotipobol";
	  $q = $q . " where codigofuncao = " . $codigoFuncao;
	  $q = $q . " and    login = '" . $login .  "')" ;
	  //echo $q;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_num_rows($result);
      $colTipoBol2 = new ColtipoBol2();
      for ($i = 0 ; $i < $num_rows; $i++)
      { $row = mysqli_fetch_array($result);
	    $tipoBol = new TipoBol();
	    $tipoBol->setCodigo($row['cod']);
	    $tipoBol->setDescricao($row['descricao']);
	    
        $colTipoBol2->incluirRegistro($tipoBol);
      }
      return $colTipoBol2;
    }
    
  }
?>
