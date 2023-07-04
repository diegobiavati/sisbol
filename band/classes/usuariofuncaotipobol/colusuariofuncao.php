<?php
  class ColUsuarioFuncao implements ICOLUsuarioFuncao
  { private $db;
    public function ColUsuarioFuncao($db)
    { $this->db = $db;
    }
    public function incluirRegistro($usuario, $funcaoDoSistema)//alterado
    { $q = "insert into usuariofuncao (codigofuncao, login) values (" .
	    $funcaoDoSistema->getCodigo() . ",'" . $usuario->getLogin() . "')";
//	  echo $q;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
	  // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Incluído")
                                    </script>');
          //throw new Exception('COLUSUARIOFUNCAO->Registro não Incluido');
	  }
    }
    public function excluirRegistro($usuario, $funcaoDoSistema)
    { $q = "delete from usuariofuncao ";
	  $q = $q . " where  codigofuncao = " . $funcaoDoSistema->getCodigo() ;
	  $q = $q . " and  login = '" . $usuario->getLogin() . "'" ;
//	  echo $q;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_affected_rows($this->db);
      if ($num_rows <= 0)
      { 
	  // PARREIRA - 19-06-13
          throw new Exception('<script type="text/javascript"> 
					window.alert("Registro não Excluído")
                                    </script>');
          //throw new Exception('COLUSUARIOFUNCAO->Registro não excluído');
	  }
    }
    public function lerRegistro($login, $codigoFuncao)//alterado
    { $q = "select codigofuncao, login from usuariofuncao ";
	  $q = $q . " where  codigofuncao = " . $codigoFuncao ;
	  $q = $q . " and  login = '" . $login . "'" ;
	  echo $q;
      $result = mysqli_query($this->db, $q);
	  if (mysqli_num_rows($result) <= 0)
	  { return null;
	  }
	  else
	  { $row = mysqli_fetch_array($result);
	    $funcaoDoSistema = new FuncaoDoSistema();
        $funcaoDoSistema->setCodigo($row['codigofuncao']);
//      $funcaoDoSistema->setDescricao($row['descricao']);
        return $funcaoDoSistema;
	  }
    }
    public function lerColecaoAutorizada($login, $assocTipoBol)//alterado 01Ago2008 Watanabe
    { $q = "select usuariofuncao.codigofuncao, login, descricao, assoc_tipobol from usuariofuncao, funcoesdosistema ";
	  $q = $q . " where login = '" . $login . "'" ;
	  $q = $q . " and usuariofuncao.codigofuncao = funcoesdosistema.codigofuncao";
	  if (($assocTipoBol == 'S') or ($assocTipoBol == 'N'))
	  { $q = $q . " and assoc_tipobol = '" . $assocTipoBol . "'";
	  }
	  //echo $q;
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
    public function lerColecaoNaoAutorizada($login, $assocTipoBol)//alterado
    { $q = "select funcoesdosistema.codigofuncao, funcoesdosistema.descricao from funcoesdosistema ";
      $q = $q . " where funcoesdosistema.codigofuncao not in ";
      $q = $q . "(select codigofuncao from usuariofuncao ";
	  $q = $q . " where login = '" . $login . "')" ;
	  if (($assocTipoBol == 'S') or ($assocTipoBol == 'N'))
	  { $q = $q . " and assoc_tipobol = '" . $assocTipoBol . "'";
	  }
//      echo $q;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_num_rows($result);
      $colFuncaoDoSistema2 = new ColFuncaoDoSistema2();
      for ($i = 0 ; $i < $num_rows; $i++)
      { $row = mysqli_fetch_array($result);
	    $funcaoDoSistema = new FuncaoDoSistema();
        $funcaoDoSistema->setCodigo($row['codigofuncao']);
        $funcaoDoSistema->setDescricao($row['descricao']);
        $colFuncaoDoSistema2->incluirRegistro($funcaoDoSistema);
      }
      return $colFuncaoDoSistema2;
    }
	//renato
    public function lerColecaoAutorizadaPorFuncao($codFuncao, $assocTipoBol)//alterado
    { $q = "select usuariofuncao.codigofuncao, login, descricao from usuariofuncao, funcoesdosistema ";
	  $q = $q . " where usuariofuncao.codigofuncao = " . $codFuncao;
	  $q = $q . " and usuariofuncao.codigofuncao = funcoesdosistema.codigofuncao";
	  if (($assocTipoBol == 'S') or ($assocTipoBol == 'N'))
	  { $q = $q . " and assoc_tipobol = '" . $assocTipoBol . "' order by login";
	  }
//	  echo $q;
      $result = mysqli_query($this->db, $q);
      $num_rows = mysqli_num_rows($result);
      $colUsuario2 = new ColUsuario2();
      for ($i = 0 ; $i < $num_rows; $i++)
      { $row = mysqli_fetch_array($result);
	    $usuario = new Usuario(null);
        $usuario->setLogin($row['login']);
        $colUsuario2->incluirRegistro($usuario);
      }
      return $colUsuario2;
    }

  }
?>
