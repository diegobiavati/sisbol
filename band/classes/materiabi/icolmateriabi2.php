<?php
  interface IColMateriaBi2
  { public function incluirRegistro($materiaBi);
    public function alterarRegistro($materiaBi);
    public function excluirRegistro($materiaBi);
    public function lerRegistro($codMateriaBi);
    public function iniciaBusca1();
    public function getProximo1();    
  }
?>
