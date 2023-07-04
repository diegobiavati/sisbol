<?php
  interface IColPGrad2
  { public function incluirRegistro($pGrad);
    public function alterarRegistro($pGrad);
    public function excluirRegistro($pGrad);
    public function lerRegistro($codPGrad);
  }
?>
