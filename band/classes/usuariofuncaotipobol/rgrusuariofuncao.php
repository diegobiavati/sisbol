<?php
  class RgrUsuarioFuncao 
  { private $colUsuarioFuncao;
    public function RgrUsuarioFuncao($colUsuarioFuncao)
    { $this->colUsuarioFuncao = $colUsuarioFuncao;
    }
  	private function consisteDados($usuario, $funcaoDoSistema, $oper)
    { 
    }
    public function incluirRegistro($usuario, $funcaoDoSistema)
    { $this->consisteDados($usuario, $funcaoDoSistema, 'I');
      $this->colUsuarioFuncao->incluirRegistro($usuario, $funcaoDoSistema);
    }
    public function excluirRegistro($usuario, $funcaoDoSistema)
    { $this->consisteDados($usuario, $funcaoDoSistema, 'A');
      $this->colUsuarioFuncao->excluirRegistro($usuario, $funcaoDoSistema);
    }
    public function lerRegistro($login, $codigoFuncao)
    { return $this->colUsuarioFuncao->lerRegistro($login, $codigoFuncao);
    }
    public function lerColecaoAutorizada($login, $assocTipoBol)
    { return $this->colUsuarioFuncao->lerColecaoAutorizada($login, $assocTipoBol);
    }
	//renato
    public function lerColecaoAutorizadaPorFuncao($codFuncao, $assocTipoBol)
    { return $this->colUsuarioFuncao->lerColecaoAutorizadaPorFuncao($codFuncao, $assocTipoBol);
    }
    public function lerColecaoNaoAutorizada($login, $assocTipoBol)
    { return $this->colUsuarioFuncao->lerColecaoNaoAutorizada($login, $assocTipoBol);
    }
  }
?>
