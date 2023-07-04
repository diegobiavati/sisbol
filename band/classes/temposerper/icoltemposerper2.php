<?php
  interface  IColTempoSerPer2
  {
    public function ColTempoSerPer2();
    public function incluirRegistro($TempoSerPer);
    public function alterarRegistro($TempoSerPer);
    public function excluirRegistro($TempoSerPer);
    public function lerRegistro($codTempoSerPer);
	public function iniciaBusca1();
    public function getProximo1();
    public function getQTD();
  }
?>
