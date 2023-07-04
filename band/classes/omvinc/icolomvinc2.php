<?php
  interface IColOMVinc2
  { public function incluirRegistro($OMVinc);
    public function alterarRegistro($OMVinc);
    public function excluirRegistro($OMVinc);
    public function lerRegistro($codOM);
  }
?>
