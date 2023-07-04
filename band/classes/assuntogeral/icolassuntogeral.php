<?php
  interface IColAssuntoGeral
  { public function incluirRegistro($assuntoGeral);
    public function alterarRegistro($assuntoGeral);
    public function excluirRegistro($assuntogeral);
    public function lerRegistro($codigo);
    public function lerUltimoRegistro();
    public function setaOrdem($codAssuntoGer, $ordemAssuntoGer);
    public function setaOrdemGeral($codAssuntoGeral, $ordemAssuntoGeral);
  }
?>
