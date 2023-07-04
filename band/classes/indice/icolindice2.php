<?php
  interface IColIndice2
  { public function incluirRegistro($indice);
    public function alterarRegistro($indice);
    public function excluirRegistro($indice);
    public function lerRegistro($indice);
    public function iniciaBusca1();
    public function getProximo1();    
  }
?>
