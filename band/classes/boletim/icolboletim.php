<?php
  interface IColboletim
  { public function incluirRegistro($boletim);
    public function alterarRegistro($boletim);
    public function excluirRegistro($boletim);
    public function lerPorBiTipo($codTipoBol, $codBiAtual);
    public function lerPorCodigo($cod);
    public function lerPorNumeroBi($codTipoBol, $numeroBi, $anoBi);
    public function lerColecao($aprovado, $assinado,$codTipoBol,$ordem,$ano=null);
    public function getQTD($codTipoBol);
    public function getAnosBI();
    public function lerUltBi($codTipoBol);

    //PARREIRA 10-06-2013 - valida encerrar ano
    public function valEncerraAno();
  }
?>
