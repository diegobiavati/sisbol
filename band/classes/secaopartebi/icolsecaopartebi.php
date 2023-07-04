<?php
  interface IColSecaoParteBi
  { public function incluirRegistro($parteBoletim, $secaoParteBi);
    public function alterarRegistro($parteBoletim, $secaoParteBi);
    public function excluirRegistro($parteBoletim, $secaoParteBi);
    public function lerRegistro($numeroParte, $numeroSecao);
    public function lerColecao($numeroParte);
  }
?>
