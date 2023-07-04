<?php
  interface IColUsuarioFuncaotipoBol
  { 
    public function incluirRegistro($usuario, $funcaoDoSistema, $tipoBol);
    public function excluirRegistro($usuario, $funcaoDoSistema, $tipoBol);
    public function lerRegistro($login, $codigoFuncao, $codTipoBol);
    public function lerColecaoAutorizada($login, $codigoFuncao);//alterado
    public function lerColecaoNaoAutorizada($login, $codigoFuncao);//alterado
  }
?>
