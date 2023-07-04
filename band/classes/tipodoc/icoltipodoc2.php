<?php
  interface IColTipoDoc2
  { public function incluirRegistro($TipoDoc);
    public function alterarRegistro($TipoDoc);
    public function excluirRegistro($TipoDoc);
    public function lerRegistro($codTipoDoc);
  }
?>
