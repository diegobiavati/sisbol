<?php
  interface IColFuncao
  { public function incluirRegistro($Funcao);
    public function alterarRegistro($Funcao);
    public function excluirRegistro($Funcao);
    public function lerRegistro($codFuncao);
    public function lerFuncaoQueAssinaBi();
    public function lerFuncaoQueConfere();
  }
?>
