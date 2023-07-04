<?php
  interface IColUsuario2
  { public function incluirRegistro($usuario);
    public function alterarRegistro($usuario);
    public function excluirRegistro($usuario);
    public function lerRegistro($login);
    public function iniciaBusca1();
    public function getProximo1();    
  }
?>
