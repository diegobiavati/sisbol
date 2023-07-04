<?php
  interface IColTipoDoc
  { public function incluirRegistro($tipoDoc);
    public function alterarRegistro($tipoDoc);
    public function excluirRegistro($tipoDoc);
    public function lerRegistro($codDoc);
  }
?>
