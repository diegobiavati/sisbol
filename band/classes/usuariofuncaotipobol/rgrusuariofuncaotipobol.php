<?php
  class RgrUsuarioFuncaoTipoBol
  { private $colUsuarioFuncaoTipoBol;
    public function RgrUsuarioFuncaoTipoBol($colUsuarioFuncaoTipoBol)
    { $this->colUsuarioFuncaoTipoBol = $colUsuarioFuncaoTipoBol;
    }
    public function incluirRegistro($usuario, $funcaoDoSistema, $tipoBol)
    { $this->colUsuarioFuncaoTipoBol->incluirRegistro($usuario, $funcaoDoSistema, $tipoBol);
    }
    public function excluirRegistro($usuario, $funcaoDoSistema, $tipoBol)
    { $this->colUsuarioFuncaoTipoBol->excluirRegistro($usuario, $funcaoDoSistema, $tipoBol);
    }
    public function lerRegistro($login, $codigoFuncao, $codTipoBol)
    { return $this->colUsuarioFuncaoTipoBol->lerRegistro($login, $codigoFuncao, $codTipoBol);
    }
    public function lerColecaoAutorizada($login, $codigoFuncao)
    { return $this->colUsuarioFuncaoTipoBol->lerColecaoAutorizada($login, $codigoFuncao);
    }
    public function lerColecaoNaoAutorizada($login, $codigoFuncao)
    { return $this->colUsuarioFuncaoTipoBol->lerColecaoNaoAutorizada($login, $codigoFuncao);
    }
  }
?>
