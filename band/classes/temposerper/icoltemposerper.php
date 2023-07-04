<?php
interface ICOLTempoSerPer
  {
    public function incluirRegistro($TempoSerPer);
    public function alterarRegistro($TempoSerPer);
    
    public function excluirRegistro($TempoSerPer);
    
    public function lerRegistro($dataIn, $dataFim, $idMilitar);
    
    public function lerColecao($filtro,$ordem); 
    
    public function getQTD();
    
  }
?>
