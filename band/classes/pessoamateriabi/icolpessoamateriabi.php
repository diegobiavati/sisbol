<?php
  interface IColPessoaMateriaBi
  { public function incluirRegistro($materiaBi, $pessoaMateriaBi);
    public function alterarRegistro($materiaBi, $pessoaMateriaBi);
    public function excluirRegistro($materiaBi, $PessoaMateriaBi);
    public function lerRegistro($codMateriaBi, $idMilitar);
    public function lerColecao($codMateriaBi);
    public function lerAlteracoes($idMilitar, $dtInicio, $dtTermino);
  }
?>
