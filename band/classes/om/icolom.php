<?php
  interface IColOM  
  {
    public function incluirRegistro($OM);
    public function alterarRegistro($OM);
 	public function excluirRegistro($OM);
    public function lerRegistro();
    public function lerColecao($ordem);
  }
?>
