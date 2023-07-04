<?php
  interface IColUsuarioFuncao 
  { public function incluirRegistro($usuario, $funcaoDoSistema);
    public function excluirRegistro($usuario, $funcaoDoSistema);
    public function lerRegistro($login, $codigoFuncao);
    public function lerColecaoAutorizada($login, $assocTipoBol);
    public function lerColecaoNaoAutorizada($login, $assocTipoBol);
    public function lerColecaoAutorizadaPorFuncao($codFuncao, $assocTipoBol);
  }
?>
