<?php
  interface IColOMVinc  
  {
    public function incluirRegistro($OMVinc);
    public function alterarRegistro($OMVinc);
 	public function excluirRegistro($OMVinc);
    public function lerRegistro($codOM);
    public function lerColecao($ordem);
  }
?>
