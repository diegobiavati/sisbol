<?php
  interface IColQM2
  { public function incluirRegistro($pQM);
    public function alterarRegistro($pQM);
    public function excluirRegistro($pQM);
    public function lerRegistro($codQM);
  }
?>
