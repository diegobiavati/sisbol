<?php
  interface IColAssinaConfereBi
  { public function incluirRegistro($assinaConfereBi);
    public function lerRegistro($codMilitarAssina, $codPGradMilitarAssina, $codFuncaoMilitarAssina, $codMilitarConfere, 
	  $codPGradMilitarConfere, $codFuncaoMilitarConfere);
    public function getProximoCodigo();
    public function lerPorCodigo($codigo);
  }
?>
