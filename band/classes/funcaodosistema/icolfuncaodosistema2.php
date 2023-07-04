<?php
  interface IColFuncaoDoSistema2
  { public function incluirRegistro($funcaoDoSistema);
    public function alterarRegistro($funcaoDoSistema);
    public function excluirRegistro($funcaoDoSistema);
    public function lerRegistro($codigo);
    public function iniciaBusca1();
    public function getProximo1();    
  }
?>
