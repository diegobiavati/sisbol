<?php
  interface IColBoletim2
  { public function incluirRegistro($boletim);
    public function alterarRegistro($boletim);
    public function excluirRegistro($boletim);
    public function lerPorCodigo($codigo);
  }
?>
