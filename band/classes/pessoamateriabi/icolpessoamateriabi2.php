<?php
  interface IColPessoaMateriaBi2
  { public function incluirRegistro($pessoaMateriaBi);
    public function alterarRegistro($pessoaMateriaBi);
    public function excluirRegistro($pessoaMateriaBi);
    public function lerRegistro($idMilitar);
    public function iniciaBusca1();
    public function getProximo1();    
  }
?>
