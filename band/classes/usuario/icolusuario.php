<?php
  interface IColUsuario
  { public function incluirRegistro($usuario);
    public function alterarRegistro($usuario);
    public function excluirRegistro($usuario);
    public function lerRegistro($login);
    public function lerColecao();
  }
?>
