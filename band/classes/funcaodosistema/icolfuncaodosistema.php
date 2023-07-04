<?php
  interface IColFuncaoDoSistema
  { public function incluirRegistro($funcaoDoSistema);
    public function alterarRegistro($funcaoDoSistema);
    public function excluirRegistro($funcaoDoSistema);
    public function lerColecao();
  }
?>
