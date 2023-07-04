<?php
  interface IColPessoa  
  {
    public function incluirRegistro($Pessoa);
    public function alterarRegistro($Pessoa);
 	public function excluirRegistro($Pessoa);
    public function lerRegistro($idMilitar);
    public function ativaPessoa($idMilitar);
    public function desativaPessoa($idMilitar);
    //public function lerColecao($ordem);
  }
?>
