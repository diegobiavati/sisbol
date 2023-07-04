<?php
  interface IColOM2
  { public function incluirRegistro($OM);
    public function alterarRegistro($OM);
    public function excluirRegistro($OM);
    public function lerRegistro($codOM);
  }
?>
