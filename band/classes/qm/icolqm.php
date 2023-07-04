<?php
  interface IColQM
  { public function incluirRegistro($pQM);
    public function alterarRegistro($pQM);
    public function excluirRegistro($pQM);
    public function lerRegistro($codQM);
    public function lerColecao($ordem);
  }
?>
