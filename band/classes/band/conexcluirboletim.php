<?php
  class ConExcluirBoletim
  { //propriedades privadas
    private $rgrTipoBol;
    private $rgrBoletim;
    
    
    //construtor
    public function ConExcluirBoletim($rgrTipoBol, $rgrBoletim)
    {  $this->rgrTipoBol = $rgrTipoBol;
       $this->rgrBoletim = $rgrBoletim;
    }
    public function excluirBoletim($boletim)
    { 
	  //obter o nr BI Ant - rev 06
      $numeroBiAnt = $boletim->getNumeroBi() - 1;
      if ($numeroBiAnt > 0){
	      $bolAnt = $this->rgrBoletim->lerPorNumeroBi($boletim->getTipoBol()->getCodigo(),$numeroBiAnt,$boletim->getDataPub()->getIAno());
	      if ($bolAnt)
	   	      $ultPag = $bolAnt->getPagFinal();
	  }else{
   	      $ultPag = 0;
	  }

      //ler o tipo de boletim
      $tipoBol = $this->rgrTipoBol->lerRegistro($boletim->getTipoBol()->getCodigo());
      if ($tipoBol == null)
        throw new Exception('Tipo de Boletim não existe');
      //decrementa o numero do boletim
      $tipoBol->decNrUltBi();
	  //atualiza o nr ultPagBI - rv 06
	  if ($ultPag!=null)
	      $tipoBol->atualizNrUltPagBi($ultPag);
      //atualiza o tipo de boletim
      $this->rgrTipoBol->alterarRegistro($tipoBol);
      $this->rgrBoletim->excluirRegistro($boletim);
    
    }
  }
?>
