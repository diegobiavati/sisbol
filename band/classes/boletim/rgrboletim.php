<?php
  class RgrBoletim
  { private $colBoletim;
    public function RgrBoletim($colBoletim)
    { $this->colBoletim = $colBoletim;
    }
    private function consisteDados($boletim, $oper)
    {
	  if (!is_numeric($boletim->getNumeroBi()))
      { throw new Exception('RGRBOLETIM->número BI= ' . $boletim->getNumeroBi() .  ' inválido');
      }
      if ($boletim->getPagInicial() < 0)
      { throw new Exception('RGRBOLETIM->página inicial inválida');
      }
      if ($boletim->getPagFinal() < 0)
      { throw new Exception('RGRBOLETIM->página final inválida');
      }
      if ($boletim->getPagFinal() < $boletim->getPagInicial())
      { throw new Exception('RGRBOLETIM->números de página inválidos, pag. Inicial = '. $boletim->getPagInicial() .
	      ' Pag Final ' . $boletim->getPagFinal());
      }
      if (($boletim->getAssinado() != 'S') and ($boletim->getAssinado() != 'N'))
      { throw new Exception('RGRBOLETIM->campo assinado inválido');
      }
      if (($boletim->getAprovado() != 'S') and ($boletim->getAprovado() != 'N'))
      { throw new Exception('RGRBOLETIM->Campo assinado inválido');
      }
      if (($boletim->getAssinado() == 'S') and ($boletim->getAprovado() == 'N') and ($_SESSION['APROVBOLETIM']=='S'))
      { throw new Exception('RGRBOLETIM->boletim foi assinado sem ter sido aprovado');
      }
//    $this->consisteBiAnt($boletim, $oper);
    }
    public function incluirRegistro($boletim)
    { $this->consisteDados($boletim, 'I');
	  //alterado para não incluir um BI que já exista - rv 06
	  $lBoletim = $this->colBoletim->lerPorNumeroBi($boletim->getTipoBol()->getCodigo(), $boletim->getNumeroBi(), $boletim->getDataPub()->getIAno());
      if ($lBoletim != null)
      { throw new Exception('RGRBOLETIM->Boletim já existente!');
      }
	  $this->colBoletim->incluirRegistro($boletim);
    }
    public function alterarRegistro($boletim)
    { $this->consisteDados($boletim, 'A');
	  $this->colBoletim->alterarRegistro($boletim);
    }
    public function excluirRegistro($boletim)
//    { $lBoletim = $this->colBoletim->lerPorNumeroBi($boletim->getTipoBol()->getCodigo(), $boletim->getNumeroBi()+1, $boletim->getDataPub()->GetcDataYYYYHMMHDD());
    { $lBoletim = $this->colBoletim->lerPorNumeroBi($boletim->getTipoBol()->getCodigo(), $boletim->getNumeroBi()+1, $boletim->getDataPub()->getIAno());
      if ($lBoletim != null)
      { throw new Exception('RGRBOLETIM->boletim não pode ser excluído porque já existe um subsequente');
      }
	  if (($boletim->getAssinado() == 'S') or ($boletim->getAprovado() == 'S'))
      { throw new Exception('RGRBOLETIM->boletim foi assinado ou aprovado não pode ser excluído');
      }

	  $this->colBoletim->excluirRegistro($boletim);
    }
    public function aprovarBoletim($boletim)
    {
	  $boletim = $this->lerPorCodigo($boletim->getCodigo());
      if ($boletim == null)
      { throw new Exception('Boletim não Existe');
      }
      if ($boletim->getAssinado() == 'S')
      { throw new Exception('Boletim já foi assinado');
      }
      if ($boletim->getAprovado() == 'S')
      { throw new Exception('Boletim já foi aprovado');
      }
      $boletim->setAprovado('S');
      $this->alterarRegistro($boletim);
    }
    public function cancelarAprovarBoletim($boletim)
    {
	  $boletim = $this->lerPorCodigo($boletim->getCodigo());
      if ($boletim == null)
      { throw new Exception('Boletim não Existe');
      }
      if ($boletim->getAssinado() == 'S')
      { throw new Exception('Boletim já foi assinado');
      }
      if ($boletim->getAprovado() != 'S')
      { throw new Exception('Boletim não foi aprovado');
      }
      $boletim->setAprovado('N');
      $this->alterarRegistro($boletim);
    }
    public function assinarBoletim($boletim)
    {
	  $boletim = $this->lerPorCodigo($boletim->getCodigo());
      if ($boletim == null)
      { throw new Exception('Boletim não Existe');
      }
      if ($boletim->getAssinado() == 'S')
      { throw new Exception('Boletim já foi assinado');
      }
      if (($boletim->getAprovado() != 'S') and ($_SESSION['APROVBOLETIM']=='S'))
      { throw new Exception('Boletim não foi aprovado');
      }
      $boletim->setAssinado('S');
      $this->alterarRegistro($boletim);
    }
    public function cancelarAssinarBoletim($boletim)
    {
	  $boletim = $this->lerPorCodigo($boletim->getCodigo());
      if ($boletim == null)
      { throw new Exception('Boletim não Existe');
      }
      if ($boletim->getAssinado() != 'S')
      { throw new Exception('Boletim não foi assinado');
      }
      $boletim->setAssinado('N');
      $this->alterarRegistro($boletim);
    }
    public function lerPorCodigo($cod)
    { return $this->colBoletim->lerPorCodigo($cod);
    }
    public function lerPorNumeroBi($codTipoBol, $numeroBi, $anoBi)
//    { return $this->colBoletim->lerPorNumeroBi($codTipoBol, $numeroBi);
    { return $this->colBoletim->lerPorNumeroBi($codTipoBol, $numeroBi, $anoBi);
    }
    public function lerPorBiTipo($codTipoBol,$codBiAtual)
//    { return $this->colBoletim->lerPorNumeroBi($codTipoBol, $numeroBi);
    { return $this->colBoletim->lerPorBiTipo($codTipoBol,$codBiAtual);
    }
    public function lerColecao($aprovado, $assinado,$codTipoBol,$ordem,$ano)
    { return $this->colBoletim->lerColecao($aprovado, $assinado,$codTipoBol,$ordem,$ano);
	}
	public function lerColecaoSemPrimeiro($aprovado, $assinado,$codTipoBol,$ordem,$ano)
    { return $this->colBoletim->lerColecaoSemPrimeiro($aprovado, $assinado,$codTipoBol,$ordem,$ano);
	}
    public function getQTD($codTipoBol)
    { return $this->colBoletim->getQTD($codTipoBol);
    }
    public function getAnosBI(){
    	 return $this->colBoletim->getAnosBI();
    }
    public function lerUltBi($codTipoBol)
    {
    	return $this->colBoletim->lerUltBi($codTipoBol);
    }
    //PARREIRA 07-06-2013 - Valida encerrar ano
    public function valEncerraAno()
    {
        return $this->colBoletim->valEncerraAno();
    	
    }
//
  }
?>
