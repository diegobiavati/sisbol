<?php
  interface IColMilitar  
  {
    public function incluirRegistro($Militar);
    public function alterarRegistro($Militar);
 	public function excluirRegistro($Militar);
    public function lerRegistro($idMilitar);
    public function lerColecao($ordem,$filtro);
    public function lerMilitarQueExerceFuncao($codFuncao);
    public function lerColMilAssAlteracoes($filtro);
  }
?>
