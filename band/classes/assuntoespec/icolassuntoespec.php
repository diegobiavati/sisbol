<?php
  interface IColAssuntoEspec
  { public function incluirRegistro($assuntoGeral, $assuntoEspec);
    public function alterarRegistro($assuntoGeral, $assuntoEspec);
    public function excluirRegistro($assuntoGeral, $assuntoEspec);
    public function lerRegistro($codAssuntoGeral, $codAssuntoEspec);
    public function lerColecao($codAssuntoGeral);
    public function lerUltimoRegistro();
  }
?>
