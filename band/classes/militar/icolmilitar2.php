<?php
  interface IColMilitar2
  { public function incluirRegistro($Militar);
    public function alterarRegistro($Militar);
    public function excluirRegistro($Militar);
    public function lerRegistro($idMilitar);
  }
?>
