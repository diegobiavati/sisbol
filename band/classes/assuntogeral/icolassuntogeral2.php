<?php
  interface IColAssuntoGeral2
  { public function incluirRegistro($assuntoGeral);
    public function alterarRegistro($assuntoGeral);
    public function excluirRegistro($assuntoGeral);
    public function lerRegistro($codAssuntoGeral);
  }
?>
