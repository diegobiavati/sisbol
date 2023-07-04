<?php
  class ColUsuario2 implements IColUsuario2
  {
    private $arrayUsuario;
    public function ColUsuario2()
    {
    }
    public function incluirRegistro($usuario)
    { $this->arrayUsuario[$usuario->getLogin()] = $usuario;
    }
    public function alterarRegistro($usuario)
    { $this->arrayUsuario[$usuario->getLogin()] = $usuario;
    }
    public function excluirRegistro($usuario)
    { $this->arrayUsuario[$usuario->getLogin()] = null;
    }
	public function LerRegistro($login)
	{ $resultado = null;
	  $usuario = $this->iniciaBusca1();
	  while ($usuario != null)
	  { if ($usuario->getLogin() == $login)
	    { $resultado = $usuario;
	      break;
	    }
	    $usuario = $this->getProximo1();
	  }
	  return $resultado;
	}
    public function iniciaBusca1()
    { //aponta para o primeiro elemento
      if (count($this->arrayUsuario) > 0)
      { return reset($this->arrayUsuario);
	  }
      else
      { return null;
      }
    }
    public function getProximo1()
    { return next($this->arrayUsuario);
    }
    public function getQTD()
    { return count($this->arrayUsuario);
	}    
  }
?>
