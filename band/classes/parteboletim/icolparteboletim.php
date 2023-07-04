<?php
  interface IColParteBoletim
  { public function incluirRegistro($parteBoletim);
    public function alterarRegistro($parteBoletim);
    public function excluirRegistro($parteBoletim);
    public function lerRegistro($numeroParte);
    public function lerParteQuePertenceAssuntoEspec($codAssuntoGeral,$codAssuntoEspec);
  }
?>
