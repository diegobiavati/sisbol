<?php
  interface IColSecaoParteBi2
  { public function incluirRegistro($secaoParteBi);
    public function alterarRegistro($secaoParteBi);
    public function excluirRegistro($secaoParteBi);
    public function lerRegistro($numeroSecao);
  }
?>
