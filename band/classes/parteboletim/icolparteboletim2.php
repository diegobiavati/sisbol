<?php
  interface IColParteBoletim2
  { public function incluirRegistro($ParteBoletim);
    public function alterarRegistro($ParteBoletim);
    public function excluirRegistro($ParteBoletim);
    public function lerRegistro($codParteBoletim);
  }
?>
