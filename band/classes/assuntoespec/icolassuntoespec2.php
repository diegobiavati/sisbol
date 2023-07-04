<?php
  interface IColAssuntoEspec2
  { public function incluirRegistro($assuntoEspec);
    public function alterarRegistro($assuntoEspec);
    public function excluirRegistro($assuntoEspec);
    public function lerRegistro($codAssuntoEspec);
    public function iniciaBusca1();
    public function getProximo1();    
  }
?>
