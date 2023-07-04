<?php
  interface IColTipoBol
  { public function incluirRegistro($tipoBol);
    public function alterarRegistro($tipoBol);
    public function excluirRegistro($tipoBol);
    public function lerRegistro($codTipoBol);
    public function lerColecao($ordem);
  }
?>
