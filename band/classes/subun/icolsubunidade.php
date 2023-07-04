<?php
  interface IColSubunidade
  { public function incluirRegistro($omVinc, $subun);
    public function alterarRegistro($omVinc, $subun);
    public function excluirRegistro($omVinc, $subun);
    public function lerRegistro($codom, $codSubun);
    public function lerColecao($codom);
  }
?>
