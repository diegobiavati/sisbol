<?php
  interface IColIndicePessoa2
  { public function incluirRegistro($indicePessoa);
    public function alterarRegistro($indicePessoa);
    public function excluirRegistro($indicePessoa);
    public function lerRegistro($indicePessoa);
    public function iniciaBusca1();
    public function getProximo1();    
  }
?>
