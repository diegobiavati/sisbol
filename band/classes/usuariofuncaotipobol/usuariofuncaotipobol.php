<?php
  class UsuarioFuncaoTipoBol
  { //propriedades privadas
    private $usuario;
    private $funcaoDoSistema;
    private $tipoBol;
    public function UsuarioFuncaoTipoBol($usuario, $funcaoDoSistema, $tipoBol)
    { $this->usuario = $usuario;
      $this->funcaoDoSistema = $funcaoDoSistema;
      $this->tipoBol = $tipoBol;
    }
    //funcoes de acesso-get
    public function getUsuario()
    { return $this->usuario;
    }
    public function getFuncaoDoSistema()
    { return $this->funcaoDoSistema;
    }
    public function getTipoBol()
    { return $this->getTipoBol;
    }
    //funcoes de acesso set
    public function setUsuario($valor)
    { $this->usuario = $valor;
    }
    public function setFuncaoDoSistema($valor)
    { $this->funcaoDoSistema = $valor;
    }
    public function setTipoBol($valor)
    { $this->tipoBol = $valor;
    }
  }
?>
