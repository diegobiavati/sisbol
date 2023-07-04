<?php
  interface IColPGrad
  { public function incluirRegistro($pGrad);
    public function alterarRegistro($pGrad);
    public function excluirRegistro($pGrad);
    public function lerRegistro($codPGrad);
    public function lerColecao($ordem);
  }
?>
